<?php

require_once "_com/DAO.php";

$resultado = DAO::personaCrear($_REQUEST["id"],$_REQUEST["nombre"],$_REQUEST["apellido"],$_REQUEST["telefono"],$_REQUEST["categoria"],$_REQUEST["estrella"]);

json_encode($resultado);