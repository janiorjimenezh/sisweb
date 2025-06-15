<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mtarifario extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function m_updateTarifario($id,$data)
    {
        $this->db->where('tase_codigo', $id);
        $this->db->update('tb_tarifario_sede', $data);
        
        $rp = new stdClass;
        $rp->id=$id;
        $rp->countRows=$this->db->affected_rows();
        $rp->salida=($rp->countRows==0) ? false : true;
        return $rp;
    }

    public function m_insertTarifario($data){
        $this->db->insert('tb_tarifario_sede', $data);

        $rp = new stdClass;
        $rp->id = $this->db->insert_id();
        $rp->salida=($rp->id==0) ? false : true;
        return  $rp;
    }

  public function m_getTarifas($data)
  {
    $sqltext_array=array();

    $data_array=array();
    
    if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigoperiodo = ?";
      $data_array[]=$data['codperiodo'];
    } 
    if (isset($data['codsede']) and ($data['codsede']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigosede = ?";
      $data_array[]=$data['codsede'];
    } 
    if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigocarrera = ?";
      $data_array[]=$data['codcarrera'];
    } 
    if (isset($data['codturno']) and ($data['codturno']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigoturno = ?";
      $data_array[]=$data['codturno'];
    }
    if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigociclo = ?";
      $data_array[]=$data['codciclo'];
    }
    if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigoseccion = ?";
      $data_array[]=$data['codseccion'];
    }
    if (isset($data['codconcepto']) and ($data['codconcepto']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigogestion=?";
      $data_array[]=$data['codconcepto'];
    }
    
    $sqltext=implode(' AND ', $sqltext_array);
    if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

    $result = $this->db->query("SELECT 
              tb_tarifario_sede.tase_codigo AS codtarifa,
              tb_tarifario_sede.codigosede AS codsede,
              tb_tarifario_sede.codigoperiodo AS codperiodo,
              tb_tarifario_sede.codigocarrera AS codcarrera,
              tb_carrera.car_nombre AS carrera,
              tb_carrera.car_sigla AS sigla,
              tb_tarifario_sede.codigociclo AS codciclo,
              tb_tarifario_sede.codigoturno AS codturno,
              tb_tarifario_sede.codigoseccion AS codseccion,
              tb_tarifario_sede.tase_inicia AS inicia,
              tb_tarifario_sede.tase_culmina AS culmina,
              tb_tarifario_sede.tase_habilitado AS habilitado,
              tb_tarifario_sede.tase_observacion AS observacion,
              tb_gestion.gt_categoria AS codcategoria,
              tb_tarifario_sede.codigogestion AS codgestion,
              tb_gestion.gt_nombre AS gestion,
              tb_tarifario_sede.tase_tarifa_real AS tarifa,
              tb_tarifario_sede.tase_tarifa_dscto AS tarifadscto
            FROM
              tb_tarifario_sede
              INNER JOIN tb_gestion ON (tb_tarifario_sede.codigogestion = tb_gestion.gt_codigo)
              LEFT OUTER JOIN tb_carrera ON (tb_tarifario_sede.codigocarrera = tb_carrera.car_id)
            $sqltext
            ORDER BY
                tb_tarifario_sede.codigosede,
                tb_tarifario_sede.codigoperiodo,
                tb_tarifario_sede.codigocarrera,
                tb_tarifario_sede.codigociclo,
                tb_tarifario_sede.codigoturno,
                tb_tarifario_sede.codigoseccion",$data_array);
      return $result->result();
  }

  public function m_getTarifasCompleto($data)
  {
    $sqltext_array=array();

    $data_array=array();
    if (isset($data['tipo']) and ($data['tipo']!="%")) {
      $sqltext_array[]="tb_gestion.gt_tipo = ?";
      $data_array[]=$data['tipo'];
    }
    if (isset($data['codperiodo']) and ($data['codperiodo']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigoperiodo = ?";
      $data_array[]=$data['codperiodo'];
    } 
    if (isset($data['codsede']) and ($data['codsede']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigosede = ?";
      $data_array[]=$data['codsede'];
    } 
    if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigocarrera = ?";
      $data_array[]=$data['codcarrera'];
    } 
    if (isset($data['codturno']) and ($data['codturno']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigoturno = ?";
      $data_array[]=$data['codturno'];
    }
    if (isset($data['codciclo']) and ($data['codciclo']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigociclo = ?";
      $data_array[]=$data['codciclo'];
    }
    if (isset($data['codseccion']) and ($data['codseccion']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigoseccion = ?";
      $data_array[]=$data['codseccion'];
    }
    if (isset($data['codconcepto']) and ($data['codconcepto']!="%")) {
      $sqltext_array[]="tb_tarifario_sede.codigogestion=?";
      $data_array[]=$data['codconcepto'];
    }
    
    $sqltext=implode(' AND ', $sqltext_array);
    if ($sqltext!="") $sqltext= " WHERE ".$sqltext;

    $result = $this->db->query("SELECT 
            tb_tarifario_sede.tase_codigo AS codtarifa,
            tb_gestion.gt_codigo AS codgestion,
            tb_gestion.gt_nombre AS gestion,
            tb_gestion.gt_categoria AS codcategoria,
            tb_tarifario_sede.tase_tarifa_real AS tarifa,
            tb_tarifario_sede.tase_tarifa_dscto AS tarifa_dscto,
            tb_tarifario_sede.tase_inicia AS inicia,
            tb_tarifario_sede.tase_culmina AS culmina,
            tb_tarifario_sede.tase_habilitado AS habilitado,
            tb_gestion.gt_facturar_como AS codgestion_como,
            tb_gestion.cod_tipoafectacion AS codtipoafectacion,
            tb_gestion.cod_unidad AS codunidad,
            tb_gestion.gt_tipo AS tipo,
            tb_tarifario_sede.codigosede AS codsede,
            tb_sede.sed_abreviatura AS sede_abrevia,
            tb_sede.sed_nombre AS sede,
            tb_tarifario_sede.codigoperiodo AS codperiodo,
            tb_periodo.ped_nombre AS periodo,
            tb_tarifario_sede.codigocarrera AS codcarrera,
            tb_carrera.car_nombre AS carrera,
            tb_tarifario_sede.codigociclo AS codciclo,
            tb_ciclo.cic_nombre AS ciclo,
            tb_tarifario_sede.codigoturno AS codturno,
            tb_turno.tur_nombre AS turno,
            tb_tarifario_sede.codigoseccion AS codseccion,
            tb_tarifario_sede.codigoseccion AS seccion
          FROM
            tb_gestion
            INNER JOIN tb_tarifario_sede ON (tb_gestion.gt_codigo = tb_tarifario_sede.codigogestion)
            LEFT OUTER JOIN tb_sede ON (tb_tarifario_sede.codigosede = tb_sede.id_sede)
            LEFT OUTER JOIN tb_periodo ON (tb_tarifario_sede.codigoperiodo = tb_periodo.ped_codigo)
            LEFT OUTER JOIN tb_carrera ON (tb_tarifario_sede.codigocarrera = tb_carrera.car_id)
            LEFT OUTER JOIN tb_ciclo ON (tb_tarifario_sede.codigociclo = tb_ciclo.cic_codigo)
            LEFT OUTER JOIN tb_turno ON (tb_tarifario_sede.codigoturno = tb_turno.tur_codigo)
          $sqltext 
          ORDER BY
            tb_tarifario_sede.codigosede,
            tb_tarifario_sede.codigoperiodo,
            tb_tarifario_sede.codigocarrera,
            tb_tarifario_sede.codigociclo,
            tb_tarifario_sede.codigoturno,
            tb_tarifario_sede.codigoseccion",$data_array);
      return $result->result();
  }


    public function m_getTarifa($tarifas,$data){

      $gllave[]=(isset($data['codsede']))? trim($data['codsede']) : "";
      $gllave[]=(isset($data['codperiodo']))? trim($data['codperiodo']) : "";
      $gllave[]=(isset($data['codcarrera']))? trim($data['codcarrera']) : "";
      $gllave[]=(isset($data['codciclo']))? trim($data['codciclo']) : "";
      $gllave[]=(isset($data['codturno']))? trim($data['codturno']) : "";
      $gllave[]=(isset($data['codseccion']))? trim($data['codseccion']) : "";
      
      //$gllave="$gcodsede.$gcodperiodo.$gcodcarrera.$gcodciclo.$gcodturno.$gcodseccion";     
      $tarifa=array();
      for ($i=5; $i >=0 ; $i--) { 
          // code...
          $gcllave=implode(".", $gllave);
      
          
          $coincidencia=false;
          foreach ($tarifas as $key => $tf) {
              $tcodsede=(is_null($tf->codsede))? "" : $tf->codsede;
              $tcodperiodo=(is_null($tf->codperiodo))? "" : $tf->codperiodo;
              $tcodcarrera=(is_null($tf->codcarrera))? "" : $tf->codcarrera;
              $tcodciclo=(is_null($tf->codciclo))? "" : $tf->codciclo;
              $tcodturno=(is_null($tf->codturno))? "" : $tf->codturno;
              $tcodseccion=(is_null($tf->codseccion))? "" : $tf->codseccion;
              $tllave="$tcodsede.$tcodperiodo.$tcodcarrera.$tcodciclo.$tcodturno.$tcodseccion";
             
              if ($tllave==$gcllave){
                  $coincidencia=true;
                  $tarifa=$tf;
                  break;
              }
          }
          if ($coincidencia==true){
              break;
          }
          else{
              $gllave[$i]="";
          }
      }
      return $tarifa;
    }
}