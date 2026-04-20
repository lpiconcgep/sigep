<?php
// includes/modal_quienes_somos.php - Modal ¿Quiénes Somos?
?>
<div id="modal-quienes" class="modal-sigep">
    <div class="modal-sigep-content modal-quienes-content">
        <div class="modal-sigep-header">
            <h3><i class="fas fa-users"></i> ¿Quiénes Somos?</h3>
            <span class="modal-sigep-close" onclick="cerrarModal('modal-quienes')">&times;</span>
        </div>
        <div class="modal-sigep-body">
            <!-- Robot Asistente Oliver centrado -->
            <?php include "includes/robot_asistente.php"; ?>
            
            <div class="presentacion-section">
                <div class="logo-section">
<!--                     <i class="fas fa-graduation-cap"></i>
 -->                </div>
                
                <div class="description">
                    <p><strong>SIGEP</strong> es una plataforma tecnológica desarrollada para optimizar y modernizar la administración académica de programas de postgrado. Nuestro sistema ofrece herramientas eficientes para la gestión integral de estudiantes.</p>
                </div>
            </div>
            
            <div class="mission-vision">
                <div class="mission">
                    <h4><i class="fas fa-bullseye"></i> Misión</h4>
                    <p>Proveer una herramienta tecnológica eficiente que facilite la gestión integral de estudiantes de postgrado, mejorando los procesos administrativos y académicos con innovación y calidad.</p>
                </div>
                <div class="vision">
                    <h4><i class="fas fa-eye"></i> Visión</h4>
                    <p>Convertirnos en el sistema de referencia para la gestión de postgrados a nivel nacional e internacional.</p>
                </div>
            </div>
            
            <div class="values">
                <h4><i class="fas fa-star"></i> Nuestros Valores</h4>
                <div class="values-grid">
                    <span class="value-badge"><i class="fas fa-check"></i> Innovación</span>
                    <span class="value-badge"><i class="fas fa-check"></i> Calidad</span>
                    <span class="value-badge"><i class="fas fa-check"></i> Compromiso</span>
                    <span class="value-badge"><i class="fas fa-check"></i> Transparencia</span>
                    <span class="value-badge"><i class="fas fa-check"></i> Excelencia</span>
                    <span class="value-badge"><i class="fas fa-check"></i> Responsabilidad</span>
                    <span class="value-badge"><i class="fas fa-check"></i> Ética</span>
                </div>
            </div>
            
            <div class="manual-footer">
                    <hr>
                    <div class="support-info">
                        <i class="fas fa-headset"></i>
                        <h4>!Bienvenido a la actualizacion 2.0 🛠️</h4>
                        <p>SIGEP 2.0</p>
                    </div>
        </div>
    </div>
</div>

<style>
.modal-quienes-content {
    max-width: 950px !important;
}

.presentacion-section {
    margin-top: 25px;
}

/* Asegurar que el robot-container se centre dentro del modal */
.robot-container {
    margin: 10px auto !important;
}
</style>