<div class="modal fade" id="modguardarnotas" tabindex="-1" role="dialog" aria-labelledby="modguardarnotas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
		<div class="modal-content" id="divmodaladd_nf">
			<div class="modal-header">
				<h5 class="modal-title">Modificar notas finales</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<small id="fmt-conteo" class="form-text text-primary">
				
				</small>
				<div class="btable" id="div_filtro_head">
					<div class="thead col-12  d-none d-md-block">
						<div class="row">
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-3 td small text-bold">NRO</div>
									<div class="col-md-9 td small text-bold">CARNÉ</div>
								</div>
							</div>
							<div class="col-md-4 td small text-bold">ESTUDIANTE</div>
							<div class="col-md-2 td small text-bold">ORIGEN</div>
							<div class="col-md-1 td small text-bold">NOTA FIN</div>
							<div class="col-md-1 td small text-bold">NOTA REC.</div>
							<div class="col-md-1 td small text-bold"></div>
						</div>
					</div>
					<div id="div_notas_alumnos" class="tbody col-12">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<?php if (getPermitido("128")=='SI'){ ?>
				<button type="button" id="vw_mpc_btn_subirnotas_final" class="btn btn-primary">Guardar</button>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">


	function fn_cambiar_origen(btn) {
	    var fila = btn.closest('.cfila');
	    var codigo = fila.data('codmatnota');
	    var vcodmatricula64=fila.data("codmatricula64");
	    var vNuevoOrigen = btn.data('origen');
	    var btdt = btn.parents(".btn-group").find('.dropdown-toggle');
	    var vViejoOrigen = btdt.html();

	    vtxtNotaFin=fila.find(".txtnotafin");
	    vtxtNotaFin=fila.find(".txtnotafin");
	    
	    vtxtNotaRec=fila.find(".txtnotarec");
	    $('#divmodaladd_nf').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');

	    $.ajax({
	        url: base_url + 'academico/carga-academica/miembros/migrada/update-origen',
	        type: 'post',
	        dataType: 'json',
	        data: {
	            'ce-codmatriculanota64': codigo,
	            'ce-norigen': vNuevoOrigen,
	            'ce-norigenanterior': vViejoOrigen,
	            'ce-codmatricula64': vcodmatricula64 
	        },
	        success: function(e) {
	            $('#divmodaladd_nf #divoverlay').remove();
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
	                    title: 'Felicitaciones, origen actualizado',
	                    text: 'Se ha actualizado el origen',
	                    backdrop: false,
	                })
	                btdt.removeClass('btn-primary');
	                btdt.removeClass('btn-info');
	                btdt.removeClass('btn-secondary');
	                switch (vNuevoOrigen) {
	                    case "PLATAFORMA":
	                        btdt.addClass('btn-primary');
	                        vtxtNotaFin.attr('readonly', true);
	                        vtxtNotaFin.addClass("bg-lightgray");
	                        //vtxtNotaRec.attr('readonly', 'true');
	                        break;
	                    case "MANUAL":
	                        btdt.addClass('btn-secondary');
	                        vtxtNotaFin.attr('readonly', false);
	                        vtxtNotaFin.removeClass("bg-lightgray");
	                        break;
	                    case "CONVALIDA":
	                        btdt.addClass('btn-info');
	                        vtxtNotaFin.attr('readonly', false);
	                        vtxtNotaFin.removeClass("bg-lightgray");
	                        break;
	                    default:
	                        btdt.addClass("btn-info");
	                }
	                btdt.html(vNuevoOrigen);

	            }
	        },
	        error: function(jqXHR, exception) {
	            var msgf = errorAjax(jqXHR, exception, 'text');
	            $('#divmodaladd_nf #divoverlay').remove();
	            Swal.fire({
	                icon: 'error',
	                title: 'Error',
	                text: msgf,
	                backdrop: false,
	            })
	        }
	    });
	    return false;
	}

	function fn_modGuardarNotas(boton) {

    //MUESTRA LOS DATOS DE LOS ALUMNOS PARA GUARDAR SOLO NOTAS FINALES Y RECUPERACION
    $('#divcard_cursos').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $('#divcard_grupo').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    $("#div_filtro_alumno").html("");
    var fila_division = boton.closest(".fdivision");

    var vdocente = fila_division.data("coddocente");
    var vunidad = fila_division.data("codunidad");


    var jscodccarga = fila_division.data("codcarga64");
    var jscoddivision = fila_division.data("division64");

    $.ajax({
        url: base_url + "academico/carga-academica/miembros/filtro-con-notas",
        type: 'post',
        dataType: 'json',
        data: {
            codcarga: jscodccarga,
            coddivision: jscoddivision,
        },
        success: function(e) {
            if (e.status == false) {

            } else {
                $('#divcard_cursos #divoverlay').remove();
                $('#divcard_grupo #divoverlay').remove();
                $('#modguardarnotas').modal('show');
                var nro = 0;
                var tabla = "";
                var notafin = "";
                var notarec = "";
                var btndwl = "";
                if (e.vdata.length > 0) {
                    if (vpermiso128 == 'SI') {
                        btndwl = '<a class="btn btn-info btn-sm btndownload_notas" href="#" onclick="fn_migrar_notas($(this));return false;" title="Migrar a Historial"><i class="fas fa-download"></i> </a>';
                    } else {
                        btndwl = "";
                    }
                    $.each(e.vdata, function(index, v) {
                        nro++;
                        //var vcm = v['codmatricula64'];
                        var vcarga = v['codcarga'];
                        var vdivision = v['codsubseccion'];

                        var vcarrera = v['codcarrera'];
                        var vciclo = v['codciclo'];
                        var vperiodo = v['codperiodo'];
                        var vplan = v['codplan'];
                        var vseccion = v['codseccion'];
                        var vturno = v['codturno'];
                        var vidmiembro = v['codmiembro64'];
                        var codmatnota = v['codnotamigrada64'];
                        var codmatricula64=v['codmatricula64']; 

                        var carne = v['carne'];
                        var estudiante=v['paterno'] + " " + v['materno'] + " " + v['nombres']; 


                        var notafin_his = (v['notafin_migrada'] !== null) ? v['notafin_migrada'] : "";
                        colorbtnfin=(notafin_his>12.5) ? "text-primary":"text-danger";

                        var notarec_his = (v['notarecuperacion_migrada'] !== null) ? v['notarecuperacion_migrada'] : "";
                        colorbtnrec=(notarec_his>12.5) ? "text-primary":"text-danger";

                        var fechamat = v['fecha'];


                        var vReadonly="";
                        var vColorFondoTxtFin="";
                        if (v['origentipo'] == "MANUAL") {
                            colortipo = "btn-secondary";
                        } else if (v['origentipo'] == "PLATAFORMA") {
                            colortipo = "btn-primary";
                            vReadonly="readonly";
                            vColorFondoTxtFin="bg-lightgray";
                        } else if (v['origentipo'] == "CONVALIDA") {
                            colortipo = "btn-warning";
                            vReadonly="readonly";
                            vColorFondoTxtFin="bg-lightgray";
                        } else {
                            colortipo = "btn-info";
                        }

                        vOrigenCombo=   '<div class="btn-group m-0">' +
                                            '<button class="btn ' + colortipo + ' btn-sm dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            v['origentipo'] +
                                            '</button>' +
                                            '<div class="dropdown-menu">' +
                                                '<a href="#" onclick="fn_cambiar_origen($(this));return false;" class="btn-cborigen dropdown-item" data-origen="PLATAFORMA">PLATAFORMA</a>' +
                                                '<a href="#" onclick="fn_cambiar_origen($(this));return false;" class="btn-cborigen dropdown-item" data-origen="MANUAL">MANUAL</a>' +
                                               
                                            '</div>' +
                                        "</div>";
                        if (v['origentipo'] == "CONVALIDA") vOrigenCombo='<button class="btn ' + colortipo + ' btn-sm py-0"  > CONVALIDA </button>';
                        
                        tabla = tabla + 
                            '<div data-carne="' + carne + '" data-estudiante="' + estudiante + '" data-codmiembro="' + vidmiembro + '" data-codmatricula64="' + codmatricula64 + '" data-codmatnota="' + codmatnota + '" data-carga="' + vcarga + '" data-division="' + vdivision + '" data-docente="' + vdocente + '" data-carrera="' + vcarrera + '" data-ciclo="' + vciclo + '" data-periodo="' + vperiodo + '" data-plan="' + vplan + '" data-seccion="' + vseccion + '" data-turno="' + vturno + '" data-unidad="' + vunidad + '" data-estado="' + v['estado'] + '" data-repitencia="' + v['repitencia'] + '" data-notafin="' + v['notafin'] + '" data-notarecuperacion="' + v['notarecuperacion'] + '"  data-notafinmigrada="' + v['notafin_migrada'] + '" data-notarecuperacionmigrada="' + v['notarecuperacion_migrada'] + '" data-matfecha="' + fechamat + '" class="row cfila rowcolor ">' +
                            '<div class="col-4 col-md-3">' +
                            '<div class="row">' +
                            '<div class="col-3 col-md-3 td">' + nro + '</div>' +
                            '<div class="col-9 col-md-9 td">' + v['carne'] + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-8 col-md-4 td">' + v['paterno'] + ' ' + v['materno'] + ' ' + v['nombres'] + '</div>' +
                            '<div class="col-6 col-md-2 td">' + vOrigenCombo + '</div>' +
                            '<div class="col-2 col-md-1 td text-center tdnota_his" >' + 
                                '<input ' + vReadonly + ' class="txtnota txtnotafin ' + vColorFondoTxtFin + ' ' + colorbtnfin + '" data-valor="' + notafin_his + '" max="20" min="0"  value="' + notafin_his + '" >' +
                            '</div>' +
                            '<div class="col-2 col-md-1 td text-center tdnota_rec_his">' +
                              '<input class="txtnota txtnotarec ' + colorbtnrec + '" data-valor="' + notarec_his + '" max="20" min="0"  value="' + notarec_his + '" >' +
                             '</div>' +
                            '</div>';
                    })
                    $("#div_notas_alumnos").html(tabla);
                    //$("#fmt-conteo").html(nro + ' Alumnos encontrados');
                    //$('#div_notas_alumnos').css('height', '359px');
                    //$('#vw_mpc_btn_subirnotas').show();
                } else {
                    $("#div_notas_alumnos").html("<div class='text-danger h5'>Esta unidad didáctica aún no se ha culminado</div>");
                    //$("#fmt-conteo").html('');
                    $('#div_notas_alumnos').css('height', 'auto');
                    //$('#vw_mpc_btn_subirnotas').hide();
                }


                //********************************************/

            }
        },
        error: function(jqXHR, exception) {
            var msgf = errorAjax(jqXHR, exception, 'text');
            $('#divcard_cursos #divoverlay').remove();
            $('#divcard_grupo #divoverlay').remove();
            //$('#divError').show();
            //$('#msgError').html(msgf);
        }
    });
    return false;
}

//AQUI SUBE LAS NOTAS FINALES MODIFICADAS
$('#vw_mpc_btn_subirnotas_final').click(function() {
    arrdata = [];
    $('#div_notas_alumnos .rowcolor').each(function() {
        var idmat = $(this).data('idm');
        var codmatnota = $(this).data('codmatnota');

        var carga = $(this).data('carga');
        var division = $(this).data('division');
        var docente = $(this).data('docente');
        var miembro = $(this).data('miembro');
        var carne = $(this).data('carne');
        var estudiante = $(this).data('estudiante');
        var carrera = $(this).data('carrera');
        var ciclo = $(this).data('ciclo');
        var periodo = $(this).data('periodo');
        var plan = $(this).data('plan');
        var seccion = $(this).data('seccion');
        var turno = $(this).data('turno');
        var unidad = $(this).data('unidad');
        var estado = $(this).data('estado');
        var repitencia = $(this).data('repitencia');
        var notfin = ($(this).data('notafinmigrada')==null) ? "": $(this).data('notafinmigrada');
        var notrec = ($(this).data('notarecuperacionmigrada')==null) ? "": $(this).data('notarecuperacionmigrada');
        var notfin_txt=$(this).find(".txtnotafin").val();
        var notrec_txt=$(this).find(".txtnotarec").val();
        
        var fechamatr = $(this).data('matfecha');
        //alert(Number(notfin) + " + " + Number(notfin_txt) + "="  + (Number(notfin)!=Number(notfin_txt)));
        if ((Number(notfin)!=Number(notfin_txt)) || (Number(notrec)!=Number(notrec_txt))){
            //alert("entro");
            notfin=notfin_txt;
            notrec=notrec_txt;
            
            var myvals = [idmat, miembro, codmatnota, carga, division, docente, carrera, ciclo, periodo, plan, seccion, turno, unidad, estado, repitencia, notfin, notrec, fechamatr, carne, estudiante];
            arrdata.push(myvals);
        }
    })

    $('#divmodaladd_nf').append('<div id="divoverlay" class="overlay bg-white d-flex justify-content-center align-items-center"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
    if (arrdata.length>0){
        $.ajax({
            url: base_url + 'academico/carga-academica/miembros/migrada/update-notas-final',
            type: 'post',
            dataType: 'json',
            data: {
                filas: JSON.stringify(arrdata),
            },
            success: function(e) {
                $('#divmodaladd_nf #divoverlay').remove();
                if (e.status == false) {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: e.msg,
                        backdrop: false,
                    });
                } else {
                    $('#div_notas_alumnos .rowcolor').each(function() {
                        fila = $(this);
                        var codmatnota = $(this).data('codmatnota');
                        var notfin_txt=$(this).find(".txtnotafin").val();
                        var notrec_txt=$(this).find(".txtnotarec").val();

                        $.each(e.vdata, function(index, val) {
                            if (val['status'] == true) {
                                if (codmatnota == val['codorigen']) {

                                    fila.data('notafinmigrada', notfin_txt);
                                    fila.data('codmatnota', val['codnotamigrada64']);
                                    fila.data('notarecuperacionmigrada', notrec_txt);
                                    fila.data('estado', val['estado']);
                                }
                            }
                        })

                    });

                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'ÉXITO, Se guardó cambios',
                        text: "Lo cambios fueron guardados correctamente",
                        backdrop: false,
                    });

                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception, 'text');
                $('#divmodaladd_nf #divoverlay').remove();
                Swal.fire({
                    type: 'error',
                    icon: 'error',
                    title: 'ERROR, NO se guardó cambios',
                    text: msgf,
                    backdrop: false,
                });
            },
        })
    }
    else{
        $('#divmodaladd_nf #divoverlay').remove();
        Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'ÉXITO, Se guardó cambios',
                        text: "Lo cambios fueron guardados correctamente",
                        backdrop: false,
                    });
    }
    return false;
});

</script>