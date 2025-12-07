<?php

namespace App\Services\admin;

use Exception;
use Illuminate\Support\Facades\Http;

class ProductosService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = '1|qpXariEJJxTGZnWtKw0v21rfFa7Nb9YZK0XqRMoma2d010aa';
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
