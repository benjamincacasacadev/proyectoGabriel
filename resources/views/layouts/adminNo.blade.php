@php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
@endphp

<!doctype html>
<html lang="es">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Proyecto UAB" />
    <meta name="description" content="Proyecto UAB" />
    <meta name="author" content="Gabriel Mamani" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    @if (!empty($title_template))
        <title>{{ $title_template }}</title>
    @else
        <title>Proyecto UAB</title>
    @endif
    <link rel="shortcut icon" href="{{asset('favicon.ico?r='.rand())}}" />
    @include('layouts.assets.css')


    @yield('extracss')
    @stack('extracss')
    @show
    @php
        $item = \Session::get('item');
    @endphp
</head>
<body class="">
    <div id="contenedor_carga">
        <div id="loader-container">
            <p id="loadingText">Cargando...</p>
        </div>
    </div>

    <div class="page-wrapper">
        {{-- LAYOUT VERTICAL SIDEBAR y NAVBAR--}}
        @includeWhen(Auth::check(), 'layouts.sections.sidebar')

        <div class="page-container2">
            @includeWhen(Auth::check(), 'layouts.sections.header')

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                @yield('contenidoHeader')
                            </div>
                        </div>
                        @yield('contenido')
                        @include('layouts.sections.footer')
                    </div>
                </div>
            </div>

            @yield('modals')
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    <!-- Libs JS -->
    @include('layouts.assets.js')
    <script>
        $(function () {
            $('[data-toggle="tooltipMenu"]').tooltip({
                html: true,
                "placement": "top",
                "container": "body",
            })
        });

        $( ".bntCerrarSesion" ).click(function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
        $(function () {
            $('[data-toggle="tooltipLogout"]').tooltip({
                html: true,
                "placement": "bottom",
                "container": "body",
            });
        });
    </script>

    @stack('plugin-scripts')
    @yield('scripts')
    @stack('scripts')
</body>
</html>
