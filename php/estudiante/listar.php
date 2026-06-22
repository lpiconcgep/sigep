<?php

include "php/conexion.php";
include "php/funciones.php";
include "php/utilidades.php";


$user_id=null;
$sql1= "select ep.*,ep.id estudiante_id,p.id persona_id,pr.nombre programa,e.nombre estatus,c.nombre condicion, pr.id as programa_id 
		from estudiante_programa ep INNER JOIN persona p ON ep.persona_id = p.id
									INNER JOIN programa pr ON ep.programa_id = pr.id
									INNER JOIN estatus_estudiante e ON ep.estatus_estudiante_id = e.id
									INNER JOIN condicion_estudiante c ON ep.condicion_estudiante_id = c.id
									where p.id = ".$_GET["id"]." ORDER BY ep.id ASC";
$query = $con->query($sql1);
?>

<?php if($query->num_rows>0):
$num = 0;?>
<table class="table table-bordered table-hover">
<thead>
	<th width="3%">N.</th>
	<th width="25%">Postgrado</th>
	<th width="10%">Condici&oacute;n</th>
	<!--th width="12%">Estatus</th-->
	<th width="20%">Fecha de Ingreso</th>
	<th width="15%">Fecha de Grado</th>
	<th width="15%">Fecha de Retiro</th>
	<th width="15%">Acciones</th>
</thead>
<?php while ($r=$query->fetch_array()):
$num++;?>
<tr>
	<td><?php echo $num;?></td>
	<td><?php echo $r["programa"]; ?></td>
	<td><?php echo $r["condicion"]; ?></td>
	<!--td><?php echo $r["estatus"] ?></td-->
	<td><?php echo transforma_fecha($r["fecha_ingreso"]) ?></td>
	<td><?php echo ($r["fecha_grado"] != '0000-00-00' and $r["fecha_grado"] != NULL) ?  transforma_fecha($r["fecha_grado"]) : "N/A"; ?></td>
	<td><?php echo ($r["fecha_retiro"] != '0000-00-00' and $r["fecha_retiro"] != NULL )?  transforma_fecha($r["fecha_retiro"]) : "N/A"; ?></td>
	<td style="width:150px;">
		<?php if($r['estatus_estudiante_id'] != 4) { ?>
			<a href="./php/estudiante/editar.php?estudiante_id=<?php echo $r["estudiante_id"];?>" title="Editar Estudio" class="btn btn-sm btn-warning"><span style="top: 0px;" class="glyphicon glyphicon-pencil"></span></a>
			<?php } if(1 == 2) 
			{ ?>
				<?php if(tiene_prorroga($_GET["id"],$r['programa_id'])) { ?>
					<a href="./php/estudiante/prorrogas.php?estudiante_id=<?php echo $r["estudiante_id"];?>" title="Prorrogas" class="btn btn-sm btn-success"><span style="top: 0px;" class="glyphicon glyphicon-time"></span></a>
				<?php } else { ?>
					<a title="No tiene Prorroga" href="./php/estudiante/prorrogas.php?estudiante_id=<?php echo $r["estudiante_id"];?>" class="btn btn-sm btn-danger"><span style="top: 0px;" class="glyphicon glyphicon-remove-sign"></span></a>
				<?php } 
			} ?>
			<?php if($_SESSION['user_id'] == 1 or $_SESSION['user_id'] == 8){ 
				
				?>
				<input id="estudiante_programa_id" value='<?php echo $r["estudiante_id"];?>' type="hidden" />
			<a href="./php/estudiante/movimientos.php?estudiante_programa_id=<?php echo $r["estudiante_id"];?>" title="Movimientos" class="btn btn-sm btn-success"><span style="top: 0px;" class="glyphicon glyphicon-random"></span></a>
			<?php
			} 
			if($_SESSION['user_id'] == 1){ 
			?> 

			<a id="generar_pdf" href="./generate_pdf.php?estudiante_programa_id=<?php echo $r["estudiante_id"];?>" title="Generar documentos de cierre" class="btn btn-sm btn-primary"><span style="top: 0px;" class="glyphicon glyphicon-forward"></span></a>
			<?php } ?>
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
			<?php if(1 == 2) { ?>
			<a href="estudios.php?id=<?php echo $r["estudiante_id"];?>" title="Expediente" class="btn btn-sm btn-primary"><span style="top: 0px;" class="glyphicon glyphicon-folder-open"></span></a>
		<?php } ?>
	</td>
</tr>
<?php endwhile;?>
</table>
<?php else:?>
	<p class="alert alert-warning">No tiene prostgrados inscritos</p>
<?php endif;?>
