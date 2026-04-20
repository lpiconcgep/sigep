<?php
// inicio.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    require_once "includes/config.php";
    $page_title = "Inicio - SIGEP";
    $base = '';
    include "includes/header.php";
?>

<!-- Estilos específicos para inicio.php -->
<link rel="stylesheet" href="css/estilos_inicio.css">

<?php include "php/navbar.php"; ?>

<div class="container">
    <div class="page-header fade-in-up">
        <h2>
            <i class="fas fa-graduation-cap"></i>
            SIGEP - Sistema Integrado de Gestión de Postgrados
        </h2>
        <p class="animated-subtitle">
            <i class="fas fa-heart"></i> 
            Innovando la gestión académica para un futuro mejor
        </p>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-md-6">
            <div class="feature-card fade-in-up" id="btn-nuevo_ingreso" onclick="mostrar_nuevo_ingreso()">
                <div class="feature-icon">
                    <i class="fas fa-bolt fa-2x"></i>
                </div>
                <h4>⚡ Registro Rápido</h4>
                <p>Agregue nuevos estudiantes de manera eficiente con nuestro sistema de búsqueda automática por cédula.</p>
                <div class="feature-hint">
                    <i class="fas fa-arrow-right"></i> Haga clic para comenzar
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="feature-card fade-in-up" onclick="window.location.href='reportes.php'">
                <div class="feature-icon">
                    <i class="fas fa-chart-line fa-2x"></i>
                </div>
                <h4>📊 Seguimiento Académico</h4>
                <p>Monitoree el progreso de los estudiantes en sus programas de postgrado y genere reportes.</p>
                <div class="feature-hint">
                    <i class="fas fa-arrow-right"></i> Haga clic para ver reportes
                </div>
            </div>
        </div>
    </div>

    <!-- Botones flotantes -->
    <div class="floating-buttons">
        <div class="float-btn-group">
            <button class="float-btn float-btn-help" onclick="mostrarQuienesSomos()">
                <i class="fas fa-question-circle"></i>
                <span>¿Quiénes Somos?</span>
            </button>
            <div class="float-tooltip">Conoce nuestra misión y visión</div>
        </div>
        <div class="float-btn-group">
            <button class="float-btn float-btn-info" onclick="mostrarInstrucciones()">
                <i class="fas fa-info-circle"></i>
                <span>Instrucciones</span>
            </button>
            <div class="float-tooltip">Aprende a usar el sistema</div>
        </div>
        <div class="float-btn-group">
            <button class="float-btn float-btn-manual" onclick="mostrarManual()">
                <i class="fas fa-book"></i>
                <span>Manual de Usuario</span>
            </button>
            <div class="float-tooltip">Guía completa del sistema</div>
        </div>
    </div>

    <!-- MODALES SEPARADOS -->
    <?php include "includes/modal_quienes_somos.php"; ?>
    <?php include "includes/modal_instrucciones.php"; ?>
    <?php include "includes/modal_manual.php"; ?>

    <!-- Formulario de búsqueda por cédula -->
    <div class="row" id="parcial_cedula" style="display: none; margin-top: 40px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="content-card fade-in-up">
                <h4 class="section-title">
                    <i class="fas fa-search"></i> Buscar Estudiante por Cédula
                </h4>
                <form action="./buscar_estudiante.php" method="post">
                    <div class="input-group">
                        <input type="text" name="s" id="cedula" class="form-control" placeholder="Número de cédula" maxlength="10">
                        <input type="hidden" name="opcion" id="opcion" value="">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success">Buscar</button>
                        </span>
                    </div>
                </form>
                <div class="alert alert-info" style="margin-top: 15px;">
                    <i class="fas fa-info-circle"></i> Ingrese la cédula para verificar si el estudiante ya está registrado.
                </div>
            </div>
        </div>
    </div>
</div>

<button onclick="scrollToTop()" id="btnTop" class="btn-top" title="Volver arriba">
    <i class="fas fa-arrow-up"></i>
</button>

<?php include "includes/footer.php"; ?>

<script>
// ============================================
// FUNCIONES PARA MODALES
// ============================================
function mostrarQuienesSomos() {
    var modal = document.getElementById('modal-quienes');
    if (modal) modal.style.display = 'block';
}

function mostrarInstrucciones() {
    var modal = document.getElementById('modal-instrucciones');
    if (modal) modal.style.display = 'block';
}

function mostrarManual() {
    var modal = document.getElementById('modal-manual');
    if (modal) modal.style.display = 'block';
}

function cerrarModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) modal.style.display = 'none';
}

// ============================================
// FUNCIÓN REGISTRO RÁPIDO
// ============================================
function mostrar_nuevo_ingreso() {
    var parcialCedula = document.getElementById('parcial_cedula');
    var opcionInput = document.getElementById('opcion');
    
    if (parcialCedula) {
        parcialCedula.style.display = 'block';
        parcialCedula.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    if (opcionInput) {
        opcionInput.value = 'nuevo';
    }
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Botón volver arriba
window.addEventListener('scroll', function() {
    var btnTop = document.getElementById('btnTop');
    if (btnTop) {
        btnTop.style.display = window.scrollY > 300 ? 'flex' : 'none';
    }
});

// Cerrar modales al hacer clic fuera
window.onclick = function(event) {
    var modales = document.querySelectorAll('.modal-sigep');
    modales.forEach(function(modal) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}

function validarCedula() {
    var cedula = document.getElementById('cedula');
    if (cedula) {
        var cedulaValue = cedula.value;
        if (cedulaValue.length < 7 && cedulaValue.length > 0) {
            alert('La cédula debe tener al menos 7 dígitos');
            return false;
        }
    }
    return true;
}

// Verificar elementos al cargar
document.addEventListener('DOMContentLoaded', function() {
    console.log("=== VERIFICACIÓN DE MODALES ===");
    console.log("modal-quienes:", document.getElementById('modal-quienes') ? "✅ EXISTE" : "❌ NO EXISTE");
    console.log("modal-instrucciones:", document.getElementById('modal-instrucciones') ? "✅ EXISTE" : "❌ NO EXISTE");
    console.log("modal-manual:", document.getElementById('modal-manual') ? "✅ EXISTE" : "❌ NO EXISTE");
});
</script>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>