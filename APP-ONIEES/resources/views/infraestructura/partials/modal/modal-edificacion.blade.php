<!-- Modal para Agregar/Editar Edificación -->
<div id="edificacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-semibold text-teal-800" id="modalTitle">Agregar Edificación</h3>
            <button onclick="closeEdificacionModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="mt-4">
            <input type="hidden" name="id_establecimiento" id="modal_id_establecimiento" value="{{ $establecimiento->id ?? '' }}">
            <input type="hidden" name="edificacion_id" id="edificacion_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bloque <span class="text-red-500">*</span></label>
                    <input type="text" id="bloque" required
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: A, B, C, Principal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pabellón <span class="text-red-500">*</span></label>
                    <input type="text" id="pabellon" required
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: Central, Norte, Sur">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">UPSS/UPS <span class="text-red-500">*</span></label>
                    <select id="servicio" required
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        @foreach ($upssList as $upss)
                            <option value="{{ $upss->id }}">{{ $upss->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de Pisos</label>
                    <input type="number" id="nropisos" min="0"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: 1, 2, 3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Antigüedad (años)</label>
                    <input type="number" id="antiguedad" min="0"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Ej: 10, 20, 30">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Última Intervención</label>
                    <input type="date" id="ultima_intervencion"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Intervención</label>
                    <select id="tipo_intervencion"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Seleccione</option>
                        @foreach ($tiposIntervencion as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observación</label>
                    <textarea id="observacion" rows="2"
                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                        placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-3 border-t">
                <button type="button" onclick="closeEdificacionModal()"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition">
                    Cancelar
                </button>
                <button type="button" onclick="guardarEdificacion()"
                    class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>