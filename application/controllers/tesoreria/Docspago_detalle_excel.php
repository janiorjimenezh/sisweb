<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Docspago_detalle_excel extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mdocspago');
        $this->load->model('mfacturacion_detalle');
		
	}
      public function rpsede_documentos_emitidos_cuadro_x_conceptos_porGrupo()
    {
        //ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '600');
        date_default_timezone_set('America/Lima');

        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");
        
        $fmcbsede=$this->input->get("cd");
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");


        $this->load->model('mfacturacion_impresion');

        $this->load->model('mgestion');
        $this->load->model('msede');
        $fmctiempo=array();

        if ($emision != "" && $emisionf != "") {
            $horaini = ' 00:00:01';
            $horafin = ' 23:59:59';
            $fmctiempo[]=$emision.$horaini;
            $fmctiempo[]=$emisionf.$horafin;
        }
        elseif ($emision == "" && $emisionf == "") {
            /*$emision='1990-01-01 00:00:01';
            $emisionf=date("Y-m-d").' 23:59:59';*/
        }
        elseif ($emision == "") {
            $emision='1990-01-01 00:00:01';
            $emisionf=$emisionf.' 23:59:59';
            $fmctiempo[]=$emision;
            $fmctiempo[]=$emisionf;
        }
        else{
            $emision=$emision.' 00:00:01';
            $emisionf=date("Y-m-d").' 23:59:59';
            $fmctiempo[]=$emision;
            $fmctiempo[]=$emisionf;
        }

        $a_estado=array();
        if (null !== $this->input->get("checkanulado")) {
            $a_estado[]="ANULADO";
        }
        if (null !== $this->input->get("checkenviado")) {
            $a_estado[]="ENVIADO";
        }
        if (null !== $this->input->get("checkrechazado")) {
            $a_estado[]="RECHAZADO";
        }
        if (null !== $this->input->get("checkerror")) {
            $a_estado[]="ERROR";
        }
        if (null !== $this->input->get("checkaceptado")) {
            $a_estado[]="ACEPTADO";
        }
        if (null !== $this->input->get("checkpendiente")) {
            $a_estado[]="PENDIENTE";
        }
        
        if (count($a_estado)==0){
            $a_estado[]="TODOS";
        }

        $rstdata_gestion=$this->mgestion->m_get_gestion();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp_documentospago_emitidos_cuadroporconceptos.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();


        

        $arrayBusqueda = array('codsede_dp' =>$fmcbsede ,'codperiodo' =>$fmcbperiodo ,'codcarrera' =>$fmcbcarrera ,'codplan' =>$fmcbplan ,'codciclo' =>$fmcbciclo ,'codturno' =>$fmcbturno ,'codseccion' =>$fmcbseccion,'fechas'=>$fmctiempo ,'estados'=>$a_estado);
        $rsDetalles = $this->mfacturacion_detalle->m_getDocPagoDetalles($arrayBusqueda);
        $rsDocsPago=array();
        $a_conceptos=array();
        $arrayFilial=array();
        foreach ($rsDetalles as $keyDetalle => $detalle) {
            $arrayFilial[$detalle->codsede]['sede']=$detalle->sede;
            if (($detalle->codtipodoc=="FC") || ($detalle->codtipodoc=="BL")){
                $arrayFilial[$detalle->codsede]['BF'][$detalle->coddocpago]=$detalle;
            }
            elseif ($detalle->codtipodoc=="NC"){
                $arrayFilial[$detalle->codsede]['NC'][$detalle->coddocpago]=$detalle;
            }
            else{
                $arrayFilial[$detalle->codsede]['ND'][$detalle->coddocpago]=$detalle;
            }
            //$arrayFilial[$detalle->coddocpago]=$detalle;
            $a_conceptos[$detalle->codgestion]=array();
        }

        $sheet->setCellValue("A4", "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
        //$sheet->setCellValue('B5', $_SESSION['userActivo']->sede);
        $sheet->setCellValue('G1', date("d/m/Y"));
        $sheet->setCellValue('G2', date("h:i:s"));
        $fila=3;
        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        $ncol=7;
        $nfil=6;
        $grupo="";
        $docsAcumulada=0;
        $filnotas = "";
        $sidnota = 0;
        $nronotasc = 0;
        $a_conceptos[]=array();
            
        // }
        // BOLETAS Y FACTURAS
        //var_dump($arrayFilial);
        foreach ($arrayFilial  as $keyFilial => $filial) {
            $sheet->mergeCells("A{$fila}:G{$fila}");
            $sheet->setCellValue("A".$fila, "COMPROBANTE DE VENTA EMITIDOS");
            $sheet->getStyle("A$fila")->getFont()->setBold(true);
            $sheet->getStyle("A$fila")->getFont()->setSize(12);
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal('center');
            $fila++;
            $sheet->mergeCells("A$fila:G$fila");
            $sheet->setCellValue("A".$fila, "del ".date_format(date_create($emision),"d/m/Y")."         al ".date_format(date_create($emisionf),"d/m/Y"));
            $sheet->getStyle("A$fila")->getAlignment()->setHorizontal('center');
            $fila++;
            $sheet->getStyle("A".$fila.":B".$fila)->getFont()->setBold(true);
            $sheet->setCellValue('A'.$fila, "FILIAL");
            $sheet->setCellValue('B'.$fila, $filial['sede']);
            $fila++;
            $sheet->setCellValue('A'.$fila, "N°");
            $sheet->setCellValue('B'.$fila, "COMPROBANTE");
            $sheet->setCellValue('C'.$fila, "CARNÉ");
            $sheet->setCellValue('D'.$fila, "CLIENTE");
            
            $sheet->setCellValue('E'.$fila, "EST");
            $sheet->setCellValue('F'.$fila, "EMISIÓN");
            $sheet->getStyle("A".$fila.":F".$fila)->getFont()->setBold(true);
            $sheet->getStyle("A".$fila.":F".$fila)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('F2F2F2');
            $sheet->getStyle('A'.$fila.':F'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

            foreach ($rstdata_gestion as $key => $cc) {
                if (isset($a_conceptos[$cc->codigo])){
                    $a_conceptos[$cc->codigo]['nombre']=$cc->nombre;
                    $a_conceptos[$cc->codigo]['monto']=0;
                    $a_conceptos[$cc->codigo]['col']=$ncol;

                    $sheet->setCellValueByColumnAndRow($ncol,$fila, $cc->nombre);
                    $columntf = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ncol);
                    $a_conceptos[$cc->codigo]['letracol']=$columntf;
                    $sheet->getStyle("G".$fila.":".$columntf.$fila)
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('F2F2F2');
                    $sheet->getStyle("G".$fila.":".$columntf.$fila)->getFont()->setSize(9);
                    $sheet->getStyle("G".$fila.":".$columntf.$fila)
                        ->getAlignment()
                        ->setVertical('center')
                        ->setWrapText(true);
                    $sheet->getStyle('G'.$fila.':'.$columntf.$fila)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);
                    $ncol++;
                }
            }
            $sheet->getRowDimension($fila)->setRowHeight(59.25, 'pt');
            $sheet->setCellValueByColumnAndRow($ncol,$fila, "TOTAL");
            $sheet->getStyleByColumnAndRow($ncol,$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            $nro=0;
            $docsAcumulada = 0;
            $mtotal = 0;
            $mefectivo = 0;
            $mbanco = 0;
            $filnotas = "";
            $sidnota = 0;
            $nronotasc = 0;
            $filaInicia=$fila + 1;

            foreach ($filial['BF'] as $kdoc => $docPago) {
                //$grupoint= $docPago->codsede;
                //if ($grupo!=$grupoint){
                    //$grupo=$grupoint;
                    
                //}

                //if (($docPago->codtipodoc=="FC") || ($docPago->codtipodoc=="BL")){
                    $nro++;
                    $fila++;
                    $vestado="";
                    $docsAcumulada = $nro;
                    //$filnotas = $docPago->sede;
                    //$sidnota = $docPago->codsede;
                    if ($docPago->estado=="ANULADO"){
                        $docPago->total=0;
                        $docPago->efectivo=0;
                        $docPago->banco=0;
                        $vestado="AN";
                    }
                    $sheet->setCellValue('A'.$fila, $nro);
                    $sheet->setCellValue('B'.$fila, $docPago->serie."-".str_pad($docPago->numero, 6, "0", STR_PAD_LEFT));
                    $sheet->setCellValue('C'.$fila, $docPago->codpagante);
                    $sheet->setCellValue('D'.$fila, $docPago->pagante);
                    $sheet->setCellValue('E'.$fila, $vestado);
                    $sheet->setCellValue('F'.$fila, date_format(date_create($docPago->fecha),"d/m/Y"));
                    $sheet->getStyle('A'.$fila.':F'.$fila)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);
                   
                    foreach ($rsDetalles as $key => $concepto) {
                        if ($docPago->coddocpago==$concepto->coddocpago){
                            if (isset($a_conceptos[$concepto->codgestion]['col'])){
                                if ($docPago->estado=="ANULADO"){
                                   $concepto->monto=0;
                                }
                                $sheet->setCellValueByColumnAndRow($a_conceptos[$concepto->codgestion]['col'],$fila, $concepto->monto);
                                $a_conceptos[$concepto->codgestion]['monto']=$a_conceptos[$concepto->codgestion]['monto'] + $concepto->monto;

                            }
                        }

                    }
                    $columnttf = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ncol);
                    $columnttf_suma = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ncol-1);
                    $sheet->getStyle('G'.$fila.':'.$columnttf.$fila)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);


                    //$sheet->setCellValueByColumnAndRow($ncol,$fila, $docPago->total);
                    //$sheet->getCell("{$columnttf}{$fila}")->setValueExplicit("=SUM(G{$fila}:G{$columnttf_suma})", DataType::TYPE_FORMULA);
                    $sheet->setCellValue("{$columnttf}{$fila}","=SUM(G{$fila}:{$columnttf_suma}{$fila})");
                    // $mtotal=$mtotal +  $docPago->total;
                    // $mefectivo=$mefectivo + $docPago->efectivo;
                    // $mbanco=$mbanco + $docPago->banco;
                    unset($filial['BF'][$kdoc]);
                //}

                if (($docPago->codtipodoc=="NF") || ($docPago->codtipodoc=="NB")){
                    $nronotasc++;
                }
            }
            

            $filaTermina=$fila;
            $fila++;
            foreach ($a_conceptos as $key => $cc) {
                if (isset($cc['col'])){
                    $letraCol=$cc['letracol'];
                    $sheet->setCellValueByColumnAndRow($cc['col'],$fila, "=SUM({$letraCol}{$filaInicia}:{$letraCol}{$filaTermina})");
                }
            }
            $sheet->setCellValueByColumnAndRow($ncol,$fila, $mtotal);
            $columnf = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($ncol);
            $sheet->getStyle("G".$fila.":".$columnf.$fila)->getFont()->setBold(true);
            $sheet->getStyle($columnf."6:".$columnf.$fila)->getFont()->setBold(true);
            $sheet->getStyle('A'.$fila.':'.$columnf.$fila)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $fila++;
            $fila++;
            $sheet->getStyle("D".$fila.":F".($fila + 3))->getFont()->setBold(true);
            $sheet->getStyle("D".$fila.":F".($fila + 3))
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $sheet->mergeCells("D$fila:E$fila");
            $sheet->setCellValue('D'.($fila), "Total Emitido");
            $sheet->setCellValue('F'.($fila ), $mtotal);
            $fila++;
            $sheet->mergeCells("D$fila:E$fila");
            $sheet->setCellValue('D'.($fila), "Total Efectivo");
            $sheet->setCellValue('F'.($fila), $mefectivo);
            $fila++;
            $sheet->mergeCells("D$fila:E$fila");
            $sheet->setCellValue('D'.($fila), "Total Banco");
            $sheet->setCellValue('F'.($fila), $mbanco);
            $fila++;
            $sheet->mergeCells("D$fila:E$fila");
            $sheet->setCellValue('D'.($fila), "Otros Doc. Valor");
            $sheet->setCellValue('F'.($fila), $mtotal - ($mefectivo + $mbanco));
            $fila++;
            $fila++;

           
            // FIN NOTAS CREDITO
            $ncol = 7;
                    
        }
        
        
 
        $writer = new Xlsx($spreadsheet);
        $rptased = array();
        if ($fmcbsede != "%") {
            $rptased = $this->msede->m_get_sede_config_x_codigo(array($fmcbsede));
        }

        $filname = ($fmcbsede == "%") ? "" : $rptased->sede;
        $filename = $filname.' Documentos Emitidos';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

	public function rp_docsEmitidos_formatoSIRE()
    {
        date_default_timezone_set('America/Lima');
        $emision=$this->input->get("fi");
        $emisionf=$this->input->get("ff");
        $busqueda=$this->input->get("pg");
        $filial = ($this->input->get("fil") != "%") ? base64url_decode($this->input->get("fil")) : $this->input->get("fil");
        //$ei=$emision;
        //$ef=$emisionf;
        $this->load->model('mtipodoc_sede');

        $databuscar=array();

        if ($emision != "" && $emisionf != "") {
            $horaini = ' 00:00:01';
            $horafin = ' 23:59:59';
            $databuscar[]=$emision.$horaini;
            $databuscar[]=$emisionf.$horafin;
        }
        elseif ($emision == "" && $emisionf == "") {
            /*$emision='1990-01-01 00:00:01';
            $emisionf=date("Y-m-d").' 23:59:59';*/
        }
        elseif ($emision == "") {
            $emision='1990-01-01 00:00:01';
            $emisionf=$emisionf.' 23:59:59';
            $databuscar[]=$emision;
            $databuscar[]=$emisionf;
        }
        else{
            $emision=$emision.' 00:00:01';
            $emisionf=date("Y-m-d").' 23:59:59';
            $databuscar[]=$emision;
            $databuscar[]=$emisionf;
        }

        $a_estado=array();
        if (null !== $this->input->get("checkanulado")) {
            $a_estado[]="ANULADO";
        }
        if (null !== $this->input->get("checkenviado")) {
            $a_estado[]="ENVIADO";
        }
        if (null !== $this->input->get("checkrechazado")) {
            $a_estado[]="RECHAZADO";
        }
        if (null !== $this->input->get("checkerror")) {
            $a_estado[]="ERROR";
        }
        if (null !== $this->input->get("checkaceptado")) {
            $a_estado[]="ACEPTADO";
        }
        if (null !== $this->input->get("checkpendiente")) {
            $a_estado[]="PENDIENTE";
        }
        
        if (count($a_estado)==0){
            $a_estado[]="TODOS";
        }
        
       	$arraySedeTipoSerie=array();
        $rptased = $this->mtipodoc_sede->m_getTiposDoc( array('habilitado' => "SI"));    	   
        foreach ($rptased as $key => $sd) {
        	$clave="{$sd->codsede}.{$sd->codtipodoc}.{$sd->serie}";
        	$arraySedeTipoSerie[$clave]=$sd;
        }
        $rstdata = $this->mdocspago->m_get_emitidos_filtro_xsede($filial,$busqueda,$databuscar,$a_estado);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rptesoreria_documentosemitidos_formatosimple.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

     
        $fila=2;
        $nro=0;
        $mtotal=0;
        $mefectivo=0;
        $mbanco=0;
        $grupo="";
        $docsAcumulada=0;
        $filnotas = "";
        $nronotasc = 0;

        foreach ($rstdata as $mat) {
            $grupoint= $mat->sede;
            
           
                $nro++;
                $fila++;
                $vestado="";
                $docsAcumulada = $nro;
                
                if ($mat->estado=="ANULADO"){
                    $mat->total=0;
                    $mat->efectivo=0;
                    $mat->banco=0;
                    $vestado="AN";
                }
                $clave="{$mat->codsede}.{$mat->codtipo}.{$mat->serie}";
                if (isset($arraySedeTipoSerie[$clave]->codigo)) {
                	$SedeTipoSerie=$arraySedeTipoSerie[$clave];	                
	                $sheet->setCellValue('A'.$fila, $SedeTipoSerie->sede);
	                $sheet->setCellValue('B'.$fila, $nro);
	                //$sheet->setCellValue('B'.$fila, $mat->serie."-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT));
	                $sheet->setCellValue('C'.$fila, $SedeTipoSerie->ruc);
	                $sheet->setCellValue('D'.$fila, $SedeTipoSerie->razonsocial);
	                

	                $fechaComoEntero = strtotime($mat->fecha_hora);
	                $anio = date("Y", $fechaComoEntero);
	                $mes = date("m", $fechaComoEntero);
	                $sheet->setCellValue('E'.$fila, $anio.$mes);


	                $sheet->setCellValue('G'.$fila, date_format(date_create($mat->fecha_hora),"d/m/Y"));
	                if (!is_null($mat->vence)) $sheet->setCellValue('H'.$fila, date_format(date_create($mat->vence),"d/m/Y"));
	                $sheet->setCellValue('I'.$fila, $mat->codtipo_sunat);
	                $sheet->setCellValue('J'.$fila, $mat->serie);
	                $sheet->setCellValue('K'.$fila, str_pad($mat->numero, 2, "0", STR_PAD_LEFT));
	                $sheet->setCellValue('M'.$fila, $mat->codtipodocidentidad_sunat );
	                $sheet->setCellValue('N'.$fila, $mat->pagantenrodoc );
	                $sheet->setCellValue('O'.$fila, $mat->pagante);

	                $sheet->setCellValue('P'.$fila, $mat->dsctos_totales);
	                $sheet->setCellValue('Q'.$fila, $mat->gravada);
	                
	                $sheet->setCellValue('R'.$fila, 0);//R  DESCUENTO BASE IMPONIBLE GRAVADA
	                $sheet->setCellValue('S'.$fila, $mat->igv/100 * $mat->gravada );
	                $sheet->setCellValue('T'.$fila, 0); //T DESCUENTO IGV  18% Y 10%
	                $sheet->setCellValue('U'.$fila, $mat->exonerada);
	                $sheet->setCellValue('V'.$fila, $mat->inafecta);
	                $sheet->setCellValue('W'.$fila, $mat->isc);
	                $sheet->setCellValue('X'.$fila, 0); //X BASE IMPONIBLE IVAP - ARROZ PILADO	
	                $sheet->setCellValue('Y'.$fila, 0); //Y IVAP - ARROZ PILADO
	                $sheet->setCellValue('Z'.$fila, $mat->icbper);
	                $sheet->setCellValue('AA'.$fila, 0 ); 
	                $sheet->setCellValue('AB'.$fila, $mat->total);

	                $sheet->setCellValue('AC'.$fila, "PEN");
	                $sheet->setCellValue('AD'.$fila, "1.000");

	                $sheet->setCellValue('AE'.$fila, ""); //AE FECHA DE EMISION Doc Modificado
	                $sheet->setCellValue('AF'.$fila, $mat->codtipoafectado_sunat);
	                $sheet->setCellValue('AG'.$fila, $mat->serie_afectado);
	                $sheet->setCellValue('AH'.$fila, $mat->nro_afectado);
	                $sheet->setCellValue('AI'.$fila, "");
	                $sheet->setCellValue('AJ'.$fila, "");
	            }
	            else{
	            	$sheet->setCellValue('B'.$fila, "INFORME A SOPORTE DE PLATAFORMAL VIRTUA SOBRE ESTE MENSAJE");
	            }        
        }
        
        $writer = new Xlsx($spreadsheet);
        $filname = "";//($filial == "%") ? "" : $rptased->sede." ";
        $filename = $filname.'Documentos Emitidos SIRE';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }
}