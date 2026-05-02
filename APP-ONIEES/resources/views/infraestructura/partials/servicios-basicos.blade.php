<!-- ============================================ -->
<!-- AGUA -->
<!-- ============================================ -->
<div class="mb-8 border-b border-gray-200 pb-6">
    <h4 class="text-md font-semibold text-gray-700 mb-4">
        <i class="fas fa-tint mr-2 text-blue-500"></i> 1. Agua
    </h4>

    <!-- El agua que utilizan en la ipress procede principalmente de -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                El agua que utilizan en la ipress procede principalmente de: <span class="text-red-500">*</span>
            </label>
            <select name="se_agua" id="se_agua" class="w-full rounded-lg border-gray-300">
                <option value="">Seleccione</option>
                <option value="RP" {{ old('se_agua', $format_ii->se_agua ?? '') == 'RP' ? 'selected' : '' }}>Red Pública</option>
                <option value="CCS" {{ old('se_agua', $format_ii->se_agua ?? '') == 'CCS' ? 'selected' : '' }}>Camion-cisterna u otro similar</option>
                <option value="P" {{ old('se_agua', $format_ii->se_agua ?? '') == 'P' ? 'selected' : '' }}>Pozo</option>
                <option value="MP" {{ old('se_agua', $format_ii->se_agua ?? '') == 'MP' ? 'selected' : '' }}>Manantial o puquio</option>
                <option value="RALL" {{ old('se_agua', $format_ii->se_agua ?? '') == 'RALL' ? 'selected' : '' }}>Rio, acequia, lago, laguna</option>
                <option value="O" {{ old('se_agua', $format_ii->se_agua ?? '') == 'O' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>
        <div id="se_agua_otro_div" style="display: {{ old('se_agua', $format_ii->se_agua ?? '') == 'O' ? 'block' : 'none' }};">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Especifique otro origen del agua:
            </label>
            <input type="text" name="se_agua_otro" value="{{ old('se_agua_otro', $format_ii->se_agua_otro ?? '') }}" 
                   class="w-full rounded-lg border-gray-300" placeholder="Ej: Agua embotellada, etc.">
        </div>
    </div>

    <!-- ¿Se encuentra operativo? -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                ¿Se encuentra operativo? <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_agua_operativo" value="SI" 
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_agua_operativo', $format_ii->se_agua_operativo ?? '') == 'SI' ? 'checked' : '' }}>
                    <span>SI</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_agua_operativo" value="NO" 
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_agua_operativo', $format_ii->se_agua_operativo ?? '') == 'NO' ? 'checked' : '' }}>
                    <span>NO</span>
                </label>
            </div>
        </div>

        <!-- Estado de conservación -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Estado de conservación: <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_agua_estado" value="B" 
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'B' ? 'checked' : '' }}>
                    <span>Bueno (B)</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_agua_estado" value="R" 
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'R' ? 'checked' : '' }}>
                    <span>Regular (R)</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_agua_estado" value="M" 
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'M' ? 'checked' : '' }}>
                    <span>Malo (M)</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Días y horas de servicio -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                ¿La IPRESS tiene el servicio de agua todos los días de la semana? <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_sevicio_semana" value="SI" 
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_sevicio_semana', $format_ii->se_sevicio_semana ?? '') == 'SI' ? 'checked' : '' }}>
                    <span>SI</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_sevicio_semana" value="NO" 
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_sevicio_semana', $format_ii->se_sevicio_semana ?? '') == 'NO' ? 'checked' : '' }}>
                    <span>NO</span>
                </label>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Horas al día: <span class="text-red-500">*</span>
            </label>
            <input type="number" name="se_horas_dia" id="se_horas_dia" value="{{ old('se_horas_dia', $format_ii->se_horas_dia ?? '24') }}" 
                   class="w-full rounded-lg border-gray-300" min="0" max="24" step="1">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Horas a la semana:
            </label>
            <input type="number" name="se_sevicio_semana_calculo" id="se_sevicio_semana_calculo" value="{{ old('se_sevicio_semana_calculo', $format_ii->se_sevicio_semana_calculo ?? '168') }}" 
                   class="w-full rounded-lg border-gray-300 bg-gray-100" readonly>
        </div>
    </div>

    <!-- Pago del servicio -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                ¿Pagan por el servicio de agua? <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_servicio_agua" value="SI" id="se_agua_paga_si"
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'SI' ? 'checked' : '' }}>
                    <span>SI</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_servicio_agua" value="NO" id="se_agua_paga_no"
                           class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'NO' ? 'checked' : '' }}>
                    <span>NO</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Empresa/Entidad a la que se paga -->
    <div id="se_agua_empresa_div" style="display: {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'SI' ? 'block' : 'none' }};">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    ¿A qué empresa o entidad se paga por el servicio de agua? <span class="text-red-500">*</span>
                </label>
                <select name="se_empresa_agua" id="se_agua_empresa" class="w-full rounded-lg border-gray-300">
                    <option value="">Seleccione</option>
                    <option value="EPS" {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'EPS' ? 'selected' : '' }}>Empresa prestadora de servicio</option>
                    <option value="M" {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'M' ? 'selected' : '' }}>Municipalidad</option>
                    <option value="PC" {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'PC' ? 'selected' : '' }}>Organización comunal</option>
                    <option value="C" {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'C' ? 'selected' : '' }}>Camion cisterna (pago directo)</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- DESAGÜE / ALCANTARILLADO -->
<!-- ============================================ -->
<div class="mb-8 border-b border-gray-200 pb-6">
    <h4 class="text-md font-semibold text-gray-700 mb-4">
        <i class="fas fa-toilet mr-2 text-green-500"></i> 2. Desagüe / Alcantarillado
    </h4>

    <!-- Tipo de servicio -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tipo de servicio: <span class="text-red-500">*</span>
            </label>
            <select name="se_desague" id="se_desague" class="w-full rounded-lg border-gray-300">
                <option value="">Seleccione</option>
                <option value="RPD" {{ old('se_desague', $format_ii->se_desague ?? '') == 'RPD' ? 'selected' : '' }}>Red pública de desagüe dentro de la IPRESS</option>
                <option value="RPF" {{ old('se_desague', $format_ii->se_desague ?? '') == 'RPF' ? 'selected' : '' }}>Red pública de desagüe fuera de la IPRESS</option>
                <option value="P" {{ old('se_desague', $format_ii->se_desague ?? '') == 'P' ? 'selected' : '' }}>Pozo séptico, tanque séptico, séptico biogestor</option>
                <option value="L" {{ old('se_desague', $format_ii->se_desague ?? '') == 'L' ? 'selected' : '' }}>Letrina (con tratamiento)</option>
                <option value="PN" {{ old('se_desague', $format_ii->se_desague ?? '') == 'PN' ? 'selected' : '' }}>Pozo ciego o negro</option>
                <option value="OTR" {{ old('se_desague', $format_ii->se_desague ?? '') == 'OTR' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>
        <div id="se_desague_otro_div" style="display: {{ old('se_desague', $format_ii->se_desague ?? '') == 'OTR' ? 'block' : 'none' }};">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Especifique otro tipo de servicio:
            </label>
            <input type="text" name="se_desague_otro" value="{{ old('se_desague_otro', $format_ii->se_desague_otro ?? '') }}" 
                   class="w-full rounded-lg border-gray-300" placeholder="Ej: Canal abierto, etc.">
        </div>
    </div>

    <!-- ¿Se encuentra operativo? -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                ¿Se encuentra operativo? <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_desague_operativo" value="SI" 
                           class="rounded-full border-gray-300 text-green-600 focus:ring-green-500"
                           {{ old('se_desague_operativo', $format_ii->se_desague_operativo ?? '') == 'SI' ? 'checked' : '' }}>
                    <span>SI</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_desague_operativo" value="NO" 
                           class="rounded-full border-gray-300 text-green-600 focus:ring-green-500"
                           {{ old('se_desague_operativo', $format_ii->se_desague_operativo ?? '') == 'NO' ? 'checked' : '' }}>
                    <span>NO</span>
                </label>
            </div>
        </div>

        <!-- Estado de conservación -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Estado de conservación: <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_desague_estado" value="B" 
                           class="rounded-full border-gray-300 text-green-600 focus:ring-green-500"
                           {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'B' ? 'checked' : '' }}>
                    <span>Bueno (B)</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_desague_estado" value="R" 
                           class="rounded-full border-gray-300 text-green-600 focus:ring-green-500"
                           {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'R' ? 'checked' : '' }}>
                    <span>Regular (R)</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="se_desague_estado" value="M" 
                           class="rounded-full border-gray-300 text-green-600 focus:ring-green-500"
                           {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'M' ? 'checked' : '' }}>
                    <span>Malo (M)</span>
                </label>
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
</script>