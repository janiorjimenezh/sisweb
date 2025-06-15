<?php $vbaseurl=base_url();
$nfechas=$curso->sesiones; ?>
<div class="content-wrapper">
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $curso->unidad ?>
            <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
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
                
              <li class="breadcrumb-item active">Asistencia</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section id="s-cargado" class="content">
        <?php include 'vw_curso_encabezado.php'; ?>
        <div id="divboxevaluaciones" class="card card-success">
            <?php if (!$alumnos){  ?>
                <div class="card-body ">
                <center>
                    <br><br><br><br>
                    <h2>Asistencias no disponibles, comuniquese con el administrador</h>
                    <br>
                </center>
                </div>
            <?php }
            else { ?>
            <div class="card-body px-2 pt-2">
                <div class="col-12 text-center">

                <span class="h5">Reunión:</span>
                <span class="h5 text-primary">
                <?php 
                    $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                    $fanterior="01/01/90";
                    foreach ($fechas as $key => $fecha) {
                        $fechaslt=date("d/m/y", strtotime($fecha->fecha));
                        $inicia=date("h:i a", strtotime($fecha->inicia));
                        echo $dias[date("w", strtotime($fecha->fecha))]." - ".$fechaslt." ".$inicia;
                    }
                ?>
                </span>
                </div>
                <table class="table-registro mt-1" id="tbasistencia" role="table">
                    <thead role="rowgroup">
                        <tr role="row">
                            <th role="columnheader" class="text-center">
                                <span class="d-none d-sm-block">CARNÉ</span>
                                <span class="d-block d-sm-none">N°</span>
                            </th>
                            <th role="columnheader">ESTUDIANTE</th>
                            <?php
                            $dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
                                $fanterior="01/01/90";
                                $nfechas=$curso->sesiones;
                                foreach ($fechas as $key => $fecha) {
                                    $fechaslt=date("d/m/y", strtotime($fecha->fecha));
                                    $inicia=($fechaslt==$fanterior) ? $fecha->inicia."<br>" : "";
                                    echo "<th class='text-center'><a class='rotar' href='".base_url().'curso/asistencia-sesion/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division).'/'.base64url_encode($fecha->sesion)."' >".$inicia.$dias[date("w", strtotime($fecha->fecha))]." ".$fechaslt."</a></th>";
                                    $fanterior=$fechaslt;
                                }
                            ?>
                            <th class="bg-green" role="columnheader">
                                
                                <div class='checkround'>
                                    <input value='A' type='radio' name='radiocol' class='radiocolbox' id='acheckboxcol' />
                                    <label for='acheckboxcol'></label>
                                </div>
                                <span class='rotar'>Asitió&nbsp;&nbsp;</span>
                            </th>
                            
                            <th class="bg-red" role="columnheader">

                                <div class='checkround'>
                                    <input value='F' type='radio' name='radiocol' class='radiocolbox' id='fcheckboxcol' />
                                    <label for='fcheckboxcol'></label>
                                </div>
                                <span class='rotar'>Faltó&nbsp;&nbsp;</span>
                            </th>
                            <th class="bg-yellow" role="columnheader">

                                <div class='checkround'>
                                    <input value='T' type='radio' name='radiocol' class='radiocolbox' id='tcheckboxcol' />
                                    <label for='tcheckboxcol'></label>
                                </div>
                                <span class='rotar'>Tarde&nbsp;&nbsp;</span>
                            </th>
                            <th class="bg-aqua" role="columnheader">
                                <?php if ($pJustifica=="SI"): ?>
                                    <div class='checkround'>
                                        <input value='J' type='radio' name='radiocol' class='radiocolbox' id='jcheckboxcol' />
                                        <label for='jcheckboxcol'></label>
                                    </div> 
                                <?php endif ?>
                                
                                <span class='rotar'>Justif.&nbsp;&nbsp;</span>
                            </th>
                            <th class="" role="columnheader">

                                <div class='checkround'>
                                    <input value='E' type='radio' name='radiocol' class='radiocolbox' id='echeckboxcol' />
                                    <label for='echeckboxcol'></label>
                                </div>
                                <span class='rotar'>Exoner.&nbsp;&nbsp;</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody role="rowgroup">
                        <?php
                            $numero=0;
                            
                            $anota="";
                            $valor=0;
                            $va=0;
                                                $vf=0;
                                                $vt=0;
                                                $vj=0;
                                                $ve=0;
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
                                                $aaccion=$alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['accion'];
                                                $aid= $alumnos[$miembro->idmiembro]['asis'][$fecha->sesion]['idaccion'] ;
                                                $colorbtn="btn-default";
                                               
                                                $vacheckbox="";
                                                $vfcheckbox="";
                                                $vtcheckbox="";
                                                $vjcheckbox="";
                                                $vecheckbox="";

                                                switch ($aaccion) {
                                                    case 'A':
                                                        $colorbtn="btn-success";
                                                        $vacheckbox="checked";
                                                        $va++;
                                                        break;
                                                    case 'T':
                                                        $colorbtn="btn-warning";
                                                        $vtcheckbox="checked";
                                                        $vt++;
                                                        break;
                                                    case 'F':
                                                        $colorbtn="btn-danger";
                                                        $vfcheckbox="checked";
                                                        $vf++;
                                                        break;
                                                    case 'J':
                                                        $colorbtn="btn-info";
                                                        $vjcheckbox="checked";
                                                        $vj++;
                                                        break;
                                                    case 'E':
                                                        $colorbtn="btn-default";
                                                        $vecheckbox="checked";
                                                        $ve++;
                                                        break;
                                                }
                                                echo "<td class='cell' >
                                                    <a data-sesion='".$fecha->sesion."' data-edit='0' data-idacu='".$aid."' data-fecha='".$fecha->fecha."' data-miembro='".$aidmiembro."' class='txtnota btn btn-flat btn-block ".$colorbtn."' href='#'>".$aaccion."</a>
                                                    </td>";
                                                echo "<td class='bg-green disabled p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vacheckbox." value='A' type='radio' name='radio".$aid."' class='radiobox acheckbox' id='acheckbox".$aid."' />
                                                            <label for='acheckbox".$aid."'></label>
                                                        </div>
                                                      </td>";
                                                echo "<td class='bg-red disabled p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vfcheckbox." value='F' type='radio' name='radio".$aid."' class='radiobox fcheckbox' id='fcheckbox".$aid."' />
                                                            <label for='fcheckbox".$aid."'></label>
                                                        </div>
                                                      </td>";

                                                echo "<td class='bg-yellow disabled p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vtcheckbox." value='T' type='radio' name='radio".$aid."' class='radiobox tcheckbox' id='tcheckbox".$aid."' />
                                                            <label for='tcheckbox".$aid."'></label>
                                                        </div>
                                                    </td>";
                                                echo "<td class='bg-info disabled p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vjcheckbox." value='J' type='radio' name='radio".$aid."' class='radiobox jcheckbox' id='jcheckbox".$aid."' />
                                                            <label for='jcheckbox".$aid."'></label>
                                                        </div>
                                                    </td>";
                                                echo "<td class='p-1'>
                                                        <div class='checkround'>
                                                            <input ".$vecheckbox." value='E' type='radio' name='radio".$aid."' class='radiobox echeckbox' id='echeckbox".$aid."' />
                                                            <label for='echeckbox".$aid."'></label>
                                                        </div>
                                                    </td>";
                                            }
                                            
                                
                                echo '</tr>';
                                }
                        } ?>
                        <tr role="row">
                                <td class="cell" role="cell"></td>
                                <td class="cell" role="cell"></td>
                                <td class="cell" role="cell"></td>
                                <td id="conteova" class="cell text-center" role="cell"><?php echo $va ?></td>
                                <td id="conteovf" class="cell text-center" role="cell"><?php echo $vf ?></td>
                                <td id="conteovt" class="cell text-center" role="cell"><?php echo $vt ?></td>
                                <td id="conteovj" class="cell text-center" role="cell"><?php echo $vj ?></td>
                                <td id="conteove" class="cell text-center" role="cell"><?php echo $ve ?></td>
                                
                            </tr>
                    </tbody>
                </table>
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
    var pJustifica= '<?php echo $pJustifica ?>';
    $("table tr td:nth-child(3), table tr th:nth-child(3)").hide();

    function conteo(valor,num){

        if (valor == "A") {
            $("#conteova").html(parseInt($("#conteova").html()) + num);
        } else if (valor == "T") {
            $("#conteovt").html(parseInt($("#conteovt").html()) + num);
        } else if (valor == "F") {
            $("#conteovf").html(parseInt($("#conteovf").html()) + num);
        } else if (valor == "J") {
            $("#conteovj").html(parseInt($("#conteovj").html()) + num);
        } else if (valor == "E") {
            $("#conteove").html(parseInt($("#conteove").html()) + num);

        }
    }

    $(".radiocolbox").change(function(event) {
        var valor=$(this).val();
        $(".txtnota").html(valor);
        $("#conteova").html(0);
        $("#conteovt").html(0);
        $("#conteovf").html(0);
        $("#conteovj").html(0);
        $("#conteove").html(0);
        var nrow=$('#tbasistencia tr').length - 2;
        
        if (valor == "A") {
            $("#conteova").html(nrow);
            $(".acheckbox").prop("checked", true);
        } else if (valor == "T") {
            $(".tcheckbox").prop("checked", true);
            $("#conteovt").html(nrow);
        } else if (valor == "F") {
            $(".fcheckbox").prop("checked", true);
            $("#conteovf").html(nrow);
        } else if (valor == "J") {
            if (pJustifica=="SI"){
                $(".jcheckbox").prop("checked", true);
               
                $("#conteovj").html(nrow);
            }
            else{
                 $(this).prop("checked", true);
            }
        } else if (valor == "E") {
           $(".echeckbox").prop("checked", true);
           $("#conteove").html(nrow);
        }
        $(".txtnota").data('edit', '1')

       

    });
    $(".radiobox").change(function(event) {
        var error=false;
        var cuadro=$(this).parent().parent().parent().find('a');
        var accionNueva=$(this).val();
        var accionAnterior=cuadro.html();
        if (pJustifica=="NO"){
            var name= $(this).prop('name');    
            if(accionAnterior=="J"){
                var grupo=$('input[type=radio][name=' + name + '][value=J]');
                grupo.prop("checked",true);
                error=true;
            }
            else if (accionNueva=="J"){
                if ($.trim(accionAnterior)==""){
                    $(this).prop("checked",false);
                    error=true;
                }
                else{
                    var grupo=$('input[type=radio][name=' + name + '][value=' + accionAnterior + ']');
                    grupo.prop("checked",true);
                    error=true;

                }
            }
        }
        
        if (error==true){
             Swal.fire({
                icon: 'warning',
                title: 'NO PERMITIDO',
                text: "Solo el área de BIENESTAR puede Justificar y realizar una modificación de justificaciones",
            });
        }
        else{
            conteo(cuadro.html(),-1);
            cuadro.html($(this).val());
            conteo(cuadro.html(),1);
            var accion = $.trim(cuadro.html());
            cuadro.data('edit', '1')
            $(this).html(accion);
        }
        

    });

    $('#btnguardareg').click(function(event) {
        $('#divboxevaluaciones').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        arrdata = [];
         var edits=0;
        $('#tbasistencia td a').each(function() {
            // <a data-sesion='".$fecha->sesion."' data-edit='$esedit' data-idacu='".$aid."' data-fecha='".$fecha->fecha."' data-miembro='".$aidmiembro."' class='txtnota btn btn-flat btn-block ".$colorbtn."' href='#'>".$aaccion."</a>
                                                   
            var isedit = $(this).data("edit");
            var idacu = $(this).data("idacu");
            var fcha = $(this).data("fecha");
            var accn = $(this).html();
            var idmiembro = $(this).data("miembro");
            var idses = $(this).data("sesion");
            //dataString = {fecha: fcha, accion: accn ,idmiembro: idacu};
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
                   Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios ',
                        text: "Lo cambios NO fueron guardados correctamente",
                        backdrop:false,
                    });
                     $('#divboxevaluaciones #divoverlay').remove();
                } else {
                    //location.reload();
                    $('#divboxevaluaciones #divoverlay').remove();
                     $('.txtnota').each(function() {
                            //alert($(this).data('edit'));
                            //alert($(this).data('idaccion'));
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

                }
               
            },
            error: function(jqXHR, exception) {
                var msgf = errorAjax(jqXHR, exception,'text');
                Swal.fire({
                        type: 'error',
                        title: 'ERROR, NO se guardó cambios ',
                        text: msgf,
                        backdrop:false,
                    });
                    $('#divboxevaluaciones #divoverlay').remove();
            },
        });}
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




</script>