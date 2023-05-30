<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

use App\Repository\AdjudicationRepository;

/**
 * @ORM\Entity(repositoryClass=AdjudicationRepository::class)
 */
class Adjudication
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $adjudicationYear;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $expiryYear;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $registrationNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="adjudications")
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Grave::class, inversedBy="adjudications")
     */
    private $grave;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpiryYear(): ?int
    {
        return $this->expiryYear;
    }

    public function setExpiryYear(?int $expiryYear): self
    {
        $this->expiryYear = $expiryYear;

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

    public function getRegistrationNumber(): ?int
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?int $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getGrave(): ?Grave
    {
        return $this->grave;
    }

    public function setGrave(?Grave $grave): self
    {
        $this->grave = $grave;

        return $this;
    }

    public function fill(array $data): self {
        $this->adjudicationYear = isset($data['adjudicationYear']) ? $data['adjudicationYear'] : null;
        $this->expiryYear = isset($data['expiryYear']) ? $data['expiryYear']: null;
        $this->note = isset($data['note']) ? $data['note']: null;
        $this->registrationNumber = isset($data['registrationNumber']) ? $data['registrationNumber']: null;
        $this->owner = isset($data['owner']) ? $data['owner']: null;
        $this->grave = isset($data['grave']) ? $data['grave']: null;

        return $this;
    }

    public function getAdjudicationYear(): ?int
    {
        return $this->adjudicationYear;
    }

    public function setAdjudicationYear(?int $adjudicationYear): self
    {
        $this->adjudicationYear = $adjudicationYear;

        return $this;
    }
}
