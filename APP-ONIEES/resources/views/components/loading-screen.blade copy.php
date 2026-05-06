@props(['show' => false, 'duration' => 5000, 'theme' => 'light'])

<div x-data="{
    show: {{ $show ? 'true' : 'false' }},
    duration: {{ $duration }},
    theme: 'light',
    countdown: Math.ceil({{ $duration }} / 1000),
    startTime: null,
    interval: null,
    progress: 0,
    isExiting: false,
    showScanLine: false,
    particles: [],
    particleInterval: null,
    
    init() {
        if (this.show) {
            this.startLoading();
        }
    },
    
    startLoading() {
        console.log('LoadingScreen iniciado');
        this.startTime = Date.now();
        this.isExiting = false;
        this.showScanLine = false;
        
        this.$nextTick(() => {
            this.initParticles();
            this.startCountdown();
        });
    },
    
    initParticles() {
        const container = this.$refs.particlesContainer;
        if (!container) return;
        
        const particleCount = 50;
        
        for (let i = 0; i < particleCount; i++) {
            this.particles.push({
                x: Math.random() * 100,
                y: Math.random() * 100,
                size: Math.random() * 4 + 2,
                speedX: (Math.random() - 0.5) * 0.5,
                speedY: (Math.random() - 0.5) * 0.5,
                opacity: Math.random() * 0.5 + 0.2
            });
        }
        
        this.particleInterval = setInterval(() => {
            if (this.isExiting) return;
            this.updateParticles();
        }, 50);
    },
    
    updateParticles() {
        this.particles = this.particles.map(p => ({
            ...p,
            x: p.x + p.speedX,
            y: p.y + p.speedY
        }));
        
        this.$refs.particlesContainer.style.setProperty('--particles', JSON.stringify(this.particles));
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
        }, 50);
    },
    
    startExit() {
        if (this.isExiting) return;
        
        this.isExiting = true;
        this.showScanLine = true;
        
        if (this.particleInterval) {
            clearInterval(this.particleInterval);
            this.particleInterval = null;
        }
        
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
        }, 800);
    }
}" x-init="init()" x-show="show" x-cloak>
    <div class="fixed inset-0 z-[9999] flex items-center justify-center overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        
        <!-- Partículas flotantes SVG -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none" x-ref="particlesContainer">
            <g fill="url(#gradient)">
                <template x-for="(particle, index) in particles" :key="index">
                    <circle :cx="particle.x + '%'" :cy="particle.y + '%'" :r="particle.size" :opacity="particle.opacity">
                        <animate attributeName="opacity" values="0.2;0.6;0.2" dur="3s" repeatCount="indefinite"/>
                    </circle>
                </template>
            </g>
            <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.3"/>
                    <stop offset="50%" stop-color="#8b5cf6" stop-opacity="0.3"/>
                    <stop offset="100%" stop-color="#06b6d4" stop-opacity="0.3"/>
                </linearGradient>
            </defs>
        </svg>

        <!-- Ondas decorativas -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-1/2 -right-1/2 w-full h-full bg-gradient-to-br from-blue-100/30 to-transparent rounded-full blur-3xl animate-float"></div>
            <div class="absolute -bottom-1/2 -left-1/2 w-full h-full bg-gradient-to-tr from-indigo-100/20 to-transparent rounded-full blur-3xl animate-float-delayed"></div>
        </div>

        <!-- Efecto de desvanecimiento -->
        <div class="absolute inset-0 z-10 transition-opacity duration-1000"
             :class="isExiting ? 'opacity-100 bg-gradient-to-t from-white via-transparent to-transparent' : 'opacity-0'"></div>

        <!-- Contenido principal -->
        <div class="relative z-20 text-center space-y-10 transition-all duration-1000 max-w-md w-full mx-6"
             :class="[
                 isExiting ? 'opacity-0 scale-95 translate-y-10' : 'opacity-100 scale-100 translate-y-0'
             ]">
            
            <!-- Logo con animación moderna -->
            <div class="relative mx-auto w-28 h-28">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 animate-spin-slow"></div>
                <div class="absolute inset-1 rounded-xl bg-white flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-600 animate-bounce-gentle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>

            <!-- Texto principal elegante -->
            <div class="space-y-4">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent animate-slide-up">
                    Cargando Sistema
                </h1>
                <p class="text-lg text-slate-600 font-light animate-fade-in-up" style="animation-delay: 0.2s;">
                    Preparando tu experiencia
                </p>
            </div>

            <!-- Barra de progreso moderna -->
            <div class="space-y-4">
                <div class="relative w-full h-1.5 bg-slate-100 rounded-full overflow-hidden shadow-inner">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 transition-all duration-100 ease-out rounded-full" 
                         :style="{ width: progress + '%', boxShadow: '0 0 10px rgba(59,130,246,0.5)' }"></div>
                </div>
                
                <div class="flex justify-between items-center text-sm font-medium">
                    <span class="text-slate-500">Inicializando...</span>
                    <span class="text-blue-600 font-mono" x-text="countdown + 's'"></span>
                </div>
            </div>

            <!-- Tarjetas de estado -->
            <div class="grid grid-cols-2 gap-3 mt-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 shadow-sm border border-slate-100 animate-slide-up-stagger">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 text-sm">Conectando</span>
                        <svg class="w-4 h-4 text-green-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                
                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 shadow-sm border border-slate-100 animate-slide-up-stagger" style="animation-delay: 0.3s;">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 text-sm">Seguridad</span>
                        <svg class="w-4 h-4 text-blue-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 shadow-sm border border-slate-100 animate-slide-up-stagger" style="animation-delay: 0.6s;">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 text-sm">Módulos</span>
                        <div class="w-4 h-4 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 shadow-sm border border-slate-100 animate-slide-up-stagger" style="animation-delay: 0.9s;">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 text-sm">Cache</span>
                        <div class="flex space-x-0.5">
                            <div class="w-1 h-2 bg-indigo-500 animate-pulse" style="animation-delay: 0s"></div>
                            <div class="w-1 h-3 bg-indigo-500 animate-pulse" style="animation-delay: 0.2s"></div>
                            <div class="w-1 h-4 bg-indigo-500 animate-pulse" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-4 text-xs text-slate-400 animate-fade-in-up" style="animation-delay: 1.2s;">
                <span>Sistema seguro v2.0</span>
                <span class="mx-2">•</span>
                <span>Todos los derechos reservados</span>
            </div>
        </div>

        <!-- Efecto de barrido final -->
        <div x-show="showScanLine" 
             x-cloak
             class="absolute inset-0 z-30 pointer-events-none">
            <div class="w-full h-32 bg-gradient-to-b from-blue-500/20 via-transparent to-transparent animate-scan-line"></div>
        </div>
    </div>
</div>

<style>
/* Animaciones personalizadas */
@keyframes spin-slow {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes bounce-gentle {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    50% {
        transform: translate(10%, 10%) scale(1.1);
    }
}

@keyframes scan-line {
    0% {
        transform: translateY(-100%);
        opacity: 1;
    }
    70% {
        opacity: 0.5;
    }
    100% {
        transform: translateY(100vh);
        opacity: 0;
    }
}

/* Clases de animación */
.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}

.animate-bounce-gentle {
    animation: bounce-gentle 2s ease-in-out infinite;
}

.animate-slide-up {
    animation: slide-up 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}

.animate-slide-up-stagger {
    animation: slide-up 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    opacity: 0;
}

.animate-float {
    animation: float 8s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float 8s ease-in-out infinite;
    animation-delay: 4s;
}

.animate-scan-line {
    animation: scan-line 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

/* Mejoras visuales */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
}

/* Optimizaciones de rendimiento */
.will-change-transform {
    will-change: transform;
}

.will-change-opacity {
    will-change: opacity;
}

/* Ocultar inicialmente */
[x-cloak] {
    display: none !important;
}

/* Scroll suave */
* {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
</style>