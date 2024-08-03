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
    <meta name="keywords" content="Seg Tech AMPER" />
    <meta name="description" content="Seg Tech AMPER" />
    <meta name="author" content="Benjamin Cacasaca" />
    <meta name="viewport" content="width=device-width, initial-scale=1">


    @if (!empty($title_template))
        <title>{{ $title_template }}</title>
    @else
        <title>Seg Tech AMPER</title>
    @endif
    <link rel="shortcut icon" href="{{asset('favicon.ico?r='.rand())}}" />
    @include('layouts.assets.css')
    <style>
        a.scroll-top {
            display: none;
            width: 40px;
            height: 50px;
            position: fixed;
            z-index: 1000;
            bottom: 50px;
            right: 30px;
            padding-right:20px;
            font-size: 25px;
            border-radius: 3px !important;
            text-align: center;
        }
        a.scroll-top i {
            position: relative;
            top: 5px;
            left: 2px;
            padding-bottom:20px;
        }
        @media  (max-width: 1203px){
            a.scroll-top i {
                position: relative;
                top: 5px;
                padding-left:5px;
            }
        }
    </style>

    @yield('extracss')
    @stack('extracss')
    @show
    @php
        $item = \Session::get('item');
    @endphp
</head>
<body class="animsition">
    @auth
    <div id="contenedor_carga">
        <div id="loader-container">
            <p id="loadingText">Cargando...</p>
        </div>
    </div>

    <div class="page-wrapper">
        {{-- LAYOUT VERTICAL SIDEBAR y NAVBAR--}}
        @include('layouts.sections.sidebar')

        <div class="page-container2">
            @include('layouts.sections.header')


            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                @yield('contenidoHeader')
                            </div>
                        </div>

                        @php
                            $array = ['0', '1.', '2.', '4.0:', '6.'];
                        @endphp
                        @if(!in_array($item,$array))
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            @yield('contenido')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            @yield('contenido')
                        @endif


                        @include('layouts.sections.footer')
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- modal de cerrar sesión --}}
    <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog"  id="modalCerrarSesion" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-primary"></div>
                <div class="modal-body text-center pt-4 pb-2">
                    <svg class="icon mb-2 text-primary icon-lg" width="12" height="12" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                        <path d="M7 12h14l-3 -3m0 6l3 -3" />
                    </svg>
                    <h3>¿Está seguro de cerrar sesión?</h3>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a class="btn @if(themeMode() == 'D') btn-secondary @endif w-100" data-dismiss="modal">
                                    Cancelar
                                </a>
                            </div>
                            <div class="col">
                                <a type="button" class="btn btn-primary w-100 bntCerrarSesion">Confirmar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    <!-- Libs JS -->
    @include('layouts.assets.js')
    <script>
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('a.scroll-top').fadeIn('slow');
            } else {
                $('a.scroll-top').fadeOut('slow');
            }
        }); $('a.scroll-top').click(function (event) {
            event.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 600);
        });

        var pathname = window.location.pathname;
        $(document).ready(function() {
            // if(pathname != '/' && pathname != '/schedule/calendar'){
                $('.divIconLogout').show();
            // }
        });

        $(function () {
            $('[data-toggle="tooltipMenu"]').tooltip({
                html: true,
                "placement": "top",
                "container": "body",
            })
        });

        $('.logoutModal').on('click', function(){
            $("#modalCerrarSesion").modal('show');
        })

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
    @endauth
</body>
</html>