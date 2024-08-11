{!! Form::open( array('route' =>'clientes.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCrearCliente', 'onsubmit'=>'botonGuardar.disabled = true; return true;'))!!}
<div class="row">
    {!! datosRegistro('create') !!}

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="col-form-label" id="nombre--label">* Nombre de cliente</label> <br>
            <input class="form-control" name="nombre" type="text" placeholder="Nombre de cliente">
            <span id="nombre-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="col-form-label" id="nit--label">* Número de NIT</label> <br>
            <input class="form-control" name="nit" type="text" placeholder="Número de NIT">
            <span id="nit-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="col-form-label" id="direccion--label">Dirección</label> <br>
            <textarea name="direccion"  rows="2" class="form-control" style="width:100%;resize:none" placeholder="Dirección"></textarea>
            <span id="direccion-error" class="text-red"></span>
        </div>
    </div>

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

    var campos = ['nombre','nit','direccion'];
    ValidateAjax("formCrearCliente",campos,"botonGuardar","{{route('clientes.store')}}","POST","/clientes");
</script>