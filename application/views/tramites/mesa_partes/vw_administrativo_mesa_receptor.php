<style>
.form-title{
background-color: black;
color: white;
padding: 5px 0px 5px 10px;
margin: 25px -10px 25px -10px;
font-size: 16px;
}
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

.select2-container--default .select2-selection--multiple {
    border: 1px solid #ced4da !important;
    min-height: calc(2.25rem + 2px) !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: transparent !important;
    /*border-color: #006fe6 !important;*/
    border: 1px solid #bdc6d0 !important;
    color: #343a40 !important;
    padding: 0 10px !important;
    margin-top: .31rem !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    /*color: rgba(255,255,255,.7) !important;*/
    color: #bdc6d0;
    float: right !important;
    margin-left: 5px !important;
    margin-right: -2px !important;
}

.not-active { 
    pointer-events: none; 
    cursor: default;
}

</style>

<?php $vbaseurl = base_url();
date_default_timezone_set('America/Lima');
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/select2/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $vbaseurl ?>resources/dist/css/paginador.css">
<div class="content-wrapper">
  <div id="vw_mpr_md_verdatos" class="modal modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-body">
          
        </div>
        <div class="modal-footer py-1">
          
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade vw_mpa_lista_md_rec-der-rec" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row">
            <div class="col-6">
              <h5 id="md_vd_titulo" class="border rounded bg-lightgray p-1"></h5>
            </div>
            <div class="col-6">
              <h5 id="md_vd_fecha"></h5>
            </div>
            <div class="col-12">
              <h5 id="md_vd_solicitante" class="bg-lightgray border rounded p-1" >Solicitante:</h5>
              <h5 id="md_vd_asunto" class="bg-lightgray border rounded p-1" >Solicitante:</h5>
              
            </div>
          </div>
        </div>
        <div class="modal-body">
          <form id="vw_mpa_lista_form-ejecutar" action="<?php echo $vbaseurl ?>mesa_partes/fn_insert" method="post" accept-charset="utf-8">
            <input name="vw_mpae_txt_seguimiento" id="vw_mpae_txt_seguimiento" type="hidden" value="">
            <input name="vw_mpae_txt_ruta" id="vw_mpae_txt_ruta" type="hidden" value="">
            <div class="col-12">
              <div class="row">
                <label class="col-md-2 col-form-label-sm ">Acción:</label>
                <select class="form-control col-md-5 form-control-sm" data-sitruta='' name="vw_mpae_cb_ejecutar" id="vw_mpae_cb_ejecutar">
                  <option value='RECIBIDO'>RECIBIR</option>
                  
                  <?php if (getPermitido("68")=="SI") echo "<option value='RECHAZADO'>RECHAZAR</option>" ?>
                  <option value="DERIVADO">DERIVAR</option>
                  <option value='FINALIZADO'>FINALIZAR</option>
                </select>
              </div>
              
              <div id="vw_mpae_div_derivar" >
                <div class="row">
                  <label class="col-md-2 col-form-label-sm ">Area:</label>
                  <select class="form-control col-md-6 form-control-sm" name="vw_mpa_lista_cb_area" id="vw_mpa_lista_cb_area">
                    <option value="0">[--Seleccionar--]</option>
                    <?php
                    foreach ($areas as $area) {
                      if (($area->nombre=="EXTERIOR") && (getPermitido("68")=="NO") ){
                        //echo '<option value="'.base64url_encode($area->codarea).'">'.$area->nombre.'</option>';  
                      }
                      else{
                        $codtrabajador=base64url_encode($area->codencargado);
                        echo '<option data-codencargado="'.$codtrabajador.'" value="'.base64url_encode($area->codarea).'">'.$area->nombre.'</option>';  
                      }
                      
                    }
                    ?>
                  </select>
                </div>
                <div class="row">
                  <label class="col-md-2 col-form-label-sm ">Atención a:</label>
                  <select class="form-control col-md-8 form-control-sm" name="vw_mpa_lista_cb_usuario" id="vw_mpa_lista_cb_usuario">
                    <option value="0">[--Seleccionar--]</option>
                    <?php
                    foreach ($administrativos as $administrativo) {
                    $iduser=base64url_encode($administrativo->idusuario);
                    $codtrabajador=base64url_encode($administrativo->codtrabajador);
                    echo "<option data-codtrabajador='$codtrabajador' value='$iduser'>$administrativo->paterno $administrativo->materno $administrativo->nombres</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="row pb-1" id="msgemail_solicitante">

                    <div class="col-md-2 text-bold">Destino:</div>
                    <div class="col-md-5 px-0 text-primary" id="msgemail_solicitante_mail">
                    </div>

                    <div class="col-md-2 text-bold">Telefono:</div>
                    <div class="col-md-3 " id="msgemail_solicitante_fono">
                    </div>
              </div>
              <div class="row mb-2" id="msgemail_cc">
                <label class="col-md-2 col-form-label-sm ">Copia a:</label>
                <div class="col-md-10 pl-0 pr-0">
                  <select class="form-control form-control-sm select2" multiple="multiple" data-placeholder="[--Seleccionar--]" style="width: 100%;" name="vw_mpa_email_cc" id="vw_mpa_email_cc">
                    <?php
                    foreach ($administrativos as $admin) {
                    $nomuser = explode(" ",$admin->nombres);
                    echo "<option value='$admin->ecorporativo'>$admin->paterno $admin->materno $nomuser[0]</option>";
                    }
                    ?>
                  </select>
                </div>
                
              </div>
              <div id="vw_mpae_div_descripcion">
                <textarea class="vw_mpae_txt_summernote" id="vw_mpae_txt_descripcion" name="vw_mpae_txt_descripcion">
                
                </textarea>
              </div>
            </div>
            
            
            
          </form>


          <section id="vw_mpae_sec_adjuntar">
            <h5 class="form-title">Archivos a Adjuntar</h5>
            <div class="row">
              <div class="form-group col-lg-12">
                <div class="row">
                  
                  <div class="col-md-7 has-float-label mb-2">
                    <input type="text" name="vw_mpc_txt_titulo" id="vw_mpc_txt_titulo" class="form-control" placeholder="Describe el archivo adjunto" maxlength="200" autocomplete="off" >
                    <label for="vw_mpc_txt_titulo">Describe el archivo adjunto</label>
                  </div>
                  <div class="col-md-3">
                    <button id="vw_mpc_btn_selecionar" role="button" class="btn btn-info"><i class="fas fa-paperclip mr-1"></i>
                    Seleccionar archivo
                    </button>
                    <small class="d-block pt-2" id="vw_mpc_txt_filename"></small>
                    <input type="file" class="form-control" name="vw_mpc_file" id="vw_mpc_file">
                  </div>
                  <!--<div class="col-md-2">
                    <div class="btn btn-success" id="vw_mpc_btn_adjuntar">
                      <i class="fas fa-upload"></i> Adjuntar Prueba
                    </div>
                  </div>-->
                </div>
                <div class="row">
                  <div id="vw_mpc_txt_progress"></div>
                  <div id="vw_mpc_txt_size"></div>
                  <div id="vw_mpc_txt_type"></div>
                  <div id="vw_mpc_pgBar"></div>
                </div>
                <div class="row">
                  <b>(Se permite adjuntar hasta 10 archivos, de 1 en 1, con un máximo de 10 Mb por cada uno) <br>
                  * Solo se permiten los siguientes tipos de archivo: pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,txt.</b>
                </div>
              </div>
              
              <div id="divcard_items" class="col-12"></div>
            </div>
            <div class="row text-bold border-bottom">
              <div class="col-5">
                Archivo
              </div>
              <div class="col-2">
                Tamaño
              </div>
              <div class="col-5">
                Descripción
              </div>
            </div>
            <div class="clearfix"></div>
            <div id="vw_mpc_lista">
              
            </div>
            <div class="row mt-3">
              <div class="col-12" id="divmsjinc">
                
              </div>
            </div>
            
          </section>


        </div>
        <div class="modal-footer">
          <button id="vw_mpae_lista_md_btn-accionar" type="button" class="btn btn-primary" data-dismiss="modal">Guardar </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Mesa de Partes - Recepción
          <small></small></h1>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div id="divcard-general" class="card">
      <div class="card-header ">
        <div class="card-tools">
          <a href='<?php echo "{$vbaseurl}tramites/mesa-de-partes/agregar"  ?>' class="btn btn-success ">
            <i class="fas fa-plus mr-1"></i><br>Agregar
          </a>
          
        </div>
        <div class="row">
          <div class="btn-group btn-group-toggsle" data-toggle="buttons">
            <!--<label class="btn btn-info active">
              <input type="radio" class='vw_mpa_rbsituacion' name="rbsituacion" id="rbtodos" autocomplete="off" value="TODOS"> Todos
            </label>-->
            <label class="btn btn-info active">
              <input type="radio" class='vw_mpa_rbsituacion' name="rbsituacion" id="rbpendiente" autocomplete="off" value="PENDIENTE"> Pendientes
            </label>
            <!--<label class="btn btn-info">
              <input type="radio" class='vw_mpa_rbsituacion' name="rbsituacion" id="rbrecibido" autocomplete="off" value="RECIBIDO"> Recibidos
            </label>
            <label class="btn btn-info ">
              <input type="radio" class='vw_mpa_rbsituacion' name="rbsituacion" id="rbderivado" autocomplete="off" value="DERIVADO"> Derivados
            </label>-->
            <label class="btn btn-info">
              <input type="radio" class='vw_mpa_rbsituacion' name="rbsituacion" id="rbrechazado" autocomplete="off" value="RECHAZADO"> Rechazados 
            </label>
            <label class="btn btn-info">
              <input type="radio" class='vw_mpa_rbsituacion' name="rbsituacion" id="rbfinalizado" autocomplete="off" value="ATENDIDO"> Atendidos
            </label>
          </div>
        </div>
        <div class="row mt-3">
          
          <div class="form-group has-float-label col-12 col-md-5">
            <select class="form-control form-control-sm" name="vw_mpa_lista_cb_tramite" id="vw_mpa_lista_cb_tramite" placeholder="Trámite" >
              <option value="%">Todos</option>
              <?php
              foreach ($tipos as $value) {
              echo '<option value="'.base64url_encode($value->id).'">'.$value->nombre.'</option>';
              }
              ?>
            </select>
            <label for="vw_mpa_lista_cb_tramite"> Trámite</label>
          </div>
          <div class="form-group has-float-label col-12  col-md-6">
            <input id="vw_mpa_lista_txt_busqueda" name="vw_mpa_lista_txt_busqueda" type="text" class="form-control form-control-sm " maxlength="200" minlength="5" placeholder="DNI o Apellidos y nombres" >
            <label for="vw_mpa_lista_txt_busqueda"> DNI o Apellidos y nombres</label>
          </div>
           <div class="col-12  col-md-1">
            <button id="vw_mpa_lista_btn_buscar" role="button" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
          </div>
          
        </div>
        
      </div>
      
      <div class="card-body">
        <div class="btable">
          <div class="thead col-12  d-none d-md-block">
            <div class="row">
              <div class='col-12 col-md-5'>
                <div class='row'>
                  <div class='col-md-1 td'>N°</div>
                  <div class='col-md-4 td text-center'>INGRESÓ</div>
                  <div class='col-md-7 td text-center'>SOLICITANTE</div>
                </div>
              </div>
              <div class='col-12 col-md-3 td text-center'>
                
                ASUNTO
              </div>
              
              <div class='col-12 col-md-1 td text-center'>
                ESTADO
              </div>
              <div class='col-12 col-md-2 td text-center'>
                
                PARA / SITUACIÓN
                
              </div>
              <div class='col-12 col-md-1 td text-center'>
                
                ACCIÓN
                
              </div>
            </div>
          </div>
          <div class="tbody col-12" id="div_result_tramites">

        </div>
          
        </div>

        <div class="col-12 py-0">
            <div id="page-selection" class="text-right pagination-page"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php
echo
"<script src='{$vbaseurl}resources/plugins/summernote8/summernote-bs4.min.js'></script>
<script src='{$vbaseurl}resources/plugins/summernote8/lang/summernote-es-ES.js'></script>
<script src='{$vbaseurl}resources/plugins/simpleUpload/simpleUpload.min.js'></script>
<script src='{$vbaseurl}resources/plugins/select2/js/select2.full.min.js'></script>
<script src='{$vbaseurl}resources/dist/js/jquery.bootpag.min.js'></script>"; 
//<script src='{$vbaseurl}resources/dist/js/pages/portalweb.js'></script>";
?>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url();?>resources/jquery/pages.js"></script>-->
<script type="text/javascript" charset="utf-8">
  $(".vw_mpa_rbsituacion").change(function(event) {
    $("#vw_mpa_lista_btn_buscar").click();
  });
  
  $('.select2').select2();
  
  /*$("#vw_mpa_lista_cb_tramite").change(function(event) {
    
  });*/
  $("#vw_mpa_lista_btn_buscar").click(function(event) {
    if (history.pushState) {
      var st=$("input[name='rbsituacion']:checked").val();
      var stt="?stt=" + st;
      var tpt=($("#vw_mpa_lista_cb_tramite").val()=="%")?"":"&tpt=" + $("#vw_mpa_lista_cb_tramite").val();
      var qry=($.trim($("#vw_mpa_lista_txt_busqueda").val())=="")?"":"&qry=" + $("#vw_mpa_lista_txt_busqueda").val();
          var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + stt + tpt + qry ;
          window.history.pushState({path: newurl}, '', newurl);
    }
    fn_filtrar_tramites(1);
    // location.reload();

  });
  /*rbsituacion
vw_mpa_lista_cb_tramite
vw_mpa_lista_txt_busqueda*/

$(document).ready(function() {


  //ADJUNTAR ARCHIVO
    $('#vw_mpc_txt_progress').hide();
    $('#vw_mpc_txt_size').hide();
    $('#vw_mpc_txt_type').hide();
    $('#vw_mpc_pgBar').hide();
    $("#vw_mpc_file").hide();
    $("#vw_mpae_sec_adjuntar").hide();
    $('#msgemail_cc').hide();
    $('#msgemail_solicitante').hide();
    //FIN ADJUNTAR ARCHIVO

    $("#vw_mpae_div_descripcion").hide();
    $("#vw_mpae_div_derivar").hide();
    $.summernote.dom.emptyPara = "<div><br></div>"
      $('.vw_mpae_txt_summernote').summernote({
          height: 150,
          placeholder: 'Escriba Aquí ...!',
          dialogsFade: true,
          lang: 'es-ES',
          toolbar: [
              ['font', ['bold', 'italic', 'underline', 'clear']],

              ['insert', ['link', 'hr']],
              ['view', ['codeview']],
          ],
      });

    var stt=getUrlParameter("stt","PENDIENTE");
    var tpt=getUrlParameter("tpt","%");
    var qry=getUrlParameter("qry","");
    $("#vw_mpa_lista_cb_tramite").val(tpt);
    $("#vw_mpa_lista_txt_busqueda").val(qry);
    $("input[name=rbsituacion][value=" + stt + "]").prop('checked', true);
    $("#vw_mpa_lista_btn_buscar").click();
    //$("input[name='rbsituacion']").val(stt);
});
var arrayarchivos=[];
$('#vw_mpc_file').change(function(){
  if (arrayarchivos.length>=10){
    Swal.fire({
                  icon: 'error',
                  title: 'Límite de 10 archivos',
                  text: 'Solo se puede adjuntar como máximo 6 archivos',
                  backdrop: false,
              });
    return;
  }
  $('#vw_mpc_txt_titulo').removeClass('is-invalid');
  $('.invalid-feedback').remove();
    // if ($.trim($('#vw_mpc_txt_titulo').val())==""){
    //     alert("Ingresa la descripción o nombre del archivo");
    // $('#vw_mpc_txt_titulo').addClass('is-invalid');
    //   $('#vw_mpc_txt_titulo').parent().append("<div class='invalid-feedback'>Ingresa una descripción del archivo</div>");
    //   $('#vw_mpc_txt_titulo').focus();
    // }
    /*else if ($.trim($('#vw_mpc_file').val())==""){
      alert("Seleciona un archivo");
    }*/
    // else{
       $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $("#vw_mpc_file").simpleUpload(base_url+"/mesa_partes/fn_upload_file_logeado", {
          allowedExts: ["jpg", "jpeg", "png", "txt","pdf","doc","docx","xls","xlsx","xlsm","ppt","pptx"],
      //allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
      maxFileSize: 10485760, //10MB in bytes

        start: function(file){
          //upload started
          $('#vw_mpc_txt_filename').html(file.name);
          $('#vw_mpc_txt_size').html(file.size);
          $('#vw_mpc_txt_type').html(file.type);

          $('#vw_mpc_txt_progress').html("");
          $('#vw_mpc_pgBar').width(0);
          $('#vw_mpc_txt_progress').show();
          $('#vw_mpc_pgBar').show();
        },

        progress: function(progress){
          //received progress
          $('#vw_mpc_txt_progress').html("Progress: " + Math.round(progress) + "%");
          $('#vw_mpc_pgBar').width(progress + "%");
        },

        success: function(data){
          //upload successful
          //$('#progress').html("Success!<br>Data: " + JSON.stringify(data));
          $('#vw_mpc_txt_progress').hide();
          $('#vw_mpc_pgBar').hide();

          //AGREGAR ARCVO A LA LISTA
          //i.link,i.name,i.size,i.type,i.fileid
           $('#divcard-general #divoverlay').remove();
          var newarchivo=[data.link,$('#vw_mpc_txt_filename').html(),$('#vw_mpc_txt_size').html(),$('#vw_mpc_txt_type').html(),$('#vw_mpc_txt_titulo').val()];
          arrayarchivos.push(newarchivo);
          " "
          $('#vw_mpc_lista').append("<div class='row border-bottom rowcolor p-2'>"+
              "<div class='col-5'> " + $('#vw_mpc_txt_filename').html() +"</div>" + 
              "<div class='col-2'> " + $('#vw_mpc_txt_size').html() +" kb</div>" + 
              "<div class='col-5'> " + $('#vw_mpc_txt_titulo').val() +"<a href='#' class='float-right' data-link='" + data.link + "' onclick='vw_mpa_fn_delfile($(this));event.preventDefault();' ><i class='far fa-trash-alt'></i></a></div>");
          $('#vw_mpc_txt_titulo').val("");
          $('#vw_mpc_txt_filename').html("");
          $('#vw_mpc_txt_titulo').focus();
        },

        error: function(error){
          //upload failed
          
          switch (error.name) {
        case 'InvalidFileExtensionError':
          vmsg="Este tipo de archivo no es admitido";
          break;
        case 'MaxFileSizeError':
          vmsg="El peso máximo permitido es de 10MB";
          break;
        default:
          vmsg=error.message;

          //$('#vw_mpc_txt_progress').html("Error!<br>" + error.name + ": " + error.message);
      }
      Swal.fire({
                  icon: 'error',
                  title: "Error! " + error.name,
                  text: vmsg,
                  backdrop: false,
              });
            $('#vw_mpc_txt_filename').html("");
          $('#vw_mpc_txt_size').html("");
          $('#vw_mpc_txt_type').html("");
           $('#divcard-general #divoverlay').remove();
        }

        });
      // }


});
function vw_mpa_fn_delfile(btn) {
    var link = btn.data('link');


    var n = 0;
    arrayarchivos.forEach(function(afile) {
        if (afile[0] === link) {
            arrayarchivos.splice(n, 1);
            btn.closest('.rowcolor').remove();
        }
        n++;
    });

}
$('#vw_mpc_btn_selecionar').click(function(event) {
    event.preventDefault();
    $("#vw_mpc_file").trigger('click');
});

$("#vw_mpa_lista_cb_area").change(function(event) {
  /* Act on the event */
    var codencargado=$('#vw_mpa_lista_cb_area option:selected').data('codencargado');
    
    var atencion_a="0";
    $("#vw_mpa_lista_cb_usuario option").each(function(i){
        if ($(this).data('codtrabajador')==codencargado){
          atencion_a=$(this).val();
        }
    });
    
    $("#vw_mpa_lista_cb_usuario").val(atencion_a);
  

});
$("#vw_mpae_cb_ejecutar").change(function(event) {
    $('#msgemail_solicitante').hide();
    var cbval = $(this).val();
    $("#vw_mpa_lista_cb_area").val("0");
    $("#vw_mpa_lista_cb_usuario").val("0");
    if (cbval == "RECIBIDO") {
      $("#vw_mpae_div_derivar").hide();
      $("#vw_mpae_div_descripcion").hide();
      $("#vw_mpae_sec_adjuntar").hide();
      $('#msgemail_cc').hide();
    } 
    else if (cbval == "RECHAZADO") {
      $("#msgemail_solicitante").show();
      $("#vw_mpae_div_derivar").hide();
      $("#vw_mpae_div_descripcion").show();
      $("#vw_mpae_sec_adjuntar").show();
      $('#msgemail_cc').hide();
    } 
    else if (cbval == "DERIVADO") {
      $("#vw_mpae_div_descripcion").show();
      $("#vw_mpae_div_derivar").show();
      $("#vw_mpae_sec_adjuntar").show();
      $('#msgemail_cc').show();
    } 
    else if (cbval == "FINALIZADO") {
      $("#msgemail_solicitante").show();
      $("#vw_mpae_div_descripcion").show();
      $("#vw_mpae_div_derivar").hide();
      $("#vw_mpae_sec_adjuntar").show();
      $('#msgemail_cc').show();
    }
});
//vw_mpa_lista_md_ver_datos
function vw_mpa_lista_btn_ver(btn){
    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var seg = btn.data('seguimiento');
    $.ajax({
        url: base_url + 'mesa_partes/vw_administrativo_ajax_solicitud_detalle',
        type: 'post',
        dataType: 'json',
        data: {
            seguimiento: seg
        },
        success: function(e) {
            $('#divcard-general #divoverlay').remove();

            // $('.vw_mpa_lista_md_ver_datos .modal-title').html('DETALLE');
            $('#vw_mpr_md_verdatos #md_vd_titulo').html('TRÁMITE N° <b>'+ e.codseguim + "</b>");
            $('#vw_mpr_md_verdatos #md_vd_solicitante').html("Solicitante: <b>" + e.solicitante + "</b>");
            //$('#vw_mpr_md_verdatos #md_vd_fecha').html("<b>Ingresó: </b>" + e.fecha);

            
            if (e.status == false) {
                $('#vw_mpr_md_verdatos .modal-body').html(e.msg);
            } else {
                $('#vw_mpr_md_verdatos .modal-body').html(e.datos);
            }
            $('#vw_mpr_md_verdatos').modal('show')
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divcard-general #divoverlay').remove();
            $('#vw_mpr_md_verdatos .modal-body').html(msgf);
            $('#vw_mpr_md_verdatos').modal('show')
        },
    });
};

function vw_mpa_lista_btn_ver_ruta(btn) {
    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    var seg = btn.data('seguimiento');
    $.ajax({
        url: base_url + 'mesa_partes/vw_administrativo_ajax_solicitud_ruta',
        type: 'post',
        dataType: 'json',
        data: {
            seguimiento: seg
        },
        success: function(e) {
            $('#divcard-general #divoverlay').remove();
            $('#vw_mpr_md_verdatos #md_vd_titulo').html('TRÁMITE N° <b>'+ e.codseguim + "</b>");
            $('#vw_mpr_md_verdatos #md_vd_solicitante').html("Solicitante: <b>" + e.solicitante + "</b>");
            if (e.status == false) {
                $('#vw_mpr_md_verdatos .modal-body').html(e.msg);
            } else {
                $('#vw_mpr_md_verdatos .modal-body').html(e.datos);
            }
            $('#vw_mpr_md_verdatos').modal('show')
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divcard-general #divoverlay').remove();
            $('#vw_mpr_md_verdatos .modal-body').html(msgf);
            $('#vw_mpr_md_verdatos').modal('show')
        },
    });
};

function vw_mpa_lista_btn_recibir(btn) {
    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

    var seg = btn.data('seguimiento');
    var rut = btn.data('ruta');
    var sitruta = btn.data('sitruta');
    var fila = btn.closest('.rowcolor');
     var email = fila.data('email');
    var telefono = fila.data('telefono');
    var codseguim = fila.data('codseguim');
    var solicitante = fila.data('solicit');
    var asunto = fila.data('asunto');
    var fecha = fila.data('fecha');
    $('#vw_mpae_cb_ejecutar').val("");
    if (sitruta=="PENDIENTE"){
      $('#vw_mpae_cb_ejecutar option').each(function(index, el) {
          $(this).addClass('ocultar');
          if (($(this).attr('value')=='RECIBIDO') || ($(this).attr('value')=='RECHAZADO') ) $(this).removeClass('ocultar');
      });
    }
    else if (sitruta=="RECIBIDO") {
      $('#vw_mpae_cb_ejecutar option').each(function(index, el) {
          $(this).addClass('ocultar');
          if ($(this).attr('value')!='RECIBIDO') $(this).removeClass('ocultar');
      });
    } 
    else if (sitruta=="RECHAZADO") {
      $('#vw_mpae_cb_ejecutar option').each(function(index, el) {
          $(this).addClass('ocultar');
          if ($(this).attr('value')=='RECIBIDO') $(this).removeClass('ocultar');
      });
    } 
    
    $("#msgemail_solicitante_mail").html(email);
    $("#msgemail_solicitante_fono").html(telefono);
    $('#vw_mpae_txt_seguimiento').val(seg);
    $('#vw_mpae_txt_ruta').val(rut);

    $('.vw_mpa_lista_md_rec-der-rec #md_vd_titulo').html('TRÁMITE N° <b>'+ codseguim + "</b>");
    $('.vw_mpa_lista_md_rec-der-rec #md_vd_solicitante').html("Solicitante: <b>" + solicitante + "</b>");
    $('.vw_mpa_lista_md_rec-der-rec #md_vd_fecha').html("Fecha: <b>" + fecha + "</b>");
    $('.vw_mpa_lista_md_rec-der-rec #md_vd_asunto').html("Asunto: <b>" + asunto + "</b>");

    /*$('.vw_mpa_lista_md_rec-der-rec .modal-title').html('ACCIÓN DE TRAMITE N° '+ codseguim + "<br><div class='small'><b>Solicitante: </b>" + solicitante + "</div><span class='small'><b>Asunto: </b>" + asunto + "</span><br><span class='small'><b>Fecha tramite: </b>" + fecha + "</span>");*/
    $('.vw_mpa_lista_md_rec-der-rec').modal('show');
    $('#divcard-general #divoverlay').remove();
};

$('#vw_mpae_lista_md_btn-accionar').click(function(event) {
    $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    /*var seg = $(this).data('seguimiento');
    var seg = $(this).data('seguimiento');
    vw_mpa_cb_ejecutar*/
    //var datos = $("#vw_mpa_lista_form-ejecutar").serialize();
    arremailcc = [];
    $.each($("#vw_mpa_email_cc option:selected"), function() {
      arremailcc.push($(this).val());
    });

    var formData = new FormData($("#vw_mpa_lista_form-ejecutar")[0]);
    formData.append('vw_mpc_email_cc', JSON.stringify(arremailcc));
    formData.append('vw_mpc_archivos', JSON.stringify(arrayarchivos));


    $.ajax({
        url: base_url + 'mesa_partes/fn_administrativo_ejecutar',
        type: 'post',
        dataType: 'json',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(e) {
            $('#divcard-general #divoverlay').remove();
            if (e.status == false) {
              Swal.fire({
                  icon: 'error',
                  title: 'Leer atentamente',
                  text: e.msg,
                  backdrop: false,
              });
            } 
            else {
              $('#divcard-general').append('<div id="divoverlay" class="overlay dark"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                location.reload();
            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'div');
            $('#divcard-general #divoverlay').remove();
            $('.vw_mpa_lista_md_rec-der-rec .modal-body').html(msgf);
            $('.vw_mpa_lista_md_rec-der-rec').modal('show')
        },
    });
    return false;
});

$('.vw_mpa_lista_md_rec-der-rec').on('hidden.bs.modal', function (e) {
  $("#vw_mpae_div_derivar").hide();
  $("#vw_mpae_div_descripcion").hide();
  $("#vw_mpae_sec_adjuntar").hide();
  $('#msgemail_cc').hide();
  $('.vw_mpa_lista_md_rec-der-rec .modal-title').html('ACCIÓN');
})

function fn_filtrar_tramites(pagina){
  var limite = "40";
  var inicio = (pagina - 1) * limite;
  
  var situacion = $("input[name='rbsituacion']:checked").val();
  var tramite = $("#vw_mpa_lista_cb_tramite").val();
  var buscar = $.trim($("#vw_mpa_lista_txt_busqueda").val());
  $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
  $.ajax({
      url: base_url + 'mesa_partes/search_list_tramites',
      type: 'post',
      dataType: 'json',
      data: {
        'situacion':situacion,
        'tramite':tramite,
        'buscar':buscar,
        'inicio':inicio,
        'limite':limite,
        'vper68':"SI",
      },
      success: function(e) {
          $('#divcard-general #divoverlay').remove();
          if (e.status== true) {
              $('#div_result_tramites').html(e.vdata);

              // $('#divcantfiltro').html("Cantidad: "+ e.numitems);
              
              pagination_mesa(e.numitems,pagina);
              
          } else {
              $('#div_result_tramites').html(e.vdata);
              // $('#divcantfiltro').html("Cantidad: 0");
              pagination_mesa(0);
          }
          
      },
      error: function(jqXHR, exception) {
          $('#divcard-general #divoverlay').remove();
          var msgf = errorAjax(jqXHR, exception, 'text');
          $('#div_result_tramites').html(msgf);
      }
  });
  return false;
}

function pagination_mesa(cantidad,total=1){
  var pagtotal = Math.round(cantidad / 40);
    $('#page-selection').html('');
    if (pagtotal > 0) {
      $('#page-selection').bootpag({
          total: pagtotal,
          page: total,
          maxVisible: 4,
          wrapClass: "pages",
          disabledClass: "not-active"
      }).on("page", function(event, num){
          var limite = "40";
          var inicio = (num - 1) * limite;

          var situacion = $("input[name='rbsituacion']:checked").val();
          var tramite = $("#vw_mpa_lista_cb_tramite").val();
          var buscar = $.trim($("#vw_mpa_lista_txt_busqueda").val());
          $('#divcard-general').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
          $.ajax({
              url: base_url + 'mesa_partes/search_list_tramites',
              type: 'post',
              dataType: 'json',
              data: {
                'situacion':situacion,
                'tramite':tramite,
                'buscar':buscar,
                'inicio':inicio,
                'limite':limite,
                'vper68':"SI",
              },
              success: function(e) {
                  $('#divcard-general #divoverlay').remove();
                  if (e.status== true) {
                      $('#div_result_tramites').html(e.vdata);

                      // $('#divcantfiltro').html("Cantidad: "+ e.numitems);
                      
                      
                  } else {
                      $('#div_result_tramites').html(e.vdata);
                      // $('#divcantfiltro').html("Cantidad: 0");
                      
                  }
                  
              },
              error: function(jqXHR, exception) {
                  $('#divcard-general #divoverlay').remove();
                  var msgf = errorAjax(jqXHR, exception, 'text');
                  $('#div_result_tramites').html(msgf);
              }
          });

      });
  } else {
      $('#page-selection').html('');
  }
}


</script>