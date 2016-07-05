<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Api_Rest_Evento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model('api-rest/M_Api_Rest');
    }

    public function getAllData() {
        $json 				= new stdClass();
        $json->type 		= "Nuevo Evento";
        $json->presentation = "getAllData";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ($this->input->post("id_usuario")) {

            $dataOperaciones    = $this->M_Api_Rest->getOperaciones(trim($this->input->post("id_usuario", TRUE)));
            $dataRutas          = $this->M_Api_Rest->getRutas(trim($this->input->post("id_usuario", TRUE)));
            $dataTramos         = $this->M_Api_Rest->getTramos(trim($this->input->post("id_usuario", TRUE)));
            $dataEventos        = $this->M_Api_Rest->getEventos();
            $dataCategorias     = $this->M_Api_Rest->getCategorias();
            $dataTipos          = $this->M_Api_Rest->getTipos();
            $dataPlacas         = $this->M_Api_Rest->getPlacas(trim($this->input->post("id_usuario", TRUE)));

            $data                   = new stdClass();
            $data->dataOperaciones  = $dataOperaciones;
            $data->dataRutas        = $dataRutas;
            $data->dataTramos       = $dataTramos;
            $data->dataEventos      = $dataEventos;
            $data->dataCategorias   = $dataCategorias;
            $data->dataTipos        = $dataTipos;
            $data->dataPlacas       = $dataPlacas;

            $json->data         = $data;
            $json->message      = "Todos los registros fueron recuperados correctamente.";
            $json->status       = TRUE;

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function registrarEvento() {
        $json 				= new stdClass();
        $json->type 		= "Nuevo Evento";
        $json->presentation = "insert";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ($this->input->post("id_usuario") &&
            $this->input->post("id_placa") &&
            $this->input->post("id_evento") &&
            $this->input->post("id_categoria") &&
            $this->input->post("id_tramo") &&
            $this->input->post("descripcion") &&
            $this->input->post("fecha_registro")) {

            if ($this->validarOperacionUsuarioRegistroEvento()) {
                $idEventoRiesgo    = $this->M_Api_Rest->insertEventoRiesgo(
                    array(
                        "id_usuario"        => trim($this->input->post("id_usuario", TRUE)),
                        "id_evento"         => trim($this->input->post("id_evento", TRUE)),
                        "id_categoria"      => trim($this->input->post("id_categoria", TRUE)),
                        "id_tipo"           => trim($this->input->post("id_tipo", TRUE)),
                        "id_placa"          => trim($this->input->post("id_placa", TRUE)),
                        "id_tramo"          => trim($this->input->post("id_tramo", TRUE)),
                        "descripcion"       => trim($this->input->post("descripcion", TRUE)),
                        "fecha_registro"    => trim($this->input->post("fecha_registro", TRUE))
                    )
                );

                if (is_int($idEventoRiesgo)) {
                    $data                   = new stdClass();
                    $data->id_evento_riesgo = $idEventoRiesgo;
                    $json->data             = $data;
                    $json->message          = "Su evento fue registrado correctamente.";
                    $json->status           = TRUE;
                }
            } else {
                $json->message 	= "Lo sentimos, la operación seleccionada no se encuentra asignada a su usuario. Sincronice los datos de registro de eventos correctamente e inténtalo de nuevo.";
            }

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function getEventosPiramide() {
        $json 				= new stdClass();
        $json->type 		= "Eventos";
        $json->presentation = "select";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ($this->input->post("id_usuario") &&
            $this->input->post("tipo_usuario") &&
            $this->input->post("id_tipo_usuario") &&
            $this->input->post("filtro")) {

            $usuario = $this->M_Api_Rest->getUserByID(
                array(
                    "id_usuario"        => trim($this->input->post("id_usuario", TRUE))
                )
            );

            if (sizeof($usuario) > 0) {
                $data = new stdClass();

                if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 1) {

                    $IDOperacionesUsuario = $this->getOperacionesUsuario($usuario[0]->id_usuario);

                    $data->piramide_nivel_1 = sizeof($this->M_Api_Rest->getEventosPiramide(
                        array(
                            "nivel_piramide"    => 1,
                            "id_region"         => $usuario[0]->id_region,
                            "filtro"            => trim($this->input->post("filtro", TRUE)),
                            "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    ));
                    $data->piramide_nivel_2 = sizeof($this->M_Api_Rest->getEventosPiramide(
                        array(
                            "nivel_piramide"    => 2,
                            "id_region"         => $usuario[0]->id_region,
                            "filtro"            => trim($this->input->post("filtro", TRUE)),
                            "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    ));
                    $data->piramide_nivel_3 = sizeof($this->M_Api_Rest->getEventosPiramide(
                        array(
                            "nivel_piramide"    => 3,
                            "id_region"         => $usuario[0]->id_region,
                            "filtro"            => trim($this->input->post("filtro", TRUE)),
                            "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    ));
                    $data->piramide_nivel_4 = sizeof($this->M_Api_Rest->getEventosPiramide(
                        array(
                            "nivel_piramide"    => 4,
                            "id_region"         => $usuario[0]->id_region,
                            "filtro"            => trim($this->input->post("filtro", TRUE)),
                            "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    ));
                    $data->piramide_nivel_5 = sizeof($this->M_Api_Rest->getEventosPiramide(
                        array(
                            "nivel_piramide"    => 5,
                            "id_region"         => $usuario[0]->id_region,
                            "filtro"            => trim($this->input->post("filtro", TRUE)),
                            "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    ));

                    $json->data             = $data;
                    $json->message          = "Registo de eventos de riesgo filtrados correctamente.";
                    $json->status           = TRUE;

                } else if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 2) {

                    if ($this->validarSolicitudConOperaciones()) {

                        $data->piramide_nivel_1 = sizeof($this->M_Api_Rest->getEventosPiramide(
                            array(
                                "nivel_piramide"    => 1,
                                "id_region"         => trim($this->input->post("id_region", TRUE)),
                                "filtro"            => trim($this->input->post("filtro", TRUE)),
                                "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        ));
                        $data->piramide_nivel_2 = sizeof($this->M_Api_Rest->getEventosPiramide(
                            array(
                                "nivel_piramide"    => 2,
                                "id_region"         => trim($this->input->post("id_region", TRUE)),
                                "filtro"            => trim($this->input->post("filtro", TRUE)),
                                "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        ));
                        $data->piramide_nivel_3 = sizeof($this->M_Api_Rest->getEventosPiramide(
                            array(
                                "nivel_piramide"    => 3,
                                "id_region"         => trim($this->input->post("id_region", TRUE)),
                                "filtro"            => trim($this->input->post("filtro", TRUE)),
                                "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        ));
                        $data->piramide_nivel_4 = sizeof($this->M_Api_Rest->getEventosPiramide(
                            array(
                                "nivel_piramide"    => 4,
                                "id_region"         => trim($this->input->post("id_region", TRUE)),
                                "filtro"            => trim($this->input->post("filtro", TRUE)),
                                "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        ));
                        $data->piramide_nivel_5 = sizeof($this->M_Api_Rest->getEventosPiramide(
                            array(
                                "nivel_piramide"    => 5,
                                "id_region"         => trim($this->input->post("id_region", TRUE)),
                                "filtro"            => trim($this->input->post("filtro", TRUE)),
                                "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        ));

                        $json->data             = $data;
                        $json->message          = "Registo de eventos de riesgo filtrados correctamente.";
                        $json->status           = TRUE;

                    } else {
                        $json->message 	= "Lo sentimos, la operación seleccionada no se encuentra asignada a su usuario. Sincronice los datos de registro de eventos correctamente e inténtalo de nuevo.";
                    }

                } else {
                    $json->message 	= "Lo sentimos, el tipo de usuario no es correcto o no tiene permisos de acceso a esta informacion.";
                }

            } else {
                $json->message 	= "Lo sentimos, la cuenta de usuario no se encuentra registrado";
            }

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function getEventosComportamientoSeguro() {
        $json 				= new stdClass();
        $json->type 		= "Eventos";
        $json->presentation = "select";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ($this->input->post("id_usuario") &&
            $this->input->post("tipo_usuario") &&
            $this->input->post("id_tipo_usuario") &&
            $this->input->post("filtro")) {

            $usuario = $this->M_Api_Rest->getUserByID(
                array(
                    "id_usuario"        => trim($this->input->post("id_usuario", TRUE))
                )
            );

            if (sizeof($usuario) > 0) {
                $data = new stdClass();

                if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 1) {

                    $IDOperacionesUsuario = $this->getOperacionesUsuario($usuario[0]->id_usuario);

                    $data->comportamiento_riesgo = $this->M_Api_Rest->getEventosComportamientoSeguro(
                        array(
                            "id_region"                 => $usuario[0]->id_region,
                            "filtro"                    => trim($this->input->post("filtro", TRUE)),
                            "operaciones"               => array(trim($this->input->post("id_operacion", TRUE))),
                            "isComportamientoRiesgo"    => true
                        )
                    );

                    $data->comportamiento_seguro = $this->M_Api_Rest->getEventosComportamientoSeguro(
                        array(
                            "id_region"                 => $usuario[0]->id_region,
                            "filtro"                    => trim($this->input->post("filtro", TRUE)),
                            "operaciones"               => array(trim($this->input->post("id_operacion", TRUE))),
                            "isComportamientoRiesgo"    => false
                        )
                    );

                    $json->data             = $data;
                    $json->message          = "Registo de eventos de riesgo filtrados correctamente.";
                    $json->status           = TRUE;

                } else if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 2) {

                    if ($this->validarSolicitudConOperaciones()) {

                        $data->comportamiento_riesgo = $this->M_Api_Rest->getEventosComportamientoSeguro(
                            array(
                                "id_region"                 => trim($this->input->post("id_region", TRUE)),
                                "filtro"                    => trim($this->input->post("filtro", TRUE)),
                                "operaciones"               => array(trim($this->input->post("id_operacion", TRUE))),
                                "isComportamientoRiesgo"    => true
                            )
                        );

                        $data->comportamiento_seguro = $this->M_Api_Rest->getEventosComportamientoSeguro(
                            array(
                                "id_region"                 => trim($this->input->post("id_region", TRUE)),
                                "filtro"                    => trim($this->input->post("filtro", TRUE)),
                                "operaciones"               => array(trim($this->input->post("id_operacion", TRUE))),
                                "isComportamientoRiesgo"    => false
                            )
                        );

                        $json->data             = $data;
                        $json->message          = "Registo de comportamientos seguros filtrados correctamente.";
                        $json->status           = TRUE;

                    } else {
                        $json->message 	= "Lo sentimos, la operación seleccionada no se encuentra asignada a su usuario. Sincronice los datos de registro de eventos correctamente e inténtalo de nuevo.";
                    }

                } else {
                    $json->message 	= "Lo sentimos, el tipo de usuario no es correcto o no tiene permisos de acceso a esta informacion.";
                }

            } else {
                $json->message 	= "Lo sentimos, la cuenta de usuario no se encuentra registrado";
            }

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function getEventosComportamientoSeguroExportarExcel() {
        $json 				= new stdClass();
        $json->type 		= "Eventos";
        $json->presentation = "select";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ($this->input->post("id_usuario") &&
            $this->input->post("tipo_usuario") &&
            $this->input->post("id_tipo_usuario") &&
            $this->input->post("filtro")) {

            $usuario = $this->M_Api_Rest->getUserByID(
                array(
                    "id_usuario"        => trim($this->input->post("id_usuario", TRUE))
                )
            );

            if (sizeof($usuario) > 0) {
                $data = new stdClass();

                if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 1) {

                    $IDOperacionesUsuario = $this->getOperacionesUsuario($usuario[0]->id_usuario);

                    $registros = $this->M_Api_Rest->getEventosComportamientoSeguroExportarExcel(
                        array(
                            "id_region"                 => $usuario[0]->id_region,
                            "filtro"                    => trim($this->input->post("filtro", TRUE)),
                            "operaciones"               => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    );

                    $json->data             = $registros;
                    $json->message          = "Registo de eventos de riesgo filtrados correctamente.";
                    $json->status           = TRUE;

                } else if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 2) {

                    if ($this->validarSolicitudConOperaciones()) {

                        $registros = $this->M_Api_Rest->getEventosComportamientoSeguroExportarExcel(
                            array(
                                "id_region"                 => trim($this->input->post("id_region", TRUE)),
                                "filtro"                    => trim($this->input->post("filtro", TRUE)),
                                "operaciones"               => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        );

                        $json->data             = $registros;
                        $json->message          = "Registo de eventos de riesgo filtrados correctamente.";
                        $json->status           = TRUE;

                    } else {
                        $json->message 	= "Lo sentimos, la operación seleccionada no se encuentra asignada a su usuario. Sincronice los datos de registro de eventos correctamente e inténtalo de nuevo.";
                    }

                } else {
                    $json->message 	= "Lo sentimos, el tipo de usuario no es correcto o no tiene permisos de acceso a esta informacion.";
                }

            } else {
                $json->message 	= "Lo sentimos, la cuenta de usuario no se encuentra registrado";
            }

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    public function getEventosPiramideExportarExcel() {
        $json 				= new stdClass();
        $json->type 		= "Eventos";
        $json->presentation = "select";
        $json->data 		= array();
        $json->status 		= FALSE;

        if ($this->input->post("id_usuario") &&
            $this->input->post("tipo_usuario") &&
            $this->input->post("id_tipo_usuario") &&
            $this->input->post("filtro")) {

            $usuario = $this->M_Api_Rest->getUserByID(
                array(
                    "id_usuario"        => trim($this->input->post("id_usuario", TRUE))
                )
            );

            if (sizeof($usuario) > 0) {

                if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 1) {

                    $IDOperacionesUsuario = $this->getOperacionesUsuario($usuario[0]->id_usuario);

                    $registros = $this->M_Api_Rest->getEventosPiramideExportarExcel(
                        array(
                            "id_region"         => $usuario[0]->id_region,
                            "filtro"            => trim($this->input->post("filtro", TRUE)),
                            "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                        )
                    );

                    $json->data             = $registros;
                    $json->message          = "Registo de eventos de riesgo filtrados correctamente.";
                    $json->status           = TRUE;

                } else if (intval(trim($this->input->post("id_tipo_usuario", TRUE))) == 2) {

                    if ($this->validarSolicitudConOperaciones()) {

                        $registros = $this->M_Api_Rest->getEventosPiramideExportarExcel(
                            array(
                                "id_region"         => trim($this->input->post("id_region", TRUE)),
                                "filtro"            => trim($this->input->post("filtro", TRUE)),
                                "operaciones"       => array(trim($this->input->post("id_operacion", TRUE)))
                            )
                        );

                        $json->data             = $registros;
                        $json->message          = "Registo de eventos de riesgo filtrados correctamente.";
                        $json->status           = TRUE;

                    } else {
                        $json->message 	= "Lo sentimos, la operación seleccionada no se encuentra asignada a su usuario. Sincronice los datos de registro de eventos correctamente e inténtalo de nuevo.";
                    }

                } else {
                    $json->message 	= "Lo sentimos, el tipo de usuario no es correcto o no tiene permisos de acceso a esta informacion.";
                }

            } else {
                $json->message 	= "Lo sentimos, la cuenta de usuario no se encuentra registrado.";
            }

        } else {
            $json->message 	= "No se recibio los parametros necesarios para procesar su solicitud.";
        }

        echo json_encode($json);
    }

    private function validarSolicitudConOperaciones() {
        $validarIntegridadOperaciones = true;

        if (trim($this->input->post("filtro", TRUE)) == "operacion") {
            if ( $this->validarOperacionUsuario(trim($this->input->post("id_operacion", TRUE))) == false ) {
                $validarIntegridadOperaciones = false;
            }
        }

        return $validarIntegridadOperaciones;
    }

    private function validarOperacionUsuarioRegistroEvento() {
        $operacion = $this->M_Api_Rest->getOperacionByIDTramo(trim($this->input->post("id_tramo", TRUE)));

        $operacionesUsuario = $this->M_Api_Rest->getOperaciones(trim($this->input->post("id_usuario", TRUE)));

        if (sizeof($operacionesUsuario) > 0) {
            foreach($operacionesUsuario as $operacionUsuario) {
                if ($operacionUsuario->id_operacion == $operacion[0]->id_operacion) {
                    return true;
                }
            }
        }

        return false;
    }

    private function validarOperacionUsuario($idOperacion) {
        $operacionesUsuario = $this->M_Api_Rest->getOperaciones(trim($this->input->post("id_usuario", TRUE)));

        if (sizeof($operacionesUsuario) > 0) {
            foreach($operacionesUsuario as $operacionUsuario) {
                if ($operacionUsuario->id_operacion == $idOperacion) {
                    return true;
                }
            }
        }

        return false;
    }

    private function getOperacionesUsuario($idUsuario) {
        $operacionesUsuario = $this->M_Api_Rest->getOperaciones($idUsuario);

        $IDOperacionesUsuario = array();

        foreach($operacionesUsuario as $operacion) {
            array_push($IDOperacionesUsuario, $operacion->id_operacion);
        }

        return $IDOperacionesUsuario;
    }

}