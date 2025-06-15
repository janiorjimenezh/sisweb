<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deuda extends CI_Controller {
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('mperiodo');
		$this->load->model('mcarrera');
		$this->load->model('mciclo');
		$this->load->model('mturno');
		$this->load->model('mseccion');
		$this->load->model('mgestion');
		$this->load->model('mdeudas_individual');
		$this->load->model('mfacturacion_detalle');
        $this->load->model('mdeudas_calendario_grupo');

		$this->load->model('mdeuda');
		
		
	}
	public function vw_principal(){
		if (getPermitido("105")=='SI'){
			$this->ci=& get_instance();
			$ahead= array('page_title' =>'Deudas - '.$this->ci->config->item('erp_title')  );
			$asidebar= array('menu_padre' =>'mn_deudas','menu_hijo' =>'mh_dd_individual');
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
			$arraydts['gestion'] =$this->mgestion->m_getGestiones(array('habilitado' =>"SI"));
			/////////////////////////
			//$arraydts = $arraydts + $this->mperiodo->m_periodos();
			//$this->load->view('deudas/individual/vw_principal', $arraydts);
			$this->load->view('tesoreria/deudas/vw_deudas', $arraydts);
			$this->load->view('footer');
		}
		else{
			//$this->vwh_nopermitido("NO AUTORIZADO - ERP");
		}
	}

	public function fn_GenenarVincularDeudasConPagosAutomaticamente_PorGrupo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    	date_default_timezone_set ('America/Lima');
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$codCalendario=base64url_decode($this->input->post('txtcodcalendario64'));
			$codGrupoCalendario64=$this->input->post('txtcodgrupo64');
			$codGrupoCalendario="%";
			if ($codGrupoCalendario64!="%"){
				$codGrupoCalendario=base64url_decode($this->input->post('txtcodgrupo64'));
			}
			
            $grupos=$this->mdeudas_calendario_grupo->m_getGrupos(array('codcalendario' => $codCalendario, 'codgrupo' => $codGrupoCalendario ));
            //codcalendario
            foreach ($grupos as $keyGrupo => $grupo) {
            	$arrayFiltro= array("codsede"=>$grupo->codsede,"codperiodo"=>$grupo->codperiodo,"codcarrera"=>$grupo->codcarrera,"codciclo"=>$grupo->codciclo,"codturno"=>$grupo->codturno,"codseccion"=>$grupo->codseccion);
            	$this->mdeuda->fnp_GenenarVincularDeudasConPagosAutomaticamente($grupo->codcalendario,$arrayFiltro);
            }
            
            //$dataex['vdata'] =$matriculados;
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_GenenarVincularDeudasConPagosAutomaticamente_PorEstudiante()
    {
    	//Recibe txtcodcalendario64, txtcodinscripcion64 y txtcodmatricula64; son obligatorios sin embargo pueden recibir un "%" para anular el txtcodmatricula64
        $this->form_validation->set_message('required', '%s Requerido');
    	date_default_timezone_set ('America/Lima');
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

			$codInscripcion=base64url_decode($this->input->post('txtcodinscripcion64'));
			$codCalendario=base64url_decode($this->input->post('txtcodcalendario64'));
			$codMatricula64=$this->input->post('txtcodmatricula64');
			$codMatricula="%";
			if ($codMatricula64!="%"){
				$codMatricula=base64url_decode($this->input->post('txtcodmatricula64'));
			}
			

        	$arrayFiltro= array("codinscripcion"=>$codInscripcion,"codmatricula"=>$codMatricula);
        	$this->mdeuda->fnp_GenenarVincularDeudasConPagosAutomaticamente($codCalendario,$arrayFiltro);
            
            
            //$dataex['vdata'] =$matriculados;
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_vincular_deuda_con_pago()
    {
    	 $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('coddetalle','Detalle','trim|required');
            $this->form_validation->set_rules('coddeuda','Deuda','trim|required');
            

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
                $dataex['msg'] ="Cambio NO realizado";
                $dataex['status'] =FALSE;
                $coddetalle = base64url_decode($this->input->post('coddetalle'));
                $coddeuda = base64url_decode($this->input->post('coddeuda'));     
                $codmatricula = base64url_decode($this->input->post('codmatricula'));      
                
                $rptaUpdateDocDetalle=$this->mfacturacion_detalle->m_updateDocPagoDetalle($coddetalle, array("deuda_cod" => $coddeuda,"codmatricula"=>$codmatricula));
                if ($rptaUpdateDocDetalle==true){
            		
        			$this->mdeuda->m_sincronizarSaldo(array("coddeuda" => $coddeuda));
			        
                   	$dataex['status'] =TRUE;
                    $dataex['coddeuda'] = $coddeuda ;
                    $dataex['msg'] ="Cambio registrado correctamente";
                }
 
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    public function fn_desvincular_deuda_con_pago()
    {
    	 $this->form_validation->set_message('required', '%s Requerido');
        $dataex['status'] =FALSE;
        $dataex['msg']    = '¿Que Intentas?.';
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('coddetalle','Detalle','trim|required');
            $this->form_validation->set_rules('coddeuda','Deuda','trim|required');
            

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
                $dataex['msg'] ="Cambio NO realizado";
                $dataex['status'] =FALSE;
                $coddetalle = base64url_decode($this->input->post('coddetalle'));
                $coddeuda = base64url_decode($this->input->post('coddeuda'));      
                $newcod=$this->mdeudas_individual->m_desvincular_deuda_a_pago(array($coddeuda,$coddetalle));
                if ($newcod==1){
                    $dataex['status'] =TRUE;
                    $dataex['coddeuda'] = $coddeuda ;
                    $dataex['msg'] ="Cambio registrado correctamente";
                    
                }
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }

    
}