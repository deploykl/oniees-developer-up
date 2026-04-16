<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Middleware\TwoFactorAuthenticated;

Route::get('/', function () {
    return view('home');
})->name('home');

// CORREGIDO: Usar el middleware completo de Fortify
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', TwoFactorAuthenticated::class])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';