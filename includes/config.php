<?php
// includes/config.php

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Función para obtener la ruta base según la profundidad
function get_base_path($current_file) {
    $base = '';
    $depth = substr_count($current_file, '/') - substr_count($current_file, 'sigep_prototipo/');
    for ($i = 0; $i < $depth; $i++) {
        $base .= '../';
    }
    return $base;
}

// La base se definirá en cada archivo según su ubicación
?>