@section('extracss')
<style>
    .btn-outline-primary-dotted {
        color: #365cad !important;
        background-color: transparent;
        background-image: none;
        border-color: #365cad;
        width: 250px;
        border-style: dashed;
        border-width: 2px;
        border-color: #365cad;
    }

    .btn-outline-primary-dotted:hover {
        color: #eee !important;
        background-color: #365cad;
        border-color: #eee;
    }
    .divAccesos{
        width: 150px;
    }
    @media  (max-width: 800px){
        .divAccesos{
            width: 125px;
        }
    }
</style>
@endsection
@extends ('layouts.admin', ['title_template' => "Usuario: ".userFullName($user->id).""])

@section ('contenidoHeader')
<div class="col">
    <div class="page-pretitle">
        {{nameEmpresa()}}
    </div>
    <h2 class="page-title">
        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 11l2 2l4 -4" /></svg>
        &nbsp;Usuario: &nbsp;&nbsp;{{userFullName($user->id)}}
    </h2>
</div>

<div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
        @if (Gate::check('roles.index'))
            <a href="/roles" class="btn btn-outline-secondary">
                <b><svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="4" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                Ver roles</b>
            </a>
        @endif
        @if (Gate::check('users.index'))
            <a href="/users" class="btn btn-outline-secondary">
                <b><svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                Ver usuarios</b>
            </a>
        @endif
    </div>
</div>

@endsection

@section ('contenido')
@php
    $varmasSW = 1;
    $cant = 0;
@endphp
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-5 col-lg-5 col-sm-12 d-flex justify-content-center">
                    <img class="img-rounded" style="max-width: 40%;border-radius: 5%" src="{{ imageRouteAvatar($user->avatar,0) }}">
                </div>
                <div class="col-md-7 col-lg-7 col-sm-12">
                    <table class="table table-lg table-responsive">
                        <tr>
                            <td class="font-weight-bold">Nombre</td>
                            <td>{{ $user->fullName }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Nombre de usuario</td>
                            <td>{{$user->username}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">E-mail</td>
                            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Celular</td>
                            <td>{{ checkVacio($user->celular) ? $user->celular : '-'}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Rol:</td>
                            <td>
                                <label class="badge badge-info font-weight-bold">
                                    {{$user->rolUser->name}}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Estado</td>
                            <td>@if ( $user->active==1 )
                                <span class="badge badge-pill bg-green font-weight-bold">ACTIVO</span>
                                @else
                                <span class="badge badge-pill bg-red font-weight-bold">INACTIVO</span>
                                @endif</td>
                            <td>
                        </tr>
                    </table>
                </div>
            </div>


            {{--//========================================================================================
            *                                    Fin de la información                                  *
            //========================================================================================--}}
            <div class="row justify-content-md-center" style="margin-top:20px">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <a type="button" class="btn btn-outline-primarydark btn-lg" href="/users/{{code($user->id)}}/edit" title="Editar">
                        <i class="fa fa-edit"></i> Editar
                    </a>
                </div>
                @if($user->id != userId())
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        @if ($user->active == 1)
                            <a class="btn btn-outline-yellow btn-lg" rel="modalCambioEstado" href="/users/modalCambEstado/{{code($user->id)}}" title="Desactivar">
                                <i class="fa fa-plug"></i> Desactivar
                            </a>
                        @else
                            <a class="btn btn-outline-success btn-lg" rel="modalCambioEstado" href="/users/modalCambEstado/{{code($user->id)}}" title="Activar">
                                <i class="fa fa-plug"></i> Activar
                            </a>
                        @endif
                    </div>
                @endif
                @if($user->id != userId())
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        <a class="btn btn-outline-danger btn-lg" rel="modalEliminar" href="/users/modalDelete/{{code($user->id)}}" title="Eliminar">
                            <i class="fa fa-trash-alt"></i> Eliminar
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('modals')
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
<script src="{{asset('file-explore/js/file-explore.js')}}" type="text/javascript"></script>
<script type="text/javascript">

    $('#verMas').click(function(){
        $('#InputLimite').val(parseInt ($('#InputLimite').val())+40);
        $('#formVermas').submit();
    });

    //popover
    $(function () {
        $('[data-toggle="popover"]').popover({
            html: true,
            "trigger": "hover",
            "placement": "top",
            "container": "body",
        });
        $('[data-toggle="popover"]').on('click', function (e) {
            $('[data-toggle="popover"]').popover('hide');
        });
    });

    modalAjax("modalEliminar","modalEliminar","modal-content");
    modalAjax("modalCambioEstado","modalCambioEstado","modal-content");
</script>
@endsection
