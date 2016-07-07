<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Register | Simulador de Ex&aacute;menes</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<base href="<?php echo base_url();?>">
	<link rel="shortcut icon" href="<?php echo PATH_RESOURCE_ADMIN; ?>img/icon/user_mini.png" type="image/png">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_BOOTSTRAP; ?>css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_DIST; ?>css/AdminLTE.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_PLUGINS; ?>iCheck/square/blue.css">
    
    <link rel="stylesheet" href="<?php echo PATH_RESOURCE_ADMIN; ?>css/style.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<!-- Sweet Alert -->
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_PLUGINS; ?>sweetalert/sweetalert.css">
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_PLUGINS; ?>iCheck/square/blue.css">

    <![endif]-->
</head>
<body class="hold-transition login-page" style="background: #d2d6de;">
	<!-- <body class="hold-transition" style="background: #4CAF50;"> -->
	<div class="register-box">
		<div class="login-logo">
			<img src="<?php echo PATH_RESOURCE_ADMIN; ?>img/icon/logo_white.png" style="width: 360px; height: 120px;" >
             
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">INICIAR SESION</p>
			<form id="Form"  method="post">
				<div class="row">

						<div class="col-md-6 col-xs-12">
							<div class="form-group has-feedback">
								<input type="text" name="txtNombre" id="txtNombre" class="form-control" placeholder="NOMBRES">
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="txtApellido" id="txtApellido" class="form-control" placeholder="APELLIDO PATERNO">
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="txtApellido" id="txtApellido" class="form-control" placeholder="APELLIDO MATERNO">
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="txtApellido" id="txtApellido" class="form-control" placeholder="DEPARTAMENTO">
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="txtApellido" id="txtApellido" class="form-control" placeholder="PROVINCIA">
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="txtApellido" id="txtApellido" class="form-control" placeholder="DISTRITO">
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group has-feedback">
								<input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="DNI">
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="TELEFONO">
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="CORREO ELECTRONICO">
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<input type="password" name="txtPassword" id="txtPassword" class="form-control" placeholder="CONTRASEÑA">
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
								<label style="margin-top: 20px">FECHA DE REGISTRO 07/07/2016</label>
							</div>
							<div class="checkbox icheck">
								<label style="margin-top: 5px">
									<input type="checkbox"> Estoy de acuerdo con los <a>Términos y condiciones</a>
								</label>
							</div>

						</div>


				</div>
				<div class="row">
					<div class="col-xs-4"></div>
					<div class="col-xs-4">
						<button type="submit" id="btnSignIn" class="btn btn-primary btn-block btn-flat">INGRESAR</button>
					</div><!-- /.col -->
					<div class="col-xs-4"></div>
				</div>


			</form>

<!--			<div class="social-auth-links text-center">-->
<!---->
<!--				<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Inicia Sesion con Facebook</a>-->
<!---->
<!--			</div><!-- /.social-auth-links -->


		</div><!-- /.login-box-body -->

	</div><!-- /.login-box -->
	
    <?php $this->load->view('template/main-panel/scripts-footer'); ?>
    <script>
            
        $(function () {
			$("#btnSignIn").on("click", function(evt){
				evt.preventDefault();
				//$(location).attr("href", "<?php echo base_url().'admin'; ?>");
				if ( $("#txtEmail").val().length > 0 && $("#txtPassword").val().length > 0 ) {
					$.LoadingOverlay("show");
					var request = $.ajax({
						url: "<?php echo base_url().'signIn'; ?>",
						type: "post",
						data: $("#Form").serialize(),
						dataType: 'json'
					});

					request.done(function( response ) {
						$.LoadingOverlay("hide");
						if (response.status) {
							$(location).attr("href", response.data.url_redirect);
						} else {
							swal("Error", response.message, "error");

						}
					});

					request.fail(function( jqXHR, textStatus ) {
						$.LoadingOverlay("hide");
						swal("Error", textStatus, "error");

					});
				} else {

					swal("Error", "Ingrese sus datos de usuario correctamente.", "error");

				}
			});
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' // optional
			});
				

		});
        
    </script>
    </body>
</html>