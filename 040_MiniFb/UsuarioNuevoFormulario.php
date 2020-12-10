<?php
$datosErroneos = isset($_REQUEST["datosErroneos"]);
?>
<h1>Crear Cuenta</h1>

<?php if ($datosErroneos) { ?>
    <p style='color: red;'>No se ha podido iniciar sesión con los datos proporcionados. Inténtelo de nuevo.</p>
<?php } ?>
<form action='UsuarioNuevoCrear.php' method='get'>
    <p>Usuario: <input type='text' name='identificador' /></p>
    <p>Contraseña: <input type='password' name='contrasenna' /></p>
    <p>Nombre: <input type='text' name='nombre' /></p>
    <p>Apellidos: <input type='text' name='apellidos' /></p>
    <input type='submit' name='boton' value="Enviar" />
</form>
