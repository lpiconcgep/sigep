<?php
// php/personas/listar.php

include "./php/conexion.php";

ini_set('display_errors',0);

$sql1 = "SELECT * FROM persona ORDER BY id DESC";
$query = $con->query($sql1);
?>

<?php if($query->num_rows > 0): ?>

<div class="table-responsive">
    <table id="table_personas" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">Ced. Identidad</th>
                <th class="text-center">Apellidos</th>
                <th class="text-center">Nombres</th>
                <th class="text-center">Sexo</th>
                <th class="text-center" style="width: 160px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($r = $query->fetch_array()): ?>
            <tr>
                <td class="text-center"><?php echo $r["nacionalidad"] . " - " . $r["documento_identidad"]; ?></td>
                <td><?php echo strtoupper($r["primer_apellido"]) . " " . strtoupper($r["segundo_apellido"]); ?></td>
                <td><?php echo strtoupper($r["primer_nombre"]) . " " . strtoupper($r["segundo_nombre"]); ?></td>
                <td class="text-center"><?php echo $r["sexo"]; ?></td>
                <td class="text-center" style="white-space: nowrap;">
                    <!-- BOTONES ORIGINALES - MISMO COLOR Y FORMA -->
                    <a href="./php/personas/editar.php?sour=list&id=<?php echo $r["id"]; ?>" 
                       class="btn btn-sm btn-warning" 
                       style="margin-right: 5px;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="estudios.php?sour=list&id=<?php echo $r["id"]; ?>" 
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-graduation-cap"></i> Estudios
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
    <div class="alert alert-warning" style="border-radius: 8px;">
        <i class="fas fa-exclamation-triangle"></i> No hay resultados
    </div>
<?php endif; ?>