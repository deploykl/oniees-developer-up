<x-action-section>
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <i class="fas fa-globe text-blue-500"></i>
            {{ __('Sesiones del navegador') }}
        </div>
    </x-slot>

    <x-slot name="description">
        {{ __('Administra y cierra sesiones activas en otros navegadores y dispositivos.') }}
    </x-slot>

    <x-slot name="content">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="max-w-xl text-sm text-gray-600 mb-4 flex items-start gap-2">
                <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                <p>{{ __('Si es necesario, puedes cerrar todas tus otras sesiones de navegador en todos tus dispositivos. Algunas de tus sesiones recientes se enumeran a continuación; sin embargo, esta lista puede no ser exhaustiva. Si crees que tu cuenta se ha visto comprometida, también deberías actualizar tu contraseña.') }}
                </p>
            </div>

            @if (count($this->sessions) > 0)
                <div class="mt-5 space-y-4">
                    <!-- Otras Sesiones del Navegador -->
                    @foreach ($this->sessions as $session)
                        <div
                            class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-md transition-all duration-200">
                            <div class="flex-shrink-0">
                                @if ($session->agent->isDesktop())
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-desktop text-blue-600 text-lg"></i>
                                    </div>
                                @else
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-mobile-alt text-green-600 text-lg"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="ms-3 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-gray-800">
                                        {{ $session->agent->platform() ? $session->agent->platform() : __('Desconocido') }}
                                    </span>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-sm text-gray-600">
                                        {{ $session->agent->browser() ? $session->agent->browser() : __('Desconocido') }}
                                    </span>

                                    @if ($session->is_current_device)
                                        <span
                                            class="ml-2 px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full flex items-center gap-1">
                                            <i class="fas fa-check-circle text-xs"></i>
                                            {{ __('Dispositivo actual') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                                    <span>{{ $session->ip_address }}</span>
                                    <span class="text-gray-300">|</span>
                                    <i class="far fa-clock text-gray-400 text-xs"></i>
                                    <span>
                                        @if ($session->is_current_device)
                                            {{ __('Activo ahora') }}
                                        @else
                                            {{ __('Última actividad') }}: {{ $session->last_active }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <x-button wire:click="confirmLogout" wire:loading.attr="disabled"
                        class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        {{ __('Cerrar otras sesiones') }}
                    </x-button>

                    <x-action-message class="text-green-600" on="loggedOut">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ __('¡Completado!') }}</span>
                        </div>
                    </x-action-message>
                </div>

                <div class="text-xs text-gray-400 flex items-center gap-1">
                    <i class="fas fa-shield-alt"></i>
                    <span>{{ __('Sesiones seguras') }}</span>
                </div>
            </div>
        </div>

        <!-- MODAL MANUAL -->
        @if ($confirmingLogout)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: true }" x-show="open" x-cloak>
                <!-- Fondo oscuro -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     x-show="open" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0">
                </div>
                
                <!-- Modal -->
                <div class="flex items-center justify-center min-h-screen px-4 text-center sm:p-0">
                    <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto transform transition-all"
                         x-show="open"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        
                        <!-- Cabecera -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ __('Cerrar otras sesiones') }}
                                </h3>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-6 space-y-4">
                            <!-- Advertencia -->
                            <div class="flex items-start gap-3 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <i class="fas fa-shield-alt text-yellow-600 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">
                                        {{ __('Confirmación de seguridad') }}
                                    </p>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        {{ __('Ingresa tu contraseña para confirmar que deseas cerrar sesión en todos tus otros navegadores y dispositivos.') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Campo de contraseña -->
                            <div>
                                <x-label for="modal_password" value="{{ __('Contraseña') }}" 
                                    class="text-sm font-semibold text-gray-700 mb-2" />
                                <div class="relative">
                                    <input type="password" 
                                           id="modal_password"
                                           wire:model="password"
                                           wire:keydown.enter="logoutOtherBrowserSessions"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                                           placeholder="{{ __('Ingresa tu contraseña') }}"
                                           autofocus>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                </div>
                                @error('password') 
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i>
                                    {{ __('Esta acción cerrará todas las sesiones excepto la actual.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer con botones -->
                        <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 rounded-b-lg">
                            <button type="button" 
                                    wire:click="$set('confirmingLogout', false)"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
                                <i class="fas fa-times"></i>
                                {{ __('Cancelar') }}
                            </button>
                            
                            <button type="button" 
                                    wire:click="logoutOtherBrowserSessions"
                                    wire:loading.attr="disabled"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
                                <i class="fas fa-sign-out-alt"></i>
                                {{ __('Cerrar otras sesiones') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estilos para x-cloak -->
            <style>
                [x-cloak] { display: none !important; }
            </style>
        @endif
    </x-slot>
</x-action-section>