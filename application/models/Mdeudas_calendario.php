<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdeudas_calendario extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //POR JANIOR

    public function m_getCalendarios($data)
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['codcalendario']) and ($data['codcalendario']!="%")) {
            $sqltext_array[]="tb_deuda_calendario.dc_codigo = ?";
            $data_array[]=$data['codcalendario'];
        } 
        if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
            $sqltext_array[]="tb_deuda_calendario.cod_periodo  = ?";
            $data_array[]=$data['codperiodo'];
        } 
        if (isset($data['codsede']) and ($data['codsede']!="%")) {
            $sqltext_array[]="tb_deuda_calendario.cod_sede = ?";
            $data_array[]=$data['codsede'];
        } 
       
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
            tb_deuda_calendario.dc_codigo AS codigo,
            tb_deuda_calendario.dc_nombre AS nombre,
            tb_deuda_calendario.dc_fec_inicia AS inicia,
            tb_deuda_calendario.dc_fec_culmina AS culmina,
            tb_deuda_calendario.cod_periodo AS codperiodo,
            tb_deuda_calendario.dc_fecha_cierre_ud AS cierre_ud,
            tb_deuda_calendario.dc_fecha_consolida_retiros AS consolida_retiros,
            tb_periodo.ped_nombre AS periodo,
            tb_periodo.ped_estado AS estado,
            tb_deuda_calendario.cod_sede AS codsede,
            tb_sede.sed_nombre AS sede,
            tb_deuda_calendario.dc_cerrar_i1 AS cerrar_i1,
            tb_deuda_calendario.dc_cerrar_i2 AS cerrar_i2,
            tb_deuda_calendario.dc_cerrar_i3 AS cerrar_i3,
            COUNT(tb_deuda_calendario_grupoacad.cga_id) AS totalgrupos
          FROM
            tb_periodo
            INNER JOIN tb_deuda_calendario ON (tb_periodo.ped_codigo = tb_deuda_calendario.cod_periodo)
            INNER JOIN tb_sede ON (tb_deuda_calendario.cod_sede = tb_sede.id_sede)
            LEFT OUTER JOIN tb_deuda_calendario_grupoacad ON (tb_deuda_calendario.dc_codigo = tb_deuda_calendario_grupoacad.cod_deuda_calendario)
          $sqltext 
          GROUP BY
            tb_deuda_calendario.dc_codigo,
            tb_deuda_calendario.dc_nombre,
            tb_deuda_calendario.dc_fec_inicia,
            tb_deuda_calendario.dc_fec_culmina,
            tb_deuda_calendario.cod_periodo,
            tb_deuda_calendario.dc_fecha_cierre_ud,
            tb_deuda_calendario.dc_fecha_consolida_retiros,
            tb_periodo.ped_nombre,
            tb_periodo.ped_estado,
            tb_deuda_calendario.cod_sede,
            tb_sede.sed_nombre,
            tb_deuda_calendario.dc_cerrar_i1,
            tb_deuda_calendario.dc_cerrar_i2,
            tb_deuda_calendario.dc_cerrar_i3
          ORDER BY
            tb_deuda_calendario.cod_sede,
            tb_deuda_calendario.cod_periodo,
            tb_deuda_calendario.dc_fec_inicia",$data_array);
        return $result->result();
    }

    public function m_getCalendariosSimple($data)
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['codcalendario']) and ($data['codcalendario']!="%")) {
            $sqltext_array[]="tb_deuda_calendario.dc_codigo = ?";
            $data_array[]=$data['codcalendario'];
        } 
        if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
            $sqltext_array[]="tb_deuda_calendario.cod_periodo  = ?";
            $data_array[]=$data['codperiodo'];
        } 
        if (isset($data['codsede']) and ($data['codsede']!="%")) {
            $sqltext_array[]="tb_deuda_calendario.cod_sede = ?";
            $data_array[]=$data['codsede'];
        } 
       
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
              tb_deuda_calendario.dc_codigo AS codcalendario,
              tb_deuda_calendario.dc_nombre AS calendario,
              tb_deuda_calendario.dc_fec_inicia AS inicia,
              tb_deuda_calendario.dc_fec_culmina AS culmina,
              tb_deuda_calendario.cod_periodo AS codperiodo,
              tb_deuda_calendario.dc_fecha_cierre_ud AS cierre_ud,
              tb_deuda_calendario.dc_fecha_consolida_retiros AS consolida_retiros,
              tb_periodo.ped_nombre AS periodo,
              tb_periodo.ped_estado AS estado,
              tb_deuda_calendario.cod_sede AS codsede,
              tb_sede.sed_nombre AS sede,
              tb_deuda_calendario.dc_cerrar_i1 AS cerrar_i1,
              tb_deuda_calendario.dc_cerrar_i2 AS cerrar_i2,
              tb_deuda_calendario.dc_cerrar_i3 AS cerrar_i3
            FROM
              tb_periodo
              INNER JOIN tb_deuda_calendario ON (tb_periodo.ped_codigo = tb_deuda_calendario.cod_periodo)
              INNER JOIN tb_sede ON (tb_deuda_calendario.cod_sede = tb_sede.id_sede)
            $sqltext 
            ORDER BY
              tb_deuda_calendario.cod_sede",$data_array);
        return $result->result();
    }




  public function m_updateCalendario($id,$data)
  {
    $this->db->where('dc_codigo', $id);
    $this->db->update('tb_deuda_calendario', $data);
    
    $rp = new stdClass;
    $rp->id=$id;
    $rp->countRows=$this->db->affected_rows();
    //$rp->salida=($rp->countRows==0) ? false : true;
    $rp->salida=true;
    return $rp;
  }

  public function m_insertCalendario($data){
    $this->db->insert('tb_deuda_calendario', $data);
    $rp = new stdClass;
    $rp->id = $this->db->insert_id();
    $rp->salida=($rp->id==0) ? false : true;
    return  $rp;
  }
}