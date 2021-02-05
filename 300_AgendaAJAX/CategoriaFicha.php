<?php
require_once "_com/DAO.php";



// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (y $nueva_entrada tomará false).
$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $categoriaId = -1;
    $categoriaNombre = "<introduzca nombre>";
} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
    $categoria = DAO::categoriaObtenerPorId($id);
    $categoriaNombre = $categoria->getNombre();
    $categoriaId = $categoria->getId();
    $personas = DAO::personasCategoriaObtener($id);
}
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
	<h1>Nueva ficha de categoría</h1>
<?php } else { ?>
	<h1>Ficha de categoría</h1>
<?php } ?>

<form method='post' action='CategoriaGuardar.php'>

<input type='hidden' name='id' value='<?=$id?>' />

    <label for='nombre'>Nombre</label>
	<input type='text' name='nombre' value='<?=$categoriaNombre?>' />
    <br/>

    <br/>

<?php if ($nuevaEntrada) { ?>
	<input type='submit' name='crear' value='Crear categoría' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<br />

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='CategoriaEliminar.php?id=<?=$id?>'>Eliminar categoría</a>
<?php } ?>

<br />
<br />

<a href='Agenda.html'>Volver al listado de categorías.</a>

</body>

</html>