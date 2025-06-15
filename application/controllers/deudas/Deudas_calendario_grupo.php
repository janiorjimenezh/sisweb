<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deudas_calendario_grupo extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('mdeudas_calendario_grupo');
        $this->load->model('mdeudas_calendario_fecha');
        $this->load->model('mdeudas_individual');
        $this->load->model('mdeudas_calendario_fecha_item');
        
        
    }
    
    public function fn_getGruposPorCalendario()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['vgrupos']=array();
        $dataex['vfechas']=array();
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $codCalendario=base64url_decode($this->input->post('txtcodcalendario64'));
            
            
            $fechas=$this->mdeudas_calendario_fecha->m_get_fechas_xcalendario($codCalendario);

            $fechasItems=$this->mdeudas_calendario_fecha_item->m_getItemsFecha(array("codcalendario"=>$codCalendario));
            foreach ($fechas as $keyFecha => $fecha) {
                $fechas[$keyFecha]->items=array();
                $fechas[$keyFecha]->codigo64=base64url_encode($fecha->codigo);
                foreach ($fechasItems as $keyFechaItem => $fechaItem) {
                    if ($fecha->codigo==$fechaItem->codfecha){
                        $fechas[$keyFecha]->items[]=$fechaItem;
                    }
                }
            }
            $total_matriculados=$this->mdeudas_calendario_grupo->m_get_grupos_totalMatriculados(array($codCalendario));
            
            $grupos=$this->mdeudas_calendario_grupo->m_getGrupos(array("codcalendario"=>$codCalendario));
            
            foreach ($grupos as $key => $gp) {
                $gp->matriculas=0;
                $gp->generadas=0;
                $grupos[$key]->codgrupo64=base64url_encode($gp->codgrupo);
                foreach ($total_matriculados as $tm_key => $tm) {
                    if ($tm->codigo==$gp->codgrupo){
                        $gp->matriculas=$tm->matriculados;
                    }
                }
                /*foreach ($total_deudasGeneradas as $dg_key => $dg) {
                    if ($dg->codigo==$gp->codigo){
                        $gp->generadas=$dg->generadas;
                    }
                }*/
            }
            $dataex['vgrupos']=$grupos;
            $dataex['vfechas']=$fechas;

        }
        $dataex['status'] = true;
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function fn_getTodosLosGrupos()
    {
        $this->form_validation->set_message('required', '%s Requerido');
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['vgrupos']=array();
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $this->load->model('mgrupos');


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
                    
                    $gp->codciclo=$gpc->codciclo;
                    $gp->ciclo=$gpc->ciclo;
                    $gp->codplan=$gpc->codplan;
                    $gp->plan=$gpc->plan;
                    $gp->codturno=$gpc->codturno;
                    $gp->turno=$gpc->turno;
                    $gp->seccion=$gpc->seccion;
                    $gp->mat=0;
                    $gp->act=0;
                    $gp->ret=0;
                    $gp->cul=0;
                    $gp->idplan="";
                    $gp->plan="";

                    $gp->codsede=$gpc->codsede;
                    $gp->sede=$gpc->sede;
                    $grupos[]=$gp;    
            }

            $dataex['vgrupos']=$grupos;
        }
        $dataex['status'] = true;
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    

    public function fn_EliminarGrupoDeCalendario(){
        $this->form_validation->set_message('required', '%s Requerido');
        $urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';
        $dataex['vgrupos']=array();
        $dataex['status'] = false;
        if ($this->input->is_ajax_request())
        {
            $dataex['vdata'] =array();
            $dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';

            $codGrupoCalendario=base64url_decode($this->input->post('txtcodgrupo64'));
            $grupos=$this->mdeudas_calendario_grupo->m_getGrupos(array('codgrupo' => $codGrupoCalendario ));
            $grupo=array();
            if (count($grupos)==1){
                $grupo=$grupos[0];
                $arrayFiltroGrupo=array("codcalendario"=>$grupo->codcalendario,"codperiodo"=>$grupo->codperiodo,"codcarrera"=>$grupo->codcarrera,"codciclo"=>$grupo->codciclo,"codturno"=>$grupo->codturno,"codseccion"=>$grupo->codseccion);
                $deudas=$this->mdeudas_individual->m_getDeudas($arrayFiltroGrupo);
                foreach ($deudas as $keyDeuda => $deuda) {
                    $this->mdeudas_individual->fn_eliminarDeuda(array('di_codigo' => $deuda->codigo));
                }
                $this->mdeudas_calendario_grupo->fn_eliminarGrupo($codGrupoCalendario);
                $dataex['status'] = true;
            }
        }
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }
}