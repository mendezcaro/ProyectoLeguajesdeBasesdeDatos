<?php
include 'ConexionBD.php';

if (isset($_POST["CargarUsuarios"])) {
    CargarUsuarios();
}
if (isset($_POST["DropdownUbicaciones"])) {
    DropdownUbicaciones();
}
if (isset($_POST["ConsultaFechaS"])) {
    ConsultaFechaS($_POST["idUbicacion"]);
}
if (isset($_POST["ConsultaFechaR"])) {
    ConsultaFechaR($_POST["idUbicacion"]);
}
if (isset($_POST["ConsultaIDalojamiento"])) {
    ConsultaIDalojamiento($_POST["idUbicacion"]);
}
if (isset($_POST["CalcularNombreAlojamiento"])) {
    CalcularNombreAlojamiento($_POST["idAlojamiento"]);
}
if (isset($_POST["ConsultaPrecio"])) {
    ConsultaPrecio($_POST["idUbicacion"]);
}

if(isset($_POST["CargarHoteles"]))
{
    CargarHoteles();
}

if(isset($_POST["CargarUbicaciones"]))
{
    CargarUbicaciones();
}

if(isset($_POST["CargarPaquetesAdmin"]))
{
    CargarPaquetesAdmin();
}

if(isset($_POST["CargarPaquetes"]))
{
    CargarPaquetes();
}

//Index - Llena la tabla con ubicaciones
function CargarUbicaciones()
{

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
         $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,'begin CargarUbicaciones(:cursor); end;');
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $item) {
                echo "<tr>";
             echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
             echo "</tr>";
        }
        }
    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
    oci_free_statement($sentencia);
    oci_close($enlace);



}

if(isset($_POST["LlenarComboAlojamientos"]))
{
    LlenarComboAlojamientos();
}

if(isset($_POST["LlenarComboUbicaciones"]))
{
    LlenarComboUbicaciones();
}

//Llena combobox alojamientos/hoteles
function LlenarComboUbicaciones()
{

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,'begin LlenarComboUbicaciones(:cursor); end;');
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);
       echo '<option value=0>Seleccione Hotel</option>';
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){

       echo '<option value=' . $row["IDUBICACION"] . '>' . $row["NOMBRE_LUGAR"] . '</option>';

        }
    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
    oci_free_statement($sentencia);
    oci_close($enlace);


}

//Llena combobox alojamientos/hoteles
function LlenarComboAlojamientos()
{
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,'begin LLENARCOMBOUALOJAMIENTOS(:cursor); end;');
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);
       echo '<option value=0>Seleccione Hotel</option>';
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){

       echo '<option value=' . $row["IDHOTEL"] . '>' . $row["NOMBREHOTEL"] . '</option>';

        }
    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
    oci_free_statement($sentencia);
    oci_close($enlace);


    
}

//Index - Llena la tabla con hoteles
function CargarHoteles()
{
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,'begin CargarHoteles(:cursor); end;');
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $item) {
                echo "<tr>";
             echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
             echo "</tr>";
        }
        }
    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
    oci_free_statement($sentencia);
            oci_close($enlace);


    
}

//Index - Llena la tabla con usuarios
function CargarUsuarios()
{
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,'begin ConsultarUsuarios(:cursor); end;');
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){
        
            echo "<tr>";
      echo "<td>" . $row["NOMBRE_USUARIO"] . "</td>";
      echo "<td>" . $row["NOMBRE_COMPLETO"] . "</td>"; 
      echo "<td>" . $row["IDROL"] . "</td>";
      echo "<td>" . $row["CORREO"] . "</td>";
      echo "<td>" . $row["TELEFONO"] . "</td>";
            if ($row["IDROL"] == '0'){
              echo '<td><a href="EditarUsuarios.php?HacerAdmin=' . $row["IDUSUARIO"] . '" class="btn btn-info">Hacer Administrador</a></td>'; //aun no es admin
            }
            if ($row["IDROL"] == '999' && $row["IDUSUARIO"] != '777'){//es admin pero no es el admin principal
              echo '<td><a href="EditarUsuarios.php?QuitarAdmin=' . $row["IDUSUARIO"] . '" class="btn btn-info">Remover Rol Administrador</a></td>'; 
            }
            if ($row["IDUSUARIO"] != '777'){//valida si este es el usuario admin principal si lo es entonces no se puede eliminar
              echo '<td><a href="EditarUsuarios.php?EliminarUsuario=' . $row["IDUSUARIO"] . '" class="btn btn-info">Eliminar Usuario</a></td>';  
            
            echo "</tr>";
        }
        }

        oci_free_statement($sentencia);
        oci_close($enlace);
        if ($respuesta){
            return $respuesta;
        }
    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            return 505;
    }
            oci_close($enlace);


}

function ConsultarUsuario($user,$pass){

try {
    $enlace = oci_connect("admin","admin","localhost/orcl");            
    $sentencia = oci_parse( $enlace,"begin ValidarUsuario(:user,:pass); end;");
    oci_bind_by_name($sentencia, ':user', $user);
    oci_bind_by_name($sentencia, ':pass', $pass);
    $respuesta = oci_execute($sentencia);
    oci_free_statement($sentencia);
    oci_close($enlace);
    if ($respuesta){
        return $respuesta;
    }
}
catch(Exception $ex)
{
        $respuesta = oci_error();
        return 505;
}
  
}

function CrearUsuario($pass,$mail,$name,$username,$phone){

    $respuesta = "";
    try {
            $enlace = oci_connect("admin","admin","localhost/orcl");            
            $sentencia = oci_parse($enlace, "begin CrearUsuarios(:idrol, :name, :username, :pass, :phone, :mail); end;");

            $rol = 999;
            oci_bind_by_name($sentencia, ':idrol', $rol);
            oci_bind_by_name($sentencia, ':name', $name);
            oci_bind_by_name($sentencia, ':username', $username);
            oci_bind_by_name($sentencia, ':pass', $pass);
            oci_bind_by_name($sentencia, ':phone', $phone);
            oci_bind_by_name($sentencia, ':mail', $mail);

            $respuesta = oci_execute($sentencia);
            oci_free_statement($sentencia);
            oci_close($enlace);
            if ($respuesta){
                return 200;
            }
            
    }
    catch(Exception $ex)
    {
        $respuesta = oci_error();
        return 505;
    }
        oci_close($enlace);

    
}

//nueva funcion luego de cambios en la tabla
function CargarPaquetes()
{
    
    try {

        $enlace = oci_connect("admin","admin","localhost/orcl"); 
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,'begin ConsultarPaquetes(:cursor); end;');
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $item) {

             echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
 
        }
        }

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
            oci_close($enlace);


}

//nueva funcion luego de cambios en la tabla
function CargarPaquetesAdmin()
{
    try {
        $i = 1;
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,'begin ConsultarPaquetes(:cursor); end;');
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){
            //foreach ($row as $item) {
                
            // echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
            echo "<tr>";
       echo "<td>" . $row["IDPAQUETES"] . "</td>";
       echo "<td>" . $row["FECHA_INICIO"] . "</td>";
       echo "<td>" . $row["FECHA_FINAL"] . "</td>";
       echo "<td>" . $row["NOMBREHOTEL"] . "</td>";
       echo "<td>" . $row["NOMBRE_LUGAR"] . "</td>";
       echo "<td>" . "$".$row["PRECIO"] . "</td>";
      // echo '<td><a href="Editarpaquete.php?q=' . $row["IDPAQUETES"] . '" class="button">Editar</a></td>';
      echo '<td><a href="Eliminar.php?q=' . $row["IDPAQUETES"] . '" class="button">Eliminar</a></td>';
       echo "</tr>";
       echo "</tr>";
        //}
        }
  
        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
            oci_close($enlace);

}

//anterior funcion antes de cambios en la tabla
function ConsultarPaquetes()
{
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,'begin ConsultarPaquetes(:cursor); end;');
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $item) {

             echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
               
           /* echo "<tr>";
            echo "<td>" . $item["idpaquetes"] . "</td>";
            echo "<td>" . $item["FECHA_INICIO"] . "</td>";
            echo "<td>" . $item["FECHA_FINAL"] . "</td>";
            echo "<td>" . $item["4"] . "</td>"; // Por alguna razon no desplegaba cuando se usa el nombre del array pero si el index
            echo "<td>" . $item["NOMBRE_LUGAR"] . "</td>";
            echo "<td>" . "$".$item["precio"] . "</td>";
            echo "</tr>";
            */
        }
         //echo "</tr>\n";
        }

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
            oci_close($enlace);

}

function ConsultarHoteles()
{

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");   
        $curs = oci_new_cursor($enlace);          
        $sentencia = oci_parse($enlace,"begin ConsultarHoteles(:cursor); end;");
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
       oci_execute($curs);

        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){

            echo "<tr>";
            echo "<td>" . $row["IDHOTEL"] . "</td>";
            echo "<td>" . $row["NOMBREHOTEL"] . "</td>";
          /*  echo '<td><a href="Editarhotel.php?q=' . $row["IDHOTEL"] . '" class="button">Editar</a></td>';*/
            echo '<td><a href="Eliminarhotel.php?q=' . $row["IDHOTEL"] . '" class="button">Eliminar</a></td>';
            echo "</tr>";
        }

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
            oci_close($enlace);


}

function ModificarHotel($idhotel, $nombrehotel)
{
    $respuesta = "";

    try
    {
    
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin ModificarHotel(:idhotel, :nombrehotel); end;");
        $respuesta = oci_execute($sentencia);
        oci_bind_by_name($sentencia, ':idhotel', $idhotel);
        oci_bind_by_name($sentencia, ':nombrehotel', $nombrehotel);

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
        $respuesta = oci_error();
    }

    oci_close($enlace);

}

function ConsultarHotel($idhotel)
{

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl"); 
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,"begin ConsultarHotel(:idhotel, :cursor); end;");
        oci_bind_by_name($sentencia, ':idhotel', $idhotel);
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($sentencia);
        oci_execute($curs);
        oci_free_statement($sentencia);
        oci_close($enlace);


        return $row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
    }
            oci_close($enlace);
}
function EliminarHotel($idhotel)
{
    $respuesta = "";


    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin Eliminarhotel(:idhotel); end;");
        oci_bind_by_name($sentencia, ':idhotel', $idhotel);
        oci_execute($sentencia);
        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
    }
           
}

function InsertarHotel( $nombrehotel)
{
    $respuesta = "";


    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin InsertarHotel(:nombrehotel); end;");
        oci_bind_by_name($sentencia, ':nombrehotel', $nombrehotel);
        $respuesta = oci_execute($sentencia);
        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
    }
            
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ConsultarUbicaciones()
{
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");
        $curs = oci_new_cursor($enlace);                
        $sentencia = oci_parse($enlace,"begin ConsultarUbicaciones(:cursor); end;");
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($sentencia);
        oci_execute($curs);

        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){
            echo "<tr>";
            echo "<td>" . $row["IDUBICACION"] . "</td>";
            echo "<td>" . $row["NOMBRE_LUGAR"] . "</td>";
           //echo '<td><a href="Editarubicacion.php?q=' . $row["IDUBICACION"] . '" class="button">Editar</a></td>';
            echo '<td><a href="Eliminarubicacion.php?q=' . $row["IDUBICACION"] . '" class="button">Eliminar</a></td>';
            echo "</tr>";
        }

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
            oci_close($enlace);


}

function ModificarUbicacion($idubicacion, $nombre_lugar)
{


        $respuesta = "";


    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin ModificarUbicacion(':idubicacion',':nombre_lugar'); end;");
        oci_bind_by_name($sentencia, ':idubicacion', $idubicacion);
        oci_bind_by_name($sentencia, ':nombre_lugar', $nombre_lugar);
        $respuesta = oci_execute($sentencia);
        oci_free_statement($sentencia);
        oci_close($enlace);
        return $respuesta;
    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
    }
            oci_close($enlace);
}

function ConsultarUbicacion($idubicacion)
{


    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin ConsultarUbicacion(':idubicacion'); end;");
        oci_bind_by_name($sentencia, ':idubicacion', $idubicacion);
        $ubica = oci_execute($sentencia);

        return $ubica;
        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
            oci_close($enlace);
}

function EliminarUbicacion($idubicacion)
{
    $respuesta = "";

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin EliminarUbicacion(:idubicacion); end;");
        oci_bind_by_name($sentencia, ':idubicacion', $idubicacion);
         oci_execute($sentencia);
        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
           
}


function InsertarUbicacion( $nombre_lugar)
{
    $respuesta = "";

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin InsertarUbicacion(:nombre_lugar); end;");
        oci_bind_by_name($sentencia, ':nombre_lugar', $nombre_lugar);
        $respuesta = oci_execute($sentencia);

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
    
    
}

function ConsultarPaquete($iden)
{

    $respuesta = "";

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");   
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,"begin ConsultarPaquete(:iden); end;");
        oci_bind_by_name($sentencia, ":iden", $curs, -1, OCI_B_CURSOR);
       oci_execute($sentencia);
      oci_execute($curs);
    
        return oci_fetch_array($sentencia);

       oci_free_statement($sentencia);
        oci_close($enlace);
    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
            oci_close($enlace);
}


function InsertarPaquete($fechaInicio, $fechaFinal, $lugar, $alojam, $precio)
{


    $respuesta = "";

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin InsertarPaquetes(:fechaInicio,:fechaFinal,:lugar,:alojam, :precio); end;");       
        oci_bind_by_name($sentencia, ':fechaInicio', $fechaInicio);
        oci_bind_by_name($sentencia, ':fechaFinal', $fechaFinal);
        oci_bind_by_name($sentencia, ':lugar', $lugar);
        oci_bind_by_name($sentencia, ':alojam', $alojam);
        oci_bind_by_name($sentencia, ':precio', $precio);
        oci_execute($sentencia);

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
           
}

function EliminarPaquete($iden)
{

    
    $respuesta = "";

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin EliminarPaquete(:iden); end;");
        oci_bind_by_name($sentencia, ':iden', $iden);
        $respuesta = oci_execute($sentencia);

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }



}

function ModificarPaquete($alojamiento, $FECHA_FINAL, $FECHA_INICIO, $lugar, $precio,$idpaquetes)
{
    $respuesta = "";


    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin ModificarPaquete(':alojamiento',':FECHA_FINAL',':FECHA_INICIO',':lugar',':precio',':idpaquetes'); end;");
        oci_bind_by_name($sentencia, ':alojamiento', $alojamiento);
        oci_bind_by_name($sentencia, ':FECHA_FINAL', $FECHA_FINAL);
        oci_bind_by_name($sentencia, ':FECHA_INICIO', $FECHA_INICIO);
        oci_bind_by_name($sentencia, ':lugar', $lugar);
        oci_bind_by_name($sentencia, ':precio', $precio);
        oci_bind_by_name($sentencia, ':idpaquetes', $idpaquetes);
        $respuesta = oci_execute($sentencia);

        oci_free_statement($sentencia);
        oci_close($enlace);

    }
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
            oci_close($enlace);
}

function DropdownUbicaciones()
{
    $respuesta = "";

    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");    
        $curs = oci_new_cursor($enlace);         
        $sentencia = oci_parse($enlace,"begin CONSULTARUBICACIONESDROPDOOWN(:cursor); end;");
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($sentencia);
        oci_execute($curs);
        echo "<option value=0>Seleccione</option>";
        while($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)){
            echo "<option value=" . $row["IDUBICACION"] . ">" . $row["NOMBRE_LUGAR"] .  "</option>";
        }

        }


    
    catch(Exception $ex)
    {
            $respuesta = oci_error();
            
    }
   
    
}

function ConvertirFecha($fecha)
{
    if ($fecha !== null) {
        $fecha = date("d/m/Y", strtotime($fecha));
    } else {
        $fecha = null;
    }
    return $fecha;
}

function ConsultaFechaS($idUbicacion)
{
    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");  
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,"begin ConsultarPaqueteConLugar(:idUbicacion, :cursor); end;");
        oci_bind_by_name($sentencia, ':idUbicacion', $idUbicacion);
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($sentencia);
        oci_execute($curs);

    } catch (Exception $ex) {
        $respuesta = $ex->getMessage();
        oci_close($enlace);
        return $curs;
    }
    $row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
    if ($row != null) {
        $fechaS = ConvertirFecha($row["FECHA_INICIO"]);
        echo $fechaS;
    } else {
        echo "Sin paquete";
    }
}

function ConsultaFechaR($idUbicacion)
{
    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");
        $curs = oci_new_cursor($enlace);               
        $sentencia = oci_parse($enlace,"begin ConsultarPaqueteConLugar(:idUbicacion, :cursor); end;");
        oci_bind_by_name($sentencia, ':idUbicacion', $idUbicacion);
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($sentencia);
        oci_execute($curs);
        
    } catch (Exception $ex) {
        $respuesta = $ex->getMessage();
        oci_close($enlace);
        return $curs;
    }
    $row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
    if ($row != null) {
        $fechaR = ConvertirFecha($row["FECHA_FINAL"]);
        echo $fechaR;
    } else {
        echo "Sin paquete";
    }
}

function ConsultaIDalojamiento($idUbicacion)
{
    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");      
        $curs = oci_new_cursor($enlace);      
        $sentencia = oci_parse($enlace,"begin ConsultarPaqueteConLugar(:idUbicacion, :cursor); end;");
        oci_bind_by_name($sentencia, ':idUbicacion', $idUbicacion);
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($sentencia);
        oci_execute($curs);
        
    } catch (Exception $ex) {
        $respuesta = $ex->getMessage();
        oci_close($enlace);
        return $curs;
    }
    $row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
    if ($row != null) {
        $alojamientoID = $row["ALOJAMIENTO"];
        echo $alojamientoID;
    } else {
        echo "Sin paquete";
    }
}

function CalcularNombreAlojamiento($idAlojamiento)
{
    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");  
        $curs = oci_new_cursor($enlace);           
        $sentencia = oci_parse($enlace,"begin ConsultarHotel(:idhotel, :cursor); end;");
        oci_bind_by_name($sentencia, ':idhotel', $idAlojamiento);
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($sentencia);
        oci_execute($curs);

    } catch (Exception $ex) {
        $respuesta = $ex->getMessage();
        oci_close($enlace);
        return $curs;
    }
    $row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
    if ($row != null) {
        $NombreAlojamiento = $row["NOMBREHOTEL"];
        echo $NombreAlojamiento;
    } else {
        echo "Sin paquete";
    }
}

function ConsultaPrecio($idUbicacion)
{
    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");      
        $curs = oci_new_cursor($enlace);              
        $sentencia = oci_parse($enlace,"begin ConsultarPaqueteConLugar(:idUbicacion, :cursor); end;");
        oci_bind_by_name($sentencia, ':idUbicacion', $idUbicacion);
        oci_bind_by_name($sentencia, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($sentencia);
        oci_execute($curs);

    } catch (Exception $ex) {
        $respuesta = $ex->getMessage();
        oci_close($enlace);
        return $curs;
    }
    $row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
    if ($row != null) {
        $precio = $row["PRECIO"];
        echo $precio;
    } else {
        echo "0.00";
    }
}

function ReservarPaquete($idPaquetes, $UserID, $totalReserva)
{
    $respuesta = "";
    try {
        $enlace = oci_connect("admin","admin","localhost/orcl");            
        $sentencia = oci_parse($enlace,"begin ReservarPaquete(:idPaquetes,:UserID,:totalReserva); end;");
        oci_bind_by_name($sentencia, ':idPaquetes', $idPaquetes);
        oci_bind_by_name($sentencia, ':UserID', $UserID);
        oci_bind_by_name($sentencia, ':totalReserva', $totalReserva);
        oci_execute($sentencia);

    } catch (Exception $ex) {
        $respuesta = $ex->getMessage();
    }

    oci_close($enlace);
    return $respuesta;
}


?>
