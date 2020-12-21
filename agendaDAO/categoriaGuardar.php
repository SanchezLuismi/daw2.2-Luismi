<?php
require_once "_com/DAO.php";

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
	// (y $nueva_entrada tomará false).
    if($id == -1){
        $nuevaEntrada = true;
    }else{
        $nuevaEntrada =false;
    }
	//$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
        $respSQL = DAO::categoriaCrear($nombre);
	} else {
	    $categoria = DAO::categoriaObtenerPorId($id);
	    $categoria->setNombre($nombre);
        $respSQL = DAO::categoriaActualizar($categoria);
 	}



 	// INTERFAZ:
    // $nuevaEntrada
    // $correcto
    // $datosNoModificados
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php
	// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
	if ($respSQL == null && $respSQL !=0) { ?>
        <?php if ($nuevaEntrada) { ?>
            <h1>Error en la creación.</h1>
            <p>No se ha podido crear la nueva categoría.</p>
        <?php } else { ?>
            <h1>Error en la modificación.</h1>
            <p>No se han podido guardar los datos de la categoría.</p>
        <?php } ?>

			<?php if ($respSQL != null && $respSQL ==0) { ?>
				<p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
			<?php } ?>

<?php
	} else {
?>
<?php if ($nuevaEntrada) { ?>
    <h1>Inserción completada</h1>
    <p>Se ha insertado correctamente la nueva entrada de <?=$nombre?>.</p>
<?php } else { ?>
    <h1>Guardado completado</h1>
    <p>Se han guardado correctamente los datos de <?=$nombre?>.</p>


<?php
	}
    }
?>

<a href='categoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>