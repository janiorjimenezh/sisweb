<?php
//require 'simple_html_dom.php';
//error_reporting(E_ALL ^ E_NOTICE);

$status = FALSE;
$msg = 'Ingresa un número de DNI';
if (isset($_POST['dni'])){
	$dni = $_POST['dni'];
	$msg = 'Solo se debe ingresar caracteres numéricos';
	if (ctype_digit($dni)){
		$msg = 'El número debe tener 8 caracteres';
		
		if (strlen($dni)>7){
			$cn=FALSE;
			try {
				// $cn = json_decode(file_get_contents("https://dniruc.apisperu.com/api/v1/dni/$dni?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpqaW1lbmV6QHRlY21lcmFraS5wZSJ9.0VCE_AyYj3gTjjO_hV7rHdHbDGPug0DI4pyZVnvE-Sg"),true);
				$token = 'apis-token-9152.MInlI8iXYRrx05O5hwlBJDHnfLYVP8M8';
				//$dni = $_REQUEST['dni'];

				// Iniciar llamada a API
				$curl = curl_init();

				// Buscar dni
				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 2,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_CUSTOMREQUEST => 'GET',
				  CURLOPT_HTTPHEADER => array(
				    'Referer: https://apis.net.pe/consulta-dni-api',
				    'Authorization: Bearer ' . $token
				  ),
				));


				$response = curl_exec($curl);
				curl_close($curl);
				$cn = json_decode($response,true);
			} catch (Exception $e) {
			    $cn=FALSE;
			}
			///$datos['cn']=$cn;
			$msg = 'Ocurrio un error, comunicate con el proveedor';
			//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
			if ($cn==FALSE){
				
			}
			else{
				//$consulta =$cn->plaintext;
				$msg = 'Número no encontrado en el Padron Electoral';
				$datosnombres = array();
							
				$result = $cn;
				$datos['result'] = $result;
				$datos['datos'] = $datosnombres[0];
				if ($cn['numeroDocumento']== $dni) {
					$status = TRUE;
					$msg = 'Número encontrado';
					$datos['paterno'] = $cn['apellidoPaterno'];
					$datos['materno'] = $cn['apellidoMaterno'];
					$datos['nombres'] = $cn['nombres'];
				} else {
					$status = false;
					$msg = $cn['error'];
				}

			}
		
		}
	}
	//OBTENEMOS EL VALOR
}
$datos['status'] = $status;
$datos['msg'] = $msg;

echo json_encode($datos);
?>
