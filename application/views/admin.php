<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TMO | Iniciar sesion</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<base href="<?php echo base_url();?>">
	<link rel="icon" href="<?php echo PATH_RESOURCE_ADMIN; ?>img/icon/icon_app.png" type="image/png">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_BOOTSTRAP; ?>css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_DIST; ?>css/AdminLTE.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_PLUGINS; ?>iCheck/square/blue.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition login-page">
	<!-- <body class="hold-transition" style="background: #4CAF50;"> -->
	<div class="login-box">
		<div class="login-logo">
			<a href="#"><b>TMO</b> <b></b></a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			
			<a href="signOut" class="btn btn-default btn-flat">Cerrar sesion</a>

			<div class="social-auth-links text-center hide">
				<p>- OR -</p>
				<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
				<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
			</div><!-- /.social-auth-links -->

			<a class="hide" href="#">I forgot my password</a><br>
			<a href="register.html" class="text-center hide">Register a new membership</a>

		</div><!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<div class="example-modal">
		<div id="myModal" class="modal modal-danger fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Iniciar Sesion</h4>
					</div>
					<div class="modal-body">
						<p>One fine body&hellip;</p>
						<p><?php 
// $password = 'gf45_gdf#4hg';
							// $password = 'MegaRepresentaciones2015';
							$password = 'MR2015@';

// A higher "cost" is more secure but consumes more processing power
							$cost = 10;

// Create a random salt
							$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

// Prefix information about the hash so PHP knows how to verify it later.
// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
							$salt = sprintf("$2a$%02d$", $cost) . $salt;

// Value:
// $2a$10$eImiTXuWVxfM37uY4JANjQ==

// Hash the password with the salt
							$hash = crypt($password, $salt);
							
							echo $hash;

// echo $hash;

// Value:
// $2a$10$eImiTXuWVxfM37uY4JANjOL.oTxqp7WylW7FCzx2Lc7VLmdJIddZq
// $2a$10$mgXjn.OMJOn07hVY2o1qLem4W8Ht3PJZKdcoAG
							?></p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline" data-dismiss="modal">Aceptar</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div><!-- /.example-modal -->

		<!-- jQuery 2.1.4 -->
		<script src="<?php echo PATH_RESOURCE_PLUGINS; ?>jQuery/jQuery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.5 -->
		<script src="<?php echo PATH_RESOURCE_BOOTSTRAP; ?>js/bootstrap.min.js"></script>
		<!-- iCheck -->
		<script src="<?php echo PATH_RESOURCE_PLUGINS; ?>iCheck/icheck.min.js"></script>
		<script>
			$(function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
increaseArea: '20%' // optional
});

				$("#btnSignOut").on("click", function(evt){
					evt.preventDefault();

					
						var request = $.ajax({
							url: "<?php echo base_url().'signOut'; ?>",
							method: "POST",
							data: $("#formLogin").serialize(),
							dataType: "json"
						});

						request.done(function( response ) {
							
							if (response.status) {
								$(location).attr("href", "<?php echo base_url().'admin'; ?>");
							} else {
								$( ".modal-body" ).html( "<p>" + response.message + "<p>");
								$('#myModal').modal('show');
							}
						});

						request.fail(function( jqXHR, textStatus ) {
							$( ".modal-body" ).html( "<p>" + textStatus + " FAIL<p>");
							$('#myModal').modal('show');
						});
					

				});

			});
		</script>
	</body>
	</html>
