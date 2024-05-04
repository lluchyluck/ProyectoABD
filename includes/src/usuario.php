<?php

namespace abd\usuarios;

use abd\Aplicacion;

class Usuario
{

    // Propiedades privadas para encapsular los datos
    private $id;
    private $username;
    private $password;
    private $img;

    // Constructor para inicializar las propiedades
    public function __construct($username, $password, $img)
    {
        $this->username = $username;
        $this->password = $password;
        $this->img = $img;
    }

    public function insertarBd($app){
        $bd = $app->getConexionBd();
        $this->id = $this->nextId($app);
        $sqlQuery = "INSERT INTO usuarios (id, username, password, img) VALUES ('$this->id', '$this->username', '$this->password', '$this->img')";
        $result = mysqli_query($bd, $sqlQuery);
        if($result){
            echo "[+]Usuario añadido exitosamente";
            mysqli_free_result($result);
            return true;
        }else{
            echo "[-]No se pudo añadir al usuario, error de mysql";
            mysqli_free_result($result);
            return false;
        }
        
    }
    private function nextId($app){
        $db = $app->getConexionBd();
        $maxIDquery = "SELECT MAX(id) FROM usuarios u"; 
        $resultmaxIDquery = mysqli_query($db ,$maxIDquery);
        $row = mysqli_fetch_row($resultmaxIDquery);
        $maxId = $row[0];
        mysqli_free_result($resultmaxIDquery);
        return $maxId + 1;
    }

    public function newUser($usuario){

    }
    // Métodos getters para acceder a las propiedades
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getImg()
    {
        return $this->img;
    }

    // Métodos setters para modificar las propiedades
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setImg($img)
    {
        $this->img = $img;
    }
}