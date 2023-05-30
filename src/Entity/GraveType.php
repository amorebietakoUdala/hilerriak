<?php

namespace App\Entity;

use App\Repository\GraveTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GraveTypeRepository::class)
 */
class GraveType
{
    const OCUPATION = 1;
    const REST = 2;
    const PANTEON = 3;
    const ASHES = 4;
    const PIT = 5;
    const SLAB = 6;

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
     * @ORM\OneToMany(targetEntity=Grave::class, mappedBy="type")
     */
    private $graves;

    public function __construct()
    {
        $this->graves = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

    public function fill(GraveType $graveType) {
        $this->descriptionEs= $graveType->getDescriptionEs();
        $this->descriptionEu= $graveType->getDescriptionEu();
    }

    /**
     * @return Collection<int, Grave>
     */
    public function getGraves(): Collection
    {
        return $this->graves;
    }

    public function addGrave(Grave $grave): self
    {
        if (!$this->graves->contains($grave)) {
            $this->graves[] = $grave;
            $grave->setType($this);
        }

        return $this;
    }

    public function removeGrave(Grave $grave): self
    {
        if ($this->graves->removeElement($grave)) {
            // set the owning side to null (unless already changed)
            if ($grave->getType() === $this) {
                $grave->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->descriptionEs;
    }

    public function getDescription($locale): string {
        if ($locale === 'es') {
            return $this->descriptionEs;
        }
        return $this->descriptionEu;
    }
}
