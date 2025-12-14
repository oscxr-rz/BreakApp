<?php

namespace App\Livewire\Admin;

use App\Services\Admin\OrdenesService;
use Exception;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class RegistrarCompra extends Component
{
    public $menu = [];
    public $productosSeleccionados = [];
    public $total = 0;
    public $nombreCliente = '';
    public $montoPagado = 0;
    public $cambio = 0;

    protected OrdenesService $ordenesService;

    protected $rules = [
        'nombreCliente' => 'required|string|min:2|max:100',
        'montoPagado' => 'required|numeric|min:0',
        'productosSeleccionados' => 'required|array|min:1',
        'productosSeleccionados.*.cantidad' => 'required|integer|min:1',
    ];

    protected $messages = [
        'nombreCliente.required' => 'El nombre del cliente es requerido',
        'nombreCliente.min' => 'El nombre debe tener al menos 2 caracteres',
        'montoPagado.required' => 'El monto pagado es requerido',
        'montoPagado.min' => 'El monto debe ser mayor a 0',
        'productosSeleccionados.required' => 'Debes seleccionar al menos un producto',
        'productosSeleccionados.min' => 'Debes seleccionar al menos un producto',
        'productosSeleccionados.*.cantidad.required' => 'La cantidad es requerida',
        'productosSeleccionados.*.cantidad.min' => 'La cantidad debe ser al menos 1',
    ];

    public function boot(OrdenesService $ordenesService)
    {
        $this->ordenesService = $ordenesService;
    }

    public function mount()
    {
        $this->cargarMenu();
    }

    public function cargarMenu()
    {
        $response = Http::get(env('API_HOST') . '/menu');

        if ($response->successful()) {
            $this->menu = $response->json('data.0') ?? [];
        }
    }

    public function toggleProducto($idProducto, $categoria)
    {
        if (isset($this->productosSeleccionados[$idProducto])) {
            unset($this->productosSeleccionados[$idProducto]);
        } else {
            $producto = null;
            if (isset($this->menu['productos'][$categoria])) {
                foreach ($this->menu['productos'][$categoria] as $prod) {
                    if ($prod['id_producto'] == $idProducto) {
                        $producto = $prod;
                        break;
                    }
                }
            }

            if ($producto) {
                $this->productosSeleccionados[$idProducto] = [
                    'id_producto' => $producto['id_producto'],
                    'id_menu' => $this->menu['id_menu'] ?? null,
                    'nombre' => $producto['nombre'],
                    'cantidad' => 1,
                    'precio_unitario' => $producto['precio'] ?? 0,
                    'notas' => null,
                ];
            }
        }

        $this->calcularTotal();
    }

    public function incrementarCantidad($idProducto)
    {
        if (isset($this->productosSeleccionados[$idProducto])) {
            $this->productosSeleccionados[$idProducto]['cantidad']++;
            $this->calcularTotal();
        }
    }

    public function decrementarCantidad($idProducto)
    {
        if (isset($this->productosSeleccionados[$idProducto])) {
            if ($this->productosSeleccionados[$idProducto]['cantidad'] > 1) {
                $this->productosSeleccionados[$idProducto]['cantidad']--;
                $this->calcularTotal();
            } else {
                unset($this->productosSeleccionados[$idProducto]);
                $this->calcularTotal();
            }
        }
    }

    public function quitarProducto($idProducto)
    {
        if (isset($this->productosSeleccionados[$idProducto])) {
            unset($this->productosSeleccionados[$idProducto]);
            $this->calcularTotal();
            $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Producto eliminado');
        }
    }

    public function calcularTotal()
    {
        $this->total = collect($this->productosSeleccionados)->sum(function ($item) {
            return ($item['precio_unitario'] ?? 0) * ($item['cantidad'] ?? 0);
        });
        
        $this->calcularCambio();
    }

    public function updatedMontoPagado()
    {
        $this->calcularCambio();
    }

    public function calcularCambio()
    {
        $monto = (float) $this->montoPagado;
        $this->cambio = $monto - $this->total;
    }

    public function registrarCompra()
    {
        try {
            $this->validate();

            if ($this->montoPagado < $this->total) {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'El monto pagado es insuficiente');
                return;
            }

            $idMenu = collect($this->productosSeleccionados)
                ->pluck('id_menu')
                ->unique()
                ->count() === 1
                ? collect($this->productosSeleccionados)->first()['id_menu']
                : null;

            $productosParaEnviar = collect($this->productosSeleccionados)
                ->map(function ($item) {
                    return [
                        'id_producto' => (int) $item['id_producto'],
                        'id_menu' => (int) $item['id_menu'],
                        'cantidad' => (int) $item['cantidad'],
                        'precio_unitario' => (float) $item['precio_unitario'],
                        'notas' => $item['notas'] ?? null,
                    ];
                })
                ->values()
                ->toArray();

            if ($this->ordenesService->registrarCompra($this->nombreCliente, $idMenu, $productosParaEnviar)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Compra registrada correctamente');
                $this->limpiarFormulario();
                $this->cargarMenu();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo registrar la compra');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al registrar la compra');
        }
    }

    public function limpiarFormulario()
    {
        $this->productosSeleccionados = [];
        $this->total = 0;
        $this->nombreCliente = '';
        $this->montoPagado = 0;
        $this->cambio = 0;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.registrar-compra', [
            'productosAgrupados' => $this->menu['productos'] ?? []
        ]);
    }
}