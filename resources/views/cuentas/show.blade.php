@extends ('layouts.admin', ['title_template' => "Cuenta $cuenta->cod"])
@section('extracss')
<style>
    table#tablaContactos th{
        font-size:12px;
    }
    table#tablaContactos td{
        font-size: 13px;
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
</style>
@endsection

@section ('contenidoHeader')
<div class="col">
    <div class="overview-wrap">
        <h2 class="title-1">Cuenta {{ $cuenta->cod }} </h2>
        <a href="/cuentas" class="au-btn au-btn-icon btn-outline-secondary border border-secondary font-weight-bold">
            <i class="fa fa-list-ul"></i> Ver cuentas
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
                        <table class="table table-borderless table-earning-large">
                            <tr>
                                <th class="font-weight-bold">Nombre de cuenta</th>
                                <td>{!! $cuenta->nombre_cuenta !!}</td>
                            </tr>
                            <tr>
                                <th class="font-weight-bold">Cliente</th>
                                <td>{!! $cuenta->cliente->nombre !!}</td>
                            </tr>
                            <tr>
                                <th class="font-weight-bold">Regional</th>
                                <td>{!! $cuenta->regional->nombre_regional !!}</td>
                            </tr>
                            <tr>
                                <th class="font-weight-bold">Departamento</th>
                                <td>{!! $cuenta->regional->nameCiudad() !!}</td>
                            </tr>
                        </table>
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
                            Contactos
                            <small>
                                <a href="/contactos/modalCreate/{{ code($cuenta->id) }}" rel="modalCreate" class="badge badge-success float-right mt-1">
                                    <i class="fa fa-plus"></i>&nbsp;
                                    NUEVO
                                </a>
                            </small>
                        </strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table table-vcenter table-center table-vcenter table-hover table-earning-large text-center" id="tablaContactos">
                                <thead class="font-weight-bold ">
                                    <tr>
                                        <th width="30%">NOMBRE Y CARGO</th>
                                        <th width="20%">ASIGNACIÓN</th>
                                        <th width="30%">CELULAR Y EMAIL</th>
                                        <th width="10%">OPC.</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($contactos as $contacto)
                                        <tr>
                                            <td>{!! $contacto->nombre_contacto.'<br><b>'.$contacto->cargo_contacto.'</b>' !!}</td>
                                            <td>{{ $contacto->getInfoAsignacion() }}</td>
                                            <td class="text-center">
                                                {!! $contacto->celular_contacto.'<br>'.$contacto->email_contacto !!}
                                            </td>
                                            <td>{!! $contacto->getOperacionesHTML() !!}</td>
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
                        Nuevo contacto
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
