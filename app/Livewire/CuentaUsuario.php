<?php

namespace App\Livewire;

use App\Services\UsuarioService;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class CuentaUsuario extends Component
{

    use WithFileUploads;
    public $usuario = [];
    public int $id;

    protected UsuarioService $usuarioService;
    public $imagen;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $newPassword;

    public $gradoGrupo;
    public $grupo;
    public $semestre;

    public function boot(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function mount()
    {
        $this->id = session()->get('id');
        $this->cargarUsuario();
    }

    public function cargarUsuario()
    {
        $this->usuario = $this->usuarioService->obtenerUsuario($this->id) ?? [];

        if ($this->usuario['grupo']) {
            $this->semestre = $this->usuario['grupo'][0];
            $this->grupo = $this->usuario['grupo'][1];
        }
    }

    protected function reglasDatos()
    {
        return [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => 'required|email',
            'telefono' => 'required|numeric|min_digits:10|max_digits:10',
            'grupo' => 'nullable|string',
            'semestre' => 'nullable|string'
        ];
    }
    protected function reglasPassword()
    {
        return [
            'password' => 'required|string|min:6',
            'newPassword' => 'required|string|min:6',
        ];
    }

    public function rules()
    {
        if ($this->password) {
            return $this->reglasPassword();
        }

        return $this->reglasDatos();
    }

    public $messages = [
        'nombre.required' => 'Debe ingresar al menos un nombre',
        'nombre.string' => 'El nombre debe ser texto válido',

        'apellido.required' => 'Debe ingresar al menos un apellido',
        'apellido.string' => 'El apellido debe ser texto válido',

        'email.required' => 'Debe ingresar un email',
        'email.email' => 'Debe ingresar un email válido',

        'telefono.required' => 'Debe ingresar un número de teléfono',
        'telefono.numeric' => 'El teléfono debe contener solo números',
        'telefono.min_digits' => 'El teléfono debe tener exactamente 10 dígitos',
        'telefono.max_digits' => 'El teléfono debe tener exactamente 10 dígitos',

        'password.required' => 'Debe ingresar una contraseña',
        'password.string' => 'La contraseña debe ser texto válido',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres',

        'newPassword.required' => 'Debe ingresar la nueva contraseña',
        'newPassword.string' => 'Debe ser texto válido',
        'newPassword.min' => 'Debe tener al menos 6 caracteres',

        'grupo.string' => 'El grupo debe ser texto válido',
        'semestre.string' => 'El semestre debe ser texto válido',

        'imagen.required' => 'Debe ingresar una imagen',
        'imagen.image' => 'Debe ser una imagen',
        'imagen.max' => 'El archivo es demasiado grande'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function actualizarImg()
    {
        try {
            $this->validate([
                'imagen' => 'required|image|mimes:jpg,png|max:4096'
            ]);

            if ($this->usuarioService->img($this->id, $this->imagen)) {
                Session::flash('mensaje', 'se envió correctamente');
                $this->dispatch('mostrar-toast', tipo: 'exito', mensaje: 'Imagen actualizada correctamente');
                $this->reset('imagen');
                $this->cargarUsuario();
            } else {
                $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'No se pudo actualizar la imagen');
                Session::flash('mensaje', 'no se envio');
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->dispatch('mostrar-toast', tipo: 'error', mensaje: 'Ocurrió un error al actualizar la imagen');
                Session::flash('mensaje', 'error');
        }
    }
    public function actualizarDatos() {}

    public function actualizarPassword() {}

    public function desactivarCuenta() {}
    public function render()
    {
        return view('livewire.cuenta-usuario');
    }
}
