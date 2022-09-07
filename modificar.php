<?php //sqltest.php
    require_once 'login.php';
    session_start();
    $conexion = new mysqli($hn, $un, $pw, $db, $port);

    if ($conexion->connect_error) die ("Fatal error");
    date_default_timezone_set("America/Lima"); 
    $fecha= date("Y-m-d H:i");
    if (isset($_SESSION['nombre']))
    {
        $titulo = get_post($conexion,'titulo');
    if (isset($_POST['contenido']))  
    {      
        $contenido = get_post($conexion, 'contenido');
        $fecha_de_registro = get_post($conexion, 'fecha_de_registro');
        $fecha_de_vencimiento= get_post($conexion, 'fecha_de_vencimiento');
        
        $query =  " UPDATE tarea SET contenido='$contenido' , fecha_de_registro= '$fecha_de_registro', fecha_de_vencimiento= '$fecha_de_vencimiento'
            where   titulo='$titulo'";
              
        $result = $conexion->query($query);
        if (!$result) die ( "INSERT falló <br><br>");

        header('Location: pendientes.php');
    }
    echo <<<_END
    <form action="modificar.php" method="post"><pre>
       <input type='hidden' name='titulo' value='$titulo'>
        contenido  <input type="text" name="contenido">  
        fecha_de_registro <input type="datetime" name="fecha_de_registro" value = "$fecha">
        fecha_de_vencimiento <input type="datetime" name= "fecha_de_vencimiento">
        <input type="submit" value="ADD RECORD">
    </pre></form>
    _END;

    }else echo "<a href=iniciar_sesion.php>Click aqui</a> para ingresar";

    function get_post($con, $var)
    {
        return $con->real_escape_string($_POST[$var]);
        
    }
?>
