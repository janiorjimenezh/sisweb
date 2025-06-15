<?php 
	$vbaseurl=base_url();
?>
<style>
	.bg-selection {
		background-color: #F9F4BC!important;
    	color: black;
	}
</style>
<div class="content-wrapper">
	<div class="modal fade" id="modupdaunidad" tabindex="-1" role="dialog" aria-labelledby="modupdaunidad" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xl" role="document">
      		<div class="modal-content" id="divmodalupdund">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="modtitleunidad">AGREGAR UNIDAD DIDÁCTICA</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<form class="" id="frm_unidad" action="<?php echo $vbaseurl ?>unidaddidactica/fn_insert_unidades" method="post" accept-charset="utf-8">
						<div class="row mt-2">
							<div class="form-group has-float-label col-12 col-sm-6">
								<input type="hidden" name="fictxtcodigo" id="fictxtcodigo" value="0">
								<input data-currentvalue='' value="" class="form-control text-uppercase" id="fictxtnombre" name="fictxtnombre" type="text" placeholder="Nombre unidad" />
								<label for="fictxtnombre">Nombre unidad</label>
							</div>
							<div class="form-group has-float-label col-6 col-sm-3">
								<select name="cbotipound" id="cbotipound" data-currentvalue='' class="form-control">
									<option value="">Seleccione tipo unidad</option>
									<option value="ESPEC">COMP. ESPECÍFICA</option>
									<option value="EMPLB">COMP. EMPLEABILIDAD</option>
									<option value="EFSRT">EFSRT</option>
									<option value="DEMOS">DEMOS</option>
									<option value="EXTRA">EXTRACURRICULAR</option>
								</select>
								<label for="cbotipound">Tipo</label>
							</div>
							<div class="form-group has-float-label col-6 col-sm-3">
								<select name="cbociclo" id="cbociclo" data-currentvalue='' class="form-control">
									<option value="">Seleccione Semestre</option>
									<?php foreach ($ciclo as $dts) {
										echo "<option value='$dts->id'>$dts->nomcic</option>";
									} ?>
								</select>
								<label for="cbociclo">Semestre</label>
							</div>
						</div>
						<div class="row mt-2">
							<div class="form-group has-float-label col-6 col-sm-3 col-md-3">
								<select name="txtprograma" id="txtprograma" class="form-control" onchange="fn_plan_programa($(this));return false;">
									<option value="">Seleccione carrera</option>
									<?php foreach ($carreras as $car) {
										$codcar = base64url_encode($car->id);
										echo "<option value='$codcar'>$car->nombre</option>";
									} ?>
								</select>
								<label for="txtprograma">Carrera</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-3 col-md-3">
								<select name="cboplan" id="cboplan" data-currentvalue='' class="form-control">
									<option value="" data-carrera='0'>Seleccione plan estudios</option>
									<?php foreach ($planes as $pln) {
										$codprog = base64url_encode($pln->codcar);
										echo "<option class='ocultar' data-carrera='$codprog' value='$pln->id'>$pln->nombre</option>";
									} ?>
								</select>
								<label for="cboplan">plan estudios</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-3 col-md-3">
								<select name="cbomodulo" id="cbomodulo" data-currentvalue='' class="form-control">
									<option value="">Sin opciones</option>
								</select>
								<label for="cbomodulo">Módulo</label>
							</div>
							<div class="form-group has-float-label col-12 col-sm-3 col-md-3">
								<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxthorter" name="fictxthorter" type="number" placeholder="Horas teoria" />
								<label for="fictxthorter">Horas teoria</label>
							</div>
						</div>
						<div class="row mt-2">
							<div class="form-group has-float-label col-6 col-sm-3">
								<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxthorprac" name="fictxthorprac" type="number" placeholder="Horas práctica" />
								<label for="fictxthorprac">Horas práctica</label>
							</div>
							<div class="form-group has-float-label col-6 col-sm-3">
								<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxthorcic" name="fictxthorcic" type="number" placeholder="Horas ciclo" />
								<label for="fictxthorcic">Horas Semestre</label>
							</div>
							<div class="form-group has-float-label col-6 col-sm-3">
								<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxtcredter" name="fictxtcredter" type="number" placeholder="Créditos teoria" />
								<label for="fictxtcredter">Créditos teoria</label>
							</div>
							<div class="form-group has-float-label col-6 col-sm-3">
								<input data-currentvalue='' value="" class="form-control" step='0.1' id="fictxtcredprac" name="fictxtcredprac" type="number" placeholder="Créditos práctica" />
								<label for="fictxtcredprac">Créditos práctica</label>
							</div>
						</div>
						<div class="row mt-1">
				        	<div class="col-12">
				        		<div id="divmsgunidad" class="float-left">
									
								</div>
							</div>
						</div>
					</form>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		          	<button type="button" id="btn_addunidad" class="btn btn-primary">Guardar</button>
		        </div>
      		</div>
    	</div>
  	</div>

	<section id="s-cargado" class="content pt-2">
		<div id="divcard_unidad" class="card">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-list-ul"></i> Listado de Unidades Didácticas</h3>
				<div class="card-tools">
					<button class="btn btn-outline-dark" data-toggle="modal" data-target="#modupdaunidad"><i class="fas fa-plus"></i> Agregar</button>
				</div>
			</div>
			<div class="card-body">
				<form id="frm-filtro-unidad" name="frm-filtro-unidad" action="<?php echo $vbaseurl ?>unidaddidactica/fn_unidad_x_parametros" method="post" accept-charset='utf-8'>
					<div class="row">
						<div class="form-group has-float-label col-6 col-xs-6 col-sm-3 col-md-3">
							<select name="txtcarrera" id="txtcarrera" class="form-control">
								<option value="0">Seleccione carrera</option>
								<?php foreach ($carreras as $car) {
									$codcar = base64url_encode($car->id);
									echo "<option value='$codcar'>$car->nombre</option>";
								} ?>
							</select>
							<label for="txtcarrera">Carrera</label>
						</div>
						<div class="form-group has-float-label col-6 col-xs-3 col-sm-3 col-md-3">
							<select name="txtplan" id="txtplan" class="form-control">
								<option data-carrera='0' value="0">Seleccione plan estudios</option>
								<?php foreach ($planes as $pln) {
									$codpl = base64url_encode($pln->id);
									$codcar = base64url_encode($pln->codcar);
									echo "<option class='ocultar' data-carrera='$codcar' value='$codpl'>$pln->nombre</option>";
								} ?>
							</select>
							<label for="txtplan">Nombre Plan</label>
						</div>
						<div class="form-group has-float-label col-6 col-xs-6 col-sm-3 col-md-3">
							<select data-plan='0' name="txtmodulo" id="txtmodulo" class="form-control">
								<option value="0">Seleccione módulo</option>
								<?php foreach ($modulos as $mdls) {
									$codmod = base64url_encode($mdls->id);
									$idplan = base64url_encode($mdls->idplan);
									echo "<option class='ocultar' data-plan='$idplan' value='$codmod'>$mdls->modnom</option>";
								} ?>
							</select>
							<label for="txtmodulo">Nombre Módulo</label>
						</div>
						
						<div class="form-group has-float-label col-6 col-xs-6 col-sm-2 col-md-2">
							<select name="txtciclo" id="txtciclo" class="form-control">
								<option value="0">Semestre</option>
								<?php foreach ($ciclo as $dts) {
									$codcic = base64url_encode($dts->id);
									echo "<option value='$codcic'>$dts->nomcic</option>";
								} ?>
							</select>
							<label for="txtciclo">Semestre</label>
						</div>
						<div class="col-12 col-xs-3 col-sm-1 col-md-1">
							<button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
						</div>
					</div>
				</form>
				<div class="row">
	                <div class="col-12 py-1" id="divdata-unidad">
	                	<div class="border rounded p-3">
	                		<span class="text-danger">Utiliza el cuadro de búsqueda ubicado arriba para encontrar el historial existente de las unidades didácticas</span>
	                	</div>
	                </div>
	            </div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('[data-toggle="popover"]').popover({
            trigger: 'hover',
            html: true
        })
	});
	$('#frm-filtro-unidad select').change(function(event) {
	    if ($(this).attr('id') == "txtcarrera") {
	        $('#frm-filtro-unidad #txtplan').val("0");
	        $('#frm-filtro-unidad #txtmodulo').val("0");
	        var codcar = $(this).val();
	       	$("#frm-filtro-unidad #txtplan option").each(function(i){
		        
		        if ($(this).data('carrera')=='0'){

		        }
		        else if ($(this).data('carrera')==codcar){
		        	$(this).removeClass('ocultar');
		        }
		        else{
		        	if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
		        }
		    });
	    }
	    if ($(this).attr('id') == "txtplan") {
	        $('#frm-filtro-unidad #txtmodulo').val("0");
	        var codplan = $(this).val();
	       	$("#frm-filtro-unidad #txtmodulo option").each(function(i){
		        if ($(this).data('plan')=='0'){

		        }
		        else if ($(this).data('plan')==codplan){
		        	$(this).removeClass('ocultar');
		        }
		        else{
		        	if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
		        }
		    });
	    }
	});

	$('#frm-filtro-unidad').submit(function() {
	    $('#divdata-unidad').html("");
	    $('#frm-filtro-unidad input:text, select').removeClass('is-invalid');
	    $('#frm-filtro-unidad .invalid-feedback').remove();
	    $('#divcard_unidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divcard_unidad #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().parent().after("<div class='invalid-feedback btn-block'>" + val + "</div>");
	                });
	            } else {
	                $('#divdata-unidad').html(e.vdata);
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'div');
	            $('#divcard_unidad #divoverlay').remove();
	            $('#divdata-unidad').html(msgf);
	        }
	    });
	    return false;
	});

	function viewupdaunidad(btn) {
		var codigo = btn.data('idund');
		$('#divcard_unidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
 		$("#divdatosunidad").html("");
	  	$.ajax({
	      	url: base_url + "unidaddidactica/vwmostrar_datosxcodigo",
	      	type: 'post',
	     	dataType: "json",
	      	data: {txtcodigo: codigo},
	      	success: function(e) {
	        	$('#divcard_unidad #divoverlay').remove();
	        	// $("#divdatosunidad").html(e.unidup);
	        	$('#modtitleunidad').html("ACTUALIZAR UNIDAD DIDÁCTICA");
	        	$("#fictxtcodigo").val(e.vdata['idund64']);
	        	$("#fictxtnombre").val(e.vdata['uninom']);
	        	$("#cbotipound").val(e.vdata['unitip']);
	        	$("#cbociclo").val(e.vdata['idcic']);
	        	$("#txtprograma").val(e.vdata['carrera64']);
	        	fn_plan_programa($("#txtprograma"));
	        	$("#cboplan").val(e.vdata['plan']);
	        	$("#cbomodulo").html(e.vmodulos);
	        	$("#cbomodulo").val(e.vdata['idmod']);

	        	$("#fictxthorter").val(e.vdata['horter']);
	        	$("#fictxthorprac").val(e.vdata['horprac']);
	        	$("#fictxthorcic").val(e.vdata['horcic']);
	        	$("#fictxtcredter").val(e.vdata['credter']);
	        	$("#fictxtcredprac").val(e.vdata['credprac']);

	        	$("#modupdaunidad").modal("show");
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception, 'div');
	          	$('#divcard_unidad #divoverlay').remove();
	          	$("#modupdaunidad modal-body").html(msgf);
	      	} 
	  	});
  		return false;
	}

	function fn_plan_programa(btn) {
		var codcar = btn.val();
		console.log("codcar", codcar);
     	$("#frm_unidad #cboplan option").each(function(i){
        
	        if ($(this).data('carrera')=='0'){

	        }
	        else if ($(this).data('carrera')==codcar){
	        	$(this).removeClass('ocultar');
	        }
	        else{
	        	if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
	        }
	    });
	}

	$('#frm_unidad select').change(function(event) {
	    if ($(this).attr('id') == "cboplan") {
	        $('#divmodalupdund').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $('#frm_unidad #cbomodulo').html("<option value='0'>Sin opciones</option>");
	        var plan = $(this).val();
	        $.ajax({
	            url: base_url + 'unidaddidactica/fnmodulo_x_planes',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtplan: plan
	            },
	            success: function(e) {
	                $('#divmodalupdund #divoverlay').remove();
	                $('#frm_unidad #cbomodulo').html(e.vdata);
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#frm_unidad #cbomodulo').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	    }
	});

	$('#btn_addunidad').click(function() {
	    $('#frm_unidad input,select').removeClass('is-invalid');
	    $('#frm_unidad .invalid-feedback').remove();
	    $('#divmodalupdund').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    var codigound = $('#fictxtcodigo').val();
	    $.ajax({
	        url: $('#frm_unidad').attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $('#frm_unidad').serialize(),
	        success: function(e) {
	            $('#divmodalupdund #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                
	            } else {
	                var msgf = '<span class="text-success"><i class="fa fa-check"></i> ' + e.msg + '</span>';
	                $('#divmsgunidad').html(msgf);
	                Swal.fire({
	                    title: e.msg,
	                    // text: "",
	                    type: 'success',
	                    icon: 'success',
	                }).then((result) => {
	                  if (result.value) {
	                    //location.reload();
	                  }
	                })

	                if (codigound !== '0') {
	                	$("#modupdaunidad").modal("hide");
	                }
	                $("#fictxtnombre").val("");
	                $('#frm-filtro-unidad').submit();
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception,'text');
	            $('#divmodalupdund #divoverlay').remove();
	            $('#divmsgunidad').show();
	            $('#divmsgunidad').html(msgf);
	        }
	    });
	    return false;
	});

	$("#modupdaunidad").on('hidden.bs.modal', function () {
		$('#frm_unidad input,select').removeClass('is-invalid');
	    $('#frm_unidad .invalid-feedback').remove();
        $('#frm_unidad')[0].reset();
        $("#fictxtcodigo").val("0");
        $('#modtitleunidad').html("AGREGAR UNIDAD DIDÁCTICA");
        $('#divmsgunidad').html('');
        // $('#frm_unidad #cboplan').html("<option value=''>Sin opciones</option>");
        $("#frm_unidad #cboplan option").each(function(i){
        	if ($(this).data('carrera') != '0'){
        		$(this).addClass('ocultar');
	        }
        })
        $('#frm_unidad #cbomodulo').html("<option value=''>Sin opciones</option>");
    });

    function fn_rowselection(btn) {
	    $("#divdata-unidad .cfila").removeClass("bg-selection");
	    btn.addClass("bg-selection");
	};

	function fn_update_estado_und(btn) {
	    fila = btn.closest('.rowcolor');
	    codigo = btn.data('codigo');
	    flat = btn.data('flat');
	    act = btn.data('act');

	    var estado = "desactivar";
	    var titulo="¿Deseas desactivar esta unidad didáctica Seleccionada?";
	    if (flat=="activarunidad"){
	        titulo="¿Deseas activar esta unidad didáctica Seleccionada?";
	        estado = "activar";
	    }
	    Swal.fire({
	        title: titulo,
	        text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Si, '+estado+'!'
	    }).then(function(result){
	        if(result.value){
	            $('#divcard_unidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	            
	            $.ajax({
	                url: base_url + 'unidaddidactica/fn_update_status_unidad_didactica',
	                method: "POST",
	                dataType: 'json',
	                data: {
	                    undcod : codigo,
	                    accion: act,
	                },
	                success:function(e){
	                    $('#divcard_unidad #divoverlay').remove();
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

	                        btn.removeClass('btn-danger');
	                        btn.removeClass('btn-success');

	                        if (act == "SI") {
	                            fila.find('.msgtooltip').attr('title','Desactivar');
	                            btn.addClass('btn-success');
	                            btn.data('flat','desactivarunidad');
	                            btn.data('act','NO');
	                            btn.html('<i class="fa fa-toggle-on"></i>');
	                        } else {
	                            fila.find('.msgtooltip').attr('title','Activar');
	                            btn.addClass('btn-danger');
	                            btn.data('flat','activarunidad');
	                            btn.data('act','SI');
	                            btn.html('<i class="fa fa-toggle-off"></i>');
	                        }

	                        $('[data-toggle="popover"]').popover({
					            trigger: 'hover',
					            html: true
					        })
	                                                
	                    } else {
	                        Swal.fire({
	                            title: "Error",
	                            text: 'No se pudo actualizar',
	                            type: "error",
	                            icon: "error",
	                            allowOutsideClick: false,
	                            confirmButtonText: "¡Cerrar!"
	                        });
	                    }
	                },
	                error: function(jqXHR, exception) {
	                    var msgf = errorAjax(jqXHR, exception,'text');
	                    $('#divcard_unidad #divoverlay').remove();
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

	function fn_delete_unidad(btn) {
		fila = btn.closest('.rowcolor');
	    codigo = btn.data('idund');
	    Swal.fire({
	        title: 'Desea eliminar esta unidad didáctica Seleccionada?',
	        text: "¡Si no lo está puede cancelar la acción!",
	        type: 'warning',
	        icon: 'warning',
	        showCancelButton: true,
	        allowOutsideClick: false,
	        cancelButtonText: 'Cancelar',
	        confirmButtonText: 'Eliminar'
	    }).then(function(result){
	    	if(result.value){
	            $('#divcard_unidad').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	            
	            $.ajax({
	                url: base_url + 'unidaddidactica/fn_eliminar_unidad',
	                method: "POST",
	                dataType: 'json',
	                data: {
	                    txtcodigo : codigo,
	                },
	                success:function(e){
	                    $('#divcard_unidad #divoverlay').remove();
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
	                        ordenarnro("divdata_unidades");
	                                                
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
	                    $('#divcard_unidad #divoverlay').remove();
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

	function ordenarnro(div) {
	    var nro = 0;
	    
	    $("#" + div + " .tdnro").each(function(index) {
	        nro = nro + 1;
	        $(this).html(nro);
	    });
	}

</script>