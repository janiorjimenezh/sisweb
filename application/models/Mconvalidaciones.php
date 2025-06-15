<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mconvalidaciones extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_itinerarios($data)
    {
        $result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo id,
                  tb_unidad_didactica.undd_nombre uninom,
                  tb_unidad_didactica.undd_tipo_mod unitip,
                  tb_unidad_didactica.codigociclo idcic,
                  tb_ciclo.cic_nombre cicnom,
                  tb_unidad_didactica.codigomodulo idmod,
                  tb_modulo_educativo.mod_nombre modnom,
                  tb_unidad_didactica.undd_horas_sema_teor horter,
                  tb_unidad_didactica.undd_horas_sema_pract horprac,
                  tb_unidad_didactica.undd_horas_ciclo horcic,
                  tb_unidad_didactica.undd_creditos_teor credter,
                  tb_unidad_didactica.undd_creditos_pract credprac,
                  tb_unidad_didactica.undd_activo activo,
                  tb_plan_estudios.pln_id as idplan,
                  tb_plan_estudios.pln_nombre as plan,
                  tb_plan_estudios.codigocarrera as codcarrera 
                FROM
                  tb_modulo_educativo
                  INNER JOIN tb_unidad_didactica ON (tb_modulo_educativo.mod_codigo = tb_unidad_didactica.codigomodulo)
                  INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
                  INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
                WHERE 
                  tb_plan_estudios.pln_id = ? AND
                  tb_plan_estudios.codigocarrera = ? AND 
                  tb_unidad_didactica.codigociclo <> '00'
                ORDER BY tb_ciclo.cic_codigo,tb_unidad_didactica.undd_nombre", $data);
        return $result->result();
    }

    public function m_get_cursos_matricula_xinscripcion($data)
    {
        $array_text = array($data[0],$data[0]);
        $result = $this->db->query("SELECT 
            tb_matricula_cursos_nota_final.mtcf_codigo AS id,
            tb_matricula_cursos_nota_final.mtcf_tipo AS tipo,
            tb_periodo.ped_nombre AS periodo,
            tb_matricula_cursos_nota_final.cod_plan_estudios AS codplan,
            tb_plan_estudios.pln_nombre AS plan,
            tb_carrera.car_sigla AS sigla,
            tb_carrera.car_nombre AS carrera,
            tb_ciclo.cic_nombre AS ciclo,
            tb_matricula_cursos_nota_final.codigoturno AS codturno,
            tb_turno.tur_nombre AS turno,
            tb_matricula_cursos_nota_final.codigoseccion AS codseccion,
            tb_matricula_cursos_nota_final.cod_subseccion AS subseccion,
            tb_matricula_cursos_nota_final.cod_unidad_didactica AS codcurso,
            tb_unidad_didactica.undd_nombre AS curso,
            tb_ciclound.cic_nombre AS ciclound,
            tb_matricula_cursos_nota_final.mtr_id AS matricula,
            tb_matricula_cursos_nota_final.mtcf_nota_final AS nota,
            tb_matricula_cursos_nota_final.mtcf_nota_recupera AS recuperacion,
            tb_matricula_cursos_nota_final.mtcf_culminado AS culminado,
            tb_matricula_cursos_nota_final.cod_carga_academica AS idcarga,
            tb_matricula_cursos_nota_final.mtcf_estado AS estado,
            tb_matricula_cursos_nota_final.mtcf_convalida_resolucion AS resolucion,
            tb_matricula_cursos_nota_final.mtcf_covalida_fecha AS feconvalida,
            tb_matricula_cursos_nota_final.cod_docente,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_matricula_cursos_nota_final.cod_miembro AS codmiembro,
            tb_matricula_cursos_nota_final.codigometodocalculo AS metodo,
            tb_matricula_cursos_nota_final.cod_sede as codsede,
            tb_sede.sed_abreviatura as sede_abrevia
          FROM
            tb_matricula_cursos_nota_final
            INNER JOIN tb_periodo ON (tb_matricula_cursos_nota_final.codigoperiodo = tb_periodo.ped_codigo)
            INNER JOIN tb_turno ON (tb_matricula_cursos_nota_final.codigoturno = tb_turno.tur_codigo)
            INNER JOIN tb_ciclo ON (tb_matricula_cursos_nota_final.codigociclo = tb_ciclo.cic_codigo)
            INNER JOIN tb_carrera ON (tb_matricula_cursos_nota_final.codigocarrera = tb_carrera.car_id)
            INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
            INNER JOIN tb_ciclo tb_ciclound ON (tb_unidad_didactica.codigociclo = tb_ciclound.cic_codigo)
            LEFT OUTER JOIN tb_docente ON (tb_matricula_cursos_nota_final.cod_docente = tb_docente.doc_codigo)
            LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
            LEFT OUTER JOIN tb_plan_estudios ON (tb_matricula_cursos_nota_final.cod_plan_estudios = tb_plan_estudios.pln_id)
            INNER JOIN tb_sede ON (tb_matricula_cursos_nota_final.cod_sede = tb_sede.id_sede)
            LEFT OUTER JOIN tb_matricula ON (tb_matricula_cursos_nota_final.mtr_id = tb_matricula.mtr_id)
          WHERE 
            tb_matricula.codigoinscripcion = ? OR tb_matricula_cursos_nota_final.codigoinscripcion = ?
          ORDER BY tb_matricula_cursos_nota_final.codigociclo,tb_unidad_didactica.undd_nombre ", $array_text);

        return $result->result();
    }

    


}

