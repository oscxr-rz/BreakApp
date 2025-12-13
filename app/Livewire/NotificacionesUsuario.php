<?php

namespace App\Livewire;

use App\Services\NotificacionService;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class NotificacionesUsuario extends Component
{
    public int $id;
    public $notificaciones = [];
    protected NotificacionService $notificacionService;

    public function boot(NotificacionService $notificacionService)
    {
        $this->notificacionService = $notificacionService;
    }

    public function mount()
    {
        $this->id = Session::get('id') ?? 0;
        $this->cargarNotificaciones();
    }

    public function cargarNotificaciones()
    {
        $this->notificaciones = $this->notificacionService->obtenerNotificaciones($this->id) ?? [];
    }

    public function ocultarNotificacion(int $idNotificacion)
    {
        try {
            if ($this->notificacionService->ocultarNotificacion($this->id, $idNotificacion)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Notificación eliminada correctamente');
                $this->cargarNotificaciones();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo eliminar la notificación');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al momento de eliminar la notificación');
        }
    }
    
    public function render()
    {
        return view('livewire.notificaciones-usuario');
    }
}
