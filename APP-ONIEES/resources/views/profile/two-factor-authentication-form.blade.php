<x-action-section>
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <i class="fas fa-shield-alt text-blue-500"></i>
            {{ __('Autenticación de Dos Factores') }}
        </div>
    </x-slot>

    <x-slot name="description">
        {{ __('Agrega seguridad adicional a tu cuenta usando autenticación de dos factores.') }}
    </x-slot>

    <x-slot name="content">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                @if ($this->enabled)
                    @if ($showingConfirmation)
                        <i class="fas fa-qrcode text-blue-500"></i>
                        {{ __('Completa la activación de la autenticación de dos factores.') }}
                    @else
                        <i class="fas fa-shield-alt text-green-500"></i>
                        {{ __('Has activado la autenticación de dos factores.') }}
                    @endif
                @else
                    <i class="fas fa-shield-alt text-gray-400"></i>
                    {{ __('No has activado la autenticación de dos factores.') }}
                @endif
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600">
                <p class="flex items-start gap-2">
                    <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                    {{ __('Cuando la autenticación de dos factores está activada, se te solicitará un token seguro y aleatorio durante la autenticación. Puedes obtener este token desde la aplicación de autenticación de tu teléfono.') }}
                </p>
            </div>

            @if ($this->enabled)
                @if ($showingQrCode)
                    <div class="mt-4 max-w-xl text-sm text-gray-600">
                        <p class="font-semibold flex items-center gap-2">
                            <i class="fas fa-mobile-alt text-blue-500"></i>
                            @if ($showingConfirmation)
                                {{ __('Para completar la activación, escanea el siguiente código QR con tu aplicación de autenticación o ingresa la clave de configuración y proporciona el código OTP generado.') }}
                            @else
                                {{ __('La autenticación de dos factores ya está activada. Escanea el siguiente código QR con tu aplicación de autenticación o ingresa la clave de configuración.') }}
                            @endif
                        </p>
                    </div>

                    <div class="mt-4 p-4 bg-white rounded-xl shadow-md inline-block border border-gray-200">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>

                    <div class="mt-4 max-w-xl">
                        <p class="font-semibold text-sm text-gray-700 flex items-center gap-2">
                            <i class="fas fa-key text-gray-500"></i>
                            {{ __('Clave de Configuración') }}:
                            <code class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">{{ decrypt($this->user->two_factor_secret) }}</code>
                        </p>
                    </div>

                    @if ($showingConfirmation)
                        <div class="mt-4">
                            <x-label for="code" value="{{ __('Código de Verificación') }}" />
                            <div class="relative mt-1">
                                <x-input id="code" type="text" name="code" class="block w-1/2 pr-10"
                                    inputmode="numeric" autofocus autocomplete="one-time-code" wire:model="code"
                                    wire:keydown.enter="confirmTwoFactorAuthentication" placeholder="000000" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                            </div>
                            <x-input-error for="code" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-clock"></i> Ingresa el código de 6 dígitos de tu aplicación
                            </p>
                        </div>
                    @endif
                @endif

                @if ($showingRecoveryCodes)
                    <div class="mt-4">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                                <div>
                                    <p class="font-semibold text-sm text-yellow-800">
                                        {{ __('Guarda estos códigos de recuperación en un lugar seguro.') }}
                                    </p>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        {{ __('Pueden usarse para recuperar el acceso a tu cuenta si pierdes tu dispositivo.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-2 max-w-xl mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="grid grid-cols-2 gap-2 font-mono text-sm">
                                @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                                    <div class="bg-white p-2 rounded border border-gray-200 text-center text-gray-700">
                                        {{ $code }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="mt-6 flex flex-wrap gap-3">
                @if (!$this->enabled)
                    {{-- Botón Activar --}}
                    <x-confirms-password wire:then="enableTwoFactorAuthentication">
                        <x-button type="button" wire:loading.attr="disabled"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                            <i class="fas fa-shield-alt mr-2"></i>
                            {{ __('Activar 2FA') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    {{-- Botones cuando ya está activado o en proceso --}}
                    @if ($showingRecoveryCodes)
                        <x-confirms-password wire:then="regenerateRecoveryCodes">
                            <x-secondary-button class="flex items-center gap-2">
                                <i class="fas fa-sync-alt"></i>
                                {{ __('Regenerar Códigos') }}
                            </x-secondary-button>
                        </x-confirms-password>
                    @elseif ($showingConfirmation)
                        <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                            <x-button type="button" class="bg-green-600 hover:bg-green-700 flex items-center gap-2"
                                wire:loading.attr="disabled">
                                <i class="fas fa-check-circle"></i>
                                {{ __('Confirmar') }}
                            </x-button>
                        </x-confirms-password>
                    @else
                        <x-confirms-password wire:then="showRecoveryCodes">
                            <x-secondary-button class="flex items-center gap-2">
                                <i class="fas fa-code"></i>
                                {{ __('Mostrar Códigos') }}
                            </x-secondary-button>
                        </x-confirms-password>
                    @endif

                    @if ($showingConfirmation)
                        <x-confirms-password wire:then="disableTwoFactorAuthentication">
                            <x-secondary-button wire:loading.attr="disabled">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                        </x-confirms-password>
                    @else
                        <x-confirms-password wire:then="disableTwoFactorAuthentication">
                            <x-danger-button wire:loading.attr="disabled" class="flex items-center gap-2">
                                <i class="fas fa-trash-alt"></i>
                                {{ __('Desactivar') }}
                            </x-danger-button>
                        </x-confirms-password>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>
</x-action-section>