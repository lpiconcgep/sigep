<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robot Asistente AI - Voz Serena</title>
    <style>
        /* --- Configuración del Fondo --- */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: radial-gradient(circle at center, #ffffff 0%, #eef2f3 100%);
            margin: 0;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
            cursor: pointer; /* Indica que se puede interactuar */
        }

        .scene {
            position: relative;
            width: 200px;
            height: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- Animación de Levitación Principal --- */
        .robot {
            position: absolute;
            bottom: 70px;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: float 5s ease-in-out infinite;
            z-index: 2;
        }

        /* --- Cabeza y Headset --- */
        .head {
            width: 165px;
            height: 125px;
            background: linear-gradient(145deg, #ffffff 0%, #e6f7ff 100%);
            border: 3px solid #333;
            border-radius: 45px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1), inset -4px -4px 10px rgba(0,0,0,0.05);
        }

        .head::before {
            content: '';
            position: absolute;
            top: -12px;
            width: 105%;
            height: 40px;
            border: 10px solid #2c3e50;
            border-bottom: none;
            border-radius: 70px 70px 0 0;
            box-sizing: border-box;
        }

        .headset-pad {
            position: absolute;
            width: 20px;
            height: 55px;
            background-color: #2c3e50;
            border-radius: 8px;
            top: 30px;
        }
        .pad-left { left: -18px; }
        .pad-right { right: -18px; }

        .mic-arm {
            position: absolute;
            width: 40px;
            height: 4px;
            background-color: #2c3e50;
            bottom: 25px;
            left: -15px;
            transform: rotate(30deg);
        }
        .mic-tip {
            position: absolute;
            width: 14px;
            height: 14px;
            background-color: #2c3e50;
            border-radius: 50%;
            bottom: -5px;
            right: -10px;
            box-shadow: 0 0 8px rgba(79, 251, 223, 0.6);
        }

        /* --- Visor y Rostro Neón --- */
        .visor {
            width: 130px;
            height: 85px;
            background: linear-gradient(180deg, #1a2a3a 0%, #0d141d 100%);
            border-radius: 28px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0 12px;
            box-sizing: border-box;
            border: 3px solid #4ffbdf;
            box-shadow: 0 0 15px rgba(79, 251, 223, 0.4);
            animation: neon-pulse 2s ease-in-out infinite;
        }

        .eye {
            width: 30px;
            height: 15px;
            border: 4.5px solid #cffff7;
            border-bottom: none;
            border-radius: 25px 25px 0 0;
            filter: drop-shadow(0 0 6px #4ffbdf);
        }

        /* --- Cuerpo y Logo AI --- */
        .body-torso {
            width: 110px;
            height: 115px;
            background: linear-gradient(145deg, #ffffff 0%, #e6f7ff 100%);
            border: 3px solid #333;
            border-radius: 35px;
            position: relative;
            display: flex;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .body-torso::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #2c3e50;
            border-radius: 32px;
            z-index: -1;
            clip-path: polygon(0 0, 15% 0, 15% 100%, 0 100%, 85% 100%, 100% 100%, 100% 0, 85% 0);
        }

        .ai-logo {
            margin-top: 40px;
            font-size: 28px;
            font-weight: 900;
            color: #4ffbdf;
            letter-spacing: 2px;
            filter: drop-shadow(0 0 10px rgba(79, 251, 223, 0.8));
            animation: ai-pulse 2.5s ease-in-out infinite;
        }

        /* --- Brazos --- */
        .arm {
            position: absolute;
            width: 32px;
            height: 75px;
            background: linear-gradient(145deg, #ffffff 0%, #e6f7ff 100%);
            border: 3px solid #333;
            border-radius: 18px;
            transform-origin: center 12px;
        }

        .arm.left { left: -42px; top: 5px; animation: wave-high 3s ease-in-out infinite; }
        .arm.right { right: -42px; top: 20px; animation: wave-low 2s ease-in-out infinite; }

        .shadow {
            position: absolute;
            bottom: 20px;
            width: 120px;
            height: 35px;
            background: rgba(79, 251, 223, 0.15);
            border-radius: 50%;
            filter: blur(6px);
            animation: shadow-size 5s ease-in-out infinite;
        }

        /* --- Animaciones --- */
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-18px); } }
        @keyframes neon-pulse { 0%, 100% { box-shadow: 0 0 15px rgba(79, 251, 223, 0.4); border-color: #4ffbdf; } 50% { box-shadow: 0 0 25px rgba(79, 251, 223, 0.7); border-color: #cffff7; } }
        @keyframes ai-pulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.1); opacity: 0.7; } }
        @keyframes wave-high { 0%, 100% { transform: rotate(-110deg); } 50% { transform: rotate(-85deg); } }
        @keyframes wave-low { 0%, 100% { transform: rotate(10deg); } 50% { transform: rotate(-15deg); } }
        @keyframes shadow-size { 0%, 100% { transform: scale(1); opacity: 0.8; } 50% { transform: scale(0.7); opacity: 0.4; } }
        @keyframes blink { 0%, 90%, 100% { transform: scaleY(1); } 95% { transform: scaleY(0.1); } }
        .eye-blink { animation: blink 0.2s ease-in-out; }

        /* Estilo para el aviso de interacción */
        .instruction {
            position: absolute;
            bottom: 20px;
            color: #2c3e50;
            font-size: 14px;
            opacity: 0.6;
        }
    </style>
</head>
<body>

    <div class="scene">
        <div class="robot">
            <div class="head">
                <div class="headset-pad pad-left"></div>
                <div class="headset-pad pad-right"></div>
                <div class="mic-arm"><div class="mic-tip"></div></div>
                <div class="visor">
                    <div class="eye left-eye"></div>
                    <div class="eye right-eye"></div>
                </div>
            </div>

            <div class="body-torso">
                <div class="arm left"></div>
                <div class="arm right"></div>
                <div class="ai-logo">SIRI</div>
            </div>
        </div>
        <div class="shadow"></div>
    </div>

    <div class="instruction">Haz clic para escuchar la bienvenida</div>

    <script>
        const eyes = document.querySelectorAll('.eye');

        // Función de parpadeo (se mantiene igual)
        function startBlinking() {
            eyes.forEach(eye => {
                eye.classList.remove('eye-blink');
                void eye.offsetWidth; 
                eye.classList.add('eye-blink');
            });
            setTimeout(startBlinking, Math.random() * 4000 + 2000);
        }

        // --- LÓGICA DE VOZ SERENA ---
        function hablarSereno() {
            // Cancelar cualquier discurso previo
            window.speechSynthesis.cancel();

            const saludo = new SpeechSynthesisUtterance("Bienvenido David. Es un gusto verte de nuevo. Respira profundo, todo está en calma.");
            
            saludo.lang = 'es-ES';
            saludo.pitch = 0.95; // Tono ligeramente más bajo para calidez
            saludo.rate = 0.85;  // Velocidad pausada y tranquila
            saludo.volume = 0.9;

            // Intentar encontrar una voz femenina de alta calidad
            const voices = window.speechSynthesis.getVoices();
            const softVoice = voices.find(v => v.name.includes('Google') || v.name.includes('Soft') || v.name.includes('Helena'));
            if (softVoice) saludo.voice = softVoice;

            window.speechSynthesis.speak(saludo);
        }

        // Iniciar parpadeo
        startBlinking();

        // Escuchar el clic para la bienvenida (requerido por navegadores)
        document.body.addEventListener('click', () => {
            hablarSereno();
            document.querySelector('.instruction').style.display = 'none';
        }, { once: true });
    </script>

</body>
</html>