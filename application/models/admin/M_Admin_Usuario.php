<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Usuario extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getUsuarios() {
		$this->db->where('estado', '1');
		$query = $this->db->get('Usuario');
		return $query->result();
	}
	public function fetchUsuarios($limit, $start) {
		$this->db->select("
       		Usuario.id_usuario,
            Usuario.email,
            Usuario.nombre,
            Usuario.apellidos,
            Usuario.usuario
            ");

		$this->db->where('Usuarios.estado', '1');

		$this->db->limit($limit, $start);
		$query = $this->db->get('Usuario');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotalUsuarios() {
		$this->db->where('Usuario.estado', '1');
		$query = $this->db->get('Usuario');
		return $query->num_rows();
	}
	public function getByUser($nombre_usuario) {
		$this->db->where('Usuario.estado', '1');
		$this->db->where('Usuario.usuario', $nombre_usuario);
		$query = $this->db->get('Usuario');
		return $query->result();
	}
	public function getByEmail($email_usuario) {
		$this->db->where('Usuario.estado', '1');
		$this->db->where('Usuario.email', $email_usuario);
		$query = $this->db->get('Usuario');
		return $query->result();
	}

	public function getByID($id_usuario) {
        $this->db->select("
       		Usuario.id_usuario,
       		Usuario.usuario,
            Usuario.email,
            Usuario.nombre,
            Usuario.apellidos
            ");


		$this->db->where('Usuario.id_usuario', $id_usuario);
		$this->db->where('Usuario.estado', '1');

		$query = $this->db->get('Usuario');
        
		return $query->result();
	}

	public function insertUsuario($data) {
		$data = array(
			"nombre"			=> $data["nombre"],
			"apellidos"			=> $data["apellidos"],
			"usuario"			=> $data["usuario"],
			"email"				=> $data["email"],
			"password"			=> $data["password"]
		);
		if ($this->db->insert('Usuario', $data)) {
			return $this->db->insert_id();
		}
		
		return FALSE;
	}

	public function updateUsuario($data, $id_usuario) {
		$data = array(
			"nombre"			=> $data["nombre"],
			"apellidos"			=> $data["apellidos"],
			"usuario"			=> $data["usuario"],
			"email"				=> $data["email"],
			"password"			=> $data["password"]
		);
		$this->db->where('Usuario.id_usuario', $id_usuario);
		if ($this->db->update('Usuario', $data)) {
			return $this->db->insert_id();
		}
		
		return FALSE;
	}
	public function deleteUsuario($idUsuario) {
		$this->db->where('id_usuario', $idUsuario);
		if ($this->db->update('Usuario', array('estado'=> 0))) {
			return TRUE;
		}

		return FALSE;
	}


}