@extends('layouts.adminNo', ['title_template' => "403 - No autorizado"])

@section('extracss')
<style>
    @import url("https://fonts.googleapis.com/css?family=Bungee");

    #robot-error{
        font-family: "Bungee", cursive !important;
        text-align: center;
    }
    a {
        color: #4272d7;
        text-decoration: none;
    }
    a:hover {
        color: white;
    }
    svg {
        width: 50vw;
    }
    .lightblue {
        fill: #444;
    }
    .eye {
        cx: calc(115px + 30px * var(--mouse-x));
        cy: calc(50px + 30px * var(--mouse-y));
    }
    #eye-wrap {
        overflow: hidden;
    }
    .error-text {
        font-size: 120px;
    }
    .alarm {
        animation: alarmOn 0.5s infinite;
    }

    @keyframes alarmOn {
        to {
            fill: darkred;
        }
    }

</style>
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,700" rel="stylesheet">
@endsection

@section ('contenido')
<div class="row class403">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <svg id="robot-error" viewBox="0 0 260 118.9">
            <defs>
                <clipPath id="white-clip"><circle id="white-eye" fill="#cacaca" cx="128" cy="63" r="25" /> </clipPath>
                <text id="text-s" class="error-text" y="106"> 403 </text>
            </defs>
            <path class="alarm" fill="#e62326" d="M120.9 19.6V9.1c0-5 4.1-9.1 9.1-9.1h0c5 0 9.1 4.1 9.1 9.1v10.6" />
            <use xlink:href="#text-s" x="-0.5px" y="-1px" fill="black"></use>
            <use xlink:href="#text-s" fill="#2b2b2b"></use>
            <g id="robot">
            <g id="eye-wrap">
                <use xlink:href="#white-eye"></use>
                <circle id="eyef" class="eye" clip-path="url(#white-clip)" fill="#000" stroke="#4272d7" stroke-width="2" stroke-miterlimit="10" cx="130" cy="65" r="11" />
                {{-- <ellipse id="white-eye" fill="#2b2b2b" cx="130" cy="20" rx="18" ry="12" /> --}}
            </g>
            <circle class="lightblue" cx="105" cy="32" r="2.5" id="tornillo" />
            <use xlink:href="#tornillo" x="50"></use>
            <use xlink:href="#tornillo" x="50" y="60"></use>
            <use xlink:href="#tornillo" y="60"></use>
            </g>
        </svg>
    </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <b style="font-size:35px">No tiene permitido entrar aquí</b> <br> <br>
            <a class="btn btn-pill btn-primary btn-lg" href="/">Ir a inicio</a> &ensp;&ensp;
            <a class="btn btn-pill btn-primary btn-lg" onclick="goBack()" href="">Volver atrás</a>
        </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
@endsection

@section('scripts')
    <script>
        $( ".bntCerrarSesion" ).click(function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });

        var root = document.documentElement;
var eyef = document.getElementById('eyef');
var cx = document.getElementById("eyef").getAttribute("cx");
var cy = document.getElementById("eyef").getAttribute("cy");

document.addEventListener("mousemove", evt => {
    let x = evt.clientX / innerWidth;
    let y = evt.clientY / innerHeight;

    root.style.setProperty("--mouse-x", x);
    root.style.setProperty("--mouse-y", y);

    cx = 115 + 30 * x;
    cy = 50 + 30 * y;
    eyef.setAttribute("cx", cx);
    eyef.setAttribute("cy", cy);
});

document.addEventListener("touchmove", touchHandler => {
    let x = touchHandler.touches[0].clientX / innerWidth;
    let y = touchHandler.touches[0].clientY / innerHeight;

    root.style.setProperty("--mouse-x", x);
    root.style.setProperty("--mouse-y", y);
});
    </script>
@endsection