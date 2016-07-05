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
                            <h3 class="box-title"><?php echo $modulo->nombreSeccion; ?> Operacion</h3>
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
                                                if ( isset($modulo->idOperacion) ) { ?>
                                                    <input type="hidden" name="idOperacion" id="idOperacion" value="<?php echo $modulo->idOperacion; ?>">
                                                <?php }else{ ?>
                                                    <input type="hidden" name="idOperacion" id="idOperacion" >
                                                <?php }?>
                                                <?php
                                                if (isset($existeEmpresa) && !$existeEmpresa ) { ?>
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h4><i class="icon fa fa-ban"></i> No existe la Operacion!</h4>
                                                        Lo sentimos la Operacion que desea editar no existe.<br>
                                                        <strong>No intente modificar la direccion url</strong>
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cboRegion">Region</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>


                                                                <select id="cboRegion" value="<?php echo $dataEmpresa->id_region; ?>"  name="cboRegion"  class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la region.">

                                                                    <?php foreach($modulo->region as $region): ?>
                                                                        <?php if($dataEmpresa->id_region == $region->id_region ){?>
                                                                            <option selected="selected" value="<?php echo $region->id_region;?>"> <?php echo $region->nombre_region; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $region->id_region; ?>"><?php echo $region->nombre_region; ?></option>
                                                                        <?php } ?>

                                                                    <?php endforeach; ?>

                                                                </select>
                                                            <?php } else { ?>
                                                                <select id="cboRegion"  name="cboRegion"  class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la region.">
                                                                    <option value="0" selected="selected">Seleccione</option>
                                                                    <?php foreach($modulo->region as $tipo): ?>
                                                                        <option value="<?php echo $tipo->id_region; ?>"><?php echo $tipo->nombre_region; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtFirstName">Nombre</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $dataEmpresa->nombre_operacion; ?>" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el nombre.">
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

        var selectorInputsForm = ["#txtNombre", "#cboRegion"];

        $("#btnAgregar").on("click", function(evt){

            evt.preventDefault();
            var urlApi    = baseUrl + <?php if (isset($modulo->idOperacion)) { echo '"editar";'; } else { echo '"crear";'; } ?>;

            if ( ValidateInputFormWithParsley.validate(selectorInputsForm)) {
                waitingDialog.show('Cargando...');

                formData.append("id_operacion",       $("#idOperacion").val());
                formData.append("txtNombre",          $("#txtNombre").val());
                formData.append("cboRegion",          $("#cboRegion").val());


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

                        swal("Operación", response.message, "success");

                    } else {
                        swal("Operación", response.message, "error");
                    }

                });

                request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Operación", textStatus, "error");
                    
                });

            }
        });

        



        $("#btnClear").on("click", function(){
            $("#txtNombre").val("");
          
        });

    });

</script>
</body>
</html>