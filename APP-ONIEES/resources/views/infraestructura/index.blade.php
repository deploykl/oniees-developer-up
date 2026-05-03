<x-app-layout>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('tabs', {
                activeTab: localStorage.getItem('activeTab') || 'datos-generales',
                progressDatosGenerales: 0,
                progressInfraestructura: 0,
                progressServiciosBasicos: 0,

                setActiveTab(tab) {
                    this.activeTab = tab;
                    localStorage.setItem('activeTab', tab);
                },

                updateProgress(datos, infra, servicios) {
                    this.progressDatosGenerales = datos;
                    this.progressInfraestructura = infra;
                    this.progressServiciosBasicos = servicios;
                }
            });
        });
    </script>
    <x-slot name="title">Infraestructura - Sistema IPRESS</x-slot>

    <style>
        /* Custom scrollbar moderno */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Hover effects suaves */
        .right-sidebar .group:hover .w-7.h-7 {
            transform: scale(1.05);
            transition: transform 0.2s ease;
        }

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
                        <!-- Datos Generales -->
                        <button @click="$store.tabs.setActiveTab('datos-generales')"
                            :class="{
                                'border-blue-500 text-blue-600': $store.tabs.activeTab === 'datos-generales',
                                'border-transparent text-gray-500': $store.tabs.activeTab !== 'datos-generales'
                            }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors flex items-center gap-2">
                            <i class="fas fa-building"></i> Datos Generales
                            <span class="text-xs bg-gray-100 rounded-full px-2 py-0.5"
                                x-text="$store.tabs.progressDatosGenerales + '%'"></span>
                        </button>

                        <!-- Infraestructura -->
                        <button @click="$store.tabs.setActiveTab('infraestructura')"
                            :class="{
                                'border-teal-500 text-teal-600': $store.tabs.activeTab === 'infraestructura',
                                'border-transparent text-gray-500': $store.tabs.activeTab !== 'infraestructura'
                            }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors flex items-center gap-2">
                            <i class="fas fa-hard-hat"></i> Infraestructura
                            <span class="text-xs bg-gray-100 rounded-full px-2 py-0.5"
                                x-text="$store.tabs.progressInfraestructura + '%'"></span>
                        </button>

                        <!-- Servicios Básicos -->
                        <button @click="$store.tabs.setActiveTab('servicios-basicos')"
                            :class="{
                                'border-cyan-500 text-cyan-600': $store.tabs.activeTab === 'servicios-basicos',
                                'border-transparent text-gray-500': $store.tabs.activeTab !== 'servicios-basicos'
                            }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors flex items-center gap-2">
                            <i class="fas fa-water"></i> Servicios Básicos
                            <span class="text-xs bg-gray-100 rounded-full px-2 py-0.5"
                                x-text="$store.tabs.progressServiciosBasicos + '%'"></span>
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

        <!-- SIDEBAR DERECHO DE PROGRESO CON PESTAÑAS -->
        <div class="right-sidebar" x-data="progressSidebar()" x-init="initProgress()">
            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-20 backdrop-blur-sm">

                <!-- Header con gradiente suave -->
                <div class="bg-gradient-to-br from-teal-600 to-teal-700 px-5 py-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/5 rounded-full -ml-10 -mb-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-2">
                            <div
                                class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-sm font-semibold text-white tracking-wide">Progreso del Formulario</h2>
                        </div>
                        <p class="text-xs text-teal-100/80 truncate">
                            {{ $establecimiento->nombre_eess ?? 'Sin establecimiento' }}</p>
                    </div>
                </div>

                <!-- Progreso Total General - Diseño tipo card -->
                <!-- Progreso Total General - Diseño tipo card con barra de colores -->
                <div class="p-5 bg-white border-b border-gray-100">
                    <div class="flex justify-between items-end mb-3">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Progreso General</span>
                        <span class="text-2xl font-bold"
                            :class="totalProgress === 100 ? 'text-emerald-600' : (totalProgress >= 70 ? 'text-teal-600' : (
                                totalProgress >= 40 ? 'text-amber-600' : 'text-red-500'))"
                            x-text="totalProgress + '%'"></span>
                    </div>
                    <div class="relative">
                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full transition-all duration-500 ease-out"
                                :class="totalProgress === 100 ? 'bg-gradient-to-r from-emerald-500 to-green-400' : (
                                    totalProgress >= 70 ? 'bg-gradient-to-r from-teal-500 to-cyan-400' : (
                                        totalProgress >= 40 ? 'bg-gradient-to-r from-amber-500 to-yellow-400' :
                                        'bg-gradient-to-r from-red-500 to-orange-400'))"
                                :style="{ width: totalProgress + '%' }"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] text-gray-400">0%</span>
                            <span class="text-[10px] text-gray-400">25%</span>
                            <span class="text-[10px] text-gray-400">50%</span>
                            <span class="text-[10px] text-gray-400">75%</span>
                            <span class="text-[10px] text-gray-400">100%</span>
                        </div>
                    </div>
                    <!-- Indicador de estado -->
                    <div class="mt-3 flex items-center justify-between text-[10px]">
                        <div class="flex items-center gap-1.5">
                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                            <span class="text-gray-400">Inicio</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                            <span class="text-gray-400">Progreso</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                            <span class="text-gray-400">Completo</span>
                        </div>
                    </div>
                </div>

                <!-- Botón Guardar Cambios - Versión minimalista -->
<div class="px-5 pt-2 pb-4 bg-white" x-data="{ saving: false, success: false }">
    <button type="submit" form="mainForm"
        @click="saving = true; success = false; setTimeout(() => { saving = false; success = true; setTimeout(() => success = false, 2000); }, 2000)"
        class="w-full px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 font-medium text-sm hover:scale-[1.02] active:scale-[0.98]">
        
        <!-- Icono dinámico -->
        <template x-if="!saving && !success">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
        </template>
        
        <template x-if="saving">
            <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
        </template>
        
        <template x-if="success">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </template>
        
        <span x-text="saving ? 'Guardando...' : (success ? '¡Guardado!' : 'Guardar Cambios')"></span>
    </button>
</div>

                <!-- PESTAÑAS DEL SIDEBAR - Diseño con píldoras -->
                <div class="px-4 pt-2 pb-3 bg-gray-50/50 border-t border-gray-100">
                    <div class="flex gap-1.5 bg-gray-100/80 rounded-xl p-1">
                        <button
                            @click="$store.tabs.setActiveTab('datos-generales'); activeSidebarTab = 'datos-generales'"
                            :class="activeSidebarTab === 'datos-generales' ? 'bg-white shadow-sm text-teal-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="flex-1 px-2 py-1.5 text-xs font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <span>Datos Grales</span>
                        </button>
                        <button
                            @click="$store.tabs.setActiveTab('infraestructura'); activeSidebarTab = 'infraestructura'"
                            :class="activeSidebarTab === 'infraestructura' ? 'bg-white shadow-sm text-teal-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="flex-1 px-2 py-1.5 text-xs font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <span>Infraestructura</span>
                        </button>
                        <button
                            @click="$store.tabs.setActiveTab('servicios-basicos'); activeSidebarTab = 'servicios-basicos'"
                            :class="activeSidebarTab === 'servicios-basicos' ? 'bg-white shadow-sm text-teal-600' :
                                'text-gray-500 hover:text-gray-700'"
                            class="flex-1 px-2 py-1.5 text-xs font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <span>Servicios</span>
                        </button>
                    </div>
                </div>

                <!-- CONTENIDO DE PESTAÑAS DEL SIDEBAR - Scroll suave -->
                <div class="p-3 max-h-[calc(100vh-420px)] overflow-y-auto custom-scrollbar">
                    <!-- TAB DATOS GENERALES -->
                    <div x-show="activeSidebarTab === 'datos-generales'" class="space-y-1">
                       
                        <!-- Cada sección con diseño moderno -->
                        <div @click="scrollToSection('sec-datos-generales')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition">
                                        <i class="fas fa-hospital text-blue-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Datos Generales</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-datos-generales'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-datos-generales'].completed + '/' + sections['sec-datos-generales'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-datos-generales'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-blue-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-datos-generales'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-red-diresa')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center group-hover:bg-teal-100 transition">
                                        <i class="fas fa-shield-alt text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">RED/DIRESA</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-red-diresa'].percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="sections['sec-red-diresa'].completed + '/' + sections['sec-red-diresa'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-red-diresa'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-red-diresa'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-datos-adicionales')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-cyan-50 rounded-lg flex items-center justify-center group-hover:bg-cyan-100 transition">
                                        <i class="fas fa-database text-cyan-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Datos Adicionales</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-datos-adicionales'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-datos-adicionales'].completed + '/' + sections['sec-datos-adicionales'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-datos-adicionales'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-datos-adicionales'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-localizacion')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition">
                                        <i class="fas fa-map-marked-alt text-blue-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Localización</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-localizacion'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-localizacion'].completed + '/' + sections['sec-localizacion'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-localizacion'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-blue-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-localizacion'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-seguridad')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-red-50 rounded-lg flex items-center justify-center group-hover:bg-red-100 transition">
                                        <i class="fas fa-shield-virus text-red-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Seguridad Hospitalaria</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-seguridad'].percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="sections['sec-seguridad'].completed + '/' + sections['sec-seguridad'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-seguridad'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-red-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-seguridad'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-patrimonio')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition">
                                        <i class="fas fa-landmark text-purple-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Patrimonio Cultural</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-patrimonio'].percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="sections['sec-patrimonio'].completed + '/' + sections['sec-patrimonio'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-patrimonio'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-purple-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-patrimonio'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-director')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition">
                                        <i class="fas fa-user-tie text-gray-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Director / Administrador</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-director'].percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="sections['sec-director'].completed + '/' + sections['sec-director'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-director'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-gray-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-director'].percent + '%' }"></div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB INFRAESTRUCTURA -->
                    <div x-show="activeSidebarTab === 'infraestructura'" class="space-y-1">
                       

                        <div @click="scrollToSection('sec-saneamiento')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-signature text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">1. Saneamiento Físico Legal</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-saneamiento'].percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="sections['sec-saneamiento'].completed + '/' + sections['sec-saneamiento'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-saneamiento'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-saneamiento'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-planos-fisico')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-drafting-compass text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">2. Planos Técnicos (Físico)</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-planos-fisico'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-planos-fisico'].completed + '/' + sections['sec-planos-fisico'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-planos-fisico'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-planos-fisico'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-planos-digital')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-laptop-code text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">2.1 Planos Técnicos
                                        (Digital)</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-planos-digital'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-planos-digital'].completed + '/' + sections['sec-planos-digital'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-planos-digital'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-planos-digital'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-acabados-exteriores')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-paint-roller text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">3.1 Acabados Exteriores</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-acabados-exteriores'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-acabados-exteriores'].completed + '/' + sections['sec-acabados-exteriores'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-acabados-exteriores'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-acabados-exteriores'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-edificaciones')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-building text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">3.2 Edificación y Acabados</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-edificaciones'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-edificaciones'].completed + '/' + sections['sec-edificaciones'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-edificaciones'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-edificaciones'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-analisis-infra')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-chart-line text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">3.3 Análisis Infraestructura</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-analisis-infra'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-analisis-infra'].completed + '/' + sections['sec-analisis-infra'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-analisis-infra'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-analisis-infra'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-fotos')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-camera text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">4. Fotos</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-fotos'].percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="sections['sec-fotos'].completed + '/' + sections['sec-fotos'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-fotos'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-fotos'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-archivos')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-amber-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-folder-open text-amber-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">5. Archivos</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-archivos'].percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="sections['sec-archivos'].completed + '/' + sections['sec-archivos'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-archivos'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-amber-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-archivos'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-accesibilidad')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-wheelchair text-purple-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">6. Accesibilidad</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-accesibilidad'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-accesibilidad'].completed + '/' + sections['sec-accesibilidad'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-accesibilidad'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-purple-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-accesibilidad'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-ubicacion')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-emerald-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-emerald-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">7. Ubicación y Entorno</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-ubicacion'].percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="sections['sec-ubicacion'].completed + '/' + sections['sec-ubicacion'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-ubicacion'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-emerald-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-ubicacion'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-circulacion-horizontal')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-pink-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-arrows-alt-h text-pink-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">8. Circulación Horizontal</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-circulacion-horizontal'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-circulacion-horizontal'].completed + '/' + sections['sec-circulacion-horizontal'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-circulacion-horizontal'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-pink-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-circulacion-horizontal'].percent + '%' }"></div>
                            </div>
                        </div>

                        <div @click="scrollToSection('sec-circulacion-vertical')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 bg-indigo-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-arrows-alt-v text-indigo-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">9. Circulación Vertical</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-circulacion-vertical'].percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="sections['sec-circulacion-vertical'].completed + '/' + sections['sec-circulacion-vertical'].total"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + sections['sec-circulacion-vertical'].percent + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-indigo-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: sections['sec-circulacion-vertical'].percent + '%' }"></div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB SERVICIOS BÁSICOS - Manteniendo la misma estructura moderna -->
                    <!-- TAB SERVICIOS BÁSICOS - Diseño moderno -->
                    <div x-show="activeSidebarTab === 'servicios-basicos'" class="space-y-1">
                       

                        <!-- 1. Agua -->
                        <div @click="scrollToSection('sec-agua')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-cyan-50 rounded-lg flex items-center justify-center group-hover:bg-cyan-100 transition">
                                        <i class="fas fa-tint text-cyan-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">1. Agua</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-agua']?.percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-agua']?.completed || 0) + '/' + (sections['sec-agua']?.total || 9)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-agua']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-agua']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <!-- 2. Desagüe/Alcantarillado -->
                        <div @click="scrollToSection('sec-desague')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-cyan-50 rounded-lg flex items-center justify-center group-hover:bg-cyan-100 transition">
                                        <i class="fas fa-toilet text-cyan-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">2. Desagüe/Alcantarillado</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-desague']?.percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-desague']?.completed || 0) + '/' + (sections['sec-desague']?.total || 3)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-desague']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-cyan-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-desague']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                      

                        <!-- 3. Electricidad -->
                        <div @click="scrollToSection('sec-electricidad')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-yellow-50 rounded-lg flex items-center justify-center group-hover:bg-yellow-100 transition">
                                        <i class="fas fa-bolt text-yellow-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">3. Electricidad</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-electricidad']?.percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="(sections['sec-electricidad']?.completed || 0) + '/' + (sections['sec-electricidad']?.total || 6)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-electricidad']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-yellow-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-electricidad']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        

                        <!-- 4. Telefonía Fija -->
                        <div @click="scrollToSection('sec-telefonia')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition">
                                        <i class="fas fa-phone text-purple-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">4. Telefonía Fija</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-telefonia']?.percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-telefonia']?.completed || 0) + '/' + (sections['sec-telefonia']?.total || 6)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-telefonia']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-purple-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-telefonia']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <!-- 5. Internet -->
                        <div @click="scrollToSection('sec-internet')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-100 transition">
                                        <i class="fas fa-wifi text-indigo-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">5. Internet</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-internet']?.percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-internet']?.completed || 0) + '/' + (sections['sec-internet']?.total || 14)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-internet']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-indigo-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-internet']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <!-- 6. Televisión -->
                        <div @click="scrollToSection('sec-television')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-red-50 rounded-lg flex items-center justify-center group-hover:bg-red-100 transition">
                                        <i class="fas fa-tv text-red-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">6. Televisión</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-television']?.percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-television']?.completed || 0) + '/' + (sections['sec-television']?.total || 7)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-television']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-red-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-television']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <!-- 7. Red Móvil -->
                        <div @click="scrollToSection('sec-red-movil')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition">
                                        <i class="fas fa-signal text-blue-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">7. Red Móvil</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-red-movil']?.percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-red-movil']?.completed || 0) + '/' + (sections['sec-red-movil']?.total || 6)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-red-movil']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-blue-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-red-movil']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                      

                        <!-- 8. Gas Natural o GLP -->
                        <div @click="scrollToSection('sec-gas')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-orange-50 rounded-lg flex items-center justify-center group-hover:bg-orange-100 transition">
                                        <i class="fas fa-fire text-orange-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">8. Gas Natural o GLP</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-gas']?.percent === 100 ? 'text-emerald-600 font-semibold' :
                                            'text-gray-500'"
                                        x-text="(sections['sec-gas']?.completed || 0) + '/' + (sections['sec-gas']?.total || 6)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-gas']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-orange-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-gas']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        

                        <!-- 9. Residuos Sólidos -->
                        <div @click="scrollToSection('sec-residuos-solidos')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100 transition">
                                        <i class="fas fa-trash-alt text-green-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">9. Residuos Sólidos</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-residuos-solidos']?.percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="(sections['sec-residuos-solidos']?.completed || 0) + '/' + (sections['sec-residuos-solidos']?.total || 6)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-residuos-solidos']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-green-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-residuos-solidos']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <!-- 10. Residuos Hospitalarios -->
                        <div @click="scrollToSection('sec-residuos-hospitalarios')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-red-50 rounded-lg flex items-center justify-center group-hover:bg-red-100 transition">
                                        <i class="fas fa-biohazard text-red-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">10. Residuos Hospitalarios</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-residuos-hospitalarios']?.percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="(sections['sec-residuos-hospitalarios']?.completed || 0) + '/' + (sections['sec-residuos-hospitalarios']?.total || 6)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-residuos-hospitalarios']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-red-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-residuos-hospitalarios']?.percent || 0) + '%' }">
                                </div>
                            </div>
                        </div>

                       

                        <!-- 11. Personal de Salud -->
                        <div @click="scrollToSection('sec-personal-salud')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center group-hover:bg-teal-100 transition">
                                        <i class="fas fa-user-md text-teal-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">11. Personal de Salud</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-personal-salud']?.percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="(sections['sec-personal-salud']?.completed || 0) + '/' + (sections['sec-personal-salud']?.total || 4)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-personal-salud']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-teal-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-personal-salud']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <!-- 12. Personal Externo/Paciente -->
                        <div @click="scrollToSection('sec-personal-externo')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition">
                                        <i class="fas fa-users text-blue-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">12. Personal
                                        Externo/Paciente</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-personal-externo']?.percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="(sections['sec-personal-externo']?.completed || 0) + '/' + (sections['sec-personal-externo']?.total || 4)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-personal-externo']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-blue-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-personal-externo']?.percent || 0) + '%' }"></div>
                            </div>
                        </div>

                        <!-- 13. Personal Discapacitado -->
                        <div @click="scrollToSection('sec-personal-discapacitado')"
                            class="group px-3 py-2 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition">
                                        <i class="fas fa-wheelchair text-purple-500 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">13. Personal Discapacitado</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-mono"
                                        :class="sections['sec-personal-discapacitado']?.percent === 100 ?
                                            'text-emerald-600 font-semibold' : 'text-gray-500'"
                                        x-text="(sections['sec-personal-discapacitado']?.completed || 0) + '/' + (sections['sec-personal-discapacitado']?.total || 4)"></span>
                                    <span class="text-[11px] text-gray-400"
                                        x-text="'(' + (sections['sec-personal-discapacitado']?.percent || 0) + '%)'"></span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mt-2">
                                <div class="bg-purple-500 h-1 rounded-full transition-all duration-300"
                                    :style="{ width: (sections['sec-personal-discapacitado']?.percent || 0) + '%' }">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen rápido - Diseño elegante -->
                <div class="border-t border-gray-100 p-4 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            <span class="text-xs font-medium text-gray-600">Completado</span>
                        </div>
                        <span class="text-sm font-bold text-emerald-600" x-text="totalProgress + '%'"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                            <span class="text-xs font-medium text-gray-600">Pendiente</span>
                        </div>
                        <span class="text-sm font-bold text-amber-600" x-text="(100 - totalProgress) + '%'"></span>
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
                totalProgressDatosGenerales: 0,
                totalProgressInfraestructura: 0,
                totalProgressServiciosBasicos: 0,
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
                        total: 9, // Campos: se_agua, se_agua_otro, se_agua_operativo, se_agua_estado, se_sevicio_semana, se_horas_dia, se_sevicio_semana_calculo, se_servicio_agua(2 radios), se_empresa_agua
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
                        total: 1, // Campos: sc_personal, sc_personal_operativo, sc_personal_estado, sc_personal_option
                        percent: 0
                    },
                    // PERSONAL EXTERNO / PACIENTE
                    'sec-personal-externo': {
                        completed: 0,
                        total: 1, // Campos: sc_sshh, sc_sshh_operativo, sc_sshh_estado, sc_sshh_option
                        percent: 0
                    },
                    // PERSONAL DISCAPACITADO
                    'sec-personal-discapacitado': {
                        completed: 0,
                        total: 1, // Campos: sc_vestidores, sc_vestidores_operativo, sc_vestidores_estado, sc_vestidores_option
                        percent: 0
                    }
                },

                totalProgress: 0,

                initProgress() {
                    // Escuchar eventos de progreso de secciones
                    window.addEventListener('sectionProgress', (e) => {
                        // Actualizar el sidebar con los valores del evento
                        if (this.sections[e.detail.section]) {
                            this.sections[e.detail.section].completed = e.detail.filled;
                            this.sections[e.detail.section].total = e.detail.total;
                            this.sections[e.detail.section].percent = e.detail.percent;
                        }
                        // Recalcular progreso total desde el DOM (fuente de verdad)
                        this.actualizarDesdeDOM();
                    });

                    // Sincronizar activeSidebarTab con el store global
                    this.$watch('$store.tabs.activeTab', (value) => {
                        this.activeSidebarTab = value;
                        localStorage.setItem('activeSidebarTab', value);
                    });

                    // Forzar la actualización inicial
                    setTimeout(() => {
                        this.activeSidebarTab = Alpine.store('tabs').activeTab;
                        this.actualizarDesdeDOM();
                        this.$watch('activeSidebarTab', val => localStorage.setItem('activeSidebarTab', val));
                    }, 500);
                },

                calculateTotal() {
                    // Usar los valores del DOM directamente
                    this.actualizarDesdeDOM();
                },

                actualizarDesdeDOM() {
                    let totalCompleted = 0;
                    let totalFields = 0;

                    // Variables para progreso por pestaña
                    let datosGenCompleted = 0;
                    let datosGenTotal = 0;
                    let infraCompleted = 0;
                    let infraTotal = 0;
                    let serviciosCompleted = 0;
                    let serviciosTotal = 0;

                    // Secciones de Datos Generales
                    const datosGeneralesIds = ['sec-datos-generales', 'sec-red-diresa', 'sec-datos-adicionales',
                        'sec-localizacion', 'sec-seguridad', 'sec-patrimonio', 'sec-director'
                    ];

                    // Secciones de Infraestructura
                    const infraestructuraIds = ['sec-saneamiento', 'sec-planos-fisico', 'sec-planos-digital',
                        'sec-acabados-exteriores', 'sec-edificaciones', 'sec-analisis-infra',
                        'sec-fotos', 'sec-archivos', 'sec-accesibilidad', 'sec-ubicacion',
                        'sec-circulacion-horizontal', 'sec-circulacion-vertical'
                    ];

                    // Secciones de Servicios Básicos
                    const serviciosBasicosIds = ['sec-agua', 'sec-desague', 'sec-electricidad', 'sec-telefonia',
                        'sec-internet', 'sec-television', 'sec-red-movil', 'sec-gas',
                        'sec-residuos-solidos', 'sec-residuos-hospitalarios',
                        'sec-personal-salud', 'sec-personal-externo', 'sec-personal-discapacitado'
                    ];

                    document.querySelectorAll('.form-section').forEach(section => {
                        const sectionId = section.id;
                        const counter = section.querySelector('.counter-number');

                        if (counter && this.sections[sectionId]) {
                            const texto = counter.innerText;
                            const [completado, total] = texto.split('/').map(Number);

                            this.sections[sectionId].completed = completado;
                            this.sections[sectionId].total = total;
                            this.sections[sectionId].percent = completado === total ? 100 : Math.round((completado /
                                total) * 100);

                            totalCompleted += completado;
                            totalFields += total;

                            // Sumar por categoría
                            if (datosGeneralesIds.includes(sectionId)) {
                                datosGenCompleted += completado;
                                datosGenTotal += total;
                            } else if (infraestructuraIds.includes(sectionId)) {
                                infraCompleted += completado;
                                infraTotal += total;
                            } else if (serviciosBasicosIds.includes(sectionId)) {
                                serviciosCompleted += completado;
                                serviciosTotal += total;
                            }
                        }
                    });

                    // Calcular porcentajes por pestaña
                    this.totalProgressDatosGenerales = datosGenTotal > 0 ? Math.round((datosGenCompleted / datosGenTotal) *
                        100) : 0;
                    this.totalProgressInfraestructura = infraTotal > 0 ? Math.round((infraCompleted / infraTotal) * 100) :
                        0;
                    this.totalProgressServiciosBasicos = serviciosTotal > 0 ? Math.round((serviciosCompleted /
                        serviciosTotal) * 100) : 0;

                    let rawProgress = totalFields > 0 ? Math.round((totalCompleted / totalFields) * 100) : 0;
                    this.totalProgress = Math.min(rawProgress, 100);

                    // 👇 ACTUALIZAR EL STORE GLOBAL
                    Alpine.store('tabs').updateProgress(
                        this.totalProgressDatosGenerales,
                        this.totalProgressInfraestructura,
                        this.totalProgressServiciosBasicos
                    );
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
        // Función para formatear código a 8 dígitos con ceros a la izquierda
        function formatearCodigo(codigo) {
            codigo = codigo.trim();
            if (!codigo) return '';
            // Si es solo números, agregar ceros a la izquierda hasta 8 dígitos
            if (/^\d+$/.test(codigo)) {
                return codigo.padStart(8, '0');
            }
            return codigo;
        }
        
        function buscarEstablecimiento(codigo, resultadoDiv, redirectUrl) {
            if (!codigo) {
                $('#' + resultadoDiv).html('<div class="text-red-600 text-sm">❌ Ingrese un código</div>');
                return;
            }
            
            var codigoOriginal = codigo;
            var codigoFormateado = formatearCodigo(codigo);
            
            $('#' + resultadoDiv).html('<div class="text-center py-2"><i class="fas fa-spinner fa-spin"></i> Buscando código: ' + codigoFormateado + '...</div>');
            
            $.ajax({
                url: '/infraestructura/buscar/' + codigoFormateado,
                method: 'GET',
                success: function(response) {
                    if (response.id) {
                        window.location.href = redirectUrl + '?cargar=' + response.id;
                    } else {
                        $('#' + resultadoDiv).html('<div class="text-red-600 text-sm">❌ Establecimiento no encontrado</div>');
                    }
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON?.error || 'Error al buscar el establecimiento';
                    $('#' + resultadoDiv).html('<div class="text-red-600 text-sm">❌ ' + errorMsg + '</div>');
                }
            });
        }
        
        // Buscador inicial
        $('#btn_buscar')?.on('click', function() {
            let codigo = $('#buscar_codigo').val();
            buscarEstablecimiento(codigo, 'resultado_busqueda', '{{ route('infraestructura.edit') }}');
        });
        
        // Buscador secundario
        $('#btn_buscar_2')?.on('click', function() {
            let codigo = $('#buscar_codigo_2').val();
            buscarEstablecimiento(codigo, 'resultado_busqueda_2', '{{ route('infraestructura.edit') }}');
        });
        
        // Enter para buscar
        $('#buscar_codigo, #buscar_codigo_2').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                if (this.id === 'buscar_codigo') {
                    $('#btn_buscar').click();
                } else {
                    $('#btn_buscar_2').click();
                }
            }
        });
        
        // Auto-completar al salir del campo
        $('#buscar_codigo, #buscar_codigo_2').on('blur', function() {
            var valor = $(this).val();
            if (valor && /^\d+$/.test(valor)) {
                $(this).val(valor.padStart(8, '0'));
            }
        });
    });
</script>
</x-app-layout>
