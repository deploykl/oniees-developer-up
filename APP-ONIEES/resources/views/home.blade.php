<x-app-layout>
    <x-slot name="title">
        {{ config('app.name') }}
    </x-slot>

    <div class="relative bg-gradient-to-br from-slate-50 via-white to-slate-100 overflow-x-clip flex items-center mt-10">
        <div class="max-w-7xl mx-auto w-full relative z-10">
            
            <!-- Título centrado arriba -->
            <div class="text-center mb-5">
                <div class="inline-flex items-center gap-3 bg-white/70 backdrop-blur-sm px-5 py-2 rounded-full border border-slate-200/60 shadow-sm mb-8">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <i class="fas fa-microchip text-slate-500 text-sm"></i>
                    <span class="text-sm font-medium text-slate-600 tracking-wide">DIEM · innovación continua</span>
                </div>
                
                <h1 class="text-slate-800 text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight">
                    DIRECCIÓN DE EQUIPAMIENTO Y MANTENIMIENTO
                    <span class="bg-gradient-to-r from-slate-700 to-slate-500 bg-clip-text text-transparent text-4xl md:text-5xl lg:text-6xl font-extrabold ml-2">DIEM</span>
                </h1>
            </div>
            
            <!-- Dos columnas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                
                <!-- COLUMNA IZQUIERDA -->
                <div class="text-center lg:text-left">
                    <!-- Icono GRANDE con efecto sutil -->
                    <div class="relative w-64 h-64 md:w-80 md:h-80 mx-auto lg:mx-0 mb-8">
                        <div class="absolute -inset-3 rounded-full border border-slate-200/40 animate-[spin_20s_linear_infinite]"></div>
                        <div class="w-full h-full bg-white/60 backdrop-blur-sm rounded-full flex items-center justify-center border border-slate-200/50 shadow-lg transition-all duration-500 hover:shadow-xl hover:shadow-slate-200/50">
                            <img src="{{ asset('img/icons/observatorio-icono.png') }}" alt="Observatorio" class="w-3/4 transition-transform duration-500 hover:scale-105" onerror="this.style.display='none'">
                        </div>
                    </div>
                    
                    <!-- Subtítulos -->
                    <div class="mb-6">
                        <div class="relative inline-block">
                            <span class="text-2xl md:text-3xl font-semibold text-slate-700">OBSERVATORIO NACIONAL</span>
                            <div class="absolute -bottom-2 left-0 w-full h-0.5 bg-gradient-to-r from-slate-400 to-slate-300"></div>
                        </div>
                    </div>
                    
                    <p class="text-slate-500 text-sm md:text-base flex items-center justify-center lg:justify-start gap-3 flex-wrap mt-4">
                        <i class="fas fa-chart-line text-slate-400"></i>
                        <span>Infraestructura y equipamiento de establecimientos de salud</span>
                        <i class="fas fa-database text-slate-400"></i>
                    </p>
                    
                </div>
                
                <!-- COLUMNA DERECHA: Imágenes GRID 2x2 con efectos sutiles -->
                <div class="relative">
                    <div class="grid grid-cols-2 gap-8 md:gap-10 max-w-md mx-auto">
                        
                        <!-- Dashboard -->
                        <div class="group text-center">
                            <div class="relative mb-3">
                                <div class="absolute inset-0 rounded-full bg-slate-100 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                                <img src="{{ asset('img/icons/dashboard-1.png') }}" alt="dashboard" 
                                    class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover bg-white shadow-md border-2 border-white transition-all duration-400 group-hover:scale-105 group-hover:shadow-lg group-hover:border-slate-300 mx-auto"
                                    onerror="this.style.display='none'">
                            </div>
                            <span class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">Dashboard</span>
                        </div>
                        
                        <!-- Métricas -->
                        <div class="group text-center">
                            <div class="relative mb-3">
                                <div class="absolute inset-0 rounded-full bg-slate-100 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                                <img src="{{ asset('img/icons/dashboard-2.png') }}" alt="métrica" 
                                    class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover bg-white shadow-md border-2 border-white transition-all duration-400 group-hover:scale-105 group-hover:shadow-lg group-hover:border-slate-300 mx-auto"
                                    onerror="this.style.display='none'">
                            </div>
                            <span class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">Métricas</span>
                        </div>
                        
                        <!-- Infraestructura -->
                        <div class="group text-center">
                            <div class="relative mb-3">
                                <div class="absolute inset-0 rounded-full bg-slate-100 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                                <img src="{{ asset('img/icons/dashboard-3.png') }}" alt="infraestructura" 
                                    class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover bg-white shadow-md border-2 border-white transition-all duration-400 group-hover:scale-105 group-hover:shadow-lg group-hover:border-slate-300 mx-auto"
                                    onerror="this.style.display='none'">
                            </div>
                            <span class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">Infraestructura</span>
                        </div>
                        
                        <!-- Equipamiento -->
                        <div class="group text-center">
                            <div class="relative mb-3">
                                <div class="absolute inset-0 rounded-full bg-slate-100 scale-0 group-hover:scale-100 transition-transform duration-500"></div>
                                <img src="{{ asset('img/icons/dashboard-4.png') }}" alt="equipamiento" 
                                    class="w-32 h-32 md:w-36 md:h-36 rounded-full object-cover bg-white shadow-md border-2 border-white transition-all duration-400 group-hover:scale-105 group-hover:shadow-lg group-hover:border-slate-300 mx-auto"
                                    onerror="this.style.display='none'">
                            </div>
                            <span class="text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">Equipamiento</span>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
        
        <!-- Partículas decorativas sutiles -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute w-1 h-1 bg-slate-300 rounded-full opacity-30 animate-float-slow" style="left: 5%; top: 15%; animation-duration: 14s;"></div>
            <div class="absolute w-1.5 h-1.5 bg-slate-400 rounded-full opacity-20 animate-float-slow" style="left: 15%; top: 75%; animation-duration: 10s; animation-delay: 2s;"></div>
            <div class="absolute w-1 h-1 bg-slate-300 rounded-full opacity-30 animate-float-slow" style="left: 88%; top: 10%; animation-duration: 16s; animation-delay: 1s;"></div>
            <div class="absolute w-0.5 h-0.5 bg-slate-400 rounded-full opacity-20 animate-float-slow" style="left: 92%; top: 80%; animation-duration: 11s; animation-delay: 3s;"></div>
            <div class="absolute w-1 h-1 bg-slate-300 rounded-full opacity-30 animate-float-slow" style="left: 40%; top: 85%; animation-duration: 13s; animation-delay: 0.5s;"></div>
            <div class="absolute w-1.5 h-1.5 bg-slate-400 rounded-full opacity-20 animate-float-slow" style="left: 75%; top: 55%; animation-duration: 15s; animation-delay: 4s;"></div>
        </div>
    </div>

    <style>
        /* Animaciones sutiles y elegantes */
        @keyframes fade-scale {
            0% {
                opacity: 0;
                transform: scale(0.92);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes float-slow {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            15% {
                opacity: 0.4;
            }
            85% {
                opacity: 0.2;
            }
            100% {
                transform: translateY(-100vh) translateX(30px);
                opacity: 0;
            }
        }
        
        /* Aplicar animación de entrada a las imágenes */
        .grid-cols-2 .group:nth-child(1) { animation: fade-scale 0.5s ease-out 0s backwards; }
        .grid-cols-2 .group:nth-child(2) { animation: fade-scale 0.5s ease-out 0.1s backwards; }
        .grid-cols-2 .group:nth-child(3) { animation: fade-scale 0.5s ease-out 0.2s backwards; }
        .grid-cols-2 .group:nth-child(4) { animation: fade-scale 0.5s ease-out 0.3s backwards; }
        
        .animate-float-slow {
            animation: float-slow 12s linear infinite;
        }
        
        /* Efecto de transición más suave para las imágenes */
        .group img {
            transition-timing-function: cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        
        /* Scrollbar elegante */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <script>
        (function() {
            // Fallback elegante para imágenes que no cargan
            document.querySelectorAll('.grid-cols-2 img').forEach(img => {
                img.addEventListener('error', function() {
                    const parent = this.closest('.group');
                    if (parent) {
                        const placeholder = document.createElement('div');
                        placeholder.className = 'w-32 h-32 md:w-36 md:h-36 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center shadow-md mx-auto';
                        placeholder.innerHTML = '<i class="fas fa-image text-slate-300 text-2xl"></i>';
                        this.parentNode.insertBefore(placeholder, this);
                        this.remove();
                    }
                });
            });
            
            // Efecto parallax suave y elegante en desktop
            if (window.innerWidth > 1024) {
                const rightColumn = document.querySelector('.lg\\:grid-cols-2 > div:last-child');
                if (rightColumn) {
                    rightColumn.addEventListener('mousemove', function(e) {
                        const rect = this.getBoundingClientRect();
                        const x = (e.clientX - rect.left) / rect.width - 0.5;
                        const y = (e.clientY - rect.top) / rect.height - 0.5;
                        
                        const cards = this.querySelectorAll('.group');
                        cards.forEach((card, idx) => {
                            const speed = 8 + idx * 2;
                            const moveX = x * speed;
                            const moveY = y * speed;
                            card.style.transform = `translate(${moveX}px, ${moveY}px)`;
                        });
                    });
                    
                    rightColumn.addEventListener('mouseleave', function() {
                        const cards = this.querySelectorAll('.group');
                        cards.forEach(card => {
                            card.style.transform = '';
                        });
                    });
                }
            }
        })();
    </script>
</x-app-layout>