<?php


require_once __DIR__ . "/../../config.php";



$htmlNombreUsuario = '<h2 style="display: inline;">' . $_SESSION["username"] . '</h2>';
$imgSrc = $_SESSION["img"];
$idUser = $_SESSION["id"];
$tituloPagina = 'Perfil';

$html = <<<EOS
<article>

    <fieldset>
        <legend>$htmlNombreUsuario</legend>
        <div>
        <img src="/ProyectoABD/assets/img/$imgSrc" alt="Texto alternativo para la imagen" width="150" height="150">
        </div>
        <div>
        <label>ID: $idUser<label>
        </div>
    </fieldset>

    
</article>
EOS;

require RUTA_INCLUDES . "/plantilla.php";
