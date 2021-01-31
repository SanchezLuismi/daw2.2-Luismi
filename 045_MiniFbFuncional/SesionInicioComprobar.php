<?php
session_start();
require_once "_com/DAO.php";
require_once "_com/Varios.php";

$identificador=$_REQUEST["identificador"];
$contrasenna=$_REQUEST["contrasenna"];


$arrayUsuario = DAO::obtenerUsuarioPorContrasenna($identificador,$contrasenna);
print_r($arrayUsuario);

if($arrayUsuario->getId()){
    marcarSesionComoIniciada($arrayUsuario);
    if (isset($_REQUEST["recordar"])) {
        establecerSesionCookie($arrayUsuario);
    }
    redireccionar("MuroverGlobal.php");
}else{
    redireccionar("SesionInicioMostrarFormulario.php?datosErroneos");
}
?>

