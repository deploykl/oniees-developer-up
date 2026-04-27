@extends('layouts.admin')

@section('title', 'Gestionar Recursos')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.repositorio.categories') }}" class="text-[#0E7C9E] hover:underline">
            ← Volver a Categorías
        </a>
        <h1 class="text-2xl font-bold mt-2">📄 Recursos: {{ $subcategory->name }}</h1>
        <p class="text-gray-500">{{ $subcategory->description }}</p>
    </div>

    <div class="flex justify-end mb-4">
        <button onclick="openResourceModal()" class="bg-[#0E7C9E] hover:bg-[#0C6A88] text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i class="fas fa-plus"></i> Nuevo Recurso
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr><th class="px-6 py-3 text-left">Título</th><th class="px-6 py-3 text-left">Tipo</th><th class="px-6 py-3 text-left">URL/Archivo</th><th class="px-6 py-3 text-center">Acciones</th></tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                <tr class="border-t">
                    <td class="px-6 py-3">{{ $resource->title }}</td>
                    <td class="px-6 py-3">
                        @if($resource->type == 'powerbi') Power BI
                        @elseif($resource->type == 'file') Archivo
                        @else Enlace @endif
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500 truncate max-w-xs">
                        @if($resource->type == 'file') {{ $resource->file_name }}
                        @else {{ $resource->url }} @endif
                    </td>
                    <td class="px-6 py-3 text-center">
                        <button onclick="editResource({{ json_encode($resource) }})" class="text-blue-600 hover:text-blue-800 mx-1">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteResource({{ $resource->id }})" class="text-red-600 hover:text-red-800 mx-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Recurso -->
<div id="resourceModal" class="fixed inset-0 hidden bg-black/50 items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h3 id="resourceModalTitle" class="text-xl font-bold mb-4">Nuevo Recurso</h3>
        <form id="resourceForm" enctype="multipart/form-data">
            <input type="hidden" id="res_id">
            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Título</label>
                <input type="text" id="res_title" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Descripción</label>
                <textarea id="res_description" rows="2" class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Tipo</label>
                <select id="res_type" onchange="toggleType()" class="w-full border rounded-lg px-3 py-2">
                    <option value="powerbi">Power BI (URL)</option>
                    <option value="link">Enlace externo</option>
                    <option value="file">Archivo</option>
                </select>
            </div>
            <div id="url_field" class="mb-3">
                <label class="block text-sm font-medium mb-1">URL</label>
                <input type="url" id="res_url" class="w-full border rounded-lg px-3 py-2" placeholder="https://...">
            </div>
            <div id="file_field" class="mb-3 hidden">
                <label class="block text-sm font-medium mb-1">Archivo</label>
                <input type="file" id="res_file" class="w-full border rounded-lg px-3 py-2" accept=".pdf,.xlsx,.xls,.docx,.jpg,.png">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('resourceModal')" class="px-4 py-2 border rounded-lg">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-[#0E7C9E] text-white rounded-lg">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleType() {
    const type = document.getElementById('res_type').value;
    if(type === 'file') {
        document.getElementById('url_field').classList.add('hidden');
        document.getElementById('file_field').classList.remove('hidden');
    } else {
        document.getElementById('url_field').classList.remove('hidden');
        document.getElementById('file_field').classList.add('hidden');
    }
}

function openResourceModal(res = null) {
    document.getElementById('resourceModal').classList.remove('hidden');
    document.getElementById('resourceModal').classList.add('flex');
    if(res) {
        document.getElementById('resourceModalTitle').innerText = 'Editar Recurso';
        document.getElementById('res_id').value = res.id;
        document.getElementById('res_title').value = res.title;
        document.getElementById('res_description').value = res.description || '';
        document.getElementById('res_type').value = res.type;
        toggleType();
        if(res.type !== 'file') document.getElementById('res_url').value = res.url;
    } else {
        document.getElementById('resourceModalTitle').innerText = 'Nuevo Recurso';
        document.getElementById('resourceForm').reset();
        document.getElementById('res_id').value = '';
        toggleType();
    }
}

function editResource(res) { openResourceModal(res); }

function deleteResource(id) {
    if(confirm('¿Eliminar este recurso?')) {
        fetch(`/admin/repositorio/api/resources/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(() => location.reload());
    }
}

document.getElementById('resourceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('res_id').value;
    const url = id ? `/admin/repositorio/api/resources/${id}` : '/admin/repositorio/api/resources';
    const formData = new FormData();
    formData.append('title', document.getElementById('res_title').value);
    formData.append('description', document.getElementById('res_description').value);
    formData.append('type', document.getElementById('res_type').value);
    if(document.getElementById('res_type').value !== 'file') {
        formData.append('url', document.getElementById('res_url').value);
    } else if(document.getElementById('res_file').files[0]) {
        formData.append('file', document.getElementById('res_file').files[0]);
    }
    if(id) formData.append('_method', 'PUT');
    fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    }).then(() => location.reload());
});

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
}
</script>
@endsection