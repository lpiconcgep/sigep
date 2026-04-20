<?php
// php/estudiante/editar_estudio.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    include "../../php/conexion.php";
    
    $user_id = null;
    
    $sql1 = "SELECT * FROM estudiante_programa ep INNER JOIN persona p ON ep.persona_id = p.id WHERE ep.id = " . $_GET["estudiante_id"];
    $query1 = $con->query($sql1);
    $person = null;
    
    if($query1->num_rows > 0) {
        while ($r = $query1->fetch_object()) {
            $person = $r;
            break;
        }
    }
    
    $nombre = $person->primer_apellido . " " . $person->primer_nombre;
    $cedula = $person->nacionalidad . " - " . $person->documento_identidad;
    
    // Incluir configuración
    require_once "../../includes/config.php";
    
    // Título de la página
    $page_title = "Editar Estudio Realizado";
    
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
                <a href="javascript:history.back()" class="btn btn-danger">
                    <i class="fas fa-arrow-left"></i> Ir atrás
                </a>
            </div>
            
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-user-edit" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>EDITAR ESTUDIO REALIZADO</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-user-graduate"></i> 
                    <?php echo strtoupper($nombre); ?> (<?php echo $cedula; ?>)
                </p>
            </div>

            <!-- Formulario de edición -->
            <div class="content-card fade-in-up">
                <?php include "../estudiante/formulario.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php include "../../includes/footer.php"; ?>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='../../index.php';</script>";
} 
?>