<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmvirtual_preguntas extends CI_Model
{
    //Clase para la tabla tb_virtual_material donde se guardan los encabezados de:
    //tareas, foros, evaluaciones, archivos

    public function __construct()
    {
        parent::__construct();
    }

    public function m_getPreguntas_simple($data)
    {
        $sqltext_array=array();
        $data_array=array();
        if (isset($data['codmaterial']) and ($data['codmaterial']!="%")) {
          $sqltext_array[]="tb_virtual_evaluacion_pregunta.codmaterial = ?";
          $data_array[]=$data['codmaterial'];
        } 
        if (isset($data['codpregunta']) and ($data['codpregunta']!="%")) {
          $sqltext_array[]="tb_virtual_evaluacion_pregunta.evpg_id = ?";
          $data_array[]=$data['codpregunta'];
        }

        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
            tb_virtual_evaluacion_pregunta.evpg_id as codpregunta,
            tb_virtual_evaluacion_pregunta.codmaterial as codmaterial,
            tb_virtual_evaluacion_pregunta.codtipopreg as codtipo,
            tb_virtual_evaluacion_pregunta.evpg_valor_max as valor,
            tb_virtual_evaluacion_pregunta.evpg_permite_vacio as premitevacio,
            tb_virtual_evaluacion_pregunta.evpg_penalidad_vacio_pts as penalidadvacio,
            tb_virtual_evaluacion_pregunta.evpg_penalidad_error_pts as penalidaderror
          FROM 
            tb_virtual_evaluacion_pregunta 
          $sqltext 
          ORDER BY evpg_posicion ASC",$data_array);
        return $result->result();
    }
}