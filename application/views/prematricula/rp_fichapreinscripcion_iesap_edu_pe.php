
<style>
	@page {
		margin-top: 1.0cm;
		margin-bottom: 1.0cm;
		margin-left: 1.5cm;
		margin-right: 1.5cm;
	}
	
	.encabezado{
		width: 100%;
		border-collapse: collapse;
	}
	.logo-minedu{
		width: 200px;
		height: 50px;
	}

	.logo-ies{
		height:  40px;
		width: 200px;
	}
	.celda{
		height: 15px;
		padding: 5px;
		border: solid 1px black;
		font-size: 10px;
	}
	.texto{
		height: 20px;
		padding: 5px;
		font-size: 12px;
	}
	.firmas{
		height: 20px;
		padding: 5px;
		font-size: 10px;
	}
	.cgris{
		background-color: #E9E4E4;
	}
	.ccenter{
		text-align: center;
		font-weight: bold;
	}
	.ccenter-nobold{
		text-align: center;
	}
	.w25p{
		width: 5cm;
	}

	.text-small-9 {
		font-size: 10px;
	}

	.text-13 {
		font-size: 13px;
	}
</style>

<table class="encabezado" style="margin-bottom: 5px;">
	<tr>
		<td>
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h80.'.getDominio().'.png' ?>" alt="iestcanchaque">
		</td>
		<td class="" width="200px">
			
		</td>
		<td valign="bottom" class="ccenter-nobold">
			<img class="logo-minedu" src="<?php echo base_url().'resources/img/minedu_logo.png' ?>" alt="minedu" >
		</td>
		
	</tr><br><br>
	<tr>
		<td colspan="3" class="ccenter-nobold">
			<b>CONSTANCIA DE SOLICITUD DE INSCRIPCIÓN</b>
		</td>
		
	</tr>
</table>

<table class="encabezado" style="margin-bottom: 7px;">
	<tr>
		<td class="celda cgris">
			<b><span>AÑO</span></b>
		</td>
		<td class="celda">
			<b><span><?php echo $ins['ficha']->anio ?></span></b>
		</td>
		<td align="right" style="width: 40%">
		</td>
		<td class="celda cgris">
			<b><span>INSCRIPCIÓN EN LA FILIAL</span></b>
		</td>
		<td class="celda text-13">
			<b><span><?php echo $dtsede->nombre ?></span></b>
		</td>
	</tr>
</table>

<table class="encabezado" style="margin-bottom: 7px;">
	<tr>
		<td colspan="2" class="celda cgris w25p">
			<span>Nombre del IES/EIEST</span>
		</td>
		<td colspan="6" class="celda ccenter w25p">
			<span><?php echo $ies->nombre ?></span>
		</td>
		
	</tr>
	
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Departamento:</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $dtsede->nomdep ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>Telefono: </span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins['ficha']->sede_telefonos ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Correo Electrónico:</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins['ficha']->sede_eadmision ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>Página Web: </span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->web ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Programa de estudio: </span>
		</td>
		<td colspan="6" class="celda ccenter text-small-9">
			<span><?php echo $ins['ficha']->carrera ?></span>
		</td>
	</tr>
</table>

<table class="encabezado" style="margin-bottom: 7px;">
	<tr>
		<td colspan="8" class="celda cgris ccenter">
			<span>DATOS DEL POSTULANTE</span>
		</td>

	</tr>
	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>APELIDO PATERNO</span>
		</td>
		<td colspan="3" class="celda cgris ccenter text-small-9">
			<span>APELIDO MATERNO</span>
		</td>
		<td colspan="3" class="celda cgris ccenter text-small-9">
			<span>NOMBRES</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->paterno ?></span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->materno ?></span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->nombres ?></span>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>FECHA DE NACIMIENTO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>DOCUMENTO DE IDENTIDAD</span>
		</td>
		<td colspan="1" class="celda cgris ccenter text-small-9">
			<span>EDAD</span>
		</td>
		<td colspan="3" class="celda cgris ccenter text-small-9">
			<span>SEXO</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span>
				<?php 
				$tiempo = strtotime($ins['ficha']->fecnac); 
				echo date("d | m  | Y", $tiempo); ?>
					
				</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->tipodoc." - ".$ins['ficha']->numero ?></span>
		</td>
		<td colspan="1" class="celda ccenter-nobold">
			<span>
				<?php 
				    $ahora = time(); 
				    $edad = ($ahora-$tiempo)/(60*60*24*365.25); 
				    $edad = floor($edad); 
				    echo $edad;
				 ?>
			</span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->sexo ?></span>
		</td>
	</tr>

	<tr>		
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>DISTRITO</span>
		</td>
		<td colspan="3" class="celda cgris ccenter text-small-9">
			<span>PROVINCIA</span>
		</td>
		<td colspan="3" class="celda cgris ccenter text-small-9">
			<span>REGIÓN</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->nomdistrito ?></span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->provincia ?></span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->departamento ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="6" class="celda cgris ccenter text-small-9">
			<span>DOMICILIO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>TRABAJA</span>
		</td>

	</tr>
	<tr>
		<td colspan="6" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->direccion ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->trabaja ?></span>
		</td>
	</tr>
	<?php if ($ins['ficha']->trabaja == "SI"): ?>
	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>LUGAR TRABAJA:</span>
		</td>
		<td colspan="6" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->lugtrabaja ?></span>
		</td>
	</tr>

	<?php endif ?>

	<tr>
		
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>ESTADO CIVIL</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>TELEFONO</span>
		</td>
		<td colspan="4" class="celda cgris ccenter text-small-9">
			<span>CORREO ELECTRÓNICO</span>
		</td>
	</tr>
	<tr>
		
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->estcivil ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span>
			<?php

			 echo trim($ins['ficha']->telefono) ?></span>
		</td>
		<td colspan="4" class="celda ccenter-nobold">
			<span><?php echo $ins['ficha']->correo ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="8" class="text-small-9 celda" style="border:none;">
			<b style="color: #17a2b8;">IMPORTANTE</b> Para la apertura del ciclo de estudios se debe contar con 20 participantes como mínimo
		</td>
	</tr>
	<tr>
		<td colspan="8" class="text-small-9 celda" style="border:none;">
			<b style="color: #000;">En breve nuestros asesores se pondrán en contacto contigo, para confirmar y validar tu inscripción</b>
		</td>
	</tr>
</table>

<table class="encabezado">
	<tr>
		<td class="texto" align="right">
			<?php 
			  $fecha=$ins['ficha']->fecha;
			  $fecha = substr($fecha, 0, 10);
			  $numeroDia = date('d', strtotime($fecha));
			  $dia = date('l', strtotime($fecha));
			  $mes = date('F', strtotime($fecha));
			  $anio = date('Y', strtotime($fecha));
			  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
			  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
			  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
			  	
			  	$lugar_firma=$ins['ficha']->sede_provincia." - ".$ins['ficha']->sede_distrito;
			  	if ($ins['ficha']->sede_distrito==$ins['ficha']->sede_provincia){
					$lugar_firma=$ins['ficha']->sede_distrito;
			  	}

			  	echo "$lugar_firma , $nombredia $numeroDia de $nombreMes de $anio";

			 ?>
			
		</td>
	</tr>
</table>
