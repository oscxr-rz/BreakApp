<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TarjetaService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerTarjetas(int $idUsuario)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/usuario/tarjeta/{$idUsuario}");

        return $response->successful() ? $response->json('data') : null;
    }

    public function guardarTarjeta(string $token, int $idUsuario)
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->apiHost}/usuario/tarjeta/{$idUsuario}", [
                    'tokenStripe' => $token,
                ]);

            return $response->successful() ? true : $response->json('message');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function desactivar(int $idUsuario, int $idTarjeta)
    {
        try {
            $response = Http::withToken($this->token)
                ->patch("{$this->apiHost}/usuario/tarjeta/{$idUsuario}/desactivar", [
                    'id_tarjeta' => $idTarjeta
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
