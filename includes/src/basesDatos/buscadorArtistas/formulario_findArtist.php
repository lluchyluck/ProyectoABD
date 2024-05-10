<?php

require_once __DIR__ . "/../../../config.php";
require RUTA_INCLUDES . "/src/formulario.php";
require RUTA_INCLUDES . "/src/app.php";


class formulario_findArtist extends formulario
{
    public function __construct() {
        parent::__construct('formFindARtist', ['urlRedireccion' => '/ProyectoABD/index.php']);
    }
    
    private function htmlGeneros(){
        $html .= "<select id='genero' name='genero'>";
        $app = Aplicacion::getInstance();
        $generos = $app->getAllGenders();
        foreach($generos as $genero){
            $html .=  "<option value=" . $genero . ">". $genero."</option>";
        }
        $html .= "<select id='genero' name='genero'>";
        return $html;
    }
    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['buscarArtista', 'genero'], $this->errores, 'span', array('class' => 'error'));

        //$rutaRegistro = RUTA_INCLUDES . "/src/register/register.php";
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $htmlSelect= $this->htmlGeneros();
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Buscador de Artistas:</legend>
            <div>
                <label for="buscarArti">Nombre:</label>
                <input id="buscarArtista" type="text" name="buscarArtista"/>
                {$erroresCampos['buscarArtista']}
            </div>
            <br>
            <div>
                <label for="Gener">Genero:</label>
                
                $htmlSelect
                {$erroresCampos['genero']}
            </div>
            <br>
            <div>
                <button type="submit" name="buscar">Sumbit</button>
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
            $cancion = $app->getArtist($nombre,$genero);
        }
    }
}