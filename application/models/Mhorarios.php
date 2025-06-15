<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mhorarios extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function m_get_horarios_carga_subseccion($data)
	{
		$result = $this->db->query("SELECT 
				  tb_horarios.hro_id id,
				  tb_horarios.cod_cargaacademica carga,
				  tb_horarios.codigosubseccion subseccion,
				  tb_horarios.hro_horaini inicia,
				  tb_horarios.hro_horafin finaliza,
				  tb_horarios.codigo_aula aula,
				  tb_aulas.aul_nombre naula,
				  tb_horarios.hro_piso piso,
				  tb_horarios.hro_cnthoras nhoras,
				  tb_horarios.hro_dia dia
				FROM 
				  tb_horarios
				  INNER JOIN tb_aulas ON (tb_horarios.codigo_aula = tb_aulas.aul_id)
				WHERE 
					tb_horarios.cod_cargaacademica = ? AND tb_horarios.codigosubseccion = ? ", $data);
		return $result->result();
	}

	public function m_horas_activas()
    {
        $qry = $this->db->query("SELECT
        tb_horas.hor_id id,
        tb_horas.hor_inicia inicia,
        tb_horas.hor_fin culmina,
        tb_horas.codigoturno idturno
      FROM
        tb_horas WHERE tb_horas.hor_habilitado='SI' ORDER BY  tb_horas.hor_inicia");
        return $qry->result();
    }

    public function m_aulas()
    {
        $result = $this->db->query("SELECT
					  tb_aulas.aul_id id,
					  tb_aulas.aul_nombre nombre,
					  tb_aulas.aul_nombrec nombrec,
					  tb_aulas.aul_piso piso,
					  tb_aulas.aul_capacidad aforo
					FROM
					  tb_aulas ORDER BY tb_aulas.aul_piso,tb_aulas.aul_nombre");
        return $result->result();
    }

    public function m_insert_Horario($items)
    {
    	$this->db->query("CALL `sp_tb_horarios_insert`(?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();
    }

    public function m_update_Horario($items)
    {
    	$this->db->query("CALL `sp_tb_horarios_update`(?,?,?,?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();
    }

    public function m_elimina_item_horario($items)
    {
    	$this->db->query("CALL `sp_tb_horarios_delete`(?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();
    }

    public function m_cursos_horarios($data)
    {
    	$result = $this->db->query("SELECT 
			  tb_horarios.hro_id id,
			  tb_horarios.cod_cargaacademica idcarga,
			  tb_horarios.codigosubseccion iddivision,
			  tb_horarios.hro_horaini hini,
			  tb_horarios.hro_horafin hfin,
			  tb_horarios.codigo_aula haula,
			  tb_aulas.aul_nombre naula,
			  tb_horarios.hro_piso hpiso,
			  tb_horarios.hro_cnthoras nhoras,
			  tb_horarios.hro_dia hdia,
			  tb_unidad_didactica.undd_nombre nomcurso,
			  tb_carrera.car_nombre nomcarrera,
			  tb_carrera.car_sigla abrev,
			  tb_ciclo.cic_nombre ciclo,
			  tb_seccion.sec_nombre seccion
			FROM
			  tb_carga_academica
			  INNER JOIN tb_horarios ON (tb_carga_academica.cac_id = tb_horarios.cod_cargaacademica)
			  INNER JOIN tb_carga_academica_subseccion ON (tb_horarios.codigosubseccion = tb_carga_academica_subseccion.codigosubseccion)
			  AND (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
			  INNER JOIN tb_aulas ON (tb_horarios.codigo_aula = tb_aulas.aul_id)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_seccion ON (tb_carga_academica.codigoseccion = tb_seccion.sec_codigo)
			WHERE
			  tb_carga_academica_subseccion.codigodocente = ? AND 
			  tb_carga_academica.codigoperiodo = ? AND 
			  tb_carga_academica_subseccion.cas_activo = 'SI'
			ORDER BY tb_unidad_didactica.undd_nombre",$data);
    	
        return $result->result();
    }

    public function m_cursos_resumen($data)
    {
    	$result = $this->db->query("SELECT DISTINCT 
				  tb_horarios.hro_id id,
				  tb_horarios.cod_cargaacademica idcarga,
				  tb_horarios.codigosubseccion iddivision,
				  tb_horarios.hro_horaini hini,
				  tb_horarios.hro_horafin hfin,
				  tb_horarios.codigo_aula haula,
			  	  tb_aulas.aul_nombre naula,
				  tb_horarios.hro_piso hpiso,
				  -- SUM(tb_horarios.hro_cnthoras) nhoras,
				  tb_horarios.hro_cnthoras nhoras,
				  tb_horarios.hro_dia hdia,
				  tb_unidad_didactica.undd_nombre nomcurso,
				  tb_carrera.car_nombre nomcarrera,
				  tb_carrera.car_sigla abrev,
				  tb_ciclo.cic_nombre ciclo,
				  tb_turno.tur_nombre turno,
				  tb_seccion.sec_nombre seccion
				FROM
				  tb_carga_academica
				  INNER JOIN tb_horarios ON (tb_carga_academica.cac_id = tb_horarios.cod_cargaacademica)
				  INNER JOIN tb_carga_academica_subseccion ON (tb_horarios.codigosubseccion = tb_carga_academica_subseccion.codigosubseccion)
				  AND (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
				  INNER JOIN tb_aulas ON (tb_horarios.codigo_aula = tb_aulas.aul_id)
				  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
				  INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
				  INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
				  INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
				  INNER JOIN tb_seccion ON (tb_carga_academica.codigoseccion = tb_seccion.sec_codigo)
				WHERE
				  tb_carga_academica_subseccion.codigodocente = ? AND 
				  tb_carga_academica.codigoperiodo = ? AND 
				  tb_carga_academica_subseccion.cas_activo = 'SI'
				ORDER BY
					tb_unidad_didactica.undd_nombre",$data);
        return $result->result();
    }

    public function m_get_horarios_codigo($data)
    {
    	$result = $this->db->query("SELECT 
				  tb_horarios.hro_id id,
				  tb_horarios.cod_cargaacademica carga,
				  tb_horarios.codigosubseccion subseccion,
				  tb_horarios.hro_horaini inicia,
				  tb_horarios.hro_horafin finaliza,
				  tb_horarios.codigo_aula aula,
				  tb_horarios.hro_piso piso,
				  tb_horarios.hro_cnthoras nhoras,
				  tb_horarios.hro_dia dia
				FROM 
				  tb_horarios
				WHERE 
					tb_horarios.hro_id = ?  LIMIT 1", $data);
		return $result->row();
    }

    // public function m_cursos_resumen_2($data)
    // {
    // 	$resultdoce = $this->db->query("SELECT DISTINCT 
				//   tb_horarios.hro_id id,
				//   tb_horarios.cod_cargaacademica idcarga,
				//   tb_horarios.codigosubseccion iddivision,
				//   tb_horarios.hro_horaini hini,
				//   tb_horarios.hro_horafin hfin,
				//   tb_horarios.hro_aula haula,
				//   tb_horarios.hro_piso hpiso,
				//   SUM(tb_horarios.hro_cnthoras) nhoras,
				//   -- tb_horarios.hro_cnthoras nhoras,
				//   tb_horarios.hro_dia hdia,
				//   tb_unidad_didactica.undd_nombre nomcurso,
				//   tb_carrera.car_nombre nomcarrera,
				//   tb_carrera.car_sigla abrev,
				//   tb_ciclo.cic_nombre ciclo,
				//   tb_turno.tur_nombre turno,
				//   tb_seccion.sec_nombre seccion
				// FROM
				//   tb_carga_academica
				//   INNER JOIN tb_horarios ON (tb_carga_academica.cac_id = tb_horarios.cod_cargaacademica)
				//   INNER JOIN tb_carga_academica_subseccion ON (tb_horarios.codigosubseccion = tb_carga_academica_subseccion.codigosubseccion)
				//   AND (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
				//   INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
				//   INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
				//   INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
				//   INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
				//   INNER JOIN tb_seccion ON (tb_carga_academica.codigoseccion = tb_seccion.sec_codigo)
				// WHERE
				//   tb_carga_academica_subseccion.codigodocente = ? AND 
				//   tb_carga_academica_subseccion.cas_activo = 'SI'
				// GROUP BY
				// 	tb_carrera.car_nombre,
				// 	tb_ciclo.cic_nombre,
				// 	tb_seccion.sec_nombre,
				// 	tb_turno.tur_nombre,
				// 	tb_unidad_didactica.undd_nombre
				// ORDER BY
				// 	tb_unidad_didactica.undd_nombre",$data);
    //     return $resultdoce->result();
    // }

    public function m_cursos_horario_estudiante($data)
    {
    	$result = $this->db->query("SELECT 
					  tb_horarios.hro_id id,
					  tb_horarios.cod_cargaacademica idcarga,
					  tb_horarios.codigosubseccion iddivision,
					  tb_horarios.hro_horaini hini,
					  tb_horarios.hro_horafin hfin,
					  tb_horarios.codigo_aula haula,
					  tb_aulas.aul_nombre naula,
					  tb_horarios.hro_piso hpiso,
					  tb_horarios.hro_cnthoras nhoras,
					  tb_horarios.hro_dia hdia,
					  tb_unidad_didactica.undd_nombre nomcurso,
					  tb_persona.per_apel_paterno dpaterno,
					  tb_persona.per_apel_materno dmaterno,
					  tb_persona.per_nombres dnombres,
					  tb_matricula.codigoturno codturno
					FROM
					  tb_carga_academica
					  INNER JOIN tb_horarios ON (tb_carga_academica.cac_id = tb_horarios.cod_cargaacademica)
					  INNER JOIN tb_carga_academica_subseccion ON (tb_horarios.codigosubseccion = tb_carga_academica_subseccion.codigosubseccion)
					  AND (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
					  INNER JOIN tb_aulas ON (tb_horarios.codigo_aula = tb_aulas.aul_id)
					  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
					  INNER JOIN tb_carga_subseccion_miembros ON (tb_carga_academica.cac_id = tb_carga_subseccion_miembros.cod_cargaacademica)
					  AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
					  INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
					  INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
					  INNER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
  					  INNER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
					WHERE
					  tb_inscripcion.ins_carnet = ? AND 
					  tb_carga_academica_subseccion.cas_activo= 'SI' AND 
					  tb_carga_academica.codigoperiodo = ? 
					ORDER BY
					  tb_unidad_didactica.undd_nombre",$data);
    	return $result->result();
    }

    





}