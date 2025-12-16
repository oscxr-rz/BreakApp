<?php

namespace App\Services\admin;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MenusService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerMenus()
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/admin/menus");

        return $response->successful() ? $response->json('data') : null;
    }

    public function crear($fecha, $productos)
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->apiHost}/admin/menus", [
                    'fecha' => $fecha,
                    'productos' => $productos
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function actualizar($idMenu, $fecha, $productos)
    {
        try {
            $response = Http::withToken($this->token)
                ->put("{$this->apiHost}/admin/menus/{$idMenu}", [
                    'fecha' => $fecha,
                    'productos' => $productos
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}