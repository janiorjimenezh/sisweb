<style>
	
	@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,600;1,800&display=swap');
	
	@page {
		margin: 0.1cm;
		padding: 0.1cm;
	}

	.table_carne {
		width: 8.5cm;
		height: 5cm;
	}

	.div_content_carne {
		/*width: 8.5cm;*/
		width: 17cm;
		/*height: 11cm;*/
		height: 5cm;
		float: left;
		padding: 0;
		margin: 0;
		margin-bottom: 1px;
	}

	.div_carne{
		/*width: 8.182cm;*/
		max-width: 8.182cm;
		min-width: 8.182cm;
		width: 8.182cm;
		height: 4.75cm;
		max-height: 4.75cm;
		/*min-height: 4.75cm;*/
		font-size: 10px;
		font-weight: bold;
		border: solid 1px #343a40;
		padding: 5px;
		background: url(<?php echo base_url()."resources/img/background_delante.jpg" ?>);
		background-repeat: no-repeat;
		background-size: 100% 100%;
		float: left;
		overflow: hidden;
	}

	.div_carne table {
		max-width: 8.182cm;
		min-width: 8.182cm;
		max-height: 4.75cm;
		/*min-height: 4.75cm;*/
		width: 8.182cm;
		height: 4.75cm;
	}

	.div_carne table tr td.text_programa {
		height: 0.5cm!important;
		overflow: hidden;
	}

	.div_carne_atras{
		/*width: 8.182cm;*/
		max-width: 8.182cm;
		min-width: 8.182cm;
		width: 8.182cm;
		height: 4.75cm;
		max-height: 4.75cm;
		/*min-height: 4.75cm;*/
		font-size: 10px;
		font-weight: bold;
		border: solid 1px #343a40;
		padding: 5px;
		background: url(<?php echo base_url()."resources/img/background_atras.jpg" ?>);
		background-repeat: no-repeat;
		background-size: 100% 100%;
		float: right;

	}

	.space_left_ {
		margin-left: 10px;
	}

	.text_left {
		text-align: left!important;
		width: 5cm;
	}

	.text_right {
		text-align: right!important;
		width: 3.5cm;
	}

	.text_right_carnet {
		text-align: right!important;
		width: 4.25cm;
	}

	.logo_iesap {
		width: 4cm;
		height: 0.8cm;
	}

	.logo_minedu {
		/*width: 3cm;*/
		width: 3cm;
		height: 0.8cm;
	}

	.text_color_iesap {
		color: #dc3545;
		font-size: 12px;
		font-family: 'Open Sans', sans-serif;
	}

	.text_color_content {
		color: #343a40!important;
		font-size: 12px;
		font-family: 'Open Sans', sans-serif;
	}

	.text_emision {
		font-size: 10px!important;
	}

	.foto_alumno {
		width: 3cm;
		position: absolute;
	}

	.content_text {
		width: 4.25cm;
	}

	.text_color_carnet {
		color: #8a7c73;
		font-size: 19px;
		font-family: 'Open Sans', sans-serif;
		font-weight: 700;
	}

	.bottom {
		margin-bottom: 5px;
	}

	table.tb_reverso {
		width: 100%;
		height: 4cm;
		margin-top: 65px;
		
	}

	.tb_reverso .head_{
		font-size: 25px;
		font-weight: bold;
		width: 0.8cm;
		background-color: #fff;
	}

	.text_rotate_90 {
		/*-webkit-transform: rotate(-90deg); 
		-moz-transform: rotate(-90deg);*/
		text-rotate:90;
		/*width: 0.5cm;*/
		
	}

	.text_rotate_180 {
		text-rotate:  180;
	}

	.ancho_cm {
		width: 1cm;
	}

	.barcode_content {
		/*width: 5cm;*/
		margin-bottom: 0;
	}

	.barcode {
	    padding: 0.5mm;
	    margin: 0;
	    margin-bottom: -5px;
	    vertical-align: top;
	    color: #000;
	    background-color: #E5E7E9;
	}
	.barcodecell {
	    text-align: center;
	    vertical-align: middle;
	}

	.div_colum {
		width: 40%;
		float: left;
		margin-top: 10px;
		margin-left: 5px;
	}

	.div_colum_carnet {
		float: right;
		text-align: right;
		margin-top: -3px;
		margin-right: 10px;
	}

	.divcard_foto {
		/*width:3cm;
		max-height:3cm;
		height:3cm;*/
		text-align:right;
		/*background: #cecece;*/
	}

	/*.divcard_foto img {
		width:100%;
		max-height:120px;
		height:100%;
	}*/

	
</style>

<?php
	date_default_timezone_set ('America/Lima');
	$fechaemision = date('d/m/Y');
	$dominio = getDominio();
	$vbaseurl = base_url();
	$nro = 0;
	
	foreach ($inscritos as $key => $ins) {
		// echo $ins;
		$nro++;
		$classleft = ($nro % 2==0) ? 'space_left':'';
		$txtcarnet = $ins->carne;
		$txtapellidos = $ins->paterno." ".$ins->materno;
		$txtnombres = $ins->nombres;
		$txtcarabrevia = $ins->carabrevia;
		$contenidobar = "#CRT-".$txtcarnet;
		$sigperiodo = "";
		$siganio = "";//(substr($ins->periodo, -1) == "1") ? substr($ins->periodo, 0,5)."2" : $ins->periodo;
		$rptafoto = $ins->foto;
		$existe=comprobarFoto('resources/fotos/' . $ins->foto);
		if ($existe==FALSE)
		{
			$rptafoto = "gg/".$ins->idpersona.".jpg";
			$existe=comprobarFoto('resources/fotos/' . $ins->foto);
			if ($existe==FALSE)
			{
				$rptafoto="user.jpg";
			}
		}

		if (isset($ins->femision)) {
			$emisioncarne = $ins->femision;
		} else {
			$emisioncarne = $fechaemision;
		}

		$periodo = explode("-",$ins->periodo);

		// switch (substr($ins->periodo, -1)) {
		switch ($periodo[1]) {
			case '1':
				$sigperiodo = $periodo[0]."-2";
				break;
			case '2':
				$sigperiodo = intval($periodo[0])+1 ."-1";
				break;
			case 'I':
				$sigperiodo = $periodo[0]."-II";
				break;
			case 'II':
				$sigperiodo = intval($periodo[0])+1 ."-I";
				break;
			default:
				// code...
				break;
		}

		
		switch ($ins->ciclo) {
			case 'I':
				$siguiente = "- II";
				break;
			case 'II':
				$siguiente = "- III";
				break;
			case 'III':
				$siguiente = "- IV";
				break;
			case 'IV':
				$siguiente = "- V";
				break;
			case 'VI':
				$siguiente = "";
				break;
			default:
				$siguiente = "- VI";
				break;
		}
		echo "<div class='div_content_carne $classleft'>
				<div class='div_carne'>
					<table border='0'>
						<tr>
							<td class='text_left' align='left'>
								<img class='logo_iesap' src='{$vbaseurl}resources/img/logo_carne.{$dominio}.png' alt='logo iesap'>
							</td>
							<td class='text_right' align='right'>
								<img class='logo_minedu' src='{$vbaseurl}resources/img/minedu_carne.png' alt='minedu'>
							</td>
						</tr>
						<tr>
							<td colspan='2' class='text_color_iesap text_right' align='right'></td>
						</tr>
						<tr>
							<td class='text_left'>
								<span class='text_color_iesap'><b>Nombres</b></span>
							</td>
							<td class='text_right td_image divcard_foto' rowspan='6' style='width:3cm;max-height:3cm;height:3cm;'>
								<b class='text_color_iesap text_right bottom'>$txtcarnet</b>
								<img class='foto_alumno' src='{$vbaseurl}resources/fotos/$rptafoto' alt='foto' style='max-width:2.8cm;width:100%;max-height:2.8cm;height:100%;'>
							</td>
						</tr>
						<tr>
							<td class='text_left'>
								<span class='text_color_content'><b>$txtnombres</b></span>
							</td>
							
						</tr>
						<tr>
							<td class='text_left'>
								<span class='text_color_iesap'><b>Apellidos</b></span>
							</td>
							
						</tr>
						<tr>
							<td class='text_left'>
								<span class='text_color_content'><b>$txtapellidos</b></span>
							</td>
							
						</tr>
						<tr>
							<td class='text_left'>
								<span class='text_color_iesap'><b>Programa</b></span>
							</td>
							
						</tr>
						<tr>
							<td class='text_left text_programa'>
								<span class='text_color_content'><b>$txtcarabrevia</b></span>
							</td>
							
						</tr>
						<tr>
							<td class='text_left'>
								<span class='text_color_iesap'><b>Semestre</b></span>
								<span class='text_color_content'><b>$ins->ciclo $siguiente</b></span>
							</td>
							<td class='text_right'>
								<span class='text_color_iesap text_emision'><b>Emitido</b></span>
								<span class='text_color_content text_emision'><b>$fechaemision</b></span>
							</td>
						</tr>
					</table>
				</div>
				<div class='div_carne_atras'>
					<div class='div_colum'>
						<span><b class='text_color_iesap'>Turno : </b><b class='text_color_content'>$ins->turno</b></span>
					</div>
					<div class='div_colum_carnet'>
						<b class='text_color_carnet'>Carnet Personal</b>
					</div>
					
					<table border='0' class='tb_reverso' width='100%'>
						<tr>
							<td class='head text_rotate_90' align='left' colspan='1'>
								<b class='text_color_content'>$ins->periodo</b>
							</td>
							<td class='ancho_cm'></td>
							<td class='ancho_cm'></td>
							<td class='ancho_cm'></td>
							<td class='ancho_cm'></td>
							<td class='ancho_cm'></td>
							<td class='ancho_cm'></td>
							<td class='head text_rotate_90' align='right' colspan='1'>
								<b class='text_color_content'>$sigperiodo</b>
							</td>
						</tr>
						<tr>
							<td class='head text_rotate_90' align='left' colspan='1'>
								<b class='text_color_iesap'>Periodo : </b>
							</td>
							
							<td colspan='6' align='center' class='barcodecell'>
								<barcode code='$contenidobar' type='C128B' class='barcode' size='0.8' height='1.5' error='M' disableborder='1' />
							</td>
							<td class='head text_rotate_90' align='right' colspan='1'>
								<b class='text_color_iesap'>Periodo : </b>
							</td>
						</tr>
					</table>
				</div>
			</div>";
	}
?>
