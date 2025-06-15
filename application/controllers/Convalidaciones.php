<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convalidaciones extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('madmision');
		$this->load->model('mlenguas');
		$this->load->model('mauditoria');
		$this->load->model('mconvalidaciones');
		$this->load->model('mmatricula_independiente');
		$this->load->model('mperiodo');
		$this->load->model('mtemporal');
		$this->load->model('mnotas_descarga');
		$this->load->model('mdocentes');
		$this->load->model('mcarrera');
	}

	public function vw_principal()
	{
		$ahead= array('page_title' =>'Convalidaciones | IESTWEB'  );
		$asidebar= array('menu_padre' =>'convalidaciones','menu_hijo' =>'');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$vsidebar=(null !== $this->input->get('sb'))? "sidebar_".$this->input->get('sb') : "sidebar";
        $this->load->view($vsidebar,$asidebar);
		$this->load->model('mubigeo');
		$a_ins['periodos']=$this->mperiodo->m_get_periodos();
		$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
		$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
		$a_ins['secciones']=$this->mtemporal->m_get_secciones();
        $a_ins['docentes'] = $this->mdocentes->m_get_docentes();
        $a_ins['carreras']=$this->mcarrera->m_get_carreras_activas_por_sede($_SESSION['userActivo']->idsede);
		$this->load->view('convalidaciones/vw_principal', $a_ins);
		$this->load->view('footer');
	}

	public function fn_get_datos_itinerarios()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('max_length', '* {field} debe tener al menos {param} caracteres.');
	
		$dataex['status'] =FALSE;
		$urlRef=base_url();
		$dataex['msg']    = '¿Que Intentas?.';
		$rscuentas="";
		$dataex['conteo'] =0;
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			// $this->form_validation->set_rules('fic_txtcarne','Carne','trim|required');
			$this->form_validation->set_rules('fic_txtplan','Plan','trim|required');
			$this->form_validation->set_rules('fic_txtcarrera','carrera','trim|required');
			$this->form_validation->set_rules('fic_txtinscrito','codigo','trim|required');

			if ($this->form_validation->run() == FALSE)
			{
				$dataex['msg']="Existen errores en los campos";
				$errors = array();
		        foreach ($this->input->post() as $key => $value){
		            $errors[$key] = form_error($key);
		        }
		        $dataex['errors'] = array_filter($errors);
			}
			else
			{
				$carne = $this->input->post('fic_txtcarne');
				$idplan = $this->input->post('fic_txtplan');
				$carrera = $this->input->post('fic_txtcarrera');
				$codinscripcion = $this->input->post('fic_txtinscrito');
				
				$dominio=str_replace(".", "_",getDominio());
				$matriculas = $this->mconvalidaciones->m_get_itinerarios(array($idplan, $carrera));
				$nvecesund=$this->mmatricula_independiente->m_get_cursos_nveces_xmatricula(array($codinscripcion));
            	$cursos = $this->mconvalidaciones->m_get_cursos_matricula_xinscripcion(array($codinscripcion));

            	foreach ($matriculas as $key => $matricula) {
            		$matricula->nroveces = 0;
            		$matricula->codigound64 = base64url_encode($matricula->id);
            		$matricula->codigo64 = "0";
                    $matricula->codmiembro64 = "0";
                    $matricula->nota = 0;
                    $matricula->recuperacion = "";
                    $matricula->final = 0;
                    $matricula->nperiodo = "";
                    $matricula->nciclo = "";
                    $matricula->nestado = "PNT";
                    $matricula->ntipo = "";
                    $matricula->metodo = "";
                    $matricula->nresolucion = "";
                    $matricula->nfeconvalida = "";
        			foreach ($cursos as $key => $fila) {
        				if ($matricula->id == $fila->codcurso) {
		                    $matricula->codigound64 = base64url_encode($fila->codcurso);
		                    $matricula->codigo64 = base64url_encode($fila->id);
		                    $matricula->codmiembro64 = base64url_encode($fila->codmiembro);
		                    $matricula->nota = (is_null($fila->nota ))? "":floatval($fila->nota);
		                    $matricula->recuperacion = (is_null($fila->recuperacion ))? "":floatval($fila->recuperacion);
		                    $funcionhelp="getNotas_alumnoboleta_$dominio";
		                    $matricula->final = $funcionhelp($fila->metodo,array('promedio' => $fila->nota, 'recupera'=>$fila->recuperacion));

		                    $matricula->nperiodo = $fila->periodo;
                    		$matricula->nciclo = $fila->ciclo;
                    		$matricula->nestado = $fila->estado;
                    		$matricula->ntipo = $fila->tipo;
                    		$matricula->metodo = $fila->metodo;
                    		if ($fila->resolucion != null || $fila->resolucion != "") {
                    			$matricula->nresolucion = $fila->resolucion;
                    		}
                    		
                    		$matricula->nfeconvalida = $fila->feconvalida;

		                    foreach ($nvecesund as $key => $item) {
		                        if ($item->idunidad == $fila->codcurso) {
		                            $matricula->nroveces = $item->nrounidad;
		                        }
		                    }
		                }
	                }
            		
            	}

				$rscuentas = $matriculas;
				$dataex['status'] =TRUE;
				$dataex['vpermiso137'] = getPermitido("137");//actualizar nota final
				$dataex['vpermiso204'] = getPermitido("204");//actualizar unidad boleta
				$dataex['vpermiso206'] = getPermitido("206");//actualizar origen boleta
			}
		}
		$dataex['vdata'] =$rscuentas;
		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function fn_insert_update_notas_final()
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
            
            if ((getPermitido("137")=='SI') || (getPermitido("138")=='SI'))
            {
                $this->form_validation->set_rules('filas', 'datos', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                    $dataex['msg']="Existen errores en los campos";
                    $errors = array();
                    foreach ($this->input->post() as $key => $value){
                        $errors[$key] = form_error($key);
                    }
                    $dataex['errors'] = array_filter($errors);
                }
                else
                {
                    $dataex['status'] = FALSE;
                    date_default_timezone_set ('America/Lima');
                    $data          = json_decode($_POST['filas']);

                    $tipo = "PLATAFORMA";
                    $fecha = date('Y-m-d H:i:s');
                    $resolucion = null;
                    $observacion = null;
                    $convalfecha = null;
                    
                    $usuario = $_SESSION['userActivo']->idusuario;
                    $sede = $_SESSION['userActivo']->idsede;

                    $datos['idorg'][]=array();
                    $datos['idnew'][]=array();
                    $datos['estado'][]=array();
                    $datos['notaf'][]=array();
                    $datos['notarec'][]=array();
                    $todos = true;
                    $dominio=str_replace(".", "_",getDominio());
                    foreach ($data as $value) {
                         //var myvals = [codmat,unidad,periodo,semestre, estado, notfin, origen, resolucion,feconvalida,metodo,recupera];
                        $unidad = base64url_decode($value[1]);
                        $notafinal = $value[5];
                        $notafinal=($notafinal=="") ? NULL : $notafinal;
                        $notarecupera = $value[10];
                        $notarecupera=($notarecupera=="") ? NULL : $notarecupera;
                        $periodo = $value[2];
                        $semestre = $value[3];
                        $origen = $value[6];
                        $resolucion = $value[7];
                        $resolucion=($resolucion=="") ? NULL : $resolucion;
                        $feconvalida = $value[8];
                        $feconvalida=($feconvalida=="") ? NULL : $feconvalida;
                        $funcionhelp="getNotas_alumnoboleta_$dominio";
                        $final = $funcionhelp($value[9],array('promedio' => $notafinal, 'recupera'=>$notarecupera));

                        $estado = $value[4];
                        
                        if ($estado!="-"){

                        }
                        else{
                            if (is_null($notafinal)){
                               $estado="MTR";
                            }
                            else{
                                if ($final<12.5){
                                    $estado="DES";
                                }
                                else{
                                    $estado="APR";   
                                }
                            }
                            
                        }

                        $datos['idorg']=$value[4];
                        if (intval($value[0]) < 0) {

                        }
                        else {
                            $codmatnota = base64url_decode($value[0]);
                            $dataex['vestado']=$estado;
                            if ($estado=="-"){
                                // $rpta=$this->mnotas_descarga->m_update_nota_final_recuperacion_sin_estado(array($codmatnota,$miembro,$notafinal, $notarecupera));
                            }
                            else{
                                $rpta=$this->mnotas_descarga->m_update_nota_final_itinerario(array($codmatnota,$origen,$periodo,$semestre,$unidad,$resolucion,$feconvalida,$final,$estado));
                            }


                            $fictxtaccion = "EDITAR";
                            $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está actualizando una matricula en la tabla TB_MATRICULA_CURSOS_NOTA_FINAL COD.".$codmatnota ;
                            $auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                        }
                        $datos['idnew']=base64url_encode($codmatnota);
                        $datos['notaf'] = $notafinal;
                        $datos['notarec'] = $notarecupera;
                        $datos['estado']=false;
                        if ($rpta->salida == 1){
                            $datos['estado']=true;
                            
                        } else {
                            $todos = false;
                        }
                        $datos_fnal[]=$datos;
                    }

                    $dataex['vdata']=$datos_fnal;
                    $dataex['repsuesta'] = $rpta;
                    $dataex['status'] =TRUE;
                }
            } else {
                $dataex['status'] =FALSE;
                $dataex['msg'] ="No tienes autorización para esta acción";
            }
        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }	



}