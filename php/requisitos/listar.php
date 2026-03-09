<?php

include "./php/conexion.php";

ini_set('display_errors',1);

$user_id=null;
$sql1= "select * from requisitos";
$query1 = $con->query($sql1);

$sql2 = "SELECT * FROM grado_academico";
$query2 = $con->query($sql2);

$sql3 = "SELECT * FROM facultad_nucleo";
$query3 = $con->query($sql3);

$sql4 = "SELECT * FROM postgrado";
$query4 = $con->query($sql4);

?>

<?php if($query1->num_rows>0):?>
<table class="table table-bordered table-hover">
<thead>
	<th>Posición</th>
	<th>Nombre</th>
	<th>Obligatorio</th>
	<th>Tipo</th>
	<th></th>
</thead>
<?php
$num = 0;
while ($r=$query1->fetch_array()):
$num++;

?>
<tr>
	<td><?php echo $r["posicion"];?></td>
	<td><?php echo strtoupper($r["nombre"]); ?></td>
	<td><?php echo $r["obligatorio"]; ?></td>
	<td><?php echo $r["tipo"]; ?></td>
	
	<td style="width:150px;">
		<a data-toggle="modal" href="#myModal_<?php echo $r['id'] ?>" title="Configurar requisito" class="btn btn-sm btn-success btn-sm"> <span style="top: 0px;" class="glyphicon glyphicon-cog"></span></a>
		<div class="modal fade" id="myModal_<?php echo $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		          <h4 class="modal-title">Configurar Requisito: <strong><?=$r["nombre"]?></strong></h4>
		        </div>
		        <div class="modal-body">
		            <?php include "setting_requisito.php";?>
		        </div>

		      </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</td>
</tr>
<?php endwhile;?>
</table>
<?php else:?>
	<p class="alert alert-warning">No hay resultados</p>
<?php endif;?>
