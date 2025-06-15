<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cronograma extends CI_Controller {
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mperiodo');
		$this->load->model('mcarrera');
		$this->load->model('mseccion');
		$this->load->model('mdeudas_calendario');
		$this->load->model('mdeudas_calendario_fecha');
		$this->load->model('mturno');
		$this->load->model('mciclo');
		$this->load->model('mplancurricular');
		
		$this->load->model('mgestion');
		
	}

	public function vw_principal(){
		if (getPermitido("106")=='SI'){
			$ahead= array('page_title' =>'Cronogramas - '.$this->ci->config->item('erp_title')  );
			$asidebar= array('menu_padre' =>'mnts_cronogramas','menu_hijo' =>'mh_dd_calendario');
			$this->load->view('head',$ahead);
			$this->load->view('nav');

			$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        	$this->load->view($vsidebar,$asidebar);


			//$this->load->view('sidebar_facturacion',$asidebar);
			$arraydts['periodos'] = $this->mperiodo->m_get_periodos();
			$this->load->model('msede');
			$arraydts['sedes'] = $this->msede->m_get_sedes_activos();
			$arraydts['turnos'] = $this->mturno->m_getTurnos(array('activo' => "SI"));
			$arraydts['carrera'] = $this->mcarrera->m_getCarreras();
			$arraydts['planes'] = $this->mplancurricular->m_getPlanesEstudio();
			$arraydts['ciclos'] = $this->mciclo->m_getCiclos();
			$arraydts['secciones'] = $this->mseccion->m_getSecciones();
			
			$arraydts['gestion'] =$this->mgestion->m_getGestiones(array('habilitado' =>"SI"));
			$this->load->view('tesoreria/cronograma/vw_cronogramas', $arraydts);
			$this->load->view('footer');
		}
		else{
			//$this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function fn_getCalendariosPorSedePeriodo()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		/*$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');*/

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_dc_cbperiodo','Periodo','trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
		        $dataex['msg']=validation_errors();
			}
			else
			{
				$vw_dc_cbperiodo=$this->input->post('vw_dc_cbperiodo');
				$vw_dc_cbsede=$this->input->post('vw_dc_cbsede');
				$calendarios=$this->mdeudas_calendario->m_getCalendarios(array("codsede"=>$vw_dc_cbsede,"codperiodo"=>$vw_dc_cbperiodo));
				$fechas=$this->mdeudas_calendario_fecha->m_getFechas(array("codsede"=>$vw_dc_cbsede,"codperiodo"=>$vw_dc_cbperiodo));
				
				foreach ($calendarios as $key => $calendario) {
					$calendario->codigo64=base64url_encode($calendario->codigo);
					$calendario->cerrar_i1DDMMYYYY=date("d-m-Y", strtotime($calendario->cerrar_i1));
					$calendario->cerrar_i2DDMMYYYY=date("d-m-Y", strtotime($calendario->cerrar_i2));
					$calendario->cerrar_i3DDMMYYYY=date("d-m-Y", strtotime($calendario->cerrar_i3));
					$calendario->fechas=array();
					foreach ($fechas as $keyfecha => $fecha) {
						if ($calendario->codigo==$fecha->codcalendario){
							$fecha->fechaDDMMYYYY=date("d-m-Y", strtotime($fecha->fecha));
							$calendario->fechas[]=$fecha;
						}
					}
				}

				$dataex['vdata']=$calendarios;
				$dataex['status'] =TRUE;
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_guardar()
	{
		$this->form_validation->set_message('required', '%s Requerido');

		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('vw_dci_txtcodigo','Código','trim|required');
			$this->form_validation->set_rules('vw_dci_txtnombre','Nombre periodo','trim|required');
			$this->form_validation->set_rules('vw_dci_txtinicia','Inicia','trim|required');
			$this->form_validation->set_rules('vw_dci_txtculmina','Culmina','trim|required');
			$this->form_validation->set_rules('vw_dci_cbperiodo','Periodo','trim|required');

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
				$vw_dci_codigo=$this->input->post('vw_dci_txtcodigo');
				$vw_dci_nombre=strtoupper($this->input->post('vw_dci_txtnombre'));
				$vw_dci_inicia=$this->input->post('vw_dci_txtinicia');
				$vw_dci_culmina=$this->input->post('vw_dci_txtculmina');
				$vw_dci_cbperiodo=$this->input->post('vw_dci_cbperiodo');
				$vw_dci_txtConsolidarRetiros=$this->input->post('vw_dci_txtConsolidarRetiros');
				$vw_dci_txtcerrarUD=$this->input->post('vw_dci_txtcerrarUD');
				$vw_dci_txtCerrar1=$this->input->post('vw_dci_txtCerrar1');
				$vw_dci_txtCerrar2=$this->input->post('vw_dci_txtCerrar2');
				$vw_dci_txtCerrar3=$this->input->post('vw_dci_txtCerrar3');

				$vUser = $_SESSION['userActivo'];
				$fictxtaccion = "INSERTAR";
				$arrayDatos=array();
				if ($vw_dci_codigo=="0"){
					$arrayDatos=array("dc_nombre"=>$vw_dci_nombre, "dc_fec_inicia"=>$vw_dci_inicia, "dc_fec_culmina"=>$vw_dci_culmina,"dc_fecha_cierre_ud"=>$vw_dci_txtcerrarUD,"dc_fecha_consolida_retiros"=>$vw_dci_txtConsolidarRetiros,"cod_periodo"=>$vw_dci_cbperiodo,"cod_sede"=>$vUser->idsede,"dc_cerrar_i1"=>$vw_dci_txtCerrar1, "dc_cerrar_i2"=>$vw_dci_txtCerrar2, "dc_cerrar_i3"=>$vw_dci_txtCerrar3);
					$rpta=$this->mdeudas_calendario->m_insertCalendario($arrayDatos);
					$contenido = ", está creando un CRONOGRAMA en la tabla TB_DEUDA_CALENDARIO COD.".$vw_dci_codigo;
				}
				else{
					$vw_dci_codigo=base64url_decode($vw_dci_codigo);
					$arrayDatos=array("dc_nombre"=>$vw_dci_nombre, "dc_fec_inicia"=>$vw_dci_inicia, "dc_fec_culmina"=>$vw_dci_culmina,"dc_fecha_cierre_ud"=>$vw_dci_txtcerrarUD,"dc_fecha_consolida_retiros"=>$vw_dci_txtConsolidarRetiros,"dc_cerrar_i1"=>$vw_dci_txtCerrar1, "dc_cerrar_i2"=>$vw_dci_txtCerrar2, "dc_cerrar_i3"=>$vw_dci_txtCerrar3);
					$rpta=$this->mdeudas_calendario->m_updateCalendario($vw_dci_codigo,$arrayDatos);
					$fictxtaccion = "EDITAR";
					$contenido = ", está editando un CRONOGRAMA en la tabla TB_DEUDA_CALENDARIO COD.".$vw_dci_codigo;
				}
				$dataex['rpta'] =$rpta;
				if ($rpta->salida==true){
					$clienteIP=$_SERVER['REMOTE_ADDR'];
					$clienteDatos= $_SERVER['HTTP_USER_AGENT'];
					$datos=mapped_implode(', ', $arrayDatos, ': ');
					$dataex['status'] =TRUE;
					$clienteMetodoLogin=(isset($_SESSION['access_token'])) ? "GOOGLE":"SINCRO";
					$dataex['msg'] ="Conograma registrado correctamente";
					$empleado=$vUser->idusuario." - ".$vUser->paterno." ".$vUser->materno." ".$vUser->nombres;
					$contenido = "$empleado $contenido";
					$arrayAuditoria=array('cod_usuario'=>$vUser->idusuario, 'rs_accion'=>$fictxtaccion, 'rs_descripcion'=>$contenido, 'cod_sede'=>$vUser->idsede,'rs_datos'=>$datos,'rs_clienteip'=>$clienteIP,'rs_clientedatos'=>$clienteDatos,'rs_loginmetodo'=>$clienteMetodoLogin);
					$auditoria = $this->mauditoria->m_insertAuditoria($arrayAuditoria);
					$dataex['auditoria'] =$auditoria->salida;
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
}