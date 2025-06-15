<?php
defined('BASEPATH') OR exit('No direct script access allowed');	
require 'vendor/autoload.php';
class Horarios extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mcargasubseccion');
		$this->load->model('mhorarios');
		$this->load->model('mauditoria');
	}

	public function fn_get_carga_subseccion_horarios()
	{
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$fcarga = base64url_decode($this->input->post('fmt-carga'));
			$fsubseccion = base64url_decode($this->input->post('fmt-subseccion'));
			$fturno = $this->input->post('fmt-turno');
			
			$vhorarios = $this->mhorarios->m_get_horarios_carga_subseccion(array($fcarga,$fsubseccion));
			
			$vaulas = $this->mhorarios->m_aulas();
        	$horas = $this->mhorarios->m_horas_activas();
        	$horas_si=array();
			foreach ($horas as $khora => $hora) {
				if($fturno==$hora->idturno) $horas_si[]=$hora;
			}

			// AULAS
			$rsaulas = "";
			foreach ($vaulas as $aula) {
				$rsaulas = $rsaulas."<option data-piso='$aula->piso' data-aula='Ps$aula->piso - $aula->nombre' value='$aula->id'>Ps$aula->piso - $aula->nombre</option>";
			}

			// HINICIA
			$rsinicia = "";
			foreach ($horas_si as $ini) {
				$rsinicia = $rsinicia."<option value='$ini->inicia'>$ini->inicia</option>";
			}

			// HFIN
			$rsfin = "";
			foreach ($horas_si as $fin) {
				$rsfin = $rsfin."<option value='$fin->culmina'>$fin->culmina</option>";
			}
			
			foreach ($vhorarios as $key => $value) {
				$vhorarios[$key]->codhorario64 = base64url_encode($vhorarios[$key]->id);
				$vhorarios[$key]->hinicia = date('h:i a',strtotime($vhorarios[$key]->inicia));
				$vhorarios[$key]->hculmina = date('h:i a',strtotime($vhorarios[$key]->finaliza));
				
			}
			$dataex['status'] =TRUE;
			$dataex['vdata'] =$vhorarios;
			$dataex['cbaulas'] = $rsaulas;
			$dataex['cbhorasini'] = $rsinicia;
			$dataex['cbhorasfin'] = $rsfin;
			$dataex['vpermiso210'] = getPermitido("210");
			$dataex['vpermiso211'] = getPermitido("211");
		

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_get_carga_horarios_codigo()
	{
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$fichcodigo = base64url_decode($this->input->post('fmt-codigo'));
			
			$vhorarios = $this->mhorarios->m_get_horarios_codigo(array($fichcodigo));
			
			$vhorarios->codhorario64 = base64url_encode($vhorarios->id);
			$vhorarios->codcarga64 = base64url_encode($vhorarios->carga);
			$vhorarios->subseccion64 = base64url_encode($vhorarios->subseccion);
			
			$dataex['status'] =TRUE;
			$dataex['vdata'] =$vhorarios;
		

		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_insert_update()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		
	
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			
			$this->form_validation->set_rules('vw_horario_txtcodcarga','Cod. Carga','trim|required');
			$this->form_validation->set_rules('vw_horario_txtcoddivision','División','trim|required');

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				// $dataex['msg']=validation_errors();
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$dataex['status'] =FALSE;
				
				$ficarga = base64url_decode($this->input->post('vw_horario_txtcodcarga'));
				$fidivision = base64url_decode($this->input->post('vw_horario_txtcoddivision'));

				if (isset($_POST['items'])) {
					$items = json_decode($_POST['items'],true);
					if (count($items) > 0) {

						foreach ($items as $key => $item) {
							$fictxtcodigo = $item['fictxtcodigoh'];
							$ficdia = $item['fictxtdia'];
							$ficaula = $item['fictxtaula'];
							$ficpiso = $item['fictxtpiso'];
							$ficinicia = $item['fictxtinicia'];
							$ficculmina = $item['fictxtculmina'];
							$nhoras = $this->restarHoras($ficculmina, $ficinicia);

							if ($fictxtcodigo == '0') {
								$rpta = $this->mhorarios->m_insert_Horario(array($ficarga, $fidivision, $ficinicia, $ficculmina, $ficaula, $ficpiso, $nhoras, $ficdia));
							} else {
								$rpta = $this->mhorarios->m_update_Horario(array(base64url_decode($fictxtcodigo),$ficarga, $fidivision, $ficinicia, $ficculmina, $ficaula, $ficpiso, $nhoras, $ficdia));
							}

							
						}

						if ($rpta->salida == '1') {
							$dataex['status'] =TRUE;
							$dataex['msg'] ="Datos guardados correctamente";
							$dataex['newcod'] =$rpta;
						}
						
					}
				}
				
			}

		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function carga_horario_pdf($codigo, $docente, $periodo)
	{
		$codocente = base64url_decode($codigo);
        $nombres = base64url_decode($docente);
        $periodo = base64url_decode($periodo);
        $horas     = $this->mhorarios->m_horas_activas();
        $horarios= $this->mhorarios->m_cursos_horarios(array($codocente, $periodo));
        $resumen= $this->mhorarios->m_cursos_resumen(array($codocente, $periodo));
        $arrayDias = array('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO');

        $horario=array();
        foreach ($arrayDias as $dia) {
            $horario[$dia]=array();
            foreach ($horas as $hora) {
                $horario[$dia][$hora->inicia]["value"]="";
                $horario[$dia][$hora->inicia]["carrera"]="";
                foreach ($horarios as $curso) {
                    if ($curso->hdia==$dia && $hora->inicia==$curso->hini){
                        $horario[$dia][$hora->inicia]["value"]=$curso->nomcurso."<br>".$curso->abrev." ".$curso->ciclo." ".$curso->seccion." - ".$curso->iddivision;
                        $horario[$dia][$hora->inicia]["carrera"]=$curso->nomcarrera;
                        if (($curso->hini==$hora->inicia) &&($curso->hfin==$hora->culmina)){

                        }
                        else{
                            $curso->hini=$hora->culmina;    
                        }
                        
                    }
                }
            }
        }
        $arraydoc['horas'] =$horas;
        $arraydoc['horacurso']  =$horarios;
        $arraydoc['resumenh']  =$resumen;
        $arraydoc['dias']  =$arrayDias;
        $arraydoc['horario'] =$horario;
        // echo '<pre>'; print_r($horario); echo '</pre>';
       
        $arraydoc['titulodocente'] =$nombres;

        $htmlnt      = $this->load->view('cargaacademica/docente/vw-horario-pdf', $arraydoc,true);
        $pdfFilePath = "HORARIO - $nombres.pdf";
        //$this->load->library('M_pdf');
        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
        $mpdf->SetWatermarkImage(base_url().'resources/img/login_h80.'.getDominio().'.png',0.2,'F','P');
        $mpdf->showWatermarkImage = true;
        $mpdf->SetTitle("HORARIO - $nombres.pdf");  
        $mpdf->SetHTMLHeader('
        <table width="100%">
            <tr>
                <td width="75%"><span style="font-size:10px;font-weight: normal"></span></td>
                <td width="25%" style="text-align: right;font-size:10px;font-weight: normal">{DATE j/m/Y}</td>
            </tr>
        </table>');
        $mpdf->SetHTMLFooter('
        <table width="100%">
            <<tr>
                <<td width="67%" align="center"></td>
                <<td width="33%" style="text-align: right;font-size:10px;">{PAGENO}/{nbpg}</td>
            <</tr>
        </table>');
        $mpdf->WriteHTML($htmlnt);
        //$mpdf->Output();//$pdfFilePath, "D");
        $mpdf->Output($pdfFilePath, "I");
	}

	public function fneliminar_item_horario()
	{
		$dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('fictxtcodigo', 'codigo item horario', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este item";
                $codigoitem    = base64url_decode($this->input->post('fictxtcodigo'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un item en la tabla TB_HORARIOS COD.".$codigoitem;
				
                $rpta = $this->mhorarios->m_elimina_item_horario(array($codigoitem));
                if ($rpta->salida == '1') {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Item eliminado correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
	}

	public function vw_horario_estudiante_pdf($carne, $periodo, $estudiante)
	{
		$carne = base64url_decode($carne);
		$periodo = base64url_decode($periodo);
		$estudiante = base64url_decode($estudiante);
		// $ciclo = base64url_decode($ciclo);
		// $vuserdt = $_SESSION['userActivo'];
  		// $nombres = $vuserdt->paterno." ".$vuserdt->materno." ". $vuserdt->nombres;
        $horas     = $this->mhorarios->m_horas_activas();
        $horarios= $this->mhorarios->m_cursos_horario_estudiante(array($carne, $periodo));
        $arrayDias = array('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO');

        $horario=array();
        $resumen=array();
        foreach ($arrayDias as $dia) {
            $horario[$dia]=array();
            foreach ($horas as $hora) {
                $horario[$dia][$hora->inicia]["value"]="";
                $horario[$dia][$hora->inicia]["carrera"]="";
                foreach ($horarios as $curso) {
                    if ($curso->hdia==$dia && $hora->inicia==$curso->hini){
                    	$vnombres = explode(" ",$curso->dnombres);
                    	$vapellidos = explode(" ",$curso->dpaterno." ".$curso->dmaterno);
                        $horario[$dia][$hora->inicia]["value"]=$curso->nomcurso."<br>".$vnombres[0]." ".$vapellidos[0];
                        // $horario[$dia][$hora->inicia]["carrera"]=$curso->nomcarrera;
                        if (($curso->hini==$hora->inicia) &&($curso->hfin==$hora->culmina)){

                        }
                        else{
                            $curso->hini=$hora->culmina;    
                        }
                        
                    }
                }
            }
        }
        $arraydoc['horas'] =$horas;
        $arraydoc['horacurso']  =$horarios;
        $arraydoc['resumenh']  =$resumen;
        $arraydoc['dias']  =$arrayDias;
        $arraydoc['horario'] =$horario;
       
        $arraydoc['titulodocente'] = $estudiante;

        $htmlnt      = $this->load->view('cargaacademica/docente/vw-horario-pdf', $arraydoc,true);
        $pdfFilePath = "HORARIO - $estudiante.pdf";
        //$this->load->library('M_pdf');
        $mpdf = new \Mpdf\Mpdf(array('c', 'A4-P')); 
        $mpdf->SetWatermarkImage(base_url().'resources/img/login_h80.'.getDominio().'.png',0.2,'F','P');
        $mpdf->showWatermarkImage = true;
        $mpdf->SetTitle("HORARIO - $estudiante.pdf");  
        $mpdf->SetHTMLHeader('
        <table width="100%">
            <tr>
                <td width="75%"><span style="font-size:10px;font-weight: normal"></span></td>
                <td width="25%" style="text-align: right;font-size:10px;font-weight: normal">{DATE j/m/Y}</td>
            </tr>
        </table>');
        $mpdf->SetHTMLFooter('
        <table width="100%">
            <<tr>
                <<td width="67%" align="center"></td>
                <<td width="33%" style="text-align: right;font-size:10px;">{PAGENO}/{nbpg}</td>
            <</tr>
        </table>');
        $mpdf->WriteHTML($htmlnt);
        //$mpdf->Output();//$pdfFilePath, "D");
        $mpdf->Output($pdfFilePath, "I");
	}

	function sumarHoras($hora1, $hora2)
	{
	    list($h, $m, $s) = explode(':', $hora2); //Separo los elementos de la segunda hora
	    $a = new DateTime($hora1); //Creo un DateTime
	    $b = new DateInterval(sprintf('PT%sH%sM%sS', $h, $m, $s)); //Creo un DateInterval
	    $a->add($b); //SUMO las horas
	    return $a->format('H:i:s'); //Retorno la Suma
	}

	function restarHoras($hora1, $hora2)
    {
        list($h, $m, $s) = explode(':', $hora2); //Separo los elementos de la segunda hora
        $a = new DateTime($hora1); //Creo un DateTime
        $b = new DateInterval(sprintf('PT%sH%sM%sS', $h, $m, $s)); //Creo un DateInterval
        $a->sub($b); //RESTO las horas
        return $a->format('H:i:s'); //Retorno la Resta
    }


}
