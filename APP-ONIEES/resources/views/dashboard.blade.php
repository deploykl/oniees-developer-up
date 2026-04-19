<x-app-layout>
    <x-slot name="title">Inicio</x-slot>

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
        body {
            font-family: 'Open Sans', sans-serif;
        }
        #FormRegistro {
            background-color: #ffffff;
            margin: 0 auto;  /* Cambiado: antes era 40px auto */
            padding: 20px 15px;
            box-shadow: 0px 6px 18px rgb(0 0 0 / 9%);
            border-radius: 12px;
        }
        .card {
            height: 135px;
            margin: 10px auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
        }
        .card img {
            max-width: 80px;
            margin-bottom: 10px;
        }
        .card-body {
            text-align: center;
            font-size: 0.9em;
            font-weight: bold;
            text-decoration: none;
            color: #1e293b;
        }
        .form-header {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
        }
        .stepIndicator {
            text-align: center;
            text-decoration: none;
            color: #64748b;
            transition: all 0.2s ease;
            padding: 10px;
            border-radius: 12px;
            flex: 1;
            min-width: 80px;
        }
        .stepIndicator:hover {
            background: #f1f5f9;
            color: #0e7c9e;
        }
        .stepIndicator img {
            display: block;
            margin: 0 auto 8px auto;
        }
        .nav-tabs {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 20px;
        }
        .nav-tabs .nav-link {
            border: none;
            font-weight: 600;
            color: #64748b;
            padding: 10px 20px;
            background: transparent;
        }
        .nav-tabs .nav-link.active {
            color: #0e7c9e;
            border-bottom: 3px solid #0e7c9e;
            background: transparent;
        }
        .tab-content {
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 8px 8px;
            padding: 20px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .col-md-3, .col-md-6 {
            padding: 0 10px;
            flex: 0 0 auto;
        }
        .col-md-3 { width: 25%; }
        .col-md-6 { width: 50%; }
        @media (max-width: 768px) {
            .col-md-3, .col-md-6 { width: 100%; margin-bottom: 20px; }
            .form-header { flex-direction: column; align-items: center; }
            .stepIndicator { width: 100%; }
        }
    </style>

    <div id="FormRegistro">
        <!-- Encabezado -->
        <div class="row align-items-center mb-4">
            <div class="col-md-3">
                <div class="text-center">
                    <img src="{{ asset('img/icons/icon-ministerio-salud.png') }}" style="max-width: 100px; margin: auto;" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <img src="{{ asset('img/icons/icon-aplicativo.png') }}" style="max-width: 300px; margin: auto;" />
                    <h5 class="mt-3 mb-0 fw-bold">
                        <b>TABLERO DE MANDO ONIEES</b>
                    </h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <a href="#">
                        <img src="{{ asset('img/icons/icon-mcm.png') }}" style="max-width: 80px; margin: auto;" />
                    </a>
                </div>
            </div>
        </div>

        <!-- Menú principal -->
        <div class="form-header">
            @can('Tablero Gerencial - Inicio')       
                <a class="stepIndicator" href="{{ route('tablero-gerencial-index') }}">
                    <img src="{{ asset('img/icons/gerencial.png') }}" style="width: 45px; margin: auto;" />
                    Gerencial
                </a>
            @endcan
            @can('Tablero Ejecutivo - Inicio')
                <a class="stepIndicator" href="{{ route('tablero-ejecutivo-inicio') }}">
                    <img src="{{ asset('img/icons/ejecutivo.png') }}" style="width: 45px; margin: auto;" />
                    Ejecutivo
                </a> 
            @endcan
            @can('FTCNT - Inicio')
                <a class="stepIndicator" href="{{ route('ficha-tecnica.index') }}">
                    <img src="{{ asset('img/icons/ftcnt.png') }}" style="width: 45px; margin: auto;" />
                    FTCNT A 120
                </a>
            @endcan
            @can('Registro Estadistica - Inicio')        
                <a class="stepIndicator" href="{{ route('registro-estadistica') }}">
                    <img src="{{ asset('img/icons/estadistica.png') }}" style="width: 45px; margin: auto;" />
                    Estadística
                </a>
            @endcan
            @can(['Encuesta Señalización - Inicio', 'Encuesta Pintado - Inicio'])
                <a class="stepIndicator" href="{{ route('tablero-ejecutivo-pintado-senializacion') }}">
                    <img src="{{ asset('img/icons/pintado-senializacion.png') }}" style="width: 45px; margin: auto;" />
                    Pintado y Señalización
                </a>
            @endcan
        </div>

        <!-- INFRAESTRUCTURA Y EQUIPAMIENTO -->
        <div class="mb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#infraestructura">
                        INFRAESTRUCTURA Y EQUIPAMIENTO DE LA IPRESS
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="infraestructura">
                    <div class="row g-3">
                        @can('Datos Generales - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('formato-0') }}">
                                        Datos Generales
                                        <img src="{{ asset('img/icons/icon-datos-generales.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Infraestructuras - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('formato-i') }}">
                                        Infraestructura
                                        <img src="{{ asset('img/icons/icon-infraestructura.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Servicios Basicos - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('formato-ii') }}">
                                        Servicios Básicos
                                        <img src="{{ asset('img/icons/icon-servicios-basicos.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can(['UPSS Directa - Inicio', 'UPSS Soporte - Inicio', 'UPS Critica - Inicio'])
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-1">
                                            @can('UPSS Directa - Inicio')
                                                <a href="{{ route('formato-upss-directa') }}">UPSS Directa</a>
                                            @endcan
                                            @can('UPSS Soporte - Inicio')
                                                <a href="{{ route('formato-iii-b') }}">UPSS Soporte</a>
                                            @endcan
                                            @can('UPS Critica - Inicio')
                                                <a href="{{ route('formato-iii-c') }}">UPS Crítica</a>
                                            @endcan
                                        </div>
                                        <img src="{{ asset('img/icons/icon-upss.png') }}" />
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @if(env('ENDPOINT_ADMINISTRACION'))
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ env('ENDPOINT_ADMINISTRACION') }}" target="_blank">
                                        Equipamiento SIGA MEF
                                        <img src="{{ asset('img/icons/icon-oniees-control.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endif
                        @can('SIGA Modulo Patrimonio - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('siga-index') }}">
                                        SIGA MEF
                                        <img src="{{ asset('img/icons/icon-siga.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Costo de Equipamiento - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('costos-equipamiento') }}">
                                        Costo de Equipamiento
                                        <img src="{{ asset('img/icons/icon-costo-equipamiento.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- APLICACIÓN DIRECTIVA A.120 -->
        <div class="mb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#directiva">
                        APLICACIÓN DE LA DIRECTIVA ADMINISTRATIVA N° 269-MINSA/2029/DGOS<br />CUMPLIMIENTO DE LA NORMA TÉCNICA A. 120
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="directiva">
                    <div class="row g-3">
                        @can(['Encuesta Señalización - Inicio', 'Encuesta Pintado - Inicio'])
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                                            @can('Encuesta Señalización - Inicio')
                                                <a href="{{ route('senializacion.index') }}">Señalización</a>
                                            @endcan
                                            @can('Encuesta Pintado - Inicio')
                                                <a href="{{ route('pintado.index') }}">Pintado</a>
                                            @endcan
                                        </div>
                                        <img src="{{ asset('img/icons/icon-senializacion-pintado.png') }}" />
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @can('FTCNT - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('ficha-tecnica.index') }}">
                                        FTCNT A 120
                                        <img src="{{ asset('img/icons/icon-ficha-tecnica.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- SALA QUIRÚRGICA -->
        <div class="mb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#quirurgica">
                        SALA QUIRÚRGICA
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="quirurgica">
                    <div class="row g-3">
                        @can(['UPSS Centro Quirurgico - Inicio', 'UPSS Centro Obstetrico - Inicio'])
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-1">
                                            @can('UPSS Centro Quirurgico - Inicio')
                                                <a href="{{ route('formato-upss-quirurgico') }}">Centro Quirúrgico</a>
                                            @endcan
                                            @can('UPSS Centro Obstetrico - Inicio')
                                                <a href="{{ route('formato-upss-obstetrico') }}">Centro Obstétrico</a>
                                            @endcan
                                        </div>
                                        <img src="{{ asset('img/icons/icon-upss-centro.png') }}" />
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- OTROS -->
        <div class="mb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#otros">
                        OTROS
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="otros">
                    <div class="row g-3">
                        @can('Seguimiento de Cancer - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('seguimiento-cancer-index') }}">
                                        Seguimiento de Cáncer
                                        <img src="{{ asset('img/icons/icon-seguimiento-cancer.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can(['Registro de Plantas - Inicio', 'Registro de Tanques - Inicio'])
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                                            @can('Registro de Plantas - Inicio')
                                                <a href="{{ route('plantas') }}">Plantas</a>
                                            @endcan
                                            @can('Registro de Tanques - Inicio')
                                                <a href="{{ route('tanques') }}">Tanques</a>
                                            @endcan
                                        </div>
                                        <img src="{{ asset('img/icons/icon-plantas-tanques.png') }}" />
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @can('Agua y Saneamiento - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('indicadores-index') }}">
                                        Agua y Saneamiento
                                        <img src="{{ asset('img/icons/icon-agua-saneamiento.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Plan Mil Diagnostico - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('plan-mil-diagnostico-inicio') }}">
                                        Plan Mil
                                        <img src="{{ asset('img/icons/icon-plan-mil.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Asistencia Tecnica - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('asistencia-tecnica') }}">
                                        Asistencia Técnica
                                        <img src="{{ asset('img/icons/icon-asistencia-tecnica.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('FIDI - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('fidi') }}">
                                        FIDI
                                        <img src="{{ asset('img/icons/icon-fidi.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Essalud Inventario - Inicio')
                            <div class="col-md-3 col-sm-6">
                                <div class="card">
                                    <a class="card-body" href="{{ route('essalud-index') }}">
                                        ESSALUD
                                        <img src="{{ asset('img/icons/icon-essalud.png') }}" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard cargado');
            
            @if(session('toast_message'))
                setTimeout(function() {
                    if (window.toast) {
                        window.toast.{{ session('toast_type', 'success') }}('{{ session('toast_message') }}');
                    }
                }, 800);
            @endif
        });
    </script>
</x-app-layout>