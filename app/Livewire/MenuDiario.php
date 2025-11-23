<?php

namespace App\Livewire;

use App\Services\CarritoService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class MenuDiario extends Component
{
    public $menu = [];
    public int $id;
    protected CarritoService $carritoService;

    public function boot(CarritoService $carritoService)
    {
        $this->carritoService = $carritoService;
    }

    public function mount()
    {
        $this->id = 3;
        $this->cargarMenu();
    }

    public function cargarMenu()
    {
        $response = Http::get(env('API_HOST') . '/menu');

        if ($response->successful()) {
            $this->menu = $response->json('data.0');
        }
    }

    public function agregarAlCarrito(int $idProducto, int $cantidad)
    {
        if ($this->carritoService->agregar($this->id, $idProducto, $cantidad)) {
            Session::flash('mensaje', 'Agregado correctamente');
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
