<?php
function transforma_fecha($fecha)
{
	if($fecha != '0000-00-00')
		return date("d-m-Y", strtotime($fecha));
	else
		return $fecha;
}

function transforma_fecha_hora($fecha_hora)
{

	return date("d-m-Y H:m:s", strtotime($fecha_hora));
}




?>