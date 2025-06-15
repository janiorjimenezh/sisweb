<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mgrupos_facturacion_reportes extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }



	public function m_todosLosPagosDeMatriculadosPorGrupo($data){
      // $sqltext_array=array();
      // $data_array=array();
     
      // if (isset($data['codsede']) and ($data['codsede']!="%")) {
      //     $sqltext_array[]="tb_matricula.codigosede = ?";
      //     $data_array[]=$data['codsede'];
      // }
      // if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
      //     $sqltext_array[]="tb_matricula.codigoperiodo = ?";
      //     $data_array[]=$data['codperiodo'];
      // }

      // $sqltext=implode(' AND ', $sqltext_array);
      // if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

      $resultmiembro = $this->db->query("SELECT 
        tb_matricula.mtr_id AS codigo,
        tb_matricula.codigoinscripcion AS codinscripcion,
        tb_inscripcion.ins_carnet AS carne,
        tb_matricula.mtr_apel_paterno AS paterno,
        tb_matricula.mtr_apel_materno AS materno,
        tb_matricula.mtr_nombres AS nombres,
        tb_matricula.codigoperiodo AS codperiodo,
        tb_periodo.ped_nombre AS periodo,
        tb_matricula.codigocarrera AS codcarrera,
        tb_carrera.car_sigla AS sigla,
        tb_matricula.codigociclo AS codciclo,
        tb_ciclo.cic_nombre AS ciclo,
        tb_matricula.codigoturno AS codturno,
        tb_matricula.codigoseccion AS codseccion,
        tb_matricula.codigoplan AS codplan,
        tb_matricula.codigosede AS codsede,
        tb_docpago.dcp_id as iddoc,
        tb_docpago.tipodoc_cod AS tipodoc,
        tb_docpago.dcp_serie AS serie,
        tb_docpago.dcp_numero AS numero,
        tb_sede.sed_nombre AS sede,
        tb_sede.sed_abreviatura AS sede_abrevia,
        tb_docpago.dcp_fecha_hora as fecha,
        tb_docpago_detalle.gestion_cod as codgestion,
        tb_docpago_detalle.dpd_gestion AS gestion,
        tb_docpago_detalle.dpd_mnto_precio_unit AS total
      FROM
        tb_docpago
        INNER JOIN tb_docpago_detalle ON (tb_docpago.dcp_id = tb_docpago_detalle.cod_docpago)
        INNER JOIN tb_matricula ON (tb_matricula.mtr_id = tb_docpago_detalle.codmatricula)
        INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
        INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
        INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
        INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
        INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)

      WHERE tb_matricula.codigosede=? and tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND 
              tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
            tb_matricula.codigoseccion LIKE ? 
      ORDER BY
        codsede,
        codperiodo,
        codcarrera,
        codciclo,
        codturno,
        codseccion,
        paterno,
        materno,
        nombres", $data);
      return $resultmiembro->result();
    }
}