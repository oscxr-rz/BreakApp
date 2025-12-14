<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class NotificacionService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerNotificaciones(int $idUsuario)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/usuario/notificacion/{$idUsuario}");

        return $response->successful() ? $response->json('data') : null;
    }

    public function ocultarNotificacion(int $idUsuario, int $idNotificacion)
    {
        try {
            $response = Http::withToken($this->token)
                ->patch("{$this->apiHost}/usuario/notificacion/{$idUsuario}/ocultar", [
                    'id_notificacion' => $idNotificacion
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
