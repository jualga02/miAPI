<?php

namespace App\Entity;

use App\Repository\EntradasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntradasRepository::class)]
class Entradas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column]
    private ?float $precio = null;

    #[ORM\Column]
    private ?bool $ocupado = null;

    #[ORM\Column]
    private ?int $numeroDeAsiento = null;

    #[ORM\Column]
    private ?\DateTime $fecha = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function isOcupado(): ?bool
    {
        return $this->ocupado;
    }

    public function setOcupado(bool $ocupado): static
    {
        $this->ocupado = $ocupado;

        return $this;
    }

    public function getNumeroDeAsiento(): ?int
    {
        return $this->numeroDeAsiento;
    }

    public function setNumeroDeAsiento(int $numeroDeAsiento): static
    {
        $this->numeroDeAsiento = $numeroDeAsiento;

        return $this;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }
}
