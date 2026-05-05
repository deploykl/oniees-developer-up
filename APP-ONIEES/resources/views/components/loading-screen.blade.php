@props(['show' => false, 'duration' => 5000, 'theme' => 'dark', 'user' => null])

@php
    // Si no se pasa un usuario explícito, intentar obtener del auth global
    if (!$user && function_exists('auth') && auth()->check()) {
        $user = auth()->user();
    }
    
    $userName = $user ? ($user->name ?? '') : '';
    $userLastname = $user ? ($user->lastname ?? '') : '';
    $fullName = trim($userName . ' ' . $userLastname);
    $firstName = explode(' ', $userName)[0] ?? $userName;
    
    // Si no hay nombre, usar un saludo genérico
    if (empty($fullName)) {
        $fullName = 'Visitante';
        $firstName = 'Usuario';
    }
@endphp

<div x-data="{
    show: {{ $show ? 'true' : 'false' }},
    duration: {{ $duration }},
    theme: '{{ $theme }}',
    countdown: Math.ceil({{ $duration }} / 1000),
    startTime: null,
    interval: null,
    progress: 0,
    isExiting: false,
    showScanLine: false,
    
    init() {
        if (this.show) {
            this.startLoading();
        }
    },
    
    startLoading() {
        this.startTime = Date.now();
        this.isExiting = false;
        this.showScanLine = false;
        this.startCountdown();
    },
    
    startCountdown() {
        this.interval = setInterval(() => {
            if (this.isExiting) return;
            
            const elapsed = Date.now() - this.startTime;
            this.countdown = Math.max(0, Math.ceil((this.duration - elapsed) / 1000));
            this.progress = Math.min(100, (elapsed / this.duration) * 100);
            
            if (elapsed >= this.duration) {
                this.startExit();
            }
        }, 16);
    },
    
    startExit() {
        if (this.isExiting) return;
        
        this.isExiting = true;
        this.showScanLine = true;
        
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
        
        setTimeout(() => {
            this.show = false;
            this.$el.remove();
            
            const url = new URL(window.location.href);
            if (url.searchParams.has('loading')) {
                url.searchParams.delete('loading');
                window.history.replaceState({}, document.title, url.toString());
            }
        }, 600);
    }
}" x-init="init()" x-show="show" x-cloak>
    
    <div class="fixed inset-0 z-[9999] flex items-center justify-center"
         :class="theme === 'dark' ? 'bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900' : 'bg-gradient-to-br from-slate-100 via-white to-slate-50'">
        
        <!-- Grid de fondo -->
        <div class="absolute inset-0 overflow-hidden opacity-10">
            <div class="absolute inset-0"
                 style="background-image: linear-gradient(var(--grid-color) 1px, transparent 1px), linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
                        background-size: 40px 40px;">
            </div>
            <style>
                .theme-grid-dark { --grid-color: rgba(255,255,255,0.1); }
                .theme-grid-light { --grid-color: rgba(0,0,0,0.1); }
            </style>
        </div>

        <!-- Círculos decorativos -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse-slower"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-cyan-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Efecto de desvanecimiento de salida -->
        <div class="absolute inset-0 z-10 transition-all duration-500 pointer-events-none"
             :class="isExiting ? 'bg-black/20 backdrop-blur-sm' : 'bg-transparent backdrop-blur-none'"></div>

        <!-- Contenido principal -->
        <div class="relative z-20 text-center space-y-8 transition-all duration-500 max-w-md w-full mx-6"
             :class="[
                 isExiting ? 'opacity-0 scale-95' : 'opacity-100 scale-100'
             ]">
            
            <!-- Logo / Icono principal -->
            <div class="relative mx-auto w-24 h-24">
                <!-- Anillo exterior -->
                <div class="absolute inset-0 rounded-full border-2 border-blue-500/30 animate-ping-slow"></div>
                
                <!-- Círculo central con gradiente -->
                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/25 animate-spin-slow">
                    <div class="absolute inset-1 rounded-full bg-slate-900 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                  d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Bienvenida personalizada -->
            <div class="space-y-3">
                <div class="flex flex-col items-center gap-1">
                    <span class="text-sm font-mono tracking-wider text-blue-400 uppercase animate-fade-in">Bienvenido/a</span>
                    <h1 class="text-3xl font-bold tracking-tight bg-gradient-to-r from-blue-400 via-cyan-400 to-purple-400 bg-clip-text text-transparent"
                        :class="theme === 'dark' ? 'text-white' : 'text-slate-800'">
                        {{ $fullName }}
                    </h1>
                </div>
                <p class="text-sm font-mono tracking-wider"
                   :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                    <span x-text="Math.floor(progress)"></span>% COMPLETADO
                </p>
            </div>

            <!-- Barra de progreso tipo terminal -->
            <div class="space-y-3">
                <div class="relative w-full h-1 bg-slate-700/30 rounded-full overflow-hidden">
                    <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-blue-500 via-cyan-500 to-blue-500 transition-all duration-100"
                         :style="{ width: progress + '%' }">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>
                    </div>
                </div>
                
                <!-- Contador tipo terminal con mensaje personalizado -->
                <div class="flex justify-center items-center gap-3 font-mono text-xs"
                     :class="theme === 'dark' ? 'text-slate-500' : 'text-slate-400'">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span>PREPARANDO TU ESPACIO</span>
                    <span class="text-blue-400" x-text="countdown + 's'"></span>
                </div>
            </div>

            <!-- Terminal de estado con bienvenida animada -->
            <div class="mt-6 text-left font-mono text-xs space-y-1.5 p-4 rounded-lg border"
                 :class="theme === 'dark' ? 'bg-slate-800/50 border-slate-700' : 'bg-white/50 border-slate-200'">
                <div class="flex items-center gap-2 animate-slide-down">
                    <span class="text-green-500">➜</span>
                    <span class="text-slate-400">_</span>
                    <span class="text-blue-400">Hola {{ $firstName }}, estamos preparando todo...</span>
                    <div class="flex gap-0.5">
                        <div class="w-1 h-3 bg-blue-500 animate-type1"></div>
                        <div class="w-1 h-3 bg-blue-500 animate-type2"></div>
                        <div class="w-1 h-3 bg-blue-500 animate-type3"></div>
                    </div>
                </div>
                <div class="flex items-center gap-2 transition-opacity duration-300"
                     :class="progress > 20 ? 'opacity-100' : 'opacity-0'">
                    <span class="text-green-500">✓</span>
                    <span class="text-slate-400">Sesión iniciada como <span class="text-blue-400">{{ $fullName }}</span></span>
                </div>
                <div class="flex items-center gap-2 transition-opacity duration-300"
                     :class="progress > 40 ? 'opacity-100' : 'opacity-0'">
                    <span class="text-green-500">✓</span>
                    <span class="text-slate-400">Cargando tu perfil y preferencias</span>
                </div>
                <div class="flex items-center gap-2 transition-opacity duration-300"
                     :class="progress > 60 ? 'opacity-100' : 'opacity-0'">
                    <span class="text-green-500">✓</span>
                    <span class="text-slate-400">Conexión segura establecida</span>
                </div>
                <div class="flex items-center gap-2 transition-opacity duration-300"
                     :class="progress > 80 ? 'opacity-100' : 'opacity-0'">
                    <span class="text-green-500">✓</span>
                    <span class="text-slate-400">Redirigiendo al panel principal...</span>
                </div>
            </div>

            <!-- Footer con información del usuario -->
            <div class="pt-4 text-[10px] font-mono space-y-1"
                 :class="theme === 'dark' ? 'text-slate-600' : 'text-slate-300'">
                <div class="flex justify-center gap-2">
                    <span>──</span>
                    <span>Bienvenido a tu Dashboard</span>
                    <span>──</span>
                </div>
                <div class="tracking-wider flex justify-center gap-2">
                    <span>👤</span>
                    <span>ID: {{ $user->id ?? '—' }}</span>
                    <span>✦</span>
                    <span>{{ $user->email ?? '' }}</span>
                </div>
            </div>
        </div>

        <!-- Línea de escaneo final -->
        <div x-show="showScanLine" 
             x-cloak
             class="absolute inset-0 z-30 pointer-events-none overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-cyan-500/30 via-blue-500/20 to-transparent animate-scan-line"></div>
        </div>
    </div>
</div>

<style>
/* Animaciones clave */
@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes ping-slow {
    0% { transform: scale(1); opacity: 0.4; }
    50% { transform: scale(1.3); opacity: 0.1; }
    100% { transform: scale(1.6); opacity: 0; }
}

@keyframes pulse-slow {
    0%, 100% { opacity: 0.1; transform: scale(1); }
    50% { opacity: 0.2; transform: scale(1.1); }
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@keyframes type-blink {
    0%, 100% { opacity: 1; height: 3px; }
    50% { opacity: 0.3; height: 8px; }
}

@keyframes scan-line {
    0% { transform: translateY(-100%); opacity: 1; }
    100% { transform: translateY(100vh); opacity: 0; }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slide-down {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Clases de utilidad */
.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}

.animate-ping-slow {
    animation: ping-slow 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
}

.animate-pulse-slow {
    animation: pulse-slow 4s ease-in-out infinite;
}

.animate-pulse-slower {
    animation: pulse-slow 6s ease-in-out infinite reverse;
}

.animate-shimmer {
    animation: shimmer 1.5s ease-in-out infinite;
}

.animate-type1 { animation: type-blink 1s ease-in-out infinite; }
.animate-type2 { animation: type-blink 1s ease-in-out infinite 0.2s; }
.animate-type3 { animation: type-blink 1s ease-in-out infinite 0.4s; }

.animate-scan-line {
    animation: scan-line 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out;
}

.animate-slide-down {
    animation: slide-down 0.4s ease-out;
}

/* Utilidades */
[x-cloak] {
    display: none !important;
}

/* Mejora de rendering */
* {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Smooth transitions */
.transition-all {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>