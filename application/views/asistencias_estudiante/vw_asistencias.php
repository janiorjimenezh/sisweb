<?php
$vbaseurl=base_url();
date_default_timezone_set('America/Lima');
$vuser=$_SESSION['userActivo'];
$fechahoy = date('Y-m-d');

?>
<!--<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>
<style>
  .btn_search_bol {
    border-top-right-radius: 0.25rem!important;
    border-bottom-right-radius: 0.25rem!important;
  }

  table.dataTable tbody tr.selected a:not(.bg-danger,.bg-primary,.bg-info,.bg-success,.bg-warning,.bg-secondary, a.dropdown-item) {
    color: #007bff !important;
  }

  .dropdown-item:not(.text-danger,.text-primary,.text-info,.text-success,.text-warning) {
    color: #212529!important;
  }

  .bg-selection {
    background-color: #F9F4BC;
  }

  select.form-control-sm ~ .select2-container--default {
    top: -0.05em;
  }
</style>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/select2/css/select2.min.css">
<div class="content-wrapper">

  <section id="s-cargado" class="content pt-1">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-matriculas-tab" data-toggle="tab" href="#nav-matriculas" role="tab" aria-controls="nav-matriculas" aria-selected="true">General</a>
        <?php //if (getPermitido("42") == "SI") { ?>
        <a class="nav-item nav-link" id="nav-grupos-tab" data-toggle="tab" href="#nav-grupos" role="tab" aria-controls="nav-grupos" aria-selected="false">Reportes</a>
        <?php //} ?>
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
                        <?php //foreach ($carreras as $carrera) {?>
                        <!-- <option value="<?php //echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option> -->
                        <?php //} ?>
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
                    <div class="form-group has-float-label col-12  col-sm-2">
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
                         <option value="%">Todos</option>
                        <?php foreach ($beneficios as $beneficio) {?>
                        <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                        <?php } ?>
                      </select>
                      <label for="fmt-cbbeneficio"> Beneficio</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-md-4">
                      <select data-currentvalue='' class="form-control form-control-sm" id="fmt-cbunidad" name="fmt-cbunidad" placeholder="Unidad" >
                         <option value="">Todos</option>
                         <?php
                         $grupo = "";
                         foreach ($cursos as $key => $und) {
                           $grupoint = $und->idplan;
                           if ($grupo !== $grupoint) {
                            if($grupo!="") echo "</optgroup>";
                              $grupo = $grupoint;
                              echo "<optgroup label='$und->plannom'> ";
                           }
                           echo "<option value='$und->id'>$und->uninom ($und->cicnom)</option>";
                         }
                         ?>
                         
                      </select>
                      <label for="fmt-cbunidad" style="left:22px"> Und. Didac.</label>
                    </div>
                    <div class="form-group has-float-label col-12 col-sm-4 col-md-4">
                      <input class="form-control text-uppercase form-control-sm" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
                      <label for="fmt-alumno"> Carné o Apellidos y nombres
                      </label>
                    </div>
                    
                  </div>
                </form>
                <hr>
                <a href="#" id="btn_rp501"><i class="far fa-file-excel text-success"></i> Consolidado de Inasistencias por Unidad Didáctica</a>
          </div>
        </div>
      </div>
      <?php if (getPermitido("42") == "SI") { ?>
      <div class="tab-pane fade" id="nav-grupos" role="tabpanel" aria-labelledby="nav-grupos-tab">
        <div id="divboxhistorial" class="card">
          <div class="card-body">
            <form id="frmfiltro-grupos" name="frmfiltro-grupos" action="<?php echo $vbaseurl ?>grupos/fn_filtrar" method="post" accept-charset='utf-8'>
              <div class="row">
                <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
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

                <div class="form-group has-float-label col-12 col-sm-2">
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
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbciclo" name="fm-cbciclo" placeholder="Ciclo" required >
                    <option value="%"></option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbciclo"> Ciclo</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbturno" name="fm-cbturno" placeholder="Turno" required >
                    <option value="%"></option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbseccion" name="fm-cbseccion" placeholder="Sección" required >
                    <option value="%"></option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbseccion"> Sección</label>
                </div>
                <div class="col-12  col-sm-1">
                  <button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>


            <hr>
            <div class="table-responsive">
              
            </div>


          </div>
          <div class="card-body pt-1">
            <div class="btable">
              <div class="thead col-12 d-none d-md-block">
                <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-2 td">N°</div>
                      <div class="col-md-4 td">PERIODO</div>
                      <div class="col-md-6 td">PLAN</div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-8 td">PROG. ACAD.</div>
                      <div class="col-md-4 td">GRUPO</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-3 td">MAT.</div>
                      <div class="col-md-3 td">ACT.</div>
                      <div class="col-md-3 td">RET.</div>
                      <div class="col-md-3 td">CUL.</div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="row">
                     
                      
                    </div>
                  </div>

                </div>
              </div>
              <div id="div-filtro" class="tbody col-12">
                
              </div>
            </div>
          </div>


        </div>
      </div>
      <?php } ?>
    </div>
    
  </section>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>
<script src="<?php echo $vbaseurl ?>resources/plugins/select2/js/select2.min.js"></script>
<!--<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>-->
<script>
  $(document).ready(function() {
    $('#fmt-cbsede').change();
    $('#fmt-cbunidad').select2({
      placeholder: 'Seleccione una opción'
    });
  })

  $('#btn_rp501').click(function(e) {
    e.preventDefault();
    var codigound = $('#fmt-cbunidad').val();
    if (codigound !== "") {
      codigound = $('#fmt-cbunidad').val();
    } else {
      codigound = "%";
    }
    // console.log(codigound);
    var url = base_url + 'academico/matriculados/asistencias/reporte/excel?cp=' + $("#fmt-cbperiodo").val() + '&cc=' + $("#fmt-cbcarrera").val() + '&ccc=' + $("#fmt-cbciclo").val() + '&ct=' + $("#fmt-cbturno").val() + '&cs=' + $("#fmt-cbseccion").val() + '&cpl=' + $("#fmt-cbplan").val() + '&ap=' + $("#fmt-alumno").val() + '&es=' + $("#fmt-cbestado").val() + '&sed=' + $("#fmt-cbsede").val() + '&benf=' + $("#fmt-cbbeneficio").val() + '&undd=' + codigound;
    var ejecuta = true;
    
    if (ejecuta == true) window.open(url, '_blank');
  })

  $('#fmt-cbsede').change(function(e) {
      var combo = $(this);
      var idsede = combo.val();
      $('#divcard-matricular').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: base_url + 'prematricula/fn_carreras_sedes',
          type: 'post',
          dataType: 'json',
          data: {
              txtcodigosed: idsede
          },
          success: function(e) {
              $('#divcard-matricular #divoverlay').remove();
              $('#frmfiltro-matriculas #fmt-cbcarrera').html(e.vdata);
          },
          error: function(jqXHR, exception) {
              $('#divcard-matricular #divoverlay').remove();
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#frmfiltro-matriculas #fmt-cbcarrera').html("<option value='0'>" + msgf + "</option>");
          }
      });
      return false;
  })

  $('#fmt-cbplan').change(function(e) {
      var combo = $(this);
      var idplan = combo.val();
      $('#divcard-matricular').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: base_url + 'asistencias_estudiantes/fn_unidades_x_plan',
          type: 'post',
          dataType: 'json',
          data: {
              txtcodigoplan: idplan
          },
          success: function(e) {
              $('#divcard-matricular #divoverlay').remove();
              $('#frmfiltro-matriculas #fmt-cbunidad').html(e.vdata);
          },
          error: function(jqXHR, exception) {
              $('#divcard-matricular #divoverlay').remove();
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#frmfiltro-matriculas #fmt-cbunidad').html("<option value='0'>" + msgf + "</option>");
          }
      });
      return false;
  })

  $('#fmt-cbunidad').change(function(e) {
    // console.log($(this).val());
  })

  $('#fmt-cbcarrera').change(function(e) {
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
  })

$(".btn_exportar_excel").click(function(e) {
    e.preventDefault();
    var url = base_url + 'academico/matriculas/excel?cp=' + $("#fmt-cbperiodo").val() + '&cc=' + $("#fmt-cbcarrera").val() + '&ccc=' + $("#fmt-cbciclo").val() + '&ct=' + $("#fmt-cbturno").val() + '&cs=' + $("#fmt-cbseccion").val() + '&cpl=' + $("#fmt-cbplan").val() + '&ap=' + $("#fmt-alumno").val() + '&es=' + $("#fmt-cbestado").val() + '&sed=' + $("#fmt-cbsede").val() + '&benf=' + $("#fmt-cbbeneficio").val();
    var ejecuta = true;
    
    if (ejecuta == true) window.open(url, '_blank');
});
</script>