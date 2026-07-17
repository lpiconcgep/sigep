<script src="/sigep_prototipo/js/jquery.min.js"></script>
<?php

include "../../php/conexion.php";
include "../../php/utilidades.php";
include "../../php/funciones.php";


ini_set('display_errors',1);

$sql_motivos= "select * from motivo_retiro";
$query_motivos = $con->query($sql_motivos);

$sql_e= "select d.id d_id, m.*,d.*,t.nombre tipo, t.id as tipo_id, m.created_at as fecha_creacion from movimiento_estudiante m
		INNER JOIN tipo_movimiento t ON m.tipo_movimiento_id = t.id
		LEFT JOIN descripcion_movimiento d ON d.movimiento_estudiante_id = m.id
		LEFT JOIN motivo_retiro r ON d.motivo_retiro_id = r.id
		WHERE m.estudiante_programa_id=".$_GET["estudiante_programa_id"];

$query_e = $con->query($sql_e);

?>

<?php if($query_e->num_rows>0):?>
<table class="table table-bordered table-hover">
<thead>
	<th width="5%">N.</th>
	<th width="15%">Movimiento</th>
	<th width="15%">Fecha de registro</th>
	<th width="40%">Observaciones</th>
	<th width="5%"></th>
</thead>
<?php
$num = 0;
while ($r_e=$query_e->fetch_array())
{
	$num++;
	$observaciones = $r_e['observaciones'];
	$tipo_mov = $r_e['tipo_id'];

	if ($tipo_mov == "1"){
		$observaciones = $r_e['observaciones_expediente'] != '' ? $r_e['observaciones_expediente'] : $observaciones;
	}
	elseif ($tipo_mov == "2") {
		$observaciones = $r_e['observaciones_cierre'] != '' ? $r_e['observaciones_cierre'] : $observaciones;
	}
	elseif ($tipo_mov == "3") {
		$observaciones = $r_e['descripcion_motivo_retiro'] != '' ? $r_e['descripcion_motivo_retiro'] : $observaciones;
	}
	else
		$observaciones = $r_e['observaciones_equivalencia'] != '' ? $r_e['observaciones_equivalencia'] : $observaciones;
	?>
	<tr>
		<td><?php echo $num;?></td>
		<td><?php echo $r_e['tipo']; ?></td>
		<td><?php echo transforma_fecha_hora($r_e['fecha_creacion']); ?></td>
		<td><?php echo $observaciones; ?></td>
		
		<td style="width:150px;">
			
			<a data-toggle="modal" href="#myModalMov_<?=$r_e['tipo_id']."_".$r_e['d_id']?>" title="Ver movimiento" class="btn btn-sm btn-primary btn-sm"> <span style="top: 0px;" class="glyphicon glyphicon-search"></span></a>
			
			<div class="modal fade" id="myModalMov_<?=$r_e['tipo_id']."_".$r_e['d_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog ">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			          <h4 class="modal-title">Ver movimiento de estudiante</h4>
			        </div>
			        <div class="modal-body_<?=$r_e['d_id']?>" style="padding:10px">
			        	<?php $descripcion_id = $r_e['d_id'];

						$sql3= "select d.id d_id, m.*,d.*,t.nombre tipo,t.id tipo_mov 
						  		from movimiento_estudiante m
								INNER JOIN tipo_movimiento t ON m.tipo_movimiento_id = t.id
								INNER JOIN descripcion_movimiento d ON d.movimiento_estudiante_id = m.id
								LEFT JOIN motivo_retiro r ON d.motivo_retiro_id = r.id
								WHERE d.id=".$descripcion_id;

						$query3 = $con->query($sql3);
						?>
						<div id="info_movimiento_<?=$descripcion_id?>">
						  <?php 
						  if($query3->num_rows>0){
						    $mov=$query3->fetch_object(); 
						    ?>
						    <h3 id="h3_<?=$descripcion_id?>" style="text-align: center"><?=$mov->tipo?></h3>
						    <div class="row" style="font-size: 13px;">
						      <div class="form-group col-sm-10">
						        <label id=label_<?=$descripcion_id?>>Fecha Registro: </label>
						        <span><?php echo transforma_fecha_hora($mov->created_at)?> </span>
						        <br />
						        <label >Usuario que lo registro: </label>
						        <?php echo buscar_usuario($mov->user_create)?> 
						      </div>
						    </div>
						    <?php if($mov->fecha_solicitud != NULL) { ?>
						    <div style="font-size: 13px;" class="row">
						      <div class="col-sm-3">
						        <label for="fecha_solicitud">Fecha solicitud: </label>
						      </div>
						      <div class="col-sm-4" style="text-align: left">
						          <input type="text" class="form-control" name="fecha_solicitud" value="<?=transforma_fecha($mov->fecha_solicitud)?>" readonly="1" />
						      </div>
						  	</div>
						  	<div style="font-size: 13px;" class="row">
						      <div class="col-sm-3">
						        <label for="comunicacion_solicitud" >Comunicación de solicitud: </label>
						      </div>
						      <br />
						      <div class="col-sm-5" style="text-align: left">
						          <input type="text" class="form-control" name="comunicacion_solicitud" value="<?=$mov->comunicacion_solicitud?>" readonly="1" />
						      </div>
						    </div>
						    <hr />
						    <?php }

						    if($mov->tipo_mov == 1) { ?>
						    <div style="font-size: 14px;" class="row">
						      <div class="col-sm-3">
						        <label for="fecha_ingreso">Fecha ingreso: </label>
						      </div>
						      <div class="col-sm-3" style="text-align: left">
						          <input type="text" class="form-control" name="fecha_ingreso" value="<?=transforma_fecha($mov->fecha_ingreso)?>" readonly="1" />
						      </div>
						      <div class="col-sm-2">
						        <label for="estatus_prorroga_id">Cohorte: </label>
						      </div>
						      <div class="col-sm-3" style="text-align: left">
						          <input type="text" class="form-control" name="anio_cohorte" value="<?=$mov->anio_cohorte?>" readonly="1" />
						      </div>
						    </div>
						    <br />
						    <div style="font-size: 14px;" class="row">
						      <div class="form-group col-sm-11 ">
						        <label>Observaciones de expediente </label>
						        <textarea class="form-control" name="observaciones_expediente" readonly rows="3"><?php echo $mov->observaciones_expediente ?></textarea>
						      </div>
						    </div>
						 <?php
							}
							elseif ($mov->tipo_mov == 2) { ?>
						    <div style="font-size: 14px;" class="row">
						      <div class="col-sm-3">
						        <label for="fecha_cierre" >Fecha cierre de expediente: </label>
						      </div>
						      <div class="col-sm-4" style="text-align: left">
						          <input type="text" class="form-control" name="fecha_cierre" value="<?=transforma_fecha($mov->fecha_cierre)?>" readonly="1" />
						      </div>
						  	</div>
						  	<br />
						  	<div style="font-size: 14px;" class="row">
						      <div class="col-sm-3">
						        <label for="fecha_grado" >Fecha de grado: </label>
						      </div>
						      <div class="col-sm-4" style="text-align: left">
						          <input type="text" class="form-control" name="fecha_grado" value="<?=transforma_fecha($mov->fecha_grado)?>" readonly="1" />
						      </div>
						      <!--div class="col-sm-2">
						        <label for="num_pergamino" >N° de pergamino: </label>
						      </div>
						      <div class="col-sm-2" style="text-align: left">
						          <input type="text" class="form-control" name="num_pergamino" value="<?=$mov->num_pergamino?>" readonly="1" />
						      </div-->
						  	</div>
						  	<br />
						  	<div style="font-size: 14px;" class="row">
						      <div class="form-group col-sm-11 ">
						        <label>Observaciones de cierre de expediente </label>
						        <textarea class="form-control" name="observaciones_cierre" readonly rows="3"><?php echo $mov->observaciones_cierre ?></textarea>
						      </div>
						    </div>						  
						  	<?php
						  }
						  elseif ($mov->tipo_mov == 3) { ?>
						    <div style="font-size: 14px;" class="row">
						      <div class="col-sm-3">
						        <label for="fecha_retiro" >Fecha de retiro: </label>
						      </div>
						      <div class="col-sm-4" style="text-align: left">
						          <input type="text" class="form-control" name="fecha_retiro" value="<?=transforma_fecha($mov->fecha_retiro)?>" readonly="1" />
						      </div>
						  	</div>
						  	<br />
						  	<div style="font-size: 14px;" class="row">
						      <div class="col-sm-6">
						        <label for="motivo_retiro_id" >Motivo retiro: </label>
						      	<select class="form-control" name="motivo_retiro_id" required>
							      	<option value="">Seleccione</option>
							      	<?php 
							          while ($r=$query_motivos->fetch_array()):
							            $selected = '';
							            if($r['id'] == $mov->motivo_retiro_id)
							              $selected = 'selected="selected"';
							            echo "<option ".$selected." value='".$r['id']."' >".$r['nombre']."</option>";
							          endwhile;
							        ?>
							    </select>
						      </div>
						      <div class="col-sm-5">
						        <label for="culmino_escolaridad" >¿Culminó escolaridad?: </label>
						      
						           <select class="form-control" name="culmino_escolaridad" required>
								      <option value=""></option>
								      <option value="yes">Si</option>
								      <option value="no">No</option>
								    </select>
						      </div >
						  	</div>
						  	<br />
						  	<div style="font-size: 14px;" class="row">
						      <div class="form-group col-sm-11 ">
						        <label>Descripcion </label>
						        <textarea class="form-control" name="descripcion_motivo_retiro" readonly rows="3"><?php echo $mov->descripcion_motivo_retiro ?></textarea>
						      </div>
						    </div>
						    <div style="font-size: 14px;" class="row">
						      <div class="col-sm-2">
						        <label for="fecha_respuesta" >Fecha de respuesta: </label>
						      </div>
						      <div class="col-sm-3" style="text-align: left">
						          <input type="text" class="form-control" name="fecha_respuesta" value="<?=transforma_fecha($mov->fecha_respuesta)?>" readonly="1" />
						      </div>
						      <div class="col-sm-3">
						        <label for="comunicacion_respuesta" >Comunicación de respuesta: </label>
						      </div>
						      <div class="col-sm-4" style="text-align: left">
						          <input type="text" class="form-control" name="comunicacion_respuesta" value="<?=$mov->comunicacion_respuesta?>" readonly="1" />
						      </div>
						  	</div>						  
						  	<?php
						  }
						   elseif ($mov->tipo_mov == 4) { ?>
						  	<div style="font-size: 13px;" class="row">
						      <div class="col-sm-4">
						        <label for="fecha_reunion_equivalencia" >Fecha de reunión de equivalencia: </label>
						      </div>
						      <div class="col-sm-4" style="text-align: left">
						          <input type="text" class="form-control" name="fecha_reunion_equivalencia" value="<?=transforma_fecha($mov->fecha_reunion_equivalencia)?>" readonly="1" />
						      </div>
						  	</div>
						  	<div style="font-size: 13px;" class="row">
						      <div class="col-sm-4">
						        <label for="num_comision_equivalencia" >N° de Comisión Equivalencia: </label>
						      </div>
						      <div class="col-sm-5" style="text-align: left">
						          <input type="text" class="form-control" name="num_comision_equivalencia" value="<?=$mov->num_comision_equivalencia?>" readonly="1" />
						      </div>
						  	</div>	
						  	<br />
						  	<div style="font-size: 14px;" class="row">
						      <div class="form-group col-sm-11 ">
						        <label>Observaciones de equivalencia </label>
						        <textarea class="form-control" name="observaciones_equivalencia" readonly rows="3"><?php echo $mov->observaciones_equivalencia ?></textarea>
						      </div>
						    </div>
						    <div style="font-size: 14px;" class="row">
						      <div class="col-sm-2">
						        <label for="fecha_respuesta" >Fecha de respuesta: </label>
						      </div>
						      <div class="col-sm-3" style="text-align: left">
						          <input type="text" class="form-control" name="fecha_respuesta" value="<?=transforma_fecha($mov->fecha_respuesta)?>" readonly="1" />
						      </div>
						      <div class="col-sm-3">
						        <label for="comunicacion_respuesta" >Comunicación de respuesta: </label>
						      </div>
						      <div class="col-sm-4" style="text-align: left">
						          <input type="text" class="form-control" name="comunicacion_respuesta" value="<?=$mov->comunicacion_respuesta?>" readonly="1" />
						      </div>
						  	</div>						  
						  	<?php
						  }
						  ?>
						  
						    <?php
						}
						
						?>
						</div>
			        </div>

			      </div><!-- /.modal-content -->
			    </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

		</td>
	</tr>
<?php } ?>
</table>
<?php else:?>
	<br><br>
	<p class="alert alert-warning">No posee movimientos registrados</p>
<?php endif;?>
