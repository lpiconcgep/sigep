<?php
// buscar_estudiante.php
session_start();

include "./php/conexion.php";
include "./php/funciones.php";
include "./php/utilidades.php";

if(isset($_POST['opcion']) && $_POST['opcion'] != '')
{
	$opcio = $_POST['opcion'];
}
elseif (isset($_GET['opt']) && $_GET['opt'] != '')
{
	$opcio = $_GET['opt'];
}
else
{
	$opcio = '';
}

if(isset($_GET) && isset($_GET['opt']) == '' && $opcio == '')
{
	$opcio = 1;
}

if(isset($opcio) && $opcio != '')
{
	$opcion = " REGISTRO DE INFORMACION PARA ";
	if($opcio == '1')
		$opcion .= "NUEVO INGRESO";
	else if($opcio == '2')
		$opcion .= "RETIRO O DESINCORPORACION";
	else if($opcio == '4') 
		$opcion .= "CIERRE DE EXPEDIENTE";
	else 
		$opcion .= "EGRESO DE ESTUDIANTE";
}

if(isset($_POST['s'])) { $s = $_POST['s']; } else { $s = $_GET['s']; }

$persona = buscar_persona_x_cedula($s);

if($persona != NULL)
{
	$estudios_persona = buscar_inscripciones_x_persona_id($persona->id);
}

// Incluir configuración
require_once "includes/config.php";

// Título de la página
$page_title = "Registro de Estudiantes";

// Ruta base
$base = '';

// Incluir header
include "includes/header.php";
?>

<style>
/* Estilos específicos para esta página */
.datos-personales {
    background: var(--gradient-silver);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

.datos-personales h4 {
    color: var(--blue-soft);
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--turquoise-soft);
}

.datos-personales p {
    margin-bottom: 8px;
    color: var(--text-dark);
}

.datos-personales strong {
    color: var(--blue-soft);
}

.info-card {
    background: var(--white);
    border-radius: 12px;
    padding: 20px;
    box-shadow: var(--shadow-sm);
    margin-bottom: 20px;
}

.info-card h4 {
    color: var(--blue-soft);
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--turquoise-soft);
}

.cedula-info {
    background: var(--gradient-blue);
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.cedula-info h4 {
    margin: 0;
    font-size: 1.1rem;
}

.cedula-info em {
    font-size: 1.2rem;
    font-weight: bold;
}
</style>

<?php include "php/navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Botón volver -->
            <div class="pull-right" style="margin-bottom: 20px;">
                <a href="./" class="btn btn-danger">
                    <i class="fas fa-arrow-left"></i> Ir atrás
                </a>
            </div>
            
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-user-graduate" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong><?php echo $opcion; ?></strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Complete la información del estudiante
                </p>
            </div>
            
            <!-- Información de la cédula -->
            <div class="info-card fade-in-up">
                <div class="row">
                    <div class="col-md-12">
                        <div class="cedula-info">
                            <h4><i class="fas fa-id-card"></i> Cédula: <em><?php echo $s; ?></em></h4>
                        </div>
                        
                        <?php if($persona == NULL) { ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 
                                Cédula no registrada.
                                <?php if($opcio == '4') { ?>
                                    <br><em style="color: #856404;">Para proceder con el proceso del cierre de expediente debe hacer el registro del estudiante como nuevo ingreso.</em>
                                <?php } ?>
                            </div>
                            
                            <?php if($persona == NULL && $opcio != '4') { ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fas fa-user-plus"></i> Agregar Persona
                                </button>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
            <?php if($persona != NULL) { 
                $cols = $opcio != '4' ? "col-md-5" : "col-md-6";
            ?>
                <div class="row">
                    <div class="<?php echo $cols; ?>">
                        <!-- Datos Personales -->
                        <div class="datos-personales fade-in-up">
                            <h4><i class="fas fa-user"></i> Datos Personales</h4>
                            <p><strong>Nombres:</strong> <?php echo strtoupper($persona->primer_nombre." ".$persona->segundo_nombre); ?></p>
                            <p><strong>Apellidos:</strong> <?php echo strtoupper($persona->primer_apellido." ".$persona->segundo_apellido); ?></p>
                        </div>
                        
                        <?php
                        if(($opcio == '1') || ($opcio == '2') || ($opcio == '3')) {
                            include "parcial_datos_academicos.php"; 
                        }
                        else if($opcio == '4'){
                            include "parcial_datos_cierre.php"; 
                        }
                        ?>
                    </div>
                    
                    <?php if($opcio == '1') { ?>
                        <div class="col-md-6">
                            <div class="info-card fade-in-up">
                                <?php
                                $source = 'integral';
                                $opcio = $opcio;
                                $documento_identidad = $persona->documento_identidad;
                                include "php/estudiante/form_new_estudiante.php"; 
                                ?>
                            </div>
                        </div>
                    <?php } elseif($opcio == '2') { ?>
                        <div class="col-md-6">
                            <div class="info-card fade-in-up" id="form_registro_retiro" style="display:none">
                                <?php
                                $source = 'personal';
                                $opcio = $opcio;
                                $documento_identidad = $persona->documento_identidad;
                                include "php/estudiante/form_retiro_estudio.php";
                                ?>
                            </div>
                        </div>
                    <?php } elseif($opcio == '3') { ?>
                        <div class="col-md-6">
                            <div class="info-card fade-in-up" id="form_registro_egreso" style="display:none">
                                <?php
                                $source = 'personal';
                                $opcio = $opcio;
                                $documento_identidad = $persona->documento_identidad;
                                include "php/estudiante/form_egreso_estudio.php";
                                ?>
                            </div>
                        </div>
                    <?php } elseif($opcio == '4') { ?>
                        <div class="col-md-6">
                            <div class="info-card fade-in-up" id="form_registro_cierre" style="display:none">
                                <?php
                                $source = 'personal';
                                $opcio = $opcio;
                                $documento_identidad = $persona->documento_identidad;
                                include "php/estudiante/cierre_expediente.php";
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- MODAL para agregar persona (simple, sin estilos adicionales) -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="fas fa-user-plus"></i> Agregar Persona
                </h4>
            </div>
            <div class="modal-body">
                <?php
                $source = "integral";
                include "php/personas/form.php";
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

<script>
$(document).ready(function() {
    // Mostrar formularios según la opción
    <?php if($opcio == '2'): ?>
        $('#form_registro_retiro').show();
    <?php elseif($opcio == '3'): ?>
        $('#form_registro_egreso').show();
    <?php elseif($opcio == '4'): ?>
        $('#form_registro_cierre').show();
    <?php endif; ?>
});
</script>

<?php if(!isset($_SESSION['session']) || $_SESSION['session'] != 'true') { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>