<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuesta_egresados extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		//$this->load->model('marea');
		$this->load->model('mcarrera');
		$this->load->model('mbeneficio');
		$this->load->model('mperiodo');
		$this->load->model('mtemporal');
		$this->load->model('mplancurricular');
		$this->load->model('msede');
		$this->load->model('mmatricula');
		$this->load->model('munidaddidactica');
		$this->load->model('mlenguas');
	}
	
	public function index(){
		$ahead= array('page_title' =>'Encuesta Seguimiento Egresados | '.$this->ci->config->item('erp_title') );
		$asidebar= array('menu_padre' =>'egresados','menu_hijo' =>'');
		// $this->load->view('head',$ahead);
		// $this->load->view('nav');
		// $this->load->view('sidebar_academico',$asidebar);
		$arraydts=array();
		$a_ins = $ahead;
		$this->load->model('miestp');
        $a_ins['ies']=$this->miestp->m_get_datos();
        $a_ins['dlenguas']=$this->mlenguas->m_get_lenguas();
        // $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);	
		// $a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();
		// $a_ins['periodos']=$this->mperiodo->m_get_periodos();
		// $a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
		// $a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
		// $a_ins['secciones']=$this->mtemporal->m_get_secciones();
        // $a_ins['planes']=$this->mplancurricular->m_get_planes_activos();
        // $a_ins['estados'] = $this->mmatricula->m_filtrar_estadoalumno();
        // $a_ins['sedes'] = $this->msede->m_get_sedes_activos();
        // $a_ins['cursos'] = $this->munidaddidactica->m_get_unidades_all();
		$this->load->view('egresados/vw_encuesta_egresados_cascara', $a_ins);
		// $this->load->view('footer');
	}


	public function fn_unidades_x_plan()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		$rsoptions="<option value='0'>Sin opciones</option>";
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodigoplan','Búsqueda','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']=validation_errors();
			}
			else
			{
				$busqueda = $this->input->post('txtcodigoplan');

				$unidades = $this->munidaddidactica->m_get_unidades_all_x_plan(array($busqueda));

				if (count($unidades)>0) $rsoptions="<option value=''>Seleccione unidad</option>";
				$grupo = "";
                foreach ($unidades as $key => $und) {
                   $grupoint = $und->idplan;
                   if ($grupo !== $grupoint) {
                    if($grupo!="") $rsoptions=$rsoptions. "</optgroup>";
                      $grupo = $grupoint;
                      $rsoptions=$rsoptions. "<optgroup label='$und->plannom'> ";
                   }
                   $rsoptions=$rsoptions. "<option value='$und->id'>$und->uninom</option>";
                }
				
				$dataex['status'] =TRUE;
			}
		}
		$dataex['vdata'] =$rsoptions;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}
}