<?php

namespace App\Livewire\Admin;

use App\Services\admin\DashboardService;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Dashboard extends Component
{
    public $usuarios;
    public $usuariosActivos;
    public $ordenes;
    public $ordenesEntregadas;
    public $tickets;
    public $productos;
    public $productosActivos;
    public $categorias;
    public $categoriasActivas;
    
    public $totalUsuarios = 0;
    public $totalUsuariosActivos = 0;
    public $totalOrdenes = 0;
    public $totalOrdenesEntregadas = 0;
    public $totalTickets = 0;
    public $totalProductos = 0;
    public $totalProductosActivos = 0;
    public $totalCategorias = 0;
    public $totalCategoriasActivas = 0;
    
    protected DashboardService $dashboardService;

    public function boot(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function mount()
    {
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        try {
            $response = $this->dashboardService->obtenerDatos() ?? [];

            $this->usuarios = $response->json('usuarios') ?? [];
            $this->ordenes = $response->json('ordenes') ?? [];
            $this->tickets = $response->json('tickets') ?? [];
            $this->productos = $response->json('productos') ?? [];
            $this->categorias = $response->json('categorias') ?? [];

            $this->calcularEstadisticas();

        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al obtener la tarjeta');
        }
    }

    private function calcularEstadisticas()
    {
        $this->totalUsuarios = count($this->usuarios);
        $this->totalUsuariosActivos = collect($this->usuarios)
            ->filter(fn($usuario) => ($usuario['activo'] ?? 0) === 1)
            ->count();

        $this->totalOrdenes = count($this->ordenes);
        $this->totalOrdenesEntregadas = collect($this->ordenes)
            ->filter(fn($orden) => strtoupper($orden['estado'] ?? '') === 'ENTREGADO')
            ->count();

        $this->totalTickets = count($this->tickets);

        $this->totalProductos = count($this->productos);
        $this->totalProductosActivos = collect($this->productos)
            ->filter(fn($producto) => ($producto['activo'] ?? 0) === 1)
            ->count();

        $this->totalCategorias = count($this->categorias);
        $this->totalCategoriasActivas = collect($this->categorias)
            ->filter(fn($categoria) => ($categoria['activo'] ?? 0) === 1)
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}