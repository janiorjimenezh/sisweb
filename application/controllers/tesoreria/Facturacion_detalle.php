<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Facturacion_detalle extends Error_views{
	private $ci;
	function __construct(){
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->helper("url"); 
		$this->load->model("mfacturacion");
		$this->load->model("mfacturacion_detalle");
		$this->load->model('mauditoria');
		$this->load->model('mpagante');
		$this->load->model('mubigeo');
        
        $this->load->model('mdeuda');
        $this->load->model('mmatricula');
        

		//$this->load->library('pagination');
	}


    public function fn_updateDetalleCodGestionCodMatricula(){
        
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $rscuentas="";
        $dataex['conteo'] =0;
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('coddetalle64','Pagante','trim|required');
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
                ini_set('memory_limit', '1G');
                $coddetalle=base64url_decode($this->input->post('coddetalle64'));
                $codgestion=$this->input->post('codgestion');
                $codmatricula=null;
                $codmatricula64=$this->input->post('codmatricula64');
                if ($codmatricula64!="0"){
                    $codmatricula=base64url_decode($this->input->post('codmatricula64'));
                }
                $pagos=$this->mfacturacion_detalle->m_getDocPagoDetalles(array("coddetalle"=>$coddetalle));
                if (count($pagos)==1){
                    $codmatriculaAnterior=$pagos[0]->codmatricula;
                    $rptaUpdateDocDetalle=$this->mfacturacion_detalle->m_updateDocPagoDetalle($coddetalle, array("gestion_cod" => $codgestion,"codmatricula"=>$codmatricula));
                    if ($rptaUpdateDocDetalle==true){
                        if ($codmatricula64!="0"){
                            $arrayFiltro= array("codmatricula"=>$codmatricula);
                            $matriculados=$this->mmatricula->m_getMatriculas($arrayFiltro);
                            if (count($matriculados)==1){
                                if ($matriculados[0]->codcalendario!=""){
                                    $this->mdeuda->fnp_GenenarVincularDeudasConPagosAutomaticamente($matriculados[0]->codcalendario,$arrayFiltro);
                                }
                                
                            }
                        }
                        
                        if ($codmatricula!=$codmatriculaAnterior){
                            $arrayFiltro= array("codmatricula"=>$codmatriculaAnterior);
                            $matriculados=$this->mmatricula->m_getMatriculas($arrayFiltro);
                            if (count($matriculados)==1){
                                if ($matriculados[0]->codcalendario!=""){
                                    $this->mdeuda->fnp_GenenarVincularDeudasConPagosAutomaticamente($matriculados[0]->codcalendario,$arrayFiltro);
                                }
                            }
                        }
                        
                        $dataex['status'] =TRUE;
                        $dataex['msg'] ="Cambio registrado correctamente";
                    }
                }
                
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }
        
    

    public function fn_getDetallesPagos()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $rscuentas="";
        $dataex['conteo'] =0;
        if ($this->input->is_ajax_request())
        {
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            
              
                $data_array=array();
                $data_array['codsede_dp']=$_SESSION['userActivo']->idsede;

                if (null !==$this->input->post('txttipodoc')){
                    $variable=(trim($this->input->post('txttipodoc'))=="") ? "%" : trim($this->input->post('txttipodoc'));
                    $data_array['codtipodoc']=$variable;
                }
                if (null !==$this->input->post('txtcodpagante')){
                    $variable=(trim($this->input->post('txtcodpagante'))=="") ? "%" : trim($this->input->post('txtcodpagante'));
                    $data_array['codpagante']=$variable;
                }
                if (null !==$this->input->post('txtcodgestion')){
                    $variable=(trim($this->input->post('txtcodgestion'))=="") ? "%" : trim($this->input->post('txtcodgestion'));
                    $data_array['codgestion']=$variable;
                }
                if (null !==$this->input->post('txtestadodoc')){
                    $variable=(trim($this->input->post('txtestadodoc'))=="") ? "%" : trim($this->input->post('txtestadodoc'));
                    $data_array['estadodoc']=$variable;
                }
                if ((null !==$this->input->post('txtcodmatricula'))){
                    if (trim($this->input->post('txtcodmatricula'))==""){

                    }
                    else{
                        $variable=(trim($this->input->post('txtcodmatricula'))=="") ? "%" : trim($this->input->post('txtcodmatricula'));
                        $data_array['codmatricula']=$variable;
                    }
                }
                
                if (null!=$this->input->post('txtbuscar')) {
                    $vBuscar=trim($this->input->post('txtbuscar'));
                    $vBuscar=str_replace(" ","%",$vBuscar);
                    $data_array['buscar']="%".$vBuscar."%";
                }
                
                //Siemrpe enviar las fechas al final
                $emision= "";
                $emisionf= "";
                if (null !==$this->input->post('txtfechaini')){
                    $variable=(trim($this->input->post('txtfechaini'))=="") ? "" : trim($this->input->post('txtfechaini'));
                    $emision=$variable;
                }
                if (null !==$this->input->post('txtfechafin')){
                    $variable=(trim($this->input->post('txtfechafin'))=="") ? "" : trim($this->input->post('txtfechafin'));
                    $emisionf=$variable;
                }
                if ($emision != "" && $emisionf != "") {
                    $horaini = ' 00:00:01';
                    $horafin = ' 23:59:59';
                    $data_array['fechas'][]=$emision.$horaini;
                    $data_array['fechas'][]=$emisionf.$horafin;
                }
                elseif ($emision == "" && $emisionf == "") {
                    
                }
                elseif ($emision == "") {
                    $emision='1990-01-01 00:00:01';
                    $emisionf=$emisionf.' 23:59:59';
                    $data_array['fechas'][]=$emision;
                    $data_array['fechas'][]=$emisionf;
                }
                else{
                    $emision=$emision.' 00:00:01';
                    $emisionf=date("Y-m-d").' 23:59:59';
                    $data_array['fechas'][]=$emision;
                    $data_array['fechas'][]=$emisionf;
                }
                $data_array['protegelimites']=true;
                if (count($data_array)>0){
                    //$codgestion = $this->input->post('codgestion');
                    $pagos=$this->mfacturacion_detalle->m_getDocPagoDetalles($data_array);
                    foreach ($pagos as $key => $pago) {
                        $fecha_hora =  new DateTime($pago->fecha) ;
                        $pago->fecha_hora_sin_formato = $pago->fecha;
                        $pago->fecha_hora = $fecha_hora->format('d/m/Y h:i a');  
                        $pago->coddetalle64=base64url_encode($pago->coddetalle);
                        $pago->codboleta64=base64url_encode($pago->coddocpago);
                        $pago->codmatricula64=base64url_encode($pago->codmatricula);
                        $pago->codinscripcion64=base64url_encode($pago->codinscripcion);
                        $pago->coddeuda64=(is_null($pago->coddeuda)) ? 0: base64url_encode($pago->coddeuda);

                    }
                    $dataex['vdata']=$pagos;
                    $dataex['vpermiso198'] = getPermitido("198");

                    $dataex['status'] =TRUE;
                } 
                else{
                    $dataex['status'] = false;
                    $dataex['msg'] = "Ingresa parámetros de búsqueda";
                }
                
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }
}
