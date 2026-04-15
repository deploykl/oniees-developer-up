<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- ========== FOTO DE PERFIL - AGREGADA MANUALMENTE ========== -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="photo" value="{{ __('Profile Photo') }}" />
            
            <!-- Current Photo -->
            <div class="mt-2">
                <img src="{{ Auth::user()->profile_photo_url }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="rounded-full h-24 w-24 object-cover">
            </div>

            <!-- Photo Upload -->
            <div class="mt-4">
                <input type="file" wire:model="photo" id="photo" class="hidden">
                <x-secondary-button type="button" onclick="document.getElementById('photo').click()">
                    <i class="fas fa-camera"></i> {{ __('Select A New Photo') }}
                </x-secondary-button>
                
                @if (Auth::user()->profile_photo_path)
                    <x-secondary-button type="button" class="ml-2" wire:click="deleteProfilePhoto">
                        <i class="fas fa-trash"></i> {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif
            </div>

            <!-- Photo Preview -->
            @if ($photo)
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Preview:</p>
                    <img src="{{ $photo->temporaryUrl() }}" class="rounded-full h-20 w-20 object-cover">
                </div>
            @endif

            <x-input-error for="photo" class="mt-2" />
        </div>
        <!-- ========== FIN FOTO ========== -->

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Lastname -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="lastname" value="{{ __('Lastname') }}" />
            <x-input id="lastname" type="text" class="mt-1 block w-full" wire:model="state.lastname" />
            <x-input-error for="lastname" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="phone" value="{{ __('Phone') }}" />
            <x-input id="phone" type="text" class="mt-1 block w-full" wire:model="state.phone" />
            <x-input-error for="phone" class="mt-2" />
        </div>

        <!-- Cargo -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="cargo" value="{{ __('Cargo') }}" />
            <x-input id="cargo" type="text" class="mt-1 block w-full" wire:model="state.cargo" />
            <x-input-error for="cargo" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>