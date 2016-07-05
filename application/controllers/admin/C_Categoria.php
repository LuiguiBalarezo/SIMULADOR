<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Categoria extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_Categoria');
        $this->load->model('admin/M_Admin_Usuario');
	}

	

    public function categoria($id){
        $this->load->model('admin/M_Admin_Evento');
        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Categoria";

        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;

        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Categoria ";
        $modulo->titulo                    = "Categoria ";
        $modulo->titulo_registro           = "Registro de Categoria ";
        $modulo->cabecera_registro         = array("Codigo Categoria","Categoria");
        $modulo->ruta_plantilla_registro   = "admin/categoria/v-admin-categoria-rows";
        $modulo->base_url                  = "admin/categoria/";
        $modulo->api_rest_params           = array("delete" => "id_categoria");
        $modulo->menu                      = array("menu" => 3, "submenu" =>7);
        $modulo->navegacion                = array(
            array("nombre" => "Categoria",
                "url" => "",
                "activo" => TRUE,
                )
        );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/categoria/".$this->uri->segment(3)."/page/";
        $total_row                         = $this->M_Admin_Categoria->getTotal($id);
        $config["total_rows"]              = $total_row;
        $config["per_page"]                = 15;
        $config['use_page_numbers']        = TRUE;
        $config['cur_tag_open']            = '&nbsp;<a class="current">';
        $config['cur_tag_close']           = '</a>';
        $config['next_link']               = 'Siguiente';
        $config['prev_link']               = 'Anterior';
        $config['first_link']              = 'Primero';
        $config['last_link']               = 'Ultimo';
        $config["uri_segment"]             = 5;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;

        $modulo->registros = $this->M_Admin_Categoria->fetch($config["per_page"], ($page - 1) * 15,$id);
       
        $str_links = $this->pagination->create_links();
        $modulo->links          = explode('&nbsp;',$str_links );
        $evento              = $this->M_Admin_Evento->getByID($id);
        $modulo->evento      = $evento[0];
        $data["modulo"] = $modulo;
        $this->load->view('admin/categoria/v-admin-categoria', $data);
    }

    public function agregar($id) {
        $this->load->model("admin/M_Admin_Evento");
        $modulo = new stdClass();

        $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario          = $usuario[0];
    
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
        $modulo->titulo                 = "Categoria";
        $modulo->titulo_pagina          = "SERVOSA | Categoria";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/categoria/";
        
        $modulo->url_signout            = base_url()."admin/signOut";
        $modulo->url_main_panel         = base_url()."admin";

        $modulo->id                     = $id;
        $modulo->menu                   = array("menu" => 2, "submenu" => 7);
        $modulo->evento                 = $this->M_Admin_Evento->getEvento();
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/categoria/v-admin-categoria-editar', $data);
    }

    public function insertar() {

        $json                   = new stdClass();
        $json->type             = "Categoria";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("txtCodigo") && $this->input->post("id_evento")) {

            $result1 = $this->M_Admin_Categoria->insert(
                    array(
                        "nombre_categoria"          => trim($this->input->post("txtNombre", TRUE)),
                        "codigo_categoria"          => trim($this->input->post("txtCodigo", TRUE)),
                        "id_evento"                 => trim($this->input->post("id_evento", TRUE))
                    )
            );
            $json->message = "La Categoria se creo correctamente.";
            array_push($json->data, array("id_categoria" => $result1));
            $json->status = TRUE;


        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function editar($id) {
        $this->load->model("admin/M_Admin_Evento");

        if (isset($id)) {
            $modulo = new stdClass();

            $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
            $modulo->datos_usuario          = $usuario[0];

            /* Datos de la cabecera del panel de administrador*/
            $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
            $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
            $modulo->titulo                 = "Categoria";
            $modulo->titulo_pagina          = "SERVOSA | Categoria";
            $modulo->nombreSeccion          = "Editar";
            $modulo->base_url               = "admin/categoria/";
            $modulo->url_main_panel         = base_url()."admin";
            $modulo->menu                   = array("menu" => 2, "submenu" => 7);

            $result = $this->M_Admin_Categoria->getByID($id);
            if (count($result) > 0) {
                $data["dataEmpresa"]    = $result[0];
                $data["existeEmpresa"]  = TRUE;
            } else {
                $data["dataEmpresa"]    = NULL;
                $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idCategoria            = $id;
            $modulo->evento                 = $this->M_Admin_Evento->getEvento();
            $data["modulo"]                 = $modulo;
            $this->load->view('admin/categoria/v-admin-categoria-editar', $data);
        } else {
                redirect('/');
        }
    }

    public function actualizar() {
        
        $json                   = new stdClass();
        $json->type             = "Categoria";
        $json->presentation     = "";
        $json->action           = "actualizar";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("txtCodigo") && $this->input->post("id_evento")) {
            
            /* Registrar Datos */
            $result1 = $this->M_Admin_Categoria->update(
                array(
                        "nombre_categoria"          => trim($this->input->post("txtNombre", TRUE)),
                        "codigo_categoria"          => trim($this->input->post("txtCodigo", TRUE)),
                        "id_evento"                 => trim($this->input->post("id_evento", TRUE))
                        
                ),
                trim($this->input->post("id_categoria", TRUE))
            );
            
           
            $json->message = "La Categoria se edito correctamente.";
            array_push($json->data, array("id_categoria" =>  trim($this->input->post("id_categoria", TRUE))));
            $json->status = TRUE;

                                                                
                      
        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
                
        echo json_encode($json);
    }


   

    public function eliminar() {
        
        $json 				= new stdClass();
        $json->type 		= "Categoria";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id") ) {
            
            $this->M_Admin_Categoria->delete(trim($this->input->post("id", TRUE)));

            $json->message = "La Categoria se elimino correctamente.";
            $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function ajaxGenerateCodigo() {
        $this->load->model('admin/M_Admin_Evento');
        $json                           = new stdClass();
        $json->type                     = "Generate Codigo";
        $json->presentation             = "data";
        $json->action                   = "";

        $result0                        = $this->M_Admin_Evento->getByID($this->input->post("id_evento"));
        $resultado0                     = $result0[0];
        $codeEvento                     = $resultado0->codigo_evento;

        $result                         = $this->M_Admin_Categoria->getLastCode($resultado0->id_evento);
        $resultado                      = $result[0];

        /* CONSTRUIR CODIGO */
        $last_id                        = $resultado->id_categoria;
        $number                         = $last_id + 1;

        if($number<10){
            $code   = "0".$number;
        }else{
            $code   = $number;
        }

        $codeCategoria                  = $codeEvento.$code;

        $json->data                     = array("codigo" => $codeCategoria);
        $json->message                  = "Codigo generado correctamente.";
        $json->status                   = TRUE;

        echo json_encode($json);
    }
        
}