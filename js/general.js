function mostrar_nuevo_ingreso()
{
	$("#parcial_cedula").css("display" , "");
	$("#parcial_desarrollo").css("display" , "none");
	$("#btn_atras_index").css("display" , "");


	$("#btn-nuevo_ingreso").css("display" , "");
	$("#btn-retiro").css("display" , "none");
	$("#btn-egreso").css("display" , "none");

	$("#opcion").val('1');

}

function mostrar_retiro()
{
	//$("#parcial_cedula").css("display" , "");
	$("#parcial_desarrollo").css("display" , "");
	$("#btn_atras_index").css("display" , "none");


	$("#btn-nuevo_ingreso").css("display" , "");
	$("#btn-retiro").css("display" , "");
	$("#btn-egreso").css("display" , "");

	$("#opcion").val('2');

}



function mostrar_egreso()
{
	//$("#parcial_cedula").css("display" , "");
	$("#parcial_desarrollo").css("display" , "");
	$("#btn_atras_index").css("display" , "none");

	$("#btn-nuevo_ingreso").css("display" , "");
	$("#btn-retiro").css("display" , "");
	$("#btn-egreso").css("display" , "");

	$("#opcion").val('3');

}






/*$("#table_facultades").css("display" , "");
$("#table_postgrados").css("display" , "none");
$("#table_programas").css("display" , "none");*/