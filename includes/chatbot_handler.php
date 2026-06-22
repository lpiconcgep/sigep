<?php
// includes/chatbot_handler.php - Manejador de preguntas del chatbot
require_once 'chatbot_respuestas.php';

// Verificar que se recibió una pregunta
if (isset($_POST['pregunta']) && !empty($_POST['pregunta'])) {
    $pregunta = $_POST['pregunta'];
    
    // Obtener respuesta
    $respuesta = buscar_respuesta_chatbot($pregunta);
    
    // Devolver respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'pregunta' => htmlspecialchars($pregunta),
        'respuesta' => $respuesta
    ]);
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'No se recibió ninguna pregunta'
    ]);
}
?>