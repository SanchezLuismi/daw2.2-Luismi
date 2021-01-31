<?php

declare(strict_types=1);

// (Esta función no se utiliza en este proyecto pero se deja por si se optimizase el flujo de navegación.)
// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function marcarSesionComoIniciada($usuario)
{
    // TODO Anotar en el post-it todos estos datos:
    $_SESSION["id"] = $usuario->getId();
    $_SESSION["identificador"] = $usuario->getIdentificador();
    $_SESSION["codigoCookie"] = $usuario->getCodigoCookie();
    $_SESSION["contrasenna"] = $usuario->getContrasenna();
    $_SESSION["nombre"] = $usuario->getNombre();
    $_SESSION["apellidos"] = $usuario->getApellidos();
}

function haySesionRamIniciada(): bool
{
    // TODO Pendiente hacer la comprobación.

    // Está iniciada si isset($_SESSION["id"])
    return isset($_SESSION["id"]) ? true : false;

}

function borrarCookies()
{
    setcookie("id", "", time() - 3600);
    setcookie("identificador", "", time() - 3600);
    setcookie("codigoCookie", "", time() - 3600);
    setcookie("contrasenna", "", time() - 3600);
    setcookie("nombre", "", time() - 3600);
    setcookie("apellidos", "", time() - 3600);
}

function pintarInfoSesion() {
    if (haySesionRamIniciada()) {
        echo "<span>Sesión iniciada por <a href='UsuarioPerfilVer.php'>$_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='SesionCerrar.php'>Cerrar sesión</a></span>";
    } else {
        echo "<a href='SesionInicioFormulario.php'>Iniciar sesión</a>";
    }
}

function intentarCanjearSesionCookie(): bool
{
    if (isset($_COOKIE["identificador"]) && isset($_COOKIE["codigoCookie"])) {
        $arrayUsuario = obtenerUsuarioPorCodigoCookie($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);

        if ($arrayUsuario) {
            marcarSesionComoIniciada($arrayUsuario);
            establecerSesionCookie($arrayUsuario); // Para re-generar el numerito.
            return true;
        } else { // Venían cookies pero los datos no estaban bien.
          borrarCookies(); // Las borramos para evitar problemas.
            return false;
        }
    } else { // No vienen ambas cookies.
        borrarCookies(); // Las borramos por si venía solo una de ellas, para evitar problemas.
        return false;
    }
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}

function obtenerFecha(): string
{
    return date("Y-m-d H:i:s");
}

function generarCadenaAleatoria($longitud) : string
{
    for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != $longitud; $x = rand(0,$z), $s .= $a[$x], $i++);
    return $s;
}

