<?php
require_once "_com/DAO.php";
if (DAO::haySesionRamIniciada()) redireccionar("MuroVerGlobal.php");

$datosErroneos = isset($_REQUEST["datosErroneos"]);
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar sesión</h1>

<?php if ($datosErroneos) { ?>
    <p style='color: red;'>No se ha podido crear el usuario con los datos proporcionados. Inténtelo de nuevo.</p>
<?php } ?>

<form action='UsuarioNuevoCrear.php' method="post">
    <label for='identificador'>Identificador</label>
    <input type='text' name='identificador' required><br><br>

    <label for='contrasenna'>Contraseña</label>
    <input type='password' name='contrasenna' id='contrasenna' required><br><br>

    <label for='contrasenna'>Nombre</label>
    <input type='text' name='nombre' id='nombre' required><br><br>

    <label for='contrasenna'>Apellidos</label>
    <input type='text' name='apellidos' id='apellidos' required><br><br>

    <input type='submit' value='Crear Usuario'>
</form>

<p>O, si no tienes una cuenta aún, <a href='UsuarioNuevoCrear.php'>créala aquí</a>.</p>

</body>

</html>