<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ListadoEventos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('utils/UserSession');
		$this->usersession->validateSession();
		$this->load->model('admin/M_Admin_EventoRiesgo');
		$this->load->model('admin/M_Admin_Usuario');
	}

	public function all()	{

		$this->load->model('admin/M_Admin_Operacion');
		$this->load->library('pagination');
		$modulo = new stdClass();
		$modulo->titulo_pagina = "SERVOSA | Eventos de Riesgo";

		$usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
		$modulo->datos_usuario      = $usuario[0];

		/* Datos de la cabecera del panel de administrador*/
		$modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
		$modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;

		$modulo->url_signout = base_url()."admin/signOut";
		$modulo->url_main_panel = base_url()."admin";

		$modulo->nombre                    = "Eventos de Riesgo ";
		$modulo->titulo                    = "Eventos de Riesgo ";
		$modulo->titulo_registro           = "Registro de Eventos de Riesgo ";
		$modulo->cabecera_registro         = array("Region", "Operacion", "Ruta", "Tramo", "Placa", "Fecha Registro", "Evento","Categoria", "Tipo","Observador", "Descripcion");
		$modulo->ruta_plantilla_registro   = "admin/eventoriesgos/v-admin-eventoriesgo-rows";
		$modulo->base_url                  = "admin/eventoriesgos/";
		$modulo->api_rest_params           = array("delete" => "id_operacion");
		$modulo->menu                      = array("menu" => 6, "submenu" => 0);
		$modulo->navegacion                = array(
			array("nombre" => "Evento de Riesgo",
				"url" => "",
				"activo" => TRUE)
		);

		$config                            = array();
		$config["base_url"]                = base_url() . "admin/eventoriesgos/page/";
		$total_row                         = $this->M_Admin_EventoRiesgo->getTotalEventosRiesgoAll();
		$config["total_rows"]              = $total_row;
		$config["per_page"]                = 15;
		$config['use_page_numbers']        = TRUE;
		$config['cur_tag_open']            = '&nbsp;<a class="current">';
		$config['cur_tag_close']           = '</a>';
		$config['next_link']               = 'Siguiente';
		$config['prev_link']               = 'Anterior';
		$config['first_link']              = 'Primero';
		$config['last_link']               = 'Ultimo';
		$config["uri_segment"]             = 4;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

		$modulo->registros = $this->M_Admin_EventoRiesgo->fetchEventoRiesgoAll($config["per_page"], ($page - 1) * 15);
		$str_links = $this->pagination->create_links();
		$modulo->links = explode('&nbsp;',$str_links );



		$data["modulo"] = $modulo;
		$this->load->view('admin/eventoriesgos/v-admin-eventoriesgo', $data);
	}

	public function eliminar() {


		$json 				= new stdClass();
		$json->type 		= "Evento de Riesgo";
		$json->presentation = "";
		$json->action 		= "delete";
		$json->data 		= array();
		$json->status 		= FALSE;

		if ( $this->input->post("id_evento_riesgo") ) {


			$result = $this->M_Admin_EventoRiesgo->delete(trim($this->input->post("id_evento_riesgo", TRUE)));

			$json->message = "El Evento de Riesgo se elimino correctamente.";
			$json->status = TRUE;

		} else {
			$json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
		}

		echo json_encode($json);
	}


}
