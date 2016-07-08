<?php $this->load->view('template/main-panel/main-head', $modulo); ?>
<body class="hold-transition skin-black sidebar-mini fix-padding-scrollbar">
<div class="wrapper">

  <?php
  $data["modulo"] = $modulo;
  $this->load->view('template/main-panel/header', $data); ?>

  <?php
  $data["menu"]     = 0;
  $data["submenu"]  = 0;
  $this->load->view('admin/v-panel-menu', $data); ?>

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
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <p><h4>MODULO DE <br/>
                ESTUDIO</h4></p>
            </div>

            <a href="panel/c" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h4>SIMULADOR<br/>
                100 PREGUNTAS</h4>
            </div>

            <a href="panel/cienpreguntas" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h4>SIMULADOR<br/>
                COMPLETO</h4>
            </div>

            <a href="panel/completo" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6" ></div>

      </div>
      <div class="row">
        <div class="col-lg-3 col-xs-6" ></div>

        <div class="col-lg-3 col-xs-6" >
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65 </h3>
              <p>Para caducar tu licencia<br/>
              RENUEVALA AHORA </p>
            </div>
            <a href="panel/licencia" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6" ></div>
        <div class="col-lg-3 col-xs-6" ></div>

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