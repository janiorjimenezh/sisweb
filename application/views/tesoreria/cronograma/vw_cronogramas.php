<?php
$vbaseurl=base_url();
date_default_timezone_set ('America/Lima');
$vuser=$_SESSION['userActivo'];
$f_hoy = date('Y-m-d');
?>
<style>
/*.bg-selection{
background-color: #F9F4BC;
}*/

</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet"> -->

<!--<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">-->
<div class="content-wrapper">
    <?php include 'vw_modals_cronograma_detalle.php'; ?>
    <?php include 'vw_modals_cronograma_seleccionar_grupos.php'; ?>
    <?php include 'vw_modals_cronograma_fecha_mantenimiento.php'; ?>
    <?php include 'vw_modals_cronogramas.php'; ?>
    
    <section id="s-cargado" class="content">
        <?php if (getPermitido("106")=='SI') { ?>
                
            <div id="vw_dc_divCalpanel" class="card mt-2">
                <div class="card-header">
                    <h1 class="card-title text-bold">Calendario de Pagos (Cronograma)</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group has-float-label col-10 col-sm-10  col-md-3">
                            <select name="vw_dc_cbsede" id="vw_dc_cbsede" class="form-control form-control-sm">
                                
                                <?php
                                $codsede=$_SESSION['userActivo']->idsede;
                                foreach ($sedes as $sede) {
                                $selsede=($codsede==$sede->id)?"selected":"";
                                echo "<option $selsede value='$sede->id'>$sede->nombre </option>";
                                } ?>
                            </select>
                            <label for="vw_dc_cbsede">Filial</label>
                        </div>
                        <div class="form-group has-float-label col-10 col-sm-10  col-md-3">
                            <select name="vw_dc_cbperiodo" id="vw_dc_cbperiodo" class="form-control form-control-sm">
                                <option value="0">Selecciona periodo</option>
                                <?php foreach ($periodos as $periodo) {
                                echo "<option  value='$periodo->codigo'>$periodo->nombre </option>";
                                } ?>
                            </select>
                            <label for="vw_dc_cbperiodo">Periodo</label>
                        </div>
                        
                        
                        <div class="col-2 col-sm-2 col-md-1">
                            <button id="vw_dc_btnbuscar" type="button" class="btn btn-block btn-sm btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="col-12 col-md-5 text-right">
                            <a href="#" class="btn btn-sm btn-outline-primary" data-accion='nuevo' data-toggle="modal" data-target="#modMantCalendario">
                                <i class="fas fa-plus mr-1"></i>  Crear
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tbdc_dtCronogramas" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                              <thead>
                                <tr class="bg-lightgray">
                                  <th>N°</th>
                                  <th>FILIAL</th>
                                  <th>PERIODO</th>
                                  <th>NOMBRE</th>
                                  <th>INICIA</th>
                                  <th>FIN</th>
                                  <th>VENCIMIENTOS</th>
                                  <th>EVALUACIONES</th>
                                  <th>GRUPOS</th>
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
                
        <?php } ?>
        
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

    var tbcg_dtGrupos = $('#tbcg_dtGrupos').DataTable({
        "autoWidth": false,
        "pageLength": 13,
        "lengthChange": false,
        scrollCollapse: true,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, // your case first column
            "className": "text-right rowhead",
            "width": "8px"
        }],
        dom:"<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "fnDrawCallback": function (oSettings) {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover',
                html: true
            });
            $('[data-toggle="tooltip"]').tooltip();
        }
    });


    var tbcg_dtFechas = $('#tbce_dtFechas').DataTable({
        "autoWidth": false,
        "pageLength": 20,
        "lengthChange": false,
        "bPaginate": false, 
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, // your case first column
            "className": "text-right rowhead",
            "width": "8px"
        },
        {
            targets: 1,
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
        dom: "<'row'<'col-sm-12'tr>>" ,
        "fnDrawCallback": function (oSettings) {
            $('[data-toggle="tooltip"]').tooltip();
        }

    });
  

    $('#tbdc_dtCronogramas').DataTable({
       "autoWidth": false,
        "pageLength": 25,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [
            {
            "targets": 0, // your case first column
            "className": "text-right rowhead",
            "width": "8px"
            },
            {
            "targets": 7, // your case first column
            "className": "text-center"
            },
            {   
                targets: [4,5], 
                render: function ( data, type, row ) {
                  var datetime = moment(data, 'YYYY-MM-DD');
                  var displayString = moment(datetime).format('DD/MM/YYYY');
                  if ( type === 'display' || type === 'filter' ) {
                    return displayString;
                  } else {
                    return datetime; // for sorting
                  }
                }
            }
        ],
        "fnDrawCallback": function (oSettings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('#tbcg_dtGruposSeleccionar').DataTable({
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
        }],
    });

});






$('#modCronogramas').on('shown.bs.modal', function(e) {
    $('#div_cronogramas input,select').removeClass('is-invalid');
    $('#div_cronogramas .invalid-feedback').remove();
    $('#div_cronogramas').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var btn = $(e.relatedTarget);
    var calendario = btn.closest('.cfila').data('calendario');
    var nombreCalendario = btn.closest('.cfila').data('nombrecal');
    var codperiodo = btn.closest('.cfila').data('codperiodo');
    var periodo = btn.closest('.cfila').data('periodo');
    var codsede = btn.closest('.cfila').data('codsede');
    var sede = btn.closest('.cfila').data('sede');
    
    $.ajax({
        url: base_url + "deudas_calendario_fechas/vw_modal_fechas",
        type: 'post',
        dataType: 'json',
        data: {
            vw_dcmd_calendario: calendario
        },
        success: function(e) {
            $('#div_cronogramas #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $('#div_cronogramas').html(e.vdata);
                $("#div_cronogramas #vw_cmd_crono_view #vw_cmd_crono_btnasignar").data('calendario', calendario);
                $("#modCronogramas #md_crono_sede").html(sede);
                $("#modCronogramas #md_crono_nombre").html(nombreCalendario);
                $("#modCronogramas #md_crono_periodo").html(periodo);
                $("#modCronogramas #md_crono_txt_codperiodo").val(codperiodo);
                $("#modCronogramas #md_crono_txt_codsede").val(codsede);

                $('#div_cronogramas #vw_cmd_crono_btnasignargp').data('calendario', calendario);

                $('#modCronogramas #vwbtn_update_fecha').hide();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_cronogramas #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
})

$('#modCronogramas').on('hidden.bs.modal', function(e) {
    $('#modCronogramas #vwbtn_update_fecha').hide();
})

$('#modGrupos').on('shown.bs.modal', function(e) {
    $('#div_Grupos input,select').removeClass('is-invalid');
    $('#div_Grupos .invalid-feedback').remove();
    $('#div_Grupos').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var btn = $(e.relatedTarget);
    var grupo = btn.closest('.rowcolor').data('calendario');
    $.ajax({
        url: base_url + "deudas_grupo/vw_modal_grupos",
        type: 'post',
        dataType: 'json',
        data: {
            vw_dcmd_grupo: grupo
        },
        success: function(e) {
            $('#div_Grupos #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $('#div_Grupos').html(e.vdata);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_Grupos #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
})

$('#vw_dc_btnbuscar').click(function(event) {
    var periodo = $('#vw_dc_cbperiodo').val();
    var sede = $('#vw_dc_cbsede').val();
    $('#vw_dc_divCalpanel input,select').removeClass('is-invalid');
    $('#vw_dc_divCalpanel .invalid-feedback').remove();
    if (periodo == "0") {
        $("#vw_dc_divcalendarios").html("");
        $('#vw_dc_cbperiodo').addClass('is-invalid');
        $('#vw_dc_cbperiodo').parent().append("<div class='invalid-feedback'>Periodo Requerido</div>");
        return;
    }
    $('#vw_dc_divCalpanel').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    $.ajax({
        url: base_url + "tesoreria/cronogramas/filtrar/sede/periodo",
        type: 'post',
        dataType: 'json',
        data: {
            "vw_dc_cbperiodo": periodo,
            "vw_dc_cbsede": sede
        },
        success: function(e) {
            $('#vw_dc_divCalpanel #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $("#vw_dc_divcalendarios").html("");
                $('#modMantCalendario').modal('hide');
                var nro = 0;
                var tabla = "";
                btnGrupos = '';
                tbCronogramas = $('#tbdc_dtCronogramas').DataTable();
                tbCronogramas.clear();

                $.each(e.vdata, function(index, val) {
                    vDetalleVencimientos="Fechas de Pago";
                     $.each(val['fechas'], function(index, item) {
                        itemColorFecha="text-danger";
                        var fechaEs=laFechaEs(item['fecha']);
                        if (fechaEs== 0){
                            itemColorFecha=" text-primary";
                        }
                        else if (fechaEs==1){
                            itemColorFecha=" text-success";
                        }
                        vDetalleVencimientos=vDetalleVencimientos + 
                        "<div class='row cfilaItem' data-codfechaitem='" + item['codigo'] + "'>" + 
                            "<div class='col-7'>" +
                                "<i class='fas fa-circle mr-1  " + itemColorFecha + "'></i>" +
                                item['descripcion'] +
                            "</div>" +
                            "<div class='col-5 text-rigth pr-1 " + itemColorFecha + "'>" + item['fechaDDMMYYYY'] +"</div>" + 
                            
                        "</div>";
                    });
                    var btnVerCronograma="<span class='mr-1' title='Detalles' data-toggle='tooltip' data-placement='bottom' >" + 
                                            "<a class='badge badge-primary text-white p-1' href='#' onclick='vw_abrir_modal_cronogramaDetalle($(this));return false'>" + 
                                                "<i class='fas fa-pencil-alt'></i></a></span> ";

                    vDetalleVencimientos=   "<div class='col-12'><div class='row'>" +
                                                "<div class='col-10'>" + vDetalleVencimientos + "</div>" +
                                                "<div class='border-danger col-2' >" +
                                                    btnVerCronograma +
                                                "</div>" + 
                                            "</div></div>";
                     

                    btnDuplicarCronograma = '<a class="dropdown-item" href="#" onclick="vw_abrir_modal_DuplicarCronogramaFilial($(this));return false"><i class="far fa-clone"></i> Duplicar a filial</a>';
                    btnProyectarMatriculas = '<a class="dropdown-item" href="#" data-proyectarorigen="cronograma" onclick="vw_abrir_modal_proyectarMatriculas($(this));return false"><i class="fas fa-hourglass-start"></i> Proyectar Matrículas</a>';
                    var btnOpciones='<div class="btn-group btn-group-sm p-0 " role="group">' +
                                    '<button class="bg-primary text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cog"></i>' +
                                    '</button>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                        //btnGrupos +
                                        btnDuplicarCronograma + btnProyectarMatriculas + 
                                    '</div>' +
                                '</div>';
                    var  btnSincronizarCalendario="<span class='mr-1' title='Sincronizar' data-toggle='tooltip' data-placement='bottom'>" +
                                                    "<a class='badge badge-success mx-1 p-1 text-white' href='#' onclick='fn_GenerarVincularDeudasConPagosAutomaticamente_PorCronograma($(this));return false'><i class='fas fa-sync-alt'></i>" + 
                                                    "</a></span> ";;

                    var linkNombreCronograma="<a href='#' onclick='vw_abrir_modal_cronogramaDetalle($(this));return false'>" + val['nombre']  + " (" + val['codigo'] + ") </a>";
                    
                    var btnEditarCronograma="<span class='mr-1' title='Editar' data-toggle='tooltip' data-placement='bottom'>" +
                                    "<a class='badge badge-warning p-1' href='#' data-toggle='modal' data-target='#modMantCalendario' data-accion='editar'><i class='fas fa-edit'></i>" + 
                                    "</a>" + 
                                    "</span>";
                    var vDetalleEvaluaciones="U1: " + val['cerrar_i1DDMMYYYY'] + "<br>U2: " + val['cerrar_i2DDMMYYYY'] + "<br>U3: " + val['cerrar_i3DDMMYYYY'];
                    var arrayCronogramas_new = [
                        (index + 1) ,
                        val['sede'] ,
                        val['periodo'] ,
                        linkNombreCronograma,
                        val['inicia'] ,
                        val['culmina'],
                        vDetalleVencimientos,
                        vDetalleEvaluaciones,
                        val['totalgrupos'],
                         btnEditarCronograma + btnSincronizarCalendario + btnOpciones
                    ];


            

                var filaCronograma_new = tbCronogramas.row.add(arrayCronogramas_new).node();
                    $(filaCronograma_new).attr('data-nombrecal', val['nombre'] );
                    $(filaCronograma_new).attr('data-calendario', val['codigo64'] );
                    $(filaCronograma_new).attr('data-codcalendario64', val['codigo64'] );
                    $(filaCronograma_new).attr('data-codcalendario', val['codigo'] );
                    $(filaCronograma_new).attr('data-cierreud', val['cierre_ud'] );
                    $(filaCronograma_new).attr('data-consolida', val['consolida_retiros'] );

                    $(filaCronograma_new).attr('data-cerrare1', val['cerrar_i1'] );
                    $(filaCronograma_new).attr('data-cerrare2', val['cerrar_i2'] );
                    $(filaCronograma_new).attr('data-cerrare3', val['cerrar_i3'] );

                    $(filaCronograma_new).attr('data-codsede', val['codsede'] );
                    $(filaCronograma_new).attr('data-codperiodo', val['codperiodo'] );
                    $(filaCronograma_new).attr('data-sede', val['sede'] );
                    $(filaCronograma_new).attr('data-periodo', val['periodo'] );
                    $(filaCronograma_new).attr('data-inicia', val['inicia'] );
                    $(filaCronograma_new).attr('data-culmina', val['culmina'] );
                    $(filaCronograma_new).addClass("cfila");

                });
                tbCronogramas.draw();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_dc_divCalpanel #divoverlay').remove();
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


function vw_abrir_modal_DuplicarCronogramaFilial(boton) {
    
    fila=boton.closest(".cfila");
    $('#divModalDuplicarCronogramaParaFilial').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var vcodcalendario64 = fila.data("codcalendario64");
    //var vcodcalendario = fila.data("codcalendario");
    //7var calendario = fila.data('calendario');
    var nombreCalendario = fila.data('nombrecal');
    //var codperiodo = fila.data('codperiodo');
    var periodo = fila.data('periodo');
    var codsede = fila.data('codsede');
    var sede = fila.data('sede');

    $("#modDuplicaCalendarioParaFilial .modal-title").html(sede + " | "  + periodo + " | Cronograma: <span class='text-primary'>" + nombreCalendario+ "</span>");

    $("#vw_mdcf_cbFilial").val(0);
    $("#vw_mdcf_codCalendario64").val(vcodcalendario64);
    $('#div_cronogramas #divoverlay').remove();
    $('#modDuplicaCalendarioParaFilial').modal("show");
     $('#divModalDuplicarCronogramaParaFilial #divoverlay').remove();

}

function fn_guardarDuplicarCronogramaFilial(boton) {
   
    $('#divModalDuplicarCronogramaParaFilial').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var vcodcalendario64 = $("#vw_mdcf_codCalendario64").val();
    var vcodFilial = $("#vw_mdcf_cbFilial").val();

   
    $.ajax({
        url: base_url + "deudas_calendario/fn_DuplicarCronogramaParaFilial",
        type: 'post',
        dataType: 'json',
        data: {
            txtcodcalendario64: vcodcalendario64,
            txtcodfilial: vcodFilial          
        },
        success: function(e) {
            $('#divModalDuplicarCronogramaParaFilial #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                 Swal.fire({
                    title: "Error!",
                    text: e.msg,
                    icon: 'error',
                })
            } else {
                Swal.fire({
                title: "Duplicado correctamente",
                text: e.msg,
                icon: 'success',
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divModalDuplicarCronogramaParaFilial #divoverlay').remove();
            Swal.fire({
                title: msgf,
                icon: 'error',
            })
        }
    });
    return false;
}



function fn_vw_save_itemfac() {
    var vw_cmdi_cbgestion = $("#vw_cmdi_cbgestion").val();
    var vw_cmdi_txtcodigo = $("#vw_cmdi_txtcodigo").val();
    var vw_cmdi_chkrepite = ($("#vw_cmdi_chkrepite").prop('checked') == true) ? "SI" : "NO";
    var vw_cmdi_txtcalfecha = $("#vw_cmdi_txtcalfecha").val();
    var vw_cmdi_txtmonto = $("#vw_cmdi_txtmonto").val();
    $.ajax({
        url: base_url + "deudas_calendario_fechas_item/fn_insert_update",
        type: 'post',
        dataType: 'json',
        //data: $('#div_cronogramas #vw_cmda_frmcalendario').serialize(),
        data: {
            fictxtcodigo: vw_cmdi_txtcodigo,
            fictxtcal_fecha: vw_cmdi_txtcalfecha,
            fictxtcodgestion: vw_cmdi_cbgestion,
            fictxt_repite: vw_cmdi_chkrepite,
            fictxt_monto: vw_cmdi_txtmonto
        },
        success: function(e) {
            $('#div_cronogramas #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                $(".vw_rbfecha_cobro").change();
                $("#vw_cmdv_item_agregar").hide();
                $("#vw_cmdv_item").show();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#div_cronogramas #divoverlay').remove();
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