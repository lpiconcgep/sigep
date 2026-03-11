<?php

include "./php/conexion.php";

$user_id=null;
$sql1= "select * from persona where primer_apellido like '%$_GET[s]%' or segundo_apellido like '%$_GET[s]%' or primer_nombre like '%$_GET[s]%' or segundo_nombre like '%$_GET[s]%'  or documento_identidad like '%$_GET[s]%' or pasaporte like '%$_GET[s]%' ";
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
	<td><?php echo $r["primer_apellido"]." ".$r["segundo_apellido"];; ?></td>
	<td><?php echo $r["primer_nombre"]." ".$r["segundo_nombre"]; ?></td>
	<td><?php echo $r["sexo"]; ?></td>
	<td style="width:150px;">
		<!--a href="./editar.php?id=<?php echo $r["id"];?>" class="btn btn-sm btn-warning">Editar</a-->
		<a href="./php/personas/editar.php?sour=edit&s=<?php echo $_GET['s'];?>&id=<?php echo $r["id"];?>" class="btn btn-sm btn-warning">Editar</a>
		<a href="estudios.php?s=<?php echo $_GET['s'];?>&id=<?php echo $r["id"];?>" class="btn btn-sm btn-primary">Estudios</a>

		<!--a href="#" id="del-<?php echo $r["id"];?>" class="btn btn-sm btn-danger">Eliminar</a-->
		<!--script>
>>>>>>> 24861cc2950c10fe5a8d8e9a1af9bbdbeff45c07
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
	<p class="alert alert-warning">No hay resultados</p>
<?php endif;?>
