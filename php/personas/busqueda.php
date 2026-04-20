<?php
// php/personas/busqueda.php

// CORREGIDO: Ruta correcta para conexión (sube dos niveles)
include "../../php/conexion.php";

$busqueda = $_GET['s'];

// Verificar que la conexión existe
if(!isset($con) || $con == null) {
    echo '<div class="alert alert-danger">Error de conexión a la base de datos</div>';
    exit;
}

// Búsqueda en tabla persona
$sql_personas = "SELECT * FROM persona 
                 WHERE documento_identidad LIKE '%$busqueda%' 
                 OR primer_nombre LIKE '%$busqueda%' 
                 OR segundo_nombre LIKE '%$busqueda%' 
                 OR primer_apellido LIKE '%$busqueda%' 
                 OR segundo_apellido LIKE '%$busqueda%'
                 ORDER BY primer_apellido ASC, primer_nombre ASC";

$result_personas = mysqli_query($con, $sql_personas);

// Búsqueda en tabla programa
$sql_programas = "SELECT * FROM programa 
                  WHERE nombre LIKE '%$busqueda%' 
                  OR codigo LIKE '%$busqueda%'
                  ORDER BY nombre ASC";

$result_programas = mysqli_query($con, $sql_programas);

// Búsqueda en tabla postgrado
$sql_postgrados = "SELECT * FROM postgrado 
                   WHERE nombre LIKE '%$busqueda%' 
                   OR codigo LIKE '%$busqueda%'
                   ORDER BY nombre ASC";

$result_postgrados = mysqli_query($con, $sql_postgrados);

$total_resultados = 0;
?>

<?php if(mysqli_num_rows($result_personas) > 0 || mysqli_num_rows($result_programas) > 0 || mysqli_num_rows($result_postgrados) > 0): ?>
    
    <!-- Resultados de Personas -->
    <?php if(mysqli_num_rows($result_personas) > 0): 
        $total_resultados += mysqli_num_rows($result_personas);
    ?>
    <div class="result-card fade-in-up">
        <h4><i class="fas fa-users"></i> Personas Encontradas</h4>
        <div class="table-responsive">
            <table class="result-table">
                <?php while($row = mysqli_fetch_assoc($result_personas)): ?>
                    <tr>
                        <td class="label">
                            <i class="fas fa-id-card"></i> Cédula:
                        </td>
                        <td>
                            <span class="badge-search"><?php echo $row['nacionalidad'] . " - " . $row['documento_identidad']; ?></span>
                        </td>
                        <td class="label">
                            <i class="fas fa-user"></i> Nombre:
                        </td>
                        <td><?php echo strtoupper($row['primer_nombre'] . " " . $row['segundo_nombre']); ?></td>
                        <td class="label">
                            <i class="fas fa-user"></i> Apellido:
                        </td>
                        <td><?php echo strtoupper($row['primer_apellido'] . " " . $row['segundo_apellido']); ?></td>
                        <td>
                            <a href="personas.php" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Resultados de Programas -->
    <?php if(mysqli_num_rows($result_programas) > 0): 
        $total_resultados += mysqli_num_rows($result_programas);
    ?>
    <div class="result-card fade-in-up">
        <h4><i class="fas fa-book"></i> Programas Encontrados</h4>
        <div class="table-responsive">
            <table class="result-table">
                <?php while($row = mysqli_fetch_assoc($result_programas)): ?>
                    <tr>
                        <td class="label">
                            <i class="fas fa-code"></i> Código:
                        </td>
                        <td>
                            <span class="badge-search"><?php echo $row['codigo']; ?></span>
                        </td>
                        <td class="label">
                            <i class="fas fa-graduation-cap"></i> Nombre:
                        </td>
                        <td colspan="3"><?php echo $row['nombre']; ?></td>
                        <td>
                            <a href="postgrados.php" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Resultados de Postgrados -->
    <?php if(mysqli_num_rows($result_postgrados) > 0): 
        $total_resultados += mysqli_num_rows($result_postgrados);
    ?>
    <div class="result-card fade-in-up">
        <h4><i class="fas fa-university"></i> Postgrados Encontrados</h4>
        <div class="table-responsive">
            <table class="result-table">
                <?php while($row = mysqli_fetch_assoc($result_postgrados)): ?>
                    <tr>
                        <td class="label">
                            <i class="fas fa-code"></i> Código:
                        </td>
                        <td>
                            <span class="badge-search"><?php echo $row['codigo']; ?></span>
                        </td>
                        <td class="label">
                            <i class="fas fa-university"></i> Nombre:
                        </td>
                        <td colspan="3"><?php echo $row['nombre']; ?></td>
                        <td>
                            <a href="postgrados.php" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Resumen de resultados -->
    <div class="alert alert-info" style="border-radius: 12px;">
        <i class="fas fa-chart-bar"></i>
        <strong>Total de resultados encontrados:</strong> <?php echo $total_resultados; ?> coincidencias
    </div>
    
<?php else: ?>
    <div class="no-results fade-in-up">
        <i class="fas fa-search"></i>
        <h4>No se encontraron resultados</h4>
        <p>No hay coincidencias para "<strong><?php echo htmlspecialchars($busqueda); ?></strong>"</p>
        <p>Sugerencias:</p>
        <ul style="list-style: none; padding: 0;">
            <li><i class="fas fa-check-circle" style="color: var(--turquoise-soft);"></i> Verifica que la cédula esté escrita correctamente</li>
            <li><i class="fas fa-check-circle" style="color: var(--turquoise-soft);"></i> Intenta con nombres o apellidos completos</li>
            <li><i class="fas fa-check-circle" style="color: var(--turquoise-soft);"></i> Usa solo números para buscar por cédula</li>
        </ul>
    </div>
<?php endif; ?>