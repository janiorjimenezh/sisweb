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
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
//use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Asistencias_reportes extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		//$this->load->model('marea');
	}
	


 public function dp_insistencias_estudiantes_grupo()
    {
        $fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $fmcbestado=$this->input->get("es");
        $busqueda=$this->input->get("ap");
        $sede=$this->input->get("sed");
        $beneficio=$this->input->get("benf");
        $unidaddid=$this->input->get('undd');
        $this->load->model('masistencias');


        $vmatriculas=$this->masistencias->m_asistencias_x_grupo(array($sede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmcbestado,$beneficio,$unidaddid,'%'.$busqueda.'%'));
        // var_dump($vmatriculas);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("plantillas/rs_lista_inasistencias_grupo.xlsx");

        //$spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $fila=0;
        $nro=0;
        $strtimeact=strtotime("now");
        $grupo="";
        $sesiones=1;
        foreach ($vmatriculas as $mat) {
            //if ($mat->faltas > 0) {
                
                $grupoint=$mat->codperiodo.".".$mat->codcarrera.".".$mat->codplan.".".$mat->codciclo.".".$mat->codturno.".".$mat->codseccion.".".$mat->codcurso.".".$mat->subseccion;
                
                if ($grupo!=$grupoint){
                    $grupo=$grupoint;
                    $fila = $fila + 4;
                    $sesiones=$mat->sesiones;
                    $sheet->setCellValue("A".$fila, "PERIODO LECTIVO");
                    $sheet->mergeCells("A$fila:B$fila");
                    $sheet->setCellValue("C".$fila, $mat->periodo);
                    $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                    $sheet->setCellValue("D".$fila, "PROGRAMA");
                    $sheet->setCellValue("E".$fila, $mat->carrera);
                    $sheet->getStyle("E".$fila)->getFont()->setBold(true);
                    $sheet->mergeCells("E$fila:H$fila");
                    $fila++;
                    $sheet->setCellValue("A".$fila, "PERIODO ACADEM.");
                    $sheet->mergeCells("A$fila:B$fila");
                    $sheet->setCellValue("C".$fila, $mat->ciclo);
                    $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                    $sheet->setCellValue("D".$fila, "TURNO");
                    $sheet->setCellValue("E".$fila, $mat->codturno);
                    $sheet->getStyle("E".$fila)->getFont()->setBold(true);
                    $sheet->setCellValue("F".$fila, "SECCIÓN");
                    $sheet->setCellValue("G".$fila, $mat->codseccion);
                    $sheet->getStyle("G".$fila)->getFont()->setBold(true);
                    $fila++;
                    $sheet->setCellValue("A".$fila, "UNID. DIDÁCTICA");
                    $sheet->mergeCells("A$fila:B$fila");
                    $sheet->setCellValue("C".$fila, $mat->curso);
                    $sheet->getStyle("C".$fila)->getFont()->setBold(true);
                    $sheet->mergeCells("C$fila:E$fila");
                    $sheet->setCellValue("F".$fila,$mat->codcargaacademica."G".$mat->subseccion);
                    $sheet->setCellValue("G".$fila,"N° SES.");
                    $sheet->setCellValue("H".$fila, $sesiones);
                    $sheet->getStyle("F$fila:H$fila")->getFont()->setBold(true);
                    //
                    
                    $fila= $fila + 2;
                    //
      
                    $sheet->setCellValue("A".$fila, "N°");
                    $sheet->setCellValue("B".$fila, "CARNÉ");
                    $sheet->setCellValue("C".$fila, "APELLIDOS Y NOMBRES");
                    $sheet->mergeCells("C$fila:E$fila");
                    $sheet->setCellValue("F".$fila, "INASISTENC.");
                     $sheet->setCellValue("G".$fila, "PORCENTAJE");
                    
                   
                    $sheet->getStyle("A$fila:H$fila")->getFont()->setBold(true);
                    
                    
                    $sheet->getStyle("A".$fila.":H{$fila}")
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);
                    $nro=0;
                }
                
                $nro++;
                $fila++;
                
                $pfaltas=($mat->faltas/$sesiones * 100);
                $sheet->setCellValue("A".$fila, $nro);
                $sheet->setCellValue('B'.$fila, $mat->carne);
                $sheet->setCellValue('C'.$fila, $mat->paterno." ".$mat->materno." ".$mat->nombres);
                $sheet->mergeCells("C$fila:E$fila");
                $sheet->setCellValue('F'.$fila, $mat->faltas);
                $sheet->setCellValue('G'.$fila,  round($pfaltas, 2));
                if ($pfaltas>=30){
                    $spreadsheet->getActiveSheet()->getStyle("A$fila:H$fila")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                }
                elseif ($pfaltas>=20){
                    $spreadsheet->getActiveSheet()->getStyle("A$fila:H$fila")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKYELLOW);
                }
                $sheet->getStyle("A".$fila.":H{$fila}")
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);
            //}
          

        }
        /*foreach(range('A','L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }*/
        $writer = new Xlsx($spreadsheet);
 
        $filename = 'lista-inasistencias';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
     
        $writer->save('php://output'); // download file 
    }
}