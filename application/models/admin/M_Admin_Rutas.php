<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Rutas extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id) {
		$this->db->where('Ruta.id_ruta', $id);
		$this->db->where('estado', '1');
		$query = $this->db->get('Ruta');
		return $query->result();
	}

	public function getByName($nombre) {
		$this->db->where('Ruta.estado', '1');
		$this->db->where('Ruta.nombre_ruta', $nombre);
		$query = $this->db->get('Ruta');
		return $query->result();
	}
	public function getRutas() {
		$this->db->where('estado', '1');
		$query = $this->db->get('Ruta');
		return $query->result();
	}
	public function getRutasbyID($id) {
		$this->db->where('Ruta.estado', '1');
		$this->db->where('Ruta.id_operacion', $id);
		$query = $this->db->get('Ruta');
		return $query->result();
	}

	public function fetch($limit, $start, $id) {
		$this->db->select("Ruta.id_ruta, Ruta.nombre_ruta,Operacion.id_operacion,
            Operacion.nombre_operacion");
		$this->db->join('Operacion', 'Ruta.id_operacion = Operacion.id_operacion');
		$this->db->where('Operacion.estado', '1');
		$this->db->where('Ruta.estado', '1');
		$this->db->where('Ruta.id_operacion', $id);
		$this->db->limit($limit, $start);
		$query = $this->db->get('Ruta');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotal($id) {
		$this->db->where('Ruta.estado', '1');
		$this->db->where('Ruta.id_operacion', $id);
		$query = $this->db->get('Ruta');
		return $query->num_rows();
	}

	public function insert($data) {
		$data = array(
			'nombre_ruta'			=> $data["nombre_ruta"],
			'id_operacion'			=> $data["id_operacion"]
		);
		if ($this->db->insert('Ruta', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


	public function update($data, $id) {
		$data = array(
			"nombre_ruta"			=> $data["nombre_ruta"],
			'id_operacion'			=> $data["id_operacion"]
		);
		$this->db->where('Ruta.id_ruta', $id);
		if ($this->db->update('Ruta', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function delete($id) {
		$this->db->where('Ruta.id_ruta', $id);
		if ($this->db->update('Ruta', array('Ruta.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
	
}