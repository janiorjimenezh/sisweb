<!-- Main Sidebar Container -->
<?php
$vuser=$_SESSION['userActivo'];
$vbaseurl=base_url();
if (!isset($menu_padre)) $menu_padre="";
?>
<aside class="main-sidebar elevation-4 sidebar-dark-olive">
  <!-- Brand Logo -->
  <a href="<?php echo $vbaseurl ?>" class="brand-link navbar-info">
    <img src="<?php echo $vbaseurl.'resources/img/logo_h80.'.getDominio().'.png' ?>"
    alt="IESTWEB"
    class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light"><b>IESTWEB</b></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo $vbaseurl ?>resources/fotos/<?php echo $vuser->foto ?>" class="img-circle elevation-2" alt="User">
      </div>
      <div class="info">
        <?php $nombres=explode(" ",$vuser->nombres); ?>
        <small><a href="<?php echo $vbaseurl ?>cuentas/mi-perfil" class="d-block"><?php echo $nombres[0]." ".$vuser->paterno; ?><br><?php echo $vuser->usuario ?></a></small>
        <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>ayuda/tutoriales" class="nav-link <?php echo ($menu_padre=='alvideoayuda') ? 'active' : '' ?>">
            <i class="nav-icon far fa-question-circle"></i>
            <p>
              Ayuda
              <!--<span class="right badge badge-danger">New</span>-->
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>biblioteca/buscar-libros" class="nav-link <?php echo ($menu_padre=='biblioteca') ? 'active' : '' ?>">
            <i class="nav-icon fas fas fa-book-reader"></i>
            <p>
              Biblioteca
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>alumno/mis-cursos-panel" class="nav-link">
            
            <i class="nav-icon fas fa-book-open"></i>
            <p>
              Mis Unidades didác.
              <!--<span class="right badge badge-danger">New</span>-->
            </p>
          </a>
        </li>
  
        <li class="nav-item pl-2">
          <a href="<?php echo $vbaseurl.'alumno/curso/panel/'.base64url_encode($vcarga).'/'.base64url_encode($vdivision).'/'.base64url_encode($vmiembro); ?>" class="nav-link <?php echo ($menu_padre=='miscursospanel') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-caret-square-right"></i>
            <p>
              Panel
            </p>
          </a>
        </li>
        <li class="nav-item pl-2">
          <a href="<?php echo $vbaseurl.'alumno/curso/virtual/'.base64url_encode($vcarga).'/'.base64url_encode($vdivision).'/'.base64url_encode($vmiembro); ?>" class="nav-link <?php echo ($menu_padre=='alaulavirtual') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-cubes"></i>
            <p>
              Aula Virtual
            </p>
          </a>
        </li>


        <li class="nav-item pl-2">
          <a href="<?php echo $vbaseurl.'alumno/curso/sesiones/'.base64url_encode($vcarga).'/'.base64url_encode($vdivision).'/'.base64url_encode($vmiembro); ?>" class="nav-link <?php echo ($menu_padre=='missesiones') ? 'active' : '' ?>">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Sesiones
            </p>
          </a>
        </li>

        <li class="nav-item pl-2">
          <a href="<?php echo $vbaseurl.'alumno/curso/anuncios/'.base64url_encode($vcarga).'/'.base64url_encode($vdivision).'/'.base64url_encode($vmiembro); ?>" class="nav-link <?php echo ($menu_padre=='aluanuncios') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-bell"></i>
            <p>
              Anuncios
            </p>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a href="#" onclick="location.reload(true)" class="nav-link">
            <i class="nav-icon far fas fa-sync-alt"></i>
            <p>
              Hard refresh
            </p>
          </a>
        </li>-->
        <li class="nav-item">
          <a href="<?php echo $vbaseurl ?>contacto/sugerencia" class="nav-link <?php echo ($menu_padre=='sendsugerencia') ? 'active' : '' ?>">
            <i class="nav-icon far fa-paper-plane"></i>
            <p>
              Enviar Sugerencia
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>