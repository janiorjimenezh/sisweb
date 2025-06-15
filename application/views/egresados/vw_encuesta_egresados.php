<?php
	$arraylimitaciones = array('Trastorno espectro autista', 'Visual - Baja visión','Visual - Ceguera','Auditiva-Hipoacusia','Auditiva-Sordera','Motora','Intelectual','Salud mental','Sordoceguera - Total','Sordoceguera-Parcial','Situación de hospitalización','Ninguna');
	$arrayrazonprinci = array('Los Programas de Estudios que se brindan, no se encuentran en otras Modalidades/Niveles 1 El IESAP son más accesibles (lejanía, costo o dificultad) que los estudios universitarios 2','El IESAP son más accesibles (lejanía, costo o dificultad) que los estudios universitarios','Se brindan Programas de Estudios más cortos','Los Programas de Estudios que se brindan se adaptan mejor a mis necesidades','Otros');
?>
<script src="<?php echo $vbaseurl ?>resources/plugins/inputmask/jquery.inputmask.min.js"></script>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/encuesta_egresados.css">
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-12 pt-2 ">
				<div class="card" id="divcard_encuesta">
					<div class="card-header">
						<span>
							<b>Objetivos:</b>
							<ul>
								<li>Perfilar a los egresados del IESAP.</li>
								<li>Analizar la trayectoria educativa de los egresados, características socioeconómicas.</li>
								<li>Conocer a que dedican los egresados la mayor parte de su tiempo (ocupación principal)</li>
								<li>Analizar la relación de la carrera tecnológica de los egresados y las empresas donde se encuentran laborando.</li>
								<li>Conocer la remuneración que perciben los egresados del IESAP.</li>
								<li>Analizar los diferentes medios que utilizan los egresados para la búsqueda de empleo.</li>
								<li>Conocer el grado de satisfacción con los recursos ofrecidos por el IESAP.</li>
							</ul>
								
						</span>
					</div>
					<div class="card-body px-4">
						<div id="divcard_frm_encuenta">
							<form id="frm_encuesta_egresados" action="<?php echo $vbaseurl ?>encuesta_egresados/fn_insert_encuesta" method="POST" role="form">
								<div class="tab">
									<h2 class="title-seccion text-iesap">DATOS DEMOGRÁFICOS.</h2>
									<div class="row my-4">
										<div class="form-group col-md-6">
											<label class="m-0" for="txtape_paterno">Apellidos y Nombres:</label>
											<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtape_paterno" id="txtape_paterno"  value="<?php //echo $apepaterno ?>">
										</div>
										<div class="form-group col-md-3">
											<label class="m-0" for="txt_tpdoc">Tipo: Documento</label>
											<select name="txt_tpdoc" id="txt_tpdoc" class="form-control-plaintext border-bottom">
												<option value="">Elige tu tipo de doc.</option>
												<option <?php //echo ($tipodoc == "CEX") ? "selected" : ""; ?> value="CEX">Carnet de extranjería</option>
												<option <?php //echo ($tipodoc == "DNI") ? "selected" : ""; ?> value="DNI">DNI</option>
												<!-- <option <?php //echo ($tipodoc == "PSP") ? "selected" : ""; ?> value="PSP">Pasaporte</option> -->
											</select>
										</div>
										<div class="form-group col-md-3">
											<label class="m-0" for="txtdni">N°: Documento</label>
											<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" id="txtdni" name="txtdni"   value="<?php //echo $nrodocum ?>">
										</div>
									</div>
									<div class="row my-4">
										<div class="form-group col-md-3">
											<label class="m-0" for="txt_fecnac">Fecha Nacimiento:</label>
											<input autocomplete="off" class="form-control-plaintext border-bottom" id="txt_fecnac" name="txt_fecnac" maxlength="10"  value="<?php //echo $fechanac ?>">
										</div>
										<div class="form-group col-md-6">
											<label class="m-0" for="txtlugnac">Lugar de nacimiento (Departamento y Distrito):</label>
											<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtlugnac" id="txtlugnac"  value="<?php //echo $lugarnac ?>">
										</div>
										<div class="form-group col-md-3">
											<label class="m-0" for="txt_genero">Género:</label>
											<select name="txt_genero" id="txt_genero" class="form-control-plaintext border-bottom">
												<option value="">Selecciona tu género</option>
												<option <?php //echo ($genero == "MASCULINO") ? "selected" : ""; ?> value="MASCULINO">Masculino</option>
												<option <?php //echo ($genero == "FEMENINO") ? "selected" : ""; ?> value="FEMENINO">Femenino</option>
											</select>
										</div>
									</div>
									<div class="row my-4">
										<div class="form-group col-md-3">
											<label class="m-0" for="txtlugresidencia">Lugar de residencia (Ubigeo):</label>
											<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtlugresidencia" id="txtlugresidencia"  value="<?php //echo $lugarnac ?>">
										</div>
										<div class="form-group col-md-3">
											<label class="m-0" for="txttelefono">Número Celular:</label>
											<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txttelefono" id="txttelefono"  value="<?php //echo $telefono ?>">
										</div>
										<div class="form-group col-md-3">
											<label class="m-0" for="txtcorreo">Correo electrónico:</label>
											<input autocomplete="off" class="form-control-plaintext border-bottom" type="email" name="txtcorreo" id="txtcorreo" value="<?php //echo $correoper ?>">
										</div>
										<div class="form-group col-md-3">
											<label class="m-0" for="txtrucegres">RUC:</label>
											<input autocomplete="off" class="form-control-plaintext border-bottom" type="text" name="txtrucegres" id="txtrucegres" value="<?php //echo $correoper ?>">
										</div>
									</div>
									<div class="row my-4">
										<div class="form-group col-md-3">
											<label class="m-0" for="txt_lengua_orig">¿Cuál es su lengua materna?</label>
											<select name="txt_lengua_orig" id="txt_lengua_orig" class="form-control-plaintext border-bottom">
												<option value="">Selecciona una opción</option>
												<?php
												foreach ($dlenguas as $key => $leng) {
													echo "<option value='$leng->codigo'>$leng->nombre</option>";
												}
												?>
											</select>
										</div>
										<div class="form-group col-md-3">
											<label class="m-0" for="txtestcivil">Estado Civil:</label>
											<select name="txtestcivil" id="txtestcivil" class="form-control-plaintext border-bottom">
												<option value="">Selecciona una opción</option>
												<option <?php //echo ($estadociv == "SOLTERO") ? "selected" : ""; ?> value="SOLTERO">SOLTERO(A)</option>
												<option <?php //echo ($estadociv == "CASADO/CONVIVIENTE") ? "selected" : ""; ?> value="CASADO/CONVIVIENTE">CASADO/CONVIVIENTE</option>
												<option <?php //echo ($estadociv == "SEPARADO") ? "selected" : ""; ?> value="SEPARADO">SEPARADO</option>
												<option <?php //echo ($estadociv == "DIVORCIADO") ? "selected" : ""; ?> value="DIVORCIADO">DIVORCIADO(A)</option>
												<option <?php //echo ($estadociv == "VIUDO") ? "selected" : ""; ?> value="VIUDO">VIUDO(A)</option>									
											</select>
										</div>
									</div>
									<div class="row my-3">
										<div class="form-group col-md-12">
											<h6 class="m-0">¿Cuál de las siguientes limitaciones tiene? (Puede marcar más de una alternativa)</h6>
											<?php
											$nro = 0;
											foreach ($arraylimitaciones as $key => $alimit) {
												$nro++;
												echo "<div class='col-12 divcheck'>
														<div class='custom-control custom-checkbox'>
														  	<input type='checkbox' class='custom-control-input checklimitaciones' id='checklimit{$nro}' data-limit='$alimit'>
														  	<label class='custom-control-label' for='checklimit{$nro}'>$alimit</label>
														</div>
													</div>";
											}
											?>

										</div>
										
									</div>
								</div>

								<div class="tab">
									<h2 class="title-seccion text-iesap">DATOS ACADÉMICOS.</h2>
									<div class="row my-4">
										<div class="form-group col-md-6">
											<label class="m-0" for="txtprograma_sigue">¿Cuál es el Programa de Estudios que siguió en el IESAP?</label>
											<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtprograma_sigue" id="txtprograma_sigue"  value="">
										</div>
										<div class="form-group col-md-6">
											<label class="m-0" for="txt_nivel_alcanzado">Con respecto al nivel alcanzado, ¿Usted actualmente se encuentra:</label>
											<select name="txt_nivel_alcanzado" id="txt_nivel_alcanzado" class="form-control-plaintext border-bottom">
												<option value="">Elige una opción.</option>
												<option value="Egresado">Egresado</option>
												<option value="Titulado">Titulado</option>
											</select>
										</div>
									</div>
									<div class="row my-4">
										<div class="form-group col-md-6">
											<label class="m-0" for="txtanio_egreso">Si marcaste en la pregunta anterior Egresado  ¿En qué año egreso?</label>
											<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtanio_egreso" id="txtanio_egreso"  value="">
										</div>
										<div class="form-group col-md-6">
											<label class="m-0" for="txtanio_titulado">Si marcaste en la pregunta anterior  Titulado ¿En qué año se Tituló?</label>
											<input type="text" autocomplete="off" class="form-control-plaintext border-bottom" name="txtanio_titulado" id="txtanio_titulado"  value="">
										</div>
									</div>
									<div class="row my-3">
										<div class="form-group col-md-12">
											<h6 class="m-0">¿Cuál de las siguientes limitaciones tiene? (Puede marcar más de una alternativa)</h6>
											<?php
											$nrorz = 0;
											foreach ($arrayrazonprinci as $key => $rzprn) {
												$nrorz++;
												echo "<div class='col-12 divcheck'>
														<div class='custom-control custom-checkbox'>
														  	<input type='checkbox' class='custom-control-input checkrazonpri' id='checkrznpn{$nrorz}' data-limit='$rzprn'>
														  	<label class='custom-control-label' for='checkrznpn{$nrorz}'>$rzprn</label>
														</div>
													</div>";
											}
											?>

										</div>
										
									</div>
								</div>
								

								<div style="overflow:auto;">
									<div class="float-left">
										<button type="button" id="prevBtn" onclick="nextPrev(-1)" class="btn btn-danger">
									    	<i class='fa fa-arrow-left'></i> 
									    	Atrás
									    </button>
									</div>
								  	<div class="float-right">
									    <button type="button" id="nextBtn" class="btn btn-primary" onclick="nextPrev(1)">
									    	Siguiente
										</button>
										<button type="submit" id="guarda_encuesta_egresado" class="btn btn-primary">
											Enviar <i class='fa fa-send'></i>
										</button>
								  	</div>
								</div>

								<div style="text-align:center;margin-top:40px;">
								  <span class="step"></span>
								  <span class="step"></span>
								  <span class="step"></span>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
	    $("#txt_fecnac").inputmask("99/99/9999", {
	        "placeholder": "dd/mm/yyyy"
	    });
	})

	var currentTab = 0; // La pestaña actual está configurada para ser la primera pestaña (0)
	showTab(currentTab); // Mostrar la pestaña actual

	function showTab(n) {
	  // Esta función mostrará la pestaña especificada del formulario ...
	  var x = document.getElementsByClassName("tab");
	  x[n].style.display = "block";
	  // ... y fija los botones Anterior / Siguiente:
	  if (n == 0) {
	    document.getElementById("prevBtn").style.display = "none";
	  } else {
	    document.getElementById("prevBtn").style.display = "inline";
	  }

	  if (n == (x.length - 1)) {
	    
	    $("#nextBtn").addClass('d-none');
	    $("#guarda_encuesta_egresado").removeClass('d-none');
	  } else {
	    document.getElementById("nextBtn").innerHTML = "Siguiente <i class='fa fa-arrow-right'></i>";
	    $("#nextBtn").removeClass('d-none');
	    $("#guarda_encuesta_egresado").addClass('d-none');
	  }
	  
	  // ... y ejecuta una función que muestra el indicador de paso correcto:
	  fixStepIndicator(n)
	}

	function nextPrev(n) {
	  // Esta función determinará qué pestaña mostrar
	  var x = document.getElementsByClassName("tab");
	  // Salga de la función si algún campo en la pestaña actual no es válido:
	  if (n == 1 && !validateForm()) return false;
	  // Ocultar la pestaña actual:
	  x[currentTab].style.display = "none";
	  // Aumenta o disminuye la pestaña actual en 1:
	  currentTab = currentTab + n;

	  // si ha llegado al final del formulario... :
	  // if (currentTab >= x.length) {
	  //   //...el formulario se envía:
	  //   $("#regForm").submit();
	  //   return false;

	  // }

	  // De lo contrario, muestre la pestaña correcta:
	  showTab(currentTab);
	  
	}

	function validateForm() {
	  // Esta función se ocupa de la validación de los campos del formulario.
	  var x, y, i, valid = true;
	  x = document.getElementsByClassName("tab");
	  y = x[currentTab].getElementsByTagName("input");
	  s = x[currentTab].getElementsByTagName("select");
	  // Un bucle que verifica cada campo de entrada en la pestaña actual:
	  for (i = 0; i < y.length; i++) {
	    // Si un campo está vacío...
	    if (y[i].value == "") {
	      // agregar una clase "inválida" al campo:
	      y[i].className += " is-invalid";
	      if (y[i].type == "hidden") {
	        $('.smgalert').parent().append(`<p class="invalid-desc">*campo requerido</p>`)
	      }
	      // y establecer el estado válido actual en falso:
	      valid = false;
	    }
	  }

	  for (f = 0; f < s.length; f++) {
	    // Si un campo está vacío...
	    if (s[f].value == "") {
	      // agregar una clase "inválida" al campo:
	      s[f].className += " is-invalid";
	      // y establecer el estado válido actual en falso:
	      valid = false;
	    }
	  }
	  // Si el estado válido es verdadero, marque el paso como terminado y válido:
	  if (valid) {
	    document.getElementsByClassName("step")[currentTab].className += " finish";
	  }
	  return valid; // devolver el estado válido
	}

	function fixStepIndicator(n) {
	  // Esta función elimina la clase "activa" de todos los pasos...
	  var i, x = document.getElementsByClassName("step");
	  for (i = 0; i < x.length; i++) {
	    x[i].className = x[i].className.replace(" active", "");
	  }
	  //... y agrega la clase "activa" al paso actual:
	  x[n].className += " active";
	}
</script>