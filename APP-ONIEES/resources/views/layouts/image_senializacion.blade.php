<div>
    <label for="{{ $field_name }}" class="form-label">{{ $field_label }}:</label>

    @if(isset($senializacion->$field_name) && $senializacion->$field_name)
        <!-- Botones para modal y descarga -->
        <div class="mb-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $field_name }}Modal">
                Ver Imagen
            </button>
            <a href="{{ asset('storage/' . $senializacion->$field_name) }}" download="{{ $field_label }}" class="btn btn-secondary">
                Descargar Imagen
            </a>
        </div>

        <!-- Modal para vista previa -->
        <div class="modal fade" id="{{ $field_name }}Modal" tabindex="-1" aria-labelledby="{{ $field_name }}ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{ $field_name }}ModalLabel">Vista Previa - {{ $field_label }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $senializacion->$field_name) }}" alt="{{ $field_label }}" style="max-width: 100%; height: auto;" class="img-fluid">
                    </div>
                    <div class="modal-footer">
                        <a href="{{ asset('storage/' . $senializacion->$field_name) }}" download="{{ $field_label }}" class="btn btn-secondary">
                            Descargar Imagen
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Input para subir nueva imagen -->
    <input type="file" class="form-control" id="{{ $field_name }}" name="{{ $field_name }}" accept="image/*" max-size="{{ env('MAX_FILE_SIZE', 2) * 1024 }}" />
    <small class="text-muted">Subir nueva imagen para reemplazar la existente.</small>
    <div class="invalid-feedback">Por favor, suba una imagen válida.</div>
</div>