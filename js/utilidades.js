
$('#generar_pdf').click(function(e) {

    e.preventDefault();
    $('<form>', {
        method: 'post',
        action: 'generate_pdf.php',
        html: $('<input>', {
            type: 'hidden',
            name: 'estudiante_programa_id',
            value: '111'
        }),
        append: $('<input>', {
            type: 'hidden',
            name: 'dato2',
            value: 'valor2'
        })
    }).appendTo('body').submit();
});


function buscar_postgrados(){

	var facultad_id = $("#select_facultades option:selected").val();

    $('.postgrados').each(function( index ) {
      
        $( this ).css ("display" , "none");
      
    });

    if(facultad_id != '-1')
    {
        $("#table_facultades").hide();
        $("#table_postgrados").show();
        $("#table_programas").hide();

        var element = $('.facultad_'+facultad_id);
        $('.facultad_'+facultad_id).each(function( index ) {
          
            $( this ).css ("display" , "");
          
        });
    }
    else
    {
        $("#table_postgrados").hide();
        $("#table_facultades").show();
        $("#table_programas").hide();
    }

	var parametros = {
            "accion" : 1,
            "valor" : facultad_id
    };

	$.ajax({
            data:  parametros,
            url:   '/sigep_prototipo/php/lib/utilidades_ajax.php',
            type:  'get',
            dataType: 'json', 
            //contentType: "application/json",
            beforeSend: function () {
               	$('#select_postgrados option').each(function() {
				    $(this).remove();
				});

				$("#select_postgrados").append("<option value='-1'>Cargando...</option>");
            },
            success:  function (data) {                
                var $select = $('#select_postgrados');
                $select.empty().append('<option value="-1">Todos</option>');
                var i = 0;

                if(data.success) {
                    // data.resultado es un ARRAY
                    var resultado = data.resultado;
                    
                    // Recorrer el array correctamente
                    for (var i = 0; i < resultado.length; i++) {
                        $("#select_postgrados").append(
                            "<option value='" + resultado[i].id + "'>" + 
                            resultado[i].nombre + 
                            "</option>"
                        );
                    }
                } else {
                    $("#select_postgrados").append("<option value='-1'>Sin datos</option>");
                }




                /*
                if(datos["success"])
                {
                    $('#select_postgrados option').each(function() {
                        $(this).remove();
                    });

                    $("#select_postgrados").append("<option value='-1'>Todos</option>");

                    for (var resul in datos["resultado"])
                    {
                        $("#select_postgrados").append("<option value='"+datos['resultado'][i]['id']+"'>"+datos['resultado'][i]['nombre']+"</option>");
                        i++;
                    }
                }*/

            },
            /*error: function(jqXHR, textStatus, errorThrown) {
                    console.error("❌ Error en la petición!");
                    console.error("Estado:", textStatus);
                    console.error("Error:", errorThrown);
                    console.error("Código HTTP:", jqXHR.status);
                    console.error("Respuesta del servidor:", jqXHR.responseText);
                    
                    // Mostrar mensaje de error según el código HTTP
                    var mensajeError = '';
                    switch(jqXHR.status) {
                        case 0:
                            mensajeError = 'No se pudo conectar al servidor';
                            break;
                        case 400:
                            mensajeError = 'Solicitud incorrecta';
                            break;
                        case 403:
                            mensajeError = 'No tienes permisos para esta acción';
                            break;
                        case 404:
                            mensajeError = 'El recurso no existe';
                            break;
                        case 500:
                            mensajeError = 'Error interno del servidor';
                            break;
                        default:
                            mensajeError = 'Error al procesar la solicitud';
                    }
                    
                    alert('Error: ' + mensajeError);
                    
                    // Mostrar mensaje en el select
                    $('#select_postgrados')
                        .empty()
                        .append('<option value="-1">Error al cargar datos</option>');
                },
                
                // Siempre se ejecuta, haya éxito o error
                complete: function(jqXHR, textStatus) {
                    console.log("🏁 Petición completada");
                    console.log("Estado final:", textStatus);
                    console.log("Headers de respuesta:", jqXHR.getAllResponseHeaders());
                    
                    // Ocultar loader siempre
                    $('#loader').hide();
                    $('#select_postgrados').prop('disabled', false);
                    
                    // Log para debugging
                    if(textStatus === 'success') {
                        console.log("✅ La petición fue exitosa");
                    } else {
                        console.log("❌ La petición falló o fue abortada");
                    }
                }*/




        });
}

function buscar_programas(){
	
	postgrado_id = $("#select_postgrados option:selected").val();
    $('.programas').each(function( index ) {
      
        $( this ).css ("display" , "none");
      
    });

    if(postgrado_id != '-1')
    {
        $("#table_facultades").hide();
        $("#table_postgrados").hide();
        $("#table_programas").show();



        //var element = $('.postgrado_'+postgrado_id);
        $('.postgrado_'+postgrado_id).each(function( index ) {
          
            $( this ).css ("display" , "");
          
        });
    }
    else
    {
        $("#table_postgrados").show();
        $("#table_facultades").hide();
        $("#table_programas").hide();
    }

    
    var parametros = {
            "accion" : 2,
            "valor" : postgrado_id
    };

    $.ajax({
            data:  parametros,
            url:   '/sigep_prototipo/php/lib/utilidades_ajax.php',
            type:  'get',
            //dataType: 'json', 
            contentType: "application/json; charset=utf-8",
            beforeSend: function () {
                $('#select_programas option').each(function() {
                    $(this).remove();
                });

                $("#select_programas").append("<option value='-1'>Cargando...</option>");
            },
            success:  function (data) {

                var datos = jQuery.parseJSON(data);
                var i = 0;
                
                if(datos["success"])
                {
                    $('#select_programas option').each(function() {
                        $(this).remove();
                    });

                    $("#select_programas").append("<option value='-1'>Todos</option>");

                    for (var resul in datos["resultado"])
                    {
                        $("#select_programas").append("<option value='"+datos['resultado'][i]['id']+"'>"+datos['resultado'][i]['nombre']+"</option>");
                        
                        i++;
                    }
                }


            }
        });
}

function buscar_programa_x_id(programa_id){
    
    
    var parametros = {
            "accion" : 3,
            "valor" : programa_id
    };

    $.ajax({
            data:  parametros,
            url:   '/sigep_prototipo/php/lib/utilidades_ajax.php',
            type:  'get',
            //dataType: 'json', 
            contentType: "application/json; charset=utf-8",
            /*beforeSend: function () {
                $('#select_programas option').each(function() {
                    $(this).remove();
                });

                $("#select_programas").append("<option value='-1'>Cargando...</option>");
            },*/
            success:  function (data) {

                var datos = jQuery.parseJSON(data);
                var i = 0;
                if(datos["success"])
                {
                    var programa = datos['resultado'];
                    var name_otorga = programa['otorga']+" en "+datos['name'];
                    var name_academico = programa['grado']+" en "+datos['name'];
                    $("#grado_academico_otorga").val(name_otorga);
                    $("#name_programa").val(name_academico);
                }


            }
        });
}

function ver_matricula(programa_id,tipo)
{
    
    location.href = '../../matricula.php?programa_id='+programa_id+'&tipo='+tipo+'&source=reportes';
      

}

//VALIDACIÓN
function validarCedula(evt) {
    var numCedula    = document.getElementById('cedula').value,
        cedulaValida = /^[1-9]-?\d{4}-?\d{4}$/;
        /*alert("holaaa");*/

    if (cedulaValida.test(numCedula)) {
        alert('Cédula Válida: ' + numCedula);
    }
}