<style>
    .file-drop-zone-title {
        padding: 0px !important;
    }
    .file-preview-frame{
        height: 150px;
    }
    .kv-file-content, .file-preview-other{
        height: 50px !important;
    }
    .file-other-icon{
        font-size: 3em !important
    }
    .krajee-default.file-preview-frame {
        left: 33%;
    }
    @media  (max-width: 991px){
        .krajee-default.file-preview-frame {
            left: 20%;
        }
    }
    @media  (max-width: 767px){
        .krajee-default.file-preview-frame {
            left: 0%;
        }
    }
    .file-caption-main, .kv-error-close{
        display: none !important;
    }
</style>
<link href="{{asset('/plugins/fileinput/css/fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{asset('/plugins/iCheck/all.css')}}">
<div class="modal-header">
    <h5 class="modal-title font-weight-bold text-primarydark">
        Editar vehículo: {{ $vehiculo->nombre_vehiculo }}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    {{Form::Open(array('action'=>array('VehiculosController@update',code($vehiculo->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditarVehiculo', 'onsubmit'=>'botonEditar.disabled = true; return true;'))}}
    <div class="row">
        {!! datosRegistro('edit') !!}

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="col-form-label" id="nombreedit--label">* Nombre de vehículo</label> <br>
                <input class="form-control" name="nombreedit" type="text" placeholder="Nombre de vehículo" value="{{ $vehiculo->nombre_vehiculo }}">
                <span id="nombreedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="col-form-label" id="matricula--label">* Matrícula</label> <br>
                <input class="form-control" name="matricula" type="text" placeholder="Nombre de vehículo" value="{{ $vehiculo->matricula }}">
                <span id="matricula-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <div class="" id="regionaledit-sel2">
                <label id="regionaledit--label">* Regional</label>
                <select name="regionaledit" class="form-control form-select selector-modal-edit" style="width: 100%">
                    <option value="">Seleccione una opción</option>
                    @foreach ($regionales as $regional)
                        @php
                            $isSelected = '';
                            if($regional->id == $vehiculo->regional_id){
                                $isSelected = 'selected';
                            }
                        @endphp
                        <option value="{{ $regional->id }}" data-departamento="{{ $regional->nameCiudad() }}" data-extra= {{ $regional->departamento }} {{ $isSelected }}>{{ $regional->nombre_regional }}</option>
                    @endforeach
                </select>
                <span id="regionaledit-error" class="text-red"></span>
            </div>
            <div class="divInfoDepartamentoEdit">
                <i style="font-size:11px"><b style="font-size:11px">Departamento: </b>{{ $vehiculo->regional->nameCiudad() }}</i>
            </div>
        </div>

        <input class="form-control" name="departamentoIdedit" id="departamentoInputEdit" type="text" value="{{ $vehiculo->regional->departamento }}" hidden>

                {{-- CAMBIAR ARCHIVO --}}
            @php
                $rutaArchivo = storage_path('app/public/vehiculos/'.$vehiculo->archivo);
                $ocultarDivArchivo = '';
                if($vehiculo->archivo == '' || $vehiculo->archivo == null || !file_exists($rutaArchivo)){
                    $ocultarDivArchivo = 'display:none';
                }
                $ocultarInputArchivo = '';
                if($vehiculo->archivo != '' && $vehiculo->archivo != null && file_exists($rutaArchivo)){
                    $ocultarInputArchivo = 'display:none';
                }
            @endphp
            {{-- CAMBIAR IMAGEN ADJUNTA DE VEHICULOS --}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="{{ $ocultarDivArchivo }}">
                <b>Ver imagen adjunta</b>
                <i class="fa fa-arrow-circle-right"></i>
                <a href="/storage/vehiculos/{{ $vehiculo->archivo }}" target="_blank">
                    <i class="fa fa-image fa-lg text-primarydark"></i>
                </a><br>
                <label class="text-primarydark cursor-pointer">Cambiar imagen
                    <input type="checkbox" class="cambioarchivo" name="cambioarchivo" value="1">
                </label>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 archivodiv" id="fileVehiculosedit--label" style="{{ $ocultarInputArchivo }}">
                <span class="titleFile font-weight-bold"><i>(Opcional)</i> Imagen o fotografía del vehículo</span>
                <span id="fileRequired" class="font-weight-bold" style="display: none">* Imagen o fotografía del vehículo</span>
                <br>
                <div style="padding-left: 25px;" class="mb-2">
                    <b><i class="fa fa-arrow-circle-right"></i> &nbsp;Extensiones soportadas:</b>&nbsp;&nbsp;.jpg, .jpeg, .png<br>
                    <b><i class="fa fa-arrow-circle-right"></i> &nbsp;Tamaño máximo: </b>2 MB (2048 KB)<br>
                </div>
                <div id="fileAssets_fg" class="form-group" style="margin:0; padding:0" >
                    <input type="file" class="input-sm" id="fileVehiculosedit" name="fileVehiculosedit" data-max-size="2048" data-browse-on-zone-click="true" accept=".jpg, .jpeg, .png, .mp4">
                    <span id="fileVehiculosedit-error" class="text-red fileVehiculosedit-error"></span>
                </div>
            </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
            <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primarydark pull-right" name="botonEditar">Modificar</button>
        </div>
    </div>
    {{Form::Close()}}
</div>

<script src="{{asset('/plugins/fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
        $(".select2-selection--single").addClass('form-selectcont');

        $("#fileVehiculosedit").fileinput({
            // Validación del tipo de archivo (Incluye Drag and Drop)
            showUpload: false,
            allowedFileExtensions: ["jpg","jpeg","png"],
            // Validación del tamaño de archivo máximo a subir (Incluye Drag and Drop)
            maxFileSize: 2048,
            // Máximo tamaño a previsualizar
            maxFilePreviewSize: 2048,
            // Color de fondo de la zona Drag and Drop
            previewClass: "bg-fileinput",
            preferIconicPreview: true,
            previewFileIconSettings: {
                'docx': '<i class="fas fa-file-word text-primary"></i>',
                'xlsx': '<i class="fas fa-file-excel text-success"></i>',
                'pptx': '<i class="fas fa-file-powerpoint text-danger"></i>',
                'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                'zip': '<i class="fas fa-file-archive text-muted"></i>',
            },
            "fileActionSettings":{ "showZoom":true }
        });

        $('.cambioarchivo').iCheck({
            checkboxClass: 'icheckbox_square-blue',
        }).on('ifChecked', function (event) {
            $('.titleFile').hide();
            $('#fileRequired').show();
            $('.archivodiv').slideDown();
        }).on('ifUnchecked', function (event){
            $('.archivodiv').slideUp();
        });
    });

    $('[data-toggle="popover"]').popover({
        html: true,
        "trigger" : "hover",
        "placement": "top",
        "container": "body",
    });

    function formatState (regional) {
        var departamentoSelect = $(regional.element).data('departamento');

        if (typeof departamentoSelect === 'undefined') {
            return regional.text;
        }
        var departamentoHTML = "";
        if(departamentoSelect != ""){
            departamentoHTML = '<br><i style="font-size:11px"><b style="font-size:11px">Departamento:</b> '+departamentoSelect+'</i>';
        }

        var $regional = $(
            '<span>' + regional.text + departamentoHTML + '</span>'
        );
        return $regional;
    };

    $('select.selector-modal-edit:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatState,
        });
    });

    $('.selector-modal-edit').change(function () {
        var data = $('.selector-modal-edit').select2('data')[0];
        var departamento = $(data.element).data('departamento');
        var departamentoId = $(data.element).data('extra');
        var info;
        if (typeof departamento === 'undefined') {
            info = '';
            $('#departamentoInputEdit').val('');
            $(".divInfoDepartamentoEdit").hide();
            $(".divInfoDepartamentoEdit").removeClass('mb-2');
        }else{
            info = '<i style="font-size:11px"><b style="font-size:11px">Departamento: </b>'+departamento+'</i>';
            $(".divInfoDepartamentoEdit").show();
            $(".divInfoDepartamentoEdit").addClass('mb-2');
            $('#departamentoInputEdit').val(departamentoId);
        }
        $(".divInfoDepartamentoEdit").html(info);
    });

    var campos = ['nombreedit','matricula','regionaledit','fileVehiculosedit'];
    ValidateAjax("formEditarVehiculo",campos,"botonEditar","{{ route('vehiculos.update',code($vehiculo->id) )}}","POST","/vehiculos");
</script>