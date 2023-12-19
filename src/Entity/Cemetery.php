<?php

namespace App\Entity;

use App\Repository\CemeteryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CemeteryRepository::class)]
class Cemetery implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Grave::class, mappedBy: 'cemetery')]
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function fill(Cemetery $cemetery) {
        $this->name = $cemetery->getName();

        return $this;
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
            $grave->setCemetery($this);
        }

        return $this;
    }

    public function removeGrave(Grave $grave): self
    {
        if ($this->graves->removeElement($grave)) {
            // set the owning side to null (unless already changed)
            if ($grave->getCemetery() === $this) {
                $grave->setCemetery(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->name;
    }
}
