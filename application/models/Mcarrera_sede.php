<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcarrera_sede extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_getCarrerasSedes($data=array())
    {
      $sqltext_array=array();
      $data_array=array();

      if (isset($data['codsede']) and ($data['codsede']!="%")) {
          $sqltext_array[]="tb_carrera_sede.cod_sede = ?";
          $data_array[]=$data['codsede'];
      }
      if (isset($data['activo']) and ($data['activo']!="%")) {
          $sqltext_array[]="tb_carrera.car_activo = ?";
          $data_array[]=$data['activo'];
      } 
      if (isset($data['abierto']) and ($data['abierto']!="%")) {
          $sqltext_array[]="tb_carrera.car_abierta = ?";
          $data_array[]=$data['abierto'];
      }

      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
      $result = $this->db->query("SELECT 
          tb_carrera_sede.cod_sede  AS codsede,
          tb_sede.sed_nombre AS sede,
          tb_carrera_sede.cod_carrera  AS codcarrera,
          tb_carrera.car_nombre as carrera,
          tb_carrera_sede.seca_abierta AS abierto,
          tb_carrera_sede.seca_activo AS activo
        FROM 
          tb_carrera_sede
          INNER JOIN tb_sede ON (tb_carrera_sede.cod_sede = tb_sede.id_sede) 
          INNER JOIN tb_carrera ON (tb_carrera_sede.cod_carrera = tb_carrera.car_id) 
        $sqltext 
        ORDER BY tb_sede.sed_nombre ASC ", $data_array);
      return $result->result();
    }

    public function m_get_carreras_xsede($data)
    {
      $result = $this->db->query("SELECT 
                    tb_carrera_sede.cod_sede  AS idsede,
                    tb_sede.sed_nombre AS nomsede,
                    tb_carrera_sede.cod_carrera  AS idcarrera,
                    tb_carrera.car_nombre as nomcarr,
                    tb_carrera_sede.seca_costo_inscripcion AS inscripcion,
                    tb_carrera_sede.seca_costo_matricula AS matricula,
                    tb_carrera_sede.seca_costo_total AS total,
                    tb_carrera_sede.seca_costo_contado AS contado,
                    tb_carrera_sede.seca_nro_cuotas AS cuotas,
                    tb_carrera_sede.seca_abierta AS abierto,
                    tb_carrera_sede.seca_activo AS activo
                  FROM 
                    tb_carrera_sede
                    INNER JOIN tb_sede ON (tb_carrera_sede.cod_sede = tb_sede.id_sede) 
                    INNER JOIN tb_carrera ON (tb_carrera_sede.cod_carrera = tb_carrera.car_id) 
                  WHERE tb_carrera_sede.cod_sede=? 
                  ORDER BY tb_sede.sed_nombre ASC ", $data);
      return $result->result();
    }

    public function m_get_carrerasedesxcodigo($data)
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
                    tb_carrera_sede.cod_sede  AS idsede,
                    tb_sede.sed_nombre AS nomsede,
                    tb_carrera_sede.cod_carrera  AS idcarrera,
                    tb_carrera.car_nombre as nomcarr,
                    tb_carrera_sede.seca_costo_inscripcion AS inscripcion,
                    tb_carrera_sede.seca_costo_matricula AS matricula,
                    tb_carrera_sede.seca_costo_total AS total,
                    tb_carrera_sede.seca_costo_contado AS contado,
                    tb_carrera_sede.seca_nro_cuotas AS cuotas,
                    tb_carrera_sede.seca_abierta AS abierto,
                    tb_carrera_sede.seca_activo AS activo
                  FROM 
                    tb_carrera_sede
                    INNER JOIN tb_sede ON (tb_carrera_sede.cod_sede = tb_sede.id_sede) 
                    INNER JOIN tb_carrera ON (tb_carrera_sede.cod_carrera = tb_carrera.car_id) 
                  WHERE tb_carrera_sede.cod_sede = ? AND tb_carrera_sede.cod_carrera = ? LIMIT 1", $data);
        return $result->row();
    }

    public function mInsert_carrera_sede($items)
    {
        $this->db->query("CALL `sp_tb_carrera_sede_insert`(?,?,?,?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function mUpdate_carrera_sede($items)
    {
        $this->db->query("CALL `sp_tb_carrera_sede_update`(?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_eliminasedecarrera($data)
    {
        
        $qry = $this->db->query("DELETE FROM tb_carrera_sede where cod_sede = ? AND cod_carrera = ?", $data);
        
        return 1;
    }

    public function m_get_carrerasedesxnombre($data)
    {
      $result = $this->db->query("SELECT 
                    tb_carrera_sede.cod_sede  AS idsede,
                    tb_sede.sed_nombre AS nomsede,
                    tb_carrera_sede.cod_carrera  AS idcarrera,
                    tb_carrera.car_nombre as nomcarr,
                    tb_carrera.car_abreviatura as abrevcarr,
                    tb_carrera_sede.seca_costo_inscripcion AS inscripcion,
                    tb_carrera_sede.seca_costo_matricula AS matricula,
                    tb_carrera_sede.seca_costo_total AS total,
                    tb_carrera_sede.seca_costo_contado AS contado,
                    tb_carrera_sede.seca_nro_cuotas AS cuotas,
                    tb_carrera_sede.seca_abierta AS abierto,
                    tb_carrera_sede.seca_activo AS activo
                  FROM 
                    tb_carrera_sede
                    INNER JOIN tb_sede ON (tb_carrera_sede.cod_sede = tb_sede.id_sede) 
                    INNER JOIN tb_carrera ON (tb_carrera_sede.cod_carrera = tb_carrera.car_id) 
                  WHERE tb_sede.sed_nombre like ? AND tb_carrera_sede.cod_sede=? 
                  ORDER BY tb_sede.sed_nombre ASC ", $data);
      return $result->result();
    }

}