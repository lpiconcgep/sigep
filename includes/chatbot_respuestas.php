<?php
// includes/chatbot_respuestas.php - Base de conocimientos del asistente Oliver

$respuestas_chatbot = [
    // ============================================
    // SALUDOS Y PRESENTACIÓN
    // ============================================
    'hola' => [
        'keywords' => ['hola', 'buenos días', 'buenas tardes', 'buenas noches', 'saludos', 'hey', 'que tal'],
        'respuesta' => '¡Hola! Soy Oliver, tu asistente virtual del SIGEP. ¿En qué puedo ayudarte hoy? 😊'
    ],
    'como estas' => [
        'keywords' => ['como estas', 'que tal estas', 'como te va', 'estas bien'],
        'respuesta' => '¡Estoy excelente! Siempre listo para ayudarte con la gestión de postgrados. ¿Qué necesitas saber? 🚀'
    ],
    'quien eres' => [
        'keywords' => ['quien eres', 'quien sos', 'que eres', 'presentate'],
        'respuesta' => 'Soy <strong>Oliver</strong>, el asistente virtual del Sistema Integrado de Gestión de Postgrados (SIGEP). Fui creado para ayudarte a navegar y utilizar todas las funcionalidades del sistema de manera fácil y rápida. 🤖'
    ],
    'gracias' => [
        'keywords' => ['gracias', 'muchas gracias', 'gracias por', 'agradezco'],
        'respuesta' => '¡De nada! Es un placer ayudarte. Si necesitas algo más, aquí estoy. 😊'
    ],
    'adios' => [
        'keywords' => ['adios', 'chao', 'hasta luego', 'nos vemos', 'bye'],
        'respuesta' => '¡Hasta luego! Recuerda que estoy aquí cuando me necesites. ¡Vuelve pronto! 👋'
    ],

    // ============================================
    // INFORMACIÓN GENERAL DEL SISTEMA
    // ============================================
    'que es sigep' => [
        'keywords' => ['que es sigep', 'sigep', 'sistema', 'que hace', 'que es el sistema'],
        'respuesta' => 'El <strong>SIGEP</strong> (Sistema Integrado de Gestión de Postgrados) es una plataforma tecnológica diseñada para optimizar y modernizar la administración académica de programas de postgrado, ofreciendo herramientas para la gestión integral de estudiantes, docentes y procesos académicos. 🎓'
    ],
    'que hace sigep' => [
        'keywords' => ['funciones', 'para que sirve', 'utilidad', 'herramientas', 'características'],
        'respuesta' => 'SIGEP permite: <br>• Gestionar estudiantes y sus datos académicos<br>• Administrar programas y postgrados<br>• Generar reportes y estadísticas<br>• Crear documentos en PDF<br>• Buscar información de manera avanzada<br>• Gestionar cohortes y matrículas 📋'
    ],
    'quien creo sigep' => [
        'keywords' => ['creador', 'quien lo hizo', 'desarrollador', 'quien desarrollo', 'quien creo'],
        'respuesta' => 'SIGEP fue desarrollado por un equipo de profesionales apasionados por la educación y la tecnología, con el objetivo de brindar una solución moderna y eficiente para la gestión de postgrados. 👨‍💻'
    ],

    // ============================================
    // MÓDULOS Y FUNCIONALIDADES
    // ============================================
    'personas' => [
        'keywords' => ['personas', 'estudiantes', 'gestión de estudiantes', 'alumnos'],
        'respuesta' => 'En el módulo de <strong>Personas</strong> puedes: <br>• Registrar nuevos estudiantes<br>• Editar información personal<br>• Buscar personas por documento, nombre o apellido<br>• Ver el historial académico completo<br>• Gestionar el estado del estudiante (activo/inactivo) 👤'
    ],
    'postgrados' => [
        'keywords' => ['postgrado', 'postgrados', 'maestría', 'doctorado', 'especialización'],
        'respuesta' => 'El módulo de <strong>Postgrados</strong> te permite: <br>• Crear y administrar postgrados<br>• Asignar facultades o núcleos<br>• Ver la lista de programas por postgrado<br>• Gestionar cohortes<br>• Asignar coordinadores académicos 🎯'
    ],
    'programas' => [
        'keywords' => ['programa', 'programas', 'pensum', 'asignaturas', 'materias'],
        'respuesta' => 'En <strong>Programas</strong> puedes: <br>• Crear programas académicos<br>• Asignarlos a un postgrado<br>• Ver la cantidad de inscritos<br>• Gestionar cohortes<br>• Administrar datos de contacto y coordinadores 📚'
    ],
    'matriculas' => [
        'keywords' => ['matrícula', 'matrículas', 'inscripción', 'inscripciones', 'registro'],
        'respuesta' => 'El módulo de <strong>Matrículas</strong> permite: <br>• Inscribir estudiantes en programas<br>• Registrar fechas de ingreso<br>• Gestionar el estado de la matrícula<br>• Ver historial académico del estudiante<br>• Generar constancias de estudio 📝'
    ],
    'reportes' => [
        'keywords' => ['reporte', 'reportes', 'estadísticas', 'informes', 'pdf'],
        'respuesta' => 'Puedes generar <strong>Reportes</strong> como: <br>• Listado de estudiantes por programa<br>• Reporte por años de ingreso<br>• Estadísticas de inscritos<br>• Descargar en formato PDF<br>• Filtrar por programa, año y estado 📊'
    ],
    'cohortes' => [
        'keywords' => ['cohorte', 'cohortes', 'promoción', 'generación', 'año'],
        'respuesta' => 'Las <strong>Cohortes</strong> agrupan estudiantes por año de ingreso. Puedes: <br>• Crear nuevas cohortes<br>• Asignar estudiantes a cohortes<br>• Ver el progreso académico<br>• Gestionar fechas importantes 🗓️'
    ],

    // ============================================
    // FUNCIONALIDADES ESPECÍFICAS
    // ============================================
    'pdf' => [
        'keywords' => ['pdf', 'descargar pdf', 'generar pdf', 'imprimir'],
        'respuesta' => 'Puedes generar archivos <strong>PDF</strong> desde: <br>• Reporte de estudiantes<br>• Listado de postgrados<br>• Informes de matrículas<br>• Constancias y certificados<br>Solo haz clic en el botón "Descargar PDF" 📄'
    ],
    'buscar' => [
        'keywords' => ['buscar', 'búsqueda', 'buscar persona', 'encontrar', 'localizar'],
        'respuesta' => 'La <strong>Búsqueda Avanzada</strong> te permite: <br>• Buscar por documento de identidad<br>• Buscar por nombre o apellido<br>• Buscar por correo electrónico<br>• Resultados instantáneos<br>• Ver toda la información del estudiante 🔍'
    ],
    'facultades' => [
        'keywords' => ['facultad', 'facultades', 'núcleo', 'núcleos'],
        'respuesta' => 'Los <strong>Núcleos o Facultades</strong> son las unidades académicas que agrupan los postgrados. Puedes: <br>• Administrar facultades<br>• Asignar postgrados a facultades<br>• Filtrar postgrados por facultad 🏛️'
    ],

    // ============================================
    // AYUDA Y SOPORTE
    // ============================================
    'ayuda' => [
        'keywords' => ['ayuda', 'soporte', 'asistencia', 'ayudame', 'necesito ayuda'],
        'respuesta' => '¡Claro! Estoy aquí para ayudarte. Puedes preguntarme sobre: <br>• Cómo funciona SIGEP<br>• Módulos del sistema<br>• Gestión de estudiantes<br>• Reportes y PDF<br>• Matrículas y cohortes<br>• Cualquier otra duda que tengas 🤝'
    ],
    'olvide' => [
        'keywords' => ['olvide', 'olvidé', 'no recuerdo', 'como se hace'],
        'respuesta' => '¡Tranquilo! Puedes preguntarme cualquier cosa. <br>Si no encuentras una funcionalidad, puedes: <br>1. Buscar en el menú principal<br>2. Usar la barra de búsqueda<br>3. Preguntarme directamente a mí<br>4. Revisar la documentación del sistema 💡'
    ],
    'error' => [
        'keywords' => ['error', 'problema', 'falla', 'no funciona', 'bug'],
        'respuesta' => 'Si encuentras un <strong>error</strong>, te recomiendo: <br>• Recargar la página<br>• Verificar tu conexión a internet<br>• Contactar al administrador del sistema<br>• Anotar el mensaje de error para reportarlo 🛠️'
    ],

    // ============================================
    // PREGUNTAS ABIERTAS Y ALEATORIAS
    // ============================================
    'default' => [
        'keywords' => [],
        'respuesta' => 'Hmm, no estoy seguro de entender tu pregunta. ¿Puedes reformularla? <br>Puedo responder sobre: <br>• SIGEP y sus funciones<br>• Gestión de estudiantes<br>• Postgrados y programas<br>• Matrículas y cohortes<br>• Reportes y PDF<br>¡Pregúntame lo que necesites! 🤔'
    ]
];

// Función para buscar respuesta por pregunta
function buscar_respuesta_chatbot($pregunta) {
    global $respuestas_chatbot;
    
    $pregunta = strtolower(trim($pregunta));
    $pregunta = preg_replace('/[^a-záéíóúñ\s]/', '', $pregunta);
    
    // Primero buscar coincidencia exacta o parcial
    $mejor_coincidencia = null;
    $max_palabras = 0;
    
    foreach ($respuestas_chatbot as $key => $data) {
        if (empty($data['keywords'])) continue;
        
        foreach ($data['keywords'] as $keyword) {
            $keyword = strtolower($keyword);
            // Verificar si la palabra clave está en la pregunta
            if (strpos($pregunta, $keyword) !== false) {
                $palabras_encontradas = substr_count($pregunta, $keyword);
                if ($palabras_encontradas > $max_palabras) {
                    $max_palabras = $palabras_encontradas;
                    $mejor_coincidencia = $key;
                }
            }
        }
    }
    
    if ($mejor_coincidencia !== null && isset($respuestas_chatbot[$mejor_coincidencia])) {
        return $respuestas_chatbot[$mejor_coincidencia]['respuesta'];
    }
    
    // Si no hay coincidencia, devolver respuesta por defecto
    return $respuestas_chatbot['default']['respuesta'];
}
?>