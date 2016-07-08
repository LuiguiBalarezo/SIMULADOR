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
	<link rel="stylesheet" href="<?php echo PATH_RESOURCE_PLUGINS; ?>bootstrap-validator/bootstrapValidator.min.css"/>

    <![endif]-->
</head>
<body class="hold-transition login-page" style="background: #d2d6de;">
	<!-- <body class="hold-transition" style="background: #4CAF50;"> -->
	<div class="register-box">
		<div class="login-logo">
			<img src="<?php echo PATH_RESOURCE_ADMIN; ?>img/icon/logo_white.png" style="width: 360px; height: 120px;" >
             
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">REGISTRARSE</p>

			<div class="container">

				<form class="" action=" " method="post"  id="contact_form">
					<div class="row">
						<div class="col-md-3 col-xs-12">
							<div class="form-group">
<!--								<label class="">Nombres</label>-->
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input id="txtNombre"  name="txtNombre" placeholder="NOMBRES" class="form-control"  type="text">
									</div>
								</div>
							</div>
							<div class="form-group">
<!--								<label class="control-label" >Apellido Paterno</label>-->
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input name="txtApellidoP" placeholder="APELLIDO PATERNO" class="form-control"  type="text">
									</div>
								</div>
							</div>
							<div class="form-group">
<!--								<label class="control-label" >Apellido Materno</label>-->
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input name="txtApellidoM" placeholder="APELLIDO MATERNO" class="form-control"  type="text">
									</div>
								</div>
							</div>
							<div class="form-group">
<!--								<label class="control-label" >Departamento</label>-->
								<div class="selectContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
										<select name="cbDepartamento" class="form-control selectpicker" >
											<option selected value="">DEPARTAMENTO</option>
											<?php foreach($modulo->departamento as $departamento): ?>
												<option value="<?php echo $departamento->idDepartamento;?>"> <?php echo $departamento->nom_departamento; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
<!--								<label class="control-label" >Provincia</label>-->
								<div class="selectContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
										<select name="cbProvincia" class="form-control selectpicker" >
											<option selected value="">PROVINCIA</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
<!--								<label class="control-label" >Distrito</label>-->
								<div class="selectContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
										<select name="cbDistrito" class="form-control selectpicker" >
											<option selected value="">DISTRITO</option>
										</select>
									</div>
								</div>

							</div>
							<div class="form-group">
<!--								<label class=" control-label">Dirección</label>-->
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<input name="txtDireccion" placeholder="DIRECCION" class="form-control" type="text">
									</div>
								</div>
							</div>


						</div>

						<div class="col-md-3 col-xs-12">
							<div class="form-group">
<!--								<label class=" control-label">DNI</label>-->
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
										<input name="txtDni" placeholder="DNI" class="form-control"  type="text">
									</div>
								</div>
							</div>
							<div class="form-group">
<!--								<label class=" control-label">Teléfono</label>-->
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
										<input name="txtTelefono" placeholder="(01)555-1212" class="form-control" type="text">
									</div>
								</div>
							</div>

							<div class="form-group">
<!--								<label class=" control-label">Correo Electrónico</label>-->
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
										<input name="txtCorreo" placeholder="CORREO ELECTRONICO" class="form-control"  type="text">
									</div>
								</div>
							</div>

							<div class="form-group">
<!--								<label class=" control-label">Contraseña</label>-->
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
										<input name="txtPassword" placeholder="CONTRASEÑA" class="form-control"  type="text">
									</div>
								</div>
							</div>
							<div class="form-group has-feedback" style="text-align: center">
								<label style="margin-top: 8px;">FECHA DE REGISTRO 07/07/2016</label>
							</div>
							<div class="checkbox icheck">
								<label style="margin-top: 6px">
									<input name="ckTerminos" id="ckTerminos" type="checkbox"><div style="margin-left: 30px;margin-top: -23px"> Estoy de acuerdo con los <a>Términos y condiciones</a></div>
								</label>
							</div>


						</div>

					</div>
						<!-- Success message -->

						<!-- Button -->
						<div class="form-group">
							<label class="control-label"></label>
							<div class="">
								<button type="submit" class="btn btn-warning" >Send <span class="glyphicon glyphicon-send"></span></button>
							</div>
						</div>


				</form>
			</div>
		</div><!-- /.container -->


		</div><!-- /.login-box-body -->

	</div><!-- /.login-box -->
	
    <?php $this->load->view('template/main-panel/scripts-footer'); ?>

    </body>
</html>