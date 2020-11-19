<?php
    require_once "_varios.php";

    $conexion = obtenerPdoConexionBD();

    if (!isset($_REQUEST["pEstrella"])){
        $estrella = false;
        $condicion="";
    } else{
        $estrella = true;
        $condicion="WHERE p.estrella=1";
    }

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
                   $condicion
                ORDER BY p.nombre ";

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
            <th>Categoria</th>
        </tr>

        <?php foreach ($rs as $fila) {?>
            <tr>
                <?php
                if($estrella){?>
                    <td><a href="personaEstablecerEstadoEstrella.php?estrella=<?=$fila["pEstrella"]?>&id=<?=$fila["pId"]?>"><img src="img/estrellaRellena.png" width="20" height="20"></a></td>
                    <td><a href='personaFicha.php?id=<?=$fila["pId"]?>'> <?=$fila["pNombre"] . " " .$fila["pApellidos"]?> </a></td>
                    <td><a href=  'categoriaFicha.php?id=<?=$fila["cId"]?>'> <?=$fila["cNombre"] ?></a></td>
                    <td><a href='personaEliminar.php?id=<?=$fila["pId"]?>'> (X)                   </a></td>
                    <?php
                } else{
                        if($fila["pEstrella"] == "1"){?>
                            <td><a href='personaEstablecerEstadoEstrella.php?id=<?=$fila["pId"]?>'><img src="/agenda/img/estrellaRellena.png"  width="20" height="20"></a></td>
                        <?php
                        }else{?>

                            <td><a href='personaEstablecerEstadoEstrella.php?id=<?=$fila["pId"]?>'><img src="/agenda/img/estrellaVacia.png"  width="20" height="20"></a></td>
                        <?php
                        }?>
                    <td><a href='personaFicha.php?id=<?=$fila["pId"]?>'> <?=$fila["pNombre"] . " " .$fila["pApellidos"]?> </a></td>
                    <td><a href=  'categoriaFicha.php?id=<?=$fila["cId"]?>'> <?=$fila["cNombre"] ?></a></td>
                    <td><a href='personaEliminar.php?id=<?=$fila["pId"]?>'> (X)                   </a></td>
                <?php
                    }
                    ?>


            </tr>
        <?php } ?>

    </table>

    <br />

    <a href='personaFicha.php?id=-1'>Crear entrada</a>

    <br />
    <br />

    <a href='categoriaListado.php'>Gestionar listado de Categorias</a>
    <br />
    <?php
        if($estrella){?>
            <a href='personaListado.php'>Gestionar listado de personas</a>
       <?php
        }else{?>
            <a href='personaListado.php?pEstrella=1'>Gestionar listado de personas con estrella</a>
       <?php
        }
    ?>


</body>

</html>