<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="space-y-6">
            <!-- Título -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800">
                    ¡Bienvenido!
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    Inicia sesión para acceder a tu cuenta
                </p>
            </div>

            <!-- Mensaje de estado -->
            @session('status')
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-sm text-green-700">{{ $value }}</span>
                    </div>
                </div>
            @endsession

            <!-- Errores de validación -->
            <x-validation-errors class="mb-4" />

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Campo Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-envelope text-gray-400 mr-1"></i> Correo Electrónico
                    </label>
                    <input id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="tu@email.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 outline-none">
                </div>

                <!-- Campo Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-lock text-gray-400 mr-1"></i> Contraseña
                    </label>
                    <input id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 outline-none">
                </div>

                <!-- Recordarme y Olvidé contraseña -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                            name="remember" 
                            id="remember_me" 
                            value="1"
                            {{ old('remember') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">
                            Recordarme
                        </span>
                    </label>
                </div>

                <!-- Botón Iniciar Sesión -->
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-150 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>