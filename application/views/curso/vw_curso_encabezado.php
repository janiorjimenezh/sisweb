<section class="content-header pb-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="text-bold"><?php echo $curso->unidad ?>
                <small> <?php echo $curso->codseccion.$curso->division; ?></small></h1>
            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <?php if (isset($supervisa)){ ?>
                    <li class="breadcrumb-item"><a href="<?php echo $vbaseurl.'monitoreo/docente/'.base64url_encode($curso->coddocente_principal).'/'.base64url_encode($curso->codperiodo).'/cursos'; ?>"><i class="fas fa-compass"></i></i> Volver al Panel</a></li>
                    <?php }
                    else{ ?>
                    <li class="breadcrumb-item"><a href="<?php echo $vbaseurl.'curso/panel/'.base64url_encode($curso->codcarga).'/'.base64url_encode($curso->division); ?>"><i class="fas fa-compass"></i></i> Volver al Panel</a></li>
                    <?php } ?>
                </ol>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-body p-3">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <div class="row">
                                <span class="col-5 col-md-5">Periodo:</span>
                                <span id="divperiodo" class="col-7"><b><?php echo $curso->periodo; ?></b></span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-8">
                            <div class="row">
                                <span class="col-4 col-md-3">Programa:</span>
                                <span id="divcarrera" class="col-8 col-md-9"><b><?php echo $curso->carrera; ?></b></span>
                            </div>
                        </div>
                        <!-- fila ---->
                        <div class="col-sm-6 col-md-4">
                            <div class="row">
                                <span class="col-5 col-md-5">Semestre:</span>
                                <span id="divciclo" class="col-7"><b><?php echo $curso->ciclo; ?></b></span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="row">
                                <span class="col-4 col-md-6">Turno:</span>
                                <span id="divturno" class="col-8 col-md-6"><b><?php echo $curso->turno; ?></b></span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="row">
                                <span class="col-4 col-md-4">Sección:</span>
                                <span id="divseccion" class="col-8"><b><?php echo $curso->codseccion.$curso->division; ?></b></span>
                            </div>
                        </div>
                        <!-- fila ---->
                        <div class="col-sm-12 col-md-10">
                            <div class="row">
                                <span class="col-4 col-sm-2">Docente:</span>
                                <span id="divdocente" class="col-8 col-sm-10"><b><?php echo "$curso->paterno $curso->materno $curso->nombres"; ?></b></span>
                            </div>
                        </div>
                        <div class="col-sm-10 col-md-10">
                            <div class="row">
                                <span class="col-4 col-sm-2">Correo:</span>
                                <span id="divdocente" class="col-8 col-sm-10"><b><?php echo "$curso->ecorporativo"; ?></b></span>
                            </div>
                        </div>
                        <div class="col-sm-10 col-md-10">
                            <div class="row">
                                <span class="col-4 col-sm-2">Cálculo:</span>
                                <span id="divdocente" class="col-8 col-sm-10"><b><?php echo "$curso->metodo"; ?></b></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $editarUnidEval[0]=false;
                    $editarUnidEval[1]=false;
                    $editarUnidEval[2]=false;
                    $editarUnidEval[3]=false; 
                    if ($mostrarfechaCierres==true): ?>
                <div class="col-12 col-md-4">
                    <div class="row">
                        <?php 
                            $fechaCierreUD="Sin Fecha";
                            $colorTextCierreUD="";
                            //$editarUnidEval[0]=false;
                            $fechaCierreU1="Sin Fecha";
                            $colorTextCierreU1="";
                            //$editarUnidEval[1]=false;
                            $fechaCierreU2="Sin Fecha";
                            $colorTextCierreU2="";
                            //$editarUnidEval[2]=false;
                            $fechaCierreU3="Sin Fecha";
                            $colorTextCierreU3="";
                            //$editarUnidEval[3]=false;
                            if (isset($calendario->codcalendario)){
                                $fechaActual = date('Y-m-d');
                                $fechaCierreUD=$calendario->cierre_ud;
                                if ($fechaActual>$fechaCierreUD) {
                                    $colorTextCierreUD="text-danger";
                                    $editarUnidEval[0]=true;
                                }
                                $fechaCierreU1=$calendario->cerrar_i1;
                                if ($fechaActual>$fechaCierreU1) {
                                    $colorTextCierreU1="text-danger";
                                    $editarUnidEval[1]=true;
                                }
                                $fechaCierreU2=$calendario->cerrar_i2;
                                if ($fechaActual>$fechaCierreU2) {
                                    $colorTextCierreU2="text-danger";
                                    $editarUnidEval[2]=true;
                                }
                                $fechaCierreU3=$calendario->cerrar_i3;
                                if ($fechaActual>$fechaCierreU3) {
                                    $colorTextCierreU3="text-danger";
                                    $editarUnidEval[3]=true;
                                }
                            }
                            echo 
                            "<div class='border rounded col-12 bg-gray text-bold'>Cierre Automático</div>";
                            if ($config->conf_cierre_automatico_indicador=='SI'){
                                echo "
                                <div class='col-6 col-sm-6 $colorTextCierreU1'>Unidad Eval. 01:</div>
                                <div id='vw_ce_divCierreU1' class='col-6 col-sm-6 $colorTextCierreU1'>".date("d-m-Y", strtotime($fechaCierreU1))."</div>
                                <div class='col-6 col-sm-6 $colorTextCierreU2'>Unidad Eval. 02:</div>
                                <div id='vw_ce_divCierreU2' class='col-6 coñl-sm-6 $colorTextCierreU2'>".date("d-m-Y", strtotime($fechaCierreU2))."</div>
                                <div class='col-6 col-sm-6 $colorTextCierreU3'>Unidad Eval. 03:</div>
                                <div id='vw_ce_divCierreU3' class='col-6 col-sm-6 $colorTextCierreU3'>".date("d-m-Y", strtotime($fechaCierreU3))."</div>";
                            }
                            echo "<div class='col-6 col-sm-6 border-top text-bold $colorTextCierreUD'>Unidad Didáctica:</div>
                            <div id='vw_ce_divCierreUD' class='col-6 col-sm-6 border-top text-bold $colorTextCierreUD'>".date("d-m-Y", strtotime($fechaCierreUD))."</div>";
                        ?>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    
</section>