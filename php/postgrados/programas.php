<?php
// php/postgrados/programas.php
session_start(); 
ini_set('display_errors',0);

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    include "../../php/conexion.php";

    $sql1 = "SELECT * FROM postgrado WHERE id = " . $_GET["postgrado_id"];
    $query = $con->query($sql1);
    $programa = null;

    if($query->num_rows > 0) {
        while ($r = $query->fetch_object()) {
            $programa = $r;
            break;
        }
    }
    
    // Incluir configuración
    require_once "../../includes/config.php";
    
    // Título de la página
    $page_title = "Programas del Postgrado";
    
    // Ruta base
    $base = '../../';
    
    // Incluir header
    include "../../includes/header.php";
?>

<?php include "../../php/navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Botón volver -->
            <div class="pull-right" style="margin-bottom: 20px;">
                <a href="../../postgrados.php" class="btn btn-danger">
                    <i class="fas fa-arrow-left"></i> Ir atrás
                </a>
            </div>
            
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-university" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>PROGRAMAS DEL POSTGRADO</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-graduation-cap"></i> 
                    <?php echo strtoupper($programa->nombre); ?>
                </p>
            </div>

            <!-- Información del postgrado -->
            <div class="content-card fade-in-up" style="margin-bottom: 20px;">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="section-title" style="margin-top: 0;">
                            <i class="fas fa-info-circle"></i> Información del Postgrado
                        </h4>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Código:</th>
                                <td><?php echo htmlspecialchars($programa->codigo); ?></td>
                            </tr>
                            <tr>
                                <th>Nombre:</th>
                                <td><?php echo htmlspecialchars($programa->nombre); ?></td>
                            </tr>
                            <?php if(isset($programa->sitio_web) && !empty($programa->sitio_web)): ?>
                            <tr>
                                <th>Sitio Web:</th>
                                <td>
                                    <a href="<?php echo htmlspecialchars($programa->sitio_web); ?>" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-external-link-alt"></i> Visitar sitio
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 class="section-title" style="margin-top: 0;">
                            <i class="fas fa-chart-bar"></i> Estadísticas
                        </h4>
                        <?php
                        // Contar programas asociados
                        $sql_count = "SELECT COUNT(*) as total FROM programa WHERE postgrado_id = " . $programa->id;
                        $count_query = $con->query($sql_count);
                        $total_programas = ($count_query && $row = $count_query->fetch_object()) ? $row->total : 0;
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center" style="background: var(--gradient-silver); padding: 20px; border-radius: 12px;">
                                    <i class="fas fa-layer-group" style="font-size: 2rem; color: var(--primary-blue);"></i>
                                    <h3 style="margin: 10px 0; color: var(--primary-blue);"><?php echo $total_programas; ?></h3>
                                    <p style="margin: 0; color: var(--gray-600);">Total Programas</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center" style="background: var(--gradient-silver); padding: 20px; border-radius: 12px;">
                                    <i class="fas fa-calendar-alt" style="font-size: 2rem; color: var(--accent-green);"></i>
                                    <h3 style="margin: 10px 0; color: var(--accent-green);">-</h3>
                                    <p style="margin: 0; color: var(--gray-600);">Años de actividad</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LISTADO DE PROGRAMAS -->
            <div class="table-container fade-in-up">
                <h4 class="section-title" style="margin-top: 0;">
                    <i class="fas fa-list"></i> Programas Asociados
                </h4>
                <?php include "../programas/listar.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php include "../../includes/footer.php"; ?>

<!-- Inicialización de DataTables -->
<script>
$(document).ready(function() {
    $('#table_programas').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay datos disponibles en la tabla",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron resultados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar para ordenar columna ascendente",
                "sortDescending": ": activar para ordenar columna descendente"
            }
        },
        "pageLength": 10,
        "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]]
    });
});
</script>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='../../index.php';</script>";
} 
?>