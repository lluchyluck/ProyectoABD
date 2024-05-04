<?php

namespace abd;

use abd\usuarios\Usuario;

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
                } else {
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
    public function objectToDataBase($objeto)
    {
        if (is_a($objeto, "Usuario")) {
            $this->insertarUsuario($objeto);
        } elseif (is_a($objeto, "Cancion")) {

        } else {
            echo "El objeto no pertenece a ninguna clase conocida";
            return false;
        }
    }
    private function insertarUsuario($usuario)
    {
        return $usuario->insertarBd($this->instancia);
    }
    public function getAllUsers()
    {
        $bd = $this->getConexionBd();
        $sql = "SELECT DISTINCT id,username FROM usuarios";
        $result = mysqli_query($bd, $sql);
        if (mysqli_num_rows($result) > 0) {
            $usernames = array(); 

            while ($row = mysqli_fetch_assoc($result)) {
                $usernames[$row['id']] = $row["username"];
            }
            mysqli_free_result($result); 
            return $usernames; 
        } else {
            return null; 
        }
    }
    public function existeUsuario($nombreUsuario){
        $users = $this->getAllUsers();
        foreach ($users as $userId => $userData) {
            if ($userData['username'] === $nombreUsuario) {
                
                return $userId;
            }
        }
        return null;
    }

}