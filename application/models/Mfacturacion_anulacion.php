<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion_anulacion extends CI_Model {

	function __construct() {
           parent::__construct();
    }

    public function m_consultarExistenciaDocPagoAnulacion($data){
      

       $qry = $this->db->query("SELECT 
          dcps_id AS coddoc
        FROM 
          tb_docpago_sunat_anulacion    
        WHERE dcps_id=?;", $data );
      return $qry->row();

    }
    public function m_updateDocPagoAnulacion($id,$data)
    {
      
      $this->db->where('dcps_id', $id);
      $this->db->update('tb_docpago_sunat_anulacion', $data);
      return true;
    }

}