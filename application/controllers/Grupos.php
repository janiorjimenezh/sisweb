<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class Grupos extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mgrupos');
        $this->load->model('mdeudas_calendario_grupo');
        $this->load->model('mmatricula');
        
	}

  

    public function vw_grupos(){
        $ahead= array('page_title' =>'Grupos matriculados | IESTWEB'  );
        $asidebar= array('menu_padre' =>'academico','menu_hijo' =>'matriculas','menu_nieto' =>'grupos');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        $this->load->view($vsidebar,$asidebar);
        $this->load->model('mperiodo');

        $this->load->model('mbeneficio');   
        $a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

        $this->load->model('mcarrera');
        $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);

        $a_ins['periodos']=$this->mperiodo->m_get_periodos();
        $this->load->model('mtemporal');
        $a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
        
        $a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
        //$this->load->model('mcarrera');
        $a_ins['secciones']=$this->mtemporal->m_get_secciones();
        $this->load->model('msede');
        $a_ins['sedes'] = $this->msede->m_get_sedes_activos();
        //$modl=$this->mmodalidad->m_modalidad();
        $this->load->view('matricula/vw_grupos',$a_ins);
        $this->load->view('footer');
    }

    public function vw_grupos_consultas(){
        $ahead= array('page_title' =>'Grupos matriculados | IESTWEB'  );
        $asidebar= array('menu_padre' =>'academico','menu_hijo' =>'matriculas','menu_nieto' =>'grupos');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);
        $this->load->model('mperiodo');

        $this->load->model('mbeneficio');   
        $a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

        $this->load->model('mcarrera');
        $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);

        $a_ins['periodos']=$this->mperiodo->m_get_periodos();
        $this->load->model('mtemporal');
        $a_ins['ciclos']=$this->mtemporal->m_get_ciclos();

        $a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
        //$this->load->model('mcarrera');
        $a_ins['secciones']=$this->mtemporal->m_get_secciones();
        //$modl=$this->mmodalidad->m_modalidad();
        $this->load->view('matricula/vw_grupos_consultas',$a_ins);
        $this->load->view('footer');
    }

    public function pdf_orden_merito_grupo(){
        $ahead= array('page_title' =>'Grupos matriculados | IESTWEB'  );
        $asidebar= array('menu_padre' =>'academico','menu_hijo' =>'matriculas','menu_nieto' =>'grupos');
        $this->load->view('head',$ahead);
        $this->load->view('nav');
        $this->load->view('sidebar',$asidebar);
        $this->load->model('mperiodo');

        $this->load->model('mbeneficio');   
        $a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();

        $this->load->model('mcarrera');
        $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);

        $a_ins['periodos']=$this->mperiodo->m_get_periodos();
        $this->load->model('mtemporal');
        $a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
        

        $a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
        //$this->load->model('mcarrera');
        $a_ins['secciones']=$this->mtemporal->m_get_secciones();
        //$modl=$this->mmodalidad->m_modalidad();
        $this->load->view('matricula/vw_grupos_consultas',$a_ins);
        $this->load->view('footer');
    }


    public function fn_filtrar()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('fm-cbsede','Sede','trim|required');
            $this->form_validation->set_rules('fm-cbperiodo','Periodo','trim|required');
            $this->form_validation->set_rules('fm-cbcarrera','Carrera','trim|required');
            $this->form_validation->set_rules('fm-cbciclo','Ciclo','trim|required');
            $this->form_validation->set_rules('fm-cbturno','Turno','trim|required');
            $this->form_validation->set_rules('fm-cbseccion','Seccion','trim|required');
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
                $fmcbsede=$this->input->post('fm-cbsede');
                $fmcbperiodo=$this->input->post('fm-cbperiodo');
                $fmcbcarrera=$this->input->post('fm-cbcarrera');
                $fmcbplan=$this->input->post('fm-cbplan');
                $fmcbciclo=$this->input->post('fm-cbciclo');
                $fmcbturno=$this->input->post('fm-cbturno');
                $fmcbseccion=$this->input->post('fm-cbseccion');
                $databuscar=array("codsede"=>$fmcbsede,"codperiodo"=>$fmcbperiodo, "codcarrera"=>$fmcbcarrera,"codplan"=>$fmcbplan,"codturno"=>$fmcbturno, "codciclo"=>$fmcbciclo, "codseccion"=>$fmcbseccion);
                $grupos=$this->mgrupos->m_filtrar($databuscar);
           


                $gruposCalendario=$this->mdeudas_calendario_grupo->m_getGrupos(array("codsede"=>$fmcbsede,"codperiodo"=>$fmcbperiodo,"codcarrera"=>$fmcbcarrera,"codturno"=>$fmcbturno, "codciclo"=>$fmcbciclo, "codseccion"=>$fmcbseccion));


                foreach ($grupos as $gpKey => $gp) {
                    $grupos[$gpKey]->codgrupo=0;
                    $grupos[$gpKey]->codgrupo64=0;
                    $grupos[$gpKey]->codcalendario="";
                    $grupos[$gpKey]->calendario="";
                    foreach ($gruposCalendario as $gpcKey => $gpc) {
                        if (($gp->periodo==$gpc->periodo) && ($gp->codcarrera==$gpc->codcarrera) && ($gp->codciclo==$gpc->codciclo) && ($gp->codturno==$gpc->codturno) && ($gp->seccion==$gpc->codseccion) ){
                            $grupos[$gpKey]->codgrupo=$gpc->codgrupo;
                            $grupos[$gpKey]->codgrupo64=base64url_encode($gpc->codgrupo);;
                            $grupos[$gpKey]->codcalendario=$gpc->codcalendario;
                            $grupos[$gpKey]->calendario=$gpc->calendario;
                            unset($gruposCalendario[$gpcKey]);
                        }
                    }
                }
                foreach ($gruposCalendario as $gpcKey => $gpc) {
                        $gp = new stdClass;
                        $gp->codcalendario=$gpc->codcalendario;
                        $gp->calendario=$gpc->calendario;
                        $gp->codperiodo=$gpc->codperiodo;
                        $gp->periodo=$gpc->periodo;
                        $gp->codcarrera=$gpc->codcarrera;
                        $gp->carrera=$gpc->carrera;
                        $gp->sigla=$gpc->sigla;
                        $gp->codciclo=$gpc->codciclo;
                        $gp->ciclo=$gpc->ciclo;
                        $gp->codturno=$gpc->codturno;
                        $gp->turno=$gpc->turno;
                        $gp->seccion=$gpc->seccion;
                        $gp->codseccion=$gpc->codseccion;
                        $gp->mat=0;
                        $gp->act=0;
                        $gp->ret=0;
                        $gp->cul=0;
                        $gp->pry=0;
                        $gp->idplan="";
                        $gp->plan="";

                        $gp->codsede=$gpc->codsede;
                        $gp->sede_abrevia=$gpc->sede_abrevia;
                        $gp->sede=$gpc->sede;
                        $grupos[]=$gp;    
                }

                $dataex['vdata']=$grupos;
                $dataex['status'] = true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    /*public function fn_filtrar()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('fm-cbsede','Sede','trim|required');
            $this->form_validation->set_rules('fm-cbperiodo','Periodo','trim|required');
            $this->form_validation->set_rules('fm-cbcarrera','Carrera','trim|required');
            $this->form_validation->set_rules('fm-cbciclo','Ciclo','trim|required');
            $this->form_validation->set_rules('fm-cbturno','Turno','trim|required');
            $this->form_validation->set_rules('fm-cbseccion','Seccion','trim|required');
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
                $fmcbsede=$this->input->post('fm-cbsede');
                $fmcbperiodo=$this->input->post('fm-cbperiodo');
                $fmcbcarrera=$this->input->post('fm-cbcarrera');
                $fmcbplan=$this->input->post('fm-cbplan');
                $fmcbciclo=$this->input->post('fm-cbciclo');
                $fmcbturno=$this->input->post('fm-cbturno');
                $fmcbseccion=$this->input->post('fm-cbseccion');
                $databuscar=array("codsede"=>$fmcbsede,"codperiodo"=>$fmcbperiodo, "codcarrera"=>$fmcbcarrera,"codplan"=>$fmcbplan,"codturno"=>$fmcbturno, "codciclo"=>$fmcbciclo, "codseccion"=>$fmcbseccion);
                $grupos=$this->mgrupos->m_filtrar($databuscar);
                $dataex['vdata'] =$grupos;
                $dataex['status'] = true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }*/

    public function pdf_orden_merito(){

        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");

        $this->load->model('miestp');
        $ie=$this->miestp->m_get_datos();

        $insc=$this->mgrupos->m_filtrar_ord_mer(array($_SESSION['userActivo']->idsede,$fmcbperiodo,$fmcbcarrera,$fmcbciclo,$fmcbturno,$fmcbseccion));
        if (count($insc)>0){
           $html1=$this->load->view('matricula/rp_orden_merito', array('ies' => $ie,'mats' => $insc ),true);
            $pdfFilePath = "ORDEN DE MERITO.pdf";
            //$this->load->library('M_pdf');
            $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
            $mpdf->SetTitle( "ORDEN DE MÉRITO");
            $mpdf->SetWatermarkImage(base_url().'resources/img/logo_h110.'.getDominio().'.png',0.1,array(50,70),array(80,40));
            $mpdf->showWatermarkImage  = true;
            $mpdf->WriteHTML($html1);
            $mpdf->Output($pdfFilePath, "I"); 
        }
        else{
            $this->load->view('errors/page-sin-resultados',array('encabezado' => 'Orden de Mérito' ));
        }
        
    }

    public function fn_matriculados_x_grupo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $dataex['msg']="jajaajj";
            $fmcbperiodo=$this->input->post('fmt-cbperiodo');
            $fmcbcarrera=$this->input->post('fmt-cbcarrera');
            $fmcbciclo=$this->input->post('fmt-cbciclo');
            $fmcbturno=$this->input->post('fmt-cbturno');
            $fmcbseccion=$this->input->post('fmt-cbseccion');
            $fmcbplan=$this->input->post('fmt-cbplan');
            
            $this->load->model('mmatricula');
            $cuentas=$this->mmatricula->m_matriculados_con_estadistica_cursos_xgrupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
            foreach ($cuentas as $key => $mat) {
                $mat->codmat64 = base64url_encode($mat->codigo);
            }
            $dataex['vdata'] =$cuentas;
            $dataex['status'] = true;
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_culminar_grupo()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            if (getPermitido("149")=='SI'){
                $dataex['status'] = false;
                $urlRef           = base_url();
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $this->form_validation->set_rules('filas', 'datos', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $dataex['msg'] = validation_errors();
                } else {
                    $dataex['msg'] = "Ocurrio un error al intentar actualizar el estado";
                    $data          = json_decode($_POST['filas']);
                    
                    foreach ($data as $value) {
                                        
                        $rpta = $this->mmatricula->m_update_culminar_grupo(array(base64url_decode($value[0]),$value[1]));
                        
                    }
                    
                    if ($rpta->salida == "1") {
                        $dataex['msg'] = "datos actualizados";
                        $dataex['status'] = true;
                    }
                    

                }
            } else {
                $dataex['msg'] = "No tienes acceso para esta acción";
                $dataex['status'] = false;
            }
            
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fnFiltrarGruposBloqueo()
    {
        $this->form_validation->set_message('required', '%s Requerido');
    
        $dataex['status'] =FALSE;
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('fm-cbsede','Sede','trim|required');
            $this->form_validation->set_rules('fm-cbperiodo','Periodo','trim|required');
            $this->form_validation->set_rules('fm-cbcarrera','Carrera','trim|required');
            $this->form_validation->set_rules('fm-cbciclo','Ciclo','trim|required');
            $this->form_validation->set_rules('fm-cbturno','Turno','trim|required');
            $this->form_validation->set_rules('fm-cbseccion','Seccion','trim|required');
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
                $fmcbsede=$this->input->post('fm-cbsede');
                $fmcbperiodo=$this->input->post('fm-cbperiodo');
                $fmcbcarrera=$this->input->post('fm-cbcarrera');
                $fmcbplan=$this->input->post('fm-cbplan');
                $fmcbciclo=$this->input->post('fm-cbciclo');
                $fmcbturno=$this->input->post('fm-cbturno');
                $fmcbseccion=$this->input->post('fm-cbseccion');
                $databuscar=array("codsede"=>$fmcbsede,"codperiodo"=>$fmcbperiodo, "codcarrera"=>$fmcbcarrera,"codplan"=>$fmcbplan,"codturno"=>$fmcbturno, "codciclo"=>$fmcbciclo, "codseccion"=>$fmcbseccion);
                $grupos=$this->mgrupos->m_filtrar($databuscar);
                $dataex['vdata'] =$grupos;
                $dataex['status'] = true;
            }
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

}