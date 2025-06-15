<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Minscrito_consolidados extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_cambiar_estado($items)
    {
      //CALL ( @vniv_codigo, @vniv_estado, @s);
      $this->db->query("CALL sp_tb_inscripcion_update_estado(?,?,?,@s)",$items);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function mFiltrarInscripciones_culminados($data=array())
    {
      $sqltext_array=array();
      $data_array=array();
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_inscripcion.ins_sede = ?";
        $data_array[]=$data['codsede'];
      }
      if (isset($data['cod_periodo_culminado']) and ($data['cod_periodo_culminado']!="%")) {
        $sqltext_array[]="tb_inscripcion.cod_periodo_culminado = ?";
        $data_array[]=$data['cod_periodo_culminado'];
      }
      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_inscripcion.cod_carrera = ?";
        $data_array[]=$data['codcarrera'];
      }
      if (isset($data['convalida']) and ($data['convalida']!='%')) {
        $sqltext_array[]="tb_inscripcion.ins_convalida_unidades = ?";
        $data_array[]=$data['convalida'];
      } 
      $sqltext_array[]="tb_inscripcion.cod_periodo_culminado IS NOT NULL"; 
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
              tb_inscripcion.ins_sede AS codsede,
              tb_inscripcion.cod_periodo_culminado AS codperiodo,
              tb_inscripcion.cod_carrera AS codcarrera,
              COUNT(tb_inscripcion.ins_identificador) AS total
            FROM
              tb_inscripcion
            $sqltext
            GROUP BY
              tb_inscripcion.ins_sede,
              tb_inscripcion.cod_periodo_culminado,
              tb_inscripcion.cod_carrera
            ORDER BY
              codsede,
              codperiodo,
              codcarrera",$data_array);
        return $result->result();
    }

    public function mFiltrarInscripciones_egresados($data=array())
    {
      $sqltext_array=array();
      $data_array=array();
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_inscripcion.ins_sede = ?";
        $data_array[]=$data['codsede'];
      }
      if (isset($data['codperiodo_egresado']) and ($data['codperiodo_egresado']!="%")) {
        $sqltext_array[]="tb_inscripcion.cod_periodo_egresado = ?";
        $data_array[]=$data['codperiodo_egresado'];
      }
      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_inscripcion.cod_carrera = ?";
        $data_array[]=$data['codcarrera'];
      }
      if (isset($data['convalida']) and ($data['convalida']!='%')) {
        $sqltext_array[]="tb_inscripcion.ins_convalida_unidades = ?";
        $data_array[]=$data['convalida'];
      } 
      $sqltext_array[]="tb_inscripcion.cod_periodo_egresado IS NOT NULL"; 
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
              tb_inscripcion.ins_sede AS codsede,
              tb_inscripcion.cod_periodo_egresado AS codperiodo,
              tb_inscripcion.cod_carrera AS codcarrera,
              COUNT(tb_inscripcion.ins_identificador) AS total
            FROM
              tb_inscripcion
            $sqltext               
            GROUP BY
              tb_inscripcion.ins_sede,
              tb_inscripcion.cod_periodo_egresado,
              tb_inscripcion.cod_carrera
            ORDER BY
              codsede,
              codperiodo,
              codcarrera",$data_array);
        return $result->result();
    }
}
