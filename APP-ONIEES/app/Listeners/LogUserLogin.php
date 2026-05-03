<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\UserSession;

class LogUserLogin
{
    public function handle(Login $event): void
    {
        // Verificar que el usuario existe y tiene un ID
        if ($event->user && $event->user->id) {
            UserSession::updateOrCreate(
                ['user_id' => $event->user->id],
                [
                    'session_id' => session()->getId(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'last_activity' => now(),
                    'is_online' => true,
                    'logout_at' => null,
                ]
            );
        }
    }
}