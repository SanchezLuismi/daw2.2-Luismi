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
        $personaNombre = "<introduzca nombre>";
        $telefono="<introduzca telefono>";
        $personaEstrella="0";

    } else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
        $sql = "SELECT * FROM persona WHERE id=?";

        $select = $conexion->prepare($sql);
        $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
        $rs = $select->fetchAll();

        // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
        $personaNombre = $rs[0]["nombre"];
        $telefono = $rs[0]["telefono"];
        $personaCategoria = $rs[0]["categoriaId"];
        $personaApellidos = $rs[0]["apellidos"];
        $personaEstrella = $rs[0]["estrella"];
        if($personaEstrella == "1"){
            $estrella = true;
        }else{
            $estrella = false;
        }
      //  echo $personaEstrella;

}
$sql = "SELECT * FROM categoria";

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
    <h1>Nueva ficha de Persona</h1>
<?php } else { ?>
    <h1>Ficha de persona</h1>
<?php } ?>

<form method='post' action='personaGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$personaNombre?>' />
        </li>
        <li>
            <strong>Apellidos: </strong>
            <input type='text' name='apellidos' value='<?=$personaApellidos?>' />
        </li>
        <li>
            <strong>Categoria: </strong>
            <select name="categoria">
            <?php
                foreach ($rs1 as $fila){
                       if(intval($personaCategoria) == intval($fila["id"])){?>
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
            <strong>Telefono: </strong>
            <input type='text' name='telefono' value='<?=$telefono?>' />
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
        <input type='submit' name='crear' value='Crear persona' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>


<?php
if(!$nuevaEntrada){
    ?>
    <br />
    <a href='personaEliminar.php?id=<?=$id?>'>Eliminar persona</a>
<?php
    }
?>
<br />
<br />

<a href='personaListado.php'>Volver al listado de persona.</a>

</body>

</html>