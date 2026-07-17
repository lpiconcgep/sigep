<?php
// personas.php - CON TAMAÑOS DE FUENTE CORREGIDOS
session_start();


if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Gestión de Personas";
    
    // Ruta base
    $base = '';
    
    // Incluir header
    include "includes/header.php";
?>

<!-- Estilos DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

<style>
/* Tamaños de fuente corregidos */
.table-personas {
    width: 100% !important;
    font-size: 14px !important;
}

.table-personas thead th {
    background: var(--gradient-blue);
    color: white;
    font-weight: 600;
    font-size: 15px !important;
    text-transform: uppercase;
    padding: 12px 15px;
    border: none;
    white-space: nowrap;
}

.table-personas tbody td {
    padding: 12px 15px;
    vertical-align: middle;
    font-size: 14px !important;
    line-height: 1.5;
}

.table-personas tbody tr:hover {
    background: rgba(91,192,190,0.08);
}

/* Botones más grandes y legibles */
.btn-sm {
    padding: 8px 16px !important;
    font-size: 14px !important;
    border-radius: 6px;
    font-weight: 500;
}

.btn-sm i {
    font-size: 14px !important;
    margin-right: 5px;
}

/* Botón Agregar */
.btn-success {
    font-size: 16px !important;
    padding: 10px 25px !important;
    border-radius: 8px;
}

.btn-success i {
    font-size: 16px !important;
    margin-right: 8px;
}

/* Badge de documento */
.badge-documento {
    background: var(--gradient-blue);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 14px !important;
    white-space: nowrap;
    display: inline-block;
    font-weight: 500;
}

.badge-documento i {
    margin-right: 5px;
    font-size: 13px;
}

/* Etiquetas de sexo */
.label {
    font-size: 13px !important;
    padding: 5px 12px !important;
    border-radius: 15px;
}

/* Contenedor de tabla */
.table-container {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* Encabezado de página */
.page-header h2 {
    font-size: 28px !important;
}

.page-header .text-muted {
    font-size: 15px !important;
}

/* DataTables */
.dataTables_wrapper .dataTables_filter input {
    font-size: 14px !important;
    padding: 8px 16px !important;
    border-radius: 20px;
}

.dataTables_wrapper .dataTables_length select {
    font-size: 14px !important;
    padding: 5px 10px !important;
}

.dataTables_wrapper .dataTables_info {
    font-size: 14px !important;
}

.dataTables_wrapper .paginate_button {
    font-size: 14px !important;
    padding: 6px 14px !important;
}

/* Modal */
.modal-header-custom {
    background: var(--gradient-blue);
    color: white;
    padding: 18px 25px;
    border-radius: 10px 10px 0 0;
}

.modal-title-custom {
    font-weight: 600;
    font-size: 18px !important;
    margin: 0;
}

.modal-title-custom i {
    margin-right: 10px;
    color: #7ED4D2;
}

.modal-body {
    font-size: 14px !important;
}

.modal-body .form-control {
    font-size: 14px !important;
    padding: 10px 15px !important;
    height: auto;
}

.modal-body label {
    font-size: 14px !important;
    font-weight: 600;
}

.modal-footer .btn {
    font-size: 14px !important;
    padding: 8px 20px !important;
}

/* Responsive */
@media (max-width: 768px) {
    .table-personas {
        font-size: 13px !important;
    }
    
    .table-personas thead th {
        font-size: 13px !important;
        padding: 8px 10px;
    }
    
    .table-personas tbody td {
        font-size: 13px !important;
        padding: 8px 10px;
    }
    
    .btn-sm {
        padding: 6px 12px !important;
        font-size: 13px !important;
    }
    
    .badge-documento {
        font-size: 13px !important;
        padding: 4px 10px;
    }
}
</style>

<?php include "php/navbar.php"; ?>
<div style="height: 50px;"></div>
<div class="container" style="width: 95%;">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Encabezado de la página -->
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
            
            <!-- Botón Agregar -->
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

            <!-- LISTADO DE PERSONAS -->
            <div class="table-container fade-in-up">
                <?php include "php/personas/listar.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>



<!-- Scripts DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#table_personas').DataTable({
        language: {
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
        "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
        "order": [[0, "desc"]],
        "responsive": true,
        "processing": true,
        "deferRender": true,
        "stateSave": false,
        "autoWidth": false,
        "searchDelay": 500
    });
});
</script>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>