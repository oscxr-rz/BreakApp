<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TarjetaLocalController extends Controller
{
    public function show()
    {
        $tarjetaLocal = [];
        $response = Http::withToken('2|WItwCkHKTzKpkr2LWRSQsKpqQKGEdGmluYpoVyEU14e4486e')
            ->get(env('API_HOST') . '/usuario/tarjeta-local/3');

        if ($response->successful()) {
            $tarjetaLocal = $response->json('data');
        }

        return view('User.tarjeta-local', compact('tarjetaLocal'));
    }
}
