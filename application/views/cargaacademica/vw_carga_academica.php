
<?php
$vbaseurl=base_url();
date_default_timezone_set('America/Lima');
$fechahoy = date('Y-m-d');
$vuser=$_SESSION['userActivo'];
$p66=getPermitido("66");
$p67=getPermitido("67");
$p128 = getPermitido("128");
$p208 = getPermitido("208");//Acceder a horarios
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>
<link href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.bootstrap4.min.css"/>-->

<div class="content-wrapper">
  
  <?php include 'vw_carga_academica_modal_cambiar_notas_finales_por_curso.php'; ?>
  <?php include 'vw_carga_academica_modal_detalle.php'; ?>
  <?php include 'vw_carga_academica_modals.php'; ?>
  <section id="s-cargado" class="content pt-1">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-carga_academica-tab" data-toggle="tab" href="#nav-carga_academica" role="tab" aria-controls="nav-carga_academica" aria-selected="true">Cargas Académicas</a>
        <a class="nav-item nav-link" id="nav-grupos-tab" data-toggle="tab" href="#nav-grupos" role="tab" aria-controls="nav-grupos" aria-selected="false">Carga Grupal</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-carga_academica" role="tabpanel" aria-labelledby="nav-carga_academica-tab">
        <div id="divcard-cargaAcademica" class="card">
          
          <div class="card-body">
            <div class="row-fluid">
              <form id="frmfiltro-carga_academica" name="frmfiltro-carga_academica" method="post" accept-charset='utf-8'>
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
                    <select  class="form-control form-control-sm" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" onchange="fn_get_planes_combo($(this),'frmfiltro-carga_academica','fmt-cbplan');return false;">
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
                  <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
                    <input class="form-control text-uppercase form-control-sm" autocomplete="off" id="fmt-txtbusqueda" name="fmt-txtbusqueda" placeholder="Unidad Didáctica" >
                    <label for="fmt-txtbusqueda"> Unidad Didáctica
                    </label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                    <select  class="form-control form-control-sm" id="fmt-cbestado" name="fmt-cbestado" placeholder="Sección" >
                      <option value="%"></option>
                      <option value="NO">Abierto</option>
                      <option value="SI">Culminado</option>
                    </select>
                    <label for="fmt-cbestado">Estado</label>
                  </div>
                  <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
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
                <table id="tbc_dtCargaAcademica" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                  <thead>
                    <tr class="bg-lightgray">
                      <th>N°</th>
                      <th>Filial</th>
                      <th>Carga</th>
                      
                      <th>Plan</th>
                      <th>Grupo</th>
                      <th>Unidad Didáctica</th>
                      <th>Ses.</th>
                      <th class="text-center" title="ABIERTO"><i class="far fa-folder-open"></i></th>
                      <!-- <th class="text-center" title="VISIBLE"><i class="far fa-eye"></i></th> -->
                      <th>Cd</th>
                      <th>Hr</th>
                      <th title="ENROLADOS"><i class="fas fa-user-friends"></i></th>
                      <th>Docente</th>
                      <th>Fusión</th>
                      <?php
                      echo "<th title='Horario'><i class='fas fa-calendar-alt'></i></th>";
                      if ($p208 == "SI") {
                        //echo "";
                      }
                      ?>
                      <th>Acciones</th>
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
      <div class="tab-pane fade" id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">
        <div id="divcard-GruposcargaAcademica" class="card">
           <div class="card-header">
                <h3 class="card-title">Selecciona un gupo para generar su carga académica</h3>
              </div>
          <div class="card-body">
            <div id="divcard_grupo" class="cardg">
             
              <div class="card-bodyg">
                
                <form id="frm-grupo" name="frm-grupo" action="#" method="post" accept-charset='utf-8'>
                  <div class="row mt-2">
                    <div class="form-group has-float-label col-12  col-sm-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fca-cbperiodo" name="fca-cbperiodo" placeholder="Periodo" required >
                        <option value="0">Periodo</option>
                        <?php foreach ($periodos as $periodo) {?>
                        <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-cbperiodo"> Periodo</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-sm-4">
                      <select class="form-control form-control-sm" id="fca-carrera" name="fca-carrera" placeholder="Programa">
                        <option value="0">Selecciona un Programa Acad.</option>
                        <?php foreach ($carreras as $carrera) {?>
                        <option value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>"><?php echo $carrera->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-carrera"> Programa</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-md-4">
                      <select class="form-control form-control-sm" id="fca-plan" name="fca-plan" placeholder="Plan curricular">
                        <option value="0">Selecciona Plan curricular</option>
                        <?php foreach ($planes as $plan) {?>
                        <option value="<?php echo $plan->codigo ?>"><?php echo $plan->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-plan"> Plan curricular</label>
                    </div>
                    
                    <div class="form-group has-float-label col-12  col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fca-cbciclo" name="fca-cbciclo" placeholder="Ciclo" required >
                        <option value="0">Ciclo</option>
                        <?php foreach ($ciclos as $ciclo) {?>
                        <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-cbciclo"> Ciclo</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fca-cbturno" name="fca-cbturno" placeholder="Turno" required >
                        <option value="0">Turno</option>
                        <?php foreach ($turnos as $turno) {?>
                        <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-cbturno"> Turno</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fca-cbseccion" name="fca-cbseccion" placeholder="Sección" required >
                        <option value="0">Sección</option>
                        <?php foreach ($secciones as $seccion) {?>
                        <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fca-cbseccion"> Sección</label>
                    </div>
                    <div class="col-md-1 mb-2">
                      <input id="fca-checkgrupo" type="checkbox" data-toggle="toggle"
                      data-on="<i class='fa fa-check'></i>" data-off="<i class='fas fa-arrow-alt-circle-right'></i>"
                      data-onstyle="success" data-offstyle="danger">
                    </div>
                    <div class="col-12 col-md-3">
                      <button type="button" id="btn-vercurricula" class="btn btn-primary">
                      <i class="fas fa-eye"></i> Currícula
                      </button>
                    </div>
                    <div class="col-12 col-md-3">
                      Matrículas : <span id="vw_cg_spn_nmatriculas"></span>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div id="divcard_cursos" class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-plus mr-1"></i> Registro de carga académica por grupo</h3>
              </div>
              <div class="card-body">
                <b class="text-danger"></i> Selecciona el grupo</b>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    
  </section>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/dist/js/pages/grupo_carga_academica.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.bootstrap4.min.js"></script>-->
<script>
var vpermiso151 = '<?php echo getPermitido("151") ?>';
var vpermiso208 = '<?php echo getPermitido("208") ?>';
var vpermiso209 = '<?php echo getPermitido("209"); ?>';
var vpermiso212 = '<?php echo getPermitido("212"); ?>';
//var tb;
var btn_editdocente=null;
var vdocentes = <?php echo json_encode($docentes, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
var vpermiso128 = '<?php echo getPermitido("128"); ?>';
var vpermiso66 = '<?php echo getPermitido("66"); ?>';
var vpermiso67 = '<?php echo getPermitido("67"); ?>';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
})
$("#btn-vercurricula").hide();


$(document).ready(function() {
  $.fn.modal.Constructor.prototype._enforceFocus = function() {};

    $('#tbc_dtCargaAcademica').DataTable({
        "autoWidth": false,
        "pageLength": 50,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, 
            "className": "text-right rowhead",
            "width": "8px"
        }, {
            "targets": 6,
            "className": "text-center",
        }, {
            "targets": 7,
            "className": "text-center",
        }, {
            "targets": 8,
            "className": "text-center",
        }, {
            "targets": 9,
            "className": "text-center",
        }, {
            "targets": 10,
            "className": "text-center",
        }],
        "fnDrawCallback": function (oSettings) {
            $('.checkOpen').bootstrapToggle();
        }

    });
    $('.tbdatatableModal').DataTable({
        "autoWidth": false,
        "pageLength": 50,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, 
            "className": "text-right rowhead",
            "width": "8px"
        }]

    });
    $('#tbc_dtCargaAcademica_fusion').DataTable({
        "autoWidth": false,
        "pageLength": 50,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        'columnDefs': [{
            "targets": 0, 
            "className": "text-right rowhead",
            "width": "8px"
        }, {
            "targets": 6,
            "className": "text-center",
        }, {
            "targets": 7,
            "className": "text-center",
        }, {
            "targets": 8,
            "className": "text-center",
        }, {
            "targets": 9,
            "className": "text-center",
        }, {
            "targets": 10,
            "className": "text-center",
        }],

    });

    rowtablehor="";

    if (vpermiso209 == "SI") {
      rowtablehor="<'row'<'col-sm-6'B><'col-sm-6'f>>";
    } else {
      rowtablehor="<'row'<'col-sm-12'f>>";
    }

    $('#tbc_dtCargaHorario').DataTable({ 
        "autoWidth": false,
        "pageLength": 50,
        "lengthChange": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        dom: rowtablehor +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: {
            buttons: [{
                    text: '<i class="fas fa-plus"></i> Agregar',
                    className: 'btn-sm btn-success',
                    attr: {
                        'title': 'Agregar',
                        'id': 'divbtnadd_horario',
                        'onclick': 'fn_additem_horario($(this));return false;'
                    },
                    action: function(e, dt, node, config) {

                    },
                },
            ],
            dom: {
                button: {
                    className: 'btn'
                },
                buttonLiner: {
                    tag: null
                }
            }
        },
    });

    $("#vw_fcb_rowitem").hide();

});
$('.tbdatatable tbody').on('click', 'tr', function() {
    tabla = $(this).closest("table").DataTable();
    if ($(this).hasClass('selected')) {
        //Deseleccionar
        //$(this).removeClass('selected');
    } else {
        //Seleccionar
        tabla.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        //alert(tabla.table().node().id);
        if (tabla.table().node().id == "tbce_dtEstutiantesEnrolados") {
            tabla.button(1).enable(true);
        }
    }
});

$("#frmfiltro-carga_academica").submit(function(event) {
    //event.preventDefault()
    tbcarga = $('#tbc_dtCargaAcademica').DataTable();
    tbcarga.clear();
    $('#divcard-cargaAcademica').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_get_carga_subseccion_filtro',
        type: 'post',
        dataType: 'json',
        data: $("#frmfiltro-carga_academica").serialize(),
        success: function(e) {
            vhorarios = "";
            dropdown_opciones = "";
            vdeletesubseccion = "";
            vNotasFinalRecuperacion="";
            vEnrolarMiembros="";
            vNotasPorUnidad ="";

            $.each(e.vdata, function(index, carga) {
                btnCambiarNroSesiones="";
                if (carga['codcarga'] + "G" + carga['division']!=carga['codcarga_fusion'] + "G" + carga['division_fusion'] ){
                  unidad = carga['unidad'] + " (" + carga['codunidad'] + ") F";
                  unidad_principal = "<br>" + "<a href='#' onclick='vw_abrir_modal($(this));return false' data-tabula='evaluaciones'>" + carga['unidad_principal'] + " (" + carga['codunidad_principal'] + ") P" + "</a>";
                  fusionado = "SI";
                }
                else{
                  unidad = "<a href='#' onclick='vw_abrir_modal($(this));return false' data-tabula='evaluaciones'>" + carga['unidad'] + " (" + carga['codunidad'] + ")" + "</a>";

                  unidad_principal="";
                  fusionado = "NO";
                }
                nrosesiones=carga['sesiones_principal'];
                nrosesiones_avance=carga['avance_principal'];
                grupo = carga['periodo'] + " " + carga['sigla'] + " " + carga['turno'] + " " + carga['ciclo'] + " " + carga['codseccion'];
                docente = "<span class='spandocente'>" + carga['paterno'] + " " + carga['materno'] + " " + String(carga['nombres']).replace(/ .*/, '')  + "</span>";
                docente = docente + "<a onclick='vw_abrir_modal_cambiarDocente($(this));return false;' href='#' title='Cambiar docente'>" +
                          "<i class='fas fa-pen ml-2'></i>" +
                          "</a> "
                
                
                creditos = Number(carga['cred_teo']) + Number(carga['cred_pra']);
                horas = Number(carga['hsem_teo']) + Number(carga['hsem_pra']);
                codigo = (carga['carga_activo'] == "NO") ? "<del>" + carga['codcarga'] + "G" + carga['division'] + "</del>" : carga['codcarga'] + "G" + carga['division'];


                if (vpermiso67=="NO"){
                  visible = (carga['activo'] == "NO") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                }
                else{
                  checked= (carga['activo'] == "NO") ? "":"checked";
                  visible ="<span>" + 
                      "<input " + checked + " class='checkOcultar' data-size='xs' type='checkbox' data-toggle='toggle'" +
                      " data-on='<i class=\"far fa-eye\"></i>' data-off='<i class=\"far fa-eye-slash\"></i>' data-onstyle='success' data-offstyle='danger' >"  + 
                    "</span>";
                }

                if (vpermiso66=="NO"){
                   abierto = (carga['culminado'] == "SI") ? "<span class='d-inline-block text-white tboton bg-danger'>" + "NO" + "</span>" : "<span class='d-inline-block text-white tboton bg-success'>" + "SI" + "</span>";
                }
                else{
                  if (carga['codcarga'] == carga['codcarga_fusion']) {
                    checked= (carga['culminado'] == "SI") ? "":"checked";
                    abierto ="<span>" + 
                        "<input " + checked + " onchange='fn_abrir_cerrar_curso($(this));return false;' class='checkOpen' data-size='xs' type='checkbox' data-toggle='toggle'" +
                        " data-on='<i class=\"far fa-folder-open\"></i>' data-off='<i class=\"far fa-folder\"></i>' data-onstyle='success' data-offstyle='danger' >"  + 
                      "</span>";
                  } else {
                    abierto = (carga['culminado'] == "SI") ? "<span class='d-inline-block text-white tboton bg-danger'>" + "NO " + "<i class='fas fa-fist-raised'></i></span>" : "<span class='d-inline-block text-white tboton bg-success'>" + "SI " + "<i class='fas fa-fist-raised'></i></span>";
                  }
                }

                if (vpermiso208 == "SI") {
                  vhorarios = "<a class='text-center d-inline-block bg-success py-1 px-2 rounded' href='#' title='Horario' data-nunidad='"+carga['unidad_principal']+"' data-codturno='"+carga['codturno']+"' onclick='vw_abrir_horarios_modal($(this));return false;'><i class='fas fa-calendar-alt'></i></a>";
                }

                //abierto = (carga['culminado'] == "SI") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                
                enrolados = "<a href='#' onclick='vw_abrir_modal($(this));return false' data-tabula='evaluaciones'>" + carga['enrolados'] + "</a>";
                /*dropdown = '<div class="btn-group">' +
                    '<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cog"></i> </button>' +
                    '<div class="dropdown-menu">' +
                    '<a onclick="vw_abrir_modal($(this));return false" class="dropdown-item" data-tabula="evaluaciones" href="#">Evaluaciones</a>' +
                    '</div>' +
                    '</div>';*/
                if (vpermiso212 == "SI") {
                  vdeletesubseccion = '<a href="#" class="dropdown-item text-danger" data-grupo="'+carga['division']+'" data-carga="'+carga['codcarga']+'" onclick="fn_eliminadivision($(this));return false;"><i class="fas fa-trash-alt mr-2"></i>Eliminar División</a>';
                }
                if (vpermiso128 == "SI") {
                  vNotasFinalRecuperacion = '<a href="#" class="dropdown-item" onclick="fn_modGuardarNotas($(this));return false;"><i class="fas fa-sort-numeric-up-alt mr-2"></i>Notas Finales</a>';
                }
                if (vpermiso128 == "SI") {
                  vEnrolarMiembros = '<a href="' + base_url + 'gestion/academico/carga-academica/miembros/enrolar/' + carga['codcarga64'] + '/' + carga['division64'] + '" target="_blank" class="dropdown-item" "><i class="fas fa-user-friends mr-2"></i>Enrolar</a>';
                  vNotasPorUnidad = '<a href="' + base_url + 'curso/evaluaciones/' + carga['codcarga64'] + '/' + carga['division64'] + '" target="_blank" class="dropdown-item" "><i class="fas fa-user-friends mr-2"></i>Notas por Unidad</a>';
                }
                
                dropdown_opciones='<div class="btn-group btn-group-sm p-0 dropleft">' +
                  '<button class="btn btn-warning btn-sm dropdown-toggle py-0 rounded" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                  '<i class="fas fa-cog"></i>' +
                  '</button>' +
                  '<div class="dropdown-menu">' +
                    vdeletesubseccion +
                    vNotasFinalRecuperacion + 

                    vEnrolarMiembros + 
                    vNotasPorUnidad
                  '</div>' +
                '</div>' ;
                fusion=(carga['codcarga'] + "G" + carga['division']==carga['codcarga_fusion'] + "G" + carga['division_fusion'] ) ? "": carga['codcarga_fusion'] + "G" + carga['division_fusion'];
                fusion='<a class="btn btn-info btn-sm py-0" href="#" onclick="vw_abrir_modal_fusion($(this));return false" data-fusionado="'+fusionado+'"><i class="fas fa-fist-raised mr-1"></i>' + fusion + '</a>';
                if (fusionado=="NO"){
                  btnCambiarNroSesiones='<a  href="#" onclick="vw_abrir_modal_cambiarNroSesiones($(this));return false" title="Cambiar Nro de Reuniones"><i class="fas fa-pencil-alt ml-1"></i></a>';
                }
                nroSesionesText="<span>" + nrosesiones_avance + '/' + "<span class='spnNroSesiones'>" + nrosesiones + "</span> " + btnCambiarNroSesiones + '</span>';
                var fila = tbcarga.row.add([index + 1, carga['sede_abrevia'], codigo, carga['plan'], grupo, unidad + unidad_principal,nroSesionesText, abierto, creditos, horas, "<b>" + enrolados + "</b>", docente, fusion, vhorarios, dropdown_opciones]).node();
                $(fila).attr('data-codcarga64', carga['codcarga64']);
                $(fila).attr('data-division64', carga['division64']);
                $(fila).attr('data-codcargafusion64', carga['codcarga_fusion64']);
                $(fila).attr('data-divisionfusion64', carga['division_fusion64']);
                $(fila).attr('data-coddocente', carga['coddocente64']);
                $(fila).attr('data-unidad', unidad);
                $(fila).attr('data-codunidad', carga['codunidad']);
                $(fila).attr('data-culminado', carga['culminado']);
                $(fila).addClass("fdivision");
                $(fila).attr('data-nameund', carga['unidad'] + "("+codigo+")");
                $(fila).attr('data-namegroup', grupo);
                $(fila).attr('data-namestudent', carga['enrolados']);


            });

            tbcarga.draw();
            $('.checkOcultar').bootstrapToggle();
            $('.checkOpen').bootstrapToggle();
            $('#divcard-cargaAcademica #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            $('#divcard-cargaAcademica #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
});
function vw_abrir_modal_cambiarNroSesiones(boton){
  fila=boton.closest(".fdivision");
  if (fila.data('culminado')=="SI"){
    Swal.fire({
        icon: 'error',
        title: 'ERROR, NO se puede realizar cambio',
        text: "No se puede realizar cambios si la U.D. se encuentra cerrada",
        backdrop:false,
    });
    return false;
  }
  Swal.fire({
    title: "¿Cuantas reuniones tiene esta U.D. durante el semestre?",
    input: "text",
    inputAttributes: {
      autocapitalize: "off"
    },
    showCancelButton: true,
    confirmButtonText: "Guardar",
    showLoaderOnConfirm: true
  }).then((result) => {
      if (result.value) {
        if(!isNaN(result.value) && (result.value>0)){
          
          var idcurso=fila.data('codcargafusion64');
          var vdivision=fila.data('divisionfusion64');
          var nrses=result.value;
          $('#divboxevaluaciones').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          var acto=  base_url + 'curso/f_updatenrosesiones';
          $.ajax({
              url: acto,
              type: 'post',
              dataType: 'json',
              data: {
                  idcarga: idcurso,nrosesiones: nrses, division:vdivision
              },
              success: function(e) {
                  $('#divboxevaluaciones #divoverlay').remove();
                  if (e.status == false) {
                      
                       Swal.fire({
                          icon: 'error',
                          title: 'ERROR, NO se pudo guardar los cambios',
                          text: e.msg,
                          backdrop:false,
                      });
                  } else {
                       Swal.fire({
                          icon: 'success',
                          title: 'ÉXITO, Se guardó cambios',
                          text: "Lo cambios fueron guardados correctamente",
                          backdrop:false,
                      });
                       fila.find(".spnNroSesiones").html(nrses);
                      //setTimeout(function(){ window.location.href = e.redirect; }, 2000);

                  }
              },
              error: function(jqXHR, exception) {
                  $('#divboxevaluaciones #divoverlay').remove();
                  var msgf = errorAjax(jqXHR, exception,'text');
                  Swal.fire({
                          icon: 'error',
                          title: 'ERROR, NO se pudo guardar los cambios',
                          text: msgf,
                          backdrop:false,
                  });
              },
          });
        }
        else{
          Swal.fire({
                  icon: 'error',
                  title: 'ERROR, Debes ingresar un número',
                  text: "El valor ingresado debe ser un número mayor a CERO",
                  backdrop:false,
          });
        }

        return false;

      }
  });
}
$("#frmfiltro-carga_academica_fusion").submit(function(event) {
    //event.preventDefault()
    tbcarga = $('#tbc_dtCargaAcademica_fusion').DataTable();
    tbcarga.clear();
    $('#modFusionar .modFusionar_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_get_carga_subseccion_filtro',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            nrogrp = 0;
            $.each(e.vdata, function(index, carga) {

              if ((carga['codcarga'] === carga['codcarga_fusion']) && (carga['division'] === carga['division_fusion'])) {
                nrogrp++;
                grupo = carga['periodo'] + " " + carga['sigla'] + " " + carga['turno'] + " " + carga['ciclo'] + " " + carga['codseccion'];
                docente = carga['paterno'] + " " + carga['materno'] + " " + String(carga['nombres']).replace(/ .*/, '');
                unidad = carga['unidad'] + " (" + carga['codunidad'] + ")";
                creditos = Number(carga['cred_teo']) + Number(carga['cred_pra']);
                horas = Number(carga['hsem_teo']) + Number(carga['hsem_pra']);
                codigo = (carga['carga_activo'] == "NO") ? "<del>" + carga['codcarga'] + "G" + carga['division'] + "</del>" : carga['codcarga'] + "G" + carga['division'];
                codigo ='<button class="btn btn-info btn-sm py-0" onclick="fn_fusionar($(this));return false"><i class="fas fa-fist-raised mr-1"></i>' + codigo +'</button>';
                abierto = (carga['culminado'] == "SI") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                visible = (carga['ACTIVO'] == "NO") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";;
                enrolados =  carga['enrolados'];
                
                var fila = tbcarga.row.add([nrogrp, carga['sede_abrevia'], codigo, carga['plan'], grupo,"<b>" + unidad + "</b>" , abierto, visible, creditos, horas, "<b>" + enrolados + "</b>", docente]).node();
                $(fila).attr('data-codcarga64', carga['codcarga64']);
                $(fila).attr('data-division64', carga['division64']);
              }

            });
            tbcarga.draw();
            $('#modFusionar .modFusionar_content #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            $('#modFusionar .modFusionar_content #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
});
/*function vw_md_enrolar(boton){
fila=boton.closest('tr');
codcarga64=fila.data('codcarga64');
division64=fila.data('division64');
$("#vw_cme_txtcodcarga").val(codcarga64);
$("#vw_cme_txtcoddivision").val(division64);

$("#modEnrolados").modal("show");
tbmiembros=$('#tbce_dtEstutiantesEnrolados').DataTable();
tbmiembros.clear();
tbmiembros.button(1).enable(false);
$('#modEnrolados .modEnrolados_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
$.ajax({
url: base_url + 'miembros/fn_get_miembros_x_carga_division',
type: 'post',
dataType: 'json',
data: {
codcarga: codcarga64,
division: division64
} ,
success: function(e) {

$.each(e.vmiembros, function(index, miembro) {
grupo=miembro['sigla'] + " " + miembro['codturno'] + " " + miembro['ciclo'] + " " + miembro['codseccion'] ;
sexo=(miembro['sexo']=="FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
estudiante= miembro['paterno'] + " " + miembro['materno'] + " " + miembro['nombres'];


//visible=(miembro['ACTIVO']=="NO") ? "<span class='badge badge-danger'>" + "NO" + "</span>":"<span class='badge badge-success'>" + "SI" + "</span>";;
eliminar="<a href='#' onclick='fn_desenrolar($(this))'><i class='fas fa-trash-alt text-danger'></i></a>";
var fila=tbmiembros.row.add([index + 1,miembro['sede_abrevia'],miembro['carnet'],sexo + estudiante,grupo,eliminar]).node();
$(fila).attr('data-idmiembro64',miembro['idmiembro64'] );
$(fila).attr('data-estudiante',estudiante);
//$(fila).attr('data-division64',miembro['division64'] );
});
tbmiembros.draw();
$('#modEnrolados .modEnrolados_content #divoverlay').remove();
},
error: function(jqXHR, exception) {
$('#modEnrolados .modEnrolados_content #divoverlay').remove();
var msgf = errorAjax(jqXHR, exception,'text');
Swal.fire({
type: 'error',
title: 'ERROR, NO se guardó cambios',
text: msgf,
backdrop:false,
});
},
});
return false;
}*/
function vw_abrir_modal(boton) {
    fila = boton.closest('tr');
    codcarga64 = fila.data('codcarga64');
    division64 = fila.data('division64');
    $("#vw_cme_txtcodcarga").val(codcarga64);
    $("#vw_cme_txtcoddivision").val(division64);

    
    //if (boton.data('tabula')=="evaluaciones"){
    vw_md_evaluaciones();
    $("#modEnrolados").modal("show");
    //}
    return false;
}
function vw_abrir_modal_fusion(boton) {
  
    fila = boton.closest('.fdivision');
    codcarga64 = fila.data('codcarga64');
    division64 = fila.data('division64');
    unidad = fila.data('nameund');
    grupo = fila.data('namegroup');
    enrolados = fila.data('namestudent');
    fusionado = boton.data('fusionado');
    codcarga64fusion = fila.data('codcargafusion64');
    division64fusion = fila.data('divisionfusion64');
    $('#text_unidad_did').html(unidad+" /");
    $('#textgroup').html("<b class='mr-2'>("+grupo+") /</b><b class='text-primary'><i class='fas fa-user-friends'></i>("+enrolados+")</b>");

    $("#vw_mdfs_txtcodcarga").val(codcarga64);
    $("#vw_mdfs_txtdivision").val(division64);

    $("#modFusionar").modal("show");

    if (fusionado == "SI") {
      $('#frmfiltro-carga_academica_fusion').hide();
      fn_get_carga_fusionados(codcarga64fusion,division64fusion);
    } else {
      $('#frmfiltro-carga_academica_fusion').show();
    }
    //if (boton.data('tabula')=="evaluaciones"){
    //vw_md_evaluaciones();
    //}
    return false;
}

function fn_get_carga_fusionados(carga,division) {
    tbcarga = $('#tbc_dtCargaAcademica_fusion').DataTable();
    tbcarga.clear();
    codcarga64 = $("#vw_mdfs_txtcodcarga").val();
    division64 = $("#vw_mdfs_txtdivision").val();
    $('#modFusionar .modFusionar_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_get_carga_subseccion_fusionado',
        type: 'post',
        dataType: 'json',
        data: {
          'fmt-cbcarga':carga,
          'fmt-cbdivision':division
        },
        success: function(e) {
            nrogrp = 0;
            // $.each(e.vdata, function(index, carga) {

              // if ((carga['codcarga'] === carga['codcarga_fusion']) && (carga['division'] === carga['division_fusion'])) {
                nrogrp++;
                grupo = e.vdata['periodo'] + " " + e.vdata['sigla'] + " " + e.vdata['turno'] + " " + e.vdata['ciclo'] + " " + e.vdata['codseccion'];
                docente = e.vdata['paterno'] + " " + e.vdata['materno'] + " " + String(e.vdata['nombres']).replace(/ .*/, '');
                unidad = e.vdata['unidad'] + " (" + e.vdata['codunidad'] + ")";
                creditos = Number(e.vdata['cred_teo']) + Number(e.vdata['cred_pra']);
                horas = Number(e.vdata['hsem_teo']) + Number(e.vdata['hsem_pra']);
                codigocarga = (e.vdata['carga_activo'] == "NO") ? "<del>" + e.vdata['codcarga'] + "G" + e.vdata['division'] + "</del>" : e.vdata['codcarga'] + "G" + e.vdata['division'];
                codigo ='<button class="btn btn-info btn-sm py-0" onclick="fn_fusionar($(this));return false" data-separar="SI"><i class="fas fa-fist-raised mr-1"></i> Separar '+ codigocarga +'</button>';
                abierto = (e.vdata['culminado'] == "SI") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                visible = (e.vdata['ACTIVO'] == "NO") ? "<span class='badge badge-danger'>" + "NO" + "</span>" : "<span class='badge badge-success'>" + "SI" + "</span>";
                enrolados =  e.vdata['enrolados'];
                
                var fila = tbcarga.row.add([nrogrp, e.vdata['sede_abrevia'], codigo, e.vdata['plan'], grupo,"<b>" + unidad + "</b>" , abierto, visible, creditos, horas, "<b>" + enrolados + "</b>", docente]).node();
                $(fila).attr('data-codcarga64', codcarga64);
                $(fila).attr('data-division64', division64);
                $(fila).attr('data-docente64', e.vdata['coddocente64']);
              // }

            // });
            tbcarga.draw();
            $('#modFusionar .modFusionar_content #divoverlay').remove();
        },
        error: function(jqXHR, exception) {
            $('#modFusionar .modFusionar_content #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se encontraron datos',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
}

function vw_abrir_modal_cambiarCargaDivision(boton) {
  
    fila = boton.closest('.fdivision');
    estudiante = fila.data('estudiante');
    /*codcarga64 = fila.data('codcarga64');
    division64 = fila.data('coddivision');
    $("#vw_mdfs_txtcodcarga").val(codcarga64);
    $("#vw_mdfs_txtdivision").val(division64);*/
    $("#vw_md_ccd_spnestudiante").html(estudiante);
    $("#modCambiarCargaDivision").modal("show");
    //if (boton.data('tabula')=="evaluaciones"){
    //vw_md_evaluaciones();
    //}
    return false;
}

function vw_abrir_modal_cambiarDocente(boton) {
    fila=boton.closest(".fdivision");
    btn_editdocente=boton;
    var vgrupo=fila.data('division64');
    var vcarga=fila.data('codcarga64');
    var vunidad=fila.data('unidad');

    $("#vw_md_doc_txtcarga").val(vcarga);
    $("#vw_md_doc_txtdivision").val(vgrupo);
    $("#vw_md_doc_div_unidad").html(vunidad);
    $("#md_docentes").modal("show");
    docactual=fila.data('coddocente');
    if (docactual=="") docactual="00000";
    $("#vw_md_doc_docentes").val(docactual);
    
};


$('#modEnrolados').on('hidden.bs.modal', function (e) {

  
  tbestudiantesAsistencias = $('#tbce_dtEstudiantesAsistencia').DataTable();
  tbestudiantesAsistencias.clear();
  tbestudiantesAsistencias.destroy(false);

  tbestudiantesEvaluaciones = $('#tbce_dtEstutiantesEvaluaciones').DataTable();
  tbestudiantesEvaluaciones.clear();
  tbestudiantesEvaluaciones.destroy(false);


  tbenrolados = $('#tbce_dtEstutiantesEnrolados').DataTable();
  tbenrolados.clear();

  tbreuniones = $('#tbce_dtReuniones').DataTable();
  tbreuniones.clear();
  

  
})
function vw_md_evaluaciones() {

    codcarga64 = $("#vw_cme_txtcodcarga").val();
    division64 = $("#vw_cme_txtcoddivision").val();

    
    //tbevaluaciones.button(1).enable(false);
    $('#md_enrolados-tab').tab('show');
    $('#modEnrolados .modEnrolados_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_get_carga_subseccion_datos_completos',
        type: 'post',
        dataType: 'json',
        data: {
            codcarga: codcarga64,
            division: division64
        },
        success: function(e) {
            $('#modEnrolados .modEnrolados_content #divoverlay').remove();
            $("#modEnrolados .modal-title").html(e.vcurso['unidad']);
            $("#vw_cme_spnDocente").html(e.vcurso['paterno'] + " " + e.vcurso['materno'] + " " + e.vcurso['nombres']);
            $("#vw_cme_spnPeriodo").html(e.vcurso['periodo']);
            $("#vw_cme_spnPrograma").html(e.vcurso['carrera']);
            $("#vw_cme_spnSemestre").html(e.vcurso['ciclo']);
            $("#vw_cme_spnTurno").html(e.vcurso['turno']);
            $("#vw_cme_spnSeccion").html(e.vcurso['codseccion']);
            $("#vw_cme_spnDivision").html(e.vcurso['division']);
            $("#vw_cme_spnMetodo").html(e.vcurso['metodo']);
            $("#vw_cme_spnReuniones_actual").html(e.vcurso['avance_principal']);
            $("#vw_cme_spnReuniones_total").html(e.vcurso['sesiones_principal']);
            
            filaDivision=$("#modEnrolados").find(".fdivision");
            filaDivision.data("culminado",e.vcurso['culminado']);
            filaDivision.data("codcargafusion64",codcarga64);
            filaDivision.data("divisionfusion64",division64);

            
            vstatus=(e.vcurso['culminado'] == "SI") ? "<span class='badge badge-success p-1'>ABIERTO</span>":"<span class='badge badge-danger'>CULMINADO</span>";
            $("#vw_cme_divEstado").html(vstatus);

            var thindicadores = "";
            var thhead = "";
            nroColNota=8
            nroColsNota=[];
            nroColsNotaPU=[];
            nroColsNotaFI=[];
            nroColsVacio =[];
            nroColsGenerales=[0,1,2,3,4,5,6,7];
            $.each(e.vindicadores, function(index, indicador) {
                colspan = 0;

                $.each(e.vhead, function(index, head) {
                    if (head['indicador'] == indicador['codigo']) {
                        colspan++;
                        if (head['abrevia']=="PU"){
                          nroColsNotaPU.push(nroColNota++);
                        }  
                        else{
                          nroColsNota.push(nroColNota++);
                        }                     
                        thhead = thhead + "<th>" + head['abrevia'] + "</th>"
                    }
                });
                if (colspan == 0) colspan = 1;
                thindicadores = thindicadores + "<th colspan='" + colspan + "'>" + indicador['nombre'] + "</th>";
            });
            var headGeneraltbestudiantesEvaluaciones = '<tr class="bg-lightgray ">' +
                '<th rowspan="2">N°</th>' +
                '<th rowspan="2">Filial</th>' +
                '<th rowspan="2">Carné</th>' +
                '<th rowspan="2">Estudiante</th>' +
                '<th rowspan="2">Grupo</th>' +
                '<th rowspan="2">Estado</th>' +
                '<th rowspan="2">Cogs</th>' +
                '<th rowspan="2">F(%)</th>' +
                thindicadores +
                '<th rowspan="2"></th>' +
                '<th rowspan="2">NF</th>' +
                '<th rowspan="2">RC</th>' +
                '<th rowspan="2">PF</th>' +
                '</tr>' +
                '<tr class="bg-lightgray">' +
                thhead +

                '</tr>';
                nroColsVacio.push(nroColNota++)
                nroColsNotaFI.push(nroColNota++);
                nroColsNotaFI.push(nroColNota++);
                nroColsNotaFI.push(nroColNota++);
                
            var headFechas="";
            //tbce_dtReuniones
            tbreuniones = $('#tbce_dtReuniones').DataTable();
            tbreuniones.clear();
            tbestudiantesMiembros = $('#tbce_dtEstutiantesEnrolados').DataTable();
            tbestudiantesMiembros.clear();

            
            $.each(e.vheadFechas, function(index, reunion) {
              vfecha=formatDDMMYY(reunion['fecha'],".");
              //
              vlink=(reunion['linkf'] ==null)?"":'<a class="badge badge-primary"  href="' + reunion['linkf'] + '">Meet</a>';
              var filaReunion_new = [
                    index + 1,
                    vfecha,
                    "R" + ('0' + reunion['nrosesion']).slice(-2),
                    reunion['detalle'],
                    reunion['hini'],
                    reunion['hfin'],
                    reunion['tipo'],
                    vlink
                    

                ];
              var fila_enr = tbreuniones.row.add(filaReunion_new).node();
              headFechas=headFechas + "<th class='pl-0 pr-0 py-1 text-xs'><span class='rotar'>" + vfecha + "</span></th>";
            });

            var headGeneraltbestudiantesAsistencias = '<tr class="bg-lightgray ">' +
                '<th>N°</th>' +
                '<th>Filial</th>' +
                '<th>Carné</th>' +
                '<th>Estudiante</th>' +
                '<th>Grupo</th>' +
                '<th>Estado</th>' +
                '<th>Cogs</th>' +
                '<th>F(%)</th>' +
                  headFechas +
                '</tr>';

            $('#tbce_dtEstudiantesAsistencia thead').html(headGeneraltbestudiantesAsistencias);
            $('#tbce_dtEstutiantesEvaluaciones thead').html(headGeneraltbestudiantesEvaluaciones);
            
            $('#tbce_dtEstudiantesAsistencia').DataTable({
                "autoWidth": false,
                "pageLength": 50,
                "lengthChange": false,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                },
                'columnDefs': [{
                    "targets": 0, 
                    "className": "text-right rowhead",
                    "width": "8px"
                }]

            });

            $('#tbce_dtEstutiantesEvaluaciones').DataTable({
                "autoWidth": false,
                "pageLength": 50,
                "lengthChange": false,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                },
                'columnDefs': [{
                    "targets": 0, 
                    "className": "text-right rowhead",
                    "width": "8px"
                  },
                  {
                      "targets": nroColsGenerales,
                      "createdCell": function (td, cellData, rowData, row, col) {
                        ultimaCol=rowData.length - 4;
                        if (rowData[ultimaCol]=="SI"){
                          $(td).addClass("text-danger");
                        }
                      }
                  },
                  {
                      "targets": nroColsNota, 
                      "className": "text-center",
                      "width": "11px"
                  },
                  {
                      "targets": nroColsNotaPU, 
                      "className": "text-center text-bold border border-success",
                      "width": "11px"
                  },
                  {
                      "targets": nroColsNotaFI, 
                      "className": "text-center text-bold border border-danger",
                      "width": "11px"
                  },
                  {
                      "targets": nroColsVacio, 
                       visible:false,
                      searchable: false
                  }
                ]
            });

            tbestudiantesAsistencias = $('#tbce_dtEstudiantesAsistencia').DataTable();
            tbestudiantesAsistencias.clear();
            tbestudiantesEvaluaciones = $('#tbce_dtEstutiantesEvaluaciones').DataTable();
            tbestudiantesEvaluaciones.clear();
            $.each(e.vmiembros, function(index, miembro) {
                //////////////
                //TBEVALUACIONES
                //////////////
                sexo = (miembro['sexo'] == "FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
                estudiante = miembro['paterno'] + " " + miembro['materno'] + " " + miembro['nombres'] ;
                datos_miembro = e.valumno[miembro['idmiembro']];

                
               
                grupo = miembro['sigla'] + "-" + miembro['codturno'] + "-" + miembro['ciclo'] + "-" + miembro['codseccion'];
                
                cambiarCarga = "<a href='#' class='mx-1' onclick='vw_abrir_modal_cambiarCargaDivision($(this));return false;'><i class='fas fa-cog'></i></a>";
                eliminar = "<a href='#' onclick='fn_desenrolar($(this))'><i class='fas fa-trash-alt text-danger'></i></a>";

                
                porcentajeFaltas=Math.round(datos_miembro['asis']['faltas'] / e.vcurso['sesiones_principal'] * 100);
                porcentajeFaltasTexto="";
                colorTexto="";
                colorFondo="";
                isDPI="NO";
                if(porcentajeFaltas>=30){
                  porcentajeFaltasTexto= porcentajeFaltas + "%" + " DPI";
                  colorTexto="text-danger";
                  colorFondo="bg-danger";
                  isDPI="SI";
                }
                else{
                  porcentajeFaltasTexto=porcentajeFaltas + "%";
                }
                var arrayGenerico_new = [
                     (index + 1) ,
                     miembro['sede_abrevia'] ,
                     miembro['carnet'] ,
                    "<span title='" + miembro['idmiembro'] + "'>"  + sexo + estudiante + "</span>",
                      grupo ,
                    "<span class='px-1 " + colorFondo + "'>"  + miembro['estado'] + "</span>",
                    cambiarCarga + eliminar,
                    "<span class='px-1 " + colorFondo + "'>"  + porcentajeFaltasTexto + "</span>"
                    
                ];


                var arrayAsistencias_new=structuredClone(arrayGenerico_new);
                var arrayEvaluaciones_new=structuredClone(arrayGenerico_new);

                var filaMiembros_new = tbestudiantesMiembros.row.add(arrayGenerico_new).node();
                $(filaMiembros_new).addClass(colorTexto);
                $(filaMiembros_new).addClass("cfila");
                $(filaMiembros_new).attr('data-idmiembro64', miembro['idmiembro64']);
                $(filaMiembros_new).attr('data-estudiante', estudiante);



                $.each(e.vheadFechas, function(index, fecha) {
                  arrayAsistencias_new.push(datos_miembro['asis'][fecha['id']]);
                });
                var filaAsistencias_new = tbestudiantesAsistencias.row.add(arrayAsistencias_new).node();
                $(filaAsistencias_new).attr('data-idmiembro64', miembro['idmiembro64']);
                $(filaAsistencias_new).addClass(colorTexto);
                $(filaAsistencias_new).attr('data-estudiante', estudiante);

                $.each(e.vindicadores, function(index, indicador) {
                    $.each(e.vhead, function(index, head) {
                        if (head['indicador'] == indicador['codigo']) {
                            var nota=datos_miembro['eval'][indicador['codigo']][head['nombre_calculo']]['nota'];
                            var colorNota=(nota>=13)?"text-primary":"text-danger";
                            //esPU=(head['abrevia']=="PU")?"text-bold": "";
                            arrayEvaluaciones_new.push("<span class='text-center " + colorNota + "'>" + nota + "</span>");
                        }
                    });
                });
                arrayEvaluaciones_new.push(isDPI);
                notapi=datos_miembro['eval']['PI']['nota'];
                colorNota=(notapi>=13)?"text-primary":"text-danger";
                arrayEvaluaciones_new.push("<span class='text-center " + colorNota + "'>" + notapi + "</span>");
                notarc=datos_miembro['eval']['RC']['nota'];
                if (notarc==null) notarc="";
                colorNota=(notarc>=13)?"text-primary":"text-danger";
                arrayEvaluaciones_new.push("<span class='text-center " + colorNota + "'>" + notarc + "</span>");
                notapf=datos_miembro['eval']['PF']['nota'];
                colorNota=(notapf>=13)?"text-primary":"text-danger";
                arrayEvaluaciones_new.push("<span class='text-center " + colorNota + "'>" + notapf + "</span>");

                
                var filaEvaluaciones_new = tbestudiantesEvaluaciones.row.add(arrayEvaluaciones_new).node();
                $(filaEvaluaciones_new).attr('data-idmiembro64', miembro['idmiembro64']);
                $(filaEvaluaciones_new).attr('data-estudiante', estudiante);

            });
            tbestudiantesEvaluaciones.column(1).visible( false, false );
            tbestudiantesEvaluaciones.column(2).visible( false, false );
            tbestudiantesEvaluaciones.column(4).visible( false, false );
            tbestudiantesEvaluaciones.column(5).visible( false, false );
            tbestudiantesEvaluaciones.column(6).visible( false, false );

            tbestudiantesAsistencias.column(1).visible( false, false );
            tbestudiantesAsistencias.column(2).visible( false, false );
            tbestudiantesAsistencias.column(4).visible( false, false );
            tbestudiantesAsistencias.column(5).visible( false, false );
            tbestudiantesAsistencias.column(6).visible( false, false );


            tbestudiantesAsistencias.draw();
            tbestudiantesEvaluaciones.draw();
            tbreuniones.draw();
            tbestudiantesMiembros.draw();

        },
        error: function(jqXHR, exception) {
            $('#modEnrolados .modEnrolados_content #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
}

function fn_desenrolar(boton) {
    $('#modEnrolados .modEnrolados_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    tbmiembros = $('#tbce_dtEstutiantesEnrolados').DataTable();
    //fila = tbmiembros.$('tr.selected');
    fila=boton.closest('tr');
    idmiembro64 = fila.data('idmiembro64');

    alumno = fila.data('estudiante');
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Se eliminarán las notas y asistencias del estudiante " + alumno + ", registradas en esta unidad didáctica ",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "miembros/fn_eliminar",
                type: 'post',
                dataType: 'json',
                data: {
                    "fm-idmiembro": idmiembro64
                },
                success: function(e) {
                    $('#modEnrolados .modEnrolados_content #divoverlay').remove();
                    if (e.status == true) {
                        fila.remove();
                        //tbmiembros.draw
                        $('#divcard-matricular #divoverlay').remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito,  realizado',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error, NO se pudo realizar la eliminación',
                            text: e.msg,
                            backdrop: false,
                        })
                    }
                },
                error: function(jqXHR, exception) {
                    $('#modEnrolados .modEnrolados_content #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error, NO se pudo realizar la eliminación',
                        text: e.msgf,
                        backdrop: false,
                    })
                }
            })
        } else {
            $('#modEnrolados .modEnrolados_content #divoverlay').remove();
        }
    });
};

function fn_fusionar(boton) {
   $('#modFusionar .modFusionar_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    tbmiembros = $('#tbc_dtCargaAcademica_fusion').DataTable();
    //fila = tbmiembros.$('tr.selected');
    fila=boton.closest('tr');
    codcarga64_fusion=fila.data('codcarga64');
    division64_fusion=fila.data('division64');
    codcarga64_original=$('#vw_mdfs_txtcodcarga').val();
    division64_original=$('#vw_mdfs_txtdivision').val();
    codigodocente = fila.data('docente64');
    if (codigodocente) {
      fsepare = "SI";
      textfusion = "separar";
    } else {
      fsepare = "NO";
      textfusion = "fusionar";
    }


    carga = fila.data('estudiante');
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Estas seguro de "+textfusion+" las aulas? ",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, '+textfusion+'!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "cargasubseccion/fn_fusionar",
                type: 'post',
                dataType: 'json',
                data: {
                    "fs-codcarga64_fusion" : codcarga64_fusion,
                    "fs-division64_fusion" : division64_fusion,
                    "fs-codcarga64_original" : codcarga64_original,
                    "fs-division64_original" : division64_original,
                    "fs-fsepare" : fsepare,
                },
                success: function(e) {
                    $('#modFusionar .modFusionar_content #divoverlay').remove();
                    if (e.status == true) {
                        fila.remove();
                        //tbmiembros.draw
                        $('#divcard-matricular #divoverlay').remove();
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Éxito,  realizado',
                            text: e.msg,
                            backdrop: false,
                        })
                        $("#frmfiltro-carga_academica").submit();
                        $("#modFusionar").modal("hide");
                    } else {
                        $('#modFusionar .modFusionar_content #divoverlay').remove();
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'Error, NO se pudo realizar la eliminación',
                            text: e.msg,
                            backdrop: false,
                        })
                    }
                },
                error: function(jqXHR, exception) {
                    $('#modFusionar .modFusionar_content #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error, NO se pudo realizar la eliminación',
                        text: e.msgf,
                        backdrop: false,
                    })
                }
            })
        } else {
            $('#modFusionar .modFusionar_content #divoverlay').remove();
        }
    });
};
$('#modFusionar').on('hidden.bs.modal', function(e) {
  // tbcarga = $('#tbc_dtCargaAcademica_fusion').DataTable();
  // tbcarga.clear();
  // tbcarga.draw();

  $('#text_unidad_did').html("");
  $('#textgroup').html("");
})
/*$('#myModal').on('hidden.bs.modal', function (e) {

})*/
function fn_asignar_metodo(boton) {
    fila = boton.closest('.cfila');
    codmetodo64 = fila.data('codmetodo64');
    metodo = fila.data('metodo');
    codcarga64 = $("#vw_cme_txtcodcarga").val();
    division64 = $("#vw_cme_txtcoddivision").val();
    $('#modCambiarCalculo .modcambiarCalculo_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'cargasubseccion/fn_cambiar_metodo_calculo',
        type: 'post',
        dataType: 'json',
        data: {
            "codcarga": codcarga64,
            "division": division64,
            "metodo": codmetodo64,
        },
        success: function(e) {
            $('#modCambiarCalculo .modcambiarCalculo_content #divoverlay').remove();
            if (e.status == true) {
                $("#modCambiarCalculo").modal("hide");
                $("#vw_cme_spnMetodo").html(metodo);
            }
        },
        error: function(jqXHR, exception) {
            $('#modCambiarCalculo .modcambiarCalculo_content #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
}


function fn_miembro_update_CargaDivision(btn) {

  tbmiembros = $('#tbce_dtEstutiantesEnrolados').DataTable();
  fila = tbmiembros.$('tr.selected');
    //fila=boton.closest('tr');
  idmiembro64 = fila.data('idmiembro64');

  alumno = fila.data('estudiante');



  //vw_md_ccd_btguardar

    codcarga = $("#vw_md_ccd_txtcarga").val();
    division = $("#vw_md_ccd_txtdivision").val();
    $('#modCambiarCargaDivision .modCambiarCargaDivision_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'miembros/fn_update_carga_division',
        type: 'post',
        dataType: 'json',
        data: {
            "fm-codcarga": codcarga,
            "fm-division": division,
            "fm-idmiembro": idmiembro64,
        },
        success: function(e) {
            $('#modCambiarCargaDivision .modCambiarCargaDivision_content #divoverlay').remove();
            if (e.status == true) {
                 fila.remove();
                  $("#modCambiarCargaDivision").modal("hide");
            }
        },
        error: function(jqXHR, exception) {
            $('#modCambiarCargaDivision .modCambiarCargaDivision_content #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
            Swal.fire({
                type: 'error',
                title: 'ERROR, NO se guardó cambios',
                text: msgf,
                backdrop: false,
            });
        },
    });
    return false;
}


$("#vw_md_doc_guardar").click(function(event) {
    $('#divcontent_docentes').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var docsel=$("#vw_md_doc_docentes").val();
    vcarga=$("#vw_md_doc_txtcarga").val();
    jsnombreDocente=$( "#vw_md_doc_docentes option:selected" ).text();
    vgrupo=$("#vw_md_doc_txtdivision").val();
    
    $.ajax({
            url: base_url + 'cargasubseccion/fn_cambiardocente',
            type: 'POST',
            data: {"fca-txtcoddocente": docsel ,"fca-txtsubseccion": vgrupo ,"fca-txtcodcarga": vcarga},
            dataType: 'json',
            success: function(e) {
              $('#divcontent_docentes #divoverlay').remove();
              if (e.status==true){
                
                if (docsel=='00000'){
                  btn_editdocente.closest(".fdivision").find('.spandocente').html("SIN DOCENTE");
                }
                else{
                  btn_editdocente.closest(".fdivision").find('.spandocente').html(jsnombreDocente);
                  /*setInterval(function(){ 
                  btn.parent().css("border", "0px solid #f37736").animate({'borderWidth': '1px',  'borderColor': 'red'},500);
              }, 2000);*/
                }
                $("#md_docentes").modal("hide");
              }
              else{
                Toast.fire({
              type: 'danger',
              title: 'Error: ' + e.msg
            });

              }
            },
            error: function(jqXHR, exception) {
              $(this).bootstrapToggle('off');
              $('#divcontent_docentes #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fca-plan').html("<option value='0'>" + msgf + "</option>");
            }
        })

});

<?php if ($p66 == "SI"): ?>
    $('.checkOpen').bootstrapToggle();
    function fn_abrir_cerrar_curso(btn){

        //var fila_carga=btn.closest(".fcarga");
        var fila_division=btn.closest(".fdivision");

        var vcarga=fila_division.data("codcarga64");
        var vdivision=fila_division.data("division64");
        
        if (btn.prop('checked') == false) {

          $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $('#divcard-cargaAcademica').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'cargasubseccion/fn_culminar_carga_subseccion',
                type: 'post',
                dataType: 'json',
                data: {"idcarga": vcarga,"division":vdivision},
                success: function(e) {
                    $('#divcard-cargaAcademica #divoverlay').remove();
                    $('#divcard_cursos #divoverlay').remove();
                    $('#divcard_grupo #divoverlay').remove();
                    if (e.status == true) {
                        Swal.fire({
                          icon: 'success',
                          title: 'ÉXITO, culminación completa',
                          html: e.msg,
                          backdrop:false,
                        });
                    } else {
                        btn.bootstrapToggle('destroy');
                        btn.prop('checked', true);
                        btn.bootstrapToggle();
                        Swal.fire({
                          icon: 'error',
                          title: 'ERROR, NO se pudo culminar',
                          html: e.msg,
                          backdrop:false,
                        });
                        
                    }
                },
                error: function(jqXHR, exception) {
                  //alert("dd");
                    btn.bootstrapToggle('destroy');
                    btn.prop('checked', true);
                    btn.bootstrapToggle();
                    $('#divcard-cargaAcademica #divoverlay').remove();
                    $('#divcard_cursos #divoverlay').remove();
                    $('#divcard_grupo #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se pudo culminar',
                        text: msgf,
                        backdrop:false,
                    });
                }
            });
        } else {
          $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $('#divcard-cargaAcademica').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            $.ajax({
                url: base_url + 'cargasubseccion/fn_abrir_carga_subseccion',
                type: 'post',
                dataType: 'json',
                data: {"idcarga": vcarga,"division":vdivision},
                success: function(e) {
                    $('#divcard-cargaAcademica #divoverlay').remove();
                    $('#divcard_cursos #divoverlay').remove();
                    $('#divcard_grupo #divoverlay').remove();
                    if (e.status == true) {
                      Swal.fire({
                          type: 'success',
                          title: 'ÉXITO, apertura completa',
                          html: e.msg,
                          backdrop:false,
                        });

                    } else {
                      btn.bootstrapToggle('destroy');
                      btn.prop('checked', false);
                      btn.bootstrapToggle();
                        Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se pudo aperturar',
                        html: e.msg,
                        backdrop:false,
                    });
                    }
                },
                error: function(jqXHR, exception) {
                     btn.bootstrapToggle('destroy');
                    btn.prop('checked', false);
                    btn.bootstrapToggle();
                   $('#divcard-cargaAcademica #divoverlay').remove();
                    $('#divcard_cursos #divoverlay').remove();
                    $('#divcard_grupo #divoverlay').remove();
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se pudo culminar',
                        text: msgf,
                        backdrop:false,
                    });
                }
            });
        }
    };
  <?php endif ?>

  <?php if ($p67 == "SI"): ?>
    $('.checkOcultar').bootstrapToggle();
    $(".checkOcultar").change(function(event) {
      btn=$(this);
        //var fila_carga=btn.closest(".fcarga");
        var fila_division=btn.closest(".fdivision");

        var vcarga=fila_division.data("codcarga64");
        var vdivision=fila_division.data("division64");
        var chekear=btn.prop('checked') 
        

        $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $.ajax({
              url: base_url + 'curso/fn_curso_ocultar',
              type: 'post',
              dataType: 'json',
              data: {"idcarga": vcarga,"division":vdivision,"accion":!chekear},
              success: function(e) {
                  $('#divcard_cursos #divoverlay').remove();
                  $('#divcard_grupo #divoverlay').remove();
                  if (e.status == true) {
                      
                  } else {
                      btn.bootstrapToggle('destroy');
                    btn.prop('checked', !chekear);
                    btn.bootstrapToggle();
                      Toast.fire({
                          type: 'danger',
                          title: 'Error: ' + e.msg
                      });
                  }
              },
              error: function(jqXHR, exception) {
                //alert("dd");
                  btn.bootstrapToggle('destroy');
                  btn.prop('checked', !chekear);
                  btn.bootstrapToggle();
                  $('#divcard_cursos #divoverlay').remove();
                  $('#divcard_grupo #divoverlay').remove();
                  var msgf = errorAjax(jqXHR, exception, 'text');
                  Swal.fire({
                      type: 'error',
                      title: 'ERROR, NO se pudo culminar',
                      text: msgf,
                      backdrop:false,
                  });
              }
          });
      
    });
  <?php endif ?>

function fn_eliminadivision(btn) {
    var vcarga = btn.data('carga');
    var vgrupo = btn.data('grupo');
    Swal.fire({
      title: '¿Deseas eliminar el grupo ' + vgrupo + '?',
      text: "Al eliminar, los alumnos registrados no serán eliminados, permaneceran inactivos hasta asignar un nuevo grupo",
      type: 'warning',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
      if (result.value) {
            $.ajax({
                  url: base_url + 'cargasubseccion/fn_eliminardivision',
                  type: 'POST',
                  data: {"fca-txtsubseccion": vgrupo ,"fca-txtcodcarga": vcarga},
                  dataType: 'json',
                  success: function(e) {
                      if (e.status==true){
                          Swal.fire(
                              'Eliminado!',
                              'La división '+ vgrupo + ' fue eliminado correctamente.',
                              'success'
                          )
                          btn.closest('.fdivision').remove();
                      }
                      else{
                          resolve(e.msg);
                      }
                  },
                  error: function(jqXHR, exception) {
                    //$('#divcard_grupo #divoverlay').remove();
                      var msgf = errorAjax(jqXHR, exception, 'text');
                      Swal.fire(
                          'Error!',
                          msgf,
                          'success'
                      )
                  }
              })
      }
    })
}

//////////////////////////////
// SCRIPT HORARIOS
/////////////////////////////

function vw_abrir_horarios_modal(btn) {
    fila = btn.closest('tr');
    codcarga64 = fila.data('codcarga64');
    division64 = fila.data('division64');
    nunidad = btn.data('nunidad');
    vturno = btn.data('codturno');
    $('#modname_unidad').html(nunidad);
    $("#vw_horario_txtcodcarga").val(codcarga64);
    $("#vw_horario_txtcoddivision").val(division64);
    $('#vw_horario_txtturno').val(vturno);
    $('#divcard_formadd').hide();

    fn_get_carga_horarios();
    
    return false;
}

function fn_get_carga_horarios() {
  codcarga64 = $("#vw_horario_txtcodcarga").val();
  division64 = $("#vw_horario_txtcoddivision").val();
  vturno = $('#vw_horario_txtturno').val();

  tbhorario = $('#tbc_dtCargaHorario').DataTable();
  tbhorario.clear();
  $('#divcard-cargaAcademica').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'horarios/fn_get_carga_subseccion_horarios',
      type: 'post',
      dataType: 'json',
      data: {
          'fmt-carga': codcarga64,
          'fmt-subseccion': division64,
          'fmt-turno': vturno
      },
      success: function(e) {
          $('#divcard-cargaAcademica #divoverlay').remove();
          $('#modview_hoarios').modal();
          $('#ficboaula').html(e.cbaulas);
          $('#ficbohoraini').html(e.cbhorasini);
          $('#ficbohorafin').html(e.cbhorasfin);
          dropdown_opciones = "";
          vupdatehorario = "";
          vdeletehorario = "";
          $.each(e.vdata, function(index, v) {

              if (e.vpermiso210 == "SI") {
                vupdatehorario = '<a href="#" data-chr=' + v['codhorario64'] + ' class="dropdown-item text-dark" onclick="fn_vw_horario_codigo($(this));return false;"><i class="fas fa-edit mr-2"></i>Editar</a>';
              }

              if (e.vpermiso211 == "SI") {
                vdeletehorario = '<a href="#" data-chr=' + v['codhorario64'] + ' class="dropdown-item text-danger" onclick="fn_vw_delete_horario($(this));return false;"><i class="fas fa-trash-alt mr-2"></i>Eliminar</a>';
              }

              dropdown_opciones='<div class="btn-group btn-group-sm p-0 dropleft">' +
                  '<button class="btn btn-info btn-sm dropdown-toggle py-0 rounded" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                  '<i class="fas fa-cog"></i>' +
                  '</button>' +
                  '<div class="dropdown-menu">' +
                    vupdatehorario +
                    vdeletehorario+
                  '</div>' +
                '</div>' ;

              var fila = tbhorario.row.add([index + 1, v['dia'], v['hinicia'], v['hculmina'], v['naula'], v['piso'], v['nhoras'], dropdown_opciones]).node();
              $(fila).attr('data-codhorario64', v['id']);
              $(fila).addClass("fchorario");
          })

          tbhorario.draw();

      },
      error: function(jqXHR, exception) {
          $('#divcard-cargaAcademica #divoverlay').remove();
          var msgf = errorAjax(jqXHR, exception, 'text');
          Swal.fire({
              type: 'error',
              title: 'ERROR, NO se guardó cambios',
              text: msgf,
              backdrop: false,
          });
      },
  });
}

function fn_additem_horario(btn) {
  $('#divcard_formadd').show();
  $('#divcard_dtCargaHorario').hide();
  $('#divbtnadd_horario').hide();
  $('#btn_item_add').show();
  // $('#btncancel_horario').hide();
}

$('#btncancel_horario').click(function(e) {
  $('#divdata_items_horario').html('');
  $('#divcard_formadd').hide();
  $('#divcard_dtCargaHorario').show();
  $('#divbtnadd_horario').show();
});

$('#modview_hoarios').on('hidden.bs.modal', function (e) {
  $('#divdata_items_horario').html('');
  $('#divcard_formadd').hide();
  $('#divcard_dtCargaHorario').show();
  $('#divbtnadd_horario').show();
})

var itemsHorarios = {};
var itemsNro = 1;

function fn_agrega_item_horario(btn) {
    var row = $("#vw_fcb_rowitem").clone();
    row.attr('id', 'vw_fcb_rowitem' + itemsNro);
    row.data('arraypos', itemsNro);
    itemsNro++;
    
    row.show();
    $('#divdata_items_horario').append(row);
}

function fn_delete_item_horario(btn) {
  var fila = btn.closest('.rowcolors');
    var pos = fila.data('arraypos');
    fila.remove();
}

function fn_vw_horario_codigo(btn) {
  vcodigo64 = btn.data('chr');

  $('#modview_hoarios .modview_hoarios_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'horarios/fn_get_carga_horarios_codigo',
      type: 'post',
      dataType: 'json',
      data: {
          'fmt-codigo': vcodigo64
      },
      success: function(e) {
          $('#modview_hoarios .modview_hoarios_content #divoverlay').remove();
          
          $('#divcard_formadd').show();
          $('#divcard_dtCargaHorario').hide();
          $('#divbtnadd_horario').hide();
          $('#btn_item_add').hide();
          // $('#btncancel_horario').show();

          var itemhor = {};
          var itemsNroup = 1;

          itemhor['fictxtcodigoh'] = e.vdata['codhorario64'];
          itemhor['ficbodia'] = e.vdata['dia'];
          itemhor['ficboaula'] = e.vdata['aula'];
          itemhor['ficbohoraini'] = e.vdata['inicia'];
          itemhor['ficbohorafin'] = e.vdata['finaliza'];

          var row = $("#vw_fcb_rowitem").clone();
          row.attr('id', 'vw_fcb_rowitem' + itemsNroup);
          row.data('arraypos', itemsNroup);
          row.find('input,select').each(function(index, el) {
              $(this).val(itemhor[$(this).attr('name')]);
          })
          row.find('.deleteitemh').hide();
          row.show();
          $('#divdata_items_horario').append(row);

      },
      error: function(jqXHR, exception) {
          $('#modview_hoarios .modview_hoarios_content #divoverlay').remove();
          var msgf = errorAjax(jqXHR, exception, 'text');
          Swal.fire({
              type: 'error',
              title: 'ERROR, NO se guardó cambios',
              text: msgf,
              backdrop: false,
          });
      },
  });
}

function fn_vw_delete_horario(btn) {
    vcodigo64 = btn.data('chr');
      
    Swal.fire({
      title: '¿Está seguro de eliminar el item seleccionado?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      icon: 'warning',
      showCancelButton: true,
      allowOutsideClick: false,
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, eliminar!'
    }).then(function(result){
      if(result.value){
          $('#modview_hoarios .modview_hoarios_content').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          var datos = new FormData();
          datos.append("fictxtcodigo", vcodigo64);
          
          $.ajax({
              url: base_url + "horarios/fneliminar_item_horario",
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              success:function(e){
                $('#modview_hoarios .modview_hoarios_content #divoverlay').remove();
                if (e.status == true) {
                  Swal.fire({
                        type: "success",
                        icon: 'success',
                        title: "¡CORRECTO!",
                        text: e.msg,
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            fn_get_carga_horarios();
                        }
                    })
                }
              },
              error: function(jqXHR, exception) {
                  var msgf = errorAjax(jqXHR, exception,'text');
                  $('#modview_hoarios .modview_hoarios_content #divoverlay').remove();
                  Swal.fire({
                      title: "Error",
                      text: e.msgf,
                      type: "error",
                      icon: "error",
                      allowOutsideClick: false,
                      confirmButtonText: "¡Cerrar!"
                  });
              }
          })
      }
    });     
        
    return false;
}

$('#form_addHorario').submit(function(e) {
    arritemhr = [];
    Nroitemshorario = $('#divdata_items_horario .vw_fcb_class_rowitem').length;
    
    if (Nroitemshorario === 0) {
        Swal.fire(
            'Items!',
            "Se necesita agregar al menos un item para guardar los datos",
            'warning'
        );
        return false;
    }

    $('#divdata_items_horario .vw_fcb_class_rowitem').each(function(index, el) {
        var itemd = {};
        itemd['fictxtcodigoh'] = $(this).find('[name=fictxtcodigoh]').val();
        itemd['fictxtdia'] = $(this).find('[name=ficbodia]').val();
        itemd['fictxtaula'] = $(this).find('[name=ficboaula]').val();
        itemd['fictxtpiso'] = $(this).find('[name=ficboaula] option:selected').data('piso');
        itemd['fictxtinicia'] = $(this).find('[name=ficbohoraini]').val();
        itemd['fictxtculmina'] = $(this).find('[name=ficbohorafin]').val();
        
        horainicial = $(this).find('[name=ficbohoraini]').val();
        horafinal = $(this).find('[name=ficbohorafin]').val();

        arritemhr.push(itemd);
        
    })

    ahorario= JSON.stringify(arritemhr);
    fdata=$(this).serializeArray();
    fdata.push({name: 'items', value: ahorario});
    
    $('#modview_hoarios .modview_hoarios_content').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "horarios/fn_insert_update",
        type: 'post',
        dataType: 'json',
        data: fdata,
        success: function(e) {

            $('#modview_hoarios .modview_hoarios_content #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: "No se pudieron guardar datos",
                    text: e.msg,
                    backdrop:false,
                });
            } else {
                
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: "Datos GUARDADOS CORRECTAMENTE",
                    text: e.msg,
                    backdrop:false,
                });

                $('#divcard_formadd').hide();
                $('#divcard_dtCargaHorario').show();
                $('#divbtnadd_horario').show();
                $('#divdata_items_horario').html('');
                fn_get_carga_horarios();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#modview_hoarios .modview_hoarios_content #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: "No se pudieron guardar datos",
                text: msgf,
                backdrop:false,
            });
        }
    });
    return false;

});

function fn_get_planes_combo(btn, formulario, combo) {
    codcar = btn.val();
    if (codcar == "%") {
        $("#"+formulario+" #"+combo+" option").each(function(i) {
            if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
        });
    } else {
        $("#"+formulario+" #"+combo+" option").each(function(i) {
            if ($(this).data('carrera') == '0') {
                //if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
            } else if ($(this).data('carrera') == codcar) {
                $(this).removeClass('ocultar');
            } else {
                if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
            }
        });
    }
    
}

</script>