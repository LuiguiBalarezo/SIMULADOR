<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="header">MENU</li>

			<li <?php echo ($menu == 4) ? 'class="active"' : ''; ?>>
				<a href="admin/eventoriesgo">
					<i class="fa fa-list"></i> <span>EVENTO DE RIESGO</span> <i class="fa fa-angle-left pull-right"></i>
				</a>

			</li>
			<li <?php echo ($menu == 5) ? 'class="active"' : ''; ?>>
				<a >
					<i class="fa fa-bar-chart"></i> <span>GRAFICOS ESTADISTICOS</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li <?php echo ($submenu == 1) ? 'class="active"' : ''; ?>><a href="admin/piramide"><i class="fa fa-exclamation-triangle"></i> PIRAMIDE DE BIRD</a></li>
					<li <?php echo ($submenu == 2) ? 'class="active"' : ''; ?>><a href="admin/comportamiento"><i class="fa fa-pie-chart"></i> COMPORTAMIENTO SEGURO</a></li>
				</ul>
			</li>
		</ul><!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>