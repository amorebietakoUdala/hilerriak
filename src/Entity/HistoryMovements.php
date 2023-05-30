<?php

namespace App\Entity;

use App\Repository\HistoryMovementsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryMovementsRepository::class)
 */
class HistoryMovements
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nº_registro", type="integer", nullable=true)
     */
    private $numRegistro;

    /**
     * @ORM\Column(name="año",type="string", length=255, nullable=true)
     */
    private $anyo;

    /**
     * @ORM\Column(name="tipo_acción",type="string", length=255, nullable=true)
     */
    private $tipoAccion;

    /**
     * @ORM\Column(name="sepultura_destino", type="string", length=255, nullable=true)
     */
    private $sepulturaDestino;

    /**
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @ORM\Column(name="difunto",type="string", length=255, nullable=true)
     */
    private $difunto;

    /**
     * @ORM\Column(name="descripción",type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="origen_restos",type="string", length=255, nullable=true)
     */
    private $origenRestos;

    /**
     * @ORM\Column(name="n_expediente",type="string", length=255, nullable=true)
     */
    private $numExpediente;

    /**
     * @ORM\Column(name="incidencias",type="string", length=255, nullable=true)
     */
    private $incidencias;

    /**
     * @ORM\Column(name="cementerio",type="string", length=255, nullable=true)
     */
    private $cementerio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumRegistro(): ?int
    {
        return $this->numRegistro;
    }

    public function setNumRegistro(?int $numRegistro): self
    {
        $this->numRegistro = $numRegistro;

        return $this;
    }

    public function getAnyo(): ?string 
    {
        return $this->anyo;
    }

    public function setAnyo(?string $anyo): self
    {
        $this->anyo = $anyo;

        return $this;
    }

    public function getTipoAccion(): ?string
    {
        return $this->tipoAccion;
    }

    public function setTipoAccion(?string $tipoAccion): self
    {
        $this->tipoAccion = $tipoAccion;

        return $this;
    }

    public function getSepulturaDestino(): ?string
    {
        return $this->sepulturaDestino;
    }

    public function setSepulturaDestino(?string $sepulturaDestino): self
    {
        $this->sepulturaDestino = $sepulturaDestino;

        return $this;
    }

    public function getFechaRegistro(): ?\DateTime
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(?\DateTime $fechaRegistro): self
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    public function getDifunto(): ?string
    {
        return $this->difunto;
    }

    public function setDifunto(?string $difunto): self
    {
        $this->difunto = $difunto;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getOrigenRestos(): ?string
    {
        return $this->origenRestos;
    }

    public function setOrigenRestos(?string $origenRestos): self
    {
        $this->origenRestos = $origenRestos;

        return $this;
    }

    public function getNumExpediente(): ?string
    {
        return $this->numExpediente;
    }

    public function setNumExpediente(?string $numExpediente): self
    {
        $this->numExpediente = $numExpediente;

        return $this;
    }

    public function getIncidencias(): ?string
    {
        return $this->incidencias;
    }

    public function setIncidencias(?string $incidencias): self
    {
        $this->incidencias = $incidencias;

        return $this;
    }

    public function getCementerio(): ?string
    {
        return $this->cementerio;
    }

    public function setCementerio(?string $cementerio): self
    {
        $this->cementerio = $cementerio;

        return $this;
    }
}
