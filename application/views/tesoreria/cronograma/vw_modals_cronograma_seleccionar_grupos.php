<div class="modal fade" id="modGrupos_matriculados" tabindex="-1" role="dialog" aria-labelledby="modGrupos_matriculados" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content modGrupos_matriculados_content">
      <div class="modal-header">
        <h5 class="modal-title" >Grupos Académicos Asignar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-12" id="divModalCronogramaSeleccionarGrupos">
          <form id="frmfiltro-grupos" name="frmfiltro-grupos"  method="post" accept-charset='utf-8'>
            <div class="row">
              <div class="form-group has-float-label col-12 col-sm-4 col-md-2">
                <select  class="form-control form-control-sm" id="fm-cbsede" name="fm-cbsede" placeholder="Filial">
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
                  <?php foreach ($periodos as $periodo) {?>
                  <option value="<?php echo $periodo->codigo ?>"><?php echo $periodo->nombre ?></option>
                  <?php } ?>
                </select>
                <label for="fm-cbperiodo"> Periodo</label>
              </div>
              
              <div class="form-group has-float-label col-12 col-sm-3">
                <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbcarrera" name="fm-cbcarrera" placeholder="Programa Académico" required >
                  <option value="%">Todos</option>
                  <?php
                  foreach ($carrera as $carr) {
                  echo '<option value="'.$carr->codigo.'">'.$carr->nombre.'</option>';
                  }
                  ?>
                </select>
                <label for="fm-cbcarrera"> Prog. de Estudios</label>
              </div>

              <div class="form-group has-float-label col-12 col-sm-3 col-md-2">
                <select name="fm-cbplan" id="fm-cbplan"class="form-control form-control-sm">
                  <option data-carrera="0" value="%">Todos</option>
                  <option data-carrera="0" value="0">Sin Plan</option>
                  <?php foreach ($planes as $pln) {
                  echo "<option data-carrera='$pln->codcarrera' value='$pln->codplan'>$pln->nombre</option>";
                  } ?>
                </select>
                <label for="fm-cbplan">Plan estudios</label>
              </div>
              <div class="form-group has-float-label col-12 col-sm-2">
                <select data-currentvalue='' class="form-control form-control-sm" id="fm-cbciclo" name="fm-cbciclo" placeholder="Ciclo" required >
                  <option value="%">Todos</option>
                  <?php
                  foreach ($ciclos as $cic) {
                  echo '<option value="'.$cic->codigo.'">'.$cic->nombre.'</option>';
                  }
                  ?>
                </select>
                <label for="fm-cbciclo"> Semestre</label>
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
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>
       
          <div class="table-responsive">
            <table id="tbcg_dtGruposSeleccionar" class="tbdatatable tbdatatableModal table table-sm table-hover  table-bordered table-condensed" style="width:100%">
              <thead>
                <tr class="bg-lightgray ">
                  <th>N°</th>
                  <th>CRONOGRAMA</th>
                  <th>PERIODO</th>
                  <th>PLAN</th>
                  <th>PROGRAMA</th>
                  <th>SEMESTRE</th>
                  <th>TURNO</th>
                  <th>SECCION</th>
                  <th>MAT.</th>
                  <th>RET.</th>
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
  function fn_vw_agregar_grupo(btn) {
      //var idcalendario = $("#vw_cmd_codCalendario").val();
      var vcodPeriodo = $("#vw_cmd_codPeriodo").val();
      var vcodCalendario64 = $("#vw_cmd_codCalendario64").val();
      var vcodSede = $("#vw_cmd_codSede").val();
      //modCronogramaDetalle
      $("#modGrupos_matriculados #fm-cbsede").val(vcodSede);
      $("#modGrupos_matriculados #fm-cbsede option").each(function(i) {
          if ($(this).hasClass("ocultar")) $(this).removeClass('ocultar');
          if ($(this).val() == vcodSede) {

          }
          else {
              if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');

          }
      });
      $("#modGrupos_matriculados #fm-cbperiodo").val(vcodPeriodo);
      $("#modGrupos_matriculados #fm-cbperiodo option").each(function(i) {
          if ($(this).val() == vcodPeriodo) {
              //$(this).attr('selected', true);
          } else {
              if (!$(this).hasClass("ocultar")) $(this).addClass('ocultar');
          }
      });

      //$('#modGrupos_matriculados #vw_id_calendario_grp').val(vcodCalendario64);
      $("#modGrupos_matriculados").modal("show");

  }

  $("#frmfiltro-grupos").submit(function(event) {

      $('#divModalCronogramaSeleccionarGrupos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      vcodCalendario= $("#vw_cmd_codCalendario").val();
      $.ajax({
          url: base_url + "deudas/deudas_calendario_grupo/fn_getTodosLosGrupos",
          type: 'post',
          dataType: 'json',
          data: $(this).serialize(),
          success: function(e) {
              if (e.status == false) {} else {
                  tbGrupos = $('#tbcg_dtGruposSeleccionar').DataTable();
                  tbGrupos.clear();
                  $.each(e.vgrupos, function(index, val) {
                    linkAccionGrupo="";
                    if (val['codcalendario']==0){
                       linkAccionGrupo = "<a class='py-1 badge badge-success text-white' href='#' onclick='fn_agregarGrupoDeuda($(this));return false'><i class='fas fa-plus-circle mr-1'></i>Agregar</a>";
                    }
                    else if (val['codcalendario']!=vcodCalendario){
                      linkAccionGrupo = "<a class='py-1 badge badge-primary text-white' href='#' onclick='fn_agregarGrupoDeuda($(this));return false'><i class='fas fa-share mr-1'></i>Migrar</a>";
                    }
                     
                    var arrayGrupo_new = [
                        (index + 1),
                        val['calendario'],
                        val['periodo'],
                        val['plan'],
                        val['carrera'],
                        val['ciclo'],
                        val['turno'],
                        val['seccion'],
                        val['mat'],
                        val['ret'],
                        linkAccionGrupo
                    ];
                    var filaGrupo_new = tbGrupos.row.add(arrayGrupo_new).node();
                    $(filaGrupo_new).attr('data-codperiodo', val['codperiodo']);
                    $(filaGrupo_new).attr('data-codcarrera', val['codcarrera']);
                    $(filaGrupo_new).attr('data-codplan', val['codplan']);
                    $(filaGrupo_new).attr('data-codciclo', val['codciclo']);
                    $(filaGrupo_new).attr('data-codturno', val['codturno']);
                    $(filaGrupo_new).attr('data-codseccion', val['seccion']);
                    $(filaGrupo_new).attr('data-codgrupo64', val['codgrupo64']);
                    $(filaGrupo_new).addClass("cfila");

                  });
                  tbGrupos.draw();




                  $('#divModalCronogramaSeleccionarGrupos #divoverlay').remove();
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#divModalCronogramaSeleccionarGrupos #divoverlay').remove();
          }
      });
      return false;
  });

  function fn_agregarGrupoDeuda(btn) {
      var id64calendario = $('#vw_cmd_codCalendario64').val();
      var fila = btn.closest('.cfila');
      var periodo = fila.data('codperiodo');
      var programa = fila.data('codcarrera');
      var plan = fila.data('codplan');
      
      var semestre = fila.data('codciclo');
      var turno = fila.data('codturno');
      var seccion = fila.data('codseccion');
      $('#modGrupos_matriculados input,select').removeClass('is-invalid');
      $('#modGrupos_matriculados .invalid-feedback').remove();
      $('#modGrupos_matriculados .modGrupos_matriculados_content').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: base_url + "deudas_grupo/fn_guardar",
          type: 'post',
          dataType: 'json',
          data: {
              vw_dg_idcalend: id64calendario,
              vw_dg_cbperiodo: periodo,
              vw_dg_cbcarrera: programa,
              vw_dg_cbplan: plan,
              vw_dg_cbciclo: semestre,
              vw_dg_cbturno: turno,
              vw_dg_cbseccion: seccion
          },
          success: function(e) {
              $('#modGrupos_matriculados .modGrupos_matriculados_content #divoverlay').remove();
              if (e.status == false) {
                  $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                  });
              } else {
                  // $("#modGrupos_matriculados").modal("hide");
                  fila.remove();
                  Swal.fire({
                      title: e.msg,
                      // text: "",
                      type: 'success',
                      icon: 'success',
                  })

              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              $('#modGrupos_matriculados .modGrupos_matriculados_content #divoverlay').remove();
              Swal.fire({
                  title: msgf,
                  // text: "",
                  type: 'error',
                  icon: 'error',
              })
          }
      });
  };
</script>