<?php

require_once __DIR__ . "/../../../config.php";
require_once RUTA_INCLUDES . "/src/app.php";
require RUTA_INCLUDES . "/src/basesDatos/buscadorCanciones/formulario_findSong.php";

$tituloPagina = 'Canciones Favoritas';

$app = Aplicacion::getInstance();

$html = "";
$html .= verCancionesFavoritas($app);
$html .= verAñadirCanciones();


require RUTA_INCLUDES . "/plantilla.php";

function verCancionesFavoritas($app)
{
    $html = "";
    $songs = $app->getAllFavouriteSongs();


    if (!isset($songs)) {
        $html = "<p>No hay canciones para mostrar</p>";
        return $html;
    }
    $html .= "<h3>Canciones favoritas de: " . $_SESSION["username"] . "</h3>";
    $html .= "<table>";
    $html .= "<tr><th>Nombre</th><th>Género</th><th>Artista</th><th>Duración</th></tr>";

    foreach ($songs as $song) {
        $html .= "<tr>";
        $html .= "<td>" . $song['name'] . "</td>";
        $html .= "<td>" . $song['genero'] . "</td>";
        $html .= "<td>" . $song['artista'] . "</td>";
        $html .= "<td>" . $song['duracion'] . "</td>";
        $html .= "</tr>";
    }

    $html .= "</table>";
    return $html;
}
function verAñadirCanciones()
{
    $html = "";
    $formFindSong = new formulario_findSong();
    $htmlFormFindSong = $formFindSong->gestiona();
    $html .= "<h3>Añadir cancion favorita: </h3>";
    $html .= <<<EOS
    <article>
        $htmlFormFindSong
    </article>
    EOS;
    return $html;

}