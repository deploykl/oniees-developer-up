<x-app-layout>
  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>1. DATOS GENERALES DEL ESTABLECIMIENTO DE SALUD</h4>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <!-- SELECTOR DE ESTABLECIMIENTO -->
                    @if(isset($showSelector) && $showSelector)
                        <div class="alert alert-info">
                            <h5><i class="fas fa-search"></i> Buscar establecimiento</h5>
                            <p>Ingrese el código RENIPRESS del establecimiento que desea consultar/editar.</p>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" 
                                           id="buscar_codigo" 
                                           class="form-control" 
                                           placeholder="Ejemplo: 00003253"
                                           value="{{ $codigoBuscar ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="btn_buscar" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                            
                            <div id="resultado_busqueda" class="mt-3"></div>
                        </div>
                    @else
                        <!-- FORMULARIO DE DATOS GENERALES -->
                        <form method="POST" action="{{ route('infraestructura.save') }}">
                            @csrf
                            
                            <input type="hidden" name="id_establecimiento" value="{{ $establecimiento->id ?? '' }}">
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>CÓDIGO IPRESS (*)</label>
                                    <input type="text" class="form-control" name="codigo_ipress" value="{{ $establecimiento->codigo ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>INSTITUCIÓN (*)</label>
                                    <input type="text" class="form-control" name="institucion" value="{{ $establecimiento->institucion ?? 'GOBIERNO REGIONAL' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>NOMBRE DEL EESS (*)</label>
                                    <input type="text" class="form-control" name="nombre_eess" value="{{ $establecimiento->nombre_eess ?? '' }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>REGIÓN</label>
                                    <input type="text" class="form-control" name="region" value="{{ $establecimiento->region ?? '' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>PROVINCIA</label>
                                    <input type="text" class="form-control" name="provincia" value="{{ $establecimiento->provincia ?? '' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>DISTRITO</label>
                                    <input type="text" class="form-control" name="distrito" value="{{ $establecimiento->distrito ?? '' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>RED</label>
                                    <input type="text" class="form-control" name="red" value="{{ $establecimiento->nombre_red ?? '' }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>MICRORED</label>
                                    <input type="text" class="form-control" name="microred" value="{{ $establecimiento->nombre_microred ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>NIVEL DE ATENCIÓN</label>
                                    <input type="text" class="form-control" name="nivel_atencion" value="{{ $establecimiento->nivel_atencion ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>CATEGORÍA</label>
                                    <input type="text" class="form-control" name="categoria" value="{{ $establecimiento->categoria ?? '' }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>DIRECCIÓN</label>
                                    <input type="text" class="form-control" name="direccion" value="{{ $establecimiento->direccion ?? '' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>TELÉFONO</label>
                                    <input type="text" class="form-control" name="telefono" value="{{ $establecimiento->telefono ?? '' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>NÚMERO DE CAMAS</label>
                                    <input type="number" class="form-control" name="numero_camas" value="{{ $establecimiento->numero_camas ?? '' }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>DIRECTOR MÉDICO</label>
                                    <input type="text" class="form-control" name="director_medico" value="{{ $establecimiento->director_medico ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>HORARIO</label>
                                    <input type="text" class="form-control" name="horario" value="{{ $establecimiento->horario ?? '' }}">
                                </div>
                            </div>
                            
                            @if(Auth::user() && !Auth::user()->idestablecimiento_user)
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="asignar_a_mi" id="asignar_a_mi" value="1">
                                <label class="form-check-label" for="asignar_a_mi">
                                    Asignar este establecimiento a mi usuario (para futuros accesos)
                                </label>
                            </div>
                            @endif
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">GUARDAR</button>
                                <a href="{{ route('infraestructura.edit') }}" class="btn btn-secondary">LIMPIAR</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#btn_buscar').on('click', function() {
        var codigo = $('#buscar_codigo').val();
        
        if (!codigo) {
            alert('Ingrese un código RENIPRESS');
            return;
        }
        
        window.location.href = '{{ route("infraestructura.edit") }}?codigo=' + codigo;
    });
    
    var urlParams = new URLSearchParams(window.location.search);
    var codigoParam = urlParams.get('codigo');
    
    if (codigoParam && {{ isset($showSelector) && $showSelector ? 'true' : 'false' }}) {
        $.ajax({
            url: '{{ url("/infraestructura/buscar") }}/' + codigoParam,
            type: 'GET',
            success: function(response) {
                var html = '<div class="alert alert-success">';
                html += '<h5><i class="fas fa-check-circle"></i> Establecimiento encontrado</h5>';
                html += '<p><strong>Código:</strong> ' + response.codigo + '<br>';
                html += '<strong>Nombre:</strong> ' + response.nombre + '<br>';
                html += '<strong>Región:</strong> ' + (response.region || '-') + '<br>';
                html += '<strong>Provincia:</strong> ' + (response.provincia || '-') + '<br>';
                html += '<strong>Distrito:</strong> ' + (response.distrito || '-') + '</p>';
                html += '<button type="button" id="seleccionar_establecimiento" class="btn btn-success">Seleccionar este establecimiento</button>';
                html += '</div>';
                $('#resultado_busqueda').html(html);
                
                $('#seleccionar_establecimiento').on('click', function() {
                    window.location.href = '{{ route("infraestructura.edit") }}?cargar=' + response.id;
                });
            },
            error: function(xhr) {
                var errorMsg = 'Error al buscar';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                $('#resultado_busqueda').html('<div class="alert alert-danger">' + errorMsg + '</div>');
            }
        });
    }
});
</script>
</x-app-layout>