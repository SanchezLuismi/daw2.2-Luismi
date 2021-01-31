<?php

// TODO ...$_REQUEST["..."]...

// TODO Intentar crear (añadir funciones en Varios.php para crear y tal).
//
// TODO Y redirigir a donde sea.
require_once "_com/DAO.php";


$arrayUsuario = DAO::usuarioCrear($_REQUEST["identificador"],$_REQUEST["contrasenna"],null,null,0,$_REQUEST["nombre"],$_REQUEST["apellidos"]);

// TODO ¿Excepciones?

if ($arrayUsuario) {
    redireccionar("MuroVerGlobal.php");
} else {
    redireccionar("UsuarioNuevoFormulario?datosErroneos.php");
}