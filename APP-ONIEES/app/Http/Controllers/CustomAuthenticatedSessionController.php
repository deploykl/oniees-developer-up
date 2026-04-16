<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CustomAuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();

        // Verificar si tiene 2FA habilitado (usando la columna que existe)
        if ($user->two_factor_secret && $user->two_factor_recovery_codes) {
            // Guardar remember me si está marcado
            if ($request->boolean('remember')) {
                session(['2fa:remember' => true]);
            }
            
            // Cerrar sesión parcialmente
            Auth::logout();
            session(['2fa:user:id' => $user->id]);
            
            return redirect()->route('two-factor.challenge');
        }

        // Si no tiene 2FA, proceder normalmente
        return redirect()->intended('/dashboard');
    }
}