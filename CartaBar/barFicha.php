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
    $barNombre = "<introduzca nombre>";
    $estrella = false;

} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
    $sql = "SELECT * FROM lugar WHERE id=?";

    $select = $conexion->prepare($sql);
    $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
    $rs = $select->fetchAll();

    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    $barNombre = $rs[0]["nombre"];
    $barId = $rs[0]["id"];
    $barEstrella = $rs[0]["estrellaB"];
    if($barEstrella == "1"){
        $estrella = true;
    }else{
        $estrella = false;
    }

}
$sql = "SELECT * FROM plato";

$select = $conexion->prepare($sql);
$select->execute([]); // Se añade el parámetro a la consulta preparada.
$rs1 = $select->fetchAll();
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>
<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de bar</h1>
<?php } else { ?>
    <h1>Ficha de bar</h1>
<?php } ?>

<form method='post' action='barGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$barNombre?>' />
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
        <?php if ($nuevaEntrada) { ?>
        <?php } else { ?>
        <li>
            <strong>Plato: </strong>

            <ul>
                <?php
                foreach ($rs1 as $fila){
                    if(intval($barId) == intval($fila["barId"])){?>
                        <li><?='Nombre: ' . $fila["nombre"] .' Precio: ' . $fila["precio"]?></li>
                        <?php
                    }
                }
                ?>
            </ul>
        </li>
        <?php
        }
        ?>


    </ul>

    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear bar' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>


<?php
if(!$nuevaEntrada){
    ?>
    <br />
    <a href='barEliminar.php?id=<?=$id?>'>Eliminar bar</a>
    <?php
}
?>
<br />
<br />

<a href='barListado.php'>Volver al listado de bares.</a>

</body>

</html>
