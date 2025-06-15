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
		height:  60px;
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
		margin-top: -10px;
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
		margin-top: 5px;
		float: left;
		width: 62%;
		border: 0px;
		-moz-border: 0px;
		-webkit-border: 0px;
		font-size: 16px;
		font-weight: bold;
		padding: 5px;

	}
	.div_cliente2{
		
		float: right;
		width: 33%;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		font-size: 16px;
		font-weight: bold;
		border: solid 1px gray;
		padding: 5px;

	}
	.div_observacion{
		margin-top: 5px;
		float: left;
		width: 78%;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		font-size: 16px;
		border: solid 1px gray;
		padding: 5px;

	}
	.div_qr{
		
		float: right;
		width: 15%;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		font-size: 16px;
		font-weight: bold;
		border: solid 1px gray;
		padding: 5px;
		text-align: center;

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

	.text-danger {
		color: red;
	}


</style>
<?php
	$fechahoy = date("d/m/Y");
	$horahoy = date("h:i:s a");
	
?>
<div class="div_logo">
	<img class="logo-ies mb" src="<?php echo base_url().'resources/img/logo_facturacion.'.getDominio().'.png' ?>" alt="Logo de Facturación"><br>
</div>

<div class="div_datedoc">
	<table class="text-small-4" cellpadding="0">
		<tr>
			<td colspan="3"><b>Fecha </b></td>
			<td>: <?php echo $fechahoy ?></td>
		</tr>
		<tr>
			<td colspan="3"><b>Hora </b></td>
			<td>: <?php echo $horahoy ?></td>
		</tr>
	</table>
</div>

<!-- <div class="div_titledoc">
	<h5>COMPROBANTE DE VENTA EMITIDOS</h5>
</div>

<div class="div_fechareport">
	<span class="text-small-5"><?php echo "del ".date_format(date_create($emision),"d/m/Y")."   al ".date_format(date_create($emisionf),"d/m/Y"); ?></span>
</div>

<div class="div_filial">
	<table class="text-small-5" cellpadding="0">
		<tr>
			<td colspan="2"><b>FILIAL</b></td>
			<td>: <?php //echo $_SESSION['userActivo']->sede ?></td>
		</tr>			
		
	</table>
</div> -->
<?php
$nro=0;
$mtotal=0;
$mefectivo=0;
$mbanco=0;
$grupo="";
$docsAcumulada=0;
$filnotas = "";
$nronotasc = 0;
foreach ($docpagos as $kdoc => $mat) {
	$grupoint= $mat->sede;
    if ($grupo!=$grupoint){
        if ($docsAcumulada > 0) {
        	echo "</table></div>
        	<div class='div_detalle div_detalle_header mb padding'>
				<table class='encabezado celda-lados' cellpadding='0' cellspacing='0'>
					<tr>
						<td cla colspan='2'></td>
						<td cla width='70%'  align='right'>Total Emitido</td>
						<td cla align='right' class='right-nobold'><span>S/.</span></td>
						<td cla align='right' class='right-nobold'>
							<span>".number_format($mtotal, 2, '.', '')."</span>
						</td>
					</tr>
					<tr>
						<td colspan='2'></td>
						<td align='right'>Total Efectivo</td>
						<td align='right' class='right-nobold'><span>S/.</span></td>
						<td align='right' class='right-nobold '>
							<span>".number_format($mefectivo, 2, '.', '')."</span>
						</td>
					</tr>
					<tr>
						<td colspan='2'></td>
						<td align='right'>Total Banco</td>
						<td align='right' class='right-nobold'><span>S/.</span></td>
						<td align='right' class='right-nobold '>
							<span>".number_format($mbanco, 2, '.', '')."</span>
						</td>
					</tr>
					<tr>
						<td colspan='2'></td>
						<td align='right'>Otros Doc. Valor</td>
						<td align='right' class='right-nobold'><span>S/.</span></td>
						<td align='right' class='right-nobold '>
							<span>".number_format($mtotal - ($mefectivo + $mbanco), 2, '.', '')."</span>
						</td>
					</tr>
				</table>
			</div>";
			// NOTAS DE CREDITO
			if ($nronotasc > 0) {
				echo "<div class='div_titledoc'>
					<h5>NOTAS DE CRÉDITO EMITIDAS</h5>
				</div>

				<div class='div_fechareport'>
					<span class='text-small-5'>del ".date_format(date_create($emision),"d/m/Y")."   al ".date_format(date_create($emisionf),"d/m/Y")."</span>
				</div>
				<div class='div_filial'>
					<table class='text-small-5' cellpadding='0'>
						<tr>
							<td colspan='2'><b>FILIAL</b></td>
							<td>: $filnotas</td>
						</tr>			
						
					</table>
				</div>
				<div class='div_detalle div_detalle_header'>
					<table class='encabezado celda-lados' cellpadding='0' cellspacing='0' >
						<tr>
							<td class='ccenter-nobold bg-detalle' width='50px'>
								<b>N°</b>
							</td>
							<td class='ccenter-nobold bg-detalle' width='80px'>
								<b>COMPROBANTE</b>
							</td>
							<td colspan='2' class='cleft-nobold bg-detalle'>
								<b>CLIENTE</b>
							</td>
							<td class='ccenter-nobold bg-detalle' width='40px'>
								<b>EST</b>
							</td>
							<td class='ccenter-nobold bg-detalle' width='70px'>
								<b>EMISIÓN</b>
							</td>
							<td class='ccenter-nobold right-nobold bg-detalle' width='70px'>
								<b>MONTO</b>
							</td>
						</tr>
					</table>
				</div>
				<div class='div_detalle mb margin-top'>
					<table class='encabezado celda-lados' cellpadding='0' cellspacing='0' >";
				$nronot=0;
				$itemdnot=0;
		        $mtotalnot=0;
		        $mefectivonot=0;
		        $mbanconot=0;
		        $gruponot = "";
		        $sednotas = "";
		        
		        foreach ($docpagos as $matn) {
		        	if ($sednotas == 0) {
		        		$mtotalnot=0;
		        	}
	        		if (($matn->tipodoc=="NF") || ($matn->tipodoc=="NB") && ($filnotas == $matn->nomsede)){
			        	$nronot++;
			        	$vestadonot="";
			        	$sednotas = $nronot;
			        	$textcolor = "";
			        	if (($matn->estado=="ANULADO") || ($matn->estado=="RECHAZADO")){
							$matn->total=0;
			           		$matn->efectivo=0;
			            	$matn->banco=0;
			            	$vestadonot=($matn->estado=="ANULADO") ? "AN" : "RECH";
			            	$textcolor = "text-danger";
			            }

			            echo "<tr>
							<td class='border-bottom ccenter-nobold' width='70px'>$nronot</td>
							<td class='border-bottom ccenter-nobold $textcolor' width='80px'>$matn->serie-".str_pad($matn->numero, 6, "0", STR_PAD_LEFT) ."</td>
							<td class='border-bottom cleft-nobold'>$matn->pagantenrodoc $matn->pagante </td>
							<td class='border-bottom right-nobold text-small-5' width='40px'>$vestadonot </td>
							<td class='border-bottom right-nobold' width='70px'>".date_format(date_create($matn->fecha_hora),"d/m/Y") ."</td>
							<td class='border-bottom right-nobold' width='70px'>$matn->total</td>
						</tr>";
						foreach ($detalle as $keydn => $valdtn) {
							if ($valdtn->iddocp == $matn->codigo) {
								if ($matn->estado=="ANULADO"){
					                $valdtn->mpunit=0;
					            }
					            echo "<tr class='item_detalle'>
									<td class='border-bottom ccenter-nobold' width='70px'></td>
									<td class='border-bottom ccenter-nobold' width='80px'>$valdtn->cantidad</td>
									<td colspan='2' class='border-bottom cleft-nobold'>$valdtn->gestid $valdtn->gestion</td>
									<td class='border-bottom right-nobold' width='70px'>".number_format($valdtn->mpunit, 2, '.', '') ."</td>
									<td class='border-bottom right-nobold' width='70px'></td>
								</tr>";
								unset($detalle[$keydn]);
					        }
					    }

						$mtotalnot=$mtotalnot +  $matn->total;
				        $mefectivonot=$mefectivonot + $matn->efectivo;
				        $mbanconot=$mbanconot + $matn->banco;
				        // unset($docpagos[$kdoc]);

					}
					else {
						$nronot=0;
					}
				}
				echo "</table></div>
				<div class='div_detalle div_detalle_header mb padding'>
					<table class='encabezado celda-lados' cellpadding='0' cellspacing='0'>
						<tr>
							<td cla colspan='2'></td>
							<td cla width='70%'  align='right'>Total Emitido</td>
							<td cla align='right' class='right-nobold'><span>S/.</span></td>
							<td cla align='right' class='right-nobold'>
								<span>".number_format($mtotalnot, 2, '.', '')."</span>
							</td>
						</tr>
					</table>
				</div>";
			}
			// FIN NOTAS CREDITO
			echo "<pagebreak>";
        }
        $grupo=$grupoint;
        echo "
        <div class='div_titledoc'>
			<h5>COMPROBANTE DE VENTA EMITIDOS</h5>
		</div>

		<div class='div_fechareport'>
			<span class='text-small-5'>
				del ".date_format(date_create($emision),"d/m/Y")."   al ".date_format(date_create($emisionf),"d/m/Y")."</span>
		</div>
        <div class='div_filial'>
        	<table class='text-small-5' cellpadding='0'>
				<tr>
					<td colspan='2'><b>FILIAL</b></td>
					<td>: $mat->nomsede</td>
				</tr>			
				
			</table>
        </div>
        <div class='div_detalle div_detalle_header'>
			<table class='encabezado celda-lados' cellpadding='0' cellspacing='0' >
				<tr>
					<td class='ccenter-nobold bg-detalle' width='70px'>
						<b>N°</b>
					</td>
					<td class='ccenter-nobold bg-detalle' width='80px'>
						<b>COMPROBANTE</b>
					</td>
					<td colspan='2' class='cleft-nobold bg-detalle'>
						<b>CLIENTE</b>
					</td>
					<td class='ccenter-nobold bg-detalle' width='40px'>
						<b>EST</b>
					</td>
					<td class='ccenter-nobold bg-detalle' width='70px'>
						<b>EMISIÓN</b>
					</td>
					<td class='ccenter-nobold right-nobold bg-detalle' width='70px'>
						<b>MONTO</b>
					</td>
				</tr>
			</table>
		</div>
		<div class='div_detalle mb margin-top'>
			<table class='encabezado celda-lados' cellpadding='0' cellspacing='0' >";
		$nro=0;
        $docsAcumulada = 0;
        $mtotal = 0;
        $mefectivo = 0;
        $mbanco = 0;
        $filnotas = "";
        $nronotasc = 0;
    }

    if (($mat->tipodoc=="FC") || ($mat->tipodoc=="BL")){
		$nro++;
		$docsAcumulada = $nro;
		$vestado="";
		$filnotas = $mat->nomsede;
	    if ($mat->estado=="ANULADO"){
	        $mat->total=0;
	        $mat->efectivo=0;
	        $mat->banco=0;
	        $vestado="AN";
	    }
	    echo "<tr>
			<td class='border-bottom ccenter-nobold' width='70px'>$nro</td>
			<td class='border-bottom ccenter-nobold' width='80px'>$mat->serie-".str_pad($mat->numero, 6, "0", STR_PAD_LEFT) ."</td>
			<td class='border-bottom cleft-nobold'>$mat->pagantenrodoc $mat->pagante </td>
			<td class='border-bottom right-nobold text-small-5' width='40px'>$vestado </td>
			<td class='border-bottom right-nobold' width='70px'>".date_format(date_create($mat->fecha_hora),"d/m/Y") ."</td>
			<td class='border-bottom right-nobold' width='70px'>$mat->total</td>
		</tr>";
		foreach ($detalle as $keyd => $valdt) {
			if ($valdt->iddocp == $mat->codigo) {
				if ($mat->estado=="ANULADO"){
	                $valdt->mpunit=0;
	            }
	            echo "<tr class='item_detalle'>
					<td class='border-bottom ccenter-nobold' width='70px'></td>
					<td class='border-bottom ccenter-nobold' width='80px'>$valdt->cantidad</td>
					<td colspan='2' class='border-bottom cleft-nobold'>$valdt->gestid $valdt->gestion</td>
					<td class='border-bottom right-nobold' width='70px'>".number_format($valdt->mpunit, 2, '.', '') ."</td>
					<td class='border-bottom right-nobold' width='70px'></td>
				</tr>";
				unset($detalle[$keyd]);
	        }
	    }
		// echo "<tr class='item_detalle'>
		// 	<td class='border-bottom ccenter-nobold' width='70px'></td>
		// 	<td class='border-bottom ccenter-nobold' width='80px'></td>
		// 	<td colspan='2' class='border-bottom cleft-nobold'></td>
		// 	<td class='border-bottom right-nobold' width='70px'></td>
		// 	<td class='border-bottom right-nobold' width='70px'></td>
		// </tr>";

		$mtotal=$mtotal +  $mat->total;
	    $mefectivo=$mefectivo + $mat->efectivo;
	    $mbanco=$mbanco + $mat->banco;
	    unset($docpagos[$kdoc]);
	}

	if (($mat->tipodoc=="NF") || ($mat->tipodoc=="NB")){
    	$nronotasc++;
    }
}
if ($docsAcumulada > 0) {
	echo "</table></div>
	<div class='div_detalle div_detalle_header mb padding'>
		<table class='encabezado celda-lados' cellpadding='0' cellspacing='0'>
			<tr>
				<td cla colspan='2'></td>
				<td cla width='70%'  align='right'>Total Emitido</td>
				<td cla align='right' class='right-nobold'><span>S/.</span></td>
				<td cla align='right' class='right-nobold'>
					<span>".number_format($mtotal, 2, '.', '')."</span>
				</td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td align='right'>Total Efectivo</td>
				<td align='right' class='right-nobold'><span>S/.</span></td>
				<td align='right' class='right-nobold '>
					<span>".number_format($mefectivo, 2, '.', '')."</span>
				</td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td align='right'>Total Banco</td>
				<td align='right' class='right-nobold'><span>S/.</span></td>
				<td align='right' class='right-nobold '>
					<span>".number_format($mbanco, 2, '.', '')."</span>
				</td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td align='right'>Otros Doc. Valor</td>
				<td align='right' class='right-nobold'><span>S/.</span></td>
				<td align='right' class='right-nobold '>
					<span>".number_format($mtotal - ($mefectivo + $mbanco), 2, '.', '')."</span>
				</td>
			</tr>
		</table>
	</div>";
	// NOTAS DE CREDITO
	if ($nronotasc > 0) {
		echo "<div class='div_titledoc'>
			<h5>NOTAS DE CRÉDITO EMITIDAS</h5>
		</div>

		<div class='div_fechareport'>
			<span class='text-small-5'>del ".date_format(date_create($emision),"d/m/Y")."   al ".date_format(date_create($emisionf),"d/m/Y")."</span>
		</div>
		<div class='div_filial'>
			<table class='text-small-5' cellpadding='0'>
				<tr>
					<td colspan='2'><b>FILIAL</b></td>
					<td>: $filnotas</td>
				</tr>			
				
			</table>
		</div>
		<div class='div_detalle div_detalle_header'>
			<table class='encabezado celda-lados' cellpadding='0' cellspacing='0' >
				<tr>
					<td class='ccenter-nobold bg-detalle' width='50px'>
						<b>N°</b>
					</td>
					<td class='ccenter-nobold bg-detalle' width='80px'>
						<b>COMPROBANTE</b>
					</td>
					<td colspan='2' class='cleft-nobold bg-detalle'>
						<b>CLIENTE</b>
					</td>
					<td class='ccenter-nobold bg-detalle' width='40px'>
						<b>EST</b>
					</td>
					<td class='ccenter-nobold bg-detalle' width='70px'>
						<b>EMISIÓN</b>
					</td>
					<td class='ccenter-nobold right-nobold bg-detalle' width='70px'>
						<b>MONTO</b>
					</td>
				</tr>
			</table>
		</div>
		<div class='div_detalle mb margin-top'>
			<table class='encabezado celda-lados' cellpadding='0' cellspacing='0' >";
		$nronot=0;
		$itemdnot=0;
        $mtotalnot=0;
        $mefectivonot=0;
        $mbanconot=0;
        $gruponot = "";
        $sednotas = "";
        
        foreach ($docpagos as $matn) {
        	if ($sednotas == 0) {
        		$mtotalnot=0;
        	}
    		if (($matn->tipodoc=="NF") || ($matn->tipodoc=="NB") && ($filnotas == $matn->nomsede)){
	        	$nronot++;
	        	$vestadonot="";
	        	$sednotas = $nronot;
	        	$textcolor = "";
	        	if (($matn->estado=="ANULADO") || ($matn->estado=="RECHAZADO")){
					$matn->total=0;
	           		$matn->efectivo=0;
	            	$matn->banco=0;
	            	$vestadonot=($matn->estado=="ANULADO") ? "AN" : "RECH";
	            	$textcolor = "text-danger";
	            }

	            echo "<tr>
					<td class='border-bottom ccenter-nobold' width='70px'>$nronot</td>
					<td class='border-bottom ccenter-nobold $textcolor' width='80px'>$matn->serie-".str_pad($matn->numero, 6, "0", STR_PAD_LEFT) ."</td>
					<td class='border-bottom cleft-nobold'>$matn->pagantenrodoc $matn->pagante </td>
					<td class='border-bottom right-nobold text-small-5' width='40px'>$vestadonot </td>
					<td class='border-bottom right-nobold' width='70px'>".date_format(date_create($matn->fecha_hora),"d/m/Y") ."</td>
					<td class='border-bottom right-nobold' width='70px'>$matn->total</td>
				</tr>";
				foreach ($detalle as $keydn => $valdtn) {
					if ($valdtn->iddocp == $matn->codigo) {
						if ($matn->estado=="ANULADO"){
			                $valdtn->mpunit=0;
			            }
			            echo "<tr class='item_detalle'>
							<td class='border-bottom ccenter-nobold' width='70px'></td>
							<td class='border-bottom ccenter-nobold' width='80px'>$valdtn->cantidad</td>
							<td colspan='2' class='border-bottom cleft-nobold'>$valdtn->gestid $valdtn->gestion</td>
							<td class='border-bottom right-nobold' width='70px'>".number_format($valdtn->mpunit, 2, '.', '') ."</td>
							<td class='border-bottom right-nobold' width='70px'></td>
						</tr>";
						unset($detalle[$keydn]);
			        }
			    }

				$mtotalnot=$mtotalnot +  $matn->total;
		        $mefectivonot=$mefectivonot + $matn->efectivo;
		        $mbanconot=$mbanconot + $matn->banco;
		        // unset($docpagos[$kdoc]);

			}
			else {
				$nronot=0;
			}
		}
		echo "</table></div>
		<div class='div_detalle div_detalle_header mb padding'>
			<table class='encabezado celda-lados' cellpadding='0' cellspacing='0'>
				<tr>
					<td cla colspan='2'></td>
					<td cla width='70%'  align='right'>Total Emitido</td>
					<td cla align='right' class='right-nobold'><span>S/.</span></td>
					<td cla align='right' class='right-nobold'>
						<span>".number_format($mtotalnot, 2, '.', '')."</span>
					</td>
				</tr>
			</table>
		</div>";
	}
	// FIN NOTAS CREDITO
}
?>

