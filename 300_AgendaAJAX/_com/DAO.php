<?php

require_once "Clases.php";
require_once "Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "agenda1"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
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
        else return self::$pdo->lastInsertId();
    }

    private static function ejecutarBorrado(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return 1;
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

    public static function categoriaActualizar($id, $nombre)
    {
        $idAutogenerado=self::ejecutarActualizacion(
            "UPDATE categoria SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
        return self::categoriaObtenerPorId($idAutogenerado);
    }

    public static function categoriaCrear(string $nombre)
    {
        $idAutogenerado = self::ejecutarActualizacion(
            "INSERT INTO categoria (nombre) VALUES (?)",
            [$nombre]
        );

        return self::categoriaObtenerPorId($idAutogenerado);
    }

    public static function categoriaEliminar($id) : ?int
    {
       $rs = self::ejecutarBorrado(
            "DELETE FROM categoria WHERE id=?",
            [$id]
        );
       return $rs;
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

    private static function personaCrearDesdeRs(array $fila): Categoria
    {
        return new Persona($fila["id"], $fila["nombre"],$fila["telefono"],$fila["categoria_id"]);
    }

    public static function personasCategoriaObtener(int $id): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM persona where categoria_id = (SELECT id FROM categoria where id=?) ORDER BY nombre",
            [$id]
        );

        foreach ($rs as $fila) {
            $categoria = self::personaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }
}