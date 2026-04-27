<x-app-layout>
    <x-slot name="title">Inicio | ONIEES</x-slot>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f5f7fc 0%, #eef2f7 100%);
            font-family: 'Inter', 'Open Sans', sans-serif;
        }

        /* Contenedor principal */
        .dashboard-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* Header moderno */
        .dashboard-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(6, 182, 212, 0.15);
        }

        /* Menú rápido */
        .quick-menu {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .quick-item {
            background: white;
            border-radius: 1.5rem;
            padding: 0.75rem 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #1e293b;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .quick-item i {
            font-size: 1rem;
            color: #0e7c9e;
        }

        .quick-item:hover {
            background: #0e7c9e;
            color: white;
            transform: translateY(-2px);
            border-color: #0e7c9e;
        }

        .quick-item:hover i {
            color: white;
        }

        /* Secciones */
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

        /* Grid de tarjetas */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
            padding: 1.75rem;
        }

        /* Tarjeta moderna */
        .modern-card {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 1.25rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.25s ease;
            border: 1px solid #edf2f7;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
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

        /* Tarjeta con múltiples enlaces */
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

        /* Responsive */
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
            .section-header h2 {
                font-size: 1rem;
            }
        }
    </style>

    <div class="dashboard-container">
        <!-- Header moderno -->
        <div class="dashboard-header">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h1 style="font-size: 1.4rem; font-weight: 600; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-chalkboard-user" style="color: #0e7c9e;"></i>
                        Tablero de Mando ONIEES
                    </h1>
                    <p style="font-size: 0.8rem; color: #64748b; margin: 0.25rem 0 0 2rem;">Sistema de Información de Establecimientos de Salud</p>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <span style="background: #e6f7f9; padding: 0.3rem 1rem; border-radius: 2rem; font-size: 0.7rem; color: #0e7c9e;">
                        <i class="fas fa-sync-alt"></i> Actualizado
                    </span>
                </div>
            </div>
        </div>

        <!-- Menú rápido -->
        <div class="quick-menu">
            @can('Tablero Gerencial - Inicio')
                <a href="{{ route('tablero-gerencial-index') }}" class="quick-item"><i class="fas fa-chart-line"></i> Gerencial</a>
            @endcan
            @can('Tablero Ejecutivo - Inicio')
                <a href="{{ route('tablero-ejecutivo-inicio') }}" class="quick-item"><i class="fas fa-chart-simple"></i> Ejecutivo</a>
            @endcan
            @can('FTCNT - Inicio')
                <a href="{{ route('ficha-tecnica.index') }}" class="quick-item"><i class="fas fa-clipboard-list"></i> FTCNT A 120</a>
            @endcan
            @can('Registro Estadistica - Inicio')
                <a href="{{ route('registro-estadistica') }}" class="quick-item"><i class="fas fa-chart-pie"></i> Estadística</a>
            @endcan
            @can(['Encuesta Señalización - Inicio', 'Encuesta Pintado - Inicio'])
                <a href="{{ route('tablero-ejecutivo-pintado-senializacion') }}" class="quick-item"><i class="fas fa-paint-roller"></i> Pintado y Señalización</a>
            @endcan
            @can('Infraestructuras - Inicio')
                <a href="{{ route('infraestructura.edit') }}" class="quick-item"><i class="fas fa-building"></i> Infraestructura</a>
            @endcan
        </div>

        <!-- Sección 1: INFRAESTRUCTURA Y EQUIPAMIENTO -->
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fas fa-hospital-user"></i> Infraestructura y Equipamiento de la IPRESS</h2>
                <p>Gestión de datos de infraestructura, servicios básicos y equipamiento médico</p>
            </div>
            <div class="cards-grid">
                @can('Datos Generales - Inicio')
                    <a href="{{ route('formato-0') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-database"></i></div>
                        <h3>Datos Generales</h3>
                        <span>Información del establecimiento</span>
                    </a>
                @endcan
                @can('Infraestructuras - Inicio')
                    <a href="{{ route('infraestructura.edit') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-hard-hat"></i></div>
                        <h3>Infraestructura</h3>
                        <span>Datos de infraestructura</span>
                    </a>
                @endcan
                @can('Servicios Basicos - Inicio')
                    <a href="{{ route('formato-ii') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-water"></i></div>
                        <h3>Servicios Básicos</h3>
                        <span>Agua, luz, desagüe</span>
                    </a>
                @endcan
                @can(['UPSS Directa - Inicio', 'UPSS Soporte - Inicio', 'UPS Critica - Inicio'])
                    <div class="multi-card">
                        <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                            <i class="fas fa-microscope" style="color: #0e7c9e;"></i>
                            <h3 style="margin: 0; font-size: 0.85rem; font-weight: 600;">UPSS</h3>
                        </div>
                        <div class="links">
                            @can('UPSS Directa - Inicio')
                                <a href="{{ route('formato-upss-directa') }}"><i class="fas fa-chevron-right"></i> UPSS Directa</a>
                            @endcan
                            @can('UPSS Soporte - Inicio')
                                <a href="{{ route('formato-iii-b') }}"><i class="fas fa-chevron-right"></i> UPSS Soporte</a>
                            @endcan
                            @can('UPS Critica - Inicio')
                                <a href="{{ route('formato-iii-c') }}"><i class="fas fa-chevron-right"></i> UPS Crítica</a>
                            @endcan
                        </div>
                    </div>
                @endcan
                @if(env('ENDPOINT_ADMINISTRACION'))
                    <a href="{{ env('ENDPOINT_ADMINISTRACION') }}" target="_blank" class="modern-card">
                        <div class="card-icon"><i class="fas fa-chart-line"></i></div>
                        <h3>SIGA MEF</h3>
                        <span>Equipamiento SIGA</span>
                    </a>
                @endif
                @can('SIGA Modulo Patrimonio - Inicio')
                    <a href="{{ route('siga-index') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-microchip"></i></div>
                        <h3>SIGA MEF</h3>
                        <span>Módulo Patrimonio</span>
                    </a>
                @endcan
                @can('Costo de Equipamiento - Inicio')
                    <a href="{{ route('costos-equipamiento') }}" class="modern-card">
                        <div class="card-icon"><i class="fas fa-dollar-sign"></i></div>
                        <h3>Costo de Equipamiento</h3>
                        <span>Gestión de costos</span>
                    </a>
                @endcan
            </div>
        </div>

        <!-- Sección 2: DIRECTIVA A.120 -->
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
                                <a href="{{ route('senializacion.index') }}"><i class="fas fa-chevron-right"></i> Señalización</a>
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

        <!-- Sección 3: SALA QUIRÚRGICA -->
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fas fa-scalpel"></i> Sala Quirúrgica</h2>
                <p>Centros Quirúrgicos y Obstétricos</p>
            </div>
            <div class="cards-grid">
                @can(['UPSS Centro Quirurgico - Inicio', 'UPSS Centro Obstetrico - Inicio'])
                    <div class="multi-card">
                        <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                            <i class="fas fa-hospital" style="color: #0e7c9e;"></i>
                            <h3 style="margin: 0; font-size: 0.85rem; font-weight: 600;">UPSS</h3>
                        </div>
                        <div class="links">
                            @can('UPSS Centro Quirurgico - Inicio')
                                <a href="{{ route('formato-upss-quirurgico') }}"><i class="fas fa-chevron-right"></i> Centro Quirúrgico</a>
                            @endcan
                            @can('UPSS Centro Obstetrico - Inicio')
                                <a href="{{ route('formato-upss-obstetrico') }}"><i class="fas fa-chevron-right"></i> Centro Obstétrico</a>
                            @endcan
                        </div>
                    </div>
                @endcan
            </div>
        </div>

        <!-- Sección 4: OTROS MÓDULOS -->
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