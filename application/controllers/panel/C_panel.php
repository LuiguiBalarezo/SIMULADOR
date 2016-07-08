<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Panel extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

	}

	public function index() {
		$this->load->view('admin/cliente/v-admin-panel');
	}
	public function perfil(){
		$this->load->view('admin/cliente/v-cliente-perfil');

	}
	public function estudio(){
		$this->load->view('admin/cliente/v-cliente-estudio');

	}
	public function cienpreguntas(){
		$this->load->view('admin/cliente/v-cliente-cienpreguntas');

	}
	public function completo(){

		$this->load->view('admin/cliente/v-cliente-completo');

	}
	public function bibliografia(){
		$this->load->view('admin/cliente/v-cliente-bibliografia');

	}
	public function manual(){
		$this->load->view('admin/cliente/v-cliente-manual');

	}
	public function soporte(){
		$this->load->view('admin/cliente/v-cliente-soporte');

	}
	public function licencia(){
		$this->load->view('admin/cliente/v-cliente-licencia');

	}


}