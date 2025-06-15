<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbanco extends CI_Model {

	function __construct() {
    parent::__construct();
  }

  public function m_get_bancos($data)
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['activo']) and ($data['activo']!="%")) {
            $sqltext_array[]="tb_banco.bn_activo = ?";
            $data_array[]=$data['activo'];
        } 

        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
              tb_banco.bn_codigo AS codbanco,
              tb_banco.bn_nombre AS banco,
              tb_banco.bn_banco_sigla as sigla,
              tb_banco.bn_activo as activo 
            FROM
              tb_banco
            $sqltext 
            ORDER BY
              tb_banco.bn_nombre",$data_array);
        return $result->result();
    }


}