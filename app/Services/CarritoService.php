<?php

namespace App\Services;

use Exception;
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

    public function comprar(int $idUsuario, string $metodoPago, string $horaRecogida, array $productos)
    {
        try {
            $idMenu = collect($productos)
                ->pluck('id_menu')
                ->unique()
                ->count() === 1
                ? collect($productos)->first()['id_menu']
                : null;

            $response = Http::withToken($this->token)
                ->post("{$this->apiHost}/usuario/orden/{$idUsuario}", [
                    'id_menu' => $idMenu,
                    'metodo_pago' => $metodoPago,
                    'hora_recogida' => $horaRecogida,
                    'productos' => $productos
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
