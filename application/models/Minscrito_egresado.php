<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Minscrito_egresado extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

public function mFiltrarEgresados($data)
    {
      $sqltext_array=array();
      $data_array=array();
      if (isset($data['estado']) and ($data['estado']!='%')) {
        $sqltext_array[]="tb_inscripcion.ins_estado= ?";
        $data_array[]=$data['estado'];
      } 
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_inscripcion.ins_sede = ?";
        $data_array[]=$data['codsede'];
      } 
      if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_inscripcion.cod_periodo_egresado  = ?";
        $data_array[]=$data['codperiodo'];
      } 

      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_inscripcion.cod_carrera = ?";
        $data_array[]=$data['codcarrera'];
      } 
      if (isset($data['estudiante']) and ($data['estudiante']!='%%')) {
        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) = ?";
        $data_array[]=$data['estudiante'];
      } 
      

      
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
        $result = $this->db->query("SELECT 
          tb_inscripcion.cod_periodo_egresado as codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_inscripcion.ins_identificador AS codinscripcion,
          tb_inscripcion.ins_estado as estado,
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
          tb_persona.per_tipodoc AS tdoc,
          tb_persona.per_dni AS nro,
          tb_persona.per_fecha_nacimiento AS fecnac,
          tb_persona.per_celular AS celular,
          tb_persona.per_email_personal AS epersonal,
          tb_persona.per_foto AS foto,
          tb_inscripcion.ins_emailc AS ecorporativo,
           tb_inscripcion.id_plan as codplan,
          tb_plan_estudios.pln_nombre AS plan,
          tb_sede.sed_nombre AS sede,
          tb_inscripcion.ins_sede as codsede
        FROM
          tb_persona
          INNER JOIN tb_inscripcion ON (tb_persona.per_codigo = tb_inscripcion.cod_persona)
          INNER JOIN tb_carrera ON (tb_inscripcion.cod_carrera = tb_carrera.car_id)
          INNER JOIN tb_periodo ON (tb_inscripcion.cod_periodo_egresado = tb_periodo.ped_codigo)
          INNER JOIN tb_sede ON (tb_inscripcion.ins_sede = tb_sede.id_sede)
          LEFT OUTER JOIN tb_plan_estudios ON (tb_inscripcion.id_plan = tb_plan_estudios.pln_id)
        $sqltext
        ORDER BY
          tb_inscripcion.cod_periodo_egresado DESC,
          tb_inscripcion.cod_carrera,
          tb_persona.per_apel_paterno,
          tb_persona.per_apel_materno,
          tb_persona.per_nombres ",$data_array);
        return $result->result();
    }
}