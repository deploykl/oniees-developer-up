<div class="space-y-6">
    <div class="bg-teal-50 p-4 rounded-lg mb-4">
        <h3 class="text-lg font-semibold text-teal-800 mb-2 flex items-center gap-2">
            <i class="fas fa-hard-hat"></i> Módulo de Infraestructura
        </h3>
        <p class="text-sm text-gray-600">Complete los datos de infraestructura del establecimiento de salud</p>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 1: ESTADO DEL SANEAMIENTO FÍSICO LEGAL -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-file-signature"></i> 1. Estado del Saneamiento Físico Legal
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado del Saneamiento Físico
                        Legal</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="t_estado_saneado" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->t_estado_saneado ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="t_estado_saneado" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->t_estado_saneado ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Condición de Saneamiento Físico
                        Legal</label>
                    <select name="t_condicion_saneamiento"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        <option value="PROPIO"
                            {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'PROPIO' ? 'selected' : '' }}>PROPIO
                        </option>
                        <option value="ALQUILER"
                            {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'ALQUILER' ? 'selected' : '' }}>
                            ALQUILER</option>
                        <option value="CESION"
                            {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'CESION' ? 'selected' : '' }}>CESIÓN
                        </option>
                        <option value="OTRO"
                            {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'OTRO' ? 'selected' : '' }}>OTRO
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Copia Literal, Convenio, Contrato o N°
                        de Partida Registral</label>
                    <input type="text" name="t_nro_contrato" value="{{ $infraestructura->t_nro_contrato ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ingrese el número">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título a favor de</label>
                    <input type="text" name="t_titulo_a_favor" value="{{ $infraestructura->t_titulo_a_favor ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: MINSA, GOBIERNO REGIONAL">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observación</label>
                    <input type="text" name="t_observacion" value="{{ $infraestructura->t_observacion ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Observaciones del terreno">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA TERRENO (m²)</label>
                    <input type="number" step="0.01" name="t_area_terreno"
                        value="{{ $infraestructura->t_area_terreno ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0.00">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA CONSTRUIDA (m²)</label>
                    <input type="number" step="0.01" name="t_area_construida"
                        value="{{ $infraestructura->t_area_construida ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0.00">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA ESTACIONAMIENTO (m²)</label>
                    <input type="number" step="0.01" name="t_area_estac"
                        value="{{ $infraestructura->t_area_estac ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0.00">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA LIBRE (m²)</label>
                    <input type="number" step="0.01" name="t_area_libre"
                        value="{{ $infraestructura->t_area_libre ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0.00">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">N° PLAZA DE ESTACIONAMIENTO</label>
                    <input type="number" name="t_estacionamiento"
                        value="{{ $infraestructura->t_estacionamiento ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">¿CUENTA CON INSPECCIÓN TÉCNICA DE
                        SEGURIDAD EN EDIFICACIONES?</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="t_inspeccion" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->t_inspeccion ?? '') == 'SI' ? 'checked' : '' }}
                                onclick="document.getElementById('estado_inspeccion_div').style.display = 'block'">
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="t_inspeccion" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->t_inspeccion ?? '') == 'NO' ? 'checked' : '' }}
                                onclick="document.getElementById('estado_inspeccion_div').style.display = 'none'">
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <div id="estado_inspeccion_div"
                    style="display: {{ ($infraestructura->t_inspeccion ?? '') == 'SI' ? 'block' : 'none' }};">
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ESTADO DE LA INSPECCIÓN</label>
                        <select name="t_inspeccion_estado"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Seleccione</option>
                            <option value="APROBADO"
                                {{ ($infraestructura->t_inspeccion_estado ?? '') == 'APROBADO' ? 'selected' : '' }}>
                                APROBADO</option>
                            <option value="NO APROBADO"
                                {{ ($infraestructura->t_inspeccion_estado ?? '') == 'NO APROBADO' ? 'selected' : '' }}>
                                NO APROBADO</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 2: PLANOS TÉCNICOS (FÍSICO) -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-drafting-compass"></i> 2. Disponibilidad de Planos Técnicos (FÍSICO)
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach (['pf_ubicacion' => 'PLANO DE UBICACIÓN', 'pf_estructuras' => 'PLANOS DE ESTRUCTURAS', 'pf_ins_mecanicas' => 'PLANOS DE INSTALACIONES MECÁNICAS', 'pf_perimetro' => 'PLANO PERIMÉTRICO', 'pf_ins_sanitarias' => 'PLANOS DE INSTALACIONES SANITARIAS', 'pf_ins_comunic' => 'PLANOS DE INSTALACIONES DE COMUNICACIONES', 'pf_arquitectura' => 'PLANO DE ARQUITECTURA', 'pf_ins_electricas' => 'PLANOS DE INSTALACIONES ELÉCTRICAS', 'pf_distribuicion' => 'PLANOS DE DISTRIBUCIÓN DE EQUIPAMIENTO'] as $name => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON
                            {{ $label }}</label>
                        <div class="flex gap-4 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="{{ $name }}" value="SI"
                                    class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                    {{ ($infraestructura->$name ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">SI</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="{{ $name }}" value="NO"
                                    class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                    {{ ($infraestructura->$name ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 2B: PLANOS TÉCNICOS (DIGITAL) -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-laptop-code"></i> 2.1 Disponibilidad de Planos Técnicos (DIGITAL)
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach (['pd_ubicacion' => 'PLANO DE UBICACIÓN', 'pd_perimetro' => 'PLANO PERIMÉTRICO', 'pd_arquitectura' => 'PLANOS DE ARQUITECTURA', 'pd_estructuras' => 'PLANOS DE ESTRUCTURAS', 'pd_ins_sanitarias' => 'PLANOS DE INSTALACIONES SANITARIAS', 'pd_ins_electricas' => 'PLANOS DE INSTALACIONES ELÉCTRICAS', 'pd_ins_mecanicas' => 'PLANOS DE INSTALACIONES MECÁNICAS', 'pd_ins_comunic' => 'PLANOS DE INSTALACIONES DE COMUNICACIONES', 'pd_distribuicion' => 'PLANOS DE DISTRIBUCIÓN DE EQUIPAMIENTO'] as $name => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON
                            {{ $label }}</label>
                        <div class="flex gap-4 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="{{ $name }}" value="SI"
                                    class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                    {{ ($infraestructura->$name ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">SI</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="{{ $name }}" value="NO"
                                    class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                    {{ ($infraestructura->$name ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 3.1: SOBRE LA EDIFICACIÓN -->
    <!-- ============================================ -->
    <!-- ============================================ -->
    <!-- SECCIÓN 3.1: SOBRE LA EDIFICACIÓN -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-building"></i> 3.1 Sobre la Edificación
            </h3>
            <p class="text-sm text-gray-500 mt-1">Registre los datos de las edificaciones del establecimiento de salud
            </p>
        </div>
        <div class="p-6">
            <div class="mb-4 flex justify-end">
                <button type="button" onclick="openEdificacionModal()"
                    class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg shadow-sm transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Agregar Edificación
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bloque</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pabellón</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">UPSS/UPS</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Pisos</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Antigüedad</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Últ.
                                Intervención</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-edificaciones" class="bg-white divide-y divide-gray-200">
                        @if (isset($edificaciones) && $edificaciones->count())
                            @foreach ($edificaciones as $edif)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $edif->bloque ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $edif->pabellon ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        {{ $edif->upss->nombre ?? ($edif->servicio ?? '-') }}</td>
                                    <td class="px-4 py-2 text-sm text-center">{{ $edif->nropisos ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-center">{{ $edif->antiguedad ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $edif->ultima_intervencion ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        {{ $edif->tipoIntervencion->nombre ?? ($edif->tipo_intervencion ?? '-') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <button type="button" onclick="editEdificacion({{ $edif->id }})"
                                            class="text-blue-600 hover:text-blue-800 mr-2" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" onclick="deleteEdificacion({{ $edif->id }})"
                                            class="text-red-600 hover:text-red-800" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="px-4 py-4 text-center text-gray-500">No hay edificaciones
                                    registradas</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 4: CERRAMIENTO PERIMETRAL -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-fence"></i> 4. Cerramiento Perimetral
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">¿Cuenta con cerco perimétrico?</label>
                    <select name="cp_erco_perim"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        <option value="SI"
                            {{ ($infraestructura->cp_erco_perim ?? '') == 'SI' ? 'selected' : '' }}>SI</option>
                        <option value="NO"
                            {{ ($infraestructura->cp_erco_perim ?? '') == 'NO' ? 'selected' : '' }}>NO</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Material del cerco</label>
                    <select name="cp_material"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        <option value="LADRILLO"
                            {{ ($infraestructura->cp_material ?? '') == 'LADRILLO' ? 'selected' : '' }}>Ladrillo
                        </option>
                        <option value="CONCRETO"
                            {{ ($infraestructura->cp_material ?? '') == 'CONCRETO' ? 'selected' : '' }}>Concreto
                        </option>
                        <option value="METAL"
                            {{ ($infraestructura->cp_material ?? '') == 'METAL' ? 'selected' : '' }}>Metal</option>
                        <option value="MADERA"
                            {{ ($infraestructura->cp_material ?? '') == 'MADERA' ? 'selected' : '' }}>Madera</option>
                        <option value="OTRO"
                            {{ ($infraestructura->cp_material ?? '') == 'OTRO' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado del cerco</label>
                    <select name="cp_estado"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        <option value="BUENO" {{ ($infraestructura->cp_estado ?? '') == 'BUENO' ? 'selected' : '' }}>
                            Bueno</option>
                        <option value="REGULAR"
                            {{ ($infraestructura->cp_estado ?? '') == 'REGULAR' ? 'selected' : '' }}>Regular</option>
                        <option value="MALO" {{ ($infraestructura->cp_estado ?? '') == 'MALO' ? 'selected' : '' }}>
                            Malo</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 5: FECHA DE EVALUACIÓN -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-calendar-alt"></i> 5. Fecha de Evaluación
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Evaluación</label>
                    <input type="date" name="fecha_evaluacion"
                        value="{{ $infraestructura->fecha_evaluacion ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Inicio</label>
                    <input type="time" name="hora_inicio" value="{{ $infraestructura->hora_inicio ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Finalización</label>
                    <input type="time" name="hora_final" value="{{ $infraestructura->hora_final ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Comentarios / Observaciones
                    Generales</label>
                <textarea name="comentarios" rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                    placeholder="Ingrese comentarios adicionales...">{{ $infraestructura->comentarios ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>

<script>
    const establecimientoId = {{ $establecimiento->id ?? 'null' }};

    function openEdificacionModal() {
        const modal = document.getElementById('edificacionModal');
        const form = document.getElementById('edificacion_id');
        const modalTitle = document.getElementById('modalTitle');

        if (modalTitle) modalTitle.innerText = 'Agregar Edificación';
        document.getElementById('bloque').value = '';
        document.getElementById('pabellon').value = '';
        document.getElementById('servicio').value = '';
        document.getElementById('nropisos').value = '';
        document.getElementById('antiguedad').value = '';
        document.getElementById('ultima_intervencion').value = '';
        document.getElementById('tipo_intervencion').value = '';
        document.getElementById('observacion').value = '';
        if (form) form.value = '';
        if (modal) modal.classList.remove('hidden');
    }

    function closeEdificacionModal() {
        const modal = document.getElementById('edificacionModal');
        if (modal) modal.classList.add('hidden');
    }

    function guardarEdificacion() {
        const id = document.getElementById('edificacion_id')?.value;
        const url = id ? `/infraestructura/edificaciones/${id}` : '/infraestructura/edificaciones';
        const method = id ? 'PUT' : 'POST';

        const data = {
            id_establecimiento: Number(establecimientoId),
            bloque: document.getElementById('bloque')?.value || '',
            pabellon: document.getElementById('pabellon')?.value || '',
            servicio: document.getElementById('servicio')?.value || '',
            nropisos: document.getElementById('nropisos')?.value || '',
            antiguedad: document.getElementById('antiguedad')?.value || '',
            ultima_intervencion: document.getElementById('ultima_intervencion')?.value || '',
            tipo_intervencion: document.getElementById('tipo_intervencion')?.value || '',
            observacion: document.getElementById('observacion')?.value || '',
            _token: document.querySelector('input[name="_token"]')?.value || ''
        };

        const btn = event?.target;
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        }

        fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || ''
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    closeEdificacionModal();
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-save"></i> Guardar';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar: ' + error.message);
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save"></i> Guardar';
                }
            });
    }

    async function editEdificacion(id) {
        try {
            // CAMBIA show por get
            const response = await fetch(`/infraestructura/edificaciones/get/${id}`);
            const data = await response.json();

            document.getElementById('modalTitle').innerText = 'Editar Edificación';
            document.getElementById('edificacion_id').value = data.id;
            document.getElementById('bloque').value = data.bloque || '';
            document.getElementById('pabellon').value = data.pabellon || '';
            document.getElementById('servicio').value = data.servicio || '';
            document.getElementById('nropisos').value = data.nropisos || '';
            document.getElementById('antiguedad').value = data.antiguedad || '';
            document.getElementById('ultima_intervencion').value = data.ultima_intervencion || '';
            document.getElementById('tipo_intervencion').value = data.tipo_intervencion || '';
            document.getElementById('observacion').value = data.observacion || '';

            document.getElementById('edificacionModal').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
            alert('Error al cargar los datos');
        }
    }

    async function deleteEdificacion(id) {
        if (confirm('¿Está seguro de eliminar esta edificación?')) {
            try {
                const response = await fetch(`/infraestructura/edificaciones/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || ''
                    }
                });
                const result = await response.json();
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al eliminar');
            }
        }
    }
</script>
