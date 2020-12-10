<?php
require_once "_Varios.php";
session_start();
$identificador = $_REQUEST["identificador"];

$contrasenna = $_REQUEST["contrasenna"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];

$arrayUsuario = crearUsuario($identificador, $contrasenna, $nombre, $apellidos);

// TODO ¿Excepciones?

if ($arrayUsuario) { // HAN venido datos: identificador existía y contraseña era correcta.
    marcarSesionComoIniciada($arrayUsuario);
    // echo print_r($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");
} else {
    redireccionar("UsuarioNuevoFormulario.php?datosErroneos");
}
