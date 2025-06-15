<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncios extends CI_Controller {
	private $ci;
	function __construct() {
		parent::__construct();
		$this->ci=& get_instance();
		$this->load->model('marea');
		$this->load->model('mdocentes');
		$this->load->model('mauditoria');

		$this->load->model('mcargasubseccion');
		$this->load->model('msede');
		$this->load->model('manuncio');
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
			
			$this->form_validation->set_rules('fictxttitulo','Titulo','trim|required');
			$this->form_validation->set_rules('fictxtanuncio','Anuncio','trim|required');

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
				$dataex['status'] =FALSE;
				
				$codigo = $this->input->post('fictxtcodigoanuncio');
				$titulo = $this->input->post('fictxttitulo');
				$anuncio = $this->input->post('fictxtanuncio');
				$codcarga = base64url_decode($this->input->post('fictxtcodigocarga'));
				$coddivision = base64url_decode($this->input->post('fictxtcodigodivision'));

				$usuario = $_SESSION['userActivo']->idusuario;
				// $sede = $_SESSION['userActivo']->idsede;
				date_default_timezone_set ('America/Lima');
				$publicado = date("Y-m-d H:i:s");

				$this->load->model('mcorreos');
				$this->load->model('miestp');
                $iestp=$this->miestp->m_get_datos();
				$d_enviador=array('notificaciones@'.getDominio(),$iestp->nombre);
                $d_destino=array();
                $d_copia=array();
                $d_oculto=array();
				$d_responder=$d_enviador;
                $d_asunto="";
				$d_mensaje = "";
				$contenidobs = "";
				

				if ($codigo == "0") {
					$rpta = $this->manuncio->mInsert_anuncio(array($codcarga, $coddivision, $titulo, $anuncio, $publicado, $usuario));
					if ($rpta->salida == '1'){
						$this->load->model('mmiembros');
                		$rptamiembros = $this->mmiembros->m_get_miembros_por_carga_division_con_fusionados(array($codcarga,$coddivision));
                		$rptaanuncio = $this->manuncio->m_get_carga_subseccionanuncios(array($codcarga,$coddivision,$rpta->newcod));
                		$contador = 0;
                		$d_asunto = $titulo;
                		// $d_mensaje = $anuncio;
                		$d_cuerpo = "El docente ".$rptaanuncio->paterno." ".$rptaanuncio->materno." ".$rptaanuncio->nombre." ha publicado un anuncio<br><b>$rptaanuncio->unidad</b>";
                		$contenidobs = $d_cuerpo;
                		$vbaseurl = base_url();
                		$vgetdominio = getDominio();

                		$e_mensaje = "<div style='background-color: white; padding: 15px;'>
										<br>
										<table>
											<tr>
												<td width='82px'>
													<img src='{$vbaseurl}resources/img/logo_h80.{$vgetdominio}.png' alt='LOGO'>
												</td>
												<td><h2 style='margin: 0px;'>$iestp->nombre </h2>Plataforma Virtual</td>
											</tr>
										</table>
										<hr>
										<br>
										<div style='padding: 20px 10px; margin-bottom:10px; background-color: #ededed;
											border-radius: 10px 10px 10px 10px;
											-moz-border-radius: 10px 10px 10px 10px;
											-webkit-border-radius: 10px 10px 10px 10px;
											border: 0px solid #000000;'>
											<div style='margin-bottom: 5px;'>
												$d_cuerpo
												<hr>
												<b>Mensaje: </b>$anuncio
												<br>
											</div>
										</div>
										
										Gracias. <br>
										Atte. Equipo de Plataforma Virtual <br><br>
										<hr>
										Usted está recibiendo este mensaje para informar eventos y/o cambios en su cuenta <br></small>
									</div>";

                		foreach ($rptamiembros as $key => $miembro) {
                			$contador++;
                			$rptamb = $this->manuncio->mInsert_anuncio_estudiante(array($rpta->newcod, $codcarga, $coddivision, 'NO', $miembro->idmiembro));
                			$correo=trim($miembro->einstitucional);
		                    if ($correo!=""){
		                        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		                            $d_destino[]=$correo;
		                        }
		                    }
                			// GUARDAR NOTIFICACIONES
                			if ($contador == 10 ) {
                				$rpta_not = $this->mcorreos->mInsert_correo_notificaciones(array($rpta->newcod,json_encode($d_enviador),json_encode($d_destino),$d_asunto,$e_mensaje,"CREADO","",json_encode($d_responder),$contenidobs,"ANUNCIOS",json_encode($d_copia),json_encode($d_oculto)));
                				$contador = 0;
                				$d_destino=array();
                			}
                			
                		}

                		if (count($d_destino) > 0) {
                			$rpta_not = $this->mcorreos->mInsert_correo_notificaciones(array($rpta->newcod,json_encode($d_enviador),json_encode($d_destino),$d_asunto,$e_mensaje,"CREADO","",json_encode($d_responder),$contenidobs,"ANUNCIOS",json_encode($d_copia),json_encode($d_oculto)));
                		}

						$dataex['status'] =TRUE;
						$dataex['msg'] ="Anuncio registrado correctamente";
						$dataex['msgnotif'] = $rpta_not;
						
					}
				} else {
					$rpta=$this->manuncio->mUpdate_anuncio(array(base64url_decode($codigo), $codcarga, $coddivision, $titulo, $anuncio));
					if ($rpta->salida == '1'){
						$dataex['status'] =TRUE;
						$dataex['msg'] ="Anuncio actualizado correctamente";
						
					}
				}
				
			}
		}
		
		header('Content-Type: application/x-json; charset=utf-8');
		echo json_encode($dataex);
	}

	public function fn_anuncio_xcodigo(){
		$dataex['status']=false;
		$dataex['msg']="No se ha podido establecer el origen de esta solicitud";
		$this->form_validation->set_message('required', '%s Requerido');
		$this->form_validation->set_message('min_length', '* {field} debe tener al menos {param} caracteres.');
		$this->form_validation->set_message('is_unique', '* {field} ya se encuentra registrado.');
		$this->form_validation->set_message('is_natural_no_zero', '* {field} requiere un valor de la lista.');
			
		$dataex['msg'] ='Intente nuevamente o comuniquese con un administrador.';
		$msgrpta="<h4>NO SE ENCONTRARON RESULTADOS</h4>";
		$this->form_validation->set_rules('txtcodigo', 'codigo anuncio', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$dataex['msg'] = validation_errors();
		}
		else{
			$codigo = base64url_decode($this->input->post('txtcodigo'));
			$dataex['status'] =true;
			$msgrpta = $this->manuncio->m_filtrar_anuncioxcodigo(array($codigo));
			$msgrpta->idanunc64 = base64url_encode($msgrpta->id);
			$msgrpta->idcarga64 = base64url_encode($msgrpta->carga);
			$msgrpta->iddivis64 = base64url_encode($msgrpta->division);
		}
		
		$dataex['vdata'] = $msgrpta;

		header('Content-Type: application/x-json; charset=utf-8');
		echo(json_encode($dataex));
	}

	public function vw_anuncios_estudiantes($codcarga, $division, $codmiembro)
	{
		$codcarga=base64url_decode($codcarga);
        $division=base64url_decode($division);
        if ($_SESSION['userActivo']->tipo=="AL"){
        	$this->load->model('mmiembros');
            $codm = $this->mmiembros->m_comprobar_miembro_codigo(array($codcarga,$division,base64url_decode($codmiembro)));
            if ($codm=="0"){
                $ahead= array('page_title' =>'No autorizado | IESTWEB'  );
                $asidebar= array('menu_padre' =>'aluanuncios');
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $this->load->view('sidebar',$asidebar);
                $this->load->view('errors/sin-permisos');
                $this->load->view('footer');
            }
            else{

                $ahead= array('page_title' =>'Anuncios | '.$this->ci->config->item('erp_title') );
                $this->load->view('head',$ahead);
                $this->load->view('nav');
                $vcurso = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
                $arraymc['curso'] = $vcurso;
                $arraymc['vanuncios'] = $this->manuncio->m_get_carga_subseccion_anuncios(array($vcurso->codcarga_fusion,$vcurso->division_fusion, base64url_decode($codmiembro)));
                $arsb['menu_padre']='aluanuncios';
                $arsb['vcarga']=$codcarga;
		        $arsb['vdivision']=$division;
		        $arsb['vmiembro']=base64url_decode($codmiembro);
                $arraymc['miembroid'] = $codmiembro;
                $this->load->view('alumno/sidebar_estudiante_curso',$arsb);
                $this->load->view('alumno/anuncios/vw_alumno_anuncios', $arraymc);
                $this->load->view('footer');
            }
        }
        else{
            $ahead= array('page_title' =>'No autorizado | IESTWEB'  );
            $asidebar= array('menu_padre' =>'aluanuncios');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar',$asidebar);
            $this->load->view('errors/sin-permisos-personalizado', array('mensaje' => 'Enlace habilitado solo para estudiantes' ));
            $this->load->view('footer');
        }
	}

	public function vw_anuncios_estudiantes_detalle($codcarga, $division, $material, $miembro)
	{
		$codcarga=base64url_decode($codcarga);
        $division=base64url_decode($division);
        $material=base64url_decode($material);
        $miembro=base64url_decode($miembro);
        if ($_SESSION['userActivo']->tipo=="AL"){
        	$ahead= array('page_title' =>'Anuncios | '.$this->ci->config->item('erp_title') );
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $vcurso = $this->mcargasubseccion->m_get_carga_subseccion(array($codcarga,$division));
            $arraymc['curso'] = $vcurso;
            $anuncios = $this->manuncio->m_get_anunciosxcarga_subseccion(array($vcurso->codcarga_fusion,$vcurso->division_fusion, $material, $miembro));
            $arraymc['vanuncios'] = $anuncios;
            if ($anuncios->leido == "NO") {
            	date_default_timezone_set ('America/Lima');
            	$fleido = date("Y-m-d H:i:s");
            	$rpleido = $this->manuncio->m_update_anuncio_leido(array('SI', $fleido, $vcurso->codcarga_fusion,$vcurso->division_fusion, $material, $miembro));
            }
           
            $arsb['menu_padre']='aluanuncios';
            $arsb['vcarga']=$codcarga;
	        $arsb['vdivision']=$division;
	        $arsb['vmiembro']=$miembro;
            $arraymc['miembroid'] = base64url_encode($miembro);
            $this->load->view('alumno/sidebar_estudiante_curso',$arsb);
            $this->load->view('alumno/anuncios/vw_anuncio_detalle', $arraymc);
            $this->load->view('footer');
        }
        else{
            $ahead= array('page_title' =>'No autorizado | IESTWEB'  );
            $asidebar= array('menu_padre' =>'aluanuncios');
            $this->load->view('head',$ahead);
            $this->load->view('nav');
            $this->load->view('sidebar',$asidebar);
            $this->load->view('errors/sin-permisos-personalizado', array('mensaje' => 'Enlace habilitado solo para estudiantes' ));
            $this->load->view('footer');
        }
	}

	public function fneliminar_anuncios()
    {
        $dataex['status'] = false;
        $dataex['msg']    = '¿Que intentas? .|.';
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_message('required', '%s Requerido');
            $dataex['msg'] = 'Intente nuevamente o comuniquese con un administrador.';
            $this->form_validation->set_rules('txtcodigo', 'codigo anuncio', 'trim|required');
            if ($this->form_validation->run() == false) {
                $dataex['msg'] = validation_errors();
            } else {
                $dataex['msg'] = "Ocurrio un error, no se puede eliminar este anuncio";
                $txtcodigo    = base64url_decode($this->input->post('txtcodigo'));
                
                $usuario = $_SESSION['userActivo']->idusuario;
				$sede = $_SESSION['userActivo']->idsede;
				$fictxtaccion = "ELIMINAR";
                
                $contenido = $_SESSION['userActivo']->usuario." - ".$_SESSION['userActivo']->paterno." ".$_SESSION['userActivo']->materno." ".$_SESSION['userActivo']->nombres.", está eliminando un anuncio en la tabla TB_CARGA_ANUNCIOS COD.".$txtcodigo;
				
                $rpta = $this->manuncio->m_eliminaanuncio(array($txtcodigo));
                if ($rpta->salida == '1') {
                	$auditoria = $this->mauditoria->insert_datos_auditoria(array($usuario, $fictxtaccion, $contenido, $sede));
                    $dataex['status'] = true;
                    $dataex['msg']    = 'Anuncio eliminado correctamente';

                }

            }

        }

        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($dataex));
    }    

}