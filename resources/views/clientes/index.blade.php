@extends ('layouts.admin', ['title_template' => "Clientes"])
@section('extracss')
<style>
    table#tablaClientes th{
        font-size:12px;
    }
    table#tablaClientes td{
        font-size: 13px;
    }
</style>
@endsection

@section ('contenidoHeader')
<div class="col">
    <div class="overview-wrap">
        <h2 class="title-1">Clientes</h2>
        @if (permisoAdministrador())
            <a href="/clientes/modalCreate" rel="modalCreate" title="Nuevo cliente" class="au-btn au-btn-icon au-btn--blue font-weight-bold">
                <i class="fa fa-plus"></i> CLIENTE
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
                {{-- TABLA DE DATOS --}}
                <div class="table-responsive ">
                    <table class="table table-vcenter table-center table-hover table-earning" id="tablaClientes">
                        <thead>
                            <tr>
                                <th width="20%">NOMBRE DE CLIENTE</th>
                                <th width="20%">NIT</th>
                                <th width="20%">DIRECCIÓN</th>
                                <th width="10%">ESTADO</th>
                                <th width="3%">OPC.</th>
                            </tr>
                        </thead>

                        <thead role="row">
                            <tr class="filters">
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="nombreb"/></td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="nitb"/></td>
                                <td><input style="width: 100%;font-size:10px" class="form-control" type="text" placeholder="🔍 &nbsp;Buscar" name="direccionb"/></td>
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
                        Nuevo cliente
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

    $(function () {
        var table = $('#tablaClientes').DataTable({
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
                "url": "{{ route('clientes.table') }}",
                'dataType': 'json',
                'type': 'post',
                'data': {
                    "_token": "{{ csrf_token() }}",
                },
            },
            "columns": [
                {"data": "nombre"},
                {"data": "nit"},
                {"data": "direccion"},
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
