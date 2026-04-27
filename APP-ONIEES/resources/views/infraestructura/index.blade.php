<x-app-layout>
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
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
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

            <div x-data="{ activeTab: localStorage.getItem('activeTab') || 'datos-generales' }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'datos-generales'"
                            :class="{ 'border-blue-500 text-blue-600': activeTab === 'datos-generales', 'border-transparent text-gray-500': activeTab !== 'datos-generales' }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors">
                            <i class="fas fa-building mr-2"></i> Datos Generales
                        </button>
                        <button @click="activeTab = 'infraestructura'"
                            :class="{ 'border-teal-500 text-teal-600': activeTab === 'infraestructura', 'border-transparent text-gray-500': activeTab !== 'infraestructura' }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors">
                            <i class="fas fa-hard-hat mr-2"></i> Infraestructura
                        </button>
                        <button @click="activeTab = 'servicios-basicos'"
                            :class="{ 'border-cyan-500 text-cyan-600': activeTab === 'servicios-basicos', 'border-transparent text-gray-500': activeTab !== 'servicios-basicos' }"
                            class="px-6 py-3 text-sm font-medium border-b-2 transition-colors">
                            <i class="fas fa-water mr-2"></i> Servicios Básicos
                        </button>
                    </nav>
                </div>

                <form method="POST" action="{{ route('infraestructura.save') }}" id="mainForm">
                    @csrf
                    <input type="hidden" name="id_establecimiento" value="{{ $establecimiento->id ?? '' }}">

                    <div x-show="activeTab === 'datos-generales'" class="p-6">
                        @include('infraestructura.partials.datos-generales')
                    </div>

                    <div x-show="activeTab === 'infraestructura'" class="p-6" style="display: none;">
                        @include('infraestructura.partials.infraestructura')
                    </div>

                    <div x-show="activeTab === 'servicios-basicos'" class="p-6" style="display: none;">
                        @include('infraestructura.partials.servicios-basicos')
                    </div>

                </form>
            </div>
        </div>

        <!-- SIDEBAR DERECHO DE PROGRESO CON PESTAÑAS -->
        <div class="right-sidebar" x-data="progressSidebar()" x-init="initProgress()">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden sticky top-20">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4">
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

                <!-- PESTAÑAS DEL SIDEBAR -->
                <div class="border-b border-gray-200">
                    <div class="flex">
                        <button @click="activeSidebarTab = 'datos-generales'"
                            :class="activeSidebarTab === 'datos-generales' ? 'border-blue-500 text-blue-600 bg-blue-50' :
                                'border-transparent text-gray-500 hover:text-gray-700'"
                            class="flex-1 px-3 py-2 text-xs font-medium border-b-2 transition-colors sidebar-tab">
                            <i class="fas fa-building mr-1"></i> Datos Grales
                        </button>
                        <button @click="activeSidebarTab = 'infraestructura'"
                            :class="activeSidebarTab === 'infraestructura' ? 'border-teal-500 text-teal-600 bg-teal-50' :
                                'border-transparent text-gray-500 hover:text-gray-700'"
                            class="flex-1 px-3 py-2 text-xs font-medium border-b-2 transition-colors sidebar-tab">
                            <i class="fas fa-hard-hat mr-1"></i> Infraestructura
                        </button>
                        <button @click="activeSidebarTab = 'servicios-basicos'"
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
                        <div class="p-4 text-center text-gray-400 text-xs">
                            <i class="fas fa-hard-hat text-2xl mb-2 block"></i>
                            Módulo en construcción
                        </div>
                    </div>

                    <!-- TAB SERVICIOS BÁSICOS -->
                    <div x-show="activeSidebarTab === 'servicios-basicos'" class="space-y-1">
                        <div class="text-xs font-semibold text-gray-500 px-3 pt-2 pb-1">💧 SECCIONES</div>
                        <div class="p-4 text-center text-gray-400 text-xs">
                            <i class="fas fa-water text-2xl mb-2 block"></i>
                            Módulo en construcción
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

                <!-- Botón Guardar Cambios -->
                <div class="p-4 border-t border-gray-200 bg-white">
                    <button type="submit" form="mainForm"
                        class="w-full px-4 py-3 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 font-medium"
                        style="background: linear-gradient(135deg, #0E7C9E, #0a637f);">
                        <i class="fas fa-save text-sm"></i>
                        <span>Guardar Cambios</span>
                    </button>
                </div>
            </div>
        </div>
    </div>



    <script>
        function progressSidebar() {
            return {
                activeSidebarTab: localStorage.getItem('activeSidebarTab') || 'datos-generales',
                sections: {
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
                        total: 3,
                        percent: 0
                    },
                    'sec-patrimonio': {
                        completed: 0,
                        total: 3,
                        percent: 0
                    },
                    'sec-director': {
                        completed: 0,
                        total: 9,
                        percent: 0
                    }
                },
                totalProgress: 0,
                initProgress() {
                    window.addEventListener('sectionProgress', (e) => {
                        if (this.sections[e.detail.section]) {
                            this.sections[e.detail.section].completed = e.detail.filled;
                            this.sections[e.detail.section].percent = e.detail.percent;
                            this.calculateTotal();
                        }
                    });
                    setTimeout(() => {
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
                        if (sectionId.startsWith('sec-')) {
                            document.querySelector('[x-on\\:click="activeTab = \'datos-generales\'"]')?.click();
                        }

                        // Calcular offset para no tapar con el header
                        const headerOffset = 90;
                        const elementPosition = element.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        if (element.__x && element.__x.$data) {
                            element.__x.$data.open = true;
                        }
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
