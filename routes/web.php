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
Route::view('/notificaciones', 'user.notificaciones')->name('notificaciones');
Route::view('/notificacion/{id}', 'user.notificacion-show')->name('notificacion');
Route::view('/tarjeta-local', 'user.tarjeta-local')->name('tarjeta.local');
Route::view('/ordenes', 'user.ordenes')->name('ordenes');

Route::prefix('/admin')->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('dashboard');
    Route::view('/categorias', 'admin.categorias')->name('admin.categorias');
    Route::view('/productos', 'admin.productos')->name('admin.productos');
    Route::view('/menus', 'admin.menus')->name('admin.menus');
    Route::view('/ordenes', 'admin.ordenes')->name('admin.ordenes');
    Route::view('/registrar-compra', 'admin.capturar-orden')->name('admin.registrar.compra');
    Route::view('/capturar-orden', 'admin.registrar-compra')->name('admin.capturar.orden');
});
