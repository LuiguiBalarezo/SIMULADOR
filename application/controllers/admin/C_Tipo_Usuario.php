<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Tipo_Usuario extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_Usuario');
	}

	public function index()	{
        $this->load->model('admin/M_Admin_TipoUsuario');
        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Tipo de Usuario";

        $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario      = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;
        
        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Tipo de Usuario ";
        $modulo->titulo                    = "Tipo de Usuario ";
        $modulo->titulo_registro           = "Registro de Tipos de Usuario ";
        $modulo->cabecera_registro         = array("Tipo de Usuario");
        $modulo->ruta_plantilla_registro   = "admin/tipousuario/v-admin-tipo-usuario-rows";
        $modulo->base_url                  = "admin/tipousuario/";
        $modulo->api_rest_params           = array("delete" => "id_tipo_usuario");
        $modulo->menu                      = array("menu" => 1, "submenu" => 2);
        $modulo->navegacion                = array(
                                                   array("nombre" => "Tipo de Usuario",
                                                        "url" => "",
                                                        "activo" => TRUE)
                                                );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/tipousuario/page/";
        $total_row                         = $this->M_Admin_TipoUsuario->getTotalTipoUsuarios();
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

        $modulo->registros = $this->M_Admin_TipoUsuario->fetchTipoUsuarios($config["per_page"], ($page - 1) * 15);
        $str_links = $this->pagination->create_links();
        $modulo->links = explode('&nbsp;',$str_links );

        $data["modulo"] = $modulo;
        $this->load->view('admin/tipousuario/v-admin-tipo-usuario', $data);
	}

    public function agregar() {
        $this->load->model('admin/M_Admin_TipoUsuario');
        $modulo = new stdClass();

        $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario          = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
        $modulo->titulo                 = "Tipo de Usuario";
        $modulo->titulo_pagina          = "SERVOSA | Tipo de Usuario";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/tipousuario/";
        
        $modulo->url_signout            = base_url()."admin/signOut";
        $modulo->url_main_panel         = base_url()."admin";


        $modulo->menu                   = array("menu" => 1, "submenu" => 1);
        $data["modulo"]                                 = $modulo;

        $this->load->view('admin/tipousuario/v-admin-tipo-usuario-editar', $data);
    }

    public function insertar() {
        $this->load->model('admin/M_Admin_TipoUsuario');


        $json                   = new stdClass();
        $json->type             = "Tipo de Usuario";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") ) {
            
                /* Registrar Datos */
                $result1 = $this->M_Admin_TipoUsuario->insertTipoUsuario(
                        array(
                                "nombre"         => trim($this->input->post("txtNombre", TRUE))
                        )
                );

                $json->message = "El Tipo de Usuario se creo correctamente.";
                array_push($json->data, array("id_tipo_usuario" => $result1));
                $json->status = TRUE;

        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function editar($idTipoUsuario) {
        $this->load->model('admin/M_Admin_TipoUsuario');

        if (isset($idTipoUsuario)) {
                $modulo = new stdClass();

            $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
            $modulo->datos_usuario          = $usuario[0];

            /* Datos de la cabecera del panel de administrador*/
            $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
            $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
            $modulo->titulo                 = "Tipo de Usuario";
            $modulo->titulo_pagina          = "SERVOSA | Tipo de Usuario";
            $modulo->nombreSeccion          = "Editar";
            $modulo->base_url               = "admin/tipousuario/";
            $modulo->url_main_panel         = base_url()."admin";
            $modulo->menu                   = array("menu" => 1, "submenu" => 1);

            $result = $this->M_Admin_TipoUsuario->getByID($idTipoUsuario);
            if (count($result) > 0) {
                    $data["dataEmpresa"]    = $result[0];
                    $data["existeEmpresa"]  = TRUE;
            } else {
                    $data["dataEmpresa"]    = NULL;
                    $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idTipoUsuario              = $idTipoUsuario;
            
            $data["modulo"]                 = $modulo;
            $this->load->view('admin/tipousuario/v-admin-tipo-usuario-editar', $data);
        } else {
                redirect('/');
        }
    }

    public function actualizar() {
        $this->load->model('admin/M_Admin_TipoUsuario');

        $json                           = new stdClass();
        $json->type             = "Tipo de Usuario";
        $json->presentation = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") ) {
            
            /* Registrar Datos */
            $result1 = $this->M_Admin_TipoUsuario->updateTipoUsuario(
                array(
                        "nombre"         => trim($this->input->post("txtNombre", TRUE)),
                        
                ),
                trim($this->input->post("id_tipo_usuario", TRUE))
            );

            

           
            $json->message = "El Tipo de Usuario se edito correctamente.";
            array_push($json->data, array("id_tipo_usuario" =>  trim($this->input->post("id_tipo_usuario", TRUE))));
            $json->status = TRUE;

                                                                
                      
        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
                
                echo json_encode($json);
    }


   

    public function eliminar() {
        $this->load->model('admin/M_Admin_TipoUsuario');

        $json 				= new stdClass();
        $json->type 		= "Tipo de Usuario";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_tipo_usuario") ) {

                
                $result = $this->M_Admin_TipoUsuario->deleteTipoUsuario(trim($this->input->post("id_tipo_usuario", TRUE)));

                $json->message = "El Tipo de Usuario se elimino correctamente.";
                $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }
        
}