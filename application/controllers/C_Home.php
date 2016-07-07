<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

	}

	public function index() {
		if ($this->session->has_userdata('usuario')) {
			 redirect('/admin/');
		} else {
			$this->load->view('v_home');
		}
	}



}