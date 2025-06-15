<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdeudasgrupo extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_getDeudasGrupo($data)
    {
        $data_array=array();
        $sqltext_array=array();
    
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

        $sqltext_array[]="tb_deuda_individual.di_estado = ?";
        $data_array[]='ACTIVO';

      

      // if (isset($data['fechas'])) {
      //   if (count($data['fechas'])>0){
      //     $sqltext_array[]="tb_docpago.dcp_fecha_hora BETWEEN ? AND ? ";
      //     $data_array[]=$data['fechas'][0];
      //     $data_array[]=$data['fechas'][1];

      //   }
      // }

      // $sqltext=implode(' AND ', $sqltext_array);
      // if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

      // if (isset($data['limites'])) {
      //   if (count($data['limites'])>0){
      //     $limit_text="LIMIT ?";
      //     $data_array[]=$data['limites'][0];
      //   }
      //   if (count($data['limites'])>1){
      //     $limit_text=$limit_text."OFFSET ?";
      //     $data_array[]=$data['limites'][1];
      //   }
      // }
      // else{
      //   if (isset($data['protegelimites'])) {
      //     if ($data['protegelimites']==true){
      //       $limit_text="LIMIT ?";
      //       $data_array[]=1000;
      //     }
      //   }
      // }

        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

        $result = $this->db->query("SELECT 
          tb_matricula.codigosede AS codsede,
          tb_sede.sed_nombre AS sede,
          tb_sede.sed_abreviatura AS sede_abreviatura,
          tb_matricula.codigoperiodo AS codperiodo,
          tb_periodo.ped_nombre AS periodo,
          tb_matricula.codigocarrera AS codcarrera,
          tb_carrera.car_nombre AS carrera,
          tb_carrera.car_abreviatura AS carrera_abreviatura,
          tb_matricula.codigociclo AS codciclo,
          tb_ciclo.cic_nombre AS ciclo,
          tb_matricula.codigoturno AS codturno,
          tb_turno.tur_nombre AS turno,
          tb_matricula.codigoseccion AS codseccion,
          SUM(tb_deuda_individual.di_monto) AS generado,
          SUM(CASE WHEN tb_deuda_individual.di_saldo<0 THEN 0 ELSE tb_deuda_individual.di_saldo END) AS pendiente,
          tb_deuda_calendario_grupoacad.cod_deuda_calendario as codcronograma,
          tb_deuda_calendario.dc_nombre as cronograma
        FROM
          tb_matricula
          INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
          INNER JOIN tb_carrera ON (tb_matricula.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_periodo ON (tb_matricula.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_ciclo ON (tb_matricula.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_turno ON (tb_matricula.codigoturno = tb_turno.tur_codigo)
          INNER JOIN tb_sede ON (tb_matricula.codigosede = tb_sede.id_sede)
          LEFT OUTER JOIN tb_deuda_calendario_grupoacad ON (tb_matricula.codigoperiodo = tb_deuda_calendario_grupoacad.codigoperiodo)
          AND (tb_matricula.codigocarrera = tb_deuda_calendario_grupoacad.codigocarrera)
          AND (tb_matricula.codigociclo = tb_deuda_calendario_grupoacad.codigociclo)
          AND (tb_matricula.codigoturno = tb_deuda_calendario_grupoacad.codigoturno)
          AND (tb_matricula.codigoseccion = tb_deuda_calendario_grupoacad.codigoseccion)
          INNER JOIN tb_deuda_calendario ON (tb_deuda_calendario_grupoacad.cod_deuda_calendario = tb_deuda_calendario.dc_codigo)
          AND (tb_matricula.codigosede = tb_deuda_calendario.cod_sede)
        $sqltext 
        GROUP BY
          tb_matricula.codigosede,
          tb_sede.sed_nombre,
          tb_sede.sed_abreviatura,
          tb_matricula.codigoperiodo,
          tb_periodo.ped_nombre,
          tb_matricula.codigocarrera,
          tb_carrera.car_nombre,
          tb_carrera.car_abreviatura,
          tb_matricula.codigociclo,
          tb_ciclo.cic_nombre,
          tb_matricula.codigoturno,
          tb_turno.tur_nombre,
          tb_matricula.codigoseccion,
          tb_deuda_calendario_grupoacad.cod_deuda_calendario,
          tb_deuda_calendario.dc_nombre
        ORDER BY
          tb_matricula.codigoperiodo,
          tb_matricula.codigocarrera,
          tb_matricula.codigociclo,
          tb_matricula.codigoturno,
          tb_matricula.codigoseccion", $data_array);

        return $result->result();
    }

}