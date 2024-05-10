<aside id="sidebar-derecha">
    <h2>Info Biblioteca</h2>
    <?php 
    require_once __DIR__ . "/../includes/config.php"; 
    require RUTA_INCLUDES . "/src/app.php";
    $app = Aplicacion::getInstance();
    echo $app->displayGenericInfo();
    ?>
</aside>
