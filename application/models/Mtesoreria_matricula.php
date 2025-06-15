<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mtesoreria_matricula extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function m_matricula_x_periodo_carnetes($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS alumno,
		  tb_persona.per_tipodoc AS tipodoc,
		  tb_persona.per_dni AS dni,
		  tb_periodo.ped_nombre AS periodo,
		  tb_carrera.car_nombre AS carrera,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_matricula.codigoturno as codturno,
		  tb_matricula.codigoseccion as codseccion
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		WHERE tb_inscripcion.ins_carnet=? AND tb_periodo.ped_codigo=? LIMIT 1", $data);
        ////$this->db->close();
        return $resultmiembro->row();
    }

	public function m_pagos_xcarne($data)
    {
        $qry = $this->db->query("SELECT 
			  tb_docpago.dcp_id AS codigo,
			  tb_docpago.dcp_serie AS serie,
			  tb_docpago.dcp_numero AS numero,
			  tb_docpago.dcp_fecha_hora AS fecha_hora,
			  tb_docpago.pagante_cod AS codpagante,
			  tb_docpago.dcp_pagante AS pagante,
			  tb_docpago.tipodoc_cod AS tipodoc,
			  tb_docpago.dcp_estado AS estado,
			  tb_docpago.dcp_total AS total,
			  tb_docpago.sede_id AS sede,
			  tb_docpago.dcp_mnto_igv AS migv,
			  tb_docpago_sunat.dcps_aceptado AS s_aceptado,
			  tb_docpago_sunat.dcps_snt_descripcion AS s_descripcion,
			  tb_docpago_sunat.dcps_snt_note AS s_note,
			  tb_docpago_sunat.dcps_snt_responsecode AS s_response,
			  tb_docpago_sunat.dcps_snt_soap_error AS s_soap,
			  tb_docpago_sunat.dcps_snt_enlace_xml AS enl_xml,
			  tb_docpago_sunat.dcps_snt_enlace_cdr AS enl_cdr,
			  tb_docpago_sunat.dcps_snt_enlace_pdf AS enl_pdf,
			  tb_docpago_sunat.dcps_error_cod AS error_cod,
			  tb_docpago_sunat.dcps_error_desc AS error_desc,
			  tb_docpago.dcp_anulacion_motivo AS anul_motivo,
			  tb_docpago.dcp_fecha_anulacion AS anul_fecha
			FROM
			  tb_docpago_sunat
			  RIGHT OUTER JOIN tb_docpago ON (tb_docpago_sunat.dcps_id = tb_docpago.dcp_id)
          	WHERE  tb_docpago.pagante_tipodoc = ? AND tb_docpago.pagante_nrodoc = ? AND tb_docpago.dcp_estado='ACEPTADO' 
          	ORDER BY
             tb_docpago.dcp_serie,tb_docpago.dcp_numero DESC ", $data);
        
        return $qry->result();
        
    }

    public function m_pagos_detalle_xcarne($data)
    {
        $qry = $this->db->query("SELECT 
			  tb_docpago.dcp_id AS codpago,
			  tb_docpago.dcp_serie AS serie,
			  tb_docpago.dcp_numero AS numero,
			  tb_docpago_detalle.cod_docpago as iddoc,
			  tb_docpago_detalle.dpd_gestion as gestion,
			  tb_docpago_detalle.dpd_cantidad as cantidad,
			  tb_docpago_detalle.dpd_mnto_igv as migv,
			  tb_docpago_detalle.dpd_mnto_precio_unit as mpunit
			FROM
			  tb_docpago_detalle
			  INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id)
          	WHERE  tb_docpago.pagante_tipodoc = ? AND tb_docpago.pagante_nrodoc = ? AND tb_docpago.dcp_estado='ACEPTADO' 
          	ORDER BY
             tb_docpago.dcp_serie,tb_docpago.dcp_numero DESC ", $data);
        
        return $qry->result();
        
    }

    public function mFiltrarMatriculadosXGrupo($data)
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
	    if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
	        $sqltext_array[]="tb_matricula.codigociclo = ?";
	        $data_array[]=$data['codciclo'];
	    }
	    if (isset($data['codturno']) and ($data['codturno']!="%")) {
	        $sqltext_array[]="tb_matricula.codigoturno = ?";
	        $data_array[]=$data['codturno'];
	    }
	    if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
	        $sqltext_array[]="tb_matricula.codigoseccion = ?";
	        $data_array[]=$data['codseccion'];
	    }
	    if (isset($data['codestado']) and ($data['codestado']!="%")) {
	        $sqltext_array[]="tb_matricula.codigoestado = ?";
	        $data_array[]=$data['codestado'];
	    }
	    if (isset($data['codbeneficio']) and ($data['codbeneficio']!="%")) {
	        $sqltext_array[]="tb_matricula.codigobeneficio = ?";
	        $data_array[]=$data['codbeneficio'];
	    }
	    
	    $sqltext=implode(' AND ', $sqltext_array);
	    if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

      	$resultmiembro = $this->db->query("SELECT 
			  tb_matricula.mtr_id AS codmatricula,
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
			  tb_estadoalumno.esal_nombre AS estado,
			  tb_persona.per_celular AS celular1,
			  tb_persona.per_celular2 AS celular2,
			  tb_persona.per_telefono AS telefono,
			  tb_matricula.codigosede AS codsede,
			  tb_sede.sed_nombre AS sede,
			  tb_sede.sed_abreviatura AS sede_abrevia,
			  tb_persona.per_sexo AS codsexo,
			  tb_plan_estudios.pln_nombre AS plan,
			  tb_usuario.id_usuario as userid,
			  tb_usuario.usu_activo as estadouser,
			  SUM(tb_deuda_individual.di_saldo) AS deuda
			FROM
			  tb_periodo
			  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
			  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
			  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
			  INNER JOIN tb_plan_estudios ON (tb_matricula.codigoplan = tb_plan_estudios.pln_id)
			  INNER JOIN tb_usuario ON (tb_inscripcion.ins_identificador = tb_usuario.usu_codente)
			  INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
			$sqltext  
			GROUP BY tb_matricula.mtr_id,
				  tb_matricula.codigoinscripcion,
				  tb_inscripcion.ins_carnet,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres,
				  tb_matricula.codigoperiodo,
				  tb_periodo.ped_nombre,
				  tb_matricula.codigocarrera,
				  tb_carrera.car_nombre,
				  tb_carrera.car_sigla,
				  tb_matricula.codigociclo,
				  tb_ciclo.cic_nombre,
				  tb_matricula.codigoturno,
				  tb_matricula.codigoseccion,
				  tb_matricula.codigoplan,
				  tb_plan_estudios.pln_nombre,
				  tb_matricula.mtr_bloquear_evaluaciones,
				  tb_estadoalumno.esal_nombre,
				  tb_persona.per_celular,
				  tb_persona.per_celular2,
				  tb_persona.per_telefono,
				  tb_matricula.codigosede,
				  tb_sede.sed_nombre,
				  tb_sede.sed_abreviatura,
				  tb_persona.per_sexo,
				  tb_usuario.id_usuario,
				  tb_usuario.usu_activo
				ORDER BY
				  tb_matricula.codigoperiodo,
				  tb_matricula.codigocarrera,
				  tb_matricula.codigoplan,
				  tb_matricula.codigociclo,
				  tb_matricula.codigoturno,
				  tb_matricula.codigoseccion,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres", $data_array);
        return $resultmiembro->result();
    }

    public function mGetEstudianteEstadistica($data)
    {
    	$resultados= array('pagos' =>  array() );
        $qry = $this->db->query("SELECT 
				  tb_docpago.dcp_id AS codpago,
				  tb_docpago.dcp_serie AS serie,
				  tb_docpago.dcp_numero AS numero,
				  tb_docpago_detalle.cod_docpago AS iddoc,
				  tb_docpago_detalle.dpd_gestion AS gestion,
				  tb_docpago_detalle.dpd_cantidad AS cantidad,
				  tb_docpago_detalle.dpd_mnto_igv AS migv,
				  tb_docpago_detalle.dpd_mnto_precio_unit AS mpunit,
				  tb_docpago.dcp_fecha_hora as fechahora,
				  tb_docpago.tipodoc_cod as codtipodoc,
				  tb_docpago.pagante_cod as codpagante,
				  tb_docpago.dcp_pagante as pagante
				FROM
			  tb_docpago_detalle
			  INNER JOIN tb_docpago ON (tb_docpago_detalle.cod_docpago = tb_docpago.dcp_id)
          	WHERE  tb_docpago.pagante_tipodoc = ? AND tb_docpago.pagante_nrodoc = ? AND tb_docpago.dcp_estado='ACEPTADO' 
          	ORDER BY
             tb_docpago.dcp_serie,tb_docpago.dcp_numero DESC ", $data);
        $resultados["pagos"]=$qry->result();
        return $resultados;
        
    }

    public function mFiltrarDeudasMatriculadosXGrupo($data)
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
	    if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
	        $sqltext_array[]="tb_matricula.codigociclo = ?";
	        $data_array[]=$data['codciclo'];
	    }
	    if (isset($data['codturno']) and ($data['codturno']!="%")) {
	        $sqltext_array[]="tb_matricula.codigoturno = ?";
	        $data_array[]=$data['codturno'];
	    }
	    if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
	        $sqltext_array[]="tb_matricula.codigoseccion = ?";
	        $data_array[]=$data['codseccion'];
	    }
	    if (isset($data['codestado']) and ($data['codestado']!="%")) {
	        $sqltext_array[]="tb_matricula.codigoestado = ?";
	        $data_array[]=$data['codestado'];
	    }
	    if (isset($data['codbeneficio']) and ($data['codbeneficio']!="%")) {
	        $sqltext_array[]="tb_matricula.codigobeneficio = ?";
	        $data_array[]=$data['codbeneficio'];
	    }

	    $sqltext_array[]="tb_deuda_individual.di_saldo > 0";
	    $sqltext_array[]="tb_deuda_individual.di_estado = 'ACTIVO'";
	    
	    $sqltext=implode(' AND ', $sqltext_array);
	    if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

      	$resultmiembro = $this->db->query("SELECT 
			  tb_matricula.mtr_id AS codmatricula,
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
			  substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
			  sum(case when tb_deuda_individual.di_fecha_vencimiento < CURDATE() then 1 else 0 end) as ndeudas,
			  tb_persona.per_celular AS celular1,
			  tb_persona.per_celular2 AS celular2,
			  tb_persona.per_telefono AS telefono,
			  tb_matricula.codigosede AS codsede,
			  tb_sede.sed_nombre AS sede,
			  tb_sede.sed_abreviatura AS sede_abrevia,
			  tb_persona.per_sexo AS codsexo,
			  tb_plan_estudios.pln_nombre AS plan
			FROM
			  tb_periodo
			  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
			  INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
			  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
			  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
			  INNER JOIN tb_plan_estudios ON (tb_matricula.codigoplan = tb_plan_estudios.pln_id)

			$sqltext  
			GROUP BY
			tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres, tb_deuda_individual.matricula_cod
			ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres, tb_deuda_individual.matricula_cod
			", $data_array);
        return $resultmiembro->result();
    }

}