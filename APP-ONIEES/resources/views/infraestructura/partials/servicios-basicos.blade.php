<div class="px-6 py-5 border-b border-gray-100">
    <div class="flex items-center gap-3">
        <div class="w-1 h-8 bg-teal-500 rounded-full"></div>
        <div>
            <h3 class="text-base font-semibold text-gray-800">SERVICIOS BÁSICOS DEL ESTABLECIMIENTO</h3>
            <p class="text-xs text-gray-500 mt-0.5">Agua, electricidad, comunicaciones y más</p>
        </div>
    </div>
</div>


<!-- ============================================ -->
<!-- AGUA -->
<!-- ============================================ -->
<div id="sec-agua" class="form-section" x-data="sectionCounter('sec-agua', 8)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-cyan-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tint text-cyan-500 text-sm"></i>
                </div>
                1. Agua
                <span class="section-badge">Servicio básico</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Abastecimiento y calidad del agua</p>
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
                :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'">
            </div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-5 space-y-5">
            <!-- Origen del agua -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            El agua que utilizan en la IPRESS procede principalmente de: <span
                                class="text-cyan-500">*</span>
                        </label>
                        <select name="se_agua" id="se_agua"
                            class="w-full rounded-lg border-gray-200 bg-white focus:border-cyan-400 focus:ring-cyan-400 text-sm">
                            <option value="">Seleccione</option>
                            <option value="RP"
                                {{ old('se_agua', $format_ii->se_agua ?? '') == 'RP' ? 'selected' : '' }}>Red Pública
                            </option>
                            <option value="CCS"
                                {{ old('se_agua', $format_ii->se_agua ?? '') == 'CCS' ? 'selected' : '' }}>
                                Camion-cisterna u otro similar</option>
                            <option value="P"
                                {{ old('se_agua', $format_ii->se_agua ?? '') == 'P' ? 'selected' : '' }}>Pozo</option>
                            <option value="MP"
                                {{ old('se_agua', $format_ii->se_agua ?? '') == 'MP' ? 'selected' : '' }}>Manantial o
                                puquio</option>
                            <option value="RALL"
                                {{ old('se_agua', $format_ii->se_agua ?? '') == 'RALL' ? 'selected' : '' }}>Rio,
                                acequia, lago, laguna</option>
                            <option value="O"
                                {{ old('se_agua', $format_ii->se_agua ?? '') == 'O' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div id="se_agua_otro_div"
                        style="display: {{ old('se_agua', $format_ii->se_agua ?? '') == 'O' ? 'block' : 'none' }};">
                        <label
                            class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Especifique
                            otro origen del agua:</label>
                        <input type="text" name="se_agua_otro"
                            value="{{ old('se_agua_otro', $format_ii->se_agua_otro ?? '') }}"
                            class="w-full rounded-lg border-gray-200 bg-white focus:border-cyan-400 focus:ring-cyan-400 text-sm"
                            placeholder="Ej: Agua embotellada, etc.">
                    </div>
                </div>
            </div>

            <!-- Operatividad y estado de conservación -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">¿Se
                            encuentra operativo? <span class="text-cyan-500">*</span></label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_agua_operativo" value="SI"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_agua_operativo', $format_ii->se_agua_operativo ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">SI</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_agua_operativo" value="NO"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_agua_operativo', $format_ii->se_agua_operativo ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Estado de
                            conservación: <span class="text-cyan-500">*</span></label>
                        <div class="flex gap-5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_agua_estado" value="B"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_agua_estado" value="R"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_agua_estado" value="M"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Días y horas de servicio -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">¿La IPRESS
                            tiene el servicio de agua todos los días de la semana? <span
                                class="text-cyan-500">*</span></label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_sevicio_semana" value="SI"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_sevicio_semana', $format_ii->se_sevicio_semana ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">SI</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_sevicio_semana" value="NO"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_sevicio_semana', $format_ii->se_sevicio_semana ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Horas al
                            día: <span class="text-cyan-500">*</span></label>
                        <input type="number" name="se_horas_dia" id="se_horas_dia"
                            value="{{ old('se_horas_dia', $format_ii->se_horas_dia ?? '24') }}"
                            class="w-full rounded-lg border-gray-200 bg-white focus:border-cyan-400 focus:ring-cyan-400 text-sm"
                            min="0" max="24" step="1">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Horas a la
                        semana:</label>
                    <input type="number" name="se_sevicio_semana_calculo" id="se_sevicio_semana_calculo"
                        value="{{ old('se_sevicio_semana_calculo', $format_ii->se_sevicio_semana_calculo ?? '168') }}"
                        class="w-full rounded-lg border-gray-200 bg-gray-100 text-sm" readonly>
                </div>
            </div>

            <!-- Pago del servicio -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">¿Pagan
                            por el servicio de agua? <span class="text-cyan-500">*</span></label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_servicio_agua" value="SI" id="se_agua_paga_si"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">SI</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_servicio_agua" value="NO" id="se_agua_paga_no"
                                    class="w-4 h-4 text-cyan-500 focus:ring-cyan-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>
                    <div id="se_agua_empresa_div"
                        style="display: {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">¿A qué
                            empresa o entidad se paga por el servicio de agua? <span
                                class="text-cyan-500">*</span></label>
                        <select name="se_empresa_agua" id="se_agua_empresa"
                            class="w-full rounded-lg border-gray-200 bg-white focus:border-cyan-400 focus:ring-cyan-400 text-sm">
                            <option value="">Seleccione</option>
                            <option value="EPS"
                                {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'EPS' ? 'selected' : '' }}>
                                Empresa prestadora de servicio</option>
                            <option value="M"
                                {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'M' ? 'selected' : '' }}>
                                Municipalidad</option>
                            <option value="PC"
                                {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'PC' ? 'selected' : '' }}>
                                Organización comunal</option>
                            <option value="C"
                                {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'C' ? 'selected' : '' }}>
                                Camion cisterna (pago directo)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- ============================================ -->
<!-- DESAGÜE / ALCANTARILLADO -->
<!-- ============================================ -->
<div id="sec-desague" class="form-section" x-data="sectionCounter('sec-desague')" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-toilet text-green-500 text-sm"></i>
                </div>
                2. Desagüe / Alcantarillado
                <span class="section-badge">Servicio básico</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Sistema de evacuación de aguas residuales</p>
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
        <div class="p-5 space-y-5">
            <!-- Tipo de servicio -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Tipo de servicio <span class="text-green-500">*</span>
                        </label>
                        <select name="se_desague" id="se_desague"
                            class="w-full rounded-lg border-gray-200 bg-white focus:border-green-400 focus:ring-green-400 text-sm">
                            <option value="">Seleccione</option>
                            <option value="RPD"
                                {{ old('se_desague', $format_ii->se_desague ?? '') == 'RPD' ? 'selected' : '' }}>Red
                                pública de desagüe dentro de la IPRESS</option>
                            <option value="RPF"
                                {{ old('se_desague', $format_ii->se_desague ?? '') == 'RPF' ? 'selected' : '' }}>Red
                                pública de desagüe fuera de la IPRESS</option>
                            <option value="P"
                                {{ old('se_desague', $format_ii->se_desague ?? '') == 'P' ? 'selected' : '' }}>Pozo
                                séptico, tanque séptico, séptico biogestor</option>
                            <option value="L"
                                {{ old('se_desague', $format_ii->se_desague ?? '') == 'L' ? 'selected' : '' }}>Letrina
                                (con tratamiento)</option>
                            <option value="PN"
                                {{ old('se_desague', $format_ii->se_desague ?? '') == 'PN' ? 'selected' : '' }}>Pozo
                                ciego o negro</option>
                            <option value="OTR"
                                {{ old('se_desague', $format_ii->se_desague ?? '') == 'OTR' ? 'selected' : '' }}>Otro
                            </option>
                        </select>
                    </div>
                    <div id="se_desague_otro_div"
                        style="display: {{ old('se_desague', $format_ii->se_desague ?? '') == 'OTR' ? 'block' : 'none' }};">
                        <label
                            class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Especifique
                            otro tipo de servicio</label>
                        <input type="text" name="se_desague_otro"
                            value="{{ old('se_desague_otro', $format_ii->se_desague_otro ?? '') }}"
                            class="w-full rounded-lg border-gray-200 bg-white focus:border-green-400 focus:ring-green-400 text-sm"
                            placeholder="Ej: Canal abierto, etc.">
                    </div>
                </div>
            </div>

            <!-- Operatividad y estado de conservación -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">¿Se
                            encuentra operativo? <span class="text-green-500">*</span></label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_desague_operativo" value="SI"
                                    class="w-4 h-4 text-green-500 focus:ring-green-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_desague_operativo', $format_ii->se_desague_operativo ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">SI</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_desague_operativo" value="NO"
                                    class="w-4 h-4 text-green-500 focus:ring-green-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_desague_operativo', $format_ii->se_desague_operativo ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Estado de
                            conservación <span class="text-green-500">*</span></label>
                        <div class="flex gap-5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_desague_estado" value="B"
                                    class="w-4 h-4 text-green-500 focus:ring-green-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_desague_estado" value="R"
                                    class="w-4 h-4 text-green-500 focus:ring-green-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_desague_estado" value="M"
                                    class="w-4 h-4 text-green-500 focus:ring-green-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar campo "Otro" en Desagüe
        const se_desague = document.getElementById('se_desague');
        const se_desague_otro_div = document.getElementById('se_desague_otro_div');

        if (se_desague && se_desague_otro_div) {
            se_desague.addEventListener('change', function() {
                if (this.value === 'OTR') {
                    se_desague_otro_div.style.display = 'block';
                } else {
                    se_desague_otro_div.style.display = 'none';
                    const input = se_desague_otro_div.querySelector('input');
                    if (input) input.value = '';
                }
            });
        }
    });
</script>


<!-- ============================================ -->
<!-- ELECTRICIDAD -->
<!-- ============================================ -->
<div id="sec-electricidad" class="form-section" x-data="sectionCounter('sec-electricidad', 6)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-yellow-500 text-sm"></i>
                </div>
                3. Electricidad
                <span class="section-badge">Servicio básico</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Suministro eléctrico del establecimiento</p>
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
        <div class="p-5 space-y-5">

            <!-- ¿Cuenta con servicio de electricidad? -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            ¿Cuenta con servicio de electricidad? <span class="text-yellow-500">*</span>
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_electricidad" value="SI" id="se_electricidad_si"
                                    class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_electricidad', $format_ii->se_electricidad ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">SI</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_electricidad" value="NO" id="se_electricidad_no"
                                    class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_electricidad', $format_ii->se_electricidad ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>

                    <!-- ¿Se encuentra operativo? (visible solo si tiene electricidad = SI) -->
                    <div id="se_electricidad_operativo_div"
                        style="display: {{ old('se_electricidad', $format_ii->se_electricidad ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            ¿Se encuentra operativo? <span class="text-yellow-500">*</span>
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_electricidad_operativo" value="SI"
                                    class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_electricidad_operativo', $format_ii->se_electricidad_operativo ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">SI</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_electricidad_operativo" value="NO"
                                    class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_electricidad_operativo', $format_ii->se_electricidad_operativo ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>

                    <!-- Situación/Estado de conservación (visible solo si tiene electricidad = SI) -->
                    <div id="se_electricidad_estado_div"
                        style="display: {{ old('se_electricidad', $format_ii->se_electricidad ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Situación de servicio / Estado de conservación <span class="text-yellow-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_electricidad_estado" value="B"
                                    class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_electricidad_estado', $format_ii->se_electricidad_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_electricidad_estado" value="R"
                                    class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_electricidad_estado', $format_ii->se_electricidad_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_electricidad_estado" value="M"
                                    class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_electricidad_estado', $format_ii->se_electricidad_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modo de uso (visible solo si tiene electricidad = SI) -->
            <div id="se_electricidad_option_div"
                style="display: {{ old('se_electricidad', $format_ii->se_electricidad ?? '') == 'SI' ? 'block' : 'none' }};">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                Modo de uso <span class="text-yellow-500">*</span>
                            </label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="se_electricidad_option" value="C"
                                        class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                        {{ old('se_electricidad_option', $format_ii->se_electricidad_option ?? '') == 'C' ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">CONTINUO</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="se_electricidad_option" value="T"
                                        class="w-4 h-4 text-yellow-500 focus:ring-yellow-400 focus:ring-offset-0 border-gray-300"
                                        {{ old('se_electricidad_option', $format_ii->se_electricidad_option ?? '') == 'T' ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">TEMPORAL</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fuente / Proveedor -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Fuente de electricidad / Nombre del proveedor
                        </label>
                        <input type="text" name="se_electricidad_fuente"
                            value="{{ old('se_electricidad_fuente', $format_ii->se_electricidad_fuente ?? '') }}"
                            class="w-full rounded-lg border-gray-200 bg-white focus:border-yellow-400 focus:ring-yellow-400 text-sm"
                            placeholder="Ej: Electrocentro, ENEL, etc.">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            RUC del proveedor
                        </label>
                        <input type="text" name="se_electricidad_proveedor_ruc"
                            value="{{ old('se_electricidad_proveedor_ruc', $format_ii->se_electricidad_proveedor_ruc ?? '') }}"
                            class="w-full rounded-lg border-gray-200 bg-white focus:border-yellow-400 focus:ring-yellow-400 text-sm"
                            placeholder="Ej: 20123456789" maxlength="11">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<!-- ============================================ -->
<!-- TELEFONÍA FIJA -->
<!-- ============================================ -->
<div id="sec-telefonia" class="form-section" x-data="sectionCounter('sec-telefonia', 6)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-phone text-purple-500 text-sm"></i>
                </div>
                4. Telefonía Fija
                <span class="section-badge">Servicio básico</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Servicio de telefonía fija del establecimiento</p>
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
        <div class="p-5 space-y-5">

            <!-- ¿Cuenta con servicio de telefonía fija? -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            ¿Cuenta con servicio de telefonía fija? <span class="text-purple-500">*</span>
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_telefonia" value="SI" id="se_telefonia_si"
                                    class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_telefonia', $format_ii->se_telefonia ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">SI</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_telefonia" value="NO" id="se_telefonia_no"
                                    class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_telefonia', $format_ii->se_telefonia ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>

                    <!-- ¿Se encuentra operativo? (visible solo si tiene telefonía = SI) -->
                    <div id="se_telefonia_operativo_div"
                        style="display: {{ old('se_telefonia', $format_ii->se_telefonia ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            ¿Se encuentra operativo? <span class="text-purple-500">*</span>
                        </label>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_telefonia_operativo" value="SI"
                                    class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_telefonia_operativo', $format_ii->se_telefonia_operativo ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">SI</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_telefonia_operativo" value="NO"
                                    class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_telefonia_operativo', $format_ii->se_telefonia_operativo ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">NO</span>
                            </label>
                        </div>
                    </div>

                    <!-- Situación/Estado de conservación (visible solo si tiene telefonía = SI) -->
                    <div id="se_telefonia_estado_div"
                        style="display: {{ old('se_telefonia', $format_ii->se_telefonia ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Situación de servicio / Estado de conservación <span class="text-purple-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_telefonia_estado" value="B"
                                    class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_telefonia_estado', $format_ii->se_telefonia_estado ?? '') == 'B' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Bueno (B)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_telefonia_estado" value="R"
                                    class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_telefonia_estado', $format_ii->se_telefonia_estado ?? '') == 'R' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Regular (R)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="se_telefonia_estado" value="M"
                                    class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                    {{ old('se_telefonia_estado', $format_ii->se_telefonia_estado ?? '') == 'M' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Malo (M)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modo de uso y Proveedor (visible solo si tiene telefonía = SI) -->
            <div id="se_telefonia_option_div"
                style="display: {{ old('se_telefonia', $format_ii->se_telefonia ?? '') == 'SI' ? 'block' : 'none' }};">

                <!-- Modo de uso -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 mb-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                Modo de uso <span class="text-purple-500">*</span>
                            </label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="se_telefonia_option" value="C"
                                        class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                        {{ old('se_telefonia_option', $format_ii->se_telefonia_option ?? '') == 'C' ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">CONTINUO</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="se_telefonia_option" value="T"
                                        class="w-4 h-4 text-purple-500 focus:ring-purple-400 focus:ring-offset-0 border-gray-300"
                                        {{ old('se_telefonia_option', $format_ii->se_telefonia_option ?? '') == 'T' ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">TEMPORAL</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fuente / Proveedor -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                Nombre del proveedor
                            </label>
                            <input type="text" name="se_telefonia_proveedor"
                                value="{{ old('se_telefonia_proveedor', $format_ii->se_telefonia_proveedor ?? '') }}"
                                class="w-full rounded-lg border-gray-200 bg-white focus:border-purple-400 focus:ring-purple-400 text-sm"
                                placeholder="Ej: Claro, Movistar, etc.">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                RUC del proveedor
                            </label>
                            <input type="text" name="se_telefonia_proveedor_ruc"
                                value="{{ old('se_telefonia_proveedor_ruc', $format_ii->se_telefonia_proveedor_ruc ?? '') }}"
                                class="w-full rounded-lg border-gray-200 bg-white focus:border-purple-400 focus:ring-purple-400 text-sm"
                                placeholder="Ej: 20123456789" maxlength="11">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- ============================================ -->
<!-- INTERNET -->
<!-- ============================================ -->
<div id="sec-internet" class="form-section" x-data="sectionCounter('sec-internet', 14)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wifi text-indigo-500 text-sm"></i>
                </div>
                5. Internet
                <span class="section-badge">Servicio básico</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Conectividad y servicios de internet</p>
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
        <div class="p-4 space-y-3">
            <!-- ¿Cuenta con servicio de internet? -->
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con servicio de internet?
                            <span class="text-indigo-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_internet" value="SI" id="se_internet_si"
                                    class="w-3.5 h-3.5 text-indigo-500"
                                    {{ old('se_internet', $format_ii->se_internet ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_internet" value="NO" id="se_internet_no"
                                    class="w-3.5 h-3.5 text-indigo-500"
                                    {{ old('se_internet', $format_ii->se_internet ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                    <div id="se_internet_operativo_div"
                        style="display: {{ old('se_internet', $format_ii->se_internet ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Se encuentra operativo? <span
                                class="text-indigo-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                    name="se_internet_operativo" value="SI" class="w-3.5 h-3.5 text-indigo-500"
                                    {{ old('se_internet_operativo', $format_ii->se_internet_operativo ?? '') == 'SI' ? 'checked' : '' }}><span
                                    class="text-sm">SI</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                    name="se_internet_operativo" value="NO" class="w-3.5 h-3.5 text-indigo-500"
                                    {{ old('se_internet_operativo', $format_ii->se_internet_operativo ?? '') == 'NO' ? 'checked' : '' }}><span
                                    class="text-sm">NO</span></label>
                        </div>
                    </div>
                    <div id="se_internet_estado_div"
                        style="display: {{ old('se_internet', $format_ii->se_internet ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado conservación <span
                                class="text-indigo-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio"
                                    name="se_internet_estado" value="B" class="w-3.5 h-3.5 text-indigo-500"
                                    {{ old('se_internet_estado', $format_ii->se_internet_estado ?? '') == 'B' ? 'checked' : '' }}><span
                                    class="text-xs">B</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio"
                                    name="se_internet_estado" value="R" class="w-3.5 h-3.5 text-indigo-500"
                                    {{ old('se_internet_estado', $format_ii->se_internet_estado ?? '') == 'R' ? 'checked' : '' }}><span
                                    class="text-xs">R</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio"
                                    name="se_internet_estado" value="M" class="w-3.5 h-3.5 text-indigo-500"
                                    {{ old('se_internet_estado', $format_ii->se_internet_estado ?? '') == 'M' ? 'checked' : '' }}><span
                                    class="text-xs">M</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campos condicionales (solo si tiene internet = SI) -->
            <div id="se_internet_option_div"
                style="display: {{ old('se_internet', $format_ii->se_internet ?? '') == 'SI' ? 'block' : 'none' }};"
                class="space-y-3">

                <!-- Modo de uso + Proveedor + RUC -->
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Modo de uso <span
                                    class="text-indigo-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                        name="se_internet_option" value="C" class="w-3.5 h-3.5 text-indigo-500"
                                        {{ old('se_internet_option', $format_ii->se_internet_option ?? '') == 'C' ? 'checked' : '' }}><span
                                        class="text-sm">CONTINUO</span></label>
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                        name="se_internet_option" value="T" class="w-3.5 h-3.5 text-indigo-500"
                                        {{ old('se_internet_option', $format_ii->se_internet_option ?? '') == 'T' ? 'checked' : '' }}><span
                                        class="text-sm">TEMPORAL</span></label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Proveedor</label>
                            <input type="text" name="se_internet_proveedor"
                                value="{{ old('se_internet_proveedor', $format_ii->se_internet_proveedor ?? '') }}"
                                class="w-full rounded-md border-gray-200 text-sm py-1.5"
                                placeholder="Ej: Claro, Movistar">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">RUC del proveedor</label>
                            <input type="text" name="se_internet_proveedor_ruc"
                                value="{{ old('se_internet_proveedor_ruc', $format_ii->se_internet_proveedor_ruc ?? '') }}"
                                class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: 20123456789"
                                maxlength="11">
                        </div>
                    </div>
                </div>

                <!-- ¿Dispone de conexión a internet? + Operador -->
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">¿Dispone de conexión a
                                internet? <span class="text-indigo-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                        name="internet_conexion" value="SI" id="internet_conexion_si"
                                        class="w-3.5 h-3.5 text-indigo-500"
                                        {{ old('internet_conexion', $format_ii->internet ?? '') == 'SI' ? 'checked' : '' }}><span
                                        class="text-sm">SI</span></label>
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                        name="internet_conexion" value="NO" id="internet_conexion_no"
                                        class="w-3.5 h-3.5 text-indigo-500"
                                        {{ old('internet_conexion', $format_ii->internet ?? '') == 'NO' ? 'checked' : '' }}><span
                                        class="text-sm">NO</span></label>
                            </div>
                        </div>
                        <div id="internet_operador_div"
                            style="display: {{ old('internet_conexion', $format_ii->internet ?? '') == 'SI' ? 'block' : 'none' }};">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">¿De qué operador? <span
                                    class="text-indigo-500">*</span></label>
                            <select name="internet_operador" class="w-full rounded-md border-gray-200 text-sm py-1.5">
                                <option value="">Seleccione</option>
                                <option value="CLARO"
                                    {{ old('internet_operador', $format_ii->internet_operador ?? '') == 'CLARO' ? 'selected' : '' }}>
                                    CLARO</option>
                                <option value="MOVISTAR"
                                    {{ old('internet_operador', $format_ii->internet_operador ?? '') == 'MOVISTAR' ? 'selected' : '' }}>
                                    MOVISTAR</option>
                                <option value="ENTEL"
                                    {{ old('internet_operador', $format_ii->internet_operador ?? '') == 'ENTEL' ? 'selected' : '' }}>
                                    ENTEL</option>
                                <option value="BITEL"
                                    {{ old('internet_operador', $format_ii->internet_operador ?? '') == 'BITEL' ? 'selected' : '' }}>
                                    BITEL</option>
                                <option value="OTRO"
                                    {{ old('internet_operador', $format_ii->internet_operador ?? '') == 'OTRO' ? 'selected' : '' }}>
                                    OTRO</option>
                            </select>
                        </div>
                    </div>
                </div>
               <!-- ¿Dispone de una red? + Continuidad de servicio (Temporal) -->
<div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">¿Dispone de una red? <span class="text-indigo-500">*</span></label>
            <div class="flex gap-3">
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="radio" name="internet_red" value="CABLEADA" class="w-3.5 h-3.5 text-indigo-500" {{ old('internet_red', $format_ii->internet_red ?? '') == 'CABLEADA' ? 'checked' : '' }}>
                    <span class="text-sm">CABLEADA</span>
                </label>
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="radio" name="internet_red" value="WI-FI" class="w-3.5 h-3.5 text-indigo-500" {{ old('internet_red', $format_ii->internet_red ?? '') == 'WI-FI' ? 'checked' : '' }}>
                    <span class="text-sm">WI-FI</span>
                </label>
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="radio" name="internet_red" value="AMBAS" class="w-3.5 h-3.5 text-indigo-500" {{ old('internet_red', $format_ii->internet_red ?? '') == 'AMBAS' ? 'checked' : '' }}>
                    <span class="text-sm">AMBAS</span>
                </label>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Continuidad de servicio <span class="text-indigo-500">*</span></label>
            <select name="internet_continuidad" class="w-full rounded-md border-gray-200 text-sm py-1.5">
                <option value="">Seleccione</option>
                <option value="T" {{ old('internet_continuidad', $format_ii->internet_option1 ?? '') == 'T' ? 'selected' : '' }}>Temporal</option>
                <option value="P" {{ old('internet_continuidad', $format_ii->internet_option1 ?? '') == 'P' ? 'selected' : '' }}>Permanente</option>
                <option value="N" {{ old('internet_continuidad', $format_ii->internet_option1 ?? '') == 'N' ? 'selected' : '' }}>Nunca</option>
            </select>
        </div>
    </div>
</div>



                <!-- Porcentaje + Transmisión -->
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">% ambientes con internet
                                <span class="text-indigo-500">*</span></label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="internet_porcentaje"
                                    value="{{ old('internet_porcentaje', $format_ii->internet_porcentaje ?? '80') }}"
                                    class="w-20 rounded-md border-gray-200 text-sm py-1.5 text-center" min="0"
                                    max="100" step="1">
                                <span class="text-xs text-gray-500">% (0-100)</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">¿Transmite voz, datos,
                                imágenes? <span class="text-indigo-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                        name="internet_transmision" value="SI"
                                        class="w-3.5 h-3.5 text-indigo-500"
                                        {{ old('internet_transmision', $format_ii->internet_transmision ?? '') == 'SI' ? 'checked' : '' }}><span
                                        class="text-sm">SI</span></label>
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                        name="internet_transmision" value="NO"
                                        class="w-3.5 h-3.5 text-indigo-500"
                                        {{ old('internet_transmision', $format_ii->internet_transmision ?? '') == 'NO' ? 'checked' : '' }}><span
                                        class="text-sm">NO</span></label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Continuidad de servicio (Siempre) + Telesalud -->
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Continuidad de servicio <span
                                    class="text-indigo-500">*</span></label>
                            <select name="internet_option2" class="w-full rounded-md border-gray-200 text-sm py-1.5">
                                <option value="">Seleccione</option>
                                <option value="S"
                                    {{ old('internet_option2', $format_ii->internet_option2 ?? '') == 'S' ? 'selected' : '' }}>
                                    Siempre</option>
                                <option value="P"
                                    {{ old('internet_option2', $format_ii->internet_option2 ?? '') == 'P' ? 'selected' : '' }}>
                                    Por las Noches</option>
                                <option value="N"
                                    {{ old('internet_option2', $format_ii->internet_option2 ?? '') == 'N' ? 'selected' : '' }}>
                                    Nunca</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">¿Realiza servicios de
                                telesalud? <span class="text-indigo-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                        name="internet_servicio" value="SI" class="w-3.5 h-3.5 text-indigo-500"
                                        {{ old('internet_servicio', $format_ii->internet_servicio ?? '') == 'SI' ? 'checked' : '' }}><span
                                        class="text-sm">SI</span></label>
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio"
                                        name="internet_servicio" value="NO" class="w-3.5 h-3.5 text-indigo-500"
                                        {{ old('internet_servicio', $format_ii->internet_servicio ?? '') == 'NO' ? 'checked' : '' }}><span
                                        class="text-sm">NO</span></label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- TELEVISIÓN -->
<!-- ============================================ -->
<div id="sec-television" class="form-section" x-data="sectionCounter('sec-television',7)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tv text-red-500 text-sm"></i>
                </div>
                6. Televisión
                <span class="section-badge">Servicio de televisión</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Señal de televisión y equipamiento</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
            <div class="counter-bar">
                <div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-4 space-y-3">

            <!-- ¿Dispone de señal de televisión por cable? + Operador -->
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Dispone de señal de televisión por cable? <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="televicion" value="SI" id="televicion_si" class="w-3.5 h-3.5 text-red-500" {{ old('televicion', $format_ii->televicion ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="televicion" value="NO" id="televicion_no" class="w-3.5 h-3.5 text-red-500" {{ old('televicion', $format_ii->televicion ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                    <div id="televicion_operador_div" style="display: {{ old('televicion', $format_ii->televicion ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿De qué operador? <span class="text-red-500">*</span></label>
                        <input type="text" name="televicion_operador" value="{{ old('televicion_operador', $format_ii->televicion_operador ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: Claro, Movistar, DirecTV">
                    </div>
                </div>
            </div>

            <!-- Continuidad de servicio (solo si tiene televisión = SI) -->
            <div id="televicion_option_div" style="display: {{ old('televicion', $format_ii->televicion ?? '') == 'SI' ? 'block' : 'none' }};">
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Continuidad de servicio <span class="text-red-500">*</span></label>
                            <select name="televicion_option1" class="w-full rounded-md border-gray-200 text-sm py-1.5">
                                <option value="">Seleccione</option>
                                <option value="S" {{ old('televicion_option1', $format_ii->televicion_option1 ?? '') == 'S' ? 'selected' : '' }}>Siempre</option>
                                <option value="T" {{ old('televicion_option1', $format_ii->televicion_option1 ?? '') == 'T' ? 'selected' : '' }}>Temporal</option>
                                <option value="N" {{ old('televicion_option1', $format_ii->televicion_option1 ?? '') == 'N' ? 'selected' : '' }}>Nunca</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ¿Las salas de espera disponen de televisores? + Porcentaje -->
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Las salas de espera disponen de televisores? <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="televicion_espera" value="SI" id="televicion_espera_si" class="w-3.5 h-3.5 text-red-500" {{ old('televicion_espera', $format_ii->televicion_espera ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="televicion_espera" value="NO" id="televicion_espera_no" class="w-3.5 h-3.5 text-red-500" {{ old('televicion_espera', $format_ii->televicion_espera ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                    <div id="televicion_porcentaje_div" style="display: {{ old('televicion_espera', $format_ii->televicion_espera ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Porcentaje de ambientes con televisores <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="televicion_porcentaje" value="{{ old('televicion_porcentaje', $format_ii->televicion_porcentaje ?? '50') }}" class="w-20 rounded-md border-gray-200 text-sm py-1.5 text-center" min="0" max="100" step="1">
                            <span class="text-xs text-gray-500">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Antena + Equipo de telecomunicación -->
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con antena de radio de telecomunicación? <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="televicion_antena" value="SI" class="w-3.5 h-3.5 text-red-500" {{ old('televicion_antena', $format_ii->televicion_antena ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="televicion_antena" value="NO" class="w-3.5 h-3.5 text-red-500" {{ old('televicion_antena', $format_ii->televicion_antena ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con equipo de telecomunicación? <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="televicion_equipo" value="SI" class="w-3.5 h-3.5 text-red-500" {{ old('televicion_equipo', $format_ii->televicion_equipo ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="televicion_equipo" value="NO" class="w-3.5 h-3.5 text-red-500" {{ old('televicion_equipo', $format_ii->televicion_equipo ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<!-- ============================================ -->
<!-- RED MÓVIL -->
<!-- ============================================ -->
<div id="sec-red-movil" class="form-section" x-data="sectionCounter('sec-red-movil',6)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-signal text-blue-500 text-sm"></i>
                </div>
                7. Red Móvil
                <span class="section-badge">Servicio móvil</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Cobertura y servicio de telefonía móvil</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
            <div class="counter-bar">
                <div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-4 space-y-3">

            <!-- ¿Cuenta con servicio de red móvil? + Operativo + Estado -->
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con servicio de red móvil? <span class="text-blue-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_red" value="SI" id="se_red_si" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red', $format_ii->se_red ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_red" value="NO" id="se_red_no" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red', $format_ii->se_red ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                    <div id="se_red_operativo_div" style="display: {{ old('se_red', $format_ii->se_red ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Se encuentra operativo? <span class="text-blue-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_red_operativo" value="SI" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red_operativo', $format_ii->se_red_operativo ?? '') == 'SI' ? 'checked' : '' }}><span class="text-sm">SI</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_red_operativo" value="NO" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red_operativo', $format_ii->se_red_operativo ?? '') == 'NO' ? 'checked' : '' }}><span class="text-sm">NO</span></label>
                        </div>
                    </div>
                    <div id="se_red_estado_div" style="display: {{ old('se_red', $format_ii->se_red ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado conservación <span class="text-blue-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_red_estado" value="B" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red_estado', $format_ii->se_red_estado ?? '') == 'B' ? 'checked' : '' }}><span class="text-xs">B</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_red_estado" value="R" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red_estado', $format_ii->se_red_estado ?? '') == 'R' ? 'checked' : '' }}><span class="text-xs">R</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_red_estado" value="M" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red_estado', $format_ii->se_red_estado ?? '') == 'M' ? 'checked' : '' }}><span class="text-xs">M</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campos condicionales (solo si tiene red móvil = SI) -->
            <div id="se_red_option_div" style="display: {{ old('se_red', $format_ii->se_red ?? '') == 'SI' ? 'block' : 'none' }};" class="space-y-3">

                <!-- Modo de uso + Proveedor + RUC -->
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Modo de uso <span class="text-blue-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_red_option" value="C" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red_option', $format_ii->se_red_option ?? '') == 'C' ? 'checked' : '' }}><span class="text-sm">CONTINUO</span></label>
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_red_option" value="T" class="w-3.5 h-3.5 text-blue-500" {{ old('se_red_option', $format_ii->se_red_option ?? '') == 'T' ? 'checked' : '' }}><span class="text-sm">TEMPORAL</span></label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Proveedor</label>
                            <input type="text" name="se_red_proveedor" value="{{ old('se_red_proveedor', $format_ii->se_red_proveedor ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: Claro, Movistar, Entel">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">RUC del proveedor</label>
                            <input type="text" name="se_red_proveedor_ruc" value="{{ old('se_red_proveedor_ruc', $format_ii->se_red_proveedor_ruc ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: 20123456789" maxlength="11">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- ============================================ -->
<!-- GAS NATURAL O GLP -->
<!-- ============================================ -->
<div id="sec-gas" class="form-section" x-data="sectionCounter('sec-gas',6)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-fire text-orange-500 text-sm"></i>
                </div>
                8. Gas Natural o GLP
                <span class="section-badge">Combustible</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Suministro de gas para el establecimiento</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
            <div class="counter-bar">
                <div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-4 space-y-3">

            <!-- ¿Cuenta con servicio de gas? + Operativo + Estado -->
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con servicio de gas natural o GLP? <span class="text-orange-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_gas" value="SI" id="se_gas_si" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas', $format_ii->se_gas ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_gas" value="NO" id="se_gas_no" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas', $format_ii->se_gas ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                    <div id="se_gas_operativo_div" style="display: {{ old('se_gas', $format_ii->se_gas ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Se encuentra operativo? <span class="text-orange-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_gas_operativo" value="SI" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas_operativo', $format_ii->se_gas_operativo ?? '') == 'SI' ? 'checked' : '' }}><span class="text-sm">SI</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_gas_operativo" value="NO" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas_operativo', $format_ii->se_gas_operativo ?? '') == 'NO' ? 'checked' : '' }}><span class="text-sm">NO</span></label>
                        </div>
                    </div>
                    <div id="se_gas_estado_div" style="display: {{ old('se_gas', $format_ii->se_gas ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado conservación <span class="text-orange-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_gas_estado" value="B" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas_estado', $format_ii->se_gas_estado ?? '') == 'B' ? 'checked' : '' }}><span class="text-xs">B</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_gas_estado" value="R" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas_estado', $format_ii->se_gas_estado ?? '') == 'R' ? 'checked' : '' }}><span class="text-xs">R</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_gas_estado" value="M" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas_estado', $format_ii->se_gas_estado ?? '') == 'M' ? 'checked' : '' }}><span class="text-xs">M</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campos condicionales (solo si tiene gas = SI) -->
            <div id="se_gas_option_div" style="display: {{ old('se_gas', $format_ii->se_gas ?? '') == 'SI' ? 'block' : 'none' }};" class="space-y-3">

                <!-- Modo de uso + Proveedor + RUC -->
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Modo de uso <span class="text-orange-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_gas_option" value="C" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas_option', $format_ii->se_gas_option ?? '') == 'C' ? 'checked' : '' }}><span class="text-sm">CONTINUO</span></label>
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_gas_option" value="T" class="w-3.5 h-3.5 text-orange-500" {{ old('se_gas_option', $format_ii->se_gas_option ?? '') == 'T' ? 'checked' : '' }}><span class="text-sm">TEMPORAL</span></label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Proveedor</label>
                            <input type="text" name="se_gas_proveedor" value="{{ old('se_gas_proveedor', $format_ii->se_gas_proveedor ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: Calidda, Solgas">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">RUC del proveedor</label>
                            <input type="text" name="se_gas_proveedor_ruc" value="{{ old('se_gas_proveedor_ruc', $format_ii->se_gas_proveedor_ruc ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: 20123456789" maxlength="11">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>





<!-- ============================================ -->
<!-- RESIDUOS SÓLIDOS -->
<!-- ============================================ -->
<div id="sec-residuos-solidos" class="form-section" x-data="sectionCounter('sec-residuos-solidos',6)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trash-alt text-green-500 text-sm"></i>
                </div>
                9. Eliminación de Residuos Sólidos
                <span class="section-badge">Gestión de residuos</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Servicio de recolección y disposición de residuos sólidos</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
            <div class="counter-bar">
                <div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-4 space-y-3">

            <!-- ¿Cuenta con servicio de eliminación de residuos sólidos? + Operativo + Estado -->
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con servicio de eliminación de residuos sólidos? <span class="text-green-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_residuos" value="SI" id="se_residuos_si" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos', $format_ii->se_residuos ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_residuos" value="NO" id="se_residuos_no" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos', $format_ii->se_residuos ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                    <div id="se_residuos_operativo_div" style="display: {{ old('se_residuos', $format_ii->se_residuos ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Se encuentra operativo? <span class="text-green-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_residuos_operativo" value="SI" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos_operativo', $format_ii->se_residuos_operativo ?? '') == 'SI' ? 'checked' : '' }}><span class="text-sm">SI</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_residuos_operativo" value="NO" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos_operativo', $format_ii->se_residuos_operativo ?? '') == 'NO' ? 'checked' : '' }}><span class="text-sm">NO</span></label>
                        </div>
                    </div>
                    <div id="se_residuos_estado_div" style="display: {{ old('se_residuos', $format_ii->se_residuos ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado conservación <span class="text-green-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_residuos_estado" value="B" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos_estado', $format_ii->se_residuos_estado ?? '') == 'B' ? 'checked' : '' }}><span class="text-xs">B</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_residuos_estado" value="R" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos_estado', $format_ii->se_residuos_estado ?? '') == 'R' ? 'checked' : '' }}><span class="text-xs">R</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_residuos_estado" value="M" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos_estado', $format_ii->se_residuos_estado ?? '') == 'M' ? 'checked' : '' }}><span class="text-xs">M</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campos condicionales (solo si tiene residuos = SI) -->
            <div id="se_residuos_option_div" style="display: {{ old('se_residuos', $format_ii->se_residuos ?? '') == 'SI' ? 'block' : 'none' }};" class="space-y-3">

                <!-- Modo de uso + Proveedor + RUC -->
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Modo de uso <span class="text-green-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_residuos_option" value="C" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos_option', $format_ii->se_residuos_option ?? '') == 'C' ? 'checked' : '' }}><span class="text-sm">CONTINUO</span></label>
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_residuos_option" value="T" class="w-3.5 h-3.5 text-green-500" {{ old('se_residuos_option', $format_ii->se_residuos_option ?? '') == 'T' ? 'checked' : '' }}><span class="text-sm">TEMPORAL</span></label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Proveedor</label>
                            <input type="text" name="se_residuos_proveedor" value="{{ old('se_residuos_proveedor', $format_ii->se_residuos_proveedor ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: Municipalidad, empresa privada">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">RUC del proveedor</label>
                            <input type="text" name="se_residuos_proveedor_ruc" value="{{ old('se_residuos_proveedor_ruc', $format_ii->se_residuos_proveedor_ruc ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: 20123456789" maxlength="11">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- ============================================ -->
<!-- RESIDUOS HOSPITALARIOS -->
<!-- ============================================ -->
<div id="sec-residuos-hospitalarios" class="form-section" x-data="sectionCounter('sec-residuos-hospitalarios',6)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-biohazard text-red-500 text-sm"></i>
                </div>
                10. Eliminación de Residuos Hospitalarios
                <span class="section-badge">Gestión de residuos peligrosos</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Servicio especializado para residuos biocontaminados</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
            <div class="counter-bar">
                <div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-4 space-y-3">

            <!-- ¿Cuenta con servicio de eliminación de residuos hospitalarios? + Operativo + Estado -->
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con servicio de eliminación de residuos hospitalarios? <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_residuos_h" value="SI" id="se_residuos_h_si" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h', $format_ii->se_residuos_h ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="se_residuos_h" value="NO" id="se_residuos_h_no" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h', $format_ii->se_residuos_h ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>
                    <div id="se_residuos_h_operativo_div" style="display: {{ old('se_residuos_h', $format_ii->se_residuos_h ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Se encuentra operativo? <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_residuos_h_operativo" value="SI" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h_operativo', $format_ii->se_residuos_h_operativo ?? '') == 'SI' ? 'checked' : '' }}><span class="text-sm">SI</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_residuos_h_operativo" value="NO" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h_operativo', $format_ii->se_residuos_h_operativo ?? '') == 'NO' ? 'checked' : '' }}><span class="text-sm">NO</span></label>
                        </div>
                    </div>
                    <div id="se_residuos_h_estado_div" style="display: {{ old('se_residuos_h', $format_ii->se_residuos_h ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado conservación <span class="text-red-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_residuos_h_estado" value="B" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h_estado', $format_ii->se_residuos_h_estado ?? '') == 'B' ? 'checked' : '' }}><span class="text-xs">B</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_residuos_h_estado" value="R" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h_estado', $format_ii->se_residuos_h_estado ?? '') == 'R' ? 'checked' : '' }}><span class="text-xs">R</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="se_residuos_h_estado" value="M" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h_estado', $format_ii->se_residuos_h_estado ?? '') == 'M' ? 'checked' : '' }}><span class="text-xs">M</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campos condicionales (solo si tiene residuos hospitalarios = SI) -->
            <div id="se_residuos_h_option_div" style="display: {{ old('se_residuos_h', $format_ii->se_residuos_h ?? '') == 'SI' ? 'block' : 'none' }};" class="space-y-3">

                <!-- Modo de uso + Proveedor + RUC -->
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Modo de uso <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_residuos_h_option" value="C" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h_option', $format_ii->se_residuos_h_option ?? '') == 'C' ? 'checked' : '' }}><span class="text-sm">CONTINUO</span></label>
                                <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="se_residuos_h_option" value="T" class="w-3.5 h-3.5 text-red-500" {{ old('se_residuos_h_option', $format_ii->se_residuos_h_option ?? '') == 'T' ? 'checked' : '' }}><span class="text-sm">TEMPORAL</span></label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Proveedor</label>
                            <input type="text" name="se_residuos_h_proveedor" value="{{ old('se_residuos_h_proveedor', $format_ii->se_residuos_h_proveedor ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: Empresa especializada">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">RUC del proveedor</label>
                            <input type="text" name="se_residuos_h_proveedor_ruc" value="{{ old('se_residuos_h_proveedor_ruc', $format_ii->se_residuos_h_proveedor_ruc ?? '') }}" class="w-full rounded-md border-gray-200 text-sm py-1.5" placeholder="Ej: 20123456789" maxlength="11">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="px-6 py-5 border-b border-gray-100">
    <div class="flex items-center gap-3">
        <div class="w-1 h-8 bg-teal-500 rounded-full"></div>
        <div>
            <h3 class="text-base font-semibold text-gray-800">SERVICIOS COLECTIVOS</h3>
            <p class="text-xs text-gray-500 mt-0.5">Personal, pacientes y servicios generales</p>
        </div>
    </div>
</div>
<!-- ============================================ -->
<!-- SERVICIOS COLECTIVOS -->
<!-- ============================================ -->
<div class="mb-8 border-b border-gray-200 pb-6">
    

<!-- ============================================ -->
<!-- PERSONAL DE SALUD -->
<!-- ============================================ -->
<div id="sec-personal-salud" class="form-section" x-data="sectionCounter('sec-personal-salud',4)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-md text-teal-500 text-sm"></i>
                </div>
                11. Personal de Salud
                <span class="section-badge">Servicios colectivos</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Servicios higiénicos y vestidores para el personal de salud</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
            <div class="counter-bar">
                <div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-3">
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="flex flex-wrap items-end gap-4">
                    <!-- ¿Cuenta con servicios? -->
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con servicios higiénicos y vestidores? <span class="text-teal-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="sc_personal" value="SI" id="sc_personal_si" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal', $format_ii->sc_personal ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="sc_personal" value="NO" id="sc_personal_no" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal', $format_ii->sc_personal ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>

                    <!-- ¿Se encuentra operativo? -->
                    <div class="flex-1 min-w-[150px]" id="sc_personal_operativo_div" style="display: {{ old('sc_personal', $format_ii->sc_personal ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Se encuentra operativo? <span class="text-teal-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_personal_operativo" value="SI" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal_operativo', $format_ii->sc_personal_operativo ?? '') == 'SI' ? 'checked' : '' }}><span class="text-sm">SI</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_personal_operativo" value="NO" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal_operativo', $format_ii->sc_personal_operativo ?? '') == 'NO' ? 'checked' : '' }}><span class="text-sm">NO</span></label>
                        </div>
                    </div>

                    <!-- Estado conservación -->
                    <div class="flex-1 min-w-[160px]" id="sc_personal_estado_div" style="display: {{ old('sc_personal', $format_ii->sc_personal ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado conservación <span class="text-teal-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_personal_estado" value="B" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal_estado', $format_ii->sc_personal_estado ?? '') == 'B' ? 'checked' : '' }}><span class="text-xs">B</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_personal_estado" value="R" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal_estado', $format_ii->sc_personal_estado ?? '') == 'R' ? 'checked' : '' }}><span class="text-xs">R</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_personal_estado" value="M" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal_estado', $format_ii->sc_personal_estado ?? '') == 'M' ? 'checked' : '' }}><span class="text-xs">M</span></label>
                        </div>
                    </div>

                    <!-- Modo de uso -->
                    <div class="flex-1 min-w-[150px]" id="sc_personal_option_div" style="display: {{ old('sc_personal', $format_ii->sc_personal ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Modo de uso <span class="text-teal-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_personal_option" value="C" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal_option', $format_ii->sc_personal_option ?? '') == 'C' ? 'checked' : '' }}><span class="text-sm">CONTINUO</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_personal_option" value="T" class="w-3.5 h-3.5 text-teal-500" {{ old('sc_personal_option', $format_ii->sc_personal_option ?? '') == 'T' ? 'checked' : '' }}><span class="text-sm">TEMPORAL</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- PERSONAL EXTERNO / PACIENTE -->
<!-- ============================================ -->
<div id="sec-personal-externo" class="form-section" x-data="sectionCounter('sec-personal-externo',4)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-500 text-sm"></i>
                </div>
                12. Personal Externo / Paciente
                <span class="section-badge">Servicios colectivos</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Servicios higiénicos y vestidores para pacientes y público externo</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
            <div class="counter-bar">
                <div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-3">
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con servicios higiénicos y vestidores? <span class="text-blue-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="sc_sshh" value="SI" id="sc_sshh_si" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh', $format_ii->sc_sshh ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="sc_sshh" value="NO" id="sc_sshh_no" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh', $format_ii->sc_sshh ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[150px]" id="sc_sshh_operativo_div" style="display: {{ old('sc_sshh', $format_ii->sc_sshh ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Se encuentra operativo? <span class="text-blue-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_sshh_operativo" value="SI" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh_operativo', $format_ii->sc_sshh_operativo ?? '') == 'SI' ? 'checked' : '' }}><span class="text-sm">SI</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_sshh_operativo" value="NO" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh_operativo', $format_ii->sc_sshh_operativo ?? '') == 'NO' ? 'checked' : '' }}><span class="text-sm">NO</span></label>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[160px]" id="sc_sshh_estado_div" style="display: {{ old('sc_sshh', $format_ii->sc_sshh ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado conservación <span class="text-blue-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_sshh_estado" value="B" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh_estado', $format_ii->sc_sshh_estado ?? '') == 'B' ? 'checked' : '' }}><span class="text-xs">B</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_sshh_estado" value="R" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh_estado', $format_ii->sc_sshh_estado ?? '') == 'R' ? 'checked' : '' }}><span class="text-xs">R</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_sshh_estado" value="M" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh_estado', $format_ii->sc_sshh_estado ?? '') == 'M' ? 'checked' : '' }}><span class="text-xs">M</span></label>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[150px]" id="sc_sshh_option_div" style="display: {{ old('sc_sshh', $format_ii->sc_sshh ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Modo de uso <span class="text-blue-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_sshh_option" value="C" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh_option', $format_ii->sc_sshh_option ?? '') == 'C' ? 'checked' : '' }}><span class="text-sm">CONTINUO</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_sshh_option" value="T" class="w-3.5 h-3.5 text-blue-500" {{ old('sc_sshh_option', $format_ii->sc_sshh_option ?? '') == 'T' ? 'checked' : '' }}><span class="text-sm">TEMPORAL</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- ============================================ -->
<!-- PERSONAL DISCAPACITADO -->
<!-- ============================================ -->
<div id="sec-personal-discapacitado" class="form-section" x-data="sectionCounter('sec-personal-discapacitado',4)" x-init="init()">
    <div class="section-header" @click="toggle()">
        <div class="section-header-left">
            <h2 class="section-title">
                <div class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wheelchair text-purple-500 text-sm"></i>
                </div>
                13. Personal Discapacitado
                <span class="section-badge">Servicios colectivos</span>
                <i class="fas accordion-icon ml-auto" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </h2>
            <p class="section-subtitle">Servicios higiénicos y vestidores accesibles para personas con discapacidad</p>
        </div>
        <div class="progress-counter" @click.stop>
            <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
            <div class="counter-bar">
                <div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div>
            </div>
            <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
        </div>
    </div>
    <div class="section-content" :class="open ? '' : 'hidden'">
        <div class="p-3">
            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                <div class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Cuenta con servicios higiénicos y vestidores? <span class="text-purple-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="sc_vestidores" value="SI" id="sc_vestidores_si" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_vestidores', $format_ii->sc_vestidores ?? '') == 'SI' ? 'checked' : '' }}>
                                <span class="text-sm">SI</span>
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="radio" name="sc_vestidores" value="NO" id="sc_vestidores_no" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_vestidores', $format_ii->sc_vestidores ?? '') == 'NO' ? 'checked' : '' }}>
                                <span class="text-sm">NO</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[150px]" id="sc_personal_operativo_div" style="display: {{ old('sc_vestidores', $format_ii->sc_personal_operativo ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">¿Se encuentra operativo? <span class="text-purple-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_personal_operativo" value="SI" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_personal_operativo', $format_ii->sc_personal_operativo ?? '') == 'SI' ? 'checked' : '' }}><span class="text-sm">SI</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_personal_operativo" value="NO" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_personal_operativo', $format_ii->sc_personal_operativo ?? '') == 'NO' ? 'checked' : '' }}><span class="text-sm">NO</span></label>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[160px]" id="sc_vestidores_estado_div" style="display: {{ old('sc_vestidores', $format_ii->sc_vestidores ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Estado conservación <span class="text-purple-500">*</span></label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_vestidores_estado" value="B" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_vestidores_estado', $format_ii->sc_vestidores_estado ?? '') == 'B' ? 'checked' : '' }}><span class="text-xs">B</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_vestidores_estado" value="R" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_vestidores_estado', $format_ii->sc_vestidores_estado ?? '') == 'R' ? 'checked' : '' }}><span class="text-xs">R</span></label>
                            <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="sc_vestidores_estado" value="M" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_vestidores_estado', $format_ii->sc_vestidores_estado ?? '') == 'M' ? 'checked' : '' }}><span class="text-xs">M</span></label>
                        </div>
                    </div>

                    <div class="flex-1 min-w-[150px]" id="sc_vestidores_option_div" style="display: {{ old('sc_vestidores', $format_ii->sc_vestidores ?? '') == 'SI' ? 'block' : 'none' }};">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Modo de uso <span class="text-purple-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_vestidores_option" value="C" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_vestidores_option', $format_ii->sc_vestidores_option ?? '') == 'C' ? 'checked' : '' }}><span class="text-sm">CONTINUO</span></label>
                            <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="sc_vestidores_option" value="T" class="w-3.5 h-3.5 text-purple-500" {{ old('sc_vestidores_option', $format_ii->sc_vestidores_option ?? '') == 'T' ? 'checked' : '' }}><span class="text-sm">TEMPORAL</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    $(document).ready(function() {
        // ============================================
        // AGUA: Mostrar/ocultar campo "Otro"
        // ============================================
        $('#se_agua').on('change', function() {
            if ($(this).val() === 'O') {
                $('#se_agua_otro_div').slideDown(200);
            } else {
                $('#se_agua_otro_div').slideUp(200);
                $('input[name="se_agua_otro"]').val('');
            }
        });

        // ============================================
        // AGUA: Mostrar/ocultar empresa según pago
        // ============================================
        function toggleEmpresaDiv() {
            if ($('#se_agua_paga_si').is(':checked')) {
                $('#se_agua_empresa_div').slideDown(200);
            } else {
                $('#se_agua_empresa_div').slideUp(200);
                $('#se_agua_empresa').val('');
            }
        }

        $('#se_agua_paga_si, #se_agua_paga_no').on('change', toggleEmpresaDiv);
        toggleEmpresaDiv();

        // ============================================
        // AGUA: Calcular horas a la semana
        // ============================================
        function calcularHorasSemana() {
            var horasDia = parseInt($('#se_horas_dia').val()) || 0;
            var totalHoras = 0;

            if ($('input[name="se_sevicio_semana"]:checked').val() === 'SI') {
                totalHoras = horasDia * 7;
            } else {
                totalHoras = horasDia * 5; // Lunes a viernes
            }

            $('#se_sevicio_semana_calculo').val(totalHoras);
        }

        $('#se_horas_dia').on('input', calcularHorasSemana);
        $('input[name="se_sevicio_semana"]').on('change', calcularHorasSemana);
        calcularHorasSemana();

        // ============================================
        // DESAGÜE: Mostrar/ocultar campo "Otro"
        // ============================================
        $('#se_desague').on('change', function() {
            if ($(this).val() === 'OTR') {
                $('#se_desague_otro_div').slideDown(200);
            } else {
                $('#se_desague_otro_div').slideUp(200);
                $('input[name="se_desague_otro"]').val('');
            }
        });
    });

    function toggleElectricidadFields() {
        if ($('#se_electricidad_si').is(':checked')) {
            $('#se_electricidad_operativo_div').slideDown(200);
            $('#se_electricidad_estado_div').slideDown(200);
            $('#se_electricidad_option_div').slideDown(200);
        } else {
            $('#se_electricidad_operativo_div').slideUp(200);
            $('#se_electricidad_estado_div').slideUp(200);
            $('#se_electricidad_option_div').slideUp(200);
            // Limpiar campos cuando NO tiene electricidad
            $('input[name="se_electricidad_operativo"]').prop('checked', false);
            $('input[name="se_electricidad_estado"]').prop('checked', false);
            $('input[name="se_electricidad_option"]').prop('checked', false);
            $('input[name="se_electricidad_fuente"]').val('');
            $('input[name="se_electricidad_proveedor_ruc"]').val('');
        }
    }

    $('#se_electricidad_si, #se_electricidad_no').on('change', toggleElectricidadFields);
    toggleElectricidadFields();


    // ============================================
    // TELEFONÍA: Mostrar/ocultar campos según SI/NO
    // ============================================
    function toggleTelefoniaFields() {
        if ($('#se_telefonia_si').is(':checked')) {
            $('#se_telefonia_operativo_div').slideDown(200);
            $('#se_telefonia_estado_div').slideDown(200);
            $('#se_telefonia_option_div').slideDown(200);
        } else {
            $('#se_telefonia_operativo_div').slideUp(200);
            $('#se_telefonia_estado_div').slideUp(200);
            $('#se_telefonia_option_div').slideUp(200);
            // Limpiar campos cuando NO tiene telefonía
            $('input[name="se_telefonia_operativo"]').prop('checked', false);
            $('input[name="se_telefonia_estado"]').prop('checked', false);
            $('input[name="se_telefonia_option"]').prop('checked', false);
            $('input[name="se_telefonia_proveedor"]').val('');
            $('input[name="se_telefonia_proveedor_ruc"]').val('');
        }
    }

    $('#se_telefonia_si, #se_telefonia_no').on('change', toggleTelefoniaFields);
    toggleTelefoniaFields();

    // ============================================
    // TELEVISIÓN: Mostrar/ocultar campos según SI/NO
    // ============================================
    function toggleTelevicionFields() {
        if ($('#televicion_si').is(':checked')) {
            $('#televicion_operador_div').slideDown(200);
            $('#televicion_option_div').slideDown(200);
        } else {
            $('#televicion_operador_div').slideUp(200);
            $('#televicion_option_div').slideUp(200);
            $('input[name="televicion_operador"]').val('');
            $('select[name="televicion_option1"]').val('');
        }
    }

    // Mostrar/ocultar porcentaje según salas de espera
    function togglePorcentajeDiv() {
        if ($('input[name="televicion_espera"]:checked').val() === 'SI') {
            $('#televicion_porcentaje_div').slideDown(200);
        } else {
            $('#televicion_porcentaje_div').slideUp(200);
            $('input[name="televicion_porcentaje"]').val('');
        }
    }

    $('#televicion_si, #televicion_no').on('change', toggleTelevicionFields);
    $('input[name="televicion_espera"]').on('change', togglePorcentajeDiv);
    toggleTelevicionFields();
    togglePorcentajeDiv();


    // ============================================
    // RED MÓVIL
    // ============================================
    function toggleRedFields() {
        if ($('#se_red_si').is(':checked')) {
            $('#se_red_operativo_div, #se_red_estado_div, #se_red_option_div').slideDown(200);
        } else {
            $('#se_red_operativo_div, #se_red_estado_div, #se_red_option_div').slideUp(200);
            $('input[name="se_red_operativo"], input[name="se_red_estado"], input[name="se_red_option"]').prop(
                'checked', false);
            $('input[name="se_red_proveedor"], input[name="se_red_proveedor_ruc"]').val('');
        }
    }

    // ============================================
    // GAS
    // ============================================
    function toggleGasFields() {
        if ($('#se_gas_si').is(':checked')) {
            $('#se_gas_operativo_div, #se_gas_estado_div, #se_gas_option_div').slideDown(200);
        } else {
            $('#se_gas_operativo_div, #se_gas_estado_div, #se_gas_option_div').slideUp(200);
            $('input[name="se_gas_operativo"], input[name="se_gas_estado"], input[name="se_gas_option"]').prop(
                'checked', false);
            $('input[name="se_gas_proveedor"], input[name="se_gas_proveedor_ruc"]').val('');
        }
    }

    // ============================================
    // RESIDUOS SÓLIDOS
    // ============================================
    function toggleResiduosFields() {
        if ($('#se_residuos_si').is(':checked')) {
            $('#se_residuos_operativo_div, #se_residuos_estado_div, #se_residuos_option_div').slideDown(200);
        } else {
            $('#se_residuos_operativo_div, #se_residuos_estado_div, #se_residuos_option_div').slideUp(200);
            $('input[name="se_residuos_operativo"], input[name="se_residuos_estado"], input[name="se_residuos_option"]')
                .prop('checked', false);
            $('input[name="se_residuos_proveedor"], input[name="se_residuos_proveedor_ruc"]').val('');
        }
    }

    // ============================================
    // RESIDUOS HOSPITALARIOS
    // ============================================
    function toggleResiduosHFields() {
        if ($('#se_residuos_h_si').is(':checked')) {
            $('#se_residuos_h_operativo_div, #se_residuos_h_estado_div, #se_residuos_h_option_div').slideDown(200);
        } else {
            $('#se_residuos_h_operativo_div, #se_residuos_h_estado_div, #se_residuos_h_option_div').slideUp(200);
            $('input[name="se_residuos_h_operativo"], input[name="se_residuos_h_estado"], input[name="se_residuos_h_option"]')
                .prop('checked', false);
            $('input[name="se_residuos_h_proveedor"], input[name="se_residuos_h_proveedor_ruc"]').val('');
        }
    }

    // Eventos
    $('#se_red_si, #se_red_no').on('change', toggleRedFields);
    $('#se_gas_si, #se_gas_no').on('change', toggleGasFields);
    $('#se_residuos_si, #se_residuos_no').on('change', toggleResiduosFields);
    $('#se_residuos_h_si, #se_residuos_h_no').on('change', toggleResiduosHFields);

    // Inicializar
    toggleRedFields();
    toggleGasFields();
    toggleResiduosFields();
    toggleResiduosHFields();


    // ============================================
    // PERSONAL DE SALUD
    // ============================================
    function togglePersonalFields() {
        if ($('#sc_personal_si').is(':checked')) {
            $('#sc_personal_operativo_div, #sc_personal_estado_div, #sc_personal_option_div').slideDown(200);
        } else {
            $('#sc_personal_operativo_div, #sc_personal_estado_div, #sc_personal_option_div').slideUp(200);
            $('input[name="sc_personal_operativo"], input[name="sc_personal_estado"], input[name="sc_personal_option"]')
                .prop('checked', false);
        }
    }

    // ============================================
    // PERSONAL EXTERNO / PACIENTE
    // ============================================
    function toggleSshhFields() {
        if ($('#sc_sshh_si').is(':checked')) {
            $('#sc_sshh_operativo_div, #sc_sshh_estado_div, #sc_sshh_option_div').slideDown(200);
        } else {
            $('#sc_sshh_operativo_div, #sc_sshh_estado_div, #sc_sshh_option_div').slideUp(200);
            $('input[name="sc_sshh_operativo"], input[name="sc_sshh_estado"], input[name="sc_sshh_option"]').prop(
                'checked', false);
        }
    }

    // ============================================
    // PERSONAL DISCAPACITADO
    // ============================================
    function toggleVestidoresFields() {
        if ($('#sc_vestidores_si').is(':checked')) {
            $('#sc_vestidores_operativo_div, #sc_vestidores_estado_div, #sc_vestidores_option_div').slideDown(200);
        } else {
            $('#sc_vestidores_operativo_div, #sc_vestidores_estado_div, #sc_vestidores_option_div').slideUp(200);
            $('input[name="sc_vestidores_operativo"], input[name="sc_vestidores_estado"], input[name="sc_vestidores_option"]')
                .prop('checked', false);
        }
    }

    // Eventos
    $('#sc_personal_si, #sc_personal_no').on('change', togglePersonalFields);
    $('#sc_sshh_si, #sc_sshh_no').on('change', toggleSshhFields);
    $('#sc_vestidores_si, #sc_vestidores_no').on('change', toggleVestidoresFields);

    // Inicializar
    togglePersonalFields();
    toggleSshhFields();
    toggleVestidoresFields();
</script>
