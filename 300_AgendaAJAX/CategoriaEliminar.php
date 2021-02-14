<?php
	require_once "_com/DAO.php";

    $respuesta = DAO::categoriaEliminar($_REQUEST["id"]);
