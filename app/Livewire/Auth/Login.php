<?php

namespace App\Livewire\Auth;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $telefono;
    public $password;

    public function rules()
    {
        return [
            'email' => 'nullable|email',
            'telefono' => 'nullable|numeric|min_digits:10|max_digits:10',
            'password' => 'required|string|min:6'
        ];
    }

    public $messages = [
        'email.email' => 'Debe ingresar un email válido',

        'telefono.numeric' => 'El teléfono debe contener solo números',
        'telefono.min_digits' => 'El teléfono debe tener exactamente 10 dígitos',
        'telefono.max_digits' => 'El teléfono debe tener exactamente 10 dígitos',

        'password.required' => 'Debe ingresar una contraseña',
        'password.string' => 'La contraseña debe ser texto válido',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function iniciarSesion()
    {
        try {
            $this->validate();

            $response = Http::post(env('API_HOST') . '/login', [
                'email' => $this->email ?? null,
                'telefono' => $this->telefono ?? null,
                'password' => $this->password
            ]);

            if ($response->successful()) {
                $this->guardarSession($response->json('data'), $response->json('token'));
                Session::flash('mensaje', 'Se inició sesión correctamente');
                $this->reset(['email', 'telefono', 'password']);
            } else {
                $this->addError('error', $response->json('message'));
            }
        } catch (Exception $e) {
            $this->addError('error', 'Ocurrío un error al momento de iniciar sesión');
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
        return view('livewire.auth.login');
    }
}
