<?php

// Definir variables globales para rutas en la aplicación web
define('BASE_URL', __DIR__ . '/..'); // Ruta base del proyecto (ajustar a la URL real)
//define('BASE_URL', '/ProyectoABD'); // Ruta base del proyecto (ajustar a la URL real)
define('CARPETAS_ASSETS', BASE_URL . '/assets'); // Ruta de la carpeta de recursos estáticos (imágenes, CSS, JS)
define('VISTAS', BASE_URL . '/vistas'); // Ruta de la carpeta de plantillas HTML
define('INCLUDES', BASE_URL . '/includes'); // Ruta de la carpeta de funciones y código reutilizable
define('MYSQL', BASE_URL . '/mysql'); // Ruta de la carpeta de consultas y configuraciones de MySQL
define('RUTA_CSS','/ProyectoABD/assets/css/style.css'); // Ruta de la carpeta de consultas y configuraciones de MySQL



// Comprobar si la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
