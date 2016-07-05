<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Not_Found extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function store() {
        $modulo = new stdClass();
		$modulo->titulo     = "Store Not Found";
        $modulo->mensaje    = "La tienda no se encuentra registrado, para mas informacion consulte con el equipo de TMO.";
        
        $data["modulo"] = $modulo;        
        $this->load->view('template/v-not-found', $data);
	}

	public function company() {
		$modulo = new stdClass();
		$modulo->titulo     = "Company Not Found";
		$modulo->mensaje    = "La empresa no se encuentra registrado, para mas informacion consulte con el equipo de TMO.";

		$data["modulo"] = $modulo;
		$this->load->view('template/v-not-found', $data);
	}

}