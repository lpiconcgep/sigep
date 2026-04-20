<?php
// php/personas/editar.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración
    require_once "../../includes/config.php";
    
    // Título de la página
    $page_title = "Editar Persona";
    
    // Ruta base
    $base = '../../';
    
    // Incluir header
    include "../../includes/header.php";
?>

<?php include "../navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Botón volver -->
            <div class="pull-right" style="margin-bottom: 20px;">
                <?php 
                $back = $_GET['sour']; 
                if($back == 'list') {
                    $url_back = "/sigep_prototipo/personas.php";
                } else {
                    $url_back = "/sigep_prototipo/buscar.php?s=" . $_GET['s'];
                }
                ?>
                <a href="<?php echo $url_back; ?>" class="btn btn-danger">
                    <i class="fas fa-arrow-left"></i> Ir atrás
                </a>
            </div>
            
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-user-edit" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>EDITAR PERSONA</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Modifique los datos de la persona seleccionada
                </p>
            </div>

            <!-- Formulario de edición -->
            <div class="content-card fade-in-up">
                <?php include "../personas/formulario.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php include "../../includes/footer.php"; ?>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='../../index.php';</script>";
} 
?>