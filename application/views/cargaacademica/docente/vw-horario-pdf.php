<style>
	.div_titledoc {
		width: 100%;
		text-align: center;
	}

	.div_detalle{
		margin-top: -5px;
		width: 100%;
		font-size: 10px;
		font-weight: bold;
	}

	.div_detalle_header {
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border: solid 1px gray;
	}

	.celda-lados{
		height: 15px;
		font-size: 11px;
	}
	
	.cleft-nobold {
		text-align: left;
		margin: auto 10px;
 		padding: 5px;
	}

	.cleft-nobold span {
		/*padding-left: 20px;*/

	}
	
	.ccenter-nobold{
		text-align: center;
		font-weight: bold;
	}

	.right-nobold{
		text-align: right;
		padding-right: 3px;
	}

	.bg-detalle {
		background-color: #BDC3C7;
		color: #fff;
		font-size: 11px;
		height: 25px;
		/*border-radius: 10pt;*/
	}

	.bg_detalle_left {
		background-color: transparent;
		color: #000;
		font-size: 9px;
		height: 20px;
		/*border-radius: 10pt;*/
	}

	.border-bottom {
		/*border-top: #000 1px dotted;*/
		/*border-bottom: #000 2px dotted;*/
		border-bottom: solid 1px gray;
		padding: 2px 0;
	}

	.border-right {
		border-right: solid 1px gray;
	}

	.border-right:last-child {
	    border-right: none!important;
	}

	.tb_resumen .cleft-nobold {
	    padding: 6px 10px;
	    text-transform: uppercase;
	    font-weight: bold;
	}
</style>
<div class="div_titledoc">
	<h5>HORARIO DE CLASES - <?php echo $titulodocente ?></h5>
</div>
<div class="div_detalle div_detalle_header">
	<table  width="100%" align="center" class="encabezado celda-lados" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 10%">Hora</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 15%">LUNES</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 15%">MARTES</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 15%">MIÉRCOLES</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 15%">JUEVES</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 15%">VIERNES</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 15%">SÁBADO</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$arrayDias = array('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO');
		foreach ($horas as $key => $hora) {
			$date = new DateTime($hora->inicia);
			$vhorai= $date->format('h:ia');
			$date = new DateTime($hora->culmina);
			$vhoraf= $date->format('h:ia');?>
			<tr>
				<td class="ccenter-nobold bg_detalle_left border-bottom border-right" style="font-weight: 600;"><?php echo $vhorai."<br>".$vhoraf ?></td>
				<?php foreach ($arrayDias as $key => $dia) { ?>
				<td class="ccenter-nobold bg_detalle_left border-bottom border-right">
					<span><?php echo $horario[$dia][$hora->inicia]["value"];?></span>
				</td>
				<?php } ?>					
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
	<?php if ($_SESSION['userActivo']->tipo == 'AL') {
		
	}else{ ?>
<div class="div_titledoc">
	<h5>RESUMEN</h5>
</div>
<div class="div_detalle div_detalle_header">
	<table width="100%" align="center" class="encabezado celda-lados tb_resumen" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 50%">UNIDAD DIDAC. / ESPECIALIDAD</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 10%">SEMESTRE</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 15%">TURNO</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 15%">AULA</th>
				<th class="ccenter-nobold bg-detalle border-bottom" style="width: 10%">N° HORAS</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$ntothoras = 0;
		foreach ($resumenh as $key => $curso) { 
			$parts = explode(":", $curso->nhoras);
        	$ntothoras += $parts[2] + $parts[1]*60 + $parts[0]*3600;

        	echo "<tr>
        			<td class='cleft-nobold bg_detalle_left border-bottom border-right'>
						<span>$curso->abrev - $curso->nomcurso</span>
					</td>
					<td class='ccenter-nobold bg_detalle_left border-bottom border-right' >
						<span>$curso->ciclo $curso->seccion</span>
					</td>
					<td class='ccenter-nobold bg_detalle_left border-bottom border-right' >
						<span>$curso->turno</span>
					</td>
					<td class='ccenter-nobold bg_detalle_left border-bottom border-right' >
						<span>Ps$curso->hpiso - $curso->naula</span>
					</td>
					<td class='ccenter-nobold bg_detalle_left border-bottom border-right' >
						<span>$curso->nhoras</span>
					</td>
        		</tr>";

        }

        $partsrpta = explode(":", gmdate("H:i:s", $ntothoras));
        $vhortotal = "0";
        $vmintotal = "";
        if ($partsrpta[0] != 0) {
        	$vhortotal = $partsrpta[0]."Hr";
        }

        if ($partsrpta[1] != 0) {
        	$vmintotal = $partsrpta[1]."Min";
        }

        echo "<tr>
				<td colspan='4' class='ccenter-nobold border-right bg_detalle_left'>TOTAL DE HORAS </td>
				<td class='ccenter-nobold bg_detalle_left'>$vhortotal $vmintotal</td>
			</tr>";
		?>
			
		</tbody>
	</table>
</div>
<?php } ?>
