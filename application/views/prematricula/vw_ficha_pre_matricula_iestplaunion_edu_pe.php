<?php 
	$vbaseurl=base_url();
	date_default_timezone_set ('America/Lima');
	$codigo = "0";
	$periodo="";
	$ciclopr="";
	$sede="";
	$carrera = "";
	$modalidades="";
	$turno="";
	$apepaterno="";
	$apematerno="";
	$nombres="";
	$tipodoc="";
	$nrodocum="";
	$genero="";
	$estadociv="";
	$trabaja = "";
	$lugtrabaja = "";
	$fechanac="";
	$lugarnac="";
	$telefono="";
	$correoper="";
	$apenompadre="";
	$ocupapadre="";
	$apenommadre="";
	$ocupamadre="";
	$departam="";
	$provincia="";
	$distrito="";
	$direccion="";
	$colegio = "";
	$traslado="";
	$discapacidad="";
	$detalle_discap="";
	$lengua = "Castellano";
	$aniosec = "";
	$dtpublicidad = "";

	$coltiposec = "";
	$departamcol="";
	$provinciacol="";
	$distritocol="";

	$extranjsecu = "";
	$dirextrasecu = "";
	$vpais = "";

	if (isset($ficha->codpre))  $codigo = base64url_encode($ficha->codpre);
	if (isset($ficha->codperiodo))  $periodo = $ficha->codperiodo;
	if (isset($ficha->sede))  $sede = $ficha->sede;
	if (isset($ficha->codcarrera))  $carrera = $ficha->codcarrera;
	if (isset($ficha->codmodalidad))  $modalidades = $ficha->codmodalidad;
	if (isset($ficha->codturno))  $turno = $ficha->codturno;
	if (isset($ficha->paterno))  $apepaterno = $ficha->paterno;
	if (isset($ficha->materno))  $apematerno = $ficha->materno;
	if (isset($ficha->nombres))  $nombres = $ficha->nombres;
	if (isset($ficha->tipodoc))  $tipodoc = $ficha->tipodoc;
	if (isset($ficha->numero))  $nrodocum = $ficha->numero;
	if (isset($ficha->sexo))  $genero = $ficha->sexo;
	if (isset($ficha->estcivil))  $estadociv = $ficha->estcivil;
	if (isset($ficha->trabaja))  $trabaja = $ficha->trabaja;
	if (isset($ficha->lugtrabaja))  $lugtrabaja = $ficha->lugtrabaja;
	if (isset($ficha->fecnac))  $fechanac = date("d/m/Y", strtotime($ficha->fecnac));
	if (isset($ficha->lugnac))  $lugarnac = $ficha->lugnac;
	if (isset($ficha->telefono))  $telefono = $ficha->telefono;
	if (isset($ficha->correo))  $correoper = $ficha->correo;
	if (isset($ficha->nompadre))  $apenompadre = $ficha->nompadre;
	if (isset($ficha->ocuppadre))  $ocupapadre = $ficha->ocuppadre;
	if (isset($ficha->nommadre))  $apenommadre = $ficha->nommadre;
	if (isset($ficha->ocupmadre))  $ocupamadre = $ficha->ocupmadre;
	if (isset($ficha->codepartamento))  $departam = $ficha->codepartamento;
	if (isset($ficha->codprovincia))  $provincia = $ficha->codprovincia;
	if (isset($ficha->coddistrito))  $distrito = $ficha->coddistrito;
	if (isset($ficha->direccion))  $direccion = $ficha->direccion;
	if (isset($ficha->centro))  $colegio = $ficha->centro;
	if (isset($ficha->instituto))  $traslado = $ficha->instituto;
	if (isset($ficha->ciclo))  $ciclopr = $ficha->ciclo;
	if (isset($ficha->discapacidad))  $discapacidad = $ficha->discapacidad;
	if (isset($ficha->nomdiscapacidad))  $detalle_discap = $ficha->nomdiscapacidad;
	if (isset($ficha->lenguaorig))  $lengua = $ficha->lenguaorig;
	if (isset($ficha->aniosecundaria))  $aniosec = $ficha->aniosecundaria;
	if (isset($ficha->publicidad))  $dtpublicidad = $ficha->publicidad;

	if (isset($ficha->codepartamento2))  $departamcol = $ficha->codepartamento2;
	if (isset($ficha->codprovincia2))  $provinciacol = $ficha->codprovincia2;
	if (isset($ficha->distritosecund))  $distritocol = $ficha->distritosecund;
	if (isset($ficha->tiposecund))  $coltiposec = $ficha->tiposecund;

	if (isset($ficha->extrasecund))  $extranjsecu = $ficha->extrasecund;
	if (isset($ficha->direccextra))  $dirextrasecu = $ficha->direccextra;
	if (isset($ficha->codpais))  $vpais = $ficha->codpais;

	$arraypublic = array();
	if ($dtpublicidad != "" OR $dtpublicidad != null) {
		$arraypublic = explode(",", $dtpublicidad);
	}

	function obtienecheck($array, $valor)
	{
		if (count($array)> 0) {
			for ($i = 0; $i < count($array); $i++) {
		        if ($array[$i] == $valor) {
		            return $array[$i];
		        }
		    }
		}
	}

?>
<!-- /.navbar -->
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/preinscripcion.css">
<script src="<?php echo $vbaseurl ?>resources/plugins/inputmask/jquery.inputmask.min.js"></script>
		<?php echo
		"<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
<div class="content-wrapper ">
<style type="text/css">
	.text-iesap {
		color: #ac1a25!important;
	}
</style>
	<!-- /.content-header -->
	<!-- Main content -->
	<div class="content">
		<div class="container">
			<div class="row">
				
				<div class="col-12 pt-2 ">
					<div class="card" id="divcard_prematricula">
						
						<div class="card-body px-4">
							<div id="divcard_frm_pre">
								<form id="form_prematricula" action="<?php echo $vbaseurl ?>prematricula/fn_insert" method="post" accept-charset="utf-8">
									<input type="hidden" name="fictxtcodigo_pre" id="fictxtcodigo_pre" value="<?php echo $codigo ?>">
									<div class="row">
										<div class="col-md-9">
											
											<h2 class="title-seccion text-iesap"><i class="fas fa-graduation-cap mr-1"></i> Ficha de inscripción</h2>
											<div class="row my-4">
												<div class="form-group col-md-5">
													<label class="m-0" for="txt_periodo">Periodo:</label>
													<select name="txt_periodo" id="txt_periodo" class="form-control-plaintext border-bottom">
														
														<?php
														foreach ($periodos as $per) {
															$selper = ($per->codigo == $periodo) ? "selected" : "";
														echo '<option '.$selper.' value="'.$per->codigo.'">'.$per->nombre.'</option>';
														}
														?>
													</select>
												</div>
											</div>
											<div class="row my-4">
												<div class="form-group col-md-5">
													<label class="m-0" for="txt_sede">Sede:</label>
													<select name="txt_sede" id="txt_sede" class="form-control-plaintext border-bottom" data-dvcarga='divcard_datos'>
														<option value="">Seleccione sede</option>
														<?php
														foreach ($sedes as $sed) {
															$selsed = ($sed->id == $sede) ? "selected" : "";
														echo '<option '.$selsed.' value="'.$sed->id.'">'.$sed->nombre.'</option>';
														}
														?>
													</select>
												</div>
												<div class="form-group col-md-7">
													<label class="m-0" for="cbocarrera">Programa de estudios:</label>
													<select name="cbocarrera" id="cbocarrera" class="form-control-plaintext border-bottom">
														<option value="">Seleccione programa</option>
														
													</select>
												</div>
											</div>
											<div class="row my-4">
												<div class="form-group col-md-6">
													<label class="m-0" for="txt_modalidad">Modalidad:</label>
													<select name="txt_modalidad" id="txt_modalidad" class="form-control-plaintext border-bottom">
														<option value="">Elige la modalidad</option>
														<?php
														foreach ($modalidad as $mod) {
															$selmod = ($mod->id == $modalidades) ? "selected" : "";
														echo '<option '.$selmod.' value="'.$mod->id.'">'.$mod->nombre.'</option>';
														}
														?>
													</select>
												</div>
												<div class="form-group col-md-3 d-none" id="divcard_ciclo">
													<label class="m-0" for="txt_ciclo">Ciclo:</label>
													<select name="txt_ciclo" id="txt_ciclo" class="form-control-plaintext border-bottom">
														<option value="">Elige ciclo</option>
														<?php
														foreach ($ciclo as $cic) {
															$selcic = ($cic->id == $ciclopr) ? "selected" : "";
														echo '<option '.$selcic.' value="'.$cic->id.'">'.$cic->nombre.'</option>';
														}
														?>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label class="m-0" for="txt_turno">Turno:</label>
													<select name="txt_turno" id="txt_turno" class="form-control-plaintext border-bottom">
														<option value="">Elige turno</option>
														<?php
														foreach ($turnos as $trn) {
															$seltur = ($trn->codigo == $turno) ? "selected" : "";
														echo '<option '.$seltur.' value="'.$trn->codigo.'">'.$trn->nombre.'</option>';
														}
														?>
													</select>
												</div>
											</div>
											<h2 class="title-seccion text-iesap"><i class="fas fa-user-check mr-1"></i> Acerca de ti</h2>
											<div class="row my-4">
												<div class="form-group col-md-3">
													<label class="m-0" for="txt_tpdoc">Tipo: Documento</label>
													<select name="txt_tpdoc" id="txt_tpdoc" class="form-control-plaintext border-bottom">
														<option value="">Elige tu tipo de doc.</option>
														<option <?php echo ($tipodoc == "CEX") ? "selected" : ""; ?> value="CEX">Carnet de extranjería</option>
														<option <?php echo ($tipodoc == "DNI") ? "selected" : ""; ?> value="DNI">DNI</option>
														<!-- <option <?php //echo ($tipodoc == "PSP") ? "selected" : ""; ?> value="PSP">Pasaporte</option> -->
													</select>
												</div>
												<div class="form-group col-md-3">
													<label class="m-0" for="txtdni">N°: Documento</label>
													<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" id="txtdni" name="txtdni"   value="<?php echo $nrodocum ?>">
												</div>
											</div>
											<div class="row mb-3 d-none" id="divcardinstituto">
												<div class="form-group col-md-12">
													<label class="m-0" for="txt_inst_traslado">Instituto: de Traslado</label>
													<input class="form-control-plaintext border-bottom" type="text" name="txt_inst_traslado" id="txt_inst_traslado" placeholder="Instituto de Traslado" value="<?php echo $traslado ?>">
												</div>
											</div>
											
											<div class="row my-4">
												<div class="form-group col-md-4">
													<label class="m-0" for="txtape_paterno">Apellido Paterno:</label>
													<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtape_paterno" id="txtape_paterno"  value="<?php echo $apepaterno ?>">
												</div>
												<div class="form-group col-md-4">
													<label class="m-0" for="txtape_materno">Apellido Materno:</label>
													<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtape_materno" id="txtape_materno"   value="<?php echo $apematerno ?>">
												</div>
												<div class="form-group col-md-4">
													<label class="m-0" for="txtnombres">Nombres:</label>
													<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtnombres" id="txtnombres"   value="<?php echo $nombres ?>">
												</div>
											</div>
											
											<div class="row mb-3">
												
												<div class="form-group col-md-3">
													<label class="m-0" for="txt_genero">Género:</label>
													<select name="txt_genero" id="txt_genero" class="form-control-plaintext border-bottom">
														<option value="">Selecciona tu género</option>
														<option <?php echo ($genero == "MASCULINO") ? "selected" : ""; ?> value="MASCULINO">Masculino</option>
														<option <?php echo ($genero == "FEMENINO") ? "selected" : ""; ?> value="FEMENINO">Femenino</option>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label class="m-0" for="txtestcivil">Estado Civil:</label>
													<select name="txtestcivil" id="txtestcivil" class="form-control-plaintext border-bottom">
														<option value="">Selecciona estado civil</option>
														<option <?php echo ($estadociv == "SOLTERO") ? "selected" : ""; ?> value="SOLTERO">SOLTERO(A)</option>
														<option <?php echo ($estadociv == "CASADO") ? "selected" : ""; ?> value="CASADO">CASADO(A)</option>
														<option <?php echo ($estadociv == "VIUDO") ? "selected" : ""; ?> value="VIUDO">VIUDO(A)</option>
														<option <?php echo ($estadociv == "DIVORCIADO") ? "selected" : ""; ?> value="DIVORCIADO">DIVORCIADO(A)</option>
														<option <?php echo ($estadociv == "CONVIVIENTE") ? "selected" : ""; ?> value="CONVIVIENTE">CONVIVIENTE</option>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label class="m-0" for="cbtrabaja">Trabaja:</label>
													<select name="cbtrabaja" id="cbtrabaja" class="form-control-plaintext border-bottom">
														
														<option <?php echo ($trabaja == "NO") ? "selected" : ""; ?> value="NO">NO</option>
														<option <?php echo ($trabaja == "SI") ? "selected" : ""; ?> value="SI">SI</option>
													</select>
												</div>

												<div class="form-group col-md-3 d-none" id="divcard_empresa">
													<label class="m-0" for="txtlugtrabajo">Empresa /Institución donde labora:</label>
													<input class="form-control-plaintext border-bottom" type="text" name="txtlugtrabajo" id="txtlugtrabajo" value="<?php echo $lugtrabaja ?>">
												</div>
											</div>
											<div class="row mb-3">
												
											</div>
											<div class="row mb-3">
												<div class="form-group col-md-4">
													<label class="m-0" for="cbodispacacidad">¿Tiene: alguna discapacidad?</label>
													<select name="cbodispacacidad" id="cbodispacacidad" class="form-control-plaintext border-bottom">
														
														<option <?php echo ($discapacidad == "NO") ? "selected" : ""; ?> value="NO">NO</option>
														<option <?php echo ($discapacidad == "SI") ? "selected" : ""; ?> value="SI">SI</option>
													</select>
												</div>

												<div class="form-group col-md-8 d-none" id="divcard_detdiscap">
													<label class="m-0" for="txtdetadiscapac">Especificar: ¿Cúal es su discapacidad?</label>
													<input class="form-control-plaintext border-bottom" type="text" name="txtdetadiscapac" id="txtdetadiscapac" value="<?php echo $detalle_discap ?>">
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<img src="<?php echo $vbaseurl ?>resources/img/estudiante.png" alt="student" class="img-fluid mt-5 d-none d-md-block">
										</div>
										<div class="col-12">
											<div class="row mb-3 mt-2">
												<div class="form-group col-md-3">
													<label class="m-0" for="txt_fecnac">Fecha Nacimiento:</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" id="txt_fecnac" name="txt_fecnac" maxlength="10"  value="<?php echo $fechanac ?>">
												</div>
												<div class="form-group col-md-3">
													<label class="m-0" for="txtlugnac">Lugar de Nacimiento:</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtlugnac" id="txtlugnac"  value="<?php echo $lugarnac ?>">
												</div>
												<div class="form-group col-12  col-sm-3">
													<label class="m-0" for="ficbpais"> Pais de origen</label>
													<select data-currentvalue='' class="form-control-plaintext border-bottom" id="ficbpais" name="ficbpais" >
														<option value="0">Selecciona Pais</option>
														<?php foreach ($paises as $key => $ps) {?>
														<option <?php echo ($vpais == $ps->codigo) ? "selected" : ""; ?> value="<?php echo $ps->codigo ?>"><?php echo $ps->nombre ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label class="m-0" for="txtlenguaorig">Lengua Originaria:</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtlenguaorig" id="txtlenguaorig"  value="<?php echo $lengua ?>">
												</div>

												<div class="form-group col-md-4">
													<label class="m-0" for="txttelefono">Telefono/Celular:</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txttelefono" id="txttelefono"  value="<?php echo $telefono ?>">
												</div>
												<div class="form-group col-md-8">
													<label class="m-0" for="txtcorreo">Correo electrónico:</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="email" name="txtcorreo" id="txtcorreo" value="<?php echo $correoper ?>">
												</div>

												<div class="form-group col-md-6">
													<label class="m-0" for="txtapenompa">Apellidos y nombres (Padre)</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtapenompa" id="txtapenompa" value="<?php echo $apenompadre ?>">
												</div>

												<div class="form-group col-md-6">
													<label class="m-0" for="txtocupadre">Ocupación (Padre)</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtocupadre" id="txtocupadre"  value="<?php echo $ocupapadre ?>">
												</div>

												<div class="form-group col-md-6">
													<label class="m-0" for="txtapenomma">Apellidos y nombres (Madre)</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtapenomma" id="txtapenomma" value="<?php echo $apenommadre ?>">
												</div>

												<div class="form-group col-md-6">
													<label class="m-0" for="txtocumadre">Ocupación (Madre)</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtocumadre" id="txtocumadre"  value="<?php echo $ocupamadre ?>">
												</div>
												
											</div>
											<h2 class="title-seccion text-iesap"><i class="fas fa-map-marker-alt mr-1"></i> ¿Donde Vives?</h2>
											<div class="row mb-3 mt-2">
												<div class="form-group col-md-4">
													<input type="hidden" id="txtnomdepart" name="txtnomdepart">
													<label class="m-0" for="txt_departamento">Departamento:</label>
													<select onchange='fn_combo_ubigeo($(this));' name="txt_departamento" id="txt_departamento" class="form-control-plaintext border-bottom" data-tubigeo='departamento' data-cbprovincia='txt_provincia' data-cbdistrito='txt_distrito' data-dvcarga='divcard_data'>
														<option value="">Seleccione departamento</option>
														<?php
															foreach ($departamentos as $key => $dep) {
																$seldepart = ($dep->codigo == $departam) ? "selected" : "";
																echo '<option '.$seldepart.' value="'.$dep->codigo.'">'.$dep->nombre.'</option>';
															}
														?>
													</select>
												</div>

												<div class="form-group col-md-4">
													<input type="hidden" id="txtnomprovin" name="txtnomprovin">
													<label class="m-0" for="txt_provincia">Provincia:</label>
													<select onchange='fn_combo_ubigeo($(this));' name="txt_provincia" id="txt_provincia" class="form-control-plaintext border-bottom" data-tubigeo='provincia' data-cbdistrito='txt_distrito' data-dvcarga='divcard_data'>
														<option value="">Seleccione provincia</option>}
													</select>
												</div>

												<div class="form-group col-md-4">
													<input type="hidden" id="txtnomdistrito" name="txtnomdistrito">
													<label class="m-0" for="txt_distrito">Distrito:</label>
													<select onchange='fn_combo_ubigeo($(this));' name="txt_distrito" id="txt_distrito" class="form-control-plaintext border-bottom" data-tubigeo='distrito'>
														<option value="">Seleccione distrito</option>}
													</select>
												</div>
												
												<div class="form-group col-md-12">
													<label class="m-0" for="txt_direccion">Dirección:</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txt_direccion" id="txt_direccion"  value="<?php echo $direccion ?>">
												</div>
											</div>

											<h2 class="title-seccion text-iesap"><i class="fas fa-school mr-1"></i> ¿Donde estudiaste 5to de Secundaria?</h2>
											<div class="row my-4">
												<div class="form-group col-md-7">
													<label class="m-0" for="txt_centroestud">Último Colegio donde estudiaste 5to de Secundaria:</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txt_centroestud" id="txt_centroestud" value="<?php echo $colegio ?>">
												</div>
												<div class="form-group col-md-3">
													<label class="m-0" for="cbotipocolsec">Tipo colegio</label>
													<select name="cbotipocolsec" id="cbotipocolsec" class="form-control-plaintext border-bottom">
														<option value="0">Selecciona</option>
														<option <?php echo ($coltiposec == "CEBA") ? "selected" : ""; ?> value="CEBA">Educación Básica Alternativa (CEBA)</option>
														<option <?php echo ($coltiposec == "EBR") ? "selected" : ""; ?> value="EBR">Educación Básica Regular (EBR)</option>
													</select>
												</div>
												<div class="form-group col-md-2">
													<label class="m-0" for="txt_colsecuanio">Año que culminó:</label>
													<input autocomplete="off" class="form-control-plaintext border-bottom" type="number" name="txt_colsecuanio" id="txt_colsecuanio" value="<?php echo $aniosec ?>">
												</div>

												<div class="form-group col-12">
													<div class="checkbox">
								                      	<label>
								                        	<input <?php echo ($extranjsecu == "SI") ? "checked" : ""; ?> type="checkbox" id="check_extranjero"> Si culminó sus estudios secundarios en el extranjero, marque esta casilla
								                      	</label>
								                    </div>
												</div>
												<div class="form-group has-float-label col-12 col-sm-12 <?php echo ($extranjsecu == "SI") ? '' : 'd-none'; ?>" id="divcard_extranjero">
													<label for="fitxtdireccion_extranjero">Ingrese la dirección de su Institución (Detalle País, Estado, provincia o ciudad)</label>
													<input autocomplete='off' class="form-control-plaintext border-bottom" id="fitxtdireccion_extranjero" name="fitxtdireccion_extranjero" type="text" value="<?php echo $dirextrasecu ?>" />
												</div>
											</div>
											<div class="row <?php echo ($extranjsecu == "SI") ? 'd-none' : ''; ?>" id="divcard_ubigeocolegio">
												<div class="form-group col-md-4">
													<input type="hidden" id="txtnomdepart_col" name="txtnomdepart_col">
													<label class="m-0" for="txt_departamento_col">Departamento:</label>
													<select onchange='fn_combo_ubigeo($(this));' name="txt_departamento_col" id="txt_departamento_col" class="form-control-plaintext border-bottom" data-tubigeo='departamento' data-cbprovincia='txt_provincia_col' data-cbdistrito='txt_distrito_col' data-dvcarga='divcard_data'>
														<option value="0">Seleccione departamento</option>
														<?php
															foreach ($departamentos as $key => $dep) {
																$seldepart = ($dep->codigo == $departamcol) ? "selected" : "";
																echo '<option '.$seldepart.' value="'.$dep->codigo.'">'.$dep->nombre.'</option>';
															}
														?>
													</select>
												</div>

												<div class="form-group col-md-4">
													<input type="hidden" id="txtnomprovin_col" name="txtnomprovin_col">
													<label class="m-0" for="txt_provincia_col">Provincia:</label>
													<select onchange='fn_combo_ubigeo($(this));' name="txt_provincia_col" id="txt_provincia_col" class="form-control-plaintext border-bottom" data-tubigeo='provincia' data-cbdistrito='txt_distrito_col' data-dvcarga='divcard_data'>
														<option value="0">Seleccione provincia</option>}
													</select>
												</div>

												<div class="form-group col-md-4">
													<input type="hidden" id="txtnomdistrito_col" name="txtnomdistrito_col">
													<label class="m-0" for="txt_distrito_col">Distrito:</label>
													<select onchange='fn_combo_ubigeo($(this));' name="txt_distrito_col" id="txt_distrito_col" class="form-control-plaintext border-bottom" data-tubigeo='distrito'>
														<option value="0">Seleccione distrito</option>}
													</select>
												</div>
											</div>

											<div class="col-12" id="divcard_publicidad">
												<h4 class="title-seccion text-iesap">¿Como se enteró de nuestros programas?</h4>
												<div class="row ml-3">
													<?php
														$nro = 0;
														foreach ($publicidad as $key => $pb) {
															$nro ++;
													?>
													<div class="col-12 divcheck">
														<div class="custom-control custom-switch">
														  	<input type="checkbox" <?php echo (obtienecheck($arraypublic, $pb->codigo) == $pb->codigo) ? "checked": "" ?> class="custom-control-input checkpublicidad" id="checkpub<?php echo $nro ?>" data-codigo="<?php echo $pb->codigo ?>">
														  	<label class="custom-control-label" for="checkpub<?php echo $nro ?>"><?php echo $pb->nombre ?></label>
														</div>
													</div>
													<?php
														}
													?>
													
												</div>
											</div>
											
											<section id="vw_mpae_sec_adjuntar">
												<h2 class="title-seccion text-iesap"><i class="fas fa-paperclip mr-1"></i> Adjuntar Documentos</h2>
												<div class="row">
													
													<div class="col-lg-12">
														<div class="row">
															<div class="col-md-4">
																<h4>Requisitos</h4>
																<ul>
																	<li>Partida de Nacimiento</li>
																	<li>Certificado original de Secundaria</li>
																	<li>02 fotos</li>
																	<li>Copia de DNI</li>
																	<li>Voucher de pago del Derecho de Inscripción</li>
																</ul>
															</div>
															<div class="col-md-5 mb-2">
																<label for="vw_mpc_txt_titulo">Paso 1: Describe el archivo antes de adjuntarlo.</label>
																<input type="text" autocomplete="off" name="vw_mpc_txt_titulo" id="vw_mpc_txt_titulo" class="form-control" maxlength="200" autocomplete="off" >
															</div>
															<div class="col-md-3">
																<label class="d-block ">Paso 2: Adjunta el archivo</label>
																<button id="vw_mpc_btn_selecionar" role="button" class="btn btn-info"><i class="fas fa-paperclip mr-1"></i>
																Seleccionar archivo
																</button>
																<small class="d-block pt-2" id="vw_mpc_txt_filename"></small>
																<input type="file" class="form-control" name="vw_mpc_file" id="vw_mpc_file">
															</div>
															
														</div>
														<div class="row">
															<div class="col-12">
																<div id="vw_mpc_txt_progress"></div>
																<div id="vw_mpc_txt_size"></div>
																<div id="vw_mpc_txt_type"></div>
																<div id="vw_mpc_pgBar"></div>
															</div>
															<div class="col-12">
																<b>(Se permite adjuntar hasta 10 archivos, de 1 en 1, con un máximo de 10 Mb por cada uno) <br>
																* Solo se permiten los siguientes tipos de archivo: pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,txt.</b>
															</div>
														</div>
													</div>
													
													<div id="divcard_items" class="col-12"></div>
												</div>
												<div class="row text-bold border-bottom">
													<div class="col-5">
														Archivo
													</div>
													<div class="col-2">
														Tamaño
													</div>
													<div class="col-5">
														Descripción
													</div>
												</div>
												<div class="clearfix"></div>
												<div id="vw_mpc_lista">
													<?php 
													if ($codigo != "0") {
														foreach ($adjuntos as $key => $varch) {
															$pesoadj = number_format($varch->peso, 0);
															$codfile = base64url_encode($varch->codigo);
														echo "<div class='row border-bottom rowcolor p-2'>
				                								<div class='col-5'>$varch->archivo</div>
				                								<div class='col-2'>$pesoadj kb</div>
				                								<div class='col-5'>
				                									$varch->titulo
				                									<a href='#' class='float-right' data-link='$varch->link' data-codfile='$codfile' onclick='vw_mpa_fn_delfile($(this));event.preventDefault();' >
				                										<i class='far fa-trash-alt'></i>
				                									</a>
				                								</div>
				                							</div>";
				                						}
													}
													?>
													
												</div>
												<div class="row mt-3">
													<div class="col-12 text-danger" >
														<small id="div_msjerror">
														
														</small>
													</div>
												</div>
												
												
											</section>
											
											
										</div>
										
										
									</div>
									<div class="row mt-3">
										<?php 
											if ($codigo !== "0"){ 
												$classcolum = "col-md-6 col-6";
										?>
										<div class="<?php echo $classcolum ?>">
											<small class="form-text text-muted">
												Para cancelar la actualización presiona el boton "Cancelar"
											</small>
											<button type="button" class="btn btn-danger btn-flat float-left btn-lg" id="btn_updatecancel"><i class="fa fa-times"></i> Cancelar</button>
										</div>
										<?php } else {
											$classcolum = "col-md-12 col-12";
										} ?>
										<div class="<?php echo $classcolum ?> text-right">
											<small class="form-text text-muted">
											Para finalizar tu ficha presiona el boton "Inscribirme"
											</small>
											<button type="submit" class="btn btn-primary btn-flat float-right btn-lg"><i class="fa fa-save"></i> Inscribirme</button>
										</div>
									</div>
								</form>
							</div>
							<div id="divcard_rpta" class="text-center p-5">
								<div class="border border-dark py-4">
									<span class="h5"><i class="far fa-check-circle text-success"></i> Datos enviados correctamente</span><br><br>
					                <div class="row justify-content-center mt-2">
					                    <div class="col-11 col-md-4">
					                        <a id="vw_preins_btn_download" target="_blank" class="btn btn-primary d-block" href="#">
					                            <i class="far fa-file-pdf mr-1"></i> Descargar Constancia (Pdf)
					                        </a>
					                    </div>
					                </div>
					                <div class="row justify-content-center mt-2" id="divcardemail">
					                    <div class="col-11 col-md-4">
					                        <a id="vw_preins_btn_send_email" class="btn btn-success d-block" href="#" data-codigo="">
					                            <i class="fas fa-at mr-1"></i> Enviar constancia a mi Correo (<span id="emailenvia"></span>)
					                        </a>
					                    </div>
					                </div>
					               
					                <div class="row justify-content-center mt-2">
					                    <div class="col-11 col-md-4">
					                    	<?php
					                    		$regresa = '';
					                    		if (isset($_SESSION['userActivo']) && $_SESSION['userActivo']) {
					                    			$regresa = base_url().'admision/pre-inscripcion';
					                    		} else {
					                    			$regresa = base_url().'pre-inscripcion';
					                    		}
					                    	?>
					                        <a id="vw_preins_btn_regresar" class="btn btn-secondary d-block" href="<?php echo $regresa ?>">
					                            Volver
					                        </a>
					                    </div>
					                </div>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	$(document).ready(function() {
		$("#vw_mpc_file").hide();
	    $("#vw_mpc_txt_size").hide();
	    $("#vw_mpc_txt_type").hide();
	    $("#txt_fecnac").inputmask("99/99/9999", {
	        "placeholder": "dd/mm/yyyy"
	    });

		$('#txt_sede').change();
		$('#divcard_rpta').hide();
		$('#divcardemail').hide();
		if ('<?php echo $codigo ?>' != "0") {

			$('#divcard_prematricula').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

			setTimeout(function() {
		        $('#cbocarrera').val('<?php echo $carrera ?>');
		        $('#divcard_prematricula #divoverlay').remove();
		    },1000);

			$('#txt_provincia').html("<?php echo $dprovincias ?>");
			$('#txt_provincia').val('<?php echo $provincia ?>');
		    
		    $('#txt_distrito').html("<?php echo $ddistritos ?>");
	        $('#txt_distrito').val('<?php echo $distrito ?>');
	        $('#txtnomdistrito').val($('select[name="txt_distrito"] option:selected').text());
	        $('#txtnomprovin').val($('select[name="txt_provincia"] option:selected').text());
	        $('#txtnomdepart').val($('select[name="txt_departamento"] option:selected').text());

	        $('#txt_provincia_col').html("<?php echo $dprovinciascol ?>");
			$('#txt_provincia_col').val('<?php echo $provinciacol ?>');

			$('#txt_distrito_col').html("<?php echo $ddistritoscol ?>");
	        $('#txt_distrito_col').val('<?php echo $distritocol ?>');

		    $('#txt_modalidad').change();
		    $('#cbtrabaja').change();
		    $('#cbodispacacidad').change();

		    var vadjuntos = <?php echo json_encode($adjuntos, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
		    if (vadjuntos.length !== 0) {
		    	
		        $.each(vadjuntos, function(index, val) {
		        	var newarchivo = [val['link'], val['archivo'], val['peso'], val['tipo'], val['titulo']];
		        	arrayarchivos.push(newarchivo);
		        });
		    }	        
		}
	});

	$('#btn_updatecancel').click(function() {
		window.location = base_url +"admision/pre-inscripcion";
	});

	$('#txt_sede').change(function(){
		var combo = $(this);
		var idsede = combo.val();
		var nmdiv=combo.data('dvcarga');
		$.ajax({
            url: base_url + 'prematricula/fn_carreras_sedes',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodigosed: idsede
            },
            success: function(e) {
                $('#' + nmdiv + ' #divoverlay').remove();
                $('#form_prematricula #cbocarrera').html(e.vdata);
            },
            error: function(jqXHR, exception) {
                $('#' + nmdiv + ' #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#form_prematricula #cbocarrera').html("<option value='0'>" + msgf + "</option>");
            }
        });
        return false;
	});

	$('#txt_modalidad').change(function(){
		var combo = $(this);
		var item = combo.val();
		if (item == "" || item == 1) {
			$('#divcard_ciclo').addClass('d-none');
			$("#txt_ciclo").prop("required",false);
			$('#divcardinstituto').addClass('d-none');
			$("#txt_inst_traslado").prop("required",false);
		} else if (item == 2) {
			$('#divcard_ciclo').removeClass('d-none');
			$("#txt_ciclo").prop("required",true);
			$('#divcardinstituto').removeClass('d-none');
			$("#txt_inst_traslado").prop("required",true);
			
			
		} else if (item == 3) {
			$('#divcard_ciclo').removeClass('d-none');
			$("#txt_ciclo").prop("required",true);
			$('#divcardinstituto').addClass('d-none');
			$("#txt_inst_traslado").prop("required",false);
		}
		
	});

	$('#cbtrabaja').change(function(){
		var combo = $(this);
		var item = combo.val();
		if (item =='SI') {
			$('#divcard_empresa').removeClass('d-none');
		} else {
			$('#divcard_empresa').addClass('d-none');
		}
	});

	$('#cbodispacacidad').change(function() {
		var combo = $(this);
		var item = combo.val();
		if (item =='SI') {
			$('#divcard_detdiscap').removeClass('d-none');
		} else {
			$('#divcard_detdiscap').addClass('d-none');
		}
	});

	function fn_combo_ubigeo(combo){
        if (combo.data('tubigeo') == "departamento") {
            var nmprov=combo.data('cbprovincia');
            var nmdist=combo.data('cbdistrito');
            var nmdiv=combo.data('dvcarga');
            $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $('#' + nmprov).html("<option value='0'>Sin opciones</option>");
            $('#form_prematricula #' + nmdist).html("<option value='0'>Sin opciones</option>");
            var coddepa = combo.val();
            
            if (coddepa == '0') return;
            $.ajax({
                url: base_url + 'ubigeo/fn_provincia_x_departamento',
                type: 'post',
                dataType: 'json',
                data: {
                    txtcoddepa: coddepa
                },
                success: function(e) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    $('#form_prematricula #' + nmprov).html(e.vdata);
                    $('#txtnomdepart').val($('select[name="txt_departamento"] option:selected').text());
                    
                },
                error: function(jqXHR, exception) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#form_prematricula #' + nmprov).html("<option value='0'>" + msgf + "</option>");
                }
            });
        } 
        else if (combo.data('tubigeo') == "provincia") {
            var nmdist=combo.data('cbdistrito');
            var nmdiv=combo.data('dvcarga');
            $('#' + nmdiv).append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $('#form_prematricula #' + nmdist).html("<option value='0'>Sin opciones</option>");
            var codprov = combo.val();
            if (codprov == '0') return;
            $.ajax({
                url: base_url + 'ubigeo/fn_distrito_x_provincia',
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodprov: codprov
                },
                success: function(e) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    $('#form_prematricula #' + nmdist).html(e.vdata);
                    $('#txtnomprovin').val($('select[name="txt_provincia"] option:selected').text());
                    
                },
                error: function(jqXHR, exception) {
                    $('#' + nmdiv + ' #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#form_prematricula #ficbdistrito').html("<option value='0'>" + msgf + "</option>");
                }
            });
        } 
        else if (combo.data('tubigeo') == "distrito") {
        	$('#txtnomdistrito').val($('select[name="txt_distrito"] option:selected').text());
        }
        return false;
    }

	$('#form_prematricula').submit(function() {
	    $('#form_prematricula input,select').removeClass('is-invalid');
	    $('#form_prematricula .invalid-feedback').remove();
	    $('#divcard_prematricula').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    var check_extranjero = ($('#check_extranjero').prop('checked') == true) ? 'SI' : 'NO';
	    var formData = new FormData($("#form_prematricula")[0]);
	    var arraypublic = [];
		var datospublic = "";
		$('#divcard_publicidad .divcheck .checkpublicidad').each(function() {
			var check = $(this);
			var idpub = "";
			if (check.prop('checked') == true) {
				var idpub = check.data('codigo');
			}

			if (idpub !== "") {
				var myvals = [idpub];
    			arraypublic.push(myvals);
    			datospublic = arraypublic.join(",");
			}
			
		})

	    formData.append('vw_mpc_archivos', JSON.stringify(arrayarchivos));
	    formData.append('vw_mpc_publicidad', datospublic);
	    formData.append('check_extranjero', check_extranjero);
	    $.ajax({
	        url: $(this).attr("action"),
	        type: "post",
	        dataType: 'json',
	        data: formData,
	        cache: false,
	        contentType: false,
	        processData: false,
	        success: function(e) {
	            $('#divcard_prematricula #divoverlay').remove();
	            if (e.status == false) {
	                msjinput = "<b>Datos Incompletos</b>" + "<br>";
	                $.each(e.errors, function(key, val) {
	                    msjinput = msjinput + val;
	                    $('#' + key).addClass('is-invalid');
	                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
	                    $('#' + key).focus();
	                });
	                $('#div_msjerror').html(msjinput)
	            } else {
	                
	                $('#divcard_frm_pre').hide();
	                $('#vw_preins_btn_download').attr('href', e.download);
	                
	                // $('#vw_preins_btn_regresar').attr('href', base_url +"admision/pre-inscripcion");
	                if (e.email !== "") {
	                	$('#divcardemail').show();
	                	$('#emailenvia').html(e.email);
	                	$('#vw_preins_btn_send_email').data('codigo',e.newid);
	                }
	                $('#divcard_rpta').show();
	                
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard_prematricula #divoverlay').remove();
	            Swal.fire({
	                title: "Error",
	                text: msgf,
	                icon: 'error',
	            })
	        }
	    });
	    return false;
	});

	var arrayarchivos = [];
	$('#vw_mpc_file').change(function() {
	    if (arrayarchivos.length >= 10) {
	        Swal.fire({
	            icon: 'error',
	            title: 'Límite de 10 archivos',
	            text: 'Solo se puede adjuntar como máximo 10 archivos',
	            backdrop: false,
	        });
	        return;
	    }
	    $('#vw_mpc_txt_titulo').removeClass('is-invalid');
	    $('.invalid-feedback').remove();

	    $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    $("#vw_mpc_file").simpleUpload(base_url + "prematricula/fn_upload_file_externo", {
	        allowedExts: ["jpg", "jpeg", "png", "txt", "pdf", "doc", "docx"],
	        //allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
	        maxFileSize: 10485760, //10MB in bytes
	        start: function(file) {
	            //upload started
	            $('#vw_mpc_txt_filename').html(file.name);
	            $('#vw_mpc_txt_size').html(file.size);
	            $('#vw_mpc_txt_type').html(file.type);
	            $('#vw_mpc_txt_progress').html("");
	            $('#vw_mpc_pgBar').width(0);
	            $('#vw_mpc_txt_progress').show();
	            $('#vw_mpc_pgBar').show();
	        },
	        progress: function(progress) {
	            //received progress
	            $('#vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
	            $('#vw_mpc_pgBar').width(progress + "%");
	        },
	        success: function(data) {
	            //upload successful
	            //$('#progress').html("Success!<br>Data: " + JSON.stringify(data));
	            $('#vw_mpc_txt_progress').hide();
	            $('#vw_mpc_pgBar').hide();
	            //AGREGAR ARCVO A LA LISTA
	            //i.link,i.name,i.size,i.type,i.fileid
	            $('#divcard-general #divoverlay').remove();
	            var newarchivo = [data.link, $('#vw_mpc_txt_filename').html(), $('#vw_mpc_txt_size').html(), $('#vw_mpc_txt_type').html(), $('#vw_mpc_txt_titulo').val()];
	            arrayarchivos.push(newarchivo);
	            " "
	            $('#vw_mpc_lista').append("<div class='row border-bottom rowcolor p-2'>" +
	                "<div class='col-5'> " + $('#vw_mpc_txt_filename').html() + "</div>" +
	                "<div class='col-2'> " + $('#vw_mpc_txt_size').html() + " kb</div>" +
	                "<div class='col-5'> " + $('#vw_mpc_txt_titulo').val() + "<a href='#' class='float-right' data-link='" + data.link + "' data-codfile='0' onclick='vw_mpa_fn_delfile($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a></div>");
	            $('#vw_mpc_txt_titulo').val("");
	            $('#vw_mpc_txt_filename').html("");
	            $('#vw_mpc_txt_titulo').focus();
	        },
	        error: function(error) {
	            //upload failed
	            switch (error.name) {
	                case 'InvalidFileExtensionError':
	                    vmsg = "Este tipo de archivo no es admitido";
	                    break;
	                case 'MaxFileSizeError':
	                    vmsg = "El peso máximo permitido es de 10MB";
	                    break;
	                default:
	                    vmsg = error.message;
	            }
	            Swal.fire({
	                icon: 'error',
	                title: "Error! " + error.name,
	                text: vmsg,
	                backdrop: false,
	            });
	            $('#vw_mpc_txt_filename').html("");
	            $('#vw_mpc_txt_size').html("");
	            $('#vw_mpc_txt_type').html("");
	            $('#divcard-general #divoverlay').remove();
	        }
	    });
	});

	function vw_mpa_fn_delfile(btn) {
	    var link = btn.data('link');
	    var codigo = btn.data('codfile');
	    var n = 0;
    	$.ajax({
            url: base_url + 'prematricula/fn_delete_file',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodigo: codigo,
                archivo:link
            },
            success: function(e) {
                if (e.status == true) {
                	const Toast = Swal.mixin({
			          	toast: true,
			          	position: 'top-end',
			          	showConfirmButton: false,
			          	timer: 5000,
			        })

					Toast.fire({
					  	icon: 'success',
					  	type: 'success',
					  	title: e.msg,
					})
                }
                
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard_prematricula #divoverlay').remove();
	            Swal.fire({
	                title: "Error",
	                text: msgf,
	                icon: 'error',
	            })
            }
        });

	    arrayarchivos.forEach(function(afile) {
	        if (afile[0] === link) {
	            arrayarchivos.splice(n, 1);
	            btn.closest('.rowcolor').remove();
	        }
	        n++;
	    });

	}

	$('#vw_mpc_btn_selecionar').click(function(event) {
	    event.preventDefault();
	    $("#vw_mpc_file").trigger('click');
	});

	$('#vw_preins_btn_send_email').click(function() {
	    var boton = $(this);
	    var codigo = boton.data('codigo');
	    
	    $('#divcard_prematricula').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    
	    $.ajax({
	        url: base_url + "prematricula/fn_enviar_constancia_preins_correo",
	        type: "post",
	        dataType: 'json',
	        data: 
	        {
	            "codigo":codigo
	        },
	        success: function(e) {
	            $('#divcard_prematricula #divoverlay').remove();
	            if (e.status == false) {
	                Swal.fire({
	                    title: "Error!",
	                    text:  "No se pudo enviar la constancia al correo",
	                    icon: 'error',
	                })
	            } else {
	                
	                Swal.fire({
	                    title: "Éxito!",
	                    text: e.msg,
	                    icon: 'success',
	                })
	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divcard_prematricula #divoverlay').remove();
	            Swal.fire({
	                title: "Error",
	                text: msgf,
	                icon: 'error',
	            })
	        }
	    });
	    return false;
	});

	$('#check_extranjero').change(function(e) {
	    var check = $(this);
	    if (check.prop('checked') == true) {
	        $('#divcard_extranjero').removeClass('d-none');
	        $('#divcard_ubigeocolegio').addClass('d-none');
	    } else {
	        $('#divcard_extranjero').addClass('d-none');
	        $('#divcard_ubigeocolegio').removeClass('d-none');
	    }
	});

	$("#txtdni").keyup(function(e) {

	    if (e.keyCode == 13) {
	        $("#txtdni").blur();
	    }
	});

	$("#txtdni").blur(function(e) {
	    fn_valida_reniec_admision($(this).val());
	});

	$('#txt_tpdoc').change(function(e) {
		var tipodocum = $(this).val();
		var nrodocumento = $("#txtdni").val();
		if ((tipodocum == "DNI") && (nrodocumento !== "")) {
			fn_valida_reniec_admision(nrodocumento);
		}
	})

	function fn_valida_reniec_admision(documento) {
		var dni = documento;
		console.log(dni);
		tipodoc = $('#txt_tpdoc').val();
		if ((tipodoc == "DNI") && (dni !== "")) {
			$('#divcard_prematricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	    	if ((dni.length!=8) || (!$.isNumeric(dni))){
	        	Swal.fire({
	        		type: 'error',
	        		title: "DNI incorrecto",
	        		text: "Un N° de DNI correcto presenta 8 números",
	        		backdrop:false,
	        	});
	        	$('#divcard_prematricula #divoverlay').remove();
	        	return;
	    	}
	    	$.ajax({
	        	data: {
	            	"dni": dni
	        	},
	        	type: "POST",
	        	dataType: "json",
	        	url: base_url +  "cnrnc/consulta_reniec.php",
	        	success: function(datos_dni) {
	                var datos = eval(datos_dni);
	                if (datos['status'] == true) {
	                    // $("#fitxtreniec").val(datos['paterno'] + ' ' + datos['materno'] + ' ' + datos['nombres']);
	                    // $("#fibtnaplica-reniec").attr('disabled', false);
	                    $('#txtape_paterno').val(datos['paterno']);
	                    $('#txtape_materno').val(datos['materno']);
	                    $('#txtnombres').val(datos['nombres']);
	                    // txtrnc = $("#fitxtreniec");
	                    // txtrnc.data('paterno', datos['paterno']);
	                    // txtrnc.data('materno', datos['materno']);
	                    // txtrnc.data('nombres', datos['nombres']);
	                } else {
	                    // $("#fitxtreniec").val(datos['msg']);
	                    // $("#fibtnaplica-reniec").attr('disabled', true);
	                    // txtrnc = $("#fitxtreniec");
	                    // txtrnc.data('paterno', '');
	                    // txtrnc.data('materno', '');
	                    // txtrnc.data('nombres', '');
	                    // $('#form_prematricula #txtape_paterno').focus();
	                }
	                $('#divcard_prematricula #divoverlay').remove();
	            },
	            error: function(jqXHR, exception) {
	                var msgf = errorAjax(jqXHR, exception, 'text');
	                Swal.fire({
	                    type: 'error',
	                    title: "No pudimos conectar a RENIEC, puedes registrar MANUALMENTE o comunícate con SOPORTE",
	                    text: msgf,
	                    backdrop:false,
	                });
	                $('#divcard_prematricula #divoverlay').remove();
	            }
	        });
		}
		
        return false;
	}
</script>

<!-- Main Footer -->

<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

