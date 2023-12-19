<?php

namespace App\Entity;

use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OwnerRepository::class)]
class Owner extends Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['api_person'])]
    private $id;

    #[ORM\OneToMany(targetEntity: Adjudication::class, mappedBy: 'owner')]
    private Collection|array $adjudications;

    public function __construct()
    {
        $this->adjudications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Adjudication>
     */
    public function getAdjudications(): Collection
    {
        return $this->adjudications;
    }

    public function addAdjudication(Adjudication $adjudication): self
    {
        if (!$this->adjudications->contains($adjudication)) {
            $this->adjudications[] = $adjudication;
            $adjudication->setOwner($this);
        }

        return $this;
    }

    public function removeAdjudication(Adjudication $adjudication): self
    {
        if ($this->adjudications->removeElement($adjudication)) {
            // set the owning side to null (unless already changed)
            if ($adjudication->getOwner() === $this) {
                $adjudication->setOwner(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) ($this->dni !== null ? "$this->dni-$this->fullname" : $this->fullname);
    }
}
