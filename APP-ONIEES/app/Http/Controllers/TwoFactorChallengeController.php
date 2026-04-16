<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class TwoFactorChallengeController extends Controller
{
    public function show()
    {
        if (!session('2fa:user:id')) {
            return redirect()->route('login');
        }
        
        return view('auth.two-factor-challenge');
    }
    
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string',
            'recovery_code' => 'nullable|string',
        ]);
        
        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Verificar si es código de recuperación
        if ($request->filled('recovery_code')) {
            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            
            // Buscar el código de recuperación
            $index = array_search($request->recovery_code, $recoveryCodes);
            
            if ($index !== false) {
                // Eliminar el código usado
                unset($recoveryCodes[$index]);
                $user->two_factor_recovery_codes = encrypt(json_encode(array_values($recoveryCodes)));
                $user->save();
                
                // Autenticar al usuario
                Auth::login($user, session('2fa:remember', false));
                session()->forget(['2fa:user:id', '2fa:remember']);
                
                return redirect()->intended('/dashboard');
            }
            
            return back()->withErrors(['recovery_code' => 'El código de recuperación es inválido.']);
        }
        
        // Verificar código normal de 2FA
        if ($request->filled('code')) {
            $provider = app(TwoFactorAuthenticationProvider::class);
            $secret = decrypt($user->two_factor_secret);
            $valid = $provider->verify($secret, $request->code);
            
            if (!$valid) {
                return back()->withErrors(['code' => 'El código de autenticación es inválido.']);
            }
            
            Auth::login($user, session('2fa:remember', false));
            session()->forget(['2fa:user:id', '2fa:remember']);
            
            return redirect()->intended('/dashboard');
        }
        
        return back()->withErrors(['code' => 'Por favor ingresa un código de verificación.']);
    }
}