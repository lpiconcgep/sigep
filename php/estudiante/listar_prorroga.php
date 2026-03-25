<script src="/sigep_prototipo/js/jquery.min.js"></script>
<?php

include "../../php/conexion.php";


ini_set('display_errors',1);

$sql_e= "select e.id as extension_id,p.*,e.* from extension_plazos e 
		INNER JOIN estatus_prorroga p ON e.estatus_prorroga_id = p.id
		WHERE e.estudiante_programa_id=".$_GET["estudiante_id"];
$query_e = $con->query($sql_e);

?>

<?php if($query_e->num_rows>0):?>
<table class="table table-bordered table-hover">
<thead>
	<th width="5%">N.</th>
	<th width="15%">Fecha Solicitud</th>
	<th width="35%">Motivo Estudiante</th>
	<th width="35%">Decisi&oacute;n CEP</th>
	<th width="5%">Estatus</th>
	<th width="5%"></th>
</thead>
<?php
$num = 0;
while ($r_e=$query_e->fetch_array())
{
	$num++;

	?>
	<tr>
		<td><?php echo $num;?></td>
		<td><?php echo $r_e['fecha_solicitud']; ?></td>
		<td><?php echo $r_e['motivo_estudiante']; ?></td>
		<td><?php echo $r_e['decision_cep']; ?></td>
		<td><?php echo $r_e['nombre']; ?></td>
		
		<td style="width:150px;">
			<!--a href="../../matricula.php?programa_id=<?php echo $r["extension_id"];?>" class="btn btn-sm btn-primary"><span style="top: 0px;" class="glyphicon glyphicon-search"></span></a-->
			
			<a data-toggle="modal" href="#myModal_<?php echo $r_e['extension_id'] ?>" title="Ver Prorroga" class="btn btn-sm btn-primary btn-sm"> <span style="top: 0px;" class="glyphicon glyphicon-search"></span></a>
			
			<div class="modal fade" id="myModal_<?php echo $r_e['extension_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			          <h4 class="modal-title">Ver Prorroga</h4>
			        </div>
			        <div class="modal-body">
			        	<?php $extension_id = $r_e['extension_id']; ?>
			            <?php include "prorroga_view.php";?>
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
			<!--a href="estudios.php?id=<?php echo $r["id"];?>" class="btn btn-sm btn-primary">Estudios</a-->

		</td>
	</tr>
<?php } ?>
</table>
<?php else:?>
	<br><br>
	<p class="alert alert-warning">No posee extensi&oacute;n de plazos registradas</p>
<?php endif;?>
