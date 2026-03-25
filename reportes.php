<?php 
// reportes.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración (estamos en la raíz)
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Reportes";
    
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
                    <i class="fas fa-chart-bar" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>REPORTES DEL SISTEMA</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Seleccione el tipo de reporte que desea visualizar
                </p>
            </div>
            
            <!-- Tarjetas de reportes - Tamaño más pequeño y alineadas -->
            <div class="row" style="margin-top: 20px;">
                <!-- Reporte de Matrícula -->
                <div class="col-md-3">
                    <div class="feature-card fade-in-up" style="min-height: 180px; cursor: pointer; text-align: center; padding: 15px;" onclick="window.location.href='php/reportes/matricula.php'">
                        <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 10px; background: var(--gradient-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h4 style="font-size: 1.1rem; margin: 5px 0;">MATRÍCULA</h4>
                        <p style="font-size: 0.85rem; margin: 5px 0;">Reporte de matrícula de estudiantes</p>
                        <div style="margin-top: 8px;">
                            <span class="badge" style="background-color: var(--accent-green); color: white; padding: 3px 8px; font-size: 0.75rem;">
                                <i class="fas fa-arrow-right"></i> Ver
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Reporte de Estudiantes -->
                <div class="col-md-3">
                    <div class="feature-card fade-in-up" style="min-height: 180px; cursor: pointer; text-align: center; padding: 15px;" onclick="window.location.href='php/reportes/estudiantes.php'">
                        <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 10px; background: var(--gradient-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <h4 style="font-size: 1.1rem; margin: 5px 0;">ESTUDIANTES</h4>
                        <p style="font-size: 0.85rem; margin: 5px 0;">Reporte detallado de estudiantes</p>
                        <div style="margin-top: 8px;">
                            <span class="badge" style="background-color: var(--accent-green); color: white; padding: 3px 8px; font-size: 0.75rem;">
                                <i class="fas fa-arrow-right"></i> Ver
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Reporte de Posgrados Inactivos -->
                <div class="col-md-3">
                    <div class="feature-card fade-in-up" style="min-height: 180px; cursor: pointer; text-align: center; padding: 15px;" onclick="window.location.href='php/reportes/posgrado.php'">
                        <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 10px; background: var(--gradient-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-university fa-2x"></i>
                        </div>
                        <h4 style="font-size: 1.1rem; margin: 5px 0;">POSGRADOS</h4>
                        <p style="font-size: 0.85rem; margin: 5px 0;">Programas sin actividad</p>
                        <div style="margin-top: 8px;">
                            <span class="badge" style="background-color: var(--accent-green); color: white; padding: 3px 8px; font-size: 0.75rem;">
                                <i class="fas fa-arrow-right"></i> Ver
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Reporte de Estadísticas (en desarrollo) -->
                <div class="col-md-3">
                    <div class="feature-card fade-in-up" style="min-height: 180px; cursor: pointer; text-align: center; padding: 15px; opacity: 0.7;" onclick="alert('Módulo en desarrollo');">
                        <div class="feature-icon" style="width: 60px; height: 60px; margin: 0 auto 10px; background: var(--gradient-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                        <h4 style="font-size: 1.1rem; margin: 5px 0;">ESTADÍSTICAS</h4>
                        <p style="font-size: 0.85rem; margin: 5px 0;">Módulo en desarrollo</p>
                        <div style="margin-top: 8px;">
                            <span class="badge" style="background-color: var(--gray-500); color: white; padding: 3px 8px; font-size: 0.75rem;">
                                <i class="fas fa-clock"></i> Pronto
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas rápidas - Versión compacta -->
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-12">
                    <div class="content-card fade-in-up" style="padding: 15px;">
                        <h4 class="section-title" style="margin-top: 0; margin-bottom: 15px; font-size: 1.2rem;">
                            <i class="fas fa-chart-pie" style="color: var(--accent-green);"></i>
                            Resumen Rápido
                        </h4>
                        
                        <div class="row">
                            <?php
                            // Obtener algunas estadísticas rápidas
                            include "php/conexion.php";
                            
                            // Total de estudiantes
                            $sql_est = "SELECT COUNT(*) as total FROM persona";
                            $res_est = $con->query($sql_est);
                            $total_est = ($res_est && $row = $res_est->fetch_assoc()) ? $row['total'] : 0;
                            
                            // Total de programas
                            $sql_prog = "SELECT COUNT(*) as total FROM programa";
                            $res_prog = $con->query($sql_prog);
                            $total_prog = ($res_prog && $row = $res_prog->fetch_assoc()) ? $row['total'] : 0;
                            
                            // Total de postgrados
                            $sql_post = "SELECT COUNT(*) as total FROM postgrado";
                            $res_post = $con->query($sql_post);
                            $total_post = ($res_post && $row = $res_post->fetch_assoc()) ? $row['total'] : 0;
                            ?>
                            
                            <div class="col-md-4">
                                <div class="text-center" style="background: var(--gradient-silver); padding: 10px; border-radius: 8px;">
                                    <i class="fas fa-users" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
                                    <h3 style="margin: 5px 0; color: var(--primary-blue); font-size: 1.5rem;"><?php echo number_format($total_est); ?></h3>
                                    <p style="margin: 0; color: var(--gray-600); font-size: 0.8rem;">Personas</p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="text-center" style="background: var(--gradient-silver); padding: 10px; border-radius: 8px;">
                                    <i class="fas fa-book" style="font-size: 1.5rem; color: var(--accent-green);"></i>
                                    <h3 style="margin: 5px 0; color: var(--accent-green); font-size: 1.5rem;"><?php echo number_format($total_prog); ?></h3>
                                    <p style="margin: 0; color: var(--gray-600); font-size: 0.8rem;">Programas</p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="text-center" style="background: var(--gradient-silver); padding: 10px; border-radius: 8px;">
                                    <i class="fas fa-university" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
                                    <h3 style="margin: 5px 0; color: var(--primary-blue); font-size: 1.5rem;"><?php echo number_format($total_post); ?></h3>
                                    <p style="margin: 0; color: var(--gray-600); font-size: 0.8rem;">Postgrados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="row" style="margin-top: 20px; margin-bottom: 30px;">
                <div class="col-md-12">
                    <div class="alert alert-info" style="background: var(--gradient-silver); border-left: 4px solid var(--primary-blue); padding: 10px; margin-bottom: 0;">
                        <i class="fas fa-info-circle"></i>
                        <small>Puede generar reportes en formato PDF desde cada módulo.</small>
                    </div>
                </div>
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