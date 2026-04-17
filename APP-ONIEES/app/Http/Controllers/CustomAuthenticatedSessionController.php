<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

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

        // Verificar si tiene 2FA habilitado
        if ($user->two_factor_secret) {
            // Guardar remember me si está marcado
            if ($request->boolean('remember')) {
                session(['2fa:remember' => true]);
            }
            
            // Guardar el ID del usuario en sesión antes de cerrar sesión
            session(['2fa:user:id' => $user->id]);
            session(['2fa:user:email' => $user->email]);
            
            // Cerrar sesión parcialmente
            Auth::logout();
            
            return redirect()->route('two-factor.challenge');
        }

        // Si no tiene 2FA, proceder normalmente
        return redirect()->intended('/dashboard');
    }
}