    <div class="modal-status @if($users->active == 1) bg-yellow @else bg-green @endif"></div>
    {{Form::open(array('action'=>array('UserController@cambiarestado',code($users->id)),'method'=>'post', 'onsubmit'=>'btnCambEstado.disabled = true; return true;'))}}
        <div class="modal-body text-center py-4 px-4">
            <br>
            @if ($users->active == 1)
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
                    <i class="fa fa-user-slash text-yellow fa-lg" style="font-size:40px !important"></i>
                </div>
                <h5 class="font-weight-bold">¿Está seguro?</h5>
                <div class="text-muted">
                    ¿Está seguro de de cambiar a estado INACTIVO al usuario <b>{{userFullName($users->id)}}?</b>?
                </div>
            @else
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
                    <i class="fa fa-user-check text-success fa-lg" style="font-size:50px !important"></i>
                </div>
                <h5 class="font-weight-bold">¿Está seguro?</h5>
                <div class="text-muted">
                    ¿Está seguro de de cambiar a estado ACTIVO al usuario <b>{{userFullName($users->id)}}?</b>?
                </div>
            @endif
        </div>
        <div class="modal-footer">
            <div class="w-100">
                <div class="row">
                    <div class="col-6">
                        <a class="au-btn btn-outline-secondary border border-secondary" data-dismiss="modal">
                            Cancelar
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="au-btn @if($users->active == 1) au-btn--yellow @else au-btn--green @endif w-100 p-0" name="btnCambEstado">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    {{Form::Close()}}


