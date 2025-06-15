<div class="modal fade" id="modMantFechaPago" tabindex="-1" role="dialog" aria-labelledby="modMantFechaPago" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" >
				Mantenimiento: Items en Fechas de pago
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<div id="div_cronogramaFechaMantenimiento">
					<form id="vw_cmda_frmcalendario" accept-charset="utf-8">
						
						<div class="col-md-12">
							<div class="row">
								<input type="hidden" id="vw_cmda_txtcodigo" name="vw_cmda_txtcodigo" value="">
								<input type="hidden" id="vw_cmda_txtcalendario" name="vw_cmda_txtcalendario" value="">
								<div class="form-group has-float-label col-6  col-md-12">
									<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_cmda_txtnombre" name="vw_cmda_txtnombre" type="text" placeholder="Nombre"  minlength="8" />
									<label for="vw_cmda_txtnombre">Nombre</label>
								</div>
								<div class="form-group has-float-label col-6  col-md-6">
									<input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_cmda_txtinicia" name="vw_cmda_txtinicia" type="date" placeholder="Fecha"  minlength="8" />
									<label for="vw_cmda_txtinicia">Fecha</label>
								</div>
								
								
							</div>
							<div class="row" id="vw_cmda_divItem">
									<div class="col-8">
										<div class="row">
											<div class="col-12">
												<label for="vw_cmdi_cbgestion">Gestión</label>
											</div>
											<div class="col-12">
												<select class="vw_select2 form-control form-control-sm" name="vw_cmdi_cbgestion" id="vw_cmdi_cbgestion" style="width: 100%">
													<option value='0'></option>";
													<?php
														$cat_group="";
														foreach ($gestion as $key => $gt) {
															if ($cat_group!=$gt->codcategoria){
																if ($cat_group!="") echo "</optgroup>";
																$cat_group=$gt->codcategoria;
																echo "<optgroup label='$gt->categoria'>";
															}
															echo "<option value='$gt->codgestion'>$gt->gestion</option>";
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-4">
										<div class="row">
											<div class="col-12">
												<label for="vw_cmdi_cbgestion">¿Aplicar descuento de pronto pago?</label>
											</div>
											<div class="col-12">
												<select class="vw_select2 form-control form-control-sm" name="vw_cmdi_cbprontopago" id="vw_cmdi_cbprontopago" style="width: 100%">
													<option value='SI'>SI</option>";
													<option value='NO'>NO</option>";											
												</select>
											</div>
										</div>
									</div>
								</div>
						</div>
					</form>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="vw_cmda_btnguardar" onclick='fn_vw_save_fecha($(this));' class="btn btn-primary float-right">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modMantFechaItemPago" tabindex="-1" role="dialog" aria-labelledby="modMantFechaItemPago" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" >
				Mantenimiento: Items de pago
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<div id="div_cronogramaFechaITemPago">
					<form id="vw_cmdip_frmFechaItemPagpo" accept-charset="utf-8">
						
						<div class="col-md-12">
							<div class="row">
								<input type="hidden" id="vw_cmdip_txtcodigo" name="vw_cmdip_txtcodigo" value="">
								<input type="hidden" id="vw_cmdip_txtcodfechaitem" name="vw_cmdip_txtcodfechaitem" value="">
								
								
								
			
								<div class="col-12">
									<label for="vw_cmdip_cbgestion">Gestión</label>
								</div>
								<div class="col-12" id="vw_cmda_divItem" >
									
										
										<select class="vw_select2 form-control form-control-sm" name="vw_cmdip_cbgestion" id="vw_cmdip_cbgestion" style="width: 100%">
											<option value='0'></option>";
											<?php
												$cat_group="";
												foreach ($gestion as $key => $gt) {
													if ($cat_group!=$gt->codcategoria){
														if ($cat_group!="") echo "</optgroup>";
														$cat_group=$gt->codcategoria;
														echo "<optgroup label='$gt->categoria'>";
													}
													echo "<option value='$gt->codgestion'>$gt->gestion</option>";
												}
											?>
										</select>
										
					
									
								</div>
							</div>
						</div>
					</form>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="vw_cmdip_btnguardar" onclick='fn_guardarFechaItem($(this));' class="btn btn-primary float-right">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	function fn_vw_agregar_fecha(btn) {

		$('#div_cronogramaFechaMantenimiento').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
	      var vcodPeriodo = $("#vw_cmd_codPeriodo").val();
	      var vcodCalendario64 = $("#vw_cmd_codCalendario64").val();
	      var vcodSede = $("#vw_cmd_codSede").val();

  		$("#modMantFechaPago .modal-title").html($("#modCronogramaDetalle .modal-title").html());
  		
        
        accion=btn.data("accion");
        vcodigo="0";
        if (accion=="editar"){
        	fila=btn.closest(".cfila")
            vcodigo=fila.data("codigo64");
            $("#vw_cmda_txtcodigo").val(vcodigo);
            $("#vw_cmda_txtcalendario").val(vcodCalendario64);
            $("#vw_cmda_txtnombre").val(fila.data("descripcion"));
            $("#vw_cmda_txtinicia").val(fila.data("fecha"));
            $("#vw_cmda_divItem").hide();
            
        }
        else{
            $("#vw_cmda_txtcodigo").val('0');
            $("#vw_cmda_txtcalendario").val(vcodCalendario64);
            $("#vw_cmda_txtnombre").val("");
            $("#vw_cmda_txtinicia").val("");
            $("#vw_cmda_divItem").show();
        }



      //$('#modGrupos_matriculados #vw_id_calendario_grp').val(vcodCalendario64);
      $("#modMantFechaPago").modal("show");
      $('#div_cronogramaFechaMantenimiento #divoverlay').remove();

  }

  function fn_vw_save_fecha(btn) {
    $('#div_cronogramas input,select').removeClass('is-invalid');
    $('#div_cronogramas .invalid-feedback').remove();
    $('#div_cronogramaFechaMantenimiento').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "deudas_calendario_fechas/fn_guardarFechaConItem",
        type: 'post',
        dataType: 'json',
        data: $('#vw_cmda_frmcalendario').serialize(),
        success: function(e) {
            $('#div_cronogramaFechaMantenimiento #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {

            	fnp_llenarDatatableFechas(e.vfechas);
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_cronogramaFechaMantenimiento #divoverlay').remove();
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

  function fn_guardarFechaItem(btn) {
    $('#div_cronogramas input,select').removeClass('is-invalid');
    $('#div_cronogramas .invalid-feedback').remove();
    $('#div_cronogramaFechaMantenimiento').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "deudas_calendario_fechas/fn_guardarFechaConItem",
        type: 'post',
        dataType: 'json',
        data: $('#vw_cmda_frmcalendario').serialize(),
        success: function(e) {
            $('#div_cronogramaFechaMantenimiento #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {

            	fnp_llenarDatatableFechas(e.vfechas);
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_cronogramaFechaMantenimiento #divoverlay').remove();
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


</script>