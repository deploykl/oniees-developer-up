<x-app-layout>
    <x-slot name="title">Usuarios</x-slot>
    <x-slot name="subtitle">Crear Usuario</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <form id="FormUserCreate" action="{{ route('users-save') }}" method="post"
                        class="space-y-6 needs-validation">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}" />

                        <h3 class="text-2xl font-bold text-center text-gray-800">Registro de Usuario</h3>

                        <!-- Fila 1: Tipo Rol, Tipo Usuario, Estado -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tipo Rol <span class="text-red-500">*</span>
                                </label>
                                <select id="idtiporol" name="idtiporol" onchange="RequiredDiris()"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                    <option value="">Seleccione</option>
                                    @if (Auth::user()->idtiporol == 1)
                                        <option value="1">Minsa-Dgos-Diem</option>
                                    @endif
                                    <option value="2">Diresa/Geresa/Diris</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden">Seleccione el Tipo de Usuario</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tipo Usuario <span class="text-red-500">*</span>
                                </label>
                                <select id="idtipousuario" name="idtipousuario"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
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

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Estado <span class="text-red-500">*</span>
                                </label>
                                <select id="state_id" name="state_id"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                    <option value="2">Activo</option>
                                    <option value="3">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Fila 2: Tipo Documento, Documento, Nombre -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tipo Documento <span class="text-red-500">*</span>
                                </label>
                                <select name="id_tipo_documento" id="id_tipo_documento"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
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

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Documento de Identidad <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="documento_identidad" name="documento_identidad"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ $user->documento_identidad }}" placeholder="Digite el documento" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nombre <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ $user->name }}" placeholder="Digite el Nombre" required />
                            </div>
                        </div>

                        <!-- Fila 3: Apellidos, Email, Celular -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Apellidos <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="lastname" name="lastname"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ $user->lastname }}" placeholder="Digite los Apellidos" required />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ $user->email }}" placeholder="Digite el Correo" required />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Celular <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="phone" name="phone"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ $user->phone }}" placeholder="Celular" required />
                            </div>
                        </div>

                        <!-- Fila 4: Cargo, DIRIS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Cargo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="cargo" name="cargo"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    value="{{ $user->cargo }}" placeholder="Digite el Cargo" required />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    DIRIS
                                </label>
                                <select id="iddiresa" name="iddiresa[]" multiple
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    @foreach ($diresas as $diresa)
                                        <option value="{{ $diresa->id }}">{{ $diresa->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Fila 5: Red, MicroRed, Establecimiento -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Red</label>
                                <select id="red" name="red"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">MicroRed</label>
                                <select id="microred" name="microred"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Establecimiento</label>
                                <select id="idestablecimiento" name="idestablecimiento"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>

                        <!-- Fila 6: Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password" name="password"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Contraseña" required />
                            <div id="pswd_info" class="hidden mt-2 p-3 bg-gray-50 rounded-lg text-sm">
                                <p class="font-semibold mb-2">La contraseña debe cumplir:</p>
                                <ul class="space-y-1">
                                    <li id="letter" class="text-red-600">✗ Al menos una letra</li>
                                    <li id="capital" class="text-red-600">✗ Al menos una mayúscula</li>
                                    <li id="number" class="text-red-600">✗ Al menos un número</li>
                                    <li id="length" class="text-red-600">✗ Al menos 8 caracteres</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-center gap-4 pt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                                <i class="fas fa-save mr-2"></i> Guardar
                            </button>
                            <a href="{{ route('users-index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition">
                                <i class="fas fa-arrow-left mr-2"></i> Regresar
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

    function CambiarTipo(input) {
        var tipo = $("#" + input).prop("type");
        $("#" + input).prop("type", (tipo == "text" ? "password" : "text"));
    }

    function PasswordValidate() {
        var pswd = $("#password").val();
        var result = true;

        $("#pswd_info").show();

        if (pswd.length < 8) {
            $('#length').removeClass('text-green-600').addClass('text-red-600');
            result = false;
        } else {
            $('#length').removeClass('text-red-600').addClass('text-green-600');
        }

        if (!!pswd.match(/[A-z]/)) {
            $('#letter').removeClass('text-red-600').addClass('text-green-600');
        } else {
            $('#letter').removeClass('text-green-600').addClass('text-red-600');
            result = false;
        }

        if (!!pswd.match(/[A-Z]/)) {
            $('#capital').removeClass('text-red-600').addClass('text-green-600');
        } else {
            $('#capital').removeClass('text-green-600').addClass('text-red-600');
            result = false;
        }

        if (!!pswd.match(/\d/)) {
            $('#number').removeClass('text-red-600').addClass('text-green-600');
        } else {
            $('#number').removeClass('text-green-600').addClass('text-red-600');
            result = false;
        }

        if (result) {
            $("#pswd_info").hide();
        }
        return result;
    }

    // ✅ SOLO validar, NO prevenir el envío
    $('#FormUserCreate').on('submit', function(e) {
        if (!PasswordValidate()) {
            e.preventDefault();
            Swal.fire('Error', 'La contraseña no cumple los requisitos', 'error');
        }
        // Si la contraseña es válida, NO hacer nada, el formulario se envía normalmente
    });
</script>
</x-app-layout>
