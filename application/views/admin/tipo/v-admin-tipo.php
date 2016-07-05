<?php $this->load->view('template/main-panel/main-head', $modulo); ?>
<body class="hold-transition skin-blue sidebar-mini fix-padding-scrollbar">
    <div class="wrapper">
        
      <?php 
        $data["modulo"] = $modulo;
        $this->load->view('template/main-panel/header', $data); ?>
        
      <?php 
        $data["menu"]     = $modulo->menu["menu"];
        $data["submenu"]  = $modulo->menu["submenu"];
        $this->load->view('admin/v-admin-menu', $data); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            EVENTO <?php echo $modulo->evento->nombre_evento?> - CATEGORIA <?php echo $modulo->evento->nombre_categoria?> - <?php echo $modulo->titulo; ?>
            <small>&nbsp;&nbsp; <a href="<?php echo base_url()."admin/categoria/".$modulo->evento->id_evento; ?>"><i class="fa fa-reply" aria-hidden="true"></i></a></small>
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
                  <h3 class="box-title"><?php echo $modulo->titulo_registro; ?>&nbsp;&nbsp;<a href="<?php echo base_url().$modulo->base_url.$modulo->id; ?>/agregar"><i class="fa fa-plus-square" aria-hidden="true"></i></a></h3>
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
    <script>
      $(function () {
        var formData  = new FormData();

        $(".btnActionRow").on("click", function(evt){
          var self = this;

          if ( $(this).attr("data-row-action") == "delete") {
            evt.preventDefault();
            formData.append("id", $(this).attr("data-row-id"));

            swal({
                  title: "Eliminar Tipo",
                  text: "¿Seguro que desea eliminar el Tipo?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#fc0836",
                  confirmButtonText: "Si, Eliminar",
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true
                },
                function() {
                  var request = $.ajax({
                    url: "<?php echo $modulo->base_url."delete"; ?>",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false
                  });

                  request.done(function( response ) {
                    waitingDialog.hide();
                    if (response.status) {
                      swal("Eliminado!", response.message, "success");
                      $(self).parent().parent().hide("slow", function(){
                        $(self).parent().parent().remove();
                      });
                    } else {
                      swal("Error", response.message, "error");
                    }
                  });

                  request.fail(function( jqXHR, textStatus ) {
                    waitingDialog.hide();
                    swal("Error", textStatus, "error");
                  });
                }
            );

          }

        });

      });
    </script>


</body>
</html>