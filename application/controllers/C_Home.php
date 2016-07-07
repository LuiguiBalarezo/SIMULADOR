<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

	}

	public function index() {
//		if ($this->session->has_userdata('usuario')) {
//			 redirect('/admin/');
//		} else {
			$this->load->view('v_home');
//		}

	}
	public function signIn() {
		$this->load->helper('security');
		$this->load->model('admin/M_Admin_Login');
		$this->load->library('security/Cryptography');

		$json 				= new stdClass();
		$json->type 		= "Iniciar Sesion";
		$json->presentation = "SignIn";
		$json->data 		= array();
		$json->status 		= FALSE;

		var_dump($this->input->post());
		if ($this->input->post("txtEmail") && $this->input->post("txtPassword")) {

			$result = $this->M_Admin_Login->signIn(trim($this->input->post("email", TRUE)));
			if (sizeof($result) > 0 ) {
				$Usuario = $result[0];
				if ($this->cryptography->validateHash($Usuario->password, trim($this->input->post("password", TRUE)))) {

					$sessionUser = array(
						'user_session'          => TRUE,
						'id_usuario'            => intval($Usuario->id_usuario),
						'nombres_usuario'       => $Usuario->nombre,
						'apellidos_usuario'	    => $Usuario->apellidos,
						'usuario'	    		=> $Usuario->usuario,
						'email_usuario'		    => $Usuario->email,
						'id_tipo_usuario'		=> $Usuario->id_tipo_usuario,
						'nombre_tipo_usuario'	=> $Usuario->nombre_tipo_usuario,
					);

					$json->data = array("url_redirect" => base_url()."panel");

					$this->session->set_userdata($sessionUser);

					$json->message = "Inicio de sesion existosa.";
					$json->status 	= TRUE;
				} else {
					$json->message = "La contraseña del usuario es incorrecta.";
				}
			} else {
				$json->message = "El Usuario no existe.";
			}

		} else {
			$json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
		}

		echo json_encode($json);
	}

	public function signOut() {
		$sessionUser = array(
			'user_session',
			'id_usuario',
			'nombres_usuario',
			'apellidos_usuario',
			'usuario',
			'email_usuario',
			'id_tipo_usuario',
			'nombre_tipo_usuario'
		);
		$this->session->unset_userdata($sessionUser);
		$this->session->sess_destroy();
		redirect('/');
	}



}