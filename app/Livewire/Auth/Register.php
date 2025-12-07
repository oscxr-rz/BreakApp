<?php

namespace App\Livewire\Auth;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Register extends Component
{
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $passwordVerificacion;
    public $tipo = 'ALUMNO';

    public $gradoGrupo = null;
    public $grupo;
    public $semestre;

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => 'required|email',
            'telefono' => 'required|numeric|min_digits:10|max_digits:10',
            'password' => 'required|string|min:6',
            'passwordVerificacion' => 'required|string|min:6|same:password',
            'grupo' => 'nullable|string',
            'semestre' => 'nullable|string'
        ];
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

        'passwordVerificacion.required' => 'Debe confirmar su contraseña',
        'passwordVerificacion.string' => 'La confirmación debe ser texto válido',
        'passwordVerificacion.min' => 'La confirmación debe tener al menos 6 caracteres',
        'passwordVerificacion.same' => 'Las contraseñas no coinciden',

        'grupo.string' => 'El grupo debe ser texto válido',
        'semestre.string' => 'El semestre debe ser texto válido',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function crearCuenta()
    {
        try {
            $this->validate();

            $this->gradoGrupo = ($this->semestre && $this->grupo)
                ? $this->semestre . $this->grupo
                : null;

            $response = Http::post(env('API_HOST') . '/register', [
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'password' => $this->password,
                'tipo' => $this->tipo,
                'grupo' => $this->gradoGrupo,
            ]);

            if ($response->successful()) {
                $this->guardarSession($response->json('data'), $response->json('token'));
                Session::flash('mensaje', 'Cuenta creada correctamente');
                $this->reset(['nombre', 'apellido', 'email', 'telefono', 'password', 'passwordVerificacion', 'semestre', 'grupo']);
            } else {
                $this->addError('error', $response->json('message'));
            }
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrío un error al momento de crear la cuenta');
        }
    }

    private function guardarSession($usuario, $token)
    {
        session([
            'api_token' => $token,
            'id' => $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'tipo' => $usuario['tipo']
        ]);
    }


    public function render()
    {
        return view('livewire.auth.register');
    }
}
