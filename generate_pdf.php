<?php
session_start();

generar_pdf();

function mostrar_formulario_pdf() {
    // Procesar el envío del formulario
    if (isset($_POST['generar_pdf'])) {
        generar_pdf();
    }
    ?>
	<button type="submit" class="btn-samadi" name="generar_pdf">
        Generar PDF
    </button>

    <?php
    return ob_get_clean(); // Devolver el contenido del buffer
}

// Función para generar el PDF
function generar_pdf() {
    

    // Obtener datos del formulario (sanitizados)
    $nombre = "pepito perez";
    
    try {
        // Crear nueva instancia TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        
        // Configuración del documento
        $pdf->SetCreator('Coordinacion General de Estudios de Postgrado-CGEP ULA');
        $pdf->SetAuthor("UCREP - CGEP - ULA");
        $pdf->SetTitle('Cierre expediente '. $nombre);
        $pdf->SetMargins(10, 6, 10);
        $pdf->setPrintHeader(false);
        
        // Agregar página
        $pdf->AddPage();
        
        // Logo (opcional)
        $logo_path = plugin_dir_path(__FILE__) . '../assets/images/wooctf_logo_contract.png';

        if (file_exists($logo_path)) {
            $pdf->Image($logo_path, 10, 8, 110, 0, 'PNG');
        }
        $html_header = '<h3 style="text-align:right;">CONTRATO DE VENTA</h3>
			        <table  cellpadding="0" cellspacing="0" border="0">
			        <tr >
			          <td colspan="2"></td>
			            <td align="right" style="font-size:15px">N°</td>
			            <td align="center" valing="top" style="font-size:25px;color:red">000000</td>
			        </tr>
			        <tr>
			          <td ></td>
			          <td width="185"></td>
			          <td width="80">Ciudad y Fecha: </td>
			          <td style="border-bottom:1px solid #000000 width="30">Quito </td>
                      <td width="128" style="border-bottom:1px solid #000000 >'.date('d/m/Y').'</td>
			        </tr>
			        <tr>
			          <td ></td>
			          <td width="185"></td>
			          <td width="55">Vendedor: </td>
			          <td width="152" colspan="2" style="border-bottom:1px solid #000000"></td>
			            
			        </tr>

			    </table>';
        $html_client = get_html_client($_POST);
        $html_client_references = get_html_references($_POST);
        $html_spouse = get_html_spouse($_POST);
        $html_spouse_references = get_html_spouse_references($_POST);
        $html_vehicle = get_html_vehicle($_POST);
        $html_financial = get_html_financial($_POST);
        $html_firmas = get_html_firmas($_POST);

        // Contenido HTML
        $html = $html_header.$html_client.$html_client_references.$html_spouse.$html_spouse_references.$html_vehicle.$html_financial;
        
        $html2 = $html_firmas;
        // Escribir HTML
        $pdf->SetFontSize(10);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->addPage();
        $pdf->writeHTML($html2, true, false, true, false, '');
        
        
        
        // Salida del PDF (D = descarga, I = vista en navegador)
        $pdf->Output('Contrato_' . sanitize_title($nombre) . '.pdf', 'D');
        exit;
        
    } catch (Exception $e) {
        wp_die('Error al generar el PDF: ' . $e->getMessage());
    }
}






/*

function generar_pdf_main() {

		//check_admin_referer('generar_pdf_action');

		var_dump($_POST);
    
        // Crear PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Configuración básica
        $pdf->SetCreator('Plugin Deudores');
        $pdf->SetAuthor('Sistema WordPress');
        $pdf->SetTitle('Datos del Deudor: ');
        
        // Añadir página
        $pdf->AddPage();

    	$plugin_logo_path = plugin_dir_path(__FILE__) . 'assets/images/wooctf_logo_p.jpg';
	    if (file_exists($plugin_logo_path)) {
	        $pdf->Image($plugin_logo_path, 15, 10, 30, 0, 'PNG', '', 'T', false, 300);
	    }
        
        // Contenido HTML del PDF
        $html = '
        <h1 style="text-align:center;">Datos del Deudor</h1>';
        
        // Escribir HTML
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Limpiar buffer y enviar PDF
        ob_end_clean();
        $pdf->Output('deudor_1666.pdf', 'D');
        exit;
}
//add_action('init', 'generar_pdf_main');
add_action('wp_ajax_generar_pdf', 'generar_pdf_main');

// Función para mostrar el formulario
function mostrar_formulario_deudor() {
    // Añadir nonce para seguridad
    
    
    
    // Tu formulario HTML existente
    ob_start();
    ?>
    <div id="wooctf-step2">
        <!-- Tus campos existentes -->
        <div style="text-align: center; margin-top: 20px;">
            <form method="post">
                <input type="hidden" name="generar_pdf" value="1">
                <?php wp_nonce_field('generar_pdf_action'); ?>
                <input type="submit" name="submit_pdf" value="Generar PDF" class="button button-primary">
            </form>
        </div>
    </div>
    <script>
		jQuery('#generar-pdf').click(function() {
		    window.open('<?php echo admin_url('admin-ajax.php?action=generar_pdf'); ?>');
		});
	</script>
    <?php
    return ob_get_clean();
}



// Shortcode para mostrar el formulario
add_shortcode('formulario_deudor', 'mostrar_formulario_deudor');*/
?>