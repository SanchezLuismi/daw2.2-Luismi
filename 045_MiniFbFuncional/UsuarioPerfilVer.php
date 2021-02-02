<?php

require_once "_com/DAO.php";
if (!DAO::haySesionRamIniciada())  redireccionar("SesionInicioFormulario.php");

$usuario = DAO::obtenerUsuarioPorId($_SESSION["id"]);


?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php DAO::pintarInfoSesion(); ?>

<h4>Nombre: <?= $usuario->getNombre() ." " . $usuario->getApellidos() ?> </h4>
<h4>Nombre Usuario: <?= $usuario->getIdentificador() ?></h4>

<a href='Index.php'>Ir al pagina principal</a>
<a href='MuroVerde.php'>Ir a tu muro</a>
<a href='MuroVerGlobal.php'>Ir al muro global</a>
</body>

</html>