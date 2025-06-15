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

class Docspago_excel extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mdocspago');
		
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
	            	$sheet->setCellValue('B'.$fila, "INFORME A SOPORTE DE PLATAFORMA VIRTUA SOBRE ESTE MENSAJE");
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