<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Api_Rest_Session extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model('api-rest/M_Api_Rest');
        $this->load->library('security/Cryptography');
    }

    public function signIn() {
        $json 				= new stdClass();
        $json->type 		= "Iniciar Sesion";
        $json->presentation = "SignIn";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ($this->input->post("username") && $this->input->post("password")) {

            $result = $this->M_Api_Rest->getUserByName(array("username" => trim($this->input->post("username", TRUE))));

            if (sizeof($result) > 0 ) {
                $Usuario = $result[0];

                if ($this->cryptography->validateHash($Usuario->password, trim($this->input->post("password", TRUE)))) {

                    if (intval($Usuario->id_tipo_usuario) != 3) {
                        $json->data = $Usuario;
                        $json->message = "Inicio de sesion existosa.";
                        $json->status 	= TRUE;
                    } else {
                        $json->message 	= "Su tipo cuenta de usuario no tiene permiso para acceder a la aplicación. Contactese con el equipo de SERVOSA.";
                    }

                } else {
                    $json->message = "La contraseña del usuario es incorrecta.";
                }
            } else {
                $json->message = "La cuenta de usuario no existe.";
            }

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

}