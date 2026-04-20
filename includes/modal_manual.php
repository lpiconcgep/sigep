<?php
// includes/modal_manual.php
?>
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
                    <p>Contacta con la unidad de informática:</p>

                </div>
                <p class="text-muted">Versión: 2.0 - <?php echo date('d/m/Y'); ?></p>
            </div>
        </div>
    </div>
</div>