<?php 
session_start();
ini_set('display_errors',0);
if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
<html>
<head>
    <title>.: SIGEP :.</title>
    <link rel="stylesheet" type="text/css" href="css/styles_tables.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <style>
        .btn-verde {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .btn-verde:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: #fff;
        }
    </style>
</head>
<body>
<?php 
    include "php/navbar.php"; 
    include "php/funciones.php";
?>
<div class="container">
<div class="row">
<div class="col-md-12">
    <h3>VER POSTGRADOS</h3>
    <br>
    <?php $facultades_obj = consultar_facultades(); 
    $facultades = (array) $facultades_obj;
    ?>
    
    <form method="get" class="form-inline mb-3">
        <label for="facultadSelect" class="mr-2"><strong>Filtrar por Facultad:</strong></label>
        <select id="facultadSelect" name="facultad" class="form-control mr-2" style="max-width:250px;">
            <option value="">Todos</option>
            <?php 
                foreach ($facultades as $fact) {
                    $fac = (array) $fact;
                    ?>
                    <option value="<?php echo $fac['id']; ?>" 
                        <?php if(isset($_GET['facultad']) && $_GET['facultad']==$fac['id']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($fac['nombre']); ?>
                    </option>

                    <?php
                }
                ?>
        </select>
        <button type="submit" class="btn btn-verde">Filtrar</button>
    </form>

    <?php include "php/postgrados/listar.php"; ?>

</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
      
        if ($.fn.DataTable) {
            $('#table_postgrado').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });
            console.log("✅ DataTables inicializado correctamente");
        } else {
            console.error("❌ DataTables no está disponible");
        }
    });
</script>

</body>
</html>
<?php } else {
    print "<script>alert('Debe iniciar sesion.'); window.location='index.php';</script>";
} ?>