<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', config('app.name', 'ONIEES'))</title>
    <meta name="description" content="@yield('description', 'Sistema de monitoreo de infraestructura y equipamiento de establecimientos de salud — DIEM MINSA Perú')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- CSS adicional por página -->
    @stack('styles')
    
    <style>
        /* Estilos globales base */
        

        /* Utilidades globales */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }
        }
    </style>
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Si usas Vite --}}
</head>
<body>
    @include('layouts.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <!-- Scripts base -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejo elegante de errores de imágenes
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    this.style.opacity = '0';
                    this.style.display = 'none';
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>