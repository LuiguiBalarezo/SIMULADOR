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
                  <h3 class="box-title"><?php echo $modulo->titulo_registro; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <div class="col-md-12" style="text-align: center; padding-top: 10px">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">

                          <button id="btn_nacional" class="btn btn-primary">GRAFICO NACIONAL</button>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <button id="btn_regional" class="btn btn-primary" data-toggle="modal" data-target="#m_region">GRAFICO REGIONAL</button>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <button id="btn_operacion" class="btn btn-primary" data-toggle="modal" data-target="#m_operacion">GRAFICO POR OPERACION</button>
                        </div>
                    </div>


                </div>
                <div class="row" style="margin-top: 20px;">
                  <div class="col-md-12">
                    <div id="chartContainer" style="height: 450px; visibility: hidden">
                    </div>
                  </div>
                  <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-4 col-sm-12"></div>
                    <div class="col-md-4 col-sm-12" style="display: flex; justify-content: center;">
                      <a class="info-box-icon exportar" style="display: none"><i class="fa botonimagen"></i></a>

                    </div>
                    <form id="datos" name="datos" action="<?php echo base_url()."admin/excelC"; ?>" method="post" hidden  >
                      <input name="id_usuario" id="id_usuario" type="text" value="">
                      <input name="id_tipo_usuario" id="id_tipo_usuario" type="text" value="">
                      <input name="tipo_usuario" id="tipo_usuario" type="text" value="">
                      <input name="filtro" id="filtro" type="text" value="">
                      <input name="id_region" id="id_region" type="text" value="">
                      <input name="id_operacion" id="id_operacion" type="text" value="">

                    </form>
                  </div>

                </div>


                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

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
    <div class="modal fade" id="m_region" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Seleccionar Region</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="cboRegion">Region</label>
              <select  id="cboRegion" name="cboRegion"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el tipo de usuario.">
                <?php if($modulo->datos_usuario->id_tipo_usuario == 2){ ?>
                <?php foreach($modulo->region as $region): ?>
                  <?php if($modulo->datos_usuario->id_region == $region->id_region ){?>
                    <option selected="selected" value="<?php echo $region->id_region;?>"> <?php echo $region->nombre_region; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $region->id_region; ?>"><?php echo $region->nombre_region; ?></option>
                  <?php } ?>

                <?php endforeach; ?>
                <?php }else{ ?>
                  <option value="<?php echo $modulo->datos_usuario->id_region; ?>"><?php echo $modulo->datos_usuario->nombre_region; ?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button id="send_region" type="button" class="btn btn-primary">Aceptar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="m_operacion" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Seleccionar Operacion</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="cboOperacion">Operacion</label>
              <select  id="cboOperacion" name="cboOperacion"  class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true" data-parsley-required data-parsley-required-message="Seleccione el tipo de usuario.">
                <?php foreach($modulo->operacion as $operacion): ?>
                    <option value="<?php echo $operacion->id_operacion; ?>"><?php echo $operacion->nombre_operacion; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button id="send_operacion" type="button" class="btn btn-primary">Aceptar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    
    <?php $this->load->view('template/main-panel/modal-admin'); ?>
    <?php $this->load->view('template/main-panel/scripts-footer'); ?>
    <?php $this->load->view('template/main-panel/modal-admin'); ?>
    <script src="<?php echo PATH_RESOURCE_PLUGINS; ?>canvas/canvasjs.min.js"></script>

    <script>


      function grafico($riesgo, $seguro){

        var chart = new CanvasJS.Chart("chartContainer",
            {

              animationEnabled: true,
              legend: {
                verticalAlign: "bottom",
                horizontalAlign: "center"
              },
              theme: "theme1",
              data: [
                {
                  type: "pie",
                  indexLabelFontFamily: "Garamond",
                  indexLabelFontSize: 20,
                  indexLabelFontWeight: "bold",
                  startAngle:0,
                  indexLabelFontColor: "MistyRose",
                  indexLabelLineColor: "darkgrey",
                  indexLabelPlacement: "inside",
                  toolTipContent: "{name}: {y} eventos",
                  showInLegend: true,
                  indexLabel: "#percent%",
                  dataPoints: [
                    {  y: $riesgo, name: "Comportamiento de Riesgo", legendMarkerType: "square"},
                    {  y: $seguro, name: "Comportamiento Seguro", legendMarkerType: "square"},
                  ]
                }
              ]
            });
        chart.render();
      }

      var baseUrl   = "<?php echo base_url(); ?>";
      GenericModal.config("#genericModal", "");
      //Initialize Select2 Elements
      $(".select2").select2();

      var id_usuario = "<?php echo $modulo->datos_usuario->id_usuario; ?>";
      var tipo_usuario = "<?php echo $modulo->datos_usuario->nombre_tipo_usuario; ?>";
      var id_tipo_usuario = "<?php echo $modulo->datos_usuario->id_tipo_usuario; ?>";
      $("#id_usuario").val(id_usuario);
      $("#tipo_usuario").val(tipo_usuario);
      $("#id_tipo_usuario").val(id_tipo_usuario);

      var formData = new FormData();

      formData.append("id_usuario",       id_usuario);
      formData.append("tipo_usuario",       tipo_usuario);
      formData.append("id_tipo_usuario",       id_tipo_usuario);

      $("#btn_nacional").on("click", function(evt){
        formData.append("filtro",       "nacional");
        $("#chartContainer").css("visibility", "hidden");
        $("#leyend").css("visibility", "hidden");
        $( ".exportar" ).css("display", "none");
        $("#filtro").val("nacional");

        $("#m_operacion").modal('hide');

        if(id_tipo_usuario == 2 ){
          waitingDialog.show('Cargando...');
          var request = $.ajax({
            url: baseUrl + "api-rest/evento/getEventosComportamientoSeguro",
            method: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false
          });

          request.done(function( response ) {
            waitingDialog.hide();
            if (response.status) {

              if(response.data.comportamiento_riesgo == 0 && response.data.comportamiento_seguro == 0){
                swal("Comportamiento Seguro", "No se obtuvieron registros", "warning");
                $("#chartContainer").css("visibility", "hidden");
              }else{
                swal("Comportamiento Seguro", response.message, "success");
                grafico(response.data.comportamiento_riesgo, response.data.comportamiento_seguro);
                $("#btn_nacional").css("background", "#7bb51e");
                $("#btn_regional").css("background", "#367fa9");
                $("#btn_operacion").css("background", "#367fa9");

                $("#chartContainer").css("visibility", "visible");
                $( ".exportar" ).css("display", "block");
              }
            } else {
              swal("Comportamiento Seguro", response.message, "error");
            }



          });

          request.fail(function( jqXHR, textStatus ) {
            waitingDialog.hide();
            swal("Comportamiento Seguro", textStatus, "error");

          });

        }else {
          swal("Comportamiento Seguro", "Usted no puede acceder a este grafico", "warning");
        }

      });

      $("#send_region").on("click", function(evt){
        formData.append("id_region",       $("#cboRegion").val());
        formData.append("filtro",       "region");
        $("#chartContainer").css("visibility", "hidden");
        $("#leyend").css("visibility", "hidden");
        $( ".exportar" ).css("display", "none");

        $("#btn_nacional").css("background", "#367fa9");
        $("#btn_regional").css("background", "#7bb51e");
        $("#btn_operacion").css("background", "#367fa9");

        $("#filtro").val("region");
        $("#id_region").val($("#cboRegion").val());

        $("#m_region").modal('hide');
        waitingDialog.show('Cargando...');

        var request = $.ajax({
          url: baseUrl + "api-rest/evento/getEventosComportamientoSeguro",
          method: "POST",
          data: formData,
          dataType: "json",
          processData: false,
          contentType: false
        });

        request.done(function( response ) {
          waitingDialog.hide();


          if(response.data.comportamiento_riesgo == 0 && response.data.comportamiento_seguro == 0){
            swal("Comportamiento Seguro", "No se obtuvieron registros", "warning");
            $("#chartContainer").css("visibility", "hidden");
          }else{
            swal("Comportamiento Seguro", response.message, "success");
            grafico(response.data.comportamiento_riesgo, response.data.comportamiento_seguro);
            $("#chartContainer").css("visibility", "visible");
            $( ".exportar" ).css("display", "block");
          }

        });

        request.fail(function( jqXHR, textStatus ) {
          waitingDialog.hide();
          swal("Comportamiento Seguro", textStatus, "error");

        });

      });

      $("#send_operacion").on("click", function(evt){
        formData.append("filtro",       "operacion");
        formData.append("id_operacion",       $("#cboOperacion").val());
        $("#chartContainer").css("visibility", "hidden");
        $("#leyend").css("visibility", "hidden");
        $( ".exportar" ).css("display", "none");

        $("#btn_nacional").css("background", "#367fa9");
        $("#btn_regional").css("background", "#367fa9");
        $("#btn_operacion").css("background", "#7bb51e");

        $("#filtro").val("operacion");
        $("#id_operacion").val($("#cboOperacion").val());

        $("#m_operacion").modal('hide');
        waitingDialog.show('Cargando...');

        var request = $.ajax({
          url: baseUrl + "api-rest/evento/getEventosComportamientoSeguro",
          method: "POST",
          data: formData,
          dataType: "json",
          processData: false,
          contentType: false
        });

        request.done(function( response ) {
          waitingDialog.hide();

          if(response.data.comportamiento_riesgo == 0 && response.data.comportamiento_seguro == 0){
            swal("Comportamiento Seguro", "No se obtuvieron registros", "warning");
            $("#chartContainer").css("visibility", "hidden");
          }else{
            swal("Comportamiento Seguro", response.message, "success");
            grafico(response.data.comportamiento_riesgo, response.data.comportamiento_seguro);
            $("#chartContainer").css("visibility", "visible");
            $( ".exportar" ).css("display", "block");
          }

        });

        request.fail(function( jqXHR, textStatus ) {
          waitingDialog.hide();
          swal("Comportamiento Seguro", textStatus, "error");

        });

      });
      $(".exportar").on("click", function(evt){
        $("#datos").submit();
      });
    </script>
    

</body>
</html>