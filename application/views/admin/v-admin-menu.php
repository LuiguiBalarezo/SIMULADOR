<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header">MENU</li>
			<li <?php echo ($menu == 1) ? 'class="active"' : ''; ?>>
	          <a href="admin/usuario">
	            <i class="fa fa-user"></i> <span>USUARIOS</span> <i class="fa fa-angle-left pull-right"></i>
	          </a>
	          <ul class="treeview-menu">
	            <li <?php echo ($submenu == 1) ? 'class="active"' : ''; ?>><a href="admin/usuario"><i class="fa fa-circle-o"></i> USUARIO</a></li>
	            <li <?php echo ($submenu == 2) ? 'class="active"' : ''; ?>><a href="admin/tipousuario"><i class="fa fa-circle-o"></i> TIPO DE USUARIO</a></li>
				<li <?php echo ($submenu == 9) ? 'class="active"' : ''; ?>><a ><i class="fa fa-circle-o"></i> OPERACIONES DE USUARIO</a></li>
	          </ul>
	        </li>
	        <li <?php echo ($menu == 2) ? 'class="active"' : ''; ?>>
	          <a href="admin/operacion">
	            <i class="fa fa-dashboard"></i> <span>OPERACION</span> <i class="fa fa-angle-left pull-right"></i>
	          </a>
	          <ul class="treeview-menu">
	            <li <?php echo ($submenu == 3) ? 'class="active"' : ''; ?>><a href="admin/operacion"><i class="fa fa-circle-o"></i> OPERACION</a></li>
	            <li <?php echo ($submenu == 4) ? 'class="active"' : ''; ?>><a ><i class="fa fa-circle-o"></i> RUTA</a></li>
	            <li <?php echo ($submenu == 5) ? 'class="active"' : ''; ?>><a ><i class="fa fa-circle-o"></i> TRAMO</a></li>
	            <li <?php echo ($submenu == 6) ? 'class="active"' : ''; ?>><a ><i class="fa fa-circle-o"></i> PLACAS</a></li>
	          </ul>
	        </li>
	        <li <?php echo ($menu == 3) ? 'class="active"' : ''; ?>>
	          <a href="admin/evento">
	            <i class="fa fa-bar-chart"></i> <span>GRAFICOS ESTADISTICOS</span> <i class="fa fa-angle-left pull-right"></i>
	          </a>
	          <ul class="treeview-menu">
	            <li <?php echo ($submenu == 6) ? 'class="active"' : ''; ?>><a href="admin/evento"><i class="fa fa-circle-o"></i> EVENTO</a></li>
	            <li <?php echo ($submenu == 7) ? 'class="active"' : ''; ?>><a><i class="fa fa-circle-o"></i> CATEGORIA</a></li>
	            <li <?php echo ($submenu == 8) ? 'class="active"' : ''; ?>><a><i class="fa fa-circle-o"></i> TIPO</a></li>
	          </ul>
	        </li>
			<li <?php echo ($menu == 6) ? 'class="active"' : ''; ?>>
				<a href="admin/eventoriesgos">
					<i class="fa fa-exclamation-triangle"></i> <span>EVENTOS DE RIESGO</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 7) ? 'class="active"' : ''; ?>>
				<a href="admin/backup">
					<i class="fa fa-floppy-o"></i> <span>BACKUP</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>

            
            
		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>