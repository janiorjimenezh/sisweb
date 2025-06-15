<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deudas_calendario_fechas_item extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mdeudas_calendario_fecha_item');
		$this->load->model('mdeudas_calendario_grupo');
		//$this->load->model('mdocentes');
		$this->load->model('mauditoria');
	}
	
	public function fn_insertUpdate()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$this->form_validation->set_rules('fictxtcal_fecha','codigo Calendario fecha','trim|required');
			$this->form_validation->set_rules('fictxtcodgestion','codigo gestion','trim|required');
			$this->form_validation->set_rules('fictxt_repite','repite','trim|required');

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
				$dataex['status'] =FALSE;
				$dataex['msg'] ='Ocurrio un error al intentar INSERTAR/EDITAR.';
				$codigo64 = $this->input->post('fictxtcodigo');
				
				$cal_fecha = base64url_decode($this->input->post('fictxtcal_fecha'));
				$codGestion = $this->input->post('fictxtcodgestion');
				$repite = $this->input->post('fictxt_repite');
				$monto = $this->input->post('fictxt_monto');
				$vw_cmdi_cbprontopago = $this->input->post('fictxt_aplicarDscto');
				$vUser = $_SESSION['userActivo'];

				$arrayCFI=array("codigo_calfecha"=> $cal_fecha,"codigogestion"=> $codGestion,"dcfi_repite"=> $repite,"dcfi_monto"=> $monto ,"dcfi_aplicardscto"=>$vw_cmdi_cbprontopago );
				if ($codigo64 == "0") {
					$rptaCFI=$this->mdeudas_calendario_fecha_item->m_insertCalendarioFechaItem($arrayCFI);
					if ($rptaCFI->salida==true){
						$fictxtaccion = "INSERTAR";
						$empleado=$vUser->idusuario." - ".$vUser->paterno." ".$vUser->materno." ".$vUser->nombres;
						$contenido = $empleado.", está agregando una deuda item en la tabla TB_DEUDA_CALENDARIO_FECHA_ITEM COD.".$rptaCFI->id." COD. GESTIÓN: $codGestion";
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($vUser->idusuario, $fictxtaccion, $contenido, $vUser->idsede))
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Registrado correctamente";
					}
				} 
				else {
					$codigo = base64url_decode($codigo64);
					$rptaCFI=$this->mdeudas_calendario_fecha_item->m_updateCalendarioFechaItem($codigo,$arrayCFI);
					if ($rptaCFI->salida==true){
						$fictxtaccion = "EDITAR";
						$empleado=$vUser->idusuario." - ".$vUser->paterno." ".$vUser->materno." ".$vUser->nombres;
						$contenido = $empleado.", está editando una deuda item en la tabla TB_DEUDA_CALENDARIO_FECHA_ITEM COD.".$codigo." COD. GESTIÓN: $codGestion";
						$auditoria = $this->mauditoria->insert_datos_auditoria(array($vUser->idusuario, $fictxtaccion, $contenido, $vUser->idsede))
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Actualizado correctamente";
					}
				}
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
}