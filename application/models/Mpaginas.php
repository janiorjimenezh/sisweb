<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpaginas extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function m_get_paginas()
    {
        $result = $this->db->query("SELECT 
            `wpg_codigo` as codigo,
            `wpg_titulo` as titulo,
            `wpg_descripcion` as descripcion,
            `wpg_url` as url,
            `wpg_estado` as estado
          FROM 
            `tb_web_paginas`;");

        return $result->result();
    }

    public function m_get_pagina($data)
    {
        $result = $this->db->query("SELECT 
            `wpg_codigo` as codigo,
            `wpg_titulo` as titulo,
            `wpg_descripcion` as descripcion,
            `wpg_url` as url,
            `wpg_contenido` as contenido,
            `wpg_estado` as estado
          FROM 
            `tb_web_paginas` 
          WHERE wpg_codigo=?;",$data);

        return $result->row();
    }

    public function m_get_paginas_secciones($data)
    {
        $result = $this->db->query("SELECT 
          wps_codigo as codigo,
          web_pagina_codigo as codpagina,
          wps_nombre as titulo,
          wps_contenido as contenido,
          wps_esdefecto as esdefecto,
          wps_orden as orden 
        FROM 
          tb_web_paginas_seccion 
        WHERE web_pagina_codigo=?;",$data);

        return $result->result();
    }

    public function m_updatePagina($data){
        $this->db->query("UPDATE  `tb_web_paginas`  
          SET 
            `wpg_titulo` = ?,
            `wpg_descripcion` = ?,
            `wpg_contenido` = ?,
            `wpg_url` = ?,
            `wpg_estado` = ?  
          WHERE 
            `wpg_codigo` = ?;",$data);
        
    }

    public function m_updatePaginaSeccion($data){
        $this->db->query("UPDATE `tb_web_paginas_seccion`  
          SET 
            `web_pagina_codigo` = ?,
            `wps_nombre` = ?,
            `wps_contenido` = ?,
            `wps_esdefecto` = ?,
            `wps_orden` = ? 
          WHERE 
            `wps_codigo` = ?;",$data);
        
    }



    


  }