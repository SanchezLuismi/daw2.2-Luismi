<?php
require_once "_com/DAO.php";

$categoria = DAO::categoriaActualizar($_REQUEST["id"],$_REQUEST["nombre"]);

echo json_encode($categoria);