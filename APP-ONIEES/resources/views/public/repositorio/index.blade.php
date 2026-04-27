<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio DIEM - Enlaces y Recursos</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Tus estilos existentes... */
        .modal-container { width: 95vw; max-width: 95vw; height: 95vh; max-height: 95vh; }
        .powerbi-iframe, .generic-iframe { width: 100%; height: 100%; border: none; }
    </style>
</head>
<body class="font-sans antialiased bg-white">

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- HEADER -->
    <div class="mb-12 border-b border-gray-100 pb-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-semibold tracking-tight text-[#1e2a44]">
                    <i class="fa-regular fa-folder-open text-[#0E7C9E] mr-3"></i>
                    Repositorio de Recursos
                </h1>
                <p class="text-gray-500 mt-2">Infraestructura, equipamiento y establecimientos de salud</p>
            </div>
        </div>
    </div>

    <!-- LAYOUT con SIDEBAR dinámico -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- SIDEBAR dinámico con categorías -->
        <aside class="lg:w-72 w-full flex-shrink-0">
            <div class="sticky top-8 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 pt-5 pb-2 border-b border-gray-100">
                        <h2 class="font-medium text-gray-700 text-sm uppercase tracking-wide">
                            <i class="fa-regular fa-compass text-[#0E7C9E] mr-2"></i>Categorías
                        </h2>
                    </div>
                    <div class="py-2 px-2">
                        @foreach($categories as $category)
                            <a href="#categoria-{{ $category->id }}" 
                               data-category="{{ $category->id }}"
                               class="category-link sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 text-sm transition hover:bg-gray-50">
                                <i class="{{ $category->icon ?? 'fa-regular fa-folder' }} w-5 text-[#0E7C9E]"></i>
                                <span>{{ $category->name }}</span>
                                <span class="ml-auto text-xs text-gray-400">{{ $category->subcategories->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL DINÁMICO -->
        <div class="flex-1 space-y-12">
            @foreach($categories as $category)
                <section id="categoria-{{ $category->id }}" class="scroll-mt-24">
                    <div class="flex items-center gap-3 mb-6 pb-1 border-b border-gray-100">
                        <div class="w-1 h-7 bg-[#0E7C9E] rounded-full"></div>
                        <i class="{{ $category->icon ?? 'fa-regular fa-folder' }} text-xl text-[#0E7C9E]"></i>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $category->name }}</h2>
                        <span class="text-xs bg-gray-100 px-2 py-0.5 rounded-full">{{ $category->subcategories->count() }} subcategorías</span>
                    </div>
                    
                    @foreach($category->subcategories as $subcategory)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fa-regular fa-tag text-[#0E7C9E] text-sm"></i>
                                {{ $subcategory->name }}
                            </h3>
                            <p class="text-gray-500 text-sm mb-4">{{ $subcategory->description }}</p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse($subcategory->resources as $resource)
                                    <div data-url="{{ $resource->getResourceUrl() }}"
                                         data-title="{{ $resource->title }}"
                                         data-type="{{ $resource->type }}"
                                         class="resource-card link-card bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-all cursor-pointer">
                                        <div class="flex items-start justify-between">
                                            <div class="w-9 h-9 rounded-full bg-[#0E7C9E]/5 flex items-center justify-center text-[#0E7C9E]">
                                                <i class="{{ $resource->getIcon() }} text-lg"></i>
                                            </div>
                                            <i class="fa-regular fa-arrow-up-right-from-square text-gray-300 text-sm"></i>
                                        </div>
                                        <h4 class="font-semibold text-gray-800 mt-3">{{ $resource->title }}</h4>
                                        <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $resource->description }}</p>
                                        <div class="mt-2 text-xs text-[#0E7C9E]/70 truncate">
                                            @if($resource->type === 'file')
                                                <i class="fa-regular fa-file"></i> {{ $resource->file_name }} ({{ $resource->file_size }})
                                            @else
                                                {{ Str::limit($resource->url, 40) }}
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-400 text-sm col-span-3">No hay recursos disponibles</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </section>
            @endforeach
        </div>
    </div>
</main>

<!-- MODALES (igual que tu código) -->
<div id="resourceModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl w-[95vw] h-[95vh] overflow-hidden flex flex-col">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 id="modalTitle" class="font-semibold text-gray-800">Recurso</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <iframe id="modalIframe" class="flex-1 w-full border-none" sandbox="allow-same-origin allow-scripts allow-popups allow-forms allow-modals"></iframe>
        <div class="px-6 py-3 bg-gray-50 text-xs flex justify-between">
            <span>Contenido embebido</span>
            <button id="openNewTabBtn" class="text-[#0E7C9E] hover:underline">Abrir en nueva pestaña</button>
        </div>
    </div>
</div>

<script>
    let currentUrl = '';
    
    document.querySelectorAll('.resource-card').forEach(card => {
        card.addEventListener('click', () => {
            const url = card.dataset.url;
            const title = card.dataset.title;
            currentUrl = url;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalIframe').src = url;
            document.getElementById('resourceModal').classList.remove('hidden');
            document.getElementById('resourceModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    });
    
    function closeModal() {
        document.getElementById('resourceModal').classList.add('hidden');
        document.getElementById('resourceModal').classList.remove('flex');
        document.getElementById('modalIframe').src = 'about:blank';
        document.body.style.overflow = '';
    }
    
    document.getElementById('openNewTabBtn')?.addEventListener('click', () => {
        if (currentUrl) window.open(currentUrl, '_blank');
    });
    
    document.getElementById('resourceModal')?.addEventListener('click', (e) => {
        if (e.target === document.getElementById('resourceModal')) closeModal();
    });
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
</script>

</body>
</html>