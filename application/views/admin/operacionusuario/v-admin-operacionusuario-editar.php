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
<!--                --><?php //if (isset($existeEmpresa) && $existeEmpresa ) { ?>
<!--                    <small><a href="--><?php //echo base_url().$modulo->base_url.$dataEmpresa->id_operacion; ?><!--">Regresar</a></small>-->
<!--                    -->
<!--                --><?php //}  ?>
                
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active"><a href="<?php echo base_url(); ?>admin/empresa"> Operacion por Usuario</a> </li>
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
                                <?php foreach($modulo->usuario as $usuario): ?>
                                    <?php if($modulo->id == $usuario->id_usuario ){?>
                                        <h3 class="box-title">Usuario  <?php echo $usuario->nombre. " ".$usuario->apellidos; ?>  - <?php echo $modulo->nombreSeccion; ?> Operacion </h3>
                                    <?php }  ?>
                                <?php endforeach; ?>
                            <?php }  ?>
<!--                            --><?php //if (isset($existeEmpresa) && $existeEmpresa ) { ?>
<!--                                --><?php //foreach($modulo->usuario as $usuario): ?>
<!--                                    --><?php //if($dataEmpresa->id_usuario == $usuario->id_usuario ){?>
<!--                                        <h3 class="box-title">Operacion  --><?php //echo $operacion->nombre_operacion; ?><!-- - --><?php //echo $modulo->nombreSeccion; ?><!-- Ruta </h3>-->
<!--                                    --><?php //} ?>
<!---->
<!--                                --><?php //endforeach; ?>
<!--                            --><?php //}  ?>
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
                                                if ( isset($modulo->idUsuario) ) { ?>
                                                    <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $modulo->idUsuario; ?>">
                                                <?php }else{ ?>
                                                    <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $modulo->id; ?>" >
                                                <?php }?>
                                                <?php
                                                if (isset($existeEmpresa) && !$existeEmpresa ) { ?>
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h4><i class="icon fa fa-ban"></i> No existe el Usuario!</h4>
                                                        Lo sentimos el Usuario que desea editar no existe.<br>
                                                        <strong>No intente modificar la direccion url</strong>
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cboOperacion">Operacion</label>
<!--                                                            --><?php //if (isset($existeEmpresa) && $existeEmpresa ) { ?>
<!--                                                                <select id="cboOperacion" value="--><?php //echo $dataEmpresa->id_operacion; ?><!--" name="cboOperacion"  class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la Operacion.">-->
<!--                                                                    --><?php //foreach($modulo->operacion as $operacion): ?>
<!--                                                                        --><?php //if($dataEmpresa->id_operacion == $operacion->id_operacion ){?>
<!--                                                                            <option selected="selected" value="--><?php //echo $operacion->id_operacion;?><!--"> --><?php //echo $operacion->nombre_operacion; ?><!--</option>-->
<!--                                                                        --><?php //} else { ?>
<!--                                                                            <option value="--><?php //echo $operacion->id_operacion; ?><!--">--><?php //echo $operacion->nombre_operacion; ?><!--</option>-->
<!--                                                                        --><?php //} ?>
<!---->
<!--                                                                    --><?php //endforeach; ?>
<!---->
<!--                                                                </select>-->
<!--                                                            --><?php //} else { ?>
                                                                
                                                                <select id="cboOperacion" name="cboOperacion"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el Operacion.">
                                                                    <option value="" selected="selected">Seleccione</option>
                                                                    <?php foreach($modulo->region as $region): ?>
                                                                        <option disabled value="<?php echo $region->id_region; ?>"><?php echo $region->nombre_region; ?></option>
                                                                    <?php

                                                                    foreach ($modulo->operacion as $value1) {
                                                                        $encontrado=false;
                                                                        foreach ($modulo->operacionuser as $value2) {
                                                                            if ($value1->id_operacion == $value2->id_operacion){
                                                                                $encontrado=true;
                                                                                $break;
                                                                            }
                                                                        }
                                                                        if($region->id_region == $value1->id_region ){
                                                                            if ($encontrado == false){ ?>
                                                                                <option value="<?php echo  $value1->id_operacion; ?>">&nbsp; &nbsp; <?php echo $value1->nombre_operacion; ?></option>
                                                                            <?php }

                                                                         }
                                                                    }
                                                                    ?>
                                                                    <?php endforeach; ?>






                                                                </select>



<!--                                                            --><?php //} ?>

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

        var selectorInputsForm = ["#cboOperacion"];

        $("#btnAgregar").on("click", function(evt){

            evt.preventDefault();
            var urlApi    = baseUrl + <?php if (isset($modulo->idUsuario)) { echo '"editar";'; } else { echo '"crear";'; } ?>;

            if ( ValidateInputFormWithParsley.validate(selectorInputsForm)) {
                waitingDialog.show('Cargando...');

                formData.append("id_usuario",               $("#idUsuario").val());
                formData.append("id_operacion",          $("#cboOperacion").val());


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

                        swal("Operacion por Usuario", response.message, "success");

                    } else {
                        swal("Operacion por Usuario", response.message, "error");
                    }

                });

                request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Operacion por Usuario", textStatus, "error");
                    
                });

            }
        });

        
        

    });

</script>
</body>
</html>