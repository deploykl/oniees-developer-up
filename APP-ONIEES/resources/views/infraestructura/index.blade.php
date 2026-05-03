<x-app-layout>
    <script>
        // Store global para compartir el estado de las pestañas
        document.addEventListener('alpine:init', () => {
            Alpine.store('tabs', {
                activeTab: localStorage.getItem('activeTab') || 'datos-generales',

                setActiveTab(tab) {
                    this.activeTab = tab;
                    localStorage.setItem('activeTab', tab);
                }
            });
        });
    </script>
    <x-slot name="title">Infraestructura - Sistema IPRESS</x-slot>

    <style>
        .two-column-layout {
            display: flex;
            gap: 1.5rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem;
        }

        .main-content {
            flex: 1;
            min-width: 0;
        }

        .right-sidebar {
            width: 320px;
            flex-shrink: 0;
            position: sticky;
            top: 20px;
            height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .tab-button {
            transition: all 0.2s ease;
        }

        .tab-button.active {
            background: linear-gradient(135deg, #1e40af, #1e3a5f);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .two-column-layout {
                flex-direction: column;
            }

            .right-sidebar {
                width: 100%;
                position: static;
                height: auto;
            }
        }

        .save-button-fixed {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 100;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .save-button-fixed {
                bottom: 1rem;
                right: 1rem;
            }
        }

        /* Sidebar tabs */
        .sidebar-tab {
            transition: all 0.2s ease;
        }

        .sidebar-tab.active {
            border-bottom-width: 2px;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        /* Para cada sección */
        .sec-scroll-target {
            scroll-margin-top: 100px;
        }
    </style>

    <div class="two-column-layout">

        <!-- CONTENIDO PRINCIPAL CON PESTAÑAS -->
        <div class="main-content">
            <!-- Buscador de establecimientos - SOLO PARA ADMIN -->
            @hasrole('Admin')
                @if (isset($showSelector) && $showSelector)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-4">
                        <h5 class="font-bold mb-2">🔍 Buscar establecimiento</h5>
                        <div class="flex gap-3">
                            <input type="text" id="buscar_codigo" class="flex-1 px-3 py-2 border rounded-lg"
                                placeholder="Código RENIPRESS">
                            <button type="button" id="btn_buscar"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Buscar</button>
                        </div>
                        <div id="resultado_busqueda" class="mt-3"></div>
                    </div>
                @else
                    <!-- Botón para buscar otro establecimiento (si ya hay uno seleccionado) -->
                    <div x-data="{ showSearch: false }" class="mb-4">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h5 class="font-bold mb-1">🏥 Establecimiento actual:
                                        {{ $establecimiento->nombre_eess ?? 'Sin nombre' }}</h5>
                                    <p class="text-sm text-gray-600">Código: {{ $establecimiento->codigo ?? 'N/A' }}</p>
                                </div>
                                <button @click="showSearch = !showSearch"
                                    class="px-4 py-2 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2"
                                    style="background: linear-gradient(135deg, #0E7C9E, #0a637f);">
                                    <i class="fas fa-search"></i>
                                    <span>Buscar otro establecimiento</span>
                                </button>
                            </div>
                        </div>

                        <div x-show="showSearch" x-collapse
                            class="mt-3 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                            <h5 class="font-bold mb-2">🔍 Buscar otro establecimiento</h5>
                            <div class="flex gap-3">
                                <input type="text" id="buscar_codigo_2" class="flex-1 px-3 py-2 border rounded-lg"
                                    placeholder="Código RENIPRESS">
                                <button type="button" id="btn_buscar_2"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Buscar</button>
                            </div>
                            <div id="resultado_busqueda_2" class="mt-3"></div>
                        </div>
                    </div>
                @endif
            @endhasrole

            <div x-data class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="$store.tabs.setActiveTab('datos-generales')"
                            :class="{ 'border-blue-500 text-blue-600': $store.tabs
                                .activeTab === 'datos-generales', 'border-transparent text-gray-500': $store.tabs
                                    .activeTab !== 'datos-generales' }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors">
                            <i class="fas fa-building mr-2"></i> Datos Generales
                        </button>
                        <button @click="$store.tabs.setActiveTab('infraestructura')"
                            :class="{ 'border-teal-500 text-teal-600': $store.tabs
                                .activeTab === 'infraestructura', 'border-transparent text-gray-500': $store.tabs
                                    .activeTab !== 'infraestructura' }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors">
                            <i class="fas fa-hard-hat mr-2"></i> Infraestructura
                        </button>
                        <button @click="$store.tabs.setActiveTab('servicios-basicos')"
                            :class="{ 'border-cyan-500 text-cyan-600': $store.tabs
                                .activeTab === 'servicios-basicos', 'border-transparent text-gray-500': $store.tabs
                                    .activeTab !== 'servicios-basicos' }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors">
                            <i class="fas fa-water mr-2"></i> Servicios Básicos
                        </button>
                    </nav>
                </div>

                <form method="POST" action="{{ route('infraestructura.save') }}" id="mainForm">
                    @csrf
                    <input type="hidden" name="id_establecimiento" value="{{ $establecimiento->id ?? '' }}">

                    <div x-show="$store.tabs.activeTab === 'datos-generales'" class="p-6">
                        @include('infraestructura.partials.datos-generales')
                    </div>
                    <div x-show="$store.tabs.activeTab === 'servicios-basicos'" class="p-6" x-cloak>
                        @include('infraestructura.partials.servicios-basicos')
                    </div>
                    <div x-show="$store.tabs.activeTab === 'infraestructura'" class="p-6" x-cloak>
                        @include('infraestructura.partials.infraestructura')
                    </div>
                </form>
            </div>
        </div>
        <!-- ✅ MODAL FUERA DEL FORMULARIO PRINCIPAL -->
        <!-- SIDEBAR DERECHO DE PROGRESO CON PESTAÑAS -->
        <div class="right-sidebar" x-data="progressSidebar()" x-init="initProgress()">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden sticky top-20">
                <div class="bg-gradient-to-r from-[#0E7C9E] to-[#0a637f] p-4">
                    <h2 class="text-sm font-bold text-white">📊 Progreso del Formulario</h2>
                    <p class="text-xs text-blue-100 truncate mt-1">
                        {{ $establecimiento->nombre_eess ?? 'Sin establecimiento' }}</p>
                </div>

                <!-- Progreso Total General -->
                <div class="p-4 bg-gray-50 border-b">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progreso Total</span>
                        <span class="font-bold text-blue-600" x-text="totalProgress + '%'"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-teal-500 h-2 rounded-full transition-all duration-500"
                            :style="{ width: totalProgress + '%' }"></div>
                    </div>
                </div>
                <!-- Botón Guardar Cambios -->
                <div class="p-4 border-t border-gray-200 bg-white" x-data="{ saving: false }">
                    <button type="submit" form="mainForm"
                        @click="saving = true; setTimeout(() => saving = false, 3000)"
                        class="w-full px-4 py-3 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 font-medium"
                        style="background: linear-gradient(135deg, #0E7C9E, #0a637f);">
                        <i class="fas" :class="saving ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                        <span x-text="saving ? 'Guardando...' : 'Guardar Cambios'"></span>
                    </button>
                </div>
                <!-- PESTAÑAS DEL SIDEBAR -->
                <div class="border-b border-gray-200">
                    <div class="flex">
                        <button
                            @click="$store.tabs.setActiveTab('datos-generales'); activeSidebarTab = 'datos-generales'"
                            :class="activeSidebarTab === 'datos-generales' ? 'border-blue-500 text-blue-600 bg-blue-50' :
                                'border-transparent text-gray-500 hover:text-gray-700'"
                            class="flex-1 px-3 py-2 text-xs font-medium border-b-2 transition-colors sidebar-tab">
                            <i class="fas fa-building mr-1"></i> Datos Grales
                        </button>
                        <button
                            @click="$store.tabs.setActiveTab('infraestructura'); activeSidebarTab = 'infraestructura'"
                            :class="activeSidebarTab === 'infraestructura' ? 'border-teal-500 text-teal-600 bg-teal-50' :
                                'border-transparent text-gray-500 hover:text-gray-700'"
                            class="flex-1 px-3 py-2 text-xs font-medium border-b-2 transition-colors sidebar-tab">
                            <i class="fas fa-hard-hat mr-1"></i> Infraestructura
                        </button>
                        <button
                            @click="$store.tabs.setActiveTab('servicios-basicos'); activeSidebarTab = 'servicios-basicos'"
                            :class="activeSidebarTab === 'servicios-basicos' ? 'border-cyan-500 text-cyan-600 bg-cyan-50' :
                                'border-transparent text-gray-500 hover:text-gray-700'"
                            class="flex-1 px-3 py-2 text-xs font-medium border-b-2 transition-colors sidebar-tab">
                            <i class="fas fa-water mr-1"></i> Servicios
                        </button>
                    </div>
                </div>

                <!-- CONTENIDO DE PESTAÑAS DEL SIDEBAR -->
                <div class="p-2">
                    <!-- TAB DATOS GENERALES -->
                    <div x-show="activeSidebarTab === 'datos-generales'" class="space-y-1">
                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1">📋 SECCIONES</div>

                        <div @click="scrollToSection('sec-datos-generales')"
                            class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-hospital text-blue-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">Datos Generales</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-datos-generales'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-datos-generales'].completed + '/' + sections['sec-datos-generales'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-datos-generales'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-blue-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-datos-generales'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-red-diresa')"
                            class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-shield-alt text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">RED/DIRESA</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-red-diresa'].percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="sections['sec-red-diresa'].completed + '/' + sections['sec-red-diresa'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-red-diresa'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-red-diresa'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-datos-adicionales')"
                            class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-database text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">Datos Adicionales</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-datos-adicionales'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-datos-adicionales'].completed + '/' + sections['sec-datos-adicionales'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-datos-adicionales'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-datos-adicionales'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-localizacion')"
                            class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-map-marked-alt text-blue-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">Localización</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-localizacion'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-localizacion'].completed + '/' + sections['sec-localizacion'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-localizacion'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-blue-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-localizacion'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-seguridad')"
                            class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-shield-virus text-red-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">Seguridad Hospitalaria</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-seguridad'].percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="sections['sec-seguridad'].completed + '/' + sections['sec-seguridad'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-seguridad'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-red-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-seguridad'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-patrimonio')"
                            class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-landmark text-purple-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">Patrimonio Cultural</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-patrimonio'].percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="sections['sec-patrimonio'].completed + '/' + sections['sec-patrimonio'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-patrimonio'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-purple-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-patrimonio'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-director')"
                            class="p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-user-tie text-gray-600 text-xs w-4"></i><span
                                        class="text-xs font-medium">Director / Administrador</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-director'].percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="sections['sec-director'].completed + '/' + sections['sec-director'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-director'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-gray-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-director'].percent + '%' }"></div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB INFRAESTRUCTURA -->
                    <div x-show="activeSidebarTab === 'infraestructura'" class="space-y-1">
                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1">🏗️ SECCIONES</div>

                        <div @click="scrollToSection('sec-saneamiento')"
                            class="p-2 rounded-lg hover:bg-teal-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-file-signature text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">1. Saneamiento Físico Legal</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-saneamiento'].percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="sections['sec-saneamiento'].completed + '/' + sections['sec-saneamiento'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-saneamiento'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-saneamiento'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-planos-fisico')"
                            class="p-2 rounded-lg hover:bg-teal-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-drafting-compass text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">2. Planos Técnicos (Físico)</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-planos-fisico'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-planos-fisico'].completed + '/' + sections['sec-planos-fisico'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-planos-fisico'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-planos-fisico'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-planos-digital')"
                            class="p-2 rounded-lg hover:bg-teal-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-laptop-code text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">2.1 Planos Técnicos (Digital)</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-planos-digital'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-planos-digital'].completed + '/' + sections['sec-planos-digital'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-planos-digital'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-planos-digital'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-acabados-exteriores')"
                            class="p-2 rounded-lg hover:bg-teal-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-paint-roller text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">3.1 Acabados Exteriores</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-acabados-exteriores'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-acabados-exteriores'].completed + '/' + sections['sec-acabados-exteriores'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-acabados-exteriores'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-acabados-exteriores'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-edificaciones')"
                            class="p-2 rounded-lg hover:bg-teal-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-building text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">3.2 Edificación y Acabados</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-edificaciones'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-edificaciones'].completed + '/' + sections['sec-edificaciones'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-edificaciones'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-edificaciones'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-analisis-infra')"
                            class="p-2 rounded-lg hover:bg-teal-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-chart-line text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">3.3 Análisis Infraestructura</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-analisis-infra'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-analisis-infra'].completed + '/' + sections['sec-analisis-infra'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-analisis-infra'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-analisis-infra'].percent + '%' }"></div>
                            </div>
                        </div>

                    <!--  !-- Solo mostrar esta sección si el establecimiento es un hospital 
                        <div @click="scrollToSection('sec-operatividad')"
                            class="p-2 rounded-lg hover:bg-teal-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-chart-simple text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">3.6 Operatividad</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-operatividad'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-operatividad'].completed + '/' + sections['sec-operatividad'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-operatividad'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-operatividad'].percent + '%' }"></div>
                            </div>
                        </div>
-->
                        <div @click="scrollToSection('sec-fotos')"
                            class="p-2 rounded-lg hover:bg-teal-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-camera text-teal-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">4. Fotos</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-fotos'].percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="sections['sec-fotos'].completed + '/' + sections['sec-fotos'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-fotos'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-teal-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-fotos'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-archivos')"
                            class="p-2 rounded-lg hover:bg-amber-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-folder-open text-amber-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">5. Archivos</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-archivos'].percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="sections['sec-archivos'].completed + '/' + sections['sec-archivos'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-archivos'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-amber-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-archivos'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-accesibilidad')"
                            class="p-2 rounded-lg hover:bg-purple-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-wheelchair text-purple-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">6. Accesibilidad</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-accesibilidad'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-accesibilidad'].completed + '/' + sections['sec-accesibilidad'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-accesibilidad'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-purple-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-accesibilidad'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-ubicacion')"
                            class="p-2 rounded-lg hover:bg-emerald-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-map-marker-alt text-emerald-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">7. Ubicación y Entorno</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-ubicacion'].percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="sections['sec-ubicacion'].completed + '/' + sections['sec-ubicacion'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-ubicacion'].percent + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-emerald-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-ubicacion'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-circulacion-horizontal')"
                            class="p-2 rounded-lg hover:bg-pink-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-arrows-alt-h text-pink-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">8. Circulación Horizontal</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-circulacion-horizontal'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-circulacion-horizontal'].completed + '/' + sections['sec-circulacion-horizontal'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-circulacion-horizontal'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-pink-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-circulacion-horizontal'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-circulacion-vertical')"
                            class="p-2 rounded-lg hover:bg-indigo-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-arrows-alt-v text-indigo-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">9. Circulación Vertical</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-circulacion-vertical'].percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="sections['sec-circulacion-vertical'].completed + '/' + sections['sec-circulacion-vertical'].total"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + sections['sec-circulacion-vertical'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-indigo-500 h-1 rounded-full transition-all"
                                    :style="{ width: sections['sec-circulacion-vertical'].percent + '%' }"></div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB SERVICIOS BÁSICOS -->
                    <!-- TAB SERVICIOS BÁSICOS -->
                    <div x-show="activeSidebarTab === 'servicios-basicos'" class="space-y-1">
                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1">💧 AGUA Y SANEAMIENTO</div>

                        <div @click="scrollToSection('sec-agua')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-tint text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">1. Agua</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-agua']?.percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="(sections['sec-agua']?.completed || 0) + '/' + (sections['sec-agua']?.total || 12)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-agua']?.percent || 0) + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-agua']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-desague')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-toilet text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">2. Desagüe/Alcantarillado</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-desague']?.percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="(sections['sec-desague']?.completed || 0) + '/' + (sections['sec-desague']?.total || 5)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-desague']?.percent || 0) + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-desague']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1 mt-2">⚡ ENERGÍA</div>

                        <div @click="scrollToSection('sec-electricidad')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-bolt text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">3. Electricidad</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-electricidad']?.percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-electricidad']?.completed || 0) + '/' + (sections['sec-electricidad']?.total || 8)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-electricidad']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-electricidad']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1 mt-2">📡 COMUNICACIONES</div>

                        <div @click="scrollToSection('sec-telefonia')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-phone text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">4. Telefonía Fija</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-telefonia']?.percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="(sections['sec-telefonia']?.completed || 0) + '/' + (sections['sec-telefonia']?.total || 7)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-telefonia']?.percent || 0) + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-telefonia']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-internet')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-wifi text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">5. Internet</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-internet']?.percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="(sections['sec-internet']?.completed || 0) + '/' + (sections['sec-internet']?.total || 15)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-internet']?.percent || 0) + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-internet']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-television')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-tv text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">6. Televisión</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-television']?.percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="(sections['sec-television']?.completed || 0) + '/' + (sections['sec-television']?.total || 8)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-television']?.percent || 0) + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-television']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-red-movil')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-signal text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">7. Red Móvil</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-red-movil']?.percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="(sections['sec-red-movil']?.completed || 0) + '/' + (sections['sec-red-movil']?.total || 8)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-red-movil']?.percent || 0) + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-red-movil']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1 mt-2">🔥 GAS</div>

                        <div @click="scrollToSection('sec-gas')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-fire text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">8. Gas Natural o GLP</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-gas']?.percent === 100 ? 'text-green-600' : 'text-gray-500'"
                                        x-text="(sections['sec-gas']?.completed || 0) + '/' + (sections['sec-gas']?.total || 8)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-gas']?.percent || 0) + '%)'"></span></div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-gas']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1 mt-2">🗑️ RESIDUOS</div>

                        <div @click="scrollToSection('sec-residuos-solidos')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-trash-alt text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">9. Residuos Sólidos</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-residuos-solidos']?.percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-residuos-solidos']?.completed || 0) + '/' + (sections['sec-residuos-solidos']?.total || 8)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-residuos-solidos']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-residuos-solidos']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-residuos-hospitalarios')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-biohazard text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">10. Residuos Hospitalarios</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-residuos-hospitalarios']?.percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-residuos-hospitalarios']?.completed || 0) + '/' + (sections['sec-residuos-hospitalarios']?.total || 8)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-residuos-hospitalarios']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-residuos-hospitalarios']?.percent || 0) + '%' }">
                                </div>
                            </div>
                        </div>

                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1 mt-2">👥 SERVICIOS COLECTIVOS
                        </div>

                        <div @click="scrollToSection('sec-personal-salud')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-user-md text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">11. Personal de Salud</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-personal-salud']?.percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-personal-salud']?.completed || 0) + '/' + (sections['sec-personal-salud']?.total || 4)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-personal-salud']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-personal-salud']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-personal-externo')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-users text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">12. Personal Externo/Paciente</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-personal-externo']?.percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-personal-externo']?.completed || 0) + '/' + (sections['sec-personal-externo']?.total || 4)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-personal-externo']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-personal-externo']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-personal-discapacitado')"
                            class="p-2 rounded-lg hover:bg-cyan-50 cursor-pointer transition">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2"><i
                                        class="fas fa-wheelchair text-cyan-500 text-xs w-4"></i><span
                                        class="text-xs font-medium">13. Personal Discapacitado</span></div>
                                <div class="flex items-center gap-1"><span class="text-xs font-mono"
                                        :class="sections['sec-personal-discapacitado']?.percent === 100 ? 'text-green-600' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-personal-discapacitado']?.completed || 0) + '/' + (sections['sec-personal-discapacitado']?.total || 4)"></span><span
                                        class="text-xs text-gray-400"
                                        x-text="'(' + (sections['sec-personal-discapacitado']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all"
                                    :style="{ width: (sections['sec-personal-discapacitado']?.percent || 0) + '%' }">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen rápido -->
                <div class="border-t border-gray-200 p-3 bg-gray-50">
                    <div class="flex justify-between text-xs mb-2">
                        <span class="text-gray-600">✅ Completado:</span>
                        <span class="font-bold text-green-600" x-text="totalProgress + '%'"></span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-600">📋 Pendiente:</span>
                        <span class="font-bold text-orange-600" x-text="(100 - totalProgress) + '%'"></span>
                    </div>
                </div>


            </div>
        </div>

    </div>
    @include('infraestructura.partials.modal.modal-edificacion')
    @include('infraestructura.partials.modal.modal-acabados')



    <script>
        // Notificaciones usando el sistema existente
        document.addEventListener('DOMContentLoaded', function() {
            // Usar el sistema de toast que ya tienes
            setTimeout(() => {
                @if (session('success'))
                    if (window.toast && window.toast.success) {
                        window.toast.success("{{ session('success') }}", 4000);
                    }
                @endif

                @if (session('error'))
                    if (window.toast && window.toast.error) {
                        window.toast.error("{{ session('error') }}", 5000);
                    }
                @endif

                @if (session('warning'))
                    if (window.toast && window.toast.warning) {
                        window.toast.warning("{{ session('warning') }}", 4000);
                    }
                @endif

                @if (session('info'))
                    if (window.toast && window.toast.info) {
                        window.toast.info("{{ session('info') }}", 4000);
                    }
                @endif
            }, 500); // Pequeño delay para asegurar que el toast esté listo
        });

        function progressSidebar() {
            return {
                activeSidebarTab: localStorage.getItem('activeSidebarTab') ||
                    'datos-generales', // Predeterminado a 'infraestructura'
                sections: {

                    // ============================================
                    // Secciones para 'datos-generales'
                    // ============================================
                    'sec-datos-generales': {
                        completed: 0,
                        total: 18,
                        percent: 0
                    },
                    'sec-red-diresa': {
                        completed: 0,
                        total: 8,
                        percent: 0
                    },
                    'sec-datos-adicionales': {
                        completed: 0,
                        total: 6,
                        percent: 0
                    },
                    'sec-localizacion': {
                        completed: 0,
                        total: 5,
                        percent: 0
                    },
                    'sec-seguridad': {
                        completed: 0,
                        total: 1,
                        percent: 0
                    },
                    'sec-patrimonio': {
                        completed: 0,
                        total: 1,
                        percent: 0
                    },
                    'sec-director': {
                        completed: 0,
                        total: 9,
                        percent: 0
                    },
                    // ============================================
                    // Secciones para 'infraestructura'
                    // ============================================
                    'sec-saneamiento': {
                        completed: 0,
                        total: 11,
                        percent: 0
                    },
                    'sec-planos-fisico': {
                        completed: 0,
                        total: 9,
                        percent: 0
                    },
                    'sec-planos-digital': {
                        completed: 0,
                        total: 9,
                        percent: 0
                    },
                    'sec-acabados-exteriores': {
                        completed: 0,
                        total: 10,
                        percent: 0
                    },
                    'sec-edificaciones': {
                        completed: 0,
                        total: 1,
                        percent: 0
                    },
                    'sec-analisis-infra': {
                        completed: 0,
                        total: 23,
                        percent: 0
                    },
                    'sec-entorno': {
                        completed: 0,
                        total: 5,
                        percent: 0
                    },
                    'sec-observaciones': {
                        completed: 0,
                        total: 1,
                        percent: 0
                    },
                    'sec-tipo-intervencion': {
                        completed: 0,
                        total: 4,
                        percent: 0
                    },
                    'sec-operatividad': {
                        completed: 0,
                        total: 1,
                        percent: 0
                    },
                    'sec-fotos': {
                        completed: 0,
                        total: 1,
                        percent: 0
                    },
                    'sec-archivos': {
                        completed: 0,
                        total: 1,
                        percent: 0
                    },
                    'sec-accesibilidad': {
                        completed: 0,
                        total: 4,
                        percent: 0
                    },
                    'sec-ubicacion': {
                        completed: 0,
                        total: 13,
                        percent: 0
                    },
                    'sec-circulacion-horizontal': {
                        completed: 0,
                        total: 10,
                        percent: 0
                    },
                    'sec-circulacion-vertical': {
                        completed: 0,
                        total: 10,
                        percent: 0
                    },


                    // ============================================
                    // Secciones para 'servicios-basicos'
                    // ============================================
                    // AGUA
                    'sec-agua': {
                        completed: 0,
                        total: 8, // Campos: se_agua, se_agua_otro, se_agua_operativo, se_agua_estado, se_sevicio_semana, se_horas_dia, se_sevicio_semana_calculo, se_servicio_agua(2 radios), se_empresa_agua
                        percent: 0
                    },
                    // DESAGÜE
                    'sec-desague': {
                        completed: 0,
                        total: 3, // Campos: se_desague, se_desague_otro, se_desague_operativo, se_desague_estado
                        percent: 0
                    },
                    // ELECTRICIDAD
                    'sec-electricidad': {
                        completed: 0,
                        total: 6, // Campos: se_electricidad, se_electricidad_operativo, se_electricidad_estado, se_electricidad_option, se_electricidad_fuente, se_electricidad_proveedor_ruc
                        percent: 0
                    },
                    // TELEFONÍA
                    'sec-telefonia': {
                        completed: 0,
                        total: 6, // Campos: se_telefonia, se_telefonia_operativo, se_telefonia_estado, se_telefonia_option, se_telefonia_proveedor, se_telefonia_proveedor_ruc
                        percent: 0
                    },
                    // INTERNET
                    'sec-internet': {
                        completed: 0,
                        total: 14, // Campos: se_internet, se_internet_operativo, se_internet_estado, se_internet_option, se_internet_proveedor, se_internet_proveedor_ruc, internet_conexion, internet_operador, internet_continuidad, internet_red, internet_porcentaje, internet_transmision, internet_option2, internet_servicio
                        percent: 0
                    },
                    // TELEVISIÓN
                    'sec-television': {
                        completed: 0,
                        total: 7, // Campos: televicion, televicion_operador, televicion_option1, televicion_espera, televicion_porcentaje, televicion_antena, televicion_equipo
                        percent: 0
                    },
                    // RED MÓVIL
                    'sec-red-movil': {
                        completed: 0,
                        total: 6, // Campos: se_red, se_red_operativo, se_red_estado, se_red_option, se_red_proveedor, se_red_proveedor_ruc
                        percent: 0
                    },
                    // GAS
                    'sec-gas': {
                        completed: 0,
                        total: 6, // Campos: se_gas, se_gas_operativo, se_gas_estado, se_gas_option, se_gas_proveedor, se_gas_proveedor_ruc
                        percent: 0
                    },
                    // RESIDUOS SÓLIDOS
                    'sec-residuos-solidos': {
                        completed: 0,
                        total: 6, // Campos: se_residuos, se_residuos_operativo, se_residuos_estado, se_residuos_option, se_residuos_proveedor, se_residuos_proveedor_ruc
                        percent: 0
                    },
                    // RESIDUOS HOSPITALARIOS
                    'sec-residuos-hospitalarios': {
                        completed: 0,
                        total: 6, // Campos: se_residuos_h, se_residuos_h_operativo, se_residuos_h_estado, se_residuos_h_option, se_residuos_h_proveedor, se_residuos_h_proveedor_ruc
                        percent: 0
                    },

                    // ============================================
                    // Secciones para 'servicios-colectivos'
                    // ============================================
                    // PERSONAL DE SALUD
                    'sec-personal-salud': {
                        completed: 0,
                        total: 4, // Campos: sc_personal, sc_personal_operativo, sc_personal_estado, sc_personal_option
                        percent: 0
                    },
                    // PERSONAL EXTERNO / PACIENTE
                    'sec-personal-externo': {
                        completed: 0,
                        total: 4, // Campos: sc_sshh, sc_sshh_operativo, sc_sshh_estado, sc_sshh_option
                        percent: 0
                    },
                    // PERSONAL DISCAPACITADO
                    'sec-personal-discapacitado': {
                        completed: 0,
                        total: 4, // Campos: sc_vestidores, sc_vestidores_operativo, sc_vestidores_estado, sc_vestidores_option
                        percent: 0
                    }
                },

                totalProgress: 0,

                initProgress() {
                    // Escuchar eventos de progreso de secciones
                    window.addEventListener('sectionProgress', (e) => {
                        if (this.sections[e.detail.section]) {
                            this.sections[e.detail.section].completed = e.detail.filled;
                            this.sections[e.detail.section].total = e.detail.total;
                            this.sections[e.detail.section].percent = e.detail.percent;
                            this.calculateTotal();
                        }
                    });

                    // 👇 NUEVO: Sincronizar activeSidebarTab con el store global
                    this.$watch('$store.tabs.activeTab', (value) => {
                        this.activeSidebarTab = value;
                        localStorage.setItem('activeSidebarTab', value);
                    });

                    // Forzar eventos iniciales después de que todo cargue
                    setTimeout(() => {
                        // Sincronizar estado inicial
                        this.activeSidebarTab = Alpine.store('tabs').activeTab;

                        // Disparar eventos manualmente para seguridad y patrimonio
                        const secSeguridad = document.getElementById('sec-seguridad');
                        if (secSeguridad && secSeguridad.__x) {
                            secSeguridad.__x.$data.update();
                        }
                        const secPatrimonio = document.getElementById('sec-patrimonio');
                        if (secPatrimonio && secPatrimonio.__x) {
                            secPatrimonio.__x.$data.update();
                        }
                        this.calculateTotal();
                        this.$watch('activeSidebarTab', val => localStorage.setItem('activeSidebarTab', val));
                    }, 500);
                },
                calculateTotal() {
                    let totalCompleted = 0;
                    let totalFields = 0;
                    for (let key in this.sections) {
                        totalCompleted += this.sections[key].completed;
                        totalFields += this.sections[key].total;
                    }
                    let rawProgress = totalFields > 0 ? Math.round((totalCompleted / totalFields) * 100) : 0;
                    this.totalProgress = Math.min(rawProgress, 100);
                },

                scrollToSection(sectionId) {
                    const element = document.getElementById(sectionId);
                    if (element) {
                        // Determinar a qué pestaña pertenece la sección
                        const seccionesDatosGenerales = ['sec-datos-generales', 'sec-red-diresa', 'sec-datos-adicionales',
                            'sec-localizacion', 'sec-seguridad', 'sec-patrimonio', 'sec-director'
                        ];
                        const seccionesInfraestructura = ['sec-saneamiento', 'sec-planos-fisico', 'sec-planos-digital',
                            'sec-acabados-exteriores', 'sec-edificaciones', 'sec-analisis-infra', 'sec-entorno',
                            'sec-observaciones', 'sec-tipo-intervencion', 'sec-operatividad', 'sec-fotos',
                            'sec-archivos', 'sec-accesibilidad', 'sec-ubicacion', 'sec-circulacion-horizontal',
                            'sec-circulacion-vertical'
                        ];
                        const seccionesServiciosBasicos = ['sec-agua', 'sec-desague', 'sec-electricidad', 'sec-telefonia',
                            'sec-internet', 'sec-television', 'sec-red-movil', 'sec-gas', 'sec-residuos-solidos',
                            'sec-residuos-hospitalarios', 'sec-personal-salud', 'sec-personal-externo',
                            'sec-personal-discapacitado'
                        ];

                        // Usar el store global para cambiar la pestaña
                        if (seccionesDatosGenerales.includes(sectionId)) {
                            window.Alpine.store('tabs').setActiveTab('datos-generales');
                            this.activeSidebarTab = 'datos-generales';
                        } else if (seccionesInfraestructura.includes(sectionId)) {
                            window.Alpine.store('tabs').setActiveTab('infraestructura');
                            this.activeSidebarTab = 'infraestructura';
                        } else if (seccionesServiciosBasicos.includes(sectionId)) {
                            window.Alpine.store('tabs').setActiveTab('servicios-basicos');
                            this.activeSidebarTab = 'servicios-basicos';
                        }

                        // Resto del código de scroll...
                        setTimeout(() => {
                            const headerOffset = 90;
                            const elementPosition = element.getBoundingClientRect().top;
                            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                        }, 150);
                    }
                }
            };
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para buscar establecimiento
            function buscarEstablecimiento(codigo, resultadoDiv, redirectUrl) {
                if (!codigo) {
                    $('#' + resultadoDiv).html('<div class="text-red-600 text-sm">❌ Ingrese un código</div>');
                    return;
                }

                // Mostrar loading
                $('#' + resultadoDiv).html(
                    '<div class="text-center py-2"><i class="fas fa-spinner fa-spin"></i> Buscando...</div>');

                // Hacer la búsqueda vía AJAX
                $.ajax({
                    url: '/infraestructura/buscar/' + codigo,
                    method: 'GET',
                    success: function(response) {
                        if (response.id) {
                            // Redirigir al establecimiento encontrado
                            window.location.href = redirectUrl + '?cargar=' + response.id;
                        } else {
                            $('#' + resultadoDiv).html(
                                '<div class="text-red-600 text-sm">❌ Establecimiento no encontrado</div>'
                            );
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON?.error || 'Error al buscar el establecimiento';
                        $('#' + resultadoDiv).html('<div class="text-red-600 text-sm">❌ ' + errorMsg +
                            '</div>');
                    }
                });
            }

            // Buscador inicial (cuando no hay establecimiento)
            $('#btn_buscar')?.on('click', function() {
                let codigo = $('#buscar_codigo').val();
                buscarEstablecimiento(codigo, 'resultado_busqueda', '{{ route('infraestructura.edit') }}');
            });

            // Buscador secundario (cuando ya hay establecimiento)
            $('#btn_buscar_2')?.on('click', function() {
                let codigo = $('#buscar_codigo_2').val();
                buscarEstablecimiento(codigo, 'resultado_busqueda_2',
                    '{{ route('infraestructura.edit') }}');
            });

            // Permitir buscar con Enter en ambos campos
            $('#buscar_codigo, #buscar_codigo_2').on('keypress', function(e) {
                if (e.which === 13) {
                    if (this.id === 'buscar_codigo') {
                        $('#btn_buscar').click();
                    } else {
                        $('#btn_buscar_2').click();
                    }
                }
            });
        });
    </script>
</x-app-layout>
