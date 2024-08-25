@extends ('layouts.admin', ['title_template' => "Inicio"])
@section('extracss')
<style>
    .highcharts-figure, .highcharts-data-table table {
        min-width: 220px;
    }
    table#table_lastassets td{
        font-size: 12px;
    }
    .modal-body{
        padding: 0.5rem
    }
    table#tableForms td{
        font-size: 12px;
    }
    table#tableForms th{
        text-align: center !important;
    }
    .leftTable{
        text-align: left !important;
    }
    .rightTable{
        text-align: right !important;
    }
    .tui-full-calendar-popup-section{
        min-height: 0px !important;
    }
    .dropCalendar{
        left: -105px !important;
    }
    .col-lg-2-4 {
        width: calc(20% - 10px); /* 20% ancho menos el margen */
        margin: 5px; /* Ajusta el margen según lo necesario */
    }
    .desc{
        font-size: 12.5px !important;
        font-weight: bold !important;
    }
</style>
@endsection
@section('contenidoHeader')
<div class="overview-wrap">
    <h2 class="title-1">Bienvenido {{ userFullName( auth()->user()->id )}}</h2>
    <a class="au-btn au-btn-icon au-btn--blue text-right" href="/novedades?selectEstado=S">
        Ver pendientes de cierre
    </a>
</div>
@endsection
@section('contenido')
<div class="row m-3">
    <a class="overview-item overview-item--c6 mx-1" href="/novedades?selectEventos=1">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-timer"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->activacion_alarma }}</h2>
                    <span class="desc">Activaciones <br>de alarma</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c8 mx-1" href="/novedades?selectEventos=2">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-run"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->movimiento_fuera_de_horario }}</h2>
                    <span class="desc">Movimiento fuera <br> de horario</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c10 mx-1" href="/novedades?selectEventos=3">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-key"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->apertura_remota }}</h2>
                    <span class="desc">Apertura <br>remota</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c6 mx-1" href="/novedades?selectEventos=4">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-lock"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->cierre_remoto }}</h2>
                    <span class="desc">Cierre remoto</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c8 mx-1" href="/novedades?selectEventos=5">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-key"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->asignacion_de_llaves }}</h2>
                    <span class="desc">Asignación <br>de llaves</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c10 mx-1" href="/novedades?selectEventos=6">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-car"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->control_remoto_vehiculo }}</h2>
                    <span class="desc">Control remoto <br>de vehículo</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c6 mx-1" href="/novedades?selectEventos=7">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-car-wash"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->salida_vehiculo_fuera_horario }}</h2>
                    <span class="desc">Vehiculo fuera <br>de horario</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c8 mx-1" href="/novedades?selectEventos=8">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-hotel"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->pernocte_diferente }}</h2>
                    <span class="desc">Pernocte <br> diferente</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c10 mx-1" href="/novedades?selectEventos=9">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-wrench"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->vehiculo_taller }}</h2>
                    <span class="desc">Vehiculo <br> en taller</span>
                </div>
            </div>
        </div>
    </a>

    <a class="overview-item overview-item--c6 mx-1" href="/novedades?selectEventos=10">
        <div class="overview__inner">
            <div class="overview-box clearfix">
                <div class="icon">
                    <i class="zmdi zmdi-alert-circle-o"></i>
                </div>
                <div class="text mb-2">
                    <h2>{{ $novedad->vehiculo_sin_comunicacion }}</h2>
                    <span class="desc">Vehiculo sin <br> comunicación</span>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="row">
    <div class="col-xl-8">
        <!-- RECENT REPORT 2-->
        <div class="recent-report2">
            <h3 class="title-3">Novedades por fechas</h3>
            <div class="chart-info">
                <div class="chart-info__left">

                    <div class="chart-note">
                        <span class="dot dot--green"></span>
                        <span>Novedades</span>
                    </div>
                </div>
                {{-- <div class="chart-info-right">
                        <a class="au-btn au-btn-icon au-btn--blue text-right" href="/novedades?selectEstado=S">
                            Novedades pendientes de cierre
                        </a>
                </div> --}}
            </div>
            <div class="recent-report__chart">
                <canvas id="recent-rep2-chart"></canvas>
            </div>
        </div>
        <!-- END RECENT REPORT 2             -->
    </div>
    <div class="col-xl-4">
        <!-- TASK PROGRESS-->
        <div class="task-progress">
            <h2 class="title-2">Ambitos</h2>
            <b >Total de registros: {{ $ambitos->total }}</b>
            <div class="au-skill-container">
                @php
                    $total = $ambitos->total ?? 0;
                    $porcFisica = $ambitos->fisica/$total * 100;
                    $porcElectronica = $ambitos->electronica/$total * 100;
                    $porcVehiculos = $ambitos->vehiculos/$total * 100;
                @endphp
                <div class="au-progress">
                    <span class="au-progress__title">Seguridad fisica ({{$ambitos->fisica}}) </span><br><br>
                    <div class="au-progress__bar">
                        <div class="au-progress__inner js-progressbar-simple" role="progressbar" data-transitiongoal="{{ $porcFisica }}">
                            <span class="au-progress__value js-value"></span>
                        </div>
                    </div>
                </div>
                <div class="au-progress">
                    <span class="au-progress__title">Seguridad electronica ({{$ambitos->electronica}})</span><br><br>
                    <div class="au-progress__bar">
                        <div class="au-progress__inner js-progressbar-simple" role="progressbar" data-transitiongoal="{{ $porcElectronica }}">
                            <span class="au-progress__value js-value"></span>
                        </div>
                    </div>
                </div>
                <div class="au-progress">
                    <span class="au-progress__title">Vehiculos ({{$ambitos->vehiculos}})</span> <br><br>
                    <div class="au-progress__bar">
                        <div class="au-progress__inner js-progressbar-simple" role="progressbar" data-transitiongoal="{{ $porcVehiculos }}">
                            <span class="au-progress__value js-value"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END TASK PROGRESS-->
    </div>
</div>

@endsection
@section('scripts')
<script>
try {

// Recent Report 2
const bd_brandProduct2 = 'rgba(0,181,233,0.9)'
const bd_brandService2 = 'rgba(0,173,95,0.9)'
const brandProduct2 = 'rgba(0,181,233,0.2)'
const brandService2 = 'rgba(0,173,95,0.2)'

var data3 = [{!! $cantE !!}];
var ctx = document.getElementById("recent-rep2-chart");
if (ctx) {
    ctx.height = 230;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
        labels: [{!! $fechaE !!}],
        datasets: [
            {
                label: 'Novedades',
                backgroundColor: brandService2,
                borderColor: bd_brandService2,
                pointHoverBackgroundColor: '#fff',
                borderWidth: 0,
                data: data3
            }
        ]
        },
        options: {
        maintainAspectRatio: true,
        legend: {
            display: false
        },
        responsive: true,
        scales: {
            xAxes: [{
            gridLines: {
                drawOnChartArea: true,
                color: '#f2f2f2'
            },
            ticks: {
                fontFamily: "Poppins",
                fontSize: 12
            }
            }],
            yAxes: [{
            ticks: {
                beginAtZero: true,
                maxTicksLimit: 5,
                stepSize: 2,
                max: 10,
                fontFamily: "Poppins",
                fontSize: 12
            },
            gridLines: {
                display: true,
                color: '#f2f2f2'

            }
            }]
        },
        elements: {
            point: {
            radius: 0,
            hitRadius: 10,
            hoverRadius: 4,
            hoverBorderWidth: 3
            },
            line: {
            tension: 0
            }
        }


        }
    });
}

} catch (error) {
console.log(error);
}

</script>

@endsection
