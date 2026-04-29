<?php

use App\Http\Controllers\InfraestructuraController;
use Illuminate\Support\Facades\Route;

// Rutas para infraestructura - ACCESO LIBRE PARA USUARIOS AUTENTICADOS
Route::middleware(['auth'])->prefix('infraestructura')->group(function () {
    Route::get('/index', [InfraestructuraController::class, 'edit'])->name('infraestructura.edit');
    Route::post('/save', [InfraestructuraController::class, 'save'])->name('infraestructura.save');
    Route::post('/save-infraestructura', [InfraestructuraController::class, 'saveInfraestructura'])->name('infraestructura.saveInfraestructura');
    Route::get('/buscar/{codigo}', [InfraestructuraController::class, 'buscarEstablecimiento'])->name('infraestructura.buscar');
    Route::get('/establecimiento/{codigo}', [InfraestructuraController::class, 'getEstablecimientoByCodigo'])->name('api.establecimiento.codigo');
    Route::get('/infraestructura/reset', [InfraestructuraController::class, 'resetEstablecimiento'])
    ->name('infraestructura.reset');
});