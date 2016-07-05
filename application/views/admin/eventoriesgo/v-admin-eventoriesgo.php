<?php $this->load->view('template/main-panel/main-head', $modulo); ?>
<body class="hold-transition skin-blue sidebar-mini fix-padding-scrollbar">
    <div class="wrapper">
        
      <?php 
        $data["modulo"] = $modulo;
        $this->load->view('template/main-panel/header', $data); ?>
        
      <?php 
        $data["menu"]     = $modulo->menu["menu"];
        $data["submenu"]  = $modulo->menu["submenu"];
        $this->load->view('admin/v-admin-menu2', $data); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $modulo->titulo; ?>
<!--            <small><a href="--><?php //echo base_url().$modulo->base_url; ?><!--agregar">Agregar</a></small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <?php foreach ($modulo->navegacion as $navegacion) {
                    if ($navegacion["activo"]) { ?>
                      <li class="active"><?php echo $navegacion["nombre"]; ?></li>
              <?php } else { 
                      if (strlen($navegacion["url"]) > 0) { ?>
                        <li><a href="<?php echo base_url().$navegacion["url"]; ?>"><?php echo $navegacion["nombre"]; ?></a></li>
                <?php } else { ?>
                        <li><?php echo $navegacion["nombre"]; ?></li>
                <?php } ?>
              <?php } ?>
            <?php } ?>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $modulo->titulo_registro; ?>&nbsp;&nbsp;<a href="<?php echo base_url().$modulo->base_url; ?>agregar"><i class="fa fa-plus-square" aria-hidden="true"></i></a></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                                         
                      <?php foreach ($modulo->cabecera_registro as $nombreCabecera) { ?>
                        <th><?php echo $nombreCabecera; ?></th>
                      <?php } ?>
                      
                      <th></th>
                    </tr>
                    <?php 
                    $registros["registros"] = $modulo->registros;
                    $registros["moduloNombre"] = $modulo->nombre;
                    $this->load->view($modulo->ruta_plantilla_registro, $registros); ?>
                    
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <!-- Show pagination links -->
                    <?php 
                      foreach ($modulo->links as $link) {
                        echo "<li>". $link."</li>";
                      } 
                    ?>
                  </ul>
                </div>
                <div class="overlay hide" >
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div><!-- /.box -->
              
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
      <?php $this->load->view('template/main-panel/footer'); ?>
      
    </div><!-- ./wrapper -->
    
    <?php $this->load->view('template/main-panel/modal-admin'); ?>
    <?php $this->load->view('template/main-panel/scripts-footer'); ?>
    

</body>
</html>