<?php

namespace App\Entity;

use App\Repository\MovementTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovementTypeRepository::class)
 */
class MovementType
{
    const MOVEMENT_TYPE_ASHES_DEPOSITATION = 1;
    const MOVEMENT_TYPE_INHUMATION = 2;
    const MOVEMENT_TYPE_EXHUMATION = 3;
    const MOVEMENT_TYPE_TRANSFER = 4;

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
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="type")
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
            $movement->setType($this);
        }

        return $this;
    }

    public function removeMovement(Movement $movement): self
    {
        if ($this->movements->removeElement($movement)) {
            // set the owning side to null (unless already changed)
            if ($movement->getType() === $this) {
                $movement->setType(null);
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
}
