<?php


class Aplicacion
{

    private static $instancia;

    public static function getInstance()
    {
        if (!self::$instancia instanceof self) {
            self::$instancia = new static();
        }
        return self::$instancia;
    }

    private function __construct()
    {
        $this->inicializada = false;
        $this->generandoError = false;
    }

	
    
}