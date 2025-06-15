<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdeudas_calendario_fecha_item extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function m_getItemsFecha($data)
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['codcalendario']) and ($data['codcalendario']!="%")) {
            $sqltext_array[]="tb_deuda_calendario_fecha.cod_calendario = ?";
            $data_array[]=$data['codcalendario'];
        } 
        if (isset($data['codfecha']) and ($data['codfecha']!="%")) {
            $sqltext_array[]="tb_deuda_calendario_fecha_item.codigo_calfecha = ?";
            $data_array[]=$data['codfecha'];
        } 
        if (isset($data['codfechaitem']) and ($data['codfechaitem']!="%")) {
            $sqltext_array[]="tb_deuda_calendario_fecha_item.dcfi_codigo = ?";
            $data_array[]=$data['codfechaitem'];
        } 
       
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
              tb_deuda_calendario_fecha_item.dcfi_codigo AS codfechaitem,
              tb_deuda_calendario_fecha_item.codigo_calfecha AS codfecha,
              tb_deuda_calendario_fecha_item.codigogestion AS codgestion,
              tb_deuda_calendario_fecha_item.dcfi_repite AS repite,
              tb_deuda_calendario_fecha_item.dcfi_monto AS monto,
              tb_gestion.gt_nombre AS gestion,
              tb_deuda_calendario_fecha.dcf_fecha as vence,
              tb_deuda_calendario_fecha_item.dcfi_aplicardscto as aplicardscto,
              tb_deuda_calendario_fecha.cod_calendario as codcalendario
            FROM
              tb_gestion
              INNER JOIN tb_deuda_calendario_fecha_item ON (tb_gestion.gt_codigo = tb_deuda_calendario_fecha_item.codigogestion)
              INNER JOIN tb_deuda_calendario_fecha ON (tb_deuda_calendario_fecha_item.codigo_calfecha = tb_deuda_calendario_fecha.dcf_codigo)
            $sqltext 
            ORDER BY
              tb_deuda_calendario_fecha_item.codigo_calfecha",$data_array);
        return $result->result();
    }


    public function m_get_items_cobro_x_fecha($data)
    {
        $result = $this->db->query("SELECT 
              tb_deuda_calendario_fecha_item.dcfi_codigo AS codigo,
              tb_deuda_calendario_fecha_item.codigo_calfecha AS codcal_fecha,
              tb_deuda_calendario_fecha_item.codigogestion AS codgestion,
              tb_deuda_calendario_fecha_item.dcfi_repite AS repite,
              tb_deuda_calendario_fecha_item.dcfi_monto AS monto,
              tb_gestion.gt_nombre AS gestion,
              tb_deuda_calendario_fecha.dcf_fecha as vence
            FROM
              tb_gestion
              INNER JOIN tb_deuda_calendario_fecha_item ON (tb_gestion.gt_codigo = tb_deuda_calendario_fecha_item.codigogestion)
              INNER JOIN tb_deuda_calendario_fecha ON (tb_deuda_calendario_fecha_item.codigo_calfecha = tb_deuda_calendario_fecha.dcf_codigo)
            WHERE tb_deuda_calendario_fecha_item.codigo_calfecha=? 
            ORDER BY
              tb_deuda_calendario_fecha_item.dcfi_codigo DESC",$data);

        return $result->result();
    }

    public function m_insertCalendarioFechaItem($data){
        $this->db->insert('tb_deuda_calendario_fecha_item', $data);

        $rp = new stdClass;
        $rp->id = $this->db->insert_id();
        $rp->salida=($rp->id==0) ? false : true;
        return  $rp;
    }

     public function m_updateCalendarioFechaItem($id,$data)
    {  
        $this->db->where('dcfi_codigo', $id);
        $rs=$this->db->update('tb_deuda_calendario_fecha_item', $data);
        $rp = new stdClass;
        $rp->id=$id;
        $rp->aRows=$this->db->affected_rows();
        $rp->salida=($rp->countRows==0) ? 0 : 1;
        return $rp;
    }

    public function mInsert_deudas_calendario_item($items)
    {
        $this->db->query("CALL `sp_tb_deuda_calendario_fecha_item_insert`(?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_deudas_calendario_item($items)
    {
        $this->db->query("CALL `sp_tb_deuda_calendario_fecha_item_update`(?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return   $res->row();    
    }

    public function mDelete_deudas_calendario_item($codigo)
    {
        
        $this->db->query("CALL `sp_tb_deuda_calendario_fecha_item_delete`(?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return   $res->row(); 
    }


}

