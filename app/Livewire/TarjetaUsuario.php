<?php

namespace App\Livewire;

use App\Services\TarjetaService;
use Exception;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class TarjetaUsuario extends Component
{
    public $id;
    public $tarjetas = [];

    public $tokenStripe;
    protected TarjetaService $tarjetaService;

    public function boot(TarjetaService $tarjetaService)
    {
        $this->tarjetaService = $tarjetaService;
    }

    public function mount()
    {
        $this->id = Session::get('id') ?? 0;
        $this->cargarTarjetas();
    }

    public function cargarTarjetas()
    {
        $this->tarjetas = $this->tarjetaService->obtenerTarjetas($this->id) ?? [];
    }

    public function agregarTarjeta()
    {
        try {
            $response = $this->tarjetaService->guardarTarjeta($this->tokenStripe, $this->id);
            if ($response === true) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Tarjeta agregada correctamente');
                $this->cargarTarjetas();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: $response);
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al agregar la tarjeta');
        }
    }

    public function ocultarTarjeta(int $idTarjeta)
    {
        try {
            if ($this->tarjetaService->desactivar($this->id, $idTarjeta)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Tarjeta desactivada correctamente');
                $this->cargarTarjetas();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo desactivar la tarjeta');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al momento de desactivar la tarjeta');
        }
    }
    public function render()
    {
        return view('livewire.tarjeta-usuario');
    }
}
