<?php
include "./php/conexion.php";
ini_set('display_errors',0);

// Construir consulta con filtro
$sql1 = "SELECT p.id AS id, f.nombre AS facultad, p.nombre AS postgrado 
         FROM postgrado p 
         INNER JOIN facultad_nucleo f ON p.facultad_nucleo_id = f.id";

// Si se seleccionó una facultad, añadir condición
if (isset($_GET['facultad']) && $_GET['facultad'] !== '') {
    $facultad_id = intval($_GET['facultad']);
    $sql1 .= " WHERE f.id = $facultad_id";
}

$query1 = $con->query($sql1);
?>

<?php if($query1->num_rows>0):?>
<table class="table table-bordered table-hover">
<thead>
    <th>N.</th>
    <th>Facultad</th>
    <th>Nombre</th>
    <th>Cantidad Programas</th>
    <th></th>
</thead>
<?php
$num = 0;
while ($r=$query1->fetch_array()):
$num++;
// contar programas asociados al posgrado
$sql_p= "SELECT COUNT(*) as cantidad FROM programa WHERE postgrado_id = ".$r["id"];
$query_p = $con->query($sql_p);
$programas = $query_p->fetch_object();
?>
<tr>
    <td><?php echo $num;?></td>
    <td><?php echo strtoupper($r["facultad"]); ?></td>
    <td><?php echo strtoupper($r["postgrado"]); ?></td>
    <td><?php echo $programas->cantidad; ?></td>
    <td style="width:150px;">
        <a href="./php/postgrados/programas.php?postgrado_id=<?php echo $r["id"];?>" class="btn btn-sm btn-success">Ver Programas</a>
    </td>
</tr>
<?php endwhile;?>
</table>
<?php else:?>
    <p class="alert alert-warning">No hay resultados</p>
<?php endif;?>
