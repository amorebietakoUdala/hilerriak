<?php

namespace App\Entity;

use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OwnerRepository::class)
 */
class Owner
{
//    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_owner"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_owner"})
     */
    private $dni;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_owner"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_owner"})
     */
    private $surname1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_owner"})
     */
    private $surname2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_owner"})
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCollective;

    /**
     * @ORM\OneToMany(targetEntity=Adjudication::class, mappedBy="owner")
     */
    private $adjudications;

    public function __construct()
    {
        $this->adjudications = new ArrayCollection();
    }

    // /**
    //  * @ORM\Column(type="string", length=255, nullable=true)
    //  */
//    private $expedientNumber;

    // /**
    //  * @ORM\Column(type="integer", nullable=true)
    //  */
//    private $registrationNumber;

    // /**
    //  * @ORM\Column(type="integer", nullable=true)
    //  */
//    private $creationYear;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        $this->fullname = $this->surname1.' '.$this->surname2.', '.$this->name;

        return $this;
    }

    public function getSurname1()
    {
        return $this->surname1;
    }

    public function setSurname1($surname1)
    {
        $this->surname1 = $surname1;
        $this->fullname = $this->surname1.' '.$this->surname2.', '.$this->name;

        return $this;
    }

    public function getSurname2()
    {
        return $this->surname2;
    }

    public function setSurname2($surname2)
    {
        $this->surname2 = $surname2;
        $this->fullname = $this->surname1.' '.$this->surname2.', '.$this->name;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    // public function getExpedientNumber(): ?string
    // {
    //     return $this->expedientNumber;
    // }

    // public function setExpedientNumber(?string $expedientNumber): self
    // {
    //     $this->expedientNumber = $expedientNumber;

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

    // public function getCreationYear(): ?int
    // {
    //     return $this->creationYear;
    // }

    // public function setCreationYear(?int $creationYear): self
    // {
    //     $this->creationYear = $creationYear;

    //     return $this;
    // }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of isCollective
     */ 
    public function getIsCollective()
    {
        return $this->isCollective;
    }

    /**
     * Set the value of isCollective
     *
     * @return  self
     */ 
    public function setIsCollective($isCollective)
    {
        $this->isCollective = $isCollective;

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

    public function __toString()
    {
        return $this->dni !== null ? "$this->dni-$this->fullname" : $this->fullname;
    }
}
