<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomAuthenticatedSessionController;
use App\Http\Controllers\TwoFactorChallengeController;
use App\Http\Controllers\Public\RepositorioController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\SubcategoryController;

// Cargar rutas de auth (Fortify)
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/infraestructura.php';

// ============================================
// RUTAS PÚBLICAS
// ============================================

Route::get('/', function () {
    return view('home');
})->name('home');

// Repositorio público
Route::get('/repositorio', [RepositorioController::class, 'index'])->name('repositorio.index');
Route::get('/repositorio/recurso/{resource}', [RepositorioController::class, 'view'])->name('repositorio.view');


// ============================================
// RUTAS DE LOGIN (sobrescriben Fortify)
// ============================================

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [CustomAuthenticatedSessionController::class, 'store']);

    // Rutas 2FA challenge
    Route::get('/two-factor-challenge', [TwoFactorChallengeController::class, 'show'])
        ->name('two-factor.challenge');

    Route::post('/two-factor-challenge', [TwoFactorChallengeController::class, 'verify'])
        ->name('two-factor.verify');
});


// ============================================
// RUTAS PROTEGIDAS (requieren autenticación)
// ============================================

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ============================================
    // ADMIN - REPOSITORIO (TODO EN MODALES)
    // ============================================

    // Dentro de Route::middleware(['auth'])->group
    Route::prefix('admin')->name('admin.')->group(function () {
        // Categorías (vista principal)
        Route::get('repositorio/categories', [CategoryController::class, 'index'])->name('repositorio.categories');

        // Recursos por subcategoría
        Route::get('repositorio/resources/{subcategory}', [ResourceController::class, 'index'])->name('repositorio.resources');

        // API endpoints
        Route::prefix('repositorio/api')->name('repositorio.api.')->group(function () {
            Route::post('categories', [CategoryController::class, 'store']);
            Route::put('categories/{category}', [CategoryController::class, 'update']);
            Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

            Route::post('subcategories', [SubcategoryController::class, 'store']);
            Route::put('subcategories/{subcategory}', [SubcategoryController::class, 'update']);
            Route::delete('subcategories/{subcategory}', [SubcategoryController::class, 'destroy']);

            Route::post('resources', [ResourceController::class, 'store']);
            Route::put('resources/{resource}', [ResourceController::class, 'update']);
            Route::delete('resources/{resource}', [ResourceController::class, 'destroy']);
        });
    });
});


// ============================================
// RUTAS DE DEBUG (solo para pruebas)
// ============================================

Route::get('/debug-session', function () {
    dd(session()->all());
});
Route::get('/test-insert-foto', function() {
    try {
        $foto = new \App\Models\FormatIFiles();
        $foto->id_format_i = 4;
        $foto->tipo = 1;
        $foto->nombre = 'test.jpg';
        $foto->url = '/storage/test.jpg';
        $foto->size = '10 KB';
        $foto->user_id = 1;
        $foto->save();
        
        return "Insertado correctamente con ID: " . $foto->id;
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
