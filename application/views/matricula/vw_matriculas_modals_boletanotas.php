


<!-- modal-fullscreen  -->
<div class="modal fade" id="vw_mat_modBoletaNotas" tabindex="-1" role="dialog" aria-labelledby="vw_mat_modBoletaNotas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content" id="vw_mat_modBoletaNotas_content">
     <!--  <div class="modal-header">
        <h5 class="modal-title text-bold" id="divcard_title"></h5>

        <?php if (getPermitido("203") == "SI") { ?>
        <button type="button" class="btn btn-info btn-sm" id="btn_agregarnew">
        <i class="fas fa-plus"></i> Agregar
        </button>
        <button type="button" class="btn btn-danger btn-sm d-none" id="btncancelar">
        <i class="fas fa-times"></i> Cancelar
        </button>
        <?php } ?>
      </div> -->
      <div class="modal-body">
        <div class="col-12">
           <div class="row">
                <input type="hidden" name="vwbn_txtcodmatricula64" id="vwbn_txtcodmatricula64" value="">
                <div class="col-sm-12">
                    <div class="row">
                        <span class="col-3 col-md-1">Estudiante:</span>
                        <h5 id="divbnestudiante" class="col-8 col-md-11 text-bold "></h5>

                        <span class="col-3 col-md-1">Periodo:</span>
                        <span id="divbnperiodo" class="col-8 col-md-2 text-bold "></span>
                    
                        <span class="col-3 col-md-1">Programa:</span>
                        <span id="divbncarrera" class="col-8 col-md-8 text-bold "></span>
                    
                        <span class="col-3 col-md-1">Plan:</span>
                        <span id="divbnplan" class="col-8 col-md-2 text-bold "></span>
                    
                        <span class="col-3 col-md-1">Semestre:</span>
                        <span id="divbnciclo" class="col-8 col-md-2 text-bold "></span>
                    
                        <span class="col-3 col-md-1">Turno:</span>
                        <span id="divbnturno" class="col-8 col-md-2 text-bold "></span>
                   
                        <span class="col-3 col-md-1">Sección:</span>
                        <span id="divbnseccion" class="col-8 col-md-2 text-bold "></span>
                    </div>
                </div>
                <!-- <div class="col-sm-10 col-md-4">
                    <div class="row">
                        <span class="border col-4 col-sm-3 col-md-2">Correo:</span>
                        <span id="divbncorreo" class="col-8 col-sm-9 col-md-10 text-bold border"></span>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="col-12 py-1" id="divcard_datamat">
          
          <div class="btable">
            <div class="thead col-12  d-none d-md-block">
              <div class="row">
                <div class='col-12 col-md-2'>
                  <div class='row'>
                    <div class='col-2 col-md-2 td'>N°1</div>
                    <div class='col-10 col-md-10 td'>GRUPO / PLAN</div>
                    
                  </div>
                </div>
                <div class='col-12 col-md-4 td'>
                  <!-- UNIDAD DID. -->
                  <div class='row'>
                    <div class='col-8 col-md-8 td'>UNIDAD DID.</div>
                    <div class='col-2 col-md-2 td'>SEM.</div>
                    <div class='col-2 col-md-2 td'>VECES</div>
                  </div>
                </div>
                <div class='col-12 col-md-2 td'>
                      ORIGEN
                </div>
                <div class="col-md-3">
                  <div class="row">
                    
                    <div class='col-12 col-md-3 td'>
                      PROMED.
                    </div>
                    <div class='col-12 col-md-3 td'>
                      RECUP.
                    </div>
                    <div class='col-12 col-md-3 td'>
                      FINAL
                    </div>
                    <div class='col-12 col-md-3 td'>
                      ESTADO
                    </div>
                  </div>
                </div>
                
                <div class='col-12 col-md-1 text-center td'>
                  
                  ACCIÓN
                  
                </div>
              </div>
              
            </div>
            <div class="tbody col-12" id="divcard_data_matricula_curso">
              
            </div>
          </div>
          
        </div>
        <div class="col-12 py-1 d-none" id="divcard_form_new">
          <form id="form_addmatricula" action="" method="post" accept-charset="utf-8">
            <input type="hidden" name="fmt-cbncodmatcurso" id="fmt-cbncodmatcurso" value="0">
            <input type="hidden" name="fmt-cbncodmatricula" id="fmt-cbncodmatricula" value="">
            <input type="hidden" name="fmt-cbncargaacadem" id="fmt-cbncargaacadem" value="">
            <input type="hidden" name="fmt-cbncargaacadsubsec" id="fmt-cbncargaacadsubsec" value="">
            <div class="row">
              <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                <select class="form-control form-control-sm" id="fmt-cbtipo" name="fmt-cbtipo">
                  <option value="MANUAL" data-tipo="MANUAL">MANUAL</option>
                  <option value="PLATAFORMA" data-tipo="PLATAFORMA">PLATAFORMA</option>
                  <option value="CONVALIDA" data-tipo="CONVALIDA">CONVALIDA</option>
                </select>
                <label for="fmt-cbtipo"> Tipo</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                <select class="form-control form-control-sm" id="fmt-cbnperiodo" name="fmt-cbnperiodo" placeholder="Periodo">
                  <?php foreach ($periodos as $periodo) {?>
                  <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbnperiodo"> Periodo</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-7">
                <select class="form-control form-control-sm" id="fmt-cbncarrera" name="fmt-cbncarrera">
                  <option value="0"></option>
                  <?php foreach ($carreras as $carrera) {?>
                  <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                  <?php } ?>
                  
                </select>
                <label for="fmt-cbncarrera"> Programa</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-5">
                <select class="form-control form-control-sm" id="fmt-cbnplan" name="fmt-cbnplan" onchange="get_unidades('fmt-cbnciclo','fmt-cbnplan');">
                  <option value=""></option>
                </select>
                <label for="fmt-cbnplan"> Plan</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                <select class="form-control form-control-sm" id="fmt-cbnciclo" name="fmt-cbnciclo" onchange="get_unidades('fmt-cbnciclo','fmt-cbnplan');">
                  <option value="0"></option>
                  <?php foreach ($ciclos as $ciclo) {?>
                  <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbnciclo"> Ciclo</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                <select class="form-control form-control-sm" id="fmt-cbnturno" name="fmt-cbnturno">
                  <?php foreach ($turnos as $turno) {?>
                  <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbnturno"> Turno</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                <select class="form-control form-control-sm" id="fmt-cbnseccion" name="fmt-cbnseccion">
                  <?php foreach ($secciones as $seccion) {?>
                  <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbnseccion"> Sección</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-6">
                <select class="form-control form-control-sm" id="fmt-cbnunididact" name="fmt-cbnunididact">
                  <option value=""></option>
                </select>
                <label for="fmt-cbnunididact"> Und. didac.</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-6">
                <select class="form-control form-control-sm" id="fmt-cbndocente" name="fmt-cbndocente">
                  <option value=""></option>
                  <?php foreach ($docentes as $docente) {
                  $nomdocente = $docente->paterno . ' ' . $docente->materno . ' ' . $docente->nombres;
                  ?>
                  <option value="<?php echo $docente->coddocente ?>"><?php echo $nomdocente ?></option>
                  <?php } ?>
                </select>
                <label for="fmt-cbndocente"> Docente</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
                <input type="number" name="fmt-cbnnotafinal" id="fmt-cbnnotafinal" class="form-control form-control-sm" placeholder="Nota final">
                <label for="fmt-cbnnotafinal"> Nota final</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
                <input type="number" name="fmt-cbnnotarecup" id="fmt-cbnnotarecup" class="form-control form-control-sm" placeholder="Recuperación">
                <label for="fmt-cbnnotarecup"> Recuperación</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
                <input type="date" name="fmt-cbnfecha" id="fmt-cbnfecha" class="form-control form-control-sm" value="<?php echo $fechahoy ?>">
                <label for="fmt-cbnfecha"> Fecha</label>
              </div>
              <div id="divcontent_convalida" class="border border-dark rounded p-2 col-12 mb-2 d-none">
                <span class="font-weight-bold">CONVALIDACIÓN</span>
                <div class="row mt-2">
                  <div class="form-group has-float-label col-12 col-sm-6 col-md-6">
                    <input type="text" name="fmt-cbnresolucion" id="fmt-cbnresolucion" class="form-control form-control-sm" placeholder="Resolución">
                    <label for="fmt-cbnresolucion"> Resolución</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-6 col-md-6">
                    <input type="date" name="fmt-cbnfechaconv" id="fmt-cbnfechaconv" class="form-control form-control-sm">
                    <label for="fmt-cbnfechaconv"> Fecha Convalida</label>
                  </div>
                </div>
              </div>
              
              <div class="form-group has-float-label col-12">
                <textarea name="fmt-cbnobservacion" id="fmt-cbnobservacion" class="form-control form-control-sm" placeholder="Observación" rows="3"></textarea>
                <label for="fmt-cbnobservacion"> Observación</label>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-sm float-right">Guardar</button>
              </div>
            </div>
            
          </form>
        </div>
      </div>
      <div class="modal-footer" id="vw_dp_mdcarga_footer_boleta">
        <div id="divcard_drop_estado"></div>
        
        <span id="fmt_conteo_modal" class="form-text text-primary float-left"></span>
        <?php if (getPermitido("202") == "SI") { ?>
        <a href="#" target="_blank" id="vw_dp_em_btnimp_boleta" data-codigo='' class="btn btn-info float-right">
          <i class="fas fa-print mr-1"></i> Imprimir
        </a>
        <?php } 
        if (getPermitido("207") == "SI") { ?>
        <button type="button" id="vw_dp_em_btnguardar" data-codigo='' class="btn btn-primary float-right">
        <i class="fas fa-save mr-1"></i>Guardar Notas
        </button>
      <?php } ?>
      <button type="button" class="btn btn-secondary float-left ml-2" data-dismiss="modal"><i class="fas fa-undo mr-1"></i> Cerrar</button>
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="vw_mdSincronizarRecuperaciones" tabindex="-1" aria-labelledby="vw_mdSincronizarRecuperacionesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="vw_mdSincronizarRecuperaciones_content">
      <div class="modal-header">
        <h5 class="modal-title" id="vw_mdSincronizarRecuperacionesLabel">Sincronizar Recuperación de U.D. </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 px-0 pt-2 table-responsive">
              <table id="tbmt_dtRecuperaciones" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                <thead>
                  <tr class="bg-lightgray">
                    <th>N°</th>
                    <th>CÓD</th>
                    <th>SEDE</th>
                    <th>PERIODO</th>
                    <th>SEM.</th>
                    <th>UD.</th>
                    <th>CÁLCULO</th>
                    <th>NF.</th>
                    <th>RC.</th>
                    <th>PF.</th>
                    <th>EST.</th>
                    <th>OPCIONES</th>
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
<script type="text/javascript">
    var table = $('#tbmt_dtRecuperaciones').DataTable({
        "autoWidth": false,
        "pageLength": 10,
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
            "targets": 9, // your case first column
            "className": "text-bold text-center",
            "width": "11px"
          },
        ],
        
        "fnDrawCallback": function (oSettings) {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover',
                html: true
            })
        }

    });
    

$('#vw_mat_modBoletaNotas').on('shown.bs.modal', function (event) {
    var codmatricula64=$("#vwbn_txtcodmatricula64").val();
    $('#vw_mat_modBoletaNotas_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    //$("#vw_mat_modBoletaNotas .modal-title").html("Cronograma: <span class='text-primary'>" + codcarrera + "</span>");
    $('#divcard_data_matricula_curso').html("");
    $.ajax({
        url: base_url + "academico/matricula/miembros/migrada/filtro-con-notas",
        type: 'post',
        dataType: 'json',
        data: {
            codmatricula64: codmatricula64
        },
        success: function(e) {
            if (e.status == true) {
                vmtr=e.vmatricula;
                $("#divbnperiodo").html(vmtr['periodo']);
                $("#divbncarrera").html(vmtr['carrera']);
                $("#divbnplan").html(vmtr['plan']);
                $("#divbnciclo").html(vmtr['ciclo']);
                $("#divbnturno").html(vmtr['turno']);
                $("#divbnseccion").html(vmtr['seccion']);

                estado_matricula = vmtr['matriculaestado'];
                carne=vmtr['carne'];
                var estudiante = vmtr['paterno'] + " " +  vmtr['materno'] + " " + vmtr['nombres'];
                $("#divbnestudiante").html(estudiante + " / " + carne);
                //$("#divbncorreo").html(vmtr['ecorporativo']);

                // DROPDOWN ESTADO MATRÍCULA
                var btnstcolor = "";
                switch (estado_matricula) {
                    case "ACTIVO":
                        btnstcolor = "btn-success";
                        break;
                    case "CULMINADO":
                        btnstcolor = "btn-secondary";
                        break;
                    case "DESAPROBADO":
                        btnstcolor = "btn-danger";
                        break;
                    case "RETIRADO":
                        btnstcolor = "btn-danger";
                        break;
                    default:
                        btnstcolor = "btn-warning";
                }


                //var fechamat = val['fecha'];
                // if (e.vpermiso178 == "SI") {
                //     dropdown_estado = '<div class="btn-group">' +
                //         '<button class="btn ' + btnstcolor + ' text-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                //         e.vmatricula['matriculaestado'] +
                //         '</button>' +
                //         '<div class="dropdown-menu">' +
                //         '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item" data-campo="modal" data-ie="' + cd1 + '">Activo</a>' +
                //         '<a href="#" onclick="fn_cambiarestado($(this))" data-pagante="' + carne + '" data-pagantenb="' + estudiante + '" data-programa="' + carrera + '" data-periodo="' + periodo + '" data-ciclo="' + ciclo + '" data-turno="' + turno + '" data-seccion="' + codseccion + '" data-plan="' + plan + '" class="dropdown-item" data-campo="modal" data-ie="' + cd2 + '">Retirado</a>' +
                //         '<a href="#" onclick="fn_cambiarestado($(this))" class="dropdown-item" data-campo="modal" data-ie="' + cd7 + '">Desaprobado</a>' +
                //         '</div>' +
                //         '</div>';
                // } else {
                    dropdown_estado = '<small class="badge ' + btnstcolor + ' p-2"> ' + estado_matricula + '</small>';
                //}

                $('#divcard_drop_estado').html(dropdown_estado);

                var nro = 0;
                var tabla = "";
                if (e.vdata.length !== 0) {
                    $('#fmt_conteo_modal').html(e.vdata.length + ' datos encontrados');
                    var inputrecup = "";
                    var inputfinal = "";
                    var btnupdateund = "";
                    var btndeleteund = "";
                    var btnorigennt = "disabled='disabled'";
                    $.each(e.vdata, function(index, val) {
                        nro++;
                        var vcarga = val['codcarga'];
                        var vdivision = val['codsubseccion_migrada'];

                        var vcarrera = val['codcarrera'];
                        var vciclo = val['codciclo'];
                        var vperiodo = val['codperiodo'];
                        var vplan = val['codplan'];
                        var vseccion = val['codseccion'];
                        var vturno = val['codturno'];
                        var vidmiembro = val['codmiembro64_plataforma'];
                        var codmatnota = val['codnotamigrada64'];
                        var codmatricula64 = val['codmatricula64_migrada'];
                        var vdocente = val["coddocente"];
                        var vunidad = val["codunidad_migrada"];

                        //var carne = val['carne'];
                        //var estudiante=val['paterno'] + " " + val['materno'] + " " + val['nombres']; 


                        var notafin_his = (val['notafin_migrada'] !== null) ? val['notafin_migrada'] : "";
                        colorbtnfin = (notafin_his > 12.5) ? "text-primary" : "text-danger";

                        var notarec_his = (val['notarecuperacion_migrada'] !== null) ? val['notarecuperacion_migrada'] : "";
                        colorbtnrec = (notarec_his > 12.5) ? "text-primary" : "text-danger";

                        var notafin_plataforma = (val['notafin_migrada'] !== null) ? val['notafin_migrada'] : "";
                        colorbtnfin = (notafin_his > 12.5) ? "text-primary" : "text-danger";

                        var notarec_plataforma = (val['notarecuperacion_migrada'] !== null) ? val['notarecuperacion_migrada'] : "";
                        colorbtnrec = (notarec_his > 12.5) ? "text-primary" : "text-danger";



                        var vReadonly = "";
                        var vColorFondoTxtFin = "";
                        if (val['origentipo_migrada'] == "MANUAL") {
                            colortipo = "btn-secondary";
                        } else if (val['origentipo_migrada'] == "PLATAFORMA") {
                            colortipo = "btn-primary";
                            vReadonly = "readonly";
                            vColorFondoTxtFin = "bg-lightgray";
                        } else if (val['origentipo_migrada'] == "CONVALIDA") {
                            colortipo = "btn-warning";
                            vReadonly = "readonly";
                            vColorFondoTxtFin = "bg-lightgray";
                        } else {
                            colortipo = "btn-info";
                        }

                        vOrigenCombo = '<div class="btn-group">' +
                            '<button class="btn ' + colortipo + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >' +
                            val['origentipo_migrada'] +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a href="#" onclick="fn_cambiar_origen($(this));return false;" class="btn-cborigen dropdown-item" data-origen="PLATAFORMA">PLATAFORMA</a>' +
                            '<a href="#" onclick="fn_cambiar_origen($(this));return false;" class="btn-cborigen dropdown-item" data-origen="MANUAL">MANUAL</a>' +
                            '</div>' +
                            "</div>";
                        if (val['origentipo'] == "CONVALIDA") vOrigenCombo = '<button class="btn ' + colortipo + ' btn-sm py-0"  > CONVALIDA </button>';
                        anota = val['nota'];
                        var jsest = val['estado'];
                        recuperacion = val['recuperacion'];
                        colorbtn = "text-danger";
                        if (anota >= 12.5) colorbtn = "text-primary";
                        colorbtnrc = "text-danger";
                        if (recuperacion >= 12.5) colorbtnrc = "text-primary";
                        colorfinal = "text-danger";
                        if (val['notaprom_migrada'] >= 12.5) colorfinal = "text-primary";

                        if (e.vpermiso137 == "SI") {
                            inputfinal = "<input onchange='fn_promediar($(this))' " + vReadonly + " type='number' data-valor='" + notafin_his + "' max='20' min='0' data-edit='0' class='nf_txt_final " + colorbtnfin + " form-control form-control-sm spinner-0' value='" + notafin_his + "' data-idmat=" + val['codigo64'] + " data-ntsaved='" + notafin_his + "' data-stnota='NF'>";
                        } else {
                            inputfinal = "<span class='form-control form-control-sm " + colorbtnfin + "'>" + notafin_his + "</span>";
                        }

                        if (e.vpermiso138 == "SI") {
                            inputrecup = "<input onchange='fn_promediar($(this))' type='number' data-valor='" + notarec_his + "' max='20' min='0' data-edit='0' class='nt_txt_recupera " + colorbtnrec + " form-control form-control-sm spinner-0' value='" + notarec_his + "' data-idmat=" + val['codigo64'] + " data-ntsaved='" + notarec_his + "' data-stnota='NR'>";
                        } else {
                            inputrecup = "<span class='form-control form-control-sm " + colorbtnrec + "'>" + notarec_his + "</span>";
                        }

                        if (e.vpermiso204 == "SI") {
                            btnupdateund = "<a class='dropdown-item editmatcurso' href='#' title='Editar' data-idmatc='" + val['codigo64'] + "'>" +
                                "<i class='fas fa-edit mr-1'></i> Editar" +
                                "</a>";
                        }

                        if (e.vpermiso205 == "SI") {
                            btndeleteund = "<a onclick='fn_eliminarNotaMigrada($(this))' class='dropdown-item text-danger' href='#' title='Eliminar'>" +
                                "<i class='fas fa-trash mr-1'></i> Eliminar" +
                                "</a>";
                        }

                        if (e.vpermiso206 == "SI") {
                            btnorigennt = "";
                        }

                        tabla = tabla +
                            '<div  data-codinscripcion64="' + val['codinscripcion_migrada64'] + '" data-codunidadmigrada64="' + val['codunidad_migrada64'] + '" data-carne="' + carne + '" data-estudiante="' + estudiante + '" data-codmiembro="' + vidmiembro + '" data-codmiembro64="' + vidmiembro + '" data-codmatricula64="' + codmatricula64 + '" data-codmatnota="' + codmatnota + '" data-codnotamigrada64="' + codmatnota + '" data-carga="' + vcarga + '" data-division="' + vdivision + '" data-docente="' + vdocente + '" data-carrera="' + vcarrera + '" data-ciclo="' + vciclo + '" data-periodo="' + vperiodo + '" data-plan="' + vplan + '" data-seccion="' + vseccion + '" data-turno="' + vturno + '" data-unidad="' + vunidad + '" data-estado="' + val['estado_migrada'] + '" data-repitencia="' + val['repitencia_plataforma'] + '" data-notafin="' + val['notafin_plataforma'] + '" data-notarecuperacion="' + val['notarecuperacion_plataforma'] + '"  data-notafinmigrada="' + val['notafin_migrada'] + '" data-notarecuperacionmigrada="' + val['notarecuperacion_migrada'] + '" class="row cfila rowcolor ">' +
                            "<div class='col-6 col-md-2'>" +
                            "<div class='row'>" +
                            "<div class='col-2 col-md-2 td'>" + nro + "</div>" +
                            "<div class='col-10 col-md-10 td'>" +
                            val['periodo'] + " " + val['carrera_sigla'] + " <b>" + val['codturno'] + "</b>  " + val['ciclo'] + "-" + val['codseccion'] + "<br>" + "<small>" + val['codplan'] + " " + val['plan'] + "</small>" + "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-6 col-md-4'>" +
                            "<div class='row'>" +
                            "<div class='col-8 col-md-8 td'>" +
                            "(" + val['codcarga_migrada'] + "G" + val['codsubseccion_migrada'] + ") " + val['codunidad_migrada'] + " <b>" + val['unidad_migrada'] + "</b><br>" +
                            "<small>" + val['doc_paterno_migrada'] + " " + val['doc_materno_migrada'] + " " + val['doc_nombres_migrada'] + 
                            "</small>" +
                            "</div>" +
                            "<div class='col-2 col-md-2 td text-center'>" +
                            val['ciclo_unidad_migrada'] +
                            "</div>" +
                            "<div class='col-2 col-md-2 td text-center'>" +
                             "<a href='#' onclick='fn_modal_sincronizarRepitencias($(this))' >" + val['veces_migrada'] + "</a>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-6 col-md-2 td text-center'>" +
                            vOrigenCombo +
                            "</div>" +
                            "<div class='col-6 col-md-3'>" +
                            "<div class='row'>" +

                            "<div class='col-6 col-md-3 td text-center'>" +
                            inputfinal +
                            "</div>" +
                            "<div class='col-6 col-md-3 td text-center'>" +
                            inputrecup +
                            "</div>" +
                            "<div class='col-6 col-md-3 td text-center'>" +
                            "<span class='form-control form-control-sm nt_txt_pf bg-lightgray" + colorfinal + "'>" + val['notaprom_migrada'] + "</span>" +
                            "</div>" +
                            "<div class='col-6 col-md-3 td text-center'>" +
                            "<select class='nf_estado form-control form-control-sm'>" +
                            "<option  value='-'> -- </option> " +
                            "<option " + ((jsest == 'NSP') ? "selected" : "") + " value='NSP'>NSP</option> " +
                            "<option " + ((jsest == 'DPI') ? "selected" : "") + " value='DPI'>DPI</option> " +
                            "</select>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "<div class='col-6 col-md-1 text-center'>" +
                            "<div class='row'>" +
                            "<div class='col-12 col-sm-12 col-md-12 td'>" +
                            "<div class='col-12 pt-1 pr-3 text-center'>" +
                            "<div class='btn-group'>" +
                            "<button class='btn btn-warning btn-sm dropdown-toggle py-0' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                            "<i class='fas fa-cog'></i>" +
                            "</a>" +
                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>" +
                            btnupdateund +
                            btndeleteund +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    })
                    $('#vw_dp_em_btnimp_boleta').attr('href', base_url + "academico/matricula/independiente/boleta/imprimir/" + codmatricula64);
                } else {
                    $('#fmt_conteo_modal').html('No se encontraron resultados');
                }
                $('#divcard_data_matricula_curso').html(tabla);
                $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
            } else {
                $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
                var msgf = '<span class="text-danger">' + e.msg + '</span>';
                $('#divcard_data_matricula_curso').html(msgf);
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
            // if (llamarUnidades=="SI"){
            //   //get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
            // }
        }
    });
   
})

function fn_modal_sincronizarRepitencias(btn) {
  var fila = btn.closest('.cfila');
  var vcodinscripcion64 = fila.data('codinscripcion64');
  var vcodunidad_migrada64=fila.data("codunidadmigrada64");
  
  fn_cargarTablaRecuperaciones(vcodinscripcion64,vcodunidad_migrada64);
  return false;
}

function fn_cargarTablaRecuperaciones(vcodinscripcion64,vcodunidad_migrada64) {
  $("#vw_mdSincronizarRecuperaciones").modal("show");
  $('#vw_mdSincronizarRecuperaciones_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
    

      $.ajax({
          url: base_url + 'academico/evaluaciones/migradas/filtrar',
          type: 'post',
          dataType: 'json',
          data: {
              'txtcodinscripcion64': vcodinscripcion64,
              'txtcodunidad64': vcodunidad_migrada64
          },
          success: function(e) {
              $('#vw_mdSincronizarRecuperaciones_content #divoverlay').remove();
              if (e.status == false) {
                  Swal.fire({
                      type: 'error',
                      icon: 'error',
                      title: 'Error!',
                      text: e.msg,
                      backdrop: false,
                  })
              } 
              else {
                tbRecuperaciones = $('#tbmt_dtRecuperaciones').DataTable();
                tbRecuperaciones.clear();
                 $.each(e.vfinales, function(index, v) {
                    btnOpciones="<a class='badge badge-primary px-2 py-1' href='#' onclick='fn_sincronizarRepitencias($(this));return false;' ><i class='fas fa-check-circle'></i></a>" ;
                    var arrayGrupo_new = [
                      (index + 1) ,
                      
                      v['codnotamigrada'] ,
                      v['sede_abrevia'] ,
                      v['periodo'] ,
                      v['ciclo'],
                      v['unidad_migrada'],
                      v['metodocalculo_migrada'],
                      v['notafin_migrada'],
                      v['notarecuperacion_migrada'],
                      "-",
                      v['estadofinal'],
                      
                     btnOpciones
                    ];
                    var filaGrupo_new = tbRecuperaciones.row.add(arrayGrupo_new).node();
                    $(filaGrupo_new).attr('data-codinscripcion64', v['codinscripcion_migrada64']);
                    $(filaGrupo_new).attr('data-codunidadmigrada64', v['codunidad_migrada64']);
                    $(filaGrupo_new).attr('data-codnotamigrada64', v['codnotamigrada64']);
                    $(filaGrupo_new).addClass('cfila');
                  });
                  tbRecuperaciones.draw();
                  
                ////////////
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: msgf,
                  backdrop: false,
              })
          }
      });
}

function fn_sincronizarRepitencias(btn) {
  var fila = btn.closest('.cfila');
  var vcodinscripcion64 = fila.data('codinscripcion64');
  var vcodunidad_migrada64=fila.data("codunidadmigrada64");
  var vcodnotamigrada64=fila.data("codnotamigrada64");
  
  
   $('#vw_mdSincronizarRecuperaciones_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');

      $.ajax({
          url: base_url + 'academico/evaluaciones/migradas/sincronizar-recuperacion',
          type: 'post',
          dataType: 'json',
          data: {
              'txtcodinscripcion64': vcodinscripcion64,
              'txtcodunidad64': vcodunidad_migrada64,
              'txtcodrecuperador64': vcodnotamigrada64
          },
          success: function(e) {
              $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
              if (e.status == false) {
                  Swal.fire({
                      type: 'error',
                      icon: 'error',
                      title: 'Error!',
                      text: e.msg,
                      backdrop: false,
                  })
              } 
              else {
                fn_cargarTablaRecuperaciones(vcodinscripcion64,vcodunidad_migrada64);
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
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

function fn_cambiar_origen(btn) {
      var fila = btn.closest('.cfila');
      var codigo = fila.data('codmatnota');
      var vcodmatricula64=fila.data("codmatricula64");
      var vnotafin_plataforma=fila.data("notafin");
      var vnotarecuperacion_plataforma=fila.data("notarecuperacion");
      
      var vNuevoOrigen = btn.data('origen');
      var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
      var vViejoOrigen = btdt.html();

      
      vtxtNotaFin=fila.find(".nf_txt_final");
      
      vtxtNotaRec=fila.find(".nt_txt_recupera");
      vtxtNotaProm=fila.find(".nt_txt_pf");
      
      $('#vw_mat_modBoletaNotas_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

      $.ajax({
          url: base_url + 'academico/carga-academica/miembros/migrada/update-origen',
          type: 'post',
          dataType: 'json',
          data: {
              'ce-codmatriculanota64': codigo,
              'ce-norigen': vNuevoOrigen,
              'ce-norigenanterior': vViejoOrigen,
              'ce-codmatricula64': vcodmatricula64
          },
          success: function(e) {
              $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
              if (e.status == false) {
                  Swal.fire({
                      type: 'error',
                      icon: 'error',
                      title: 'Error!',
                      text: e.msg,
                      backdrop: false,
                  })
              } else {
                  /*$("#fm-txtidmatricula").html(e.newcod);*/
                  Swal.fire({
                      type: 'success',
                      icon: 'success',
                      title: 'Felicitaciones, origen actualizado',
                      text: 'Se ha actualizado el origen',
                      backdrop: false,
                  })
                  btdt.removeClass('btn-primary');
                  btdt.removeClass('btn-info');
                  btdt.removeClass('btn-secondary');
                  switch (vNuevoOrigen) {
                      case "PLATAFORMA":
                          btdt.addClass('btn-primary');
                          vtxtNotaFin.attr('readonly', true);
                          vtxtNotaFin.addClass("bg-lightgray");
                          vtxtNotaFin.val(vnotafin_plataforma);
                          vtxtNotaRec.val(vnotarecuperacion_plataforma);
                          vtxtNotaProm.html("");
                          //vtxtNotaRec.attr('readonly', 'true');
                          break;
                      case "MANUAL":
                          btdt.addClass('btn-secondary');
                          vtxtNotaFin.attr('readonly', false);
                          vtxtNotaFin.val("");
                          vtxtNotaRec.val("");
                          vtxtNotaProm.html("");
                          vtxtNotaFin.removeClass("bg-lightgray");
                          break;
                      case "CONVALIDA":
                          btdt.addClass('btn-info');
                          vtxtNotaFin.attr('readonly', false);
                          vtxtNotaFin.removeClass("bg-lightgray");
                          break;
                      default:
                          btdt.addClass("btn-info");
                  }
                  btdt.html(vNuevoOrigen);

              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
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


function fn_eliminarNotaMigrada(btn){
  var fila = btn.closest('.cfila');
  var codigo = fila.data('codnotamigrada64');
  
    Swal.fire({
        title: '¿Está seguro de eliminar este registro?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, eliminar!'
    }).then(function(result) {
        if (result.value) {
            $('#vw_mat_modBoletaNotas_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center">'  + getCargando("Un momento...") + '</div>');
            $.ajax({
                url: base_url + 'matricula_independiente/fn_delete_matricula_curso',
                type: 'post',
                dataType: 'json',
                data: {
                    txtcodigo: codigo,
                },
                success: function(e) {
                    $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
                    if (e.status == true) {
                        Swal.fire({
                            title: 'Éxito!',
                            text: e.msg,
                            icon: 'success',
                            allowOutsideClick: false,
                        })
                        fila.remove();
                        //get_matriculas_cursos(codigo);
                        //get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
                    }
                },
                error: function(jqXHR, exception) {
                    $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        title: msgf,
                        // text: "",
                        type: 'error',
                        icon: 'error',
                    })
                }
            });
        }
    })
    return false;
}


$('#vw_dp_em_btnguardar').click(function() {
    arrdata = [];
    var nerror = 0;
    var edits = 0;
    $('#vw_mat_modBoletaNotas_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');


    $('#divcard_data_matricula_curso .cfila').each(function() {
      var idmat = $(this).data('idm');
        var codmatnota = $(this).data('codmatnota');

        // var carga = $(this).data('carga');
        // var division = $(this).data('division');
        // var docente = $(this).data('docente');
        // var miembro = $(this).data('miembro');
        
        // var carrera = $(this).data('carrera');
        // var ciclo = $(this).data('ciclo');
        // var periodo = $(this).data('periodo');
        // var plan = $(this).data('plan');
        // var seccion = $(this).data('seccion');
        // var turno = $(this).data('turno');
        // var unidad = $(this).data('unidad');
        // var estado = $(this).data('estado');
        // var repitencia = $(this).data('repitencia');
        // var notfin = ($(this).data('notafinmigrada')==null) ? "": $(this).data('notafinmigrada');
        // var notrec = ($(this).data('notarecuperacionmigrada')==null) ? "": $(this).data('notarecuperacionmigrada');
        // var notfin_txt=$(this).find(".txtnotafin").val();
        // var notrec_txt=$(this).find(".txtnotarec").val();
        // var fechamatr = $(this).data('matfecha');

        ////////////////////////////////////////
        var carne = $(this).data('carne');
        var estudiante = $(this).data('estudiante');
        var codnotamigrada64 = $(this).data("codnotamigrada64");
        var codmiembro64 = $(this).data("codmiembro64");
        var notfin = ($(this).data('notafinmigrada')==null) ? "": $(this).data('notafinmigrada');
        var notrec = ($(this).data('notarecuperacionmigrada')==null) ? "": $(this).data('notarecuperacionmigrada');
        var notfin_txt = $(this).find(".nf_txt_final").val();
        var notrec_txt = $(this).find(".nt_txt_recupera").val();
        var estado = $(this).find(".nf_estado").val();
        var metodo = $(this).data("metodo");

        var isedit = '0';

        if ((Number(notfin)!=Number(notfin_txt)) || (Number(notrec)!=Number(notrec_txt))){
            notfin = notfin_txt;
            notrec = notrec_txt;
            isedit = "1";
            //arrdata.push(myvals);
        }

        if (isedit == "1") {
            if ((notfin_txt < 0) || (notfin_txt > 20)) {
                nerror++
            } else if ((notrec_txt < 0) || (notrec_txt > 20)) {
                nerror++
            } else {
                //var myvals = [codmat, estado, notfin, notrec, codmiembro,metodo];
                
                 var myvals = ['', codmiembro64, codnotamigrada64, '', '', '', '', '', '', '', '', '', '', estado, '', notfin, notrec, '', carne, estudiante];
                arrdata.push(myvals);
            }
            edits++;
        }
    });

    if (nerror == 0) {
        if (edits > 0) {
            $.ajax({
                url: base_url + 'academico/matricula/miembros/migrada/update-notas-final',
                type: 'post',
                dataType: 'json',
                data: {
                    filas: JSON.stringify(arrdata),
                },
                success: function(e) {
                    $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'ERROR, NO se guardó cambios',
                            text: e.msg,
                            backdrop: false,
                        });
                    } else {
                        /*$('.txtnota').each(function() {
                        if ($(this).data('edit')=='1'){
                        $(this).data('edit',  '0');
                        }

                        });*/

                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'ÉXITO, Se guardó cambios',
                            text: "Lo cambios fueron guardados correctamente",
                            backdrop: false,
                        });
                        var idmatricula = $('#fmt-cbncodmatricula').val();
                        //get_matriculas_cursos(idmatricula);
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop: false,
                    });
                },
            })
        } else {
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: 'ÉXITO, Se guardó cambios (M)',
                text: "Lo cambios fueron guardados correctamente",
                backdrop: false,
            });
            $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
        }
    } else {
        Swal.fire({
            type: 'error',
            icon: 'error',
            title: 'ERROR, Notas Invalidas',
            text: "Existen " + nerror + " error(es): NOTA NO VÁLIDA (Rojo)",
            backdrop: false,
        });
        $('#vw_mat_modBoletaNotas_content #divoverlay').remove();
    }
});

$(document).on("blur", ".cfila div input", function(event) {
    if ($(this).data('ntsaved') != $(this).val()) {
        $(this).data('edit', '1');
        if (($(this).val() < 0)||($(this).val() > 20)) {
            $(this).parent().addClass('cellerror');
        } else {
                
            $(this).parent().removeClass('cellerror');
            $(this).parent().addClass('celleditada');
        }

    } else {
        $(this).data('edit', '0');
        $(this).parent().removeClass('celleditada');
    }
    if ($(this).val() > 12) {
        $(this).removeClass('text-danger');
        $(this).addClass('text-primary');
    } else {
        $(this).removeClass('text-primary');
        $(this).addClass('text-danger');
    }
})

</script>