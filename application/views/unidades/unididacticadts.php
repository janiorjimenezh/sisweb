<?php if(count($unidades) > 0) { ?>
<div id="divtabl_plan" class="col-12 btable">
	<div class="col-12 thead d-none d-md-block">
		<div class="row">
			<div class="col-12 col-md-3">
				<div class="row">
					<div class="col-sm-6 col-md-2 td text-right">
						<span>N°</span>
					</div>
					<div class="col-sm-6 col-md-8 td">
						<span>UNIDAD DID.</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-2">
				<div class="row">
					<div class="col-sm-6 col-md-9 td">
						<span>TIPO</span>
					</div>
					<div class="col-sm-6 col-md-3 td">
						<span>SEM.</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-3">
				<div class="row">
					<div class="col-sm-6 col-md-2 td">
						<span>HT</span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span>HP</span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span>Hrs</span>
					</div>
					
					<div class="col-sm-6 col-md-2 td">
						<span>CT</span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span>CP</span>
					</div>
					<div class="col-sm-6 col-md-2 td">
						<span>Cdts</span>
					</div>
				</div>
			</div>
			
			<div class="col-12 col-md-3 td">
				
				<span>MÓDULO</span>
				
			</div>
			<div class="col-12 col-md-1">
				
			</div>
		</div>
	</div>
	<div class="col-md-12 tbody" id="divdata_unidades">
		<?php
		$nro=0;
		foreach ($unidades as $dts) {
		$nro++;
		$codund64 = base64url_encode($dts->id);
		switch ($dts->unitip) {
			case 'C':
				$nomtip = 'COMP. ESPECÍFICA';
				break;
			case 'T':
				$nomtip = 'TRANSVERSAL';
				break;
			case 'E':
				$nomtip = 'EMPLEABILIDAD';
				break;
			case 'L':
				$nomtip = 'LIBRE';
				break;
			case 'EFSRT':
				$nomtip = 'EFSRT';
				break;
			case 'DEMOS':
				$nomtip = 'DEMOS';
				break;
			case 'ESPEC':
				$nomtip = 'COMP. ESPECÍFICA';
				break;
			case 'EMPLB';
				$nomtip = 'COMP. PARA LA EMPLEABILIDAD';
				break;
			case 'EXTRA';
				$nomtip = 'EXTRACURRICULAR';
				break;
			default:
				$nomtip = 'COMP. PARA LA EMPLEABILIDAD';
				break;
		}

		if($dts->activo == 'SI') {
			$vflat="desactivarunidad";
            $vtitle="<b>Desactivar</b>";
            $vicon="fa fa-toggle-on";
            $btncolor="btn-success btn-sm";
            $accion= "NO";
            $estado="Habilitado";
		} else {
			$vflat="activarunidad";
            $vtitle="<b>Activar</b>";
            $vicon="fa fa-toggle-off";
            $btncolor="btn-danger btn-sm";
           	$accion= "SI";
            $estado="Inhabilitado";
		}
		
		?>
		<div class="row rowcolor cfila" onclick="fn_rowselection($(this))">
			<div class="col-12 col-md-3">
				<div class="row">
					<div class="col-1 col-sm-6 col-md-2 td text-right">
						<span class="tdnro"><?php echo $nro ;?></span>
					</div>
					<div class="col-11 col-sm-6 col-md-10 td">
						<span><?php echo "$dts->id $dts->uninom" ?></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-2">
				<div class="row">
					<div class="col-6 col-sm-6 col-md-9 td">
						<span><?php echo $nomtip ;?></span>
					</div>
					<div class="col-6 col-sm-6 col-md-3 td">
						<span><?php echo $dts->cicnom ?></span>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-3 text-center">
				<div class="row">
					<div class="col-2 col-sm-6 col-md-2 td">
						<span><?php echo $dts->horter ;?></span>
					</div>
					<div class="col-2 col-sm-6 col-md-2 td">
						<span><?php echo $dts->horprac ?></span>
					</div>
					<div class="col-2 col-sm-6 col-md-2 td">
						<span class="text-primary"><?php echo $dts->horprac  + $dts->horter ?></span>
					</div>
					
					<div class="col-2 col-sm-6 col-md-2 td">
						<span><?php echo $dts->credter ;?></span>
					</div>
					<div class="col-2 col-sm-6 col-md-2 td">
						<span><?php echo $dts->credprac ?></span>
					</div>
					<div class="col-2 col-sm-6 col-md-2 td">
						<span class="text-primary"><?php echo $dts->credprac  + $dts->credter ?></span>
					</div>
				</div>
			</div>
			
			<div class="col-12 col-md-4">
				<div class="row">
					<div class="col-8 col-sm-6 col-md-7 td">
						<span><?php echo "$dts->plan - $dts->modnom ";?></span>
					</div>
					<div class="col-2 col-sm-3 col-md-2 td text-center">
						<span role='button' data-container='body' data-toggle='popover' data-trigger='hover' data-content='<?php echo $vtitle ?>' class='msgtooltip'>
							<a data-flat='<?php echo $vflat ?>' data-codigo='<?php echo $codund64 ?>' data-act='<?php echo $accion ?>' class='btn <?php echo $btncolor ?>' href='#' onclick="fn_update_estado_und($(this));return false;">
								<i class='<?php echo $vicon ?>'></i>
							</a>
						</span>
					</div>
					<div class="col-2 col-sm-3 col-md-3 td text-center">
						<div class='btn-group'>
							<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
	                            <i class='fas fa-cog'></i>
	                        </a>
	                        <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
	                        	<a class='dropdown-item' href='#' title='Editar' data-idund="<?php echo $codund64 ?>" onclick="viewupdaunidad($(this));return false;">
                                    <i class='fas fa-edit mr-1'></i> Editar
                                </a>
                                <a class='dropdown-item text-danger' href='#' title='Eliminar' data-idund="<?php echo $codund64 ?>" onclick="fn_delete_unidad($(this));return false;">
                                    <i class='fas fa-trash mr-1'></i> Eliminar
                                </a>
	                        </div>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		<?php } ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('[data-toggle="popover"]').popover({
            trigger: 'hover',
            html: true
        })
	});
</script>
<?php } else {
	echo '<h5 class="text-danger"><i class="fa fa-ban"></i> NO SE ENCONTRARON DATOS...!</h5>';
} ?>