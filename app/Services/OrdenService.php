<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OrdenService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = '2|WItwCkHKTzKpkr2LWRSQsKpqQKGEdGmluYpoVyEU14e4486e';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerOrdenes(int $idUsuario)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/usuario/orden/{$idUsuario}");

        return $response->successful() ? $response->json('data') : null;
    }

    public function ocultarOrden(int $idUsuario, int $idOrden)
    {
        $response = Http::withToken($this->token)
            ->patch("{$this->apiHost}/usuario/orden/{$idUsuario}/ocultar", [
                'id_orden' => $idOrden
            ]);

        return $response->successful();
    }
}
