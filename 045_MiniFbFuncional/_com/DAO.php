<?php

require_once "Clases.php";
require_once "Varios.php";
session_start();

class DAO
{
    private static $pdo = null;

    /**
     * DAO constructor.
     */
    public function __construct()
    {
    }

    function obtenerPdoConexionBD(): PDO
    {
        $servidor = "localhost";
        $bd = "MiniFb";
        $identificador = "root";
        $contrasenna = "";
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];

        try {
            $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
            exit('Error al conectar'); //something a user can understand
        }

        return $conexion;
    }

    function intentarCanjearSesionCookie(): bool
    {
        if (isset($_COOKIE["identificador"]) && isset($_COOKIE["codigoCookie"])) {
            $arrayUsuario = obtenerUsuarioPorCodigoCookie($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);

            if ($arrayUsuario) {
                establecerSesionRam($arrayUsuario);
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

    public function establecerSesionCookie(Usuario $usuario)
    {
        // Creamos un código cookie muy complejo (no necesariamente único).
        $codigoCookie = generarCadenaAleatoria(32); // Random..
        //.
        self::ejecutarActualizacion(
            "UPDATE Usuario SET codigoCookie=? WHERE identificador=?",
            [$codigoCookie,$usuario->getIdentificador()]
        );

        // Enviamos al cliente, en forma de cookies, el identificador y el codigoCookie:
        setcookie("identificador",$usuario->getIdentificador(), time() + 600);
        setcookie("codigoCookie", $codigoCookie, time() + 600);

    }
    function destruirSesionRamYCookie()
    {
            session_destroy();
            setcookie('codigoCookie', "");
            setcookie('identificador',"");
            unset($_SESSION);
    }

    public function actualizarCodigoCookieEnBD($codigoCookie,$identificador)
    {

        self::ejecutarActualizacion(
            "UPDATE usuario SET codigoCookie=? WHERE identificador=?",
            [$codigoCookie,$identificador]
        );
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }



    /* PUBLICACION */

    private static function publicacionCrearDesdeRs(array $fila): Publicacion
    {
        if($fila["pEmisorId"] == null){
            $emisorId = new Usuario();
        }else{
            $emisorId =new Usuario($fila["uId"],$fila["uIdentificador"],$fila["uContrasenna"],$fila["uCodigoCookie"],$fila["uTipoUsuario"],
                $fila["uNombre"],$fila["uApellidos"]);
        }

        if($fila["pDestinatarioId"] == null){
            $destinatarioId=new Usuario();
        }else{
            $destinatarioId=new Usuario($fila["uId"],$fila["uIdentificador"],$fila["uContrasenna"],$fila["uCodigoCookie"],$fila["uTipoUsuario"],
                $fila["uNombre"],$fila["uApellidos"]);
        }

        if($fila["pDestacadaHasta"] == null){
            $destacadaHasta="";
        }else{
            $destacadaHasta=$fila["destacadaHasta"];
        }

        return new Publicacion($fila["pId"], $fila["pFecha"],$emisorId,$destinatarioId,
            $destacadaHasta,$fila["pAsunto"],$fila["pContenido"]);

    }

    public static function publicacionObtenerPorEmisorId($emisorId): ?Publicacion
    {
        $rs = self::ejecutarConsulta(
            "SELECT p.id as pId, p.fecha as pFecha,p.emisorId as pEmisorId,p.destinatarioId as pDestinatarioId,
	                p.destacadaHasta as pDestacadaHasta,p.asunto as pAsunto, p.contenido as pContenido,	
	                u.id as uId,u.identificador as uIdentificador,u.contrasenna as uContrasenna,u.codigoCookie as uCodigoCookie,u.tipoUsuario as uTipoUsuario,
	                u.nombre as uNombre, u.apellidos as uApellidos                
                FROM publicacion as p INNER JOIN usuario as u on p.emisorId = u.Id WHERE p.emisorId= ? ORDER BY p.fecha ",
            [$emisorId]
        );
        if ($rs) return self::publicacionCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function publicacionActualizar($id, $nombre)
    {
        self::ejecutarActualizacion(
            "UPDATE publicacion SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
    }

    public static function publicacionCrear($publicacion)
    {
        self::ejecutarActualizacion(
            "INSERT INTO publicacion (nombre) VALUES (?,?,?,?,?,?)",
            [$publicacion->getFecha(),$publicacion->getEmisorId(),$publicacion->getDestinatarioId(),$publicacion->getDestacadaHasta(),
                $publicacion->getAsunto(),$publicacion->getContenido()]
        );
    }

    public static function publicacionObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT p.id as pId, p.fecha as pFecha,p.emisorId as pEmisorId,p.destinatarioId as pDestinatarioId,
	                p.destacadaHasta as pDestacadaHasta,p.asunto as pAsunto, p.contenido as pContenido,	
	              u.id as uId,u.identificador as uIdentificador,u.contrasenna as uContrasenna,u.codigoCookie as uCodigoCookie,u.tipoUsuario as uTipoUsuario,
	                u.nombre as uNombre, u.apellidos as uApellidos                 
                FROM publicacion as p INNER JOIN usuario as u on p.emisorId = u.Id ORDER BY p.fecha ",
            []
        );
        /*$rs = self::ejecutarConsulta(
            "SELECT * FROM publicacion ORDER BY fecha",
            []
            as p
        );*/

        foreach ($rs as $fila) {
            $publicacion = self::publicacionCrearDesdeRs($fila);
            array_push($datos, $publicacion);
        }

        return $datos;
    }

    /* USUARIO */
    private static function usuarioCrearDesdeRs(array $fila): Usuario
    {
        return new Usuario($fila["id"],$fila["identificador"],$fila["contrasenna"],$fila["codigoCookie"],
            $fila["tipoUsuario"],$fila["nombre"],$fila["apellidos"]);

    }


    public static function obtenerUsuarioPorContrasenna($identificador,$contrasena): ?Usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE identificador=? AND BINARY contrasenna=?",
            [$identificador,$contrasena]
        );
        if ($rs) return self::usuarioCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function obtenerUsuarioPorIdentificador($identificador): ?Usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE identificador=?",
            [$identificador]
        );
        if ($rs) return self::usuarioCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function usuarioActualizar($id, $nombre)
    {
        self::ejecutarActualizacion(
            "UPDATE usuario SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
    }

    function obtenerUsuarioPorCodigoCookie(string $identificador, string $codigoCookie): ?Usuario
    {
        $rs = self::ejecutarActualizacion(
            "SELECT * FROM usuario WHERE identificador=? AND BINARY codigoCookie=?",
            [$identificador, $codigoCookie]
        );
        $conexion = obtenerPdoConexionBD();
        if ($rs) return self::usuarioCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function usuarioCrear($identificador,$contrasenna,$codigoCookie,$caducidadCodigoCookie,$tipoUsuario,$nombre,$apellidos)
    {
        $rs = self::ejecutarActualizacion(
            "INSERT INTO usuario (identificador,contrasenna,codigoCookie,caducidadCodigoCookie,tipoUsuario,nombre,apellidos) VALUES (?,?,?,?,?,?,?)",
            [$identificador,$contrasenna,$codigoCookie,$caducidadCodigoCookie,$tipoUsuario,$nombre,$apellidos]
        );

       /* if($rs) return ;
        else return null;*/
    }

    public static function usuarioObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            array_push($datos, $fila);
        }

        return $datos;
    }

}