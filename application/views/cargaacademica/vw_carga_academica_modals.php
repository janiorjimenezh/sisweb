<div class="modal fade" id="md_docentes" tabindex="-1" role="dialog" aria-labelledby="md_docentes" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="divcontent_docentes">
            <div class="modal-header">
                <h5 class="modal-title">Docentes Activos</h5>
                
            </div>
            <div class="modal-body">
                <!--<div class="col-12" id="divcard_docentes">-->
                <input type="hidden" name="vw_md_doc_txtcarga" id="vw_md_doc_txtcarga">
                <input type="hidden" name="vw_md_doc_txtdivision" id="vw_md_doc_txtdivision">
                <div class="col-12 border bg-lightgray p-1 mb-3" >
                    <h5 id="vw_md_doc_div_unidad"></h5>
                </div>
                <div class="form-group has-float-label col-12 col-md-12">
                    <select class="form-control form-control-sm" id="vw_md_doc_docentes" name="vw_md_doc_docentes" placeholder="Periodo">
                        <option value="00000">SIN DOCENTE</option>
                        <?php foreach ($docentes as $coddoc => $doc) {?>
                        <option value="<?php echo $doc->coddocente64 ?>"><?php echo $doc->paterno." ".$doc->materno." ".$doc->nombres ?></option>
                        <?php } ?>
                    </select>
                    <label for="vw_md_doc_docentes"> Docente</label>
                </div>
                <!--</div>-->
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary float-left" data-dismiss="modal">Cerrar</button>
                
                <button type="button" id="vw_md_doc_guardar" data-codigo='' class="btn btn-primary float-right">
                <i class="fas fa-save mr-1"></i>Guardar
                </button>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="md-plan" tabindex="-1" role="dialog" aria-labelledby="md-plan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Terminar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modCambiarCalculo" tabindex="-1" role="dialog" aria-labelledby="modCambiarCalculo" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modcambiarCalculo_content">
            <div class="modal-header">
                <h5 class="modal-title" >Cambiar metodo de cálculo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="btable">
                    <div class="thead col-12  d-none d-md-block bg-lightgray">
                        <div class="row">
                            <div class='col-12 col-md-2'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 td'>N°</div>
                                    <div class='col-10 col-md-10 td'>Abrevia</div>
                                    
                                </div>
                            </div>
                            <div class='col-12 col-md-10 td'>
                                Descripción
                            </div>
                        </div>
                        
                    </div>
                    <div class="tbody col-12">
                        <?php
                        $nro=0;
                        foreach ($metodos as $key => $metodo) {
                        $nro++;
                        echo
                        "<div class='row cfila' data-codmetodo64='".base64url_encode($metodo->codigo)."' data-metodo='$metodo->codigo'>
                            <div class='col-12 col-md-4'>
                                <div class='row'>
                                    <div class='col-2 col-md-1 td bg-lightgray'>$nro</div>
                                    <div class='col-10 col-md-2 td'>$metodo->codigo</div>
                                    <div class='col-10 col-md-9 td'>$metodo->nombre</div>
                                </div>
                            </div>
                            <div class='col-12 col-md-7 td'>
                                $metodo->descripcion
                            </div>
                            <div class='col-12 col-md-1 td text-center'>
                                <a onclick='fn_asignar_metodo($(this));return false' href='#'><i class='fas fa-check-square fa-2x'></i></a>
                            </div>
                        </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>

<!--MODAL CAMBIAR CARGA Y SUBSECCION DE ESTUDIANTE-->
<div class="modal fade" id="modCambiarCargaDivision" tabindex="-1" role="dialog" aria-labelledby="modCambiarCargaDivision" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modCambiarCargaDivision_content">
            <div class="modal-header">
                <h5 class="modal-title" >Cambiar metodo de cálculo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <h4 class="bg-lightgray border px-2" id="vw_md_ccd_spnestudiante"></h4>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="vw_md_ccd_txtcarga" name="vw_md_ccd_txtcarga" aria-label="Código de Carga Académica">
                  <div class="input-group-prepend">
                    <span class="input-group-text">G</span>
                  </div>
                  <input type="text" class="form-control" id="vw_md_ccd_txtdivision" name="vw_md_ccd_txtdivision" aria-label="Código de la Subsección">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="vw_md_ccd_btguardar" onclick="fn_miembro_update_CargaDivision($(this));return false;" data-idmiembro64='' class="btn btn-primary float-right">
                    <i class="fas fa-save mr-1"></i>Guardar
                    </button>
            </div>
        </div>
    </div>
</div>

<!--MODAL FUSIONAR-->
<div class="modal fade" id="modFusionar" tabindex="-1" role="dialog" aria-labelledby="modFusionar" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modFusionar_content">
            <div class="modal-header">
                <h5 class="modal-title" >Fusión de Unidades Didacticas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="row pb-4">
                        <div class="col-12 border-bottom">
                            <b id="text_unidad_did" class="text-danger"></b>
                            <span id="textgroup" class="ml-1"></span>
                        </div>
                    </div>
                    <input type="hidden" id="vw_mdfs_txtcodcarga">
                    <input type="hidden" id="vw_mdfs_txtdivision">
                    <form id="frmfiltro-carga_academica_fusion" name="frmfiltro-carga_academica_fusion" method="post" accept-charset='utf-8'>
                        <div class="row">
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                                <select  class="form-control form-control-sm" id="fmt-cbsede" name="fmt-cbsede" placeholder="Filial">
                                    <option value="%"></option>
                                    <?php
                                    foreach ($sedes as $filial) {
                                    $select=($vuser->idsede==$filial->id) ? "selected":"";
                                    echo "<option $select value='$filial->id'>$filial->nombre</option>";
                                    }
                                    ?>
                                </select>
                                <label for="fmt-cbsede"> Filial</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                                <select  class="form-control form-control-sm" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
                                    <option value="%"></option>
                                    <?php foreach ($periodos as $periodo) {?>
                                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbperiodo"> Periodo</label>
                            </div>
                            
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                                <select  class="form-control form-control-sm" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" onchange="fn_get_planes_combo($(this),'frmfiltro-carga_academica_fusion','fmt-cbplan');return false;">
                                    <option value="%"></option>
                                    <?php foreach ($carreras as $carrera) {?>
                                    <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbcarrera"> Prog. de Estudios</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                                <select name="fmt-cbplan" id="fmt-cbplan"class="form-control form-control-sm">
                                    <option data-carrera="0" value="%">Todos</option>
                                    <option data-carrera="0" value="0">Sin Plan</option>
                                    <?php foreach ($planes as $pln) {
                                    echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                                    } ?>
                                </select>
                                <label for="fmt-cbplan">Plan estudios</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                                <select  class="form-control form-control-sm" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Semestre" >
                                    <option value="%"></option>
                                    <?php foreach ($ciclos as $ciclo) {?>
                                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbciclo">Semestre</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                                <select  class="form-control form-control-sm" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                                    <option value="%"></option>
                                    <?php foreach ($turnos as $turno) {?>
                                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbturno"> Turno</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                                <select  class="form-control form-control-sm" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                                    <option value="%"></option>
                                    <?php foreach ($secciones as $seccion) {?>
                                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                                    <?php } ?>
                                </select>
                                <label for="fmt-cbseccion"> Sección</label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-5 col-md-5">
                                <input class="form-control text-uppercase form-control-sm" autocomplete="off" id="fmt-txtbusqueda" name="fmt-txtbusqueda" placeholder="Unidad Didáctica" >
                                <label for="fmt-txtbusqueda"> Unidad Didáctica
                                </label>
                            </div>
                            <div class="form-group has-float-label col-12 col-sm-6 col-md-5">
                                <select  class="form-control form-control-sm" id="fmt-cbdocente" name="fmt-cbdocente" placeholder="Sección" >
                                  <option value="%"></option>
                                  <option value="00000">SIN DOCENTE</option>
                                        <?php foreach ($docentes as $coddoc => $doc) {?>
                                        <option value="<?php echo $doc->coddocente ?>"><?php echo $doc->paterno." ".$doc->materno." ".$doc->nombres ?></option>
                                        <?php } ?>
                                </select>
                                <label for="fmt-cbdocente"> Docente</label>
                              </div>
                            <div class="col-6 col-sm-2 col-md-1">
                                <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fas fa-search"></i></button>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="col-12 px-0 pt-2">
              <div class="table-responsive">
                <table id="tbc_dtCargaAcademica_fusion" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                  <thead>
                    <tr class="bg-lightgray">
                      <th>N°</th>
                      <th>Filial</th>
                      <th>Carga</th>
                      
                      <th>Plan</th>
                      <th>Grupo</th>
                      <th>Unidad Didáctica</th>
                      <th title="ABIERTO"><i class="far fa-folder-open"></i></th>
                      <th title="VISIBLE"><i class="far fa-eye"></i></th>
                      <th>Cd</th>
                      <th>Hr</th>
                      <th title="ENROLADOS"><i class="fas fa-user-friends"></i></th>
                      <th>Docente</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
<!--<div class="modal fade" id="modEnrolados" tabindex="-1" role="dialog" aria-labelledby="modEnrolados" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modEnrolados_content">
            <div class="modal-header">
                <h5 class="modal-title" >Estudiantes Enrolados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" value="0" id="vw_cme_txtcodcarga">
                <input type="hidden" value="0" id="vw_cme_txtcoddivision">
            </div>
            <div class="modal-body">
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>-->

<div class="modal fade" id="modview_hoarios" tabindex="-1" role="dialog" aria-labelledby="modview_hoarios" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modview_hoarios_content">
            <div class="modal-header">
                <h5 class="modal-title" >Horarios de <b id="modname_unidad"></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
                <div class="col-12 px-0 pt-2" id="divcard_dtCargaHorario">
                    <div class="table-responsive">
                        <table id="tbc_dtCargaHorario" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                            <thead>
                                <tr class="bg-lightgray">
                                    <th>N°</th>
                                    <th>Dia</th>
                                    <th>Inicia</th>
                                    <th>Finaliza</th>
                                    <th>Aula</th>
                                    <th>Piso</th>
                                    <th>Hr</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="divcard_formadd">
                    <form id="form_addHorario" action="" method="post" accept-charset="utf-8">
                        <input type="hidden" value="0" id="vw_horario_txtcodcarga" name="vw_horario_txtcodcarga">
                        <input type="hidden" value="0" id="vw_horario_txtcoddivision" name="vw_horario_txtcoddivision">
                        <input type="hidden" value="0" id="vw_horario_txtturno">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm btn-outline-primary float-right" onclick="fn_agrega_item_horario($(this));return false;" id="btn_item_add">
                                <i class="fas fa-plus"></i> Agregar item
                            </button>
                            </div>
                        </div>
                        <div id="divdata_items_horario" class="mt-3 border rounded p-4">
                            
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-sm float-right">
                                    Guardar
                                </button>
                                <button type="button" class="btn btn-danger btn-sm float-left" id="btncancel_horario">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>

<div id="vw_fcb_rowitem" class="row rowcolors vw_fcb_class_rowitem" data-arraypos="-1">
    <div class="form-group has-float-label col-md-3">
        <input type="hidden" name="fictxtcodigoh" value="0">
        <select class="form-control" name="ficbodia" placeholder="Día">
            <option value="LUNES">LUNES</option>
            <option value="MARTES">MARTES</option>
            <option value="MIÉRCOLES">MIÉRCOLES</option>
            <option value="JUEVES">JUEVES</option>
            <option value="VIERNES">VIERNES</option>
            <option value="SÁBADO">SÁBADO</option>
        </select>
        <label for="ficbodia">Día</label>
    </div>

    <div class="form-group has-float-label col-md-3">
        <select class="form-control" name="ficboaula" id="ficboaula" placeholder="Aula">
            
        </select>
        <label for="ficboaula">Aula</label>
    </div>

    <div class="form-group has-float-label col-md-2">
        <select class="form-control" name="ficbohoraini" id="ficbohoraini" placeholder="Hora Inicia" >
            
        </select>
        <label for="ficbohoraini">Hora Inicia</label>
    </div>

    <div class="form-group has-float-label col-md-2">
        <select class="form-control" name="ficbohorafin" id="ficbohorafin" placeholder="Hora Culmina" >
            
        </select>
        <label for="ficbohorafin">Hora Culmina</label>
    </div>

    <div class="col-12 col-sm-2">
        <button type="button" class="btn btn-sm btn-outline-danger deleteitemh" onclick="fn_delete_item_horario($(this));return false;">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</div>