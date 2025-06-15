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

class Matriculas_excel extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mmatricula');
        $this->load->model('mcarrera_sede');
        $this->load->model('msede');
        $this->load->model('mciclo');
        $this->load->model('mmatricula_consolidados');
        $this->load->model('minscrito_consolidados');
        $this->load->model('mperiodo');
        
	}

	public function rpMemoriaGeneralPorSede()
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

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/memoria_general_filial.xlsx");

        //HOJA 1 - MATRICULAS
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $arrayBusqueda = array('codsede' =>$fmcbsede ,'codperiodo' =>$fmcbperiodo ,'codcarrera' =>$fmcbcarrera ,'codplan' =>$fmcbplan ,'codciclo' =>$fmcbciclo ,'codturno' =>$fmcbturno ,'codseccion' =>$fmcbseccion,'fechas'=>$fmctiempo ,'estados'=>$a_estado);


        $rsProgramas= $this->mcarrera_sede->m_getCarrerasSedes(array('codsede' =>$fmcbsede,'activo'=>"SI"));
        $rsConsolidado= $this->mmatricula_consolidados->m_getConsolidadoPorSedPerProgSem($arrayBusqueda);
        $rsCiclos=$this->mciclo->m_getCiclos(array("tipo"=>"CC"));
        $rsCulminados=$this->minscrito_consolidados->mFiltrarInscripciones_culminados();
        $rsEgresados=$this->minscrito_consolidados->mFiltrarInscripciones_egresados();
        
        $sheet = $this->rpiMemoriaGeneralPorSede_matriculas($sheet,$rsProgramas,$rsConsolidado,$rsCiclos);
        //$arrayBusqueda = array('codsede' =>$fmcbsede ,'codperiodo' =>$fmcbperiodo ,'codcarrera' =>$fmcbcarrera ,'codplan' =>$fmcbplan ,'codciclo' =>$fmcbciclo ,'codturno' =>$fmcbturno ,'codseccion' =>$fmcbseccion,'fechas'=>$fmctiempo ,'estados'=>$a_estado);

        $rsCiclos=$this->mciclo->m_getCiclos(array("tipo"=>"CC"));
        $rsPeriodos=$this->mperiodo->m_getPeriodos(array("tipo"=>"ACADEMICO"));
        $arrayPeriodos=array();
        $agregarPeriodo="NO";
        $nroPeriodos=6;
        foreach ($rsPeriodos as $keyPeriodo => $periodo) {
            if ($periodo->codigo==$fmcbperiodo) $agregarPeriodo="SI";
            if (($agregarPeriodo=="SI") && ($nroPeriodos>0)){
                $arrayPeriodos[]=$periodo;
                $nroPeriodos--;
            }
        }
        $arrayBusqueda['codperiodo']="-";
        if (isset($arrayPeriodos[1])) $arrayBusqueda['codperiodo']=$arrayPeriodos[1]->codigo;
        
        $rsConsolidadoAnterior= $this->mmatricula_consolidados->m_getConsolidadoPorSedPerProgSem($arrayBusqueda);

        //HOJA 2 - DESERCIÓN
        $spreadsheet->setActiveSheetIndex(1);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet = $this->rpiMemoriaGeneralPorSede_desercion($sheet,$rsProgramas,$rsConsolidado,$rsCiclos,$rsConsolidadoAnterior);

        //HOJA 3 - EGRESADOS
        $spreadsheet->setActiveSheetIndex(2);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet = $this->rpiMemoriaGeneralPorSede_egresados($sheet,$rsProgramas,array_reverse($arrayPeriodos),$rsCulminados,$rsEgresados);

        $writer = new Xlsx($spreadsheet);
        $rptased = array();
        if ($fmcbsede != "%") {
            $rptased = $this->msede->m_get_sede_config_x_codigo(array($fmcbsede));
        }

        $filname = ($fmcbsede == "%") ? "" : $rptased->sede;
        $filename = $filname.' Memoria General';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    private function rpiMemoriaGeneralPorSede_matriculas($sheet,$rsProgramas,$rsConsolidado,$rsCiclos){
        //CONSOLIDADO DE MATRICULAS
        $filaGeneral=4;
        $columnasSemestre=array('01' => "C",'02' => "D",'03' => "E",'04' => "F",'05' => "G",'06' => "H");
        $array_filaMatRegulares=array();
        $array_filaMatReincorporaciones=array();
        $array_filaMatTraslados=array();
        $array_filaMatRetirados=array();
        $array_filaMatReservas=array();
        $array_filaMatTotal=array();
        foreach ($rsProgramas as $keyPrograma => $programa) {
            $filaGeneral=$filaGeneral+ 2 ;
            $sheet->setCellValue("A{$filaGeneral}", $programa->carrera);
            $sheet->getStyle("A{$filaGeneral}")->getFont()->setBold(true);
            $sheet->mergeCells("A$filaGeneral:I$filaGeneral");
            $sheet->getStyle('A'.$filaGeneral)->getAlignment()->setHorizontal('center');
            $filaGeneral=$filaGeneral+2;
            $filaMatRegulares=$filaGeneral;
            $filaMatReincorporaciones=$filaMatRegulares + 1;
            $filaMatTraslados=$filaMatReincorporaciones + 1;
            $filaMatRetirados=$filaMatTraslados + 1;
            $filaMatReservas=$filaMatRetirados + 1;
            $filaMatTotal=$filaMatReservas + 1;
            
            //GUARDAMOS LAS FILAS PARA EL TOTAL
            $array_filaMatRegulares[]=$filaMatRegulares;
            $array_filaMatReincorporaciones[]=$filaMatReincorporaciones;
            $array_filaMatTraslados[]=$filaMatTraslados;
            $array_filaMatRetirados[]=$filaMatRetirados;
            $array_filaMatReservas[]=$filaMatReservas;
            $array_filaMatTotal[]=$filaMatTotal;
            
            $sheet->setCellValue("B{$filaMatRegulares}", "Nro. Matrículas Regulares");
            $sheet->setCellValue("B{$filaMatReincorporaciones}", "Nro. Reincorporaciones");
            $sheet->setCellValue("B{$filaMatTraslados}", "Nro. Traslados");
            $sheet->setCellValue("B{$filaMatRetirados}", "Nro. Retirados");
            $sheet->setCellValue("B{$filaMatReservas}", "Nro. Reservas");
            $sheet->setCellValue("B{$filaMatTotal}", "Total");

            $sheet->setCellValue("I{$filaMatRegulares}", "=SUM(C{$filaMatRegulares}:H{$filaMatRegulares})");
            $sheet->setCellValue("I{$filaMatReincorporaciones}", "=SUM(C{$filaMatReincorporaciones}:H{$filaMatReincorporaciones})");
            $sheet->setCellValue("I{$filaMatTraslados}", "=SUM(C{$filaMatTraslados}:H{$filaMatTraslados})");
            $sheet->setCellValue("I{$filaMatRetirados}", "=SUM(C{$filaMatRetirados}:H{$filaMatRetirados})");
            $sheet->setCellValue("I{$filaMatReservas}", "=SUM(C{$filaMatReservas}:H{$filaMatReservas})");
            $sheet->setCellValue("I{$filaMatTotal}", "=SUM(C{$filaMatTotal}:H{$filaMatTotal})");

            
            $sheet->setCellValue("C{$filaMatTotal}", "=SUM(C{$filaMatRegulares}:C{$filaMatReservas})");
            $sheet->setCellValue("D{$filaMatTotal}", "=SUM(D{$filaMatRegulares}:D{$filaMatReservas})");
            $sheet->setCellValue("E{$filaMatTotal}", "=SUM(E{$filaMatRegulares}:E{$filaMatReservas})");
            $sheet->setCellValue("F{$filaMatTotal}", "=SUM(F{$filaMatRegulares}:F{$filaMatReservas})");
            $sheet->setCellValue("G{$filaMatTotal}", "=SUM(G{$filaMatRegulares}:G{$filaMatReservas})");
            $sheet->setCellValue("H{$filaMatTotal}", "=SUM(H{$filaMatRegulares}:H{$filaMatReservas})");
            $sheet->setCellValue("I{$filaMatTotal}", "=SUM(I{$filaMatRegulares}:I{$filaMatReservas})");

            $filaEncabezadoCiclo=$filaGeneral-1;
            $sheet->setCellValue("I{$filaEncabezadoCiclo}", "Total");
            $sheet->getStyle('I'.$filaEncabezadoCiclo)->getAlignment()->setHorizontal('center');
            $sheet->getStyle("I{$filaEncabezadoCiclo}")->getFont()->setBold(true);
            foreach ($rsCiclos as $keyCiclo => $ciclo) {
                $sheet->setCellValue("{$columnasSemestre["$ciclo->codigo"]}{$filaEncabezadoCiclo}", $ciclo->nombre);
                $sheet->getStyle("{$columnasSemestre["$ciclo->codigo"]}{$filaEncabezadoCiclo}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("{$columnasSemestre["$ciclo->codigo"]}{$filaEncabezadoCiclo}")->getFont()->setBold(true);
                foreach ($rsConsolidado as $keyConsolidado => $consolidado) {
                    $total=0;
                    if (($programa->codcarrera==$consolidado->codcarrera) && ($ciclo->codigo==$consolidado->codciclo)){
                        $sheet->setCellValue("{$columnasSemestre["$ciclo->codigo"]}{$filaMatRegulares}", $consolidado->total);
                    }
                }
            }
            $filaGeneral=$filaMatTotal+2;
        }
        $filaGeneral=$filaMatTotal+2;
        
        $sheet->setCellValue("A{$filaGeneral}","TOTAL FILIAL");
        $sheet->getStyle("A{$filaGeneral}")->getFont()->setBold(true);
        $sheet->mergeCells("A$filaGeneral:I$filaGeneral");
        $sheet->getStyle('A'.$filaGeneral)->getAlignment()->setHorizontal('center');
        $filaGeneral=$filaGeneral+2;
        $filaMatRegulares=$filaGeneral;
        $filaMatReincorporaciones=$filaMatRegulares + 1;
        $filaMatTraslados=$filaMatReincorporaciones + 1;
        $filaMatRetirados=$filaMatTraslados + 1;
        $filaMatReservas=$filaMatRetirados + 1;
        $filaMatTotal=$filaMatReservas + 1;

        $sheet->setCellValue("B{$filaMatRegulares}", "Nro. Matrículas Regulares");
        $sheet->setCellValue("B{$filaMatReincorporaciones}", "Nro. Reincorporaciones");
        $sheet->setCellValue("B{$filaMatTraslados}", "Nro. Traslados");
        $sheet->setCellValue("B{$filaMatRetirados}", "Nro. Retirados");
        $sheet->setCellValue("B{$filaMatReservas}", "Nro. Reservas");
        $sheet->setCellValue("B{$filaMatTotal}", "Total");

        $sheet->setCellValue("I{$filaMatRegulares}", "=SUM(C{$filaMatRegulares}:H{$filaMatRegulares})");
        $sheet->setCellValue("I{$filaMatReincorporaciones}", "=SUM(C{$filaMatReincorporaciones}:H{$filaMatReincorporaciones})");
        $sheet->setCellValue("I{$filaMatTraslados}", "=SUM(C{$filaMatTraslados}:H{$filaMatTraslados})");
        $sheet->setCellValue("I{$filaMatRetirados}", "=SUM(C{$filaMatRetirados}:H{$filaMatRetirados})");
        $sheet->setCellValue("I{$filaMatReservas}", "=SUM(C{$filaMatReservas}:H{$filaMatReservas})");
        $sheet->setCellValue("I{$filaMatTotal}", "=SUM(C{$filaMatTotal}:H{$filaMatTotal})");

        
        $sheet->setCellValue("C{$filaMatTotal}", "=SUM(C{$filaMatRegulares}:C{$filaMatReservas})");
        $sheet->setCellValue("D{$filaMatTotal}", "=SUM(D{$filaMatRegulares}:D{$filaMatReservas})");
        $sheet->setCellValue("E{$filaMatTotal}", "=SUM(E{$filaMatRegulares}:E{$filaMatReservas})");
        $sheet->setCellValue("F{$filaMatTotal}", "=SUM(F{$filaMatRegulares}:F{$filaMatReservas})");
        $sheet->setCellValue("G{$filaMatTotal}", "=SUM(G{$filaMatRegulares}:G{$filaMatReservas})");
        $sheet->setCellValue("H{$filaMatTotal}", "=SUM(H{$filaMatRegulares}:H{$filaMatReservas})");
        $sheet->setCellValue("I{$filaMatTotal}", "=SUM(I{$filaMatRegulares}:I{$filaMatReservas})");

        $filaEncabezadoCiclo=$filaGeneral-1;
        $sheet->setCellValue("I{$filaEncabezadoCiclo}", "Total");
        $sheet->getStyle('I'.$filaEncabezadoCiclo)->getAlignment()->setHorizontal('center');
        $sheet->getStyle("I{$filaEncabezadoCiclo}")->getFont()->setBold(true);
        foreach ($rsCiclos as $keyCiclo => $ciclo) {
            $sheet->setCellValue("{$columnasSemestre["$ciclo->codigo"]}{$filaEncabezadoCiclo}", $ciclo->nombre);
            $sheet->getStyle("{$columnasSemestre["$ciclo->codigo"]}{$filaEncabezadoCiclo}")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("{$columnasSemestre["$ciclo->codigo"]}{$filaEncabezadoCiclo}")->getFont()->setBold(true);

            $text_filaMatRegulares=implode(" + {$columnasSemestre["$ciclo->codigo"]}", $array_filaMatRegulares);
            $text_filaMatReincorporaciones=implode(" + {$columnasSemestre["$ciclo->codigo"]}", $array_filaMatReincorporaciones);
            $text_filaMatTraslados=implode(" + {$columnasSemestre["$ciclo->codigo"]}", $array_filaMatTraslados);
            $text_filaMatRetirados=implode(" + {$columnasSemestre["$ciclo->codigo"]}", $array_filaMatRetirados);
            $text_filaMatReservas=implode(" + {$columnasSemestre["$ciclo->codigo"]}", $array_filaMatReservas);
            $text_filaMatTotal=implode(" + {$columnasSemestre["$ciclo->codigo"]}", $array_filaMatTotal);
            
            $sheet->setCellValue("{$columnasSemestre[$ciclo->codigo]}{$filaMatRegulares}", "=SUM({$columnasSemestre["$ciclo->codigo"]}$text_filaMatRegulares)");
            $sheet->setCellValue("{$columnasSemestre[$ciclo->codigo]}{$filaMatReincorporaciones}", "=SUM({$columnasSemestre["$ciclo->codigo"]}$text_filaMatReincorporaciones)");
            $sheet->setCellValue("{$columnasSemestre[$ciclo->codigo]}{$filaMatTraslados}", "=SUM({$columnasSemestre["$ciclo->codigo"]}$text_filaMatTraslados)");
            $sheet->setCellValue("{$columnasSemestre[$ciclo->codigo]}{$filaMatRetirados}", "=SUM({$columnasSemestre["$ciclo->codigo"]}$text_filaMatRetirados)");
            $sheet->setCellValue("{$columnasSemestre[$ciclo->codigo]}{$filaMatReservas}", "=SUM({$columnasSemestre["$ciclo->codigo"]}$text_filaMatReservas)");
            //$sheet->setCellValue("{$columnasSemestre["$ciclo->codigo"]}{$filaMatRegulares}", "=SUM($text_filaMatRegulares)");
        }
        
        return $sheet;
    }

    private function rpiMemoriaGeneralPorSede_desercion($sheet,$rsProgramas,$rsConsolidado,$rsCiclos,$rsConsolidadoAnterior){
        //CONSOLIDADO DE MATRICULAS
        $filaGeneral=8;
        $columnasSemestre=array('02' => array("C","D","E"),'03' => array("F","G","H"),'04' => array("I","J","K"),'05' => array("L","M","N"),'06' => array("O","P","R"));
        $cicloComparar=array('02' => "01",'03' => "02",'04' => "03",'05' => "04",'06' => "05");
        foreach ($rsProgramas as $keyPrograma => $programa) {
            $sheet->setCellValue("B{$filaGeneral}", $programa->carrera);
            foreach ($rsCiclos as $keyCiclo => $ciclo) {
                if ($ciclo->codigo!=="01"){
                    foreach ($rsConsolidado as $keyConsolidado => $consolidado) {
                        if (($programa->codcarrera==$consolidado->codcarrera) && ($ciclo->codigo==$consolidado->codciclo)){
                            $columnas=$columnasSemestre["$ciclo->codigo"];

                            $sheet->setCellValue("{$columnas[1]}{$filaGeneral}", $consolidado->total);
                            foreach ($rsConsolidadoAnterior as $keyCA => $consolidadoAnterior) {
                                if (($programa->codcarrera==$consolidadoAnterior->codcarrera) && ($cicloComparar["$ciclo->codigo"]==$consolidadoAnterior->codciclo)){
                                    $sheet->setCellValue("{$columnas[0]}{$filaGeneral}", $consolidadoAnterior->total);
                                }
                            }
                            //=(D9-C9)/C9*100
                            $sheet->setCellValue("{$columnas[2]}{$filaGeneral}", "=({$columnas[1]}{$filaGeneral}-{$columnas[0]}{$filaGeneral})/{$columnas[0]}{$filaGeneral} * 100");
                        }
                    }
                }
                //$sheet->setCellValue("{$columnasSemestre["$ciclo->codigo"]}{$filaEncabezadoCiclo}", $ciclo->nombre);
            }
            //$sheet->setCellValue("I{$filaEncabezadoCiclo}", "Total");
            //$sheet->setCellValue("I{$filaGeneral}", "=SUM(C{$filaGeneral}:H{$filaGeneral})");
            $filaGeneral++;
        }
        return $sheet;
    }
    
    private function rpiMemoriaGeneralPorSede_egresados($sheet,$rsProgramas,$arrayPeriodos,$rsCulminados,$rsEgresados){
        //CONSOLIDADO DE MATRICULAS
        
        $columnasPeriodo=array("C","D","E","F","G","H");
        $cuadros=array("CULMINADOS"=>$rsCulminados,"EGRESADOS"=>$rsEgresados,"CONTACTADOS"=>$rsEgresados,"TITULADOS"=>$rsEgresados);
        $cuadrosFilas=array("CULMINADOS"=>array(),"EGRESADOS"=>array(),"CONTACTADOS"=>array(),"TITULADOS"=>array());

        $filaGeneral=8;

        foreach ($cuadros as $keyCuadro => $cuadro) {
            $filaEncabezadoPeriodo=$filaGeneral - 1;
            $colPeriodo=3;
            
            $sheet->setCellValue("B{$filaEncabezadoPeriodo}", $keyCuadro);
            foreach ($arrayPeriodos as $keyPeriodo => $periodo){
                $sheet->setCellValueByColumnAndRow($colPeriodo,$filaEncabezadoPeriodo, $periodo->nombre);
                $colPeriodo++;
            }
            $filaInicia=$filaGeneral;
            foreach ($rsProgramas as $keyPrograma => $programa) {
                $sheet->setCellValue("B{$filaGeneral}", $programa->carrera);
                $cuadrosFilas[$keyCuadro][$programa->codcarrera]=$filaGeneral;
                foreach ($arrayPeriodos as $keyPeriodo => $periodo) {
                    foreach ($cuadro as $keyCulminado => $culminado) {
                        if (($culminado->codcarrera==$programa->codcarrera) && ($culminado->codperiodo==$periodo->codigo)){
                            $sheet->setCellValue("{$columnasPeriodo[$keyPeriodo]}{$filaGeneral}", $culminado->total);
                        }
                    }
                }
                $filaGeneral++;
            }
            $sheet->setCellValue("B{$filaGeneral}", "Total");
            
            foreach ($arrayPeriodos as $keyPeriodo => $periodo){
                $col=$columnasPeriodo[$keyPeriodo];
                $sheet->setCellValue("{$col}{$filaGeneral}", "=SUM({$col}{$filaInicia}:{$col}{$filaGeneral})");
            }
            $sheet->getStyle("B{$filaEncabezadoPeriodo}:{$col}{$filaEncabezadoPeriodo}")->getFont()->setBold(true);
            //$sheet->getStyle("A$fila")->getFont()->setSize(12);
            $sheet->getStyle("B{$filaEncabezadoPeriodo}:{$col}{$filaEncabezadoPeriodo}")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("B{$filaEncabezadoPeriodo}:{$col}{$filaEncabezadoPeriodo}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('D21A1A');
            $sheet->getStyle("B{$filaInicia}:B{$filaGeneral}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('FEF4F4');
            $sheet->getStyle("B{$filaEncabezadoPeriodo}:{$col}{$filaGeneral}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            $filaGeneral=$filaGeneral+ 5;
        }

        //PORCENTAJE DE EGRESADOS CONTACTADOS
        $filaEncabezadoPeriodo=$filaGeneral - 1;
        $colPeriodo=3;
        $sheet->setCellValue("B{$filaEncabezadoPeriodo}", "EGRESADOS CONTACTADOS");
        foreach ($arrayPeriodos as $keyPeriodo => $periodo){
            $sheet->setCellValueByColumnAndRow($colPeriodo,$filaEncabezadoPeriodo, $periodo->nombre);
            $colPeriodo++;
        }
        $filaInicia=$filaGeneral;
        foreach ($rsProgramas as $keyPrograma => $programa) {
            $sheet->setCellValue("B{$filaGeneral}", $programa->carrera);
            //$cuadrosFilas[$keyCuadro][$programa->codcarrera]=$filaGeneral;
            foreach ($arrayPeriodos as $keyPeriodo => $periodo) {
                $col=$columnasPeriodo[$keyPeriodo];
                $filaEgresado=$cuadrosFilas["EGRESADOS"][$programa->codcarrera];
                $filaContactado=$cuadrosFilas["CONTACTADOS"][$programa->codcarrera];
                $sheet->setCellValue("{$col}{$filaGeneral}", "={$col}{$filaContactado}/{$col}{$filaEgresado}");
            }
            $filaGeneral++;
        }
        $sheet->getStyle("B{$filaEncabezadoPeriodo}:{$col}{$filaEncabezadoPeriodo}")->getFont()->setBold(true);
        //$sheet->getStyle("A$fila")->getFont()->setSize(12);
        $sheet->getStyle("B{$filaEncabezadoPeriodo}:{$col}{$filaEncabezadoPeriodo}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B{$filaEncabezadoPeriodo}:{$col}{$filaEncabezadoPeriodo}")
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('D21A1A');
        $sheet->getStyle("B{$filaInicia}:B{$filaGeneral}")
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('FEF4F4');
        $sheet->getStyle("B{$filaEncabezadoPeriodo}:{$col}{$filaGeneral}")
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        $filaGeneral=$filaGeneral+ 5;


        //CUADRO FINAL CULMINADOS - EGRESADOS - TITULADOS
        $filaEncabezadoPeriodo=$filaGeneral - 1;
        $colPeriodo=3;
        $sheet->setCellValue("B{$filaEncabezadoPeriodo}", "CUADRO COMPARATIVO");
        foreach ($arrayPeriodos as $keyPeriodo => $periodo){
            $sheet->setCellValueByColumnAndRow($colPeriodo,$filaEncabezadoPeriodo, $periodo->nombre);
            $sheet->setCellValueByColumnAndRow($colPeriodo,$filaGeneral, "CULMINADOS");
            $sheet->setCellValueByColumnAndRow($colPeriodo + 1 ,$filaGeneral, "EGRESADOS");
            $sheet->setCellValueByColumnAndRow($colPeriodo + 2 ,$filaGeneral, "TITULADOS");
            $colPeriodo=$colPeriodo + 3;
        }
        
        $filaGeneral++;
        $filaInicia=$filaGeneral;
        foreach ($rsProgramas as $keyPrograma => $programa) {
            $colPeriodo=3;
            $sheet->setCellValue("B{$filaGeneral}", $programa->carrera);
            //$cuadrosFilas[$keyCuadro][$programa->codcarrera]=$filaGeneral;
            foreach ($arrayPeriodos as $keyPeriodo => $periodo) {
                $col=$columnasPeriodo[$keyPeriodo];
                $filaCulminado=$cuadrosFilas["CULMINADOS"][$programa->codcarrera];
                $filaEgresado=$cuadrosFilas["EGRESADOS"][$programa->codcarrera];
                $filaTitulado=$cuadrosFilas["TITULADOS"][$programa->codcarrera];
                //$sheet->setCellValue("{$col}{$filaGeneral}", "={$col}{$filaContactado}/{$col}{$filaEgresado}");
                $sheet->setCellValueByColumnAndRow( $colPeriodo ,$filaGeneral, "={$col}{$filaCulminado}");
                $sheet->setCellValueByColumnAndRow( $colPeriodo  + 1,$filaGeneral, "={$col}{$filaEgresado}");
                $sheet->setCellValueByColumnAndRow( $colPeriodo  + 2,$filaGeneral, "={$col}{$filaTitulado}");
                $colPeriodo=$colPeriodo + 3;
            }
            $filaGeneral++;
        }

        return $sheet;
    }
    public function rpMemoriaGeneralPorSedeDesercion()
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

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/memoria_general_filial.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $arrayBusqueda = array('codsede' =>$fmcbsede ,'codperiodo' =>$fmcbperiodo ,'codcarrera' =>$fmcbcarrera ,'codplan' =>$fmcbplan ,'codciclo' =>$fmcbciclo ,'codturno' =>$fmcbturno ,'codseccion' =>$fmcbseccion,'fechas'=>$fmctiempo ,'estados'=>$a_estado);


        $rsProgramas= $this->mcarrera_sede->m_getCarrerasSedes(array('codsede' =>$fmcbsede));
        $rsConsolidado= $this->mmatricula_consolidados->m_getConsolidadoPorSedPerProgSem($arrayBusqueda);
        $rsCiclos=$this->mciclo->m_getCiclos(array("tipo"=>"CC"));

        $rsPeriodos=$this->mperiodo->m_getPeriodos(array("tipo"=>"ACADEMICO"));
        $arrayBusqueda['codperiodo']="20232";
        $rsConsolidadoAnterior= $this->mmatricula_consolidados->m_getConsolidadoPorSedPerProgSem($arrayBusqueda);
        
        $filaGeneral=8;

        $columnasSemestre=array('02' => array("C","D"),'03' => array("F","G"),'04' => array("I","J"),'05' => array("L","M"),'06' => array("O","P"));
        $cicloComparar=array('02' => "01",'03' => "02",'04' => "03",'05' => "04",'06' => "05");
        foreach ($rsProgramas as $keyPrograma => $programa) {
            $sheet->setCellValue("B{$filaGeneral}", $programa->carrera);
            foreach ($rsCiclos as $keyCiclo => $ciclo) {
                if ($ciclo->codigo!=="01"){
                    foreach ($rsConsolidado as $keyConsolidado => $consolidado) {
                        if (($programa->codcarrera==$consolidado->codcarrera) && ($ciclo->codigo==$consolidado->codciclo)){
                            $columnas=$columnasSemestre["$ciclo->codigo"];

                            $sheet->setCellValue("{$columnas[0]}{$filaGeneral}", $consolidado->total);
                            foreach ($rsConsolidadoAnterior as $keyCA => $consolidadoAnterior) {
                                if (($programa->codcarrera==$consolidadoAnterior->codcarrera) && ($cicloComparar["$ciclo->codigo"]==$consolidadoAnterior->codciclo)){
                                    $sheet->setCellValue("{$columnas[1]}{$filaGeneral}", $consolidadoAnterior->total);
                                }
                            }
                        }
                    }
                }
                //$sheet->setCellValue("{$columnasSemestre["$ciclo->codigo"]}{$filaEncabezadoCiclo}", $ciclo->nombre);
                
            }
            //$sheet->setCellValue("I{$filaEncabezadoCiclo}", "Total");
            //$sheet->setCellValue("I{$filaGeneral}", "=SUM(C{$filaGeneral}:H{$filaGeneral})");

            $filaGeneral++;
        }

        $writer = new Xlsx($spreadsheet);
        $rptased = array();
        if ($fmcbsede != "%") {
            $rptased = $this->msede->m_get_sede_config_x_codigo(array($fmcbsede));
        }

        $filname = ($fmcbsede == "%") ? "" : $rptased->sede;
        $filename = $filname.' Memoria General';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

    public function rpPadronEvaluacionesPorGrupos()
    {
        // $fmcbperiodo=;
        // $fmcbsede=;
        // $fmcbcarrera=;
        // $fmcbciclo=;
        // $fmcbturno=;
        // $fmcbseccion=;
        // $fmcbplan=;

        $this->load->model('miestp');
        $iestp=$this->miestp->m_get_datos();
        $this->load->model('mgrupos');
        $filtro_array=array();
            //$filtro_array['codsede']=$_SESSION['userActivo']->idsede;
        if (null !==$this->input->get("sd")){
            $variable=(trim($this->input->get("sd"))=="") ? "%" : trim($this->input->get("sd"));
            $filtro_array['codsede']=$variable;
        } 
        if (null !==$this->input->get("cp")){
            $variable=(trim($this->input->get("cp"))=="") ? "%" : trim($this->input->get("cp"));
            $filtro_array['codperiodo']=$variable;
        } 
        if (null !==$this->input->get("cc")){
            $variable=(trim($this->input->get("cc"))=="") ? "%" : trim($this->input->get("cc"));
            $filtro_array['codcarrera']=$variable;
        }
        if (null !==$this->input->get("cpl")){
            $variable=(trim($this->input->get("cpl"))=="") ? "%" : trim($this->input->get("cpl"));
            $filtro_array['codplan']=$variable;
        }
        if (null !==$this->input->get("ccc")){
            $variable=(trim($this->input->get("ccc"))=="") ? "%" : trim($this->input->get("ccc"));
            $filtro_array['codciclo']=$variable;
        }
        if (null !==$this->input->get("ct")){
            $variable=(trim($this->input->get("ct"))=="") ? "%" : trim($this->input->get("ct"));
            $filtro_array['codturno']=$variable;
        }
        if (null !==$this->input->get("cs")){
            $variable=(trim($this->input->get("cs"))=="") ? "%" : trim($this->input->get("cs"));
            $filtro_array['codseccion']=$variable;
        }

        //$docs=$this->mdocspago->m_getDocsPago($filtro_array);
        $grupos=$this->mgrupos->m_filtrar($filtro_array);
        //$grupos=$this->mgrupos->m_filtrar(array("codsede"=>$_SESSION['userActivo']->idsede,"codperiodo"=>$fmcbperiodo,"codcarrera"=>$fmcbcarrera,"codplan"=>$fmcbplan,"codciclo"=>$fmcbciclo,"codturno"=>$fmcbturno,"codseccion"=>$fmcbseccion));
        
        $this->load->model('mcargaacademica');
        $filtro_array['activo']="SI";
        $vcursos=$this->mcargaacademica->m_getCargasAcademicas($filtro_array);
        $this->load->model('mmiembros_migrado');
        $vmatriculas=$this->mmiembros_migrado->m_getMiembros_Migrados($filtro_array);
        // $vnotas=$this->mmiembros->m_notas_x_grupo(array($fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion));
        $vnotas=$this->mmiembros_migrado->m_getMiembros_notasFinalesMigradas($filtro_array);
        $dominio=str_replace(".", "_",getDominio());
         
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/padron_evaluaciones.xlsx");
        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        $filaGeneral=2;
        //var_dump($grupos);
            foreach ($grupos as $keyGrupo => $grupo) {
                $filaGeneral= $filaGeneral+ 2;
                $sheet->setCellValue("B$filaGeneral", "PERIODO:");
                $sheet->setCellValue("E$filaGeneral", "PLAN:");
                $sheet->setCellValue("D$filaGeneral", $grupo->periodo);
                $sheet->setCellValue("F$filaGeneral", $grupo->plan);
                $filaGeneral++;
                $sheet->setCellValue("B$filaGeneral", "PROGRAMA:");
                $sheet->setCellValue("D$filaGeneral", $grupo->carrera);
                $filaGeneral++;
                $sheet->setCellValue("B$filaGeneral", "SEMESTRE:");
                $sheet->setCellValue("E$filaGeneral", "TURNO:");
                $sheet->setCellValue("D$filaGeneral", $grupo->ciclo);
                $sheet->setCellValue("F$filaGeneral", $grupo->turno);
                $filaGeneral++;
                $sheet->setCellValue("B$filaGeneral", "SECCIÓN:");
                $sheet->setCellValue("D$filaGeneral", $grupo->seccion);
                $sheet->setCellValue("E$filaGeneral", "SEDE:");
                $sheet->setCellValue("F$filaGeneral", $grupo->sede);
                $filaGeneral= $filaGeneral+ 2;
               
                $colCurso=6;
                $vcursos2=array();
                foreach ($vcursos as $curso) {
                    if (($grupo->codsede==$curso->codsede) && ($grupo->codperiodo==$curso->codperiodo) && ($grupo->codcarrera==$curso->codcarrera) &&($grupo->codciclo==$curso->codciclo) && ($grupo->codturno==$curso->codturno) &&($grupo->codseccion==$curso->codseccion) &&($grupo->idplan==$curso->codplan)){
                        $vcursos2[]=$curso;
                        $colCurso++;
                        $sheet->setCellValueByColumnAndRow($colCurso,$filaGeneral, $curso->curso);
                    }
                }
                
                $nro=0;
                foreach ($vmatriculas as $mat) {
                    if (($grupo->codsede==$mat->codsede) && ($grupo->codperiodo==$mat->codperiodo) && ($grupo->codcarrera==$mat->codcarrera) &&($grupo->codciclo==$mat->codciclo) && ($grupo->codturno==$mat->codturno) &&($grupo->codseccion==$mat->codseccion) &&($grupo->idplan==$mat->codplan)){
                        $nro++;
                        $filaGeneral++;
                        //if ($fila==43) $fila=48;
                        $sheet->setCellValue("B".$filaGeneral, $nro);
                        $sheet->setCellValue('C'.$filaGeneral, $mat->numero);
                        $sheet->setCellValue('D'.$filaGeneral, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                        $colCurso=6;
                        foreach ($vcursos2 as $curso) {
                            $colCurso++;
                            foreach ($vnotas as $key => $nota) {
                                if (($mat->codmatricula==$nota->codmatricula_migrada) && ($curso->codunidad==$nota->codunidad_migrada)){
                                    /*$rc=$nota->recuperacion;
                                    if (!is_numeric($rc)) $rc="";
                                    $notapf=($rc!="") ? $rc : $nota->final;*/

                                    $funcionhelp="getNotas_alumnoboleta_$dominio";
                                    $notapf = $funcionhelp($nota->metodocalculo_migrada,array('promedio' => $nota->notafin_migrada, 'recupera'=>$nota->notarecuperacion_migrada));
                                    if (($nota->estado_migrada=="DPI") or ($nota->estado_migrada=="NSP")){
                                        $notapf=$nota->estado_migrada;
                                    }
                                    $sheet->setCellValueByColumnAndRow($colCurso,$filaGeneral, $notapf);
                                    unset($vnotas[$key]);
                                }
                            }
                        }
                    }
                } 
            }
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'PADRON-DE-EVALUACIONs';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }

}