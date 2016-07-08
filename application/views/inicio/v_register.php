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
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css"/>

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
						<!-- Text input-->
						<div class="col-md-3 col-xs-12">
							<div class="form-group">
								<label class="">First Name</label>
								<div class=" inputGroupContainer">
									<div class="input-group">
										<input  name="first_name" placeholder="First Name" class="form-control"  type="text">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									</div>
								</div>
							</div>

							<!-- Text input-->

							<div class="form-group">
								<label class="control-label" >Last Name</label>
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input name="last_name" placeholder="Last Name" class="form-control"  type="text">
									</div>
								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class=" control-label">E-Mail</label>
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
										<input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
									</div>
								</div>
							</div>
						</div>


						<!-- Text input-->
						<div class="col-md-3 col-xs-12">
							<div class="form-group">
								<label class=" control-label">Phone #</label>
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
										<input name="phone" placeholder="(845)555-1212" class="form-control" type="text">
									</div>
								</div>
							</div>

							<!-- Text input-->

							<div class="form-group">
								<label class=" control-label">Address</label>
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<input name="address" placeholder="Address" class="form-control" type="text">
									</div>
								</div>
							</div>

							<!-- Text input-->

							<div class="form-group">
								<label class="control-label">City</label>
								<div class=" inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<input name="city" placeholder="city" class="form-control"  type="text">
									</div>
								</div>
							</div>

							<!-- Select Basic -->

							<div class="form-group">
								<label class="control-label">State</label>
								<div class="selectContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
										<select name="state" class="form-control selectpicker" >
											<option value=" " >Please select your state</option>
											<option>Alabama</option>
											<option>Alaska</option>
											<option >Arizona</option>
											<option >Arkansas</option>
											<option >California</option>
											<option >Colorado</option>
											<option >Connecticut</option>
											<option >Delaware</option>
											<option >District of Columbia</option>
											<option> Florida</option>
											<option >Georgia</option>
											<option >Hawaii</option>
											<option >daho</option>
											<option >Illinois</option>
											<option >Indiana</option>
											<option >Iowa</option>
											<option> Kansas</option>
											<option >Kentucky</option>
											<option >Louisiana</option>
											<option>Maine</option>
											<option >Maryland</option>

										</select>
									</div>
								</div>
							</div>

							<!-- Text input-->

							<div class="form-group">
								<label class=" control-label">Zip Code</label>
								<div class="inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<input name="zip" placeholder="Zip Code" class="form-control"  type="text">
									</div>
								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="control-label">Website or domain name</label>
								<div class="inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
										<input name="website" placeholder="Website or domain name" class="form-control" type="text">
									</div>
								</div>
							</div>

							<!-- radio checks -->
							<div class="form-group">
								<label class="control-label">Do you have hosting?</label>
								<div class="">
									<div class="radio">
										<label>
											<input type="radio" name="hosting" value="yes" /> Yes
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="hosting" value="no" /> No
										</label>
									</div>
								</div>
							</div>

							<!-- Text area -->

							<div class="form-group">
								<label class="control-label">Project Description</label>
								<div class="inputGroupContainer">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
										<textarea class="form-control" name="comment" placeholder="Project Description"></textarea>
									</div>
								</div>
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