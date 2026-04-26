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
        /* Pestañas */
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
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
        /* Botón guardar flotante */
        .save-button-fixed {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 100;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .save-button-fixed {
                bottom: 1rem;
                right: 1rem;
            }
        }
    </style>

    <div class="two-column-layout">
        
        <!-- CONTENIDO PRINCIPAL CON PESTAÑAS -->
        <div class="main-content">
            <!-- Selector de establecimiento (solo si es necesario) -->
            @if(isset($showSelector) && $showSelector)
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-4">
                <h5 class="font-bold mb-2">🔍 Buscar establecimiento</h5>
                <div class="flex gap-3">
                    <input type="text" id="buscar_codigo" class="flex-1 px-3 py-2 border rounded-lg" placeholder="Código RENIPRESS">
                    <button type="button" id="btn_buscar" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Buscar</button>
                </div>
                <div id="resultado_busqueda" class="mt-3"></div>
            </div>
            @endif

            <!-- PESTAÑAS -->
            <!-- PESTAÑAS - Agrega x-data aquí -->
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

        <!-- TAB 1 -->
        <div x-show="activeTab === 'datos-generales'" class="p-6">
            @include('infraestructura.partials.datos-generales')
        </div>

        <!-- TAB 2 -->
        <div x-show="activeTab === 'infraestructura'" class="p-6" style="display: none;">
            @include('infraestructura.partials.infraestructura')
        </div>

        <!-- TAB 3 -->
        <div x-show="activeTab === 'servicios-basicos'" class="p-6" style="display: none;">
            @include('infraestructura.partials.servicios-basicos')
        </div>

        <!-- Botones -->
        <div class="border-t border-gray-200 p-4 bg-gray-50 flex justify-end gap-3">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Guardar
            </button>
        </div>
    </form>
</div>
        </div>

        <!-- SIDEBAR DERECHO DE PROGRESO -->
        <div class="right-sidebar" x-data="progressSidebar()" x-init="initProgress()">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden sticky top-20">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4">
                    <h2 class="text-sm font-bold text-white">📊 Progreso del Formulario</h2>
                    <p class="text-xs text-blue-100 truncate mt-1">{{ $establecimiento->nombre_eess ?? 'Sin establecimiento' }}</p>
                </div>

                <!-- Progreso Total -->
                <div class="p-4 bg-gray-50 border-b">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Completado</span>
                        <span class="font-bold text-blue-600" x-text="totalProgress + '%'"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-teal-500 h-2 rounded-full transition-all duration-500" :style="{ width: totalProgress + '%' }"></div>
                    </div>
                </div>

                <!-- Lista de secciones -->
                <div class="divide-y divide-gray-100">
                    <div class="p-3 hover:bg-gray-50 cursor-pointer" @click="scrollToSection('datos-generales')">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-building text-blue-500 text-sm"></i>
                                <span class="text-sm font-medium">Datos Generales</span>
                            </div>
                            <span class="text-xs" :class="sections['datos-generales'].percent === 100 ? 'text-green-600 font-bold' : 'text-gray-500'" x-text="sections['datos-generales'].percent + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                            <div class="bg-blue-500 h-1 rounded-full transition-all" :style="{ width: sections['datos-generales'].percent + '%' }"></div>
                        </div>
                    </div>
                    <div class="p-3 hover:bg-gray-50 cursor-pointer" @click="scrollToSection('infraestructura-tab')">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-hard-hat text-teal-500 text-sm"></i>
                                <span class="text-sm font-medium">Infraestructura</span>
                            </div>
                            <span class="text-xs" :class="sections['infraestructura'].percent === 100 ? 'text-green-600 font-bold' : 'text-gray-500'" x-text="sections['infraestructura'].percent + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                            <div class="bg-teal-500 h-1 rounded-full transition-all" :style="{ width: sections['infraestructura'].percent + '%' }"></div>
                        </div>
                    </div>
                    <div class="p-3 hover:bg-gray-50 cursor-pointer" @click="scrollToSection('servicios-basicos-tab')">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-water text-cyan-500 text-sm"></i>
                                <span class="text-sm font-medium">Servicios Básicos</span>
                            </div>
                            <span class="text-xs" :class="sections['servicios-basicos'].percent === 100 ? 'text-green-600 font-bold' : 'text-gray-500'" x-text="sections['servicios-basicos'].percent + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                            <div class="bg-cyan-500 h-1 rounded-full transition-all" :style="{ width: sections['servicios-basicos'].percent + '%' }"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTÓN GUARDAR FLOTANTE (opcional) -->
    <div class="save-button-fixed">
        <button type="submit" form="mainForm" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-full shadow-lg hover:from-green-700 hover:to-green-800 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Guardar
        </button>
    </div>

    <script>
       function progressSidebar() {
    return {
        sections: {
            'datos-generales': { completed: 0, total: 50, percent: 0 }, // ← Cambia a 48 o más
            'infraestructura': { completed: 0, total: 15, percent: 0 },
            'servicios-basicos': { completed: 0, total: 10, percent: 0 }
        },
        totalProgress: 0,
        initProgress() {
            this.calculateProgress();
            setInterval(() => this.calculateProgress(), 1000);
        },
        calculateProgress() {
            let totalCompleted = 0;
            let totalFields = 0;
            for (let key in this.sections) {
                const section = document.getElementById(key + '-section');
                if (section) {
                    const inputs = section.querySelectorAll('input, select, textarea');
                    let filled = 0;
                    inputs.forEach(input => {
                        // Solo contar campos que no sean readonly?
                        if (input.value && input.value.trim() !== '') filled++;
                    });
                    this.sections[key].completed = filled;
                    this.sections[key].percent = Math.min(Math.round((filled / this.sections[key].total) * 100), 100);
                    totalCompleted += filled;
                    totalFields += this.sections[key].total;
                }
            }
            // Limitar el progreso total a máximo 100%
            let rawProgress = totalFields > 0 ? Math.round((totalCompleted / totalFields) * 100) : 0;
            this.totalProgress = Math.min(rawProgress, 100);
        },
        scrollToSection(sectionId) {
            if (sectionId === 'infraestructura-tab') {
                document.querySelector('[x-on\\:click="activeTab = \'infraestructura\'"]')?.click();
            } else if (sectionId === 'servicios-basicos-tab') {
                document.querySelector('[x-on\\:click="activeTab = \'servicios-basicos\'"]')?.click();
            } else {
                document.getElementById(sectionId)?.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }
}
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btn_buscar')?.on('click', function() {
                let codigo = $('#buscar_codigo').val();
                if (codigo) window.location.href = '{{ route('infraestructura.edit') }}?codigo=' + codigo;
            });
        });
    </script>
</x-app-layout>