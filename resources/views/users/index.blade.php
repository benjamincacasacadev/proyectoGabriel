@section('extracss')
<style></style>
<style>
    .info-box {
        min-height: 60px;
    }
    .info-box-icon {
        height: 60px; line-height: 50px;
    }
    .info-box-content {
        padding-top: 5px; padding-bottom: 5px;
    }
    @media  (max-width: 1000px){
        #botonesexport{ text-align: center }
    }
    .icon-tabler {
        width: 25px;
        height: 25px;
        stroke-width: 1.25;
        margin-bottom:5px;
    }
    table#tablaUsuarios th{
        font-size:12px;
    }
    table#tablaUsuarios td{
        font-size: 13px;
    }
    .avatar-status {
        position: absolute;
        right: -2px;
        bottom: -2px;
        width: 1rem;
        height: 1rem;
        border: 2px solid #fff;
        border-radius: 50%;
    }
    .card-stamp {
        --stamp-size:7rem;
        position:absolute;
        top:0;
        right:0;
        width:calc(var(--stamp-size) * 1);
        height:calc(var(--stamp-size) * 1);
        max-height:100%;
        border-top-right-radius:4px;
        opacity:.2;
        overflow:hidden;
        pointer-events:none
    }
    .card-stamp-lg {
        --stamp-size: 13rem
    }
    .card-stamp-icon {
        display:flex;
        align-items:center;
        justify-content:center;
        border-radius:100rem;
        color: #FFFFFF;
        width:calc(var(--stamp-size) * 1);
        height:calc(var(--stamp-size) * 1);
        position:relative;
        top:calc(var(--stamp-size) * -.25);
        right:calc(var(--stamp-size) * -.25);
        font-size:calc(var(--stamp-size) * .75);
        transform:rotate(10deg)
    }
    .card-stamp-icon .icon {
        stroke-width:2;
        width:calc(var(--stamp-size) * .75);
        height:calc(var(--stamp-size) * .75)
    }
</style>
@endsection

@extends ('layouts.admin', ['title_template' => "Usuarios"])

@section ('contenidoHeader')

<div class="col">
    <div class="overview-wrap">
        <h2 class="title-1">Operadores</h2>
        <a href="/users/create" title="Nuevo usuario" class="au-btn au-btn-icon au-btn--blue font-weight-bold">
            <i class="zmdi zmdi-plus"></i> Usuario
        </a>
    </div>
</div>
@endsection

@section ('contenido')
    <!-- INDICADORES DE USUARIO -->
    <div class="row">
        <div class="col-md-6 col-lg-4">
            @php
                $s = $usersactive == 1 ? '' : 's';
                $info = 'Usuario'.$s.' '.'activo'.$s;
            @endphp
            <div class="statistic__item text-success">
                <h3 class="number">{{$usersactive}}</h3>
                <b class="desc text-success">{{$info}}</b>
                <div class="icon ">
                    <i class="fa fa-user-plus text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            @php
                $s = $usersinactive == 1 ? '' : 's';
                $info = 'Usuario'.$s.' '.'inactivo'.$s;
            @endphp
            <div class="statistic__item text-yellow">
                <h3 class="number">{{$usersinactive}}</h3>
                <b class="desc text-yellow">{{$info}}</b>
                <div class="icon">
                    <i class="fa fa-user text-yellow"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            @php
                $s = $usersdelete == 1 ? '' : 's';
                $info = 'Usuario'.$s.' '.'eliminado'.$s;
            @endphp
            <div class="statistic__item text-danger">
                <h3 class="number">{{$usersdelete}}</h3>
                <b class="desc text-danger">{{$info}}</b>
                <div class="icon">
                    <i class="fa fa-user-minus text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- REPORTES --}}
                    <div class="row mb-2">
                        <div class="container-fluid text-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-danger border border-danger pull-right mb-2 exportUser" id="pdf" title="Exportar PDF" style="width:242px;">
                                    <i class="fas fa-file-pdf fa-lg" ></i> &nbsp;
                                    <span class="d-none d-sm-inline-block">
                                        Reporte en PDF
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="container-fluid text-right">
                            <div class="form-group">
                                <button class="btn btn-outline-success border border-success pull-right exportUser" type="button" id="excel" style="width:242px;">
                                    <i class="fas fa-file-excel fa-lg " id="icon"> </i> &nbsp;&nbsp;
                                    <span class="d-none d-sm-inline-block">
                                        Reporte en excel
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- TABLA DE DATOS --}}
                    <div class="table-responsive ">
                        <table class="table table-vcenter table-center table-hover table-earning" id="tablaUsuarios">
                            <thead>
                                <tr>
                                    <th width="5%" style="color:transparent !important;"></th>
                                    <th class="hidden"></th>
                                    <th width="20%" class="font-weight-bold">NOMBRE(S)</th>
                                    <th width="20%">E-MAIL</th>
                                    <th width="10%">ESTADO</th>
                                    <th width="10%">ROL</th>
                                    <th width="3%">OP.</th>
                                </tr>
                            </thead>

                            <thead role="row">
                                <tr class="filters">
                                    <td></td>
                                    <td class="hidden"></td>
                                    <td><input style="width: 100%;font-size:10px" id="user0" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="nombreb"/></td>
                                    <td><input style="width: 100%;font-size:10px" id="user1" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="emailb"/></td>
                                    <td><input style="width: 100%;font-size:10px" id="user2" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="estadob"/></td>
                                    <td><input style="width: 100%;font-size:10px" id="user3" class="form-control nopegar" type="text" placeholder="🔍 &nbsp;Buscar" name="rolb"/></td>
                                    <td></td>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($usersa as $user)
                                    <tr>
                                        <td>
                                            <center>
                                                <span class="avatar avatar--small avatar-rounded" style="background-image: url({{ imageRouteAvatar($user->avatar,1) }}); ">
                                                    <span class="@if( $user->id == userId() ) avatar-status bg-success @endif"></span>
                                                </span>
                                            </center>
                                        </td>
                                        <td class="hidden">{{ code($user->id)}}</td>

                                        <td style="text-align: left !important"> {!! $user->getName() !!} </td>
                                        <td >{{ isset($user->email) ? $user->email : '-' }}</td>
                                        <td class="text-center">
                                            @if ( $user->active==1 )
                                                <span class="badge badge-pill bg-green">ACTIVO</span>
                                            @else
                                                <span class="badge badge-pill bg-red">INACTIVO</span>
                                            @endif
                                        </td>
                                        <td >{{ $user->rolUser->name }}</td>
                                        <td>
                                            <span class="form-operations" data-toggle="popoverOper" tabindex="0"
                                                data-content=
                                                    '<a href="/users/{{code($user->id)}}/edit" title="Editar">
                                                        <svg class="icon text-muted iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                                                        &nbsp;<span class="text-muted">Editar</span>
                                                    </a><br>
                                                    @if($user->id != userId())
                                                        @if ($user->active==1)
                                                            <a rel="modalCambioEstado" style="cursor:pointer" href="/users/modalCambEstado/{{code($user->id)}}" title="Desactivar">
                                                                <svg class="icon text-red iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h10v6a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3v-6" /><line x1="9" y1="3" x2="9" y2="7" /><line x1="15" y1="3" x2="15" y2="7" /><path d="M12 16v2a2 2 0 0 0 2 2h3" /></svg>
                                                                &nbsp;<span class="text-red">Desactivar</span>
                                                            </a><br>
                                                        @else
                                                            <a rel="modalCambioEstado" style="cursor:pointer" href="/users/modalCambEstado/{{code($user->id)}}" title="Activar">
                                                                <svg class="icon text-green iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h10v6a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3v-6" /><line x1="9" y1="3" x2="9" y2="7" /><line x1="15" y1="3" x2="15" y2="7" /><path d="M12 16v2a2 2 0 0 0 2 2h3" /></svg>
                                                                &nbsp;<span class="text-green">Activar</span>
                                                            </a><br>
                                                        @endif
                                                    @endif
                                                    @if($user->id != userId())
                                                        <a rel="modalEliminar" style="cursor:pointer" href="/users/modalDelete/{{code($user->id)}}" data-toggle="tooltip" data-placement="top" title="Eliminar" >
                                                            <svg class="icon text-muted iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                            &nbsp;<span class="text-muted">Eliminar</span>
                                                        </a><br>
                                                    @endif
                                                '>
                                                <svg class="icon text-muted btnoper" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <circle cx="12" cy="12" r="1" /><circle cx="12" cy="19" r="1" /><circle cx="12" cy="5" r="1" />
                                                </svg>
                                            <span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ Form::open(['route'=>'users.export','method'=>'GET','role'=>'search','id'=>'formExportUser', 'target'=>'_blank']) }}
                        <input hidden id="tipo" name="tipo">
                        <input hidden id="idsExport" name="idsExport">
                        <button hidden id="btnGenerarExport" type="submit"></button>
                    {!! Form::close() !!}
                </div>
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

    {{-- Modal Cambio Estado --}}
    <div class="modal  fade" aria-hidden="true" role="dialog" id="modalCambioEstado" data-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#tablaUsuarios').DataTable({
            'mark'        : true,
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "order": [[ 0, "desc" ]],
            "pageLength": 25,
            "columnDefs": [ {
                "orderable": false, //5
                    "targets": ["_all"] ,
            } ],

            "drawCallback": function () {
                $('[data-toggle="popoverOper"]').popover({
                    html: true,
                    "trigger" : "focus",
                    "placement": "left",
                    "container": "body",
                    delay: {
                        "hide": 200
                    }
                });

                modalAjax("modalEliminar","modalEliminar","modal-content");
                modalAjax("modalCambioEstado","modalCambioEstado","modal-content");
                $('.inputSearchDT').on('paste', function(e) {
                    var valor = e.originalEvent.clipboardData.getData('Text');
                    var id = $(this).attr('id');
                    if ( noPegar(valor,id,'top') == 1) e.preventDefault();
                });
                $('.inputSearchDT').on('drop', function(e) {
                    event.preventDefault();
                    event.stopPropagation();
                    var id = $(this).attr('id');
                    $('#'+id).attr('data-toggle','popover');
                    $('#'+id).attr('data-trigger','manual');
                    $('#'+id).attr('data-content','<span class="text-red font-weight-bold"><center><i class="fa fa-ban"></i> La acción no se puede realizar.<br>Por favor escríba el texto</center></span>');
                    $('#'+id).attr('data-placement','top');
                    $('#'+id).attr('data-html','true');
                    $('#'+id).attr('data-container','body');
                    $('#'+id).popover('show');
                    setTimeout(function(){
                        $('#'+id).popover('hide');
                        $('#'+id).removeAttr('data-toggle');
                        $('#'+id).removeAttr('data-trigger');
                    }, 2000)
                });
            }
        });

        table.columns().eq( 0 ).each( function ( colIdx ) {
            $( 'input', $('.filters td')[colIdx] ).on( 'keyup', function () {
                table
                    .column( colIdx )
                    .search( this.value )
                    .draw();
            } );
        });

        // input search para el pdf
        $( "input[type='search']" ).focusout(function () {
            $("#searchDT").val(table.search());
        });

        //Exportación en Excel
        $(".exportUser").click(function () {
            var val = $(this).attr('id');
            $("#tipo").val(val);
            //Obtenemos los resultados del filtrado del datatable para enviar los índices para generar el export
            var resultado=table.rows( {order:'applied', search:'applied'} ).data();
            var idsExport=[];
            $.each(resultado, function( indice, fila ) {
                idsExport[indice]=fila[1];
            });
            $('#idsExport').val(idsExport);
            console.log(idsExport);
            $('#btnGenerarExport').click();

        });

        // funcion para ajecutar el export pdf
        $('#exportPdf').click(function () {
            $('#formExport').submit();
        });
    });
</script>
@endsection
