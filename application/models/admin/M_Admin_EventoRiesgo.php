<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Admin_EventoRiesgo extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function getTotal() {
		$this->db->where('Evento_Riesgo.estado', '1');
		$this->db->where('Evento_Riesgo.id_usuario');
		$query = $this->db->get('Evento_Riesgo');
		return $query->result();
	}
	public function fetchEventoRiesgo($limit, $start, $id) {
		$this->db->select("
       		Evento_Riesgo.id_evento_riesgo,
            Evento_Riesgo.fecha_registro,
            Evento_Riesgo.descripcion,
            Usuario.id_usuario,
            Region.id_region,
            Region.nombre_region,
            Operacion.id_operacion,
            Operacion.nombre_operacion,
            Ruta.id_ruta,
            Ruta.nombre_ruta,
            Tramo.id_tramo,
            Tramo.nombre_tramo,
            Evento.id_evento,
            Evento.nombre_evento,
            Evento.codigo_evento,
            Categoria.id_categoria,
            Categoria.nombre_categoria,
            Categoria.codigo_categoria,
            Tipo.id_tipo,
            Tipo.nombre_tipo,
            Tipo.codigo_tipo,
            Placa.id_placa,
            Placa.placa
            ");
		$this->db->join('Placa', 'Placa.id_placa = Evento_Riesgo.id_placa');

		$this->db->join('Usuario', 'Usuario.id_usuario = Evento_Riesgo.id_usuario');

		$this->db->join('Tipo', 'Tipo.id_tipo = Evento_Riesgo.id_tipo', 'left');
		$this->db->join('Categoria', 'Categoria.id_categoria = Evento_Riesgo.id_categoria');
		$this->db->join('Evento', 'Evento.id_evento = Evento_Riesgo.id_evento');

		$this->db->join('Tramo', 'Tramo.id_tramo = Evento_Riesgo.id_tramo');
		$this->db->join('Ruta', 'Ruta.id_ruta = Tramo.id_ruta');
		$this->db->join('Operacion', 'Operacion.id_operacion = Ruta.id_operacion');
		$this->db->join('Region', 'Region.id_region = Operacion.id_region');

		$this->db->where('Usuario.estado', '1');
//		$this->db->where('Tipo.estado', '1');
		$this->db->where('Placa.estado', '1');
		$this->db->where('Tramo.estado', '1');
		$this->db->where('Evento_Riesgo.estado', '1');
		$this->db->where('Evento_Riesgo.id_usuario', $id);
		$this->db->limit($limit, $start);
		$query = $this->db->get('Evento_Riesgo');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}
	public function fetchEventoRiesgoAll($limit, $start) {
		$this->db->select("
       		Evento_Riesgo.id_evento_riesgo,
            Evento_Riesgo.fecha_registro,
            Evento_Riesgo.descripcion,
            Usuario.id_usuario,
            Usuario.nombre,
            Usuario.apellidos,
            Region.id_region,
            Region.nombre_region,
            Operacion.id_operacion,
            Operacion.nombre_operacion,
            Ruta.id_ruta,
            Ruta.nombre_ruta,
            Tramo.id_tramo,
            Tramo.nombre_tramo,
            Evento.id_evento,
            Evento.nombre_evento,
            Evento.codigo_evento,
            Categoria.id_categoria,
            Categoria.nombre_categoria,
            Categoria.codigo_categoria,
            Tipo.id_tipo,
            Tipo.nombre_tipo,
            Tipo.codigo_tipo,
            Placa.id_placa,
            Placa.placa
            ");
		$this->db->join('Placa', 'Placa.id_placa = Evento_Riesgo.id_placa');

		$this->db->join('Usuario', 'Usuario.id_usuario = Evento_Riesgo.id_usuario');

		$this->db->join('Tipo', 'Tipo.id_tipo = Evento_Riesgo.id_tipo', 'left');
		$this->db->join('Categoria', 'Categoria.id_categoria = Evento_Riesgo.id_categoria');
		$this->db->join('Evento', 'Evento.id_evento = Evento_Riesgo.id_evento');

		$this->db->join('Tramo', 'Tramo.id_tramo = Evento_Riesgo.id_tramo');
		$this->db->join('Ruta', 'Ruta.id_ruta = Tramo.id_ruta');
		$this->db->join('Operacion', 'Operacion.id_operacion = Ruta.id_operacion');
		$this->db->join('Region', 'Region.id_region = Operacion.id_region');

		$this->db->where('Usuario.estado', '1');
//		$this->db->where('Tipo.estado', '1');
		$this->db->where('Placa.estado', '1');
		$this->db->where('Tramo.estado', '1');
		$this->db->where('Evento_Riesgo.estado', '1');
		$this->db->order_by("Evento_Riesgo.id_evento_riesgo", "asc");
		$this->db->limit($limit, $start);
		$query = $this->db->get('Evento_Riesgo');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}

		return FALSE;
	}

	public function getTotalEventosRiesgo($id) {
		$this->db->join('Placa', 'Placa.id_placa = Evento_Riesgo.id_placa');

		$this->db->join('Usuario', 'Usuario.id_usuario = Evento_Riesgo.id_usuario');

		$this->db->join('Tipo', 'Tipo.id_tipo = Evento_Riesgo.id_tipo','left');
		$this->db->join('Categoria', 'Categoria.id_categoria = Evento_Riesgo.id_categoria');
		$this->db->join('Evento', 'Evento.id_evento = Evento_Riesgo.id_evento');

		$this->db->join('Tramo', 'Tramo.id_tramo = Evento_Riesgo.id_tramo');
		$this->db->join('Ruta', 'Ruta.id_ruta = Tramo.id_ruta');
		$this->db->join('Operacion', 'Operacion.id_operacion = Ruta.id_operacion');
		$this->db->join('Region', 'Region.id_region = Operacion.id_region');

		$this->db->where('Usuario.estado', '1');
//		$this->db->where('Tipo.estado', '1');
		$this->db->where('Placa.estado', '1');
		$this->db->where('Tramo.estado', '1');
		$this->db->where('Evento_Riesgo.estado', '1');
		$this->db->where('Evento_Riesgo.id_usuario', $id);
		$query = $this->db->get('Evento_Riesgo');
		return $query->num_rows();
	}

	public function getTotalEventosRiesgoAll() {
		$this->db->join('Placa', 'Placa.id_placa = Evento_Riesgo.id_placa');

		$this->db->join('Usuario', 'Usuario.id_usuario = Evento_Riesgo.id_usuario');

		$this->db->join('Tipo', 'Tipo.id_tipo = Evento_Riesgo.id_tipo','left');
		$this->db->join('Categoria', 'Categoria.id_categoria = Evento_Riesgo.id_categoria');
		$this->db->join('Evento', 'Evento.id_evento = Evento_Riesgo.id_evento');

		$this->db->join('Tramo', 'Tramo.id_tramo = Evento_Riesgo.id_tramo');
		$this->db->join('Ruta', 'Ruta.id_ruta = Tramo.id_ruta');
		$this->db->join('Operacion', 'Operacion.id_operacion = Ruta.id_operacion');
		$this->db->join('Region', 'Region.id_region = Operacion.id_region');

		$this->db->where('Usuario.estado', '1');
//		$this->db->where('Tipo.estado', '1');
		$this->db->where('Placa.estado', '1');
		$this->db->where('Tramo.estado', '1');
		$this->db->where('Evento_Riesgo.estado', '1');
		$query = $this->db->get('Evento_Riesgo');
		return $query->num_rows();
	}



	public function insert($data) {
		$data = array(
			"id_usuario"			=> $data["id_usuario"],
			"id_tramo"				=> $data["id_tramo"],
			"id_evento"				=> $data["id_evento"],
			"id_categoria"			=> $data["id_categoria"],
			"id_tipo"				=> $data["id_tipo"],
			"id_placa"				=> $data["id_placa"],
			"fecha_registro"		=> $data["fecha_registro"],
			"descripcion"			=> $data["descripcion"]
			
		);
		if ($this->db->insert('Evento_Riesgo', $data)) {
			return $this->db->insert_id();
		}
		
		return FALSE;
	}

	public function delete($id) {
		$this->db->where('Evento_Riesgo.id_evento_riesgo', $id);
		if ($this->db->update('Evento_Riesgo', array('Evento_Riesgo.estado' => 0)))	{
			return TRUE;
		}
		return FALSE;
	}


	

}