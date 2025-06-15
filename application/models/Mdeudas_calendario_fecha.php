<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdeudas_calendario_fecha extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function m_getFechas($data)
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['codcalendario']) and ($data['codcalendario']!="%")) {
            $sqltext_array[]="tb_deuda_calendario_fecha.cod_calendario = ?";
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
            tb_deuda_calendario_fecha.dcf_codigo AS codigo,
            tb_deuda_calendario_fecha.dcf_descripcion AS descripcion,
            tb_deuda_calendario_fecha.dcf_fecha AS fecha,
            tb_deuda_calendario_fecha.cod_calendario AS codcalendario,
            tb_deuda_calendario.dc_nombre as calendario,
            tb_deuda_calendario.cod_periodo as codperiodo,
            tb_deuda_calendario.cod_sede as codsede
            FROM
            tb_deuda_calendario_fecha
            INNER JOIN tb_deuda_calendario ON (tb_deuda_calendario_fecha.cod_calendario = tb_deuda_calendario.dc_codigo)
            $sqltext
            ORDER BY
            tb_deuda_calendario.cod_sede,tb_deuda_calendario.cod_periodo,tb_deuda_calendario_fecha.cod_calendario,tb_deuda_calendario_fecha.dcf_fecha",$data_array);
        return $result->result();
    }

    //POR JANIOR
    public function m_get_fechas_xcalendario($data)
    {
          $result = $this->db->query("SELECT 
            tb_deuda_calendario_fecha.dcf_codigo as codigo,
            tb_deuda_calendario_fecha.dcf_descripcion as descripcion,
            tb_deuda_calendario_fecha.dcf_fecha as fecha,
            tb_deuda_calendario_fecha.cod_calendario as calendario
          FROM
            tb_deuda_calendario_fecha
          WHERE
            tb_deuda_calendario_fecha.cod_calendario = ?
          ORDER BY
            tb_deuda_calendario_fecha.dcf_fecha",$data);
        return $result->result();
    }


  public function m_guardar($data){
        //CALL `sp_tb_deuda_calendario_insert`( @vdc_nombre, @vdc_fec_inicia, @vdc_fec_culmina, @s, @nid);
    $this->db->query("CALL `sp_tb_deuda_calendario_fecha_insert`(?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    //$this->db->close(); 
    return   $res->row();
  }

  public function m_update_fecha($data){
        //CALL `sp_tb_deuda_calendario_insert`( @vdc_nombre, @vdc_fec_inicia, @vdc_fec_culmina, @s, @nid);
    $this->db->query("CALL `sp_tb_deuda_calendario_fecha_update`(?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    //$this->db->close(); 
    return   $res->row();
  }
}