<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas necesarias para implementar una API que permita consultar los mensajes y añadir nuevos mensajes. Estas rutas se corresponden con los métodos del controlador MensajeController:
// Protegemos las rutas para que solo sean accesibles con un token válido. Para ello, añadimos el middleware 'auth:sanctum' a las rutas. Esto asegura que solo los usuarios autenticados puedan acceder a estas rutas.
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
//Route::prefix('v1')->group(function () {
    Route::get('/mensajes', [App\Http\Controllers\Api\V1\MensajeController::class, 'index'])->name('mensaje.index');
    Route::post('/mensajes', [App\Http\Controllers\Api\V1\MensajeController::class, 'store'])->name('mensaje.store');
    Route::delete('/mensajes/{id}', [App\Http\Controllers\Api\V1\MensajeController::class, 'destroy'])->name('mensaje.destroy');
});

// Ruta para el login, que no requiere autenticación previa, ya que es el punto de entrada para obtener el token de acceso.
Route::post('/v1/login', [App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('auth.login');