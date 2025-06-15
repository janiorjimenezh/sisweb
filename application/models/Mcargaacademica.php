<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mcargaacademica extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function m_getCargasAcademicas($data){
      $sqltext_array=array();
      $data_array=array();

      if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_carga_academica.codigoperiodo = ?";
        $data_array[]=$data['codperiodo'];
      } 
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_carga_academica.cod_sede = ?";
        $data_array[]=$data['codsede'];
      } 
      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_carga_academica.codigocarrera = ?";
        $data_array[]=$data['codcarrera'];
      } 
      if (isset($data['codturno']) and ($data['codturno']!="%")) {
        $sqltext_array[]="tb_carga_academica.codigoturno = ?";
        $data_array[]=$data['codturno'];
      }
      if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
        $sqltext_array[]="tb_carga_academica.codigociclo = ?";
        $data_array[]=$data['codciclo'];
      }
      if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
        $sqltext_array[]="tb_carga_academica.codigoseccion = ?";
        $data_array[]=$data['codseccion'];
      }
      if (isset($data['codplan']) and ($data['codplan']!="%")) {
        $sqltext_array[]="tb_modulo_educativo.codigoplan = ?";
        $data_array[]=$data['codplan'];
      }
      if (isset($data['activo']) and ($data['activo']!="%")) {
        $sqltext_array[]="tb_carga_academica.cac_activo = ?";
        $data_array[]=$data['activo'];
      }
      
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
      

      $result = $this->db->query("SELECT 
        tb_carga_academica.cac_id AS codcarga,
        tb_carga_academica.cod_sede as codsede,
        tb_carga_academica.codigoperiodo as codperiodo,
        tb_periodo.ped_nombre AS periodo,
        tb_carga_academica.codigocarrera as codcarrera,
        tb_carrera.car_nombre AS carrera,
        tb_modulo_educativo.codigoplan AS codplan,
        tb_modulo_educativo.mod_nombre AS modulo,
        tb_carga_academica.codigociclo as codciclo,
        tb_ciclo.cic_nombre AS ciclo,
        tb_carga_academica.codigoturno AS codturno,
        tb_carga_academica.codigoseccion AS codseccion,
        tb_carga_academica.codigouindidadd AS codcurso,
        tb_unidad_didactica.undd_codigo AS codunidad,
        tb_unidad_didactica.undd_nombre AS curso,
        tb_unidad_didactica.codigomodulo AS codmodulo,
        tb_modulo_educativo.mod_nro AS nromodulo,
        tb_carga_academica.cac_horas_sema_teor AS hts,
        tb_carga_academica.cac_horas_sema_pract AS hps,
        tb_carga_academica.cac_creditos_teor AS ct,
        tb_carga_academica.cac_creditos_pract AS cp
      FROM
        tb_carga_academica
        INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
        INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
        INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
        INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
        INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
      $sqltext 
      ORDER BY
        tb_modulo_educativo.codigoplan,
        tb_modulo_educativo.mod_codigo,
        tb_carga_academica.codigociclo,
        tb_unidad_didactica.undd_nombre", $data_array);
      return   $result->result();
    }

    public function m_filtrar($data){
        $result = $this->db->query("SELECT 
        tb_carga_academica.cac_id AS idcarga,
        tb_periodo.ped_nombre AS periodo,
        tb_carrera.car_nombre AS carrera,
        tb_carga_academica.codigouindidadd AS codcurso,
        tb_unidad_didactica.undd_codigo AS codunidad,
        tb_unidad_didactica.undd_nombre AS curso,
        tb_unidad_didactica.codigomodulo AS codmodulo,
        tb_modulo_educativo.mod_nro AS nromodulo,
        tb_carga_academica.cac_horas_sema_teor AS hts,
        tb_carga_academica.cac_horas_sema_pract AS hps,
        tb_carga_academica.cac_creditos_teor AS ct,
        tb_carga_academica.cac_creditos_pract AS cp,
        tb_modulo_educativo.codigoplan AS codplan,
        tb_modulo_educativo.mod_nombre AS modulo,
        tb_ciclo.cic_nombre AS ciclo,
        tb_carga_academica.codigoturno AS codturno,
        tb_carga_academica.codigoseccion AS codseccion
      FROM
        tb_carga_academica
        INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
        INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
        INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
        INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
        INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
      WHERE tb_carga_academica.cod_sede=? AND  tb_carga_academica.codigoperiodo LIKE ? AND tb_carga_academica.codigocarrera LIKE ? AND tb_modulo_educativo.codigoplan LIKE ? AND tb_carga_academica.codigociclo LIKE ? AND tb_carga_academica.codigoturno LIKE ? AND tb_carga_academica.codigoseccion LIKE ? and tb_carga_academica.cac_activo='SI' 
      ORDER BY
        tb_modulo_educativo.codigoplan,
        tb_modulo_educativo.mod_codigo,
        tb_carga_academica.codigociclo,
        tb_unidad_didactica.undd_nombre", $data);
      return   $result->result();
    }

    public function m_filtrar_agrupados_x_matriculados($data){
        $result = $this->db->query("SELECT 
  tb_carga_academica.cac_id AS idcarga,
  tb_periodo.ped_nombre AS periodo,
  tb_carrera.car_nombre AS carrera,
  tb_carga_academica.codigouindidadd AS codcurso,
  tb_unidad_didactica.undd_nombre AS curso,
  tb_unidad_didactica.codigomodulo AS codmodulo,
  tb_modulo_educativo.mod_nro AS nromodulo,
  tb_carga_academica.cac_horas_sema_teor AS hts,
  tb_carga_academica.cac_horas_sema_pract AS hps,
  tb_carga_academica.cac_creditos_teor AS ct,
  tb_carga_academica.cac_creditos_pract AS cp,
  tb_modulo_educativo.codigoplan AS codplan,
  tb_modulo_educativo.mod_nombre AS modulo,
  tb_ciclo.cic_nombre AS ciclo,
  tb_matricula.codigoturno AS codturno,
  tb_matricula.codigoseccion AS codseccion,
  COUNT(tb_matricula.mtr_id) AS FIELD_1
FROM
  tb_carga_academica
  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
  INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
  INNER JOIN tb_periodo ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)

      WHERE tb_carga_academica.cod_sede=? AND  tb_matricula.codigoperiodo LIKE ? AND tb_matricula.codigocarrera LIKE ? AND tb_modulo_educativo.codigoplan LIKE ? AND tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND tb_matricula.codigoseccion LIKE ? and tb_carga_academica.cac_activo='SI' 
      GROUP BY
  tb_carga_academica.cac_id,
  tb_periodo.ped_nombre,
  tb_carrera.car_nombre,
  tb_carga_academica.codigouindidadd,
  tb_unidad_didactica.undd_nombre,
  tb_unidad_didactica.codigomodulo,
  tb_modulo_educativo.mod_nro,
  tb_carga_academica.cac_horas_sema_teor,
  tb_carga_academica.cac_horas_sema_pract,
  tb_carga_academica.cac_creditos_teor,
  tb_carga_academica.cac_creditos_pract,
  tb_modulo_educativo.codigoplan,
  tb_modulo_educativo.mod_nombre,
  tb_ciclo.cic_nombre,
  tb_matricula.codigoturno,
  tb_matricula.codigoseccion 
      ORDER BY
        tb_modulo_educativo.codigoplan,
        tb_modulo_educativo.mod_codigo,
        tb_carga_academica.codigociclo,
        tb_unidad_didactica.undd_nombre", $data);
      return   $result->result();
    }

    public function m_insert($data){
      //(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd, @s);
      $this->db->query("CALL `sp_tb_cargaacad_insert`(?,?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return   $res->row();  
    }

    public function m_activar($data){   
      //(( @vcodigoperiodo, @vcodigocarrera, @vcodigociclo, @vcodigoturno, @vcodigoseccion, @vcodigouindidadd, @s);
      $this->db->query("CALL `sp_tb_cargaacad_update_estado`(?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    //$fcacbperiodo,$fcacbcarrera,$fcacbciclo,$fcacbturno,$fcacbseccion,$fcacbplan
    public function m_get_carga_por_grupo($data){
        $result = $this->db->query("SELECT 
            tb_carga_academica.cac_id AS codcarga,
            tb_carga_academica.codigouindidadd AS codunidad,
            tb_carga_academica.cac_activo AS activo
          FROM
            tb_unidad_didactica
            INNER JOIN tb_carga_academica ON (tb_unidad_didactica.undd_codigo = tb_carga_academica.codigouindidadd)
            INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
            WHERE tb_carga_academica.codigoperiodo=? AND tb_modulo_educativo.codigoplan=? AND tb_carga_academica.codigocarrera=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND tb_carga_academica.codigoseccion=? AND tb_carga_academica.cod_sede = ?", $data);
        return   $result->result();
    }


     public function m_get_carga_por_grupo_extendida($data){
        $result = $this->db->query("SELECT 
              tb_carga_academica.cac_id AS codcarga,
              tb_carga_academica.codigouindidadd as codunidad,
              tb_unidad_didactica.undd_nombre AS unidad,
              tb_unidad_didactica.codigociclo as codciclo,
              tb_unidad_didactica.undd_horas_sema_teor AS hst,
              tb_unidad_didactica.undd_horas_sema_pract AS hsp,
              tb_unidad_didactica.undd_horas_ciclo AS hc,
              tb_unidad_didactica.undd_creditos_teor AS ct,
              tb_unidad_didactica.undd_creditos_pract AS cp,
              tb_carga_academica.cac_activo AS activo,
              tb_modulo_educativo.codigoplan as codplan
            FROM
              tb_carga_academica
              INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
              INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo) 
            WHERE tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=?  AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND tb_carga_academica.codigoseccion=? AND tb_modulo_educativo.codigoplan=? AND tb_carga_academica.cod_sede = ?
            ORDER BY  tb_unidad_didactica.undd_nombre ", $data);
        return   $result->result();
    }


    
  
}



