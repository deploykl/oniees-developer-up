<x-app-layout>
    <x-slot name="title">Infraestructura - Datos Generales</x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h4 class="text-white text-xl font-bold">1. DATOS GENERALES DEL ESTABLECIMIENTO DE SALUD</h4>
                </div>
                <div class="p-6">

                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 px-4 py-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- SELECTOR DE ESTABLECIMIENTO -->
                    @if (isset($showSelector) && $showSelector)
                        <div class="mb-4 px-4 py-3 bg-blue-100 border-l-4 border-blue-500 text-blue-700 rounded">
                            <h5 class="font-bold mb-2"><i class="fas fa-search"></i> Buscar establecimiento</h5>
                            <p class="mb-3">Ingrese el código RENIPRESS del establecimiento que desea
                                consultar/editar.</p>

                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="flex-1">
                                    <input type="text" id="buscar_codigo"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Ejemplo: 00003253" value="{{ $codigoBuscar ?? '' }}">
                                </div>
                                <div>
                                    <button type="button" id="btn_buscar"
                                        class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>

                            <div id="resultado_busqueda" class="mt-3"></div>
                        </div>
                    @else
                        <!-- FORMULARIO DE DATOS GENERALES -->
                        <form method="POST" action="{{ route('infraestructura.save') }}">
                            @csrf

                            <input type="hidden" name="id_establecimiento" value="{{ $establecimiento->id ?? '' }}">

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CÓDIGO IPRESS
                                        (*)</label>
                                    <input type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        name="codigo_ipress" value="{{ $establecimiento->codigo ?? '' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NOMBRE DEL EESS
                                        (*)</label>
                                    <input type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        name="nombre_eess" value="{{ $establecimiento->nombre_eess ?? '' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">INSTITUCIÓN (*)</label>
                                    <input type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        name="institucion"
                                        value="{{ $establecimiento->institucion ?? 'GOBIERNO REGIONAL' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">REGIÓN</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="region" value="{{ $establecimiento->region ?? '' }}">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">PROVINCIA</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="provincia" value="{{ $establecimiento->provincia ?? '' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">DISTRITO</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="distrito" value="{{ $establecimiento->distrito ?? '' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">RED</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="red" value="{{ $establecimiento->nombre_red ?? '' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">MICRORED</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="microred" value="{{ $establecimiento->nombre_microred ?? '' }}">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">
                                <!-- NIVEL DE ATENCIÓN - 2 columnas (angosto) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIVEL DE
                                        ATENCIÓN</label>
                                    <select name="nivel_atencion"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Seleccione</option>
                                        <option value="I"
                                            {{ ($establecimiento->nivel_atencion ?? '') == 'I' ? 'selected' : '' }}>I
                                        </option>
                                        <option value="II"
                                            {{ ($establecimiento->nivel_atencion ?? '') == 'II' ? 'selected' : '' }}>II
                                        </option>
                                        <option value="III"
                                            {{ ($establecimiento->nivel_atencion ?? '') == 'III' ? 'selected' : '' }}>
                                            III</option>
                                        <option value="Sin Categoría"
                                            {{ ($establecimiento->nivel_atencion ?? '') == 'Sin Categoría' ? 'selected' : '' }}>
                                            Sin Categoría</option>
                                    </select>
                                </div>

                                <!-- CATEGORÍA - 2 columnas (angosto) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CATEGORÍA</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="categoria" value="{{ $establecimiento->categoria ?? '' }}">
                                </div>

                                <!-- RESOLUCIÓN DE CATEGORÍA - 3 columnas -->
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">RESOLUCIÓN DE
                                        CATEGORÍA</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="resolucion_categoria"
                                        value="{{ $establecimiento->resolucion_categoria ?? '' }}">
                                </div>

                                <!-- CLASIFICACIÓN - 3 columnas -->
                                <div class="md:col-span-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CLASIFICACIÓN</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="clasificacion" value="{{ $establecimiento->clasificacion ?? '' }}">
                                </div>
                                <div class="md:col-span-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">TIPO</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="tipo" value="{{ $establecimiento->tipo ?? '' }}">
                                </div>

                                <div class="md:col-span-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">COD UE </label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="codigo_ue" value="{{ $establecimiento->codigo_ue ?? '' }}">
                                </div>
                                <div class="md:col-span-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">UNIDAD EJECUTORA</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="unidad_ejecutora" value="{{ $establecimiento->unidad_ejecutora ?? '' }}">
                                </div>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">TELÉFONO</label>
                                        <input type="text"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg" name="telefono"
                                            value="{{ $establecimiento->telefono ?? '' }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">NÚMERO DE
                                            CAMAS</label>
                                        <input type="number"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                            name="numero_camas" value="{{ $establecimiento->numero_camas ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">DIRECTOR MÉDICO</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="director_medico" value="{{ $establecimiento->director_medico ?? '' }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">HORARIO</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        name="horario" value="{{ $establecimiento->horario ?? '' }}">
                                </div>
                            </div>

                            @if (Auth::user() && !Auth::user()->idestablecimiento_user)
                                <div class="mb-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600"
                                            name="asignar_a_mi" value="1">
                                        <span class="ml-2 text-sm text-gray-700">Asignar este establecimiento a mi
                                            usuario (para futuros accesos)</span>
                                    </label>
                                </div>
                            @endif

                            <div class="flex justify-center gap-3 mt-6">
                                <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-save"></i> GUARDAR
                                </button>
                                <a href="{{ route('infraestructura.edit') }}"
                                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                    <i class="fas fa-eraser"></i> LIMPIAR
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btn_buscar').on('click', function() {
                var codigo = $('#buscar_codigo').val();

                if (!codigo) {
                    alert('Ingrese un código RENIPRESS');
                    return;
                }

                window.location.href = '{{ route('infraestructura.edit') }}?codigo=' + codigo;
            });

            var urlParams = new URLSearchParams(window.location.search);
            var codigoParam = urlParams.get('codigo');

            if (codigoParam && {{ isset($showSelector) && $showSelector ? 'true' : 'false' }}) {
                $.ajax({
                    url: '{{ url('/infraestructura/buscar') }}/' + codigoParam,
                    type: 'GET',
                    success: function(response) {
                        var html =
                            '<div class="mt-3 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">';
                        html +=
                            '<h5 class="font-bold"><i class="fas fa-check-circle"></i> Establecimiento encontrado</h5>';
                        html += '<p class="mt-2"><strong>Código:</strong> ' + response.codigo + '<br>';
                        html += '<strong>Nombre:</strong> ' + response.nombre + '<br>';
                        html += '<strong>Región:</strong> ' + (response.region || '-') + '<br>';
                        html += '<strong>Provincia:</strong> ' + (response.provincia || '-') + '<br>';
                        html += '<strong>Distrito:</strong> ' + (response.distrito || '-') + '</p>';
                        html +=
                            '<button type="button" id="seleccionar_establecimiento" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Seleccionar este establecimiento</button>';
                        html += '</div>';
                        $('#resultado_busqueda').html(html);

                        $('#seleccionar_establecimiento').on('click', function() {
                            window.location.href =
                                '{{ route('infraestructura.edit') }}?cargar=' + response.id;
                        });
                    },
                    error: function(xhr) {
                        var errorMsg = 'Error al buscar';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        $('#resultado_busqueda').html(
                            '<div class="mt-3 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">' +
                            errorMsg + '</div>');
                    }
                });
            }
        });
    </script>
</x-app-layout>
