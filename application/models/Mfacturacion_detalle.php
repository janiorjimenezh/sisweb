<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfacturacion_detalle extends CI_Model {

  function __construct() {
      parent::__construct();
  }

  public function m_updateDocPagoDetalle($where,$data)
  {  
    if (is_array($where)){
      $this->db->where($where);
    }
    else{
      $this->db->where('dpd_id', $where);
    }
    $this->db->update('tb_docpago_detalle', $data);
    return true;
  }

  public function m_updateWhereDocPagoDetalle($id,$data)
  {  
    $this->db->where('dpd_id', $id);
    $this->db->update('tb_docpago_detalle', $data);
    return true;
  }


  public function m_getDocPagoDetalles($data){

      $data_array=array();
      $sqltext_array=array();
      $limit_text="";
      if (isset($data['coddocpago']) and ($data['coddocpago']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.cod_docpago =?";
        $data_array[]=$data['coddocpago'];
      }
      if (isset($data['coddetalle']) and ($data['coddetalle']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.dpd_id = ?";
        $data_array[]=$data['coddetalle'];
      } 
      if (isset($data['codtipodoc']) and ($data['codtipodoc']!="%")) {
        $sqltext_array[]="tb_docpago.tipodoc_cod = ?";
        $data_array[]=$data['codtipodoc'];
      } 
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_matricula.codigosede = ?";
        $data_array[]=$data['codsede'];
      } 
      if (isset($data['codsede_dp']) and ($data['codsede_dp']!="%")) {
        $sqltext_array[]="tb_docpago.sede_id = ?";
        $data_array[]=$data['codsede_dp'];
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
      if (isset($data['carnet']) and ($data['carnet']!="%")) {
        $sqltext_array[]="tb_inscripcion.ins_carnet=?";
        $data_array[]=$data['carnet'];
      }
      if (isset($data['codpagante']) and ($data['codpagante']!="%")) {
        $sqltext_array[]="tb_docpago.pagante_cod=?";
        $data_array[]=$data['codpagante'];
      }
      if (isset($data['codinscripcion']) and ($data['codinscripcion']!="%")) {
        $sqltext_array[]="tb_matricula.codigoinscripcion=?";
        $data_array[]=$data['codinscripcion'];
      }
      if (isset($data['codmatricula'])) {
        $sqltext_array[]="tb_docpago_detalle.codmatricula=?";
        $data_array[]=$data['codmatricula'];
      }
      if (isset($data['codgestion']) and ($data['codgestion']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.gestion_cod=?";
        $data_array[]=$data['codgestion'];
      }
      if (isset($data['estadodoc']) and ($data['estadodoc']!="%")) {
        $sqltext_array[]="tb_docpago.dcp_estado =?";
        $data_array[]=$data['estadodoc'];
      }
      if (isset($data['dp_codperiodo']) and ($data['dp_codperiodo']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.codigoperiodo=?";
        $data_array[]=$data['dp_codperiodo'];
      }

      if (isset($data['buscar']) and ($data['buscar']!="%%")) {
        $sqltext_array[]="concat(tb_docpago.dcp_serie,'-',tb_docpago.dcp_numero,' ',tb_docpago.pagante_cod,' ',tb_docpago.dcp_pagante)  like ?";
        $data_array[]=$data['buscar'];
      }

      if (isset($data['fechas'])) {
        if (count($data['fechas'])>0){
          $sqltext_array[]="tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
          $data_array[]=$data['fechas'][0];
          $data_array[]=$data['fechas'][1];

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

      
      // if (isset($data['estados'])) {
      //   if ($data['estados'][0]=="TODOS"){

      //   }
      //   else{
      //       $sqltext=" AND tb_docpago.dcp_estado IN ('".implode("','", $data['estados'])."')";
      //   }
      // }    



      $resultmiembro = $this->db->query("SELECT 
          tb_docpago_detalle.codmatricula,
          tb_matricula.codigoinscripcion AS codinscripcion,
          tb_inscripcion.ins_carnet AS carne,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_matricula.codigoperiodo AS codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_matricula.codigocarrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS sigla,
          tb_matricula.codigociclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_matricula.codigoturno AS codturno,
          tb_matricula.codigoseccion AS codseccion,
          tb_matricula.codigoplan AS codplan,
          tb_matricula.mtr_bloquear_evaluaciones AS bloqueo,
          tb_estadoalumno.esal_nombre AS estado_alumno,
          tb_matricula.mtr_cuotapension AS cuota,
          tb_matricula.codigobeneficio AS codbeneficio,
          tb_beneficio.ben_sigla AS bene_sigla,
          tb_docpago_detalle.dpd_id AS coddetalle,
          tb_docpago_detalle.cod_docpago AS coddocpago,
          tb_docpago_detalle.dpd_cantidad AS cantidad,
          tb_docpago_detalle.gestion_cod AS codgestion,
          tb_gestion.gt_nombre AS gestion,
          tb_docpago_detalle.dpd_facturar_como AS codgestion_como,
          tb_docpago_detalle.dpd_gestion AS gestion_como,
          tb_docpago_detalle.deuda_cod AS coddeuda,
          tb_docpago_detalle.dpd_mnto_valor_unitario AS unitario,
          tb_docpago_detalle.dpd_mnto_valor_venta AS monto,
          tb_docpago_detalle.dpd_esgratis as esgratis,
          tb_docpago.tipodoc_cod AS codtipodoc,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS numero,
          tb_docpago.dcp_fecha_hora AS fecha,
          tb_docpago.pagante_cod AS codpagante,
          tb_docpago.dcp_pagante AS pagante,
          tb_docpago.dcp_estado AS estado,
          tb_deuda_individual.cod_gestion AS dcodgestion,
          tb_gestion1.gt_nombre AS dgestion,
          tb_deuda_individual.di_monto AS dmonto,
          tb_deuda_individual.di_fecha_vencimiento AS dvence,
          tb_deuda_individual.di_saldo AS dsaldo,
          tb_docpago.sede_id AS codsede,
          tb_sede.sed_nombre as sede,
          tb_sede.sed_abreviatura as sede_sigla
        FROM
          tb_docpago_detalle
          INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id)
          LEFT OUTER JOIN tb_matricula ON (tb_docpago_detalle.codmatricula = tb_matricula.mtr_id)
          LEFT OUTER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          LEFT OUTER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
          LEFT OUTER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
          LEFT OUTER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
          LEFT OUTER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
          LEFT OUTER JOIN tb_beneficio ON (tb_matricula.codigobeneficio = tb_beneficio.ben_id)
          INNER JOIN tb_gestion ON (tb_docpago_detalle.gestion_cod = tb_gestion.gt_codigo)
          LEFT OUTER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
          LEFT OUTER JOIN tb_deuda_individual ON (tb_docpago_detalle.deuda_cod = tb_deuda_individual.di_codigo)
          LEFT OUTER JOIN tb_gestion tb_gestion1 ON (tb_deuda_individual.cod_gestion = tb_gestion1.gt_codigo)
          INNER JOIN tb_sede ON (tb_docpago.sede_id = tb_sede.id_sede)
        $sqltext 
        ORDER BY
          tb_docpago.sede_id,tb_docpago.dcp_fecha_hora desc,tb_docpago_detalle.gestion_cod desc $limit_text", $data_array);
        return $resultmiembro->result();
  
  }
  public function m_getDocPagoDetalles2($data){
      $data_array=array();
      $sqltext_array=array();
      $limit_text="";
      if (isset($data['coddocpago']) and ($data['coddocpago']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.cod_docpago =?";
        $data_array[]=$data['coddocpago'];
      }
      if (isset($data['coddetalle']) and ($data['coddetalle']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.dpd_id = ?";
        $data_array[]=$data['coddetalle'];
      } 
      if (isset($data['codtipodoc']) and ($data['codtipodoc']!="%")) {
        $sqltext_array[]="tb_docpago.tipodoc_cod = ?";
        $data_array[]=$data['codtipodoc'];
      } 
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_matricula.codigosede = ?";
        $data_array[]=$data['codsede'];
      } 
      if (isset($data['codsede_dp']) and ($data['codsede_dp']!="%")) {
        $sqltext_array[]="tb_docpago.sede_id = ?";
        $data_array[]=$data['codsede_dp'];
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
      if (isset($data['carnet']) and ($data['carnet']!="%")) {
        $sqltext_array[]="tb_inscripcion.ins_carnet=?";
        $data_array[]=$data['carnet'];
      }
      if (isset($data['codpagante']) and ($data['codpagante']!="%")) {
        $sqltext_array[]="tb_docpago.pagante_cod=?";
        $data_array[]=$data['codpagante'];
      }
      if (isset($data['codinscripcion']) and ($data['codinscripcion']!="%")) {
        $sqltext_array[]="tb_matricula.codigoinscripcion=?";
        $data_array[]=$data['codinscripcion'];
      }
      if (isset($data['codmatricula']) and ($data['codmatricula']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.codmatricula=?";
        $data_array[]=$data['codmatricula'];
      }
      if (isset($data['codgestion']) and ($data['codgestion']!="%")) {
        $sqltext_array[]="tb_docpago_detalle.gestion_cod=?";
        $data_array[]=$data['codgestion'];
      }
      if (isset($data['estadodoc']) and ($data['estadodoc']!="%")) {
        $sqltext_array[]="tb_docpago.dcp_estado =?";
        $data_array[]=$data['estadodoc'];
      }

      if (isset($data['buscar']) and ($data['buscar']!="%%")) {
        $sqltext_array[]="concat(tb_docpago.dcp_serie,'-',tb_docpago.dcp_numero,' ',tb_docpago.pagante_cod,' ',tb_docpago.dcp_pagante)  like ?";
        $data_array[]=$data['buscar'];
      }

      if (isset($data['fechas'])) {
        if (count($data['fechas'])>0){
          $sqltext_array[]="tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
          $data_array[]=$data['fechas'][0];
          $data_array[]=$data['fechas'][1];

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

      
      // if (isset($data['estados'])) {
      //   if ($data['estados'][0]=="TODOS"){

      //   }
      //   else{
      //       $sqltext=" AND tb_docpago.dcp_estado IN ('".implode("','", $data['estados'])."')";
      //   }
      // }    



      $resultmiembro = $this->db->query("SELECT 
          tb_docpago_detalle.codmatricula,
          tb_matricula.codigoinscripcion AS codinscripcion,
          tb_inscripcion.ins_carnet AS carne,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_matricula.codigoperiodo AS codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_matricula.codigocarrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS sigla,
          tb_matricula.codigociclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_matricula.codigoturno AS codturno,
          tb_matricula.codigoseccion AS codseccion,
          tb_matricula.codigoplan AS codplan,
          tb_matricula.mtr_bloquear_evaluaciones AS bloqueo,
          tb_estadoalumno.esal_nombre AS estado_alumno,
          tb_matricula.mtr_cuotapension AS cuota,
          tb_matricula.codigobeneficio AS codbeneficio,
          tb_beneficio.ben_sigla AS bene_sigla,
          tb_docpago_detalle.dpd_id AS coddetalle,
          tb_docpago_detalle.cod_docpago AS coddocpago,
          tb_docpago_detalle.dpd_cantidad AS cantidad,
          tb_docpago_detalle.gestion_cod AS codgestion,
          tb_gestion.gt_nombre AS gestion,
          tb_docpago_detalle.dpd_facturar_como AS codgestion_como,
          tb_docpago_detalle.dpd_gestion AS gestion_como,
          tb_docpago_detalle.deuda_cod AS coddeuda,
          tb_docpago_detalle.dpd_mnto_valor_unitario AS unitario,
          tb_docpago_detalle.dpd_mnto_valor_venta AS monto,
          tb_docpago_detalle.dpd_esgratis as esgratis,
          tb_docpago.tipodoc_cod AS codtipodoc,
          tb_docpago.dcp_serie AS serie,
          tb_docpago.dcp_numero AS numero,
          tb_docpago.dcp_fecha_hora AS fecha,
          tb_docpago.pagante_cod AS codpagante,
          tb_docpago.dcp_pagante AS pagante,
          tb_docpago.dcp_estado AS estado,
          tb_deuda_individual.cod_gestion AS dcodgestion,
          tb_gestion1.gt_nombre AS dgestion,
          tb_deuda_individual.di_monto AS dmonto,
          tb_deuda_individual.di_fecha_vencimiento AS dvence,
          tb_deuda_individual.di_saldo AS dsaldo,
          tb_docpago.sede_id AS codsede,
          tb_sede.sed_nombre as sede,
          tb_sede.sed_abreviatura as sede_sigla
        FROM
          tb_docpago_detalle
          INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id)
          LEFT OUTER JOIN tb_matricula ON (tb_docpago_detalle.codmatricula = tb_matricula.mtr_id)
          LEFT OUTER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          LEFT OUTER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
          LEFT OUTER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
          LEFT OUTER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
          LEFT OUTER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
          LEFT OUTER JOIN tb_beneficio ON (tb_matricula.codigobeneficio = tb_beneficio.ben_id)
          INNER JOIN tb_gestion ON (tb_docpago_detalle.gestion_cod = tb_gestion.gt_codigo)
          LEFT OUTER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
          LEFT OUTER JOIN tb_deuda_individual ON (tb_docpago_detalle.deuda_cod = tb_deuda_individual.di_codigo)
          LEFT OUTER JOIN tb_gestion tb_gestion1 ON (tb_deuda_individual.cod_gestion = tb_gestion1.gt_codigo)
          INNER JOIN tb_sede ON (tb_docpago.sede_id = tb_sede.id_sede)
        $sqltext 
        ORDER BY
          tb_docpago.sede_id,tb_docpago.dcp_fecha_hora desc,tb_docpago_detalle.gestion_cod desc $limit_text", $data_array);
        return $resultmiembro->result();
  
  }


}