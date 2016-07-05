<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Forbidden_Access extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
        $this->load->library('user_agent');
        $this->load->library('utils/UserSession');
	}

	public function index() {
        $modulo = new stdClass();
		$modulo->titulo      = "Access Denied!";
        $modulo->mensaje     = "You do not have permission to view this resource.";
        
        if ($this->agent->is_referral()) {
            $modulo->url_go_back = $this->agent->referrer();
        } else {
            if (!$this->usersession->validateTypeUser()) {
                $modulo->url_go_back = base_url();
            } else {
                if ($this->usersession->validateTypeUser() == 1) {
                    $modulo->url_go_back = base_url()."admin";
                } else if ($this->usersession->validateTypeUser() == 2) {
                    $modulo->url_go_back = base_url()."store/".$this->session->id_empresa."/admin";
                } else if ($this->usersession->validateTypeUser() == 3) {
                    $modulo->url_go_back = base_url()."store/".$this->session->id_empresa."";
                }
            }
        }
        
        $data["modulo"] = $modulo;        
        $this->load->view('template/v-forbidden-access', $data);
	}

}