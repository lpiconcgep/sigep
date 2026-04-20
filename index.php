<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.: SIGEP V2 - Sistema Integrado de Gestión de Postgrados :.</title>
    
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script src="js/jquery.min.js"></script>
    <script src="js/utilidades.js"></script>
    <script src="js/general.js"></script>
    
    <style>
        /* ============================================
           SIGEP - Estilos del sistema
           ============================================ */

        :root {
            --blue-soft: #2B5F8A;
            --blue-soft-dark: #1E4A6E;
            --turquoise-soft: #5BC0BE;
            --silver-soft: #E8ECEF;
            --silver-soft-dark: #D0D6DC;
            --white: #FFFFFF;
            --text-dark: #495057;
            --gradient-blue: linear-gradient(135deg, #2B5F8A 0%, #3B7AA8 100%);
            --gradient-turquoise: linear-gradient(135deg, #5BC0BE 0%, #7ED4D2 100%);
            --gradient-silver: linear-gradient(135deg, #E8ECEF 0%, #F5F7F9 50%, #E8ECEF 100%);
            --shadow-sm: 0 2px 8px rgba(43, 95, 138, 0.08);
            --shadow-md: 0 4px 12px rgba(43, 95, 138, 0.12);
            --shadow-lg: 0 8px 20px rgba(43, 95, 138, 0.15);
        }

        body {
            background: var(--gradient-silver);
            font-family: 'Segoe UI', 'Inter', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* ============================================
           NAVBAR (blanco, como el sistema)
           ============================================ */

        .navbar-default {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            margin-bottom: 30px;
        }

        .navbar-default .navbar-brand {
            color: #2B5F8A;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .navbar-default .navbar-brand i {
            color: #5BC0BE;
            margin-right: 5px;
        }

        .navbar-default .navbar-nav > li > a {
            color: #555555;
            font-weight: 500;
        }

        .navbar-default .navbar-nav > li > a:hover {
            color: #2B5F8A;
        }

        .navbar-default .navbar-nav > .active > a {
            color: #2B5F8A;
            border-bottom: 2px solid #5BC0BE;
        }

        /* ============================================
           TARJETAS DE OPCIONES
           ============================================ */

        .opcion-card {
            background: var(--white);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid var(--silver-soft);
            cursor: pointer;
        }
        
        .opcion-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: var(--turquoise-soft);
        }
        
        .opcion-card span {
            font-size: 2.5rem;
            color: var(--blue-soft);
        }
        
        .opcion-card br + * {
            font-weight: 600;
            color: var(--blue-soft-dark);
        }

        /* ============================================
           FORMULARIO DE BÚSQUEDA
           ============================================ */

        #parcial_cedula {
            background: var(--white);
            border-radius: 20px;
            padding: 25px;
            margin-top: 25px;
            box-shadow: var(--shadow-md);
        }
        
        #parcial_cedula .form-control {
            border-radius: 25px;
            border: 1px solid var(--silver-soft-dark);
            padding: 8px 20px;
        }
        
        #parcial_cedula .btn-default {
            background: var(--gradient-blue);
            border: none;
            border-radius: 25px;
            padding: 8px 25px;
            color: white;
        }

        /* ============================================
           LOGIN (VERSIÓN QUE FUNCIONA)
           ============================================ */

        .login-card {
            background: var(--white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow-lg);
            margin-top: 80px;
        }
        
        .login-card h3 {
            color: var(--blue-soft-dark);
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .login-card h3 i {
            color: var(--turquoise-soft);
            margin-right: 10px;
        }
        
        .login-card .form-control {
            border-radius: 25px;
            border: 1px solid var(--silver-soft-dark);
            padding: 10px 15px;
        }
        
        .login-card .btn-primary {
            background: var(--gradient-blue);
            border: none;
            border-radius: 25px;
            padding: 10px;
            width: 100%;
        }
        
        .login-card .btn-primary:hover {
            background: var(--gradient-turquoise);
        }

        @media (max-width: 768px) {
            .col-sm-3 {
                margin-bottom: 15px;
            }
            .login-card {
                margin: 20px;
            }
        }
    </style>
</head>
<body>

<?php if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { ?>
    
    <?php include "php/navbar.php"; ?>
    
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-4">
                <div class="opcion-card" id="btn-nuevo_ingreso" onclick="mostrar_nuevo_ingreso()">
                    <span class="glyphicon glyphicon-user"></span>
                    <br />
                    Nuevo Ingreso
                </div>
            </div>
            <div class="col-md-4">
                <div class="opcion-card" id="btn-retiro" onclick="mostrar_retiro()">
                    <span class="glyphicon glyphicon-user"></span>
                    <br />
                    Retiro o Desincorporación
                </div>
            </div>
            <div class="col-md-4">
                <div class="opcion-card" id="btn-egreso" onclick="mostrar_egreso('prod')">
                    <span class="glyphicon glyphicon-user"></span>
                    <br />
                    Egreso
                </div>
            </div>
        </div>
        
        <div class="row" id="parcial_cedula" style="display: none">
            <div class="col-md-6 col-md-offset-3">
                <p class="text-center"><strong><i class="fas fa-id-card"></i> Escriba el Número de Cédula</strong></p>
                <form class="form-inline text-center" action="./buscar_estudiante.php" method="post">
                    <div class="form-group">
                        <input type="text" name="s" id="cedula" onblur="validarCedula()" class="form-control" placeholder="Solo números" style="width: 250px;">
                        <input type="hidden" name="opcion" id="opcion" value="" />
                    </div>
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>
        </div>
        
        <div class="row" id="parcial_desarrollo" style="display: none">
            <div class="col-md-6 col-md-offset-3 text-center">
                <p><i class="fas fa-tools"></i> Este Módulo se encuentra en desarrollo</p>
            </div>
        </div>
    </div>
    
<?php } else { ?>
    
       
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="login-card">
                    <h3><i class="fas fa-graduation-cap"></i> SIGEP</h3>
                    <form role="form" method="post" action="./php/iniciar.php">
                        <div class="form-group">
                            <label for="user">Usuario <span style='color: red'>*</span></label>
                            <input type="text" class="form-control" name="user" placeholder="Ingrese su usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña <span style='color: red'>*</span></label>
                            <input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<?php } ?>

<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>