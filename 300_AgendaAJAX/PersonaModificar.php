<?php

require_once "_com/DAO.php";

$persona = new Persona($_REQUEST["id"], $_REQUEST["nombre"],$_REQUEST["apellido"],$_REQUEST["telefono"],$_REQUEST["estrella"],$_REQUEST["categoria"]);

$persona = DAO::personaActualizar($persona);

echo json_encode($persona);