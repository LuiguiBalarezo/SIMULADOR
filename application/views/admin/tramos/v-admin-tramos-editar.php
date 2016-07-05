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
                    <small><a href="<?php echo base_url().$modulo->base_url.$dataEmpresa->id_ruta; ?>">Regresar</a></small>
                <?php }  ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <?php echo $modulo->titulo; ?>
                <?php if (isset($modulo->id) && $modulo->id ) { ?>
                    
                    <li class="active"><a href="<?php echo base_url()."admin/tramos/".$modulo->id; ?>">Tramos</a> </li>    
                <?php }  ?>
                <?php if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                    <li class="active"><a href="<?php echo base_url()."admin/tramos/".$dataEmpresa->id_ruta; ?>">Tramos</a> </li>
                    
                <?php }  ?>
                
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
                                <?php foreach($modulo->rutas as $ruta): ?>
                                    <?php if($modulo->id == $ruta->id_ruta ){?>
                                        <h3 class="box-title">Ruta  <?php echo $ruta->nombre_ruta; ?> - <?php echo $modulo->nombreSeccion; ?> Tramo </h3>
                                    <?php }  ?>
                                <?php endforeach; ?>
                            <?php }  ?>
                            <?php if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                <?php foreach($modulo->rutas as $ruta): ?>
                                    <?php if($dataEmpresa->id_ruta == $ruta->id_ruta ){?>
                                        <h3 class="box-title">Ruta  <?php echo $ruta->nombre_ruta; ?> - <?php echo $modulo->nombreSeccion; ?> Tramo </h3>
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

                                            <div class="col-md-12">

                                                <?php
                                                if ( isset($modulo->idTramo) ) { ?>
                                                    <input type="hidden" name="idTramo" id="idTramo" value="<?php echo $modulo->idTramo; ?>">
                                                <?php }else{ ?>
                                                    <input type="hidden" name="idTramo" id="idTramo" >
                                                <?php }?>
                                                <?php
                                                if (isset($existeEmpresa) && !$existeEmpresa ) { ?>
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h4><i class="icon fa fa-ban"></i> No existe el Tramo!</h4>
                                                        Lo sentimos el Tramo que desea editar no existe.<br>
                                                        <strong>No intente modificar la direccion url</strong>
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="cboRegion">Ruta</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>


                                                                <select id="cboRuta"  value="<?php echo $dataEmpresa->id_ruta; ?>"  name="cboRuta"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el Tramo.">

                                                                    <?php foreach($modulo->rutas as $ruta): ?>
                                                                        <?php if($dataEmpresa->id_ruta == $ruta->id_ruta ){?>
                                                                            <option selected="selected" value="<?php echo $ruta->id_ruta;?>"> <?php echo $ruta->nombre_ruta; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $ruta->id_ruta; ?>"><?php echo $ruta->nombre_ruta; ?></option>
                                                                        <?php } ?>

                                                                    <?php endforeach; ?>

                                                                </select>
                                                            <?php } else { ?>
                                                                <select id="cboRuta" disabled name="cboRuta"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el Tramo.">
                                                                    <?php foreach($modulo->rutas as $ruta): ?>
                                                                        <?php if($modulo->id == $ruta->id_ruta ){?>
                                                                            <option selected="selected" value="<?php echo $ruta->id_ruta;?>"> <?php echo $ruta->nombre_ruta; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $ruta->id_ruta; ?>"><?php echo $ruta->nombre_ruta; ?></option>
                                                                        <?php } ?>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="txtFirstName">Nombre</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $dataEmpresa->nombre_tramo; ?>" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el nombre.">
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el nombre.">
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="txtVelocidad">Velocidad</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>

                                                                <input type="text" class="form-control" id="txtVelocidad" name="txtVelocidad" value="<?php echo $dataEmpresa->velocidad; ?>" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese la Velocidad." data-parsley-type="integer">
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" id="txtVelocidad" name="txtVelocidad" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese la Velocidad." data-parsley-type="integer">
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

        var selectorInputsForm = ["#txtNombre", "#cboRuta" ];

        $("#btnAgregar").on("click", function(evt){

            evt.preventDefault();
            var urlApi    = baseUrl + <?php if (isset($modulo->idTramo)) { echo '"editar";'; } else { echo '"crear";'; } ?>;

            if ( ValidateInputFormWithParsley.validate(selectorInputsForm)) {
                waitingDialog.show('Cargando...');

                formData.append("id_tramo",           $("#idTramo").val());
                formData.append("txtNombre",          $("#txtNombre").val());
                formData.append("id_ruta",            $("#cboRuta").val());
                formData.append("txtVelocidad",       $("#txtVelocidad").val());


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

                        swal("Tramo", response.message, "success");

                    } else {
                        swal("Tramo", response.message, "error");
                    }

                });

                request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Tramo", textStatus, "error");
                    
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