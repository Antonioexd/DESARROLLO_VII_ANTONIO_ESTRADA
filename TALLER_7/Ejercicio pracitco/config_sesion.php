<?php
session_start();

// Configuraciones seguras de sesión
ini_set('session.cookie_httponly', 1);  // Evitar acceso a cookies vía JavaScript
ini_set('session.use_strict_mode', 1);  // Rechazar ID de sesión no válidos

// Otras configuraciones opcionales
session_regenerate_id(true);  // Regenerar ID de sesión para mayor seguridad
?>
