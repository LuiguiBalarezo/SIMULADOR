<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Evento extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id) {
		$this->db->where('Evento.id_evento', $id);
		$this->db->where('estado', '1');
		$query = $this->db->get('Evento');
		return $query->result();
	}

	public function getByName($nombre) {
		$this->db->where('Evento.estado', '1');
		$this->db->where('Evento.nombre_evento', $nombre);
		$query = $this->db->get('Evento');
		return $query->result();
	}
	public function getEvento() {
		$this->db->where('estado', '1');
		$query = $this->db->get('Evento');
		return $query->result();
	}
	public function getLastCode() {
		$query ="SELECT id_evento FROM Evento ORDER BY id_evento DESC limit 1";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function fetch($limit, $start) {
		$this->db->select("Evento.id_evento, Evento.codigo_evento,Evento.nombre_evento");
		$this->db->where('Evento.estado', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get('Evento');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotal() {
		$this->db->where('Evento.estado', '1');
		$query = $this->db->get('Evento');
		return $query->num_rows();
	}

	public function insert($data) {
		$data = array(
			'nombre_evento'				=> $data["nombre_evento"],
			'codigo_evento'				=> $data["codigo_evento"]
		);
		if ($this->db->insert('Evento', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


	public function update($data, $id) {
		$data = array(
			'nombre_evento'				=> $data["nombre_evento"],
			'codigo_evento'				=> $data["codigo_evento"]

		);
		$this->db->where('Evento.id_evento', $id);
		if ($this->db->update('Evento', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function delete($id) {
		$this->db->where('Evento.id_evento', $id);
		if ($this->db->update('Evento', array('Evento.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
	
}