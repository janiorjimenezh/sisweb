<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmvirtual_respuestas extends CI_Model
{
    //Clase para la tabla tb_virtual_material donde se guardan los encabezados de:
    //tareas, foros, evaluaciones, archivos

    public function __construct()
    {
        parent::__construct();
    }

    public function m_getRespuestas_simple($data)
    {
        $sqltext_array=array();
        $data_array=array();
        if (isset($data['codmaterial']) and ($data['codmaterial']!="%")) {
          $sqltext_array[]="tb_virtual_evaluacion_respuesta.codmaterial = ?";
          $data_array[]=$data['codmaterial'];
        } 
        if (isset($data['codpregunta']) and ($data['codpregunta']!="%")) {
          $sqltext_array[]="tb_virtual_evaluacion_respuesta.evpg_id = ?";
          $data_array[]=$data['codpregunta'];
        }
        if (isset($data['escorrecta']) and ($data['escorrecta']!="%")) {
          $sqltext_array[]="tb_virtual_evaluacion_respuesta.evrp_escorrecta = ?";
          $data_array[]=$data['escorrecta'];
        }
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
            evrp_id as codrespuesta,
            id_pregunta as codpregunta,
            evrp_valor_max as valor,
            evrp_escorrecta as correcta
          FROM
            tb_virtual_evaluacion_respuesta 
          $sqltext",$data_array);
        return $result->result();
    }
}