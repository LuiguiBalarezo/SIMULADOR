<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Tipo extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id) {
		$this->db->where('Tipo.id_tipo', $id);
		$this->db->where('estado', '1');
		$query = $this->db->get('Tipo');
		return $query->result();
	}
	public function getTiposbyID($id) {
		$this->db->where('Tipo.id_categoria', $id);
		$this->db->where('estado', '1');
		$query = $this->db->get('Tipo');
		return $query->result();
	}
	public function getLastCode($id) {
		$query ="SELECT id_tipo FROM Tipo WHERE id_categoria=".$id." ORDER BY id_tipo DESC limit 1";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getByName($nombre) {
		$this->db->where('Tipo.estado', '1');
		$this->db->where('Tipo.nombre_tipo', $nombre);
		$query = $this->db->get('Tipo');
		return $query->result();
	}
	public function getCategoria() {
		$this->db->where('estado', '1');
		$query = $this->db->get('Tipo');
		return $query->result();
	}

	public function fetch($limit, $start, $id) {
		$this->db->select("Tipo.id_tipo, Tipo.nombre_tipo,Tipo.codigo_tipo");
		$this->db->join('Categoria', 'Categoria.id_categoria = Tipo.id_categoria');
		$this->db->where('Tipo.id_categoria', $id);
		$this->db->where('Categoria.estado', '1');
		$this->db->where('Tipo.estado', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get('Tipo');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotal($id) {
		$this->db->where('Tipo.estado', '1');
		$this->db->where('Tipo.id_categoria', $id);
		$query = $this->db->get('Tipo');
		return $query->num_rows();
	}

	public function insert($data) {
		$data = array(
			"nombre_tipo"			=> $data["nombre_tipo"],
			"codigo_tipo"			=> $data["codigo_tipo"],
			"id_categoria"			=> $data["id_categoria"]
		);
		if ($this->db->insert('Tipo', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


	public function update($data, $id) {
		$data = array(
			"nombre_tipo"			=> $data["nombre_tipo"],
			"codigo_tipo"			=> $data["codigo_tipo"],
			"id_categoria"			=> $data["id_categoria"]

		);
		$this->db->where('Tipo.id_tipo', $id);
		if ($this->db->update('Tipo', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function delete($id) {
		$this->db->where('Tipo.id_tipo', $id);
		if ($this->db->update('Tipo', array('Tipo.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
	public function getEvento($id) {
		$this->db->select('Evento.id_evento,Evento.nombre_evento,Categoria.id_categoria, Categoria.nombre_categoria');
		$this->db->join('Categoria', 'Categoria.id_categoria = Tipo.id_categoria');
		$this->db->join('Evento', 'Evento.id_evento = Categoria.id_evento');
		$this->db->where('Tipo.id_categoria', $id);
		$query = $this->db->get('Tipo',1);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}
	
	
}