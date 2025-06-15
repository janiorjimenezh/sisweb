<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mdeudas_calendario_grupo extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

  


  public function m_get_historial_pagante($data)
  {
      $sqltext_array=array();

      $data_array=array();
      
      if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_matricula.codigoperiodo = ?";
        $data_array[]=$data['codperiodo'];
      } 
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_matricula.codigosede = ?";
        $data_array[]=$data['codsede'];
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
      if (isset($data['buscar']) and ($data['buscar']!="%")) {
        $sqltext_array[]="concat(tb_inscripcion.ins_carnet,' ',tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) like ?";
        $data_array[]=$data['buscar'];
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
      if (isset($data['codconcepto']) and ($data['codconcepto']!="%")) {
        $sqltext_array[]="tb_deuda_individual.cod_gestion=?";
        $data_array[]=$data['codconcepto'];
      }
      if (isset($data['saldo'])) {
        $sqltext_array[]="tb_deuda_individual.di_saldo ".$data['saldo'][0]." ?";
        $data_array[]=$data['saldo'][1];
      }
      if (isset($data['destado'])) {
        $sqltext_array[]="tb_deuda_individual.di_estado= ?";
        $data_array[]=$data['destado'];
      }
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

      $result = $this->db->query("SELECT 
                tb_deuda_calendario_grupoacad.cga_id,
                tb_deuda_calendario_grupoacad.codigoperiodo,
                tb_deuda_calendario_grupoacad.codigocarrera,
                tb_deuda_calendario_grupoacad.codigociclo,
                tb_deuda_calendario_grupoacad.codigoturno,
                tb_deuda_calendario_grupoacad.codigoseccion,
                tb_deuda_calendario_grupoacad.cod_deuda_calendario
              FROM
                tb_deuda_calendario_grupoacad
              $sqltext
              ORDER BY
                  tb_deuda_calendario_grupoacad.cod_deuda_calendario,
                  tb_deuda_calendario_grupoacad.codigoperiodo,
                  tb_deuda_calendario_grupoacad.codigocarrera,
                  tb_deuda_calendario_grupoacad.codigociclo,
                  tb_deuda_calendario_grupoacad.codigoturno,
                  tb_deuda_calendario_grupoacad.codigoseccion",$data_array);
        return $result->result();
  
  }

  public function m_getGrupos($data){
      $sqltext_array=array();
      $data_array=array();
      
      if (isset($data['codsede']) and ($data['codsede']!="%")) {
        $sqltext_array[]="tb_deuda_calendario.cod_sede = ?";
        $data_array[]=$data['codsede'];
      } 
      if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
        $sqltext_array[]="tb_deuda_calendario_grupoacad.codigoperiodo = ?";
        $data_array[]=$data['codperiodo'];
      } 
      if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
        $sqltext_array[]="tb_deuda_calendario_grupoacad.codigocarrera = ?";
        $data_array[]=$data['codcarrera'];
      } 
      if (isset($data['codplan']) and ($data['codplan']!="%")) {
        $sqltext_array[]="tb_deuda_calendario_grupoacad.codigoplan = ?";
        $data_array[]=$data['codplan'];
      } 
      if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
        $sqltext_array[]="tb_deuda_calendario_grupoacad.codigociclo = ?";
        $data_array[]=$data['codciclo'];
      }
      if (isset($data['codturno']) and ($data['codturno']!="%")) {
        $sqltext_array[]="tb_deuda_calendario_grupoacad.codigoturno = ?";
        $data_array[]=$data['codturno'];
      }
      if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
        $sqltext_array[]="tb_deuda_calendario_grupoacad.codigoseccion = ?";
        $data_array[]=$data['codseccion'];
      }
      if (isset($data['codgrupo']) and ($data['codgrupo']!="%")) {
        $sqltext_array[]="tb_deuda_calendario_grupoacad.cga_id = ?";
        $data_array[]=$data['codgrupo'];
      }
      if (isset($data['codcalendario']) and ($data['codcalendario']!="%")) {
        $sqltext_array[]="tb_deuda_calendario_grupoacad.cod_deuda_calendario = ?";
        $data_array[]=$data['codcalendario'];
      }
     
      $sqltext=implode(' AND ', $sqltext_array);
      if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
      $result = $this->db->query("SELECT 
            tb_deuda_calendario_grupoacad.cga_id AS codgrupo,
            tb_deuda_calendario.cod_sede AS codsede,
            tb_sede.sed_nombre as sede,
            tb_sede.sed_abreviatura as sede_abrevia,
            tb_deuda_calendario_grupoacad.codigoperiodo AS codperiodo,
            tb_periodo.ped_nombre AS periodo,
            tb_deuda_calendario_grupoacad.codigocarrera AS codcarrera,
            tb_carrera.car_nombre AS carrera,
            tb_carrera.car_sigla AS sigla,
            tb_deuda_calendario_grupoacad.codigoplan AS codplan,
            tb_deuda_calendario_grupoacad.codigoplan AS plan,
            tb_deuda_calendario_grupoacad.codigociclo AS codciclo,
            tb_ciclo.cic_nombre AS ciclo,
            tb_deuda_calendario_grupoacad.codigoturno AS codturno,
            tb_turno.tur_nombre AS turno,
            tb_deuda_calendario_grupoacad.codigoseccion AS codseccion,
            tb_seccion.sec_nombre AS seccion,
            tb_deuda_calendario_grupoacad.cod_deuda_calendario AS codcalendario,
            tb_deuda_calendario.dc_nombre AS calendario 
          FROM
            tb_deuda_calendario_grupoacad
            INNER JOIN tb_periodo ON (tb_deuda_calendario_grupoacad.codigoperiodo = tb_periodo.ped_codigo)
            INNER JOIN tb_carrera ON (tb_deuda_calendario_grupoacad.codigocarrera = tb_carrera.car_id)
            INNER JOIN tb_ciclo ON (tb_deuda_calendario_grupoacad.codigociclo = tb_ciclo.cic_codigo)
            INNER JOIN tb_turno ON (tb_deuda_calendario_grupoacad.codigoturno = tb_turno.tur_codigo)
            INNER JOIN tb_seccion ON (tb_deuda_calendario_grupoacad.codigoseccion = tb_seccion.sec_codigo)
            INNER JOIN tb_deuda_calendario ON (tb_deuda_calendario_grupoacad.cod_deuda_calendario = tb_deuda_calendario.dc_codigo)
            INNER JOIN tb_sede ON (tb_deuda_calendario.cod_sede = tb_sede.id_sede)
          $sqltext
          ORDER BY
            tb_deuda_calendario.cod_sede,
            tb_deuda_calendario_grupoacad.codigoperiodo,
            tb_deuda_calendario_grupoacad.cod_deuda_calendario,
            tb_deuda_calendario_grupoacad.codigocarrera,
            tb_deuda_calendario_grupoacad.codigoplan,
            tb_deuda_calendario_grupoacad.codigociclo,
            tb_deuda_calendario_grupoacad.codigoturno,
            tb_deuda_calendario_grupoacad.codigoseccion",$data_array);
        return $result->result();
  }
  public function m_guardar($data){
        //CALL sp_tb_deuda_calendario_insert( @vdc_nombre, @vdc_fec_inicia, @vdc_fec_culmina, @s, @nid);
    $this->db->query("CALL sp_tb_deuda_calendario_grupoacad_insert(?,?,?,?,?,?,@s,@nid)",$data);
    $res = $this->db->query('select @s as salida,@nid as nid');
    //$this->db->close(); 
    return   $res->row();
  }

  public function fn_eliminarGrupo($id){
    $this->db->where('cga_id', $id);
    $this->db->delete('tb_deuda_calendario_grupoacad');
    return true;
  }

  public function fn_updateGrupo($id,$data){
    //cod_deuda_calendario
    $this->db->where('cga_id', $id);
    $this->db->update('tb_deuda_calendario_grupoacad', $data);
    return true;
  }
  public function m_insertGrupo($data){
    /*'cga_id'=> ,'codigoperiodo'=> ,'codigocarrera'=> ,'codigoplan'=> ,'codigociclo'=> ,'codigoturno'=> ,   'codigoseccion'=> ,'cod_deuda_calendario'=> ,*/
    $this->db->insert('tb_deuda_calendario_grupoacad', $data);
    $rp = new stdClass;
    $rp->id = $this->db->insert_id();
    $rp->salida=($rp->id==0) ? false : true;
    return  $rp;
  }

    //POR JANIOR
    //public function m_get_grupos_xcalendario($data)
    // {
    //       $result = $this->db->query("SELECT 
    //         tb_deuda_calendario_grupoacad.cga_id as codigo,
    //         tb_deuda_calendario_grupoacad.codigoperiodo as periodo,
    //         tb_periodo.ped_nombre as nomperiodo,
    //         tb_deuda_calendario_grupoacad.codigocarrera as carrera,
    //         tb_carrera.car_abreviatura as nomcarrera,
    //         tb_deuda_calendario_grupoacad.codigociclo as ciclo,
    //         tb_ciclo.cic_nombre as nomciclo,
    //         tb_deuda_calendario_grupoacad.codigoturno as turno,
    //         tb_turno.tur_nombre as nomturno,
    //         tb_deuda_calendario_grupoacad.codigoseccion as seccion,
    //         tb_seccion.sec_nombre as nomseccion,
    //         tb_deuda_calendario_grupoacad.cod_deuda_calendario as dcalendarioid
    //       FROM
    //         tb_deuda_calendario_grupoacad
    //         INNER JOIN tb_periodo ON (tb_deuda_calendario_grupoacad.codigoperiodo = tb_periodo.ped_codigo)
    //         INNER JOIN tb_carrera ON (tb_deuda_calendario_grupoacad.codigocarrera = tb_carrera.car_id)
    //         INNER JOIN tb_ciclo ON (tb_deuda_calendario_grupoacad.codigociclo = tb_ciclo.cic_codigo)
    //         INNER JOIN tb_turno ON (tb_deuda_calendario_grupoacad.codigoturno = tb_turno.tur_codigo)
    //         INNER JOIN tb_seccion ON (tb_deuda_calendario_grupoacad.codigoseccion = tb_seccion.sec_codigo)
    //       WHERE
    //         tb_deuda_calendario_grupoacad.cod_deuda_calendario = ?
    //       ORDER BY
    //         tb_deuda_calendario_grupoacad.codigocarrera,tb_deuda_calendario_grupoacad.codigociclo",$data);
    //     return $result->result();
    // }

    public function m_get_grupos_totalDeudasGeneradas($data)
    {
          $result = $this->db->query("SELECT 
  tb_deuda_calendario_grupoacad.cga_id AS codigo,
  tb_deuda_calendario_grupoacad.cod_deuda_calendario AS dcalendarioid,
  tb_deuda_calendario_grupoacad.codigoperiodo AS periodo,
  tb_deuda_calendario_grupoacad.codigocarrera AS carrera,
  tb_deuda_calendario_grupoacad.codigociclo AS ciclo,
  tb_deuda_calendario_grupoacad.codigoturno AS turno,
  tb_deuda_calendario_grupoacad.codigoseccion AS seccion,
  tb_deuda_calendario_fecha_item.dcfi_codigo,
  COUNT(tb_deuda_individual.di_codigo) AS generadas
FROM
  tb_matricula
  INNER JOIN tb_deuda_calendario_grupoacad ON (tb_matricula.codigoperiodo = tb_deuda_calendario_grupoacad.codigoperiodo)
  AND (tb_matricula.codigociclo = tb_deuda_calendario_grupoacad.codigociclo)
  AND (tb_matricula.codigocarrera = tb_deuda_calendario_grupoacad.codigocarrera)
  AND (tb_matricula.codigoturno = tb_deuda_calendario_grupoacad.codigoturno)
  AND (tb_matricula.codigoseccion = tb_deuda_calendario_grupoacad.codigoseccion)
  INNER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
  INNER JOIN tb_deuda_calendario_fecha_item ON (tb_deuda_individual.cal_fecha_item_cod = tb_deuda_calendario_fecha_item.dcfi_codigo)
WHERE
  tb_deuda_calendario_grupoacad.cod_deuda_calendario = ? AND tb_deuda_calendario_fecha_item.codigo_calfecha=?
GROUP BY
  tb_deuda_calendario_grupoacad.cga_id,
  tb_deuda_calendario_grupoacad.cod_deuda_calendario,
  tb_deuda_calendario_grupoacad.codigoperiodo,
  tb_deuda_calendario_grupoacad.codigocarrera,
  tb_deuda_calendario_grupoacad.codigociclo,
  tb_deuda_calendario_grupoacad.codigoturno,
  tb_deuda_calendario_grupoacad.codigoseccion,
  tb_deuda_calendario_fecha_item.dcfi_codigo
ORDER BY
  tb_deuda_calendario_grupoacad.codigoperiodo,
  tb_deuda_calendario_grupoacad.codigocarrera,
  tb_deuda_calendario_grupoacad.codigociclo,
  tb_deuda_calendario_grupoacad.codigoturno,
  tb_deuda_calendario_grupoacad.codigoseccion",$data);
        return $result->result();
    }

    public function m_get_grupos_totalMatriculados($data)
    {
          $result = $this->db->query("SELECT 
            tb_deuda_calendario_grupoacad.cod_deuda_calendario,
            tb_deuda_calendario_grupoacad.cga_id AS codigo,
            tb_deuda_calendario_grupoacad.codigoperiodo AS periodo,
            tb_deuda_calendario_grupoacad.codigocarrera AS carrera,
            tb_deuda_calendario_grupoacad.codigociclo AS ciclo,
            tb_deuda_calendario_grupoacad.codigoturno AS turno,
            tb_deuda_calendario_grupoacad.codigoseccion AS seccion,
            COUNT(tb_matricula.mtr_id) AS matriculados
          FROM
            tb_deuda_calendario_grupoacad
            INNER JOIN tb_deuda_calendario ON (tb_deuda_calendario_grupoacad.cod_deuda_calendario = tb_deuda_calendario.dc_codigo)
            INNER JOIN tb_matricula ON (tb_matricula.codigosede = tb_deuda_calendario.cod_sede)
            AND (tb_matricula.codigoperiodo = tb_deuda_calendario_grupoacad.codigoperiodo)
            AND (tb_matricula.codigociclo = tb_deuda_calendario_grupoacad.codigociclo)
            AND (tb_matricula.codigocarrera = tb_deuda_calendario_grupoacad.codigocarrera)
            AND (tb_matricula.codigoturno = tb_deuda_calendario_grupoacad.codigoturno)
            AND (tb_matricula.codigoseccion = tb_deuda_calendario_grupoacad.codigoseccion)
          WHERE
            tb_deuda_calendario_grupoacad.cod_deuda_calendario = ? 
          GROUP BY
            tb_deuda_calendario_grupoacad.cod_deuda_calendario,
            tb_deuda_calendario_grupoacad.cga_id,
            tb_deuda_calendario_grupoacad.codigoperiodo,
            tb_deuda_calendario_grupoacad.codigocarrera,
            tb_deuda_calendario_grupoacad.codigociclo,
            tb_deuda_calendario_grupoacad.codigoturno,
            tb_deuda_calendario_grupoacad.codigoseccion
          ORDER BY
            tb_deuda_calendario_grupoacad.codigoperiodo,
            tb_deuda_calendario_grupoacad.codigocarrera,
            tb_deuda_calendario_grupoacad.codigociclo,
            tb_deuda_calendario_grupoacad.codigoturno,
            tb_deuda_calendario_grupoacad.codigoseccion",$data);
        return $result->result();
    }



    //NO DEBE IR AQUI
  public function m_deuda_xgrupo_calendario($data)
    {
      $codsede=$_SESSION['userActivo']->idsede;
      $resultmiembro = $this->db->query("
        SELECT  tb_matricula.mtr_id AS codmatricula,
          tb_matricula.codigoinscripcion AS codinscripcion,
          tb_matricula.codigoperiodo AS codperiodo,
          tb_matricula.codigocarrera AS codcarrera,
          tb_matricula.codigociclo AS codciclo,
          tb_matricula.codigoturno AS codturno,
          tb_matricula.codigoseccion AS codseccion,
          tb_matricula.codigoplan AS codplan,
          tb_matricula.mtr_bloquear_evaluaciones AS bloqueo,
          tb_matricula.mtr_cuotapension AS cuota,
          tb_matricula.codigobeneficio AS codbeneficio,
          tb_deuda_individual.di_codigo as coddeuda,
          tb_deuda_individual.cal_fecha_item_cod as codfecha_item,
          tb_deuda_individual.cod_gestion as codgestion,
          tb_deuda_individual.di_saldo as saldo,
          tb_deuda_individual.di_monto as monto 
        FROM
          tb_matricula
          LEFT OUTER JOIN tb_deuda_individual ON (tb_matricula.mtr_id = tb_deuda_individual.matricula_cod)
        WHERE 
          tb_matricula.codigosede = $codsede AND tb_matricula.codigoperiodo LIKE ? AND   tb_matricula.codigocarrera LIKE ? AND 
          tb_matricula.codigociclo LIKE ? AND tb_matricula.codigoturno LIKE ? AND 
          tb_matricula.codigoseccion LIKE ?  AND (tb_deuda_individual.voucher_cod IS NULL OR tb_deuda_individual.voucher_cod=?)", $data);
        return $resultmiembro->result();
    }



  

  public function m_get_grupos_xcalendario_mat($data)
  {
        $result = $this->db->query("SELECT 
          tb_deuda_calendario_grupoacad.cga_id as codigo,
          tb_deuda_calendario_grupoacad.codigoperiodo as periodo,
          tb_periodo.ped_nombre as nomperiodo,
          tb_deuda_calendario_grupoacad.codigocarrera as carrera,
          tb_carrera.car_abreviatura as nomcarrera,
          tb_deuda_calendario_grupoacad.codigociclo as ciclo,
          tb_ciclo.cic_nombre as nomciclo,
          tb_deuda_calendario_grupoacad.codigoturno as turno,
          tb_turno.tur_nombre as nomturno,
          tb_deuda_calendario_grupoacad.codigoseccion as seccion,
          tb_seccion.sec_nombre as nomseccion,
          tb_deuda_calendario_grupoacad.cod_deuda_calendario as dcalendarioid
        FROM
          tb_deuda_calendario_grupoacad
          INNER JOIN tb_deuda_calendario ON (tb_deuda_calendario_grupoacad.cod_deuda_calendario = tb_deuda_calendario.dc_codigo)
          INNER JOIN tb_periodo ON (tb_deuda_calendario_grupoacad.codigoperiodo = tb_periodo.ped_codigo)
          INNER JOIN tb_carrera ON (tb_deuda_calendario_grupoacad.codigocarrera = tb_carrera.car_id)
          INNER JOIN tb_ciclo ON (tb_deuda_calendario_grupoacad.codigociclo = tb_ciclo.cic_codigo)
          INNER JOIN tb_turno ON (tb_deuda_calendario_grupoacad.codigoturno = tb_turno.tur_codigo)
          INNER JOIN tb_seccion ON (tb_deuda_calendario_grupoacad.codigoseccion = tb_seccion.sec_codigo)
        WHERE
          tb_deuda_calendario_grupoacad.codigoperiodo = ? AND tb_deuda_calendario_grupoacad.codigocarrera = ? AND tb_deuda_calendario_grupoacad.codigociclo = ? AND tb_deuda_calendario_grupoacad.codigoturno = ? AND tb_deuda_calendario_grupoacad.codigoseccion = ? AND tb_deuda_calendario.cod_sede = ?
        ORDER BY
          tb_deuda_calendario_grupoacad.codigocarrera,tb_deuda_calendario_grupoacad.codigociclo",$data);
      return $result->row();
  }

  public function m_get_calendario_fecha_mat($data)
  {
        $result = $this->db->query("SELECT 
          tb_deuda_calendario_fecha.dcf_codigo AS codigo,
          tb_deuda_calendario_fecha.dcf_descripcion AS descripcion,
          tb_deuda_calendario_fecha.dcf_fecha AS fecha,
          tb_deuda_calendario_fecha.cod_calendario AS idcalendario
        FROM 
          tb_deuda_calendario_fecha
        WHERE
          tb_deuda_calendario_fecha.cod_calendario = ?", $data);
        return $result->result();
  }

}