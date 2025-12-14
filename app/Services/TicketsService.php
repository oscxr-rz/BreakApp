<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TicketsService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
    }

    public function ticket($idOrden, $email) {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->apiHost}/ticket/{$idOrden}/enviar", [
                    'email' => $email
                ]);

            return $response->successful();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
