
@extends ('layouts.admin', ['title_template' => "Crear usuario"])
@section('extracss')
<link rel="stylesheet" href="{{asset('/plugins/iCheck/all.css')}}">

@endsection
@section ('contenidoHeader')

<div class="col">
    <div class="overview-wrap">
        <h2 class="title-1">Crear operador</h2>
        <a href="/users" title="Nuevo usuario" class="au-btn au-btn-icon btn-outline-secondary border border-secondary font-weight-bold">
            <i class="fa fa-list-ul"></i> Ver operadores
        </a>
    </div>
</div>

@endsection
@section ('contenido')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            {!! Form::open(array('route' => 'users.store','method'=>'POST', 'onsubmit'=>'btnSubmit.disabled = true; return true;','id'=>'formCreateUsuarios')) !!}
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label id="username--label">* Nombre de usuario: &nbsp;<i class="text-sm text-primarydark">** Con el cual accederá al sistema</i></label>
                        <input class="form-control" placeholder="Nombre de usuario" id="name_usr" name="username">
                        <span id="validar" class="font-weight-bold" style="text-align:right"></span> <br>
                        <span id="username-error" class="text-red"></span>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label id="password--label">* Contraseña:</label> &ensp; <small class="form-text text-yellow font-weight-bold"></small>
                        <input class="form-control" placeholder="Número de cédula de identidad" name="password">
                        <span id="password-error" class="text-red"></span> <br>
                        <span class="label label-light"></span>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label id="name--label">* Nombre(s):</label>
                        <input class="form-control" placeholder="Nombre(s)" name="name">
                        <span id="name-error" class="text-red"></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label id="ap_paterno--label">* Apellido Paterno:</label>
                        <input class="form-control" placeholder="Apellido Paterno" name="ap_paterno">
                        <span id="ap_paterno-error" class="text-red"></span>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label id="ap_materno--label">Apellido Materno:</label>
                        <input class="form-control" placeholder="Apellido Materno" name="ap_materno">
                        <span id="ap_materno-error" class="text-red"></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label id="celular--label">Celular:</label>
                        <input class="form-control" placeholder="Celular" name="celular" >
                        <span id="celular-error" class="text-red"></span>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label id="roles--label">* Asignar rol: </label>
                        <div class="form-group">
                            <select class="form-control form-select" id="tipoRol" name="roles">
                                <option value="" hidden>Seleccionar una opción</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            <span id="roles-error" class="text-red"></span>
                        </div>
                    </div>
                </div>

                <div class="pull-right" id="registrar">
                    <button type="submit" class="au-btn au-btn--submit font-weight-bold" name="btnSubmit">Registrar</button>
                </div>
                <div class="pull-right" id="msgerror" style="display: none">
                    <strong>El nombre de usuario debe ser único</strong>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script>
        var dtTimer;
        $(document).ready(function () {
            $('#tipoRol').children("option:selected").val("");
            clearTimeout(dtTimer);
            $('#name_usr').keyup(function(){
                var query = $('#name_usr').val();
                if (query != '') {
                    clearTimeout(dtTimer);
                    var _token = $('input[name="_token"]').val();
                    dtTimer = setTimeout(function(){
                        $.ajax({
                            url: "{{ route('users.validar') }}",
                            method: "POST",
                            data: { query: query, _token: _token },
                            success: function (data) {
                                $('#validar').fadeIn();
                                $('#validar').html(data.msg);
                                setTimeout(function() {
                                    $('#validar').fadeOut(1500);
                                },5000);
                                //$('#validar').fadeIn();
                                var sw=$('#sw').val();
                                if(sw==0){
                                    $('#msgerror').hide();
                                    $('#registrar').show();
                                    $('#name_usr').removeClass('is-invalid').addClass('is-valid');
                                }else{
                                    $('#name_usr').removeClass('is-valid').addClass('is-invalid');
                                    $('#msgerror').show();
                                    $('#registrar').hide();
                                }
                            }
                        });
                    }, 1000);
                }
            })
        });
    </script>

    {{-- ===========================================================================================
                                    VALIDACION DE CREATE USERS
    =========================================================================================== --}}
    <script>
        var campos = [ 'username', 'password', 'name', 'ap_paterno', 'ap_materno','email','celular', 'roles'];
        ValidateAjax("formCreateUsuarios",campos,"btnSubmit","{{route('users.store')}}","POST","/users");
    </script>
@endsection
