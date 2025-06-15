<?php
	$vbaseurl=base_url();
?>
<link rel="stylesheet" href="<?php echo $vbaseurl ?>resources/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css">
<div class="content-wrapper">

    <div class="modal fade" id="modaddarea" tabindex="-1" role="dialog" aria-labelledby="modaddarea" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="divmodaladd">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlearea">AGREGAR ÁREA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm_addarea" action="<?php echo $vbaseurl ?>area/fn_insert_update" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="form-group has-float-label col-8">
                                <input type="hidden" id="fictxtaccion" name="fictxtaccion" value="INSERTAR">
                                <input type="hidden" id="fictxtcodigo" name="fictxtcodigo" value="">
                                <input type="text" name="fictxtnombre" id="fictxtnombre" value="" placeholder="Nombre Área" class="form-control">
                                <label for="fictxtnombre">Nombre Área</label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="checkestado">Activo:</label>
                                <input  id="checkestado" name="checkestado" class="checkestado" data-size="sm" type="checkbox" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group has-float-label col-12">
                                <select name="fictxtencarg" id="fictxtencarg" class="form-control">
                                    <option value="">Seleccione item</option>
                                    <?php
                                        foreach ($docentes as $key => $value) {
                                            echo "<option value='$value->coddocente'>$value->nombres</option>";
                                        }
                                    ?>
                                </select>
                                <label for="fictxtencarg">Encargado</label>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group has-float-label col-12">
                                <input type="text" name="fictxtemail" id="fictxtemail" value="" placeholder="Email" class="form-control">
                                <label for="fictxtemail">Email</label>
                            </div>
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="lbtn_guardar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

  
	<section id="s-cargado" class="content pt-2">
		<div id="divcard_area" class="card">
			<div class="card-header">
		    	<h3 class="card-title"><i class="fas fa-list-ul mr-1"></i> Lista de áreas</h3>
		    	<div class="no-padding card-tools">
                	<a type="button" class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#modaddarea"><i class="fa fa-plus"></i> Agregar</a>
              	</div>
		    </div>
		    <div class="card-body">
                <small id="fmt_conteo" class="form-text text-primary">
            
                </small>
                <div class="col-12 py-1">
                    <div class="btable">
                        <div class="thead col-12  d-none d-md-block">
                            <div class="row">
                                <div class='col-12 col-md-3'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'>CÓD.</div>
                                        <div class='col-10 col-md-10 td'>NOMBRE</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-7'>
                                    <div class='row'>
                                        <div class='col-3 col-md-3 td'>DESCRIPCIÓN</div>
                                        <div class='col-9 col-md-9 td'>URL</div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 text-center'>
                                    <div class='row'>
                                        <div class='col-12 col-md-12 td'>
                                            <span>ACCIONES</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tbody col-12" id="divcard_data_area">
                            <?php foreach ($paginas as $keyPag => $pagina): ?>
                                <div class="row">
                                <div class='col-12 col-md-3'>
                                    <div class='row'>
                                        <div class='col-2 col-md-2 td'><?php echo $pagina->codigo ?></div>
                                        <div class='col-10 col-md-10 td'><?php echo $pagina->titulo ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-7'>
                                    <div class='row'>
                                        <div class='col-3 col-md-3 td'><?php echo $pagina->descripcion ?></div>
                                        <div class='col-9 col-md-9 td'><?php echo $pagina->url ?></div>
                                    </div>
                                </div>
                                <div class='col-12 col-md-2 text-center'>
                                    <div class='row'>
                                        <div class='col-12 col-md-12 td'>
                                            <!-- <span><?php //echo $pagina->estado ?></span> -->
                                            <a href='<?php echo $vbaseurl."portal-web/paginas/{$pagina->codigo}" ?>'>Editar
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
		    </div>
		</div>
	</section>
</div>

