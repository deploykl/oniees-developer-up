<div x-data="sonnerToaster()" x-init="initToaster">
    <template x-for="toast in toasts" :key="toast.id">
        <div 
            x-show="true"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-[-20px] opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transform ease-in duration-200 transition"
            x-transition:leave-start="translate-y-0 opacity-100 scale-100"
            x-transition:leave-end="translate-y-[-20px] opacity-0 scale-95"
            class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] w-[380px] rounded-xl shadow-2xl overflow-hidden"
            :class="{
                'bg-gradient-to-r from-emerald-500 to-emerald-600': toast.type === 'success',
                'bg-gradient-to-r from-rose-500 to-rose-600': toast.type === 'error',
                'bg-gradient-to-r from-blue-500 to-blue-600': toast.type === 'info',
                'bg-gradient-to-r from-amber-500 to-amber-600': toast.type === 'warning'
            }"
        >
            <!-- Barra de progreso -->
            <div class="absolute bottom-0 left-0 h-1 bg-white/30" 
                 :style="{ width: toast.width + '%' }"></div>
            
            <div class="flex items-start gap-3 px-4 py-3 relative">
                <!-- Pulse effect en el icono -->
                <div class="flex-shrink-0 mt-0.5 relative">
                    <div class="absolute inset-0 rounded-full animate-ping opacity-30"
                         :class="{
                             'bg-white': toast.type === 'success',
                             'bg-white': toast.type === 'error',
                             'bg-white': toast.type === 'info',
                             'bg-white': toast.type === 'warning'
                         }"></div>
                    <svg x-show="toast.type === 'success'" class="w-5 h-5 text-white relative animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="toast.type === 'error'" class="w-5 h-5 text-white relative animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="toast.type === 'info'" class="w-5 h-5 text-white relative animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="toast.type === 'warning'" class="w-5 h-5 text-white relative animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                
                <!-- Contenido -->
                <div class="flex-1">
                    <p class="text-sm font-semibold text-white" x-text="toast.message"></p>
                </div>
                
                <!-- Botón cerrar -->
                <button @click="toasts = toasts.filter(t => t.id !== toast.id)" 
                        class="flex-shrink-0 text-white/70 hover:text-white transition-transform hover:scale-110">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </template>
</div>

<script>
    function sonnerToaster() {
        return {
            toasts: [],
            initToaster() {
                window.addToast = (type, message, duration = 4000) => {
                    const id = Date.now();
                    let width = 100;
                    const interval = setInterval(() => {
                        width -= 100 / (duration / 100);
                        if (width <= 0) {
                            clearInterval(interval);
                        }
                    }, 100);
                    
                    this.toasts.push({ id, type, message, width: 100, interval });
                    
                    const timeoutId = setTimeout(() => {
                        clearInterval(interval);
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, duration);
                    
                    // Guardar timeout para limpiar si es necesario
                    const toastIndex = this.toasts.findIndex(t => t.id === id);
                    if (toastIndex !== -1) {
                        this.toasts[toastIndex].timeout = timeoutId;
                    }
                };
                
                window.toast = {
                    success: (msg, dur) => window.addToast('success', msg, dur || 4000),
                    error: (msg, dur) => window.addToast('error', msg, dur || 4000),
                    info: (msg, dur) => window.addToast('info', msg, dur || 4000),
                    warning: (msg, dur) => window.addToast('warning', msg, dur || 4000)
                };

                // Actualizar width de los toasts
                setInterval(() => {
                    this.toasts.forEach(toast => {
                        if (toast.width > 0) {
                            toast.width -= 100 / (4000 / 100);
                            if (toast.width < 0) toast.width = 0;
                        }
                    });
                }, 100);

                setTimeout(() => {
                    @if(session('toast_message'))
                        window.toast.{{ session('toast_type') }}("{{ session('toast_message') }}");
                    @endif
                }, 500);
            }
        };
    }
</script>