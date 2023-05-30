<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\MappedSuperclass
 */
class Person
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_person"})
     */
    protected $dni;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_person"})
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_person"})
     */
    protected $surname1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_person"})
     */
    protected $surname2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_person"})
     */
    protected $fullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $email;

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): self
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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function __toString()
    {
        return $this->dni !== null ? "$this->dni-$this->fullname" : $this->fullname;
    }
}
