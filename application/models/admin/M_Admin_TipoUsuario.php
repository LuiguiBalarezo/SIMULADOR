<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_TipoUsuario extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id_tipo_usuario) {
		$this->db->where('Tipo_usuario.id_tipo_usuario', $id_tipo_usuario);
		$this->db->where('estado', '1');
		$query = $this->db->get('Tipo_usuario');
		return $query->result();
	}
	public function getTipoUsuario() {
		$this->db->where('estado', '1');
		$query = $this->db->get('Tipo_usuario');
		return $query->result();
	}

	public function fetchTipoUsuarios($limit, $start) {
		$this->db->select("	Tipo_usuario.id_tipo_usuario, Tipo_usuario.nombre_tipo_usuario,");
		$this->db->where('Tipo_usuario.estado', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get('Tipo_usuario');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotalTipoUsuarios() {
		$this->db->where('Tipo_usuario.estado', '1');
		$query = $this->db->get('Tipo_usuario');
		return $query->num_rows();
	}

	public function insertTipoUsuario($data) {
		$data = array(
			'nombre_tipo_usuario'			=> $data["nombre"]
		);
		if ($this->db->insert('Tipo_usuario', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


	public function updateTipoUsuario($data, $id_tipo_usuario) {
		$data = array(
			"nombre_tipo_usuario"			=> $data["nombre"]

		);
		$this->db->where('Tipo_usuario.id_tipo_usuario', $id_tipo_usuario);
		if ($this->db->update('Tipo_usuario', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function deleteTipoUsuario($id_tipo_usuario) {
		$this->db->where('Tipo_usuario.id_tipo_usuario', $id_tipo_usuario);
		if ($this->db->update('Tipo_usuario', array('Tipo_usuario.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
	
}