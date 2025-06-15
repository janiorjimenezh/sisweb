<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmatricula_consolidados extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	

	public function m_getConsolidadoPorSedPerProgSem($data)
	    {
	    $sqltext_array=array();
      $data_array=array();
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_matricula.codigosede = ?";
        $data_array[]=$data['codsede'];
      } 
      if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_matricula.codigoperiodo = ?";
        $data_array[]=$data['codperiodo'];
      } 
      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_matricula.codigocarrera = ?";
        $data_array[]=$data['codcarrera'];
      } 
      if (isset($data['codplan']) and ($data['codplan']!="%")) {
        $sqltext_array[]="tb_matricula.codigoplan = ?";
        $data_array[]=$data['codplan'];
      } 
      if (isset($data['codturno']) and ($data['codturno']!="%")) {
        $sqltext_array[]="tb_matricula.codigoturno = ?";
        $data_array[]=$data['codturno'];
      }
      if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
        $sqltext_array[]="tb_matricula.codigociclo = ?";
        $data_array[]=$data['codciclo'];
      }
      if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
        $sqltext_array[]="tb_matricula.codigoseccion = ?";
        $data_array[]=$data['codseccion'];
      }
      if (isset($data['codbeneficio']) and ($data['codbeneficio']!="%")) {
        $sqltext_array[]="tb_matricula.codigobeneficio = ?";
        $data_array[]=$data['codbeneficio'];
      } 
      if (isset($data['codestado']) and ($data['codestado']!="%")) {
        $sqltext_array[]="tb_matricula.codigoestado = ?";
        $data_array[]=$data['codestado'];
      } 
      if (isset($data['codinscripcion']) and ($data['codinscripcion']!="%")) {
        $sqltext_array[]="tb_matricula.codigoinscripcion=?";
        $data_array[]=$data['codinscripcion'];
      }
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
      $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.codigosede as codsede,
		  tb_matricula.codigoperiodo as codperiodo,
		  tb_matricula.codigocarrera as codcarrera,
		  tb_matricula.codigociclo as codciclo,
		  COUNT(tb_matricula.mtr_id) AS total
		FROM
		  tb_matricula
		$sqltext 
		GROUP BY
		  tb_matricula.codigosede,
		  tb_matricula.codigoperiodo,
		  tb_matricula.codigocarrera,
		  tb_matricula.codigociclo
		ORDER BY
  		  tb_matricula.codigosede,
  		  tb_matricula.codigoperiodo,
  		  tb_matricula.codigocarrera,
  		  tb_matricula.codigociclo", $data_array);
        return $resultmiembro->result();
  	}
}