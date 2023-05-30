<?php

namespace App\Entity;

use App\Repository\PetitionerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PetitionerRepository::class)
 */
class Petitioner extends Person
{
//    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_person"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="petitioner")
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
            $movement->setPetitioner($this);
        }

        return $this;
    }

    public function removeMovement(Movement $movement): self
    {
        if ($this->movements->removeElement($movement)) {
            // set the owning side to null (unless already changed)
            if ($movement->getPetitioner() === $this) {
                $movement->setPetitioner(null);
            }
        }

        return $this;
    }

    public static function createPetitioner(Owner $owner) {
        $petitioner = new Petitioner();
        $petitioner->setDni($owner->getDni());
        $petitioner->setName($owner->getName());
        $petitioner->setSurname1($owner->getSurname1());
        $petitioner->setSurname2($owner->getSurname2());
        $petitioner->setFullname($owner->getFullname());
        $petitioner->setTelephone($owner->getTelephone());
        $petitioner->setEmail($owner->getEmail());
        return $petitioner;
    }
}
