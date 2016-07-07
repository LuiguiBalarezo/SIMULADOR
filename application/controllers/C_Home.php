<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

	}

	public function index() {

		$this->load->view('inicio/v_start');

	}

	public function login() {

		$this->load->view('inicio/v_login');

	}

	public function register() {

		$this->load->view('inicio/v_register');

	}

	public function facebook() {

		$this->load->library('facebook/Facebook_lib');
		$data = array(
			'redirect_uri' => site_url('handlefacebook'),
			'scope' => 'public_profile,email'
		);
		redirect($this->facebook_lib->getLoginUrl($data));

	}

	public function handle_facebook_login(){
		$this->load->library('facebook/Facebook_lib');
		$facebook_user = $this->facebook_lib->user;
		if($facebook_user){

			if(isset($facebook_user['email']) && $facebook_user['email'] ){
				$resultado_cliente = $this->M_Intranet_Cliente->has_account($facebook_user['email']);
				if(count($resultado_cliente) == 1 && $resultado_cliente[0]->estado == '1'){
					$cliente = $resultado_cliente[0];
					$this->log_in($cliente->idCliente, $cliente->nombre_cliente, $cliente->apellido_cliente, $cliente->email_cliente);
					redirect('perfilc');
				}else{
//					$idCliente = $this->M_Intranet_Cliente->sign_up_from_facebook($facebook_user);
//					$this->log_in($idCliente, $facebook_user['first_name'],$facebook_user['last_name'],$facebook_user['email'] );
					redirect('register');
				}
			}

		}else{
			redirect('register');
		}

	}

	public function log_in($idCliente, $nombre, $apellido, $email){
		$sessionUser = array(
			'user_session'          => TRUE,
			'idCliente'             => $idCliente,
			'nombre_cliente'        => $nombre,
			'apellido_cliente'	    => $apellido,
			'email_cliente'	    	=> $email
		);
		$this->session->set_userdata($sessionUser);
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


		if ($this->input->post("txtEmail") && $this->input->post("txtPassword")) {

			$result = $this->M_Admin_Login->signIn(trim($this->input->post("txtEmail", TRUE)));
			if (sizeof($result) > 0 ) {
				$Usuario = $result[0];
				if ($this->cryptography->validateHash($Usuario->password, trim($this->input->post("txtPassword", TRUE)))) {

					$sessionUser = array(
						'user_session'          => TRUE,
						'id_usuario'            => intval($Usuario->id_usuario),
						'nombres_usuario'       => $Usuario->nombre,
						'apellidos_usuario'	    => $Usuario->apellidos,
						'usuario'	    		=> $Usuario->usuario,
						'email_usuario'		    => $Usuario->email
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