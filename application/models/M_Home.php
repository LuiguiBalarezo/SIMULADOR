<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Home extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function getByEmail($email) {
        $this->db->where('estado', '1');
        $this->db->where('email', $email);
        $query = $this->db->get('Usuario');
        return $query->result();
    }


}