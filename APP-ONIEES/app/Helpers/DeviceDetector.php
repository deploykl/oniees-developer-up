<?php

namespace App\Helpers;

class DeviceDetector
{
    public static function detect($userAgent)
    {
        if (!$userAgent) {
            return [
                'device_type' => 'desktop',
                'browser' => 'Desconocido',
                'os' => 'Desconocido'
            ];
        }

        // Detectar dispositivo
        $device_type = 'desktop';
        if (preg_match('/(tablet|ipad|playbook|kindle|silk)/i', $userAgent)) {
            $device_type = 'tablet';
        } elseif (preg_match('/(mobile|iphone|ipod|android|windows phone|blackberry|opera mini|iemobile)/i', $userAgent)) {
            $device_type = 'mobile';
        }

        // Detectar navegador
        $browser = 'Otro';
        if (preg_match('/(Edg|Edge)/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edg|Edge|OPR|Brave/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome|Edg|Edge|OPR/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Firefox|FxiOS/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Brave/i', $userAgent)) {
            $browser = 'Brave';
        }

        // Detectar sistema operativo
        $os = 'Otro';
        if (preg_match('/Windows/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac OS X|Macintosh/i', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent) && !preg_match('/Android/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $os = 'iOS';
        }

        return [
            'device_type' => $device_type,
            'browser' => $browser,
            'os' => $os,
        ];
    }

    public static function getIcon($device_type, $browser, $os)
    {
        $icons = [];
        
        // Icono según dispositivo
        switch ($device_type) {
            case 'mobile':
                $icons[] = '<i class="fas fa-mobile-alt text-gray-500" title="Móvil"></i>';
                break;
            case 'tablet':
                $icons[] = '<i class="fas fa-tablet-alt text-gray-500" title="Tablet"></i>';
                break;
            default:
                $icons[] = '<i class="fas fa-desktop text-gray-500" title="Escritorio"></i>';
                break;
        }
        
        // Icono según navegador
        switch ($browser) {
            case 'Chrome':
                $icons[] = '<i class="fab fa-chrome text-green-600" title="Chrome"></i>';
                break;
            case 'Firefox':
                $icons[] = '<i class="fab fa-firefox text-orange-600" title="Firefox"></i>';
                break;
            case 'Safari':
                $icons[] = '<i class="fab fa-safari text-blue-600" title="Safari"></i>';
                break;
            case 'Edge':
                $icons[] = '<i class="fab fa-edge text-blue-600" title="Edge"></i>';
                break;
            case 'Opera':
                $icons[] = '<i class="fab fa-opera text-red-600" title="Opera"></i>';
                break;
        }
        
        // Icono según SO
        switch ($os) {
            case 'Windows':
                $icons[] = '<i class="fab fa-windows text-blue-500" title="Windows"></i>';
                break;
            case 'macOS':
                $icons[] = '<i class="fab fa-apple text-gray-600" title="macOS"></i>';
                break;
            case 'Android':
                $icons[] = '<i class="fab fa-android text-green-500" title="Android"></i>';
                break;
            case 'iOS':
                $icons[] = '<i class="fab fa-apple text-gray-600" title="iOS"></i>';
                break;
            case 'Linux':
                $icons[] = '<i class="fab fa-linux text-yellow-600" title="Linux"></i>';
                break;
        }
        
        return implode(' ', $icons);
    }
}