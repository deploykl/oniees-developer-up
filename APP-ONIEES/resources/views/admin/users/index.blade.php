<x-app-layout>
    @section('title', 'Usuarios')
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-center text-2xl font-bold">Gestión de Usuarios</h3>
                    @can("Usuarios - Crear")
                        <a href="{{ route('users-add') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-plus"></i> Nuevo Usuario
                        </a>
                    @endcan
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200" id="users-table">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Nombre</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Rol</th>
                                <th class="px-4 py-2 border">2FA</th>
                                <th class="px-4 py-2 border">Estado</th>
                                <th class="px-4 py-2 border">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-2 border text-center">{{ $user->id }}</td>
                                <td class="px-4 py-2 border">{{ $user->name }} {{ $user->lastname }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <td class="px-4 py-2 border text-center">
                                    @if($user->tipo_rol == 1)
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Superadmin</span>
                                    @elseif($user->tipo_rol == 2)
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">Admin</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">Usuario</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    @if($user->two_factor_secret)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                            <i class="fas fa-check-circle"></i> Activado
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">
                                            <i class="fas fa-times-circle"></i> No
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    @if($user->state_id == 2)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Activo</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    @can("Usuarios - Editar")
                                        <a href="{{ route('users-edit', $user->id) }}" class="text-blue-500 hover:text-blue-700 mr-2" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can("Usuarios - Eliminar")
                                        @if(Auth::user()->id != $user->id)
                                            <button onclick="deleteUser({{ $user->id }})" class="text-red-500 hover:text-red-700" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function deleteUser(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route("users-delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'OK') {
                        Swal.fire('Eliminado', data.mensaje, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.mensaje, 'error');
                    }
                });
            }
        });
    }
    </script>
</x-app-layout>