<?php

namespace App\Livewire\Admin;

use App\Services\admin\ProductosService;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class Productos extends Component
{
    public $productos = [];
    protected ProductosService $productosService;

    public function boot(ProductosService $productosService)
    {
        $this->productosService = $productosService;
    }
    public function mount()
    {
        $this->cargarProductos();
    }

    public function cargarProductos()
    {
        $this->productos = $this->productosService->obtenerProductos() ?? [];
    }

    public function cambiarEstado(int $idProducto, int $activo)
    {
        try {
            if ($this->productosService->cambiarEstado($idProducto, $activo)) {
                Session::flash('mensaje', 'Producto actualizado correctamente');
            } else {
                $this->addError('error', 'No se pudo actualizar el producto');
            }
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrió un error al cambiar el estado del producto');
        }
    }

    public function render()
    {
        return view('livewire.admin.productos');
    }
}
