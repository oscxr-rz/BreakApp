<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class MenuDiario extends Component
{
    public $menu = [];

    public function mount()
    {
        $this->cargarMenu();
    }

    public function cargarMenu()
    {
        $response = Http::get(env('API_HOST') . '/menu');

        if ($response->successful()) {
            $this->menu = $response->json('data.0');
        }
    }

    #[On('echo:menu,ActualizarMenu')]
    public function menuActualizado()
    {
        $this->cargarMenu();
    }
    public function render()
    {
        return view('livewire.menu-diario');
    }
}
