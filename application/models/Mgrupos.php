<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mgrupos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
	
	public function m_filtrar($data)
	{
	  $sqltext_array=array();
	  $sqltext2_array=array();
      $data_array=array();

      if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_matricula.codigoperiodo = ?";
        $sqltext2_array[]="tb_carga_academica.codigoperiodo=?";
        $data_array[]=$data['codperiodo'];
      } 
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_matricula.codigosede = ?";
        $sqltext2_array[]="tb_carga_academica.cod_sede=?";
        $data_array[]=$data['codsede'];
      } 
      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_matricula.codigocarrera = ?";
        $sqltext2_array[]="tb_carga_academica.codigocarrera=?";
        $data_array[]=$data['codcarrera'];
      } 
      if (isset($data['codturno']) and ($data['codturno']!="%")) {
        $sqltext_array[]="tb_matricula.codigoturno = ?";
        $sqltext2_array[]="tb_carga_academica.codigoturno=?";
        $data_array[]=$data['codturno'];
      }
      if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
        $sqltext_array[]="tb_matricula.codigociclo = ?";
        $sqltext2_array[]="tb_carga_academica.codigociclo=?";
        $data_array[]=$data['codciclo'];
      }
      if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
        $sqltext_array[]="tb_matricula.codigoseccion = ?";
        $sqltext2_array[]="tb_carga_academica.codigoseccion=?";
        $data_array[]=$data['codseccion'];
      }
       if (isset($data['codplan']) and ($data['codplan']!="%")) {
        $sqltext_array[]="tb_matricula.codigoplan = ?";
        $sqltext2_array[]="tb_modulo_educativo.codigoplan=?";
        $data_array[]=$data['codplan'];
      }
      $sqltext2_array[]="tb_carga_academica.cac_activo='SI'";
      
      $sqltext=implode(' AND ', $sqltext_array);
      $sqltext2=implode(' AND ', $sqltext2_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
      if ($sqltext2!="") $sqltext2= " WHERE ".$sqltext2;

		$gpmatriculas=array();
		$gpcargas=array();
		$qry=$this->db->query("SELECT 
			  tb_matricula.codigoperiodo AS codperiodo,
			  tb_periodo.ped_nombre AS periodo,
			  tb_matricula.codigocarrera AS codcarrera,
			  tb_carrera.car_nombre AS carrera,
			  tb_carrera.car_sigla AS sigla,
			  tb_carrera.car_nivel_formativo AS nformativo,
			  tb_matricula.codigociclo AS codciclo,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_ciclo.cic_letras AS ciclol,
			  tb_matricula.codigoturno AS codturno,
			  tb_turno.tur_nombre AS turno,
			  tb_matricula.codigoseccion AS codseccion,
			  tb_matricula.codigoseccion AS seccion,
			  COUNT(tb_matricula.mtr_id) AS mat,
			  sum(case when tb_matricula.codigoestado = 1 then 1 else 0 end) AS act,
			  sum(case when tb_matricula.codigoestado = 2 then 1 else 0 end) AS ret,
			  sum(case when tb_matricula.codigoestado = 4 then 1 else 0 end) AS cul,
			  sum(case when tb_matricula.codigoestado = 6 then 1 else 0 end) AS pry,
			  sum(case when tb_matricula.mtr_bloquear_evaluaciones = 'SI' then 1 else 0 end) AS bloqueo,
			  tb_matricula.codigoplan AS idplan,
			  tb_plan_estudios.pln_nombre AS plan,
			  tb_matricula.codigosede AS codsede,
			  tb_sede.sed_nombre AS sede,
			  tb_sede.sed_abreviatura AS sede_abrevia,
			  tb_matricula.codigoplan AS codplan
			FROM
			  tb_periodo
			  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
			  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
			  LEFT OUTER JOIN tb_plan_estudios ON (tb_plan_estudios.pln_id = tb_matricula.codigoplan)
			  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
			$sqltext 
			GROUP BY
			  tb_matricula.codigoperiodo,
			  tb_periodo.ped_nombre,
			  tb_matricula.codigocarrera,
			  tb_carrera.car_nombre,
			  tb_carrera.car_sigla,
			  tb_carrera.car_nivel_formativo,
			  tb_matricula.codigociclo,
			  tb_ciclo.cic_nombre,
			  tb_ciclo.cic_letras,
			  tb_matricula.codigoturno,
			  tb_turno.tur_nombre,
			  tb_matricula.codigoseccion,
			  tb_matricula.codigoseccion,
			  tb_matricula.codigoplan,
			  tb_plan_estudios.pln_nombre,
			  tb_matricula.codigosede,
			  tb_sede.sed_nombre,
			  tb_sede.sed_abreviatura,
			  tb_matricula.codigoplan 
			ORDER BY
			  tb_matricula.codigosede,
			  tb_matricula.codigoperiodo,
				tb_matricula.codigocarrera,
				tb_matricula.codigociclo,
				tb_matricula.codigoturno,
				tb_matricula.codigoseccion",$data_array);

		$gpmatriculas=$qry->result();
		$qry2=$this->db->query("SELECT DISTINCT 
			  tb_carga_academica.codigoperiodo AS codperiodo,
			  tb_periodo.ped_nombre AS periodo,
			  tb_carga_academica.codigocarrera AS codcarrera,
			  tb_carrera.car_nombre AS carrera,
			  tb_carrera.car_sigla AS sigla,
			  tb_carrera.car_nivel_formativo AS nformativo,
			  tb_carga_academica.codigociclo AS codciclo,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_ciclo.cic_letras AS ciclol,
			  tb_carga_academica.codigoturno AS codturno,
			  tb_turno.tur_nombre AS turno,
			  tb_carga_academica.codigoseccion AS seccion,
			  tb_carga_academica.codigoseccion AS codseccion,
			  tb_modulo_educativo.codigoplan AS idplan,
			  tb_plan_estudios.pln_nombre AS plan,
			  tb_carga_academica.cod_sede AS codsede,
			  tb_sede.sed_nombre AS sede,
			  tb_sede.sed_abreviatura AS sede_abrevia,
			  tb_modulo_educativo.codigoplan AS codplan
			FROM
			  tb_carga_academica_subseccion
			  INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
			  INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
			  INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
			  INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
			  INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
			  INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
			  INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
			  INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede) 
			$sqltext2 
			ORDER BY 
			 	tb_carga_academica.codigoperiodo,
				tb_carga_academica.codigocarrera,
				tb_carga_academica.codigociclo,
				tb_carga_academica.codigoturno,
				tb_carga_academica.codigoseccion,
				tb_modulo_educativo.codigoplan",$data_array);

		$gpcargas=$qry2->result();
		foreach ($gpcargas as $kgc => $cg) {
			$flat_existe=false;
			foreach ($gpmatriculas as $kgm => $mt) {
				if (($cg->periodo==$mt->periodo) && ($cg->codcarrera==$mt->codcarrera) && ($cg->codciclo==$mt->codciclo) && ($cg->codturno==$mt->codturno) && ($cg->seccion==$mt->seccion) && ($cg->idplan==$mt->idplan)){
					$flat_existe=true;
				}
			}
			if ($flat_existe==false){
				$gp = new stdClass;
				$gp->codperiodo=$cg->codperiodo;
				$gp->periodo=$cg->periodo;
				$gp->codcarrera=$cg->codcarrera;
				$gp->carrera=$cg->carrera;
				$gp->sigla=$cg->sigla;
				$gp->nformativo=$cg->nformativo;
				$gp->codciclo=$cg->codciclo;
				$gp->ciclo=$cg->ciclo;
				$gp->ciclol=$cg->ciclol;
				$gp->codturno=$cg->codturno;
				$gp->turno=$cg->turno;
				$gp->seccion=$cg->seccion;
				$gp->codseccion=$cg->codseccion;
				$gp->mat=0;
				$gp->act=0;
				$gp->ret=0;
				$gp->cul=0;
				$gp->pry=0;
				$gp->idplan=$cg->idplan;
				$gp->codplan=$cg->idplan;
				$gp->plan=$cg->plan;

				$gp->codsede=$cg->codsede;
				$gp->sede=$cg->sede;
				$gp->sede_abrevia=$cg->sede_abrevia;
				$gpmatriculas[]=$gp;
			}
		}
		return $gpmatriculas;
	}


	public function m_matriculas_x_grupo($data)
	{
		$gpmatriculas=array();
		$qry=$this->db->query("SELECT 
			  tb_matricula.codigoperiodo AS codperiodo,
			  tb_periodo.ped_nombre AS periodo,
			  tb_matricula.codigocarrera AS codcarrera,
			  tb_carrera.car_nombre AS carrera,
			  tb_carrera.car_nivel_formativo AS nformativo,
			  tb_matricula.codigociclo AS codciclo,
			  tb_ciclo.cic_nombre AS ciclo,
			  tb_ciclo.cic_letras AS ciclol,
			  tb_matricula.codigoturno AS codturno,
			  tb_turno.tur_nombre AS turno,
			  tb_matricula.codigoseccion AS seccion,
			  COUNT(tb_matricula.mtr_id) AS mat,
			  sum(case when tb_matricula.codigoestado = 1 then 1 else 0 end) AS act,
			  sum(case when tb_matricula.codigoestado = 2 then 1 else 0 end) AS ret,
			  sum(case when tb_matricula.codigoestado = 4 then 1 else 0 end) AS cul,
			  tb_matricula.codigoplan AS idplan,
			  tb_plan_estudios.pln_nombre AS plan
			FROM
			  tb_periodo
			  INNER JOIN tb_matricula ON (tb_periodo.ped_codigo = tb_matricula.codigoperiodo)
			  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
			  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
			  LEFT OUTER JOIN tb_plan_estudios ON (tb_plan_estudios.pln_id = tb_matricula.codigoplan)
			  INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
			WHERE 
			   tb_matricula.codigosede=? AND tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND tb_matricula.codigoplan LIKE ? AND
  		  	   tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
		  	   tb_matricula.codigoseccion LIKE ?  
			GROUP BY
			  tb_matricula.codigoperiodo,
			  tb_periodo.ped_nombre,
			  tb_matricula.codigocarrera,
			  tb_carrera.car_nombre,
			  tb_carrera.car_nivel_formativo,
			  tb_matricula.codigociclo,
			  tb_ciclo.cic_nombre,
			  tb_ciclo.cic_letras,
			  tb_matricula.codigoturno,
			  tb_turno.tur_nombre,
			  tb_matricula.codigoseccion,
			  tb_matricula.codigoplan,
			  tb_plan_estudios.pln_nombre",$data);

		$gpmatriculas=$qry->result();
		
		return $gpmatriculas;
	}

	public function m_filtrar_ord_mer($data)
	{
		$qry=$this->db->query("SELECT 
		  tb_matricula.mtr_id AS codigo,
		  tb_matricula.codigoinscripcion AS codinscripcion,
		  tb_inscripcion.ins_carnet AS carne,
		  tb_matricula.mtr_apel_paterno AS paterno,
		  tb_matricula.mtr_apel_materno AS materno,
		  tb_matricula.mtr_nombres AS nombres,
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
		  substr(tb_estadoalumno.esal_nombre, 1, 3) AS estado,
		  SUM(tb_unidad_didactica.undd_creditos_teor + tb_unidad_didactica.undd_creditos_pract) AS creditos,
		  sum(((case when(tb_matricula_cursos_nota_final.mtcf_nota_recupera IS NULL) then tb_matricula_cursos_nota_final.mtcf_nota_final ELSE tb_matricula_cursos_nota_final.mtcf_nota_recupera end) * (tb_unidad_didactica.undd_creditos_teor + tb_unidad_didactica.undd_creditos_pract))) AS puntaje,
		  sum(((case when(tb_matricula_cursos_nota_final.mtcf_nota_recupera IS NULL) then tb_matricula_cursos_nota_final.mtcf_nota_final ELSE tb_matricula_cursos_nota_final.mtcf_nota_recupera end) * (tb_unidad_didactica.undd_creditos_teor + tb_unidad_didactica.undd_creditos_pract))) / SUM(tb_unidad_didactica.undd_creditos_teor + tb_unidad_didactica.undd_creditos_pract) as ponderado
		FROM
		  tb_inscripcion
		  INNER JOIN tb_matricula ON (tb_inscripcion.ins_identificador = tb_matricula.codigoinscripcion)
		  INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
		  INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
		  INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
		  INNER JOIN tb_estadoalumno ON (tb_matricula.codigoestado = tb_estadoalumno.esal_id)
		  INNER JOIN tb_matricula_cursos_nota_final ON (tb_matricula_cursos_nota_final.mtr_id = tb_matricula.mtr_id)
		  INNER JOIN tb_unidad_didactica ON (tb_unidad_didactica.undd_codigo = tb_matricula_cursos_nota_final.cod_unidad_didactica)
  
		WHERE
		  tb_matricula.codigosede=?  AND tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND
  		  tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
		  tb_matricula.codigoseccion LIKE ? AND tb_matricula_cursos_nota_final.mtcf_repitencia = 'NO'
		GROUP BY
		  tb_matricula.mtr_id,
		  tb_matricula.codigoinscripcion,
		  tb_inscripcion.ins_carnet,
		  tb_matricula.mtr_apel_paterno,
		  tb_matricula.mtr_apel_materno,
		  tb_matricula.mtr_nombres,
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
		  estado
		ORDER BY
		  ponderado DESC",$data);
		return $qry->result();
	}

	
}