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

                $users[] = $row; // Add complete user data to the array
            }
            mysqli_free_result($result);
            return $users;
        } else {
            return null;
        }
    }
    public function getAllSongs()
    {
        $bd = $this->getConexionBd();
        $sql = "SELECT name,genero,artista,duracion FROM canciones";
        $result = mysqli_query($bd, $sql);

        if (mysqli_num_rows($result) > 0) {
            $canciones = array();
            while ($row = mysqli_fetch_assoc($result)) {

                $canciones[] = $row; // Add complete user data to the array
            }

            mysqli_free_result($result);
            return $canciones;
        } else {
            return null;
        }
    }
    public function getAllGenders()
    {
        $bd = $this->getConexionBd();
        $sql = "SELECT genero FROM generos";
        $result = mysqli_query($bd, $sql);

        if (mysqli_num_rows($result) > 0) {
            $generos = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $generos[] = $row["genero"]; // Add complete user data to the array

            }

            mysqli_free_result($result);
            return $generos;
        } else {
            return null;
        }
    }
    private function getGenericInfo()
    {
        $bd = $this->getConexionBd();
        $generos = $this->getAllGenders();
        $generosCount = array();
        foreach ($generos as $genero) {
            $sql = "SELECT COUNT(id) FROM canciones WHERE genero = '" . $genero . "'";
            $result = mysqli_query($bd, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $generosCount[$genero] = $row["COUNT(id)"];

                mysqli_free_result($result);

            }
        }
        return $generosCount;
    }
    public function displayGenericInfo()
    {
        $generosCount = $this->getGenericInfo();
        $generos = $this->getAllGenders();

        $html = "";
        $html .= "<table>";
        $html .= "<tr><th><h3>Géneros</h3></th></tr>";
        foreach ($generos as $genero) {
            $html .= "<tr><td><p><b>" . $genero . "</b>: " . $generosCount[$genero] . "</p></td></tr>";
        }

        $totalCanciones = 0;
        foreach ($generos as $genero) {
            $totalCanciones += $generosCount[$genero];
        }

        $html .= "<tr><th><label>Total canciones: " . $totalCanciones . "</label></th></tr>";
        $html .= "</table>";
        $usuarios = $this->getAllUsers();
        $html .= "----------------------------------------------------------------";
        $html .= "<label>Numero de usuarios:" . count($usuarios) . "</label>";
        $html .= "----------------------------------------------------------------";
        if ($_SESSION['login']) {
            $html .= "<p>Usuario loggeado como: <b>" . $_SESSION['username'] . "</b>,con id:<b>" . $_SESSION['id'] . "</b></p>";
        }
        return $html;
    }
    public function getSong($nombre, $genero)
    {
        $bd = $this->getConexionBd();
        if($nombre == "1" && $genero == "1"){
            return $this->getAllSongs();
        }else if($nombre == "1"){
            $sql = "SELECT name,genero,artista,duracion FROM canciones WHERE genero = '" . $genero . "'";
        }else if($genero == "1"){
            $sql = "SELECT name,genero,artista,duracion FROM canciones WHERE name = '" . $nombre . "'";
        }else{
            $sql = "SELECT name,genero,artista,duracion FROM canciones WHERE name = '" . $nombre . "' AND genero = '" . $genero . "'";
        }

        $result = mysqli_query($bd, $sql);

        if (mysqli_num_rows($result) > 0) {
            $canciones = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $canciones[] = $row; // Add complete user data to the array

            }
            
            mysqli_free_result($result);
            return $canciones;
        } else {
            return null;
        }

    }
    public function getArtist($nombre){
        $bd = $this->getConexionBd();
    
        $sql = "SELECT name,genero,duracion FROM canciones WHERE artista = '" . $nombre . "'";
        
        $result = mysqli_query($bd, $sql);

        if (mysqli_num_rows($result) > 0) {
            $canciones = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $canciones[] = $row; // Add complete user data to the array

            }
            
            mysqli_free_result($result);
            return $canciones;
        } else {
            return null;
        }
    }
    public function getAllFavouriteSongs(){
        $bd = $this->getConexionBd();
        $idUsuario = $_SESSION["id"];
        $sql = "SELECT c.name,c.artista,c.genero,c.duracion FROM canciones c JOIN cancionesFavoritas f ON f.song_id = c.id";
        
        $result = mysqli_query($bd, $sql);

        if (mysqli_num_rows($result) > 0) {
            $canciones = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $canciones[] = $row; // Add complete user data to the array

            }
            
            mysqli_free_result($result);
            return $canciones;
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