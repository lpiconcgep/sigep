<?php 
// postgrados.php
session_start();
ini_set('display_errors',1);

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    // Incluir configuración (ajustamos la ruta porque estamos en la raíz)
    require_once "includes/config.php";
    
    // Título de la página
    $page_title = "Postgrados";
    
    // Ruta base (estamos en la raíz)
    $base = '';
    
    // Incluir header
    include "includes/header.php";
?>

<?php 
    include "php/navbar.php"; 
    include "php/funciones.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Encabezado de la página con estilo SIGEP -->
            <div class="page-header fade-in-up">
                <h2>
                    <i class="fas fa-university" style="margin-right: 15px; color: var(--accent-green);"></i>
                    <strong>VER POSTGRADOS</strong>
                </h2>
                <p class="text-muted">Gestión de programas de postgrado por facultad</p>
            </div>
            
            <?php 
            $facultades_obj = consultar_facultades(); 
            $facultades = (array) $facultades_obj;
            ?>
            
            <!-- Filtro de facultades con estilo mejorado -->
            <div class="content-card fade-in-up">
                <h4 class="section-title" style="margin-top: 0;">
                    <i class="fas fa-filter" style="color: var(--accent-green); margin-right: 10px;"></i>
                    Filtrar por Facultad
                </h4>
                
                <form method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="facultadSelect" class="col-sm-4 control-label">
                                    <strong>Facultad:</strong>
                                </label>
                                <div class="col-sm-8">
                                    <select id="facultadSelect" name="facultad" class="form-control">
                                        <option value="">Todas las facultades</option>
                                        <?php 
                                        foreach ($facultades as $fact) {
                                            $fac = (array) $fact;
                                        ?>
                                            <option value="<?php echo $fac['id']; ?>" 
                                                <?php if(isset($_GET['facultad']) && $_GET['facultad'] == $fac['id']) echo "selected"; ?>>
                                                <?php echo htmlspecialchars($fac['nombre']); ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn-custom btn-success-custom">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                    <a href="postgrados.php" class="btn-custom btn-primary-custom" style="margin-left: 10px;">
                                        <i class="fas fa-redo-alt"></i> Limpiar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Listado de postgrados -->
            <div class="content-card fade-in-up">
                <h4 class="section-title" style="margin-top: 0;">
                    <i class="fas fa-list" style="color: var(--accent-green); margin-right: 10px;"></i>
                    Listado de Programas
                </h4>
                
                <?php include "php/postgrados/listar.php"; ?>
            </div>
            
        </div>
    </div>
</div>

<?php 
    include "includes/footer.php"; 
?>
    
<?php } else {
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>