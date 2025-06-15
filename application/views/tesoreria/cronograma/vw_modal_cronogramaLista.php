<div class="modal fade" id="modListaCronogramas" tabindex="-1" role="dialog" aria-labelledby="modListaCronogramas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
		<div class="modal-content" id="vw_mdlc_divListaCronogramas">
			<div class="modal-header">
				<h5 class="modal-title" >
				Periodo:
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<div >
					<form id="vw_cmdip_frmFechaItemPagpo" accept-charset="utf-8">
						
						<div class="col-md-12">
							<div class="row">
								
								<input type="hidden" id="vw_dg_txtcambio" name="vw_dg_txtcambio" value="">
								<input type="hidden" id="vw_dg_cbcarrera" name="vw_dg_cbcarrera" value="">
								<input type="hidden" id="vw_dg_cbciclo" name="vw_dg_cbciclo" value="">
								<input type="hidden" id="vw_dg_cbturno" name="vw_dg_cbturno" value="">
								<input type="hidden" id="vw_dg_cbseccion" name="vw_dg_cbseccion" value="">
								<div class="col-12">
		                            <div class="table-responsive">
		                                <table id="tbmt_dtlistacronogramas" class="tbdatatable table table-sm table-hover  table-bordered table-condensed" style="width:100%">
		                                  <thead>
		                                    <tr class="bg-lightgray">
		                                      <th>N°</th>
			                                  <th>PERIODO</th>
			                                  <th>CRONOGRAMA</th>
			                                  <th>INICIA</th>
			                                  <th>CULMINA</th>
			                                  <th>FECHAS</th>
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
					</form>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tbmt_dtlistacronogramas').DataTable({
	       "autoWidth": false,
	        "pageLength": 25,
	        "lengthChange": false,
	        "language": {
	            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
	        },
	        'columnDefs': [
	            {
	            "targets": 0, // your case first column
	            "className": "text-right rowhead",
	            "width": "8px"
	            },
	            {   
	                targets: [3,4], 
	                render: function ( data, type, row ) {
	                  var datetime = moment(data, 'YYYY-MM-DD');
	                  var displayString = moment(datetime).format('DD/MM/YYYY');
	                  if ( type === 'display' || type === 'filter' ) {
	                    return displayString;
	                  } else {
	                    return datetime; // for sorting
	                  }
	                }
	            }
	        ],
	        "fnDrawCallback": function (oSettings) {
	            $('[data-toggle="tooltip"]').tooltip();
	        }
	    });
	});
	function fn_agregarGrupoDeuda(btn) {
      
      var fila = btn.closest('.cfila');
      var id64calendario = fila.data('codcalendario64');
      var periodo = fila.data('codperiodo');
      var programa = $("#vw_dg_cbcarrera").val();
      var semestre = $("#vw_dg_cbciclo").val();
      var turno = $("#vw_dg_cbturno").val();
      var seccion = $("#vw_dg_cbseccion").val();

      $('#vw_mdlc_divListaCronogramas').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
      $.ajax({
          url: base_url + "deudas_grupo/fn_guardar",
          type: 'post',
          dataType: 'json',
          data: {
              vw_dg_idcalend: id64calendario,
              vw_dg_cbperiodo: periodo,
              vw_dg_cbcarrera: programa,
              vw_dg_cbciclo: semestre,
              vw_dg_cbturno: turno,
              vw_dg_cbseccion: seccion
          },
          success: function(e) {
              $('#vw_mdlc_divListaCronogramas #divoverlay').remove();
              if (e.status == false) {
                  $.each(e.errors, function(key, val) {
                      $('#' + key).addClass('is-invalid');
                      $('#' + key).parent().append("<div class='invalid-feedback'>" + val + "</div>");
                  });
              } else {
                  // $("#modGrupos_matriculados").modal("hide");
                  
                  $("#vw_dg_txtcambio").val("SI");
                  $('#modListaCronogramas').modal("hide");
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
  };
</script>