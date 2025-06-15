<?php
    $nro = (isset($inicio)?$inicio:0);
    $arrayestado = array('ACEPTADO','ANULADO','ANULANDO','ENVIADO','RECHAZADO','PENDIENTE','OBSERVADO','ERROR');
    //$nro =$inicio;
    foreach ($items as $docp) {
    $nro ++;
    $estado_color="text-warning";
    $btn_color="btn-warning";
    $icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
    $s_msj=$docp->s_descripcion;
    $text_strike="";
    $btnenlxml="";

    $ciclo = '';
    if ($docp->ciclo != "") {
        $ciclo = ' / '.$docp->ciclo ;
    }
    
    switch ($docp->estado) {
        case 'ACEPTADO':
            $icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
            $estado_color="text-success";
            $btn_color = "btn-success";
            $btnenlxml="<a target='_blank' class='dropdown-item' href='$docp->enl_xml' title='Descargar XML'>
                            <i class='far fa-file-code mr-1'></i> Descargar XML
                        </a>";
            break;
        case 'ANULADO':
            $s_msj="$docp->anul_fecha: $docp->anul_motivo";
            $icon_sunat="<i class='fas fa-times fa-lg mr-1'></i>";
            $estado_color="text-danger";
            $btn_color = "btn-danger";
            $text_strike="text-strike";
            break;
        case 'ENVIADO':
            $icon_sunat="<i class='fas fa-check-circle fa-lg mr-1'></i>";
            $estado_color="text-primary";
            $btn_color = "btn-primary";
            break;
        case 'RECHAZADO':
            $icon_sunat="<i class='fas fa-exclamation-circle fa-lg mr-1'></i>";
            $estado_color="text-danger";
            $btn_color = "btn-danger";
            break;
        case 'ERROR':
            $s_msj="$docp->error_cod - $docp->error_desc";
            $icon_sunat="<i class='fas fa-ban fa-lg mr-1'></i>";
            $estado_color="text-danger";
            $btn_color = "btn-danger";
            break;
    }

    $vbaseurl=base_url();
    //$datepubl =  new DateTime($docp->fecha_hora) ;
    $datemis =  new DateTime($docp->fecha_hora) ;
    //$datvence =  new DateTime($docp->fecha_hora) ;
    //$dias = array("Dom","Lun","Mar","Mie","Jue","Vie","Sáb");
    //$vpublica= $dias[$datepubl->format('w')].". ".$datepubl->format('d/m/Y h:i a');
    $emision = $datemis->format('d/m/Y h:i a');  
    //$fvence = $datvence->format('d/m/Y');          
    $codigo_enc=base64url_encode($docp->codigo);
    $btneditar = "";
    $btndelete = "";
    /*$vdescargar=($docp->ruta=="")?"":"<a target='_blank' href='{$vbaseurl}documentos/pagos/archivos/$codigo_enc' title='Descargar'>
                                            <img class='mr-1' src='".base_url()."resources/img/icons/p_pdf.png' alt='PDF'> PDF
                                  </a>";*/
    $btnprint="";
    $btnpdf="";
    $btnmail="";
    $btnanular="";
    $btnaddcobros = "";
    $btneliminar="";
    $btnsunat="";
    $btnconsultar="";
    $btnmatricula = "";
    $btnAutorizaVoucherAntiguo ="";
    $btnupdateclient = "";
    $btnupdatedoc = "";
    $dropdownstatus = "";

    if (getPermitido("239") == "SI") {
        $dropdownstatus = "<div class='btn-group p-0'>
                            <button class='btn $btn_color btn-sm text-sm dropdown-toggle py-0' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='estado$codigo_enc'>
                                <small>$docp->estado</small>
                            </button>
                            <div class='dropdown-menu'>";
                            foreach ($arrayestado as $key => $statbol) {
                                $status64 = base64url_encode($statbol);
                                $dropdownstatus = $dropdownstatus."<a href='#' onclick='fn_cambiarestadobol($(this))' class='dropdown-item' data-campo='tabla' data-estado='$status64'><small>$statbol</small></a>";
                            }
                                
                    $dropdownstatus =  $dropdownstatus."</div>
                        </div> 
                        <a class='vw_btn_msjsunat $estado_color' tabindex='0' role='button' data-toggle='popover' data-trigger='focus' title='$docp->estado' data-content='$s_msj'>$icon_sunat</a>";
    } else {
        $dropdownstatus = "<a class='vw_btn_msjsunat $estado_color' tabindex='0' role='button' data-toggle='popover' data-trigger='focus' title='$docp->estado' data-content='$s_msj'>$icon_sunat $docp->estado</a>";
    }
    
    if (getPermitido("97") == "SI") {

        
        $btnmail = "<a class='dropdown-item' href='#' title='Editar' data-toggle='modal' data-codigo='$codigo_enc' data-target='#modenviarmail'>
                        <i class='far fa-file-alt mr-1'></i> Enviar a email
                    </a>";
        $btnprint = "<a target='_blank' class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/generar/rpgrafica/$codigo_enc' title='Imprimir'>
                        <i class='far fa-file-alt mr-1'></i> Impresión
                    </a>";
        $btnpdf = "<a target='_blank' class='dropdown-item' href='{$vbaseurl}tesoreria/facturacion/generar/pdf/$codigo_enc' title='PDF'>
                       <i class='far fa-file-pdf mr-1'></i> PDF
                    </a>";
    }
    if (getPermitido("193") == "SI") {
        /*$btnpdf = "<a target='_blank' class='dropdown-item' href='$docp->enl_pdf' title='PDF'>
                       <i class='far fa-file-pdf mr-1'></i> PDF
                    </a>";    */
        $btnaddcobros = "<a data-codigo='$codigo_enc' class='dropdown-item text-success' href='#' title='Cobros' data-toggle='modal' data-target='#modaddcobros' data-pgmonto='$docp->total'>
                        <i class='far fa-credit-card mr-1'></i> Cobros
                    </a>";
        //$btndelete = "<a class='dropdown-item text-danger' href='#' data-codigo='$codigo_enc' onclick='vw_pw_tp_pr_fn_delete_doc($(this));event.preventDefault();' title='Eliminar'>
                        //<i class='far fa-file-pdf mr-1'></i> PDF
                    //</a>";
        
    }

    if (getPermitido("144") == "SI") {

        $btnmatricula = "<a data-codigo='$codigo_enc' id='btnasigmat_$codigo_enc' class='dropdown-item text-primary' href='#' title='Asignar matricula' data-toggle='modal' data-target='#modasgmatricula' data-pagante='$docp->codpagante'>
                        <i class='fas fa-graduation-cap mr-1'></i> Asignar matricula
                    </a>";
    }
    if (getPermitido("234") == "SI") {
        $autoriza="";
        if ($docp->autoriza_voucherantiguo=="SI"){
            $autoriza=base64url_encode("NO");
            $auvTexto="<i class='far fa-thumbs-up fa-flip-vertical mr-1'></i> Deshabilitar Voucher Antiguos";
        }
        else{
            $autoriza=base64url_encode("SI");
            $auvTexto="<i class='far fa-thumbs-up mr-1'></i> Habilitar Voucher Antiguos";
        }
        $btnAutorizaVoucherAntiguo = "<a onclick='fn_cambiarAutorizacionVouhersAntiguos($(this));return false;' data-codigo='$codigo_enc' data-autoriza='$autoriza' id='btnautorizava_$codigo_enc' class='dropdown-item text-primary' href='#' title='Asignar matricula'>
                        $auvTexto
                    </a>";
    }

    if ((getPermitido("102") == "SI") && ($docp->estado == "ACEPTADO")) {
        $btnanular = "<a data-codigo='$codigo_enc' class='dropdown-item text-danger' href='#' title='Anular' data-toggle='modal' data-target='#modanuladoc'>
                        <i class='far fa-file-alt mr-1'></i> Anular o Comunicar Baja
                    </a>";
    }

    if ((getPermitido("109") == "SI") && (($docp->estado == "PENDIENTE") || ($docp->estado == "ERROR") )) {
        
        $btneliminar = "<a data-codigo='$codigo_enc' class='dropdown-item text-danger' href='#' title='Eliminar' onclick='fn_eliminar_documento($(this));return false' >
                <i class='fas fa-trash mr-1'></i> Eliminar
            </a>";
    }
    if ((getPermitido("110") == "SI") && (($docp->estado == "PENDIENTE") || ($docp->estado == "ERROR"))) {

        $btnsunat = "<a data-codigo='$codigo_enc' class='dropdown-item text-primary' href='#' title='Enviar a SUNAT' onclick='fn_enviar_documento_ose($(this));return false' >
                <i class='far fa-paper-plane mr-1'></i> Enviar a SUNAT
            </a>";
    }
    if ((getPermitido("111") == "SI") && ($docp->estado == "ENVIADO")) {

        $btnconsultar = "<a data-codigo='$codigo_enc' class='dropdown-item text-info' href='#' title='Consultar a SUNAT' onclick='fn_consultar_documento_ose($(this));return false' >
                <i class='fas fa-binoculars mr-1'></i> Consultar a SUNAT
            </a>";
         
        
    }

    //if ((getPermitido("111") == "SI") && ($docp->estado == "ANULANDO")) {

       $btnconsultarAnulado="<a data-codigo='$codigo_enc' class='dropdown-item text-info' href='#' title='Consultar a SUNAT' onclick='fn_consultar_documento_anulado($(this));return false' >
                <i class='fas fa-binoculars mr-1'></i> Consultar Anulación a SUNAT
            </a>";
        
    //}

    if ((getPermitido("156") == "SI") && ($docp->estado == "PENDIENTE")) {
        $btnupdateclient = "<a data-codigo='$codigo_enc' class='dropdown-item' href='#' title='Actualizar Pagante' onclick='fn_update_pagante_doc($(this));return false' >
                <i class='fas fa-edit mr-1'></i> Actualizar Pagante
            </a>";
    }

    if ((getPermitido("174") == "SI")) {
        $btnupdatedoc = "<a data-codigo='$codigo_enc' class='dropdown-item text-success' href='#' title='Actualizar Documento' onclick='fn_view_data_doc($(this));return false' >
                <i class='fas fa-edit mr-1'></i> Actualizar Documento
            </a>";
    }

    $vrtotal=number_format($docp->total, 2);
    $vrigv=number_format($docp->migv, 2);
    echo 
    "<div class='row cfila' data-docsn='{$docp->serie}-{$docp->numero}' data-coddoc='$codigo_enc'  data-codpagante='{$docp->codpagante}' data-pagante='{$docp->pagante}' data-subtotal='{$docp->total}' data-igv='{$docp->migv}' data-autorizarvoucherantiguos='{$docp->autoriza_voucherantiguo}' data-pagantetipodoc='{$docp->pagantetipodoc}' data-pagantenrodoc='{$docp->pagantenrodoc}'>
                            <div class='col-12 col-md-5'>
                                <div class='row'>
                                    <div class='col-2 col-md-2 text-right td' >{$nro}. $docp->tipodoc</div>
                                    <div class='col-3 col-md-2 td' >
                                        <a href='#'  onclick='fn_showdetail($(this),`$codigo_enc`);return false;'>
                                            {$docp->serie}-{$docp->numero} 
                                        </a>
                                    </div>
                                    <div class='col-5 col-md-4 td' >$emision</div>
                                    <div class='col-2 col-md-4 td text-center ' >
                                        $dropdownstatus
                                    </div>


                                </div>
                            </div>
                             <div class='col-12 col-md-4 td'>
                                <a href='#'  onclick='fn_showdetail($(this),`$codigo_enc`);return false;'>
                                    $docp->codpagante - $docp->pagante
                                </a>
                            </div>
                            <div class='col-12 col-md-3'>
                                <div class='row'>
                                    <div class='col-sm-4 col-md-4 td'>
                                        <span class='txtperiodo'>$docp->periodo $ciclo</span>
                                    </div>
                                    <div class='col-md-3 td text-right'>
                                        <span class='$text_strike'>S/. $vrtotal</span>
                                    </div>
                                   <div class='col-md-3 td text-right'>
                                        <span class='$text_strike'>S/. $vrigv</span>
                                    </div>
                                    
                                    
                                    <div class='col-sm-4 col-md-2 td'>
                                        
                                            <div class='btn-group dropleft drop-menu-index'>
                                                <button class='btn btn-warning btn-sm btn-xs dropdown-toggle py-0' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    <i class='fas fa-print'></i>
                                                </button> 
                                                
                                               

                                                <div class='dropdown-menu dropdown-menu-right drop-menu-index'>
                                                    $btnmail
                                                    $btnprint
                                                    $btnpdf
                                                    $btnenlxml
                                                    $btnaddcobros
                                                    $btnanular 
                                                    $btneliminar
                                                    $btnsunat
                                                    $btnconsultar
                                                    $btnconsultarAnulado
                                                    $btnmatricula
                                                    $btnupdateclient
                                                    $btnupdatedoc
                                                    $btnAutorizaVoucherAntiguo 
                                                </div>
                                            </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>";
    }
?>
