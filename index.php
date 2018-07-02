<?php
    require_once('commons.php');

    $commons = new Commons();
    $commons->checkUserSession();

    header('Location: lodge-main.php' );

?>
