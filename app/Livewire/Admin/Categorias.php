<?php

namespace App\Livewire\Admin;

use App\Services\admin\CategoriasService;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Categorias extends Component
{
    public $categorias = [];
    protected CategoriasService $categoriasService;
    public $crear_nombre = '';
    public $crear_descripcion = '';
    public $crear_activo = '';

    public $editar_id = null;
    public $editar_nombre = '';
    public $editar_descripcion = '';

    public $modalCrearAbierto = false;
    public $modalEditarAbierto = false;

    public function boot(CategoriasService $categoriasService)
    {
        $this->categoriasService = $categoriasService;
    }

    public function mount()
    {
        $this->cargarCategorias();
    }

    public function cargarCategorias()
    {
        $this->categorias = $this->categoriasService->obtenerCategorias() ?? [];
    }

    public function abrirModalCrear()
    {
        $this->reset(['crear_nombre', 'crear_descripcion', 'crear_activo']);
        $this->resetErrorBag();
        $this->modalCrearAbierto = true;
    }

    public function cerrarModalCrear()
    {
        $this->modalCrearAbierto = false;
        $this->reset(['crear_nombre', 'crear_descripcion', 'crear_activo']);
        $this->resetErrorBag();
    }

    public function abrirModalEditar($id, $nombre, $descripcion)
    {
        $this->editar_id = $id;
        $this->editar_nombre = $nombre;
        $this->editar_descripcion = $descripcion;
        $this->resetErrorBag();
        $this->modalEditarAbierto = true;
    }


    public function cerrarModalEditar()
    {
        $this->modalEditarAbierto = false;
        $this->reset(['editar_id', 'editar_nombre', 'editar_descripcion']);
        $this->resetErrorBag();
    }

    public function crearCategoria()
    {
        try {
            $this->validate([
                'crear_nombre' => 'required|string|min:3|max:100',
                'crear_descripcion' => 'required|string|min:5|max:255',
                'crear_activo' => 'required|in:0,1'
            ], [
                'crear_nombre.required' => 'El nombre es obligatorio',
                'crear_nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'crear_nombre.max' => 'El nombre no puede exceder 100 caracteres',
                'crear_descripcion.required' => 'La descripción es obligatoria',
                'crear_descripcion.min' => 'La descripción debe tener al menos 5 caracteres',
                'crear_descripcion.max' => 'La descripción no puede exceder 255 caracteres',
                'crear_activo.required' => 'Debe seleccionar un estado',
                'crear_activo.in' => 'El estado debe ser Activa o Inactiva',
            ]);

            if ($this->categoriasService->crear($this->crear_nombre, $this->crear_descripcion, $this->crear_activo)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Categoría creada correctamente');
                $this->cerrarModalCrear();
                $this->cargarCategorias();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo crear la categoría');
                $this->cerrarModalCrear();
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al crear la categoría');
            $this->cerrarModalCrear();
        }
    }

    public function actualizarCategoria()
    {
        try {
            $this->validate([
                'editar_nombre' => 'required|string|min:3|max:100',
                'editar_descripcion' => 'required|string|min:5|max:255'
            ], [
                'editar_nombre.required' => 'El nombre es obligatorio',
                'editar_nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'editar_nombre.max' => 'El nombre no puede exceder 100 caracteres',
                'editar_descripcion.required' => 'La descripción es obligatoria',
                'editar_descripcion.min' => 'La descripción debe tener al menos 5 caracteres',
                'editar_descripcion.max' => 'La descripción no puede exceder 255 caracteres',
            ]);

            if ($this->categoriasService->actualizar($this->editar_id, $this->editar_nombre, $this->editar_descripcion)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Categoría actualizada correctamente');
                $this->cerrarModalEditar();
                $this->cargarCategorias();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar la categoría');
                $this->cerrarModalEditar();
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar la categoría');
            $this->cerrarModalEditar();
        }
    }

    public function cambiarEstado(int $idCategoria, int $activo)
    {
        try {
            if ($this->categoriasService->cambiarEstado($idCategoria, $activo)) {
                $mensaje = $activo == 1 ? 'Categoría activada correctamente' : 'Categoría desactivada correctamente';
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: $mensaje);
                $this->cargarCategorias();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar la categoría');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar la categoría');
        }
    }

    public function render()
    {
        return view('livewire.admin.categorias');
    }
}
