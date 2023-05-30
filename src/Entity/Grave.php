<?php

namespace App\Entity;

use App\Repository\GraveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Cemetery;
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $years;

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

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $side;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zoneOrRow;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $capacity;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $occupation;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getYears(): ?int
    {
        return $this->years;
    }

    public function setYears(?int $years): self
    {
        $this->years = $years;

        return $this;
    }

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

    public function getSide(): ?string
    {
        return $this->side;
    }

    public function setSide(?string $side): self
    {
        $this->side = $side;

        return $this;
    }

    public function getZoneOrRow(): ?int
    {
        return $this->zoneOrRow;
    }

    public function setZoneOrRow(?int $zoneOrRow): self
    {
        $this->zoneOrRow = $zoneOrRow;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getOccupation(): ?int
    {
        return $this->occupation;
    }

    public function setOccupation(?int $occupation): self
    {
        $this->occupation = $occupation;

        return $this;
    }

    public function addOccupation(): self 
    {
        $this->occupation++;
        if ($this->occupation === $this->capacity) {
            $this->free = false;
        }

        return $this;
    }

    public function removeOccupation(): self 
    {
        if ($this->occupation > 0) {
            $this->occupation--;
        };
        if ($this->occupation === 0) {
            $this->free = true;
        }

        return $this;
    }

    public static function createGrave(Cemetery $cemetery, GraveType $type, string $side, string $zoneOrRow, string $number, int $years = 10, bool $free = true, int $occupation = 0, int $capacity = 1) {
        $grave = new Grave();
        $grave->setType($type);
        $grave->setCemetery($cemetery);
        $grave->setFree($free);
        $grave->setOccupation($occupation);
        $grave->setCapacity($capacity);
        $grave->setYears($years);
        $grave->setSide($side);
        $grave->setZoneOrRow($zoneOrRow);
        $grave->setNumber($number);
        // $grave->setDescription($type->getDescriptionEs());
        $code = $side.'-'.str_pad($zoneOrRow,2,0,STR_PAD_LEFT).'-'.str_pad($number,2,0,STR_PAD_LEFT);
        $grave->setCode($code);
        return $grave;
    }
}
