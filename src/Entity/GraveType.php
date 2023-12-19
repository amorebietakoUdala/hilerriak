<?php

namespace App\Entity;

use App\Repository\GraveTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GraveTypeRepository::class)]
class GraveType implements \Stringable
{
    final public const OCUPATION = 1;
    final public const REST = 2;
    final public const PANTEON = 3;
    final public const ASHES = 4;
    final public const PIT = 5;
    final public const SLAB = 6;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $descriptionEs = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $descriptionEu = null;

    #[ORM\OneToMany(targetEntity: Grave::class, mappedBy: 'type')]
    private Collection|array $graves;

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

    public function __toString(): string
    {
        return (string) $this->descriptionEs;
    }

    public function getDescription($locale): string {
        if ($locale === 'es') {
            return $this->descriptionEs;
        }
        return $this->descriptionEu;
    }
}
