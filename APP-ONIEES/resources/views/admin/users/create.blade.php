<x-app-layout>
    <x-slot name="title">Usuarios</x-slot>
    <x-slot name="subtitle">Crear Usuario</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="p-6 lg:p-8">
                    <form id="FormUserCreate" action="{{ route('users-save') }}" method="post"
                        class="space-y-6 needs-validation">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}" />

                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                Registro de Usuario
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
                                        <option value="1">Minsa-Dgos-Diem</option>
                                    @endif
                                    <option value="2">Diresa/Geresa/Diris</option>
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
                                    <option value="2">Activo</option>
                                    <option value="3">Inactivo</option>
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
                                <p id="email-error" class="text-xs text-red-500 hidden">Ingrese un correo electrónico válido</p>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">
                                    Celular <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="phone" name="phone"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    value="{{ $user->phone }}" placeholder="999999999" maxlength="9" />
                                <p id="phone-error" class="text-xs text-red-500 hidden">El celular debe tener 9 dígitos y comenzar con 9</p>
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
                                <select id="iddiresa" name="iddiresa"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white"
                                    required>
                                    <option value="">Seleccione una DIRIS</option>
                                    @foreach ($diresas as $diresa)
                                        <option value="{{ $diresa->id }}">{{ $diresa->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Fila 5: Red, MicroRed, Establecimiento -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Red</label>
                                <select id="red" name="red"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                    <option value="">Seleccione una Red</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">MicroRed</label>
                                <select id="microred" name="microred"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                    <option value="">Primero seleccione una Red</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Establecimiento</label>
                                <select id="idestablecimiento" name="idestablecimiento"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                    <option value="">Primero seleccione una MicroRed</option>
                                </select>
                            </div>
                        </div>

                        <!-- Fila 6: Contraseña -->
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white pr-12"
                                    placeholder="Contraseña" required />
                                <button type="button" onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i id="togglePasswordIcon" class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <div id="pswd_info" class="hidden mt-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-sm font-semibold text-gray-700 mb-2">La contraseña debe cumplir:</p>
                                <ul class="space-y-1 text-sm">
                                    <li id="letter" class="text-red-500 flex items-center gap-2">
                                        <i class="fas fa-times-circle text-xs"></i> Al menos una letra
                                    </li>
                                    <li id="capital" class="text-red-500 flex items-center gap-2">
                                        <i class="fas fa-times-circle text-xs"></i> Al menos una mayúscula
                                    </li>
                                    <li id="number" class="text-red-500 flex items-center gap-2">
                                        <i class="fas fa-times-circle text-xs"></i> Al menos un número
                                    </li>
                                    <li id="length" class="text-red-500 flex items-center gap-2">
                                        <i class="fas fa-times-circle text-xs"></i> Al menos 8 caracteres
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-center gap-4 pt-6">
                            <button type="submit"
                                class="px-8 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                <i class="fas fa-save"></i> Guardar
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
        // Validación de email
        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        // Validación de celular
        function validatePhone(phone) {
            const regex = /^9\d{8}$/;
            return regex.test(phone);
        }

        // Mostrar/ocultar contraseña
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

        function CambiarTipo(input) {
            var tipo = $("#" + input).prop("type");
            $("#" + input).prop("type", (tipo == "text" ? "password" : "text"));
        }

        function PasswordValidate() {
            var pswd = $("#password").val();
            var result = true;

            $("#pswd_info").show();

            if (pswd.length < 8) {
                $('#length').removeClass('text-green-500').addClass('text-red-500');
                $('#length i').removeClass('fa-check-circle').addClass('fa-times-circle');
                result = false;
            } else {
                $('#length').removeClass('text-red-500').addClass('text-green-500');
                $('#length i').removeClass('fa-times-circle').addClass('fa-check-circle');
            }

            if (!!pswd.match(/[A-z]/)) {
                $('#letter').removeClass('text-red-500').addClass('text-green-500');
                $('#letter i').removeClass('fa-times-circle').addClass('fa-check-circle');
            } else {
                $('#letter').removeClass('text-green-500').addClass('text-red-500');
                $('#letter i').removeClass('fa-check-circle').addClass('fa-times-circle');
                result = false;
            }

            if (!!pswd.match(/[A-Z]/)) {
                $('#capital').removeClass('text-red-500').addClass('text-green-500');
                $('#capital i').removeClass('fa-times-circle').addClass('fa-check-circle');
            } else {
                $('#capital').removeClass('text-green-500').addClass('text-red-500');
                $('#capital i').removeClass('fa-check-circle').addClass('fa-times-circle');
                result = false;
            }

            if (!!pswd.match(/\d/)) {
                $('#number').removeClass('text-red-500').addClass('text-green-500');
                $('#number i').removeClass('fa-times-circle').addClass('fa-check-circle');
            } else {
                $('#number').removeClass('text-green-500').addClass('text-red-500');
                $('#number i').removeClass('fa-check-circle').addClass('fa-times-circle');
                result = false;
            }

            if (result) {
                $("#pswd_info").hide();
            }
            return result;
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

        // Validar contraseña antes de enviar
        $('#FormUserCreate').on('submit', function(e) {
            let isValid = true;
            
            const email = $('#email').val();
            if (email && !validateEmail(email)) {
                isValid = false;
                $('#email-error').removeClass('hidden');
                $('#email').addClass('border-red-500');
            }
            
            const phone = $('#phone').val();
            if (phone && !validatePhone(phone)) {
                isValid = false;
                $('#phone-error').removeClass('hidden');
                $('#phone').addClass('border-red-500');
            }
            
            if (!PasswordValidate()) {
                isValid = false;
                Swal.fire('Error', 'La contraseña no cumple los requisitos', 'error');
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });

        // ========== SELECTS PARA RED, MICRORED Y ESTABLECIMIENTO ==========
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Cuando cambia DIRIS, recargar redes
            $('#iddiresa').on('change', function() {
                cargarRedes();
                $('#microred').html('<option value="">Primero seleccione una Red</option>');
                $('#idestablecimiento').html('<option value="">Primero seleccione una MicroRed</option>');
            });

            function cargarRedes() {
                var iddiresaValue = $("#iddiresa").val() || "0";

                $.ajax({
                    url: "{{ route('users-listado-red') }}",
                    type: "GET",
                    data: { search: "", iddiresa: iddiresaValue },
                    success: function(response) {
                        var $select = $('#red');
                        $select.empty();
                        $select.append('<option value="">Seleccione una Red</option>');

                        if (response.results && response.results.length > 0) {
                            $.each(response.results, function(i, item) {
                                $select.append('<option value="' + item.id + '">' + item.text + '</option>');
                            });
                        }
                    },
                    error: function() {
                        $('#red').html('<option value="">Error al cargar redes</option>');
                    }
                });
            }

            $('#red').on('change', function() {
                var nombre_red = $(this).val();

                if (nombre_red) {
                    $.ajax({
                        url: "{{ route('users-listado-microred') }}",
                        type: "GET",
                        data: { search: "", iddiresa: "0", nombre_red: nombre_red },
                        success: function(response) {
                            var $select = $('#microred');
                            $select.empty();
                            $select.append('<option value="">Seleccione una MicroRed</option>');

                            if (response.results && response.results.length > 0) {
                                $.each(response.results, function(i, item) {
                                    $select.append('<option value="' + item.id + '">' + item.text + '</option>');
                                });
                            }
                        }
                    });
                } else {
                    $('#microred').html('<option value="">Primero seleccione una Red</option>');
                    $('#idestablecimiento').html('<option value="">Primero seleccione una MicroRed</option>');
                }
            });

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
                            $select.empty();
                            $select.append('<option value="">Seleccione un Establecimiento</option>');

                            if (response.results && response.results.length > 0) {
                                $.each(response.results, function(i, item) {
                                    $select.append('<option value="' + item.id + '">' + item.text + '</option>');
                                });
                            }
                        }
                    });
                } else {
                    $('#idestablecimiento').html('<option value="">Primero seleccione una MicroRed</option>');
                }
            });

            cargarRedes();
        });
    </script>
</x-app-layout>