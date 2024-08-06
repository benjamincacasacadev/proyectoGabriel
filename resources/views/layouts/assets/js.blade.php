<script src="{{asset('/templates/coolAdmin/libsCool/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/bootstrap-4.1/popper.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/bootstrap-4.1/bootstrap.min.js')}}"></script>

<script src="{{asset('/templates/coolAdmin/libsCool/slick/slick.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/wow/wow.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/counter-up/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/counter-up/jquery.counterup.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/circle-progress/circle-progress.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/chartjs/Chart.bundle.min.js')}}"></script>
<script src="{{asset('/templates/coolAdmin/libsCool/select2/select2.min.js')}}"></script>

<script src="{{asset('/templates/coolAdmin/js/main.js')}}"></script>

<script src="{{asset('/plugins/autonumeric/autoNumeric.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/jquery.mark.min.js')}}"></script>
<script src="{{asset('/plugins/datatables.net-bs/js/datatables.mark.js')}}"></script>
<script src="{{asset('/plugins/datatables.net/js/dataTables.fixedColumns.min.js')}}"></script>
<script src="{{asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('/dist/js/datetimepicker.js')}}"></script>
<script src="{{asset('/plugins/toastr.min.js')}}"></script>

{{-- <script src="{{asset('/plugins/flasher.min.js')}}"></script> --}}

    <script>
        window.onload = function () {
            var contenedor = document.getElementById('contenedor_carga');
            contenedor.style.visibility = 'hidden';
            contenedor.style.opacity = '0';
        }
    </script>
    <script>
        $(document).ready(function () {
            $(".fl-main-container").removeAttr('data-position');
            $(".fl-main-container").attr('data-position','bottom-right');
            $('select').addClass('form-select').css('font-size','12px');
            $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
            $(".select2-selection--single").addClass('form-selectcont');
            if ($(window).width() <= 450) $('.contenidoprinc_content').removeClass('content')
            else    $('.contenidoprinc_content').addClass('content')
            if ($(window).width() <= 450) $('.contenidoprinc_lg').removeClass('container-lg')
            else    $('.contenidoprinc_lg').addClass('container-lg')
            $(window).resize(function() {
                if ($(window).width() <= 450) $('.contenidoprinc_content').removeClass('content')
                else    $('.contenidoprinc_content').addClass('content')
                if ($(window).width() <= 450) $('.contenidoprinc_lg').removeClass('container-lg')
                else    $('.contenidoprinc_lg').addClass('container-lg')
            });
            $("#startab").delay(1000).fadeIn();

            $('.datepicker').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
            });
        });


        // ===========================================================================================
        //                            MODAL AJAX
        // ===========================================================================================
        function modalAjax(relmodal,idmodal,containermodal,hrefReload){
            $(document).on('click','a[rel='+relmodal+']',function(evt) {
                evt.preventDefault();
                var modal = $('#'+idmodal).modal();
                var modalurl = $(this).attr('href');
                modal.find('.'+containermodal).load(modalurl, function (responseText, textStatus) {
                    if ( textStatus === 'success' || textStatus === 'notmodified'){
                        modal.show();
                    }
                    if(textStatus == 'error'){
                        alert('No puede realizar la acción solicitada. La página se recargará en un momento');
                        setTimeout(function () {
                            if (hrefReload === undefined || hrefReload === null)    location.reload(true);
                            else window.location.href = hrefReload;
                        }, 500);
                    }
                });
            });
        }

        // ===========================================================================================
        //                                  FUNCIONES PARA DATATABLE
        // ===========================================================================================
        // Mostrar ayuda para mostrar u ocultar columnas
        function ayudaDT(){
            var ayuda = '&nbsp;<span class="form-help" data-toggle="popover" data-content="<p style=\'font-size:10.5px; text-align:justify\'>Puede hacer clic en el botón de la izquierda y se desplegará un menú con todas las columnas de esta tabla.<br>Si la columna de la tabla está siendo mostrada el nombre de la columna se visualizará de esta forma <button class=\'ejbutton dt-button buttons-columnVisibility active\' style=\'font-size:10px\'>Columna</button> y si la columna esta oculta se visualizará de la siguiente forma <button class=\'ejbutton dt-button buttons-columnVisibility\' style=\'font-size:10px\'>Columna</button> </p>" data-title="<span style=\'font-size=10px; font-weight:bold\'>Información</span>">'+
                            '?'+
                        '</span>';
            return ayuda;
        }
        // Mostrar mensaje de espera mientras cargan datos
        function espereDT(){
            var espere = '<div class="espereDT font-weight-bold text-primary mb-2" style="font-size:15px">'+
                            '<i class="far fa-clock"></i>&nbsp;'+
                            'Espere un momento...'+
                        '</div>';
            return espere;
        }

        // funcion para evitar realizar peticiones por cada letra que se escriba al filtrar
        // bloqueo de acciones al cambiar de pagina y de tamaño de tabla
        function filterInputDT(table){
            var dtTimer;
            table.columns().eq(0).each(function (colIdx) {
                $('input', $('.filters td')[colIdx]).on('keyup', function () {
                    clearTimeout(dtTimer);
                    var searchField = this.value;
                    dtTimer = setTimeout(function(){
                        table.column(colIdx).search(searchField).draw();
                    }, 1000);
                });

                $('select', $('.filters td')[colIdx]).on('change', function () {
                    clearTimeout(dtTimer);
                    var searchField = this.value;
                    console.log(this.value);
                    dtTimer = setTimeout(function(){
                        table.column(colIdx).search(searchField).draw();
                    }, 1000);
                });
            });

            // BLOQUEAR PAGINADO
            table.on( 'page.dt', function () {
                $(".dataTables_paginate").children().hide();
                $(".dataTables_paginate").append(espereDT());
            });
            // BLOQUEAR TAMAÑO
            table.on( 'length.dt', function ( ) {
                $(".dataTables_length").children().hide();
                $(".dataTables_length").append(espereDT());
            });
        }

        // Mostrar todos las acciones que pertenecen al datatable, se usa en drawcallback
        function restartActionsDT(){
            $(".espereDT").remove();
            $(".dataTables_length").children().show();
            $(".dataTables_paginate").children().show();
        }
    </script>

    {{-- ===========================================================================================
                                                VALIDACION
    =========================================================================================== --}}
    <script>
        function ValidateAjax(idform,fields,buttonname,routeform,methodform,urlback){
            $("#"+idform+"").on('submit', function(e) {
                e.preventDefault();
                $("#"+idform+" .divWaitingMessage").slideDown();
                var registerForm = $("#"+idform+"");
                var formData = new FormData($("#"+idform+"")[0]);
                // var formData = registerForm.serialize();
                $.each(fields, function( indice, valor ) {
                    valor = valor.replace('.','___');
                    $("#"+valor+"-error").html( "" );
                    var inputtype = $("[name="+valor+"]").attr("type");
                    if(inputtype != 'radio')    $("[name="+valor+"]").removeClass('is-invalid').addClass('is-valid');
                    $("select[name="+valor+"]").removeClass('is-invalid-select').addClass('is-valid-select').removeClass('select2-selection');
                    $("#"+idform+" #"+valor+"-sel2 .select2-selection").removeClass('is-invalid-select').addClass('is-valid-select');
                    $("#"+idform+" #"+valor+"-sel2 .select2-selection").css('border','1px solid #5eba00');
                });
                $.ajax({
                    url: routeform,
                    type: methodform,
                    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                    data:formData,
                    contentType: false,
                    processData: false,

                    success:function(data) {
                        $("#"+idform+" .divWaitingMessage").hide();
                        if(data.alerta) {
                            toastr.error(data.mensaje, 'Algo salió mal');
                            $("[name="+buttonname+"]").attr('disabled',false)
                        }else if(data.success) {
                            if(data.urlReload){
                                window.location.href = data.urlReload;
                            }else{
                                if (urlback === undefined || urlback === null){
                                    location.reload(true);
                                }else{
                                    window.location.href = urlback;
                                }
                            }
                            $("[name="+buttonname+"]").attr('disabled',true)
                        } else if(typeof(data.status) == "undefined"){
                            // window.location.reload();
                        }
                    },
                    error: function(data){
                        $("#"+idform+" .divWaitingMessage").hide();
                        if(data.responseJSON.errors) {
                            var msjmail = ""; var sw_mail = 0;
                            $.each(data.responseJSON.errors, function( index, value ) {
                                index = index.replace('.','___');
                                $('#'+index+'-error' ).html( '&nbsp;<i class="fa fa-ban"></i> '+value );
                                $('#'+index+'').addClass('has-error');
                                var inputtype = $("[name="+index+"]").attr("type");
                                if(inputtype != 'radio')    $("[name="+index+"]").removeClass('is-valid').addClass('is-invalid');
                                $("select[name="+index+"]").removeClass('is-valid-select').addClass('is-invalid-select').removeClass('select2-selection');
                                $("#"+idform+" #"+index+"-sel2 .select2-selection").removeClass('is-valid-select').addClass('is-invalid-select');
                                $("#"+idform+" #"+index+"-sel2 .select2-selection").css('border','1px solid #cd201f');
                            });
                            var indexaux = []; var camposaux =[]; var i=0;
                            $.each(fields, function( indice, valor ) {
                                if(data.responseJSON.errors[valor]){
                                    indexaux[i] = indice;  i++;
                                }
                                var j = indice;
                                camposaux[j] = valor;
                            });
                            var menor = Math.min.apply(null, indexaux);
                            $('#'+camposaux[menor]+'--label')[0].scrollIntoView({behavior: 'smooth'});
                        }
                        setTimeout(function(){
                            $("[name="+buttonname+"]").attr('disabled',false);
                        }, 500)
                        if(typeof(data.status) != "undefined" && data.status != null && data.status == '401'){
                            // window.location.reload();
                        }
                    }
                });
            });
        }

    </script>

