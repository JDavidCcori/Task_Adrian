<?php 
    require_once 'login.php';
    $conexion = new mysqli($hn, $un, $pw, $db, $port);
    if($conexion->connect_error) die("Error fatal");
    session_start();
    if(isset($_SESSION['nombre']))
    {
      header('Location: pendientes.php');
    }
    if (isset($_POST['username'])&&
        isset($_POST['password']))
    {
        $un_temp = mysql_entities_fix_string($conexion, $_POST['username']);
        $pw_temp = mysql_entities_fix_string($conexion, $_POST['password']);
        $query   = "SELECT * FROM usuarios WHERE username='$un_temp'";
        $result  = $conexion->query($query);
        
        if (!$result) die ("Usuario no encontrado");
        elseif ($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_NUM);
            $result->close();

            if (password_verify($pw_temp, $row[3])) 
            {
                session_start();
                $_SESSION['nombre']=$row[0];
                $_SESSION['apellido']=$row[1];
                $_SESSION['username']=$row[2];
                header('Location: pendientes.php');
            }
            else {
                echo "Usuario/password incorrecto <p><a href='Registrar.php'>
            Registrarse</a></p>";
            }
        }
        else {
          echo "Usuario/password incorrecto <p><a href='Registrar.php'>
      Registrarse</a></p>";
      }   
    }
    else
    {

      echo <<<_END
      <h1><center>Iniciar sesion</center></h1>
      <form action="iniciar_sesion.php" method="post"><pre>
      <center> Usuario <input type="text" name="username">  </center>
      <center> Password <input type="password" name="password">  </center>
      <center>        <input type="submit" value="INGRESAR">  </center>
      </form>
      _END;
      echo  "<center><br><a = href=Registrar.php>AGREGAR USUARIO</a></center>";
    }

    $conexion->close();

    function mysql_entities_fix_string($conexion, $string)
    {
        return htmlentities(mysql_fix_string($conexion, $string));
      }
    function mysql_fix_string($conexion, $string)
    {
      
        return $conexion->real_escape_string($string);
      }  
?>

