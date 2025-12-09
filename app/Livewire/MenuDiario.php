<?php

namespace App\Livewire;

use App\Services\CarritoService;
use App\Services\UsuarioService;
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
    protected UsuarioService $usuarioService;

    public function boot(CarritoService $carritoService, UsuarioService $usuarioService)
    {
        $this->carritoService = $carritoService;
        $this->usuarioService = $usuarioService;
    }

    public function mount()
    {
        $this->id = Session::get('id') ?? 0;
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
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Agregado correctamente');
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo agregar el producto al carrito');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al momento de agregar el producto al carrito');
        }
    }

    public function cerrarSesion()
    {
        try {
            if ($this->usuarioService->loguot()) {
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Sesión cerrada');
                return $this->redirect(route('index'));
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo cerrar sesión');
            }
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al cerrar sesión');
        }
    }
    public function render()
    {
        return view('livewire.menu-diario');
    }
}
