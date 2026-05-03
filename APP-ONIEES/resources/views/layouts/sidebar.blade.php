<!-- Sidebar Glassmorphism con store global -->
<div x-data="{
    get sidebarOpen() { return $store.sidebar.open },
    init() {
        // Inicializar estados de menús desde localStorage
        if (!localStorage.getItem('menu_siga')) localStorage.setItem('menu_siga', false);
        if (!localStorage.getItem('menu_formularios')) localStorage.setItem('menu_formularios', false);
        if (!localStorage.getItem('menu_reportes')) localStorage.setItem('menu_reportes', false);
        if (!localStorage.getItem('menu_tableros')) localStorage.setItem('menu_tableros', false);
        if (!localStorage.getItem('menu_monitoreo')) localStorage.setItem('menu_monitoreo', false);
        if (!localStorage.getItem('menu_registros')) localStorage.setItem('menu_registros', false);
        if (!localStorage.getItem('menu_ipress')) localStorage.setItem('menu_ipress', false);
        if (!localStorage.getItem('menu_repositorio')) localStorage.setItem('menu_repositorio', false);
    }
}" :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="fixed left-0 top-0 h-full bg-white/95 backdrop-blur-xl border-r border-blue-100/30 shadow-2xl z-[200] transition-all duration-300 overflow-hidden flex flex-col">

    <!-- Logo Sidebar -->
    <div class="flex items-center justify-between p-4 border-b border-blue-100/30 flex-shrink-0">
        <div x-show="sidebarOpen" class="flex items-center gap-2">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-decoration-none">
                <div
                    class="flex items-center gap-2 bg-white/50 backdrop-blur-sm px-3 py-1.5 rounded-full border border-blue-100/30">
                    <img src="{{ asset('img/logo-minsa.png') }}" alt="MINSA Logo"
                        style="height: 32px; width: auto; max-width: 120px; object-fit: contain;">
                </div>
            </a>
        </div>
        <div x-show="!sidebarOpen" class="flex justify-center w-full">
            <a href="{{ url('/') }}"
                class="flex items-center justify-center bg-white/50 backdrop-blur-sm p-2 rounded-full border border-blue-100/30">
                <i class="fas fa-hospital-user text-teal-600 text-lg"></i>
            </a>
        </div>
        <button @click="$store.sidebar.toggle()"
            class="p-2 rounded-lg hover:bg-blue-50 transition text-gray-500 flex-shrink-0">
            <i :class="sidebarOpen ? 'fas fa-chevron-left' : 'fas fa-chevron-right'" class="text-sm"></i>
        </button>
    </div>

    <!-- Menú de Navegación -->
    <nav class="p-3 space-y-1 overflow-y-auto flex-1" style="overflow-y: auto;">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group"
            :class="window.location.pathname === '/dashboard' ? 'bg-blue-50 text-blue-600' :
                'text-gray-600 hover:bg-blue-50/50 hover:text-blue-500'">
            <i class="fas fa-house w-5 text-lg"></i>
            <span x-show="sidebarOpen" class="text-sm font-medium">Home</span>
            <span x-show="!sidebarOpen" class="hidden">Home</span>
        </a>

        <!-- Infraestructura -->
        <a href="{{ route('infraestructura.edit') }}"
            class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group"
            :class="window.location.pathname === '/infraestructura/index' ? 'bg-blue-50 text-blue-600' :
                'text-gray-600 hover:bg-blue-50/50 hover:text-blue-500'">
            <i class="fas fa-building w-5 text-lg"></i>
            <span x-show="sidebarOpen" class="text-sm font-medium">Infraestructura</span>
            <span x-show="!sidebarOpen" class="hidden">Infraestructura</span>
        </a>

        <!-- ==================== REPOSITORIO ==================== -->
        @hasrole('Admin')
            <div x-data="{ open: localStorage.getItem('menu_repositorio') === 'true' }">
                <button @click="open = !open"
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-folder-open w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">Repositorio</span>
                    </div>
                    <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                </button>
                <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                    <a href="{{ route('repositorio.index') }}" target="_blank"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm">
                        <i class="fas fa-eye w-4"></i> Ver Repositorio
                    </a>
                    <a href="{{ route('admin.repositorio.categories') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm">
                        <i class="fas fa-tags w-4"></i> Categorías
                    </a>
                </div>
            </div>
        @endhasrole

        <!-- ==================== ADMIN ==================== -->
        @hasrole('Admin')
            <!-- Usuarios -->
            <a href="{{ route('users-index') }}"
                class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                <i class="fas fa-users w-5 text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Usuarios</span>
                <span x-show="!sidebarOpen" class="hidden">Usuarios</span>
            </a>

            <!-- SIGA -->
            <div x-data="{ open: localStorage.getItem('menu_siga') === 'true' }" x-init="$watch('open', value => localStorage.setItem('menu_siga', value))">
                <button @click="open = !open"
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-microchip w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">SIGA</span>
                    </div>
                    <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                        class="fas text-xs transition-transform"></i>
                </button>
                <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-chart-simple w-4"></i>
                        <span>Patrimonio</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-file-alt w-4"></i>
                        <span>Datos Generales</span>
                    </a>
                </div>
            </div>

            <!-- Formularios -->
            <div x-data="{ open: localStorage.getItem('menu_formularios') === 'true' }" x-init="$watch('open', value => localStorage.setItem('menu_formularios', value))">
                <button @click="open = !open"
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-alt w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">Formularios</span>
                    </div>
                    <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                        class="fas text-xs transition-transform"></i>
                </button>
                <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-file-alt w-4"></i>
                        <span>Formato 0</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-file-alt w-4"></i>
                        <span>Formato I</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-file-alt w-4"></i>
                        <span>Formato II</span>
                    </a>
                </div>
            </div>

            <!-- Reportes -->
            <div x-data="{ open: localStorage.getItem('menu_reportes') === 'true' }" x-init="$watch('open', value => localStorage.setItem('menu_reportes', value))">
                <button @click="open = !open"
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chart-bar w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">Reportes</span>
                    </div>
                    <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                        class="fas text-xs transition-transform"></i>
                </button>
                <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-chart-line w-4"></i>
                        <span>IPRESS</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-chart-simple w-4"></i>
                        <span>KPI</span>
                    </a>
                </div>
            </div>

            <!-- Tableros -->
            <div x-data="{ open: localStorage.getItem('menu_tableros') === 'true' }" x-init="$watch('open', value => localStorage.setItem('menu_tableros', value))">
                <button @click="open = !open"
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chalkboard-user w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">Tableros</span>
                    </div>
                    <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                        class="fas text-xs transition-transform"></i>
                </button>
                <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-chalkboard w-4"></i>
                        <span>Gerencial</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-chalkboard-user w-4"></i>
                        <span>Ejecutivo</span>
                    </a>
                </div>
            </div>
        @endhasrole

        <!-- ==================== SUPERVISOR ==================== -->
        @hasrole('Supervisor')
            <div x-data="{ open: localStorage.getItem('menu_monitoreo') === 'true' }" x-init="$watch('open', value => localStorage.setItem('menu_monitoreo', value))">
                <button @click="open = !open"
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chart-line w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">Monitoreo</span>
                    </div>
                    <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                        class="fas text-xs transition-transform"></i>
                </button>
                <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-chart-simple w-4"></i>
                        <span>Dashboard Supervisor</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-file-alt w-4"></i>
                        <span>Reportes Diarios</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-chart-line w-4"></i>
                        <span>Métricas</span>
                    </a>
                </div>
            </div>
        @endhasrole

        <!-- ==================== REGISTRADOR ==================== -->
        @hasrole('Registrador')
            <div x-data="{ open: localStorage.getItem('menu_registros') === 'true' }" x-init="$watch('open', value => localStorage.setItem('menu_registros', value))">
                <button @click="open = !open"
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-pen-alt w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">Registros</span>
                    </div>
                    <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                        class="fas text-xs transition-transform"></i>
                </button>
                <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-file-alt w-4"></i>
                        <span>Nuevo Registro</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-list w-4"></i>
                        <span>Mis Registros</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-search w-4"></i>
                        <span>Buscar</span>
                    </a>
                </div>
            </div>
        @endhasrole

        <!-- ==================== IPRESS ==================== -->
        @hasrole('Ipress')
            <div x-data="{ open: localStorage.getItem('menu_ipress') === 'true' }" x-init="$watch('open', value => localStorage.setItem('menu_ipress', value))">
                <button @click="open = !open"
                    class="menu-item w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group text-gray-600 hover:bg-blue-50/50 hover:text-blue-500">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-hospital w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">IPRESS</span>
                    </div>
                    <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                        class="fas text-xs transition-transform"></i>
                </button>
                <div x-show="open && sidebarOpen" x-collapse class="ml-9 mt-1 space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-building w-4"></i>
                        <span>Mi Establecimiento</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-chart-simple w-4"></i>
                        <span>Estadísticas</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:bg-blue-50/50 hover:text-blue-500 transition">
                        <i class="fas fa-file-export w-4"></i>
                        <span>Reportes</span>
                    </a>
                </div>
            </div>
        @endhasrole

        <!-- ==================== SIN ROL ==================== -->
        @role('')
            <div class="text-center py-8">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mb-2"></i>
                <p class="text-sm text-gray-500">No tiene permisos asignados</p>
                <p class="text-xs text-gray-400 mt-1">Contacte al administrador</p>
            </div>
        @endrole
    </nav>

    <!-- Footer Sidebar -->
    <div class="border-t border-blue-100/30 bg-white/50 flex-shrink-0">

        <!-- 👇 AQUÍ VA EL BLOQUE DE USUARIOS CONECTADOS -->
        <!-- Usuarios Conectados -->
        <div class="p-3 border-b border-blue-100/30" x-data="sidebarUsuarios()" x-init="init()">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-semibold text-gray-600">En línea</span>
                </div>
                <span class="text-xs font-bold text-green-600" x-text="onlineCount"></span>
            </div>

            <div class="space-y-2 max-h-32 overflow-y-auto">
                <template x-for="user in onlineUsers.slice(0, 4)" :key="user.id">
                    <div class="flex items-center gap-2 text-xs">
                        <div class="w-6 h-6 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-teal-600 text-[10px]"></i>
                        </div>
                        <span class="text-gray-700 truncate flex-1" x-text="user.name"></span>
                        <span class="text-green-500 text-[10px]">●</span>
                    </div>
                </template>

                <div x-show="onlineUsers.length === 0" class="text-center py-2">
                    <i class="fas fa-user-friends text-gray-300 text-sm"></i>
                    <p class="text-xs text-gray-400 mt-1">No hay usuarios conectados</p>
                </div>
            </div>

            <a href="{{ route('usuarios.conectados') }}"
                class="block text-center text-xs text-teal-600 hover:text-teal-700 mt-2 pt-2 border-t border-gray-100">
                Ver todos <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
            </a>
        </div>

        <!-- Información del usuario (ya existe) -->
        <div class="p-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-teal-500 flex items-center justify-center flex-shrink-0 shadow-md">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div x-show="sidebarOpen" class="overflow-hidden flex-1">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name ?? 'Usuario' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                    <span
                        class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                        <i class="fas fa-shield-alt text-xs"></i>
                        @hasrole('Admin')
                            Administrador
                        @elseif(Auth::user()->hasRole('Supervisor'))
                            Supervisor
                        @elseif(Auth::user()->hasRole('Registrador'))
                            Registrador
                        @elseif(Auth::user()->hasRole('Ipress'))
                            IPRESS
                        @else
                            Sin rol
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Botón de Cerrar Sesión (ya existe) -->
            <div class="p-3 pt-0 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 text-red-600 hover:bg-red-50 hover:text-red-700 group">
                        <i class="fas fa-sign-out-alt w-5 text-lg"></i>
                        <span x-show="sidebarOpen" class="text-sm font-medium">Cerrar Sesión</span>
                        <span x-show="!sidebarOpen" class="hidden">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
        <script>
function sidebarUsuarios() {
    return {
        onlineUsers: [],
        onlineCount: 0,
        intervalo: null,
        
        init() {
            this.cargarUsuarios();
            this.intervalo = setInterval(() => this.cargarUsuarios(), 15000);
        },
        
        cargarUsuarios() {
            fetch('/api/usuarios/conectados')
                .then(res => res.json())
                .then(data => {
                    this.onlineUsers = data.online || [];
                    this.onlineCount = data.total_online || 0;
                })
                .catch(err => console.error('Error:', err));
        },
        
        destroy() {
            if (this.intervalo) clearInterval(this.intervalo);
        }
    }
}
</script>
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
