<?php 
	$vbaseurl=base_url(); 
	$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
?>
<style type="text/css">
	.text-transparent {
		color: transparent!important;
	}

	.user_notification {
	    margin-bottom: 15px;
	    width: 100%;
	}

	.user_notification img {
		height: 40px;
    	width: 40px;
	}

	.user_notification .username {
	    font-size: 16px;
	    font-weight: 600;
	    margin-top: -1px;
	}

	.user_notification .username, .user_notification .comment {
		display: block;
	}

	.user_notification .comment-text {
		width: 65%;
	}

	.fila-comentario {
		border-bottom: 1px solid #e9ecef;
    	padding: 0.75rem 1.25rem;
    	position: relative;
	}

	.comment-text .comment {
	    -webkit-line-clamp: 1;
	    -webkit-box-orient: vertical;
	    display: -webkit-box;
	    max-height: 130px;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: normal;
	    width: 100%;
	    color: #535b60;
	}

	.fila-comentario:hover {
	    color: #212529;
	    background-color: rgba(0,0,0,.075);
	    transition:all .5s ease-in-out;
	}

	.user_notification .comment-text a:hover {
		text-decoration: underline;
		color: #000;
	}

	@-webkit-keyframes pulse{
		0%,100%{
			opacity:0
		}
		50%{
			opacity:1;
			color: #dc3545;
		}
	}

	@keyframes pulse{
		0%,100%{
			opacity:0
		}
		50%{
			opacity:1;
			color: #dc3545;
		}
	}

	.pulse{
		/*height:16px;
		max-height:20px;*/
		-webkit-animation-name:pulse;
		animation-name:pulse;
		-webkit-animation-duration:1s;
		animation-duration:1s;
		-webkit-animation-iteration-count:infinite;
		animation-iteration-count:infinite
	}
</style>
<div class="content-wrapper">
	<section class="content-header">
      	<div class="container-fluid">
	        <div class="row mb-2">
	          	<div class="col-sm-6">
	            	<h1><?php echo $curso->unidad ?>
	            		<small> <?php echo $curso->codseccion.$curso->division; ?></small>
	            	</h1>
	          	</div>
	          	<div class="col-sm-6">
	            	<ol class="breadcrumb float-sm-right">
		                <li class="breadcrumb-item">
		                    <a href="<?php echo $vbaseurl ?>alumno/mis-cursos-panel"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
		                </li>
		                <li class="breadcrumb-item">
		                    
		                    <a href="<?php echo $vbaseurl.'alumno/curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.$miembroid; ?>"><?php echo $curso->unidad ?>
		                    </a>
		                </li>
	              		<li class="breadcrumb-item active">ANUNCIOS</li>
	            	</ol>
	          	</div>
	        </div>
      	</div>
    </section>
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<?php include 'vw_curso_encabezado.php'; ?>
			</div>
		</div>
		<div id="divcard_anuncios" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="pulse nav-icon fas fa-bell"></i> Anuncios</h3>
			</div>
			<div class="card-body p-2 p-sm-3">
				<div class="row">
					<?php
						if (count($vanuncios) > 0) {
							foreach ($vanuncios as $key => $anun) {
								$codanuncio64 = base64url_encode($anun->id);
								$fechapub = new DateTime($anun->publicado);
								// $fpublicado = $fechapub->format("d/m/Y h:i a");
								$numeroDia = $fechapub->format("d");
								$mes = date('n', strtotime($fechapub->format("Y/m/d")));
								$nombreMes = $meses_ES[$mes-1];
								$anio = $fechapub->format("Y");
								$dhora = $fechapub->format("h:i a");
								$carga64 = base64url_encode($curso->codcarga);
								$division64 = base64url_encode($curso->division);
								if ($anun->leido == "SI") {
									$coloricon = "text-transparent";
								} else {
									$coloricon = "text-danger";
								}
								echo "<div class='col-12 fila-comentario'>
										<div class='user_notification rounded mb-2'>
											<div class='div_user_img float-left'>
												<span class='$coloricon mr-3'><i class='fas fa-circle'></i></span>
												<img class='img-circle border' src='{$vbaseurl}resources/fotos/$anun->foto' alt='User Image'>
											</div>
											<div class='float-left comment-text ml-3'>
												<a href='{$vbaseurl}alumno/curso/anuncios/detalle/$carga64/$division64/$codanuncio64/$miembroid'>
													<span class='username text-dark text-uppercase'>$anun->titulo</span>
												</a>
												<span class='comment'>
													<div>".strip_tags($anun->contenido)."</div>
												</span>
											</div>
											<div class='float-right comment-time ml-3 text-right'>
												<span class='text-dark font-weight-bold text-sm'>Publicado el:</span>
												<div class='clearfix'></div>
												<span class='text-dark text-sm'>$numeroDia $nombreMes $anio $dhora</span>
											</div>
											
										</div>
									</div>";
							}
						} else {
							echo "<div class='col-12'><h3 class='text-danger'>No hay anuncios disponibles</h3></div>";
						}
						
					?>
				</div>
			</div>
		</div>
	</section>
</div>