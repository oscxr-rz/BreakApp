<?php

namespace App\Livewire\Admin;

use App\Services\Admin\OrdenesService;
use App\Services\Admin\ProductosService;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CapturarOrden extends Component
{
    public $productos = [];
    public $productosSeleccionados = [];
    public $total = 0;

    protected OrdenesService $ordenesService;
    protected ProductosService $productosService;

    protected $rules = [
        'productosSeleccionados' => 'required|array|min:1',
        'productosSeleccionados.*.cantidad' => 'required|integer|min:1',
    ];

    protected $messages = [
        'productosSeleccionados.required' => 'Debes seleccionar al menos un producto',
        'productosSeleccionados.min' => 'Debes seleccionar al menos un producto',
        'productosSeleccionados.*.cantidad.required' => 'La cantidad es requerida',
        'productosSeleccionados.*.cantidad.min' => 'La cantidad debe ser al menos 1',
    ];

    public function boot(OrdenesService $ordenesService, ProductosService $productosService)
    {
        $this->ordenesService = $ordenesService;
        $this->productosService = $productosService;
    }

    public function mount()
    {
        $this->cargarProductos();
    }

    public function cargarProductos()
    {
        $productosRaw = $this->productosService->obtenerProductos() ?? [];
        $productosAplanados = [];

        foreach ($productosRaw as $categoria => $items) {
            if (is_array($items)) {
                foreach ($items as $producto) {
                    if (isset($producto['activo']) && $producto['activo'] == 1) {
                        if (!isset($producto['categoria']) || is_string($producto['categoria'])) {
                            $producto['categoria'] = $categoria;
                        }
                        $productosAplanados[] = $producto;
                    }
                }
            }
        }

        $this->productos = $productosAplanados;
    }

    public function toggleProducto($idProducto)
    {
        if (isset($this->productosSeleccionados[$idProducto])) {
            unset($this->productosSeleccionados[$idProducto]);
        } else {
            $producto = collect($this->productos)->firstWhere('id_producto', $idProducto);

            if ($producto) {
                $this->productosSeleccionados[$idProducto] = [
                    'id_producto' => $producto['id_producto'],
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
    }

    public function capturarOrden()
    {
        try {
            if (empty($this->productosSeleccionados)) {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Debes seleccionar al menos un producto');
                return;
            }

            $productosParaEnviar = collect($this->productosSeleccionados)
                ->map(function ($item) {
                    return [
                        'id_producto' => (int) $item['id_producto'],
                        'cantidad' => (int) $item['cantidad'],
                        'precio_unitario' => (float) $item['precio_unitario'],
                        'notas' => $item['notas'] ?? null,
                    ];
                })
                ->values()
                ->toArray();

            if ($this->ordenesService->capturarOrden($productosParaEnviar)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Orden capturada correctamente');
                $this->limpiarSeleccion();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo capturar la orden');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al capturar la orden');
        }
    }

    public function limpiarSeleccion()
    {
        $this->productosSeleccionados = [];
        $this->total = 0;
    }

    public function render()
    {
        if (empty($this->productos)) {
            return view('livewire.admin.capturar-orden', [
                'productosAgrupados' => []
            ]);
        }

        $productosPorCategoria = [];

        foreach ($this->productos as $producto) {
            $categoria = $producto['categoria'] ?? 'Sin categoría';

            if (is_array($categoria)) {
                $categoria = $categoria['nombre'] ?? 'Sin categoría';
            }

            if (!isset($productosPorCategoria[$categoria])) {
                $productosPorCategoria[$categoria] = [];
            }

            $productosPorCategoria[$categoria][] = $producto;
        }

        return view('livewire.admin.capturar-orden', [
            'productosAgrupados' => $productosPorCategoria
        ]);
    }
}
