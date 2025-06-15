<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarifario extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mauditoria');
		$this->load->model('mtarifario');
		$this->load->model('mperiodo');
		$this->load->model('mcarrera');
		$this->load->model('mciclo');
		$this->load->model('mturno');
		$this->load->model('mseccion');
		$this->load->model('mgestion');
		$this->load->model('mtarifario');
	}
	

	public function vw_tarifario(){
		if (getPermitido("243")=='SI'){
			$this->ci=& get_instance();

			$vUser=$codsede=$_SESSION['userActivo'];
			$ahead= array('page_title' =>'Tarifario - '.$this->ci->config->item('erp_title'));
			$asidebar= array('menu_padre' =>'mn_tarifario','menu_hijo' =>'');
			$this->load->view('head',$ahead);
			$this->load->view('nav');
			$this->load->view('sidebar_facturacion',$asidebar);
			$arraydts['turnos'] = $this->mturno->m_getTurnos(array('activo' => "SI"));
			$arraydts['carrera'] = $this->mcarrera->m_getCarreras();
			$arraydts['ciclo'] = $this->mciclo->m_getCiclos();
			
			$arraydts['secciones']=$this->mseccion->m_getSecciones();
			//$arraydts['gestion'] =$this->mgestion->m_get_gestionxestado();
			//////////////////////
			$arraydts['periodos'] = $this->mperiodo->m_get_periodos();
			$this->load->model('msede');
			$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
			$this->load->model('mbeneficio');
			$arraydts['beneficios'] = $this->mbeneficio->m_get_beneficios();
			$this->load->model('mmatricula');
			$arraydts['estados'] = $this->mmatricula->m_filtrar_estadoalumno();
			$this->load->model('mplancurricular');
			$arraydts['planes'] =$this->mplancurricular->m_get_planes_activos();
			$arraydts['gestion'] =$this->mgestion->m_getGestiones(array('habilitado' =>"SI",'tipo' =>"GENERAL"));
			$vTarifas=$this->mtarifario->m_getTarifasCompleto(array('tipo' =>"GENERAL",'codsede'=>$vUser->idsede));
			foreach ($vTarifas as $keytf => $tf) {
				$tf->codtarifa64=base64url_encode($tf->codtarifa);
			}
			$arraydts['tarifario'] =$vTarifas;
			/////////////////////////
			//$arraydts = $arraydts + $this->mperiodo->m_periodos();
			//$this->load->view('deudas/individual/vw_principal', $arraydts);
			$this->load->view('tesoreria/tarifario/vw_tarifario', $arraydts);
			$this->load->view('footer');
		}
		else{
			//$this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function fn_getTarifa(){

		$this->form_validation->set_message('required', '%s Requerido');
        date_default_timezone_set ('America/Lima');
        
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        $data["mats"]=array();
        $dataex['tarifa']=array();
        $tarifa=array();
        if ($this->input->is_ajax_request())
        {
			$this->form_validation->set_message('required', '%s Requerido');
			$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
			$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
			$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
				
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
				$grupo_array=array(); 
				$tarifas_array=array(); 
	            $grupo_array['codsede']=$_SESSION['userActivo']->idsede;
	            $tarifas_array['codsede']=$_SESSION['userActivo']->idsede;
	            if (null !==$this->input->post('txtcodperiodo')){
	                $variable=(trim($this->input->post('txtcodperiodo'))=="0") ? "" : trim($this->input->post('txtcodperiodo'));
	                if ($variable!="%") $fmtCodInscripcion=base64url_decode($variable);
	                $grupo_array['codperiodo']=$variable;
	                $tarifas_array['codperiodo']=$variable;
	            } 
	            if (null !==$this->input->post('txtcodcarrera')){
	                $variable=(trim($this->input->post('txtcodcarrera'))=="0") ? "" : trim($this->input->post('txtcodcarrera'));
	                $grupo_array['codcarrera']=$variable;
	                $tarifas_array['codcarrera']=$variable;
	            } 
	            if (null !==$this->input->post('txtcodciclo')){
	                $variable=(trim($this->input->post('txtcodciclo'))=="0") ? "" : trim($this->input->post('txtcodciclo'));
	                $grupo_array['codciclo']=$variable;
	            } 
	           	if (null !==$this->input->post('txtcodturno')){
	                $variable=(trim($this->input->post('txtcodturno'))=="0") ? "" : trim($this->input->post('txtcodturno'));
	                $grupo_array['codturno']=$variable;
	            } 
	            if (null !==$this->input->post('txtcodseccion')){
	                $variable=(trim($this->input->post('txtcodseccion'))=="0") ? "" : trim($this->input->post('txtcodseccion'));
	                $grupo_array['codseccion']=$variable;
	            } 
	            if (null !==$this->input->post('txtcodconcepto')){
	                $variable=(trim($this->input->post('txtcodconcepto'))=="0") ? "" : trim($this->input->post('txtcodconcepto'));
	                $tarifas_array['codconcepto']=$variable;
	            } 
	            //$tarifas_array["codconcepto"]="02.10";
	            $tarifas=$this->mtarifario->m_getTarifas($tarifas_array);
	            $tarifa=$this->mtarifario->m_getTarifa($tarifas,$grupo_array);
			$dataex['status'] =true;
			
			$dataex['tarifa'] = $tarifa;
		}

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_getTarifas(){

		$this->form_validation->set_message('required', '%s Requerido');
        date_default_timezone_set ('America/Lima');
        
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        $data["mats"]=array();
        $dataex['tarifa']=array();
        $tarifa=array();
        if ($this->input->is_ajax_request())
        {
			$this->form_validation->set_message('required', '%s Requerido');
			$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
			$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
			$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
				
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';


				
				$grupo_array=array(); 
				$tarifas_array=array(); 
	            $grupo_array['codsede']=$_SESSION['userActivo']->idsede;
	            $tarifas_array['codsede']=$_SESSION['userActivo']->idsede;
	            if (null !==$this->input->post('txtcodperiodo')){
	                $variable=(trim($this->input->post('txtcodperiodo'))=="0") ? "" : trim($this->input->post('txtcodperiodo'));
	                if ($variable!="%") $fmtCodInscripcion=base64url_decode($variable);
	                $grupo_array['codperiodo']=$variable;
	                $tarifas_array['codperiodo']=$variable;
	            } 
	            if (null !==$this->input->post('txtcodcarrera')){
	                $variable=(trim($this->input->post('txtcodcarrera'))=="0") ? "" : trim($this->input->post('txtcodcarrera'));
	                $grupo_array['codcarrera']=$variable;
	                $tarifas_array['codcarrera']=$variable;
	            } 
	            if (null !==$this->input->post('txtcodciclo')){
	                $variable=(trim($this->input->post('txtcodciclo'))=="0") ? "" : trim($this->input->post('txtcodciclo'));
	                $grupo_array['codciclo']=$variable;
	            } 
	           	if (null !==$this->input->post('txtcodturno')){
	                $variable=(trim($this->input->post('txtcodturno'))=="0") ? "" : trim($this->input->post('txtcodturno'));
	                $grupo_array['codturno']=$variable;
	            } 
	            if (null !==$this->input->post('txtcodseccion')){
	                $variable=(trim($this->input->post('txtcodseccion'))=="0") ? "" : trim($this->input->post('txtcodseccion'));
	                $grupo_array['codseccion']=$variable;
	            } 
	            if (null !==$this->input->post('txtcodconcepto')){
	                $variable=(trim($this->input->post('txtcodconcepto'))=="0") ? "" : trim($this->input->post('txtcodconcepto'));
	                $tarifas_array['codconcepto']=$variable;
	            } 
	            //$tarifas_array["codconcepto"]="02.10";
	            $tarifas=$this->mtarifario->m_getTarifas($tarifas_array);
	            $tarifa=$this->mtarifario->m_getTarifa($tarifas,$grupo_array);
			$dataex['status'] =true;
			
			$dataex['tarifa'] = $tarifa;
		}

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_guardar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodtarifa64','Código','trim|required');
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
				$errorInterno=FALSE;
				$vCodigoTarifa="0";
				// `tase_codigo`
				// ``
				// `codigoperiodo`
				// `codigocarrera`
				// `codigociclo`
				// `codigoturno`
				// `codigoseccion`
				// ``
				// ``
				// `tase_tarifa_dscto`
				// `tase_inicia`
				// `tase_culmina`

				$data_array=array();
				$cambios_array=array();
				if (null !==$this->input->post('txtcodtarifa64')){
                    $vCodigoTarifa=$this->input->post('txtcodtarifa64');
                }
                if (null !==$this->input->post('txtcodsede')){
                    $data_array['codigosede']=$this->input->post('txtcodsede');
                    $cambios_array[]="CODSEDE: ".$data_array['codigosede'];
                }
                if (null !==$this->input->post('txtcodgestion')){
                    $data_array['codigogestion']=trim($this->input->post('txtcodgestion'));
                    $cambios_array[]="CODGESTION: ".$data_array['codigogestion'];
                }
                if (null !==$this->input->post('txttarifa')){
                    $data_array['tase_tarifa_real']=trim($this->input->post('txttarifa'));
                    $cambios_array[]="TARIFA: ".$data_array['tase_tarifa_real'];
                }
                if (null !==$this->input->post('txthabilitado')){
                    $data_array['tase_habilitado']=trim($this->input->post('txthabilitado'));
                    $cambios_array[]="HABILITADO: ".$data_array['tase_habilitado'];
                }
                if (null !==$this->input->post('txtobservacion')){
                    $data_array['tase_observacion']=trim($this->input->post('txtobservacion'));
                    $cambios_array[]="OBS.: ".$data_array['tase_observacion'];
                }

                $accion = "EDITAR";
				if (trim($vCodigoTarifa)=="0"){
					$accion = "INSERTAR";
					
					$rpta=$this->mtarifario->m_insertTarifario($data_array);
					$contenido =", esta generando una nueva tarifa con los datos: ".implode(",",$cambios_array)." en la tabla TB_TARIFARIO_SEDE CÓD.".$rpta->id;
				}
				else{
					$vCodigoTarifa=base64url_decode($vCodigoTarifa);
					$rpta=$this->mtarifario->m_updateTarifario($vCodigoTarifa,$data_array);
					$contenido =", esta actualizando una tarifa con los datos: ".implode(",",$cambios_array)." en la tabla TB_TARIFARIO_SEDE CÓD.".$rpta->id;
				}
				//$dataex['rpta'] =$rpta;
				if ($rpta->salida==true){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Tarifa guardada correctamente";
					//AUDITORIA
					$usuario=$codsede=$_SESSION['userActivo'];
					
					$contenido = $usuario->usuario." - ".$usuario->paterno." ".$usuario->materno." ".$usuario->nombres.$contenido;
					$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario->idusuario, $accion, $contenido, $usuario->idsede));
				
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


}