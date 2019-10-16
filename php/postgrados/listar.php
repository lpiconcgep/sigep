<?php

include "./php/conexion.php";

ini_set('display_errors',0);

$user_id=null;
$sql1= "select p.id as id, f.nombre as facultad, p.nombre as postgrado from postgrado p INNER JOIN facultad_nucleo f ON p.facultad_nucleo_id = f.id";
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
$programas=null;
  $sql_p= "select count(*) as cantidad from programa where postgrado_id = ".$r["id"];
  $query_p = $con->query($sql_p);
  if($query_p->num_rows>0){
	while ($r1=$query_p->fetch_object()){
	  $programas=$r1;
	  break;
	  }
	}
?>
<tr>
	<td><?php echo $num;?></td>
	<td><?php echo strtoupper($r["facultad"]); ?></td>
	<td><?php echo strtoupper($r["postgrado"]); ?></td>
	<td><?php echo $programas->cantidad; ?></td>
	
	<td style="width:150px;">
		<a href="./php/postgrados/programas.php?postgrado_id=<?php echo $r["id"];?>" class="btn btn-sm btn-success">Ver Programas</a>
		
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
<?php endwhile;?>
</table>
<?php else:?>
	<p class="alert alert-warning">No hay resultados</p>
<?php endif;?>
