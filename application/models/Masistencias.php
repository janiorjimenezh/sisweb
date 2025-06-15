<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Masistencias extends CI_Model
{
	function __construct()
	{
	parent::__construct();
	}
	public function m_fechas_x_curso($data)
    {
        ///////$this->load->database();
        $resultdoce = $this->db->query("SELECT
                  tb_carga_sesiones.ses_fecha fecha,
                  tb_carga_sesiones.ses_horaini inicia,
                  tb_carga_sesiones.ses_id sesion
                FROM
                  tb_carga_sesiones
                WHERE
                  tb_carga_sesiones.codigocarga=? AND  tb_carga_sesiones.codigosubseccion=? 
                 order by tb_carga_sesiones.ses_fecha,tb_carga_sesiones.ses_horaini", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }

    public function m_fechas_x_curso_sesion($data)
    {
        ///////$this->load->database();
        $resultdoce = $this->db->query("SELECT
                  tb_carga_sesiones.ses_fecha fecha,
                  tb_carga_sesiones.ses_horaini inicia,
                  tb_carga_sesiones.ses_id sesion
                FROM
                  tb_carga_sesiones
                WHERE
                  tb_carga_sesiones.ses_id =? ", $data);
        //////$this->db->close();
        return $resultdoce->result();
    }



	 public function m_asistencias_x_curso($data)
    {

        /////$this->load->database();
        $resultdoce = $this->db->query("SELECT 
                  tb_carga_asistencia.acu_id AS id,
                  tb_carga_asistencia.idmiembro,
                  tb_carga_asistencia.acu_fecha AS fecha,
                  tb_carga_asistencia.acu_accion AS accion,
                  tb_carga_asistencia.idsesion AS sesion,
                  tb_justificacion.jus_codigo as codjustificacion,
                  tb_justificacion.jus_fecha_recepcion as jstf_fecha_recepcion,
                  tb_justificacion.cod_motivo_justificacion as jstf_codmotivo,
                  tb_justificacion_motivo.jumo_nombre as jstf_motivo,
                  tb_justificacion.just_descripcion as jstf_descripcion,
                  tb_persona.per_apel_paterno as jstf_recepciona_paterno,
                  tb_persona.per_apel_materno as jstf_recepciona_materno,
                  tb_persona.per_nombres as jstf_recepciona_nombres  
                FROM
                  tb_carga_asistencia
                  LEFT OUTER JOIN tb_justificacion ON (tb_carga_asistencia.jus_codjustificacion = tb_justificacion.jus_codigo)
                  LEFT OUTER JOIN tb_justificacion_motivo ON (tb_justificacion.cod_motivo_justificacion = tb_justificacion_motivo.jumo_codigo)
                  LEFT OUTER JOIN tb_usuario ON (tb_justificacion.usu_codusuario_receptor = tb_usuario.id_usuario)
                  LEFT OUTER JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
                WHERE
                  tb_carga_asistencia.codigocarga=? AND  tb_carga_asistencia.codigosubseccion=? 
                ORDER BY tb_carga_asistencia.acu_fecha,tb_carga_asistencia.idmiembro", $data);
        ////$this->db->close();
        return $resultdoce->result();
    }

     public function m_asistencias_x_curso_sesion($data)
    {
        $resultdoce = $this->db->query("SELECT 
                  tb_carga_asistencia.acu_id AS id,
                  tb_carga_asistencia.idmiembro,
                  tb_carga_asistencia.acu_fecha AS fecha,
                  tb_carga_asistencia.acu_accion AS accion,
                  tb_carga_asistencia.idsesion AS sesion,
                  tb_justificacion.jus_codigo as codjustificacion,
                  tb_justificacion.jus_fecha_recepcion as jstf_fecha_recepcion,
                  tb_justificacion.cod_motivo_justificacion as jstf_codmotivo,
                  tb_justificacion_motivo.jumo_nombre as jstf_motivo,
                  tb_justificacion.just_descripcion as jstf_descripcion,
                  tb_persona.per_apel_paterno as jstf_recepciona_paterno,
                  tb_persona.per_apel_materno as jstf_recepciona_materno,
                  tb_persona.per_nombres as jstf_recepciona_nombres  
                FROM
                  tb_carga_asistencia
                  LEFT OUTER JOIN tb_justificacion ON (tb_carga_asistencia.jus_codjustificacion = tb_justificacion.jus_codigo)
                  LEFT OUTER JOIN tb_justificacion_motivo ON (tb_justificacion.cod_motivo_justificacion = tb_justificacion_motivo.jumo_codigo)
                  LEFT OUTER JOIN tb_usuario ON (tb_justificacion.usu_codusuario_receptor = tb_usuario.id_usuario)
                  LEFT OUTER JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
                WHERE
                  tb_carga_asistencia.idsesion=? ", $data);
        ////$this->db->close();
        return $resultdoce->result();
    }

     public function m_guardar_asistencia($datainsert, $dataupdate)
    {
        /////$this->load->database();
        //CALL painsertar_asistencia_accion( @vcca, @vssc, @vfecha, @vidmiembro, @vaccion, @s);
      $idsn=array();
        foreach ($datainsert as $key => $data) {
            //CALL painsertar_asistencia_accion( @vcca, @vfecha, @vidmiembro, @vaccion, @vidsesion, @s);
            $this->db->query("CALL sp_tb_carga_asistencia_insert(?,?,?,?,?,?,@s)", array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]));
            $res = $this->db->query('select @s as out_param');

            $idsn[$data[6]] = $res->row()->out_param;
        }
        $ar['idsnew'] = $idsn;
        foreach ($dataupdate as $key => $data) {
            $this->db->query("CALL sp_tb_carga_asistencia_accion_update(?,?,@s)", $data);
        }

        //$res = $this->db->query('select @s as out_param');
        ////$this->db->close();
        return $ar;
    }

    public function m_asistencias_x_grupo($data)
    {
        $sqltext_array=array();
        $data_array=array();
        if ($data[0]!="%") {
          $sqltext_array[]="tb_carga_academica.cod_sede = ?";
          $data_array[]=$data[0];
        } 
        if ($data[1]!="%") {
          $sqltext_array[]="tb_carga_academica.codigoperiodo = ?";
          $data_array[]=$data[1];
        } 
        if ($data[2]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigocarrera = ?";
          $data_array[]=$data[2];
        }
        if ($data[3]!="%")  {
          $sqltext_array[]="tb_modulo_educativo.codigoplan = ?";
          $data_array[]=$data[3];
        }
        if ($data[4]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigociclo = ?";
          $data_array[]=$data[4];
        }
        if ($data[5]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigoturno = ?";
          $data_array[]=$data[5];
        }
        if ($data[6]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigoseccion = ?";
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
        if ($data[9]!="%")  {
          $sqltext_array[]="tb_carga_academica.codigouindidadd = ?";
          $data_array[]=$data[9];
        }
        if ($data[10]!="%%")  {
          $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
          $data_array[]=$data[10];
        }
        $sqltext_array[] = "tb_carga_academica.cac_activo = 'SI'";
        $sqltext_array[] = "tb_carga_subseccion_miembros.csm_eliminado = 'NO'";
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        /////$this->load->database();
        $resultdoce = $this->db->query("SELECT 
          tb_inscripcion.ins_carnet as carne,
          tb_persona.per_tipodoc as tipodoc,
          tb_persona.per_dni as nrodoc,
          tb_persona.per_apel_paterno as paterno,
          tb_persona.per_apel_materno as materno,
          tb_persona.per_nombres as nombres,
          tb_persona.per_sexo as sexo,
          tb_carga_academica.codigoperiodo as codperiodo,
          tb_periodo.ped_nombre as periodo,
          tb_carga_academica.codigocarrera as codcarrera,
          tb_carrera.car_nombre as carrera,
          tb_carga_academica.codigociclo as codciclo,
          tb_ciclo.cic_nombre as ciclo,
          tb_carga_academica.codigoturno as codturno,
          tb_turno.tur_nombre as turno,
          tb_carga_academica.codigoseccion as codseccion,
          tb_seccion.sec_nombre as seccion,
          tb_carga_academica.cac_id as codcargaacademica,
          tb_carga_academica.codigouindidadd as codcurso,
          tb_unidad_didactica.undd_nombre as curso,
          tb_carga_academica.cod_sede as codsede,
          tb_sede.sed_nombre as sede,
          tb_sede.sed_abreviatura as sede_abrevia,
          tb_carga_academica_subseccion.codigosubseccion as subseccion,
          tb_carga_academica_subseccion.cas_nrosesiones AS sesiones,
          tb_modulo_educativo.codigoplan as codplan, 
          sum(case when tb_carga_asistencia.acu_accion = 'A' then 1 else 0 end) AS asiste,
          sum(case when tb_carga_asistencia.acu_accion = 'F' then 1 else 0 end) AS faltas,
          sum(case when tb_carga_asistencia.acu_accion = 'T' then 1 else 0 end) AS tarde,
          sum(case when tb_carga_asistencia.acu_accion = 'J' then 1 else 0 end) AS justif
        FROM
          tb_carga_subseccion_miembros
        INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
        INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
        AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
        INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
        INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
        INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
        INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
        INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
        INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
        INNER JOIN tb_seccion ON (tb_carga_academica.codigoseccion = tb_seccion.sec_codigo)
        INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
        INNER JOIN tb_inscripcion ON (tb_matricula.codigoinscripcion = tb_inscripcion.ins_identificador)
        INNER JOIN tb_persona ON (tb_inscripcion.cod_persona = tb_persona.per_codigo)
        INNER JOIN tb_carga_sesiones ON (tb_carga_academica_subseccion.codigosubseccion_aula = tb_carga_sesiones.codigosubseccion)
        AND (tb_carga_academica_subseccion.codigocargaacademica_aula = tb_carga_sesiones.codigocarga)
        LEFT OUTER JOIN tb_carga_asistencia ON (tb_carga_sesiones.ses_id = tb_carga_asistencia.idsesion)
        AND (tb_carga_subseccion_miembros.csm_id = tb_carga_asistencia.idmiembro)
        INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)

        $sqltext
        GROUP BY
          tb_inscripcion.ins_carnet,
          tb_persona.per_tipodoc,
          tb_persona.per_dni,
          tb_persona.per_apel_paterno,
          tb_persona.per_apel_materno,
          tb_persona.per_nombres,
          tb_persona.per_sexo,
          tb_carga_academica.codigoperiodo,
          tb_periodo.ped_nombre,
          tb_carga_academica.codigocarrera,
          tb_carrera.car_nombre,
          tb_carga_academica.codigociclo,
          tb_ciclo.cic_nombre,
          tb_carga_academica.codigoturno,
          tb_turno.tur_nombre,
          tb_carga_academica.codigoseccion,
          tb_seccion.sec_nombre,
          tb_carga_academica.cac_id,
          tb_carga_academica.codigouindidadd,
          tb_unidad_didactica.undd_nombre,
          tb_carga_academica.cod_sede,
          tb_sede.sed_nombre,
          tb_sede.sed_abreviatura,
          tb_carga_academica_subseccion.codigosubseccion,
          tb_modulo_educativo.codigoplan,
          tb_carga_academica_subseccion.cas_nrosesiones
        ORDER BY
          tb_carga_academica.cod_sede,
          tb_carga_academica.codigoperiodo,
          tb_carga_academica.codigocarrera,
          tb_modulo_educativo.codigoplan,
          tb_carga_academica.codigociclo,
          tb_carga_academica.codigoturno,
          tb_carga_academica.codigoseccion,
          tb_carga_academica.codigouindidadd,
          tb_carga_academica_subseccion.codigosubseccion,
          tb_persona.per_apel_paterno,
          tb_persona.per_apel_materno,
          tb_persona.per_nombres", $data_array);
        ////$this->db->close();
        return $resultdoce->result();
    }
    

	}