<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdocentes extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //POR JANIOR
    public function m_get_docentes()
    {
          $result = $this->db->query("SELECT 
              tb_persona.per_codigo codpersona,
              tb_docente.doc_codigo coddocente,
              tb_persona.per_apel_paterno paterno,
              tb_persona.per_apel_materno materno,
              tb_persona.per_nombres nombres,
              tb_persona.per_sexo sexo,
              tb_docente.doc_activo activo
            FROM
              tb_docente
              LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo) 
            WHERE tb_docente.doc_tipo<>'AD' 
            order by  tb_persona.per_apel_paterno,tb_persona.per_nombres");
        return $result->result();
    }

  public function m_get_docentes_administrativos()
  {
        $result = $this->db->query("SELECT 
            tb_persona.per_codigo codpersona,
            tb_docente.doc_codigo coddocente,
            CONCAT(tb_persona.per_apel_paterno,' ',
            tb_persona.per_apel_materno,' ',
            tb_persona.per_nombres) nombres,
            tb_persona.per_sexo sexo,
            tb_docente.doc_activo activo
          FROM
            tb_docente
            LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo) 
          WHERE tb_docente.doc_tipo <> 'DC' AND tb_docente.doc_activo = 'SI'
          order by  tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres");
      return $result->result();
  }
  
  public function get_datos_personales($data){
    $result=$this->db->query("SELECT 
        tb_persona.per_codigo AS idpersona,
        tb_persona.per_codigo_sec AS codpersona,
        tb_persona.per_tipodoc AS tipodoc,
        tb_persona.per_dni AS numero,
        tb_persona.per_apel_paterno AS paterno,
        tb_persona.per_apel_materno AS materno,
        tb_persona.per_nombres AS nombres,
        tb_persona.per_sexo AS sexo,
        tb_persona.per_fecha_nacimiento AS fecnac,
        tb_persona.per_celular AS celular,
        tb_persona.per_telefono AS telefono,
        tb_persona.per_email_personal AS epersonal,
        tb_persona.per_domicilio AS domicilio,
        tb_persona.cod_distrito AS coddistrito,
        tb_distrito.cod_provincia AS codprovincia,
        tb_provincia.cod_departamento AS coddepartamento,
        tb_persona.per_domicilio_secundario AS domiciliosecu,
        tb_persona.per_foto AS foto,
        tb_docente.doc_codigo AS coddocente,
        tb_docente.doc_emailc AS einstitucional,
        tb_docente.doc_activo AS activo,
        tb_docente.doc_tipo AS tipo,
        tb_docente.doc_cargo AS cargo,
        tb_persona.cod_pais as pais
      FROM
        tb_persona
        INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
        INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        LEFT OUTER JOIN tb_docente ON (tb_persona.per_codigo = tb_docente.cod_persona)
      WHERE tb_persona.per_dni=?;",$data);
    $rslogin=$result->row();
    return   $rslogin;  
  }

  public function get_datos_completos_xdni($data){
    $result=$this->db->query("SELECT 
        tb_persona.per_codigo AS idpersona,
        tb_persona.per_codigo_sec AS codpersona,
        tb_persona.per_tipodoc AS tipodoc,
        tb_persona.per_dni AS numero,
        tb_persona.per_apel_paterno AS paterno,
        tb_persona.per_apel_materno AS materno,
        tb_persona.per_nombres AS nombres,
        tb_persona.per_estadocivil AS estadocivil,
        tb_persona.per_sexo AS sexo,
        tb_persona.per_fecha_nacimiento AS fecnac,
        tb_persona.per_lugar_nacimiento AS lugnac,
        tb_persona.per_celular AS celular,
        tb_persona.per_telefono AS telefono,
        tb_persona.per_celular2 AS celular2,
        tb_persona.per_email_personal AS epersonal,
        tb_persona.per_domicilio AS domicilio,
        tb_persona.cod_distrito AS coddistrito,
        tb_distrito.cod_provincia AS codprovincia,
        tb_provincia.cod_departamento AS coddepartamento,
        tb_persona.per_domicilio_secundario AS domiciliosecu,
        tb_persona.per_foto AS foto,
        tb_persona.per_trabaja AS statrab,
        tb_persona.per_lugar_trabaja AS lugar_trab,
        tb_persona.ins_colegio_5to_sec AS colsecund,
        tb_persona.per_padre_apel_paterno AS apepapa,
        tb_persona.per_padre_ocupacion AS ocupapadre,
        tb_persona.per_madre_apel_paterno AS apemama,
        tb_persona.per_madre_ocupacion AS ocupamadre,
        tb_persona.cod_pais AS pais,
        tb_docente.doc_emailc AS ecorporativo,
        tb_docente.doc_tipo AS tipo,
        tb_docente.doc_cargo AS cargo,
        tb_docente.doc_codigo AS codtrabajador,
        tb_usuario.usu_nick AS usuario,
        tb_usuario.usu_email_corporativo AS einstitucional,
        tb_usuario.usu_nivel AS mivel,
        tb_usuario.area_id AS codarea,
        tb_usuario.usu_tipo AS tipousu,
        tb_docente.ins_sede AS sede,
        tb_sede.sed_nombre as nomsede
      FROM
        tb_persona
        INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
        INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        LEFT OUTER JOIN tb_docente ON (tb_persona.per_codigo = tb_docente.cod_persona)
        LEFT OUTER JOIN tb_usuario ON (tb_docente.doc_codigo = tb_usuario.usu_codente)
        AND (tb_docente.doc_tipo = tb_usuario.usu_tipo)
        LEFT OUTER JOIN tb_sede ON (tb_docente.ins_sede = tb_sede.id_sede)
      WHERE
        tb_persona.per_dni = ?;",$data);
    $rslogin=$result->row();
    return   $rslogin;  
  }

  public function get_datos_completos_administrativos($data)
  {
    $result=$this->db->query("SELECT 
        tb_persona.per_codigo AS idpersona,
        tb_persona.per_codigo_sec AS codpersona,
        tb_persona.per_tipodoc AS tipodoc,
        tb_persona.per_dni AS numero,
        tb_persona.per_apel_paterno AS paterno,
        tb_persona.per_apel_materno AS materno,
        tb_persona.per_nombres AS nombres,
        tb_persona.per_estadocivil AS estadocivil,
        tb_persona.per_sexo AS sexo,
        tb_persona.per_fecha_nacimiento AS fecnac,
        tb_persona.per_lugar_nacimiento AS lugnac,
        tb_persona.per_celular AS celular,
        tb_persona.per_telefono AS telefono,
        tb_persona.per_celular2 AS celular2,
        tb_persona.per_email_personal AS epersonal,
        tb_persona.per_domicilio AS domicilio,
        tb_persona.cod_distrito AS coddistrito,
        tb_distrito.dis_nombre as distrito,
        tb_distrito.cod_provincia AS codprovincia,
        tb_provincia.prv_nombre as provincia,
        tb_provincia.cod_departamento AS coddepartamento,
        tb_departamento.dep_nombre as departamento,
        tb_persona.per_domicilio_secundario AS domiciliosecu,
        tb_persona.cod_pais AS pais,
        tb_docente.doc_emailc AS ecorporativo,
        tb_docente.doc_tipo AS tipo,
        tb_docente.doc_cargo AS cargo,
        tb_docente.doc_codigo AS codtrabajador,
        tb_area.are_nombre as area,
        tb_docente.ins_sede AS sede,
        tb_sede.sed_abreviatura AS sede_abrevia
      FROM
        tb_persona
        INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
        INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
        INNER JOIN tb_docente ON (tb_persona.per_codigo = tb_docente.cod_persona)
        INNER JOIN tb_area ON (tb_docente.cod_idarea = tb_area.are_codigo)
        LEFT OUTER JOIN tb_sede ON (tb_docente.ins_sede = tb_sede.id_sede)
      WHERE concat(tb_persona.per_dni, ' ',tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno ,' ',tb_persona.per_nombres) like ?
        AND tb_docente.ins_sede like ? AND tb_docente.doc_activo like ?
        order by  tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres",$data);
    
    return  $result->result();
  }

  public function get_datos_docente($data){
      $result=$this->db->query("SELECT 
        tb_persona.per_codigo AS idpersona,
        tb_persona.per_codigo_sec AS codpersona,
        tb_persona.per_tipodoc AS tipodoc,
        tb_persona.per_dni AS numero,
        tb_persona.per_apel_paterno AS paterno,
        tb_persona.per_apel_materno AS materno,
        tb_persona.per_nombres AS nombres,
        tb_persona.per_estadocivil AS estadocivil,
        tb_persona.per_sexo AS sexo,
        tb_persona.per_fecha_nacimiento AS fecnac,
        tb_persona.per_lugar_nacimiento AS lugnac,
        tb_persona.per_celular AS celular,
        tb_persona.per_telefono AS telefono,
        tb_persona.per_celular2 AS celular2,
        tb_persona.per_email_personal AS epersonal,
        tb_persona.per_domicilio AS domicilio,
        tb_persona.cod_distrito AS coddistrito,
        tb_distrito.cod_provincia AS codprovincia,
        tb_provincia.cod_departamento AS coddepartamento,
        tb_persona.per_domicilio_secundario AS domiciliosecu,
        tb_persona.cod_pais AS pais,
        tb_persona.per_foto AS foto,
        tb_docente.doc_emailc AS ecorporativo,
        tb_docente.doc_tipo AS tipo,
        tb_docente.doc_cargo AS cargo,
        tb_docente.doc_codigo AS codtrabajador,
        tb_usuario.usu_nick AS usuario,
        tb_usuario.usu_email_corporativo AS einstitucional,
        tb_usuario.usu_nivel AS mivel,
        tb_usuario.area_id AS codarea,
        tb_usuario.usu_tipo AS tipousu
      FROM
        tb_persona
        INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
        INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        LEFT OUTER JOIN tb_docente ON (tb_persona.per_codigo = tb_docente.cod_persona)
        LEFT OUTER JOIN tb_usuario ON (tb_docente.doc_codigo = tb_usuario.usu_codente)
        AND (tb_docente.doc_tipo = tb_usuario.usu_tipo)
      WHERE
        tb_docente.doc_codigo = ?;",$data);
    $rslogin=$result->row();
    return   $rslogin;  
  }

    public function m_update($data){
          //CALL ( @vdoc_codigo, @doc_emailc, @doc_tipo, @vdoc_cargo, @s);
      $this->db->query("CALL sp_tb_docente_update(?,?,?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      //$this->db->close(); 
      return   $res->row()->out_param;
    }

  //CALL ( @vdoc_codigo, @vcod_persona, @doc_emailc, @doc_tipo, @vdoc_cargo, @s);
  public function m_insert($data){
    $this->db->query("CALL sp_tb_docente_insert(?,?,?,?,?,?,?,@s)",$data);
    $res = $this->db->query('select @s as out_param');
    //$this->db->close(); 
    return   $res->row()->out_param;  
  }

  
    public function m_filtrar_trabajadores($data)
    {
        $rscuentas=array();
        //$rsdeudas=array();
        $result = $this->db->query("SELECT 
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_foto AS foto,
          tb_persona.per_dni AS dni,
          tb_docente.cod_persona AS codpersona,
          tb_docente.doc_codigo AS codtrabajador,
          tb_docente.doc_emailc AS ecorporativo,
          tb_docente.doc_tipo as tipo,
          tb_docente.doc_activo as activo,
          tb_sede.sed_abreviatura as sed_sigla
        FROM
          tb_persona
          INNER JOIN  tb_docente ON (tb_persona.per_codigo=tb_docente.cod_persona )
          INNER JOIN tb_sede ON (tb_docente.ins_sede = tb_sede.id_sede)
        WHERE  concat(tb_persona.per_dni, ' ',tb_persona.per_apel_paterno, ' ',tb_persona.per_apel_materno ,' ',tb_persona.per_nombres) like ? 
        AND tb_docente.ins_sede like ? AND tb_docente.doc_activo like ?
        ORDER BY   tb_persona.per_apel_paterno, tb_persona.per_apel_materno, tb_persona.per_nombres " , $data);

          $rscuentas=$result->result();
        return array('trabajadores' => $rscuentas);
    }

    public function Update_activo_docente($data)
    {
        $this->db->query("UPDATE tb_docente SET tb_docente.doc_activo = ? WHERE tb_docente.doc_codigo = ?",$data);
        // $res = $this->db->query('select @s as salida');
        return 1;
    }

    public function m_docentes_x_periodo($data)
    {
        //$this->load->database();
        $resultmiembro = $this->db->query("SELECT 
            tb_docente.doc_codigo AS coddocente,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_docente.doc_emailc AS ecorporativo,
            count(tb_docente.doc_codigo) AS ctotal,
            sum(case when tb_carga_academica_subseccion.cas_culminado = 'NO' then 1 else 0 END) AS cactivos,
            tb_persona.per_tipodoc as tipodoc,
            tb_persona.per_dni as nrodoc,
            tb_persona.per_celular as celular,
            tb_persona.per_email_personal as epersonal,
            tb_docente.ins_sede as codsede,
            tb_sede.sed_nombre as sede
          FROM
            tb_persona
            INNER JOIN tb_docente ON (tb_persona.per_codigo = tb_docente.cod_persona)
            INNER JOIN tb_carga_academica_subseccion ON (tb_docente.doc_codigo = tb_carga_academica_subseccion.codigodocente)
            INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
            INNER JOIN tb_sede ON (tb_docente.ins_sede = tb_sede.id_sede)
          WHERE
            tb_carga_academica.codigoperiodo = ? AND 
            tb_carga_academica.cac_activo = 'SI'
          GROUP BY
            tb_docente.doc_codigo,
            tb_persona.per_apel_paterno,
            tb_persona.per_apel_materno,
            tb_persona.per_nombres,
            tb_persona.per_sexo,
            tb_docente.doc_emailc,
            tb_persona.per_tipodoc,
            tb_persona.per_dni,
            tb_persona.per_celular,
            tb_persona.per_email_personal,
            tb_docente.ins_sede,
            tb_sede.sed_nombre
          ORDER BY
            paterno,
            materno,
            nombres", $data);
        //$this->db->close();
        return $resultmiembro->result();
    }

    public function m_cursos_x_docente($data)
    {
        //$this->load->database();
        $resultado=array('docente'=>array(),'cursos'=>array());
        $rsdocente = $this->db->query("SELECT 
            tb_docente.doc_codigo AS coddocente,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres
          FROM
            tb_persona
            INNER JOIN tb_docente ON (tb_persona.per_codigo = tb_docente.cod_persona)
          WHERE
            tb_docente.doc_codigo = ? LIMIT 1", $data[0]);
      $resultado['docente']=$rsdocente->row();

      if (isset($resultado['docente'])){
          $rscursos = $this->db->query("SELECT 
            tb_carga_academica_subseccion.codigocargaacademica AS codcarga,
            tb_carga_academica_subseccion.codigosubseccion AS division,
            tb_carga_academica.codigoperiodo AS periodo,
            tb_carga_academica.codigouindidadd AS codcurso,
            tb_carga_academica.cac_activo as carga_activo,
            tb_unidad_didactica.undd_nombre AS curso,
            tb_carrera.car_sigla AS carrera,
            tb_carrera.car_nombre AS programa,
            tb_ciclo.cic_nombre AS ciclo,
            tb_turno.tur_nombre AS turno,
            tb_seccion.sec_nombre AS seccion,
            tb_carga_academica.cod_sede AS codsede,
            tb_sede.sed_abreviatura AS sede_abrevia,
            tb_carga_academica_subseccion.codigocargaacademica_aula as codcarga_principal,
            tb_carga_academica_subseccion.codigosubseccion_aula as division_principal,
            tb_carga_academica_subseccion1.codigosubseccion AS subseccion_principal,
            tb_carga_academica_subseccion1.cas_nrosesiones AS nsesiones_principal,
            tb_carga_academica_subseccion1.cas_culminado AS culmino_principal,
            tb_carga_academica_subseccion1.cas_activo AS activo_principal,
            tb_carga_academica_subseccion1.cas_avance_ses  AS nsesavance_principal
          FROM
            tb_carga_academica_subseccion
            INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
            INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
            INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
            INNER JOIN tb_seccion ON (tb_carga_academica.codigoseccion = tb_seccion.sec_codigo)
            INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
            INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
            INNER JOIN tb_carga_academica_subseccion tb_carga_academica_subseccion1 ON (tb_carga_academica_subseccion.codigocargaacademica_aula = tb_carga_academica_subseccion1.codigocargaacademica_aula)
            AND (tb_carga_academica_subseccion.codigocargaacademica_aula = tb_carga_academica_subseccion1.codigocargaacademica)
            AND (tb_carga_academica_subseccion.codigosubseccion_aula = tb_carga_academica_subseccion1.codigosubseccion)
            INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
          WHERE
            tb_carga_academica_subseccion1.codigodocente = ? AND 
            tb_carga_academica.codigoperiodo = ? AND tb_carga_academica.cod_sede=? 
          ORDER BY
            tb_carga_academica.codigoperiodo,
            tb_carga_academica.codigocarrera,
            tb_carga_academica.codigociclo,
            tb_carga_academica.codigoturno,
            tb_carga_academica.codigoseccion,
            tb_carga_academica_subseccion.codigosubseccion,
            tb_unidad_didactica.undd_nombre", $data);
          $resultado['cursos']=$rscursos->result();
      }
        //$this->db->close();
        return $resultado;
    }

    public function m_monitoreo_accesos()
    {
        //$this->load->database();
        $rsdocente = $this->db->query("SELECT 
          tb_persona.per_codigo AS codpersona,
          tb_usuario.id_usuario AS codusuario,
          tb_usuario.usu_nick AS usuario,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          MAX(tb_usuario_accesos.acc_fecha_hora) AS ultimo
        FROM
          tb_persona
          INNER JOIN tb_usuario_accesos ON (tb_persona.per_codigo = tb_usuario_accesos.per_codigo)
          INNER JOIN tb_usuario ON (tb_persona.per_codigo = tb_usuario.cod_persona)
        WHERE
          tb_usuario.usu_tipo = 'DC'
        GROUP BY
          tb_persona.per_codigo,
          tb_usuario.id_usuario,
          tb_usuario.usu_nick,
          tb_persona.per_apel_paterno,
          tb_persona.per_apel_materno,
          tb_persona.per_nombres,
          tb_persona.per_sexo
        ORDER BY ultimo DESC");

      return $rsdocente->result();
    }

     public function m_monitoreo_estadistica($data)
    {
        //$this->load->database();
        $rsdocente = $this->db->query("SELECT 
            tb_indicador.codigocarga AS codcarga,
            tb_indicador.codigosubseccion AS division,
            tb_carga_evaluaciones_head.evh_id AS codevh,
            tb_carga_evaluaciones_head.evh_nombre,
            tb_carga_evaluaciones_head.evh_nombrecorto AS evh_nombrec,
            tb_carga_evaluaciones_head.evh_orden,
            tb_indicador.ind_nombre AS indicador,
            tb_carga_evaluaciones_head.codigoindicador AS codind,
            tb_indicador.ind_nroorden AS ind_orden,
            SUM(case when tb_carga_evaluaciones.ecu_nota is not NULL THEN 1 ELSE 0 END) AS total
          FROM
            tb_carga_subseccion_miembros
            RIGHT OUTER JOIN tb_indicador ON (tb_carga_subseccion_miembros.cod_cargaacademica = tb_indicador.codigocarga)
            AND (tb_carga_subseccion_miembros.cod_subseccion = tb_indicador.codigosubseccion)
            RIGHT OUTER JOIN tb_carga_evaluaciones_head ON (tb_carga_evaluaciones_head.codigoindicador = tb_indicador.ind_id)
            LEFT OUTER JOIN tb_carga_evaluaciones ON (tb_carga_subseccion_miembros.cod_subseccion = tb_carga_evaluaciones.codigosubseccion)
            AND (tb_carga_subseccion_miembros.csm_id = tb_carga_evaluaciones.idmiembro)
            AND (tb_carga_evaluaciones.idevaluacionhead = tb_carga_evaluaciones_head.evh_id)
            LEFT OUTER JOIN tb_carga_academica ON (tb_indicador.codigocarga = tb_carga_academica.cac_id)
            LEFT OUTER JOIN tb_carga_academica_subseccion ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
            AND (tb_carga_academica_subseccion.codigosubseccion = tb_indicador.codigosubseccion)
          WHERE
            tb_carga_subseccion_miembros.csm_eliminado = 'NO' AND 
            tb_carga_academica_subseccion.codigodocente = ? AND 
            tb_carga_academica.codigoperiodo = ?
          GROUP BY
            tb_indicador.codigocarga,
            tb_indicador.codigosubseccion,
            tb_carga_evaluaciones_head.evh_id,
            tb_carga_evaluaciones_head.evh_nombre,
            tb_carga_evaluaciones_head.evh_nombrecorto,
            tb_carga_evaluaciones_head.evh_orden,
            tb_indicador.ind_nombre,
            tb_carga_evaluaciones_head.codigoindicador,
            tb_indicador.ind_nroorden
          ORDER BY
            tb_indicador.codigocarga,
            tb_indicador.codigosubseccion,
            tb_indicador.ind_nroorden,
            tb_carga_evaluaciones_head.evh_orden",$data);

        $resultado['e_eval']=$rsdocente->result();

        $rstotmiembros = $this->db->query("SELECT 
            tb_carga_academica_subseccion.codigocargaacademica as codcarga,
            tb_carga_academica_subseccion.codigosubseccion as division,
            COUNT(tb_carga_subseccion_miembros.csm_id) AS miembros
          FROM
            tb_carga_subseccion_miembros
            INNER JOIN tb_matricula ON (tb_carga_subseccion_miembros.cod_matricula = tb_matricula.mtr_id)
            INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_subseccion_miembros.cod_cargaacademica)
            AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_subseccion_miembros.cod_subseccion)
            INNER JOIN tb_carga_academica ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
          WHERE
            tb_carga_academica_subseccion.codigodocente = ? AND 
             tb_carga_academica.codigoperiodo = ? AND 
            tb_carga_subseccion_miembros.csm_eliminado = 'NO'
          GROUP BY
            tb_carga_academica_subseccion.codigocargaacademica,
            tb_carga_academica_subseccion.codigosubseccion",$data);
         $resultado['c_miembros']=$rstotmiembros->result();

         $rsasisten = $this->db->query("SELECT 
          tb_carga_sesiones.ses_detalle AS sesion,
          tb_carga_sesiones.ses_fecha AS fecha,
          tb_carga_sesiones.ses_horaini AS hora,
          sum(case when tb_carga_asistencia.acu_accion is not null then 1 else 0 END) AS total,
          tb_carga_sesiones.codigocarga AS codcarga,
          tb_carga_sesiones.codigosubseccion AS division
        FROM
          tb_carga_asistencia
          RIGHT OUTER JOIN tb_carga_sesiones ON (tb_carga_asistencia.idsesion = tb_carga_sesiones.ses_id)
          INNER JOIN tb_carga_academica ON (tb_carga_sesiones.codigocarga = tb_carga_academica.cac_id)
          INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
          AND (tb_carga_academica_subseccion.codigosubseccion = tb_carga_sesiones.codigosubseccion)
          LEFT OUTER JOIN tb_carga_subseccion_miembros ON (tb_carga_asistencia.idmiembro = tb_carga_subseccion_miembros.csm_id)
        WHERE
          tb_carga_academica_subseccion.codigodocente = ?  AND 
          tb_carga_academica.codigoperiodo =? AND 
          (tb_carga_subseccion_miembros.csm_eliminado = 'NO' OR 
          tb_carga_subseccion_miembros.csm_eliminado IS NULL)
        GROUP BY
          tb_carga_sesiones.ses_detalle,
          tb_carga_sesiones.ses_fecha,
          tb_carga_sesiones.ses_horaini,
          tb_carga_sesiones.codigocarga,
          tb_carga_sesiones.codigosubseccion
        ORDER BY
          tb_carga_sesiones.codigocarga,
          tb_carga_sesiones.codigosubseccion,
          tb_carga_sesiones.ses_fecha,
          tb_carga_sesiones.ses_horaini",$data);


         $resultado['e_asiste']=$rsasisten->result();

         $rsvirtual = $this->db->query("SELECT 
            tb_virtual_material.codigocarga as codcarga,
            tb_virtual_material.codigosubseccion as division,
            tb_virtual_material.virt_tipo as tipo,
            COUNT(tb_virtual_material.virt_id) AS total
          FROM
            tb_carga_academica
            INNER JOIN tb_virtual_material ON (tb_carga_academica.cac_id = tb_virtual_material.codigocarga)
            INNER JOIN tb_carga_academica_subseccion ON (tb_carga_academica.cac_id = tb_carga_academica_subseccion.codigocargaacademica)
            AND (tb_carga_academica_subseccion.codigosubseccion = tb_virtual_material.codigosubseccion)
          WHERE
            tb_carga_academica_subseccion.codigodocente = ? AND 
            tb_carga_academica.codigoperiodo = ? 
          GROUP BY
            tb_virtual_material.codigocarga,
            tb_virtual_material.codigosubseccion,
            tb_virtual_material.virt_tipo",$data);
          $resultado['e_virtual']=$rsvirtual->result();


        return $resultado;
    }

    public function m_get_carga_subseccion_docentes($data){
      $sqltext_array=array();
      $data_array=array();
      if ($data[0]!="%") {
        $sqltext_array[]="tb_docente.ins_sede = ?";
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
      
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
      
        $result = $this->db->query("SELECT 
          tb_carga_academica.cac_id AS codcarga,
          tb_carga_academica.codigoperiodo AS codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_carga_academica.codigocarrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS sigla,
          tb_carga_academica.codigociclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_ciclo.cic_letras AS ciclol,
          tb_carga_academica.codigoturno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_carga_academica.codigoseccion AS codseccion,
          tb_carga_academica_subseccion.codigosubseccion AS division,
          tb_carga_academica.codigouindidadd AS codunidad,
          tb_unidad_didactica.undd_nombre AS unidad,
          tb_carga_academica.cac_activo AS carga_activo,
          tb_unidad_didactica.codigomodulo AS codmodulo,
          tb_modulo_educativo.mod_nombre AS modulo,
          tb_modulo_educativo.codigoplan AS codplan,
          tb_plan_estudios.pln_nombre AS plan,
          tb_carga_academica_subseccion.codigodocente AS coddocente,
          tb_persona.per_tipodoc AS tipodoc,
          tb_persona.per_dni as numero,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_email_personal as epersonal,
          tb_persona.per_domicilio as domicilio,
          tb_persona.per_celular as celular,
          tb_persona.per_telefono as telefono,
          tb_persona.per_celular2 as celular2,
          tb_docente.doc_emailc AS ecorporativo,
          tb_sede.sed_nombre AS sede,
          tb_sede.sed_abreviatura AS sede_abrevia
          
        FROM
          tb_carga_academica_subseccion
          INNER JOIN tb_carga_academica ON (tb_carga_academica_subseccion.codigocargaacademica = tb_carga_academica.cac_id)
          INNER JOIN tb_carrera ON (tb_carga_academica.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_carga_academica.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
          INNER JOIN tb_modulo_educativo ON (tb_unidad_didactica.codigomodulo = tb_modulo_educativo.mod_codigo)
          LEFT OUTER JOIN tb_docente ON (tb_carga_academica_subseccion.codigodocente = tb_docente.doc_codigo)
          LEFT OUTER JOIN tb_persona ON (tb_docente.cod_persona = tb_persona.per_codigo)
          INNER JOIN tb_plan_estudios ON (tb_modulo_educativo.codigoplan = tb_plan_estudios.pln_id)
          INNER JOIN tb_turno ON (tb_carga_academica.codigoturno = tb_turno.tur_codigo)
          INNER JOIN tb_periodo ON (tb_carga_academica.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_sede ON (tb_carga_academica.cod_sede = tb_sede.id_sede)
          
        $sqltext
        ORDER BY
          -- tb_carga_academica_subseccion.codigodocente,
          tb_persona.per_apel_paterno,
          tb_persona.per_apel_materno,
          tb_persona.per_nombres,
          -- tb_carga_academica.cod_sede,
          tb_carrera.car_nombre",$data_array);
        return   $result->result();
    }

    
    

}