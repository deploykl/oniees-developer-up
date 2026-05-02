<?php

use App\Http\Controllers\InfraestructuraController;
use App\Http\Controllers\Infraestructura\EdificacionController;
use App\Http\Controllers\Infraestructura\FotoController;
use App\Http\Controllers\Infraestructura\AcabadoController;
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

    // Rutas para Acabados
    Route::prefix('acabados')->group(function () {
        Route::get('/{idEdificacion}', [AcabadoController::class, 'show'])->name('infraestructura.acabados.show');
        Route::post('/', [AcabadoController::class, 'store'])->name('infraestructura.acabados.store');
    });

    // Rutas para Fotos
    Route::prefix('fotos')->group(function () {
        Route::get('/{idEstablecimiento}', [FotoController::class, 'index'])->name('infraestructura.fotos.index');
        Route::post('/', [FotoController::class, 'store'])->name('infraestructura.fotos.store');
        Route::post('/{id}', [FotoController::class, 'update'])->name('infraestructura.fotos.update');
        Route::delete('/{id}', [FotoController::class, 'destroy'])->name('infraestructura.fotos.destroy');
    });
    // Rutas para Archivos (tipo=2)
    Route::prefix('archivos')->group(function () {
        Route::get('/{idFormatI}', [FotoController::class, 'getArchivos'])->name('infraestructura.archivos.index');
        Route::post('/', [FotoController::class, 'storeArchivo'])->name('infraestructura.archivos.store');
        Route::delete('/{id}', [FotoController::class, 'destroy'])->name('infraestructura.archivos.destroy');
    });
    Route::get('/upss', [EdificacionController::class, 'getUpss'])->name('infraestructura.upss');
});

// Ruta de prueba para verificar autenticación (agregar al final)
