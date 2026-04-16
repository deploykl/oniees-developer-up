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
            'code' => 'required|string',
        ]);
        
        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Usar el provider de Fortify
        $provider = app(TwoFactorAuthenticationProvider::class);
        $secret = decrypt($user->two_factor_secret);
        $valid = $provider->verify($secret, $request->code);
        
        if (!$valid) {
            return back()->withErrors(['code' => 'El código de autenticación de dos factores es inválido.']);
        }
        
        Auth::login($user, session('2fa:remember', false));
        session()->forget(['2fa:user:id', '2fa:remember']);
        
        return redirect()->intended('/dashboard');
    }
}