<!-- servicios-basicos.blade.php - Versión de prueba SOLO Agua y Desagüe -->
<div class="space-y-6" id="sec-servicios-basicos">
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-blue-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-water mr-2 text-cyan-600"></i> Servicios Básicos
            </h3>
        </div>

        <div class="p-6">
            <!-- === AGUA === -->
            <div class="mb-8 border-b border-gray-200 pb-6">
                <h4 class="text-md font-semibold text-gray-700 mb-4">
                    <i class="fas fa-tint mr-2 text-blue-500"></i> 1. Agua
                </h4>
                
                <!-- Campo oculto para debug -->
                <input type="hidden" name="test_agua" value="1">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ¿Cuenta con servicio de agua?
                        </label>
                        <select name="se_agua" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="SI" {{ old('se_agua', $format_ii->se_agua ?? '') == 'SI' ? 'selected' : '' }}>Sí</option>
                            <option value="NO" {{ old('se_agua', $format_ii->se_agua ?? '') == 'NO' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ¿Está operativo?
                        </label>
                        <select name="se_agua_operativo" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="SI" {{ old('se_agua_operativo', $format_ii->se_agua_operativo ?? '') == 'SI' ? 'selected' : '' }}>Sí</option>
                            <option value="NO" {{ old('se_agua_operativo', $format_ii->se_agua_operativo ?? '') == 'NO' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Estado
                        </label>
                        <select name="se_agua_estado" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="B" {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'B' ? 'selected' : '' }}>Bueno</option>
                            <option value="R" {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'R' ? 'selected' : '' }}>Regular</option>
                            <option value="M" {{ old('se_agua_estado', $format_ii->se_agua_estado ?? '') == 'M' ? 'selected' : '' }}>Malo</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Días de servicio a la semana
                        </label>
                        <input type="number" name="se_sevicio_semana" value="{{ old('se_sevicio_semana', $format_ii->se_sevicio_semana ?? '') }}" 
                               class="w-full rounded-lg border-gray-300" min="0" max="7">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Horas por día
                        </label>
                        <input type="number" name="se_horas_dia" value="{{ old('se_horas_dia', $format_ii->se_horas_dia ?? '') }}" 
                               class="w-full rounded-lg border-gray-300" min="0" max="24">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de servicio
                        </label>
                        <select name="se_servicio_agua" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="CR" {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'CR' ? 'selected' : '' }}>Conexión domiciliaria</option>
                            <option value="PI" {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'PI' ? 'selected' : '' }}>Pilón</option>
                            <option value="CA" {{ old('se_servicio_agua', $format_ii->se_servicio_agua ?? '') == 'CA' ? 'selected' : '' }}>Camión cisterna</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Empresa proveedora
                        </label>
                        <select name="se_empresa_agua" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="SED" {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'SED' ? 'selected' : '' }}>SEDAPAL</option>
                            <option value="EPS" {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'EPS' ? 'selected' : '' }}>EPS</option>
                            <option value="MUN" {{ old('se_empresa_agua', $format_ii->se_empresa_agua ?? '') == 'MUN' ? 'selected' : '' }}>Municipalidad</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Fuente de agua
                    </label>
                    <input type="text" name="se_agua_fuente" value="{{ old('se_agua_fuente', $format_ii->se_agua_fuente ?? '') }}" 
                           class="w-full rounded-lg border-gray-300" placeholder="Ej: Río, Lago, Pozo">
                </div>
            </div>

            <!-- === DESAGÜE === -->
            <div class="mb-8 border-b border-gray-200 pb-6">
                <h4 class="text-md font-semibold text-gray-700 mb-4">
                    <i class="fas fa-toilet mr-2 text-green-500"></i> 2. Desagüe/Alcantarillado
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ¿Cuenta con servicio de desagüe?
                        </label>
                        <select name="se_desague" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="SI" {{ old('se_desague', $format_ii->se_desague ?? '') == 'SI' ? 'selected' : '' }}>Sí</option>
                            <option value="NO" {{ old('se_desague', $format_ii->se_desague ?? '') == 'NO' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ¿Está operativo?
                        </label>
                        <select name="se_desague_operativo" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="SI" {{ old('se_desague_operativo', $format_ii->se_desague_operativo ?? '') == 'SI' ? 'selected' : '' }}>Sí</option>
                            <option value="NO" {{ old('se_desague_operativo', $format_ii->se_desague_operativo ?? '') == 'NO' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Estado
                        </label>
                        <select name="se_desague_estado" class="w-full rounded-lg border-gray-300">
                            <option value="">Seleccione</option>
                            <option value="B" {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'B' ? 'selected' : '' }}>Bueno</option>
                            <option value="R" {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'R' ? 'selected' : '' }}>Regular</option>
                            <option value="M" {{ old('se_desague_estado', $format_ii->se_desague_estado ?? '') == 'M' ? 'selected' : '' }}>Malo</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Fuente/Sistema de desagüe
                    </label>
                    <input type="text" name="se_desague_fuente" value="{{ old('se_desague_fuente', $format_ii->se_desague_fuente ?? '') }}" 
                           class="w-full rounded-lg border-gray-300" placeholder="Ej: Red pública, Letrina, Pozo séptico">
                </div>
            </div>

            <!-- Mensaje de depuración -->
            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Depuración:</strong> Los campos de Agua y Desagüe están activos. Al guardar, deberían registrarse en la base de datos.
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Interceptar el envío del formulario
    $('#mainForm').on('submit', function(e) {
        // Recopilar todos los datos del formulario
        var formData = $(this).serializeArray();
        
        console.log('=== DATOS DEL FORMULARIO ===');
        formData.forEach(function(item) {
            console.log(item.name + ' = ' + item.value);
        });
        
        // Verificar específicamente campos de servicios básicos
        var se_agua = $('[name="se_agua"]').val();
        var se_desague = $('[name="se_desague"]').val();
        
        console.log('se_agua valor:', se_agua);
        console.log('se_desague valor:', se_desague);
        
        if (!se_agua && !se_desague) {
            console.warn('⚠️ ADVERTENCIA: Los campos de servicios básicos NO se están enviando');
        }
        
        // No prevenir el envío, solo depurar
        return true;
    });
});

</script>