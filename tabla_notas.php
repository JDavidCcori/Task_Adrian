<?php 
    require_once 'login.php';
    $conexion = new mysqli($hn, $un, $pw, $db, $port);

    if($conexion->connect_error) die("Error fatal de conexion");

    $query = "CREATE TABLE Tarea (
        usuario VARCHAR(32) NOT NULL,
        titulo VARCHAR(32) NOT NULL,
        contenido TEXT NOT NULL,
        fecha_de_registro  DATETIME NOT NUll,
        fecha_de_vencimiento  DATETIME NOT NULL,
        categoria VARCHAR(15) NOT NULL
    )";

 
     $result = $conexion->query($query);
     if (!$result) die("Error fatal 1");
?>