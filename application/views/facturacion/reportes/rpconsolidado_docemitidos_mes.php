<style>
	@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,500&display=swap');
	@page {
		margin: 0;
		
	}
	.div_logo{
		float: left;
		border:0;
		width: 70%;
	}
	.logo-ies{
		height:  40px;
	}
	.div_datedoc {
		padding: 5px;
		float: right;
		width: 20%;
		font-size: 16px;
		font-weight: bold;
		/*text-align: right;*/
		border: solid 1px gray;
		border: none;
		-moz-border: none;
		-webkit-border: none;
	}

	.div_titledoc {
		margin-top: 5px;
		float: left;
		width: 100%;
		text-align: center;
	}

	.div_fechareport {
		
		margin-top: -7px;
		float: left;
		width: 100%;
		text-align: center;
	}

	.div_emisor{
		padding: 5px;
		float: right;
		width: 30%;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		font-size: 16px;
		font-weight: bold;
		text-align: center;
		border: solid 1px gray;

	}
	.div_filial{
		margin-top: 0px;
		float: left;
		width: 62%;
		border: 0px;
		-moz-border: 0px;
		-webkit-border: 0px;
		font-size: 16px;
		font-weight: bold;
		padding: 5px;

	}

	.div_detalle{
		
		margin-top: 5px;
		width: 100%;
		font-size: 10px;

	}

	.div_detalle_header {
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border: solid 1px gray;
	}

	.mb{
		margin-bottom: 5px;
	}
	.encabezado{
		width: 100%;
		border-collapse: collapse;

	}
	
	.margin-top{
		margin-top: 5px;
	}
	.text-small-5 {
		font-size: 10px;
	}
	.text-small-4 {
		font-size: 9px;
	}
	
	
	.celda-lados{
		height: 15px;
		font-size: 11px;
	}
	
	.cleft-nobold {
		text-align: left;
		padding-left: 20px;
	}
	
	.ccenter-nobold{
		text-align: center;
	}
	.right-nobold{
		text-align: right;
		padding-right: 3px;
	}
	.w25p{
		width: 5cm;
	}
	.text-footer {
		font-style: italic;
		font-size: 11px;
	}
	.bg-detalle {
		background-color: #BDC3C7;
		color: #fff;
		font-size: 11px;
		height: 25px;
		/*border-radius: 10pt;*/
	}
	.border-top{
		border-top: 0.5px solid gray;
	}

	.border-bottom {
		/*border-top: #000 1px dotted;*/
		border-bottom: #000 2px dotted;
		padding: 2px 0;
	}

	.margin-top {
		margin-top: 1px;
	}

	.padding {
		padding: 5px 0;
	}
	.text-danger{
		color:red;
	}

	.div_grupo {
		padding: 10px;
	}


</style>
<?php
	$fechahoy = date("d/m/Y");
	$horahoy = date("h:i:s a");

	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
?>
<div class="div_logo">
	<img class="logo-ies mb" src="<?php echo base_url().'resources/img/logo_facturacion.'.getDominio().'.png' ?>" alt="Logo de Facturación"><br>
</div>

<div class="div_datedoc">
	<table width="100%" class="text-small-4" cellpadding="0" >
		<tr>
			<td><b>Fecha </b></td>
			<td><b>:</b></td>
			<td align="right"><?php echo $fechahoy ?></td>
		</tr>
		<tr>
			<td><b>Hora </b></td>
			<td><b>:</b></td>
			<td align="right"><?php echo $horahoy ?></td>
		</tr>
	</table>
</div>

<div class="div_titledoc">
	<h5>CONSOLIDADO DE DOCUMENTOS EMITIDOS POR MES</h5>
</div>

<div class="div_fechareport">
	<span class="text-small-5"><?php echo ($anio != "") ? "Año :".$anio : "" ?></span>
</div>

<div class="div_detalle mb margin-top">
<table class="encabezado celda-lados" cellpadding="0" cellspacing="0" >
	<?php
		
		$grupo = "";
		$nro = 0;
		foreach ($docpagos as $key => $doc) {
			$agrupacion = $doc->sede;
			
			
			if ($agrupacion != $grupo) {
				// if($grupo!="") echo "</tr>";
				$grupo = $agrupacion;
				$nro = 0;
				echo "<tr><td class='div_grupo'><b>$grupo</b></td></tr>
					<div class='div_detalle div_detalle_header'>
						<tr>
							<td class='ccenter-nobold bg-detalle' width='50px'>
								<b>N°</b>
							</td>
							<td class='ccenter-nobold bg-detalle' >
								<b>MES</b>
							</td>
							<td colspan='2' class='ccenter-nobold bg-detalle'>
								<b>MEDIO</b>
							</td>
							<td  class='ccenter-nobold bg-detalle' >
								<b>DOCUMENTO</b>
							</td>
							<td class='ccenter-nobold bg-detalle' >
								<b>SERIE</b>
							</td>
							<td class='ccenter-nobold right-nobold bg-detalle' >
								<b>MONTO</b>
							</td>
						</tr>
					</div>";
			}
			$nro++;

			echo "<tr>
				<td class='border-bottom text-small-5 ccenter-nobold' width='50px'>$nro</td>
					<td class='border-bottom text-small-5 ccenter-nobold' >".$meses[$doc->mes-1]."</td>
					<td class='border-bottom text-small-5 ccenter-nobold' colspan='2'>$doc->medio</td>
					<td class='border-bottom text-small-5 ccenter-nobold' >$doc->tipodoc</td>
					<td class='border-bottom text-small-5 ccenter-nobold' >$doc->serie</td>
					<td class='border-bottom text-small-5 ccenter-nobold right-nobold' >".number_format ($doc->monto,2)."</td>
				</tr>";
		}
	?>
	
	
</table>
</div>

<!-- <pagebreak>  -->

