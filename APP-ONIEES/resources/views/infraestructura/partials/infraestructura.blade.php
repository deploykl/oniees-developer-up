

    <!-- ============================================ -->
    <!-- SECCIÓN 1: ESTADO DEL SANEAMIENTO FÍSICO LEGAL -->
    <!-- ============================================ -->

    <div id="sec-saneamiento" class="form-section" x-data="sectionCounter('sec-saneamiento', 13)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-file-signature"></i> 1. Estado del Saneamiento Físico Legal
                    <span class="section-badge">Documentación</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Información legal y documentaria del terreno</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span
                            x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
                <!-- TODO EL CONTENIDO ORIGINAL SIN MODIFICAR NADA -->
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
    <div id="sec-planos-fisico" class="form-section" x-data="sectionCounter('sec-planos-fisico', 9)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-drafting-compass"></i> 2. Disponibilidad de Planos Técnicos (FÍSICO)
                    <span class="section-badge">Documentos físicos</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Registre si el establecimiento cuenta con planos físicos</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span
                        class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
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
    <div id="sec-planos-digital" class="form-section" x-data="sectionCounter('sec-planos-digital', 9)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-laptop-code"></i> 2.1 Disponibilidad de Planos Técnicos (DIGITAL)
                    <span class="section-badge">Documentos digitales</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Registre si el establecimiento cuenta con planos digitales</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span
                        class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
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
        <!-- ============================================ -->
        <!-- SECCIÓN 3.1: ACABADOS EXTERIORES -->
        <!-- ============================================ -->
        <div id="sec-acabados-exteriores" class="form-section" x-data="sectionCounter('sec-acabados-exteriores', 10)" x-init="init()">
            <div class="section-header" @click="toggle()">
                <div class="section-header-left">
                    <h2 class="section-title">
                        <i class="fas fa-paint-roller"></i> 3.1 Acabados Exteriores del establecimiento
                        <span class="section-badge">Materiales y estado</span>
                        <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </h2>
                    <p class="section-subtitle">Material predominante y estado de conservación del establecimiento</p>
                </div>
                <div class="progress-counter" @click.stop>
                    <div class="counter-number"><span class="completed" x-text="filled"></span><span
                            class="total">/<span x-text="total"></span></span></div>
                    <div class="counter-bar">
                        <div class="counter-bar-fill"
                            :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                            :style="{ width: percent + '%' }"></div>
                    </div>
                    <div class="counter-percent"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        x-text="percent + '%'"></div>
                </div>
            </div>
            <div class="section-content" :class="open ? '' : 'hidden'">
                <div class="p-6">
                    <!-- PISOS -->
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">PISOS</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Material
                                    Predominante</label>
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de
                                    Conservación</label>
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
                        <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">VEREDAS
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Material
                                    Predominante</label>
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de
                                    Conservación</label>
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
                        <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">ZÓCALOS
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Material
                                    Predominante</label>
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de
                                    Conservación</label>
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Material
                                    Predominante</label>
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de
                                    Conservación</label>
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Material
                                    Predominante</label>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="ae_techo" value="CA"
                                            data-nombre="Concreto armado" class="rounded-full text-teal-600"
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de
                                    Conservación</label>
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
        <!-- SECCIÓN 3.2: SOBRE LA EDIFICACIÓN Y ACABADOS INTERIORES -->
        <!-- ============================================ -->
        <div id="sec-edificaciones" class="form-section" x-data="sectionCounter('sec-edificaciones', 1)" x-init="init()">
            <div class="section-header" @click="toggle()">
                <div class="section-header-left">
                    <h2 class="section-title">
                        <i class="fas fa-building"></i> 3.2 Sobre la Edificación y Acabados Interiores
                        <span class="section-badge">Edificaciones</span>
                        <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </h2>
                    <p class="section-subtitle">Registre los datos de las edificaciones y sus acabados interiores</p>
                </div>
                <div class="progress-counter" @click.stop>
                    <div class="counter-number"><span class="completed" x-text="filled"></span><span
                            class="total">/<span x-text="total"></span></span></div>
                    <div class="counter-bar">
                        <div class="counter-bar-fill"
                            :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                            :style="{ width: percent + '%' }"></div>
                    </div>
                    <div class="counter-percent"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        x-text="percent + '%'"></div>
                </div>
            </div>
            <div class="section-content" :class="open ? '' : 'hidden'">
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bloque
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Pabellón</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        UPSS/UPS</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">N°
                                        Pisos</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Antigüedad</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Últ.
                                        Intervención</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Acabados</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                        Acciones</th>
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
                                            <td class="px-4 py-2 text-sm text-center">{{ $edif->nropisos ?? '-' }}
                                            </td>
                                            <td class="px-4 py-2 text-sm text-center">{{ $edif->antiguedad ?? '-' }}
                                            </td>
                                            <td class="px-4 py-2 text-sm">{{ $edif->ultima_intervencion ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                {{ $edif->tipoIntervencion->nombre ?? ($edif->tipo_intervencion ?? '-') }}
                                            </td>
                                            <td class="px-4 py-2 text-sm">
                                                <button type="button"
                                                    onclick="openAcabadosModal({{ $edif->id }})"
                                                    class="text-teal-600 hover:text-teal-800"
                                                    title="Acabados Interiores">
                                                    <i class="fas fa-paint-roller"></i> Ver Acabados
                                                </button>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button" onclick="editEdificacion({{ $edif->id }})"
                                                    class="text-blue-600 hover:text-blue-800 mr-2" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button"
                                                    onclick="deleteEdificacion({{ $edif->id }})"
                                                    class="text-red-600 hover:text-red-800" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="no-registros">
                                        <td colspan="9" class="px-4 py-4 text-center text-gray-500">No hay
                                            edificaciones registradas</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <!-- ============================================ -->
        <!-- SECCIÓN 3.3: ANÁLISIS DE LA INFRAESTRUCTURA -->
        <!-- ============================================ -->
        <div id="sec-analisis-infra" class="form-section" x-data="sectionCounter('sec-analisis-infra', 14)" x-init="init()">
            <div class="section-header" @click="toggle()">
                <div class="section-header-left">
                    <h2 class="section-title">
                        <i class="fas fa-chart-line"></i> 3.3 Análisis de la Infraestructura
                        <span class="section-badge">Evaluación técnica</span>
                        <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </h2>
                    <p class="section-subtitle">Evaluación técnica del estado de la infraestructura</p>
                </div>
                <div class="progress-counter" @click.stop>
                    <div class="counter-number"><span class="completed" x-text="filled"></span><span
                            class="total">/<span x-text="total"></span></span></div>
                    <div class="counter-bar">
                        <div class="counter-bar-fill"
                            :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                            :style="{ width: percent + '%' }"></div>
                    </div>
                    <div class="counter-percent"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        x-text="percent + '%'"></div>
                </div>
            </div>
            <div class="section-content" :class="open ? '' : 'hidden'">
                <div class="p-6 space-y-8">

                    <!-- ============================================ -->
                    <!-- 3.3.1 DATOS DEL EDIFICIO Y/O PABELLONES Y/O UPSS -->
                    <!-- ============================================ -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">3.3.1
                            Datos del Edificio y/o Pabellones y/o UPSS a ser evaluados</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número de Sótanos</label>
                                <input type="number" name="sonatos" min="0"
                                    value="{{ $infraestructura->sonatos ?? '' }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número de Pisos
                                    Superiores</label>
                                <input type="number" name="pisos" min="0"
                                    value="{{ $infraestructura->pisos ?? '' }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Área Aproximada
                                    (m²)</label>
                                <input type="number" step="0.01" name="area"
                                    value="{{ $infraestructura->area ?? '' }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    placeholder="0.00">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación del
                                    EE.SS.</label>
                                <div class="flex gap-6">
                                    <label class="flex items-center gap-2"><input type="radio" name="ubicacion"
                                            value="1"
                                            {{ ($infraestructura->ubicacion ?? '') == '1' ? 'checked' : '' }}><span>Plano</span></label>
                                    <label class="flex items-center gap-2"><input type="radio" name="ubicacion"
                                            value="2"
                                            {{ ($infraestructura->ubicacion ?? '') == '2' ? 'checked' : '' }}><span>Pendiente</span></label>
                                </div>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Material de la
                                    Edificación</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <label class="flex items-center gap-2"><input type="radio" name="material"
                                            value="1"
                                            {{ ($infraestructura->material ?? '') == '1' ? 'checked' : '' }}>
                                        Ladrillo</label>
                                    <label class="flex items-center gap-2"><input type="radio" name="material"
                                            value="2"
                                            {{ ($infraestructura->material ?? '') == '2' ? 'checked' : '' }}>
                                        Madera</label>
                                    <label class="flex items-center gap-2"><input type="radio" name="material"
                                            value="3"
                                            {{ ($infraestructura->material ?? '') == '3' ? 'checked' : '' }}>
                                        Metal</label>
                                    <label class="flex items-center gap-2"><input type="radio" name="material"
                                            value="4"
                                            {{ ($infraestructura->material ?? '') == '4' ? 'checked' : '' }}>
                                        Drywall</label>
                                    <label class="flex items-center gap-2"><input type="radio" name="material"
                                            value="5"
                                            {{ ($infraestructura->material ?? '') == '5' ? 'checked' : '' }}>
                                        Adobe</label>
                                    <label class="flex items-center gap-2"><input type="radio" name="material"
                                            value="6"
                                            {{ ($infraestructura->material ?? '') == '6' ? 'checked' : '' }}>
                                        Caña</label>
                                    <label class="flex items-center gap-2 col-span-2"><input type="radio"
                                            name="material" value="7"
                                            {{ ($infraestructura->material ?? '') == '7' ? 'checked' : '' }}> Otro
                                        material</label>
                                </div>
                                <input type="text" name="material_nombre"
                                    value="{{ $infraestructura->material_nombre ?? '' }}"
                                    class="w-full mt-2 rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    placeholder="Especifique el material"
                                    style="display: {{ ($infraestructura->material ?? '') == '7' ? 'block' : 'none' }}">
                            </div>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- 3.3.2 EVALUACIÓN DEL ESTADO DE LA INFRAESTRUCTURA -->
                    <!-- ============================================ -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">3.3.2
                            Evaluación del Estado de la Infraestructura</h4>

                        <!-- A. Daños por Inundación -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">A. Daños a la infraestructura por Inundación
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_a" value="1"
                                            {{ ($infraestructura->infraestructura_option_a ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_a" value="0"
                                            {{ ($infraestructura->infraestructura_option_a ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_a" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_a ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_a"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '1' ? 'selected' : '' }}>
                                            1. Piso mojado</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '2' ? 'selected' : '' }}>
                                            2. Pared mojado</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '3' ? 'selected' : '' }}>
                                            3. Techo y cielo raso mojado</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '4' ? 'selected' : '' }}>
                                            4. Desprendimiento de cerámico de piso</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '5' ? 'selected' : '' }}>
                                            5. Erosión de piso de cemento</option>
                                        <option value="6"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '6' ? 'selected' : '' }}>
                                            6. Desprendimiento de piso de cerámico</option>
                                        <option value="7"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '7' ? 'selected' : '' }}>
                                            7. Desprendimiento de tarrajeo</option>
                                        <option value="8"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '8' ? 'selected' : '' }}>
                                            8. Fallas de asentado de ladrillo</option>
                                        <option value="9"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '9' ? 'selected' : '' }}>
                                            9. Afectación de sobrecimiento</option>
                                        <option value="10"
                                            {{ ($infraestructura->infraestructura_valor_a ?? '') == '10' ? 'selected' : '' }}>
                                            10. Zocavones y falla de cimentación</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- B. Daños por Movimiento en masa -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">B. Daños a la infraestructura (Movimiento en
                                masa, deslizamiento, Huayco, etc)</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_b" value="1"
                                            {{ ($infraestructura->infraestructura_option_b ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_b" value="0"
                                            {{ ($infraestructura->infraestructura_option_b ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_b" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_b ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_b"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '1' ? 'selected' : '' }}>
                                            1. Ingreso de agua al EE.SS.</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '2' ? 'selected' : '' }}>
                                            2. Ingreso de lodo al EE.SS.</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '3' ? 'selected' : '' }}>
                                            3. Ingreso de lodo y piedra al EE.SS.</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '4' ? 'selected' : '' }}>
                                            4. Cerco perimetrico fisurado</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '5' ? 'selected' : '' }}>
                                            5. Cerco perimétrico en diagonal</option>
                                        <option value="6"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '6' ? 'selected' : '' }}>
                                            6. Derrumbe parcial de Cerco perimétrico</option>
                                        <option value="7"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '7' ? 'selected' : '' }}>
                                            7. Derrumbe total de Cerco perimétrico</option>
                                        <option value="8"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '8' ? 'selected' : '' }}>
                                            8. Ingreso de agua a la edificación (UPSS)</option>
                                        <option value="9"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '9' ? 'selected' : '' }}>
                                            9. Ingreso de lodo a la edificación (UPSS)</option>
                                        <option value="10"
                                            {{ ($infraestructura->infraestructura_valor_b ?? '') == '10' ? 'selected' : '' }}>
                                            10. Ingreso de lodo y piedras a la edificación (UPSS)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- C. Daños a elementos estructurales - Vigas -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">C. Daños a elementos estructurales - Vigas
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_c" value="1"
                                            {{ ($infraestructura->infraestructura_option_c ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_c" value="0"
                                            {{ ($infraestructura->infraestructura_option_c ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_c" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_c ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_c"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '1' ? 'selected' : '' }}>
                                            1. Viga mojada</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '2' ? 'selected' : '' }}>
                                            2. Pintura deteriorada</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '3' ? 'selected' : '' }}>
                                            3. Tarrajeo carcomido</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '4' ? 'selected' : '' }}>
                                            4. Tarrajeo fisurado</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '5' ? 'selected' : '' }}>
                                            5. Fisura del concreto</option>
                                        <option value="6"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '6' ? 'selected' : '' }}>
                                            6. Cortes por mala distribución de estribos</option>
                                        <option value="7"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '7' ? 'selected' : '' }}>
                                            7. Desgaste de viga, por lluvia acida</option>
                                        <option value="8"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '8' ? 'selected' : '' }}>
                                            8. Exposición del fierro</option>
                                        <option value="9"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '9' ? 'selected' : '' }}>
                                            9. Deformación de viga</option>
                                        <option value="10"
                                            {{ ($infraestructura->infraestructura_valor_c ?? '') == '10' ? 'selected' : '' }}>
                                            10. Rotura de viga</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- D. Daños a elementos estructurales - Columnas -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">D. Daños a elementos estructurales - Columnas
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_d" value="1"
                                            {{ ($infraestructura->infraestructura_option_d ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_d" value="0"
                                            {{ ($infraestructura->infraestructura_option_d ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_d" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_d ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_d"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '1' ? 'selected' : '' }}>
                                            1. Columna mojada</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '2' ? 'selected' : '' }}>
                                            2. Pintura deteriorada</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '3' ? 'selected' : '' }}>
                                            3. Tarrajeo carcomido</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '4' ? 'selected' : '' }}>
                                            4. Tarrajeo fisurado</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '5' ? 'selected' : '' }}>
                                            5. Fisura del concreto</option>
                                        <option value="6"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '6' ? 'selected' : '' }}>
                                            6. Cortes por mala distribución de estribos</option>
                                        <option value="7"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '7' ? 'selected' : '' }}>
                                            7. Desgaste de columna, por lluvia acida</option>
                                        <option value="8"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '8' ? 'selected' : '' }}>
                                            8. Exposición del fierro</option>
                                        <option value="9"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '9' ? 'selected' : '' }}>
                                            9. Deformación de viga</option>
                                        <option value="10"
                                            {{ ($infraestructura->infraestructura_valor_d ?? '') == '10' ? 'selected' : '' }}>
                                            10. Rotura de columna</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- E. Techos -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">E. Techos (aligerado, cobertura liviana u
                                otros)</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_e" value="1"
                                            {{ ($infraestructura->infraestructura_option_e ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_e" value="0"
                                            {{ ($infraestructura->infraestructura_option_e ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_e" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_e ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_e"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '1' ? 'selected' : '' }}>
                                            1. Techo mojado</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '2' ? 'selected' : '' }}>
                                            2. Filtración de agua</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '3' ? 'selected' : '' }}>
                                            3. Paño de cobertura dañada</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '4' ? 'selected' : '' }}>
                                            4. Paño de cobertura rota</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '5' ? 'selected' : '' }}>
                                            5. Pintura dañada de cielo raso</option>
                                        <option value="6"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '6' ? 'selected' : '' }}>
                                            6. Desprendimiento de tarrajeo de losa</option>
                                        <option value="7"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '7' ? 'selected' : '' }}>
                                            7. Filtración de losa aligerada</option>
                                        <option value="8"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '8' ? 'selected' : '' }}>
                                            8. Fisura en losa aligerada</option>
                                        <option value="9"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '9' ? 'selected' : '' }}>
                                            9. Estructura de madera y/o metal roto</option>
                                        <option value="10"
                                            {{ ($infraestructura->infraestructura_valor_e ?? '') == '10' ? 'selected' : '' }}>
                                            10. Estructura de madera y/o metal caido</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- F. Muros -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">F. Muros</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_f" value="1"
                                            {{ ($infraestructura->infraestructura_option_f ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_f" value="0"
                                            {{ ($infraestructura->infraestructura_option_f ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_f" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_f ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_f"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '1' ? 'selected' : '' }}>
                                            1. Muro mojado</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '2' ? 'selected' : '' }}>
                                            2. Pintura deteriorada</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '3' ? 'selected' : '' }}>
                                            3. Revestimiento deteriorado</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '4' ? 'selected' : '' }}>
                                            4. Tarrajeo fisurado</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '5' ? 'selected' : '' }}>
                                            5. Desprendimiento de zócalo</option>
                                        <option value="6"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '6' ? 'selected' : '' }}>
                                            6. Desprendimiento de panel</option>
                                        <option value="7"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '7' ? 'selected' : '' }}>
                                            7. Exposición de ladrillo</option>
                                        <option value="8"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '8' ? 'selected' : '' }}>
                                            8. Estructura de muro deteriorado</option>
                                        <option value="9"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '9' ? 'selected' : '' }}>
                                            9. Afectación de sobrecimiento</option>
                                        <option value="10"
                                            {{ ($infraestructura->infraestructura_valor_f ?? '') == '10' ? 'selected' : '' }}>
                                            10. Derrumbe de muro</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- G. Pisos -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">G. Pisos</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_g" value="1"
                                            {{ ($infraestructura->infraestructura_option_g ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_g" value="0"
                                            {{ ($infraestructura->infraestructura_option_g ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_g" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_g ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_g"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_g ?? '') == '1' ? 'selected' : '' }}>
                                            1. Piso y vereda mojado</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_g ?? '') == '2' ? 'selected' : '' }}>
                                            2. Desprendimiento de cerámico de piso</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_g ?? '') == '3' ? 'selected' : '' }}>
                                            3. Erosión de piso de cemento</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_g ?? '') == '4' ? 'selected' : '' }}>
                                            4. Desprendimiento de contrapiso</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_g ?? '') == '5' ? 'selected' : '' }}>
                                            5. Rotura de piso</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- H. Sistema de drenaje pluvial -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">H. Sistema de drenaje pluvial (Canaletas de
                                techo, montantes de bajas, etc)</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_h" value="1"
                                            {{ ($infraestructura->infraestructura_option_h ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_h" value="0"
                                            {{ ($infraestructura->infraestructura_option_h ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_h" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_h ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_h"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '1' ? 'selected' : '' }}>
                                            1. Filtración de canaleta de techo</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '2' ? 'selected' : '' }}>
                                            2. Rotura de canaleta de techo</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '3' ? 'selected' : '' }}>
                                            3. Desprendimiento de canaleta</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '4' ? 'selected' : '' }}>
                                            4. Montantes rotas</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '5' ? 'selected' : '' }}>
                                            5. Canaletas de piso rotas y saturadas</option>
                                        <option value="6"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '6' ? 'selected' : '' }}>
                                            6. Rejilla de canaleta de piso rotas</option>
                                        <option value="7"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '7' ? 'selected' : '' }}>
                                            7. Colapsado de montante</option>
                                        <option value="8"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '8' ? 'selected' : '' }}>
                                            8. Colapsado total de canaletas de techo</option>
                                        <option value="9"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '9' ? 'selected' : '' }}>
                                            9. Colapsado total de canaletas de piso</option>
                                        <option value="10"
                                            {{ ($infraestructura->infraestructura_valor_h ?? '') == '10' ? 'selected' : '' }}>
                                            10. Sistema colapsado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- I. Puertas y ventanas -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">I. Puertas y ventanas</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_i" value="1"
                                            {{ ($infraestructura->infraestructura_option_i ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_i" value="0"
                                            {{ ($infraestructura->infraestructura_option_i ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_i" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_i ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_i"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_i ?? '') == '1' ? 'selected' : '' }}>
                                            1. Puerta y ventana de madera mojada</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_i ?? '') == '2' ? 'selected' : '' }}>
                                            2. Puerta y ventana de metal oxidada</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_i ?? '') == '3' ? 'selected' : '' }}>
                                            3. Ceraduras y accesorios en mal estado</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_i ?? '') == '4' ? 'selected' : '' }}>
                                            4. Desprendimiento de marco de puerta</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_i ?? '') == '5' ? 'selected' : '' }}>
                                            5. Desprendimiento de puerta</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- J. Equipos -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">J. Equipos</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_j" value="1"
                                            {{ ($infraestructura->infraestructura_option_j ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_j" value="0"
                                            {{ ($infraestructura->infraestructura_option_j ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_j" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_j ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_j"
                                        class="w-full rounded-lg border-gray-300 text-sm"
                                        style="{{ ($infraestructura->infraestructura_option_j ?? 0) == 1 ? 'display: block;' : 'display: none;' }}">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_j ?? '') == '1' ? 'selected' : '' }}>
                                            1. OPERATIVO</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_j ?? '') == '2' ? 'selected' : '' }}>
                                            2. INOPERATIVO</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- K. Red de agua -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">K. Red de agua</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_k" value="1"
                                            {{ ($infraestructura->infraestructura_option_k ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_k" value="0"
                                            {{ ($infraestructura->infraestructura_option_k ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_k" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_k ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_k"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_k ?? '') == '1' ? 'selected' : '' }}>
                                            1. Inundación de cisterna y otros</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_k ?? '') == '2' ? 'selected' : '' }}>
                                            2. Daño de cajas, valvulas, ubicadas en superficie, lodo</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_k ?? '') == '3' ? 'selected' : '' }}>
                                            3. Exposición de tuberías</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_k ?? '') == '4' ? 'selected' : '' }}>
                                            4. Rajadura de tuberías, fuga de desague</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_k ?? '') == '5' ? 'selected' : '' }}>
                                            5. Desaparece tubería por fuerza de lodo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- L. Red de desagüe -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">L. Red de desagüe</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_l" value="1"
                                            {{ ($infraestructura->infraestructura_option_l ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_l" value="0"
                                            {{ ($infraestructura->infraestructura_option_l ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_l" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_l ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_l"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_l ?? '') == '1' ? 'selected' : '' }}>
                                            1. Inundación de cajas y buzones</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_l ?? '') == '2' ? 'selected' : '' }}>
                                            2. Daño de cajas, valvulas, ubicadas en superficie, lodo</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_l ?? '') == '3' ? 'selected' : '' }}>
                                            3. Exposición de tuberías</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_l ?? '') == '4' ? 'selected' : '' }}>
                                            4. Rajadura de tuberías, fuga de desague</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_l ?? '') == '5' ? 'selected' : '' }}>
                                            5. Desaparece tubería por fuerza de lodo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- M. Red de agua contra incendio -->
                        <div class="mb-6 pb-4 border-b">
                            <h5 class="font-semibold text-gray-700 mb-3">M. Red de agua contra incendio</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_m" value="1"
                                            {{ ($infraestructura->infraestructura_option_m ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_m" value="0"
                                            {{ ($infraestructura->infraestructura_option_m ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_m" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_m ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_m"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_m ?? '') == '1' ? 'selected' : '' }}>
                                            1. Daño de cajas, valvulas, ubicadas en superficie, lodo</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_m ?? '') == '2' ? 'selected' : '' }}>
                                            2. Exposición de tuberías</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_m ?? '') == '3' ? 'selected' : '' }}>
                                            3. Rajadura de tuberías, fuga de desague</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_m ?? '') == '4' ? 'selected' : '' }}>
                                            4. Desaparece tubería por fuerza de lodo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- N. Instalaciones eléctricas -->
                        <div class="mb-6 pb-4">
                            <h5 class="font-semibold text-gray-700 mb-3">N. Instalaciones eléctricas</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex gap-4 items-center">
                                    <span class="text-sm text-gray-600 w-32">¿Presenta daños?</span>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_n" value="1"
                                            {{ ($infraestructura->infraestructura_option_n ?? 0) == 1 ? 'checked' : '' }}>
                                        SI</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="infraestructura_option_n" value="0"
                                            {{ ($infraestructura->infraestructura_option_n ?? 0) == 0 ? 'checked' : '' }}>
                                        NO</label>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Descripción del daño:</label>
                                    <textarea name="infraestructura_descripcion_n" rows="2" class="w-full rounded-lg border-gray-300 text-sm"
                                        style="display: none;" placeholder="Describa los daños...">{{ $infraestructura->infraestructura_descripcion_n ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Valoración:</label>
                                    <select name="infraestructura_valor_n"
                                        class="w-full rounded-lg border-gray-300 text-sm" style="display: none;">
                                        <option value="">Seleccione</option>
                                        <option value="1"
                                            {{ ($infraestructura->infraestructura_valor_n ?? '') == '1' ? 'selected' : '' }}>
                                            1. Luminarias y tomacorrientes mojados</option>
                                        <option value="2"
                                            {{ ($infraestructura->infraestructura_valor_n ?? '') == '2' ? 'selected' : '' }}>
                                            2. Cableado expuesto</option>
                                        <option value="3"
                                            {{ ($infraestructura->infraestructura_valor_n ?? '') == '3' ? 'selected' : '' }}>
                                            3. Tableros mojados</option>
                                        <option value="4"
                                            {{ ($infraestructura->infraestructura_valor_n ?? '') == '4' ? 'selected' : '' }}>
                                            4. Daño a ductos subterraneos</option>
                                        <option value="5"
                                            {{ ($infraestructura->infraestructura_valor_n ?? '') == '5' ? 'selected' : '' }}>
                                            5. Perdida total de energía</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Campo para otros daños -->
                        <div class="mt-4 pt-4 border-t">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Indicar otro tipo de
                                daño:</label>
                            <textarea name="infraestructura_descripcion_1" rows="2" class="w-full rounded-lg border-gray-300"
                                placeholder="Describa otros daños no contemplados...">{{ $infraestructura->infraestructura_descripcion_1 ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- 3.3.3 ESTADO DEL ENTORNO / CERRAMIENTO PERIMETRAL -->
                    <!-- ============================================ -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-teal-600 pl-3">3.3.3
                            Estado del Entorno / Cerramiento Perimetral</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de muro de
                                    contención</label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="estado_contencion" value="1"
                                            {{ ($infraestructura->estado_contencion ?? '') == 1 ? 'checked' : '' }}>
                                        Bueno</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="estado_contencion" value="2"
                                            {{ ($infraestructura->estado_contencion ?? '') == 2 ? 'checked' : '' }}>
                                        Regular</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="estado_contencion" value="3"
                                            {{ ($infraestructura->estado_contencion ?? '') == 3 ? 'checked' : '' }}>
                                        Malo</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="estado_contencion" value="0"
                                            {{ ($infraestructura->estado_contencion ?? '') == 0 ? 'checked' : '' }}>
                                        No cuenta</label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Taludes</label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="estado_taludes" value="1"
                                            {{ ($infraestructura->estado_taludes ?? '') == 1 ? 'checked' : '' }}>
                                        Bueno</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="estado_taludes" value="2"
                                            {{ ($infraestructura->estado_taludes ?? '') == 2 ? 'checked' : '' }}>
                                        Regular</label>
                                    <label class="flex items-center gap-2"><input type="radio"
                                            name="estado_taludes" value="3"
                                            {{ ($infraestructura->estado_taludes ?? '') == 3 ? 'checked' : '' }}>
                                        Malo</label>
                                </div>
                            </div>
                        </div>

                        <!-- CERCO PERIMETRAL -->
                        <div class="border-t pt-4 mt-2">
                            <h5 class="font-semibold text-gray-700 mb-3">Cerco Perimetral</h5>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">¿Cuenta con cerco
                                        perimetral?</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2"><input type="radio"
                                                name="cp_erco_perim" value="SI" class="cp-tiene-cerco"
                                                {{ ($infraestructura->cp_erco_perim ?? '') == 'SI' ? 'checked' : '' }}>
                                            SI</label>
                                        <label class="flex items-center gap-2"><input type="radio"
                                                name="cp_erco_perim" value="NO" class="cp-tiene-cerco"
                                                {{ ($infraestructura->cp_erco_perim ?? '') == 'NO' ? 'checked' : '' }}>
                                            NO</label>
                                    </div>
                                </div>

                                <div class="cp-material-group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                                    <div class="flex flex-wrap gap-4">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="cp_material" value="CO"
                                                class="cp-material-radio"
                                                {{ ($infraestructura->cp_material ?? '') == 'CO' ? 'checked' : '' }}>
                                            Concreto
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="cp_material" value="LA"
                                                class="cp-material-radio"
                                                {{ ($infraestructura->cp_material ?? '') == 'LA' ? 'checked' : '' }}>
                                            Ladrillo
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="cp_material" value="FI"
                                                class="cp-material-radio"
                                                {{ ($infraestructura->cp_material ?? '') == 'FI' ? 'checked' : '' }}>
                                            Fierro
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="cp_material" value="MI"
                                                class="cp-material-radio"
                                                {{ ($infraestructura->cp_material ?? '') == 'MI' ? 'checked' : '' }}>
                                            Mixto
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="cp_material" value="OT"
                                                class="cp-material-radio"
                                                {{ ($infraestructura->cp_material ?? '') == 'OT' ? 'checked' : '' }}>
                                            Otro
                                        </label>
                                    </div>
                                    <input type="text" name="cp_material_nombre"
                                        class="mt-2 w-full rounded-lg border-gray-300 text-sm hidden"
                                        placeholder="Especifique el material"
                                        value="{{ $infraestructura->cp_material_nombre ?? '' }}">
                                </div>

                                <div class="cp-estado-group">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="cp_estado" value="BU"
                                                {{ ($infraestructura->cp_estado ?? '') == 'BU' ? 'checked' : '' }}>
                                            Bueno
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="cp_estado" value="RE"
                                                {{ ($infraestructura->cp_estado ?? '') == 'RE' ? 'checked' : '' }}>
                                            Regular
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="cp_estado" value="MA"
                                                {{ ($infraestructura->cp_estado ?? '') == 'MA' ? 'checked' : '' }}>
                                            Malo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

















        <!-- ============================================ -->
        <!-- SECCIÓN 3.4: OBSERVACIONES DEL EVALUADOR -->
        <!-- ============================================ -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
            <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                    <i class="fas fa-comment-dots"></i> 3.4 Observaciones, Comentarios y/o Apreciación del Evaluador
                </h3>
            </div>
            <div class="p-6">
                <textarea name="observacion" rows="4"
                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                    placeholder="Ingrese sus observaciones y comentarios...">{{ $infraestructura->observacion ?? '' }}</textarea>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- SECCIÓN 3.5: IDENTIFICACIÓN PRELIMINAR DEL TIPO DE INTERVENCIÓN -->
        <!-- ============================================ -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
            <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                    <i class="fas fa-clipboard-list"></i> 3.5 Identificación Preliminar del Tipo de Intervención
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Intervalo de Puntaje</label>
                        <input type="text" id="puntaje_intervalo"
                            class="w-full rounded-lg border-gray-300 bg-gray-100" readonly placeholder="0 - 65">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Puntaje Obtenido</label>
                        <input type="number" name="puntaje" id="puntaje_obtenido" step="0.01"
                            class="w-full rounded-lg border-gray-300 bg-gray-100" readonly placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Intervención</label>
                        <input type="text" id="tipo_intervencion_resultante" name="tipo_intervencion"
                            class="w-full rounded-lg border-gray-300 bg-gray-100" readonly
                            placeholder="Se calculará automáticamente">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Evaluación</label>
                        <input type="date" name="fecha_evaluacion"
                            value="{{ $infraestructura->fecha_evaluacion ?? '' }}"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora de Inicio</label>
                        <input type="time" name="hora_inicio"
                            value="{{ $infraestructura->hora_inicio ?? '' }}"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora Final</label>
                        <input type="time" name="hora_final" value="{{ $infraestructura->hora_final ?? '' }}"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 3.6: DETERMINACIÓN DE LA OPERATIVIDAD -->
        <!-- ============================================ -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
            <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                    <i class="fas fa-chart-simple"></i> 3.6 Determinación de la Operatividad de la Infraestructura
                </h3>
            </div>
            <div class="p-6">
                <!-- Tabla de operatividad - se actualiza automáticamente -->
                <!-- Tabla de operatividad - se actualiza automáticamente -->
                <div class="mb-6 overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">INTERVALO DE PUNTAJE</th>
                                <th class="border px-4 py-2 text-left">PUNTAJE OBTENIDO</th>
                                <th class="border px-4 py-2 text-left">CALIFICACIÓN</th>
                                <th class="border px-4 py-2 text-left">RECOMENDACIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Fila: Mayor a 75 -->
                            <tr id="fila_mayor_75">
                                <td class="border px-4 py-2">Mayor a 75</td>
                                <td id="puntaje_mayor_75" class="border px-4 py-2 text-center font-semibold">-</td>
                                <td class="border px-4 py-2">Afectado inoperativo</td>
                                <td class="border px-4 py-2">Evacuar</td>
                            </tr>
                            <!-- Fila: 21 a 75 -->
                            <tr id="fila_21_75">
                                <td class="border px-4 py-2">21 a 75</td>
                                <td id="puntaje_21_75" class="border px-4 py-2 text-center font-semibold">-</td>
                                <td class="border px-4 py-2">Afectado operativo (Alto)</td>
                                <td class="border px-4 py-2">Atención urgente - Intervenir inmediatamente</td>
                            </tr>
                            <!-- Fila: 1 a 20 -->
                            <tr id="fila_1_20">
                                <td class="border px-4 py-2">1 a 20</td>
                                <td id="puntaje_1_20" class="border px-4 py-2 text-center font-semibold">-</td>
                                <td class="border px-4 py-2">Afectado operativo (Leve)</td>
                                <td class="border px-4 py-2">Monitorear y planificar mantenimiento</td>
                            </tr>
                            <!-- Fila: 0 -->
                            <tr id="fila_0">
                                <td class="border px-4 py-2">0</td>
                                <td id="puntaje_0" class="border px-4 py-2 text-center font-semibold">-</td>
                                <td class="border px-4 py-2">No afectado</td>
                                <td class="border px-4 py-2">Continuar uso normal</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Comentarios -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comentarios</label>
                    <textarea name="comentarios" rows="3"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Comentarios sobre la operatividad...">{{ $infraestructura->comentarios ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 4: VISTAS GENERALES DEL ESTABLECIMIENTO DE SALUD - FOTOS -->
    <!-- ============================================ -->
    <div id="sec-fotos" class="form-section" x-data="sectionCounter('sec-fotos', 1)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-camera"></i> 4. Vistas Generales del Establecimiento de Salud - Fotos
                    <span class="section-badge">Imágenes</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Registre las fotos del establecimiento de salud</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span
                        class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="p-6">
                <!-- Botón para agregar foto -->
                <div class="mb-4 flex justify-end">
                    <button type="button" onclick="openFotoModal()"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                        <i class="fas fa-plus"></i> Agregar Foto
                    </button>
                </div>

                <!-- Tabla de fotos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">Nombre</th>
                                <th class="border px-4 py-2 text-left">Tamaño</th>
                                <th class="border px-4 py-2 text-left">Fecha</th>
                                <th class="border px-4 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-fotos">
                            @if (isset($fotos) && count($fotos) > 0)
                                @foreach ($fotos as $foto)
                                    <tr id="foto-{{ $foto->id }}">
                                        <td class="border px-4 py-2">
                                            <a href="{{ $foto->url }}" target="_blank"
                                                class="text-teal-600 hover:text-teal-800">
                                                {{ $foto->nombre }}
                                            </a>
                                        </td>
                                        <td class="border px-4 py-2">{{ $foto->size ?? '-' }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $foto->created_at ? date('d/m/Y H:i', strtotime($foto->created_at)) : '-' }}
                                        </td>
                                        <td class="border px-4 py-2 text-center">
                                            <button type="button"
                                                onclick="verFoto('{{ $foto->url }}', '{{ $foto->nombre }}')"
                                                class="text-blue-600 hover:text-blue-800 mr-2" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" onclick="deleteFoto({{ $foto->id }})"
                                                class="text-red-600 hover:text-red-800" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        </td>
                                @endforeach
                            @else
                                <tr id="no-fotos">
                                    <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                        No hay fotos registradas
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================ -->
    <!-- SECCIÓN 5: ARCHIVOS DEL ESTABLECIMIENTO -->
    <!-- ============================================ -->
    <div id="sec-archivos" class="form-section" x-data="sectionCounter('sec-archivos', 1)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-folder-open"></i> 5. Archivos del Establecimiento
                    <span class="section-badge">Documentos</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Registre los archivos del establecimiento de salud</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span
                        class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="p-6">
                <div class="mb-4 flex justify-end">
                    <button type="button" onclick="openArchivoModal()"
                        class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                        <i class="fas fa-upload"></i> Subir Archivo
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">Nombre</th>
                                <th class="border px-4 py-2 text-left">Tamaño</th>
                                <th class="border px-4 py-2 text-left">Fecha</th>
                                <th class="border px-4 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-archivos">
                            @if (isset($archivos) && count($archivos) > 0)
                                @foreach ($archivos as $archivo)
                                    <tr id="archivo-{{ $archivo->id }}">
                                        <td class="border px-4 py-2">
                                            <a href="{{ $archivo->url }}" target="_blank"
                                                class="text-amber-600 hover:text-amber-800">
                                                <i class="fas fa-file-alt mr-1"></i> {{ $archivo->nombre }}
                                            </a>
                                        </td>
                                        <td class="border px-4 py-2">{{ $archivo->size ?? '-' }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $archivo->created_at ? date('d/m/Y H:i', strtotime($archivo->created_at)) : '-' }}
                                        </td>
                                        <td class="border px-4 py-2 text-center">
                                            <button type="button"
                                                onclick="verArchivo('{{ $archivo->url }}', '{{ $archivo->nombre }}')"
                                                class="text-blue-600 hover:text-blue-800 mr-2" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" onclick="deleteArchivo({{ $archivo->id }})"
                                                class="text-red-600 hover:text-red-800" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="no-archivos">
                                    <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                        No hay archivos registrados
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================ -->
    <!-- SECCIÓN 6: ACCESIBILIDAD -->
    <!-- ============================================ -->
    <div id="sec-accesibilidad" class="form-section" x-data="sectionCounter('sec-accesibilidad', 4)">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-wheelchair"></i> 6. Accesibilidad
                    <span class="section-badge">Evaluación</span> <i class="fas accordion-icon"
                        :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Condiciones de acceso para pacientes, personal y público en general</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span
                        class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            ¿Se encuentra abierto a los pacientes, personal y público en general, dentro de los horarios
                            de atención establecidos?
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_1"
                                    value="SI"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_1 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_1"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_1 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_1"
                                    value="NO CORRESPONDE"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_1 ?? '') == 'NO CORRESPONDE' ? 'checked' : '' }}><span>NO
                                    CORRESPONDE</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            ¿Cuenta con rampas de ingreso y barandas en las escaleras para PCD (Personas con
                            Discapacidad)?
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_2"
                                    value="SI"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_2 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_2"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_2 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_2"
                                    value="NO CORRESPONDE"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_2 ?? '') == 'NO CORRESPONDE' ? 'checked' : '' }}><span>NO
                                    CORRESPONDE</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            ¿Cuenta con lugar para estacionamiento de taxis para personas con discapacidad?
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_3"
                                    value="SI"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_3 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_3"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_3 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_3"
                                    value="NO CORRESPONDE"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_3 ?? '') == 'NO CORRESPONDE' ? 'checked' : '' }}><span>NO
                                    CORRESPONDE</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            ¿El acceso es vulnerable a inundaciones o correnteras de agua por desnivel de piso?
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_4"
                                    value="SI"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_4 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_4"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_4 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_option_4"
                                    value="NO CORRESPONDE"
                                    class="rounded-full border-gray-300 text-purple-600 focus:ring-purple-500"
                                    {{ ($infraestructura->ac_option_4 ?? '') == 'NO CORRESPONDE' ? 'checked' : '' }}><span>NO
                                    CORRESPONDE</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- ============================================ -->
    <!-- SECCIÓN 7: UBICACIÓN Y ENTORNO -->
    <!-- ============================================ -->
    <div id="sec-ubicacion" class="form-section" x-data="sectionCounter('sec-ubicacion', 13)">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-map-marker-alt"></i> 7. Ubicación y Entorno
                    <span class="section-badge">Evaluación</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Evaluación del terreno y ubicación del establecimiento</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span
                        class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica en cuencas de topografía
                            accidentada, terrazas aluviales o de inundación, abanicos aluvionales, como de
                            deyección?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_1" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_1 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_1"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_1 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica en terrenos con
                            pendiente inestable, al pie de borde o de laderas?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_2" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_2 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_2"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_2 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Existe evidencias de restos
                            arqueológicos (declarados como zona arqueológica por el Ministerio de Cultura)?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_3" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_3 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_3"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_3 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Cuenta con Certificado de
                            Inexistencia de Restos Arqueológicos (CIRA)?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_4" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_4 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_4"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_4 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica a una distancia menor a
                            100m de estaciones de servicio de combustible?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_5" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_5 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_5"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_5 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica a una distancia menor a
                            100m de grandes edificaciones comerciales (supermercados o similares)?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_6" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_6 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_6"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_6 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica a una distancia menor a
                            100m al límite de la propiedad de edificaciones que generen concentración de
                            personas?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_7" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_7 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_7"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_7 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica a una distancia menor a
                            300m al límite de la propiedad de borde de ríos, lagos o lagunas?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_8" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_8 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_8"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_8 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica a una distancia menor a
                            1km al límite de la propiedad del litoral?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_9" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_9 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_9"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_9 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica en terrenos con suelo
                            provenientes de relleno sanitario?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_10" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_10 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_10"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_10 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica en terrenos próximos a
                            volcanes?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_11" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_11 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_11"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_11 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica a una distancia menor de
                            300m al límite de la propiedad de fuentes de contaminación ambiental?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_12" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_12 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_12"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_12 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Se ubica a una distancia menor de
                            1km de rellenos sanitarios, basurales y plantas de tratamiento de aguas residuales?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ub_option_13" value="SI"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_13 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ub_option_13"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                    {{ ($infraestructura->ub_option_13 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- ============================================ -->
    <!-- SECCIÓN 8: CIRCULACIÓN HORIZONTAL -->
    <!-- ============================================ -->
    <div id="sec-circulacion-horizontal" class="form-section" x-data="sectionCounter('sec-circulacion-horizontal', 10)">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-arrows-alt-h"></i> 8. Circulación Horizontal
                    <span class="section-badge">Evaluación</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Evaluación de corredores y accesos internos</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span
                        class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todos los corredores de las áreas
                            asistenciales tienen un ancho mínimo de 2.40m?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_1" value="SI"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_1 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ch_option_1"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_1 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todos los corredores de las áreas
                            de emergencia tienen un ancho mínimo de 2.80m?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_2" value="SI"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_2 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ch_option_2"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_2 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Los corredores se utilizan como
                            área de espera?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_3" value="SI"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_3 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ch_option_3"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_3 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿El área de espera de los
                            corredores se da en uno o en ambos lados?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_4" value="1"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_4 ?? '') == '1' ? 'checked' : '' }}><span>1 (Un
                                    lado)</span></label><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_4" value="2"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_4 ?? '') == '2' ? 'checked' : '' }}><span>2 (Ambos
                                    lados)</span></label></div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Cuál es el ancho total (m) del
                            corredor incluido el área de espera?</label>
                        <input type="number" step="0.01" name="ch_ancho"
                            value="{{ $infraestructura->ch_ancho ?? '' }}"
                            class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                            placeholder="Ej: 2.50">
                        <p class="text-xs text-gray-500 mt-1">Ingrese el ancho en metros (ejemplo: 2.50)</p>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿La circulación de la UPSS de
                            hospitalización está restringida?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_5" value="SI"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_5 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ch_option_5"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_5 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todos los corredores de las áreas
                            del centro quirúrgico tienen un ancho mínimo de 3.20m?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_6" value="SI"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_6 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ch_option_6"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_6 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todos los corredores están libres
                            de obstáculos?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_7" value="SI"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_7 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ch_option_7"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_7 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Los extintores o sistemas contra
                            incendios están empotrados en los muros de los corredores?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_8" value="SI"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_8 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ch_option_8"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_8 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todos los corredores están
                            protegidos del sol y la lluvia?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="ch_option_9" value="SI"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_9 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="ch_option_9"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-pink-600 focus:ring-pink-500"
                                    {{ ($infraestructura->ch_option_9 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- ============================================ -->
    <!-- SECCIÓN 9: CIRCULACIÓN VERTICAL -->
    <!-- ============================================ -->
    <div id="sec-circulacion-vertical" class="form-section" x-data="sectionCounter('sec-circulacion-vertical', 10)">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-arrows-alt-v"></i> 9. Circulación Vertical
                    <span class="section-badge">Evaluación</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Evaluación de escaleras, rampas y ascensores</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span
                        class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar">
                    <div class="counter-bar-fill"
                        :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                        :style="{ width: percent + '%' }"></div>
                </div>
                <div class="counter-percent"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todas las escaleras tienen un
                            ancho mínimo de 1.80m y tienen pasamanos a ambos lados de 0.90m de altura?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_1" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_1 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_1"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_1 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todas las escaleras de servicio y
                            de evacuación tienen un ancho mínimo de 1.20m y tienen pasamanos a ambos lados?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_2" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_2 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_2"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_2 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿El área previa a la escalera
                            tiene una distancia mínima de 3 metros considerada desde el inicio de la escalera hasta el
                            paramento opuesto?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_3" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_3 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_3"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_3 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Los pasos de las escaleras son de
                            material antideslizante y llevan cantoneras?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_4" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_4 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_4"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_4 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todas las rampas tienen un ancho
                            mínimo de 1.25m?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_5" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_5 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_5"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_5 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todas las rampas tienen el piso
                            de material antideslizante y/o bruñado cada 10cm?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_6" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_6 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_6"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_6 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todas las rampas peatonales
                            tienen la pendiente mínima de acuerdo a reglamento?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_7" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_7 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_7"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_7 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Todas las rampas cuentan con
                            barandas a ambos lados?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_8" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_8 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_8"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_8 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Cuenta con ascensores para el
                            traslado de pacientes?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_9" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_9 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_9"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_9 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-medium text-gray-700 mb-3">¿Cuenta con montacarga para
                            transportar únicamente carga y/o servicio?</label>
                        <div class="flex gap-6"><label class="flex items-center gap-2"><input type="radio"
                                    name="cv_option_10" value="SI"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_10 ?? '') == 'SI' ? 'checked' : '' }}><span>SI</span></label><label
                                class="flex items-center gap-2"><input type="radio" name="cv_option_10"
                                    value="NO"
                                    class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ ($infraestructura->cv_option_10 ?? '') == 'NO' ? 'checked' : '' }}><span>NO</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Modal para agregar/editar foto -->
<div id="fotoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900" id="modalFotoTitle">Agregar Foto</h3>
            <button type="button" onclick="closeFotoModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- IMPORTANTE: Este formulario NO debe tener acción, solo usamos fetch -->
        <form id="fotoForm" enctype="multipart/form-data" onsubmit="return false;">
            <input type="hidden" name="foto_id" id="foto_id" value="">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Archivo <span class="text-red-500"
                        id="archivo_required">*</span></label>
                <input type="file" name="foto_archivo" id="foto_archivo" accept="image/*"
                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG, GIF. Máximo 2MB</p>
                <p class="text-xs text-amber-600 mt-1" id="editar_aviso" style="display: none;">
                    <i class="fas fa-info-circle"></i> Si no selecciona un archivo, mantendrá la foto actual
                </p>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeFotoModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="button" onclick="guardarFoto()" // ← CAMBIADO a type="button"
                    class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Modal para ver foto -->
<!-- Modal para ver foto - Asegúrate que tenga estos IDs -->
<div id="verFotoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900" id="verFotoTitle"></h3>
            <button type="button" onclick="closeVerFotoModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="text-center">
            <img id="verFotoImg" src="" alt="" class="max-w-full max-h-96 mx-auto">
        </div>
    </div>
</div>

<!-- Modal para subir archivo -->
<div id="archivoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Subir Archivo</h3>
            <button type="button" onclick="closeArchivoModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="archivoForm" enctype="multipart/form-data" onsubmit="return false;">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Archivo <span
                        class="text-red-500">*</span></label>
                <input type="file" name="archivo_file" id="archivo_file"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.zip"
                    class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500">
                <p class="text-xs text-gray-500 mt-1">Formatos: PDF, DOC, XLS, ZIP. Máximo 2MB</p>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeArchivoModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="button" onclick="guardarArchivo()"
                    class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">
                    Subir
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const establecimientoId = {{ $establecimiento->id ?? 'null' }};
    const formatIId = {{ $infraestructura ? $infraestructura->id : 0 }};
    console.log('formatIId:', formatIId); // Debería mostrar 4
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
        <td class="px-4 py-2 text-sm">
            <button type="button" onclick="openAcabadosModal(${data.id})"
                class="text-teal-600 hover:text-teal-800" title="Acabados Interiores">
                <i class="fas fa-paint-roller"></i> Ver Acabados
            </button>
        </td>
        <td class="px-4 py-2 text-center">
            <button type="button" onclick="editEdificacion(${data.id})" 
                class="text-blue-600 hover:text-blue-800 mr-2" title="Editar">
                <i class="fas fa-edit"></i>
            </button>
            <button type="button" onclick="deleteEdificacion(${data.id})" 
                class="text-red-600 hover:text-red-800" title="Eliminar">
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
                            tbody.innerHTML =
                                `<tr id="no-registros"><td colspan="8" class="px-4 py-4 text-center text-gray-500">No hay edificaciones registradas</td></tr>`;
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
    // ============================================
    // ACABADOS INTERIORES
    // ============================================

    function openAcabadosModal(edificacionId) {
        console.log('Abriendo modal para edificación ID:', edificacionId); // Debug
        document.getElementById('acabados_edificacion_id').value = edificacionId;
        document.getElementById('acabadosModal').classList.remove('hidden');
        cargarAcabados(edificacionId);
    }

    function closeAcabadosModal() {
        document.getElementById('acabadosModal').classList.add('hidden');
    }

    function cargarAcabados(edificacionId) {
        // PRIMERO: Limpiar todos los campos del modal
        limpiarModalAcabados();

        fetch(`/infraestructura/acabados/${edificacionId}`)
            .then(response => response.json())
            .then(data => {
                if (data && Object.keys(data).length > 0) {
                    // Guardar valores en los inputs nombre
                    if (data.pisos_nombre) {
                        document.querySelector('input[name="ac_pisos_nombre"]').value = data.pisos_nombre;
                    }
                    if (data.veredas_nombre) {
                        document.querySelector('input[name="ac_veredas_nombre"]').value = data.veredas_nombre;
                    }
                    if (data.zocalos_nombre) {
                        document.querySelector('input[name="ac_zocalos_nombre"]').value = data.zocalos_nombre;
                    }
                    if (data.muros_nombre) {
                        document.querySelector('input[name="ac_muros_nombre"]').value = data.muros_nombre;
                    }
                    if (data.techo_nombre) {
                        document.querySelector('input[name="ac_techo_nombre"]').value = data.techo_nombre;
                    }

                    // Seleccionar radios
                    if (data.pisos) setRadioValue('ac_pisos', data.pisos);
                    if (data.pisos_estado) setRadioValue('ac_pisos_estado', data.pisos_estado);
                    if (data.veredas) setRadioValue('ac_veredas', data.veredas);
                    if (data.veredas_estado) setRadioValue('ac_veredas_estado', data.veredas_estado);
                    if (data.zocalos) setRadioValue('ac_zocalos', data.zocalos);
                    if (data.zocalos_estado) setRadioValue('ac_zocalos_estado', data.zocalos_estado);
                    if (data.muros) setRadioValue('ac_muros', data.muros);
                    if (data.muros_estado) setRadioValue('ac_muros_estado', data.muros_estado);
                    if (data.techo) setRadioValue('ac_techo', data.techo);
                    if (data.techo_estado) setRadioValue('ac_techo_estado', data.techo_estado);
                } else {
                    // Si no hay datos, mostrar el modal vacío
                    console.log('No hay acabados para esta edificación');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Función para limpiar el modal
    function limpiarModalAcabados() {
        // Limpiar todos los radios
        const grupos = ['ac_pisos', 'ac_veredas', 'ac_zocalos', 'ac_muros', 'ac_techo'];
        grupos.forEach(grupo => {
            const radios = document.querySelectorAll(`input[name="${grupo}"]`);
            radios.forEach(radio => radio.checked = false);
        });

        // Limpiar estados
        const estados = ['ac_pisos_estado', 'ac_veredas_estado', 'ac_zocalos_estado', 'ac_muros_estado',
            'ac_techo_estado'
        ];
        estados.forEach(estado => {
            const radios = document.querySelectorAll(`input[name="${estado}"]`);
            radios.forEach(radio => radio.checked = false);
        });

        // Limpiar inputs de texto
        const inputs = document.querySelectorAll('input[name*="_nombre"]');
        inputs.forEach(input => input.value = '');
    }

    function setRadioValue(name, value) {
        const radio = document.querySelector(`input[name="${name}"][value="${value}"]`);
        if (radio) radio.checked = true;
    }

    function guardarAcabados() {
        const edificacionId = document.getElementById('acabados_edificacion_id').value;

        const data = {
            id_format_i_one: edificacionId,
            pisos: getSelectedRadioValue('ac_pisos') || null,
            pisos_nombre: document.querySelector('input[name="ac_pisos_nombre"]')?.value || '',
            pisos_estado: getSelectedRadioValue('ac_pisos_estado') || null,
            veredas: getSelectedRadioValue('ac_veredas') || null,
            veredas_nombre: document.querySelector('input[name="ac_veredas_nombre"]')?.value || '',
            veredas_estado: getSelectedRadioValue('ac_veredas_estado') || null,
            zocalos: getSelectedRadioValue('ac_zocalos') || null,
            zocalos_nombre: document.querySelector('input[name="ac_zocalos_nombre"]')?.value || '',
            zocalos_estado: getSelectedRadioValue('ac_zocalos_estado') || null,
            muros: getSelectedRadioValue('ac_muros') || null,
            muros_nombre: document.querySelector('input[name="ac_muros_nombre"]')?.value || '',
            muros_estado: getSelectedRadioValue('ac_muros_estado') || null,
            techo: getSelectedRadioValue('ac_techo') || null,
            techo_nombre: document.querySelector('input[name="ac_techo_nombre"]')?.value || '',
            techo_estado: getSelectedRadioValue('ac_techo_estado') || null,
            _token: document.querySelector('input[name="_token"]')?.value || ''
        };

        fetch('/infraestructura/acabados', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    if (window.toast && window.toast.success) {
                        window.toast.success('Acabados guardados correctamente');
                    } else {
                        alert('Acabados guardados correctamente');
                    }
                    closeAcabadosModal();
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar acabados');
            });
    }

    function getSelectedRadioValue(name) {
        const selected = document.querySelector(`input[name="${name}"]:checked`);
        return selected ? selected.value : null;
    }

    // Manejar "Otros" en acabados interiores
    // Manejar "Otros" y asignar nombres automáticos en acabados interiores
    function initAcabadosInteriores() {
        const grupos = ['pisos', 'veredas', 'zocalos', 'muros', 'techo'];

        const nombresMap = {
            // PISOS
            'PMP': 'Parquet o madera pulida',
            'LAV': 'Láminas asfálticas, vinílicos o similares',
            'LTC': 'Loseta, terrazos, cerámicos o similares',
            'MAD': 'Madera',
            'CEM': 'Cemento',
            'TIE': 'Tierra',
            // VEREDAS
            'LTC': 'Loseta, terrazos, cerámicos o similares',
            'MAD': 'Madera',
            'CEM': 'Cemento',
            'TIE': 'Tierra',
            // ZÓCALOS
            'LTC': 'Loseta, terrazos, cerámicos o similares',
            'CEM': 'Cemento',
            // MUROS
            'LBC': 'Ladrillo o bloque de cemento',
            'PSC': 'Piedra o Sillar con cal o cemento',
            'ADO': 'Adobe',
            'TAP': 'Tapia',
            'MAD': 'Madera',
            // TECHO
            'CA': 'Concreto armado',
            'MAD': 'Madera',
            'TEJ': 'Tejas',
            'PCF': 'Planchas de calamina, fibra de cemento o similares',
            'CEB': 'Caña o estera con torta de barro o cemento',
            'TEC': 'Triplay/estera/carrizo'
        };

        grupos.forEach(grupo => {
            const radios = document.querySelectorAll(`input[name="ac_${grupo}"]`);
            const inputNombre = document.querySelector(`input[name="ac_${grupo}_nombre"]`);

            if (!radios.length || !inputNombre) return;

            // Función para actualizar el nombre según el radio seleccionado
            const updateNombre = () => {
                const selected = document.querySelector(`input[name="ac_${grupo}"]:checked`);

                if (selected) {
                    if (selected.value === 'OTR') {
                        inputNombre.style.display = 'block';
                        // Solo limpiar si es un nuevo "Otros" (sin valor guardado)
                        if (inputNombre.getAttribute('data-original-value') !== inputNombre.value) {
                            inputNombre.value = '';
                        }
                        inputNombre.focus();
                    } else {
                        inputNombre.style.display = 'none';
                        const nombreCompleto = nombresMap[selected.value];
                        if (nombreCompleto) {
                            inputNombre.value = nombreCompleto;
                        }
                    }
                }
            };

            // Guardar el valor original al cargar
            inputNombre.setAttribute('data-original-value', inputNombre.value || '');

            // Asignar evento a cada radio
            radios.forEach(radio => {
                radio.addEventListener('change', updateNombre);
            });

            // NO ejecutar updateNombre() al cargar para no sobrescribir valores guardados
            // Solo ajustar la visibilidad del campo "Otros"
            const checked = document.querySelector(`input[name="ac_${grupo}"]:checked`);
            if (checked && checked.value === 'OTR') {
                inputNombre.style.display = 'block';
            } else {
                inputNombre.style.display = 'none';
                // Si hay un valor guardado, mantenerlo
                const savedValue = inputNombre.getAttribute('data-original-value');
                if (savedValue && savedValue !== '') {
                    inputNombre.value = savedValue;
                }
            }
        });
    }


    // Manejar "Otro material" en el tipo de material
    const materialRadios = document.querySelectorAll('input[name="material"]');
    const materialOtroInput = document.querySelector('input[name="material_nombre"]');
    // Manejar material "Otro"
    if (materialRadios.length && materialOtroInput) {
        materialRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'OT') {
                    materialOtroInput.classList.remove('hidden');
                    materialOtroInput.focus();
                } else {
                    materialOtroInput.classList.add('hidden');
                    materialOtroInput.value = '';
                }
            });
        });
    }

    function initEvaluacionInfraestructura() {
        // Lista de todos los elementos A hasta N
        const elementos = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n'];

        elementos.forEach(letra => {
            const radioSi = document.querySelector(`input[name="infraestructura_option_${letra}"][value="1"]`);
            const radioNo = document.querySelector(`input[name="infraestructura_option_${letra}"][value="0"]`);
            const valoracionSelect = document.querySelector(`select[name="infraestructura_valor_${letra}"]`);
            const descripcionTextarea = document.querySelector(
                `textarea[name="infraestructura_descripcion_${letra}"]`);

            if (!radioSi || !radioNo || !valoracionSelect) return;

            // Función para mostrar/ocultar la valoración
            const toggleValoracion = () => {
                if (radioSi.checked) {
                    valoracionSelect.style.display = 'block';
                    valoracionSelect.disabled = false;
                    if (descripcionTextarea) {
                        descripcionTextarea.style.display = 'block';
                        descripcionTextarea.disabled = false;
                    }
                } else {
                    valoracionSelect.style.display = 'none';
                    valoracionSelect.disabled = true;
                    // Limpiar valor cuando es NO
                    valoracionSelect.value = '';
                    if (descripcionTextarea) {
                        descripcionTextarea.style.display = 'none';
                        descripcionTextarea.disabled = true;
                        descripcionTextarea.value = '';
                    }
                }
            };

            // Agregar eventos
            radioSi.addEventListener('change', toggleValoracion);
            radioNo.addEventListener('change', toggleValoracion);

            // Estado inicial al cargar la página
            toggleValoracion();
        });
    }
    // Manejo del Cerco Perimetral
    document.addEventListener('DOMContentLoaded', function() {
        const tieneCercoRadios = document.querySelectorAll('.cp-tiene-cerco');
        const materialGroup = document.querySelector('.cp-material-group');
        const estadoGroup = document.querySelector('.cp-estado-group');
        const materialRadios = document.querySelectorAll('.cp-material-radio');
        const materialOtroInput = document.querySelector('input[name="cp_material_nombre"]');
        const estadoRadios = document.querySelectorAll('input[name="cp_estado"]');

        function toggleCercoFields() {
            const selected = document.querySelector('input[name="cp_erco_perim"]:checked');
            const tieneCerco = selected && selected.value === 'SI';

            if (materialGroup) {
                materialGroup.style.opacity = tieneCerco ? '1' : '0.5';
                materialGroup.style.pointerEvents = tieneCerco ? 'auto' : 'none';
            }
            if (estadoGroup) {
                estadoGroup.style.opacity = tieneCerco ? '1' : '0.5';
                estadoGroup.style.pointerEvents = tieneCerco ? 'auto' : 'none';
            }

            materialRadios.forEach(radio => radio.disabled = !tieneCerco);
            estadoRadios.forEach(radio => radio.disabled = !tieneCerco);

            if (!tieneCerco) {
                materialRadios.forEach(radio => radio.checked = false);
                estadoRadios.forEach(radio => radio.checked = false);
                if (materialOtroInput) {
                    materialOtroInput.classList.add('hidden');
                    materialOtroInput.value = '';
                }
            } else {
                const selectedMaterial = document.querySelector('input[name="cp_material"]:checked');
                if (selectedMaterial && selectedMaterial.value === 'OTRO' && materialOtroInput) {
                    materialOtroInput.classList.remove('hidden');
                }
            }
        }
        // Manejar material "Otro"
        if (materialRadios.length && materialOtroInput) {
            materialRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'O') {
                        materialOtroInput.classList.remove('hidden');
                        materialOtroInput.focus();
                    } else {
                        materialOtroInput.classList.add('hidden');
                        materialOtroInput.value = '';
                    }
                });
            });
        }

        // Eventos para los radios de "tiene cerco"
        tieneCercoRadios.forEach(radio => {
            radio.addEventListener('change', toggleCercoFields);
        });

        // Estado inicial
        toggleCercoFields();
    });

    function calcularIntervencion() {
        const puntajeInput = document.getElementById('puntaje_obtenido');
        const intervaloInput = document.getElementById('puntaje_intervalo');
        const tipoInput = document.getElementById('tipo_intervencion_resultante');

        let puntaje = parseFloat(puntajeInput.value);

        // Si no es un número válido, limpiar campos
        if (isNaN(puntaje) || puntaje === '') {
            intervaloInput.value = '';
            tipoInput.value = '';
            return;
        }

        // Calcular intervalo y tipo de intervención
        if (puntaje >= 0 && puntaje <= 65) {
            intervaloInput.value = '0 - 65';
            tipoInput.value = 'SERVICIO y/o MANTENIMIENTO';
        } else if (puntaje > 65) {
            intervaloInput.value = 'Mayor a 65';
            tipoInput.value = 'IOARR y/o PIP';
        } else {
            intervaloInput.value = '';
            tipoInput.value = '';
        }
    }



    // ============================================
    // FUNCIONES REUTILIZABLES PARA PUNTAJE TOTAL
    // ============================================

    // Función principal: calcula el puntaje total de infraestructura (A hasta N)
    function calcularPuntajeTotalInfraestructura() {
        const letras = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n'];
        let total = 0;

        for (let letra of letras) {
            const radioSi = document.querySelector(`input[name="infraestructura_option_${letra}"][value="1"]:checked`);

            if (radioSi) {
                const selectValor = document.querySelector(`select[name="infraestructura_valor_${letra}"]`);
                if (selectValor && selectValor.value) {
                    const valor = parseInt(selectValor.value);
                    if (!isNaN(valor)) {
                        total += valor;
                    }
                }
            }
        }
        return total;
    }

    // Función para actualizar la sección 3.5 (Tipo de Intervención)
    function actualizarSeccion35() {
        const puntajeTotal = calcularPuntajeTotalInfraestructura();
        const puntajeInput = document.getElementById('puntaje_obtenido');
        const intervaloInput = document.getElementById('puntaje_intervalo');
        const tipoInput = document.getElementById('tipo_intervencion_resultante');

        if (puntajeInput) puntajeInput.value = puntajeTotal;

        if (puntajeTotal >= 0 && puntajeTotal <= 65) {
            if (intervaloInput) intervaloInput.value = '0 - 65';
            if (tipoInput) tipoInput.value = 'SERVICIO y/o MANTENIMIENTO';
        } else if (puntajeTotal > 65) {
            if (intervaloInput) intervaloInput.value = 'Mayor a 65';
            if (tipoInput) tipoInput.value = 'IOARR y/o PIP';
        } else {
            if (intervaloInput) intervaloInput.value = '';
            if (tipoInput) tipoInput.value = '';
        }
    }

    // Función para actualizar la sección 3.6 (Operatividad)
    // Función para actualizar la tabla de operatividad
    // Función para actualizar la tabla de operatividad
    function actualizarTablaOperatividad() {
        const puntajeTotal = calcularPuntajeTotalInfraestructura();

        // Limpiar todas las celdas de puntaje
        document.getElementById('puntaje_mayor_75').innerHTML = '-';
        document.getElementById('puntaje_1_20').innerHTML = '-';
        document.getElementById('puntaje_21_75').innerHTML = '-';
        document.getElementById('puntaje_0').innerHTML = '-';

        // Remover todas las clases de resaltado
        const filas = ['fila_mayor_75', 'fila_1_20', 'fila_21_75', 'fila_0'];
        filas.forEach(fila => {
            const elemento = document.getElementById(fila);
            if (elemento) {
                elemento.classList.remove('bg-red-50', 'border-red-500', 'border-2', 'bg-green-50',
                    'border-green-500', 'bg-amber-50', 'border-amber-500', 'bg-gray-50', 'border-gray-500');
            }
        });

        // Mostrar el puntaje en la fila correspondiente y resaltarla con el color adecuado
        if (puntajeTotal > 75) {
            document.getElementById('puntaje_mayor_75').innerHTML = puntajeTotal;
            document.getElementById('fila_mayor_75').classList.add('bg-red-50', 'border-red-500', 'border-2');
        } else if (puntajeTotal >= 21 && puntajeTotal <= 75) {
            document.getElementById('puntaje_21_75').innerHTML = puntajeTotal;
            document.getElementById('fila_21_75').classList.add('bg-amber-50', 'border-amber-500', 'border-2');
        } else if (puntajeTotal >= 1 && puntajeTotal <= 20) {
            document.getElementById('puntaje_1_20').innerHTML = puntajeTotal;
            document.getElementById('fila_1_20').classList.add('bg-green-50', 'border-green-500', 'border-2');
        } else if (puntajeTotal === 0) {
            document.getElementById('puntaje_0').innerHTML = puntajeTotal;
            document.getElementById('fila_0').classList.add('bg-gray-50', 'border-gray-500', 'border-2');
        }
    }

    // Función para actualizar AMBAS secciones
    function actualizarAmbasSecciones() {
        actualizarSeccion35();
        actualizarTablaOperatividad();
    }

    // Función que ya tenías (solo cambia qué función llama)
    function initCalculoPuntaje() {
        const letras = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n'];

        for (let letra of letras) {
            const radios = document.querySelectorAll(`input[name="infraestructura_option_${letra}"]`);
            const selectValor = document.querySelector(`select[name="infraestructura_valor_${letra}"]`);

            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    setTimeout(actualizarAmbasSecciones, 10);
                });
            });

            if (selectValor) {
                selectValor.addEventListener('change', () => {
                    setTimeout(actualizarAmbasSecciones, 10);
                });
            }
        }

        // Calcular al cargar la página
        actualizarAmbasSecciones();
    }
    // ============================================
    // FUNCIONES PARA FOTOS - VERSIÓN CORREGIDA
    // ============================================

    function openFotoModal() {
        if (!formatIId || formatIId === 0) {
            alert('Primero debe guardar los datos de infraestructura antes de subir fotos');
            return;
        }

        document.getElementById('fotoModal').classList.remove('hidden');
        document.getElementById('modalFotoTitle').innerText = 'Agregar Foto';
        document.getElementById('foto_id').value = '';

        // Para nueva foto, el archivo es obligatorio
        const archivoInput = document.getElementById('foto_archivo');
        if (archivoInput) {
            archivoInput.required = true;
            archivoInput.value = '';
        }

        // Ocultar aviso de edición
        const aviso = document.getElementById('editar_aviso');
        if (aviso) aviso.style.display = 'none';

        const requiredSpan = document.getElementById('archivo_required');
        if (requiredSpan) requiredSpan.style.display = 'inline';
    }
    // Función separada para guardar fotos (NO usar submit del formulario)
    async function guardarFoto() {
        console.log('=== INICIO guardarFoto ===');

        const fotoId = document.getElementById('foto_id').value;
        const archivo = document.getElementById('foto_archivo').files[0];

        console.log('fotoId:', fotoId);
        console.log('archivo:', archivo ? archivo.name : 'null');
        console.log('formatIId:', formatIId);

        // Validación SIMPLE
        if (!archivo) {
            alert('Debe seleccionar un archivo');
            return;
        }

        if (!formatIId || formatIId === 0) {
            alert('ID de infraestructura no válido: ' + formatIId);
            return;
        }

        const formData = new FormData();
        formData.append('id_format_i', formatIId);
        formData.append('_token', document.querySelector('input[name="_token"]')?.value || '');
        formData.append('foto', archivo);

        if (fotoId) {
            formData.append('_method', 'PUT');
        }

        // Mostrar en consola lo que se va a enviar
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        const btn = event?.target;
        const originalText = btn?.innerHTML;
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        }

        try {
            const url = fotoId ? `/infraestructura/fotos/${fotoId}` : '/infraestructura/fotos';

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();
            console.log('Respuesta:', result);

            if (result.success) {
                alert('✅ Foto guardada exitosamente');
                closeFotoModal();
                location.reload(); // Recargar para mostrar la nueva foto
            } else {
                alert('❌ Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        }
    }



    function closeFotoModal() {
        document.getElementById('fotoModal').classList.add('hidden');
        // Resetear el formulario
        document.getElementById('foto_id').value = '';
        document.getElementById('foto_archivo').value = '';
    }


    function verFoto(url, nombre) {
        console.log('Ver foto:', url, nombre);
        const modal = document.getElementById('verFotoModal');
        const title = document.getElementById('verFotoTitle');
        const img = document.getElementById('verFotoImg');

        if (!modal || !title || !img) {
            console.error('No se encontraron elementos del modal');
            return;
        }

        title.innerText = nombre;
        img.src = url;
        modal.classList.remove('hidden');
    }

    function closeVerFotoModal() {
        const modal = document.getElementById('verFotoModal');
        if (modal) {
            modal.classList.add('hidden');
        }
        // Limpiar la imagen para evitar que se vea la anterior al abrir otro
        const img = document.getElementById('verFotoImg');
        if (img) {
            img.src = '';
        }
    }

    function deleteFoto(id) {
        if (confirm('¿Está seguro de eliminar esta foto?')) {
            fetch(`/infraestructura/fotos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || ''
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const row = document.getElementById(`foto-${id}`);
                        if (row) row.remove();

                        const tbody = document.getElementById('tabla-fotos');
                        if (tbody && tbody.children.length === 0) {
                            tbody.innerHTML =
                                `<tr id="no-fotos"><td colspan="4" class="border px-4 py-4 text-center text-gray-500">No hay fotos registradas</td></tr>`;
                        }

                        if (window.toast && window.toast.success) {
                            window.toast.success(result.message);
                        } else {
                            alert(result.message);
                        }
                    } else {
                        alert('Error: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar la foto');
                });
        }
    }





    // Función auxiliar para escapar HTML
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        }).replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, function(c) {
            return c;
        });
    }


    // ============================================
    // FUNCIONES PARA ARCHIVOS - VERSIÓN CORREGIDA
    // ============================================

    function openArchivoModal() {
        if (!formatIId || formatIId === 0) {
            alert('Primero debe guardar los datos de infraestructura');
            return;
        }
        document.getElementById('archivoModal').classList.remove('hidden');
        document.getElementById('archivo_file').value = '';
    }

    function closeArchivoModal() {
        document.getElementById('archivoModal').classList.add('hidden');
    }

    async function guardarArchivo() {
        const archivo = document.getElementById('archivo_file').files[0];

        if (!archivo) {
            alert('Debe seleccionar un archivo');
            return;
        }
        // Validar nombre del archivo (sin emojis ni caracteres raros)
        const nombreArchivo = archivo.name;
        const nombreLimpio = nombreArchivo.replace(/[^\x20-\x7E]/g, '');

        if (nombreArchivo !== nombreLimpio) {
            alert(
                '⚠️ El nombre del archivo contiene caracteres especiales o emojis. Se guardará con nombre limpio.'
            );
        }
        const formData = new FormData();
        formData.append('id_format_i', formatIId);
        formData.append('archivo', archivo);
        formData.append('_token', document.querySelector('input[name="_token"]')?.value || '');

        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subiendo...';

        try {
            const response = await fetch('/infraestructura/archivos', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || ''
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert('✅ Archivo subido exitosamente');
                closeArchivoModal();
                location.reload();
            } else {
                alert('❌ Error: ' + result.message);
            }
        } catch (error) {
            alert('Error: ' + error.message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }

    function abrirArchivoOffice(url, extension, nombre) {
        const fullUrl = url.startsWith('http') ? url : window.location.origin + url;

        // Mostrar mensaje de confirmación
        const confirmar = confirm(
            `¿Desea abrir "${nombre}" con ${getOfficeName(extension)}?`
        );

        if (!confirmar) return;

        try {
            let protocol = '';
            switch (extension) {
                case 'doc':
                case 'docx':
                    protocol = 'ms-word';
                    break;
                case 'xls':
                case 'xlsx':
                    protocol = 'ms-excel';
                    break;
                case 'ppt':
                case 'pptx':
                    protocol = 'ms-powerpoint';
                    break;
                default:
                    window.open(fullUrl, '_blank');
                    return;
            }

            // Usar el protocolo ofe|u (Office File Extension - URL)
            window.location.href = `${protocol}:ofe|u|${fullUrl}`;

        } catch (error) {
            console.error('Error:', error);
            // Fallback: descargar
            const link = document.createElement('a');
            link.href = fullUrl;
            link.download = nombre;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    function getOfficeName(extension) {
        const names = {
            'doc': 'Microsoft Word',
            'docx': 'Microsoft Word',
            'xls': 'Microsoft Excel',
            'xlsx': 'Microsoft Excel',
            'ppt': 'Microsoft PowerPoint',
            'pptx': 'Microsoft PowerPoint'
        };
        return names[extension] || 'la aplicación correspondiente';
    }

    function verArchivo(url, nombre) {
        // Obtener extensión del nombre del archivo
        const extension = nombre.split('.').pop().toLowerCase();

        console.log('Ver archivo:', {
            url,
            nombre,
            extension
        });

        // Imágenes
        if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'].includes(extension)) {
            mostrarImagenModal(url, nombre);
            return;
        }

        // PDF
        if (extension === 'pdf') {
            window.open(url, '_blank');
            return;
        }

        // Office
        if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(extension)) {
            abrirArchivoOffice(url, extension, nombre);
            return;
        }

        // Otros: descargar
        const link = document.createElement('a');
        link.href = url;
        link.download = nombre;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function mostrarImagenModal(url, nombre) {
        const modalHtml = `
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50" onclick="closeImageModal()">
            <div class="relative max-w-4xl max-h-[90vh] p-4" onclick="event.stopPropagation()">
                <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white text-2xl hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
                <img src="${url}" alt="${nombre}" class="max-w-full max-h-[80vh] mx-auto rounded-lg shadow-lg">
                <p class="text-white text-center mt-4">${nombre}</p>
            </div>
        </div>
    `;

        const existingModal = document.getElementById('imageModal');
        if (existingModal) existingModal.remove();

        document.body.insertAdjacentHTML('beforeend', modalHtml);
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        if (modal) modal.remove();
    }

    function deleteArchivo(id) {
        if (confirm('¿Está seguro de eliminar este archivo?')) {
            fetch(`/infraestructura/archivos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || ''
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const row = document.getElementById(`archivo-${id}`);
                        if (row) row.remove();

                        const tbody = document.getElementById('tabla-archivos');
                        if (tbody.children.length === 0) {
                            tbody.innerHTML =
                                `<tr id="no-archivos"><td colspan="4" class="border px-4 py-4 text-center text-gray-500">No hay archivos registrados</td></tr>`;
                        }
                        alert(result.message);
                    } else {
                        alert('Error: ' + result.message);
                    }
                })
                .catch(error => {
                    alert('Error al eliminar el archivo');
                });
        }
    }


    // ============================================
    // INICIALIZACIÓN
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        initAcabadosExteriores();
        initAcabadosInteriores();
        initEvaluacionInfraestructura();
        initCalculoPuntaje(); // Esto ahora actualiza AMBAS secciones (3.5 y 3.6)
    });
</script>
