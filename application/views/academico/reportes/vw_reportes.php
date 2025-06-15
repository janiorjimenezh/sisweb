<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<h1>Estadistica
					<small>Panel</small></h1>
				</div>
				
			</div>
		</div>
	</section>
	<section id="s-cargado" class="content pt-2">
		
		<!-- <div class="card-header">
						<h3 class="card-title">Tipos</h3>
		</div> -->
		<div id="divcard_ls_reportes" class="card">
			<!-- <div class="card-header">
							<h3 class="card-title">Tipos</h3>
			</div> -->
			<div class="card-body">
				<div class="row">
					<div class="col-5">
						<div class="form-check">
							<input checked class="form-check-input rd_reportes" data-title='Total de Unid. didacticas asignadas a estudiante - Filial' data-view='ts_div_vwreportes_total_unid_est_filial' data-urlpdf='' data-urlexcel='academico/reportes/carga-x-estudiante-filial/excel' type="radio" name="exampleRadios" id="ra301" value="ra301">
							<label class="form-check-label" for="ra301">
								Total de Unid. didacticas asignadas a estudiante - Filial
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Reporte de Unid. didácticas asignadas a docente - Filial' data-view='ts_div_vwreportes_total_unid_docen_filial' data-urlpdf='' data-urlexcel='academico/reportes/carga-x-docente-filial/excel' type="radio" name="exampleRadios" id="ra303" value="ra303">
							<label class="form-check-label" for="ra303">
								Reporte de Unid. didácticas asignadas a docente - Filial
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Padron de Notas por Grupo' data-view='ts_div_vwreportes_total_unid_docen_filial' data-urlpdf='' data-urlexcel='academico/reportes/padron-evaluaciones-x-grupos/excel' type="radio" name="exampleRadios" id="ra203" value="ra203">
							<label class="form-check-label" for="ra203">
								Padron de Notas por Grupo
							</label>
						</div>
						

						
					</div>
					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_total_unid_est_filial">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title_deudas">Total de Unid. didacticas asignadas a estudiante - Filial</h3>
							</div>
							<div class="col-12">
								
								<form id="frm_search_deudaxcuota" action="" method="post" accept-charset="utf-8">
									
									<div class="row mt-2">
										

											
				                        <!--SOLO APARECE SI TIENE PERMISO DE EDITAR SEDE DE MATRICULA-->
				                        <div class="form-group has-float-label col-12">
				                          <select name="fca-cbsede" id="fca-cbsede" class="form-control form-control-sm">
				                                
				                                <?php 
				                                $codsede=$_SESSION['userActivo']->idsede;
				                                foreach ($_SESSION['userActivo']->sedes as $sede) {
				                                    $selsede=($codsede==$sede->idsede)?"selected":"";
				                                    echo "<option $selsede value='$sede->idsede'>$sede->nombre </option>";
				                                } ?>
				                            </select>
				                             <label for="fca-cbsede">Filial</label>
				                        </div>
					                  

										<div class="form-group has-float-label col-12  col-sm-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbperiodo" name="fca-cbperiodo" placeholder="Periodo" required >
												<option value="%">Todos</option>
												<?php foreach ($periodos as $periodo) {?>
												<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbperiodo">Periodo</label>
										</div>
										<div class="form-group has-float-label col-12 col-md-4">
											<select data-currentvalue='' class="form-control form-control-sm fca_carrera" data-formview="frm_search_deudaxcuota" id="fca-cbcarrera" name="fca-cbcarrera" placeholder="Programa Académico" >
												<option value="%">Todas</option>
												<?php foreach ($carreras as $carrera) {?>
												<option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbcarrera"> Prog. de Estudios</label>
										</div>
										<div class="form-group has-float-label col-12 col-md-5">
											<select name="fca-cbplan" id="fca-cbplan"class="form-control form-control-sm">
												<option  value="%">Todos</option>
												<?php foreach ($planes as $pln) {
												echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
												} ?>
											</select>
											<label for="fca-cbplan">Plan estudios</label>
										</div>
										
										<div class="form-group has-float-label col-12  col-md-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbciclo" name="fca-cbciclo" placeholder="Semestre" required >
												<option value="%">Todos</option>
												<?php foreach ($ciclos as $ciclo) {?>
												<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbciclo"> Semestre</label>
										</div>
										<div class="form-group has-float-label col-12  col-md-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbturno" name="fca-cbturno" placeholder="Turno" required >
												<option value="%">Todos</option>
												<?php foreach ($turnos as $turno) {?>
												<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbturno"> Turno</label>
										</div>
										<div class="form-group has-float-label col-12  col-md-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbseccion" name="fca-cbseccion" placeholder="Sección" required >
												<option value="%">Todas</option>
												<?php foreach ($secciones as $seccion) {?>
												<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbseccion"> Sección</label>
										</div>
										<div class="form-group has-float-label col-12  col-md-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbestado" name="fca-cbestado" placeholder="Estado" required >
												<option value="%">Todos</option>
												<?php foreach ($estados as $estado) {?>
												<option value="<?php echo $estado->codigo ?>"><?php echo $estado->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbestado"> Estado</label>
										</div>
										
										
									</div>
									
									
									
									<div class="row">
										<div class="form-group has-float-label col-12">
											<input type="text" autocomplete="off" name="fictxtpagapenom" id="fictxtpagapenom" class="form-control form-control-sm" placeholder="Cliente">
											<label for="fictxtpagapenom">Cliente</label>
										</div>
										<div class="col-12 text-right">
											<!--<a id='vw_exp_pdf' class='btn btn-sm btn-danger' href='#'>PDF</a>-->
											<a id='vw_filtro_matricula_excel_student' class='btn btn-sm btn-success vw_btn_exp_excel' href='#'>Excel</a>
										</div>
									</div>

								</form>
							</div>
						</div>
					</div>

					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_total_unid_docen_filial">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title_deudas">Reporte de Unid. didácticas asignadas a docente - Filial</h3>
							</div>
							<div class="col-12">
								<form id="frm_report_docente" action="" method="post" accept-charset="utf-8">
									<div class="row mt-2">
				                        <!--SOLO APARECE SI TIENE PERMISO DE EDITAR SEDE DE MATRICULA-->
				                        <div class="form-group has-float-label col-12">
				                          <select name="fca-cbsede" id="fca-cbsede" class="form-control form-control-sm">
				                                
				                                <?php 
				                                $codsede=$_SESSION['userActivo']->idsede;
				                                foreach ($_SESSION['userActivo']->sedes as $sede) {
				                                    $selsede=($codsede==$sede->idsede)?"selected":"";
				                                    echo "<option $selsede value='$sede->idsede'>$sede->nombre </option>";
				                                } ?>
				                            </select>
				                             <label for="fca-cbsede">Filial</label>
				                        </div>
					                  

										<div class="form-group has-float-label col-12  col-sm-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbperiodo" name="fca-cbperiodo" placeholder="Periodo" required >
												<option value="%">Todos</option>
												<?php foreach ($periodos as $periodo) {?>
												<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbperiodo">Periodo</label>
										</div>
										<div class="form-group has-float-label col-12 col-md-9">
											<select data-currentvalue='' class="form-control form-control-sm fca_carrera" data-formview="frm_report_docente" id="fca-cbcarrera" name="fca-cbcarrera" placeholder="Programa Académico" >
												<option value="%">Todas</option>
												<?php foreach ($carreras as $carrera) {?>
												<option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbcarrera"> Prog. de Estudios</label>
										</div>
										<div class="form-group has-float-label col-12 col-md-3">
											<select name="fca-cbplan" id="fca-cbplan"class="form-control form-control-sm">
												<option  value="%">Todos</option>
												<?php foreach ($planes as $pln) {
												echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
												} ?>
											</select>
											<label for="fca-cbplan">Plan estudios</label>
										</div>
										
										<div class="form-group has-float-label col-12  col-md-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbciclo" name="fca-cbciclo" placeholder="Semestre" required >
												<option value="%">Todos</option>
												<?php foreach ($ciclos as $ciclo) {?>
												<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbciclo"> Semestre</label>
										</div>
										<div class="form-group has-float-label col-12  col-md-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbturno" name="fca-cbturno" placeholder="Turno" required >
												<option value="%">Todos</option>
												<?php foreach ($turnos as $turno) {?>
												<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbturno"> Turno</label>
										</div>
										<div class="form-group has-float-label col-12  col-md-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="fca-cbseccion" name="fca-cbseccion" placeholder="Sección" required >
												<option value="%">Todas</option>
												<?php foreach ($secciones as $seccion) {?>
												<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbseccion"> Sección</label>
										</div>
										
									</div>
									
									<div class="row">
										<div class="col-12 text-right">
											<!--<a id='vw_exp_pdf' class='btn btn-sm btn-danger' href='#'>PDF</a>-->
											<a id='vw_btn_exp_excel_doc' class='btn btn-sm btn-success vw_btn_exp_excel' href='#'>Excel</a>
										</div>
									</div>

								</form>
							</div>
						</div>
					</div>

					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title">Documentos emitidos</h3>
							</div>
							<div class="col-12">
								<form id="frm_search_matricula" action="" method="post" accept-charset="utf-8">
									<div class="col-4 border rounded py-2 mb-3">
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input" id="checktodos" value="TODOS">
											<label class="form-check-label" for="checktodos">TODOS</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkestatus" id="checkaceptado">
											<label class="form-check-label" for="checkanulado">ACEPTADO</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkestatus" id="checkpendiente">
											<label class="form-check-label" for="checkpendiente">PENDIENTE</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkestatus" id="checkanulado">
											<label class="form-check-label" for="checkanulado">ANULADO</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkestatus" id="checkenviado">
											<label class="form-check-label" for="checkenviado">ENVIADO</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkestatus" id="checkrechazado">
											<label class="form-check-label" for="checkrechazado">RECHAZADO</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkestatus" id="checkerror">
											<label class="form-check-label" for="checkerror">ERROR</label>
										</div>
									</div>
									<div class="row">
										<div class="form-group has-float-label col-6 ">
											<input type="date" name="fictxtfecha_emision" id="fictxtfecha_emision" class="form-control form-control-sm fictxtfecha_emision_class">
											<label for="fictxtfecha_emision">Fecha Inicio</label>
										</div>
										<div class="form-group has-float-label col-6">
											<input type="date" name="fictxtfecha_emisionf" id="fictxtfecha_emisionf" class="form-control form-control-sm fictxtfecha_emisionf_class">
											<label for="fictxtfecha_emisionf">Fecha Final</label>
										</div>
									</div>
									<div class="row">
										<div class="form-group has-float-label col-12">
											<input type="text" autocomplete="off" name="fictxtpagapenom" id="fictxtpagapenom" class="form-control form-control-sm" placeholder="Cliente">
											<label for="fictxtpagapenom">Cliente</label>
										</div>
										<div class="col-12 text-right">
											<a id='vw_exp_pdf' class='btn btn-sm btn-danger vw_btn_exp_pdf' href='#'>PDF</a>
											<a id='vw_exp_excel' class='btn btn-sm btn-success vw_btn_exp_excel' href='#'>Excel</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_pagoxitem">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title">Documentos emitidos</h3>
							</div>
							<div class="col-12">
								<form id="frm_search_docpagoitems" action="" method="post" accept-charset="utf-8">
										
										<div class="row">
											<div class="form-group has-float-label col-6 ">
												<input type="date" name="fictxtfecha_desde" id="fictxtfecha_desde" class="form-control form-control-sm">
												<label for="fictxtfecha_desde">Desde</label>
											</div>
											<div class="form-group has-float-label col-6">
												<input type="date" name="fictxtfecha_hasta" id="fictxtfecha_hasta" class="form-control form-control-sm">
												<label for="fictxtfecha_hasta">Hasta</label>
											</div>
										</div>
										<div class="row">
											<div class="form-group has-float-label col-12">
												<select name="cboconceptos" id="cboconceptos" class="form-control form-control-sm" required="">
													<option value="">Conceptos#</option>
													<?php
													foreach ($gestion as $key => $gt) {
														echo "<option value='$gt->codigo' >$gt->gestion</option>";
													}
													?>
												</select>
												<label for="cboconceptos">Conceptos</label>
											</div>
											<div class="col-12 text-right">
												<a id='vw_exp_pdfitem' class='btn btn-sm btn-danger' href='#'>PDF</a>
												<a id='vw_exp_excelitem' class='btn btn-sm btn-success' href='#'>Excel</a>
											</div>
										</div>
									</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
	</section>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    //$(".rd_reportes").change();
	    $(".ts_div_reportes").hide();
	    $("#ts_div_vwreportes_total_unid_est_filial").show();
	    var factual = new Date();
	    var anio = factual.getFullYear();
	    var mes = ("0" + (factual.getMonth() + 1)).slice(-2);
	    var udia = new Date(anio, mes, 0).getDate();
	    $(".fictxtfecha_emision_class").val(anio + "-" + mes + "-01");
	    $(".fictxtfecha_emisionf_class").val(anio + "-" + mes + "-" + udia);
	});
	$('.fca_carrera').change(function(event) {

	    var codcar = $(this).val();
	    var formview = $(this).data('formview');
	    if (codcar == "%") {
	        $("#"+formview+" #fca-cbplan option").each(function(i) {
	            if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
	        });
	    } else {
	        $("#"+formview+" #fca-cbplan option").each(function(i) {

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
	$(".rd_reportes").change(function(event) {
	    $("#vw_exp_title").html($("#divcard_ls_reportes input[type='radio']:checked").data('title'));
	    var jsview = $(this).data('view');
	    $(".ts_div_reportes").hide();
	    if (jsview != "") {
	        $("#" + jsview).show();
	        if ($(this).data("urlexcel")=="") {
	    		$(".vw_btn_exp_excel").hide();
	    	}
	    	else{
	    		$(".vw_btn_exp_excel").show();
	    	}
	    	if ($(this).data("urlpdf")=="") {
	    		$(".vw_btn_exp_pdf").hide();
	    	}
	    	else{
	    		$(".vw_btn_exp_pdf").show();
	    	}
	    }
	   
	});

	/*$("#vw_deudaxcuota_excel").click(function(e) {
	    e.preventDefault();

	    $('#frm_search_docpago input,select').removeClass('is-invalid');
	    $('#frm_search_docpago .invalid-feedback').remove();
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');
	    var fi = $("#fictxtfecha_emision").val();
	    var ff = $("#fictxtfecha_emisionf").val();
	    var pg = $("#fictxtpagapenom").val();


        var url = base_url + url_excel +'?cp=' + $("#fca-cbperiodo").val() + '&cc=' + $("#fca-cbcarrera").val() + '&ccc=' + $("#fca-cbciclo").val() + '&ct=' + $("#fca-cbturno").val() + '&cs=' + $("#fca-cbseccion").val() + '&cpl=' + $("#fca-cbplan").val() + '&ap=' + $("#fictxtpagapenom").val();

	//    var url = UR
	    var ejecuta = false;
	    if ($.trim(fi) != '') {
	        ejecuta = true;
	    } else if ($.trim(ff) != '') {
	        ejecuta = true;
	    } else if ($.trim(pg) != '') {
	        ejecuta = true;
	    }
	    if (ejecuta == true) {
	        window.open(url, '_blank');
	    } else {
	        Swal.fire({
	            title: "Parametros requeridos",
	            text: "Ingresa al menos un parametro de búsqueda",
	            type: 'error',
	            icon: 'error',
	        })
	    }
	});*/
	$("#vw_filtro_matricula_excel_student").click(function(e) {
	    e.preventDefault();
	    //$('#frm_search_matricula input,select').removeClass('is-invalid');
	    //$('#frm_search_matricula .invalid-feedback').remove();
	    
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');

	    var url = base_url + url_excel +'?cp=' + $("#fca-cbperiodo").val() + '&cc=' + $("#fca-cbcarrera").val() + '&sd=' + $("#fca-cbsede").val() + '&ccc=' + $("#fca-cbciclo").val() + '&ct=' + $("#fca-cbturno").val() + '&cs=' + $("#fca-cbseccion").val() + '&cpl=' + $("#fca-cbplan").val() + '&ap=' + $("#fictxtpagapenom").val() + '&es=' + $("#fca-cbestado").val();

	    var ejecuta = false;
	    var llenos=0;
	    if ($("#fictxtpagapenom").val()!=="") llenos++;
	    if ($("#fca-cbperiodo").val()!=="%") llenos++;
	    if ($("#fca-cbcarrera").val()!=="%") llenos++;
	    if ($("#fca-cbciclo").val()!=="%") llenos++;
	    if ($("#fca-cbturno").val()!=="%") llenos++;
	    if ($("#fca-cbseccion").val()!=="%") llenos++;
	    if ($("#fca-cbplan").val()!=="%") llenos++;
	    if ($("#fca-cbestado").val()!=="%") llenos++;
	    if ($('#fca-cbsede').val()!== "%") llenos++;

	    if (llenos > 1) {
	        window.open(url, '_blank');
	    } else {
	        Swal.fire({
	            title: "Parametros requeridos",
	            text: "Ingresa al menos un parametro de búsqueda",
	            type: 'error',
	            icon: 'error',
	        })
	    }
	});

	$("#vw_btn_exp_excel_doc").click(function(e) {
	    e.preventDefault();
	    //$('#frm_search_matricula input,select').removeClass('is-invalid');
	    //$('#frm_search_matricula .invalid-feedback').remove();
	    
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');
	    var vperiodo = $("#frm_report_docente #fca-cbperiodo").val();
	    var vcarrera = $("#frm_report_docente #fca-cbcarrera").val();
	    var vsemestre = $("#frm_report_docente #fca-cbciclo").val();
	    var vturno = $("#frm_report_docente #fca-cbturno").val();
	    var vseccion = $("#frm_report_docente #fca-cbseccion").val();
	    var vplan = $("#frm_report_docente #fca-cbplan").val();
	    var vsede = $('#frm_report_docente #fca-cbsede').val();

	    var url = base_url + url_excel +'?cp=' + vperiodo + '&cc=' + vcarrera + '&sd=' + vsede + '&ccc=' + vsemestre + '&ct=' + vturno + '&cs=' + vseccion + '&cpl=' + vplan;

	    var ejecuta = false;
	    var llenos=0;
		
	    if (vperiodo!=="%") llenos++;
	    if (vcarrera!=="%") llenos++;
	    if (vsemestre!=="%") llenos++;
	    if (vturno!=="%") llenos++;
	    if (vseccion!=="%") llenos++;
	    if (vplan!=="%") llenos++;
	    if (vsede!== "%") llenos++;

	    if (llenos > 1) {
	        window.open(url, '_blank');
	    } else {
	        Swal.fire({
	            title: "Parametros requeridos",
	            text: "Ingresa al menos un parametro de búsqueda",
	            type: 'error',
	            icon: 'error',
	        })
	    }
	});
	/*$("#vw_exp_pdf").click(function(e) {
	    e.preventDefault();

	    $('#frm_search_docpago input,select').removeClass('is-invalid');
	    $('#frm_search_docpago .invalid-feedback').remove();
	    var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlpdf');
	    var fi = $("#fictxtfecha_emision").val();
	    var ff = $("#fictxtfecha_emisionf").val();
	    var pg = $("#fictxtpagapenom").val();
	    checktodos = ($("#checktodos").prop('checked') == true ? "&checktodos=TODOS" : "");
	    checkanulado = ($("#checkanulado").prop('checked') == true ? "&checkanulado=ANULADO" : "");
	    checkenviado = ($("#checkenviado").prop('checked') == true ? "&checkenviado=ENVIADO" : "");
	    checkrechazado = ($("#checkrechazado").prop('checked') == true ? "&checkrechazado=RECHAZADO" : "");
	    checkerror = ($("#checkerror").prop('checked') == true ? "&checkerror=ERROR" : "");
	    checkaceptado = ($("#checkaceptado").prop('checked') == true ? "&checkaceptado=ACEPTADO" : "");
	    checkpendiente = ($("#checkpendiente").prop('checked') == true ? "&checkpendiente=PENDIENTE" : "");
	    var url = base_url + url_pdf + '?fi=' + fi + '&ff=' + ff + '&pg=' + pg + checktodos + checkanulado + checkenviado + checkrechazado + checkerror + checkaceptado + checkpendiente;
	    var ejecuta = false;
	    if ($.trim(fi) != '') {
	        ejecuta = true;
	    } else if ($.trim(ff) != '') {
	        ejecuta = true;
	    } else if ($.trim(pg) != '') {
	        ejecuta = true;
	    }
	    if (ejecuta == true) {
	        window.open(url, '_blank');
	    } else {
	        Swal.fire({
	            title: "Parametros requeridos",
	            text: "Ingresa al menos un parametro de búsqueda",
	            type: 'error',
	            icon: 'error',
	        })
	    }
	});*/



	/*$("#checktodos").change(function(event) {
	    $(".checkestatus").prop('checked', $(this).prop('checked'))
	});
	$(".checkestatus").change(function(event) {
	    var check = true;
	    $(".checkestatus").each(function(index, el) {
	        if ($(this).prop('checked') == false) {
	            check = false;
	        }
	    });
	    $("#checktodos").prop('checked', check);
	});

	$("#vw_exp_excelitem").click(function(e) {

	    e.preventDefault();

	    $('#frm_search_docpagoitems input,select').removeClass('is-invalid');
	    $('#frm_search_docpagoitems .invalid-feedback').remove();
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');
	    var fi = $("#fictxtfecha_desde").val();
	    var ff = $("#fictxtfecha_hasta").val();
	    var ct = $("#cboconceptos").val();

	    var url = base_url + url_excel + '?fi=' + fi + '&ff=' + ff + '&ct=' + ct;

	    var ejecuta = false;
	    if ($.trim(fi) != '') {
	        ejecuta = true;
	    }
	    if ($.trim(ff) != '') {
	        ejecuta = true;
	    }
	    if ($.trim(ct) != '') {
	        ejecuta = true;
	    } else {
	        ejecuta = false;
	    }

	    if (ejecuta == true) {
	        window.open(url, '_blank');
	    } else {
	        Swal.fire({
	            title: "Parámetros requeridos",
	            text: "Completa todos los parámetros de búsqueda",
	            type: 'error',
	            icon: 'error',
	        })
	    }
	});

	$("#vw_exp_pdfitem").click(function(e) {
	    e.preventDefault();

	    $('#frm_search_docpago input,select').removeClass('is-invalid');
	    $('#frm_search_docpago .invalid-feedback').remove();
	    var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlpdf');
	    var fi = $("#fictxtfecha_desde").val();
	    var ff = $("#fictxtfecha_hasta").val();
	    var ct = $("#cboconceptos").val();

	    var url = base_url + url_pdf + '?fi=' + fi + '&ff=' + ff + '&ct=' + ct;
	    var ejecuta = false;
	    if ($.trim(fi) != '') {
	        ejecuta = true;
	    }
	    if ($.trim(ff) != '') {
	        ejecuta = true;
	    }
	    if ($.trim(ct) != '') {
	        ejecuta = true;
	    } else {
	        ejecuta = false;
	    }

	    if (ejecuta == true) {
	        window.open(url, '_blank');
	    } else {
	        Swal.fire({
	            title: "Parámetros requeridos",
	            text: "Completa todos los parámetros de búsqueda",
	            type: 'error',
	            icon: 'error',
	        })
	    }
	});*/
</script>