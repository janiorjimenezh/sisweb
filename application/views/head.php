<!DOCTYPE html>
<html lang="es">
<head>
  <?php 
  

   ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $page_title ?></title>
  <?php $vbaseurl=base_url() 

  ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo $vbaseurl.'resources/img/favicon.'.getDominio().'.png'?>" />
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.css"/>

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/adminlte.css">
  <link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/dist/css/private-v5.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
  <!-- <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css" rel="stylesheet"> -->
  <!-- Google Font: Source Sans Pro -->
 

  <script src="<?php echo $vbaseurl ?>resources/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo $vbaseurl ?>resources/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo $vbaseurl ?>resources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/b-2.1.1/sl-1.3.4/datatables.min.js"></script>





  <script>
      var base_url = '<?php echo $vbaseurl; ?>';
      var getUrlParameter = function getUrlParameter(sParam,sDefault) {
          var params = new window.URLSearchParams(window.location.search);
          var param =params.get(sParam);
          return (param===null) ? sDefault : param;
      };

      function errorAjax(jqXHR, exception,msgtype) {
          var msg = '';
          if (jqXHR.status === 0) {
              msg = 'Conexión perdida.\n Verifica tu red y conexión al Servidor.';
          } else if (jqXHR.status == 404) {
              msg = 'Página no encontrada. [404]';
          } else if (jqXHR.status == 500) {
              msg = 'Internal Server Error [500].';
          } else if (exception === 'parsererror') {
              msg = 'Requested JSON parse failed1.';
          } else if (exception === 'timeout') {
              msg = 'Time out error.';
          } else if (exception === 'abort') {
              msg = 'Ajax request aborted.';
          } else {
              msg = 'Uncaught Error.\n' + jqXHR.responseText;
          }
          if (msgtype=='div'){
            return '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>' + msg + '</div>';
          }
          else
          {
            return msg;
          }
          
          
      }

      
      function tr (str, from, to) {
        var out = "", i, m, p ;
        for (i = 0, m = str.length; i < m; i++) {
        p = from.indexOf(str.charAt(i));
        if (p >= 0) {
        out = out + to.charAt(p);
        }
        else {
        out += str.charAt(i);
        }
        }
        return out;
      }

      function base64url_encode(input) {
        //var v64=btoa(input);
        return tr(btoa(input), '+/=', '._-');
      }

      function base64url_decode(input) {
       return atob(tr(input, '._-', '+/='));
      }
      $(document).ready(function() {
        getTotalNotifica();
      });

      function copyToClipboard(elemento) {
        var $temp = $("<input>")
        $("body").append($temp);
        $temp.val($(elemento).text()).select();
        document.execCommand("copy");
        $temp.remove();
      }

      function isValidDate(fecha) {
        if ($.trim(fecha)=="") return false;
        var fechaf = fecha.split("/");
        var day = fechaf[0];
        var month = fechaf[1];
        var year = fechaf[2];
        var date = new Date(year,month,'0');
        if((day-0)>(date.getDate()-0)){
              return false;
        }
        return true;
      }
      function isFechaMenorActual(date){
        
        var fecha = new Date(date);
        var today = new Date();
        today.setHours(0,0,0,0); 
        //Si devuelve true significa que la fecha es hoy o anterior, y si devuelve false significa que la fehca introducida es posterior a la actual.
        if (fecha > today){
          return false;
        }
        else{
          return true
        }
        
      }
      function laFechaEs(date){
        
        var fecha = new Date(date);  
        fecha.setHours(0,0,0,0); 
        //const fechaUTC = fecha.toLocaleString("es-MX", {timeZone: "America/Lima"});
        const fechaUTC = fecha;

        var today = new Date();
        today.setHours(0,0,0,0); 
        //const todayUTC = today.toLocaleString("es-MX", {timeZone: "America/Lima"});
        const todayUTC = today;
        //Devuelve 0 si es hoy, 1 si es mayor y -1 si es menor
       
        if (fechaUTC == todayUTC){
          return 0;
        }
        else if (fechaUTC > todayUTC){
          return 1;
        }
        else{
          console.log(fechaUTC +"||" + todayUTC);
          return -1;

        }
        
      }
      function formatDDMMYY(fecha,separador="/"){
        var d = new Date(fecha+"T00:00:00");

        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + separador + month + separador + year;

        return date;
      }

      function getCargando(mensaje=""){
        if (mensaje!="") mensaje="<br>" + mensaje;
        return  "<img height='100px' src='" + base_url + "resources/img/loader_rojo.gif' alt='Cargando'>" +mensaje;
      }
  </script>
</head>
<section id="s-cargando" class="content">
    <div  class="card">
      <div class="card-body p-5 text-center">
        <?php echo "<img height='100px' src='{$vbaseurl}resources/img/loader_rojo.gif' alt='Cargando'>"?>
        <br>
        Cargando...
      </div>
    </div>
</section>