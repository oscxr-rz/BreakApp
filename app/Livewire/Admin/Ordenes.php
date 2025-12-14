<?php

namespace App\Livewire\Admin;

use App\Services\admin\OrdenesService;
use Exception;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Ordenes extends Component
{
    public $ordenes = [];
    protected OrdenesService $ordenesService;

    public function boot(OrdenesService $ordenesService)
    {
        $this->ordenesService = $ordenesService;
    }

    public function mount()
    {
        $this->cargarOrdenes();
    }

    public function cargarOrdenes()
    {
        $this->ordenes = $this->ordenesService->obtenerOrdenes() ?? [];
    }

    public function cambiarEstado(int $idOrden, string $estado)
    {
        try {
            if ($this->ordenesService->cambiarEstado($idOrden, $estado)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: "Orden {$idOrden} actualizada a {$estado}");
                $this->cargarOrdenes();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar la orden');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar la orden');
        }
    }
    public function render()
    {
        return view('livewire.admin.ordenes');
    }
}
