<?php
// includes/modal_quienes_somos.php - Modal ¿Quiénes Somos? CON CHAT INTERACTIVO
?>
<div id="modal-quienes" class="modal-sigep">
    <div class="modal-sigep-content modal-quienes-content">
        <div class="modal-sigep-header">
            <h3><i class="fas fa-users"></i> ¿Quiénes Somos?</h3>
            <span class="modal-sigep-close" onclick="cerrarModal('modal-quienes')">&times;</span>
        </div>
        <div class="modal-sigep-body">
            <!-- Robot + Cuadro de chat interactivo -->
            <div class="robot-welcome-container">
                <!-- Robot Asistente Oliver -->
                <div class="robot-avatar-container">
                    <?php include "includes/robot_asistente.php"; ?>
                </div>
                
                <!-- Cuadro de chat interactivo -->
                <div class="welcome-box">
                    <div class="welcome-box-header">
                        <i class="fas fa-robot"></i>
                        <span class="welcome-box-title">¡Pregúntame lo que quieras!</span>
                    </div>
                    <div class="welcome-box-body">
                        <!-- Área de chat -->
                        <div class="chat-container">
                            <div id="chat-messages" class="chat-messages">
                                <div class="message bot-message">
                                    <div class="message-content">
                                        <i class="fas fa-robot" style="margin-right: 8px; color: var(--turquoise-soft);"></i>
                                        ¡Hola! Soy <strong>Oliver</strong>. Puedes preguntarme sobre el sistema SIGEP. 
                                        ¿Qué necesitas saber?
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Input de pregunta -->
                            <div class="chat-input-container">
                                <input type="text" id="chat-input" placeholder="Escribe tu pregunta aquí..." class="chat-input">
                                <button id="chat-send-btn" class="chat-send-btn">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                            
                            <!-- Sugerencias rápidas -->
                            <div class="chat-suggestions">
                                <span class="suggestion-tag" onclick="preguntarRapido('¿Qué es SIGEP?')">¿Qué es SIGEP?</span>
                                <span class="suggestion-tag" onclick="preguntarRapido('¿Cómo gestiono estudiantes?')">Gestión de estudiantes</span>
                                <span class="suggestion-tag" onclick="preguntarRapido('¿Cómo generar un PDF?')">Generar PDF</span>
                                <span class="suggestion-tag" onclick="preguntarRapido('¿Qué módulos tiene?')">Módulos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Resto del contenido -->
            <div class="presentacion-section">
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
                    <h4>¡Bienvenido a la actualización 2.0! 🛠️</h4>
                    <p>SIGEP 2.0</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================
   CONTENEDOR ROBOT + CHAT
   ============================================ */
.robot-welcome-container {
    display: flex;
    align-items: stretch;
    gap: 20px;
    margin: 10px 0 20px 0;
    padding: 15px;
    background: linear-gradient(135deg, #f0f7ff 0%, #e8f4f8 100%);
    border-radius: 16px;
    border-left: 5px solid var(--turquoise-soft);
    min-height: 280px;
}

.robot-avatar-container {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
}

.robot-avatar-container .robot-container {
    margin: 0 !important;
}

/* ============================================
   CHAT INTERACTIVO
   ============================================ */
.welcome-box {
    flex: 1;
    background: var(--white);
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 250px;
}

.welcome-box-header {
    background: var(--gradient-blue);
    padding: 10px 18px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: white;
    flex-shrink: 0;
}

.welcome-box-header i {
    font-size: 1.3rem;
    color: var(--turquoise-soft-light);
}

.welcome-box-title {
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: -0.2px;
}

.welcome-box-body {
    padding: 12px 16px 16px 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 200px;
}

/* Área de mensajes */
.chat-container {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 200px;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    max-height: 250px;
    padding-right: 5px;
    margin-bottom: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* Estilos de mensajes */
.message {
    display: flex;
    margin-bottom: 4px;
    animation: fadeInMessage 0.3s ease-out;
}

@keyframes fadeInMessage {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bot-message {
    justify-content: flex-start;
}

.user-message {
    justify-content: flex-end;
}

.message-content {
    max-width: 85%;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 0.95rem;
    line-height: 1.6;
    word-wrap: break-word;
}

.bot-message .message-content {
    background: var(--gray-soft);
    border-bottom-left-radius: 4px;
    color: var(--text-dark);
}

.user-message .message-content {
    background: var(--gradient-blue);
    color: white;
    border-bottom-right-radius: 4px;
}

.user-message .message-content strong {
    color: var(--turquoise-soft-light);
}

/* Input de chat */
.chat-input-container {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.chat-input {
    flex: 1;
    padding: 10px 14px;
    border: 2px solid var(--silver-soft-dark);
    border-radius: 25px;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.3s ease;
    background: var(--white);
}

.chat-input:focus {
    border-color: var(--turquoise-soft);
    box-shadow: 0 0 0 3px rgba(91, 192, 190, 0.2);
}

.chat-send-btn {
    width: 44px;
    height: 44px;
    border: none;
    border-radius: 50%;
    background: var(--gradient-blue);
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.chat-send-btn:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-sm);
}

.chat-send-btn i {
    font-size: 1.1rem;
}

/* Sugerencias rápidas */
.chat-suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: 6px 8px;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid var(--silver-soft);
}

.suggestion-tag {
    background: var(--gray-soft);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    color: var(--blue-soft);
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    font-weight: 500;
}

.suggestion-tag:hover {
    background: var(--turquoise-soft);
    color: white;
    border-color: var(--turquoise-soft);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

/* Scrollbar del chat */
.chat-messages::-webkit-scrollbar {
    width: 4px;
}

.chat-messages::-webkit-scrollbar-track {
    background: var(--gray-soft);
    border-radius: 10px;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: var(--turquoise-soft);
    border-radius: 10px;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .robot-welcome-container {
        flex-direction: column;
        align-items: center;
        padding: 12px;
        min-height: auto;
    }
    
    .robot-avatar-container {
        min-width: auto;
    }
    
    .robot-avatar-container .robot-container {
        transform: scale(0.8);
        transform-origin: center;
    }
    
    .welcome-box {
        width: 100%;
        min-height: 200px;
    }
    
    .chat-messages {
        max-height: 180px;
    }
    
    .message-content {
        font-size: 0.85rem;
        padding: 8px 12px;
    }
    
    .chat-input {
        font-size: 0.85rem;
        padding: 8px 12px;
    }
    
    .chat-send-btn {
        width: 38px;
        height: 38px;
    }
    
    .chat-send-btn i {
        font-size: 0.95rem;
    }
    
    .suggestion-tag {
        font-size: 0.7rem;
        padding: 4px 10px;
    }
}

@media (max-width: 480px) {
    .robot-welcome-container {
        padding: 8px;
        gap: 10px;
    }
    
    .welcome-box-header {
        padding: 8px 12px;
    }
    
    .welcome-box-title {
        font-size: 0.85rem;
    }
    
    .chat-messages {
        max-height: 150px;
    }
    
    .message-content {
        font-size: 0.8rem;
        padding: 6px 10px;
    }
    
    .chat-suggestions {
        gap: 4px 6px;
    }
    
    .suggestion-tag {
        font-size: 0.65rem;
        padding: 3px 8px;
    }
}
</style>

<script>
// ============================================
// CHATBOT INTERACTIVO
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('chat-send-btn');
    
    // Función para agregar mensaje al chat
    function agregarMensaje(texto, tipo) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${tipo}-message`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.innerHTML = texto;
        
        messageDiv.appendChild(contentDiv);
        chatMessages.appendChild(messageDiv);
        
        // Scroll al final
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Función para mostrar "escribiendo..."
    function mostrarEscribiendo() {
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'message bot-message';
        loadingDiv.id = 'loading-message';
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.innerHTML = '<i class="fas fa-robot" style="margin-right: 8px; color: var(--turquoise-soft);"></i> <span style="opacity: 0.6;">Oliver está escribiendo</span><span class="dots">.</span>';
        contentDiv.style.display = 'flex';
        contentDiv.style.alignItems = 'center';
        contentDiv.style.gap = '4px';
        
        loadingDiv.appendChild(contentDiv);
        chatMessages.appendChild(loadingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Animación de puntos suspensivos
        let dots = 0;
        const dotInterval = setInterval(() => {
            dots = (dots + 1) % 4;
            const dotSpan = loadingDiv.querySelector('.dots');
            if (dotSpan) {
                dotSpan.textContent = '.'.repeat(dots);
            }
        }, 300);
        
        return { loadingDiv, dotInterval };
    }
    
    // Función para eliminar el mensaje de "escribiendo..."
    function eliminarEscribiendo(loadingData) {
        if (loadingData) {
            clearInterval(loadingData.dotInterval);
            if (loadingData.loadingDiv && loadingData.loadingDiv.parentNode) {
                loadingData.loadingDiv.remove();
            }
        }
    }
    
    // Función para enviar pregunta
    async function enviarPregunta() {
        const pregunta = chatInput.value.trim();
        if (!pregunta) return;
        
        // Agregar mensaje del usuario
        agregarMensaje(pregunta, 'user');
        
        // Limpiar input
        chatInput.value = '';
        chatInput.focus();
        
        // Mostrar "escribiendo..."
        const loadingData = mostrarEscribiendo();
        
        try {
            // Enviar pregunta al servidor
            const formData = new FormData();
            formData.append('pregunta', pregunta);
            
            const response = await fetch('includes/chatbot_handler.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            // Eliminar "escribiendo..."
            eliminarEscribiendo(loadingData);
            
            if (data.success) {
                // Agregar respuesta del bot
                agregarMensaje(data.respuesta, 'bot');
            } else {
                agregarMensaje('Lo siento, no pude procesar tu pregunta. Intenta de nuevo.', 'bot');
            }
        } catch (error) {
            // Eliminar "escribiendo..."
            eliminarEscribiendo(loadingData);
            agregarMensaje('Hubo un error al procesar tu pregunta. Por favor, intenta de nuevo.', 'bot');
            console.error('Error:', error);
        }
    }
    
    // Eventos
    sendBtn.addEventListener('click', enviarPregunta);
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            enviarPregunta();
        }
    });
});

// Función para preguntas rápidas desde los tags
function preguntarRapido(pregunta) {
    const input = document.getElementById('chat-input');
    if (input) {
        input.value = pregunta;
        // Disparar el evento de envío
        const event = new Event('keypress');
        event.key = 'Enter';
        input.dispatchEvent(event);
    }
}

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('modal-quienes');
        if (modal && modal.style.display === 'block') {
            cerrarModal('modal-quienes');
        }
    }
});
</script>