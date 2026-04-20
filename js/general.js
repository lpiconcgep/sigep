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
	$("#parcial_cedula").css("display" , "");
	$("#parcial_desarrollo").css("display" , "none");
	$("#btn_atras_index").css("display" , "");


	$("#btn-nuevo_ingreso").css("display" , "none");
	$("#btn-retiro").css("display" , "");
	$("#btn-egreso").css("display" , "none");

	$("#opcion").val('2');

}



function mostrar_egreso(option = 'dev')
{

	if(option == 'dev'){
		//$("#parcial_cedula").css("display" , "");
		$("#parcial_desarrollo").css("display" , "");
		$("#btn_atras_index").css("display" , "none");

		$("#btn-nuevo_ingreso").css("display" , "");
		$("#btn-retiro").css("display" , "");
		$("#btn-egreso").css("display" , "");

		$("#opcion").val('3');
	}
	else
	{
		$("#parcial_cedula").css("display" , "");
		$("#parcial_desarrollo").css("display" , "none");
		$("#btn_atras_index").css("display" , "");


		$("#btn-nuevo_ingreso").css("display" , "none");
		$("#btn-retiro").css("display" , "none");
		$("#btn-egreso").css("display" , "");

		$("#opcion").val('3');
	}

}


function mostrar_registro_egreso(data)
{
	$("#estudio_id").val(data);
	$("#form_registro_egreso").css("display" , "");
	/*$("#parcial_desarrollo").css("display" , "none");
	$("#btn_atras_index").css("display" , "");


	$("#btn-nuevo_ingreso").css("display" , "none");
	$("#btn-retiro").css("display" , "none");
	$("#btn-egreso").css("display" , "");

	$("#opcion").val('3');*/
	

}

function mostrar_registro_retiro(data)
{
	$("#estudio_id").val(data);
	$("#form_registro_retiro").css("display" , "");
	/*$("#parcial_desarrollo").css("display" , "none");
	$("#btn_atras_index").css("display" , "");


	$("#btn-nuevo_ingreso").css("display" , "none");
	$("#btn-retiro").css("display" , "none");
	$("#btn-egreso").css("display" , "");

	$("#opcion").val('3');*/
	

}

function mostrar_registro_cierre(data, programa_id)
{
	$("#estudio_id").val(data);
	$("#postgrado").val(programa_id);
	$("#form_registro_cierre").css("display" , "");
	var result = buscar_programa_x_id(programa_id);

}









/*$("#table_facultades").css("display" , "");
$("#table_postgrados").css("display" , "none");
$("#table_programas").css("display" , "none");*/