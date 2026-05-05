<x-app-layout>
      {{-- Pantalla de carga Matrix --}}
    <x-slot name="title">Inicio | ONIEES</x-slot>
<style>
    /* Reset y base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f5f7fc 0%, #eef2f7 100%);
        font-family: 'Inter', 'Open Sans', sans-serif;
    }

    .dashboard-container {
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    /* ============================================ */
    /* HEADER PRINCIPAL MEJORADO CON LOGO */
    /* ============================================ */
    .main-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 2rem;
        padding: 1.5rem 2rem;
        border: 1px solid rgba(6, 182, 212, 0.15);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    .logo-container {
        flex-shrink: 0;
    }

    .main-logo {
        width: 70px;
        height: 70px;
        object-fit: contain;
        border-radius: 1.2rem;
        transition: transform 0.3s ease;
    }

    .main-logo:hover {
        transform: scale(1.05);
    }

    .title-container {
        text-align: center;
    }

    .title-container h1 {
        font-size: 0;
        margin: 0;
        letter-spacing: normal;
    }

    .title-main {
        font-size: 1.6rem;
        font-weight: 700;
        background: linear-gradient(135deg, #0e7c9e 0%, #1e3a5f 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        letter-spacing: -0.3px;
    }

    .title-sub {
        font-size: 1.6rem;
        font-weight: 500;
        color: #475569;
        letter-spacing: -0.3px;
    }

    .title-container p {
        font-size: 0.8rem;
        color: #64748b;
        margin-top: 0.5rem;
        margin-bottom: 0;
    }

    .divider {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #0e7c9e, #38bdf8);
        margin: 0.75rem auto 0;
        border-radius: 2px;
    }

    /* ============================================ */
    /* SECCIONES */
    /* ============================================ */
    .section-card {
        background: white;
        border-radius: 1.5rem;
        margin-bottom: 2rem;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-header {
        padding: 1.25rem 1.75rem;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-bottom: 1px solid #eef2f7;
    }

    .section-header h2 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f172a;
        letter-spacing: -0.3px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-header h2 i {
        color: #0e7c9e;
        font-size: 1.2rem;
    }

    .section-header p {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.25rem;
        margin-left: 1.9rem;
    }

    /* ============================================ */
    /* CARDS GRID */
    /* ============================================ */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.25rem;
        padding: 1.75rem;
    }

    .modern-card {
        background: #ffffff;
        border-radius: 1.25rem;
        padding: 1.25rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.25s ease;
        border: 1px solid #edf2f7;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-card:hover {
        transform: translateY(-4px);
        border-color: #cbd5e1;
        box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.08);
    }

    .card-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #e6f7f9 0%, #e0f2fe 100%);
        border-radius: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0e7c9e;
        font-size: 1.5rem;
    }

    .modern-card h3 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .modern-card span {
        font-size: 0.7rem;
        color: #94a3b8;
    }

    /* ============================================ */
    /* MULTI CARD */
    /* ============================================ */
    .multi-card {
        background: #ffffff;
        border-radius: 1.25rem;
        padding: 1.25rem;
        border: 1px solid #edf2f7;
        transition: all 0.2s ease;
    }

    .multi-card .links {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        margin-top: 0.75rem;
    }

    .multi-card a {
        text-decoration: none;
        font-size: 0.8rem;
        padding: 0.4rem 0;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 1px dashed #eef2f7;
        transition: all 0.2s;
    }

    .multi-card a:last-child {
        border-bottom: none;
    }

    .multi-card a i {
        width: 20px;
        color: #0e7c9e;
        font-size: 0.75rem;
    }

    .multi-card a:hover {
        color: #0e7c9e;
        transform: translateX(4px);
    }

    /* ============================================ */
    /* ENLACES DE INTERÉS */
    /* ============================================ */
    .interes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 0.75rem;
        padding: 1.5rem;
    }

    .interes-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 1.25rem;
        background: #f8fafc;
        border-radius: 1rem;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid #edf2f7;
    }

    .interes-link:hover {
        background: white;
        border-color: #cbd5e1;
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .interes-icon {
        width: 36px;
        height: 36px;
        border-radius: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .interes-info {
        flex: 1;
    }

    .interes-info .titulo {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e293b;
    }

    .interes-info .descripcion {
        font-size: 0.7rem;
        color: #94a3b8;
    }

    .interes-link i:last-child {
        color: #cbd5e1;
        font-size: 0.7rem;
        transition: all 0.2s;
    }

    .interes-link:hover i:last-child {
        color: #0e7c9e;
        transform: translateX(4px);
    }

    .badge-pendiente {
        background: #fef3c7;
        color: #d97706;
        font-size: 0.6rem;
        padding: 0.2rem 0.6rem;
        border-radius: 1rem;
        margin-left: 0.5rem;
    }

    /* ============================================ */
    /* RESPONSIVE */
    /* ============================================ */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 0 1rem;
            margin: 1rem auto;
        }

        .cards-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }

        .interes-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            padding: 1.25rem;
            gap: 0.8rem;
        }

        .main-logo {
            width: 55px;
            height: 55px;
        }

        .title-main, .title-sub {
            font-size: 1.3rem;
        }

        .title-container p {
            font-size: 0.7rem;
        }
    }
</style>
    <div class="dashboard-container">
       <div class="dashboard-container">
    <!-- HEADER MEJORADO CON LOGO -->
    <div class="main-header">
        <div class="header-content">
            <div class="logo-container">
                <img src="{{ asset('img/icons/icon-aplicativo.png') }}" alt="ONIEES Logo" class="main-logo">
            </div>
            <div class="title-container">
                <h1>
                    <span class="title-main">TABLERO DE MANDO </span>
                </h1>
                <p>Sistema de Información de Establecimientos de Salud</p>
                <div class="divider"></div>
            </div>
        </div>
    </div>

    <!-- RESTO DE SECCIONES (Enlaces de Interés, Infraestructura, etc.) -->
    <!-- ... -->
</div>
        <!-- ============================================ -->
        <!-- SECCIÓN 1: INFRAESTRUCTURA Y EQUIPAMIENTO -->
        <!-- ============================================ -->
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fas fa-hospital-user"></i> Infraestructura y Equipamiento de la IPRESS</h2>
                <p>Gestión de datos de infraestructura, servicios básicos y equipamiento médico</p>
            </div>
            <div class="cards-grid">
                <!-- Módulo de Infraestructura (Activo) -->
                <a href="{{ route('infraestructura.edit') }}"
                    class="modern-card group hover:border-teal-200 hover:shadow-md transition-all duration-300">
                    <div
                        class="card-icon bg-gradient-to-br from-teal-50 to-teal-100 group-hover:from-teal-100 group-hover:to-teal-200 transition-colors">
                        <i class="fas fa-drafting-compass text-teal-600"></i>
                    </div>
                    <h3 class="text-gray-700 group-hover:text-teal-700">Módulo de Infraestructura</h3>
                    <span class="text-gray-400 text-xs">
                        Datos generales, servicios básicos y estado de la edificación
                    </span>
                </a>

                <!-- Módulo de Reportes Dinámicos (En Desarrollo) -->
                <div class="modern-card opacity-75 relative overflow-hidden group">
                    <div class="card-icon bg-gradient-to-br from-blue-50 to-blue-100">
                        <i class="fas fa-chart-pie text-blue-600"></i>
                    </div>
                    <h3 class="text-gray-700">Reportes e Indicadores</h3>
                    <span class="text-gray-400 text-xs">Análisis de datos, dashboards en Power BI y exportación
                        avanzada</span>
                    <div
                        class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 rounded-full text-amber-600 text-xs">
                        <i class="fas fa-clock text-[10px]"></i>
                        <span>En desarrollo</span>
                    </div>
                </div>

                <!-- Repositorio Digital de Documentos (En Desarrollo) -->
                <div class="modern-card opacity-75 relative overflow-hidden group">
                    <div class="card-icon bg-gradient-to-br from-indigo-50 to-indigo-100">
                        <i class="fas fa-folder-open text-indigo-600"></i>
                    </div>
                    <h3 class="text-gray-700">Repositorio Digital</h3>
                    <span class="text-gray-400 text-xs">Archivo centralizado de planos, certificados ITSE y actas
                        técnicas</span>
                    <div
                        class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 rounded-full text-amber-600 text-xs">
                        <i class="fas fa-clock text-[10px]"></i>
                        <span>En desarrollo</span>
                    </div>
                </div>

                <!-- Feedback y Mejora Continua (En Desarrollo) -->
                <div class="modern-card opacity-75 relative overflow-hidden group">
                    <div class="card-icon bg-gradient-to-br from-purple-50 to-purple-100">
                        <i class="fas fa-comment-dots text-purple-600"></i>
                    </div>
                    <h3 class="text-gray-700">Módulo de Feedback</h3>
                    <span class="text-gray-400 text-xs">Sugerencias del sistema, reporte de bugs y encuestas de
                        satisfacción</span>
                    <div
                        class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 rounded-full text-amber-600 text-xs">
                        <i class="fas fa-clock text-[10px]"></i>
                        <span>En desarrollo</span>
                    </div>
                </div>

                <!-- Asistencia Técnica (Pendiente) -->
                <div class="modern-card opacity-75 relative overflow-hidden">
                    <div class="card-icon bg-gradient-to-br from-gray-100 to-gray-200">
                        <i class="fas fa-headset text-gray-500"></i>
                    </div>
                    <h3 class="text-gray-500">Asistencia Técnica</h3>
                    <span class="text-gray-400 text-xs">Soporte técnico remoto y mesa de ayuda para usuarios
                        IPRESS</span>
                    <div
                        class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 rounded-full text-amber-600 text-xs">
                        <i class="fas fa-clock text-[10px]"></i>
                        <span>En desarrollo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- Sección 2: ENLACES DE INTERÉS -->
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fas fa-external-link-alt"></i> Enlaces de Interés</h2>
                <p>Recursos y herramientas externas para la gestión del establecimiento de salud</p>
            </div>
            <div class="cards-grid">
                <!-- Transparencia MEF -->
                <a href="https://apps5.mineco.gob.pe/transparencia/Navegador/default.aspx" target="_blank"
                    rel="noopener noreferrer"
                    class="modern-card group hover:border-teal-200 hover:shadow-md transition-all duration-300">
                    <div
                        class="card-icon bg-gradient-to-br from-teal-50 to-teal-100 group-hover:from-teal-100 group-hover:to-teal-200 transition-colors">
                        <i class="fas fa-building text-teal-600"></i>
                    </div>
                    <h3 class="text-gray-700 group-hover:text-teal-700">Transparencia MEF</h3>
                    <span class="text-gray-400 text-xs">Consulta de información pública</span>
                </a>

                <!-- Invierte.pe -->
                <a href="https://ofi5.mef.gob.pe/inviertePub/ConsultaPublica/ConsultaAvanzada" target="_blank"
                    rel="noopener noreferrer"
                    class="modern-card group hover:border-indigo-200 hover:shadow-md transition-all duration-300">
                    <div
                        class="card-icon bg-gradient-to-br from-indigo-50 to-indigo-100 group-hover:from-indigo-100 group-hover:to-indigo-200">
                        <i class="fas fa-chart-line text-indigo-600"></i>
                    </div>
                    <h3 class="text-gray-700 group-hover:text-indigo-700">Invierte.pe</h3>
                    <span class="text-gray-400 text-xs">Consulta de inversión pública</span>
                </a>

                <!-- Población Estimada MINSA -->
                <a href="https://www.minsa.gob.pe/reunis/data/poblacion_estimada.asp" target="_blank"
                    rel="noopener noreferrer"
                    class="modern-card group hover:border-emerald-200 hover:shadow-md transition-all duration-300">
                    <div
                        class="card-icon bg-gradient-to-br from-emerald-50 to-emerald-100 group-hover:from-emerald-100 group-hover:to-emerald-200">
                        <i class="fas fa-users text-emerald-600"></i>
                    </div>
                    <h3 class="text-gray-700 group-hover:text-emerald-700">Población Estimada</h3>
                    <span class="text-gray-400 text-xs">REUNIS - MINSA</span>
                </a>

                <!-- Padrón Nominal -->
                <a href="https://www.minsa.gob.pe/reunis/data/poblacion_padron_nominal.asp" target="_blank"
                    rel="noopener noreferrer"
                    class="modern-card group hover:border-blue-200 hover:shadow-md transition-all duration-300">
                    <div
                        class="card-icon bg-gradient-to-br from-blue-50 to-blue-100 group-hover:from-blue-100 group-hover:to-blue-200">
                        <i class="fas fa-id-card text-blue-600"></i>
                    </div>
                    <h3 class="text-gray-700 group-hover:text-blue-700">Padrón Nominal</h3>
                    <span class="text-gray-400 text-xs">REUNIS - MINSA</span>
                </a>

                <!-- Censo 2017 INEI -->
                <a href="https://censo2017.inei.gob.pe/resultados-definitivos-de-los-censos-nacionales-2017/"
                    target="_blank" rel="noopener noreferrer"
                    class="modern-card group hover:border-purple-200 hover:shadow-md transition-all duration-300">
                    <div
                        class="card-icon bg-gradient-to-br from-purple-50 to-purple-100 group-hover:from-purple-100 group-hover:to-purple-200">
                        <i class="fas fa-chart-bar text-purple-600"></i>
                    </div>
                    <h3 class="text-gray-700 group-hover:text-purple-700">Censo 2017</h3>
                    <span class="text-gray-400 text-xs">INEI - Resultados definitivos</span>
                </a>
            </div>
        </div>


        <!-- ============================================ -->
        <!-- SECCIÓN 3: DIRECTIVA A.120 -->
        <!-- ============================================ -->
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fas fa-file-alt"></i> Directiva Administrativa N° 269-MINSA/2029/DGOS</h2>
                <p>Cumplimiento de la Norma Técnica A.120</p>
            </div>
            <div class="cards-grid">
                @can(['Encuesta Señalización - Inicio', 'Encuesta Pintado - Inicio'])
                    <div class="multi-card">
                        <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                            <i class="fas fa-paint-bucket" style="color: #0e7c9e;"></i>
                            <h3 style="margin: 0; font-size: 0.85rem; font-weight: 600;">A.120</h3>
                        </div>
                        <div class="links">
                            @can('Encuesta Señalización - Inicio')
                                <a href="{{ route('senializacion.index') }}"><i class="fas fa-chevron-right"></i>
                                    Señalización</a>
                            @endcan
                            @can('Encuesta Pintado - Inicio')
                                <a href="{{ route('pintado.index') }}"><i class="fas fa-chevron-right"></i> Pintado</a>
                            @endcan
                        </div>
                    </div>
                @endcan
                @can('FTCNT - Inicio')
                    <a href="{{ route('ficha-tecnica.index') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-file-alt"></i></div>
                        <h3>FTCNT A 120</h3>
                        <span>Ficha técnica</span>
                    </a>
                @endcan
            </div>
        </div>

        <!-- ============================================ -->
        <!-- SECCIÓN 4: OTROS MÓDULOS -->
        <!-- ============================================ -->
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fas fa-cubes"></i> Otros Módulos</h2>
                <p>Herramientas complementarias del sistema</p>
            </div>
            <div class="cards-grid">
                @can('Seguimiento de Cancer - Inicio')
                    <a href="{{ route('seguimiento-cancer-index') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-heartbeat"></i></div>
                        <h3>Seguimiento de Cáncer</h3>
                        <span>Oncología</span>
                    </a>
                @endcan
                @can(['Registro de Plantas - Inicio', 'Registro de Tanques - Inicio'])
                    <div class="multi-card">
                        <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                            <i class="fas fa-factory" style="color: #0e7c9e;"></i>
                            <h3 style="margin: 0; font-size: 0.85rem; font-weight: 600;">Infraestructura</h3>
                        </div>
                        <div class="links">
                            @can('Registro de Plantas - Inicio')
                                <a href="{{ route('plantas') }}"><i class="fas fa-chevron-right"></i> Plantas</a>
                            @endcan
                            @can('Registro de Tanques - Inicio')
                                <a href="{{ route('tanques') }}"><i class="fas fa-chevron-right"></i> Tanques</a>
                            @endcan
                        </div>
                    </div>
                @endcan
                @can('Agua y Saneamiento - Inicio')
                    <a href="{{ route('indicadores-index') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-tint"></i></div>
                        <h3>Agua y Saneamiento</h3>
                        <span>Indicadores</span>
                    </a>
                @endcan
                @can('Plan Mil Diagnostico - Inicio')
                    <a href="{{ route('plan-mil-diagnostico-inicio') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-chart-line"></i></div>
                        <h3>Plan Mil</h3>
                        <span>Diagnóstico</span>
                    </a>
                @endcan
                @can('Asistencia Tecnica - Inicio')
                    <a href="{{ route('asistencia-tecnica') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-headset"></i></div>
                        <h3>Asistencia Técnica</h3>
                        <span>Soporte</span>
                    </a>
                @endcan
                @can('FIDI - Inicio')
                    <a href="{{ route('fidi') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-file-invoice"></i></div>
                        <h3>FIDI</h3>
                        <span>Documentos</span>
                    </a>
                @endcan
                @can('Essalud Inventario - Inicio')
                    <a href="{{ route('essalud-index') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-building"></i></div>
                        <h3>ESSALUD</h3>
                        <span>Inventario</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
