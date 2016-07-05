<?php $this->load->view('template/main-panel/main-head', $modulo); ?>
<body class="hold-transition skin-blue sidebar-mini fix-padding-scrollbar">
<div class="wrapper">

    <?php
    $data["modulo"] = $modulo;
    $this->load->view('template/main-panel/header', $data); ?>

    <?php
    $data["menu"]     = $modulo->menu["menu"];
    $data["submenu"]  = $modulo->menu["submenu"];
    $this->load->view('admin/v-admin-menu2', $data); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $modulo->titulo; ?>
                <small><a href="<?php echo base_url().$modulo->base_url; ?>">Regresar</a></small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><a href="<?php echo base_url(); ?>admin/eventoriesgo">Evento de Riesgo</a> </li>
                <li><?php echo strtolower($modulo->nombreSeccion); ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $modulo->nombreSeccion; ?> Evento de Riesgo</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="box-group">
                                <!-- Panel Empresa-->

                                <div class="box-body">
                                        <!-- form start -->
                                        <form id="formEmpresa" role="form"  enctype="multipart/form-data">

                                            <div class="col-md-4">


                                                <?php
                                                if (isset($existeEmpresa) && !$existeEmpresa ) { ?>
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h4><i class="icon fa fa-ban"></i> No existe el Evento!</h4>
                                                        Lo sentimos el Evento que desea editar no existe.<br>
                                                        <strong>No intente modificar la direccion url</strong>
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cboOperacion">Operacion</label>
                                                            <select id="cboOperacion" name="cboOperacion"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la Operacion.">
                                                                <option value="" selected="selected">Seleccione Operacion</option>
                                                                <?php foreach($modulo->operacion as $operacion): ?>
                                                                    <option value="<?php echo $operacion->id_operacion; ?>"><?php echo $operacion->nombre_operacion; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cboRuta">Ruta</label>
                                                            <select id="cboRuta"  name="cboRuta"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la Ruta.">
                                                                <option value="" selected="selected">Seleccione Ruta</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cboTramo">Tramo</label>
                                                            <select id="cboTramo"  name="cboTramo"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione un Tramo.">
                                                                <option value="" selected="selected">Seleccione Tramo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cboEvento">Evento</label>

                                                            <select id="cboEvento" name="cboEvento"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione un Evento.">
                                                                <option value="" selected="selected">Seleccione Evento</option>
                                                                <?php foreach($modulo->evento as $evento): ?>
                                                                    <option value="<?php echo $evento->id_evento; ?>"><?php echo $evento->nombre_evento; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cboCategoria">Categoria</label>

                                                            <select id="cboCategoria" name="cboCategoria"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione una Categoria.">
                                                                <option value="" selected="selected">Seleccione una Categoria</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cboTipo">Tipo</label>

                                                            <select id="cboTipo" name="cboTipo"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione un Tipo.">
                                                                <option value="" selected="selected">Seleccione un Tipo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cboPlaca">Numero de Placa</label>

                                                            <select id="cboPlaca" name="cboPlaca"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione una Placa.">
                                                                <option value="" selected="selected">Seleccione Placa</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtFecha">Fecha</label>
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input data-format="YYYY-MM-DD HH:mm:ss" type="text" class="form-control pull-right" id="txtFecha" name="txtFecha"  data-parsley-required data-parsley-required-message="Ingrese una Fecha." data-parsley-type-message="Ingrese una Fecha.">

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtDescripcion">Descripcion</label>
                                                            <textarea class="form-control" id="txtDescripcion" placeholder="Descripcion" name="txtDescripcion" maxlength="500" data-parsley-required data-parsley-required-message="Ingrese una Descripcion." data-parsley-type-message="Ingrese una Descripcion." rows="4"></textarea>
                                                        </div>
                                                    </div>

                                            </div>

                                           

                                        </form>

                                    </div>

                        </div><!-- /.box-body -->
                        <div class="box-footer" style="text-align: center">
                            <button id="btnAgregar" type="submit" class="btn btn-primary"><?php echo $modulo->nombreSeccion; ?></button>
                            <button id="btnClear" type="reset" class="btn btn-primary">Limpiar</button>

                        </div>

                    </div><!-- /.box -->

                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

    <?php $this->load->view('template/main-panel/footer'); ?>

</div><!-- ./wrapper -->
<?php $this->load->view('template/main-panel/scripts-footer'); ?>
<!-- DatePicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<?php $this->load->view('template/main-panel/modal-admin'); ?>

<script>

    $(function () {
        var base_url = "<?php echo base_url(); ?>";


        //Initialize Select2 Elements
        $(".select2").select2();

        //Date picker
        $('#txtFecha').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        GenericModal.config("#genericModal", "");


        var formData = new FormData();

        var baseUrl   = "<?php echo $modulo->base_url; ?>";

        var selectorInputsForm = ["#cboOperacion", "#cboRuta", "#cboTramo", "#cboEvento", "#cboCategoria",
                                    "#cboPlaca", "#txtFecha", "#txtDescripcion" ];

        $("#btnAgregar").on("click", function(evt){
            evt.preventDefault();
//            console.log($("#cboOperacion").val());
//            console.log($("#cboRuta").val());
//            console.log($("#cboTramo").val());
//            console.log($("#cboEvento").val());
//            console.log($("#cboCategoria").val());
//            console.log($("#cboTipo").val());
//            console.log($("#cboPlaca").val());
//            console.log($("#txtFecha").val());
//            console.log($("#txtDescripcion").val());


            var urlApi    = baseUrl +"crear";

            if ( ValidateInputFormWithParsley.validate(selectorInputsForm)) {

                waitingDialog.show('Cargando...');

                formData.append("cboTramo",         $("#cboTramo").val());
                formData.append("cboEvento",        $("#cboEvento").val());
                formData.append("cboCategoria",     $("#cboCategoria").val());
                formData.append("cboTipo",          $("#cboTipo").val());
                formData.append("cboPlaca",         $("#cboPlaca").val());
                formData.append("txtFecha",         $("#txtFecha").val());
                formData.append("txtDescripcion",   $("#txtDescripcion").val());

                var request = $.ajax({
                    url: urlApi,
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false
                });
                request.done(function( response ) {
                    waitingDialog.hide();
                    formData = new FormData();
                    if (response.status) {
                        swal("Evento de Riesgo", response.message, "success");
                    } else {
                        swal("Evento de Riesgo", response.message, "error");
                    }
                });

                request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Evento de Riesgo", textStatus, "error");
                    
                });

            }

        });


        $( "#cboOperacion" ).change(function() {
            //LLENAR RUTAS
            formData.append("id_operacion",       $(this).val());
            var request = $.ajax({
                url: base_url + "getRutas",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false
            });

            request.done(function( response ) {
                if (response.status) {
                    $("#cboRuta").empty();
                    $("#cboRuta").append("<option value='' selected='selected'>Seleccione Ruta</option>");
                    for (var i = 0; i < response.data.length; i++) {
                        $("#cboRuta").append("<option value='" + response.data[i].id_ruta + "'>" + response.data[i].nombre_ruta + "</option>");
                    }
                } else {
                    swal("Rutas", response.message, "error");
                }

            });

            request.fail(function( jqXHR, textStatus ) {
                waitingDialog.hide();
                swal("Rutas", textStatus, "error");

            });
            //LLENAR PLACAS
            var request0 = $.ajax({
                url: base_url + "getPlacas",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false
            });

            request0.done(function( response ) {
                if (response.status) {
                    $("#cboPlaca").empty();
                    $("#cboPlaca").append("<option value='' selected='selected'>Seleccione Placa</option>");
                    for (var i = 0; i < response.data.length; i++) {
                        $("#cboPlaca").append("<option value='" + response.data[i].id_placa + "'>" + response.data[i].placa + "</option>");
                    }
                } else {
                    swal("Placa", response.message, "error");
                }

            });

            request0.fail(function( jqXHR, textStatus ) {
                waitingDialog.hide();
                swal("Placa", textStatus, "error");

            });
        });

        $( "#cboRuta" ).change(function() {
            //LLENAR TRAMOS
            formData.append("id_ruta",       $(this).val());
            var request = $.ajax({
                url: base_url + "getTramos",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false
            });

            request.done(function( response ) {
                if (response.status) {
                    $("#cboTramo").empty();
                    $("#cboTramo").append("<option value='' selected='selected'>Seleccione Tramo</option>");
                    for (var i = 0; i < response.data.length; i++) {
                        $("#cboTramo").append("<option value='" + response.data[i].id_tramo + "'>" + response.data[i].nombre_tramo + "</option>");
                    }
                } else {
                    swal("Tramo", response.message, "error");
                }

            });

            request.fail(function( jqXHR, textStatus ) {
                waitingDialog.hide();
                swal("Tramo", textStatus, "error");

            });
           
        });

        $( "#cboEvento" ).change(function() {
            //LLENAR CATEGORIA
            formData.append("id_evento",       $(this).val());
            var request = $.ajax({
                url: base_url + "getCategorias",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false
            });

            request.done(function( response ) {
                if (response.status) {
                    $("#cboCategoria").empty();
                    $("#cboCategoria").append("<option value='' selected='selected'>Seleccione Categoria</option>");
                    for (var i = 0; i < response.data.length; i++) {
                        $("#cboCategoria").append("<option value='" + response.data[i].id_categoria + "'>" + response.data[i].nombre_categoria + "</option>");
                    }
                } else {
                    swal("Tramo", response.message, "error");
                }

            });

            request.fail(function( jqXHR, textStatus ) {
                waitingDialog.hide();
                swal("Tramo", textStatus, "error");

            });

        });

        $( "#cboCategoria" ).change(function() {
            var idEvento = $("#cboEvento").val();
            if(idEvento == 3 || idEvento == 4){
                $("#cboTipo").empty();
                $("#cboTipo").append("<option value='' selected='selected'>TIPOS NO DISPONIBLES</option>");
            }else{
                //LLENAR TIPO
                formData.append("id_categoria",       $(this).val());
                var request = $.ajax({
                    url: base_url + "getTipos",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false
                });

                request.done(function( response ) {
                    if (response.status) {
                        $("#cboTipo").empty();
                        $("#cboTipo").append("<option value='' selected='selected'>Seleccione Tipo</option>");
                        for (var i = 0; i < response.data.length; i++) {
                            $("#cboTipo").append("<option value='" + response.data[i].id_tipo + "'>" + response.data[i].nombre_tipo + "</option>");
                        }
                    } else {
                        swal("Tipo", response.message, "error");
                    }

                });

                request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Tipo", textStatus, "error");

                });
            }


        });

        $("#btnClear").on("click", function(){
            $("#txtFecha").val("");
            $("#txtDescripcion").val("");

        });

    });

</script>
</body>
</html>