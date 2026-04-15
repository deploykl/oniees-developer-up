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
        body{
            font-family: 'Open Sans', sans-serif;
        }
        #FormRegistro {
            background-color: #ffffff;
            margin: 40px auto;
            padding: 30px 15px;
            box-shadow: 0px 6px 18px rgb(0 0 0 / 9%);
            border-radius: 12px;
        }
        #FormRegistro .form-header {
            gap: 5px;
            text-align: center;
            font-size: .9em;
        }
        #FormRegistro .form-header .stepIndicator {
            position: relative;
            flex: 1;
            padding-bottom: 30px;
        }
        #FormRegistro .form-header .stepIndicator.active {
            font-weight: 600;
        }
        #FormRegistro .form-header .stepIndicator.finish {
            font-weight: 600;
            color: #009688;
        }
        #FormRegistro .form-header .stepIndicator::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            z-index: 9;
            width: 20px;
            height: 20px;
            background-color: #d5efed;
            border-radius: 50%;
            border: 3px solid #ecf5f4;
        }
        #FormRegistro .form-header .stepIndicator.active::before {
            background-color: #a7ede8;
            border: 3px solid #d5f9f6;
        }
        #FormRegistro .form-header .stepIndicator.finish::before {
            background-color: #009688;
            border: 3px solid #b7e1dd;
        }
        #FormRegistro .form-header .stepIndicator::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 8px;
            width: 100%;
            height: 3px;
            background-color: #f3f3f3;
        }
        #FormRegistro .form-header .stepIndicator.active::after {
            background-color: #a7ede8;
        }
        #FormRegistro .form-header .stepIndicator.finish::after {
            background-color: #009688;
        }
        #FormRegistro .form-header .stepIndicator:last-child:after {
            display: none;
        }
        #FormRegistro .form-footer{
            overflow:auto;
            gap: 20px;
        }
        #FormRegistro .form-footer button{
            background-color: #009688;
            border: 1px solid #009688 !important;
            color: #ffffff;
            border: none;
            padding: 13px 30px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            margin-top: 5px;
        }
        #FormRegistro .form-footer button:hover {
            opacity: 0.8;
        }
        #FormRegistro .form-footer #prevBtn {
            background-color: #fff;
            color: #009688;
        }
        .table tr th {
            text-align: center;
            vertical-align: middle;
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
        }
        .card img {
            max-width: 80px;
            margin-bottom: 10px;
        }
        .card-body {
            text-align: center;
            font-size: 0.9em;
            font-weight: bold;
        }
    </style>
    <div id="FormRegistro" class="text-center" style="font-size:13px;">
        <div class="row">
            <div class="col-md-3">
                <div class="row justify-content-center">
                    <div class="col-md-12 d-flex align-items-center mb-2">
                        <img src="{{ asset('img/icons/icon-ministerio-salud.png') }}" class="m-auto" style="width: 100%;" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('img/icons/icon-aplicativo.png') }}" class="mb-2" style="width: 100%;margin:auto;max-width: 400px;" />
                <h5 class="text-center mb-0 text-center mt-3 mb-3">
                    <b>TABLERO DE MANDO ONIEES</b>
                </h5>
            </div>
            <div class="col-md-3">
                <div class="row justify-content-center">
                    <div class="col-md-12 d-flex align-items-center mb-2">
                        <a href="{{ route('mcm.miembros') }}">
                            <img src="{{ asset('img/icons/icon-mcm.png') }}" class="m-auto" style="width: 100%;" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-header d-flex mb-4">
            @can('Tablero Gerencial - Inicio')       
                <a class="stepIndicator link-underline link-underline-opacity-0 text-bold" style="cursor: pointer;"  href="{{ route('tablero-gerencial-index') }}">
                    <img src="{{ asset('img/icons/gerencial.png') }}" style="width: 100%;max-width: 55px;margin:auto" />
                    Gerencial
                </a>
            @endcan
            @can('Tablero Ejecutivo - Inicio')
                <a class="stepIndicator link-underline link-underline-opacity-0 text-bold" style="cursor: pointer;" href="{{ route('tablero-ejecutivo-inicio') }}">
                    <img src="{{ asset('img/icons/ejecutivo.png') }}" style="width: 100%;max-width: 55px;margin:auto" />
                    Ejecutivo
                </a> 
            @endcan
            @can('FTCNT - Inicio')
                <a class="stepIndicator link-underline link-underline-opacity-0 text-bold" style="cursor: pointer;" href="{{ route('ficha-tecnica.index') }}">
                    <img src="{{ asset('img/icons/ftcnt.png') }}" style="width: 100%;max-width: 55px;margin:auto" />
                    FTCNT A 120
                </a>
            @endcan
            @can('Registro Estadistica - Inicio')        
                <a class="stepIndicator link-underline link-underline-opacity-0 text-bold" style="cursor: pointer;" href="{{ route('registro-estadistica') }}">
                    <img src="{{ asset('img/icons/estadistica.png') }}" style="width: 100%;max-width: 55px;margin:auto" />
                    Estad&iacute;stica
                </a>
            @endcan
            @can(['Encuesta Señalización - Inicio', 'Encuesta Pintado - Inicio'])
                <a class="stepIndicator link-underline link-underline-opacity-0 text-bold" style="cursor: pointer;" href="{{ route('tablero-ejecutivo-pintado-senializacion') }}">
                    <img src="{{ asset('img/icons/pintado-senializacion.png') }}" style="width: 100%;max-width: 55px;margin:auto" />
                    Pintado y Se&ntilde;alizaci&oacute;n
                </a>
            @endcan
        </div>
        <div class="step">
            <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="font-weight: bold;background:#dee2e6;">
                        INFRAESTRUCTURA Y EQUIPAMIENTO DE LA IPRESS
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="border: 1px solid;border-color: #dee2e6;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;padding: 10px;">
                    <div class="row justify-content-center">
                        @can('Datos Generales - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('formato-0') }}">
                                        Datos Generales
                                        <img src="{{ asset('img/icons/icon-datos-generales.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Infraestructuras - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('formato-i') }}">
                                        Infraestructura
                                        <img src="{{ asset('img/icons/icon-infraestructura.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Servicios Basicos - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('formato-ii') }}">
                                        Servicios Basicos
                                        <img src="{{ asset('img/icons/icon-servicios-basicos.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can(['UPSS Directa - Inicio', 'UPSS Soporte - Inicio', 'UPS Critica - Inicio'])
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <div class="d-flex flex-wrap w-100">
                                        @can('UPSS Directa - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold text-center p-2" href="{{ route('formato-upss-directa') }}">
                                                UPSS Directa
                                            </a>
                                        @endcan
                                        @can('UPSS Soporte - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold text-center p-2" href="{{ route('formato-iii-b') }}">
                                                UPSS Soporte
                                            </a>
                                        @endcan
                                        @can('UPS Critica - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold text-center p-2" href="{{ route('formato-iii-c') }}">
                                                UPS Critica
                                            </a>
                                        @endcan
                                    </div>
                                    <img src="{{ asset('img/icons/icon-upss.png') }}" style="width: 100%;max-width: 75px;margin:auto" />
                                </div>
                            </div>
                        @endcan
                        @if(env('ENDPOINT_ADMINISTRACION'))
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body p-0 link-underline link-underline-opacity-0 text-bold" href="{{ env('ENDPOINT_ADMINISTRACION') }}" target="_blank">
                                        Equipamiento SIGA MEF
                                        <img src="{{ asset('img/icons/icon-oniees-control.png') }}" style="width: 100%;margin: auto;max-width: 90px;" />
                                    </a>
                                </div>
                            </div>
                        @endif
                        @can('SIGA Modulo Patrimonio - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('siga-index') }}">
                                        SIGA MEF
                                        <img src="{{ asset('img/icons/icon-siga.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Costo de Equipamiento - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('costos-equipamiento') }}">
                                        Costo de Equipamiento
                                        <img src="{{ asset('img/icons/icon-costo-equipamiento.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            
            <ul class="nav nav-tabs mt-2" id="myTab2" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="font-weight: bold;background:#dee2e6;">
                        APLICACI&Oacute;N DE LA DIRECTIVA ADMINISTRATIVA N&deg; 269-MINSA/2029/DGOS<br />CUMPLIMIENTO DE LA NORMA T&Eacute;CNICA A. 120
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent2">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="border: 1px solid;border-color: #dee2e6;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;padding: 10px;">
                    <div class="row justify-content-center">
                        @can(['Encuesta Señalización - Inicio', 'Encuesta Pintado - Inicio'])
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <div class="d-flex flex-wrap w-100">
                                        @can('Encuesta Señalización - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold w-50 text-center p-2" href="{{ route('senializacion.index') }}">Se&ntilde;alizaci&oacute;n</a>
                                        @endcan
                                        @can('Encuesta Pintado - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold w-50 text-center p-2" href="{{ route('pintado.index') }}">Pintado</a>
                                        @endcan
                                    </div>
                                    <img src="{{ asset('img/icons/icon-senializacion-pintado.png') }}" style="width: 100%;max-width: 75px;margin:auto" />
                                </div>
                            </div>
                        @endcan
                        @can('FTCNT - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('ficha-tecnica.index') }}">
                                        FTCNT A 120
                                        <img src="{{ asset('img/icons/icon-ficha-tecnica.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>   
            
            <ul class="nav nav-tabs mt-2" id="myTab2" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="font-weight: bold;background:#dee2e6;">
                        SALA QUIRURGICA
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent2">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="border: 1px solid;border-color: #dee2e6;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;padding: 10px;">
                    <div class="row justify-content-center">
                        @can(['UPSS Centro Quirurgico - Inicio', 'UPSS Centro Obstetrico - Inicio'])
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <div class="d-flex flex-wrap w-100">
                                        @can('UPSS Centro Quirurgico - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold w-50 text-center p-2" href="{{ route('formato-upss-quirurgico') }}">
                                                UPSS Centro Quirurgico
                                            </a>
                                        @endcan
                                        @can('UPSS Centro Obstetrico - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold w-50 text-center p-2" href="{{ route('formato-upss-obstetrico') }}">
                                                UPSS Centro Obstetrico
                                            </a>
                                        @endcan
                                    </div>
                                    <img src="{{ asset('img/icons/icon-upss-centro.png') }}" style="width: 100%;max-width: 75px;margin:auto" />
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>   
            
            <ul class="nav nav-tabs mt-2" id="myTab2" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="font-weight: bold;background:#dee2e6;">
                        OTROS
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent2">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="border: 1px solid;border-color: #dee2e6;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;padding: 10px;">
                    <div class="row justify-content-center"> 
                        @can('Seguimiento de Cancer - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('seguimiento-cancer-index') }}">
                                        Seguimiento de C&aacute;ncer
                                        <img src="{{ asset('img/icons/icon-seguimiento-cancer.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can(['Registro de Plantas - Inicio', 'Registro de Tanques - Inicio'])
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <div class="d-flex flex-wrap w-100">
                                        @can('Registro de Plantas - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold w-50 text-center p-2" href="{{ route('plantas') }}">
                                                Plantas
                                            </a>
                                        @endcan
                                        @can('Registro de Tanques - Inicio')
                                            <a class="card-body link-underline link-underline-opacity-0 text-bold w-50 text-center p-2" href="{{ route('tanques') }}">
                                                Tanques
                                            </a>
                                        @endcan
                                    </div>
                                    <img src="{{ asset('img/icons/icon-plantas-tanques.png') }}" style="width: 100%;max-width: 75px;margin:auto" />
                                </div>
                            </div>
                        @endcan
                        @can('Agua y Saneamiento - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('indicadores-index') }}">
                                        Agua y Saneamiento
                                        <img src="{{ asset('img/icons/icon-agua-saneamiento.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Plan Mil Diagnostico - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('plan-mil-diagnostico-inicio') }}">
                                        Plan Mil
                                        <img src="{{ asset('img/icons/icon-plan-mil.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Asistencia Tecnica - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('asistencia-tecnica') }}">
                                        Asistencia T&eacute;cnica
                                        <img src="{{ asset('img/icons/icon-asistencia-tecnica.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('FIDI - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('fidi') }}">
                                        FIDI
                                        <img src="{{ asset('img/icons/icon-fidi.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                        @can('Essalud Inventario - Inicio')
                            <div class="col-md-3 text-center">
                                <div class="card">
                                    <a class="card-body link-underline link-underline-opacity-0 text-bold" href="{{ route('essalud-index') }}">
                                        ESSALUD
                                        <img src="{{ asset('img/icons/icon-essalud.png') }}" style="width: 100%;max-width: 80px;margin:auto" />
                                    </a>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>  
        </div>
    </div>
</x-app-layout>