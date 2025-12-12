<?php

namespace App\Livewire\Admin;

use App\Services\OrdenService;
use Exception;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Ordenes extends Component
{
    public $ordenes = [];
    protected OrdenService $ordenService;

    public function boot(OrdenService $ordenService)
    {
        $this->ordenService = $ordenService;
    }

    public function mount()
    {
        $this->cargarOrdenes();
    }

    public function cargarOrdenes()
    {
        $response = Http::withToken(session('api_token'))
            ->get(env('API_HOST') . '/admin/ordenes');
        $this->ordenes = $response->successful() ? $response->json('data') : [];
    }

    public function cambiarEstado(int $idOrden, string $estado)
    {
        try {
            if ($this->ordenService->cambiarEstado($idOrden, $estado)) {
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
