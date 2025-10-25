<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MensajeController;


Route::get('/mensaje', [MensajeController::class, 'create'])->name('mensaje.create');
Route::post('/mensaje', [MensajeController::class, 'store'])->name('mensaje.store');
Route::get('/muro', [MensajeController::class, 'index'])->name('mensaje.index');