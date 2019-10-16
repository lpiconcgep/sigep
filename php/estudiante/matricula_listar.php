<?php

include "php/conexion.php";
include "php/funciones.php";
ini_set('display_errors',1);

  $user_id=null;

  if(isset($_GET) && isset($_GET['tipo']))
  {
  	if($_GET['tipo'] != '999')
  	{
  		$aux = " AND c.id = ".$_GET['tipo'];	
  		$aux_inner_2 = '';
  		$cad = "";
  	}
  	else
  	{
  		$aux = '';
  		$aux_inner_2 = " INNER JOIN extension_plazos ex ON ex.estudiante_programa_id = ep.id ";
  		$cad = ",ex.*";
  	}

  	if($_GET['tipo'] == 1)
  		$condicion = "Activo";
  	elseif($_GET['tipo'] == 2)
  		$condicion = "Egresados";
  		elseif($_GET['tipo'] == 5)
  			$condicion = "Retirados";
  			elseif($_GET['tipo'] == 6)
  				$condicion = "Desincoporados";
  				elseif($_GET['tipo'] == 3)
  					$condicion = "Inactivos";
  					else
  						$condicion = "Extensión de Plazos";
  }
  else
  	$aux = '';

  $sql1 = "select ep.*,p.*,ep.id estudiante_id,p.id persona_id,pr.nombre programa,e.nombre estatus,c.nombre condicion,pr.id as programa_id {$cad}
          from estudiante_programa ep LEFT JOIN persona p ON ep.persona_id = p.id
          LEFT JOIN programa pr ON ep.programa_id = pr.id
          LEFT JOIN estatus_estudiante e ON ep.estatus_estudiante_id = e.id
          LEFT JOIN condicion_estudiante c ON ep.condicion_estudiante_id = c.id ".
          $aux_inner_2."
          WHERE ep.programa_id = ".$_GET["programa_id"]."".$aux;

 
  $query1 = $con->query($sql1);
  $cantidad = $query1->num_rows;

  echo "CONDICI&Oacute;N: ".strtoupper(utf8_decode($condicion))." | CANTIDAD: ".$cantidad."<br /><br />";
?>

<?php if($query1->num_rows>0):
$num = 0;?>
<table class="table table-bordered table-hover">
<thead>
	<th width="3%">N.</th>
	<th width="25%">Nombre Estudiante</th>
	<th width="10%">Condici&oacute;n</th>
	<th width="12%">Estatus</th>
	<?php if(isset($_GET) && (($_GET['tipo'] == 1) || ($_GET['tipo'] == 3))) { ?>
		<th width="20%">Fecha de Ingreso</th>
	<?php } 
	 if(isset($_GET) && ($_GET['tipo'] == 2)) { ?>
		<th width="20%">Fecha de Egreso</th>
	<?php } 
	 if(isset($_GET) && ($_GET['tipo'] == 5)) { ?>
		<th width="20%">Fecha de Retiro</th>
	<?php } 
	 if(isset($_GET) && ($_GET['tipo'] == 6)) { ?>
		<th width="20%">Fecha de Desincorporaci&oacute;n</th>
	<?php } ?>

	<th width="15%">Cohorte</th>
	<th width="15%">Prorrogas / Expediente</th>
</thead>
<?php while ($r=$query1->fetch_array()):
$num++;?>
<tr>
	<td><?php echo $num;?></td>
	<td><?php echo strtoupper($r["primer_apellido"])." ".strtoupper($r["segundo_apellido"])." ".strtoupper($r["primer_nombre"])." ".strtoupper($r["segundo_nombre"]); ?></td>
	<td><?php echo $r["condicion"]; ?></td>
	<td><?php echo $r["estatus"] ?></td>

	<?php if(isset($_GET) && (($_GET['tipo'] == 1) || ($_GET['tipo'] == 3))) { ?>
		<td><?php echo $r["fecha_ingreso"] ?></td>
	<?php } 
	 if(isset($_GET) && ($_GET['tipo'] == 2)) { ?>
		<td><?php echo $r["fecha_egreso"] ?></td>
	<?php } 
	 if(isset($_GET) && ($_GET['tipo'] == 5)) { ?>
		<td><?php echo $r["fecha_retiro"] ?></td>
	<?php } 
	 if(isset($_GET) && ($_GET['tipo'] == 6)) { ?>
		<td><?php echo $r["fecha_desincorporacion"] ?></td>
	<?php } ?>

	<td><?php echo $r["anio_cohorte"] ?></td>
	<td style="width:150px;">
		<!--a href="php/personas/editar.php?id=<?php echo $r["persona_id"];?>&origen=matricula&programa_id=<?php echo $_GET["programa_id"];?>" class="btn btn-sm btn-warning">Editar</a>
		<a href="./php/estudiante/ver_prorroga.php?estudiante_id=<?php echo $r["estudiante_id"];?>" title="Agregar Prorrogas" class="btn btn-sm btn-success"> + </a>
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
		<!--a href="estudios.php?id=<?php echo $r["estudiante_id"];?>" title="Expediente" class="btn btn-sm btn-primary">#</a-->
		<a href="./php/estudiante/editar.php?estudiante_id=<?php echo $r["estudiante_id"];?>" title="Agregar Estudios" class="btn btn-sm btn-warning"><span style="top: 0px;" class="glyphicon glyphicon-pencil"></span></a>
		<?php if(tiene_prorroga($r["persona_id"],$r['programa_id'])) { ?>
			<a href="./php/estudiante/prorrogas.php?estudiante_id=<?php echo $r["estudiante_id"];?>&source=<?php echo $source; ?>" title="Prorrogas" class="btn btn-sm btn-success"><span style="top: 0px;" class="glyphicon glyphicon-time"></span></a>
		<?php } else { ?>
			<a title="No tiene Prorroga" href="./php/estudiante/prorrogas.php?estudiante_id=<?php echo $r["estudiante_id"];?>&source=<?php echo $source; ?>" class="btn btn-sm btn-danger"><span style="top: 0px;" class="glyphicon glyphicon-remove-sign"></span></a>
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
		<a href="estudios.php?id=<?php echo $r["estudiante_id"];?>" title="Expediente" class="btn btn-sm btn-primary"><span style="top: 0px;" class="glyphicon glyphicon-folder-open"></span></a>

	</td>
</tr>
<?php endwhile;?>
</table>
<?php else:?>
	<p class="alert alert-warning">No tiene estudiantes registrados</p>
<?php endif;?>
