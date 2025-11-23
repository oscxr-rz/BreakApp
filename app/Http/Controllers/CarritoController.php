<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CarritoController extends Controller
{
    public function index()
    {
        return view('User.carrito');
    }
}
