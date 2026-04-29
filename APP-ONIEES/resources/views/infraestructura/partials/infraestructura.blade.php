<div class="space-y-6">
    <div class="bg-teal-50 p-4 rounded-lg mb-4">
        <h3 class="text-lg font-semibold text-teal-800 mb-2 flex items-center gap-2">
            <i class="fas fa-hard-hat"></i> Módulo de Infraestructura
        </h3>
        <p class="text-sm text-gray-600">Complete los datos de infraestructura del establecimiento de salud</p>
    </div>

    <form method="POST" action="{{ route('infraestructura.saveInfraestructura') }}" id="infraestructuraForm" class="space-y-6">
        @csrf
        <input type="hidden" name="id_establecimiento" value="{{ $establecimiento->id ?? '' }}">
        
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
                    <!-- Condición de Saneamiento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Condición de Saneamiento Físico Legal</label>
                        <select name="t_condicion_saneamiento" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Seleccione</option>
                            <option value="PROPIO" {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'PROPIO' ? 'selected' : '' }}>PROPIO</option>
                            <option value="ALQUILER" {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'ALQUILER' ? 'selected' : '' }}>ALQUILER</option>
                            <option value="CESION" {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'CESION' ? 'selected' : '' }}>CESIÓN</option>
                            <option value="OTRO" {{ ($infraestructura->t_condicion_saneamiento ?? '') == 'OTRO' ? 'selected' : '' }}>OTRO</option>
                        </select>
                    </div>
                    
                    <!-- Título a favor de -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Título a favor de</label>
                        <input type="text" name="t_titular_nombre" value="{{ $infraestructura->t_titular_nombre ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                               placeholder="Ej: MINSA, GOBIERNO REGIONAL, etc.">
                    </div>
                    
                    <!-- Observación -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observación</label>
                        <input type="text" name="observacion" value="{{ $infraestructura->observacion ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                               placeholder="Observaciones del terreno">
                    </div>
                    
                    <!-- Área Terreno -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA TERRENO (m²)</label>
                        <input type="number" step="0.01" name="t_area_terreno" value="{{ $infraestructura->t_area_terreno ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    
                    <!-- Área Construida -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA CONSTRUIDA (m²)</label>
                        <input type="number" step="0.01" name="t_area_construida" value="{{ $infraestructura->t_area_construida ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    
                    <!-- Área Estacionamiento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA ESTACIONAMIENTO (m²)</label>
                        <input type="number" step="0.01" name="t_area_estac" value="{{ $infraestructura->t_area_estac ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    
                    <!-- Área Libre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ÁREA LIBRE (m²)</label>
                        <input type="number" step="0.01" name="t_area_libre" value="{{ $infraestructura->t_area_libre ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    
                    <!-- N° Plazas de Estacionamiento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">N° PLAZA DE ESTACIONAMIENTO</label>
                        <input type="number" name="t_estacionamiento" value="{{ $infraestructura->t_estacionamiento ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    
                    <!-- Inspección Técnica -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">¿CUENTA CON INSPECCIÓN TÉCNICA DE SEGURIDAD EN EDIFICACIONES?</label>
                        <select name="t_inspeccion" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Seleccione</option>
                            <option value="SI" {{ ($infraestructura->t_inspeccion ?? '') == 'SI' ? 'selected' : '' }}>SI</option>
                            <option value="NO" {{ ($infraestructura->t_inspeccion ?? '') == 'NO' ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                    
                    <!-- Estado de Inspección -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ESTADO DE LA INSPECCIÓN</label>
                        <select name="t_inspeccion_estado" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Seleccione</option>
                            <option value="FAVORABLE" {{ ($infraestructura->t_inspeccion_estado ?? '') == 'FAVORABLE' ? 'selected' : '' }}>FAVORABLE</option>
                            <option value="DESFAVORABLE" {{ ($infraestructura->t_inspeccion_estado ?? '') == 'DESFAVORABLE' ? 'selected' : '' }}>DESFAVORABLE</option>
                            <option value="OBSERVADO" {{ ($infraestructura->t_inspeccion_estado ?? '') == 'OBSERVADO' ? 'selected' : '' }}>OBSERVADO</option>
                        </select>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_ubicacion" value="SI" {{ ($infraestructura->pf_ubicacion ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Plano de Ubicación</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_estructuras" value="SI" {{ ($infraestructura->pf_estructuras ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Estructuras</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_ins_mecanicas" value="SI" {{ ($infraestructura->pf_ins_mecanicas ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Instalaciones Mecánicas</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_perimetro" value="SI" {{ ($infraestructura->pf_perimetro ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Plano Perimétrico</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_ins_sanitarias" value="SI" {{ ($infraestructura->pf_ins_sanitarias ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Instalaciones Sanitarias</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_ins_comunic" value="SI" {{ ($infraestructura->pf_ins_comunic ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Instalaciones de Comunicaciones</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_arquitectura" value="SI" {{ ($infraestructura->pf_arquitectura ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Plano de Arquitectura</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_ins_electricas" value="SI" {{ ($infraestructura->pf_ins_electricas ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Instalaciones Eléctricas</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pf_distribuicion" value="SI" {{ ($infraestructura->pf_distribuicion ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Distribución de Equipamiento</span>
                    </label>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_ubicacion" value="SI" {{ ($infraestructura->pd_ubicacion ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Plano de Ubicación</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_perimetro" value="SI" {{ ($infraestructura->pd_perimetro ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Plano Perimétrico</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_arquitectura" value="SI" {{ ($infraestructura->pd_arquitectura ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Arquitectura</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_estructuras" value="SI" {{ ($infraestructura->pd_estructuras ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Estructuras</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_ins_sanitarias" value="SI" {{ ($infraestructura->pd_ins_sanitarias ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Instalaciones Sanitarias</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_ins_electricas" value="SI" {{ ($infraestructura->pd_ins_electricas ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Instalaciones Eléctricas</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_ins_mecanicas" value="SI" {{ ($infraestructura->pd_ins_mecanicas ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Instalaciones Mecánicas</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_ins_comunic" value="SI" {{ ($infraestructura->pd_ins_comunic ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Instalaciones de Comunicaciones</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                        <input type="checkbox" name="pd_distribuicion" value="SI" {{ ($infraestructura->pd_distribuicion ?? '') == 'SI' ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500 w-5 h-5">
                        <span class="text-sm text-gray-700">Planos de Distribución de Equipamiento</span>
                    </label>
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
                        <select name="material" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                onchange="document.querySelector('[name=material_nombre]').style.display = this.value == '5' ? 'block' : 'none'">
                            <option value="">Seleccione</option>
                            <option value="1" {{ ($infraestructura->material ?? '') == '1' ? 'selected' : '' }}>Adobe</option>
                            <option value="2" {{ ($infraestructura->material ?? '') == '2' ? 'selected' : '' }}>Ladrillo</option>
                            <option value="3" {{ ($infraestructura->material ?? '') == '3' ? 'selected' : '' }}>Concreto</option>
                            <option value="4" {{ ($infraestructura->material ?? '') == '4' ? 'selected' : '' }}>Madera</option>
                            <option value="5" {{ ($infraestructura->material ?? '') == '5' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    
                    <!-- Material (especificar) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material (especificar)</label>
                        <input type="text" name="material_nombre" value="{{ $infraestructura->material_nombre ?? '' }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                               placeholder="Especifique el material si seleccionó 'Otro'"
                               style="display: {{ ($infraestructura->material ?? '') == '5' ? 'block' : 'none' }}">
                    </div>
                    
                    <!-- Suelo Vulnerable -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suelo Vulnerable</label>
                        <select name="t_vulnerable" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Seleccione</option>
                            <option value="SI" {{ ($infraestructura->t_vulnerable ?? '') == 'SI' ? 'selected' : '' }}>SI</option>
                            <option value="NO" {{ ($infraestructura->t_vulnerable ?? '') == 'NO' ? 'selected' : '' }}>NO</option>
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">¿Cuenta con cerco perimétrico?</label>
                        <select name="cp_erco_perim" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Seleccione</option>
                            <option value="SI" {{ ($infraestructura->cp_erco_perim ?? '') == 'SI' ? 'selected' : '' }}>SI</option>
                            <option value="NO" {{ ($infraestructura->cp_erco_perim ?? '') == 'NO' ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                    
                    <!-- Material del cerco -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Material del cerco</label>
                        <select name="cp_material" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Seleccione</option>
                            <option value="LADRILLO" {{ ($infraestructura->cp_material ?? '') == 'LADRILLO' ? 'selected' : '' }}>Ladrillo</option>
                            <option value="CONCRETO" {{ ($infraestructura->cp_material ?? '') == 'CONCRETO' ? 'selected' : '' }}>Concreto</option>
                            <option value="METAL" {{ ($infraestructura->cp_material ?? '') == 'METAL' ? 'selected' : '' }}>Metal</option>
                            <option value="MADERA" {{ ($infraestructura->cp_material ?? '') == 'MADERA' ? 'selected' : '' }}>Madera</option>
                            <option value="OTRO" {{ ($infraestructura->cp_material ?? '') == 'OTRO' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    
                    <!-- Estado del cerco -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado del cerco</label>
                        <select name="cp_estado" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Seleccione</option>
                            <option value="BUENO" {{ ($infraestructura->cp_estado ?? '') == 'BUENO' ? 'selected' : '' }}>Bueno</option>
                            <option value="REGULAR" {{ ($infraestructura->cp_estado ?? '') == 'REGULAR' ? 'selected' : '' }}>Regular</option>
                            <option value="MALO" {{ ($infraestructura->cp_estado ?? '') == 'MALO' ? 'selected' : '' }}>Malo</option>
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
                        <input type="date" name="fecha_evaluacion" value="{{ $infraestructura->fecha_evaluacion ?? '' }}" 
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comentarios / Observaciones Generales</label>
                    <textarea name="comentarios" rows="3" 
                              class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                              placeholder="Ingrese comentarios adicionales...">{{ $infraestructura->comentarios ?? '' }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Botón Guardar -->
        <div class="flex justify-end pt-4">
            <button type="submit" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                <i class="fas fa-save"></i>
                Guardar Datos de Infraestructura
            </button>
        </div>
    </form>
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