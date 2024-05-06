<?php


require_once __DIR__ . "/../../config.php";
require RUTA_INCLUDES . "/src/logout/formulario_logout.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /ProyectoABD/index.php");
}

$datos = null;
$formLogout = new formulario_logout();

$formLogout->procesaFormulario($datos);
echo "hola";