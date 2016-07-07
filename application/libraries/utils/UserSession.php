<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserSession {
    
    var $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library("session");
    }

    public function validateSession() {
        $this->validatePanelAdmin();
    }

	public function validateTypeUser() {
        if ($this->CI->session->has_userdata('user_session')) {
            if ($this->CI->session->id_tipo_usuario == "1") {
                return 1;
            } else if ($this->CI->session->id_tipo_usuario == "2") {
                return 2;
            } else if ($this->CI->session->id_tipo_usuario == "3") {
                return 3;
            } else{
                return 4;
            }
        } else {
            return FALSE;
        }
	}
    
    private function validatePanelAdmin() {
        if ($this->validateTypeUser()) {
            if ($this->validateTypeUser() == 1 || $this->validateTypeUser() == 2 || $this->validateTypeUser() == 4) {
               // redirect("/admin/eventoriesgo/");
                //redirect("/admin/");
            }
        } else {
            redirect("/");
        }
    }
    public function validatePanelEvento() {
        if ($this->validateTypeUser()) {
            if ($this->validateTypeUser() == 3 ) {
                redirect("/admin/");
            }

        } else {
            redirect("/");
        }
    }

}