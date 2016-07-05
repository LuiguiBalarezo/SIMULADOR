<?php $this->load->view('template/main-panel/main-head', $modulo); ?>
<body class="hold-transition skin-blue sidebar-mini fix-padding-scrollbar">
<div class="wrapper">

    <?php
    $data["modulo"] = $modulo;
    $this->load->view('template/main-panel/header', $data); ?>

    <?php
    $data["menu"]     = $modulo->menu["menu"];
    $data["submenu"]  = $modulo->menu["submenu"];
    $this->load->view('admin/v-admin-menu', $data); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $modulo->titulo; ?>
                <small><a href="<?php echo base_url().$modulo->base_url; ?>">Regresar</a></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active"><a href="<?php echo base_url(); ?>admin/empresa">Tipo de Usuario</a> </li>
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
                            <h3 class="box-title"><?php echo $modulo->nombreSeccion; ?> Tipo de Usuario</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="box-group">
                                <!-- Panel Empresa-->
                                <div class="box-body">
                                        <!-- form start -->
                                        <form id="formEmpresa" role="form"  enctype="multipart/form-data">

                                            <div class="col-md-6">

                                                <?php
                                                if ( isset($modulo->idTipoUsuario) ) { ?>
                                                    <input type="hidden" name="id_tipo_usuario" id="id_tipo_usuario" value="<?php echo $modulo->idTipoUsuario; ?>">
                                                <?php }else{ ?>
                                                    <input type="hidden" name="id_tipo_usuario" id="id_tipo_usuario" >
                                                <?php }?>
                                                <?php
                                                if (isset($existeEmpresa) && !$existeEmpresa ) { ?>
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h4><i class="icon fa fa-ban"></i> No existe el Tipo de Usuario!</h4>
                                                        Lo sentimos el Tipo de Usuario que desea editar no existe.<br>
                                                        <strong>No intente modificar la direccion url</strong>
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtFirstName">Nombre</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $dataEmpresa->nombre_tipo_usuario; ?>" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el nombre.">
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el nombre.">
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                         

                                                </div>



                                            </div>

                                           

                                        </form>

                                    </div>

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
<?php $this->load->view('template/main-panel/modal-admin'); ?>

<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        GenericModal.config("#genericModal", "");

        var formData = new FormData();

        var baseUrl   = "<?php echo $modulo->base_url; ?>";

        var selectorInputsForm = ["#txtNombre"];

        $("#btnAgregar").on("click", function(evt){
            evt.preventDefault();
            var urlApi    = baseUrl + <?php if (isset($modulo->idTipoUsuario)) { echo '"editar";'; } else { echo '"crear";'; } ?>;

            if ( ValidateInputFormWithParsley.validate(selectorInputsForm)) {
                waitingDialog.show('Cargando...');

                formData.append("id_tipo_usuario",       $("#id_tipo_usuario").val());
                formData.append("txtNombre",        $("#txtNombre").val());


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

                        swal("Tipo de Usuario", response.message, "success");

                    } else {
                        swal("Tipo de Usuario", response.message, "error");
                    }

                });

                request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Tipo de Usuario", textStatus, "error");
                    
                });

            }

        });

        



        $("#btnClear").on("click", function(){
            $("#txtNombre").val("");
            $("#txtApellidos").val("");
            $("#txtEmail").val("");
            $("#txtDni").val("");
            $("#txtCelular").val("");
            $("#txtDireccion").val("");
            $("#txtUsuario").val("");
            $("#txtEmail").val("");
            $("#txtPassword").val("");
        });

    });

</script>
</body>
</html>