<?php

namespace App\Livewire;

use App\Services\TarjetaLocalService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class TarjetaLocalUsuario extends Component
{
    public $id;
    public $tarjetaLocal;
    protected TarjetaLocalService $tarjetaLocalService;

    public function boot(TarjetaLocalService $tarjetaLocalService)
    {
        $this->tarjetaLocalService = $tarjetaLocalService;
    }

    public function mount()
    {
        $this->id = Session::get('id') ?? 0;
        $this->cargarTarjeta();
    }

    public function cargarTarjeta()
    {
        $this->tarjetaLocal = $this->tarjetaLocalService->obtenerSaldo($this->id) ?? [];
    }
    public function render()
    {
        return view('livewire.tarjeta-local-usuario');
    }
}
