<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deuda_ajuste extends CI_Controller {
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mdeudas_ajustes');
		$this->load->model('mmatricula');
		$this->load->model('mdeuda');
	}


	public function fn_getDeudaAjustes(){
		$this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $dataex['status'] =FALSE;
            
            $filtro_array=array();
            //$filtro_array['codsede']=$_SESSION['userActivo']->idsede;
            if (null !==$this->input->post('coddeuda64')){
                $variable=base64url_decode($this->input->post('coddeuda64'));
                $filtro_array['coddeuda']=$variable;
            } 
            
            $rowsDeudaAjustes=$this->mdeudas_ajustes->m_getDeudasAjustes($filtro_array);
            foreach ($rowsDeudaAjustes as $keyDoc => $rowAjuste) {
                $rowAjuste->coddeuda64=base64url_encode($rowAjuste->coddeuda);
                $rowAjuste->codajuste64=base64url_encode($rowAjuste->codajuste);
            }
            $dataex['status']  =   TRUE;
            $dataex['data']    =   $rowsDeudaAjustes;
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
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador1.';
			$this->form_validation->set_rules('txtcodajuste64','Código','trim|required');
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
				$dataex['msg'] ='Ocurrio un error';
				$errorInterno=TRUE;
				$vCodigoAjuste="0";
				if (null !==$this->input->post('txtcodajuste64')){
                    $vCodigoAjuste=$this->input->post('txtcodajuste64');
                }
                if (null !==$this->input->post('txtcoddeuda64')){
                    $data_array['cod_deuda']=base64url_decode($this->input->post('txtcoddeuda64'));
                }
                if (null !==$this->input->post('txtsustento')){
                    $data_array['ddi_sustento']=trim($this->input->post('txtsustento'));
                }
                
                if (null !==$this->input->post('cbestado')){
                    $data_array['ddi_estado']=$this->input->post('cbestado');
                    if ($data_array['ddi_estado']=="ANULADO"){
		                $data_array['ddi_anulacion_fecha']=date("Y-m-d H:i:s"); 
		                if (null !==$this->input->post('txtmotivo')){
		                    $data_array['ddi_anulacion_motivo']=trim($this->input->post('txtmotivo'));
		                }
                    }
                }
                
                if (null !==$this->input->post('txtmonto')){
                    $variable=$this->input->post('txtmonto');
                    $data_array['ddi_monto']=$variable;
                    if ($variable==0){

                    	$errors['txtmonto']="El monto de un ajuste no puede ser Cero";
                    	unset($data_array['ddi_monto']);
                    }
                }
                
                $codmatricula=0;
                if (null !==$this->input->post('txtcodmatricula64')){
                    $codmatricula=base64url_decode($this->input->post('txtcodmatricula64'));
                }

                
                if ($errorInterno==TRUE){
                	$dataex['msg'] ='Error al guardar';
                	if ($vCodigoAjuste=="0"){
                		$dataex['msg'] ='Error al Insertar';
                		$data_array['cod_usuario_crea']=$_SESSION['userActivo']->idusuario;
						$rpta=$this->mdeudas_ajustes->m_insertDeudaAjuste($data_array);
					}
					else{
						$dataex['msg'] ='Error al Actualizar';
						$vCodigoAjuste=base64url_decode($vCodigoAjuste);
						$rpta=$this->mdeudas_ajustes->m_updateDeudaAjuste($vCodigoAjuste,$data_array);
					}
					if ($rpta->salida==true){
						$dataex['msg'] ='Error al Sincronizar';
						$this->mdeuda->m_sincronizarAjuste(array('coddeuda' => $data_array['cod_deuda']));
						if ($codmatricula!="0"){
	                        $arrayFiltro= array("codmatricula"=>$codmatricula);
	                        $matriculados=$this->mmatricula->m_getMatriculas($arrayFiltro);
	                        if (count($matriculados)==1){
	                            if ($matriculados[0]->codcalendario!=""){
	                                $this->mdeuda->fnp_GenenarVincularDeudasConPagosAutomaticamente($matriculados[0]->codcalendario,$arrayFiltro);
	                            }
	                        }
	                    }
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Ajuste guardado correctamente";
					}
                }
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_eliminar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('txtcodajuste64','Código','trim|required');
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
				$errorInterno=TRUE;
				$vCodigoAjuste="0";
				if (null !==$this->input->post('txtcodajuste64')){
                    $vCodigoAjuste=base64url_decode($this->input->post('txtcodajuste64'));
                }
                if (null !==$this->input->post('txtcoddeuda64')){
                    $data_array['cod_deuda']=base64url_decode($this->input->post('txtcoddeuda64'));
                }
                $codmatricula=0;
                if (null !==$this->input->post('txtcodmatricula64')){
                    $codmatricula=base64url_decode($this->input->post('txtcodmatricula64'));
                }

                
                if ($errorInterno==TRUE){
                	
					//$data_array['cod_usuario_crea']=$_SESSION['userActivo']->idusuario;
					$rpta=$this->mdeudas_ajustes->m_eliminarDeudaAjuste($vCodigoAjuste);
					
					if ($rpta->salida==true){
						$this->mdeuda->m_sincronizarAjuste(array('coddeuda' => $data_array['cod_deuda']));
						if ($codmatricula!="0"){
	                        $arrayFiltro= array("codmatricula"=>$codmatricula);
	                        $matriculados=$this->mmatricula->m_getMatriculas($arrayFiltro);
	                        if (count($matriculados)==1){
	                            if ($matriculados[0]->codcalendario!=""){
	                                $this->mdeuda->fnp_GenenarVincularDeudasConPagosAutomaticamente($matriculados[0]->codcalendario,$arrayFiltro);
	                            }
	                        }
	                    }
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Ajuste guardado correctamente";
					}
                }
				
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}



}