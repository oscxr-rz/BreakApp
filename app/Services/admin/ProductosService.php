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

    public function crear($idCategoria, $nombre, $descripcion, $precio, $tiempoPreparacion, $imagen, $activo)
    {
        try {
            $response = Http::withToken($this->token)
                ->attach(
                    'imagen',
                    fopen($imagen->getRealPath(), 'r'),
                    $imagen->getClientOriginalName()
                )
                ->post("{$this->apiHost}/admin/productos", [
                    'id_categoria' => $idCategoria,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'tiempo_preparacion' => $tiempoPreparacion,
                    'activo' => $activo
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function actualizar($idProducto, $idCategoria, $nombre, $descripcion, $precio, $tiempoPreparacion, $imagen)
    {
        try {
            $request = Http::withToken($this->token);

            if ($imagen) {
                $response = $request
                    ->attach('imagen', fopen($imagen->getRealPath(), 'r'), $imagen->getClientOriginalName())
                    ->attach('id_categoria', $idCategoria)
                    ->attach('nombre', $nombre)
                    ->attach('descripcion', $descripcion)
                    ->attach('precio', $precio)
                    ->attach('tiempo_preparacion', $tiempoPreparacion)
                    ->post("{$this->apiHost}/admin/productos/{$idProducto}?_method=PUT");
            } else {
                $response = $request->put("{$this->apiHost}/admin/productos/{$idProducto}", [
                    'id_categoria' => $idCategoria,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'tiempo_preparacion' => $tiempoPreparacion
                ]);
            }

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function cambiarEstado(int $idProducto, int $activo)
    {
        try {
            $response = Http::withToken($this->token)->patch("{$this->apiHost}/admin/productos/{$idProducto}/estado", [
                'activo' => $activo
            ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
