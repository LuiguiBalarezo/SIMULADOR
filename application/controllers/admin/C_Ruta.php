<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Ruta extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_Rutas');
        $this->load->model('admin/M_Admin_Usuario');
	}

	

    public function rutas($id){
        $this->load->model('admin/M_Admin_Operacion');
        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Rutas";

        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;


        $modulo->nombre                    = "Rutas ";
        $modulo->titulo                    = "Rutas ";
        $modulo->titulo_registro           = "Registro de Rutas ";
        $modulo->cabecera_registro         = array("Rutas");
        $modulo->ruta_plantilla_registro   = "admin/rutas/v-admin-rutas-rows";
        $modulo->base_url                  = "admin/rutas/";
        $modulo->api_rest_params           = array("delete" => "id_ruta");
        $modulo->menu                      = array("menu" => 2, "submenu" => 4);
        $modulo->navegacion                = array(
            array("nombre" => "Rutas",
                "url" => "",
                "activo" => TRUE,
                )
        );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/rutas/".$this->uri->segment(3)."/page/";
        $total_row                         = $this->M_Admin_Rutas->getTotal($id);
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

        $modulo->registros = $this->M_Admin_Rutas->fetch($config["per_page"], ($page - 1) * 15,$id);
       
        $str_links = $this->pagination->create_links();
        $modulo->links          = explode('&nbsp;',$str_links );
        $operacion              = $this->M_Admin_Operacion->getByID($id);
        $modulo->operacion      = $operacion[0];
        $data["modulo"] = $modulo;
        $this->load->view('admin/rutas/v-admin-rutas', $data);
    }

    public function agregar($id) {
        $this->load->model("admin/M_Admin_Operacion");
        $modulo = new stdClass();

        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;

        $modulo->titulo                     = "Rutas";
        $modulo->titulo_pagina              = "SERVOSA | Rutas";
        $modulo->nombreSeccion              = "Agregar";
        $modulo->base_url                   = "admin/rutas/";
        


        $modulo->id                     = $id;
        $modulo->menu                   = array("menu" => 2, "submenu" => 4);
        $modulo->operacion              = $this->M_Admin_Operacion->getOperacion();
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/rutas/v-admin-rutas-editar', $data);
    }

    public function insertar() {

        $json                   = new stdClass();
        $json->type             = "Ruta";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("id_operacion") ) {

            /* Registrar Datos */
            $result1 = $this->M_Admin_Rutas->insert(
                    array(
                            "nombre_ruta"  => trim($this->input->post("txtNombre", TRUE)),
                            "id_operacion"         => trim($this->input->post("id_operacion", TRUE))
                    )
            );
            $json->message = "La Ruta se creo correctamente.";
            array_push($json->data, array("id_ruta" => $result1));
            $json->status = TRUE;

        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function editar($id) {
        $this->load->model("admin/M_Admin_Operacion");

        if (isset($id)) {
            $modulo = new stdClass();

            $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
            $modulo->datos_usuario              = $usuario[0];
            /* Datos de la cabecera del panel de administrador*/
            $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
            $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;
            
            $modulo->titulo                     = "Rutas";
            
            $modulo->nombreSeccion              = "Editar";
            $modulo->base_url                   = "admin/rutas/";
            $modulo->url_main_panel             = base_url()."admin";
            $modulo->menu                       = array("menu" => 2, "submenu" => 4);

            $result = $this->M_Admin_Rutas->getByID($id);
            if (count($result) > 0) {
                $data["dataEmpresa"]    = $result[0];
                $data["existeEmpresa"]  = TRUE;
            } else {
                $data["dataEmpresa"]    = NULL;
                $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idRuta                 = $id;
            $modulo->operacion              = $this->M_Admin_Operacion->getOperacion();
            $data["modulo"]                 = $modulo;
            $this->load->view('admin/rutas/v-admin-rutas-editar', $data);
        } else {
                redirect('/');
        }
    }

    public function actualizar() {


        $json                   = new stdClass();
        $json->type             = "Ruta";
        $json->presentation     = "";
        $json->action           = "actualizar";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("id_operacion") ) {
            
            /* Registrar Datos */
            $result1 = $this->M_Admin_Rutas->update(
                array(
                        "nombre_ruta"         => trim($this->input->post("txtNombre", TRUE)),
                        "id_operacion"      => trim($this->input->post("id_operacion", TRUE))
                        
                ),
                trim($this->input->post("id_ruta", TRUE))
            );
            
           
            $json->message = "La Ruta se edito correctamente.";
            array_push($json->data, array("id_operacion" =>  trim($this->input->post("id_operacion", TRUE))));
            $json->status = TRUE;

                                                                
                      
        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
                
        echo json_encode($json);
    }


   

    public function eliminar() {

        $json 				= new stdClass();
        $json->type 		= "Ruta";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id") ) {

                
                $result = $this->M_Admin_Rutas->delete(trim($this->input->post("id", TRUE)));

                $json->message = "La Ruta se elimino correctamente.";
                $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    
        
}