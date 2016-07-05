<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Categoria extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getByID($id) {
		$this->db->where('Categoria.id_categoria', $id);
		$this->db->where('estado', '1');
		$query = $this->db->get('Categoria');
		return $query->result();
	}
	public function getCategoriasbyID($id) {
		$this->db->join('Evento', 'Evento.id_evento = Categoria.id_evento');
		$this->db->where('Categoria.id_evento', $id);
		$this->db->where('Categoria.estado', '1');
		$query = $this->db->get('Categoria');
		return $query->result();
	}
	public function getLastCode($id) {
		$query ="SELECT id_categoria FROM Categoria WHERE id_evento=".$id." ORDER BY id_categoria DESC limit 1";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getByName($nombre) {
		$this->db->where('Categoria.estado', '1');
		$this->db->where('Categoria.nombre_categoria', $nombre);
		$query = $this->db->get('Categoria');
		return $query->result();
	}
	public function getCategoria() {
		$this->db->where('estado', '1');
		$query = $this->db->get('Categoria');
		return $query->result();
	}

	public function fetch($limit, $start, $id) {
		$this->db->select("Categoria.id_categoria, Categoria.nombre_categoria,Categoria.codigo_categoria,
            Evento.id_evento, Evento.nombre_evento");
		$this->db->join('Evento', 'Evento.id_evento = Categoria.id_evento');
		$this->db->where('Categoria.id_evento', $id);
		$this->db->where('Categoria.estado', '1');
		$this->db->where('Evento.estado', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get('Categoria');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotal() {
		$this->db->where('Categoria.estado', '1');
		$query = $this->db->get('Categoria');
		return $query->num_rows();
	}

	public function insert($data) {
		$data = array(
			"nombre_categoria"		=> $data["nombre_categoria"],
			"codigo_categoria"		=> $data["codigo_categoria"],
			"id_evento"				=> $data["id_evento"]
		);
		if ($this->db->insert('Categoria', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}


	public function update($data, $id) {
		$data = array(
			"nombre_categoria"		=> $data["nombre_categoria"],
			"codigo_categoria"		=> $data["codigo_categoria"],
			"id_evento"				=> $data["id_evento"]

		);
		$this->db->where('Categoria.id_categoria', $id);
		if ($this->db->update('Categoria', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function delete($id) {
		$this->db->where('Categoria.id_categoria', $id);
		if ($this->db->update('Categoria', array('Categoria.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
	
}