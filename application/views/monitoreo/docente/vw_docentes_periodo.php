<?php
if (count($docentes)>0){
?>
<div class="row mb-2">
  <div class="col-12">
    <a href="<?php echo base_url().'monitoreo/docentes/cargas/excel/'.$periodo ?>" class="btn-excel btn btn-sm btn-outline-secondary float-right" target="_blank">
      <img src="<?php echo base_url().'resources/img/icons/p_excel.png' ?>" class="float-left" alt=""> 
      Exportar
    </a>
  </div>
</div>

<div id="divcursos" class="col-12 col-md-12 btable">
  <div class="col-md-12 thead ">
    <div class="row"  role="rowgroup" >
      <div class="col-4 col-sm-3 col-md-2">
        <div class="row">
          <div class="col-4 col-md-4 td">
            N°
          </div>
          <div class="col-8 col-md-8 td">
            COD
          </div>
        </div>
      </div>
      <div class="col-8 col-sm-4 col-md-4 td">
        DOCENTE
      </div>
      
      <div class="col-md-3 td d-none d-md-block">
        UNIDADES DIDÁC.
      </div>
    </div>
  </div>
  <div class="col-md-12 tbody">
    <?php
    $nro=0;
    foreach ($docentes as $docente) {
    $fn="";
    $nro++;
    $nombres=$docente->paterno.' '.$docente->materno.' '.$docente->nombres;
    $nombre64 = base64url_encode($nombres);
    ?>
    
    <div class="row <?php echo ($nro % 2==0) ? 'bg-lightgray':'' ?>" role="row" data-idcarga='<?php echo $codcurso64 ?>'>
      <div class="col-4 col-sm-3 col-md-2">
        <div class="row">
          <div class="col-4 col-md-4 td text-center">
          <?php echo str_pad($nro, 2, "0", STR_PAD_LEFT)  ?>
          </div>
          <div class="col-8 col-md-8 td">
            <b><?php echo $docente->coddocente ?></b>
          </div>
        </div>
      </div>
      <div class="col-8 col-sm-9 col-md-4 td">
        <?php 
        echo  "$docente->paterno $docente->materno $docente->nombres <br>
        <span>$docente->ecorporativo</span>";
        ?>
      </div>
      <div class="col-6 col-sm-6 col-md-1 td">
        <span class="d-block-inline d-md-none">Unid. Didác.: </span> 
        <span class="bg-success text-white tboton">
            <?php echo str_pad($docente->cactivos, 2, "0", STR_PAD_LEFT) ?> 
          </span>
          <span class="bg-danger text-white tboton">
            <?php echo str_pad($docente->ctotal - $docente->cactivos, 2, "0", STR_PAD_LEFT) ?> 
          </span>
      </div>
      <div class="col-6 col-sm-6 col-md-2 td">
          <a href="<?php echo base_url().'monitoreo/docente/'.base64url_encode($docente->coddocente).'/'.base64url_encode($periodo).'/cursos' ?>" class="btn btn-xs btn-outline-info" title="Ver detalles" href="#"><i class="fa fa-eye mr-1"></i> Unidades Didác.</a>
         
      </div>
      <div class="col-6 col-sm-6 col-md-2 td">
        <?php 
          echo "<a href='".base_url().'monitoreo/docente/'.base64url_encode($docente->coddocente).'/'.base64url_encode($periodo)."/cursos/estadistica' class='btn btn-xs btn-outline-danger' title='Descagar Informe' href='#'>
            <img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'> Estadísticas
            </a>";
           ?>
      </div>
      <div class="col-6 col-sm-6 col-md-1 td">
        <?php if (getPermitido("219") == "SI") { ?>
        <a href="<?php echo base_url().'monitoreo/docente/reporte/desaprobados/'.base64url_encode($docente->coddocente).'/'.base64url_encode($periodo) ?>" class="btn_desaprobados_rpexcel btn btn-xs btn-outline-success" target="_blank">
          <img src="<?php echo base_url().'resources/img/icons/p_excel.png' ?>" alt=""> Desaprobados.
        </a>
        <?php } ?>
      </div>
    </div>
    
    <?php } ?>
  </div>
  
</div>
<?php
}
else{
echo "<h4>SIN RESULTADOS</h4>";
}
?>