<!DOCTYPE html>
<html>

<head>
    <link href=
'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>

    <script src=
'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'>
    </script>

    <script src=
'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'>
    </script>

    <link rel="stylesheet" href="../css/style_step.css">
</head>

<body>
<div class="container" id="container-contract_new">
<div class="row justify-content-center">
<div class="col-11 col-sm-9 col-md-7 
col-lg-6 col-xl-5 text-center p-0 mt-3 mb-2">
<div class="px-0 pt-4 pb-0 mt-3 mb-3">
    <form id="form" method="post">
        <?php session_start(); 
        //var_dump($_SESSION);
        //$_SESSION['ctf_step'] = 2;
        ?>
        <ul id="progressbar">
            <li class="active" id="step1">
                <strong>Consultar cliente</strong>
            </li>
            <li id="step2"><strong>Datos cliente</strong></li>
            <li id="step3"><strong>Datos de la moto</strong></li>
            <li id="step4"><strong>Datos financieros</strong></li>
            <li id="step5"><strong>Generación de contrato</strong></li>
        </ul>
        

        <fieldset id="step_customer_new" class="active">
            <?php if(!isset($_SESSION['client'])) { ?>
            <div id="wooctf-init" style="background-color: #ffffff; padding: 10px 50px 50px 50px; text-align: center;">
                    <h3>Ingrese el número de Cédula del cliente como lo tiene registrado en Contifico</h3>
                    
                    <div style="margin: 50px">
                 
                        <input type="text" id="ctf_ruc_search" name="ruc" placeholder="Ingrese el RUC" maxlength="13" required>

                        <button type="button" id="lpct_btn_get_client" style="padding: 5px; margin: 10px;" class="wooctf-sync-users-wp">Consultar</button>
                    </div>
                </div>
            <div class="center"><img src="<?php echo WOOCTF_URL;?>/assets/images/loading.gif" id="loading" style="position: fixed; margin-left: -50px; top: 400px; display: none"></div>
            <?php } ?>
            <?php $client = $_SESSION['client'][0]; 
            if(isset($_SESSION['client'])) { ?>
            <div id="wooctf-main" style="background-color: #ffffff; padding: 10px 50px 50px 50px; text-align: center;">
                <h3>Datos del cliente:</h3>
                
                <div style="">
                    <table class="wp-list-table widefat wooctf-admin-tables table-responsive table-bordered" style="margin: 20px 0">
                        <tr>
                            <td><label>Cédula:</label></td>
                            <?php $value = isset($_SESSION['client']) ? $client->cedula : ''; ?>
                            <td><input type="text" id="client_cedula" value="<?=$value?>" name="client_cedula" readonly='readonly'></td>
                        </tr>
                        <tr>
                            <td><label>Nombre y Apellido:</label></td>
                            <td><input type="text" id="client_name" value="<?=$client->razon_social?>" name="client_name"></td>
                        </tr>
                        
                    </table>
                    <span><strong>¿Estan correctos los datos del cliente?</strong><br /> Si estan correctos presione Continuar. Si no presione limpiar y vuelva a sincronizar</span><br />
                    <button type="button" id="lpct_btn_clean_client" style="padding: 5px; margin: 10px;" class="wooctf-sync-users-wp">Limpiar</button>
                    <button type="button" id="lpct_btn_save_client" style="padding: 5px; margin: 10px;" class="wooctf-sync-users-wp ctf_next_step2">Continuar</button>
                </div>
               
            </div>

            <?php } ?>

            <input type="button" name="next-step" 
                class="next-step" id="next-step_1" value="Siguiente" />
        </fieldset>
        <fieldset id="step_datos_cliente" >            
            <?php include plugin_dir_path(__FILE__).'ctf_step_client.php'; ?>
            <?php include plugin_dir_path(__FILE__).'ctf_step2_client.php'; ?>  
            <?php include plugin_dir_path(__FILE__).'ctf_step_spouse.php'; ?>  
            <?php include plugin_dir_path(__FILE__).'ctf_step2_spouse.php'; ?>  

            <input type="button" name="next-step" 
                class="next-step" value="Siguiente" />
            <input type="button" name="previous-step" 
                class="previous-step" 
                value="Atrás" />
        </fieldset>
        <fieldset id="step_datos_moto">

            <?php include plugin_dir_path(__FILE__).'ctf_step_vehicle.php'; ?>
            <input type="button" name="next-step" 
                class="next-step" value="Siguiente" />
            <input type="button" name="previous-step" 
                class="previous-step" 
                value="Atrás" />
            
        </fieldset>
        <fieldset>
            <?php include plugin_dir_path(__FILE__).'ctf_step_financial.php'; ?>

            <input type="button" name="next-step" 
                class="next-step" value="Siguiente" />
            <input type="button" name="previous-step" 
                class="previous-step" 
                value="Atrás" />
        </fieldset>
        <fieldset>
            <div class="finish">
                <h2 class="text text-center">
                    <strong>Generación de Contrato</strong>
                    <br />
                    <br />
                     <?php echo do_shortcode('[formulario_con_pdf]'); ?>
                </h2>

                <div class="documentos-checklist">
    <h3>Seleccione los documentos adicionales que sean requeridos para generarlos en pdf</h3>
    <ul style="list-style-type: none; padding-left: 0;">
        <li>
            <label>
                <input type="checkbox" name="documentos[]" value="guia_remision"> 
                Guía de remisión
            </label>
        </li>
        <li>
            <label>
                <input type="checkbox" name="documentos[]" value="acta_entrega"> 
                Acta de entrega
            </label>
        </li>
        <li>
            <label>
                <input type="checkbox" name="documentos[]" value="carta_responsabilidad"> 
                Carta de responsabilidad
            </label>
        </li>
        <li>
            <label>
                <input type="checkbox" name="documentos[]" value="acuerdo_pagos"> 
                Acuerdo de pagos
            </label>
        </li>
        <li>
            <label>
                <input type="checkbox" name="documentos[]" value="reserva_dominio"> 
                Reserva de dominio
            </label>
        </li>
    </ul>
</div>
            </div>
            <input type="button" name="previous-step" 
                class="previous-step" 
                value="Anterior" />
        </fieldset>
    </form>
</div>
</div>
</div>
</div>
</body>
<script src="../js/script_step.js"></script>

</html>