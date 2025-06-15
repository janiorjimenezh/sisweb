<div class="modal modal-fullscreen fade" id="modEnrolados" tabindex="-1" role="dialog" aria-labelledby="modEnrolados" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
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
                <div class="row fdivision" data-culminado="" data-codcargafusion64="" data-divisionfusion64="">
                    
                    <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_spnPeriodo"></div>
                        <label for="vw_cme_spnPeriodo"> Periodo</label>
                    </div>
                    <div class="has-float-label col-12 col-sm-6 col-md-5">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_spnPrograma"></div>
                        <label for="vw_cme_spnPrograma"> Programa</label>
                    </div>
                    <div class="has-float-label col-12 col-sm-6 col-md-1">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_spnSemestre"></div>
                        <label for="vw_cme_spnSemestre"> Semestre</label>
                    </div>
                    <div class="has-float-label col-12 col-sm-6 col-md-2">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_spnTurno"></div>
                        <label for="vw_cme_spnTurno"> Turno</label>
                    </div>
                    <div class="has-float-label col-12 col-sm-6 col-md-1">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_spnSeccion"></div>
                        <label for="vw_cme_spnSeccion"> Sección</label>
                    </div>
                    <div class="has-float-label col-12 col-sm-6 col-md-1">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_spnDivision"></div>
                        <label for="vw_cme_spnDivision"> División</label>
                    </div>
                    <div class="has-float-label col-12 col-sm-6 col-md-5">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_spnDocente" ></div>
                        <label for="vw_cme_spnDocente"> Docente</label>
                    </div>
                    <div class="has-float-label col-12 col-sm-6 col-md-2">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_spnReuniones">
                            <span id="vw_cme_spnReuniones_actual"></span> /     
                            <span class="spnNroSesiones" id="vw_cme_spnReuniones_total"></span>
                            <span>
                                <a  href="#" onclick="vw_abrir_modal_cambiarNroSesiones($(this));return false" title="Cambiar Nro de Reuniones">
                                    <i class="fas fa-pencil-alt ml-1"></i>
                                </a>   
                            </span>
                                                   
                        </div>
                        <label for="vw_cme_spnReuniones"> Reuniones</label>
                    </div>

                    <div class="has-float-label col-12 col-sm-6 col-md-2">
                        <div class="form-control text-uppercase form-control-sm" id="vw_cme_divMetodo">
                            <span id="vw_cme_spnMetodo"></span>  
                            
                            <span>
                                <a  href="#" data-toggle="modal" data-target="#modCambiarCalculo" title="Cambiar Cálculo">
                                    <i class="fas fa-pencil-alt ml-1"></i>
                                </a>
                                <a href="#" title="Editar Estructura de Registro">
                                    <i class="fas fa-calculator ml-1"></i>
                                </a>
                            </span>
                                                   
                        </div>
                        <label for="vw_cme_divMetodo"> Cálculo</label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 text-center border" id="vw_cme_divEstado">
                       
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 text-center border">
                       
                    </div>

                </div>
<!--                 <div class="col-12 border rounded p-1 bg-lightgray" >
                    <h4 id="vw_md_pagos_estudiante"></h4>
                </div>
                <div class="col-12 border rounded p-1 bg-lightgray" >
                    <h4 id="vw_md_pagos_gestion"></h4>
                </div> -->
                <hr>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="md_enrolados-tab" data-toggle="tab" href="#md_enrolados" role="tab" aria-controls="md_enrolados" aria-selected="true">Enrolados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="md_reuniones-tab" data-toggle="tab" href="#md_reuniones" role="tab" aria-controls="md_reuniones" aria-selected="false">Reuniones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="md_asistencia-tab" data-toggle="tab" href="#md_asistencia" role="tab" aria-controls="md_asistencia" aria-selected="false">Asistencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="md_evaluaciones-tab" data-toggle="tab" href="#md_evaluaciones" role="tab" aria-controls="md_evaluaciones" aria-selected="false">Evaluaciones</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="md_enrolados" role="tabpanel" aria-labelledby="md_enrolados-tab">
                        <div class="table-responsive">
                            <table id="tbce_dtEstutiantesEnrolados" class="tbdatatable tbdatatableModal table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                <thead>
                                    <tr class="bg-lightgray ">
                                        <th>N°</th>
                                        <th>Filial</th>
                                        <th>Carné</th>
                                        <th>Estudiante</th>
                                        <th>Grupo</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                        <th>F(%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="md_reuniones" role="tabpanel" aria-labelledby="md_reuniones-tab">
                        <div class="table-responsive">
                            <table id="tbce_dtReuniones" class="tbdatatable tbdatatableModal table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                <thead>
                                    <tr class="bg-lightgray ">
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Reu.</th>
                                        <th>Tema</th>
                                        <th>Inicia</th>
                                        <th>Culmina</th>
                                        <th>Tipo</th>
                                        <th>Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="md_asistencia" role="tabpanel" aria-labelledby="md_asistencia-tab">
                        <div class="table-responsive">
                            <table id="tbce_dtEstudiantesAsistencia" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                <thead>
                                
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="md_evaluaciones" role="tabpanel" aria-labelledby="md_evaluaciones-tab">
                        <div class="table-responsive">
                            <table id="tbce_dtEstutiantesEvaluaciones" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                                <thead>
                                    
                                    
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