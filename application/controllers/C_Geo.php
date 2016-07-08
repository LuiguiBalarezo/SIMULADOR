<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Geo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function getProvincias()	{

        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{

            $this->load->model('M_GeoData');

            $json 				= new stdClass();
            $json->type 		= "Consulta";
            $json->presentation = "";
            $json->action 		= "consultar";
            $json->data 		= array();
            $json->status       = FALSE;
            if ( $this->input->post("id") ) {


                $result = $this->M_GeoData->getProvincia(trim($this->input->post("id", TRUE)));
                if (count($result) > 0) {
                    $json->data     = $result;
                    $json->message  = "Informacion correcta";
                    $json->status 	= TRUE;
                }else{
                    $json->message = "No se pudo obtener la informacion ";
                    $json->status  = FALSE;
                }


            } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($json);

        }

    }

    public function getDistritos()	{
        if(!$this->input->is_ajax_request())
        {
            show_404();
        }else{

            $this->load->model('M_GeoData');

            $json 				= new stdClass();
            $json->type 		= "Consulta";
            $json->presentation = "";
            $json->action 		= "consultar";
            $json->data 		= array();
            $json->status       = FALSE;
            if ( $this->input->post("id") ) {


                $result = $this->M_GeoData->getDistrito(trim($this->input->post("id", TRUE)));
                if (count($result) > 0) {
                    $json->data     = $result;
                    $json->message  = "Informacion correcta";
                    $json->status 	= TRUE;
                }else{
                    $json->message = "No se pudo obtener la informacion ";
                    $json->status  = FALSE;
                }


            } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($json);

        }

    }



}