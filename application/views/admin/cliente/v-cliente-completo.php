<?php $this->load->view('template/main-panel/main-head', $modulo); ?>
<body class="hold-transition bg-black sidebar-mini fix-padding-scrollbar">
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
                SIMULADOR DE EXAMEN COMPLETO
                <ol class="breadcrumb">
                    <li>HORA INICIO: 00:00:00 PM <span class="glyphicon glyphicon-time"></span>  <p class="text-red">00:50:00 minutos</p></li>
                </ol>
                <br>

            </h1>
            <ol class="breadcrumb">
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="form-group">
                    <label>Tema</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option selected="selected">Tema</option>

                    </select>
                    <span class="select2 select2-container select2-container--default select2-container--below select2-container--open"
                          dir="ltr" style="width: 100%;">
                        <span class="selection">
                            <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="true" tabindex="0" aria-labelledby="select2-n588-container" aria-owns="select2-n588-results" aria-activedescendant="select2-n588-result-6lmh-Alaska">
                                <span class="select2-selection__rendered" id="select2-n588-container" title="Tema"></span>
                                <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
                            </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                    </span>
                </div>
                <div class="form-group">
                    <label>Sub Tema</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option selected="selected">Tema</option>

                    </select>
                    <span class="select2 select2-container select2-container--default select2-container--below select2-container--open"
                          dir="ltr" style="width: 100%;">
                        <span class="selection">
                            <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="true" tabindex="0" aria-labelledby="select2-n588-container" aria-owns="select2-n588-results" aria-activedescendant="select2-n588-result-6lmh-Alaska">
                                <span class="select2-selection__rendered" id="select2-n588-container" title="Tema"></span>
                                <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
                            </span>
                        </span>
                        <span class="dropdown-wrapper" aria-hidden="true"></span>
                    </span>
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