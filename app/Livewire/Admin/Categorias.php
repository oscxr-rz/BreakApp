<?php

namespace App\Livewire\Admin;

use App\Services\admin\CategoriasService;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class Categorias extends Component
{
    public $categorias = [];
    protected CategoriasService $categoriasService;
    public $idCategoria = null;
    public $nombre = '';
    public $descripcion = '';
    public $activo = null;

    public function boot(CategoriasService $categoriasService)
    {
        $this->categoriasService = $categoriasService;
    }

    public function mount()
    {
        $this->cargarCategorias();
    }

    public function cargarCategorias()
    {
        $this->categorias = $this->categoriasService->obtenerCategorias() ?? [];
    }

    protected function reglasCrear()
    {
        return [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'activo' => 'required|in:0,1'
        ];
    }

    protected function reglasActualizar()
    {
        return [
            'idCategoria' => 'required|integer|min:1',
            'nombre' => 'required|string',
            'descripcion' => 'required|string'
        ];
    }

    public function rules()
    {
        if ($this->idCategoria) {
            return $this->reglasActualizar();
        }

        return $this->reglasCrear();
    }

    protected $messages = [
        'nombre.required' => 'Debe ingresar el nombre de la categoría',
        'descripcion.required' => 'Debe ingresar la descripción de la categoría',
        'activo.required' => 'Debe elegir si estará activa o no',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function crearCategoria()
    {
        try {
            $this->validate();

            if ($this->categoriasService->crear($this->nombre, $this->descripcion, $this->activo)) {
                Session::flash('mensaje', 'Categoría creada correctamente');
                $this->reset(['nombre', 'descripcion', 'activo']);
            } else {
                $this->addError('mensaje', 'No se pudo crear la categoría');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->addError('mensaje', 'Ocurrió un error al crear la categoría');
        }
    }

    public function actualizarCategoria()
    {
        try {
            $this->validate();

            if ($this->categoriasService->actualizar($this->idCategoria, $this->nombre, $this->descripcion)) {
                Session::flash('mensaje', 'Categoría actualizada correctamente');
                $this->reset(['idCategoria', 'nombre', 'descripcion']);
            } else {
                $this->addError('error', 'No se pudo actualizar la categoría');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrió un error al actualizar la categoría');
        }
    }

    public function cambiarEstado(int $idCategoria, int $activo)
    {
        try {
            if ($this->categoriasService->cambiarEstado($idCategoria, $activo)) {
                Session::flash('mensaje', 'Categoría actualizada correctamente');
            } else {
                $this->addError('error', 'No se pudo actualizar la categoría');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrió un error al cambiar el estado de la categoría');
        }
    }

    #[On('echo:admin,ActualizarCategoria')]

    public function categoriaActualizada()
    {
        $this->cargarCategorias();
        dd($this->categorias);
    }

    public function render()
    {
        return view('livewire.admin.categorias');
    }
}
