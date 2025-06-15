<?php
	$vbaseurl=base_url();
	$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
	$codcarga64 = base64url_encode($curso->codcarga);
	$coddivision64 = base64url_encode($curso->division);
	$codunidad64 = base64url_encode($curso->codunidad);
?>
<div class="content-wrapper">
	<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1><?php echo $curso->unidad ?>
				<small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">
						<a href="<?php echo $vbaseurl ?>alumno/mis-cursos-panel"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
					</li>
					<li class="breadcrumb-item">
						
						<a href="<?php echo $vbaseurl.'alumno/curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($miembro); ?>"><?php echo $curso->unidad ?>
						</a>
					</li>
					
					<li class="breadcrumb-item active">Sesiones</li>
				</ol>
			</div>
		</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<?php include 'vw_panel_encabezado.php'; ?>

		<div id="divboxmissesiones" class="card">
			<div class="card-header">
				<h3 class="card-title">Clases diarias</h3>
			</div>
			<div class="card-body">
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
								$codsesion64 = base64url_encode($ss->id);
								$date = new DateTime($ss->fecha);
								$vfecha= $date->format('d/m/Y');
								$hinia = new DateTime($ss->hini);
								$hfina = new DateTime($ss->hfin);
								$hini=$hinia->format('h:i a');
								$hfin=$hfina->format('h:i a');
								
								$vfecha= $date->format('d/m/Y');
								$vnroses=str_pad($ss->nrosesion, 2, "0", STR_PAD_LEFT);
								$textdiases = $dias[date("w", strtotime($ss->fecha))];
								$urlmeet = "";
								$urlfileses = "";
								$textfileses = ($ss->archivo != "") ? getIcono('P',$ss->linkf).' '.$ss->archivo.' ('.formatBytes($ss->pesof).')' : "";
								if (trim($ss->hlink)!=""){
									$urlmeet = "<a target='_blank' data-carga='$codcarga64' data-division='$coddivision64' data-unidad='$codunidad64' class='vd_link mr-2 btn_ses_asist' href='$ss->hlink'>
													$ss->hlink
												</a>
												<a target='_blank' data-carga='$codcarga64' data-division='$coddivision64' data-unidad='$codunidad64' href='$ss->hlink' class='btn btn-tool bg-primary btn_ses_asist'>
													<i class='fas fa-video'></i> Unirte
												</a>";

								}

								if (trim($textfileses)!="") {
									$urlfileses = "<div class='col-12 mt-2'>
													<a target='_blank' class='fl_link' href='{$vbaseurl}alumno/sesion/descargar-file/". base64url_encode($ss->archivo) .'/'. base64url_encode($ss->linkf) .'/'. base64url_encode($ss->tipof)."'>
														$textfileses
													</a>
												</div>";
								}

								echo "<div class='card border border-primary div-sesion' data-titulo='SESIÓN $vnroses' data-detalle='$ss->detalle' data-sesion='$codsesion64' data-file='$ss->linkf'>
										<div class='card-header'>
											<h3 class='card-title text-bold' data-toggle='tooltip' title='$ss->id'>
												<i class='fa fa-angle-double-right text-success'></i>
												SESIÓN $vnroses - $ss->tipo
											</h3>
											
										</div>
										<div class='card-body p-3'>
											<div class='row'>
												<div class='col-md-12'>
													<span>$ss->detalle</span><br>
													<u>$textdiases</u> $vfecha $hini - $hfin
												</div>
												<div class='col-12'>
													$urlmeet
												</div>
												$urlfileses
												
											</div>
										</div>
									</div>";
							}
						} else {
							echo "<div class='card border border-primary div-sesion text-center py-2'>
									<h5><i class='fa fa-exclamation-circle'></i> No hay sesiones pendientes para mostrar</h5>
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
							$codsesion64 = base64url_encode($ss->id);
							$date = new DateTime($ss->fecha);
							$vfecha= $date->format('d/m/Y');
							$hinia = new DateTime($ss->hini);
							$hfina = new DateTime($ss->hfin);
							$hini=$hinia->format('h:i a');
							$hfin=$hfina->format('h:i a');
							
							$vfecha= $date->format('d/m/Y');
							$vnroses=str_pad($ss->nrosesion, 2, "0", STR_PAD_LEFT);
							$textdiases = $dias[date("w", strtotime($ss->fecha))];
							$urlmeet = "";
							$urlfileses = "";
							$textfileses = ($ss->archivo != "") ? getIcono('P',$ss->linkf).' '.$ss->archivo.' ('.formatBytes($ss->pesof).')' : "";
							if (trim($ss->hlink)!=""){
								$urlmeet = "<a target='_blank' data-carga='$codcarga64' data-division='$coddivision64' data-unidad='$codunidad64' class='vd_link mr-2 btn_ses_asist' href='$ss->hlink'>
												$ss->hlink
											</a>
											<a target='_blank' data-carga='$codcarga64' data-division='$coddivision64' data-unidad='$codunidad64' href='$ss->hlink' class='btn btn-tool bg-primary btn_ses_asist'>
												<i class='fas fa-video'></i> Unirte
											</a>";

							}

							if (trim($textfileses)!="") {
								$urlfileses = "<div class='col-12 mt-2'>
												<a target='_blank' class='fl_link' href='{$vbaseurl}alumno/sesion/descargar-file/". base64url_encode($ss->archivo) .'/'. base64url_encode($ss->linkf) .'/'. base64url_encode($ss->tipof)."'>
													$textfileses
												</a>
											</div>";
							}

							echo "<div class='card border border-primary div-sesion' data-titulo='SESIÓN $vnroses' data-detalle='$ss->detalle' data-sesion='$codsesion64' data-file='$ss->linkf'>
									<div class='card-header'>
										<h3 class='card-title text-bold' data-toggle='tooltip' title='$ss->id'>
											<i class='fa fa-angle-double-right text-success'></i>
											SESIÓN $vnroses - $ss->tipo
										</h3>
										
									</div>
									<div class='card-body p-3'>
										<div class='row'>
											<div class='col-md-12'>
												<span>$ss->detalle</span><br>
												<u>$textdiases</u> $vfecha $hini - $hfin
											</div>
											<div class='col-12'>
												$urlmeet
											</div>

											$urlfileses
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
							$codsesion64 = base64url_encode($ss->id);
							$date = new DateTime($ss->fecha);
							$vfecha= $date->format('d/m/Y');
							$hinia = new DateTime($ss->hini);
							$hfina = new DateTime($ss->hfin);
							$hini=$hinia->format('h:i a');
							$hfin=$hfina->format('h:i a');
							
							$vfecha= $date->format('d/m/Y');
							$vnroses=str_pad($ss->nrosesion, 2, "0", STR_PAD_LEFT);
							$textdiases = $dias[date("w", strtotime($ss->fecha))];
							$urlmeet = "";
							$urlfileses = "";
							$textfileses = ($ss->archivo != "") ? getIcono('P',$ss->linkf).' '.$ss->archivo.' ('.formatBytes($ss->pesof).')' : "";
							if (trim($ss->hlink)!=""){
								$urlmeet = "<a target='_blank' data-carga='$codcarga64' data-division='$coddivision64' data-unidad='$codunidad64' class='vd_link mr-2 btn_ses_asist' href='$ss->hlink'>
												$ss->hlink
											</a>
											<a target='_blank' data-carga='$codcarga64' data-division='$coddivision64' data-unidad='$codunidad64' href='$ss->hlink' class='btn btn-tool bg-primary btn_ses_asist'>
												<i class='fas fa-video'></i> Unirte
											</a>";

							}

							if (trim($textfileses)!="") {
								$urlfileses = "<div class='col-12 mt-2'>
												<a target='_blank' class='fl_link' href='{$vbaseurl}alumno/sesion/descargar-file/". base64url_encode($ss->archivo) .'/'. base64url_encode($ss->linkf) .'/'. base64url_encode($ss->tipof)."'>
													$textfileses
												</a>
											</div>";
							}

							echo "<div class='card border border-primary div-sesion' data-titulo='SESIÓN $vnroses' data-detalle='$ss->detalle' data-sesion='$codsesion64' data-file='$ss->linkf'>
									<div class='card-header'>
										<h3 class='card-title text-bold' data-toggle='tooltip' title='$ss->id'>
											<i class='fa fa-angle-double-right text-success'></i>
											SESIÓN $vnroses - $ss->tipo
										</h3>
										
									</div>
									<div class='card-body p-3'>
										<div class='row'>
											<div class='col-md-12'>
												<span>$ss->detalle</span><br>
												<u>$textdiases</u> $vfecha $hini - $hfin
											</div>
											<div class='col-12'>
												$urlmeet
											</div>

											$urlfileses
										</div>
									</div>
								</div>";
						}
						?>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>

<script>
	$('.btn_ses_asist').click(function(e) {
		e.preventDefault();
		var btn = $(this);
		var enlace = btn.attr('href');
		div = btn.closest('.div-sesion');
		var sesion = div.data('sesion');
		var carga = btn.data('carga');
		var division = btn.data('division');
		var unidad = btn.data('unidad');

		div.append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
			url: base_url + 'sesion/fn_curso_sesiones_asistencias'	,
			type: 'post',
			dataType: 'json',
			data: {
				sesion: sesion,
				carga: carga,
				division: division,
				unidad: unidad
			},
			success: function(e) {
				div.find('#divoverlay').remove();
				if (e.status == false) {
					Swal.fire({
	                    title: "Error!",
	                    text: "existen errores",
	                    type: 'error',
	                    icon: 'error',
	                })
				}
				else {
					window.open(enlace);
				}
			},
			error: function (jqXHR, exception) {
				var msgf=errorAjax(jqXHR, exception,'div');
				div.find('#divoverlay').remove();
				Swal.fire('Error!',msgf,'error')
			},
		});
		return false;
	});
</script>