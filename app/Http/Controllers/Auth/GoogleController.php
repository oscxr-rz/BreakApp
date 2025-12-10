<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Session\SessionController;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class GoogleController
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            if (!$request->has('code')) {
                return redirect()->route('login')
                    ->with('error', 'Acceso no autorizado. Por favor, inicia sesión correctamente.');
            }

            $googleUser = Socialite::driver('google')->user();
            
            $email = $googleUser->getEmail();
            $nameParts = explode(' ', $googleUser->getName(), 2);
            $nombre = $nameParts[0];
            $apellido = isset($nameParts[1]) ? $nameParts[1] : ' ';

            $response = Http::post(env('API_HOST') . '/login/google', [
                'email' => $email,
                'nombre' => $nombre,
                'apellido' => $apellido
            ]);

            if ($response->successful()) {
                $data = $response->json('data');
                session([
                    'api_token' => $response->json('token'),
                    'id' => $data['id_usuario'],
                    'nombre' => $data['nombre'],
                    'tipo' => $data['tipo'],
                ]);
                return redirect()->route('index');
            }
            return redirect()->route('login')->with('error', $response->json('message'));
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Ocurrió un error al momento de iniciar sesión');
        }
    }
}
