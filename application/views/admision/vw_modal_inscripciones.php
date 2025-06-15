<?php 
  $vbaseurl=base_url();
?>
<div class="modal fade" id="modupdatefoto" tabindex="-1" role="dialog" aria-labelledby="modupdatefoto" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="divmodalfoto">
            <div class="modal-header">
                <h5 class="modal-title" id="divcard_title">FOTO ESTUDIANTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                  	<input type="hidden" name="fictxtcodpersona" id="fictxtcodpersona" value="0">
                  	<!-- <div id="content_dropzone_foto"> -->
                    <div id="actions" class="col-12">
                      	<div class="row">
                          	<div class="col-lg-7">
                              	<button type="submit" class="btn btn-primary start" style="display: none;">
                              		<i class="fas fa-upload"></i>
                              		<span>Upload</span>
                              	</button>
                              	<button type="reset" class="btn btn-warning cancel" style="display: none;">
                              		<i class="fas fa-ban"></i>
                              		<span>Cancel</span>
                              	</button>
                          	</div>
                          
                          	<div class="col-lg-5">
                              
                          	</div>
                          	<div class="col-12 dropzone-here">
                            
                          	</div>
                          	<div class="col-12 px-3 text-center">
                            	<span class="fileupload-process" style="display: none">
	                                <div id="total-progress" class="progress " role="progressbar">
	                                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
	                                    </div>
	                                </div>
                            	</span>
                            	<h5> Arrastra aquí tu IMAGEN (Peso 5 MB máx.)</h5>
	                            <div class="row" id="previews">
	                                <div id="template" class="col-6 col-sm-4 col-md-2 px-2 mt-2" >
	                                    <div  class="row">
	                                        <div class="col-12 mx-auto preview ">
	                                            <img style="width: 100%;" data-dz-thumbnail />
	                                            <a class="text-primary start" style="display: none">
	                                                <i class="fas fa-upload"></i>
	                                                <span>Empezar</span>
	                                            </a>
	                                            <a data-dz-remove class="text-warning cancel">
	                                                <i class="fas fa-ban"></i>
	                                                <span>Cancelar</span>
	                                            </a>
	                                            <a data-dz-remove class=" text-danger delete">
	                                                <i class="fas fa-trash"></i>
	                                                <span>Eliminar</span>
	                                            </a>
	                                            <div class="progress">
	                                                <div class="progress-bar pb-private progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
	                                                </div>
	                                            </div>
	                                            <div>
	                                                <strong class="error text-danger" data-dz-errormessage></strong>
	                                            </div>
	                                            <p class="size m-0" data-dz-size></p>
	                                            <p class="name m-0" data-dz-name></p>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
                          	</div>
                          	<div class="alert alert-danger alert-dismissible mt-2" style="display: none">
                            	<h5><i class="icon fas fa-ban"></i> Alerta!</h5>
	                            <ul>
	                              	<li>Se encontraron algunos archivos con error </li>
	                              	<li>Verifique si alguno de ellos tenga un peso superior a los 5 Mb (5120 kb)</li>
	                              	<li>Solo se acepta archivos de tipo imagen</li>
	                            </ul>
                          	</div>
                      	</div>
                    </div>
                  <!-- </div> -->
                  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_guardarfoto" data-ficfila="" data-insc="" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $vbaseurl ?>resources/plugins/dropzone/dropzone.min.js"></script>

<script>
    var varchivo = new Array();
    var myDropzone;

    $(document).ready(function() {
    	/*DROPZONE*/
        
        var imageUrl = base_url + "resources/img/nube.png";
        $('#previews').css('background-image', 'url(' + imageUrl + ')');
        $('#previews').css('background-repeat', 'url(' + imageUrl + ')');
        $('#btn_guardarfoto').prop("disabled", true);

        Dropzone.prototype.getErroredFiles = function () {
            var file, _i, _len, _ref, _results;
            _ref = this.files;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
               file = _ref[_i];
               if (file.status === Dropzone.ERROR) {
                   _results.push(file);
               }
            }
            return _results;
        };

        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        myDropzone = new Dropzone(document.body, {
            url: base_url + "persona/fn_upload_foto_propia",
            paramName: "file",
            maxFilesize: 5120000,
            maxFiles: 1,
            thumbnailWidth: 100,
            thumbnailHeight: 100,
            timeout: 180000,
            thumbnailMethod: 'crop',
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: true,
            previewsContainer: "#previews",
            clickable: "#previews",
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            init: function() {
                this.on("complete", function (file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0 && this.getErroredFiles().length === 0) {
       
                        $(".alert").hide();
                        $("#btn_guardarfoto").prop("disabled", false);
                    }
                    else{
                        $(".alert").show();
                        $("#btn_guardarfoto").prop("disabled", true);
                    }
                });

                este = this;
                

                this.on("success", function(file, response) {
                    var obj = jQuery.parseJSON(response)
                    file.link = obj.link;
                    file.fileid=0;
                    //console.log(file);
                })

            },
            removedfile: function(file) {
                var vinid=(typeof file.fileid === "undefined") ? "":file.fileid ;
                var vilink=(typeof file.link === "undefined") ? "":file.link ;
                var este=this;
                Swal.fire({
                    title: '¿Deseas eliminar el ARCHIVO ?',
                    text: "Al eliminar, se perdera " + file.name + " y no podrá recuperarse",
                    type: 'warning',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        if (vinid == "") {
                            file.previewElement.remove();
                            if (este.getUploadingFiles().length === 0 && este.getQueuedFiles().length === 0 && este.getErroredFiles().length === 0) {
                                $(".alert").hide();
                                $("#vw_pw_bt_ad_btn_guardar").prop("disabled", false);
                            } else {
                                $(".alert").show();
                                $("#vw_pw_bt_ad_btn_guardar").prop("disabled", true);
                            }
                            este.options.maxFiles = 1;
                        } else {
                          $.ajax({
                              url: base_url + 'persona/fn_delete_upload_foto',
                              type: 'POST',
                              data: {
                                  "coddetalle": vinid,
                                  "link": vilink 
                              },
                              dataType: 'json',
                              success: function(e) {
                                  if (e.status == true) {
                                      Swal.fire(
                                          'Eliminado!',
                                          'El archivo fue eliminado correctamente.',
                                          'success'
                                      )
                                      file.previewElement.remove();
                                      if (este.getUploadingFiles().length === 0 && este.getQueuedFiles().length === 0 && este.getErroredFiles().length === 0) {
                                          $(".alert").hide();
                                          $("#btn_guardarfoto").prop("disabled", false);
                                      }
                                       else{
                                          $(".alert").show();
                                          $("#btn_guardarfoto").prop("disabled", true);
                                      }
                                      este.options.maxFiles = 1;

                                  } else {
                                      Swal.fire(
                                          'Error!',
                                          e.msg,
                                          'error'
                                      )
                                  }
                              },
                              error: function(jqXHR, exception) {
                                  var msgf = errorAjax(jqXHR, exception, 'text');
                                  Swal.fire(
                                      'Error!',
                                      msgf,
                                      'success'
                                  )
                              }
                          });
                        }
                    }
                })
                return false;

            }

        });

        myDropzone.on("addedfile", function(file) {
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file);
            };
            var ext = file.name.split('.').pop();
            $("#btn_guardarfoto").prop("disabled", true);
            if (ext == "pdf") {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/pdf.png");
            } else if (ext.indexOf("doc") != -1) {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/word.png");
            } else if (ext.indexOf("xls") != -1) {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/excel.png");
            } else if ((ext.indexOf("jpg") != -1) || (ext.indexOf("png") != -1)) {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/img.png");
            } else {
                myDropzone.emit("thumbnail", file, base_url + "resources/img/icons/file.png");
            }

        });


        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

        myDropzone.on("sending", function(file, xhr, formData) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1";
            // And disable the start button
            codpersona64 = $('#fictxtcodpersona').val();
            formData.append('codpersona', codpersona64);
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0";

        });

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
            
        };

        // FIN DROPZONE
    })

    function fn_vw_foto_perfil(codins) {
        // var fila = btn.closest('.cfila');
        // var codins = fila.data('ci');
        $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        
        $.ajax({
            url: base_url + 'inscrito/fn_view_foto_inscrito',
            type: 'post',
            dataType: 'json',
            data: {
              'ce-idins': codins,
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
                    
                    $('#modupdatefoto').modal('show');
                    $('#fictxtcodpersona').val(e.vdata['idper64']);
                    varchivo['link'] = e.vdata['link'];
                    varchivo['codigo'] = e.vdata['idper64'];
                    varchivo['nombre'] = e.vdata['foto'];
                    varchivo['peso'] = e.vdata['pesofoto'];
                    varchivo['tipo'] = e.vdata['typefoto'];
                    
                    este= myDropzone;
                    
                    if (varchivo['link'] !== "") {
                                        
                        var mockFile = {
                            name: varchivo['nombre'],
                            size: varchivo['peso'],
                            type: varchivo['tipo']
                        };

                        var ext = varchivo['nombre'].split('.').pop();
                        var ico = "";
                        ico = "resources/fotos/"+mockFile.name;

                        mockFile.fileid = varchivo['codigo'];
                        mockFile.link = varchivo['link'];
                        este.files.push(mockFile);
                        este.options.addedfile.call(este, mockFile);
                        este.options.thumbnail.call(este, mockFile, base_url + ico);

                        mockFile.previewElement.classList.add('dz-success');
                        mockFile.previewElement.classList.add('dz-complete');
                        mockFile.previewElement.querySelector(".pb-private").style.width = "100%"
                        este.options.maxFiles = 0;
                    }
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
    }

    $("#btn_guardarfoto").click(function(e) {
        $('#divmodalfoto').append('<div id="divoverlay" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        var fila = $(this).data('ficfila');

        var fdata= [];
        var codpersona = $('#fictxtcodpersona').val()
        var link
        for(var si in myDropzone.files){
            i=myDropzone.files[si];
            link = i.link;
        
        }
        fdata.push({name: 'link', value: link});
        fdata.push({name: 'idpersona', value: codpersona});

        $.ajax({
            url: base_url + 'persona/fn_guardar_foto_propia',
            type: 'post',
            dataType: 'json',
            data: fdata,
            success: function(e) {
                $('#divmodalfoto #divoverlay').remove();
                if (e.status==true){
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Felicitaciones',
                        text: e.msg,
                        backdrop: false,
                    });
                    //myDropzone.disable(); 
                    //$("#vwperfil_img_user").attr("src",base_url + "resources/fotos/" + e.link);
                    // location.reload();
                    $("#frm-filtro-inscritos").submit();
                    $("#btn_guardarfoto").prop("disabled", true);
                    $('#modupdatefoto').modal('hide');
                    fila.data('photo',e.link64);
                    codigo = fila.data('codins64');
                    tabla = fila.closest('.tb_principal');
                    fn_preview_foto(codigo,tabla.attr('id'));
                }
                else{
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'ERROR, no se guardó los cambios',
                        text: e.msg,
                        backdrop: false,
                    });
                }
              
            },
            error: function(jqXHR, exception) {
                $('#divmodalfoto #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'ERROR, NO se guardó cambios',
                    text: msgf,
                    backdrop: false,
                });
            },
        });

        return  false;
    });

    $('#modupdatefoto').on('hidden.bs.modal', function (e) {
        varchivo = [];
        este= myDropzone;
        este.files = [];
        este.options.maxFiles = 1;
        // console.log(este.getUploadingFiles().length);
        $('#previews').html('');
        $('#fictxtcodpersona').val('0');
        $('#modupdatefoto #btn_guardarfoto').data('ficfila', '');
        $('#modupdatefoto #btn_guardarfoto').data('insc', '');
    })
</script>