<?php 

// postgrados.php
session_start();
ini_set('display_errors',0);

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Gestión de Postgrados";
    
    // Ruta base
    $base = '';
    
    // Incluir header
    include "includes/header.php";
<<<<<<< Updated upstream
    include "php/navbar.php"; 
    include "php/funciones.php";
?>
=======
?>

<?php include "php/navbar.php"; ?>
>>>>>>> Stashed changes

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-university" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>VER POSTGRADOS</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Gestión de programas de postgrado por facultad
                </p>
            </div>
            
            <?php 
            include "php/funciones.php";
            $facultades_obj = consultar_facultades(); 
            $facultades = (array) $facultades_obj;
            ?>
            
            <!-- Filtro de facultades -->
            <div class="content-card fade-in-up" style="padding: 15px;">
                <form method="get" class="form-inline">
                    <label for="facultadSelect"><strong>Filtrar por Facultad:</strong></label>
                    <select id="facultadSelect" name="facultad" class="form-control" style="width: 250px; margin-left: 10px; margin-right: 10px;">
                        <option value="">Todas</option>
                        <?php 
                        foreach ($facultades as $fact) {
                            $fac = (array) $fact;
                        ?>
                            <option value="<?php echo $fac['id']; ?>" 
                                <?php if(isset($_GET['facultad']) && $_GET['facultad'] == $fac['id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($fac['nombre']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-success">Filtrar</button>
                    <a href="postgrados.php" class="btn btn-default" style="margin-left: 10px;">Limpiar</a>
                </form>
            </div>

            <!-- LISTADO DE POSTGRADOS -->
            <div class="table-container fade-in-up">
                <?php include "php/postgrados/listar.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

<!-- Inicialización de DataTables -->
<script>
$(document).ready(function() {
    $('#table_postgrado').DataTable({
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
