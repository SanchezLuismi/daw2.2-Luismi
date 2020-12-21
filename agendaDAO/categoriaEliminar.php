<?php
    require_once "_com/DAO.php";

// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];
    $respSQL = DAO::categoriaEliminar($id);


 	// INTERFAZ:
    // $correctoNormal
    // $noExistia
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($respSQL == null || $respSQL !=0) { ?>
    <h1>Error en la eliminación</h1>
    <p>No se ha podido eliminar la categoría.</p>

<?php } else if ($respSQL != null || $respSQL ==0) { ?>

	<h1>Eliminación no realizada</h1>
	<p>No existe la categoría que se pretende eliminar (quizá la eliminaron en paraleo o, ¿ha manipulado Vd. el parámetro id?).</p>

<?php } else { ?>
    <h1>Eliminación completada</h1>
    <p>Se ha eliminado correctamente la categoría.</p>


<?php } ?>

<a href='categoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>