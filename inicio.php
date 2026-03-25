<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGEP - Sistema Integrado de Gestión de Postgrados</title>
    
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    
    <!-- Estilos personalizados SIGEP -->
    <link rel="stylesheet" type="text/css" href="css/sigep.css">
    
    <!-- Font Awesome para iconos (opcional pero recomendado) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include "php/navbar.php"; ?>
    
    <div class="container">
        <!-- Encabezado principal -->
        <div class="page-header fade-in-up">
            <h2>
                <i class="fas fa-graduation-cap" style="margin-right: 15px;"></i>
                <strong>SIGEP</strong> - Sistema Integrado de Gestión de Postgrados
            </h2>
            <div style="position: relative; z-index: 1;">
                <span class="badge" style="background: var(--accent-green); color: var(--white); padding: 8px 15px; font-size: 0.9rem;">
                    <i class="fas fa-users"></i> Gestión de Estudiantes
                </span>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="row">
            <div class="col-md-12">
                <!-- Tarjeta de bienvenida -->
                <div class="content-card fade-in-up">
                    <h3 class="section-title">
                        <i class="fas fa-star" style="color: var(--accent-green); margin-right: 10px;"></i>
                        Módulo de Gestión de Estudiantes
                    </h3>
                    
                    <p class="lead">
                        <i class="fas fa-quote-left" style="color: var(--accent-green); margin-right: 10px;"></i>
                        Bienvenido al sistema de gestión de estudiantes de postgrado. 
                        Aquí podrá administrar toda la información relacionada con los 
                        estudiantes, sus programas y su progreso académico.
                    </p>

                    <!-- Grid de características -->
                    <div class="feature-grid">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h4>Registro Rápido</h4>
                            <p>Agregue nuevos estudiantes de manera eficiente con nuestro sistema de búsqueda automática.</p>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h4>Búsqueda Inteligente</h4>
                            <p>Localice estudiantes por cédula, nombre o programa con nuestro buscador avanzado.</p>
                        </div>

                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h4>Seguimiento Académico</h4>
                            <p>Monitoree el progreso de los estudiantes en sus programas de postgrado.</p>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de instrucciones -->
                <div class="content-card fade-in-up">
                    <h3 class="section-title">
                        <i class="fas fa-clipboard-list" style="color: var(--accent-green); margin-right: 10px;"></i>
                        Instrucciones para Agregar Estudiantes
                    </h3>

                    <div style="margin-bottom: 25px;">
                        <p style="color: var(--gray-600); font-size: 1.1rem;">
                            <i class="fas fa-info-circle" style="color: var(--primary-blue); margin-right: 10px;"></i>
                            Siga estos pasos para registrar un nuevo estudiante:
                        </p>
                    </div>

                    <ol class="instruction-list">
                        <li>
                            <strong>Acceda al formulario:</strong> Haga clic en el botón 
                            <span class="btn-custom btn-success-custom" style="padding: 5px 15px; font-size: 0.9rem; margin: 0 5px;">
                                <i class="fas fa-user-plus"></i> Registro Nuevo Ingreso
                            </span>
                            en el menú superior.
                        </li>
                        <li>
                            <strong>Ingrese la cédula:</strong> El sistema buscará automáticamente si el 
                            estudiante ya está registrado en la base de datos.
                        </li>
                        <li>
                            <strong>Complete los datos personales:</strong> Si es un estudiante nuevo, 
                            ingrese toda la información personal requerida.
                        </li>
                        <li>
                            <strong>Agregue el programa:</strong> El sistema le presentará las opciones 
                            disponibles para asignarle el estudio correspondiente.
                        </li>
                    </ol>

                    <div style="margin-top: 25px; padding: 20px; background: var(--gradient-silver); border-radius: 12px;">
                        <p style="margin: 0; color: var(--gray-700);">
                            <i class="fas fa-lightbulb" style="color: var(--accent-green); margin-right: 10px;"></i>
                            <strong>Consejo:</strong> Puede buscar estudiantes existentes usando el campo 
                            de búsqueda en el menú superior para agilizar el proceso.
                        </p>
                    </div>
                </div>

                <!-- Tarjeta de acciones rápidas -->
                <div class="content-card fade-in-up">
                    <h3 class="section-title">
                        <i class="fas fa-bolt" style="color: var(--accent-green); margin-right: 10px;"></i>
                        Acciones Rápidas
                    </h3>

                    <div class="row">
                        <div class="col-md-4 text-center">
                            <a href="personas.php" class="btn-custom btn-primary-custom" style="width: 100%; margin-bottom: 15px;">
                                <i class="fas fa-users"></i> Ver Personas
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="postgrados.php" class="btn-custom btn-success-custom" style="width: 100%; margin-bottom: 15px;">
                                <i class="fas fa-graduation-cap"></i> Ver Postgrados
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="reportes.php" class="btn-custom btn-primary-custom" style="width: 100%; margin-bottom: 15px;">
                                <i class="fas fa-chart-bar"></i> Reportes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
    <!-- Scripts personalizados SIGEP -->
    <script src="js/sigep.js"></script>
    <script src="js/sigep-ui.js"></script>
</body>
</html>