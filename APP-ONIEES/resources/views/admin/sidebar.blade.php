<!-- Sidebar Glassmorphism -->
<div x-data="{ sidebarOpen: true, activeMenu: null }" 
     :class="sidebarOpen ? 'w-64' : 'w-20'" 
     class="fixed left-0 top-0 h-full bg-white/80 backdrop-blur-xl border-r border-blue-100/30 shadow-xl z-50 transition-all duration-300 overflow-hidden">
    
    <!-- Logo Sidebar -->
    <div class="flex items-center justify-between p-4 border-b border-blue-100/30">
        <div x-show="sidebarOpen" class="flex items-center gap-2">
            <img src="{{ asset('img/favicon.png') }}" class="w-8 h-8 rounded-lg" alt="Logo">
            <span class="font-bold text-gray-800 text-lg">DIEM</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" 
                class="p-2 rounded-lg hover:bg-blue-50 transition text-gray-500">
            <i :class="sidebarOpen ? 'fas fa-chevron-left' : 'fas fa-chevron-right'" class="text-sm"></i>
        </button>
    </div>

    <!-- Menú de Navegación -->
    <nav class="p-3 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group"
           :class="window.location.pathname === '/dashboard' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50/50 hover:text-blue-500'">
            <i class="fas fa-chart-line w-5 text-lg"></i>
            <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
            <span x-show="!sidebarOpen" class="hidden">Dashboard</span>
        </a>

        <!-- Usuarios -->
        @can('Usuarios - Inicio')
        <div x-data="{ open: false }">
            <button @click="open = !open" 
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                <div class="flex items-center gap-3">
                    <i class="fas fa-users w-5 text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Usuarios</span>
                </div>
                <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs transition-transform"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                <a href="{{ route('users-index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-list w-4"></i>
                    <span>Listar Usuarios</span>
                </a>
                @can('Usuarios - Crear')
                <a href="{{ route('users-add') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-user-plus w-4"></i>
                    <span>Crear Usuario</span>
                </a>
                @endcan
            </div>
        </div>
        @endcan

        <!-- SIGA -->
        @can('SIGA - Inicio')
        <div x-data="{ open: false }">
            <button @click="open = !open" 
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                <div class="flex items-center gap-3">
                    <i class="fas fa-microchip w-5 text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">SIGA</span>
                </div>
                <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs transition-transform"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                <a href="{{ route('siga-index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-chart-simple w-4"></i>
                    <span>Patrimonio</span>
                </a>
                <a href="{{ route('formato-0') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-file-alt w-4"></i>
                    <span>Datos Generales</span>
                </a>
            </div>
        </div>
        @endcan

        <!-- Formularios -->
        <div x-data="{ open: false }">
            <button @click="open = !open" 
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-alt w-5 text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Formularios</span>
                </div>
                <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs transition-transform"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                <a href="{{ route('formato-0') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-file-alt w-4"></i>
                    <span>Formato 0</span>
                </a>
                <a href="{{ route('formato-i') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-file-alt w-4"></i>
                    <span>Formato I</span>
                </a>
                <a href="{{ route('formato-ii') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-file-alt w-4"></i>
                    <span>Formato II</span>
                </a>
            </div>
        </div>

        <!-- Reportes -->
        <div x-data="{ open: false }">
            <button @click="open = !open" 
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                <div class="flex items-center gap-3">
                    <i class="fas fa-chart-bar w-5 text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Reportes</span>
                </div>
                <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs transition-transform"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                <a href="{{ route('ipress') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-chart-line w-4"></i>
                    <span>IPRESS</span>
                </a>
                <a href="{{ route('reportes') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-chart-simple w-4"></i>
                    <span>KPI</span>
                </a>
            </div>
        </div>

        <!-- Tableros -->
        <div x-data="{ open: false }">
            <button @click="open = !open" 
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                <div class="flex items-center gap-3">
                    <i class="fas fa-chalkboard-user w-5 text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Tableros</span>
                </div>
                <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs transition-transform"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                <a href="{{ route('tablero-gerencial-index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-chalkboard w-4"></i>
                    <span>Gerencial</span>
                </a>
                <a href="{{ route('tablero-ejecutivo-inicio') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-chalkboard-user w-4"></i>
                    <span>Ejecutivo</span>
                </a>
            </div>
        </div>

        <!-- Administración -->
        @can('Usuarios - Inicio')
        <div x-data="{ open: false }">
            <button @click="open = !open" 
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                <div class="flex items-center gap-3">
                    <i class="fas fa-gear w-5 text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Admin</span>
                </div>
                <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs transition-transform"></i>
            </button>
            <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                <a href="{{ route('roles-todos') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-lock w-4"></i>
                    <span>Roles</span>
                </a>
                <a href="{{ route('permisos-todos') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                    <i class="fas fa-key w-4"></i>
                    <span>Permisos</span>
                </a>
            </div>
        </div>
        @endcan
    </nav>

    <!-- Footer Sidebar -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-100/30">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-teal-500 flex items-center justify-center">
                <i class="fas fa-user text-white text-xs"></i>
            </div>
            <div x-show="sidebarOpen">
                <p class="text-xs font-medium text-gray-700">{{ Auth::user()->name ?? 'Usuario' }}</p>
                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    .menu-item {
        position: relative;
        overflow: hidden;
    }
    
    .menu-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: linear-gradient(135deg, #0E7C9E, #1E3A5F);
        border-radius: 3px;
        transition: height 0.3s ease;
    }
    
    .menu-item:hover::before,
    .menu-item.active::before {
        height: 70%;
    }
    
    /* Scrollbar personalizado */
    nav::-webkit-scrollbar {
        width: 4px;
    }
    
    nav::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    nav::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    
    nav::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>