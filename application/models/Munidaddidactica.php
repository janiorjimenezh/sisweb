<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Munidaddidactica extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_datos_unidad($data){

        $this->db->query("CALL `sp_tb_unidad_didactica`(?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_get_ciclo()
    {
        $result = $this->db->query("SELECT 
                  tb_ciclo.cic_codigo id,
                  tb_ciclo.cic_nombre nomcic,
                  tb_ciclo.cic_anios anio,
                  tb_ciclo.cic_letras letra
                FROM
                  tb_ciclo");
        return $result->result();
    }

    public function m_get_unidades_all()
    {
      $result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo id,
                  tb_unidad_didactica.undd_nombre uninom,
                  tb_unidad_didactica.undd_tipo_mod unitip,
                  tb_unidad_didactica.codigociclo idcic,
                  tb_ciclo.cic_nombre cicnom,
                  tb_unidad_didactica.codigomodulo idmod,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_unidad_didactica.undd_horas_sema_teor horter,
                  tb_unidad_didactica.undd_horas_sema_pract horprac,
                  tb_unidad_didactica.undd_horas_ciclo horcic,
                  tb_unidad_didactica.undd_creditos_teor credter,
                  tb_unidad_didactica.undd_creditos_pract credprac,
                  tb_unidad_didactica.undd_activo activo,
                  tb_plan_estudios.pln_id idplan,
                  tb_plan_estudios.pln_nombre plannom
                FROM
                  tb_modulo_educativo
                  INNER JOIN tb_unidad_didactica ON (tb_modulo_educativo.mod_codigo = tb_unidad_didactica.codigomodulo)
                  INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
                  INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
                  INNER JOIN tb_carrera ON (tb_plan_estudios.codigocarrera = tb_carrera.car_id)
                WHERE 
                  `tb_unidad_didactica`.`undd_activo` = 'SI' AND tb_carrera.car_abierta = 'SI'
                ORDER BY tb_plan_estudios.codigoperiodo DESC");
      return $result->result();
    }

    public function m_get_unidades_all_x_plan($data)
    {
      $result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo id,
                  tb_unidad_didactica.undd_nombre uninom,
                  tb_unidad_didactica.undd_tipo_mod unitip,
                  tb_unidad_didactica.codigociclo idcic,
                  tb_ciclo.cic_nombre cicnom,
                  tb_unidad_didactica.codigomodulo idmod,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_unidad_didactica.undd_horas_sema_teor horter,
                  tb_unidad_didactica.undd_horas_sema_pract horprac,
                  tb_unidad_didactica.undd_horas_ciclo horcic,
                  tb_unidad_didactica.undd_creditos_teor credter,
                  tb_unidad_didactica.undd_creditos_pract credprac,
                  tb_unidad_didactica.undd_activo activo,
                  tb_plan_estudios.pln_id idplan,
                  tb_plan_estudios.pln_nombre plannom
                FROM
                  tb_modulo_educativo
                  INNER JOIN tb_unidad_didactica ON (tb_modulo_educativo.mod_codigo = tb_unidad_didactica.codigomodulo)
                  INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
                  INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
                  INNER JOIN tb_carrera ON (tb_plan_estudios.codigocarrera = tb_carrera.car_id)
                WHERE 
                  `tb_unidad_didactica`.`undd_activo` = 'SI' AND tb_carrera.car_abierta = 'SI' AND tb_plan_estudios.pln_id = ?
                ORDER BY tb_plan_estudios.codigoperiodo DESC", $data);
      return $result->result();
    }

    public function m_get_unidades()
    {
    	$result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo id,
                  tb_unidad_didactica.undd_nombre uninom,
                  tb_unidad_didactica.undd_tipo_mod unitip,
                  tb_unidad_didactica.codigociclo idcic,
                  tb_ciclo.cic_nombre cicnom,
                  tb_unidad_didactica.codigomodulo idmod,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_unidad_didactica.undd_horas_sema_teor horter,
                  tb_unidad_didactica.undd_horas_sema_pract horprac,
                  tb_unidad_didactica.undd_horas_ciclo horcic,
                  tb_unidad_didactica.undd_creditos_teor credter,
                  tb_unidad_didactica.undd_creditos_pract credprac,
                  tb_unidad_didactica.undd_activo activo
                FROM
                  tb_modulo_educativo
                  INNER JOIN tb_unidad_didactica ON (tb_modulo_educativo.mod_codigo = tb_unidad_didactica.codigomodulo)
                  INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
                WHERE 
                  `tb_unidad_didactica`.`undd_activo` = 'SI'");
    	return $result->result();
    }

    public function m_get_unidadesxparametros($data)
    {
      $rsunid = array();
      $result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo id,
                  tb_unidad_didactica.undd_nombre uninom,
                  tb_unidad_didactica.undd_tipo_mod unitip,
                  tb_unidad_didactica.codigociclo idcic,
                  tb_ciclo.cic_nombre cicnom,
                  tb_unidad_didactica.codigomodulo idmod,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_unidad_didactica.undd_horas_sema_teor horter,
                  tb_unidad_didactica.undd_horas_sema_pract horprac,
                  tb_unidad_didactica.undd_horas_ciclo horcic,
                  tb_unidad_didactica.undd_creditos_teor credter,
                  tb_unidad_didactica.undd_creditos_pract credprac,
                  tb_unidad_didactica.undd_activo activo,
                    tb_plan_estudios.pln_nombre as plan 
                FROM
                  tb_modulo_educativo
                  INNER JOIN tb_unidad_didactica ON (tb_modulo_educativo.mod_codigo = tb_unidad_didactica.codigomodulo)
                  INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
                  INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
                WHERE 
                  tb_plan_estudios.pln_id LIKE ? AND
                  tb_modulo_educativo.mod_codigo LIKE ? AND
                  tb_plan_estudios.codigocarrera LIKE ? AND
                  tb_unidad_didactica.codigociclo LIKE ? ", $data);
      $rsunid = $result->result();
      return array('unidades' => $rsunid);
    }

    public function m_get_unidadxcodigo($codigo)
    {
      $rsunidad = array();
      $result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo id,
                  tb_unidad_didactica.undd_nombre uninom,
                  tb_unidad_didactica.undd_tipo_mod unitip,
                  tb_unidad_didactica.codigociclo idcic,
                  tb_ciclo.cic_nombre cicnom,
                  tb_unidad_didactica.codigomodulo idmod,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_unidad_didactica.undd_horas_sema_teor horter,
                  tb_unidad_didactica.undd_horas_sema_pract horprac,
                  tb_unidad_didactica.undd_horas_ciclo horcic,
                  tb_unidad_didactica.undd_creditos_teor credter,
                  tb_unidad_didactica.undd_creditos_pract credprac,
                  tb_unidad_didactica.undd_activo activo,
                  tb_plan_estudios.codigocarrera carrera,
                  tb_modulo_educativo.codigoplan plan
                FROM
                  tb_modulo_educativo
                  INNER JOIN tb_unidad_didactica ON (tb_modulo_educativo.mod_codigo = tb_unidad_didactica.codigomodulo)
                  INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
                  INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
                WHERE 
                  tb_unidad_didactica.undd_codigo = ? ", $codigo);
        return $result->row();
        // return array('dtsunidad' => $rsunidad);
    }

    public function m_get_unidad_x_plan_ciclo($datos)
    {
      
      $resulta = $this->db->query("SELECT 
            tb_unidad_didactica.undd_codigo AS codunidad,
            tb_unidad_didactica.undd_nombre nombre,
            tb_unidad_didactica.codigociclo AS codciclo,
            tb_unidad_didactica.undd_horas_sema_teor AS hst,
            tb_unidad_didactica.undd_horas_sema_pract AS hsp,
            tb_unidad_didactica.undd_horas_ciclo AS hc,
            tb_unidad_didactica.undd_creditos_teor AS ct,
            tb_unidad_didactica.undd_creditos_pract AS cp,
            tb_modulo_educativo.codigoplan AS codplan,
            tb_unidad_didactica.undd_activo as activo 
          FROM
            tb_unidad_didactica
            INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          WHERE
            tb_modulo_educativo.codigoplan = ? AND 
            tb_unidad_didactica.codigociclo = ? 
          ORDER BY tb_unidad_didactica.undd_nombre ", $datos);
        return $resulta->result();
         
    }

    public function update_datos_unidad($data){

        $this->db->query("CALL `sp_tb_unidad_didactica_update`(?,?,?,?,?,?,?,?,?,?,@s)",$data);
        $res = $this->db->query('select @s as out_param');
        return $res->row()->out_param;    
    }

    public function m_elimina_unidad($codigo)
    {
        $qry = $this->db->query("DELETE FROM tb_unidad_didactica where undd_codigo = ?", $codigo);
        $this->db->close();
        return 1;
    }

    public function Update_activo_unidad_didactica($data)
    {
        $this->db->query("UPDATE tb_unidad_didactica SET tb_unidad_didactica.undd_activo = ? WHERE tb_unidad_didactica.undd_codigo = ?",$data);
        // $res = $this->db->query('select @s as salida');
        return 1;
    }

    public function m_get_carga_por_unidad_didactica($data){
        $result = $this->db->query("SELECT 
              tb_carga_academica.cac_id AS codcarga,
              tb_carga_academica.codigouindidadd as codunidad,
              tb_carga_academica.cac_activo AS activo
            FROM
              tb_carga_academica
            WHERE tb_carga_academica.codigouindidadd = ? ", $data);
        return $result->result();
    }

}