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

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Verificar si tiene 2FA habilitado Y confirmado
            if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
                session(['login.id' => $user->id]);
                session(['remember' => $remember]);
                Auth::logout();
                
                return redirect()->route('two-factor.challenge');
            }

            $userName = $user->name . ' ' . ($user->lastname ?? '');
            
            // ✅ SOLO CAMBIA ESTO - redirige a /dashboard con parámetro loading
            return redirect()->to('/dashboard?loading=1')
                ->with('toast_message', "¡Bienvenido {$userName}!")
                ->with('toast_type', 'success');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}