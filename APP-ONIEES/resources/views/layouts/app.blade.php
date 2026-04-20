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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            overflow-x: hidden;
        }

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

        /* Transiciones suaves */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Flex utilities */
        .flex-1 {
            flex: 1 1 0%;
            min-height: 0;
        }

        .flex-shrink-0 {
            flex-shrink: 0;
        }

        .min-h-screen {
            min-height: 100vh;
        }
    </style>
</head>

<body>
    @auth
        @php
            $rutasSinSidebar = ['login', 'home', 'register', 'password.request', 'password.reset'];
            $mostrarSidebar = !in_array(request()->route()?->getName(), $rutasSinSidebar) && !request()->is('/');
        @endphp

        @if ($mostrarSidebar)
            <!-- Layout con sidebar -->
            <div x-data="{
                get sidebarOpen() { return $store.sidebar.open },
                get isMobile() { return $store.sidebar.isMobile }
            }" class="min-h-screen bg-gray-50">

                <!-- Overlay para móvil -->
                <div class="fixed inset-0 bg-black/50 z-[199] transition-opacity duration-300 md:hidden"
                    :class="{ 'opacity-100 visible': isMobile && sidebarOpen, 'opacity-0 invisible': !(isMobile &&
                        sidebarOpen) }"
                    @click="$store.sidebar.setOpen(false)"></div>

                <!-- Sidebar -->
                <div class="fixed left-0 top-0 h-full z-[200] transition-all duration-300"
                    :class="{
                        'w-64': sidebarOpen,
                        'w-20': !sidebarOpen,
                        'translate-x-0': !isMobile || sidebarOpen,
                        '-translate-x-full': isMobile && !sidebarOpen
                    }">
                    @include('layouts.sidebar')
                </div>

                <!-- Botón flotante para móvil -->
                <button x-show="isMobile && !sidebarOpen" @click="$store.sidebar.setOpen(true)"
                    class="fixed left-4 top-3 z-[999] p-2.5 bg-white rounded-xl shadow-lg text-gray-600 hover:bg-blue-50 transition md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Contenido principal -->
                <div class="transition-all duration-300 min-h-screen flex flex-col"
                    :style="{
                        marginLeft: !isMobile ? (sidebarOpen ? '16rem' : '5rem') : '0',
                        width: !isMobile ? (sidebarOpen ? 'calc(100% - 16rem)' : 'calc(100% - 5rem)') : '100%'
                    }">

                    <!-- Header -->
                    <div class="flex-shrink-0" style="position: relative; z-index: 150;">
                        @include('layouts.header')
                    </div>

                    <!-- Header opcional -->
                    @if (isset($header))
                        <header class="bg-white shadow flex-shrink-0">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    <!-- Main content -->
                    <main class="flex-1 p-6">
                        {{ $slot }}
                    </main>

                    <!-- Footer -->
                    <footer class="flex-shrink-0">
                        @include('layouts.footer')
                    </footer>
                </div>
            </div>
        @else
            <!-- Layout sin sidebar -->
            <div class="min-h-screen flex flex-col">
                @include('layouts.header')

                @if (isset($header))
                    <header class="bg-white shadow flex-shrink-0">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="flex-1">
                    {{ $slot }}
                </main>

                <footer class="flex-shrink-0">
                    @include('layouts.footer')
                </footer>
            </div>
        @endif
    @else
        <!-- Usuario no autenticado -->
        <div class="min-h-screen flex flex-col">
            @include('layouts.header')

            @if (isset($header))
                <header class="bg-white shadow flex-shrink-0">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="flex-shrink-0">
                @include('layouts.footer')
            </footer>
        </div>
    @endauth

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Sonner Toaster -->
    @livewire('sonner-toaster')

    @livewireScripts

    <script>
        // Store global para el sidebar
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: localStorage.getItem('sidebarOpen') !== 'false',
                isMobile: window.innerWidth <= 768,

                init() {
                    // Si es móvil y está abierto, cerrar
                    if (this.isMobile && this.open) {
                        this.open = false;
                        localStorage.setItem('sidebarOpen', false);
                    }
                },

                toggle() {
                    this.open = !this.open;
                    localStorage.setItem('sidebarOpen', this.open);
                    // Disparar evento para notificar cambios
                    window.dispatchEvent(new CustomEvent('sidebar-state-change', {
                        detail: {
                            open: this.open
                        }
                    }));
                },

                setOpen(value) {
                    this.open = value;
                    localStorage.setItem('sidebarOpen', value);
                    window.dispatchEvent(new CustomEvent('sidebar-state-change', {
                        detail: {
                            open: value
                        }
                    }));
                },

                checkMobile() {
                    const wasMobile = this.isMobile;
                    this.isMobile = window.innerWidth <= 768;

                    // Si cambia de móvil a desktop y estaba cerrado, abrir
                    if (wasMobile && !this.isMobile && !this.open) {
                        this.setOpen(true);
                    }
                    // Si cambia de desktop a móvil y estaba abierto, cerrar
                    if (!wasMobile && this.isMobile && this.open) {
                        this.setOpen(false);
                    }
                }
            });

            // Escuchar resize
            window.addEventListener('resize', () => {
                Alpine.store('sidebar').checkMobile();
            });
        });
    </script>
</body>

</html>
