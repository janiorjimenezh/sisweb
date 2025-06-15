<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Minscrito extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function m_getInscripciones($data)
    { 
      $sqltext_array=array();
      $data_array=array();
      
      if (isset($data['codinscripcion']) and ($data['codinscripcion']!="%")) {
        $sqltext_array[]="tb_inscripcion.ins_identificador  = ?";
        $data_array[]=$data['codinscripcion'];
      } 
      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_inscripcion.cod_carrera = ?";
        $data_array[]=$data['codcarrera'];
      } 
      if (isset($data['convalida']) and ($data['convalida']!='%')) {
        $sqltext_array[]="tb_inscripcion.ins_convalida_unidades = ?";
        $data_array[]=$data['convalida'];
      } 
      if (isset($data['estudiante']) and ($data['estudiante']!='%%')) {
        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
        $data_array[]=$data['estudiante'];
      } 
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
            tb_persona.per_codigo AS codpersona,
            tb_inscripcion.ins_identificador AS codinscripcion,
            tb_inscripcion.ins_carnet AS carne,
            tb_inscripcion.cod_carrera AS codcarrera,
            tb_carrera.car_nombre AS carrera,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_inscripcion.ins_estado AS estado,
            tb_inscripcion.id_plan as codplan
          FROM
            tb_persona
            INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
            INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id) 
          $sqltext", $data);
        return   $result->result();
    }


    public function m_cambiar_estado($items)
    {
      //CALL ``( @vniv_codigo, @vniv_estado, @`s`);
      $this->db->query("CALL `sp_tb_inscripcion_update_estado`(?,?,?,@s)",$items);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function mFiltrarInscripciones($data)
    {
      $sqltext_array=array();
      $data_array=array();
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_inscripcion_detalle.cod_sede = ?";
        $data_array[]=$data['codsede'];
      } 
      if (isset($data['codmodalidad']) and ($data['codmodalidad']!="%")) {
        $sqltext_array[]="tb_inscripcion_detalle.cod_modalidad  = ?";
        $data_array[]=$data['codmodalidad'];
      } 
      if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_inscripcion_detalle.cod_periodo  = ?";
        $data_array[]=$data['codperiodo'];
      } 
      if (isset($data['codcampania']) and ($data['codcampania']!="%")) {
        $sqltext_array[]="tb_inscripcion_detalle.cod_campania = ?";
        $data_array[]=$data['codcampania'];
      } 
      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_inscripcion.cod_carrera = ?";
        $data_array[]=$data['codcarrera'];
      } 
      if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
        $sqltext_array[]="tb_inscripcion_detalle.cod_ciclo  = ?";
        $data_array[]=$data['codciclo'];
      } 
      if (isset($data['codturno']) and ($data['codturno']!="%")) {
        $sqltext_array[]="tb_inscripcion_detalle.cod_turno = ?";
        $data_array[]=$data['codturno'];
      } 
      if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
        $sqltext_array[]="tb_inscripcion_detalle.cod_seccion = ?";
        $data_array[]=$data['codseccion'];
      }
      if (isset($data['convalida']) and ($data['convalida']!='%')) {
        $sqltext_array[]="tb_inscripcion.ins_convalida_unidades = ?";
        $data_array[]=$data['convalida'];
      } 
      if (isset($data['estudiante']) and ($data['estudiante']!='%%')) {
        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
        $data_array[]=$data['estudiante'];
      } 

      
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
          tb_inscripcion_detalle.cod_periodo AS codperiodo,
          tb_inscripcion_detalle.cod_ciclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_carrera.car_abreviatura AS carabrevia,
          tb_persona.per_codigo AS codpersona,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_inscripcion_detalle.inde_estado AS estado,
          tb_inscripcion_detalle.cod_turno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_inscripcion_detalle.cod_campania AS codcampania,
          tb_campania.cam_nombre AS campania,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_persona.per_email_personal AS epersonal,
          tb_persona.per_foto AS foto,
          tb_inscripcion.ins_emailc AS ecorporativo,
          tb_inscripcion.id_plan AS codplan,
          tb_inscripcion.ins_resolucion_general AS resgeneral,
          tb_inscripcion.ins_resolucion_individual AS resindiv,
          tb_inscripcion.ins_institucion_procedencia AS instproced,
          tb_inscripcion.ins_programa_procedencia AS carrproced,
          carrera2.car_nombre AS procedprograma,
          tb_inscripcion.ins_periodo_procedencia AS perproced,
          tb_inscripcion.ins_ciclo_procedencia AS cicproced,
          tb_inscripcion.ins_turno_procedencia AS turproced,
          tb_inscripcion.ins_seccion_procedencia AS seccproced,
          tb_inscripcion.ins_convalida_unidades AS convaund,
          tb_plan_estudios.pln_nombre AS plan,
          tb_inscripcion_detalle.cod_seccion AS codseccion,
          tb_inscripcion_detalle.cod_sede AS codsede,
          tb_sede.sed_nombre AS sede,
          tb_inscripcion_detalle.cod_modalidad as codmodalidad,
          tb_modalidad.mod_nombre as modalidad,
          tb_modalidad.mod_abreviatura as modalidad_abrevia
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          LEFT OUTER JOIN tb_turno ON (tb_inscripcion_detalle.cod_turno = tb_turno.tur_codigo)
          INNER JOIN tb_campania ON (tb_inscripcion_detalle.cod_campania = tb_campania.cam_id)
          INNER JOIN tb_ciclo ON (tb_inscripcion_detalle.cod_ciclo = tb_ciclo.cic_codigo)
          LEFT OUTER JOIN tb_plan_estudios ON (tb_inscripcion.id_plan = tb_plan_estudios.pln_id)
          INNER JOIN tb_sede ON (tb_inscripcion_detalle.cod_sede = tb_sede.id_sede)
            INNER JOIN tb_modalidad ON (tb_inscripcion_detalle.cod_modalidad = tb_modalidad.mod_id) 
            LEFT OUTER JOIN tb_carrera as carrera2 ON (tb_inscripcion.ins_programa_procedencia = carrera2.car_id)
        $sqltext
        ORDER BY tb_inscripcion_detalle.cod_periodo DESC,tb_inscripcion.cod_carrera,tb_inscripcion_detalle.cod_turno,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres ",$data_array);
        return $result->result();
    }


  /*
  COMENTADO POR JANIOR, PROBABLEMENTE YA NO SIRVA
  public function m_get_inscripcion_por_carne($data)
  {
      $result = $this->db->query("SELECT 
          tb_persona.per_codigo AS idpersona,
          tb_inscripcion.ins_identificador AS idinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          concat(tb_persona.per_tipodoc,'-',tb_persona.per_dni) AS dni,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_inscripcion.ins_estado AS estado
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id) 
        WHERE tb_inscripcion.ins_carnet = ? LIMIT 1", $data);
      return   $result->row();
  }*/

    public function m_get_inscrito_por_carne($data)
    {
        $result = $this->db->query("SELECT 
            tb_persona.per_codigo AS idpersona,
            tb_inscripcion.ins_identificador AS idinscripcion,
            tb_inscripcion.ins_carnet AS carnet,
            tb_inscripcion.cod_carrera AS codcarrera,
            tb_carrera.car_nombre AS carrera,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_inscripcion.ins_estado AS estado,
            tb_inscripcion.id_plan as codplan
          FROM
            tb_persona
            INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
            INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id) 
          WHERE tb_inscripcion.ins_carnet=? LIMIT 1", $data);
        return   $result->row();
    }

    public function m_get_inscrito_por_codigo($data)
    {
        $result = $this->db->query("SELECT 
            tb_persona.per_codigo AS idpersona,
            tb_inscripcion.ins_identificador AS idinscripcion,
            tb_inscripcion.ins_carnet AS carnet,
            tb_inscripcion.cod_carrera AS codcarrera,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_persona.per_foto AS foto,
            tb_inscripcion.ins_estado AS estado,
            tb_inscripcion.id_plan as codplan,
            tb_inscripcion_detalle.cod_periodo as codperiodo
          FROM
            tb_persona
            INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
            INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion) 
          WHERE tb_inscripcion.ins_identificador = ? LIMIT 1", $data);
        return   $result->row();
    }

    public function m_get_datos_matriculantes($data)
    {
        $result = $this->db->query("SELECT 
            tb_inscripcion.ins_identificador AS idinscripcion,
            tb_inscripcion.cod_carrera AS codcarrera,
            tb_carrera.car_nombre AS carrera,
            tb_persona.per_apel_paterno AS paterno,
            tb_persona.per_apel_materno AS materno,
            tb_persona.per_nombres AS nombres,
            tb_persona.per_sexo AS sexo,
            tb_inscripcion.ins_estado AS estado,
            tb_inscripcion.id_plan AS codplan,
            tb_inscripcion.ins_carnet AS carne
          FROM
            tb_persona
            INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
            INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
            where  tb_inscripcion.`ins_estado`<>'RETIRADO' AND tb_inscripcion.ins_identificador not IN(SELECT 
            `codigoinscripcion`
          FROM 
            `tb_matricula` WHERE  `codigoperiodo`=?) AND tb_inscripcion.cod_carrera=? AND CONCAT( tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno,' ',tb_persona.per_apel_materno,' ',tb_persona.per_nombres) like ? LIMIT 10", $data);
        return   $result->result();
    }

    public function m_get_docsanexados($data)
    {
        $result = $this->db->query("SELECT `ins_identificador` as codins,  `doan_id` as coddoc, `doan_fecha` as detalle, `cod_periodo` as periodo FROM  `tb_inscripcion_docanexados` 
          WHERE ins_identificador=?", $data);
        return   $result->result();
    }

    public function m_get_docsanexados_fichapdf($data)
    {
        $result = $this->db->query("SELECT 
                tb_inscripcion_docanexados.ins_identificador as codins,  
                tb_inscripcion_docanexados.doan_id as coddoc,
                tb_doc_anexar.doan_nombre as documento
              FROM  `tb_inscripcion_docanexados` 
              INNER JOIN tb_doc_anexar ON (tb_inscripcion_docanexados.doan_id = tb_doc_anexar.doan_id)
          WHERE tb_inscripcion_docanexados.ins_identificador = ?", $data);
        return   $result->result();
    }

    public function m_get_documentos_anexados($data)
    {
      $result = $this->db->query("SELECT 
                tb_doc_anexar.doan_id id,
                tb_doc_anexar.doan_nombre nombre,
                tb_doc_anexar.doan_abrevia abrev
              FROM 
                tb_doc_anexar
              WHERE
                tb_doc_anexar.doan_id = ? LIMIT 1", $data);
      return $result->row();
    }

    public function m_insertdocs($data)
    {
      
      $result = $this->db->query("DELETE FROM  `tb_inscripcion_docanexados` WHERE ins_identificador=?;", array($data[0]));
      foreach ($data[1] as $key => $doc) {
        $result = $this->db->query("INSERT INTO  `tb_inscripcion_docanexados` ( `ins_identificador`, `doan_id`, `doan_fecha`, `cod_periodo`) 
                VALUE (?, ?, ?, ?);", array($data[0],$doc[0],$doc[1],$doc[2]));
      }
    }
    
    public function m_filtrar_basico_sd_activa($data)
    {
      if ($data[1]=="0") $data[1]="%";
      $result = $this->db->query("SELECT 
          tb_inscripcion_detalle.cod_periodo AS codperiodo,
          tb_inscripcion_detalle.cod_ciclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_carrera.car_abreviatura AS carabrevia,
          tb_persona.per_codigo AS codpersona,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_inscripcion_detalle.inde_estado AS estado,
          tb_inscripcion_detalle.cod_turno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_inscripcion_detalle.cod_campania AS codcampania,
          tb_campania.cam_nombre AS campania,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_persona.per_email_personal AS epersonal,
          tb_persona.per_foto AS foto,
          tb_inscripcion.ins_emailc AS ecorporativo,
          tb_inscripcion.id_plan AS codplan,
          tb_plan_estudios.pln_nombre AS plan,
          tb_inscripcion_detalle.cod_seccion AS codseccion,
          tb_inscripcion_detalle.cod_sede AS codsede,
          tb_sede.sed_nombre AS sede
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          LEFT OUTER JOIN tb_turno ON (tb_inscripcion_detalle.cod_turno = tb_turno.tur_codigo)
          INNER JOIN tb_campania ON (tb_inscripcion_detalle.cod_campania = tb_campania.cam_id)
          INNER JOIN tb_ciclo ON (tb_inscripcion_detalle.cod_ciclo = tb_ciclo.cic_codigo)
          LEFT OUTER JOIN tb_plan_estudios ON (tb_inscripcion.id_plan = tb_plan_estudios.pln_id)
          INNER JOIN tb_sede ON (tb_inscripcion_detalle.cod_sede = tb_sede.id_sede)
        WHERE tb_inscripcion_detalle.cod_periodo like ? AND tb_inscripcion_detalle.cod_campania LIKE ? AND tb_inscripcion.cod_carrera like ? AND tb_inscripcion_detalle.cod_ciclo like ? AND tb_inscripcion_detalle.cod_turno LIKE ? AND tb_inscripcion_detalle.cod_seccion LIKE ?  AND tb_inscripcion_detalle.cod_sede like ? AND 
                    concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? 
        ORDER BY tb_inscripcion_detalle.cod_periodo DESC,tb_inscripcion.cod_carrera,tb_inscripcion_detalle.cod_turno,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
      
      return   $result->result();
    }

    public function m_get_inscripciones_x_dni_multisedes($data)
    {
      $result = $this->db->query("SELECT 
          tb_inscripcion_detalle.cod_periodo AS codperiodo,
          tb_inscripcion_detalle.cod_ciclo AS codciclo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_inscripcion_detalle.inde_estado AS estado,
          tb_inscripcion_detalle.cod_turno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_inscripcion_detalle.cod_campania as codcampania,
          tb_campania.cam_nombre as campania,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_persona.per_email_personal as epersonal,
          tb_usuario.usu_email_corporativo as ecorporativo,
          tb_inscripcion_detalle.cod_sede as codsede,
          tb_sede.sed_nombre as sede
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          LEFT OUTER JOIN tb_turno ON (tb_inscripcion_detalle.cod_turno = tb_turno.tur_codigo)
          INNER JOIN tb_campania ON (tb_inscripcion_detalle.cod_campania = tb_campania.cam_id)
          LEFT OUTER JOIN tb_usuario ON (tb_inscripcion.ins_identificador = tb_usuario.usu_codente)
          INNER JOIN tb_sede ON (tb_inscripcion_detalle.cod_sede = tb_sede.id_sede)
        WHERE tb_persona.per_tipodoc=? AND tb_persona.per_dni=? 

        ORDER BY tb_inscripcion_detalle.cod_periodo DESC,tb_inscripcion.cod_carrera,tb_inscripcion_detalle.cod_turno,tb_persona.per_apel_paterno,tb_persona.per_apel_materno,tb_persona.per_nombres", $data);
      return   $result->result();
    }

    /*public function m_filtrar_basicosc_sd_activa($data)
    {
      $result = $this->db->query("SELECT 
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_carnet AS carnet,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_usuario.usu_email_corporativo as ecorporativo,
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          INNER JOIN tb_usuario ON (tb_inscripcion.ins_carnet = tb_usuario.usu_nick)
        WHERE tb_inscripcion_detalle.cod_periodo like ? AND tb_inscripcion.cod_carrera like ? AND tb_inscripcion_detalle.cod_sede=? AND 
              concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? ", $data);
      return   $result->result();
    }*/

    public function m_get_inscripcion_pdf($data)
    {
      $result = $this->db->query("SELECT 
        tb_periodo.ped_nombre AS periodo,
        tb_inscripcion.ins_carnet AS carnet,
        tb_inscripcion.cod_carrera AS codcarrera,
        tb_carrera.car_nombre AS carrera,
        tb_persona.per_apel_paterno AS paterno,
        tb_persona.per_apel_materno AS materno,
        tb_persona.per_nombres AS nombres,
        tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
        tb_inscripcion.ins_estado AS estado,
        tb_sede.sed_nombre AS sede,
        tb_sede.sed_tipo_local AS sedetipo,
        tb_carrera.car_nivel_formativo AS nivelformativo,
        tb_persona.per_sexo AS sexo,
        tb_persona.per_fecha_nacimiento AS fecnac,
        tb_persona.per_tipodoc AS tipodoc,
        tb_persona.per_dni AS nrodoc,
        tb_persona.per_lugar_nacimiento AS lugarnac,
        tb_pais.pa_nombre AS pais,
        tb_distrito.dis_nombre AS distrito,
        tb_provincia.prv_nombre AS provincia,
        tb_departamento.dep_nombre AS departamento,
        tb_persona.per_domicilio AS domicilio,
        tb_persona.per_trabaja AS trabaja,
        tb_persona.per_cargo AS cargo,
        tb_persona.per_email_personal AS email,
        tb_persona.per_telefono AS telefono,
        tb_persona.per_celular AS celular,
        tb_persona.per_estadocivil AS estadocivil,
        tb_periodo.ped_anio AS anio,
        tb_persona.ins_colegio_5to_sec AS colegio5to,
        tb_persona.per_padre_apel_paterno AS padre,
        tb_persona.per_padre_ocupacion AS ocupapadre,
        tb_persona.per_madre_apel_paterno AS madre,
        tb_persona.per_madre_ocupacion AS ocupamadre,
        tb_ciclo.cic_nombre AS ciclo,
        tb_turno.tur_nombre AS turno,
        tb_inscripcion_detalle.cod_seccion AS seccion,
        tb_inscripcion_detalle.inde_observacion AS observacion,
        tb_inscripcion_detalle.cod_campania AS idcampania,
        tb_campania.cam_nombre AS campania,
        tb_sede.sed_telefonos AS sede_telefonos,
        tb_sede.sed_dre AS sede_dre,
        tb_sede.email_admision AS sede_eadmision,
        tb_distrito1.dis_nombre as sede_distrito,
        tb_provincia1.prv_nombre as sede_provincia,
        tb_departamento1.dep_nombre as sede_departamento,
        tb_sede.sed_centro_poblado as sede_centropoblado 
      FROM
        tb_persona
        INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
        INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
        INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
        LEFT OUTER JOIN tb_campania ON (tb_inscripcion_detalle.cod_campania = tb_campania.cam_id)
        INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
        INNER JOIN tb_sede ON (tb_inscripcion.ins_sede = tb_sede.id_sede)
        INNER JOIN tb_pais ON (tb_persona.cod_pais = tb_pais.pa_id)
        INNER JOIN tb_distrito ON (tb_persona.cod_distrito = tb_distrito.dis_codigo)
        INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo)
        INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo)
        LEFT OUTER JOIN tb_ciclo ON (tb_inscripcion_detalle.cod_ciclo = tb_ciclo.cic_codigo)
        LEFT OUTER JOIN tb_turno ON (tb_inscripcion_detalle.cod_turno = tb_turno.tur_codigo)
        INNER JOIN tb_distrito tb_distrito1 ON (tb_sede.cod_distrito = tb_distrito1.dis_codigo)
        INNER JOIN tb_provincia tb_provincia1 ON (tb_distrito1.cod_provincia = tb_provincia1.prv_codigo)
        INNER JOIN tb_departamento tb_departamento1 ON (tb_provincia1.cod_departamento = tb_departamento1.dep_codigo)
        
        WHERE
          tb_inscripcion_detalle.cod_periodo = ? AND tb_inscripcion.ins_identificador=?  LIMIT 1", $data);
      return   $result->row();
    }

    public function m_filtrar_basico_sd_retirados($data)
    {
      $result = $this->db->query("SELECT 
          tb_inscripcion_detalle.cod_periodo AS codperiodo,
          tb_inscripcion_detalle.cod_ciclo AS codciclo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_usuario.usu_email_corporativo as ecorporativo,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_inscripcion_detalle.inde_estado AS estado,
          tb_inscripcion_detalle.cod_campania AS idcampania,
          tb_inscripcion_detalle.cod_turno AS turno
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          INNER JOIN tb_usuario ON (tb_inscripcion.ins_identificador = tb_usuario.usu_codente)
        WHERE tb_inscripcion_detalle.cod_periodo like ? AND tb_inscripcion.cod_carrera like ? AND  
              concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? AND tb_inscripcion_detalle.inde_estado = 'RETIRADO' ", $data);
      return   $result->result();
    }

    public function m_filtrar_basico_sd_traslados($data)
    {
      $result = $this->db->query("SELECT 
          tb_inscripcion_detalle.cod_periodo AS codperiodo,
          tb_inscripcion_detalle.cod_ciclo AS codciclo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_usuario.usu_email_corporativo as ecorporativo,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_inscripcion_detalle.inde_estado AS estado,
          tb_inscripcion_detalle.cod_campania AS idcampania
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
          INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
          INNER JOIN tb_usuario ON (tb_inscripcion.ins_carnet = tb_usuario.usu_nick)
        WHERE tb_inscripcion_detalle.cod_periodo like ? AND tb_inscripcion.cod_carrera like ? AND tb_inscripcion_detalle.cod_sede=? AND 
              concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) LIKE ? AND tb_inscripcion_detalle.cod_modalidad = '2' ", $data);
      return   $result->result();
    }

    public function m_insert_inscripcion($data){   
      // $this->db->query("CALL `sp_tb_inscripcion_insert`(?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
      $this->db->query("CALL `sp_tb_inscripcion_insert_manual`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return   $res->row();  
    }

    public function m_insert_inscripcion2($data){   
      //( @vidpersona, @vcarnet, @vcodcarrera, @vcodmodalidad, @vcodperido, @vcodcampania, @vcodciclo, @vobservacion, @vfecinscripcion, @`s`);
      $this->db->query("CALL `sp_tb_inscripcion_insert2`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return   $res->row();  
    }

    public function m_update_inscripcion($data){   
      //( @vidpersona, @vcarnet, @vcodcarrera, @vcodmodalidad, @vcodperido, @vcodcampania, @vcodciclo, @vobservacion, @vfecinscripcion, @`s`);
      $this->db->query("CALL `sp_tb_inscripcion_update`(?,?,?,?,?,?,?,?,?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_insert_activa_retirado($data)
    {
      $this->db->query("CALL `sp_tb_inscripcion_activa_retirado_insert`(?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as newcod');
      return   $res->row();
    }

    public function m_update_asignarplan($data){   
      //( @vidpersona, @vcarnet, @vcodcarrera, @vcodmodalidad, @vcodperido, @vcodcampania, @vcodciclo, @vobservacion, @vfecinscripcion, @`s`);
      $this->db->query("CALL `sp_tb_inscripcion_update_asignarplan`(?,?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }
    public function m_eliminar($data){   
      //( @vidpersona, @vcarnet, @vcodcarrera, @vcodmodalidad, @vcodperido, @vcodcampania, @vcodciclo, @vobservacion, @vfecinscripcion, @`s`);
      $this->db->query("CALL `sp_tb_inscripcion_delete`(?,?,@s)",$data);
      $res = $this->db->query('select @s as out_param');
      return   $res->row()->out_param;  
    }

    public function m_update_estado_retiro($data)
    {
      $this->db->query("CALL `sp_tb_inscripcion_detalle_update_retirado`(?,?,?,?,?,@s)",$data);
      $res = $this->db->query('select @s as salida');
      return   $res->row()->salida;
    }

    public function m_update_grupo_inscripcion($data)
    {
      //(array($inscripcion,$periodo,$campania,$ciclo,$turno,$seccion));
      $this->db->query("CALL `sp_tb_inscripcion_detalle_update_grupo`(?,?,?,?,?,?,@s)",$data);
      $res = $this->db->query('select @s as salida');
      return   $res->row()->salida;
    }

    

    public function m_insert_reingreso($data)
    {
      $this->db->query("CALL `sp_tb_inscripcion_detalle_insert`(?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return   $res->row();
    }

    public function m_update_data_inscripcion($data){   
      $this->db->query("CALL `sp_tb_inscripcion_update_manual`(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@s,@nid)",$data);
      $res = $this->db->query('select @s as salida,@nid as nid');
      return   $res->row();  
    }

    public function m_filtrar_inscritos($data)
    {
      $insc = $data[3];
      $result = $this->db->query("SELECT 
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_carnet AS carnet,
          tb_inscripcion.cod_carrera AS codcarrera,
          tb_inscripcion.id_plan AS idplan,
          tb_inscripcion.ins_instituto_traslado AS traslado,
          tb_inscripcion.ins_discapacidad AS discapacidad,
          tb_inscripcion.ins_detalle_discapacidad AS detalle,
          tb_inscripcion_detalle.cod_modalidad AS codmodalidad,
          tb_inscripcion_detalle.cod_periodo AS codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion_detalle.cod_campania AS codcampania,
          tb_campania.cam_nombre as campania,
          tb_inscripcion_detalle.cod_ciclo AS codciclo,
          tb_inscripcion_detalle.inde_estado AS estado,
          tb_inscripcion_detalle.inde_observacion AS observacion,
          tb_inscripcion_detalle.cod_plpan AS codplan,
          tb_inscripcion_detalle.cod_turno AS codturno,
          tb_inscripcion_detalle.cod_seccion AS codseccion,
          tb_inscripcion_detalle.cod_sede AS codsede,
          tb_turno.tur_nombre AS turno,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_sigla AS carsigla,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_persona.per_sexo AS sexo,
          tb_inscripcion_detalle.inde_fecinscripcion AS fecinsc,
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_persona.per_email_personal as epersonal,
          tb_usuario.usu_email_corporativo as ecorporativo
      FROM
        tb_persona
        INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
        INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
        INNER JOIN tb_inscripcion_detalle ON (tb_inscripcion.ins_identificador = tb_inscripcion_detalle.cod_inscripcion)
        INNER JOIN tb_periodo ON (tb_inscripcion_detalle.cod_periodo = tb_periodo.ped_codigo)
        LEFT OUTER JOIN tb_turno ON (tb_inscripcion_detalle.cod_turno = tb_turno.tur_codigo)
        INNER JOIN tb_campania ON (tb_inscripcion_detalle.cod_campania = tb_campania.cam_id)
        LEFT OUTER JOIN tb_usuario ON (tb_inscripcion.ins_identificador = tb_usuario.usu_codente)
              WHERE tb_inscripcion_detalle.cod_periodo = ? AND tb_inscripcion_detalle.cod_sede = ? AND tb_inscripcion_detalle.cod_ciclo = ? AND tb_inscripcion_detalle.cod_inscripcion = ? ", $data);
      $arr_result['inscrito']= $result->row();

      $result = $this->db->query("SELECT 
        tb_inscripcion_discapacidad.inl_id as codigo,
        tb_inscripcion_discapacidad.cod_inscripcion as codins,
        tb_inscripcion_discapacidad.cod_discapacidad as coddiscap,
        tb_inscripcion_discapacidad.inl_principal as principal
      FROM
        tb_inscripcion_discapacidad
        WHERE tb_inscripcion_discapacidad.cod_inscripcion = ?", $insc);

      $arr_result['discapacidad']= $result->row();

      $result = $this->db->query("SELECT 
        tb_inscripcion_publicidad.inpb_id as codigo,
        tb_inscripcion_publicidad.cod_inscripcion as codins,
        tb_inscripcion_publicidad.cod_publicidad as public
      FROM
        tb_inscripcion_publicidad
        WHERE tb_inscripcion_publicidad.cod_inscripcion = ?", $insc);

      $arr_result['dpublicidad']= $result->result();
      return $arr_result;
    }

    public function m_delete_discapacidad($data)
    {
      $result = $this->db->query("DELETE FROM tb_inscripcion_discapacidad WHERE cod_inscripcion = ?", $data);
      return 1;
    }

    public function m_delete_publicidad($data)
    {
      $result = $this->db->query("DELETE FROM tb_inscripcion_publicidad WHERE cod_inscripcion = ?", $data);
      return 1;
    }

}

