<?php

require_once __DIR__ . "/../../config.php";
require RUTA_INCLUDES . "/src/formulario.php";


class formulario_register extends formulario
{
    protected $app;
    protected $usuario;

    public function __construct() {
       
        parent::__construct('formAddUser', ['urlRedireccion' => "index.php", 'enctype' => 'multipart/form-data']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'contraseña', 'foto'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Añada los datos necesarios de el nuevo Usuario:</legend>
            <div>
                <label for="nombreUsuario"><strong>Nombre de Usuario:  </strong></label>
                <input type="text" id="nombreUsuario" name="nombreUsuario"><br><br>
                {$erroresCampos['nombreUsuario']}
            </div>
            <div>
                <label for="contraseña"><strong>Contraseña:  </strong></label>
                <input type="text" id="contrasena" name="contrasena"><br><br>
                {$erroresCampos['contraseña']}
            </div>
            <div> 
                <label for="foto"><strong>Foto de perfil:  </strong></label> 
                <input type="file" id="foto" name="foto" accept="image/*"> 
                {$erroresCampos['foto']}
            </div> 
            <br>
            <button type="submit">Añadir Usuario</button>
        </fieldset>


        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreUsuario || empty($nombreUsuario) ) {
            $this->errores['nombreUsuario'] = '<span style="color: red;">El nombre de usuario no puede estar vacío.</span>';
            
        }
        if (isset($datos['foto']) && $datos['foto']['error'] === UPLOAD_ERR_OK) {
            
            //Subir el archivo a la ruta /img/...
            $ruta_destino =  $_SERVER['DOCUMENT_ROOT'] . RUTA_IMG . "/" . $datos['foto']['name']; 

            if(!move_uploaded_file($datos['foto']['tmp_name'], $ruta_destino)){
                $this->errores['foto'] = '<span style="color: red;">Ha habido un problema con la foto.</span>';
            }
            
        }

        $foto = $datos['foto']['name'];
        $urlFoto = "/" . $foto;
        
        /*
        if (count($this->errores) === 0) {
            
            //$newUser = new Usuario($nombreUsuario, $contraseña, $nombre, $apellidos, $email, $telefono, $rol, $posicion, $urlFoto);
            
            $app = Aplicacion::getInstance();
            
            //comprobar que el usuario no esta ya en la base de datos para prevenir de duplicados
            foreach ($users = $app->getAllUsers() as $u){
                if($u->getUserName() == $nombreUsuario){
                    $this->errores[] = '<span style="color: red;">Error al añadir un Usuario: usuario ya existente.</span>';
                    return 1;
                }
            }
            
            $resultt = Usuario::inserta($newUser);
            
            $app->inserta($nombreUsuario);
            
            if(!$resultt){
                $this->errores[] = '<p style="color: red;">Error al añadir un Usuario.</p>';
            }
            else{
                
                $_SESSION["mensaje"] = '<p style="color: green;">Usuario añadido con éxito.</p>';
                $_SESSION["accion"] = true;
                
            }
        }
        */
    }
}