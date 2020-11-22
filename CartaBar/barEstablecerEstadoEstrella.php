<?php
require_once "_varios.php";

$conexion = obtenerPdoConexionBD();

$id = $_REQUEST["id"];

$sql = "UPDATE lugar SET estrellaB = (NOT (SELECT estrellaB FROM lugar WHERE id=?)) WHERE id=?";
$sentencia = $conexion->prepare($sql);
$sentencia->execute([$id, $id]);
redireccionar("barListado.php");

?>