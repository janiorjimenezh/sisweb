<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmvirtual extends CI_Model
{
    //Clase para la tabla tb_virtual_material donde se guardan los encabezados de:
    //tareas, foros, evaluaciones, archivos

    public function __construct()
    {
        parent::__construct();
    }

    public function m_getMateriales_simple($data)
    {
            $sqltext_array=array();

    $data_array=array();
    
    if (isset($data['codmaterial']) and ($data['codmaterial']!="%")) {
      $sqltext_array[]="tb_virtual_material.virt_id = ?";
      $data_array[]=$data['codmaterial'];
    } 
    if (isset($data['codcarga']) and ($data['codcarga']!="%")) {
      $sqltext_array[]="tb_virtual_material.codigocarga = ?";
      $data_array[]=$data['codcarga'];
    } 
    if (isset($data['codsubseccion']) and ($data['codsubseccion']!="%")) {
      $sqltext_array[]="tb_virtual_material.codigosubseccion = ?";
      $data_array[]=$data['codsubseccion'];
    } 
    $sqltext=implode(' AND ', $sqltext_array);
    if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

        $result = $this->db->query("SELECT 
          tb_virtual_material.virt_id AS codmaterial,
          tb_virtual_material.virt_nombre AS material,
          tb_virtual_material.virt_tipo AS tipo,
          tb_virtual_material.virt_norden AS orden,
          tb_virtual_material.virt_id_padre AS padre,
          tb_virtual_material.virt_link AS link,
          tb_virtual_material.virt_vence AS vence,
          tb_virtual_material.virt_detalle AS detalle,
          tb_virtual_material.virt_espacio AS espaciado,
          tb_virtual_material.vit_mostrar_detalle AS mostrardt,
          tb_virtual_material.virt_visible AS visible,
          tb_virtual_material.virt_visible_time AS visibletime,
          tb_virtual_material.cod_carga_eval_head AS codevalhead,
          tb_virtual_material.codigocarga AS codcarga,
          tb_virtual_material.codigosubseccion as codsubseccion
        FROM 
            tb_virtual_material 
        $sqltext 
        ORDER BY virt_id_padre,virt_norden,virt_fechacreacion",$data_array);
        return $result->result();
    }
}