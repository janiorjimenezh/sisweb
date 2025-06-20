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
		margin-bottom: 1.5cm;
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
		font-size: 11px;
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
		background-color: lightgray;
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
	.td-rd{
		height: 15px;
		font-size: 10px;
		text-align: left;
	}
</style>
<watermarkimage src="<?php echo base_url().'resources/img/matriculado_iesap_edu_pe.png' ?>" alpha="0.6" position="70,35"  size="D" />
<table class="encabezado">
	<!--<tr>
		
		<td colspan="3" class="td-rd">
			<span>R.M.N° 0568 – 94 ED | </span>
			<span>Revadilación: R.D.N° 079 – 2005 – ED</span>
			<hr style="margin-top: 2px">
		</td>
		
	</tr>-->
	<tr>
		<td>
			<img class="logo-minedu" src="<?php echo base_url().'resources/img/minedu_logo.png' ?>" alt="minedu">
		</td>
		<td valign="bottom"><b></b></td>
		<td width="100px">
			<img class="logo-ies" src="<?php echo base_url().'resources/img/logo_h110.'.getDominio().'.png' ?>" alt="iestcanchaque">
		</td>
	</tr>
	<tr>

		<td colspan="3" valign="bottom" align="center"><br><b><?php echo $ies->denoml ?></b></td>
	</tr>
	<tr>
		<td colspan="3" valign="bottom" align="center">
			<b>FICHA DE REGISTRO DE MATRÍCULA</b></td>
		
	</tr>
</table>
<br>
<table class="encabezado">
	<tr>
		<td class="celda cgris">
			<b><span>Nombre del IESTP</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->snombre ?></span>
		</td>
		<td class="celda cgris">
			<b><span>DRE/GRE</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $sede->sede_dre ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda cgris">
			<b><span>Código modular</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->codmodular ?></span>
		</td>
		<td class="celda cgris">
			<b><span>Tipo de Gestión</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $ies->gestion ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda cgris">
			<b><span>Departamento</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $sede->nomdep ?></span>
		</td>
		<td class="celda cgris">
			<b><span>Provincia</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $sede->nomprov ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda cgris">
			<b><span>Distrito</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $sede->nomdist ?></span>
		</td>
		<td class="celda cgris">
			<b><span>Periodo lectivo</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->periodo ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda cgris">
			<b><span>Programa de estudios</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->carrera ?></span>
		</td>
		<td class="celda cgris">
			<b><span>Periodo académico</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->ciclo ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda cgris">
			<b><span>Plan del programa de estudios</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span>MODULAR</span>
		</td>
		<td class="celda cgris">
			<b><span>Nivel formativo</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->nivel ?></span>
		</td>
	</tr>

	<tr>
		<td class="celda cgris">
			<b><span>Tipo de plan de estudios</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
		<td class="celda cgris">
			<b><span>Periodo de clases</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
	</tr>
	<tr>
		<td class="celda cgris">
			<b><span>DNI N°</span></b>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php echo $mat->dni ?></span>
		</td>
	</tr>
	<tr>
		<td class="celda cgris">
			<b><span>Apellidos y nombres</span></b>
		</td>
		<td colspan="3" class="celda ccenter-nobold">
			<span><?php echo $mat->paterno." ".$mat->materno." ".$mat->nombres ?></span>
		</td>
	</tr>
	
</table>
<br>
<table class="encabezado">

	<tr>
		<td  class="celda ccenter">
			<small>N°</small>
		</td>
		<td  class="celda ccenter">
			<small>UNIDADES DIDACTICAS</small>
		</td>
		
		<td  class="celda ccenter">
			<small>MÓDULO</small>
		</td>
		<td  class="celda ccenter">
			<small>HORAS</small>
		</td>
		<td  class="celda ccenter">
			<small>CRÉDITOS</small>
		</td>
		<td  class="celda ccenter">
			<small>CONDICIÓN</small>
		</td>
	</tr>
	<?php
	$nro=0;
	$isrepite=false;
	$vhoras=0;
	$vcre=0;
	foreach ($curs as $kc => $cur) {
		if ($cur->repite=='NO'){
		$nro++;
		# code...
		
	?>
	<tr>
		<td class="celda ccenter-nobold">
			<span><?php echo $nro ?></span>
		</td>
		<td class="celda">
			<span><?php echo $cur->curso ?></span>
		</td>
		
		<td class="celda ccenter-nobold">
			<span><?php echo $cur->nromodulo ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php 
			$vhoras= $vhoras + $cur->hts + $cur->hps;
			echo $cur->hts + $cur->hps; ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php 
			$vcre= $vcre + $cur->cp + $cur->ct;
			echo $cur->cp + $cur->ct; ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
	</tr>
	<?php 
		unset($curs[$kc]);
		}
		else{
			$isrepite=true;
		}
	} ?>
	<tr>
		<td colspan="2"></td>
		<td class="celda ccenter">
			<span>TOTAL</span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $vhoras ?></span>
		</td>
		<td class="celda ccenter">
			<span><?php echo $vcre ?></span>
		</td>
		<td class="celda ccenter">
			<span></span>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<?php if ($isrepite==true){ ?>
	<tr>
		<td class="texto">REPITENCIA:</td>
	</tr>
	<tr>
		<td  class="celda ccenter">
			<small>N°</small>
		</td>
		<td  class="celda ccenter">
			<small>UNIDADES DIDACTICAS</small>
		</td>
		
		<td  class="celda ccenter">
			<small>MÓDULO</small>
		</td>
		<td  class="celda ccenter">
			<small>HORAS</small>
		</td>
		<td  class="celda ccenter">
			<small>CRÉDITOS</small>
		</td>
		<td  class="celda ccenter">
			<small>CONDICIÓN</small>
		</td>
	</tr>
	<?php
	}
	$nro=0;
	foreach ($curs as $key => $cur) {

		$nro++;
		# code...
	?>
	<tr>
		<td class="celda ccenter-nobold">
			<span><?php echo $nro ?></span>
		</td>
		<td class="celda">
			<span><?php echo $cur->curso ?></span>
		</td>

		<td class="celda ccenter-nobold">
			<span><?php echo $cur->nromodulo ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php 
			echo $cur->hts + $cur->hps; ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span><?php 
			echo $cur->cp + $cur->ct; ?></span>
		</td>
		<td class="celda ccenter-nobold">
			<span></span>
		</td>
	</tr>
	<?php } ?>
</table>
<br>
<table class="encabezado">
	<tr>
		<td class="texto" align="right">
			<?php 
			  $fecha=$mat->fecha;
			  $fechas = substr($fecha, 0, 10);
			  $numeroDia = date('d', strtotime($fechas));
			  $dia = date('w', strtotime($fechas));
			  $mes = date('n', strtotime($fechas));
			  $anio = date('Y', strtotime($fechas));
			  $dias_ES = array("Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
			  //$dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			  $nombredia = $dias_ES[$dia];
			  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			  //$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			  $nombreMes = $meses_ES[$mes-1];
			  

			 ?>
			<?php 


			$lugar_firma=$sede->nomprov." - ".$sede->nomdist;
			if ($sede->nomdist==$sede->nomprov){
				$lugar_firma=$sede->nomdist;
			}

			echo "$lugar_firma , $nombredia $numeroDia de $nombreMes de $anio "; ?>
		</td>
	</tr>
</table>
<table class="encabezado">
	<tr>
		
		
		<td class="firmas ccenter-nobold">
			<br><br><br><br><br><br><br><br><br>
			<!--<img src="<?php echo base_url().'resources/img/firma_sec_academico.charlesashbee.edu.pe.jpg' ?>" alt="MINEDU"><br>-->
			____________________________________
		</td>
		<td class="firmas ccenter-nobold">
			<br><br><br><br><br><br><br><br><br>
			____________________________________
		</td>
	</tr>
	<tr>
		<
		<td class="firmas ccenter-nobold">
			SECRETARÍA ACADÉMICO 	<br>
			Sello, Firma, Posfirma
		</td>
		<td class="firmas ccenter-nobold">
			ESTUDIANTE 	<br>
			
		</td>
	</tr>
</table>