
<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar Menu -->

		<div class="user-panel">

			<div class="pull-left info">
				<p>Admin</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>


		<ul class="sidebar-menu " style="color:#b8c7ce;">
			<li class="header">MAIN NAVIGATION</li>
			<li <?php echo ($menu == 1) ? 'class="active"' : ''; ?>>
	          <a href="panel/perfil">
	            <i class="fa fa-circle-o"> </i> <span> EDITAR MI PERFIL </span>
	          </a>

	        </li>
	        <li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
	          <a href="panel/estudio">
	            <i class="fa fa-circle-o"></i> <span>MODULO DE ESTUDIO</span>
	          </a>

	        </li>
			<li <?php echo ($menu == 3) ? 'class="active"' : ''; ?>>
				<a href="panel/cienpreguntas">
					<i class="fa fa-circle-o"></i> <span>SIMULADOR DE 100 PREGUNTAS</span>
				</a>

			</li>

			<li <?php echo ($menu == 4) ? 'class="active"' : ''; ?>>
				<a href="panel/completo">
					<i class="fa fa-circle-o"></i> <span>SIMULADOR DE EXAMEN</span>
				</a>

			</li>
			<li <?php echo ($menu == 5) ?  'class="active"' : ''; ?>>
				<a href="panel/bibliografia">
					<i class="fa fa-circle-o"></i> <span>BIBLIOGRAFIA</span>
				</a>

			</li>
			<li <?php echo ($menu == 6) ? 'class="active"' : ''; ?> >
				<a href="panel/manual">
					<i class="fa fa-circle-o"></i> <span>MANUAL DE USO</span>
				</a>

			</li>
			<li <?php echo ($menu == 7) ? 'class="active"' : ''; ?>>
				<a href="panel/soporte">
					<i class="fa fa-circle-o"></i> <span>SOPORTE TECNICO (AYUDA)</span>
				</a>

			</li>

			<li <?php echo ($menu == 8) ? 'class="active"' : ''; ?>>
				<a href="panel/licencia">
					<i class="fa fa-circle-o"></i> <span>COMPRAR O RENOVAR LICENCIA</span>
				</a>

			</li>

            
            
		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>