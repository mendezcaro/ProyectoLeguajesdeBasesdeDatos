<?php
function ConectarBaseDatos()
{
$conn = oci_connect("admin","admin","localhost/orcl");
 if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
}
?>