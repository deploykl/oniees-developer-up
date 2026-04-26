<style>
    /* Estilo global para inputs readonly con tema del footer */
    .input-readonly-teal {
        background: linear-gradient(135deg, rgba(14, 124, 158, 0.04), rgba(6, 182, 212, 0.04));
        border-color: rgba(14, 124, 158, 0.2);
        color: #1E3A5F;
        cursor: default;
        transition: all 0.2s ease;
    }

    .input-readonly-teal:focus {
        outline: none;
        border-color: rgba(14, 124, 158, 0.4);
        box-shadow: 0 0 0 2px rgba(14, 124, 158, 0.1);
    }

    .readonly-label {
        color: #1E3A5F;
        font-weight: 500;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    .readonly-badge {
        background: rgba(14, 124, 158, 0.1);
        border-radius: 20px;
        padding: 2px 8px;
        font-size: 0.6rem;
        font-weight: normal;
        color: #0E7C9E;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
</style>
<div id="datos-generales-section" class="space-y-6">
    <h1>1. DATOS GENERALES DEL ESTABLECIMIENTO DE SALUD</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="readonly-label">
                CÓDIGO IPRESS (*)
            </label>
            <div class="relative">
                <input type="text" name="codigo_ipress" class="w-full p-2.5 border rounded-lg input-readonly-teal pr-8"
                    value="{{ $establecimiento->codigo ?? '' }}" readonly>
                <i class="fas fa-lock  absolute right-3 top-1/2 -translate-y-1/2 text-[#0E7C9E] text-xs"></i>
            </div>
        </div>
        <div><label class="text-sm font-medium">NOMBRE DEL EESS (*)</label><input type="text" name="nombre_eess"
                class="w-full p-2 border rounded" value="{{ $establecimiento->nombre_eess ?? '' }}" readonly></div>
        <div><label class="text-sm font-medium">INSTITUCIÓN</label><input type="text" name="institucion"
                class="w-full p-2 border rounded" value="{{ $establecimiento->institucion ?? '' }}" readonly></div>
        <div><label class="text-sm font-medium">REGIÓN</label><input type="text" name="region"
                class="w-full p-2 border rounded" value="{{ $establecimiento->region ?? '' }}" readonly></div>
        <div><label class="text-sm font-medium">PROVINCIA</label><input type="text" name="provincia"
                class="w-full p-2 border rounded" value="{{ $establecimiento->provincia ?? '' }}" readonly></div>
        <div><label class="text-sm font-medium">DISTRITO</label><input type="text" name="distrito"
                class="w-full p-2 border rounded" value="{{ $establecimiento->distrito ?? '' }}" readonly></div>
        <div><label class="text-sm font-medium">RED</label><input type="text" name="red"
                class="w-full p-2 border rounded" value="{{ $establecimiento->nombre_red ?? '' }}" readonly></div>
        <div><label class="text-sm font-medium">MICRORED</label><input type="text" name="microred"
                class="w-full p-2 border rounded" value="{{ $establecimiento->nombre_microred ?? '' }}" readonly></div>
        <div>
            <label class="text-sm font-medium">NIVEL DE ATENCIÓN</label>
            <select name="nivel_atencion" class="w-full p-2 border rounded">
                <option value="">Seleccione</option>
                <option value="I" {{ ($establecimiento->nivel_atencion ?? '') == 'I' ? 'selected' : '' }}>I
                </option>
                <option value="II" {{ ($establecimiento->nivel_atencion ?? '') == 'II' ? 'selected' : '' }}>II
                </option>
                <option value="III" {{ ($establecimiento->nivel_atencion ?? '') == 'III' ? 'selected' : '' }}>III
                </option>
            </select>
        </div>
        <div><label class="text-sm font-medium">CATEGORÍA</label><input type="text" name="categoria"
                class="w-full p-2 border rounded" value="{{ $establecimiento->categoria ?? '' }}" readonly></div>
        <div><label class="text-sm font-medium">RESOLUCIÓN DE CATEGORÍA</label><input type="text"
                name="resolucion_categoria" class="w-full p-2 border rounded"
                value="{{ $establecimiento->resolucion_categoria ?? '' }}"></div>
        <div><label class="text-sm font-medium">CLASIFICACIÓN</label><input type="text" name="clasificacion"
                class="w-full p-2 border rounded" value="{{ $establecimiento->clasificacion ?? '' }}"></div>
        <div><label class="text-sm font-medium">TIPO</label><input type="text" name="tipo"
                class="w-full p-2 border rounded" value="{{ $establecimiento->tipo ?? '' }}"></div>
        <div><label class="text-sm font-medium">COD UE</label><input type="text" name="codigo_ue"
                class="w-full p-2 border rounded" value="{{ $establecimiento->codigo_ue ?? '' }}"></div>
        <div><label class="text-sm font-medium">UNIDAD EJECUTORA</label><input type="text" name="unidad_ejecutora"
                class="w-full p-2 border rounded" value="{{ $establecimiento->unidad_ejecutora ?? '' }}"></div>
        <div><label class="text-sm font-medium">TELÉFONO</label><input type="text" name="telefono"
                class="w-full p-2 border rounded" value="{{ $establecimiento->telefono ?? '' }}"></div>

        <div><label class="text-sm font-medium">DIRECTOR MÉDICO</label><input type="text" name="director_medico"
                class="w-full p-2 border rounded" value="{{ $establecimiento->director_medico ?? '' }}"></div>
        <div><label class="text-sm font-medium">HORARIO</label><input type="text" name="horario"
                class="w-full p-2 border rounded" value="{{ $establecimiento->horario ?? '' }}"></div>
    </div>
    <h2>ESTA INFORMACIÓN DEBERÍA SER PROPORCIONADA POR LOS SERVICIOS DE SALUD DE LA RED O DIRESA</h2>
    <div class="border-b border-gray-200 pb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-700">INICIO DE FUNCIONAMIENTO</label>
                <input type="date" name="inicio_funcionamiento"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                    value="{{ $establecimiento->inicio_funcionamiento ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">FECHA REGISTRO</label>
                <input type="date" name="fecha_registro"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                    value="{{ $establecimiento->fecha_registro ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">ULTIMA RECATEGORIZACIÓN</label>
                <input type="date" name="ultima_recategorizacion"
                    class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                    value="{{ $establecimiento->ultima_recategorizacion ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">ANTIGUEDAD DEL EE.SS (años)</label>
                <input type="number" name="antiguedad" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->antiguedad_anios ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">CATEGORIA INICIAL</label>
                <input type="text" name="categoria_inicial" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->categoria_inicial ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">QUINTIL</label>
                <input type="number" name="quintil" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->quintil ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">PCM/ZONA</label>
                <select name="pcm_zona" class="w-full p-2 border rounded-lg">
                    <option value="">Seleccione</option>
                    <option value="URBANO" {{ ($establecimiento->pcm_zona ?? '') == 'URBANO' ? 'selected' : '' }}>
                        URBANO</option>
                    <option value="RURAL" {{ ($establecimiento->pcm_zona ?? '') == 'RURAL' ? 'selected' : '' }}>RURAL
                    </option>
                    <option value="URBANO MARGINAL"
                        {{ ($establecimiento->pcm_zona ?? '') == 'URBANO MARGINAL' ? 'selected' : '' }}>URBANO MARGINAL
                    </option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">FRONTERA</label>
                <select name="frontera" class="w-full p-2 border rounded-lg">
                    <option value="">Seleccione</option>
                    <option value="1"
                        {{ ($establecimiento->frontera ?? '') == '1' || ($establecimiento->frontera ?? '') == 1 ? 'selected' : '' }}>
                        Sí</option>
                    <option value="0"
                        {{ ($establecimiento->frontera ?? '') == '0' || ($establecimiento->frontera ?? '') == 0 ? 'selected' : '' }}>
                        No</option>
                </select>
            </div>
        </div>
    </div>
    <h2>DATOS ADICIONALES</h2>
    <!-- DATOS DE INFRAESTRUCTURA Y PROPIETARIO -->
    <div class="border-b border-gray-200 pb-4">
        <h3 class="text-md font-semibold text-gray-700 mb-3">🏢 DATOS DE INFRAESTRUCTURA Y PROPIETARIO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-700">NÚMERO DE CAMAS</label>
                <input type="number" name="numero_camas" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->numero_camas ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">AUTORIDAD SANITARIA</label>
                <input type="text" name="autoridad_sanitaria" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->autoridad_sanitaria ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">PROPIETARIO RUC</label>
                <input type="text" name="propietario_ruc" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->propietario_ruc ?? '' }}">
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700">PROPIETARIO RAZON SOCIAL</label>
                <input type="text" name="propietario_razon_social" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->propietario_razon_social ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">SITUACION ESTADO</label>
                <select name="situacion_estado" class="w-full p-2 border rounded-lg">
                    <option value="">Seleccione</option>
                    <option value="REGULAR"
                        {{ ($establecimiento->situacion_estado ?? '') == 'REGULAR' ? 'selected' : '' }}>REGULAR
                    </option>
                    <option value="BUENO"
                        {{ ($establecimiento->situacion_estado ?? '') == 'BUENO' ? 'selected' : '' }}>BUENO</option>
                    <option value="MALO"
                        {{ ($establecimiento->situacion_estado ?? '') == 'MALO' ? 'selected' : '' }}>MALO</option>
                    <option value="EN CONSTRUCCION"
                        {{ ($establecimiento->situacion_estado ?? '') == 'EN CONSTRUCCION' ? 'selected' : '' }}>EN
                        CONSTRUCCION</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">SITUACION CONDICION</label>
                <select name="situacion_condicion" class="w-full p-2 border rounded-lg">
                    <option value="">Seleccione</option>
                    <option value="MAL"
                        {{ ($establecimiento->situacion_condicion ?? '') == 'MAL' ? 'selected' : '' }}>MAL</option>
                    <option value="REGULAR"
                        {{ ($establecimiento->situacion_condicion ?? '') == 'REGULAR' ? 'selected' : '' }}>REGULAR
                    </option>
                    <option value="BUENO"
                        {{ ($establecimiento->situacion_condicion ?? '') == 'BUENO' ? 'selected' : '' }}>BUENO</option>
                    <option value="EXCELENTE"
                        {{ ($establecimiento->situacion_condicion ?? '') == 'EXCELENTE' ? 'selected' : '' }}>EXCELENTE
                    </option>
                </select>
            </div>
        </div>
    </div>
    <h1>2. LOCALIZACIÓN GEOGRÁFICA</h1>
    <!-- UBICACIÓN Y COORDENADAS -->
    <div class="border-b border-gray-200 pb-4">
        <h3 class="text-md font-semibold text-gray-700 mb-3">📍 UBICACIÓN Y COORDENADAS</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700">DIRECCIÓN</label>
                <input type="text" name="direccion" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->direccion ?? '' }}" placeholder="Ej: JR. SIDERAL S/N">
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700">REFERENCIA</label>
                <input type="text" name="referencia" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->referencia ?? '' }}" placeholder="Ej: Cerca al mercado central">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">M.S.N.M. (ALTITUD)</label>
                <input type="number" name="cota" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->cota ?? '' }}" placeholder="Ej: 3833">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">COORDENADAS UTM NORTE</label>
                <input type="text" name="coord_utm_norte" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->coordenada_utm_norte ?? '' }}" placeholder="Ej: -15.863840">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">COORDENADAS UTM ESTE</label>
                <input type="text" name="coord_utm_este" class="w-full p-2 border rounded-lg"
                    value="{{ $establecimiento->coordenada_utm_este ?? '' }}" placeholder="Ej: 1234567">
            </div>
        </div>
    </div>
    <h1>3. INDICE SEGURIDAD HOSPITALARIA</h1>
<h1>3. INDICE SEGURIDAD HOSPITALARIA</h1>
<div class="border-b border-gray-200 pb-4">
    <h3 class="text-md font-semibold text-gray-700 mb-3">🛡️ ÍNDICE DE SEGURIDAD HOSPITALARIA</h3>

    <div class="space-y-4">
        <!-- Pregunta 1: Documento -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                ¿CUENTO CON EL DOCUMENTO DE ÍNDICE DE SEGURIDAD HOSPITALARIA?
            </label>
            <div class="flex gap-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="tiene_documento_seguridad" value="1"
                        class="form-radio text-blue-500"
                        {{ ($format->seguridad_hospitalaria ?? '') == 'SI' ? 'checked' : '' }}
                        onclick="document.getElementById('resultado_seguridad_div').style.display = 'block'">
                    <span class="ml-2 text-sm text-gray-700">SI</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="tiene_documento_seguridad" value="0"
                        class="form-radio text-blue-500"
                        {{ ($format->seguridad_hospitalaria ?? '') == 'NO' ? 'checked' : '' }}
                        onclick="document.getElementById('resultado_seguridad_div').style.display = 'none'">
                    <span class="ml-2 text-sm text-gray-700">NO</span>
                </label>
            </div>
        </div>

        <!-- Resultado (visible solo si tiene documento = SI) -->
        <div id="resultado_seguridad_div"
            style="{{ ($format->seguridad_hospitalaria ?? '') == 'SI' ? 'display:block' : 'display:none' }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        ¿CUÁL FUE EL RESULTADO? (*)
                    </label>
                    <select name="resultado_seguridad" class="w-full p-2 border rounded-lg">
                        <option value="">Seleccione</option>
                        <option value="CATEGORIA A"
                            {{ ($format->seguridad_resultado ?? '') == 'CATEGORIA A' ? 'selected' : '' }}>
                            CATEGORIA A
                        </option>
                        <option value="CATEGORIA B"
                            {{ ($format->seguridad_resultado ?? '') == 'CATEGORIA B' ? 'selected' : '' }}>
                            CATEGORIA B
                        </option>
                        <option value="CATEGORIA C"
                            {{ ($format->seguridad_resultado ?? '') == 'CATEGORIA C' ? 'selected' : '' }}>
                            CATEGORIA C
                        </option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        ¿EN QUÉ FECHA SE REALIZÓ EL ÚLTIMO ÍNDICE DE SEGURIDAD HOSPITALARIA? (*)
                    </label>
                    <input type="date" name="anio_seguridad" class="w-full p-2 border rounded-lg"
                        value="{{ $format->seguridad_fecha ?? '' ? date('Y-m-d', strtotime($format->seguridad_fecha)) : '' }}">
                </div>
            </div>
        </div>
    </div>
</div>

    <h1>4. CONDICIÓN DE PATRIMONIO CULTURAL</h1>
    <div class="border-b border-gray-200 pb-4">
        <div class="space-y-4">
            <!-- Pregunta: Patrimonio Cultural -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    ¿LA IPRESS ES CONSIDERADA COMO PATRIMONIO CULTURAL?
                </label>
                <div class="flex gap-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="patrimonio_cultural" value="1"
                            class="form-radio text-blue-500"
                            {{ ($format->patrimonio_cultural ?? '') == 'SI' ? 'checked' : '' }}
                            onclick="document.getElementById('patrimonio_data').style.display = 'block'">
                        <span class="ml-2 text-sm text-gray-700">SI</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="patrimonio_cultural" value="0"
                            class="form-radio text-blue-500"
                            {{ ($format->patrimonio_cultural ?? '') == 'NO' ? 'checked' : '' }}
                            onclick="document.getElementById('patrimonio_data').style.display = 'none'">
                        <span class="ml-2 text-sm text-gray-700">NO</span>
                    </label>
                </div>
            </div>

            <!-- Datos de Patrimonio (visible solo si es SI) -->
            <div id="patrimonio_data"
                style="{{ ($format->patrimonio_cultural ?? '') == 'SI' ? 'display:block' : 'display:none' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            FECHA DE RECONOCIMIENTO COMO PATRIMONIO CULTURAL
                        </label>
                        <input type="date" name="fecha_patrimonio" class="w-full p-2 border rounded-lg"
                            value="{{ $format->fecha_emision ?? '' }}">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            NÚMERO DE RESOLUCIÓN
                        </label>
                        <input type="text" name="num_resolucion_patrimonio" class="w-full p-2 border rounded-lg"
                            value="{{ $format->numero_documento ?? '' }}" placeholder="Ej: 045-2024">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h1>5. DATOS DEL DIRECTOR O ADMINISTRADOR DE LA IPRESS</h1>
    <div class="border-b border-gray-200 pb-4">
        <h3 class="text-md font-semibold text-gray-700 mb-3">👨‍⚕️ DATOS DEL DIRECTOR O ADMINISTRADOR DE LA IPRESS</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-700">TIPO DE DOCUMENTO (*)</label>
                <select name="director_tipo_documento" class="w-full p-2 border rounded-lg">
                    <option value="">Seleccione</option>
                    @foreach ($tiposDocumento as $tipo)
                        <option value="{{ $tipo->id }}"
                            {{ ($format->tipo_documento_registrador ?? '') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">DOC. DE IDENTIDAD (*)</label>
                <input type="text" name="director_dni" class="w-full p-2 border rounded-lg"
                    value="{{ $format->doc_entidad_registrador ?? '' }}" placeholder="02413179">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">NOMBRES Y APELLIDOS (*)</label>
                <input type="text" name="director_nombres" class="w-full p-2 border rounded-lg"
                    value="{{ $format->nombre_registrador ?? '' }}" placeholder="ZORAIDA MATILDE PALZA VALDIVIA">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">PROFESIÓN (*)</label>
                <select name="director_profesion" class="w-full p-2 border rounded-lg">
                    <option value="">Seleccione</option>
                    @foreach ($profesiones as $prof)
                        <option value="{{ $prof->id }}"
                            {{ ($format->id_profesion_registrador ?? '') == $prof->id ? 'selected' : '' }}>
                            {{ $prof->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">CARGO O FUNCIÓN (*)</label>
                <input type="text" name="director_cargo" class="w-full p-2 border rounded-lg"
                    value="{{ $format->cargo_registrador ?? '' }}" placeholder="JEFE DE ESTABLECIMIENTO">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">CONDICIÓN LABORAL (*)</label>
                <select name="director_condicion_laboral" class="w-full p-2 border rounded-lg">
                    <option value="">Seleccione</option>
                    @foreach ($condiciones as $cond)
                        <option value="{{ $cond->id }}"
                            {{ ($format->id_condicion_profesional ?? '') == $cond->id ? 'selected' : '' }}>
                            {{ $cond->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">RÉGIMEN LABORAL (*)</label>
                <select name="director_regimen_laboral" class="w-full p-2 border rounded-lg">
                    <option value="">Seleccione</option>
                    @foreach ($regimenes as $reg)
                        <option value="{{ $reg->id }}"
                            {{ ($format->id_regimen_laboral ?? '') == $reg->id ? 'selected' : '' }}>
                            {{ $reg->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">CORREO ELECTRÓNICO (*)</label>
                <input type="email" name="director_email" class="w-full p-2 border rounded-lg"
                    value="{{ $format->email_registrador ?? '' }}" placeholder="mattipalza@hotmail.com">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">NÚMERO CELULAR (*)</label>
                <input type="tel" name="director_celular" class="w-full p-2 border rounded-lg"
                    value="{{ $format->movil_registrador ?? '' }}" placeholder="999999999">
            </div>
        </div>
    </div>
</div>
