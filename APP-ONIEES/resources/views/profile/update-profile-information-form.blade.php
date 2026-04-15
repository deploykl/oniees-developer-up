@if (session('status') === 'profile-updated')
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
         class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-lg shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-medium text-emerald-800">Perfil actualizado correctamente.</p>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('user-profile-information.update') }}" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- Foto de Perfil -->
    <div x-data="{photoName: null, photoPreview: null}" class="bg-gradient-to-r from-gray-50 to-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <label class="block text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Foto de perfil
        </label>

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
                <div x-show="! photoPreview" class="relative">
                    <div class="w-28 h-28 rounded-full ring-4 ring-blue-100 shadow-lg overflow-hidden bg-gradient-to-br from-blue-400 to-blue-600">
                        <img src="{{ Auth::user()->profile_photo_url }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
                
                <div x-show="photoPreview" style="display: none;" class="relative">
                    <div class="w-28 h-28 rounded-full ring-4 ring-green-100 shadow-lg overflow-hidden">
                        <span class="block w-full h-full bg-cover bg-no-repeat bg-center"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>
                </div>

                <!-- Badle de preview -->
                <div x-show="photoPreview" class="absolute -bottom-2 -right-2 bg-green-500 rounded-full p-1 shadow-md">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col gap-2 text-center sm:text-left">
                <button type="button" 
                        x-on:click.prevent="$refs.photo.click()"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Cambiar foto
                </button>
                
                <div x-show="photoName" x-text="photoName" class="text-xs text-gray-500 truncate max-w-[200px]"></div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Formatos permitidos: JPG, PNG, GIF, WEBP. Máximo 2MB
            </p>
        </div>
        @error('photo') <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-lg">{{ $message }}</p> @enderror
    </div>

    <!-- Campos del perfil -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nombre -->
        <div class="group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Nombre
            </label>
            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" 
                   required>
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Apellido -->
        <div class="group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                </svg>
                Apellido
            </label>
            <input type="text" name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
            @error('lastname') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Teléfono -->
        <div class="group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Teléfono
            </label>
            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Cargo -->
        <div class="group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Cargo
            </label>
            <input type="text" name="cargo" value="{{ old('cargo', Auth::user()->cargo) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
            @error('cargo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Email - ocupa todo el ancho -->
        <div class="md:col-span-2 group">
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Correo electrónico
            </label>
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white" 
                   required>
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Botón Guardar -->
    <div class="pt-4">
        <button type="submit" 
                class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2 group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Guardar cambios
        </button>
    </div>
</form>