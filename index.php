<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php require_once "includes/config.php"; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Musical</title>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>" />
    
    
</head>
<body>
    <header>
        <?php require(VISTAS . '/cabecera.php'); ?>
    </header>

    <main>
        <section class="contenedor-principal">
            <aside id="sidebar-izquierda">
                <?php require(VISTAS . '/sidebarizq.php'); ?>
            </aside>

            <div id="contenido-central">
                <h1>Bienvenido a la Biblioteca Musical</h1>

                <section id="registro-login">
                    <h2>Registro/Inicio de sesión</h2>
                    <form action="registro.php" method="post">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>

                        <label for="correo">Correo electrónico:</label>
                        <input type="email" id="correo" name="correo" required>

                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" required>

                        <button type="submit">Registrarse</button>
                    </form>

                    <form action="login.php" method="post">
                        <label for="correo_login">Correo electrónico:</label>
                        <input type="email" id="correo_login" name="correo_login" required>

                        <label for="contrasena_login">Contraseña:</label>
                        <input type="password" id="contrasena_login" name="contrasena_login" required>

                        <button type="submit">Iniciar sesión</button>
                    </form>
                </section>

                <section id="bases-datos">
                    <h2>Bases de datos musicales</h2>
                    <ul>
                        <li><a href="base_datos1.php">Base de datos 1</a></li>
                        <li><a href="base_datos2.php">Base de datos 2</a></li>
                        <li><a href="base_datos3.php">Base de datos 3</a></li>
                    </ul>
                </section>
            </div>

            <aside id="sidebar-derecha">
                <?php require(VISTAS . '/sidebarder.php'); ?>
            </aside>
        </section>
    </main>


    <footer>
        <?phprequire(VISTAS . '/footer.php'); ?>
    </footer>

    <script src="script.js"></script>
</body>
</html>
