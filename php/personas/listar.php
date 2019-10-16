<?php

include "./php/conexion.php";

ini_set('display_errors',0);

$user_id=null;
$sql1= "select * from persona ORDER BY id DESC";
$query = $con->query($sql1);
?>

<?php if($query->num_rows>0):?>
<table class="table table-bordered table-hover">
<thead>
	<th>Ced. Identidad</th>
	<th>Apellidos</th>
	<th>Nombres</th>
	<th>Sexo</th>
	
	<th></th>
</thead>
<?php while ($r=$query->fetch_array()):?>
<tr>
	<td><?php echo $r["nacionalidad"]." - ".$r["documento_identidad"]; ?></td>
	<td><?php echo strtoupper($r["primer_apellido"])." ".strtoupper($r["segundo_apellido"]); ?></td>
	<td><?php echo strtoupper($r["primer_nombre"])." ".strtoupper($r["segundo_nombre"]); ?></td>
	<td><?php echo $r["sexo"]; ?></td>
	
	<td style="width:150px;">
		<a href="./php/personas/editar.php?id=<?php echo $r["id"];?>" class="btn btn-sm btn-warning">Editar</a>
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
		<a href="estudios.php?id=<?php echo $r["id"];?>" class="btn btn-sm btn-primary">Estudios</a>

	</td>
</tr>
<?php endwhile;?>
</table>
<?php else:?>
	<p class="alert alert-warning">No hay resultados</p>
<?php endif;?>
