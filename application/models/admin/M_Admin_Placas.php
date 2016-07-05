<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Placas extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id) {
		$this->db->where('Placa.id_placa', $id);
		$this->db->where('Placa.estado', '1');
		$query = $this->db->get('Placa');
		return $query->result();
	}
	public function getPlacasbyID($id) {
		$this->db->where('Placa.id_operacion', $id);
		$this->db->where('Placa.estado', '1');
		$query = $this->db->get('Placa');
		return $query->result();
	}

	public function getByName($nombre) {
		$this->db->where('Placa.estado', '1');
		$this->db->where('Placa.placa', $nombre);
		$query = $this->db->get('Placa');
		return $query->result();
	}

	public function fetch($limit, $start, $id) {
		$this->db->select("Placa.id_placa, Placa.placa,Operacion.id_operacion,
            Operacion.nombre_operacion");
		$this->db->join('Operacion', 'Placa.id_operacion = Operacion.id_operacion');
		$this->db->where('Operacion.estado', '1');
		$this->db->where('Placa.estado', '1');
		$this->db->where('Placa.id_operacion', $id);
		$this->db->limit($limit, $start);
		$query = $this->db->get('Placa');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotal($id) {
		$this->db->where('Placa.estado', '1');
		$this->db->where('Placa.id_operacion', $id);
		$query = $this->db->get('Placa');
		return $query->num_rows();
	}

	public function insert($data) {
		$data = array(
			'placa'					=> $data["placa"],
			'id_operacion'			=> $data["id_operacion"]
		);
		if ($this->db->insert('Placa', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


	public function update($data, $id) {
		$data = array(
			"placa"			=> $data["placa"]

		);
		$this->db->where('Placa.id_placa', $id);
		if ($this->db->update('Placa', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function delete($id) {
		$this->db->where('Placa.id_placa', $id);
		if ($this->db->update('Placa', array('Placa.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
	
}