<x-form-section submit="updatePassword">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <i class="fas fa-key text-blue-500"></i>
            {{ __('Actualizar Contraseña') }}
        </div>
    </x-slot>

    <x-slot name="description">
        {{ __('Asegúrate de usar una contraseña larga y aleatoria para mantener tu cuenta segura.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Contraseña Actual') }}" />
            <div class="relative mt-1">
                <x-input id="current_password" type="password" class="block w-full pr-10"
                    wire:model="state.current_password" autocomplete="current-password" />
                <button type="button" onclick="togglePassword('current_password')"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-eye-slash" id="current_password_icon"></i>
                </button>
            </div>
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('Nueva Contraseña') }}" />
            <div class="relative mt-1">
                <x-input id="password" type="password" class="block w-full pr-10" wire:model="state.password"
                    autocomplete="new-password" minlength="6" />
                <button type="button" onclick="togglePassword('password')"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-eye-slash" id="password_icon"></i>
                </button>
            </div>
            <x-input-error for="password" class="mt-2" />
            <!-- Indicador de fortaleza de contraseña -->
            <div class="mt-2">
                <div class="flex gap-1">
                    <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-bar-1"></div>
                    <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-bar-2"></div>
                    <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-bar-3"></div>
                    <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-bar-4"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1" id="strength-text">
                    <i class="fas fa-info-circle"></i> Mínimo 6 caracteres
                </p>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
            <div class="relative mt-1">
                <x-input id="password_confirmation" type="password" class="block w-full pr-10"
                    wire:model="state.password_confirmation" autocomplete="new-password" minlength="6" />
                <button type="button" onclick="togglePassword('password_confirmation')"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-eye-slash" id="password_confirmation_icon"></i>
                </button>
            </div>
            <x-input-error for="password_confirmation" class="mt-2" />
            <!-- Indicador de coincidencia -->
            <p class="text-xs mt-1" id="match-indicator"></p>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('¡Guardado!') }}
        </x-action-message>

        <x-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
            <i class="fas fa-save mr-2"></i>
            {{ __('Guardar Cambios') }}
        </x-button>
    </x-slot>
</x-form-section>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }

    // Medidor de fortaleza de contraseña (modificado para 6 caracteres)
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        if (passwordField) {
            passwordField.addEventListener('input', function() {
                checkPasswordStrength(this.value);
            });
        }

        const confirmField = document.getElementById('password_confirmation');
        const passwordFieldRef = document.getElementById('password');

        if (confirmField && passwordFieldRef) {
            confirmField.addEventListener('input', function() {
                checkPasswordMatch(passwordFieldRef.value, this.value);
            });

            passwordFieldRef.addEventListener('input', function() {
                if (confirmField.value) {
                    checkPasswordMatch(this.value, confirmField.value);
                }
            });
        }
    });

    function checkPasswordStrength(password) {
        const bars = document.querySelectorAll('[id^="strength-bar-"]');
        const strengthText = document.getElementById('strength-text');

        let strength = 0;

        // Criterios modificados: mínimo 6 caracteres
        if (password.length >= 6) strength++;
        if (password.length >= 8 && password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.length >= 8 && password.match(/[0-9]/)) strength++;
        if (password.length >= 8 && password.match(/[^a-zA-Z0-9]/)) strength++;

        // Resetear colores
        bars.forEach(bar => {
            bar.classList.remove('bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500');
            bar.classList.add('bg-gray-200');
        });

        // Aplicar colores según fortaleza
        const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
        const texts = [
            '<i class="fas fa-exclamation-triangle"></i> Muy débil - Usa al menos 6 caracteres',
            '<i class="fas fa-chart-line"></i> Débil - Agrega números y mayúsculas',
            '<i class="fas fa-chart-line"></i> Media - Agrega caracteres especiales',
            '<i class="fas fa-shield-alt"></i> ¡Fuerte! Contraseña segura'
        ];

        for (let i = 0; i < strength; i++) {
            bars[i].classList.remove('bg-gray-200');
            bars[i].classList.add(colors[i]);
        }

        if (password.length === 0) {
            strengthText.innerHTML = '<i class="fas fa-info-circle"></i> Mínimo 6 caracteres';
        } else if (password.length < 6) {
            strengthText.innerHTML =
                '<i class="fas fa-exclamation-triangle text-red-500"></i> Mínimo 6 caracteres requeridos';
        } else {
            strengthText.innerHTML = texts[strength - 1] || texts[0];
        }
    }

    function checkPasswordMatch(password, confirm) {
        const indicator = document.getElementById('match-indicator');

        if (confirm.length === 0) {
            indicator.innerHTML = '';
            indicator.className = 'text-xs mt-1';
        } else if (password === confirm) {
            indicator.innerHTML = '<i class="fas fa-check-circle text-green-500"></i> Las contraseñas coinciden';
            indicator.className = 'text-xs mt-1 text-green-600';
        } else {
            indicator.innerHTML = '<i class="fas fa-times-circle text-red-500"></i> Las contraseñas no coinciden';
            indicator.className = 'text-xs mt-1 text-red-600';
        }
    }
</script>
