<?php

namespace App\Livewire\Admin;

use App\Services\admin\TarjetaLocalService;
use Exception;
use Livewire\Component;

class TarjetaLocal extends Component
{
    public $tarjetaLocal = [];
    public $idTarjeta;
    public $monto;
    protected TarjetaLocalService $tarjetaLocalService;

    public function boot(TarjetaLocalService $tarjetaLocalService)
    {
        $this->tarjetaLocalService = $tarjetaLocalService;
    }

    public function cargarTarjeta()
    {
        try {
            $this->validate([
                'idTarjeta' => 'required|integer|min:1',
            ], [
                'idTarjeta.required' => 'Debe ingresar el ID de la tarjeta',
                'idTarjeta.min' => 'El ID no debe ser menor a 1',
            ]);

            $this->tarjetaLocal = $this->tarjetaLocalService->obtenerTarjeta($this->idTarjeta) ?? [];
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al obtener la tarjeta');
        }
    }

    public function depositar($idTarjeta)
    {
        try {
            $this->validate([
                'monto' => 'required|numeric|min:1'
            ], [
                'monto.required' => 'Debe ingresar el monto',
                'monto.min' => 'El monto no debe ser menor a 1',
            ]);

            if ($this->tarjetaLocalService->depositar($idTarjeta, $this->monto)) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Tarjeta recargada correctamente');
                $this->tarjetaLocal = [];
                $this->reset('monto');
                $this->cargarTarjeta();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo recargar la tarjeta');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al recargar la tarjeta');
        }
    }

    public function limpiar()
    {
        $this->reset(['tarjetaLocal', 'idTarjeta', 'monto']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.tarjeta-local');
    }
}