<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_GeoData extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function getDepartamento() {
        $this->db->where('estado', '1');
        $query = $this->db->get('Departamento');
        return $query->result();
    }

    public function getProvincia($id) {
        $this->db->where('Provincia.estado', '1');
        $this->db->where('Provincia.idDepartamento', $id);
        $query = $this->db->get('Provincia');
        return $query->result();
    }

    public function getDistrito($id) {
        $this->db->where('Distrito.estado', '1');
        $this->db->where('Distrito.idProvincia', $id);
        $query = $this->db->get('Distrito');
        return $query->result();
    }


}