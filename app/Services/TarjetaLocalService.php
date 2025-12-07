<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TarjetaLocalService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token');
        $this->apiHost = env('API_HOST');
    }

    public function obtenerSaldo(int $idUsuario)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/usuario/tarjeta-local/{$idUsuario}");

        return $response->successful() ? $response->json('data') : null;
    }
}
