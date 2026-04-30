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

                <!-- Estado del Saneamiento Físico Legal - RADIO BUTTON -->
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

                <!-- Condición de Saneamiento Físico Legal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Condición de Saneamiento Físico
                        Legal</label>
                    <select name="t_condicion_saneamiento"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        <option value="PROPIO"
                            {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'PROPIO' ? 'selected' : '' }}>
                            PROPIO</option>
                        <option value="ALQUILER"
                            {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'ALQUILER' ? 'selected' : '' }}>
                            ALQUILER</option>
                        <option value="CESION"
                            {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'CESION' ? 'selected' : '' }}>
                            CESIÓN</option>
                        <option value="OTRO"
                            {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'OTRO' ? 'selected' : '' }}>OTRO
                        </option>
                    </select>
                </div>

                <!-- Copia Literal, Convenio, Contrato o N° de Partida Registral -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Copia Literal, Convenio, Contrato o
                        N° de Partida Registral</label>
                    <input type="text" name="t_nro_contrato" value="{{ $infraestructura->t_nro_contrato ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ingrese el número">
                </div>

                <!-- Título a favor de -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título a favor de</label>
                    <input type="text" name="t_titulo_a_favor" value="{{ $infraestructura->t_titulo_a_favor ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: MINSA, GOBIERNO REGIONAL">
                </div>

                <!-- Observación -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observación</label>
                    <input type="text" name="t_observacion" value="{{ $infraestructura->t_observacion ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Observaciones del terreno">
                </div>

                <!-- ÁREA TERRENO (m2) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA TERRENO (m²)</label>
                    <input type="number" step="0.01" name="t_area_terreno"
                        value="{{ $infraestructura->t_area_terreno ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0.00">
                </div>

                <!-- ÁREA CONSTRUIDA (m2) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA CONSTRUIDA (m²)</label>
                    <input type="number" step="0.01" name="t_area_construida"
                        value="{{ $infraestructura->t_area_construida ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0.00">
                </div>

                <!-- ÁREA ESTACIONAMIENTO (m2) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA ESTACIONAMIENTO (m²)</label>
                    <input type="number" step="0.01" name="t_area_estac"
                        value="{{ $infraestructura->t_area_estac ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0.00">
                </div>

                <!-- ÁREA LIBRE (m2) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA LIBRE (m²)</label>
                    <input type="number" step="0.01" name="t_area_libre"
                        value="{{ $infraestructura->t_area_libre ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0.00">
                </div>

                <!-- N° PLAZA DE ESTACIONAMIENTO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">N° PLAZA DE ESTACIONAMIENTO</label>
                    <input type="number" name="t_estacionamiento"
                        value="{{ $infraestructura->t_estacionamiento ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="0">
                </div>

                <!-- ¿CUENTA CON INSPECCIÓN TÉCNICA DE SEGURIDAD EN EDIFICACIONES? - RADIO BUTTON -->
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

                <!-- ESTADO DE LA INSPECCIÓN - Se muestra solo si seleccionó SI -->
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

                <!-- Plano de Ubicación -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANO DE
                        UBICACIÓN</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ubicacion" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ubicacion ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ubicacion" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ubicacion ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Estructuras -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        ESTRUCTURAS</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_estructuras" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_estructuras ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_estructuras" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_estructuras ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Instalaciones Mecánicas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        INSTALACIONES MECÁNICAS</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ins_mecanicas" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ins_mecanicas ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ins_mecanicas" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ins_mecanicas ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Plano Perimétrico -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANO
                        PERIMÉTRICO</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_perimetro" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_perimetro ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_perimetro" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_perimetro ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Instalaciones Sanitarias -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        INSTALACIONES SANITARIAS</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ins_sanitarias" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ins_sanitarias ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ins_sanitarias" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ins_sanitarias ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Instalaciones de Comunicaciones -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        INSTALACIONES DE COMUNICACIONES</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ins_comunic" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ins_comunic ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ins_comunic" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ins_comunic ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Plano de Arquitectura -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANO DE
                        ARQUITECTURA</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_arquitectura" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_arquitectura ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_arquitectura" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_arquitectura ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Instalaciones Eléctricas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        INSTALACIONES ELÉCTRICAS</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ins_electricas" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ins_electricas ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_ins_electricas" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_ins_electricas ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Distribución de Equipamiento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        DISTRIBUCIÓN DE EQUIPAMIENTO</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_distribuicion" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_distribuicion ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pf_distribuicion" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pf_distribuicion ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ============================================ -->
    <!-- SECCIÓN 2B: PLANOS TÉCNICOS (DIGITAL) -->
    <!-- ============================================ -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-50 to-white px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-teal-800 flex items-center gap-2">
                <i class="fas fa-laptop-code"></i> 2.1 Disponibilidad de Planos Técnicos (DIGITAL)
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Plano de Ubicación -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANO DE
                        UBICACIÓN</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ubicacion" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ubicacion ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ubicacion" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ubicacion ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Plano Perimétrico -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANO
                        PERIMÉTRICO</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_perimetro" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_perimetro ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_perimetro" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_perimetro ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Arquitectura -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        ARQUITECTURA</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_arquitectura" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_arquitectura ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_arquitectura" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_arquitectura ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Estructuras -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        ESTRUCTURAS</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_estructuras" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_estructuras ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_estructuras" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_estructuras ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Instalaciones Sanitarias -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        INSTALACIONES SANITARIAS</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ins_sanitarias" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ins_sanitarias ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ins_sanitarias" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ins_sanitarias ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Instalaciones Eléctricas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        INSTALACIONES ELÉCTRICAS</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ins_electricas" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ins_electricas ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ins_electricas" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ins_electricas ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Instalaciones Mecánicas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        INSTALACIONES MECÁNICAS</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ins_mecanicas" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ins_mecanicas ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ins_mecanicas" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ins_mecanicas ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Instalaciones de Comunicaciones -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        INSTALACIONES DE COMUNICACIONES</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ins_comunic" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ins_comunic ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_ins_comunic" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_ins_comunic ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

                <!-- Planos de Distribución de Equipamiento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LA IPRESS CUENTA CON PLANOS DE
                        DISTRIBUCIÓN DE EQUIPAMIENTO</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_distribuicion" value="SI"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_distribuicion ?? '') == 'SI' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">SI</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="pd_distribuicion" value="NO"
                                class="rounded-full border-gray-300 text-teal-600 focus:ring-teal-500"
                                {{ ($infraestructura->pd_distribuicion ?? '') == 'NO' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">NO</span>
                        </label>
                    </div>
                </div>

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
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- N° de Sótanos -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">N° de Sótanos</label>
                    <input type="number" name="sonatos" value="{{ $infraestructura->sonatos ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: 0, 1, 2">
                </div>

                <!-- N° de Pisos -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">N° de Pisos (sobre nivel)</label>
                    <input type="number" name="pisos" value="{{ $infraestructura->pisos ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: 1, 2, 3">
                </div>

                <!-- Área Aproximada -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Área Aproximada (m²)</label>
                    <input type="number" step="0.01" name="area" value="{{ $infraestructura->area ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: 500.00">
                </div>

                <!-- Tipo de Material -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Material</label>
                    <select name="material"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        onchange="document.querySelector('[name=material_nombre]').style.display = this.value == '5' ? 'block' : 'none'">
                        <option value="">Seleccione</option>
                        <option value="1" {{ ($infraestructura->material ?? '') == '1' ? 'selected' : '' }}>
                            Adobe</option>
                        <option value="2" {{ ($infraestructura->material ?? '') == '2' ? 'selected' : '' }}>
                            Ladrillo</option>
                        <option value="3" {{ ($infraestructura->material ?? '') == '3' ? 'selected' : '' }}>
                            Concreto</option>
                        <option value="4" {{ ($infraestructura->material ?? '') == '4' ? 'selected' : '' }}>
                            Madera</option>
                        <option value="5" {{ ($infraestructura->material ?? '') == '5' ? 'selected' : '' }}>
                            Otro</option>
                    </select>
                </div>

                <!-- Material (especificar) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Material (especificar)</label>
                    <input type="text" name="material_nombre"
                        value="{{ $infraestructura->material_nombre ?? '' }}"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Especifique el material si seleccionó 'Otro'"
                        style="display: {{ ($infraestructura->material ?? '') == '5' ? 'block' : 'none' }}">
                </div>

                <!-- Suelo Vulnerable -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Suelo Vulnerable</label>
                    <select name="t_vulnerable"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        <option value="SI" {{ ($infraestructura->t_vulnerable ?? '') == 'SI' ? 'selected' : '' }}>
                            SI</option>
                        <option value="NO" {{ ($infraestructura->t_vulnerable ?? '') == 'NO' ? 'selected' : '' }}>
                            NO</option>
                    </select>
                </div>
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
                <!-- Cuenta con cerco perimétrico -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">¿Cuenta con cerco
                        perimétrico?</label>
                    <select name="cp_erco_perim"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        <option value="SI"
                            {{ ($infraestructura->cp_erco_perim ?? '') == 'SI' ? 'selected' : '' }}>SI</option>
                        <option value="NO"
                            {{ ($infraestructura->cp_erco_perim ?? '') == 'NO' ? 'selected' : '' }}>NO</option>
                    </select>
                </div>

                <!-- Material del cerco -->
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
                            {{ ($infraestructura->cp_material ?? '') == 'MADERA' ? 'selected' : '' }}>Madera
                        </option>
                        <option value="OTRO"
                            {{ ($infraestructura->cp_material ?? '') == 'OTRO' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <!-- Estado del cerco -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado del cerco</label>
                    <select name="cp_estado"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        <option value="BUENO" {{ ($infraestructura->cp_estado ?? '') == 'BUENO' ? 'selected' : '' }}>
                            Bueno</option>
                        <option value="REGULAR"
                            {{ ($infraestructura->cp_estado ?? '') == 'REGULAR' ? 'selected' : '' }}>Regular
                        </option>
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
    // Mostrar/ocultar campo de material "Otro"
    document.querySelector('[name=material]')?.addEventListener('change', function() {
        const materialOtro = document.querySelector('[name=material_nombre]');
        if (materialOtro) {
            materialOtro.style.display = this.value == '5' ? 'block' : 'none';
        }
    });
</script>
