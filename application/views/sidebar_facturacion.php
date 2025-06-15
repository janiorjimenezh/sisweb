<!-- Main Sidebar Container -->
<?php
$vuser=$_SESSION['userActivo'];
$vbaseurl=base_url();
if (!isset($menu_padre)) $menu_padre="";
if (!isset($menu_hijo))  $menu_hijo="";
if (!isset($menu_nieto))  $menu_nieto="";
?>
<aside class="main-sidebar elevation-4 sidebar-dark-olive">
  <!-- Brand Logo -->
  <a href="<?php echo $vbaseurl ?>" class="brand-link navbar-info">
    <img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png' ?>"
    alt="ERP"
    class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light"><b>ERP</b></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo $vbaseurl ?>resources/fotos/<?php echo $vuser->foto ?>" class="img-circle elevation-2" alt="User">
      </div>
      <div class="info">
        <?php $nombres=explode(" ",$vuser->nombres);  ?>
        <small>
          <a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $nombres[0]." ".$vuser->paterno;  ?><br><?php echo $vuser->usuario ?></a>
        </small>
      </div>
    </div>

    <nav class="mt-2">      
      <ul class="nav nav-pills nav-sidebar flex-column border-bottom text-sm" data-widget="treeview" role="menu" data-accordion="false">
        
        <?php 
        if (((getPermitido("97") == "SI")) && (($_SESSION['userActivo']->tipo == 'DA') || ($_SESSION['userActivo']->tipo == 'AD'))) {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/documentos-de-pago?sb=facturacion" class="nav-link <?php echo ($menu_padre=='mn_facturaerp') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p>
              Documentos de Pago
              
            </p>
          </a>
        </li>
        <?php } ?>

        <?php 
        if (getPermitido("194") == "SI") {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/pagante" class="nav-link <?php echo ($menu_padre=='mn_pagante') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Clientes
            </p>
          </a>
        </li>
        <?php } ?>
        <?php 
        if (getPermitido("243") == "SI") {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/tarifario" class="nav-link <?php echo ($menu_padre=='mn_tarifario') ? 'active' : '' ?>">
            <!-- <i class="nav-icon fas fa-hand-holding-usd"></i> -->
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p>
              Tarifario
            </p>
          </a>
        </li>
        <?php } ?>

      </ul>

      <ul class="nav nav-pills nav-sidebar flex-column border-bottom text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <!--DEUDAS-->
        <?php if (getPermitido("105")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/deudas" class="nav-link <?php echo ($menu_padre=='mn_deudas') ? 'active' : '' ?>">
            <i class="fas fa-search-dollar nav-icon"></i>
            <p>Deudas</p>
          </a>
        </li>
        <?php } ?>

        <!--CRONOGRAMAS-->
        <?php if (getPermitido("106")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/cronogramas?sb=facturacion" class="nav-link <?php echo ($menu_padre=='mnts_cronogramas') ? 'active' : '' ?>">
            <i class="far fa-calendar-alt nav-icon"></i>
            <p>Cronogramas</p>
          </a>
        </li>
        
        <?php } ?>
        <?php 
        if (getPermitido("126") == "SI") {?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/matriculas/bloqueos" class="nav-link <?php echo ($menu_padre=='mn_ts_matriculas') ? 'active' : '' ?>">
            <i class="fas fa-user-alt-slash nav-icon"></i>
            <p>Bloqueos</p>
          </a>
        </li>
        <?php } ?>
      </ul>
      <ul class="nav nav-pills nav-sidebar flex-column border-bottom text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <?php if (getPermitido("48") == "SI") { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/academico/matriculas?sb=facturacion&ts=grp" class="nav-link <?php echo ($menu_nieto=='grupos') ? 'active' : '' ?>">
            <i class="fas fa-user-friends nav-icon"></i>
            <p>Grupos</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>gestion/academico/matriculas?sb=facturacion" class="nav-link <?php echo ($menu_nieto=='alumnos') ? 'active' : '' ?>">
            <i class="fas fa-user-graduate nav-icon"></i>
            <p>Matrículas</p>
          </a>
        </li>
        <?php } ?>
        <?php
        if (getPermitido("34") == "SI") { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>admision/inscripciones?sb=facturacion" class="nav-link <?php echo ($menu_padre=='admision') ? 'active' : '' ?>">
            <i class="fas fa-user-check nav-icon"></i>
            <p>Inscripciones</p>
          </a>
        </li>
        <?php } ?>
      </ul>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php 
        if (getPermitido("191")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/sede" class="nav-link <?php echo ($menu_padre=='docsede') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-list-ol"></i>
            <p>
              Series
            </p>
          </a>
        </li>
        <?php } 
        if (getPermitido("192")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/gestion" class="nav-link <?php echo ($menu_padre=='gestion') ? 'active' : '' ?>">
            <i class="fas fa-chalkboard nav-icon"></i>
            <p>
              Conceptos
            </p>
          </a>
        </li>
        <?php } ?>
      </ul>

      <ul class="nav nav-pills nav-sidebar flex-column border-bottom text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <?php
        if (getPermitido("190")=='SI') { ?>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>tesoreria/facturacion/reportes/sede" class="nav-link <?php echo ($menu_padre=='mn_ts_reportes') ? 'active' : '' ?>">
            <i class="fas fa-chart-bar nav-icon"></i>
            <p>
              Reportes
            </p>
          </a>
        </li>
        <?php } ?>

      </ul>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>ayuda/tutoriales" class="nav-link <?php echo ($menu_padre=='docvideoayuda') ? 'active' : '' ?>">
            <i class="nav-icon far fa-question-circle"></i>
            <p>
              Ayuda
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>


