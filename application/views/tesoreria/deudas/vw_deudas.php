<?php
$vbaseurl=base_url();
date_default_timezone_set ('America/Lima');
$vuser=$_SESSION['userActivo'];
$f_hoy = date('Y-m-d');
?>
<style>
.bg-selection{
background-color: #F9F4BC;
}
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="content-wrapper">
    
    <?php include 'vw_deudas_modalAjustes.php'; ?>
    <?php include 'vw_deudas_modalAnular.php'; ?>
    <?php include 'vw_deudas_modalAsignar.php'; ?>
    <!-- 186716 -->
    <?php include 'vw_deudas_modalAjustesMantenimiento.php'; ?>
    <?php $this->load->view('facturacion/vw_documentos_modalCambiarItemDetalle', array('gestion' => $gestion )); ?>
    <section id="s-cargado" class="content">
        <div class="row">
            <div class="col-12 pt-2">
                <div class="card" id="divcard_deudas">
                    <div class="card-header">
                        <h1 class="card-title text-bold">Deudas</h1>
                    </div>
                    <div class="card-body">
                        <div id="divcar_form_historial mb-2">
                            <form id="tbdd_form_search_deudas" action="<?php echo $vbaseurl ?>deudas_individual/fn_filtrar_deudas" method="post" accept-charset="utf-8">
                                <div class="row">
                                    <div class="form-group has-float-label col-12 col-md-1">
                                        <select  class="form-control form-control-sm" id="cbosede" name="cbosede" placeholder="Filial">
                                            <option value="%">Todas</option>
                                            <?php
                                            foreach ($sedes as $filial) {
                                            $select=($vuser->idsede==$filial->id) ? "selected":"";
                                            echo "<option $select value='$filial->id'>$filial->nombre</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="cbosede"> Filial</label>
                                    </div>
                                    <div class="form-group has-float-label col-md-2">
                                        <select name="cboperiodo" id="cboperiodo" class="form-control form-control-sm">
                                            <option value="%">Todos</option>
                                            <?php
                                            foreach ($periodos as $per) {
                                            echo '<option value="'.$per->codigo.'">'.$per->nombre.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="cboperiodo">Periodo</label>
                                    </div>
                                    <div class="form-group has-float-label col-md-3">
                                        <select name="cboprograma" id="cboprograma" class="form-control form-control-sm">
                                            <option value="%">Todos</option>
                                            <?php
                                            foreach ($carrera as $carr) {
                                            echo '<option value="'.$carr->codigo.'">'.$carr->nombre.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="cboprograma">Programa de estudios</label>
                                    </div>
                                    <div class="form-group has-float-label col-md-2">
                                        <select name="cboturno" id="cboturno" class="form-control form-control-sm">
                                            <option value="%">Todos</option>
                                            <?php
                                            foreach ($turnos as $turn) {
                                            echo '<option value="'.$turn->codigo.'">'.$turn->nombre.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="cboturno">Turno</label>
                                    </div>
                                    <div class="form-group has-float-label col-md-1">
                                        <select name="cbociclo" id="cbociclo" class="form-control form-control-sm">
                                            <option value="%">Todos</option>
                                            <?php
                                            foreach ($ciclo as $cic) {
                                            echo '<option value="'.$cic->codigo.'">'.$cic->nombre.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="cbociclo">Semest.</label>
                                    </div>
                                    <div class="form-group has-float-label col-md-1">
                                        <select name="cboseccion" id="cboseccion" class="form-control form-control-sm">
                                            <option value="%">Todos</option>
                                            <?php
                                            foreach ($secciones as $sec) {
                                            echo '<option value="'.$sec->codigo.'">'.$sec->nombre.'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="cboseccion">Sección</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-md-2">
                                        <select data-currentvalue="" class="form-control form-control-sm" id="cboestado" name="cboestado" required="">
                                            <option value="%">Todos</option>
                                            <?php foreach ($estados as $estado) {?>
                                            <option value="<?php echo $estado->codigo ?>"><?php echo $estado->nombre ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="cboestado"> Estado</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-md-2">
                                        <select data-currentvalue='' class="form-control form-control-sm" id="cbobeneficio" name="cbobeneficio" placeholder="Periodo" required >
                                            <option value="%">Todos</option>
                                            <?php foreach ($beneficios as $beneficio) {?>
                                            <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="cbobeneficio"> Beneficio</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-md-3">
                                        <input autocomplete="off" class="form-control form-control-sm" type="text" placeholder="Apellidos y nombres" name="txtapenombres" id="txtapenombres">
                                        <label for="txtapenombres">Apellidos y nombres</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-md-2">
                                        <select name="cboconceptos" id="cboconceptos" class="form-control form-control-sm" required="">
                                            <option value="%">Conceptos#</option>
                                            <?php
                                            foreach ($gestion as $key => $gt) {
                                            echo "<option value='$gt->codgestion' >$gt->gestion</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="cboconceptos">Conceptos</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-md-2">
                                        <input autocomplete="off" class="form-control form-control-sm" type="text" placeholder="Cod. Deuda" name="txtcoddeuda" id="txtcoddeuda">
                                        <label for="txtcoddeuda">Cod. Deuda</label>
                                    </div>
                                    <div class="form-group col-12 col-md-2">
                                        <button type="submit" class="btn btn-sm btn-info">
                                        <i class="fas fa-search"></i>
                                        </button>
                                        <?php if (getPermitido("195")=='SI') { ?>
                                        <a type="button" class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modadddeuda">
                                            <i class="fa fa-plus"></i> Agregar
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tbmt_dtdeudas" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                  <thead>
                                    <tr class="bg-lightgray">
                                      <th>N°</th>
                                      <th>DEUDA</th>
                                      <th>DEUDOR</th>
                                      <th>CONCEPTO</th>
                                      <th>Mont.</th>
                                      <th>Ajuste</th>
                                      <th>Paga</th>
                                      <th>Sald.</th>
                                      <th>VENCE</th>
                                      <th>CRONOG.</th>
                                      <th>GRUPO</th>
                                      <th>OBS.</th>
                                      <th>OPCIONES</th>
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
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script type="text/javascript">

var cd1 = "<?php echo base64url_encode("ACTIVO") ?>";
var cd2 = "<?php echo base64url_encode("ANULADO") ?>";
$('.tbdatatable tbody').on('click', 'tr', function() {
    tabla = $(this).closest("table").DataTable();
    if ($(this).hasClass('selected')) {
        //Deseleccionar
        //$(this).removeClass('selected');
    } else {
        //Seleccionar
        tabla.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if (tabla.table().node().id=="tbmt_dtpagos"){
            var fila = $(this);
            var idboleta64 = fila.data('codboleta');
            var boleta = fila.data('boleta');
            var femision = fila.data('femision');
            var itembol = fila.data('itembl');
            fn_data_cobros_x_boleta(idboleta64, boleta, femision, itembol);
        }
    }
});
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});
$(document).ready(function() {
    $('.vw_select2').select2({
        dropdownParent: $('#modMantFechaPago'),
        width: 'resolve'
    });

    $('#divcardform_search_pagante').hide();
    $('#divcard_tabpagant').hide();

    $('#tbmt_dtdeudas').DataTable({
        "autoWidth": false,
        "pageLength": 50,
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
            "targets": 4, // your case first column
            "className": "text-right text-bold"
        },  
        {
            "targets": [5, 6, 7], // your case first column
            "className": "text-right"
        },  
        {
            "targets": 12, // your case first column
            "width": "90px"
        },  
        {
            targets: 8,
            render: function(data, type, row) {
                var datetime = moment(data, 'YYYY-MM-DD');
                var displayString = moment(datetime).format('DD/MM/YYYY');
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
// $('#modCronogramas').on('shown.bs.modal', function(e) {
//     $('#div_cronogramas input,select').removeClass('is-invalid');
//     $('#div_cronogramas .invalid-feedback').remove();
//     $('#div_cronogramas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     var btn = $(e.relatedTarget);
//     var calendario = btn.closest('.cfila').data('calendario');
//     var nombreCalendario = btn.closest('.cfila').data('nombrecal');
//     var codperiodo = btn.closest('.cfila').data('codperiodo');
//     var periodo = btn.closest('.cfila').data('periodo');
//     var codsede = btn.closest('.cfila').data('codsede');
//     var sede = btn.closest('.cfila').data('sede');
//     $.ajax({
//         url: base_url + "deudas_calendario_fechas/vw_modal_fechas",
//         type: 'post',
//         dataType: 'json',
//         data: {
//             vw_dcmd_calendario: calendario
//         },
//         success: function(e) {
//             $('#div_cronogramas #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//             } else {
//                 $('#div_cronogramas').html(e.vdata);
//                 $("#div_cronogramas #vw_cmd_crono_view #vw_cmd_crono_btnasignar").data('calendario', calendario);
//                 $("#modCronogramas #md_crono_sede").html(sede);
//                 $("#modCronogramas #md_crono_nombre").html(nombreCalendario);
//                 $("#modCronogramas #md_crono_periodo").html(periodo);
//                 $("#modCronogramas #md_crono_txt_codperiodo").val(codperiodo);
//                 $("#modCronogramas #md_crono_txt_codsede").val(codsede);
//                 $('#div_cronogramas #vw_cmd_crono_btnasignargp').data('calendario', calendario);
//                 $('#modCronogramas #vwbtn_update_fecha').hide();
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#div_cronogramas #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 
//                 icon: 'error',
//             })
//         }
//     });
// })
// $('#modCronogramas').on('hidden.bs.modal', function(e) {
//     $('#modCronogramas #vwbtn_update_fecha').hide();
// })
// $('#modGrupos').on('shown.bs.modal', function(e) {
//     $('#div_Grupos input,select').removeClass('is-invalid');
//     $('#div_Grupos .invalid-feedback').remove();
//     $('#div_Grupos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     var btn = $(e.relatedTarget);
//     var grupo = btn.closest('.rowcolor').data('calendario');
//     $.ajax({
//         url: base_url + "deudas_grupo/vw_modal_grupos",
//         type: 'post',
//         dataType: 'json',
//         data: {
//             vw_dcmd_grupo: grupo
//         },
//         success: function(e) {
//             $('#div_Grupos #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//             } else {
//                 $('#div_Grupos').html(e.vdata);
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#div_Grupos #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 
//                 icon: 'error',
//             })
//         }
//     });
// })
// $('#vw_dc_btnbuscar').click(function(event) {
//     var periodo = $('#vw_dc_cbperiodo').val();
//     var sede = $('#vw_dc_cbsede').val();
//     $('#vw_dc_divCalpanel input,select').removeClass('is-invalid');
//     $('#vw_dc_divCalpanel .invalid-feedback').remove();
//     if (periodo == "0") {
//         $("#vw_dc_divcalendarios").html("");
//         $('#vw_dc_cbperiodo').addClass('is-invalid');
//         $('#vw_dc_cbperiodo').parent().append("<div class='invalid-feedback'>Periodo Requerido</div>");
//         return;
//     }
//     $('#vw_dc_divCalpanel').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     $.ajax({
//         url: base_url + "deudas_calendario/fn_get_calendarios_xperiodo",
//         type: 'post',
//         dataType: 'json',
//         data: {
//             "vw_dc_cbperiodo": periodo,
//             "vw_dc_cbsede": sede
//         },
//         success: function(e) {
//             $('#vw_dc_divCalpanel #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//             } else {
//                 $("#vw_dc_divcalendarios").html("");
//                 $('#modMantCalendario').modal('hide');
//                 var nro = 0;
//                 var tabla = "";
//                 btnGrupos = '';
//                 tbCronogramas = $('#tbdc_dtCronogramas').DataTable();
//                 tbCronogramas.clear();
//                 $.each(e.vdata, function(index, val) {
//                     btnFechas = '<a class="dropdown-item" href="#" onclick="vw_abrir_modal_DuplicarCronogramaFilial($(this));return false"><i class="far fa-clone"></i> Duplicar a filial</a>';
//                     btnProyectarMatriculas = '<a class="dropdown-item" href="#" data-proyectarorigen="cronograma" onclick="vw_abrir_modal_proyectarMatriculas($(this));return false"><i class="fas fa-hourglass-start"></i> Proyectar Matrículas</a>';
//                     // btnGrupos = '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modGrupos"><i class="fas fa-user-friends"></i> Grupos</a>';
//                     var btnOpciones = '<div class="btn-group btn-group-sm p-0 " role="group">' +
//                         '<button class="bg-primary text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cog"></i>' +
//                         '</button>' +
//                         '<div class="dropdown-menu dropdown-menu-right">' +
//                         //btnGrupos +
//                         btnFechas + btnProyectarMatriculas +
//                         '</div>' +
//                         '</div>' +
//                         "<a class='badge badge-warning mx-1 p-1' href='#' data-toggle='modal' data-target='#modMantCalendario' data-accion='editar'><i class='fas fa-edit'></i></a>" +
//                         "<a class='badge badge-primary mx-1 p-1 text-white' href='#' onclick='fn_GenerarVincularDeudasConPagosAutomaticamente_PorCronograma($(this));return false'><i class='fas fa-sync-alt'></i></a>";
//                     var linkNombreCronograma = "<a href='#' onclick='vw_abrir_modal_cronogramaDetalle($(this));return false'>" + val['nombre'] + " (" + val['codigo'] + ")" + "</a>"
//                     var arrayCronogramas_new = [
//                         (index + 1),
//                         val['sede'],
//                         val['periodo'],
//                         linkNombreCronograma,
//                         val['inicia'],
//                         val['culmina'],
//                         "f",
//                         "g",
//                         btnOpciones
//                     ];
//                     var filaCronograma_new = tbCronogramas.row.add(arrayCronogramas_new).node();
//                     $(filaCronograma_new).attr('data-nombrecal', val['nombre']);
//                     $(filaCronograma_new).attr('data-calendario', val['codigo64']);
//                     $(filaCronograma_new).attr('data-codcalendario64', val['codigo64']);
//                     $(filaCronograma_new).attr('data-codcalendario', val['codigo']);
//                     $(filaCronograma_new).attr('data-cierreud', val['cierre_ud']);
//                     $(filaCronograma_new).attr('data-consolida', val['consolida_retiros']);
//                     $(filaCronograma_new).attr('data-codsede', val['codsede']);
//                     $(filaCronograma_new).attr('data-codperiodo', val['codperiodo']);
//                     $(filaCronograma_new).attr('data-sede', val['sede']);
//                     $(filaCronograma_new).attr('data-periodo', val['periodo']);
//                     $(filaCronograma_new).attr('data-inicia', val['inicia']);
//                     $(filaCronograma_new).attr('data-culmina', val['culmina']);
//                     $(filaCronograma_new).addClass("cfila");
//                 });
//                 tbCronogramas.draw();
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#vw_dc_divCalpanel #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 
//                 icon: 'error',
//             })
//         }
//     });
//     return false;
// });
// function fn_vw_add_fecha(btn) {
//     $('#nav-fechas-tab').tab('show')
//     $("#div_cronogramas #vw_cmd_crono_add").show();
//     $("#div_cronogramas #vw_cmd_crono_view").hide();
// }
// function fn_vw_upd_fecha(btn) {
//     var idfecha = btn.data('idfecha');
//     var descrip = btn.data('descripcion');
//     var fecha = btn.data('fecha');
//     $('#vw_cmda_txtcodigo').val(idfecha);
//     $('#vw_cmda_txtnombre').val(descrip);
//     $('#vw_cmda_txtinicia').val(fecha);
//     $('#nav-fechas-tab').tab('show')
//     $("#div_cronogramas #vw_cmd_crono_add").show();
//     $("#div_cronogramas #vw_cmd_crono_view").hide();
// }
//var items_cobro;
// function fn_vw_view_fecha(btn) {
//     if (btn.is(':checked')) {
//         $('#div_cronogramas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//         //items_cobro;
//         $('#nav-fechas-tab').tab('show')
//         $('#modCronogramas #vwbtn_update_fecha').show();
//         $('#modCronogramas #vwbtn_update_fecha').data('idfecha',btn.val());
//         $('#modCronogramas #vwbtn_update_fecha').data('descripcion',btn.data('descripcion'));
//         $('#modCronogramas #vwbtn_update_fecha').data('fecha',btn.data('fecha'));
//         $("#div_cronogramas #vw_cmdv_spnfecha").html(btn.data('fecha'));
//         $("#div_cronogramas #vw_cmdv_spndescripcion").html(btn.data('descripcion'));
//         $("#div_cronogramas #vw_cmd_crono_add").hide();
//         $("#div_cronogramas #vw_cmd_crono_view").show();
//         $("#div_cronogramas #vw_cmd_crono_view #vw_cmdv_item_agregar #vw_cmdi_txtcalfecha").val(btn.val())
//         var vidcalendario = $("#vw_cmda_txtcalendario").val();
//         $.ajax({
//             url: base_url + "Deudas_calendario_fechas_item/fn_get_itemscobro_x_fecha",
//             type: 'post',
//             dataType: 'json',
//             data: {
//                 vw_cmdi_txtcalfecha64: btn.val(),
//                 vw_cmdi_txtcal64: vidcalendario
//             },
//             success: function(e) {
//                 $('#div_cronogramas #divoverlay').remove();
//                 if (e.status == false) {
//                     $.each(e.errors, function(key, val) {
//                         $('#' + key).addClass('is-invalid');
//                         $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                     });
//                 } else {
//                     //PESTAÑA CONCEPTOS
//                     items_cobro = e.vdata;
//                     var nro = 0;
//                     var tabla = "";
//                     $.each(e.vdata, function(index, v) {
//                         nro++;
//                         tabla = tabla +
//                             '<div class="row cfila rowcolor ">' +
//                             '<div class="col-2 col-md-1 td">' + nro + '</div>' +
//                             '<div class="col-10 col-md-7 td">' + v['gestion'] + '</div>' +
//                             '<div class="col-4 col-md-2 td">' + v['monto'] + '</div>' +
//                             '<div class="col-4 col-md-1 td">' + v['repite'] + '</div>' +
//                             '<div class="col-4 col-md-1 td"></div>' +
//                             '</div>';
//                     });
//                     $("#vw_cmdv_items").html(tabla);
//                     //PESTAÑA GRUPOS
//                     nro = 0;
//                     tabla = "";
//                     $.each(e.vgrupos, function(index, v) {
//                         nro++;
//                         tabla = tabla +
//                             "<div class='row rowcolor' data-codperiodo='" + v['periodo'] +
//                             "' data-codcarrera='" + v['carrera'] + "' data-codciclo='" + v['ciclo'] +
//                             "' data-codturno='" + v['turno'] + "' data-codseccion='" + v['seccion'] + "'>" +
//                             "<div class='col-12 col-md-3'>" +
//                             "<div class='row'>" +
//                             "<div class='col-2 col-md-4 td'><span>" + nro + "</span></div>" +
//                             "<div class='col-10 col-md-8 td'><span>" + v['nomperiodo'] + "</span></div>" +
//                             "</div>" +
//                             "</div>" +
//                             "<div class='col-12 col-md-4 td'><span>" + v['nomcarrera'] + "</span></div>" +
//                             "<div class='col-4 col-md-2 td'><span>" + v['nomturno'] + " " + v['nomciclo'] + " - " + v['nomseccion'] + "</span></div>" +
//                             "<div class='col-4 col-md-2 td'><span>" + v['generadas'] + "/" + v['matriculas'] + "</span></div>" +
//                             "<div class='col-4 col-md-1 td text-center'>" +
//                             "<a href='#' onclick='fn_vw_view_deudas($(this));return false;' class='btn btn-primary btn-sm vw_gc_btndeudas'>Deudas</a>" +
//                             "</div>" +
//                             "</div>";
//                     });
//                     $("#div_fechas_GruposDeudas").html(tabla);
//                 }
//             },
//             error: function(jqXHR, exception) {
//                 var msgf = errorAjax(jqXHR, exception, 'text');
//                 $('#div_cronogramas #divoverlay').remove();
//                 Swal.fire({
//                     title: msgf,
//                     // text: "",
//                     
//                     icon: 'error',
//                 })
//             }
//         });
//     }
//     return false;
// }
// function fn_vw_add_itemfac(btn) {
//     $("#vw_cmdv_item_agregar").show();
//     $("#vw_cmdv_item").hide();
// }
// function vw_abrir_modal_DuplicarCronogramaFilial(boton) {
//     fila = boton.closest(".cfila");
//     $('#divModalDuplicarCronogramaParaFilial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     var vcodcalendario64 = fila.data("codcalendario64");
//     //var vcodcalendario = fila.data("codcalendario");
//     //7var calendario = fila.data('calendario');
//     var nombreCalendario = fila.data('nombrecal');
//     //var codperiodo = fila.data('codperiodo');
//     var periodo = fila.data('periodo');
//     var codsede = fila.data('codsede');
//     var sede = fila.data('sede');
//     $("#modDuplicaCalendarioParaFilial .modal-title").html(sede + " | " + periodo + " | Cronograma: <span class='text-primary'>" + nombreCalendario + "</span>");
//     $("#vw_mdcf_cbFilial").val(0);
//     $("#vw_mdcf_codCalendario64").val(vcodcalendario64);
//     $('#div_cronogramas #divoverlay').remove();
//     $('#modDuplicaCalendarioParaFilial').modal("show");
//     $('#divModalDuplicarCronogramaParaFilial #divoverlay').remove();
// }

// function fn_guardarDuplicarCronogramaFilial(boton) {
//     $('#divModalDuplicarCronogramaParaFilial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     var vcodcalendario64 = $("#vw_mdcf_codCalendario64").val();
//     var vcodFilial = $("#vw_mdcf_cbFilial").val();
//     $.ajax({
//         url: base_url + "deudas_calendario/fn_DuplicarCronogramaParaFilial",
//         type: 'post',
//         dataType: 'json',
//         data: {
//             txtcodcalendario64: vcodcalendario64,
//             txtcodfilial: vcodFilial
//         },
//         success: function(e) {
//             $('#divModalDuplicarCronogramaParaFilial #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//                 Swal.fire({
//                     title: "Error!",
//                     text: e.msg,
//                     icon: 'error',
//                 })
//             } else {
//                 Swal.fire({
//                     title: "Duplicado correctamente",
//                     text: e.msg,
//                     icon: 'success',
//                 })
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#divModalDuplicarCronogramaParaFilial #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 icon: 'error',
//             })
//         }
//     });
//     return false;
// }

// function fn_vw_save_itemfac() {
//     var vw_cmdi_cbgestion = $("#vw_cmdi_cbgestion").val();
//     var vw_cmdi_txtcodigo = $("#vw_cmdi_txtcodigo").val();
//     var vw_cmdi_chkrepite = ($("#vw_cmdi_chkrepite").prop('checked') == true) ? "SI" : "NO";
//     var vw_cmdi_txtcalfecha = $("#vw_cmdi_txtcalfecha").val();
//     var vw_cmdi_txtmonto = $("#vw_cmdi_txtmonto").val();
//     $.ajax({
//         url: base_url + "deudas_calendario_fechas_item/fn_insert_update",
//         type: 'post',
//         dataType: 'json',
//         //data: $('#div_cronogramas #vw_cmda_frmcalendario').serialize(),
//         data: {
//             fictxtcodigo: vw_cmdi_txtcodigo,
//             fictxtcal_fecha: vw_cmdi_txtcalfecha,
//             fictxtcodgestion: vw_cmdi_cbgestion,
//             fictxt_repite: vw_cmdi_chkrepite,
//             fictxt_monto: vw_cmdi_txtmonto
//         },
//         success: function(e) {
//             $('#div_cronogramas #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//             } else {
//                 $(".vw_rbfecha_cobro").change();
//                 $("#vw_cmdv_item_agregar").hide();
//                 $("#vw_cmdv_item").show();
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#div_cronogramas #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 
//                 icon: 'error',
//             })
//         }
//     });
//     return false;
// }
// function fn_vw_view_deudas(btn) {
//     $("#modDeudas").modal('show');
//     $('#modDeudas_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     var fila = btn.closest('.rowcolor');
//     //var grupo=btn.closest('.rowcolor').data('calendario');
//     var codperiodo = fila.data('codperiodo');
//     var codcarrera = fila.data('codcarrera');
//     var codciclo = fila.data('codciclo');
//     var codturno = fila.data('codturno');
//     var codseccion = fila.data('codseccion');
//     var vw_cmdi_txtcalfecha = $("#vw_cmdi_txtcalfecha").val();
//     $.ajax({
//         url: base_url + "deudas_grupo/fn_matriculados_x_grupo",
//         type: 'post',
//         dataType: 'json',
//         data: {
//             txtcodperiodo: codperiodo,
//             txtcodcarrera: codcarrera,
//             txtcodciclo: codciclo,
//             txtcodturno: codturno,
//             txtcodseccion: codseccion,
//             txtcalfecha: vw_cmdi_txtcalfecha
//         },
//         success: function(e) {
//             $('#modDeudas_content #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//             } else {
//                 var nro = 0;
//                 var tabla = "";
//                 var cuota = 0;
//                 var inputhead = "";
//                 $.each(e.items, function(index2, it) {
//                     inputhead = inputhead +
//                         '<div class="col-md-2 text-center">' +
//                         it['gestion'] +
//                         '</div>';
//                 });
//                 thead = '<div class="col-md-5">' +
//                     '<div class="row">' +
//                     '<div class="col-md-1 td">N°</div>' +
//                     '<div class="col-md-7 td">ESTUDIANTE</div>' +
//                     '<div class="col-md-4 td">PLAN ECON. / CUOTA</div>' +
//                     '</div>' +
//                     '</div>' +
//                     '<div class="col-md-7">' +
//                     '<div class="row">' +
//                     inputhead +
//                     '</div>' +
//                     '</div>';
//                 var coddeuda_negativo = 0;
//                 $.each(e.vdata, function(index, v) {
//                     nro++;
//                     cuota = Number.parseFloat(v['cuota']).toFixed(2);
//                     inputtext = "";
//                     $.each(e.items, function(index2, it) {
//                         itmat = v['items'][it['codigo']];
//                         monto = Number.parseFloat(itmat['monto']).toFixed(2);
//                         deuda = itmat['deuda'];
//                         if (deuda['codigo'] < 0) {
//                             edit = "1";
//                         } else {
//                             edit = "0";
//                         }
//                         inputtext = inputtext +
//                             '<div class="col-md-2">' +
//                             '<input type="number" step="0.01" class="form-control form-control-sm mt-1" data-edit="' + edit + '" data-codgestion="' + deuda['codgestion'] + '" data-saldo="' + deuda['saldo'] + '" data-itemcobro="' + it['codigo'] + '" data-coddeuda="' + deuda['codigo'] + '" value="' + monto + '" >' +
//                             '</div>';
//                     });
//                     vpagocontado = "";
//                     if (v['contado'] == "PC") {
//                         vpagocontado = " <a href='#' class='badge badge-success' title='Pensiones al Contado'> " + v['contado'] + "</a>";
//                     }
//                     tabla = tabla +
//                         '<div class="row cfila rowcolor rowdeuda"   data-codbeneficio="' + v['codbeneficio'] + '"  data-carnet="' + v['carne'] + '"  data-codmat="' + v['codigo64'] + '">' +
//                         '<div class="col-md-5">' +
//                         '<div class="row">' +
//                         '<div class="col-2 col-md-1 td">' + nro + '</div>' +
//                         '<div class="col-10 col-md-7 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + deuda['codigo'] +'</div>' +
//                         '<div class="col-6 col-md-2 td"><a class="vw_lm_lbplan" onclick="fn_vw_change_plan_eco($(this));return false;" title="Plan Económico: ' + v['beneficio'] + '" href="#">' + v['bene_sigla'] + '</a>' + vpagocontado + '</div>' +
//                         '<div class="col-6 col-md-2 td"><a class="vw_lm_lbplancuota" onclick="fn_vw_change_plan_eco($(this));return false;" title="Plan Económico" href="#">' + cuota + '</a></div>' +
//                         '</div>' +
//                         '</div>' +
//                         '<div class="col-md-7">' +
//                         '<div class="row">' +
//                         inputtext +
//                         '</div>' +
//                         '</div>' +
//                         '</div>';
//                 });
//                 $("#vw_mdd_estudiantes_head").html(thead);
//                 $("#vw_mdd_estudiantes").html(tabla);
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#modDeudas_content #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 
//                 icon: 'error',
//             })
//         }
//     });
// }
// function fn_vw_deuda_asignar_grupo(btn) {
//     $("#modGrupos_deudas").modal('show');
//     $('#modGrupos_deudas .modGrupos_deudas_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     var grupo = btn.data('calendario');
//     var calfecha = $("#vw_cmdi_txtcalfecha").val();
//     $.ajax({
//         url: base_url + "deudas_grupo/fn_grupos",
//         type: 'post',
//         dataType: 'json',
//         data: {
//             vw_dcmd_grupo: grupo,
//             vw_dcmd_calfecha: calfecha
//         },
//         success: function(e) {
//             $('#modGrupos_deudas .modGrupos_deudas_content #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//             } else {
//                 var nro = 0;
//                 var tabla = "";
//                 $.each(e.vdata, function(index, v) {
//                     nro++;
//                     tabla = tabla +
//                         "<div class='row rowcolor' data-codperiodo='" + v['periodo'] + "' data-codcarrera='" + v['carrera'] + "' data-codciclo='" + v['ciclo'] + "' data-codturno='" + v['turno'] + "' data-codseccion='" + v['seccion'] + "'>" +
//                         "<div class='col-4 col-md-1 td'><span><b>" + nro + "</b></span></div>" +
//                         "<div class='col-8 col-md-2 td'><span>" + v['nomperiodo'] + "</span></div>" +
//                         "<div class='col-8 col-md-4 td'><span>" + v['nomcarrera'] + "</span></div>" +
//                         "<div class='col-4 col-md-2 td'><span>" + v['nomturno'] + " " + v['nomciclo'] + " - " + v['nomseccion'] + "</span></div>" +
//                         "<div class='col-6 col-md-2 td'><span>" + v['generadas'] + "/" + v['matriculas'] + "</span></div>" +
//                         "<div class='col-6 col-md-1 td text-right'>" +
//                         "<a href='#' onclick='fn_vw_view_deudas($(this));return false;' class='btn btn-primary btn-sm vw_gc_btndeudas'>Deudas</a>" +
//                         "</div>" +
//                         "</div>";
//                 });
//                 $("#div_GruposDeudas").html(tabla);
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#modGrupos_deudas .modGrupos_deudas_content #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 
//                 icon: 'error',
//             })
//         }
//     });
// }
// function fn_insert_grupo_deuda(btn) {
//     $('#div_Grupos input,select').removeClass('is-invalid');
//     $('#div_Grupos .invalid-feedback').remove();
//     $('#div_Grupos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     $.ajax({
//         url: base_url + "deudas_grupo/fn_guardar" ,
//         type: 'post',
//         dataType: 'json',
//         data: $('#div_Grupos #frm_add_grupo').serialize(),
//         success: function(e) {
//             $('#div_Grupos #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//             } else {
//                 $("#div_Grupos #divcard_lista").show();
//                 $("#div_Grupos #divcard_form").hide();
//                 var nro=0;
//                 var tabla="";
//                 $.each(e.vdata, function(index, val) {
//                     nro++;
//                     tabla=tabla +
//                     "<div class='row rowcolor'>"+
//                         "<div class='col-4 col-md-1 td'>" +
//                               "<span><b>" + nro + "</b></span>" +
//                         "</div>" +
//                         "<div class='col-8 col-md-2 td'>" +
//                           "<span>" + val['nomperiodo'] + "</span>" +
//                         "</div> " +
//                         "<div class='col-8 col-md-4 td'>" +
//                             "<span>" + val['nomcarrera'] + "</span>" +
//                         "</div> " +
//                         "<div class='col-4 col-md-2 td'>" +
//                           "<span>" + val['nomciclo'] + " - "+val['nomseccion']+"</span>" +
//                         "</div> " +
//                         "<div class='col-6 col-md-2 td'>" +
//                           "<span>" + val['nomturno'] + "</span>" +
//                         "</div> " +
//                         '<div class="col-6 col-md-1 td text-right">' +

//                         '</div>' +
//                     '</div>';
//                 })
//                 $('#vw_dc_divdata').html(tabla);
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#div_Grupos #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 
//                 icon: 'error',
//             })
//         }
//     });
//     return false;
// };
//
var vw_lm_filaplan;

// function fn_vw_change_plan_eco(btn) {
//     vw_lm_filaplan = btn.closest(".rowcolor");
//     btn_cuota = vw_lm_filaplan.find(".vw_lm_lbplancuota");
//     btn_plan = vw_lm_filaplan.find(".vw_lm_lbplan");
//     codmat = vw_lm_filaplan.data("codmat");
//     codbene = vw_lm_filaplan.data("codbeneficio");
//     cuota = btn_cuota.html();
//     $("#vw_mdpe_cbbeneficio").val(codbene);
//     $("#vw_mdpe_monto").val(cuota);
//     $("#vw_mdpe_codmat").val(codmat);
//     $("#modPlanEconomico").modal("show");
// }
// $('#modPlanEconomico').on('hidden.bs.modal', function(e) {
//     vw_lm_filaplan = null;
// })
// $("#vw_mdpe_btnguardar").click(function(event) {
//     $('#modPlanEconomico .modPlanEconomico_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
//     vcodigo64 = $("#vw_mdpe_codmat").val();
//     vcodbeneficio = $("#vw_mdpe_cbbeneficio").val();
//     vbeneficio = $("#vw_mdpe_cbbeneficio").find(':selected').data('sigla');
//     vmonto = $("#vw_mdpe_monto").val();
//     $.ajax({
//         url: base_url + "matricula/fn_cambiar_plan_economico",
//         type: 'post',
//         dataType: 'json',
//         data: {
//             vw_mdpe_codmat: vcodigo64,
//             vw_mdpe_cbbeneficio: vcodbeneficio,
//             vw_mdpe_monto: vmonto
//         },
//         success: function(e) {
//             $('#modPlanEconomico .modPlanEconomico_content #divoverlay').remove();
//             if (e.status == false) {
//                 $.each(e.errors, function(key, val) {
//                     $('#' + key).addClass('is-invalid');
//                     $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
//                 });
//             } else {
//                 btn_cuota = vw_lm_filaplan.find(".vw_lm_lbplancuota");
//                 btn_plan = vw_lm_filaplan.find(".vw_lm_lbplan");
//                 vw_lm_filaplan.data("codbeneficio", vcodbeneficio);
//                 cuota = Number.parseFloat($("#vw_mdpe_monto").val()).toFixed(2);
//                 btn_plan.html(vbeneficio);
//                 btn_cuota.html(cuota);
//                 $("#modPlanEconomico").modal("hide");
//             }
//         },
//         error: function(jqXHR, exception) {
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             $('#modGrupos_deudas .modGrupos_deudas_content #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 
//                 icon: 'error',
//             })
//         }
//     });
// });
// $(document).on("blur", ".rowdeuda div input", function(event) {
//     var valor = $(this).val();
//     if ($(this).data('saldo') != $(this).val()) {
//         $(this).data('edit', '1');
//     } else {
//         $(this).data('edit', '0');
//     }
//     // console.log("valor", valor);
// })
$("#vw_mdd_btnguardar").click(function(event) {
    event.preventDefault();
    $('#modDeudas_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var vw_cmdi_txtcalfecha = $("#vw_cmdi_txtcalfecha").val();
    array_deudas = [];
    var nerror = 0;
    var edits = 0;
    var rc = 0;
    $('#vw_mdd_estudiantes input').each(function() {
        rc++;
        fila = $(this).closest('.cfila');
        var isedit = $(this).data("edit");
        var carnet = fila.data("carnet");
        var codmat = fila.data("codmat");
        var codgestion = $(this).data("codgestion");
        var monto = $(this).val();
        var coddeuda = $(this).data("coddeuda");
        var saldo = $(this).data("saldo");
        var itemcobro = $(this).data("itemcobro");
        if (isedit == "1") {
            /*if (($(this).val() < 0)||($(this).val() > 20)) {
            nerror++
            }
            else{*/
            //$pagante, $matricula, $gestion, $monto, $fcreacion, $fvence, $vouchercod, $mora, $fprorroga, $repite, $observacion, $saldo
            var myvals = [coddeuda, carnet, codmat, codgestion, monto, saldo, itemcobro];
            array_deudas.push(myvals);
            edits++;
        }
    });
    if (edits > 0) {
        $.ajax({
            url: base_url + 'deudas_grupo/fn_insert_update_deuda_grupo',
            type: 'post',
            dataType: 'json',
            data: {
                vw_cmdi_txtcalfecha64: vw_cmdi_txtcalfecha,
                filas: JSON.stringify(array_deudas),
            },
            success: function(e) {
                $('#modDeudas_content #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        
                        title: 'ERROR, NO se guardó cambios',
                        text: e.msg,
                        backdrop: false,
                    });
                } else {
                    $('#vw_mdd_estudiantes input').each(function() {
                        if (($(this).data('edit') == '1') && ($(this).data('coddeuda') < 0)) {
                            $(this).data('coddeuda', e.ids[$(this).data('coddeuda')]);
                            $(this).data('edit', '0');
                        }
                    });
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'ÉXITO, Se guardó cambios',
                        text: "Lo cambios fueron guardados correctamente",
                        backdrop: false,
                    });
                }
            },
            error: function(jqXHR, exception) {
                $('#modDeudas_content #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    
                    icon: 'error',
                    title: 'ERROR, NO se guardó cambios',
                    text: msgf,
                    backdrop: false,
                });
            },
        });
    } else {
        Swal.fire({
            type: 'success',
            icon: 'success',
            title: 'ÉXITO, Se guardó cambios (M)',
            text: "Lo cambios fueron guardados correctamente",
            backdrop: false,
        });
        $('#modDeudas_content #divoverlay').remove();
    }
    /*}
    else{
    Swal.fire({
    
    title: 'ERROR, Notas Invalidas',
    text: "Existen " + nerror + " error(es): NOTA NO VÁLIDA (Rojo)",
    backdrop:false,
    });
    $('#divboxevaluaciones #divoverlay').remove();
    }*/
    return false;
});
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///DEUDAS - POR ESTUDIANTE
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
///////////////////////////
var vpermiso196 = '<?php echo getPermitido("196"); ?>';
var vpermiso197 = '<?php echo getPermitido("197"); ?>';
var vpermiso198 = '<?php echo getPermitido("198"); ?>';
var vpermiso199 = '<?php echo getPermitido("199"); ?>';
$('#tbdd_form_search_deudas').submit(function() {
    $('#tbdd_form_search_deudas input,select,textarea').removeClass('is-invalid');
    $('#tbdd_form_search_deudas .invalid-feedback').remove();
    $('#divcard_deudas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    
    $.ajax({
        url: $('#tbdd_form_search_deudas').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#tbdd_form_search_deudas').serialize(),
        success: function(e) {
            tbDeudas = $('#tbmt_dtdeudas').DataTable();
            tbDeudas.clear();
            $('#divcard_deudas #divoverlay').remove();
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
                var nro = 0;
                var tabla = "";
                var bgcolor = "";
                var badgecolor = "";
                var btnupdate = "";
                var dropdownestado = "";
                var btnvincular = "";
                var btnEliminarDeuda ="";
                $.each(e.vdatahst, function(index, val) {
                    var bgsaldo = " text-success";
                    if ((val['saldo'] > 0) && (val['vencida'] == "SI")) {
                        bgsaldo = "text-danger";
                    } else if ((val['saldo'] > 0) && (val['vencida'] == "NO")) {
                        bgsaldo = "text-primary";
                    }
                    nro++;
                    switch (val['estadodeuda']) {
                        case "ACTIVO":
                            bgcolor = "btn-success";
                            badgecolor = "badge-success";
                            vEstadoText="<i class='far fa-check-circle'></i>";
                            break;
                        case "ANULADO":
                            bgcolor = "btn-danger";
                            badgecolor = "badge-danger";
                            bgsaldo=bgsaldo + " text-strike ";
                            vEstadoText="<i class='fas fa-ban'></i>";
                            break;
                        default:
                            bgcolor = "btn-success";
                            badgecolor = "badge-success";
                    }
                    if (vpermiso196 == "SI") {
                        // btnupdate = '<a class="badge badge-warning py-1 ml-1" href="#" onclick="fn_vw_editar_deuda($(this));return false;" title="Editar Deuda" >' +
                        //     '<i class="fas fa-pencil-alt fa-lg "></i>' +
                        //     '</a>';
                        btnupdate = '<a href="#" onclick="fn_vw_editar_deuda($(this));return false;" class="dropdown-item" title="Editar Deuda"><i class="fas fa-pencil-alt "></i> Editar</a>'
                    }
                    if (vpermiso198 == "SI") {
                        btnvincular = '<a class="badge badge-primary py-1 ml-1 text-white" href="#" onclick="fn_vw_vincular_pagos($(this));return false;" title="Vincular Pagos" >' +
                            '<i class="far fa-money-bill-alt fa-lg"></i>' +
                            '</a>';
                    }
                    if (vpermiso197 == "SI") {
                        dropdownestado = '<div class="btn-group btn-group-sm dropleft m-0 p-0">' +
                            '<button title="' + val['estadodeuda'] + '" class="btn ' + bgcolor + ' btn-sm dropdown-toggle px-1 py-0" type="button" data-toggle="dropdown" ' +
                            'aria-haspopup="true" aria-expanded="false">' +
                             vEstadoText +
                            '</button> ' +
                            '<div class="dropdown-menu">' +
                            '<a href="#" onclick="fn_update_estado($(this));" class="btn-cestado dropdown-item" data-color="btn-success" data-ie="' + cd1 + '">Activo</a>' +
                            '<a href="#" class="dropdown-item"  data-toggle="modal" data-target="#vw_deudaModalAjustes"><i class="fas fa-wrench mr-1"></i>Ajustes</a>';
                            
                            dropdownestado =  dropdownestado + '</div>';        

                    } else {
                        dropdownestado = '<small title="' + val['estadodeuda'] + '" class="badge ' + badgecolor + ' p-2">' + vEstadoText + '</small>';
                    }
                    if (vpermiso199 == "SI") {
                        btnEliminarDeuda =   '<a href="#" onclick="fn_delete_deuda($(this))" class="dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>';
                    }      
                    dropdownOpciones = '<div class="btn-group btn-group-sm dropleft m-0 p-0">' +
                            '<button title="' + val['estadodeuda'] + '" class="btn btn-primary btn-sm dropdown-toggle px-1 py-0" type="button" data-toggle="dropdown" ' +
                            'aria-haspopup="true" aria-expanded="false">' +
                             '<i class="fas fa-cog"></i>' +
                            '</button> ' +
                            '<div class="dropdown-menu">' +
                                 btnupdate +
                                '<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modanuladeuda">Anulado</a>' +
                                btnEliminarDeuda + 
                                '</div>' +
                            '</div>';

                    var grupodeuda = val['codperiodo'] + " " + val['sigla'] + " - " + val['ciclo'];
                   
                    vTextObservacion=val['observacion'];
                    vTextAnulacion=val['motivoanulacion'];


                    vDescuentoAjuste='<a href="#"  data-toggle="modal" data-target="#vw_deudaModalAjustes">' + parseFloat(val['descuento']).toFixed(2) + '<i class="fas fa-wrench"></i>';


                    if ($.trim(vTextAnulacion)!="") vTextObservacion=vTextObservacion + "Anulado: " + vTextAnulacion;
                        var paga=parseFloat(val['monto']) + parseFloat(val['descuento']) - parseFloat(val['saldo']);
                        var arrayDeuda_new = [
                            (index + 1),
                            val['codigo'] ,
                            val['carnet'] + " " + val['paterno'] + " " + val['materno'] + " " + val['nombres'],
                            val['gestion'],
                            "<span class='fmonto'>" + parseFloat(val['monto']).toFixed(2) + "</span> " ,
                            "<span class='fdescuento'>" + vDescuentoAjuste + "</span> " ,
                            "<span class='fpago'>" + parseFloat(paga).toFixed(2) + "</span> " ,
                            "<span class='fsaldo " + bgsaldo + "'>" + parseFloat(val['saldo']).toFixed(2) + "</span> ",
                            val['fvence'],
                            val['calendario'],
                            val['codperiodo']  + " " + val['sigla'] + " - " + val['ciclo'] ,
                            vTextObservacion,
                            dropdownestado + btnvincular +  dropdownOpciones 
                            
                        ];


                        var filaDeuda_new = tbDeudas.row.add(arrayDeuda_new).node();
                        $(filaDeuda_new).attr('data-codinscripcion64', val['codinscripcion64'] );
                        $(filaDeuda_new).attr('data-codmatricula', val['idmatricula'] );
                        $(filaDeuda_new).attr('data-codmatricula64', val['idmatricula64'] );
                        $(filaDeuda_new).attr('data-cdeuda', val['codigo64'] );
                        
                        $(filaDeuda_new).attr('data-coddeuda', val['codigo'] );
                        $(filaDeuda_new).attr('data-coddeuda64', val['codigo64'] );
                        $(filaDeuda_new).attr('data-estadodeuda', val['estadodeuda'] );
                    
                        $(filaDeuda_new).attr('data-apellidos', val['paterno'] + ' ' + val['materno'] );
                        $(filaDeuda_new).attr('data-alumno', val['nombres'] );

                        $(filaDeuda_new).attr('id', val['codigo64'] );
                        $(filaDeuda_new).attr('data-carnet', val['carnet'] );
                        $(filaDeuda_new).attr('data-gestion', val['gestion'] );
                        $(filaDeuda_new).attr('data-codgestion', val['codgestion'] );
                        $(filaDeuda_new).attr('data-cronograma', val['calendario'] );
                        $(filaDeuda_new).attr('data-grupodeuda', val['grupodeuda'] );
                        $(filaDeuda_new).attr('data-fechaven', val['fecvence'] );
                        $(filaDeuda_new).attr('data-deudamonto', parseFloat(val['monto']).toFixed(2));
                        $(filaDeuda_new).attr('data-saldodeuda', parseFloat(val['saldo']).toFixed(2));
                        $(filaDeuda_new).attr('data-deudacancelado', parseFloat(paga).toFixed(2));
                        $(filaDeuda_new).attr('data-deudaajuste', parseFloat(val['descuento']).toFixed(2));
                        $(filaDeuda_new).addClass("cfila");
                })
                tbDeudas.draw();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard_deudas #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                
                icon: 'error',
            })
        }
    });
    return false;
});

$('#btn_show_frm_search').click(function() {
    $('#divcardform_adddeuda').hide();
    $('#divcardform_search_pagante').show();
    $('#fitxtdniapenomb').focus();
});

$("#modadddeuda").on('hidden.bs.modal', function() {
    $('#divcardform_adddeuda').show();
    $('#divcardform_search_pagante').hide();
    $('#frm_addpagante')[0].reset();
    $('#ficcodmatricula').html('<option value="">Sin Asignar</option>');
    $('#ficcod_deuda').val("0");
    $('#divcard_button').show();
    $('#ficcodpagante').attr('readonly', false);
    $('#ficapenomde').attr('readonly', false);
    $('#divcard_nompagante').removeClass('col-lg-8');
    $('#divcard_nompagante').addClass('col-lg-5');
});
$('#form_search_pagante').submit(function() {
    $('#divres_paghistorial').html("");
    $('#form_search_pagante input,select').removeClass('is-invalid');
    $('#form_search_pagante .invalid-feedback').remove();
    $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divmodaladd #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $('#divres_paghistorial').html("");
                $('#divcard_tabpagant').show();
                var nro = 0;
                var tabla = "";
                $.each(e.vdata, function(index, val) {
                    nro++;
                    tabla = tabla +
                        "<div class='row rowcolor' data-matric='" + val['idmat'] + "' data-codpag='" + val['carne'] + "' >" +
                        "<div class='col-4 col-md-1 td'>" +
                        "<span><b>" + nro + "</b></span>" +
                        "</div>" +
                        "<div class='col-8 col-md-2 td'>" +
                        "<span>" + val['dni'] + "</span>" +
                        "</div> " +
                        "<div class='col-8 col-md-7 td'>" +
                        "<span class='nompagante'>" + val['apepaterno'] + " " + val['apematerno'] + " " + val['nombre'] + "</span>" +
                        "</div> " +
                        '<div class="col-4 col-md-2 td text-center">' +
                        '<a href="#" type="button" title="selecciona" onclick="fn_select_pagante($(this));return false;">' +
                        '<i class="fas fa-check fa-lg"></i>' +
                        '</a>' +
                        '</div>' +
                        '</div>';
                })
                $('#divres_paghistorial').html(tabla);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divmodaladd #divoverlay').remove();
            $('#divres_paghistorial').html(msgf);
        }
    });
    return false;
});

function fn_select_pagante(btn) {
    var div = btn.parents('.rowcolor');
    var codmat = div.data("matric");
    var codpag = div.data("codpag");
    dnompagant = div.find('.nompagante');
    $('#ficcodpagante').val(codpag);
    // $('#ficcodmatricula').val(codmat);
    $('#ficapenomde').val(dnompagant.html());
    $('#divcardform_search_pagante').hide();
    // $('#divcard_tabpagant').hide();
    $('#divcardform_adddeuda').show();
    $('#divmodaladd').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "deudas_individual/fn_get_matriculas_pagante",
        type: 'post',
        dataType: 'json',
        data: {
            vw_fcb_txtcodpagante: codpag,
        },
        success: function(e) {
            $('#divmodaladd #divoverlay').remove();
            if (e.status == false) {} else {
                $('#ficcodpagante').attr('readonly', true);
                $('#ficapenomde').attr('readonly', true);
                $('#ficcodmatricula').html(e.vmatriculas);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divmodaladd #divoverlay').remove();
            $('#divres_paghistorial').html(msgf);
        }
    })
}
$('#lbtn_guardar_deuda').click(function() {
    $('#frm_addpagante input,select,textarea').removeClass('is-invalid');
    $('#frm_addpagante .invalid-feedback').remove();
    $('#divmodaladd').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $('#frm_addpagante').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#frm_addpagante').serialize(),
        success: function(e) {
            $('#divmodaladd #divoverlay').remove();
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
            } else {
                // $('#modadddeuda').modal('hide');
                if (e.estado == "INSERTAR") {
                    $('#ficcodpagante').val("");
                    $('#ficcodpagante').attr('readonly', false);
                    $('#ficapenomde').attr('readonly', false);
                    $('#ficcodmatricula').html('<option value="">Sin Asignar</option>');
                    $('#ficapenomde').val("");
                    $('#frm_addpagante')[0].reset();
                } else {
                    $('#modadddeuda').modal('hide');
                    var vidcodigo = $('#frm_addpagante #ficcod_deuda').val();
                    var fila = $('#' + vidcodigo);
                    var vdmonto = $('#frm_addpagante #ficmonto').val();
                    var vdsaldo = $('#frm_addpagante #ficsaldo').val();
                    fila.find('.fmonto').html(parseFloat(vdmonto).toFixed(2));
                    fila.find('.fsaldo').html(parseFloat(vdsaldo).toFixed(2));
                    // $('#tbdd_form_search_deudas').submit();
                }
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: e.msg,
                    // text: 'Se ha actualizado el estado',
                    backdrop: false,
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodaladd #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                
                icon: 'error',
            })
        }
    });
    return false;
});

function fn_vw_editar_deuda(btn) {
    var fila = btn.closest('.cfila');
    var codigo = fila.data('cdeuda');
    $('#divcard_deudas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "deudas_individual/fn_get_deuda_codigo",
        type: 'post',
        dataType: 'json',
        data: {
            vw_fcb_txtcodigo: codigo,
        },
        success: function(e) {
            $('#divcard_deudas #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Error!",
                    text: "No se encontraron datos",
                    
                    icon: 'error',
                })
            } else {
                $('#ficcodpagante').attr('readonly', true);
                $('#ficapenomde').attr('readonly', true);
                $('#modadddeuda').modal();
                $('#divcard_button').hide();
                $('#ficcodmatricula').html(e.vmatriculas);
                $('#divcard_nompagante').removeClass('col-lg-5');
                $('#divcard_nompagante').addClass('col-lg-8');
                $('#ficcod_deuda').val(e.vdata['coddeuda64']);
                $('#ficcodpagante').val(e.vdata['pagante']);
                $('#ficcodmatricula').val(e.vdata['codmat64']);
                $('#ficapenomde').val(e.vdata['paterno'] + " " + e.vdata['materno'] + " " + e.vdata['nombres']);
                $('#ficbgestion').val(e.vdata['codgestion']);
                $('#ficmonto').val(parseFloat(e.vdata['monto']).toFixed(2));
                $('#ficmora').val(parseFloat(e.vdata['mora']).toFixed(2));
                $('#ficfechcreacion').val(e.vdata['fecha']);
                $('#ficfechvence').val(e.vdata['fvence']);
                $('#ficfechprorrog').val(e.vdata['fprorroga']);
                $('#ficvouchcodigo').val(e.vdata['voucher']);
                $('#ficcodigofecitem').val(e.vdata['fitem']);
                $('#ficrepitecic').val(e.vdata['repciclo']);
                $('#ficsaldo').val(parseFloat(e.vdata['saldo']).toFixed(2));
                $('#ficobservacion').val(e.vdata['observacion']);
                $('#divcardform_search_pagante').hide();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divcard_deudas #divoverlay').remove();
            $('#divres_paghistorial').html(msgf);
        }
    })
}





function fn_vw_vincular_pago(btn) {
    $("#modPagos_asignar").modal('show');
    $('#modPagos_asignar .modPagos_asignar_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    //vw_md_pagos_estudiante
    fila = btn.closest(".rowcolor");
    var cdetalle = fila.data('coddetalle');
    var vcodmatricula = $("#vw_mdp_txtcodmatricula64").val();
    var cdeuda = $("#vw_mdp_txtcoddeuda").val();
    $.ajax({
        url: base_url + "tesoreria/deudas/acciones/vincular/detalle",
        type: 'post',
        dataType: 'json',
        data: {
            coddetalle: cdetalle,
            coddeuda: cdeuda,
            codmatricula: vcodmatricula
        },
        success: function(e) {
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Ocurrio un error",
                    text: e.msg,
                    
                    icon: 'error',
                })
            } else {
                fila.find(".vw_mdp_spcoddeuda").html(e.coddeuda);
                botonLink = fila.find(".vw_mdp_linkdeuda");
                botonLink.html("<i class='fas fa-unlink'></i>");
                botonLink.attr('onclick', "fn_vw_desvincular_pago($(this));return false;");
                botonLink.removeClass("badge-success");
                botonLink.addClass("badge-danger");
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                
                icon: 'error',
            })
        }
    });
}

function fn_vw_desvincular_pago(btn) {
    $("#modPagos_asignar").modal('show');
    $('#modPagos_asignar .modPagos_asignar_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    //vw_md_pagos_estudiante
    fila = btn.closest(".rowcolor");
    var cdetalle = fila.data('coddetalle');
    var cdeuda = $("#vw_mdp_txtcoddeuda").val();
    $.ajax({
        url: base_url + "tesoreria/deudas/acciones/desvincular/detalle",
        type: 'post',
        dataType: 'json',
        data: {
            coddetalle: cdetalle,
            coddeuda: cdeuda
        },
        success: function(e) {
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Ocurrio un error",
                    text: e.msg,
                    
                    icon: 'error',
                })
            } else {
                fila.find(".vw_mdp_spcoddeuda").html("");
                botonLink = fila.find(".vw_mdp_linkdeuda");
                botonLink.html("<i class='fas fa-link mr-1'></i>Vincular");
                botonLink.attr('onclick', "fn_vw_vincular_pago($(this));return false;");
                botonLink.removeClass("badge-danger");
                botonLink.addClass("badge-success");
                botonLink.attr('title', "Vincular");
                //$('#tbdd_form_search_deudas').submit();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                
                icon: 'error',
            })
        }
    });
}
/////////////////////////////
function fn_update_estado(btn) {
    var fila=btn.closest(".cfila");
    var iddeuda = fila.data('cdeuda');
    var ie = btn.data('ie');
    var color = btn.data('color');
    var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
    var texto = btn.html();
    $('#divcard_deudas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'deudas_individual/fn_cambiarestado_deuda',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-iddeuda': iddeuda,
            'ce-nestado': ie
        },
        success: function(e) {
            $('#divcard_deudas #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    
                    icon: 'error',
                    title: 'Error!',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Felicitaciones, estado actualizado',
                    text: 'Se ha actualizado el estado',
                    backdrop: false,
                })
                btdt.removeClass('btn-danger');
                btdt.removeClass('btn-success');
                btdt.addClass(color);
                btdt.html(texto);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard_deudas #divoverlay').remove();
            Swal.fire({
                
                icon: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
}
$("#modanuladeuda").on('show.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var fila = rel.closest('.cfila');
    var coddeuda = fila.data('coddeuda64');
    var estado = fila.data('estadodeuda');
    var color = fila.data('color');
    $('#ficdeudacodigo').val(coddeuda);
    $('#ficdeudaestado').val(cd2);
    //$('#lbtn_anula_deuda').data('coloran', color);
});

$('#lbtn_anula_deuda').click(function() {
    var color = $(this).data('coloran');
    // alert("Mensaje");
    $('#form_anuladeuda input,select,textarea').removeClass('is-invalid');
    $('#form_anuladeuda .invalid-feedback').remove();
    $('#divmodalanulad').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $('#form_anuladeuda').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#form_anuladeuda').serialize(),
        success: function(e) {
            $('#divmodalanulad #divoverlay').remove();
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
            } else {
                $('#modanuladeuda').modal('hide');
                var btdtan = $('#btn_stanul' + e.iddeuda).parents(".btn-group").find('.dropdown-toggle');
                var textoan = $('#btn_stanul' + e.iddeuda).html();
                btdtan.removeClass('btn-danger');
                btdtan.removeClass('btn-success');
                btdtan.addClass(color);
                btdtan.html(textoan);
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Felicitaciones, deuda anulada',
                    text: 'Se ha anulado la deuda',
                    backdrop: false,
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalanulad #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                
                icon: 'error',
            })
        }
    });
    return false;
});


function fn_delete_deuda(btn) {
    $('#divcard_deudas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    
    var fila = btn.parents(".cfila");
    // var carne=fila.find('.cell-carne').html();
    //************************************
    var cdeuda = fila.data("coddeuda64");
    Swal.fire({
        title: "Precaución",
        text: "Se eliminarán todos los datos con respecto a esta DEUDA ",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $.ajax({
                url: base_url + 'deudas_individual/fn_eliminar',
                type: 'post',
                dataType: 'json',
                data: {
                    'id-deuda': cdeuda
                },
                success: function(e) {
                    $('#divcard_deudas #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            
                            icon: 'error',
                            title: 'Error!',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Eliminación correcta',
                            text: 'Se ha eliminado la deuda',
                            backdrop: false,
                        })
                        fila.remove();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divcard_deudas #divoverlay').remove();
                    Swal.fire({
                        
                        icon: 'error',
                        title: 'Error',
                        text: msgf,
                        backdrop: false,
                    })
                }
            });
        } else {
            $('#divcard_deudas #divoverlay').remove();
        }
    });
    return false;
}



function fn_data_cobros(btn) {
    var fila = btn.parents(".rowcolor");
    var idboleta64 = fila.data('codboleta');
    var boleta = fila.data('boleta');
    var femision = fila.data('femision');
    var itembol = fila.data('itembl');
    fn_data_cobros_x_boleta(idboleta64, boleta, femision, itembol);
}
$('#modPagos_asignar').on('hidden.bs.modal', function(e) {
    tbcobrospg = $('#tbmt_dtcobros').DataTable();
    $('#divcardboleta_detalle').addClass('d-none');
    tbcobrospg.clear();
    tbcobrospg.draw();
})
</script>