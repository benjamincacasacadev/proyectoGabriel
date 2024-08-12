@extends ('layouts.admin', ['title_template' => "Vehículos"])
@section('extracss')
<style>
    table#tablaVehiculos th{
        font-size:12px;
    }
    table#tablaVehiculos td{
        font-size: 13px;
    }
</style>
@endsection

@section ('contenidoHeader')
<div class="col">
    <div class="overview-wrap">
        <h2 class="title-1">Vehículos</h2>
        @if (permisoAdministrador())
            <a href="/vehiculos/modalCreate" rel="modalCreate" title="Nuevo vehículo" class="au-btn au-btn-icon au-btn--blue font-weight-bold">
                <i class="fa fa-plus"></i> VEHÍCULO
            </a>
        @endif
    </div>
</div>

@endsection

@section ('contenido')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route'=>'vehiculos.index','method'=>'GET', 'role'=>'search', 'id'=>'formFilterVehiculo']) !!}
                <div class="row mb-3 me-1">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pull-right">
                            <div class="form-inline"  >
                                <div class="form-group">
                                    <div class="divEstado pull-right" >
                                        <select class="form-control selectDepartamento" name="selectDepartamento" style=" margin-right:-10px; width:192px;">
                                            <option @if($selectDepartamento == '') selected @endif value="">Todos</option>
                                            @foreach(listaDepartamentos() as $key => $departamento)
                                                <option @if($selectDepartamento == $key) selected @endif value={{ $key }}>{{ $departamento }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="pull-right font-weight-bold" style="margin-top: 8px;">Departamento:&nbsp;&nbsp; </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

                {{-- TABLA DE DATOS --}}
                <div class="table-responsive ">
                    <table class="table table-vcenter table-center table-hover table-earning" id="tablaVehiculos">
                        <thead>
                            <tr>
                                <th width="10%">MATRÍCULA</th>
                                <th width="20%">NOMBRE DE VEHÍCULO</th>
                                <th width="20%">REGIONAL</th>
                                <th width="20%">DEPARTAMENTO</th>
                                <th width="10%">ESTADO</th>
                                <th width="3%">OPC.</th>
                            </tr>
                        </thead>

                        <thead role="row">
                            <tr class="filters">
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="codb"/></td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="nombreb"/></td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="regionalb"/></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
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
                        Nuevo vehículo
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

    $('.selectDepartamento').on('change', function () {
        $('#formFilterVehiculo').submit();
    });
    var departamento = '{{ $selectDepartamento }}';
    $(function () {
        var table = $('#tablaVehiculos').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': false,
            'info': true,
            'autoWidth': false,
            "order": [['0', 'desc']],
            'mark': "true",
            'dom': 'lrtip',
            "stateSave": false,
            "pageLength": 25,
            processing: true,
            serverSide: true,
            "columnDefs": [{
                "orderable": false,
                "targets": ["_all"]
            }],
            "ajax": {
                "url": "{{ route('vehiculos.table') }}",
                'dataType': 'json',
                'type': 'post',
                'data': {
                    "_token": "{{ csrf_token() }}",
                    departamento: departamento,
                },
            },
            "columns": [
                {"data": "matricula"},
                {"data": "nombre"},
                {"data": "regional"},
                {"data": "departamento"},
                {"data": "estado"},
                @if (permisoAdministrador())
                    {"data": "operations"},
                @endif
            ],
            "drawCallback": function () {
                restartActionsDT();
            }
        });

        // BUSCAR Filtros de DataTable
        filterInputDT(table);
    });
</script>
@endsection
