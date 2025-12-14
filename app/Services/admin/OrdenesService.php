<?php

namespace App\Services\admin;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrdenesService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerOrdenes()
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/admin/ordenes");

        return $response->successful() ? $response->json('data') : null;
    }

    public function capturarOrden(array $productos)
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->apiHost}/admin/ordenes", [
                    'tipo' => 'CAPTURA',
                    'estado' => 'ENTREGADO',
                    'productos' => $productos
                ]);

                dd($response->json());

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function cambiarEstado($idOrden, $estado)
    {
        try {
            $response = Http::withToken($this->token)
                ->patch("{$this->apiHost}/admin/ordenes/{$idOrden}/estado", [
                    'estado' => $estado
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
