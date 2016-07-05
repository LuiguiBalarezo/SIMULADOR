<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Tipo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_Tipo');
        $this->load->model('admin/M_Admin_Usuario');
	}

	

    public function tipo($id){
        $this->load->model('admin/M_Admin_Categoria');
        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Tipo";

        $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario      = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;

        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Tipo ";
        $modulo->titulo                    = "Tipo ";
        $modulo->titulo_registro           = "Registro de Tipos ";
        $modulo->cabecera_registro         = array("Codigo Tipo","Tipo");
        $modulo->ruta_plantilla_registro   = "admin/tipo/v-admin-tipo-rows";
        $modulo->base_url                  = "admin/tipo/";
        $modulo->api_rest_params           = array("delete" => "id_tipo");
        $modulo->menu                      = array("menu" => 3, "submenu" =>8);
        $modulo->navegacion                = array(
            array("nombre" => "Tipo",
                "url" => "",
                "activo" => TRUE,
                )
        );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/tipo/".$this->uri->segment(3)."/page/";
        $total_row                         = $this->M_Admin_Tipo->getTotal($id);
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

        $modulo->registros = $this->M_Admin_Tipo->fetch($config["per_page"], ($page - 1) * 15,$id);

        $str_links = $this->pagination->create_links();
        $modulo->links          =  explode('&nbsp;',$str_links );
        $modulo->id             =  $id;
        $evento                 =  $this->M_Admin_Tipo->getEvento($id);
        $modulo->evento         =  $evento[0];
        $data["modulo"] = $modulo;
        $this->load->view('admin/tipo/v-admin-tipo', $data);
    }

    public function agregar($id) {
        $this->load->model("admin/M_Admin_Categoria");
        $modulo = new stdClass();

        $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario      = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;

        $modulo->titulo                 = "Tipo";
        $modulo->titulo_pagina          = "SERVOSA | Tipo";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/tipo/";
        
        $modulo->url_signout            = base_url()."admin/signOut";
        $modulo->url_main_panel         = base_url()."admin";

        $modulo->id                     = $id;
        $modulo->menu                   = array("menu" => 3, "submenu" => 8);
        $modulo->categoria              = $this->M_Admin_Categoria->getCategoria();
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/tipo/v-admin-tipo-editar', $data);
    }

    public function insertar() {

        $json                   = new stdClass();
        $json->type             = "Tipo";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("txtCodigo") && $this->input->post("id_categoria") ) {
            /* Validar Datos */
            $validate = $this->M_Admin_Tipo->getByName(trim($this->input->post("txtNombre", TRUE)));
            if (sizeof($validate) == 0) {
                /* Registrar Datos */
                $result1 = $this->M_Admin_Tipo->insert(
                    array(
                        "nombre_tipo"          => trim($this->input->post("txtNombre", TRUE)),
                        "codigo_tipo"          => trim($this->input->post("txtCodigo", TRUE)),
                        "id_categoria"                 => trim($this->input->post("id_categoria", TRUE))

                    )
                );
                $json->message = "El Tipo se creo correctamente.";
                array_push($json->data, array("id_ruta" => $result1));
                $json->status = TRUE;
            } else {
                $json->message = "Lo sentimos el Tipo ya existe, intente de nuevo.";
            }



        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function editar($id) {
        $this->load->model("admin/M_Admin_Categoria");

        if (isset($id)) {
            $modulo = new stdClass();

            $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
            $modulo->datos_usuario      = $usuario[0];

            /* Datos de la cabecera del panel de administrador*/
            $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
            $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
            $modulo->titulo                 = "Tipo";
            $modulo->titulo_pagina          = "SERVOSA | Tipo ";
            $modulo->nombreSeccion          = "Editar";
            $modulo->base_url               = "admin/tipo/";
            $modulo->url_main_panel         = base_url()."admin";
            $modulo->menu                   = array("menu" => 3, "submenu" => 8);

            $result = $this->M_Admin_Tipo->getByID($id);
            if (count($result) > 0) {
                $data["dataEmpresa"]    = $result[0];
                $data["existeEmpresa"]  = TRUE;
            } else {
                $data["dataEmpresa"]    = NULL;
                $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idTipo                 = $id;
            $modulo->categoria              = $this->M_Admin_Categoria->getCategoria();
            $data["modulo"]                 = $modulo;
            $this->load->view('admin/tipo/v-admin-tipo-editar', $data);
        } else {
                redirect('/');
        }
    }

    public function actualizar() {
        
        $json                   = new stdClass();
        $json->type             = "Tipo";
        $json->presentation     = "";
        $json->action           = "actualizar";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("txtCodigo") && $this->input->post("id_categoria") ) {
            
            /* Registrar Datos */
            $result1 = $this->M_Admin_Tipo->update(
                array(
                        "nombre_tipo"          => trim($this->input->post("txtNombre", TRUE)),
                        "codigo_tipo"          => trim($this->input->post("txtCodigo", TRUE)),
                        "id_categoria"                 => trim($this->input->post("id_categoria", TRUE))
                        
                ),
                trim($this->input->post("id_tipo", TRUE))
            );
            
           
            $json->message = "El Tipo se edito correctamente.";
            array_push($json->data, array("id_tipo" =>  trim($this->input->post("id_tipo", TRUE))));
            $json->status = TRUE;

                                                                
                      
        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
                
        echo json_encode($json);
    }


   

    public function eliminar() {
        
        $json 				= new stdClass();
        $json->type 		= "Tipo";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id") ) {
            
            $this->M_Admin_Tipo->delete(trim($this->input->post("id", TRUE)));

            $json->message = "EL Tipo se elimino correctamente.";
            $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function ajaxGenerateCodigo() {
        $this->load->model('admin/M_Admin_Categoria');
        $json                           = new stdClass();
        $json->type                     = "Generate Codigo";
        $json->presentation             = "data";
        $json->action                   = "";

        $result0                        = $this->M_Admin_Categoria->getByID($this->input->post("id_categoria"));
        $resultado0                     = $result0[0];
        $codeCategoria                  = $resultado0->codigo_categoria;

        $result                         = $this->M_Admin_Tipo->getLastCode($resultado0->id_categoria);
        $resultado                      = $result[0];

        /* CONSTRUIR CODIGO */
        $last_id                        = $resultado->id_tipo;
        $number                         = $last_id + 1;

        if($number<10){
            $code   = "0".$number;
        }else{
            $code   = $number;
        }

        $codeTipo                  = $codeCategoria.$code;

        $json->data                     = array("codigo" => $codeTipo);
        $json->message                  = "Codigo generado correctamente.";
        $json->status                   = TRUE;

        echo json_encode($json);
    }
        
}