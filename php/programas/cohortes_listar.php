<?php

include "../../php/conexion.php";

  $user_id=null;
  $sql1 = "SELECT * FROM cohorte WHERE programa_id = ".$_GET["programa_id"];
  $query1 = $con->query($sql1);


?>

<?php if($query1->num_rows>0):?>
<table class="table table-bordered table-hover">
<thead>
	<th width="3%">N.</th>
	<th width="15%">Nombre</th>
	<th width="12%">A&ntilde;o</th>
	<th width="15%">Fecha Inicio</th>
	<th width="15%">Fecha Fin</th>
	<th width="30%">Periodos Acad&eacute;micos</th>
	<th width="10%"></th>
</thead>
<?php while ($r=$query1->fetch_array()):
  $sql2 = "SELECT * FROM periodo_academico WHERE cohorte_id = ".$r["id"];
  $query2 = $con->query($sql2);
?>
<tr>
	<td><?php echo $r['numero'] ?></td>
	<td><?php echo strtoupper($r["nombre"]); ?></td>
	<td><?php echo $r["anio"]; ?></td>
	<td><?php echo $r["fecha_inicio"] ?></td>
	<td><?php echo $r["fecha_fin"] ?></td>
	<td>
		<?php if($query2->num_rows>0): ?>
		<table style="font-size: 11px">
			<?php while ($r2=$query2->fetch_array()): ?>
				<tr><td><?php echo $r2['nombre']?></td><td><?php echo $r2['fecha_inicio']?></td><td><?php echo $r2['fecha_fin']?></td></tr>
			<?php endwhile; ?>
		</table>
		<?php else: ?>
			<p style="font-size: 10px" class="alert alert-warning">No tiene periodos registrados</p>
		<?php endif; ?>
	</td>
	<td style="width:150px;">
		<a data-toggle="modal" href="#myModal_<?php echo $r['id'] ?>" title="Agregar Periodo" class="btn btn-sm btn-success btn-sm btn_add_periodo"> <span style="top: 0px;" class="glyphicon glyphicon-plus"></span></a>
		<div class="modal fade" id="myModal_<?php echo $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		          <h4 class="modal-title">Agregar Periodo</h4>
		        </div>
		        <div class="modal-body">
		            <?php include "periodo_form.php";?>
		        </div>

		      </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- a href="#" id="del-<?php echo $r["id"];?>" class="btn btn-sm btn-danger">Eliminar</a>
		<script>
		$("#del-"+<?php echo $r["id"];?>).click(function(e){
			e.preventDefault();
			p = confirm("Estas seguro?");
			if(p){
				window.location="./php/eliminar.php?id="+<?php echo $r["id"];?>;

			}

		});
		</script-->
	</td>
</tr>
<?php endwhile;?>
</table>
<?php else:?>
	<p class="alert alert-warning">No tiene cohortes registradas</p>
<?php endif;?>


