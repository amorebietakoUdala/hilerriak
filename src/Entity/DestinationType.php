<?php

namespace App\Entity;

use App\Repository\DestinationTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DestinationTypeRepository::class)
 */
class DestinationType
{
    const DESTINATION_TYPE_GRAVE = 1;
    const DESTINATION_TYPE_ZINC_BOX = 2;
    const DESTINATION_TYPE_BAG = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionEs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionEu;

    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="destinationType")
     */
    private $movements;

    public function __construct()
    {
        $this->movements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionEs(): ?string
    {
        return $this->descriptionEs;
    }

    public function setDescriptionEs(string $descriptionEs): self
    {
        $this->descriptionEs = $descriptionEs;

        return $this;
    }

    public function getDescriptionEu(): ?string
    {
        return $this->descriptionEu;
    }

    public function setDescriptionEu(string $descriptionEu): self
    {
        $this->descriptionEu = $descriptionEu;

        return $this;
    }

    /**
     * @return Collection<int, Movement>
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }

    public function addMovement(Movement $movement): self
    {
        if (!$this->movements->contains($movement)) {
            $this->movements[] = $movement;
            $movement->setDestinationType($this);
        }

        return $this;
    }

    public function removeMovement(Movement $movement): self
    {
        if ($this->movements->removeElement($movement)) {
            // set the owning side to null (unless already changed)
            if ($movement->getDestinationType() === $this) {
                $movement->setDestinationType(null);
            }
        }

        return $this;
    }

    public function getDescription($locale): string {
        if ($locale === 'es') {
            return $this->descriptionEs;
        }
        return $this->descriptionEu;
    }

    public function __toString()
    {
        return $this->descriptionEs;
    }
}
