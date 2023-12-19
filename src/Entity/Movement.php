<?php

namespace App\Entity;

use App\Repository\MovementRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: MovementRepository::class)]
class Movement
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: MovementType::class, inversedBy: 'movements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MovementType $type = null;

    #[ORM\ManyToOne(targetEntity: Grave::class, inversedBy: 'sourceMovements')]
    private ?Grave $source = null;

    #[ORM\ManyToOne(targetEntity: DestinationType::class, inversedBy: 'movements')]
    private ?DestinationType $destinationType = null;

    #[ORM\ManyToOne(targetEntity: Grave::class, inversedBy: 'destinationMovements')]
    private ?Grave $destination = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $registrationNumber = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $year = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $defunctName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $defunctSurname1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $defunctSurname2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $defunctFullname;

    #[ORM\Column(type: 'string', length: 1024, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $finalized = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $deceaseDate = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private $movementEndDate;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $wantsToBePresent = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $relationship = null;

    #[ORM\ManyToOne(targetEntity: Petitioner::class, inversedBy: 'movements', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Petitioner $petitioner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?MovementType
    {
        return $this->type;
    }

    public function setType(?MovementType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSource(): ?Grave
    {
        return $this->source;
    }

    public function setSource(?Grave $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getDestination(): ?Grave
    {
        return $this->destination;
    }

    public function setDestination(?Grave $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getRegistrationNumber(): ?int
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?int $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function isFinalized(): ?bool
    {
        return $this->finalized;
    }

    public function setFinalized(?bool $finalized): self
    {
        $this->finalized = $finalized;

        return $this;
    }

    public function getDeceaseDate(): ?\DateTimeInterface
    {
        return $this->deceaseDate;
    }

    public function setDeceaseDate(?\DateTimeInterface $deceaseDate): self
    {
        $this->deceaseDate = $deceaseDate;

        return $this;
    }

    public function getDefunctName()
    {

        return $this->defunctName;

    }

    public function setDefunctName($defunctName)
    {
        $this->defunctName = $defunctName;
        $this->defunctFullname = $this->defunctName.' '. $this->defunctSurname1.' '.$this->defunctSurname2;

        return $this;
    }

    public function getDefunctSurname1()
    {
        return $this->defunctSurname1;
    }

    public function setDefunctSurname1($defunctSurname1)
    {
        $this->defunctSurname1 = $defunctSurname1;
        $this->defunctFullname = $this->defunctName.' '. $this->defunctSurname1.' '.$this->defunctSurname2;

        return $this;
    }

    public function getDefunctSurname2()
    {
        return $this->defunctSurname2;
    }

    public function setDefunctSurname2($defunctSurname2)
    {
        $this->defunctSurname2 = $defunctSurname2;
        $this->defunctFullname = $this->defunctName.' '. $this->defunctSurname1.' '.$this->defunctSurname2;

        return $this;
    }

    public function getDefunctFullname()
    {
        return $this->defunctFullname;
    }

    public function setDefunctFullname($defunctFullname)
    {
        $this->defunctFullname = $defunctFullname;

        return $this;
    }

    public function getDestinationType(): ?DestinationType
    {
        return $this->destinationType;
    }

    public function setDestinationType(?DestinationType $destinationType): self
    {
        $this->destinationType = $destinationType;

        return $this;
    }

    public function getMovementEndDate()
    {
        return $this->movementEndDate;
    }

    public function setMovementEndDate($movementEndDate)
    {
        $this->movementEndDate = $movementEndDate;

        return $this;
    }

    public function isWantsToBePresent(): ?bool
    {
        return $this->wantsToBePresent;
    }

    public function setWantsToBePresent(?bool $wantsToBePresent): self
    {
        $this->wantsToBePresent = $wantsToBePresent;

        return $this;
    }

    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    public function setRelationship(?string $relationship): self
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function getPetitioner(): ?Petitioner
    {
        return $this->petitioner;
    }

    public function setPetitioner(?Petitioner $petitioner): self
    {
        $this->petitioner = $petitioner;

        return $this;
    }
}
