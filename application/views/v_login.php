<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $modulo->titulo_pagina; ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<base href="<?php echo base_url();?>">
	<link rel="icon" href="<?php echo $modulo->url_logo; ?>" type="image/png">
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
    
    <link rel="stylesheet" href="<?php echo PATH_RESOURCE_ADMIN; ?>css/style.css">

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
             <!-- <img class="img-circle" src="<?php echo $modulo->url_logo; ?>" alt="User Avatar"> -->
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">Iniciar sesion</p>
			<form id="formLogin" name="formLogin" method="post">
				<div class="form-group has-feedback">
					<input id="email_usuario" type="email" name="email_usuario" class="form-control" placeholder="Email">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input id="contrasenia_usuario" type="password" name="contrasenia_usuario" class="form-control" placeholder="Password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>

				<div class="row">
					<div class="col-xs-8">
<!--						<div class="checkbox icheck">-->
<!--							<label>-->
<!--								<input type="checkbox"> Recordarme-->
<!--							</label>-->
<!--						</div>-->
					</div><!-- /.col -->
					<div class="col-xs-4">
						<button id="btnSignIn" type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
					</div><!-- /.col -->
				</div>
				
<!--                <a href="#">I forgot my password</a><br>-->
<!--                <a href="#" class="text-center">Register a new membership</a>-->

			</form>
            
            

		</div><!-- /.login-box-body -->

	</div><!-- /.login-box -->

    <?php $this->load->view('template/main-panel/modal-admin'); ?>
    <?php $this->load->view('template/main-panel/scripts-footer'); ?>
    <script>
            
        $(function () {
            
            GenericModal.config("#genericModal", "");
            
            // $('input').iCheck({
            //     checkboxClass: 'icheckbox_square-blue',
            //     radioClass:    'iradio_square-blue',
            //     increaseArea:   '20%' // optional
            // });

            $("#btnSignIn").on("click", function(evt){
                evt.preventDefault();

                if ( $("#email_usuario").val().length > 0 && $("#contrasenia_usuario").val().length > 0 ) {
                    waitingDialog.show('Iniciando sesion...');
                    var request = $.ajax({
                        url: "<?php echo base_url().'admin/signIn'; ?>",
                        method: "POST",
                        data: $("#formLogin").serialize(),
                        dataType: "json"
                    });

                    request.done(function( response ) {
                        waitingDialog.hide();
                        if (response.status) {
                            $(location).attr("href", response.data.url_redirect);
                        } else {
                            GenericModal.show("danger", "<p>" + response.message + "</p>");
                        }
                    });

                    request.fail(function( jqXHR, textStatus ) {
                        waitingDialog.hide();
                        GenericModal.show("danger", "<p>" + textStatus + "</p>");
                    });
                } else {
                    waitingDialog.hide();
                    GenericModal.show("danger", "<p>Ingrese sus datos de usuario correctamente.</p>");
                }

            });

        });
        
    </script>
    </body>
</html>