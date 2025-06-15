<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmiembros extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function m_auto_insert($cargas,$codmat)
	{
		//CALL ( @vcodcarga, @vcodsubseccion, @vcodmatricula, @s);
		foreach ($cargas as $key => $carga) {
			if ($carga->activo=='SI'){
				$items=array($carga->codcarga,1,$codmat);
				$this->db->query("CALL sp_tb_cargasubseccion_miembros_autoinsert(?,?,?,@s)",$items);
				$res = $this->db->query('select @s as out_param');
 				if ($res->row()->out_param==1)	unset($cargas[$key]);
			}
		}	
	}

	public function m_insert($items)
	{
		$result = $this->db->query("SELECT 
		  COUNT(tb_carga_academica.codigouindidadd) AS veces
		FROM
		  tb_carga_subseccion_miembros
		  INNER JOIN tb_carga_academica ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica.cac_id)
		  INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  WHERE tb_carga_academica.codigouindidadd=? AND tb_inscripcion.ins_carnet=?", array($items[3],$items[4]));
		$fila=$result->row();
		$repite=($fila->veces>0)?"SI":"NO";

		$this->db->query("CALL sp_tb_cargasubseccion_miembros_insert(?,?,?,?,@s)",array($items[0],$items[1],$items[2],$repite));
		$res = $this->db->query('select @s as out_param');
		return $res->row()->out_param;
	}


	public function m_updateMiembro($id,$data){
	    //cod_deuda_calendario
	    $this->db->where('csm_id', $id);
	    $this->db->update('tb_carga_subseccion_miembros', $data);
	    return true;
  	}

	public function m_update($items)
	{
		//CALL ( @vidmiembro, @vcodsubseccion, @veliminar, @s);
		$this->db->query("CALL sp_tb_cargasubseccion_miembros_update(?,?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
		return $res->row()->out_param;
	}

	public function m_update_carga_subseccion($items)
	{
		//CALL ( @vidmiembro, @vcodsubseccion, @veliminar, @s);
		$this->db->query("CALL sp_tb_carga_miembro_update_carga_subseccion(?,?,?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
		return $res->row()->out_param;
	}

	public function m_retirar($items)
	{
		//CALL ( @vidmiembro, @vcodsubseccion, @veliminar, @s);
		$this->db->query("CALL sp_tb_cargasubseccion_miembros_retirar(?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
		return $res->row()->out_param;
	}
	public function m_ocultar($items)
	{
		//CALL ( @vidmiembro, @vcodsubseccion, @veliminar, @s);
		$this->db->query("UPDATE tb_carga_subseccion_miembros  SET  cms_ocultar = ? WHERE csm_id = ?;",$items);
		//$res = $this->db->query('select @s as out_param');
		return $this->db->affected_rows();
	}

	public function m_eliminar($items)
	{
		//CALL ( @vidmiembro, @vcodsubseccion, @veliminar, @s);
		$this->db->query("CALL sp_tb_cargasubseccion_miembros_eliminar(?,@s)",$items);
		$res = $this->db->query('select @s as out_param');
		return $res->row()->out_param;
	}

	public function m_editar_estado($data)
    {
        /////$this->load->database();
        //CALL paeditardpi_miembrocurso( @vcmi_id, @vcmi_dpi, @s);
        $this->db->query("CALL sp_tb_carga_miembro_update_dpi(?,?,@s)", $data);
        $res = $this->db->query('select @s as out_param');
        ////$this->db->close();
        return $res->row()->out_param;
    }
    public function m_editar_promedio($data)
    {

        $this->db->query("CALL sp_tb_carga_miembro_update_promedio(?,?,?,@s)", $data);
        $res = $this->db->query('select @s as out_param');
        ////$this->db->close();
        return $res->row()->out_param;
    }

    public function m_editar_recuperacion($data)
    {

        $this->db->query("CALL sp_tb_carga_miembro_update_recuperacion(?,?,@s)", $data);
        $res = $this->db->query('select @s as out_param');
        ////$this->db->close();
        return $res->row()->out_param;
    }


	public function m_get_miembros_por_carga($data){

        $result = $this->db->query("SELECT 
        		tb_matricula.mtr_id AS codmatricula,
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_carga_subseccion_miembros.csm_id as idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_dni as dni,
			  tb_persona.per_sexo as sexo,
			  tb_persona.per_fecha_nacimiento as fecnac,
			  tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
			  tb_carga_subseccion_miembros.cod_subseccion AS division,
			  tb_carga_subseccion_miembros.csm_eliminado AS eliminado
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
            WHERE tb_carga_subseccion_miembros.cod_cargaacademica=? 
            ORDER BY
				tb_matricula.codigosede,
				tb_matricula.codigocarrera,
				tb_matricula.codigociclo,
				paterno,
				materno,
				nombres", $data);
        return   $result->result();
    }

    public function m_get_miembros_por_carga_division($data){

        $result = $this->db->query("SELECT 
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_matricula.mtr_id AS codmatricula,
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_sexo AS sexo,
			  tb_persona.per_dni AS dni,
			  tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
			  tb_carga_subseccion_miembros.cod_subseccion AS division,
			  tb_carga_subseccion_miembros.csm_eliminado AS eliminado,
			  tb_carga_subseccion_miembros.cms_ocultar AS ocultar,
			  tb_carga_subseccion_miembros.csm_nota_final AS final,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  tb_matricula.codigoestado AS codestadomat,
			  tb_inscripcion.ins_emailc AS einstitucional,
			  tb_carga_subseccion_miembros.csm_estado AS estado,
			  tb_carga_subseccion_miembros.csm_repitencia AS repitencia,
			  tb_matricula.codigosede AS codsede,
			  tb_sede.sed_nombre AS sede,
			  tb_sede.sed_abreviatura AS sede_abrevia,
			  tb_matricula.codigoperiodo AS codperiodo,
			  tb_periodo.ped_codigo AS periodo,
			  tb_matricula.codigocarrera AS codcarrrera,
			  tb_carrera.car_nombre AS carrera,
			  tb_carrera.car_sigla AS sigla,
			  tb_matricula.codigociclo AS codciclo,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_matricula.codigoturno AS codturno,
			  tb_turno.tur_nombre AS turno,
			  tb_matricula.codigoseccion AS codseccion
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
			  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
			  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
			  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
            WHERE tb_carga_subseccion_miembros.cod_cargaacademica=? AND tb_carga_subseccion_miembros.cod_subseccion=? AND  tb_carga_subseccion_miembros.csm_eliminado='NO' 
            ORDER BY tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data);
        return   $result->result();
    }

    public function m_get_miembros_por_carga_division_con_fusionados($data){

        $result = $this->db->query("SELECT 
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_matricula.mtr_id AS codmatricula,
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_sexo AS sexo,
			  tb_persona.per_dni AS dni,
			  tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
			  tb_carga_subseccion_miembros.cod_subseccion AS division,
			  tb_carga_subseccion_miembros.csm_eliminado AS eliminado,
			  tb_carga_subseccion_miembros.cms_ocultar AS ocultar,
			  tb_carga_subseccion_miembros.csm_nota_final AS final,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  tb_matricula.codigoestado AS codestadomat,
			  tb_inscripcion.ins_emailc AS einstitucional,
			  tb_carga_subseccion_miembros.csm_estado AS estado,
			  tb_carga_subseccion_miembros.csm_repitencia AS repitencia,
			  tb_matricula.codigosede AS codsede,
			  tb_sede.sed_nombre AS sede,
			  tb_sede.sed_abreviatura AS sede_abrevia,
			  tb_carga_academica_subseccion.codigocargaacademica_aula as codcarga_fusion,
			  tb_carga_academica_subseccion.codigosubseccion_aula as division_fusion,
			  tb_matricula.codigoperiodo AS codperiodo,
			  tb_periodo.ped_codigo AS periodo,
			  tb_matricula.codigocarrera AS codcarrrera,
			  tb_carrera.car_nombre AS carrera,
			  tb_carrera.car_sigla AS sigla,
			  tb_matricula.codigociclo AS codciclo,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_matricula.codigoturno AS codturno,
			  tb_turno.tur_nombre AS turno,
			  tb_matricula.codigoseccion AS codseccion
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
			  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
			  INNER JOIN tb_carga_academica_subseccion ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica_subseccion.codigocargaacademica)
			  AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
			  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
            WHERE tb_carga_academica_subseccion.codigocargaacademica_aula =? AND tb_carga_academica_subseccion.codigosubseccion_aula=? AND  tb_carga_subseccion_miembros.csm_eliminado='NO' 
            ORDER BY tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data);
        return   $result->result();
    }

    public function m_get_miembro_por_idmiembro($data){

        $result = $this->db->query("SELECT 
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_matricula.mtr_id AS codmatricula,
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_sexo AS sexo,
			  tb_persona.per_dni AS dni,
			  tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
			  tb_carga_subseccion_miembros.cod_subseccion AS division,
			  tb_carga_subseccion_miembros.csm_eliminado AS eliminado,
			  tb_carga_subseccion_miembros.cms_ocultar AS ocultar,
			  tb_carga_subseccion_miembros.csm_nota_final AS final,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  tb_matricula.codigoestado AS codestadomat,
			  tb_inscripcion.ins_emailc AS einstitucional,
			  tb_carga_subseccion_miembros.csm_estado AS estado,
			  tb_carga_subseccion_miembros.csm_repitencia AS repitencia,
			  tb_matricula.codigosede AS codsede,
			  tb_sede.sed_nombre as sede,
			  tb_sede.sed_abreviatura as sede_abrevia
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
			  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
            WHERE tb_carga_subseccion_miembros.csm_id=? AND tb_carga_subseccion_miembros.cod_cargaacademica=? AND tb_carga_subseccion_miembros.cod_subseccion=? AND  tb_carga_subseccion_miembros.csm_eliminado='NO' 
            ORDER BY tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data);
        return   $result->row();
    }

    public function m_get_todos_miembros_x_carga_division($data){

        $result = $this->db->query("SELECT 
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_matricula.mtr_id AS codmatricula,
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_sexo AS sexo,
			  tb_persona.per_dni AS dni,
			  tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
			  tb_carga_subseccion_miembros.cod_subseccion AS division,
			  tb_carga_subseccion_miembros.csm_eliminado AS eliminado,
			  tb_carga_subseccion_miembros.cms_ocultar AS ocultar,
			  tb_carga_subseccion_miembros.csm_nota_final AS final,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  tb_matricula.codigoestado AS codestadomat,
			  tb_inscripcion.ins_emailc AS einstitucional,
			  tb_carga_subseccion_miembros.csm_estado AS estado,
			  tb_carga_subseccion_miembros.csm_repitencia AS repitencia,
			  tb_matricula.codigosede as codsede,
			  tb_sede.sed_nombre as sede  ,
			  tb_carrera.car_sigla as sigla,
			  tb_ciclo.cic_nombre as ciclo,
			  tb_matricula.codigoturno as codturno,
			  tb_matricula.codigoseccion as codseccion 
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
			  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede) 
			  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id) 
			  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo) 
            WHERE tb_carga_subseccion_miembros.cod_cargaacademica=? AND tb_carga_subseccion_miembros.cod_subseccion=?  
            ORDER BY tb_persona.per_apel_paterno,tb_persona.per_apel_materno , tb_persona.per_nombres", $data);
        return   $result->result();
    }

    public function m_comprobar_miembro_por_carga_division($data){

        $result = $this->db->query("SELECT 
        		tb_matricula.mtr_id AS codmatricula,
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_carga_subseccion_miembros.csm_id as idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_dni as dni,
			  tb_persona.per_sexo as sexo,
			  tb_persona.per_fecha_nacimiento as fecnac,
			  tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
			  tb_carga_subseccion_miembros.cod_subseccion AS division,
			  tb_carga_subseccion_miembros.csm_eliminado AS eliminado
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
            WHERE tb_carga_subseccion_miembros.cod_cargaacademica=? AND tb_carga_subseccion_miembros.cod_subseccion=? AND tb_inscripcion.ins_identificador=?
            ORDER BY
				tb_matricula.codigosede,
				tb_matricula.codigocarrera,
				tb_matricula.codigociclo,
				paterno,
				materno,
				nombres", $data);
        return   $result->row();
    }

    public function m_comprobar_miembro($data){

        $result = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id as idmiembro
			  
			FROM
			  tb_carga_subseccion_miembros
           	WHERE tb_carga_subseccion_miembros.cod_cargaacademica=? AND tb_carga_subseccion_miembros.cod_subseccion=? AND tb_carga_subseccion_miembros.cod_matricula=? LIMIT 1", $data);
        $miembro=  $result->row();
        $id="0";
        if ($miembro){
        	$id=$miembro->idmiembro;
        }
        return $id;
    }

    public function m_get_miembros_codigo_carga_division($data)
    {
    	$resultdoce = $this->db->query("SELECT 
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_matricula.mtr_id AS codmatricula,
			  tb_carga_subseccion_miembros.csm_id as idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_sexo AS sexo,
			  tb_persona.per_dni AS dni,
			  tb_inscripcion.ins_emailc einstitucional
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
            WHERE tb_carga_subseccion_miembros.cod_cargaacademica=? AND tb_carga_subseccion_miembros.cod_subseccion=? AND tb_carga_subseccion_miembros.csm_id = ? AND tb_carga_subseccion_miembros.csm_eliminado='NO' LIMIT 1 ", $data);
    	return $resultdoce->row();
    }

    public function m_get_miembro($data)
    {
    	$resultdoce = $this->db->query("SELECT 
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_matricula.mtr_id AS codmatricula,
			  tb_carga_subseccion_miembros.csm_id as idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_sexo AS sexo,
			  tb_persona.per_dni AS dni,
			  tb_inscripcion.ins_emailc einstitucional
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
            WHERE tb_carga_subseccion_miembros.csm_id = ? AND tb_carga_subseccion_miembros.csm_eliminado='NO' LIMIT 1 ", $data);
    	return $resultdoce->row();
    }


    public function m_comprobar_miembro_codigo($data){

        $result = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.csm_id as idmiembro
			  
			FROM
			  tb_carga_subseccion_miembros
           	WHERE tb_carga_subseccion_miembros.cod_cargaacademica=? AND tb_carga_subseccion_miembros.cod_subseccion=? AND tb_carga_subseccion_miembros.csm_id=? LIMIT 1", $data);
        $miembro=  $result->row();
        $id=0;
        if ($miembro){
        	$id=$miembro->idmiembro;
        }
        return $id;
    }


    public function m_posibles_miembros($data){
      $resultdoce = $this->db->query("SELECT 
		  tb_inscripcion.ins_carnet as carnet,
		  tb_persona.per_apel_paterno as paterno,
		  tb_persona.per_apel_materno as materno,
		  tb_persona.per_nombres as nombres,
		  tb_matricula.mtr_id as matricula,
		  tb_matricula.codigociclo as codciclo
		FROM
		  tb_persona
		  INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
		  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
		WHERE
			tb_matricula.codigoperiodo = ? AND 
		    CONCAT(tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? AND tb_matricula.mtr_id NOT IN 
		    	(SELECT tb_carga_subseccion_miembros.cod_matricula FROM tb_carga_subseccion_miembros WHERE tb_carga_subseccion_miembros.cod_cargaacademica = ? and tb_carga_subseccion_miembros.cod_subseccion=? and tb_carga_subseccion_miembros.csm_eliminado ='NO') 
		ORDER BY
		  tb_persona.per_apel_paterno,
		  tb_persona.per_apel_materno,
		  tb_persona.per_nombres LIMIT 20", $data);
        return $resultdoce->result();
     
    }

    public function m_posibles_miembros_xgrupo($data){
      $resultdoce = $this->db->query("SELECT 
		  tb_inscripcion.ins_carnet as carnet,
		  tb_persona.per_apel_paterno as paterno,
		  tb_persona.per_apel_materno as materno,
		  tb_persona.per_nombres as nombres,
		  tb_matricula.mtr_id as matricula,
		  tb_matricula.codigociclo as codciclo
		FROM
		  tb_persona
		  INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
		  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
		WHERE
			tb_matricula.codigosede = ? AND tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan like ? AND 
  		  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
		  tb_matricula.codigoseccion LIKE ? AND 
		    CONCAT(tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? AND tb_matricula.mtr_id NOT IN 
		    	(SELECT tb_carga_subseccion_miembros.cod_matricula FROM tb_carga_subseccion_miembros WHERE tb_carga_subseccion_miembros.cod_cargaacademica = ? and tb_carga_subseccion_miembros.cod_subseccion=? and tb_carga_subseccion_miembros.csm_eliminado ='NO') 
		ORDER BY
		  tb_persona.per_apel_paterno,
		  tb_persona.per_apel_materno,
		  tb_persona.per_nombres LIMIT 40", $data);
        return $resultdoce->result();
     
    }



    // public function m_notas_x_grupo($data)
    // {

    //     $resultdoce = $this->db->query("SELECT 
	// 		  tb_carga_subseccion_miembros.cod_matricula AS matricula,
	// 		  tb_carga_subseccion_miembros.csm_id AS idmiembro,
	// 		  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
	// 		  tb_carga_academica.codigouindidadd AS codcurso,
	// 		  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
	// 		  tb_carga_subseccion_miembros.csm_nota_final AS nota,
	// 		  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
	// 		  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
	// 		  tb_carga_subseccion_miembros.csm_estado AS dpi,
	// 		  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
	// 		  tb_carga_academica.cac_horas_sema_teor AS hts,
	// 		  tb_carga_academica.cac_horas_sema_pract AS hps,
	// 		  tb_carga_academica.cac_creditos_teor AS ct,
	// 		  tb_carga_academica.cac_creditos_pract AS cp,
	// 		  tb_carga_subseccion_miembros.csm_repitencia AS repite,
	// 		  tb_modulo_educativo.codigoplan,
	// 		  tb_carga_academica_subseccion.codigo_calculo_evaluacion as metodo
	// 		FROM
	// 		  tb_carga_academica_subseccion
	// 		  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
	// 		  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
	// 		  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
	// 		  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
	// 		  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
	// 		WHERE
	// 		   tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=? AND tb_modulo_educativo.codigoplan=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND  tb_carga_academica.codigoseccion=?", $data);
       
    //     return $resultdoce->result();
	// 	/*  $resultdoce = $this->db->query("SELECT 
	// 		  tb_carga_subseccion_miembros.cod_matricula AS matricula,
	// 		  tb_carga_subseccion_miembros.csm_id AS idmiembro,
	// 		  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
	// 		  tb_carga_academica.codigouindidadd AS codcurso,
	// 		  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
	// 		  tb_carga_subseccion_miembros.csm_nota_final AS nota,
	// 		  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
	// 		  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
	// 		  tb_carga_subseccion_miembros.csm_estado AS dpi,
	// 		  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
	// 		  tb_carga_academica.cac_horas_sema_teor AS hts,
	// 		  tb_carga_academica.cac_horas_sema_pract AS hps,
	// 		  tb_carga_academica.cac_creditos_teor AS ct,
	// 		  tb_carga_academica.cac_creditos_pract AS cp,
	// 		  tb_carga_subseccion_miembros.csm_repitencia AS repite,
	// 		  tb_modulo_educativo.codigoplan
	// 		FROM
	// 		  tb_carga_academica_subseccion
	// 		  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
	// 		  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
	// 		  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
	// 		  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
	// 		  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
	// 		WHERE
	// 		   tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=? AND tb_modulo_educativo.codigoplan=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND  tb_carga_academica.codigoseccion=?", $data);
       
    //     return $resultdoce->result();*/
    // }
    
    public function m_notas_x_grupo_padron($data)
    {

        $resultdoce = $this->db->query("SELECT 
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
			  tb_carga_academica.cac_horas_sema_teor AS hts,
			  tb_carga_academica.cac_horas_sema_pract AS hps,
			  tb_carga_academica.cac_creditos_teor AS ct,
			  tb_carga_academica.cac_creditos_pract AS cp,
			  tb_modulo_educativo.codigoplan,
			  tb_carga_academica_subseccion.codigo_calculo_evaluacion AS metodo,
			  tb_matricula_cursos_nota_final.cod_miembro AS idmiembro,
			  tb_matricula_cursos_nota_final.mtr_id AS matricula,
			  tb_matricula_cursos_nota_final.mtcf_nota_final AS nota,
			  tb_matricula_cursos_nota_final.mtcf_nota_recupera AS recuperacion,
			  tb_matricula_cursos_nota_final.mtcf_nota_final AS final,
			  tb_matricula_cursos_nota_final.mtcf_estado AS dpi,
			  tb_matricula_cursos_nota_final.mtcf_repitencia AS repite,
			  tb_matricula_cursos_nota_final.cod_unidad_didactica AS codunidad
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
			  INNER JOIN tb_matricula_cursos_nota_final ON (tb_carga_academica_subseccion.codigocargaacademica = tb_matricula_cursos_nota_final.cod_carga_academica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_matricula_cursos_nota_final.cod_subseccion)
			WHERE
			   tb_matricula_cursos_nota_final.codigoperiodo=? AND tb_matricula_cursos_nota_final.codigocarrera=? AND tb_modulo_educativo.codigoplan=? AND tb_matricula_cursos_nota_final.codigociclo=? AND tb_matricula_cursos_nota_final.codigoturno=? AND  tb_matricula_cursos_nota_final.codigoseccion=?", $data);
       
        return $resultdoce->result();
    }

    public function m_notas_x_grupo($data)
    {

        $resultdoce = $this->db->query("SELECT 
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
			  tb_carga_academica.cac_horas_sema_teor AS hts,
			  tb_carga_academica.cac_horas_sema_pract AS hps,
			  tb_carga_academica.cac_creditos_teor AS ct,
			  tb_carga_academica.cac_creditos_pract AS cp,
			  tb_modulo_educativo.codigoplan,
			  tb_carga_academica_subseccion.codigo_calculo_evaluacion AS metodo,
			  tb_matricula_cursos_nota_final.cod_miembro AS idmiembro,
			  tb_matricula_cursos_nota_final.mtr_id AS matricula,
			  tb_matricula_cursos_nota_final.mtcf_nota_final AS nota,
			  tb_matricula_cursos_nota_final.mtcf_nota_recupera AS recuperacion,
			  tb_matricula_cursos_nota_final.mtcf_nota_final AS final,
			  tb_matricula_cursos_nota_final.mtcf_estado AS dpi,
			  tb_matricula_cursos_nota_final.mtcf_repitencia AS repite
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
			  INNER JOIN tb_matricula_cursos_nota_final ON (tb_carga_academica_subseccion.codigocargaacademica = tb_matricula_cursos_nota_final.cod_carga_academica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_matricula_cursos_nota_final.cod_subseccion)
			WHERE
			   tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=? AND tb_modulo_educativo.codigoplan=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND  tb_carga_academica.codigoseccion=?", $data);
       
        return $resultdoce->result();
    }

    public function m_notas_x_grupo_v2($data)
    {

        $resultdoce = $this->db->query("SELECT 
			  tb_carga_subseccion_miembros.cod_matricula AS matricula,
			  tb_carga_subseccion_miembros.csm_id AS idmiembro,
			  tb_carga_academica_subseccion.codigocargaacademica AS idcarga,
			  tb_carga_academica.codigouindidadd AS codcurso,
			  tb_carga_academica_subseccion.codigosubseccion AS subseccion,
			  tb_carga_subseccion_miembros.csm_nota_final AS nota,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS recuperacion,
			  (case when(tb_carga_subseccion_miembros.csm_nota_recuperacion > tb_carga_subseccion_miembros.csm_nota_final) then tb_carga_subseccion_miembros.csm_nota_recuperacion else tb_carga_subseccion_miembros.csm_nota_final end) AS final,
			  tb_carga_subseccion_miembros.csm_estado AS dpi,
			  tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones,
			  tb_carga_academica.cac_horas_sema_teor AS hts,
			  tb_carga_academica.cac_horas_sema_pract AS hps,
			  tb_carga_academica.cac_creditos_teor AS ct,
			  tb_carga_academica.cac_creditos_pract AS cp,
			  tb_carga_subseccion_miembros.csm_repitencia AS repite,
			  tb_modulo_educativo.codigoplan,
			  tb_carga_academica_subseccion.codigo_calculo_evaluacion as metodo
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
			  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
			WHERE
			   tb_carga_academica.codigoperiodo=? AND tb_carga_academica.codigocarrera=? AND tb_modulo_educativo.codigoplan=? AND tb_carga_academica.codigociclo=? AND tb_carga_academica.codigoturno=? AND  tb_carga_academica.codigoseccion=?", $data);
       
        return $resultdoce->result();
    }

    public function m_miembrosxcodigo($data)
    {
    	$resultdoce = $this->db->query("SELECT 
			  tb_matricula.codigoinscripcion AS codinscripcion,
			  tb_inscripcion.ins_carnet AS carnet,
			  tb_matricula.mtr_id AS codmatricula,
			  tb_carga_subseccion_miembros.csm_id as idmiembro,
			  tb_persona.per_apel_paterno AS paterno,
			  tb_persona.per_apel_materno AS materno,
			  tb_persona.per_nombres AS nombres,
			  tb_persona.per_sexo AS sexo,
			  tb_persona.per_dni AS dni,
			  tb_inscripcion.ins_emailc einstitucional
			FROM
			  tb_inscripcion
			  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
			  INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
            WHERE tb_carga_subseccion_miembros.csm_id = ? LIMIT 1", $data);
    	return $resultdoce->row();
    }

  



 	// public function m_notas_carga_subseccion($data)
    // {
    // 	$result = $this->db->query("SELECT 
    // 			tb_matricula.mtr_id as codmatricula,
	// 			  tb_matricula.mtr_apel_paterno AS paterno,
	// 			  tb_matricula.mtr_apel_materno AS materno,
	// 			  tb_matricula.mtr_nombres AS nombres,
	// 			  tb_matricula.mtr_fecha AS fechamat,
	// 			  tb_inscripcion.ins_carnet AS carne,
	// 			  tb_carga_subseccion_miembros.csm_nota_final AS notafin,
	// 			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS notarec,
	// 			  tb_carga_subseccion_miembros.cod_matricula AS idmat,
	// 			  tb_carga_subseccion_miembros.csm_id as idmiembro,
	// 			  tb_carga_subseccion_miembros.cod_cargaacademica AS idcarga,
	// 			  tb_carga_subseccion_miembros.cod_subseccion AS iddivision,
	// 			  tb_matricula.codigoperiodo AS idperiodo,
	// 			  tb_matricula.codigocarrera AS idcarrera,
	// 			  tb_matricula.codigoplan AS idplan,
	// 			  tb_matricula.codigociclo AS idciclo,
	// 			  tb_matricula.codigoturno AS idturno,
	// 			  tb_matricula.codigoseccion AS idseccion,
	// 			  tb_carga_subseccion_miembros.csm_estado AS estado,
	// 			  tb_carga_subseccion_miembros.csm_repitencia AS repitencia,
	// 			  tb_carga_academica_subseccion.codigodocente AS coddocente,
	// 			  tb_matricula_cursos_nota_final.mtcf_tipo AS origentipo,
	// 			  tb_matricula_cursos_nota_final.mtcf_codigo as codmatnota,
	// 			  tb_matricula_cursos_nota_final.mtcf_nota_final AS nota_his,
	// 			  tb_matricula_cursos_nota_final.mtcf_nota_recupera AS nota_rec_his
	// 			FROM
	// 			  tb_matricula
	// 			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
	// 			  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
	// 			  INNER JOIN tb_carga_academica_subseccion ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica_subseccion.codigocargaacademica)
	// 			  AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
	// 			  LEFT OUTER JOIN tb_matricula_cursos_nota_final ON (tb_carga_subseccion_miembros.csm_id = tb_matricula_cursos_nota_final.cod_miembro)

	// 			WHERE
	// 			  tb_carga_subseccion_miembros.cod_cargaacademica = ? AND 
	// 			  tb_carga_subseccion_miembros.cod_subseccion = ? AND
	// 			  tb_carga_academica_subseccion.cas_culminado = 'SI' AND 
	// 			  tb_carga_subseccion_miembros.csm_eliminado='NO' 
	// 			ORDER BY
	// 			  tb_matricula.codigoperiodo,
	// 			  tb_matricula.codigocarrera,
	// 			  tb_matricula.codigoplan,
	// 			  tb_matricula.codigociclo,
	// 			  tb_matricula.codigoturno,
	// 			  tb_matricula.codigoseccion,
	// 			  tb_matricula.mtr_apel_paterno,
	// 			  tb_matricula.mtr_apel_materno,
	// 			  tb_matricula.mtr_nombres", $data);
    // 	return $result->result();
    // }


    public function m_getMiembros($data)
    {
    	//DEPENDE DE LAS NOTAS REGISTRADAS tb_miembros ES DECIR LAS NOTAS DE PLATAFORMA
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
		if (isset($data['codcarga']) and ($data['codcarga']!="%")) {
		$sqltext_array[]="tb_carga_subseccion_miembros.cod_cargaacademica=?";
		$data_array[]=$data['codcarga'];
		}
		if (isset($data['codsubseccion']) and ($data['codsubseccion']!="%")) {
		$sqltext_array[]="tb_carga_subseccion_miembros.cod_subseccion=?";
		$data_array[]=$data['codsubseccion'];
		}
		if (isset($data['culminado']) and ($data['culminado']!="%")) {
		$sqltext_array[]="tb_carga_academica_subseccion.cas_culminado=?";
		$data_array[]=$data['culminado'];
		}
		if (isset($data['eliminado']) and ($data['eliminado']!="%")) {
		$sqltext_array[]="tb_carga_subseccion_miembros.csm_eliminado=?";
		$data_array[]=$data['eliminado'];
		}
		if (isset($data['carga_activa']) and ($data['carga_activa']!="%")) {
		$sqltext_array[]="tb_carga_academica.cac_activo=?";
		$data_array[]=$data['carga_activa'];
		}

		$sqltext=implode(' AND ', $sqltext_array);
		if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
    	$result = $this->db->query("SELECT 
		  tb_inscripcion.ins_carnet AS carne,
		  tb_matricula.mtr_id AS codmatricula,
		  tb_carga_subseccion_miembros.csm_id AS codmiembro,
		  tb_matricula.mtr_apel_paterno AS paterno,
		  tb_matricula.mtr_apel_materno AS materno,
		  tb_matricula.mtr_nombres AS nombres,
		  tb_matricula.mtr_fecha AS fecha,
		  tb_matricula.codigoperiodo AS codperiodo,
		  tb_matricula.codigocarrera AS codcarrera,
		  tb_matricula.codigoplan AS codplan,
		  tb_matricula.codigociclo AS codciclo,
		  tb_matricula.codigoturno AS codturno,
		  tb_matricula.codigoseccion AS codseccion,
		  tb_carga_subseccion_miembros.csm_nota_final AS notafin,
		  tb_carga_subseccion_miembros.csm_nota_recuperacion AS notarecuperacion,
		  tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
		  tb_carga_subseccion_miembros.cod_subseccion AS codsubseccion,
		  tb_carga_subseccion_miembros.csm_estado AS estadomiembro,
		  tb_carga_subseccion_miembros.csm_eliminado AS eliminado,
		  tb_carga_subseccion_miembros.csm_repitencia AS repitencia,
		  tb_carga_academica_subseccion.codigodocente AS coddocente,
		  tb_carga_academica_subseccion.cas_culminado AS culminado
		FROM
		  tb_matricula
		  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
		  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
		  INNER JOIN tb_carga_academica_subseccion ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica_subseccion.codigocargaacademica)
		  AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
		  INNER JOIN tb_carga_academica ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica.cac_id)
		$sqltext 
		ORDER BY
		  tb_matricula.codigoperiodo,
		  tb_matricula.codigocarrera,
		  tb_matricula.codigoplan,
		  tb_matricula.codigociclo,
		  tb_matricula.codigoturno,
		  tb_matricula.codigoseccion,
		  tb_matricula.mtr_apel_paterno,
		  tb_matricula.mtr_apel_materno,
		  tb_matricula.mtr_nombres", $data_array);
    	return $result->result();
   	}

   	public function m_getMiembros_notasFinalesMigradas($data)
    {
    	//DEPENDE DE LAS NOTAS REGISTRADAS tb_miembros ES DECIR LAS NOTAS DE PLATAFORMA
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
		if (isset($data['codcarga']) and ($data['codcarga']!="%")) {
		$sqltext_array[]="tb_carga_subseccion_miembros.cod_cargaacademica=?";
		$data_array[]=$data['codcarga'];
		}
		if (isset($data['codsubseccion']) and ($data['codsubseccion']!="%")) {
		$sqltext_array[]="tb_carga_subseccion_miembros.cod_subseccion=?";
		$data_array[]=$data['codsubseccion'];
		}
		if (isset($data['culminado']) and ($data['culminado']!="%")) {
		$sqltext_array[]="tb_carga_academica_subseccion.cas_culminado=?";
		$data_array[]=$data['culminado'];
		}
		if (isset($data['eliminado']) and ($data['eliminado']!="%")) {
		$sqltext_array[]="tb_carga_subseccion_miembros.csm_eliminado=?";
		$data_array[]=$data['eliminado'];
		}


		$sqltext=implode(' AND ', $sqltext_array);
		if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
    	$result = $this->db->query("SELECT 
    		tb_inscripcion.ins_carnet AS carne,
    		tb_matricula.mtr_id as codmatricula,
    		tb_carga_subseccion_miembros.csm_id as codmiembro,
			  tb_matricula.mtr_apel_paterno AS paterno,
			  tb_matricula.mtr_apel_materno AS materno,
			  tb_matricula.mtr_nombres AS nombres,
			  tb_matricula.mtr_fecha AS fecha,
			  tb_matricula.codigoperiodo AS codperiodo,
			  tb_matricula.codigocarrera AS codcarrera,
			  tb_matricula.codigoplan AS codplan,
			  tb_matricula.codigociclo AS codciclo,
			  tb_matricula.codigoturno AS codturno,
			  tb_matricula.codigoseccion AS codseccion,

			  tb_carga_subseccion_miembros.csm_nota_final AS notafin,
			  tb_carga_subseccion_miembros.csm_nota_recuperacion AS notarecuperacion,
			  
			  tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga,
			  tb_carga_subseccion_miembros.cod_subseccion AS codsubseccion,
			  tb_carga_subseccion_miembros.csm_estado AS estadomiembro,
			  tb_carga_subseccion_miembros.csm_eliminado as eliminado,
			  tb_carga_subseccion_miembros.csm_repitencia AS repitencia,

			  tb_carga_academica_subseccion.codigodocente AS coddocente,
			  tb_carga_academica_subseccion.cas_culminado AS culminado,
			  

			  tb_matricula_cursos_nota_final.mtcf_codigo as codnotamigrada,
			  tb_matricula_cursos_nota_final.mtcf_estado as estado,
			  tb_matricula_cursos_nota_final.mtcf_tipo AS origentipo,
			  tb_matricula_cursos_nota_final.mtcf_nota_final AS notafin_migrada,
			  tb_matricula_cursos_nota_final.mtcf_nota_recupera AS notarecuperacion_migrada
			FROM
			  tb_matricula
			  INNER JOIN tb_carga_subseccion_miembros ON (tb_matricula.mtr_id = tb_carga_subseccion_miembros.cod_matricula)
			  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
			  INNER JOIN tb_carga_academica_subseccion ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica_subseccion.codigocargaacademica)
			  AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
			  LEFT OUTER JOIN tb_matricula_cursos_nota_final ON (tb_carga_subseccion_miembros.csm_id = tb_matricula_cursos_nota_final.cod_miembro)

		
			 $sqltext
			ORDER BY
			  tb_matricula.codigoperiodo,
			  tb_matricula.codigocarrera,
			  tb_matricula.codigoplan,
			  tb_matricula.codigociclo,
			  tb_matricula.codigoturno,
			  tb_matricula.codigoseccion,
			  tb_matricula.mtr_apel_paterno,
			  tb_matricula.mtr_apel_materno,
			  tb_matricula.mtr_nombres", $data_array);
    	return $result->result();
   	}
}
/*SELECT 
            tbmatricula.mtr_carne as carne,
            tbusuario.usu_apel_paterno as paterno,
            tbusuario.usu_apel_materno as materno,
            tbusuario.usu_nombres as nombres,
            tbmatricula.cac_codigo as matricula,
            tbmatricula.codigociclo as codciclo
          FROM
            tbusuario
            INNER JOIN tbmatricula ON (tbusuario.usu_codigo = tbmatricula.mtr_carne)
          WHERE
            tbmatricula.codigoperiodo = ? AND 
            CONCAT(tbusuario.usu_apel_paterno, ' ', IFNULL(tbusuario.usu_apel_materno, ''), ' ', tbusuario.usu_nombres) LIKE ? AND 
            tbmatricula.mtr_carne NOT IN (SELECT tbcurso_miembros.cmi_carne FROM tbcurso_miembros WHERE idcarga_subseccion = ? and tbcurso_miembros.cmi_eliminado='NO')
          ORDER BY
            tbusuario.usu_apel_paterno, tbusuario.usu_apel_materno,
            tbusuario.usu_nombres*/
