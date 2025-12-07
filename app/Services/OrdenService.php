<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class OrdenService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = '1|qpXariEJJxTGZnWtKw0v21rfFa7Nb9YZK0XqRMoma2d010aa';
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
