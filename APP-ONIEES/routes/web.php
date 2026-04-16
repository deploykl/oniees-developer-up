<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomAuthenticatedSessionController;
use App\Http\Controllers\TwoFactorChallengeController;
use Illuminate\Support\Facades\Route;

// Cargar rutas de auth (Fortify)
require __DIR__.'/auth.php';

// Rutas públicas
Route::get('/', function () {
    return view('home');
})->name('home');

// Rutas de login personalizadas (sobrescriben las de Fortify)
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

// Rutas protegidas (requieren autenticación completa)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Debug (temporal)
Route::get('/debug-2fa', function () {
    $user = auth()->user();
    if ($user) {
        dd([
            'user_id' => $user->id,
            'email' => $user->email,
            'two_factor_confirmed_at' => $user->two_factor_confirmed_at,
            'has_two_factor_secret' => !is_null($user->two_factor_secret),
            'two_factor_enabled' => $user->two_factor_confirmed_at !== null,
            'session_2fa_user' => session('2fa:user:id'),
            'is_authenticated' => auth()->check(),
        ]);
    }
    return 'No logged in';
})->middleware(['auth']);

Route::get('/debug-session', function () {
    dd(session()->all());
});