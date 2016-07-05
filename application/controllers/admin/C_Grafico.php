<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Grafico extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

        $this->load->library('utils/UserSession');
        $this->load->model('admin/M_Admin_EventoRiesgo');
        $this->load->model('admin/M_Admin_Usuario');
        $this->load->model('api-rest/M_Api_Rest');
        $this->usersession->validatePanelEvento();
    }

    public function piramide()	{

        $this->load->model('admin/M_Admin_OperacionUsuario');
        $this->load->model('admin/M_Admin_Region');

        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Piramide de Brid";

        $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario      = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;

        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Piramide de Brid ";
        $modulo->titulo                    = "Piramide de Brid ";
        $modulo->titulo_registro           = "Gráfico Piramide de Brid ";

        $modulo->base_url                  = "admin/piramide/";

        $modulo->menu                      = array("menu" => 5, "submenu" => 1);
        $modulo->navegacion                = array(
            array("nombre" => "Piramide",
                "url" => "",
                "activo" => TRUE)
        );
        $modulo->region                    = $this->M_Admin_Region->getRegion();
        $modulo->operacion                 = $this->M_Admin_OperacionUsuario->getByID($usuario[0]->id_usuario);


        $data["modulo"] = $modulo;
        $this->load->view('admin/graficos/v-admin-piramide', $data);
    }

    public function getDataPiramide(){
        if ($this->input->post("id_usuario") &&
            $this->input->post("tipo_usuario") &&
            $this->input->post("id_tipo_usuario") &&
            $this->input->post("filtro")) {

            $usuario = $this->M_Api_Rest->getUserByID(
                array(
                    "id_usuario"        => trim($this->input->post("id_usuario", TRUE))
                )
            );

            if (sizeof($usuario) > 0) {

                if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 1) {

                    $registros = $this->M_Api_Rest->getEventosPiramideExportarExcel(
                        array(
                            "id_region"         => $usuario[0]->id_region,
                            "filtro"            => trim($this->input->post("filtro", TRUE)),
                            "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    );
                    $this->generateExcelPiramide($registros);


                } else if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 2) {

                    if ($this->validarSolicitudConOperaciones()) {

                        $registros = $this->M_Api_Rest->getEventosPiramideExportarExcel(
                            array(
                                "id_region"         => trim($this->input->post("id_region", TRUE)),
                                "filtro"            => trim($this->input->post("filtro", TRUE)),
                                "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        );
                        $this->generateExcelPiramide($registros);

                    } else {
                        echo "Lo sentimos, la operación seleccionada no se encuentra asignada a su usuario. Sincronice los datos de registro de eventos correctamente e inténtalo de nuevo.";
                    }

                } else {
                    echo "Lo sentimos, el tipo de usuario no es correcto o no tiene permisos de acceso a esta informacion.";
                }

            } else {
                echo "Lo sentimos, la cuenta de usuario no se encuentra registrado.";
            }

        } else {
            echo "No se recibio los parametros necesarios para procesar su solicitud.";
        }
    }

    public function getDataComportamiento(){
        if ($this->input->post("id_usuario") &&
            $this->input->post("tipo_usuario") &&
            $this->input->post("id_tipo_usuario") &&
            $this->input->post("filtro")) {

            $usuario = $this->M_Api_Rest->getUserByID(
                array(
                    "id_usuario"        => trim($this->input->post("id_usuario", TRUE))
                )
            );

            if (sizeof($usuario) > 0) {
                $data = new stdClass();

                if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 1) {

//                    $IDOperacionesUsuario = $this->getOperacionesUsuario($usuario[0]->id_usuario);
//
                    $registros = $this->M_Api_Rest->getEventosComportamientoSeguroExportarExcel(
                        array(
                            "id_region"                 => $usuario[0]->id_region,
                            "filtro"                    => trim($this->input->post("filtro", TRUE)),
                            "operaciones"               => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    );
                    //echo $registros;
                    $this->generateExcelPiramide($registros);

                } else if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 2) {

                    if ($this->validarSolicitudConOperaciones()) {

                        $registros = $this->M_Api_Rest->getEventosComportamientoSeguroExportarExcel(
                            array(
                                "id_region"                 => trim($this->input->post("id_region", TRUE)),
                                "filtro"                    => trim($this->input->post("filtro", TRUE)),
                                "operaciones"               => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        );
                        //echo $registros;
                        $this->generateExcelPiramide($registros);

                    } else {
                        echo "Lo sentimos, la operación seleccionada no se encuentra asignada a su usuario. Sincronice los datos de registro de eventos correctamente e inténtalo de nuevo.";
                    }

                } else {
                    echo "Lo sentimos, el tipo de usuario no es correcto o no tiene permisos de acceso a esta informacion.";
                }

            } else {
                echo "Lo sentimos, la cuenta de usuario no se encuentra registrado";
            }

        } else {
            echo "No se recibio los parametros necesarios para procesar su solicitud.";
        }
    }

    private function validarSolicitudConOperaciones() {
        $validarIntegridadOperaciones = true;

        if (trim($this->input->post("filtro", TRUE)) == "operacion") {
            if ( $this->validarOperacionUsuario(trim($this->input->post("id_operacion", TRUE))) == false ) {
                $validarIntegridadOperaciones = false;
            }
        }

        return $validarIntegridadOperaciones;
    }

    function cellColor($cells,$backgroundColor, $fontColor){
        $this->load->library('utils/PHPExcel/PHPExcel');
//        global $objPHPExcel;
        $borders = array(

            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $this->phpexcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $backgroundColor
            )
        ));
        $this->phpexcel->getActiveSheet()->getStyle($cells)->getFont()->setColor( new PHPExcel_Style_Color( $fontColor ) );

        $this->phpexcel->getActiveSheet()->getStyle($cells)->applyFromArray($borders);

    }

    public function generateExcelPiramide($registros)	{
        $this->load->library('utils/PHPExcel/PHPExcel');
        // configuramos las propiedades del documento
        $this->phpexcel->getProperties()->setCreator("SERVOSA")
            ->setLastModifiedBy("SERVOSA")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Estructura Piramide de Accidentabilidad")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("SERVOSA result file");


        // agregamos información a las celdas
        $this->phpexcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'N°')
            ->setCellValue('B1', 'REGION')
            ->setCellValue('C1', 'OPERACION')
            ->setCellValue('D1', 'RUTA')
            ->setCellValue('E1', 'TRAMO')
            ->setCellValue('F1', 'PLACA')
            ->setCellValue('G1', 'OBSERVADOR')
            ->setCellValue('H1', 'NIVEL DE OBSERVADOR')
            ->setCellValue('I1', 'FECHA')
            ->setCellValue('J1', 'HORA')
            ->setCellValue('K1', 'EVENTO')
            ->setCellValue('L1', 'CATEGORIA')
            ->setCellValue('M1', 'TIPO')
            ->setCellValue('N1', 'DESCRIPCION')
        ;

        $this->cellColor('A1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('B1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('C1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('D1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('E1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('F1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('G1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('H1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('I1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('J1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('K1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('L1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('M1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );
        $this->cellColor('N1', '3366ff', PHPExcel_Style_Color::COLOR_WHITE );

        for($col = 'A'; $col !== 'O'; $col++) {
            $this->phpexcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }
        $i = 2;
        foreach($registros as $info) {
            $fecha_registro = new DateTime($info->fecha_registro);
            $this->phpexcel->getActiveSheet()->setCellValue('A' . $i, $i-1)
                ->setCellValue('B' . $i, $info->nombre_region)
                ->setCellValue('C' . $i, $info->nombre_operacion)
                ->setCellValue('D' . $i, $info->nombre_ruta)
                ->setCellValue('E' . $i, $info->nombre_tramo)
                ->setCellValue('F' . $i, $info->placa)
                ->setCellValue('G' . $i, $info->nombre. " ". $info->apellidos)
                ->setCellValue('H' . $i, "NIVEL ".$info->id_tipo_usuario)
                ->setCellValue('I' . $i, date_format($fecha_registro, "d-m-Y"))
                ->setCellValue('J' . $i, date_format($fecha_registro, "H:i:s"))
                ->setCellValue('K' . $i, $info->nombre_evento)
                ->setCellValue('L' . $i, $info->nombre_categoria)
                ->setCellValue('M' . $i, $info->nombre_tipo)
                ->setCellValue('N' . $i, $info->descripcion)
            ;

            $this->setStyleCellsRegistros($i);

            $i++;
        }

        // Renombramos la hoja de trabajo
        $this->phpexcel->getActiveSheet()->setTitle('Simple');


        // configuramos el documento para que la hoja
        // de trabajo número 0 sera la primera en mostrarse
        // al abrir el documento
        $this->phpexcel->setActiveSheetIndex(0);

        $date   = date("d");
        $month  = date("m");
        $year   = date("Y");
        $name   = "Reporte Datos de Accidentabilidad - ".$date."-".$month."-".$year;


        // redireccionamos la salida al navegador del cliente (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    private function setStyleCellsRegistros($positionRow) {
        $columns = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N'
        );

        foreach ($columns as $column) {
            if ($positionRow % 2 == 0) {
                $this->cellColor($column.$positionRow, 'ffffff', PHPExcel_Style_Color::COLOR_BLACK );
            } else {
                $this->cellColor($column.$positionRow, 'ccffff', PHPExcel_Style_Color::COLOR_BLACK );

            }
        }
    }

    public function pastel()	{

        $this->load->model('admin/M_Admin_OperacionUsuario');
        $this->load->model('admin/M_Admin_Region');

        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Gráfico Comportamiento Seguro";

        $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario      = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;

        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Gráfico Comportamiento Seguro";
        $modulo->titulo                    = "Gráfico Comportamiento Seguro";
        $modulo->titulo_registro           = "Gráfico Comportamiento Seguro";

        $modulo->base_url                  = "admin/piramide/";

        $modulo->menu                      = array("menu" => 5, "submenu" => 2);
        $modulo->navegacion                = array(
            array("nombre" => "Comportamiento Seguro",
                "url" => "",
                "activo" => TRUE)
        );
        $modulo->region                    = $this->M_Admin_Region->getRegion();
        $modulo->operacion                 = $this->M_Admin_OperacionUsuario->getByID($usuario[0]->id_usuario);


        $data["modulo"] = $modulo;
        $this->load->view('admin/graficos/v-admin-torta', $data);
    }



    private function validarOperacionUsuario($idOperacion) {
        $operacionesUsuario = $this->M_Api_Rest->getOperaciones(trim($this->input->post("id_usuario", TRUE)));

        if (sizeof($operacionesUsuario) > 0) {
            foreach($operacionesUsuario as $operacionUsuario) {
                if ($operacionUsuario->id_operacion == $idOperacion) {
                    return true;
                }
            }
        }

        return false;
    }


}