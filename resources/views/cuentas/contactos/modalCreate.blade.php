{!! Form::open( array('route' =>'contactos.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCrearContacto', 'onsubmit'=>'botonGuardar.disabled = true; return true;'))!!}
<div class="row">
    {!! datosRegistro('create') !!}

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="nombreContacto--label">* Nombre completo</label>
            <input class="form-control" type="text" name="nombreContacto" placeholder="Nombre de contacto">
            <span id="nombreContacto-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="cargo--label">* Cargo</label>
            <input class="form-control" type="text" name="cargo" placeholder="Cargo">
            <span id="cargo-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
        <div class="" id="asignacion-sel2">
            <label id="asignacion--label">* Asignación</label>
            <select name="asignacion" class="form-control form-select selector-modal" style="width: 100%">
                <option value="">Seleccione una opción</option>
                <option value="L">Llave</option>
                <option value="C">Clave</option>
            </select>
            <span id="asignacion-error" class="text-red"></span>
        </div>
        <div class="divInfoDepartamento" style="display:none"></div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
            <label id="celular--label"> Celular</label>
            <input class="form-control" type="text" name="celular" placeholder="Celular">
            <span id="celular-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="email--label">* Email</label>
            <input class="form-control" type="text" name="email" placeholder="ejemplo@mail.com">
            <span id="email-error" class="text-red"></span>
        </div>
    </div>

    <input type="text" name="cuentaId" value="{{$cuentaId}}" hidden>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primarydark pull-right" name="botonGuardar">Registrar</button>
    </div>
</div>
{{Form::Close()}}

<script>

    $(document).ready(function () {
        $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
        $(".select2-selection--single").addClass('form-selectcont');
    });

    var campos = ['nombreContacto', 'cargo', 'asignacion', 'celular', 'email', 'cuentaId'];
    ValidateAjax("formCrearContacto",campos,"botonGuardar","{{route('contactos.store')}}","POST","/cuentas/show/{{ $cuentaId }}");
</script>