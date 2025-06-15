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

class Deudasgrupo_excel extends CI_Controller {
	function __construct() {
		parent::__construct();
		
	}
    
    public function rpDeudasxGrupo_Consolidado()
    {
        $fmcbsede=$this->input->get("cd");
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan="%";//$this->input->get("cpl");
        $busqueda=$this->input->get("ap");


        $this->load->model('mdeudasgrupo');


        $arrayFiltro=array("codsede"=>$fmcbsede,"codperiodo"=>$fmcbperiodo,"codcarrera"=>$fmcbcarrera,"codplan"=>$fmcbplan,"codciclo"=>$fmcbciclo,"codturno"=>$fmcbturno,"codseccion"=>$fmcbseccion);
        $vGrupos=$this->mdeudasgrupo->m_getDeudasGrupo($arrayFiltro);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rp-DeudasPorGrupoConsolidado.xlsx");

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
       
        
        $colLetra = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(13);

        
        $fila=10;
        $nro=0;
        $vTotalGenerado=0;
        $vTotalPendiente=0;
        $vTotalRecaudado=0;

        $vFilaGruposInicial=11;
        $vFilaGruposFinal=11;

        $vFiltroSede=array();
        $vFiltroPeriodo=array();
        $vFiltroCarrera=array();
        $vFiltroCiclo=array();
        $vFiltroTurno=array();
        $vFiltroSeccion=array();
        $vFiltroCronograma=array();

        foreach ($vGrupos as $gp) {
        	$vFiltroSede[$gp->codsede]=$gp->sede_abreviatura;
        	$vFiltroPeriodo[$gp->codperiodo]=$gp->periodo;
        	$vFiltroCarrera[$gp->codcarrera]=$gp->carrera_abreviatura;
        	$vFiltroCiclo[$gp->codciclo]=$gp->ciclo;
        	$vFiltroTurno[$gp->codturno]=$gp->turno;
        	$vFiltroSeccion[$gp->codseccion]=$gp->codseccion;
        	$vFiltroCronograma[$gp->codcronograma]=$gp->cronograma;

            $nro++;
            $fila++;
            $vMontoGenerado=($gp->generado==0)? 1 : $gp->generado;
            $vMontoPendiente=$gp->pendiente;
            $vMontoRecaudado=$gp->generado - $vMontoPendiente;
            $vTotalGenerado=$vTotalGenerado + $gp->generado;
	        $vTotalPendiente=$vTotalPendiente + $vMontoPendiente;
	        $vTotalRecaudado=$vTotalRecaudado + $vMontoRecaudado;

            $sheet->setCellValue("A".$fila, $nro);
            $sheet->setCellValue("B".$fila, $gp->sede_abreviatura);
            $sheet->setCellValue('C'.$fila, $gp->periodo);
            $sheet->setCellValue('D'.$fila, $gp->cronograma);
            $sheet->setCellValue('E'.$fila, $gp->carrera_abreviatura);
            $sheet->setCellValue('F'.$fila, $gp->ciclo);
            $sheet->setCellValue('G'.$fila, $gp->turno);
            $sheet->setCellValue('H'.$fila, $gp->codseccion);
            $sheet->setCellValue('I'.$fila, $gp->generado);
            $sheet->setCellValue('J'.$fila, $vMontoRecaudado);
            $sheet->setCellValue('K'.$fila, $gp->pendiente);
            $sheet->setCellValue('L'.$fila, "=J{$fila}/I{$fila}" );
        	$sheet->setCellValue('M'.$fila, "=K{$fila}/I{$fila}");
            
           
            //$sheet->setCellValueByColumnAndRow($colrow,$fila, $totalcuotas);
            //$sheet->getStyle("$columnf{$fila}")->getFont()->setBold(true);
            $sheet->getStyle('A'.$fila.':'.$colLetra.$fila)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }
        $vFilaGruposFinal=$fila;
        // Aplicar formato de moneda (S/.)
        $sheet->getStyle("I{$vFilaGruposInicial}:K{$vFilaGruposFinal}")->getNumberFormat()->setFormatCode('[$S/. ]#,##0.00');
        //Aplicar formato de porcentaje 
        $sheet->getStyle("L{$vFilaGruposInicial}:M{$vFilaGruposFinal}")->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);
        
        $vFiltroSede[0]=(count($vFiltroSede)==1) ? reset($vFiltroSede) : "Todos";

    	$vFiltroPeriodo[0] =(count($vFiltroPeriodo)==1) ? reset($vFiltroPeriodo) : "Todos";
    	$vFiltroCarrera[0] =(count($vFiltroCarrera)==1) ? reset($vFiltroCarrera) : "Todos";
    	$vFiltroCiclo[0] =(count($vFiltroCiclo)==1) ? reset($vFiltroCiclo) : "Todos";
    	$vFiltroTurno[0] =(count($vFiltroTurno)==1) ? reset($vFiltroTurno) : "Todos";
    	$vFiltroSeccion[0] =(count($vFiltroSeccion)==1) ? reset($vFiltroSeccion) : "Todos";
    	$vFiltroCronograma[0] =(count($vFiltroCronograma)==1) ? reset($vFiltroCronograma) : "Todos";

    	$sheet->setCellValue("B5", $vFiltroSede[0]);
        $sheet->setCellValue('C5', $vFiltroPeriodo[0]);
        $sheet->setCellValue('D5', $vFiltroCronograma[0]);
        $sheet->setCellValue('E5', $vFiltroCarrera[0]);
        $sheet->setCellValue('F5', $vFiltroCiclo[0]);
        $sheet->setCellValue('G5', $vFiltroTurno[0]);
        $sheet->setCellValue('H5', $vFiltroSeccion[0]);
        $sheet->setCellValue('I5', "=SUM(I{$vFilaGruposInicial}:I{$vFilaGruposFinal})");//GENERADO
        $sheet->setCellValue('J5', "=SUM(J{$vFilaGruposInicial}:J{$vFilaGruposFinal})");//RECAUDADO
        $sheet->setCellValue('K5', "=SUM(K{$vFilaGruposInicial}:K{$vFilaGruposFinal})");//PENDIENTE
        // Aplicar formato de moneda (S/.)
        $sheet->getStyle('I5:K5')->getNumberFormat()->setFormatCode('[$S/. ]#,##0.00');

        $sheet->setCellValue('L5', "=J5/I5" );
        $sheet->setCellValue('M5', "=K5/I5");
        $sheet->getStyle('L5:M5')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);



       
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'Consolidado de deudas por grupo';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }
}

