<div class="modal fade" id="vw_deudaModalAjustesMantenimiento" tabindex="-1" role="dialog" aria-labelledby="vw_deudaModalAjustesMantenimiento" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mantenimiento de Ajuste de Deuda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="vw_dmam_txtcodajuste64">
                <input type="hidden" id="vw_dmam_txtcoddeuda64">
                <input type="hidden" id="vw_dmam_txtcodmatricula64">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="vw_dmam_checkTipo" id="vw_dmam_checkDescuento" value="-1">
                                  <label class="form-check-label" for="vw_dmam_checkDescuento">DESCUENTO</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="vw_dmam_checkTipo" id="vw_dmam_checkIncremento" value="1">
                                  <label class="form-check-label" for="vw_dmam_checkIncremento">INCREMENTO</label>
                                </div>
                            </div>
                            <div class="form-group has-float-label col-6">
                                <input type="number" name="vw_dmam_txtmonto" id="vw_dmam_txtmonto" class="form-control form-control-sm text-right" min="0" placeholder="0.00" step="0.01" >
                                <label for="vw_dmam_txtmonto">Monto</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <textarea name="vw_dmam_txtsustento" id="vw_dmam_txtsustento" class="form-control form-control-sm" rows="3" placeholder="Descripción/Sustento"></textarea>
                                <label for="vw_dmam_txtsustento">Descripción/Sustento</label>
                            </div>
                            <div class="form-group has-float-label col-md-6">
                                <input readonly type="number" name="vw_dmam_spnEstado" id="vw_dmam_spnEstado" class="form-control form-control-sm text-right" >
                                <label for="vw_dmam_spnEstado">Estado</label>
                            </div>
                            <div class="form-group has-float-label col-md-6">
                                <input readonly type="number" name="vw_dmam_spnAnulacionFecha" id="vw_dmam_spnAnulacionFecha" class="form-control form-control-sm text-right" >
                                <label for="vw_dmam_spnAnulacionFecha">Fecha de Anulación</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input readonly type="number" name="vw_dmam_spnAnulacionMotivo" id="vw_dmam_spnAnulacionMotivo" class="form-control form-control-sm text-right" placeholder="0.00" step="0.01" >
                                <label for="vw_dmam_spnAnulacionMotivo">Motivo de Anulación</label>
                            </div>
                        </div>
                    </div>
                  
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" id="vw_dmam_btnGuardar" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>

    $('#vw_deudaModalAjustesMantenimiento').on('show.bs.modal', function(e) {
        var btn=$(e.relatedTarget);
        var vCodAjuste64="0";
        var vEstado="";
        var vSustento="";
        var vAnulacionFecha="";
        var vAnulacionMotivo="";
        var vMonto="0";
        $("#vw_dmam_txtcoddeuda64").val($("#vw_dma_txtcoddeuda64").val());
        $("#vw_dmam_txtcodmatricula64").val($("#vw_dma_txtcodmatricula64").val());
        if (btn.data("accion")=="EDITAR"){
            var fila=btn.closest(".cfila");
            vCodAjuste64=fila.data('codajuste64');
            vEstado=fila.data("estado");
            vSustento=fila.data("sustento");
            vAnulacionFecha=fila.data("anulacionfecha");
            vAnulacionMotivo=fila.data("anulacionmotivo");
            vMonto=parseFloat(fila.data("monto")).toFixed(2);
            if (vMonto<0){
                $("#vw_dmam_checkDescuento").prop("checked", true);
            }
            else{
                $("#vw_dmam_checkIncremento").prop("checked", true);
            }
        }
        $("#vw_dmam_txtcodajuste64").val(vCodAjuste64);
        $("#vw_dmam_txtmonto").val(Math.abs(vMonto));
        $("#vw_dmam_txtsustento").val(vSustento);
        $("#vw_dmam_spnEstado").val(vEstado);
        $("#vw_dmam_spnAnulacionFecha").val(vAnulacionFecha);
        $("#vw_dmam_spnAnulacionMotivo").val(vAnulacionMotivo);
        
    });

    $("#vw_dmam_btnGuardar").click(function(event) {
        event.preventDefault();



        var vCodDeuda64=$('#vw_deudaModalAjustesMantenimiento #vw_dmam_txtcoddeuda64').val();
        var vCodAjuste64=$('#vw_deudaModalAjustesMantenimiento #vw_dmam_txtcodajuste64').val();
        var vCodMatricula64=$('#vw_deudaModalAjustesMantenimiento #vw_dmam_txtcodmatricula64').val();
        var vSustento=$("#vw_deudaModalAjustesMantenimiento #vw_dmam_txtsustento").val();
        var vValorTipo=$("#vw_deudaModalAjustesMantenimiento input[name='vw_dmam_checkTipo']:checked").val();
        var vMonto=$("#vw_deudaModalAjustesMantenimiento #vw_dmam_txtmonto").val();
        vMonto=Number(vMonto) * Number(vValorTipo);
        if (vMonto==0){

        }
        else{
            $('#vw_deudaModalAjustesMantenimiento .modal-content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
            //var vEstadoCambiar=(vEstado=="ACTIVO") ? "ANULADO":"ACTIVO";
            $.ajax({
                url: base_url + 'tesoreria/deuda_ajuste/fn_guardar',
                type: 'post',
                dataType: 'json',
                data: {
                    txtcoddeuda64: vCodDeuda64,
                    txtcodajuste64: vCodAjuste64,
                    txtcodmatricula64: vCodMatricula64,
                    txtsustento: vSustento,
                    txtmonto: vMonto,
                },
                success: function(e) {
                    $('#vw_deudaModalAjustesMantenimiento .modal-content #divoverlay').remove();
                    if (e.status == false) {
                        $.each(e.errors, function(key, val) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                        });
                        Swal.fire({
                            title: e.msg,
                            // text: "",
                            type: 'error',
                            icon: 'error',
                        })
                    } else {
                        fn_filtrarAjustes($("#vw_deudaModalAjustes #vw_dma_txtcoddeuda64").val());
                        $('#vw_deudaModalAjustesMantenimiento').modal("hide");
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    ('#vw_deudaModalAjustes .modal-content #divoverlay').remove();
                    Swal.fire({
                        title: msgf,
                        icon: 'error',
                    })
                }
            });
        }
        return false;
    });
   
</script>