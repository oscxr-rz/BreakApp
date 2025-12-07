<?php

namespace App\Livewire;

use App\Services\CarritoService;
use App\Services\TarjetaLocalService;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

use function Pest\Laravel\session;

class CarritoUsuario extends Component
{
    public int $id;
    public $carrito = [];
    protected CarritoService $carritoService;
    protected TarjetaLocalService $tajetaLocalService;

    public $total = 0;
    public $saldoLocal = 0;

    public $metodo_pago = 'EFECTIVO';
    public $hora_recogida = '';

    public function boot(CarritoService $carritoService, TarjetaLocalService $tarjetaLocalService)
    {
        $this->carritoService = $carritoService;
        $this->tajetaLocalService = $tarjetaLocalService;
    }

    public function mount()
    {
        $this->id = Session::get('id');
        $this->cargarCarrito();
    }

    public function cargarCarrito()
    {
        $this->carrito = $this->carritoService->obtenerCarrito($this->id) ?? [];

        $this->total = number_format(
            collect($this->carrito['productos'])->flatten(1)->where('activoAhora', 1)->sum(function ($producto) {
                return $producto['precio_unitario'] * $producto['cantidad'];
            }),
            2,
        );

        $this->saldoLocal = $this->tajetaLocalService->obtenerSaldo($this->id) ?? 0;
    }

    public function agregarAlCarrito(int $idProducto, int $cantidad)
    {
        try {
            if ($this->carritoService->agregar($this->id, $idProducto, $cantidad)) {
                Session::flash('mensaje', 'Producto gregado correctamente');
            } else {
                $this->addError('error', 'No se pudo agregar el producto al carrito');
            }
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrió un error al momento de agregar el producto al carrito');
        }
    }

    public function eliminarAlCarrito(int $idProducto, int $cantidad)
    {
        try {
            if ($this->carritoService->eliminar($this->id, $idProducto, $cantidad)) {
                Session::flash('mensaje', 'Producto eliminado correctamente');
            } else {
                $this->addError('error', 'No se pudo eliminar el producto del carrito');
            }
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrió un error al momento de eliminar el producto carrito');
        }
    }

    public function quitarDelCarrito(int $idProducto)
    {
        try {
            if ($this->carritoService->quitar($this->id, $idProducto)) {
                Session::flash('mensaje', 'Producto borrado del carrito correctamente');
            } else {
                $this->addError('error', 'No se pudo borrar el producto del carrito');
            }
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrió un error al momento de borrar el producto carrito');
        }
    }

    protected $rules = [
        'metodo_pago' => 'required|string|in:EFECTIVO,SALDO,TARJETA',
        'hora_recogida' => 'required|date_format:H:i',
    ];

    protected $messages = [
        'metodo_pago.required' => 'Debes seleccionar un método de pago',
        'hora_recogida.required' => 'Debes seleccionar una hora para recoger tus productos',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function comprarCarrito()
    {
        try {
            $this->validate();

            $productos = collect($this->carrito['productos'] ?? [])
                ->flatten(1)
                ->where('activoAhora', 1)
                ->where('disponible', true)
                ->values()
                ->toArray();

            if (empty($productos)) {
                $this->addError('productos', 'No hay productos en el carrito');
                return;
            }

            if ($this->carritoService->comprar($this->id, $this->metodo_pago, $this->hora_recogida, $productos)) {
                Session::flash('mensaje', 'Orden generada correctamente');
            } else {
                $this->addError('error', 'No se pudo procesar la orden');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrió un error al procesar tu compra');
        }
    }

    public function render()
    {
        return view('livewire.carrito-usuario');
    }
}
