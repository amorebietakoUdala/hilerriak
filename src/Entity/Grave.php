<?php

namespace App\Entity;

use App\Repository\GraveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GraveRepository::class)
 */
class Grave
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_graves"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_graves"})
     */
    private $code;

    // /**
    //  * @ORM\Column(type="string", length=255, nullable=true)
    //  */
    // private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $years;

    // /**
    //  * @ORM\Column(type="integer", nullable=true)
    //  */
    // private $expedientCreationYear;

    // /**
    //  * @ORM\Column(type="integer", nullable=true)
    //  */
    // private $registrationNumber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $free;

    /**
     * @ORM\ManyToOne(targetEntity=Cemetery::class, inversedBy="graves")
     */
    private $cemetery;

    /**
     * @ORM\ManyToOne(targetEntity=GraveType::class, inversedBy="graves")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Adjudication::class, mappedBy="grave")
     */
    private $adjudications;

    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="source")
     */
    private $sourceMovements;

    /**
     * @ORM\OneToMany(targetEntity=Movement::class, mappedBy="destination")
     */
    private $destinationMovements;

    public function __construct()
    {
        $this->adjudications = new ArrayCollection();
        $this->sourceMovements = new ArrayCollection();
        $this->destinationMovements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    // public function getDescription(): ?string
    // {
    //     return $this->description;
    // }

    // public function setDescription(string $description): self
    // {
    //     $this->description = $description;

    //     return $this;
    // }

    public function getYears(): ?int
    {
        return $this->years;
    }

    public function setYears(?int $years): self
    {
        $this->years = $years;

        return $this;
    }

    // public function getExpedientCreationYear(): ?int
    // {
    //     return $this->expedientCreationYear;
    // }

    // public function setExpedientCreationYear(?int $expedientCreationYear): self
    // {
    //     $this->expedientCreationYear = $expedientCreationYear;

    //     return $this;
    // }

    // public function getRegistrationNumber(): ?int
    // {
    //     return $this->registrationNumber;
    // }

    // public function setRegistrationNumber(?int $registrationNumber): self
    // {
    //     $this->registrationNumber = $registrationNumber;

    //     return $this;
    // }

    public function isFree(): ?bool
    {
        return $this->free;
    }

    public function setFree(?bool $free): self
    {
        $this->free = $free;

        return $this;
    }

    public function getCemetery(): ?Cemetery
    {
        return $this->cemetery;
    }

    public function setCemetery(?Cemetery $cemetery): self
    {
        $this->cemetery = $cemetery;

        return $this;
    }

    public function getType(): ?GraveType
    {
        return $this->type;
    }

    public function setType(?GraveType $type): self
    {
        $this->type = $type;

        return $this;
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
            $adjudication->setGrave($this);
        }

        return $this;
    }

    public function removeAdjudication(Adjudication $adjudication): self
    {
        if ($this->adjudications->removeElement($adjudication)) {
            // set the owning side to null (unless already changed)
            if ($adjudication->getGrave() === $this) {
                $adjudication->setGrave(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->code;
    }

    /**
     * @return Collection<int, Movement>
     */
    public function getSourceMovements(): Collection
    {
        return $this->sourceMovements;
    }

    public function addSourceMovement(Movement $sourceMovement): self
    {
        if (!$this->sourceMovements->contains($sourceMovement)) {
            $this->sourceMovements[] = $sourceMovement;
            $sourceMovement->setSource($this);
        }

        return $this;
    }

    public function removeSourceMovement(Movement $sourceMovement): self
    {
        if ($this->sourceMovements->removeElement($sourceMovement)) {
            // set the owning side to null (unless already changed)
            if ($sourceMovement->getSource() === $this) {
                $sourceMovement->setSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Movement>
     */
    public function getDestinationMovements(): Collection
    {
        return $this->destinationMovements;
    }

    public function addDestinationMovement(Movement $destinationMovement): self
    {
        if (!$this->destinationMovements->contains($destinationMovement)) {
            $this->destinationMovements[] = $destinationMovement;
            $destinationMovement->setDestination($this);
        }

        return $this;
    }

    public function removeDestinationMovement(Movement $destinationMovement): self
    {
        if ($this->destinationMovements->removeElement($destinationMovement)) {
            // set the owning side to null (unless already changed)
            if ($destinationMovement->getDestination() === $this) {
                $destinationMovement->setDestination(null);
            }
        }

        return $this;
    }

    public function getCodeCemetery(): string {
        return $this->getCode().'-'.$this->getCemetery()->getName();
    }
}
