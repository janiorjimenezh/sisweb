
    <?php
    $procesando="no";
    $pendiente="no";
    $dominio=str_replace(".", "_",getDominio());
    foreach ($miscursos as $curso) {
      $estado="Completo";
      $vdeturl=base_url() . 'alumno/historial/curso/' . base64url_encode($curso->codcarga_plataforma) .'/'.base64url_encode($curso->codsubseccion_plataforma).'/detalle/' . base64url_encode($curso->codmiembro_plataforma) . '/' . base64url_encode($curso->codmatricula_migrada) .'/' . base64url_encode($carnet) . '/' .base64url_encode($alumno);

      $textcolor = ($curso->culminado=="SI") ? "text-success" : "text-danger";
      $textcolornota="";
      /*$nl=$curso->nota;
      $nr="-";//$curso->recuperacion;*/
      // $nf=$curso->final;
      $funcionhelp="getNotas_alumnoboleta_$dominio";

      $nota=$curso->notafin_plataforma;
      $nota_recuperacion=$curso->notarecuperacion_plataforma;
      if ($curso->origentipo_migrada=="MANUAL"){
        $nota=$curso->notafin_migrada;
        $nota_recuperacion=$curso->notarecuperacion_migrada;
      }
      $nf = $funcionhelp($curso->metodocalculo_migrada,array('promedio' => $nota, 'recupera'=>$nota_recuperacion));

      $dpi=$curso->estado_migrada;
      if ($dpi=='DPI') $nf="DPI";

      if (($curso->culminado=="NO") && ($curso->origentipo_migrada=="PLATAFORMA") ){
        $nf="Pendiente";
        $estado="Abierto";
        $pendiente="si";
      }

      if (($ndeudas>0) && ($bloqueoeva == true)) {
        $nf="Procesando";
        $textcolornota=$textcolor;
        $procesando="si";
        $pendiente="no";
      }
      
      if (($ndeudas>0) && ($sede->conf_autobloqueo_xdeuda=="SI")){
        $nf="Procesando";
        $textcolornota=$textcolor;
        $procesando="si";
        $pendiente="no";
      } 
      $as=0;
      $td=0;
      $ft=0;
      $jt=0;
      
      foreach ($miscursosesta as $key => $est) {
        if (($curso->codcarga_plataforma==$est->idcarga) && ($curso->codmiembro_plataforma==$est->idmiembro)){
          $as=$est->asiste;
          $td=$est->tarde;
          $ft=$est->falta;
          $jt=$est->justif;
          unset($miscursosesta[$key]);
        }
      }
      //PROCESANDO==El docente ya CULMINO el curso pero el estudiante tiene deudas
      //PENDIENTE== El docnete aun NO CULMINA  el curso
      //COMPLETO =El docente ya CULMINOP e curso
      echo 
      "<div class='row rowcolor cfila'>
        <div class='col-6 col-md-7'>
          <div class='row'>
            <div class='col-2 col-md-1 td'>{$curso->codcarga_plataforma}G{$curso->codsubseccion_plataforma}</div>
            <div class='col-10 col-md-6 td'>
              {$curso->unidad_migrada}({$curso->codunidad_migrada}) (<a class='text-primary' title='Ver detalles' href='$vdeturl'>
              <i class='fa fa-arrow-circle-right'></i> Detalles</a>)
            </div>
            <div class='col-12 col-md-5 td'>$curso->doc_paterno_migrada $curso->doc_materno_migrada $curso->doc_nombres_migrada</div>
          </div>
        </div>
        
        
        <div class='col-6 col-md-5'>
          <div class='row'>
            <div class='col-5 col-md-2 text-center td'><span class='d-md-none'>Estado:<br></span><span class='$textcolor'>{$estado}</span></div>
            <div class='col-5 col-md-2 text-center td'><span class='d-md-none'>Nota:<br></span><span class='$textcolornota'>{$nf}</span></div>
            <div class='col-2 col-md-2 text-center td'><span class='d-md-none'>Ses<br></span>{$curso->nrosesiones_plataforma}</div>

            <div class='col-3 col-md-2 text-right td bg-success'><span class='d-md-none'>As<br></span>{$as}</div>
            <div class='col-3 col-md-2 text-right td bg-danger'><span class='d-md-none'>Ft<br></span>{$ft}</div>
            <div class='col-3 col-md-1 text-right td bg-warning'><span class='d-md-none'>Td<br></span>{$td}</div>
            <div class='col-3 col-md-1 text-right td bg-info'><span class='d-md-none'>Jt<br></span>{$jt}</div>

          </div>
        </div>
      
      </div>";
     
      }

      if ($procesando=="si"){
        echo 
      "<div class='row rowcolor mt-3 px-2'>
        <div class='col-12'>
          <br>
          <h5> $sede->conf_autobloqueo_xdeuda_msj</h5>
        </div>
      </div>";
      }
      else if ($pendiente=="si"){
        echo 
      "<div class='row rowcolor mt-3 px-2'>
        <div class='col-12'>
          <br>
          <h5> Si tienes UD en estado <b>Pendiente</b> significa que tu docente aún no cierra la Unidad, contacta con tu docente</h5>
        </div>
      </div>";
      }
      else{
        if (isset($cmat64)){
          echo 
          "<div class='row rowcolor mt-3'>
            <div class='col-12 text-right'>
              <br>
              <a target='_blank' href='".base_url()."alumno/historial/notas/imprimir?cmt={$cmat64}' class='btn btn-primary'>Descargar boleta</a>
              <br>
              <br>
            </div>
          </div>";
        }
      }
      
     
    ?>

  
