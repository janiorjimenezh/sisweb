<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mturno extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function m_getTurnos($data)
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['activo']) and ($data['activo']!="%")) {
            $sqltext_array[]="tur_activo = ?";
            $data_array[]=$data['activo'];
        } 
       
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
              tur_codigo as codigo,
              tur_nombre as nombre,
              tur_inicia as inicia,
              tur_fin as fin,
              tur_activo as activo
            FROM 
              tb_turno
            $sqltext
            ORDER BY
                tur_inicia",$data_array);
        return $result->result();
    }

}