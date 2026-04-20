<?php 
// personas.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración (estamos en la raíz)
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Gestión de Personas";
    
    // Ruta base (estamos en la raíz)
    $base = '';
    
    // Incluir header
    include "includes/header.php";
?>

<?php include "php/navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-users" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>VER PERSONAS</strong>
                </h2>
                <p class="text-muted">Gestión de personas registradas en el sistema</p>
            </div>
            
            <!-- Botón para agregar persona (modal trigger) -->
            <div class="content-card fade-in-up" style="padding: 15px;">
                <div class="row">
                    <div class="col-md-6">
                        <button data-toggle="modal" href="#myModal" class="btn-custom btn-success-custom">
                            <i class="fas fa-user-plus"></i> Agregar Nueva Persona
                        </button>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="badge" style="background-color: var(--primary-blue); color: white; padding: 8px 15px; font-size: 1rem;">
                            <i class="fas fa-users"></i> Listado completo
                        </span>
                    </div>
                </div>
            </div>

            <!-- Modal para agregar persona (mejorado) -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: var(--gradient-blue); color: white; border-radius: 5px 5px 0 0;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white; opacity: 0.8;">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">
                                <i class="fas fa-user-plus"></i> Agregar Nueva Persona
                            </h4>
                        </div>
                        <div class="modal-body">
                            <?php
                            $source = "personas";
                            include "php/personas/form.php";
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-custom btn-primary-custom" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Listado de personas -->
            <div class="content-card fade-in-up">
                <h4 class="section-title" style="margin-top: 0;">
                    <i class="fas fa-list" style="color: var(--accent-green); margin-right: 10px;"></i>
                    Listado de Personas Registradas
                </h4>
                
                <?php include "php/personas/listar.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php 
    include "includes/footer.php"; 
?>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>