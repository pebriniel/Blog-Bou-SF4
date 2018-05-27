<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $works;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hackathon;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $formation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Articles", mappedBy="Category")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(?Articles $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addCategory($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            $article->removeCategory($this);
        }

        return $this;
    }

    public function getWorks(): ?bool
    {
        return $this->works;
    }

    public function setWorks(?bool $works): self
    {
        $this->works = $works;

        return $this;
    }

    public function getHackathon(): ?bool
    {
        return $this->hackathon;
    }

    public function setHackathon(?bool $hackathon): self
    {
        $this->hackathon = $hackathon;

        return $this;
    }

    public function getFormation(): ?bool
    {
        return $this->formation;
    }

    public function setFormation(?bool $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function __toString() 
    {
        return $this->getName();
    }
}
