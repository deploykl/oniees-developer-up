<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />
          
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.8.1/dropzone.min.css" />        
        <link rel="stylesheet" href="{{ asset('css/alertify.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/alertify.rtl.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" />
        <link rel="shortcut icon" href="{{ asset('img/icon-oniees.png') }}" /> 

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.8.1/min/dropzone.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>        
        <script src="{{ asset('js/alertify.min.js') }}"></script>
        
        @yield('scripts')
                    
        <!-- ICON -->
        <link rel="shortcut icon" href="{{ asset('img/icon-oniees.png') }}">
        <style>
            .form-control.is-valid, .was-validated .form-control:valid {
                background-image: none!important;
            }
            @media (min-width: 992px) {
                .sidebar-mini .nav-sidebar .nav-link.nav-link-submenu,
                .sidebar-mini .nav-sidebar .nav-link.nav-link-title {
                    white-space: normal!important;
                }
            }
            .nav-link-icon {
                display: flex;
                align-items: baseline;
            }
            .nav-link-icon > p {
                white-space: normal;
                margin-left: 7.5px!important;
            }  
            .form-check-input[type=radio] {
                /*background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='2' fill='%23fff'/%3e%3c/svg%3e);*/
                width: 1.5em;
                height: 1.5em;
            }
            .nav-link-title {
                font-size: 15px;
                color: #089FDB!important;
                font-weight: 500;
            }
            .nav-link-submenu {
                font-size: 13px;
                color: rgba(0, 0, 0, 0.75)!important;
                font-weight: 500;
            }
            .nav-link-danger{
                color: #990000!important;
            }
        </style>     
        
        @yield('head') 
        <script>
            $(function () {
                $('input, select').on('focus', function () {
                    $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
                });
                $('input, select').on('blur', function () {
                    $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
                });
            });
        </script>
        <script>
            $("input.texto, textarea.texto").bind('keypress', function(event) {
                debugger;
                var regex = new RegExp(/^[a-zA-Z-\u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1 ]+$/);
                var key = String.fromCharCode(!event.charCode ? event.charCode : event.which );
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
            $("input.alfanumerico, textarea.alfanumerico").bind('keypress', function(event) {
                var regex = new RegExp(/^[a-zA-Z0-9-\u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1 ]+$/);
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body style="background-color: #E4E7F1">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#1E084E;color:#FFFFFF">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{ route('inicio') }}">
                <img src="{{ asset('img/logo-minsa.png') }}" style="width:100%;max-width:200px" />
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarText" style="justify-content: flex-end;">
                <ul class="navbar-nav text-center">
                    @if(env('REPORTE_ACTIVO', false))
                        <li class="nav-item">
                            <a href="{{ route('reportes') }}" class="nav-link {{ (!!request()->routeIs('reportes') ? 'active' : '') }}">
                                <b>Reporte</b>
                            </a>
                        </li>
                    @endif
                    @if(env('ASISTENCIA_TECNICA_ACTIVO', false))
                        <li class="nav-item">
                            <a href="{{ route('solicitud-asistencia-tecnica') }}" class="nav-link {{ (!!request()->routeIs('solicitud-asistencia-tecnica') ? 'active' : '') }}">
                                <b>Asistencia Tecnica</b>
                            </a>
                        </li>
                    @endif
                    @if(env('TABLERO_GERENCIAL_ACTIVO', false) || env('TABLERO_GERENCIAL_ACTIVO', false) || env('TABLERO_EJECUTIVO_ACTIVO', false) || env('TABLERO_FIDI_ACTIVO', false) || env('TABLERO_ASISTENCIA_ACTIVO', false))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ ((!!request()->routeIs('fidi-tablero-guest') || !!request()->routeIs('tablero-ejecutivo-guest') || !!request()->routeIs('tablero-gerencial-guest')) ? 'active' : '') }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <b>Tablero de Mando<b>
                            </a>
                            <ul class="dropdown-menu">
                                @if(env('TABLERO_GERENCIAL_ACTIVO', false))
                                    <li>
                                        <a href="{{ route('tablero-gerencial-guest') }}" class="dropdown-item {{ (!!request()->routeIs('tablero-gerencial-guest') ? 'active' : '') }}">
                                            <b>Tablero Gerencial</b>
                                        </a>
                                    </li>
                                @endif
                                @if(env('TABLERO_EJECUTIVO_ACTIVO', false))
                                    <li>
                                        <a href="{{ route('tablero-ejecutivo-guest') }}" class="dropdown-item {{ (!!request()->routeIs('tablero-ejecutivo-guest') ? 'active' : '') }}">
                                            <b>Tablero Ejecutivo</b>
                                        </a>
                                    </li>
                                @endif
                                @if(env('TABLERO_FIDI_ACTIVO', false))
                                    <li>
                                        <a href="{{ route('fidi-tablero-guest') }}" class="dropdown-item {{ (!!request()->routeIs('fidi-tablero-guest') ? 'active' : '') }}">
                                            <b>Tablero FIDI</b>
                                        </a>
                                    </li>
                                @endif
                                @if(env('TABLERO_ASISTENCIA_ACTIVO', false))
                                    <li>
                                        <a href="{{ route('asistencia-tablero-guest') }}" class="dropdown-item {{ (!!request()->routeIs('asistencia-tablero-guest') ? 'active' : '') }}">
                                            <b>Tablero Asistencia</b>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ (!!request()->routeIs('dashboard') ? 'active' : '') }}">
                                <b>Dashboard</b>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">  
                            <a href="{{ route('login') }}" class="nav-link {{ (!!request()->routeIs('login') ? 'active' : '') }}">
                                <b>{{ __('Log in') }}</b>
                            </a>
                        </li>
                    @endauth 
                </ul>
              </div>
            </div>
        </nav>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
        @stack('modals')
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        @yield('scripts')
        <script>
            $("input.texto, textarea.texto").bind('keypress', function(event) {
                debugger;
                var regex = new RegExp(/^[a-zA-Z-\u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1 ]+$/);
                var key = String.fromCharCode(!event.charCode ? event.charCode : event.which );
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
            $("input.alfanumerico, textarea.alfanumerico").bind('keypress', function(event) {
                var regex = new RegExp(/^[a-zA-Z0-9-\u00e1\u00e9\u00ed\u00f3\u00fa\u00c1\u00c9\u00cd\u00d3\u00da\u00f1\u00d1 ]+$/);
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
        </script>
    </body>
</html>