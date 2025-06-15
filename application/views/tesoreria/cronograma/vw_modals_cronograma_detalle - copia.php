
<div class="modal modal-fullscreen fade" id="modCronogramaDetalle" tabindex="-1" role="dialog" aria-labelledby="modCronogramaDetalle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content modEnrolados_content">
            <div class="modal-header">
                <h5 class="modal-title" >Crograna de Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" value="0" id="vw_cmd_codCalendario64">
                <input type="hidden" value="0" id="vw_cmd_codCalendario">
                <input type="hidden" value="0" id="vw_cmd_codPeriodo">
                <input type="hidden" value="0" id="vw_cmd_codSede">
                

                <!-- <input type="hidden" value="0" id="vw_cmd_codCalendario_tx"> -->
            </div>
            <div class="modal-body">
                <div id="divMdoalCronogramaDetalle">
                  
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="md_enrolados-tab" data-toggle="tab" href="#md_enrolados" role="tab" aria-controls="md_enrolados" aria-selected="true">Grupos matriculados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="md_fechas-tab" data-toggle="tab" href="#md_fechas" role="tab" aria-controls="md_fechas" aria-selected="false">Fechas</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="md_asistencia-tab" data-toggle="tab" href="#md_asistencia" role="tab" aria-controls="md_asistencia" aria-selected="false">Asistencia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="md_evaluaciones-tab" data-toggle="tab" href="#md_evaluaciones" role="tab" aria-controls="md_evaluaciones" aria-selected="false">Evaluaciones</a>
                        </li> -->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="md_enrolados" role="tabpanel" aria-labelledby="md_enrolados-tab">
                            <div class="table-responsive">
                                <table id="tbcg_dtGrupos" class="tbdatatable tbdatatableModal table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                    <thead>
                                        <tr class="bg-lightgray ">
                                            <th>N°</th>
                                            <th>PERIODO</th>
                                            <th>PROGRAMA</th>
                                            <th>SEMESTRE</th>
                                            <th>TURNO</th>
                                            <th>SECCION</th>
                                            <th>MAT.</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="md_fechas" role="tabpanel" aria-labelledby="md_fechas-tab">
                            <div class="table-responsive">
                                <table id="tbce_dtFechas" class="tbdatatable tbdatatableModal table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                    <thead>
                                        <tr class="bg-lightgray ">
                                            <th>N°</th>
                                            <th>VENCE</th>
                                            <th>NOMBRE</th>
                                            <th>ITEMS</th>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modProyectarMatriculas" tabindex="-1" role="dialog" aria-labelledby="modProyectarMatriculas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Duplicar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="divModalProyectarMatriculas">
                <input type="hidden" value="0" id="vw_mdpm_codGrupoCalendario64">
                <div class="form-group has-float-label col-12 col-md-12">
                      <select  class="form-control form-control-sm" id="vw_mdpm_cbperiodo" name="vw_mdpm_cbperiodo" placeholder="Periodo">
                        <option selected value="0">--</option>
                        <?php 
                          foreach ($periodos as $periodo) {

                            echo "<option data-estado='$periodo->estado' value='$periodo->codigo'>$periodo->nombre</option>";
                          } 
                        ?>
                      </select>
                      <label for="vw_mdpm_cbperiodo"> Periodo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" onclick='fn_proyectarMatriculas_PorGrupo($(this));return false' class="btn btn-primary">Proyectar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function vw_abrir_modal_cronogramaDetalle(boton){
        fila=boton.closest(".cfila");
        $('#divMdoalCronogramaDetalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var vcodcalendario64 = fila.data("codcalendario64");
        var vcodcalendario = fila.data("codcalendario");
        var calendario = fila.data('calendario');
        var nombreCalendario = fila.data('nombrecal');
        var codperiodo = fila.data('codperiodo');
        var periodo = fila.data('periodo');
        var codsede = fila.data('codsede');
        var sede = fila.data('sede');
        
        $("#modCronogramaDetalle .modal-title").html(sede + " | "  + periodo + " | Cronograma: <span class='text-primary'>" + nombreCalendario+ "</span>");
        
        $("#vw_cmd_codCalendario64").val(vcodcalendario64);
        $("#vw_cmd_codCalendario").val(vcodcalendario);
        $("#vw_cmd_codPeriodo").val(codperiodo);
        $("#vw_cmd_codSede").val(codsede);
        $.ajax({
            url: base_url + "deudas/deudas_calendario_grupo/fn_getGruposPorCalendario",
            type: 'post',
            dataType: 'json',
            data: {
                txtcodcalendario64: vcodcalendario64
            },
            success: function(e) {
                $('#divMdoalCronogramaDetalle #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                } else {
                    tbGrupos = $('#tbcg_dtGrupos').DataTable();
                    tbGrupos.clear();
                    

                    $.each(e.vgrupos, function(index, val) {
                        var linkRemoverGrupo="<a title='Remover grupo' class='text-danger mx-1' href='#' onclick='fn_removerGrupo($(this));return false'><i class='far fa-trash-alt'></i></a>";
                        var linkGenerarDeudas="<a title='Generar / Sincronizar Deudas' class='text-primary mx-1' href='#' onclick='fn_GenerarVincularDeudasConPagosAutomaticamente_PorGrupo($(this));return false'><i class='fas fa-sync-alt'></i></a>";
                         var linkProyectarMatriculas="<a title='Proyectar matrículas' data-proyectarorigen='grupo' class='text-primary mx-1' href='#' onclick='vw_abrir_modal_proyectarMatriculas($(this));return false'><i class='fas fa-hourglass-start'></i> </a>";


                        var arrayGrupo_new = [
                            (index + 1) ,
                            val['periodo'] ,
                            val['carrera'] ,
                            val['ciclo'] ,
                            val['turno'] ,
                            val['seccion'],
                            val['generadas'] + "/" + val['matriculas'],
                            linkRemoverGrupo + linkGenerarDeudas + linkProyectarMatriculas
                        ];

                        var filaGrupo_new = tbGrupos.row.add(arrayGrupo_new).node();
                        $(filaGrupo_new).attr('data-codperiodo', val['codperiodo'] );
                        $(filaGrupo_new).attr('data-codcarrera', val['codcarrera'] );
                        $(filaGrupo_new).attr('data-codciclo', val['codciclo'] );
                        $(filaGrupo_new).attr('data-codturno', val['codturno'] );
                        $(filaGrupo_new).attr('data-codseccion', val['codseccion'] );
                        $(filaGrupo_new).attr('data-codgrupo64', val['codgrupo64'] );
                        $(filaGrupo_new).addClass("cfila");

                    });
                    tbGrupos.draw();

                    fnp_llenarDatatableFechas(e.vfechas);
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divMdoalCronogramaDetalle #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    type: 'error',
                    icon: 'error',
                })
            }
        });
        $('#modCronogramaDetalle').modal("show");

    }
    function fnp_llenarDatatableFechas(vfechas){
        tbfechas = $('#tbce_dtFechas').DataTable();
        tbfechas.clear();
        $.each(vfechas, function(index, val) {
            var linkRemoverFecha="";//<a class='text-danger' href='#' onclick='fn_removerGrupo($(this));return false'><i class='far fa-trash-alt'></i></a>"
            vdetalle="";
            $.each(val['items'], function(index, item) {
                vdetalle=vdetalle + 
                        "<div class='col-12'>" +
                            "<div class='row cfilaItem' data-codfechaitem='" + item['codfechaitem'] + "'>" + 
                                "<div class='col-7'>" +
                                    "<a title='Eliminar' class='badge badge-danger mx-1 px-1 text-white' href='#' ><i class='fas fa-minus-square'></i>" +
                                    "</a>" +
                                    item['codgestion'] + " " + item['gestion'] + 
                                "</div>" +
                                "<div class='col-2 text-rigth pr-1'>" + item['monto'] +"</div>" + 
                                "<div class='col-2 text-center'>" + 
                                    "<a class='badge badge-warning mx-1 px-1' href='#' data-toggle='modal' data-target='#modMantCalendario' data-accion='Editar'><i class='fas fa-edit'></i>" +
                                    "</a>" +
                                "</div>" + 
                            "</div>" +
                        "</div>";
            });
            vdetalle=   "<div class='row'>" + vdetalle + "</div>";
            vnombre=    "<div class='col-8'>" +
                            val['descripcion'] + " (" + val['codigo']  + ") " + 
                           
                                "<a title='Editar' data-toggle='tooltip' data-placement='bottom' class='badge badge-warning p-1 mx-1' href='#' onclick='fn_vw_agregar_fecha($(this));return false' data-accion='editar'><i class='fas fa-edit'></i>" + 
                                "</a>" + 
                           
                        "</div>" + 
                        "<div class='col-4 text-center'>" + 
                            "<a title='Agregar Item de pago' class='badge badge-primary mx-1 px-1 text-white' href='#' data-toggle='modal' data-target='#modMantCalendario' data-accion='Nuevo'><i class='fas fa-plus-square mr-1'></i> Agregar Item" +
                            "</a>" +
                        "</div>" ;
            vnombre="<div class='row'>" + vnombre + "</div>";
            var arrayFecha_new = [
                (index + 1) ,
                val['fecha'] ,
                vnombre,
                vdetalle,
                linkRemoverFecha
            ];
            var filaFecha_new = tbfechas.row.add(arrayFecha_new).node();
            $(filaFecha_new).attr('data-codigo64', val['codigo64'] );
            $(filaFecha_new).attr('data-descripcion', val['descripcion'] );
            $(filaFecha_new).attr('data-fecha', val['fecha'] );
            $(filaFecha_new).addClass("cfila");

        });
        tbfechas.draw();
    }
    function fn_removerGrupo(boton){
        fila=boton.closest(".cfila");
        Swal.fire({
          title: "¿Deseas remover el grupo seleccionado de este CRONOGRAMA?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Remover"
        }).then((result) => {
          if (result.isConfirmed) {
            $('#divMdoalCronogramaDetalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var vcodgrupo64 = fila.data("codgrupo64");
            $.ajax({
                url: base_url + "deudas/deudas_calendario_grupo/fn_EliminarGrupoDeCalendario",
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodgrupo64: vcodgrupo64
                },
                success: function(e) {
                    $('#divMdoalCronogramaDetalle #divoverlay').remove();
                    if (e.status == false) {
                        $.each(e.errors, function(key, val) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                        });
                    } else {
                        tbGrupos = $('#tbcg_dtGrupos').DataTable();
                        var rows = tbGrupos.rows('.selected').remove().draw();
                        Swal.fire({
                            title: "Removido",
                            // text: "",
                            icon: 'success',
                        })

                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divMdoalCronogramaDetalle #divoverlay').remove();
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        icon: 'error',
                    })
                }
            });
           
          
          }
        });    
    }
    function fn_GenerarVincularDeudasConPagosAutomaticamente_PorGrupo(boton){
        var vcodcalendario64=$("#vw_cmd_codCalendario64").val();
        fila=boton.closest(".cfila");
        Swal.fire({
          title: "¿Deseas Generar las deudas del grupo seleccionado de este CRONOGRAMA?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Generar"
        }).then((result) => {
          if (result.isConfirmed) {
            $('#divMdoalCronogramaDetalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var vcodgrupo64 = fila.data("codgrupo64");
            $.ajax({
                url: base_url + "tesoreria/cronograma/deudas/sincronizar",
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodcalendario64 : vcodcalendario64,
                    txtcodgrupo64: vcodgrupo64
                },
                success: function(e) {
                    $('#divMdoalCronogramaDetalle #divoverlay').remove();
                    if (e.status == false) {
                        $.each(e.errors, function(key, val) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                        });
                    } else {
                        Swal.fire({
                            title: "Generado Correctamente",
                            // text: "",
                            icon: 'success',
                        })

                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divMdoalCronogramaDetalle #divoverlay').remove();
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        icon: 'error',
                    })
                }
            });
           
          
          }
        });    
    }

    function fn_GenerarVincularDeudasConPagosAutomaticamente_PorCronograma(boton){
        fila=boton.closest(".cfila");
        Swal.fire({
          title: "¿Deseas Generar las deudas del grupo seleccionado de este CRONOGRAMA?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Generar"
        }).then((result) => {
          if (result.isConfirmed) {
             $('#vw_dc_divCalpanel').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

            var vcodcalendario64 = fila.data("codcalendario64");
            $.ajax({
                url: base_url + "tesoreria/cronograma/deudas/sincronizar",
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodcalendario64 : vcodcalendario64,
                    txtcodgrupo64: '%'
                },
                success: function(e) {
                    $('#vw_dc_divCalpanel #divoverlay').remove();
                    if (e.status == false) {
                        $.each(e.errors, function(key, val) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                        });
                    } else {
                        Swal.fire({
                            title: "Generado Correctamente",
                            // text: "",
                            icon: 'success',
                        })

                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#vw_dc_divCalpanel #divoverlay').remove();
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        icon: 'error',
                    })
                }
            });
           
          
          }
        });    
    }

    function vw_abrir_modal_proyectarMatriculas(boton){
        $('#divModalProyectarMatriculas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var origen=boton.data("proyectarorigen");
        fila=boton.closest(".cfila");
        var codperiodo="";
        vw_mdpm_codGrupoCalendario64="";
        vw_mdpm_codGrupoCalendario64="%";
        if (origen=="cronograma"){
            
             $("#vw_cmd_codCalendario64").val(fila.data("codcalendario64"));

            var nombreCalendario = fila.data('nombrecal');
            alert(nombreCalendario);
            var periodo = fila.data('periodo');
            codperiodo = fila.data('codperiodo');
            var sede = fila.data('sede');

            $("#modProyectarMatriculas .modal-title").html(sede + " | "  + periodo + " | Cronograma: <span class='text-primary'>" + nombreCalendario+ "</span>");

            
        }
        else if (origen=="grupo"){
                
             vw_mdpm_codGrupoCalendario64=fila.data('codgrupo64');
            codperiodo=$("#vw_cmd_codPeriodo").val();
            $("#modProyectarMatriculas .modal-title").html($("#modCronogramaDetalle .modal-title").html());
        }

        $("#vw_mdpm_cbperiodo option").each(function(index,element) {
            if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
            if (($(this).data("estado") != "ACTIVO") || ($(this).val() ==codperiodo ) ){
                if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
            }
        });
       
        
        $("#vw_mdpm_cbperiodo").val(0);
       
        $("#vw_mdpm_codGrupoCalendario64").val(vw_mdpm_codGrupoCalendario64);
        $('#modProyectarMatriculas').modal("show");
        $('#divModalProyectarMatriculas #divoverlay').remove();


    }

    function fn_proyectarMatriculas_PorGrupo(boton){
        var vcodcalendario64=$("#vw_cmd_codCalendario64").val();
        var vw_mdpm_cbperiodo=$("#vw_mdpm_cbperiodo").val();
        var vcodgrupo64 = $("#vw_mdpm_codGrupoCalendario64").val();

        //fila=boton.closest(".cfila");
        Swal.fire({
          title: "¿Deseas proyectar las matrículas grupo seleccionado?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Generar"
        }).then((result) => {
          if (result.isConfirmed) {
            $('#divMdoalCronogramaDetalle').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            
            $.ajax({
                url: base_url + "matricula/fn_proyectarMatriculas_PorGrupo",
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodcalendario64 : vcodcalendario64,
                    txtcodgrupo64: vcodgrupo64,
                    cbcodperiodo:  vw_mdpm_cbperiodo
                },
                success: function(e) {
                    $('#divMdoalCronogramaDetalle #divoverlay').remove();
                    if (e.status == false) {
                        $.each(e.errors, function(key, val) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                        });
                        Swal.fire({
                            title: "Error",
                            text: e.msg,
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: "Proyectado Correctamente",
                            // text: "",
                            icon: 'success',
                        })

                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divMdoalCronogramaDetalle #divoverlay').remove();
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        icon: 'error',
                    })
                }
            });
           
          
          }
        });    
    }

    
    
</script>