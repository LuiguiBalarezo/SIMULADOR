<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Tramos extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id) {
		$this->db->where('Tramo.id_tramo', $id);
		$this->db->where('estado', '1');
		$query = $this->db->get('Tramo');
		return $query->result();
	}
	public function getTramosbyID($id) {
		$this->db->where('Tramo.id_ruta', $id);
		$this->db->where('Tramo.estado', '1');
		$query = $this->db->get('Tramo');
		return $query->result();
	}

	public function getByName($nombre) {
		$this->db->where('Tramo.estado', '1');
		$this->db->where('Tramo.nombre_tramo', $nombre);
		$query = $this->db->get('Tramo');
		return $query->result();
	}

	public function fetch($limit, $start, $id) {
		$this->db->select("Ruta.id_ruta, Ruta.nombre_ruta,Tramo.id_tramo,
            Tramo.nombre_tramo, Tramo.velocidad");
		$this->db->join('Ruta', 'Ruta.id_ruta = Tramo.id_ruta');
		$this->db->where('Tramo.estado', '1');
		$this->db->where('Ruta.estado', '1');
		$this->db->where('Tramo.id_ruta', $id);
		$this->db->limit($limit, $start);
		$query = $this->db->get('Tramo');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotal($id) {
		$this->db->where('Tramo.estado', '1');
		$this->db->where('Tramo.id_tramo', $id);
		$query = $this->db->get('Tramo');
		return $query->num_rows();
	}

	public function insert($data) {
		$data = array(
			'nombre_tramo'				=> $data["nombre_tramo"],
			'velocidad'					=> $data["velocidad"],
			'id_ruta'					=> $data["id_ruta"]
		);
		if ($this->db->insert('Tramo', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


	public function update($data, $id) {
		$data = array(
			"nombre_tramo"			=> $data["nombre_tramo"],
			'velocidad'				=> $data["velocidad"],
			"id_ruta"				=> $data["id_ruta"]

		);
		$this->db->where('Tramo.id_tramo', $id);
		if ($this->db->update('Tramo', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function delete($id) {
		$this->db->where('Tramo.id_tramo', $id);
		if ($this->db->update('Tramo', array('Tramo.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}

	public function getOperacion($id) {
		$this->db->select('Operacion.id_operacion,Operacion.nombre_operacion,Ruta.nombre_ruta');
		$this->db->join('Operacion', 'Operacion.id_operacion = Ruta.id_operacion');
		$this->db->where('Ruta.id_ruta', $id);
		$query = $this->db->get('Ruta',1);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}
	
}