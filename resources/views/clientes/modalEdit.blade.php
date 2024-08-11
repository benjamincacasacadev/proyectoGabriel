<div class="modal-header">
    <h5 class="modal-title font-weight-bold text-primarydark">
        Editar regional: {{ $cliente->nombre }}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    {{Form::Open(array('action'=>array('ClientesController@update',code($cliente->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditarCliente', 'onsubmit'=>'botonEditar.disabled = true; return true;'))}}
    <div class="row">
        {!! datosRegistro('edit') !!}

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="col-form-label" id="nombreedit--label">* Nombre de cliente</label> <br>
                <input class="form-control" name="nombreedit" type="text" placeholder="Nombre de cliente" value="{{ $cliente->nombre }}">
                <span id="nombreedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="col-form-label" id="nit--label">* Número de NIT</label> <br>
                <input class="form-control" name="nit" type="text" placeholder="Número de NIT" value="{{ $cliente->nit }}">
                <span id="nit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="col-form-label" id="direccionedit--label">Dirección</label> <br>
                <textarea name="direccionedit"  rows="2" class="form-control" style="width:100%;resize:none" placeholder="Dirección">{!! $cliente->direccion !!}</textarea>
                <span id="direccionedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
            <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primarydark pull-right" name="botonEditar">Modificar</button>
        </div>
    </div>
    {{Form::Close()}}
</div>

<script>
    var campos = ['nombreedit','nit','direccionedit'];
    ValidateAjax("formEditarCliente",campos,"botonEditar","{{ route('clientes.update',code($cliente->id) )}}","POST","/clientes");
</script>