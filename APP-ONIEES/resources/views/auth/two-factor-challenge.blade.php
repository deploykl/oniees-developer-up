<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Card con efecto glassmorphism -->
        <div class="max-w-md w-full bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20">
            
            <div x-data="{ recovery: false }" class="space-y-8">
                <!-- Logo -->
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-full bg-blue-100 blur-xl opacity-70"></div>
                        <img src="{{ asset('img/favicon.png') }}" class="relative w-16 h-16 mx-auto rounded-full shadow-lg ring-4 ring-white" alt="Logo">
                    </div>
                </div>

                <!-- Título -->
                <div class="text-center space-y-2">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Verificación de Dos Factores
                    </h2>
                    <p class="text-sm text-gray-600">
                        Protege tu cuenta con verificación adicional
                    </p>
                </div>

                <!-- Mensajes de instrucción -->
                <div class="bg-blue-50/80 backdrop-blur-sm border-l-4 border-blue-500 p-4 rounded-xl">
                    <div x-show="! recovery" class="text-sm text-blue-800">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Por favor, confirma el acceso a tu cuenta ingresando el código de autenticación de 6 dígitos.
                    </div>
                    <div x-show="recovery" x-cloak class="text-sm text-blue-800">
                        <i class="fas fa-key mr-2"></i>
                        Ingresa uno de tus códigos de recuperación de emergencia.
                    </div>
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-6">
                    @csrf

                    <!-- Campo Código de Autenticación -->
                    <div x-show="! recovery" class="space-y-2">
                        <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-qrcode text-gray-400 mr-2"></i> Código de Autenticación
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-digital-tiling text-gray-400 text-sm"></i>
                            </div>
                            <input id="code" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none bg-white/50 hover:bg-white" 
                                type="text" 
                                inputmode="numeric" 
                                name="code" 
                                autofocus 
                                x-ref="code" 
                                autocomplete="one-time-code"
                                placeholder="000000" />
                        </div>
                    </div>

                    <!-- Campo Código de Recuperación -->
                    <div x-show="recovery" x-cloak class="space-y-2">
                        <label for="recovery_code" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-save text-gray-400 mr-2"></i> Código de Recuperación
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400 text-sm"></i>
                            </div>
                            <input id="recovery_code" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none bg-white/50 hover:bg-white" 
                                type="text" 
                                name="recovery_code" 
                                x-ref="recovery_code" 
                                autocomplete="one-time-code"
                                placeholder="XXXX-XXXX-XXXX" />
                        </div>
                    </div>

                    <!-- Botones de opción y verificación -->
                    <div class="flex flex-col space-y-3">
                        <button type="button" 
                            class="text-sm text-blue-600 hover:text-blue-800 font-semibold cursor-pointer text-left transition"
                            x-show="! recovery"
                            x-on:click="
                                recovery = true;
                                $nextTick(() => { $refs.recovery_code.focus() })
                            ">
                            <i class="fas fa-arrow-right mr-1"></i> ¿Usar un código de recuperación?
                        </button>

                        <button type="button" 
                            class="text-sm text-blue-600 hover:text-blue-800 font-semibold cursor-pointer text-left transition"
                            x-cloak
                            x-show="recovery"
                            x-on:click="
                                recovery = false;
                                $nextTick(() => { $refs.code.focus() })
                            ">
                            <i class="fas fa-arrow-left mr-1"></i> ¿Usar código de autenticación?
                        </button>

                        <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg shadow-blue-500/25">
                            <i class="fas fa-check-circle mr-2"></i>
                            Verificar e Iniciar Sesión
                        </button>
                    </div>
                </form>

                <!-- Enlace de volver -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 transition inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al inicio de sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>