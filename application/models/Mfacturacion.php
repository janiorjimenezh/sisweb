<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion extends CI_Model {

	function __construct() {
           parent::__construct();
    }

  public function m_getDocumentos($data) {
      $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id as coddocpago,
          tb_docpago.tipodoc_cod as codtipodoc,
          tb_doctipo.dt_nombre as tipodoc,
          tb_docpago.dcp_serie as serie,
          tb_docpago.dcp_numero as numero,
          tb_docpago.dcp_fecha_hora as fechahora,
          tb_docpago.dcp_condicion as condicion,
          tb_docpago.pagante_cod as codpagante,
          tb_docpago.dcp_pagante as pagante,
          tb_docpago.pagante_tipodoc as codtipodoc_pagante,
          tb_docpago.pagante_nrodoc as nrodoc_pagante,
          tb_docpago.dcp_valor_venta as valor,
          tb_docpago.dcp_mnto_igv as igv_monto,
          tb_docpago.dcp_total as total,
          tb_docpago.dcp_nc_monto_aplicado as monto_aplicado,
        FROM
          tb_doctipo
          INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
        WHERE tb_docpago.dcp_id  = ? ", $data);
    
        return $qry->row();

  }


  public function m_updateDocPago($id,$data)
  {
    
    $this->db->where('dcp_id', $id);
    $this->db->update('tb_docpago', $data);
    return true;
  }


  public function m_get_tiposdoc()
  {
      $qry = $this->db->query("SELECT 
          tb_doctipo.dt_id AS codigo,
          tb_doctipo.dt_nombre AS nombre
        FROM
          tb_doctipo
        ORDER BY
          tb_doctipo.dt_nombre");
      
      return $qry->result();
  }

    //janior todo en 1
    public function m_get_emitidos_limit_xsede($inicio, $limite,$sede,$tipo,$estado,$pagante='',$fechas=array())
    {
        if ($inicio == 0) {
          $limitado = "limit $limite";
        } else {
          $limitado = "limit $inicio, $limite";
        }
        $data=array($sede,$tipo,$estado);
        $sqltext="";
        if (count($fechas)>0){
          $sqltext=" AND tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
          $data[]=$fechas[0];
          $data[]=$fechas[1];

        }
        if (trim($pagante)!=""){
          $sqltext= $sqltext." AND concat(tb_docpago.dcp_serie,'-',tb_docpago.dcp_numero,tb_docpago.pagante_cod,' ',tb_docpago.dcp_pagante)  like ? ";
          $data[]="%".$pagante."%";
        }
        $qry = $this->db->query("SELECT 
            tb_docpago.dcp_id AS codigo,
            tb_docpago.dcp_serie AS serie,
            tb_docpago.dcp_numero AS numero,
            tb_docpago.dcp_fecha_hora AS fecha_hora,
            tb_docpago.pagante_cod AS codpagante,
            tb_docpago.dcp_pagante AS pagante,
            tb_docpago.pagante_tipodoc AS pagantetipodoc,
            tb_docpago.pagante_nrodoc AS pagantenrodoc,
            tb_docpago.tipodoc_cod AS tipodoc,
            tb_docpago.dcp_estado AS estado,
            tb_docpago.dcp_total AS total,
            tb_docpago.sede_id AS sede,
            tb_docpago.dcp_mnto_igv AS migv,
            tb_docpago.dcp_autorizar_voucher_antiguos AS autoriza_voucherantiguo,
            tb_docpago_sunat.dcps_aceptado as s_aceptado,
            tb_docpago_sunat.dcps_snt_descripcion as s_descripcion,
            tb_docpago_sunat.dcps_snt_note as s_note,
            tb_docpago_sunat.dcps_snt_responsecode as s_response,
            tb_docpago_sunat.dcps_snt_soap_error as s_soap,
            tb_docpago_sunat.dcps_snt_enlace_xml enl_xml,
            tb_docpago_sunat.dcps_snt_enlace_cdr enl_cdr,
            tb_docpago_sunat.dcps_snt_enlace_pdf enl_pdf,
            tb_docpago_sunat.dcps_error_cod as error_cod,
            tb_docpago_sunat.dcps_error_desc as error_desc,
            tb_docpago.dcp_anulacion_motivo as anul_motivo,
            tb_docpago.dcp_fecha_anulacion as anul_fecha,
            tb_matricula.mtr_id AS codmat,
            tb_periodo.ped_nombre AS periodo,
            tb_ciclo.cic_nombre AS ciclo
          FROM
            tb_docpago_sunat
            INNER JOIN tb_docpago ON (tb_docpago_sunat.dcps_id = tb_docpago.dcp_id) 
            LEFT OUTER JOIN tb_matricula ON (tb_docpago.matricula_cod = tb_matricula.mtr_id) 
            LEFT OUTER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
            LEFT OUTER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          WHERE tb_docpago.sede_id=? AND tb_docpago.tipodoc_cod like ? AND tb_docpago.dcp_estado like ? $sqltext 
          ORDER BY
            tb_docpago.dcp_fecha_hora DESC $limitado", $data);
        
        $rs['items'] =$qry->result();
        $qryc = $this->db->query("SELECT 

            count(tb_docpago.dcp_id) AS conteo
          FROM
            tb_docpago
          WHERE tb_docpago.sede_id=? AND tb_docpago.tipodoc_cod like ? AND tb_docpago.dcp_estado like ? $sqltext", $data);
        $rs['numitems']= $qryc->row()->conteo;
        return $rs;
    }


    

    public function m_get_items_gestion_habilitados()
    {
        $qry = $this->db->query("SELECT 
        tb_gestion.gt_codigo AS codigo,
        tb_gestion.gt_nombre AS gestion,
        tb_gestion.cod_tipoafectacion AS codtipafecta,
        tb_gestion.cod_unidad AS codunidad,
        tb_gestion.gt_facturar_como AS facturar_cod,
        tb_categoria.gt_nombre AS facturar_como,
        tb_gestion.gt_afectacion AS afecta 
      FROM
        tb_gestion
        INNER JOIN tb_gestion tb_categoria ON (tb_categoria.gt_codigo = tb_gestion.gt_facturar_como)
      WHERE
        tb_gestion.gt_categoria <> '00.00' AND 
        tb_categoria.gt_habilitado = 'SI'
      ORDER BY tb_gestion.gt_nombre");
        
        return $qry->result();
    }

    public function m_get_unidades_habilitados()
    {
        $qry = $this->db->query("SELECT 
            tb_doc_unidades.un_codigo as codigo,
            tb_doc_unidades.un_descripcion as nombre
          FROM
            tb_doc_unidades
          WHERE
            tb_doc_unidades.un_habilitada = 'SI'");
        
        return $qry->result();
    }

    public function m_get_afectacion_habilitados()
    {
        $qry = $this->db->query("SELECT 
            tb_doc_tipoafectacion.ta_codigo as codigo,
            tb_doc_tipoafectacion.ta_descripcion as nombre,
            tb_doc_tipoafectacion.ta_info as info,
            tb_doc_tipoafectacion.ta_esgratis as esgratis 
          FROM
            tb_doc_tipoafectacion
          WHERE
            tb_doc_tipoafectacion.ta_habilitado = 'SI'");
        
        return $qry->result();
    }

    public function m_get_isc_habilitados()
    {
        $qry = $this->db->query("SELECT 
            tb_doc_isc.isc_codigo as codigo,
            tb_doc_isc.isc_descripcion as nombre
          FROM
            tb_doc_isc
          WHERE
            tb_doc_isc.isc_habilitado = 'SI'
          ORDER BY isc_codigo_sunat");
        
        return $qry->result();
    }

    public function m_get_tipo_operacion_xtipodoc_habilitados($data)
    {
        $qry = $this->db->query("SELECT 
          tb_doc_tipo_operacion51_tipodoc.cod_codtipo as codtipodoc,
          tb_doc_tipo_operacion_51.to_codigo as codopera51,
          tb_doc_tipo_operacion_51.to_descripcion as nombre
        FROM
          tb_doc_tipo_operacion51_tipodoc
          INNER JOIN tb_doc_tipo_operacion_51 ON (tb_doc_tipo_operacion51_tipodoc.cod_tipo_operacion51 = tb_doc_tipo_operacion_51.to_codigo)
        WHERE
          tb_doc_tipo_operacion_51.to_habilitado = 'SI' AND tb_doc_tipo_operacion51_tipodoc.cod_codtipo = ?",$data);
        
        return $qry->result();
    }


    public function m_get_tipo_identidad_habilitados()
    {
        $qry = $this->db->query("SELECT 
            tb_doc_identidad.ti_codigo AS codigo,
            tb_doc_identidad.ti_descripcion AS nombre,
            tb_doc_identidad.ti_longitud AS longitud,
            tb_doc_identidad.ti_docpermitidos AS docs_permitidos
          FROM
            tb_doc_identidad
          WHERE
            tb_doc_identidad.ti_habilitado = 'SI'
          ORDER BY
            tb_doc_identidad.ti_nroorden");
        
        return $qry->result();
    }

    public function m_get_tipo_notas($data)
    {
        $qry = $this->db->query("SELECT 
            tb_doc_tiponota_cd.tn_codigo as codigo,
            tb_doc_tiponota_cd.tn_descripcion as nombre
          FROM
            tb_doc_tiponota_cd
          WHERE
            tb_doc_tiponota_cd.cod_tipodoc = ? AND tb_doc_tiponota_cd.tn_habilitado='SI'",$data);
        
        return $qry->result();
    }
    
    
    public function m_get_conexion_nubefact($data)
    {
        $qry = $this->db->query("SELECT 
                  sed_token_nubefact as token,
                  sed_ruta_nubefact as ruta
                FROM 
                  tb_sede 
                WHERE id_sede = ? LIMIT 1", $data);
        
        return $qry->row();
    }

    public function m_get_docserie($data)
    {
        $qry = $this->db->query("SELECT 
                  tb_doctipo_sede.cod_sede as sede,
                  tb_doctipo_sede.cod_doctipo as tipo,
                  tb_doctipo_sede.dtse_ruc as ruc,
                  tb_doctipo_sede.dtse_serie as serie,
                  tb_doctipo_sede.dtse_contador_nro as contador,
                  tb_doctipo_sede.dtse_codlocal_sunat as codsunat,
                  tb_doctipo_sede.cod_tipo_operacion51 as codoperacion51,
                  tb_doctipo_sede.dtse_igv_porcentaje as igvpr
                FROM 
                  tb_doctipo_sede 
                WHERE tb_doctipo_sede.cod_doctipo = ? AND tb_doctipo_sede.cod_sede = ? AND tb_doctipo_sede.dtse_habilitado='SI' 
                LIMIT 1", $data);
        
        return $qry->row();
    }

    public function update_correlativo_sede($data)
    {
      $qry = $this->db->query("UPDATE tb_doctipo_sede 
                  SET tb_doctipo_sede.dtse_contador_nro = tb_doctipo_sede.dtse_contador_nro + 1 
                  WHERE tb_doctipo_sede.cod_doctipo = ? AND tb_doctipo_sede.cod_sede = ?", $data );
      return 1;

    }

 

  public function m_insert_facturacion($data)
  {
    $this->db->query("CALL  sp_tb_docpago_boleta_insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid,@nrodoc)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid,@nrodoc as nrodoc');
    return   $res->row(); 
  }
  public function m_insert_facturacion_reemplazo($data)
  {
    $this->db->query("CALL  sp_tb_docpago_boleta_reemp_insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid,@nrodoc)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid,@nrodoc as nrodoc');
    return   $res->row(); 
  }

  public function m_insert_facturacion_cuotas_credito($data)
  {
    $this->db->insert_batch('tb_docpago_credito_cuotas', $data);
    return  true; 
  }

  

  public function m_update_facturacion($data)
  {
    $this->db->query("CALL  sp_tb_docpago_boleta_update(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid,@nrodoc)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid,@nrodoc as nrodoc');
    return $res->row(); 
  }

  public function m_insert_facturacion_rpsunat($data)
  {
  
    $this->db->query("CALL  sp_tb_docpago_sunat_insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }
  public function m_insert_facturacion_rpsunat_error($data)
  {
  
    $this->db->query("CALL  sp_tb_docpago_sunat_error_insert(?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }

  public function m_update_facturacion_rpsunat($data)
  {
  
    $this->db->query("CALL  sp_tb_docpago_sunat_update(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }
  public function m_update_facturacion_rpsunat_error($data)
  {
  
    $this->db->query("CALL  sp_tb_docpago_sunat_error_update(?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }


  public function m_insert_facturacion_anulacion_rpsunat($data)
  {
    $this->db->query("CALL  sp_tb_docpago_sunat_anulacion_insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }
  public function m_insert_facturacion_rpsunat_anulacion_error($data)
  {
  
    $this->db->query("CALL  sp_tb_docpago_sunat_error_anulacion_insert(?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row(); 
  }
  


  public function m_insert_facturacion_detalle($data)
  {
    $this->db->query("CALL sp_tb_docpago_detalle_insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }
  public function m_insert_facturacionnota_detalle($data)
  {
    $this->db->query("CALL sp_tb_docpagonota_detalle_insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }

  public function m_update_facturacion_detalle($data)
  {
    $this->db->query("CALL sp_tb_docpago_detalle_update(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    return   $res->row(); 
  }


  public function get_docpago($data) {
    $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id as coddoc,
          tb_doctipo.dt_codnubefact AS tipodoc,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS nro,
          tb_docpago.pagante_tipodoc AS codtipodocidentidad,
          tb_doc_identidad.ti_codigo_sunat AS pagtipodoc,
          tb_docpago.pagante_cod as codpagante,
          tb_docpago.pagante_nrodoc AS pagnrodoc,
          tb_docpago.dcp_pagante AS pagante,
          tb_docpago.dcp_direccion AS pagdirecion,
          tb_pagante.pg_correo1 AS pagcorreo1,
          tb_pagante.pg_correo2 AS pagcorreo2,
          tb_pagante.pg_correo_corp AS pagcorreo3,
          tb_docpago.dcp_fecha_hora AS fecha,
          tb_docpago.dcp_fecha_vence AS vence,
          tb_docpago.dcp_igv AS igvporc,
          tb_docpago.dcp_descuento_general AS dsctoglobal,
          tb_docpago.dcp_mnto_dsctos_totales AS dsctototal,
          tb_docpago.dcp_mnto_oper_gravadas AS opergrav,
          tb_docpago.dcp_mnto_oper_inafecta AS operinaf,
          tb_docpago.dcp_mnto_oper_exonerada AS operexon,
          tb_docpago.dcp_mnto_igv AS igvtotal,
          tb_docpago.dcp_mnto_oper_gratis AS opergrat,
          tb_docpago.dcp_total AS total,
          tb_docpago.dcp_observacion AS obs,
          tb_docpago.dcp_estado as estado,
          tb_docpago.dcp_condicion AS condicion,
          tb_docpago.dcp_autorizar_voucher_antiguos AS autoriza_voucherantiguo,
          tb_docpago.dcp_nc_monto_aplicado as monto_aplicado,
          tb_docpago.dcp_historial AS historial 
        FROM
          tb_doctipo
          INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
          INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
          INNER JOIN tb_pagante ON (tb_docpago.pagante_cod = tb_pagante.pg_codpagante)
        WHERE tb_docpago.dcp_id  = ?  LIMIT 1", $data);
    
        return $qry->row();
  }

  public function m_get_docpago_cuotas_credito($data)
  {
    $qry = $this->db->query("SELECT 
          dcpc_id as codigo,
          cod_docpago as coddocpago,
          dcpc_ncuota as ncuota,
          dcpc_fecha as  fecha,
          dcp_monto as monto
        FROM 
          tb_docpago_credito_cuotas
        WHERE cod_docpago = ? ", $data);
    return $qry->result();
  }
  

  public function get_docpagos_pendientes($data, $coddoc=null) {
    $sqltext="";
    if ($coddoc!=null){
      $sqltext=" and tb_docpago.dcp_id  = $coddoc ";
      $data[]=$coddoc;
    }
    $qry = $this->db->query("SELECT 
    tb_docpago.dcp_id AS coddoc,
    tb_docpago.tipodoc_cod,
    tb_doctipo.dt_codnubefact AS tipodoc,
    tb_docpago.dcp_serie AS serie,
    tb_docpago.dcp_numero AS nro,
    tb_doc_identidad.ti_codigo_sunat AS pagtipodoc,
    tb_docpago.pagante_nrodoc AS pagnrodoc,
    tb_docpago.dcp_pagante AS pagante,
    tb_docpago.dcp_direccion AS pagdirecion,
    tb_docpago.dcp_fecha_hora AS fecha,
    tb_docpago.dcp_fecha_vence AS vence,
    tb_docpago.dcp_igv AS igvporc,
    tb_docpago.dcp_descuento_general AS dsctoglobal,
    tb_docpago.dcp_mnto_dsctos_totales AS dsctototal,
    tb_docpago.dcp_mnto_oper_gravadas AS opergrav,
    tb_docpago.dcp_mnto_oper_inafecta AS operinaf,
    tb_docpago.dcp_mnto_oper_exonerada AS operexon,
    tb_docpago.dcp_mnto_igv AS igvtotal,
    tb_docpago.dcp_mnto_oper_gratis AS opergrat,
    tb_docpago.dcp_total AS total,
    tb_docpago.dcp_observacion AS obs,
    tb_docpago.dcp_estado AS estado,
    tb_docpago.dcp_condicion AS condicion,
    tb_doc_tiponota_cd.tn_codigo_nubefact AS codtiponota,
    tb_docpago.dcp_serie_afectado AS serie_afectado,
    tb_docpago.dcp_numero_afectado AS nro_afectado,
    tb_docpago.dcp_motivo_afectado AS motivo_afectado,
    tb_doctipo1.dt_codnubefact AS tipodoc_afectado,
    tb_pagante.pg_correo1 AS correo_1,
    tb_pagante.pg_correo2 as correo_2,
    tb_pagante.pg_correo_corp as correo_corp
  FROM
    tb_doctipo
    INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
    INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
    LEFT OUTER JOIN tb_doc_tiponota_cd ON (tb_docpago.tiponota_cod = tb_doc_tiponota_cd.tn_codigo)
    LEFT OUTER JOIN tb_doctipo tb_doctipo1 ON (tb_docpago.tipodoc_cod_afectado = tb_doctipo1.dt_id)
    LEFT OUTER JOIN tb_pagante ON (tb_docpago.pagante_cod = tb_pagante.pg_codpagante)

      WHERE
        tb_docpago.sede_id = ? AND 
        (tb_docpago.dcp_estado = 'PENDIENTE' OR tb_docpago.dcp_estado = 'ERROR') AND  
        tb_docpago.dcp_fecha_creacion < CURDATE() $sqltext 
      ORDER BY
        tb_docpago.dcp_serie,
        tb_docpago.dcp_numero", $data);
    
        return $qry->result();

  }
  public function get_items_docpago_pendientes($data,$coddoc=null) {
    $sqltext="";
    if ($coddoc!=null){
      $sqltext=" and tb_docpago.dcp_id  = $coddoc ";
      $data[]=$coddoc;
    }
    $qry = $this->db->query("SELECT 
          tb_docpago_detalle.cod_docpago as coddoc,
          tb_docpago_detalle.cod_unidad AS unidad,
          tb_docpago_detalle.gestion_cod AS codgestion,
          tb_docpago_detalle.dpd_gestion AS gestion,
          tb_docpago_detalle.dpd_cantidad AS cantidad,
          tb_docpago_detalle.dpd_facturar_como AS codgestion_como,
          tb_docpago_detalle.dpd_facturar_como_cant AS cantidad_como,
          tb_docpago_detalle.dpd_mnto_valor_unitario AS v_unitario,
          tb_docpago_detalle.dpd_mnto_precio_unit AS p_unitario,
          tb_docpago_detalle.dpd_mnto_descuento AS m_descuento,
          tb_docpago_detalle.dpd_mnto_base_sinigv AS subtotal,
          tb_doc_tipoafectacion.ta_codigo_nubefact AS tipoigv,
          tb_docpago_detalle.dpd_mnto_igv AS igv,
          tb_docpago_detalle.dpd_mnto_valor_venta AS total
        FROM
          tb_doc_tipoafectacion
          INNER JOIN tb_docpago_detalle ON (tb_doc_tipoafectacion.ta_codigo = tb_docpago_detalle.cod_tipoafc_igv)
          INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id)
       WHERE tb_docpago.sede_id  = ? 
       AND (tb_docpago.dcp_estado='PENDIENTE' OR tb_docpago.dcp_estado='ERROR') $sqltext", $data);
    
        return $qry->result();

  }

    public function get_cuotas_docpago_pendientes($data) {
        $qry = $this->db->query("SELECT 
          tb_docpago_credito_cuotas.dcpc_id as codigo,
          tb_docpago_credito_cuotas.cod_docpago as coddocpago,
          tb_docpago_credito_cuotas.dcpc_ncuota as ncuota,
          tb_docpago_credito_cuotas.dcpc_fecha as fecha,
          tb_docpago_credito_cuotas.dcp_monto as  monto
        FROM
          tb_docpago_credito_cuotas
          INNER JOIN tb_docpago ON (tb_docpago_credito_cuotas.cod_docpago = tb_docpago.dcp_id)
        WHERE
          tb_docpago.sede_id = 10 AND 
          (tb_docpago.dcp_estado = 'PENDIENTE' OR 
          tb_docpago.dcp_estado = 'ERROR')", $data);
    
        return $qry->result();

  }


  public function get_simple_docpagos_enviados($data) {
    $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id as coddoc,
          tb_doctipo.dt_codnubefact AS tipodoc,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS nro,
          tb_docpago.dcp_estado AS estado
        FROM
          tb_doctipo
          INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
        WHERE tb_docpago.sede_id  = ? AND tb_docpago.dcp_estado='ENVIADO'", $data);
    
        return $qry->result();

  }

  public function get_items_docpago($data) {
    $qry = $this->db->query("SELECT 
          tb_docpago_detalle.cod_unidad AS unidad,
          tb_docpago_detalle.gestion_cod AS codgestion,
          tb_docpago_detalle.dpd_gestion AS gestion,
          tb_docpago_detalle.dpd_cantidad AS cantidad,
          tb_docpago_detalle.dpd_facturar_como AS codgestion_como,
          tb_docpago_detalle.dpd_facturar_como_cant AS cantidad_como,
          tb_docpago_detalle.dpd_mnto_valor_unitario AS v_unitario,
          tb_docpago_detalle.dpd_mnto_precio_unit AS p_unitario,
          tb_docpago_detalle.dpd_mnto_descuento AS m_descuento,
          tb_docpago_detalle.dpd_mnto_base_sinigv AS subtotal,
          tb_doc_tipoafectacion.ta_codigo_nubefact AS tipoigv,
          tb_docpago_detalle.dpd_mnto_igv AS igv,
          tb_docpago_detalle.dpd_mnto_valor_venta AS total
        FROM
          tb_doc_tipoafectacion
          INNER JOIN tb_docpago_detalle ON (tb_doc_tipoafectacion.ta_codigo = tb_docpago_detalle.cod_tipoafc_igv)
        WHERE tb_docpago_detalle.cod_docpago  = ? ", $data);
    
        return $qry->result();

  }

  public function m_update_anular_docpago($data)
  {
    $this->db->query("CALL sp_tb_docpago_update_anular(?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida; 
  }
  public function m_update_estado_docpago($data)
  {
    $this->db->query("CALL sp_tb_docpago_update_estado(?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida; 
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

  

  /*public function m_guardar_cobro($data)
  {
    $this->db->query("CALL sp_tb_docpago_cobros_insert(?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row()->salida; 
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
          tb_docpago_cobros.docpago_cod AS idocpag
        FROM
          tb_docpago_cobros
          INNER JOIN tb_docpago_medio ON (tb_docpago_cobros.medio_cod = tb_docpago_medio.dm_codigo)
          LEFT JOIN tb_banco ON (tb_docpago_cobros.banco_cod = tb_banco.bn_codigo)
        WHERE tb_docpago_cobros.docpago_cod = ?
        ORDER BY
          tb_docpago_cobros.dpc_id ASC", $data);
      
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
  }*/

  public function m_eliminar_documento($data)
  {
    $this->db->query("CALL sp_tb_docpago_delete(?,@s)",$data);
    $res = $this->db->query('select @s as salida');
    return   $res->row();
  }

  public function fn_update_doc_codmatricula($data)
  {
    $result = $this->db->query("UPDATE 
            tb_docpago  
            SET matricula_cod = ?
            WHERE 
            dcp_id = ?", $data);
    return 1;
  }

  public function get_docpago_x_codigo($data) {
    $qry = $this->db->query("SELECT 
          tb_docpago.dcp_id AS codigo,
          tb_doctipo.dt_codnubefact AS tipodoc,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS nro,
          tb_doc_identidad.ti_codigo_sunat AS pagtipodoc,
          tb_docpago.pagante_cod AS pagcod,
          tb_docpago.pagante_nrodoc AS pagnrodoc,
          tb_docpago.dcp_pagante AS pagante,
          tb_docpago.pagante_tipodoc AS pgtipodoc,
          tb_docpago.dcp_direccion AS pagdirecion,
          tb_docpago.dcp_estado as estado
        FROM
          tb_doctipo
          INNER JOIN tb_docpago ON (tb_doctipo.dt_id = tb_docpago.tipodoc_cod)
          INNER JOIN tb_doc_identidad ON (tb_docpago.pagante_tipodoc = tb_doc_identidad.ti_codigo)
        WHERE tb_docpago.dcp_id  = ?  LIMIT 1", $data);
    
        return $qry->row();

  }

  public function fn_update_datospagante($data)
  {
    $this->db->query("CALL sp_tb_docpago_update_datos_pagante(?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as newcod');
    return   $res->row(); 
  }

  public function fn_update_codmat_detalle_pago($data)
  {
    $qry = $this->db->query("UPDATE tb_docpago_detalle SET tb_docpago_detalle.codmatricula = ? WHERE tb_docpago_detalle.dpd_id = ?", $data);
    return 1;
  }


}