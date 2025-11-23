<?php

namespace App\Livewire;

use App\Services\CarritoService;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class CarritoUsuario extends Component
{
    public $id;
    public $carrito = [];
    protected CarritoService $carritoService;

    public function boot(CarritoService $carritoService)
    {
        $this->carritoService = $carritoService;
    }

    public function mount()
    {
        $this->id = 3;
        $this->cargarCarrito();
    }

    public function cargarCarrito()
    {
        $this->carrito = $this->carritoService->obtenerCarrito($this->id) ?? [];
    }

    public function agregarAlCarrito(int $idProducto, int $cantidad)
    {
        if ($this->carritoService->agregar($this->id, $idProducto, $cantidad)) {
            Session::flash('mensaje', 'Agregado correctamente');
        }
    }

        public function eliminarAlCarrito(int $idProducto, int $cantidad)
    {
        if ($this->carritoService->eliminar($this->id, $idProducto, $cantidad)) {
            Session::flash('mensaje', 'Eliminado correctamente');
        }
    }

    public function quitarDelCarrito(int $idProducto)
    {
        if ($this->carritoService->quitar($this->id, $idProducto)) {
            Session::flash('mensaje', 'Producto borrado correctamente');
        }
    }

    #[On('echo-private:usuario.{id},ActualizarCarrito')]
    public function carritoActualizado()
    {
        $this->cargarCarrito();
    }

    public function render()
    {
        return view('livewire.carrito-usuario');
    }
}
