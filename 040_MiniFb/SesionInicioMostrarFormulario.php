<?php
    require_once "_Varios.php";

    if (haySesionIniciada()) redireccionar("ContenidoPrivado1.php");

    $datosErroneos = isset($_REQUEST["datosErroneos"]);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar Sesión</h1>

<?php if ($datosErroneos) { ?>
    <p style='color: red;'>No se ha podido iniciar sesión con los datos proporcionados. Inténtelo de nuevo.</p>
<?php } ?>

<form action='SesionInicioComprobar.php' method='get'>
    <p>Usuario: <input type='text' name='identificador' /></p>
    <p>Contraseña: <input type='password' name='contrasenna' /></p>
    <input type='submit' name='boton' value="Enviar" />
</form>

<p><a href='UsuarioNuevoFormulario.php'>Crear Cuenta</a></p>

</body>

</html>