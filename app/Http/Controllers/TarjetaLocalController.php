<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TarjetaLocalController extends Controller
{
    private int $id = session()->get('id');
    private string $token = session()->get('api_token');
    public function show()
    {
        $tarjetaLocal = [];
        $response = Http::withToken($this->token)
            ->get(env('API_HOST') . "/usuario/tarjeta-local/{$this->id}");

        if ($response->successful()) {
            $tarjetaLocal = $response->json('data');
        }

        return view('user.tarjeta-local', compact('tarjetaLocal'));
    }
}
