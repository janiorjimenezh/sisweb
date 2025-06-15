<?php
	$meses = array("1"=>"Enero","2"=>"Febrero","3"=>"Marzo","4"=>"Abril","5"=>"Mayo","6"=>"Junio","7"=>"Julio","8"=>"Agosto","9"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");

	date_default_timezone_set('America/Lima');
	$vuser=$_SESSION['userActivo'];
    $anioactual = date('Y');
?>
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
							<input class="form-check-input rd_reportes" data-title='Documentos emitidos' type="radio" data-view='ts_div_vwreportes' data-urlpdf='tesoreria/facturacion/reportes/documentos-emitidos/pdf' data-urlexcel='tesoreria/facturacion/reportes/documentos-emitidos/excel' data-urlword="" name="exampleRadios" id="r301" value="301" checked>
							<label class="form-check-label" for="r301">
								Documentos emitidos 
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Documentos emitidos - formato SIRE' type="radio" data-view='ts_div_vwreportes' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reporte/documentos-emitidos/formato-sire/excel' data-urlword="" name="exampleRadios" id="r301A" value="r301A">
							<label class="form-check-label" for="r301A">
								Documentos emitidos - formato SIRE
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Documentos emitidos detallando conceptos' data-view='ts_div_vwreportes' data-urlpdf='tesoreria/facturacion/reportes/documentos-emitidos-detalle-concepto/pdf' data-urlexcel='tesoreria/facturacion/reportes/documentos-emitidos-detalle-concepto/excel' data-urlword="" type="radio" name="exampleRadios" id="r302" value="302">
							<label class="form-check-label" for="r302">
								Documentos emitidos - Detalle de conceptos
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Documentos emitidos detallando Medios de Pago' data-view='ts_div_vwreportes' data-urlpdf='tesoreria/facturacion/reportes/documentos-emitidos-detalle-medios/pdf' data-urlexcel='tesoreria/facturacion/reportes/documentos-emitidos-detalle-medios/excel' data-urlword="tesoreria/facturacion/reportes/documentos-emitidos-detalle-medios/word" type="radio" name="exampleRadios" id="r303" value="303">
							<label class="form-check-label" for="r303">
								Documentos emitidos - Detalle Medios de Pago
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Deudas por Cuota' data-view='ts_div_vwreportes' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reportes/documentos-emitidos-cudaro-conceptos/excel' data-urlword="" type="radio" name="exampleRadios" id="r306" value="306">
							<label class="form-check-label" for="r306">
								Documentos emitidos - Cuadro por conceptos
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Cuadro por conceptos Agrupado por Programa' data-view='ts_div_vwreportes' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reportes/documentos-emitidos-cudaro-conceptos-agrupado/excel' data-urlword="" type="radio" name="exampleRadios" id="r311" value="311">
							<label class="form-check-label" for="r311">
								Documentos emitidos - Cuadro por conceptos Agrupado por Programa
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Cuadro por conceptos Agrupado por Programa' data-view='ts_div_vwreportes_completo' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reportes/documentos-emitidos-cudaro-conceptos-grupos/excel' data-urlword="" type="radio" name="exampleRadios" id="r314" value="314">
							<label class="form-check-label" for="r314">
								Documentos emitidos - Cuadro por conceptos por grupo y/ matrícula<span class="right badge badge-danger">Nuevo</span>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Cuadro por conceptos Agrupado por Programa' data-view='ts_div_vwreportes_completo' data-urlpdf='' data-urlexcel='estadistica/matriculas/reportes/consolidado-315/excel' data-urlword="" type="radio" name="exampleRadios" id="r315" value="315">
							<label class="form-check-label" for="r315">
								Consolidado de Matriculas Por Semestre y Programa<span class="right badge badge-danger">Nuevo</span>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Documentos de Pago por Items' data-view='ts_div_vwreportes_pagoxitem' data-urlpdf='tesoreria/facturacion/reportes/documentos-emitidos-items/pdf' data-urlexcel='tesoreria/facturacion/reportes/documentos-emitidos-items/excel' type="radio" name="exampleRadios" id="r304" value="304">
							<label class="form-check-label" for="r304">
								Documentos emitidos por Items <span class="right badge badge-danger">Nuevo</span>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Deudas por Cuota' data-view='ts_div_vwreportes_deudaxcuota' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reportes/deudas_xcuotas_grupo/excel' type="radio" name="exampleRadios" id="r305" value="305">
							<label class="form-check-label" for="r305">
								Deudas por Cuotas
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Deudas por Cuota - Ubicación' data-view='ts_div_vwreportes_deudaxcuota' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reportes/deudas_xcuotas_grupo_ubicacion/excel' type="radio" name="exampleRadios" id="r310" value="310">
							<label class="form-check-label" for="r310">
								Deudas por Cuotas - Ubicación <span class="right badge badge-danger">Nuevo</span>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='CONSOLIDADO DE DEUDAS POR GRUPO (Cuotas)' data-view='ts_div_vwreportes_deudaxcuota' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reporte/deudas/grupo/excel' type="radio" name="exampleRadios" id="r312" value="312">
							<label class="form-check-label" for="r312">
								Deudas por grupo (Por Cuotas)
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='CONSOLIDADO DE DEUDAS POR GRUPO' data-view='ts_div_vwreportes_deudaxcuota' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reporte/deudas/grupo-consolidado/excel' type="radio" name="exampleRadios" id="r313" value="313">
							<label class="form-check-label" for="r313">
								Deudas por grupo (Consolidado)<span class="right badge badge-danger">Nuevo</span>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Consolidado por mes' data-view='ts_div_vwreportes_consolidames' data-urlpdf='tesoreria/facturacion/reporte/consolidado/mes/pdf' data-urlexcel='tesoreria/facturacion/reporte/consolidado/mes/excel' type="radio" name="exampleRadios" id="r307" value="307">
							<label class="form-check-label" for="r307">
								Consolidado por mes
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Deudas por estudiante' data-view='ts_div_vwreportes_deuda_estduante' data-urlpdf='tesoreria/facturacion/reporte/deudas/estudiante/pdf' data-urlexcel='tesoreria/facturacion/reporte/deudas/estudiante/excel' type="radio" name="exampleRadios" id="r308" value="308">
							<label class="form-check-label" for="r308">
								Deudas por estudiante
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Estado de cuenta' data-view='ts_div_vwreportes_estado_cuenta' data-urlpdf='tesoreria/facturacion/reporte/estado/cuenta/pdf' data-urlexcel='tesoreria/facturacion/reporte/estado/cuenta/excel' type="radio" name="exampleRadios" id="r309" value="309">
							<label class="form-check-label" for="r309">
								Estado de cuenta
							</label>
						</div>

						<div class="form-check">
							<input class="form-check-input rd_reportes" data-title='Pagos estudiantes' data-view='ts_div_vwreportes_pagos_estudiante' data-urlpdf='' data-urlexcel='tesoreria/facturacion/reportes/grupal/matriculados/consolidado-pagos/excel' type="radio" name="exampleRadios" id="r313" value="313">
							<label class="form-check-label" for="r313">
								Consolidado Grupal de Pagos por matriculado <span class="right badge badge-danger">Nuevo</span>
							</label>
						</div>

						
					</div>
					
					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title">Documentos emitidos</h3>
							</div>
							<div class="col-12">
								<form id="frm_search_docpago" action="" method="post" accept-charset="utf-8">
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
										<div class="form-group has-float-label col-md-4 col-12 ">
											<select name="cbosededocum" id="cbosededocum" class="form-control form-control-sm" required="">
												<?php
												if (count($vuser->sedes) > 1) {
													echo "<option value='%' >Todos</option>";
												}
												foreach ($vuser->sedes as $vsd) {
													$select= ($vsd->idsede==$vuser->idsede) ? "selected" : "";
													$idsede = base64url_encode($vsd->idsede);
													echo "<option $select value='$idsede' >$vsd->nombre</option>";
												}
												?>
											</select>
											<label for="cbosededocum">Filial</label>
										</div>
	
								

										<div class="form-group has-float-label col-md-4 col-6 ">
											<input type="date" name="fictxtfecha_emision" id="fictxtfecha_emision" class="form-control form-control-sm fictxtfecha_emision_class">
											<label for="fictxtfecha_emision">Fecha Inicio</label>
										</div>
										<div class="form-group has-float-label col-md-4 col-6">
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
											<a id='vw_exp_word' class='btn btn-sm btn-primary vw_btn_exp_word' href='#'>Word</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_completo">
						<div class="row">
							<div class="col-12 mb-2">
								<h5  id="vw_exp_title_completo">Documentos emitidos</h5>
							</div>
							<div class="col-12">
								<form id="frm_search_docpago_completo" action="" method="post" accept-charset="utf-8">
									<div class="row">
										<div class="form-group has-float-label col-md-4 col-12 ">
											<select name="vwrc_cbsede" id="vwrc_cbsede" class="form-control form-control-sm" required="">
												<?php
												if (count($vuser->sedes) > 1) {
													echo "<option value='%' >Todos</option>";
												}
												foreach ($vuser->sedes as $vsd) {
													$select= ($vsd->idsede==$vuser->idsede) ? "selected" : "";
													
													echo "<option $select value='{$vsd->idsede}' >$vsd->nombre</option>";
												}
												?>
											</select>
											<label for="vwrc_cbsede">Filial</label>
										</div>
										<hr>
										<div class="form-group has-float-label col-md-4 col-6 ">
											<input type="date" name="vwrc_txtfecha_emision" id="vwrc_txtfecha_emision" class="form-control form-control-sm fictxtfecha_emision_class">
											<label for="vwrc_txtfecha_emision">Fecha Inicio</label>
										</div>
										<div class="form-group has-float-label col-md-4 col-6">
											<input type="date" name="vwrc_txtfecha_emisionf" id="vwrc_txtfecha_emisionf" class="form-control form-control-sm fictxtfecha_emisionf_class">
											<label for="vwrc_txtfecha_emisionf">Fecha Final</label>
										</div>
										
	
										<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="vwrc_cbperiodo" name="vwrc_cbperiodo" placeholder="Periodo" required >
												<option value="%">Seleciona</option>
												<?php foreach ($periodos as $periodo) {?>
												<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="vwrc_cbperiodo"> Periodo</label>
										</div>
										<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
											<select data-currentvalue='' class="form-control form-control-sm" id="vwrc_cbcarrera" name="vwrc_cbcarrera" placeholder="Programa Académico" >
												<option value="%"></option>
												<?php foreach ($carreras as $carrera) {?>
												<option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
												<?php } ?>
											</select>
											<label for="vwrc_cbcarrera"> Prog. de Estudios</label>
										</div>
										<div class="form-group has-float-label col-12 col-sm-6 col-md-3">
											<select name="vwrc_cbplan" id="vwrc_cbplan"class="form-control form-control-sm">
												<option data-carrera="0" value="%"></option>
												<?php foreach ($planes as $pln) {
												echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
												} ?>
											</select>
											<label for="vwrc_cbplan">Plan estudios</label>
										</div>
										
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
											<select data-currentvalue='' class="form-control form-control-sm" id="vwrc_cbciclo" name="vwrc_cbciclo" placeholder="Semest." required >
												<option value="%"></option>
												<?php foreach ($ciclos as $ciclo) {?>
												<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="vwrc_cbciclo"> Semest.</label>
										</div>
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="vwrc_cbturno" name="vwrc_cbturno" placeholder="Turno" required >
												<option value="%"></option>
												<?php foreach ($turnos as $turno) {?>
												<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
												<?php } ?>
											</select>
											<label for="vwrc_cbturno"> Turno</label>
										</div>
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
											<select data-currentvalue='' class="form-control form-control-sm" id="vwrc_cbseccion" name="cboseccion" placeholder="Sección" required >
												<option value="%"></option>
												<?php foreach ($secciones as $seccion) {?>
												<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
												<?php } ?>
											</select>
											<label for="cboseccion"> Sección</label>
										</div>

										
									</div>

									<div class="col-md-12 border rounded py-2 mb-3">
										<span class="text-bold">Estado de documento</span><br>
										<div class="form-check d-inline-block mr-4">
											<input checked type="checkbox" class="form-check-input" id="vwrc_checktodos" value="TODOS">
											<label class="form-check-label" for="vwrc_checktodos">TODOS</label>
										</div>
										<div class="form-check d-inline-block mr-2">
											<input checked type="checkbox" class="form-check-input checkestatus" id="vwrc_checkaceptado">
											<label class="form-check-label" for="vwrc_checkaceptado">ACEPTADO</label>
										</div>
										<div class="form-check d-inline-block mr-2">
											<input checked type="checkbox" class="form-check-input checkestatus" id="vwrc_checkpendiente">
											<label class="form-check-label" for="vwrc_checkpendiente">PENDIENTE</label>
										</div>
										<div class="form-check d-inline-block mr-2">
											<input checked type="checkbox" class="form-check-input checkestatus" id="vwrc_checkanulado">
											<label class="form-check-label" for="vwrc_checkanulado">ANULADO</label>
										</div>
										<div class="form-check d-inline-block mr-2">
											<input checked type="checkbox" class="form-check-input checkestatus" id="vwrc_checkenviado">
											<label class="form-check-label" for="vwrc_checkenviado">ENVIADO</label>
										</div>
										<div class="form-check d-inline-block mr-2">
											<input checked type="checkbox" class="form-check-input checkestatus" id="vwrc_checkrechazado">
											<label class="form-check-label" for="vwrc_checkrechazado">RECHAZADO</label>
										</div>
										<!-- <div class="form-check d-inline-block mr-2">
											<input checked type="checkbox" class="form-check-input checkestatus" id="checkerror">
											<label class="form-check-label" for="checkerror">ERROR</label>
										</div> -->
									</div>
								
									<div class="row">
										<div class="form-group has-float-label col-12">
											<input type="text" autocomplete="off" name="vwrc_txtpagapenom" id="vwrc_txtpagapenom" class="form-control form-control-sm" placeholder="Cliente">
											<label for="vwrc_txtpagapenom">Cliente</label>
										</div>
										<div class="col-12 text-right">
											<!-- <a id='vw_exp_pdf' class='btn btn-sm btn-danger vw_btn_exp_pdf' href='#'>PDF</a> -->
											<a id='vwrc_exp_excel_completo' class='btn btn-sm btn-success vw_btn_exp_excel' href='#'>Excel</a>
											<!-- <a id='vw_exp_word' class='btn btn-sm btn-primary vw_btn_exp_word' href='#'>Word</a> -->
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_deudaxcuota">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title_deudas">Deudas por Cuota</h3>
							</div>
							<div class="col-12">
								
								<form id="frm_search_deudaxcuota" action="" method="post" accept-charset="utf-8">
									<div class="row mt-2">
										<div class="form-group has-float-label col-4">
											<select name="fca-cbsede" id="fca-cbsede" class="form-control form-control-sm" required="">
												<option value="%">Todas</option>
												<?php
												foreach ($vuser->sedes as $vsd) {
													$select= ($vsd->idsede==$vuser->idsede) ? "selected" : "";
													$idsede = $vsd->idsede;
													echo "<option $select value='$idsede' >$vsd->nombre</option>";
												}
												?>
											</select>
											<label for="fca-cbsede">Sedes</label>
										</div>
										<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
											<select data-currentvalue='' class="form-control" id="fca-cbperiodo" name="fca-cbperiodo" placeholder="Periodo" required >
												<option value="0">Periodo</option>
												<?php foreach ($periodos as $periodo) {?>
												<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbperiodo"> Periodo</label>
										</div>
										<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
											<select data-currentvalue='' class="form-control" id="fca-cbcarrera" name="fca-cbcarrera" placeholder="Programa Académico" >
												<option value="%"></option>
												<?php foreach ($carreras as $carrera) {?>
												<option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbcarrera"> Prog. de Estudios</label>
										</div>
										<div class="form-group has-float-label col-12 col-sm-6 col-md-3">
											<select name="fca-cbplan" id="fca-cbplan"class="form-control">
												<option data-carrera="0" value="%"></option>
												<?php foreach ($planes as $pln) {
												echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
												} ?>
											</select>
											<label for="fca-cbplan">Plan estudios</label>
										</div>
										
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
											<select data-currentvalue='' class="form-control" id="fca-cbciclo" name="fca-cbciclo" placeholder="Ciclo" required >
												<option value="%">Ciclo</option>
												<?php foreach ($ciclos as $ciclo) {?>
												<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbciclo"> Ciclo</label>
										</div>
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
											<select data-currentvalue='' class="form-control" id="fca-cbturno" name="fca-cbturno" placeholder="Turno" required >
												<option value="%">Turno</option>
												<?php foreach ($turnos as $turno) {?>
												<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbturno"> Turno</label>
										</div>
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
											<select data-currentvalue='' class="form-control" id="fca-cbseccion" name="fca-cbseccion" placeholder="Sección" required >
												<option value="%">Sección</option>
												<?php foreach ($secciones as $seccion) {?>
												<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbseccion"> Sección</label>
										</div>

											<div class="col-12 col-sm-4">
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input" id="checkv" value="SI">
													<label class="form-check-label" for="checkv">Solo Deudas Vencidas</label>
												</div>
											</div>
										
									</div>
									
									<div class="col-4 border rounded py-2 mb-3">
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input" id="checkctodos" value="TODOS">
											<label class="form-check-label" for="checkctodos">TODOS</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkescuotas" data-value='' id="checkc1">
											<label class="form-check-label" for="checkc1">CUOTA 01</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkescuotas" data-value='' id="checkc2">
											<label class="form-check-label" for="checkc2">CUOTA 02</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkescuotas" data-value='' id="checkc3">
											<label class="form-check-label" for="checkc3">CUOTA 03</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkescuotas" data-value='' id="checkc4">
											<label class="form-check-label" for="checkc4">CUOTA 04</label>
										</div>
										<div class="form-check">
											<input checked type="checkbox" class="form-check-input checkescuotas" data-value='' id="checkc5">
											<label class="form-check-label" for="checkc5">CUOTA 05</label>
										</div>
									</div>
									<!--<div class="row">
										<div class="form-group has-float-label col-6 ">
											<input type="date" name="fictxtfecha_emision" id="fictxtfecha_emision" class="form-control form-control-sm fictxtfecha_emision_class">
											<label for="fictxtfecha_emision">Fecha Inicio</label>
										</div>
										<div class="form-group has-float-label col-6">
											<input type="date" name="fictxtfecha_emisionf" id="fictxtfecha_emisionf" class="form-control form-control-sm fictxtfecha_emisionf_class">
											<label for="fictxtfecha_emisionf">Fecha Final</label>
										</div>
									</div>-->
									<div class="row">
										<!--<div class="form-group has-float-label col-12">
											<input type="text" autocomplete="off" name="fictxtpagapenom" id="fictxtpagapenom" class="form-control form-control-sm" placeholder="Cliente">
											<label for="fictxtpagapenom">Cliente</label>
										</div>-->
										<div class="col-12 text-right">
											<!--<a id='vw_exp_pdf' class='btn btn-sm btn-danger' href='#'>PDF</a>-->
											<a id='vw_deudaxcuota_excel' class='btn btn-sm btn-success' href='#'>
												<i class="fas fa-file-excel"></i> Excel
											</a>
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

					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_consolidames">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title">Consolidado por mes</h3>
							</div>
							<div class="col-12">
								<form id="frm_search_consolida" action="" method="post" accept-charset="utf-8">
									<div class="row">
										<div class="form-group has-float-label col-4">
											<select name="cbosede" id="cbosede" class="form-control form-control-sm" required="">
												<option value="%">Sede#</option>
												<?php
												if (count($vuser->sedes) > 1) {
													echo "<option value='%' >Todos</option>";
												}
												foreach ($vuser->sedes as $vsd) {
													$select= ($vsd->idsede==$vuser->idsede) ? "selected" : "";
													$idsede = base64url_encode($vsd->idsede);
													echo "<option $select value='$idsede' >$vsd->nombre</option>";
												}
												?>
											</select>
											<label for="cbosede">Sedes</label>
										</div>
										<div class="form-group has-float-label col-4">
											<select name="cbomeses" id="cbomeses" class="form-control form-control-sm" required="">
												<option value="%">Mes#</option>
												<?php
												foreach ($meses as $key => $ms) {
													echo "<option value='$key' >$ms</option>";
												}
												?>
											</select>
											<label for="cbomeses">Meses</label>
										</div>
										<div class="form-group has-float-label col-4">
											<input type="number" name="fibtxtanio" id="fibtxtanio" value="<?php echo $anioactual ?>" placeholder="Año" class="form-control form-control-sm" required="">
											<label for="fibtxtanio">Año</label>
										</div>
										<div class="col-12 text-right">
											<a id='vw_exp_pdf_consolida' class='btn btn-sm btn-danger vw_btn_exp_pdf' href='#'>PDF</a>
											<a id='vw_exp_excel_consolida' class='btn btn-sm btn-success vw_btn_exp_excel' href='#'>Excel</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_deuda_estduante">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title">Deudas por estudiante</h3>
							</div>
							<div class="col-12">
								<form id="frm_search_deudas_estudiante" action="" method="post" accept-charset="utf-8">
									<div class="row">
										<div class="form-group has-float-label col-4">
											<select name="cbotipo_est" id="cbotipo_est" class="form-control form-control-sm" required="">
												<option value="DNI">DNI</option>
												<option value="CARNET">CARNÉ</option>
											</select>
											<label for="cbotipo_est">Tipo</label>
										</div>
										<div class="form-group has-float-label col-8">
											<input type="text" name="fibtxt_nrotipo" id="fibtxt_nrotipo" value="" placeholder="Nro" class="form-control form-control-sm" required="">
											<label for="fibtxt_nrotipo">Nro</label>
										</div>
										<div class="col-12 text-right">
											<a id='vw_exp_pdf_deuda_al' class='btn btn-sm btn-danger vw_btn_exp_pdf' href='#'>PDF</a>
											<a id='vw_exp_excel_deuda_al' class='btn btn-sm btn-success vw_btn_exp_excel' href='#'>Excel</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_estado_cuenta">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title_deudas">Estado de cuenta</h3>
							</div>
							<div class="col-12">
								<form id="frm_search_estado_cuenta" action="" method="post" accept-charset="utf-8">
									<div class="col-12 border rounded py-2 mb-3">
										<p class="text-dark"><b>Campos para Pagos</b></p>
										<div class="row mt-2">
											<div class="col-12 col-sm-4 mb-2"></div>
											<div class="col-12 col-sm-8 mb-2">
												<div class="form-check">
													<input type="checkbox" class="form-check-input" id="checksfec" value="SI">
													<label class="form-check-label" for="checksfec">Habilitar fechas</label>
												</div>
											</div>
											<div class="form-group has-float-label col-12 col-sm-4">
												<input type="text" autocomplete="off" name="fictxtdnicarne" id="fictxtdnicarne" class="form-control form-control-sm" placeholder="Dni o Carné" minlength="8">
												<label for="fictxtdnicarne">Dni o Carné</label>
											</div>
											<div class="form-group has-float-label col-12 col-sm-4">
												<input type="date" name="fictxtfecha_emisionest" id="fictxtfecha_emisionest" class="form-control form-control-sm fictxtfecha_emision_class checkfechaestado">
												<label for="fictxtfecha_emisionest">Fecha Inicio</label>
											</div>
											<div class="form-group has-float-label col-12 col-sm-4">
												<input type="date" name="fictxtfecha_emisionfest" id="fictxtfecha_emisionfest" class="form-control form-control-sm fictxtfecha_emisionf_class checkfechaestado">
												<label for="fictxtfecha_emisionfest">Fecha Final</label>
											</div>

										</div>
									</div>
									
									<div class="col-12 border rounded py-2 mb-3">
										<div class="row">
											<div class="col-12 col-sm-4">
												<p class="text-dark mb-0"><b>Campos para Deudas</b></p>
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input" id="checkstodos" value="TODOS">
													<label class="form-check-label" for="checkstodos">TODOS</label>
												</div>
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input checksemestre" data-value='' id="checks1">
													<label class="form-check-label" for="checks1">I SEMESTRE</label>
												</div>
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input checksemestre" data-value='' id="checks2">
													<label class="form-check-label" for="checks2">II SEMESTRE</label>
												</div>
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input checksemestre" data-value='' id="checks3">
													<label class="form-check-label" for="checks3">III SEMESTRE</label>
												</div>
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input checksemestre" data-value='' id="checks4">
													<label class="form-check-label" for="checks4">IV SEMESTRE</label>
												</div>
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input checksemestre" data-value='' id="checks5">
													<label class="form-check-label" for="checks5">V SEMESTRE</label>
												</div>
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input checksemestre" data-value='' id="checks6">
													<label class="form-check-label" for="checks6">VI SEMESTRE</label>
												</div>
											</div>

											<div class="col-12 col-sm-8 border-left">
												<div class="form-check">
													<input checked type="checkbox" class="form-check-input" id="checksv" value="SI">
													<label class="form-check-label" for="checksv">Mostrar Solo Deudas Pendientes</label>
												</div>
											</div>
										</div>
										
									</div>

									<div class="row">
										<div class="col-12 text-right">
											<a id='vw_estadocuenta_pdf' class='btn btn-sm btn-danger' href='#'>
												<i class="fas fa-file-pdf"></i> PDF
											</a>
											<a id='vw_estadocuenta_excel' class='btn btn-sm btn-success' href='#'>
												<i class="fas fa-file-excel"></i> Excel
											</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>


					<div class="col-7 ts_div_reportes" id="ts_div_vwreportes_pagos_estudiante">
						<div class="row">
							<div class="col-12 mb-2">
								<h3  id="vw_exp_title_deudas">Pagos estudiantes</h3>
							</div>
							<div class="col-12">
								
								<form id="frm_search_pagosxcuota" action="" method="post" accept-charset="utf-8">
									
									<div class="row mt-2">
										<div class="form-group has-float-label col-12 col-xs-4 col-sm-3">
											<select data-currentvalue='' class="form-control" id="fca-cbperiodopg" name="fca-cbperiodopg" placeholder="Periodo" required >
												<option value="0">Periodo</option>
												<?php foreach ($periodos as $periodo) {?>
												<option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbperiodopg"> Periodo</label>
										</div>
										<div class="form-group has-float-label col-12 col-sm-6 col-md-4">
											<select data-currentvalue='' class="form-control" id="fca-cbcarrerapg" name="fca-cbcarrerapg" placeholder="Programa Académico" >
												<option value="%"></option>
												<?php foreach ($carreras as $carrera) {?>
												<option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbcarrerapg"> Prog. de Estudios</label>
										</div>
										<div class="form-group has-float-label col-12 col-sm-6 col-md-3">
											<select name="fca-cbplanpg" id="fca-cbplanpg"class="form-control">
												<option data-carrera="0" value="%"></option>
												<?php foreach ($planes as $pln) {
												echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
												} ?>
											</select>
											<label for="fca-cbplanpg">Plan estudios</label>
										</div>
										
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-2">
											<select data-currentvalue='' class="form-control" id="fca-cbciclopg" name="fca-cbciclopg" placeholder="Ciclo" required >
												<option value="%">Ciclo</option>
												<?php foreach ($ciclos as $ciclo) {?>
												<option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbciclopg"> Ciclo</label>
										</div>
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
											<select data-currentvalue='' class="form-control" id="fca-cbturnopg" name="fca-cbturnopg" placeholder="Turno" required >
												<option value="%">Turno</option>
												<?php foreach ($turnos as $turno) {?>
												<option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbturnopg"> Turno</label>
										</div>
										<div class="form-group has-float-label col-12 col-xs-12 col-sm-3">
											<select data-currentvalue='' class="form-control" id="fca-cbseccionpg" name="fca-cbseccionpg" placeholder="Sección" required >
												<option value="%">Sección</option>
												<?php foreach ($secciones as $seccion) {?>
												<option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
												<?php } ?>
											</select>
											<label for="fca-cbseccionpg"> Sección</label>
										</div>
										
									</div>
									
									<div class="row">
										<div class="col-12 text-right">
											<!--<a id='vw_exp_pdf' class='btn btn-sm btn-danger' href='#'>PDF</a>-->
											<a id='vw_pagosxcuota_excel' class='btn btn-sm btn-success' href='#'>
												<i class="fas fa-file-excel"></i> Excel
											</a>
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
	    $("#r301").change();
	    $(".ts_div_reportes").hide();
	    $("#ts_div_vwreportes").show();
	    $('#cbotipo_est').change();
	    var factual = new Date();
	    var anio = factual.getFullYear();
	    var mes = ("0" + (factual.getMonth() + 1)).slice(-2);
	    var udia = new Date(anio, mes, 0).getDate();
	    $(".fictxtfecha_emision_class").val(anio + "-" + mes + "-01");
	    $(".fictxtfecha_emisionf_class").val(anio + "-" + mes + "-" + udia);
	    $('#checksfec').change();
	});

	$('#fca-cbcarrera').change(function(event) {

	    var codcar = $(this).val();
	    if (codcar == "%") {
	        $("#fca-cbplan option").each(function(i) {
	            if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
	        });
	    } else {
	        $("#fca-cbplan option").each(function(i) {

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
	    	if ($(this).data("urlword")=="") {
	    		$(".vw_btn_exp_word").hide();
	    	}
	    	else{
	    		$(".vw_btn_exp_word").show();
	    	}
	    }
	   
	});

	$("#vw_deudaxcuota_excel").click(function(e) {
	    e.preventDefault();

	    $('#frm_search_docpago input,select').removeClass('is-invalid');
	    $('#frm_search_docpago .invalid-feedback').remove();
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');
	    var fi = $("#fictxtfecha_emision").val();
	    var ff = $("#fictxtfecha_emisionf").val();
	    var pg = $("#fictxtpagapenom").val();

	  	/*$fmcbperiodo=$this->input->get("cp");
        $fmcbcarrera=$this->input->get("cc");
        $fmcbciclo=$this->input->get("ccc");
        $fmcbturno=$this->input->get("ct");
        $fmcbseccion=$this->input->get("cs");
        $fmcbplan=$this->input->get("cpl");
        $busqueda=$this->input->get("ap");*/

        checkctodos = ($("#checkctodos").prop('checked') == true ? "&checkctodos=TODOS" : "");
	    checkc1 = ($("#checkc1").prop('checked') == true ? "&checkc1=CUOTA1" : "");
	    checkc2 = ($("#checkc2").prop('checked') == true ? "&checkc2=CUOTA2" : "");
	    checkc3 = ($("#checkc3").prop('checked') == true ? "&checkc3=CUOTA3" : "");
	    checkc4 = ($("#checkc4").prop('checked') == true ? "&checkc4=CUOTA4" : "");
	    checkc5 = ($("#checkc5").prop('checked') == true ? "&checkc5=CUOTA5" : "");
	    checkv = ($("#checkv").prop('checked') == true ? "&checkcv=SI" : "");
	    

        var url = base_url + url_excel +'?cd=' + $("#fca-cbsede").val() + '&cp=' + $("#fca-cbperiodo").val() + '&cc=' + $("#fca-cbcarrera").val() + '&ccc=' + $("#fca-cbciclo").val() + '&ct=' + $("#fca-cbturno").val() + '&cs=' + $("#fca-cbseccion").val() + '&cpl=' + $("#fca-cbplan").val() + '&ap=' + $("#fictxtpagapenom").val() + checkctodos + checkc1 + checkc2 + checkc3 + checkc4 +checkc5 + checkv;
        
        /*cbperiodo
		cbcarrera
		cbplan
		cbciclo
		cbturno
		cbseccion*/
		//var url = UR
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
	});

	$("#vw_exp_excel").click(function(e) {
	    e.preventDefault();
	    $('#frm_search_docpago input,select').removeClass('is-invalid');
	    $('#frm_search_docpago .invalid-feedback').remove();
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');

	    var fi = $("#fictxtfecha_emision").val();
	    var ff = $("#fictxtfecha_emisionf").val();
	    var pg = $("#fictxtpagapenom").val();
	    var fil = $("#cbosededocum").val();

	    checktodos = ($("#checktodos").prop('checked') == true ? "&checktodos=TODOS" : "");
	    checkanulado = ($("#checkanulado").prop('checked') == true ? "&checkanulado=ANULADO" : "");
	    checkenviado = ($("#checkenviado").prop('checked') == true ? "&checkenviado=ENVIADO" : "");
	    checkrechazado = ($("#checkrechazado").prop('checked') == true ? "&checkrechazado=RECHAZADO" : "");
	    checkerror = ($("#checkerror").prop('checked') == true ? "&checkerror=ERROR" : "");
	    checkaceptado = ($("#checkaceptado").prop('checked') == true ? "&checkaceptado=ACEPTADO" : "");
	    checkpendiente = ($("#checkpendiente").prop('checked') == true ? "&checkpendiente=PENDIENTE" : "");
	    var url = base_url + url_excel + '?fi=' + fi + '&ff=' + ff + '&pg=' + pg + '&fil=' + fil + checktodos + checkanulado + checkenviado + checkrechazado + checkerror + checkaceptado + checkpendiente;
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
	});

	$("#vwrc_exp_excel_completo").click(function(e) {
	    e.preventDefault();
	    $('#frm_search_docpago input,select').removeClass('is-invalid');
	    $('#frm_search_docpago .invalid-feedback').remove();
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');

	    var fi = $("#vwrc_txtfecha_emision").val();
	    var ff = $("#vwrc_txtfecha_emisionf").val();
	    var pg = $("#vwrc_txtpagapenom").val();

	    checktodos = ($("#vwrc_checktodos").prop('checked') == true ? "&checktodos=TODOS" : "");
	    checkanulado = ($("#vwrc_checkanulado").prop('checked') == true ? "&checkanulado=ANULADO" : "");
	    checkenviado = ($("#vwrc_checkenviado").prop('checked') == true ? "&checkenviado=ENVIADO" : "");
	    checkrechazado = ($("#vwrc_checkrechazado").prop('checked') == true ? "&checkrechazado=RECHAZADO" : "");
	    checkerror = ($("#vwrc_checkerror").prop('checked') == true ? "&checkerror=ERROR" : "");
	    checkaceptado = ($("#vwrc_checkaceptado").prop('checked') == true ? "&checkaceptado=ACEPTADO" : "");
	    checkpendiente = ($("#vwrc_checkpendiente").prop('checked') == true ? "&checkpendiente=PENDIENTE" : "");

	    //var url = base_url + url_excel +'?cd=' + $("#fca-cbsede").val() + '&cp=' + $("#fca-cbperiodo").val() + '&cc=' + $("#fca-cbcarrera").val() + '&ccc=' + $("#fca-cbciclo").val() + '&ct=' + $("#fca-cbturno").val() + '&cs=' + $("#fca-cbseccion").val() + '&cpl=' + $("#fca-cbplan").val() + '&ap=' + $("#fictxtpagapenom").val() + checkctodos + checkc1 + checkc2 + checkc3 + checkc4 +checkc5 + checkv;

	    var url = base_url + url_excel + '?cd=' + $("#vwrc_cbsede").val() + '&cp=' + $("#vwrc_cbperiodo").val() + '&cc=' + $("#vwrc_cbcarrera").val() + '&ccc=' + $("#vwrc_cbciclo").val() + '&ct=' + $("#vwrc_cbturno").val() + '&cs=' + $("#vwrc_cbseccion").val() + '&cpl=' + $("#vwrc_cbplan").val() + '&fi=' + fi + '&ff=' + ff + '&pg=' + pg + checktodos + checkanulado + checkenviado + checkrechazado + checkerror + checkaceptado + checkpendiente;
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
	});

	$("#vw_exp_pdf").click(function(e) {
	    e.preventDefault();

	    $('#frm_search_docpago input,select').removeClass('is-invalid');
	    $('#frm_search_docpago .invalid-feedback').remove();
	    var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlpdf');
	    var fi = $("#fictxtfecha_emision").val();
	    var ff = $("#fictxtfecha_emisionf").val();
	    var pg = $("#fictxtpagapenom").val();
	    var fil = $("#cbosededocum").val();
	    checktodos = ($("#checktodos").prop('checked') == true ? "&checktodos=TODOS" : "");
	    checkanulado = ($("#checkanulado").prop('checked') == true ? "&checkanulado=ANULADO" : "");
	    checkenviado = ($("#checkenviado").prop('checked') == true ? "&checkenviado=ENVIADO" : "");
	    checkrechazado = ($("#checkrechazado").prop('checked') == true ? "&checkrechazado=RECHAZADO" : "");
	    checkerror = ($("#checkerror").prop('checked') == true ? "&checkerror=ERROR" : "");
	    checkaceptado = ($("#checkaceptado").prop('checked') == true ? "&checkaceptado=ACEPTADO" : "");
	    checkpendiente = ($("#checkpendiente").prop('checked') == true ? "&checkpendiente=PENDIENTE" : "");
	    var url = base_url + url_pdf + '?fi=' + fi + '&ff=' + ff + '&pg=' + pg + '&fil=' + fil + checktodos + checkanulado + checkenviado + checkrechazado + checkerror + checkaceptado + checkpendiente;
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
	});

	$("#vw_exp_word").click(function(e) {
	    e.preventDefault();
	    $('#frm_search_docpago input,select').removeClass('is-invalid');
	    $('#frm_search_docpago .invalid-feedback').remove();
	    var url_word = $("#divcard_ls_reportes input[type='radio']:checked").data('urlword');

	    var fi = $("#fictxtfecha_emision").val();
	    var ff = $("#fictxtfecha_emisionf").val();
	    var pg = $("#fictxtpagapenom").val();
	    var fil = $("#cbosededocum").val();

	    checktodos = ($("#checktodos").prop('checked') == true ? "&checktodos=TODOS" : "");
	    checkanulado = ($("#checkanulado").prop('checked') == true ? "&checkanulado=ANULADO" : "");
	    checkenviado = ($("#checkenviado").prop('checked') == true ? "&checkenviado=ENVIADO" : "");
	    checkrechazado = ($("#checkrechazado").prop('checked') == true ? "&checkrechazado=RECHAZADO" : "");
	    checkerror = ($("#checkerror").prop('checked') == true ? "&checkerror=ERROR" : "");
	    checkaceptado = ($("#checkaceptado").prop('checked') == true ? "&checkaceptado=ACEPTADO" : "");
	    checkpendiente = ($("#checkpendiente").prop('checked') == true ? "&checkpendiente=PENDIENTE" : "");
	    var url = base_url + url_word + '?fi=' + fi + '&ff=' + ff + '&pg=' + pg + '&fil=' + fil + checktodos + checkanulado + checkenviado + checkrechazado + checkerror + checkaceptado + checkpendiente;
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
	});

	$("#checktodos").change(function(event) {
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
	});

	$("#checkctodos").change(function(event) {
	    $(".checkescuotas").prop('checked', $(this).prop('checked'))
	});

	$(".checkescuotas").change(function(event) {
	    var check = true;
	    $(".checkescuotas").each(function(index, el) {
	        if ($(this).prop('checked') == false) {
	            check = false;
	        }
	    });
	    $("#checkctodos").prop('checked', check);
	});

	$("#vw_exp_pdf_consolida").click(function(e) {
	    e.preventDefault();

	    $('#frm_search_consolida input,select').removeClass('is-invalid');
	    $('#frm_search_consolida .invalid-feedback').remove();
	    var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlpdf');
	    var sd = $('#cbosede').val();
	    var ms = $('#cbomeses').val();
	    var anio = $('#fibtxtanio').val();

	    var url = base_url + url_pdf + '?sd=' + sd + '&ms=' + ms + '&year=' + anio;
	    var ejecuta = false;
	    if ($.trim(anio) != '') {
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
	});

	$('#vw_exp_excel_consolida').click(function(e) {
		e.preventDefault();

	    $('#frm_search_consolida input,select').removeClass('is-invalid');
	    $('#frm_search_consolida .invalid-feedback').remove();
	    var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');
	    var sd = $('#cbosede').val();
	    var ms = $('#cbomeses').val();
	    var anio = $('#fibtxtanio').val();

	    var url = base_url + url_pdf + '?sd=' + sd + '&ms=' + ms + '&year=' + anio;
	    var ejecuta = false;
	    if ($.trim(anio) != '') {
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
	});

	$('#cbotipo_est').change(function(e) {
		var valor = $(this).val();
		var texto = "";
		if (valor == "DNI") {
			texto = "DNI";
		} else {
			texto = "CARNÉ";
		}
		$('#fibtxt_nrotipo').attr('placeholder', texto);
		$('label[for="fibtxt_nrotipo"]').html(texto);
	});
	$("#vw_exp_pdf_deuda_al").click(function(e) {
	    e.preventDefault();

	    $('#frm_search_deudas_estudiante input,select').removeClass('is-invalid');
	    $('#frm_search_deudas_estudiante .invalid-feedback').remove();
	    var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlpdf');
	    var tp = $('#cbotipo_est').val();
	    var nro = $('#fibtxt_nrotipo').val();

	    var url = base_url + url_pdf + '?tp=' + tp + '&nro=' + nro;
	    var ejecuta = false;

	    if ($.trim(nro) != '') {
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
	});

	$('#vw_exp_excel_deuda_al').click(function(e) {
		e.preventDefault();

	    $('#frm_search_deudas_estudiante input,select').removeClass('is-invalid');
	    $('#frm_search_deudas_estudiante .invalid-feedback').remove();
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');
	    var tp = $('#cbotipo_est').val();
	    var nro = $('#fibtxt_nrotipo').val();

	    var url = base_url + url_excel + '?tp=' + tp + '&nro=' + nro;
	    var ejecuta = false;

	    if ($.trim(nro) != '') {
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
	});

	$("#checkstodos").change(function(event) {
	    $(".checksemestre").prop('checked', $(this).prop('checked'))
	});

	$(".checksemestre").change(function(event) {
	    var check = true;
	    $(".checksemestre").each(function(index, el) {
	        if ($(this).prop('checked') == false) {
	            check = false;
	        }
	    });
	    $("#checkstodos").prop('checked', check);
	});

	$('#vw_estadocuenta_pdf').click(function(e) {
		e.preventDefault();

	    $('#frm_search_estado_cuenta input,select').removeClass('is-invalid');
	    $('#frm_search_estado_cuenta .invalid-feedback').remove();
	    var url_pdf = $("#divcard_ls_reportes input[type='radio']:checked").data('urlpdf');
	    var fi = $("#fictxtfecha_emisionest").val();
	    var ff = $("#fictxtfecha_emisionfest").val();
	    var pg = $("#fictxtdnicarne").val();
	    checktodos = ($("#checkstodos").prop('checked') == true ? "&checkstodos=TODOS" : "");
	    sem1 = ($("#checks1").prop('checked') == true ? "&checksem1=01" : "");
	    sem2 = ($("#checks2").prop('checked') == true ? "&checksem2=02" : "");
	    sem3 = ($("#checks3").prop('checked') == true ? "&checksem3=03" : "");
	    sem4 = ($("#checks4").prop('checked') == true ? "&checksem4=04" : "");
	    sem5 = ($("#checks5").prop('checked') == true ? "&checksem5=05" : "");
	    sem6 = ($("#checks6").prop('checked') == true ? "&checksem6=06" : "");
	    pend = ($('#checksv').prop('checked') == true ? "&checkpend=SI" : "");

	    var url = base_url + url_pdf + '?fi=' + fi + '&ff=' + ff + '&pg=' + pg  + checktodos + sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + pend;
	    if ($('#checksfec').prop('checked') == false) {
            url = base_url + url_pdf + '?pg=' + pg  + checktodos + sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + pend;
        }

	    var ejecuta = false;
	    var texto = "Ingresa al menos un parametro de búsqueda";
	    // if ($.trim(fi) != '') {
	    //     ejecuta = true;
	    // } else {
	    // 	ejecuta = false;
	    // }

	    // if ($.trim(ff) != '') {
	    //     ejecuta = true;
	    // } else {
	    // 	ejecuta = false;
	    // }

	    if ($.trim(pg) != '') {
	        // ejecuta = true;
	        if (pg.length < 8) {
		        ejecuta = false;
		        texto = "El campo Dni o Carné debe tener como minimo 8 caracteres";
	    	} else {
	    		ejecuta = true;
	    	}
	    } else {
	    	ejecuta = false;
	    }

	    if (ejecuta == true) {
	        window.open(url, '_blank');
	    } else {
	        Swal.fire({
	            title: "Parametros requeridos",
	            text: texto,
	            type: 'error',
	            icon: 'error',
	        })
	    }
	});

	$('#vw_estadocuenta_excel').click(function(e) {
		e.preventDefault();

	    $('#frm_search_estado_cuenta input,select').removeClass('is-invalid');
	    $('#frm_search_estado_cuenta .invalid-feedback').remove();
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');
	    var fi = $("#fictxtfecha_emisionest").val();
	    var ff = $("#fictxtfecha_emisionfest").val();
	    var pg = $("#fictxtdnicarne").val();
	    checktodos = ($("#checkstodos").prop('checked') == true ? "&checkstodos=TODOS" : "");
	    sem1 = ($("#checks1").prop('checked') == true ? "&checksem1=01" : "");
	    sem2 = ($("#checks2").prop('checked') == true ? "&checksem2=02" : "");
	    sem3 = ($("#checks3").prop('checked') == true ? "&checksem3=03" : "");
	    sem4 = ($("#checks4").prop('checked') == true ? "&checksem4=04" : "");
	    sem5 = ($("#checks5").prop('checked') == true ? "&checksem5=05" : "");
	    sem6 = ($("#checks6").prop('checked') == true ? "&checksem6=06" : "");
	    pend = ($('#checksv').prop('checked') == true ? "&checkpend=SI" : "");
	    var url = base_url + url_excel + '?fi=' + fi + '&ff=' + ff + '&pg=' + pg  + checktodos + sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + pend;
	    if ($('#checksfec').prop('checked') == false) {
            url = base_url + url_excel + '?pg=' + pg  + checktodos + sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + pend;
        }
        
	    var ejecuta = false;
	    var texto = "Ingresa al menos un parametro de búsqueda";
	    // if ($.trim(fi) != '') {
	    //     ejecuta = true;
	    // } else {
	    // 	ejecuta = false;
	    // }

	    // if ($.trim(ff) != '') {
	    //     ejecuta = true;
	    // } else {
	    // 	ejecuta = false;
	    // }

	    if ($.trim(pg) != '') {
	        // ejecuta = true;
	        if (pg.length < 8) {
		        ejecuta = false;
		        texto = "El campo Dni o Carné debe tener como minimo 8 caracteres";
	    	} else {
	    		ejecuta = true;
	    	}
	    } else {
	    	ejecuta = false;
	    }

	    if (ejecuta == true) {
	        window.open(url, '_blank');
	    } else {
	        Swal.fire({
	            title: "Parametros requeridos",
	            text: texto,
	            type: 'error',
	            icon: 'error',
	        })
	    }
	});

	$('#checksfec').change(function(e) {
		var check = false;
		if ($(this).prop('checked') == false) {
            check = true;
        }
	   	
	    $(".checkfechaestado").prop('disabled', check);
	})

	$("#vw_pagosxcuota_excel").click(function(e) {
	    e.preventDefault();

	    $('#frm_search_pagosxcuota input,select').removeClass('is-invalid');
	    $('#frm_search_pagosxcuota .invalid-feedback').remove();
	    var url_excel = $("#divcard_ls_reportes input[type='radio']:checked").data('urlexcel');

        var url = base_url + url_excel +'?cp=' + $("#fca-cbperiodopg").val() + '&cc=' + $("#fca-cbcarrerapg").val() + '&ccc=' + $("#fca-cbciclopg").val() + '&ct=' + $("#fca-cbturnopg").val() + '&cs=' + $("#fca-cbseccionpg").val() + '&cpl=' + $("#fca-cbplanpg").val();
        
	    var ejecuta = true;
	    
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
	});
</script>