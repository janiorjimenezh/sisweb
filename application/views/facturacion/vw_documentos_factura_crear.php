<?php
$vbaseurl=base_url();
date_default_timezone_set ('America/Lima');
$fecha = date('Y-m-d');
$hora = date('H:i');
$config_anterioridad = $configsede->conf_dias_anter;
?>
<style type="text/css">



</style>
<div class="content-wrapper">
   
    <?php echo $vw_modal_matricular; ?>
    <div class="modal fade" id="modaddmatricula" tabindex="-1" role="dialog" aria-labelledby="modaddmatricula" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                        <div class="col-12 col-md-6 tex-primay">
                            
                            <div class="col-12">
                                <h4 id="fgi-apellidos" class=""></h4>
                                <b class="d-block text-danger pt-3"><i class="fas fa-user-graduate mr-1"></i> HISTORIAL DE MATRÍCULAS</b>
                            </div>
                            <div class="col-12 btable">
                                <div class="col-md-12 thead d-none d-md-block">
                                    <div class="row">
                                        <div class="col-6 col-md-4">
                                            <div class="row">
                                                <div class="cperiodo col-2 col-md-4 td"> PER. </div>
                                                <div class="col-2 col-md-5 td text-center">PLAN</div>
                                                <div class="ccarrera col-2 col-md-3 td" >PRG.</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <div class="row">
                                                <div class="cciclo td col-2 col-md-4 text-center " >CC.</div>
                                                <div class="cturno td col-2 col-md-4 text-center ">TR.</div>
                                                <div class="cseccion td col-2 col-md-4 text-center ">SC.</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="row">
                                                <div class="cciclo td col-2 col-md-3 text-center " >+</div>
                                                <div class="cciclo td col-2 col-md-3 text-center " >-</div>
                                                <div class="cturno td col-2 col-md-3 text-center ">DPI</div>
                                                <div class="cseccion td col-2 col-md-3 text-center ">NSP</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 td">
                                            EST.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 tbody" id="vw_fcb_div_Hmatriculas">
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-2">
                                <a class="float-right btn btn-sm btn-primary" data-carne="" id="btn_newmatricula" href="#"> + Nueva</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="col-12" id="vw_dp_divmatricular">
                                <form id="frm-matricular" action="<?php echo $vbaseurl ?>matricula/fn_insert_update_matricula" method="post" accept-charset='utf-8'>
                                    <b class="d-block text-danger"><i class="fas fa-user-graduate mr-1"></i> PROCESO DE MATRÍCULA</b>
                                    <input data-currentvalue='' id="fm-txtidmatriculaup" name="fm-txtidmatriculaup" value="0" type="hidden" />
                                    <input data-currentvalue='' id="fm-txtidup" name="fm-txtidup" type="hidden" />
                                    <input data-currentvalue='' id="fm-txtcarreraup" name="fm-txtcarreraup" type="hidden" />
                                    <input id="fm-txtplanup" name="fm-txtplanup" type="hidden" />
                                    <input data-currentvalue="" id="fm-txtperiodoup" name="fm-txtperiodoup" type="hidden">
                                    <input id="fm-txtmapepatup" name="fm-txtmapepatup" type="hidden" />
                                    <input id="fm-txtmapematup" name="fm-txtmapematup" type="hidden" />
                                    <input id="fm-txtmnombresup" name="fm-txtmnombresup" type="hidden" />
                                    <input id="fm-txtmsexoup" name="fm-txtmsexoup" type="hidden" />
                                    <input type="hidden" name="fm-txtcodpago" id="fm-txtcodpago" value="">
                                    
                                    <div class="row mt-3">
                                        <div class="form-group col-12 col-sm-12">
                                            <span id="fm-carreraup" class="d-block p-2 bg-light border rounded">PROGRAMA ACADÉMICO</span>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbtipoup" name="fm-cbtipoup" placeholder="Condición" required >
                                                <option value="O">Ordinaria</option>
                                                <option value="E">Extemporánea</option>
                                            </select>
                                            <label for="fm-cbtipoup"> Matrícula</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-md-3">
                                            <select data-currentvalue='' class="form-control" id="fm-cbperiodoup" name="fm-cbperiodoup" placeholder="Periodo" required >
                                                <option value="0"></option>
                                                <?php foreach ($periodos as $periodo) {?>
                                                <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbperiodoup"> Periodo</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-xs-4 col-md-5">
                                            <select data-currentvalue='' class="form-control" id="fm-cbplanup" name="fm-cbplanup" placeholder="Plan de Estudio" required>
                                                
                                            </select>
                                            <label for="fm-cbplanup"> Plan de Estudio</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-xs-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbcicloup" name="fm-cbcicloup" placeholder="Ciclo" required >
                                                <option value="0"></option>
                                                <?php foreach ($ciclos as $ciclo) {?>
                                                <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbcicloup"> Ciclo</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-xs-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbturnoup" name="fm-cbturnoup" placeholder="Turno" required >
                                                <option value="0"></option>
                                                <?php foreach ($turnos as $turno) {?>
                                                <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbturnoup"> Turno</label>
                                        </div>
                                        <div class="form-group has-float-label col-12 col-xs-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbseccionup" name="fm-cbseccionup" placeholder="Sección" required >
                                                <option value="0"></option>
                                                <?php foreach ($secciones as $seccion) {?>
                                                <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbseccionup"> Sección</label>
                                        </div>
                                       
                                        <div class="form-group has-float-label col-12 col-md-6">
                                            <select data-currentvalue='' class="form-control" id="fm-cbbeneficioup" name="fm-cbbeneficioup" placeholder="Periodo" required >
                                                <?php foreach ($beneficios as $beneficio) {?>
                                                <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbbeneficioup"> Beneficio</label>
                                        </div>

                                        <div class="form-group has-float-label col-12 col-md-4">
                                            <select data-currentvalue='' class="form-control" id="fm-cbestadoup" name="fm-cbestadoup" placeholder="Periodo" required >
                                                <option value="0"></option>
                                                <?php foreach ($estados as $est) {?>
                                                <option <?php echo ($est->codigo=="1") ? "selected" : ""  ?> value="<?php echo $est->codigo ?>"><?php echo $est->nombre ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="fm-cbestadoup"> Estado</label>
                                        </div>

                                        <div class="form-group has-float-label col-6 col-md-4">
                                            <input data-currentvalue='' class="form-control text-uppercase" value="<?php echo $fecha; ?>" id="fm-txtfecmatriculaup" name="fm-txtfecmatriculaup" type="date" placeholder="Fec. Matrícula"   />
                                            <label for="fm-txtfecmatriculaup">Fec. Matrícula</label>
                                        </div>
                                        <div class="form-group has-float-label col-6 col-md-6">
                                            <input data-currentvalue='' class="form-control" type="number" step="0.01"  value='0.00' id="fm-txtcuotaup" name="fm-txtcuotaup" placeholder="Cuota"   />
                                            <label for="fm-txtcuotaup">Cuota</label>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        
                                        <div class="form-group has-float-label col-12 col-xs-12 col-sm-12">
                                            <textarea class="form-control text-uppercase" id="fm-txtobservacionesup" name="fm-txtobservacionesup" placeholder="Observaciones"  rows="3"></textarea>
                                            <label for="fm-txtobservacionesup"> Observaciones</label>
                                        </div>
                                        
                                    </div>
                                </form>
                                <button type="button" id="lbtn_guardarmat" class="btn btn-primary">Guardar</button>
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
    <!-- MODAL COBROS -->
    <?php include 'vw_documentos_pago_cobrar.php'; ?>
    <!-- MODAL AGREGAR PAGANTE -->
    <div class="modal fade" id="modaddpagante" tabindex="-1" role="dialog" aria-labelledby="modaddpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_title">NUEVO CLIENTE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addpagante" action="<?php echo $vbaseurl ?>pagante/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-6 col-sm-4">
                                <select class="form-control form-control-sm" id="ficbtipodoc" name="ficbtipodoc" placeholder="Tipo Doc." >
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                    <option value="CEX">Carné de Extranjería</option>
                                    <option value="PSP">Pasaporte</option>
                                    <option value="PTP">Permiso Temporal de Permanencia</option>
                                </select>
                                <label for="ficbtipodoc"> Tipo Doc.</label>
                            </div>
                            <div class="form-group has-float-label col-6  col-sm-4">
                                <input autocomplete='off' data-currentvalue='' class="form-control form-control-sm text-uppercase" id="fitxtdni" name="fitxtdni" type="text" placeholder="N° documento"  minlength="8" />
                                <label for="fitxtdni"> N° documento</label>
                            </div>
                            <div class="col-12  col-sm-3">
                                <button id="fibtnsearch-dni" type="button" class="btn btn-primary btn-block btn-sm">
                                <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="0">
                                <input type="hidden" id="fictxtcodpagante" name="fictxtcodpagante">
                                <select name="fictipopag" id="fictipopag" class="form-control form-control-sm">
                                    <option value="CLIENTE">CLIENTE</option>
                                    <option value="ESTUDIANTE">ESTUDIANTE</option>
                                    <option value="LIBRE">LIBRE</option>
                                </select>
                                <label for="fictipopag">Tipo Pagante</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <select name="fictipopers" id="fictipopers" class="form-control form-control-sm">
                                    <option value="NATURAL">NATURAL</option>
                                    <option value="JURIDICA">JURIDICA</option>
                                </select>
                                <label for="fictipopers">Tipo Persona</label>
                            </div>
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="fictxtnomrazon" id="fictxtnomrazon" placeholder="Nombres/Razon Social" class="form-control form-control-sm">
                                <label for="fictxtnomrazon">Nombres/Razon Social</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailper" id="fictxtemailper" placeholder="Correo Electrónico" class="form-control form-control-sm">
                                <label for="fictxtemailper">Correo Electrónico</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailper2" id="fictxtemailper2" placeholder="Otro Correo Electrónico" class="form-control form-control-sm">
                                <label for="fictxtemailper2">Otro Correo Electrónico</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtemailcorporat" id="fictxtemailcorporat" placeholder="Correo Corporativo" class="form-control form-control-sm">
                                <label for="fictxtemailcorporat">Correo Corporativo</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtdireccion" id="fictxtdireccion" placeholder="Dirección" class="form-control form-control-sm">
                                <label for="fictxtdireccion">Dirección</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select onchange='fn_combo_ubigeo($(this));' data-currentvalue='' class="form-control form-control-sm" id="ficbdepartamento" name="ficbdepartamento" placeholder="Departamento" required data-tubigeo='departamento' data-cbprovincia='ficbprovincia' data-cbdistrito='ficbdistrito' data-dvcarga='divcard_data'>
                                    <option value="0">Selecciona Departamento</option>
                                    <?php foreach ($departamentos as $key => $depa) {?>
                                    <option value="<?php echo $depa->codigo ?>"><?php echo $depa->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="ficbdepartamento"> Departamento</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select onchange='fn_combo_ubigeo($(this));' data-currentvalue='0' class="form-control form-control-sm" id="ficbprovincia" name="ficbprovincia" placeholder="Provincia" required data-tubigeo='provincia' data-cbdistrito='ficbdistrito' data-dvcarga='divcard_data'>
                                    <option value="0">Sin opciones</option>
                                </select>
                                <label for="ficbprovincia"> Provincia</label>
                            </div>
                            <div class="form-group has-float-label col-12  col-sm-4">
                                <select data-currentvalue='0'  class="form-control form-control-sm" id="ficbdistrito" name="ficbdistrito" placeholder="Distrito" required >
                                    <option value="0">Sin opciones</option>
                                </select>
                                <label for="ficbdistrito"> Distrito</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtelefono" id="fictxtelefono" placeholder="Teléfono" class="form-control form-control-sm">
                                <label for="fictxtelefono">Teléfono</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-md-6">
                                <input type="text" name="fictxtcelular" id="fictxtcelular" placeholder="Celular" class="form-control form-control-sm">
                                <label for="fictxtcelular">Celular</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL AGREGAR PAGANTE -->
    <!-- BUSCAR MODAL PAGANTE -->
    <div class="modal fade" id="modsearchpagante" tabindex="-1" role="dialog" aria-labelledby="modsearchpagante" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog  modal-xl" role="document">
            <div class="modal-content" id="vwmdbp_divBuscarPagante">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_titles">Buscar Pagantes </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_searchpag" action="" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-11">
                                <input autocomplete="off" type="text" name="fictxtnompagante" id="fictxtnompagante" placeholder="Cliente" class="form-control form-control-sm">
                                <label for="fictxtnompagante">Cliente</label>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-sm btn-info" type="submit" >
                                <i class="fas fa-search"></i>
                                </button>
                                
                            </div>
                        </div>
                        
                    </form>
                    
                    <div class="col-12 py-1 btable"  id="divcard_ltspagante">
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL BUSCAR PAGANTE -->
    <!-- AGREGAR MODAL ITEM -->
    <div class="modal fade" id="modadditem" tabindex="-1" role="dialog" aria-labelledby="modadditem" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="divmodalitem">
                <div class="modal-header">
                    <h5 class="modal-title" id="divcard_tititem">Agregar detalle</h5>
                    <button type="button"class="close"  data-toggle="collapse" href="#vw_fcb_ai_divconfiguraciones" role="button" aria-expanded="false" aria-controls="vw_fcb_ai_divconfiguraciones">
                    <span aria-hidden="true"><i class="fas fa-cog"></i></span>
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="vw_fcb_ai_divbody">
                    
                    <input type="hidden" name="vw_fcb_ai_codmatricula" id="vw_fcb_ai_codmatricula" value="">
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-5">
                            <select name="vw_fcb_ai_cbgestion" id="vw_fcb_ai_cbgestion" class="form-control control form-control-sm text-sm inputsb">
                                <option  value='0'>Seleccionar</option>
                                <?php
                                foreach ($gestion as $key => $gs) {
                                echo "<option data-unidad='$gs->codunidad' data-afectacion='$gs->codtipafecta' data-afecta='$gs->afecta' value='$gs->codigo' >$gs->gestion</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbgestion">Gestións</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-3">
                            <select name="vw_fcb_ai_cbunidad" id="vw_fcb_ai_cbunidad" class="form-control control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($unidad as $key => $und) {
                                echo "<option  value='$und->codigo' >$und->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbunidad">Unidad</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input autocomplete="off" type="text" name="vw_fcb_ai_txtcantidad" id="vw_fcb_ai_txtcantidad" placeholder="Cantidad" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtcantidad">Cantidad</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input autocomplete="off" type="text" name="vw_fcb_ai_txtpreciounitario" id="vw_fcb_ai_txtpreciounitario" placeholder="Monto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtpreciounitario">Monto</label>
                        </div>
                        <!--AFECTACIÓN-->
                    </div>
                    <div class="row pt-2">
                        <div class="form-group has-float-label col-12 col-md-4">
                            <select name="vw_fcb_ai_cbafectacion" id="vw_fcb_ai_cbafectacion" class="form-control control form-control-sm text-sm inputsb">
                                
                                <?php
                                foreach ($afectacion as $key => $af) {
                                echo "<option data-esgratis='$af->esgratis'  value='$af->codigo' >$af->info $af->codigo  $af->nombre</option>";
                                }
                                ?>
                            </select>
                            <label for="vw_fcb_ai_cbafectacion">Tipo de Afectación</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-2">
                            <input readonly autocomplete="off" type="text" name="vw_fcb_ai_txtcoddeuda" id="vw_fcb_ai_txtcoddeuda" placeholder="Monto" class="form-control form-control-sm inputsb">
                            <label for="vw_fcb_ai_txtcoddeuda">Cod. Deuda</label>
                        </div>
                        
                    </div>
                    <div class="collapse" id="vw_fcb_ai_divconfiguraciones">
                        <div class="card card-body">
                            <div class="row pt-2">
                                <div class="form-group has-float-label col-12 col-md-5">
                                    <select name="vw_fcb_ai_cbtipoitem" id="vw_fcb_ai_cbtipoitem" class="form-control control form-control-sm text-sm inputsb">
                                        <option  value='SERVICIO'>Servicio</option>
                                        <option  value='BIEN'>Bien</option>
                                    </select>
                                    <label for="vw_fcb_ai_cbtipoitem">Tipo</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-md-3">
                                    <select name="vw_fcb_ai_cbafectaigv" id="vw_fcb_ai_cbafectaigv" class="form-control control form-control-sm text-sm inputsb">
                                        <option  value='GRAVADO'>GRAVADO</option>
                                        <option  value='EXONERADO'>EXONERADO</option>
                                        <option  value='INAFECTO'>INAFECTO</option>
                                    </select>
                                    <label for="vw_fcb_ai_cbafectaigv">Afectación</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-md-3">
                                    <select name="vw_fcb_ai_cbgratis" id="vw_fcb_ai_cbgratis" class="form-control control form-control-sm text-sm inputsb">
                                        <option  value='NO'>NO</option>
                                        <option  value='SI'>SI</option>
                                        
                                        
                                    </select>
                                    <label for="vw_fcb_ai_cbgratis">Operación Gratuita</label>
                                </div>
                                
                            </div>
                            <hr>
                            <!--ISC-->
                            <div class="row pt-2">
                                <div class="form-group has-float-label col-12 col-md-3">
                                    <select name="vw_fcb_ai_cbisc" id="vw_fcb_ai_cbisc" class="form-control control form-control-sm text-sm inputsb">
                                        <option  value=''>Seleccionar</option>
                                        <?php
                                        foreach ($iscs as $key => $isc) {
                                        echo "<option  value='$isc->codigo' >$isc->nombre</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="vw_fcb_ai_cbisc">ISC</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-md-2">
                                    <input type="text" name="vw_fcb_ai_txtiscvalor" id="vw_fcb_ai_txtiscvalor" placeholder="Impuesto" class="form-control form-control-sm inputsb">
                                    <label for="vw_fcb_ai_txtiscvalor">Impuesto</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-md-3">
                                    <select name="vw_fcb_ai_cbiscfactor" id="vw_fcb_ai_cbiscfactor" class="form-control control form-control-sm text-sm inputsb">
                                        <option  value='1'>Soles</option>
                                        <option  value='100'>%</option>
                                        
                                    </select>
                                </div>
                                <div id="vw_fcb_ai_diviscbase" class="form-group has-float-label col-12 col-md-2">
                                    <input type="text" name="vw_fcb_ai_txtiscbase" id="vw_fcb_ai_txtiscbase" placeholder="Base Imponible" class="form-control form-control-sm inputsb">
                                    <label for="vw_fcb_ai_txtiscbase">Base Imponible</label>
                                </div>
                            </div>
                            
                            <!--DESCUENTO-->
                            <div class="row pt-2 d-none">
                                <div class="form-group has-float-label col-12 col-md-2">
                                    <input type="text" name="vw_fcb_ai_txtdsctvalor" id="vw_fcb_ai_txtdsctvalor" placeholder="Impuesto" class="form-control form-control-sm inputsb">
                                    <label for="vw_fcb_ai_txtdsctvalor">Descuento</label>
                                </div>
                                <div class="form-group has-float-label col-12 col-md-3">
                                    <select name="vw_fcb_ai_cbdsctfactor" id="vw_fcb_ai_cbdsctfactor" class="form-control control form-control-sm text-sm inputsb">
                                        <option  value='1'>Soles</option>
                                        <option  value='100'>%</option>
                                        
                                    </select>
                                </div>
                                
                            </div>
                            
                            
                        </div>
                    </div>
                    <hr>
                    
                    <div class="row pt-2">
                        
                        <div class="form-group has-float-label col-12">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button id="vw_fcb_ai_btnagregar" type="button" class="btn btn-primary float-right">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODAL AGREGAR ITEM -->
    <!-- BUSCAR MODAL ITEM -->
    <!-- FIN MODAL BUSCAR ITEM -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <span class="text-primary h4">CREAR <?php echo $tipol; ?></span>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago?sb=facturacion">Documentos</a>
                        </li>
                        <li class="breadcrumb-item active">Crear</li>
                        <!-- <li class="breadcrumb-item active"><a  href="#"  data-accion='INSERTAR' data-toggle='modal' data-target='#modupmat'>matricular</a></li> -->
                        
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section id="s-cargado" class="content">
        <div id="vw_pw_bt_ad_div_principal" class="card">
            <div class="card-body">
                
                <form id="vw_fcb_frmboleta" action="" method="post" accept-charset="utf-8">
                    <div class="row">
                        
                        <div class="input-group input-group-sm col-md-3">
                            <input type="hidden" name="vw_fcb_tipo" id="vw_fcb_tipo" value="<?php echo trim($docserie->tipo) ?>">
                            <input readonly type="text" class="form-control " placeholder="Serie" name="vw_fcb_serie" id="vw_fcb_serie" value="<?php echo $docserie->serie ?>">
                            <input readonly type="text" class="form-control " placeholder="N°" name="vw_fcb_sernumero" id="vw_fcb_sernumero" value="<?php echo $docserie->contador ?>">
                            <input type="text" class="form-control " placeholder="N°" name="vw_fcb_sernumero_real" id="vw_fcb_sernumero_real" value="0">
                            <div class="input-group-append">
                                <button id="vw_fcb_btnedit_numero" data-accion="auto" class="btn btn-outline-secondary" type="button"><i class="fas fa-pencil-alt"></i></button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            
                        </div>
                        <div class="input-group input-group-sm col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Emisión: </span>
                            </div>
                            <input type="date" class="form-control " name="vw_fcb_emision" id="vw_fcb_emision" value="<?php echo $fecha ?>">
                            <input type="time" class="form-control " name="vw_fcb_emishora" id="vw_fcb_emishora" value="<?php echo $hora ?>">
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="input-group input-group-sm  mb-3 col-12 col-md-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Operación: </span>
                            </div>
                            <select name="vw_fcb_cbtipo_operacion51" id="vw_fcb_cbtipo_operacion51" class="form-control custom-select inputsb text-sm">
                                <?php
                                foreach ($tipoopera51 as $key => $tpop51) {
                                $opera51sel=($docserie->codoperacion51==$tpop51->codopera51)?"selected":"";
                                echo "<option $opera51sel value='$tpop51->codopera51' >$tpop51->nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group input-group-sm  mb-3 col-12 col-md-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">IGV %: </span>
                            </div>
                            <input autocomplete="off"  name="vw_fcb_txtigvp" id="vw_fcb_txtigvp" type="text" class="form-control text-sm inputsb" placeholder="IGV %" value="<?php echo $docserie->igvpr ?>">
                        </div>


                        <div class="input-group input-group-sm  mb-3 col-12 col-md-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Condición: </span>
                            </div>
                            <select name="vw_fcb_cbcondicion" id="vw_fcb_cbcondicion" class="form-control custom-select inputsb text-sm">
                                <option value="CONTADO">CONTADO</option>
                                <option value="CRÉDITO">CRÉDITO</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Vence: </span>
                                </div>
                                <input type="date" class="form-control " name="vw_fcb_vencimiento" id="vw_fcb_vencimiento">
                            </div>
                        </div>
                    </div>
                    
                    <hr class="m-0">
                    <div class="row mt-3">
                        
                        <div class="form-group has-float-label col-12 col-md-2">
                            <select name="vw_fcb_cbtipodoc" id="vw_fcb_cbtipodoc" class="form-control  control form-control-sm text-sm inputsb">
                                <?php
                                foreach ($tipoidentidad as $key => $tpid) {
                                echo "<option value='$tpid->codigo' data-lgt='$tpid->longitud'>$tpid->nombre</option>";
                                }
                                ?>
                                
                            </select>
                            <label for="vw_fcb_cbtipodoc">Tipo doc.</label>
                        </div>
                        
                        <div class="form-group has-float-label col-12 col-md-3">
                            <input autocomplete="off"  name="vw_fcb_txtnrodoc" id="vw_fcb_txtnrodoc" type="text" class="form-control  form-control-sm text-sm inputsb" placeholder="N° Documento">
                            <label for="vw_fcb_txtnrodoc">N° Documento</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row">
                                    <input readonly autocomplete="off" type="text" name="vw_fcb_codpagante" id="vw_fcb_codpagante" class="col-3 form-control form-control-sm text-sm inputsb">
                                    <input readonly autocomplete="off" name="vw_fcb_txtpagante" id="vw_fcb_txtpagante" type="text" class="col-9 form-control form-control-sm text-sm inputsb" placeholder="Cliente">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="btn-group dropleft float-right">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-tie"></i> Cliente
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modaddpagante">
                                        <i class="fas fa-plus mr-1"></i> Agregar
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modsearchpagante">
                                        <i class="fas fa-search mr-1"></i> Buscar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-12">
                            <input readonly name="vw_fcb_txtdireccion" id="vw_fcb_txtdireccion" type="text" class="form-control  form-control-sm text-sm inputsb" placeholder="Dirección">
                            <label for="vw_fcb_txtdireccion">Dirección</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4 d-none">
                            <select name="vw_fcb_cbmatricula" id="vw_fcb_cbmatricula" class="form-control  control form-control-sm text-sm border border-primary text-danger">
                                      <option value='0'>Sin Asignar</option>                         
                            </select>
                            <label for="vw_fcb_cbmatricula">Matrícula</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail1" id="vw_fcb_txtemail1" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 1">
                            <label for="vw_fcb_txtemail1">Correo 1</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail2" id="vw_fcb_txtemail2" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 2">
                            <label for="vw_fcb_txtemail2">Correo 2</label>
                        </div>
                        <div class="form-group has-float-label col-12 col-md-4">
                            <input name="vw_fcb_txtemail3" id="vw_fcb_txtemail3" type="text" class="form-control form-control-sm text-sm inputsb" placeholder="Correo 3">
                            <label for="vw_fcb_txtemail3">Correo 3</label>
                        </div>
                    </div>
                    <div class="row mt-2" id="divcard_detalle_deuda">
                        <div class="col-12">
                            <div class="card card-danger border border-danger">
                                <div class="card-header text-bold  py-1 pl-2">
                                    <h5 class="p-0 m-0">Deudas del Cliente</h5>
                                </div>
                                <div class="card-body p-0" id="">
                                    <div class="col-12 btable">
                                        <div class="col-md-12 thead d-none d-md-block bg-lightgray">
                                            <div class="row text-bold">
                                                <div class='col-8 col-md-4 td'>
                                                    Concepto
                                                </div>
                                                <div class='col-4 col-md-1 td'>
                                                    Monto
                                                </div>
                                                <div class='col-4 col-md-1 td'>
                                                    Mora
                                                </div>
                                                <div class='col-6 col-md-2 td'>
                                                    Vence
                                                </div>
                                                <div class='col-6 col-md-1 td'>
                                                    Saldo
                                                </div>
                                                <div class='col-6 col-md-2 td'>
                                                    Periodo / Ciclo
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 tbody" id="divdata_detalle_deuda">
                                            
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="row mt-3" id="divcard_detalle">
                        <div class="col-12">
                            <div class="card ">
                                <div class="card-header py-1">
                                    <div class="card-title ">
                                        <span class=" text-bold h5">Items</span>
                                    </div>
                                    <div class="p-0 card-tools">
                                        
                                        <a href="#" class="badge badge-primary p-2" data-toggle="modal" data-target="#modadditem">
                                            <i class="fas fa-plus mr-1"></i>  item
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body pt-0" id="divdata_detalle">
                                    <div class="row text-bold">
                                        <span class="text-sm col-1">Und.</span>
                                        <span class="text-sm col-1">Cód.</span>
                                        <span class="text-sm col-3">Concepto</span>
                                        <span class="text-sm col-1">Cant.</span>
                                        <span class="text-sm col-1">P.U</span>
                                        <span class="text-sm col-1">Monto</span>
                                        <span class="text-sm col-1">Cod.Deud</span>
                                        <span class="text-sm col-1">Per./Sem.</span>
                                    </div>
                                    
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="row mb-2">
                                        <label for="vw_fcb_txtobservaciones">Observaciones</label>
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
                                        
                                    </div>
                                    <div class="row">
                                        <div class="form-group has-float-label col-6  col-sm-2">
                                            <input autocomplete='off' data-currentvalue='' class="vw_fcb_frmcontrols form-control form-control-sm text-uppercase" id="vw_fcb_txtoper_gravada" name="vw_fcb_txtoper_gravada" type="text" placeholder="0.00"  readonly="" value="0.00"/>
                                            <label for="vw_fcb_txtoper_gravada">Oper. Gravada</label>
                                        </div>
                                        <div class="form-group has-float-label col-6  col-sm-2">
                                            <input autocomplete='off' data-currentvalue='' class="vw_fcb_frmcontrols form-control form-control-sm text-uppercase" id="vw_fcb_txtoper_inafecta" name="vw_fcb_txtoper_inafecta" type="text" placeholder="0.00"  readonly="" value="0.00"/>
                                            <label for="vw_fcb_txtoper_inafecta">Oper. Inafecta</label>
                                        </div>
                                        <div class="form-group has-float-label col-6  col-sm-2">
                                            <input autocomplete='off' data-currentvalue='' class="vw_fcb_frmcontrols form-control form-control-sm text-uppercase" id="vw_fcb_txtoper_exonerada" name="vw_fcb_txtoper_exonerada" type="text" placeholder="0.00"  readonly="" value="0.00"/>
                                            <label for="vw_fcb_txtoper_exonerada">Oper. Exonerada</label>
                                        </div>
                                        <div class="form-group has-float-label col-6  col-sm-2">
                                            <input autocomplete='off' data-currentvalue='' class="vw_fcb_frmcontrols form-control form-control-sm text-uppercase" id="vw_fcb_txtoper_exportacion" name="vw_fcb_txtoper_exportacion" type="text" placeholder="0.00"  readonly="" value="0.00"/>
                                            <label for="vw_fcb_txtoper_exportacion">Oper. Exportación</label>
                                        </div>

                                        <div class="form-group has-float-label col-6  col-sm-2">
                                            <input autocomplete='off' data-currentvalue='' class="vw_fcb_frmcontrols form-control form-control-sm text-uppercase" id="vw_fcb_txtoper_desctotal" name="vw_fcb_txtoper_desctotal" type="text" placeholder="0.00"  readonly="" value="0.00"/>
                                            <label for="vw_fcb_txtoper_desctotal">Total Desc.</label>
                                        </div>
                                        <div class="form-group has-float-label col-6  col-sm-2">
                                            <input autocomplete='off' data-currentvalue='' class="vw_fcb_frmcontrols form-control form-control-sm text-uppercase" id="vw_fcb_txtoper_gratuitas" name="vw_fcb_txtoper_gratuitas" type="text" placeholder="0.00"  readonly="" value="0.00"/>
                                            <label for="fitxtdni">Oper. Gratuitas</label>
                                        </div>

                            


                                        
                                    </div>
           
        
                                   
                                    <hr>
                                    <div class="row">

                                         <div class="col-sm-6 border border-primary rounded">
                                            <div class="row" id="vw_fcb_cred_div_cuotas">
                                                <div class="col-12 text-center border bg-lightgray text-bold">CUOTAS AL CRÉDITO</div>
                                                <div class="col-2 text-center border bg-lightgray">Cuota</div>
                                                <div class="col-6 text-center border bg-lightgray">Vence</div>
                                                <div class="col-4 text-center border bg-lightgray">Monto</div>
                                            
                                                <div class="col-2 border">
                                                    <input type="text" class="form-control form-control-sm text-center" name="vw_fcb_cred_ncuota1" id="vw_fcb_cred_ncuota1" value="1">
                                                </div>
                                                <div class="col-6 border">
                                                    <input type="date" class="form-control form-control-sm" name="vw_fcb_cred_fecha1" id="vw_fcb_cred_fecha1">
                                                </div>
                                                <div class="col-4 border">
                                                    <input type="number" class="form-control form-control-sm" name="vw_fcb_cred_vence1" id="vw_fcb_cred_vence1">
                                                </div>
                                            
                                                <div class="col-2 border">
                                                    <input type="text" class="form-control form-control-sm text-center" name="vw_fcb_cred_ncuota2" id="vw_fcb_cred_ncuota2" value="2">
                                                </div>
                                                <div class="col-6 border">
                                                    <input type="date" class="form-control form-control-sm" name="vw_fcb_cred_fecha2" id="vw_fcb_cred_fecha2">
                                                </div>
                                                <div class="col-4 border">
                                                    <input type="number" class="form-control form-control-sm" name="vw_fcb_cred_vence2" id="vw_fcb_cred_vence2">
                                                </div>
                                           
                                                <div class="col-2 border">
                                                    <input type="text" class="form-control form-control-sm text-center" name="vw_fcb_cred_ncuota3" id="vw_fcb_cred_ncuota3" value="3">
                                                </div>
                                                <div class="col-6 border">
                                                    <input type="date" class="form-control form-control-sm" name="vw_fcb_cred_fecha3" id="vw_fcb_cred_fecha3">
                                                </div>
                                                <div class="col-4 border">
                                                    <input type="number" class="form-control form-control-sm" name="vw_fcb_cred_vence3" id="vw_fcb_cred_vence3">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <div class="row" >
                                                <div class="text-sm col-8"><span class="float-right">Subtotal</span></div>
                                                <div class="text-sm col-4">
                                                    <input type="text" name="vw_fcb_txtsubtotal" id="vw_fcb_txtsubtotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                                </div>
                                            
                                                <div class="text-sm col-8"><span class="float-right">ICBPER</span></div>
                                                <div class="text-sm col-4">
                                                    <input type="text" name="vw_fcb_txticbpertotal" id="vw_fcb_txticbpertotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                                </div>
                                            
                                                <div class="text-sm col-8"><span class="float-right">ISC Total</span></div>
                                                <div class="text-sm col-4">
                                                    <input type="text" name="vw_fcb_txtisctotal" id="vw_fcb_txtisctotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                                </div>
                                            
                                                <div class="text-sm col-8"><span class="float-right">IGV Total</span></div>
                                                <div class="text-sm col-4">
                                                    <input type="text" name="vw_fcb_txtigvtotal" id="vw_fcb_txtigvtotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                                </div>
                                            
                                                <div class="text-sm col-8"><span class="float-right">TOTAL</span></div>
                                                <div class="text-sm col-4">
                                                    <input type="text" name="vw_fcb_txttotal" id="vw_fcb_txttotal" class="form-control vw_fcb_frmcontrols form-control-sm text-sm" readonly="" value="0.00">
                                                </div>
                                            </div>  
                                        </div>  
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 py-2">
                            <div id="vw_pw_bt_ad_divmsgbolsa" class="text-danger">
                            </div>
                        </div>
                        <div class="col-12">
                            <a type="button" href="<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago" class="btn btn-danger btn-md float-left" >
                                <i class="fas fa-undo"></i> Cancelar
                            </a>
                            <a role='button' type="button" href="#" id="vw_pw_bt_ad_btn_guardar" class="btn btn-primary btn-md float-right">
                                <i class="fas fa-save"></i> Guardar
                            </a>
                        </div>
                    </div>
                </form>
                <div class="card col-12 text-center" id="divcard_resultfin">
                    <div class="card-body text-center">
                        <br>
                        <span>Se ha generado un nuevo documento identifcado con:</span><br><br>
                        <h2 id="vw_fcb_fin_numero">F001-00000003</h2><br>
                        <div class="row justify-content-center mt-2">

                            <div class="col-11 col-md-4 cfila" data-codigo64=''  data-docsn='' data-coddoc='' data-pagante='' data-subtotal='' data-igv=''>
                                <a id="btn_addmodcobros" class="btn btn-success btn-lg d-block" href="#" data-toggle='modal' data-target='#modaddcobros' data-codigo='' data-pgmonto='' data-iddocp="" data-montodocp="">
                                    <i class="far fa-credit-card mr-1"></i> Agregar Cobros
                                </a>
                            </div>

                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                <a id="vw_fcb_fin_ticket" target="_blank" class="btn btn-primary btn-lg  d-block" href="#">
                                    <i class="fas fa-print mr-1"></i> Impresión
                                </a>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                <a id="vw_fcb_fin_pdf" target="_blank" class="btn btn-info btn-lg d-block" href="#">
                                    <i class="far fa-file-pdf mr-1"></i> Representación Digital (PDF)
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                <a class='btn btn-info btn-lg d-block d-primary' href='<?php echo $vbaseurl ?>tesoreria/facturacion/crear-documento?tp=boleta'>Nueva Boleta</a>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                
                                <a class='btn btn-info btn-lg d-block d-primary' href='<?php echo $vbaseurl ?>tesoreria/facturacion/crear-documento?tp=boleta'>Nueva Factura</a>
                            </div>
                            
                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-11 col-md-4">
                                <a class='btn btn-info btn-lg d-block d-primary' href='<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago'>Ir a documentos de Pago</a>
                            </div>
                        </div>
                    </div>
                    <br>
                    
                    
                    <br>
                    
                    <br><br>
                </div>
                
            </div>
        </div>
    </div>
</section>
</div>
<div id="vw_fcb_rowitem" class="row rowcolor vw_fcb_class_rowitem" data-arraypos="-1">
<div class="col-12 col-md-1 p-0">
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
<div class="col-12 col-md-3 p-0">
    <input autocomplete="off" type="text"  onchange="fn_update_concepto($(this));return false" name="vw_fcb_ai_txtgestion" placeholder="Gestion" class="form-control form-control-sm text-sm">
</div>
<div class="col-12 col-md-1 p-0">
    <input autocomplete="off" onkeyup="fn_update_precios($(this));return false" onchange="fn_update_precios($(this));return false" type="number" name="vw_fcb_ai_txtcantidad"  placeholder="Cantidad" class="form-control form-control-sm text-sm text-right">
</div>
<div class="col-12 col-md-1 p-0">
    <input autocomplete="off" onkeyup="fn_update_precios($(this));return false" onchange="fn_update_precios($(this));return false" type="number" name="vw_fcb_ai_txtpreciounitario"  placeholder="pu" class="form-control form-control-sm text-sm text-right">
</div>
<div class="col-12 col-md-1 p-0">
    <input readonly type="text" name="vw_fcb_ai_txtprecioventa"  placeholder="pv" class="form-control form-control-sm text-sm text-right">
</div>
<div class="col-12 col-md-1 p-0">
    <input readonly type="text"  name="vw_fcb_ai_txtcoddeuda" class="form-control form-control-sm text-sm">
</div>
<div class="col-12 col-md-2 p-0">
    <select onchange="fn_update_cod_matricula_deta($(this));return false;" name="vw_fcb_ai_txtcodmatricula_det" class="form-control control form-control-sm text-sm text-success form_select_mat vw_fcb_ai_cbcodmatricula" data-prb="hola">

    </select>
</div>

<div class="col-12 col-md-1 p-0">
    <a class="btn btn-danger btn-sm" onclick="fn_removeitem($(this));return false" href="#"><i class="fas fa-minus-circle"></i></a>
</div>

<div class="row">
    <input readonly type="hidden" name="vw_fcb_ai_txtvalorunitario"  >
    <div class="col-12 col-md-3">
        <input  type="hidden" name="vw_fcb_ai_cbisc"  >
    </div>
    <div class="col-12 col-md-2">
        <input  type="hidden" name="vw_fcb_ai_txtiscvalor"  placeholder="Impuesto" >
    </div>
    <div class="col-12 col-md-2">
        <input  type="hidden" name="vw_fcb_ai_txtcodperiodo_det"  placeholder="Cod. Periodo" >
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
    <div class="col-12 col-md-4">
        <input  type="hidden"  name="vw_fcb_ai_cbgratis">
    </div>
    
</div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>resources/dist/js/pages/pagante_21_07_16.js"></script>
<script type="text/javascript">
var cd1 = '<?php echo base64url_encode("1"); ?>';
var itemsDocumento = {};
var itemsNro = 0;
var vconfiguracion = <?php echo $config_anterioridad ?>;
var arrayPeriodos=<?php echo json_encode($periodos); ?>;

$(document).ready(function() {
    $('#vw_fcb_ai_diviscbase').hide();
    $('#vw_dp_divmatricular').hide();
    $('#vw_fcb_cred_div_cuotas').hide();
    
    $(".div_dctoglobal").hide();
    // $("#divcard_resultfin").show();
    $("#divcard_resultfin").hide();
    $("#vw_fcb_rowitem").hide();
    $("#divcard_detalle_deuda").hide();
    $("#vw_fcb_sernumero_real").hide();

    if ($("#vw_fcb_tipo").val() == "BL") {
        $("#vw_fcb_btnedit_numero").show();
    } else {
        $("#vw_fcb_btnedit_numero").hide();
    }

    $("#vw_fcb_txtnrodoc").focus();
    pigv = <?php echo $docserie->igvpr ?>;
    pigv = Number(pigv) / 100;
});
$("#vw_fcb_cbcondicion").change(function(event) {
    if($(this).val()=="CRÉDITO"){
        $("#vw_fcb_cred_div_cuotas").show("fast");
    }
    else{
        $("#vw_fcb_cred_div_cuotas").hide("fast");
    }
});
//vw_fcb_chk_dsct_global
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

    $.each(itemsDocumento, function(ind, elem) {
        var pu = Number(elem['vw_fcb_ai_txtpreciounitario']);
        var valorventa = Number(elem['vw_fcb_ai_txtcantidad']) * pu;
        if (elem['vw_fcb_ai_cbafectacion'] == "10") {
            //GRAVADO
            //elem['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
            valorventa_sinigv = Number(elem['vw_fcb_ai_txtvalorunitario']) * Number(elem['vw_fcb_ai_txtcantidad']);
            //elem['vw_fcb_ai_txtprecioventa'] = valorventa;
            ops_grav = ops_grav + valorventa_sinigv;
            js_total = js_total + valorventa;
        } else if (elem['vw_fcb_ai_cbafectacion'] == "30") {
            //INAFECTO
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] = valorventa;
            ops_inaf = ops_inaf + valorventa;
            js_total = js_total + valorventa;
        } else if (elem['vw_fcb_ai_cbafectacion'] == "20") {
            //EXONERADO
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] =valorventa;
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
            //elem['vw_fcb_ai_txtvalorunitario'] = pu;
            //elem['vw_fcb_ai_txtprecioventa'] =valorventa;
            ops_grat = ops_grat + valorventa;
            //js_total=js_total + valorventa;
        }
    });
    //OPERACION GRAVADA, INAFECTA Y EXONERADA
    //DESCUENTO GLOBAL
    /*if ($("#vw_fcb_chk_dsct_global").is(':checked')) {
    $(".div_dctoglobal").show();
    var jvdctofactor = $("#vw_fcb_cbdsctglobalfactor").val();
    var jvdctovalor = $("#vw_fcb_txt_dsct_general").val();
    jvdctofactor = Number(jvdctofactor);
    jvdctovalor = Number(jvdctovalor);
    //alert(jvdctofactor);
    if (jvdctofactor == "1") {
    dsctos_globales = jvdctovalor;
    //$("#vw_fcb_cbdsctglobalmontobase_final").val(jvdctovalor);
    } else {
    //comprobar si la afectacion es a la base imponible
    //para este caso asumire que es no afecto a la base imponible
    jvdctofactor = Number(jvdctovalor) / 100;
    dsctos_globales = Math.round((ops_grav * jvdctofactor) * 100) / 100;
    //$("#vw_fcb_cbdsctglobalmontobase_final").val(ops_grav);
    }
    dsctos_globales_igv=dsctos_globales *
    $("#vw_fcb_cbdsctglobalfactor_final").val(jvdctofactor);
    $("#vw_fcb_txtoper_desctotal").val(dsctos_globales + dsctos_detalles);
    //js_subtotal=ops_grav + ops_exon + ops_inaf - dsctos_globales;
    js_total=js_total - (dsctos_globales)

    } else {
    $(".div_dctoglobal").hide();
    dsctos_globales = 0;
    }*/
    //SUBTOTAL
    js_subtotal = ops_grav + ops_exon + ops_inaf - (dsctos_globales + dsctos_detalles);
    //IGV
    js_igv = Math.round((js_total - js_subtotal - js_isc - js_icbper) * 100) / 100;
    //js_igv = Math.round(((ops_grav - dsctos_globales - dsctos_detalles) * pigv * 100)) / 100
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
$("#vw_fcb_chk_dsct_global,#vw_fcb_cbdsctglobalfactor").change(function(event) {
    mostrar_montos();
});
/*$("#vw_fcb_ai_btnagregar").click(function(event) {
event.preventDefault();
$('#vw_fcb_ai_divbody .modal-body input,select').removeClass('is-invalid');
$('#vw_fcb_ai_divbody .modal-body .invalid-feedback').remove();


if ($('#vw_fcb_ai_cbgestion').val()=="0"){
$('#vw_fcb_ai_cbgestion').addClass('is-invalid');
$('#vw_fcb_ai_cbgestion').parent().append("<div class='invalid-feedback'>Selecciona un Item</div>");
return false;
}
//var txtcnt=Number($("#vw_fcb_ai_txtcantidad").val())
if (!$.isNumeric($("#vw_fcb_ai_txtcantidad").val())){
$("#vw_fcb_ai_txtcantidad").addClass('is-invalid');
$("#vw_fcb_ai_txtcantidad").parent().append("<div class='invalid-feedback'>Corregir</div>");
return false;
}
//var txtpu=Number($("#vw_fcb_ai_txtpreciounitario").val())
if (!$.isNumeric( $("#vw_fcb_ai_txtpreciounitario").val() )){
$("#vw_fcb_ai_txtpreciounitario").addClass('is-invalid');
$("#vw_fcb_ai_txtpreciounitario").parent().append("<div class='invalid-feedback'>Corregir</div>");
return false;
}
//TERMINA LA VALIDACIÓN
var itemd = {};
$("#vw_fcb_ai_divbody input,select").each(function() {
itemd[$(this).attr('id')] = $(this).val();
});

//llenar gestion
itemd['vw_fcb_ai_txtgestion'] = $("#vw_fcb_ai_cbgestion option:selected").text();
//console.log(itemd)
var pu = Number(itemd['vw_fcb_ai_txtpreciounitario']);
var valorventa=Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
if afectacion == "10") {
//GRAVADO
itemd['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
valorventa_sinigv=Number(itemd['vw_fcb_ai_txtvalorunitario']) * Number(itemd['vw_fcb_ai_txtcantidad']);
itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
ops_grav = ops_grav + valorventa_sinigv;
js_total=js_total + valorventa;
} else if (itemd['vw_fcb_ai_cbafectacion'] == "30") {
//INAFECTO
itemd['vw_fcb_ai_txtvalorunitario'] = pu;
itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
ops_inaf = ops_inaf + valorventa;
js_total=js_total + valorventa;
} else if (itemd['vw_fcb_ai_cbafectacion'] == "20") {
//EXONERADO
itemd['vw_fcb_ai_txtvalorunitario'] = pu;
itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
ops_exon = ops_exon +  valorventa;
js_total=js_total + valorventa;
} else if (itemd['vw_fcb_ai_cbafectacion'] == "40") {
//EXONERADO
itemd['vw_fcb_ai_txtvalorunitario'] = pu;
itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
ops_inaf = ops_inaf +  valorventa;
js_total=js_total + valorventa;
} else {
//GRATUITA
itemd['vw_fcb_ai_txtvalorunitario'] = pu;
itemd['vw_fcb_ai_txtprecioventa'] =valorventa;
ops_grat = ops_grat +  valorventa;
//js_total=js_total + valorventa;
}



var row = $("#vw_fcb_rowitem").clone();
row.attr('id', 'vw_fcb_rowitem' + itemsNro);
row.data('arraypos', itemsNro);
itemsDocumento[itemsNro]=itemd;
console.log(itemsDocumento);
itemsNro++;
row.find('input,select').each(function(index, el) {
$(this).val(itemd[$(this).attr('name')]);
});
row.show();
$('#divdata_detalle').append(row);
$("#modadditem").modal("hide");
mostrar_montos();
$('#vw_fcb_ai_cbgestion').val("0");
$('#vw_fcb_ai_txtcantidad').val("1");
$('#vw_fcb_ai_txtpreciounitario').val("");
});*/
$("#vw_fcb_ai_btnagregar").click(function(event) {
    event.preventDefault();
    $('#vw_fcb_ai_divbody .modal-body input,select').removeClass('is-invalid');
    $('#vw_fcb_ai_divbody .modal-body .invalid-feedback').remove();


    if ($('#vw_fcb_ai_cbgestion').val() == "0") {
        $('#vw_fcb_ai_cbgestion').addClass('is-invalid');
        $('#vw_fcb_ai_cbgestion').parent().append("<div class='invalid-feedback'>Selecciona un Item</div>");
        return false;
    }
    //var txtcnt=Number($("#vw_fcb_ai_txtcantidad").val())
    if (!$.isNumeric($("#vw_fcb_ai_txtcantidad").val())) {
        $("#vw_fcb_ai_txtcantidad").addClass('is-invalid');
        $("#vw_fcb_ai_txtcantidad").parent().append("<div class='invalid-feedback'>Corregir</div>");
        return false;
    }
    //var txtpu=Number($("#vw_fcb_ai_txtpreciounitario").val())
    if (!$.isNumeric($("#vw_fcb_ai_txtpreciounitario").val())) {
        $("#vw_fcb_ai_txtpreciounitario").addClass('is-invalid');
        $("#vw_fcb_ai_txtpreciounitario").parent().append("<div class='invalid-feedback'>Corregir</div>");
        return false;
    }
    //TERMINA LA VALIDACIÓN
    var itemd = {};
    $("#vw_fcb_ai_divbody input,select").each(function() {
        itemd[$(this).attr('id')] = $(this).val();
    });

    //llenar gestion
    itemd['vw_fcb_ai_txtgestion'] = $("#vw_fcb_ai_cbgestion option:selected").text();
    // llenar matricula
    itemd['vw_fcb_ai_txtcodmatricula_det'] = $("#vw_fcb_ai_codmatricula").val();
    var codPeriodoDetalle=$("#vw_fcb_ai_codmatricula").find(':selected').data('codperiodo');
    itemd['vw_fcb_ai_txtcodperiodo_det'] ='' + codPeriodoDetalle;
    //console.log(itemd)
    /*itemsDocumento.each(function(index, el) {
    });*/
    var pu = Number(itemd['vw_fcb_ai_txtpreciounitario']);
    var valorventa = Number(itemd['vw_fcb_ai_txtcantidad']) * pu;
    itemd['vw_fcb_ai_cbgratis']="NO";
    if (itemd['vw_fcb_ai_cbafectacion'] == "10") {
        //GRAVADO
        itemd['vw_fcb_ai_txtvalorunitario'] = Math.round((pu / (pigv + 1)) * 100) / 100;
        //valorventa_sinigv=Number(itemd['vw_fcb_ai_txtvalorunitario']) * Number(itemd['vw_fcb_ai_txtcantidad']);
        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
        //ops_grav = ops_grav + valorventa_sinigv;
        //js_total=js_total + valorventa;
    } else if (itemd['vw_fcb_ai_cbafectacion'] == "30") {
        //INAFECTO
        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
        //ops_inaf = ops_inaf + valorventa;
        //js_total=js_total + valorventa;
    } else if (itemd['vw_fcb_ai_cbafectacion'] == "20") {
        //EXONERADO
        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
        //ops_exon = ops_exon +  valorventa;
        //js_total=js_total + valorventa;
    } else if (itemd['vw_fcb_ai_cbafectacion'] == "40") {
        //EXONERADO
        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
        //ops_inaf = ops_inaf +  valorventa;
        //js_total=js_total + valorventa;
    } else {
        //GRATUITA
        itemd['vw_fcb_ai_txtvalorunitario'] = pu;
        itemd['vw_fcb_ai_txtprecioventa'] = valorventa;
        
        itemd['vw_fcb_ai_cbgratis']="SI";
        //ops_grat = ops_grat +  valorventa;
        //js_total=js_total + valorventa;
    }



    var row = $("#vw_fcb_rowitem").clone();
    row.attr('id', 'vw_fcb_rowitem' + itemsNro);
    row.data('arraypos', itemsNro);
    itemsDocumento[itemsNro] = itemd;
    itemsNro++;
    row.find('input,select').each(function(index, el) {
        $(this).val(itemd[$(this).attr('name')]);
    });
    row.show();

    $('#divdata_detalle').append(row);

    mostrar_montos();
    $('#vw_fcb_ai_cbgestion').val("0");
    $('#vw_fcb_ai_txtcantidad').val("1");
    $('#vw_fcb_ai_txtpreciounitario').val("");
    $("#modadditem").modal("hide");
});
$("#vw_fcb_txt_dsct_general").blur(function(event) {
    mostrar_montos();
});
$('#vw_fcb_ai_cbgestion').change(function(event) {
    if ($('#vw_fcb_ai_cbgestion').val() == "0") {
        return false;
    }
    var jvunidad = $(this).find(':selected').data('unidad');
    var jvafectacion = $(this).find(':selected').data('afectacion');
    var jvafecta = $(this).find(':selected').data('afecta');
    if (jvunidad != "") $('#vw_fcb_ai_cbunidad').val(jvunidad);
    if (jvafecta != "") $('#vw_fcb_ai_cbafectaigv').val(jvafecta);

    if (jvafectacion != "") $('#vw_fcb_ai_cbafectacion').val(jvafectacion);
    $('#vw_fcb_ai_txtcantidad').val("1");
    $('#vw_fcb_ai_txtpreciounitario').val("");
    $('#vw_fcb_ai_txtcantidad').focus();
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
$('#frm_searchpag').submit(function() {
    $('#frm_searchpag input,select').removeClass('is-invalid');
    $('#frm_searchpag .invalid-feedback').remove();
    
    $('#vwmdbp_divBuscarPagante').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'pagante/get_pagantes',
        type: 'post',
        dataType: 'json',
        data: $('#frm_searchpag').serialize(),
        success: function(e) {
            $("#divcard_ltspagante").html("");
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                
            } else {
                $("#divcard_ltspagante").html(e.vdata);
            }
            $('#vwmdbp_divBuscarPagante #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vwmdbp_divBuscarPagante #divoverlay').remove();
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
$("#modsearchpagante").on('hidden.bs.modal', function() {
    $('#frm_searchpag')[0].reset();
    $('#divcard_ltspagante').html('');
});
$("#modsearchpagante").on('shown.bs.modal', function() {

    $('#fictxtnompagante').focus();
});
$("#modadditem").on('hidden.bs.modal', function() {
    $('#vw_fcb_ai_cbgestion').val("0");
    $('#vw_fcb_ai_txtcantidad').val("1");
    $('#vw_fcb_ai_txtpreciounitario').val("");
    $('#vw_fcb_ai_txtcoddeuda').val("");
    $('#vw_fcb_ai_codmatricula').val("");
});
/*$(document).on("keyup", ".unidad", function() {
var btn = $(this).parents('.cfila');
if ($(this).val() == "") {
btn.data('unidad', $(this).val(''));
} else {
btn.data('unidad', $(this).val());
}
})
$(document).on("keyup", ".valor", function() {
var btn = $(this).parents('.cfila');
if ($(this).val() == "") {
btn.data('valor', $(this).val(''));
} else {
btn.data('valor', $(this).val());
}
})*/
var cnt = 0;
$("#vw_pw_bt_ad_btn_guardar").click(function(event) {
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    event.preventDefault();
    modmatricula = false;
    $('#divdata_detalle input[name="vw_fcb_ai_cbgestion"]').each(function() {
        campo = $(this).val();
        if ((campo == "01.01") || (campo == "01.02") || (campo == "01.03")) {
            modmatricula = true;
        }
    })
    var nrovaciomat = 0;
    $('#divdata_detalle select[name="vw_fcb_ai_txtcodmatricula_det"]').each(function() {
        selcodmatricula = $(this).val();
        //console.log("codmat",selcodmatricula);
        if ((selcodmatricula == "")) {
            nrovaciomat++;
            $(this).addClass('is-invalid');
            $(this).parent().append("<div class='invalid-feedback'>Seleccionar matrícula</div>");
        }
    })
    if (nrovaciomat > 0) {
        Swal.fire(
            'Matricula!',
            "Debes seleccionar a que matrícula pertenece en los item del detalle",
            'warning'
        );
        return false;
    }
    if ($('#vw_fcb_txtnrodoc').val() == "") {
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
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    
    $('.vw_fcb_frmcontrols').attr('readonly', false);
    $('.vw_fcb_class_rowitem input,select').attr('readonly', false);
    //$('#vw_fcb_frmboleta select').attr('readonly', false);
    var formData = new FormData($("#vw_fcb_frmboleta")[0]);
    formData.append('vw_fcb_items', JSON.stringify(itemsDocumento));
    var carne=$('#vw_fcb_codpagante').val();
    var jsPagante=$('#vw_fcb_txtpagante').val();

    $.ajax({
        url: base_url + 'facturacion/fn_guardar_docpago',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                
                Swal.fire(
                    'Exito!',
                    'Los datos fueron guardados correctamente.',
                    'success'
                );
                $('#vw_fcb_frmboleta').hide();
                $('#divcard_resultfin').show();
                $('#vw_fcb_fin_numero').html(e.numero);
                $('#vw_fcb_fin_ticket').attr('href', e.tickect);
                $('#vw_fcb_fin_pdf').attr('href', e.pdf);

                $('#btn_addmodcobros').data('iddocp', e.coddocpago);
                $('#btn_addmodcobros').data('montodocp', e.montodocpago);
                


                //Simulo ser una fila de resultados
                var fila=$('#btn_addmodcobros').closest('.cfila');
                fila.data('docsn', e.numero);
                fila.data('codigo64', e.coddocpago64);
                fila.data('coddoc', e.coddocpago);
                fila.data('pagante', jsPagante );
                fila.data('total', e.montodocpago);
                fila.data('subtotal', e.montodocpago);
                fila.data('igv', 0);
                fila.data('serie', e.serie);
                fila.data('numero', e.numero);
                fila.data('codpagante', e.codpagante);
                $('#btn_addmodcobros').data('codigo', e.coddocpago);
                $('#btn_addmodcobros').data('pgmonto', e.montodocpago);

                


                if (e.vpermiso221 == "SI") {
                    if (e.matriculando == "SI") {
                        if (carne !=="") {
                            
                            $("#modupmat").modal();
                            fn_select_inscrito({carnet: carne, iddocpago: e.coddocpago},"pagos");
                            setTimeout(function() {
                                $('#divalert_mat').hide();
                                $('#modfiltroins').modal('hide');
                            },2000);
                            
                        }
                    }
                }

                /*if (modmatricula == true) {
                    //$('#fm-txtidmatricula').val(e.codmat);
                    //if (e.matestado == "AGREGAR") {
                    //datos_carne($('#vw_fcb_codpagante').val(), e.coddocpago);

                    //}
                    //else if (e.matestado == "EDITAR") {
                    //datos_matricula(e.codmat,e.coddocpago);
                    // $('#modaddmatricula').modal('show');
                    //}

                     if (carne !=="") {
                      $("#modupmat").modal();
                      $('#modfiltroins').modal('hide');
                      fn_select_inscrito({carnet: carne, iddocpago: e.coddocpago},"pagos");
                    }

                    $('#divcard_deudas_historial').hide();

                    $('#lbtn_reportedeudas').hide();
                    $('#lbtn_reportepagos').hide();

                }*/



            } else {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                /*$('#vw_fcb_codpagante').attr('readonly', true);
                $('#vw_fcb_txtpagante').attr('readonly', true);
                $('#vw_fcb_txtpagante').attr('readonly', true);*/
                $('.vw_fcb_frmcontrols').attr('readonly', true);
                $('.vw_fcb_class_rowitem input,select').attr('readonly', true);

                /*$("#vw_fcb_txtoper_gravada").attr('readonly', true);
                $("#vw_fcb_txtoper_inafecta").attr('readonly', true);
                $("#vw_fcb_txtoper_exonerada").attr('readonly', true);
                $("#vw_fcb_txtoper_exportacion").attr('readonly', true);
                $("#vw_fcb_txtoper_desctotal").attr('readonly', true);
                $("#vw_fcb_txtoper_gratuitas").attr('readonly', true);
                $("#vw_fcb_txtsubtotal").attr('readonly', true);
                $("#vw_fcb_txticbpertotal").attr('readonly', true);
                $("#vw_fcb_txtisctotal").attr('readonly', true);
                $("#vw_fcb_txtigvtotal").attr('readonly', true);
                $("#vw_fcb_txttotal").attr('readonly', true);*/
                Swal.fire(
                    'Error!',
                    e.msg,
                    'error'
                )
            }
        },
        error: function(jqXHR, exception) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
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

function datos_carne(carne, codpago) {
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "matricula/fn_get_inscripcion_y_matriculas_x_carne",
        type: 'post',
        dataType: 'json',
        data: {
            'fgi-txtcarne': carne,
        },
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'warning',
                    title: 'ADVERTENCIA',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                $('#modaddmatricula').modal('show');
                $('#fm-txtid').val(e.vdata['idinscripcion64']);
                $('#fm-txtcodpago').val(codpago);
                $("#frm-matricular")[0].reset();
                if (e.existe_inscrito == false) {
                    $('#fgi-apellidos').html('NO ENCONTRADO');

                    $('#fm-txtcarrera').val("");
                    $('#fm-carrera').val("PROGRAMA ACADÉMICO");
                    $('#fm-cbplan').html("<option value='0'>Plán curricular NO DISPONIBLE</option>");
                    //$("#frm-matricular").hide();
                } else {
                    //$('#fitxtdni').val(e.vdata['dni']);
                    $('#fgi-apellidos').html(carne + "<br>" + e.vdata['paterno'] + ' ' + e.vdata['materno'] + ' ' + e.vdata['nombres']);
                    $('#fm-txtcarrera').val(e.vdata['codcarrera']);
                    $('#fm-carrera').html(e.vdata['carrera']);
                    $('#btn_newmatricula').data('carne', e.vdata['carnet']);
                    var planes = "";
                    $.each(e.vplanes, function(key, val) {
                        planes = planes + "<option value='" + val['codigo'] + "'>" + val['nombre'] + "</option>";

                    });
                    $('#fm-cbplan').html(planes);
                    $('#fm-cbplan').val(e.vdata['codplan']);
                    $('#fm-txtplan').val(e.vdata['codplan']);
                    $('#fm-txtmapepat').val(e.vdata['paterno']);
                    $('#fm-txtmapemat').val(e.vdata['materno']);
                    $('#fm-txtmnombres').val(e.vdata['nombres']);
                    $('#fm-txtmsexo').val(e.vdata['sexo']);
                    var nro = 0;
                    $("#vw_fcb_div_Hmatriculas").html("");
                    $.each(e.vmatriculas, function(index, v) {

                        nro++;
                        var btnscolor = "";
                        switch (v['estado']) {
                            case "ACT":
                                btnscolor = "btn-success";
                                break;
                            case "CUL":
                                btnscolor = "btn-secondary";
                                break;
                            case "RET":
                                btnscolor = "btn-danger";
                                break;
                            default:
                                btnscolor = "btn-warning";
                        }
                        var js_estado = v['estado'];
                        var js_update = "";
                        if ((v['codestado'] == "6") || (v['codestado'] == "5")) {
                            js_estado = '<div class="btn-group btn-group-sm p-0 ">' +
                                '<button class="btn ' + btnscolor + ' btn-sm dropdown-toggle py-0 rounded border-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                v['estado'] +
                                '</button>' +
                                '<div class="dropdown-menu">' +
                                '<a href="#" class="btn-cestado dropdown-item" data-ie="' + cd1 + '">Activo</a>' +
                                '</div>' +
                                '</div>'
                        }

                        if ((v['codestado'] == "6") || (v['codestado'] == "5") || (v['codestado'] == "1")) {
                            js_update = '<a onclick="fn_matricula_update($(this))" href="#">' +
                                '<i class="far fa-edit ml-2"></i>' +
                                '</a> ';
                        }
                        $("#vw_fcb_div_Hmatriculas").append(
                            '<div data-idm="' + v['codmatricula64'] + '" class="row cfila rowcolor ">' +
                            '<div class="col-12 col-md-4">' +
                            '<div class="row">' +
                            '<div data-cp="' + v['codperiodo'] + '" class="cperiodo col-2 col-md-4 td">' + v['codperiodo'] + '</div>' +
                            '<div class="col-8 col-md-5 td text-center">' + v['plan'] + '</div>' +
                            '<div class="ccarrera col-2 col-md-3 td" data-cod="' + v['codcarrera'] + '">' + v['sigla'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-12 col-md-2">' +
                            '<div class="row">' +
                            '<div class="cciclo td col-4 col-md-4 text-center " data-cod="' + v['codciclo'] + '">' + v['codciclo'] + '</div>' +
                            '<div class="cturno td col-4 col-md-4 text-center ">' + v['codturno'] + '</div>' +
                            '<div class="cseccion td col-4 col-md-4 text-center ">' + v['codseccion'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-12 col-md-3">' +
                            '<div class="row">' +
                            '<div class="td col-3 col-md-3 text-center text-primary">' + v['aprobados'] + '</div>' +
                            '<div class="td col-3 col-md-3 text-center text-danger">' + v['desaprobados'] + '</div>' +
                            '<div class="td col-3 col-md-3 text-center text-danger">' + v['dpi'] + '</div>' +
                            '<div class="td col-3 col-md-3 text-center text-danger">' + v['nsp'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-12 col-md-3 td">' +
                            js_update +
                            js_estado +
                            '</div>' +
                            '</div>');
                    });

                    $(".btn-cestado").click(function(event) {
                        var im = $(this).closest(".cfila").data('idm');
                        var ie = $(this).data('ie');
                        var btdt = $(this).parents(".btn-group").find('.dropdown-toggle');
                        //var btdt=$(this).parents(".dropdown-toggle");
                        var texto = $(this).html();
                        //alert(btdt.html());
                        $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                        $.ajax({
                            url: base_url + 'matricula/fn_cambiarestado',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                'ce-idmat': im,
                                'ce-nestado': ie
                            },
                            success: function(e) {
                                $('#divcard-matricular #divoverlay').remove();
                                if (e.status == false) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Error!',
                                        text: e.msg,
                                        backdrop: false,
                                    })
                                } else {
                                    /*$("#fm-txtidmatricula").html(e.newcod);*/
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Felicitaciones, estado actualizado',
                                        text: 'Se ha actualizado el estado',
                                        backdrop: false,
                                    })
                                    btdt.removeClass('btn-danger');
                                    btdt.removeClass('btn-success');
                                    btdt.removeClass('btn-warning');
                                    btdt.removeClass('btn-secondary');
                                    switch (texto) {
                                        case "Activo":
                                            btdt.addClass('btn-success');
                                            btdt.html("ACT");
                                            break;
                                            /*case "CUL":
                                            btnscolor="btn-secondary";
                                            break;*/
                                        case "Retirado":
                                            btdt.addClass('btn-danger');
                                            btdt.html("RET");
                                            break;
                                        default:
                                            btnscolor = "btn-warning";
                                    }
                                    //btdt.addClass('class_name');
                                    //mostrarCursos("div-cursosmat", "", e.vdata);
                                }
                            },
                            error: function(jqXHR, exception) {
                                var msgf = errorAjax(jqXHR, exception, 'text');
                                $('#divcard-matricular #divoverlay').remove();
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: msgf,
                                    backdrop: false,
                                })
                            }
                        });
                        return false;
                    });
                    /*'<div class="td col-2 col-md-1 p-2"><a class="bg-primary text-white py-1 px-2 mt-2 rounded btn-editar" data-cm=' + vcm + '  href="#" title="Carga académica"><i class="fas fa-book"></i> Editar</a></div>' +
                    '</div>' +*/
                    //academico/matricula/ficha/excel/
                    //$("#fmt-conteo").html(nro + ' matriculas encontradas');
                    //$("#frm-matricular").show();
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            $('#divError').show();
            $('#msgError').html(msgf);
        }
    });
    return false;
}

$('#vw_fcb_cbtipodoc').change(function(event) {
    $('#vw_fcb_txtnrodoc').removeClass('is-invalid');
    $('#vw_fcb_txtnrodoc').parent().find('.invalid-feedback').remove();
    if ($(this).val() == "VAR") {
        $('#vw_fcb_txtnrodoc').val("00000000");
        $('#vw_fcb_cbmatricula').html("<option value='0'>Sin Matrícula</option>");
        $(".vw_fcb_ai_cbcodmatricula").html("<option value='0'>Sin Matrícula</option>")

    } else {
        $('#vw_fcb_txtnrodoc').val("");
        $('#vw_fcb_txtnrodoc').focus();
    }
    $('#vw_fcb_txtpagante').val("VARIOS");
    $('#vw_fcb_txtdireccion').val("");
    $('#vw_fcb_txtemail1').val("");
    $('#vw_fcb_txtemail2').val("");
    $('#vw_fcb_txtemail3').val("");
    $('#vw_fcb_codpagante').val("");

});
$("#vw_fcb_txtnrodoc").keyup(function(e) {

    if (e.keyCode == 13) {
        $("#vw_fcb_txtnrodoc").blur();
    }
});
$("#vw_fcb_txtnrodoc").blur(function(event) {
    $(this).removeClass('is-invalid');
    $(this).parent().find('.invalid-feedback').remove();
    var jvnrodoc = $('#vw_fcb_txtnrodoc').val();
    var jvtipodoc = $('#vw_fcb_cbtipodoc').val();
    var jvlongitud = $('#vw_fcb_cbtipodoc').find(':selected').data('lgt');
    if (jvlongitud == 0) {} else {
        if (jvlongitud == jvnrodoc.length) {
            /*if (jvtipodoc=="RUC"){
            }*/

            mostrar_pagante_deudas();
        } else {
            $(this).addClass('is-invalid');
            $(this).parent().append("<div class='invalid-feedback'> El n° de tener como mínimo " + jvlongitud + " dígitos</div>");
        }
    }
    return false;
});

function fn_removeitem(boton) {
    //event.preventDefault();

    var fila = boton.closest('.rowcolor');
    var pos = fila.data('arraypos');
    var rvalorventa = Number(fila.find('#vw_fcb_ai_txtvalorunitario').val()) * Number(fila.find('#vw_fcb_ai_txtcantidad').val());
    fila.remove();
    //itemsDocumento[pos].re
    //js_total=js_total - rvalorventa;
    delete itemsDocumento[pos];
    mostrar_montos();
}

function fn_additemdeduda(boton) {
    var fila = boton.closest('.cfila');
    var coddeuda = fila.data('coddeuda');
    var coditem = fila.data('coditem');
    var monto = fila.data('monto');
    var codmatricula = fila.data('codmatr');
    $("#modadditem").modal('show');
    $("#vw_fcb_ai_txtcoddeuda").val(coddeuda);
    $("#vw_fcb_ai_cbgestion").val(coditem);
    $("#vw_fcb_ai_cbgestion").change();
    $("#vw_fcb_ai_txtpreciounitario").val(parseFloat(monto).toFixed(2));
    $("#vw_fcb_ai_txtpreciounitario").focus();
    $("#vw_fcb_ai_codmatricula").val(codmatricula);
    return false;
}

function mostrar_pagante_deudas() {
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('#vw_fcb_txtpagante').val("");
    $('#vw_fcb_txtdireccion').val("" );
    $('#vw_fcb_txtemail1').val("");
    $('#vw_fcb_txtemail2').val("");
    $('#vw_fcb_txtemail3').val("");
    $('#vw_fcb_codpagante').val("");
    $('#vw_fcb_cbmatricula').html("<option value='0'>Sin Asignar</option>");
    $("#divdata_detalle_deuda").html("");

    var jvnrodoc = $('#vw_fcb_txtnrodoc').val();
    var jvtipodoc = $('#vw_fcb_cbtipodoc').val();
    $.ajax({
        url: base_url + 'pagante/fn_get_pagantes_deuda',
        type: 'POST',
        data: {
            vw_fcb_txtnrodoc: jvnrodoc,
            vw_fcb_cbtipodoc: jvtipodoc
        },
        dataType: 'json',
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                if (e.rscount == 1) {
                    $('#vw_fcb_txtpagante').val(e.vdata.razonsocial);
                    $('#vw_fcb_txtdireccion').val(e.vdata.direccion + " - " + e.vdata.distrito + " - " + e.vdata.provincia + " - " + e.vdata.departamento);
                    $('#vw_fcb_txtemail1').val(e.vdata.correo1);
                    $('#vw_fcb_txtemail2').val(e.vdata.correo2);
                    $('#vw_fcb_txtemail3').val(e.vdata.correo_corp);
                    $('#vw_fcb_codpagante').val(e.vdata.codpagante);

                    llenarCbMatriculas(e.vmatriculas);
                    llenarTbDeudas(e.vdeudas);

                } else {
                    
                    $("#modsearchpagante").modal("show");
                    $("#divcard_ltspagante").html(e.vpagantes);
                }

            } else {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire(
                    'Error!',
                    e.msg,
                    'error'
                )
            }
        },
        error: function(jqXHR, exception) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                'Error!',
                msgf,
                'error'
            )
        }
    })
}

function mostrar_deudas(codpagante) {
    $('#vw_pw_bt_ad_div_principal').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('input:text,select').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $.ajax({
        url: base_url + 'deudas_individual/fn_get_deuda_x_codpagante',
        type: 'POST',
        data: {
            vw_fcb_txtcodpagante: codpagante
        },
        dataType: 'json',
        success: function(e) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            if (e.status == true) {
                    llenarCbMatriculas(e.vmatriculas);
                    llenarTbDeudas(e.vdeudas);
            } else {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire(
                    'Error!',
                    e.msg,
                    'error'
                )
            }
        },
        error: function(jqXHR, exception) {
            $('#vw_pw_bt_ad_div_principal #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire(
                'Error!',
                msgf,
                'error'
            )
        }
    })
}

function llenarTbDeudas(arrayDeudas){
    $("#divdata_detalle_deuda").html("");
    if (arrayDeudas.length > 0) {
        $("#divcard_detalle_deuda").show();
        var tbdeudas = "";
        var nro = 0;
        var codciclocb = "";
        $.each(arrayDeudas, function(index, dd) {
            //prorroga
            nro++;
            if (codciclocb!= dd['codciclo']){
                codciclocb= dd['codciclo'];
                tbdeudas = tbdeudas + "<div class='row bg-danger pt-1'></div>";
            }

            bgsaldo=(dd['situacion']=="VENCIDO")? "bg-danger": "";
            tbdeudas = tbdeudas +

                "<div class='row cfila rowcolor' data-coditem=" + dd['codgestion'] + " data-monto=" + dd['saldo'] + " data-coddeuda='" + dd['codigo'] + "' data-codmatr='"+dd['matricula']+"'>" +

                "<div class='col-8 col-md-4 td'>" +
                "<span>" + dd['codgestion'] + " " + dd['gestion'] + "</span>" +
                "</div> " +
                "<div class='col-4 col-md-1 td text-right'>" +
                "<span>" + parseFloat(dd['monto']).toFixed(2) + "</span>" +
                "</div> " +
                "<div class='col-4 col-md-1 td text-right'>" +
                "<span>" + parseFloat(dd['mora']).toFixed(2) + "</span>" +
                "</div> " +
                "<div class='col-6 col-md-2 td text-center'>" +
                "<span>" + dd['fvenceDDMMYYYY'] + "</span>" +
                "</div> " +
                "<div class='col-6 col-md-1 td text-right " + bgsaldo + "'>" +
                "<span>" + parseFloat(dd['saldo']).toFixed(2) + "</span>" +
                "</div> " +
                "<div class='col-6 col-md-2 td text-center text-bold'>" +
                "<span>" + dd['periodo'] + " / " + dd['ciclo'] + "</span>" +
                "</div> " +
                "<div class='col-6 col-md-1 td text-center'>" +
                "<a onclick='fn_additemdeduda($(this));return false' class='badge badge-primary' href='#'><i class='fas fa-plus'></i></a>" +
                "</div> " +
                '</div>';
        });

        $("#divdata_detalle_deuda").html(tbdeudas);
    } else {
        $("#divcard_detalle_deuda").hide();
        $("#divdata_detalle_deuda").html("");
    }
}

function llenarCbMatriculas(arrayMatriculas){
    var vPeriodos= [];
    var iterPeriodo=0;
    var limPeriodo=6;
    $.each(arrayPeriodos, function(key, pd) {
        if (iterPeriodo<=limPeriodo){
            vPeriodos.push(pd);
        }
        iterPeriodo++;
    });
    var matricula = "";
    var ciclomat = "";
    if (arrayMatriculas.length > 0) {
       
        $.each(vPeriodos, function(keypd, pd) {
            var encPeriodo=false;
            $.each(arrayMatriculas, function(keymt, mt) {
                if (pd['codigo']==mt['codperiodo']){
                    if (mt['estado'] !== '2') {
                        encPeriodo=true;
                        matricula = matricula + "<option data-codperiodo='" + mt['codperiodo'] + "' value='" + mt['codigo'] + "'>" + mt['periodo'] + " - " + mt['ciclo'] + "</option>";
                        mt['eliminar']="SI";
                    }
                }
            });
            if (encPeriodo==false){
                matricula = matricula + "<option  data-codperiodo='" + pd['codigo'] + "' value='0'>" + pd['nombre'] + " - SM" + "</option>";
            }
        });
        $.each(arrayMatriculas, function(key, mt) {
            if (mt['estado'] !== '2') {
                if(typeof mt['eliminar'] == 'undefined') {
                    matricula = matricula + "<option data-codperiodo='" + mt['codperiodo'] + "' value='" + mt['codigo'] + "'>" + mt['periodo'] + " - " + mt['ciclo'] + "</option>";

                }
            }
        });
        matricula = "<option value=''></option>" + matricula;
        $('#vw_fcb_cbmatricula').html(matricula);
        $(".vw_fcb_ai_cbcodmatricula").html(matricula);
        $('#vw_fcb_cbmatricula').val('');
        $(".vw_fcb_ai_cbcodmatricula").val("");
        
    } else {
        $.each(vPeriodos, function(keypd, pd) {
            
                matricula = matricula + "<option  data-codperiodo='" + pd['codigo'] + "' value='0'>" + pd['nombre'] + " - SM" + "</option>";
            
        });
        matricula = "<option value=''></option>" + matricula;
        $('#vw_fcb_cbmatricula').html(matricula);
        $(".vw_fcb_ai_cbcodmatricula").html(matricula);
        $('#vw_fcb_cbmatricula').val('');
        $(".vw_fcb_ai_cbcodmatricula").val("");
    }
}



function fn_select_pagante(boton) {
    //e.preventDefault();
    var btn = boton.parents('.cfila');
    var codpagante = btn.data('codpag');
    var documento = btn.data('docum');
    var pagante = btn.data('pagante');
    var direccion = btn.data('direccion');
    var email = btn.data('email');
    var email2 = btn.data('email2');
    var email3 = btn.data('ecorp');
    var tipodocum = btn.data('tipdoc');
    $('#vw_fcb_cbtipodoc').val(tipodocum);
    $('#vw_fcb_txtnrodoc').val(documento);
    $('#vw_fcb_txtpagante').val(pagante);
    $('#vw_fcb_txtdireccion').val(direccion);
    $('#vw_fcb_txtemail1').val(email);
    $('#vw_fcb_txtemail2').val(email2);
    $('#vw_fcb_txtemail3').val(email3);
    $('#vw_fcb_codpagante').val(codpagante);
    $("#modsearchpagante").modal('hide');
    mostrar_deudas(codpagante);
};
//Función para comprobar los campos de texto
/*function checkCampos(obj) {
var camposRellenados = true;
obj.find("input").each(function() {
var $this = $(this);
if ($this.val().length <= 0) {
camposRellenados = false;
return false;
}
});
if (camposRellenados == false) {
return false;
} else {
return true;
}
}*/

$("#vw_fcb_btnedit_numero").click(function(event) {
    if ($(this).data('accion') == "auto") {
        $("#vw_fcb_sernumero_real").show();
        $("#vw_fcb_sernumero").hide();
        $(this).data('accion', "");
        $("#vw_fcb_sernumero_real").val("0")
        $(this).html('<i class="fas fa-undo-alt"></i>');
        $("#vw_fcb_sernumero_real").focus();
    } else {
        $("#vw_fcb_sernumero_real").hide();
        $("#vw_fcb_sernumero").show();
        $(this).data('accion', "auto");
        $("#vw_fcb_sernumero_real").val("0")
        $(this).html('<i class="fas fa-pencil-alt"></i>');
    }
});

function fn_update_concepto(txt) {

    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');
    var concepto = fila.find('input[name="vw_fcb_ai_txtgestion"]').val();
    itemsDocumento[pos]['vw_fcb_ai_txtgestion'] = concepto;
}

function fn_update_precios(txt) {

    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');

    var pu = Number(fila.find('input[name="vw_fcb_ai_txtpreciounitario"]').val());
    itemsDocumento[pos]['vw_fcb_ai_txtpreciounitario'] = pu;
    var vcnt = fila.find('input[name="vw_fcb_ai_txtcantidad"]').val();
    var valorventa = Number(vcnt) * pu;
    itemsDocumento[pos]['vw_fcb_ai_txtcantidad'] = vcnt;
    /*itemsDocumento[pos].vw_fcb_ai_txtpreciounitario = pu;
    itemsDocumento[pos].vw_fcb_ai_txtprecioventa = Number(newvalue);
    itemsDocumento[pos].vw_fcb_ai_txtvalorunitario = Number(newvalue);*/

    var afectacion = itemsDocumento[pos]['vw_fcb_ai_cbafectacion'];

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
        /*var row = $("#vw_fcb_rowitem"+pos);
        $("#vw_fcb_rowitem"+pos+" input[name='vw_fcb_ai_txtprecioventa']").val(Number(newvalue));
        ;*/

    mostrar_montos();
}
$("#btn_prueba").click(function(event) {
    event.preventDefault();
    datos_carne($('#vw_fcb_codpagante').val(), "");
    return false;
});

function fn_matricula_update(boton) {
    var fila = boton.closest('.rowcolor');
    var idmat = fila.data('idm');
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula/fn_matricula_x_codigo',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-idmat': idmat,
        },
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
            $('#divmodaladdmat #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error!',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                $('#vw_dp_divmatricular').show();
                $('#titlemodal').html(e.matdata['nomalu']);

                $('#fm-txtidmatriculaup').val(e.matdata['id64']);
                $('#fm-txtidup').val(e.matdata['idins64']);
                $('#fm-txtcarreraup').val(e.matdata['codcarrera']);
                $('#fm-txtperiodoup').val(e.matdata['codperiodo'])
                $('#fm-txtplanup').val(e.matdata['codplan']);

                $('#fm-cbplanup').html(e.vplanes);
                $('#fm-cbplanup').val(e.matdata['codplan']);

                $('#fm-cbestadoup').html(e.vestados);
                $('#fm-cbestadoup').val(e.matdata['estado']);

                $('#fm-cbtipoup').val(e.matdata['tipo']);
                $('#fm-cbbeneficioup').val(e.matdata['beneficio']);
                $('#fm-txtfecmatriculaup').val(e.matdata['fecha']);
                $('#fm-txtcuotaup').val(e.matdata['pension']);

                $('#fm-cbperiodoup').attr('disabled', true);
                $('#fm-cbperiodoup').val(e.matdata['codperiodo']);
                $('#fm-carreraup').html(e.matdata['carrera']);
                $('#fm-cbcicloup').val(e.matdata['codciclo']);
                $('#fm-cbturnoup').val(e.matdata['codturno']);
                $('#fm-cbseccionup').val(e.matdata['codseccion']);

                $('#fm-txtobservacionesup').val(e.matdata['observacion']);

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            $('#divmodaladdmat #divoverlay').remove();
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
}

$("#modaddmatricula").on('hidden.bs.modal', function(e) {
    $('#vw_dp_divmatricular').hide();
    $("#frm-matricular")[0].reset();
    $('#fm-txtidmatriculaup').val('0');
    $('#fm-carreraup').html('PROGRAMA ACADÉMICO');
    $('#fm-cbperiodoup').attr('disabled', false);
    $('#fm-txtidup').val('');
    $('#fm-txtcarreraup').val('');
    $('#fm-txtperiodoup').val('')
    $('#fm-txtplanup').val('');
    $('#fm-cbplanup').html('');
    $('#btn_newmatricula').data('carne', '')
})

$('#btn_newmatricula').click(function(e) {
    var boton = $(this);
    var carne = boton.data('carne');
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "inscrito/fn_get_datos_carne",
        type: 'post',
        dataType: 'json',
        data: {
            'fgi-txtcarne': carne,
        },
        success: function(e) {
            $('#divmodaladdmat #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'warning',
                    icon: 'warning',
                    title: 'ADVERTENCIA',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                $('#vw_dp_divmatricular').show();
                $('#fm-txtidup').val(e.vdata['idinscripcion']);
                $('#fm-txtidmatriculaup').val('0');
                $("#frm-matricular")[0].reset();
                $('#frm-matricular input,select').removeClass('is-invalid');
                $('#frm-matricular .invalid-feedback').remove();
                $('#fm-cbperiodoup').attr('disabled', false);

                if (e.vdata['idinscripcion'] == '0') {
                    $('#fm-txtcarreraup').val("");
                    $('#fm-carreraup').val("PROGRAMA ACADÉMICO");
                    $('#fm-cbplanup').html("<option value='0'>Plán curricular NO DISPONIBLE</option>");

                } else {

                    $('#fm-txtcarreraup').val(e.vdata['codcarrera']);
                    $('#fm-carreraup').html(e.vdata['carrera']);
                    $('#fm-cbplanup').html(e.vplanes);
                    $('#fm-cbplanup').val(e.vdata['codplan']);
                    $('#fm-txtplanup').val(e.vdata['codplan']);

                    $('#fm-txtmapepatup').val(e.vdata['paterno']);
                    $('#fm-txtmapematup').val(e.vdata['materno']);
                    $('#fm-txtmnombresup').val(e.vdata['nombres']);
                    $('#fm-txtmsexoup').val(e.vdata['sexo']);

                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodaladdmat #divoverlay').remove();
            $('#divError').show();
            $('#msgError').html(msgf);
        }
    })

    return false;
});

$('#lbtn_guardarmat').click(function(e) {
    $('#frm-matricular input,select').removeClass('is-invalid');
    $('#frm-matricular .invalid-feedback').remove();
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $("#frm-matricular").attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#frm-matricular').serialize(),
        success: function(e) {
            $('#divmodaladdmat #divoverlay').remove();
            if (e.status == false) {
                if (e.newcod == 0) {
                    Swal.fire({
                        type: 'warning',
                        icon: 'warning',
                        title: 'Matrícula DUPLICADA',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error, matrícula NO actualizada',
                        text: e.msg,
                        backdrop: false,
                    })
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                }
            } else {

                $("#modaddmatricula").modal('hide');
                if (e.matstatus == "INSERTAR") {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, matrícula registrada',
                        text: 'Se han registrado cursos',
                        backdrop: false,
                    })

                } else {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones, Matrícula actualizada correctamente',
                        text: 'verificar sus unidades didácticas de ser necesario',
                        backdrop: false,
                    })

                    $("#frmfiltro-matriculas").submit();
                }


            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodaladdmat #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error, matrícula NO actualizada',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});

function fn_update_cod_matricula_deta(txt) {

    var fila = txt.closest('.rowcolor');
    var pos = fila.data('arraypos');
    // var codigomat = fila.find('input[name="vw_fcb_ai_txtcodmatricula_det"] option:selected').val();
    var codigomat = txt.val();
    var codPeriodoDetalle=txt.find(':selected').data('codperiodo');
    // console.log("codigomat", codigomat);
    itemsDocumento[pos]['vw_fcb_ai_txtcodmatricula_det'] = codigomat;
    itemsDocumento[pos]['vw_fcb_ai_txtcodperiodo_det'] = '' + codPeriodoDetalle;
    // console.log("itemsDocumento", itemsDocumento);
}

function num_romanos(number){

    const romanos = {
        M: 1000,CM: 900,D: 500,CD: 400,C: 100,XC: 90,L: 50,XL: 40,X: 10,IX: 9,V: 5,IV: 4,I: 1,
    }

    let resultado = ""
    for (let r in romanos) {
        //repeat es parte del iterador y lo que hace es que
        // repite r las veces que sean necesarias. ( dependiendo la division)
        resultado += r.repeat(Math.floor( number / romanos[r]))
        number = number % romanos[r]
    }
    return resultado
}

$('#vw_fcb_emision').blur(function(e) {
    $('#vw_fcb_frmboleta input, select').removeClass('is-invalid');
    $('#vw_fcb_frmboleta .invalid-feedback').remove();
    fecha = $(this).val();

    var fecha_input = new Date(fecha+"T00:00:00");
    // fecha_input.setDate(day);
    
    var fecha_minima = new Date();
    fecha_minima.setDate(fecha_minima.getDate() - vconfiguracion);
    fecha_minima.setHours(0, 0, 0, 0);
    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    };
    var dayinsert = fecha_minima.toLocaleDateString('es-ES', options);
    // console.log("dia de la fecha restada:",dayinsert);
    
    // console.log("fecha resta 3 dias:",fecha_minima);

    var rsfecha_input = fecha_input.getTime();
    var rsfecha_minima = fecha_minima.getTime();

    if (rsfecha_input < rsfecha_minima) {
        Swal.fire({
            type: 'error',
            icon: 'error',
            title: 'Advertencia',
            text: 'La fecha ingresada no puede ser menor a ' + dayinsert,
            backdrop: false,
        });
        $('#vw_fcb_emision').addClass('is-invalid');
        $('#vw_fcb_emision').parent().append("<div class='invalid-feedback'>La fecha ingresada no puede ser mayor a "+dayinsert+"</div>");
    }
    else if (isFechaMenorActual(fecha)==false){
         Swal.fire({
            type: 'error',
            icon: 'error',
            title: 'Advertencia',
            text: 'La fecha ingresada no puede ser mayor a HOY',
            backdrop: false,
        });
        $('#vw_fcb_emision').addClass('is-invalid');
        $('#vw_fcb_emision').parent().append("<div class='invalid-feedback'>La fecha ingresada no puede ser menor a HOY</div>");
    }
    
})
</script>