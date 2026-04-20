<?php
// inicio.php
session_start();

if(isset($_SESSION['session']) && $_SESSION['session'] == 'true') { 
    
    require_once "includes/config.php";
    $page_title = "Inicio - SIGEP";
    $base = '';
    include "includes/header.php";
?>

<style>
/* Título con animación simple */
.page-header h2 {
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Subtítulo animado */
.animated-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.9);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 1; }
}

/* Botones flotantes */
.floating-buttons {
    position: fixed;
    right: 20px;
    bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    z-index: 1000;
}

.float-btn-group {
    position: relative;
}

.float-btn {
    border: none;
    border-radius: 50px;
    padding: 12px 20px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 180px;
}

.float-btn-help {
    background: linear-gradient(135deg, #2B5F8A 0%, #3B7AA8 100%);
}

.float-btn-info {
    background: linear-gradient(135deg, #5BC0BE 0%, #7ED4D2 100%);
    color: #1E4A6E;
}

.float-btn-manual {
    background: linear-gradient(135deg, #D4A843 0%, #E2BC6E 100%);
    color: #1E4A6E;
}

.float-btn:hover {
    transform: translateX(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.float-tooltip {
    position: absolute;
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: #1E4A6E;
    color: white;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 0.75rem;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
    margin-right: 10px;
}

.float-btn-group:hover .float-tooltip {
    opacity: 1;
    visibility: visible;
}

/* Modales profesionales */
.modal-sigep {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.7);
    backdrop-filter: blur(5px);
}

.modal-sigep-content {
    background: linear-gradient(135deg, #ffffff 0%, #f5f7fa 100%);
    margin: 3% auto;
    width: 90%;
    max-width: 850px;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    animation: slideIn 0.4s ease-out;
    overflow: hidden;
    border: 1px solid rgba(91, 192, 190, 0.3);
}

.modal-sigep-header {
    background: linear-gradient(135deg, #2B5F8A 0%, #3B7AA8 100%);
    color: white;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 3px solid #5BC0BE;
}

.modal-sigep-header h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
    letter-spacing: 1px;
}

.modal-sigep-header h3 i {
    margin-right: 12px;
    color: #7ED4D2;
}

.modal-sigep-close {
    font-size: 32px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.modal-sigep-close:hover {
    transform: scale(1.1);
    background: rgba(255,255,255,0.2);
}

.modal-sigep-body {
    padding: 30px;
    max-height: 70vh;
    overflow-y: auto;
}

/* Estilos para secciones dentro de modales */
.logo-section {
    text-align: center;
    margin-bottom: 25px;
}

.logo-section i {
    font-size: 3.5rem;
    color: #2B5F8A;
    background: linear-gradient(135deg, #5BC0BE 0%, #7ED4D2 100%);
    padding: 15px;
    border-radius: 50%;
    margin-bottom: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.logo-section h2 {
    color: #2B5F8A;
    margin: 10px 0 5px;
    font-size: 1.8rem;
}

.logo-section p {
    color: #6C757D;
}

.description {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
    border-left: 4px solid #5BC0BE;
    line-height: 1.6;
    color: #495057;
}

.mission-vision {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 25px 0;
}

.mission, .vision {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 15px;
    transition: transform 0.3s;
    border: 1px solid #e9ecef;
}

.mission:hover, .vision:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.mission h4, .vision h4 {
    color: #2B5F8A;
    margin-bottom: 12px;
    font-size: 1.2rem;
}

.mission h4 i, .vision h4 i {
    margin-right: 8px;
    color: #5BC0BE;
}

.values {
    margin-top: 25px;
}

.values h4 {
    color: #2B5F8A;
    margin-bottom: 15px;
}

.values-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.value-badge {
    background: linear-gradient(135deg, #5BC0BE 0%, #7ED4D2 100%);
    color: #1E4A6E;
    padding: 8px 18px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: transform 0.3s;
}

.value-badge:hover {
    transform: scale(1.05);
}

.value-badge i {
    margin-right: 6px;
}

.contact-info {
    margin-top: 25px;
    text-align: center;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
}

.contact-info h4 {
    color: #2B5F8A;
    margin-bottom: 10px;
}

.contact-info p {
    margin: 5px 0;
    color: #6C757D;
}

.feature-hint {
    margin-top: 15px;
    font-size: 0.85rem;
    color: #5BC0BE;
    opacity: 0.6;
    transition: opacity 0.3s;
}

.feature-card:hover .feature-hint {
    opacity: 1;
}

.btn-top {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: linear-gradient(135deg, #2B5F8A 0%, #3B7AA8 100%);
    color: white;
    border: none;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    z-index: 1000;
}

.btn-top:hover {
    transform: translateY(-5px);
    background: linear-gradient(135deg, #5BC0BE 0%, #7ED4D2 100%);
    color: #1E4A6E;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Instrucciones steps */
.instructions-steps {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.step {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    padding: 10px;
    border-radius: 12px;
    transition: background 0.3s;
}

.step:hover {
    background: #f8f9fa;
}

.step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #5BC0BE 0%, #7ED4D2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
    color: #1E4A6E;
    flex-shrink: 0;
}

.step-content h4 {
    color: #2B5F8A;
    margin: 0 0 5px 0;
}

.step-content p {
    margin: 0;
    color: #6C757D;
}

/* Manual sections */
.manual-sections {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.manual-section {
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 12px;
    transition: all 0.3s;
}

.manual-section:hover {
    transform: translateX(5px);
    background: #ffffff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.manual-section h4 {
    color: #2B5F8A;
    margin-bottom: 10px;
}

.manual-section p {
    color: #6C757D;
    margin-bottom: 8px;
}

.manual-section ul {
    margin: 5px 0 0 20px;
    color: #6C757D;
}

.manual-section li {
    margin: 3px 0;
}

.manual-footer {
    margin-top: 20px;
    text-align: center;
    padding-top: 15px;
    border-top: 1px solid #e0e0e0;
}

.support-info {
    background: linear-gradient(135deg, #2B5F8A 0%, #3B7AA8 100%);
    color: white;
    padding: 15px;
    border-radius: 12px;
    margin: 15px 0;
}

.support-info i {
    font-size: 2rem;
    margin-bottom: 10px;
}

.support-info h4 {
    margin: 10px 0;
}

.support-info p {
    margin: 5px 0;
}

@media (max-width: 768px) {
    .float-btn span {
        display: none;
    }
    .float-btn {
        min-width: 50px;
        width: 50px;
        padding: 12px;
        justify-content: center;
    }
    .float-tooltip {
        display: none;
    }
    .modal-sigep-content {
        width: 95%;
        margin: 10% auto;
    }
    .mission-vision {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    .step {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
}
</style>

<?php include "php/navbar.php"; ?>

<div class="container">
    <div class="page-header fade-in-up">
        <h2>
            <i class="fas fa-graduation-cap" style="color: #7ED4D2; margin-right: 15px;"></i>
            SIGEP - Sistema Integrado de Gestión de Postgrados
        </h2>
        <p class="animated-subtitle">
            <i class="fas fa-heart" style="color: #5BC0BE;"></i> 
            Innovando la gestión académica para un futuro mejor
        </p>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-md-6">
            <div class="feature-card fade-in-up" id="btn-nuevo_ingreso" style="cursor: pointer;" onclick="mostrar_nuevo_ingreso()">
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
            <div class="feature-card fade-in-up" style="cursor: pointer;" onclick="window.location.href='reportes.php'">
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

    <!-- MODAL: ¿Quiénes Somos? (con robot incluido desde archivo externo) -->
    <?php include "includes/modal_quienes_somos.php"; ?>

    <!-- MODAL: Instrucciones -->
    <div id="modal-instrucciones" class="modal-sigep">
        <div class="modal-sigep-content">
            <div class="modal-sigep-header">
                <h3><i class="fas fa-clipboard-list"></i> Instrucciones</h3>
                <span class="modal-sigep-close" onclick="cerrarModal('modal-instrucciones')">&times;</span>
            </div>
            <div class="modal-sigep-body">
                <div class="instructions-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>Registro Rápido</h4>
                            <p>Haga clic en el botón "Registro Rápido" en la página principal.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>Ingrese la cédula</h4>
                            <p>Escriba el número de cédula del estudiante (solo números).</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>Complete los datos</h4>
                            <p>Si el estudiante es nuevo, ingrese todos los datos personales requeridos.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h4>Confirme el registro</h4>
                            <p>Verifique los datos y confirme el registro.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Manual de Usuario -->
    <div id="modal-manual" class="modal-sigep modal-manual">
        <div class="modal-sigep-content modal-manual-content">
            <div class="modal-sigep-header">
                <h3><i class="fas fa-book-open"></i> Manual de Usuario</h3>
                <span class="modal-sigep-close" onclick="cerrarModal('modal-manual')">&times;</span>
            </div>
            <div class="modal-sigep-body">
                <div class="manual-sections">
                    <div class="manual-section">
                        <h4><i class="fas fa-home"></i> Inicio</h4>
                        <p>Página principal con las opciones: Registro Rápido y Seguimiento Académico.</p>
                    </div>
                    <div class="manual-section">
                        <h4><i class="fas fa-user-plus"></i> Registro de Estudiantes</h4>
                        <p>Para registrar un nuevo estudiante, use el botón "Registro Rápido".</p>
                    </div>
                    <div class="manual-section">
                        <h4><i class="fas fa-users"></i> Gestión de Personas</h4>
                        <p>En el módulo "PERSONAS" puede ver, editar y buscar personas registradas.</p>
                    </div>
                    <div class="manual-section">
                        <h4><i class="fas fa-university"></i> Gestión de Postgrados</h4>
                        <p>En el módulo "POSTGRADOS" puede ver y filtrar postgrados por facultad.</p>
                    </div>
                    <div class="manual-section">
                        <h4><i class="fas fa-chart-bar"></i> Reportes</h4>
                        <p>Genere reportes de estudiantes, matrícula y posgrados inactivos.</p>
                    </div>
                </div>
                <div class="manual-footer">
                    <hr>
                    <div class="support-info">
                        <i class="fas fa-headset"></i>
                        <h4>¿Necesitas más ayuda?</h4>
                        <p>Contacta con la unidad de informatica:</p>
                    </div>
                    <p class="text-muted">Versión: 2.0 - <?php echo date('22/02/Y'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de búsqueda por cédula -->
    <div class="row" id="parcial_cedula" style="display: none; margin-top: 40px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="content-card fade-in-up">
                <h4 class="section-title" style="margin-top: 0;">
                    <i class="fas fa-search"></i> Buscar Estudiante por Cédula
                </h4>
                <form action="./buscar_estudiante.php" method="post">
                    <div class="input-group">
                        <input type="text" name="s" id="cedula" class="form-control" placeholder="Número de cédula" maxlength="10">
                        <input type="hidden" name="opcion" id="opcion" value="nuevo">
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
    document.getElementById('modal-quienes').style.display = 'block';
}

function mostrarInstrucciones() {
    document.getElementById('modal-instrucciones').style.display = 'block';
}

function mostrarManual() {
    document.getElementById('modal-manual').style.display = 'block';
}

function cerrarModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function mostrar_nuevo_ingreso() {
    document.getElementById('parcial_cedula').style.display = 'block';
    document.getElementById('opcion').value = 'nuevo';
    document.getElementById('parcial_cedula').scrollIntoView({ behavior: 'smooth' });
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
</script>

<?php } else { 
    print "<script>alert('Debe iniciar sesión.'); window.location='index.php';</script>";
} 
?>