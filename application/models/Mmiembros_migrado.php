<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmiembros_migrado extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
 
    // mtcf_codigo,
    // mtr_id,
    // mtcf_tipo,
    // codigoperiodo,
    // codigocarrera,
    // cod_plan_estudios,
    // codigociclo,
    // codigoturno,
    // codigoseccion,
    // mtcf_fecha,
    // cod_carga_academica,
    // cod_subseccion,
    // cod_docente,
    // cod_unidad_didactica,
    // mtcf_convalida_resolucion,
    // mtcf_covalida_fecha,
    // mtcf_nota_final,
    // mtcf_nota_recupera,
    // mtr_observacion,
    // id_usuario,
    // cod_sede,
    // mtcf_culminado,
    // mtcf_estado,
    // mtcf_repitencia,
    // cod_miembro,
    // mtcf_fecha_migracion,
    // codigometodocalculo,
    // codigoinscripcion
    public function m_update($id,$data)
    {  
      $this->db->where('mtcf_codigo', $id);
      $rs=$this->db->update('tb_matricula_cursos_nota_final', $data);
      $rp = new stdClass;
      $rp->codigo=$id;
      $rp->countRows=$this->db->affected_rows();
      $rp->salida=($rp->countRows==0) ? 0 : 1;
      return $rp;
    }


    public function m_updateWhere($where, $data)
    {
        $this->db->where($where);  // Utilizamos el array asociativo en 'where' para aplicar múltiples condiciones
        $rs = $this->db->update('tb_matricula_cursos_nota_final', $data);
        
        // Creamos el objeto de salida
        $rp = new stdClass;
        $rp->where = $where;  // Para saber qué condiciones se usaron en la actualización
        $rp->countRows = $this->db->affected_rows();  // Número de filas afectadas por la actualización
        $rp->salida = ($rp->countRows == 0) ? 0 : 1;  // Si no se actualizaron filas, salida = 0, sino = 1
        
        return $rp;
    }

    public function m_getMiembros_notasFinalesMigradas($data)
    {
        //DEPENDE DE LAS NOTAS REGISTRADAS tb_matricula_cursos_nota_final
        $sqltext_array=array();
        $data_array=array();

        
        if (isset($data['codnotamigrada']) and ($data['codnotamigrada']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.mtcf_codigo = ?";
        $data_array[]=$data['codnotamigrada'];
        } 
        if (isset($data['codunidad']) and ($data['codunidad']!="%")) {
          $sqltext_array[]="tb_matricula_cursos_nota_final.cod_unidad_didactica = ?";
          $data_array[]=$data['codunidad'];
        }    
        if (isset($data['codinscripcion']) and ($data['codinscripcion']!="%")) {
          $sqltext_array[]="tb_matricula_cursos_nota_final.codigoinscripcion = ?";
          $data_array[]=$data['codinscripcion'];
        }        
        if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.cod_sede = ?";
        $data_array[]=$data['codsede'];
        } 
        if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigoperiodo = ?";
        $data_array[]=$data['codperiodo'];
        } 
        if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigocarrera = ?";
        $data_array[]=$data['codcarrera'];
        } 
        if (isset($data['codplan']) and ($data['codplan']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.cod_plan_estudios = ?";
        $data_array[]=$data['codplan'];
        } 
        if (isset($data['codturno']) and ($data['codturno']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigoturno = ?";
        $data_array[]=$data['codturno'];
        }
        if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigociclo = ?";
        $data_array[]=$data['codciclo'];
        }
        if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigoseccion = ?";
        $data_array[]=$data['codseccion'];
        }
        
        if (isset($data['codestado']) and ($data['codestado']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.mtcf_estado = ?";
        $data_array[]=$data['codestado'];
        } 
        
        if (isset($data['codmatricula']) and ($data['codmatricula']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.mtr_id =?";
        $data_array[]=$data['codmatricula'];
        }
        if (isset($data['codcarga']) and ($data['codcarga']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.cod_carga_academica=?";
        $data_array[]=$data['codcarga'];
        }
        if (isset($data['codsubseccion']) and ($data['codsubseccion']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.cod_subseccion=?";
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
              tb_matricula_cursos_nota_final.codigoinscripcion AS codinscripcion_migrada,
              tb_matricula_cursos_nota_final.mtr_id AS codmatricula_migrada,
              tb_carga_subseccion_miembros.csm_id AS codmiembro_plataforma,
              tb_carga_subseccion_miembros.csm_nota_final AS notafin_plataforma,
              tb_carga_subseccion_miembros.csm_nota_recuperacion AS notarecuperacion_plataforma,
              tb_carga_subseccion_miembros.cod_cargaacademica AS codcarga_plataforma,
              tb_carga_subseccion_miembros.cod_subseccion AS codsubseccion_plataforma,
              tb_carga_subseccion_miembros.csm_estado AS estadomiembro_plataforma,
              tb_carga_subseccion_miembros.csm_eliminado AS eliminado_plataforma,
              tb_carga_subseccion_miembros.csm_repitencia AS repitencia_plataforma,
              tb_carga_academica_subseccion.codigodocente AS coddocente,
              tb_carga_academica_subseccion.cas_culminado AS culminado,
              tb_carga_academica_subseccion.cas_nrosesiones AS nrosesiones_plataforma,
              tb_matricula_cursos_nota_final.mtcf_codigo AS codnotamigrada,
              tb_matricula_cursos_nota_final.cod_carga_academica AS codcarga_migrada,
              tb_matricula_cursos_nota_final.cod_subseccion AS codsubseccion_migrada,
              tb_matricula_cursos_nota_final.mtcf_estado AS estado_migrada,
              tb_matricula_cursos_nota_final.mtcf_tipo AS origentipo_migrada,
              tb_matricula_cursos_nota_final.mtcf_nota_final AS notafin_migrada,
              tb_matricula_cursos_nota_final.mtcf_nota_recupera AS notarecuperacion_migrada,
              tb_unidad_didactica.undd_nombre AS unidad_migrada,
              tb_unidad_didactica.codigociclo AS codciclo_unidad_migrada,
              tb_ciclo.cic_nombre AS ciclo_unidad_migrada,
              tb_matricula_cursos_nota_final.codigometodocalculo AS metodocalculo_migrada,
              tb_matricula_cursos_nota_final.cod_docente AS codocente_migrada,
              tb_persona.per_apel_paterno AS doc_paterno_migrada,
              tb_persona.per_apel_materno AS doc_materno_migrada,
              tb_persona.per_nombres AS doc_nombres_migrada,
              tb_carga_academica.cod_sede AS codsede,
              tb_sede.sed_nombre AS sede,
              tb_sede.sed_abreviatura AS sede_abrevia,
              tb_matricula_cursos_nota_final.cod_unidad_didactica AS codunidad_migrada,
              tb_matricula_cursos_nota_final.mtcf_veces AS veces_migrada,
              tb_carga_academica.codigoperiodo as codperiodo,
              tb_periodo.ped_nombre as periodo,
              tb_carga_academica.codigocarrera as codcarrera,
              tb_carrera.car_sigla as carrera_sigla,
              tb_carga_academica.codigociclo as codciclo,
              tb_ciclo1.cic_nombre as ciclo,
              tb_carga_academica.codigoturno as codturno,
              tb_carga_academica.codigoseccion as codseccion,
              tb_unidad_didactica1.codigomodulo as codmodulo,
              tb_modulo_educativo.mod_nombre as modulo,
              tb_modulo_educativo.codigoplan as codplan,
              tb_plan_estudios.pln_nombre as plan,
              tb_unidad_didactica1.undd_nombre as unidad,
              tb_matricula_cursos_nota_final.mtcf_codigo_recuperador as recuperador,
              tb_matricula_cursos_nota_final.mtcf_codigo_recuperado as recuperado,
              tb_matricula_cursos_nota_final.mtcf_estado_final as estadofinal
        
            FROM
              tb_matricula_cursos_nota_final
              LEFT OUTER JOIN tb_carga_subseccion_miembros ON (tb_matricula_cursos_nota_final.cod_miembro = tb_carga_subseccion_miembros.csm_id)
              LEFT OUTER JOIN tb_carga_academica_subseccion ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_carga_academica_subseccion.codigocargaacademica)
              AND (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_academica_subseccion.codigosubseccion)
              LEFT OUTER JOIN tb_docente ON (tb_matricula_cursos_nota_final.cod_docente = tb_docente.doc_codigo)
              INNER JOIN tb_unidad_didactica ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
              LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
              LEFT OUTER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica_aula = tb_carga_academica.cac_id)
              LEFT OUTER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
              INNER JOIN tb_ciclo ON (tb_unidad_didactica.codigociclo = tb_ciclo.cic_codigo)
              LEFT OUTER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
              LEFT OUTER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
              LEFT OUTER JOIN tb_ciclo tb_ciclo1 ON (tb_carga_academica.codigociclo = tb_ciclo1.cic_codigo)
              LEFT OUTER JOIN tb_unidad_didactica tb_unidad_didactica1 ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica1.undd_codigo)
              LEFT OUTER JOIN tb_modulo_educativo ON (tb_unidad_didactica1.codigomodulo = tb_modulo_educativo.mod_codigo)
              LEFT OUTER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
            $sqltext
            ORDER BY
              tb_unidad_didactica.codigociclo,
              tb_unidad_didactica.undd_nombre", $data_array);
        return $result->result();
    }

    public function m_getMiembros_Migrados($data)
    {
        //DEPENDE DE LAS NOTAS REGISTRADAS tb_matricula_cursos_nota_final
        $sqltext_array=array();
        $data_array=array();

        if (isset($data['codnotamigrada']) and ($data['codnotamigrada']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.mtcf_codigo = ?";
        $data_array[]=$data['codnotamigrada'];
        } 

        if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.cod_sede = ?";
        $data_array[]=$data['codsede'];
        } 
        if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigoperiodo = ?";
        $data_array[]=$data['codperiodo'];
        } 
        if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigocarrera = ?";
        $data_array[]=$data['codcarrera'];
        } 
        if (isset($data['codplan']) and ($data['codplan']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.cod_plan_estudios = ?";
        $data_array[]=$data['codplan'];
        } 
        if (isset($data['codturno']) and ($data['codturno']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigoturno = ?";
        $data_array[]=$data['codturno'];
        }
        if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigociclo = ?";
        $data_array[]=$data['codciclo'];
        }
        if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.codigoseccion = ?";
        $data_array[]=$data['codseccion'];
        }
        
        if (isset($data['codestado']) and ($data['codestado']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.mtcf_estado = ?";
        $data_array[]=$data['codestado'];
        } 
        
        if (isset($data['codmatricula']) and ($data['codmatricula']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.mtr_id =?";
        $data_array[]=$data['codmatricula'];
        }
        if (isset($data['codcarga']) and ($data['codcarga']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.cod_carga_academica=?";
        $data_array[]=$data['codcarga'];
        }
        if (isset($data['codsubseccion']) and ($data['codsubseccion']!="%")) {
        $sqltext_array[]="tb_matricula_cursos_nota_final.cod_subseccion=?";
        $data_array[]=$data['codsubseccion'];
        }
        // if (isset($data['culminado']) and ($data['culminado']!="%")) {
        // $sqltext_array[]="tb_carga_academica_subseccion.cas_culminado=?";
        // $data_array[]=$data['culminado'];
        // }
        // if (isset($data['eliminado']) and ($data['eliminado']!="%")) {
        // $sqltext_array[]="tb_carga_subseccion_miembros.csm_eliminado=?";
        // $data_array[]=$data['eliminado'];
        // }



        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
            tb_matricula_cursos_nota_final.codigoperiodo AS codperiodo,
            tb_matricula.mtr_id AS codmatricula,
            tb_inscripcion.ins_carnet AS carne,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_persona.per_fecha_nacimiento AS fechanacimiento,
            tb_persona.per_tipodoc AS codtipodoc,
            tb_persona.per_dni AS numero,
            COUNT(tb_matricula_cursos_nota_final.mtcf_codigo) AS nro_cursos,
            tb_matricula_cursos_nota_final.cod_sede AS codsede,
            tb_matricula_cursos_nota_final.codigocarrera as codcarrera,
            tb_matricula_cursos_nota_final.cod_plan_estudios as codplan,
            tb_matricula_cursos_nota_final.codigociclo as codciclo,
            tb_matricula_cursos_nota_final.codigoturno as codturno,
            tb_matricula_cursos_nota_final.codigoseccion as codseccion
          FROM
            tb_matricula_cursos_nota_final
            INNER JOIN tb_matricula ON (tb_matricula_cursos_nota_final.mtr_id = tb_matricula.mtr_id)
            INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
            INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
          GROUP BY
            tb_matricula_cursos_nota_final.codigoperiodo,
            tb_matricula.mtr_id,
            tb_inscripcion.ins_carnet,
            tb_persona.per_apel_paterno,
            tb_persona.per_apel_materno,
            tb_persona.per_nombres,
            tb_persona.per_sexo,
            tb_persona.per_fecha_nacimiento,
            tb_persona.per_tipodoc,
            tb_persona.per_dni,
            tb_matricula_cursos_nota_final.cod_sede,
            tb_matricula_cursos_nota_final.codigocarrera,
            tb_matricula_cursos_nota_final.cod_plan_estudios,
            tb_matricula_cursos_nota_final.codigociclo,
            tb_matricula_cursos_nota_final.codigoturno,
            tb_matricula_cursos_nota_final.codigoseccion", $data_array);
        return $result->result();
    }


        public function m_getTotalRepiteCursos($data)
          {
            $array_text = array($data[0],$data[0]);
            $result = $this->db->query("SELECT 
                  tb_unidad_didactica.undd_codigo as idunidad,
                  tb_unidad_didactica.undd_nombre as nombre,
                  COUNT(tb_matricula_cursos_nota_final.cod_unidad_didactica) AS nrounidad
                FROM
                  tb_unidad_didactica
                  INNER JOIN tb_matricula_cursos_nota_final ON (tb_matricula_cursos_nota_final.cod_unidad_didactica = tb_unidad_didactica.undd_codigo)
                  LEFT OUTER JOIN tb_matricula ON (tb_matricula.mtr_id = tb_matricula_cursos_nota_final.mtr_id)
                WHERE
                  tb_matricula.codigoinscripcion = ? OR tb_matricula_cursos_nota_final.codigoinscripcion = ?
                GROUP BY
                  tb_unidad_didactica.undd_codigo,
                  tb_unidad_didactica.undd_nombre", $array_text);
            return $result->result();
          }


}