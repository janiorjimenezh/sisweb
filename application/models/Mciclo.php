<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MCiclo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

   public function m_getCiclos($data=array())
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['tipo']) and ($data['tipo']!="%")) {
            $sqltext_array[]="tb_ciclo.cic_tipo = ?";
            $data_array[]=$data['tipo'];
        } 
     
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
              tb_ciclo.cic_codigo AS codigo,
              tb_ciclo.cic_nombre AS nombre,
              tb_ciclo.cic_anios AS anios,
              tb_ciclo.cic_letras AS letras,
              tb_ciclo.cic_tipo AS tipo
            FROM
              tb_ciclo
            $sqltext 
            ORDER BY tb_ciclo.cic_codigo ;",$data_array);
        return $result->result();
    }
    
}