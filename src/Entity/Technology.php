<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechnologyRepository")
 */
class Technology
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $acquired;    

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inprogress;

    public function __construct()
    {
        $this->dateStart = new ArrayCollection();
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

    public function getAcquired(): ?bool
    {
        return $this->acquired;
    }

    public function setAcquired(?bool $acquired): self
    {
        $this->acquired = $acquired;

        return $this;
    }

    public function getInprogress(): ?bool
    {
        return $this->inprogress;
    }

    public function setInprogress(?bool $inprogress): self
    {
        $this->inprogress = $inprogress;

        return $this;
    }

    /**
     * @return Collection|Projects[]
     */
    public function getDateStart(): Collection
    {
        return $this->dateStart;
    }

    public function addDateStart(Projects $dateStart): self
    {
        if (!$this->dateStart->contains($dateStart)) {
            $this->dateStart[] = $dateStart;
            $dateStart->addTechnology($this);
        }

        return $this;
    }

    public function removeDateStart(Projects $dateStart): self
    {
        if ($this->dateStart->contains($dateStart)) {
            $this->dateStart->removeElement($dateStart);
            $dateStart->removeTechnology($this);
        }

        return $this;
    }    

    public function __toString(){
        return $this->getName();
    }
}
