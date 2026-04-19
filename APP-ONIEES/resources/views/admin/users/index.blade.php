<x-app-layout>
    <x-slot name="title">Usuarios</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h3>
                    @can('Usuarios - Crear')
                        <a href="{{ route('users-add') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-plus mr-2"></i> Nuevo Usuario
                        </a>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg" id="users-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Nombre</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Rol</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">2FA</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Estado</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Fecha de Creación
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body">
                            @foreach ($users as $user)
                                <tr id="user-row-{{ $user->id }}"
                                    class="border-t border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-sm">{{ $user->id }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $user->name }} {{ $user->lastname }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        @if ($user->hasRole('Admin'))
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Admin</span>
                                        @elseif($user->hasRole('Supervisor'))
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Supervisor</span>
                                        @elseif($user->hasRole('Registrador'))
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Registrador</span>
                                        @elseif($user->hasRole('Ipress'))
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">Ipress</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">Sin
                                                rol</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if ($user->two_factor_secret)
                                            <span class="text-green-600"><i class="fas fa-check-circle"></i>
                                                Activado</span>
                                        @else
                                            <span class="text-gray-400"><i class="fas fa-times-circle"></i> No</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if (isset($user->state_id) && $user->state_id == 2)
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">Activo</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full bg-rose-100 text-rose-700">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $user->created_at }}</td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            @can('Usuarios - Editar')
                                                <a href="{{ route('users-edit', $user->id) }}"
                                                    class="text-blue-500 hover:text-blue-700 transition" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('Usuarios - Eliminar')
                                                @if (Auth::user()->id != $user->id)
                                                    <button onclick="confirmDelete({{ $user->id }})"
                                                        class="text-rose-500 hover:text-rose-700 transition"
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
        function confirmDelete(id) {
            window.dispatchEvent(new CustomEvent('open-delete-modal', {
                detail: {
                    id: id
                }
            }));
        }

        function deleteUser(id) {
            fetch('{{ route('users-delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'OK') {
                        // Mostrar toast de éxito
                        window.toast?.success(data.mensaje);
                        // Eliminar la fila de la tabla sin recargar
                        const row = document.getElementById(`user-row-${id}`);
                        if (row) {
                            row.style.transition = 'opacity 0.3s ease';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        }
                    } else {
                        window.toast?.error(data.mensaje);
                    }
                })
                .catch(error => {
                    window.toast?.error('Error al eliminar el usuario');
                });
        }
    </script>
</x-app-layout>
