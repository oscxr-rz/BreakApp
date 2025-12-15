<?php

namespace App\Services\admin;

use App\Services\TicketsService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrdenesService
{
    private string $token;
    private string $apiHost;

    protected TicketsService $ticketsService;

    public function __construct(TicketsService $ticketsService)
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
        $this->ticketsService = $ticketsService;
    }

    public function obtenerOrdenes()
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/admin/ordenes");

        return $response->successful() ? $response->json('data') : null;
    }

    public function capturarOrden(array $productos)
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->apiHost}/admin/ordenes", [
                    'tipo' => 'CAPTURA',
                    'estado' => 'ENTREGADO',
                    'productos' => $productos
                ]);


            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function registrarCompra(string $nombreCliente, ?int $idMenu, array $productos, $email)
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->apiHost}/admin/ordenes", [
                    'tipo' => 'COMPRA',
                    'estado' => 'PENDIENTE',
                    'id_menu' => $idMenu,
                    'nombre' => $nombreCliente,
                    'email' => $email,
                    'productos' => $productos
                ]);
    
            $orden = $response->json('data');
            $ticket = $this->ticketsService->ticket($orden['id_orden'], $email);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function cambiarEstado($idOrden, $estado)
    {
        try {
            $response = Http::withToken($this->token)
                ->patch("{$this->apiHost}/admin/ordenes/{$idOrden}/estado", [
                    'estado' => $estado
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
