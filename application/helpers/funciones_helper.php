<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('getDominio')){
	function getDominio() {
		/*$domexp=explode(".",base_url());
		$ultexp=count($domexp);
		$domimail=$domexp[$ultexp - 3].".".$domexp[$ultexp - 2].".".substr($domexp[$ultexp - 1],0,2);*/
		//$domimail="iestphuarmaca.edu.pe";
		//$domimail="iestpcanchaque.edu.pe";
		//$domimail="charlesashbee.edu.pe";
		//$domimail="iesap.edu.pe";
		$domimail="iestplaunion.edu.pe";
		//$domimail="iestbellavista.edu.pe";
		return $domimail;
	}
}


if(!function_exists('getPermitido')){
	function getPermitido($idperm){
		if ($_SESSION['userActivo']->codnivel==0) return "SI";
  		$prms = $_SESSION['userPermisos'];
		if (array_key_exists($idperm,$prms)){
			return $prms[$idperm];
		}
		else{
			return "NO";
		}
	}
}

if(!function_exists('mapped_implode')){
	function mapped_implode($glue, $array, $symbol = '=') {
	    return implode($glue, array_map(
	            function($k, $v) use($symbol) { 
	                return $k . $symbol . $v;
	            }, 
	            array_keys($array), 
	            array_values($array)
	            )
	        );
	}
}

if(!function_exists('print_vpd_modal')){
	function print_vpd_modal(){
	    echo 
	    '<div class="modal fade" id="md_rpta_documents" tabindex="-1" role="dialog" aria-modal="true" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	        <div class="modal-dialog modal-xl modal-dialog-scrollable h-100" role="document">
	            <div class="modal-content h-100" id="md_en_estudiante">
	                <div class="modal-header">
	                    <h5 class="modal-title px-1" id="mv_title_estudiante">Vista Previa</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body bordered">
	                    <iframe class="h-100" width="100%" id="divfile_view" src="" frameborder="0"></iframe>
	                </div>
	            </div>
	        </div>
	    </div>';
  	}
}
if(!function_exists('print_vpd_link')){
	function print_vpd_link($icon,$nombre,$descarga,$previa){
	    return "<div class='d-block'>
            	<div class='btn-group btn-group-sm mt-1'>
	                <a  href='$descarga' class='btn btn-link btn-sm p-0' >
	                    $icon $nombre
	                </a>
	                <a class='btn text-danger dropdown-toggle-split' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
						<span class='sr-only'>Descargar</span><i class='far fa-caret-square-down fa-lg'></i>
					</a>
	                <div class='dropdown-menu dropdown-menu-right' role='menu'>
	                    <a href='$descarga' class='dropdown-item'>
	                        <i class='fas fa-download'></i> Descargar
	                    </a>
	                    <a href='#' data-toggle='modal' data-target='#md_rpta_documents' data-file='$previa' class='dropdown-item'>
	                        <i class='fas fa-eye'></i> Vista Previa
	                    </a>
	                </div>
	            </div>
            </div>";
  	}
}
if(!function_exists('print_vpd_link_il')){
	function print_vpd_link_il($icon,$nombre,$descarga,$previa){
	    return "<div class='btn-group btn-group-sm mt-1'>
	                <a  href='$descarga' class='btn btn-link btn-sm p-0' >
	                    $icon $nombre
	                </a>
	                <a class='btn text-danger dropdown-toggle-split pt-0' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
						<span class='sr-only'>Descargar</span><i class='far fa-caret-square-down fa-lg'></i>
					</a>
	                <div class='dropdown-menu dropdown-menu-right' role='menu'>
	                    <a href='$descarga' class='dropdown-item'>
	                        <i class='fas fa-download'></i> Descargar
	                    </a>
	                    <a href='#' data-toggle='modal' data-target='#md_rpta_documents' data-file='$previa' class='dropdown-item'>
	                        <i class='fas fa-eye'></i> Vista Previa
	                    </a>
	                </div>
	            </div>";
  	}
}


if(!function_exists('getUserOptions')){
	function getUserOptions($key){
  		$prms = $_SESSION['UserOptions'];
		if (array_key_exists($key,$prms)){
			return $prms[$key];
		}
		else{
			return null;
		}
	}
}

if(!function_exists('formatBytes')){
	function formatBytes($size, $precision = 2)
	{
	    $base = log($size, 1024);
	    $suffixes = array('', 'K', 'M', 'G', 'T');   

	    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}
	
}

if(!function_exists('comprobarFoto')){
	function comprobarFoto($ruta){
		if (@getimagesize($ruta)){
			return true;
		} else {
			return false;
		}
	}
}

if(!function_exists('base64url_encode')){
	function base64url_encode($input) {
	 return strtr(base64_encode($input), '+/=', '._-');
	}
}

if(!function_exists('base64url_decode')){
	function base64url_decode($input) {
	 return base64_decode(strtr($input, '._-', '+/='));
	}
}

if(!function_exists('descarga_archivo')){
	function descarga_archivo($vfilename,$vfilepath,$vfiletype) {
		if(!empty($fileName) && file_exists($filePath)){
		 	header("Cache-Control: public");
		    header("Content-Description: File Transfer");
		    header("Content-Disposition: attachment; filename=$vfilename");
		    header("Content-type:$vfiletype");
		    header("Content-Transfer-Encoding: binary");
		    readfile($vfilepath);
		}
        else{
            header("Location: ".base_url()."no-encontrado");
        }
	}
}
 

if(!function_exists('url_clear')){
	function url_clear($url) {
	 $url = strtolower($url);
	 //Reemplazamos caracteres especiales latinos
	 $find = array('á','é','í','ó','ú','â','ê','î','ô','û','ã','õ','ç','ñ');
	 $repl = array('a','e','i','o','u','a','e','i','o','u','a','o','c','n');
	 $url = str_replace($find, $repl, $url);
	 //Añadimos los guiones
	 $find = array(' ', '&', '\r\n', '\n','+');
	 $url = str_replace($find, '-', $url);
	 //Eliminamos y Reemplazamos los demas caracteres especiales
	 $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<{^>*>/');
	 $repl = array('', '-', '');
	 $url = preg_replace($find, $repl, $url);
	 return $url;
	}
}


if(!function_exists('slugs')){
	function slugs($string)
    {
        $characters = array(
            "Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u",
            "á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
            "à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u",
        );

        $string = strtr($string, $characters);
        $string = strtolower(trim($string));
        $string = preg_replace("/[^a-z0-9-]/", "-", $string);
        $string = preg_replace("/-+/", "-", $string);

        if (substr($string, strlen($string) - 1, strlen($string)) === "-") {
            $string = substr($string, 0, strlen($string) - 1);
        }
        return $string;
    }
}


if(!function_exists('fechaCastellano')){
	function fechaCastellano ($fecha,$meses_ES,$dias_ES) {
		$strfecha=strtotime($fecha);
		$numeroDia = date('w', $strfecha);
		$dia = date('d', $strfecha);
		$mes = date('n', $strfecha);
		$anio = date('Y', $strfecha);
		
		$nombredia =$dias_ES[$numeroDia];
		$nombreMes = $meses_ES[$mes -1];
		//return $nombredia.", ".$dia." de ".$nombreMes." de ".$anio;
		return $nombredia.", ".$dia."- ".$nombreMes."- ".$anio;
	}
}



if(!function_exists('getIcono')){
	function getIcono ($tamanio,$nombre){
		$icon="<i class='fas fa-download mr-2'></i>";
		$ext          = explode(".", $nombre);
		$exten    = end($ext);
		if ($tamanio=='X'){
			if ($exten=="pdf"){
		        $icon="<img height='16px' class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'>";
		    }
		    else if(($exten=="mp4")||$exten=="mpg"){
		        $icon="<img height='16px' class='mr-1' src='".base_url()."resources/img/icons/p_vdo.png' alt='VÍDEO'>";
		    }
		    else if(($exten=="jpg")||$exten=="png"){
		        $icon="<img height='16px' class='mr-1' src='".base_url()."resources/img/icons/p_img.png' alt='IMAGEN'>";
		    }
		    else if(($exten=="doc")||$exten=="docx"){
		        $icon="<img height='16px' class='mr-1' src='".base_url()."resources/img/icons/p_word.png' alt='WORD'>";
		    }
		    else if(($exten=="ppt")||$exten=="pptx"){
		        $icon="<img height='16px' class='mr-1' src='".base_url()."resources/img/icons/p_ppt.png' alt='POWERPOINT'>";
		    }
		    else if(($exten=="xls")||$exten=="xlsx"){
		        $icon="<img height='16px' class='mr-1' src='".base_url()."resources/img/icons/p_excel.png' alt='EXCEL'>";
		    }
		}elseif ($tamanio=='P'){
			if ($exten=="pdf"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'>";
		    }
		    else if(($exten=="mp4")||$exten=="mpg"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_vdo.png' alt='VÍDEO'>";
		    }
		    else if(($exten=="jpg")||$exten=="png"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_img.png' alt='IMAGEN'>";
		    }
		    else if(($exten=="doc")||$exten=="docx"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_word.png' alt='WORD'>";
		    }
		    else if(($exten=="ppt")||$exten=="pptx"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_ppt.png' alt='POWERPOINT'>";
		    }
		    else if(($exten=="xls")||$exten=="xlsx"){
		        $icon="<img class='mr-1' src='".base_url()."resources/img/icons/p_excel.png' alt='EXCEL'>";
		    }
		}elseif ($tamanio=='G') {
			# code...
		}
		return $icon;
	}
}



if(!function_exists('hms_restantes')){
	function hms_restantes($hora_alta,$hora_cierre=""){
		date_default_timezone_set('America/Lima');
		$fecha_actual = new DateTime($hora_alta);//fecha inicial
		$fecha2 = ($hora_cierre=="") ? new DateTime() : new DateTime($hora_cierre)  ;
		$intervalo = $fecha_actual->diff($fecha2);
		$dias="";
		$horas="";
		$minutos="";
		$segundos="";
		switch ($intervalo->format("%a")) {
			case '0':
				break;
			case '1':
				$dias=$intervalo->format("%a día ");
				break;
			default:
				$dias=$intervalo->format("%a días ");
				break;
		}
		switch ($intervalo->format("%H")) {
			case '0':
				break;
			case '1':
				$horas=$intervalo->format("%H hora ");
				break;
			default:
				$horas=$intervalo->format("%H horas ");
				break;
		}
		switch ($intervalo->format("%i")) {
			case '0':
				break;
			case '1':
				$minutos=$intervalo->format("%i minuto ");
				break;
			default:
				$minutos=$intervalo->format("%i minutos ");
				break;
		}
		switch ($intervalo->format("%s")) {
			case '0':
				break;
			case '1':
				$segundos=$intervalo->format("%s segundo ");
				break;
			default:
				$segundos=$intervalo->format("%s segundos ");
				break;
		}
		if ($fecha_actual>$fecha2){
        	return "<span class='text-primary'>$dias$horas$minutos$segundos</span>";
        }
        else{
        	return "<span class='text-info'>Actividad retrasadas por: $dias$horas$minutos</span>";
        	
        }
	}
}

if(!function_exists('optimiza_img')){
	function optimiza_img($filecontrol,$configimg,$configthumb="",$nombrearchivo=""){
		$dataex['link']="";
		$dataex['status']=false;
		if(isset($filecontrol)){
			//Funciones optimizar imagenes
			//Ruta de la carpeta donde se guardarán las imagenes
			//$patch='resources/fotos/tmp';
			//Parámetros optimización, resolución máxima permitida
			$patch=(isset($configimg['patch']))?$configimg['patch']:'resources/fotos/tmp';
			$max_ancho = (isset($configimg['ancho']))?$configimg['ancho']:900;
			$max_alto = (isset($configimg['alto']))?$configimg['alto']:350;
			if($filecontrol['type']=='image/png' || $filecontrol['type']=='image/jpeg' || $filecontrol['type']=='image/gif'){
				$dataex['msg'] = "Ocurrio un error al subir la imagen";
				$medidasimagen= getimagesize($filecontrol['tmp_name']);

				$fileNameExt  = $filecontrol["name"];
		        $ext          = explode(".", $fileNameExt);
		        $extension    = end($ext);
		        $nro_rand=rand(0,9);
				if ($nombrearchivo=="") $nombrearchivo  = $_SESSION['userActivo']->codpersona.$nro_rand.date("d") . date("m") . date("Y") . date("H") . date("i").".".$extension;
				//Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
				$copiado=false;
				if($medidasimagen[0] < $max_ancho && $filecontrol['size'] < 200000){
					if ($configthumb!=""){
						$patch_th=(isset($configthumb['patch']))?$configthumb['patch']:'resources/fotos/tmp';
						$max_ancho_th = (isset($configthumb['ancho']))?$configthumb['ancho']:900;
						$max_alto_th = (isset($configthumb['alto']))?$configthumb['alto']:350;
						$rtOriginal=$filecontrol['tmp_name'];
						if($filecontrol['type']=='image/jpeg'){
							$original = imagecreatefromjpeg($rtOriginal);
						}
						else if($filecontrol['type']=='image/png'){
							$original = imagecreatefrompng($rtOriginal);
						}
						else if($filecontrol['type']=='image/gif'){
							$original = imagecreatefromgif($rtOriginal);
						}
						list($ancho,$alto)=getimagesize($rtOriginal);
						$x_ratio = $max_ancho_th / $ancho;
						$y_ratio = $max_alto_th / $alto;

						if( ($ancho <= $max_ancho_th) && ($alto <= $max_alto_th) ){
							$ancho_final_th = $ancho;
							$alto_final_th = $alto;
						}
						elseif (($x_ratio * $alto) < $max_alto_th){
							$alto_final_th = ceil($x_ratio * $alto);
							$ancho_final_th = $max_ancho_th;
						}
						else{
							$ancho_final_th = ceil($y_ratio * $ancho);
							$alto_final_th = $max_alto_th;
						}

						$lienzo_th=imagecreatetruecolor($ancho_final_th,$alto_final_th);
						imagecopyresampled($lienzo_th,$original,0,0,0,0,$ancho_final_th, $alto_final_th,$ancho,$alto);
						//imagedestroy($original);
						$cal=8;
						
						if($filecontrol['type']=='image/jpeg'){
							$copiado=imagejpeg($lienzo_th,$patch_th."/".$nombrearchivo);
						}
						else if($filecontrol['type']=='image/png'){
							$copiado=imagepng($lienzo_th,$patch_th."/".$nombrearchivo);
						}
						else if($filecontrol['type']=='image/gif'){
							$copiado=imagegif($lienzo_th,$patch_th."/".$nombrearchivo);
						}
					}
					move_uploaded_file($filecontrol['tmp_name'], $patch.'/'.$nombrearchivo);
					$copiado=true;
				}
				//Si no, se generan nuevas imagenes optimizadas
				else {
					$dataex['msg'] = "Ocurrio un error al optimizar la imagen";
					//Redimensionar
					$rtOriginal=$filecontrol['tmp_name'];
					if($filecontrol['type']=='image/jpeg'){
						$original = imagecreatefromjpeg($rtOriginal);
					}
					else if($filecontrol['type']=='image/png'){
						$original = imagecreatefrompng($rtOriginal);
					}
					else if($filecontrol['type']=='image/gif'){
						$original = imagecreatefromgif($rtOriginal);
					}
					list($ancho,$alto)=getimagesize($rtOriginal);
					$x_ratio = $max_ancho / $ancho;
					$y_ratio = $max_alto / $alto;
					if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
						$ancho_final = $ancho;
						$alto_final = $alto;
					}
					elseif (($x_ratio * $alto) < $max_alto){
						$alto_final = ceil($x_ratio * $alto);
						$ancho_final = $max_ancho;
					}
					else{
						$ancho_final = ceil($y_ratio * $ancho);
						$alto_final = $max_alto;
					}
					$lienzo=imagecreatetruecolor($ancho_final,$alto_final);
					imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
					//imagedestroy($original);
					$cal=8;
					
					if($filecontrol['type']=='image/jpeg'){
						$copiado=imagejpeg($lienzo,$patch."/".$nombrearchivo);
					}
					else if($filecontrol['type']=='image/png'){
						$copiado=imagepng($lienzo,$patch."/".$nombrearchivo);
					}
					else if($filecontrol['type']=='image/gif'){
						$copiado=imagegif($lienzo,$patch."/".$nombrearchivo);
					}

					if ($configthumb!=""){
						$patch_th=(isset($configthumb['patch']))?$configthumb['patch']:'resources/fotos/tmp';
						$max_ancho_th = (isset($configthumb['ancho']))?$configthumb['ancho']:50;
						$max_alto_th = (isset($configthumb['alto']))?$configthumb['alto']:100;

						$x_ratio_th = $max_ancho_th / $ancho;
						$y_ratio_th = $max_alto_th / $alto;

						if( ($ancho <= $max_ancho_th) && ($alto <= $max_alto_th) ){
							$ancho_final_th = $ancho;
							$alto_final_th = $alto;
						}
						elseif (($x_ratio_th * $alto) < $max_alto_th){
							$alto_final_th = ceil($x_ratio_th * $alto);
							$ancho_final_th = $max_ancho_th;
						}
						else{
							$ancho_final_th = ceil($y_ratio_th * $ancho);
							$alto_final_th = $max_alto_th;
						}

						$lienzo_th=imagecreatetruecolor($ancho_final_th,$alto_final_th);
						imagecopyresampled($lienzo_th,$original,0,0,0,0,$ancho_final_th, $alto_final_th,$ancho,$alto);
						//imagedestroy($original);
						$cal=8;
						
						if($filecontrol['type']=='image/jpeg'){
							$copiado=imagejpeg($lienzo_th,$patch_th."/".$nombrearchivo);
						}
						else if($filecontrol['type']=='image/png'){
							$copiado=imagepng($lienzo_th,$patch_th."/".$nombrearchivo);
						}
						else if($filecontrol['type']=='image/gif'){
							$copiado=imagegif($lienzo_th,$patch_th."/".$nombrearchivo);
						}
					}

				}
		        $dataex['status']=$copiado;
		        if ($copiado) {
		        	$dataex['msg'] = "Imagen en servidor";
		            $dataex['link'] = $nombrearchivo;
		        }
			}
			else {
				$dataex['msg'] = "Solo se aceptan imágenes";
			}
		}
		//header('Content-Type: application/x-json; charset=utf-8');
        return $dataex;
	}
}


if(!function_exists('getNotas_alumno_iesap_edu_pe')){
	function getNotas_alumno_iesap_edu_pe($metodo,$alumnos,$indicadores) {
		if ($metodo=="PFCP") {
   			foreach ($alumnos as $keyalumno => $alumno) {
	   			$nco=0;
		        $eis=0;
		        $tais=0;
		        foreach ($indicadores as $indicador) {
		            $ep=$alumnos[$keyalumno]['eval'][$indicador->codigo]['N1']['nota'];
		            if (!is_numeric($ep)) $ep=0;
		            $ta=$alumnos[$keyalumno]['eval'][$indicador->codigo]['N2']['nota'];
		            if (!is_numeric($ta)) $ta=0;
		            if ($nco<2){
		                $ei=$alumnos[$keyalumno]['eval'][$indicador->codigo]['N3']['nota'];
		               	if (!is_numeric($ei)) $ei=0; 
		                //RECUPERACION POR INDICADOR
		                $recu_unidad=$alumnos[$keyalumno]['eval'][$indicador->codigo]['NR']['nota'];
		                if (!is_numeric($recu_unidad)) $recu_unidad=""; 
		                if ($recu_unidad!=""){
		                	if (($ep<$ta) && ($ep<$ei)){
		                		$ep=$recu_unidad;
		                	}
		                	else if (($ta<$ep) && ($ta<$ei)){
		                		$ta=$recu_unidad;
		                	}
		                	else if (($ei<$ep) && ($ei<$ta)){
		                		$ei=$recu_unidad;
		                	}
		            	}
		                $eis= $eis + $ei;
		            }
		            $tai=round(($ep + $ta)/2,0);
		            $alumnos[$keyalumno]['eval'][$indicador->codigo]['TAI']['nota']=$tai;
		            $tais=$tais + $tai;
		            $ultind=$indicador->codigo;
		            $nco++;
		        }
		        if ($nco==0) $nco=1;
		        
		        $tap=round($tais/$nco,0);
		        $alumnos[$keyalumno]['eval']['PTA']['tipo'] = "C"; 
		        $alumnos[$keyalumno]['eval']['PTA']['nota']=$tap;

		        $nco=$nco - 1;
		        if ($nco<=0) $nco=1;
		        $eip=round($eis/$nco,0);

		        $alumnos[$keyalumno]['eval']['PEI']['tipo'] = "C"; 
		        $alumnos[$keyalumno]['eval']['PEI']['nota']=$eip;

		        $ef=$alumnos[$keyalumno]['eval'][$ultind]['N3']['nota']; 
		        if (!is_numeric($ef)) $ef=0; 


		        $pi=round(($tap * 0.3) + ($eip * 0.3) + ($ef * 0.4),0); 
		        $alumnos[$keyalumno]['eval']['PI']['tipo'] = "C"; 
		        $alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
		        
		        $rc=$alumnos[$keyalumno]['eval']['RC']['nota'];
		        if (!is_numeric($rc)) $rc=0;

		        $alumnos[$keyalumno]['eval']['PF']['tipo'] = "C"; 
	        	$alumnos[$keyalumno]['eval']['PF']['nota']=($pi>$rc) ? $pi : $rc;
   			}
   		}
   		elseif ($metodo=="PFGN") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$pindicador=round(($n1 + $n2 + $n3)/3);

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;
   					$suma=$suma + $pindicador;
   					$nindicadores++;
   				}
   				if ($nindicadores==0){
   					$pi=0;
   				}
   				else{
   					$pi=round($suma/$nindicadores,0);
   				}
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (is_numeric($rc)){
	        		$pi=round(($pi + $rc)/2);
	        	}
   				$alumnos[$keyalumno]['eval']['PF']['nota']=$pi;
   			}
   		}
   		elseif ($metodo=="PF22") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				//$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$pindicador=round(($n1 * 0.3) + ($n2 * 0.3) + ($n3 * 0.4));

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;
   					$peso=$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['peso'];
   					$porc_indicador=$pindicador * $peso;
   					$suma=$suma + $porc_indicador;
   				}
   				
   				$pi=round($suma,0);
   				
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (is_numeric($rc)){
	        		if ($rc>$pi){
	        			$pi=round(($pi + $rc)/2);
	        		}
	        	}
   				$alumnos[$keyalumno]['eval']['PF']['nota']=$pi;
   			}
   		}
   		elseif ($metodo=="PS03") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$pindicador=round(($n1 + $n2 + $n3)/3);

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;
   					$suma=$suma + $pindicador;
   					$nindicadores++;
   				}
   				if ($nindicadores==0){
   					$pi=0;
   				}
   				else{
   					$pi=round($suma/$nindicadores,0);
   				}
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (is_numeric($rc)){
	        		$pi=round(($pi + $rc)/2);
	        	}
   				$alumnos[$keyalumno]['eval']['PF']['nota']=$pi;
   			}
   		}
   		elseif ($metodo=="PS04") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$n4=$alumno['eval'][$indicador->codigo]['N4']['nota'];
   					if (!is_numeric($n4)) $n4=0;
   					$pindicador=round(($n1 + $n2 + $n3 + $n4)/4);

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;
   					$suma=$suma + $pindicador;
   					$nindicadores++;
   				}
   				if ($nindicadores==0){
   					$pi=0;
   				}
   				else{
   					$pi=round($suma/$nindicadores,0);
   				}
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (is_numeric($rc)){
	        		$pi=round(($pi + $rc)/2);
	        	}
   				$alumnos[$keyalumno]['eval']['PF']['nota']=$pi;
   			}
   		}
   		return $alumnos;
    }
}

if(!function_exists('getNotas_alumnoboleta_iesap_edu_pe')){
	function getNotas_alumnoboleta_iesap_edu_pe($metodo,$notas) {
		$final=0;
		if ($metodo=="PFCP") {
		        $pi=$notas['promedio']; 
		        $rc=$notas['recupera'];
		        if (!is_numeric($rc)) $rc=0;
	        	$final=($pi>$rc) ? $pi : $rc;
   			
   		}
   		elseif ($metodo=="PFGN") {
   			$pi=$notas['promedio']; 
		    $rc=$notas['recupera'];
        	if (is_numeric($rc)){
        		$pi=round(($pi + $rc)/2);
        	}
			$final=$pi;
   			
   		}
   		elseif ($metodo=="PF22") {
   			$pi=$notas['promedio']; 
		    $rc=$notas['recupera'];
        	if (is_numeric($rc)){
        		if ($rc>$pi){
        			$pi=round(($pi + $rc)/2);
        		}
        	}
			$final=$pi;
   			
   		}
   		elseif ($metodo=="PS03") {
   			$pi=$notas['promedio']; 
	        $rc=$notas['recupera'];
        	if (is_numeric($rc)){
        		$pi=round(($pi + $rc)/2);
        	}
			$final=$pi;
   		}
   		
   		return $final;
    }
}

if(!function_exists('getNotas_alumno_charlesashbee_edu_pe')){
	function getNotas_alumno_charlesashbee_edu_pe($metodo,$alumnos,$indicadores) {
		if ($metodo=="PFCP") {
   			foreach ($alumnos as $keyalumno => $alumno) {
	   			$nco=0;
		        $eis=0;
		        $tais=0;
		        foreach ($indicadores as $indicador) {
		            $ep=$alumnos[$keyalumno]['eval'][$indicador->codigo]['N1']['nota'];
		            if (!is_numeric($ep)) $ep=0;
		            $ta=$alumnos[$keyalumno]['eval'][$indicador->codigo]['N2']['nota'];
		            if (!is_numeric($ta)) $ta=0;
		            if ($nco<2){
		                $ei=$alumnos[$keyalumno]['eval'][$indicador->codigo]['N3']['nota'];
		               	if (!is_numeric($ei)) $ei=0; 
		                //RECUPERACION POR INDICADOR
		                // $recu_unidad=$alumnos[$keyalumno]['eval'][$indicador->codigo]['NR']['nota'];
		                // if (!is_numeric($recu_unidad)) $recu_unidad=""; 
		                // if ($recu_unidad!=""){
		                // 	if (($ep<$ta) && ($ep<$ei)){
		                // 		$ep=$recu_unidad;
		                // 	}
		                // 	else if (($ta<$ep) && ($ta<$ei)){
		                // 		$ta=$recu_unidad;
		                // 	}
		                // 	else if (($ei<$ep) && ($ei<$ta)){
		                // 		$ei=$recu_unidad;
		                // 	}
		            	// }
		                $eis= $eis + $ei;
		            }
		            $tai=round(($ep + $ta)/2,0);
		            $alumnos[$keyalumno]['eval'][$indicador->codigo]['TAI']['nota']=$tai;
		            $tais=$tais + $tai;
		            $ultind=$indicador->codigo;
		            $nco++;
		        }
		        if ($nco==0) $nco=1;
		        
		        $tap=round($tais/$nco,0);
		        $alumnos[$keyalumno]['eval']['PTA']['tipo'] = "C"; 
		        $alumnos[$keyalumno]['eval']['PTA']['nota']=$tap;

		        $nco=$nco - 1;
		        if ($nco<=0) $nco=1;
		        $eip=round($eis/$nco,0);

		        $alumnos[$keyalumno]['eval']['PEI']['tipo'] = "C"; 
		        $alumnos[$keyalumno]['eval']['PEI']['nota']=$eip;

		        $ef=$alumnos[$keyalumno]['eval'][$ultind]['N3']['nota']; 
		        if (!is_numeric($ef)) $ef=0; 


		        $pi=round(($tap * 0.3) + ($eip * 0.3) + ($ef * 0.4),0); 
		        $alumnos[$keyalumno]['eval']['PI']['tipo'] = "C"; 
		        $alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
		        
		        $rc=$alumnos[$keyalumno]['eval']['RC']['nota'];
		        if (!is_numeric($rc)) $rc=0;

		        $alumnos[$keyalumno]['eval']['PF']['tipo'] = "C"; 
	        	$alumnos[$keyalumno]['eval']['PF']['nota']=($pi>$rc) ? $pi : $rc;
   			}
   		}
   		elseif ($metodo=="PS03") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$pindicador=round(($n1 + $n2 + $n3)/3);

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;
   					$suma=$suma + $pindicador;
   					$nindicadores++;
   				}
   				if ($nindicadores==0){
   					$pi=0;
   				}
   				else{
   					$pi=round($suma/$nindicadores,0);
   				}
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (is_numeric($rc)){
	        		$pi=round(($pi + $rc)/2);
	        	}
   				$alumnos[$keyalumno]['eval']['PF']['nota']=$pi;
   			}
   		}
   		elseif ($metodo=="PS04") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$n4=$alumno['eval'][$indicador->codigo]['N4']['nota'];
   					if (!is_numeric($n4)) $n4=0;
   					$pindicador=round(($n1 + $n2 + $n3 + $n4)/4);

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;
   					$suma=$suma + $pindicador;
   					$nindicadores++;
   				}
   				if ($nindicadores==0){
   					$pi=0;
   				}
   				else{
   					$pi=round($suma/$nindicadores,0);
   				}
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (is_numeric($rc)){
	        		$pi=round(($pi + $rc)/2);
	        	}
   				$alumnos[$keyalumno]['eval']['PF']['nota']=$pi;
   			}
   		}
   		return $alumnos;
    }
}

if(!function_exists('getNotas_alumnoboleta_charlesashbee_edu_pe')){
	function getNotas_alumnoboleta_charlesashbee_edu_pe($metodo,$notas) {
		$final=0;
		if ($metodo=="PFCP") {
		        $pi=$notas['promedio']; 
		        $rc=$notas['recupera'];
		        if (!is_numeric($rc)) $rc=0;
	        	$final=($pi>$rc) ? $pi : $rc;
   			
   		}
   		elseif ($metodo=="PFGN") {
   			$pi=$notas['promedio']; 
		    $rc=$notas['recupera'];
        	if (is_numeric($rc)){
        		$pi=round(($pi + $rc)/2);
        	}
			$final=$pi;
   			
   		}
   		elseif ($metodo=="PF22") {
   			$pi=$notas['promedio']; 
		    $rc=$notas['recupera'];
        	if (is_numeric($rc)){
        		if ($rc>$pi){
        			$pi=round(($pi + $rc)/2);
        		}
        	}
			$final=$pi;
   			
   		}
   		elseif ($metodo=="PS03") {
   			$pi=$notas['promedio']; 
	        $rc=$notas['recupera'];
        	if (is_numeric($rc)){
        		$pi=round(($pi + $rc)/2);
        	}
			$final=$pi;
   		}
   		
   		return $final;
    }
}

if(!function_exists('getNotas_alumno_iestbellavista_edu_pe')){
	function getNotas_alumno_iestbellavista_edu_pe($metodo,$alumnos,$indicadores) {

   	if ($metodo=="PF22") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$pindicador=round(($n1 * 0.3) + ($n2 * 0.4) + ($n3 * 0.3));
   					$ri=$alumno['eval'][$indicador->codigo]['N4']['nota'];
   					if (!is_numeric($ri)) $ri=0;

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;

   					// $peso=$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['peso'];
   					// $porc_indicador=$pindicador * $peso;
   					$suma=$suma + (($pindicador>$ri) ? $pindicador : $ri);
   					$nindicadores++;
   				}
   				
   				if ($nindicadores==0) $nindicadores=1;
   				$pfinal=round($suma/$nindicadores,0);
   				
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pfinal;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (!is_numeric($rc)) $rc="";

	    

   				$alumnos[$keyalumno]['eval']['PF']['nota']=($rc!="") ? $rc : $pfinal;
   			}
   		}
   		elseif ($metodo=="PS03") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$pindicador=round(($n1 + $n2 + $n3)/3);

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;
   					$suma=$suma + $pindicador;
   					$nindicadores++;
   				}
   				if ($nindicadores==0){
   					$pi=0;
   				}
   				else{
   					$pi=round($suma/$nindicadores,0);
   				}
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (is_numeric($rc)){
	        		$pi=round(($pi + $rc)/2);
	        	}
   				$alumnos[$keyalumno]['eval']['PF']['nota']=$pi;
   			}
   		}
   		elseif ($metodo=="PS04") {
   			foreach ($alumnos as $keyalumno => $alumno) {
   				$nindicadores=0;
   				$suma=0;
   				foreach ($indicadores as $keyindicdor => $indicador) {
   					$n1=$alumno['eval'][$indicador->codigo]['N1']['nota'];
   					if (!is_numeric($n1)) $n1=0;
   					$n2=$alumno['eval'][$indicador->codigo]['N2']['nota'];
   					if (!is_numeric($n2)) $n2=0;
   					$n3=$alumno['eval'][$indicador->codigo]['N3']['nota'];
   					if (!is_numeric($n3)) $n3=0;
   					$n4=$alumno['eval'][$indicador->codigo]['N4']['nota'];
   					if (!is_numeric($n4)) $n4=0;
   					$pindicador=round(($n1 + $n2 + $n3 + $n4)/4);

   					$alumnos[$keyalumno]['eval'][$indicador->codigo]['C1']['nota']=$pindicador;
   					$suma=$suma + $pindicador;
   					$nindicadores++;
   				}
   				if ($nindicadores==0){
   					$pi=0;
   				}
   				else{
   					$pi=round($suma/$nindicadores,0);
   				}
   				$alumnos[$keyalumno]['eval']['PI']['nota']=$pi;
   				//CALCULO DE RECUPERACIÓN
   				$rc=$alumno['eval']['RC']['nota'];
	        	if (is_numeric($rc)){
	        		$pi=round(($pi + $rc)/2);
	        	}
   				$alumnos[$keyalumno]['eval']['PF']['nota']=$pi;
   			}
   		}
   		return $alumnos;
    }
}

if(!function_exists('getNotas_alumnoboleta_iestbellavista_edu_pe')){
	function getNotas_alumnoboleta_iestbellavista_edu_pe($metodo,$notas) {
		$final=0;

   		if ($metodo=="PF22") {
   			$pi=$notas['promedio']; 
		    $rc=$notas['recupera'];
        	if (!is_numeric($rc)) $rc="";

	        $final=($rc!="") ? $rc : $pi;
			
   			
   		}
   		elseif ($metodo=="PS03") {
   			$pi=$notas['promedio']; 
	        $rc=$notas['recupera'];
        	if (is_numeric($rc)){
        		$pi=round(($pi + $rc)/2);
        	}
			$final=$pi;
   		}
   		
   		return $final;
    }
}