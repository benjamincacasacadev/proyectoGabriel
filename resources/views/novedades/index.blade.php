@extends ('layouts.admin', ['title_template' => "Novedades"])
@section('extracss')
<style>
    table#tablaNovedades th{
        font-size:12px;
    }
    table#tablaNovedades td{
        font-size: 13px;
    }
    .table {
        table-layout: auto !important;
        width: 100% !important;
    }

    .table-earning-large thead th {
        background: #333;
        font-size: 16px;
        color: #fff;
        vertical-align: middle;
        font-weight: 400;
        text-transform: capitalize;
        line-height: 1;
        padding: 20px 0px 20px 0px;
    }

    .table-earning-large tbody td {
        color: #808080;
        padding: 20px 5px;
    }

    .whiteSpace{
        white-space: nowrap !important;
    }
    .dt-buttons{
        width: 100% !important;
    }
</style>
@endsection

@section ('contenidoHeader')
<div class="col">
    <div class="overview-wrap">
        <h2 class="title-1">Novedades</h2>
        @if (permisoAdministrador())
            <a href="/novedades/modalCreate" rel="modalCreate" title="Nueva novedad" class="au-btn au-btn-icon au-btn--blue font-weight-bold">
                <i class="fa fa-plus"></i> NOVEDAD
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
                {!! Form::open(['route'=>'novedades.index','method'=>'GET', 'role'=>'search', 'id'=>'formFilterNovedades']) !!}
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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                        <div class="pull-right">
                            <div class="form-inline"  >
                                <div class="form-group">
                                    <div class="divEstado pull-right" >
                                        <select class="form-control selectEstado" name="selectEstado" style=" margin-right:-10px; width:192px;">
                                            <option @if($selectEstado == '') selected @endif value="">Todos</option>
                                            <option @if($selectEstado == 'C') selected @endif value="C">Cerrado</option>
                                            <option @if($selectEstado == 'S') selected @endif value="S">En seguimiento</option>
                                        </select>
                                    </div>
                                    <span class="pull-right font-weight-bold" style="margin-top: 8px;">Estado:&nbsp;&nbsp; </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}

                {{-- TABLA DE DATOS --}}
                {!! Form::open(['route'=>'novedades.export','method'=>'POST', 'role'=>'search', 'id'=>'formExport', 'onsubmit'=>'btnExportBoton.disabled = true; return true;']) !!}
                <div class="table-responsive">
                    <table class="table table-vcenter table-center table-hover table-earning-large table-sm text-center" id="tablaNovedades">
                        <thead>
                            <tr>
                                <th width="5%">CÓDIGO</th>
                                <th width="7%">FECHA</th>
                                <th width="5%">OPERADOR</th>
                                <th width="8%">ÁMBITO</th>
                                <th width="8%">EVENTO</th>
                                <th width="5%">CUENTA/MATRICULA</th>
                                <th width="7%">REGIONAL</th>
                                <th width="7%">DEPARTAMENTO</th>
                                <th width="5%">REPORTADO A</th>
                                <th width="5%">ESTADO</th>
                                <th width="2%">OPC.</th>
                            </tr>
                        </thead>
                        <thead role="row">
                            <tr class="filters">
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="codb"/></td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="fechab"/></td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="operadorb"/></td>
                                <td>
                                    <select class="selector" name="ambitob">
                                        <option value="" selected>Todos</option>
                                        @foreach (listaAmbitos() as $keyAmbito => $ambito)
                                            <option value="{{ $keyAmbito }}">{{ $ambito }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="selector" name="eventob">
                                        <option value="" selected>Todos</option>
                                        @foreach (listaEventos() as $keyEvento => $evento)
                                            <option value="{{ $keyEvento }}">{{ $evento }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="cuentab"/></td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="regionalb"/></td>
                                <td></td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="reportadob"/></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <input class="hidden" type="text" name="estadob" value="{{ $selectEstado }}"/>
                <input class="hidden" type="text" name="departamentob" value="{{ $selectDepartamento }}"/>
                {!! Form::close() !!}
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
                        Registro de novedad
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Eliminar --}}
    <div class="modal modal-danger fade" aria-hidden="true" role="dialog" id="modalEstado" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
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

    {{-- Modal Comentarios --}}
    <div class="modal modal-danger fade" aria-hidden="true" role="dialog" id="modalComentarios" data-backdrop="static">
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
    modalAjax("modalEstado","modalEstado","modal-content");
    modalAjax("modalEditar","modalEditar","modal-content");
    modalAjax("modalComentarios","modalComentarios","modal-content");
    $('.selector').select2();

    $('.selectDepartamento').on('change', function () {
        $('#formFilterNovedades').submit();
    });
    $('.selectEstado').on('change', function () {
        $('#formFilterNovedades').submit();
    });


    var departamento = '{{ $selectDepartamento }}';
    var estado = '{{ $selectEstado }}';
    $(function () {
        $('#tablaNovedades').on('init.dt', function() {
            $(".exportBoton").attr('name','btnExportBoton');
        });

        var table = $('#tablaNovedades').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': false,
            'info': true,
            'autoWidth': true,
            'mark': "true",
            'dom': 'lBrtip',
            "stateSave": false,
            "pageLength": 25,
            processing: true,
            serverSide: true,
            'buttons': [
                {
                    text: '<i class="fa fa-file-excel text-success fa-lg"></i>',
                    className: 'border border-success pull-right exportBoton',
                    titleAttr: 'Exportar en excel',
                    action: function ( e, dt, node, config ) {
                        toastr.options = {
                            "positionClass": "toast-bottom-right",
                            "progressBar": true,
                        };
                        toastr.info('No cierre la ventana actual hasta que termine el proceso','Generando archivo', { timeOut: 90000 });
                        $(".exportBoton").attr('disabled',true);
                        $(".exportBoton").addClass('cursor-wait');
                        $(".exportBoton").attr('title','Espere un momento');
                        $("#tipoExport").val('excel');
                        var registerForm = $("#formExport");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: "{{route('novedades.export')}}",
                            type:'POST',
                            data:formData,
                            xhrFields: {
                                responseType: 'blob'
                            },
                            success:function(response) {
                                window.toastr.clear();
                                if(response){
                                    let date = new Date()
                                    let day = date.getDate()
                                    let month = date.getMonth() + 1
                                    let year = date.getFullYear()
                                    var fecha = '';
                                    var nameModulo = "novedades";
                                    var langUsuario = "{!! App::getLocale() !!}";

                                    day = day < 10 ? `0${day}` : `${day}`;
                                    month = month < 10 ? `0${month}` : `${month}`;
                                    if(langUsuario == 'es'){
                                        fecha = `${day}-${month}-${year}`;
                                    }else{
                                        fecha = `${month}-${day}-${year}`;
                                    }

                                    var a = document.createElement('a');
                                    var url = window.URL.createObjectURL(response);
                                    a.href = url;
                                    a.download = nameModulo+'_'+fecha+'.xlsx';
                                    document.body.append(a);
                                    a.click();
                                    a.remove();
                                    window.URL.revokeObjectURL(url);
                                }
                            },
                            error: function(data){
                                window.toastr.clear();
                                if(data.status == 202){
                                    window.location.reload();
                                }
                                if(data.status == 201){
                                    toastr.warning( '{!! trans("invent.records_available_export") !!}','{!! trans("invent.no_data") !!}');
                                }
                                setTimeout( function(){
                                    $(".exportBoton").attr('disabled',false);
                                    $(".exportBoton").attr('title','{!! trans("invent.export_to_excel") !!}');
                                    $(".exportBoton").removeClass('cursor-wait');
                                },2000);
                            }
                        });

                    }
                },
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": ["_all"]
            }],
            "ajax": {
                "url": "{{ route('novedades.table') }}",
                'dataType': 'json',
                'type': 'post',
                'data': {
                    "_token": "{{ csrf_token() }}",
                    departamento: departamento,
                    estado: estado,
                },
            },
            "columns": [
                {"data": "cod"},
                {"data": "fecha"},
                {"data": "operador"},
                {"data": "ambito"},
                {"data": "evento"},
                {"data": "cuentaMatricula"},
                {"data": "regional"},
                {"data": "departamento"},
                {"data": "reportado"},
                {"data": "estado"},
                @if (permisoAdministrador())
                    {"data": "operations", "class": 'whiteSpace'},
                @endif
            ],
            "drawCallback": function () {
                restartActionsDT();
                $('[data-toggle="tooltip"]').tooltip({
                    html: true,
                    "placement": "top",
                    "container": "body",
                });
            }
        });

        // BUSCAR Filtros de DataTable
        filterInputDT(table);
    });
</script>
@endsection
