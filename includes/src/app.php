<?php

require_once __DIR__ . "/../config.php";
include RUTA_INCLUDES . "/src/usuario.php";

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
        if (!isset($this->db)) {
            $bdHost = "localhost";
            $bdUser = "root";
            $bdPass = "";
            $bdName = "ProyectoABD";

            $db = @mysqli_connect($bdHost, $bdUser, $bdPass, $bdName);
            if ($db) {
                $this->db = $db;
            } else {
                echo 'Conexión erronea a la base de datos';
            }
        }
        return $this->db;

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
            return $this->insertarUsuario($objeto);
        } elseif (is_a($objeto, "Cancion")) {

        } else {
            echo "El objeto no pertenece a ninguna clase conocida";
            return false;
        }
    }
    private function insertarUsuario($usuario)
    {
        $bd = $this->getConexionBd();

        $usuario->setId($this->nextId());

        $sqlQuery = "INSERT INTO usuarios (id, username, password, img) VALUES (" . $usuario->getId() . ", '" . $usuario->getUsername() . "', '" . $usuario->getPassword() . "', '" . $usuario->getImg() . "')";
        $result = mysqli_query($bd, $sqlQuery);

        if ($result) {
            echo "[+]Usuario añadido exitosamente";
            return true;
        } else {
            echo "[-]No se pudo añadir al usuario, error de mysql";
            return false;
        }
    }
    private function nextId()
    {
        $db = $this->getConexionBd();
        $maxIDquery = "SELECT MAX(id) FROM usuarios";
        $resultmaxIDquery = mysqli_query($db, $maxIDquery);
        $row = mysqli_fetch_row($resultmaxIDquery);
        $maxId = $row[0];
        mysqli_free_result($resultmaxIDquery);
        return $maxId + 1;
    }
    public function getAllUsers()
    {
        $bd = $this->getConexionBd();
        $sql = "SELECT id, username, password, img FROM usuarios";
        $result = mysqli_query($bd, $sql);

        if (mysqli_num_rows($result) > 0) {
            $users = array();
            while ($row = mysqli_fetch_assoc($result)) {
                echo "$row";
                $users[] = $row; // Add complete user data to the array
            }
            mysqli_free_result($result);
            return $users;
        } else {
            return null;
        }
    }
    public function getAllSongs(){
        $bd = $this->getConexionBd();
        $sql = "SELECT name,genero,artista,duracion FROM canciones";
        $result = mysqli_query($bd, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $canciones = array();
            while ($row = mysqli_fetch_assoc($result)) {
                echo "$row";
                $canciones[] = $row; // Add complete user data to the array
            }
            
            mysqli_free_result($result);
            return $canciones;
        } else {
            return null;
        }
    }
    public function getSong($nombre, $genero){
        $bd = $this->getConexionBd();
        $sql = "SELECT name,genero FROM canciones WHERE name = " . $nombre . " AND genero = " . $genero . "";
        $result = mysqli_query($bd, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $cancion = mysqli_fetch_assoc($result); // Add complete user data to the array
            mysqli_free_result($result);
            return $cancion;
        } else {
            return null;
        }

    }
    public function existeUsuario($nombreUsuario)
    {
        $users = $this->getAllUsers();

        if (empty($users) || $users == null) {
            return null; // No users found, not an error
        }

        foreach ($users as $user) {
            if ($user['username'] === $nombreUsuario) {
                return $user; // Return the complete user data
            }
        }

        return null;
    }
    public function login($user)
    {
        $_SESSION["login"] = true;
        $_SESSION["id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["img"] = $user["img"];
        $_SESSION["mensaje"] = "Usuario logeado con exito: " . $user["username"];
    }
    public function logout()
    {
        unset($_SESSION['login']);
        unset($_SESSION['username']);
        unset($_SESSION['id']);
        unset($_SESSION['img']);
        session_destroy();
        session_start();
        $_SESSION["mensaje"] = "Sesion cerrada!!!";
    }
}