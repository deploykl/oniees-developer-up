<?php

use App\Http\Controllers\InfraestructuraController;
use App\Http\Controllers\Infraestructura\EdificacionController;
use Illuminate\Support\Facades\Route;

// Rutas para infraestructura - ACCESO LIBRE PARA USUARIOS AUTENTICADOS
Route::middleware(['auth'])->prefix('infraestructura')->group(function () {
    // Rutas principales
    Route::get('/index', [InfraestructuraController::class, 'edit'])->name('infraestructura.edit');
    Route::post('/save', [InfraestructuraController::class, 'save'])->name('infraestructura.save');
    Route::get('/buscar/{codigo}', [InfraestructuraController::class, 'buscarEstablecimiento'])->name('infraestructura.buscar');
    Route::get('/reset', [InfraestructuraController::class, 'resetEstablecimiento'])->name('infraestructura.reset');

    // Rutas para Edificaciones (API)
    Route::prefix('edificaciones')->group(function () {
        Route::get('/get/{id}', [EdificacionController::class, 'show'])->name('infraestructura.edificaciones.get');
        Route::get('/{idEstablecimiento}', [EdificacionController::class, 'index'])->name('infraestructura.edificaciones.index');
        Route::post('/', [EdificacionController::class, 'store'])->name('infraestructura.edificaciones.store');
        Route::put('/{id}', [EdificacionController::class, 'update'])->name('infraestructura.edificaciones.update');
        Route::delete('/{id}', [EdificacionController::class, 'destroy'])->name('infraestructura.edificaciones.destroy');
    });

    Route::get('/upss', [EdificacionController::class, 'getUpss'])->name('infraestructura.upss');
});
