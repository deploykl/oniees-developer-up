<x-app-layout>
    <x-slot name="title">Usuarios</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="p-6">
                    <!-- Header con filtros -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                            Gestión de Usuarios
                        </h3>
                        @can('Usuarios - Crear')
                            <a href="{{ route('users-add') }}"
                                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                <i class="fas fa-plus"></i> Nuevo Usuario
                            </a>
                        @endcan
                    </div>

                    <!-- Barra de búsqueda y filtros -->
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div class="flex-1">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="searchInput" placeholder="Buscar por nombre, email o documento..." 
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                            </div>
                        </div>
                        <div class="w-full md:w-64">
                            <select id="diresaFilter" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                <option value="">Todas las DIRIS</option>
                                @foreach ($diresas as $diresa)
                                    <option value="{{ $diresa->id }}">{{ $diresa->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-48">
                            <select id="estadoFilter" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                <option value="">Todos los estados</option>
                                <option value="2">Activo</option>
                                <option value="3">Inactivo</option>
                            </select>
                        </div>
                        <div class="w-full md:w-48">
                            <select id="rolFilter" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/50 hover:bg-white">
                                <option value="">Todos los roles</option>
                                <option value="Admin">Admin</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Registrador">Registrador</option>
                                <option value="Ipress">Ipress</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full bg-white" id="users-table">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">ID</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Usuario</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Rol</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">DIRIS</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">2FA</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Estado</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Fecha Creación</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body">
                                @foreach ($users as $user)
                                    <tr id="user-row-{{ $user->id }}" class="border-b border-gray-100 hover:bg-blue-50/30 transition-all duration-200">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $user->id }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-teal-500 flex items-center justify-center shadow-sm">
                                                    <span class="text-white text-xs font-bold">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }} {{ $user->lastname }}</p>
                                                    <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-3">
                                            @if ($user->hasRole('Admin'))
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700 shadow-sm">Admin</span>
                                            @elseif($user->hasRole('Supervisor'))
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 shadow-sm">Supervisor</span>
                                            @elseif($user->hasRole('Registrador'))
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700 shadow-sm">Registrador</span>
                                            @elseif($user->hasRole('Ipress'))
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700 shadow-sm">Ipress</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 shadow-sm">Sin rol</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            @php
                                                $diresaNombre = '';
                                                if($user->iddiresa) {
                                                    $ids = explode(',', $user->iddiresa);
                                                    $nombres = [];
                                                    foreach($ids as $id) {
                                                        $d = $diresas->firstWhere('id', $id);
                                                        if($d) $nombres[] = $d->nombre;
                                                    }
                                                    $diresaNombre = implode(', ', $nombres);
                                                }
                                            @endphp
                                            <span class="text-xs">{{ $diresaNombre ?: '-' }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($user->two_factor_secret)
                                                <span class="text-green-600"><i class="fas fa-check-circle"></i> Activado</span>
                                            @else
                                                <span class="text-gray-400"><i class="fas fa-times-circle"></i> No</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if (isset($user->state_id) && $user->state_id == 2)
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 shadow-sm">
                                                    <i class="fas fa-circle text-[8px] mr-1"></i> Activo
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-rose-100 text-rose-700 shadow-sm">
                                                    <i class="fas fa-circle text-[8px] mr-1"></i> Inactivo
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                @can('Usuarios - Editar')
                                                    <a href="{{ route('users-edit', $user->id) }}" 
                                                        class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-all duration-200" 
                                                        title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('Usuarios - Eliminar')
                                                    @if (Auth::user()->id != $user->id)
                                                        <button onclick="confirmDelete({{ $user->id }})" 
                                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all duration-200" 
                                                            title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6" id="pagination-container">
                        <div class="text-sm text-gray-500">
                            Mostrando <span id="start-count">0</span> a <span id="end-count">0</span> de <span id="total-count">0</span> resultados
                        </div>
                        <div class="flex gap-2">
                            <button id="prev-page" 
                                class="px-4 py-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-chevron-left mr-1"></i> Anterior
                            </button>
                            <div id="page-numbers" class="flex gap-1">
                                <!-- Los números de página se generarán con JS -->
                            </div>
                            <button id="next-page" 
                                class="px-4 py-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                Siguiente <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de eliminación -->
    <div x-data="{ open: false, userId: null }" x-on:open-delete-modal.window="open = true; userId = $event.detail.id" x-cloak>
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[200]" @click="open = false">
        </div>
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md z-[201]">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-center text-gray-900">Eliminar Usuario</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">¿Estás seguro de eliminar este usuario? Esta
                        acción no se puede deshacer.</p>
                </div>
                <div class="flex gap-3 p-6 pt-0">
                    <button type="button" @click="open = false"
                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Cancelar
                    </button>
                    <button type="button" x-on:click="if(userId) { deleteUser(userId); open = false; }"
                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let allUsers = @json($users);
        let currentPage = 1;
        let rowsPerPage = 10;
        let currentFilters = {
            search: '',
            diresa: '',
            estado: '',
            rol: ''
        };

        // Función para filtrar usuarios
        function filterUsers() {
            return allUsers.filter(user => {
                // Filtro por búsqueda
                const searchTerm = currentFilters.search.toLowerCase();
                const matchesSearch = searchTerm === '' || 
                    user.name.toLowerCase().includes(searchTerm) || 
                    (user.lastname && user.lastname.toLowerCase().includes(searchTerm)) ||
                    user.email.toLowerCase().includes(searchTerm) ||
                    (user.documento_identidad && user.documento_identidad.includes(searchTerm));

                // Filtro por DIRIS
                let matchesDiresa = true;
                if (currentFilters.diresa) {
                    const userDiresas = user.iddiresa ? user.iddiresa.split(',') : [];
                    matchesDiresa = userDiresas.includes(currentFilters.diresa);
                }

                // Filtro por estado
                const matchesEstado = currentFilters.estado === '' || user.state_id == currentFilters.estado;

                // Filtro por rol
                let matchesRol = true;
                if (currentFilters.rol) {
                    const roles = user.roles || [];
                    matchesRol = roles.some(r => r.name === currentFilters.rol);
                }

                return matchesSearch && matchesDiresa && matchesEstado && matchesRol;
            });
        }

        // Función para renderizar la tabla
        function renderTable() {
            const filteredUsers = filterUsers();
            const totalPages = Math.ceil(filteredUsers.length / rowsPerPage);
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const pageUsers = filteredUsers.slice(start, end);

            // Actualizar contadores
            document.getElementById('start-count').textContent = filteredUsers.length === 0 ? 0 : start + 1;
            document.getElementById('end-count').textContent = Math.min(end, filteredUsers.length);
            document.getElementById('total-count').textContent = filteredUsers.length;

            // Limpiar y llenar tabla
            const tbody = document.getElementById('users-table-body');
            tbody.innerHTML = '';

            if (pageUsers.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                            <i class="fas fa-search text-4xl mb-2 block"></i>
                            No se encontraron usuarios
                        </td>
                    </tr>
                `;
            } else {
                pageUsers.forEach(user => {
                    // Determinar rol
                    let rolHtml = '';
                    if (user.roles && user.roles.length > 0) {
                        const roleName = user.roles[0].name;
                        const roleColors = {
                            'Admin': 'bg-red-100 text-red-700',
                            'Supervisor': 'bg-blue-100 text-blue-700',
                            'Registrador': 'bg-green-100 text-green-700',
                            'Ipress': 'bg-purple-100 text-purple-700'
                        };
                        const colorClass = roleColors[roleName] || 'bg-gray-100 text-gray-600';
                        rolHtml = `<span class="px-2 py-1 text-xs font-medium rounded-full ${colorClass} shadow-sm">${roleName}</span>`;
                    } else {
                        rolHtml = `<span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 shadow-sm">Sin rol</span>`;
                    }

                    // Estado HTML
                    const estadoHtml = user.state_id == 2 
                        ? `<span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 shadow-sm"><i class="fas fa-circle text-[8px] mr-1"></i> Activo</span>`
                        : `<span class="px-2 py-1 text-xs font-medium rounded-full bg-rose-100 text-rose-700 shadow-sm"><i class="fas fa-circle text-[8px] mr-1"></i> Inactivo</span>`;

                    // Fecha formateada
                    const fecha = new Date(user.created_at);
                    const fechaFormateada = `${fecha.getDate().toString().padStart(2, '0')}/${(fecha.getMonth() + 1).toString().padStart(2, '0')}/${fecha.getFullYear()}`;

                    // Iniciales para avatar
                    const inicial = (user.name ? user.name.charAt(0).toUpperCase() : 'U');

                    tbody.innerHTML += `
                        <tr id="user-row-${user.id}" class="border-b border-gray-100 hover:bg-blue-50/30 transition-all duration-200">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${user.id}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-teal-500 flex items-center justify-center shadow-sm">
                                        <span class="text-white text-xs font-bold">${inicial}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">${user.name} ${user.lastname || ''}</p>
                                        <p class="text-xs text-gray-500">ID: ${user.id}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">${user.email}</td>
                            <td class="px-4 py-3">${rolHtml}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">-</td>
                            <td class="px-4 py-3 text-sm">
                                ${user.two_factor_secret 
                                    ? '<span class="text-green-600"><i class="fas fa-check-circle"></i> Activado</span>'
                                    : '<span class="text-gray-400"><i class="fas fa-times-circle"></i> No</span>'}
                            </td>
                            <td class="px-4 py-3">${estadoHtml}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${fechaFormateada}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="/admin/users/edit/${user.id}" 
                                        class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-all duration-200" 
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(${user.id})" 
                                        class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all duration-200" 
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            // Actualizar paginación
            updatePagination(totalPages);
        }

        // Función para actualizar los botones de paginación
        function updatePagination(totalPages) {
            const prevBtn = document.getElementById('prev-page');
            const nextBtn = document.getElementById('next-page');
            const pageNumbers = document.getElementById('page-numbers');

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages || totalPages === 0;

            // Generar números de página
            pageNumbers.innerHTML = '';
            const maxVisible = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);

            if (endPage - startPage + 1 < maxVisible) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }

            for (let i = startPage; i <= endPage; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = `px-3 py-2 rounded-lg transition-all duration-200 ${i === currentPage ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50'}`;
                btn.onclick = () => {
                    currentPage = i;
                    renderTable();
                };
                pageNumbers.appendChild(btn);
            }
        }

        // Event listeners para filtros
        document.getElementById('searchInput').addEventListener('input', (e) => {
            currentFilters.search = e.target.value;
            currentPage = 1;
            renderTable();
        });

        document.getElementById('diresaFilter').addEventListener('change', (e) => {
            currentFilters.diresa = e.target.value;
            currentPage = 1;
            renderTable();
        });

        document.getElementById('estadoFilter').addEventListener('change', (e) => {
            currentFilters.estado = e.target.value;
            currentPage = 1;
            renderTable();
        });

        document.getElementById('rolFilter').addEventListener('change', (e) => {
            currentFilters.rol = e.target.value;
            currentPage = 1;
            renderTable();
        });

        // Event listeners para paginación
        document.getElementById('prev-page').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        document.getElementById('next-page').addEventListener('click', () => {
            const totalPages = Math.ceil(filterUsers().length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });

        // Función deleteUser (mantener la existente)
        function confirmDelete(id) {
            window.dispatchEvent(new CustomEvent('open-delete-modal', { detail: { id: id } }));
        }

        function deleteUser(id) {
            fetch('{{ route('users-delete') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'OK') {
                    window.toast?.success(data.mensaje);
                    // Eliminar de allUsers y recargar
                    allUsers = allUsers.filter(u => u.id !== id);
                    renderTable();
                } else {
                    window.toast?.error(data.mensaje);
                }
            })
            .catch(error => {
                window.toast?.error('Error al eliminar el usuario');
            });
        }

        // Inicializar
        renderTable();
    </script>
</x-app-layout>