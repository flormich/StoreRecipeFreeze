<?php

namespace App\Entity;

use App\Entity\Places;
use App\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantityGram;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantityUnit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dlc;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Places", mappedBy="stock")
     */
    private $places;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="stock")
     */
    private $id_product;

    public function __construct()
    {
        // $this->id_lieux = new ArrayCollection();
        $this->id_product = new ArrayCollection();
        // $this->places = new ArrayCollection();
        // $this->places = $places;
        // $this->commandeStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDlc(): ?string
    {
        return $this->dlc;
    }

    public function setDlc(?string $dlc): self
    {
        $this->dlc = $dlc;

        return $this;
    }
    
    public function getPlaces(): ?Places
    {
        return $this->places;
    }

    public function setPlaces(?Places $places): self
    {
        $this->places = $places;

        return $this;
    }

    // /**
    //  * @return Collection|Places[]
    //  */
    // public function getPlaces(): Places
    // {
    //     return $this->places;
    // }

    // public function addPlaces(Places $places): self
    // {
    //     if (!$this->places->contains($places)) {
    //         $this->places[] = $places;
    //         $places->setStock($this);
    //     }

    //     return $this;
    // }

    /**
     * @return Collection|Product[]
     */
    public function getIdProduct(): Collection
    {
        return $this->id_product;
    }

    public function addIdProduct(Product $idProduct): self
    {
        if (!$this->id_product->contains($idProduct)) {
            $this->id_product[] = $idProduct;
            $idProduct->setStock($this);
        }

        return $this;
    }

    public function removeIdProduct(Product $idProduct): self
    {
        if ($this->id_product->contains($idProduct)) {
            $this->id_product->removeElement($idProduct);
            // set the owning side to null (unless already changed)
            if ($idProduct->getStock() === $this) {
                $idProduct->setStock(null);
            }
        }

        return $this;
    }
}
