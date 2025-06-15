<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<h1>
			Registro Matrículas
			</h1>
		</div>
	</section>

	<section class="content">
		<div id="divcardmatriculas" class="card">
			<div class="card-body">
				<div class="table-responsive margin-top-10px no-padding">
					
					<div class="btable mt-3">
	                    <div class="thead col-12  d-none d-md-block">
	                        <div class="row">
	                            <div class='col-12 col-md-2'>
	                                <div class='row'>
	                                    <div class='col-2 col-md-2 td'>N°</div>
	                                    <div class='col-10 col-md-10 td'>CARNET</div>
	                                </div>
	                            </div>
	                            <div class='col-12 col-md-3'>
	                                <div class='row'>
	                                    <div class='col-7 col-md-7 td'>FECHA</div>
	                                    <div class='col-5 col-md-5 td'>ESTADO</div>
	                                </div>
	                            </div>
	                            <div class='col-12 col-md-5 text-center'>
	                                <div class='row'>
	                                    <div class='col-2 col-md-2 td'>
	                                        <span>PERIODO</span>
	                                    </div>
	                                    
	                                    <div class='col-6 col-md-6 td'>
	                                        <span>PROGRAMA</span>
	                                    </div>
	                                    <div class='col-2 col-md-2 td'>
	                                        <span>CICLO</span>
	                                    </div>
	                                    <div class='col-2 col-md-2 td'>
	                                        <span>TURNO</span>
	                                    </div>
	                                    
	                                </div>
	                            </div>
	                            <div class='col-12 col-md-2 text-center'>
	                            	<div class='row'>
		                            	<div class='col-6 col-md-6 td'>
	                                        <span><i class="fas fa-file-pdf"></i></span>
	                                    </div>
	                                    <div class='col-6 col-md-6 td'>
	                                        <span><i class="fas fa-calendar-alt"></i></span>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="tbody col-12" id="divresult">
	                    	<?php
	                    		$nro = 0;
	                    		$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
	                    		foreach ($mismatriculas as $mtc) {
	                    			$nro ++;
	                    			$datemat =  new DateTime($mtc->fecregistro) ;
	                    			$vmatricula = $dias[$datemat->format('w')].". ".$datemat->format('d/m/Y h:i a');
	                    			$codigo = base64url_encode($mtc->codmatricula);
	                    			$vcarne64 = base64url_encode($mtc->carne);
	                    			$vperiodo64 = base64url_encode($mtc->codperiodo);
	                    			$vciclo64 = base64url_encode($mtc->codciclo);
	                    			$vnombres64 = base64url_encode($mtc->paterno.' '.$mtc->materno.' '.$mtc->nombres);
	                    			echo 
		                            "<div class='row cfila'>
		                                <div class='col-12 col-md-2'>
		                                    <div class='row'>
		                                        <div class='col-2 col-md-2 td'>$nro</div>
		                                        <div class='col-10 col-md-10 td'>
		                                            <span>$mtc->carne</span>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-3'>
		                                	<div class='row'>
		                                        <div class='col-7 col-md-7 td'>
		                                        	<small><i class='far fa-calendar-alt'></i> $vmatricula</small>
		                                        </div>
		                                        <div class='col-5 col-md-5 td'>
		                                            <span>$mtc->matriculaestado</span>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-5'>
		                                	<div class='row'>
		                                        <div class='col-2 col-md-2 td'>
		                                        	<span>$mtc->periodo</span>
		                                        </div>
		                                        <div class='col-6 col-md-6 td'>
		                                            <span>$mtc->carrera</span>
		                                        </div>
		                                        <div class='col-2 col-md-2 td'>
		                                        	<span>$mtc->ciclo - $mtc->seccion</span>
		                                        </div>
		                                        <div class='col-2 col-md-2 td'>
		                                        	<span>$mtc->turno</span>
		                                        </div>
		                                        
		                                    </div>
		                                </div>
		                                <div class='col-12 col-md-2 text-center'>
			                                <div class='row'>
					                            <div class='col-6 col-md-6 td'>
													<a href='{$vbaseurl}academico/matricula/imprimir/$codigo' class='btn btn-sm btn-primary' target='_blank'>
														Ficha
													</a>
												</div>
			                                    <div class='col-6 col-md-6 td'>
			                                        
			                                    </div>
			                                </div>
			                            </div>
		                            </div>";
	                    		}
	                    	?>
	                    </div>
	                </div>
					
				</div>
			</div>
		</div>		
	</section>
</div>