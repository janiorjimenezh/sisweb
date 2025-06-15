<?php  
$nfechas=$curso->sesiones;
//$pJustificar=$pJustifica;
$vbaseurl=base_url(); 

    $acciones['A']['cambiar']="T";
    $acciones['A']['remove']="btn-success";
    $acciones['A']['add']="btn-warning";

    $acciones['T']['cambiar']="F";
    $acciones['T']['remove']="btn-warning";
    $acciones['T']['add']="btn-danger";

    $acciones['F']['cambiar']="J";
    $acciones['F']['remove']="btn-danger";
    $acciones['F']['add']="btn-info";

    if ($pJustifica=="SI"){
        $acciones['J']['cambiar']="E";
        $acciones['J']['remove']="btn-info";
        $acciones['J']['add']="btn-default";
    }
    else{
        $acciones['F']['cambiar']="E";
        $acciones['F']['remove']="btn-danger";
        $acciones['F']['add']="btn-default";
    }

    $acciones['E']['cambiar']="A";
    $acciones['E']['remove']="btn-default";
    $acciones['E']['add']="btn-success";

?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $curso->unidad ?>
            <small> <?php echo $curso->codseccion.$curso->division; ?></small> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="<?php echo $vbaseurl ?>docente/mis-cursos"><i class="fas fa-compass"></i> Mis Unidades didácticas</a>
                </li>
                <li class="breadcrumb-item">
                    
                    <a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><?php echo $curso->unidad ?>
                    </a>
                </li>
                
              <li class="breadcrumb-item active">Asistencias</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section id="s-cargado" class="content">
        <?php include 'vw_curso_encabezado.php'; ?>
        <div id="divboxevaluaciones" class="card">
            <?php
             if (!$alumnos){  ?>
                <div class="card-body ">
                    <center>
                    <br><br><br><br>
                    <h2>Evaluaciones no disponibles, comuniquese con el administrador</h>
                    <br>
                </center>
                </div>
            <?php }
            else { ?>
            <div class="card-header">
                <h3 class="card-title text-bold" id="colos">Reuniones</h3>
                <div class="card-tools">
                    <a href="<?php echo $vbaseurl.'curso/asistencias/excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division) ?>" class="btn-excel btn btn-tool border"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>"  alt="Exportar a Excel" title="Exportar a Excel"></a>
                </div>
            </div>
            <div class="card-body px-2">
                <div class="form-group">
                    <input type="range" class="custom-range" id="ex1" min="1" max="<?php echo count($fechas) ?>">
                </div>
                <table class="table-registro" id="tbasistencia" role="table">
                    <thead role="rowgroup">
                        <tr role="row">
                           <th role="columnheader" class="text-center"><span class="d-none d-sm-block">  CARNÉ </span><span class="d-block d-sm-none">  N° </span></th>
                            <th role="columnheader" class="pl-1">ESTUDIANTE</th>
                            <?php
                            $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                                $fanterior="01/01/90";
                                $nfechas=$curso->sesiones;
                                foreach ($fechas as $key => $fecha) {
                                    $fechaslt=date("d/m/y", strtotime($fecha->fecha));
                                    $inicia=($fechaslt==$fanterior) ? $fecha->inicia."<br>" : "";
                                    echo "<th class='text-center cellAsistencia'><a class='rotar' href='".base_url().'curso/asistencia-sesion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($fecha->sesion)."' >".($key + 1)."||".$inicia.$dias[date("w", strtotime($fecha->fecha))]." ".$fechaslt."</a></th>";
                                    $fanterior=$fechaslt;
                                }
                                echo "<th><b>F(%)</b></th>";
                            ?>
                        </tr>
                    </thead>
                    <tbody role="rowgroup">
                        <?php
                            $numero=0;
                            
                            $anota="";
                            $valor=0;

                            foreach ($miembros as $miembro) {
                                if (($miembro->eliminado=='NO') && ($miembro->ocultar=='NO')){
                                    $numero++;
                                    $colormat=($miembro->codestadomat=="1") ? "black":"red";
                                    echo '<tr role="row" data-idmiembro="'.$miembro->idmiembro.'">
                                            <td class="cell" role="cell">
                                                <small class="d-none d-sm-block">
                                                <b>'.str_pad($numero, 2, "0", STR_PAD_LEFT).'.- </b>'.$miembro->carnet.
                                                '</small>
                                                 <small class="d-block d-sm-none">
                                                <b>'.str_pad($numero, 2, "0", STR_PAD_LEFT).'</b>
                                                </small>
                                            </td>
                                            <td class="cell" role="cell">
                                                <small style="color:'.$colormat.'">'.$miembro->paterno.' '.$miembro->materno.' '.$miembro->nombres.'</small>
                                            </td>';
                                            $aidmiembro=$miembro->idmiembro;
                                            foreach ($fechas as $key => $fecha) {
                                                //var_dump($fecha);
                                                //var_dump($alumnos[$miembro->idmiembro]['asis']);
                                                //if (isset($alumnos[$miembro->idmiembro]['asis'][$fecha->sesion])){
                                                $aaccion=$alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'];
                                                $aid= $alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['idaccion'];
                                                $asistencia= $alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['asistencia'];
                                                $pover="";
                                                $msjJustificacion="";
                                                $colorbtn="btn-default";
                                                switch ($aaccion) {
                                                    case 'A':
                                                        $colorbtn="btn-success";
                                                        break;
                                                    case 'T':
                                                        $colorbtn="btn-warning";
                                                        break;
                                                    case 'F':
                                                        $colorbtn="btn-danger";
                                                        break;
                                                    case 'J':
                                                        if (!is_null($asistencia->codjustificacion)){
                                                            $msjJustificacion= "{$asistencia->jstf_descripcion}<br>
                                                                            Recepcionado por {$asistencia->jstf_recepciona_paterno} {$asistencia->jstf_recepciona_nombres}<br>
                                                                            Fecha: {$asistencia->jstf_fecha_recepcion}";
                                                            $pover="<span class='float-right' data-container='body' data-toggle='popover' data-trigger='hover' data-placement='top' data-content='$msjJustificacion' title='{$asistencia->jstf_motivo}'><i class='fas fa-question-circle text-danger'></i></span>";
                                                        }
                                                        $colorbtn="btn-info";
                                                }
                                                $aaccion=($aaccion=="")?".":$aaccion;
                                                echo "<td class='cell p-1 cellAsistencia' >
                                                    $pover <a data-sesion='".$fecha->sesion."' data-edit='0' data-idacu='".$aid."' data-fecha='".$fecha->fecha."' data-miembro='".$aidmiembro."' class='btnAsistencia btn btn-flat btn-block py-0 px-2 m-0 ".$colorbtn."' href='#'>".$aaccion."</a> 
                                                    </td>";
                                            }
                                            
                                            $pfaltas=round($alumnos[$miembro->idmiembro]['asis']['faltas']/$nfechas*100,0);
                                            $isdpi=($pfaltas>=30) ? "DPI" : "";
                                            if ($isdpi==""){
                                                echo "<td class='text-center'>{$pfaltas}%</td>";
                                            }
                                            else{
                                                echo "<td class='bg-red text-center'><small>$isdpi {$pfaltas}%</small></td>";  
                                            }
                                
                                echo '</tr>';
                                }
                        } ?>
                    </tbody>
                </table>
                <div class="col-md-8" id="divmsgError">
                    
                </div>
                <div class="col-md-4 no-padding float-right margin-top-10px">
                    <button id="btnguardareg" class="btn btn-lg btn-flat btn-primary btn-block">
                    Guardar
                    </button>
                </div>
            </div>
            <?php } ?>
        
        </div>
    </section>
</div>

<script>
    var vccaj = '<?php echo $curso->codcarga ?>';
    var vsscj = '<?php echo $curso->division ?>';

    var acciones =  <?php echo json_encode($acciones); ?>; 
    var pJustifica= '<?php echo $pJustifica ?>';
    var showCols = 2;
    var nrocol = <?php echo count($fechas) ?>;
    var totalColumns=0;
    function obtenerAncho(){
        var ancho=$(window).width();
        if (ancho > 1023) {
            showCols = 20;
        } else if (ancho > 767) {
            showCols = 13;
        } else if (ancho > 479) {
            showCols = 6;
        } else {
            showCols = 4;
        }
    }
    obtenerAncho();
    $(window).resize(function(){
        //var alto=$(window).height();
        obtenerAncho();
        var newVal = $('#ex1').val();
        mostrarcols(newVal);
    });
    

    $("#mdcancel").click(function(event) {
        $("#mdmsg").html("");
        $("#mdfecha").val("");
    });


    function mostrarcols(ncol){
        if (nrocol>showCols){
            $(".cellAsistencia").addClass("ocultar");
            nColReal= parseInt(ncol) + 2;
            rango= Math.trunc((showCols/2)) - 1;
            minc=nColReal - rango;
            maxc=nColReal + rango;
            if (maxc>totalColumns){
                minc=minc - (maxc - totalColumns);
                maxc=totalColumns;
            }else{
                 if (minc<3) {
                    maxc=maxc + (3 - minc);
                    minc=3;
                }
            }
            
            //$("#colos").html("Reuniones: " + nrocol + " Mostrar Fechas: "  + showCols + ": Min:" + minc + " / Max:" + maxc + " step: " + ncol + " Rango: " + rango);
            for (var i = minc; i <= maxc; i++) {
                $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").removeClass("ocultar");
            }
        }
        else{
            $(".cellAsistencia").removeClass("ocultar");
        }
        $("#colos").html("Reuniones: " + nrocol );
    }

    var originalVal;
    $("#ex1").change(function(event) {
        /* Act on the event */
        mostrarcols($(this).val());
    });


    $("#tbasistencia td a").click(function(event) {

        var accion = $.trim($(this).html());
        if ((pJustifica=="NO") && (accion=="J")){
            Swal.fire({
                icon: 'warning',
                title: 'NO PERMITIDO',
                text: "Solo el área de BIENESTAR puede Justificar y realizar una modificación de justificaciones",
            });
        }
        else{
            if (accion==".") accion="E";
            $(this).removeClass(acciones[accion]['remove']);
            $(this).addClass(acciones[accion]['add']);
            accion=acciones[accion]['cambiar'];

            $(this).data('edit', '1')
            $(this).html(accion);
        }
        return false;  
        
    });
    $('#btnguardareg').click(function(event) {
        $('#divboxevaluaciones').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        arrdata = [];
        var edits=0;
        $('#tbasistencia td a').each(function() {
            // <a data-sesion='".$fecha->sesion."' data-edit='$esedit' data-idacu='".$aid."' data-fecha='".$fecha->fecha."' data-miembro='".$aidmiembro."' class='btnAsistencia btn btn-flat btn-block ".$colorbtn."' href='#'>".$aaccion."</a>
                                                   
            var isedit = $(this).data("edit");
            var idacu = $(this).data("idacu");
            var fcha = $(this).data("fecha");
            var accn = $(this).html();
            var idmiembro = $(this).data("miembro");
            var idses = $(this).data("sesion");
            if (isedit == "1") {
                var myvals = [fcha, accn, idacu, idmiembro, idses];
                arrdata.push(myvals);
                    edits++;
            }

        });
        if (edits>0){
        $.ajax({
            url: base_url + 'curso/f_subirasistencia',
            type: 'post',
            dataType: 'json',
            data: {
                vcca: vccaj,
                vssc: vsscj,
                filas: JSON.stringify(arrdata),
            },
            success: function(e) {
                
                if (e.status == false) {
                    $('#divboxevaluaciones #divoverlay').remove();
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: e.msg,
                        backdrop:false,
                    });
                } else {
                    //location.reload();
                     $('.btnAsistencia').each(function() {
                            if ($(this).data('edit')=='1') {
                                if ($(this).data('idacu')<0){
                                    $(this).data('idacu',  e.ids[$(this).data('idacu')]);
                                    $(this).data('edit',  '0');
                                }
                            }
                            });
                        Swal.fire({
                            type: 'success',
                            title: 'ÉXITO, Se guardó cambios',
                            text: "Lo cambios fueron guardados correctamente",
                            backdrop:false,
                        });
                         $('#divboxevaluaciones #divoverlay').remove();
                }
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'div');
                Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios',
                        text: msgf,
                        backdrop:false,
                    });
                $('#divboxevaluaciones #divoverlay').remove();
            },
        });
            }
     else{
            Swal.fire({
                type: 'success',
                title: 'ÉXITO, Se guardó cambios (M)',
                text: "Lo cambios fueron guardados correctamente",
                backdrop:false,
            });
            $('#divboxevaluaciones #divoverlay').remove();
        }
    });

    $(document).ready(function() {
        totalColumns=$("table tr th").length - 1;
        $('#ex1').val(nrocol);
        mostrarcols(nrocol);
        $(function () {
          $('[data-toggle="popover"]').popover({
            html:true
          })
        })
    });




</script>