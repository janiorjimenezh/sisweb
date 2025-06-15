<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manuncio extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_anuncios($data)
    {
        $result = $this->db->query("SELECT 
              tb_carga_anuncios.csas_id id,
              tb_carga_anuncios.cod_cargaacademica carga,
              tb_carga_anuncios.cod_subseccion division,
              tb_carga_anuncios.csas_titulo titulo,
              tb_carga_anuncios.csas_contenido contenido,
              tb_carga_anuncios.csas_publicado publicado,
              tb_carga_anuncios.cod_usuario idusuario,
              tb_persona.per_apel_paterno paterno,
              tb_persona.per_apel_materno materno,
              tb_persona.per_nombres nombre,
              tb_persona.per_foto foto
            FROM 
              tb_carga_anuncios
            INNER JOIN tb_usuario ON (tb_carga_anuncios.cod_usuario = tb_usuario.id_usuario)
            INNER JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
          WHERE 
              tb_carga_anuncios.cod_cargaacademica = ? AND tb_carga_anuncios.cod_subseccion = ?
        ORDER BY tb_carga_anuncios.csas_publicado DESC ", $data);

        return $result->result();
    }

    public function mInsert_anuncio($items)
    {
        $this->db->query("CALL `sp_tb_carga_anuncios_insert`(?,?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();    
    }

    public function mUpdate_anuncio($items)
    {
        $this->db->query("CALL `sp_tb_carga_anuncios_update`(?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();    
    }

    public function mInsert_anuncio_estudiante($items)
    {
        $this->db->query("CALL `sp_tb_carga_anuncios_estudiante_insert`(?,?,?,?,?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return $res->row();    
    }

    public function m_filtrar_anuncioxcodigo($codigo)
    {
        $result = $this->db->query("SELECT 
              tb_carga_anuncios.csas_id id,
              tb_carga_anuncios.cod_cargaacademica carga,
              tb_carga_anuncios.cod_subseccion division,
              tb_carga_anuncios.csas_titulo titulo,
              tb_carga_anuncios.csas_contenido contenido,
              tb_carga_anuncios.csas_publicado publicado,
              tb_carga_anuncios.cod_usuario idusuario
            FROM
              tb_carga_anuncios
            WHERE tb_carga_anuncios.csas_id = ? LIMIT 1 ", $codigo);

            return $result->row();
    }

    public function m_get_carga_subseccion_anuncios($data)
    {
        $result = $this->db->query("SELECT 
              tb_carga_anuncios.csas_id id,
              tb_carga_anuncios.cod_cargaacademica carga,
              tb_carga_anuncios.cod_subseccion division,
              tb_carga_anuncios.csas_titulo titulo,
              tb_carga_anuncios.csas_contenido contenido,
              tb_carga_anuncios.csas_publicado publicado,
              tb_carga_anuncios.cod_usuario idusuario,
              tb_carga_anuncios_estudiante.cae_leido leido,
              tb_carga_anuncios_estudiante.cae_fecha_leido fecleido,
              tb_persona.per_apel_paterno paterno,
              tb_persona.per_apel_materno materno,
              tb_persona.per_nombres nombre,
              tb_persona.per_foto foto
            FROM
              tb_carga_anuncios
            INNER JOIN tb_carga_anuncios_estudiante ON (tb_carga_anuncios.csas_id = tb_carga_anuncios_estudiante.cod_anuncios)
            INNER JOIN tb_usuario ON (tb_carga_anuncios.cod_usuario = tb_usuario.id_usuario)
            INNER JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
            WHERE tb_carga_anuncios.cod_cargaacademica = ? AND tb_carga_anuncios.cod_subseccion = ? AND tb_carga_anuncios_estudiante.miembro_id = ? 
            ORDER BY tb_carga_anuncios.csas_publicado DESC", $data);

            return $result->result();
    }

    public function m_get_anunciosxcarga_subseccion($data)
    {
        $result = $this->db->query("SELECT 
              tb_carga_anuncios.csas_id id,
              tb_carga_anuncios.cod_cargaacademica carga,
              tb_carga_anuncios.cod_subseccion division,
              tb_carga_anuncios.csas_titulo titulo,
              tb_carga_anuncios.csas_contenido contenido,
              tb_carga_anuncios.csas_publicado publicado,
              tb_carga_anuncios.cod_usuario idusuario,
              tb_persona.per_apel_paterno paterno,
              tb_persona.per_apel_materno materno,
              tb_persona.per_nombres nombre,
              tb_persona.per_foto foto,
              tb_carga_anuncios_estudiante.cae_leido leido
            FROM
              tb_carga_anuncios
            INNER JOIN tb_usuario ON (tb_carga_anuncios.cod_usuario = tb_usuario.id_usuario)
            INNER JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
            INNER JOIN tb_carga_anuncios_estudiante ON (tb_carga_anuncios.csas_id = tb_carga_anuncios_estudiante.cod_anuncios)
            WHERE tb_carga_anuncios.cod_cargaacademica = ? AND tb_carga_anuncios.cod_subseccion = ? AND tb_carga_anuncios.csas_id = ? AND tb_carga_anuncios_estudiante.miembro_id = ? LIMIT 1 ", $data);

            return $result->row();
    }

    public function m_get_carga_subseccionanuncios($data)
    {
        $result = $this->db->query("SELECT 
              tb_carga_anuncios.csas_id id,
              tb_carga_anuncios.cod_cargaacademica carga,
              tb_carga_anuncios.cod_subseccion division,
              tb_carga_anuncios.csas_titulo titulo,
              tb_carga_anuncios.csas_contenido contenido,
              tb_carga_anuncios.csas_publicado publicado,
              tb_carga_anuncios.cod_usuario idusuario,
              tb_persona.per_apel_paterno paterno,
              tb_persona.per_apel_materno materno,
              tb_persona.per_nombres nombre,
              tb_persona.per_foto foto,
              tb_unidad_didactica.undd_nombre AS unidad
            FROM
              tb_carga_anuncios
            INNER JOIN tb_usuario ON (tb_carga_anuncios.cod_usuario = tb_usuario.id_usuario)
            INNER JOIN tb_persona ON (tb_usuario.cod_persona = tb_persona.per_codigo)
            INNER JOIN tb_carga_academica ON (tb_carga_anuncios.cod_cargaacademica = tb_carga_academica.cac_id)
            INNER JOIN tb_unidad_didactica ON (tb_carga_academica.codigouindidadd = tb_unidad_didactica.undd_codigo)
            WHERE tb_carga_anuncios.cod_cargaacademica = ? AND tb_carga_anuncios.cod_subseccion = ? AND tb_carga_anuncios.csas_id = ? LIMIT 1 ", $data);

            return $result->row();
    }

    public function m_update_anuncio_leido($data)
    {
        $result = $this->db->query("UPDATE 
              tb_carga_anuncios_estudiante
            SET 
              tb_carga_anuncios_estudiante.cae_leido = ?,
              tb_carga_anuncios_estudiante.cae_fecha_leido = ?
            WHERE tb_carga_anuncios_estudiante.codigocarga = ? AND tb_carga_anuncios_estudiante.codigosubseccion = ? AND tb_carga_anuncios_estudiante.cod_anuncios = ? AND tb_carga_anuncios_estudiante.miembro_id = ? ", $data);

            return 1;
    }

    public function m_eliminaanuncio($items)
    {
        $this->db->query("CALL `sp_tb_carga_anuncios_delete`(?,@s,@nid)",$items);
        $res = $this->db->query('select @s as salida,@nid as newcod');
        
        return   $res->row();
    }


}

