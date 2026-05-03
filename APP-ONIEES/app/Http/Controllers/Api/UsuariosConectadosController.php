<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserSession;
use App\Models\User;
use Illuminate\Http\Request;

class UsuariosConectadosController extends Controller
{
    public function index()
    {
        // Usuarios conectados en los últimos 5 minutos
        $timeout = now()->subMinutes(5);
        
        $onlineUsers = UserSession::with('user')
            ->where('is_online', true)
            ->where('last_activity', '>', $timeout)
            ->orderBy('last_activity', 'desc')
            ->get();
        
        // Usuarios offline (tienen sesión pero no están activos)
        $offlineUsers = UserSession::with('user')
            ->where('is_online', false)
            ->orWhere('last_activity', '<', $timeout)
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return response()->json([
            'online' => $onlineUsers->map(function($session) {
                return [
                    'id' => $session->user->id,
                    'name' => $session->user->name,
                    'email' => $session->user->email,
                    'avatar' => $session->user->avatar ?? null,
                    'last_activity' => $session->last_activity?->diffForHumans(),
                    'role' => $session->user->tipo_rol ?? 'usuario',
                ];
            }),
            'offline' => $offlineUsers->map(function($session) {
                return [
                    'id' => $session->user->id,
                    'name' => $session->user->name,
                    'email' => $session->user->email,
                    'avatar' => $session->user->avatar ?? null,
                    'last_seen' => $session->logout_at?->diffForHumans() ?? $session->updated_at->diffForHumans(),
                ];
            }),
            'total_online' => $onlineUsers->count(),
            'total_offline' => $offlineUsers->count(),
        ]);
    }
}