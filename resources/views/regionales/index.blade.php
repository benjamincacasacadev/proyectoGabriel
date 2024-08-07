@extends ('layouts.admin', ['title_template' => "Regionales"])
@section('extracss')
<style>
    table#tablaRegionales th{
        font-size:12px;
    }
    table#tablaRegionales td{
        font-size: 13px;
    }
</style>
@endsection

@section ('contenidoHeader')
<div class="col">
    <div class="overview-wrap">
        <h2 class="title-1">Regionales</h2>
        @if (permisoAdministrador())
            <a href="/regionales/modalCreate" rel="modalCreate" title="Nueva regional" class="au-btn au-btn-icon au-btn--blue font-weight-bold">
                <i class="fa fa-plus"></i> REGIÓNAL
            </a>
        @endif
    </div>
</div>

@endsection

@section ('contenido')

    {{-- TABLA DE DATOS --}}
    <div class="table-responsive ">
        <table class="table table-vcenter table-center table-hover table-earning" id="tablaRegionales">
            <thead>
                <tr>
                    <th width="20%">NOMBRE DE REGIÓN</th>
                    <th width="20%">DEPARTAMENTO</th>
                    <th width="10%">ESTADO</th>
                    <th width="3%">OPC.</th>
                </tr>
            </thead>

            <thead role="row">
                <tr class="filters">
                    <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="nombreb"/></td>
                    <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="departamentob"/></td>
                    <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="estadob"/></td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
                @foreach($regionales as $regional)
                    <tr>
                        <td> {{ $regional->nombre_regional }}</td>
                        <td>{{ $regional->nameCiudad() }}</td>
                        <td class="text-center">
                            @if ( $regional->estado == 1 )
                                <a href="/regionales/estado/{{ code($regional->id) }}/1" class="badge badge-pill bg-green text-white" title="Desactivar regional">
                                    ACTIVO
                                </a>
                            @else
                                <a href="/regionales/estado/{{ code($regional->id) }}/0" class="badge badge-pill bg-red text-white" title="Activar regional">
                                    INACTIVO
                                </a>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-outline-primarydark btn-sm" rel="modalEditar" href="/regionales/modalEdit/{{code($regional->id)}}" title="Editar">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-outline-danger btn-sm" rel="modalEliminar" href="/regionales/modalDelete/{{code($regional->id)}}" title="Eliminar">
                                <i class="fa fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                        Nueva regional
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

    $(document).ready(function () {
        var table = $('#tablaRegionales').DataTable({
            'mark'        : true,
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : false,
            'info'        : true,
            'autoWidth'   : false,
            "pageLength": 25,
            "drawCallback": function () {

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
    });
</script>
@endsection
