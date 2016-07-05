<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PanelAdmin {

    var $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->model("M_Empresa");
        $this->CI->load->model("M_Usuario");
        $this->CI->load->model("M_Archivo");
    }

    public function loadPanelCompany() {
        $modulo = new stdClass();

        $dataEmpresa        = $this->CI->M_Empresa->getByID($this->CI->session->id_empresa);
        $dataUsuario        = $this->CI->M_Usuario->getByID($this->CI->session->id_usuario);
        $dataLogoEmpresa    = $this->CI->M_Archivo->getByID($dataEmpresa[0]->id_archivo_logo);

        if (sizeof($dataLogoEmpresa) > 0) {
            $modulo->icono_empresa = $dataLogoEmpresa[0]->url_archivo;
        } else {
            $modulo->icono_empresa = PATH_RESOURCE_ADMIN."img/image_not_found.png"; // Colocar logo de store por defecto
        }

        $modulo->datos_usuario = $dataUsuario[0];
        $modulo->datos_empresa = $dataEmpresa[0];

        /* Datos de la cabecera del panel de administrador */
        $modulo->nombres_usuario        = $dataUsuario[0]->nombres_persona." ".$dataUsuario[0]->apellidos_persona;
        $modulo->tipo_usuario           = $dataUsuario[0]->nombre_tipo_usuario;
        $modulo->nombre_empresa_largo   = $dataEmpresa[0]->organization;
        $modulo->nombre_empresa_corto   = $dataEmpresa[0]->organization;
        /* --------------------*-------------------- */

        $modulo->url_signout    = base_url()."admin/signOut";
        $modulo->url_main_panel = base_url()."company/".$this->CI->session->id_empresa."/admin";

        return $modulo;
    }

}