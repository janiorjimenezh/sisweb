<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmatricula extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	

	public function m_insert($items)
	{
		$this->db->query("CALL sp_tb_matricula_insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nc)",$items);
		$res = $this->db->query('select @s as rs,@nc as newcod');
 		return   $res->row();	
	}

  public function m_updateMatricula($id,$data)
  {  
    $this->db->where('mtr_id', $id);
    $rs=$this->db->update('tb_matricula', $data);
    $rp = new stdClass;
    $rp->newcod=$id;
    $rp->countRows=$this->db->affected_rows();
    $rp->rs=($rp->countRows==0) ? 0 : 1;
    return $rp;

   //$res = $this->db->query('select @s as rs,@nc as ');
  }

	public function m_cambiar_estado($items)
	{
		//CALL ( @vniv_codigo, @vniv_estado, @s);
		$this->db->query("CALL sp_tb_matricula_update_estado(?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
 		return   $res->row()->out_param;	
	}


	public function m_cambiar_estado_condicional($items)
	{
		$this->db->query("CALL sp_tb_matricula_update_condicional(?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
 		return   $res->row()->out_param;	
	}

	public function m_cambiar_plan_economico($items)
	{
		//CALL ( @vniv_codigo, @vniv_estado, @s);
		$this->db->query("CALL sp_tb_matricula_update_plan_economico(?,?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
 		return   $res->row()->out_param;	
	}

	

	public function m_update_culminar_grupo($data)
  {
  	$this->db->query("CALL sp_tb_matricula_update_culminar(?,?,@s,@nid)", $data);
    	$res = $this->db->query('select @s as salida,@nid as newcod');
    	return $res->row();
  }

	public function m_eliminar($items)
	{
		//CALL ( @vniv_codigo, @vniv_estado, @s);
		$this->db->query("CALL sp_tb_matricula_delete(?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
 		return   $res->row()->out_param;	
	}

	/*public function m_get_estado_alumno()
	{
      $result = $this->db->query("SELECT 
          tb_estadoalumno.esal_id AS id,
          tb_estadoalumno.esal_nombre AS nombre
        FROM
          tb_estadoalumno");
      return   $result->result();
 	}*/

 	 public function m_filtrar_estadoalumno()
    {
    	$resultmiembro = $this->db->query("SELECT 
		  tb_estadoalumno.esal_id AS codigo,
		  tb_estadoalumno.esal_nombre AS nombre
		FROM
		  tb_estadoalumno");
    	return $resultmiembro->result();
    }

 	public function m_getMatriculas($data)
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
      if (isset($data['buscar']) and ($data['buscar']!='%%')) {
        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
        $data_array[]=$data['buscar'];
      }
      if (isset($data['codbeneficio']) and ($data['codbeneficio']!="%")) {
        $sqltext_array[]="tb_matricula.codigobeneficio = ?";
        $data_array[]=$data['codbeneficio'];
      } 
      if (isset($data['codestado']) and ($data['codestado']!="%")) {
        $sqltext_array[]="tb_matricula.codigoestado = ?";
        $data_array[]=$data['codestado'];
      } 
      if (isset($data['carnet']) and ($data['carnet']!="%")) {
        $sqltext_array[]="tb_inscripcion.ins_carnet=?";
        $data_array[]=$data['carnet'];
      }
      if (isset($data['codinscripcion']) and ($data['codinscripcion']!="%")) {
        $sqltext_array[]="tb_matricula.codigoinscripcion=?";
        $data_array[]=$data['codinscripcion'];
      }
       if (isset($data['codmatricula']) and ($data['codmatricula']!="%")) {
        $sqltext_array[]="tb_matricula.mtr_id=?";
        $data_array[]=$data['codmatricula'];
      }
      if (isset($data['fecha'])) {
        if (count($data['fecha'])>0){
          $sqltext_array[]="tb_matricula.mtr_fecha BETWEEN ? AND ? ";
          $data_array[]=$data['fecha'][0];
          $data_array[]=$data['fecha'][1];

        }
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
					  tb_persona.per_foto AS foto,
					  tb_persona.per_codigo AS idpersona,
					  tb_matricula.codigoperiodo AS codperiodo,
					  tb_periodo.ped_nombre AS periodo,
					  tb_matricula.codigocarrera AS codcarrera,
					  tb_carrera.car_nombre AS carrera,
					  tb_carrera.car_sigla AS sigla,
					  tb_carrera.car_abreviatura AS carabrevia,
					  tb_matricula.codigociclo AS codciclo,
					  tb_ciclo.cic_nombre AS ciclo,
					  tb_matricula.codigoturno AS codturno,
					  tb_turno.tur_nombre AS turno,
					  tb_matricula.codigoseccion AS codseccion,
					  tb_seccion.sec_nombre AS seccion,
					  tb_matricula.codigoplan AS codplan,
					  tb_plan_estudios.pln_nombre AS plan,
					  tb_matricula.mt_tipo AS tipo,
					  tb_matricula.mtr_bloquear_evaluaciones AS bloqueo,
					  tb_matricula.codigoestado AS codestado,
					  substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
					  tb_estadoalumno.esal_nombre AS matriculaestado,
					  tb_persona.per_celular AS celular1,
					  tb_persona.per_celular2 AS celular2,
					  tb_persona.per_telefono AS telefono,
					  tb_matricula.codigosede AS codsede,
					  tb_matricula.mtr_fecha AS fecregistro,
					  tb_sede.sed_nombre AS sede,
					  tb_sede.sed_abreviatura AS sede_abrevia,
					  tb_persona.per_sexo AS codsexo,
					  tb_persona.per_fecha_nacimiento AS fechanac,
					  CONCAT(tb_personaus.per_apel_paterno, ' ', tb_personaus.per_apel_materno, ' ', tb_personaus.per_nombres) AS usuario,
					  tb_matricula.mtr_cuotapension AS pension,
					  tb_matricula.mtr_cuotapension_real AS pensionreal,
					  tb_matricula.mtr_mat_condicional AS condicional,
					  tb_matricula.mtr_observacion AS observacion,
					  tb_beneficio.ben_sigla AS beneficio,
					  tbv_deuda_calendario_grupo.cod_deuda_calendario AS codcalendario,
					  tbv_deuda_calendario_grupo.dc_nombre AS calendario
					FROM
					  tb_periodo
					  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
					  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
					  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
					  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
					  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
					  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
					  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
					  LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula.codigoplan = tb_plan_estudios.pln_id)
					  LEFT OUTER JOIN tb_usuario ON (tb_matricula.usuario_id = tb_usuario.id_usuario)
					  LEFT OUTER JOIN tb_persona tb_personaus ON (tb_usuario.cod_persona = tb_personaus.per_codigo)
					  INNER JOIN tb_beneficio ON (tb_matricula.codigobeneficio = tb_beneficio.ben_id)
					  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
					  INNER JOIN tb_seccion ON (tb_matricula.codigoseccion = tb_seccion.sec_codigo)
					  LEFT OUTER JOIN tbv_deuda_calendario_grupo ON (tb_matricula.codigoperiodo = tbv_deuda_calendario_grupo.codigoperiodo)
					  AND (tb_matricula.codigocarrera = tbv_deuda_calendario_grupo.codigocarrera)
					  AND (tb_matricula.codigociclo = tbv_deuda_calendario_grupo.codigociclo)
					  AND (tb_matricula.codigoturno = tbv_deuda_calendario_grupo.codigoturno)
					  AND (tb_matricula.codigoseccion = tbv_deuda_calendario_grupo.codigoseccion)
					  AND (tb_matricula.codigosede = tbv_deuda_calendario_grupo.cod_sede)
					$sqltext 
					ORDER BY
					  tb_matricula.codigoperiodo,
					  tb_matricula.codigocarrera,
					  tb_matricula.codigociclo,
					  tb_matricula.codigoplan,
					  tb_matricula.codigoturno,
					  tb_matricula.codigoseccion,
					  tb_persona.per_apel_paterno,
					  tb_persona.per_apel_materno,
					  tb_persona.per_nombres", $data_array);
	        ////$this->db->close();
	        return $resultmiembro->result();
	  }

 	public function m_filtrar_xgrupo($data)
    {
    	$codsede=$_SESSION['userActivo']->idsede;
      $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
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
		  tb_matricula.mtr_cuotapension AS cuota,
		  tb_matricula.codigobeneficio AS codbeneficio,
		  tb_beneficio.ben_sigla AS bene_sigla
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
		  INNER JOIN tb_beneficio ON (tb_matricula.codigobeneficio = tb_beneficio.ben_id)
		WHERE 
		  tb_matricula.codigosede = $codsede AND tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND 
  		  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
		  tb_matricula.codigoseccion LIKE ?  
		ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

		public function m_filtrar($data)
	    {

	    	$sqltext_array=array();
	      $data_array=array();
	      if ($data[0]!="%") {
	        $sqltext_array[]="tb_matricula.codigosede = ?";
	        $data_array[]=$data[0];
	      } 
	      if ($data[1]!="%") {
	        $sqltext_array[]="tb_matricula.codigoperiodo = ?";
	        $data_array[]=$data[1];
	      } 
	      if ($data[2]!="%")  {
	        $sqltext_array[]="tb_matricula.codigocarrera = ?";
	        $data_array[]=$data[2];
	      }
	      if ($data[3]!="%")  {
	        $sqltext_array[]="tb_matricula.codigoplan = ?";
	        $data_array[]=$data[3];
	      }
	      if ($data[4]!="%")  {
	        $sqltext_array[]="tb_matricula.codigociclo = ?";
	        $data_array[]=$data[4];
	      }
	      if ($data[5]!="%")  {
	        $sqltext_array[]="tb_matricula.codigoturno = ?";
	        $data_array[]=$data[5];
	      }
	      if ($data[6]!="%")  {
	        $sqltext_array[]="tb_matricula.codigoseccion = ?";
	        $data_array[]=$data[6];
	      }
	      if ($data[7]!="%")  {
	        $sqltext_array[]="tb_matricula.codigoestado = ?";
	        $data_array[]=$data[7];
	      }
	      if ($data[8]!="%")  {
	        $sqltext_array[]="tb_matricula.codigobeneficio = ?";
	        $data_array[]=$data[8];
	      }
	      if ($data[9]!="%%")  {
	        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
	        $data_array[]=$data[9];
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
					  tb_persona.per_foto AS foto,
					  tb_persona.per_codigo AS idpersona,
					  tb_matricula.codigoperiodo AS codperiodo,
					  tb_periodo.ped_nombre AS periodo,
					  tb_matricula.codigocarrera AS codcarrera,
					  tb_carrera.car_nombre AS carrera,
					  tb_carrera.car_sigla AS sigla,
					  tb_carrera.car_abreviatura AS carabrevia,
					  tb_matricula.codigociclo AS codciclo,
					  tb_ciclo.cic_nombre AS ciclo,
					  tb_matricula.codigoturno AS codturno,
					  tb_matricula.codigoseccion AS codseccion,
					  tb_matricula.codigoplan AS codplan,
					  tb_matricula.mtr_bloquear_evaluaciones AS bloqueo,
					  substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
					  tb_persona.per_celular AS celular1,
					  tb_persona.per_celular2 AS celular2,
					  tb_persona.per_telefono AS telefono,
					  tb_matricula.codigosede AS codsede,
					  tb_matricula.mtr_fecha AS fecregistro,
					  tb_sede.sed_nombre AS sede,
					  tb_sede.sed_abreviatura AS sede_abrevia,
					  tb_persona.per_sexo AS codsexo,
					  tb_persona.per_fecha_nacimiento AS fechanac,
					  tb_plan_estudios.pln_nombre AS plan,
					  CONCAT(tb_personaus.per_apel_paterno,' ',tb_personaus.per_apel_materno,' ',tb_personaus.per_nombres) as usuario,
					  tb_matricula.mtr_cuotapension as pension,
					  tb_matricula.mtr_cuotapension_real as pensionreal,
					  tb_matricula.mtr_mat_condicional as condicional,
					  tb_matricula.mtr_observacion as observacion,
					  tb_beneficio.ben_sigla as beneficio,
	  				tb_turno.tur_nombre as turno,
					  tb_seccion.sec_nombre as seccion
					FROM
					  tb_periodo
					  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
					  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
					  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
					  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
					  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
					  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
					  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
					  LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula.codigoplan = tb_plan_estudios.pln_id)
					  LEFT OUTER JOIN tb_usuario ON (tb_matricula.usuario_id = tb_usuario.id_usuario)
					  LEFT OUTER JOIN tb_persona tb_personaus ON (tb_usuario.cod_persona = tb_personaus.per_codigo)
					  INNER JOIN tb_beneficio ON (tb_matricula.codigobeneficio = tb_beneficio.ben_id)
					  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
					  INNER JOIN tb_seccion ON (tb_matricula.codigoseccion = tb_seccion.sec_codigo)
					$sqltext  
					ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigociclo,tb_matricula.codigoplan,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data_array);
	        ////$this->db->close();
	        return $resultmiembro->result();
	  }

  	public function m_filtrar_bloqueos($data)
    {

    	$sqltext_array=array();
      $data_array=array();
      if ($data[0]!="%") {
        $sqltext_array[]="tb_matricula.codigosede = ?";
        $data_array[]=$data[0];
      } 
      if ($data[1]!="%") {
        $sqltext_array[]="tb_matricula.codigoperiodo = ?";
        $data_array[]=$data[1];
      } 
      if ($data[2]!="%")  {
        $sqltext_array[]="tb_matricula.codigocarrera = ?";
        $data_array[]=$data[2];
      }
      if ($data[3]!="%")  {
        $sqltext_array[]="tb_matricula.codigoplan = ?";
        $data_array[]=$data[3];
      }
      if ($data[4]!="%")  {
        $sqltext_array[]="tb_matricula.codigociclo = ?";
        $data_array[]=$data[4];
      }
      if ($data[5]!="%")  {
        $sqltext_array[]="tb_matricula.codigoturno = ?";
        $data_array[]=$data[5];
      }
      if ($data[6]!="%")  {
        $sqltext_array[]="tb_matricula.codigoseccion = ?";
        $data_array[]=$data[6];
      }
      if ($data[7]!="%")  {
        $sqltext_array[]="tb_matricula.codigoestado = ?";
        $data_array[]=$data[7];
      }
      if ($data[8]!="%")  {
        $sqltext_array[]="tb_matricula.codigobeneficio = ?";
        $data_array[]=$data[8];
      }
      if ($data[9]!="%%")  {
        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
        $data_array[]=$data[9];
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
				  substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
				  tb_persona.per_celular AS celular1,
				  tb_persona.per_celular2 AS celular2,
				  tb_persona.per_telefono AS telefono,
				  tb_matricula.codigosede AS codsede,
				  tb_sede.sed_nombre AS sede,
				  tb_sede.sed_abreviatura AS sede_abrevia,
				  tb_persona.per_sexo AS codsexo,
				  tb_plan_estudios.pln_nombre AS plan,
				  tb_usuario.id_usuario as userid,
				  		   tb_usuario.usu_activo as estadouser
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
				$sqltext  
				ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data_array);
        ////$this->db->close();
        return $resultmiembro->result();
  }
    public function m_matriculas_total_carga_filiales($data,$sedes)
    {
    	//SUM(CASE WHEN tb_carga_academica.cod_sede=1 THEN 1 ELSE 0 END ) AS SEDE1
    	$sql_sedes="";
    	foreach ($sedes as $key => $sede) {
    		$idsede=$sede->id;
    		$sql_sedes=$sql_sedes." , SUM(CASE WHEN tb_carga_academica.cod_sede=$idsede AND tb_carga_academica.cac_activo = 'SI'  THEN 1 ELSE 0 END ) AS s".$idsede;
    	}

      $resultmiembro = $this->db->query("SELECT 
					  tb_inscripcion.ins_carnet AS carne,
					  tb_persona.per_apel_paterno AS paterno,
					  tb_persona.per_apel_materno AS materno,
					  tb_persona.per_nombres AS nombres,
					  tb_periodo.ped_nombre AS periodo,
					  tb_carrera.car_nombre AS carrera,
					  tb_ciclo.cic_nombre AS ciclo,
					  tb_turno.tur_nombre AS turno,
					  tb_matricula.codigoseccion AS seccion,
					  tb_matricula.codigoperiodo as codperiodo,
					  tb_matricula.codigocarrera as codcarrera,
					  tb_matricula.codigoplan as codplan,
					  tb_matricula.codigociclo as codciclo,
					  tb_matricula.codigoturno as codturno,
					  tb_matricula.codigoseccion as codseccion,
					  tb_estadoalumno.esal_nombre AS estado,
					  SUM(CASE WHEN tb_carga_academica.cac_activo = 'SI' THEN 1 ELSE 0 END) AS ncursos 
					  $sql_sedes 
					FROM
					  tb_matricula
					  LEFT OUTER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
					  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
					  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
					  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
					  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
					  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
					  LEFT OUTER JOIN tb_carga_academica ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica.cac_id)
					  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
					  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)

					WHERE
  					tb_matricula.codigosede = ? AND 
		  			tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan like ? AND 
  		  		tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND   tb_matricula.codigoseccion LIKE ? AND  tb_matricula.codigoestado like ? AND 
		  			concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? AND (tb_carga_subseccion_miembros.csm_eliminado IS NULL OR tb_carga_subseccion_miembros.csm_eliminado='NO')
					GROUP BY
					  tb_inscripcion.ins_carnet,
					  tb_persona.per_apel_paterno,
					  tb_persona.per_apel_materno,
					  tb_persona.per_nombres,
					  tb_periodo.ped_nombre,
					  tb_carrera.car_nombre,
					  tb_ciclo.cic_nombre,
					  tb_turno.tur_nombre,
					  tb_matricula.codigoperiodo,
					  tb_matricula.codigocarrera,
					  tb_matricula.codigoplan,
					  tb_matricula.codigociclo,
					  tb_matricula.codigoturno,
					  tb_matricula.codigoseccion,
					  tb_estadoalumno.esal_nombre
					ORDER BY
					  tb_matricula.codigoperiodo,
					  tb_matricula.codigocarrera,
					  tb_matricula.codigoplan,
					  tb_matricula.codigociclo,
					  tb_matricula.codigoturno,
					  tb_matricula.codigoseccion,
					  tb_persona.per_apel_paterno,
					  tb_persona.per_apel_materno,
					  tb_persona.per_nombres", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

    public function m_filtrar_con_estadistica_cursos_xgrupo($data)
    {
    	$rs=array();
    	$sqltext_estado="";
    	$codsede=$_SESSION['userActivo']->idsede;
      if (count($data)==8)  $sqltext_estado=" AND tb_matricula.codigoestado like ? ";
      $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_matricula.codigoperiodo as codperiodo,
		  tb_periodo.ped_nombre AS periodo,
		  tb_matricula.codigocarrera as codcarrera,
		  tb_carrera.car_nombre AS carrera,
		  tb_carrera.car_sigla as sigla,
		  tb_matricula.codigociclo as codciclo,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_matricula.codigoturno AS codturno,
		  tb_matricula.codigoseccion AS codseccion,
		  tb_matricula.codigoplan as codplan,
		  tb_matricula.mtr_bloquear_evaluaciones as bloqueo,
		  substr(tb_estadoalumno.esal_nombre,1,3) AS estado,
		   tb_persona.per_celular as celular1,
		   tb_persona.per_celular2 as celular2,
  		   tb_persona.per_telefono as telefono
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
		WHERE 
		  tb_matricula.codigosede = $codsede AND tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan like ? AND 
  		  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
		  tb_matricula.codigoseccion LIKE ? AND 
		  concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? $sqltext_estado 
		ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data);
        ////$this->db->close();
        $rs['matriculas']=$resultmiembro->result();

         $resultestadistica = $this->db->query("SELECT 
				  tb_matricula.mtr_id AS codmat,
				  tb_matricula.codigoinscripcion AS codinscripcion,
				  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'APR' THEN 1 ELSE 0 END)) AS aprobados,
				  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'DES' THEN 1 ELSE 0 END)) AS desaprobados,
				  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'DPI' THEN 1 ELSE 0 END)) AS dpi,
				  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'NSP' THEN 1 ELSE 0 END)) AS nsp
				FROM
				  tb_matricula
				  LEFT OUTER JOIN tb_matricula_cursos_nota_final ON (tb_matricula.mtr_id = tb_matricula_cursos_nota_final.mtr_id)
				  INNER JOIN tb_inscripcion ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
				  INNER JOIN tb_persona ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
				WHERE 
				  tb_matricula.codigosede = $codsede AND tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan like ? AND 
		  		  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
				  tb_matricula.codigoseccion LIKE ? AND 
				  concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? $sqltext_estado 

				GROUP BY
				  tb_matricula.mtr_id,
				  tb_matricula.codigoinscripcion
				ORDER BY
				  tb_matricula.codigoperiodo DESC,
				  tb_matricula.codigocarrera,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres",$data);
         $rs['estadistica']=$resultestadistica->result();
         return $rs;

    }

    public function m_matriculados_con_estadistica_cursos_xgrupo($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
  				tb_matricula.mtr_id AS codigo,
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
				  tb_matricula.mtr_bloquear_evaluaciones AS bloqueo,
				  tb_persona.per_celular AS celular1,
				  tb_persona.per_celular2 AS celular2,
				  tb_persona.per_telefono as telefono,
				   tb_matricula.mtr_cuotapension AS pension,
				  tb_matricula.codigoestado AS codestado,
				  tb_estadoalumno.esal_nombre AS estado,
				  tb_matricula.mtr_fecha AS fecha,
				  tb_matricula.mtr_observacion AS obs,
				  tb_matricula.codigoplan AS codplan,
				  tb_plan_estudios.pln_nombre AS plan,
				  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'APR' THEN 1 ELSE 0 END)) AS aprobados,
				  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'DES' THEN 1 ELSE 0 END)) AS desaprobados,
				  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'DPI' THEN 1 ELSE 0 END)) AS dpi,
				  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'NSP' THEN 1 ELSE 0 END)) AS nsp
				FROM
				  tb_carrera
				  INNER JOIN tb_matricula ON (tb_carrera.car_id = tb_matricula.codigocarrera)
				  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
				  LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula.codigoplan = tb_plan_estudios.pln_id)
				  LEFT OUTER JOIN tb_matricula_cursos_nota_final ON (tb_matricula.mtr_id = tb_matricula_cursos_nota_final.mtr_id)
				  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
				  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
				  INNER JOIN tb_inscripcion ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
				  INNER JOIN tb_persona ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
				WHERE
				   tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan like ? AND 
				  		  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
						  tb_matricula.codigoseccion LIKE ?
				GROUP BY
				  tb_matricula.mtr_id,
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
				  tb_matricula.mtr_bloquear_evaluaciones,
				  tb_persona.per_celular,
				  tb_persona.per_celular2,
				  pension,
				  tb_matricula.codigoestado,
				  tb_estadoalumno.esal_nombre,
				  tb_matricula.mtr_fecha,
				  tb_matricula.mtr_observacion,
				  tb_matricula.codigoplan,
				  tb_matricula.codigoplan,
				  tb_plan_estudios.pln_nombre
				ORDER BY
				  tb_matricula.codigoperiodo DESC,tb_matricula.codigocarrera,tb_persona.per_apel_paterno, tb_persona.per_apel_materno ,tb_persona.per_nombres", $data);
        ////$this->db->close();


        return $resultmiembro->result();
    }


	public function m_filtrar_cur_ad($data)
    {
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
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
		  tb_inscripcion.id_plan AS codplan,
		  substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
		  COUNT(tb_carga_subseccion_miembros.csm_id) AS cursos,
		  sum(case when tb_carga_subseccion_miembros.csm_estado='DES' THEN 1 else 0 end) AS DES,
		  sum(case when tb_carga_subseccion_miembros.csm_estado='APR' THEN 1 else 0 end) AS APR,
		  sum(case when tb_carga_subseccion_miembros.csm_estado='DPI' THEN 1 else 0 end) AS DPI,
		  sum(case when tb_carga_subseccion_miembros.csm_estado='NSP' THEN 1 else 0 end) AS NSP
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
		  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
		WHERE 
		  tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND
			  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
		  tb_matricula.codigoseccion LIKE ? AND 
		  concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? AND tb_carga_subseccion_miembros.csm_eliminado = 'NO' 
		GROUP BY
		  tb_matricula.mtr_id,
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
		  tb_inscripcion.id_plan,
		  substr(tb_estadoalumno.esal_nombre, 1, 3)", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

     /*public function m_miscursos_x_matricula($data)
    {

        //////$this->load->database();
		  $resultdoce = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_periodo.ped_nombre AS periodo,
			  tb_carrera.car_sigla AS sigla,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_turno.tur_nombre AS turno,
			  tb_seccion.sec_nombre AS seccion,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_unidad_didactica.undd_nombre AS curso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_subseccion_miembros.csm_nota_final AS nota,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  'miembro-alumno' AS miembro,
			  tb_carga_subseccion_miembros.cod_matricula AS matricula,
			  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
			  tb_carga_subseccion_miembros.csm_estado AS dpi,
			  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
			  concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS docente
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
			  INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
			  INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_seccion ON (tb_carga_academica.codigoseccion = tb_seccion.sec_codigo)
			  LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
			  LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
			WHERE
			  tb_carga_subseccion_miembros.cod_matricula = ? AND 
			  tb_carga_subseccion_miembros.csm_eliminado = 'NO'", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }*/

    public function m_matrciulas_x_carnet($data){

    	 $resultdoce = $this->db->query("SELECT 
  			tb_matricula.mtr_id AS codmatricula,
			  tb_matricula.codigoperiodo AS codperiodo,
			  tb_periodo.ped_nombre AS periodo,
			  tb_matricula.codigocarrera AS codcarrera,
			  tb_carrera.car_nombre AS carrera,
			  tb_carrera.car_sigla AS sigla,
			  tb_matricula.codigociclo AS codciclo,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_matricula.codigoturno AS codturno,
			  tb_matricula.codigoseccion AS codseccion,
			  tb_matricula.mtr_cuotapension AS pension,
			  tb_matricula.codigoestado AS codestado,
			  tb_estadoalumno.esal_nombre AS estado,
			  tb_matricula.mtr_fecha AS fecha,
			  tb_matricula.mtr_observacion AS obs,
			  tb_matricula.codigoplan AS codplan,
			  tb_plan_estudios.pln_nombre AS plan,
			  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'APR' THEN 1 ELSE 0 END)) AS aprobados,
			  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'DES' THEN 1 ELSE 0 END)) AS desaprobados,
			  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'DPI' THEN 1 ELSE 0 END)) AS dpi,
			  SUM((CASE WHEN tb_matricula_cursos_nota_final.mtcf_estado = 'NSP' THEN 1 ELSE 0 END)) AS nsp
			FROM
			  tb_carrera
			  INNER JOIN tb_matricula ON (tb_carrera.car_id = tb_matricula.codigocarrera)
			  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
			  LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula.codigoplan = tb_plan_estudios.pln_id)
			  LEFT OUTER JOIN tb_matricula_cursos_nota_final ON (tb_matricula.mtr_id = tb_matricula_cursos_nota_final.mtr_id)
			  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
			  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
			WHERE
			  tb_matricula.codigoinscripcion = ?
			GROUP BY
			  tb_matricula.mtr_id,
			  tb_matricula.codigoperiodo,
			  tb_periodo.ped_nombre,
			  tb_matricula.codigocarrera,
			  tb_carrera.car_nombre,
			  tb_carrera.car_sigla,
			  tb_matricula.codigociclo,
			  tb_ciclo.cic_nombre,
			  tb_matricula.codigoturno,
			  tb_matricula.codigoseccion,
			  tb_matricula.mtr_cuotapension,
			  tb_matricula.codigoestado,
			  tb_estadoalumno.esal_nombre,
			  tb_matricula.mtr_fecha,
			  tb_matricula.mtr_observacion,
			  tb_matricula.codigoplan,
			  tb_plan_estudios.pln_nombre
			ORDER BY
			  tb_matricula.codigoperiodo DESC", $data);
        //////$this->db->close();
        return $resultdoce->result();

    	
    }
    public function m_cursos_x_matricula($data)
    {

		  $resultdoce = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_periodo.ped_nombre AS periodo,
			  tb_carrera.car_sigla AS sigla,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_turno.tur_nombre AS turno,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_unidad_didactica.undd_nombre AS curso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_subseccion_miembros.csm_nota_final AS nota,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  'miembro-alumno' AS miembro,
			  tb_carga_subseccion_miembros.cod_matricula AS matricula,
			  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
			  tb_carga_subseccion_miembros.csm_estado AS dpi,
			  tb_modulo_educativo.mod_nro as nromodulo,
			  tb_unidad_didactica.undd_horas_sema_teor AS hts,
			  tb_unidad_didactica.undd_horas_sema_pract AS hps,
			  tb_unidad_didactica.undd_creditos_teor AS ct,
			  tb_unidad_didactica.undd_creditos_pract AS cp,
			  tb_carga_subseccion_miembros.csm_repitencia AS repite 
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
			  INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
			  INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
			WHERE
			  tb_carga_subseccion_miembros.cod_matricula = ? AND 
			  tb_carga_subseccion_miembros.csm_eliminado = 'NO'", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }

    public function m_cursos_min_x_matricula($data)
    {

		  $resultdoce = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_subseccion_miembros.csm_nota_final AS nota,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  tb_carga_subseccion_miembros.cod_matricula AS matricula,
			  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
			  tb_carga_subseccion_miembros.csm_estado AS dpi,
			  tb_carga_subseccion_miembros.csm_repitencia AS repite,
			  tb_carga_academica.cac_activo as activo,
			  tb_carga_academica_subseccion.cas_culminado as culminado 
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
			WHERE
			  tb_carga_subseccion_miembros.cod_matricula = ? AND 
			  tb_carga_subseccion_miembros.csm_eliminado = 'NO' AND tb_carga_academica.cac_activo='SI' ", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }
	public function m_matriculas_x_grupo_enrolar($data)
    {
      $result = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codmatricula,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carnet,
		  tb_persona.per_dni as dni,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_persona.per_sexo as sexo,
  		tb_persona.per_fecha_nacimiento as fecnac,
  		tb_matricula.codigoestado as codestado
		FROM
		  tb_inscripcion
		  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
        WHERE  tb_matricula.codigosede=? AND tb_matricula.codigoperiodo=? AND tb_matricula.codigocarrera=?  AND tb_matricula.codigociclo=? AND tb_matricula.codigoturno=? AND tb_matricula.codigoseccion=? AND tb_matricula.codigoestado in (1,3,4) 
        ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_inscripcion.id_plan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
        return   $result->result();
    }
    public function m_matriculas_x_grupo($data)
    {
      $result = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codmatricula,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carnet,
		  tb_persona.per_dni as dni,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_persona.per_sexo as sexo,
  		  tb_persona.per_fecha_nacimiento as fecnac,
  		  tb_matricula.codigoestado as codestado 
		FROM
		  tb_inscripcion
		  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
        WHERE  tb_matricula.codigoperiodo=? AND tb_matricula.codigocarrera=? AND tb_inscripcion.id_plan=? AND tb_matricula.codigociclo=? AND tb_matricula.codigoturno=? AND  tb_matricula.codigoseccion=? AND tb_matricula.codigosede = ?
        ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_inscripcion.id_plan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
        return   $result->result();
    }

    public function m_matriculados_miembros_x_grupo_padron($data)
    {
      $result = $this->db->query("SELECT 
				  tb_matricula_cursos_nota_final.mtr_id AS codmatricula,
				  tb_matricula.codigoinscripcion AS codinscripcion,
				  tb_inscripcion.ins_carnet AS carnet,
				  tb_persona.per_dni AS dni,
				  tb_persona.per_apel_paterno AS paterno,
				  tb_persona.per_apel_materno AS materno,
				  tb_persona.per_nombres AS nombres,
				  tb_persona.per_sexo AS sexo,
				  tb_persona.per_fecha_nacimiento AS fecnac,
				  tb_matricula.codigoestado AS codestado,
				  tb_matricula.codigosede as codsede,
				  COUNT(tb_matricula_cursos_nota_final.mtcf_codigo) AS total
				FROM
				  tb_matricula
				  INNER JOIN tb_matricula_cursos_nota_final ON (tb_matricula.mtr_id = tb_matricula_cursos_nota_final.mtr_id)
				  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
				  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
				  INNER JOIN tb_carga_academica ON (tb_matricula_cursos_nota_final.cod_carga_academica = tb_carga_academica.cac_id)
				  INNER JOIN tb_carga_academica_subseccion ON (tb_matricula_cursos_nota_final.cod_carga_academica = tb_carga_academica_subseccion.codigocargaacademica)
				  AND (tb_matricula_cursos_nota_final.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
				  AND (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
        WHERE  tb_matricula.codigosede=? AND tb_matricula_cursos_nota_final.codigoperiodo=? AND tb_matricula_cursos_nota_final.codigocarrera=? AND tb_matricula.codigoplan=? AND tb_matricula_cursos_nota_final.codigociclo=? AND tb_matricula_cursos_nota_final.codigoturno=? AND  tb_matricula_cursos_nota_final.codigoseccion=? 
        GROUP BY
				  tb_matricula_cursos_nota_final.mtr_id,
				  tb_matricula.codigoinscripcion,
				  tb_inscripcion.ins_carnet,
				  tb_persona.per_dni,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres,
				  tb_persona.per_sexo,
				  tb_persona.per_fecha_nacimiento,
				  tb_matricula.codigoestado,
				  tb_matricula.codigosede 
				ORDER BY
				  tb_matricula_cursos_nota_final.codigoperiodo,
				  tb_matricula_cursos_nota_final.codigocarrera,
				  tb_matricula_cursos_nota_final.codigociclo,
				  tb_matricula_cursos_nota_final.codigoturno,
				  tb_matricula_cursos_nota_final.codigoseccion,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres", $data);
        return $result->result();
    }
    
    public function m_matriculas_miembros_x_grupo($data)
    {
      $result = $this->db->query("SELECT 
				  tb_matricula_cursos_nota_final.mtr_id AS codmatricula,
				  tb_matricula.codigoinscripcion AS codinscripcion,
				  tb_inscripcion.ins_carnet AS carnet,
				  tb_persona.per_dni AS dni,
				  tb_persona.per_apel_paterno AS paterno,
				  tb_persona.per_apel_materno AS materno,
				  tb_persona.per_nombres AS nombres,
				  tb_persona.per_sexo AS sexo,
				  tb_persona.per_fecha_nacimiento AS fecnac,
				  tb_matricula.codigoestado AS codestado,
				  COUNT(tb_matricula_cursos_nota_final.mtcf_codigo) AS total
				FROM
				  tb_matricula
				  INNER JOIN tb_matricula_cursos_nota_final ON (tb_matricula.mtr_id = tb_matricula_cursos_nota_final.mtr_id)
				  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
				  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
				  INNER JOIN tb_carga_academica ON (tb_matricula_cursos_nota_final.cod_carga_academica = tb_carga_academica.cac_id)
				  INNER JOIN tb_carga_academica_subseccion ON (tb_matricula_cursos_nota_final.cod_carga_academica = tb_carga_academica_subseccion.codigocargaacademica)
				  AND (tb_matricula_cursos_nota_final.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
				  AND (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
        WHERE  tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=? AND tb_matricula.codigoplan=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND  tb_carga_academica.codigoseccion=? 
        GROUP BY
				  tb_matricula_cursos_nota_final.mtr_id,
				  tb_matricula.codigoinscripcion,
				  tb_inscripcion.ins_carnet,
				  tb_persona.per_dni,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres,
				  tb_persona.per_sexo,
				  tb_persona.per_fecha_nacimiento,
				  tb_matricula.codigoestado
				ORDER BY
				  tb_carga_academica.codigoperiodo,
				  tb_carga_academica.codigocarrera,
				  tb_carga_academica.codigociclo,
				  tb_carga_academica.codigoturno,
				  tb_carga_academica.codigoseccion,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres", $data);
        return   $result->result();
    }

    public function m_matriculados_miembros_x_grupo($data)
    {


      $result = $this->db->query("SELECT 
				  tb_matricula_cursos_nota_final.mtr_id AS codmatricula,
				  tb_matricula.codigoinscripcion AS codinscripcion,
				  tb_inscripcion.ins_carnet AS carnet,
				  tb_persona.per_dni AS dni,
				  tb_persona.per_apel_paterno AS paterno,
				  tb_persona.per_apel_materno AS materno,
				  tb_persona.per_nombres AS nombres,
				  tb_persona.per_sexo AS sexo,
				  tb_persona.per_fecha_nacimiento AS fecnac,
				  tb_matricula.codigoestado AS codestado,
				  tb_matricula.codigosede as codsede,
				  COUNT(tb_matricula_cursos_nota_final.mtcf_codigo) AS total
				FROM
				  tb_matricula
				  INNER JOIN tb_matricula_cursos_nota_final ON (tb_matricula.mtr_id = tb_matricula_cursos_nota_final.mtr_id)
				  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
				  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
				  INNER JOIN tb_carga_academica ON (tb_matricula_cursos_nota_final.cod_carga_academica = tb_carga_academica.cac_id)
				  INNER JOIN tb_carga_academica_subseccion ON (tb_matricula_cursos_nota_final.cod_carga_academica = tb_carga_academica_subseccion.codigocargaacademica)
				  AND (tb_matricula_cursos_nota_final.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
				  AND (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
        WHERE  tb_matricula.codigosede=? AND tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=? AND tb_matricula.codigoplan=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND  tb_carga_academica.codigoseccion=? 
        GROUP BY
				  tb_matricula_cursos_nota_final.mtr_id,
				  tb_matricula.codigoinscripcion,
				  tb_inscripcion.ins_carnet,
				  tb_persona.per_dni,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres,
				  tb_persona.per_sexo,
				  tb_persona.per_fecha_nacimiento,
				  tb_matricula.codigoestado,
				  tb_matricula.codigosede 
				ORDER BY
				  tb_carga_academica.codigoperiodo,
				  tb_carga_academica.codigocarrera,
				  tb_carga_academica.codigociclo,
				  tb_carga_academica.codigoturno,
				  tb_carga_academica.codigoseccion,
				  tb_persona.per_apel_paterno,
				  tb_persona.per_apel_materno,
				  tb_persona.per_nombres", $data);
        return   $result->result();
    }


     public function m_miscursos_x_matricula($data)
    {

        //////$this->load->database();
		  $resultdoce = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_carga_academica_subseccion.codigocargaacademica_aula AS codcarga_fusion,
			  tb_periodo.ped_nombre AS periodo,
			  tb_carrera.car_sigla AS sigla,
			  tb_carrera.car_nombre AS carrera,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_carga_academica.codigoturno AS codturno,
			  tb_carga_academica.codigocarrera AS codcarrera,
			  tb_carga_academica.codigociclo AS codciclo,
			  tb_carga_academica.codigoperiodo AS codperiodo,
			  tb_turno.tur_nombre AS turno,
			  tb_carga_academica.codigoseccion AS codseccion,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_unidad_didactica.undd_nombre AS curso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_subseccion_miembros.csm_nota_final AS nota,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  'miembro-alumno' AS miembro,
			  tb_carga_subseccion_miembros.cod_matricula AS matricula,
			  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
			  tb_carga_subseccion_miembros.csm_estado AS dpi,
			  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
			  tb_carga_academica_subseccion.codigodocente as coddocente,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_unidad_didactica.undd_horas_sema_teor AS hts,
			  tb_unidad_didactica.undd_horas_sema_pract AS hps,
			  tb_unidad_didactica.undd_creditos_teor AS ct,
			  tb_unidad_didactica.undd_creditos_pract AS cp,
			  tb_carga_subseccion_miembros.csm_repitencia AS repite,
			  tb_carga_subseccion_miembros.csm_eliminado AS eliminado,
			  tb_unidad_didactica.codigomodulo as codmodulo,
			  tb_modulo_educativo.mod_nro AS nromodulo,
			  tb_modulo_educativo.codigoplan AS codplan,
			  tb_modulo_educativo.mod_nombre AS modulo,
			  tb_carga_academica_subseccion.cas_culminado AS culminado,
			  tb_carga_academica_subseccion.codigo_calculo_evaluacion AS metodo,
			  tb_carga_academica.cod_sede as carga_codsede,
			  tb_sede.sed_nombre AS carga_sede,
			  tb_sede.sed_abreviatura AS sede_abrevia
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
			  INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
			  INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
			  LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
			  LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
			WHERE
			  tb_carga_subseccion_miembros.cod_matricula = ? AND tb_carga_subseccion_miembros.csm_eliminado = 'NO' order by tb_unidad_didactica.undd_nombre", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }


    public function m_miscursos_x_matriculas($data)
    {

        $signos=implode("','", $data);
				$resultdoce = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_periodo.ped_nombre AS periodo,
			  tb_carrera.car_sigla AS sigla,
			  tb_carrera.car_nombre AS carrera,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_carga_academica.codigoturno as codturno,
			  tb_turno.tur_nombre AS turno,
			  tb_carga_academica.codigoseccion AS codseccion,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_unidad_didactica.undd_nombre AS curso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_subseccion_miembros.csm_nota_final AS nota,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  'miembro-alumno' AS miembro,
			  tb_carga_subseccion_miembros.cod_matricula AS matricula,
			  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
			  tb_carga_subseccion_miembros.csm_estado AS dpi,
			  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
			  tb_persona.per_apel_paterno as paterno,
			  tb_persona.per_apel_materno as materno,
			  tb_persona.per_nombres AS nombres,
			  tb_carga_academica.cac_horas_sema_teor AS hts,
			  tb_carga_academica.cac_horas_sema_pract AS hps,
			  tb_carga_academica.cac_creditos_teor AS ct,
			  tb_carga_academica.cac_creditos_pract AS cp,
			  tb_carga_subseccion_miembros.csm_repitencia AS repite,
			  tb_modulo_educativo.mod_nro as nromodulo ,
			  tb_modulo_educativo.codigoplan AS codplan,
          	tb_modulo_educativo.mod_nombre AS modulo
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
			  INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
			  INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
			  LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
			  LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
			WHERE
			  tb_carga_subseccion_miembros.cod_matricula IN ('$signos') order by tb_unidad_didactica.undd_nombre");
        //////$this->db->close();
        return $resultdoce->result();
    }

    public function m_miscursos_x_mat_asist_estadistica($data)
    {

        //////$this->load->database();
		        $resultdoce = $this->db->query("SELECT 
				  tb_carga_asistencia.codigocarga idcarga,
				  tb_carga_asistencia.idmiembro idmiembro,
				  sum(case when tb_carga_asistencia.acu_accion = 'A' then 1 else 0 end) AS asiste,
				  sum(case when tb_carga_asistencia.acu_accion = 'F' then 1 else 0 end) AS falta,
				  sum(case when tb_carga_asistencia.acu_accion = 'T' then 1 else 0 end) AS tarde,
				  sum(case when tb_carga_asistencia.acu_accion = 'J' then 1 else 0 end) AS justif
				FROM
				  tb_carga_sesiones
				  INNER JOIN tb_carga_asistencia ON (tb_carga_sesiones.ses_id = tb_carga_asistencia.idsesion)
				  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_asistencia.idmiembro = tb_carga_subseccion_miembros.csm_id)
				   WHERE tb_carga_subseccion_miembros.cod_matricula =? and tb_carga_subseccion_miembros.csm_eliminado='NO' 
				GROUP BY
				  tb_carga_asistencia.codigocarga,
				  tb_carga_asistencia.idmiembro", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }

    public function m_matricula_x_periodo_alumno($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS alumno,
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
		WHERE concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ? AND tb_periodo.ped_codigo=?", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

    public function m_matricula_x_periodo_carne($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  concat(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS alumno,
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


    public function m_get_matricula_pdf($data)
    {
       
        $resultmiembro = $this->db->query("SELECT 
				  tb_inscripcion.ins_carnet AS carne,
				  tb_persona.per_apel_paterno AS paterno,
				  tb_persona.per_apel_materno AS materno,
				  tb_persona.per_nombres AS nombres,
				  tb_periodo.ped_nombre AS periodo,
				  tb_inscripcion.id_plan AS codplan,
				  tb_matricula.codigocarrera as codcarrera,
				  tb_carrera.car_nombre AS carrera,
				  tb_carrera.car_nivel_formativo as  nivel,
				  tb_ciclo.cic_nombre AS ciclo,
				  tb_ciclo.cic_letras AS ciclol,
				  tb_turno.tur_nombre AS turno,
				  tb_matricula.codigoseccion AS codseccion,
				  tb_matricula.mtr_fecha as fecha,
				  tb_periodo.ped_anio as anio,
				  tb_persona.per_tipodoc as tipodoc,
				  tb_persona.per_dni as dni,
				  tb_matricula.mtr_id as matricula,
				  tb_matricula.codigosede as idsede,
				  tb_estadoalumno.esal_nombre AS estado,
				  tb_inscripcion.ins_identificador as codinscripcion,
				  tb_inscripcion.ins_emailc as ecorporativo,
				  tb_plan_estudios.pln_nombre plan
				FROM
				  tb_periodo
				  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
				  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
				  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
				  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
				  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
				  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
				  LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula.codigoplan = tb_plan_estudios.pln_id)
				  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
				WHERE tb_matricula.mtr_id=? LIMIT 1", $data);
        ////$this->db->close();
        return $resultmiembro->result();
    }

    


     public function m_get_matriculas_pdf($data)
    {
    	$signos=implode("','", $data);
        $resultmiembro = $this->db->query("SELECT 
		  tb_inscripcion.ins_carnet AS carne,
		  tb_persona.per_apel_paterno AS paterno,
		  tb_persona.per_apel_materno AS materno,
		  tb_persona.per_nombres AS nombres,
		  tb_periodo.ped_nombre AS periodo,
		  tb_inscripcion.id_plan AS codplan,
		  tb_carrera.car_nombre AS carrera,
		  tb_ciclo.cic_nombre AS ciclo,
		  tb_turno.tur_nombre AS turno,
		  tb_matricula.codigoseccion AS codseccion,
		  tb_matricula.mtr_fecha as fecha,
		  tb_periodo.ped_anio as anio,
		  tb_persona.per_tipodoc as tipodoc,
		  tb_persona.per_dni as dni,
		  tb_matricula.mtr_id as matricula,
		  tb_matricula.codigocarrera as codcarrera,
 		  tb_ciclo.cic_letras AS ciclol
		FROM
		  tb_periodo
		  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
		  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
		WHERE tb_matricula.mtr_id IN ('$signos')");
        ////$this->db->close();
        return $resultmiembro->result();
    }

    public function m_update_mostrar_evaluaciones($data)
    {
    	$this->db->query("CALL sp_tb_matricula_update_bloquear(?,?,@s,@nid)", $data);
      	$res = $this->db->query('select @s as salida,@nid as newcod');
      	return $res->row();
    }

    public function m_update_bloquea_evaluaciones($data)
    {
    	$this->db->query("CALL sp_tb_matricula_update_bloquea_evaluaciones(?,?,?,@s,@nid)", $data);
      	$res = $this->db->query('select @s as salida,@nid as newcod');
      	return $res->row();
    }

   
    public function m_filtrar_matriculaxcodigo($data)
    {
       
      $resultmiembro = $this->db->query("SELECT 
				  tb_matricula.mtr_id AS codigo,
				  tb_matricula.codigoinscripcion AS codinscripcion,
				  tb_matricula.mt_tipo AS tipo,
				  tb_matricula.codigobeneficio AS beneficio,
				  tb_matricula.codigoperiodo as codperiodo,
				  tb_matricula.codigocarrera as codcarrera,
				  tb_carrera.car_nombre AS carrera,
				  tb_matricula.codigociclo as codciclo,
				  tb_matricula.codigoturno AS codturno,
				  tb_matricula.codigoseccion AS codseccion,
				  tb_matricula.mtr_cuotapension AS pension,
				  tb_matricula.mtr_cuotapension_real AS pension_real,
				  tb_matricula.codigoestado AS estado,
				  tb_matricula.codigoplan as codplan,
				  tb_matricula.mtr_fecha as fecha,
				  tb_matricula.mtr_observacion as observacion,
				  tb_matricula.mtr_apel_paterno as paterno,
				  tb_matricula.mtr_apel_materno as materno,
				  tb_matricula.mtr_nombres as nombres,
				  tb_matricula.mtr_bloquear_evaluaciones as bloqueo,
				  tb_matricula.codigosede as codsede,
				  tb_matricula.tipodoc_cod as ftipodoc,
				  tb_matricula.dcp_serie as fserie,
				  tb_matricula.dcp_numero as fnumero,
				  tb_matricula.mtr_sin_documento_pago as fsindoc
				FROM
				  tb_matricula
				  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
				WHERE 
				  tb_matricula.mtr_id = ?
				LIMIT 1", $data);
        return $resultmiembro->row();
    }

    public function m_update_matricula_manual($data)
    {
    	$this->db->query("CALL sp_tb_matricula_update_manual(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nc)", $data);
      	$res = $this->db->query('select @s as rs,@nc as newcod');
      	return $res->row();
    }

    public function m_update_matricula_manual_consede($data)
    {
    	$this->db->query("CALL sp_tb_matricula_update_manual_sede(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nc)", $data);
      	$res = $this->db->query('select @s as rs,@nc as newcod');
      	return $res->row();
    }

 	public function m_filtrar_record_academico($carne)
    {
    	$result = $this->db->query("SELECT 
			  tb_matricula_cursos_nota_final.mtcf_codigo as codigo,
			  tb_matricula_cursos_nota_final.mtr_id as matid,
			  tb_matricula_cursos_nota_final.mtcf_tipo as tipo,
			  tb_matricula_cursos_nota_final.codigoperiodo as codperiodo,
			  tb_matricula_cursos_nota_final.codigocarrera as codcarrera,
			  tb_matricula_cursos_nota_final.cod_plan_estudios as codplan,
			  tb_matricula_cursos_nota_final.codigociclo as codciclo,
			  tb_matricula_cursos_nota_final.codigoturno as codturno,
			  tb_matricula_cursos_nota_final.codigoseccion as codseccion,
			  tb_matricula_cursos_nota_final.mtcf_fecha as fecha,
			  tb_matricula_cursos_nota_final.cod_carga_academica as idcarga,
			  tb_matricula_cursos_nota_final.cod_subseccion as codsubsec,
			  tb_matricula_cursos_nota_final.cod_docente as codocente,
			  tb_matricula_cursos_nota_final.cod_unidad_didactica as idunidad,
			  tb_matricula_cursos_nota_final.mtcf_convalida_resolucion as valida,
			  tb_matricula_cursos_nota_final.mtcf_covalida_fecha as vfecha,
			  tb_matricula_cursos_nota_final.mtcf_nota_final as nota,
			  tb_matricula_cursos_nota_final.mtcf_nota_recupera as recuperacion,
			  tb_matricula_cursos_nota_final.mtr_observacion as observacion,
			  tb_matricula_cursos_nota_final.id_usuario as idusuario,
			  tb_matricula_cursos_nota_final.cod_sede as idsede,
			  tb_matricula_cursos_nota_final.mtcf_culminado as culminado,
			  tb_matricula_cursos_nota_final.mtcf_estado as estado,
			  tb_matricula_cursos_nota_final.mtcf_repitencia as repitencia,
			  tb_matricula_cursos_nota_final.cod_miembro as idmiembro,
			  tb_matricula_cursos_nota_final.mtcf_fecha_migracion as fechamig,
			  tb_matricula.mtr_apel_paterno as paterno,
			  tb_matricula.mtr_apel_materno as materno,
			  tb_matricula.mtr_nombres as nombres,
			  tb_matricula.codigoestado as mtestado,
			  tb_estadoalumno.esal_nombre as nomestado,
			  tb_inscripcion.ins_carnet as carnet,
			  tb_carrera.car_nombre as carrera,
			  tb_periodo.ped_nombre as periodo,
			  tb_ciclo.cic_nombre as ciclo,
			  tb_ciclo.cic_letras as cicletras,
			  tb_turno.tur_nombre as turno,
			  tb_unidad_didactica.undd_nombre as curso,
			  tb_unidad_didactica.undd_horas_sema_teor as hts,
			  tb_unidad_didactica.undd_horas_sema_pract as hps,
			  tb_unidad_didactica.undd_creditos_teor as ct,
			  tb_unidad_didactica.undd_creditos_pract as cp,
			  tb_matricula_cursos_nota_final.codigometodocalculo as metodo,
			  tb_matricula_cursos_nota_final.mtcf_codigo_recuperador as recuperador,
				tb_matricula_cursos_nota_final.mtcf_codigo_recuperado as recuperado,
				tb_matricula_cursos_nota_final.mtcf_estado_final as estadofinal 
			FROM
			  tb_periodo
			  INNER JOIN tb_matricula_cursos_nota_final ON (tb_periodo.ped_codigo = tb_matricula_cursos_nota_final.codigoperiodo)
			  INNER JOIN tb_carrera ON (tb_matricula_cursos_nota_final.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_ciclo ON (tb_matricula_cursos_nota_final.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_turno ON (tb_matricula_cursos_nota_final.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_matricula ON (tb_matricula_cursos_nota_final.mtr_id = tb_matricula.mtr_id)
			  INNER JOIN tb_estadoalumno ON (tb_estadoalumno.esal_id = tb_matricula.codigoestado)
			  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
			WHERE 
				tb_inscripcion.ins_carnet = ? 
			ORDER BY tb_matricula_cursos_nota_final.codigoperiodo ASC,tb_unidad_didactica.undd_nombre", $carne);

    	return $result->result();
    }

    public function m_matriculas_campos($data)
    {
      $sqltext_array=array();
      $data_array=array();
      if ($data[0]!="%") {
        $sqltext_array[]="tb_matricula.codigosede = ?";
        $data_array[]=$data[0];
      } 
      if ($data[1]!="%") {
        $sqltext_array[]="tb_matricula.codigoperiodo = ?";
        $data_array[]=$data[1];
      } 
      if ($data[2]!="%")  {
        $sqltext_array[]="tb_matricula.codigocarrera = ?";
        $data_array[]=$data[2];
      }
      if ($data[3]!="%")  {
        $sqltext_array[]="tb_matricula.codigoplan = ?";
        $data_array[]=$data[3];
      }
      if ($data[4]!="%")  {
        $sqltext_array[]="tb_matricula.codigociclo = ?";
        $data_array[]=$data[4];
      }
      if ($data[5]!="%")  {
        $sqltext_array[]="tb_matricula.codigoturno = ?";
        $data_array[]=$data[5];
      }
      if ($data[6]!="%")  {
        $sqltext_array[]="tb_matricula.codigoseccion = ?";
        $data_array[]=$data[6];
      }
      if ($data[7]!="%")  {
        $sqltext_array[]="tb_matricula.codigoestado = ?";
        $data_array[]=$data[7];
      }
      if ($data[8]!="%")  {
        $sqltext_array[]="tb_matricula.codigobeneficio = ?";
        $data_array[]=$data[8];
      }
      if ($data[9]!="%%")  {
        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
        $data_array[]=$data[9];
      }
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

        $resultmiembro = $this->db->query("SELECT 
						  tb_matricula.mtr_id AS codigo,
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
						  tb_matricula.mtr_fecha AS fechamat,
						  tb_matricula.mtr_bloquear_evaluaciones AS bloqueo,
						  tb_estadoalumno.esal_nombre AS estado,
						  tb_persona.per_celular AS celular1,
						  tb_persona.per_celular2 AS celular2,
						  tb_persona.per_telefono AS telefono,
						  tb_persona.per_sexo AS sexo,
						  tb_persona.per_fecha_nacimiento AS fecnac,
						  tb_persona.per_domicilio AS domicilio,
						  tb_persona.per_email_personal AS email,
						  tb_persona.per_tipodoc AS tipodoc,
						  tb_persona.per_dni AS numero,
						  tb_persona.ins_colegio_5to_sec AS colsecundario,
						  tb_persona.per_tipo_colegio AS tipocolegio,
						  tb_persona.per_colegio_anio AS aniocolegio,
						  tb_lenguas.lg_nombre AS lengua,
						  tb_departamento.dep_nombre AS departamento,
						  tb_provincia.prv_nombre AS provincia,
						  tb_distrito.dis_nombre AS distrito,
						  tb_discapacidades.dcd_grupo AS disgrupo,
						  tb_discapacidades.dcd_detalle AS disdetalle,
						  tb_plan_estudios.pln_nombre AS plan,
						  tb_matricula.mt_tipo AS tipomat,
						  tb_beneficio.ben_nombre AS beneficio,
						  tb_matricula.mtr_cuotapension_real AS pensionreal,
						  tb_matricula.mtr_cuotapension AS pensiondscto,
						  tb_matricula.tipodoc_cod as dptipo,
						  tb_matricula.dcp_serie as dpserie,
						  tb_matricula.dcp_numero as dpnumero, 
						  tb_matricula.usuario_id as codusuario,
						  tb_usuario.usu_nick as usuario,
						  tb_matricula.codigosede as codsede,
						  tb_sede.sed_nombre as sede,
						  tb_sede.sed_abreviatura as sede_abrevia
						FROM
						  tb_periodo
						  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
						  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
						  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
						  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
						  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
						  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
						  INNER JOIN tb_lenguas ON (tb_persona.cod_lengua = tb_lenguas.lg_id)
						  INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
						  INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
						  INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
						  LEFT OUTER JOIN tb_inscripcion_discapacidad ON (tb_inscripcion.ins_identificador = tb_inscripcion_discapacidad.cod_inscripcion)
						  LEFT OUTER JOIN tb_discapacidades ON (tb_inscripcion_discapacidad.cod_discapacidad = tb_discapacidades.dcd_id)
						  LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula.codigoplan = tb_plan_estudios.pln_id)
						  INNER JOIN tb_beneficio ON (tb_matricula.codigobeneficio = tb_beneficio.ben_id)
						  LEFT OUTER JOIN tb_usuario ON (tb_matricula.usuario_id = tb_usuario.id_usuario)
						  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
				$sqltext 
				ORDER BY tb_matricula.codigoperiodo,tb_matricula.codigocarrera,tb_matricula.codigoplan,tb_matricula.codigociclo,tb_matricula.codigoturno,tb_matricula.codigoseccion,tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data_array);
        ////$this->db->close();
        return $resultmiembro->result();
    }

    public function m_get_emitidos_tipserie($data)
    {
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
            tb_docpago_sunat.dcps_aceptado as s_aceptado,
            tb_docpago_sunat.dcps_snt_descripcion as s_descripcion,
            tb_matricula.mtr_id AS codmat,
            tb_periodo.ped_nombre AS periodo,
            tb_ciclo.cic_nombre AS ciclo
          FROM
            tb_docpago_sunat
            INNER JOIN tb_docpago ON (tb_docpago_sunat.dcps_id = tb_docpago.dcp_id) 
            LEFT OUTER JOIN tb_matricula ON (tb_docpago.matricula_cod = tb_matricula.mtr_id) 
            LEFT OUTER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
            LEFT OUTER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          WHERE 
          	tb_docpago.tipodoc_cod = ? AND tb_docpago.dcp_serie = ? AND tb_docpago.dcp_numero = ?
          LIMIT 1", $data);
        return $qry->row();
    }


}