<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class LogUserLogout
{
    public function handle(Logout $event): void
    {
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        
        if ($userId) {
            UserSession::where('user_id', $userId)->update([
                'is_online' => false,
                'logout_at' => now(),
            ]);
        } else if ($event->user && $event->user->id) {
            UserSession::where('user_id', $event->user->id)->update([
                'is_online' => false,
                'logout_at' => now(),
            ]);
        }
    }
}