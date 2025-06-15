<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdoctipo_sede extends CI_Model {

	function __construct() {
           parent::__construct();
           $this->load->helper("url");          
    }

public function m_get_docTipoSede($data)
    {
    	$data_array=array();
      	$sqltext_array=array();
    	if (isset($data['codsede']) and ($data['codsede']!="%")) {
			$sqltext_array[]="tb_doctipo_sede.cod_sede = ?";
			$data_array[]=$data['codsede'];
		} 
		if (isset($data['codtipodoc']) and ($data['codtipodoc']!="%")) {
			$sqltext_array[]="tb_doctipo_sede.cod_doctipo = ?";
			$data_array[]=$data['codtipodoc'];
		} 
		if (isset($data['serie']) and ($data['serie']!="%")) {
        	$sqltext_array[]="tb_doctipo_sede.dtse_serie = ?";
        	$data_array[]=$data['serie'];
		} 
		if (isset($data['habilitado']) and ($data['habilitado']!="%")) {
        	$sqltext_array[]="tb_doctipo_sede.dtse_habilitado = ?";
        	$data_array[]=$data['habilitado'];
		} 
		
		$sqltext=implode(' AND ', $sqltext_array);
      	if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $qry = $this->db->query("SELECT 
                  tb_doctipo_sede.cod_sede as codsede,
                  tb_doctipo_sede.cod_doctipo as codtipodoc,
                  tb_doctipo_sede.dtse_ruc as ruc,
                  tb_doctipo_sede.dtse_serie as serie,
                  tb_doctipo_sede.dtse_contador_nro as contador,
                  tb_doctipo_sede.dtse_habilitado as habilitado,
                  tb_doctipo_sede.dtse_codlocal_sunat as codlocalsunat,
                  tb_doctipo_sede.cod_tipo_operacion51 as codoperacion51,
                  tb_doctipo_sede.dtse_igv_porcentaje as igvpr
                FROM 
                  tb_doctipo_sede 
               	$sqltext", $data_array);
        
        return $qry->result();
    }
}
?>