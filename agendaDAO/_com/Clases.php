<?php

abstract class Dato
{
}

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Categoria extends Dato
{
    use Identificable;

    private string $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }
}
class Persona extends Dato
{
    use Identificable;

    private string $nombre;
    private string $telefono;
    private int $categoriaId;

    public function __construct(int $id,string $nombre, string $telefono, int $categoriaId)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setTelefono($telefono);
        $ $this->setCategoria_id($categoriaId);
    }

    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }
    public function setCategoriaId(int $categoriaId): void
    {
        $this->$categoriaId = $categoriaId;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }




}
