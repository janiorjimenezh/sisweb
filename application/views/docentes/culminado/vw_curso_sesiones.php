
<?php $vbaseurl=base_url(); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 			<?php include 'vw_curso_encabezado.php'; ?>

 			<div class="card">
 				<div class="card-body ">
 					<nav>
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
					        <a class="nav-item nav-link active" id="nav-pendientes-tab" data-toggle="tab" href="#nav-pendientes" role="tab" aria-controls="nav-pendientes" aria-selected="true">Pendientes</a>
					        <a class="nav-item nav-link" id="nav-anteriores-tab" data-toggle="tab" href="#nav-anteriores" role="tab" aria-controls="nav-anteriores" aria-selected="false">Anteriores</a>
					        <a class="nav-item nav-link" id="nav-todos-tab" data-toggle="tab" href="#nav-todos" role="tab" aria-controls="nav-todos" aria-selected="false">Todos</a>
					    </div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active py-3 px-1" id="nav-pendientes" role="tabpanel" aria-labelledby="nav-pendientes-tab">
							<?php
								
								if (count($pendientes) > 0) {
									
									$item=0;
									$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
									foreach ($pendientes as $key => $ss) {
										$item++;
										$date = new DateTime($ss->fecha);
										$vfecha= $date->format('d/m/Y');
										$hinia = new DateTime($ss->hini);
										$hfina = new DateTime($ss->hfin);
										$hini=$hinia->format('h:i a');
										$hfin=$hfina->format('h:i a');
										$vnroses=str_pad($ss->nrosesion, 2, "0", STR_PAD_LEFT);
										$textdiases = $dias[date("w", strtotime($ss->fecha))];
										$urlmeet = "";
										$textfileses = ($ss->archivo != "") ? getIcono('P',$ss->linkf).' '.$ss->archivo.' ('.formatBytes($ss->pesof).')' : "";
										if (trim($ss->hlink)!="") {
											$urlmeet = "<a target='_blank' class='vd_link mr-2' href='$ss->hlink'>$ss->hlink</a>
														<a target='_blank' href='$ss->hlink' class='btn btn-tool bg-primary'><i class='fas fa-video'></i> Unirte</a>";
										}

										echo "<div class='card border border-primary div-sesion'>
												<div class='card-header'>
													<h3 class='card-title text-bold' data-toggle='tooltip' title='$ss->id'>
													<i class='fa fa-angle-double-right text-success'></i>
													SESIÓN $vnroses - $ss->tipo
													</h3>
												</div>
												<div class='card-body px-3 pb-3 pt-1'>
													<div class='row'>
														<div class='col-md-12'>
															<span class='text-bold'>$ss->detalle</span><br>
															<u>$textdiases</u> $vfecha $hini - $hfin
														</div>
														<div class='col-12'>
															$urlmeet
														</div>
														<div class='col-12 mt-2'>
															<a target='_blank' class='fl_link' href='{$vbaseurl}upload/docweb/$ss->linkf'>
																$textfileses
															</a>
														</div>
														
													</div>
												</div>
											</div>";
									}
								} else {
									echo "<div class='card border border-primary div-sesion text-center py-2'>
											<h5> No hay sesiones pendientes para mostrar</h5>
										</div>";
								}
							?>
							
						</div>
						<div class="tab-pane fade py-3 px-1" id="nav-anteriores" role="tabpanel" aria-labelledby="nav-anteriores-tab">
							<?php
								$item=0;
								$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
								foreach ($pasada as $key => $ss) {
									$item++;
									$date = new DateTime($ss->fecha);
									$vfecha= $date->format('d/m/Y');
									$hinia = new DateTime($ss->hini);
									$hfina = new DateTime($ss->hfin);
									$hini=$hinia->format('h:i a');
									$hfin=$hfina->format('h:i a');
									$vnroses=str_pad($ss->nrosesion, 2, "0", STR_PAD_LEFT);
									$textdiases = $dias[date("w", strtotime($ss->fecha))];
									$urlmeet = "";
									$textfileses = ($ss->archivo != "") ? getIcono('P',$ss->linkf).' '.$ss->archivo.' ('.formatBytes($ss->pesof).')' : "";
									if (trim($ss->hlink)!="") {
										$urlmeet = "<a target='_blank' class='vd_link mr-2' href='$ss->hlink'>$ss->hlink</a>
													<a target='_blank' href='$ss->hlink' class='btn btn-tool bg-primary'><i class='fas fa-video'></i> Unirte</a>";
									}

									echo "<div class='card border border-primary div-sesion'>
											<div class='card-header'>
												<h3 class='card-title text-bold' data-toggle='tooltip' title='$ss->id'>
												<i class='fa fa-angle-double-right text-success'></i>
												SESIÓN $vnroses - $ss->tipo
												</h3>
											</div>
											<div class='card-body px-3 pb-3 pt-1'>
												<div class='row'>
													<div class='col-md-12'>
														<span class='text-bold'>$ss->detalle</span><br>
														<u>$textdiases</u> $vfecha $hini - $hfin
													</div>
													<div class='col-12'>
														$urlmeet
													</div>
													<div class='col-12 mt-2'>
														<a target='_blank' class='fl_link' href='{$vbaseurl}upload/docweb/$ss->linkf'>
															$textfileses
														</a>
													</div>
													
												</div>
											</div>
										</div>";
								}
							?>
							
						</div>
						<div class="tab-pane fade py-3 px-1" id="nav-todos" role="tabpanel" aria-labelledby="nav-todos-tab">
							<?php
								$item=0;
								$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
								foreach ($sesiones as $key => $ss) {
									$item++;
									$date = new DateTime($ss->fecha);
									$vfecha= $date->format('d/m/Y');
									$hinia = new DateTime($ss->hini);
									$hfina = new DateTime($ss->hfin);
									$hini=$hinia->format('h:i a');
									$hfin=$hfina->format('h:i a');
									$vnroses=str_pad($ss->nrosesion, 2, "0", STR_PAD_LEFT);
							?>
							<div class="card border border-primary div-sesion">
								<div class="card-header">
									<h3 class="card-title text-bold" data-toggle="tooltip" title="<?php echo $ss->id ?>">
									<i class="fa fa-angle-double-right text-success"></i>
									SESIÓN <?php echo $vnroses." - ".$ss->tipo ?>
									</h3>
								</div>
								<div class="card-body px-3 pb-3 pt-1">
									<div class="row">
										<div class="col-md-12">
											<span class="text-bold"><?php echo $ss->detalle ?></span><br>
											<u> <?php echo $dias[date("w", strtotime($ss->fecha))]."</u> ".$vfecha." ".$hini." - ".$hfin; ?>
										</div>
										<div class="col-12">
											
											
												<?php 
												if (trim($ss->hlink)!=""){
													 
													echo "<a target='_blank' class='vd_link mr-2' href='$ss->hlink'>$ss->hlink</a>";
													echo "<a target='_blank' href='$ss->hlink' class='btn btn-tool bg-primary'><i class='fas fa-video'></i> Unirte</a>";
												}
												
											?>
										</div>
										<div class="col-12 mt-2">
											<a target="_blank" class="fl_link" href="<?php echo base_url().'upload/docweb/'. $ss->linkf ?>">
												<?php echo ($ss->archivo != "") ? getIcono('P',$ss->linkf).' '.$ss->archivo.' ('.formatBytes($ss->pesof).')' : ""?>
											</a>
										</div>
										
									</div>
								</div>
								<!-- /.card-body -->
									
							</div>
							<?php } ?>
						</div>
					</div>

					<div id="divsesionprocesos">
						
					</div>
					
				</div>
 			</div>
			
		</section>
	</div>
</div>
	