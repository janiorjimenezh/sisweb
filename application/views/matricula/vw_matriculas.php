<?php
$vbaseurl=base_url();
date_default_timezone_set('America/Lima');
$vuser=$_SESSION['userActivo'];
$fechahoy = date('Y-m-d');

?>
<div class="content-wrapper">
  <?php $this->load->view('tesoreria/cronograma/vw_modal_cronogramaLista'); ?>
  <?php include("vw_matriculas_modals_matricular.php") ?>
  <?php include("vw_matriculas_modals.php") ?>
  <?php include("vw_matriculas_modals_boletanotas.php") ?>
  <section id="s-cargado" class="content pt-1">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-matriculas-tab" data-toggle="tab" href="#nav-matriculas" role="tab" aria-controls="nav-matriculas" aria-selected="true">Matrículas</a>
        <?php if (getPermitido("42") == "SI") { ?>
        <a class="nav-item nav-link" id="nav-grupos-tab" data-toggle="tab" href="#nav-grupos" role="tab" aria-controls="nav-grupos" aria-selected="false">Grupos</a>
        <?php } ?>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-matriculas" role="tabpanel" aria-labelledby="nav-matriculas-tab">
        <div id="divcard-matricular" class="card">

          <div class="card-body">
            
                <form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>matricula/fn_filtrar" method="post" accept-charset='utf-8'>
                  <div class="row">
                    <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
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
                    <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
                        <option value="%"></option>
                        <?php foreach ($periodos as $periodo) {?>
                        <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbperiodo"> Periodo</label>
                    </div>
                    
                    <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
                        <option value="%"></option>
                        <?php foreach ($carreras as $carrera) {?>
                        <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbcarrera"> Prog. de Estudios</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
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
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Semestre" >
                        <option value="%"></option>
                        <?php foreach ($ciclos as $ciclo) {?>
                        <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbciclo">Semestre</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                        <option value="%"></option>
                        <?php foreach ($turnos as $turno) {?>
                        <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbturno"> Turno</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                        <option value="%"></option>
                        <?php foreach ($secciones as $seccion) {?>
                        <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbseccion"> Sección</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-sm-1">
                      <select data-currentvalue="" class="form-control form-control-sm" id="fmt-cbestado" name="fmt-cbestado" required="">
                        <option value="%"></option>
                        <?php foreach ($estados as $estado) {?>
                        <option value="<?php echo $estado->codigo ?>"><?php echo $estado->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbestado"> Estado</label>
                    </div>
                    <div class="form-group has-float-label col-12  col-md-2">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbbeneficio" name="fmt-cbbeneficio" placeholder="Periodo" required >
                         <option value="%"></option>
                        <?php foreach ($beneficios as $beneficio) {?>
                        <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbbeneficio"> Beneficio</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-3 col-md-3">
                      <input class="form-control text-uppercase form-control-sm" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
                      <label for="fmt-alumno"> Carné o Apellidos y nombres
                      </label>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="form-group has-float-label col-6 col-md-6 col-sm-2">
                                <input type="date" name="fmt-txtfecha_emision" id="fmt-txtfecha_emision" class="form-control form-control-sm">
                                <label for="fmt-txtfecha_emision">Fecha Inicio</label>
                            </div>
                            <div class="form-group has-float-label col-6 col-md-6 col-sm-2">
                                <input type="date" name="fmt-txtfecha_emisionf" id="fmt-txtfecha_emisionf" class="form-control form-control-sm">
                                <label for="fmt-txtfecha_emisionf">Fecha Final</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-2 col-md-2">
                      <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>

                      <div class="btn-group">
                        <button class="btn-excel btn btn-outline-success btn-sm py-0" type="button">
                          <img height="20px"  src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> 
                        </button>
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Split</span>
                        </button>
                        <div class="dropdown-menu">
                          <a href="#" class="btn_campos dropdown-item py-0">
                            <img height="20px" src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" alt=""> Otros Campos
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="col-12 px-0 pt-2 table-responsive">
                  <div class="alert alert-danger alert-dismissible fade show" id="vw_mt_divmensaje" role="alert">
                    <span id="vw_mt_spanmensaje"></span>
                  </div>
                  <table id="tbmt_dtMatriculados" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                  <thead>
                      <tr class="bg-lightgray">
                          <th>N°</th>
                          <th>FIL.</th>
                          <th>CARNÉ</th>
                          
                          <th>Estudiante / Edad</th>
                          <th>Fec.Mat.</th>
                          <th>CUOTA</th>
                          <th>Plan</th>
                          <th>CRONOG.</th>
                          <th>Grupo</th>
                          <th>Est.</th>
                          <!--<th title="ABIERTO"><i class="far fa-folder-open"></i></th>
                          <th title="VISIBLE"><i class="far fa-eye"></i></th>
                          <th>Cd</th>
                          <th>Hr</th>
                          <th title="ENROLADOS"><i class="fas fa-user-friends"></i></th>-->
                          <th>Ficha</th>
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
      <?php if (getPermitido("42") == "SI") { ?>
      <div class="tab-pane fade" id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">
        <div id="divboxhistorial" class="card">
          <div class="card-body">
            <form id="frmfiltro-grupos" name="frmfiltro-grupos" action="<?php echo $vbaseurl ?>grupos/fn_filtrar" method="post" accept-charset='utf-8'>
              <div class="row">
                <div class="form-group has-float-label col-12 col-sm-4 col-md-1">
                  <select  class="form-control form-control-sm" id="fm-cbsede" name="fm-cbsede" placeholder="Filial">
                    <option value="%"></option>
                    <?php 
                      foreach ($sedes as $filial) {
                        $select=($vuser->idsede==$filial->id) ? "selected":"";
                        echo "<option $select value='$filial->id'>$filial->nombre</option>";
                      }
                    ?>
                  </select>
                  <label for="fm-cbsede"> Filial</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2 col-md-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbperiodo" name="fm-cbperiodo" placeholder="Periodo" required >
                    <option value="%"></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbperiodo"> Periodo</label>
                </div>
                
                <div class="form-group has-float-label col-12 col-sm-3">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbcarrera" name="fm-cbcarrera" placeholder="Programa Académico" required >
                    <option value="%"></option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbcarrera"> Programa Académico</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                  <select name="fm-cbplan" id="fm-cbplan"class="form-control form-control-sm">
                    <option data-carrera="0" value="%">Todos</option>
                    <option data-carrera="0" value="0">Sin Plan</option>
                    <?php foreach ($planes as $pln) {
                    echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                    } ?>
                  </select>
                  <label for="fm-cbplan">Plan estudios</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-1">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbciclo" name="fm-cbciclo" placeholder="SEM." required >
                    <option value="%"></option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbciclo"> SEM.</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2 col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbturno" name="fm-cbturno" placeholder="Turno" required >
                    <option value="%"></option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-1">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbseccion" name="fm-cbseccion" placeholder="Secc." required >
                    <option value="%"></option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbseccion"> Secc.</label>
                </div>
                <div class="col-12  col-sm-1">
                  <button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>


           
            <div class="col-12 px-0 pt-2 table-responsive">
             
              <table id="tbmt_dtGrupos" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
                <thead>
                  <tr class="bg-lightgray">
                    <th>N°</th>
                    <th>SEDE</th>
                    <th>PERIODO</th>
                    <th>CRONOGRAMA</th>
                    <th>PLAN</th>
                    <th>PROGR.</th>
                    <th>SEM.</th>
                    <th>TUR.</th>
                    <th>SEC.</th>
                    <th>MAT.</th>
                    <th>ACT.</th>
                    <th>PRY.</th>
                    <th>RET.</th>
                    <th>CUL.</th>
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
      <?php } ?>
    </div>
    
  </section>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>

<!--<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>-->
<script>
var vpermiso151 = '<?php echo getPermitido("151") ?>';
var vpermiso172 = '<?php echo getPermitido("172") ?>';
var vpermiso173 = '<?php echo getPermitido("173") ?>';
var vpermiso177 = '<?php echo getPermitido("177") ?>';

var cd1 = '<?php echo base64url_encode("1") ?>';
var cd2 = '<?php echo base64url_encode("2") ?>';
var cd7 = '<?php echo base64url_encode("7") ?>';

var cd2de = "<?php echo base64url_encode("ANULADO") ?>";

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
        /*if (tabla.table().node().id=="tbmt_dtEstutiantesEnrolados"){
            tabla.button(1).enable( true);
        }*/
    }
});


$('#frmfiltro-matriculas #fmt-cbcarrera').change(function(event) {
    var codcar = $(this).val();
    if (codcar == "%") {
        $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i) {
            if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
        });
    } else {
        $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i) {
            if ($(this).data('carrera') == '0') {
                //if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
            } else if ($(this).data('carrera') == codcar) {
                $(this).removeClass('ocultar');
            } else {
                if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
            }
        });
    }
});

$(".btn-excel").click(function(e) {
    e.preventDefault();
    /*$('#frm-filtro-inscritos input,select').removeClass('is-invalid');
    $('#frm-filtro-inscritos .invalid-feedback').remove();*/
    var url = base_url + 'academico/matriculas/excel?cp=' + $("#fmt-cbperiodo").val() + '&cc=' + $("#fmt-cbcarrera").val() + '&ccc=' + $("#fmt-cbciclo").val() + '&ct=' + $("#fmt-cbturno").val() + '&cs=' + $("#fmt-cbseccion").val() + '&cpl=' + $("#fmt-cbplan").val() + '&ap=' + $("#fmt-alumno").val() + '&es=' + $("#fmt-cbestado").val() + '&sed=' + $("#fmt-cbsede").val() + '&benf=' + $("#fmt-cbbeneficio").val();
    var ejecuta = true;
    
    if (ejecuta == true) window.open(url, '_blank');
});

$("#frmfiltro-matriculas").submit(function(event) {
    filtrar = 0;
    if ($("#fmt-cbsede").val() != "%") filtrar++;
    if ($("#fmt-cbperiodo").val() != "%") filtrar++;
    if ($("#fmt-cbcarrera").val() != "%") filtrar++;
    if ($("#fmt-cbplan").val() != "%") filtrar++;
    if ($("#fmt-cbciclo").val() != "%") filtrar++;
    if ($("#fmt-cbturno").val() != "%") filtrar++;
    if ($("#fmt-cbseccion").val() != "%") filtrar++;
    if ($("#fmt-cbestado").val() != "%") filtrar++;
    if ($("#fmt-cbbeneficio").val() != "%") filtrar++;
    if ($.trim($("#fmt-alumno").val()).length > 3) filtrar++;
    tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
    tbmatriculados.clear();
    $("#vw_mt_divmensaje").hide();
    if (filtrar > 1) {

        $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

        $.ajax({
            url: $(this).attr("action"),
            type: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(e) {
                if (e.status == false) {} else {
                    var nro = 0;
                    var mt = 0;
                    var ac = 0;
                    var rt = 0;
                    var cl = 0;

                    $.each(e.vdata, function(index, v) {
                        nro++;
                        var vcm = v['codmatricula64'];
                        var url = base_url + "academico/matricula/imprimir/" + vcm;
                        var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
                        var btnscolor = "";
                        var btnactcondi = "";
                        var btnupdatem = "";
                        var btnview_deudas = "";
                        var btndownload_ficha = "";
                        var btndownload_record = "";
                        var btnview_boleta = "";
                        var btnEliminarMatricula="";
                        var textobs = (v['observacion']!= "") ? v['observacion'] : "Ninguna";
                        var observacion = "<br><b>Observación:</b><br>"+textobs;
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

                        if (vpermiso172 == "SI" && v['estado'] == "DES" && v['condicional'] == "NO") {
                          var btnactcondi = '<a href="#" target="_blank" class="dropdown-item" onclick="fn_activa_matcondicional($(this));return false;" data-codigo="'+vcm+'" data-estado="SI"><i class="fas fa-check-circle mr-2"></i>Activa Condicional</a>';
                        }

                        if (e.vpermiso179 == "SI") {
                          btnupdatem = '<a href="#" data-cm=' + vcm + ' data-carne=' + v['carne'] + ' data-accion="EDITAR" class="dropdown-item text-success" data-toggle="modal" data-target="#modupmat"><i class="fas fa-edit mr-2"></i>Edita matricula</a>';
                        }

                        if (e.vpermiso105 == "SI") {
                          btnview_deudas = '<a href="#" onclick="fn_historial_vw_deudas($(this));return false;" class="dropdown-item text-success" data-programa="'+ v['carrera'] +'" data-periodo="' + v['periodo'] + '" data-ciclo="' + v['ciclo'] + '" data-turno="' + v['codturno'] + '" data-seccion="' + v['codseccion'] + '" data-plan="' + v['plan'] + '"><i class="fas fa-money-bill-alt mr-2"></i>Deudas</a>';
                        }

                        if (e.vpermiso200 == "SI") {
                          btndownload_ficha = '<a target="_blank" href="' + url + '" class="dropdown-item"><i class="far fa-file-pdf text-danger mr-2"></i>PDF</a>' +
                            '<a href="' + base_url + 'academico/matricula/ficha/excel/' + vcm + '" class="dropdown-item" ><i class="far fa-file-excel text-success mr-2"></i>Excel</a>';
                        }

                        if (e.vpermiso201 == "SI") {
                          btndownload_record = '<a href="'+base_url+'academico/matricula/record-academico/excel/'+v['carne']+'" target="_blank" class="dropdown-item"><i class="fas fa-graduation-cap mr-2"></i>Récord académico</a>' +
                              '<a href="'+base_url+'academico/matricula/record-academico/pdf/'+v['carne']+'" target="_blank" class="dropdown-item text-info"><i class="fas fa-graduation-cap mr-2"></i>Récord académico (pdf)</a>';
                        }

                        if (e.vpermiso202 == "SI") {
                          btnview_boleta = '<a onclick="vw_abrir_modal_boletanotas($(this));return false;"  title="Ver Boleta de notas" class="bg-success text-white py-1 px-2 mr-1 rounded"  href="#">' +
                            '<i class="fas fa-book"></i>' +
                            '</a>';
                        }
                        
                        sexo = (v['codsexo'] == "FEMENINO") ? "<i class='fas fa-female text-danger mr-1'></i>" : "<i class='fas fa-male text-primary mr-1'></i>";
                        nomestudiante = v['paterno'] + " " + v['materno'] + " " + v['nombres'];
                        estudiante = sexo + nomestudiante + " " + v['edad'];
                        textfecregistro = "<br><b>Registrado el:</b> " + v['registro'] + " " + v['regishora'];
                        textcuotareal = "<br> <b>Cuota real:</b> " + v['vrepension'];
                        fecharegistro = v['registro'] + " <a href='#' class='view_user_reg' tabindex='0' role='button' data-toggle='popover' data-trigger='hover' title='Matriculado por: ' data-content='"+v['usuario']+textfecregistro+observacion+textcuotareal+"'><i class='fas fa-info-circle fa-lg'></i></a>";
                        vcuota = v['vpension'] + " ("+v['beneficio']+")";
                        grupo = v['periodo'] + " " + v['sigla'] + " " + v['codturno'] + " " + v['ciclo'] + " " + v['codseccion'];
                        // boleta = ;
                        if (e.vpermiso240=="SI"){
                          btnEliminarMatricula='<div class="dropdown-divider"></div>' +
                            '<a href="#" onclick="fn_eliminar_matricula($(this));return false;" class="dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>';
                        }
                        
                        if ((e.vpermiso178 == "NO") || (v['estado']=="PRO")) {
                            //dropdown_estado = '<small class="badge '+btnscolor+' p-2"> '+ v['estado'] +'</small>';
                             dropdown_estado = '<div class="btn-group btn-group-sm">' +
                            '<button class="btn ' + btnscolor + ' btn-sm text-sm dropdown-toggle py-0 px-1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="estado'+vcm+'">' +
                            v['estado'] +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                              btnEliminarMatricula + 
                            '</div>' +
                            '</div>';
                        }
                        else{
                            dropdown_estado = '<div class="btn-group btn-group-sm">' +
                            '<button class="btn ' + btnscolor + ' btn-sm text-sm dropdown-toggle py-0 px-1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="estado'+vcm+'">' +
                            v['estado'] +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="dropdown-item" data-campo="tabla" data-ie="' + cd1 + '">Activo</a>' +
                            '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="dropdown-item" data-campo="tabla" data-ie="' + cd2 + '" data-pagante="'+v['carne']+'" data-pagantenb="'+nomestudiante+'" data-programa="'+ v['carrera'] +'" data-periodo="' + v['periodo'] + '" data-ciclo="' + v['ciclo'] + '" data-turno="' + v['codturno'] + '" data-seccion="' + v['codseccion'] + '" data-plan="' + v['plan'] + '">Retirado</a>' +
                            '<a href="#" onclick="fn_cambiarestado($(this));return false;" class="dropdown-item" data-campo="tabla" data-ie="' + cd7 + '">Desaprobado</a>' +
                              btnEliminarMatricula + 
                            '</div>' +
                            '</div>';
                        }
                            
                         
                        

                        dropdown_imprimir = '<div class="btn-group dropleft">' +
                            '<button class="btn btn-info btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="fas fa-print fa-sm"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                              btndownload_ficha+
                            ' </div>' +
                            '</div>';
                        dropdown_opciones='<div class="btn-group btn-group-sm p-0 dropleft">' +
                            '<button class="btn btn-info btn-sm dropdown-toggle py-0 rounded" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="fas fa-cog"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +

                              '<a class="dropdown-item" data-cm='+ vcm +' data-plan="'+v['plan']+'" data-stdnt="'+ v['carne'] +" / "+ v['paterno'] + " " + v['materno'] + " " + v['nombres'] +'" href="#" title="Carga académica" onclick="fn_carga_mat_estudiante($(this));return false;"><i class="fas fa-book"></i> Carga</a>'+

                              btnupdatem +
                              btndownload_record+
                              btnactcondi +
                              btnview_deudas +
                            '</div>' +
                          '</div>' ;
                        /*dropdown='<div class="btn-group">' + 
                                   '<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cog"></i> </button>' + 
                                   '<div class="dropdown-menu">' +
                                     '<a onclick="vw_abrir_modal($(this))" class="dropdown-item" data-tabula="evaluaciones" href="#">Evaluaciones</a>' + 
                                   '</div>' +
                                 '</div>';*/
                        vcronograma=v['calendario'];
                        var fila = tbmatriculados.row.add([index + 1, v['sede_abrevia'], v['carne'], estudiante, fecharegistro, vcuota, v['plan'], vcronograma,grupo, dropdown_estado, dropdown_imprimir, btnview_boleta + dropdown_opciones]).node();
                        $(fila).attr('data-codmatricula64', v['codmatricula64']);
                        $(fila).attr('data-estudiante', nomestudiante);
                        $(fila).attr('data-carnet', v['carne']);

                        //$(fila).attr('data-carnet', v['carne']);

                       
                        $(fila).attr('data-codcronograma64', v['codcalendario64']);
                        $(fila).attr('data-codperiodo', v['codperiodo']);
                        $(fila).attr('data-codcarrera', v['codcarrera']);
                        $(fila).attr('data-codciclo', v['codciclo']);
                        $(fila).attr('data-codplan', v['codplan']);
                        $(fila).attr('data-codturno', v['codturno']);
                        $(fila).attr('data-codseccion', v['codseccion']);
                        $(fila).attr('data-periodo', v['periodo']);
                        $(fila).attr('data-carrera', v['carrera']);
                        $(fila).attr('data-ciclo', v['ciclo']);
                        $(fila).attr('data-plan', v['plan']);
                        $(fila).attr('data-estado_abrevia', v['estado']);
                        $(fila).attr('data-estado', v['matriculaestado']);
                        


                        $(fila).attr('data-coperiodo', v['codperiodo']);
                        $(fila).attr('data-cocarrera', v['codcarrera']);
                        $(fila).attr('data-cociclo', v['codciclo']);
                        $(fila).attr('data-cturno', v['codturno']);
                        $(fila).attr('data-cseccion', v['codseccion']);
                        $(fila).attr('data-cperiodo', v['periodo']);
                        $(fila).attr('data-ccarrera', v['carrera']);
                        $(fila).attr('data-cciclo', v['ciclo']);
                        $(fila).attr('data-codmatricula', v['codmatricula']);
                        // $(fila).attr('data-cturno', v['turno']);
                        // $(fila).attr('data-cseccion', v['seccion']);
                        $(fila).addClass('cfila_mt');
                    });

                    tbmatriculados.draw();
                    $('#divcard-matricular #divoverlay').remove();

                    $('.view_user_reg').popover({
                      trigger: 'hover',
                      html: true
                    })

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divcard-matricular #divoverlay').remove();
                //$('#divError').show();
                //$('#msgError').html(msgf);
            }
        });
    } else {
        $("#vw_mt_divmensaje").show();
        $("#vw_mt_spanmensaje").html("Se requiere como mínimo 3 parámetros de búsqueda");
    }

    return false;
});

//$("#frm-matricular").hide();
$("#frm-getinscrito").submit(function(event) {
    $('#frm-getinscrito input').removeClass('is-invalid');
    $('#frm-getinscrito .invalid-feedback').remove();
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
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
                $('#fm-txtid').val(e.vdata['idinscripcion']);
                $("#frm-matricular")[0].reset();
                if (e.vdata['idinscripcion'] == '0') {
                    $('#fgi-apellidos').html('NO ENCONTRADO');
                    $('#fgi-nombres').html('NO ENCONTRADO');
                    $('#fm-txtcarrera').val("");
                    $('#fm-carrera').val("PROGRAMA ACADÉMICO");
                    $('#fm-cbplan').html("<option value='0'>Plán curricular NO DISPONIBLE</option>");
                    //$("#frm-matricular").hide();
                } else {
                    //$('#fitxtdni').val(e.vdata['dni']);
                    $('#fgi-apellidos').html(e.vdata['paterno'] + ' ' + e.vdata['materno']);
                    $('#fgi-nombres').html(e.vdata['nombres']);
                    $('#fm-txtcarrera').val(e.vdata['codcarrera']);
                    $('#fm-carrera').html(e.vdata['carrera']);
                    $('#fm-cbplan').html(e.vplanes);
                    $('#fm-cbplan').val(e.vdata['codplan']);
                    $('#fm-txtplan').val(e.vdata['codplan']);
                    $('#fm-txtmapepat').val(e.vdata['paterno']);
                    $('#fm-txtmapemat').val(e.vdata['materno']);
                    $('#fm-txtmnombres').val(e.vdata['nombres']);
                    $('#fm-txtmsexo').val(e.vdata['sexo']);
                    //$("#frm-matricular").show();
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            $('#divError').show();
            $('#msgError').html(msgf);
        }
    });
    return false;
});

$("#btn-cancelar").click(function(event) {
    $("#frm-matricular")[0].reset();
});

$("#frm-matricular").submit(function(event) {
    /* Act on the event */
    $('#frm-matricular input,select').removeClass('is-invalid');
    $('#frm-matricular .invalid-feedback').remove();
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
            if (e.status == false) {
                if (e.newcod == 0) {
                    Swal.fire({
                        type: 'warning',
                        title: 'Matrícula DUPLICADA',
                        text: e.msg,
                        backdrop: false,
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Error, matrícula NO registrada',
                        text: e.msg,
                        backdrop: false,
                    })
                    $.each(e.errors, function(key, val) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                    });
                }
            } else {
                //$("#fm-txtidmatricula").html(e.newcod);
                Swal.fire({
                    type: 'success',
                    title: 'Felcicitaciones, matrícula registrada',
                    text: 'Se han registrado cursos',
                    backdrop: false,
                })
                $("#vwtxtcodmat").val(base64url_encode(e.newcod));
                $("#divcarne").html("<h3>" + $("#fgi-txtcarne").val().toLowerCase() + "</h3>");
                $("#divmiembro").html($("#fgi-apellidos").html() + " " + $("#fgi-nombres").html());
                $("#divperiodo").html($("#fm-cbperiodo").val());
                $("#divcarrera").html($("#fm-carrera").html());
                $("#divciclo").html("Ciclo: " + $("#fm-cbciclo").val());
                $("#divturno").html("Turno: " + $("#fm-cbturno").val());
                $("#divseccion").html("Sección: " + $("#fm-cbseccion").val());
                $("#fud-cbperiodo").html($("#fm-cbperiodo option:selected").text());
                $("#fud-cbperiodo").data($("#fm-cbperiodo").val());
                mostrarCursos("divcard_data_carga", "", e.vdata);
                var url = base_url + "academico/matricula/imprimir/" + base64url_encode(e.newcod);
                $("#divcard_data_carga").append(
                    '<div class="cfilaprint row">' +
                    '<div class="col-12 col-md-12 text-right td"><a class="btn btn-info" target="_blank" href="' + url + '" title="Imprimir matrícula"><i class="fas fa-print mr-1"></i> Imprimir Matrícula</a></div>' +
                    '</div></div>');
                $('.nav-pills a[href="#fichacarga"]').tab('show');
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            Swal.fire({
                type: 'error',
                title: 'Error, matrícula NO registrada',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});

function comprobarcurso() {
    $("#divcard_data_carga .cfila").each(function(index) {
        var cc = $(this).data('cc');
        var cs = $(this).data('ccs');
        //alert(cc + cs);
        $("#divcard_data_cursos_disponibles .cfila").each(function(index2) {
            var ccd = $(this).data('cc');
            var csd = $(this).data('ccs');
            if ((cc == ccd) && (cs == csd)) {
                $(this).remove();
            }
        });
    });
}

function ordenarnro(div) {
    var nro = 0;
    $("#" + div + " .tdnro").each(function(index) {
        nro = nro + 1;
        $(this).html(nro);
    });
}

function mostrarCursos(div, vcm, vdata, agregar = 'no') {
    var vplan = "00";
    var nro = 0;
    $("#" + div).html("");
    $.each(vdata, function(index, v) {
        nro++;
        var mcidcarga = base64url_encode(v['idcarga']);
        jsbtnagregar = "";
        jsbtnretirar = "";
        if (vpermiso173 == "SI") {
          if (agregar == 'si') {
              var codcurso = base64url_encode(v['codcurso']);
              jsbtnagregar = '<button data-ccurso="' + codcurso + '" data-cc="' + mcidcarga + '"  data-cd="' + v['subseccion'] + '" data-cm="' + vcm + '" title="Enrolar" class="btn px-1 py-0 btn-enrolar btn-sm btn-primary"><i class="fas fa-book-medical"></i></button>';
          }
          
          if (agregar == 'no') {
              var midmiembro = base64url_encode(v['idmiembro']);
              jsbtnretirar = '<button   data-im="' + midmiembro + '"  title="Eliminar" class="btn px-1 py-0 btn-desenrolar btn-sm btn-danger"><i class="fas fa-minus-square"></i></button>';
          }
        }

        
        if (vplan != v['codplan'] + v['codmodulo']) {
            vplan = v['codplan'] + v['codmodulo'];
            $("#" + div).append(
                '<div class="row text-bold ">' +
                '<div class="col-12 col-md-12 td"> Plan: ' +
                v['codplan'] + " : Módulo N° " + v['nromodulo'] + " / " + v['modulo'] + " / " + v['carrera'] +
                '</div>' +
                '</div>');
        }
        if (v['paterno'] == null) v['paterno'] = "SIN";
        if (v['materno'] == null) v['materno'] = "DOCENTE";
        if (v['nombres'] == null) v['nombres'] = "";
        var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
        $("#" + div).append(
        '<div class="cfila row ' + rowcolor + ' " data-cc="' + mcidcarga + '" data-ccs="' + v['subseccion'] + '">' +
          '<div class="col-4 col-md-4">' +
            '<div class="row">' +
              '<div title="' + v['idmiembro'] + '" class="tdnro col-3 col-md-1 td">' + nro + '</div>' +
              '<div class="col-9 col-md-11 td">(' + v['idcarga'] + 'G' + v['subseccion'] + ') ' + v['curso'] + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="col-6 col-md-2">' +
            '<div class="row">' +
              '<div class="td col-6 col-md-6 text-center ">' + v['sede_abrevia'] +'</div>' +
              '<div class="td col-6 col-md-6 text-center ">' + v['sigla'] + ' ' + v['ciclo'] + ' - ' + v['codturno'] +' - ' + v['codseccion'] + v['subseccion'] + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="col-6 col-md-2">' +
            '<div class="row">' +
              '<div class="td col-2 col-md-4 text-center ">' + '1' + '</div>' +
              '<div class="td col-2 col-md-4 text-center ">' + (parseInt(v['hts']) + parseInt(v['hps'])) + '</div>' +
              '<div class="td col-2 col-md-4 text-center ">' + (parseInt(v['ct']) + parseInt(v['cp'])) + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="col-8 col-md-3 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
          '<div class="col-4 col-md-1">' + 
            '<div class="row">' + 
              '<div class="td col-2 col-md-12 text-center">' + 
                jsbtnagregar + jsbtnretirar + 
              '</div>' + 
            '</div>' + 
          '</div>' +
        '</div>');
    });
    //******************************************
    if (agregar == 'si') {
        $(".btn-enrolar").on("click", function() {
            $('#divmodcarga').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var codc = $(this).data('cc');
            var codm = $(this).data('cm');
            var codd = $(this).data('cd');
            var codcarne = $("#divcarne").find('H3').html();
            var codcurso = $(this).data('ccurso');
            var btnenr = $(this);
            var idm = "0";
            $.ajax({
                url: base_url + "miembros/fn_insert/SI",
                type: 'post',
                dataType: 'json',
                data: {
                    "fm-codcarga": codc,
                    "fm-codmatricula": codm,
                    "fm-division": codd,
                    "fm-carne": codcarne,
                    "fm-codcurso": codcurso,
                    "fm-idmiembro": idm
                },
                success: function(e) {
                    $('#divmodcarga #divoverlay').remove();
                    if (e.status == true) {
                        btnenr.parents(".cfila").appendTo('#divcard_data_carga');
                        $(".cfilaprint").appendTo('#divcard_data_carga');
                        ordenarnro("divcard_data_carga");
                        ordenarnro("divcard_data_cursos_disponibles");
                        //$('#divcard-matricular #divoverlay').remove();
                        Swal.fire({
                            type: 'success',
                            title: 'Éxito, enrolamiento realizado',
                            text: e.msg,
                            backdrop: false,
                        })
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divmodcarga #divoverlay').remove();
                    Swal.fire({
                        type: 'error',
                        title: 'Error, no se pudo mostrar los curso Matriculados',
                        text: msgf,
                        backdrop: false,
                    })
                }
            });
        });
    } else {
        $(".btn-desenrolar").on("click", function() {
            $('#divmodcarga').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
            var alumno = $("#divmiembro").html();
            var btndes = $(this);
            //************************************
            Swal.fire({
                title: "Precaución",
                text: "Se eliminarán las notas y asistencias del alumno " + alumno + ", en este curso: ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.value) {
                    var codc = $(this).data('im');
                    $.ajax({
                        url: base_url + "miembros/fn_eliminar",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "fm-idmiembro": codc
                        },
                        success: function(e) {
                            $('#divmodcarga #divoverlay').remove();
                            if (e.status == true) {
                                btndes.parents(".cfila").remove();
                                ordenarnro("divcard_data_carga");
                                
                                Swal.fire({
                                    type: 'success',
                                    title: 'Éxito,  realizado',
                                    text: e.msg,
                                    backdrop: false,
                                })
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error, NO se pudo realizar la eliminación',
                                    text: e.msg,
                                    backdrop: false,
                                })
                            }
                        },
                        error: function(jqXHR, exception) {
                            $('#divmodcarga #divoverlay').remove();
                            var msgf = errorAjax(jqXHR, exception, 'text');
                            Swal.fire({
                                type: 'error',
                                title: 'Error, NO se pudo realizar la eliminación',
                                text: e.msgf,
                                backdrop: false,
                            })
                        }
                    })
                } else {
                    $('#divmodcarga #divoverlay').remove();
                }
            });
            //***************************************
        });
    }
}

$("#frmfiltro-unidades").submit(function(event) {
    $("#btn-vercurricula").show();
    $('#divcard_data_cursos_disponibles').html("");
    $('#divmodcarga').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    //$("#divcard_grupo select").prop('disabled', false);
    var fdata = new Array();
    fdata.push({
        name: 'periodo',
        value: $("#fud-cbperiodo").data('cp')
    });
    fdata.push({
        name: 'carrera',
        value: $("#fud-cbcarrera").val()
    });
    fdata.push({
        name: 'plan',
        value: $("#fud-cbplan").val()
    });
    fdata.push({
        name: 'ciclo',
        value: $("#fud-cbciclo").val()
    });
    fdata.push({
        name: 'turno',
        value: $("#fud-cbturno").val()
    });
    fdata.push({
        name: 'seccion',
        value: $("#fud-cbseccion").val()
    });
    var vcm = $("#vwtxtcodmatcrg").val();
    $.ajax({
        url: base_url + 'cargasubseccion/fn_filtrar',
        type: 'post',
        dataType: 'json',
        data: fdata,
        success: function(e) {
            $('#divmodcarga #divoverlay').remove();
            mostrarCursos('divcard_data_cursos_disponibles', vcm, e.vdata, 'si');
            comprobarcurso();
            ordenarnro('divcard_data_cursos_disponibles');
            //.html(e.vdata);
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            Toast.fire({
                type: 'warning',
                title: 'Aviso: ' + msgf
            })
            $('#divcard_data_cursos_disponibles').html("");
            $('#divmodcarga #divoverlay').remove();
        }
    });
    return false;
});

$("#fud-cbcarrera").change(function(event) {
    /* Act on the event */
    if ($(this).val() != "%") {
        $('#fud-cbplan').html("<option value='%'>Sin opciones</option>");
        var codcar = $(this).val();
        if (codcar == '%') return;
        $.ajax({
            url: base_url + 'plancurricular/fn_get_planes_activos_combo',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodcarrera: codcar
            },
            success: function(e) {
                $('#fud-cbplan').html(e.vdata);
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fud-cbplan').html("<option value='%'>" + msgf + "</option>");
            }
        });
    } else {
        $('#fud-cbplan').html("<option value='%'>Seleciona un carrera<option>");
    }
});


function vw_abrir_modal_boletanotas(boton){

    fila = boton.closest(".cfila_mt");
    var codmatricula64 = fila.data('codmatricula64');
    $("#vwbn_txtcodmatricula64").val(codmatricula64);
    $('#vw_mat_modBoletaNotas').modal('show');
    return false;
    
}

// $('#vw_mat_modBoletaNotas').on('show.bs.modal', function(e) {
//     var rel = $(e.relatedTarget);
//     var codigo = rel.data('cm');
//     var programa = rel.data('prog');
//     var periodo = rel.data('periodo');
//     var ciclo = rel.data('ciclo');
//     var turno = rel.data('turno');
//     var seccion = rel.data('seccion');
//     $('#fmt-cbncodmatricula').val(codigo);
//     $('#vw_dp_em_btnimp_boleta').attr('href', base_url + "academico/matricula/independiente/boleta/imprimir/" + codigo);
//     $('#fmt-cbncarrera').val(programa);
//     $('#fmt-cbnperiodo').val(periodo);
//     $('#fmt-cbnciclo').val(ciclo);
//     $('#fmt-cbnturno').val(turno);
//     $('#fmt-cbnseccion').val(seccion);
//     $('#fmt-cbncarrera').change();
//     get_matriculas_cursos(codigo,"SI");
    
// });

$('#vw_mat_modBoletaNotas').on('hidden.bs.modal', function(e) {
    $('#divcard_datamat').removeClass('d-none');
    $('#divcard_form_new').addClass('d-none');
    $('#btn_agregarnew').removeClass('d-none');
    $('#btncancelar').addClass('d-none');
    $('#fmt-cbncodmatcurso').val('0');
    $('#form_addmatricula')[0].reset();
    get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
    //$('#vw_dp_em_btnguardar').show();
    $('#vw_dp_mdcarga_footer_boleta').show();
    $('#divcontent_convalida').addClass('d-none');
})



function get_unidades(ciclo, plan) {
  $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    if ($('#' + ciclo).val() != "0" && $('#' + plan).val() != "0") {
        
        $('#fmt-cbnunididact').html("<option value='0'>Sin opciones</option>");
        var ciclo = $('#' + ciclo).val();
        var plan = $('#' + plan).val();
        if (ciclo == '0' && plan == '0') return;
        $.ajax({
            url: base_url + 'unidaddidactica/fn_get_unidades_combo',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodciclo: ciclo,
                txtcodplan: plan,
            },
            success: function(e) {
                $('#divmodalnewmatricula #divoverlay').remove();
                $('#fmt-cbnunididact').html(e.vdata);
                $("#fmt-cbnunididact").val(getUrlParameter("cpl", 0));
            },
            error: function(jqXHR, exception) {
                $('#divmodalnewmatricula #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fmt-cbnunididact').html("<option value='0'>" + msgf + "</option>");
            }
        });
    } else {
        $('#fmt-cbnunididact').html("<option value='0'>Selecciona un plan curricular y ciclo<option>");
        $('#divmodalnewmatricula #divoverlay').remove();
    }
}

$('#form_addmatricula').submit(function() {
    $('#form_addmatricula input,select').removeClass('is-invalid');
    $('#form_addmatricula .invalid-feedback').remove();
    $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    // $("#div-filtro").html("");
    $.ajax({
        url: base_url + 'matricula_independiente/fn_insert_update',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            $('#divmodalnewmatricula #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'Error!',
                    text: 'Existen errores en los campos',
                    backdrop: false,
                })
            } else {
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Éxito!',
                    text: e.msg,
                    backdrop: false,
                }).then((result) => {
                    if (result.value) {
                        // $('#modmatriculacurso').modal('hide');
                        //get_matriculas_cursos(e.idmatricula);
                        get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
                        $('#divcard_datamat').removeClass('d-none');
                        $('#divcard_form_new').addClass('d-none');
                        $('#btn_agregarnew').removeClass('d-none');
                        $('#btncancelar').addClass('d-none');
                        //$('#vw_dp_em_btnguardar').show();
                        $('#vw_dp_mdcarga_footer_boleta').show();
                        $('#divcontent_convalida').addClass('d-none');
                    }
                })
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalnewmatricula #divoverlay').remove();
            Swal.fire({
                type: 'error',
                icon: 'error',
                title: 'Error!',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
});

$(document).on("click", ".editmatcurso", function() {
    var codigo = $(this).data('idmatc');
    //$('#vw_dp_em_btnguardar').hide();
    $('#vw_dp_mdcarga_footer_boleta').hide();
    $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula_independiente/fn_get_matriculacurso_codigo',
        type: 'post',
        dataType: 'json',
        data: {
            txtcodigo: codigo,
        },
        success: function(e) {
            if (e.status == true) {
                $('#divcard_datamat').addClass('d-none');
                $('#divcard_form_new').removeClass('d-none');
                $('#btn_agregarnew').addClass('d-none');
                $('#btncancelar').removeClass('d-none');
                $('#fmt-cbncodmatricula').val(e.vdata['codmatric64']);
                $('#fmt-cbncargaacadem').val(e.vdata['idcarga']);
                $('#fmt-cbncargaacadsubsec').val(e.vdata['codsubsec']);
                $('#fmt-cbtipo').val(e.vdata['tipo']);
                $('#fmt-cbnperiodo').val(e.vdata['idperiodo']);
                $('#fmt-cbncarrera').val(e.vdata['idcarrera']);
                $('#fmt-cbnplan').val(e.vdata['codplan']);
                $('#fmt-cbnciclo').val(e.vdata['idciclo']);
                $('#fmt-cbnturno').val(e.vdata['idturno']);
                $('#fmt-cbnseccion').val(e.vdata['idseccion']);
                $('#fmt-cbnfecha').val(e.vdata['fechaf']);
                $('#fmt-cbndocente').val(e.vdata['codocente']);
                $('#fmt-cbnresolucion').val(e.vdata['valida']);
                $('#fmt-cbnobservacion').val(e.vdata['observacion']);
                $('#fmt-cbnnotafinal').val(e.vdata['notaf']);
                $('#fmt-cbncodmatcurso').val(e.vdata['codigo64']);
                if (e.vdata['vfecha'] !== null) {
                    $('#fmt-cbnfechaconv').val(e.vdata['vfecha']);
                }
                if (e.vdata['notar'] !== null) {
                    $('#fmt-cbnnotarecup').val(e.vdata['notar']);
                }
                setTimeout(function() {
                    get_unidades('fmt-cbnciclo', 'fmt-cbnplan');
                }, 500);
                setTimeout(function() {
                    $('#fmt-cbnunididact').val(e.vdata['idunidad']);
                    $('#divmodalnewmatricula #divoverlay').remove();
                }, 1000);
                $('#fmt-cbtipo').change();
            }
        },
        error: function(jqXHR, exception) {
            $('#divmodalnewmatricula #divoverlay').remove();
            var msgf = errorAjax(jqXHR, exception, 'text');
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








$('#fmt-cbtipo').change(function(event) {
    var item = $(this);
    var tipo = item.find(':selected').data('tipo');
    if (tipo === "CONVALIDA") {
        $('#divcontent_convalida').removeClass('d-none');
    } else {
        $('#divcontent_convalida').addClass('d-none');
    }
});




$('#btn_agregarnew').click(function() {
    $('#divcard_datamat').addClass('d-none');
    $('#divcard_form_new').removeClass('d-none');
    $('#btn_agregarnew').addClass('d-none');
    $('#btncancelar').removeClass('d-none');
    $('#vw_dp_mdcarga_footer_boleta').hide();
});

$('#btncancelar').click(function() {
    $('#divcard_datamat').removeClass('d-none');
    $('#divcard_form_new').addClass('d-none');
    $('#btn_agregarnew').removeClass('d-none');
    $('#btncancelar').addClass('d-none');
    $('#fmt-cbncodmatcurso').val('0');
    $('#vw_dp_mdcarga_footer_boleta').show();
    $('#divcontent_convalida').addClass('d-none');
    $('#form_addmatricula')[0].reset();
});

$('.btn_campos').click(function(e) {
    e.preventDefault();
    $('#modexport').modal('show');
});

$('#fmt-cbncarrera').change(function(event) {
    if ($(this).val() != "0") {
        $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $('#fmt-cbnplan').html("<option value='0'>Sin opciones</option>");
        var codcar = $(this).val();
        if (codcar == '0') return;
        $.ajax({
            url: base_url + 'plancurricular/fn_get_planes_activos_combo',
            type: 'post',
            dataType: 'json',
            data: {
                txtcodcarrera: codcar
            },
            success: function(e) {
                $('#divmodalnewmatricula #divoverlay').remove();
                $('#fmt-cbnplan').html(e.vdata);
                $("#fmt-cbnplan").val(getUrlParameter("cpl", 0));
            },
            error: function(jqXHR, exception) {
                $('#divmodalnewmatricula #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#fmt-cbnplan').html("<option value='0'>" + msgf + "</option>");
            }
        });
    } else {
        $('#fmt-cbnplan').html("<option value='0'>Selecciona un programa<option>");
    }
});

$('#lbtn_exportar').click(function(e) {
    var urlExcel = base_url + 'academico/matriculas/campos/excel?cp=' + $("#fmt-cbperiodo").val() + '&cc=' + $("#fmt-cbcarrera").val() + '&ccc=' + $("#fmt-cbciclo").val() + '&ct=' + $("#fmt-cbturno").val() + '&cs=' + $("#fmt-cbseccion").val() + '&cpl=' + $("#fmt-cbplan").val() + '&ap=' + $("#fmt-alumno").val() + '&es=' + $("#fmt-cbestado").val() + '&sed=' + $("#fmt-cbsede").val() + '&benf=' + $("#fmt-cbbeneficio").val();
    checkcarne = ($("#checkcarnet").prop('checked') == true ? "&checkcarnet=SI" : "&checkcarnet=NO");
    checkapellidos = ($("#checkape").prop('checked') == true ? "&checkape=SI" : "&checkape=NO");
    checknombres = ($("#checknombres").prop('checked') == true ? "&checknombres=SI" : "&checknombres=NO");
    checkcorpo = ($("#checkcorpo").prop('checked') == true ? "&checkcorpo=SI" : "&checkcorpo=NO");
    checkacelulares = ($("#checkcelul").prop('checked') == true ? "&checkcelul=SI" : "&checkcelul=NO");
    checkcarrera = ($("#checkcarr").prop('checked') == true ? "&checkcarr=SI" : "&checkcarr=NO");
    checkciclo = ($("#checkcic").prop('checked') == true ? "&checkcic=SI" : "&checkcic=NO");
    checkturno = ($("#checkturn").prop('checked') == true ? "&checkturn=SI" : "&checkturn=NO");
    checkseccion = ($("#checksecc").prop('checked') == true ? "&checksecc=SI" : "&checksecc=NO");
    checkperiodo = ($("#checkper").prop('checked') == true ? "&checkper=SI" : "&checkper=NO");
    checkestado = ($("#checkest").prop('checked') == true ? "&checkest=SI" : "&checkest=NO");
    checkfecmat = ($("#checkfecmat").prop('checked') == true ? "&checkfecmat=SI" : "&checkfecmat=NO");
    checksexo = ($("#checksex").prop('checked') == true ? "&checksex=SI" : "&checksex=NO");
    checkfecnac = ($("#checkfecnac").prop('checked') == true ? "&checkfecnac=SI" : "&checkfecnac=NO");
    checkcorreo = ($("#checkcorper").prop('checked') == true ? "&checkcorper=SI" : "&checkcorper=NO");
    checkdomicilio = ($("#checkdomic").prop('checked') == true ? "&checkdomic=SI" : "&checkdomic=NO");
    checklengua = ($("#checkleng").prop('checked') == true ? "&checkleng=SI" : "&checkleng=NO");
    checkdepart = ($("#checkdepart").prop('checked') == true ? "&checkdepart=SI" : "&checkdepart=NO");
    checkprovin = ($("#checkprovin").prop('checked') == true ? "&checkprovin=SI" : "&checkprovin=NO");
    checkdistrito = ($("#checkdistri").prop('checked') == true ? "&checkdistri=SI" : "&checkdistri=NO");
    checkdiscap = ($("#checkdiscap").prop('checked') == true ? "&checkdiscap=SI" : "&checkdiscap=NO");
    checkplan = ($("#checkplan").prop('checked') == true ? "&checkplan=SI" : "&checkplan=NO");
    checkbeneficio = ($("#checkbeneficio").prop('checked') == true ? "&checkbeneficio=SI" : "&checkbeneficio=NO");
    checkdni = ($("#checkdni").prop('checked') == true ? "&checkdni=SI" : "&checkdni=NO");
    checkidinscripcion = ($("#checkidinscripcion").prop('checked') == true ? "&checkidinscripcion=SI" : "&checkidinscripcion=NO");
    checkedad = ($("#checkedad").prop('checked') == true ? "&checkedad=SI" : "&checkedad=NO");
    checkcuota = ($("#checkcuota").prop('checked') == true ? "&checkcuota=SI" : "&checkcuota=NO");
    checkcuotareal = ($("#checkcuotareal").prop('checked') == true ? "&checkcuotareal=SI" : "&checkcuotareal=NO");
    checkusermat = ($("#checkusuariomat").prop('checked') == true ? "&checkusermat=SI" : "&checkusermat=NO");
    checkboleta = ($("#checkboletamat").prop('checked') == true ? "&checkboleta=SI" : "&checkboleta=NO");
    checkcodigomat = ($("#checkcodigomat").prop('checked') == true ? "&checkcodigomat=SI" : "&checkcodigomat=NO");

    checkcolsecun = ($("#checkcolsecun").prop('checked') == true ? "&checkcolsecun=SI" : "&checkcolsecun=NO");
    checktiposecun = ($("#checktiposecun").prop('checked') == true ? "&checktiposecun=SI" : "&checktiposecun=NO");
    checkaniosecun = ($("#checkaniosecun").prop('checked') == true ? "&checkaniosecun=SI" : "&checkaniosecun=NO");

    var url = urlExcel + checkcarne + checkapellidos + checknombres + checkcorpo + checkacelulares + checkcarrera + checkciclo + checkturno + checkseccion + checkperiodo + checkestado + checkfecmat + checksexo + checkfecnac + checkcorreo + checkdomicilio + checklengua + checkdepart + checkprovin + checkdistrito + checkdiscap + checkplan + checkbeneficio + checkdni + checkidinscripcion + checkedad + checkcuota + checkcuotareal + checkusermat +checkboleta + checkcodigomat + checkcolsecun + checktiposecun + checkaniosecun;
    var ejecuta = true;

    if (ejecuta == true) window.open(url, '_blank');
});

$(document).ready(function() {
    var vtab = getUrlParameter('ts');
    
    if (vtab == "grp") {
      $('.nav-tabs a[href="#nav-grupos"]').tab('show');
    }
    
    rowtable="";
    
    if (vpermiso177 == "SI") {
      btnaddmatricula = true;
      rowtable="<'row'<'col-sm-8'B><'col-sm-4'f>>";
    } else {
      btnaddmatricula = false;
      rowtable="<'row'<'col-sm-12'f>>";
    }

    $("#vw_mt_divmensaje").hide();
    var table = $('#tbmt_dtMatriculados').DataTable({
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
        dom: rowtable +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: {
            buttons: [{
                    text: '<i class="fas fa-user-plus mr-1"></i> Matricular',
                    className: 'btn-sm btn-success',
                    attr: {
                        'title': 'Matricular',
                        'data-accion': 'INSERTAR',
                        'data-toggle': 'modal',
                        'data-target': '#modupmat',
                        'id': 'divbtnadd_matricula'
                    },
                    action: function(e, dt, node, config) {

                    },
                    // enabled: btnaddmatricula
                },
                /*{
                    text: '<i class="fas fa-trash-alt"></i>',
                    className: 'btn-sm btn-danger',
                    action: function ( e, dt, node, config ) {
                        fn_eliminar_matricula();
                    },
                    enabled: false
                }*/
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
        "fnDrawCallback": function (oSettings) {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover',
                html: true
            })
        }

    });
    var table = $('#tbmt_dtGrupos').DataTable({
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
            "targets": 9, // your case first column
            "className": "text-bold text-center",
            "width": "11px"
          },
          {
            "targets": 10, // your case first column
            "className": "text-primary text-center",
            "width": "11px"
          },
          {
            "targets": 11, // your case first column
            "className": "text-warning text-center",
            "width": "11px"
          },
          {
            "targets": 12, // your case first column
            "className": "text-danger text-center",
            "width": "11px"
          },
          {
            "targets": 13, // your case first column
            "className": "text-success text-center",
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
    

    $('#tbmt_dtMatriculados .view_user_reg').popover({
      trigger: 'hover',
      html: true
    })

    $("#fmt-cbperiodo").val(getUrlParameter("cp", '%'));
    $("#fmt-cbcarrera").val(getUrlParameter("cc", '%'));
    $("#fmt-cbciclo").val(getUrlParameter("ccc", '%'));
    $("#fmt-cbturno").val(getUrlParameter("ct", '%'));
    $("#fmt-cbseccion").val(getUrlParameter("cs", '%'));
    $("#fmt-cbplan").val(getUrlParameter("cpl", '%'));
    if (getUrlParameter("at", 0) == 1) $("#frmfiltro-matriculas").submit();

    var carne = getUrlParameter("fcarnet","");
    // var alumno = getUrlParameter("festudent","");
    // if (carne !=="" && alumno!== "") {}
    if (carne !=="") {
      $("#modupmat").modal();
      $('#modfiltroins').modal('hide');
      fn_select_inscrito(null,"inscrito");
    }

    $('#divcard_deudas_historial').hide();

    $('#lbtn_reportedeudas').hide();
    $('#lbtn_reportepagos').hide();

});
//$("#fmt-conteo").html(nro + ' matriculas encontradas');
//$('#divcard-matricular #divoverlay').remove();
//********************************************/
/*$(".btncall-carga").on("click", function() {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('.nav-pills a[href="#fichacarga"]').tab('show');
    vcm = $(this).data('cm');
    $("#vwtxtcodmat").val(vcm);
    fila=$(this).parents(".cfila_mt");

    alert("aaa");
    $("#divcarne").html("<h3>" + fila.data('.carnet') + "</h3>");
    $("#divmiembro").html(fila.data('.estudiante'));
    $("#divperiodo").html(fila.data('.cperiodo'));
    $("#divcarrera").html(fila.data('.ccarrera'));
    $("#divciclo").html("Ciclo: " + fila.data('.cciclo'));
    $("#divturno").html("Turno: " + fila.data('.cturno'));
    $("#divseccion").html("Sección: " + fila.data('.cseccion'));
    $("#fud-cbperiodo").html(fila.data('.cperiodo'));
    $("#fud-cbperiodo").data('cp', fila.data('.cperiodo'));
    //$("#fud-cbcarrera").text();
    //alert(fila.find('.ccarrera').data('cod'));
    $("#fud-cbcarrera").val(fila.data('.ccarrera'));
    $("#fud-cbcarrera").change();
    $("#fud-cbciclo").val(fila.data('.cciclo'));
    //$("#fud-cbciclo").val(getUrlParameter("ccc",0));
    ;
    $("#fud-cbturno").val(fila.data('.cturno'));
    $("#fud-cbseccion").val(fila.data('.cseccion'));
    $.ajax({
        url: base_url + "matricula/fn_cursos_x_matricula",
        type: 'post',
        dataType: 'json',
        data: {
            codmatricula: vcm
        },
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
            if (e.status == true) {
                var url = base_url + "academico/matricula/imprimir/" + vcm;
                mostrarCursos("divcard_data_carga", vcm, e.vdata);
                $("#divcard_data_carga").append(
                    '<div class="cfilaprint row">' +
                    '<div class="col-12 col-md-12 text-right td"><a class="btn btn-info" target="_blank" href="' + url + '" title="Imprimir matrícula"><i class="fas fa-print mr-1"></i> Imprimir Matrícula</a></div>' +
                    '</div></div>');
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            Swal.fire({
                type: 'error',
                title: 'Error, no se pudo mostrar los curso Matriculados',
                text: msgf,
                backdrop: false,
            })
        }
    });
});*/

function fn_carga_mat_estudiante(btn){
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    fila=btn.closest(".cfila_mt");
    var codigo = btn.data('cm');
    var plan = btn.data('plan');
    var est = btn.data('stdnt');
    $('#vwtxtcodmatcrg').val(codigo);

    // alert(fila.data('cperiodo'));
    $('#divcargaperiodo').html(fila.data('cperiodo'));
    $('#divcargacarrera').html(fila.data('ccarrera'));
    $('#divcargaciclo').html(fila.data('cciclo'));
    $('#divcargaturno').html(fila.data('cturno'));
    $('#divcargaseccion').html(fila.data('cseccion'));

    $('#fud-cbperiodo').html(fila.data('cperiodo'));
    $("#fud-cbperiodo").data('cp',fila.data('coperiodo'));
    $('#fud-cbcarrera').val(fila.data('cocarrera'));
    $('#fud-cbcarrera').change();
    $('#fud-cbciclo').val(fila.data('cociclo'));
    $('#fud-cbturno').val(fila.data('cturno'));
    $('#fud-cbseccion').val(fila.data('cseccion'));
    $('#divcargaplan').html(plan);
    $('#divcard_title_carga').html(est);
    // alert("jajaaj");

    $.ajax({
        url: base_url + "matricula/fn_cursos_x_matricula",
        type: 'post',
        dataType: 'json',
        data: {
            codmatricula: codigo
        },
        success: function(e) {
            $('#divcard-matricular #divoverlay').remove();
            $('#modview_carga').modal('show');
            if (e.status == true) {
                grupocrg = "";
                 


                $.each(e.vdata, function(index, v) {
                  grupoint = v['codciclo']+v['codseccion']+v['codturno']+v['codperiodo']+v['codcarrera']+v['codplan'];
                  if (grupocrg != grupoint) {
                      grupocrg = grupoint;
                     

                      $('#divcard_data_academico').show();
                  }
                })
                

                var url = base_url + "academico/matricula/imprimir/" + codigo;
                mostrarCursos("divcard_data_carga", codigo, e.vdata);
                $("#divcard_data_carga").append(
                    '<div class="cfilaprint row">' +
                    '<div class="col-12 col-md-12 text-right td"><a class="btn btn-info" target="_blank" href="' + url + '" title="Imprimir matrícula"><i class="fas fa-print mr-1"></i> Imprimir Matrícula</a></div>' +
                    '</div></div>');
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            Swal.fire({
                type: 'error',
                title: 'Error, no se pudo mostrar los curso Matriculados',
                text: msgf,
                backdrop: false,
            })
        }
    });
}

$('#modview_carga').on('hidden.bs.modal', function(e){
  $('#divcard_data_academico').hide();
  $('#divcard_data_cursos_disponibles').html("");
})

function fn_cambiarestado(btn) {
  tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
  fila = tbmatriculados.$('tr.selected');
  im = fila.data('codmatricula64');
  var ie = btn.data('ie');
  var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
  var texto = btn.html();
  var contenedor = btn.data('campo');
  var div = "";
  if (contenedor == "tabla") {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    div = "divcard-matricular";
  } else {
    $('#divmodalnewmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    div = "divmodalnewmatricula";
  }
  
  $.ajax({
      url: base_url + 'matricula/fn_cambiarestado',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-idmat': im,
          'ce-nestado': ie
      },
      success: function(e) {
          $('#'+div+' #divoverlay').remove();
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
              
              btdt.removeClass('btn-danger');
              btdt.removeClass('btn-success');
              btdt.removeClass('btn-warning');
              btdt.removeClass('btn-secondary');
              if (contenedor == "tabla") {
                  switch (texto) {
                      case "Activo":
                          btdt.addClass('btn-success');
                          btdt.html("ACT");
                          break;
                      case "Retirado":
                          btdt.addClass('btn-danger');
                          btdt.html("RET");
                          break;
                      case "Desaprobado":
                          btdt.addClass('btn-danger');
                          btdt.html("DES");
                          break;
                      default:
                          btdt.addClass("btn-warning");
                  }
              } else {
                  switch (texto) {
                      case "Activo":
                          btdt.addClass('btn-success');
                          btdt.html("ACTIVO");
                          $('#estado'+im).addClass('btn-success');
                          $('#estado'+im).html("ACT");
                          break;
                      case "Retirado":
                          btdt.addClass('btn-danger');
                          btdt.html("RETIRADO");
                          $('#estado'+im).addClass('btn-danger');
                          $('#estado'+im).html("RET");
                          break;
                      case "Desaprobado":
                          btdt.addClass('btn-danger');
                          btdt.html("DESAPROBADO");
                          $('#estado'+im).addClass('btn-danger');
                          $('#estado'+im).html("DES");
                          break;
                      default:
                          btdt.addClass("btn-warning");
                  }
              }

              if (ie == cd2) {
                //fn_view_data_deudas(btn);
                Swal.fire({
                  icon: 'success',
                  title: 'RETIRADO',
                  text: 'Se ha actualizado el estado y se anularon las deudas de esta matrícula',
                  backdrop: false,
                })
              } else {
                Swal.fire({
                  icon: 'success',
                  title: 'Felicitaciones, estado actualizado',
                  text: 'Se ha actualizado el estado',
                  backdrop: false,
                })
              }
              
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#'+div+' #divoverlay').remove();
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

$(".btn-cestado").click(function(event) {
    var im = $(this).parents(".cfila").data('idm');
    var ie = $(this).data('ie');
    var btdt = $(this).parents(".btn-group").find('.dropdown-toggle');
    //var btdt=$(this).parents(".dropdown-toggle");
    var texto = $(this).html();
    //alert(btdt.html());
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
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
                //mostrarCursos("divcard_data_carga", "", e.vdata);
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

function fn_eliminar_matricula() {
    $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    tbmatriculados = $('#tbmt_dtMatriculados').DataTable();
    fila = tbmatriculados.$('tr.selected');
    im = fila.data('codmatricula64');

    alumno = fila.data('estudiante');
    // var fila = $(this).parents(".cfila");
    // var im = fila.data('idm');
    // var alumno = fila.find('.calumno').html();
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Se eliminarán las notas y asistencias del estudiante " + alumno + ", en este curso: ",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $.ajax({
                url: base_url + 'matricula/fn_eliminar',
                type: 'post',
                dataType: 'json',
                data: {
                    'ce-idmat': im
                },
                success: function(e) {
                    $('#divcard-matricular #divoverlay').remove();
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
                            title: 'Eliminación correcta',
                            text: 'Se ha eliminado la matrícula',
                            backdrop: false,
                        })
                        fila.remove();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divcard-matricular #divoverlay').remove();
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error',
                        text: msgf,
                        backdrop: false,
                    })
                }
            });
        } else {
            $('#divcard-matricular #divoverlay').remove();
        }
    });
}

function fn_promediar(input){
    var fila=input.closest(".cfila");
    jsmetodo=fila.data('metodo');
    promedio=fila.find('.nf_txt_final').val();
    recupera=fila.find('.nt_txt_recupera').val();
    spanpf=fila.find(".nt_txt_pf");
    
    pi=0;
    if (jsmetodo=="PFGN"){
        pi=promedio;
        rc=recupera;
        if (rc!=""){
            pi=Math.round((Number(pi) + Number(rc) )/2);
        }
    }
    else if (jsmetodo=="PFCP"){
        pi=promedio;
        rc=recupera;
        if (rc!=""){
          if (Number(rc) > Number(pi)) pi=rc;
        }
        
    }
    else if (jsmetodo=="PF22"){
        pi=promedio;
        rc=recupera;
        if (rc!=""){
            pi=Math.round((Number(pi) + Number(rc) )/2);
        }
        
    }
    spanpf.html(pi);
    colorfinal = "text-danger";
    if (pi>= 12.5) colorfinal = "text-primary";
    spanpf.removeClass('text-danger');
    spanpf.removeClass('text-primary');
    spanpf.addClass(colorfinal);
}

$('#modupmat #nav-tab a').on('click', function (e) {
  e.preventDefault()
  item = $(this).attr('id');
  // console.log("item", item);
  if (item == "nav-matricular-tab") {
    $('#lbtn_editamat').show();
  } else {
    $('#lbtn_editamat').hide();
  }
})



function fn_activa_matcondicional(boton) {
  var codigo = boton.data('codigo');
  var estado = boton.data('estado');
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'matricula/fn_update_estadocondicional',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-codigo': codigo,
          'ce-estado': estado
      },
      success: function(e) {
        $('#divcard-matricular #divoverlay').remove();
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
          Swal.fire({
              type: 'success',
              icon: 'success',
              title: 'Éxito!',
              text: "Datos actualizados correctamente",
              backdrop: false,
          })
          boton.remove();
        }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divcard-matricular #divoverlay').remove();
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

function fn_refresca_condicional(boton) {
  var vcarne = boton.data('carne');
  $('#divmodaddmatricula').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'matricula/fn_historial_matricula',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-carne': vcarne
      },
      success: function(e) {
        $('#divmodaddmatricula #divoverlay').remove();
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
          if (e.vestado == "DES" && e.vcondic == "SI") {
            $('#lbtn_editamat').attr('disabled', false);
            boton.hide();

            $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
              if (!$(this).hasClass("ocultar")){
                $(this).data('autorizado', 'SI');
              }
            })
            $("#frm_updmatri #fm-cbcicloup").change();

          } else if (e.vcondic == "SI") {
            $('#lbtn_editamat').attr('disabled', false);
            boton.hide();

            $("#frm_updmatri #fm-cbcicloup option").each(function(i) {
              if (!$(this).hasClass("ocultar")){
                $(this).data('autorizado', 'SI');
              }
            })
          }
        }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#divmodaddmatricula #divoverlay').remove();
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

$("#frm_updmatri #fm-cbcicloup").change(function(e) {
  var item = $(this);
  var autoriza = item.find(':selected').data('autorizado');
  if (autoriza == "SI") {
    $('#lbtn_editamat').attr('disabled', false);
    $('#msgcursos_deudas').html("");
  } else {
    $('#lbtn_editamat').attr('disabled', true);
    $('#msgcursos_deudas').html('<div class="alert alert-danger alert-dismissible">'+
                                          '<i class="icon fas fa-ban mr-1"></i>'+
                                          'El estudiante no puede ser matriculado por presentar unidades didácticas desaprobadas con 6 creditos a más o presentar deudas pendientes, favor de regularizar lo antes mencionado'+
                                        '</div>');
  }
});




function fn_view_data_deudas(btn) {
  $('#modDeudas_view_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#div_Deudas_view').html("");
  tbldeudas = "";
  var carnet = btn.data('pagante');
  var estudiante = btn.data('pagantenb');

  var programa = btn.data('programa');
  var periodo = btn.data('periodo');
  var ciclo = btn.data('ciclo');
  var turno = btn.data('turno');
  var seccion = btn.data('seccion');
  var plan = btn.data('plan');

  $.ajax({
      url: base_url + 'inscrito/fn_datos_deudas',
      type: 'post',
      dataType: 'json',
      data: {
          'ce-carne': carnet
      },
      success: function(e) {
          
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'Error!',
                  text: e.msg,
                  backdrop: false,
              })
              $('#modDeudas_view_content #divoverlay').remove();
          } 
          else {
                
                $('#divcard_title_Deuda').html("<span class='text-danger'>"+carnet+"</span> / "+estudiante);
                $("#divdaperiodo").html(periodo);
                $("#divdacarrera").html(programa);
                $("#divdaplan").html(plan);
                $("#divdaciclo").html(ciclo);
                $("#divdaturno").html(turno);
                $("#divdaseccion").html(seccion);

                nro = 0;
                totald = 0;
                var bgcolor = "";
                $.each(e.vdata, function(index, v) {
                  nro++;
                  totald = totald + parseFloat(v['saldo']);
                  var bgsaldo = (v['saldo']>0) ? "text-danger":"text-success";

                  switch (v['estado']) {
                      case "ACTIVO":
                          bgcolor = "btn-success";
                          break;
                      case "ANULADO":
                          bgcolor = "btn-danger";
                          break;
                      default:
                          bgcolor = "btn-success";
                  }

                  tbldeudas = tbldeudas + 
                          "<div class='row cfila'>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-1 td text-center bg-lightgray px-0'>"+nro+"</div>"+
                                        "<div class='col-2 col-md-2 td text-center'><b>"+v['codigo']+"</b></div>"+
                                        "<div class='col-8 col-md-9 td'>"+v['persona'] +"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3 td'>"+
                                    "<span>"+v['gestion']+"</span>"+
                                "</div>"+
                                "<div class='col-12 col-md-2'>"+
                                    "<div class='row'>"+
                                        "<div class='col-6 col-md-6 td text-center'>"+parseFloat(v['monto']).toFixed(2)+"</div>"+
                                        "<div class='col-6 col-md-6 td text-center'>"+
                                          "<span class='"+bgsaldo+"'>"+parseFloat(v['saldo']).toFixed(2)+"<span>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['vence']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['grupo']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+
                                          '<div class="btn-group dropleft">' +
                                            '<button class="btn ' + bgcolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" ' +
                                            'aria-haspopup="true" aria-expanded="false">' +
                                            (v['estado'].toLowerCase()).charAt(0).toUpperCase() + (v['estado'].toLowerCase()).slice(1) +
                                            '</button> ' +
                                            '<div class="dropdown-menu">' +
                                              '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="' + cd2de + '" data-coddeuda="' + v['codigo64'] + '" id="btn_stanul' + v['codigo64'] + '" data-toggle="modal" data-target="#modanuladeuda">Anulado</a>' +
                                            '</div>' +
                                          '</div>' +
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                })

                if (nro > 0) {
                  $("#modDeudas_view").modal('show');
                } else {
                  Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Felicitaciones, estado actualizado',
                    text: 'Se ha actualizado el estado',
                    backdrop: false,
                  })
                }
                
                $('#div_Deudas_view').html(tbldeudas);
                $('#modDeudas_view_content #divoverlay').remove();
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#modDeudas_view_content #divoverlay').remove();
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

$("#modDeudas_view").on('hidden.bs.modal', function(e) {
  $('#divcard_title_Deuda').html("");
  $("#divdaperiodo").html("");
  $("#divdacarrera").html("");
  $("#divdaplan").html("");
  $("#divdaciclo").html("");
  $("#divdaturno").html("");
  $("#divdaseccion").html("");
  $('#div_Deudas_view').html("");
})

$("#modanuladeuda").on('show.bs.modal', function(e) {
    var rel = $(e.relatedTarget);
    var coddeuda = rel.data('coddeuda');
    var estado = rel.data('ie');
    var color = rel.data('color');

    $('#ficdeudacodigo').val(coddeuda);
    $('#ficdeudaestado').val(estado);
    $('#lbtn_anula_deuda').data('coloran', color);
});

$('#lbtn_anula_deuda').click(function() {
    var color = $(this).data('coloran');
    // alert("Mensaje");
    $('#form_anuladeuda input,select,textarea').removeClass('is-invalid');
    $('#form_anuladeuda .invalid-feedback').remove();
    $('#divmodalanulad').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $('#form_anuladeuda').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#form_anuladeuda').serialize(),
        success: function(e) {
            $('#divmodalanulad #divoverlay').remove();
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
                $('#modanuladeuda').modal('hide');
                var btdtan = $('#btn_stanul' + e.iddeuda).parents(".btn-group").find('.dropdown-toggle');
                var textoan = $('#btn_stanul' + e.iddeuda).html();
                btdtan.removeClass('btn-danger');
                btdtan.removeClass('btn-success');
                btdtan.addClass(color);
                btdtan.html(textoan);

                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'Felicitaciones, deuda anulada',
                    text: 'Se ha anulado la deuda',
                    backdrop: false,
                })

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalanulad #divoverlay').remove();
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

/* ====================================
DEUDAS
======================================= */

function fn_historial_vw_deudas(btn) {
  $('#modDeudas_historial').modal();
  $('#modDeudas_historial .modDeudas_historial_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#div_Pagos_Historial').html("");
  tabla = "";
  tbdeudas = "";
  tbdeudash = "";
  var fila = btn.closest('.cfila_mt');
  var carnet = fila.data('carnet');
  var estudiante = fila.data('estudiante');
  var idmatricula = fila.data('codmatricula64');

  var programa = btn.data('programa');
  var periodo = btn.data('periodo');
  var ciclo = btn.data('ciclo');
  var turno = btn.data('turno');
  var seccion = btn.data('seccion');
  var plan = btn.data('plan');
  
  $.ajax({
      url: base_url + "matricula/fn_docemitidos_items_x_pagante",
      type: 'post',
      dataType: 'json',
      data: {
          codpagante: carnet,
          idmatricula: idmatricula
      },
      success: function(e) {
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'Error!',
                  text: e.msg,
                  backdrop: false,
              })
              $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
          } 
          else {
                
                $('#divcard_title_HDeuda').html("<span class='text-danger'>"+carnet+"</span> / "+estudiante);
                $("#divhtperiodo").html(periodo);
                $("#divhtcarrera").html(programa);
                $("#divhtplan").html(plan);
                $("#divhtciclo").html(ciclo);
                $("#divhtturno").html(turno);
                $("#divhtseccion").html(seccion);

                var nro = 0;
                var tabla = "";
                var boton = "";
                // LLENADO DE DATOS PAGOS
                $.each(e.vdata, function(index, p) {
                    nro++;
                    var estado = p['estadoc'];
                    // boton = "<a href='#' onclick='fn_vw_seleccionar_pago($(this));return false;' title='Seleccionar' class='badge badge-primary'>seleccione</a>";
                    
                    monto = Number.parseFloat(p['monto']).toFixed(2);
                    if (estado !== "ANULADO") {
                      tabla = tabla +
                          "<div class='row rowcolor' data-tipo='" + p['codtipo'] + "' data-serie='" + p['serie'] + "' data-numero='" + p['numero'] + "'>" +
                          "<div class='col-6 col-md-5'>" +
                          "<div class='row'>" +
                          "<div class='col-4 col-md-2 td text-center'><span><b>" + nro + "</b></span></div>" +
                          "<div class='col-8 col-md-5 td'><span>" + p['serie'] + "-" + p['numero'] + "</span>" +
                          "</div>" +
                          "<div class='col-8 col-md-5 td'><span>" + p['fecha_hora'] + "</span>" +
                          "</div>" +
                          "</div>" +
                          "</div>" +
                          "<div class='col-4 col-md-4 td'><span>" + p['gestion'] + "</span></div>" +
                          "<div class='col-6 col-md-3 text-center'>" +
                          "<div class='row'>" +
                          "<div class='col-6 col-md-4 td text-center'><span>" + monto + "</span></div>" +
                          "<div class='col-6 col-md-8 td'><span>" + p['estadoc'] + "</span></div>" +
                          "</div>" +
                          "</div>" +
                          "</div>";
                    }
                });

                var nrod = 0;
                var nrod2 = 0;
                var tbdeudas = "";
                var tbdeudash = "";
                var bgcolor = "";
                var btnstatus = "";
                var btndeleted = "";
                var btnupdated = "";
                totald = 0;
                // LLENADO DE DATOS DEUDAS
                $.each(e.vdeudas, function(index, v) {
                  totald = totald + parseFloat(v['saldo']);
                  var bgsaldo = (v['saldo']>0) ? "text-danger":"text-success";
                  var codmatricula = v['idmatricula64'];
                  switch (v['estado']) {
                      case "ACTIVO":
                          bgcolor = "btn-success";
                          break;
                      case "ANULADO":
                          bgcolor = "btn-danger";
                          break;
                      default:
                          bgcolor = "btn-success";
                  }

                  if (codmatricula === idmatricula) {
                    nrod++;

                    if (e.vpermiso197 == "SI") {
                      btnstatus = '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="' + cd2de + '" data-coddeuda="' + v['codigo64'] + '" id="btn_stanul' + v['codigo64'] + '" data-toggle="modal" data-target="#modanuladeuda">Anulado</a>';
                    }

                    if (e.vpermiso199 == "SI") {
                      btndeleted = '<a href="#" data-cdeudad="' + v['codigo64'] + '" onclick="fn_delete_deuda($(this))" class="dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>';
                    }

                    if (e.vpermiso196 == "SI") {
                      btnupdated = '<a href="#" onclick="fn_vw_editar_deuda($(this));return false;" title="Editar Deuda" >' +
                                            '<i class="fas fa-pencil-alt fa-lg mx-1"></i>' +
                                          '</a>';
                    }

                    tbdeudas = tbdeudas + 
                          "<div class='row cfila' onclick='fn_rowselection($(this))' data-cdeuda='" + v['codigo64'] + "'>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-1 td text-center bg-lightgray px-0'>"+nrod+"</div>"+
                                        "<div class='col-2 col-md-2 td text-center'><b>"+v['codigo']+"</b></div>"+
                                        "<div class='col-8 col-md-9 td'>"+v['persona'] +"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3 td'>"+
                                    "<span>"+v['gestion']+"</span>"+
                                "</div>"+
                                "<div class='col-12 col-md-2'>"+
                                    "<div class='row'>"+
                                        "<div class='col-5 col-md-5 td text-center'>"+parseFloat(v['monto']).toFixed(2)+"</div>"+
                                        "<div class='col-5 col-md-5 td text-center'>"+
                                          "<span class='"+bgsaldo+"'>"+parseFloat(v['saldo']).toFixed(2)+"<span>"+
                                        "</div>"+
                                        "<div class='col-2 col-md-2 td text-center'>"+
                                          btnupdated +
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['vence']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['grupo']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+
                                          '<div class="btn-group dropleft">' +
                                            '<button class="btn ' + bgcolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" ' +
                                            'aria-haspopup="true" aria-expanded="false">' +
                                            (v['estado'].toLowerCase()).charAt(0).toUpperCase() + (v['estado'].toLowerCase()).slice(1) +
                                            '</button> ' +
                                            '<div class="dropdown-menu">' +
                                              btnstatus +
                                              '<div class="dropdown-divider"></div>' +
                                              btndeleted +
                                            '</div>' +
                                          '</div>' +
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                  } else {
                    nrod2++;
                    tbdeudash = tbdeudash + 
                          "<div class='row cfila'>"+
                                "<div class='col-12 col-md-4'>"+
                                    "<div class='row'>"+
                                        "<div class='col-2 col-md-1 td text-center bg-lightgray px-0'>"+nrod2+"</div>"+
                                        "<div class='col-2 col-md-2 td text-center'><b>"+v['codigo']+"</b></div>"+
                                        "<div class='col-8 col-md-9 td'>"+v['persona'] +"</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3 td'>"+
                                    "<span>"+v['gestion']+"</span>"+
                                "</div>"+
                                "<div class='col-12 col-md-2'>"+
                                    "<div class='row'>"+
                                        "<div class='col-6 col-md-6 td text-center'>"+parseFloat(v['monto']).toFixed(2)+"</div>"+
                                        "<div class='col-6 col-md-6 td text-center'>"+
                                          "<span class='"+bgsaldo+"'>"+parseFloat(v['saldo']).toFixed(2)+"<span>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-12 col-md-3'>"+
                                    "<div class='row'>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['vence']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+v['grupo']+"</div>"+
                                        "<div class='col-4 col-md-4 td text-center'>"+
                                          // '<div class="btn-group dropleft">' +
                                          //   '<button class="btn ' + bgcolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" ' +
                                          //   'aria-haspopup="true" aria-expanded="false">' +
                                          //   (v['estado'].toLowerCase()).charAt(0).toUpperCase() + (v['estado'].toLowerCase()).slice(1) +
                                          //   '</button> ' +
                                          //   '<div class="dropdown-menu">' +
                                          //     '<a href="#" class="dropdown-item" data-color="btn-danger" data-ie="' + cd2 + '" data-coddeuda="' + v['codigo64'] + '" id="btn_stanul' + v['codigo64'] + '" data-toggle="modal" data-target="#modanuladeuda">Anulado</a>' +
                                          //   '</div>' +
                                          // '</div>' +
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                  }

                  
                })

                if (nrod2 > 0) {
                  $('#divdata_Deudas_Historial').html(tbdeudash);
                  $('#divcard_deudas_historial').show();
                }

                $('#div_Deudas_Historial').html(tbdeudas);
                $('#div_Pagos_Historial').html(tabla);

                if (e.conteo > 0) {
                  $('#lbtn_reportedeudas').data('carnet', carnet);
                  $('#lbtn_reportedeudas').show();
                }

                if (e.pagos > 0) {
                  $('#lbtn_reportepagos').data('carnet', carnet);
                  $('#lbtn_reportepagos').data('pagante', estudiante);
                  $('#lbtn_reportepagos').data('programa', programa);
                  $('#lbtn_reportepagos').show();
                }
                
                $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
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

$("#modDeudas_historial").on('hidden.bs.modal', function(e) {
  $('#nav-mdeudash-tab').addClass('active');$('#nav-mdeudash').addClass('show active');
  $('#nav-mpagos-tab').removeClass('active');$('#nav-mpagos').removeClass('show active');

  $('#div_Deudas_Historial').html("");
  $('#divdata_Deudas_Historial').html("");
  $('#div_Pagos_Historial').html("");
  $('#lbtn_reportedeudas').hide();
  $('#lbtn_reportepagos').hide();
})

function fn_rowselection(btn) {
    $("#div_Deudas_Historial .cfila").removeClass("bg-selection");
    btn.addClass("bg-selection");
};

function fn_vw_editar_deuda(btn) {
    var fila = btn.closest('.cfila');
    var codigo = fila.data('cdeuda');
    $('#modDeudas_historial .modDeudas_historial_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + "deudas_individual/fn_get_deuda_codigo",
        type: 'post',
        dataType: 'json',
        data: {
            vw_fcb_txtcodigo : codigo,
        },
        success: function(e) {
            $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
            if (e.status == false) {
                Swal.fire({
                    title: "Error!",
                    text: "No se encontraron datos",
                    type: 'error',
                    icon: 'error',
                })
            } else {
                $('#ficcodpagante').attr('readonly', true);
                $('#ficapenomde').attr('readonly', true);
                $('#modadddeuda').modal();
                $('#divcard_button').hide();
                $('#ficcodmatricula').html(e.vmatriculas);
                $('#divcard_nompagante').removeClass('col-lg-5');
                $('#divcard_nompagante').addClass('col-lg-8');

                $('#ficcod_deuda').val(e.vdata['coddeuda64']);
                $('#ficcodpagante').val(e.vdata['pagante']);
                $('#ficcodmatricula').val(e.vdata['codmat64']);
                $('#ficapenomde').val(e.vdata['paterno'] + " " + e.vdata['materno'] + " " + e.vdata['nombres']);
                $('#ficbgestion').val(e.vdata['codgestion']);
                $('#ficmonto').val(parseFloat(e.vdata['monto']).toFixed(2));
                $('#ficmora').val(parseFloat(e.vdata['mora']).toFixed(2));
                $('#ficfechcreacion').val(e.vdata['fecha']);
                $('#ficfechvence').val(e.vdata['fvence']);
                $('#ficfechprorrog').val(e.vdata['fprorroga']);
                $('#ficvouchcodigo').val(e.vdata['voucher']);
                $('#ficcodigofecitem').val(e.vdata['fitem']);
                $('#ficrepitecic').val(e.vdata['repciclo']);
                $('#ficsaldo').val(parseFloat(e.vdata['saldo']).toFixed(2));
                $('#ficobservacion').val(e.vdata['observacion']);
                $('#divcardform_search_pagante').hide();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'div');
            $('#modDeudas_historial .modDeudas_historial_content #divoverlay').remove();
            $('#divres_paghistorial').html(msgf);
        }
    })
}

$('#lbtn_guardar_deuda').click(function() {
    $('#frm_addpagante input,select,textarea').removeClass('is-invalid');
    $('#frm_addpagante .invalid-feedback').remove();
    $('#divmodaladdmat').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: $('#frm_addpagante').attr("action"),
        type: 'post',
        dataType: 'json',
        data: $('#frm_addpagante').serialize(),
        success: function(e) {
            $('#divmodaladdmat #divoverlay').remove();
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
                // $('#modadddeuda').modal('hide');
                if (e.estado == "INSERTAR") {
                    $('#ficcodpagante').val("");
                    $('#ficcodpagante').attr('readonly', false);
                    $('#ficapenomde').attr('readonly', false);
                    $('#ficcodmatricula').html('<option value="">Sin Asignar</option>');
                    $('#ficapenomde').val("");
                    $('#frm_addpagante')[0].reset();
                } else {
                    $('#modadddeuda').modal('hide');
                    // $('#tbdd_form_search_deudas').submit();
                }
                
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: e.msg,
                    // text: 'Se ha actualizado el estado',
                    backdrop: false,
                })

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception,'text');
            $('#divmodaladdmat #divoverlay').remove();
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

function fn_delete_deuda(btn) {
    $('#divcard_deudas').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var cdeuda = btn.data("cdeudad");
    var fila = btn.parents(".cfila");
    // var carne=fila.find('.cell-carne').html();
    //************************************
    Swal.fire({
        title: "Precaución",
        text: "Se eliminarán todos los datos con respecto a esta DEUDA ",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.value) {
            //var codc=$(this).data('im');
            $.ajax({
                url: base_url + 'deudas_individual/fn_eliminar',
                type: 'post',
                dataType: 'json',
                data: {
                    'id-deuda': cdeuda
                },
                success: function(e) {
                    $('#divcard_deudas #divoverlay').remove();
                    if (e.status == false) {
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'Error!',
                            text: e.msg,
                            backdrop: false,
                        })
                    } else {

                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Eliminación correcta',
                            text: 'Se ha eliminado la deuda',
                            backdrop: false,
                        })

                        fila.remove();
                    }
                },
                error: function(jqXHR, exception) {
                    var msgf = errorAjax(jqXHR, exception, 'text');
                    $('#divcard_deudas #divoverlay').remove();
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Error',
                        text: msgf,
                        backdrop: false,
                    })
                }
            });
        } else {
            $('#divcard_deudas #divoverlay').remove();
        }
    });
    return false;
}

function fn_view_reporte_deudas(btn) {
  var carnet = btn.data('carnet');
  var url = base_url + "tesoreria/facturacion/reporte/deudas/estudiante/pdf?tp=CARNET&nro=" + carnet;
  window.open(url, '_blank');
}

function fn_view_reporte_pagos(btn) {
  var carnet = btn.data('carnet');
  var pagante = btn.data('pagante');
  var programa = btn.data('programa');
  var url = base_url + "tesoreria/facturacion/reporte/pagos/estudiante/pdf?ct=" + carnet + "&cpg=" + pagante + "&cpm=" + programa;
  window.open(url, '_blank');
}

/* ============================= 
SCRIPT GRUPOS
================================ */

var per_vcxg='<?php echo getPermitido("41"); ?>';
var per_vmxg='<?php echo getPermitido("43"); ?>';
var per_vcgp = '<?php echo getPermitido("149") ?>';

$("#frmfiltro-grupos").submit(function(event) {
    var sb=getUrlParameter("sb","");
    var jsparamSidebar=(sb=="")?"":"sb=" + sb + "&";
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-filtro").html("");
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
          $('#divboxhistorial #divoverlay').remove();
          if (e.status==false){
          }
          else{
            var nro=0;
            var mt=0;
            var ac=0;
            var rt=0;
            var cl=0;
            var py=0;
            var btn_culminar = "";
            tbgrupos = $('#tbmt_dtGrupos').DataTable();
              tbgrupos.clear();
            $.each(e.vdata, function(index, v) {
              /* iterate through array or object */
              nro++;
              mt=mt + parseInt(v['mat']);
              ac=ac + parseInt(v['act']);
              rt=rt + parseInt(v['ret']);
              cl=cl + parseInt(v['cul']);
              py=py + parseInt(v['pry']);
              
              var btn_carga='';
              var btn_matriculas="";
              var btnregeval="";
              var btnactaregmat="";
              var btnpadeval="";
              var btnord_merito="";
              
              var btn_culminar ="";
              var btn_matricular="";
              var btn_egresar="";

              var params='cp='+ v['codperiodo'] +'&cc='+ v['codcarrera'] + '&ccc='+ v['codciclo'] +'&ct='+ v['codturno']+'&cs='+ v['seccion']+'&cpl='+ v['idplan'] + '&sed=' + v['codsede'];

              btnregeval='<a class="dropdown-item" href="' + base_url + 'academico/consulta/nomina-evaluaciones/excel?' + params + '&at=1'+'"><i class="fas fa-file-excel"></i> Evaluaciones</a>'; 
              btnactaregmat='<a class="dropdown-item" href="' + base_url + 'academico/consulta/nomina-matricula/excel?' + params +'"><i class="fas fa-file-excel"></i> Matriculados</a>';
              btnpadeval='<a class="dropdown-item" href="' + base_url + 'academico/consulta/padron-evaluaciones/excel?' + params +'"><i class="fas fa-file-excel"></i> Padrón</a>';

              btnord_merito='<a class="dropdown-item" target="_blank" href="' + base_url + 'academico/consulta/orden-merito/imprimir?' + params + '&at=1'+'"><i class="fas fa-sort-numeric-up-alt mr-1"></i> Mérito</a>';

              if (per_vcxg=='SI'){
                
                btn_carga='<a class="dropdown-item" href="' + base_url + 'gestion/academico/carga-academica/grupo?' + jsparamSidebar + params +'"><i class="fas fa-book-open mr-1"></i> Carga</a>';
              }
              if (per_vmxg=='SI'){

                btn_matriculas='<a class="dropdown-item" href="' + base_url + 'gestion/academico/matriculas?' + jsparamSidebar + params + '&at=1'+'"><i class="fas fa-user mr-1"></i> Matrículas</a>';
              }

              if (per_vcgp == 'SI') {
                btn_culminar = '<a class="dropdown-item btn_culminar_grupo" href="#" onclick="vw_modal_culmina_grupo($(this));event.preventDefault();"><i class="far fa-times-circle mr-1"></i> Culminar</a>';
              }

              btn_matricular='<a class="dropdown-item" data-periodo=' + v['codperiodo'] + ' data-carrera=' + v['codcarrera'] + ' data-ciclo=' + v['codciclo'] + ' data-turno=' + v['codturno'] + ' data-seccion=' + v['seccion'] + ' data-plan=' + v['idplan'] + ' title="Agregar matrícula" href="#" data-toggle="modal" data-target="#modal-addalumno"><i class="fas fa-user-plus mr-1"></i> Matrícula Rápida</a>';

              btn_egresar='<a class="dropdown-item"  data-periodo=' + v['codperiodo'] + ' data-carrera=' + v['codcarrera'] + ' data-ciclo=' + v['codciclo'] + ' data-turno=' + v['codturno'] + ' data-seccion=' + v['seccion'] + ' data-plan=' + v['idplan'] + ' title="Agregar matrícula" href="#" data-toggle="modal" data-target="#modal-addalumno"><i class="fas fa-user-graduate mr-1"></i> Egresar</i></a>';
                                 
              btnActas='<div class="btn-group btn-group-sm p-0 " role="group">' + 
                '<button class="bg-success text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                    'Actas' +
                '</button>' +
                '<div class="dropdown-menu">' +
                    btnactaregmat +
                    btnregeval +
                    '<div class="dropdown-divider"></div>' + 
                     btnpadeval +
                '</div>' +
              '</div>';
  
              btnOpciones='<div class="btn-group btn-group-sm p-0 " role="group">' + 
                '<button class="bg-primary text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                    'Opciones' +
                '</button>' +
                '<div class="dropdown-menu dropdown-menu-right">' +
                    btnord_merito +
                    btn_carga +
                    btn_matriculas +
                    '<div class="dropdown-divider"></div>' + 
                    btn_matricular + 
                    btn_culminar +
                    btn_egresar + 
                ' </div>' +
              '</div>';
              vLinkAsignarCalendario="<a class='badge badge-warning mx-1 p-1' href='#' onclick='vw_abrir_ModalListaCronograma($(this));return false;'><i class='fas fa-edit'></i></a>";
              vCalendario=v['calendario'];
              if (v['calendario']==""){
                vCalendario="<span class='text-danger text-bold'>Asignar</span>"
              }
              var arrayGrupo_new = [
                (index + 1) ,
                v['sede_abrevia'] ,
                v['periodo'] ,
                vCalendario  +  vLinkAsignarCalendario,
                v['plan'],
                v['sigla'],
                v['ciclo'],
                v['turno'],
                v['seccion'],
                v['mat'],
                v['act'],
                v['pry'],
                v['ret'] ,
                v['cul'] ,
                btnActas + btnOpciones
              ];
              var filaGrupo_new = tbgrupos.row.add(arrayGrupo_new).node();

              $(filaGrupo_new).attr('data-per', v['codperiodo']);
              $(filaGrupo_new).attr('data-codsede', v['codsede']);
              $(filaGrupo_new).attr('data-sede', v['sede']);
              $(filaGrupo_new).attr('data-car', v['codcarrera']);
              $(filaGrupo_new).attr('data-cic', v['codciclo']);
              $(filaGrupo_new).attr('data-tur', v['codturno']);
              $(filaGrupo_new).attr('data-sec', v['codseccion']);
              $(filaGrupo_new).attr('data-plan', v['idplan']);
              $(filaGrupo_new).attr('data-periodo', v['periodo']);
              $(filaGrupo_new).attr('data-carrera', v['carrera']);
              $(filaGrupo_new).attr('data-turno', v['turno']);
              $(filaGrupo_new).attr('data-ciclo', v['ciclo']);
              $(filaGrupo_new).attr('data-seccion', v['seccion']);
              $(filaGrupo_new).attr('data-plann', v['plan']);
              $(filaGrupo_new).addClass('rowcolor');
              $(filaGrupo_new).addClass('cfila');
            });
            tbgrupos.draw();
            
          }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divboxhistorial #divoverlay').remove();
        }
    });
    return false;
});

function vw_abrir_ModalListaCronograma(boton) {
    fila=boton.closest(".cfila");
    var periodo = fila.data('periodo');
    var codperiodo = fila.data('per');
    var codsede = fila.data('codsede');
    var sede = fila.data('sede');

    $('#vw_mdlc_divListaCronogramas').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#vw_dg_txtcambio").val("NO");
    $("#vw_dg_cbcarrera").val(fila.data("car"));
    $("#vw_dg_cbciclo").val(fila.data("cic"));
    $("#vw_dg_cbturno").val(fila.data("tur"));
    $("#vw_dg_cbseccion").val(fila.data("sec"));
    $.ajax({
        url: base_url + "tesoreria/cronogramas/filtrar/sede/periodo",
        type: 'post',
        dataType: 'json',
        data: {
            "vw_dc_cbperiodo": codperiodo,
            "vw_dc_cbsede": codsede
        },
        success: function(e) {
            $('#vw_mdlc_divListaCronogramas #divoverlay').remove();
            if (e.status == false) {
                $.each(e.errors, function(key, val) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                });
            } else {
                var nro = 0;
                var tabla = "";
                btnGrupos = '';
                tbCronogramas = $('#tbmt_dtlistacronogramas').DataTable();
                tbCronogramas.clear();

                $.each(e.vdata, function(index, val) {
                    vdetalle="";
                     $.each(val['fechas'], function(index, item) {
                        vdetalle=vdetalle + 
                         
                        "<div class='row cfilaItem' data-codfechaitem='" + item['codigo'] + "'>" + 
                            "<div class='col-7'>" +
                                "<i class='fas fa-circle mr-1 fa-'></i>" +
                                item['descripcion'] +
                            "</div>" +
                            "<div class='col-5 text-rigth pr-1'>" + item['fechaDDMMYYYY'] +"</div>" + 
                        "</div>";
                    });
                    //vdetalle=   "<div class='col-12'>" + vdetalle + "</div>";
                   
                    btnSeleccionaCalendario = "<a class='badge badge-success mx-1 p-1 text-white' href='#' onclick='fn_agregarGrupoDeuda($(this));return false'>Seleccionar</a>";;
                  
                    var arrayCronogramas_new = [
                        (index + 1) ,
                        val['periodo'] ,
                        val['nombre']  + " (" + val['codigo'] + ")" ,
                        val['inicia'] ,
                        val['culmina'],
                        vdetalle,
                        btnSeleccionaCalendario
                    ];


            

                var filaCronograma_new = tbCronogramas.row.add(arrayCronogramas_new).node();
                    $(filaCronograma_new).attr('data-nombrecal', val['nombre'] );
                    $(filaCronograma_new).attr('data-calendario', val['codigo64'] );
                    $(filaCronograma_new).attr('data-codcalendario64', val['codigo64'] );
                    $(filaCronograma_new).attr('data-codcalendario', val['codigo'] );
                    $(filaCronograma_new).attr('data-cierreud', val['cierre_ud'] );
                    $(filaCronograma_new).attr('data-consolida', val['consolida_retiros'] );
                    

                    $(filaCronograma_new).attr('data-codsede', val['codsede'] );
                    $(filaCronograma_new).attr('data-codperiodo', val['codperiodo'] );
                    $(filaCronograma_new).attr('data-sede', val['sede'] );
                    $(filaCronograma_new).attr('data-periodo', val['periodo'] );
                    $(filaCronograma_new).attr('data-inicia', val['inicia'] );
                    $(filaCronograma_new).attr('data-culmina', val['culmina'] );
                    $(filaCronograma_new).addClass("cfila");

                });
                tbCronogramas.draw();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#vw_mdlc_divListaCronogramas #divoverlay').remove();
            Swal.fire({
                title: msgf,
                // text: "",
                type: 'error',
                icon: 'error',
            })
        }
    });

    $("#modListaCronogramas .modal-title").html(sede + " | "  + periodo + "</span>");
    $('#modListaCronogramas').modal("show");
}
$('#modListaCronogramas').on('hide.bs.modal', function () {
    if ( $("#vw_dg_txtcambio").val()=="SI"){
      $("#frmfiltro-grupos").submit();
    }
})

$('#modal-addalumno').on('hide.bs.modal', function () {
    $("#frmfiltro-grupos").submit();
})

$('#modal-addalumno').on('show.bs.modal', function (e) {
    var btn = $(e.relatedTarget)
    
    $("#vwg_md_periodo").val(btn.data('periodo'));
    $("#vwg_md_carrera").val(btn.data('carrera'));
    $("#vwg_md_plan_nuevo").val(btn.data('plan'));
    $("#vwg_md_ciclo").val(btn.data('ciclo'));
    $("#vwg_md_seccion").val(btn.data('seccion'));
    $("#vwg_md_turno").val(btn.data('turno'));
    $("#lista-alumnos").html("");
    
});

$('#txt-buscaralumnos').keypress(function(event) {
      var keycode = event.keyCode || event.which;
    if(keycode == '13') {
      $('#btn-buscaralumnos').click();
    }
});

$("#btn-buscaralumnos").click(function(event) {
    $('#lista-alumnos').html('<center><h4 class="text-primary">Buscando</h4><br /><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span><center>');
    
    var vcarga=$("#vidcurso").val();
    var valumno=$("#txt-buscaralumnos").val();
    var vperiodo=$("#vwg_md_periodo").val();
    var vcarrera=$("#vwg_md_carrera").val();//$("#vidperiodo").val();
    //var vdivision=$("#vdivision").val();
    $.ajax({
              url: base_url + 'inscrito/fn_get_datos_matriculantes' ,
        type: 'post',
        dataType: 'json',
        data: {periodo:vperiodo,alumno:valumno,carrera:vcarrera},
        success: function(e) {
          var resultados="";
          if (e.status==true){
            
            $.each(e.vdata, function(index, val) {
               resultados=resultados + 
                          "<div class='row rowcolor'>"+
                            "<div class='col-10'>" +
                              "<div class='row'>" + 
                                "<div class='col-12 col-md-4 td'>" +
                                      "<span><b>" + val['carne'] + "</b></span>" +
                                "</div>" + 
                                "<div class='col-12 col-md-8 td'>" +
                                  "<span>" + val['paterno'] + " " + val['materno'] + " " + val['nombres'] + "</span>" +
                                "</div> " + 
                              "</div>" +
                            "</div>" +
                           
                            "<div class='col-2 text-center td'>" +
                             
                              "<a href='#' data-inscripcion='" + base64url_encode(val['idinscripcion']) + "' data-planold='" + val['codplan'] + "' data-mapepaterno='" + val['paterno'] + "' data-mapematerno='" + val['materno'] + "' data-mnombres='" + val['nombres'] + "' data-msexo='" + val['sexo'] + "' onclick='vw_grupos_matricular($(this));event.preventDefault();' class='btn btn-primary btn-block btn-agregaralumno btn-sm' title='Agregar'>" +
                                "<i class='fa fa-plus'></i><span class='d-none'> Agregar</span>" + 
                              "</a>" +

                            "</div>" +

                          "</div>";

            });
            if (resultados=="") resultados="<span class='text-danger'>No se encontraron resultados, comprueba que no este matriculado o que su inscripción sea ACTIVA</span>"
            $('#lista-alumnos').html(resultados);
          }
          else{
            $('#lista-alumnos').html(e.msg);
          }
          
        },
      error: function (jqXHR, exception) {
        var msgf=errorAjax(jqXHR, exception,'div');
        $('#lista-alumnos').html(msgf);
      },
    });
    return false;
});

function vw_grupos_matricular(boton){
  //var boton=$(this);/
  
  $(".btn-agregaralumno").addClass('disabled');

  var fmtxtid= boton.data('inscripcion');
  var fmcbtipo='O';
  var fmcbbeneficio="1";
  var fmcbperiodo=$("#vwg_md_periodo").val();
  var fmtxtcarrera=$("#vwg_md_carrera").val();
  var fmtxtplan=boton.data('planold');
  var fmcbplan=$("#vwg_md_plan_nuevo").val();
  var fmcbciclo=$("#vwg_md_ciclo").val();
  var fmcbturno=$("#vwg_md_turno").val();
  
  var fmcbseccion=$("#vwg_md_seccion").val();
  var fmtxtfecmatricula="0";
  var fmtxtcuota="0";
  var fmtxtobservaciones="";

  var fmtapepaterno = boton.data('mapepaterno');
  var fmtapematerno = boton.data('mapematerno');
  var fmtnombres = boton.data('mnombres');
  var fmtsexo = boton.data('msexo');
  //codcarga codmatricula division idmiembro
  boton.html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
  $.ajax({
    url: base_url + 'matricula/fn_insert',
    type: 'post',
    dataType: 'json',
    data: {
  "fm-txtid": fmtxtid,
  "fm-cbtipo": fmcbtipo,
  "fm-cbbeneficio": fmcbbeneficio,
  "fm-cbperiodo": fmcbperiodo,
  "fm-txtcarrera": fmtxtcarrera,
  "fm-cbplan": fmcbplan,
  "fm-txtplan": fmtxtplan,
  "fm-cbciclo": fmcbciclo,
  "fm-cbturno": fmcbturno,
  "fm-cbseccion": fmcbseccion,
  "fm-txtfecmatricula": fmtxtfecmatricula,
  "fm-txtcuota": fmtxtcuota,
  "fm-txtobservaciones": fmtxtobservaciones,
  "fm-txtmapepat":fmtapepaterno,
  "fm-txtmapemat":fmtapematerno,
  "fm-txtmnombres":fmtnombres,
  "fm-txtmsexo":fmtsexo},
    success: function(e) {
      $(".btn-agregaralumno").removeClass('disabled');
      if (e.status==true){
         boton.hide();
      }
      else{
          boton.html('<i class="fa fa-plus"></i><span class="d-none"> Agregar</span>');
      }
    },
    error: function (jqXHR, exception) {
      var msgf=errorAjax(jqXHR, exception,'div');
      boton.html('<i class="fa fa-plus"></i><span class="d-none"> Agregar</span>');
      return false;
    },
  });
  return false
};

function vw_modal_culmina_grupo(boton) {
  var fila=boton.closest(".rowcolor");
  var periodo = fila.data('per');
  var carrera = fila.data('car');
  var ciclo = fila.data('cic');
  var turno = fila.data('tur');
  var seccion = fila.data('sec');
  var plan = fila.data('plan');

  var periodon = fila.data('periodo');
  var carreran = fila.data('carrera');
  var ciclon = fila.data('ciclo');
  var turnon = fila.data('turno');
  var plann = fila.data('plann');
  var seccionn = fila.data('sec');


  $("#vw_md_gp_cul_periodo").html(periodon);
  $("#vw_md_gp_cul_programa").html(carreran);
  $("#vw_md_gp_cul_turno").html(turnon);
  $("#vw_md_gp_cul_plan").html(plann);
  $("#vw_md_gp_cul_semestre").html(ciclon);
  $("#vw_md_gp_cul_seccion").html(seccionn);


  $('#divboxhistorial').append('<div id="divoverlay" class="overlay  d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + "grupos/fn_matriculados_x_grupo",
      type: 'post',
      dataType: 'json',
      data: {
        'fmt-cbperiodo' : periodo,
        'fmt-cbcarrera' : carrera,
        'fmt-cbciclo' : ciclo,
        'fmt-cbturno' : turno,
        'fmt-cbseccion' : seccion,
        'fmt-cbplan' : plan
      },
      success: function(e) {
          $('#divboxhistorial #divoverlay').remove();
          if (e.status == false) {
              Swal.fire({
                  title: 'Error!',
                  text: e.msg,
                  type: 'error',
                  icon: 'error',
              })
              
          } else {
            $('#divcard_data').html('');
            var nro=0;
            var tabla="";
            var btnscolor = "";
            var checkcul = "";
            if (e.vdata.length !== 0) {

              $.each(e.vdata, function(index, v) {
                nro++;
                checkcul = "";
                switch (v['codestado']) {
                    case "1":
                        btnscolor = "btn-success";
                        checkcul = "<input class='form-check-input culmcheckbox' onchange='vw_check_culmina($(this));' type='checkbox' data-mat='"+v['codmat64']+"' data-edit='' data-ant=''>";
                        break;
                    case "4":
                        btnscolor = "btn-secondary";
                        break;
                    case "2":
                        btnscolor = "btn-danger";
                        break;
                    case "7":
                        btnscolor = "btn-danger";
                        break;
                    default:
                        btnscolor = "btn-warning";
                }
                tabla=tabla +
                  "<div class='row rowcolor cfilagrupo' data-codigo='' data-idm='"+ v['codmat64']+"'>"+
                    "<div class='col-12 col-md-6'>"+
                        "<div class='row'>"+
                            "<div class='col-2 col-md-1 td' title='" + v['codigo'] +"'>"+nro+"</div>"+
                            "<div class='col-10 col-md-11 td calumno'>"+v['carne']+" - "+v['paterno']+' '+v['materno']+' '+v['nombres']+"</div>"+
                        "</div>"+
                    "</div>"+
                    "<div class='col-12 col-md-5'>"+
                        "<div class='row'>"+
                            "<div class='col-3 col-md-2 td text-center'>"+v['aprobados']+"</div>"+
                            "<div class='col-3 col-md-2 td text-center text-danger'>"+v['desaprobados']+"</div>"+
                            "<div class='col-3 col-md-2 td text-center text-danger'>"+v['nsp']+"</div>"+
                            "<div class='col-3 col-md-2 td text-center text-danger'>"+v['dpi']+"</div>"+
                            //"<div class='col-3 col-md-4 td text-center'><span class='badge "+btnscolor+" '> "+v['estado']+" </span></div>"+
                            "<div class='col-3 col-md-4 td text-center'>"+
                              '<div class="btn-group">' +
                                '<button class="btn ' + btnscolor + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                                v['estado'] +
                                '</button>' +
                                '<div class="dropdown-menu">' +
                                  '<a href="#" onclick="fn_cambiarEstado_grp($(this));return false;" class="btn-cestado dropdown-item" data-ie="' + cd1 + '">Activo</a>' +
                                  '<a href="#" onclick="fn_cambiarEstado_grp($(this));return false;" class="btn-cestado dropdown-item"  data-ie="' + cd2 + '">Retirado</a>' +
                                  '<a href="#" onclick="fn_cambiarEstado_grp($(this));return false;" class="btn-cestado dropdown-item"  data-ie="' + cd7 + '">Desaprobado</a>' +
                                  '<div class="dropdown-divider"></div>' +
                                  '<a href="#" onclick="eliminarMatricula($(this));return false;" class="btn-ematricula dropdown-item text-danger text-bold"><i class="fas fa-trash-alt"></i> Eliminar</a>' +
                                '</div>' +
                              '</div>' +
                            "</div>"+



                        "</div>"+
                    "</div>"+
                    "<div class='col-12 col-md-1 td text-center'>"+
                      '<div class="form-check">'+
                        checkcul+
                      '</div>'+
                    "</div>"+
                  "</div>";

              })
            }

            $("#fmt_conteo").html(nro + ' matriculas encontradas');

            $('#allcheck').prop('checked', true);

            $('#divcard_data').html(tabla);
            $('#modculminagrupo').modal('show');
            
            checks = $('.cfilagrupo').find('.culmcheckbox').length;
            
            if (checks > 0) {
              $('#lbtn_culminar').attr('disabled', false);
            } else {
              $('#lbtn_culminar').attr('disabled', true);
            }

            if ($('#allcheck').prop('checked')) {
              $('.culmcheckbox').each(function() {
                $(this).prop('checked',true);
                $(this).data('edit', "1");
              })
              
            }
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception,'text');
          $('#divboxhistorial #divoverlay').remove();
          Swal.fire({
              title: msgf,
              // text: "",
              type: 'error',
              icon: 'error',
          })
      }
  });
  return false;
}

$('#modculminagrupo').on('hide.bs.modal', function () {
  $("#frmfiltro-grupos").submit();
})

function vw_check_culmina(checked) {
  var check = true;
  $(".culmcheckbox").each(function(index, el) {
      if ($(this).prop('checked') == false) {
          check = false;
          $(this).data('edit', "0");
      } else {
        $(this).data('edit', "1");
      }
  });
  $("#allcheck").prop('checked', check);
}

$('#lbtn_culminar').click(function(e) {
    arrdata = [];
    $('#divcard_data .cfilagrupo div .culmcheckbox').each(function() {
      var isedit = $(this).data("edit");
      var idmat = $(this).data("mat");
      var valor = "";

      if (isedit == "1") {
        valor = 4;
        var myvals = [idmat, valor];
        arrdata.push(myvals);
      }
      
    })
    
    $('#divmodalculmgrup').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
      url: base_url + 'grupos/fn_culminar_grupo',
      type: 'post',
      dataType: 'json',
      data: {
          filas: JSON.stringify(arrdata),
      },
      success: function(e) {
          $('#divmodalculmgrup #divoverlay').remove();
          if (e.status == false) {
              Swal.fire({
                  type: 'error',
                  icon: 'error',
                  title: 'ERROR, NO se guardó cambios',
                  text: e.msg,
                  backdrop:false,
              });
          } else {
              
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: 'ÉXITO, Se guardó cambios',
                text: "Lo cambios fueron guardados correctamente",
                backdrop:false,
            });

            $("#modculminagrupo").modal("hide");
          }
      },
      error: function(jqXHR, exception) {
          var msgf = errorAjax(jqXHR, exception,'text');
          $('#divmodalculmgrup #divoverlay').remove();
          Swal.fire({
              type: 'error',
              icon: 'error',
              title: 'ERROR, NO se guardó cambios',
              text: msgf,
              backdrop:false,
          });
      },
    })
    return false;
});

function fn_cambiarEstado_grp(btn) {
    var im = btn.closest(".cfilagrupo").data('idm');
    var ie = btn.data('ie');
    var btdt = btn.closest(".btn-group").find('.dropdown-toggle');
    //var btdt=btn.parents(".dropdown-toggle");
    var texto = btn.html();
    //alert(btdt.html());
    $('#divmodalculmgrup').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $.ajax({
        url: base_url + 'matricula/fn_cambiarestado',
        type: 'post',
        dataType: 'json',
        data: {
            'ce-idmat': im,
            'ce-nestado': ie
        },
        success: function(e) {
            $('#divmodalculmgrup #divoverlay').remove();
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
                        btdt.html("ACTIVO");
                        break;
                        /*case "CUL":
                        btnscolor="btn-secondary";
                        break;*/
                    case "Retirado":
                        btdt.addClass('btn-danger');
                        btdt.html("RETIRADO");
                        break;
                      case "Desaprobado":
                        btdt.addClass('btn-danger');
                        btdt.html("DESAPROBADO");
                        break;
                    default:
                        btnscolor = "btn-warning";
                }
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divmodalculmgrup #divoverlay').remove();
            Swal.fire({
                type: 'error',
                title: 'Error',
                text: msgf,
                backdrop: false,
            })
        }
    });
    return false;
};

</script>