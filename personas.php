<?php
// personas.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración (estamos en la raíz)
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Gestión de Personas";
    
    // Ruta base (estamos en la raíz)
    $base = '';
    
    // Incluir header
    include "includes/header.php";
?>

<?php include "php/navbar.php"; ?>

<!-- ELIMINADO el div espaciador porque ahora el CSS se encarga con padding-top -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Encabezado de la página -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-users" style="color: var(--accent-green); margin-right: 15px;"></i>
                    <strong>VER PERSONAS</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Administre las personas registradas en el sistema
                </p>
            </div>
            
            <!-- Botón Agregar -->
            <div style="margin-bottom: 20px;">
                <a data-toggle="modal" href="#myModal" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Agregar
                </a>
            </div>

            <!-- Modal para agregar persona -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">
                                <i class="fas fa-user-plus"></i> Agregar
                            </h4>
                        </div>
                        <div class="modal-body">
                            <?php
                            $source = "personas";
                            include "php/personas/form.php";
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LISTADO DE PERSONAS (con botones originales) -->
            <div class="table-container fade-in-up">
                <?php include "php/personas/listar.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

<script>
$(document).ready(function() {
    $('#table_personas').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay datos disponibles en la tabla",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron resultados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar para ordenar columna ascendente",
                "sortDescending": ": activar para ordenar columna descendente"
            }
        },
        "pageLength": 10,
        "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]]
    });
});
</script>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 

?>