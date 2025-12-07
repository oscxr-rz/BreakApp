<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TarjetaLocalService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = '1|qpXariEJJxTGZnWtKw0v21rfFa7Nb9YZK0XqRMoma2d010aa';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerSaldo(int $idUsuario)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/usuario/tarjeta-local/{$idUsuario}");

        return $response->successful() ? $response->json('data') : null;
    }
}
