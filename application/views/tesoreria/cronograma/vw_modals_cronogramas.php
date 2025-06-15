
<div class="modal fade" id="modDuplicaCalendarioParaFilial" tabindex="-1" role="dialog" aria-labelledby="modDuplicaCalendarioParaFilial" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="divcard_title">Duplicar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="divModalDuplicarCronogramaParaFilial">
                <input type="hidden" value="0" id="vw_mdcf_codCalendario64">
                <div class="form-group has-float-label col-12 col-md-12">
                      <select  class="form-control form-control-sm" id="vw_mdcf_cbFilial" name="vw_mdcf_cbFilial" placeholder="Filial">
                        <option selected value="0">--</option>
                        <?php 
                          foreach ($sedes as $filial) {

                            echo "<option value='$filial->id'>$filial->nombre</option>";
                          } 
                        ?>
                      </select>
                      <label for="vw_mdcf_cbFilial"> Filial</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" onclick='fn_guardarDuplicarCronogramaFilial($(this));return false' class="btn btn-primary">Duplicar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modMantCalendario" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cronograma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12" id="div_frmcalendario">
                    <!-- <div class="card-body"> -->
                        <form id="vw_dci_frmcalendario" accept-charset="utf-8">
                            <div class="row">
                                <input type="hidden" id="vw_dci_txtcodigo" name="vw_dci_txtcodigo" value="0">
                                <div class="form-group has-float-label col-12  col-md-6">
                                    <select name="vw_dci_cbperiodo" id="vw_dci_cbperiodo" class="form-control form-control-sm inputsb">
                                        <option value="0">Selecciona periodo</option>
                                        <?php foreach ($periodos as $periodo) {
                                        echo "<option  value='$periodo->codigo'>$periodo->nombre </option>";
                                        } ?>
                                    </select>
                                    <label for="vw_dci_cbperiodo">Periodo</label>
                                </div>
                                <div class="form-group has-float-label col-12  col-md-6">
                                    <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtnombre" name="vw_dci_txtnombre" type="text" placeholder="Nombre"  maxlength="8" />
                                    <label for="vw_dci_txtnombre">Nombre</label>
                                </div>
                                <div class="form-group has-float-label col-6  col-md-6">
                                    <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtinicia" name="vw_dci_txtinicia" type="date" placeholder="Inicia"/>
                                    <label for="vw_dci_txtinicia">Inicia</label>
                                </div>
                                <div class="form-group has-float-label col-6  col-md-6">
                                    <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtculmina" name="vw_dci_txtculmina" type="date" placeholder="Culmina"  />
                                    <label for="vw_dci_txtculmina">Culmina</label>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 text-bold text-primary">Evaluaciones</div>
                                        <div class="form-group has-float-label col-12  col-md-6">
                                            <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtCerrar1" name="vw_dci_txtCerrar1" type="date" placeholder="Cerrar U1"  minlength="8" />
                                            <label for="vw_dci_txtCerrar1">Cerrar U1</label>
                                        </div>
                                        <div class="form-group has-float-label col-12  col-md-6">
                                            <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtCerrar2" name="vw_dci_txtCerrar2" type="date" placeholder="Cerrar U2"  minlength="8" />
                                            <label for="vw_dci_txtCerrar2">Cerrar U2</label>
                                        </div>
                                        <div class="form-group has-float-label col-12  col-md-6">
                                            <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtCerrar3" name="vw_dci_txtCerrar3" type="date" placeholder="Cerrar U3"  minlength="8" />
                                            <label for="vw_dci_txtCerrar3">Cerrar U3</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 text-bold text-primary">Consolidar</div>
                                        <div class="form-group has-float-label col-6  col-md-6">
                                            <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtConsolidarRetiros" name="vw_dci_txtConsolidarRetiros" type="date" placeholder="Consolidar Retirados"  minlength="8" />
                                            <label for="vw_dci_txtConsolidarRetiros">Consolidar Retirados</label>
                                        </div>
                                        <div class="form-group has-float-label col-6  col-md-6">
                                            <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase inputsb" id="vw_dci_txtcerrarUD" name="vw_dci_txtcerrarUD" type="date" placeholder="Culminar UD automáticamente"  minlength="8" />
                                            <label for="vw_dci_txtcerrarUD">Culminar UD automáticamente</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <!-- </div> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="vw_dci_btnguardar" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modCronogramas" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >
                    <span id="md_crono_sede"></span> | <span id="md_crono_periodo"></span> | <span id="md_crono_nombre"></span> 
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="col-12">
                    <input type="hidden" id="md_crono_txt_codperiodo">
                    <input type="hidden" id="md_crono_txt_codsede">
                </div>
                
                <div class="card" id="div_cronogramas">
                    <br>
                    <br><br>
                    <br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modGrupos" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Grupos Académicos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card" id="div_Grupos">
                    <br>
                    <br><br>
                    <br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modGrupos_deudas" tabindex="-1" role="dialog" aria-labelledby="modGrupos_deudas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content modGrupos_deudas_content">
            <div class="modal-header">
                <h5 class="modal-title" >Grupos Académicos Asignar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 btable">
                    <div class="col-md-12 thead d-none d-md-block">
                        <div class="row">
                            <div class="col-sm-1 col-md-1 td hidden-xs">N°</div>
                            <div class="col-sm-2 col-md-2 td">PERIODO</div>
                            <div class="col-sm-2 col-md-4 td">CARRERA</div>
                            <div class="col-sm-2 col-md-2 td">CIC./SECCIÓN</div>
                            <div class="col-sm-2 col-md-2 td">TURNO</div>
                            <div class="col-sm-1 col-md-1 td text-center"></div>
                        </div>
                    </div>
                    <div class="col-md-12 tbody" id="div_GruposDeudas">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modDeudas" tabindex="-1" role="dialog" aria-labelledby="modDeudas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content" id="modDeudas_content">
            <div class="modal-header">
                <h5 class="modal-title" >Generar Deudas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 btable" >
                    <div class="col-md-12 thead d-none d-md-block">
                        <div class="row" id="vw_mdd_estudiantes_head">
                            
                            
                        </div>
                    </div>
                    <div class="col-md-12 tbody" id="vw_mdd_estudiantes">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="vw_mdd_btnguardar" class="btn btn-primary">Guardar</button>
                
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="modPlanEconomico" tabindex="-1" role="dialog" aria-labelledby="modPlanEconomico" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content" id="modPlanEconomico_content">
            <div class="modal-header">
                <h5 class="modal-title" >Plan Ecónomico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="vw_mdpe_codmat">
                    <div class="form-group has-float-label col-12">
                        <select name="vw_mdpe_cbbeneficio" id="vw_mdpe_cbbeneficio" class="form-control form-control-sm">
                            <option value="0">Seleccionar</option>
                            <?php foreach ($beneficios as $bene) {
                            //echo "<option data-sigla='$bene->sigla'  value='$bene->id'>$bene->nombre </option>";
                            } ?>
                        </select>
                        <label for="vw_mdpe_cbbeneficio">Beneficio</label>
                    </div>
                    <div class="form-group has-float-label col-12">
                        <input type="text" class="form-control form-control-sm" name="vw_mdpe_monto" id="vw_mdpe_monto">
                        <label for="vw_mdpe_monto">Monto</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="vw_mdpe_btnguardar" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div> -->

<script type="text/javascript">
    $('#modMantCalendario').on('shown.bs.modal', function (event) {
        $('#div_frmcalendario').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        boton = $(event.relatedTarget);
        fila=boton.closest(".cfila")
        accion=boton.data("accion");
        vcodigo="0";
        if (accion=="editar"){
            vcodigo=fila.data("codcalendario64");
            $("#vw_dci_txtcodigo").val(vcodigo);
            $("#vw_dci_cbperiodo").val(fila.data("codperiodo"));
            $("#vw_dci_txtnombre").val(fila.data("nombrecal"));
            $("#vw_dci_txtinicia").val(fila.data("inicia"));
            $("#vw_dci_txtculmina").val(fila.data("culmina"));
            $("#vw_dci_txtConsolidarRetiros").val(fila.data("cierreud"));
            $("#vw_dci_txtcerrarUD").val(fila.data("consolida"));
            $("#vw_dci_txtCerrar1").val(fila.data("cerrare1"));
            $("#vw_dci_txtCerrar2").val(fila.data("cerrare2"));
            $("#vw_dci_txtCerrar3").val(fila.data("cerrare3"));
        }
        else{
            $("#vw_dci_txtcodigo").val('0');
            $("#vw_dci_cbperiodo").val("0");
            $("#vw_dci_txtnombre").val("");
            $("#vw_dci_txtinicia").val("");
            $("#vw_dci_txtculmina").val("");
            $("#vw_dci_txtConsolidarRetiros").val("");
            $("#vw_dci_txtcerrarUD").val("");
            $("#vw_dci_txtCerrar1").val("");
            $("#vw_dci_txtCerrar2").val("");
            $("#vw_dci_txtCerrar3").val("");
        }
        $('#div_frmcalendario #divoverlay').remove();

    });
    $('#vw_dci_btnguardar').click(function(event) {
        $('#div_frmcalendario input,select').removeClass('is-invalid');
        $('#div_frmcalendario .invalid-feedback').remove();
        $('#div_frmcalendario').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + "tesoreria/cronogramas/cronograma/guardar",
            type: 'post',
            dataType: 'json',
            data: $('#vw_dci_frmcalendario').serialize(),
            success: function(e) {
                $('#div_frmcalendario #divoverlay').remove();
                if (e.status == false) {
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                } else {
                    $('#modMantCalendario').modal('hide');
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#div_frmcalendario #divoverlay').remove();
                Swal.fire({
                    title: msgf,
                    // text: "",
                    icon: 'error',
                })
            }
        });
        return false;
    });
</script>