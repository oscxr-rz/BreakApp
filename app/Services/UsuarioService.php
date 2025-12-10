<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use function Pest\Laravel\session;

class UsuarioService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerUsuario(int $idUsuario)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/usuario/{$idUsuario}");

        return $response->successful() ? $response->json('data') : null;
    }


    public function img(int $idUsuario, $imagen)
    {
        try {
            $response = Http::withToken($this->token)
                ->attach(
                    'imagen',
                    fopen($imagen->getRealPath(), 'r'),
                    $imagen->getClientOriginalName()
                )
                ->post("{$this->apiHost}/usuario/{$idUsuario}/imagen");

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function datos(int $idUsuario, $nombre, $apellido, $email, $telefono, $grupo)
    {
        try {
            $response = Http::withToken($this->token)
                ->put("{$this->apiHost}/usuario/{$idUsuario}", [
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'email' => $email,
                    'telefono' => $telefono,
                    'grupo' => $grupo
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function password(int $idUsuario, $password, $newPassword)
    {
        try {
            $response = Http::withToken($this->token)
                ->patch("{$this->apiHost}/usuario/{$idUsuario}/password", [
                    'password' => $password,
                    'passwordNueva' => $newPassword
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function loguot()
    {
        try {
            $response = Http::withToken($this->token)
                ->get("{$this->apiHost}/logout");

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function desactivar(int $idUsuario, $password)
    {
        try {
            $response = Http::withToken($this->token)
                ->patch("{$this->apiHost}/usuario/{$idUsuario}/desactivar", [
                    'password' => $password
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
