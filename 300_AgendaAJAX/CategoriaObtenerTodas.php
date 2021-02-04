<?php
	require_once "_com/DAO.php";

	// Esto es la v0.8.
    echo '{"id":17, "nombre":"Instituto"}';

	// Esto es la v0.9 (está hecha OK).
    //echo json_encode(DAO::categoriaObtenerPorId(8));

	// TODO Esto es la v1.0:
    //echo json_encode(DAO::categoriaObtenerTodas());
?>