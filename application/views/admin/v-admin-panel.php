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

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a class="link-shorcut" href="panel/estudio">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-floppy-o"></i></span>
            <div class="info-box-content bg-aqua-active">
              <span class="info-box-text">MODULO DE ESTUDIO</span>
              <span class="info-box-number">more info</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a class="link-shorcut" href="panel/cienpreguntas">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-dashboard"></i></span>
            <div class="info-box-content bg-green-gradient">
              <span class="info-box-text">SIMULADOR DE 100 PREGUNTAS</span>
              <span class="info-box-number">more info</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->



      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow-gradient">
          <div class="inner">
            <span class="info-box-text">SIMULADOR COMPLETO</span>
          </div>
          <div class="icon">

          </div>
          <a href="panel/completo" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>


      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <h3>65 dias</h3>
            <p>para caducar tu licencia</p>
            <span class="info-box-text">RENUEVALA AHORA</span>
          </div>
          <div class="icon">

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