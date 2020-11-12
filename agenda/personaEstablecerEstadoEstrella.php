<?php
require_once "_varios.php";

$conexion = obtenerPdoConexionBD();

$sql = "
               SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos as pApellidos,
                    p.telefono as pTelefono,
                    p.estrella as pEstrella,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   persona AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                ORDER BY p.nombre
        ";

$select = $conexion->prepare($sql);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rs = $select->fetchAll();
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>
<h1>Listado de Personas</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Categoria</th>
    </tr>

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <?php
            if($fila["pEstrella"] == "1"){?>
                <td><a href='personaFicha.php?id=<?=$fila["pId"]?>'> <?=$fila["pNombre"] . " " .$fila["pApellidos"]?> </a></td>
                <td><a href=  'categoriaFicha.php?id=<?=$fila["cId"]?>'> <?=$fila["cNombre"] ?></a></td>
                <td><a href='personaEliminar.php?id=<?=$fila["pId"]?>'> (X)                   </a></td>
                <?php
            }?>

        </tr>
    <?php } ?>

</table>

<br />

<a href='personaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='categoriaListado.php'>Gestionar listado de Categorias</a>
<br />
<a href='personaListado.php'>Gestionar listado de personas</a>

</body>

</html>
