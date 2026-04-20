<?php 
// php/estudiantes/programa.php
session_start();
ini_set('display_errors',0);

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
<<<<<<< Updated upstream
    $source = $_GET['source'];
    ?>
    
    <a href="php/reportes/matricula.php" class="btn btn-danger hidden-print">Ir atr&aacute;s</a>
    <?php } ?>
</div>
<div class="col-md-12">
		<h4>VER MATRICULA DE <?php echo strtoupper($programa->nombre); ?></h4>
<br>
=======
    include "./php/conexion.php";
    
    $user_id = null;
    
    $sql = "SELECT * FROM programa WHERE id = " . $_GET["programa_id"];
    $query = $con->query($sql);
    $programa = null;
    
    if($query->num_rows > 0) {
        while ($r = $query->fetch_object()) {
            $programa = $r;
            break;
        }
    }
    
    // Incluir configuración
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Matrícula del Programa";
    
    // Ruta base
    $base = '';
    
    // Incluir header
    include "includes/header.php";
?>
>>>>>>> Stashed changes

<?php include "php/navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Botón volver -->
            <div class="pull-right" style="margin-bottom: 20px;">
                <?php if(!(isset($_GET) && isset($_GET['source']) && $_GET['source'] == 'reportes')) { 
                    $source = '';
                ?>
                    <a href="php/postgrados/programas.php?postgrado_id=<?php echo $programa->postgrado_id; ?>" class="btn btn-danger">
                        <i class="fas fa-arrow-left"></i> Ir atrás
                    </a>
                <?php } else { 
                    $source = $_GET['source'];
                ?>
                    <a href="php/reportes/matricula.php" class="btn btn-danger hidden-print">
                        <i class="fas fa-arrow-left"></i> Ir atrás
                    </a>
                <?php } ?>
            </div>
            
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-users" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>MATRÍCULA DEL PROGRAMA</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-graduation-cap"></i> 
                    <?php echo strtoupper($programa->nombre); ?>
                </p>
            </div>

            <!-- Información del programa -->
            <div class="content-card fade-in-up" style="margin-bottom: 20px;">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="section-title" style="margin-top: 0;">
                            <i class="fas fa-info-circle"></i> Información del Programa
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
                            <tr>
                                <th>Estatus:</th>
                                <td>
                                    <span class="badge" style="background: var(--accent-green); color: white; padding: 5px 12px;">
                                        <i class="fas fa-check-circle"></i> Activo
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 class="section-title" style="margin-top: 0;">
                            <i class="fas fa-chart-bar"></i> Estadísticas
                        </h4>
                        <?php
                        // Contar estudiantes del programa
                        $sql_count = "SELECT COUNT(*) as total FROM estudiante_programa WHERE programa_id = " . $programa->id;
                        $count_query = $con->query($sql_count);
                        $total_estudiantes = ($count_query && $row = $count_query->fetch_object()) ? $row->total : 0;
                        
                        // Contar estudiantes activos
                        $sql_activos = "SELECT COUNT(*) as total FROM estudiante_programa WHERE programa_id = " . $programa->id . " AND estatus_estudiante_id = 1";
                        $activos_query = $con->query($sql_activos);
                        $total_activos = ($activos_query && $row = $activos_query->fetch_object()) ? $row->total : 0;
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-center" style="background: var(--gradient-silver); padding: 20px; border-radius: 12px;">
                                    <i class="fas fa-users" style="font-size: 2rem; color: var(--primary-blue);"></i>
                                    <h3 style="margin: 10px 0; color: var(--primary-blue);"><?php echo $total_estudiantes; ?></h3>
                                    <p style="margin: 0; color: var(--gray-600);">Total Estudiantes</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center" style="background: var(--gradient-silver); padding: 20px; border-radius: 12px;">
                                    <i class="fas fa-user-check" style="font-size: 2rem; color: var(--accent-green);"></i>
                                    <h3 style="margin: 10px 0; color: var(--accent-green);"><?php echo $total_activos; ?></h3>
                                    <p style="margin: 0; color: var(--gray-600);">Estudiantes Activos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LISTADO DE MATRÍCULA -->
            <div class="table-container fade-in-up">
                <h4 class="section-title" style="margin-top: 0;">
                    <i class="fas fa-list"></i> Listado de Estudiantes Matriculados
                </h4>
                <?php include "php/estudiante/matricula_listar.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

<!-- Inicialización de DataTables -->
<script>
$(document).ready(function() {
    $('#table_matricula').DataTable({
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
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>