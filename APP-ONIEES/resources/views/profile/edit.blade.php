@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        <i class="fas fa-user-circle"></i> Mi Perfil
                    </h2>
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                </div>

                <!-- Información del perfil (incluye foto) -->
                <div class="mt-6">
                    @livewire('profile.update-profile-information-form')
                </div>

                <!-- Cambiar contraseña -->
                <div class="mt-6">
                    @livewire('profile.update-password-form')
                </div>

                <!-- Autenticación de dos factores (2FA) -->
                <div class="mt-6">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <!-- Cerrar sesión en otros dispositivos -->
                <div class="mt-6">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

                <!-- Eliminar cuenta -->
                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div class="mt-6">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection