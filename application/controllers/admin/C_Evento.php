<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Evento extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_Evento');
        $this->load->model('admin/M_Admin_Usuario');
	}

	public function index()	{

        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Evento";

        $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario      = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;
        
        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Evento ";
        $modulo->titulo                    = "Evento ";
        $modulo->titulo_registro           = "Registro de Eventos ";
        $modulo->cabecera_registro         = array("Codigo Evento","Evento");
        $modulo->ruta_plantilla_registro   = "admin/evento/v-admin-evento-rows";
        $modulo->base_url                  = "admin/evento/";
        $modulo->api_rest_params           = array("delete" => "id_evento");
        $modulo->menu                      = array("menu" => 3, "submenu" => 6);
        $modulo->navegacion                = array(
                                                   array("nombre" => "Evento",
                                                        "url" => "",
                                                        "activo" => TRUE)
                                                );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/evento/page/";
        $total_row                         = $this->M_Admin_Evento->getTotal();
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

        $modulo->registros = $this->M_Admin_Evento->fetch($config["per_page"], ($page - 1) * 15);
        $str_links = $this->pagination->create_links();
        $modulo->links = explode('&nbsp;',$str_links );

        $data["modulo"] = $modulo;
        $this->load->view('admin/evento/v-admin-evento', $data);
	}

    public function agregar() {
        $modulo = new stdClass();

        $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario          = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
        $modulo->titulo                 = "Evento";
        $modulo->titulo_pagina          = "SERVOSA | Evento";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/evento/";
        $modulo->navegacion                = array(
            array("nombre" => "Evento",
                "url" => "",
                "activo" => TRUE)
        );
        $modulo->url_signout            = base_url()."admin/signOut";
        $modulo->url_main_panel         = base_url()."admin";


        $modulo->menu                   = array("menu" => 3, "submenu" => 6);
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/evento/v-admin-evento-editar', $data);
    }

    public function insertar() {

        $json                   = new stdClass();
        $json->type             = "Evento";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("txtCodigo") ) {
           
            /* Registrar Datos */
            $result1 = $this->M_Admin_Evento->insert(
                    array(
                            "nombre_evento"         => trim($this->input->post("txtNombre", TRUE)),
                            "codigo_evento"         => trim($this->input->post("txtCodigo", TRUE))
                    )
            );
            $json->message = "El Evento se creo correctamente.";
            array_push($json->data, array("id_evento" => $result1));
            $json->status = TRUE;
           


        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function editar($id) {
        $this->load->model("admin/M_Admin_Region");

        if (isset($id)) {
            $modulo = new stdClass();

            $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
            $modulo->datos_usuario          = $usuario[0];

            /* Datos de la cabecera del panel de administrador*/
            $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
            $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
            $modulo->titulo                 = "Evento";
            $modulo->titulo_pagina          = "SERVOSA | Evento";
            $modulo->nombreSeccion          = "Editar";
            $modulo->base_url               = "admin/evento/";
            $modulo->url_main_panel         = base_url()."admin";
            $modulo->menu                   = array("menu" => 2, "submenu" => 3);

            $result = $this->M_Admin_Evento->getByID($id);
            if (count($result) > 0) {
                $data["dataEmpresa"]    = $result[0];
                $data["existeEmpresa"]  = TRUE;
            } else {
                $data["dataEmpresa"]    = NULL;
                $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idEvento               = $id;
            $data["modulo"]                 = $modulo;
            $this->load->view('admin/evento/v-admin-evento-editar', $data);
        } else {
                redirect('/');
        }
    }

    public function actualizar() {


        $json                   = new stdClass();
        $json->type             = "Evento";
        $json->presentation     = "";
        $json->action           = "actualizar";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("txtCodigo") ) {
            
            /* Registrar Datos */
            $this->M_Admin_Evento->update(
                array(
                    "nombre_evento"         => trim($this->input->post("txtNombre", TRUE)),
                    "codigo_evento"         => trim($this->input->post("txtCodigo", TRUE))
                        
                ),
                trim($this->input->post("id_evento", TRUE))
            );
            
           
            $json->message = "El Evento se edito correctamente.";
            array_push($json->data, array("id_evento" =>  trim($this->input->post("id_evento", TRUE))));
            $json->status = TRUE;

                                                                
                      
        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
                
        echo json_encode($json);
    }


   

    public function eliminar() {


        $json 				= new stdClass();
        $json->type 		= "Evento";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_evento") ) {

                
                $result = $this->M_Admin_Evento->delete(trim($this->input->post("id_evento", TRUE)));

                $json->message = "El Evento se elimino correctamente.";
                $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }
    public function ajaxGenerateCodigo() {
        
        $json                           = new stdClass();
        $json->type                     = "Generate Codigo";
        $json->presentation             = "data";
        $json->action                   = "";

        $result                         = $this->M_Admin_Evento->getLastCode();
        $resultado                      = $result[0];

        /* CONSTRUIR CODIGO */
        $last_id                        = $resultado->id_evento;
        $number                         = $last_id + 1;

        if($number<10){
            $code   = "0".$number;
        }else{
            $code   = $number;
        }

        $json->data                     = array("codigo" => $code);
        $json->message                  = "Codigo generado correctamente.";
        $json->status                   = TRUE;

        echo json_encode($json);
    }


    
        
}