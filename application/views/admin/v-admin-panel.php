<?php $this->load->view('template/main-panel/main-head', $modulo); ?>
<body class="hold-transition skin-blue sidebar-mini fix-padding-scrollbar">
<div class="wrapper">

  <?php
  $data["modulo"] = $modulo;
  $this->load->view('template/main-panel/header', $data); ?>

  <?php
  $data["menu"]     = 0;
  $data["submenu"]  = 0;
  $this->load->view('admin/v-admin-menu', $data); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SIMULADOR DE EXAMENES - BANCO DE PREGUNTAS 2016 <br>
        <small>Elija una opcion de simulador disponible segun su plan</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">


      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <p>MODULO DE ESTUDIO</p>
          </div>

          <a href="panel/estudio" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <p>SIMULADOR DE 100 PREGUNTAS</p>
          </div>

          <a href="panel/cienpreguntas" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>


      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner">
            <p>SIMULADOR COMPLETO</p>
          </div>

          <a href="panel/completo" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>


      <div class="col-lg-3 col-xs-6" style="margin-left: 200px;margin-top: 100px;">
        <div class="small-box bg-red">
          <div class="inner">
            <h3>65 dias</h3>
            <p>para caducar tu licencia
            RENUEVALA AHORA </p>

          </div>

          <a href="panel/licencia" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>


        
      <!--</div><!-- /.row -->

      <!-- =========================================================== -->

    </section><!-- /.content -->

  </div><!-- /.content-wrapper -->

  <?php $this->load->view('template/main-panel/footer'); ?>

</div><!-- ./wrapper -->
<?php $this->load->view('template/main-panel/scripts-footer'); ?>
</body>
</html>