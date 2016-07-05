<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OperacionUsuario extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->output->set_header('Access-Control-Allow-Origin: *');
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_OperacionUsuario');
        $this->load->model('admin/M_Admin_Usuario');
	}

	

    public function operacionusuario($id){
        $this->load->model('admin/M_Admin_Usuario');
        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Operacion por Usuario";

        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;

        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Operaciones ";
        $modulo->titulo                    = "Operaciones ";
        $modulo->titulo_registro           = "Registro de Operaciones por Usuario ";
        $modulo->cabecera_registro         = array("Operacion");
        $modulo->ruta_plantilla_registro   = "admin/operacionusuario/v-admin-operacionusuario-rows";
        $modulo->base_url                  = "admin/operacionusuario/";
        $modulo->api_rest_params           = array("delete" => "id_operacion");
        $modulo->menu                      = array("menu" => 1, "submenu" => 9);
        $modulo->navegacion                = array(
            array("nombre" => "Operacion por Usuario",
                "url" => "",
                "activo" => TRUE,
                )
        );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/operacionusuario/".$this->uri->segment(3)."/page/";
        $total_row                         = $this->M_Admin_OperacionUsuario->getTotal($id);
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

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;

        $modulo->registros = $this->M_Admin_OperacionUsuario->fetch($config["per_page"], ($page - 1) * 15,$id);
       
        $str_links              = $this->pagination->create_links();
        $modulo->links          = explode('&nbsp;',$str_links );
        $usuario              = $this->M_Admin_Usuario->getByID($id);
        $modulo->usuario      = $usuario[0];
        $data["modulo"] = $modulo;
        $this->load->view('admin/operacionusuario/v-admin-operacionusuario', $data);
    }

    public function agregar($id) {
        $this->load->model("admin/M_Admin_Usuario");
        $this->load->model("admin/M_Admin_Operacion");
        $this->load->model("admin/M_Admin_Region");
        $modulo = new stdClass();
        
        $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario          = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;

        $modulo->titulo                 = "Operacion por Usuario";
        $modulo->titulo_pagina          = "SERVOSA | Operacion por Usuario";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/operacionusuario/";
        
        $modulo->url_signout            = base_url()."admin/signOut";
        $modulo->url_main_panel         = base_url()."admin";

        $modulo->id                     = $id;
        $modulo->menu                   = array("menu" => 1, "submenu" => 9);
        $modulo->usuario                = $this->M_Admin_Usuario->getUsuarios();
        $modulo->region                 = $this->M_Admin_Region->getRegion();
        $modulo->operacion              = $this->M_Admin_Operacion->getOperacion();
        $modulo->operacionuser          = $this->M_Admin_Operacion->getOperacionByUser($id);
        //var_dump($modulo->operacionuser);
        //var_dump($modulo->operacion);
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/operacionusuario/v-admin-operacionusuario-editar', $data);
    }

    public function insertar() {

        $json                   = new stdClass();
        $json->type             = "Operacion Usuario";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("id_usuario") && $this->input->post("id_operacion") ) {
           
            /* Registrar Datos */
            $result1 = $this->M_Admin_OperacionUsuario->insert(
                    array(
                            "id_usuario"    => trim($this->input->post("id_usuario", TRUE)),
                            "id_operacion"  => trim($this->input->post("id_operacion", TRUE))
                           
                    )
            );
            $json->message = "Se Asigno Operacion correctamente.";
            array_push($json->data, array("id_usuario" => $result1));
            $json->status = TRUE;
           

        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

//    public function editar($id) {
//        $this->load->model("admin/M_Admin_Operacion");
//
//        if (isset($id)) {
//            $modulo = new stdClass();
//
//            //$usuario = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
//            //$modulo->datos_usuario = $usuario[0];
//
//            $modulo->titulo                 = "Operacion por Usuario";
//            $modulo->titulo_pagina          = "SERVOSA | Operacion por Usuario";
//            $modulo->icono_empresa          = PATH_RESOURCE_ADMIN."img/icon/logo_servosa.jpg";
//            $modulo->nombres_usuario        = "administrador";
//            $modulo->tipo_usuario           = "administrador";
//            $modulo->nombre_empresa_largo   = "SERVOSA";
//            $modulo->nombre_empresa_corto   = "S";
//            $modulo->nombreSeccion          = "Editar";
//            $modulo->base_url               = "admin/operacionusuario/";
//            $modulo->url_main_panel         = base_url()."admin";
//            $modulo->menu                   = array("menu" => 2, "submenu" => 9);
//
//            $result = $this->M_Admin_OperacionUsuario->getByID($id);
//            if (count($result) > 0) {
//                $data["dataEmpresa"]    = $result[0];
//                $data["existeEmpresa"]  = TRUE;
//            } else {
//                $data["dataEmpresa"]    = NULL;
//                $data["existeEmpresa"]  = FALSE;
//            }
//            $modulo->idRuta                 = $id;
//            $modulo->operacion              = $this->M_Admin_Usuario->getOperacion();
//            $data["modulo"]                 = $modulo;
//            $this->load->view('admin/operacionusuario/v-admin-operacionusuario-editar', $data);
//        } else {
//                redirect('/');
//        }
//    }
//
//    public function actualizar() {
//
//
//        $json                   = new stdClass();
//        $json->type             = "Ruta";
//        $json->presentation     = "";
//        $json->action           = "actualizar";
//        $json->data             = array();
//        $json->status           = FALSE;
//
//        if ( $this->input->post("txtNombre") && $this->input->post("id_operacion") ) {
//            
//            /* Registrar Datos */
//            $result1 = $this->M_Admin_Rutas->update(
//                array(
//                        "nombre_ruta"         => trim($this->input->post("txtNombre", TRUE)),
//                        "id_operacion"      => trim($this->input->post("id_operacion", TRUE))
//                        
//                ),
//                trim($this->input->post("id_ruta", TRUE))
//            );
//            
//           
//            $json->message = "La Ruta se edito correctamente.";
//            array_push($json->data, array("id_operacion" =>  trim($this->input->post("id_operacion", TRUE))));
//            $json->status = TRUE;
//
//                                                                
//                      
//        } else {
//                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
//        }
//                
//        echo json_encode($json);
//    }


   

    public function eliminar() {

        $json 				= new stdClass();
        $json->type 		= "Operacion Usuario";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("idUsuario") && $this->input->post("idOperacion") ) {             
                $this->M_Admin_OperacionUsuario->delete(trim($this->input->post("idUsuario", TRUE)), trim($this->input->post("idOperacion", TRUE)));

                $json->message = "La Asignacion se elimino correctamente.";
                $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }
        
}