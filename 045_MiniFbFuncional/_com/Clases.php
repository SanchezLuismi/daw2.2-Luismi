<?php

abstract class Dato
{
}

trait Identificable
{
    protected  $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }
}

class Publicacion extends Dato
{
    use Identificable;

    private $fecha;
    private $emisor;
    private $destinatario;
    private $destacadaHasta;
    private $asunto;
    private $contenido;

    public function __construct(string $id,string $fecha, Usuario $emisor, Usuario $destinatario, string $destacadaHasta, string $asunto, string $contenido)
    {
        $this->setId($id);
        $this->setFecha($fecha);
        $this->setEmisor($emisor);
        $this->setDestinatario($destinatario);
        $this->setDestacadaHasta($destacadaHasta);
        $this->setAsunto($asunto);
        $this->setContenido($contenido);
    }


    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(Usuario $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getEmisor(): Usuario
    {
        return $this->emisorId;
    }

    public function setEmisor(Usuario $emisorId): void
    {
        $this->emisorId = $emisorId;
    }

    public function getDestinatario(): Usuario
    {
        return $this->destinatarioId;
    }

    public function setDestinatario(Usuario $destinatarioId): void
    {
        $this->destinatarioId = $destinatarioId;
    }

    public function getDestacadaHasta(): string
    {
        return $this->destacadaHasta;
    }

    public function setDestacadaHasta(string $destacadaHasta): void
    {
        $this->destacadaHasta = $destacadaHasta;
    }

    public function getAsunto(): string
    {
        return $this->asunto;
    }

    public function setAsunto(string $asunto): void
    {
        $this->asunto = $asunto;
    }

    public function getContenido(): string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): void
    {
        $this->contenido = $contenido;
    }




}

class Usuario extends Dato
{
    use Identificable;

    private $identificador;
    private $contrasenna;
    private $codigoCookie;
    private $tipoUsuario;
    private $nombre;
    private $apellidos;
    

    public function __construct(int $id,string $identificador, string $contrasenna, string $codigoCookie, int $tipoUsuario, string $nombre, string $apellidos)
    {
        $this->setId($id);
        $this->setIdentificador($identificador);
        $this->setContrasenna($contrasenna);
        $this->setCodigoCookie($codigoCookie);
        $this->setTipoUsuario($tipoUsuario);
        $this->setNombre($nombre);
        $this->setapellidos($apellidos);
    }


    public function getIdentificador(): string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador): void
    {
        $this->identificador = $identificador;
    }

    public function getContrasenna(): string
    {
        return $this->contrasenna;
    }

    public function setContrasenna(string $contrasenna): void
    {
        $this->contrasenna = $contrasenna;
    }

    public function getCodigoCookie(): string
    {
        return $this->codigoCookie;
    }

    public function setCodigoCookie(string $codigoCookie): void
    {
        $this->codigoCookie = $codigoCookie;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getTipoUsuario(): int
    {
        return $this->tipoUsuario;
    }

    public function setTipoUsuario(int $tipoUsuario): void
    {
        $this->tipoUsuario = $tipoUsuario;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

}