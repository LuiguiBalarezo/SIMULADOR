<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header">MENU</li>
			<li <?php echo ($menu == 1) ? 'class="active"' : ''; ?>>
	          <a href="panel/perfil">
	            <i class="fa fa-user"></i> <span>EDITAR MI PERFIL</span> <i class="fa fa-angle-left pull-right"></i>
	          </a>

	        </li>
	        <li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
	          <a href="panel/estudio">
	            <i class="fa fa-dashboard"></i> <span>MODULO DE ESTUDIO</span> <i class="fa fa-angle-left pull-right"></i>
	          </a>

	        </li>
			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="panel/cienpreguntas">
					<i class="fa fa-dashboard"></i> <span>SIMULADOR DE 100 PREGUNTAS</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="panel/completo">
					<i class="fa fa-dashboard"></i> <span>SIMULADOR DE EXAMEN (COMPLETO)</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="panel/bibliografia">
					<i class="fa fa-dashboard"></i> <span>BIBLIOGRAFIA</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="panel/manual">
					<i class="fa fa-dashboard"></i> <span>MANUAL DE USO</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="panel/soporte">
					<i class="fa fa-dashboard"></i> <span>SOPORTE TECNICO (AYUDA)</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

			<li <?php echo ($menu == 7) ? 'class="active"' : ''; ?>>
				<a href="panel/licencia">
					<i class="fa fa-floppy-o"></i> <span>COMPRAR O RENOVAR LICENCIA</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

            
            
		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>