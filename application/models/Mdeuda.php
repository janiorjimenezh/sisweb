<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mdeuda extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}


	public function fnp_GenenarVincularDeudasConPagosAutomaticamente($codCalendario,$arrayFiltro)
   {
      date_default_timezone_set ('America/Lima');
      $this->load->model('mmatricula');
      $this->load->model('mdeudas_individual');
      $this->load->model('mfacturacion_detalle');
      
      $matriculados=$this->mmatricula->m_getMatriculas($arrayFiltro);
      $this->load->model('mfacturacion_cobros');
      $pagos_x_matriculas=$this->mfacturacion_detalle->m_getDocPagoDetalles($arrayFiltro);
      $cobros_x_matriculas=$this->mfacturacion_cobros->m_getCobrosPorGrupo($arrayFiltro);
      $pensiones=array('02.01','02.02','02.03','02.04','02.05'); //CUOTA DEL 01  AL 05
      $pensiones_pendiente=array('02.01'=>'06.02','02.02'=>'06.03','02.03'=>'06.04','02.04'=>'06.05','02.05'=>'06.06'); 
      //CUOTA PENDIENTE DEL 01 AL 05
      $gestionMatriculas=array('01.01','01.02','01.03'); //CUOTA DEL 01  AL 05
      $pensiones_contado="02.06";
      foreach ($pagos_x_matriculas as $keypago => $pago) {
         if (($pago->codtipodoc=="NB") || ($pago->codtipodoc=="NF")){
            $pago->monto=($pago->monto) * (-1);
         }
         $codRemplazaGestion=array_search($pago->codgestion, $pensiones_pendiente);
         if ($codRemplazaGestion!=false){
            $pagos_x_matriculas[$keypago]->codgestion=$codRemplazaGestion;
         }
   
         if (($pago->estado=="ANULADO") || ($pago->estado=="RECHAZADO")){
            if ($pago->coddeuda!="0"){
               $rptaUpdateDocDetalle=$this->mfacturacion_detalle->m_updateDocPagoDetalle($pago->coddetalle, array("deuda_cod" => "0"));
               unset($pagos_x_matriculas[$keypago]);
            }
         }
      }
      $deudas = $this->mdeudas_individual->m_getDeudas($arrayFiltro);
      $this->load->model('mdeudas_calendario_fecha');
      $this->load->model('mdeudas_calendario_fecha_item');
      $fechasItems= $this->mdeudas_calendario_fecha_item->m_getItemsFecha(array("codcalendario"=>$codCalendario));

      foreach ($fechasItems as $keyFechaItem => $fechaItem) {
         $fechaItem->tipoPago="OTROS";
         foreach ($pensiones as $keypen => $pen) {
            if ($fechaItem->codgestion==$pen){
               $fechaItem->tipoPago="PENSION";
               break;
            }
         }
         if ($fechaItem->tipoPago!="OTROS") continue;
         foreach ($gestionMatriculas as $keygmat => $gmat) {
            if ($fechaItem->codgestion==$gmat){
               $fechaItem->tipoPago="MATRICULA";
               break;
            }
         }
         //if ($fechaItem->tipoPago!="OTROS") continue;
      }

      $coddeuda_negativo=-1;
      foreach ($matriculados as $key => $matricula) {

         $matricula->codigo64=base64url_encode($matricula->codmatricula);
         $matricula->contado=0;
         $matricula->contadocuota=0;

         //PARA PENSIONES AL CONTADO
         foreach ($pagos_x_matriculas as $keypago => $pago) {
            if (($matricula->codmatricula==$pago->codmatricula) && ($pensiones_contado==$pago->codgestion)){
               $matricula->contado=($pago->monto);
               $matricula->contadocuota=($pago->monto)/5;
               unset($pagos_x_matriculas[$keypago]);
            }
         }
         // FIN PARA PENSIONES
         $matricula->deudas=array();
         $dm=array();


         foreach ($fechasItems as $keyFechaItem => $fechaItem) {
             
            $deuda= new stdClass();
            $coddeuda_negativo--;
            $deuda->codigo=$coddeuda_negativo;
            $deuda->vence=$fechaItem->vence;
            $deuda->prorroga=null;
            $deuda->prorroga_beneficio="NO";
            $deuda->codfechaitem=$fechaItem->codfechaitem;
            $deuda->saldo=0;
            $deuda->tipoPago=$fechaItem->tipoPago;
            $deuda->pagado=0;
            $monto=$fechaItem->monto;
            $deuda->montoreal=$monto;
            $deuda->codgestion=$fechaItem->codgestion;
            $saldo=$monto;
            $deuda->observacion="";
            $deuda->descuento=0;
            $deuda->aplicardscto=$fechaItem->aplicardscto;

            
            if ($deuda->tipoPago=="PENSION"){
               $monto=$matricula->pension;
               if ($matricula->contado>0){
                  $deuda->pagado=$matricula->contadocuota;
                  $monto=$matricula->contadocuota;
                  $matricula->pensionreal=$matricula->contadocuota;
                  $saldo=0;
                  $deuda->observacion="PAGÓ AL CONTADO";
               }
               else{
                  if ($deuda->aplicardscto=="NO"){
                     //$matricula->pension=$matricula->pensionreal;
                     $monto=$matricula->pensionreal;
                  }
               }
            }
            elseif ($deuda->tipoPago=="MATRICULA"){

            }
            elseif ($deuda->tipoPago=="OTROS"){

            }
            // FIN PARA PENSIONES

            $deuda->saldo=round($saldo,2);
            $deuda->monto=$monto;
            $dm[]=$deuda;
         }

         foreach ($dm as $keydm => $deudaProyectada) {
            foreach ($deudas as $keydeuda => $deudaCreada) {
               if (($deudaCreada->matricula==$matricula->codmatricula) &&  ($deudaCreada->codgestion==$deudaProyectada->codgestion)){
                  $dm[$keydm]->codigo=$deudaCreada->codigo;
                  $dm[$keydm]->prorroga=$deudaCreada->fprorroga;
                  $dm[$keydm]->prorroga_beneficio=$deudaCreada->prorroga_beneficio;
                  $dm[$keydm]->descuento=$deudaCreada->descuento;
                  unset($deudas[$keydeuda]);
               }
            }
         }

         foreach ($dm as $keydm => $deudaProyectada) {
            $vence=$deudaProyectada->vence;
            $deudaProyectada->pagado= $deudaProyectada->pagado - ($deudaProyectada->descuento);
            $arrayPagos=array();
            if (!is_null($deudaProyectada->prorroga)){
               if ($deudaProyectada->prorroga_beneficio=="SI"){
                  $vence=($deudaProyectada->prorroga > $deudaProyectada->vence) ? $deudaProyectada->prorroga : $deudaProyectada->vence;
               }
            }
            if ($deudaProyectada->tipoPago=="PENSION"){
               if ($vence < date('Y-m-d')){
               //VENCIDA
                  foreach ($pagos_x_matriculas as $keypago => $pago) {

                     if (($matricula->codmatricula==$pago->codmatricula) && ($deudaProyectada->codgestion==$pago->codgestion)){
                        if ($matricula->contado==0){
                           if ($pago->esgratis=="SI"){
                              $deudaProyectada->monto=$deudaProyectada->monto - ($pago->monto);
                           }
                           $arrayPagos[]=$pago;
                           foreach ($cobros_x_matriculas as $keyCobro => $cobro) {
                              if ($cobro->coddocpago==$pago->coddocpago){
                                 if ($cobro->fecha>$vence){
                                    $deudaProyectada->monto=$matricula->pensionreal;
                                 }
                                 $deudaProyectada->pagado=$deudaProyectada->pagado + ($pago->monto);
                              }
                           }
                           unset($pagos_x_matriculas[$keypago]);
                        }
                     }
                  }
                  //if (count($arrayPagos)==0) $deudaProyectada->monto=$matricula->pensionreal;
                  if (($deudaProyectada->monto - $deudaProyectada->pagado)>0) $deudaProyectada->monto=$matricula->pensionreal;
               }
               else{
                  //NO VENCIDA
                  foreach ($pagos_x_matriculas as $keypago => $pago) {
                     if (($matricula->codmatricula==$pago->codmatricula) && ($deudaProyectada->codgestion==$pago->codgestion)){
                        if ($matricula->contado==0){
                           $arrayPagos[]=$pago;
                           $deudaProyectada->pagado=$deudaProyectada->pagado + ($pago->monto);
                           unset($pagos_x_matriculas[$keypago]);
                        }
                     }
                  }
               }
            }
            else{
               
               foreach ($pagos_x_matriculas as $keypago => $pago) {
                  if (($matricula->codmatricula==$pago->codmatricula) && ($deudaProyectada->codgestion==$pago->codgestion)){
                        $arrayPagos[]=$pago;
                        $deudaProyectada->pagado=$deudaProyectada->pagado + ($pago->monto);
                        unset($pagos_x_matriculas[$keypago]);
                  }
               }
            }
            $deudaProyectada->saldo=$deudaProyectada->monto - $deudaProyectada->pagado;
            $dm[$keydm]=$deudaProyectada;
            $dm[$keydm]->pagos=$arrayPagos;
         }


         foreach ($dm as $keydeuda => $deuda) {
            if ($deuda->codigo<0){
               //INSERT
               $pagante = $matricula->carne;
               $codmatricula = $matricula->codmatricula;
               $gestion = $deuda->codgestion;
               $monto = $deuda->monto;
               $fcreacion = date('Y-m-d');
               $vouchercod = NULL;
               $fvence=$deuda->vence;
               $fechaitem = $deuda->codfechaitem;
               $mora = 0.0;
               $repite = "NO";
               $saldo = $deuda->saldo;
               $observacion = $deuda->observacion;
               $fprorroga=null;
               $rpta2=$this->mdeudas_individual->m_guardar_deuda(array($pagante, $codmatricula, $gestion, $monto, $fcreacion, $fvence, $vouchercod, $mora, $fprorroga, $repite, $observacion, $saldo , $fechaitem));
               if ($rpta2->salida="1"){
                  $deuda->codigo=$rpta2->newcod;
                  foreach ($deuda->pagos as $keyPago => $pago) {
                     $rptaUpdateDocDetalle=$this->mfacturacion_detalle->m_updateDocPagoDetalle($pago->coddetalle, array("deuda_cod" => $rpta2->newcod));
                         if ($rptaUpdateDocDetalle==true){
                             $dataex['status'] =TRUE;
                             $dataex['msg'] ="Cambio registrado correctamente";
                         }
                  }
               }
            }
            else{
               $arrayUpdateDeuda = array(
                  "di_monto"=> $deuda->monto,
                  "di_fecha_vencimiento"=> $deuda->vence,
                  "di_observacion"=> $deuda->observacion,
                  "di_saldo"=> $deuda->saldo,
                  "cal_fecha_item_cod"=> $deuda->codfechaitem); 


               $rpta2=$this->mdeudas_individual->m_updateDeuda($deuda->codigo,$arrayUpdateDeuda);
               foreach ($deuda->pagos as $keyPago => $pago) {
                  $rptaUpdateDocDetalle=$this->mfacturacion_detalle->m_updateDocPagoDetalle($pago->coddetalle, array("deuda_cod" => $deuda->codigo));
                   if ($rptaUpdateDocDetalle==true){
                       $dataex['status'] =TRUE;
                       $dataex['msg'] ="Cambio registrado correctamente";
                   }
               }
            }
         }
         $matricula->deudas=$dm;
         $dm=array();

      }

   }

   public function m_sincronizarAjuste($data){
      $data_array[]=$data['coddeuda'];
      $data_array[]=$data['coddeuda'];
      $this->db->query("UPDATE  tb_deuda_individual SET  tb_deuda_individual.di_descuento = (SELECT SUM(tb_deuda_ajustes_interno.ddi_monto) AS ajuste FROM tb_deuda_ajustes_interno WHERE tb_deuda_ajustes_interno.cod_deuda=? AND tb_deuda_ajustes_interno.ddi_estado='ACTIVO' GROUP BY  tb_deuda_ajustes_interno.cod_deuda)
        WHERE  di_codigo = ?",$data_array);
      return   true;  
      
   }



   public function m_sincronizarSaldo($data){
      $data_array[]=$data['coddeuda'];
      $data_array[]=$data['coddeuda'];
      $this->db->query("UPDATE  tb_deuda_individual SET  tb_deuda_individual.di_saldo = tb_deuda_individual.di_monto - (SELECT  SUM(tb_docpago_detalle.dpd_mnto_valor_venta) AS pagado
                     FROM tb_docpago_detalle WHERE  tb_docpago_detalle.deuda_cod = ?)
        WHERE  di_codigo = ?",$data_array);
      return   true;  
      
   }
}
   