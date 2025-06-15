<div class="modal modal-fullscreen fade" id="modPagos_asignar" tabindex="-1" role="dialog" aria-labelledby="modPagos_asignar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content modPagos_asignar_content">
            <div class="modal-header">
                <h5 class="modal-title" >Pagos Realizados</h5>
                <div class="ml-auto">
                    <a id="vw_mdp_btnActualizar" class="btn btn-sm btn-primary text-white" translate>Actualizar</a>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="row" id="vw_mdp_divEncabezado">
                        <div class="col-12 col-md-2 border rounded h6 mr-1 py-1" >
                            <span id="vw_md_pagos_detalle_coddeuda"></span>
                        </div>
                        <div class="col-12 col-md-5 border rounded h6 mr-1 py-1">
                            <span id="vw_md_pagos_estudiante"></span>
                        </div>
                        <div class="col-12 col-md-3 border rounded h6 mr-1 py-1" >
                            <span id="vw_md_pagos_detalle_grupo"></span>
                        </div>
                        <div class="col-12 col-md-4 border rounded h6 mr-1 py-1" >
                            <span id="vw_md_pagos_gestion"></span>
                        </div>
                        <div class="col-12 col-md-2 border rounded h6 mr-1 py-1" >
                            <span id="vw_md_pagos_detalle_deuda"></span>
                        </div>
                        <div class="col-12 col-md-2 border rounded h6 mr-1 py-1" >
                            <span id="vw_md_pagos_detalle_saldo"></span>
                        </div>
                        <div class="col-12 col-md-2 border rounded h6 mr-1 py-1" >
                            <span id="vw_md_pagos_detalle_vence"></span>
                        </div>
                    </div>
                    <input type="hidden" value="0" id="vw_mdp_txtcoddeuda">
                    <input type="hidden" value="0" id="vw_mdp_txtcodmatricula64">
                    <input type="hidden" value="0" id="vw_mdp_txtinscripcion64">
                    <input type="hidden" value="0" id="vw_mdp_txtcarnet">
                    <input type="hidden" value="0" id="vw_mdp_txtcoddetalle64">
                    
                    
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="row">
                                <div class="col-12 border rounded" >
                                    <h5 class="text-center">Pagos Realizados</h5>
                                </div>
                                
                                <div class="col-12 p-0" id="tabdivres-pagos">
                                    <table id="tbmt_dtpagos" class="tbdatatable table table-sm table-hover table-bordered table-condensed" style="width:100%">
                                        <thead>
                                            <tr class="bg-lightgray">
                                                <th>N°</th>
                                                <th>BOLETA</th>
                                                <th>EMISIÓN</th>
                                                <th>PER./SEM.</th>
                                                <th>GESTIÓN</th>
                                                <th>MONTO</th>
                                                <th>DEUDA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                      
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-12 border rounded" >
                                        <h5 class="text-center">Cobros</h5>
                                    </div>
                                </div>
                                <div class="col-12 mt-3 d-none" id="divcardboleta_detalle">
                                    <div class="row">
                                        <div class="col-12 col-md-5" >
                                            <div class="border rounded">
                                                <h6 class="text-center" id="vw_md_detalle_boleta"></h6>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7" >
                                            <div class="border rounded">
                                                <h6 class="text-center" id="vw_md_item_detalle_boleta"></h6>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mt-2 border rounded" >
                                        <h6 class="text-center" id="vw_md_fecha_detalle_boleta"></h6>
                                    </div>
                                </div>
                                <div class="col-12" id="tabdivres-cobros">
                                    <table id="tbmt_dtcobros" class="tbdatatable table table-sm table-hover table-bordered table-condensed" style="width:100%">
                                        <thead>
                                            <tr class="bg-lightgray">
                                                <th>N°</th>
                                                <th>FECHA</th>
                                                <th>MEDIO</th>
                                                <th>BANCO</th>
                                                <th>MONTO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                      
                                        </tbody>
                                    </table>
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tbmt_dtpagos').DataTable({
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
            }, {
                targets: 2,
                render: function(data, type, row) {
                    var datetime = moment(data, 'YYYY-MM-DD HH:mm:ss');
                    var displayString = moment(datetime).format('DD/MM/YYYY hh:mm a');
                    if (type === 'display' || type === 'filter') {
                        return displayString;
                    } else {
                        return datetime; // for sorting
                    }
                }
            }],
            'searching': false,
        });
        $('#tbmt_dtcobros').DataTable({
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
            'searching': false,
        });
    });

    function fn_data_cobros_x_boleta(idboleta64, boleta, femision, itembol) {
        $('#vw_md_detalle_boleta').html(boleta);
        $('#vw_md_item_detalle_boleta').html(itembol);
        $('#vw_md_fecha_detalle_boleta').html("Fecha Emisión : " + femision);
        $('#divcardboleta_detalle').removeClass('d-none');
        $('#modPagos_asignar .modPagos_asignar_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        tbcobrospg = $('#tbmt_dtcobros').DataTable();
        $.ajax({
            url: base_url + "facturacion_cobros/fn_filtrar_cobros",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_codigopago: idboleta64,
            },
            success: function(e) {
                $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
                tbcobrospg.clear();
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
                    $('#divdatacobrosdoc').html("");
                    var nro = 0;
                    var tabla = "";
                    var montototalc = 0;
                    var banco = "";
                    var operbanco = "";
                    if (e.vdata !== 0) {
                        $.each(e.vdata, function(index, val) {
                            nro++;
                            montototalc += parseFloat(val['montocob']);
                            if (val['nombanco'] !== null) {
                                banco = val['nombanco'];
                            } else {
                                banco = "";
                            }
                            if (val['fechaoper'] !== null) {
                                operbanco = "<b>Operación nro: </b>" + val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                            } else {
                                operbanco = "";
                            }
                            var fechauser = "<span>" + val['fecharegis'] + "</span><br>" +
                                "<span>" + val['usuarioregistra'] + "</span>";
                            var mediopg = "<span class=''>" + banco + "</span> <br>" +
                                "<span class=''>" + operbanco + "</span>";
                            var fila = tbcobrospg.row.add([index + 1, fechauser, val['nommedio'], mediopg, val['montocob']]).node();
                        })
                        tbcobrospg.draw();
                    }
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
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
    function fn_vw_vincular_pagos(btn) {
        $("#modPagos_asignar").modal('show');
        $('#modPagos_asignar .modPagos_asignar_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        //vw_md_pagos_estudiante
        fila = btn.closest(".cfila");
        fila.addClass("bg-selection");
        var cgestion = fila.data('codgestion');
        var gestion = fila.data('gestion');
        var carnet = fila.data('carnet');
        var coddeuda64 = fila.data('coddeuda64');
        var codmatricula64 = fila.data('codmatricula64');
        var coddeuda = fila.data('coddeuda');
        var alumno = fila.data('alumno');
        var apellidos = fila.data('apellidos');
        var deudavence = fila.data('fechaven');
        var grupodeuda = fila.data('grupodeuda');
        var montodeuda = fila.data('deudamonto');
        var saldodeuda = fila.data('saldodeuda');
        var coddetalle64= fila.data('coddetalle64');
        var vcodinscripcion64 = fila.data('codinscripcion64');
        $("#vw_mdp_txtinscripcion64").val(vcodinscripcion64);
        $("#vw_mdp_txtcoddeuda").val(coddeuda);
        $("#vw_mdp_txtcodmatricula64").val(codmatricula64);
        $("#vw_mdp_txtcarnet").val(carnet);
        $("#vw_mdp_txtcoddetalle64").val(coddetalle64);
        $("#vw_md_pagos_estudiante").html("(" + carnet + ") " + apellidos + " " + alumno);
        $("#vw_md_pagos_gestion ").html("(" + cgestion + ") " + gestion);
        $('#vw_md_pagos_detalle_grupo').html("Grupo: " + grupodeuda);
        $('#vw_md_pagos_detalle_deuda').html("Monto: " + montodeuda);
        $('#vw_md_pagos_detalle_coddeuda').html("Deuda N°: " + coddeuda);
        var textColorSaldo = (parseFloat(saldodeuda) > 0) ? "text-danger" : "text-success";
        $('#vw_md_pagos_detalle_saldo').html("Saldo: <span class='" + textColorSaldo + "'>" + saldodeuda + "</span>");
        $('#vw_md_pagos_detalle_vence').html("vence: " + deudavence);
        fn_llenarDtPagos();

        
    }
    function fn_llenarDtPagos(){
        var coddeuda=$("#vw_mdp_txtcoddeuda").val();
        var codmatricula64=$("#vw_mdp_txtcodmatricula64").val();
        var vcodinscripcion64=$("#vw_mdp_txtinscripcion64").val();
        var carnet=$("#vw_mdp_txtcarnet").val();
        var coddetalle64=$("#vw_mdp_txtcoddetalle64").val();
        tbpagospg = $('#tbmt_dtpagos').DataTable();
        vInfo = tbpagospg.page.info();
        vFilasPorPagina = vInfo.length;
        vConetoPaginas = 0;
        vPaginaFilaSelected = 0;
        $.ajax({
            url: base_url + "tesoreria/facturacion/docpago/detalle/filtrar",
            type: 'post',
            dataType: 'json',
            data: {
                txtcodpagante: carnet
            },
            success: function(e) {
                $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
                tbpagospg.clear();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                } else {
                    var nro = 0;
                    var tabla = "";
                    var boton = "";
                    var textColor = "";
                    var coincidencias = 0;
                    $.each(e.vdata, function(index, v) {
                        nro++;

                        if (v['coddeuda'] == 0) {
                            if ((v['estado'] == "ENVIADO") || (v['estado'] == "ACEPTADO") || (v['estado'] == "PENDIENTE")) {
                                boton = "<span class='vw_mdp_spcoddeuda'></span><a href='#' onclick='fn_vw_vincular_pago($(this));return false;' class='vw_mdp_linkdeuda badge badge-success text-white px-1'><i class='fas fa-link mr-1'></i>Vincular</a>";
                            }

                        } else {
                            boton = "<span class='vw_mdp_spcoddeuda'>" + v['coddeuda'] + "</span><a title='Desvincular' href='#' onclick='fn_vw_desvincular_pago($(this));return false;' class='vw_mdp_linkdeuda  badge badge-danger text-white px-1 ml-1'><i class='fas fa-unlink'></i></a>";
                        }
                        monto = Number.parseFloat(v['monto']).toFixed(2);
                        var boleta = "<span title='" + v['coddocpago'] + "/" + v['coddetalle'] + "'>" + v['serie'] + "-" + v['numero'] + "</span>";
                        var peridoSemestre = v['periodo'] + " / " + v['ciclo'];
                        var linkEditarDetalle = "";
                        if ((v['estado'] == "ENVIADO") || (v['estado'] == "ACEPTADO") || (v['estado'] == "PENDIENTE")) {
                            linkEditarDetalle = "<a href='#' onclick='vw_abrir_modal_CambiarDetalleItemPago($(this));return false;' class='badge badge-warning text-white ml-1 px-1'><i class='fas fa-edit'></i></a> "
                        }

                        vgestion = v['gestion_como'] + linkEditarDetalle; //+ v['codgestion'] + v['codgestion_como'];
                        if (v['codgestion'] != v['codgestion_como']) {
                            vgestion = v['gestion'] + linkEditarDetalle + "</br>" + v['gestion_como'] + " (SUNAT)";
                        }
                        var fila = tbpagospg.row.add([index + 1, boleta, v['fecha_hora_sin_formato'], peridoSemestre, vgestion, monto, v['coddeuda']]).node();
                        $(fila).attr('data-coddetalle', v['coddetalle64']);
                        $(fila).attr('data-coddeuda', v['coddeuda']);
                        $(fila).attr('data-coddeuda64', v['coddeuda64']);
                        $(fila).attr('data-coddetalle64', v['coddetalle64']);
                        $(fila).attr('data-codboleta', v['codboleta64']);
                        $(fila).attr('data-codmatricula', v['codmatricula']);
                        $(fila).attr('data-codmatricula64', v['codmatricula64']);
                        $(fila).attr('data-codinscripcion64', v['codinscripcion64']);
                        $(fila).attr('data-boleta', v['serie'] + "-" + v['numero']);
                        $(fila).attr('data-femision', v['fecha_hora']);
                        $(fila).attr('data-itembl', v['gestion']);
                        $(fila).attr('data-carnet', carnet);
                        $(fila).attr('data-codgestion', v['codgestion']);
                        $(fila).attr('data-codgestion_como', v['codgestion_como']);
                        $(fila).attr('data-gestion', v['gestion']);
                        $(fila).attr('data-gestion_como', v['gestion_como']);
                        $(fila).addClass("rowcolor");
                        $(fila).addClass("cfila");
                        if (coddeuda==0){
                            if (coddetalle64 == v['coddetalle64']) {
                                coincidencias++;
                                $(fila).addClass('text-success');
                                $(fila).addClass('text-bold');
                                if (coincidencias == 1) {
                                    fn_data_cobros_x_boleta(v['codboleta64'], v['serie'] + "-" + v['numero'], v['fecha_hora'], v['gestion']);
                                    $(fila).addClass('selected');
                                    vPaginaFilaSelected = vConetoPaginas;
                                }
                            }
                        }
                        else{
                            if (coddeuda == v['coddeuda']) {
                                coincidencias++;
                                $(fila).addClass('text-success');
                                $(fila).addClass('text-bold');
                                if (coincidencias == 1) {
                                    fn_data_cobros_x_boleta(v['codboleta64'], v['serie'] + "-" + v['numero'], v['fecha_hora'], v['gestion']);
                                    $(fila).addClass('selected');
                                    vPaginaFilaSelected = vConetoPaginas;
                                }
                            }
                        }
                        
                        if (vFilasPorPagina == nro) {
                            vConetoPaginas++;
                            nro = 0;
                        }
                        if ((v['estado'] == "ENVIADO") || (v['estado'] == "ACEPTADO") || (v['estado'] == "PENDIENTE")) {

                        } else {
                            $(fila).addClass('text-strike');
                        }
                    });             
                    tbpagospg.draw();
                    tbpagospg.page(vPaginaFilaSelected).draw(false);
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
    }
    $("#vw_mdp_btnActualizar").click(function(event) {
        event.preventDefault();
        var carnet=$("#vw_mdp_txtcarnet").val();
        fn_llenarDtPagos(carnet);
        return false;
    });
</script>