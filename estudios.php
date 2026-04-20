<?php
// estudios.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    include "php/conexion.php";

    $user_id = null;
    $sql1 = "SELECT * FROM persona WHERE id = " . $_GET["id"];
    $query = $con->query($sql1);
    $person = null;

    if($query->num_rows > 0) {
        while ($r = $query->fetch_object()) {
            $person = $r;
            break;
        }
    }

    $nombre = $person->primer_apellido . " " . $person->primer_nombre;
    $cedula = $person->nacionalidad . " - " . $person->documento_identidad;
    
    // Incluir configuración
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Estudios Realizados";
    
    // Ruta base
    $base = '';
    
    // Incluir header
    include "includes/header.php";
?>

<?php include "php/navbar.php"; ?>

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
                    <i class="fas fa-graduation-cap" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>ESTUDIOS REALIZADOS</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-user-graduate"></i> 
                    <?php echo strtoupper($nombre); ?> (<?php echo $cedula; ?>)
                </p>
            </div>
            
            <!-- Botón Agregar Estudios -->
            <div style="margin-bottom: 20px;">
                <a data-toggle="modal" href="#myModal" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Agregar Estudios
                </a>
            </div>

            <!-- Modal para agregar estudios -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">
                                <i class="fas fa-plus-circle"></i> Agregar Estudios
                            </h4>
                        </div>
                        <div class="modal-body">
                            <?php include "php/estudiante/form.php"; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de estudios -->
            <div class="table-container fade-in-up">
                <?php include "php/estudiante/listar.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>