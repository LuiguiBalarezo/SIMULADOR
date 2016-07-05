<!-- Main Header -->
<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo base_url()."admin"; ?>" class="logo" style="">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="<?php echo PATH_RESOURCE_ADMIN; ?>img/icon/icon_mini.png" alt=""></span>

    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="<?php echo PATH_RESOURCE_ADMIN; ?>img/icon/logo_white.png" alt=""></span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="<?php echo PATH_RESOURCE_ADMIN; ?>img/icon/icon_responsive.png" class="user-image" alt="SERVOSA">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"><?php echo $modulo->nombres_usuario; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="<?php echo PATH_RESOURCE_ADMIN; ?>img/icon/icon_responsive.png" class="img-circle" alt="SERVOSA">
              <p>
                <?php echo $modulo->nombres_usuario; ?> - <?php echo $modulo->tipo_usuario; ?>
                <!--<small>Member since Nov. 2012</small>-->
              </p>
            </li>
            <!-- Menu Body -->
            <!--<li class="user-body">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </li>-->
            <!-- Menu Footer-->
            <li class="user-footer">
              <!--<div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
              </div>-->
              <div >
                <a href="<?php echo  base_url()."admin/signOut"; ?>" class="btn btn-default btn-flat">Cerrar sesion</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <!--<li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>-->
      </ul>
    </div>
  </nav>
</header>