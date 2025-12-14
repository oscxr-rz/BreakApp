<?php

namespace App\Livewire;

use App\Services\OrdenService;
use App\Services\TicketsService;
use App\Services\UsuarioService;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class OrdenesUsuario extends Component
{
    public int $id;
    public $ordenes = [];
    protected OrdenService $ordenService;
    protected TicketsService $ticketsService;
    protected UsuarioService $usuarioService;

    public function boot(OrdenService $ordenService, TicketsService $ticketsService, UsuarioService $usuarioService)
    {
        $this->ordenService = $ordenService;
        $this->ticketsService = $ticketsService;
        $this->usuarioService = $usuarioService;
    }

    public function mount()
    {
        $this->id = Session::get('id') ?? 0;
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
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Orden eliminada correctamente');
                $this->cargarOrdenes();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo eliminar la orden');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al momento de eliminar la orden');
        }
    }

    public function obtenerTicket(int $idOrden)
    {
        $usuario = $this->usuarioService->obtenerUsuario($this->id) ?? [];
        $email = $usuario['email'];

        try {
            if ($this->ticketsService->ticket($idOrden, $email)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: "Ticket enviado a su email: {$email}");
                $this->cargarOrdenes();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo obtener el ticket');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al obtener el ticket');
        }
    }

    public function render()
    {
        return view('livewire.ordenes-usuario');
    }
}
