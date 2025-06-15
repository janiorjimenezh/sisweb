<?php 
	$vbaseurl=base_url(); 
	$meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
	// $md=($config->conf_doc_add_est=="SI") ? "col-md-9":"col-md-12" ;
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

	.fila-comentario:hover .divcard_actions {
		display: block;
		transition:all .5s ease-in-out;
	}

	.divcard_actions {
		display: none;
		position: absolute;
		right: 0;
		top: 0;
		padding: 5px 8px;
		width: 160px;
		height: 100%;
		text-align: center;
		background: linear-gradient(to left,#939393 0%,#ececec 93%,rgba(238,238,238,.01) 100%);
    	background-clip: padding-box;
	}

	.divcard_actions .divcard_actions_item {
		display: inline-block;
		line-height: 50px;
	}

	.divcard_actions .actions_item:nth-child(odd) {
		margin-right: 10px;
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
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">

	<!-- Modal -->
	<div class="modal fade" id="modaddnotification" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaddnotificationLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-xl">
		    <div class="modal-content" id="divcardnotif">
		      	<div class="modal-header">
		        	<h5 class="modal-title" id="title_notificacion"><i class="pulse nav-icon fas fa-bell"></i> Anuncios</h5>
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          		<span aria-hidden="true">&times;</span>
		        	</button>
		      	</div>
		      	<div class="modal-body">
		        	<form id="frm_addanuncio" action="" method="post" accept-charset="utf-8">
		        		<div class="row">
		        			<input type="hidden" name="fictxtcodigoanuncio" id="fictxtcodigoanuncio" value="0">
		        			<input type="hidden" name="fictxtcodigocarga" id="fictxtcodigocarga" value="<?php echo base64url_encode($curso->codcarga) ?>">
		        			<input type="hidden" name="fictxtcodigodivision" id="fictxtcodigodivision" value="<?php echo base64url_encode($curso->division) ?>">
		        			<div class="col-12 form-group has-float-label">
		        				<input type="text" name="fictxttitulo" id="fictxttitulo" placeholder="Titulo" class="form-control">
		        				<label for="fictxttitulo">Titulo</label>
		        			</div>
		        			<div class="col-12 form-group">
		        				<textarea name="fictxtanuncio" id="fictxtanuncio" class="form-control vw_pw_bt_textarea_summer"></textarea>
		        			</div>
		        		</div>
		        	</form>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		        	<button type="button" class="btn btn-primary" id="btn_addanuncios">Guardar</button>
		      	</div>
		    </div>
	  	</div>
	</div>
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
		                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
		                </li>
		                <li class="breadcrumb-item">
		                    
		                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
		                    </a>
		                </li>
	              		<li class="breadcrumb-item active">anuncios</li>
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
				<div class="card-tools">
					<button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modaddnotification">
						<i class="fas fa-plus"></i> Agregar
					</button>
				</div>
			</div>
			<div class="card-body p-2 p-sm-3">
				<div class="row">
					<?php
						if (count($anuncios) > 0) {
							foreach ($anuncios as $key => $anun) {
								$codanuncio64 = base64url_encode($anun->id);
								$fechapub = new DateTime($anun->publicado);
								// $fpublicado = $fechapub->format("d/m/Y h:i a");
								$numeroDia = $fechapub->format("d");
								$mes = date('n', strtotime($fechapub->format("Y/m/d")));
								$nombreMes = $meses_ES[$mes-1];
								$anio = $fechapub->format("Y");
								$dhora = $fechapub->format("h:i a");
								echo "<div class='col-12 fila-comentario'>
										<div class='user_notification rounded mb-2'>
											<div class='div_user_img float-left'>
												<span class='text-transparent mr-3'><i class='fas fa-circle'></i></span>
												<img class='img-circle border' src='{$vbaseurl}resources/fotos/$anun->foto' alt='User Image'>
											</div>
											<div class='float-left comment-text ml-3'>
												<a href='{$vbaseurl}'>
													<span class='username text-dark'>$anun->titulo</span>
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
										<div class='divcard_actions'>
												<div class='divcard_actions_item'>
													<a href='#' data-codigo='$codanuncio64' onclick='fn_update_anuncio($(this));return false;' class='actions_item'>
														<i class='fas fa-edit text-dark'></i>
													</a>
													<a href='#' data-txtidanuncio='$codanuncio64' data-titulo='$anun->titulo' onclick='fn_delete_anuncio($(this));return false;' class='actions_item'><i class='fas fa-trash text-danger'></i></a>
												</div>
											</div>
									</div>";
							}
						}else {
							echo "<div class='col-12'><h3 class='text-danger'>No hay anuncios disponibles</h3></div>";
						}
					?>
					<!-- <div class="col-12 fila-comentario">
						<div class="user_notification rounded mb-2">
							<div class="div_user_img float-left">
								<span class="text-danger mr-3"><i class="fas fa-circle"></i></span>
								<img class="img-circle border" src="https://erp.iesap.edu.pe/resources/fotos/1.png" alt="User Image">
							</div>
							
							<div class="float-left comment-text ml-3">
								<a href="#">
									<span class="username text-dark">PLATAFORMA VIRTUAL IESAP</span>
								</a>
								<span class="comment">
									<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
								</span>
							</div>
							<div class="float-right comment-time ml-3 text-right">
								<span class="text-dark font-weight-bold text-sm">Publicado el:</span>
								<div class="clearfix"></div>
								<span class="text-dark text-sm">11 jul 2022, 6:00</span>
							</div>
						</div>
					</div> -->

				</div>
			</div>
		</div>
	</section>
</div>

<?php
echo
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>";
?>

<script type="text/javascript">
	$(document).ready(function() {
		// fn_summer_note_anuncio();
	})

	function fn_summer_note_anuncio() {
		$('.vw_pw_bt_textarea_summer').summernote({
		    height: 250,
		    placeholder: 'Escriba Aquí ...!',
		    dialogsFade: true,
		    lang: 'es-ES',
		    toolbar: [
	            // [groupName, [list of button]]
	            ['style', ['bold', 'italic', 'underline']],
	            ['fontsize', ['fontsize']],
	            // ['color', ['color']],
	            ['insert', ['link']],
	        ],
		    
		});
	}
	

	$('#btn_addanuncios').click(function(e) {
		$('#frm_addanuncio input,select').removeClass('is-invalid');
        $('#frm_addanuncio .invalid-feedback').remove();
        $('#divcardnotif').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "anuncios/fn_insert_update",
            type: 'post',
            dataType: 'json',
            data: $('#frm_addanuncio').serialize(),
            success: function(e) {
                $('#divcardnotif #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    
                } else {
                    $('#modaddnotification').modal('hide');
                    Swal.fire({
                        title: e.msg,
                        type: 'success',
                        icon: 'success',
                    })
                    location.reload();
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcardnotif #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
	});

	$("#modaddnotification").on('shown.bs.modal', function () {
		fn_summer_note_anuncio();
	})

	$("#modaddnotification").on('hidden.bs.modal', function () {
		$('#frm_addanuncio input,select').removeClass('is-invalid');
	    $('#frm_addanuncio .invalid-feedback').remove();
        $('#frm_addanuncio')[0].reset();
        $('#fictxtcodigoanuncio').val('0');
        $('#fictxtanuncio').val('');
        $('.vw_pw_bt_textarea_summer').summernote('destroy');
	})

	function fn_update_anuncio(btn) {
		var codigo = btn.data('codigo');
        $('#divcard_anuncios').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "anuncios/fn_anuncio_xcodigo",
            type: 'post',
            dataType: 'json',
            data: {
            	txtcodigo:codigo
            },
            success: function(e) {
                $('#divcard_anuncios #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
	                    title: '!ERROR',
	                    text: "No se encontraron datos",
	                    type: 'error',
	                    icon: 'error',
	                })
                } else {
                	$('#fictxtcodigoanuncio').val(e.vdata['idanunc64']);
                	$('#fictxtcodigocarga').val(e.vdata['idcarga64']);
                	$('#fictxtcodigodivision').val(e.vdata['iddivis64']);
                	$('#fictxttitulo').val(e.vdata['titulo']);
                	$('#fictxtanuncio').val(e.vdata['contenido']);
                	fn_summer_note_anuncio();
                    $('#modaddnotification').modal();
                    
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divcard_anuncios #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
	}

	function fn_delete_anuncio(btn) {
		fila = btn.closest('.fila-comentario');
		console.log("fila", fila);
	    codigo = btn.data('txtidanuncio');
	    titulo = btn.data('titulo');
	    console.log("codigo", codigo);
	    Swal.fire({
	        title: 'Desea eliminar el anuncio '+titulo+'?',
	        text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Eliminar'
	    }).then(function(result){
	    	if(result.value){
	            $('#divcard_anuncios').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	            $.ajax({
	                url: base_url + 'anuncios/fneliminar_anuncios',
	                method: "POST",
	                dataType: 'json',
	                data: {
	                    txtcodigo : codigo,
	                },
	                success:function(e){
	                    $('#divcard_anuncios #divoverlay').remove();
	                    if (e.status == true) {
	                        Swal.fire({
	                            type: "success",
	                            icon: 'success',
	                            title: "¡CORRECTO!",
	                            text: e.msg,
	                            showConfirmButton: true,
	                            allowOutsideClick: false,
	                            confirmButtonText: "Cerrar"
	                        })

	                        fila.remove();
	                                                
	                    } else {
	                        Swal.fire({
	                            title: "Error",
	                            text: e.msg,
	                            type: "error",
	                            icon: "error",
	                            allowOutsideClick: false,
	                            confirmButtonText: "¡Cerrar!"
	                        });
	                    }
	                },
	                error: function(jqXHR, exception) {
	                    var msgf = errorAjax(jqXHR, exception,'text');
	                    $('#divcard_anuncios #divoverlay').remove();
	                    Swal.fire({
	                        title: "Error",
	                        text: e.msgf,
	                        type: "error",
	                        icon: "error",
	                        allowOutsideClick: false,
	                        confirmButtonText: "¡Cerrar!"
	                    });
	                }
	            })
	        }
	    });
	    return false;
	}
</script>