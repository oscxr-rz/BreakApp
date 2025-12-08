<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UsuarioService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token');
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
}
