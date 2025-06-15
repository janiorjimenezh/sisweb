<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Docspago extends CI_Controller{
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->helper("url"); 
        $this->load->model('mdocspago');
        $this->load->model('mbanco');
        $this->load->model("mfacturacion");
        $this->load->model('mgestion');
        $this->load->model('mgestion');
        $this->load->model('mdoctipo_sede');
	}

    public function vw_documentos_de_pago()
    {
        if (((getPermitido("97") == "SI")) && (($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'AD'))){
            $ahead= array('page_title' =>'Documentos de Pago | Plataforma Virtual '.$this->ci->config->item('erp_title')  );
            $asidebar= array('menu_padre' =>'mn_facturaerp');
            
            $vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
            $codsede=$_SESSION['userActivo']->idsede;
            
            $series=$this->mdoctipo_sede->m_get_docTipoSede(array('codsede' => $codsede,'habilitado'=>"SI"));


            $items=array();
            $filtro_array['codsede']=$codsede;
            $filtro_array['protegelimites']=true;
            $docs=$this->mdocspago->m_getDocsPago($filtro_array);
            $docsCorrelativos=$this->mdocspago->m_getDocsPagoCorrelativosPorSerie($filtro_array);
            $series_array=array();
            foreach ($docs as $keyDoc => $doc) {
                $doc->codigo64=base64url_encode($doc->codigo);
            }
            foreach ($docsCorrelativos as $keyDoc => $doc) {
                $series_array["T".$doc->codtipo."S".$doc->serie]=$doc->numero;
            }
            foreach ($series as $keySerie => $serie) {
                if (array_key_exists("T".$serie->codtipodoc."S".$serie->serie, $series_array)){
                    $serie->minimo=$series_array["T".$serie->codtipodoc."S".$serie->serie];
                }
                else{
                    $serie->minimo=-1;
                }
            }
            $rstdata['series']=$series;
            $rstdata['docspagodata'] = $docs;
            $rstdata['docspagocorrelativo'] = $docsCorrelativos;
            $rstdata['mediosp'] = $this->mfacturacion->m_get_medios_pago();
            $rstdata['bancos'] = $this->mbanco->m_get_bancos(array('activo' => "SI"));
            $rstdata['tipdoc'] = $this->mfacturacion->m_get_tiposdoc();
            $rstdata['unidad'] =$this->mfacturacion->m_get_unidades_habilitados();
            $rstdata['gestion'] =$this->mgestion->m_getGestiones(array('habilitado' =>"SI"));
            $vBody="facturacion/vw_documentos_pago";
        }
        else{
            $vsidebar="sidebar";
            $asidebar= array();
            $rstdata=array();
            $vBody="errors/sin-permisos";
            $ahead= array('page_title' =>'No autorizado | Plataforma Virtual '.$this->ci->config->item('erp_title')  );
        }
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view($vsidebar,$asidebar);
        $this->load->view($vBody, $rstdata);
        $this->load->view('footer');
    }

	public function fn_getDcoumentos(){
		$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $dataex['status'] =FALSE;
            
            $filtro_array=array();
            $filtro_array['codsede']=$_SESSION['userActivo']->idsede;
            if (null !==$this->input->post('coddocpago')){
                $variable=(trim($this->input->post('coddocpago'))=="") ? "%" : trim($this->input->post('coddocpago'));
                $filtro_array['coddocpago']=$variable;
            } 
            if (null !==$this->input->post('serie')){
                $variable=(trim($this->input->post('serie'))=="") ? "%" : trim($this->input->post('serie'));
                $filtro_array['serie']=$variable;
            } 
            if (null !==$this->input->post('nro')){
                $variable=(trim($this->input->post('nro'))=="") ? "%" : trim($this->input->post('nro'));
                $filtro_array['numero']=$variable;
            }
            if (null !==$this->input->post('codtipodoc')){
                $variable=(trim($this->input->post('codtipodoc'))=="") ? "%" : trim($this->input->post('codtipodoc'));
                $filtro_array['codtipodoc']=$variable;
            }
            if (null !==$this->input->post('estadodoc')){
                $variable=(trim($this->input->post('estadodoc'))=="") ? "%" : trim($this->input->post('estadodoc'));
                $filtro_array['estadodoc']=$variable;
            }
            if (null !==$this->input->post('busqueda')){
                $variable=(trim($this->input->post('busqueda'))=="") ? "%" : trim($this->input->post('busqueda'));
                $filtro_array['busqueda']="%".trim($variable)."%";
            }

            //Siemrpe enviar las fechas al final
            $emision= "";
            $emisionf= "";
            if (null !==$this->input->post('fechaini')){
                $variable=(trim($this->input->post('fechaini'))=="") ? "" : trim($this->input->post('fechaini'));
                $emision=$variable;
            }
            if (null !==$this->input->post('fechafin')){
                $variable=(trim($this->input->post('fechafin'))=="") ? "" : trim($this->input->post('fechafin'));
                $emisionf=$variable;
            }
            if ($emision != "" && $emisionf != "") {
                $horaini = ' 00:00:01';
                $horafin = ' 23:59:59';
                $filtro_array['fechaemision'][]=$emision.$horaini;
                $filtro_array['fechaemision'][]=$emisionf.$horafin;
            }
            elseif ($emision == "" && $emisionf == "") {
                
            }
            elseif ($emision == "") {
                $emision='1990-01-01 00:00:01';
                $emisionf=$emisionf.' 23:59:59';
                $filtro_array['fechaemision'][]=$emision;
                $filtro_array['fechaemision'][]=$emisionf;
            }
            else{
                $emision=$emision.' 00:00:01';
                $emisionf=date("Y-m-d").' 23:59:59';
                $filtro_array['fechaemision'][]=$emision;
                $filtro_array['fechaemision'][]=$emisionf;
            }
            $filtro_array['protegelimites']=true;
            $docs=$this->mdocspago->m_getDocsPago($filtro_array);
            foreach ($docs as $keyDoc => $doc) {
                $doc->codigo64=base64url_encode($doc->codigo);
            }
            $dataex['status']  =   TRUE;
            $dataex['data']    =   $docs;
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
	}

	

}
