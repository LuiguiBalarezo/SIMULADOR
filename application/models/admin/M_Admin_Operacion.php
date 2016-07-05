<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Operacion extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id) {
		$this->db->where('Operacion.id_operacion', $id);
		$this->db->where('estado', '1');
		$query = $this->db->get('Operacion');
		return $query->result();
	}

	public function getOperacionByUser($id) {
		$this->db->where('Usuario_Operacion.id_usuario', $id);
		$this->db->where('estado', '1');
		$query = $this->db->get('Usuario_Operacion');
		return $query->result();
	}

	public function getByName($nombre) {
		$this->db->where('Operacion.estado', '1');
		$this->db->where('Operacion.nombre_operacion', $nombre);
		$query = $this->db->get('Operacion');
		return $query->result();
	}
	public function getOperacion() {
		$this->db->where('estado', '1');
		$query = $this->db->get('Operacion');
		return $query->result();
	}
	public function getOperacionbyID($id_region) {
		$this->db->where('estado', '1');
		$this->db->where('Operacion.id_region', $id_region);
		$query = $this->db->get('Operacion');
		return $query->result();
	}

	public function fetch($limit, $start) {
		$this->db->select("Operacion.id_operacion, Operacion.nombre_operacion,Region.id_region,
            Region.nombre_region");
		$this->db->join('Region', 'Region.id_region = Operacion.id_region');
		$this->db->where('Operacion.estado', '1');
		$this->db->where('Region.estado', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get('Operacion');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotal() {
		$this->db->where('Operacion.estado', '1');
		$query = $this->db->get('Operacion');
		return $query->num_rows();
	}

	public function insert($data) {
		$data = array(
			'nombre_operacion'			=> $data["nombre_operacion"],
			'id_region'					=> $data["id_region"]
		);
		if ($this->db->insert('Operacion', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


	public function update($data, $id) {
		$data = array(
			"nombre_operacion"			=> $data["nombre_operacion"]

		);
		$this->db->where('Operacion.id_operacion', $id);
		if ($this->db->update('Operacion', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function delete($id) {
		$this->db->where('Operacion.id_operacion', $id);
		if ($this->db->update('Operacion', array('Operacion.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
	
}