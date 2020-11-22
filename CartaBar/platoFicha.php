<?php
require_once "_varios.php";

$conexion = obtenerPdoConexionBD();

// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (y $nueva_entrada tomará false).
$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $platoNombre = "<introduzca nombre>";
    $platoPrecio="<introduzca precio>";
    $estrella = false;

} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
    $sql = "SELECT * FROM plato WHERE id=?";

    $select = $conexion->prepare($sql);
    $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
    $rs = $select->fetchAll();

    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    $platoNombre = $rs[0]["nombre"];
    $platoPrecio = $rs[0]["precio"];
    $platoCategoria = $rs[0]["categoriaId"];
    $platoBar = $rs[0]["barId"];
    $platoEstrella = $rs[0]["estrellaP"];
    if($platoEstrella == "1"){
        $estrella = true;
    }else{
        $estrella = false;
    }

}
$sql = "SELECT * FROM categoria";

$select = $conexion->prepare($sql);
$select->execute([]); // Se añade el parámetro a la consulta preparada.
$rs1 = $select->fetchAll();

$sql2 = "SELECT * FROM lugar";

$select = $conexion->prepare($sql2);
$select->execute([]); // Se añade el parámetro a la consulta preparada.
$rs2 = $select->fetchAll();
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>
<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de plato</h1>
<?php } else { ?>
    <h1>Ficha de plato</h1>
<?php } ?>

<form method='post' action='platoGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$platoNombre?>' />
        </li>
        <li>
            <strong>Precio: </strong>
            <input type='text' name='precio' value='<?=$platoPrecio?>'/>
        </li>
        <li>
            <strong>Categoria: </strong>
            <select name="categoria">
                <?php
                foreach ($rs1 as $fila){
                    if(intval($platoCategoria) == intval($fila["id"])){?>
                        <option value=<?=$fila["id"]?> selected><?=$fila["nombre"]?></option>
                        <?php
                    }else{?>
                        <option value=<?=$fila["id"]?>><?=$fila["nombre"]?></option>
                    <?php  }
                }
                ?>
            </select>
        </li>
        <li>
            <strong>Bar: </strong>
            <select name="bar">
                <?php
                foreach ($rs2 as $fila){
                    if(intval($platoBar) == intval($fila["id"])){?>
                        <option value=<?=$fila["id"]?> selected><?=$fila["nombre"]?></option>
                        <?php
                    }else{?>
                        <option value=<?=$fila["id"]?>><?=$fila["nombre"]?></option>
                    <?php  }
                }
                ?>
            </select>
        </li>
        <li>
            <strong>Estrella: </strong>
            <?php
            switch ($estrella){
                case true: echo '<input type="checkbox" name="estrella" value="1" checked/>';
                    break;
                case false:echo '<input type="checkbox" name="estrella" value="1"/>';
            }
            ?>

        </li>

    </ul>

    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear plato' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>


<?php
if(!$nuevaEntrada){
    ?>
    <br />
    <a href='platoEliminar.php?id=<?=$id?>'>Eliminar persona</a>
    <?php
}
?>
<br />
<br />

<a href='platoListado.php'>Volver al listado de platos.</a>

</body>

</html>
