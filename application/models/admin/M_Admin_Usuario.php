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
            Usuario.fecha_registro,
            Usuario.nombre,
            Usuario.apellidos,
            Usuario.usuario,
            Region.id_region,
            Region.nombre_region,
            Tipo_usuario.id_tipo_usuario,
            Tipo_usuario.nombre_tipo_usuario
            ");
		$this->db->join('Tipo_usuario', 'Tipo_usuario.id_tipo_usuario = Usuario.id_tipo_usuario');
		$this->db->join('Region', 'Region.id_region = Usuario.id_region');		
		$this->db->where('Usuario.estado', '1');
		$this->db->where('Region.estado', '1');
		$this->db->where('Tipo_usuario.estado', '1');
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
		$this->db->join('Tipo_usuario', 'Tipo_usuario.id_tipo_usuario = Usuario.id_tipo_usuario');
		$this->db->join('Region', 'Region.id_region = Usuario.id_region');		
		$this->db->where('Usuario.estado', '1');
		$this->db->where('Region.estado', '1');
		$this->db->where('Tipo_usuario.estado', '1');
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
            Usuario.fecha_registro,
            Usuario.nombre,
            Usuario.apellidos,
            Usuario.dni,
            Usuario.celular,
            Usuario.direccion,
            Region.id_region,
            Region.nombre_region,
            Tipo_usuario.id_tipo_usuario,
            Tipo_usuario.nombre_tipo_usuario
            ");
		$this->db->join('Tipo_usuario', 'Tipo_usuario.id_tipo_usuario = Usuario.id_tipo_usuario');
		$this->db->join('Region', 'Region.id_region = Usuario.id_region');
		$this->db->where('Usuario.id_usuario', $id_usuario);
		$this->db->where('Usuario.estado', '1');
		$this->db->where('Region.estado', '1');
		$this->db->where('Tipo_usuario.estado', '1');
		$query = $this->db->get('Usuario');
        
		return $query->result();
	}

	public function insertUsuario($data) {
		$data = array(
			"nombre"			=> $data["nombre"],
			"apellidos"			=> $data["apellidos"],
			"dni"				=> $data["dni"],
			"celular"			=> $data["celular"],
			"direccion"			=> $data["direccion"],
			"id_tipo_usuario"	=> $data["id_tipo_usuario"],
			"id_region"			=> $data["id_region"],
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
			"dni"				=> $data["dni"],
			"celular"			=> $data["celular"],
			"direccion"			=> $data["direccion"],
			"id_tipo_usuario"	=> $data["id_tipo_usuario"],
			"id_region"			=> $data["id_region"],
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