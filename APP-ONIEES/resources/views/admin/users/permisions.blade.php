<x-app-layout>
    <x-slot name="title">Usuarios</x-slot>
    <x-slot name="url">{{ route('users-index') }}</x-slot>
    <x-slot name="subtitle">Editar</x-slot>
    <x-slot name="urlsubtitle">{{ route('users-edit', [ 'id' => $user_id ]) }}</x-slot>
    <x-slot name="subtitle2">Permisos</x-slot>
    <div class="container">
        <div class="card  mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                      <div class="table-responsive" style="max-height: 450px;">
                        <table class="table table-hover table-bordered mb-0 table-striped text-truncate">
                            <thead>
                              <tr>
                                <th scope="col" style="width: 70px;">Id</th>
                                <th scope="col">Nombre de Modulo</th>
                                {{-- <th scope="col">Nombre de Rol</th> --}}
                                <th scope="col" class="text-center" style="width: 137px;">Acceso</th>
                              </tr>
                            </thead>
                        </table>
                      </div>
                      <form id="UserPermission" class="table-responsive" style="max-height: 450px;">
                        {{ csrf_field() }}
                        @php
                            $groupedPermissions = collect($permissions)->groupBy('module');
                        @endphp
                        <table class="table table-hover table-bordered table-striped text-truncate">
                            <tbody>
                                @forelse($groupedPermissions as $module => $permissionsGroup)
                                    <tr class="table-primary">
                                        <th colspan="3" class="text-center">{{ $module }}</th>
                                    </tr>
                                    @foreach($permissionsGroup as $permission)
                                        <tr>
                                            <th scope="row" style="width: 70px;">{{ $permission["id"] }}</th>
                                            <td>{{ $permission["name"] }}</td>
                                            {{-- <td>{{ $permission["guard_name"] }}</td> --}}
                                            <td style="width: 120px;">
                                                <div class="form-check" style="max-width: 16px;margin:auto">
                                                    @if (!$permission["active"])
                                                        <input class="form-check-input" id="permission-{{ $permission["id"] }}" type="checkbox" value="{{ $permission['name'] }}">
                                                    @else
                                                        <input class="form-check-input" id="permission-{{ $permission["id"] }}" type="checkbox" checked value="{{ $permission['name'] }}">
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No hay permisos disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                      </form>
                    </div>
                    <div class="col-md-12 d-flex mt-2 justify-content-around">
                        <button type="button" onclick="Guardar()" class="btn btn-submit btn-guardar btn-primary">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                        <a href="{{ route('users-edit', ['id' => $user_id]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
      function Guardar() {
        var formData = new FormData(document.getElementById("UserPermission"));
        var permisos = $("input[type=checkbox]");
        var valores = [];
        
        formData.append('id', '{{ $user_id }}');
        formData.append('total', permisos.length);
        
        $('input[type=checkbox]').each(function(index) {
            valores.push({
                'permission' : $(this).val(),
                'active' : $(this).is(":checked")
            });
            formData.append('permission' + index, $(this).val() + "||" + $(this).is(":checked"));
        });
        
        console.log(valores);
        $.ajax({
            type: "POST",
            url : "{{ route('users-update-permission') }}",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(".btn-submit").prop("disabled", true);
                $(".btn-submit").html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...')
            },
            success : function(result){
                debugger;
                console.log(result);
                alert(result.mensaje);
                $(".btn-submit").html('<i class="fas fa-save"></i> Guardar Cambios');
                $(".btn-submit").prop("disabled", false);
            },
            error: function( jqXHR, textStatus, errorThrown ) {

            }
        });
      };
    </script>
</x-app-layout>
