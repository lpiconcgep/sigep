<?php
// ============================================
// utilidades.php - Funciones de utilidad
// ============================================

/**
 * Transforma fecha de formato YYYY-MM-DD a DD-MM-YYYY
 */
function transforma_fecha($fecha) {
    if (empty($fecha) || $fecha == '0000-00-00' || $fecha == '0000-00-00 00:00:00') {
        return '-';
    }
    
    $timestamp = strtotime($fecha);
    if ($timestamp === false) {
        return $fecha;
    }
    
    return date("d-m-Y", $timestamp);
}

/**
 * Transforma fecha y hora de formato YYYY-MM-DD HH:MM:SS a DD-MM-YYYY HH:MM:SS
 */
function transforma_fecha_hora($fecha_hora) {
    if (empty($fecha_hora) || $fecha_hora == '0000-00-00 00:00:00') {
        return '-';
    }
    
    $timestamp = strtotime($fecha_hora);
    if ($timestamp === false) {
        return $fecha_hora;
    }
    
    return date("d-m-Y H:i:s", $timestamp);
}

/**
 * Transforma fecha de formato YYYY-MM-DD a formato personalizado
 */
function transforma_fecha_custom($fecha, $formato = 'd/m/Y') {
    if (empty($fecha) || $fecha == '0000-00-00') {
        return '-';
    }
    
    $timestamp = strtotime($fecha);
    if ($timestamp === false) {
        return $fecha;
    }
    
    return date($formato, $timestamp);
}

/**
 * Formatea un número como moneda
 */
function formato_moneda($numero) {
    return number_format($numero, 2, ',', '.');
}

/**
 * Limpia una cadena de texto para evitar inyecciones
 */
function limpiar_texto($texto) {
    return htmlspecialchars(strip_tags(trim($texto)), ENT_QUOTES, 'UTF-8');
}
?>