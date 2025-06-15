<!-- Content Wrapper. Contains page content -->
<?php
	$vbaseurl=base_url();
?>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<!-- Main content -->
	<section class="content">
		<div id="divboxnotas" class="card">
			<div class="card-header text-bold pb-1">
				<h4>Mis notas y asistencias</h4>
			</div>
			<div class="card-body">
				<!-- <div class="callout callout-info py-1">
                  <span>Aqui podras visualizar tus <b>notas y asistencias</b> registradas con detalle en la plataforma virtual. <br>
                  	Si deseas imprimir tu boleta ve al Menú <a href="<?php echo $vbaseurl ?>alumno/historial/notas">Boleta de Notas</a></span>
                </div> -->
				<div class="row mb-2">
					<div class="col-md-3">

						<div class="input-group">
						  <select class="custom-select" name="fcbmatriculas" id="fcbmatriculas">
						    <option value="0">* Periodo</option>
								<?php 
								foreach ($mismatriculas as $mat) {
									if ($mat->estado!="6"){
									$mat64local=base64url_encode($mat->codigo);
									echo
									"<option data-periodo='$mat->periodo' data-carrera='$mat->carrera'	data-ciclo='$mat->ciclo' data-seccion='$mat->seccion' data-turno='$mat->turno' value='$mat64local'>$mat->periodo  - $mat->ciclo</option>";
									}
								}
								?>
						  </select>
						  <div class="input-group-append">
						    <button class="btn btn-primary" id="hbn_btn_buscar_boleta" type="button">
						    	<i class="fa fa-arrow-circle-right"></i> Mostrar
						    </button>
						  </div>
						</div>
					</div>
				</div>
				
				
				<div class="col-12 border rounded my-2 py-2">
					<div class="row">
						
						<div id="divperiodo" class="col-md-2"></div>
						<div id="divcarrera" class="col-md-4"></div>
						<div id="divciclo" class="col-md-2"></div>
						<div id="divturno" class="col-md-2"></div>
						<div id="divseccion" class="col-md-2"></div>
						<div id="divmiembro" class="col-md-12"></div>
						
					</div>
				</div>
				
			
				 <div class="btable mt-0">
                    <div class="thead col-12  d-none d-md-block">
                        <div class="row">
                            <div class='col-6 col-md-7'>
					          <div class='row'>
					            <div class='col-2 col-md-1 td'>COD</div>
					            <div class='col-10 col-md-6 td'>UNIDAD DIDÁCTICA
					            </div>
					            <div class='col-12 col-md-5 td'>DOCENTE</div>
					          </div>
					        </div>
					        
					        
					        <div class='col-6 col-md-5'>
					          <div class='row'>
					            <div class='col-5 col-md-2 text-center td'>ESTADO</div>
					            <div class='col-5 col-md-2 text-center td'>NOTA</div>
					            <div class='col-2 col-md-2 text-center td'>REU</div>

					            <div class='col-3 col-md-2 text-right td'>As</div>
					            <div class='col-3 col-md-2 text-right td'>Ft</div>
					            <div class='col-3 col-md-1 text-right td'>Td</div>
					            <div class='col-3 col-md-1 text-right td'>Jt</div>

					          </div>
					        </div>
                        </div>
                    </div>
                    <div class="tbody col-12" id="hbn_div_boleta">
                        
                    </div>
                </div>
				<div class="row">
					<div id="hbn_div_pie_descarga" class='col-12 text-right mb-2'>
					<?php
						//if (isset($miboleta)) echo $miboleta;
					?>
					</div>
					
					<div class="col-12 col-md-12 text-bold">Leyenda</div>
					<div class="col-6 col-md-2">PF = Promedio Final </div>
					<div class="col-6 col-md-2">PR = Promedio</div>
					<div class="col-6 col-md-2">RC = Recuperación</div>
					<div class="col-6 col-md-2">As = Asistencia</div>
					<div class="col-6 col-md-4">Ft = Faltas</div>
					<div class="col-6 col-md-2">Td = Tardanzas</div>
					<div class="col-6 col-md-2">Jt = Justificación</div>
					
				</div>
				
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
<!--<script src="<?php echo base_url(); ?>resources/jquery/pages.js"></script>!-->
<script type="text/javascript">
	
$('#hbn_btn_buscar_boleta').click(function(event) {
	$('#hbn_div_boleta').html("");
	$('#divperiodo').html('');
	$('#divcarrera').html('');
	$('#divciclo').html('');
	$('#divturno').html('');
	$('#divseccion').html('');
	var cmat=$("#fcbmatriculas").val();
	if (cmat!='0'){
		if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?cmt=' + cmat;
            window.history.pushState({path: newurl}, '', newurl);
        }
		$('#divperiodo').html('Periodo: <b>' + $("#fcbmatriculas").find('option:selected').data('periodo') +'</b>');
		$('#divcarrera').html('Programa: <b>' + $("#fcbmatriculas").find('option:selected').data('carrera') +'</b>');
		$('#divciclo').html('Semestre: <b>' + $("#fcbmatriculas").find('option:selected').data('ciclo') +'</b>');
		$('#divturno').html('Turno: <b>' + $("#fcbmatriculas").find('option:selected').data('turno') +'</b>');
		$('#divseccion').html('Sección: <b>' + $("#fcbmatriculas").find('option:selected').data('seccion') +'</b>');
		$('#divboxnotas').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
		$.ajax({
				url: base_url + 'alumno/historial__mi_boleta_notas'	,
			type: 'post',
			dataType: 'json',
			data: {cbmatricula: cmat},
			success: function(e) {
				$('#divboxnotas #divoverlay').remove();
				if (e.status == false) {
					
					var msgf='<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4> ' + e.msg +'</div>';
					$('#hbn_div_boleta').html(msgf);
				}
				else {
					if (e.miscursos!=""){
						$('#hbn_div_boleta').html(e.miscursos);
						//$("#hbn_div_pie_descarga").html(e.miboleta);
					}
				}
			},
		error: function (jqXHR, exception) {
			var msgf=errorAjax(jqXHR, exception,'div');
		$('#divboxnotas #divoverlay').remove();
		$('#hbn_div_boleta').html(msgf);
	},
		});
	}
	else{
		$('#hbn_div_boleta').html("<tr role='rowgroup'><td colspan='13'><h5 class='text-primary'>--- SELECCIONA UN PERIODO</h5></td></tr>");
		$("#hbn_div_pie_descarga").html("");
		if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname ;
            window.history.pushState({path: newurl}, '', newurl);
        }
	}
	return false;
});

$(document).ready(function() {

	var cmat=getUrlParameter("cmt",0);
	
	$("#fcbmatriculas").val(cmat);
	if (cmat!='0'){
		$('#divperiodo').html('Periodo: <b>' + $("#fcbmatriculas").find('option:selected').data('periodo') +'</b>');
		$('#divcarrera').html('Programa: <b>' + $("#fcbmatriculas").find('option:selected').data('carrera') +'</b>');
		$('#divciclo').html('Semestre: <b>' + $("#fcbmatriculas").find('option:selected').data('ciclo') +'</b>');
		$('#divturno').html('Turno: <b>' + $("#fcbmatriculas").find('option:selected').data('turno') +'</b>');
		$('#divseccion').html('Sección: <b>' + $("#fcbmatriculas").find('option:selected').data('seccion') +'</b>');
	}
	$('#hbn_btn_buscar_boleta').click();
});
</script>