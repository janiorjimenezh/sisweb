<?php
    $vbaseurl=base_url();
$vpcodigo=(isset($pagina->codigo))?$pagina->codigo:"0";
$vptitulo=(isset($pagina->titulo))?$pagina->titulo:"";
$vpdescripcion=(isset($pagina->descripcion))?$pagina->descripcion:"";
$vpcontenido=(isset($pagina->contenido))?$pagina->contenido:"";
$vpestado=(isset($pagina->estado))?$pagina->estado:"";
$vpurl=(isset($pagina->url))?$pagina->url:"";

?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.css">
<div class="content-wrapper">
    
    <section id="s-cargado" class="content pt-2">
        <div id="divcard_area" class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Editar <?php echo $pagina->titulo ?></h3>
                
            </div>
            <div class="card-body">
                <form >
                    <input type="hidden" name="txtcodigo" id="txtcodigo" value="<?php echo $vpcodigo ?>">
                    <div class="form-group">
                        <label for="txttitulo">Título</label>
                        <input type="text" class="form-control" id="txttitulo" name="txttitulo" placeholder="" value="<?php echo $vptitulo ?> ">
                    </div>
                    <div class="form-group">
                        <label for="txturl">URL</label>
                        <input type="text" class="form-control" id="txturl" name="txturl" placeholder="" value="<?php echo $vpurl ?> ">
                    </div>
                    <div class="form-group">
                        <label for="txtestado">Estado</label>
                        <input type="text" class="form-control" id="txtestado" name="txtestado" placeholder="" value="<?php echo $vpestado ?> ">
                    </div>
                    <div class="form-group">
                        <label for="txtdescripcion">Descripción</label>
                        <textarea class="form-control" id="txtdescripcion" name="txtdescripcion" placeholder=""><?php echo $vpdescripcion ?></textarea>
                        <small id="txtdescripcion" class="form-text text-muted">Descripción interna, esto NO APARECE en la página web.</small>
                    </div>
                    <div class="form-group">
                        <label for="txtcontenido">Contenido</label>
                        <textarea class="txt_summernote form-control" id="txtcontenido" name="txtcontenido" placeholder=""><?php echo $vpcontenido ?></textarea>
                    </div>
                </form>
                <?php if (count($secciones)>0): ?>
                <div class="col-12">
                    <ul class="nav nav-tabs">
                        <?php
                        foreach ($secciones as $keySec => $seccion) {
                        $esDefecto=($seccion->esdefecto=="SI")? "active": "";
                        echo "<li class='nav-item'>
                            <a class='nav-link  $esDefecto' data-toggle='tab' href='#tabpagina{$seccion->codigo}'>$seccion->titulo</a>
                        </li>";
                        }
                        ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        foreach ($secciones as $keySec => $seccion) {
                        $esDefecto=($seccion->esdefecto=="SI")? "show active": "";
                        echo "<div id='tabpagina{$seccion->codigo}' class='secciones p-1 tab-pane fade $esDefecto'>
                            
                            <input class='txtseccion_codigo' type='hidden' name='txtseccion_codigo{$seccion->codigo}' id='txtseccion_codigo{$seccion->codigo}' value='{$seccion->codigo}'>
                            <input class='txtseccion_orden' type='hidden' name='txtseccion_orden{$seccion->codigo}' id='txtseccion_orden{$seccion->codigo}' value='{$seccion->orden}'>
                            <input class='txtseccion_nombre' type='hidden' name='txtseccion_nombre{$seccion->codigo}' id='txtseccion_nombre{$seccion->codigo}' value='{$seccion->titulo}'>
                            <input class='txtseccion_defecto' type='hidden' name='txtseccion_defecto{$seccion->codigo}' id='txtseccion_defecto{$seccion->codigo}' value='{$seccion->esdefecto}'>
                            <textarea class='txt_summernote form-control' id='txtseccion_contenido{$seccion->codigo}' name='txtseccion_contenido{$seccion->codigo}'>$seccion->contenido</textarea>
                        </div>";
                        }
                        ?>

                        
                    </div>
                </div>
                <?php endif ?>
                <div class="col-12 text-right">
                    <button id="wc_btnGuardar" class="btn btn-primary">Guardar</button>
                </div>
                
            </div>
        </section>
    </div>
    <script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/summernote-bs4.min.js"></script>
    <script src="<?php echo $vbaseurl ?>resources/plugins/summernote8/lang/summernote-es-ES.js"></script>
    <script type="text/javascript">
    
    $(document).ready(function() {
        $.summernote.dom.emptyPara = "<div><br></div>";
        $('.txt_summernote').summernote({
            height: 300,
            minHeight: 200, // set minimum height of editor
            maxHeight: 800, // set maximum height of editor
            focus: true,
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36'],
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['list', ['ul', 'ol']],
                ['para', ['paragraph']],
                ['insert', ['link', 'picture', 'video']],
            ],
            dialogsFade: true,
            callbacks: {
                onImageUpload: function(image) {
                    var txtrt = $(this);
                    uploadImage(image[0], txtrt);
                },
                onMediaDelete: function(target) {
                    deleteFile(target[0].src);
                }
            }
        });

        function uploadImage(image,txtrt) {
            var data = new FormData();
            data.append("file", image);
            $.ajax({
                url: base_url + "noticias/uploadimages",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "post",
                success: function(url) {
                    var image = $('<img>').attr('src', base_url + url);
                    txtrt.summernote("insertNode", image[0]);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteFile(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "POST",
                url: base_url + "noticias/delete_file", // replace with your url
                cache: false,
                success: function(resp) {
                    console.log(resp);
                }
            });
        }
    });

    $("#wc_btnGuardar").click(function(event) {
        $('#divcard_area').append('<div id="divoverlay" class="overlay"><i class="fas fa-spinner fa-pulse fa-3x"></i></div>');
        arrdata = [];
        txtcodigo= $("#txtcodigo").val();
        txttitulo= $("#txttitulo").val();
        txtdescripcion= $("#txtdescripcion").val();
        txtcontenido= $("#txtcontenido").val();
        txturl= $("#txturl").val();
        txtestado= $("#txtestado").val();

        $('.secciones').each(function() {
            var secCodigo = $(this).children('.txtseccion_codigo').val();
            var secContenido = $(this).children('.txt_summernote').val();
            var secOrden = $(this).children('.txtseccion_orden').val();
            var secNombre = $(this).children('.txtseccion_nombre').val();
            var esDefecto = $(this).children('.txtseccion_defecto').val();
            var myvals = [secCodigo, secContenido,secOrden,secNombre,esDefecto];
            arrdata.push(myvals);
        });

        $.ajax({
                url: base_url + "paginas/fn_guardar",
                type: 'post',
                dataType: 'json',
                data: {
                    'txtcodigo': txtcodigo,
                    'txttitulo': txttitulo,
                    'txtdescripcion': txtdescripcion,
                    'txtcontenido': txtcontenido,
                    'txturl': txturl,
                    'txtestado': txtestado,
                    'secciones': JSON.stringify(arrdata),
                },
                success: function(e) {
                    $('#divcard_area #divoverlay').remove();
                    if (e.status == false) {
                        alert(e.msg);
                    } 
                    else {

                    }
                },
                error: function(data) {
                    $('#divcard_area #divoverlay').remove();
                    console.log(data);
                }
            });
    });
    </script>