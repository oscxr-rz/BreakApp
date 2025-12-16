<?php

namespace App\Services\admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardService
{
    private string $token;
    private string $apiHost;

    public function __construct()
    {
        $this->token = Session::get('api_token') ?? '';
        $this->apiHost = env('API_HOST');
    }

    public function obtenerDatos()
    {
        $response = Http::withToken($this->token)
            ->get("{$this->apiHost}/admin/dashboard");

        return $response;
    }
}
