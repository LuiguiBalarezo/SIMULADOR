<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Login extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function signIn($email) {
        $this->db->select("Usuario.id_usuario,
            Usuario.usuario,
            Usuario.password,
            Usuario.email,
            Usuario.nombre,
            Usuario.apellidos,
            ");
        $this->db->where('Usuario.email', $email);
        $this->db->where('Usuario.estado', '1');
        $query = $this->db->get('Usuario');
        return $query->result();
    }
}