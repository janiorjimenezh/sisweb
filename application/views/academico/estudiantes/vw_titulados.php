<?php 
  $vbaseurl=base_url();
  date_default_timezone_set ('America/Lima');
  $fecha = date("Y-m-d");
?>
<style type="text/css">
  /*not-active { 
      pointer-events: none; 
      cursor: default; 
  }

  .drop-menu-index{
    z-index: 2500;
    position: relative;
  }

  table.dataTable tbody tr.selected a:not(.bg-danger,.bg-primary,.bg-info,.bg-success,.bg-warning,.bg-secondary, a.dropdown-item) {
    color: #007bff !important;
  }*/

</style>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>


<div class="modal fade" id="vw_md_historial_mat" tabindex="-1" role="dialog" aria-labelledby="vw_md_historial_mat" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="vw_dp_mc_matriculas">
            <div class="modal-header">
                <h5 class="modal-title" id="divcard_title">Historial de Matricula</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="vw_dp_divHistorial_inscripciones">
              <div class="col-12" id="tabdivres-matriculas">
                  <table id="tbmt_dtmatriculas" class="tbdatatable table table-sm table-hover table-bordered table-condensed" style="width:100%">
                    <thead>
                      <tr class="bg-lightgray">
                        <th>N°</th>
                        <th>Filial</th>
                        <th>Carné</th>
                        <th>Estudiante / Edad</th>
                        <th>Fec.Mat.</th>
                        <th>Cuota</th>
                        <th>Plan</th>
                        <th>Grupo</th>
                        <th>Est</th>
                      </tr>
                    </thead>
                    <tbody>
                                  
                    </tbody>
                  </table>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <?php if (getPermitido("177") == "SI") { ?>
                <a id="vw_dp_mc_btn_nuevamatricula" href="#" class="btn btn-primary">Nueva Matricula</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">

  <section id="s-cargado" class="content pt-2">

    <div id="divboxhistorial" class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link active" href="#egresados" data-codmodalidad='%' id="insTabegresados" data-modalidad='egresados' data-toggle="tab">
              <u>Egresados</u>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#cuestionarios" data-codmodalidad='1' id="insTabcuestionarios" data-modalidad='cuestionarios' data-toggle="tab">
              <u>Cuestionario</u>
            </a>
          </li>
        
          
          <li id="tabli-aperturafile" class="nav-item">
            <a class="nav-link" href="#reportes" data-codmodalidad='R' id="insTabreportes" data-modalidad='reportes' data-toggle="tab">
              <u>Reportes</u>
            </a>
          </li>
          
        </ul>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-2">
        <div class="tab-content">
          <div class="active tab-pane pt-3" id="egresados">
            <!--<div class="card-header">-->
            
            <form id="frm-filtro-inscritos" name="frm-filtro-inscritos" action="<?php echo $vbaseurl ?>academico/estudiantes/filtro/incripciones" method="post" accept-charset='utf-8'>
              
              <div class="row my-2">
                <input type="hidden" name="fbus-modalidad" id="fbus-modalidad" value="%">
                <div class="form-group has-float-label col-12 col-sm-2 col-md-2">
                  <select name="fbus-sede" id="fbus-sede" class="form-control form-control-sm">
                    <option value="%">Todos</option>
                    <?php 
                      foreach ($sedes as $filial) {
                        $select=($_SESSION['userActivo']->idsede==$filial->id) ? "selected":"";
                        echo "<option $select value='$filial->id'>$filial->nombre</option>";
                      } 
                    ?>
                  </select>
                  <label for="fbus-sede"><i class="far fa-building"></i> Filial</label>
                </div>

                <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                  <select class="form-control form-control-sm" id="fbus-periodo" name="fbus-periodo" placeholder="Periodo lectivo">
                    <option value="%">Todos</option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-carrera">Periodo lectivo</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fbus-campania" name="fbus-campania" placeholder="Campaña" required >
                    <option value="%">Todas</option>
                  </select>
                  <label for="fbus-campania"> Campaña</label>
                </div>

                <div class="form-group has-float-label col-12 col-sm-3 col-md-3">
                  <select class="form-control form-control-sm" id="fbus-carrera" name="fbus-carrera" placeholder="Programa">
                    <option value="%">Todos</option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>" data-sigla="<?php echo $carrera->sigla ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-carrera"> Programa</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fbus-ciclo" name="fbus-ciclo" placeholder="Semestre Acad." required >
                    <option value="%">Selecciona</option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-ciclo"> Semestre</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fbus-turno" name="fbus-turno" placeholder="Turno" required >
                    <option value="%">Todos</option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-turno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fbus-seccion" name="fbus-seccion" placeholder="Sección" required >
                    <option value="%">Todas</option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fbus-seccion"> Sección</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-6 col-md-4">
                  <input autocomplete="off"  class="form-control form-control-sm text-uppercase" id="fbus-txtbuscar" name="fbus-txtbuscar" type="text" placeholder="Carné o Apellidos y nombres"   />
                  <label for="fbus-txtbuscar">Carné o Apellidos y nombres</label>
                </div>
                
                <div class="col-4 col-sm-3 col-md-1">
                  <button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fas fa-search"></i></button>
                </div>

                <div class="col-6 col-sm-3 col-md-2">
                  <!-- <a href="#" class="btn-excel btn btn-outline-secondary btn-sm">
                    <img src="<?php //echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt="" style="height: 20px"> Exportar
                  </a> -->
                  <div class="btn-group">
                      <button class="btn-excel btn btn-outline-success btn-sm py-0" type="button">
                        Exportar <img height="20px"  src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt="" style="height: 20px"> 
                      </button>
                      <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Split</span>
                      </button>
                      <div class="dropdown-menu">
                        
                      </div>
                  </div>
                </div>


              </div>
              
            </form>
            <!--</div>-->
            <div class="card-body no-padding">
              <div class="row">
                <div class="col-12 py-1" id="divres-historial">
                  <div class="row div-resultados">
                    <div class="col-12" id="tabdivres-inscritos">
                      <table id="tbmt_dtinscritos" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                        <thead>
                          <tr class="bg-lightgray">
                            <th>N°</th>
                            <th>Periodo</th>
                            <th>Campaña</th>
                            <th>Programa</th>
                            <th>Modalidad</th>
                            <th>Carné</th>
                            <th>Estudiante</th>
                            <th>Fec. Insc.</th>
                            <th>Estado</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                                      
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-12 py-1" id="divres-historial-msg"></div>
                
              </div>
            </div>
          </div>
          <?php if (getPermitido("44")=='SI') { ?>
          <div class="tab-pane" id="reportes">

                <div class="card-body p-2">
                  
                  
                  
                </div>

          </div>
          <?php } ?>
        </div>
       
      </div>
      
    </div>
    
  </section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.js"></script>
<script>
  jsmodalidad="<?php echo $modalidadActiva ?>";
  $(document).ready(function() {
       
        $('.nav-pills #insTab' + jsmodalidad ).tab('show');
          //$("#frmins-postulante #ficodpostulante").val(vdnipostulante);
        $("#frm-filtro-inscritos").submit();
        


        // $('#divres-historial').hide();
        var table = $('#tbmt_dtinscritos, #tbmt_dtmatriculas').DataTable({
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
            }],
            'searching': false,
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",

        });

    
        // 
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
        }
    });

    $('.nav-pills a').on('shown.bs.tab', function(event){
      $("#fbus-modalidad").val($(event.target).data('codmodalidad'));
      
      // if ($("#fbus-modalidad").val()=="ADM"){
      //   $("#divres-administrativo").show();
      // }
      // else if ($("#fbus-modalidad").val()=="DOC"){

      //   $("#divres-docente").show();
      // }
      // else{
        
      //   $("#divres-alumno").show();
      // }
      
        var newurl = window.location.protocol + "//" + window.location.host + '/sisweb' + '/academico/estudiantes/egresados/' + $(event.target).data('modalidad') + '?sb=academico';
       
        window.history.pushState(null,'',newurl);
        if ($("#fbus-modalidad").val()!="R"){
          $("#frm-filtro-inscritos").submit();
        }
        
             
      
    });

 






  var vdnipostulante='<?php echo $dnipostula; ?>';

  $("#fbus-periodo").change(function(event) {
   
      cbcmp = $('#fbus-campania');
      cbcmp.html("");
      cbcmp.html("<option value='%'>Todas</option>");
      var codperiodo = $(this).val();
      if (codperiodo == '%') return;
      $.ajax({
          url: base_url + 'campania/fn_campania_por_periodo',
          type: 'post',
          dataType: 'json',
          data: {
              txtcodperiodo: codperiodo
          },
          success: function(e) {
              cbcmp.html(e.vdata);
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              cbcmp.html("<option value='%'>" + msgf + "</option>");
          }
      });
  });

  $("#frm-filtro-inscritos").submit(function(event) {
    $('#frm-filtro-inscritos input,select').removeClass('is-invalid');
    $('#frm-filtro-inscritos .invalid-feedback').remove();
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var llenos=0;
    var tb_head_ins = "";
    if ($("#fbus-txtbuscar").val()!=="") llenos=llenos + 2;
    if ($("#fbus-periodo").val()!=="%") llenos++;
    if ($("#fbus-sede").val()!=="%") llenos++;
    if ($("#fbus-campania").val()!=="%") llenos++;
    if ($("#fbus-seccion").val()!=="%") llenos++;
    if ($("#fbus-carrera").val()!=="%") llenos++;
    if ($("#fbus-turno").val()!=="%") llenos++;
    if ($("#fbus-ciclo").val()!=="%") llenos++;
    if (llenos>1) {
      tbinscritos = $('#tbmt_dtinscritos').DataTable();
      //tbinscritos.clear();
      $('#divres-historial').show();
      $("#divres-historial-msg").hide();
      $.ajax({
          url: $(this).attr("action"),
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(e) {
              $('#divboxhistorial #divoverlay').remove();
              tbinscritos.clear();
              if (e.status == false) {
                  $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                  });
                  $("#divres-historial").html("");
              } else {
                  
                  var nro = 0;
                  $.each(e.vdata, function(index, v) {
                    nro++;
                    var btnscolor = "";
                    var classbtndis = "";
                    var dropdown_op = '';
                    var btndelete = "";
                    var btnupdgrupo = "";
                    var btnupdatein = "";
                    var btnupdatefoto = "";
                    switch (v['estado']) {
                        case "ACTIVO":
                            btnscolor = "btn-success";
                            classbtndis = "not-active";
                            break;
                        case "POSTULA":
                            btnscolor = "btn-warning";
                            classbtndis = "";
                            break;
                        case "EGRESADO":
                            btnscolor = "btn-secondary";
                            classbtndis = "not-active";
                            break;
                        case "RETIRADO":
                            btnscolor = "btn-danger";
                            classbtndis = "";
                            break;
                        case "TITULADO":
                            btnscolor = "btn-info";
                            classbtndis = "not-active";
                            break;
                        default:
                            btnscolor = "btn-warning";
                            classbtndis = "not-active";
                    }

                    urlprint = base_url + "admision/postulante/imprimir/"+v['codper64']+"/"+v['idins64'];

                    if (e.vpermiso140 == "SI") {
                      btnupdatein = "<a class='dropdown-item text-dark' onclick='vw_update_inscrito($(this));return false;' href='#' title='Editar Inscripción'><i class='fas fa-edit mr-2'></i> Editar Inscripción</a>";
                    }

                    

                    if (e.vpermiso124 == "SI") {
                      btndelete = "<a href='#' onclick='fn_eliminar_ins($(this));return false;' data-ci='"+v['idins64']+"' class='btn-delete dropdown-item text-danger text-bold'><i class='fas fa-trash-alt'></i> Eliminar</a>";
                    }

                    if (e.vpermiso213 == "SI") {
                      btnupdatefoto = "<a href='#' onclick='fn_vw_foto_perfil(`"+v['idins64']+"`);return false;' data-ci='"+v['idins64']+"' class='dropdown-item text-dark'><i class='fas fa-image mr-2'></i> Foto</a>";
                    }

                    if (v['estado'] !== "RETIRADO") {
                      if (e.vpermiso142 == "SI") {
                        dropdown_op = dropdown_op +'<a href="#" onclick="fn_cambiarestado($(this));return false;" class="btn-cestado dropdown-item" data-color="btn-success" data-ie="'+e.cd1+'">Activo</a>'+ 
                      '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="'+e.cd2+'" data-toggle="modal" data-target="#modretirainsc" id="btnretira_inscrip'+v['idins64']+'">Retirado</a> '+
                      '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="btn-cestado dropdown-item" data-color="btn-secondary" data-ie="'+e.cd3+'">Egresado</a> '+
                      '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="btn-cestado dropdown-item" data-color="btn-info" data-ie="'+e.cd4+'">Titulado</a> '+
                      '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="btn-cestado dropdown-item" data-color="btn-warning" data-ie="'+e.cd5+'">Postula</a> '+
                      '<div class="dropdown-divider"></div>';
                      }
                    } else {
                      if (e.vpermiso150 == "SI") {
                        dropdown_op = dropdown_op + '<a href="#" onclick="fn_modactiva($(this));return false;" class="btn_actestado dropdown-item" data-color="btn-success" data-ie="'+e.cd1+'" id="btnactiva_ins_'+v['idins64']+'">Activo</a> ';
                      }
                    }
                    
                    dropdown_estado = '<div class="btn-group " id="btn-group-'+v['idins64']+'">' +
                            '<button class="btn ' + btnscolor + ' btn-sm text-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                              (v['estado'].toLowerCase()).charAt(0).toUpperCase() + (v['estado'].toLowerCase()).slice(1) +
                            '</button>' +
                            '<div class="dropdown-menu dropdown-menu-right drop-menu-index">' +
                              dropdown_op +
                              btndelete+
                            '</div>' +
                          '</div>';

                    dropdown_acc = "<div class='btn-group'>"+
                            "<a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1 rounded' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
                                "<i class='fas fa-cog'></i>"+
                            "</a>"+
                            "<div class='dropdown-menu dropdown-menu-right acc_dropdown'>"+
                              btnupdatein+
                              "<a class='dropdown-item text-dark btn-anexados' href='#' title='Documentos Anexados' data-ci='"+v['idins64']+"' data-toggle='modal' data-target='#modal-docporanexar' data-carrera='"+v['carrera']+"'>"+
                                "<i class='fas fa-edit mr-2'></i> Documentos Anexados"+
                              "</a>"+
                              "<a class='dropdown-item text-dark' href='#' title='Enviar mensaje' data-ci='"+v['idins64']+"' data-emailper='"+v['epersonal']+"' data-carnet='"+v['carnet']+"' data-toggle='modal' data-target='#modal-sendemail'>"+
                                "<i class='fas fa-envelope mr-2'></i> Enviar mensaje"+
                              "</a>"+
                              btnupdatefoto +
                            "</div>"+
                          "</div>";

                    imprficha = "<a class='bg-info py-1 px-2 rounded ml-1' target='_blank' href='"+urlprint+"' title='Imprimir ficha'>"+
                                  "<i class='fas fa-print'></i> "+
                                "</a>";

                    btnmatric = "<a onclick='cargar_historial_matriculas($(this));return false;' data-carnet='"+v['carnet']+"' data-estado='"+v['estado']+"' class='bg-secondary py-1 px-2 rounded ml-1 histo_mat' target='_blank' href='#' title='Matricular'>"+
                                  "<i class='fas fa-graduation-cap'></i> "+
                                "</a>";

                    icongen = (v['sexo'] =='MASCULINO') ? '<i class="fas fa-male fa-lg text-primary"></i>':'<i class="fas fa-female  fa-lg text-danger"></i>'

                    vcarnet = "<div class='cell-carne' title='"+v['codinscripcion']+"'>"+v['carnet']+"</div>";

                    nombres = "<div class='cell-estudiante d-inline-block'>"+v['paterno']+' '+v['materno']+' '+v['nombres']+"</div>";

                    grupo = "<div title='"+v['carrera']+"'>" + v['carsigla']+' / '+v['codturno']+' - '+v['ciclo']+' - '+v['codseccion'] + "</div>";

                    var fila = tbinscritos.row.add([index + 1, v['periodo'], v['campania'], grupo,v['modalidad'], vcarnet, icongen+" "+nombres, v['fechains'], dropdown_estado, dropdown_acc + " " + imprficha + " " + btnmatric]).node();

                    $(fila).attr('data-ci', v['idins64']);
                    $(fila).attr('data-cp', v['codperiodo']);
                    $(fila).attr('data-codcampania', v['codcampania']);
                    $(fila).attr('data-cic', v['codciclo']);
                    $(fila).attr('data-codciclo', v['codciclo']);
                    $(fila).attr('data-codturno', v['codturno']);
                    $(fila).attr('data-codseccion', v['codseccion']);
                    $(fila).attr('data-carrera', v['carrera']);
                    $(fila).attr('data-sede', v['codsed64']);

                    $(fila).attr('class', "cfila");
                  })

                  tbinscritos.draw();

              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divboxhistorial #divoverlay').remove();
              $("#divres-historial").html("");
              Swal.fire({
                  type: 'error',
                  title: 'Error, no se pudo mostrar los resultados',
                  text: msgf,
                  backdrop: false,
              })
          }
      });
    }
    else{
      $('#divboxhistorial #divoverlay').remove();
      $("#divres-historial-msg").show();
      $('#divres-historial').hide();
      $('.tbdatatable tbody').html("");
      $("#divres-historial-msg").html("<span class='text-danger'>Indicar como minimo 2 parametros de búsqueda</span>");      
    }
    return false;
  });
  
  $('.check').change(function(e) {
    $('#frm-docanexar input[type=checkbox]').each(function () {
          if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(2);
            $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', false);
            $('#frm-docanexar #txt_'+check.attr('id')).attr('disabled', false);
            $('#frm-docanexar #txt_'+check.attr('id')).focus();
            
          } else {
            var check=$(this);
            $('#frm-docanexar #period_'+check.attr('id')).val('');
            $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', true);
            $('#frm-docanexar #txt_'+check.attr('id')).attr('disabled', true);
            $('#frm-docanexar #txt_'+check.attr('id')).val("");
          }
    });
  });

  $("#frm-docanexar").submit(function(event) {
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var cins=$("#fdacodins").val();
    var arrdata = [];

    $('#frm-docanexar input[type=checkbox]').each(function () {
          if (this.checked) {
            var check=$(this);
            var idins = check.data('inscrito');
            var valor=check.attr('id').substring(2);
            var detalle = $('#frm-docanexar #txt_'+check.attr('id')).val();
            var periodo = $('#frm-docanexar #period_'+check.attr('id')).val();

            var myvals = [valor, detalle, periodo,idins,'NEW'];
            arrdata.push(myvals);
          }

          if ((!this.checked) && ($(this).data('inscrito') !== "")) {
            var check_=$(this);
            var idins_ = check_.data('inscrito');
            var valor_=check_.attr('id').substring(2);
            var detalle_ = $('#frm-docanexar #txt_'+check_.attr('id')).val();
            var periodo_ = $('#frm-docanexar #period_'+check_.attr('id')).val();
            var myvals_ = [valor_, detalle_, periodo_, idins_,'OLD'];
            arrdata.push(myvals_);
          }
    });
    //************************************
    $.ajax({
      url: base_url + 'inscrito/fn_insertdocs',
      type: 'post',
      dataType: 'json',
      data: {
              'ce-idins': cins,
              'filas': JSON.stringify(arrdata),
          },
      success: function(e) {
          $('#divboxhistorial #divoverlay').remove();
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
              $('#modal-docporanexar').modal('hide')
              Swal.fire({
                  type: 'success',
                  icon: 'success',
                  title: 'Actualización correcta',
                  text: 'Se ha actualizaron los datos de la inscripción',
                  backdrop: false,
              })

              
              
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divboxhistorial #divoverlay').remove();
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
    //***************************************
  });

  $(".btn-excel").click(function(e) {
    e.preventDefault();
    
    $('#frm-filtro-inscritos input,select').removeClass('is-invalid');
    $('#frm-filtro-inscritos .invalid-feedback').remove();

    var url=base_url + 'admision/inscripciones/excel?cp=' + $("#fbus-periodo").val() + '&cc=' + $("#fbus-carrera").val()  + '&tn=' +  $("#fbus-turno").val()  + '&cl=' +  $("#fbus-ciclo").val() + '&ccp=' + $("#fbus-campania").val() + '&cs=' + $("#fbus-seccion").val() +'&ap=' + $("#fbus-txtbuscar").val();
    var llenos=0;
    if ($("#fbus-txtbuscar").val()!=="") llenos=llenos + 2;
    if ($("#fbus-periodo").val()!=="%") llenos++;
    if ($("#fbus-campania").val()!=="%") llenos++;
    if ($("#fbus-seccion").val()!=="%") llenos++;
    if ($("#fbus-carrera").val()!=="%") llenos++;
    if ($("#fbus-turno").val()!=="%") llenos++;
    if ($("#fbus-ciclo").val()!=="%") llenos++;
    //var ejecuta=false;
    /*if ($.trim($("#fbus-txtbuscar").val())=='%%%%'){
      if (($("#fbus-periodo").val()!="%") || ($("#fbus-carrera").val()!="%")){
        ejecuta=true;
      }
      else{
        $('#fbus-carrera').addClass('is-invalid');
        $('#fbus-carrera').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
        $('#fbus-periodo').addClass('is-invalid');
        $('#fbus-periodo').parent().append("<div class='invalid-feedback'> Seleccionar</div>");
      }
    }else if($.trim($("#fbus-txtbuscar").val()).length>3){
      ejecuta=true;
    }
    else{
        $('#fbus-txtbuscar').addClass('is-invalid');
        $('#fbus-txtbuscar').parent().append("<div class='invalid-feedback'> Ingrese mínimo 4 caracteres o %%%%</div>");
    }*/
    if (llenos>1) {
      window.open(url, '_blank');
    }
    else{
      $("#divres-historial").html("");
      $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $('#divboxhistorial #divoverlay').remove();
      
      $("#divres-historial").html("<span class='text-danger'>Recuerda: Indicar como minimo 2 parametros de búsqueda</span>");      
    }
  });

  $('#modretirainsc').on('show.bs.modal', function (e) {
      var rel = $(e.relatedTarget);
      tbinscritos = $('#tbmt_dtinscritos').DataTable();
      div = tbinscritos.$('tr.selected');
      // var div = rel.parents('.cfila');
      var codigo = div.data('ci');
      var periodo = div.data('cp');
      var estado = rel.data('ie');
      var color = rel.data('color');
      
      $('#fic_inscrip_codigo').val(codigo);
      $('#ficinscestado').val(estado);
      $('#lbtn_retira_insc').data('coloran', color);
      $('#ficinsperiodo').val(periodo);

  });

  $('#lbtn_retira_insc').click(function() {
      var color = $(this).data('coloran');
      
      $('#form_retira_insc input,select,textarea').removeClass('is-invalid');
      $('#form_retira_insc .invalid-feedback').remove();
      $('#divmodalretirar').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: $('#form_retira_insc').attr("action"),
          type: 'post',
          dataType: 'json',
          data: $('#form_retira_insc').serialize(),
          success: function(e) {
              $('#divmodalretirar #divoverlay').remove();
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
                  $('#modretirainsc').modal('hide');
                  
                  var btnret = $('#btnretira_inscrip'+e.idinscrip);
                  var btdt = btnret.parents(".btn-group").find('.dropdown-toggle');
                  var textoan = btnret.html();

                  btdt.removeClass('btn-danger');
                  btdt.removeClass('btn-success');
                  btdt.removeClass('btn-warning');
                  btdt.removeClass('btn-secondary');
                  btdt.removeClass('btn-info');

                  btdt.addClass(color);
                  btdt.html(textoan);

                  $('#btn-group-'+e.idinscrip+' .btn-cestado').hide();
                  $('#btn-group-'+e.idinscrip+' #btnretira_inscrip'+e.idinscrip).hide();
                  //btn-cestado
                  // $('#btn-group-'+e.idinscrip).hide();
                  // $('#btn-group-'+e.idinscrip).after('<button class="btn '+color+' btn-sm py-0" type="button"> '+
                  //     textoan+
                  //   '</button>');
                  
                  Swal.fire({
                      type: 'success',
                      icon: 'success',
                      title: 'Felicitaciones, inscripción cambio a retirado',
                      text: 'Se ha retirado la inscripción',
                      backdrop: false,
                  })
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#divmodalretirar #divoverlay').remove();
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

  function grupo_inscripcion(btn){
    // tbinscritos = $('#tbmt_dtinscritos').DataTable();
    // fila = tbinscritos.$('tr.selected');
    var fila=btn.closest(".cfila");
    var codinscripcion=fila.data("ci");
    var codperiodo=fila.data("cp");
    var carrera=fila.data("carrera");
    var codturno=fila.data("codturno");
    var codseccion=fila.data("codseccion");
    var codciclo=fila.data("codciclo");
    var codcampania=fila.data("codcampania");
    //TRAER LAS CAMPAÑIAS
    $("#modgrupoingreso").modal("show");
    $('#vw_md_gi_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'campania/fn_campania_por_periodo',
        type: 'post',
        dataType: 'json',
        data: {
                'txtcodperiodo': codperiodo
            },
        success: function(e) {
            $('#vw_md_gi_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    type: 'error',
                    title: 'Error!',
                    text: e.msg,
                    backdrop: false,
                })
            } else {
                if (e.count==0){
                   Swal.fire({
                      type: 'warning',
                      title: 'ADVERTENCIA!',
                      text: "No existe campaña registrada para el periodo " + codperiodo + ", contacte al administrador",
                      backdrop: false,
                  });
                   $("#modgrupoingreso").modal("hide");
                }
                else{
                  $("#vw_md_gi_campania").html(e.vdata);
                  $("#vw_md_gi_inscrip_codigo").val(codinscripcion);
                  $("#vw_md_gi_spperiodo").html(codperiodo);
                  $("#vw_md_gi_periodo").val(codperiodo);
                  $("#vw_md_gi_carrera").html(carrera);
                  $("#vw_md_gi_turno").val(codturno);
                  $("#vw_md_gi_seccion").val(codseccion);
                  $("#vw_md_gi_ciclo").val(codciclo);
                  $("#vw_md_gi_campania").val(codcampania);
                  
                  
                }
                
            }
        },
        error: function(jqXHR, exception) {
          $("#modgrupoingreso").modal("hide");
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_md_gi_content #divoverlay').remove();
            Swal.fire({
                type: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
      });
      //FIN TRAER CAMAPANIAS
  }

  $('#vw_md_gi_btnguardar').click(function() {
      
      $('#vw_md_gi_frmcambiargrupo input,select,textarea').removeClass('is-invalid');
      $('#vw_md_gi_frmcambiargrupo .invalid-feedback').remove();
      $('#vw_md_gi_content').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: $('#vw_md_gi_frmcambiargrupo').attr("action"),
          type: 'post',
          dataType: 'json',
          data: $('#vw_md_gi_frmcambiargrupo').serialize(),
          success: function(e) {
              $('#vw_md_gi_content #divoverlay').remove();
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
                  $("#modgrupoingreso").modal("hide");
                  $("#frm-filtro-inscritos").submit();
                  
                  
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#vw_md_gi_content #divoverlay').remove();
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

  $('#modactiva').on('hidden.bs.modal', function (e) {
    $('#form_activa_insc')[0].reset();
  })

  $('#lbtn_activa_insc').click(function() {
      var color = $(this).data('coloran');
      
      $('#form_activa_insc input,select,textarea').removeClass('is-invalid');
      $('#form_activa_insc .invalid-feedback').remove();
      $('#divmodalactivar').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: $('#form_activa_insc').attr("action"),
          type: 'post',
          dataType: 'json',
          data: $('#form_activa_insc').serialize(),
          success: function(e) {
              $('#divmodalactivar #divoverlay').remove();
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
                  $('#modactiva').modal('hide');
                  $("#frm-filtro-inscritos").submit();

                  
                  Swal.fire({
                      type: 'success',
                      icon: 'success',
                      title: 'Felicitaciones, inscripción ha sido actualizado',
                      text: 'Se ha actualizado la inscripción',
                      backdrop: false,
                  })
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception,'text');
              $('#divmodalactivar #divoverlay').remove();
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

  $('.checkman').change(function(e) {
    docarray = [];
    $('#modanexadocs input[type=checkbox]').each(function () {
        if (this.checked) {
            var check=$(this);
            var valor=check.attr('id').substring(3);
            var abrev = check.data('abrev');
            $('#period_'+check.attr('id')).attr('disabled', false);
            $('#txt_'+check.attr('id')).attr('disabled', false);
            $('#txt_'+check.attr('id')).focus();

            docarray.push(abrev);
            
        } else {
            var check=$(this);
            $('#period_'+check.attr('id')).val('');
            $('#period_'+check.attr('id')).attr('disabled', true);
            $('#txt_'+check.attr('id')).attr('disabled', true);
            $('#txt_'+check.attr('id')).val("");
        }
    });
    docsanex = JSON.stringify(docarray);
    if (docarray.length > 0) {
      $('#btn_docanex').html("Documentos anexados: "+docsanex);
    } else {
      $('#btn_docanex').html("Documentos anexados");
    }
    
  });

  $('#modanexadocs').on('show.bs.modal', function (e) {
    $('#msgcarrera').html('');
    if ($('#ficbcarrera').val !== "0") $('#msgcarrera').html($('option:selected', $('#ficbcarrera')).data('nombre'));
  })

 


  function fn_modactiva (btn) {
    var div = btn.parents('.cfila');
    var codigo = div.data('ci');
    var periodo = div.data('cp');
    var estado = btn.data('ie');
    console.log("estado", estado);
    var color = btn.data('color');

    $('#fic_inscodigo_activa').val(codigo);
    $('#ficinscestado_activa').val(estado);
    $('#ficinsperiodo_activa').val(periodo)
    $('#lbtn_activa_insc').data('coloran', color);

    $('#modactiva').modal('show');
  }

  function cargar_historial_matriculas(btn) {
    var fila = btn.closest('.cfila');
    var carnet = btn.data('carnet');
    var insestado = btn.data('estado');
    var vestudiante = fila.find('.cell-estudiante').html();
    $('#vw_dp_mc_matriculas').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#msghistorial_estudiante').html("");
    $('#vw_md_historial_mat').modal();
    tblhistorial = "";
    $.ajax({
        url: base_url + 'matricula/fn_historial_matricula',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-carne': carnet
        },
        success: function(e) {
            $('#vw_dp_mc_matriculas #divoverlay').remove();
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
                var estado = "";
                codciclo = "";
                nro = 0;
                conteo = e.vdata.length;
                
                if (conteo > 0){
                  tbmatriculados = $('#tbmt_dtmatriculas').DataTable();
                  tbmatriculados.clear();
                  $.each(e.vdata, function(index, v) {
                    nro++;
                    var vcm = v['codmatricula64'];
                    var btnscolor = "";
                    var textobs = (v['observacion']!= "") ? v['observacion'] : "Ninguna";
                    var observacion = "<br><b>Observación:</b><br>"+textobs;
                    if (v['estado'] != "RES") {
                      estado = v['estado'];
                    }
                    
                    codciclo = v['codciclo'];
                    switch (v['estado']) {
                        case "ACT":
                            btnscolor = "btn-success";
                            break;
                        case "CUL":
                            btnscolor = "btn-secondary";
                            break;
                        case "DES":
                            btnscolor = "btn-danger";
                            break;
                        case "RET":
                            btnscolor = "btn-danger";
                            break;
                        default:
                            btnscolor = "btn-warning";
                    }
                    if (e.vpermiso178 == "SI") {
                      dropdown_estado = '<div class="btn-group">' +
                          '<button class="btn ' + btnscolor + ' btn-sm text-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="estado'+vcm+'">' +
                          v['estado'] +
                          '</button>' +
                          '<div class="dropdown-menu">' +
                          '<a href="#" onclick="fn_cambiarestado_mat($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd1 + '">Activo</a>' +
                          '<a href="#" onclick="fn_cambiarestado_mat($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd2 + '">Retirado</a>' +
                          '<a href="#" onclick="fn_cambiarestado_mat($(this))" class="dropdown-item" data-campo="tabla" data-ie="' + cd7 + '">Desaprobado</a>' +
                          '<div class="dropdown-divider"></div>' +
                          '<a href="#" onclick="fn_eliminar_matricula($(this))" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                          '</div>' +
                          '</div>';
                    } else {
                        dropdown_estado = '<small class="badge '+btnscolor+' p-2"> '+ v['estado'] +'</small>';
                    }
                    sexo = (v['codsexo'] == "FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
                    estudiante = sexo + v['paterno'] + " " + v['materno'] + " " + v['nombres'] + " " + v['edad'];
                    fecharegistro = v['registro'] + " <a href='#' class='view_user_reg' tabindex='0' role='button' data-toggle='popover' data-trigger='hover' title='Matriculado por: ' data-content='"+v['usuario']+observacion+"'><i class='fas fa-info-circle fa-lg'></i></a>";
                    vcuota = v['vpension'] + " ("+v['beneficio']+")";
                    grupo = v['periodo'] + " " + v['sigla'] + " " + v['codturno'] + " " + v['ciclo'] + " " + v['codseccion'];

                    var fila = tbmatriculados.row.add([index + 1, v['sede_abrevia'], v['carne'], estudiante, fecharegistro, vcuota, v['plan'], grupo, dropdown_estado]).node();
                    $(fila).attr('data-codmatricula64', v['codmatricula64']);
                    $(fila).attr('data-estudiante', v['paterno'] + " " + v['materno'] + " " + v['nombres']);
                      
                  })
                  
                  // $('#msghistorial_estudiante').html(tblhistorial);
                  tbmatriculados.draw();
                  // $('#vw_dp_mc_matriculas #divoverlay').remove();
                  $('.view_user_reg').popover({
                    trigger: 'hover',
                    html: true
                  })
                  $("#vw_dp_mc_btn_nuevamatricula").attr('href', base_url + "gestion/academico/matriculas?sb=academico&fcarnet=" + carnet);
                } else {
                  if (insestado == "ACTIVO") {
                    $('#vw_dp_mc_matriculas').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                    window.location.href =base_url + "gestion/academico/matriculas?sb=academico&fcarnet=" + carnet;
                  } else {
                    
                    Swal.fire({
                        type: 'warning',
                        icon: 'warning',
                        title: 'Aviso!',
                        text: "El estado del estudiante no esta activo",
                        backdrop: false,
                    }).then(function(result){
                        if(result.value){
                           $('#vw_md_historial_mat').modal('hide');
                        }
                    })
                    
                  }
                  
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_dp_mc_matriculas #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
    });
  }

  $('#vw_md_historial_mat').on('hidden.bs.modal', function (e) {
    $('#vw_md_historial_mat .tbdatatable tbody').html("");
  })





</script>