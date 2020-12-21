<?php
require_once "_com/DAO.php";

$conexion = DAO::obtenerPdoConexionBD();

$id = $_REQUEST["id"];

$sql = "UPDATE persona SET estrella = (NOT (SELECT estrella FROM persona WHERE id=?)) WHERE id=?";
$sentencia = $conexion->prepare($sql);
$sentencia->execute([$id, $id]);
redireccionar("PersonaListado.php");

?>
