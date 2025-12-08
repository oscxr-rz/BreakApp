<?php

namespace App\Livewire;

use App\Services\OrdenService;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class OrdenesUsuario extends Component
{
    public int $id;
    public $ordenes = [];
    protected OrdenService $ordenService;

    public function boot(OrdenService $ordenService)
    {
        $this->ordenService = $ordenService;
    }

    public function mount()
    {
        $this->id = Session::get('id');
        $this->cargarOrdenes();
    }

    public function cargarOrdenes()
    {
        $this->ordenes = $this->ordenService->obtenerOrdenes($this->id) ?? [];
    }

    public function ocultarOrden(int $idOrden)
    {
        try {
            if ($this->ordenService->ocultarOrden($this->id, $idOrden)) {
                $this->dispatch('mensaje-exito', mensaje: 'Orden eliminada correctamente');
                $this->cargarOrdenes();
            } else {
                $this->dispatch('mensaje-error', mensaje: 'No se pudo eliminar la orden');
            }
        } catch (Exception $e) {
            $this->dispatch('mensaje-error', mensaje: 'Ocurrió un error al momento de eliminar la orden');
        }
    }

    public function render()
    {
        return view('livewire.ordenes-usuario');
    }
}
