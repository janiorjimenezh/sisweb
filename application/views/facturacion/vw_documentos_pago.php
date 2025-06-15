<style>
    .dataTables_scrollBody{
        min-height: 45vh;
    }
</style>
<?php
$vbaseurl=base_url();
$vuser=$_SESSION['userActivo'];
//$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
$arrayestado = array('ACEPTADO','ANULADO','ANULANDO','ENVIADO','RECHAZADO','PENDIENTE','OBSERVADO','ERROR');
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="content-wrapper">
    <?php include 'vw_documentos_pago_cobrar.php'; ?>
    <?php include 'vw_documentos_pago_modals.php'; ?>
    
    <?php $this->load->view('tesoreria/deudas/vw_deudas_modalAsignar'); ?>
    <?php $this->load->view('facturacion/vw_documentos_modalCambiarItemDetalle', array('gestion' => $gestion )); ?>
    <section id="s-cargado" class="content pt-1">
        <div class="card card-primary card-tabs" id="divCardDocPagosGeneral">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tabDocsPago-tab" data-toggle="pill" href="#tabDocsPago" role="tab" aria-controls="tabDocsPago" aria-selected="true">Documentos de Pago</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tabDocsPagoDetalle-tab" data-toggle="pill" href="#tabDocsPagoDetalle" role="tab" aria-controls="tabDocsPagoDetalle" aria-selected="false">Detalle de Pago</a>
                    </li>
                    
                    <li class="p-0 card-tools ml-auto">
                        
                        <span id="vw_dp_em_spn_estado" class="badge badge-warning p-2" data-trigger="hover"  data-container="body" data-toggle="popover" data-placement="bottom" data-content="Sin Novedades">
                          Resumen
                        </span>

                        <?php  if (getPermitido("110") == "SI"): ?>
                        <a href="#" class="badge badge-warning p-2" id="vw_dp_em_btn_enviar_docs_sunat">
                            <span data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Enviar Documentos Pendientes a SUNAT">
                                <i class="fa fa-plus"></i> Enviar a Sunat
                            </span>
                        </a>
                        <?php endif ?>
                        <?php  if (getPermitido("111") == "SI"): ?>
                        <a href="#" class="badge badge-success p-2" id="vw_dp_em_btn_consultar_docs_sunat">
                            <span data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Consultar Documentos enviados a SUNAT">
                                <i class="fa fa-plus"></i> Consultar Enviados
                            </span>
                        </a>
                        <?php endif ?>
                        
                        <div class="btn-group dropleft">
                            <button class="btn btn-secondary btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Crear
                            </button>
                            <div class="dropdown-menu">
                                <?php
                                if (getPermitido("99") == "SI")  {
                                echo "<a class='dropdown-item text-dark' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=boleta'>Boleta</a>";
                                }
                                if (getPermitido("98") == "SI")  {
                                echo "<a class='dropdown-item text-dark' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=factura'>Factura</a>";
                                }
                                ?>
                                <div class="dropdown-divider"></div>
                                <?php
                                if (getPermitido("100") == "SI")  {
                                echo "<a class='dropdown-item text-dark' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=notaboleta'>Nota de Crédito - BOLETA</a>";
                                echo "<a class='dropdown-item text-dark' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=notafactura'>Nota de Crédito - FACTURA</a>";
                                }
                                if (getPermitido("101") == "SI")  {
                                echo "<a class='dropdown-item text-dark' href='{$vbaseurl}tesoreria/facturacion/crear-documento?tp=notadebito'>Nota de Débito</a>";
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade show active" id="tabDocsPago" role="tabpanel" aria-labelledby="tabDocsPago-tab">
                        
                        <form id="frm_search_docpago" action="" method="post" accept-charset="utf-8">
                            <div class="row">
                                <div class="form-group has-float-label col-12 col-md-2 col-sm-3">
                                    <select name="fictxttipodoc" id="fictxttipodoc" class="form-control form-control-sm text-sm">
                                        <option value='%'>Todos</option>
                                        <?php
                                        foreach ($tipdoc as $key => $doc) {
                                        echo "<option value='$doc->codigo'>$doc->nombre</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="fictxttipodoc">Tipo</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-md-3 col-sm-4">
                                    <input type="text" autocomplete="off" name="fictxtpagapenom" id="fictxtpagapenom" class="form-control form-control-sm" placeholder="Cliente">
                                    <label for="fictxtpagapenom">Cliente</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="form-group has-float-label col-6 col-md-6 col-sm-2">
                                            <input type="date" name="fictxtfecha_emision" id="fictxtfecha_emision" class="form-control form-control-sm">
                                            <label for="fictxtfecha_emision">Fecha Inicio</label>
                                        </div>
                                        <div class="form-group has-float-label col-6 col-md-6 col-sm-2">
                                            <input type="date" name="fictxtfecha_emisionf" id="fictxtfecha_emisionf" class="form-control form-control-sm">
                                            <label for="fictxtfecha_emisionf">Fecha Final</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="row">
                                       <div class="form-group has-float-label col-12 col-md-7 col-sm-3">
                                            <select name="fictxtestadodoc" id="fictxtestadodoc" class="form-control form-control-sm text-sm">
                                                <option value='%'>Todos</option>
                                                <?php
                                                foreach ($arrayestado as $key => $est) {
                                                echo "<option value='$est'>$est</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="fictxtestadodoc">Estado</label>
                                        </div>
                                        <div class="col-md-5 col-sm-2 text-right">
                                            <button type="submit" class="btn btn-sm btn-info">
                                            <i class="fas fa-search"></i>
                                            </button>
                                            <div class="btn-group dropleft">
                                                <button class="btn btn-sm btn-outline-success dropdown-toggle px-1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-file-download"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <?php
                                                    if (getPermitido("104") == "SI")  {
                                                    echo "<a id='vw_exp_pdf' class='dropdown-item' href='#'><i class='fas fa-file-pdf text-danger mr-1'></i>PDF</a>";
                                                    }
                                                    if (getPermitido("103") == "SI")  {
                                                    echo "<a id='vw_exp_excel' class='dropdown-item' href='#'>
                                                    <i class='fas fa-file-excel text-success mr-1'></i>Excel</a>";
                                                    }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                        </form>
                        <div class="col-12" id="vwdp_spanPendientes"></div>
                        <div class="table-responsive m-0 border-bottom">
                            <table id="tbdpd_dtDoscPago" class="tbdatatable table table-sm table-hover table-bordered table-condensed" style="width:100%">
                                <thead>
                                    <tr class="bg-lightgray">
                                        <th>N°</th>
                                        <th>TP</th>
                                        <th>N° DOC.</th>
                                        <th>EMISIÓN</th>
                                        <th>PSE</th>
                                        <th>PAGANTE</th>
                                        <th>MONTO</th>
                                        <th>IGV</th>
                                        <th>-</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 divhide d-block border-top bg-lightgray">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-6 border text-center font-weight-bold" id="divdocserie">BA02-45527</div>
                                        <div class="col-6 border text-center font-weight-bold">(<span id="divestado">PENDIENTE</span>)</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border text-center font-weight-bold" id="divpagante"></div>
                                </div>
                                <div class="col-md-3">
                                    <button id="vw_dp_em_btn_close" type="button" class="btn btn-danger btn-sm float-right py-0" aria-label="Close">x</button>
                                    <div class="row">
                                        <div class="col-6 font-weight-bold border">TOTAL:</div>
                                        <div class="col-6 text-right font-weight-bold border" id="divTotal"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9" id="divcard_details">

                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-6 border text-muted font-weight-bold">SubTotal:</div>
                                        <div class="col-6 border text-muted text-right font-weight-bold" id="divsubtotal"></div>
                                        <div class="col-6 border text-muted font-weight-bold">IGV:</div>
                                        <div class="col-6 border text-muted text-right font-weight-bold" id="divIgv"></div>
                                    </div>
                                </div>

                                <div class="col-12 mt-1">
                                    <div class="border p-1">
                                        <span><b>Observaciones:</b></span>
                                        <span id="divobserva"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabDocsPagoDetalle" role="tabpanel" aria-labelledby="tabDocsPagoDetalle-tab">
                        <div class="row">
                            <div class="col-12">
                                <form class="form-row" id="tbdpd_frmBuscarDoscPagoDetalle">
                                    <div class="form-group has-float-label col-12 col-md-2 col-sm-2">
                                        <select name="tbdpd_txttipodoc" id="tbdpd_txttipodoc" class="form-control form-control-sm">
                                            <option value='%'>Todos</option>
                                            <?php
                                            foreach ($tipdoc as $key => $doc) {
                                            echo "<option value='$doc->codigo'>$doc->nombre</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="tbdpd_txttipodoc">Tipo Doc. Pago</label>
                                    </div>
                                    <div class="form-group has-float-label col-12 col-md-3 col-sm-3">
                                        <select name="tbdpd_cbestadodoc" id="tbdpd_cbestadodoc" class="form-control form-control-sm">
                                            <option value='%'>Todos</option>
                                            <?php
                                            foreach ($arrayestado as $key => $est) {
                                            echo "<option value='$est'>$est</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="tbdpd_cbestadodoc">Estado Doc.</label>
                                    </div>
                                    
                                    <div class="form-group has-float-label col-12 col-md-2 col-sm-2">
                                        <select name="tbdpd_cbLapsoTiempo" id="tbdpd_cbLapsoTiempo" class="form-control form-control-sm">
                                            <option value='1'>Todos</option>
                                            <option value='2'>Hoy</option>
                                            <option value='3'>Este Mes</option>
                                            <option value='4'>Entre ... y ...</option>
                                        </select>
                                        <label for="tbdpd_cbLapsoTiempo">Lapso de Tiempo</label>
                                    </div>
                                    <div class="form-group has-float-label col-6 col-md-2 col-sm-3">
                                        <input type="date" name="tbdpd_txtfecha_emision" id="tbdpd_txtfecha_emision" class="form-control form-control-sm">
                                        <label for="tbdpd_txtfecha_emision">Fecha Inicio</label>
                                    </div>
                                    <div class="form-group has-float-label col-6 col-md-2 col-sm-3">
                                        <input type="date" name="tbdpd_txtfecha_emisionf" id="tbdpd_txtfecha_emisionf" class="form-control form-control-sm">
                                        <label for="tbdpd_txtfecha_emisionf">Fecha Final</label>
                                    </div>
                                    
                                    
                                    <div class="form-group has-float-label col-6 col-md-6 col-sm-6">
                                        <input type="text" name="tbdpd_txtbuscar" id="tbdpd_txtbuscar" class="form-control form-control-sm" placeholder="Cliente">
                                        <label for="tbdpd_txtbuscar">Cliente</label>
                                    </div>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="tbdpd_chkSinMatricula">
                                        <label class="custom-control-label" for="tbdpd_chkSinMatricula">Sin Matrícula</label>
                                    </div>
                                    <div class="col-2 col-sm-2 col-md-1 text-right">
                                        <button id="tbdpd_btnBuscarDoscPagoDetalle" type="submit" class="btn btn-block btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="tbdpd_dtDoscPagoDetalle" class="tbdatatable table table-sm table-hover table-bordered table-condensed" style="width:100%">
                                        <thead>
                                            <tr class="bg-lightgray">
                                                <th>N°</th>
                                                <th>N° DOC.</th>
                                                <th>EMISIÓN</th>
                                                <th>PAGANTE</th>
                                                <th>CONCEPTO</th>
                                                <th>PER./SEM.</th>
                                                <th>CANT.</th>
                                                <th>MONTO</th>
                                                
                                                <th>DEUDA</th>
                                                <th>PER./SEM.</th>
                                                <th>VENCE</th>
                                                <th>MONTO</th>
                                                <th>SALDO</th>
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
        </div>
        
    </section>
    <div id="vw_fcb_rowitem" class="row rowcolor vw_fcb_class_rowitem" data-arraypos="-1">
        <div class="col-12 col-md-1 p-0">
            <input type="hidden" name="vw_fcb_ai_cod_detalle" >
            <select readonly name="vw_fcb_ai_cbunidad"  class="form-control control form-control-sm text-sm">
                <?php
                foreach ($unidad as $key => $und) {
                echo "<option  value='$und->codigo' >$und->nombre</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-12 col-md-1 p-0">
            <input readonly type="text"  name="vw_fcb_ai_cbgestion" class="form-control form-control-sm text-sm">
        </div>
        <div class="col-12 col-md-4 p-0">
            <input autocomplete="off" type="text"  onchange="fn_update_concepto($(this));return false" name="vw_fcb_ai_txtgestion" placeholder="Gestion" class="form-control form-control-sm text-sm divcard_campos_read">
        </div>
        <div class="col-12 col-md-1 p-0">
            <input autocomplete="off" onkeyup="fn_update_precios($(this));return false" onchange="fn_update_precios($(this));return false" type="number" name="vw_fcb_ai_txtcantidad"  placeholder="Cantidad" class="form-control form-control-sm text-sm text-right divcard_campos_read">
        </div>
        <div class="col-12 col-md-1 p-0">
            <input autocomplete="off" onkeyup="fn_update_precios($(this));return false" onchange="fn_update_precios($(this));return false" type="number" name="vw_fcb_ai_txtpreciounitario"  placeholder="pu" class="form-control form-control-sm text-sm text-right divcard_campos_read">
        </div>
        <div class="col-12 col-md-1 p-0">
            <input readonly type="text" name="vw_fcb_ai_txtprecioventa"  placeholder="pv" class="form-control form-control-sm text-sm text-right">
        </div>
        <div class="col-12 col-md-1 p-0">
            <input type="text" onkeyup="fn_update_cod_deuda($(this));return false" onchange="fn_update_cod_deuda($(this));return false" name="vw_fcb_ai_txtcoddeuda" class="form-control form-control-sm text-sm">
        </div>
        <div class="col-12 col-md-1 p-0">
            <select onchange="fn_update_cod_matricula_deta($(this));return false;" name="vw_fcb_ai_txtcodmatricula_det" class="form-control control form-control-sm text-sm text-danger form_select_mat" data-prb="hola">
            </select>
        </div>
        <div class="row">
            <input readonly type="hidden" name="vw_fcb_ai_txtvalorunitario"  >
            <div class="col-12 col-md-3">
                <input  type="hidden" name="vw_fcb_ai_cbisc"  >
            </div>
            <div class="col-12 col-md-2">
                <input  type="hidden" name="vw_fcb_ai_txtiscvalor"  placeholder="Impuesto" >
            </div>
            <div class="col-12 col-md-3">
                <input  type="hidden" name="vw_fcb_ai_cbiscfactor" >
            </div>
            <div  class="col-12 col-md-2">
                <input  type="hidden" name="vw_fcb_ai_txtiscbase"  placeholder="Base Imponible" >
            </div>
            <div class="col-12 col-md-2">
                <input  type="hidden" name="vw_fcb_ai_txtdsctvalor"  placeholder="Impuesto">
            </div>
            <div class="col-12 col-md-3" name="vw_fcb_ai_cbdsctfactor">
                <input  type="hidden">
                
            </div>
            <div class="col-12 col-md-4">
                <input  type="hidden"  name="vw_fcb_ai_cbafectacion">
            </div>
            <div class="col-12 col-md-4">
                <input  type="hidden"  name="vw_fcb_ai_cbafectaigv">
            </div>
            
        </div>
    </div>
    
</div>
<?php
echo
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/dist/js/pages/documentospago.js'></script>
<script src='{$vbaseurl}resources/dist/js/jquery.bootpag.min.js'></script>";
?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script type="text/javascript">
var totalPorPagina = 40;
valto = 0;
var arrayestado = [ "ACEPTADO", "ANULADO", "ANULANDO", "ENVIADO", "RECHAZADO" ,"PENDIENTE","OBSERVADO","ERROR"];
var cargaData=<?php echo json_encode($docspagodata); ?>;
var seriesData=<?php echo json_encode($series); ?>;
var cargaDataCorrelativo=<?php echo json_encode($docspagocorrelativo); ?>;


$(function () {
  $('[data-toggle="popover"]').popover()
})

$(document).ready(function() {
    $("#vw_dp_em_divoverlay").hide();
    $('#vw_fcb_rowitem').hide();
    $(".div_dctoglobal").hide();

    $(".divhide").removeClass("d-block");
    $(".divhide").addClass("d-none");
    fn_filtrarDocsPagoCargarDataTable(cargaData,true);
    cargaData=null;

});


// $(function () {
//   $('.example-popover').popover({
//     container: 'body'
//   })
// })
// $(window).on('resize', function () {
//         $($.fn.dataTable.tables(true)).DataTable()
//                 .columns.adjust();
// });

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

$('#tbdpd_dtDoscPago').DataTable({
    scrollCollapse: true,
    scrollY: '50vh',
    "autoWidth": false,
    "pageLength": 50,
    "searching": false,
    "lengthChange": false,
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
    },
    'columnDefs': [{
        targets: 2,
        orderData: 0
    }, {
        "targets": 0, // your case first column
        "className": "text-right rowhead",
        "width": "8px"
    }, {
        "targets": [6, 7], // your case first column
        "className": "text-right"
    }, {
        "targets": [4], // your case first column
        "className": "text-center"
    }, {
        targets: [3],
        render: function(data, type, row) {
            var datetime = data; //moment(data, 'YYYY-MM-DD HH:mm:ss');
            var displayString = moment(datetime).format('DD/MM/YYYY hh:mm a');
            if (type === 'display' || type === 'filter') {
                return displayString;
            } else {
                return datetime; // for sorting
            }
        }
    }],
    "fnDrawCallback": function (oSettings) {
        $('[data-toggle="popover"]').popover({
            trigger: 'hover',
            html: true
        });
        $('[data-toggle="tooltip"]').tooltip();
        $('ul.pagination').addClass("pagination-sm");
    }
});
$('#tbdpd_dtDoscPagoDetalle').DataTable({
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
    }, {
        "targets": [6, 7, 11, 12], // your case first column
        "className": "text-right"
    }, {
        "targets": [5, 8], // your case first column
        "className": "text-center"
    }, {
        targets: [2],
        render: function(data, type, row) {
            var datetime = moment(data, 'YYYY-MM-DD HH:mm:ss');
            var displayString = moment(datetime).format('DD/MM/YYYY hh:mm a');
            if (type === 'display' || type === 'filter') {
                return displayString;
            } else {
                return datetime; // for sorting
            }
        }
    }, {
        targets: [10],
        render: function(data, type, row) {
            var datetime = moment(data, 'YYYY-MM-DD');
            var displayString = moment(datetime).format('DD/MM/YYYY');
            if (type === 'display' || type === 'filter') {
                if (data == null) {
                    return "";
                } else {
                    return displayString;
                }

            } else {
                return datetime; // for sorting
            }
        }
    }],
    "fnDrawCallback": function(oSettings) {
        $('[data-toggle="tooltip"]').tooltip();
    }
});

var table = $('#tbmt_dtDeudas').addClass('nowrap').DataTable({
        "responsive": true,
        // "autoWidth": false,
        "pageLength": 15,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, // your case first column
            "className": "text-right rowhead",
            "width": "8px"
        }, ],
        'searching': false,
        dom: "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });

function fn_filtrarDocsPagoDetalle() {
    $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    var vtbdpd_txtcodpagante = $("#tbdpd_txtcodpagante").val();
    var vtbdpd_txttipodoc = $("#tbdpd_txttipodoc").val();
    var vtbdpd_txtbuscar = $("#tbdpd_txtbuscar").val();
    var vtbdpd_cbLapsoTiempo = $("#tbdpd_cbLapsoTiempo").val();
    var vtbdpd_txtfecha_emision = $("#tbdpd_txtfecha_emision").val();
    var vtbdpd_txtfecha_emisionf = $("#tbdpd_txtfecha_emisionf").val();
    var vtbdpd_cbestadodoc = $("#tbdpd_cbestadodoc").val();
    var vtbdpd_chkSinMatricula=($("#tbdpd_chkSinMatricula").prop("checked")==true) ? 0: null; 

    $.ajax({
        url: base_url + "tesoreria/facturacion/docpago/detalle/filtrar",
        type: 'post',
        dataType: 'json',
        data: {
            "txtbuscar": vtbdpd_txtbuscar,
            "txtfechaini": vtbdpd_txtfecha_emision,
            "txtfechafin": vtbdpd_txtfecha_emisionf,
            "txttipodoc": vtbdpd_txttipodoc,
            "txtestadodoc": vtbdpd_cbestadodoc,
            "txtcodmatricula": vtbdpd_chkSinMatricula
        },
        success: function(e) {
            $('#divCardDocPagosGeneral #divoverlay').remove();
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
                tbDocsPagoDetalle = $('#tbdpd_dtDoscPagoDetalle').DataTable();
                tbDocsPagoDetalle.clear();

                $.each(e.vdata, function(index, val) {
                    btnCodDeuda=val['coddeuda'];
                    if (e.vpermiso198 == "SI") {
                        btnCodDeuda = '<a class="badge badge-primary py-1 ml-1 text-white" href="#" onclick="fn_vw_vincular_pagos($(this));return false;" title="Vincular Pagos" >' + 
                            btnCodDeuda + ' <i class="far fa-money-bill-alt fa-lg ml-1"></i>' +
                            '</a>';
                    }

                    var linkEditarDetalle = "<a href='#' onclick='vw_abrir_modal_CambiarDetalleItemPago($(this));return false;' class='badge badge-warning text-white ml-1 px-1'><i class='fas fa-edit'></i></a> "
                    var vGestion = val['codgestion_como'] + " " + val['gestion_como'];
                    if (val['codgestion'] != val['codgestion_como']) {
                        vGestion = val['codgestion'] + " " + val['gestion'] + "</br>" + vGestion + " (SUNAT)";
                    }

                    vMonto = Number(val['monto']);
                    vPerSem = val['periodo'] + " / " + val['ciclo'];
                    if (val['periodo'] == null) {
                        vPerSem = "<span class='text-danger text-bold'>Asignar</span>";
                    }

                    if ((val['estado'] == "ENVIADO") || (val['estado'] == "ACEPTADO") || (val['estado'] == "PENDIENTE")) {
                        vPerSem = vPerSem + linkEditarDetalle;
                    } else {
                        vPerSem = "<span class='text-danger text-bold'>" + val['estado'] + "</span>";

                    }
                    vDmonto = Number(val['dmonto']);
                    vDsaldo = Number(val['dsaldo']);
                    var arrayCronogramas_new = [
                        (index + 1),
                        val['serie'] + "-" + val['numero'],
                        val['fecha'],
                        val['codpagante'] + " " + val['pagante'],
                        vGestion,
                        vPerSem,
                        val['cantidad'],
                        vMonto.toFixed(2),
                        btnCodDeuda,
                        val['dgestion'],
                        val['dvence'],
                        vDmonto.toFixed(2),
                        vDsaldo.toFixed(2)
                    ];
                    var filaCronograma_new = tbDocsPagoDetalle.row.add(arrayCronogramas_new).node();
                        $(filaCronograma_new).attr('data-codinscripcion64', val['codinscripcion64'] );
                        $(filaCronograma_new).attr('data-codmatricula', val['codmatricula'] );
                        $(filaCronograma_new).attr('data-codmatricula64', val['codmatricula64'] );
                        //$(filaCronograma_new).attr('data-cdeuda', val['codigo64'] );
                        
                        $(filaCronograma_new).attr('data-coddeuda', val['coddeuda'] );
                        $(filaCronograma_new).attr('data-coddeuda64', val['coddeuda64'] );
                        $(filaCronograma_new).attr('data-apellidos', val['paterno'] + ' ' + val['materno'] );
                        $(filaCronograma_new).attr('data-alumno', val['nombres'] );

                        $(filaCronograma_new).attr('id', val['coddetalle64'] );
                        $(filaCronograma_new).attr('data-carnet', val['codpagante'] );
                        $(filaCronograma_new).attr('data-gestion', val['gestion'] );
                        $(filaCronograma_new).attr('data-codgestion', val['codgestion'] );
                        $(filaCronograma_new).attr('data-gestion_como', val['gestion_como'] );
                        $(filaCronograma_new).attr('data-codgestion_como', val['codgestion_como'] );

                        //$(filaCronograma_new).attr('data-grupodeuda', val['grupodeuda'] );
                        $(filaCronograma_new).attr('data-fechaven', val['dvence'] );
                        $(filaCronograma_new).attr('data-deudamonto', parseFloat(val['dmonto']).toFixed(2));
                        $(filaCronograma_new).attr('data-saldodeuda', parseFloat(val['dsaldo']).toFixed(2))






                    $(filaCronograma_new).attr('data-coddetalle64', val['coddetalle64']);
                    $(filaCronograma_new).attr('data-gestion_como', val['gestion_como']);
                    
                    $(filaCronograma_new).attr('data-codgestion_como', val['codgestion_como']);
                    $(filaCronograma_new).attr('data-codpagante', val['codpagante']);
                    
                    $(filaCronograma_new).addClass("cfila");
                });
                tbDocsPagoDetalle.draw();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divCardDocPagosGeneral #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                icon: 'error',
            })
        }
    });
    return false;
}
$("#tbdpd_frmBuscarDoscPagoDetalle").submit(function(event) {
    fn_filtrarDocsPagoDetalle();
    return false;
});


// function vw_abrir_modal_CambiarDetalleItemPago(boton) {
//     fila = boton.closest(".cfila");
//     $("#modMantDetalleItemPago").modal('show');
//     $('#div_cronogramaFechaITemPago').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
//     var coddetalle64 = fila.data("coddetalle64");
//     var gestion_como = fila.data('gestioncomo');
//     var codgestion = fila.data('codgestion');
//     var codgestion_como = fila.data('codgestioncomo');
//     var vCarne = fila.data('codpagante');
//     var vcodmatricula64 = fila.data('codmatricula64');
//     $("#modMantDetalleItemPago .modal-title").html("Gestión: <span class='text-primary'>" + gestion_como + "</span>");
//     $("#vw_cmdidp_cbgestion").val(codgestion);
//     $("#vw_cmdidp_txtfactcomo").val(codgestion_como + " " + gestion_como);
//     $("#vw_cmdidp_cbmatricula").html("");
//     $("#vw_cmdidp_txtcodigo").val(coddetalle64);
//     $.ajax({
//         url: base_url + "matricula/fn_getMatriculas",
//         type: 'post',
//         dataType: 'json',
//         data: {
//             "txtcarne": vCarne
//         },
//         success: function(e) {
//             $('#div_cronogramaFechaITemPago #divoverlay').remove();
//             $("#vw_cmdidp_cbmatricula").append("<option value='0'>Sin Matrícula</option>");
//             $.each(e.vdata, function(index, v) {
//                 var vselected = (vcodmatricula64 == v["codmatricula64"]) ? "selected" : "";
//                 $("#vw_cmdidp_cbmatricula").append("<option " + vselected + " value='" + v["codmatricula64"] + "'>" + v["periodo"] + " / " + v["ciclo"] + "</option>");
//             });
//         },
//         error: function(jqXHR, exception) {
//             $('#div_cronogramaFechaITemPago #divoverlay').remove();
//             var msgf = errorAjax(jqXHR, exception, 'text');
//             //$('#modPagos_asignar .modPagos_asignar_content #divoverlay').remove();
//             Swal.fire({
//                 title: msgf,
//                 // text: "",
//                 icon: 'error',
//             })
//         }
//     });
//     $("#vw_cmdidp_txtcambio").val("NO");
//     $('.vw_cmdidp_select').select2({
//         dropdownParent: $('#modMantDetalleItemPago'),
//         width: 'resolve'
//     });
//     //$('#div_cronogramas #divoverlay').remove();
// }
$('#modMantDetalleItemPago').on('hide.bs.modal', function(event) {
    if ($("#vw_cmdidp_txtcambio").val() == "SI") {
        fn_filtrarDocsPagoDetalle();
    }
})
$("#vw_dp_em_btnenviar").click(function(event) {
    if ($.trim($("#vw_dp_em_txtemail").val()) == "") {
        $("#vw_dp_em_divoverlay").show();
        $("#vw_dp_em_divoverlay").addClass('text-danger');
        $("#vw_dp_em_divoverlay").html('Ingresa un Email Válido');
    } else {
        $('#divmodalsendemail').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
        $("#vw_dp_em_divoverlay").show();
        $("#vw_dp_em_divoverlay").html('Enviando <i class="fas fa-spinner fa-pulse"> </i>');
        var emailsend = $("#vw_dp_em_txtemail").val();
        var codigo = $(this).data('codigo');
        $.ajax({
            url: base_url + "facturacion_sendmail/fn_enviar_documento_email",
            type: 'post',
            dataType: 'json',
            data: {
                vw_fcb_email: emailsend,
                vw_fb_codigo: codigo,
            },
            success: function(e) {
                $('#divmodalsendemail #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        title: e.msg,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                } else {
                    $("#vw_dp_em_divoverlay").html('Enviado <i class="fas fa-check"></i>');
                    $('#vw_dp_em_btnenviar').hide();
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divmodalsendemail #divoverlay').remove();
                $("#vw_dp_em_divoverlay").hide();
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
});
$('#lbtn_anula_doc').click(function(event) {
    $('#form_anuladocpago input,select,textarea').removeClass('is-invalid');
    $('#form_anuladocpago .invalid-feedback').remove();
    $('#divmodalanulad').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    $.ajax({
        url: $('#form_anuladocpago').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#form_anuladocpago').serialize(),
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
                    type: 'error',
                    icon: 'error',
                })
            } else {
                $('#modanuladoc').modal('hide');
                $("#frm_search_docpago").submit();
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Felicitaciones, documento anulado',
                    text: 'Se ha anulado el documento',
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
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
});
$("#modanuladoc").on('show.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var fila=rel.closest('.cfila');
    var codigo = fila.data('codigo64');


    //var codigo = rel.data('codigo');
    $('#ficdocumentcodigo').val(codigo);
});

function fn_eliminar_documento(btn) {
    
    var fila = btn.closest('.cfila');
    var codigo = fila.data('codigo64');
    var docsn = fila.data('serie') + "-" + fila.data('numero') ;
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "¿Deseas eliminar de forma permanente el documento " + docsn + "?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
            $.ajax({
                url: base_url + "facturacion/fn_delete_documento",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigo: codigo
                },
                success: function(e) {
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR! DATA",
                            text: e.msg,
                            type: 'error',
                            icon: 'error',
                        })
                    } else {
                        // $('#modaddcobros').modal('hide');
                        Swal.fire({
                            title: docsn,
                            text: "Se eliminó con éxito",
                            type: 'success',
                            icon: 'success',
                        });
                        fila.remove();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    Swal.fire({
                        title: "ERROR!",
                        text: msgf,
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
            return false;
        } else {
            $('#divcard-matricular #divoverlay').remove();
        }
    });
    //***************************************
}

function fn_enviar_documento_ose(btn) {

    var fila = btn.closest('.cfila');
    var codigo = fila.data('codigo64');
    var docsn = fila.data('serie') + "-" + fila.data('numero') ;
    //************************************
    Swal.fire({
        title: "ENVIO A SUNAT",
        text: "¿Deseas enviar el documento " + docsn + "?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, enviar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
            $.ajax({
                url: base_url + "facturacion/fn_reportar_doc_a_nube",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigo: codigo
                },
                success: function(e) {
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR! DATA",
                            text: e.msg,
                            type: 'error',
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: docsn,
                            text: "Se envió con éxito",
                            type: 'success',
                            icon: 'success',
                        });
                        $('#frm_search_docpago').submit();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    Swal.fire({
                        title: "ERROR!",
                        text: msgf,
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
            return false;
        } else {
            //$('#divcard-matricular #divoverlay').remove();
        }
    });
}

function fn_consultar_documento_ose(btn) {
    var fila=btn.closest('.cfila');
    var codigo = fila.data('codigo64');
    var docsn = fila.data('serie') + "-" + fila.data('numero') ;
    //************************************
    Swal.fire({
        title: "CONSULTA A SUNAT",
        text: "¿Deseas CONSULTAR el documento " + docsn + "?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, consultar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
            $.ajax({
                url: base_url + "facturacion/fn_consultar_doc_a_nube",
                type: 'post',
                dataType: 'json',
                data: {
                    vw_fcb_codigo: codigo
                },
                success: function(e) {
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR! DATA",
                            text: e.msg,
                            type: 'error',
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: docsn,
                            text: "Se envió con éxito",
                            type: 'success',
                            icon: 'success',
                        });
                        $('#frm_search_docpago').submit();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    Swal.fire({
                        title: "ERROR!",
                        text: msgf,
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
            return false;
        } else {
            //$('#divcard-matricular #divoverlay').remove();
        }
    });
}

function fn_consultar_documento_anulado(btn) {
    //var rel = $(e.relatedTarget);
    var fila=btn.closest('.cfila');
    var codigo = fila.data('codigo64');
    var docsn = fila.data('serie') + "-" + fila.data('numero') ;
    //************************************
    Swal.fire({
        title: "CONSULTA A SUNAT",
        text: "¿Deseas CONSULTAR el documento " + docsn + "?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, consultar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
            $.ajax({
                url: base_url + "facturacion_anulacion/fn_consultaranulaciondocpago",
                type: 'post',
                dataType: 'json',
                data: {
                    ficdocumentcodigo: codigo
                },
                success: function(e) {
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR! DATA",
                            text: e.msg,
                            type: 'error',
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: docsn,
                            text: e.msg,
                            type: 'success',
                            icon: 'success',
                        });
                        $('#frm_search_docpago').submit();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    Swal.fire({
                        title: "ERROR!",
                        text: msgf,
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
            return false;
        } else {
            //$('#divcard-matricular #divoverlay').remove();
        }
    });
}
$("#vw_exp_excel").click(function(e) {
    e.preventDefault();
    $('#frm_search_docpago input,select').removeClass('is-invalid');
    $('#frm_search_docpago .invalid-feedback').remove();
    var fi = $("#fictxtfecha_emision").val();
    var ff = $("#fictxtfecha_emisionf").val();
    var pg = $("#fictxtpagapenom").val();
    var url = base_url + 'tesoreria/facturacion/reportes/documentos-emitidos/excel?fi=' + fi + '&ff=' + ff + '&pg=' + pg;
    var ejecuta = false;
    if ($.trim(fi) != '') {
        ejecuta = true;
    } else if ($.trim(ff) != '') {
        ejecuta = true;
    } else if ($.trim(pg) != '') {
        ejecuta = true;
    }
    if (ejecuta == true) {
        window.open(url, '_blank');
    } else {
        Swal.fire({
            title: "Parametros requeridos",
            text: "Ingresa al menos un parametro de búsqueda",
            type: 'error',
            icon: 'error',
        })
    }
});
$("#vw_exp_pdf").click(function(e) {
    e.preventDefault();
    $('#frm_search_docpago input,select').removeClass('is-invalid');
    $('#frm_search_docpago .invalid-feedback').remove();
    var fi = $("#fictxtfecha_emision").val();
    var ff = $("#fictxtfecha_emisionf").val();
    var pg = $("#fictxtpagapenom").val();
    var url = base_url + 'tesoreria/facturacion/reportes/documentos-emitidos/pdf?fi=' + fi + '&ff=' + ff + '&pg=' + pg;
    var ejecuta = false;
    if ($.trim(fi) != '') {
        ejecuta = true;
    } else if ($.trim(ff) != '') {
        ejecuta = true;
    } else if ($.trim(pg) != '') {
        ejecuta = true;
    }
    if (ejecuta == true) {
        window.open(url, '_blank');
    } else {
        Swal.fire({
            title: "Parametros requeridos",
            text: "Ingresa al menos un parametro de búsqueda",
            type: 'error',
            icon: 'error',
        })
    }
});
$("#modenviarmail").on('show.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var fila=rel.closest('.cfila');
    var codigo = fila.data('codigo64');
    $('#vw_dp_em_btnenviar').data('codigo', codigo)
})
$("#modenviarmail").on('hidden.bs.modal', function(e) {
    $("#vw_dp_em_divoverlay").hide();
    $("#vw_dp_em_divoverlay").removeClass('text-danger');
    $("#vw_dp_em_divoverlay").html('');
    $("#vw_dp_em_txtemail").val('');
    $('#vw_dp_em_btnenviar').show();
})

function fn_cambiarAutorizacionVouhersAntiguos(btn) {
    var autorizar = "SI";
    var fila=btn.closest('.cfila');
    var codigo = fila.data('codigo64');
    var docsn = fila.data('serie') + "-" + fila.data('numero') ;


    var autorizarVoucherAntiguos = fila.data('autorizarvoucherantiguos');
    //************************************
    avaTexto = "HABILITAR";
    if (autorizarVoucherAntiguos == "SI") {
        avaTexto = "DESHABILITAR";
        autorizar="NO";
    }
    Swal.fire({
        title: "AUTORIZA VOUCHERS ANTIGUOS",
        text: "¿Deseas " + avaTexto + " VOUCHERS ANTIGUOS para el doc.  " + docsn + "?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: avaTexto
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
            $.ajax({
                url: base_url + "facturacion/fn_autorizarVouchersAntiguos",
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodigo: codigo,
                    txtautorizar: autorizar,
                },
                success: function(e) {
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            title: "ERROR! DATA",
                            text: e.msg,
                            type: 'error',
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: docsn,
                            text: "Se envió con éxito",
                            type: 'success',
                            icon: 'success',
                        });
                        $('#frm_search_docpago').submit();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    Swal.fire({
                        title: "ERROR!",
                        text: msgf,
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
            return false;
        } else {
            //$('#divcard-matricular #divoverlay').remove();
        }
    });
}

function fn_mostrarDocDetalle(btn) {
    $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');

    var fila = btn.closest(".cfila");
    //fila.addClass("bg-warning");
    codigo=fila.data("codigo64")
    $(".divhide").removeClass("d-none");
    $(".divhide").addClass("d-block");
    //$("#divresult").height(valto - $('.divhide').height());
    $.ajax({
        url: base_url + 'facturacion/fn_filtrar_detalle_docpago',
        type: 'post',
        dataType: 'json',
        data: {
            vw_fcb_codigopago: codigo
        },
        success: function(e) {
            if (e.status == true) {
                $('#divcard_details').html("");
                var nro = 0;
                var tabla = "";
                var btnvincular = "";
                var nroboleta = e.vdatap['serie'] + ' - ' + e.vdatap['numero'];
                tabla = tabla +
                    "<div class='btable mt-0'>" +
                    "<div class='thead col-12  d-none d-md-block'>" +
                    "<div class='row'>" +
                    "<div class='col-12 col-md-5'>" +
                    "<div class='row'>" +
                    "<div class='col-3 col-md-3 td'>CODGEST</div>" +
                    "<div class='col-9 col-md-9 td'>CONCEPTO</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class='col-12 col-md-4 text-center'>" +
                    "<div class='row'>" +
                    "<div class='col-4 col-md-4 td'>CANT.</div>" +
                    "<div class='col-4 col-md-4 td'>PREC.</div>" +
                    "<div class='col-4 col-md-4 td'>CODEU.</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class='col-12 col-md-3 text-center'>" +
                    "<div class='row'>" +
                    "<div class='col-md-6  td'>" +
                    "<span>IGV.</span>" +
                    "</div>" +
                    "<div class='col-md-6  td'>" +
                    "<span>SEMESTRE</span>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class='tbody col-12'>";
                $.each(e.vdata, function(index, val) {
                    nro++;
                    if (e.vpermiso198 == "SI") {
                        btnvincular = '<a href="#" class="badge badge-success" onclick="fn_vw_vincular_deudas($(this));return false;" title="Vincular Pagos" >' +
                            val['deudaid'] +
                            '</a>';
                    } else {
                        btnvincular = '<small class="badge badge-success">' +
                            val['deudaid'] +
                            '</small>';
                    }
                    if ((val['periodo'] !== null) && (val['ciclo'] !== null)) {
                        semestre = val['periodo'] + " / " + val['ciclo'];
                    } else {
                        semestre = "";
                    }
                    tabla = tabla +
                        "<div class='row rowcolor cfila' data-pagante='" + e.vdatap['pagante'] + "' data-nompagante='" + e.vdatap['pagantenom'] + "' data-iddetalle='" + val['id'] + "' data-monto='" + val['preunit'] + "' data-gestion='" + val['gestion'] + "' data-boleta='" + nroboleta + "' data-iddeuda='" + val['deudaid'] + "'>" +
                        "<div class='col-12 col-md-5'>" +
                        "<div class='row'>" +
                        "<div class='col-3 col-md-3 text-right td'><b>" + val['gestid'] + "</b></div>" +
                        "<div class='col-9 col-md-9 td'>" + val['gestion'] + "</div>" +
                        "</div>" +
                        "</div>" +
                        "<div class='col-12 col-md-4 text-center'>" +
                        "<div class='row'>" +
                        "<div class='col-4 col-md-4 td'>" + val['cantidad'] + "</div>" +
                        "<div class='col-4 col-md-4 td'>" + val['preunit'] + "</div>" +
                        "<div class='col-4 col-md-4 td'>" + btnvincular + "</div>" +
                        "</div>" +
                        "</div>" +
                        "<div class='col-12 col-md-3 text-center'>" +
                        "<div class='row'>" +
                        "<div class='col-6 col-md-6 td'>" + val['igv'] + "</div>" +
                        "<div class='col-6 col-md-6 td'>" + semestre + "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                })
                tabla = tabla +
                    "</div>" +
                    "</div>";
                $('#divdocserie').html(e.vdatap['serie'] + ' - ' + e.vdatap['numero']);
                $('#divpagante').html(e.vdatap['pagantenom']);
                $('#divestado').html(e.vdatap['estado']);
                $('#divsubtotal').html(e.subtotal);
                $('#divIgv').html(e.igv);
                $('#divTotal').html(e.total);
                //$('.divhide').removeClass('d-none');
                $('#divcard_details').html(tabla);
                $('#divobserva').html(e.vdatap['observacion']);
            } else {
                var msgf = '<span class="text-danger">' + e.msg + '</span>';
                $('#divcard_details').html(msgf);
            }
            $('#divCardDocPagosGeneral #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divCardDocPagosGeneral #divoverlay').remove();
            Swal.fire({
                title: msgf,
                type: 'error',
                icon: 'error',
            })
        },
    });
    return false;
}
$("#frm_search_docpago").submit(function(event) {
    fn_filtrarDocsPago();
    return false;
});
var vPermisos = new Array();
vPermisos['p239'] ='<?php echo getPermitido('239') ?>';
vPermisos['p97']  ='<?php echo getPermitido("97") ?>';
vPermisos['p193'] ='<?php echo getPermitido("193") ?>';
vPermisos['p144'] ='<?php echo getPermitido("144") ?>';
vPermisos['p234'] ='<?php echo getPermitido("234") ?>';
vPermisos['p102'] ='<?php echo getPermitido("102") ?>';
vPermisos['p109'] ='<?php echo getPermitido("109") ?>';
vPermisos['p110'] ='<?php echo getPermitido("110") ?>';
vPermisos['p111'] ='<?php echo getPermitido("111") ?>';
vPermisos['p156'] ='<?php echo getPermitido("156") ?>';
vPermisos['p174'] ='<?php echo getPermitido("174") ?>';

function fn_filtrarDocsPago() {
    $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    var vtbdpd_txttipodoc = $("#fictxttipodoc").val();
    var vtbdpd_txtbuscar = $("#fictxtpagapenom").val();
    var vtbdpd_txtfecha_emision = $("#fictxtfecha_emision").val();
    var vtbdpd_txtfecha_emisionf = $("#fictxtfecha_emisionf").val();
    var vtbdpd_cbestadodoc = $("#fictxtestadodoc").val();

    $.ajax({
        url: base_url + "tesoreria/facturacion/docpago/filtrar",
        type: 'post',
        dataType: 'json',
        data: {
            "busqueda": vtbdpd_txtbuscar,
            "fechaini": vtbdpd_txtfecha_emision,
            "fechafin": vtbdpd_txtfecha_emisionf,
            "codtipodoc": vtbdpd_txttipodoc,
            "estadodoc": vtbdpd_cbestadodoc
        },
        success: function(e) {
            $('#divCardDocPagosGeneral #divoverlay').remove();
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
                fn_filtrarDocsPagoCargarDataTable(e.data);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divCardDocPagosGeneral #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                icon: 'error',
            })
        }
    });
    return false;
}
function fn_filtrarDocsPagoCargarDataTable(data,mostrarPendientes=false){
    tbDocsPago = $('#tbdpd_dtDoscPago').DataTable();
    tbDocsPago.clear();

    seriePendientes=new Array();
            
    if (mostrarPendientes==true){
        $("#vwdp_spanPendientes").html("");
        $.each(seriesData, function(index, serie) {
            nro = new Array();
            textPendientes="Faltan: ";
            ini=Number( serie['contador']) - 1;
            fin=Number( serie['minimo']);
            if (fin>-1){
                for (var i = ini ; i >= fin; i--) {
                    encontro=false;
                    $.each(cargaDataCorrelativo, function(index, dp) {
                        if ((dp["codtipo"]==serie["codtipodoc"]) && (dp["serie"]==serie["serie"])){
                            if (i==dp["numero"]){
                                encontro=true;
                                return false;
                            }
                        }
                    });
                    if (encontro==false){
                        nro.push(i);
                    }
                }
                $.each(nro, function(index, val) {
                    textPendientes=textPendientes + "<span class='px-1 text-bold text-danger'>" + serie["serie"] + "-" + val + "</span>;";
                });
                if (nro.length==0){
                    textPendientes="";
                } 
                else{
                   seriePendientes.push(textPendientes) 
                }
                
            }
            
        });   
        $("#vwdp_spanPendientes").html(seriePendientes.join("<br>"));
    }
    var vConteoEstados = {'ANULANDO':0,'ENVIADO':0,'RECHAZADO':0,'PENDIENTE':0,'OBSERVADO':0,'ERROR':0};
    var vBadgeEstados = {'OBSERVADO':'btn-danger','RECHAZADO':'badge-danger','ERROR':'btn-danger','ANULANDO':'badge-danger','ENVIADO':'badge-success','PENDIENTE':'badge-warning'};
    $.each(data, function(index, val) {
        
        estado_color="text-warning";
        btn_color="btn-warning";
        icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
        s_msj=val['sunat_descripcion'] + " Sin enviar" ;
        text_strike="";
        btnenlxml="";
        vCodigo64=val['codigo64'];
        
        
        switch (val['estado']) {
            case 'PENDIENTE':
                s_msj="PENDIENTE de enviar" ;
                estado_color="text-warning";
                btn_color="btn-warning";
                icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
                btnenlxml="";
                vConteoEstados['PENDIENTE'] = vConteoEstados['PENDIENTE'] + 1;
                break;
            case 'ACEPTADO':
                s_msj="ACEPTADO por SUNAT" ;
                icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
                estado_color="text-success";
                btn_color = "btn-success";
                btnenlxml="<a target='_blank' class='dropdown-item' href='" + val['enl_xml'] + "' title='Descargar XML'> <i class='far fa-file-code mr-1'></i>Descargar XML</a>";
                break;
            case 'ANULADO':
                s_msj=val['anul_fecha'] + ": " + val['anul_motivo'];
                icon_sunat="<i class='fas fa-times fa-lg mr-1'></i>";
                estado_color="text-danger";
                btn_color = "btn-danger";
                text_strike="text-strike";
                vConteoEstados['ANULADO'] = vConteoEstados['ANULADO'] + 1;
                break;
            case 'ENVIADO':
                s_msj="En espera de ACEPTADO" ;
                icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
                estado_color="text-primary";
                btn_color = "btn-primary";
                vConteoEstados['ENVIADO'] = vConteoEstados['ENVIADO'] + 1;
                break;
            case 'RECHAZADO':
                icon_sunat="<i class='fas fa-exclamation-circle fa-lg mr-1'></i>";
                estado_color="text-danger";
                btn_color = "btn-danger";
                vConteoEstados['RECHAZADO'] = vConteoEstados['RECHAZADO'] + 1;
                break;
            case 'ERROR':
                s_msj=val['error_cod'] + " - " + val['error_desc'];
                icon_sunat="<i class='fas fa-ban fa-lg mr-1'></i>";
                estado_color="text-danger";
                btn_color = "btn-danger";
                vConteoEstados['ERROR'] = vConteoEstados['ERROR'] + 1;
                break;
        }
        
        btneditar = "";
        btndelete = "";
        btnprint="";
        btnpdf="";
        btnmail="";
        btnanular="";
        btnaddcobros = "";
        btneliminar="";
        btnsunat="";
        btnconsultar="";
        btnmatricula = "";
        btnAutorizaVoucherAntiguo ="";
        btnupdateclient = "";
        btnupdatedoc = "";
        dropdownstatus = "";
        btnconsultarAnulado ="";

        if (vPermisos['p174'] == "SI") {
        btnupdatedoc = "<a data-codigo='$codigo_enc' class='dropdown-item text-success' href='#' title='Actualizar Documento' onclick='fn_view_data_doc($(this));return false' >" + 
                "<i class='fas fa-edit mr-1'></i> Actualizar Documento " + 
            "</a>";
        }


        if (vPermisos['p239'] == "SI") {
            dropdownstatus = "<div class='btn-group p-0'>" +
                                "<button class='btn " + btn_color + " btn-sm text-sm dropdown-toggle py-0 m-0' type='button'  data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >" + 
                                    "<small>" + val['estado'] + "</small>" +
                                "</button> " +
                                "<div class='dropdown-menu'>";
            $.each( arrayestado, function( i, vfestado ){
               dropdownstatus = dropdownstatus  + "<a href='#' data-estado='" + vfestado + "' onclick='fn_cambiarestadobol($(this))' class='dropdown-item' ><small>" + vfestado + "</small></a>";
            });
                                
             dropdownstatus =  dropdownstatus + "</div>" + 
                            "</div>" +  
                            "<a class='vw_btn_msjsunat " +  estado_color + "' tabindex='0' role='button' data-toggle='popover' data-trigger='focus' title='" + val['estado'] + "' data-content='" + s_msj + "'>" + icon_sunat + "</a>";
        } 
        else {
            dropdownstatus = "<a class='vw_btn_msjsunat " +  estado_color + "' tabindex='0' role='button' data-toggle='popover' data-trigger='focus' title='" + val['estado'] + "' data-content='" + s_msj + "'>" + icon_sunat + " " + val['estado'] + "</a>";
        }
        if (vPermisos['p97'] == "SI") {
            btnmail = "<a class='dropdown-item' href='#' title='Editar' data-toggle='modal'  data-target='#modenviarmail'>" +
                            "<i class='far fa-file-alt mr-1'></i> Enviar a email</a>";
            btnprint = "<a target='_blank' class='dropdown-item' href='" + base_url +"tesoreria/facturacion/generar/rpgrafica/"+ vCodigo64 + "' title='Imprimir'>" +
                            "<i class='far fa-file-alt mr-1'></i> Impresión </a>";
            btnpdf = "<a target='_blank' class='dropdown-item' href='" + base_url +"tesoreria/facturacion/generar/pdf/"+ vCodigo64 + "' title='PDF'>" +
                            "<i class='far fa-file-pdf mr-1'></i> PDF </a>";
        }
        if (vPermisos['p193'] == "SI") {
            btnaddcobros = "<a class='dropdown-item text-success' href='#' title='Cobros' data-toggle='modal' data-target='#modaddcobros'>" + 
                            "<i class='far fa-credit-card mr-1'></i> Cobros </a>";
        }
        // if (vPermisos['p144'] == "SI") {
        //     $btnmatricula = "<a class='dropdown-item text-primary' href='#' title='Asignar matricula' data-toggle='modal' data-target='#modasgmatricula'>" +
        //                     "<i class='fas fa-graduation-cap mr-1'></i> Asignar matrícula</a>";
        // }
        if (vPermisos['p234']  == "SI") {
            vAutoriza="";
            if (val['autoriza_voucherantiguo']=="SI"){
                vAutoriza="NO";
                auvTexto="<i class='far fa-thumbs-up fa-flip-vertical mr-1'></i> Deshabilitar Voucher Antiguos";
            }
            else{
                vAutoriza="NO";
                auvTexto="<i class='far fa-thumbs-up mr-1'></i> Habilitar Voucher Antiguos";
            }
            btnAutorizaVoucherAntiguo = "<a onclick='fn_cambiarAutorizacionVouhersAntiguos($(this));return false;' data-autoriza='" + vAutoriza + "' class='dropdown-item text-primary' href='#' title='Asignar matricula'> " + auvTexto + "</a>";
        }
        if ((vPermisos['p102']  == "SI") && (val['estado']  == "ACEPTADO")) {
            btnanular = "<a class='dropdown-item text-danger' href='#' title='Anular' data-toggle='modal' data-target='#modanuladoc'>" + 
                    "<i class='far fa-file-alt mr-1'></i> Anular o Comunicar Baja</a>";
        }
        if ((vPermisos['p109']  == "SI") && ((val['estado']  == "PENDIENTE") || (val['estado']  == "ERROR"))) {
            btneliminar = "<a class='dropdown-item text-danger' href='#' title='Eliminar' onclick='fn_eliminar_documento($(this));return false' >" +
                    "<i class='fas fa-trash mr-1'></i> Eliminar </a>";
        }
        if ((vPermisos['p110']  == "SI") && ((val['estado']  == "PENDIENTE") || (val['estado']  == "ERROR"))) {
            btnsunat = "<a class='dropdown-item text-primary' href='#' title='Enviar a SUNAT' onclick='fn_enviar_documento_ose($(this));return false' >" +
                    "<i class='far fa-paper-plane mr-1'></i> Enviar a SUNAT </a>";
        }
        if ((vPermisos['p101']  == "SI") && (val['estado']  == "ENVIADO")) {
            btnconsultar = "<a class='dropdown-item text-info' href='#' title='Consultar a SUNAT' onclick='fn_consultar_documento_ose($(this));return false' >" + 
                    "<i class='fas fa-binoculars mr-1'></i> Consultar a SUNAT</a>";
        }
        if (val['estado']  == "ANULANDO") {
           btnconsultarAnulado="<a class='dropdown-item text-info' href='#' title='Consultar a SUNAT' onclick='fn_consultar_documento_anulado($(this));return false' >" +
                    "<i class='fas fa-binoculars mr-1'></i> Consultar Anulación a SUNAT</a>";
        }
        if ((vPermisos['p156']  == "SI") && ((val['estado']  == "PENDIENTE") || (val['estado']  == "ERROR"))) {
            btnupdateclient = "<a class='dropdown-item' href='#' title='Actualizar Pagante' onclick='fn_update_pagante_doc($(this));return false' >" + 
                    "<i class='fas fa-edit mr-1'></i> Actualizar Pagante </a>";
        }

        dropdownOpciones="<div class='btn-group dropleft drop-menu-index'>" +
                            "<button class='btn btn-primary btn-sm btn-xs dropdown-toggle py-0' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                                    "<i class='fas fa-print'></i>" + 
                            "</button>" + 
                            "<div class='dropdown-menu dropdown-menu-right drop-menu-index'>" + 
                                btnmail + 
                                btnprint + 
                                btnpdf + 
                                btnenlxml + 
                                btnaddcobros + 
                                btnanular  + 
                                btneliminar + 
                                btnsunat + 
                                btnconsultar + 
                                btnconsultarAnulado + 
                                btnmatricula + 
                                btnupdateclient + 
                                btnupdatedoc + 
                                btnAutorizaVoucherAntiguo  + 
                            "</div>" +
                        "</div>";

        vTotal = Number(val['total']).toFixed(2);
        vIGV = Number(val['igv_monto']).toFixed(2);
        vMonto = (vTotal - vIGV).toFixed(2);
        vPagante="<a href='#'  onclick='fn_mostrarDocDetalle($(this));return false;'>" +
                    val['codpagante'] + " - " + val['pagante'],
                 "</a>";
        vHistorial=(val['historial']==null) ? "Historial no registrado" : val['historial'];
        vPopOverHistorial="<a class='ml-2' tabindex='0' role='button' data-toggle='popover' data-trigger='focus' title='Historial' data-content='" +  vHistorial  + "'><i class='far fa-calendar-check'></i></a>";
        var arrayDocsPago_new = [
            (index + 1),
            val['codtipo'],
            val['serie'] + "-" + val['numero'] + vPopOverHistorial,
            val['fecha_hora'],
            dropdownstatus,
            vPagante,
            vMonto,
            vIGV,
            dropdownOpciones
        ];
        var filaDocPago_new = tbDocsPago.row.add(arrayDocsPago_new).node();
        $(filaDocPago_new).attr('data-codigo64', val['codigo64']);
        $(filaDocPago_new).attr('data-codpagante', val['codpagante']);

        $(filaDocPago_new).attr('data-pagantetipodoc', val['codtipodocidentidad']);
        $(filaDocPago_new).attr('data-pagantenrodoc', val['pagantenrodoc']);
        $(filaDocPago_new).attr('data-autorizarvoucherantiguos', val['autoriza_voucherantiguo']);
        $(filaDocPago_new).attr('data-pagante', val['pagante']);
        $(filaDocPago_new).attr('data-serie', val['serie']);
        $(filaDocPago_new).attr('data-numero', val['numero']);
        $(filaDocPago_new).attr('data-monto', vMonto);
        $(filaDocPago_new).attr('data-total', vTotal);
        $(filaDocPago_new).attr('data-igvmonto', val['igv_monto']);
        $(filaDocPago_new).addClass("cfila");
    });
    tbDocsPago.draw();
    //aCTUALIZAR EL POPOVER RESUMEN
    var vMensajeEstados="";
    var bclass="badge-warning";
    $.each( vConteoEstados, function( i, vcestado ){
       if (vcestado>0){
        vMensajeEstados= vMensajeEstados + i + ": " + vcestado + " \n \r ";
        bclass=vBadgeEstados[i];
       }
    });
    if (vMensajeEstados==""){
        $("#vw_dp_em_spn_estado").hide();
    }
    else{
        $("#vw_dp_em_spn_estado").show();
    }
    
    $("#vw_dp_em_spn_estado").attr("data-content", vMensajeEstados);
    $("#vw_dp_em_spn_estado").removeAttr('class');
    $("#vw_dp_em_spn_estado").attr('class','p-2 badge ' + bclass)
}

$("#vw_dp_em_btn_close").click(function(event) {
    //$("#divresult").height($("#divresult").height() + $('.divhide').height());
    $(".divhide").removeClass("d-block");
    $(".divhide").addClass("d-none");
});
$("#vw_dp_em_btn_consultar_docs_sunat").click(function(event) {
    $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    $.ajax({
        url: base_url + 'facturacion/fn_consultar_doc_enviados_a_nube',
        type: 'post',
        dataType: 'json',
        success: function(e) {
            $('#divCardDocPagosGeneral #divoverlay').remove();
            $("#frm_search_docpago").submit();
        },
        error: function(jqXHR, exception) {
            $('#divCardDocPagosGeneral #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divresult').html(msgf);
        }
    });
    return false;
});
$("#vw_dp_em_btn_enviar_docs_sunat").click(function(event) {
    $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    $.ajax({
        url: base_url + 'facturacion/fn_enviar_doc_pendientes_a_nube',
        type: 'post',
        dataType: 'json',
        success: function(e) {
            $('#divCardDocPagosGeneral #divoverlay').remove();
            $("#frm_search_docpago").submit();
        },
        error: function(jqXHR, exception) {
            $('#divCardDocPagosGeneral #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divresult').html(msgf);
        }
    });
    return false;
});
$("#modasgmatricula").on('show.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var fila=rel.closest('.cfila');
    var codigo = fila.data('codigo64');
    var pagante = fila.data('pagante');
    if (pagante !== "") {
        $('#divmodaladdmat').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
        $.ajax({
            url: base_url + "matricula/fn_get_inscripcion_y_matriculas_x_carne",
            type: 'post',
            dataType: 'json',
            data: {
                'fgi-txtcarne': pagante,
            },
            success: function(e) {
                $('#divmodaladdmat #divoverlay').remove();
                if (e.existe_inscrito == false) {
                    $('#fgi-apellidos').html('NO ENCONTRADO');
                } else {
                    $('#fgi-apellidos').html(pagante + "<br>" + e.vdata['paterno'] + ' ' + e.vdata['materno'] + ' ' + e.vdata['nombres']);
                    var nro = 0;
                    $("#vw_fcb_div_Hmatriculas").html("");
                    $.each(e.vmatriculas, function(index, v) {
                        nro++;
                        var btnasignamat = '';
                        var js_estado = v['estado'];
                        btnasignamat = "<button data-periodo='" + v['periodo'] + "' data-semestre='" + v['ciclo'] + "' class='btn btn-sm btn-info btnasignamat' data-codigo='" + codigo + "' data-mat='" + v['codmatricula64'] + "'><i class='fas fa-mouse-pointer'></i></button>";
                        $("#vw_fcb_div_Hmatriculas").append(
                            '<div data-idm="' + v['codmatricula64'] + '" class="row cfila rowcolor ">' +
                            '<div class="col-12 col-md-7">' +
                            '<div class="row">' +
                            '<div data-cp="' + v['codperiodo'] + '" class="cperiodo col-2 col-md-2 td">' + v['periodo'] + '</div>' +
                            '<div class="col-5 col-md-5 td text-center">' + v['plan'] + '</div>' +
                            '<div class="ccarrera col-5 col-md-5 td" data-cod="' + v['codcarrera'] + '">' + v['carrera'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-12 col-md-2">' +
                            '<div class="row">' +
                            '<div class="cciclo td col-4 col-md-4 text-center " data-cod="' + v['codciclo'] + '">' + v['ciclo'] + '</div>' +
                            '<div class="cturno td col-4 col-md-4 text-center ">' + v['codturno'] + '</div>' +
                            '<div class="cseccion td col-4 col-md-4 text-center ">' + v['codseccion'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-6 col-md-2 td">' +
                            js_estado +
                            '</div>' +
                            '<div class="col-6 col-md-1 td text-center">' +
                            btnasignamat +
                            '</div>' +
                            '</div>');
                    });
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divmodaladdmat #divoverlay').remove();
                $('#divError').show();
                $('#msgError').html(msgf);
            }
        })
    }
    // return false;
})
$("#modasgmatricula").on('hidden.bs.modal', function(e) {
    $('#fgi-apellidos').html('NO ENCONTRADO');
    $("#vw_fcb_div_Hmatriculas").html("");
})
$(document).on('click', '.btnasignamat', function(e) {
    e.preventDefault();
    var boton = $(this);
    var codigo = boton.data('codigo');
    var jssemestre = boton.data('semestre');
    var jsperiodo = boton.data('periodo');
    var codmat = boton.data('mat');
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    $.ajax({
        url: base_url + "facturacion/fn_asignar_matricula_doc",
        type: 'post',
        dataType: 'json',
        data: {
            'fgi-txtcodigo': codigo,
            'fgi-txtmat': codmat,
        },
        success: function(e) {
            $('#divmodaladdmat #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: 'Error!',
                    text: e.msg,
                    type: 'error',
                    icon: 'error',
                    backdrop: false,
                })
            } else {
                $('#modasgmatricula').modal('hide');
                var fila = $('#btnasigmat_' + codigo).closest('.cfila');
                fila.find('.txtperiodo').html(jsperiodo + " / " + jssemestre);
                Swal.fire({
                    title: 'Éxito!',
                    text: e.msg,
                    type: 'success',
                    icon: 'success',
                    backdrop: false,
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodaladdmat #divoverlay').remove();
            Swal.fire({
                title: 'Error!',
                text: msgf,
                type: 'error',
                icon: 'error',
                backdrop: false,
            })
        }
    })
});
$('.checkradio').on('change', function(e) {
    e.preventDefault();
    var check = "";
    var fecha = new Date();
    var anio = fecha.getFullYear();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var hoy = anio + "-" + (('' + mes).length < 2 ? '0' : '') + mes + "-" + (('' + dia).length < 2 ? '0' : '') + dia;
    $(".checkradio").each(function(index, el) {
        if ($(this).prop('checked') == true) {
            check = $(this).val();
            if (check == "todo") {
                $("#fictxtfecha_emision").val("");
                $("#fictxtfecha_emisionf").val("");
            } else if (check == "hoy") {
                $("#fictxtfecha_emision").val(hoy);
                $("#fictxtfecha_emisionf").val(hoy);
            } else if (check == "ayer") {
                var mesant = (('' + dia) == "1" ? mes - 1 : mes);
                var diant = new Date(anio, mes, dia - 1).getDate();
                var ayer = anio + "-" + (('' + mesant).length < 2 ? '0' : '') + mesant + "-" + (('' + diant).length < 2 ? '0' : '') + diant;
                $("#fictxtfecha_emision").val(ayer);
                $("#fictxtfecha_emisionf").val(ayer);
            } else if (check == "mes") {
                //
                var factual = new Date();
                var anio = factual.getFullYear();
                var mes = ("0" + (factual.getMonth() + 1)).slice(-2);
                var udia = new Date(anio, mes, 0).getDate();
                $("#fictxtfecha_emision").val(anio + "-" + mes + "-01");
                $("#fictxtfecha_emisionf").val(anio + "-" + mes + "-" + udia);
            } else if (check == "entre") {
                /*var uldia= new Date(anio, mes, 0).getDate();
                var ultimo = anio + "-" + ((''+mes).length<2 ? '0' : '') + mes + "-" + ((''+uldia).length<2 ? '0' : '') + uldia;
                $("#fictxtfecha_emision").val(anio + "-" + ((''+mes).length<2 ? '0' : '') + mes + "-01");
                $("#fictxtfecha_emisionf").val(ultimo);*/
            }
        }
    });
});

function fn_update_pagante_doc(btn) {
    var fila = btn.closest('.cfila');
    var codigo = fila.data('codigo64');
    var docsn = fila.data('serie') + "-" + fila.data('numero');
    
    // var docsn=fila.data('docsn');
    //************************************
    $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "facturacion/fn_datos_doc_cliente",
        type: 'post',
        dataType: 'json',
        data: {
            vw_fcb_codigo: codigo
        },
        success: function(e) {
            $('#divCardDocPagosGeneral #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "ERROR!",
                    text: "SIN RESULTADOS",
                    type: 'error',
                    icon: 'error',
                })
            } else {
                $('#vw_dp_txt_codocument').val(e.vdata['codigo64']);
                $('#vw_dp_txt_codigpagante').val(e.vdata['pagcod']);
                $('#vw_dp_txt_tipdocpagante').html(e.tiposdoc);
                $('#vw_dp_txt_tipdocpagante').val(e.vdata['pgtipodoc']);
                $('#vw_dp_txt_dnipagante').val(e.vdata['pagnrodoc']);
                $('#vw_dp_txt_dpagante').val(e.vdata['pagante']);
                $('#vw_dp_txt_direccion_pag').val(e.vdata['pagdirecion'])
                $('#modupdatepagante').modal();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divCardDocPagosGeneral #divoverlay').remove();
            Swal.fire({
                title: "ERROR!",
                text: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
}
$('#vw_dp_em_btnupdate_pag').click(function(e) {
    e.preventDefault();
    $('#frm_update_pagante input,select').removeClass('is-invalid');
    $('#frm_update_pagante .invalid-feedback').remove();
    $('#divmodalupdatepag').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    $.ajax({
        url: base_url + "facturacion/fn_update_datos_pagante",
        type: 'post',
        dataType: 'json',
        data: $('#frm_update_pagante').serialize(),
        success: function(e) {
            $('#divmodalupdatepag #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    title: 'Error!',
                    text: "Existen errores en los campos",
                    type: 'error',
                    icon: 'error',
                    backdrop: false,
                })
            } else {
                Swal.fire({
                    title: 'Éxito!',
                    text: e.msg,
                    type: 'success',
                    icon: 'success',
                    backdrop: false,
                })
                $('#modupdatepagante').modal('hide');
                $("#frm_search_docpago").submit();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalupdatepag #divoverlay').remove();
            Swal.fire({
                title: 'Error!',
                text: msgf,
                type: 'error',
                icon: 'error',
                backdrop: false,
            })
        }
    })
    return false;
});
var itemsDocumento = {};
itemsNro = 0;

function mostrar_montos() {
    //var itemsNro = 0;
    var ops_grav = 0;
    var ops_inaf = 0;
    var ops_exon = 0;
    var ops_expo = 0;
    var dsctos_globales = 0;
    var dsctos_detalles = 0;
    var ops_grat = 0;
    var js_subtotal = 0;
    var js_icbper = 0;
    var js_isc = 0;
    var js_igv = 0;
    //var pigv = 0;
    var js_total = 0;
    // console.log("itemsDocumento", itemsDocumento);
    $.each(itemsDocumento, function(ind, elem) {
        var pu = Number(elem['vw_fcb_ai_txtpreciounitario']);
        var valorventa = Number(elem['vw_fcb_ai_txtcantidad']) * pu;
        if (elem['vw_fcb_ai_cbafectacion'] == "10") {
            //GRAVADO
            valorventa_sinigv = Number(elem['vw_fcb_ai_txtvalorunitario']) * Number(elem['vw_fcb_ai_txtcantidad']);
            ops_grav = ops_grav + valorventa_sinigv;
            js_total = js_total + valorventa;
        } else if (elem['vw_fcb_ai_cbafectacion'] == "30") {
            //INAFECTO
            ops_inaf = ops_inaf + valorventa;
            js_total = js_total + valorventa;
        } else if (elem['vw_fcb_ai_cbafectacion'] == "20") {
            //EXONERADO
            ops_exon = ops_exon + valorventa;
            js_total = js_total + valorventa;
        } else if (elem['vw_fcb_ai_cbafectacion'] == "40") {
            //EXONERADO
            elem['vw_fcb_ai_txtvalorunitario'] = pu;
            elem['vw_fcb_ai_txtprecioventa'] = valorventa;
            ops_inaf = ops_inaf + valorventa;
            js_total = js_total + valorventa;
        } else {
            //GRATUITA
            ops_grat = ops_grat + valorventa;
            //js_total=js_total + valorventa;
        }
    });
    //SUBTOTAL
    js_subtotal = ops_grav + ops_exon + ops_inaf - (dsctos_globales + dsctos_detalles);
    //IGV
    js_igv = Math.round((js_total - js_subtotal - js_isc - js_icbper) * 100) / 100;
    $("#vw_fcb_txtoper_gravada").val(ops_grav);
    $("#vw_fcb_txtoper_inafecta").val(ops_inaf);
    $("#vw_fcb_txtoper_exonerada").val(ops_exon);
    $("#vw_fcb_txtoper_exportacion").val(ops_expo);
    $("#vw_fcb_txtoper_desctotal").val(dsctos_globales + dsctos_detalles);
    $("#vw_fcb_txtoper_gratuitas").val(ops_grat);
    $("#vw_fcb_txtsubtotal").val(js_subtotal);
    $("#vw_fcb_txticbpertotal").val(js_icbper);
    $("#vw_fcb_txtisctotal").val(js_isc);
    $("#vw_fcb_txtigvtotal").val(js_igv);
    $("#vw_fcb_txtsubtotal").val(js_subtotal);
    $("#vw_fcb_txttotal").val(js_total);
    $(".vw_fcb_frmcontrols").each(function() {
        $(this).val(parseFloat($(this).val()).toFixed(2));
    });
}

function fn_view_data_doc(btn) {
    var fila = btn.closest('.cfila');
    var codigo = fila.data('codigo64');
    var docsn = fila.data('serie') + "-" + fila.data('numero');

    $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "facturacion/fn_datos_documento_facturacion",
        type: 'post',
        dataType: 'json',
        data: {
            vw_fcb_codigo: codigo
        },
        success: function(e) {
            $('#divCardDocPagosGeneral #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "ERROR!",
                    text: "SIN RESULTADOS",
                    type: 'error',
                    icon: 'error',
                })
            } else {
                var estado = e.vdata['estado'];
                inputstatus = true;
                if (estado == "PENDIENTE") {
                    inputstatus = false;
                } else {
                    inputstatus = true;
                }
                $('#modupdatedocumento #vw_dp_txt_codocument').val(e.vdata['codigo64']);
                $('#modupdatedocumento #vw_fcb_txtigvp_up').val(e.vdata['igv']);
                $('#modupdatedocumento #vw_fcb_serie_up').val(e.vdata['serie']);
                $('#modupdatedocumento #vw_fcb_tipo_up').val(e.vdata['tdocid']);
                $('#modupdatedocumento #vw_fcb_sernumero_up').val(e.vdata['numero']).attr('readonly', inputstatus);
                $('#modupdatedocumento #vw_fcb_emision_up').val(e.vdata['fechaem']).attr('readonly', inputstatus);
                $('#modupdatedocumento #vw_fcb_emishora_up').val(e.vdata['horaem']).attr('readonly', inputstatus);
                $('#modupdatedocumento #vw_dp_txt_codigpagante_up').val(e.vdata['pagante']);
                $('#modupdatedocumento #vw_dp_txt_tipdocpagante_up').html(e.tiposdoc);
                $('#modupdatedocumento #vw_dp_txt_tipdocpagante_up').val(e.vdata['ptipodoc']).attr('readonly', inputstatus);
                $('#modupdatedocumento #vw_dp_txt_dnipagante_up').val(e.vdata['pnrodoc']).attr('readonly', inputstatus);
                $('#modupdatedocumento #vw_dp_txt_dpagante_up').val(e.vdata['pagantenom']).attr('readonly', inputstatus);
                $('#modupdatedocumento #vw_dp_txt_direccion_pag_up').val(e.vdata['direccion']).attr('readonly', inputstatus);
                $('#modupdatedocumento #vw_fcb_txtobservaciones').val(e.vdata['observacion']).attr('readonly', inputstatus);
                if (e.rscountmatricula > 0) {
                    var matricula = "";
                    matricula = "<option value=''>Sin Asignar</option>";
                    $.each(e.vmatriculas, function(key, mt) {
                        if (mt['estado'] !== '2') {
                            matricula = matricula + "<option value='" + mt['codigo'] + "'>" + mt['periodo'] + " - " + mt['ciclo'] + "</option>";
                        }
                    });
                } else {
                    matricula = "<option value=''>Sin Asignar</option>";
                }
                $('#modupdatedocumento #vw_fcb_ai_txtcodmatricula').html(matricula);
                $('#modupdatedocumento #vw_fcb_ai_txtcodmatricula').val(e.vdata['matriculaid']);
                pigv = e.vseries['igvpr'];
                pigv = Number(pigv) / 100;
                itemsNro = 0;
                $.each(e.vdetail, function(index, v) {
                    var itemd = {};
                    itemd['vw_fcb_ai_cbunidad'] = v['undid']
                        //llenar gestion
                    itemd['vw_fcb_ai_cbgestion'] = v['gestid'];
                    itemd['vw_fcb_ai_txtgestion'] = v['gestion'];
                    // console.log(itemd)
                    itemd['vw_fcb_ai_txtcantidad'] = v['cantidad'];
                    itemd['vw_fcb_ai_txtpreciounitario'] = v['unitariov'];
                    itemd['vw_fcb_ai_txtprecioventa'] = v['ventaval'];
                    itemd['vw_fcb_ai_txtcoddeuda'] = v['deudaid'];
                    itemd['vw_fcb_ai_txtcodmatricula_det'] = v['codmat'];
                    itemd['vw_fcb_ai_cod_detalle'] = v['cod64det'];
                    itemd['vw_fcb_ai_cbiscfactor'] = v['dfactor'];
                    itemd['vw_fcb_ai_cbafectaigv'] = v['igvafect'];
                    itemd['vw_fcb_ai_txtiscvalor'] = v['iscvalor'];
                    itemd['vw_fcb_ai_txtiscbase'] = v['iscbimp'];
                    itemd['vw_fcb_ai_txtdsctvalor'] = v['dvalor'];
                    itemd['vw_fcb_ai_cbdsctfactor'] = v['dfactor'];
                    itemd['vw_fcb_ai_cbtipoitem'] = v['tipoitem'];
                    itemd['vw_fcb_ai_cbgratis'] = v['esgratis'];
                    itemd['vw_fcb_ai_cbafectacion'] = v['tafigv'];
                    itemd['vw_fcb_ai_txtcodmatricula_det'] = v['idmatricula'];
                    var pu = Number(itemd['vw_fcb_ai_txtpreciounitario']);
                    var valorventa = Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
                    if (itemd['vw_fcb_ai_cbafectacion'] == "10") {
                        //GRAVADO
                        itemd['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
                        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                    } else if (itemd['vw_fcb_ai_cbafectacion'] == "30") {
                        //INAFECTO
                        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
                        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                    } else if (itemd['vw_fcb_ai_cbafectacion'] == "20") {
                        //EXONERADO
                        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
                        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                    } else if (itemd['vw_fcb_ai_cbafectacion'] == "40") {
                        //EXONERADO
                        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
                        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                    } else {
                        //GRATUITA
                        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
                        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
                    }
                    var row = $("#vw_fcb_rowitem").clone();
                    row.attr('id', 'vw_fcb_rowitem' + itemsNro);
                    row.data('arraypos', itemsNro);
                    itemsDocumento[itemsNro] = itemd;
                    itemsNro++;
                    row.find('input,select').each(function(index, el) {
                        if ($(this).attr('name') == "vw_fcb_ai_txtcodmatricula_det") {
                            $(this).html(matricula);
                        }
                        if ($(this).hasClass('divcard_campos_read')) {
                            $(this).attr('readonly', inputstatus);
                        }
                        $(this).val(itemd[$(this).attr('name')]);
                    });
                    row.show();
                    $('#divcard_detail_doc').append(row);
                })
                mostrar_montos();
                $('#modupdatedocumento').modal();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divCardDocPagosGeneral #divoverlay').remove();
            Swal.fire({
                title: "ERROR!",
                text: msgf,
                type: 'error',
                icon: 'error',
            })
        }
    });
    return false;
}
$("#modupdatedocumento").on('hidden.bs.modal', function(e) {
    $('#divcard_detail_doc .rowcolor').remove();
    $.each(itemsDocumento, function(ind, elem) {
        delete itemsDocumento[ind];
        mostrar_montos();
    })
})

function fn_update_concepto(txt) {
    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');
    var concepto = fila.find('input[name="vw_fcb_ai_txtgestion"]').val();
    itemsDocumento[pos]['vw_fcb_ai_txtgestion'] = concepto;
    // console.log("itemsDocumento", itemsDocumento);
}

function fn_update_precios(txt) {
    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');
    var pu = Number(fila.find('input[name="vw_fcb_ai_txtpreciounitario"]').val());
    itemsDocumento[pos]['vw_fcb_ai_txtpreciounitario'] = pu;
    var vcnt = fila.find('input[name="vw_fcb_ai_txtcantidad"]').val();
    var valorventa = Number(vcnt) * pu;
    itemsDocumento[pos]['vw_fcb_ai_txtcantidad'] = vcnt;
    var afectacion = itemsDocumento[pos]['vw_fcb_ai_cbafectacion'];
    console.log("IGV", pigv);
    if (afectacion == "10") {
        //GRAVADO
        itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
        itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
    } else if (afectacion == "30") {
        //INAFECTO
        itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
        itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
    } else if (afectacion == "20") {
        //EXONERADO
        itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
        itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
    } else if (afectacion == "40") {
        //EXONERADO
        itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
        itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
    } else {
        //GRATUITA
        itemsDocumento[pos]['vw_fcb_ai_txtvalorunitario'] = pu;
        itemsDocumento[pos]['vw_fcb_ai_txtprecioventa'] = valorventa;
    }
    fila.find('input[name="vw_fcb_ai_txtprecioventa"]').val(valorventa);
    console.log("itemsDocumento", itemsDocumento)
    mostrar_montos();
}

function fn_update_cod_deuda(txt) {
    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');
    var coddeuda = fila.find('input[name="vw_fcb_ai_txtcoddeuda"]').val();
    itemsDocumento[pos]['vw_fcb_ai_txtcoddeuda'] = coddeuda;
}

function fn_update_cod_matricula_deta(txt) {
    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');
    // var codigomat = fila.find('input[name="vw_fcb_ai_txtcodmatricula_det"] option:selected').val();
    var codigomat = txt.val();
    console.log("codigomat", codigomat);
    itemsDocumento[pos]['vw_fcb_ai_txtcodmatricula_det'] = codigomat;
    console.log("itemsDocumento", itemsDocumento);
}
$("#vw_dp_em_btnupdate_docum").click(function(e) {
    e.preventDefault();
    // modmatricula = false;
    // $('#divdata_detalle input[name="vw_fcb_ai_cbgestion"]').each(function() {
    //     campo = $(this).val();
    //     if ((campo == "01.01") || (campo == "01.02") || (campo == "01.03")) {
    //         modmatricula = true;
    //     }
    // })
    if ($('#vw_dp_txt_dnipagante_up').val() == "") {
        Swal.fire(
            'Cliente!',
            "Debes indicar un cliente registrado",
            'warning'
        );
        return false;
    }
    //alert(itemsDocumento.size();)
    if (($.isEmptyObject(itemsDocumento)) || (itemsDocumento.length == 0)) {
        Swal.fire(
            'Items!',
            "Se necesitan Items para generar un documento de pago",
            'warning'
        );
        return false;
    }
    $('#divmodalupdatedocum').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    // $('.vw_fcb_frmcontrols').attr('readonly', false);
    // $('.vw_fcb_class_rowitem input,select').attr('readonly', false);
    var formData = new FormData($("#frm_update_documento")[0]);
    formData.append('vw_fcb_items', JSON.stringify(itemsDocumento));
    $.ajax({
        url: base_url + 'facturacion/fn_actualizar_docpago',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(e) {
            $('#divmodalupdatedocum #divoverlay').remove();
            if (e.status == true) {
                // if (modmatricula == true) {
                //     datos_carne($('#vw_fcb_codpagante').val(), e.coddocpago);
                // }
                $("#modupdatedocumento").modal('hide');
                Swal.fire({
                        title: 'Éxito!',
                        text: 'Los datos fueron actualizados correctamente.',
                        type: 'success',
                        icon: 'success',
                        backdrop: false,
                    })
                    // Swal.fire(
                    //     'Exito!',
                    //     'Los datos fueron actualizados correctamente.',
                    //     'success'
                    // );
            } else {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                // $('.vw_fcb_frmcontrols').attr('readonly', true);
                // $('.vw_fcb_class_rowitem input,select').attr('readonly', true);
                Swal.fire(
                    'Error!',
                    e.msg,
                    'error'
                )
            }
        },
        error: function(jqXHR, exception) {
            $('#divmodalupdatedocum #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                'Error!',
                msgf,
                'error'
            )
        }
    });
    return false;
});
$('#vw_fcb_ai_cbisc').change(function(event) {
    //var jvunidad=$(this).find(':selected').data('unidad');
    var jvcod_isc = $(this).val();
    $('#vw_fcb_ai_diviscbase').hide();
    switch (jvcod_isc) {
        case "SAV":
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                $(this).show();
            });
            break;
        case "AMF":
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                if ($(this).val() == "1") {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $("#vw_fcb_ai_cbiscfactor").val("1");
            break;
        case "PVP":
            $('#vw_fcb_ai_diviscbase').show();
            $("#vw_fcb_ai_cbiscfactor option").each(function(i) {
                if ($(this).val() == "100") {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $("#vw_fcb_ai_cbiscfactor").val("100");
            break;
    }
    /*$('#vw_fcb_ai_cbunidad').val(jvunidad);
    $('#vw_fcb_ai_txtcantidad').val(1);
    $('#vw_fcb_ai_txtpreciounitario').focus();*/
});

function fn_cambiarestadobol(btn) {
    fila = btn.closest('.cfila');
    
    var docsn = fila.data('serie') + "-" + fila.data('numero') ;
    iddoc = fila.data('codigo64');
    var estado = btn.data('estado');
    var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
    var texto = btn.find('small').html();
    var contenedor = btn.data('campo');
    $('#divCardDocPagosGeneral').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    Swal.fire({
        title: "Precaución",
        text: "¿Deseas cambiar el estado del documento " + docsn + "?",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, cambiar!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + 'facturacion/fn_cambiarestado_doc',
                type: 'post',
                dataType: 'json',
                data: {
                    'ce-iddoc': iddoc,
                    'ce-nestado': estado
                },
                success: function(e) {
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'Error!',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {
                        btdt.removeClass('btn-danger');
                        btdt.removeClass('btn-success');
                        btdt.removeClass('btn-warning');
                        btdt.removeClass('btn-secondary');
                        switch (texto) {
                            case "ACEPTADO":
                                btdt.addClass('btn-success');
                                btdt.html("<small>ACEPTADO</small>");
                                break;
                            case "ANULADO":
                                btdt.addClass('btn-danger');
                                btdt.html("<small>ANULADO</small>");
                                break;
                            case "RECHAZADO":
                                btdt.addClass('btn-danger');
                                btdt.html("<small>RECHAZADO</small>");
                                break;
                            case "ENVIADO":
                                btdt.addClass('btn-primary');
                                btdt.html("<small>ENVIADO</small>");
                                break;
                            case "PENDIENTE":
                                btdt.addClass('btn-warning');
                                btdt.html("<small>PENDIENTE</small>");
                                break;
                            case "ERROR":
                                btdt.addClass('btn-danger');
                                btdt.html("<small>ERROR</small>");
                                break;
                            case "OBSERVADO":
                                btdt.addClass('btn-danger');
                                btdt.html("<small>OBSERVADO</small>");
                                break;
                            default:
                                btdt.addClass("btn-warning");
                        }
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Felicitaciones, estado actualizado',
                            text: 'Se ha actualizado el estado',
                            backdrop: false,
                        })
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divCardDocPagosGeneral #divoverlay').remove();
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error',
                        text: msgf,
                        backdrop: false,
                    })
                }
            });
            return false;
        } else {
            $('#divCardDocPagosGeneral #divoverlay').remove();
        }
    });
}

function fn_vw_vincular_deudas(btn) {
    $("#modDeudas_asignar").modal('show');
    $("#divres_historialdeuda .cfila").removeClass("bg-selection");
    $('#modDeudas_asignar .modDeudas_asignar_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    //vw_md_pagos_estudiante
    fila = btn.closest(".cfila");
    fila.addClass("bg-selection");
    var carnet = fila.data('pagante');
    var alumno = fila.data('nompagante');
    var idocdetalle = fila.data('iddetalle');
    var montopg = fila.data('monto');
    var gestion = fila.data('gestion');
    var boleta = fila.data('boleta');
    var iddeuda = fila.data('iddeuda');
    $("#vw_md_pagos_estudiante").html("<span class='text-danger'>(" + carnet + ") </span>" + alumno);
    $('#vw_md_detalle_documento').html(boleta);
    $('#vw_md_detalle_gestion').html(gestion);
    tbpagospg = $('#tbmt_dtDeudas').DataTable();
    $.ajax({
        url: base_url + 'facturacion/fn_datos_deudas_estudiante',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-carne': carnet
        },
        success: function(e) {
            $('#modDeudas_asignar .modDeudas_asignar_content #divoverlay').remove();
            tbpagospg.clear();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                var nro = 0;
                // var tabla = "";
                var boton = "";
                $.each(e.vdata, function(index, v) {
                    nro++;
                    if (iddeuda == v['codigo']) {
                        boton = "<div class='divbtnasigna'><a href='#' onclick='fn_vw_desvincular_pago($(this));return false;' class='badge badge-secondary'>Desvincular</a></div>";
                    } else {
                        boton = "<div class='divbtnasigna'><a href='#' onclick='fn_vw_vincular_pago($(this));return false;' class='badge badge-primary'>Asignar</a></div>";
                    }
                    deudor = v['paterno'] + " " + v['materno'] + " " + v['nombres'];
                    saldodeuda = "<div class='dsaldo'>" + v['saldo'] + "</div>";
                    var fila = tbpagospg.row.add([index + 1, v['codigo'], v['gestion'], v['monto'], saldodeuda, v['vence'], v['grupo'], boton]).node();
                    $(fila).attr('data-coddeuda', v['codigo64']);
                    $(fila).attr('data-coddetalle', idocdetalle);
                    //         $(fila).attr('data-boleta', v['serie'] + "-" + v['numero']);
                    $(fila).attr('data-saldo', v['saldo']);
                    $(fila).attr('data-montopg', montopg);
                    $(fila).attr('class', "rowcolor");
                });
                tbpagospg.draw();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modDeudas_asignar .modDeudas_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
}

function fn_vw_vincular_pago(btn) {
    $("#modDeudas_asignar").modal('show');
    $('#modDeudas_asignar .modDeudas_asignar_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    //vw_md_pagos_estudiante
    fila = btn.closest(".rowcolor");
    var cdocument = fila.data('coddetalle');
    var cdeuda = fila.data('coddeuda');
    var montopg = fila.data('montopg');
    var saldodeu = fila.data('saldo');
    $.ajax({
        url: base_url + "facturacion/fn_vincular_pago_con_deuda",
        type: 'post',
        dataType: 'json',
        data: {
            coddocumento: cdocument,
            coddeuda: cdeuda
        },
        success: function(e) {
            $('#modDeudas_asignar .modDeudas_asignar_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Ocurrio un error",
                    text: e.msg,
                    type: 'error',
                    icon: 'error',
                })
            } else {
                totsaldo = Number(saldodeu) - Number(montopg);
                fila.find('.dsaldo').html(totsaldo.toFixed(2));
                fila.data('saldo', totsaldo);
                fila.find('.divbtnasigna').html("<a href='#' onclick='fn_vw_desvincular_pago($(this));return false;' class='badge badge-secondary'>Desvincular</a>");
                // if (totsaldo < 0) {
                //     fila.remove();
                // }
                // fila.find(".vw_mdp_spcoddeuda").html(e.coddeuda);
                //$('#tbdd_form_search_deudas').submit();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modDeudas_asignar .modDeudas_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
}

function fn_vw_desvincular_pago(btn) {
    $("#modDeudas_asignar").modal('show');
    $('#modDeudas_asignar .modDeudas_asignar_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    //vw_md_pagos_estudiante
    fila = btn.closest(".rowcolor");
    var cdocument = fila.data('coddetalle');
    var cdeuda = fila.data('coddeuda');
    var montopg = fila.data('montopg');
    var saldodeu = fila.data('saldo');
    $.ajax({
        url: base_url + "facturacion/fn_desvincular_pago_con_deuda",
        type: 'post',
        dataType: 'json',
        data: {
            coddetalle: cdocument,
            coddeuda: cdeuda
        },
        success: function(e) {
            $('#modDeudas_asignar .modDeudas_asignar_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Ocurrio un error",
                    text: e.msg,
                    type: 'error',
                    icon: 'error',
                })
            } else {
                // fila.find(".vw_mdp_spcoddeuda").html(0);
                totsaldo = Number(saldodeu) + Number(montopg);
                fila.find('.dsaldo').html(totsaldo.toFixed(2));
                fila.data('saldo', totsaldo);
                fila.find('.divbtnasigna').html("<a href='#' onclick='fn_vw_vincular_pago($(this));return false;' class='badge badge-primary'>Asignar</a>");
                //$('#tbdd_form_search_deudas').submit();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modDeudas_asignar .modDeudas_asignar_content #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });
}
</script>