<?php

if(!empty($_POST))
{
    // Verificar que todos los campos requeridos estén presentes
    if(isset($_POST["nombre"]) && isset($_POST["posicion"]) && isset($_POST["obligatorio"]) && isset($_POST["tipo"]))
    {
        // Verificar que los campos no estén vacíos
        if($_POST["nombre"]!="" && $_POST["posicion"]!="" && $_POST["obligatorio"]!="" && $_POST["tipo"]!="")
        {
            include "../conexion.php";
            
            // Sanitizar los datos para prevenir inyección SQL
            $nombre = $con->real_escape_string($_POST['nombre']);
            $posicion = $con->real_escape_string($_POST['posicion']);
            $obligatorio = $con->real_escape_string($_POST['obligatorio']);
            $tipo = $con->real_escape_string($_POST['tipo']);
            
            // Verificar que los valores de enum sean válidos
            $obligatorio_valido = ($obligatorio == 'si' || $obligatorio == 'no') ? $obligatorio : 'no';
            $tipo_valido = ($tipo == 'Cumplimiento' || $tipo == 'Documento') ? $tipo : 'Cumplimiento';
            
            // Insertar en la base de datos (ajusta el nombre de la tabla)
            $sql = "INSERT INTO requisitos (nombre, posicion, obligatorio, tipo, created_at) 
                    VALUES ('$nombre', '$posicion', '$obligatorio_valido', '$tipo_valido', NOW())";
            
            $query = $con->query($sql);
            
            if($query){
                print "<script>alert('Requisito agregado exitosamente.');window.location='../../requisitos.php';</script>";
            } else {
                // Mostrar error específico de MySQL
                print "<script>alert('Error al agregar: " . $con->error . "');window.location='../requisitos.php';</script>";
            }
        }
        else
        {
            echo "<script>alert('Todos los campos son obligatorios.');window.history.back();</script>";
        }
    }
    else
    {
        echo "<script>alert('Faltan campos requeridos.');window.history.back();</script>";
    }
}
else
{
    echo "<script>alert('No se recibieron datos.');window.history.back();</script>";
}
?>