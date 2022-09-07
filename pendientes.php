<?php 
    require_once 'login.php';
    session_start();
    $conexion = new mysqli($hn, $un, $pw, $db, $port);
   
    if ($conexion->connect_error) die ("Fatal error");
    date_default_timezone_set("America/Lima"); 
    $fecha= date("Y-m-d H:i");
    if (isset($_SESSION['nombre']))
    {

    if (isset($_POST['delete']) && isset($_POST['titulo']))
    {   
        $titulo = get_post($conexion, 'titulo');
        $query = "DELETE FROM tarea WHERE titulo='$titulo'";
        $result = $conexion->query($query);
        if (!$result) echo "BORRAR falló"; 
    }

    if (isset($_POST['archivar']) && isset($_POST['titulo']))
    {   
        $titulo = get_post($conexion, 'titulo');
        

        $query = " UPDATE tarea SET categoria ='archivado'  WHERE titulo ='$titulo' AND categoria= 'pendiente'";
        $result = $conexion->query($query);
        if (!$result) echo " falló"; 
    }
    
    $nombre = htmlspecialchars($_SESSION['nombre']);
    $username = htmlspecialchars($_SESSION['username']);
    echo "<h1> Todas Las Tareas Pendientes de $nombre </h1>" ;
    echo "<a href=pendientes.php> Pendientes </a> <br> ";
    echo "<a href=Tarea_vencida.php> Tareas vencidas </a> <br> ";
    echo "<a href=Tarea_Archivada.php> Tareas Archivadas </a> <br> ";
    echo "<a href=Todas_las_Tareas.php> Todas las tareas </a> <br> <br> ";

    $query = "SELECT * FROM tarea WHERE usuario = '$username' and categoria='pendiente' 
        order by fecha_de_vencimiento ";
    $result = $conexion->query($query);
    if (!$result) die ("Falló la consulta ");
     
   
    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; $j++)
    {
        $row = $result->fetch_array(MYSQLI_NUM);

        $r0 = htmlspecialchars($row[0]);
        $r1 = htmlspecialchars($row[1]);
        $r2 = htmlspecialchars($row[2]);
        $r3 = htmlspecialchars($row[3]);
        $r4 = htmlspecialchars($row[4]);
        $r5 = htmlspecialchars($row[5]);
        if($r4<=$fecha){
            
            $query = " UPDATE tarea SET categoria ='vencido'  WHERE fecha_de_vencimiento ='$r4' AND categoria= 'pendiente'";
            $resu = $conexion->query($query);
            if (!$resu) echo " falló"; 
        }
        
        echo <<<_END
        <TH>
        <TABLE BORDER=2 bordercolor="lightslategray" >
          <TR>
          <TH>Título </TH> <TH>Contenido</TH> <TH>Fecha_de_Registro </TH><TH>Fecha de Vencimiento </TH><TH>categoria</TH>
          </TR>
          <TD>$r1</TD> <TD>$r2</TD> <TD>$r3</TD> <TD>$r4</TD><TD>$r5</TD>
        </TABLE>
        <form action='pendientes.php' method='post'>
        <input type='submit' value='Eliminar tarea'>
        <input type='hidden' name='delete' value='yes'>
        <input type='hidden' name='titulo' value='$r1'>
        </form>
        _END;
 
    if($r5=='pendiente'){
        echo <<<_END
        <form action='pendientes.php' method='post'>
        <input type='submit' value='Archivar Tarea'>
        <input type='hidden' name='archivar' value='yes'>
        <input type='hidden' name='titulo' value='$r1'>
        </form>
        _END;
    } 
    echo <<<_END
    <form action='modificar.php' method='post'>
    <input type='submit' value='Modificar Tarea'>
    <input type='hidden' name='Modificar' value='yes'>
    <input type='hidden' name='titulo' value='$r1'>
    </form>
    _END;
    }
    echo "<a href=añadir.php>Añadir tareas  </a>  <br>";
    echo "<a href=cerrar_sesion.php> cerrar sesion </a> ";
    $result->close();
    $conexion->close();

     }else echo " usted no inicio sesion <a href=iniciar_sesion.php>Click aqui</a> para ingresar";


    function get_post($con, $var)
    {
        return $con->real_escape_string($_POST[$var]);
    }
    
?>
