<?php 
    $contrasena = "";
    $usuario = "root";
    $nombre_bd = "clinica";

    try {
        $bd = new PDO(
            'mysql:host=localhost;
            dbname ='.$nombre_bd,
            $usuario,
            $contrasena
        );
    } catch (Exception $e) {
        echo "Problema con la conexión: " .$e->getMessage();
    }
?>