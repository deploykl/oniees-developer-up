<div>
    <x-action-section>
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <i class="fas fa-trash-alt text-red-500"></i>
                {{ __('Eliminar Cuenta') }}
            </div>
        </x-slot>

        <x-slot name="description">
            {{ __('Elimina permanentemente tu cuenta.') }}
        </x-slot>

        <x-slot name="content">
            <div class="max-w-xl">
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-semibold text-red-800">
                                {{ __('¡Atención! Esta acción no se puede deshacer.') }}
                            </p>
                            <p class="text-sm text-red-700 mt-1">
                                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-600 mb-4 flex items-start gap-2">
                    <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                    <p>{{ __('Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.') }}</p>
                </div>
            </div>

            <div class="mt-5">
                <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800">
                    <i class="fas fa-trash-alt mr-2"></i>
                    {{ __('Eliminar Cuenta') }}
                </x-danger-button>
            </div>

            <!-- Modal de Confirmación -->
            <x-dialog-modal wire:model.live="confirmingUserDeletion">
                <x-slot name="title">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                        {{ __('Eliminar Cuenta Permanentemente') }}
                    </div>
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-4 bg-red-50 rounded-lg border border-red-200">
                            <i class="fas fa-skull-crosswalk text-red-600 text-xl"></i>
                            <div>
                                <p class="text-sm font-bold text-red-800">
                                    {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
                                </p>
                                <p class="text-sm text-red-700 mt-1">
                                    {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente.') }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-download text-yellow-600 mt-0.5"></i>
                                <p class="text-xs text-yellow-800">
                                    {{ __('Antes de continuar, asegúrate de haber descargado toda la información importante que necesitas conservar.') }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                            <x-label for="password" value="{{ __('Contraseña') }}" class="text-sm font-semibold text-gray-700" />
                            <div class="relative mt-1">
                                <x-input type="password" 
                                    id="password"
                                    class="mt-1 block w-full pr-10"
                                    autocomplete="current-password"
                                    placeholder="{{ __('Ingresa tu contraseña para confirmar') }}"
                                    x-ref="password"
                                    wire:model="password"
                                    wire:keydown.enter="deleteUser" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                            </div>
                            <x-input-error for="password" class="mt-2" />
                            
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <i class="fas fa-shield-alt"></i>
                                {{ __('Se requiere tu contraseña por razones de seguridad.') }}
                            </p>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex justify-end gap-3">
                        <x-secondary-button wire:click="$set('confirmingUserDeletion', false)" wire:loading.attr="disabled" class="flex items-center gap-1">
                            <i class="fas fa-times"></i>
                            {{ __('Cancelar') }}
                        </x-secondary-button>

                        <x-danger-button class="bg-red-600 hover:bg-red-700 flex items-center gap-1" 
                                        wire:click="deleteUser" 
                                        wire:loading.attr="disabled">
                            <i class="fas fa-trash-alt"></i>
                            {{ __('Sí, eliminar mi cuenta') }}
                        </x-danger-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
        </x-slot>
    </x-action-section>
</div>