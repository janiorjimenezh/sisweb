<div class="modal fade" id="modMantDetalleItemPago" tabindex="-1" role="dialog" aria-labelledby="modMantDetalleItemPago" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content" id="div_cronogramaFechaITemPago">
            <div class="modal-header">
                <h5 class="modal-title" >
                Mantenimiento: Item detalle de pago
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div>
                    <form id="vw_cmdidp_frmFechaItemPagpo" accept-charset="utf-8">
                        <input type="hidden" id="vw_cmdidp_txtcambio" name="vw_cmdidp_txtcambio" value="">
                        <div class="col-md-12">
                            <div class="row">
                                <input type="hidden" id="vw_cmdidp_txtcodigo" name="vw_cmdidp_txtcodigo" value="">
                                <!-- <input type="hidden" id="vw_cmdidp_txtcodfechaitem" name="vw_cmdidp_txtcodfechaitem" value=""> -->
                                <div class="form-group has-float-label col-6  col-md-12">
                                    <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_cmdidp_txtfactcomo" name="vw_cmdidp_txtfactcomo" type="text" placeholder="Facturado como:"  minlength="8" />
                                    <label for="vw_cmdidp_txtfactcomo">Facturado como:</label>
                                </div>
            
                                <div class="col-12">
                                    <label for="vw_cmdidp_cbgestion">Gestión</label>
                                </div>
                                <div class="col-12" id="vw_cmdidp_divItem" >
                                    <select class="vw_cmdidp_select form-control form-control-sm" name="vw_cmdidp_cbgestion" id="vw_cmdidp_cbgestion" style="width: 100%">
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
                                <div class="col-12">
                                    <label for="vw_cmdidp_cbmatricula">Semestre</label>
                                </div>
                                <div class="col-12" id="vw_cmdidp_divItem" >
                                    <select class="vw_cmdidp_select form-control form-control-sm" name="vw_cmdidp_cbmatricula" id="vw_cmdidp_cbmatricula" style="width: 100%">
                                        <option value='0'></option>";
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="vw_cmdidp_btnguardar"  class="btn btn-primary float-right">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function vw_abrir_modal_CambiarDetalleItemPago(boton) {
        fila=boton.closest(".cfila");
        $("#modMantDetalleItemPago").modal('show');
        $('#div_cronogramaFechaITemPago').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var coddetalle64 = fila.data("coddetalle64");
        var gestion_como = fila.data('gestion_como');
        var codgestion = fila.data('codgestion');
        var codgestion_como = fila.data('codgestion_como');
        var carnet = fila.data('carnet');
        var vcodinscripcion64= fila.data('codinscripcion64');
        var vcodmatricula64= fila.data('codmatricula64');

        $("#modMantDetalleItemPago .modal-title").html("Concepto: <span class='text-primary'>" + gestion_como + "</span>");

        $("#vw_cmdidp_cbgestion").val(codgestion);
        $("#vw_cmdidp_txtfactcomo").val(codgestion_como + " " + gestion_como );
        $("#vw_cmdidp_cbmatricula").html("");
        $("#vw_cmdidp_txtcodigo").val(coddetalle64);
        

        $.ajax({
            url: base_url + "matricula/fn_getMatriculas",
            type: 'post',
            dataType: 'json',
            data: {
                "txtcarne": carnet  
            },
            success: function(e) {
                $('#div_cronogramaFechaITemPago #divoverlay').remove();
                $("#vw_cmdidp_cbmatricula").append("<option value='0'>Sin Matrícula</option>");
                 $.each(e.vdata, function(index, v) {
                    var vselected=(vcodmatricula64==v["codmatricula64"]) ? "selected" : "";
                    $("#vw_cmdidp_cbmatricula").append("<option " + vselected + " value='" + v["codmatricula64"] + "'>" + v["periodo"] + " / " + v["ciclo"] + "</option>");
                 });
            },
            error: function(jqXHR, exception) {
                $('#div_cronogramaFechaITemPago #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                //$('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    icon: 'error',
                })
            }
        });
       
        
        $("#vw_cmdidp_txtcambio").val("NO");
        $('.vw_cmdidp_select').select2({
            dropdownParent: $('#modMantDetalleItemPago'),
            width: 'resolve'
        });
    }

    $('#vw_cmdidp_btnguardar').click(function() {
        $('#vw_cmdidp_frmFechaItemPagpo input,select,textarea').removeClass('is-invalid');
        $('#vw_cmdidp_frmFechaItemPagpo .invalid-feedback').remove();
        $('#div_cronogramaFechaITemPago').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var vcoddetalle64=$("#vw_cmdidp_txtcodigo").val();
        var vcodgestion=$("#vw_cmdidp_cbgestion").val();
        var vcodmatricula64=$("#vw_cmdidp_cbmatricula").val();
        //var vMatricula=$( "#vw_cmdidp_cbmatricula option:selected" ).text();
        $.ajax({
            url: base_url + "tesoreria/facturacion/docpago/detalle/acciones/update/gestion-semestre",
            type: 'post',
            dataType: 'json',
            data: {
                coddetalle64: vcoddetalle64,
                codgestion: vcodgestion,
                codmatricula64: vcodmatricula64 
            },
            success: function(e) {
                $('#div_cronogramaFechaITemPago #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                    Swal.fire({
                        title: e.msg,
                        // text: "",
                        icon: 'error',
                    })
                    $("#vw_cmdidp_txtcambio").val("NO");
                } else {
                    $("#vw_cmdidp_txtcambio").val("SI");
                    $('#modMantDetalleItemPago').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Felicitaciones, Cambio registrado',
                        backdrop: false,
                    })

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#div_cronogramaFechaITemPago #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    icon: 'error',
                })
            }
        });
        return false;
    });

</script>