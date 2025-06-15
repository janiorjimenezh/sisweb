<?php $vbaseurl=base_url();
$nfechas=$curso->sesiones;
$codcarga64=base64url_encode($curso->codcarga);
$division64=base64url_encode($curso->division);
$mostrarfechaCierres=true;
?>
<div class="content-wrapper">
    <input type="hidden" id="vw_eva_carga" value="<?php echo $codcarga64?>">
    <input type="hidden" id="vw_eva_division" value="<?php echo $division64 ?>">
    <div class="modal " id="md_enlazar_aula" tabindex="-1" role="dialog" aria-labelledby="md_enlazar_aula" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conectar Aula virtual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="vw_md_eav_encabezado"></h5>
                    <div class="row">
                        <div class="col-12 text-bold">
                            <div class="row">
                                <div class="col-7">Recursos enlazados</div>
                                <div class="col-5"></div>
                            </div>
                        </div>
                        <div class="col-12" id="vw_md_eav_divrecursos">
                            
                        </div>
                    </div>
                    <input type="hidden" id="vw_md_eav_codencabezado">
                    <div class="row mt-2">
                        <div class="col-7 text-bold">Enlazar recurso</div>
                        <div class="col-10">
                            <select class="form-control form-control-sm" name="vw_md_eav_recurso" id="vw_md_eav_recurso">
                            </select>
                        </div>
                        <div class="col-2">
                            <a id="vw_btn_update_enlazar" class="btn btn-sm btn-primary" href="#">Enlazar</a>
                        </div>
                        <div class="col-12">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php include 'vw_curso_encabezado.php'; ?>
    <section id="s-cargado" class="content">
        <div id="divboxevaluaciones" class="card card-primary card-outline">
            <?php if (!isset($notas)){  ?>
            <div class="card-body ">
                <div>
                    <h2 class="text-bold">SIN ESTUDIANTES</h2>
                    <h3 class="text-danger">Compruebe que han sido declarados los <b>Indicadores</b></h3>
                    <br>
                    <br>
                </div>
            </div>
            <?php }
            else { ?>
            
            <div class="card-body px-2">
                <div class="col-12 d-block d-md-none">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input " id="switchpf">
                        <label class="custom-control-label" for="switchpf">Ver promedio Final</label>
                    </div>
                    <br>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="has-float-label col-6 p-0 mb-2">
                            
                            <select data-currentvalue='' class="form-control text-bold text-primary" id="cbindicador" name="cbindicador" placeholder="Selecciona la unidad" required >
                                <?php foreach ($indicadores as $indicador) {
                                $nindi++;?>
                                <option value="<?php echo $indicador->codigo ?>"><?php echo $indicador->norden.' - '.$indicador->nombre ?></option>
                                <?php } ?>
                                <option value="0">Todos los indicadores</option>
                            </select>
                            <label for="cbindicador"> Selecciona la unidad</label>
                        </div>
                        <div class="col-6 text-right">
                            <a href="<?php echo $vbaseurl.'curso/evaluaciones/excel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division) ?>" class="btn-excel btn btn-outline-secondary float-rsight"><img src="<?php echo $vbaseurl.'resources/img/icons/p_excel.png' ?>" class="float-left" alt="">
                                Exportar
                            </a>
                        </div>
                    </div>
                </div>
                
                <table class="table-registro" id="tbasistencia" role="table">
                    <thead role="rowgroup">
                        <tr role="row">
                            <th class="cell" data-indicador='0' role="columnheader"><span class="d-none d-sm-block">CARNÉ</span></th>
                            <th class="cell" data-indicador='0' role="columnheader">ALUMNO</th>
                            <?php
                            foreach ($indicadores as $indicador) {
                            foreach ($evaluaciones as $evaluacion) {
                            if ($evaluacion->indicador==$indicador->codigo){
                            if ($evaluacion->abrevia!="RC"){
                            $color=($evaluacion->tipo=="C") ? "text-primary" : "";
                            $codencabezado=base64url_encode($evaluacion->evaluacion);
                            echo "<th  class='cell' data-indicador='$indicador->codigo' data-toggle='tooltip' data-placement='top' title='$evaluacion->nombre $indicador->norden'>
                                <a data-codencabezado='$codencabezado' data-encabezado='$evaluacion->nombre $indicador->norden' href='#' class='vw_btn_enlazar mt-1 rotar $color'>".$evaluacion->abrevia.$indicador->norden."</a></th>";
                                }
                                }
                                }
                                }
                                ?>
                                <th data data-indicador='-1' role="columnheader">
                                    
                                </th>
                                <th class="cell" data-toggle='tooltip' data-placement='top' title='Promedio'  data-indicador='-1' role="columnheader">
                                    <span class='mt-1 rotar text-success'>PR</span>
                                </th>
                                <th class="cell" data-toggle='tooltip' data-placement='top' title='Recuperación'  data-indicador='-1' role="columnheader">
                                    <span class='mt-1 rotar text-success'>RC</span>
                                </th>
                                <th class="cell" data-toggle='tooltip' data-placement='top' title='Promedio Final'  data-indicador='-1' role="columnheader">
                                    <span class='mt-1 rotar text-success'>PF</span>
                                </th>
                                
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
                                    <span class="d-none d-sm-block">
                                        <b>'.str_pad($numero, 2, "0", STR_PAD_LEFT).'.- </b>'.$miembro->carnet.
                                    '</span>
                                    <span class="d-block d-sm-none">
                                        <b>'.str_pad($numero, 2, "0", STR_PAD_LEFT).'</b>
                                    </span>
                                </td>
                                <td class="cell" role="cell">
                                    <span style="color:'.$colormat.'">'.$miembro->paterno.' '.$miembro->materno.' '.$miembro->nombres.'</span>
                                </td>';
                                
                                foreach ($indicadores as $indicador) {
                                foreach ($evaluaciones as $evaluacion) {
                                if ($evaluacion->indicador==$indicador->codigo){
                                if ($evaluacion->abrevia!="RC"){
                                $aidmiembro=$miembro->idmiembro;
                                
                                $anota="";
                                $valor=0;
                                $colorbtn="text-default";
                                
                                $valor= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['nota'] ;
                                $tipo= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['tipo'] ;
                                $anota=$valor;
                                $colorbtn="text-danger";
                                if ($valor>=12.5) $colorbtn="text-primary";
                                
                                if ($tipo=="M"){
                                $aid= $notas[$aidmiembro]['eval'][$evaluacion->indicador][$evaluacion->nombre_calculo]['idnota'] ;
                                echo "<td class='cell text-right' >
                                    <span id='".$aidmiembro.$indicador->codigo.$evaluacion->nombre_calculo."' class='$colorbtn'>$anota</span>
                                </td>";
                                }
                                else{
                                //var_dump($anota);
                                echo "<td class='cell text-right' >
                                    <span id='".$aidmiembro.$indicador->codigo.$evaluacion->nombre_calculo."' class='$colorbtn'>$anota</span>
                                </td>";
                                }
                                }
                                }
                                }
                                }
                                echo "<td class='text-right' >
                                    <span >
                                    </span>
                                </td>";
                                $nt=$notas[$aidmiembro]['eval']['PI']['nota'];
                                $colornt="text-danger";
                                if ($nt>=12.5) $colornt="text-primary";
                                echo "<td class='cell text-right' >
                                    <span id='".$aidmiembro."PI' class='$colornt'>
                                    $nt</span>
                                </td>";
                                
                                $anota=$notas[$aidmiembro]['eval']['RC']['nota'];
                                $colorpf="text-danger";
                                 if ($anota>=12.5) $colorpf="text-primary";
                                echo "<td data-dpi='NO' class='text-center p-0 text-bold $colorpf'><span id='".$aidmiembro."PF'>$anota</span></td>";
                                $pf=$notas[$aidmiembro]['eval']['PF']['nota'];
                                $colorpf="text-danger";
                                if ($pf>=12.5) $colorpf="text-primary";
                                $pfaltas=round($notas[$miembro->idmiembro]['asis']['faltas']/$nfechas*100,0);
                                $isdpi=($pfaltas>=30) ? "DPI" : "";
                                if ($isdpi==""){
                                echo "<td data-dpi='NO' class='text-center p-0 text-bold $colorpf'><span id='".$aidmiembro."PF'>$pf</span></td>";
                                }
                                else{
                                echo "<td data-dpi='SI' class='bg-red text-center p-0'><span id='".$aidmiembro."PF'>$isdpi</span></td>";
                                }
                                
                            echo '</tr>';
                            }
                            } ?>
                        </tbody>
                    </table>
                    <div class="col-md-8" id="divmsgError">
                        
                    </div>

                </div>
                <?php } ?>
                
            </div>
        </section>
    </div>
    <script>
    var vccaj = '<?php echo $curso->codcarga ?>';
    var vsscj = '<?php echo $curso->division ?>';
    var vindicadores = <?php echo json_encode($indicadores, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS) ?>;
    $("#cbindicador").change(function(event) {
        var ind = $(this).val();
        mostrarcols(ind);
    });

    function mostrarcols(nindicador) {
        var i = 1;
        if (nindicador == '0') {
            //$("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").show();
            $("table tr td, table tr th").show();
        } else {
            $('.table-registro th').each(function() {
                var ind = $(this).data("indicador");
                if (ind > "0") {
                    $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").hide();
                    if (ind == nindicador) {
                        $("table tr td:nth-child(" + (i) + "), table tr th:nth-child(" + (i) + ")").show();
                    }
                }
                i++;
            });
        }

    }

    $(document).ready(function() {
        mostrarcols($("#cbindicador").val());
        var ancho = $(window).width();
        if (ancho > 479) {
            $("#switchpf").attr('checked', true);
        } else {
            $("#switchpf").attr('checked', false);
        }

        $("#switchpf").change();
        $('[data-toggle="tooltip"]').tooltip()
    });

    /**/

    </script>