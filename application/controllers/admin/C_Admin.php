<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
	}

	public function index()	{
        $this->load->model('admin/M_Admin_Usuario');
        $modulo                     = new stdClass();
        $modulo->titulo_pagina      = "Simulador de Examenes | Panel Principal";

        $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario      = $usuario[0];
        
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;


        
        $data["modulo"] = $modulo;
        $this->load->view('admin/v-admin-panel', $data);
	}

}