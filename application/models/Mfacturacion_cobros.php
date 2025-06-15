<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion_cobros extends CI_Model {

	function __construct() {
           parent::__construct();
    }

  public function m_insertDocPagoCobros($data){
    $this->db->insert('tb_docpago_cobros', $data);

    $rp = new stdClass;
    $rp->id = $this->db->insert_id();
    $rp->salida=($rp->id==0) ? false : true;
    return  $rp;
  }



  /* COBROS PASAR A OTRO MODEL */
  public function m_get_medios_pago()
  {
      $qry = $this->db->query("SELECT 
          tb_docpago_medio.dm_codigo AS codigo,
          tb_docpago_medio.dm_nombre AS nombre
        FROM
          tb_docpago_medio
        ORDER BY
          tb_docpago_medio.dm_nombre");
      
      return $qry->result();
  }

  public function m_get_bancos()
  {
      $qry = $this->db->query("SELECT 
          tb_banco.bn_codigo AS codigo,
          tb_banco.bn_nombre AS nombre
        FROM
          tb_banco
        ORDER BY
          tb_banco.bn_nombre");
      
      return $qry->result();
  }

  public function m_guardar_cobro($data)
  {
    $this->db->query("CALL sp_tb_docpago_cobros_insert(?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida; 
  }

  

  public function m_getCobrosPorGrupo($data)
  {
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
      if (isset($data['codinscripcion']) and ($data['codinscripcion']!="%")) {
        $sqltext_array[]="tb_matricula.codigoinscripcion=?";
        $data_array[]=$data['codinscripcion'];
      }
      if (isset($data['codmatricula']) and ($data['codmatricula']!="%")) {
        $sqltext_array[]="tb_matricula.mtr_id=?";
        $data_array[]=$data['codmatricula'];
      }
      if (isset($data['codgestion']) and ($data['codgestion']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.gestion_cod=?";
        $data_array[]=$data['codgestion'];
      }
  
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
      $qry = $this->db->query("SELECT 
          tb_docpago_cobros.docpago_cod AS coddocpago,
          DATE(IFNULL(tb_docpago_cobros.dcp_fecha_operacion, tb_docpago_cobros.dpc_fecha)) AS fecha,
          SUM(tb_docpago_cobros.dpc_monto) AS monto
        FROM
          tb_docpago_cobros
        WHERE
          tb_docpago_cobros.docpago_cod IN (SELECT DISTINCT tb_docpago_detalle.cod_docpago FROM tb_docpago_detalle INNER JOIN tb_matricula ON (tb_docpago_detalle.codmatricula = tb_matricula.mtr_id) $sqltext)
        GROUP BY
          tb_docpago_cobros.docpago_cod,
          DATE(IFNULL(tb_docpago_cobros.dcp_fecha_operacion, tb_docpago_cobros.dpc_fecha)) 
        ORDER BY fecha", $data_array);
      
      return $qry->result();
  }

  public function m_get_cobros($data)
  {
    $qry = $this->db->query("SELECT 
          tb_docpago_cobros.dpc_id AS codigo,
          tb_docpago_cobros.dpc_fecha AS fecha,
          tb_docpago_cobros.medio_cod AS idmedio,
          tb_docpago_medio.dm_nombre AS nommedio,
          tb_docpago_cobros.banco_cod AS idbanco,
          tb_banco.bn_nombre AS nombanco,
          tb_docpago_cobros.dpc_monto AS montocob,
          tb_docpago_cobros.docpago_cod AS idocpag,
          tb_docpago_cobros.dcp_nro_operacion AS voucher,
          tb_docpago_cobros.dcp_fecha_operacion AS fechaoper,
          tb_docpago_cobros.dcp_fecha_operacion_nota_credito AS fechaoper_nc,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres
        FROM
          tb_docpago_cobros
          INNER JOIN tb_docpago_medio ON (tb_docpago_cobros.medio_cod = tb_docpago_medio.dm_codigo)
          LEFT JOIN tb_banco ON (tb_docpago_cobros.banco_cod = tb_banco.bn_codigo)
          LEFT JOIN tb_usuario ON (tb_docpago_cobros.cod_usuario = tb_usuario.id_usuario)
          LEFT JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
        WHERE tb_docpago_cobros.docpago_cod = ?
        ORDER BY
          tb_docpago_cobros.dcp_fecha_operacion DESC", $data);
      
      return $qry->result();
  }

  public function m_get_cobros_xVoucher($data)
  {
    $qry = $this->db->query("SELECT 
          tb_docpago_cobros.dpc_id AS codigo,
          tb_docpago_cobros.dpc_fecha AS fecha,
          tb_docpago_cobros.medio_cod AS codmedio,
          tb_docpago_cobros.banco_cod AS codbanco,
          tb_banco.bn_nombre AS banco,
          tb_docpago_cobros.dpc_monto AS monto,
          tb_docpago_cobros.docpago_cod AS coddoc,
          tb_docpago.dcp_serie as seriedoc,
          tb_docpago.dcp_numero as nrodoc,
          tb_docpago_cobros.dcp_nro_operacion AS voucher,
          tb_docpago_cobros.dcp_fecha_operacion  as fecha_operacion,
          tb_docpago.sede_id as codsede, 
          tb_sede.sed_abreviatura as sede_abrevia
        FROM
          tb_docpago_cobros
          LEFT OUTER JOIN tb_banco ON (tb_docpago_cobros.banco_cod = tb_banco.bn_codigo)
          INNER JOIN tb_docpago ON (tb_docpago_cobros.docpago_cod = tb_docpago.dcp_id)
          INNER JOIN tb_sede ON (tb_docpago.sede_id = tb_sede.id_sede)
        WHERE tb_docpago_cobros.banco_cod=? and date(tb_docpago_cobros.dcp_fecha_operacion) = ?
        ORDER BY tb_docpago.sede_id, tb_docpago_cobros.dpc_fecha asc", $data);
      
      return $qry->result();
  }

  

  public function m_get_mediopago_xnombre($data)
  {
      $qry = $this->db->query("SELECT 
          tb_docpago_medio.dm_codigo AS codigo,
          tb_docpago_medio.dm_nombre AS nombre
        FROM
          tb_docpago_medio
        WHERE tb_docpago_medio.dm_nombre = ?
        LIMIT 1", $data);
      
      return $qry->row();
  }

  public function m_eliminar_cobro($data)
  {
    $this->db->query("CALL sp_tb_docpago_cobros_delete(?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida;
  }

  public function m_eliminar_cobro_all($data)
  {
    $this->db->query("DELETE FROM tb_docpago_cobros WHERE docpago_cod = ?",$data);
    return true;
  }

  public function m_get_cobrosxcodigo($data)
  {
    $qry = $this->db->query("SELECT 
          tb_docpago_cobros.dpc_id AS codigo,
          tb_docpago_cobros.dpc_fecha AS fecha,
          tb_docpago_cobros.medio_cod AS idmedio,
          tb_docpago_medio.dm_nombre AS nommedio,
          tb_docpago_cobros.banco_cod AS idbanco,
          tb_banco.bn_nombre AS nombanco,
          tb_docpago_cobros.dpc_monto AS montocob,
          tb_docpago_cobros.docpago_cod AS idocpag,
          tb_docpago_cobros.dcp_nro_operacion AS voucher,
          tb_docpago_cobros.dcp_fecha_operacion AS fechaoper
        FROM
          tb_docpago_cobros
          INNER JOIN tb_docpago_medio ON (tb_docpago_cobros.medio_cod = tb_docpago_medio.dm_codigo)
          LEFT JOIN tb_banco ON (tb_docpago_cobros.banco_cod = tb_banco.bn_codigo)
        WHERE tb_docpago_cobros.dpc_id = ? ", $data);
      
      return $qry->row();
  }

  public function m_updateDocPagoCobros($id,$data)
  {
    
    $this->db->where('dpc_id', $id);
    $this->db->update('tb_docpago_cobros', $data);
    //return $id;
    $rp = new stdClass;
    $rp->id =$id;
    //$rp->salida=($rp->id==0) ? false : true;
    $rp->salida= true;
    return  $rp;

  }
}