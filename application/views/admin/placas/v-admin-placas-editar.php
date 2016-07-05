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
                <?php if (isset($modulo->id) && $modulo->id ) { ?>
                    <small><a href="<?php echo base_url().$modulo->base_url.$modulo->id; ?>">Regresar</a></small>

                <?php }  ?>
                <?php if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                    <small><a href="<?php echo base_url().$modulo->base_url.$dataEmpresa->id_operacion; ?>">Regresar</a></small>

                <?php }  ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active"><a href="<?php echo base_url(); ?>admin/empresa">Placas</a> </li>
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
                            <?php if (isset($modulo->id) && $modulo->id ) { ?>
                                <?php foreach($modulo->operacion as $operacion): ?>
                                    <?php if($modulo->id == $operacion->id_operacion ){?>
                                        <h3 class="box-title">Operacion  <?php echo $operacion->nombre_operacion; ?> - <?php echo $modulo->nombreSeccion; ?> Placa  </h3>
                                    <?php }  ?>
                                <?php endforeach; ?>
                            <?php }  ?>
                            <?php if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                <?php foreach($modulo->operacion as $operacion): ?>
                                    <?php if($dataEmpresa->id_operacion == $operacion->id_operacion ){?>
                                        <h3 class="box-title">Operacion  <?php echo $operacion->nombre_operacion; ?> - <?php echo $modulo->nombreSeccion; ?> Placa </h3>
                                    <?php } ?>

                                <?php endforeach; ?>
                            <?php }  ?>
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
                                                if ( isset($modulo->idPlaca) ) { ?>
                                                    <input type="hidden" name="idPlaca" id="idPlaca" value="<?php echo $modulo->idPlaca; ?>">
                                                <?php }else{ ?>
                                                    <input type="hidden" name="idPlaca" id="idPlaca" >
                                                <?php }?>
                                                <?php
                                                if (isset($existeEmpresa) && !$existeEmpresa ) { ?>
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h4><i class="icon fa fa-ban"></i> No existe la Placa!</h4>
                                                        Lo sentimos la Placa que desea editar no existe.<br>
                                                        <strong>No intente modificar la direccion url</strong>
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cboRegion">Operacion</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                <select id="cboOperacion" value="<?php echo $dataEmpresa->id_operacion; ?>" name="cboOperacion"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la Operacion.">
                                                                    <?php foreach($modulo->operacion as $operacion): ?>
                                                                        <?php if($dataEmpresa->id_operacion == $operacion->id_operacion ){?>
                                                                            <option selected="selected" value="<?php echo $operacion->id_operacion;?>"> <?php echo $operacion->nombre_operacion; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $operacion->id_operacion; ?>"><?php echo $operacion->nombre_operacion; ?></option>
                                                                        <?php } ?>

                                                                    <?php endforeach; ?>

                                                                </select>
                                                            <?php } else { ?>
                                                                <?php if (isset($modulo->id) && $modulo->id ) { ?>
                                                                    <select id="cboOperacion" disabled name="cboOperacion"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la Operacion.">

                                                                        <?php foreach($modulo->operacion as $operacion): ?>
                                                                            <?php if($modulo->id == $operacion->id_operacion ){?>
                                                                                <option selected="selected" value="<?php echo $operacion->id_operacion;?>"> <?php echo $operacion->nombre_operacion; ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?php echo $operacion->id_operacion; ?>"><?php echo $operacion->nombre_operacion; ?></option>
                                                                            <?php } ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                <?php }  ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtFirstName">Placa</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $dataEmpresa->placa; ?>" maxlength="7" data-parsley-required data-parsley-required-message="Ingrese la Placa.">
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" maxlength="7" data-parsley-required data-parsley-required-message="Ingrese la Placa.">
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

        var selectorInputsForm = ["#txtNombre", "#cboOperacion"];

        $("#btnAgregar").on("click", function(evt){

            evt.preventDefault();
            var urlApi    = baseUrl + <?php if (isset($modulo->idPlaca)) { echo '"editar";'; } else { echo '"crear";'; } ?>;

            if ( ValidateInputFormWithParsley.validate(selectorInputsForm)) {
                waitingDialog.show('Cargando...');

                formData.append("id_placa",             $("#idPlaca").val());
                formData.append("txtNombre",            $("#txtNombre").val());
                formData.append("id_operacion",         $("#cboOperacion").val());


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

                        swal("Placa", response.message, "success");

                    } else {
                        swal("Placa", response.message, "error");
                    }

                });

                request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Placa", textStatus, "error");
                    
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