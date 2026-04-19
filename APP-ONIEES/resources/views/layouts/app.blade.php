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
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    
    <style>
        /* Estilos globales */
        .sidebar-transition {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Contenido principal - el margen se ajusta dinámicamente */
        .main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .main-content.sidebar-open {
            margin-left: 16rem; /* w-64 = 256px = 16rem */
        }
        
        .main-content.sidebar-closed {
            margin-left: 5rem; /* w-20 = 80px = 5rem */
        }
        
        /* Cuando no hay sidebar */
        .main-content.no-sidebar {
            margin-left: 0;
        }
        
        @media (max-width: 768px) {
            .main-content.sidebar-open {
                margin-left: 0;
            }
            .main-content.sidebar-closed {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    @auth
        @php
            $rutasSinSidebar = ['login', 'home', 'register', 'password.request', 'password.reset'];
            $mostrarSidebar = !in_array(request()->route()?->getName(), $rutasSinSidebar) && !request()->is('/');
        @endphp

        @if($mostrarSidebar)
            <!-- Layout con sidebar -->
            <div x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false' }" 
                 x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))"
                 class="min-h-screen bg-gray-50">
                
                <!-- Sidebar -->
                @include('layouts.sidebar')
                
                <!-- Contenido principal con margen dinámico -->
                <div class="main-content transition-all duration-300"
                     :class="sidebarOpen ? 'sidebar-open' : 'sidebar-closed'">
                    
                    <!-- Header -->
                    <div style="position: relative; z-index: 150;">
                        @include('layouts.header')
                    </div>
                    
                    @if (isset($header))
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    <main class="p-6">
                        {{ $slot }}
                    </main>

                    @include('layouts.footer')
                </div>
            </div>
        @else
            <!-- Layout sin sidebar -->
            <div>
                @include('layouts.header')
                
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main>
                    {{ $slot }}
                </main>

                @include('layouts.footer')
            </div>
        @endif
    @else
        <!-- Usuario no autenticado -->
        <div>
            @include('layouts.header')
            
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>

            @include('layouts.footer')
        </div>
    @endauth

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Sonner Toaster -->
    @livewire('sonner-toaster')

    @livewireScripts
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: localStorage.getItem('sidebarOpen') !== 'false',
                toggle() {
                    this.open = !this.open;
                    localStorage.setItem('sidebarOpen', this.open);
                }
            });
        });
           // Escuchar cambios en el sidebar para ajustar el contenido principal
    window.addEventListener('sidebar-toggled', function(e) {
        const mainContent = document.querySelector('.main-content');
        if (mainContent) {
            if (e.detail.open) {
                mainContent.classList.remove('sidebar-closed');
                mainContent.classList.add('sidebar-open');
            } else {
                mainContent.classList.remove('sidebar-open');
                mainContent.classList.add('sidebar-closed');
            }
        }
    });
    </script>
</body>

</html>