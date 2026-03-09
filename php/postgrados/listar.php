<?php
include "./php/conexion.php";
//include "./php/funciones.php";

ini_set('display_errors',0);
 
// consulta con filtro
if (isset($_GET['facultad']) && $_GET['facultad'] !== '')
    $lista_postg_facultad = consultar_postgrados(intval($_GET['facultad']));
else
    $lista_postg_facultad = consultar_postgrados();

if(count($lista_postg_facultad)>0): ?>
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
foreach ($lista_postg_facultad as $postgrado) {

    $r = (array) $postgrado;
    $num++;
    $facultad = (array) consultar_facultades($r['facultad_nucleo_id']);
    $programas = get_cantidad_programas($r["id"], 'postgrados');
    ?>
    <tr>
        <td><?php echo $num;?></td>
        <td><?php echo strtoupper($facultad['nombre']); ?></td>
        <td><?php echo strtoupper($r["nombre"]); ?></td>
        <td><?php echo $programas; ?></td>
        <td style="width:150px;">
            <a href="./php/postgrados/programas.php?postgrado_id=<?php echo $r["id"];?>" class="btn btn-sm btn-success">Ver Programas</a>
        </td>
    </tr>
    <?php }?>
</table>
<?php else:?>
    <p class="alert alert-warning">No hay resultados</p>
<?php endif; ?>
