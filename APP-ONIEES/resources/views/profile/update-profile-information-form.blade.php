@if (session('status') === 'profile-updated')
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
         class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-lg shadow-sm">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
            <p class="text-sm font-medium text-emerald-800">¡Perfil actualizado correctamente!</p>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('user-profile-information.update') }}" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- Foto de Perfil -->
    <div x-data="{photoName: null, photoPreview: null}" 
         class="bg-gradient-to-r from-gray-50 to-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-camera text-blue-500 text-lg"></i>
            <label class="block text-sm font-semibold text-gray-700">
                Foto de perfil
            </label>
        </div>

        <input type="file" id="photo" name="photo" class="hidden"
            x-ref="photo"
            x-on:change="
                photoName = $refs.photo.files[0].name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    photoPreview = e.target.result;
                };
                reader.readAsDataURL($refs.photo.files[0]);
            " />

        <div class="flex flex-col sm:flex-row items-center gap-6">
            <!-- Avatar -->
            <div class="relative group">
                <!-- Estado actual -->
                <div x-show="! photoPreview" class="relative">
                    <div class="w-28 h-28 rounded-full ring-4 ring-blue-100 shadow-lg overflow-hidden bg-gradient-to-br from-blue-400 to-blue-600">
                        @if(Auth::user()->profile_photo_url)
                            <img src="{{ Auth::user()->profile_photo_url }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white text-3xl font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Preview nueva foto -->
                <div x-show="photoPreview" style="display: none;" class="relative">
                    <div class="w-28 h-28 rounded-full ring-4 ring-green-100 shadow-lg overflow-hidden">
                        <span class="block w-full h-full bg-cover bg-no-repeat bg-center"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-green-500 rounded-full p-1 shadow-md">
                        <i class="fas fa-check text-white text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col gap-2 text-center sm:text-left">
                <button type="button" 
                        x-on:click.prevent="$refs.photo.click()"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-upload text-sm"></i>
                    Cambiar foto
                </button>
                
                <div x-show="photoName" x-text="photoName" class="text-xs text-gray-500 truncate max-w-[200px]"></div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-400 flex items-center gap-1">
                <i class="fas fa-info-circle text-xs"></i>
                Formatos permitidos: JPG, PNG, GIF, WEBP. Máximo 2MB
            </p>
        </div>
        @error('photo') 
            <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-lg flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                {{ $message }}
            </p> 
        @enderror
    </div>

    <!-- Campos del perfil -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nombre -->
        <div class="group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-user text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                Nombre <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" 
                   required>
            @error('name') 
                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle text-xs"></i>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <!-- Apellido -->
        <div class="group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-user-tag text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                Apellido
            </label>
            <input type="text" name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
            @error('lastname') 
                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle text-xs"></i>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <!-- Teléfono -->
        <div class="group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-phone text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                Teléfono
            </label>
            <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                   placeholder="Ej: 999999999">
            @error('phone') 
                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle text-xs"></i>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <!-- Cargo -->
        <div class="group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-briefcase text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                Cargo
            </label>
            <input type="text" name="cargo" value="{{ old('cargo', Auth::user()->cargo) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                   placeholder="Ej: Director, Coordinador, Analista">
            @error('cargo') 
                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle text-xs"></i>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <!-- Email - ocupa todo el ancho -->
        <div class="md:col-span-2 group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-envelope text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                Correo electrónico <span class="text-red-500">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" 
                   required>
            @error('email') 
                <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle text-xs"></i>
                    {{ $message }}
                </p> 
            @enderror
        </div>
    </div>

    <!-- Botón Guardar -->
    <div class="pt-4 flex justify-end">
       <x-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
            <i class="fas fa-save mr-2"></i>
            {{ __('Guardar Cambios') }}
        </x-button>
    </div>
</form>

<!-- Script opcional para formato de teléfono -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 9) value = value.slice(0, 9);
            e.target.value = value;
        });
    }
});
</script>