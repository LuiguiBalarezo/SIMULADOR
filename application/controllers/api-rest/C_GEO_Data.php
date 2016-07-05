<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_GEO_Data extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
//        $this->load->library('session');
//        $this->load->library('utils/UserSession');
//        $this->usersession->validateSession("panel-admin");
//        $this->load->model("M_Usuario");
//        $this->load->model('admin/M_Admin_Empresa');
    }

    public function ajaxGetRegionsByCountry() {
        $this->load->model("M_GEO_Data");

        $json 				= new stdClass();
        $json->type 		= "GEO Data - Regions by Country";
        $json->presentation = "";
        $json->action 		= "list";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("code_country") ) {

            $result = $this->M_GEO_Data->getRegionsByCountry(trim($this->input->post("code_country", TRUE)));

            if (count($result) > 0) {
                $json->message  = "Lista de regiones.";
                $json->data     = $result;
                $json->status 	= TRUE;
            } else {
                $json->message = "Lo sentimos no se encontraron regiones.";
            }

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function ajaxGetCitiesByRegionAndCountry() {
        $this->load->model("M_GEO_Data");

        $json 				= new stdClass();
        $json->type 		= "GEO Data - Citys by Regions and Country";
        $json->presentation = "";
        $json->action 		= "list";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("code_country") && $this->input->post("code_region")) {

            $result = $this->M_GEO_Data->getCitiesByRegionAndCountry(
                array(
                    "code_country"  => trim($this->input->post("code_country", TRUE)),
                    "code_region"   => trim($this->input->post("code_region", TRUE))
                )
            );

            if (count($result) > 0) {
                $json->message  = "Lista de ciudades.";
                $json->data     = $result;
                $json->status 	= TRUE;
            } else {
                $json->message = "Lo sentimos no se encontraron las ciudades.";
            }

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

}