<?php
// php/personas/listar.php - CON PAGINACIÓN EN PHP

include "./php/conexion.php";

ini_set('display_errors',0);

// Obtener el número de página actual
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 20; // Registros por página
$offset = ($page - 1) * $limit;

// Contar el total de registros
$count_sql = "SELECT COUNT(*) as total FROM persona";
$count_result = $con->query($count_sql);
$total_registros = 0;
if ($count_result) {
    $total_row = $count_result->fetch_assoc();
    $total_registros = $total_row['total'];
}
$total_paginas = ceil($total_registros / $limit);

// Consulta con LIMIT para cargar solo los registros de la página actual
$sql1 = "SELECT * FROM persona ORDER BY id DESC LIMIT $offset, $limit";
$query = $con->query($sql1);
?>

<?php if($query && $query->num_rows > 0): ?>


<div class="table-responsive">
    <table id="table_personas" class="table table-personas table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">Cédula</th>
                <th class="text-center">Apellidos</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">Sexo</th>
                <th class="text-center" style="min-width: 200px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($r = $query->fetch_array()): ?>
            <tr>
                <td class="text-center">
                    <span class="badge-documento">
                        <i class="fas fa-id-card"></i> <?php echo $r["nacionalidad"] . " - " . $r["documento_identidad"]; ?>
                    </span>
                </td>
                <td><?php echo strtoupper($r["primer_apellido"]) . " " . strtoupper($r["segundo_apellido"]); ?></td>
                <td><?php echo strtoupper($r["primer_nombre"]) . " " . strtoupper($r["segundo_nombre"]); ?></td>
                <td class="text-center">
                    <?php 
                    if($r["sexo"] == 'M') {
                        echo '<span class="label label-primary">Masculino</span>';
                    } else if($r["sexo"] == 'F') {
                        echo '<span class="label label-danger">Femenino</span>';
                    } else {
                        echo '<span class="label label-default">No especificado</span>';
                    }
                    ?>
                </td>
                <td class="text-center" style="min-width: 200px;">
                    <a href="./php/personas/editar.php?sour=list&id=<?php echo $r["id"]; ?>" 
                       class="btn btn-warning btn-sm" 
                       title="Editar persona">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="estudios.php?sour=list&id=<?php echo $r["id"]; ?>" 
                       class="btn btn-primary btn-sm" 
                       title="Ver estudios">
                        <i class="fas fa-graduation-cap"></i> Estudios
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <!-- Paginación manual -->
    <?php if($total_paginas > 1): ?>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-6">
            <p style="font-size: 14px; color: #666;">
                Mostrando <?php echo $offset + 1; ?> - <?php echo min($offset + $limit, $total_registros); ?> de <?php echo $total_registros; ?> registros
            </p>
        </div>
        <div class="col-md-6 text-right">
            <ul class="pagination" style="margin: 0;">
                <?php if($page > 1): ?>
                    <li><a href="?page=<?php echo $page-1; ?>">&laquo; Anterior</a></li>
                <?php endif; ?>
                
                <?php 
                $start_page = max(1, $page - 2);
                $end_page = min($total_paginas, $page + 2);
                
                if($start_page > 1): ?>
                    <li><a href="?page=1">1</a></li>
                    <?php if($start_page > 2): ?>
                        <li class="disabled"><span>...</span></li>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php for($i = $start_page; $i <= $end_page; $i++): ?>
                    <li class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                
                <?php if($end_page < $total_paginas): ?>
                    <?php if($end_page < $total_paginas - 1): ?>
                        <li class="disabled"><span>...</span></li>
                    <?php endif; ?>
                    <li><a href="?page=<?php echo $total_paginas; ?>"><?php echo $total_paginas; ?></a></li>
                <?php endif; ?>
                
                <?php if($page < $total_paginas): ?>
                    <li><a href="?page=<?php echo $page+1; ?>">Siguiente &raquo;</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php else: ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> No hay personas registradas en el sistema.
    </div>
<?php endif; ?>
