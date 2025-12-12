<?php

namespace App\Livewire\Admin;

use App\Services\Admin\MenusService;
use App\Services\Admin\ProductosService;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;

class Menus extends Component
{
    public $menus = [];
    public $productos = [];
    
    protected MenusService $menusService;
    protected ProductosService $productosService;

    // Propiedades para crear
    public $crear_fecha = '';
    public $crear_productos = [];

    // Propiedades para editar
    public $editar_idMenu = null;
    public $editar_fecha = '';
    public $editar_productos = [];

    // Controles de modales
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
        
        Log::info('=== INICIO cargarProductos ===');
        Log::info('ProductosRaw tipo:', ['tipo' => gettype($productosRaw)]);
        Log::info('ProductosRaw count:', ['count' => count($productosRaw)]);
        
        $productosAplanados = [];
        
        // Si es un array asociativo con categorías como keys
        if (!empty($productosRaw) && !isset($productosRaw[0])) {
            Log::info('Detectado array asociativo (agrupado por categoría)');
            foreach ($productosRaw as $categoria => $items) {
                Log::info("Procesando categoría: $categoria", ['items_count' => count($items)]);
                if (is_array($items)) {
                    foreach ($items as $producto) {
                        // Solo agregar productos activos
                        if (isset($producto['activo']) && $producto['activo'] == 1) {
                            // Asegurarnos de que tenga la categoría en el formato correcto
                            if (!isset($producto['categoria']) || is_string($producto['categoria'])) {
                                $producto['categoria'] = $categoria;
                            }
                            $productosAplanados[] = $producto;
                        }
                    }
                }
            }
        } 
        // Si ya es un array indexado de productos
        else {
            Log::info('Detectado array indexado');
            foreach ($productosRaw as $producto) {
                if (isset($producto['activo']) && $producto['activo'] == 1) {
                    $productosAplanados[] = $producto;
                }
            }
        }
        
        Log::info('ProductosAplanados final count:', ['count' => count($productosAplanados)]);
        Log::info('Primeros 3 productos:', ['productos' => array_slice($productosAplanados, 0, 3)]);
        Log::info('=== FIN cargarProductos ===');
        
        $this->productos = $productosAplanados;
    }

    public function abrirModalCrear()
    {
        // Primero recargar productos para asegurar que estén actualizados
        $this->cargarProductos();
        
        Log::info('=== abrirModalCrear ===');
        Log::info('Productos count antes de inicializar:', ['count' => count($this->productos)]);
        
        $this->reset(['crear_fecha', 'crear_productos']);
        $this->resetErrorBag();
        
        // Inicializar array de productos con valores por defecto
        $this->crear_productos = [];
        foreach ($this->productos as $producto) {
            if (isset($producto['id_producto'])) {
                $this->crear_productos[$producto['id_producto']] = [
                    'seleccionado' => false,
                    'cantidad_disponible' => 10
                ];
            }
        }
        
        Log::info('crear_productos inicializado:', ['count' => count($this->crear_productos)]);
        
        // Establecer fecha de hoy por defecto
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
        // Primero recargar productos para asegurar que estén actualizados
        $this->cargarProductos();
        
        Log::info('=== abrirModalEditar ===');
        Log::info('Productos count antes de inicializar:', ['count' => count($this->productos)]);
        
        $this->resetErrorBag();
        
        // Buscar el menú
        $menu = collect($this->menus)->firstWhere('id_menu', $idMenu);
        
        if (!$menu) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Menú no encontrado');
            return;
        }
        
        $this->editar_idMenu = $idMenu;
        $this->editar_fecha = $menu['fecha'];
        
        // Inicializar array de productos
        $this->editar_productos = [];
        
        // Obtener productos del menú actual (aplanar el array agrupado por categoría)
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
        
        Log::info('Productos del menú encontrados:', ['count' => count($productosDelMenu)]);
        
        // Inicializar todos los productos
        foreach ($this->productos as $producto) {
            if (!isset($producto['id_producto'])) {
                continue;
            }
            
            $idProducto = $producto['id_producto'];
            
            if (isset($productosDelMenu[$idProducto])) {
                // Producto está en el menú
                $this->editar_productos[$idProducto] = [
                    'seleccionado' => true,
                    'cantidad_disponible' => $productosDelMenu[$idProducto]['cantidad_disponible'] ?? 10
                ];
            } else {
                // Producto no está en el menú
                $this->editar_productos[$idProducto] = [
                    'seleccionado' => false,
                    'cantidad_disponible' => 10
                ];
            }
        }
        
        Log::info('editar_productos inicializado:', ['count' => count($this->editar_productos)]);
        
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
            // Validar fecha
            $this->validate([
                'crear_fecha' => 'required|date|after_or_equal:today',
            ], [
                'crear_fecha.required' => 'La fecha es obligatoria',
                'crear_fecha.date' => 'Debe ser una fecha válida',
                'crear_fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy',
            ]);

            // Filtrar solo productos seleccionados
            $productosSeleccionados = collect($this->crear_productos)
                ->filter(fn($prod) => !empty($prod['seleccionado']))
                ->map(function($prod, $idProducto) {
                    return [
                        'id_producto' => $idProducto,
                        'cantidad_disponible' => (int)($prod['cantidad_disponible'] ?? 10)
                    ];
                })
                ->values()
                ->toArray();

            // Validar que haya al menos un producto
            if (empty($productosSeleccionados)) {
                $this->addError('crear_productos', 'Debe seleccionar al menos un producto');
                return;
            }

            // Validar cantidades
            foreach ($productosSeleccionados as $producto) {
                if ($producto['cantidad_disponible'] < 0) {
                    $this->addError('crear_productos', 'Las cantidades no pueden ser negativas');
                    return;
                }
            }

            // Crear el menú
            if ($this->menusService->crear($this->crear_fecha, $productosSeleccionados)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Menú creado correctamente');
                $this->cerrarModalCrear();
                $this->cargarMenus();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo crear el menú');
            }
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Error al crear menú:', ['error' => $e->getMessage()]);
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al crear el menú');
            $this->cerrarModalCrear();
        }
    }

    public function actualizarMenu()
    {
        try {
            // Validar fecha
            $this->validate([
                'editar_fecha' => 'required|date|after_or_equal:today',
            ], [
                'editar_fecha.required' => 'La fecha es obligatoria',
                'editar_fecha.date' => 'Debe ser una fecha válida',
                'editar_fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy',
            ]);

            // Filtrar solo productos seleccionados
            $productosSeleccionados = collect($this->editar_productos)
                ->filter(fn($prod) => !empty($prod['seleccionado']))
                ->map(function($prod, $idProducto) {
                    return [
                        'id_producto' => $idProducto,
                        'cantidad_disponible' => (int)($prod['cantidad_disponible'] ?? 10)
                    ];
                })
                ->values()
                ->toArray();

            // Validar que haya al menos un producto
            if (empty($productosSeleccionados)) {
                $this->addError('editar_productos', 'Debe seleccionar al menos un producto');
                return;
            }

            // Validar cantidades
            foreach ($productosSeleccionados as $producto) {
                if ($producto['cantidad_disponible'] < 0) {
                    $this->addError('editar_productos', 'Las cantidades no pueden ser negativas');
                    return;
                }
            }

            // Actualizar el menú
            if ($this->menusService->actualizar($this->editar_idMenu, $this->editar_fecha, $productosSeleccionados)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Menú actualizado correctamente');
                $this->cerrarModalEditar();
                $this->cargarMenus();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar el menú');
            }
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Error al actualizar menú:', ['error' => $e->getMessage()]);
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar el menú');
            $this->cerrarModalEditar();
        }
    }

    public function render()
    {
        Log::info('=== RENDER ===');
        Log::info('Productos en render:', ['count' => count($this->productos)]);
        
        return view('livewire.admin.menus');
    }
}