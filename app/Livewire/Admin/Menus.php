<?php

namespace App\Livewire\Admin;

use App\Services\Admin\MenusService;
use App\Services\Admin\ProductosService;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use Exception;

class Menus extends Component
{
    public $menus = [];
    protected MenusService $menusService;
    protected ProductosService $productosService;

    public $crear_fecha = '';
    public $crear_productos = [];

    public $editar_idMenu = null;
    public $editar_fecha = '';
    public $editar_productos = [];

    public $modalCrearAbierto = false;
    public $modalEditarAbierto = false;

    public function boot(MenusService $menusService, ProductosService $productosService)
    {
        $this->menusService = $menusService;
        $this->productosService = $productosService;
    }

    public function mount()
    {
        $this->cargarMenus();
    }

    public function cargarMenus()
    {
        $this->menus = $this->menusService->obtenerMenus() ?? [];
    }

    public function abrirModalCrear()
    {
        $this->reset(['crear_fecha', 'crear_productos']);
        $this->resetErrorBag();
        $this->modalCrearAbierto = true;
    }

    public function cerrarModalCrear()
    {
        $this->modalCrearAbierto = false;
        $this->reset(['crear_fecha', 'crear_productos']);
        $this->resetErrorBag();
    }

    public function abrirModalEditar($idMenu, $fecha, $productos)
    {
        $this->editar_idMenu = $idMenu;
        $this->editar_fecha = $fecha;
        $this->editar_productos = $productos;
        $this->resetErrorBag();
        $this->modalEditarAbierto = true;
    }

    public function cerrarModalEditar()
    {
        $this->modalEditarAbierto = false;
        $this->reset(['editar_idMenu', 'editar_fecha', 'editar_productos']);
        $this->resetErrorBag();
    }

    public function crearMenu()
    {
        try {
            $this->validate([
                'crear_fecha' => 'required|date|after_or_equal:today',
                'crear_productos' => 'required|array|min:1',
                'crear_productos.*.id_producto' => 'required|integer|min:1',
                'crear_productos.*.cantidad_disponible' => 'required|integer|min:0',
            ], [
                'crear_fecha.required' => 'La fecha es obligatoria',
                'crear_fecha.date' => 'Debe ser una fecha válida',
                'crear_fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy',
                'crear_productos.required' => 'Debe seleccionar al menos un producto',
                'crear_productos.min' => 'Debe haber mínimo un producto',
                'crear_productos.*.cantidad_disponible.required' => 'La cantidad disponible es obligatoria',
                'crear_productos.*.cantidad_disponible.integer' => 'La cantidad debe ser un número',
                'crear_productos.*.cantidad_disponible.min' => 'La cantidad no puede ser negativa',
            ]);

            if ($this->menusService->crear($this->crear_fecha, $this->crear_productos)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Menú creado correctamente');
                $this->cerrarModalCrear();
                $this->cargarMenus();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo crear el menú');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al crear el menú');
        }
    }

    public function actualizarMenu()
    {
        try {
            $this->validate([
                'editar_fecha' => 'required|date|after_or_equal:today',
                'editar_productos' => 'required|array|min:1',
                'editar_productos.*.id_producto' => 'required|integer|min:1',
                'editar_productos.*.cantidad_disponible' => 'required|integer|min:0',
            ], [
                'editar_fecha.required' => 'La fecha es obligatoria',
                'editar_fecha.date' => 'Debe ser una fecha válida',
                'editar_fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy',
                'editar_productos.required' => 'Debe seleccionar al menos un producto',
                'editar_productos.min' => 'Debe haber mínimo un producto',
                'editar_productos.*.cantidad_disponible.required' => 'La cantidad disponible es obligatoria',
                'editar_productos.*.cantidad_disponible.integer' => 'La cantidad debe ser un número',
                'editar_productos.*.cantidad_disponible.min' => 'La cantidad no puede ser negativa',
            ]);

            if ($this->menusService->actualizar($this->editar_idMenu, $this->editar_fecha, $this->editar_productos)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Menú actualizado correctamente');
                $this->cerrarModalEditar();
                $this->cargarMenus();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar el menú');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar el menú');
        }
    }

    public function render()
    {
        $productos = $this->productosService->obtenerProductos() ?? [];
        $productosActivos = collect($productos)->flatten(1)->where('activo', 1)->values()->toArray();

        return view('livewire.admin.menus');
    }
}
