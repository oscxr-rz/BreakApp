<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CarritoService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = '2|WItwCkHKTzKpkr2LWRSQsKpqQKGEdGmluYpoVyEU14e4486e';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerCarrito(int $idUsuario)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/usuario/carrito/{$idUsuario}");

        return $response->successful() ? $response->json('data.0') : null;
    }

    public function agregar(int $idUsuario, int $idProducto, int $cantidad)
    {
        $response = Http::withToken($this->token)
            ->post("{$this->apiHost}/usuario/carrito/{$idUsuario}/add", [
                'id_producto' => $idProducto,
                'cantidad' => $cantidad
            ]);

        return $response->successful();
    }

    public function eliminar(int $idUsuario, int $idProducto, int $cantidad): bool
    {
        $response = Http::withToken($this->token)
            ->post("{$this->apiHost}/usuario/carrito/{$idUsuario}/remove", [
                'id_producto' => $idProducto,
                'cantidad' => $cantidad
            ]);

        return $response->successful();
    }

    public function quitar(int $idUsuario, int $idProducto): bool
    {
        $response = Http::withToken($this->token)
            ->patch("{$this->apiHost}/usuario/carrito/{$idUsuario}/eliminar", [
                'id_producto' => $idProducto
            ]);

        return $response->successful();
    }
}
