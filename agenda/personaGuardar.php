<?php
    require_once "_varios.php";

    $conexionBD = obtenerPdoConexionBD();

    // Se recogen los datos del formulario de la request.
    $id = (int)$_REQUEST["id"];
    $nombre = $_REQUEST["nombre"];
    $categoria =(int) $_REQUEST["categoria"];
    $telefono = $_REQUEST["telefono"];
    $apellidos = $_REQUEST["apellidos"];
    if (!isset($_REQUEST["estrella"])){
        $estrella = "0";
    } else{
        $estrella = $_REQUEST["estrella"];
    }

    // Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
    // Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
    // (y $nueva_entrada tomará false).
    $nuevaEntrada = ($id == -1);

    if ($nuevaEntrada) {
        // Quieren CREAR una nueva entrada, así que es un INSERT.
        $sql = "INSERT INTO persona (nombre,apellidos,telefono,estrella,categoriaId) VALUES (?,?,?,?,?)";
        $parametros = [$nombre,$apellidos,$telefono,$estrella,$categoria];
    } else {
        // Quieren MODIFICAR una categoría existente y es un UPDATE.
        $sql = "UPDATE persona SET nombre=?,apellidos=?,telefono=?,estrella=?,categoriaId=? WHERE id=?";
        $parametros = [$nombre,$apellidos,$telefono,$estrella,$categoria,$id];
    }

    $sentencia = $conexionBD->prepare($sql);
    //Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.
    $sqlConExito = $sentencia->execute($parametros); // Se añaden los parámetros a la consulta preparada.

    // Está todo correcto de forma normal si NO ha habido errores y se ha visto afectada UNA fila.
    $correcto = ($sqlConExito && $sentencia->rowCount() == 1);

    // Si los datos no se habían modificado, también está correcto pero es "raro".
    $datosNoModificados = ($sqlConExito && $sentencia->rowCount() == 0);
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>
    <?php
    if ($correcto || $datosNoModificados) { ?>
    <?php if ($nuevaEntrada) { ?>
        <h1>Inserción completada</h1>
    <p>Se ha insertado correctamente la nueva entrada de <?=$nombre?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
    <p>Se han guardado correctamente los datos de <?=$nombre?>.</p>

    <?php if ($datosNoModificados) { ?>
        <p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
    <?php } ?>
            <?php }
    ?>

    <?php
    } else {
    ?>

        <?php if ($nuevaEntrada) { ?>
        <h1>Error en la creación.</h1>
        <p>No se ha podido crear la nueva persona.</p>
    <?php } else { ?>
        <h1>Error en la modificación.</h1>
        <p>No se han podido guardar los datos de la persona.</p>
    <?php } ?>

    <?php
    }
    ?>

    <a href='personaListado.php'>Volver al listado de personas.</a>

</body>

</html>