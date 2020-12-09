<?php
	require_once "_varios.php";

    if (!isset($_REQUEST["pEstrella"])){
        $estrella = false;
    } else{
        $estrella = true;
    }

	$conexionBD = obtenerPdoConexionBD();

	// Los campos que incluyo en el SELECT son los que luego podré leer
    // con $fila["campo"].
	$sql = "SELECT id, nombre, estrellaB FROM lugar ORDER BY nombre";

    $select = $conexionBD->prepare($sql);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rs = $select->fetchAll();

    // INTERFAZ:
    // $rs
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<h1>Listado de Categorías</h1>

<table border='1'>

	<tr>
        <th>Estrella</th>
		<th>Nombre</th>
	</tr>

	<?php
	foreach ($rs as $fila) {?>
	    <tr>
        <?php
        if($estrella){
            if($fila["estrellaB"] == "1"){?>
                <td><a href=   'barFicha.php?id=<?=$fila["id"]?>'> <?=$fila["nombre"] ?> </a></td>
                <td><a href='barEliminar.php?id=<?=$fila["id"]?>'> (X)                   </a></td>
    <?php
                        }
        }else{
        if($fila["estrellaB"] == "1"){?>
            <td><a href='barEstablecerEstadoEstrella.php?id=<?=$fila["id"]?>'><img src="img/estrellaRellena.png"  width="20" height="20"></a></td>
        <?php
        }else{?>
            <td><a href='barEstablecerEstadoEstrella.php?id=<?=$fila["id"]?>'><img src="img/estrellaVacia.png"  width="20" height="20"></a></td>
            <?php
            }
            ?>
        <td><a href=   'barFicha.php?id=<?=$fila["id"]?>'> <?=$fila["nombre"] ?> </a></td>
        <td><a href='barEliminar.php?id=<?=$fila["id"]?>'> (X)                   </a></td>
	<?php
        }
        ?>
        </tr>
    <?php
    }?>

</table>

<br />

<a href='barFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='platoListado.php'>Gestionar listado de platos</a>
<br />
<a href='categoriaListado.php'>Gestionar listado de categorias</a>

<br />
<?php
if($estrella){?>
    <a href='barListado.php'>Gestionar listado de bares</a>
    <?php
}else{?>
    <a href='barListado.php?pEstrella=1'>Gestionar listado de bares con estrella</a>
    <?php
}
?>

</body>

</html>