@extends('adminlte::page')

@section('title', html_entity_decode(($title ?? env('APP_NAME'))  . (isset($subtitle) ? (" - ".$subtitle) : "") . (isset($subtitle2) ? (" - ".$subtitle2) : ""), ENT_QUOTES, 'UTF-8'))

@section('content_header')
    <div class="container">
        @isset($title)
            <div class="alert alert-light p-2" role="alert">
                <nav aria-label="breadcrumb">
                    <nav style="--bs-breadcrumb-divider: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&quot;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">
                                <i class="fa-solid fa-house"></i>
                            </a></li>
                            @if(isset($url))
                                <li class="breadcrumb-item">
                                    <a href="{{ $url }}" class="text-primary text-decoration-none">
                                        {{ $title }}
                                    </a>
                                </li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            @endif
                            @isset($subtitle)
                                @if(isset($urlsubtitle))
                                    <li class="breadcrumb-item">
                                        <a href="{{ $urlsubtitle }}" class="text-primary text-decoration-none">
                                            {{ $subtitle }}
                                        </a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle }}</li>
                                @endif
                            @endisset
                            @isset($subtitle2)
                                <li class="breadcrumb-item active" aria-current="page">{{ $subtitle2 }}</li>
                            @endisset
                        </ol>
                    </nav>
                </nav>
            </div>
        @endisset
        {{ $slot }}
    </div>     
@stop

@section('css')
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    @livewireStyles
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.8.1/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.8.1/dropzone.min.css">
    
    <script src="{{ asset('js/alertify.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/alertify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alertify.rtl.min.css') }}">
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

        aside.main-sidebar.sidebar-info.elevation-4.bg-white > a{
            text-decoration: none !important;
        }
        .fs-7  {
            font-size: 15px !important;
        }
        .fs-8  {
            font-size: 14.5px !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('head')
@stop

@section('js')
    @stack('modals')
    @livewireScripts
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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
@stop