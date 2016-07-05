<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Tramo extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_Tramos');
        $this->load->model('admin/M_Admin_Usuario');
	}

	public function tramos($id)	{

        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Tramos";

        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;

        $modulo->nombre                    = "Tramos ";
        $modulo->titulo                    = "Tramos ";
        $modulo->titulo_registro           = "Registro de Tramos ";
        $modulo->cabecera_registro         = array("Tramos","Velocidad");
        $modulo->ruta_plantilla_registro   = "admin/tramos/v-admin-tramos-rows";
        $modulo->base_url                  = "admin/tramos/";
        $modulo->api_rest_params           = array("delete" => "id_tramos");
        $modulo->menu                      = array("menu" => 2, "submenu" => 5);
        $modulo->navegacion                = array(
            array("nombre" => "Tramos",
                "url" => "",
                "activo" => TRUE)
        );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/tramos/".$this->uri->segment(3)."/page/";
        $total_row                         = $this->M_Admin_Tramos->getTotal($id);
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

        $modulo->registros      = $this->M_Admin_Tramos->fetch($config["per_page"], ($page - 1) * 15,$id);
       
        $str_links              =  $this->pagination->create_links();
        $modulo->links          =  explode('&nbsp;',$str_links );
        $modulo->id             =  $id;
        $operacion              =  $this->M_Admin_Tramos->getOperacion($id);
        $modulo->operacion      =  $operacion[0];
        $data["modulo"]         =  $modulo;
        $this->load->view('admin/tramos/v-admin-tramos', $data);
    }

    public function agregar($id) {
        $this->load->model("admin/M_Admin_Rutas");
        $modulo = new stdClass();

        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;
        $modulo->titulo                 = "Tramos";
        $modulo->titulo_pagina          = "SERVOSA | Tramos";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/tramos/";
        
        $modulo->url_signout            = base_url()."admin/signOut";
        $modulo->url_main_panel         = base_url()."admin";

        $modulo->id                     = $id;
        $modulo->menu                   = array("menu" => 2, "submenu" => 5);
        $modulo->rutas                  = $this->M_Admin_Rutas->getRutas();
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/tramos/v-admin-tramos-editar', $data);
    }

    public function insertar() {

        $json                   = new stdClass();
        $json->type             = "Tramos";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("txtVelocidad") && $this->input->post("id_ruta") ) {

            /* Registrar Datos */
            $result1 = $this->M_Admin_Tramos->insert(
                    array(
                            "nombre_tramo"      => trim($this->input->post("txtNombre", TRUE)),
                            "velocidad"         => trim($this->input->post("txtVelocidad", TRUE)),
                            "id_ruta"           => trim($this->input->post("id_ruta", TRUE))
                    )
            );
            $json->message = "El Tramo se creo correctamente.";
            array_push($json->data, array("id_tramo" => $result1));
            $json->status = TRUE;

        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function editar($id) {
        $this->load->model("admin/M_Admin_Rutas");

        if (isset($id)) {
            $modulo = new stdClass();
            
            $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
            $modulo->datos_usuario              = $usuario[0];
            /* Datos de la cabecera del panel de administrador*/
            $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
            $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;
            
            $modulo->titulo                 = "Tramos";
            $modulo->titulo_pagina          = "SERVOSA | Tramos";
            
            $modulo->nombreSeccion          = "Editar";
            $modulo->base_url               = "admin/tramos/";
            $modulo->url_main_panel         = base_url()."admin";
            $modulo->menu                   = array("menu" => 2, "submenu" => 5);
            $modulo->url_signout            = base_url()."admin/signOut";
            $modulo->url_main_panel         = base_url()."admin";

            $result = $this->M_Admin_Tramos->getByID($id);
            if (count($result) > 0) {
                $data["dataEmpresa"]    = $result[0];
                $data["existeEmpresa"]  = TRUE;
            } else {
                $data["dataEmpresa"]    = NULL;
                $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idTramo                = $id;
            $modulo->rutas                  = $this->M_Admin_Rutas->getRutas();
            $data["modulo"]                 = $modulo;
            $this->load->view('admin/tramos/v-admin-tramos-editar', $data);
        } else {
                redirect('/');
        }
    }

    public function actualizar() {

        $json                   = new stdClass();
        $json->type             = "Tramos";
        $json->presentation     = "";
        $json->action           = "actualizar";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("txtVelocidad") && $this->input->post("id_ruta") ) {
            
            /* Registrar Datos */
            $result1 = $this->M_Admin_Tramos->update(
                array(
                        "nombre_tramo"              => trim($this->input->post("txtNombre", TRUE)),
                        "velocidad"                 => trim($this->input->post("txtVelocidad", TRUE)),
                        "id_ruta"                   => trim($this->input->post("id_ruta", TRUE))
                        
                ),
                trim($this->input->post("id_tramo", TRUE))
            );
            
           
            $json->message = "El tramo se edito correctamente.";
            array_push($json->data, array("id_tramo" =>  trim($this->input->post("id_tramo", TRUE))));
            $json->status = TRUE;

                                                                
                      
        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
                
        echo json_encode($json);
    }


   

    public function eliminar() {


        $json 				= new stdClass();
        $json->type 		= "Tramo";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_tramo") ) {

                
                $result = $this->M_Admin_Tramos->delete(trim($this->input->post("id_tramo", TRUE)));

                $json->message = "El Tramo se elimino correctamente.";
                $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }
        
}