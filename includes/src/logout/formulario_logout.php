<?php

require_once __DIR__ . "/../../config.php";
require RUTA_INCLUDES . "/src/app.php";
require RUTA_INCLUDES . "/src/formulario.php";

class formulario_logout extends formulario
{
    protected $app;
    protected $usuario;

    public function __construct()
    {

        parent::__construct('formAddUser', ['urlRedireccion' => "/ProyectoABD/index.php", 'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $html = <<<EOS
        EOS;
        return $html;
    }

    public protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();
        $app->logout();
    }
}