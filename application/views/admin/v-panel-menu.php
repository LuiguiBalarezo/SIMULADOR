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
	          <ul class="treeview-menu">
	            <li <?php echo ($submenu == 1) ? 'class="active"' : ''; ?>><a href="panel/perfil"><i class="fa fa-circle-o"></i>  </a></li>
	            <li <?php echo ($submenu == 2) ? 'class="active"' : ''; ?>><a href="admin/tipousuario"><i class="fa fa-circle-o"></i> </a></li>
				<li <?php echo ($submenu == 9) ? 'class="active"' : ''; ?>><a ><i class="fa fa-circle-o"></i> </a></li>
	          </ul>
	        </li>
	        <li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
	          <a href="admin/operacion">
	            <i class="fa fa-dashboard"></i> <span>MODULO DE ESTUDIO</span> <i class="fa fa-angle-left pull-right"></i>
	          </a>
	          <ul class="treeview-menu">
	            <li <?php echo ($submenu == 3) ? 'class="active"' : ''; ?>><a href="admin/operacion"><i class="fa fa-circle-o"></i> SUBIR EXCEL</a></li>
	            <li <?php echo ($submenu == 4) ? 'class="active"' : ''; ?>><a ><i class="fa fa-circle-o"></i> VER </a></li>
			  </ul>
	        </li>
			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="admin/operacion">
					<i class="fa fa-dashboard"></i> <span>SIMULADOR DE 100 PREGUNTAS</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li <?php echo ($submenu == 3) ? 'class="active"' : ''; ?>><a href="admin/operacion"><i class="fa fa-circle-o"></i> SUBIR EXCEL</a></li>
					<li <?php echo ($submenu == 4) ? 'class="active"' : ''; ?>><a ><i class="fa fa-circle-o"></i> VER </a></li>
				</ul>
			</li>

			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="admin/operacion">
					<i class="fa fa-dashboard"></i> <span>SIMULADOR DE EXAMEN (COMPLETO)</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li <?php echo ($submenu == 3) ? 'class="active"' : ''; ?>><a href="admin/operacion"><i class="fa fa-circle-o"></i> USUARIO DEMO</a></li>
					<li <?php echo ($submenu == 4) ? 'class="active"' : ''; ?>><a ><i class="fa fa-circle-o"></i> USUARIO PREMIUM </a></li>
				</ul>
			</li>
			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="admin/operacion">
					<i class="fa fa-dashboard"></i> <span>BIBLIOGRAFIA</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="admin/operacion">
					<i class="fa fa-dashboard"></i> <span>MANUAL DE USO</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
				<a href="admin/operacion">
					<i class="fa fa-dashboard"></i> <span>SOPORTE TECNICO (AYUDA)</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

			<li <?php echo ($menu == 7) ? 'class="active"' : ''; ?>>
				<a href="admin/backup">
					<i class="fa fa-floppy-o"></i> <span>COMPRAR O RENOVAR LICENCIA</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

            
            
		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>