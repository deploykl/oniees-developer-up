<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserSession;
use App\Helpers\DeviceDetector;
use Illuminate\Http\Request;

class UsuariosConectadosController extends Controller
{
    // Para la vista HTML
    public function view()
    {
        return view('admin.usuarios-conectados');
    }
    
    // Para la API JSON
    public function index()
    {
        $timeout = now()->subMinutes(5);
        
        $onlineUsers = UserSession::with('user')
            ->where('is_online', true)
            ->where('last_activity', '>', $timeout)
            ->orderBy('last_activity', 'desc')
            ->get();
        
        // Usuarios offline recientes (últimas 24 horas)
        $offlineUsers = UserSession::with('user')
            ->where('is_online', false)
            ->where('last_activity', '>', now()->subHours(24))
            ->orderBy('last_activity', 'desc')
            ->get();
        
        return response()->json([
            'online' => $onlineUsers->map(function($session) {
                $device_type = $session->device_type;
                $browser = $session->browser;
                $os = $session->os;
                
                if (!$device_type || !$browser || !$os) {
                    $detected = DeviceDetector::detect($session->user_agent);
                    $device_type = $device_type ?? $detected['device_type'];
                    $browser = $browser ?? $detected['browser'];
                    $os = $os ?? $detected['os'];
                }
                
                return [
                    'id' => $session->user->id,
                    'name' => $session->user->name,
                    'email' => $session->user->email,
                    'role' => $session->user->tipo_rol ?? 'usuario',
                    'last_activity' => $session->last_activity?->diffForHumans(),
                    'device_type' => $device_type ?? 'desktop',
                    'browser' => $browser ?? 'desconocido',
                    'os' => $os ?? 'desconocido',
                    'device_icon' => DeviceDetector::getIcon($device_type ?? 'desktop', $browser ?? 'desconocido', $os ?? 'desconocido'),
                ];
            }),
            'total_online' => $onlineUsers->count(),
            'offline' => $offlineUsers->map(function($session) {
                return [
                    'id' => $session->user->id,
                    'name' => $session->user->name,
                    'email' => $session->user->email,
                    'role' => $session->user->tipo_rol ?? 'usuario',
                    'last_seen' => $session->logout_at?->diffForHumans() ?? $session->last_activity?->diffForHumans(),
                ];
            }),
            'total_offline' => $offlineUsers->count(),
        ]);
    }
}