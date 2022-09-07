<?php 
    require_once 'login.php';
    $conexion = new mysqli($hn, $un, $pw, $db, $port);

    if($conexion->connect_error) die("Error fatal de conexion");

    $query = "CREATE TABLE usuarios (
        nombre VARCHAR(32) NOT NULL,
        apellido VARCHAR(32) NOT NULL,
        username VARCHAR(32) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";
     
    $result = $conexion->query($query);
    if (!$result) die("Error fatal 1");
   
?>