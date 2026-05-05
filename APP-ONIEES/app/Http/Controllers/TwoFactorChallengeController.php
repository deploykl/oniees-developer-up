<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class TwoFactorChallengeController extends Controller
{
    public function show()
    {
        // Verificar si hay un usuario en sesión para 2FA
        $userId = session('login.id');
        
        if (!$userId && !session('2fa:user:id')) {
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
        
        // Obtener el ID del usuario (desde sesión de login o 2FA)
        $userId = session('login.id') ?? session('2fa:user:id');
        
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Verificar código de recuperación
        if ($request->filled('recovery_code')) {
            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            
            $index = array_search($request->recovery_code, $recoveryCodes);
            
            if ($index !== false) {
                unset($recoveryCodes[$index]);
                $user->two_factor_recovery_codes = encrypt(json_encode(array_values($recoveryCodes)));
                $user->save();
                
                Auth::login($user, $request->session()->get('remember', false));
                $request->session()->forget(['login.id', '2fa:user:id', 'remember']);
                
                // ✅ CAMBIO 1: agregar ?loading=1
                return redirect()->to('/dashboard?loading=1');
            }
            
            return back()->withErrors(['recovery_code' => 'Código de recuperación inválido.']);
        }
        
        // Verificar código 2FA normal
        if ($request->filled('code')) {
            $provider = app(TwoFactorAuthenticationProvider::class);
            $secret = decrypt($user->two_factor_secret);
            
            // Verificar el código con tolerancia de tiempo
            $valid = $provider->verify($secret, $request->code);
            
            if ($valid) {
                // Confirmar 2FA si no está confirmado
                if (is_null($user->two_factor_confirmed_at)) {
                    $user->forceFill([
                        'two_factor_confirmed_at' => now(),
                    ])->save();
                }
                
                Auth::login($user, $request->session()->get('remember', false));
                $request->session()->forget(['login.id', '2fa:user:id', 'remember']);
                
                // ✅ CAMBIO 2: agregar ?loading=1
                return redirect()->to('/dashboard?loading=1');
            }
            
            return back()->withErrors(['code' => 'El código de verificación es inválido.']);
        }
        
        return back()->withErrors(['code' => 'Por favor ingresa un código de verificación.']);
    }
}