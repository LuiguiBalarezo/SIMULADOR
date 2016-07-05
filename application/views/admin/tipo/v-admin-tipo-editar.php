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
                    <input id="idCategoria" type="hidden"  value="<?php echo $modulo->id; ?>">
                <?php }  ?>
                <?php if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                    <small><a href="<?php echo base_url().$modulo->base_url.$dataEmpresa->id_categoria; ?>">Regresar</a></small>
                    <input id="idCategoria" type="hidden" value="<?php echo $dataEmpresa->id_categoria; ?>">
                <?php }  ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <?php if (isset($modulo->id) && $modulo->id ) { ?>

                    <li class="active"><a href="<?php echo base_url()."admin/tipo/".$modulo->id; ?>">Tipos</a> </li>
                <?php }  ?>
                <?php if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                    <li class="active"><a href="<?php echo base_url()."admin/tipo/".$dataEmpresa->id_categoria; ?>">Tipos</a> </li>

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
                                <?php foreach($modulo->categoria as $categoria): ?>
                                    <?php if($modulo->id == $categoria->id_categoria ){?>
                                        <h3 class="box-title">Categoria  <?php echo $categoria->nombre_categoria; ?> - <?php echo $modulo->nombreSeccion; ?> Tipo </h3>
                                    <?php }  ?>
                                <?php endforeach; ?>
                            <?php }  ?>
                            <?php if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                <?php foreach($modulo->categoria as $categoria): ?>
                                    <?php if($dataEmpresa->id_categoria == $categoria->id_categoria ){?>
                                        <h3 class="box-title">Categoria  <?php echo $categoria->nombre_categoria; ?> - <?php echo $modulo->nombreSeccion; ?> Tipo </h3>
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
                                                if ( isset($modulo->idTipo) ) { ?>
                                                    <input type="hidden" name="idTipo" id="idTipo" value="<?php echo $modulo->idTipo; ?>">
                                                <?php }else{ ?>
                                                    <input type="hidden" name="idTipo" id="idTipo" >
                                                <?php }?>
                                                <?php
                                                if (isset($existeEmpresa) && !$existeEmpresa ) { ?>
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h4><i class="icon fa fa-ban"></i> No existe el Tipo!</h4>
                                                        Lo sentimos el Tipo que desea editar no existe.<br>
                                                        <strong>No intente modificar la direccion url</strong>
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="cboCategoria">Categoria</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>


                                                                <select id="cboCategoria"  value="<?php echo $dataEmpresa->id_categoria; ?>"  name="cboCategoria"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el Tramo.">

                                                                    <?php foreach($modulo->categoria as $categoria): ?>
                                                                        <?php if($dataEmpresa->id_categoria == $ruta->id_categoria ){?>
                                                                            <option selected="selected" value="<?php echo $categoria->id_categoria;?>"> <?php echo $categoria->nombre_categoria; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $categoria->id_categoria; ?>"><?php echo $categoria->nombre_categoria; ?></option>
                                                                        <?php } ?>

                                                                    <?php endforeach; ?>

                                                                </select>
                                                            <?php } else { ?>
                                                                <select id="cboCategoria" disabled name="cboCategoria"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el Tramo.">
                                                                    <?php foreach($modulo->categoria as $categoria): ?>
                                                                        <?php if($modulo->id == $categoria->id_categoria ){?>
                                                                            <option selected="selected" value="<?php echo $categoria->id_categoria;?>"> <?php echo $categoria->nombre_categoria; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $categoria->id_categoria; ?>"><?php echo $categoria->nombre_categoria; ?></option>
                                                                        <?php } ?>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="txtPassword">Codigo</label>

                                                            <div class="input-group">
                                                                <?php
                                                                if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                    <input type="text" value="<?php echo $dataEmpresa->codigo_tipo; ?>" class="form-control" id="txtCodigo" name="txtCodigo" maxlength="6" data-parsley-required data-parsley-required-message="Ingrese un Codigo.">
                                                                <?php } else { ?>
                                                                    <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" maxlength="6" data-parsley-required data-parsley-required-message="Ingrese un Codigo.">
                                                                <?php } ?>

                                                                <!-- btn-group -->
                                                                <div class="input-group-btn">

                                                                    <button id="btnGenerarCodigo" type="button" class="btn btn-primary" title="Generar Codigo"><i class="fa fa-pencil"></i></button>
                                                                </div>
                                                                <!-- /btn-group -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="txtFirstName">Tipo</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $dataEmpresa->nombre_tipo; ?>" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el Tipo.">
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el Tipo.">
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

        var selectorInputsForm = ["#txtNombre", "#txtCodigo", "#cboCategoria" ];

        $("#btnAgregar").on("click", function(evt){

            
            evt.preventDefault();
            var urlApi    = baseUrl + <?php if (isset($modulo->idTipo)) { echo '"editar";'; } else { echo '"crear";'; } ?>;

            if ( ValidateInputFormWithParsley.validate(selectorInputsForm)) {
                waitingDialog.show('Cargando...');

                formData.append("id_tipo",           $("#idTipo").val());
                formData.append("txtNombre",         $("#txtNombre").val());
                formData.append("txtCodigo",         $("#txtCodigo").val());
                formData.append("id_categoria",      $("#cboCategoria").val());


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

                        swal("Tipo", response.message, "success");

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


        $("#btnGenerarCodigo").on("click", function(){
            waitingDialog.show('Generando Codigo...');
            formData.append("id_categoria",          $("#idCategoria").val());
            var request = $.ajax({
                url: baseUrl + "generatecodigo",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false
            });

            request.done(function( response ) {
                waitingDialog.hide();
                $("#txtCodigo").val(response.data.codigo);
                swal("Generar Codigo", response.message, "success");
            });

            request.fail(function( jqXHR, textStatus ) {
                waitingDialog.hide();
                swal("Generar Codigo", textStatus, "error");

            });
        });


        $("#btnClear").on("click", function(){
            $("#txtNombre").val("");
            $("#txtCodigo").val("");
        });

    });

</script>
</body>
</html>