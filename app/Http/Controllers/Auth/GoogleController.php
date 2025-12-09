<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Session\SessionController;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController
{
    public function redirectToGoole()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $findUser = Usuario::where('correo', $googleUser->email)->first();

            if ($findUser) {

                $this->CreateSession($findUser);

                $tipo = session()->get('tipo');

                if ($tipo == 'Administrador') {
                    return redirect()->route('admin.inicio');
                }

                return redirect()->route('home');
            } else {

                $nameParts = explode(' ', $googleUser->name, 2);
                $nombre = $nameParts[0];
                $apellido = isset($nameParts[1]) ? $nameParts[1] : '';

                $newUser = Usuario::create([
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'telefono' => null,
                    'correo' => $googleUser->email,
                ]);

                $this->CreateSession($newUser);

                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('mensaje', 'Error en el login');
        }
    }
}
