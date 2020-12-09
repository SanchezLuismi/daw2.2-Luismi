<?php
require_once "_varios.php";

$conexion = obtenerPdoConexionBD();

if (!isset($_REQUEST["pEstrella"])){
    $estrella = false;
} else{
    $estrella = true;
}

$sql = "
               SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.precio as pPrecio,
                    p.barId as pBarId,
                    c.id     AS cId,
                    p.estrellaP as pEstrellaP,
                    c.nombre AS cNombre,
                    l.id AS lId,
                    l.nombre AS lNombre
                FROM
                   (plato AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id) INNER JOIN lugar AS l ON p.barId = l.id
                ORDER BY p.nombre
        ";

$select = $conexion->prepare($sql);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rs = $select->fetchAll();


/* */
// INTERFAZ:
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>
<h1>Listado de Personas</h1>

<table border='1'>

    <tr>
        <th>Estrella</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Categoria</th>
        <th>Bar</th>
    </tr>

    <?php foreach ($rs as $fila) {?>
         <tr>
             <?php
        if($estrella){
            if($fila["pEstrellaP"] == "1"){?>
                 <td><a href='platoFicha.php?id=<?=$fila["pId"]?>'> <?=$fila["pNombre"]?> </a></td>
                 <td><?=$fila["pPrecio"]?> €</td>
                 <td><a href=  'categoriaFicha.php?id=<?=$fila["cId"]?>'> <?=$fila["cNombre"] ?></a></td>
                 <td><a href=  'barFicha.php?id=<?=$fila["lId"]?>'> <?=$fila["lNombre"] ?></a></td>
                 <td><a href='platoEliminar.php?id=<?=$fila["pId"]?>'> (X)                   </a></td>
             <?php
                 }
        } else{
            if($fila["pEstrellaP"] == "1"){?>
                <td><a href='platoEstablecerEstadoEstrella.php?id=<?=$fila["pId"]?>'><img src="img/estrellaRellena.png"  width="20" height="20"></a></td>
                <?php
            }else{?>
                <td><a href='platoEstablecerEstadoEstrella.php?id=<?=$fila["pId"]?>'><img src="img/estrellaVacia.png"  width="20" height="20"></a></td>
                <?php
            }?>
             <td><a href='platoFicha.php?id=<?=$fila["pId"]?>'> <?=$fila["pNombre"]?> </a></td>
             <td><?=$fila["pPrecio"]?> €</td>
             <td><a href=  'categoriaFicha.php?id=<?=$fila["cId"]?>'> <?=$fila["cNombre"] ?></a></td>
             <td><a href=  'barFicha.php?id=<?=$fila["lId"]?>'> <?=$fila["lNombre"] ?></a></td>
             <td><a href='platoEliminar.php?id=<?=$fila["pId"]?>'> (X)                   </a></td>
             <?php
    }
    ?>
    <?php } ?>
         </tr>
</table>

<br />

<a href='platoFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='categoriaListado.php'>Gestionar listado de categorias</a>
<br />
<a href='barListado.php'>Gestionar listado de bares</a>
<br />
<?php
if($estrella){?>
    <a href='platoListado.php'>Gestionar listado de platos</a>
    <?php
}else{?>
    <a href='platoListado.php?pEstrella=1'>Gestionar listado de platos con estrella</a>
    <?php
}
?>


</body>

</html>
