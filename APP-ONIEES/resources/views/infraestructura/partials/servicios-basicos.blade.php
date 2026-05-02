<!-- ============================================ -->
<!-- SECCIÓN: SERVICIOS BÁSICOS -->
<!-- ============================================ -->
<div id="sec-servicios-basicos" class="form-section" x-data="sectionCounter('sec-servicios-basicos', 1)">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <i class="fas fa-water"></i> Servicios Básicos
                <span class="section-badge">Evaluación</span>
                <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Disponibilidad y estado de servicios básicos del establecimiento</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number">
                <span class="completed" x-text="filled"></span>
                <span class="total">/<span x-text="total"></span></span>
            </div>
            <div class="counter-bar">
                <div class="counter-bar-fill"
                    :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')"
                    :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent"
                :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'">
            </div>
        </div>
    </div>

    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="space-y-6">

            <!-- ============================================ -->
<!-- AGUA - CORREGIDO -->
<!-- ============================================ -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ 
    mostrarOtroAgua: '{{ old('se_agua', $format_ii->se_agua ?? '') }}' === 'O'
}">
    <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-blue-800 flex items-center gap-2">
            <i class="fas fa-tint"></i> AGUA
        </h3>
        <p class="text-sm text-gray-500 mt-1">Servicio de agua del establecimiento</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    El agua que utilizan en la IPRESS procede principalmente de:
                    <span class="text-red-500">*</span>
                </label>
                <select name="se_agua" 
                    @change="mostrarOtroAgua = $event.target.value === 'O'"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccione</option>
                    <option value="RP" {{ (old('se_agua', $format_ii->se_agua ?? '') == 'RP') ? 'selected' : '' }}>Red pública</option>
                    <option value="PZ" {{ (old('se_agua', $format_ii->se_agua ?? '') == 'PZ') ? 'selected' : '' }}>Pozo</option>
                    <option value="CI" {{ (old('se_agua', $format_ii->se_agua ?? '') == 'CI') ? 'selected' : '' }}>Cisterna</option>
                    <option value="CC" {{ (old('se_agua', $format_ii->se_agua ?? '') == 'CC') ? 'selected' : '' }}>Camión cisterna</option>
                    <option value="RA" {{ (old('se_agua', $format_ii->se_agua ?? '') == 'RA') ? 'selected' : '' }}>Río/acequia</option>
                    <option value="O" {{ (old('se_agua', $format_ii->se_agua ?? '') == 'O') ? 'selected' : '' }}>Otro</option>
                </select>

                <input type="text" name="se_agua_otro" value="{{ old('se_agua_otro', $format_ii->se_agua_otro ?? '') }}"
                    x-show="mostrarOtroAgua" 
                    x-transition.duration.200ms
                    class="mt-2 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Especifique otro">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">¿Se encuentra operativo?</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="se_agua_operativo" value="SI" {{ (old('se_agua_operativo', $format_ii->se_agua_operativo ?? '') == 'SI') ? 'checked' : '' }}> SI
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="se_agua_operativo" value="NO" {{ (old('se_agua_operativo', $format_ii->se_agua_operativo ?? '') == 'NO') ? 'checked' : '' }}> NO
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de conservación</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2"><input type="radio" name="se_agua_estado" value="B" {{ (old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'B') ? 'checked' : '' }}> Bueno</label>
                    <label class="flex items-center gap-2"><input type="radio" name="se_agua_estado" value="R" {{ (old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'R') ? 'checked' : '' }}> Regular</label>
                    <label class="flex items-center gap-2"><input type="radio" name="se_agua_estado" value="M" {{ (old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'M') ? 'checked' : '' }}> Malo</label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">La IPRESS tiene el servicio de agua todos los días de la semana</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2"><input type="radio" name="se_sevicio_semana" value="SI" {{ (old('se_sevicio_semana', $format_ii->se_sevicio_semana ?? '') == 'SI') ? 'checked' : '' }}> SI</label>
                    <label class="flex items-center gap-2"><input type="radio" name="se_sevicio_semana" value="NO" {{ (old('se_sevicio_semana', $format_ii->se_sevicio_semana ?? '') == 'NO') ? 'checked' : '' }}> NO</label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Horas al día</label>
                <input type="number" name="se_horas_dia" value="{{ old('se_horas_dia', $format_ii->se_horas_dia ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="24">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Horas a la semana</label>
                <input type="number" name="se_horas_semana" value="{{ old('se_horas_semana', $format_ii->se_horas_semana ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="168">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">¿Pagan por el servicio de agua?</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2"><input type="radio" name="se_servicio_agua" value="SI" {{ (old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'SI') ? 'checked' : '' }}> SI</label>
                    <label class="flex items-center gap-2"><input type="radio" name="se_servicio_agua" value="NO" {{ (old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'NO') ? 'checked' : '' }}> NO</label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">¿A qué empresa o entidad se paga por el servicio de agua?</label>
                <select name="se_empresa_agua" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Seleccione</option>
                    <option value="EPS" {{ (old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'EPS') ? 'selected' : '' }}>Empresa prestadora de servicio</option>
                    <option value="M" {{ (old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'M') ? 'selected' : '' }}>Municipalidad</option>
                    <option value="PC" {{ (old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'PC') ? 'selected' : '' }}>Organizacion comunal</option>
                    <option value="C" {{ (old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'C') ? 'selected' : '' }}>Camion cisterna (pago directo)</option>
                </select>
            </div>
        </div>
    </div>
</div>


            <!-- ============================================ -->
            <!-- ELECTRICIDAD -->
            <!-- ============================================ -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-50 to-white px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center gap-2">
                        <i class="fas fa-bolt"></i> ELECTRICIDAD
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Servicio de electricidad del establecimiento</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Cuenta con servicio de
                                electricidad?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio" name="se_electricidad"
                                        value="SI"
                                        {{ ($format_ii->se_electricidad ?? '') == 'SI' ? 'checked' : '' }}> SI</label>
                                <label class="flex items-center gap-2"><input type="radio" name="se_electricidad"
                                        value="NO"
                                        {{ ($format_ii->se_electricidad ?? '') == 'NO' ? 'checked' : '' }}> NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Se encuentra
                                operativo?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_electricidad_operativo" value="SI"
                                        {{ ($format_ii->se_electricidad_operativo ?? '') == 'SI' ? 'checked' : '' }}>
                                    SI</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_electricidad_operativo" value="NO"
                                        {{ ($format_ii->se_electricidad_operativo ?? '') == 'NO' ? 'checked' : '' }}>
                                    NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Situación de servicio</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_electricidad_estado" value="B"
                                        {{ ($format_ii->se_electricidad_estado ?? '') == 'B' ? 'checked' : '' }}>
                                    Bueno</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_electricidad_estado" value="R"
                                        {{ ($format_ii->se_electricidad_estado ?? '') == 'R' ? 'checked' : '' }}>
                                    Regular</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_electricidad_estado" value="M"
                                        {{ ($format_ii->se_electricidad_estado ?? '') == 'M' ? 'checked' : '' }}>
                                    Malo</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Modo de uso</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_electricidad_option" value="CONTINUO"
                                        {{ ($format_ii->se_electricidad_option ?? '') == 'CONTINUO' ? 'checked' : '' }}>
                                    Continuo</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_electricidad_option" value="TEMPORAL"
                                        {{ ($format_ii->se_electricidad_option ?? '') == 'TEMPORAL' ? 'checked' : '' }}>
                                    Temporal</label>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Proveedor</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" name="se_electricidad_proveedor_ruc"
                                    value="{{ $format_ii->se_electricidad_proveedor_ruc ?? '' }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                    placeholder="RUC">
                                <input type="text" name="se_electricidad_proveedor"
                                    value="{{ $format_ii->se_electricidad_proveedor ?? '' }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                    placeholder="Proveedor">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- INTERNET -->
            <!-- ============================================ -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-white px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-indigo-800 flex items-center gap-2">
                        <i class="fas fa-wifi"></i> INTERNET
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Servicio de internet del establecimiento</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Cuenta con servicio de
                                internet?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio" name="se_internet"
                                        value="SI" {{ ($format_ii->se_internet ?? '') == 'SI' ? 'checked' : '' }}>
                                    SI</label>
                                <label class="flex items-center gap-2"><input type="radio" name="se_internet"
                                        value="NO" {{ ($format_ii->se_internet ?? '') == 'NO' ? 'checked' : '' }}>
                                    NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Se encuentra
                                operativo?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_internet_operativo" value="SI"
                                        {{ ($format_ii->se_internet_operativo ?? '') == 'SI' ? 'checked' : '' }}>
                                    SI</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_internet_operativo" value="NO"
                                        {{ ($format_ii->se_internet_operativo ?? '') == 'NO' ? 'checked' : '' }}>
                                    NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Situación de servicio</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_internet_estado" value="B"
                                        {{ ($format_ii->se_internet_estado ?? '') == 'B' ? 'checked' : '' }}>
                                    Bueno</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_internet_estado" value="R"
                                        {{ ($format_ii->se_internet_estado ?? '') == 'R' ? 'checked' : '' }}>
                                    Regular</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_internet_estado" value="M"
                                        {{ ($format_ii->se_internet_estado ?? '') == 'M' ? 'checked' : '' }}>
                                    Malo</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Modo de uso</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_internet_option" value="CONTINUO"
                                        {{ ($format_ii->se_internet_option ?? '') == 'CONTINUO' ? 'checked' : '' }}>
                                    Continuo</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="se_internet_option" value="TEMPORAL"
                                        {{ ($format_ii->se_internet_option ?? '') == 'TEMPORAL' ? 'checked' : '' }}>
                                    Temporal</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Dispone de conexión a
                                internet?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio" name="internet_option1"
                                        value="SI"
                                        {{ ($format_ii->internet_option1 ?? '') == 'SI' ? 'checked' : '' }}> SI</label>
                                <label class="flex items-center gap-2"><input type="radio" name="internet_option1"
                                        value="NO"
                                        {{ ($format_ii->internet_option1 ?? '') == 'NO' ? 'checked' : '' }}> NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿De qué operador?</label>
                            <select name="internet_operador"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Seleccione</option>
                                <option value="CLARO"
                                    {{ ($format_ii->internet_operador ?? '') == 'CLARO' ? 'selected' : '' }}>CLARO
                                </option>
                                <option value="MOVISTAR"
                                    {{ ($format_ii->internet_operador ?? '') == 'MOVISTAR' ? 'selected' : '' }}>
                                    MOVISTAR</option>
                                <option value="ENTEL"
                                    {{ ($format_ii->internet_operador ?? '') == 'ENTEL' ? 'selected' : '' }}>ENTEL
                                </option>
                                <option value="BITEL"
                                    {{ ($format_ii->internet_operador ?? '') == 'BITEL' ? 'selected' : '' }}>BITEL
                                </option>
                                <option value="OTRO"
                                    {{ ($format_ii->internet_operador ?? '') == 'OTRO' ? 'selected' : '' }}>OTRO
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Dispone de una red?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio" name="internet_red"
                                        value="CABLEADA"
                                        {{ ($format_ii->internet_red ?? '') == 'CABLEADA' ? 'checked' : '' }}>
                                    Cableada</label>
                                <label class="flex items-center gap-2"><input type="radio" name="internet_red"
                                        value="WI-FI"
                                        {{ ($format_ii->internet_red ?? '') == 'WI-FI' ? 'checked' : '' }}>
                                    Wi-Fi</label>
                                <label class="flex items-center gap-2"><input type="radio" name="internet_red"
                                        value="AMBOS"
                                        {{ ($format_ii->internet_red ?? '') == 'AMBOS' ? 'checked' : '' }}>
                                    Ambos</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Porcentaje de ambientes o
                                servicios que tienen acceso a internet</label>
                            <input type="number" name="internet_porcentaje"
                                value="{{ $format_ii->internet_porcentaje ?? '' }}"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="80" min="0" max="100">
                            <p class="text-xs text-gray-500 mt-1">% (0-100)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Puede transmitir voz, datos,
                                imágenes por la conexión a internet?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="internet_transmision" value="SI"
                                        {{ ($format_ii->internet_transmision ?? '') == 'SI' ? 'checked' : '' }}>
                                    SI</label>
                                <label class="flex items-center gap-2"><input type="radio"
                                        name="internet_transmision" value="NO"
                                        {{ ($format_ii->internet_transmision ?? '') == 'NO' ? 'checked' : '' }}>
                                    NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Continuidad de servicio</label>
                            <select name="internet_option2"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Seleccione</option>
                                <option value="Siempre"
                                    {{ ($format_ii->internet_option2 ?? '') == 'Siempre' ? 'selected' : '' }}>Siempre
                                </option>
                                <option value="Casi siempre"
                                    {{ ($format_ii->internet_option2 ?? '') == 'Casi siempre' ? 'selected' : '' }}>Casi
                                    siempre</option>
                                <option value="A veces"
                                    {{ ($format_ii->internet_option2 ?? '') == 'A veces' ? 'selected' : '' }}>A veces
                                </option>
                                <option value="Casi nunca"
                                    {{ ($format_ii->internet_option2 ?? '') == 'Casi nunca' ? 'selected' : '' }}>Casi
                                    nunca</option>
                                <option value="Nunca"
                                    {{ ($format_ii->internet_option2 ?? '') == 'Nunca' ? 'selected' : '' }}>Nunca
                                </option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Realiza algún servicio de
                                telesalud?</label>
                            <select name="internet_servicio"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Seleccione</option>
                                <option value="SI"
                                    {{ ($format_ii->internet_servicio ?? '') == 'SI' ? 'selected' : '' }}>SI</option>
                                <option value="NO"
                                    {{ ($format_ii->internet_servicio ?? '') == 'NO' ? 'selected' : '' }}>NO</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- TELEVISIÓN -->
            <!-- ============================================ -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-pink-50 to-white px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-pink-800 flex items-center gap-2">
                        <i class="fas fa-tv"></i> TELEVISIÓN
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Servicio de televisión del establecimiento</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Dispone de señal de televisión
                                por cable?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio" name="televicion"
                                        value="SI" {{ ($format_ii->televicion ?? '') == 'SI' ? 'checked' : '' }}>
                                    SI</label>
                                <label class="flex items-center gap-2"><input type="radio" name="televicion"
                                        value="NO" {{ ($format_ii->televicion ?? '') == 'NO' ? 'checked' : '' }}>
                                    NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿De qué operador?</label>
                            <input type="text" name="televicion_operador"
                                value="{{ $format_ii->televicion_operador ?? '' }}"
                                class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                placeholder="Operador">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Las salas de espera disponen
                                de televisores?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio" name="televicion_espera"
                                        value="SI"
                                        {{ ($format_ii->televicion_espera ?? '') == 'SI' ? 'checked' : '' }}>
                                    SI</label>
                                <label class="flex items-center gap-2"><input type="radio" name="televicion_espera"
                                        value="NO"
                                        {{ ($format_ii->televicion_espera ?? '') == 'NO' ? 'checked' : '' }}>
                                    NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Porcentaje de ambientes que
                                tienen televisores</label>
                            <input type="number" name="televicion_porcentaje"
                                value="{{ $format_ii->televicion_porcentaje ?? '' }}"
                                class="w-full rounded-lg border-gray-300 focus:border-pink-500 focus:ring-pink-500"
                                placeholder="50" min="0" max="100">
                            <p class="text-xs text-gray-500 mt-1">% (0-100)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Cuenta con antena de radio de
                                telecomunicación?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio" name="televicion_antena"
                                        value="SI"
                                        {{ ($format_ii->televicion_antena ?? '') == 'SI' ? 'checked' : '' }}>
                                    SI</label>
                                <label class="flex items-center gap-2"><input type="radio" name="televicion_antena"
                                        value="NO"
                                        {{ ($format_ii->televicion_antena ?? '') == 'NO' ? 'checked' : '' }}>
                                    NO</label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">¿Cuenta con equipo de
                                telecomunicación?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2"><input type="radio" name="televicion_equipo"
                                        value="SI"
                                        {{ ($format_ii->televicion_equipo ?? '') == 'SI' ? 'checked' : '' }}>
                                    SI</label>
                                <label class="flex items-center gap-2"><input type="radio" name="televicion_equipo"
                                        value="NO"
                                        {{ ($format_ii->televicion_equipo ?? '') == 'NO' ? 'checked' : '' }}>
                                    NO</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
