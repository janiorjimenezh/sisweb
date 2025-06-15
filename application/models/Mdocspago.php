<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdocspago extends CI_Model {

	function __construct() {
   parent::__construct();
  }



  public function m_getDocsPago($data)
  {
    $data_array=array();
    $sqltext_array=array();
    $limit_text="";
    if (isset($data['serie']) and ($data['serie']!="%")) {
      $sqltext_array[]="tb_docpago.dcp_serie = ?";
      $data_array[]=$data['serie'];
    } 
    if (isset($data['codsede']) and ($data['codsede']!="%")) {
      $sqltext_array[]="tb_docpago.sede_id = ?";
      $data_array[]=$data['codsede'];
    } 
    if (isset($data['numero']) and ($data['numero']!="%")) {
      $sqltext_array[]="tb_docpago.dcp_numero = ?";
      $data_array[]=$data['numero'];
    } 
    if (isset($data['codtipodoc']) and ($data['codtipodoc']!="%")) {
      $sqltext_array[]="tb_docpago.tipodoc_cod = ?";
      $data_array[]=$data['codtipodoc'];
    } 
    if (isset($data['estadodoc']) and ($data['estadodoc']!="%")) {
      $sqltext_array[]="tb_docpago.dcp_estado = ?";
      $data_array[]=$data['estadodoc'];
    } 
    if (isset($data['busqueda']) and ($data['busqueda']!='%%')) {
      $sqltext_array[]="concat(tb_docpago.dcp_serie,'-',tb_docpago.dcp_numero,' ',tb_docpago.pagante_nrodoc,' ',tb_docpago.pagante_cod,' ',tb_docpago.dcp_pagante)  like ?";
      $data_array[]=$data['busqueda'];
    } 

    if (isset($data['fechaemision'])) {
      if (count($data['fechaemision'])>0){
        $sqltext_array[]="tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
        $data_array[]=$data['fechaemision'][0];
        $data_array[]=$data['fechaemision'][1];

      }
    }
    
    $sqltext=implode(' AND ', $sqltext_array);
    if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

    if (isset($data['limites'])) {
      if (count($data['limites'])>0){
        $limit_text="LIMIT ?";
        $data_array[]=$data['limites'][0];
      }
      if (count($data['limites'])>1){
        $limit_text=$limit_text."OFFSET ?";
        $data_array[]=$data['limites'][1];
      }
    }
    else{
      if (isset($data['protegelimites'])) {
        if ($data['protegelimites']==true){
          $limit_text="LIMIT ?";
          $data_array[]=1000;
        }
      }
    }
    $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id AS codigo,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS numero,
          tb_docpago.dcp_fecha_hora AS fecha_hora,
          tb_docpago.pagante_cod AS codpagante,
          tb_docpago.dcp_pagante AS pagante,
          tb_docpago.pagante_tipodoc AS codtipodocidentidad,
          tb_doc_identidad.ti_codigo_sunat AS codtipodocidentidad_sunat,
          tb_docpago.pagante_nrodoc AS pagantenrodoc,
          tb_docpago.tipodoc_cod AS codtipo,
          tb_doctipo.dt_codsunat AS codtipo_sunat,
          tb_docpago.dcp_estado AS estado,
          tb_docpago.dcp_igv AS igv,
          tb_docpago.dcp_mnto_igv as igv_monto,
          tb_docpago.dcp_total AS total,
          tb_docpago.sede_id AS codsede,
          tb_sede.sed_nombre AS sede,
          tb_docpago.dcp_serie_afectado AS serie_afectado,
          tb_docpago.dcp_numero_afectado AS nro_afectado,
          tb_docpago.tipodoc_cod_afectado AS tipodoc_afectado,
          tb_doctipo1.dt_codsunat AS codtipoafectado_sunat,
          tb_docpago.dcp_anulacion_motivo AS anul_motivo,
          tb_docpago.dcp_fecha_anulacion AS anul_fecha,
          tb_docpago.dcp_fecha_vence AS vence,
          tb_docpago.dcp_mnto_oper_gravadas AS gravada,
          tb_docpago.dcp_mnto_oper_inafecta AS inafecta,
          tb_docpago.dcp_mnto_oper_exonerada AS exonerada,
          tb_docpago.dcp_mnto_oper_exportacion AS exportacion,
          tb_docpago.dcp_monto_icbper AS icbper,
          tb_docpago.dcp_mnto_isc AS isc,
          tb_docpago.dcp_mnto_dsctos_totales AS dsctos_totales,
          tb_docpago.dcp_mnto_oper_gratis AS gratis,
          tb_docpago.dcp_nc_monto_aplicado as monto_aplicado,
          tb_docpago.dcp_historial as historial,
          tb_docpago_sunat.dcps_aceptado as sunat_aceptado,
          tb_docpago_sunat.dcps_snt_descripcion as sunat_descripcion,
          tb_docpago_sunat.dcps_snt_note as sunat_note,
          tb_docpago_sunat.dcps_snt_responsecode as sunat_response,
          tb_docpago_sunat.dcps_snt_soap_error as sunat_soap,
          tb_docpago_sunat.dcps_snt_enlace_xml enl_xml,
          tb_docpago_sunat.dcps_snt_enlace_cdr enl_cdr,
          tb_docpago_sunat.dcps_snt_enlace_pdf enl_pdf,
          tb_docpago_sunat.dcps_error_cod as error_cod,
          tb_docpago_sunat.dcps_error_desc as error_desc,
          tb_docpago.dcp_autorizar_voucher_antiguos as autoriza_voucherantiguo 
        FROM
          tb_docpago
          INNER JOIN tb_sede ON (tb_docpago.sede_id = tb_sede.id_sede)
          INNER JOIN tb_doctipo ON (tb_docpago.tipodoc_cod = tb_doctipo.dt_id)
          INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
          LEFT OUTER JOIN tb_doctipo tb_doctipo1 ON (tb_docpago.tipodoc_cod_afectado = tb_doctipo1.dt_id)
          INNER JOIN tb_docpago_sunat ON (tb_docpago.dcp_id = tb_docpago_sunat.dcps_id)
        $sqltext
        ORDER BY tb_docpago.sede_id, tb_docpago.dcp_fecha_hora DESC, tb_docpago.dcp_serie, tb_docpago.dcp_numero DESC $limit_text", $data_array);
      
      return $qry->result();
  }
  
  public function m_getDocsPagoCorrelativosPorSerie($data)
  {
    $data_array=array();
    $sqltext_array=array();
    $limit_text="";
    if (isset($data['serie']) and ($data['serie']!="%")) {
      $sqltext_array[]="t.dcp_serie = ?";
      $data_array[]=$data['serie'];
    } 
    if (isset($data['codsede']) and ($data['codsede']!="%")) {
      $sqltext_array[]="t.sede_id = ?";
      $data_array[]=$data['codsede'];
    } 
    if (isset($data['numero']) and ($data['numero']!="%")) {
      $sqltext_array[]="t.dcp_numero = ?";
      $data_array[]=$data['numero'];
    } 
    if (isset($data['codtipodoc']) and ($data['codtipodoc']!="%")) {
      $sqltext_array[]="t.tipodoc_cod = ?";
      $data_array[]=$data['codtipodoc'];
    } 
    if (isset($data['estadodoc']) and ($data['estadodoc']!="%")) {
      $sqltext_array[]="t.dcp_estado = ?";
      $data_array[]=$data['estadodoc'];
    } 
    // if (isset($data['busqueda']) and ($data['busqueda']!='%%')) {
    //   $sqltext_array[]="concat(t.dcp_serie,'-',t.dcp_numero,' ',t.pagante_nrodoc,' ',t.pagante_cod,' ',t.dcp_pagante)  like ?";
    //   $data_array[]=$data['busqueda'];
    // } 

    // if (isset($data['fechaemision'])) {
    //   if (count($data['fechaemision'])>0){
    //     $sqltext_array[]="t.dcp_fecha_hora BETWEEN ? AND ? ";
    //     $data_array[]=$data['fechaemision'][0];
    //     $data_array[]=$data['fechaemision'][1];

    //   }
    // }
    
    $sqltext=implode(' AND ', $sqltext_array);
    if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

   
    $qry = $this->db->query("SELECT *
    FROM (
        SELECT t.sede_id AS codsede,
            t.tipodoc_cod AS codtipo,
            t.dcp_serie AS serie, 
            t.dcp_numero AS numero, 
            @row_num := IF(@prev_grupo = dcp_serie, @row_num + 1, 1) AS row_num,
            @prev_grupo := dcp_serie
        FROM tb_docpago t
        CROSS JOIN (SELECT @row_num := 0, @prev_grupo := NULL) AS vars
        $sqltext 
        ORDER BY t.sede_id,t.dcp_serie, t.dcp_numero DESC
    ) AS numerados
    WHERE row_num <= 200;", $data_array);
      
      return $qry->result();
  }

  public function m_get_emitidos_filtro_xsede($sede,$pagante,$fechas,$estado)
  {
    $data=array($sede);
    $sqltext="";
    if (count($fechas)>0){
      $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
      $data[]=$fechas[0];
      $data[]=$fechas[1];

    }
    if (trim($pagante)!=""){
      $sqltext= $sqltext." AND concat(tb_docpago.pagante_cod,' ',tb_docpago.dcp_pagante)  like ? ";
      $data[]="%".$pagante."%";
    }

    $sqltext_estado="";
    if ($estado[0]=="TODOS"){

    }
    else{
        $sqltext_estado=" AND tb_docpago.dcp_estado IN ('".implode("','", $estado)."')";
       
    }
    //$idsede = $_SESSION['userActivo']->idsede;
    $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id AS codigo,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS numero,
          tb_docpago.dcp_fecha_hora AS fecha_hora,
          tb_docpago.pagante_cod AS codpagante,
          tb_docpago.dcp_pagante AS pagante,
          tb_docpago.pagante_tipodoc AS codtipodocidentidad,
          tb_doc_identidad.ti_codigo_sunat AS codtipodocidentidad_sunat,
          tb_docpago.pagante_nrodoc AS pagantenrodoc,
          tb_docpago.tipodoc_cod AS codtipo,
          tb_doctipo.dt_codsunat AS codtipo_sunat,
          tb_docpago.dcp_estado AS estado,
          tb_docpago.dcp_igv AS igv,
          tb_docpago.dcp_total AS total,
          tb_docpago.sede_id AS codsede,
          tb_sede.sed_nombre AS sede,
          tb_docpago.dcp_serie_afectado AS serie_afectado,
          tb_docpago.dcp_numero_afectado AS nro_afectado,
          tb_docpago.tipodoc_cod_afectado AS tipodoc_afectado,
          tb_doctipo1.dt_codsunat AS codtipoafectado_sunat,
          tb_docpago.dcp_anulacion_motivo AS anul_motivo,
          tb_docpago.dcp_fecha_anulacion AS anul_fecha,
          tb_docpago.dcp_fecha_vence AS vence,
          tb_docpago.dcp_mnto_oper_gravadas AS gravada,
          tb_docpago.dcp_mnto_oper_inafecta AS inafecta,
          tb_docpago.dcp_mnto_oper_exonerada AS exonerada,
          tb_docpago.dcp_mnto_oper_exportacion AS exportacion,
          tb_docpago.dcp_monto_icbper AS icbper,
          tb_docpago.dcp_mnto_isc AS isc,
          tb_docpago.dcp_mnto_dsctos_totales AS dsctos_totales,
          tb_docpago.dcp_mnto_oper_gratis AS gratis
        FROM
          tb_docpago
          INNER JOIN tb_sede ON (tb_docpago.sede_id = tb_sede.id_sede)
          INNER JOIN tb_doctipo ON (tb_docpago.tipodoc_cod = tb_doctipo.dt_id)
          INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
          LEFT OUTER JOIN tb_doctipo tb_doctipo1 ON (tb_docpago.tipodoc_cod_afectado = tb_doctipo1.dt_id)
        WHERE tb_docpago.sede_id LIKE ? AND tb_sede.sed_activo = 'SI'  $sqltext $sqltext_estado
        ORDER BY tb_docpago.sede_id, tb_docpago.dcp_serie, tb_docpago.dcp_numero ", $data);
      
      return $qry->result();
  }
  
}