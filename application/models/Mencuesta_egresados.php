<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mencuesta_egresados extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
    }

    public function m_get_data_encuesta_egresados($data)
    {

        $sqltext_array=array();
        $data_array=array();

        if (isset($data['codsede']) and ($data['codsede']!="%")) {
            $sqltext_array[]="atemp_encuesta_egresados.codigosede = ?";
            $data_array[]=$data['codsede'];
        } 
        if (isset($data['codcarrera']) and ($data['codcarrera']!="%")) {
            $sqltext_array[]="atemp_encuesta_egresados.codigocarrera  = ?";
            $data_array[]=$data['codcarrera'];
        }
        if (isset($data['buscar']) and ($data['buscar']!="%%")) {
            $sqltext_array[]="concat(atemp_encuesta_egresados.Nro,' ',atemp_encuesta_egresados.Egresado)  = ?";
            $data_array[]=$data['buscar'];
        } 
       
        $sqltext=implode(' AND ', $sqltext_array);
        if ($sqltext!="") $sqltext= " WHERE ".$sqltext;
    	$resultdoce = $this->db->query("SELECT 
			  atemp_encuesta_egresados.codigo,
			  atemp_encuesta_egresados.Marca,
			  atemp_encuesta_egresados.Egresado as egresado,
			  atemp_encuesta_egresados.codigosede as codsede,
			  tb_sede.sed_nombre AS sede,
			  atemp_encuesta_egresados.codigocarrera AS codcarrera,
			  tb_carrera.car_nombre AS carrera,
			  atemp_encuesta_egresados.TipoDoc,
			  atemp_encuesta_egresados.Nro AS nrodoc,
			  atemp_encuesta_egresados.Fecha_Nacimiento AS fechanac,
			  atemp_encuesta_egresados.Lugar_Nacmiento AS lugarnac,
			  atemp_encuesta_egresados.genero,
			  atemp_encuesta_egresados.residencia,
			  atemp_encuesta_egresados.celular,
			  atemp_encuesta_egresados.correo,
			  atemp_encuesta_egresados.ruc,
			  atemp_encuesta_egresados.lengua,
			  atemp_encuesta_egresados.estado_civil AS estadocivil,
			  atemp_encuesta_egresados.limitaciones,
			  atemp_encuesta_egresados.nivel,
			  atemp_encuesta_egresados.anio_egreso AS anioegreso,
			  atemp_encuesta_egresados.anio_titulo AS aniotitulo,
			  atemp_encuesta_egresados.motivo,
			  atemp_encuesta_egresados.factor,
			  atemp_encuesta_egresados.beca,
			  atemp_encuesta_egresados.conomientos_tecnicos AS conoctecnico,
			  atemp_encuesta_egresados.ideas,
			  atemp_encuesta_egresados.claridad,
			  atemp_encuesta_egresados.herramientas_informaticas AS herraminform,
			  atemp_encuesta_egresados.trabajo_equipo AS trabequipo,
			  atemp_encuesta_egresados.lengua_extranjera AS lengextranj,
			  atemp_encuesta_egresados.toma_deciciones AS tomadecis,
			  atemp_encuesta_egresados.liderazgo,
			  atemp_encuesta_egresados.conomiento_unidad AS conocunidad,
			  atemp_encuesta_egresados.metodologis AS metodologias,
			  atemp_encuesta_egresados.material,
			  atemp_encuesta_egresados.tiempofuera,
			  atemp_encuesta_egresados.efsrt,
			  atemp_encuesta_egresados.bolsa_trabajo AS bolsatrab,
			  atemp_encuesta_egresados.convenios,
			  atemp_encuesta_egresados.fuera_clase2 AS fueraclase2,
			  atemp_encuesta_egresados.ocupacion,
			  atemp_encuesta_egresados.vinculo,
			  atemp_encuesta_egresados.entidadlabora AS entidadlaboral,
			  atemp_encuesta_egresados.empleo_actual AS empleoactual,
			  atemp_encuesta_egresados.empresa_nombre AS nomempresa,
			  atemp_encuesta_egresados.remneracion AS remuneracion,
			  atemp_encuesta_egresados.satisfacion,
			  atemp_encuesta_egresados.favorecen
			FROM
			  atemp_encuesta_egresados
			  INNER JOIN tb_sede ON (atemp_encuesta_egresados.codigosede = tb_sede.id_sede)
			  AND (atemp_encuesta_egresados.codigosede = tb_sede.id_sede)
			  INNER JOIN tb_carrera ON (atemp_encuesta_egresados.codigocarrera = tb_carrera.car_id)
			$sqltext 
			ORDER BY
			  atemp_encuesta_egresados.codigo DESC",$data_array);
        
        return $resultdoce->result();
    }

   

}