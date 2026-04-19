<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Card personalizado sin fondo blanco -->
        <div class="max-w-md w-full bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-full bg-blue-100 blur-xl opacity-70"></div>
                    <img src="{{ asset('img/favicon.png') }}" class="relative w-16 h-16 mx-auto rounded-full shadow-lg ring-4 ring-white" alt="Logo">
                </div>
            </div>

            <div class="space-y-8">
                <!-- Título -->
                <div class="text-center space-y-2">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        ¡Bienvenido!
                    </h2>
                    <p class="text-sm text-gray-600">
                        Accede a tu cuenta con tus credenciales
                    </p>
                </div>

                <!-- Mensaje de estado -->
                @session('status')
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500 text-lg"></i>
                            <span class="text-sm text-green-700">{{ $value }}</span>
                        </div>
                    </div>
                @endsession

                <!-- Errores de validación -->
                <x-validation-errors class="mb-4" />

                <!-- Formulario -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Campo Email -->
                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i> Correo Electrónico
                        </label>
                        <div class="relative">
                            <input id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="tu@email.com"
                                class="w-full pl-4 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none bg-white/50 hover:bg-white">
                        </div>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-gray-400 mr-2"></i> Contraseña
                        </label>
                        <div class="relative">
                            <input id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full pl-4 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none bg-white/50 hover:bg-white">
                            <button type="button" 
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-eye-slash text-sm" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Recordarme -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" 
                                name="remember" 
                                id="remember_me" 
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition duration-150">
                            <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900 transition">
                                Recordarme
                            </span>
                        </label>
                    </div>

                    <!-- Botón Iniciar Sesión -->
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg shadow-blue-500/25">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                } else {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });
        }
        
        // Mostrar toast si hay error de login
        @if($errors->any())
            setTimeout(() => {
                if (window.toast) {
                    window.toast.error('{{ $errors->first() }}');
                }
            }, 500);
        @endif
        
        // Mostrar toast si hay sesión expirada, etc.
        @if(session('error'))
            setTimeout(() => {
                if (window.toast) {
                    window.toast.error('{{ session('error') }}');
                }
            }, 500);
        @endif
    });
</script>
</x-guest-layout>