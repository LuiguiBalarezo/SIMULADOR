<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Panel extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

	}

	public function index() {
		$this->load->view('panel');
	}
	public function perfil(){


	}
	public function estudio(){


	}
	public function cienpreguntas(){


	}
	public function completo(){


	}
	public function bibliografia(){


	}
	public function manual(){


	}
	public function soporte(){


	}
	public function licencia(){


	}


}