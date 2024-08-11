<div class="modal-header">
    <h5 class="modal-title font-weight-bold text-primarydark">
        Editar contacto: {{ $contacto->nombre }}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    {{Form::Open(array('action'=>array('ContactosCuentasController@update',code($contacto->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditarCuenta', 'onsubmit'=>'botonEditar.disabled = true; return true;'))}}
    <div class="row">
        {!! datosRegistro('edit') !!}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="nombreContactoedit--label">* Nombre completo</label>
                <input class="form-control" type="text" name="nombreContactoedit" placeholder="Nombre de contacto" value="{{ $contacto->nombre_contacto }}">
                <span id="nombreContactoedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="cargoedit--label">* Cargo</label>
                <input class="form-control" type="text" name="cargoedit" placeholder="Cargo" value="{{ $contacto->cargo_contacto }}">
                <span id="cargoedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
                <label id="celularedit--label"> Celular</label>
                <input class="form-control" type="text" name="celularedit" placeholder="Celular" value="{{ $contacto->celular_contacto }}">
                <span id="celularedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="emailedit--label">* Email</label>
                <input class="form-control" type="text" name="emailedit" placeholder="ejemplo@mail.com" value="{{ $contacto->email_contacto }}">
                <span id="emailedit-error" class="text-red"></span>
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
    var campos = ['nombreContactoedit', 'cargoedit', 'celularedit', 'emailedit'];
    ValidateAjax("formEditarCuenta",campos,"botonEditar","{{ route('contactos.update',code($contacto->id) )}}","POST","/cuentas/show/{{ code($contacto->cuenta_id) }}");
</script>