<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Placa extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_Placas');
        $this->load->model('admin/M_Admin_Usuario');
	}

    public function placas($id)	{
        $this->load->model('admin/M_Admin_Operacion');
        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Placas";

        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;

        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Placas ";
        $modulo->titulo                    = "Placas ";
        $modulo->titulo_registro           = "Registro de Placas ";
        $modulo->cabecera_registro         = array("Placas");
        $modulo->ruta_plantilla_registro   = "admin/placas/v-admin-placas-rows";
        $modulo->base_url                  = "admin/placas/";
        $modulo->api_rest_params           = array("delete" => "id_operacion");
        $modulo->menu                      = array("menu" => 2, "submenu" => 6);
        $modulo->navegacion                = array(
            array("nombre" => "Operacion",
                "url" => "",
                "activo" => TRUE)
        );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/placas/".$this->uri->segment(3)."/page/";
        $total_row                         = $this->M_Admin_Placas->getTotal($id);
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

        $modulo->registros = $this->M_Admin_Placas->fetch($config["per_page"], ($page - 1) * 15,$id);
       
        $str_links = $this->pagination->create_links();
        $modulo->links = explode('&nbsp;',$str_links );
        $operacion              = $this->M_Admin_Operacion->getByID($id);
        $modulo->operacion      = $operacion[0];

        $data["modulo"] = $modulo;
        $this->load->view('admin/placas/v-admin-placas', $data);
    }

    public function agregar($id) {
        $this->load->model("admin/M_Admin_Operacion");
        $modulo = new stdClass();
        
        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;
 
        $modulo->titulo                 = "Placas";
        $modulo->titulo_pagina          = "SERVOSA | Placas";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/placas/";
        
        $modulo->url_signout            = base_url()."admin/signOut";
        $modulo->url_main_panel         = base_url()."admin";

        $modulo->id                     = $id;
        $modulo->menu                   = array("menu" => 2, "submenu" => 6);
        $modulo->operacion              = $this->M_Admin_Operacion->getOperacion();
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/placas/v-admin-placas-editar', $data);
    }

    public function insertar() {

        $json                   = new stdClass();
        $json->type             = "Placas";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("id_operacion") ) {
            /* Validar Datos */
            $validate = $this->M_Admin_Placas->getByName(trim($this->input->post("txtNombre", TRUE)));
            if (sizeof($validate) == 0) {
                /* Registrar Datos */
                $result1 = $this->M_Admin_Placas->insert(
                        array(
                                "placa"  => trim($this->input->post("txtNombre", TRUE)),
                                "id_operacion"      => trim($this->input->post("id_operacion", TRUE))
                        )
                );
                $json->message = "La Placa se creo correctamente.";
                array_push($json->data, array("id_operacion" => $result1));
                $json->status = TRUE;
            } else {
                $json->message = "Lo sentimos la Placa ya existe, intente de nuevo.";
            }



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

            $modulo->titulo                 = "Placas";
            $modulo->titulo_pagina          = "SERVOSA | Placas";
            $modulo->nombreSeccion          = "Editar";
            $modulo->base_url               = "admin/placas/";
            $modulo->url_main_panel         = base_url()."admin";
            $modulo->menu                   = array("menu" => 2, "submenu" => 6);

            $result = $this->M_Admin_Placas->getByID($id);
            if (count($result) > 0) {
                $data["dataEmpresa"]    = $result[0];
                $data["existeEmpresa"]  = TRUE;
            } else {
                $data["dataEmpresa"]    = NULL;
                $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idPlaca                = $id;
            $modulo->operacion              = $this->M_Admin_Operacion->getOperacion();
            $data["modulo"]                 = $modulo;
            $this->load->view('admin/placas/v-admin-placas-editar', $data);
        } else {
                redirect('/');
        }
    }

    public function actualizar() {


        $json                   = new stdClass();
        $json->type             = "Placas";
        $json->presentation     = "";
        $json->action           = "actualizar";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("id_operacion") ) {
            
            /* Registrar Datos */
            $result1 = $this->M_Admin_Placas->update(
                array(
                        "placa"         => trim($this->input->post("txtNombre", TRUE)),
                        "id_operacion"      => trim($this->input->post("id_operacion", TRUE))
                        
                ),
                trim($this->input->post("id_placa", TRUE))
            );
            
           
            $json->message = "La Placa se edito correctamente.";
            array_push($json->data, array("id_placa" =>  trim($this->input->post("id_placa", TRUE))));
            $json->status = TRUE;

                                                                
                      
        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
                
        echo json_encode($json);
    }


   

    public function eliminar() {


        $json 				= new stdClass();
        $json->type 		= "Placas";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_placa") ) {

                
                $result = $this->M_Admin_Placas->delete(trim($this->input->post("id_placa", TRUE)));

                $json->message = "La Placa se elimino correctamente.";
                $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }
        
}