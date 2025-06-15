<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Miembros extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('mmiembros');
		$this->load->model('mmiembros_migrado');
		$this->load->model('mmatricula');
	}
	

	public function vw_enrolar($codcarga,$division){
		$ahead= array('page_title' =>'Enrolar estudiantes | Plataforma Virtual'  );
		$asidebar= array('menu_padre' =>'academico','menu_hijo' =>'cargaacademica','menu_nieto' =>'enrolar');
		$this->load->view('head',$ahead);
		$this->load->view('nav');
		$this->load->view('sidebar',$asidebar);
		$this->load->model('mcargasubseccion');	
		$division=base64url_decode($division);
		$codcarga=base64url_decode($codcarga);
		$vcarga=$this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
		if ($vcarga){
			
			$this->load->model('mmatricula');	
			$vmatriculas=$this->mmatricula->m_matriculas_x_grupo_enrolar(array($_SESSION['userActivo']->idsede,$vcarga->codperiodo,$vcarga->codcarrera,$vcarga->codciclo,$vcarga->codturno,$vcarga->codseccion));
			$vmiembros=$this->mmiembros->m_get_miembros_por_carga(array($vcarga->codcarga));

			$this->load->model('mperiodo');
            $a_ins['periodos']=$this->mperiodo->m_get_periodos();
			$this->load->model('mcarrera');
			$a_ins['carreras']=$this->mcarrera->m_lts_carreras_activas();
			
			$this->load->model('mtemporal');
			$a_ins['ciclos']=$this->mtemporal->m_get_ciclos();
			//$this->load->model('mcarrera');
			$a_ins['turnos']=$this->mtemporal->m_get_turnos_activos();
			//$this->load->model('mcarrera');
			$a_ins['secciones']=$this->mtemporal->m_get_secciones();
			$this->load->model('msede');
			$a_ins['sedes'] = $this->msede->m_get_sedes_activos();

			
			/*foreach ($vmatriculas as $kmt => $mat) {
				$mat->codmiembro='0';
				$mat->division='0';
				$mat->eliminado='SI';
				foreach ($vmiembros as $kmb => $mb) {
					if ($mb->codmatricula==$mat->codmatricula){
						$mat->codmiembro=$mb->idmiembro;
						$mat->division=$mb->division;
						$mat->eliminado=$mb->eliminado;
						unset($vmiembros[$kmb]);
					}
				}
			}*/
			foreach ($vmatriculas as $kmt => $mat) {

				$mat_miebro=false;
				foreach ($vmiembros as $kmb => $mb) {
					if ($mb->codmatricula==$mat->codmatricula){
						$mat_miebro=true;
						
					
					}
				}
				if ($mat_miebro==false){
					$mb=new stdClass();
					$mb->codmatricula=$mat->codmatricula;
			  		$mb->codinscripcion=$mat->codinscripcion;
			  		$mb->carnet=$mat->carnet;
			  		$mb->idmiembro='0';
			  		$mb->paterno=$mat->paterno;
			  		$mb->materno=$mat->materno;
			  		$mb->nombres=$mat->nombres;
			  		$mb->dni=$mat->dni;
			  		$mb->sexo=$mat->sexo;
			  		$mb->fecnac=$mat->fecnac;
			  		$mb->codcarga=$codcarga;
			  		$mb->division=$division;
			  		$mb->eliminado='SI';
			  		$vmiembros[]=$mb;
				}
			}
			$a_ins['carga']=$vcarga;
			$a_ins['miembros']=$vmiembros;
			//var_dump($vmiembros);
			$this->load->view('cargaacademica/miembros/vw-enrolar-miembros',$a_ins);
		}
		else{
			$this->load->view('errors/error-404');
		}
		$this->load->view('footer');
	}

	public function fn_insert($comprueba='NO')
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('alpha', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('exact_length', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fm-codcarga','Carga','trim|required');
			$this->form_validation->set_rules('fm-codmatricula','Alumno','trim|required');
			$this->form_validation->set_rules('fm-division','División','trim|required');
			$this->form_validation->set_rules('fm-idmiembro','Miembro','trim|required');

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
				$dataex['msg'] ="Error";
				$dataex['status'] =FALSE;
				$fmcodcarga=base64url_decode($this->input->post('fm-codcarga'));
				$fmidmiembro=base64url_decode($this->input->post('fm-idmiembro'));
				$fmcodmatricula=base64url_decode($this->input->post('fm-codmatricula'));


				$fmcarne=$this->input->post('fm-carne');
				$fmcodcurso=base64url_decode($this->input->post('fm-codcurso'));

				$fmdivision=$this->input->post('fm-division');

				$usuario = $_SESSION['userActivo'];
                //$sede = $_SESSION['userActivo']->idsede;


				$this->load->model('mcargasubseccion');	
				$this->load->model('mmatricula_independiente');	
				$curso= $this->mcargasubseccion->m_get_carga_subseccion(array($fmcodcarga,$fmdivision));
				if ($comprueba=='SI'){
					$fmidmiembro=$this->mmiembros->m_comprobar_miembro(array($fmcodcarga,$fmdivision,$fmcodmatricula));
				}
				if ($fmidmiembro=='0'){
					$newcod=$this->mmiembros->m_insert(array($fmcodcarga,$fmdivision,$fmcodmatricula,$fmcodcurso,$fmcarne));
					if ($newcod>0){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="enrolado";
						$dataex['newcod'] =base64url_encode($newcod);					
						$rpta=$this->mmatricula_independiente->m_insert_mat_culminar_curso_sr(array($fmcodmatricula,'PLATAFORMA',$fmcodcarga,$fmdivision, $curso->coddocente, $curso->codunidad, 0,'', $usuario->idusuario,$curso->codsede,'SI',"MTR","NO",$newcod)); 
					}

				}
				else{
					$newcod=$this->mmiembros->m_update(array($fmidmiembro,$fmdivision,'NO'));
					if ($newcod==1){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="enrolado";
						$newcod=base64url_encode($fmidmiembro);
						$miembro_mat=$this->mmatricula_independiente->m_get_mat_final_x_miembro(array($newcod));
						if (isset($miembro_mat->codmatfinal)){

						}
						else{
							$rpta=$this->mmatricula_independiente->m_insert_mat_culminar_curso_sr(array($fmcodmatricula,'PLATAFORMA',$fmcodcarga,$fmdivision, $curso->coddocente, $curso->codunidad, 0,'', $usuario->idusuario,$curso->codsede,'SI',"MTR","NO",$newcod)); 
						}
					}
				}
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_update_carga_division()
	{ 
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('alpha', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('exact_length', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fm-codcarga','Carga','trim|required');
			$this->form_validation->set_rules('fm-division','División','trim|required');
			$this->form_validation->set_rules('fm-idmiembro','Miembro','trim|required');

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
				$dataex['msg'] ="Error";
				$dataex['status'] =FALSE;
				$fmcodcarga=$this->input->post('fm-codcarga');
				$fmidmiembro=base64url_decode($this->input->post('fm-idmiembro'));
				$fmdivision=$this->input->post('fm-division');

				
				
				$newcod=$this->mmiembros->m_update_carga_subseccion(array($fmidmiembro,$fmcodcarga,$fmdivision));
				if ($newcod==1){
					$dataex['status'] =TRUE;
					$dataex['msg'] ="Actualizado";
				}
				
				
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_retirar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('alpha', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('exact_length', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fm-idmiembro','Miembro','trim|required');

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
				$dataex['msg'] ="Error, no se pudo retirar";
				$dataex['status'] =FALSE;
				$fmidmiembro=base64url_decode($this->input->post('fm-idmiembro'));

				
				$newcod=$this->mmiembros->m_retirar(array($fmidmiembro));
				
				if ($newcod>0){
					$dataex['msg'] ="retirado";
					$dataex['status'] =TRUE;
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}
	public function fn_ocultar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('alpha', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('exact_length', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fm-idmiembro','Miembro','trim|required');

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
				$dataex['msg'] ="Error, no se pudo ocultar";
				$dataex['status'] =FALSE;
				$fmidmiembro=base64url_decode($this->input->post('fm-idmiembro'));
				$fmocultar=$this->input->post('fm-ocultar');

				
				$newcod=$this->mmiembros->m_ocultar(array($fmocultar,$fmidmiembro));
				
				if ($newcod>0){
					$dataex['msg'] ="Proceso realizado correctamente";
					$dataex['status'] =TRUE;
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

		public function fn_eliminar()
	{
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('alpha', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
		$this->form_validation->set_message('exact_length', '* {field} requiere un valor de la lista.');
		
		$dataex['status'] =FALSE;
		$dataex['msg']    = '¿Que Intentas?.';
		if ($this->input->is_ajax_request())
		{
			$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
			$this->form_validation->set_rules('fm-idmiembro','Miembro','trim|required');

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
				$dataex['msg'] ="Error, NO se pudo Eliminar";
				$dataex['status'] =FALSE;
				$fmidmiembro=base64url_decode($this->input->post('fm-idmiembro'));

				
				$newcod=$this->mmiembros->m_eliminar(array($fmidmiembro));
				
				if ($newcod==1){
					$dataex['msg'] ="Eliminado correctamente";
					$dataex['status'] =TRUE;
				}
			}
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}


	public function vw_lista_posibles_miembros()
    {
        $dataex['status'] = false;
        $dataex['msg']    = 'No se ha podido establecer el origen de esta solicitud.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('carga', 'Carga académica', 'trim|required');
            $this->form_validation->set_rules('periodo', 'Periodo', 'trim|required');
            $this->form_validation->set_rules('alumno', 'Alumno', 'trim|required|min_length[4]');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error";
                $carga=base64url_decode($this->input->post('carga'));
                //$carga          = $this->input->post('carga');
                $periodo          = $this->input->post('periodo');
                $alumno          = $this->input->post('alumno');
                $division          = $this->input->post('division');
                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

                $arraymb['pmiembros'] = $this->mmiembros->m_posibles_miembros(array($periodo,$alumno."%",$carga,$division));
                $dataex['vdata']  = $this->load->view('docentes/vw_curso_miembros-tabla', $arraymb, true);
                $dataex['status'] = true;
                $dataex['msg']    = '';
            }
           
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function vw_lista_posibles_miembros_grupo()
    {
        $dataex['status'] = false;
        $dataex['msg']    = 'No se ha podido establecer el origen de esta solicitud.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('carga', 'Carga académica', 'trim|required');
            $this->form_validation->set_rules('periodo', 'Periodo', 'trim|required');
            //$this->form_validation->set_rules('alumno', 'Alumno', 'trim|required|min_length[4]');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error";
                $carga=base64url_decode($this->input->post('carga'));
                //$carga          = $this->input->post('carga');
                $periodo          = $this->input->post('periodo');
                $alumno          = $this->input->post('alumno');
                $division          = $this->input->post('division');

				$sede=$this->input->post('sede');
				$carrera=$this->input->post('carrera');
				$plan=$this->input->post('plan');
				$ciclo=$this->input->post('ciclo');
				$turno=$this->input->post('turno');
				$seccion=$this->input->post('seccion');

                $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

              


                $arraymb['pmiembros'] = $this->mmiembros->m_posibles_miembros_xgrupo(array($sede,$periodo,$carrera,$plan,$ciclo,$turno,$seccion,$alumno."%",$carga,$division));
                $dataex['vdata']  = $this->load->view('docentes/vw_curso_miembros-tabla', $arraymb, true);
                $dataex['status'] = true;
                $dataex['msg']    = '';
            }
           
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

	public function fn_get_miembros_x_carga_division()
    {
        $dataex['status'] = false;
        $dataex['msg']    = 'No se ha podido establecer el origen de esta solicitud.';
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_message('required', '%s Requerido');
            $this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
            $dataex['status'] = false;
            $urlRef           = base_url();
            $dataex['msg']    = 'Intente nuevamente o comuniquese con un administrador.';

            $this->form_validation->set_rules('codcarga', 'Carga académica', 'trim|required');
            $this->form_validation->set_rules('division', 'Periodo', 'trim|required');
            //$this->form_validation->set_rules('alumno', 'Alumno', 'trim|required|min_length[4]');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error";
                $carga=base64url_decode($this->input->post('codcarga'));
                $division= base64url_decode($this->input->post('division'));


                unset($dataex['msg']);

                $miembros= $this->mmiembros->m_get_todos_miembros_x_carga_division(array($carga,$division));
                foreach ($miembros as $key => $value) {
                	$miembros[$key]->idmiembro64=base64url_encode($miembros[$key]->idmiembro);
                }
                $dataex['vmiembros']=$miembros;
                $dataex['status'] = true;

            }
           
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }

    public function fn_get_miembrosPorCargaDivision_notasFinalesMigradas()
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
            $this->form_validation->set_rules('codcarga','Carga','trim|required');
            $this->form_validation->set_rules('coddivision','division','trim|required');

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
                $codcarga = base64url_decode($this->input->post('codcarga'));
                $coddivision = base64url_decode($this->input->post('coddivision'));
                //$idsede = $_SESSION['userActivo']->idsede;

			  	$arrayCondiciones = array('codcarga' =>$codcarga , 'codsubseccion' => $coddivision,'culminado' => "SI" ,'eliminado' => "NO" );
                $valumnos = $this->mmiembros->m_getMiembros_notasFinalesMigradas($arrayCondiciones);
                $in = 0;
                for ($i=0; $i < count($valumnos) ; $i++) { 
                    
                    if ($valumnos[$i]->codnotamigrada==""){
                        $in = $in - 1;
                         $valumnos[$i]->codnotamigrada64 = "$in";
                    }
                    else{
                        $valumnos[$i]->codnotamigrada64 = base64url_encode($valumnos[$i]->codnotamigrada);;
                    }
                    $valumnos[$i]->codmatricula64 = base64url_encode($valumnos[$i]->codmatricula);
                    $valumnos[$i]->codcarga64 = base64url_encode($valumnos[$i]->codcarga);
                    $valumnos[$i]->codsubseccion64 = base64url_encode($valumnos[$i]->codsubseccion);
                    // $valumnos[$i]->idcarrera_64 = base64url_encode($valumnos[$i]->idcarrera);
                    $valumnos[$i]->codmiembro64 = base64url_encode($valumnos[$i]->codmiembro);
                    // $valumnos[$i]->idciclo_64 = base64url_encode($valumnos[$i]->idciclo);
                    // $valumnos[$i]->idperiodo_64 = base64url_encode($valumnos[$i]->idperiodo);
                    // $valumnos[$i]->idplan_64 = base64url_encode($valumnos[$i]->idplan);
                    // $valumnos[$i]->idseccion_64 = base64url_encode($valumnos[$i]->idseccion);
                    // $valumnos[$i]->idturno_64 = base64url_encode($valumnos[$i]->idturno);
                    //$valumnos[$i]->idunidad_64 = base64url_encode($valumnos[$i]->idunidad);
                }
                // $cursos = $this->load->view('grupos/descarganotas/vw_grupo_result',$vcursos, true);
                $dataex['status'] =TRUE;
                $dataex['vdata'] = $valumnos;
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }


    //PASARA A MIENBRO_MIGRADO
    public function fn_get_miembrosPorMatricula_notasFinalesMigradas()
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
            $this->form_validation->set_rules('codmatricula64','Cod. Matríula','trim|required');

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
                $codmatricula = base64url_decode($this->input->post('codmatricula64'));
                
			  	$arrayCondiciones = array('codmatricula' =>$codmatricula );

				$matriculas=$this->mmatricula->m_getMatriculas($arrayCondiciones);
                $vCursosNotas = $this->mmiembros_migrado->m_getMiembros_notasFinalesMigradas($arrayCondiciones);
                $dataex['msg']="No se encontró matrícula";
                $dataex['vmatricula'] = array();
                if (count($matriculas)==1){

                	$dataex['vmatricula'] =$matriculas[0];
                	$dominio=str_replace(".", "_",getDominio());
		            $nvecesund=$this->mmiembros_migrado->m_getTotalRepiteCursos(array($matriculas[0]->codinscripcion));
		            $dataex['status'] = true;
		            $dataex['vpermiso178'] = getPermitido("178");//cambiar estado matricula
		            $dataex['vpermiso137'] = getPermitido("137");//actualizar nota final
		            $dataex['vpermiso138'] = getPermitido("138");//actualizar nota recuperacion
		            $dataex['vpermiso204'] = getPermitido("204");//actualizar unidad boleta
		            $dataex['vpermiso205'] = getPermitido("205");//eliminar unidad boleta
		            $dataex['vpermiso206'] = getPermitido("206");//actualizar origen boleta
	                $in = 0;
	                for ($i=0; $i < count($vCursosNotas) ; $i++) { 
	                    if ($vCursosNotas[$i]->codnotamigrada==""){
	                        $in = $in - 1;
	                        $vCursosNotas[$i]->codnotamigrada64 = "$in";
	                    }
	                    else{
	                        $vCursosNotas[$i]->codnotamigrada64 = base64url_encode($vCursosNotas[$i]->codnotamigrada);;
	                    }

	                    $vCursosNotas[$i]->codmatricula64_migrada = base64url_encode($vCursosNotas[$i]->codmatricula_migrada);
	                    $vCursosNotas[$i]->codcarga64_migrada = base64url_encode($vCursosNotas[$i]->codcarga_migrada);
	                    $vCursosNotas[$i]->codsubseccion64_migrada = base64url_encode($vCursosNotas[$i]->codsubseccion_migrada);
	                    $vCursosNotas[$i]->codmiembro64_plataforma = base64url_encode($vCursosNotas[$i]->codmiembro_plataforma);

	                    $vCursosNotas[$i]->notafin_migrada = (is_null($vCursosNotas[$i]->notafin_migrada ))? "":floatval($vCursosNotas[$i]->notafin_migrada);
	                    $vCursosNotas[$i]->notarecuperacion_migrada = (is_null($vCursosNotas[$i]->notarecuperacion_migrada ))? "":floatval($vCursosNotas[$i]->notarecuperacion_migrada);
	                    $funcionhelp="getNotas_alumnoboleta_$dominio";
	                    $vCursosNotas[$i]->notaprom_migrada = $funcionhelp($vCursosNotas[$i]->metodocalculo_migrada,array('promedio' => $vCursosNotas[$i]->notafin_migrada, 'recupera'=>$vCursosNotas[$i]->notarecuperacion_migrada));
	                    foreach ($nvecesund as $key => $item) {
	                        if ($item->idunidad == $vCursosNotas[$i]->codunidad_migrada) {
	                            $vCursosNotas[$i]->veces_migrada = $item->nrounidad;
	                        }
	                    }

	                }
	                $dataex['status'] =TRUE;
	                $dataex['vdata'] = $vCursosNotas;
                }
                
            }

        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($dataex);
    }
}