<?php
$vbaseurl=base_url();
date_default_timezone_set ('America/Lima');
$vuser=$_SESSION['userActivo'];
?>
<style>
    .custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #38b44a !important;
    background: #38b44a !important;
}
</style>
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<div class="content-wrapper">
    <section id="s-cargado" class="content pt-1">
        <div class="card card-primary card-tabs" id="divCardTarifas">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tabTarifarioGeneral-tab" data-toggle="pill" href="#tabTarifarioGeneral" role="tab" aria-controls="tabTarifarioGeneral" aria-selected="true">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tabTarifarioMatriculas-tab" data-toggle="pill" href="#tabTarifarioMatriculas" role="tab" aria-controls="tabTarifarioMatriculas" aria-selected="false">Matrículas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tabTarifarioPensiones-tab" data-toggle="pill" href="#tabTarifarioPensiones" role="tab" aria-controls="tabTarifarioPensiones" aria-selected="false">Pensiones</a>
                    </li>
                    
                    
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade show active" id="tabTarifarioGeneral" role="tabpanel" aria-labelledby="tabTarifarioGeneral-tab">
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
                                <table id="tbtf_dtgeneral" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                  <thead>
                                    <tr class="bg-lightgray">
                                      <th>N°</th>
                                      <th>CÓD</th>
                                      <th>SEDE</th>
                                      <th>CONCEPTO</th>
                                      <th>CATEGORÍA</th>
                                      <th>TARIFA</th>
                                      <th>ACTIVO</th>
                                      <th>--</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabTarifarioMatriculas" role="tabpanel" aria-labelledby="tabTarifarioMatriculas-tab">
                        
                    </div>
                    <div class="tab-pane fade" id="tabTarifarioPensiones" role="tabpanel" aria-labelledby="tabTarifarioPensiones-tab">
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script type="text/javascript">
    var cargaDataGestiones=<?php echo json_encode($gestion); ?>;
    var cargaDataTarifas=<?php echo json_encode($tarifario); ?>;
    var cargaDataSedes=<?php echo json_encode($sedes); ?>;
    $(document).ready(function() {
        $('#tbtf_dtgeneral').DataTable({
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
                "targets": [1], // your case first column
                "className": "text-center",
            },
            {
                "targets": [5], // your case first column
                "className": "text-right",
                "width": "80px"
            },   
            {
                targets:[5],
                render: function(data, type, row) {
                    var numero = Number(data).toFixed(2);
                    //var displayString = data.toFixed(2);
                    if (type === 'display' || type === 'filter') {
                        return data + '<a href="#" class="ml-1 badge badge-warning py-1" onclick="fn_vw_editarTarifaGeneral($(this));return false;" title="Editar Tarifa"><i class="fas fa-pencil-alt fa-lg"></i></a>';
                    } else {
                        return numero; // for sorting
                    }
                },
            },
            {
                targets:[6],
                "className": "text-center",
                render: function(data, type, row) {
                    console.log(row);
                    var check = "";
                    var id="vwdttg_check" + row[0];
                    if(data=="SI"){
                        check = "checked";
                    }
                    var boton='<div class="custom-control custom-switch">' +
                                '<input ' + check + ' class="custom-control-input" type="checkbox" id="' + id + '">' +
                                '<label class="custom-control-label" for="' + id + '"></label>' +
                          '</div>';
                    if (type === 'display' || type === 'filter') {
                        return boton;
                    } else {
                        return data; // for sorting
                    }
                },
            }
            ],
            'searching': false,
        });
        fn_filtrarTarifasGeneralCargarDataTable(cargaDataGestiones,cargaDataTarifas);
        //cargaDataGestiones=null;
    });
    

    function fn_filtrarTarifasGeneralCargarDataTable(dataGestiones,dataTarifas){
    tbTarifasGeneral = $('#tbtf_dtgeneral').DataTable();
    tbTarifasGeneral.clear();    
    var encontro=false;
    var rowEncontrado=null;
    var cargaDataSedesSelects=[];
    
    if ($("#cbosede").val()=="%"){
        cargaDataSedesSelects=cargaDataSedes;
    }
    else{
        $.each(cargaDataSedes, function(indexs, vals) {

            if (vals['id']==$("#cbosede").val()){

                cargaDataSedesSelects.push(vals);
            }
        });
    }

    $("#vwdttg_tarifa").blur(function(event) {
        /* Act on the event */
    });
    $.each(cargaDataSedesSelects, function(indexs, vals) {
        $.each(dataGestiones, function(indexg, valg) {

            encontro=false;
            arrayGestionTarifa_new=null;
            rowEncontrado=null;
            btneditar = "";
            dropdownOpciones="";
            $.each(dataTarifas, function(index, val) {
                if ((val['codgestion']==valg['codgestion']) && (val['codsede']==vals['id'])){
                    encontro=true;
                    rowEncontrado=val;
                }
                
                

                
                // if ((vPermisos['p156']  == "SI") && ((val['estado']  == "PENDIENTE") || (val['estado']  == "ERROR"))) {
                //     btnupdateclient = "<a class='dropdown-item' href='#' title='Actualizar Pagante' onclick='fn_update_pagante_doc($(this));return false' >" + 
                //             "<i class='fas fa-edit mr-1'></i> Actualizar Pagante </a>";
                // }

                dropdownOpciones="<div class='btn-group dropleft drop-menu-index'>" +
                                    "<button class='btn btn-primary btn-sm btn-xs dropdown-toggle py-0' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                                            "<i class='fas fa-print'></i>" + 
                                    "</button>" + 
                                    "<div class='dropdown-menu dropdown-menu-right drop-menu-index'>" + 
                                        
                                        " "  + 
                                    "</div>" +
                                "</div>";

                
                
            });
            tarifa=0;
            vCodSede=vals['id'];
            vcodtarifa64="0";
            vCodGestion=valg['codgestion'];
            btneditar = "";//'<a href="#" class="ml-1 badge badge-warning py-1" onclick="fn_vw_editarTarifaGeneral($(this));return false;" title="Editar Tarifa"><i class="fas fa-pencil-alt fa-lg"></i></a>';
            if (encontro==true){
                tarifa=rowEncontrado['tarifa'];
                vCodSede=rowEncontrado['codsede'];
                vcodtarifa64=rowEncontrado['codtarifa64'];
                vCodGestion=rowEncontrado['codgestion'];
                arrayGestionTarifa_new = [
                    (indexg + 1),
                    rowEncontrado['codtarifa'],
                    rowEncontrado['sede_abrevia'],
                    rowEncontrado['codgestion'] + " - " + rowEncontrado['gestion'],
                    rowEncontrado['codcategoria'] + " - " + rowEncontrado['categoria'],
                    tarifa + btneditar,
                    rowEncontrado['habilitado'],
                    dropdownOpciones
                ];
            }
            else{
                //tarifa='<input type="number" step="0.01" class="form-control form-control-sm vwdttg_tarifa text-right" value="' + '0' + '">';    

                arrayGestionTarifa_new = [
                    (indexg + 1),
                    "0",
                    vals['abrevia'],
                    valg['codgestion'] + " - " + valg['gestion'],
                    valg['codcategoria'] + " - " + valg['categoria'],
                    tarifa + btneditar,
                    "-",
                    dropdownOpciones
                ];
            }
            
            var filaTarifaGeneral_new = tbTarifasGeneral.row.add(arrayGestionTarifa_new).node();
            $(filaTarifaGeneral_new).attr('data-codtarifa64', vcodtarifa64);
            $(filaTarifaGeneral_new).attr('data-codsede', vCodSede);
            $(filaTarifaGeneral_new).attr('data-codgestion', vCodGestion);
            $(filaTarifaGeneral_new).attr('data-tarifa', tarifa);
            $(filaTarifaGeneral_new).addClass("cfila");
        });
    });
    tbTarifasGeneral.draw();
}

function fn_vw_editarTarifaGeneral(btn){
        
        var fila=btn.closest(".cfila");
        var vcodtarifa64=fila.data('codtarifa64');
        var tarifaActual=fila.data('tarifa');
        var vCodSede=fila.data('codsede');
        var vCodGestion=fila.data('codgestion');

        (async () => {
            const { value: text } = await Swal.fire({
              input: "number",
              inputLabel: "Ingresa Tarifa:",
              inputPlaceholder: "Tarifa",
              inputAttributes: {
                "aria-label": "Tarifa" 
                },
              showCancelButton: true
            });
            if (text) {
                if ($.isNumeric(text)){
                    if (Number(text)!=Number(tarifaActual)){
                        $('#divCardTarifas').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
                        $.ajax({
                            url: base_url + 'tesoreria/tarifario/fn_guardar',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                txtcodtarifa64: vcodtarifa64,
                                txtcodsede: vCodSede,
                                txtcodgestion: vCodGestion,
                                txttarifa: text
                            },
                            success: function(e) {
                                $('#divCardTarifas #divoverlay').remove();
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
                                    
                                    //fn_filtrarAjustes($("#vw_deudaModalAjustes #vw_dma_txtcoddeuda64").val());
                                }
                            },
                            error: function(jqXHR, exception) {
                                var msgf = errorAjax(jqXHR, exception, 'text');
                                $('#divCardTarifas #divoverlay').remove();
                                Swal.fire({
                                    title: msgf,
                                    icon: 'error',
                                })
                            }
                        });
                    }
                    
                }
                else{
                    Swal.fire({
                        title: "Ingresa un número!",
                        // text: "",
                        icon: 'error',
                    })
                }   
            }
        })();

        
        return false;
    }
</script>
