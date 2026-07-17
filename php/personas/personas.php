<?php
// personas.php - CON DATATABLES SERVERSIDE
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    require_once "includes/config.php";
    $page_title = "Gestión de Personas";
    $base = '';
    include "includes/header.php";
?>

<!-- Estilos DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

<style>
/* ... tus estilos existentes ... */
.table-personas {
    width: 100% !important;
    font-size: 14px !important;
}
/* ... resto de estilos ... */
</style>

<?php include "php/navbar.php"; ?>

<div class="container" style="width: 95%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12">
            
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-users" style="color: #7ED4D2; margin-right: 15px;"></i>
                    <strong>VER PERSONAS</strong>
                </h2>
                <p class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Administre las personas registradas en el sistema
                </p>
            </div>
            
            <div style="margin-bottom: 15px;">
                <button data-toggle="modal" href="#myModal" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Agregar
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header modal-header-custom">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white; opacity: 0.8; font-size: 28px;">&times;</button>
                            <h4 class="modal-title-custom">
                                <i class="fas fa-user-plus"></i> Agregar Persona
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

            <!-- LISTADO DE PERSONAS CON SERVERSIDE -->
            <div class="table-container fade-in-up">
                <table id="table_personas" class="table table-bordered table-hover table-striped table-personas">
                    <thead>
                        <tr>
                            <th class="text-center">Cédula</th>
                            <th class="text-center">Apellidos</th>
                            <th class="text-center">Nombres</th>
                            <th class="text-center">Sexo</th>
                            <th class="text-center" style="min-width: 200px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables ServerSide llenará esto automáticamente -->
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    $('#table_personas').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "php/personas/server_side.php",
            "type": "POST",
            "dataType": "json"
        },
        "columns": [
            { "data": "documento_identidad" },
            { "data": "apellidos" },
            { "data": "nombres" },
            { "data": "sexo" },
            { "data": "acciones", "orderable": false, "searchable": false }
        ],
        "language": {
            "decimal": "",
            "emptyTable": "No hay datos disponibles",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
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
            }
        },
        "pageLength": 10,
        "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        "order": [[0, "asc"]],
        "responsive": true,
        "autoWidth": false,
        "searchDelay": 500
    });
});
</script>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>