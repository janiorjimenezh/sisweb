<?php
	$vbaseurl=base_url();
	date_default_timezone_set('America/Lima');
	$vuser=$_SESSION['userActivo'];
	$fechahoy = date('Y-m-d');
?>

<style>
	.border-dashed {
		border-bottom: #000 1px dashed;
	}

	.h7 {
		font-size: 0.75rem;
	}
</style>
<div class="content-wrapper">
	<div class="modal fade" id="modconvalida" tabindex="-1" role="dialog" aria-labelledby="modconvalida" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog modal-xl" role="document">
		    <div class="modal-content" id="divmodalconvalida">
		      	<div class="modal-header">
			        <h5 class="modal-title">Récord Académico</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
		      	</div>
		      	<div class="modal-body">
		      		<form id="form_addmatricula" action="" method="post" accept-charset="utf-8">
			            <input type="hidden" name="fmt-cbncodmatcurso" id="fmt-cbncodmatcurso" value="0">
			            <input type="hidden" name="fmt-cbncodmatricula" id="fmt-cbncodmatricula" value="0">
			            <input type="hidden" name="fmt-cbncargaacadem" id="fmt-cbncargaacadem" value="">
			            <input type="hidden" name="fmt-cbncargaacadsubsec" id="fmt-cbncargaacadsubsec" value="">
			            <input type="hidden" name="fmt-cbninscripcion" id="fmt-cbninscripcion" value="">
			            <div class="row">
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-3">
				                <select class="form-control form-control-sm" id="fmt-cbtipo" name="fmt-cbtipo">
				                  	<option value="MANUAL" data-tipo="MANUAL">MANUAL</option>
				                  	<option value="PLATAFORMA" data-tipo="PLATAFORMA">PLATAFORMA</option>
				                  	<option value="CONVALIDA" data-tipo="CONVALIDA">CONVALIDA</option>
				                </select>
				                <label for="fmt-cbtipo"> Tipo</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
				                <select class="form-control form-control-sm" id="fmt-cbnperiodo" name="fmt-cbnperiodo" placeholder="Periodo">
				                	<?php
				                  	foreach ($periodos as $key => $periodo) {
				                  		echo "<option value='$periodo->codigo'>$periodo->nombre</option>";
				                  	}
				                  	?>
				                </select>
				                <label for="fmt-cbnperiodo"> Periodo</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-7">
				                <select class="form-control form-control-sm" id="fmt-cbncarrera" name="fmt-cbncarrera">
				                  	<option value="0"></option>
				                  	<?php
				                  	foreach ($carreras as $key => $carrera) {
				                  		echo "<option value='$carrera->codcarrera'>$carrera->nombre</option>";
				                  	}
				                  	?>
				                  
				                </select>
				                <label for="fmt-cbncarrera"> Programa</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-5">
				                <select class="form-control form-control-sm" id="fmt-cbnplan" name="fmt-cbnplan" onchange="get_unidades('fmt-cbnciclo','fmt-cbnplan');">
				                  	<option value=""></option>
				                </select>
				                <label for="fmt-cbnplan"> Plan</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
				                <select class="form-control form-control-sm" id="fmt-cbnciclo" name="fmt-cbnciclo" onchange="get_unidades('fmt-cbnciclo','fmt-cbnplan');">
				                  	<option value="0"></option>
				                  	<?php
				                  	foreach ($ciclos as $key => $ciclo) {
				                  		echo "<option value='$ciclo->codigo'>$ciclo->nombre</option>";
				                  	}
				                  	?>
				                </select>
				                <label for="fmt-cbnciclo"> Ciclo</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-3">
				                <select class="form-control form-control-sm" id="fmt-cbnturno" name="fmt-cbnturno">
				                	<?php
				                  	foreach ($turnos as $key => $turno) {
				                  		echo "<option value='$turno->codigo'>$turno->nombre</option>";
				                  	}
				                  	?>
				                </select>
				                <label for="fmt-cbnturno"> Turno</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-2">
				                <select class="form-control form-control-sm" id="fmt-cbnseccion" name="fmt-cbnseccion">
				                	<?php
				                  	foreach ($secciones as $key => $seccion) {
				                  		echo "<option value='$seccion->codigo'>$seccion->nombre</option>";
				                  	}
				                  	?>
				                </select>
				                <label for="fmt-cbnseccion"> Sección</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-6">
				                <select class="form-control form-control-sm" id="fmt-cbnunididact" name="fmt-cbnunididact">
				                  	<option value=""></option>
				                </select>
				                <label for="fmt-cbnunididact"> Und. didac.</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-6">
				                <select class="form-control form-control-sm" id="fmt-cbndocente" name="fmt-cbndocente">
				                  	<option value=""></option>
				                  	<?php
				                  	foreach ($docentes as $key => $docente) {
				                  		$nomdocente = $docente->paterno . ' ' . $docente->materno . ' ' . $docente->nombres;
				                  		echo "<option value='$docente->coddocente'>$nomdocente</option>";
				                  	}
				                  	?>
				                </select>
				                <label for="fmt-cbndocente"> Docente</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
				                <input type="number" name="fmt-cbnnotafinal" id="fmt-cbnnotafinal" class="form-control form-control-sm" placeholder="Nota final">
				                <label for="fmt-cbnnotafinal"> Nota final</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
				                <input type="number" name="fmt-cbnnotarecup" id="fmt-cbnnotarecup" class="form-control form-control-sm" placeholder="Recuperación">
				                <label for="fmt-cbnnotarecup"> Recuperación</label>
			              	</div>
			              	<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
			                	<input type="date" name="fmt-cbnfecha" id="fmt-cbnfecha" class="form-control form-control-sm" value="<?php echo $fechahoy ?>">
			                	<label for="fmt-cbnfecha"> Fecha</label>
			              	</div>
			              	<div id="divcontent_convalida" class="border border-dark rounded p-2 col-12 mb-2 d-none">
				                <span class="font-weight-bold">CONVALIDACIÓN</span>
				                <div class="row mt-2">
				                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-6">
				                    	<input type="text" name="fmt-cbnresolucion" id="fmt-cbnresolucion" class="form-control form-control-sm" placeholder="Resolución">
				                    	<label for="fmt-cbnresolucion"> Resolución</label>
				                  	</div>
				                  	<div class="form-group has-float-label col-12 col-sm-6 col-md-6">
				                    	<input type="date" name="fmt-cbnfechaconv" id="fmt-cbnfechaconv" class="form-control form-control-sm">
				                    	<label for="fmt-cbnfechaconv"> Fecha Convalida</label>
				                  	</div>
				                </div>
			              	</div>
			              
			              	<div class="form-group has-float-label col-12">
			                	<textarea name="fmt-cbnobservacion" id="fmt-cbnobservacion" class="form-control form-control-sm" placeholder="Observación" rows="3"></textarea>
			                	<label for="fmt-cbnobservacion"> Observación</label>
			              	</div>
			              	<div class="col-12">
			                	<!-- <button type="submit" class="btn btn-primary btn-sm float-right">Guardar</button> -->
			              	</div>
			            </div>
			            
			        </form>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		        	<button type="button" class="btn btn-primary" data-inscrito='' id="btnaddconvalidad">Guardar</button>
		      	</div>
		    </div>
	  	</div>
	</div>

	<div class="modal fade" id="modfiltroins" tabindex="-1" role="dialog" aria-labelledby="modfiltroins" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog modal-xl" role="document">
		    <div class="modal-content" id="divmodalsearch">
		      	<div class="modal-header">
			        <h5 class="modal-title" >Buscar Inscritos Activos</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
		      	</div>
		      	<div class="modal-body">
			        <form id="frm-getinscritonew" action="<?php echo base_url() ?>matricula/fn_filtrar_inscritos" method="post" accept-charset="utf-8">
			          	<div class="row pt-1">
				            <div class="col-12">
				              	<small>Ingresa Apellidos y nombres</small>
				            </div>
				            <div class="input-group mb-3 col-12 col-12 col-sm-12">
				              	<input autocomplete="off" placeholder="Apellidos y nombres" type="text" class="form-control form-control-sm" id="fbus-txtbuscar" name="fbus-txtbuscar">
				              	<div class="input-group-append">
					                <button data-paterno="" data-materno="" data-nombres="" class="btn btn-info btn-sm" type="submit">
					                	<i class="fas fa-arrow-alt-circle-right"></i>
					                </button>
				              	</div>
				            </div>
			          	</div>
			        </form>
		        	<div id="divcard_result"></div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		        	<!-- <button type="button" id="" class="btn btn-primary">Guardar</button> -->
		      	</div>
		    </div>
	  	</div>
	</div>

	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
			<div class="card-header">
				<h3 class="card-title text-danger font-weight-bold">Récord Académico</h3>
			</div>
			<div class="card-body">
				<div class="border rounded p-2 mb-2">
					<div class="row">
						<!-- <div class="mb-2 col-12 border-bottom">
							<h4>Récord Académico</h4>
						</div> -->
						<div class="mb-2 col-md-8">
							<span><b class="mr-1">Estudiante:</b> <span class="" id="divcard_estudiante"></span></span>
						</div>
						<div class="mb-2 col-md-4">
							<div class="row">
								<div class="col-8 col-md-9">
									<span><b class="mr-1">Edad Actual:</b> <span id="divcard_edad"></span></span>
								</div>
								<div class="col-4 col-md-3">
									<button class="btn btn-sm btn-info" data-toggle='modal' data-target='#modfiltroins'>
										<i class="fas fa-search"></i>
									</button>
								</div>
							</div>
							
						</div>
						<div class="mb-2 col-md-8">
							<span><b class="mr-1">Programa:</b> <span id="divcard_programa"></span></span>
						</div>
						<div class="mb-2 col-md-4">
							<span><b class="mr-1">Sede/Filial:</b> <span id="divcard_filial"></span></span>
						</div>
					</div>
				</div>

				<div class="col-12 btable">
                    <div class="col-md-12 thead d-none d-md-block">
                    	<div class="row border-bottom-0">
                    		<div class="col-12 td text-center h7 mb-0">Itinerarios</div>
                    	</div>
                        <div class="row">
                            <div class="col-6 col-md-8">
                                <div class="row">
                                    <div class="col-1 col-md-1 td">Nro</div>
                                    <div class="col-11 col-md-7 td">Unid. didáctica</div>
                                    <div class="col-6 col-md-2 td text-center">Periodo</div>
                                    <div class="col-6 col-md-2 td">Estado</div>
                                    
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="row">
                                	<div class="col-3 col-md-3 td">Vez</div>
                                    <div class="col-3 col-md-3 td">Nota</div>
                                    <div class="col-3 col-md-3 td">Origen</div>
                                    <div class="td col-3 col-md-3 text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 tbody" id="vw_fcb_div_itinerarios"></div>
                </div>
			</div>
		</div>
	</section>
</div>

<script>
	$('#modfiltroins').on('shown.bs.modal', function(e) {
	    $('#fbus-txtbuscar').focus();
	})

	$("#frm-getinscritonew").submit(function(event) {
	    $('#frm-getinscritonew input').removeClass('is-invalid');
	    $('#frm-getinscritonew .invalid-feedback').remove();
	    $('#divmodalsearch').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $.ajax({
	        url: $(this).attr("action"),
	        type: 'post',
	        dataType: 'json',
	        data: $(this).serialize(),
	        success: function(e) {
	            $('#divmodalsearch #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                Swal.fire({
	                    type: 'warning',
	                    icon: 'warning',
	                    title: 'ADVERTENCIA',
	                    text: e.msg,
	                    backdrop: false,
	                })
	            } else {
	                $('#divcard_result').html('');
	                var tabla = '';
	                var tbody = '';
	                var estado = '';
	                // var viewmat = matricula;
	                var btnselect = '';
	                tabla = '<div class="col-12 py-1">' +
	                    '<div class="btable">' +
	                    '<div class="thead col-12  d-none d-md-block">' +
	                    '<div class="row">' +
	                    '<div class="col-12 col-md-5">' +
	                    '<div class="row">' +
	                    '<div class="col-2 col-md-2 td">N°</div>' +
	                    '<div class="col-10 col-md-10 td">ESTUDIANTE</div>' +
	                    '</div>' +
	                    '</div>' +
	                    '<div class="col-12 col-md-6">' +
	                    '<div class="row">' +
	                    '<div class="col-3 col-md-3 td">ESTADO</div>' +
	                    '<div class="col-9 col-md-4 td">PROG.</div>' +
	                    '<div class="col-9 col-md-5 td">PLAN ESTUDIOS</div>' +
	                    '</div>' +
	                    '</div>' +
	                    '<div class="col-12 col-md-1 text-center">' +
	                    '<div class="row">' +
	                    '<div class="col-12 col-md-12 td">' +
	                    '<span></span>' +
	                    '</div>' +
	                    '</div>' +
	                    '</div>' +
	                    '</div>' +

	                    '</div>' +
	                    '<div class="tbody col-12" id="divcard_data_alumnos">' +

	                    '</div>' +
	                    '</div>' +
	                    '</div>';
	                var nro = 0;
	                $.each(e.vdata, function(index, val) {
	                    nro++;
	                    if (val['estado'] == "ACTIVO") {
	                        estado = "<span class='badge bg-success p-2'> " + val['estado'] + " </span>";
	                        btnselect = "<a href='#' onclick='fn_select_inscrito($(this),null);return false;' class='btn btn-info btn-sm btn_select' title='seleccionar'><i class='fas fa-share'></i></a>";
	                    } else if (val['estado'] == "POSTULA") {
	                        estado = "<span class='badge bg-warning p-2'> " + val['estado'] + " </span>";
	                        btnselect = '';
	                    } else if (val['estado'] == "EGRESADO") {
	                        estado = "<span class='badge bg-secondary p-2'> " + val['estado'] + " </span>";
	                        btnselect = '';
	                    } else if (val['estado'] == "RETIRADO") {
	                        estado = "<span class='badge bg-danger p-2'> " + val['estado'] + " </span>";
	                        btnselect = '';
	                    } else if (val['estado'] == "TITULADO") {
	                        estado = "<span class='badge bg-info p-2'> " + val['estado'] + " </span>";
	                        btnselect = '';
	                    } else {
	                        estado = "<span class='badge bg-warning p-2'> " + val['estado'] + " </span>";
	                        btnselect = '';
	                    }
	                    if (val['estado'] !== "RETIRADO") {
	                        tbody = tbody +
	                            "<div class='row rowcolor cfilains' data-carnet='" + val['carnet'] + "' data-alumno='" + val['paterno'] + " " + val['materno'] + " " + val['nombres'] + "' data-programa='"+val['carrera']+"' data-sede='"+val['sede']+"' data-edad='"+val['edad']+"' data-plan='"+val['codplan']+"' data-idcarrera='"+val['codcarrera']+"' data-codins='"+val['codinscripcion']+"'>" +
	                            "<div class='col-12 col-md-5'>" +
	                            "<div class='row'>" +
	                            "<div class='col-1 col-md-2 text-right td'>" + nro + "</div>" +
	                            "<div class='col-3 col-md-3  td'>" + val['carnet'] + "</div>" +
	                            "<div class='col-8 col-md-7 td' title='" + val['codinscripcion'] + "'>" + val['paterno'] + " " + val['materno'] + " " + val['nombres'] + "</div>" +
	                            "</div>" +
	                            "</div>" +
	                            "<div class='col-12 col-md-6'>" +
	                            "<div class='row'>" +
	                            "<div class='col-3 col-md-3 td text-center'>" + estado + "</div>" +
	                            "<div class='col-6 col-md-4 td' title='" + val['carrera'] + "'>" + val['carrera'] + "</div>" +
	                            "<div class='col-3 col-md-5 td'>" + val['plan'] + "</div>" +
	                            "</div>" +
	                            "</div>" +
	                            "<div class='col-12 col-md-1 text-center td'>" +
	                            btnselect +
	                            "</div>" +
	                            "</div>";
	                    }

	                })
	                $('#divcard_result').html(tabla);
	                $('#divcard_data_alumnos').html(tbody);
	                

	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divmodalsearch #divoverlay').remove();
	            $('#divError').show();
	            $('#msgError').html(msgf);
	        }
	    });
	    return false;
	});

	function fn_select_inscrito(btn,view) {
		if (view != null) {
			var carne = btn.data('carnet');
			var idplan = btn.data('plan');
			var idcarrera = btn.data('idcarrera');
			var idinscrito = btn.data('codins');
		}
		else {
			var fila = btn.closest('.cfilains');
			var carne = fila.data('carnet');
			var idplan = fila.data('plan');
			var idcarrera = fila.data('idcarrera');
			var idinscrito = fila.data('codins');
		}
		
  		$('#divmodalsearch').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	  	$.ajax({
	      	url: base_url + "convalidaciones/fn_get_datos_itinerarios",
	      	type: 'post',
	      	dataType: 'json',
	      	data: {
	          	'fic_txtcarne': carne,
	          	'fic_txtplan': idplan,
	          	'fic_txtcarrera': idcarrera,
	          	'fic_txtinscrito': idinscrito,
	      	},
	      	success: function(e) {
	          	$('#divmodalsearch #divoverlay').remove();
	          	if (e.status == false) {
	              	$.each(e.errors, function(key, val) {
	                  	$('#' + key).addClass('is-invalid');
	                  	$('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	              	});
	              	Swal.fire({
	                  	type: 'warning',
	                  	icon: 'warning',
	                  	title: 'ADVERTENCIA',
	                  	text: e.msg,
	                  	backdrop: false,
	              	})
	          	} else {

	          		if (view == null) {
		          		$('#divcard_estudiante').html("<b class='text-danger'>"+carne+"</b> / <b class='text-primary'>"+fila.data('alumno')+"</b>");
		          		$('#divcard_edad').html(fila.data('edad'));
		          		$('#divcard_programa').html(fila.data('programa'));
		          		$('#divcard_filial').html(fila.data('sede'));
		          		$('#modfiltroins').modal('hide');
		          	}

	          		var nro = 0;
	          		var tbody = '';
	          		var btnorigennt = "";
	          		var txtorigen = "";
	          		var inputfinal = "";
	          		var btnedit = "";
	          		var inputdisabled = "";
	          		var grupo = "";
	                $.each(e.vdata, function(index, val) {
	                	
	                	txtorigen = val['ntipo'];

                        anota = val['nota'];
						colorbtn = "text-danger";
                        if (anota >= 12.5) colorbtn = "text-primary";

                        recuperacion = val['recuperacion'];
						if (recuperacion >= 12.5) colorbtnrc = "text-primary";

						if (val['nestado'] == "PNT") {
		          			inputdisabled = "disabled='disabled'";
		          		} else {
		          			inputdisabled = "";
		          		}

		          		if (e.vpermiso204 == "SI") {
		          			btnedit = "<button class='btn btn-sm btn-info' onclick='fn_view_data_indivisual($(this));return false;'><i class='fas fa-edit'></i></button>";
		          		}

		          		grupoint = val['idcic'];

		          		if (grupo != grupoint) {
		          			grupo = grupoint;
		          			tbody = tbody +
	          					"<div class='row'>"+
	          						"<div class='col-12 td text-center h7 font-weight-bold bg-olive'>" +
	          							val['cicnom'] + " Semestre" +
	          						"</div>"+
	          					"</div>";
	          				nro = 0;
		          		}
		          		nro++;

	                	tbody = tbody +
                            "<div class='row rowcolor cfilaitine' data-idmanota='"+val['codigo64']+"' data-final='" + anota + "' data-recupera='" + recuperacion + "' data-codcarrera='"+val['codcarrera']+"' data-idplan='"+val['idplan']+"' data-idsemestre='"+val['idcic']+"' data-unidad='"+val['id']+"' data-inscrito='"+idinscrito+"'>" +
                            "<div class='col-12 col-md-8'>" +
                            "<div class='row'>" +
                            "<div class='col-1 col-md-1 text-center td'>" + nro + "</div>" +
                            "<div class='col-11 col-md-7 td'>(" + val['id'] + ") " + val['uninom'] + "</div>" +
                            "<div class='col-6 col-md-2 td text-center'>" + 
                            val['nperiodo'] +
                            "</div>" +
                            "<div class='col-6 col-md-2 td text-center'>" + 
                            val['nestado'] +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-12 col-md-4'>" +
                            "<div class='row'>" +
                            "<div class='col-3 col-md-3 td text-center'>" + val['nroveces'] + "</div>" +
                            "<div class='col-3 col-md-3 td text-center " + colorbtn + "'>" + anota + "</div>" +
                            "<div class='col-3 col-md-3 td text-center'>"+ txtorigen + "</div>" +
                            "<div class='col-3 col-md-3 td text-center'>"+
                            btnedit +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
	                })

	                $('#vw_fcb_div_itinerarios').html(tbody);
	                
	                $('#vw_fcb_div_itinerarios .nf_origen').change();
	              	
	          	}
	      	},
	      	error: function(jqXHR, exception) {
	          	var msgf = errorAjax(jqXHR, exception, 'text');
	          	$('#divmodalsearch #divoverlay').remove();
	          	$('#divError').show();
	          	$('#msgError').html(msgf);
	      	}
	  	})
	}

	function fn_view_data_indivisual(btn) {
		$('#modconvalida').modal();
		var fila = btn.closest('.cfilaitine');
		var codmat = fila.data('idmanota');
		var codcarrera = fila.data('codcarrera');
		var codplan = fila.data('idplan');
		var semestre = fila.data('idsemestre');
		var unidad = fila.data('unidad');
		var idinscrito = fila.data('inscrito');
		$('#divmodalconvalida').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
	        url: base_url + 'matricula_independiente/fn_get_matriculacurso_codigo',
	        type: 'post',
	        dataType: 'json',
	        data: {
	            txtcodigo: codmat,
	        },
	        success: function(e) {
	        	
	        	$('#btnaddconvalidad').data('codins', idinscrito);
	        	$('#btnaddconvalidad').data('idcarrera', codcarrera);
	        	$('#btnaddconvalidad').data('plan', codplan);
	        	$('#btnaddconvalidad').data('carnet', '');
	        	$('#fmt-cbninscripcion').val(idinscrito);
	            if (e.status == true) {
	                $('#fmt-cbncodmatricula').val(e.vdata['codmatric64']);
	                $('#fmt-cbncargaacadem').val(e.vdata['idcarga']);
	                $('#fmt-cbncargaacadsubsec').val(e.vdata['codsubsec']);
	                $('#fmt-cbtipo').val(e.vdata['tipo']);
	                $('#fmt-cbnperiodo').val(e.vdata['idperiodo']);
	                $('#fmt-cbncarrera').val(e.vdata['idcarrera']);
	                $("#form_addmatricula #fmt-cbncarrera option").each(function(i) {
			        	if ($(this).val() == e.vdata['idcarrera']) {
			        		if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
			        	} else {
			        		if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
			        	}
			        });
			        $('#fmt-cbncarrera').change();
	                
	                $('#fmt-cbnciclo').val(e.vdata['idciclo']);
	                $('#fmt-cbnturno').val(e.vdata['idturno']);
	                $('#fmt-cbnseccion').val(e.vdata['idseccion']);
	                $('#fmt-cbnfecha').val(e.vdata['fechaf']);
	                $('#fmt-cbndocente').val(e.vdata['codocente']);
	                $('#fmt-cbnresolucion').val(e.vdata['valida']);
	                $('#fmt-cbnobservacion').val(e.vdata['observacion']);
	                $('#fmt-cbnnotafinal').val(e.vdata['notaf']);
	                $('#fmt-cbncodmatcurso').val(e.vdata['codigo64']);
	                if (e.vdata['vfecha'] !== null) {
	                    $('#fmt-cbnfechaconv').val(e.vdata['vfecha']);
	                }
	                if (e.vdata['notar'] !== null) {
	                    $('#fmt-cbnnotarecup').val(e.vdata['notar']);
	                }
	                
	                setTimeout(function() {
	                	// $('#fmt-cbnplan').val(codplan);
	                	$('#fmt-cbnplan').val(e.vdata['codplan']);
		                $("#form_addmatricula #fmt-cbnplan option").each(function(i) {
				        	if ($(this).val() == e.vdata['codplan']) {
				        		if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
				        	} else {
				        		if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
				        	}
				        });
	                    get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
	                }, 500);
	                setTimeout(function() {
	                    $('#fmt-cbnunididact').val(e.vdata['idunidad']);
	                    $("#form_addmatricula #fmt-cbnunididact option").each(function(i) {
				        	if ($(this).val() == e.vdata['idunidad']) {
				        		if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
				        	} else {
				        		if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
				        	}
				        });
	                }, 3000);
	                
	                $('#fmt-cbtipo').change();
	                setTimeout(function() {
	                    $('#divmodalconvalida #divoverlay').remove();
	                }, 8000);
	            }
	            else {
	            	$('#fmt-cbncodmatcurso').val('0');
	            	if (codcarrera != "") {
				    	$("#form_addmatricula #fmt-cbncarrera").val(codcarrera);
				        $("#form_addmatricula #fmt-cbncarrera option").each(function(i) {
				        	if ($(this).val() == codcarrera) {
				        		if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
				        	} else {
				        		if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
				        	}
				        });
				        $('#fmt-cbncarrera').change();
				        $('#fmt-cbnciclo').val(semestre);

				        window.setTimeout( function() {
						    $('#fmt-cbnplan').val(codplan);
						    $("#form_addmatricula #fmt-cbnplan option").each(function(i) {
					        	if ($(this).val() == codplan) {
					        		if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
					        	} else {
					        		if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
					        	}
					        });
						    $('#fmt-cbnciclo').change();
						}, 1000);

						window.setTimeout( function() {
						    $('#fmt-cbnunididact').val(unidad);
						    $("#form_addmatricula #fmt-cbnunididact option").each(function(i) {
					        	if ($(this).val() == unidad) {
					        		if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
					        	} else {
					        		if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
					        	}
					        });

						}, 3000);
						window.setTimeout( function() {
						    $('#divmodalconvalida #divoverlay').remove();
						}, 8000);
				        
				    }
	            }
	        },
	        error: function(jqXHR, exception) {
	            $('#divmodalconvalida #divoverlay').remove();
	            var msgf = errorAjax(jqXHR, exception, 'text');
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

	$('#modconvalida').on('hidden.bs.modal', function(e) {
		$("#form_addmatricula #fmt-cbncarrera option").each(function(i) {
			$(this).removeClass('ocultar');
		})

	    $('#fmt-cbncodmatcurso').val('0');
	    $('#fmt-cbncodmatricula').val('0');
        $('#fmt-cbncargaacadem').val('0');
        $('#fmt-cbncargaacadsubsec').val('0');
	    $('#form_addmatricula')[0].reset();
	    get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
	    $('#divcontent_convalida').addClass('d-none');
	    $('#btnaddconvalidad').data('codins', '');
	    $('#fmt-cbninscripcion').val('');
	})

	$('#fmt-cbtipo').change(function(e) {
	    var item = $(this);
	    var tipo = item.find(':selected').data('tipo');
	    if (tipo === "CONVALIDA") {
	        $('#divcontent_convalida').removeClass('d-none');
	    } else {
	        $('#divcontent_convalida').addClass('d-none');
	    }
	});

	$('#fmt-cbncarrera').change(function(e) {
	    if ($(this).val() != "0") {
	        $('#divmodalconvalida_').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $('#fmt-cbnplan').html("<option value='0'>Sin opciones</option>");
	        var codcar = $(this).val();
	        if (codcar == '0') return;
	        $.ajax({
	            url: base_url + 'plancurricular/fn_get_planes_activos_combo',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcodcarrera: codcar
	            },
	            success: function(e) {
	                $('#divmodalconvalida_ #divoverlay').remove();
	                $('#fmt-cbnplan').html(e.vdata);
	                $("#fmt-cbnplan").val(getUrlParameter("cpl", 0));
	            },
	            error: function(jqXHR, exception) {
	                $('#divmodalconvalida_ #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#fmt-cbnplan').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	    } else {
	        $('#fmt-cbnplan').html("<option value='0'>Selecciona un programa<option>");
	    }
	});

	function get_unidades(ciclo, plan) {
	    if ($('#' + ciclo).val() != "0" && $('#' + plan).val() != "0") {
	        $('#divmodalconvalida_').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $('#fmt-cbnunididact').html("<option value='0'>Sin opciones</option>");
	        var ciclo = $('#' + ciclo).val();
	        var plan = $('#' + plan).val();
	        if (ciclo == '0' && plan == '0') return;
	        $.ajax({
	            url: base_url + 'unidaddidactica/fn_get_unidades_combo',
	            type: 'post',
	            dataType: 'json',
	            data: {
	                txtcodciclo: ciclo,
	                txtcodplan: plan,
	            },
	            success: function(e) {
	                $('#divmodalconvalida_ #divoverlay').remove();
	                $('#fmt-cbnunididact').html(e.vdata);
	                $("#fmt-cbnunididact").val(getUrlParameter("cpl", 0));
	            },
	            error: function(jqXHR, exception) {
	                $('#divmodalconvalida_ #divoverlay').remove();
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#fmt-cbnunididact').html("<option value='0'>" + msgf + "</option>");
	            }
	        });
	    } else {
	        $('#fmt-cbnunididact').html("<option value='0'>Selecciona un plan curricular y ciclo<option>");
	    }
	}

	$('#btnaddconvalidad').click(function() {
	    $('#form_addmatricula input,select').removeClass('is-invalid');
	    $('#form_addmatricula .invalid-feedback').remove();
	    $('#divmodalconvalida').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    // var inscrito = $('#btnaddconvalidad').data('codins');
	    $.ajax({
	        url: base_url + 'matricula_independiente/fn_insert_update',
	        type: 'post',
	        dataType: 'json',
	        data: $('#form_addmatricula').serialize(),
	        success: function(e) {
	            $('#divmodalconvalida #divoverlay').remove();
	            if (e.status == false) {
	                $.each(e.errors, function(key, val) {
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                });
	                Swal.fire({
	                    type: 'error',
	                    icon: 'error',
	                    title: 'Error!',
	                    text: 'Existen errores en los campos',
	                    backdrop: false,
	                })
	            } else {
	                Swal.fire({
	                    type: 'success',
	                    icon: 'success',
	                    title: 'Éxito!',
	                    text: e.msg,
	                    backdrop: false,
	                }).then((result) => {
	                    if (result.value) {
	                        $('#modconvalida').modal('hide');
	                        get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
	                        $('#divcontent_convalida').addClass('d-none');
	                        fn_select_inscrito($('#btnaddconvalidad'),'modal');
	                    }
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divmodalconvalida #divoverlay').remove();
	            Swal.fire({
	                type: 'error',
	                icon: 'error',
	                title: 'Error!',
	                text: msgf,
	                backdrop: false,
	            })
	        }
	    });
	    return false;
	});
	
</script>