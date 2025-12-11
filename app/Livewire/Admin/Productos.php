<?php

namespace App\Livewire\Admin;

use App\Services\admin\CategoriasService;
use App\Services\admin\ProductosService;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Productos extends Component
{
    use WithFileUploads;
    public $productos = [];
    public $categorias = [];
    protected ProductosService $productosService;
    protected CategoriasService $categoriasService;

    public $crear_idCategoria;
    public $crear_nombre = '';
    public $crear_descripcion = '';
    public $crear_precio = '';
    public $crear_tiempoPreparacion = '';
    public $crear_imagen;
    public $crear_activo = '';

    public $editar_idProducto = null;
    public $editar_idCategoria;
    public $editar_nombre = '';
    public $editar_descripcion = '';
    public $editar_precio = '';
    public $editar_tiempoPreparacion = '';
    public $editar_imagen;
    public $editar_activo = '';

    public $modalCrearAbierto = false;
    public $modalEditarAbierto = false;

    public function boot(ProductosService $productosService, CategoriasService $categoriasService)
    {
        $this->productosService = $productosService;
        $this->categoriasService = $categoriasService;
    }
    public function mount()
    {
        $this->cargarProductos();
    }

    public function cargarProductos()
    {
        $this->productos = $this->productosService->obtenerProductos() ?? [];

        $categorias = $this->categoriasService->obtenerCategorias() ?? [];
        $this->categorias = collect($categorias)->where('activo', 1)->toArray();
    }

    public function abrirModalCrear()
    {
        $this->reset(['crear_idCategoria', 'crear_nombre', 'crear_descripcion', 'crear_precio', 'crear_tiempoPreparacion', 'crear_activo']);
        $this->resetErrorBag();
        $this->modalCrearAbierto = true;
    }

    public function cerrarModalCrear()
    {
        $this->modalCrearAbierto = false;
        $this->reset(['crear_idCategoria', 'crear_nombre', 'crear_descripcion', 'crear_precio', 'crear_tiempoPreparacion', 'crear_activo']);
        $this->resetErrorBag();
    }

    public function abrirModalEditar($idProducto, $idCategoria, $nombre, $descripcion, $precio, $tiempoPreparacion)
    {
        $this->editar_idProducto = $idProducto;
        $this->editar_idCategoria = $idCategoria;
        $this->editar_nombre = $nombre;
        $this->editar_descripcion = $descripcion;
        $this->editar_precio = $precio;
        $this->editar_tiempoPreparacion = $tiempoPreparacion;
        $this->resetErrorBag();
        $this->modalEditarAbierto = true;
    }


    public function cerrarModalEditar()
    {
        $this->modalEditarAbierto = false;
        $this->reset(['editar_idProducto', 'editar_idCategoria', 'editar_nombre', 'editar_descripcion', 'editar_precio', 'editar_tiempoPreparacion']);
        $this->resetErrorBag();
    }

    public function crearProducto()
    {
        try {
            $this->validate([
                'crear_idCategoria' => 'required|integer|min:1',
                'crear_nombre' => 'required|string',
                'crear_descripcion' => 'required|string',
                'crear_precio' => 'required|numeric|min:0',
                'crear_tiempoPreparacion' => 'required|integer|min:0',
                'crear_imagen' => 'required|image|mimes:jpg,png|max:4096',
                'crear_activo' => 'required|in:0,1'
            ], [
                'crear_idCategoria.required' => 'El producto debe pertenecer a una categoria',
                'crear_nombre.required' => 'El nombre es obligatorio',
                'crear_descripcion.required' => 'La descripción es obligatoria',
                'crear_precio.required' => 'Debe tener un precio',
                'crear_precio.min' => 'El precio debe no puede ser menor a 0.00',
                'crear_tiempoPreparacion.required' => 'Debe tener tiempo de preparación',
                'crear_tiempoPreparacion.numeric' => 'El tiempo de preparación debe de estar en minutos',
                'crear_tiempoPreparacion.min' => 'El tiempo de preparación puede ser menor que 0 minutos',
                'crear_imagen.required' => 'Se necesita una imagen del producto',
                'crear_imagen.image' => 'El archivo tiene que ser una imagen',
                'crear_imagen.min' => 'El archivo tiene que ser menor a 4mb',
                'crear_activo.required' => 'Debe seleccionar un estado',
                'crear_activo.in' => 'El estado debe ser Activa o Inactiva',
            ]);

            if ($this->productosService->crear($this->crear_idCategoria, $this->crear_nombre, $this->crear_descripcion, $this->crear_precio, $this->crear_tiempoPreparacion, $this->crear_imagen, $this->crear_activo)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Producto creado correctamente');
                $this->cerrarModalCrear();
                $this->cargarProductos();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo crear el producto');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al crear el producto');
        }
    }

    public function actualizarProducto()
    {
        try {
            $this->validate([
                'editar_idCategoria' => 'required|integer|min:1',
                'editar_nombre' => 'required|string',
                'editar_descripcion' => 'required|string',
                'editar_precio' => 'required|numeric|min:0',
                'editar_tiempoPreparacion' => 'required|integer|min:0',
                'editar_imagen' => 'nullable|image|mimes:jpg,png|max:4096',
            ], [
                'editar_idCategoria.required' => 'El producto debe pertenecer a una categoria',
                'editar_nombre.required' => 'El nombre es obligatorio',
                'editar_descripcion.required' => 'La descripción es obligatoria',
                'editar_precio.required' => 'Debe tener un precio',
                'editar_precio.min' => 'El precio debe no puede ser menor a 0.00',
                'editar_tiempoPreparacion.required' => 'Debe tener tiempo de preparación',
                'editar_tiempoPreparacion.numeric' => 'El tiempo de preparación debe de estar en minutos',
                'editar_tiempoPreparacion.min' => 'El tiempo de preparación puede ser menor que 0 minutos',
                'editar_imagen.image' => 'El archivo tiene que ser una imagen',
                'editar_imagen.min' => 'El archivo tiene que ser menor a 4mb',
            ]);

            if ($this->productosService->actualizar($this->editar_idProducto, $this->editar_idCategoria, $this->editar_nombre, $this->editar_descripcion, $this->editar_precio, $this->editar_tiempoPreparacion, $this->editar_imagen)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Producto actualizado correctamente');
                $this->cerrarModalEditar();
                $this->cargarProductos();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar el producto');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar el producto');
        }
    }

    public function cambiarEstado(int $idProducto, int $activo)
    {
        try {
            if ($this->productosService->cambiarEstado($idProducto, $activo)) {
                $mensaje = $activo == 1 ? 'Producto activado correctamente' : 'Producto desactivado correctamente';
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: $mensaje);
                $this->cargarProductos();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar el producto');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar el producto');
        }
    }

    public function render()
    {
        return view('livewire.admin.productos');
    }
}
