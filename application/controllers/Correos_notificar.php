<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
require_once APPPATH.'controllers/Sendmail.php';
class Correos_notificar  extends Sendmail
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mcorreos');
        $this->load->model('mmesa_partes');
    }
    //MESA DE PARTES
    public function pdf_ficha_tramite_mail($codmt)
    {
        $dataex['status'] =FALSE;
        //$urlRef=base_url();
        $dataex['msg']    = '¿Que Intentas?.';

            $codmt=base64url_decode($codmt);
            
            $this->load->model('miestp');
            $ie=$this->miestp->m_get_datos();
            
            $tmp=$this->mmesa_partes->m_solicitud_x_codigo(array($codmt));
            
            $dominio=str_replace(".", "_",getDominio());
            $html1=$this->load->view("tramites/mesa_partes/pdf_formato_externo", array('ies' => $ie,'tmps'=>$tmp),true);
           
            $pdfFilePath = "TRAMITE N°".$tmp['solicitud']->codseg.".pdf";

            //$this->load->library('M_pdf');
            $formatoimp="A4";
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]);
            $mpdf->SetTitle( "TRAMITE N°".$tmp['solicitud']->codseg);
            $mpdf->WriteHTML($html1);
            
            return $mpdf->Output($pdfFilePath, "S");
    }
    //////////
    public function fn_send_correos_pendientes()
    {
        ini_set("memory_limit", "300M");
        $dataex['status'] = false;
        $dataex['flat'] = "inicia";
        $dataex['destino']=array();
        $datacorreos = $this->mcorreos->mData_correos_notificaciones();
        // $pruebas_email = array();
        $nro=0;
        foreach ($datacorreos as $keydc => $tmail) {
            
            $nro++;
            $dataex['flat'] = $nro;
            $r_respondera=array();
            // $d_enviador = array();
            $d_destino = array();
            $d_copia = array();
            $d_oculto = array();
            $trestado = $tmail->trestado;
            $d_enviador = json_decode($tmail->cenvia);
            $destemail = json_decode($tmail->cdestino);
            $destcopia = json_decode($tmail->descopia);
            $destoculto = json_decode($tmail->desoculto);
            $d_asunto = $tmail->asunto;
            $e_mensaje = $tmail->mensaje;
            $codigo = $tmail->id;
            $enviar_mail=false;
            foreach ($destemail as $key => $vemail) {
                if (filter_var($vemail, FILTER_VALIDATE_EMAIL)) {
                    $d_destino[] = $vemail;
                    $enviar_mail=true;
                }
            }
            foreach ($destcopia as $key => $vemailc) {
                if (filter_var($vemailc, FILTER_VALIDATE_EMAIL)) {
                    $d_copia[] = $vemailc;
                }
            }
            foreach ($destoculto as $key => $vemailo) {
                if (filter_var($vemailo, FILTER_VALIDATE_EMAIL)) {
                    $d_oculto[] = $vemailo;
                }
            }
            $pruebas_email=array();
            $d_adjuntos =array();
            $pdfficha="";
            
            $msgerror="";
            if ($enviar_mail==true){
                
                $rpenviado = "NO";
                
                
                
               //$idceros = "";
                if ($tmail->tabla=="MESA"){
                    if ($trestado == "CREADO"){
                        //cuando es creado, $tmail->codruta  guarda el codigo de mesa de partes no de ruta
                        $tramite = $this->mmesa_partes->m_get_codseguimiento_x_codtramite(array($tmail->codruta));
                        if (isset($tramite->codseg)){
                            $idceros = $tramite->codseg;
                            $pdfficha = $this->pdf_ficha_tramite_mail(base64url_encode($tmail->codruta));
                            $pruebas_email[]=array($pdfficha, 'attachment',"TRÁMITE N° ".$idceros.".pdf","application/pdf");
                            $d_adjuntos = $this->mmesa_partes->m_get_adjuntos_x_codtramite(array($tmail->codruta));
                        }
                        else{
                            $enviar_mail=false;
                            $msgerror="CÓDIGO DE TRÁMITE NO EXISTE";
                        }
                    }
                    else{
                        $ruta = $this->mmesa_partes->m_get_codtramite_x_codruta(array($tmail->codruta));
                        if (isset($ruta->codmesa)){
                            $d_adjuntos = $this->mmesa_partes->m_get_adjuntos_x_codtramite(array($ruta->codmesa));
                            $d_adjuntos2 = $this->mmesa_partes->m_get_adjuntos_x_codruta(array($tmail->codruta));
                            foreach ($d_adjuntos2 as $key => $adj2) {
                                $d_adjuntos[]=$adj2;
                            }
                            if ($trestado == "DERIVADO"){
                                $idceros = $ruta->codmesa;
                                $pdfficha = $this->pdf_ficha_tramite_mail(base64url_encode($ruta->codmesa));
                                $pruebas_email[]=array($pdfficha, 'attachment',"TRÁMITE N°".$idceros.".pdf","application/pdf");
                            }
                            elseif($trestado == "FINALIZADO"){

                            }
                        }
                        else{
                            $enviar_mail=false;
                            $msgerror="CÓDIGO DE RUTA NO EXISTE";
                        }
                    }
                }
                elseif($tmail->tabla=="DOCPAGO"){
                    
                }
                if($enviar_mail==true){
                    foreach ($d_adjuntos as $key => $flt) {
                        $pathtodir =  getcwd() ;          
                        $link = $flt->link;
                        $existefile=is_file($pathtodir."/upload/tramites/".$link);
                        if ($existefile==true){
                            $pruebas_email[]=array($pathtodir."/upload/tramites/".$link, 'attachment',$flt->archivo);
                        }
                    }
                    //f_sendmail_completo($array_enviador,$destinos,$destinos_copia,$asunto,$mensaje,$array_adjuntos,$array_responder_a=array()){
                    $rsp_iesap = $this->f_sendmail_completo($d_enviador,$d_destino,$d_copia,$d_oculto,$d_asunto,$e_mensaje,$pruebas_email,$r_respondera);
                    
                    if ($rsp_iesap['estado'] == true){
                        $rpenviado = "SI";
                        $msgerror=null;
                    }
                    else{
                        $msgerror = "Error Grande";//$rsp_iesap['mensaje'];
                    }

                }

                date_default_timezone_set('America/Lima');
                $fecenvio = date("Y-m-d H:i:s");
                try {
                    $this->mcorreos->mUpdate_items_correos_notificaciones(array($rpenviado, $fecenvio, $msgerror, $codigo));    
                } catch (Exception $e) {
                    unset($msgerror);
                    $this->mcorreos->mUpdate_items_correos_notificaciones(array($rpenviado, $fecenvio, "Error al actualizar el registro", $codigo));
                }
                sleep(5);
            }
            else{
                $this->mcorreos->mUpdate_items_correos_notificaciones(array("NO", null, "Sin correo de destino", $codigo));
            }
            unset($datacorreos[$keydc]);
        }    
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

}
