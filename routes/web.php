<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\TarjetaLocalController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');
Route::view('/ordenes', 'User.ordenes')->name('ordenes');

//Carrito
Route::prefix('/carrito')->group( function () {
    Route::get('/', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/', [CarritoController::class, 'comprarCarrito'])->name('carrito.comprar');
});

Route::prefix('/tarjeta-local')->group( function () {
    Route::get('/', [TarjetaLocalController::class, 'show'])->name('tarjeta.local');
});
