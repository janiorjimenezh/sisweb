<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mseccion extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function m_getSecciones($data=array())
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
              `sec_codigo` codigo,
              `sec_nombre` nombre 
            FROM 
              `tb_seccion`
            $sqltext
            ",$data_array);
        return $result->result();
    }

}