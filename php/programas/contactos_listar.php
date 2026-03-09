<?php

include "../../php/conexion.php";

  $user_id=null;
  $sql1 = "SELECT p.*,t.nombre as cargo FROM personal p
  		   INNER JOIN tipo_cargo t ON p.tipo_cargo_id = t.id
  		   INNER JOIN programa pr ON p.programa_id = pr.id
   		   WHERE pr.id = ".$_GET["programa_id"];

  $query1 = $con->query($sql1);


?>

<?php if($query1->num_rows>0):
$numero = 0;?>
<table class="table table-bordered table-hover">
<thead>
	<th width="3%">N.</th>
	<th width="15%">Nombre</th>
	<th width="12%">Cargo</th>
	<th width="15%">Emails</th>
	<th width="30%">Tel&eacute;fonos</th>
	<!-- th width="10%"></th-->
</thead>
<?php while ($r=$query1->fetch_array()):
  $numero++;
  
  $sql2 = "SELECT * FROM emails WHERE personal_id = ".$r["id"];
  $query2 = $con->query($sql2);

  $sql3 = "SELECT * FROM telefonos WHERE personal_id = ".$r["id"];
  $query3 = $con->query($sql3);

?>
<tr>
	<td><?php echo $numero; ?></td>
	<td><?php echo strtoupper($r["apellidos"])."  ".strtoupper($r["nombres"]); ?></td>
	<td><?php echo $r["cargo"]; ?></td>
	<td>
		<?php if($query2->num_rows>0): ?>
		<table style="font-size: 11px">
			<?php while ($r2=$query2->fetch_array()): ?>
				<tr><td><?php echo $r2['email']?></td></tr>
			<?php endwhile; ?>
			<tr><td><a data-toggle="modal" href="#myModalEmail_<?php echo $r['id'] ?>" title="Agregar Email" class="btn btn-sm btn-primary btn-sm btn_add_email"> <span style="top: 0px;" class="glyphicon glyphicon-envelope"></span></a></td></tr>
		</table>
		<?php else: ?>
			<table>
				<tr>
					<td><p style="font-size: 10px" class="alert alert-warning">No tiene emails registrados</p></td>
					<td><a data-toggle="modal" href="#myModalEmail_<?php echo $r['id'] ?>" title="Agregar Email" class="btn btn-sm btn-primary btn-sm btn_add_email"> <span style="top: 0px;" class="glyphicon glyphicon-envelope"></span></a></td>
				</tr>
			</table>
		<?php endif; ?>
		<div class="modal fade" id="myModalEmail_<?php echo $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		          <h4 class="modal-title">Agregar Email</h4>
		        </div>
		        <div class="modal-body">
		            <form role="form" method="post" action="agregar_email.php">
					  <div class="form-group">
					    <label for="nombre">Email <span style='color: red'>*</span></label>
					    <div class="col-sm-12">
						    <input type="email" class="form-control" name="email" required>
						</div>
					  </div>
					  <input type="hidden" name="personal_id" value="<?php echo $r["id"]; ?>">  
					  <input type="hidden" name="programa_id" value="<?php echo $_GET["programa_id"]; ?>">
					  
					  <button type="submit" class="btn btn-primary">Agregar</button>
					</form>
		        </div>

		      </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</td>
	<td>
		<?php if($query3->num_rows>0): 
		$cont = 0;?>
		<table style="font-size: 11px">
			<tr><?php while ($r3=$query3->fetch_array()):
				$cont++; ?>
				<td><?php echo $r3['numero'];?></td>
				<?php if($cont%3 == 0) {?>
					</tr><tr>
				<?php }
				 ?>
			<?php endwhile; ?>
			</tr>
			<td><a data-toggle="modal" href="#myModalPhone_<?php echo $r['id'] ?>" title="Agregar Telefono" class="btn btn-sm btn-warning btn-sm btn_add_email"> <span style="top: 0px;" class="glyphicon glyphicon-phone-alt"></span></a></td>
			<tr></tr>
		</table>
		<?php else: ?>
		<table>
			<tr>
				<td><p style="font-size: 10px" class="alert alert-warning">No tiene telefonos registrados</p></td> 
				<td><a data-toggle="modal" href="#myModalPhone_<?php echo $r['id'] ?>" title="Agregar Telefono" class="btn btn-sm btn-warning btn-sm btn_add_email"> <span style="top: 0px;" class="glyphicon glyphicon-phone-alt"></span></a></td>
			</tr>
		</table>
		<?php endif; ?>
		<div class="modal fade" id="myModalPhone_<?php echo $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		          <h4 class="modal-title">Agregar Telef&oacute;no</h4>
		        </div>
		        <div class="modal-body">
		            <div>
			            <form role="form" method="post" action="agregar_telefono.php">
						  <div class="form-group">
						    <label for="nombre">Numero de Tel&eacute;fono <span style='color: red'>*</span></label>
						    <div class="col-sm-12">
							    <div class="col-sm-4">
							    	<select class="form-control" name="codigo">
								      <option value="0274">0274</option>
								      <option value="0272">0272</option>
								      <option value="0276">0276</option>
								      <option value="0412">0412</option>
								      <option value="0416">0416</option>
								      <option value="0426">0426</option>
								      <option value="0414">0414</option>
								      <option value="0424">0424</option>
								    </select>
							    </div>
							    <div class="col-sm-8">
							    	<input type="text" class="form-control" name="numero" required>
							    </div>
							</div>
						  </div>
						  <input type="hidden" name="personal_id" value="<?php echo $r["id"]; ?>">  
						  <input type="hidden" name="programa_id" value="<?php echo $_GET["programa_id"]; ?>">
						  <br><br>
						  <button type="submit" class="btn btn-primary">Agregar</button>
						</form>
					</div>
		        </div>

		      </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</td>
	<td style="width:150px; display: none">
		<a data-toggle="modal" href="#myModal_<?php echo $r['id'] ?>" title="Agregar Telefono" class="btn btn-sm btn-success btn-sm"> <span style="top: 0px;" class="glyphicon glyphicon-pencil"></span></a>
		<div class="modal fade" id="myModal_<?php echo $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		          <h4 class="modal-title">Editar contacto</h4>
		        </div>
		        <div class="modal-body">
		        	<?php $postgrado_id = $r['postgrado_id']; ?>
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
	<p class="alert alert-warning">No tiene personal registrado</p>
<?php endif;?>


