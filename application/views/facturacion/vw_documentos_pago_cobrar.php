<div class="modal fade" id="modaddcobros" tabindex="-1" role="dialog" aria-labelledby="modaddcobros" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="divmodaladdcob">
            <div class="modal-header">
                <h5 class="modal-title" id="divcard_title">COBROS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 py-2 border rounded">
                    <div class="row">
                        <div class="col-9">
                            Nro Doc.: <span class="text-bold h5" id="vw_dpcb_spNroDoc"></span><br>
                            Pagante : <span class="text-bold h5" id="vw_dpcb_spPagante" data-codpagante="" data-pagantetipodoc="" data-pagantenrodoc=""></span>
                        </div>
                        <div class="col-3">
                            <div class="row">   
                                <div class="col-4">Total :</div> 
                                <span class=" col-8 text-bold h5 text-right" id="vw_dpcb_spTotal">0.00</span><br>
                                <div class="col-4">Pagado: </div>
                                <span class=" col-8 text-bold h5 text-right" id="ficmontocobrado">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 py-2 border rounded">
                    <form id="form_addcobros" action="<?php echo $vbaseurl ?>facturacion_cobros/fn_insert_cobros" method="post" accept-charset="utf-8">
                        <input type="hidden" name="vw_fcb_codigopago" id="vw_fcb_codigopago" value="">
                        <input type="hidden" name="vw_fcb_montopago" id="vw_fcb_montopago" value="">
                        <input type="hidden" name="vw_fcb_idcobro" id="vw_fcb_idcobro" value="0">
                        <div class="row d-none">
                            <div class="col-6">
                                <b class="h5">MONTO: <span id="ficmontopag">0.00</span></b>
                            </div>
                        </div>
                        <div class="container-fluid h-100">
                            <div class="row justify-content-center h-100">
                                <div class="col-10">
                                    <div class="row mt-2" id="divcard_itemcobros">
                                        <div class="form-group has-float-label col-12 col-sm-6 col-md-6 col-lg-3 ">
                                            <select name="vw_fcb_cbmedio" id="vw_fcb_cbmedio" class="form-control control form-control-sm text-sm">
                                                <option value=''>Seleccione medio</option>"
                                                <?php
                                                foreach ($mediosp as $key => $mpg) {
                                                    echo "<option value='$mpg->codigo' data-medio='$mpg->nombre'>$mpg->nombre</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="vw_fcb_cbmedio">Medio pago</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-md-6 d-none" id="cbobanco">
                                            <select onchange="fn_validarVoucher($(this));return false"  name="vw_fcb_cbbanco" id="vw_fcb_cbbanco" class="form-control control form-control-sm text-sm">
                                                <!-- <option value=''>Seleccione banco</option>" -->
                                                <?php
                                                foreach ($bancos as $key => $bnc) {
                                                echo "<option value='$bnc->codbanco'>$bnc->banco</option>";
                                                }
                                                ?>
                                                
                                            </select>
                                            <label for="vw_fcb_cbbanco">Banco</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-sm-6 col-md-6 col-lg-3" id="vw_fcb_divNotaDeCredito">
                                            <input onchange="fn_validarNotaCredito($(this));return false"  type="text"  name="vw_fcb_txtNotaDeCredito" id="vw_fcb_txtNotaDeCredito" placeholder="Nota de Crédito" class="form-control control form-control-sm text-sm">
                                            <label for="vw_fcb_txtNotaDeCredito">Nota de Crédito</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-sm-6 col-md-6 col-lg-3">
                                            <input type="number" step="0.01" name="vw_fcb_monto_cobro" id="vw_fcb_monto_cobro" placeholder="Monto" data-saldo='0' class="form-control control form-control-sm text-sm">
                                            <label for="vw_fcb_monto_cobro">Monto</label>
                                        </div>
                                    </div>
                                    <div class="row d-none " id="divcard_form_vouchercobro" >
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="d-none " id="divcard_espacio">
                                                </div>
                                                
                                                <div class="form-group has-float-label col-6 col-md-3" id="divcol_itemfec">
                                                    <input type="date" onchange="fn_validarVoucher($(this));return false" name="vw_fcb_fechav_cobro" id="vw_fcb_fechav_cobro" placeholder="Fecha Operación" class="form-control control form-control-sm text-sm">
                                                    <label for="vw_fcb_fechav_cobro">Fecha Operación</label>
                                                </div>
                                                <div class="form-group has-float-label col-6 col-md-2" id="divcol_itemhor">
                                                    <input type="time" name="vw_fcb_horav_cobro" id="vw_fcb_horav_cobro" placeholder="Hora Operación" class="form-control control form-control-sm text-sm">
                                                    <label for="vw_fcb_horav_cobro">Hora Operación</label>
                                                </div>
                                                <div class="form-group has-float-label col-12 col-md-3" id="f">
                                                    <input type="text" onchange="fn_validarVoucher($(this));return false" name="vw_fcb_voucher_cobro" id="vw_fcb_voucher_cobro" placeholder="N° de Operación" class="form-control control form-control-sm text-sm">
                                                    <label for="vw_fcb_voucher_cobro">N° de Operación</label>
                                                </div>
                                                <!-- <div class="form-group col-12 col-md-12">
                                                    
                                                    <button type="button" class="btn btn-secondary btn-sm float-right ml-2" id="btnopercancel">
                                                    Cancelar
                                                    </button>
                                                    //<button type="button" class="btn btn-info btn-sm float-right" id="btnopercob" data-montopg='' data-idocp='' data-modpag='Banco' data-bancopg=''>
                                                    <i class="fas fa-save"></i> Guardar
                                                    </button>
                                                </div> -->
                                            </div>
                                        </div>
                                        
                                    </div>
                                   
                                </div>
                                <div class="col-2 py-2">
                                    <button type="button" class="btn w-100 h-100 bg-info" id="btncobadd"><i class="fas fa-plus"></i> Agregar</button>
                                </div>
                                <div class="col-12" id="vwdpcb_spanValidarVoucher">
                                                                                    
                                </div>
                                <div class="col-12 pb-2 border rounded" id="vwdpcb_divValidarVoucher">
                                    <div class="row">
                                        <div class="col-12 border rounded bg-gray text-white text-bold" >
                                            <div class="row">
                                                <div class="col-6 col-md-2">
                                                        Sede/Fil.
                                                </div>
                                                <div class="col-6 col-md-3">
                                                        Fecha Ope.
                                                </div>
                                                <div class="col-6 col-md-2">
                                                        Operación
                                                </div>
                                                <div class="col-6 col-md-3">
                                                        Doc. Pago
                                                </div>
                                                <div class="col-6 col-md-2">
                                                        Monto
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" id="vwdpcb_divValidarVoucher_usos">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                       </div>
                    </form>
                </div>
                <div id="divcard_lstcobros" class="d-none">
                    <div class="col-12 btable">
                        <div class="col-md-12 thead d-none d-md-block">
                            <div class="row">
                                <div class="col-sm-1 col-md-1 td hidden-xs"><b>N°</b></div>
                                <div class="col-sm-2 col-md-3 td"><b>FECHA</b></div>
                                <div class="col-sm-2 col-md-2 td"><b>MEDIO</b></div>
                                <div class="col-sm-2 col-md-3 td"><b>BANCO</b></div>
                                <div class="col-sm-2 col-md-2 td"><b>MONTO</b></div>
                                <div class="col-sm-1 col-md-1 td text-center"></div>
                            </div>
                        </div>
                        <div class="col-md-12 tbody" id="divres_historialcobros">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6 col-lg-3 col-md-4">
                        <button type="button" class="btn btn-primary btn-sm btnaddcobr" data-montopg='' data-idocp='' data-modpag='Efectivo' data-bancopg='0'>
                        <i class='far fa-credit-card mr-1'></i> <span class="txtmonpg"></span> Efectivo
                        </button>
                    </div>
                    <div class="col-6 col-lg-3 col-md-4">
                        <div class='btn-group'>
                            <button class="btn btn-success btn-sm dropdown-toggle py-1 btnbnccobr" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='far fa-credit-card mr-1'></i> <span class="txtmonpg"></span> Banco
                            </button>
                            <div class='dropdown-menu dropdown-menu-right bancos-dropdown'>
                                <?php
                                foreach ($bancos as $key => $bnc) {
                                echo "<a class='dropdown-item btnaddoperacioncob' href='#' title='$bnc->banco' data-montopg='' data-idocp='' data-modpag='Banco' data-bancopg='$bnc->codbanco' data-nombanco='$bnc->banco'>
                                    <i class='far fa-credit-card mr-1'></i> $bnc->banco
                                </a>";
                                }
                                ?>
                            </div>
                        </div>
                        <!-- <button type="button" class="btn btn-primary btn-sm">Banco</button> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL COBROS -->
<script type="text/javascript">
    // SCRIPT COBROS
    $("#modaddcobros").on('show.bs.modal', function (e) {
        $("#vwdpcb_divValidarVoucher").hide();
        $('#vw_fcb_divNotaDeCredito').addClass('d-none');
        var rel=$(e.relatedTarget);
        //Código de Janior
        var fila=rel.closest('.cfila');
        var codigo = fila.data('codigo64');
        var total = Number(fila.data('total'));
        var nroDocPago=fila.data('serie') + "-" + fila.data('numero');
        var codpagante=fila.data('codpagante');
        var pagantetipodoc=fila.data('pagantetipodoc');
        var pagantenrodoc=fila.data('pagantenrodoc');

        var pagante=fila.data('codpagante') + "-" + fila.data('pagante');
        var subtotal=fila.data('monto');
        var igv=fila.data('igv');

        

        $("#vw_dpcb_spNroDoc").html(nroDocPago);
        $("#vw_dpcb_spPagante").data("codpagante",codpagante);
        $("#vw_dpcb_spPagante").data("pagantetipodoc",pagantetipodoc);
        $("#vw_dpcb_spPagante").data("pagantenrodoc",pagantenrodoc);

        $("#vw_dpcb_spPagante").html(pagante);
        $("#vw_dpcb_spTotal").html(total.toFixed(2));


        $('#vw_fcb_codigopago').val(codigo);
        $('#vw_fcb_montopago').val(total);
        $('#ficmontopag').html(total);
        $('.btnaddcobr').data('montopg', total);
        $('.btnaddcobr').data('idocp', codigo);
        $('.txtmonpg').html(total);

        $('.btnaddoperacioncob').data('montopg', total);
        $('.btnaddoperacioncob').data('idocp', codigo);

        $.ajax({
            url: base_url + "facturacion_cobros/fn_filtrar_cobros",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_codigopago:codigo,
            },
            success: function(e) {
                // $('#divmodaladdcob #divoverlay').remove();
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
                    // $('#modaddcobros').modal('hide');
                    $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
                    $(".bancos-dropdown").removeClass('show');
                    
                    $('#form_addcobros')[0].reset();
                    $('#cbobanco').addClass('d-none');
                    
                    $('#divres_historialcobros').html("");
                    var nro=0;
                    var tabla="";
                    var montototalc = 0;
                    var banco = "";
                    var operbanco = "";
                    
                    if (e.vdata !== 0) {
                        $.each(e.vdata, function(index, val) {
                            nro++;
                            montototalc += parseFloat(val['montocob']);

                            if (val['nombanco']!==null) {
                                banco = val['nombanco'];
                            } else {
                                banco = "";
                            }

                            if (val['fechaoper']!==null) {
                                operbanco = "<b>Operación nro: </b>"+val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                            } else {
                                operbanco = "";
                            }

                            tabla=tabla + 
                            "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                                "<div class='col-2 col-md-1 td'>" +
                                      "<span><b>" + nro + "</b></span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-3 td'>" +
                                  "<span>" + val['fecharegis'] + "</span><br>" +
                                  "<span>" + val['usuarioregistra'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td'>" +
                                    "<span class=''>" + val['nommedio'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-3 td'>" +
                                    "<span class=''>" + banco + "</span> <br>" +
                                    "<span class=''>" + operbanco + "</span>" +
                                "</div> " +
                                "<div class='col-3 col-md-2 td'>" +
                                    "<span class=''>" + val['montocob'] + "</span>" +
                                "</div> " +
                                '<div class="col-3 col-md-1 td text-center">' + 
                                    val['btn_editar'] + 
                                    val['btn_eliminar'] +
                                '</div>' +
                            '</div>';
                        })

                        $('#divcard_lstcobros').removeClass('d-none');
                        $('#divres_historialcobros').html(tabla);
                        $('#ficmontocobrado').html(montototalc);

                        $('.btnaddcobr').attr('disabled', true);
                        $('.btnbnccobr').attr('disabled', true);

                    } else {
                        $('#divcard_lstcobros').addClass('d-none');
                        $('#divres_historialcobros').html("");
                        $('#ficmontocobrado').html("0");

                        $('.btnaddcobr').attr('disabled', false);
                        $('.btnbnccobr').attr('disabled', false);
                    }

                    var totalporcob = parseFloat($('#ficmontopag').html());
                    var totalcobrado = parseFloat($('#ficmontocobrado').html());

                    if (totalcobrado == totalporcob) {
                        $('#btncobadd').attr('disabled', true);
                        $('#form_addcobros select').attr('disabled', true);
                    } else {
                        $('#btncobadd').attr('disabled', false);
                        $('#form_addcobros select').attr('disabled', false);
                    }

                    // if (totalporcob == '0.000') {
                    //     $('.btnaddcobr').attr('disabled', true);
                    //     $('.btnbnccobr').attr('disabled', true);
                    // }


                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                // $('#divmodaladdcob #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        // return false;
    });

    $("#modaddcobros").on('hidden.bs.modal', function (e) {
        $('#divcard_itemcobros').removeClass('d-none');
        $('#divcard_form_vouchercobro').addClass('d-none');
        $('.btnaddcobr').removeClass('d-none');
        $('.btnbnccobr').removeClass('d-none');
        $('#vw_fcb_idcobro').val('0');
        $('#vwdpcb_spanValidarVoucher').html("");
    })

    $('#vw_fcb_cbmedio').change(function(event) {
        var item = $(this);
        vw_docPagoCobrosFocus(item);
        $('#form_addcobros input,select,textarea').removeClass('is-invalid');
        $('#form_addcobros .invalid-feedback').remove();
        $('#vwdpcb_divValidarVoucher').hide();
        

        var medio = item.find(':selected').data('medio');
        var codmedio = item.val();
        $('#divcard_form_vouchercobro').removeClass('border border-dark rounded p-2');
        $('#divtitle_banco').addClass('d-none');
        $('#vw_fcb_divNotaDeCredito').addClass('d-none');
        $('#divcol_itemoper').addClass('col-12 col-md-3');
        $('#divcol_itemoper').removeClass('col-12 col-md-4');

        $('#divcol_itemfec').addClass('col-6 col-md-3');
        $('#divcol_itemfec').removeClass('col-12 col-md-4');

        $('#divcol_itemhor').addClass('col-6 col-md-2');
        $('#divcol_itemhor').removeClass('col-12 col-md-4');
        $('#cbobanco').addClass('d-none');
        
        if (codmedio === "2") {
            //BANCO
            $('#cbobanco').removeClass('d-none');
            $('#divcard_form_vouchercobro').removeClass('d-none');
            
            $('#divcard_espacio').removeClass('d-none');
            $('#btnopercancel').addClass('d-none');
           
        }
        else if (codmedio === "6") {
            //TARJETA
            $('#cbobanco').removeClass('d-none');
            $('#divcard_form_vouchercobro').removeClass('d-none');
            
            $('#divcard_espacio').removeClass('d-none');
            $('#btnopercancel').addClass('d-none');
           
        }
        else if (codmedio === "7") {
            //QR
            $('#cbobanco').removeClass('d-none');
            $('#divcard_form_vouchercobro').removeClass('d-none');
            
            $('#divcard_espacio').removeClass('d-none');
            $('#btnopercancel').addClass('d-none');
           
        }
        else if(codmedio=="3") {
            //NOTA DE CREDITO
            $('#vw_fcb_divNotaDeCredito').removeClass('d-none');
            $('#divcard_form_vouchercobro').addClass('d-none');
            //$('#btnopercob').removeClass('d-none');
            $('#divcard_espacio').addClass('d-none');
            $('#btnopercancel').addClass('d-none');
        }
        else {
            //EL RESTO
            $('#cbobanco').addClass('d-none');
            $('#divcard_form_vouchercobro').addClass('d-none');
            //$('#btnopercob').removeClass('d-none');
            $('#divcard_espacio').addClass('d-none');
            $('#btnopercancel').addClass('d-none');
            
        }
    });


    //btn Agregar Cobro
    $('#btncobadd').click(function(event) {
        /* Act on the event */
        fn_insertarCobro();
    });

    function fn_insertarCobro(){
        $('#vwdpcb_spanValidarVoucher').html("");
        var codigocobro = $('#vw_fcb_idcobro').val();
        var totalporcob = parseFloat($('#ficmontopag').html());
        var totalcobrado = parseFloat($('#ficmontocobrado').html());
        var montoinsertado = parseFloat($('#vw_fcb_monto_cobro').val());
        var totalinsertado = (totalcobrado + montoinsertado);

        //console.log(totalinsertado);
        if (totalinsertado > totalporcob) {
            Swal.fire({
                title: 'Error',
                text: "El monto insertado supera la Cantidad a pagar",
                type: 'error',
                icon: 'error',
            })
        } 
        else {
            $('#form_addcobros input,select,textarea').removeClass('is-invalid');
            $('#form_addcobros .invalid-feedback').remove();
            $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: $('#form_addcobros').attr("action"),
                type: 'post',
                dataType: 'json',
                data: $('#form_addcobros').serialize(),
                success: function(e) {
                    $('#divmodaladdcob #divoverlay').remove();
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
                        // $('#modaddcobros').modal('hide');
                        
                        $('#form_addcobros')[0].reset();
                        $('#cbobanco').addClass('d-none');

                        $('#divcard_form_vouchercobro').addClass('d-none');
                        $('#divcard_espacio').addClass('d-none');
                        //$('#btnopercob').removeClass('d-none');
                        
                        $('#divres_historialcobros').html("");
                        var nro=0;
                        var tabla="";
                        var montototalc = 0;
                        var banco = "";
                        var operbanco = "";
                        
                        $.each(e.vdata, function(index, val) {
                            nro++;
                            montototalc += parseFloat(val['montocob']);

                            if (val['nombanco']!==null) {
                                banco = val['nombanco'];
                            } else {
                                banco = "";
                            }

                            if (val['fechaoper']!==null) {
                                operbanco = "<b>Operación nro: </b>"+val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                            } else {
                                operbanco = "";
                            }

                            tabla=tabla + 
                            "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                                "<div class='col-2 col-md-1 td'>" +
                                      "<span><b>" + nro + "</b></span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-3 td'>" +
                                  "<span>" + val['fecharegis'] + "</span><br>" +
                                  "<span>" + val['usuarioregistra'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td'>" +
                                    "<span class=''>" + val['nommedio'] + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-3 td'>" +
                                    "<span class=''>" + banco + "</span><br>" +
                                    "<span class=''>" + operbanco + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-2 td'>" +
                                    "<span class=''>" + val['montocob'] + "</span>" +
                                "</div> " +
                                '<div class="col-4 col-md-1 td text-center">' + 
                                    val['btn_editar'] + 
                                    val['btn_eliminar'] +
                                '</div>' +
                            '</div>';
                        })
                        $('#divcard_lstcobros').removeClass('d-none');
                        $('#divres_historialcobros').html(tabla);

                        $('#ficmontocobrado').html(montototalc);

                        var totalporcobfn = parseFloat($('#ficmontopag').html());
                        var totalcobradofn = parseFloat($('#ficmontocobrado').html());

                        if (totalcobradofn == totalporcobfn) {
                            $('#btncobadd').attr('disabled', true);
                            $('#form_addcobros select').attr('disabled', true);
                        } else {
                            $('#btncobadd').attr('disabled', false);
                            $('#form_addcobros select').attr('disabled', false);
                        }

                        $('.btnaddcobr').attr('disabled', true);
                        $('.btnbnccobr').attr('disabled', true);

                        $('#vwdpcb_divValidarVoucher').hide();
                        $('#vw_fcb_idcobro').val('0');

                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception,'text');
                    $('#divmodaladdcob #divoverlay').remove();
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
        }
        return false;
    }

    $('.btnaddcobr').click(function() {
        var btn = $(this);
        var codigo = btn.data('idocp');
        var monto = btn.data('montopg');
        var medio = btn.data('modpag');
        var banco = btn.data('bancopg');
        $('#form_addcobros input,select,textarea').removeClass('is-invalid');
        $('#form_addcobros .invalid-feedback').remove();
        $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "facturacion_cobros/fn_insert_cobros_boton",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_codigopago:codigo,
                vw_fcb_cbmedio:medio,
                vw_fcb_monto_cobro:monto,
                vw_fcb_cbbanco:banco,
                vw_fcb_voucher:'',
                vw_fcb_fecha:'',
                vw_fcb_hora:''
            },
            success: function(e) {
                $('#divmodaladdcob #divoverlay').remove();
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
                    // $('#modaddcobros').modal('hide');
                    $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
                    $(".bancos-dropdown").removeClass('show');
                    
                    $('#form_addcobros')[0].reset();
                    $('#cbobanco').addClass('d-none');
                    
                    $('#divres_historialcobros').html("");
                    var nro=0;
                    var tabla="";
                    var montototalc = 0;
                    var banco = "";
                    
                    $.each(e.vdata, function(index, val) {
                        nro++;
                        montototalc += parseFloat(val['montocob']);

                        if (val['nombanco']!==null) {
                            banco = val['nombanco'];
                        } else {
                            banco = "";
                        }

                        tabla=tabla + 
                        "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                            "<div class='col-2 col-md-1 td'>" +
                                  "<span><b>" + nro + "</b></span>" +
                            "</div>" + 
                            "<div class='col-4 col-md-3 td'>" +
                              "<span>" + val['fecharegis'] + "</span>" +
                            "</div> " +
                            "<div class='col-6 col-md-2 td'>" +
                                "<span class=''>" + val['nommedio'] + "</span>" +
                            "</div> " +
                            "<div class='col-4 col-md-3 td'>" +
                                "<span class=''>" + banco + "</span> " +
                            "</div> " +
                            "<div class='col-4 col-md-2 td'>" +
                                "<span class=''>" + val['montocob'] + "</span>" +
                            "</div> " +
                            '<div class="col-4 col-md-1 td text-center">' + 
                                val['btn_editar'] + 
                                val['btn_eliminar'] +
                            '</div>' +
                        '</div>';
                    })
                    $('#divcard_lstcobros').removeClass('d-none');
                    $('#divres_historialcobros').html(tabla);

                    $('#ficmontocobrado').html(montototalc);

                    var totalporcob = parseFloat($('#ficmontopag').html());
                    var totalcobrado = parseFloat($('#ficmontocobrado').html());

                    if (totalcobrado == totalporcob) {
                        $('#btncobadd').attr('disabled', true);
                        $('#form_addcobros select').attr('disabled', true);
                    } else {
                        $('#btncobadd').attr('disabled', false);
                        $('#form_addcobros select').attr('disabled', false);
                    }

                    $('.btnaddcobr').attr('disabled', true);
                    $('.btnbnccobr').attr('disabled', true);


                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladdcob #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });

    $(document).on("click", ".btndeletecobro", function() {
        var btn = $(this);
        var codigo = btn.data('idcobro');
        var idocpago = btn.data('idocpg');
        $('#form_addcobros input,select,textarea').removeClass('is-invalid');
        $('#form_addcobros .invalid-feedback').remove();
        $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "facturacion_cobros/fn_delete_cobros",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_codigocobro:codigo,
                vw_fcb_idocpago : idocpago,
            },
            success: function(e) {
                $('#divmodaladdcob #divoverlay').remove();
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
                    // $('#modaddcobros').modal('hide');
                    $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
                    $(".bancos-dropdown").removeClass('show');
                    
                    $('#form_addcobros')[0].reset();
                    $('#cbobanco').addClass('d-none');

                    $('#divcard_form_vouchercobro').addClass('d-none');
                    $('#divcard_espacio').addClass('d-none');
                    //$('#btnopercob').removeClass('d-none');
                    
                    $('#divres_historialcobros').html("");
                    var nro=0;
                    var tabla="";
                    var montototalc = 0;
                    var banco = "";
                    var operbanco = "";

                    if (e.vdata.length !== 0) {
                        $.each(e.vdata, function(index, val) {
                            nro++;
                            montototalc += parseFloat(val['montocob']);

                            if (val['nombanco']!==null) {
                                banco = val['nombanco'];
                            } else {
                                banco = "";
                            }

                            if (val['fechaoper']!==null) {
                                operbanco = "<b>Operación nro: </b>"+val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
                            } else {
                                operbanco = "";
                            }

                            tabla=tabla + 
                            "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
                                "<div class='col-2 col-md-1 td'>" +
                                      "<span><b>" + nro + "</b></span>" +
                                "</div>" + 
                                "<div class='col-4 col-md-3 td'>" +
                                  "<span>" + val['fecharegis'] + "</span>" +
                                "</div> " +
                                "<div class='col-6 col-md-2 td'>" +
                                    "<span class=''>" + val['nommedio'] + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-3 td'>" +
                                    "<span class=''>" + banco + "</span><br>" +
                                    "<span class=''>" + operbanco + "</span>" +
                                "</div> " +
                                "<div class='col-4 col-md-2 td'>" +
                                    "<span class=''>" + val['montocob'] + "</span>" +
                                "</div> " +
                                '<div class="col-4 col-md-1 td text-center">' + 
                                    val['btn_editar'] + 
                                    val['btn_eliminar'] +
                                '</div>' +
                            '</div>';
                        })

                        $('#divcard_lstcobros').removeClass('d-none');
                        $('#divres_historialcobros').html(tabla);
                        $('#ficmontocobrado').html(montototalc);

                        $('.btnaddcobr').attr('disabled', true);
                        $('.btnbnccobr').attr('disabled', true);

                    } else {
                        $('#divcard_lstcobros').addClass('d-none');
                        $('#divres_historialcobros').html("");
                        $('#ficmontocobrado').html("0");

                        $('.btnaddcobr').attr('disabled', false);
                        $('.btnbnccobr').attr('disabled', false);
                        $('.btnaddcobr').removeClass('d-none');
                        $('.btnbnccobr').removeClass('d-none');
                    }

                    var totalporcob = parseFloat($('#ficmontopag').html());
                    var totalcobrado = parseFloat($('#ficmontocobrado').html());

                    if (totalcobrado == totalporcob) {
                        $('#btncobadd').attr('disabled', true);
                        $('#form_addcobros select').attr('disabled', true);
                    } else {
                        $('#btncobadd').attr('disabled', false);
                        $('#form_addcobros select').attr('disabled', false);
                    }
                    

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladdcob #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    })
    
    

    $('.btnaddoperacioncob').click(function() {
        var btn=$(this);
        var montopg = btn.data('montopg');
        var idocpg = btn.data('idocp');
        var bancopg = btn.data('bancopg');
        var nombanco = btn.data('nombanco');
            $("#vw_fcb_cbmedio").val(2);
            $("#vw_fcb_cbbanco").val(bancopg);
            $("#vw_fcb_monto_cobro").val(montopg);
            $('#vw_fcb_cbmedio').change();
       
    });

    $(document).on("click", ".btneditcobro", function() {
        var btn = $(this);
        var codigo = btn.data('idcobro');
        var idocpago = btn.data('idocpg');
        var totcobrado = parseFloat($('#ficmontocobrado').html());
        $('#form_addcobros input,select,textarea').removeClass('is-invalid');
        $('#form_addcobros .invalid-feedback').remove();
        $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "facturacion_cobros/fn_get_cobros_id",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_codigocobro:codigo,
                vw_fcb_idocpago : idocpago,
            },
            success: function(e) {
                $('#divmodaladdcob #divoverlay').remove();
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
                    // $('#modaddcobros').modal('hide');
                    $('#ficmontocobrado').html((totcobrado-e.vdata['montocob']));
                    $('#vw_fcb_idcobro').val(e.vdata['codigo64']);
                    $('#vw_fcb_cbmedio').val(e.vdata['idmedio']);
                    if (e.vdata['nommedio'] == "Banco") {
                        $('#vw_fcb_cbmedio').change();
                        $('#vw_fcb_cbbanco').val(e.vdata['idbanco']);
                        $('#vw_fcb_fechav_cobro').val(e.vdata['operacionfecha']);
                        $('#vw_fcb_horav_cobro').val(e.vdata['operacionhora']);
                        $('#vw_fcb_voucher_cobro').val(e.vdata['voucher']);
                        $('#vw_fcb_cbbanco').change();
                        $('#vw_fcb_cbbanco').attr('disabled', false);
                        $('#cbobanco').removeClass('d-none');
                        $('#divcard_form_vouchercobro').removeClass('d-none');
                    }

                    $('#vw_fcb_monto_cobro').val(e.vdata['montocob']);
                    

                    $('#vw_fcb_cbmedio').attr('disabled', false);
                    $('#btncobadd').attr('disabled', false);

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                $('#divmodaladdcob #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        return false;
    });

    function fn_validarVoucher(control){
        vw_docPagoCobrosFocus(control);
        var btn = $(this);
        
        var banco = $('#vw_fcb_cbbanco').val();
        var fecha = $('#vw_fcb_fechav_cobro').val();
        var voucher = $('#vw_fcb_voucher_cobro').val();
        $('#vwdpcb_divValidarVoucher').hide();
        if ((isValidDate(fecha) == true) && ($.trim(voucher) != "")) {
            
            $('#vwdpcb_spanValidarVoucher').html("<span class='text-danger' ><i class='fa fa-spinner fa-spin text-danger'></i> Validando Nro de Operación</span>");
            $('#vwdpcb_divValidarVoucher_usos').html("");
            if (isFechaMenorActual(fecha) == true){
                
                var fechaOperacion = new Date(fecha);
                year = fechaOperacion.getFullYear();
                var fechaMinimaOperacion =new Date(year - 1,1,1);
                var isValida=false;
                
                //if (fechaMinimaOperacion < fechaOperacion){
                  isValida=true;
                  //Significa que la fecha no es muy antigua (Máximo del año anterior)
                //}
               
                if (isValida==true){
                    $.ajax({
                        url: base_url + "facturacion_cobros/fn_consultarVoucher",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            vw_fcb_cbbanco: banco,
                            vw_fcb_voucher: voucher,
                            vw_fcb_fecha: fecha
                        },
                        success: function(e) {
                            $("#vwdpcb_divValidarVoucher").show();

                            if (e.status == false) {
                                $('#vwdpcb_spanValidarVoucher').html("<span class='text-danger' ><i class='fas fa-exclamation-triangle'></i> Ocurrio un Error </span>");
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
                                // $('#modaddcobros').modal('hide');
                                
                                var nro = 0;
                                var tabla = "";
                                var montototal = 0;
                                
                                var operbanco = "";
                                $('#vwdpcb_divValidarVoucher').show();
                                $.each(e.vdata, function(index, val) {
                                    nro++;
                                    montototal += parseFloat(val['monto']);

                                    tabla = tabla +
                                        "<div class='row rowcolor cfila' data-codcobro='" + val['codigo64'] + "' >" +

                                            "<div class='col-6 col-md-2 td'>" +
                                                "<span>" + val['sede_abrevia'] + "</span>" +
                                            "</div> " +
                                            "<div class='col-6 col-md-3 td'>" +
                                                "<span>" + val['fecha_operacion'] + "</span>" +
                                            "</div> " +
                                            "<div class='col-6 col-md-2 td'>" +
                                                "<span>" + val['voucher'] + "</span>" +
                                            "</div> " +
                                            "<div class='col-6 col-md-3 td'>" +
                                                "<span>" + val['seriedoc'] + "-" + val['nrodoc'] + "</span>" +
                                            "</div> " +
                                            "<div class='col-6 col-md-2 td'>" +
                                                "<span>" + val['monto'] + "</span>" +
                                            "</div> " +
                                        
                                        '</div>';
                                });

                                if (nro==0){
                                    mensajeValidar="<span class='text-success' ><i class='far fa-eye'></i> Nro de Operación: <b> Encontramos " + nro +" coincidencias </b></span>";
                                    
                                    $("#vwdpcb_divValidarVoucher").hide();
                                }
                                else if (nro==1){
                                    mensajeValidar="<span class='text-danger' ><i class='far fa-eye'></i> Nro de Operación: <b> Encontramos " + nro +" coincidencias </b></span>";
                                }
                                else{
                                    mensajeValidar="<span class='text-danger' ><i class='far fa-eye'></i> Nro de Operación: <b> Encontramos " + nro +" coincidencias </b></span>";
                                }
                                $('#vwdpcb_spanValidarVoucher').html(mensajeValidar);
                                $("#vwdpcb_divValidarVoucher_usos").html(tabla);
                            }
                        },
                        error: function(jqXHR, exception) {
                            var msgf = errorAjax(jqXHR, exception, 'text');
                            $('#divmodaladdcob #divoverlay').remove();
                            Swal.fire({
                                title: msgf,
                                // text: "",
                                type: 'error',
                                icon: 'error',
                            })

                        }
                    });
                }
                else{
                     $('#vwdpcb_spanValidarVoucher').html("<span class='text-danger' ><i class='fas fa-exclamation-triangle'></i> La fecha de operación no puede ser muy antigua</span>");
                }
            }
            else{
                $('#vwdpcb_spanValidarVoucher').html("<span class='text-danger' ><i class='fas fa-exclamation-triangle'></i> La fecha de operación no puede ser mayor a hoy</span>");
            }
            
        }
        return false;
    };

    function fn_validarNotaCredito(btn){
        var vserie="";
        var vnro="";
        var nc_serienro = btn.val();
        $('#form_addcobros input,select,textarea').removeClass('is-invalid');
        $('#form_addcobros .invalid-feedback').remove();
        $('#vwdpcb_spanValidarVoucher').html("");
        if ($.trim(nc_serienro)!=""){
            var result = nc_serienro.split('-');
            if (result.length==2) {
                vserie=result[0];
                vnro=result[1];
            }
            if ((vserie=="") || (vnro=="")){
                $('#vwdpcb_spanValidarVoucher').html("Ingresar la serie y número de la nota de crédito");
                return false;   
            }
            $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + "tesoreria/docspago_facbol/fn_getDcoumentos",
                type: 'post',
                dataType: 'json',
                data: {
                    serie : vserie,
                    nro : vnro
                },
                success: function(e) {
                    
                    $('#divmodaladdcob #divoverlay').remove();
                    $("#vwdpcb_divValidarVoucher").show();

                    if (e.status == false) {
                        $('#vwdpcb_spanValidarVoucher').html("<span class='text-danger' ><i class='fas fa-exclamation-triangle'></i> Ocurrio un Error </span>");
                        Swal.fire({
                            title: e.msg,
                            // text: "",
                            type: 'error',
                            icon: 'error',
                        })

                    }
                    else {
                        // $('#modaddcobros').modal('hide');
                        if (e.data.length==1){
                            vdoc=e.data[0];

                            vPaganteCodTipoDoc=vdoc['codtipodocidentidad'];
                            vPaganteNroDoc=vdoc['pagantenrodoc'];

                            vcodpaganteDoc=$("#vw_dpcb_spPagante").data("codpagante");
                            vViewPaganteCodTipoDoc=$("#vw_dpcb_spPagante").data("pagantetipodoc");
                            vViewPaganteNroDoc=$("#vw_dpcb_spPagante").data("pagantenrodoc");

                            vpagante= $("#vw_dpcb_spPagante").html();
                            if ($.trim(vPaganteNroDoc) == $.trim(vViewPaganteNroDoc) & ($.trim(vPaganteCodTipoDoc) == $.trim(vViewPaganteCodTipoDoc)) ){
                                maplicado= Number(vdoc['monto_aplicado']);
                                total= Number(vdoc['total']);
                                saldo=total - maplicado;
                                $('#vw_fcb_monto_cobro').data("saldo",saldo);
                                $('#vw_fcb_monto_cobro').val(saldo); 
                            }
                            else{
                                Swal.fire({
                                    title: "La nota de crédito no pertenece a " + vpagante,
                                    // text: "",
                                    type: 'error',
                                    icon: 'error',
                                })
                                $('#vw_fcb_monto_cobro').data("saldo","");
                                $('#vw_fcb_monto_cobro').val(""); 
                            }
                        }
                        // $('#vwdpcb_spanValidarVoucher').html(mensajeValidar);
                        // $("#vwdpcb_divValidarVoucher_usos").html(tabla);
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divmodaladdcob #divoverlay').remove();
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
        }
        return false;
    };


    function   vw_docPagoCobrosFocus(control){
        if (control.attr("id")=="vw_fcb_cbmedio"){
            if (control.val()==1){
                $('#vw_fcb_monto_cobro').focus();
                $('#vw_fcb_cbbanco').val()="";
            }
            else if(control.val()==2){
                if ($('#vw_fcb_cbbanco').val()!=""){
                    $('#vw_fcb_monto_cobro').focus();
                }
            }

        }
        else if(control.attr("id")=="vw_fcb_cbbanco"){
           $('#vw_fcb_monto_cobro').focus();
        }
    }

       // $('#btnopercob').click(function() {
    //     var btn=$(this);
    //     var monto = btn.data('montopg');
    //     var codigo = btn.data('idocp');
    //     var banco = btn.data('bancopg');
    //     var medio = btn.data('modpag');
    //     var fecha = $('#vw_fcb_fechav_cobro').val();
    //     var hora = $('#vw_fcb_horav_cobro').val();
    //     var voucher = $('#vw_fcb_voucher_cobro').val();
    //         $('#form_addcobros input,select,textarea').removeClass('is-invalid');
    //         $('#form_addcobros .invalid-feedback').remove();
    //         $('#divmodaladdcob').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    //         $.ajax({
    //             url: base_url + "facturacion_cobros/fn_insert_cobros_boton",
    //             type: 'post',
    //             dataType: 'json',
    //             data: {
    //                 vw_fcb_codigopago:codigo,
    //                 vw_fcb_cbmedio:medio,
    //                 vw_fcb_monto_cobro:monto,
    //                 vw_fcb_cbbanco:banco,
    //                 vw_fcb_voucher:voucher,
    //                 vw_fcb_fecha:fecha,
    //                 vw_fcb_hora:hora
    //             },
    //             success: function(e) {
    //                 $('#divmodaladdcob #divoverlay').remove();
    //                 if (e.status == false) {
    //                     $.each(e.errors, function(key, val) {
    //                         $('#' + key).addClass('is-invalid');
    //                         $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
    //                     });

    //                     Swal.fire({
    //                         title: e.msg,
    //                         // text: "",
    //                         type: 'error',
    //                         icon: 'error',
    //                     })
                        
    //                 } else {
    //                     // $('#modaddcobros').modal('hide');
    //                     $(".btn-group").find('.dropdown-toggle').attr("aria-expanded", "false");
    //                     $(".bancos-dropdown").removeClass('show');
                        
    //                     $('#form_addcobros')[0].reset();
    //                     $('#cbobanco').addClass('d-none');
                        
    //                     $('#divres_historialcobros').html("");
    //                     var nro=0;
    //                     var tabla="";
    //                     var montototalc = 0;
    //                     var banco = "";
    //                     var operbanco = "";

    //                     $.each(e.vdata, function(index, val) {
    //                         nro++;
    //                         montototalc += parseFloat(val['montocob']);

    //                         if (val['nombanco']!==null) {
    //                             banco = val['nombanco'];
    //                         } else {
    //                             banco = "";
    //                         }

    //                         if (val['fechaoper']!==null) {
    //                             operbanco = "<b>Operación nro: </b>"+val['voucher'] + "<br><b>F.operac.:</b> " + val['fechaoperac'];
    //                         } else {
    //                             operbanco = "";
    //                         }

    //                         tabla=tabla + 
    //                         "<div class='row rowcolor cfila' data-codcobro='"+val['codigo64']+"' >"+
    //                             "<div class='col-2 col-md-1 td'>" +
    //                                   "<span><b>" + nro + "</b></span>" +
    //                             "</div>" + 
    //                             "<div class='col-4 col-md-3 td'>" +
    //                               "<span>" + val['fecharegis'] + "</span>" +
    //                             "</div> " +
    //                             "<div class='col-6 col-md-2 td'>" +
    //                                 "<span class=''>" + val['nommedio'] + "</span>" +
    //                             "</div> " +
    //                             "<div class='col-4 col-md-3 td'>" +
    //                                 "<span class=''>" + banco + "</span><br>" +
    //                                 "<span class=''>" + operbanco + "</span>" +
    //                             "</div> " +
    //                             "<div class='col-4 col-md-2 td'>" +
    //                                 "<span class=''>" + val['montocob'] + "</span>" +
    //                             "</div> " +
    //                             '<div class="col-4 col-md-1 td text-center">' + 
    //                                 "<button class='btn btn-danger btn-sm btndeletecobro px-3' data-idcobro='"+val['codigo64']+"' data-idocpg='"+val['idocpg64']+"'>"+
    //                                     "<i class='fas fa-trash-alt'></i>"+
    //                                 "</button>"+
    //                             '</div>' +
    //                         '</div>';
    //                     })
    //                     $('#divcard_lstcobros').removeClass('d-none');
    //                     $('#divres_historialcobros').html(tabla);

    //                     $('#ficmontocobrado').html(montototalc);

    //                     var totalporcob = parseFloat($('#ficmontopag').html());
    //                     var totalcobrado = parseFloat($('#ficmontocobrado').html());

    //                     if (totalcobrado == totalporcob) {
    //                         $('#btncobadd').attr('disabled', true);
    //                         $('#form_addcobros select').attr('disabled', true);
    //                     } else {
    //                         $('#btncobadd').attr('disabled', false);
    //                         $('#form_addcobros select').attr('disabled', false);
    //                     }

    //                     $('.btnaddcobr').attr('disabled', true);
    //                     $('.btnbnccobr').attr('disabled', true);

    //                     $('#divcard_itemcobros').removeClass('d-none');
    //                     $('#divcard_form_vouchercobro').addClass('d-none');
    //                     $('#vw_fcb_fechav_cobro').val("");
    //                     $('#vw_fcb_horav_cobro').val("");
    //                     $('#vw_fcb_voucher_cobro').val("");

    //                 }
    //             },
    //             error: function(jqXHR, exception) {
    //                 var msgf = errorAjax(jqXHR, exception,'text');
    //                 $('#divmodaladdcob #divoverlay').remove();
    //                 Swal.fire({
    //                     title: msgf,
    //                     // text: "",
    //                     type: 'error',
    //                     icon: 'error',
    //                 })
    //             }
    //         });
       
    //     return false;
    // });
</script>