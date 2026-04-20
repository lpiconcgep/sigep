<?php
// buscar.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Resultados de Búsqueda";
    
    // Ruta base
    $base = '';
    
    // Incluir header
    include "includes/header.php";
    
    // CORREGIDO: Incluir conexión con la ruta correcta
    include "php/conexion.php";
?>

<style>
/* Estilos específicos para resultados de búsqueda */
.search-header {
    background: var(--gradient-blue);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
    color: white;
}

.search-header h3 {
    margin: 0;
    font-size: 1.5rem;
}

.search-header strong {
    color: var(--turquoise-soft-light);
    font-size: 1.3rem;
}

.result-card {
    background: var(--white);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
}

.result-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.result-card h4 {
    color: var(--blue-soft);
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--turquoise-soft);
}

.result-card h4 i {
    margin-right: 10px;
    color: var(--turquoise-soft);
}

.result-table {
    width: 100%;
}

.result-table td {
    padding: 8px;
    vertical-align: middle;
    border-bottom: 1px solid var(--silver-soft);
}

.result-table tr:last-child td {
    border-bottom: none;
}

.result-table .label {
    font-weight: 600;
    color: var(--blue-soft);
    width: 120px;
}

.badge-search {
    background: var(--gradient-turquoise);
    color: var(--blue-soft-dark);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.no-results {
    text-align: center;
    padding: 40px;
    background: var(--white);
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
}

.no-results i {
    font-size: 3rem;
    color: var(--turquoise-soft);
    margin-bottom: 15px;
}

.no-results h4 {
    color: var(--blue-soft);
    margin-bottom: 10px;
}

.no-results p {
    color: var(--text-light);
}
</style>

<?php include "php/navbar.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Encabezado de búsqueda -->
            <div class="search-header fade-in-up">
                <h3>
                    <i class="fas fa-search"></i> 
                    Resultados para: <strong>*<?php echo htmlspecialchars($_GET['s']); ?>*</strong>
                </h3>
            </div>
            
            <!-- Resultados de búsqueda -->
            <?php include "php/personas/busqueda.php"; ?>
            
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>