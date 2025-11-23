<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class CarritoController extends Controller
{
    public function index()
    {
        return view('User.carrito');
    }

    public function comprarCarrito(Request $request)
    {
        try {
            if ($request->has('productos')) {
                $request['productos'] = collect(json_decode($request['productos'], true))->flatten(1)->toArray();
            }

            $request->validate([
                'metodo_pago' => 'required|string|in:EFECTIVO,SALDO,TARJETA',
                'hora_recogida' => 'required|date_format:H:i',
                'productos' => 'required|array|min:1',
                'productos.*.id_producto' => 'required|integer|min:1',
                'productos.*.cantidad' => 'required|integer|min:1',
                'productos.*.precio_unitario' => 'required|numeric|min:0',
            ]);

            $idMenu = collect($request['productos'])
            ->pluck('id_menu')->unique()
            ->count() === 1 ? collect($request['productos'])->first()['id_menu'] : null;

            $response = Http::withToken('2|WItwCkHKTzKpkr2LWRSQsKpqQKGEdGmluYpoVyEU14e4486e')
                ->post(env('API_HOST') . '/usuario/orden/3', [
                    'id_menu' => $idMenu,
                    'metodo_pago' => $request->metodo_pago,
                    'hora_recogida' => $request->hora_recogida,
                    'productos' => $request['productos']
                ]);

            if (!$response->successful()) {
                return redirect()->back()->with('mensaje', 'No se pudo generar la orden');
            }

            return redirect()->back()->with('mensaje', 'Orden creada exitosamente');
        } catch (ValidationException $e) {
            return redirect()->back()->with('mensaje', 'Datos ingresados de forma incorrecta');
        } catch (Exception $e) {
            return redirect()->back()->with('mensaje', 'Ocurrio un error al momento de procesar la orden');
        }
    }
}
