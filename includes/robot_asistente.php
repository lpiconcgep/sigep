<?php
// includes/robot_asistente.php
// Robot Asistente Oliver - Centrado, con burbuja a la derecha
?>

<style>
/* Contenedor principal del robot (centrado) */
.robot-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    margin: 20px auto;
    flex-wrap: wrap;
    max-width: 700px;
}

/* Robot más pequeño */
.robot-scene {
    position: relative;
    width: 130px;
    height: 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
}

/* Animación de Levitación */
.robot {
    position: absolute;
    bottom: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    animation: float-robot 4s ease-in-out infinite;
    z-index: 2;
}

/* Cabeza */
.robot-head {
    width: 110px;
    height: 85px;
    background: linear-gradient(145deg, #ffffff 0%, #e6f7ff 100%);
    border: 2px solid #2B5F8A;
    border-radius: 35px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 12px;
    box-shadow: 0 5px 12px rgba(0,0,0,0.1);
}

.robot-head::before {
    content: '';
    position: absolute;
    top: -8px;
    width: 100%;
    height: 28px;
    border: 6px solid #2B5F8A;
    border-bottom: none;
    border-radius: 50px 50px 0 0;
    box-sizing: border-box;
}

.robot-headset-pad {
    position: absolute;
    width: 12px;
    height: 35px;
    background-color: #2B5F8A;
    border-radius: 6px;
    top: 20px;
}
.pad-left { left: -12px; }
.pad-right { right: -12px; }

.robot-mic-arm {
    position: absolute;
    width: 28px;
    height: 3px;
    background-color: #2B5F8A;
    bottom: 15px;
    left: -10px;
    transform: rotate(30deg);
}
.robot-mic-tip {
    position: absolute;
    width: 10px;
    height: 10px;
    background-color: #2B5F8A;
    border-radius: 50%;
    bottom: -4px;
    right: -7px;
    box-shadow: 0 0 6px rgba(91, 192, 190, 0.6);
}

/* Visor */
.robot-visor {
    width: 85px;
    height: 55px;
    background: linear-gradient(180deg, #1a2a3a 0%, #0d141d 100%);
    border-radius: 20px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 0 8px;
    border: 2px solid #5BC0BE;
    box-shadow: 0 0 10px rgba(91, 192, 190, 0.4);
    animation: neon-pulse 2s ease-in-out infinite;
}

.robot-eye {
    width: 20px;
    height: 10px;
    border: 3px solid #cffff7;
    border-bottom: none;
    border-radius: 15px 15px 0 0;
    filter: drop-shadow(0 0 4px #5BC0BE);
}

/* Cuerpo */
.robot-body {
    width: 75px;
    height: 80px;
    background: linear-gradient(145deg, #ffffff 0%, #e6f7ff 100%);
    border: 2px solid #2B5F8A;
    border-radius: 25px;
    position: relative;
    display: flex;
    justify-content: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.robot-body::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #2B5F8A;
    border-radius: 23px;
    z-index: -1;
    clip-path: polygon(0 0, 15% 0, 15% 100%, 0 100%, 85% 100%, 100% 100%, 100% 0, 85% 0);
}

.robot-logo {
    margin-top: 28px;
    font-size: 18px;
    font-weight: 900;
    color: #5BC0BE;
    letter-spacing: 1px;
    filter: drop-shadow(0 0 6px rgba(91, 192, 190, 0.8));
    animation: ai-pulse 2.5s ease-in-out infinite;
}

/* Brazos */
.robot-arm {
    position: absolute;
    width: 22px;
    height: 50px;
    background: linear-gradient(145deg, #ffffff 0%, #e6f7ff 100%);
    border: 2px solid #2B5F8A;
    border-radius: 12px;
    transform-origin: center 8px;
}

.robot-arm.left { left: -28px; top: 5px; animation: wave-high 3s ease-in-out infinite; }
.robot-arm.right { right: -28px; top: 15px; animation: wave-low 2s ease-in-out infinite; }

.robot-shadow {
    position: absolute;
    bottom: 10px;
    width: 80px;
    height: 20px;
    background: rgba(91, 192, 190, 0.15);
    border-radius: 50%;
    filter: blur(4px);
    animation: shadow-size 4s ease-in-out infinite;
}

/* Burbuja de chat GRANDE a la derecha */
.chat-bubble-large {
    flex: 1;
    background: linear-gradient(135deg, #ffffff 0%, #f0f7f6 100%);
    border-radius: 25px;
    padding: 20px 25px;
    min-width: 320px;
    max-width: 420px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    border: 1px solid rgba(91, 192, 190, 0.3);
    position: relative;
    animation: fadeIn 0.6s ease-out;
}

/* Triángulo de la burbuja apuntando al robot (izquierda) */
.chat-bubble-large::before {
    content: '';
    position: absolute;
    left: -12px;
    top: 40px;
    width: 0;
    height: 0;
    border-right: 14px solid #f0f7f6;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
}

.chat-bubble-large::after {
    content: '';
    position: absolute;
    left: -14px;
    top: 39px;
    width: 0;
    height: 0;
    border-right: 15px solid rgba(91, 192, 190, 0.3);
    border-top: 11px solid transparent;
    border-bottom: 11px solid transparent;
    z-index: -1;
}

.chat-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 2px solid #5BC0BE;
}

.chat-header i {
    font-size: 1.5rem;
    color: #5BC0BE;
}

.chat-header h4 {
    margin: 0;
    color: #2B5F8A;
    font-size: 1.1rem;
    font-weight: 600;
}

.chat-text-large {
    font-family: 'Segoe UI', sans-serif;
    font-size: 1rem;
    color: #333;
    line-height: 1.6;
    min-height: 120px;
}

.chat-text-large p {
    margin: 0 0 10px 0;
}

.chat-text-large .greeting {
    font-size: 1.15rem;
    font-weight: bold;
    color: #2B5F8A;
}

.chat-text-large .highlight {
    color: #5BC0BE;
    font-weight: bold;
}

.chat-footer {
    margin-top: 15px;
    padding-top: 10px;
    border-top: 1px solid #e0e0e0;
    font-size: 0.8rem;
    color: #888;
    display: flex;
    align-items: center;
    gap: 8px;
}

.chat-footer i {
    color: #5BC0BE;
    animation: blink-dot 1.5s ease-in-out infinite;
}

/* Animaciones */
@keyframes float-robot {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}

@keyframes neon-pulse {
    0%, 100% { box-shadow: 0 0 10px rgba(91, 192, 190, 0.4); border-color: #5BC0BE; }
    50% { box-shadow: 0 0 18px rgba(91, 192, 190, 0.7); border-color: #cffff7; }
}

@keyframes ai-pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.08); opacity: 0.7; }
}

@keyframes wave-high {
    0%, 100% { transform: rotate(-110deg); }
    50% { transform: rotate(-85deg); }
}

@keyframes wave-low {
    0%, 100% { transform: rotate(10deg); }
    50% { transform: rotate(-15deg); }
}

@keyframes shadow-size {
    0%, 100% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(0.8); opacity: 0.3; }
}

@keyframes blink {
    0%, 90%, 100% { transform: scaleY(1); }
    95% { transform: scaleY(0.1); }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateX(-15px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes blink-dot {
    0%, 100% { opacity: 0.4; }
    50% { opacity: 1; }
}

.eye-blink {
    animation: blink 0.2s ease-in-out;
}

/* Responsive */
@media (max-width: 600px) {
    .robot-container {
        flex-direction: column;
        justify-content: center;
        gap: 20px;
    }
    
    .chat-bubble-large::before,
    .chat-bubble-large::after {
        display: none;
    }
    
    .chat-bubble-large {
        margin-top: 15px;
    }
}
</style>

<div class="robot-container">
    <!-- Robot (izquierda) -->
    <div class="robot-scene">
        <div class="robot">
            <!-- Cabeza -->
            <div class="robot-head">
                <div class="robot-headset-pad pad-left"></div>
                <div class="robot-headset-pad pad-right"></div>
                <div class="robot-mic-arm"><div class="robot-mic-tip"></div></div>
                <div class="robot-visor">
                    <div class="robot-eye left-eye"></div>
                    <div class="robot-eye right-eye"></div>
                </div>
            </div>
            <!-- Cuerpo -->
            <div class="robot-body">
                <div class="robot-arm left"></div>
                <div class="robot-arm right"></div>
                <div class="robot-logo">OLI</div>
            </div>
        </div>
        <div class="robot-shadow"></div>
    </div>

    <!-- Burbuja de chat GRANDE (derecha) -->
    <div class="chat-bubble-large">
        <div class="chat-header">
            <i class="fas fa-robot"></i>
            <h4>Oliver - Asistente Virtual</h4>
        </div>
        <div class="chat-text-large" id="chat-text-large">
            <span class="greeting" id="typed-message"></span>
            <span id="typed-cursor" class="cursor-blink"></span>
        </div>
        <div class="chat-footer">
            <i class="fas fa-circle"></i>
            <span>Asistente en línea</span>
        </div>
    </div>
</div>

<style>
/* Estilos del cursor para efecto máquina de escribir */
.cursor-blink {
    display: inline-block;
    width: 3px;
    height: 18px;
    background-color: #5BC0BE;
    margin-left: 2px;
    vertical-align: middle;
    animation: blink-cursor 0.8s step-end infinite;
}

@keyframes blink-cursor {
    from, to { opacity: 1; }
    50% { opacity: 0; }
}
</style>

<script>
// ============================================
// EFECTO MÁQUINA DE ESCRIBIR EN LA BURBUJA
// ============================================
(function() {
    const mensaje = "¡Hola! Soy Oliver, un asistente virtual en desarrollo.<br><br> Quiero darte la Bienvenida a SIGEP, un <span class='highlight'>Sistema Integrado de Gestión de Postgrados</span>, una plataforma moderna diseñada y actualizada para optimizar la administración académica. Aquí podrás gestionar estudiantes, programas de postgrado, matrículas y generar reportes de manera fácil y rápida.<br><br>";
    
    const typedSpan = document.getElementById('typed-message');
    const cursorSpan = document.getElementById('typed-cursor');
    
    if (!typedSpan) return;
    
    let i = 0;
    
    function typeWriter() {
        if (i < mensaje.length) {
            const char = mensaje.charAt(i);
            if (char === '<') {
                // Encontrar la etiqueta completa
                const closeIndex = mensaje.indexOf('>', i);
                if (closeIndex !== -1) {
                    const tag = mensaje.substring(i, closeIndex + 1);
                    typedSpan.innerHTML += tag;
                    i = closeIndex + 1;
                } else {
                    typedSpan.innerHTML += char;
                    i++;
                }
            } else {
                typedSpan.innerHTML += char;
                i++;
            }
            setTimeout(typeWriter, 30);
        } else {
            // Terminó de escribir, ocultar cursor
            if (cursorSpan) {
                cursorSpan.style.display = 'none';
            }
        }
    }
    
    // Iniciar el efecto después de medio segundo
    setTimeout(typeWriter, 500);
})();

// ============================================
// PARPADEO DE OJOS DEL ROBOT
// ============================================
(function() {
    const eyes = document.querySelectorAll('.robot-eye');
    
    function blinkEyes() {
        eyes.forEach(eye => {
            eye.classList.add('eye-blink');
            setTimeout(() => {
                eye.classList.remove('eye-blink');
            }, 200);
        });
        setTimeout(blinkEyes, Math.random() * 4000 + 2000);
    }
    
    if (eyes.length > 0) {
        blinkEyes();
    }
})();
</script>