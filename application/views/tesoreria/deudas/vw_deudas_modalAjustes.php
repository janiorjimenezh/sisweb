<div class="modal fade" id="vw_deudaModalAjustes" tabindex="-1" role="dialog" aria-labelledby="vw_deudaModalAjustes" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajustes de Deuda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">

                        <input type="hidden" id="vw_dma_txtcoddeuda64">
                        <input type="hidden" id="vw_dma_txtcodmatricula64">
                        
                        <div class="row">
                            <div class="col-md-3 text-bold">ESTUDIANTE:</div>
                            <div class="col-md-9" id="vw_dma_spnEstudiante">
                                8888777-APS JIMENEZ HUAYANAYNJANIOR ALEXNADER
                            </div>
                            <div class="col-md-3 text-bold">GRUPO:</div>
                            <div class="col-md-9" id="vw_dma_spnGrupo">
                                ----------------------
                            </div>
                            <div class="col-md-3 text-bold">CONCEPTO:</div>
                            <div class="col-md-9" id="vw_dma_spnConcepto">
                                04.01 PENSIONES IST - CUOTA 01
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-6 text-bold">MONTO:</div>
                            <div class="col-md-6" id="vw_dma_spnMonto">
                                120.00
                            </div>
                            <div class="col-md-6 text-bold">AJUSTE:</div>
                            <div class="col-md-6" id="vw_dma_spnAjuste">
                                120.00
                            </div>
                            <div class="col-md-6 text-bold">CANCELADO:</div>
                            <div class="col-md-6" id="vw_dma_spnCancelado">
                                120.00
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-6 text-bold">CRONOGRAMA:</div>
                            <div class="col-md-6 text-bold" id="vw_dma_spnCronograma">
                                ------------
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-12 text-bold">SALDO:</div>
                                            <h4 class="col-md-12" id="vw_dma_spnSaldo">
                                                120.00
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="col-md-12"> &nbsp;</div>
                                        <a href="#" data-accion="NUEVO" data-toggle="modal" data-target="#vw_deudaModalAjustesMantenimiento" class="btn btn-sm btn-success">Agregar</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
               <div class="table-responsive m-0 border-bottom">
                    <table id="tbdpd_dtAjustes" class="tbdatatable table table-sm table-hover table-bordered table-condensed" style="width:100%">
                        <thead>
                            <tr class="bg-lightgray">
                                <th>CÓD.</th>
                                <th>TIPO</th>
                                <th>MONTO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>APRUEBA</th>
                                <th>FECHA</th>
                                <th>ESTADO</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tbdpd_dtAjustes').DataTable({
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
            },

            {
                "targets": [2], 
                "className": "text-right"
            },  
            {
                targets: 5,
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
    });

    $('#vw_deudaModalAjustes').on('shown.bs.modal', function(e) {
         $(document).off('focusin.modal');
        var btn=$(e.relatedTarget);
        var fila=btn.closest(".cfila");
        var vcoddeuda64=fila.data('coddeuda64');
        $("#vw_deudaModalAjustes #vw_dma_txtcoddeuda64").val(vcoddeuda64);
        $("#vw_deudaModalAjustes #vw_dma_txtcodmatricula64").val(fila.data('codmatricula64'));
        
        
        $("#vw_deudaModalAjustes #vw_dma_spnEstudiante").html(fila.data('apellidos') + " " + fila.data('alumno'));
        var grupo=fila.data('grupodeuda');
        $("#vw_deudaModalAjustes #vw_dma_spnGrupo").html(grupo);
        $("#vw_deudaModalAjustes #vw_dma_spnConcepto").html(fila.data('codgestion') + "-" + fila.data('gestion'));
        $("#vw_deudaModalAjustes #vw_dma_spnMonto").html(fila.data('deudamonto'));
        $("#vw_deudaModalAjustes #vw_dma_spnCancelado").html(fila.data('deudacancelado'));
        $("#vw_deudaModalAjustes #vw_dma_spnCronograma").html("<span class='text-primary'>" + fila.data('cronograma') + "</span> " );
        $("#vw_deudaModalAjustes #vw_dma_spnAjuste").html(fila.data('deudaajuste'));
        $("#vw_deudaModalAjustes #vw_dma_spnSaldo").html(fila.data('saldodeuda'));
        
        fn_filtrarAjustes(vcoddeuda64);
    });

    function fn_filtrarAjustes(vcoddeuda64){
        $('#vw_deudaModalAjustes .modal-content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
        $.ajax({
            url: base_url + 'tesoreria/deuda_ajuste/fn_getDeudaAjustes',
            type: 'post',
            dataType: 'json',
            data: {
                coddeuda64: vcoddeuda64
            },
            success: function(e) {
                $('#vw_deudaModalAjustes .modal-content #divoverlay').remove();
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
                    tbAjustes = $('#tbdpd_dtAjustes').DataTable();
                    tbAjustes.clear();
                    var bgcolor = "";
                    var badgecolor = "";
                    var btnupdate = "";
                    var ajustedropdownOpciones = "";
                    var btnvincular = "";
                    var btnAnularActivar="";
                    $.each(e.data, function(index, val) {
                            
                        // if (vpermiso198 == "SI") {
                        //     btnvincular = '<a class="badge badge-primary py-1 ml-1 text-white" href="#" onclick="fn_vw_vincular_pagos($(this));return false;" title="Vincular Pagos" >' +
                        //         '<i class="far fa-money-bill-alt fa-lg"></i>' +
                        //         '</a>';
                        // }

                        // '<a href="#" onclick="fn_delete_deuda($(this))" class="dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                        //             '</div>' +
                        btntextAnulaActivar=(val['estado']=="ACTIVO") ? "Anular": "Activar";
              
                            
                        btnEditar='<a href="#" data-toggle="modal" data-accion="EDITAR" data-target="#vw_deudaModalAjustesMantenimiento"  class="dropdown-item ">Editar</a>';
                        btnEliminar='<a href="#" onclick="fn_eliminarDeudaAjuste($(this))" class="dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>';
                        btnAnularActivar='<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item ">' + btntextAnulaActivar + '</a>';
                        ajustedropdownOpciones = '<div class="btn-group btn-group-sm dropleft m-0 p-0">' +
                                '<button title="' + val['estadodeuda'] + '" class="btn btn-primary btn-sm dropdown-toggle px-1 py-0" type="button" data-toggle="dropdown" ' +
                                'aria-haspopup="true" aria-expanded="false">' +
                                 '<i class="fas fa-cog"></i>' +
                                '</button> ' +
                                '<div class="dropdown-menu">' +
                                     btnEditar +
                                     btnAnularActivar + 
                                    '<div class="dropdown-divider"></div>' +
                                     btnEliminar
                                '</div>';


                            var vMonto=parseFloat(val['monto']).toFixed(2);
                            var vTipo=(vMonto<0) ? "DESCUENTO" : "INCREMENTO";
                            var arrayAjuste_new = [
                                val['codajuste'] ,
                                vTipo ,
                                vMonto,
                                val['sustento'],
                                val['paterno'] + " " + val['materno'] + " " + val['nombres'],
                                val['creado'],
                                val['estado'],
                                ajustedropdownOpciones 
                            ];


                            var filaAjuste_new = tbAjustes.row.add(arrayAjuste_new).node();
                            $(filaAjuste_new).attr('data-coddeuda64', val['coddeuda64'] );
                            $(filaAjuste_new).attr('data-codajuste64', val['codajuste64'] );
                            $(filaAjuste_new).attr('data-estado', val['estado'] );
                            $(filaAjuste_new).attr('data-sustento', val['sustento'] );
                            $(filaAjuste_new).attr('data-monto', vMonto );
                            $(filaAjuste_new).attr('data-anulacionfecha', val['anulacion_fecha'] );
                            $(filaAjuste_new).attr('data-anulacionmotivo', val['anulacion_motivo'] );

                            $(filaAjuste_new).addClass("cfila");
                    })
                    tbAjustes.draw();
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#vw_deudaModalAjustes .modal-content #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
    }

    function fn_cambiarestado(btn){
        
        var fila=btn.closest(".cfila");
        var vcoddeuda64=fila.data('coddeuda64');
        var vcodajuste64=fila.data('codajuste64');
        var vEstado=fila.data('estado');
        var vCodMatricula64=$("#vw_deudaModalAjustes #vw_dma_txtcodmatricula64").val();

        (async () => {
            const { value: text } = await Swal.fire({
              input: "textarea",
              inputLabel: "Motivo:",
              inputPlaceholder: "Ingrese el motivo de cambio",
              inputAttributes: {
                "aria-label": "Ingrese el motivo de cambio" 
                },
              showCancelButton: true
            });
            if (text) {
                $('#vw_deudaModalAjustes .modal-content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
        
                var vEstadoCambiar=(vEstado=="ACTIVO") ? "ANULADO":"ACTIVO";
                $.ajax({
                    url: base_url + 'tesoreria/deuda_ajuste/fn_guardar',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        txtcoddeuda64: vcoddeuda64,
                        txtcodajuste64: vcodajuste64,
                        cbestado: vEstadoCambiar,
                        txtmotivo: text,
                        txtcodmatricula64: vCodMatricula64,
                    },
                    success: function(e) {
                        $('#vw_deudaModalAjustes .modal-content #divoverlay').remove();
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
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        ('#vw_deudaModalAjustes .modal-content #divoverlay').remove();
                        Swal.fire({
                            title: msgf,
                            // text: "",
                            type: 'error',
                            icon: 'error',
                        })
                    }
                });
            }
        })();

        
        return false;
    }

    function fn_eliminarDeudaAjuste(btn){
        
        var fila=btn.closest(".cfila");
        var vcoddeuda64=fila.data('coddeuda64');
        var vcodajuste64=fila.data('codajuste64');
        var vCodMatricula64=$("#vw_deudaModalAjustes #vw_dma_txtcodmatricula64").val();
        var vSustento=fila.data('sustento');
        var vMonto=fila.data('monto');
        Swal.fire({
          title: "Deseas eliminar el ajuste?",
          text: "Descripción: " + vSustento + " Monto: " + vMonto + "?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, eliminar!"
        }).then((result) => {
          if (result.isConfirmed) {
            $('#vw_deudaModalAjustes .modal-content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
        
                $.ajax({
                    url: base_url + 'tesoreria/deuda_ajuste/fn_eliminar',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        txtcoddeuda64: vcoddeuda64,
                        txtcodajuste64: vcodajuste64,
                        txtcodmatricula64: vCodMatricula64,
                    },
                    success: function(e) {
                        $('#vw_deudaModalAjustes .modal-content #divoverlay').remove();
                        if (e.status == false) {
                            $.each(e.errors, function(key, val) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                            });
                            Swal.fire({
                                title: e.msg,
                                icon: 'error',
                            })
                        } else {
                            Swal.fire({
                              title: "Eliminado!",
                              icon: "success"
                            });
                            fila.remove();
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        ('#vw_deudaModalAjustes .modal-content #divoverlay').remove();
                        Swal.fire({
                            title: msgf,
                            // text: "",
                            type: 'error',
                            icon: 'error',
                        })
                    }
                });
            
          }
        });
        return false;
    }
</script>