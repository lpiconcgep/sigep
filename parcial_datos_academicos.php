
<div class="row" id="datos_academicos">
	<div class="col-sm-9" style="border: 1px solid #e6e6e6; border-radius: 4px">
		<h4>Datos Acad&eacute;micos: </h4>
		<?php if($estudios_persona != NULL)
		{
			echo "<strong>Inscripciones: </strong>";
			if($opcio != 2) { $font = '11px'; } else $font = '15px';
			echo "<table style='font-size: ".$font."' class='table table-bordered'><thead><th>Postgrado</th><th>Estatus</th><th>Fecha Ingreso</th></thead>";
			foreach($estudios_persona as $estudio)
			{
				echo "<tr>";
				echo "<td>".$estudio['programa']."</td><td width='20%'>".$estudio['condicion']."</td><td width='30%'>".transforma_fecha($estudio['fecha_i'])."</td>";
				if($opcio == 2) { echo '<td><a href="./" class="btn btn-danger">Retirar</a></td>'; }
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
