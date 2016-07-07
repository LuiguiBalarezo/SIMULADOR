
<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar Menu -->

		<div class="user-panel">
			<div class="pull-left image">
				<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>Alexander Pierce</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>


		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li <?php echo ($menu == 1) ? 'class="active"' : ''; ?>>
	          <a href="panel/perfil">
	            <i class="fa fa-user"> </i> <span> EDITAR MI PERFIL </span> <i class="fa fa-angle-left pull-right"></i>
	          </a>

	        </li>
	        <li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
	          <a href="panel/estudio">
	            <i class="fa fa-dashboard"></i> <span>MODULO DE ESTUDIO</span> <i class="fa fa-angle-left pull-right"></i>
	          </a>

	        </li>
			<li <?php echo ($menu == 3) ? 'class="active"' : ''; ?>>
				<a href="panel/cienpreguntas">
					<i class="fa fa-dashboard"></i> <span>SIMULADOR DE 100 PREGUNTAS</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

			<li <?php echo ($menu == 4) ? 'class="active"' : ''; ?>>
				<a href="panel/completo">
					<i class="fa fa-dashboard"></i> <span>SIMULADOR DE EXAMEN (COMPLETO)</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 5) ?  : ''; ?>>
				<a href="panel/bibliografia">
					<i class="fa fa-dashboard"></i> <span>BIBLIOGRAFIA</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 6) ? 'class="active"' : ''; ?> >
				<a href="panel/manual">
					<i class="fa fa-dashboard"></i> <span>MANUAL DE USO</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 7) ? 'class="active"' : ''; ?>>
				<a href="panel/soporte">
					<i class="fa fa-dashboard"></i> <span>SOPORTE TECNICO (AYUDA)</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

			<li <?php echo ($menu == 8) ? 'class="active"' : ''; ?>>
				<a href="panel/licencia">
					<i class="fa fa-floppy-o"></i> <span>COMPRAR O RENOVAR LICENCIA</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

            
            
		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>