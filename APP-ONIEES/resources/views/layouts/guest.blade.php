<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon.png') }}">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <!-- SOLO PARA GUEST: Fondo GIF con opacidad -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
        <img src="{{ asset('img/gif/city.gif') }}" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.3;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.3);"></div>
    </div>
    
    <!-- Contenido -->
    <div style="position: relative; z-index: 1;">
        {{ $slot }}
    </div>

    <!-- Sonner Toaster - Notificaciones -->
    @livewire('sonner-toaster')

    @livewireScripts
</body>

</html>