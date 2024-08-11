@extends ('layouts.admin', ['title_template' => "Vehículo $vehiculo->matricula"])
@section('extracss')
<style>
    table#tablaConductores th{
        font-size:12px;
    }
    table#tablaConductores td{
        font-size: 13px;
    }
</style>
@endsection

@section ('contenidoHeader')
<div class="col">
    <div class="overview-wrap">
        <h2 class="title-1">Vehículo {{ $vehiculo->matricula }} </h2>
        <a href="/vehiculos" class="au-btn au-btn-icon btn-outline-secondary border border-secondary font-weight-bold">
            <i class="fa fa-list-ul"></i> Ver vehículos
        </a>
    </div>
</div>

@endsection

@section ('contenido')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="row row-cards">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title mb-3">
                            Datos generales
                        </strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-earning">
                            <tr>
                                <th class="font-weight-bold">Nombre de vehículo</th>
                                <td>{!! $vehiculo->nombre_vehiculo !!}</td>
                            </tr>
                            <tr>
                                <th class="font-weight-bold">Matricula</th>
                                <td>{!! $vehiculo->matricula !!}</td>
                            </tr>
                            <tr>
                                <th class="font-weight-bold">Regional</th>
                                <td>{!! $vehiculo->regional->nombre_regional !!}</td>
                            </tr>
                            <tr>
                                <th class="font-weight-bold">Departamento</th>
                                <td>{!! $vehiculo->regional->nameCiudad() !!}</td>
                            </tr>
                        </table>

                        @php
                            $rutaArchivo = storage_path('app/public/vehiculos/'.$vehiculo->archivo);
                        @endphp

                        <div class="text-center" id="divImageAttach">
                            @if (isset($vehiculo->archivo) && file_exists($rutaArchivo))
                                <a href="/storage/vehiculos/{{$vehiculo->archivo."?".rand()}}." target="_blank">
                                    <img src="/storage/vehiculos/{{$vehiculo->archivo."?".rand()}}." style="max-height: 200px;margin-bottom:10px" alt="Sin imagen para mostrar" >
                                </a>
                            @else
                                <img src="/storage/noimage.png?{{rand()}}" style="max-height: 200px;margin-bottom:10px" >
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="row row-cards">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title ">
                            Conductores
                            <small>
                                <a href="/conductores/modalCreate/{{ code($vehiculo->id) }}" rel="modalCreate" class="badge badge-success float-right mt-1">
                                    <i class="fa fa-plus"></i>&nbsp;
                                    NUEVO
                                </a>
                            </small>
                        </strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table table-vcenter table-center table-vcenter table-hover table-earning text-center" id="tablaConductores">
                                <thead class="font-weight-bold ">
                                    <tr>
                                        <th width="20%">NOMBRE</th>
                                        <th width="20%">CELULAR</th>
                                        <th width="3%">OPC.</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($conductores as $conductor)
                                        <tr>
                                            <td>{!! $conductor->nombre_conductor !!}</td>
                                            <td>
                                                {!! $conductor->celular_conductor !!}
                                            </td>
                                            <td>{!! $conductor->getOperacionesHTML() !!}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3"> <i>Sin datos para mostrar...</i></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('modals')

    {{-- Modal Crear --}}
    <div class="modal modal-danger fade" aria-hidden="true" role="dialog" id="modalCreate" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-primarydark">
                        <i class="fa fa-plus"></i>
                        Nuevo conductor
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Editar --}}
    <div class="modal  fade" aria-hidden="true" role="dialog" id="modalEditar" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>
    </div>

    {{-- Modal Eliminar --}}
    <div class="modal modal-danger fade" aria-hidden="true" role="dialog" id="modalEliminar" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
    modalAjax("modalCreate","modalCreate","modal-body");
    modalAjax("modalEliminar","modalEliminar","modal-content");
    modalAjax("modalEditar","modalEditar","modal-content");
    $('.selector').select2();

</script>
@endsection
