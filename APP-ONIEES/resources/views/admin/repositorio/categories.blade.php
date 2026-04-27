<x-app-layout>
    <x-slot name="title">
        Gestionar Categorías
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .category-card {
            transition: all 0.2s ease;
            border: 1px solid #f0f0f0;
        }
        .category-card:hover {
            border-color: #e0e0e0;
            box-shadow: 0 8px 20px rgba(0,0,0,0.03);
        }
        .resource-chip {
            transition: all 0.2s ease;
            background: #fafbfc;
        }
        .resource-chip:hover {
            background: #f0f4f8;
            transform: translateY(-1px);
        }
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
        .toggle-switch {
            transition: background-color 0.2s ease;
        }
        .toggle-switch:after {
            transition: transform 0.2s ease;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 tracking-tight flex items-center gap-2">
                    <i class="fas fa-layer-group text-[#0E7C9E] text-xl"></i>
                    Categorías del Repositorio
                </h1>
                <p class="text-sm text-gray-400 mt-0.5">Organiza y gestiona todos los recursos digitales</p>
            </div>
            <button id="btnNuevaCategoria"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0E7C9E] hover:bg-[#0B6A88] text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md active:scale-95">
                <i class="fas fa-plus text-xs"></i> Nueva Categoría
            </button>
        </div>

        <!-- Lista de categorías -->
        <div id="listaCategorias" class="space-y-5">
            @if ($categories->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder-open text-2xl text-[#0E7C9E] opacity-70"></i>
                    </div>
                    <p class="text-gray-500 text-sm">No hay categorías creadas todavía</p>
                    <button id="btnCrearPrimera"
                        class="mt-4 inline-flex items-center gap-2 px-5 py-2 bg-[#0E7C9E] hover:bg-[#0B6A88] text-white text-sm font-medium rounded-xl transition">
                        <i class="fas fa-plus text-xs"></i> Crear primera categoría
                    </button>
                </div>
            @else
                @foreach ($categories as $category)
                    <div class="category-card bg-white rounded-2xl shadow-sm overflow-hidden" id="cat-{{ $category->id }}">
                        <!-- Header categoría -->
                        <div class="px-6 py-4 border-b border-gray-50 flex flex-wrap items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-[#0E7C9E]/5 rounded-xl flex items-center justify-center">
                                    <i class="{{ $category->icon ?? 'fas fa-folder' }} text-[#0E7C9E] text-lg"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h2 class="text-lg font-semibold text-gray-800">{{ $category->name }}</h2>
                                        @if ($category->is_active)
                                            <span class="text-xs bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-full font-medium">Activo</span>
                                        @else
                                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-medium">Inactivo</span>
                                        @endif
                                    </div>
                                    @if($category->description)
                                        <p class="text-sm text-gray-400 mt-0.5">{{ $category->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="abrirModalSubcategoria({{ $category->id }})"
                                    class="p-2 text-gray-400 hover:text-emerald-600 rounded-lg transition-colors" title="Agregar subcategoría">
                                    <i class="fas fa-plus-circle text-sm"></i>
                                </button>
                                <button type="button"
                                    onclick="editarCategoria({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description) }}', '{{ $category->icon ?? 'fas fa-folder' }}', {{ $category->is_active ? 1 : 0 }})"
                                    class="p-2 text-gray-400 hover:text-blue-500 rounded-lg transition-colors" title="Editar categoría">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button type="button" onclick="eliminarCategoria({{ $category->id }})"
                                    class="p-2 text-gray-400 hover:text-red-500 rounded-lg transition-colors" title="Eliminar categoría">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Subcategorías -->
                        <div class="px-6 py-4 space-y-4">
                            @foreach ($category->subcategories as $sub)
                                <div class="pl-3 border-l-2 border-[#0E7C9E]/20" id="sub-{{ $sub->id }}">
                                    <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="font-medium text-gray-700 text-sm">{{ $sub->name }}</span>
                                                @if ($sub->is_active)
                                                    <span class="text-xs bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-full font-medium">Activo</span>
                                                @else
                                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-medium">Inactivo</span>
                                                @endif
                                            </div>
                                            @if($sub->description)
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $sub->description }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-0.5">
                                            <button type="button"
                                                onclick="abrirModalRecurso(null, {{ $sub->id }})"
                                                class="p-1.5 text-gray-400 hover:text-emerald-600 rounded-md transition-colors text-xs" title="Agregar recurso">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                            <button type="button"
                                                onclick="editarSubcategoria({{ $sub->id }}, {{ $sub->category_id }}, '{{ addslashes($sub->name) }}', '{{ addslashes($sub->description) }}', {{ $sub->is_active ? 1 : 0 }})"
                                                class="p-1.5 text-gray-400 hover:text-blue-500 rounded-md transition-colors text-xs" title="Editar subcategoría">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" onclick="eliminarSubcategoria({{ $sub->id }})"
                                                class="p-1.5 text-gray-400 hover:text-red-500 rounded-md transition-colors text-xs" title="Eliminar subcategoría">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Recursos - chips horizontales -->
                                    <div class="flex flex-wrap gap-2 mt-2 ml-0">
                                        @foreach ($sub->resources as $recurso)
                                            <div class="resource-chip inline-flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-full border border-gray-100 text-sm transition-all"
                                                id="recurso-{{ $recurso->id }}">
                                                <i class="{{ $recurso->getIcon() }} text-[#0E7C9E] text-xs"></i>
                                                <span class="text-gray-600 text-xs max-w-[150px] truncate">{{ $recurso->title }}</span>
                                                <div class="flex items-center gap-1 ml-1">
                                                    <a href="{{ $recurso->getResourceUrl() }}" target="_blank"
                                                        class="text-gray-400 hover:text-emerald-600 p-0.5 transition-colors" title="Ver">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="editarRecurso({{ json_encode($recurso) }}, {{ $sub->id }})"
                                                        class="text-gray-400 hover:text-blue-500 p-0.5 transition-colors" title="Editar">
                                                        <i class="fas fa-edit text-xs"></i>
                                                    </button>
                                                    <button type="button"
                                                        onclick="eliminarRecurso({{ $recurso->id }})"
                                                        class="text-gray-400 hover:text-red-500 p-0.5 transition-colors" title="Eliminar">
                                                        <i class="fas fa-trash-alt text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($sub->resources->isEmpty())
                                            <span class="text-xs text-gray-400 italic">Sin recursos</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @if($category->subcategories->isEmpty())
                                <div class="text-center py-6">
                                    <i class="fas fa-folder-open text-gray-300 text-2xl mb-2 block"></i>
                                    <p class="text-xs text-gray-400">Esta categoría no tiene subcategorías</p>
                                    <button type="button" onclick="abrirModalSubcategoria({{ $category->id }})"
                                        class="mt-2 text-xs text-[#0E7C9E] hover:underline inline-flex items-center gap-1">
                                        <i class="fas fa-plus-circle"></i> Agregar primera subcategoría
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- MODAL CATEGORÍA -->
    <div id="modalCategoria" class="fixed inset-0 bg-black/40 modal-backdrop z-50" style="display:none;">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl transform transition-all">
                <div class="flex items-center justify-between mb-5">
                    <h3 id="modalCategoriaTitulo" class="text-lg font-semibold text-gray-800">Nueva Categoría</h3>
                    <button onclick="cerrarModal('modalCategoria')" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="formCategoria">
                    <input type="hidden" id="categoria_id">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                        <input type="text" id="cat_nombre"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="cat_descripcion" rows="2"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icono (Font Awesome)</label>
                        <input type="text" id="cat_icono" value="fas fa-folder"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition">
                        <p class="text-xs text-gray-400 mt-1">Ej: fas fa-folder, fas fa-chart-line, fas fa-users</p>
                    </div>
                    <div class="mb-6 flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="cat_activo" class="sr-only peer" checked>
                            <div class="toggle-switch w-10 h-5 bg-gray-200 peer-checked:bg-[#0E7C9E] rounded-full transition-colors relative after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-transform peer-checked:after:translate-x-5"></div>
                            <span class="ml-2 text-sm text-gray-500" id="cat_activo_label">Activo</span>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="cerrarModal('modalCategoria')"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancelar</button>
                        <button type="submit"
                            class="px-5 py-2 bg-[#0E7C9E] hover:bg-[#0B6A88] text-white text-sm font-medium rounded-xl transition shadow-sm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL SUBCATEGORÍA -->
    <div id="modalSubcategoria" class="fixed inset-0 bg-black/40 modal-backdrop z-50" style="display:none;">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 id="modalSubcategoriaTitulo" class="text-lg font-semibold text-gray-800">Nueva Subcategoría</h3>
                    <button onclick="cerrarModal('modalSubcategoria')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="formSubcategoria">
                    <input type="hidden" id="subcategoria_id">
                    <input type="hidden" id="sub_categoria_id">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                        <input type="text" id="sub_nombre"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="sub_descripcion" rows="2"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition"></textarea>
                    </div>
                    <div class="mb-6 flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="sub_activo" class="sr-only peer" checked>
                            <div class="toggle-switch w-10 h-5 bg-gray-200 peer-checked:bg-[#0E7C9E] rounded-full transition-colors relative after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-transform peer-checked:after:translate-x-5"></div>
                            <span class="ml-2 text-sm text-gray-500" id="sub_activo_label">Activo</span>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="cerrarModal('modalSubcategoria')"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancelar</button>
                        <button type="submit"
                            class="px-5 py-2 bg-[#0E7C9E] hover:bg-[#0B6A88] text-white text-sm font-medium rounded-xl transition shadow-sm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL RECURSO -->
    <div id="modalRecurso" class="fixed inset-0 bg-black/40 modal-backdrop z-50" style="display:none;">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 id="modalRecursoTitulo" class="text-lg font-semibold text-gray-800">Nuevo Recurso</h3>
                    <button onclick="cerrarModal('modalRecurso')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="formRecurso" enctype="multipart/form-data">
                    <input type="hidden" id="recurso_id">
                    <input type="hidden" id="recurso_subcategoria_id">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                        <input type="text" id="rec_titulo"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="rec_descripcion" rows="2"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Recurso *</label>
                        <select id="rec_tipo" onchange="toggleTipoRecurso()"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition">
                            <option value="powerbi">Power BI (Enlace)</option>
                            <option value="link">Enlace externo</option>
                            <option value="file">Archivo (PDF, Excel, Word, Imagen)</option>
                        </select>
                    </div>
                    <div id="url_recursos" class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                        <input type="url" id="rec_url"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0E7C9E]/20 focus:border-[#0E7C9E] transition"
                            placeholder="https://...">
                    </div>
                    <div id="file_recursos" class="mb-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo</label>
                        <input type="file" id="rec_file"
                            class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition cursor-pointer"
                            accept=".pdf,.xlsx,.xls,.xlsm,.docx,.doc,.ppt,.pptx,.jpg,.png,.gif,.txt,.csv,.zip">
                        <div id="archivo_actual" class="hidden mt-2 text-xs text-gray-400"></div>
                    </div>
                    <div class="flex justify-end gap-3 mt-2">
                        <button type="button" onclick="cerrarModal('modalRecurso')"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Cancelar</button>
                        <button type="submit"
                            class="px-5 py-2 bg-[#0E7C9E] hover:bg-[#0B6A88] text-white text-sm font-medium rounded-xl transition shadow-sm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // ─── TOGGLE TIPO RECURSO ─────────────────────────────────────────────────
        function toggleTipoRecurso() {
            const tipo = $('#rec_tipo').val();
            if (tipo === 'file') {
                $('#url_recursos').addClass('hidden');
                $('#file_recursos').removeClass('hidden');
            } else {
                $('#url_recursos').removeClass('hidden');
                $('#file_recursos').addClass('hidden');
            }
        }

        // ─── CERRAR MODAL ────────────────────────────────────────────────────────
        function cerrarModal(modalId) {
            $('#' + modalId).fadeOut(200);
        }

        // ─── CATEGORÍAS ──────────────────────────────────────────────────────────
        function abrirModalCategoria(id = null, nombre = '', descripcion = '', icono = 'fas fa-folder', activo = 1) {
            $('#modalCategoria').fadeIn(200);
            if (id) {
                $('#modalCategoriaTitulo').text('Editar Categoría');
                $('#categoria_id').val(id);
                $('#cat_nombre').val(nombre);
                $('#cat_descripcion').val(descripcion);
                $('#cat_icono').val(icono);
                $('#cat_activo').prop('checked', activo == 1);
                $('#cat_activo_label').text(activo == 1 ? 'Activo' : 'Inactivo');
            } else {
                $('#modalCategoriaTitulo').text('Nueva Categoría');
                $('#formCategoria')[0].reset();
                $('#categoria_id').val('');
                $('#cat_icono').val('fas fa-folder');
                $('#cat_activo').prop('checked', true);
                $('#cat_activo_label').text('Activo');
            }
        }

        function editarCategoria(id, nombre, descripcion, icono, activo) {
            abrirModalCategoria(id, nombre, descripcion, icono, activo);
        }

        function eliminarCategoria(id) {
            if (confirm('¿Eliminar esta categoría? Se eliminarán también sus subcategorías y recursos.')) {
                $.ajax({
                    url: '/admin/repositorio/api/categories/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) location.reload();
                        else alert('Error: ' + (response.message || 'No se pudo eliminar'));
                    },
                    error: function() {
                        alert('Error en el servidor');
                    }
                });
            }
        }

        // ─── SUBCATEGORÍAS ───────────────────────────────────────────────────────
        function abrirModalSubcategoria(categoryId, id = null, nombre = '', descripcion = '', activo = 1) {
            $('#modalSubcategoria').fadeIn(200);
            $('#sub_categoria_id').val(categoryId);
            if (id) {
                $('#modalSubcategoriaTitulo').text('Editar Subcategoría');
                $('#subcategoria_id').val(id);
                $('#sub_nombre').val(nombre);
                $('#sub_descripcion').val(descripcion);
                $('#sub_activo').prop('checked', activo == 1);
                $('#sub_activo_label').text(activo == 1 ? 'Activo' : 'Inactivo');
            } else {
                $('#modalSubcategoriaTitulo').text('Nueva Subcategoría');
                $('#formSubcategoria')[0].reset();
                $('#subcategoria_id').val('');
                $('#sub_activo').prop('checked', true);
                $('#sub_activo_label').text('Activo');
            }
        }

        function editarSubcategoria(id, categoryId, nombre, descripcion, activo) {
            abrirModalSubcategoria(categoryId, id, nombre, descripcion, activo);
        }

        function eliminarSubcategoria(id) {
            if (confirm('¿Eliminar esta subcategoría? Se eliminarán también sus recursos.')) {
                $.ajax({
                    url: '/admin/repositorio/api/subcategories/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) location.reload();
                        else alert('Error: ' + (response.message || 'No se pudo eliminar'));
                    },
                    error: function() {
                        alert('Error en el servidor');
                    }
                });
            }
        }

        // ─── RECURSOS ────────────────────────────────────────────────────────────
        function abrirModalRecurso(recurso = null, subcategoriaId) {
            $('#modalRecurso').fadeIn(200);
            $('#recurso_subcategoria_id').val(subcategoriaId);
            if (recurso) {
                $('#modalRecursoTitulo').text('Editar Recurso');
                $('#recurso_id').val(recurso.id);
                $('#rec_titulo').val(recurso.title);
                $('#rec_descripcion').val(recurso.description || '');
                $('#rec_tipo').val(recurso.type);
                toggleTipoRecurso();
                if (recurso.type !== 'file') {
                    $('#rec_url').val(recurso.url);
                } else {
                    $('#archivo_actual')
                        .text('Archivo actual: ' + (recurso.file_name || '') + ' (' + (recurso.file_size || '') + ')')
                        .removeClass('hidden');
                }
            } else {
                $('#modalRecursoTitulo').text('Nuevo Recurso');
                $('#formRecurso')[0].reset();
                $('#recurso_id').val('');
                $('#archivo_actual').addClass('hidden');
                toggleTipoRecurso();
            }
        }

        function editarRecurso(recurso, subcategoriaId) {
            abrirModalRecurso(recurso, subcategoriaId);
        }

        function eliminarRecurso(id) {
            if (confirm('¿Eliminar este recurso?')) {
                $.ajax({
                    url: '/admin/repositorio/api/resources/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) location.reload();
                        else alert('Error: ' + (response.message || 'No se pudo eliminar'));
                    },
                    error: function() {
                        alert('Error en el servidor');
                    }
                });
            }
        }

        // ─── DOCUMENT READY ──────────────────────────────────────────────────────
        $(document).ready(function() {

            $('#btnNuevaCategoria, #btnCrearPrimera').on('click', function(e) {
                e.preventDefault();
                abrirModalCategoria();
            });

            // Cerrar al hacer clic fuera del contenido
            $('#modalCategoria, #modalSubcategoria, #modalRecurso').on('click', function(e) {
                if (e.target === this) cerrarModal($(this).attr('id'));
            });

            // Cerrar con ESC
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    cerrarModal('modalCategoria');
                    cerrarModal('modalSubcategoria');
                    cerrarModal('modalRecurso');
                }
            });

            // Actualizar label del toggle al cambiar manualmente
            $('#cat_activo').on('change', function() {
                $('#cat_activo_label').text(this.checked ? 'Activo' : 'Inactivo');
            });
            $('#sub_activo').on('change', function() {
                $('#sub_activo_label').text(this.checked ? 'Activo' : 'Inactivo');
            });

            // ── Submit Categoría ────────────────────────────────────────────────
            $('#formCategoria').on('submit', function(e) {
                e.preventDefault();
                const id = $('#categoria_id').val();
                const url = id ? '/admin/repositorio/api/categories/' + id :
                    '/admin/repositorio/api/categories';
                $.ajax({
                    url: url,
                    type: id ? 'PUT' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        name: $('#cat_nombre').val(),
                        description: $('#cat_descripcion').val(),
                        icon: $('#cat_icono').val(),
                        is_active: $('#cat_activo').is(':checked') ? 1 : 0
                    }),
                    success: function(response) {
                        if (response.success) {
                            cerrarModal('modalCategoria');
                            location.reload();
                        } else alert('Error: ' + (response.message || 'No se pudo guardar'));
                    },
                    error: function() {
                        alert('Error en el servidor');
                    }
                });
            });

            // ── Submit Subcategoría ─────────────────────────────────────────────
            $('#formSubcategoria').on('submit', function(e) {
                e.preventDefault();
                const id = $('#subcategoria_id').val();
                const url = id ? '/admin/repositorio/api/subcategories/' + id :
                    '/admin/repositorio/api/subcategories';
                $.ajax({
                    url: url,
                    type: id ? 'PUT' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        category_id: $('#sub_categoria_id').val(),
                        name: $('#sub_nombre').val(),
                        description: $('#sub_descripcion').val(),
                        is_active: $('#sub_activo').is(':checked') ? 1 : 0
                    }),
                    success: function(response) {
                        if (response.success) {
                            cerrarModal('modalSubcategoria');
                            location.reload();
                        } else alert('Error: ' + (response.message || 'No se pudo guardar'));
                    },
                    error: function() {
                        alert('Error en el servidor');
                    }
                });
            });

            // ── Submit Recurso ──────────────────────────────────────────────────
            $('#formRecurso').on('submit', function(e) {
                e.preventDefault();
                const id = $('#recurso_id').val();
                const url = id ? '/admin/repositorio/api/resources/' + id :
                    '/admin/repositorio/api/resources';
                const formData = new FormData();
                formData.append('subcategory_id', $('#recurso_subcategoria_id').val());
                formData.append('title', $('#rec_titulo').val());
                formData.append('description', $('#rec_descripcion').val());
                formData.append('type', $('#rec_tipo').val());
                if ($('#rec_tipo').val() !== 'file') {
                    formData.append('url', $('#rec_url').val());
                }
                if ($('#rec_file')[0].files[0]) {
                    formData.append('file', $('#rec_file')[0].files[0]);
                }
                if (id) formData.append('_method', 'PUT');

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            cerrarModal('modalRecurso');
                            location.reload();
                        } else alert('Error: ' + (response.message || 'No se pudo guardar'));
                    },
                    error: function() {
                        alert('Error al guardar el recurso');
                    }
                });
            });
        });
    </script>
</x-app-layout>
