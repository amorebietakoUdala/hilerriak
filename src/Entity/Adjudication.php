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
     * @ORM\Column(type="date", nullable=true)
     */
    private $decreeDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $expiryYear;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $renewed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $expedientNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $registrationNumber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $current;

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

    public function getDecreeDate(): ?\DateTimeInterface
    {
        return $this->decreeDate;
    }

    public function setDecreeDate(?\DateTimeInterface $decreeDate): self
    {
        $this->decreeDate = $decreeDate;

        return $this;
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

    public function isRenewed(): ?bool
    {
        return $this->renewed;
    }

    public function setRenewed(bool $renewed): self
    {
        $this->renewed = $renewed;

        return $this;
    }

    public function getExpedientNumber(): ?string
    {
        return $this->expedientNumber;
    }

    public function setExpedientNumber(?string $expedientNumber): self
    {
        $this->expedientNumber = $expedientNumber;

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

    public function isCurrent(): ?bool
    {
        return $this->current;
    }

    public function setCurrent(?bool $current): self
    {
        $this->current = $current;

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
        $this->decreeDate = isset($data['decreeDate']) ? $data['decreeDate'] : null;
        $this->expiryYear = isset($data['expiryYear']) ? $data['expiryYear']: null;
        $this->note = isset($data['note']) ? $data['note']: null;
        $this->renewed = isset($data['renewed']) ? $data['renewed']: null;
        $this->expedientNumber = isset($data['expedientNumber']) ? $data['expedientNumber']: null;
        $this->registrationNumber = isset($data['registrationNumber']) ? $data['registrationNumber']: null;
        $this->current = isset($data['current']) ? $data['current']: null;
        $this->owner = isset($data['owner']) ? $data['owner']: null;
        $this->grave = isset($data['grave']) ? $data['grave']: null;

        return $this;
    }
}
