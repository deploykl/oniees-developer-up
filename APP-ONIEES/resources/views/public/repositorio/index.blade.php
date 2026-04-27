<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Repositorio DIEM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0E7C9E',
                        primaryDark: '#0a5c77',
                        secondary: '#1E3A5F',
                        accent: '#38bdf8',
                        surface: '#f8fafc',
                        card: '#ffffff',
                        border: '#eef2f6',
                        muted: '#64748b'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'Segoe UI', 'Roboto', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'scale-in': 'scaleIn 0.2s ease-out'
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(20px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } },
                        scaleIn: { '0%': { transform: 'scale(0.95)', opacity: '0' }, '100%': { transform: 'scale(1)', opacity: '1' } }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 (CDN correcto) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: linear-gradient(135deg, #f5f7fc 0%, #eef2f7 100%); font-family: 'Inter', sans-serif; }
        
        /* Scrollbar personalizado */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #0E7C9E; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #0a5c77; }
        
        /* Efectos de tarjetas */
        .resource-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(0px);
        }
        .resource-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 35px -12px rgba(14, 124, 158, 0.15);
            border-color: rgba(14, 124, 158, 0.3);
        }
        
        /* Sidebar items */
        .sidebar-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .sidebar-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: linear-gradient(135deg, #0E7C9E, #38bdf8);
            transition: width 0.3s ease;
            z-index: -1;
        }
        .sidebar-item:hover::before { width: 100%; opacity: 0.08; }
        .sidebar-item.active-section {
            background: linear-gradient(135deg, rgba(14, 124, 158, 0.1), rgba(56, 189, 248, 0.05));
            border-left-color: #0E7C9E;
            font-weight: 600;
        }
        
        /* Animación de entrada */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Badges */
        .badge-glass {
            background: rgba(14, 124, 158, 0.1);
            backdrop-filter: blur(4px);
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 0.7rem;
            font-weight: 500;
            color: #0E7C9E;
        }
        
        /* Header glassmorphism */
        .header-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(14, 124, 158, 0.15);
        }
        
        .shadow-soft {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-item.active-section { background: rgba(14, 124, 158, 0.1); }
        }
    </style>
</head>
<body>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
    
    <!-- HEADER MODERNO -->
    <div class="header-glass rounded-2xl mb-8 p-6 md:p-8 shadow-soft">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-folder-open text-white text-xl"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight bg-gradient-to-r from-secondary to-primary bg-clip-text text-transparent">
                        Repositorio DIEM - OBSERVATORIO NACIONAL
                    </h1>
                </div>
                <p class="text-muted text-base ml-12">Infraestructura, equipamiento y establecimientos de salud</p>
            </div>
            <div class="flex items-center gap-3 ml-12 md:ml-0">
                <div class="badge-glass flex items-center gap-2">
                    <i class="fas fa-database text-xs"></i>
                    <span>Recursos actualizados</span>
                </div>
                <div class="badge-glass flex items-center gap-2">
                    <i class="fas fa-chart-line text-xs"></i>
                    <span>Dashboards</span>
                </div>
            </div>
        </div>
    </div>
<!-- Después del header-glass -->
<div class="mb-6 flex items-center gap-2 text-sm text-muted">
    <a href="{{ url('/') }}" class="hover:text-primary transition-colors flex items-center gap-1">
        <i class="fas fa-home text-xs"></i>
        <span>Inicio</span>
    </a>
    <i class="fas fa-chevron-right text-xs"></i>
    <span class="text-primary font-medium">Repositorio de recursos</span>
</div>
    <!-- LAYOUT: SIDEBAR + CONTENIDO -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- SIDEBAR ELEGANTE -->
        <aside class="lg:w-80 w-full flex-shrink-0">
            <div class="sticky top-8 space-y-5">
                <!-- Navegación principal -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-100 shadow-lg overflow-hidden">
                    <div class="px-5 pt-5 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                            <i class="fas fa-compass text-white text-[10px]"></i>
                        </div>
                        <h2 class="font-semibold text-gray-700 text-sm uppercase tracking-wider">Categorías</h2>
                        <span class="text-xs text-gray-400 ml-auto">
                            {{ $categories->count() ?? 0 }}
                        </span>
                    </div>
                    <div class="py-3 px-2 space-y-1 max-h-[calc(100vh-200px)] overflow-y-auto">
                        @forelse($categories as $category)
                            <a href="#categoria-{{ $category->id }}" 
                               class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 text-sm transition-all group">
                                <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition">
                                    <i class="{{ $category->icon ?? 'fas fa-folder' }} text-primary text-xs"></i>
                                </div>
                                <span class="flex-1">{{ $category->name }}</span>
                                <span class="text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $category->subcategories->count() }}</span>
                            </a>
                        @empty
                            <p class="text-gray-400 text-sm px-3 py-2 text-center">No hay categorías</p>
                        @endforelse
                    </div>
                </div>

                <!-- Tarjeta de estadísticas -->
                <div class="bg-gradient-to-br from-primary to-primaryDark rounded-2xl overflow-hidden shadow-lg">
                    <div class="p-5 text-center relative">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full -ml-10 -mb-10"></div>
                        <i class="fas fa-chart-pie text-4xl text-white/30 mb-3 relative"></i>
                        <h3 class="font-semibold text-white text-lg relative">Recursos Digitales</h3>
                        <p class="text-white/70 text-sm mt-1 relative">Documentos, enlaces y dashboards</p>
                        <div class="mt-4 pt-3 border-t border-white/20 flex justify-around relative">
                            <div>
                                <span class="text-2xl font-bold text-white">
                                    {{ $categories->sum(fn($c) => $c->subcategories->sum(fn($s) => $s->resources->count())) }}
                                </span>
                                <p class="text-xs text-white/60">Recursos</p>
                            </div>
                            <div>
                                <span class="text-2xl font-bold text-white">
                                    {{ $categories->sum(fn($c) => $c->subcategories->count()) }}
                                </span>
                                <p class="text-xs text-white/60">Subcategorías</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="flex-1 space-y-12">
            @forelse($categories as $category)
                <section id="categoria-{{ $category->id }}" class="scroll-mt-24 animate-on-scroll">
                    <div class="mb-6">
                        <div class="flex items-center gap-3 flex-wrap">
                            <div class="w-1.5 h-8 bg-gradient-to-b from-primary to-accent rounded-full"></div>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center">
                                <i class="{{ $category->icon ?? 'fas fa-folder' }} text-primary text-lg"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h2>
                            <span class="badge-glass">{{ $category->subcategories->count() }} subcategorías</span>
                        </div>
                        @if($category->description)
                            <p class="text-muted text-sm mt-2 ml-14">{{ $category->description }}</p>
                        @endif
                    </div>
                    
                    @forelse($category->subcategories as $subcategory)
                        <div class="mb-10 ml-3 group">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-1 h-5 bg-primary rounded-full"></div>
                                <i class="fas fa-tag text-primary text-sm"></i>
                                <h3 class="text-lg font-semibold text-gray-700">{{ $subcategory->name }}</h3>
                                <span class="text-xs text-gray-400">{{ $subcategory->resources->count() }} recursos</span>
                            </div>
                            @if($subcategory->description)
                                <p class="text-muted text-sm mb-4 ml-4">{{ $subcategory->description }}</p>
                            @endif
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                                @forelse($subcategory->resources as $resource)
                                    <div data-url="{{ $resource->getResourceUrl() }}"
                                         data-title="{{ $resource->title }}"
                                         data-type="{{ $resource->type }}"
                                         class="resource-card bg-white rounded-xl border border-gray-100 p-4 shadow-sm hover:shadow-xl transition-all cursor-pointer group">
                                        <div class="flex items-start justify-between">
                                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                                <i class="{{ $resource->getIcon() }} text-xl"></i>
                                            </div>
                                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                <i class="fas fa-arrow-up-right-from-square text-muted/40 text-sm"></i>
                                            </div>
                                        </div>
                                        <h4 class="font-semibold text-gray-800 mt-3 text-base line-clamp-1">{{ $resource->title }}</h4>
                                        <p class="text-muted text-sm mt-1 line-clamp-2">{{ Str::limit($resource->description ?? 'Sin descripción', 80) }}</p>
                                        <div class="mt-3 flex items-center gap-2 text-xs">
                                            <span class="badge-glass !text-[10px] !py-0.5 flex items-center gap-1">
                                                <i class="fas {{ $resource->type === 'powerbi' ? 'fa-chart-line' : ($resource->type === 'file' ? 'fa-file' : 'fa-link') }} text-[9px]"></i>
                                                {{ $resource->type === 'powerbi' ? 'Dashboard' : ($resource->type === 'file' ? 'Documento' : 'Enlace') }}
                                            </span>
                                            @if($resource->type === 'file')
                                                <span class="text-[10px] text-gray-400">{{ $resource->file_size ?? '—' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-8 text-gray-400 text-sm">
                                        <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                        No hay recursos disponibles
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm ml-4 py-4">No hay subcategorías</p>
                    @endforelse
                </section>
            @empty
                <div class="text-center py-16">
                    <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No hay categorías disponibles</p>
                </div>
            @endforelse

            <!-- Footer -->
            <div class="pt-8 mt-4 border-t border-gray-200 text-center">
                <div class="flex flex-wrap justify-center gap-6 text-xs text-muted">
                    <span><i class="far fa-copyright mr-1"></i> DIEM - Repositorio de recursos</span>
                    <span><i class="fas fa-mouse-pointer mr-1"></i> Clic en tarjeta → abre recurso</span>
                    <span><i class="fas fa-sync-alt mr-1"></i> Actualización continua</span>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL PARA POWER BI -->
<div id="powerBiModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-md transition-opacity"></div>
    <div class="modal-container relative bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col w-[95vw] max-w-[1400px] h-[90vh] max-h-[90vh] animate-scale-in">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-white/95">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-sm"></i>
                </div>
                <h3 id="modalTitle" class="font-semibold text-gray-800 text-lg">Dashboard Power BI</h3>
            </div>
            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 transition-all w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="flex-1 w-full bg-gray-100">
            <iframe id="modalIframe" class="w-full h-full border-none" title="Power BI Dashboard" allowfullscreen="true"></iframe>
        </div>
        <div class="px-6 py-3 bg-gray-50 text-xs text-muted border-t border-gray-100 flex justify-between items-center">
            <span class="flex items-center gap-2"><i class="fas fa-expand-alt mr-1"></i> Dashboard Interactivo</span>
            <button id="openNewTabBtn" class="text-primary hover:text-primaryDark transition flex items-center gap-2 font-medium">
                <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
            </button>
        </div>
    </div>
</div>

<script>
    (function() {
        const modal = document.getElementById('powerBiModal');
        const modalIframe = document.getElementById('modalIframe');
        const modalTitle = document.getElementById('modalTitle');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const openNewTabBtn = document.getElementById('openNewTabBtn');
        let currentUrl = '';

        function openModal(url, title) {
            currentUrl = url;
            modalTitle.innerText = title;
            modalIframe.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalIframe.src = '';
            document.body.style.overflow = '';
        }

        document.querySelectorAll('.resource-card').forEach(card => {
            card.addEventListener('click', (e) => {
                e.stopPropagation();
                const url = card.dataset.url;
                const title = card.dataset.title;
                const type = card.dataset.type;
                
                if (type === 'powerbi') {
                    openModal(url, title);
                } else {
                    window.open(url, '_blank');
                }
            });
        });

        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (modal) modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
        if (openNewTabBtn) {
            openNewTabBtn.addEventListener('click', () => {
                if (currentUrl) window.open(currentUrl, '_blank');
            });
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal && modal.classList.contains('flex')) closeModal();
        });

        // Sidebar active por scroll
        const sections = document.querySelectorAll('section[id^="categoria-"]');
        const sidebarLinks = document.querySelectorAll('.sidebar-item');
        
        function setActiveFromScroll() {
            const scrollPos = window.scrollY + 150;
            let currentActiveId = null;
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionBottom = sectionTop + section.offsetHeight;
                if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                    currentActiveId = section.id;
                }
            });
            sidebarLinks.forEach(link => {
                link.classList.remove('active-section');
                if (link.getAttribute('href') === '#' + currentActiveId) {
                    link.classList.add('active-section');
                }
            });
        }
        
        if (sections.length > 0) {
            window.addEventListener('load', setActiveFromScroll);
            window.addEventListener('scroll', setActiveFromScroll);
        }
        
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const yOffset = -90;
                    const y = targetElement.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                    sidebarLinks.forEach(l => l.classList.remove('active-section'));
                    this.classList.add('active-section');
                }
            });
        });

        // Animación al scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    })();
</script>
</body>
</html>