{{-- resources/views/admin/usuarios-conectados.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-users"></i> Usuarios en Línea
        </h2>
    </x-slot>

    <div class="py-12" x-data="usuariosOnline()" x-init="init()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Resumen -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-circle text-white text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-green-600">En línea ahora</p>
                                    <p class="text-2xl font-bold text-green-700" x-text="onlineCount"></p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-clock text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Conectados recientemente</p>
                                    <p class="text-2xl font-bold text-gray-700" x-text="offlineCount"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-4">
                        <nav class="flex gap-4">
                            <button @click="activeTab = 'online'" 
                                :class="activeTab === 'online' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-4 border-b-2 font-medium text-sm transition">
                                <i class="fas fa-circle text-green-500 mr-1 text-xs"></i>
                                En línea <span x-text="`(${onlineCount})`" class="text-xs"></span>
                            </button>
                            <button @click="activeTab = 'offline'" 
                                :class="activeTab === 'offline' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500'"
                                class="py-2 px-4 border-b-2 font-medium text-sm transition">
                                <i class="fas fa-clock text-gray-400 mr-1 text-xs"></i>
                                Recientes <span x-text="`(${offlineCount})`" class="text-xs"></span>
                            </button>
                        </nav>
                    </div>
                    
                    <!-- Tabla de usuarios online -->
                    <div x-show="activeTab === 'online'" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Última actividad</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="user in onlineUsers" :key="user.id">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-teal-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user text-teal-600 text-sm"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900" x-text="user.name"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="user.email"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full bg-teal-100 text-teal-700" x-text="user.role || 'Usuario'"></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center gap-1">
                                                <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
                                                <span x-text="user.last_activity"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div x-show="onlineUsers.length === 0" class="text-center py-12">
                            <i class="fas fa-user-friends text-5xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No hay usuarios en línea</p>
                        </div>
                    </div>
                    
                    <!-- Tabla de usuarios offline -->
                    <div x-show="activeTab === 'offline'" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Última vez</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="user in offlineUsers" :key="user.id">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-500 text-sm"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900" x-text="user.name"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="user.email"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700" x-text="user.role || 'Usuario'"></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-clock text-gray-400 text-xs"></i>
                                                <span x-text="user.last_seen"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div x-show="offlineUsers.length === 0" class="text-center py-12">
                            <i class="fas fa-user-friends text-5xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No hay usuarios recientes</p>
                        </div>
                    </div>
                    
                    <!-- Última actualización -->
                    <div class="text-center text-xs text-gray-400 mt-4 pt-4 border-t">
                        <span x-text="'Última actualización: ' + lastUpdate"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function usuariosOnline() {
        return {
            onlineUsers: [],
            offlineUsers: [],
            onlineCount: 0,
            offlineCount: 0,
            activeTab: 'online',
            lastUpdate: '',
            intervalo: null,
            
            init() {
                this.cargarUsuarios();
                // Actualizar cada 10 segundos (funciona en cualquier hosting)
                this.intervalo = setInterval(() => this.cargarUsuarios(), 10000);
            },
            
            cargarUsuarios() {
                fetch('/api/usuarios/conectados')
                    .then(res => res.json())
                    .then(data => {
                        this.onlineUsers = data.online || [];
                        this.offlineUsers = data.offline || [];
                        this.onlineCount = data.total_online || 0;
                        this.offlineCount = data.total_offline || 0;
                        this.lastUpdate = new Date().toLocaleTimeString();
                    })
                    .catch(err => console.error('Error:', err));
            },
            
            destroy() {
                if (this.intervalo) clearInterval(this.intervalo);
            }
        }
    }
    </script>
</x-app-layout>