<?php
    require_once "_com/DAO.php";
    $conexion = DAO::obtenerPdoConexionBD();
    session_start();
// Crear post-it vacío, o recuperar el que ya haya  (vacío o con cosas).
if (isset($_REQUEST["pEstrella"])) {
    $_SESSION["soloEstrellas"] = true;
    $estrella = true;
}
if (!isset($_REQUEST["pEstrella"])) {
    unset($_SESSION["soloEstrellas"]);
    $estrella=false;
}

if (!isset($_REQUEST["tema"]) && !isset($_SESSION["tema"])) {
    $_SESSION["tema"]=0;
}else  if (isset($_REQUEST["tema"])) {
    $_SESSION["tema"]=$_REQUEST["tema"];
}
$posibleClausulaWhere = isset($_SESSION["soloEstrellas"]) ? "WHERE p.estrella=1" : "";

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
                   $posibleClausulaWhere
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
    <?php
    if($_SESSION["tema"] == 0){?>
        <link rel="stylesheet" type="text/css" href="claro.css">
        <p>Tema de la pagina: <span class='claro'>Claro</span>   <a href='PersonaListado.php?tema=1' class='oscuro'>Oscuro</a></p>
        <?php
    }else{?>
        <link rel="stylesheet" type="text/css" href="oscuro.css">
        <p>Tema de la pagina:  <a href='PersonaListado.php?tema=0' class='claro'>Claro</a>  <span class='oscuro'>Oscuro</span></p>
        <?php
    }
    ?>
</head>



<body>
    <h1>Listado de Personas</h1>

    <table border='1'>
        <?php
        if($estrella){?>
        <tr>
            <th>Nombre</th>
            <th>Categoria</th>
        </tr>
        <?php
        }else{?>
            <tr>
            <th>Estrella</th>
            <th>Nombre</th>
            <th>Categoria</th>
        </tr>
            <?php
        }
         foreach ($rs as $fila) {?>
            <tr>
                <?php
                if($estrella){?>
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