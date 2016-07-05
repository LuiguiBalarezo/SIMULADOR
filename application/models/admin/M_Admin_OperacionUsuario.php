<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_OperacionUsuario extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id) {
		$this->db->select("Usuario_Operacion.id_usuario, Usuario_Operacion.id_operacion, Operacion.nombre_operacion");
		$this->db->join('Operacion', 'Operacion.id_operacion = Usuario_Operacion.id_operacion');
		$this->db->where('Usuario_Operacion.id_usuario', $id);
		$this->db->where('Usuario_Operacion.estado', '1');
		$this->db->where('Operacion.estado', '1');
		$query = $this->db->get('Usuario_Operacion');
		return $query->result();
	}
	

	public function fetch($limit, $start, $id) {
		$this->db->select("Usuario_Operacion.id_usuario, Usuario_Operacion.id_operacion, Operacion.nombre_operacion, Usuario.nombre, Usuario.apellidos");
		$this->db->join('Operacion', 'Operacion.id_operacion = Usuario_Operacion.id_operacion');
		$this->db->join('Usuario', 'Usuario.id_usuario = Usuario_Operacion.id_usuario');
		$this->db->where('Operacion.estado', '1');
		$this->db->where('Usuario.estado', '1');
		$this->db->where('Usuario_Operacion.estado', '1');
		$this->db->where('Usuario_Operacion.id_usuario', $id);
		$this->db->limit($limit, $start);
		$query = $this->db->get('Usuario_Operacion');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotal($id) {
		$this->db->where('Usuario_Operacion.estado', '1');
		$this->db->where('Usuario_Operacion.id_usuario', $id);
		$query = $this->db->get('Usuario_Operacion');
		return $query->num_rows();
	}

	public function insert($data) {
		$data = array(
			'id_usuario'			=> $data["id_usuario"],
			'id_operacion'			=> $data["id_operacion"]
		);
		if ($this->db->insert('Usuario_Operacion', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


//	public function update($data, $id) {
//		$data = array(
//			"nombre_ruta"			=> $data["nombre_ruta"],
//			'id_operacion'			=> $data["id_operacion"]
//		);
//		$this->db->where('Ruta.id_ruta', $id);
//		if ($this->db->update('Ruta', $data)) {
//			return $this->db->insert_id();
//		}
//
//		return FALSE;
//	}

	public function delete($idUsuario , $idOperacion) {
		$this->db->where('Usuario_Operacion.id_usuario', $idUsuario);
		$this->db->where('Usuario_Operacion.id_operacion', $idOperacion);
		if ($this->db->update('Usuario_Operacion', array('Usuario_Operacion.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
	
}