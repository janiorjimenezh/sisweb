<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Egresados extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('minscrito_egresado');
		$this->load->model('mdiscapacidad');
		$this->load->model('mpublicidad');
		$this->load->model('mauditoria');
		$this->load->model('msede');
	}


	public function index($modalidad="egresados"){
		$modalidadActiva=$modalidad;
		
		$ahead= array('page_title' =>'Egresados | IESTWEB'  );
		$asidebar= array('menu_padre' =>'estudiantes','menu_hijo' =>"est-egresados");
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
		$tipodoc=(null !== $this->input->get('td'))? $this->input->get('td') : "";
		$nrodoc=(null !== $this->input->get('nro'))? $this->input->get('nro') : "";

    	$this->load->view($vsidebar,$asidebar);

		if (getPermitido("45")=='SI'){
			$a_ins['modalidadActiva']=$modalidad;
			$this->load->model('mmodalidad');
			$a_ins['modalidades']=$this->mmodalidad->m_get_modalidades();
			$this->load->model('mperiodo');
			$a_ins['periodos']=$this->mperiodo->m_get_periodos();
			$this->load->model('mcarrera');
			$a_ins['carreras']=$this->mcarrera->m_get_carreras_abiertas_por_sede($_SESSION['userActivo']->idsede);
			$this->load->model('mtemporal');
			$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
			//$this->load->model('mcarrera');
			$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
			//$this->load->model('mcarrera');
			$a_ins['secciones']=$this->mtemporal->m_get_secciones();
			$a_ins['dnipostula']=$nrodoc;
			
        	$a_ins['sedes'] = $this->msede->m_get_sedes_activos();

			$this->load->view('academico/estudiantes/vw_egresados',$a_ins);
		}
		else{

			$this->load->view('errors/sin-permisos');
		}
		$this->load->view('footer');
	}



	public function fnFiltrarEgresados(){
		$this->form_validation->set_message('required', '%s Requerido o digite %%%%%%%%');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres o digite %%%%%%%%.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fbus-txtbuscar','búsqueda','trim');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$busqueda=$this->input->post('fbus-txtbuscar');
				$carrera=$this->input->post('fbus-carrera');
				$modalidad=$this->input->post('fbus-modalidad');
				$periodo=$this->input->post('fbus-periodo');
				$turno=$this->input->post('fbus-turno');
				$campania=$this->input->post('fbus-campania');
				$seccion=$this->input->post('fbus-seccion');
				$ciclo=$this->input->post('fbus-ciclo');
				$sede=$this->input->post('fbus-sede');
				$estado=$this->input->post('fbus-estado');
				$busqueda="%".str_replace(" ","%",trim($busqueda))."%";
       
				$cuentas = $this->minscrito_egresado->mFiltrarEgresados(array('estado'=>$estado,'codperiodo'=>$periodo,'codcarrera'=>$carrera,'codciclo'=>$ciclo,'codsede'=>$sede,'estudiante'=>$busqueda));
				$conteo = count($cuentas);
				foreach ($cuentas as $key => $ins) {
					$ins->idins64 = base64url_encode($ins->codinscripcion);
					$ins->codper64 = base64url_encode($ins->codperiodo);
					$ins->codsed64 = base64url_encode($ins->codsede);
				}
				$rscuentas = $cuentas;

				$dataex['status'] =TRUE;
				$dataex['conteo'] =$conteo;
				
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}
}