<x-app-layout>
    <x-slot name="title">Usuarios</x-slot>
    <x-slot name="subtitle">Editar Usuario</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="p-6 lg:p-8">
                    <form id="FormUserEdit" action="{{ route('users-update') }}" method="post"
                        class="space-y-6 needs-validation">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}" />

                        <div class="text-center mb-8">
                            <h3
                                class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                Editar Usuario
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Complete todos los campos obligatorios (*)</p>
                        </div>

                        <!-- Fila 1: Tipo Rol, Tipo Usuario, Estado -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Tipo Rol <span class="text-red-500">*</span>
                                </label>
                                <select id="idtiporol" name="idtiporol" onchange="RequiredDiris()"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    required>
                                    <option value="">Seleccione</option>
                                    @if (Auth::user()->idtiporol == 1)
                                        <option value="1" {{ $user->idtiporol == '1' ? 'selected' : '' }}>
                                            Minsa-Dgos-Diem</option>
                                    @endif
                                    <option value="2" {{ $user->idtiporol == '2' ? 'selected' : '' }}>
                                        Diresa/Geresa/Diris</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Tipo Usuario <span class="text-red-500">*</span>
                                </label>
                                <select id="idtipousuario" name="idtipousuario"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    required>
                                    <option value="">Seleccione</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id }}"
                                            {{ $tipo->id == $user->idtipousuario ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Estado <span class="text-red-500">*</span>
                                </label>
                                <select id="state_id" name="state_id"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    required>
                                    <option value="2" {{ $user->state_id == 2 ? 'selected' : '' }}>Activo</option>
                                    <option value="3" {{ $user->state_id == 3 ? 'selected' : '' }}>Inactivo
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Fila 2: Tipo Documento, Documento, Nombre -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Tipo Documento <span class="text-red-500">*</span>
                                </label>
                                <select name="id_tipo_documento" id="id_tipo_documento"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    required>
                                    <option value="">Seleccione</option>
                                    @foreach ($tipodocumentos as $tipodocumento)
                                        <option value="{{ $tipodocumento->id }}"
                                            {{ $tipodocumento->id == $user->id_tipo_documento ? 'selected' : '' }}>
                                            {{ $tipodocumento->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Documento de Identidad <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="documento_identidad" name="documento_identidad"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    value="{{ $user->documento_identidad }}" placeholder="Digite el documento" />
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Nombre <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    value="{{ $user->name }}" placeholder="Digite el Nombre" required />
                            </div>
                        </div>

                        <!-- Fila 3: Apellidos, Email, Celular -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Apellidos <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="lastname" name="lastname"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    value="{{ $user->lastname }}" placeholder="Digite los Apellidos" required />
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    value="{{ $user->email }}" placeholder="Digite el Correo" required />
                                <p id="email-error" class="text-xs text-red-500 hidden">Ingrese un correo electrónico
                                    válido</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Celular <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="phone" name="phone"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    value="{{ $user->phone }}" placeholder="999999999" maxlength="9" />
                                <p id="phone-error" class="text-xs text-red-500 hidden">El celular debe tener 9
                                    dígitos y comenzar con 9</p>
                            </div>
                        </div>

                        <!-- Fila 4: Cargo, DIRIS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Cargo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="cargo" name="cargo"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    value="{{ $user->cargo }}" placeholder="Digite el Cargo" required />
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    DIRIS <span class="text-red-500">*</span>
                                </label>

                                @php
                                    $selectedDiresas = explode(',', $user->iddiresa ?? '');
                                @endphp

                                <div x-data="{
                                    selected: {{ json_encode($selectedDiresas) }},
                                    open: false,
                                    toggleOption(value) {
                                        if (this.selected.includes(value)) {
                                            this.selected = this.selected.filter(v => v !== value);
                                        } else {
                                            this.selected.push(value);
                                        }
                                        this.updateRedes();
                                    },
                                    updateRedes() {
                                        const ids = this.selected.join(',');
                                        if (typeof cargarRedes === 'function') {
                                            cargarRedes(ids);
                                        }
                                    }
                                }" class="relative">
                                    <!-- Select personalizado -->
                                    <div @click="open = !open"
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white cursor-pointer flex justify-between items-center">
                                        <span
                                            x-text="selected.length > 0 ? selected.length + ' DIRIS seleccionada(s)' : 'Seleccione DIRIS'"
                                            class="text-gray-700"></span>
                                        <i class="fas fa-chevron-down text-gray-400 transition-transform"
                                            :class="{ 'rotate-180': open }"></i>
                                    </div>

                                    <!-- Dropdown con opciones -->
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute z-10 mt-1 w-full bg-white rounded-xl border border-gray-200 shadow-lg max-h-60 overflow-y-auto">
                                        <div class="p-2">
                                            @foreach ($diresas as $diresa)
                                                <label
                                                    class="flex items-center gap-3 p-2 hover:bg-blue-50 rounded-lg cursor-pointer">
                                                    <input type="checkbox"
                                                        :checked="selected.includes('{{ $diresa->id }}')"
                                                        @change="toggleOption('{{ $diresa->id }}')"
                                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-gray-700">{{ $diresa->nombre }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Inputs hidden para enviar los valores -->
                                    <template x-for="id in selected" :key="id">
                                        <input type="hidden" name="iddiresa[]" :value="id">
                                    </template>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Seleccione una o más DIRIS</p>
                            </div>
                        </div>

                        <!-- Fila 5: Red, MicroRed, Establecimiento -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Red</label>
                                <select id="red" name="red"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                    <option value="">Seleccione una Red</option>
                                    @if ($user->red)
                                        <option value="{{ $user->red }}" selected>{{ $user->red }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">MicroRed</label>
                                <select id="microred" name="microred"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                    <option value="">Primero seleccione una Red</option>
                                    @if ($user->microred)
                                        <option value="{{ $user->microred }}" selected>{{ $user->microred }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Establecimiento</label>
                                <select id="idestablecimiento" name="idestablecimiento"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                    <option value="">Primero seleccione una MicroRed</option>
                                    @if ($user->idestablecimiento_user)
                                        <option value="{{ $user->idestablecimiento_user }}" selected>
                                            {{ $user->nombre_eess }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-center gap-4 pt-6">
                            <button type="submit"
                                class="px-8 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                            <a href="{{ route('users-index') }}"
                                class="px-8 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function RequiredDiris() {
            const tipoRol = document.getElementById("idtiporol").value;
            const tipoUsuario = document.getElementById("idtipousuario");
            const labelTipoUsuario = document.querySelector("label[for='idtipousuario']");

            if (tipoRol == 1) {
                tipoUsuario.removeAttribute("required");
                labelTipoUsuario.innerHTML = 'Tipo Usuario';
            } else {
                tipoUsuario.setAttribute("required", "required");
                labelTipoUsuario.innerHTML = 'Tipo Usuario <span class="text-red-500">*</span>';
            }
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        function validatePhone(phone) {
            const regex = /^9\d{8}$/;
            return regex.test(phone);
        }

        // Validaciones en tiempo real
        $('#email').on('input', function() {
            const email = $(this).val();
            if (email && !validateEmail(email)) {
                $('#email-error').removeClass('hidden');
                $(this).addClass('border-red-500');
            } else {
                $('#email-error').addClass('hidden');
                $(this).removeClass('border-red-500');
            }
        });

        $('#phone').on('input', function() {
            let phone = $(this).val().replace(/\D/g, '');
            if (phone.length > 9) phone = phone.slice(0, 9);
            $(this).val(phone);

            if (phone && !validatePhone(phone)) {
                $('#phone-error').removeClass('hidden');
                $(this).addClass('border-red-500');
            } else {
                $('#phone-error').addClass('hidden');
                $(this).removeClass('border-red-500');
            }
        });

        $('#phone').on('keypress', function(e) {
            const charCode = e.which ? e.which : e.keyCode;
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });

        // ========== SELECTS PARA RED, MICRORED Y ESTABLECIMIENTO ==========
        function cargarRedes(iddiresaValue) {
            if (!iddiresaValue) {
                var selected = [];
                document.querySelectorAll('#iddiresa option:selected').forEach(function(option) {
                    if (option.value) selected.push(option.value);
                });
                iddiresaValue = selected.join(',') || "0";
            }

            $.ajax({
                url: "{{ route('users-listado-red') }}",
                type: "GET",
                data: {
                    search: "",
                    iddiresa: iddiresaValue
                },
                success: function(response) {
                    var $select = $('#red');
                    var currentVal = $select.val();
                    $select.empty();
                    $select.append('<option value="">Seleccione una Red</option>');

                    if (response.results && response.results.length > 0) {
                        $.each(response.results, function(i, item) {
                            $select.append('<option value="' + item.id + '">' + item.text +
                            '</option>');
                        });
                    }
                    if (currentVal) $select.val(currentVal);
                },
                error: function() {
                    $('#red').html('<option value="">Error al cargar redes</option>');
                }
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Cargar redes iniciales
            cargarRedes();

            // Cuando cambia DIRIS, recargar redes
            $('#iddiresa').on('change', function() {
                cargarRedes();
                $('#microred').html('<option value="">Primero seleccione una Red</option>');
                $('#idestablecimiento').html('<option value="">Primero seleccione una MicroRed</option>');
            });

            // Cargar MicroRedes
            $('#red').on('change', function() {
                var nombre_red = $(this).val();

                if (nombre_red) {
                    $.ajax({
                        url: "{{ route('users-listado-microred') }}",
                        type: "GET",
                        data: {
                            search: "",
                            iddiresa: "0",
                            nombre_red: nombre_red
                        },
                        success: function(response) {
                            var $select = $('#microred');
                            var currentVal = $select.val();
                            $select.empty();
                            $select.append('<option value="">Seleccione una MicroRed</option>');

                            if (response.results && response.results.length > 0) {
                                $.each(response.results, function(i, item) {
                                    $select.append('<option value="' + item.id + '">' +
                                        item.text + '</option>');
                                });
                            }
                            if (currentVal) $select.val(currentVal);
                        }
                    });
                } else {
                    $('#microred').html('<option value="">Primero seleccione una Red</option>');
                    $('#idestablecimiento').html(
                        '<option value="">Primero seleccione una MicroRed</option>');
                }
            });

            // Cargar Establecimientos
            $('#microred').on('change', function() {
                var nombre_red = $('#red').val();
                var nombre_microred = $(this).val();

                if (nombre_microred) {
                    $.ajax({
                        url: "{{ route('users-listado-establecimiento') }}",
                        type: "GET",
                        data: {
                            search: "",
                            iddiresa: "0",
                            nombre_red: nombre_red,
                            nombre_microred: nombre_microred
                        },
                        success: function(response) {
                            var $select = $('#idestablecimiento');
                            var currentVal = $select.val();
                            $select.empty();
                            $select.append(
                                '<option value="">Seleccione un Establecimiento</option>');

                            if (response.results && response.results.length > 0) {
                                $.each(response.results, function(i, item) {
                                    $select.append('<option value="' + item.id + '">' +
                                        item.text + '</option>');
                                });
                            }
                            if (currentVal) $select.val(currentVal);
                        }
                    });
                } else {
                    $('#idestablecimiento').html(
                        '<option value="">Primero seleccione una MicroRed</option>');
                }
            });
        });
    </script>
</x-app-layout>
