<?php

use App\Http\Controllers\CarritoController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');

//Carrito
Route::prefix('/carrito')->group( function () {
    Route::get('/', [CarritoController::class, 'index'])->name('carrito');
});
