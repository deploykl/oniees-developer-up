<x-app-layout>
    <x-slot name="title">
        {{ config('app.name') }}
    </x-slot>

    <div class="relative overflow-hidden ">
        <!-- Fondo decorativo -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#0E7C9E]/5 rounded-full blur-3xl"></div>
            <svg class="absolute inset-0 w-full h-full opacity-[0.02]" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-6">

            <!-- Header compacto -->
            <div class="text-center mb-8 md:mb-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/70 backdrop-blur-sm border border-[#0E7C9E]/20 shadow-sm mb-3 animate-fade-in-up">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                    </span>
                    <i class="fas fa-microchip text-[#0E7C9E] text-xs"></i>
                    <span class="text-xs font-medium text-slate-600 tracking-wide">DIEM · INNOVACIÓN CONTINUA</span>
                </div>

                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tight animate-fade-in-up" style="animation-delay: 0.1s">
                    <span class="text-slate-800">DIRECCIÓN DE</span>
                    <span class="bg-gradient-to-r from-[#0E7C9E] to-[#0EA5E9] bg-clip-text text-transparent block mt-1">
                        EQUIPAMIENTO Y MANTENIMIENTO
                    </span>
                </h1>

                <p class="text-slate-500 mt-3 max-w-2xl mx-auto animate-fade-in-up text-sm" style="animation-delay: 0.2s">
                    <i class="fas fa-chart-line mr-1 text-[#0E7C9E]"></i>
                    Infraestructura y equipamiento de establecimientos de salud
                    <i class="fas fa-database ml-1 text-[#0E7C9E]"></i>
                </p>
            </div>

            <!-- Dos columnas compactas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center">

                <!-- COLUMNA IZQUIERDA - Observatorio -->
                <div class="relative animate-fade-in-left" style="animation-delay: 0.3s">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-[#0E7C9E]/30 via-[#0EA5E9]/30 to-emerald-500/30 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition duration-700"></div>
                        
                        <div class="relative bg-white/60 backdrop-blur-sm rounded-2xl p-5 md:p-6 border border-[#0E7C9E]/20 shadow-lg">
                            
                            <!-- Icono del OJO más compacto -->
                            <div class="relative w-32 h-32 md:w-44 md:h-44 mx-auto mb-4">
                                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-[#0E7C9E]/20 to-emerald-100 animate-pulse-slow"></div>
                                <div class="absolute inset-1.5 rounded-full bg-white shadow-inner"></div>
                                <div class="absolute inset-0 rounded-full flex items-center justify-center">
                                    <div class="relative w-28 h-28 md:w-36 md:h-36">
                                        <img src="{{ asset('img/icons/observatorio-icono.png') }}" alt="Observatorio"
                                            class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110"
                                            onerror="this.style.display='none'">
                                    </div>
                                </div>
                                <div class="absolute -inset-2 rounded-full border border-[#0E7C9E]/40 animate-spin-slow"></div>
                                <div class="absolute -inset-4 rounded-full border border-emerald-200/60 animate-spin-slow-reverse"></div>
                            </div>
                            
                            <div class="text-center">
                                <h2 class="text-xl md:text-2xl font-bold text-slate-800 mb-1">OBSERVATORIO NACIONAL</h2>
                                <div class="w-12 h-0.5 bg-gradient-to-r from-[#0E7C9E] to-emerald-500 mx-auto mb-3 rounded-full"></div>
                                <p class="text-slate-600 text-xs leading-relaxed">
                                    Monitoreo y análisis de infraestructura hospitalaria, equipamiento médico y mantenimiento de establecimientos de salud.
                                </p>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- COLUMNA DERECHA - Grid compacto con bordes visibles -->
                <div class="relative animate-fade-in-right" style="animation-delay: 0.4s">
                    <div class="grid grid-cols-2 gap-3 md:gap-4">
                        
                        <!-- Tarjeta 1 -->
                        <a href="/repositorio" class="group relative">
                            <div class="absolute -inset-0.5 bg-gradient-to-br from-[#0E7C9E] to-[#0EA5E9] rounded-xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                            <div class="relative bg-white rounded-xl p-4 text-center shadow-md border border-[#0E7C9E]/15 hover:border-[#0E7C9E]/30 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-lg">
                                <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-gradient-to-br from-[#0E7C9E]/15 to-[#0EA5E9]/15 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-[#0E7C9E]/10">
                                    <i class="fas fa-folder-open text-xl text-[#0E7C9E] group-hover:text-[#0EA5E9]"></i>
                                </div>
                                <h3 class="font-semibold text-sm text-slate-700 group-hover:text-[#0E7C9E] transition-colors">Repositorio</h3>
                                <p class="text-xs text-slate-400 mt-1">Documentos técnicos</p>
                            </div>
                        </a>

                        <!-- Tarjeta 2 -->
                        <a href="#" class="group relative">
                            <div class="absolute -inset-0.5 bg-gradient-to-br from-[#0E7C9E] to-[#0EA5E9] rounded-xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                            <div class="relative bg-white rounded-xl p-4 text-center shadow-md border border-[#0E7C9E]/15 hover:border-[#0E7C9E]/30 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-lg">
                                <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-gradient-to-br from-[#0E7C9E]/15 to-[#0EA5E9]/15 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-[#0E7C9E]/10">
                                    <i class="fas fa-server text-xl text-[#0E7C9E] group-hover:text-[#0EA5E9]"></i>
                                </div>
                                <h3 class="font-semibold text-sm text-slate-700 group-hover:text-[#0E7C9E] transition-colors">Infraestructura</h3>
                                <p class="text-xs text-slate-400 mt-1">Gestión de activos</p>
                            </div>
                        </a>

                        <!-- Tarjeta 3 -->
                        <a href="#" class="group relative">
                            <div class="absolute -inset-0.5 bg-gradient-to-br from-[#0E7C9E] to-[#0EA5E9] rounded-xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                            <div class="relative bg-white rounded-xl p-4 text-center shadow-md border border-[#0E7C9E]/15 hover:border-[#0E7C9E]/30 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-lg">
                                <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-gradient-to-br from-[#0E7C9E]/15 to-[#0EA5E9]/15 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-[#0E7C9E]/10">
                                    <i class="fas fa-microchip text-xl text-[#0E7C9E] group-hover:text-[#0EA5E9]"></i>
                                </div>
                                <h3 class="font-semibold text-sm text-slate-700 group-hover:text-[#0E7C9E] transition-colors">Equipamiento</h3>
                                <p class="text-xs text-slate-400 mt-1">Tecnología médica</p>
                            </div>
                        </a>

                        <!-- Tarjeta 4 -->
                        <a href="#" class="group relative">
                            <div class="absolute -inset-0.5 bg-gradient-to-br from-[#0E7C9E] to-[#0EA5E9] rounded-xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                            <div class="relative bg-white rounded-xl p-4 text-center shadow-md border border-[#0E7C9E]/15 hover:border-[#0E7C9E]/30 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-lg">
                                <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-gradient-to-br from-[#0E7C9E]/15 to-[#0EA5E9]/15 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-[#0E7C9E]/10">
                                    <i class="fas fa-tools text-xl text-[#0E7C9E] group-hover:text-[#0EA5E9]"></i>
                                </div>
                                <h3 class="font-semibold text-sm text-slate-700 group-hover:text-[#0E7C9E] transition-colors">Mantenimiento</h3>
                                <p class="text-xs text-slate-400 mt-1">Planificación</p>
                            </div>
                        </a>

                    </div>
                    
                    <!-- Texto decorativo compacto -->
                    <div class="text-center mt-4">
                        <span class="inline-flex items-center gap-2 text-xs text-slate-400">
                            <i class="fas fa-arrow-right text-[10px] text-[#0E7C9E]"></i>
                            Gestión integral de activos hospitalarios
                            <i class="fas fa-arrow-left text-[10px] text-[#0E7C9E]"></i>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in-left {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fade-in-right {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes spin-slow-reverse {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }
        .animate-fade-in-up { animation: fade-in-up 0.5s ease-out forwards; opacity: 0; }
        .animate-fade-in-left { animation: fade-in-left 0.5s ease-out forwards; opacity: 0; }
        .animate-fade-in-right { animation: fade-in-right 0.5s ease-out forwards; opacity: 0; }
        .animate-spin-slow { animation: spin-slow 12s linear infinite; }
        .animate-spin-slow-reverse { animation: spin-slow-reverse 15s linear infinite; }
        .animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
    </style>
</x-app-layout>