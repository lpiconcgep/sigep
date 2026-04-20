<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGEP V2 - Sistema Integrado de Gestión de Postgrados</title>
    
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Estilos personalizados SIGEP -->
    <link rel="stylesheet" href="css/sigep.css">
    
    <style>
        /* Estilos específicos para el login */
        body {
            background: #ffffff;
            min-height: 100vh;
            /*display: flex;
            align-items: center;
            justify-content: center;*/
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        .login-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
        }
        
        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }
        
        .login-body {
            padding: 40px;
        }
        
        .feature-list {
            margin-bottom: 30px;
            padding: 0;
            list-style: none;
        }
        
        .feature-list li {
            margin-bottom: 15px;
            color: var(--gray-700);
            display: flex;
            align-items: center;
        }
        
        .feature-list li i {
            color: var(--accent-green);
            font-size: 1.2rem;
            margin-right: 10px;
            width: 25px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group label {
            color: var(--gray-700);
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }
        
        .input-group {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .input-group-addon {
            background: var(--gradient-blue);
            border: none;
            color: white;
            padding: 0 15px;
            font-size: 1rem;
        }
        
        .form-control {
            border: 1px solid var(--gray-300);
            border-left: none;
            height: 45px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--accent-green);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            outline: none;
        }
        
        .btn-login {
            background: var(--gradient-blue);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 30px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4);
        }
        
        .btn-login i {
            margin-right: 8px;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-300);
            color: var(--gray-600);
        }
        
        .login-footer i {
            color: var(--accent-green);
            margin: 0 5px;
        }
        
        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .alert i {
            font-size: 1.2rem;
            margin-right: 10px;
        }
        
        .alert-info {
            background: var(--gradient-silver);
            border-left: 4px solid var(--primary-blue);
        }
        
        .required-field {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
            display: block;
        }
        
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        @media (max-width: 768px) {
            .login-container {
                padding: 10px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 2rem;
            }
            
            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<?php if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
    <?php include "php/navbar.php"; ?>
    
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-sm-1 col-sm-offset-11" style="display: none" id="btn_atras_index">
                <a href="/sigep_prototipo/index.php" class="btn-custom btn-primary-custom">
                    <i class="fas fa-arrow-left"></i> Ir atrás
                </a>
            </div>
            
            <div class="col-md-12">
                <div class="page-header fade-in-up">
                    <h2>
                        <i class="fas fa-graduation-cap" style="color: var(--accent-green); margin-right: 15px;"></i>
                        <strong>SIGEP</strong> - Sistema Integrado de Gestión de Postgrados
                    </h2>
                </div>
            </div>
        </div>
        
        <!-- Opciones principales en cards -->
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-4">
                <div class="feature-card fade-in-up" id="btn-nuevo_ingreso" style="cursor: pointer;" onclick="mostrar_nuevo_ingreso()">
                    <div class="feature-icon">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h4>Nuevo Ingreso</h4>
                    <p>Registrar un nuevo estudiante en el sistema</p>
                    <div style="margin-top: 15px;">
                        <span class="badge" style="background-color: var(--accent-green); color: white; padding: 5px 10px;">
                            <i class="fas fa-arrow-right"></i> Seleccionar
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card fade-in-up" id="btn-retiro" style="cursor: pointer;" onclick="mostrar_retiro()">
                    <div class="feature-icon">
                        <i class="fas fa-user-minus fa-2x"></i>
                    </div>
                    <h4>Retiro o Desincorporación</h4>
                    <p>Procesar retiros y desincorporaciones</p>
                    <div style="margin-top: 15px;">
                        <span class="badge" style="background-color: var(--accent-green); color: white; padding: 5px 10px;">
                            <i class="fas fa-arrow-right"></i> Seleccionar
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card fade-in-up" id="btn-egreso" style="cursor: pointer;" onclick="mostrar_egreso('devv')">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                    </div>
                    <h4>Egreso</h4>
                    <p>Registrar egresos y graduaciones</p>
                    <div style="margin-top: 15px;">
                        <span class="badge" style="background-color: var(--accent-green); color: white; padding: 5px 10px;">
                            <i class="fas fa-arrow-right"></i> Seleccionar
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Formulario de búsqueda por cédula -->
        <div class="row" id="parcial_cedula" style="display: none; margin-top: 30px;">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-card fade-in-up">
                    <h4 class="section-title" style="margin-top: 0;">
                        <i class="fas fa-search" style="color: var(--accent-green);"></i>
                        Buscar Estudiante por Cédula
                    </h4>
                    
                    <p style="text-align: center; font-weight: bold; margin-bottom: 20px;">
                        <i class="fas fa-id-card"></i> Escriba el Número de Cédula
                    </p>
                    
                    <form class="form-horizontal" action="./buscar_estudiante.php" method="post">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <input type="text" 
                                           name="s" 
                                           id="cedula" 
                                           onblur="validarCedula()" 
                                           class="form-control" 
                                           placeholder="Solo números, sin puntos ni guiones"
                                           maxlength="10">
                                    <input type="hidden" name="opcion" id="opcion" value="">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn-custom btn-success-custom" style="width: 100%;">
                                    <i class="fas fa-search"></i> Buscar Estudiante
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Ingrese el número de cédula para verificar si el estudiante ya está registrado.
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Módulo en desarrollo -->
        <div class="row" id="parcial_desarrollo" style="display: none; margin-top: 30px;">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-card fade-in-up">
                    <div class="text-center" style="padding: 30px;">
                        <i class="fas fa-tools" style="font-size: 4rem; color: var(--primary-blue); margin-bottom: 20px;"></i>
                        <h3 style="color: var(--primary-blue);">Módulo en Desarrollo</h3>
                        <p style="color: var(--gray-600); font-size: 1.1rem;">
                            Este módulo se encuentra actualmente en desarrollo. Pronto estará disponible.
                        </p>
                        <div style="margin-top: 20px;">
                            <div class="progress" style="height: 20px; border-radius: 10px;">
                                <div class="progress-bar" style="width: 75%; background: var(--gradient-blue); border-radius: 10px;">
                                    75% Completado
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>SIGEP</h1>
                <p>Sistema Integrado de Gestión de Postgrados</p>
            </div>
            
            <div class="login-body">
                <!-- <ul class="feature-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Gestión completa de estudiantes de postgrado</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Control de matrícula y programas</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Reportes avanzados y estadísticas</span>
                    </li>
                </ul> -->
                
                <form role="form" method="post" action="./php/iniciar.php">
                    <div class="form-group">
                        <label for="user">
                            <i class="fas fa-user"></i> Usuario <span style="color: #dc3545;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   id="user"
                                   name="user" 
                                   placeholder="Ingrese su usuario"
                                   required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Contraseña <span style="color: #dc3545;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control" 
                                   id="password"
                                   name="password" 
                                   placeholder="Ingrese su contraseña"
                                   required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </button>
                </form>
                
                <div class="login-footer">
                    <p>
                        <i class="fas fa-copyright"></i> 2024 SIGEP - Todos los derechos reservados
                    </p>
                    <p>
                        <small>Prototipo v.2</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/utilidades.js"></script>
<script src="js/general.js"></script>
<script src="js/sigep.js"></script>
<script src="js/sigep-ui.js"></script>

<script>
// Funciones para mostrar/ocultar secciones
function mostrar_nuevo_ingreso() {
    document.getElementById('parcial_cedula').style.display = 'block';
    document.getElementById('parcial_desarrollo').style.display = 'none';
    document.getElementById('btn_atras_index').style.display = 'block';
    document.getElementById('opcion').value = 'nuevo';
    
    // Scroll suave hacia el formulario
    document.getElementById('parcial_cedula').scrollIntoView({ behavior: 'smooth' });
}

function mostrar_retiro() {
    document.getElementById('parcial_cedula').style.display = 'block';
    document.getElementById('parcial_desarrollo').style.display = 'none';
    document.getElementById('btn_atras_index').style.display = 'block';
    document.getElementById('opcion').value = 'retiro';
    
    document.getElementById('parcial_cedula').scrollIntoView({ behavior: 'smooth' });
}

function mostrar_egreso() {
    document.getElementById('parcial_desarrollo').style.display = 'block';
    document.getElementById('parcial_cedula').style.display = 'none';
    document.getElementById('btn_atras_index').style.display = 'block';
    
    document.getElementById('parcial_desarrollo').scrollIntoView({ behavior: 'smooth' });
}

function validarCedula() {
    var cedula = document.getElementById('cedula').value;
    if(cedula.length < 7 && cedula.length > 0) {
        alert('La cédula debe tener al menos 7 dígitos');
        return false;
    }
    return true;
}

// Función para volver al menú principal
function volverMenu() {
    document.getElementById('parcial_cedula').style.display = 'none';
    document.getElementById('parcial_desarrollo').style.display = 'none';
    document.getElementById('btn_atras_index').style.display = 'none';
}

// Evento para el botón atrás
document.addEventListener('DOMContentLoaded', function() {
    var btnAtras = document.querySelector('#btn_atras_index a');
    if(btnAtras) {
        btnAtras.addEventListener('click', function(e) {
            e.preventDefault();
            volverMenu();
        });
    }
});
</script>

</body>
</html>