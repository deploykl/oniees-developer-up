<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\UserSession;
use App\Helpers\DeviceDetector;

class LogUserLogin
{
    public function handle(Login $event): void
    {
        if ($event->user && $event->user->id) {
            $userAgent = request()->userAgent();
            $device = DeviceDetector::detect($userAgent);
            
            // Buscar si ya existe una sesión para este usuario
            $session = UserSession::where('user_id', $event->user->id)->first();
            
            if ($session) {
                // Actualizar sesión existente
                $session->update([
                    'session_id' => session()->getId(),
                    'ip_address' => request()->ip(),
                    'user_agent' => $userAgent,
                    'device_type' => $device['device_type'],
                    'browser' => $device['browser'],
                    'os' => $device['os'],
                    'last_activity' => now(),
                    'is_online' => true,
                    'logout_at' => null,
                ]);
            } else {
                // Crear nueva sesión
                UserSession::create([
                    'user_id' => $event->user->id,
                    'session_id' => session()->getId(),
                    'ip_address' => request()->ip(),
                    'user_agent' => $userAgent,
                    'device_type' => $device['device_type'],
                    'browser' => $device['browser'],
                    'os' => $device['os'],
                    'last_activity' => now(),
                    'is_online' => true,
                    'logout_at' => null,
                ]);
            }
        }
    }
}