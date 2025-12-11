<?php

namespace App\Livewire\Admin;

use Exception;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Ordenes extends Component
{
    public $ordenes = [];

    public function mount()
    {
        $this->cargarOrdenes();
    }

    public function cargarOrdenes()
    {
        $response = Http::withToken(session('api_token'))
            ->get(env('API_HOST') . '/admin/ordenes');
        $response->successful() ? $response->json('data') : [];
    }

    // public function cambiarEstado(int $idCategoria, int $activo)
    // {
    //     try {
    //         if ($this->categoriasService->cambiarEstado($idCategoria, $activo)) {
    //             $mensaje = $activo == 1 ? 'Categoría activada correctamente' : 'Categoría desactivada correctamente';
    //             $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: $mensaje);
    //             $this->cargarCategorias();
    //         } else {
    //             $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar la categoría');
    //         }
    //     } catch (Exception $e) {
    //         $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar la categoría');
    //     }
    // }
    public function render()
    {
        return view('livewire.admin.ordenes');
    }
}
