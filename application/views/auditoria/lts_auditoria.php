<?php
	$vbaseurl = base_url();
?>
<style> 
	.not-active { 
	    pointer-events: none; 
	    cursor: default;
	}
</style>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $vbaseurl ?>resources/dist/css/paginador.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>
<div class="content-wrapper">
	<div class="modal fade" id="modetalle_aud" tabindex="-1" role="dialog" aria-labelledby="modetalle_aud" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-dialog-centered" role="document">
      		<div class="modal-content">
        		<div class="modal-header">
		          	<h5 class="modal-title" id="exampleModalLongTitle">DETALLE</h5>
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          	<span aria-hidden="true">&times;</span>
		          	</button>
        		</div>
	       		<div class="modal-body">
	          		<div id="divdetalle">
	            		
	          		</div>
	        	</div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		        </div>
      		</div>
    	</div>
  	</div>
	<section id="s-cargado" class="content pt-2">
		<div id="divboxhistorial" class="card">
		    <div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list mr-1"></i> LISTA AUDITORIA</h3>
		    </div>
	      	<div class="card-body">
	      		<form id="frm_search_auditoria" action="" method="post" accept-charset="utf-8">
	      			<div class="row">
				      	<div class="form-group has-float-label col-lg-6 col-md-6 col-sm-6">
				        	<select name="fictxtaccion" id="fictxtaccion" class="form-control">
				        		<option value="%%%%">Todos</option>
				        		<option value="INSERTAR">INSERT</option>
				        		<option value="EDITAR">UPDATE</option>
				        		<option value="ELIMINAR">DELETE</option>
				        		<option value="SELECT">SELECT</option>
				        	</select>
				        	<label for="fictxtaccion">Acción</label>
				      	</div>
				      	<div class="form-group has-float-label col-lg-6 col-md-6 col-sm-6">
				        	<select name="fictxtusuario" id="fictxtusuario" class="form-control border" data-live-search="true">
				        		<option value="%%%%">TODOS</option>
				        		<?php
				        			foreach ($usuario as $key => $value) {
				        				echo "<option value='$value->codigous'>$value->nombres - $value->usuario</option>";
				        			}
				        		?>
				        	</select>
				        	<label for="fictxtusuario">Usuario</label>
				      	</div>
		      		</div>
		      		<div class="row">
		      			<div class="form-group has-float-label col-lg-6 col-md-4 col-sm-6">
				      		<input class="form-control" type="date" name="txtfecha" id="txtfecha">
				      		<label for="txtfecha">Fecha inicio</label>
				      	</div>
				      	<div class="form-group has-float-label col-lg-6 col-md-4 col-sm-6">
				      		<input class="form-control" type="date" name="txtfechafin" id="txtfechafin" >
				      		<label for="txtfechafin">Fecha fin</label>
				      	</div>
		      		</div>
		      		<div class="row">
		      			<div class="form-group has-float-label col-lg-10 col-md-9 col-sm-9">
				      		<input class="form-control" type="text" name="fictxtcontenido" id="fictxtcontenido" placeholder="Contenido">
				      		<label for="fictxtcontenido">Contenido</label>
				      	</div>
				      	<div class="col-lg-2 col-md-3 col-sm-3">
				        	<button class="btn btn-flat btn-info float-right btn-md" type="submit" >
				        		<i class="fas fa-search"></i>
				        		Buscar
				        	</button>
				      	</div>
		      		</div>
	      		</form>
	      		<div class="row py-1" id="divres-historial">
					<div class="table-responsive col-12" id="tabdivres-auditoria">
	                    <table id="tbmt_dtauditoria" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
	                      <thead>
	                        <tr class="bg-lightgray">
	                          <th>N°</th>
	                          <th>Usuario</th>
	                          <th>Fecha</th>
	                          <th>Detalle</th>
	                          <th>Sede</th>
	                          <th></th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                                    
	                      </tbody>
	                    </table>
	                </div>
				</div>
				
			</div>
		</div>
	</section>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>

<script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap-select-1.13.9/js/bootstrap-select.min.js"></script>
<?php echo "<script src='{$vbaseurl}resources/dist/js/jquery.bootpag.min.js'></script>" ?>
<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#tbmt_dtauditoria').DataTable({
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
	        "fnDrawCallback": function (oSettings) {
	            $('[data-toggle="popover"]').popover({
	                trigger: 'hover',
	                html: true
	            })
	        }
	    });
	})

	$('#fictxtusuario').selectpicker();

	$('#txtfecha').change(function(event) {
		if ($('#txtfechafin').val() == "" || $('#txtfechafin').val() != "") {
			var fecha = $('#txtfecha').val();
			$('#txtfechafin').val(fecha)
		}
	});

	$('#txtfechafin').change(function(event) {
		if ($('#txtfecha').val() == "") {
			$("#txtfecha").prop("required", true);
		}
		
	});
	$("#frm_search_auditoria").submit(function(event) {
		fn_filtrar_auditoria();
		// fn_filtrar_auditoria(1);
		return false;
	});

	$('#modetalle_aud').on('show.bs.modal', function (e) {
	    var rel=$(e.relatedTarget);
	    $("#divdetalle").html("<p>"+rel.data("detalle")+"</p><p><b>Fecha: </b>"+rel.data("fecha")+"</p><p><b>Hora: </b>"+rel.data("hora")+"</p>");
	});

	function fn_filtrar_auditoria(){
        
        $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        tbauditoria = $('#tbmt_dtauditoria').DataTable();
    	tbauditoria.clear();
        $.ajax({
            url: base_url + 'auditoria/search_list',
            type: 'post',
            dataType: 'json',
            data: $("#frm_search_auditoria").serialize(),
            // data: $("#frm_search_auditoria").serialize() + "&inicio="+ inicio +"&limite="  + limite,
            success: function(e) {
                $('#divboxhistorial #divoverlay').remove();
                if (e.status== true) {
                	$.each(e.vdata, function(index, v) {
                		acciones = "<div class='btn-group'>"+
                                    "<button class='btn btn-warning btn-sm dropdown-toggle py-0' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> "+
                                        "<i class='fas fa-cog mr-1'></i>"+
                                    "</button> "+
                                    "<div class='dropdown-menu  dropdown-menu-right'> "+
                                        '<a class=dropdown-item href=# title=Ver detalle data-detalle="'+v['descripcion']+'" data-fecha="'+v['fecha']+'" data-hora="'+v['hora']+'" data-toggle="modal" data-target="#modetalle_aud">'+
		                                	'<i class="fas fa-user-edit mr-1"></i> Ver'+
		                                '</a>'+
		                                '<a class="dropdown-item" onclick="fn_delete_auditoria($(this));return false;" href="#" title="Eliminar" data-id="'+v['codigo64']+'">'+
		                                	'<i class="fas fa-trash mr-1"></i> Eliminar'+
		                                '</a>'+
                                        "<div class='dropdown-divider'></div> "+
                                    "</div> "+
                                "</div> ";
                        fechatb = v['fecharegistra']+'<br>'+v['accion'];
                		var fila = tbauditoria.row.add([index + 1, v['nick'], fechatb, v['descripcion'], v['nomsede'], acciones]).node();
                	});

                	tbauditoria.draw();

                    // $('#divres-historial').html(e.vdata);

                    // $('#divcantfiltro').html("Cantidad: "+ e.numitems);
                    
                    // pagination_auditoria(e.numitems,pagina);
                    
                } else {
                    $('#divres-historial').html(e.vdata);
                    $('#divcantfiltro').html("Cantidad: 0");
                    //$('.divhide').addClass('d-none');
                    pagination_auditoria(0);
                }
                
            },
            error: function(jqXHR, exception) {
                $('#divboxhistorial #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divres-historial').html(msgf);
            }
        });
        return false;
    }

    function fn_filtrar_auditoria_v1(pagina){
    	var limite = "10";
        var inicio = (pagina - 1) * limite;
        
        $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        $.ajax({
            url: base_url + 'auditoria/search_list',
            type: 'post',
            dataType: 'json',
            data: $("#frm_search_auditoria").serialize() + "&inicio="+ inicio +"&limite="  + limite,
            success: function(e) {
                $('#divboxhistorial #divoverlay').remove();
                if (e.status== true) {
                    $('#divres-historial').html(e.vdata);

                    $('#divcantfiltro').html("Cantidad: "+ e.numitems);
                    
                    pagination_auditoria(e.numitems,pagina);
                    
                } else {
                    $('#divres-historial').html(e.vdata);
                    $('#divcantfiltro').html("Cantidad: 0");
                    //$('.divhide').addClass('d-none');
                    pagination_auditoria(0);
                }
                
            },
            error: function(jqXHR, exception) {
                $('#divboxhistorial #divoverlay').remove();
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divres-historial').html(msgf);
            }
        });
        return false;
    }

    function pagination_auditoria(cantidad,total=1){
    	var pagtotal = Math.round(cantidad / 10);
        $('#page-selection').html('');
        if (pagtotal > 0) {
            $('#page-selection').bootpag({
                total: pagtotal,
                page: total,
                maxVisible: 4,
                wrapClass: "pages",
                disabledClass: "not-active"
            }).on("page", function(event, num){
                var limite = "10";
                var inicio = (num - 1) * limite;
                $('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                $.ajax({
                    url: base_url + 'auditoria/search_list',
                    type: 'post',
                    dataType: 'json',
                    data: $("#frm_search_auditoria").serialize() + "&inicio="+ inicio +"&limite="  + limite,
                    success: function(e) {
                        $('#divboxhistorial #divoverlay').remove();
                        if (e.status== true) {
                            $('#divres-historial').html(e.vdata);

                            $('#divcantfiltro').html("Cantidad: "+ e.numitems);
                            
                            //$('.divhide').addClass('d-none');
                            
                            
                            
                        } else {
                            $('#divres-historial').html(e.vdata);
                            $('#divcantfiltro').html("Cantidad: 0");
                            //$('.divhide').addClass('d-none');
                            
                        }
                        
                    },
                    error: function(jqXHR, exception) {
                        $('#divboxhistorial #divoverlay').remove();
                        var msgf = errorAjax(jqXHR, exception, 'text');
                        $('#divres-historial').html(msgf);
                    }
                });

            });
        } else {
            $('#page-selection').html('');
        }
    }

    function fn_delete_auditoria(btn) {
    	var fila = btn.closest('.cfila');
		var codigo = btn.data("id");
		var datos = new FormData();
		Swal.fire({
  			title: '¿Está seguro de eliminar este registro?',
  			text: "¡Si no lo está puede cancelar la acción!",
            type: 'warning',
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar!'

		}).then(function(result){
			if(result.value){
				$('#divboxhistorial').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
                datos.append("txtcodigo", codigo);

                $.ajax({
                  	url: base_url + "auditoria/fneliminar_registro",
                  	method: "POST",
                  	data: datos,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success:function(e){
                    	$('#divboxhistorial #divoverlay').remove();
                    	if (e.status == true) {
                    		Swal.fire({
	                          	type: "success",
	                          	icon: "success",
	                          	title: "¡CORRECTO!",
	                          	text: e.msg,
	                          	showConfirmButton: true,
	                          	allowOutsideClick: false,
	                          	confirmButtonText: "Cerrar"
	                        }).then(function(result){

	                            if(result.value){
	                              fila.remove();
	                            }
	                        })
                    	}
                    },
			        error: function(jqXHR, exception) {
			            var msgf = errorAjax(jqXHR, exception,'text');
			            $('#divboxhistorial #divoverlay').remove();
			            Swal.fire({
	              			title: "Error",
	              			text: msgf,
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


</script>