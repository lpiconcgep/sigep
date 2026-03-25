
<div class="row" id="datos_academicos">
	<div class="col-sm-12" style="border: 1px solid #e6e6e6; border-radius: 4px">
		<h4>Datos Acad&eacute;micos: </h4>
		<?php if($estudios_persona != NULL)
		{
			echo "<strong>Inscripciones: </strong>";
			if($opcio != 4) { $font = '11px'; } else $font = '15px';
			$th_opc_fecha = $estudios_persona[0]['condicion_estudiante_id'] == 2 ? '<th>Fecha de Grado</th>' : '';
			echo "<table style='font-size: ".$font."' class='table table-bordered'><thead><th>Postgrado</th><th>Estatus</th><th>Fecha Ingreso</th>".$th_opc_fecha."</thead>";
			foreach($estudios_persona as $estudio)
			{
				echo "<tr>";
				echo "<td width='30%'>".$estudio['programa']."</td><td width='20%'>".$estudio['condicion']."</td><td width='25%'>".transforma_fecha($estudio['fecha_i'])."</td>";
				if ($th_opc_fecha != '') echo "<td width='25%'>".transforma_fecha($estudio['fecha_g'])."</td>";
				if($opcio == 2 && $estudio['condicion_estudiante_id'] == 1) { echo '<td><a onclick="javacript:mostrar_registro_retiro('.$estudio['id'].')" style="cursor: pointer" class="btn btn-danger">Retirar</a></td>'; }
				if($opcio == 3 && $estudio['condicion_estudiante_id'] == 1) { echo '<td><a onclick="javacript:mostrar_registro_egreso('.$estudio['id'].')" style="cursor: pointer" class="btn btn-warning">Registrar egreso</a></td>'; }
				if($opcio == 4 && $estudio['condicion_estudiante_id'] == 1) { echo '<td><a onclick="javacript:mostrar_registro_cierre('.$estudio['id'].',\''.$estudio['programa_id'].'\')" class="btn btn-success">Cerrar Expediente</a></td>'; }
				echo "</tr>";
			}
		echo "</table>";
			
		?>

		<?php
		}
		else
			echo "<em> No posee inscripciones </em>"; ?>
	</div>
</div>