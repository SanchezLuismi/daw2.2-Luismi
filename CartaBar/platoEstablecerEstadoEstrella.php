<?php
require_once "_varios.php";

$conexion = obtenerPdoConexionBD();

$id = $_REQUEST["id"];

$sql = "UPDATE plato SET estrellaP = (NOT (SELECT estrellaP FROM plato WHERE id=?)) WHERE id=?";
$sentencia = $conexion->prepare($sql);
$sentencia->execute([$id, $id]);
redireccionar("platoListado.php");

?>