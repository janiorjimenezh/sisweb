<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Encuesta_egresados extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mencuesta_egresados');
		$this->load->model('mdiscapacidad');
		$this->load->model('mpublicidad');
		$this->load->model('mauditoria');
		$this->load->model('msede');
	}


	public function fnFiltrarEncuestaEgresados(){
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
			// $this->form_validation->set_rules('fbus-txtbuscar','búsqueda','trim');
			// if ($this->form_validation->run() == FALSE)
			// {
			// 	$dataex['msg']="Existen errores en los campos";
			// 	$errors = array();
		    //     foreach ($this->input->post() as $key => $value){
		    //         $errors[$key] = form_error($key);
		    //     }
		    //     $dataex['errors'] = array_filter($errors);
			// }
			// else
			// {
       			$busqueda=$this->input->post('vw_cue_btnbuscar');
				$carrera=$this->input->post('vw_cue_txtcarrera');
				//$modalidad=$this->input->post('fbus-modalidad');
				//$periodo=$this->input->post('fbus-periodo');
				//$turno=$this->input->post('fbus-turno');
				//$campania=$this->input->post('fbus-campania');
				//$seccion=$this->input->post('fbus-seccion');
				//$ciclo=$this->input->post('fbus-ciclo');
				$sede=$this->input->post('vw_cue_txtsede');
				//$estado=$this->input->post('fbus-estado');
				$busqueda="%".str_replace(" ","%",trim($busqueda))."%";
				$arrayEncuestas= array('codsede' => $sede,"codcarrera"=>$carrera,"buscar"=>$busqueda);
				$cuentas = $this->mencuesta_egresados->m_get_data_encuesta_egresados($arrayEncuestas);
				$conteo = count($cuentas);
				// foreach ($cuentas as $key => $ins) {
				// 	$ins->idins64 = base64url_encode($ins->codinscripcion);
				// 	$ins->codper64 = base64url_encode($ins->codperiodo);
				// 	$ins->codsed64 = base64url_encode($ins->codsede);

				// }
				$rscuentas = $cuentas;

				$dataex['status'] =TRUE;
				$dataex['conteo'] =$conteo;
				
			// }
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

}