<?php

require_once "Clases.php";
require_once "_varios.php";

class DAO
{
    private static $pdo = null;

    private function obtenerPdoConexionBD(): PDO
    {
        $servidor = "localhost";
        $bd = "agenda2";
        $identificador = "root";
        $contrasenna = "";
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];

        try {
            $conexionBD = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
            exit('Error al conectar'); //something a user can understand
        }

        return $conexionBD;
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if(!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }



    /* CATEGORÍA */

    private static function categoriaCrearDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM categoria WHERE id=?",
            [$id]
        );
        if ($rs) return self::categoriaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function categoriaActualizar($categoria)
    {
        self::ejecutarActualizacion(
            "UPDATE categoria SET nombre=? WHERE id=?",
            [$categoria->getNombre(),$categoria->getId() ]
        );
    }

    public static function categoriaEliminar($id)
    {
        self::ejecutarActualizacion(
            "DELETE FROM categoria WHERE id=?",
            [$id]
        );
    }

    public static function categoriaCrear(string $nombre)
    {
        self::ejecutarActualizacion(
            "INSERT INTO categoria (nombre) VALUES (?)",
            [$nombre]
        );
    }

    public static function categoriaObtenerTodas(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM categoria ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $categoria = self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }
}