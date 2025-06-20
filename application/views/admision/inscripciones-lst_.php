<div class="col-12 py-1" id="divdata-periodo">
  <div class="btable">
    <div class="thead col-12  d-none d-md-block">
      <div class="row">
            <div class='col-12 col-md-3'>
                <div class='row'>
                    <div class='col-1 col-md-2 td'>N°</div>
                    <div class='col-5 col-md-3 td'>PERIODO</div>
                    <div class='col-5 col-md-4 td'>CAMPAÑA</div>
                    <div class='col-3 col-md-3 td text-center'>PROG.</div>
                    
                </div>
            </div>
            <div class='col-12 col-md-5'>
                <div class='row'>
                  <div class='col-3 col-md-3 td text-center'>CARNÉ</div>
                  <div class='col-6 col-md-9 td'>ESTUDIANTE</div>
                  
                  
                  
                </div>
            </div>
            <div class='col-12 col-md-3 text-center'>
                <div class='row'>
                    <div class='col-4 col-md-4 td'>FEC. INSC.</div>
                    <div class='col-3 col-md-3 td'>
                        <span>ESTADO</span>
                    </div>
                    <div class='col-5 col-md-5 td'>
                        <span></span>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
    <div class="tbody col-12" id="divcard_data_inscritos">
      <?php
      $nro=0;
      $cd1=base64url_encode("ACTIVO");
      $cd2=base64url_encode("RETIRADO");
      $cd3=base64url_encode("EGRESADO");
      $cd4=base64url_encode("TITULADO");
      $cd5=base64url_encode("POSTULA");
      $btndelete = "";
      foreach ($historial as $usuario) {
        $fn="";
        $nro++;
        $nombres=$usuario->paterno.' '.$usuario->materno.', '.$usuario->nombres;
        $idins=base64url_encode($usuario->codinscripcion);
        //$carne=base64url_encode($usuario->carnet);
        $codperiodo=base64url_encode($usuario->codperiodo);

        $ciclo = $usuario->codciclo;

        $calledit="";
        $urlprint=base_url()."admision/postulante/imprimir/$codperiodo/$idins";
        
        $btnscolor="";
        $classbtndis="";
        //$usuario->estado=substr($usuario->estado, 0,3);
        //ACTIVO,POSTULANTE,RETIRADO,EGRESADO,TITULADO
        switch($usuario->estado) {
          case "ACTIVO":
              $btnscolor="btn-success";
              $classbtndis = "not-active";
            break;
          case "POSTULA":
              $btnscolor="btn-warning";
              $classbtndis = "";
            break;
          case "EGRESADO":
              $btnscolor="btn-secondary";
              $classbtndis = "not-active";
            break;
          case "RETIRADO":
            $btnscolor="btn-danger";
            $classbtndis = "";
            break;
          case "TITULADO":
            $btnscolor="btn-info";
            $classbtndis = "not-active";
            break;
          default:
            $btnscolor="btn-warning";
            $classbtndis = "not-active";
        }

        if (getPermitido("124")=='SI'){
          $btndelete = "<a href='#' data-ci='$idins' class='btn-delete dropdown-item text-danger text-bold'><i class='fas fa-trash-alt'></i> Eliminar</a>";
        }

      ?>
      <div class='row rowcolor cfila' data-ci="<?php echo $idins ?>" data-cp='<?php echo $usuario->codperiodo ?>' data-codcampania='<?php echo $usuario->codcampania ?>' data-cic='<?php echo $ciclo ?>'
        data-codciclo=<?php echo $usuario->codciclo ?> data-codturno=<?php echo $usuario->codturno ?> data-codseccion="<?php echo $usuario->codseccion ?>" data-carrera="<?php echo $usuario->carrera ?>">
        <div class='col-12 col-md-4'>
          <div class='row'>
            <div class='col-2 col-md-1 td'><?php echo $nro ?></div>
            <div class='col-5 col-md-2 td'><?php echo $usuario->periodo ?></div>
            <div class='col-1 col-md-3 td text-center'><?php echo $usuario->campania ?></div>
            <div class='col-2 col-md-6 td text-center vw_cell_grupo' title="<?php echo $usuario->carrera ?>">
              <?php echo "$usuario->carsigla / $usuario->codturno - <b>$usuario->ciclo</b> - $usuario->codseccion" ?> 
              <?php if (getPermitido("141")=='SI') { ?>
              <a onclick="grupo_inscripcion($(this))" href="#">
                <i class="far fa-edit ml-2"></i>
              </a>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class='col-12 col-md-4'>
          <div class='row'>
            
            <div class='col-3 col-md-3 td cell-carne' title="<?php echo $usuario->codinscripcion ?>"><?php echo $usuario->carnet ?></div>
            <div class='col-7 col-md-9 td'>
              <b class="mr-2"><?php echo ($usuario->sexo=='MASCULINO') ? '<i class="fas fa-male fa-lg text-primary"></i>':'<i class="fas fa-female  fa-lg text-danger"></i>' ?> </b>
              <span class="cell-alumno"><?php echo $nombres ?></span>
            </div>
            
          </div>
        </div>
        <div class='col-12 col-md-4 text-center'>
          <div class='row'>
            <div class='col-2 col-md-3 td'><?php echo date("d-m-Y", strtotime($usuario->fecinsc)); ?></div>
            <div class='col-4 col-md-5 td'>
              <?php //if ($usuario->estado != "RETIRADO"): ?>
              <div class="btn-group" id="btn-group-<?php echo $idins ?>">  
                <button class="btn <?php echo $btnscolor ?> btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                  <?php echo $usuario->estado ?>
                </button> 
                <div class="dropdown-menu">
                  <?php if ($usuario->estado != "RETIRADO"): ?>
                    <?php if (getPermitido("142")=='SI') { ?>
                    <a href="#" class="btn-cestado dropdown-item" data-color='btn-success' data-ie="<?php echo $cd1 ?>">Activo</a> 
                    <a href="#" class="dropdown-item" data-color='btn-danger' data-ie="<?php echo $cd2 ?>" data-toggle="modal" data-target="#modretirainsc" id="btnretira_inscrip<?php echo $idins ?>">Retirado</a> 
                    <a href="#" class="btn-cestado dropdown-item" data-color='btn-secondary' data-ie="<?php echo $cd3 ?>">Egresado</a> 
                    <a href="#" class="btn-cestado dropdown-item" data-color='btn-info' data-ie="<?php echo $cd4 ?>">Titulado</a> 
                    <a href="#" class="btn-cestado dropdown-item" data-color='btn-warning' data-ie="<?php echo $cd5 ?>">Postula</a> 
                    <div class="dropdown-divider"></div> 
                    <?php } ?>
                    <?php else: ?>
                    <?php if (getPermitido("150")=='SI') { ?>
                    <a href="#" class="btn_actestado dropdown-item" data-color='btn-success' data-ie="<?php echo $cd1 ?>" id="btnactiva_ins_<?php echo $idins ?>">Activo</a> 
                    <?php } ?>
                     <?php endif ?>
                    <?php echo $btndelete ?>
                </div> 
              </div>
            </div>
            <div class='col-8 col-md-4 td'>
              <div class="row">
                <div class="col-6 col-md-6">
                  <div class='btn-group'>
                    <a type='button' class='text-white bg-warning dropdown-toggle px-2 py-1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-cog'></i>
                    </a>
                    <div class='dropdown-menu dropdown-menu-right acc_dropdown'>
                        <?php if (getPermitido("140")=='SI') { ?>
                        <a class='dropdown-item' href='#' title='Editar Inscripción'>
                            <i class='fas fa-edit mr-2'></i> Editar Inscripción
                        </a>
                        <?php } ?>
                        <a class='dropdown-item btn-anexados' href='#' title='Documentos Anexados' data-ci="<?php echo $idins ?>" data-toggle="modal" data-target="#modal-docporanexar"  data-carrera="<?php echo $usuario->carrera ?>">
                            <i class='fas fa-edit mr-2'></i> Documentos Anexados
                        </a>
                        
                    </div>
                  </div>

                  <!--<a class="d-block  bg-primary py-1 rounded"  title="Documentos anexados">
                    <i class="far fa-folder-open"></i>
                  </a>-->
                </div>
                <div class="col-6 col-md-6">
                  <a class="d-block bg-info py-1 rounded" target="_blank" href="<?php echo $urlprint ?>" title="Imprimir ficha">
                    <i class="fas fa-print"></i> 
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>       
    <?php
      }
    ?>
    </div>
  </div>
</div>

<script>

	$(".btn-delete").click(function(event) {
		event.preventDefault();
    $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var cins=$(this).data("ci");
    var fila=$(this).parents(".cfila");
    var carne=fila.find('.cell-carne').html();
    //************************************
    Swal.fire({
      title: "Precaución",
      text: "Se eliminarán todos los datos con respecto a este INSCRIPCIÓN ",
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
              url: base_url + 'inscrito/fn_eliminar',
              type: 'post',
              dataType: 'json',
              data: {
                      'ce-idins': cins,
                      'ce-carne': carne
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
                      Swal.fire({
                          type: 'success',
                          icon: 'success',
                          title: 'Eliminación correcta',
                          text: 'Se ha eliminado la inscripción',
                          backdrop: false,
                      })
                      
                      fila.remove();
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
      	}
      	else{
         	$('#divboxhistorial #divoverlay').remove();
      	}
    });
                //***************************************
	});

  $(".btn-cestado").click(function(event) {

      var im = $(this).parents(".cfila").data('ci');
      var cp = $(this).parents(".cfila").data('cp');
      var ie = $(this).data('ie');
      var color = $(this).data('color');

      var btdt = $(this).parents(".btn-group").find('.dropdown-toggle');
      //var btdt=$(this).parents(".dropdown-toggle");
      var texto = $(this).html();
      //alert(btdt.html());
      $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: base_url + 'inscrito/fn_cambiarestado',
          type: 'post',
          dataType: 'json',
          data: {
              'ce-idmat': im,
              'ce-nestado': ie,
              'ce-periodo': cp
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
                  Swal.fire({
                      type: 'success',
                      title: 'Felicitaciones, estado actualizado',
                      text: 'Se ha actualizado el estado',
                      backdrop: false,
                      icon: 'success',
                  })

                  $('#lbtn_mreing'+e.idinscrip).addClass('not-active');

                  btdt.removeClass('btn-danger');
                  btdt.removeClass('btn-success');
                  btdt.removeClass('btn-warning');
                  btdt.removeClass('btn-secondary');
                  btdt.removeClass('btn-info');

                  btdt.addClass(color);
                  btdt.html(texto);
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
  });


  $('#modal-docporanexar').on('show.bs.modal', function (e) {
  	$("#lista-ok").addClass('ocultar');
  	$("#lista-no").removeClass('ocultar');
    btn= $(e.relatedTarget);
    var cins=btn.data('ci');
    var carrera = btn.data('carrera');
    $("#fdacodins").val(cins);
    var fila=btn.parents(".cfila");
    var carne=fila.find('.cell-carne').html();
    var alumno=fila.find('.cell-alumno').html();
      //$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $("#frm-docanexar #spn-carne").html(carne);
      $("#frm-docanexar #spn-alumno").html(alumno);
      $("#frm-docanexar #spn_carrera").html(carrera);
      $('#frm-docanexar input[type=checkbox]').prop('checked', false);
    $.ajax({
          url: base_url + 'inscrito/fn_getdocanexados',
          type: 'post',
          dataType: 'json',
          data: {
                  'ce-idins': cins
              },
          success: function(e) {
              //$('#divboxhistorial #divoverlay').remove();
              $("#lista-ok").removeClass('ocultar');
              $("#lista-no").addClass('ocultar');
              if (e.status == false) {
                  Swal.fire({
                      type: 'error',
                      title: 'Error!',
                      text: e.msg,
                      backdrop: false,
                  })
              } else {
                  /*$("#fm-txtidmatricula").html(e.newcod);*/
                
                $('#frm-docanexar input[type=checkbox]').each(function () {
  	           //if (this.checked) {
  	           	var check=$(this);
  	           	var valor=check.attr('id').substring(2);
                $('#frm-docanexar #period_'+check.attr('id')).val('');
                $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', true);
                $('#frm-docanexar #txt_'+check.attr('id')).val('');
                $('#frm-docanexar #txt_'+check.attr('id')).prop('disabled', true);
  	            $.each(e.vdata, function(index, v) {
  	            	if (v['coddoc']==valor){
  	            		check.prop('checked', true);
                    $('#frm-docanexar #period_'+check.attr('id')).val(v['periodo']);
                    $('#frm-docanexar #period_'+check.attr('id')).attr('disabled', false);
                    $('#frm-docanexar #txt_'+check.attr('id')).val(v['detalle']);
                    $('#frm-docanexar #txt_'+check.attr('id')).prop('disabled', false);
                    
  	            	}
  	            });

  			});
                  
                  
              }
          },
          error: function(jqXHR, exception) {
              var msgf = errorAjax(jqXHR, exception, 'text');
              //$('#divboxhistorial #divoverlay').remove();
              Swal.fire({
                  type: 'error',
                  title: 'Error',
                  text: msgf,
                  backdrop: false,
              })
          }
  		});
  })

  $('.btn_actestado').click(function(e) {
    e.preventDefault();
    var boton = $(this);
    var div = boton.parents('.cfila');
    var codigo = div.data('ci');
    var periodo = div.data('cp');
    var estado = boton.data('ie');
    var color = boton.data('color');

    $('#fic_inscodigo_activa').val(codigo);
    $('#ficinscestado_activa').val(estado);
    $('#ficinsperiodo_activa').val(periodo)
    $('#lbtn_activa_insc').data('coloran', color);

    $('#modactiva').modal('show');
  });
	
</script>
