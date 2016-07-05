<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_Region extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getRegion() {
		$this->db->where('estado', '1');
		$query = $this->db->get('Region');
		return $query->result();
	}

	public function fetchTipoEmpresas($limit, $start) {
		$this->db->select("	Tipo_Empresa.id_tipo_empresa, Tipo_Empresa.nombre_tipo_empresa,");
		$this->db->where('Tipo_Empresa.estado', '1');
		$this->db->limit($limit, $start);
		$query = $this->db->get('Tipo_Empresa');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotalTipoEmpresas() {
		$this->db->where('Tipo_Empresa.estado', '1');
		$query = $this->db->get('Tipo_Empresa');
		return $query->num_rows();
	}

	public function insertTipoEmpresa($nombre_tipo_empresa) {
		$data = array(
			'nombre_tipo_empresa'			=> $nombre_tipo_empresa
		);
		if ($this->db->insert('Tipo_Empresa', $data)) {
			return $this->db->insert_id();
		}

		return FALSE;
	}

	public function getTipoEmpresaByID($id_tipoempresa) {
		$this->db->select("	Tipo_Empresa.id_tipo_empresa, Tipo_Empresa.nombre_tipo_empresa,");
		$this->db->where('Tipo_Empresa.estado', '1');
		$this->db->where('Tipo_Empresa.id_tipo_empresa', $id_tipoempresa);
		$query = $this->db->get('Tipo_Empresa');
		return $query->result();
	}

	public function update($id_tipo_empresa, $nombre_tipo_empresa) {
		$data = array(
			'id_tipo_empresa'			=> $id_tipo_empresa,
			'nombre_tipo_empresa'		=> $nombre_tipo_empresa
		);

		$this->db->where('Tipo_Empresa.id_tipo_empresa', $id_tipo_empresa);
		if ($this->db->update('Tipo_Empresa', $data)) {
			return TRUE;
		}

		return FALSE;
	}

	public function delete($id_tipo_empresa) {
		$this->db->where('Tipo_Empresa.id_tipo_empresa', $id_tipo_empresa);
		if ($this->db->update('Tipo_Empresa', array('Tipo_Empresa.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}
}