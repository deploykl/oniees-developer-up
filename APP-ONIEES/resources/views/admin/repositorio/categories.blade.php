<x-app-layout>
    <x-slot name="title">
        Gestionar Categorías
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">📁 Categorías del Repositorio</h1>
            <button id="btnNuevaCategoria" class="bg-[#0E7C9E] hover:bg-[#0C6A88] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <i class="fas fa-plus"></i> Nueva Categoría
            </button>
        </div>

        <div id="listaCategorias">
            @if($categories->isEmpty())
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
                <i class="fas fa-folder-open text-4xl text-blue-400 mb-3"></i>
                <p class="text-gray-600">No hay categorías creadas todavía.</p>
                <button id="btnCrearPrimera" class="mt-3 bg-[#0E7C9E] hover:bg-[#0C6A88] text-white px-4 py-2 rounded-lg inline-flex items-center gap-2">
                    <i class="fas fa-plus"></i> Crear primera categoría
                </button>
            </div>
            @else
                @foreach($categories as $category)
                <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center flex-wrap gap-2">
                        <div class="flex items-center gap-3">
                            <i class="{{ $category->icon ?? 'fas fa-folder' }} text-2xl text-[#0E7C9E]"></i>
                            <div>
                                <h2 class="text-xl font-bold">{{ $category->name }}</h2>
                                <p class="text-sm text-gray-500">{{ $category->description }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="abrirModalSubcategoria({{ $category->id }})" class="text-emerald-600 hover:text-emerald-800">
                                <i class="fas fa-plus-circle"></i> Subcategoría
                            </button>
                            <button onclick="editarCategoria({{ json_encode($category) }})" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="eliminarCategoria({{ $category->id }})" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-4">
                        @foreach($category->subcategories as $sub)
                        <div class="border rounded-lg p-3 mb-2 flex justify-between items-center flex-wrap gap-2">
                            <div>
                                <span class="font-medium">{{ $sub->name }}</span>
                                <p class="text-xs text-gray-500">{{ $sub->description }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.repositorio.resources', $sub->id) }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
                                    <i class="fas fa-file-alt"></i> Recursos
                                </a>
                                <button onclick="editarSubcategoria({{ json_encode($sub) }})" class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="eliminarSubcategoria({{ $sub->id }})" class="text-red-600 hover:text-red-800 text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- MODAL CATEGORÍA CORREGIDO -->
    <div id="modalCategoria" class="fixed inset-0 hidden bg-black/50 z-50" style="display: none;">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-lg w-full max-w-md p-6">
                <h3 id="modalCategoriaTitulo" class="text-xl font-bold mb-4">Nueva Categoría</h3>
                <form id="formCategoria">
                    <input type="hidden" id="categoria_id">
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Nombre *</label>
                        <input type="text" id="cat_nombre" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-[#0E7C9E]" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Descripción</label>
                        <textarea id="cat_descripcion" rows="2" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-[#0E7C9E]"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Icono (Font Awesome)</label>
                        <input type="text" id="cat_icono" value="fas fa-folder" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-[#0E7C9E]">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="cerrarModal('modalCategoria')" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-[#0E7C9E] text-white rounded-lg hover:bg-[#0C6A88]">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL SUBCATEGORÍA CORREGIDO -->
    <div id="modalSubcategoria" class="fixed inset-0 hidden bg-black/50 z-50" style="display: none;">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-lg w-full max-w-md p-6">
                <h3 id="modalSubcategoriaTitulo" class="text-xl font-bold mb-4">Nueva Subcategoría</h3>
                <form id="formSubcategoria">
                    <input type="hidden" id="subcategoria_id">
                    <input type="hidden" id="sub_categoria_id">
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Nombre *</label>
                        <input type="text" id="sub_nombre" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-[#0E7C9E]" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Descripción</label>
                        <textarea id="sub_descripcion" rows="2" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:border-[#0E7C9E]"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="cerrarModal('modalSubcategoria')" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-[#0E7C9E] text-white rounded-lg hover:bg-[#0C6A88]">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function abrirModalCategoria(categoria = null) {
        $('#modalCategoria').fadeIn();
        if(categoria) {
            $('#modalCategoriaTitulo').text('Editar Categoría');
            $('#categoria_id').val(categoria.id);
            $('#cat_nombre').val(categoria.name);
            $('#cat_descripcion').val(categoria.description || '');
            $('#cat_icono').val(categoria.icon || 'fas fa-folder');
        } else {
            $('#modalCategoriaTitulo').text('Nueva Categoría');
            $('#formCategoria')[0].reset();
            $('#categoria_id').val('');
            $('#cat_icono').val('fas fa-folder');
        }
    }

    function editarCategoria(cat) { 
        abrirModalCategoria(cat); 
    }

    function eliminarCategoria(id) {
        if(confirm('¿Eliminar esta categoría? Se eliminarán también sus subcategorías y recursos.')) {
            $.ajax({
                url: `/admin/repositorio/api/categories/${id}`,
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() { location.reload(); }
            });
        }
    }

    function abrirModalSubcategoria(categoryId, subcategoria = null) {
        $('#modalSubcategoria').fadeIn();
        $('#sub_categoria_id').val(categoryId);
        if(subcategoria) {
            $('#modalSubcategoriaTitulo').text('Editar Subcategoría');
            $('#subcategoria_id').val(subcategoria.id);
            $('#sub_nombre').val(subcategoria.name);
            $('#sub_descripcion').val(subcategoria.description || '');
        } else {
            $('#modalSubcategoriaTitulo').text('Nueva Subcategoría');
            $('#formSubcategoria')[0].reset();
            $('#subcategoria_id').val('');
        }
    }

    function editarSubcategoria(sub) { 
        abrirModalSubcategoria(sub.category_id, sub); 
    }

    function eliminarSubcategoria(id) {
        if(confirm('¿Eliminar esta subcategoría? Se eliminarán también sus recursos.')) {
            $.ajax({
                url: `/admin/repositorio/api/subcategories/${id}`,
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() { location.reload(); }
            });
        }
    }

    function cerrarModal(modalId) {
        $(`#${modalId}`).fadeOut();
    }

    $(document).ready(function() {
        $('#btnNuevaCategoria, #btnCrearPrimera').on('click', function() {
            abrirModalCategoria();
        });

        // Cerrar modal al hacer clic fuera
        $('#modalCategoria, #modalSubcategoria').on('click', function(e) {
            if(e.target === this) {
                $(this).fadeOut();
            }
        });

        // Cerrar con tecla ESC
        $(document).on('keydown', function(e) {
            if(e.key === 'Escape') {
                $('#modalCategoria, #modalSubcategoria').fadeOut();
            }
        });

        $('#formCategoria').on('submit', function(e) {
            e.preventDefault();
            const id = $('#categoria_id').val();
            const url = id ? `/admin/repositorio/api/categories/${id}` : '/admin/repositorio/api/categories';
            const method = id ? 'PUT' : 'POST';
            
            $.ajax({
                url: url,
                method: method,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Content-Type': 'application/json' },
                data: JSON.stringify({
                    name: $('#cat_nombre').val(),
                    description: $('#cat_descripcion').val(),
                    icon: $('#cat_icono').val()
                }),
                success: function() { location.reload(); }
            });
        });

        $('#formSubcategoria').on('submit', function(e) {
            e.preventDefault();
            const id = $('#subcategoria_id').val();
            const url = id ? `/admin/repositorio/api/subcategories/${id}` : '/admin/repositorio/api/subcategories';
            const method = id ? 'PUT' : 'POST';
            
            $.ajax({
                url: url,
                method: method,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Content-Type': 'application/json' },
                data: JSON.stringify({
                    category_id: $('#sub_categoria_id').val(),
                    name: $('#sub_nombre').val(),
                    description: $('#sub_descripcion').val()
                }),
                success: function() { location.reload(); }
            });
        });
    });
    </script>
</x-app-layout>