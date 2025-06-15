<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">
  	<section id="s-cargado" class="content pt-2">
    	<div id="divcard_slide" class="card">
			<div class="card-header">
  				<h3 class="card-title">
  					<i class="fas fa-image"></i>
  					Registro Slider
  				</h3>
			</div>
			<div class="card-body">
              	<form id="frm_addslider" name="frm_addslider" action="<?php echo $vbaseurl ?>slider/fn_insert_update" method="post" accept-charset='utf-8'>
                	<input id="fictxtaccion" name="fictxtaccion" type="hidden" value="INSERTAR">

                	<input id="fictxtorden" name="fictxtorden" type="hidden" value="<?php echo $order->orden ?>">
                	
                	<div class="row mt-2">
						<div class="col-md-12 mb-3">
							<span>
								
								<b>Formatos aceptados</b><br>
							  	JPG: Es mas liviano y permite una carga veloz de la página <br>
								PNG: Suelen ser mas pesadas
							</span>
						</div>
					</div>

					<div class="row mt-2">
						<div class="form-group has-float-label col-12 col-sm-8">
							<input type="file" name="fictxtimagen" id="fictxtimagen" class="border p-2 w-100" accept="image/png, .jpeg, .jpg">
							<label for="fictxtimagen">imagen</label>
						</div>
						<div class="form-group col-md-4">
							<label for="checkestado">Publicar:</label>
							<input  id="checkestado" name="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 mb-3">
							<div class="my-3">
								<img class="previsualizarslide bg-light" style="width: 350px;height: 150px;">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12" id="msgslide">
							
						</div>
						<div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>portal-web/slider" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
			        		<button type="submit" class="btn btn-primary btn-md float-right"><i class="fas fa-save"></i> Registrar</button>
			        	</div>
					</div>
              	</form>
			</div>
		</div>
  	</section>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>

<script type="text/javascript">

	$('#fictxtimagen').change(function(){
		var imagen = this.files[0];

		if (this.files.length != 0) {
			var datosImagen = new FileReader;
	    	datosImagen.readAsDataURL(imagen);

	    	$(datosImagen).on("load", function(event){

	      		var rutaImagen = event.target.result;

	      		$(".previsualizarslide").attr("src", rutaImagen);
	      		$(".previsualizarslide").css("height","auto");

	    	})
		} else {
			$(".previsualizarslide").attr("src", "<?php echo $vbaseurl.'resources/img/placeholder.png' ?>");
			$(".previsualizarslide").css("height","150px");
		}
		
	});

	$('#frm_addslider').submit(function() {
	    $('#frm_addslider input,select').removeClass('is-invalid');
	    $('#frm_addslider .invalid-feedback').remove();
	    $('#divcard_slide').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    
	    var formData = new FormData($("#frm_addslider")[0]);
	    $.ajax({
	        url:$("#frm_addslider").attr("action"),
	        type:$("#frm_addslider").attr("method"),
	        dataType: 'json',
	        data: formData,
	        cache:false,
	        contentType:false,
	        processData:false,
	        success: function(e) {
	            $('#divcard_slide #divoverlay').remove();
	            
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });

	                if( $('#fictxtimagen').val() == 0){
	                	$('#fictxtimagen').addClass('is-invalid');
	                    $('#fictxtimagen').parent().append("<div class='invalid-feedback'>" + e.errimg + "</div>");
	                }
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#msgslide').html(msgf);
	                Swal.fire({
	                    title: e.msg,
	                    type: 'success',
	                    icon: 'success',
	                    allowOutsideClick: false,
                      	showConfirmButton: true,
	                }).then((result) => {
	                  	if (result.value) {
	                    	$(location).attr('href', base_url + 'portal-web/slider');
	                  	}
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divcard_slide #divoverlay').remove();
	            $('#msgslide').show();
	            $('#msgslide').html(msgf);
	        }
	    });
	    return false;
	});
</script>