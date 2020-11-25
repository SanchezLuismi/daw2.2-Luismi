<?php
	require_once "_varios.php";

	$conexionBD = obtenerPdoConexionBD();
    session_start();

	// Los campos que incluyo en el SELECT son los que luego podré leer
    // con $fila["campo"].
	$sql = "SELECT id, nombre FROM categoria ORDER BY nombre";

    $select = $conexionBD->prepare($sql);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rs = $select->fetchAll();

    if (!isset($_REQUEST["tema"]) && !isset($_SESSION["tema"])) {
        $_SESSION["tema"]=0;
    }else  if (isset($_REQUEST["tema"])) {
        $_SESSION["tema"]=$_REQUEST["tema"];
    }

    // INTERFAZ:
    // $rs
?>



<html>

<head>
	<meta charset='UTF-8'>
    <?php
    if( $_SESSION["tema"] == 0){?>
    <link rel="stylesheet" type="text/css" href="claro.css">
    <p>Tema de la pagina: <span class='claro'>Claro</span>   <a href='CategoriaListado.php?tema=1' class='oscuro'>Oscuro</a></p>
    <?php
    }else{?>
    <link rel="stylesheet" type="text/css" href="oscuro.css">
    <p>Tema de la pagina:  <a href='CategoriaListado.php?tema=0' class='claro'>Claro</a>  <span class='oscuro'>Oscuro</span></p>
    <?php
    }
    ?>

</head>



<body>

<h1>Listado de Categorías</h1>

<table border='1'>

	<tr>
		<th>Nombre</th>
	</tr>

	<?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href=   'categoriaFicha.php?id=<?=$fila["id"]?>'> <?=$fila["nombre"] ?> </a></td>
            <td><a href='categoriaEliminar.php?id=<?=$fila["id"]?>'> (X)                   </a></td>
        </tr>
	<?php } ?>

</table>

<br />

<a href='categoriaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='personaListado.php'>Gestionar listado de Personas</a>

</body>

</html>