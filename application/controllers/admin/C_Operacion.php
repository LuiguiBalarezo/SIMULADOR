<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Operacion extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
        $this->load->model('admin/M_Admin_Operacion');
        $this->load->model('admin/M_Admin_Usuario');
	}

	public function index()	{

        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Operacion";

        $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario          = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
        
        $modulo->url_signout = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."admin";

        $modulo->nombre                    = "Operacion ";
        $modulo->titulo                    = "Operacion ";
        $modulo->titulo_registro           = "Registro de Operacion ";
        $modulo->cabecera_registro         = array("Operacion");
        $modulo->ruta_plantilla_registro   = "admin/operacion/v-admin-operacion-rows";
        $modulo->base_url                  = "admin/operacion/";
        $modulo->api_rest_params           = array("delete" => "id_operacion");
        $modulo->menu                      = array("menu" => 2, "submenu" => 3);
        $modulo->navegacion                = array(
                                                   array("nombre" => "Operacion",
                                                        "url" => "",
                                                        "activo" => TRUE)
                                                );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/operacion/page/";
        $total_row                         = $this->M_Admin_Operacion->getTotal();
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

        $modulo->registros = $this->M_Admin_Operacion->fetch($config["per_page"], ($page - 1) * 15);
        $str_links = $this->pagination->create_links();
        $modulo->links = explode('&nbsp;',$str_links );

        $data["modulo"] = $modulo;
        $this->load->view('admin/operacion/v-admin-operacion', $data);
	}

    public function agregar() {
        $this->load->model("admin/M_Admin_Region");
        $modulo = new stdClass();

        $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario          = $usuario[0];

        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
        $modulo->titulo                 = "Operacion";
        $modulo->titulo_pagina          = "SERVOSA | Operacion";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/operacion/";
        
        $modulo->url_signout            = base_url()."admin/signOut";
        $modulo->url_main_panel         = base_url()."admin";


        $modulo->menu                   = array("menu" => 2, "submenu" => 3);
        $modulo->region                 = $this->M_Admin_Region->getRegion();
        $data["modulo"]                 = $modulo;

        $this->load->view('admin/operacion/v-admin-operacion-editar', $data);
    }

    public function insertar() {

        $json                   = new stdClass();
        $json->type             = "Operacion";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("cboRegion") ) {
            /* Validar Datos */
            $validate = $this->M_Admin_Operacion->getByName(trim($this->input->post("txtNombre", TRUE)));
            if (sizeof($validate) == 0) {
                /* Registrar Datos */
                $result1 = $this->M_Admin_Operacion->insert(
                        array(
                                "nombre_operacion"  => trim($this->input->post("txtNombre", TRUE)),
                                "id_region"         => trim($this->input->post("cboRegion", TRUE))
                        )
                );
                $json->message = "La Operacion se creo correctamente.";
                array_push($json->data, array("id_operacion" => $result1));
                $json->status = TRUE;
            } else {
                $json->message = "Lo sentimos la Operacion ya existe, intente de nuevo.";
            }



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
            
            $modulo->titulo                 = "Operacion";
            $modulo->titulo_pagina          = "SERVOSA | Operacion";
            $modulo->nombreSeccion          = "Editar";
            $modulo->base_url               = "admin/operacion/";
            $modulo->url_main_panel         = base_url()."admin";
            $modulo->menu                   = array("menu" => 2, "submenu" => 3);

            $result = $this->M_Admin_Operacion->getByID($id);
            if (count($result) > 0) {
                $data["dataEmpresa"]    = $result[0];
                $data["existeEmpresa"]  = TRUE;
            } else {
                $data["dataEmpresa"]    = NULL;
                $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idOperacion            = $id;
            $modulo->region                 = $this->M_Admin_Region->getRegion();
            $data["modulo"]                 = $modulo;
            $this->load->view('admin/operacion/v-admin-operacion-editar', $data);
        } else {
                redirect('/');
        }
    }

    public function actualizar() {


        $json                   = new stdClass();
        $json->type             = "Operacion";
        $json->presentation     = "";
        $json->action           = "actualizar";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") && $this->input->post("cboRegion") ) {
            
            /* Registrar Datos */
            $result1 = $this->M_Admin_Operacion->update(
                array(
                        "nombre_operacion"         => trim($this->input->post("txtNombre", TRUE)),
                        "id_region"      => trim($this->input->post("cboRegion", TRUE))
                        
                ),
                trim($this->input->post("id_operacion", TRUE))
            );
            
           
            $json->message = "La Operacion se edito correctamente.";
            array_push($json->data, array("id_operacion" =>  trim($this->input->post("id_operacion", TRUE))));
            $json->status = TRUE;

                                                                
                      
        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
                
        echo json_encode($json);
    }


   

    public function eliminar() {


        $json 				= new stdClass();
        $json->type 		= "Operacion";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_operacion") ) {

                
                $result = $this->M_Admin_Operacion->delete(trim($this->input->post("id_operacion", TRUE)));

                $json->message = "La Operacion se elimino correctamente.";
                $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    
        
}