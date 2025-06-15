    <div class="modal fade" id="modenviarmail" tabindex="-1" role="dialog" aria-labelledby="modenviarmail" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodalsendemail">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">Enviar a email personalizado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="form-group has-float-label col-12">
                            <input type="text" name="vw_dp_em_txtemail" id="vw_dp_em_txtemail" placeholder="Email" class="form-control form-control-sm">
                            <label for="vw_dp_em_txtemail">Email</label>
                        </div>
                        <div class="col-12 text-right" id="vw_dp_em_divoverlay" >
                            
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="vw_dp_em_btnenviar" data-codigo='' class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modanuladoc" tabindex="-1" role="dialog" aria-labelledby="modanuladoc" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalanulad">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">ESTÁ SEGURO DE ANULAR DOCUMENTO?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_anuladocpago" action="<?php echo $vbaseurl ?>facturacion_anulacion/fn_anula_docpago" method="post" accept-charset="utf-8">
                        <div class="row">
                            <input type="hidden" name="ficdocumentcodigo" id="ficdocumentcodigo" value="">
                            
                            <div class="form-group has-float-label col-12">
                                <textarea name="ficmotivanula" id="ficmotivanula" class="form-control form-control-sm" rows="3" placeholder="Motivo Anulación"></textarea>
                                <label for="ficmotivanula">Motivo Anulación</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_anula_doc" data-coloran="" class="btn btn-primary">Anular</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modasgmatricula" tabindex="-1" role="dialog" aria-labelledby="modasgmatricula" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" id="divmodaladdmat">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">MATRICULAR ESTUDIANTE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 tex-primary">
                            
                            <div class="col-12 p-0">
                                <h5 id="fgi-apellidos" class="d-block p-1 bg-lightgray border rounded"></h5>
                                <b class="d-block text-danger pt-3"><i class="fas fa-user-graduate mr-1"></i> HISTORIAL DE MATRÍCULAS</b>
                            </div>
                            <div class="col-12 btable">
                                <div class="col-md-12 thead d-none d-md-block">
                                    <div class="row">
                                        <div class="col-6 col-md-7">
                                            <div class="row">
                                                <div class="cperiodo col-2 col-md-2 td"> PER. </div>
                                                <div class="col-2 col-md-5 td text-center">PLAN</div>
                                                <div class="ccarrera col-2 col-md-5 td" >PROGRAMA.</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <div class="row">
                                                <div class="cciclo td col-2 col-md-4 text-center " >CC.</div>
                                                <div class="cturno td col-2 col-md-4 text-center ">TR.</div>
                                                <div class="cseccion td col-2 col-md-4 text-center ">SC.</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 td">
                                            EST.
                                        </div>
                                        <div class="col-6 col-md-1 td">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 tbody" id="vw_fcb_div_Hmatriculas">
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modupdatepagante" tabindex="-1" role="dialog" aria-labelledby="modupdatepagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodalupdatepag">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">Actualizar Pagante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_update_pagante" action="" method="post" accept-charset="utf-8">
                        <input type="hidden" name="vw_dp_txt_codocument" id="vw_dp_txt_codocument">
                        <div class="row">
                            <div class="form-group has-float-label col-4">
                                <input type="text" name="vw_dp_txt_codigpagante" id="vw_dp_txt_codigpagante" placeholder="Cod. Pagante" class="form-control form-control-sm">
                                <label for="vw_dp_txt_codigpagante">Cod. Pagante</label>
                            </div>
                            <div class="form-group has-float-label col-4">
                                <select name="vw_dp_txt_tipdocpagante" id="vw_dp_txt_tipdocpagante" class="form-control form-control-sm">
                                    
                                </select>
                                <label for="vw_dp_txt_tipdocpagante">Tipo doc.</label>
                            </div>
                            <div class="form-group has-float-label col-4">
                                <input type="text" name="vw_dp_txt_dnipagante" id="vw_dp_txt_dnipagante" placeholder="N° documento" class="form-control form-control-sm">
                                <label for="vw_dp_txt_dnipagante">N° documento</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="vw_dp_txt_dpagante" id="vw_dp_txt_dpagante" placeholder="Cliente" class="form-control form-control-sm">
                                <label for="vw_dp_txt_dpagante">Cliente</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="vw_dp_txt_direccion_pag" id="vw_dp_txt_direccion_pag" placeholder="Dirección" class="form-control form-control-sm">
                                <label for="vw_dp_txt_direccion_pag">Dirección</label>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="vw_dp_em_btnupdate_pag" data-codigo='' class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modupdatedocumento" tabindex="-1" role="dialog" aria-labelledby="modupdatedocumento" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content" id="divmodalupdatedocum">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">Actualizar Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_update_documento" action="" method="post" accept-charset="utf-8">
                        <input type="hidden" name="vw_dp_txt_codocument" id="vw_dp_txt_codocument">
                        <input name="vw_fcb_txtigvp_up" id="vw_fcb_txtigvp_up" type="hidden" value="">
                        <div class="row mt-2">
                            <div class="input-group input-group-sm col-md-3">
                                <input type="hidden" name="vw_fcb_tipo_up" id="vw_fcb_tipo_up" value="">
                                <input readonly="" type="text" class="form-control" placeholder="Serie" name="vw_fcb_serie_up" id="vw_fcb_serie_up" value="">
                                <input type="text" class="form-control" placeholder="N°" name="vw_fcb_sernumero_up" id="vw_fcb_sernumero_up" value="">
                            </div>
                            <div class="col-md-3"></div>
                            <div class="input-group input-group-sm col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Emisión: </span>
                                </div>
                                <input type="date" class="form-control " name="vw_fcb_emision_up" id="vw_fcb_emision_up" value="">
                                <input type="time" class="form-control " name="vw_fcb_emishora_up" id="vw_fcb_emishora_up" value="">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group has-float-label col-6 col-md-2">
                                <select name="vw_dp_txt_tipdocpagante_up" id="vw_dp_txt_tipdocpagante_up" class="form-control form-control-sm">
                                    
                                </select>
                                <label for="vw_dp_txt_tipdocpagante_up">Tipo doc.</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-3">
                                <input type="text" name="vw_dp_txt_dnipagante_up" id="vw_dp_txt_dnipagante_up" placeholder="N° documento" class="form-control form-control-sm">
                                <label for="vw_dp_txt_dnipagante_up">N° documento</label>
                            </div>
                            <div class="form-group has-float-label col-4 col-sm-2">
                                <input type="text" name="vw_dp_txt_codigpagante_up" id="vw_dp_txt_codigpagante_up" placeholder="Cod. Pagante" class="form-control form-control-sm">
                                <label for="vw_dp_txt_codigpagante_up">Cod. Pagante</label>
                            </div>
                            <div class="form-group has-float-label col-8 col-md-5">
                                <input type="text" name="vw_dp_txt_dpagante_up" id="vw_dp_txt_dpagante_up" placeholder="Cliente" class="form-control form-control-sm">
                                <label for="vw_dp_txt_dpagante_up">Cliente</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-8">
                                <input type="text" name="vw_dp_txt_direccion_pag_up" id="vw_dp_txt_direccion_pag_up" placeholder="Dirección" class="form-control form-control-sm">
                                <label for="vw_dp_txt_direccion_pag_up">Dirección</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-4">
                                <select name="vw_fcb_ai_txtcodmatricula" id="vw_fcb_ai_txtcodmatricula" class="form-control control form-control-sm text-sm text-danger">
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card border border-secondary ">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h4>Detalle</h4>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0" id="divcard_detail_doc">
                                        <div class="row text-bold">
                                            <span class="text-sm col-1">Und.</span>
                                            <span class="text-sm col-1">Cód.</span>
                                            <span class="text-sm col-4">Concepto</span>
                                            <span class="text-sm col-1">Cant.</span>
                                            <span class="text-sm col-1">P.U</span>
                                            <span class="text-sm col-1">Monto</span>
                                            <span class="text-sm col-1">Cod.Deud</span>
                                            <span class="text-sm col-1">Cod.Mat</span>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row mb-2">
                                            <label for="vw_fcb_txtobservaciones">Mas Información</label>
                                            <textarea name="vw_fcb_txtobservaciones" id="vw_fcb_txtobservaciones" class="form-control " rows="2"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-6">
                                                <div class="form-check d-none">
                                                    <input class="form-check-input " type="checkbox" value="" id="vw_fcb_chk_dsct_global">
                                                    <label class="form-check-label" for="vw_fcb_chk_dsct_global">
                                                        Descuento Global
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="text-sm col-4"><span class="float-right">Operación Gravada</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_gravada" id="vw_fcb_txtoper_gravada" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-2 ">
                                                <input type="text" name="vw_fcb_txt_dsct_general" id="vw_fcb_txt_dsct_general" class="form-control  form-control-sm text-sm div_dctoglobal" value="0.00">
                                            </div>
                                            <div class="form-group has-float-label col-12 col-md-2 ">
                                                <select name="vw_fcb_cbdsctglobalfactor" id="vw_fcb_cbdsctglobalfactor" class="form-control  control form-control-sm text-sm div_dctoglobal">
                                                    <option  value='1'>Soles</option>
                                                    <option  value='100'>%</option>
                                                    
                                                </select>
                                                <input type="hidden" name="vw_fcb_cbdsctglobalmontobase_final" id="vw_fcb_cbdsctglobalmontobase_final" placeholder="mb" >
                                                <input type="hidden" name="vw_fcb_cbdsctglobalfactor_final" id="vw_fcb_cbdsctglobalfactor_final" placeholder="factor" >
                                            </div>
                                            <div class="text-sm col-6"><span class="float-right">Operación Inafecta</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_inafecta" id="vw_fcb_txtoper_inafecta" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Operación Exonerada</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_exonerada" id="vw_fcb_txtoper_exonerada" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Operación Exportación</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_exportacion" id="vw_fcb_txtoper_exportacion" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Descuentos Totales</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_desctotal" id="vw_fcb_txtoper_desctotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Total de Op. Gratuitas</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtoper_gratuitas" id="vw_fcb_txtoper_gratuitas" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">Subtotal</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtsubtotal" id="vw_fcb_txtsubtotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">ICBPER</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txticbpertotal" id="vw_fcb_txticbpertotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">ISC Total</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtisctotal" id="vw_fcb_txtisctotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">IGV Total</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txtigvtotal" id="vw_fcb_txtigvtotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="text-sm col-10"><span class="float-right">TOTAL</span></div>
                                            <div class="text-sm col-2">
                                                <input type="text" name="vw_fcb_txttotal" id="vw_fcb_txttotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" id="vw_dp_em_btnupdate_docum" data-codigo='' class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modDeudas_asignar" tabindex="-1" role="dialog" aria-labelledby="modDeudas_asignar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modDeudas_asignar_content">
                <div class="modal-header">
                    <h5 class="modal-title" >Deudas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="col-12">
                                <div class="col-12 border rounded p-1">
                                    <h5 id="vw_md_pagos_estudiante"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mt-2">
                            <div class="col-12">
                                <div class="col-12 border rounded p-1">
                                    <h5 id="vw_md_detalle_documento"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 mt-2">
                            <div class="col-12">
                                <div class="col-12 border rounded p-1">
                                    <h5 id="vw_md_detalle_gestion"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" value="0" id="vw_mdp_txtcoddeuda">
                    <div class="row mt-2">
                        <div class="col-12 col-md-12">
                            <!-- <div class="col-12">
                                <div class="col-12 border rounded p-1" >
                                    <h4 class="text-center">Deudas</h4>
                                </div>
                            </div> -->
                            <div class="col-12" id="tabdivres-pagos">
                                <table id="tbmt_dtDeudas" class="tbdatatable table table-sm table-hover table-bordered table-condensed display nowrap" style="width:100%">
                                    <thead>
                                        <tr class="bg-lightgray">
                                            <th>N°</th>
                                            <th>COD.</th>
                                            <th>CONCEPTO</th>
                                            <th>MONTO</th>
                                            <th>SALDO</th>
                                            <th>VENCE</th>
                                            <th>GRUPO</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
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