<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mperiodo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_getPeriodos($data)
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['tipo']) and ($data['tipo']!="%")) {
            $sqltext_array[]="tb_periodo.ped_tipo = ?";
            $data_array[]=$data['tipo'];
        } 
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
              ped_codigo as codigo,
              ped_nombre as nombre,
              ped_anio as anio,
              ped_estado as estado,
              ped_tipo as tipo 
            FROM 
              tb_periodo 
            $sqltext  
            ORDER BY ped_nombre DESC;",$data_array);
        return $result->result();
    }

    public function m_get_periodos()
    {
        $result = $this->db->query("SELECT 
              ped_codigo as codigo,
              ped_nombre as nombre,
              ped_anio as anio,
              ped_estado as estado,
              ped_tipo as tipo 
            FROM 
              tb_periodo  ORDER BY ped_nombre DESC;");
        return $result->result();
    }

    public function m_get_periodosxestado()
    {
        $result = $this->db->query("SELECT 
              ped_codigo as codigo,
              ped_nombre as nombre,
              ped_anio as anio
            FROM 
              tb_periodo WHERE ped_estado='ACTIVO' ORDER BY ped_codigo DESC");
        return $result->result();
    }
    public function m_get_periodos_para_inscribir()
    {
        $result = $this->db->query("SELECT 
              ped_codigo as codigo,
              ped_nombre as nombre,
              ped_anio as anio
            FROM 
              tb_periodo WHERE ped_inscripciones='SI' ORDER BY ped_codigo DESC");
        return $result->result();
    }

     public function Insert_datos_periodo($data){
        $this->db->query("CALL sp_tb_periodo_insert(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_periodos()
    {
        $rsper=array();
        $result = $this->db->query("SELECT  ped_codigo as codigo, ped_nombre as nombre, ped_activo as activ, ped_anio as anio, ped_estado as estado
                  FROM tb_periodo ORDER BY ped_codigo DESC");
        $rsper=$result->result();
        return array('periodos' => $rsper);
    }

    public function Update_datos_periodo($data){
        $this->db->query("CALL sp_tb_periodo_update(?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_eliminaper($idper)
    {
        $dbm = $this->load->database();
        $qry = $this->db->query("DELETE FROM tb_periodo where ped_codigo=?", $idper);
        $this->db->close();
        return 1;
    }

    public function Update_activo_periodo($data){
        $this->db->query("CALL sp_tb_periodo_activ_update(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function Update_status_inscripperiodo($data){
        $this->db->query("CALL sp_tb_periodo_estado_inscripcion_update(?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        //$this->db->close();   
        return   $res->row()->out_param;    
    }

    public function m_cambiar_responsable($data){   
      $this->db->query("CALL sp_tb_periodo_docente_update(?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_get_periodosxnombre($nomper)
    {
        $result = $this->db->query("SELECT 
                  tb_periodo.ped_codigo codigo,
                  tb_periodo.ped_nombre nombre,
                  tb_periodo.ped_activo activ,
                  tb_periodo.ped_anio anio,
                  tb_periodo.ped_estado estado,
                  tb_periodo.ped_inscripciones inscrip,
                  tb_periodo.cod_trabajador encargado,
                  tb_persona.per_apel_paterno paterno,
                  tb_persona.per_apel_materno materno,
                  tb_persona.per_nombres nombres
                FROM
                  tb_periodo
                  LEFT OUTER JOIN tb_docente ON (tb_periodo.cod_trabajador = tb_docente.doc_codigo )
                  LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
                WHERE
                  tb_periodo.ped_nombre LIKE ? 
                ORDER BY tb_periodo.ped_codigo DESC", $nomper);
        return $result->result();
    }

    public function m_get_responsables()
    {
          $result = $this->db->query("SELECT 
              tb_persona.per_codigo codpersona,
              tb_docente.doc_codigo coddocente,
              tb_persona.per_apel_paterno paterno,
              tb_persona.per_apel_materno materno,
              tb_persona.per_nombres nombres,
              tb_persona.per_sexo sexo,
              tb_docente.doc_activo activo
            FROM
              tb_docente
              LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo) 
            WHERE tb_docente.doc_tipo <> 'DC'
            order by  tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres");
        return $result->result();
    }
}