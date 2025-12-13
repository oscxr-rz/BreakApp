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
    public $productos = [];

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
        $this->cargarProductos();
        $this->cargarMenus();
    }

    public function cargarMenus()
    {
        $this->menus = $this->menusService->obtenerMenus() ?? [];
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

    public function abrirModalCrear()
    {
        $this->cargarProductos();
        $this->reset(['crear_fecha', 'crear_productos']);
        $this->resetErrorBag();

        $this->crear_productos = [];
        foreach ($this->productos as $producto) {
            if (isset($producto['id_producto'])) {
                $this->crear_productos[$producto['id_producto']] = [
                    'seleccionado' => false,
                    'cantidad_disponible' => 10
                ];
            }
        }

        $this->crear_fecha = now()->format('Y-m-d');
        $this->modalCrearAbierto = true;
    }

    public function cerrarModalCrear()
    {
        $this->modalCrearAbierto = false;
        $this->reset(['crear_fecha', 'crear_productos']);
        $this->resetErrorBag();
    }

    public function abrirModalEditar($idMenu)
    {
        $this->cargarProductos();
        $this->resetErrorBag();

        $menu = collect($this->menus)->firstWhere('id_menu', $idMenu);

        if (!$menu) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Menú no encontrado');
            return;
        }

        $this->editar_idMenu = $idMenu;
        $this->editar_fecha = $menu['fecha'];

        $productosDelMenu = [];
        if (isset($menu['productos']) && is_array($menu['productos'])) {
            foreach ($menu['productos'] as $categoria => $items) {
                if (is_array($items)) {
                    foreach ($items as $item) {
                        if (isset($item['id_producto'])) {
                            $productosDelMenu[$item['id_producto']] = $item;
                        }
                    }
                }
            }
        }

        $this->editar_productos = [];
        foreach ($this->productos as $producto) {
            if (!isset($producto['id_producto'])) {
                continue;
            }

            $idProducto = $producto['id_producto'];

            if (isset($productosDelMenu[$idProducto])) {
                $this->editar_productos[$idProducto] = [
                    'seleccionado' => true,
                    'cantidad_disponible' => $productosDelMenu[$idProducto]['cantidad_disponible'] ?? 10
                ];
            } else {
                $this->editar_productos[$idProducto] = [
                    'seleccionado' => false,
                    'cantidad_disponible' => 10
                ];
            }
        }

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
            ], [
                'crear_fecha.required' => 'La fecha es obligatoria',
                'crear_fecha.date' => 'Debe ser una fecha válida',
                'crear_fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy',
            ]);

            $menuExistente = collect($this->menus)->firstWhere('fecha', $this->crear_fecha);

            if ($menuExistente) {
                $this->addError('crear_fecha', 'Ya existe un menú con esa fecha');
                return;
            }

            $productosSeleccionados = collect($this->crear_productos)
                ->filter(fn($prod) => !empty($prod['seleccionado']))
                ->map(function ($prod, $idProducto) {
                    return [
                        'id_producto' => $idProducto,
                        'cantidad_disponible' => (int)($prod['cantidad_disponible'] ?? 10)
                    ];
                })
                ->values()
                ->toArray();

            if (empty($productosSeleccionados)) {
                $this->addError('crear_productos', 'Debe seleccionar al menos un producto');
                return;
            }

            foreach ($productosSeleccionados as $producto) {
                if ($producto['cantidad_disponible'] < 0) {
                    $this->addError('crear_productos', 'Las cantidades no pueden ser negativas');
                    return;
                }
            }

            if ($this->menusService->crear($this->crear_fecha, $productosSeleccionados)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Menú creado correctamente');
                $this->cerrarModalCrear();
                $this->cargarMenus();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo crear el menú');
                $this->cerrarModalCrear();
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al crear el menú');
            $this->cerrarModalCrear();
        }
    }

    public function actualizarMenu()
    {
        try {
            $this->validate([
                'editar_fecha' => 'required|date|after_or_equal:today',
            ], [
                'editar_fecha.required' => 'La fecha es obligatoria',
                'editar_fecha.date' => 'Debe ser una fecha válida',
                'editar_fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy',
            ]);

            $menuExistente = collect($this->menus)->firstWhere('fecha', $this->editar_fecha);

            if ($this->editar_idMenu !== $menuExistente['id_menu']) {
                $this->addError('editar_fecha', 'Ya existe un menú con esa fecha');
                return;
            }

            $productosSeleccionados = collect($this->editar_productos)
                ->filter(fn($prod) => !empty($prod['seleccionado']))
                ->map(function ($prod, $idProducto) {
                    return [
                        'id_producto' => $idProducto,
                        'cantidad_disponible' => (int)($prod['cantidad_disponible'] ?? 10)
                    ];
                })
                ->values()
                ->toArray();

            if (empty($productosSeleccionados)) {
                $this->addError('editar_productos', 'Debe seleccionar al menos un producto');
                return;
            }

            foreach ($productosSeleccionados as $producto) {
                if ($producto['cantidad_disponible'] < 0) {
                    $this->addError('editar_productos', 'Las cantidades no pueden ser negativas');
                    return;
                }
            }

            if ($this->menusService->actualizar($this->editar_idMenu, $this->editar_fecha, $productosSeleccionados)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Menú actualizado correctamente');
                $this->cerrarModalEditar();
                $this->cargarMenus();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar el menú');
                $this->cerrarModalEditar();
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar el menú');
            $this->cerrarModalEditar();
        }
    }

    public function render()
    {
        return view('livewire.admin.menus');
    }
}
