<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\TarjetaLocalController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');


Route::middleware('auth.guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/singup', 'auth.singup')->name('singup');
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::view('/mi-cuenta', 'user.cuenta')->name('cuenta');
Route::view('/carrito', 'user.carrito')->name('carrito');
Route::view('/tarjeta-local', 'user.tarjeta-local')->name('tarjeta.local');
Route::view('/ordenes', 'user.ordenes')->name('ordenes');


Route::view('/admin', 'admin.dashboard')->name('dashboard');
Route::view('/categorias', 'admin.categorias')->name('admin.categorias');
Route::view('/productos', 'admin.productos')->name('admin.productos');
