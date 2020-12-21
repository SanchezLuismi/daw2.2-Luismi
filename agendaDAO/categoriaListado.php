<?php
	require_once "_com/DAO.php";
	session_start();

    $categorias = DAO::categoriaObtenerTodas();
?>



<html>

<head>
	<meta charset='UTF-8'>
    <?php
    if( $_SESSION["tema"] == 0){?>
    <link rel="stylesheet" type="text/css" href="claro.css">
    <p>Tema de la pagina: <span class='claro'>Claro</span>   <a href='categoriaListado.php?tema=1' class='oscuro'>Oscuro</a></p>
    <?php
    }else{?>
    <link rel="stylesheet" type="text/css" href="oscuro.css">
    <p>Tema de la pagina:  <a href='categoriaListado.php?tema=0' class='claro'>Claro</a>  <span class='oscuro'>Oscuro</span></p>
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

    <?php foreach ($categorias as $categoria) { ?>
        <tr>
            <td><a href='categoriaFicha.php?id=<?=$categoria->getId()?>'>    <?=$categoria->getNombre()?> </a></td>
            <td><a href='categoriaEliminar.php?id=<?=$categoria->getId()?>'> (X)                            </a></td>
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