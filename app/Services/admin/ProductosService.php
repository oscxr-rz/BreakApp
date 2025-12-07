<?php

namespace App\Services\admin;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ProductosService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token');
        $this->apiHost = env('API_HOST');
    }

    public function obtenerProductos()
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/admin/productos");

        return $response->successful() ? $response->json('data') : null;
    }

    public function cambiarEstado(int $idProducto, int $activo)
    {
        try {
            $response = Http::withToken($this->token)->patch("{$this->apiHost}/admin/productos/{$idProducto}/estado", [
                'activo' => $activo
            ]);

            if ($response->successful()) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
