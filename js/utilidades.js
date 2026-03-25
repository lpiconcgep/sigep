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

	facultad_id = $("#select_facultades option:selected").val();

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
            //dataType: 'json', 
            contentType: "application/json; charset=utf-8",
            beforeSend: function () {
               	$('#select_postgrados option').each(function() {
				    $(this).remove();
				});

				$("#select_postgrados").append("<option value='-1'>Cargando...</option>");
            },
            success:  function (data) {                

                var datos = jQuery.parseJSON(data);
                var i = 0;
                
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
                }

            }
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