<?php

namespace App\Livewire;

use App\Services\CarritoService;
use Exception;
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
        try {
            if ($this->carritoService->agregar($this->id, $idProducto, $cantidad)) {
                Session::flash('mensaje', 'Agregado correctamente');
            } else {
                $this->addError('error', 'No se pudo agregar el producto al carrito');
            }
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrió un error al momento de agregar el producto al carrito');
        }
    }
    public function render()
    {
        return view('livewire.menu-diario');
    }
}
