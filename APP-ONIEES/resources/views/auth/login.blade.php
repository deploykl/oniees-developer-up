<x-guest-layout>
    <x-slot name="title">
        Iniciar Sesión | ONIEES
    </x-slot>

    <div class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-slate-50 to-slate-100">
        <!-- Elementos decorativos -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-[#0E7C9E]/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-[#0E7C9E]/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#0E7C9E]/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Card principal -->
        <div class="relative w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-[#0E7C9E] to-[#0B6A88] px-8 pt-10 pb-12 text-center relative">
                    <div class="relative z-10">
                        <div class="w-20 h-20 mx-auto bg-white rounded-xl shadow-lg flex items-center justify-center mb-5 transform transition-transform hover:scale-105 duration-300">
                            <img src="{{ asset('img/favicon.png') }}" alt="ONIEES" class="h-12 w-auto">
                        </div>
                        <h1 class="text-xl font-bold text-white">Observatorio Nacional</h1>
                        <p class="text-[#9DC8D6] text-xs mt-1">Infraestructura y Equipamiento de Salud</p>
                    </div>
                </div>

                <!-- Formulario -->
                <div class="px-6 py-6">
                    <!-- Mensajes -->
                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-exclamation-circle text-red-500 text-sm"></i>
                                <p class="text-red-700 text-xs">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    @endif

                    @session('status')
                        <div class="mb-4 p-3 bg-emerald-50 border-l-4 border-emerald-500 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-emerald-500 text-sm"></i>
                                <p class="text-emerald-700 text-xs">{{ $value }}</p>
                            </div>
                        </div>
                    @endsession

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1">
                                <i class="fas fa-envelope text-[#0E7C9E] mr-1 text-xs"></i>
                                Correo electrónico
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0E7C9E] focus:ring-2 focus:ring-[#0E7C9E]/20 transition-all text-sm"
                                placeholder="usuario@oniees.gob.pe">
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1">
                                <i class="fas fa-lock text-[#0E7C9E] mr-1 text-xs"></i>
                                Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0E7C9E] focus:ring-2 focus:ring-[#0E7C9E]/20 transition-all text-sm pr-10"
                                    placeholder="••••••••">
                                <button type="button" id="togglePassword" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0E7C9E] transition">
                                    <i class="fas fa-eye-slash text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Recordarme y Olvidé contraseña -->
                        <div class="flex items-center justify-between text-xs">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="remember" id="remember_me" value="1" {{ old('remember') ? 'checked' : '' }}
                                    class="w-3.5 h-3.5 rounded border-gray-300 text-[#0E7C9E] focus:ring-[#0E7C9E]">
                                <span class="text-gray-500">Recordarme</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[#0E7C9E] hover:text-[#0B6A88] transition">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <!-- Botón -->
                        <button type="submit"
                            class="w-full bg-[#0E7C9E] hover:bg-[#0B6A88] text-white font-medium py-2.5 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md text-sm">
                            <i class="fas fa-arrow-right-to-bracket text-xs"></i>
                            Iniciar sesión
                        </button>
                    </form>

                    <!-- Separador -->
                    <div class="relative my-5">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-100"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white px-2 text-gray-400 text-[10px]">Acceso seguro</span>
                        </div>
                    </div>

                    <!-- Badges seguridad -->
                    <div class="flex items-center justify-center gap-3 text-[10px] text-gray-400">
                        <span class="flex items-center gap-1"><i class="fas fa-shield-alt text-[#0E7C9E] text-[9px]"></i> Datos encriptados</span>
                        <span class="flex items-center gap-1"><i class="fas fa-lock text-[#0E7C9E] text-[9px]"></i> Conexión segura</span>
                        <span class="flex items-center gap-1"><i class="fas fa-clock text-[#0E7C9E] text-[9px]"></i> Sesión protegida</span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-3 text-center border-t border-gray-100">
                    <a href="{{ route('home') }}" class="text-[#0E7C9E] hover:text-[#0B6A88] transition text-xs flex items-center justify-center gap-1">
                        <i class="fas fa-arrow-left text-[9px]"></i>
                        Volver al inicio
                    </a>
                </div>
            </div>

            <!-- Copyright -->
            <p class="text-center text-gray-400 text-[10px] mt-4">
                © {{ date('Y') }} Observatorio Nacional de Infraestructura y Equipamiento de Establecimientos de Salud
            </p>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword')?.addEventListener('click', function() {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</x-guest-layout>