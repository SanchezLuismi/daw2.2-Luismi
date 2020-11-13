<?php
require_once "_varios.php";

$conexion = obtenerPdoConexionBD();

$estrella = $_REQUEST["estrella"];
$id = $_REQUEST["id"];


$sql = "UPDATE persona SET estrella=? WHERE id=?";
$parametros = [$estrella,$id];



?>
