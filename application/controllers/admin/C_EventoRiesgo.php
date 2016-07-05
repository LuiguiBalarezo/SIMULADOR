<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_EventoRiesgo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->load->model('admin/M_Admin_EventoRiesgo');
        $this->load->model('admin/M_Admin_Usuario');
        $this->usersession->validatePanelEvento();
	}

	public function index()	{

        $this->load->model('admin/M_Admin_Operacion');
        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Evento de Riesgo";

        $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario      = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;

        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Evento de Riesgo ";
        $modulo->titulo                    = "Evento de Riesgo ";
        $modulo->titulo_registro           = "Registro de Evento de Riesgo ";
        $modulo->cabecera_registro         = array("Region", "Operacion", "Ruta", "Tramo", "Placa", "Fecha Registro", "Evento","Categoria", "Tipo", "Descripcion");
        $modulo->ruta_plantilla_registro   = "admin/eventoriesgo/v-admin-eventoriesgo-rows";
        $modulo->base_url                  = "admin/eventoriesgo/";
        $modulo->api_rest_params           = array("delete" => "id_operacion");
        $modulo->menu                      = array("menu" => 4, "submenu" => 0);
        $modulo->navegacion                = array(
            array("nombre" => "Evento de Riesgo",
                "url" => "",
                "activo" => TRUE)
        );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/eventoriesgo/page/";
        $total_row                         = $this->M_Admin_EventoRiesgo->getTotalEventosRiesgo($usuario[0]->id_usuario);
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

        $modulo->registros = $this->M_Admin_EventoRiesgo->fetchEventoRiesgo($config["per_page"], ($page - 1) * 15,$usuario[0]->id_usuario);
        $str_links = $this->pagination->create_links();
        $modulo->links = explode('&nbsp;',$str_links );



        $data["modulo"] = $modulo;
        $this->load->view('admin/eventoriesgo/v-admin-eventoriesgo', $data);
	}


    public function agregar() {
        $this->load->model("admin/M_Admin_OperacionUsuario");
        $this->load->model("admin/M_Admin_Evento");

        $modulo = new stdClass();

        $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario          = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
        $modulo->titulo                 = "Evento de Riesgo";
        $modulo->titulo_pagina          = "SERVOSA | Evento de Riesgo";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/eventoriesgo/";
        $modulo->menu                      = array("menu" => 4, "submenu" => 0);

        $modulo->operacion              = $this->M_Admin_OperacionUsuario->getByID($usuario[0]->id_usuario);
        $modulo->evento                 = $this->M_Admin_Evento->getEvento();
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/eventoriesgo/v-admin-eventoriesgo-editar', $data);
    }

    public function insertar() {
        $this->load->model('admin/M_Admin_Usuario');
        $this->load->library('security/Cryptography');

        $usuario                = $this->M_Admin_Usuario->getByID($this->session->id_usuario);

        $json                   = new stdClass();
        $json->type             = "Evento de Riesgo";
        $json->presentation = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("cboTramo") &&
            $this->input->post("cboEvento") &&
            $this->input->post("cboCategoria") &&
            $this->input->post("cboPlaca") &&
            $this->input->post("txtFecha") &&
            $this->input->post("txtDescripcion")
            ) {

                /* Registrar Datos */
                $result1 = $this->M_Admin_EventoRiesgo->insert(
                    array(
                            "id_usuario"            => $usuario[0]->id_usuario,
                            "id_tramo"              => trim($this->input->post("cboTramo", TRUE)),
                            "id_evento"             => trim($this->input->post("cboEvento", TRUE)),
                            "id_categoria"          => trim($this->input->post("cboCategoria", TRUE)),
                            "id_tipo"               => trim($this->input->post("cboTipo", TRUE)),
                            "id_placa"              => trim($this->input->post("cboPlaca", TRUE)),
                            "fecha_registro"        => trim($this->input->post("txtFecha", TRUE)),
                            "descripcion"           => trim($this->input->post("txtDescripcion", TRUE))
                    )
                );

                $json->message = "El Evento de Riesgo se creo correctamente.";
                array_push($json->data, array("id_evento_riesgo" => $result1));
                $json->status = TRUE;

        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function getRutas() {
        $this->load->model("admin/M_Admin_Rutas");

        $json 				= new stdClass();
        $json->type 		= "Ruta";
        $json->presentation = "";
        $json->action 		= "obtener";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_operacion") ) {


            $result = $this->M_Admin_Rutas->getRutasbyID(trim($this->input->post("id_operacion", TRUE)));
            if (count($result) > 0) {
                $json->data = $result;
                $json->message = "Lista de Rutas.";
                $json->status 	= TRUE;
            } else {
                $json->message = "Ocurrio un error al obtener las Rutas, intente de nuevo.";
            }


        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }
    public function getTramos() {
        $this->load->model("admin/M_Admin_Tramos");

        $json 				= new stdClass();
        $json->type 		= "Tramos";
        $json->presentation = "";
        $json->action 		= "obtener";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_ruta") ) {


            $result = $this->M_Admin_Tramos->getTramosbyID(trim($this->input->post("id_ruta", TRUE)));
            if (count($result) > 0) {
                $json->data = $result;
                $json->message = "Lista de Tramos.";
                $json->status 	= TRUE;
            } else {
                $json->message = "Ocurrio un error al obtener los Tramos, intente de nuevo.";
            }


        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }
    public function getPlacas() {
        $this->load->model("admin/M_Admin_Placas");

        $json 				= new stdClass();
        $json->type 		= "Placa";
        $json->presentation = "";
        $json->action 		= "obtener";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_operacion") ) {


            $result = $this->M_Admin_Placas->getPlacasbyID(trim($this->input->post("id_operacion", TRUE)));
            if (count($result) > 0) {
                $json->data = $result;
                $json->message = "Lista de Placas.";
                $json->status 	= TRUE;
            } else {
                $json->message = "Ocurrio un error al obtener las Placas, intente de nuevo.";
            }


        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function getCategorias() {
        $this->load->model("admin/M_Admin_Categoria");

        $json 				= new stdClass();
        $json->type 		= "Categoria";
        $json->presentation = "";
        $json->action 		= "obtener";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_evento") ) {


            $result = $this->M_Admin_Categoria->getCategoriasbyID(trim($this->input->post("id_evento", TRUE)));
            if (count($result) > 0) {
                $json->data = $result;
                $json->message = "Lista de Categorias.";
                $json->status 	= TRUE;
            } else {
                $json->message = "Ocurrio un error al obtener las Categorias, intente de nuevo.";
            }


        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function getTipos() {
        $this->load->model("admin/M_Admin_Tipo");

        $json 				= new stdClass();
        $json->type 		= "Tipos";
        $json->presentation = "";
        $json->action 		= "obtener";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_categoria") ) {


            $result = $this->M_Admin_Tipo->getTiposbyID(trim($this->input->post("id_categoria", TRUE)));
            if (count($result) > 0) {
                $json->data = $result;
                $json->message = "Lista de Tipos.";
                $json->status 	= TRUE;
            } else {
                $json->message = "Ocurrio un error al obtener los Tipos, intente de nuevo.";
            }


        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }




}