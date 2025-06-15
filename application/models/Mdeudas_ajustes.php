<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdeudas_ajustes extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function m_updateDeudaAjuste($id,$data)
    {
        $this->db->where('ddi_codigo', $id);
        $this->db->update('tb_deuda_ajustes_interno', $data);
        
        $rp = new stdClass;
        $rp->id=$id;
        $rp->countRows=$this->db->affected_rows();
        $rp->salida=($rp->countRows==0) ? false : true;
        return $rp;
    }

    public function m_insertDeudaAjuste($data){
        $this->db->insert('tb_deuda_ajustes_interno', $data);

        $rp = new stdClass;
        $rp->id = $this->db->insert_id();
        $rp->salida=($rp->id==0) ? false : true;
        return  $rp;
    }

    public function m_eliminarDeudaAjuste($id){
        $this->db->where('ddi_codigo', $id);
        $elimino=$this->db->delete('tb_deuda_ajustes_interno');
        $rp = new stdClass;
        $rp->countRows = $this->db->affected_rows();
        $rp->salida=$elimino;
        return  $rp;
    }

    public function m_getDeudasAjustes($data)
    {
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['coddeuda'])) {
            $sqltext_array[]="tb_deuda_ajustes_interno.cod_deuda = ?";
            $data_array[]=$data['coddeuda'];
        }
       
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
          tb_deuda_ajustes_interno.ddi_codigo AS codajuste,
          tb_deuda_ajustes_interno.cod_deuda AS coddeuda,
          tb_deuda_ajustes_interno.ddi_monto AS monto,
          tb_deuda_ajustes_interno.ddi_sustento AS sustento,
          tb_deuda_ajustes_interno.ddi_creacion AS creado,
          tb_deuda_ajustes_interno.cod_usuario_crea AS codusuariocrea,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_deuda_ajustes_interno.ddi_estado AS estado,
          tb_deuda_ajustes_interno.ddi_anulacion_fecha AS anulacion_fecha,
          tb_deuda_ajustes_interno.ddi_anulacion_motivo AS anulacion_motivo
          FROM tb_deuda_ajustes_interno
          INNER JOIN tb_usuario ON (tb_deuda_ajustes_interno.cod_usuario_crea = tb_usuario.id_usuario)
          INNER JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
        $sqltext 
        ORDER BY tb_deuda_ajustes_interno.ddi_creacion DESC;",$data_array);
        return $result->result();
    }


}


