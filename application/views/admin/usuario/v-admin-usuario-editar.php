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
                <li class="active"><a href="<?php echo base_url(); ?>admin/empresa">Usuario</a> </li>
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
                            <h3 class="box-title"><?php echo $modulo->nombreSeccion; ?> Usuario</h3>
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
                                                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $modulo->idUsuario; ?>">
                                                <?php }else{ ?>
                                                    <input type="hidden" name="id_usuario" id="id_usuario" >
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
                                                            <label for="txtFirstName">Nombres</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" value="<?php echo $dataEmpresa->nombre; ?>" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el nombre.">
                                                            <?php } else { ?>
                                                                <input type="text" class="form-control" id="txtNombre" name="txtNombre" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el nombre.">
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                         
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtApellidos">Apellidos</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                <input type="text" class="form-control" id="txtApellidos"  name="txtApellidos" value="<?php echo $dataEmpresa->apellidos; ?>" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el apellido.">
                                                            <?php } else { ?>
                                                                
                                                                <input type="text" class="form-control" id="txtApellidos" name="txtApellidos" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el apellido.">
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtDni">DNI</label>
                                                            <?php
                                                                if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                    <input type="text" class="form-control" id="txtDni" name="txtDni" maxlength="8" value="<?php echo $dataEmpresa->dni; ?>" data-parsley-required data-parsley-required-message="Ingrese el email.">
                                                                <?php } else { ?>
                                                                    <input type="text" class="form-control" id="txtDni" name="txtDni" maxlength="8" data-parsley-required data-parsley-required-message="Ingrese el DNI.">
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtCelular">Celular</label>
                                                            <?php
                                                                if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                    <input type="text" class="form-control" id="txtCelular" name="txtCelular" value="<?php echo $dataEmpresa->celular; ?>" maxlength="9" data-parsley-required data-parsley-required-message="Ingrese el Celular.">
                                                                <?php } else { ?>
                                                                    <input type="text" class="form-control" id="txtCelular" name="txtCelular" maxlength="9" data-parsley-required data-parsley-required-message="Ingrese el Celular.">
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="txtDireccion">Dirección</label>
                                                                <?php
                                                                if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                    
                                                                    <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" value="<?php echo $dataEmpresa->direccion; ?>" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese la Direccion.">
                                                                <?php } else { ?>
                                                                    <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese la Direccion.">
                                                                <?php } ?>
                                                                
                                                            </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cboRegion">Region</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>

                                                                
                                                                <select id="cboRegion" value="<?php echo $dataEmpresa->id_region; ?>"  name="cboRegion"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la region.">

                                                                    <?php foreach($modulo->region as $region): ?>
                                                                        <?php if($dataEmpresa->id_region == $region->id_region ){?>
                                                                            <option selected="selected" value="<?php echo $region->id_region;?>"> <?php echo $region->nombre_region; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $region->id_region; ?>"><?php echo $region->nombre_region; ?></option>
                                                                        <?php } ?>

                                                                    <?php endforeach; ?>

                                                                </select>
                                                            <?php } else { ?>
                                                                <select id="cboRegion"  name="cboRegion"  class="form-control select2" style="width: 100%;"  tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione la region.">
                                                                    <option value="0" selected="selected">Seleccione</option>
                                                                    <?php foreach($modulo->region as $tipo): ?>
                                                                        <option value="<?php echo $tipo->id_region; ?>"><?php echo $tipo->nombre_region; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php } ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cboTipoUsuario">Tipo de Usuario</label>
                                                            <?php
                                                            if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                <select  id="cboTipoUsuario" value="<?php echo $dataEmpresa->id_tipo_usuario; ?>" name="cboTipoUsuario"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el tipo de usuario.">
                                                                    <?php foreach($modulo->tipousuario as $tipousuario): ?>
                                                                        <?php if($dataEmpresa->id_tipo_usuario == $tipousuario->id_tipo_usuario ){?>
                                                                            <option selected="selected" value="<?php echo $tipousuario->id_tipo_usuario;?>"> <?php echo $tipousuario->nombre_tipo_usuario; ?></option>
                                                                        <?php } else { ?>
                                                                            <option value="<?php echo $tipousuario->id_tipo_usuario; ?>"><?php echo $tipousuario->nombre_tipo_usuario; ?></option>
                                                                        <?php } ?>

                                                                    <?php endforeach; ?>

                                                                </select>
                                                            <?php } else { ?>
                                                                <select id="cboTipoUsuario"  name="cboTipoUsuario"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el tipo de usuario.">
                                                                    <option value="" selected="selected">Seleccione</option>
                                                                    <?php foreach($modulo->tipousuario as $tipo): ?>
                                                                        <option value="<?php echo $tipo->id_tipo_usuario; ?>"><?php echo $tipo->nombre_tipo_usuario; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="txtUsuario">Usuario</label>
                                                                <?php
                                                                if (isset($existeEmpresa) && $existeEmpresa ) { ?>

                                                                    <input type="text" value="<?php echo $dataEmpresa->usuario; ?>" class="form-control" id="txtUsuario" name="txtUsuario" maxlength="150" data-parsley-required  data-parsley-required-message="Ingrese el Nombre de Usuario." data-parsley-type-message="Ingrese un Usuario valido.">
                                                                <?php } else { ?>
                                                                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" maxlength="150" data-parsley-required data-parsley-required-message="Ingrese el Nombre de Usuario." data-parsley-type-message="Ingrese un Usuario valido.">
                                                                <?php } ?>

                                                            </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="txtEmail">Email</label>
                                                                <?php
                                                                if (isset($existeEmpresa) && $existeEmpresa ) { ?>
                                                                    <input type="text" di value="<?php echo $dataEmpresa->email; ?>" class="form-control" id="txtEmail" name="txtEmail" maxlength="150" data-parsley-required data-parsley-type="email" data-parsley-required-message="Ingrese el email." data-parsley-type-message="Ingrese un email valido.">
                                                                <?php } else { ?>
                                                                    <input type="text" class="form-control" id="txtEmail" name="txtEmail" maxlength="150" data-parsley-required data-parsley-type="email" data-parsley-required-message="Ingrese el email." data-parsley-type-message="Ingrese un email valido.">
                                                                <?php } ?>

                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="txtPassword">Password</label>

                                                                <div class="input-group">

                                                                    <input type="text" class="form-control" id="txtPassword" name="txtPassword" maxlength="40" data-parsley-required data-parsley-required-message="Ingrese una contraseña.">

                                                                    <!-- btn-group -->
                                                                    <div class="input-group-btn">

                                                                        <button id="btnGenerarPassword" type="button" class="btn btn-primary" title="Generar Contraseña"><i class="fa fa-pencil"></i></button>
                                                                    </div>
                                                                    <!-- /btn-group -->
                                                                </div>
                                                            </div>
                                                        </div>
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
        
        //Initialize Select2 Elements
        $("#cboRegion, #cboTipoUsuario").select2();

        var formData = new FormData();

        var baseUrl   = "<?php echo $modulo->base_url; ?>";
        var baseUrl   = "<?php echo $modulo->base_url; ?>";
        var tipo = <?php if (isset($modulo->idUsuario)) { echo '"editar";'; } else { echo '"crear";'; } ?>;
        /*if(tipo == "editar"){
         var selectorInputsForm = ["#txtNombre", "#txtApellidos", "#txtDni", "#txtCelular", "#txtDireccion",
         "#cboRegion","#cboTipoUsuario", "#txtEmail",  "#txtUsuario"];
         }else{
         var selectorInputsForm = ["#txtNombre", "#txtApellidos", "#txtDni", "#txtCelular", "#txtDireccion",
         "#cboRegion","#cboTipoUsuario", "#txtEmail", "#txtPassword" , "#txtUsuario"];
         }*/
        var selectorInputsForm = ["#txtNombre", "#txtApellidos", "#txtDni", "#txtCelular", "#txtDireccion",
            "#cboRegion","#cboTipoUsuario", "#txtEmail", "#txtPassword" , "#txtUsuario"];


        $("#btnAgregar").on("click", function(evt){
            evt.preventDefault();
//            console.log($("#id_usuario").val());
//            console.log($("#txtNombre").val());
//            console.log($("#txtApellidos").val());
//            console.log($("#txtDni").val());
//            console.log($("#txtCelular").val());
//            console.log($("#txtDireccion").val());
//            console.log($("#cboRegion").val());
//            console.log($("#cboTipoUsuario").val());
//            console.log($("#txtUsuario").val());
//            console.log($("#cboTipoUsuario").val());
//            console.log($("#txtEmail").val());
//            console.log($("#txtPassword").val());

            var urlApi    = baseUrl + <?php if (isset($modulo->idUsuario)) { echo '"editar";'; } else { echo '"crear";'; } ?>;

            if ( ValidateInputFormWithParsley.validate(selectorInputsForm)) {

                waitingDialog.show('Cargando...');

                formData.append("id_usuario",       $("#id_usuario").val());
                formData.append("txtNombre",        $("#txtNombre").val());
                formData.append("txtApellidos",     $("#txtApellidos").val());
                formData.append("txtDni",           $("#txtDni").val());
                formData.append("txtCelular",       $("#txtCelular").val());
                formData.append("txtDireccion",     $("#txtDireccion").val());
                formData.append("cboRegion",        $("#cboRegion").val());
                formData.append("cboTipoUsuario",   $("#cboTipoUsuario").val());
                formData.append("txtUsuario",       $("#txtUsuario").val());
                formData.append("txtEmail",         $("#txtEmail").val());
                formData.append("txtPassword",      $("#txtPassword").val());
               

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

                        swal("Usuario", response.message, "success");

                    } else {
                        swal("Usuario", response.message, "error");
                    }

                });

                request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Usuario", textStatus, "error");
                    
                });

            }

        });

        

        $("#btnGenerarPassword").on("click", function(){
            waitingDialog.show('Generando Contraseña...');

            var request = $.ajax({
                url: baseUrl + "generatePassword",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false
            });

            request.done(function( response ) {
                waitingDialog.hide();
                $("#txtPassword").val(response.data.password);             
                swal("Generar Contraseña", response.message, "success");
            });

            request.fail(function( jqXHR, textStatus ) {
                waitingDialog.hide();
                swal("Generar Contraseña", textStatus, "error");
                
            });
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