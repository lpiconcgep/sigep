
<div class="row" id="datos_academicos">
	<div class="col-sm-9" style="border: 1px solid #e6e6e6; border-radius: 4px">
		<h4>Datos Acad&eacute;micos: </h4>
		<?php if($estudios_persona != NULL)
		{
			echo "<strong>Inscripciones: </strong>";
			if($opcio != 2) { $font = '11px'; } else $font = '15px';

			$th_opc_fecha = $estudios_persona[0]['condicion_estudiante_id'] == 5 ? '<th>Fecha Retiro</th>' : '';
			echo "<table style='font-size: ".$font."' class='table table-bordered'><thead><th>Postgrado</th><th>Estatus</th><th>Fecha Ingreso</th>".$th_opc_fecha."</thead>";
			foreach($estudios_persona as $estudio)
			{
				echo "<tr>";
				echo "<td>".$estudio['programa']."</td><td width='20%'>".$estudio['condicion']."</td><td width='25%'>".transforma_fecha($estudio['fecha_i'])."</td>";
				if($estudio['condicion_estudiante_id'] == 1)
				{
					if($estudio['fecha_r'] != NULL || $estudio['fecha_r'] == '0000-00-00')
						$fecha_ret = transforma_fecha($estudio['fecha_r']);
					else
						$fecha_ret = "N/A";
				}
				elseif($estudio['condicion_estudiante_id'] == 5)
					$fecha_ret = transforma_fecha($estudio['fecha_r']);
				else
					$fecha_ret = "N/A";

				if ($th_opc_fecha != '') echo "<td width='25%'>".$fecha_ret."</td>";
				if($opcio == 2 && $estudio['condicion_estudiante_id'] == 1) { echo '<td><a onclick="javacript:mostrar_registro_retiro('.$estudio['id'].')" style="cursor: pointer" class="btn btn-danger">Retirar</a></td>'; }

				if($opcio == 3 && $estudio['condicion_estudiante_id'] == 1) { echo '<td><a onclick="javacript:mostrar_registro_egreso('.$estudio['id'].')" style="cursor: pointer" class="btn btn-warning">Registrar egreso</a></td>'; }

				
				if($opcio == 2 && $estudio['condicion_estudiante_id'] == 2) { echo '<td><a onclick="javacript:mostrar_registro_retiro('.$estudio['id'].')" style="cursor: pointer" class="btn btn-danger">Retirar</a></td>'; }
				
				

				if($opcio == 4 && $estudio['condicion_estudiante_id'] == 1) { echo '<td><a onclick="javacript:mostrar_registro_egreso('.$estudio['id'].')" class="btn btn-success">Cerrar Expediente</a></td>'; }
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
