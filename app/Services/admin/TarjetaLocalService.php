<?php

namespace App\Services\admin;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TarjetaLocalService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerTarjeta(int $idTarjeta)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/admin/tarjeta-local/{$idTarjeta}");

        return $response->successful() ? $response->json('data') : null;
    }

    public function depositar($idTarjeta, $monto)
    {
        try {
            $response = Http::withToken($this->token)
            ->post("{$this->apiHost}/admin/tarjeta-local/{$idTarjeta}/recargar", [
                'monto' => $monto
            ]);
            
            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}