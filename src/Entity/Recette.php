<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecetteRepository")
 */
class Recette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantityGram;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantityUnit;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $timePrepa;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $timeCook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PictureRecette", cascade={"persist", "remove"})
     */
    private $id_PictureRecette;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryRecette")
     */
    private $CategoryRecette;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NumberPeople")
     */
    private $NumberPeople;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book")
     */
    private $Book;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page")
     */
    private $Page;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeRecette", mappedBy="id_Recette")
     */
    private $commandeRecettes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductRecette", mappedBy="id_Recette")
     */
    private $productRecettes;

    public function __construct()
    {
        $this->commandeRecettes = new ArrayCollection();
        $this->productRecettes = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getQuantityGram(): ?int
    {
        return $this->quantityGram;
    }

    public function setQuantityGram(?int $quantityGram): self
    {
        $this->quantityGram = $quantityGram;

        return $this;
    }

    public function getQuantityUnit(): ?int
    {
        return $this->quantityUnit;
    }

    public function setQuantityUnit(?int $quantityUnit): self
    {
        $this->quantityUnit = $quantityUnit;

        return $this;
    }

    public function getTimePrepa(): ?string
    {
        return $this->timePrepa;
    }

    public function setTimePrepa(?string $timePrepa): self
    {
        $this->timePrepa = $timePrepa;

        return $this;
    }

    public function getTimeCook(): ?string
    {
        return $this->timeCook;
    }

    public function setTimeCook(string $timeCook): self
    {
        $this->timeCook = $timeCook;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdPictureRecette(): ?PictureRecette
    {
        return $this->id_PictureRecette;
    }

    public function setIdPictureRecette(?PictureRecette $id_PictureRecette): self
    {
        $this->id_PictureRecette = $id_PictureRecette;

        return $this;
    }

    public function getCategoryRecette(): ?CategoryRecette
    {
        return $this->CategoryRecette;
    }

    public function setCategoryRecette(?CategoryRecette $CategoryRecette): self
    {
        $this->CategoryRecette = $CategoryRecette;

        return $this;
    }

    public function getNumberPeople(): ?NumberPeople
    {
        return $this->NumberPeople;
    }

    public function setNumberPeople(?NumberPeople $NumberPeople): self
    {
        $this->NumberPeople = $NumberPeople;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->Book;
    }

    public function setBook(?Book $Book): self
    {
        $this->Book = $Book;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->Page;
    }

    public function setPage(?Page $Page): self
    {
        $this->Page = $Page;

        return $this;
    }

    /**
     * @return Collection|CommandeRecette[]
     */
    public function getCommandeRecettes(): Collection
    {
        return $this->commandeRecettes;
    }

    public function addCommandeRecette(CommandeRecette $commandeRecette): self
    {
        if (!$this->commandeRecettes->contains($commandeRecette)) {
            $this->commandeRecettes[] = $commandeRecette;
            $commandeRecette->setIdRecette($this);
        }

        return $this;
    }

    public function removeCommandeRecette(CommandeRecette $commandeRecette): self
    {
        if ($this->commandeRecettes->contains($commandeRecette)) {
            $this->commandeRecettes->removeElement($commandeRecette);
            // set the owning side to null (unless already changed)
            if ($commandeRecette->getIdRecette() === $this) {
                $commandeRecette->setIdRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductRecette[]
     */
    public function getProductRecettes(): Collection
    {
        return $this->productRecettes;
    }

    public function addProductRecette(ProductRecette $productRecette): self
    {
        if (!$this->productRecettes->contains($productRecette)) {
            $this->productRecettes[] = $productRecette;
            $productRecette->setIdRecette($this);
        }

        return $this;
    }

    public function removeProductRecette(ProductRecette $productRecette): self
    {
        if ($this->productRecettes->contains($productRecette)) {
            $this->productRecettes->removeElement($productRecette);
            // set the owning side to null (unless already changed)
            if ($productRecette->getIdRecette() === $this) {
                $productRecette->setIdRecette(null);
            }
        }

        return $this;
    }
}
