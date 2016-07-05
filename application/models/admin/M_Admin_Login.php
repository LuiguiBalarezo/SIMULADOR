<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Login extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function signIn($user) {
        $this->db->select("Usuario.id_usuario,
            Usuario.usuario,
            Usuario.password,
            Usuario.email,
            Usuario.nombre,
            Usuario.apellidos,
            Usuario.id_tipo_usuario,
            Tipo_usuario.nombre_tipo_usuario");
        $this->db->join('Tipo_usuario', 'Tipo_usuario.id_tipo_usuario = Usuario.id_tipo_usuario');
        $this->db->where('Usuario.usuario', $user);
        $this->db->where('Usuario.estado', '1');
        $this->db->where('Tipo_usuario.estado', '1');
        $query = $this->db->get('Usuario');
        return $query->result();
    }
}