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
    <!-- SECCIÓN 3: DATOS GENERALES DE LA INFRAESTRUCTURA -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-building"></i> 3. Datos Generales de la Infraestructura
            </h3>
        </div>
    <!-- SECCIÓN 3.1: ACABADOS EXTERIORES -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-paint-roller"></i> 3.1 Acabados Exteriores del establecimiento
            </h3>
            <p class="text-sm text-gray-500 mt-1">Material predominante y estado de conservación del establecimiento
            </p>
        </div>
        <div class="p-6">
            <!-- PISOS -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">PISOS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material Predominante</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pavimentos" value="PMP"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pavimentos ?? '') == 'PMP' ? 'checked' : '' }}>
                                <span>Parquet o madera pulida</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pavimentos" value="LAV"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pavimentos ?? '') == 'LAV' ? 'checked' : '' }}>
                                <span>Láminas asfálticas, vinílicos o similares</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pavimentos" value="LTC"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pavimentos ?? '') == 'LTC' ? 'checked' : '' }}>
                                <span>Loseta, terrazos, cerámicos o similares</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pavimentos" value="MAD"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pavimentos ?? '') == 'MAD' ? 'checked' : '' }}>
                                <span>Madera (pona, tornillo, etc)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pavimentos" value="CEM"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pavimentos ?? '') == 'CEM' ? 'checked' : '' }}>
                                <span>Cemento</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pavimentos" value="TIE"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pavimentos ?? '') == 'TIE' ? 'checked' : '' }}>
                                <span>Tierra</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pavimentos" value="OTR"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pavimentos ?? '') == 'OTR' ? 'checked' : '' }}>
                                <span>Otros</span>
                            </label>
                            <input type="text" name="ae_pavimentos_nombre"
                                value="{{ $infraestructura->ae_pavimentos_nombre ?? '' }}"
                                class="w-full mt-2 rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                placeholder="Especifique el material"
                                style="display: {{ ($infraestructura->ae_pavimentos ?? '') == 'OTR' ? 'block' : 'none' }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Conservación</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pav_estado" value="B"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pav_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span>Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pav_estado" value="R"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pav_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span>Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_pav_estado" value="M"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_pav_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span>Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VEREDAS -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">VEREDAS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material Predominante</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_veredas" value="LTC"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_veredas ?? '') == 'LTC' ? 'checked' : '' }}>
                                <span>Loseta, terrazos, cerámicos o similares</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_veredas" value="MAD"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_veredas ?? '') == 'MAD' ? 'checked' : '' }}>
                                <span>Madera (pona, tornillo, etc)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_veredas" value="CEM"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_veredas ?? '') == 'CEM' ? 'checked' : '' }}>
                                <span>Cemento</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_veredas" value="TIE"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_veredas ?? '') == 'TIE' ? 'checked' : '' }}>
                                <span>Tierra</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_veredas" value="OTR"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_veredas ?? '') == 'OTR' ? 'checked' : '' }}>
                                <span>Otros</span>
                            </label>
                            <input type="text" name="ae_veredas_nombre"
                                value="{{ $infraestructura->ae_veredas_nombre ?? '' }}"
                                class="w-full mt-2 rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                placeholder="Especifique el material"
                                style="display: {{ ($infraestructura->ae_veredas ?? '') == 'OTR' ? 'block' : 'none' }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Conservación</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_ver_estado" value="B"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_ver_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span>Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_ver_estado" value="R"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_ver_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span>Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_ver_estado" value="M"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_ver_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span>Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ZÓCALOS -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">ZÓCALOS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material Predominante</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_zocalos" value="LTC"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_zocalos ?? '') == 'LTC' ? 'checked' : '' }}>
                                <span>Loseta, terrazos, cerámicos o similares</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_zocalos" value="CEM"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_zocalos ?? '') == 'CEM' ? 'checked' : '' }}>
                                <span>Cemento</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_zocalos" value="OTR"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_zocalos ?? '') == 'OTR' ? 'checked' : '' }}>
                                <span>Otro</span>
                            </label>
                            <input type="text" name="ae_zocalos_nombre"
                                value="{{ $infraestructura->ae_zocalos_nombre ?? '' }}"
                                class="w-full mt-2 rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                placeholder="Especifique el material"
                                style="display: {{ ($infraestructura->ae_zocalos ?? '') == 'OTR' ? 'block' : 'none' }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Conservación</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_zoc_estado" value="B"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_zoc_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span>Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_zoc_estado" value="R"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_zoc_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span>Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_zoc_estado" value="M"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_zoc_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span>Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MUROS -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">MUROS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material Predominante</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_muros" value="LBC"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_muros ?? '') == 'LBC' ? 'checked' : '' }}>
                                <span>Ladrillo o bloque de cemento</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_muros" value="PSC"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_muros ?? '') == 'PSC' ? 'checked' : '' }}>
                                <span>Piedra o Sillar con cal o cemento</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_muros" value="ADO"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_muros ?? '') == 'ADO' ? 'checked' : '' }}>
                                <span>Adobe</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_muros" value="TAP"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_muros ?? '') == 'TAP' ? 'checked' : '' }}>
                                <span>Tapia</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_muros" value="MAD"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_muros ?? '') == 'MAD' ? 'checked' : '' }}>
                                <span>Madera</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_muros" value="OTR"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_muros ?? '') == 'OTR' ? 'checked' : '' }}>
                                <span>Otros</span>
                            </label>
                            <input type="text" name="ae_muros_nombre"
                                value="{{ $infraestructura->ae_muros_nombre ?? '' }}"
                                class="w-full mt-2 rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                placeholder="Especifique el material"
                                style="display: {{ ($infraestructura->ae_muros ?? '') == 'OTR' ? 'block' : 'none' }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Conservación</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_mur_estado" value="B"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_mur_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span>Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_mur_estado" value="R"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_mur_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span>Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_mur_estado" value="M"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_mur_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span>Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TECHO -->
            <div class="mb-4">
                <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">TECHO</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material Predominante</label>
                        <div class="space-y-2">
                            <!-- TECHO -->
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_techo" value="CA" data-nombre="Concreto armado"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_techo ?? '') == 'CA' ? 'checked' : '' }}>
                                <span>Concreto armado</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_techo" value="MAD" data-nombre="Madera"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_techo ?? '') == 'MAD' ? 'checked' : '' }}>
                                <span>Madera</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_techo" value="TEJ" data-nombre="Tejas"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_techo ?? '') == 'TEJ' ? 'checked' : '' }}>
                                <span>Tejas</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_techo" value="PCF"
                                    data-nombre="Planchas de calamina, fibra de cemento o similares"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_techo ?? '') == 'PCF' ? 'checked' : '' }}>
                                <span>Planchas de calamina, fibra de cemento o similares</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_techo" value="CEB"
                                    data-nombre="Caña o estera con torta de barro o cemento"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_techo ?? '') == 'CEB' ? 'checked' : '' }}>
                                <span>Caña o estera con torta de barro o cemento</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_techo" value="TEC"
                                    data-nombre="Triplay/estera/carrizo" class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_techo ?? '') == 'TEC' ? 'checked' : '' }}>
                                <span>Triplay/estera/carrizo</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_techo" value="OTR"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_techo ?? '') == 'OTR' ? 'checked' : '' }}>
                                <span>Otros</span>
                            </label>
                            <input type="text" name="ae_techo_nombre"
                                value="{{ $infraestructura->ae_techo_nombre ?? '' }}"
                                class="w-full mt-2 rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                placeholder="Especifique el material"
                                style="display: {{ ($infraestructura->ae_techo ?? '') == 'OTR' ? 'block' : 'none' }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Conservación</label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_tec_estado" value="B"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_tec_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span>Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_tec_estado" value="R"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_tec_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span>Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="ae_tec_estado" value="M"
                                    class="rounded-full text-teal-600"
                                    {{ ($infraestructura->ae_tec_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span>Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 3.2: SOBRE LA EDIFICACIÓN -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-building"></i> 3.2 Sobre la Edificación
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
                                <tr id="fila-{{ $edif->id }}">
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
                            <tr id="no-registros">
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
        document.getElementById('edificacion_id').value = '';
        if (modal) modal.classList.remove('hidden');
    }

    function closeEdificacionModal() {
        const modal = document.getElementById('edificacionModal');
        if (modal) modal.classList.add('hidden');
    }

    function updateTableRow(data, isNew = true) {
        const upssNombre = data.upss?.nombre || data.servicio || '-';
        const tipoNombre = data.tipo_intervencion?.nombre || data.tipo_intervencion || '-';

        const rowHtml = `
            <td class="px-4 py-2 text-sm">${data.bloque || '-'}</td>
            <td class="px-4 py-2 text-sm">${data.pabellon || '-'}</td>
            <td class="px-4 py-2 text-sm">${upssNombre}</td>
            <td class="px-4 py-2 text-sm text-center">${data.nropisos || '-'}</td>
            <td class="px-4 py-2 text-sm text-center">${data.antiguedad || '-'}</td>
            <td class="px-4 py-2 text-sm">${data.ultima_intervencion || '-'}</td>
            <td class="px-4 py-2 text-sm">${tipoNombre}</td>
            <td class="px-4 py-2 text-center">
                <button type="button" onclick="editEdificacion(${data.id})" class="text-blue-600 hover:text-blue-800 mr-2" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" onclick="deleteEdificacion(${data.id})" class="text-red-600 hover:text-red-800" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        const row = document.getElementById(`fila-${data.id}`);
        if (row && !isNew) {
            row.innerHTML = rowHtml;
        } else {
            const noRegistros = document.getElementById('no-registros');
            if (noRegistros) noRegistros.remove();
            const tbody = document.getElementById('tabla-edificaciones');
            const newRow = document.createElement('tr');
            newRow.id = `fila-${data.id}`;
            newRow.innerHTML = rowHtml;
            tbody.appendChild(newRow);
        }
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
        const originalText = btn?.innerHTML;
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
                if (id) {
                    updateTableRow(result.data, false);
                } else {
                    updateTableRow(result.data, true);
                }
                closeEdificacionModal();
                if (window.toast && window.toast.success) {
                    window.toast.success(result.message);
                } else {
                    alert(result.message);
                }
            } else {
                alert('Error: ' + result.message);
            }
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar: ' + error.message);
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    }

    async function editEdificacion(id) {
        try {
            const response = await fetch(`/infraestructura/edificaciones/get/${id}`);
            if (!response.ok) throw new Error('Error al cargar');
            const data = await response.json();

            document.getElementById('modalTitle').innerText = 'Editar Edificación';
            document.getElementById('edificacion_id').value = data.id;
            document.getElementById('bloque').value = data.bloque || '';
            document.getElementById('pabellon').value = data.pabellon || '';
            document.getElementById('servicio').value = data.servicio || '';
            document.getElementById('nropisos').value = data.nropisos || '';
            document.getElementById('antiguedad').value = data.antiguedad || '';
            document.getElementById('ultima_intervencion').value = data.ultima_intervencion || '';
            const tipoId = data.tipo_intervencion?.id || data.tipo_intervencion;
            document.getElementById('tipo_intervencion').value = tipoId || '';
            document.getElementById('observacion').value = data.observacion || '';
            document.getElementById('edificacionModal').classList.remove('hidden');
        } catch (error) {
            console.error('Error:', error);
            alert('Error al cargar los datos');
        }
    }

    function deleteEdificacion(id) {
        if (confirm('¿Está seguro de eliminar esta edificación?')) {
            const btn = event?.target;
            const originalText = btn?.innerHTML;
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }
            fetch(`/infraestructura/edificaciones/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || ''
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const row = document.getElementById(`fila-${id}`);
                    if (row) row.remove();
                    const tbody = document.getElementById('tabla-edificaciones');
                    if (tbody.children.length === 0) {
                        tbody.innerHTML = `<tr id="no-registros"><td colspan="8" class="px-4 py-4 text-center text-gray-500">No hay edificaciones registradas</td></tr>`;
                    }
                    if (window.toast && window.toast.success) {
                        window.toast.success(result.message);
                    } else {
                        alert(result.message);
                    }
                } else {
                    alert('Error: ' + result.message);
                }
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        }
    }
  // ============================================
// ACABADOS EXTERIORES - FUNCIÓN DEFINITIVA
// ============================================
function initAcabadosExteriores() {
    const grupos = ['ae_pavimentos', 'ae_veredas', 'ae_zocalos', 'ae_muros', 'ae_techo'];
    
    const nombres = {
        'PMP': 'Parquet o madera pulida',
        'LAV': 'Láminas asfálticas, vinílicos o similares',
        'LTC': 'Loseta, terrazos, cerámicos o similares',
        'MAD': 'Madera',
        'CEM': 'Cemento',
        'TIE': 'Tierra',
        'LBC': 'Ladrillo o bloque de cemento',
        'PSC': 'Piedra o Sillar con cal o cemento',
        'ADO': 'Adobe',
        'TAP': 'Tapia',
        'CA': 'Concreto armado',
        'TEJ': 'Tejas',
        'PCF': 'Planchas de calamina, fibra de cemento o similares',
        'CEB': 'Caña o estera con torta de barro o cemento',
        'TEC': 'Triplay/estera/carrizo'
    };

    grupos.forEach(grupo => {
        const radios = document.querySelectorAll(`input[name="${grupo}"]`);
        const inputNombre = document.querySelector(`input[name="${grupo}_nombre"]`);
        
        radios.forEach(radio => {
            radio.onclick = function() {
                if (this.value === 'OTR') {
                    inputNombre.style.display = 'block';
                    inputNombre.value = '';
                    inputNombre.focus();
                } else {
                    inputNombre.style.display = 'none';
                    inputNombre.value = nombres[this.value] || '';
                }
            };
        });
        
        // Solo mostrar/ocultar al cargar, sin cambiar valor
        const checked = document.querySelector(`input[name="${grupo}"]:checked`);
        if (checked && checked.value === 'OTR') {
            inputNombre.style.display = 'block';
        } else {
            inputNombre.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', initAcabadosExteriores);
</script>