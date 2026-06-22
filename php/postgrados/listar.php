<?php
// php/postgrados/listar.php - VERSIÓN CON DATATABLES

include "./php/conexion.php";

ini_set('display_errors',0);


// Consulta SQL directa
if (isset($_GET['facultad']) && $_GET['facultad'] !== '') {
    $facultad_id = intval($_GET['facultad']);
    $sql = "SELECT p.*, f.nombre as facultad_nombre 
            FROM postgrado p
            LEFT JOIN facultad_nucleo f ON p.facultad_nucleo_id = f.id
            WHERE p.facultad_nucleo_id = $facultad_id
            ORDER BY p.nombre ASC";
} else {
    $sql = "SELECT p.*, f.nombre as facultad_nombre 
            FROM postgrado p
            LEFT JOIN facultad_nucleo f ON p.facultad_nucleo_id = f.id
            ORDER BY p.nombre ASC";
}

$result = mysqli_query($con, $sql);

if(!$result) {
    echo '<div class="alert alert-danger">Error SQL: ' . mysqli_error($con) . '</div>';
} else {
    $num_rows = mysqli_num_rows($result);
    
    if($num_rows > 0): ?>
    <div class="table-responsive">
        <table id="table_postgrado" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th class="text-center">Facultad</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $num = 0;
            while($row = mysqli_fetch_assoc($result)) {
                $num++;
                ?>
                <tr>
                    <td class="text-center"><?php echo $num; ?></td>
                    <td class="text-center"><?php echo strtoupper($row['facultad_nombre'] ?: 'SIN FACULTAD'); ?></td>
                    <td><?php echo strtoupper($row['nombre']); ?></td>
                    <td class="text-center">
                        <a href="./php/postgrados/programas.php?postgrado_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Ver Programas
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> No hay postgrados registrados en la base de datos.
        </div>
    <?php endif;
} ?>

