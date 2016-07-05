<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Usuario extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        $this->load->model('admin/M_Admin_Usuario');
        $this->load->library('utils/UserSession');
        $this->usersession->validateSession();
	}

	public function index()	{
        $this->load->model('admin/M_Admin_Usuario');
        $this->load->library('pagination');
        $modulo = new stdClass();
        $modulo->titulo_pagina = "SERVOSA | Panel Principal";

        $usuario                            = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario              = $usuario[0];
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario            = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario               = $usuario[0]->nombre_tipo_usuario;

        $modulo->nombre                    = "Usuarios ";
        $modulo->titulo                    = "Usuarios ";
        $modulo->titulo_registro           = "Registro de Usuarios ";
        $modulo->cabecera_registro         = array("Nombre Usuario", "Usuario", "Correo Usuario", "Región", "Cargo", "Fecha Registro");
        $modulo->ruta_plantilla_registro   = "admin/usuario/v-admin-usuario-rows";
        $modulo->base_url                  = "admin/usuario/";
        $modulo->api_rest_params           = array("delete" => "id_usuario");
        $modulo->menu                      = array("menu" => 1, "submenu" => 1);
        $modulo->navegacion                = array(
                                                   array("nombre" => "Usuarios",
                                                        "url" => "",
                                                        "activo" => TRUE)
                                                );

        $config                            = array();
        $config["base_url"]                = base_url() . "admin/usuario/page/";
        $total_row                         = $this->M_Admin_Usuario->getTotalUsuarios();
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

        $modulo->registros = $this->M_Admin_Usuario->fetchUsuarios($config["per_page"], ($page - 1) * 15);
        $str_links = $this->pagination->create_links();
        $modulo->links = explode('&nbsp;',$str_links );

        $data["modulo"] = $modulo;
        $this->load->view('admin/usuario/v-admin-usuario', $data);
	}

    public function agregar() {
        $this->load->model("admin/M_Admin_TipoUsuario");
        $this->load->model("admin/M_Admin_Region");
        
        $modulo = new stdClass();

        $usuario                        = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
        $modulo->datos_usuario          = $usuario[0];
        /* Datos de la cabecera del panel de administrador*/
        $modulo->nombres_usuario        = $usuario[0]->nombre." ".$usuario[0]->apellidos;
        $modulo->tipo_usuario           = $usuario[0]->nombre_tipo_usuario;
        
        $modulo->titulo                 = "Usuario";
        $modulo->titulo_pagina          = "SERVOSA | Usuario ";
        $modulo->nombreSeccion          = "Agregar";
        $modulo->base_url               = "admin/usuario/";
        $modulo->url_main_panel         = base_url()."admin";

        $modulo->menu                   = array("menu" => 1, "submenu" => 1);
        $modulo->tipousuario            = $this->M_Admin_TipoUsuario->getTipoUsuario();
        $modulo->region                 = $this->M_Admin_Region->getRegion();
        $data["modulo"]                                 = $modulo;

        $this->load->view('admin/usuario/v-admin-usuario-editar', $data);
    }

    public function insertarUsuario() {
        $this->load->model('admin/M_Admin_Usuario');
        $this->load->library('security/Cryptography');

        $json                   = new stdClass();
        $json->type             = "Usuario";
        $json->presentation     = "";
        $json->action           = "insert";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") &&
            $this->input->post("txtApellidos") &&
            $this->input->post("txtDni") &&
            $this->input->post("txtCelular") &&
            $this->input->post("txtDireccion") &&
            $this->input->post("cboRegion") &&
            $this->input->post("cboTipoUsuario") &&
            $this->input->post("txtUsuario") &&
            $this->input->post("txtEmail") &&
            $this->input->post("txtPassword")) {
                
            /* Validar Datos */
            $validate = $this->M_Admin_Usuario->getByUser(trim($this->input->post("txtUsuario", TRUE)));
              
                if (sizeof($validate) == 0) {
                        unset($validate);
                        $validate = $this->M_Admin_Usuario->getByEmail(trim($this->input->post("txtEmail", TRUE)));
        
                        if (sizeof($validate) == 0) {
                                
        
                                /* Registrar Datos */
                                $result1 = $this->M_Admin_Usuario->insertUsuario(
                                        array(
                                                "nombre"         => trim($this->input->post("txtNombre", TRUE)),
                                                "apellidos"         => trim($this->input->post("txtApellidos", TRUE)),
                                                "dni"         => trim($this->input->post("txtDni", TRUE)),
                                                "celular"         => trim($this->input->post("txtCelular", TRUE)),
                                                "direccion"         => trim($this->input->post("txtDireccion", TRUE)),
                                                "id_tipo_usuario"         => trim($this->input->post("cboTipoUsuario", TRUE)),
                                                "id_region"         => trim($this->input->post("cboRegion", TRUE)),
                                                "usuario"         => trim($this->input->post("txtUsuario", TRUE)),
                                                "email"         => trim($this->input->post("txtEmail", TRUE)),
                                                "password"      => $this->cryptography->Encrypt(trim($this->input->post("txtPassword", TRUE)))
                                        )
                                );

                                $json->message = "El Usuario se creo correctamente.";
                                array_push($json->data, array("id_usuario" => $result1));
                                $json->status = TRUE;
        
                                                                
                        } else {
                                $json->message = "Lo sentimos el Email ingresado ya existe, intente de nuevo.";
                        }
        
                } else {
                        $json->message = "Lo sentimos el Nombre de Usuario ya existe, intente de nuevo.";
                }

        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
        
        echo json_encode($json);
    }

    public function editar($idUsuario) {
        $this->load->model('admin/M_Admin_Usuario');
        $this->load->model("admin/M_Admin_TipoUsuario");
        $this->load->model("admin/M_Admin_Region");
        if (isset($idUsuario)) {
            $modulo = new stdClass();

            $usuario                    = $this->M_Admin_Usuario->getByID($this->session->id_usuario);
            $modulo->datos_usuario      = $usuario[0];
            /* Datos de la cabecera del panel de administrador*/
            $modulo->nombres_usuario    = $usuario[0]->nombre." ".$usuario[0]->apellidos;
            $modulo->tipo_usuario       = $usuario[0]->nombre_tipo_usuario;
            $modulo->titulo                 = "Usuario";
            $modulo->titulo_pagina          = "SERVOSA | Usuario ";
            $modulo->nombreSeccion          = "Editar";
            $modulo->base_url               = "admin/usuario/";
            $modulo->url_main_panel         = base_url()."admin";

            $modulo->menu                   = array("menu" => 1, "submenu" => 1);

            $result = $this->M_Admin_Usuario->getByID($idUsuario);
            if (count($result) > 0) {
                    $data["dataEmpresa"]    = $result[0];
                    $data["existeEmpresa"]  = TRUE;
            } else {
                    $data["dataEmpresa"]    = NULL;
                    $data["existeEmpresa"]  = FALSE;
            }
            $modulo->idUsuario              = $idUsuario;
            $modulo->tipousuario            = $this->M_Admin_TipoUsuario->getTipoUsuario();
            $modulo->region                 = $this->M_Admin_Region->getRegion();


            $data["modulo"]                 = $modulo;
            $this->load->view('admin/usuario/v-admin-usuario-editar', $data);
        } else {
                redirect('/');
        }
    }
        
    public function actualizarUsuario() {
        $this->load->model('admin/M_Admin_Usuario');
        $this->load->library('security/Cryptography');

        $json                   = new stdClass();
        $json->type             = "Usuario";
        $json->presentation     = "";
        $json->action           = "actualizar";
        $json->data             = array();
        $json->status           = FALSE;

        if ( $this->input->post("txtNombre") &&
                $this->input->post("txtApellidos") &&
                $this->input->post("txtDni") &&
                $this->input->post("txtCelular") &&
                $this->input->post("txtDireccion") &&
                $this->input->post("cboRegion") &&
                $this->input->post("cboTipoUsuario") &&
                $this->input->post("txtUsuario") &&
                $this->input->post("txtEmail"))

        {

                /* Validar Datos */
                /*$validate = $this->M_Admin_Usuario->getByUser(trim($this->input->post("txtUsuario", TRUE)));
              

                if (sizeof($validate) == 0) {
                        unset($validate);
                        //$validate = $this->M_Admin_Usuario->getByEmail(trim($this->input->post("txtEmail", TRUE)));

                        //if (sizeof($validate) == 0) {
                                

                                /* Registrar Datos */
                                $result1 = $this->M_Admin_Usuario->updateUsuario(
                                        array(
                                                "nombre"         => trim($this->input->post("txtNombre", TRUE)),
                                                "apellidos"         => trim($this->input->post("txtApellidos", TRUE)),
                                                "dni"         => trim($this->input->post("txtDni", TRUE)),
                                                "celular"         => trim($this->input->post("txtCelular", TRUE)),
                                                "direccion"         => trim($this->input->post("txtDireccion", TRUE)),
                                                "id_tipo_usuario"         => trim($this->input->post("cboTipoUsuario", TRUE)),
                                                "id_region"         => trim($this->input->post("cboRegion", TRUE)),
                                                "usuario"         => trim($this->input->post("txtUsuario", TRUE)),
                                                "email"         => trim($this->input->post("txtEmail", TRUE)),
                                                "password"      => $this->cryptography->Encrypt(trim($this->input->post("txtPassword", TRUE)))
                                        ),
                                        trim($this->input->post("id_usuario", TRUE))
                                );

                                

                               
                                $json->message = "El Usuario se edito correctamente.";
                                array_push($json->data, array("id_usuario" => $result1));
                                $json->status = TRUE;

                                                                
                        /*} else {
                                $json->message = "Lo sentimos el Email ingresado ya existe, intente de nuevo.";
                        }*/

                /*} else {
                        $json->message = "Lo sentimos el Nombre de Usuario ya existe, intente de nuevo.";
                }*/

        } else {
                $json->message  = "No se recibio los parametros necesarios para procesar su solicitud.";
        }
        
        echo json_encode($json);
    }

    public function ajaxGeneratePassword() {
        $this->load->library("utils/Password");

        $json                           = new stdClass();
        $json->type                     = "Generate Password";
        $json->presentation             = "data";
        $json->action                   = "";
        $json->data                     = array("password" => $this->password->generate());
        $json->message                  = "Contraseña generada correctamente.";
        $json->status                   = TRUE;

        echo json_encode($json);
    }

    public function eliminarUsuario() {
        $this->load->model('admin/M_Admin_Usuario');

        $json 				= new stdClass();
        $json->type 		= "Usuario";
        $json->presentation = "";
        $json->action 		= "delete";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ( $this->input->post("id_usuario") ) {

                
                $result = $this->M_Admin_Usuario->deleteUsuario(trim($this->input->post("id_usuario", TRUE)));

                $json->message = "El Usuario se elimino correctamente.";
                $json->status = TRUE;
                
        } else {
                $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }



}