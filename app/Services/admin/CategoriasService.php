<?php

namespace App\Services\admin;

use Exception;
use Illuminate\Support\Facades\Http;

class CategoriasService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = '1|qpXariEJJxTGZnWtKw0v21rfFa7Nb9YZK0XqRMoma2d010aa';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerCategorias()
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/admin/categorias");

        return $response->successful() ? $response->json('data') : null;
    }

    public function crear(string $nombre, string $descripcion, int $activo)
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->apiHost}/admin/categorias", [
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
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

    public function actualizar(int $idCategoria, string $nombre, string $descrpcion)
    {
        try {
            $response = Http::withToken($this->token)->put("{$this->apiHost}/admin/categorias/{$idCategoria}", [
                'nombre' => $nombre,
                'descripcion' => $descrpcion
            ]);

            if ($response->successful()) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function cambiarEstado(int $idCategoria, int $activo)
    {
        try {
            $response = Http::withToken($this->token)->patch("{$this->apiHost}/admin/categorias/{$idCategoria}/estado", [
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
