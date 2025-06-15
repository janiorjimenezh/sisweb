<?php $vbaseurl=base_url() ;
$vuser=$_SESSION['userActivo'];
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<?php echo
    "<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>"; ?>
<style type="text/css">
/*# sourceMappingURL=bootstrap4-modal-fullscreen.min.css.map */

  #vw_mpc_pgBar {
    background-color: #3E6FAD;
    width: 0px;
    height: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -o-border-radius: 5px;
    border-radius: 5px;
    -moz-transition: .25s ease-out;
    -webkit-transition: .25s ease-out;
    -o-transition: .25s ease-out;
    transition: .25s ease-out;
  }

  .h7 {
    font-size: 0.8rem;
  }

  #div-filtro::-webkit-scrollbar, .divcardresult_data::-webkit-scrollbar, #mbeDivRsEstudiantes::-webkit-scrollbar {
    width: 4px;
    height: 4px;
  }

  #div-filtro::-webkit-scrollbar-track, .divcardresult_data::-webkit-scrollbar-track, #mbeDivRsEstudiantes::-webkit-scrollbar-track {
      /*box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.3);*/
      box-shadow: inset 0 0 2px rgb(0 0 0 / 12%);
      border-radius: 10px;
  }

  #div-filtro::-webkit-scrollbar-thumb, .divcardresult_data::-webkit-scrollbar-thumb, #mbeDivRsEstudiantes::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, .4);
      border-radius: 10px;
      box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.5);
  }

  @media screen and (max-width: 767px) {
      #div-filtro::-webkit-scrollbar, .divcardresult_data::-webkit-scrollbar, #mbeDivRsEstudiantes::-webkit-scrollbar {
          width: 4px;
          height: 6px;
      }
  }

  #div-filtro, .divcardresult_data, #mbeDivRsEstudiantes {
      overflow-x: auto;
      overflow-y: auto;      
  }
</style>
<div class="content-wrapper">
  
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Bloqueos</h1>
        </div>
      </div>
    </div>
  </section>
  <section id="s-cargado" class="content">
    <div class="modal fade modal-fullscreen" id="mdBloqueoEstudiantes" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="mdBloqueoEstudiantesLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" id="mdDivBloqueoEstudiantes">
          <div class="modal-header">
            <h5 class="modal-title" id="mdBloqueoEstudiantesLabel">Estudiantes Matriculados</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="mbeFiltroMatriculas" name="mbeFiltroMatriculas" action="<?php echo $vbaseurl ?>tesoreria_matricula/fnFiltrarMatriculadosXGrupo" method="post" accept-charset='utf-8'>
              <div class="form-row">
                <div class="form-group has-float-label col-12 col-sm-3 col-md-1">
                  <select  class="form-control form-control-sm text-xs" id="mbe-cbsede" name="mbe-cbsede" placeholder="Filial">
                    <option value="%"></option>
                    <?php
                    foreach ($sedes as $filial) {
                    $select=($vuser->idsede==$filial->id) ? "selected":"";
                    echo "<option $select value='$filial->id'>$filial->nombre</option>";
                    }
                    ?>
                  </select>
                  <label for="mbe-cbsede"> Filial</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-4 col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="mbe-cbperiodo" name="mbe-cbperiodo" placeholder="Periodo">
                    <option value="%"></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="mbe-cbperiodo"> Periodo</label>
                </div>
                
                <div class="form-group has-float-label col-12 col-sm-6 col-md-2">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="mbe-cbcarrera" name="mbe-cbcarrera" placeholder="Prog. de Estudios" >
                    <option value="%"></option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="mbe-cbcarrera"> Prog. de Estudios</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                  <select name="mbe-cbplan" id="mbe-cbplan"class="form-control form-control-sm text-xs">
                    <option data-carrera="0" value="%">Todos</option>
                    <option data-carrera="0" value="0">Sin Plan</option>
                    <?php foreach ($planes as $pln) {
                    echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                    } ?>
                  </select>
                  <label for="mbe-cbplan">Plan Estud.</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="mbe-cbciclo" name="mbe-cbciclo" placeholder="Semestre" >
                    <option value="%"></option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="mbe-cbciclo">Semestre</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="mbe-cbturno" name="mbe-cbturno" placeholder="Turno" >
                    <option value="%"></option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="mbe-cbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="mbe-cbseccion" name="mbe-cbseccion" placeholder="Sección" >
                    <option value="%"></option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="mbe-cbseccion"> Sección</label>
                </div>
                <div class="form-group has-float-label col-12  col-sm-1">
                  <select data-currentvalue="" class="form-control form-control-sm text-xs" id="mbe-cbestado" name="mbe-cbestado" required="">
                    <option value="%"></option>
                    <?php foreach ($estados as $estado) {?>
                    <option value="<?php echo $estado->codigo ?>"><?php echo $estado->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="mbe-cbestado"> Estado</label>
                </div>
                <div class="form-group has-float-label col-12  col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="mbe-cbbeneficio" name="mbe-cbbeneficio" placeholder="Periodo" required >
                    <option value="%">Todos</option>
                    <?php foreach ($beneficios as $beneficio) {?>
                    <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fmt-cbbeneficio"> Beneficio</label>
                </div>
                
                <div class="col-6 col-sm-2 col-md-1">
                  <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fas fa-search"></i></button>
                </div>
                
              </div>
            </form>
            <div class="row">
              <div class="col-6">
                <small id="fmt-conteo" class="form-text text-primary"></small>
                <div class="btable">
                  <div class="thead col-12  d-none d-md-block">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="row">
                          <div class="col-md-3 td">N°</div>
                          <div class="col-md-9 td">CARNÉ</div>
                        </div>
                      </div>
                  
                        
                      <div class="col-md-4 td">ALUMNO</div>
                        
                     
                      
                      <div class="col-md-5 td"></div>
                    </div>
                  </div>
                  <div id="mbeDivRsEstudiantes" class="tbody col-12">
                    
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-12 text-center border border-secondary p-1 font-weight-bold" id="divcard_alumno">
                      </div>
                      <div class="col-12 border p-1 text-center text-bold" id="card_result_title">
                        Pagos / Deudas
                      </div>
                      <small id="fmt_conteo_data" class="form-text text-primary"></small>
                      <div class="col-12" id="divcard_resultmat"></div>
                    </div>
                    
                    
                   
                    
                  </div>
                </div>
                
              </div>
              <div class="col-12"></div>
              
            </div>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Understood</button>
          </div> -->
        </div>
      </div>
    </div>
  <div class="col-12">
    <div class="card card-primary card-tabs" id="divcard_gruposmat">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
          
          <li class="nav-item">
            <a class="nav-link active" id="tabGrupos-tab" data-toggle="pill" href="#tabGrupos" role="tab" aria-controls="tabGrupos" aria-selected="true">Grupos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tabEstudiantes-tab" data-toggle="pill" href="#tabEstudiantes" role="tab" aria-controls="tabEstudiantes" aria-selected="false">Estudiantes</a>
          </li>
          
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-two-tabContent">
          <div class="tab-pane fade show active" id="tabGrupos" role="tabpanel" aria-labelledby="tabGrupos-tab">
            <form id="frmfiltro-grupos" name="frmfiltro-grupos" action="<?php echo $vbaseurl ?>grupos/fnFiltrarGruposBloqueo" method="post" accept-charset='utf-8'>
              <div class="row">
                <div class="form-group has-float-label col-12 col-sm-2 col-md-2">
                  <select  class="form-control form-control-sm text-xs" id="fm-cbsede" name="fm-cbsede" placeholder="Filial">
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
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fm-cbperiodo" name="fm-cbperiodo" placeholder="Periodo" required >
                    <option value="%"></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbperiodo"> Periodo</label>
                </div>
                
                <div class="form-group has-float-label col-12 col-sm-4 col-md-4">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fm-cbcarrera" name="fm-cbcarrera" placeholder="Programa Académico" required >
                    <option value="%"></option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbcarrera"> Programa Académico</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2 col-md-2">
                  <select name="fm-cbplan" id="fm-cbplan"class="form-control form-control-sm text-xs">
                    <option data-carrera="0" value="%">Todos</option>
                    <option data-carrera="0" value="0">Sin Plan</option>
                    <?php foreach ($planes as $pln) {
                    echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                    } ?>
                  </select>
                  <label for="fm-cbplan">Plan estudios</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2 col-md-2">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fm-cbciclo" name="fm-cbciclo" placeholder="Ciclo" required >
                    <option value="%"></option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbciclo"> Ciclo</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fm-cbturno" name="fm-cbturno" placeholder="Turno" required >
                    <option value="%"></option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fm-cbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-2">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fm-cbseccion" name="fm-cbseccion" placeholder="Sección" required >
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
            <div class="btable">
              <div class="thead col-12 d-none d-md-block">
                <div class="row">
                  <div class="col-md-3">
                    <div class="row h-100">
                      <div class="col-md-2 td">N°</div>
                      <div class="col-md-4 td">PERIODO</div>
                      <div class="col-md-6 td">PLAN</div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row h-100">
                      <div class="col-md-8 td">PROG. ACAD.</div>
                      <div class="col-md-4 td">GRUPO</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row h-100">
                      <div class="col-md-3 td">MAT.</div>
                      <div class="col-md-3 td">ACT.</div>
                      <div class="col-md-3 td">RET.</div>
                      <div class="col-md-3 td">CUL.</div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="row h-100">
                      <div class="col-md-12 td"></div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div id="divFiltroGrupos" class="tbody col-12">
                
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tabEstudiantes" role="tabpanel" aria-labelledby="tabEstudiantes-tab">
            <form id="frmfiltro-matriculas" name="frmfiltro-matriculas" action="<?php echo $vbaseurl ?>matricula/fn_filtrar_bloqueos" method="post" accept-charset='utf-8'>
              <div class="row">
                <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
                  <select  class="form-control form-control-sm text-xs" id="fmt-cbsede" name="fmt-cbsede" placeholder="Filial">
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
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbperiodo" name="fmt-cbperiodo" placeholder="Periodo">
                    <option value="%"></option>
                    <?php foreach ($periodos as $periodo) {?>
                    <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fmt-cbperiodo"> Periodo</label>
                </div>
                
                <div class="form-group has-float-label col-12 col-sm-6 col-md-3">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbcarrera" name="fmt-cbcarrera" placeholder="Programa Académico" >
                    <option value="%"></option>
                    <?php foreach ($carreras as $carrera) {?>
                    <option value="<?php echo $carrera->codcarrera ?>"><?php echo $carrera->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fmt-cbcarrera"> Prog. de Estudios</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                  <select name="fmt-cbplan" id="fmt-cbplan"class="form-control form-control-sm text-xs">
                    <option data-carrera="0" value="%">Todos</option>
                    <option data-carrera="0" value="0">Sin Plan</option>
                    <?php foreach ($planes as $pln) {
                    echo "<option data-carrera='$pln->codcarrera' value='$pln->codigo'>$pln->nombre</option>";
                    } ?>
                  </select>
                  <label for="fmt-cbplan">Plan estudios</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbciclo" name="fmt-cbciclo" placeholder="Semestre" >
                    <option value="%"></option>
                    <?php foreach ($ciclos as $ciclo) {?>
                    <option value="<?php echo $ciclo->codigo ?>"><?php echo $ciclo->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fmt-cbciclo">Semestre</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbturno" name="fmt-cbturno" placeholder="Turno" >
                    <option value="%"></option>
                    <?php foreach ($turnos as $turno) {?>
                    <option value="<?php echo $turno->codigo ?>"><?php echo $turno->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fmt-cbturno"> Turno</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-6 col-md-1">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbseccion" name="fmt-cbseccion" placeholder="Sección" >
                    <option value="%"></option>
                    <?php foreach ($secciones as $seccion) {?>
                    <option value="<?php echo $seccion->codigo ?>"><?php echo $seccion->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fmt-cbseccion"> Sección</label>
                </div>
                <div class="form-group has-float-label col-12  col-sm-2">
                  <select data-currentvalue="" class="form-control form-control-sm text-xs" id="fmt-cbestado" name="fmt-cbestado" required="">
                    <option value="%"></option>
                    <?php foreach ($estados as $estado) {?>
                    <option value="<?php echo $estado->codigo ?>"><?php echo $estado->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fmt-cbestado"> Estado</label>
                </div>
                <div class="form-group has-float-label col-12  col-md-2">
                  <select data-currentvalue='' class="form-control form-control-sm text-xs" id="fmt-cbbeneficio" name="fmt-cbbeneficio" placeholder="Periodo" required >
                    <option value="%">Todos</option>
                    <?php foreach ($beneficios as $beneficio) {?>
                    <option value="<?php echo $beneficio->id ?>"><?php echo $beneficio->nombre ?></option>
                    <?php } ?>
                  </select>
                  <label for="fmt-cbbeneficio"> Beneficio</label>
                </div>
                <div class="form-group has-float-label col-12 col-sm-5 col-md-5">
                  <input class="form-control text-uppercase form-control-sm" autocomplete="off" id="fmt-alumno" name="fmt-alumno" placeholder="Carné o Apellidos y nombres" >
                  <label for="fmt-alumno"> Carné o Apellidos y nombres
                  </label>
                </div>
                <div class="col-6 col-sm-2 col-md-1">
                  <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fas fa-search"></i></button>
                </div>
                
              </div>
            </form>
            <div class="row">
              <div class="col-12 col-md-6 pl-2 pr-0" id="divcard_ltsmatriculas">
                
                <small id="fmt-conteo" class="form-text text-primary">
                
                </small>
                <div class="btable">
                  <div class="thead col-12  d-none d-md-block">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="row">
                          <div class="col-md-3 td">N°</div>
                          <div class="col-md-9 td">CARNÉ</div>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="row">
                          <div class="col-md-4 td">GRUPO</div>
                          <div class="col-md-8 td">ALUMNO</div>
                        </div>
                      </div>
                      
                      <div class="col-md-4 td"></div>
                    </div>
                  </div>
                  <div id="div-filtro" class="tbody col-12">
                    
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-md-6 pr-2" id="divcard_detalle_tabtwo">
                <small id="fmt_conteo_data" class="form-text text-primary"></small>
                <div class="border p-1 text-center" id="title_result">
                  <h5 id="card_result_title"></h5>
                </div>
                
                <div id="divcard_resultmat"></div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12 col-md-6"></div>
              <div class="col-12 col-md-6 text-center border border-secondary p-1" id="content_alumno">
                <span class="font-weight-bold" id="divcard_alumno"></span>
              </div>
            </div>
          </div>
          
          
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<script>
var vpermiso127 = '<?php echo getPermitido("127"); ?>';
var vpermiso166 = '<?php echo getPermitido("166"); ?>';
$(document).ready(function() {
    $('#content_alumno').hide();
    $('#divcard_ltsmatriculas').hide();
    $('#title_result').hide();
    $("#fmt-cbperiodo").val(getUrlParameter("cp", '%'));
    $("#fmt-cbcarrera").val(getUrlParameter("cc", '%'));
    
    $("#fmt-cbciclo").val(getUrlParameter("ccc", '%'));
    $("#fmt-cbturno").val(getUrlParameter("ct", '%'));
    $("#fmt-cbseccion").val(getUrlParameter("cs", '%'));
    $("#fmt-cbplan").val(getUrlParameter("cpl", '%'));
    
    if (getUrlParameter("at", 0) == 1) $("#frmfiltro-matriculas").submit();
});

$('.cbgrupo').change(function(event) {

    var cp=($("#fmt-cbperiodo").val()=="%")? "":"&cp=" + $("#fmt-cbperiodo").val();
    var cc=($("#fmt-cbcarrera").val()=="%")? "":"&cc=" + $("#fmt-cbcarrera").val();
    var ccc=($("#fmt-cbciclo").val()=="%")? "":"&ccc=" + $("#fmt-cbciclo").val();
    var ct=($("#fmt-cbturno").val()=="%")? "":"&ct=" + $("#fmt-cbturno").val();
    var cs=($("#fmt-cbseccion").val()=="%")? "":"&cs=" + $("#fmt-cbseccion").val();
    var cpl=($("#fmt-cbplan").val()=="%")? "":"&cpl=" + $("#fmt-cbplan").val();
    url_complemento="?at=0" + cp + cc + ccc + ct + cs + cpl;
    if (history.pushState) {
          var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + url_complemento;
          window.history.pushState({path:newurl},'',newurl);
    }
});

$('#frmfiltro-matriculas #fmt-cbcarrera').change(function(event) {
    var codcar = $(this).val();
    if (codcar=="%"){
      $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i){
          if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');           
      });
    }
    else{
      $("#frmfiltro-matriculas #fmt-cbplan option").each(function(i){
    
        if ($(this).data('carrera')=='0'){
            //if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
          }
          else if ($(this).data('carrera')==codcar){
            $(this).removeClass('ocultar');
          }
          else{
            if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
          }
      });
    }
});

$('#frmfiltro-grupos #fm-cbcarrera').change(function(event) {
    var codcar = $(this).val();
    if (codcar=="%"){
      $("#frmfiltro-grupos #fm-cbplan option").each(function(i){
          if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');           
      });
    }
    else{
      $("#frmfiltro-grupos #fm-cbplan option").each(function(i){
    
        if ($(this).data('carrera')=='0'){
            //if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
          }
          else if ($(this).data('carrera')==codcar){
            $(this).removeClass('ocultar');
          }
          else{
            if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
          }
      });
    }
});


$("#frmfiltro-matriculas").submit(function(event) {
    $('#divcard_gruposmat').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div-filtro").html("");
    $('#tabEstudiantes #fmt_conteo_data').html('');
    $('#tabEstudiantes #title_result').hide();
    $('#tabEstudiantes #card_result_title').html('');
    $('#tabEstudiantes #divcard_resultmat').html('');
    $('#tabEstudiantes #content_alumno').hide();
    $('#tabEstudiantes #divcard_alumno').html('');
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
            if (e.status == false) {} else {
                var nro = 0;
                if (e.vdata.length > 0) {
                  var content_detail = "tabEstudiantes";
                  var divcardoverlay = "divcard_gruposmat";
                  $.each(e.vdata, function(index, v) {
                      nro++;
                      var dataedit = "";
                      var icono = "";
                      var iconous = "";
                      var cambious = "";
                      var vcm = v['codmatricula64'];
                      var periodo = base64url_encode(v['codperiodo']);
                      var vuser = base64url_encode(v['userid']);
                      var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
                      var bloquear = "";
                      var usbloqueo = "";
                      var student = v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'];
                      
                      if (v['bloqueo'] == "SI") {
                        dataedit = "1";
                        icono = '<i class="far fa-times-circle fa-lg text-danger"></i>';
                      } else {
                        dataedit = "0";
                        icono = '<i class="far fa-check-circle fa-lg text-success"></i>';
                      }

                      if (vpermiso127 =='SI') {
                        bloquear = '<a onclick="fn_bloquea_notas($(this));return false;" class="h7" style="cursor:pointer" title="" data-edit="'+dataedit+'" >'+icono+'</a>';
                      } else {
                        bloquear = "";
                      }

                      if (v['estadouser'] == "SI") {
                        cambious = "NO";
                        iconous = '<i class="fas fa-user-check fa-lg text-success"></i>';
                      } else {
                        cambious = "SI";
                        iconous = '<i class="fas fa-user-times fa-lg text-danger"></i>';
                      }

                      if (vpermiso166 == "SI") {
                        usbloqueo = '<a onclick="fn_bloquea_acceso($(this));return false;" class="h7" style="cursor:pointer" title="" data-estado="'+cambious+'" data-user="'+vuser+'">'+iconous+'</a>';
                      } else {
                        usbloqueo = "";
                      }

                      $("#div-filtro").append(
                          '<div data-idm="' + vcm + '" data-carne="'+v['carne']+'" data-periodo="'+periodo+'" data-student="'+student+'" class="cfila row ' + rowcolor + ' ">' +
                            '<div class="col-4 col-md-3">' +
                              '<div class="row">' +
                                '<div class="col-3 col-md-3 td">' + nro + '</div>' +
                                '<div class="ccarne col-9 col-md-9 td">' + v['carne'] + '</div>' +
                              '</div>' +
                            '</div>' +
                            '<div class="col-4 col-md-5">' +
                              '<div class="row">' +
                                '<div class="calumno col-8 col-md-4 td">' + 
                                    v['periodo'] + ' ' + v['ciclo'] +
                                '</div>' +
                                '<div class="calumno col-8 col-md-8 td">' +
                                    v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + 
                                '</div>' +
                              '</div>' +
                            '</div>' +
                            '<div class="col-12 col-md-3 text-center">'+
                              '<div class="row">' +
                                '<div class="col-3 col-md-3 td text-center">'+
                                  '<a onclick="fn_mostrar_notas($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Notas" data-contentdetail="'+content_detail+'" data-contentoverlay="'+divcardoverlay+'"><i class="fas fa-lg fa-paste"></i></a>'+
                                '</div>' +
                                '<div class="col-3 col-md-3 td text-center">'+
                                  '<a onclick="fn_mostrar_asistencias($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Asistencias" data-contentdetail="'+content_detail+'" data-contentoverlay="'+divcardoverlay+'"><i class="far fa-lg fa-calendar-alt"></i></a>'+
                                '</div>' +
                                '<div class="col-3 col-md-3 td text-center">'+
                                  '<a onclick="fn_pagos_alumnos($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Pagos" data-contentdetail="'+content_detail+'" data-contentoverlay="'+divcardoverlay+'"><i class="far fa-lg fa-money-bill-alt"></i></a>'+
                                '</div>' +
                                '<div class="col-3 col-md-3 td text-center">'+
                                  bloquear+
                                '</div>' +
                              '</div>' +
                            '</div>' +
                            '<div class="col-8 col-md-1 td text-center">' +
                              usbloqueo +
                            '</div>' +
                          '</div>');
                  });

                  $('#div-filtro').css('height','300px');
                  
                } else {
                  $('#div-filtro').css('height','auto');
                }

                $('#divcard_ltsmatriculas').show();
                $("#divcard_ltsmatriculas #fmt-conteo").html(nro + ' matriculas encontradas');
                $('#divcard_gruposmat #divoverlay').remove();
                //********************************************/
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard_gruposmat #divoverlay').remove();
            //$('#divError').show();
            //$('#msgError').html(msgf);
        }
    });
    return false;
});

function fn_mostrar_asistencias(boton) {
  var fila = boton.closest(".cfila");
  var carne = fila.data('carne');
  var periodo = fila.data('periodo');
  var contenedor = boton.data('contentdetail');
  var overlay = boton.data('contentoverlay');
  
  $('#'+overlay).append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#'+contenedor+' #divcard_resultmat').html("");
  $.ajax({
    url: base_url + 'tesoreria_matricula/fn_asistencias_alumno',
    type: 'post',
    dataType: 'json',
    data: {txtbusca_carne: carne,cbperiodo: periodo},

    success: function(e) {
      
      $('#'+overlay+' #divoverlay').remove();

      if (e.status == false) {
        $('#'+contenedor+' #divcard_resultmat').html("");
      }else{
        var tabla = "";
        var tabody = "";
        var nro = 0;
        var asist = 0;
        var falta = 0;
        var tard = 0;
        var just = 0;
        tabla = tabla +
          '<div class="btable">'+
            '<div class="thead col-12  d-none d-md-block">'+
              '<div class="row">'+
                '<div class="col-md-3 td">DOCENTE</div>'+
                '<div class="col-md-4 td">UNIDAD DIDAC.</div>'+
                '<div class="col-md-5">'+
                  '<div class="row">'+
                    '<div class="col-md-3 td">ASIS</div>'+
                    '<div class="col-md-3 td">FALT</div>'+
                    '<div class="col-md-3 td">TARD</div>'+
                    '<div class="col-md-3 td">JUST</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div id="divcard_asistencias" class="tbody col-12 divcardresult_data">'+
              
            '</div>'+
          '</div>';
          $('#'+contenedor+' #divcard_resultmat').html(tabla);
          $('#'+contenedor+' #title_result').show();
          $('#'+contenedor+' #card_result_title').html("ASISTENCIAS");
          if (e.miscursos.length > 0) {
            $.each(e.miscursos, function(index, v) {
              nro++;
              var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
              
              tabody = tabody +
                '<div class="rowsfila row ' + rowcolor + ' " data-carga="'+v['idcarga']+'" data-miembro="'+v['idmiembro']+'">'+
                  '<div class="col-6 col-md-3 td">'+v['paterno'] + " " + v['materno'] + " " + v['nombres'] +'</div>'+
                  '<div class="col-6 col-md-4 td">'+v['curso'] +'</div>'+
                  '<div class="col-12 col-md-5">'+
                    '<div class="row">'+
                      '<div class=" col-3 col-md-3 td cellasis bg-success">'+asist+'</div>'+
                      '<div class=" col-3 col-md-3 td cellfalt bg-danger">'+falta+'</div>'+
                      '<div class=" col-3 col-md-3 td celltard bg-warning">'+tard+'</div>'+
                      '<div class=" col-3 col-md-3 td celljust bg-info">'+just+'</div>'+
                    '</div>'+
                  '</div>'+
                '</div>';
            })

            $('#'+contenedor+' #divcard_asistencias').html(tabody);
            $('#'+contenedor+' #divcard_asistencias').css('height','300px');
            $('#'+contenedor+' #fmt_conteo_data').html(nro+" Unidades didácticas encontradas");
            $('#'+contenedor+' #content_alumno').show();
            $('#'+contenedor+' #divcard_alumno').html(e.carnet+" - <br class='d-inline-block d-md-none'>"+e.alumno);
            $('#'+contenedor+' #divcard_asistencias .rowsfila').each(function() {
              fila=$(this);
              var carga = $(this).data('carga');
              var miembro = $(this).data('miembro');
              
              $.each(e.miscursosesta, function(index, val) {
                if ((carga==val['idcarga']) && (miembro==val['idmiembro'])) {
                  asist = val['asiste'];
                  falta = val['tarde'];
                  tard = val['falta'];
                  just = val['justif'];

                  fila.find('.cellasis').html(asist);
                  fila.find('.cellfalt').html(falta);
                  fila.find('.celltard').html(tard);
                  fila.find('.celljust').html(just);
                }
              })
            })
          }
      }
    },
    error: function (jqXHR, exception) {
      var msgf = errorAjax(jqXHR, exception, 'text');
      $('#'+overlay+' #divoverlay').remove();
      
    },  

  })
}

function fn_mostrar_notas(boton) {
  var fila = boton.closest(".cfila");
  var carne = fila.data('carne');
  var periodo = fila.data('periodo');
  var contenedor = boton.data('contentdetail');
  var overlay = boton.data('contentoverlay');
  $('#'+overlay).append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#'+contenedor+' #divcard_resultmat').html("");
  $.ajax({
    url: base_url + 'tesoreria_matricula/fn_notas_alumno',
    type: 'post',
    dataType: 'json',
    data: {txtbusca_carne: carne,cbperiodo: periodo},

    success: function(e) {
      
      $('#'+overlay+' #divoverlay').remove();
      if (e.status == false) {
        $('#'+contenedor+' #divcard_resultmat').html("");
      }else{
        var tabla = "";
        var tabody = "";
        var nro = 0;
        var nt = 0;
        var nr = 0;
        var nf = 0;
        var colornt = "";
        var colornr = "";
        var colornf = "";
        tabla = tabla +
          '<div class="btable">'+
            '<div class="thead col-12  d-none d-md-block">'+
              '<div class="row">'+
                '<div class="col-md-4 td">DOCENTE</div>'+
                '<div class="col-md-4 td">UNIDAD DIDAC.</div>'+
                '<div class="col-md-4">'+
                  '<div class="row">'+
                    '<div class="col-md-4 td">NT</div>'+
                    '<div class="col-md-4 td">NR</div>'+
                    '<div class="col-md-4 td">NF</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div id="divcard_notas" class="tbody col-12 divcardresult_data">'+
              
            '</div>'+
          '</div>';
          $('#'+contenedor+' #divcard_resultmat').html(tabla);
          $('#'+contenedor+' #title_result').show();
          $('#'+contenedor+' #card_result_title').html("NOTAS");
        if (e.miscursos.length > 0) {
          $.each(e.miscursos, function(index, v) {
            nro++;
            var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
            if (v['nota'] !==null) {
              nt = v['nota'];
            } else {
              nt = 0;
            }

            if (v['recuperacion'] !==null) {
              nr = v['recuperacion'];
            } else {
              nr = 0;
            }

            if (v['final'] !==null) {
              nf = v['final'];
            } else {
              nf = 0;
            }

            if (nt < 13) {
              colornt = "text-danger";
            } else {
              colornt = "text-primary"
            }

            if (nr < 13) {
              colornr = "text-danger";
            } else {
              colornr = "text-primary"
            }

            if (nf < 13) {
              colornf = "text-danger";
            } else {
              colornf = "text-primary"
            }
            tabody = tabody +
              '<div class="rowsfila row ' + rowcolor + ' " data-carga="'+v['idcarga']+'" data-miembro="'+v['idmiembro']+'">'+
                '<div class="col-6 col-md-4 td">'+v['paterno'] + " " + v['materno'] + " " + v['nombres'] +'</div>'+
                '<div class="col-6 col-md-4 td">'+v['curso'] +'</div>'+
                '<div class="col-12 col-md-4">'+
                  '<div class="row">'+
                    '<div class=" col-4 col-md-4 td '+colornt+'">'+nt+'</div>'+
                    '<div class=" col-4 col-md-4 td '+colornr+'">'+nr+'</div>'+
                    '<div class=" col-4 col-md-4 td '+colornf+' font-weight-bold">'+nf+'</div>'+
                  '</div>'+
                '</div>'+
              '</div>';
          })

          $('#'+contenedor+' #divcard_notas').html(tabody);
          $('#'+contenedor+' #divcard_notas').css('height','300px');
          $('#'+contenedor+' #fmt_conteo_data').html(nro+" Unidades didácticas encontradas");
          $('#'+contenedor+' #content_alumno').show();
          $('#'+contenedor+' #divcard_alumno').html(e.carnet+" - <br class='d-inline-block d-md-none'>"+e.alumno);
        }
      }
    }
  })
}

function fn_pagos_alumnos(boton) {
  var fila = boton.closest(".cfila");
  var carne = fila.data('carne');
  var periodo = fila.data('periodo');
  var contenedor = boton.data('contentdetail');
  var overlay = boton.data('contentoverlay');
  $('#'+overlay).append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#'+contenedor+' #divcard_resultmat').html("");
  $.ajax({
    url: base_url + 'tesoreria_matricula/fn_docpagos_alumno',
    type: 'post',
    dataType: 'json',
    data: {txtbusca_carne: carne,cbperiodo: periodo},

    success: function(e) {
      
      $('#'+overlay+' #divoverlay').remove();
      if (e.status == false) {
        $('#'+contenedor+' #divcard_resultmat').html("");
      }else{
        var tabla = "";
        var tabody = "";
        var tadetail = "";
        var nro = 0;
        var gestion = "";
        var igv = 0;
        var unitario = 0;
        tabla = tabla +
          '<div class="btable">'+
            '<div class="thead col-12  d-none d-md-block">'+
              '<div class="row">'+
                '<div class="col-md-3 td">TIP/NRO</div>'+
                '<div class="col-md-9">'+
                  '<div class="row">'+
                    '<div class="col-md-6 td">PAGANTE</div>'+
                    '<div class="col-md-3 td">MONTO</div>'+
                    '<div class="col-md-3 td">IGV</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div id="divcard_pagos" class="tbody col-12 divcardresult_data">'+
              
            '</div>'+
          '</div>';
        $('#'+contenedor+' #divcard_resultmat').html(tabla);
        $('#'+contenedor+' #title_result').show();
        $('#'+contenedor+' #card_result_title').html("PAGOS");
        $('#'+contenedor+' #divcard_pagos').html(e.pagos);
        $('#'+contenedor+' #divcard_pagos').css('height',e.alto);
        $('#'+contenedor+' #fmt_conteo_data').html(e.mensaje);
        $('#'+contenedor+' #content_alumno').show();
        $('#'+contenedor+' #divcard_alumno').html(e.carnet+" - <br class='d-inline-block d-md-none'>"+e.alumno);
      }
    }
  })
}

function fn_bloquea_notas(boton) {
  var fila = boton.closest(".cfila");
  var periodo = fila.data('periodo');
  var student = fila.data('student');

  var idmatricula = fila.data('idm');
  var isedit = boton.data("edit");
  if (isedit == "1") {
    valor = "NO";
    
  } else {
    valor = "SI";
  }
  $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
    url: base_url + 'tesoreria_matricula/fn_update_bloqueo',
    type: 'post',
    dataType: 'json',
    data: {
        idmatricula: idmatricula,
        estado: valor,
        periodo: periodo,
        student: student
    },
    success: function(e) {
        $('#divcard-matricular #divoverlay').remove();
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

          if (valor == 'SI') {
            boton.data('edit','1');
            boton.html('<i class="far fa-times-circle fa-lg text-danger"></i>');
          } else {
            boton.data('edit','0');
            boton.html('<i class="far fa-check-circle fa-lg text-success"></i>');
          }

          // $("#frmfiltro-matriculas").submit();
          // $("#fispedit").html("");
        }
    },
    error: function(jqXHR, exception) {
        var msgf = errorAjax(jqXHR, exception,'text');
        $('#divcard-matricular #divoverlay').remove();
        Swal.fire({
            type: 'error',
            icon: 'error',
            title: 'ERROR, NO se guardó cambios',
            text: msgf,
            backdrop:false,
        });
    },
  })
}

function fn_bloquea_acceso(boton) {
  var fila = boton.closest(".cfila");
  var student = fila.data('student');
  var viduser = boton.data('user');
  var vactivo = boton.data('estado');

  var vtitle='¿Deseas desactivar a ' + student + '?';
  var vtext="Al desactivarlo, el usuario no podrá acceder al sistema, permaneceran inactivos hasta reactivarlo";
  var vbtext='Si, desactivar!';
  if (vactivo=="SI"){
    vtitle='¿Deseas activar a ' + student + '?';
    vtext="Al Activarlo, el usuario podrá acceder al sistema";
    vbtext='Si, Activar!';
  }

  Swal.fire({
      title: vtitle,
      text: vtext,
      type: 'warning',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: vbtext
  }).then((result) => {
    if (result.value) {
        $('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'usuario/fn_activado',
            type: 'POST',
            data: {activo: vactivo,iduser: viduser,student: student},
            dataType: 'json',
            success: function(e) {
              $('#divcard-matricular #divoverlay').remove();
              if (e.status==true){
                  if (vactivo=='SI'){

                    boton.data('estado', 'NO');
                    boton.html('<i class="fas fa-user-check fa-lg text-success"></i>');
                    // btn.html("<i class='fas fa-user-check'></i> <span class='d-block d-md-none'> Desactivar </span>")
                  }
                  else{
                    
                    boton.data('estado', 'SI');
                    boton.html('<i class="fas fa-user-times fa-lg text-danger"></i>');
                    // btn.html("<i class='fas fa-user-times'></i> <span class='d-block d-md-none'> Activar </span>")
                  }
                  
                  Swal.fire(
                    'Éxito!',
                    'La división '+ student + ' fue modificado correctamente.',
                    'success'
                  )
              }
              else{
                 resolve(e.msg);
              }
            },
            error: function(jqXHR, exception) {
                $('#divcard-matricular #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire(
                  'Error!',
                  msgf,
                  'error'
                )
            }
        })
    }
  })
  
}

$("#frmfiltro-grupos").submit(function(event) {
    var sb=getUrlParameter("sb","");
    var jsparamSidebar=(sb=="")?"":"sb=" + sb + "&";
    $('#divcard_gruposmat').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#divFiltroGrupos").html("");
    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(e) {
          if (e.status==false){
          }
          else{
              var nro=0;
              var mt=0;
              var ac=0;
              var rt=0;
              var cl=0;
              var btn_culminar = "";
              var btnbloquea = "";
              var vbloquea = "";
              $.each(e.vdata, function(index, v) {
                /* iterate through array or object */
                nro++;
                mt=mt + parseInt(v['mat']);
                ac=ac + parseInt(v['act']);
                rt=rt + parseInt(v['ret']);
                cl=cl + parseInt(v['cul']);
                
                var btn_carga='';
                var params='cp='+ v['codperiodo'] +'&cc='+ v['codcarrera'] + '&ccc='+ v['codciclo'] +'&ct='+ v['codturno']+'&cs='+ v['seccion']+'&cpl='+ v['idplan'];


                

                  btn_matriculas='<a onclick="fnMostrarEstudiantes($(this))" class="dropdown-item" href="#"><i class="fas fa-user mr-1"></i> Estudiantes</a>';
                
                if (v['bloqueo'] > 0) {
                  vbloquea = "";
                } else {
                  vbloquea = "checked";
                }

                if (vpermiso127 =='SI') {
                  btnbloquea = '<i class="fas fa-lock mr-1"></i>' + 
                              '<div class="custom-control custom-switch d-inline-block ">' +
                                '<input type="checkbox" '+vbloquea+' class="custom-control-input" id="chkBloquear'+ nro + '" onchange="fn_habilita_notas_grupo($(this));return false;">' +
                                '<label class="custom-control-label" for="chkBloquear'+ nro + '"></label>' +
                              '</div>' +
                              '<i class="fas fa-lock-open"></i>';
                } else {
                  btnbloquea = "";
                }

                 /*btn_matricular='<a class="dropdown-item" data-periodo=' + v['codperiodo'] + ' data-carrera=' + v['codcarrera'] + ' data-ciclo=' + v['codciclo'] + ' data-turno=' + v['codturno'] + ' data-seccion=' + v['seccion'] + ' data-plan=' + v['idplan'] + ' title="Agregar matrícula" href="#" data-toggle="modal" data-target="#modal-addalumno"><i class="fas fa-user-plus mr-1"></i> Matrícula Rápida</a>';*/
                 
                 
                $("#divFiltroGrupos").append(
                '<div class="row rowcolor cfila" data-sed="'+ v['codsede'] +'" data-per="'+ v['codperiodo'] +'" data-car="'+ v['codcarrera'] + '" data-cic="'+ v['codciclo'] +'" data-tur="'+ v['codturno']+'" data-sec="'+ v['seccion']+'" data-plan="'+ v['idplan']+'" data-periodo="'+ v['periodo'] +'" data-carrera="'+ v['carrera'] + '" data-ciclo="'+ v['ciclo'] +'" data-turno="'+ v['turno']+'" data-seccion="'+ v['seccion']+'" data-plann="'+ v['plan'] + '">' + 
                  '<div class="col-12 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="col-2 col-md-2 td">' + nro + '</div>' +
                      '<div class="col-4 col-md-3 td">' + v['sede_abrevia'] + '</div>' +
                      '<div class="col-4 col-md-3 td">' + v['periodo'] + '</div>' + 
                      '<div class="col-6 col-md-4 td" title="' + v['idplan']  +'">' + v['plan'] + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  
                  '<div class="col-12 col-md-4">' + 
                    '<div class="row">' + 
                      '<div class="col-8 col-md-8 td">' + v['carrera'] + '</div>' +
                      '<div class="col-4 col-md-4 td">' + v['ciclo'] + " - <b>" + v['turno'] + "</b> - " + v['seccion'] + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  '<div class="col-12 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="td col-3 col-md-3 text-right text-bold">' + v['mat'] + '</div>' + 
                      '<div class="td col-3 col-md-3 text-right text-primary text-bold">' + v['act'] + '</div>' + 
                      '<div class="td col-3 col-md-3 text-right text-danger text-bold">' + v['ret'] + '</div>' + 
                      '<div class="td col-3 col-md-3 text-right text-success text-bold">' + v['cul'] + '</div>' + 
                    '</div>' + 
                  '</div>' + 

                  
                                   
                  '<div class="col-12 col-md-2 ">' + 
                    '<div class="row">' + 
                      '<div class="col-6 col-md-6 td text-center">' + 
                        btnbloquea + 
                      '</div>' +
                      '<div class="col-6 col-md-6 td text-right">' + 
                        '<a href="#" class="badge badge-primary" onclick="fnCallModalEstudiantes($(this))"><i class="fas fa-users"></i></a>' +
                        '<div class="btn-group btn-group-sm p-0 " role="group">' + 
                          '<button class="bg-primary text-white rounded border-0 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                              '<i class="fas fa-cog"></i>' +
                          '</button>' +
                          '<div class="dropdown-menu dropdown-menu-right">' +
                              btn_matriculas +
                              '<div class="dropdown-divider"></div>' + 
                              //btn_matricular + 
                          ' </div>' +
                        '</div>' +
                      '</div>' +
                    '</div>' +
                  '</div>' +
                '</div>');
                //btn btn-success btn-sm 
              });
                $("#divFiltroGrupos").append(
                '<div class="row text-bold">' + 
                  '<div class="col-4 col-md-7">' + 
                   
                  '</div>' + 
                  '<div class="col-6 col-md-3">' + 
                    '<div class="row">' + 
                      '<div class="td col-3 col-md-3 text-right text-bold">' + mt + '</div>' + 
                      '<div class="td col-3 col-md-3 text-right text-primary text-bold">' + ac + '</div>' + 
                      '<div class="td col-3 col-md-3 text-right text-danger text-bold">' + rt + '</div>' + 
                      '<div class="td col-3 col-md-3 text-right text-success text-bold">' + cl + '</div>' + 
                    '</div>' + 
                  '</div>' + 
                  '<div class="col-6 col-md-2">' + 
                    '<div class="row">' + 
                     
                    '</div>' + 
                  '</div>' + 
                '</div>');
              $('#divcard_gruposmat #divoverlay').remove();
          }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard_gruposmat #divoverlay').remove();
        }
    });
    return false;
});

function  fnMostrarEstudiantes(boton){
  var fila=boton.closest('.cfila');
  $('.nav-tabs a[href="#tabEstudiantes"]').tab('show');

  $("#fmt-cbperiodo").val(fila.data("per"));
  $("#fmt-cbcarrera").val(fila.data("car"));
  $("#fmt-cbciclo").val(fila.data("cic"));
  $("#fmt-cbturno").val(fila.data("tur"));
  $("#fmt-cbseccion").val(fila.data("sec"));
  $("#fmt-cbplan").val(fila.data("plan"));

}

function  fnCallModalEstudiantes(boton){
  var fila=boton.closest('.cfila');
  $("#mbe-cbperiodo").val(fila.data("per"));
  $("#mbe-cbcarrera").val(fila.data("car"));
  $("#mbe-cbciclo").val(fila.data("cic"));
  $("#mbe-cbturno").val(fila.data("tur"));
  $("#mbe-cbseccion").val(fila.data("sec"));
  $("#mbe-cbplan").val(fila.data("plan"));
  $("#mbe-cbsede").val(fila.data("sed"));
  $('#mdBloqueoEstudiantes').modal('show');
  
  $("#mbeFiltroMatriculas").submit();
}

$("#mbeFiltroMatriculas").submit(function(event) {
    //$('#divcard-matricular').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    $("#mbeDivRsEstudiantes").html(getCargando());
    mbecbsede=$("#mbe-cbsede").val();
    mbecbperiodo=$("#mbe-cbperiodo").val();
    mbecbcarrera=$("#mbe-cbcarrera").val();
    mbecbciclo=$("#mbe-cbciclo").val();
    mbecbturno=$("#mbe-cbturno").val();
    mbecbseccion=$("#mbe-cbseccion").val();
    mbecbplan=$("#mbe-cbplan").val();

    $.ajax({
        url: $(this).attr("action"),
        type: 'post',
        dataType: 'json',
        data: {
          "fmt-cbsede":mbecbsede,
          "fmt-cbperiodo":mbecbperiodo,
          "fmt-cbcarrera":mbecbcarrera,
          "fmt-cbciclo":mbecbciclo,
          "fmt-cbturno":mbecbturno,
          "fmt-cbseccion":mbecbseccion,
          "fmt-cbplan":mbecbplan
        },
        success: function(e) {
            if (e.status == false) {
            } 
            else {
                var nro = 0;
                if (e.vdata.length > 0) {
                  var content_detail = "mdBloqueoEstudiantes";
                  var divcardoverlay = "mdDivBloqueoEstudiantes";
                  $("#mbeDivRsEstudiantes").html("");
                  $.each(e.vdata, function(index, v) {
                      nro++;
                      var dataedit = "";
                      var icono = "";
                      var iconous = "";
                      var cambious = "";
                      var vcm = v['codmatricula64'];
                      var periodo = base64url_encode(v['codperiodo']);
                      var vuser = base64url_encode(v['userid']);
                      var rowcolor = (nro % 2 == 0) ? 'bg-lightgray' : '';
                      var bloquear = "";
                      var usbloqueo = "";
                      var montodeuda = "";
                      var student = v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'];
                      
                      if (v['bloqueo'] == "SI") {
                        dataedit = "1";
                        icono = '<i class="far fa-times-circle fa-lg text-danger"></i>';
                      } else {
                        dataedit = "0";
                        icono = '<i class="far fa-check-circle fa-lg text-success"></i>';
                      }

                      if (vpermiso127 =='SI') {
                        bloquear = '<a onclick="fn_bloquea_notas($(this));return false;" class="h7" style="cursor:pointer" title="" data-edit="'+dataedit+'">'+icono+'</a>';
                      } else {
                        bloquear = "";
                      }

                      if (v['estadouser'] == "SI") {
                        cambious = "NO";
                        iconous = '<i class="fas fa-user-check fa-lg text-success"></i>';
                      } else {
                        cambious = "SI";
                        iconous = '<i class="fas fa-user-times fa-lg text-danger"></i>';
                      }

                      if (vpermiso166 == "SI") {
                        usbloqueo = '<a onclick="fn_bloquea_acceso($(this));return false;" class="h7" style="cursor:pointer" title="" data-estado="'+cambious+'" data-user="'+vuser+'">'+iconous+'</a>';
                      } else {
                        usbloqueo = "";
                      }

                      if (v['deuda'] != null) {
                        montodeuda = v['deuda'];
                      } else {
                        montodeuda = "0.00";
                      }

                      $("#mbeDivRsEstudiantes").append(
                          '<div data-idm="' + vcm + '" data-carne="'+v['carne']+'" data-periodo="'+periodo+'" data-student="'+student+'" class="cfila row ' + rowcolor + ' ">' +
                            '<div class="col-4 col-md-2">' +
                              '<div class="row">' +
                                '<div class="col-3 col-md-3 td">' + nro + '</div>' +
                                '<div class="ccarne col-9 col-md-9 td">' + v['carne'] + '</div>' +
                              '</div>' +
                            '</div>' +
                            '<div class="col-4 col-md-4 td">' +
                              
                                    v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + 
                                
                            '</div>' +
                            '<div class="col-12 col-md-5 text-center">'+
                              '<div class="row">' +
                                '<div class="col-3 col-md-2 td text-center">'+
                                  '<a onclick="fn_mostrar_notas($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Notas" data-contentdetail="'+content_detail+'" data-contentoverlay="'+divcardoverlay+'"><i class="fas fa-lg fa-paste"></i></a>'+
                                '</div>' +
                                '<div class="col-3 col-md-2 td text-center">'+
                                  '<a onclick="fn_mostrar_asistencias($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Asistencias" data-contentdetail="'+content_detail+'" data-contentoverlay="'+divcardoverlay+'"><i class="far fa-lg fa-calendar-alt"></i></a>'+
                                '</div>' +
                                '<div class="col-3 col-md-6 td text-center">'+
                                  '<a onclick="fnGetEstudianteEstadistica($(this));return false;" class="text-primary h7" style="cursor:pointer" title="Pagos">' +
                                    '<i class="far fa-lg fa-money-bill-alt"></i> S/. ' + montodeuda+ '</a>'+
                                '</div>' +
                                '<div class="col-3 col-md-2 td text-center">'+
                                  bloquear+
                                '</div>' +
                              '</div>' +
                            '</div>' +
                            '<div class="col-8 col-md-1 td text-center">' +
                              usbloqueo +
                            '</div>' +
                          '</div>');
                  });

                  $('#mbeDivRsEstudiantes').css('height','300px');
                  
                } else {
                  $('#mbeDivRsEstudiantes').css('height','auto');
                }

                $('#divcard_ltsmatriculas').show();
                $("#fmt-conteo").html(nro + ' matriculas encontradas');
                $('#divcard-matricular #divoverlay').remove();
                //********************************************/
                
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard-matricular #divoverlay').remove();
            //$('#divError').show();
            //$('#msgError').html(msgf);
        }
    });
    return false;
});

function fnGetEstudianteEstadistica(boton) {
  var fila = boton.closest(".cfila");
  var carne = fila.data('carne');
  var periodo = fila.data('periodo');
  $('#mdDivBloqueoEstudiantes').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $('#mdBloqueoEstudiantes #divcard_resultmat').html("");
  $.ajax({
    url: base_url + 'tesoreria_matricula/fnEstudianteEstadistica',
    type: 'post',
    dataType: 'json',
    data: {txtbusca_carne: carne,cbperiodo: periodo},

    success: function(e) {
      
      $('#mdDivBloqueoEstudiantes #divoverlay').remove();
      if (e.status == false) {
        $('#mdBloqueoEstudiantes #divcard_resultmat').html("");
      }else{
        var tabla = "";
        var tabody = "";
        var tadetail = "";
        var nro = 0;
        var gestion = "";
        var igv = 0;
        var unitario = 0;
        tabla = tabla +
          '<div class="row">'+
            '<div class="col-12  d-none d-md-block">'+
              '<div class="row">'+
                '<div class="col-md-3 td">TIP/NRO</div>'+
                '<div class="col-md-9">'+
                  '<div class="row">'+
                    '<div class="col-md-6 td">PAGANTE</div>'+
                    '<div class="col-md-3 td">MONTO</div>'+
                    '<div class="col-md-3 td">IGV</div>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div id="divcard_pagos" class="col-12 divcardresult_data">'+
              
            '</div>'+
          '</div>';
        $('#mdBloqueoEstudiantes #divcard_resultmat').html(tabla);

        //$('#title_result').show();
        $('#mdBloqueoEstudiantes #card_result_title').html("Pagos / Deudas");
        $('#mdBloqueoEstudiantes #divcard_pagos').html(e.pagos);
        //$('#divcard_pagos').css('height',e.alto);
        $('#mdBloqueoEstudiantes #fmt_conteo_data').html(e.mensaje);
        //$('#content_alumno').show();
        $('#mdBloqueoEstudiantes #divcard_alumno').html(e.carnet + " "+e.alumno);
      }
    }
  })
}

$("#mdBloqueoEstudiantes").on('hidden.bs.modal', function(e) {
  $('#mdBloqueoEstudiantes #divcard_resultmat').html('');
  $('#mdBloqueoEstudiantes #fmt_conteo_data').html('');
  $('#mdBloqueoEstudiantes #divcard_alumno').html('');
})

function fn_habilita_notas_grupo(boton) {
  fila = boton.closest('.cfila');
  sede = fila.data('sed');
  periodo = fila.data('per');
  carrera = fila.data('car');
  turno = fila.data('tur');
  ciclo = fila.data('cic');
  seccion = fila.data('sec');
  vplan = fila.data('plan');
  nmcarrera = fila.data('carrera');

  if(boton.is(':checked')){
    bloquea = "NO";
  } else {
    bloquea = "SI";
  }
  $('#divcard_gruposmat').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'tesoreria_matricula/fn_habilita_notas_grupo',
      type: 'POST',
      data: {
        'fmt-cbsede': sede,
        'fmt-cbperiodo': periodo,
        'fmt-cbcarrera': carrera,
        'fmt-nmcarrera': nmcarrera,
        'fmt-cbciclo': ciclo,
        'fmt-cbturno': turno,
        'fmt-cbseccion': seccion,
        'fmt-cbplan':vplan,
        'fmt-bloquea': bloquea,
      },
      dataType: 'json',
      success: function(e) {
        $('#divcard_gruposmat #divoverlay').remove();
        if (e.status==true){
          if (bloquea == "NO") {
            boton.prop('checked', true);
            // boton.data('activo', 'NO');
          } else {
            boton.prop('checked', false);
            // boton.data('activo', 'SI');
          }

          Swal.fire(
            'Éxito!',
            'Los cambios fueron modificados correctamente.',
            'success'
          )
        }
        else{
           resolve(e.msg);
        }
      },
      error: function(jqXHR, exception) {
        $('#divcard_gruposmat #divoverlay').remove();
          var msgf = errorAjax(jqXHR, exception, 'text');
          Swal.fire(
            'Error!',
            msgf,
            'error'
          )
      }
  })
}

</script>