<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrdenService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
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
        try {
            $response = Http::withToken($this->token)
                ->patch("{$this->apiHost}/usuario/orden/{$idUsuario}/ocultar", [
                    'id_orden' => $idOrden
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
