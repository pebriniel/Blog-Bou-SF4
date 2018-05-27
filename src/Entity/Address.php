<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Workplace", mappedBy="Address")
     */
    private $workplaces;

    public function __construct()
    {
        $this->workplaces = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Workplace[]
     */
    public function getWorkplaces(): Collection
    {
        return $this->workplaces;
    }

    public function addWorkplace(Workplace $workplace): self
    {
        if (!$this->workplaces->contains($workplace)) {
            $this->workplaces[] = $workplace;
            $workplace->setAddress($this);
        }

        return $this;
    }

    public function removeWorkplace(Workplace $workplace): self
    {
        if ($this->workplaces->contains($workplace)) {
            $this->workplaces->removeElement($workplace);
            // set the owning side to null (unless already changed)
            if ($workplace->getAddress() === $this) {
                $workplace->setAddress(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->getName();
    }
}
