<?php
// includes/header.php
if (!isset($base)) {
    $base = '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>SIGEP</title>
    
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="<?php echo $base; ?>bootstrap/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Estilos personalizados SIGEP -->
    <link rel="stylesheet" href="<?php echo $base; ?>css/sigep.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap.min.css">
    
    <style>
        /* Estilo adicional para DataTables */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 20px;
            padding: 5px 15px;
            border: 1px solid #e0e0e0;
        }
        
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--accent-green);
            outline: none;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border-radius: 20px;
            padding: 5px;
        }
        
        .dataTables_wrapper .paginate_button {
            border-radius: 20px !important;
            margin: 0 2px !important;
        }
        
        .dataTables_wrapper .paginate_button.current {
            background: var(--gradient-blue) !important;
            border-color: var(--primary-blue) !important;
            color: white !important;
        }
        
        .btn-danger-custom:hover {
            background: #c82333 !important;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>