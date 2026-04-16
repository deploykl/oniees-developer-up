<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }" class="space-y-6">
            <!-- Título -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800">
                    Autenticación de Dos Factores
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Protege tu cuenta con verificación adicional
                </p>
            </div>

            <!-- Mensajes de instrucción -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                <div x-show="! recovery" class="text-sm text-blue-700">
                    Por favor, confirma el acceso a tu cuenta ingresando el código de autenticación de 6 dígitos.
                </div>
                <div x-show="recovery" x-cloak class="text-sm text-blue-700">
                    Ingresa uno de tus códigos de recuperación de emergencia.
                </div>
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-6">
                @csrf

                <div x-show="! recovery" class="space-y-2">
                    <x-label for="code" value="Código de Autenticación" />
                    <x-input id="code" 
                        class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                        type="text" 
                        inputmode="numeric" 
                        name="code" 
                        autofocus 
                        x-ref="code" 
                        autocomplete="one-time-code"
                        placeholder="000000" />
                </div>

                <div x-show="recovery" x-cloak class="space-y-2">
                    <x-label for="recovery_code" value="Código de Recuperación" />
                    <x-input id="recovery_code" 
                        class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                        type="text" 
                        name="recovery_code" 
                        x-ref="recovery_code" 
                        autocomplete="one-time-code"
                        placeholder="XXXX-XXXX-XXXX" />
                </div>

                <div class="flex flex-col space-y-3">
                    <button type="button" 
                        class="text-sm text-blue-600 hover:text-blue-800 underline cursor-pointer text-left"
                        x-show="! recovery"
                        x-on:click="
                            recovery = true;
                            $nextTick(() => { $refs.recovery_code.focus() })
                        ">
                        ¿Usar un código de recuperación?
                    </button>

                    <button type="button" 
                        class="text-sm text-blue-600 hover:text-blue-800 underline cursor-pointer text-left"
                        x-cloak
                        x-show="recovery"
                        x-on:click="
                            recovery = false;
                            $nextTick(() => { $refs.code.focus() })
                        ">
                        ¿Usar código de autenticación?
                    </button>

                    <x-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg">
                        Verificar e Iniciar Sesión
                    </x-button>
                </div>
            </form>

            <div class="text-center pt-4 border-t border-gray-200">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Volver al inicio de sesión
                </a>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>