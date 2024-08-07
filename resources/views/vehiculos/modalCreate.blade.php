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
<link href="{{asset('/plugins/fileinput/css/fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css" />
{!! Form::open( array('route' =>'vehiculos.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCrearVehiculo', 'onsubmit'=>'botonGuardar.disabled = true; return true;'))!!}
<div class="row">
    {!! datosRegistro('create') !!}

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="col-form-label" id="nombre--label">* Nombre del vehiculo</label> <br>
            <input class="form-control" name="nombre" type="text" placeholder="Nombre del vehiculo">
            <span id="nombre-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="col-form-label" id="matricula--label">* Matrícula</label> <br>
            <input class="form-control" name="matricula" type="text" placeholder="Número de matrícula">
            <span id="matricula-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <div class="" id="regional-sel2">
            <label id="regional--label">* Regional</label>
            <select name="regional" class="form-control form-select selector-modal" style="width: 100%">
                <option value="">Seleccione una opción</option>
                @foreach ($regionales as $regional)
                    <option value="{{ $regional->id }}" data-departamento="{{ $regional->nameCiudad() }}" data-extra= {{ $regional->departamento }}>{{ $regional->nombre_regional }}</option>
                @endforeach
            </select>
            <span id="regional-error" class="text-red"></span>
        </div>
        <div class="divInfoDepartamento" style="display:none"></div>
    </div>

    <input class="form-control" name="departamentoId" id="departamentoInput"  type="text" hidden>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3" id="fileVehiculos--label">
        <b><i>(Opcional)</i> Imagen o fotografía del vehículo </b><br>
        <div style="padding-left: 25px;" class="mb-2">
            <b><i class="fa fa-arrow-circle-right"></i> &nbsp;Extensiones soportadas:</b>&nbsp;&nbsp;.jpg, .jpeg, .png<br>
            <b><i class="fa fa-arrow-circle-right"></i> &nbsp;Tamaño máximo: </b>2 MB (2048 KB)<br>
        </div>
        <div id="fileVehiculos_fg" class="form-group" style="margin:0; padding:0" >
            <input type="file" class="input-sm classfileVehiculos" id="fileVehiculos" name="fileVehiculos" data-max-size="2048" data-browse-on-zone-click="true" accept=".jpg, .jpeg, .png, .mp4">
            <span id="fileVehiculos-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primarydark pull-right" name="botonGuardar">Registrar</button>
    </div>
</div>
{{Form::Close()}}

<script src="{{asset('/plugins/fileinput/js/fileinput.min.js')}}"></script>
<script>

    $(document).ready(function () {
        $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
        $(".select2-selection--single").addClass('form-selectcont');

        $(".classfileVehiculos").fileinput({
            showUpload: false,
            allowedFileExtensions: ["jpg","jpeg","png"],
            maxFileSize: 2048,
            maxFilePreviewSize: 2048,
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
        $('#fileVehiculos_fg .file-caption').click(function(){
            $('#fileVehiculos').trigger('click');
        });
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

    $('select.selector-modal:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatState,
        });
    });

    $('.selector-modal').change(function () {
        var data = $('.selector-modal').select2('data')[0];
        var departamento = $(data.element).data('departamento');
        var departamentoId = $(data.element).data('extra');
        var info;
        if (typeof departamento === 'undefined') {
            info = '';
            $('#departamentoInput').val('');
            $(".divInfoDepartamento").hide();
            $(".divInfoDepartamento").removeClass('mb-2');
        }else{
            info = '<i style="font-size:11px"><b style="font-size:11px">Departamento: </b>'+departamento+'</i>';
            $(".divInfoDepartamento").show();
            $(".divInfoDepartamento").addClass('mb-2');
            $('#departamentoInput').val(departamentoId);
        }
        $(".divInfoDepartamento").html(info);
    });

    var campos = ['nombre','matricula','regional','fileVehiculos'];
    ValidateAjax("formCrearVehiculo",campos,"botonGuardar","{{route('vehiculos.store')}}","POST","/vehiculos");
</script>