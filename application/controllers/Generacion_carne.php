<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class Generacion_carne extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('madmision');
		$this->load->model('mlenguas');
		$this->load->model('mauditoria');

		$this->load->model('msede');
		$this->load->model('mperiodo');
		$this->load->model('mcarrera');
		$this->load->model('mplancurricular');
		$this->load->model('mtemporal');
		$this->load->model('mmatricula');
		$this->load->model('mbeneficio');
	}
	
	public function vw_principal(){
		$ahead= array('page_title' =>'Generación Carne | IESTWEB'  );
		$asidebar= array('menu_padre' =>'rpcarne','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		//$this->load->view('sidebar',$asidebar);
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        $this->load->view($vsidebar,$asidebar);
		$this->load->model('mubigeo');
		$ubigeo['departamentos'] =$this->mubigeo->m_departamentos();
		$ubigeo['paises'] = $this->mubigeo->m_paises();
		$ubigeo['dlenguas']=$this->mlenguas->m_get_lenguas();

		$a_ins['sedes'] = $this->msede->m_get_sedes_activos();
		$a_ins['periodos']=$this->mperiodo->m_get_periodos();
		$a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
        $a_ins['planes']=$this->mplancurricular->m_get_planes_activos();
		$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
		$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
		$a_ins['secciones']=$this->mtemporal->m_get_secciones();
		$a_ins['estados'] = $this->mmatricula->m_filtrar_estadoalumno();
		$a_ins['beneficios']=$this->mbeneficio->m_get_beneficios();
		$this->load->view('admision/impresion/vw_generacion_carne',$a_ins);
		$this->load->view('footer');
	}

	public function fn_filtrar_generacion()
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
            $fmcbsede=$this->input->post('fmt-cbsede');
            $fmcbperiodo=$this->input->post('fmt-cbperiodo');
            $fmcbcarrera=$this->input->post('fmt-cbcarrera');
            $fmcbciclo=$this->input->post('fmt-cbciclo');
            $fmcbturno=$this->input->post('fmt-cbturno');
            $fmcbseccion=$this->input->post('fmt-cbseccion');
            $fmcbplan=$this->input->post('fmt-cbplan');
            $fmalumno=$this->input->post('fmt-alumno');
            $fmtcbestado=$this->input->post('fmt-cbestado');   
            $fmtcbbeneficio=$this->input->post('fmt-cbbeneficio');    
            
            
            
            $fmalumno=str_replace(" ","%",$fmalumno);
            $matriculas=$this->mmatricula->m_filtrar(array($fmcbsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmtcbestado,$fmtcbbeneficio,'%'.$fmalumno.'%'));
            foreach ($matriculas as $key => $matricula) {
                $matriculas[$key]->codmatricula64=base64url_encode($matricula->codmatricula);
                $matriculas[$key]->fotoper64=base64url_encode($matricula->foto);
                $matriculas[$key]->codper64 = base64url_encode($matricula->idpersona);
                $matriculas[$key]->codins64 = base64url_encode($matricula->codinscripcion);

                date_default_timezone_set ('America/Lima');
                $dia_actual = date("Y-m-d");
                $edad_diff = date_diff(date_create($matricula->fechanac), date_create($dia_actual))->format('%y');
                $matriculas[$key]->edad=($edad_diff>0)?"($edad_diff)":"";

                $registro = new DateTime($matricula->fecregistro);
                $matriculas[$key]->registro = $registro->format("d/m/Y");
                $matriculas[$key]->regishora = $registro->format("H:i a");
                $matriculas[$key]->vpension = number_format($matricula->pension, 2);
                $matriculas[$key]->vrepension = number_format($matricula->pensionreal, 2);

            }
            $dataex['vdata'] =$matriculas;
            //$dataex['vdataest'] =$cuentas['estadistica'];
            $dataex['status'] = true;
            $dataex['vpermiso105'] = getPermitido("105");//ver deudas
            $dataex['vpermiso178'] = getPermitido("178");//cambiar estado matricula
            $dataex['vpermiso179'] = getPermitido("179");//editar matricula
            $dataex['vpermiso200'] = getPermitido("200");//descargar ficha
            $dataex['vpermiso201'] = getPermitido("201");//descargar record
            $dataex['vpermiso202'] = getPermitido("202");//visualizar boleta
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));
    }

    public function get_carne_estudiantes_bandeja()
	{
		
        $this->load->model('minscrito');
        $vmatriculas = [];
		$gpmatriculas = [];
        if (isset($_POST['filas'])) {
			$data          = json_decode($_POST['filas']);
			
			foreach ($data as $key => $item) {
				$apellidos = explode(" ",$item[0]);
				$paterno = $apellidos[0];
				$materno = $apellidos[1];
	    		$nombres = $item[1];
	    		$carabrevia = $item[2];
	    		$ciclo = $item[3];
	    		$carnet = $item[4];
	    		$turno = $item[5];
	    		$periodo = $item[6];
	    		$codpersona = base64url_decode($item[8]);
	    		$foto = base64url_decode($item[7]);
	    		$fechaemision = $item[9];
	    		
	    		// $vmatriculas[] = array('paterno'=>$paterno,'materno'=>$materno,'nombres'=>$nombres,'carabrevia'=>$carabrevia,'ciclo'=>$ciclo,'carnet'=>$carnet,'turno'=>$turno,'periodo'=>$periodo,'foto'=>$foto,'codpersona'=>$codpersona);
	    		$gpmatricula = new stdClass;
	    		$gpmatricula->paterno = $item[0];
				$gpmatricula->materno = "";
				$gpmatricula->nombres = $nombres;
				$gpmatricula->carabrevia = $carabrevia;
				$gpmatricula->ciclo = $ciclo;
				$gpmatricula->carne = $carnet;
				$gpmatricula->turno = $turno;
				$gpmatricula->periodo = $periodo;
				$gpmatricula->foto = $foto;
				$gpmatricula->idpersona = $codpersona;
				$gpmatricula->femision = $fechaemision;

				$gpmatriculas[]=$gpmatricula;
			}

			$arrayitems['inscritos'] = $gpmatriculas; 
		} else {
			$fmcbsede=$this->input->post('fmt-cbsede');
            $fmcbperiodo=$this->input->post('fmt-cbperiodo');
            $fmcbcarrera=$this->input->post('fmt-cbcarrera');
            $fmcbciclo=$this->input->post('fmt-cbciclo');
            $fmcbturno=$this->input->post('fmt-cbturno');
            $fmcbseccion=$this->input->post('fmt-cbseccion');
            $fmcbplan=$this->input->post('fmt-cbplan');
            $fmalumno=$this->input->post('fmt-alumno');
            $fmtcbestado=$this->input->post('fmt-cbestado');   
            $fmtcbbeneficio=$this->input->post('fmt-cbbeneficio');

            $fmalumno=str_replace(" ","%",$fmalumno);
            $matriculas=$this->mmatricula->m_filtrar(array($fmcbsede,$fmcbperiodo,$fmcbcarrera,$fmcbplan,$fmcbciclo,$fmcbturno,$fmcbseccion,$fmtcbestado,$fmtcbbeneficio,'%'.$fmalumno.'%'));
            $arrayitems['inscritos'] = $matriculas;
		}

		$dominio=str_replace(".", "_",getDominio());

        // $arrayitems['inscritos'] = $vmatriculas;
		$html1=$this->load->view("admision/reportes/rp_carne_matriculados_$dominio", $arrayitems, true);
		$pdfFilePath = "upload/carne/CARNE_INSCRITOS_".$_SESSION['userActivo']->sede.date("d") . date("m") . date("Y") . date("H") . date("i").".pdf";

        //$this->load->library('M_pdf');
        $formatoimp="A4-P";
        $vtitle = "CARNÉ INSCRITOS - ".$_SESSION['userActivo']->sede;
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>$formatoimp]); 
        $mpdf->SetTitle($vtitle);
        $mpdf->WriteHTML($html1);
        $mpdf->Output($pdfFilePath, "F");
        $dataex['title'] = $pdfFilePath;
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($dataex));

        
	}



}