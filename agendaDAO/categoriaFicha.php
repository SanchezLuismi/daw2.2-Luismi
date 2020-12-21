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
        /*$conexion = DAO::obtenerPdoConexionBD();
        $sql1 = "
               SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos as pApellidos,
                    c.id     AS cId,
                FROM
                   persona AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                ORDER BY p.nombre
        ";

        $select = $conexion->prepare($sql1);
        $select->execute([]); // Se añade el parámetro a la consulta preparada.
        $rs1 = $select->fetchAll();*/
	}



	// INTERFAZ:
    // $nuevaEntrada
    // $categoriaNombre
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

<form method='get' action='categoriaGuardar.php'>

<input type='hidden' name='id' value='<?=$categoriaId?>' />

<ul>
	<li>
		<strong>Nombre: </strong>
		<input type='text' name='nombre' value='<?=$categoriaNombre?>' />
	</li>

</ul>

<?php if ($nuevaEntrada) { ?>
	<input type='submit' name='crear' value='Crear categoría' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>
<?php
if(!$nuevaEntrada){?>
<br />

<a href='categoriaEliminar.php?id=<?=$categoriaId?>'>Eliminar categoría</a>
<?php } ?>
<br />
<br />

<a href='categoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>