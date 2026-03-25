<?php

include "../../php/conexion.php";

ini_set('display_errors',0);

$user_id=null;
$sql1= "select * FROM programa WHERE postgrado_id = ".$_GET["postgrado_id"];
$query1 = $con->query($sql1);

?>

<?php if($query1->num_rows>0):?>
<table class="table table-bordered table-hover">
<thead>
	<th width="5%">N.</th>
	<th width="45%">Nombre</th>
	<th width="20%">Cantidad Inscritos</th>
	
	<th width="20%"></th>
</thead>
<?php
$num = 0;
while ($r=$query1->fetch_array()):
$num++;
$programas=null;
  $sql_p= "select count(*) as cantidad from estudiante_programa where programa_id = ".$r["id"];
  $query_p = $con->query($sql_p);
  if($query_p->num_rows>0){
	while ($r1=$query_p->fetch_object()){
	  $inscritos=$r1;
	  break;
	  }
	}
?>
<tr>
	<td><?php echo $num;?></td>
	<td><?php echo strtoupper($r["nombre"]); ?></td>
	<td><?php echo $inscritos->cantidad; ?></td>
	
	<td style="width:150px;">
		<a href="../../matricula.php?programa_id=<?php echo $r["id"];?>" class="btn btn-sm btn-primary"><span style="top: 0px;" class="glyphicon glyphicon-user"></span></a>
		<a href="../programas/cohortes.php?programa_id=<?php echo $r["id"];?>" class="btn btn-sm btn-success"><span style="top: 0px;" class="glyphicon glyphicon-th-list">Cohortes</span></a>
		<a href="../programas/datos_contactos.php?programa_id=<?php echo $r["id"];?>" class="btn btn-sm btn-warning" title="Datos Personal"><span style="top: 0px;" class="glyphicon glyphicon-phone-alt">&nbsp;<span style="top: 0px;" class="glyphicon glyphicon-envelope"></span></a>
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
