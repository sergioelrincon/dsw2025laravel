<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas necesarias para implementar una API que permita consultar los mensajes y añadir nuevos mensajes. Estas rutas se corresponden con los métodos del controlador MensajeController:
Route::prefix('v1')->group(function () {
    Route::get('/mensajes', [App\Http\Controllers\Api\V1\MensajeController::class, 'index'])->name('mensaje.index');
    Route::post('/mensajes', [App\Http\Controllers\Api\V1\MensajeController::class, 'store'])->name('mensaje.store');
});