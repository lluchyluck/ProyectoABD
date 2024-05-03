<?php

namespace abd;


class Aplicacion
{

    private static $instancia;

    private $db;

    public static function getInstance()
    {
        if (!self::$instancia instanceof self) {
            self::$instancia = new static();
        }
        return self::$instancia;
    }

    public function getConexionBd()
    {
        if ($this->isInitialized()) {
            if (!isset($this->db)) {
                $bdHost = "localhost";
                $bdUser = "root";
                $bdPass = "";
                $bdName = "ProyectoABD";

                $db = @mysqli_connect($bdHost, $bdUser, $bdPass, $bdName);
                if ($db) {
                    echo 'Conexión realizada correctamente.<br />';
                    $this->db = $db;
                }else{
                    echo 'Conexión erronea a la base de datos';
                }
            }
            return $this->db;
        }
    }
    private function isInitialized()
    {
        if (isset($this->instancia)) {
            return true;
        } else {
            return false;
        }
    }

}