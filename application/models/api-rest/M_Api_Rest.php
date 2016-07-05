<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_Api_Rest extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getUserByID($data) {
        $this->db->join('Tipo_usuario', 'Tipo_usuario.id_tipo_usuario = Usuario.id_tipo_usuario');
        $this->db->where('Usuario.id_usuario', $data["id_usuario"]);
        $this->db->where('Tipo_usuario.estado', '1');
        $this->db->where('Usuario.estado', '1');
        $query = $this->db->get('Usuario');
        return $query->result();
    }

    public function getUserByName($data) {
        $this->db->join('Tipo_usuario', 'Tipo_usuario.id_tipo_usuario = Usuario.id_tipo_usuario');
        $this->db->where('Usuario.usuario', $data["username"]);
        $this->db->where('Tipo_usuario.estado', '1');
        $this->db->where('Usuario.estado', '1');
        $query = $this->db->get('Usuario');
        return $query->result();
    }

    public function getUserByEmail($data) {
        $this->db->join('Tipo_usuario', 'Tipo_usuario.id_tipo_usuario = Usuario.id_tipo_usuario');
        $this->db->where('Usuario.email', $data["email"]);
        $this->db->where('Tipo_usuario.estado', '1');
        $this->db->where('Usuario.estado', '1');
        $query = $this->db->get('Usuario');
        return $query->result();
    }

    public function getOperaciones($idUsuario) {
        $this->db->join('Usuario_Operacion', 'Usuario_Operacion.id_operacion = Operacion.id_operacion');
        $this->db->join('Usuario', 'Usuario.id_usuario = Usuario_Operacion.id_usuario');
        $this->db->where('Usuario.id_usuario', $idUsuario);
        $this->db->where('Usuario.estado', '1');
        $this->db->where('Usuario_Operacion.estado', '1');
        $this->db->where('Operacion.estado', '1');
        $query = $this->db->get('Operacion');
        return $query->result();
    }

    public function getRutas($idUsuario) {
        $this->db->join('Operacion', 'Operacion.id_operacion = Ruta.id_operacion');
        $this->db->join('Usuario_Operacion', 'Usuario_Operacion.id_operacion = Operacion.id_operacion');
        $this->db->join('Usuario', 'Usuario.id_usuario = Usuario_Operacion.id_usuario');
        $this->db->where('Usuario.id_usuario', $idUsuario);
        $this->db->where('Usuario.estado', '1');
        $this->db->where('Usuario_Operacion.estado', '1');
        $this->db->where('Operacion.estado', '1');
        $this->db->where('Ruta.estado', '1');
        $query = $this->db->get('Ruta');
        return $query->result();
    }

    public function getTramos($idUsuario) {
        $this->db->join('Ruta', 'Ruta.id_ruta = Tramo.id_ruta');
        $this->db->join('Operacion', 'Operacion.id_operacion = Ruta.id_operacion');
        $this->db->join('Usuario_Operacion', 'Usuario_Operacion.id_operacion = Operacion.id_operacion');
        $this->db->join('Usuario', 'Usuario.id_usuario = Usuario_Operacion.id_usuario');
        $this->db->where('Usuario.id_usuario', $idUsuario);
        $this->db->where('Usuario.estado', '1');
        $this->db->where('Usuario_Operacion.estado', '1');
        $this->db->where('Operacion.estado', '1');
        $this->db->where('Ruta.estado', '1');
        $this->db->where('Tramo.estado', '1');
        $query = $this->db->get('Tramo');
        return $query->result();
    }

    public function getOperacionByIDTramo($idTramo) {
        $this->db->join('Ruta', 'Ruta.id_operacion = Operacion.id_operacion');
        $this->db->join('Tramo', 'Tramo.id_ruta = Ruta.id_ruta');
        $this->db->where('Tramo.id_tramo', $idTramo);
        $this->db->where('Operacion.estado', '1');
        $this->db->where('Ruta.estado', '1');
        $this->db->where('Tramo.estado', '1');
        $query = $this->db->get('Operacion');
        return $query->result();
    }

    public function getPlacas($idUsuario) {
        $this->db->join('Operacion', 'Operacion.id_operacion = Placa.id_operacion');
        $this->db->join('Usuario_Operacion', 'Usuario_Operacion.id_operacion = Operacion.id_operacion');
        $this->db->join('Usuario', 'Usuario.id_usuario = Usuario_Operacion.id_usuario');
        $this->db->where('Usuario.id_usuario', $idUsuario);
        $this->db->where('Usuario.estado', '1');
        $this->db->where('Usuario_Operacion.estado', '1');
        $this->db->where('Operacion.estado', '1');
        $this->db->where('Placa.estado', '1');
        $query = $this->db->get('Placa');
        return $query->result();
    }

    public function getEventos() {
        $this->db->where('estado', '1');
        $query = $this->db->get('Evento');
        return $query->result();
    }

    public function getCategorias() {
        $this->db->where('estado', '1');
        $query = $this->db->get('Categoria');
        return $query->result();
    }

    public function getTipos() {
        $this->db->where('estado', '1');
        $query = $this->db->get('Tipo');
        return $query->result();
    }

    public function insertEventoRiesgo($data) {
        $data = array(
            'id_usuario'        => $data["id_usuario"],
            'id_tipo'           => $data["id_tipo"],
            'id_evento'         => $data["id_evento"],
            'id_categoria'      => $data["id_categoria"],
            'id_tipo'           => $data["id_tipo"],
            'id_placa'          => $data["id_placa"],
            'id_tramo'          => $data["id_tramo"],
            'descripcion'       => $data["descripcion"],
            'fecha_registro'    => $data["fecha_registro"]
        );
        if ($this->db->insert('Evento_Riesgo', $data)) {
            return $this->db->insert_id();
        }

        return FALSE;
    }

    // ARGS: NIVEL PIRAMIDE
    //       NIVEL 1: Muerte / Incapacitantes
    //       NIVEL 2: Accidentes Daños Personales
    //       NIVEL 3: Accidentes Daños Propiedad
    //       NIVEL 4: Casi Accidentes
    //       NIVEL 5: Comportamiento de Riesgo / Condiciones Inseguras

    public function getEventosPiramide($data) {
        $sql = "SELECT 
                    `Region`.`nombre_region`,
                    `Operacion`.`nombre_operacion`,
                    `Ruta`.`nombre_ruta`,
                    `Tramo`.`nombre_tramo`,
                    `Placa`.`placa`,
                    `Usuario`.`nombre`,
                    `Usuario`.`apellidos`,
                    `Tipo_usuario`.`id_tipo_usuario`,
                    `Evento_Riesgo`.`fecha_registro`,
                    `Evento`.`nombre_evento`,
                    `Categoria`.`nombre_categoria`,
                    `Evento`.`nombre_evento`,
                    `Tipo`.`nombre_tipo`,
                    `Evento_Riesgo`.`descripcion`
                FROM `Evento_Riesgo`
                LEFT JOIN `Tipo` ON `Tipo`.`id_tipo` = `Evento_Riesgo`.`id_tipo`
                INNER JOIN `Usuario` ON `Usuario`.`id_usuario` = `Evento_Riesgo`.`id_usuario`
                INNER JOIN `Tipo_usuario` ON `Tipo_usuario`.`id_tipo_usuario` = `Usuario`.`id_tipo_usuario`
                INNER JOIN `Placa` ON `Placa`.`id_placa` = `Evento_Riesgo`.`id_placa`
                INNER JOIN `Region` ON `Region`.`id_region` = `Usuario`.`id_region`
                INNER JOIN `Categoria` ON `Categoria`.`id_categoria` = `Evento_Riesgo`.`id_categoria`
                INNER JOIN `Evento` ON `Evento`.`id_evento` = `Evento_Riesgo`.`id_evento`
                INNER JOIN `Tramo` ON `Tramo`.`id_tramo` = `Evento_Riesgo`.`id_tramo`
                INNER JOIN `Ruta` ON `Ruta`.`id_ruta` = `Tramo`.`id_ruta`
                INNER JOIN `Operacion` ON `Operacion`.`id_operacion` = `Ruta`.`id_operacion`
                [nivelPiramide]
                [conditions]
                AND (`Tipo`.`estado` = '1' OR `Tipo`.`estado` IS NULL)
                AND `Usuario`.`estado` = '1'
                AND `Tipo_usuario`.`estado` = '1'
                AND `Operacion`.`estado` = '1'
                AND `Categoria`.`estado` = '1'
                AND `Evento`.`estado` = '1'
                AND `Evento_Riesgo`.`estado` = '1'";

        switch($data["nivel_piramide"]) {
            case 1:
                $sql = str_replace("[nivelPiramide]", "WHERE `Categoria`.`nombre_categoria` = 'MUERTE / INCAPACITANTES'", $sql);
                break;
            case 2:
                $sql = str_replace("[nivelPiramide]", "WHERE `Categoria`.`nombre_categoria` = 'DAÑOS PERSONALES'", $sql);
                break;
            case 3:
                $sql = str_replace("[nivelPiramide]", "WHERE `Categoria`.`nombre_categoria` = 'DAÑOS A LA PROPIEDAD'", $sql);
                break;
            case 4:
                $sql = str_replace("[nivelPiramide]", "WHERE `Evento`.`nombre_evento` = 'CASI ACCIDENTES'", $sql);
                break;
            case 5:
                $sql = str_replace("[nivelPiramide]", "WHERE `Evento`.`nombre_evento` IN('CONDICIONES INSEGURAS', 'COMPORTAMIENTO DE RIESGO')", $sql);
                break;
        }

        if ($data["filtro"] == "nacional") {
            $sql = str_replace("[conditions]", "", $sql);
        } else if ($data["filtro"] == "region") {
            $sql = str_replace("[conditions]", "AND `Region`.`id_region` = '".$data["id_region"]."'", $sql);
        } else if ($data["filtro"] == "operacion") {
            $sql = str_replace("[conditions]", "AND `Operacion`.`id_operacion` IN('".implode("','",$data["operaciones"])."')", $sql);
        }

        $query = $this->db->query($sql);
//        echo $this->db->last_query();
        return $query->result();
    }

    public function getEventosComportamientoSeguro($data) {
        $sql = "SELECT *
                FROM `Evento_Riesgo`
                LEFT JOIN `Tipo` ON `Tipo`.`id_tipo` = `Evento_Riesgo`.`id_tipo`
                INNER JOIN `Usuario` ON `Usuario`.`id_usuario` = `Evento_Riesgo`.`id_usuario`
                INNER JOIN `Tipo_usuario` ON `Tipo_usuario`.`id_tipo_usuario` = `Usuario`.`id_tipo_usuario`
                INNER JOIN `Placa` ON `Placa`.`id_placa` = `Evento_Riesgo`.`id_placa`
                INNER JOIN `Region` ON `Region`.`id_region` = `Usuario`.`id_region`
                INNER JOIN `Categoria` ON `Categoria`.`id_categoria` = `Evento_Riesgo`.`id_categoria`
                INNER JOIN `Evento` ON `Evento`.`id_evento` = `Evento_Riesgo`.`id_evento`
                INNER JOIN `Tramo` ON `Tramo`.`id_tramo` = `Evento_Riesgo`.`id_tramo`
                INNER JOIN `Ruta` ON `Ruta`.`id_ruta` = `Tramo`.`id_ruta`
                INNER JOIN `Operacion` ON `Operacion`.`id_operacion` = `Ruta`.`id_operacion`
                [isComportamientoRiesgo]
                [conditions]
                AND (`Tipo`.`estado` = '1' OR `Tipo`.`estado` IS NULL)
                AND `Usuario`.`estado` = '1'
                AND `Tipo_usuario`.`estado` = '1'
                AND `Operacion`.`estado` = '1'
                AND `Categoria`.`estado` = '1'
                AND `Evento`.`estado` = '1'
                AND `Evento_Riesgo`.`estado` = '1'";

        if ($data["isComportamientoRiesgo"]) {
            $sql = str_replace("[isComportamientoRiesgo]", "WHERE `Evento`.`nombre_evento` IN('COMPORTAMIENTO DE RIESGO')", $sql);
        } else {
            $sql = str_replace("[isComportamientoRiesgo]", "WHERE `Evento`.`nombre_evento` IN('COMPORTAMIENTO SEGURO')", $sql);
        }

        if ($data["filtro"] == "nacional") {
            $sql = str_replace("[conditions]", "", $sql);
        } else if ($data["filtro"] == "region") {
            $sql = str_replace("[conditions]", "AND `Region`.`id_region` = '".$data["id_region"]."'", $sql);
        } else if ($data["filtro"] == "operacion") {
            $sql = str_replace("[conditions]", "AND `Operacion`.`id_operacion` IN('".implode("','",$data["operaciones"])."')", $sql);
        }

        $query = $this->db->query($sql);
//        echo $this->db->last_query();
        return $query->num_rows();
    }

    public function getEventosComportamientoSeguroExportarExcel($data) {
        $sql = "SELECT 
                    `Region`.`nombre_region`,
                    `Operacion`.`nombre_operacion`,
                    `Ruta`.`nombre_ruta`,
                    `Tramo`.`nombre_tramo`,
                    `Placa`.`placa`,
                    `Usuario`.`nombre`,
                    `Usuario`.`apellidos`,
                    `Tipo_usuario`.`id_tipo_usuario`,
                    `Evento_Riesgo`.`fecha_registro`,
                    `Evento`.`nombre_evento`,
                    `Categoria`.`nombre_categoria`,
                    `Evento`.`nombre_evento`,
                    `Tipo`.`nombre_tipo`,
                    `Evento_Riesgo`.`descripcion`
                FROM `Evento_Riesgo`
                LEFT JOIN `Tipo` ON `Tipo`.`id_tipo` = `Evento_Riesgo`.`id_tipo`
                INNER JOIN `Usuario` ON `Usuario`.`id_usuario` = `Evento_Riesgo`.`id_usuario`
                INNER JOIN `Tipo_usuario` ON `Tipo_usuario`.`id_tipo_usuario` = `Usuario`.`id_tipo_usuario`
                INNER JOIN `Placa` ON `Placa`.`id_placa` = `Evento_Riesgo`.`id_placa`
                INNER JOIN `Region` ON `Region`.`id_region` = `Usuario`.`id_region`
                INNER JOIN `Categoria` ON `Categoria`.`id_categoria` = `Evento_Riesgo`.`id_categoria`
                INNER JOIN `Evento` ON `Evento`.`id_evento` = `Evento_Riesgo`.`id_evento`
                INNER JOIN `Tramo` ON `Tramo`.`id_tramo` = `Evento_Riesgo`.`id_tramo`
                INNER JOIN `Ruta` ON `Ruta`.`id_ruta` = `Tramo`.`id_ruta`
                INNER JOIN `Operacion` ON `Operacion`.`id_operacion` = `Ruta`.`id_operacion`
                WHERE `Evento`.`nombre_evento` IN('COMPORTAMIENTO SEGURO', 'COMPORTAMIENTO DE RIESGO')
                [conditions]
                AND (`Tipo`.`estado` = '1' OR `Tipo`.`estado` IS NULL)
                AND `Usuario`.`estado` = '1'
                AND `Tipo_usuario`.`estado` = '1'
                AND `Operacion`.`estado` = '1'
                AND `Categoria`.`estado` = '1'
                AND `Evento`.`estado` = '1'
                AND `Evento_Riesgo`.`estado` = '1'
                ORDER BY `Evento`.`nombre_evento`";

        if ($data["filtro"] == "nacional") {
            $sql = str_replace("[conditions]", "", $sql);
        } else if ($data["filtro"] == "region") {
            $sql = str_replace("[conditions]", "AND `Region`.`id_region` = '".$data["id_region"]."'", $sql);
        } else if ($data["filtro"] == "operacion") {
            $sql = str_replace("[conditions]", "AND `Operacion`.`id_operacion` IN('".implode("','",$data["operaciones"])."')", $sql);
        }

        $query = $this->db->query($sql);
//        echo $this->db->last_query();
        return $query->result();

    }

    public function getEventosPiramideExportarExcel($data) {

        $sql = "SELECT 
                    `Region`.`nombre_region`,
                    `Operacion`.`nombre_operacion`,
                    `Ruta`.`nombre_ruta`,
                    `Tramo`.`nombre_tramo`,
                    `Placa`.`placa`,
                    `Usuario`.`nombre`,
                    `Usuario`.`apellidos`,
                    `Tipo_usuario`.`id_tipo_usuario`,
                    `Evento_Riesgo`.`fecha_registro`,
                    `Evento`.`nombre_evento`,
                    `Categoria`.`nombre_categoria`,
                    `Evento`.`nombre_evento`,
                    `Tipo`.`nombre_tipo`,
                    `Evento_Riesgo`.`descripcion`
                FROM `Evento_Riesgo`
                LEFT JOIN `Tipo` ON `Tipo`.`id_tipo` = `Evento_Riesgo`.`id_tipo`
                INNER JOIN `Usuario` ON `Usuario`.`id_usuario` = `Evento_Riesgo`.`id_usuario`
                INNER JOIN `Tipo_usuario` ON `Tipo_usuario`.`id_tipo_usuario` = `Usuario`.`id_tipo_usuario`
                INNER JOIN `Placa` ON `Placa`.`id_placa` = `Evento_Riesgo`.`id_placa`
                INNER JOIN `Region` ON `Region`.`id_region` = `Usuario`.`id_region`
                INNER JOIN `Categoria` ON `Categoria`.`id_categoria` = `Evento_Riesgo`.`id_categoria`
                INNER JOIN `Evento` ON `Evento`.`id_evento` = `Evento_Riesgo`.`id_evento`
                INNER JOIN `Tramo` ON `Tramo`.`id_tramo` = `Evento_Riesgo`.`id_tramo`
                INNER JOIN `Ruta` ON `Ruta`.`id_ruta` = `Tramo`.`id_ruta`
                INNER JOIN `Operacion` ON `Operacion`.`id_operacion` = `Ruta`.`id_operacion`
                WHERE `Evento`.`nombre_evento` NOT IN('COMPORTAMIENTO SEGURO')
                [conditions]
                AND (`Tipo`.`estado` = '1' OR `Tipo`.`estado` IS NULL)
                AND `Usuario`.`estado` = '1'
                AND `Tipo_usuario`.`estado` = '1'
                AND `Categoria`.`estado` = '1'
                AND `Operacion`.`estado` = '1'
                AND `Evento`.`estado` = '1'
                AND `Operacion`.`estado` = '1'
                AND `Evento_Riesgo`.`estado` = '1'";

        if ($data["filtro"] == "nacional") {
            $sql = str_replace("[conditions]", "", $sql);
        } else if ($data["filtro"] == "region") {
            $sql = str_replace("[conditions]", "AND `Region`.`id_region` = '".$data["id_region"]."'", $sql);
        } else if ($data["filtro"] == "operacion") {
            $sql = str_replace("[conditions]", "AND `Operacion`.`id_operacion` IN('".implode("','",$data["operaciones"])."')", $sql);
        }

        $query = $this->db->query($sql);
//        echo $this->db->last_query();
        return $query->result();
    }

}