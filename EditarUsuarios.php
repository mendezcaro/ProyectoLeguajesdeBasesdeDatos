<?php

include 'ConexionBD.php';


if(isset($_GET["EliminarUsuario"])) 
{
    $userID = $_GET["EliminarUsuario"];

    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl"); 
    $sentencia = oci_parse($enlace,"begin ELIMINARUSUARIO(:idusuario); end;");
        oci_bind_by_name($sentencia, ':idusuario', $userID);
        $respuesta = oci_execute($sentencia);

        oci_free_statement($sentencia);
        oci_close($enlace);
        echo '
        <script>
            alert("Usuario eliminado correctamente.");
            window.location = "ManejoUsuarios.php";
        </script>
        ';

    }
    catch(Exception $ex)
    {
        $respuesta = oci_error();
        echo '
            <script>
                alert("Ha ocurrido un error, intente de nuevo o mas tarde. $respuesta");
                window.location = "index.php";
            </script>
            ';
            exit;
            
    }
           
}

if(isset($_GET["QuitarAdmin"])) 
{
    $userID = $_GET["QuitarAdmin"];

    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl"); 
        $sentencia = oci_parse($enlace,"begin QUITARADMIN(:idusuario); end;");
            oci_bind_by_name($sentencia, ':idusuario', $userID);
            $respuesta = oci_execute($sentencia);
    
            oci_free_statement($sentencia);
            oci_close($enlace);
        echo '
            <script>
                alert("Usuario editado correctamente.");
                window.location = "ManejoUsuarios.php";
            </script>
            ';
    }
    catch(Exception $ex)
    {
       
        $respuesta = oci_error();
        echo '
            <script>
                alert("Ha ocurrido un error, intente de nuevo o mas tarde. $respuesta");
                window.location = "index.php";
            </script>
            ';
            exit;
        
    }
       
}

if(isset($_GET["HacerAdmin"])) 
{
    $userID = $_GET["HacerAdmin"];

    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl"); 
    $sentencia = oci_parse($enlace,"begin HACERADMIN(:idusuario); end;");
        oci_bind_by_name($sentencia, ':idusuario', $userID);
        $respuesta = oci_execute($sentencia);
        oci_free_statement($sentencia);
        oci_close($enlace);
        echo '
            <script>
                alert("Usuario editado correctamente.");
                window.location = "ManejoUsuarios.php";
            </script>
            ';
    }
    catch(Exception $ex)
    {
        $respuesta = oci_error();
        echo '
            <script>
                alert("Ha ocurrido un error, intente de nuevo o mas tarde. $respuesta");
                window.location = "index.php";
            </script>
            ';
            exit;
        
    }
  
}


?>