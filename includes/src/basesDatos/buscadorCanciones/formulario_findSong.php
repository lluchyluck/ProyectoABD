<?php

require_once __DIR__ . "/../../../config.php";
require RUTA_INCLUDES . "/src/formulario.php";
require RUTA_INCLUDES . "/src/app.php";


class formulario_findSong extends formulario
{
    public function __construct() {
        parent::__construct('formFindSong', ['urlRedireccion' => '/ProyectoABD/index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['buscarCancion', 'genero'], $this->errores, 'span', array('class' => 'error'));

        //$rutaRegistro = RUTA_INCLUDES . "/src/register/register.php";
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Buscador de canciones:</legend>
            <div>
                <label for="buscarCancio">Nombre:</label>
                <input id="buscarCancion" type="text" name="buscarCancion"/>
                {$erroresCampos['buscarCancion']}
            </div>
            <br>
            <div>
                <label for="Gener">Genero:</label>
                <select id="genero" name="genero">
                <option value="Reggaeton">Reggaeton</option>
                <option value="Jazz">Jazz</option>
                <option value="Techno">Techno</option>
                <option value="Pop">Pop</option>
                <option value="Clasica">Clasica</option>
                <option value="Rock">Rock</option>
                <option value="Electronica">Electronica</option>
            </select>
                {$erroresCampos['genero']}
            </div>
            <br>
            <div>
                <button type="submit" name="login">Sumbit</button>
            </div>

        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $nombre = trim($datos['buscarCancion'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || empty($nombre) ) {
            $this->errores['buscarCancion'] = '<span style="color: red;">La cancion no puede estar vacia.</span>';
        }
        
        $genero = trim($datos['genero'] ?? '');
        $genero = filter_var($genero, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (count($this->errores) === 0) {
            $app = Aplicacion::getInstance();
            $cancion = $app->getSong($nombre,$genero);
        }
    }
}