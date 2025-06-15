<!--$fechas
$asistencias
$sesiones
$evaluaciones
$notas
$miembros
$curso-->
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
	}

	.logo-ies{
		height:  50px;
	}
	.celda{
		height: 20px;
		padding: 5px;
		border: solid 1px black;
		font-size: 12px;
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

	.border-bottom {
		/*border-bottom: #000 1px dashed;*/
		border-bottom: #000 2px dotted;
		padding: 2px 0;
	}
	.text-uppercase {
		text-transform: uppercase;
	}
</style>

<table class="encabezado">
	<tr>
		<td>
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_facturacion.'.getDominio().'.png' ?>" alt="iestcanchaque">
		</td>
		<td valign="bottom" class="ccenter-nobold">
			<img class="logo-minedu" src="<?php echo base_url().'resources/img/minedu_logo.png' ?>" alt="minedu"><br><br>
			
		</td>
		<td class="celda" width="100px" rowspan="2">
			
		</td>
		
	</tr>
	<tr>
		<td colspan="2" align="center">
			<br>
			<b>FICHA DE INSCRIPCIÓN DEL POSTULANTE</b>
		</td>
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		<td class="celda cgris">
			<b><span>PERIODO LECTIVO</span></b>
		</td>
		<td class="celda">
			<b><span><?php echo $ins->periodo ?></span></b>
		</td>
		<td class="celda cgris">
			<b><span>CAMPAÑA</span></b>
		</td>
		<td class="celda">
			<b><span><?php echo $ins->campania ?></span></b>
		</td>
		<td align="right" style="width: 20%">
		</td>
		<td class="celda cgris">
			<b><span>CARNÉ</span></b>
		</td>
		<td class="celda">
			<b><span><?php echo $ins->carnet ?></span></b>
		</td>
	</tr>
</table>
<!-- <br> -->
<table class="encabezado" style="margin-top: 10px;">
	<tr>
		<td colspan="2" class="celda cgris w25p">
			<span>Nombre del IES/EIEST</span>
		</td>
		<td colspan="2" class="celda ccenter w25p">
			<span><?php echo $ies->snombre ?></span>
		</td>
		<td colspan="2" class="celda cgris w25p">
			<span>Código modular</span>
		</td>
		<td colspan="2" class="celda ccenter w25p">
			<span><?php echo $ies->codmodular ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Tipo gestión</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->gestion ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>DRE/GRE</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ies->dre ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda cgris">
			<span>Resolución de licenciamiento y/o autorización</span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ies->resolucion ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda cgris">
			<span>Resolución de renovación y/o revalidación</span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ies->revalidacion ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda cgris">
			<span>Lugar donde se presenta el servicio educativo:</span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ins->sedetipo ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Departamento:</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins->sede_departamento ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>DRE/GRE</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins->sede_dre ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Provincia:</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins->sede_provincia ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>Distrito: </span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins->sede_distrito ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Centro Poblado:</span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins->sede_centropoblado ?></span>
		</td>
		<td colspan="2" class="celda cgris">
			<span>Telefono: </span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins->sede_telefonos ?></span>
		</td>
	</tr>
	<tr>
		
		<td colspan="4" class="celda cgris ccenter-nobold">
			<span>Correo Electrónico:</span>
		</td>
		<td colspan="4" class="celda cgris ccenter-nobold">
			<span>Página Web</span>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ins->sede_eadmision ?></span>
		</td>
		<td colspan="4" class="celda ccenter">
			<span><?php echo $ies->web ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Programa de estudio: </span>
		</td>
		<td colspan="6" class="celda ccenter text-small-9">
			<span><?php echo $ins->carrera ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda cgris">
			<span>Nivel formativo: </span>
		</td>
		<td colspan="2" class="celda ccenter">
			<span><?php echo $ins->nivelformativo ?></span>
		</td>
		<td colspan="1" class="celda cgris">
			<span>Semestre: </span>
		</td>
		<td colspan="1" class="celda ccenter">
			<span><?php echo $ins->ciclo ?></span>
		</td>
		<td colspan="1" class="celda cgris">
			<span>Turno: </span>
		</td>
		<td colspan="1" class="celda ccenter">
			<span><?php echo $ins->turno ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="8" class="celda text-small-9">
			Adjunta:
			<?php 
			$docadjunto = "";
			foreach ($adjuntos as $key => $ajt) {
				$docadjunto = $docadjunto."$ajt->documento,";
				
			} 
			echo substr($docadjunto,0,-1);
			?>
		</td>
	</tr>
</table>
<!-- <br> -->
<table class="encabezado" style="margin-top: 10px;">
	<tr>
		<td colspan="8" class="celda cgris ccenter">
			<span>DATOS DEL POSTULANTE</span>
		</td>

	</tr>
	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>APELLIDO PATERNO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>APELLIDO MATERNO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>NOMBRES</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>SEXO</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->paterno ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->materno ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->nombres ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->sexo ?></span>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>FECHA DE NACIMIENTO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>DOCUMENTO DE IDENTIDAD</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>EDAD</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>LUGAR DE NACIMIENTO</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span>
				<?php 
				$tiempo = strtotime($ins->fecnac); 
				echo date("d | m  | Y", $tiempo); ?>
					
				</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->tipodoc." - ".$ins->nrodoc ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span>
				<?php 
				    $ahora = time(); 
				    $edad = ($ahora-$tiempo)/(60*60*24*365.25); 
				    $edad = floor($edad); 
				    echo $edad;
				 ?>
			</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->lugarnac ?></span>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>PAIS</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>DISTRITO</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>PROVINCIA</span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>REGIÓN</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->pais ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->distrito ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->provincia ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->departamento ?></span>
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
			<span><?php echo $ins->domicilio ?></span>
		</td>
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->trabaja ?></span>
		</td>
	</tr>

	<tr>
		
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>ESTADO CIVIL</span>
		</td>
		<td colspan="3" class="celda cgris ccenter text-small-9">
			<span>TELEFONO</span>
		</td>
		<td colspan="3" class="celda cgris ccenter text-small-9">
			<span>CORREO ELECTRÓNICO</span>
		</td>
	</tr>
	<tr>
		
		<td colspan="2" class="celda ccenter-nobold">
			<span><?php echo $ins->estadocivil ?></span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span>
			<?php

			 echo trim($ins->telefono." ".$ins->celular) ?></span>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><?php echo $ins->email ?></span>
		</td>
	</tr>
	<tr>
		
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>COLEGIO 5° SEC.</span>
		</td>
		<td colspan="6" class="celda ccenter-nobold">
			<span><?php echo $ins->colegio5to ?></span>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>APELLIDOS Y NOMBRES PADRE</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold text-small-9">
			<span class="text-uppercase"><?php echo $ins->padre ?></span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>APELLIDOS Y NOMBRES MADRE</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold text-small-9">
			<span class="text-uppercase"><?php echo $ins->madre ?></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>OCUPACIÓN PADRE</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold text-small-9">
			<span class="text-uppercase"><?php echo $ins->ocupapadre ?></span>
		</td>
		<td colspan="2" class="celda cgris ccenter text-small-9">
			<span>OCUPACIÓN MADRE</span>
		</td>
		<td colspan="2" class="celda ccenter-nobold text-small-9">
			<span class="text-uppercase"><?php echo $ins->ocupamadre ?></span>
		</td>
	</tr>
	<tr><td colspan="8" height="6px"></td></tr>
	<tr>
		<td colspan="1" class="texto">
			<b><span>Observaciones:</span></b>
		</td>
		<td colspan="7" class="border-bottom text-small-9" &nbsp;><?php echo $ins->observacion ?></td>
	</tr>
	
	<tr><td colspan="8" class="border-bottom">&nbsp;</td></tr>
	<tr><td colspan="8" class="border-bottom">&nbsp;</td></tr>
	
</table>
<br>
<!-- <br> -->
<table class="encabezado">
	<tr>
		<td class="texto" align="right">
			<?php 
			  $fecha=$ins->fecinsc;
			  $fecha = substr($fecha, 0, 10);
			  $numeroDia = date('d', strtotime($fecha));
			  $dia = date('w', strtotime($fecha));
			  $mes = date('n', strtotime($fecha)) - 1;
			  $anio = date('Y', strtotime($fecha));
			  $dias_ES = array("Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
			  //$dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			  $nombredia = $dias_ES[$dia];
			  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			  //$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			  $nombreMes = $meses_ES[$mes];
			  

			 ?>
			<?php 
			$lugar_firma=$ins->sede_provincia." - ".$ins->sede_distrito;
			if ($ins->sede_distrito==$ins->sede_provincia){
				$lugar_firma=$ins->sede_distrito;
			}

			echo "$lugar_firma , $nombredia $numeroDia de $nombreMes de $anio"; ?>
		</td>
	</tr>
</table>
<br>
<!-- <br> -->
<table class="encabezado">
	<tr>
		
		<td class="firmas ccenter-nobold">
			____________________________________
		</td>
		<td class="firmas ccenter-nobold">
			____________________________________
		</td>
	</tr>
	<tr>

		<td class="firmas ccenter-nobold">
			Secretario académico 	<br>
			Sello, Firma, Posfirma
		</td>
		<td class="firmas ccenter-nobold">
			Postulante 	<br>
			
		</td>
	</tr>
</table>