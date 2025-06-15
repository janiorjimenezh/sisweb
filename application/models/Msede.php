<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Msede extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_sedes()
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
                      `id_sede` id,
                      `sed_nombre` nombre,
                      `sed_activo` activo
                    FROM 
                      `tb_sede`;");
        return $result->result();
    }

    public function m_get_sede_config_x_codigo($data)
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
          tb_sede.id_sede AS codsede,
          tb_sede.sed_nombre AS sede,
          tb_sede.sed_ruta_nubefact AS nube_ruta,
          tb_sede.sed_token_nubefact AS nube_token,
          tb_sede.conf_docente_agrega_estudiante AS conf_doc_add_est,
          tb_sede.conf_estudiante_ve_notas AS conf_est_notas,
          tb_sede.conf_docente_recuperacion AS conf_doc_rec,
          tb_sede.conf_alumno_descarga_boleta AS conf_des_bol,
          tb_sede.conf_autobloqueo_pago AS conf_autobloqueo_xdeuda,
          tb_sede.conf_autobloqueo_mensaje AS conf_autobloqueo_xdeuda_msj,
          tb_sede.conf_permitir_nsp as conf_permitir_nsp,
          tb_sede.conf_automigrar_notas as conf_migrar_notas,
          tb_sede.email_admision as email_admision,
          tb_sede.email_mesapartes as email_mesa,
          tb_sede.conf_bloqueo_notas_dpi as conf_bloq_pdi,
          tb_sede.conf_sube_foto_estudiante as conf_sube_fotopf,
          tb_sede.conf_dias_anterioridad_docpago as conf_dias_anter,
          tb_sede.conf_permitir_docente_justificar as conf_docente_justifica,
          tb_sede.conf_cierre_automatico_indicador as conf_cierre_automatico_indicador
        FROM
          tb_sede
        WHERE `id_sede` =? LIMIT 1;",$data);
        return $result->row();
    }


    public function m_get_sede_activa()
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
          tb_persona.per_dni AS dni,
          tb_persona.per_apel_paterno AS paterno,
          tb_persona.per_apel_materno AS materno,
          tb_persona.per_nombres AS nombres,
          tb_sede.sed_nombre AS sede
        FROM
          tb_persona
          INNER JOIN tb_sede ON (tb_persona.per_codigo = tb_sede.cod_persona) 
        WHERE tb_sede.id_sede=?",array($_SESSION['userActivo']->idsede));
        return $result->row();
    }


    public function m_get_sedes_por_usuario($data)
    {
        $rsdepa=array();
        $result = $this->db->query("SELECT 
                  tb_usuario_sede.cod_sede idsede,
                  tb_usuario_sede.usse_defecto esdefecto,
                  tb_usuario_sede.usse_activo activo              
                FROM
                  tb_usuario_sede  
                WHERE tb_usuario_sede.cod_usuario=?",$data);
        return $result->result();
    }

     public function mInsert_sede($items)
    {
        $this->db->query("CALL `sp_tb_sede_insert`(?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return $res->row()->out_param;    
    }

    public function mUpdate_sede($items)
    {
        $this->db->query("CALL `sp_tb_sede_update`(?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function mupdate_confactsede($items)
    {
        $this->db->query("CALL `sp_tb_sede_update_facturacion`(?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function mupdate_configuracionsede($items)
    {
        $this->db->query("CALL `sp_tb_sede_update_configuracion`(?,?,?,?,?,?,?,?,?,?,@s)",$items);
        $res = $this->db->query('select @s as out_param');
        
        return   $res->row()->out_param;    
    }

    public function m_get_sedes_all()
    {
        $result = $this->db->query("SELECT 
            tb_sede.id_sede AS id,
            tb_sede.sed_nombre AS nombre,
            tb_sede.cod_distrito AS codist,
            tb_distrito.dis_nombre AS nomdist,
            tb_sede.sed_activo AS activo,
            tb_sede.cod_persona AS percod,
            CONCAT(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS nombres,
            tb_sede.sed_tipo_local AS local
          FROM
            tb_sede
            INNER JOIN tb_distrito ON (tb_sede.cod_distrito = tb_distrito.dis_codigo)
            LEFT OUTER JOIN tb_persona ON (tb_sede.cod_persona = tb_persona.per_codigo)
          ORDER BY
            tb_sede.sed_nombre ");
        return $result->result();
    }

    public function mupdate_data_configuracionsede($id, $data)
    {
        $this->db->where('id_sede', $id);
        $this->db->update('tb_sede', $data);
        
        return true;    
    }

    public function m_get_sedesxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
          tb_sede.id_sede  AS id,
          tb_sede.sed_nombre AS nombre,
          tb_sede.cod_distrito  AS codist,
          tb_distrito.dis_nombre AS nomdist,
          tb_provincia.prv_codigo  AS codprov,
          tb_provincia.prv_nombre  AS nomprov,
          tb_departamento.dep_codigo AS codep,
          tb_departamento.dep_nombre AS nomdep,
          tb_sede.sed_activo AS activo,
          tb_sede.cod_persona AS percod,
          CONCAT(tb_persona.per_apel_paterno,' ',
          tb_persona.per_apel_materno,' ',
          tb_persona.per_nombres) AS nombres,
          tb_sede.sed_tipo_local AS local,
          tb_sede.sed_direccion AS direccion,
          tb_sede.sed_ruta_nubefact as ruta,
          tb_sede.sed_token_nubefact as token,
          tb_sede.conf_docente_agrega_estudiante as docest,
          tb_sede.conf_estudiante_ve_notas as estnot,
          tb_sede.conf_docente_recuperacion as docrec,
          tb_sede.conf_alumno_descarga_boleta as aludesnot,
          tb_sede.conf_autobloqueo_pago as bloqueo,
          tb_sede.conf_permitir_nsp as pernsp,
          tb_sede.conf_automigrar_notas as conf_migrar_notas,
          tb_sede.sed_telefonos as sede_telefonos,
          tb_sede.email_mesapartes as sede_emesa,
          tb_sede.email_admision as sede_eadmision,
          tb_sede.sed_dre as sede_dre,
          tb_sede.sed_centro_poblado as sede_centropoblado,
          tb_sede.conf_bloqueo_notas_dpi as conf_bloq_dpi,
          tb_sede.conf_sube_foto_estudiante as conf_sube_foto,
          tb_sede.conf_dias_anterioridad_docpago as conf_dias_anter
        FROM
          tb_sede
          INNER JOIN tb_distrito ON (tb_sede.cod_distrito = tb_distrito.dis_codigo ) 
          LEFT OUTER JOIN tb_persona ON (tb_sede.cod_persona = tb_persona.per_codigo ) 
          INNER JOIN tb_provincia ON (tb_distrito.cod_provincia = tb_provincia.prv_codigo ) 
          INNER JOIN tb_departamento ON (tb_provincia.cod_departamento = tb_departamento.dep_codigo ) 
        WHERE tb_sede.id_sede = ? LIMIT 1 ", $codigo);
        return $result->row();
    }

    public function m_eliminasede($codigo)
    {
        
        $qry = $this->db->query("DELETE FROM tb_sede where id_sede = ? ", $codigo);
        
        return 1;
    }

    public function m_get_sedes_activos()
    {
        $result = $this->db->query("SELECT 
          tb_sede.id_sede  AS id,
          tb_sede.sed_nombre AS nombre,
          tb_sede.cod_distrito  AS codist,
          tb_sede.sed_activo AS activo,
          tb_sede.cod_persona AS percod,
          tb_sede.sed_tipo_local AS local,
          tb_sede.sed_abreviatura as abrevia 
        FROM
          tb_sede
          WHERE tb_sede.sed_activo = 'SI'
        ORDER BY tb_sede.sed_nombre ASC ");
        return $result->result();
    }

    public function m_get_ciclos()
    {
        $result = $this->db->query("SELECT 
          tb_ciclo.cic_codigo   AS id,
          tb_ciclo.cic_nombre AS nombre,
          tb_ciclo.cic_anios  AS anios,
          tb_ciclo.cic_letras AS letras
        FROM
          tb_ciclo
        ORDER BY tb_ciclo.cic_nombre ASC ");
        return $result->result();
    }

    public function m_get_sedesxnombre($data)
    {
        $result = $this->db->query("SELECT 
            tb_sede.id_sede AS id,
            tb_sede.sed_nombre AS nombre,
            tb_sede.cod_distrito AS codist,
            tb_distrito.dis_nombre AS nomdist,
            tb_sede.sed_activo AS activo,
            tb_sede.cod_persona AS percod,
            CONCAT(tb_persona.per_apel_paterno, ' ', tb_persona.per_apel_materno, ' ', tb_persona.per_nombres) AS nombres,
            tb_sede.sed_tipo_local AS local
          FROM
            tb_sede
            INNER JOIN tb_distrito ON (tb_sede.cod_distrito = tb_distrito.dis_codigo)
            LEFT OUTER JOIN tb_persona ON (tb_sede.cod_persona = tb_persona.per_codigo)
          WHERE tb_sede.sed_nombre like ?
          ORDER BY
            tb_sede.sed_nombre ", $data);
        return $result->result();
    }


}