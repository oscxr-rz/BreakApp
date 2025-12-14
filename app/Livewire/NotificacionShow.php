<?php

namespace App\Livewire;

use App\Services\NotificacionService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class NotificacionShow extends Component
{
    public $id;
    public $idNotificacion;
    public $notificacion = [];
    protected NotificacionService $notificacionService;

    public function boot(NotificacionService $notificacionService)
    {
        $this->notificacionService = $notificacionService;
    }
    public function mount($id)
    {
        $this->id = Session::get('id');
        $this->idNotificacion = $id;
        $this->cargarNotificacion();
    }

    public function cargarNotificacion()
    {
        $this->notificacion = $this->notificacionService->obtenerNotificacion($this->id, $this->idNotificacion) ?? [];
    }
    public function render()
    {
        return view('livewire.notificacion-show');
    }
}
