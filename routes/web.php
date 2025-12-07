<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\TarjetaLocalController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');

Route::view('/register', 'auth.register')->name('register');

Route::view('/ordenes', 'user.ordenes')->name('ordenes');

//Carrito
Route::prefix('/carrito')->group( function () {
    Route::get('/', [CarritoController::class, 'index'])->name('carrito');
});

Route::prefix('/tarjeta-local')->group( function () {
    Route::get('/', [TarjetaLocalController::class, 'show'])->name('tarjeta.local');
});

Route::view('/admin', 'admin.dashboard')->name('dashboard');
Route::view('/categorias', 'admin.categorias')->name('admin.categorias');
Route::view('/productos', 'admin.productos')->name('admin.productos');

