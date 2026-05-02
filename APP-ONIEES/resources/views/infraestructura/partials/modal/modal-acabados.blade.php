<!-- Modal para Acabados Interiores -->
<div id="acabadosModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-xl font-semibold text-teal-800" id="acabadosModalTitle">Acabados Interiores</h3>
            <button onclick="closeAcabadosModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <input type="hidden" id="acabados_edificacion_id" value="">
        
        <div class="space-y-6">
            <!-- PISOS -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3 border-l-4 border-teal-600 pl-2">PISOS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos" value="PMP"> Parquet</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos" value="LAV"> Láminas</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos" value="LTC"> Loseta</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos" value="MAD"> Madera</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos" value="CEM"> Cemento</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos" value="TIE"> Tierra</label>
                            <label class="flex items-center gap-2 col-span-2"><input type="radio" name="ac_pisos" value="OTR"> Otros</label>
                        </div>
                        <input type="text" name="ac_pisos_nombre" class="w-full mt-2 rounded-lg border-gray-300 text-sm hidden" placeholder="Especifique...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos_estado" value="B"> Bueno (B)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos_estado" value="R"> Regular (R)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_pisos_estado" value="M"> Malo (M)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VEREDAS -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3 border-l-4 border-teal-600 pl-2">VEREDAS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_veredas" value="LTC"> Loseta</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_veredas" value="MAD"> Madera</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_veredas" value="CEM"> Cemento</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_veredas" value="TIE"> Tierra</label>
                            <label class="flex items-center gap-2 col-span-2"><input type="radio" name="ac_veredas" value="OTR"> Otros</label>
                        </div>
                        <input type="text" name="ac_veredas_nombre" class="w-full mt-2 rounded-lg border-gray-300 text-sm hidden" placeholder="Especifique...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_veredas_estado" value="B"> Bueno (B)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_veredas_estado" value="R"> Regular (R)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_veredas_estado" value="M"> Malo (M)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ZÓCALOS -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3 border-l-4 border-teal-600 pl-2">ZÓCALOS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_zocalos" value="LTC"> Loseta</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_zocalos" value="CEM"> Cemento</label>
                            <label class="flex items-center gap-2 col-span-2"><input type="radio" name="ac_zocalos" value="OTR"> Otros</label>
                        </div>
                        <input type="text" name="ac_zocalos_nombre" class="w-full mt-2 rounded-lg border-gray-300 text-sm hidden" placeholder="Especifique...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_zocalos_estado" value="B"> Bueno (B)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_zocalos_estado" value="R"> Regular (R)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_zocalos_estado" value="M"> Malo (M)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MUROS -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3 border-l-4 border-teal-600 pl-2">MUROS</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_muros" value="LBC"> Ladrillo</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_muros" value="PSC"> Piedra</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_muros" value="ADO"> Adobe</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_muros" value="TAP"> Tapia</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_muros" value="MAD"> Madera</label>
                            <label class="flex items-center gap-2 col-span-2"><input type="radio" name="ac_muros" value="OTR"> Otros</label>
                        </div>
                        <input type="text" name="ac_muros_nombre" class="w-full mt-2 rounded-lg border-gray-300 text-sm hidden" placeholder="Especifique...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_muros_estado" value="B"> Bueno (B)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_muros_estado" value="R"> Regular (R)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_muros_estado" value="M"> Malo (M)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TECHO -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3 border-l-4 border-teal-600 pl-2">TECHO</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo" value="CA"> Concreto</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo" value="MAD"> Madera</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo" value="TEJ"> Tejas</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo" value="PCF"> Calamina</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo" value="CEB"> Caña/estera</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo" value="TEC"> Triplay</label>
                            <label class="flex items-center gap-2 col-span-2"><input type="radio" name="ac_techo" value="OTR"> Otros</label>
                        </div>
                        <input type="text" name="ac_techo_nombre" class="w-full mt-2 rounded-lg border-gray-300 text-sm hidden" placeholder="Especifique...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo_estado" value="B"> Bueno (B)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo_estado" value="R"> Regular (R)</label>
                            <label class="flex items-center gap-2"><input type="radio" name="ac_techo_estado" value="M"> Malo (M)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
            <button type="button" onclick="closeAcabadosModal()"
                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                Cancelar
            </button>
            <button type="button" onclick="guardarAcabados()"
                class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg">
                Guardar Acabados
            </button>
        </div>
    </div>
</div>