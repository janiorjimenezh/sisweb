<?php 
	$vbaseurl=base_url();
	$vuser=$_SESSION['userActivo'];
	date_default_timezone_set ('America/Lima');
	$fechaemision = date('d/m/Y');
?>
<style>
	.preview_foto {
		height: 170px;
		max-height: 170px;
	}
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>
<div class="content-wrapper">
	<?php $this->load->view('admision/vw_modal_inscripciones'); ?>
	<div class="modal fade modal-fullscreen" id="modview_pdf" tabindex="-1" role="dialog" aria-labelledby="modview_pdf" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
		    <div class="modal-content" id="divmodaladd">
		      	<div class="modal-header">
		        	<h5 class="modal-title" >Generación de carné</h5>
		      	</div>
		      	<div class="modal-body">
		        	<div id="divcard_frame_pdf"></div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		      	</div>
		    </div>
	  	</div>
	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
			<div class="card-header">
				<h3 class="card-title">Generación de carné</h3>
			</div>
			<div class="card-body">
				<form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>generacion_carne/fn_filtrar_generacion" method="post" accept-charset='utf-8'>
                  	<div class="row">
	                    <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
	                      	<select  class="form-control form-control-sm text-xs" id="fmt-cbsede" name="fmt-cbsede" placeholder="Filial">
		                        <option value="%"></option>
		                        <?php 
		                          foreach ($sedes as $filial) {
		                            $select=($vuser->idsede==$filial->id) ? "selected":"";
		                            echo "<option $select value='$filial->id'>$filial->nombre</option>";
		                          } 
		                        ?>
	                      	</select>
	                      	<label for="fmt-cbsede"> Filial</label>
	                    </div>
	                    <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
	                      	<select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
		                        <option value="%"></option>
		                        <?php foreach ($periodos as $periodo) {?>
		                        <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
		                        <?php } ?>
	                      	</select>
	                      	<label for="fmt-cbperiodo"> Periodo</label>
	                    </div>
                    
	                    <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
	                      	<select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
		                        <option value="%"></option>
		                        <?php foreach ($carreras as $carrera) {?>
		                        <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
		                        <?php } ?>
	                      	</select>
	                      	<label for="fmt-cbcarrera"> Prog. de Estudios</label>
	                    </div>
	                    <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
	                      	<select name="fmt-cbplan" id="fmt-cbplan"class="form-control form-control-sm text-xs">
		                        <option data-carrera="0" value="%">Todos</option>
		                        <option data-carrera="0" value="0">Sin Plan</option>
		                        <?php foreach ($planes as $pln) {
		                        echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
		                        } ?>
	                      	</select>
	                      	<label for="fmt-cbplan">Plan estudios</label>
	                    </div>
	                    <div class="form-group has-float-label col-12 col-sm-3 col-md-1">
	                      	<select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Semestre" >
		                        <option value="%"></option>
		                        <?php foreach ($ciclos as $ciclo) {?>
		                        <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
		                        <?php } ?>
	                      	</select>
	                      	<label for="fmt-cbciclo">Semestre</label>
	                    </div>
	                    <div class="form-group has-float-label col-12 col-sm-3 col-md-1">
	                      	<select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
		                        <option value="%"></option>
		                        <?php foreach ($turnos as $turno) {?>
		                        <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
		                        <?php } ?>
	                      	</select>
	                      	<label for="fmt-cbturno"> Turno</label>
	                    </div>
	                    <div class="form-group has-float-label col-12 col-sm-3 col-md-1">
	                      	<select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
		                        <option value="%"></option>
		                        <?php foreach ($secciones as $seccion) {?>
		                        <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
		                        <?php } ?>
	                      	</select>
	                      	<label for="fmt-cbseccion"> Sección</label>
	                    </div>
	                    <div class="form-group has-float-label col-12 col-sm-2 col-md-2">
	                      	<select data-currentvalue="" class="form-control form-control-sm text-xs" id="fmt-cbestado" name="fmt-cbestado" required="">
		                        <option value="%"></option>
		                        <?php foreach ($estados as $estado) {?>
		                        <option value="<?php echo $estado->codigo ?>"><?php echo $estado->nombre ?></option>
		                        <?php } ?>
	                      	</select>
	                      	<label for="fmt-cbestado"> Estado</label>
	                    </div>
	                    <div class="form-group has-float-label col-12 col-sm-2 col-md-2">
	                      	<select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbbeneficio" name="fmt-cbbeneficio" placeholder="Periodo" required >
		                        <option value="%">Todos</option>
		                        <?php foreach ($beneficios as $beneficio) {?>
		                        <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
		                        <?php } ?>
	                      	</select>
	                      	<label for="fmt-cbbeneficio"> Beneficio</label>
	                    </div>
	                    <div class="form-group has-float-label col-12 col-sm-8 col-md-5">
	                      	<input class="form-control text-uppercase form-control-sm text-xs" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
	                      	<label for="fmt-alumno"> Carné o Apellidos y nombres
	                      </label>
	                    </div>
	                    <div class="col-6 col-sm-2 col-md-1">
	                      	<button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fas fa-search"></i></button>
	                    </div>
	                    <div class="col-6 col-sm-4 col-md-2">
	                    	
	                    </div>
                  	</div>
                </form>
                
                <div class="row">
                	<div class="col-12 col-md-10">
                		<!-- <div class="row mt-2">
		                	<div class="col-12">
		                		<button class="btn btn-outline-info btn-sm float-right ml-2" id="btn_printall">
		                			<i class="fas fa-print"></i> Imprimir resultados
		                		</button>
		                		<button class="btn btn-outline-success btn-sm float-right" id="btn_addbandeja">
		                			<i class="fas fa-user-plus"></i> Agregar a bandeja
		                		</button>
		                	</div>
		                </div> -->
		                <div class="col-12 px-0 pt-2 table-responsive">
		                	<div class="alert alert-danger alert-dismissible fade show" id="vw_mt_divmensaje" role="alert">
			                    <span id="vw_mt_spanmensaje"></span>
			                </div>
			                <table id="tbmt_dtMatriculados" class="tbdatatable table table-sm table-hover table-bordered table-condensed tb_principal" style="width:100%">
			                  	<thead>
			                      <tr class="bg-lightgray">
			                          <th>N°</th>
			                          <th>Filial</th>
			                          <th>Carné</th>
			                          <th>Estudiante / Edad</th>
			                          <th>Emisión.</th>
			                          <th>Plan</th>
			                          <th>Grupo</th>
			                          <th>Est.</th>
			                      </tr>
			                  	</thead>
			                  	<tbody id="content_vdata">
			                      
			                  	</tbody>
			                </table>
		                </div>
                	</div>
                	
	                <div class="col-12 col-md-2 text-center pt-2" id="divcard_principal">
	                	<div class="border rounded preview_foto mb-2 preview_foto_estudiante" id="preview_foto_estudiante"></div>
	                	<button class="btn btn-outline-secondary btn-block btn-sm" id="btn_viewfoto" data-vtable="tb_filtro" onclick="fn_viewfoto($(this));return false;">
                			<i class="fas fa-file-image"></i> Cambiar foto
                		</button>
                		<div class="clearfix"></div>
                		<button class="btn btn-outline-success btn-sm btn-block mt-1" id="btn_addbandeja">
                			<i class="fas fa-user-plus"></i> Agregar a bandeja
                		</button>
	                </div>
                </div>
                

			</div>

		</div>
		<div id="divcard_bandeja" class="card">
			<div class="card-header">
				<h3 class="card-title">Bandeja de Impresión</h3>
				<div class="card-tools mr-0">
					
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-md-10 table-responsive">
	                	<table id="tbmt_dtbandeja_Matriculados" class="tbdatatable table table-sm table-hover table-bordered table-condensed tb_principal" style="width:100%">
		                  	<thead>
		                      <tr class="bg-lightgray">
		                          <th>N°</th>
		                          <th>Filial</th>
		                          <th>Carné</th>
		                          <th>Estudiante / Edad</th>
		                          <th>Emisión</th>
		                          <th>Plan</th>
		                          <th>Grupo</th>
		                          <th>Est.</th>
		                      </tr>
		                  	</thead>
		                  	<tbody id="content_bandeja">
		                      
		                  	</tbody>
		                </table>
	                </div>
	                <div class="col-12 col-md-2 text-center" id="divcard_tbbandeja">
	                	<div class="border rounded preview_foto preview_foto_estudiante mb-2" id="preview_foto_estudiante"></div>
	                	<button class="btn btn-outline-secondary btn-sm btn-block" id="btn_viewfoto" data-vtable="tb_bandeja" onclick="fn_viewfoto($(this));return false;">
                			<i class="fas fa-file-image"></i> Cambiar foto
                		</button>
                		<div class="clearfix"></div>
                		<button class="btn btn-outline-danger btn-sm btn-block mt-1" id="btn_deletebandeja">
	            			<i class="fas fa-user-minus"></i> Quitar de bandeja
	            		</button>
	            		<div class="clearfix"></div>
	            		<button class="btn btn-outline-info btn-sm btn-block mt-1" id="btn_impresion">
                			<i class="fas fa-print"></i> Vista impresión
                		</button>
	                </div>
	            </div>
	            <div class="row mt-1">
	            	<div class="col-3 col-md-1">
	            		<label for="">Emisión: </label>
	            	</div>
	            	<div class="col-7 col-md-3">
	            		<input type="date" name="fictxtemisionnew" id="fictxtemisionnew" class="form-control form-control-sm">
	            	</div>
	            	<div class="col-2 col-md-2">
	            		<button class="btn btn-primary btn-sm btn-block" id="btn_fecha_emision">
                			<i class="fas fa-check"></i>
                		</button>
	            	</div>
	            	<div class="col-md-6 form-control form-control-sm text-right font-weight-bold" id="divcard_text_Cantidad">
	            		
	            	</div>
	            </div>
			</div>
		</div>

	</section>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/moment/moment.min.js"></script>
<script>
	$('.tbdatatable tbody').on('click', 'tr', function() {
	    tabla = $(this).closest("table").DataTable();
	    // row = $(this).find('.selected');
	    if ($(this).hasClass('selected')) {
	        //Deseleccionar
	        //$(this).removeClass('selected');
	    } else {
	        //Seleccionar
	        tabla.$('tr.selected').removeClass('selected');
	        $(this).addClass('selected');
	    }

	    if ($(this).hasClass('selected')) {
	    	codigo = $(this).data('codins64');
	    	tabla = $(this).closest('.tb_principal');
	    	fn_preview_foto(codigo,tabla.attr('id'));
	    }
	});

	$('#frmfiltro-matriculas #fmt-cbcarrera').change(function(event) {
	    var codcar = $(this).val();
	    if (codcar == "%") {
	        $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i) {
	            if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
	        });
	    } else {
	        $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i) {
	            if ($(this).data('carrera') == '0') {
	                //if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
	            } else if ($(this).data('carrera') == codcar) {
	                $(this).removeClass('ocultar');
	            } else {
	                if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
	            }
	        });
	    }
	});

	$("#frmfiltro-matriculas").submit(function(event) {
	    filtrar = 0;
	    if ($("#fmt-cbsede").val() != "%") filtrar++;
	    if ($("#fmt-cbperiodo").val() != "%") filtrar++;
	    if ($("#fmt-cbcarrera").val() != "%") filtrar++;
	    if ($("#fmt-cbplan").val() != "%") filtrar++;
	    if ($("#fmt-cbciclo").val() != "%") filtrar++;
	    if ($("#fmt-cbturno").val() != "%") filtrar++;
	    if ($("#fmt-cbseccion").val() != "%") filtrar++;
	    if ($("#fmt-cbestado").val() != "%") filtrar++;
	    if ($("#fmt-cbbeneficio").val() != "%") filtrar++;
	    if ($.trim($("#fmt-alumno").val()).length > 3) filtrar++;
	    tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
	    tbmatriculados.clear();
	    $("#vw_mt_divmensaje").hide();
	    if (filtrar > 1) {
	        $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	        $.ajax({
	            url: $(this).attr("action"),
	            type: 'post',
	            dataType: 'json',
	            data: $(this).serialize(),
	            success: function(e) {
	                if (e.status == false) {} else {
	                    var nro = 0;
	                    var mt = 0;
	                    var ac = 0;
	                    var rt = 0;
	                    var cl = 0;

	                    $.each(e.vdata, function(index, v) {
	                        nro++;
	                        var vcm = v['codmatricula64'];
	                        var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
	                        var btnscolor = "";
	                        
	                        switch (v['estado']) {
	                            case "ACT":
	                                btnscolor = "btn-success";
	                                break;
	                            case "CUL":
	                                btnscolor = "btn-secondary";
	                                break;
	                            case "DES":
	                                btnscolor = "btn-danger";
	                                break;
	                            case "RET":
	                                btnscolor = "btn-danger";
	                                break;
	                            default:
	                                btnscolor = "btn-warning";
	                        }

	                        sexo = (v['codsexo'] == "FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
	                        nomestudiante = v['paterno'] + " " + v['materno'] + " " + v['nombres'];
	                        estudiante = sexo + nomestudiante + " " + v['edad'];

	                        fecharegistro = '<span class="vfecha_emision"><?php echo "$fechaemision"; ?></span>';//v['registro'];
	                        
	                        grupo = v['periodo'] + " " + v['sigla'] + " " + v['codturno'] + " " + v['ciclo'] + " " + v['codseccion'];

	                        dropdown_estado = '<small class="badge '+btnscolor+' p-1"> '+ v['estado'] +'</small>';

	                        indexn = index+1;
	                        nroindex = "<span class='nro_index'>"+ indexn +"</span>";

	                        var fila = tbmatriculados.row.add([nroindex, v['sede_abrevia'], v['carne'], estudiante, fecharegistro, v['plan'], grupo, dropdown_estado]).node();
	                        $(fila).attr('data-codmatricula64', v['codmatricula64']);

	                        $(fila).attr('data-apellidos', v['paterno'] + " " + v['materno']);
	                        $(fila).attr('data-nombres', v['nombres']);
	                        $(fila).attr('data-abcarrera', v['carabrevia']);
	                        $(fila).attr('data-cciclo', v['ciclo']);
	                        $(fila).attr('data-carnet', v['carne']);
	                        $(fila).attr('data-cturno', v['codturno']);
	                        $(fila).attr('data-cturno', v['turno']);
	                        $(fila).attr('data-coperiodo', v['codperiodo']);
	                        $(fila).attr('data-cperiodo', v['periodo']);
	                        $(fila).attr('data-cseccion', v['codseccion']);
	                        $(fila).attr('data-cocarrera', v['codcarrera']);
	                        $(fila).attr('data-cociclo', v['codciclo']);
	                        $(fila).attr('data-photo', v['fotoper64']);
	                        $(fila).attr('data-codper', v['codper64']);
	                        $(fila).attr('data-codins64', v['codins64']);
	                        
	                        $(fila).addClass('cfila_mt');

	                    });

	                    tbmatriculados.draw();
	                    $('#divboxhistorial #divoverlay').remove();

	                    $('.view_user_reg').popover({
	                      trigger: 'hover',
	                      html: true
	                    })

	                }
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#divboxhistorial #divoverlay').remove();
	                //$('#divError').show();
	                //$('#msgError').html(msgf);
	            }
	        });
	    } else {
	        $("#vw_mt_divmensaje").show();
	        $("#vw_mt_spanmensaje").html("Se requiere como mínimo 3 parámetros de búsqueda");
	    }

	    return false;
	});

	function ordenarnro(div) {
	    var nro = 0;
	    $("#" + div + " .nro_index").each(function(index) {
	        nro = nro + 1;
	        $(this).html(nro);
	    });
	}

	$(document).ready(function() {
		$("#vw_mt_divmensaje").hide();
		var table = $('#tbmt_dtMatriculados, #tbmt_dtbandeja_Matriculados').DataTable({
	        "autoWidth": false,
	        "pageLength": 10,
	        "lengthChange": false,
	        "language": {
	            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
	        },
	        'columnDefs': [{
	            "targets": 0, // your case first column
	            "className": "text-right rowhead",
	            "width": "8px"
	        }],
	        dom: "<'row'<'col-sm-12'>>" +
	            "<'row'<'col-sm-12'tr>>" +
	            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

	        "fnDrawCallback": function (oSettings) {
	            $('[data-toggle="popover"]').popover({
	                trigger: 'hover',
	                html: true
	            })
	        }

	    });
	})

	$('#btn_addbandeja').click(function(e) {
		tbmatriculados = $('#tbmt_dtMatriculados');
		$('#preview_foto_estudiante').html('');
		// fila = btn.parents(".selected");
		fila = tbmatriculados.find('.selected').clone();
		fila.removeClass('selected');
		row = tbmatriculados.find('.selected');
		if (row.hasClass('selected')) {
			estado = true;
			$("#content_bandeja .cfila_mt").each(function(index) {
				var ccd = $(this).data('codper');
				if (fila.data('codper') == ccd) {
					estado = false;
				}
			})

			if (estado == true) {
				tbmatriculadosbndj = $('#tbmt_dtbandeja_Matriculados').DataTable();
				var fila = tbmatriculadosbndj.row.add(fila).node();
				tbmatriculadosbndj.draw();

				tbprincipal = $('#tbmt_dtMatriculados').DataTable();
				tbprincipal.row(row).remove().draw();
			}
			
			
		}

		bandejatb = $("#content_bandeja .cfila_mt").length;

		if (bandejatb > 0) {
			nropag = bandejatb / 5;
			$('#divcard_text_Cantidad').html(bandejatb + ' Carnés en lista (' + Math.ceil(nropag) + 'páginas)');
		} else {
			$('#divcard_text_Cantidad').html('');
		}

		
		// $('#content_bandeja').append(fila);

		ordenarnro('content_vdata');
		ordenarnro('content_bandeja');
		
	});

	$('#btn_deletebandeja').click(function(e) {
		tbmatriculadosbndj = $('#tbmt_dtbandeja_Matriculados');
		fila = tbmatriculadosbndj.find('.selected').clone();
		fila.removeClass('selected');
		row = tbmatriculadosbndj.find('.selected');
		if (row.hasClass('selected')) {
			tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
			var fila = tbmatriculados.row.add(fila).node();
			tbmatriculados.draw();

			tbprincipal = $('#tbmt_dtbandeja_Matriculados').DataTable();
			tbprincipal.row(row).remove().draw();
		}

		bandejatb = $("#content_bandeja .cfila_mt").length;

		if (bandejatb > 0) {
			nropag = bandejatb / 5;
			$('#divcard_text_Cantidad').html(bandejatb + ' Carnés en lista (' + Math.ceil(nropag) + 'páginas)');
		} else {
			$('#divcard_text_Cantidad').html('');
		}

		// fila.appendTo('#content_vdata');
		ordenarnro('content_bandeja');
		ordenarnro('content_vdata');
	});

	$('#btn_impresion').click(function(e) {
	    e.preventDefault();
	    bandejatb = $("#content_bandeja .cfila_mt").length;
	    if (bandejatb > 0) {
	    	arraycarne = [];
	    	$("#content_bandeja .cfila_mt").each(function(index) {
	    		fila = $(this);
	    		apellidos = fila.data('apellidos');
	    		nombres = fila.data('nombres');
	    		abrevia = fila.data('abcarrera');
	    		ciclo = fila.data('cciclo');
	    		carnet = fila.data('carnet');
	    		turno = fila.data('cturno');
	    		periodo = fila.data('cperiodo');
	    		image = fila.data('photo');
	    		codpersona = fila.data('codper');
	    		fechaemision = fila.find('.vfecha_emision').html();
	    		// seccion = fila.data('cseccion');
	    		// carrera = fila.data('cocarrera');
	    		var myvals_ = [apellidos,nombres,abrevia,ciclo,carnet,turno,periodo,image,codpersona,fechaemision];
	    		arraycarne.push(myvals_);
	    		
	    	});

	    	acarne = JSON.stringify(arraycarne);
	    	$('#divcard_bandeja').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    	$.ajax({
	          	url: base_url + "generacion_carne/get_carne_estudiantes_bandeja",
	          	type: 'post',
	          	dataType: 'json',
	          	data: {
	          		'filas':  acarne,
	          	},
	          	success: function(e) {
	              	$('#divcard_bandeja #divoverlay').remove();
	              	if (e.status == false) {
	                 	
	              	} 
	              	else {
	                	
	                	// $('#divcard_frame_pdf').html('<iframe src="'+e.pdfcarne+'" style="width:100%;height:100vh"></iframe>');
	                	// $('#modview_pdf').modal();
	                	// window.open('<iframe src="'+e.pdfcarne+'" style="width:100%;height:100vh"></iframe>');
	                	// location.href = base_url+e.title;
	                	window.open(base_url+e.title, '_blank');
	              	}
	          	},
	          	error: function(jqXHR, exception) {
	              	var msgf = errorAjax(jqXHR, exception, 'text');
	              	$('#divcard_bandeja #divoverlay').remove();
	              	$('#divError').show();
	              	$('#msgError').html(msgf);
	          	}
	      	});
	      	return false;
	    } else {
	    	Swal.fire({
                type: 'warning',
                icon: 'warning',
                title: 'Aviso!',
                text: 'La bandeja esta vacia debe agregar como minimo 1 item',
                backdrop: false,
            })
	    }
	    
	});

	$('#btn_printall').click(function(e) {
		filtrar = 0;
	    if ($("#fmt-cbsede").val() != "%") filtrar++;
	    if ($("#fmt-cbperiodo").val() != "%") filtrar++;
	    if ($("#fmt-cbcarrera").val() != "%") filtrar++;
	    if ($("#fmt-cbplan").val() != "%") filtrar++;
	    if ($("#fmt-cbciclo").val() != "%") filtrar++;
	    if ($("#fmt-cbturno").val() != "%") filtrar++;
	    if ($("#fmt-cbseccion").val() != "%") filtrar++;
	    if ($("#fmt-cbestado").val() != "%") filtrar++;
	    if ($("#fmt-cbbeneficio").val() != "%") filtrar++;
	    if ($.trim($("#fmt-alumno").val()).length > 3) filtrar++;

	    if (filtrar > 1) {
	    	$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    	$.ajax({
	            url: base_url + "generacion_carne/get_carne_estudiantes_bandeja",
	            type: 'post',
	            dataType: 'json',
	            data: $("#frmfiltro-matriculas").serialize(),
	            success: function(e) {
	                $('#divboxhistorial #divoverlay').remove();
	                if (e.status == false) {

	                } else {
	                	$('#divcard_frame_pdf').html('<iframe src="'+e.pdfcarne+'" style="width:100%;height:100vh"></iframe>');
	                	$('#modview_pdf').modal();
	                }
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                $('#divboxhistorial #divoverlay').remove();
	                //$('#divError').show();
	                //$('#msgError').html(msgf);
	            }
	        });
	    }
	});

	// $('#btn_viewfoto').click(function(e) {
	// 	tbmatriculados = $('#tbmt_dtMatriculados');
	// 	row = tbmatriculados.find('.selected');
	// 	vmatriculas = $("#content_vdata .cfila_mt").length;
	// 	if (vmatriculas > 0) {
	// 		if (row.hasClass('selected')) {
	// 			codins64 = row.data('codins64');
	// 			fn_vw_foto_perfil(codins64);
	// 		} else {
	// 			Swal.fire({
	//                 type: 'warning',
	//                 icon: 'warning',
	//                 title: 'Aviso!',
	//                 text: 'Para cambiar foto debe seleccionar un estudiante',
	//                 backdrop: false,
	//             })
	// 		}
	// 	}
		
	// });

	function fn_viewfoto(btn) {
		var tbcontent = "";
		var tablamatricula = "";
		if (btn.data('vtable') == "tb_filtro") {
			tbcontent = "content_vdata";
			tablamatricula = "tbmt_dtMatriculados";
		} else {
			tbcontent = "content_bandeja";
			tablamatricula = "tbmt_dtbandeja_Matriculados";
		}
		tbmatriculados = $('#'+tablamatricula);
		row = tbmatriculados.find('.selected');
		vmatriculas = $("#"+tbcontent+" .cfila_mt").length;
		if (vmatriculas > 0) {
			if (row.hasClass('selected')) {
				codins64 = row.data('codins64');
				fn_vw_foto_perfil(codins64);
			} else {
				Swal.fire({
	                type: 'warning',
	                icon: 'warning',
	                title: 'Aviso!',
	                text: 'Para cambiar foto debe seleccionar un estudiante',
	                backdrop: false,
	            })
			}
		}
	}

	function fn_preview_foto(codigo, tabla) {
		if (tabla == 'tbmt_dtMatriculados') {
			divimg = 'divcard_principal';
			divoverlay = 'divboxhistorial';
		} else {
			divimg = 'divcard_tbbandeja';
			divoverlay = 'divcard_bandeja';
		}
		$('#'+divoverlay).append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$('#'+divimg+' .preview_foto_estudiante').html('');
		$.ajax({
            url: base_url + 'inscrito/fn_view_foto_inscrito',
            type: 'post',
            dataType: 'json',
            data: {
              'ce-idins': codigo,
            },
            success: function(e) {
                $('#'+divoverlay+' #divoverlay').remove();
                
                if (e.status == false) {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error!',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                	if (e.vdata['foto'] != "") {
                		$('#'+divimg+' .preview_foto_estudiante').html('<img class="img-fluid w-100 h-100" src="'+base_url+'resources/fotos/'+e.vdata['foto']+'" alt="foto">');
                	} else {
                		$('#'+divimg+' .preview_foto_estudiante').html('<img class="img-fluid w-100 h-100" src="'+base_url+'resources/img/Imagen_no_disponible.png" alt="foto">');
                	}
                    
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#'+divoverlay+' #divoverlay').remove();
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error',
                    text: msgf,
                    backdrop: false,
                })
            }
        });
        return false;
	}

	$('#btn_fecha_emision').click(function(e) {
		bandejatb = $("#content_bandeja .cfila_mt").length;
		var fecha = moment($('#fictxtemisionnew').val());
		if ($('#fictxtemisionnew').val() != "") {
			if (bandejatb > 0) {
				$("#content_bandeja .cfila_mt").each(function(index) {
					fila = $(this);
					fila.find('.vfecha_emision').html(fecha.format('DD/MM/YYYY'));
				})

				$('#fictxtemisionnew').val('');
			}
		}
		

	});
</script>