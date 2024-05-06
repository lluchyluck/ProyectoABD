<div class="contenedor-header">
    <div class="contenedor-menu">
        <nav>
            <ul>
                <li><a href="/ProyectoABD/index.php">Inicio</a></li>
                <li><a href="#">Bases de datos</a></li>
                <li><a href="/ProyectoABD/includes/src/perfil/perfil.php">Perfil</a></li>
            </ul>
        </nav>
    </div>
    <div class="contenedor-sesion">
        <nav>
            <?php
            if (!$_SESSION["login"]) {
                echo '<a href="/ProyectoABD/includes/src/login/login.php">Login</a>';
            } else {
                echo '<b>Bienvenido:<a href="/ProyectoABD/includes/src/perfil/perfil.php">' . $_SESSION["username"] . '</a></b>';
            }
            ?>

            <button id="cerrarSesion" onclick="goToPHP()">Cerrar Sesión</button>

        </nav>
    </div>
</div>
<script>
        const myButton = document.getElementById('cerrarSesion');
        const url = '/ProyectoABD/includes/src/logout/logout.php'; 

        myButton.addEventListener('click', function() {
            const xhr = new XMLHttpRequest();

            xhr.open('POST', url);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            const formData = new FormData();
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('POST request successful:', xhr.responseText);
                } else {
                    console.error('Error sending POST request:', xhr.statusText);
                }
            };

            xhr.send(formData);
        });
    </script>